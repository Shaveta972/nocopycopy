<?php

namespace app\generators\model;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Schema;
use yii\db\TableSchema;
use yii\helpers\Inflector;

/**
 * This generator will generate one or multiple ActiveRecord classes for the specified database table.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Generator extends \yii\gii\generators\model\Generator {
	public $baseClass = "app\models\BaseActiveRecord";
	public $generateQuery = true;
	public $queryNs = 'app\models\query';
	/**
	 * Generates the attribute labels for the specified table.
	 *
	 * @param \yii\db\TableSchema $table
	 *        	the table schema
	 * @return array the generated attribute labels (name => label)
	 */
	public function generateLabels($table) {
		$labels = [ ];
		foreach ( $table->columns as $column ) {
			if ($this->generateLabelsFromComments && ! empty ( $column->comment )) {
				$labels [$column->name] = $column->comment;
			} elseif (! strcasecmp ( $column->name, 'id' )) {
				$labels [$column->name] = 'ID';
			} elseif (! strcasecmp ( $column->name, 'created_by' )) {
				$labels [$column->name] = 'Created By';
			} elseif (! strcasecmp ( $column->name, 'created_at' )) {
				$labels [$column->name] = 'Created On';
			} elseif (! strcasecmp ( $column->name, 'updated_at' )) {
				$labels [$column->name] = 'Updated On';
			} else {
				$label = Inflector::camel2words ( $column->name );
				if (! empty ( $label ) && substr_compare ( $label, ' id', - 3, 3, true ) === 0) {
					$label = substr ( $label, 0, - 3 );
				}
				$labels [$column->name] = $label;
			}
		}
		
		return $labels;
	}
	
	
	public function getVariablesToSkip(){
		return ['created_at','updated_at','isDeleted','deleted_at'];
	}
	
	
	/**
	 * Generates validation rules for the specified table.
	 * @param \yii\db\TableSchema $table the table schema
	 * @return array the generated validation rules
	 */
	public function generateRules($table)
	{
		$types = [];
		$lengths = [];
		
		$variablesToSkip = $this->getVariablesToSkip();
		
		foreach ($table->columns as $column) {
			if ($column->autoIncrement) {
				continue;
			}
			
			if(in_array($column->name, $variablesToSkip)){
				continue;
			}
			
			if (!$column->allowNull && $column->defaultValue === null) {
				$types['required'][] = $column->name;
			}
			switch ($column->type) {
				case Schema::TYPE_SMALLINT:
				case Schema::TYPE_INTEGER:
				case Schema::TYPE_BIGINT:
				case Schema::TYPE_TINYINT:
					$types['integer'][] = $column->name;
					break;
				case Schema::TYPE_BOOLEAN:
					$types['boolean'][] = $column->name;
					break;
				case Schema::TYPE_FLOAT:
				case Schema::TYPE_DOUBLE:
				case Schema::TYPE_DECIMAL:
				case Schema::TYPE_MONEY:
					$types['number'][] = $column->name;
					break;
				case Schema::TYPE_DATE:
				case Schema::TYPE_TIME:
				case Schema::TYPE_DATETIME:
				case Schema::TYPE_TIMESTAMP:
				case Schema::TYPE_JSON:
					$types['safe'][] = $column->name;
					break;
				default: // strings
					if ($column->size > 0) {
						$lengths[$column->size][] = $column->name;
					} else {
						$types['string'][] = $column->name;
					}
			}
		}
		$rules = [];
		$driverName = $this->getDbDriverName();
		foreach ($types as $type => $columns) {
			if ($driverName === 'pgsql' && $type === 'integer') {
				$rules[] = "[['" . implode("', '", $columns) . "'], 'default', 'value' => null]";
			}
			$rules[] = "[['" . implode("', '", $columns) . "'], '$type']";
		}
		foreach ($lengths as $length => $columns) {
			$rules[] = "[['" . implode("', '", $columns) . "'], 'string', 'max' => $length]";
		}
		
		$db = $this->getDbConnection();
		
		// Unique indexes rules
		try {
			$uniqueIndexes = array_merge($db->getSchema()->findUniqueIndexes($table), [$table->primaryKey]);
			$uniqueIndexes = array_unique($uniqueIndexes, SORT_REGULAR);
			foreach ($uniqueIndexes as $uniqueColumns) {
				// Avoid validating auto incremental columns
				if (!$this->isColumnAutoIncremental($table, $uniqueColumns)) {
					$attributesCount = count($uniqueColumns);
					
					if ($attributesCount === 1) {
						$rules[] = "[['" . $uniqueColumns[0] . "'], 'unique']";
					} elseif ($attributesCount > 1) {
						$columnsList = implode("', '", $uniqueColumns);
						$rules[] = "[['$columnsList'], 'unique', 'targetAttribute' => ['$columnsList']]";
					}
				}
			}
		} catch (NotSupportedException $e) {
			// doesn't support unique indexes information...do nothing
		}
		
		// Exist rules for foreign keys
		foreach ($table->foreignKeys as $refs) {
			$refTable = $refs[0];
			$refTableSchema = $db->getTableSchema($refTable);
			if ($refTableSchema === null) {
				// Foreign key could point to non-existing table: https://github.com/yiisoft/yii2-gii/issues/34
				continue;
			}
			$refClassName = $this->generateClassName($refTable);
			unset($refs[0]);
			$attributes = implode("', '", array_keys($refs));
			$targetAttributes = [];
			foreach ($refs as $key => $value) {
				$targetAttributes[] = "'$key' => '$value'";
			}
			$targetAttributes = implode(', ', $targetAttributes);
			$rules[] = "[['$attributes'], 'exist', 'skipOnError' => true, 'targetClass' => $refClassName::className(), 'targetAttribute' => [$targetAttributes]]";
		}
		
		return $rules;
	}
	
	
}
