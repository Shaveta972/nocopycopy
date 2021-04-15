<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
namespace app\generators\crud;

use Yii;
use yii\helpers\Inflector;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\db\Schema;

/**
 * Generates CRUD
 *
 * @property array $columnNames Model column names. This property is read-only.
 * @property string $controllerID The controller ID (without the module ID prefix). This property is
 *           read-only.
 * @property string $nameAttribute This property is read-only.
 * @property array $searchAttributes Searchable attributes. This property is read-only.
 * @property bool|\yii\db\TableSchema $tableSchema This property is read-only.
 * @property string $viewPath The controller view path. This property is read-only.
 *          
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Generator extends \yii\gii\generators\crud\Generator {
	public $baseControllerClass = 'app\modules\admin\controllers\BaseController';
	
	public function getVariablesToSkip(){
		return ['create_user_id','created_at','created_by','updated_at','isDeleted','deleted_at'];
	}
	
	/**
	 * Generates code for active field
	 * 
	 * @param string $attribute        	
	 * @return string
	 */
	public function generateActiveField($attribute) {
		$tableSchema = $this->getTableSchema ();
		if ($tableSchema === false || ! isset ( $tableSchema->columns [$attribute] )) {
			if (preg_match ( '/^(password|pass|passwd|passcode)$/i', $attribute )) {
				return "\$form->field(\$model, '$attribute')->passwordInput()";
			}
			
			return "\$form->field(\$model, '$attribute')";
		}
		$column = $tableSchema->columns [$attribute];
		if ($column->phpType === 'boolean') {
			return "\$form->field(\$model, '$attribute')->checkbox()";
		}
		
		if ($column->name=== 'state_id') {
			return "\$form->field(\$model, '$attribute')->dropDownList(\$model->getStateOptions())";
		}
		
		if ($column->type === 'text') {
			return "\$form->field(\$model, '$attribute')->textarea(['rows' => 6])";
		}
		
		if (preg_match ( '/^(password|pass|passwd|passcode)$/i', $column->name )) {
			$input = 'passwordInput';
		} else {
			$input = 'textInput';
		}
		
		if (is_array ( $column->enumValues ) && count ( $column->enumValues ) > 0) {
			$dropDownOptions = [ ];
			foreach ( $column->enumValues as $enumValue ) {
				$dropDownOptions [$enumValue] = Inflector::humanize ( $enumValue );
			}
			return "\$form->field(\$model, '$attribute')->dropDownList(" . preg_replace ( "/\n\s*/", ' ', VarDumper::export ( $dropDownOptions ) ) . ", ['prompt' => ''])";
		}
		
		if ($column->phpType !== 'string' || $column->size === null) {
			return "\$form->field(\$model, '$attribute')->$input()";
		}
		
		return "\$form->field(\$model, '$attribute')->$input(['maxlength' => true])";
	}
	
	
	/**
	 * @return string the controller view path
	 */
	public function getViewPath()
	{
		if (empty($this->viewPath)) {
			return Yii::getAlias('@app/modules/admin/views/' . $this->getControllerID());
		}
		
		return Yii::getAlias(str_replace('\\', '/', $this->viewPath));
	}
	
	
	/**
	 * Generates column format
	 * @param \yii\db\ColumnSchema $column
	 * @return string
	 */
	public function generateColumnFormat($column)
	{
		if ($column->phpType === 'boolean') {
			return 'boolean';
		}
		
		if ($column->type === 'text') {
			return 'ntext';
		}
		
		if (stripos($column->name, 'time') !== false && $column->phpType === 'integer') {
			return 'datetime';
		}
		
		if ($column->name === 'created_at' || $column->name === 'updated_at') {
			return 'datetime';
		}
		
		if (stripos($column->name, 'email') !== false) {
			return 'email';
		}
		
		if (preg_match('/(\b|[_-])url(\b|[_-])/i', $column->name)) {
			return 'url';
		}
		
		return 'text';
	}
	
	
	
	/**
	 * Generates validation rules for the search model.
	 * @return array the generated validation rules
	 */
	public function generateSearchRules()
	{
		if (($table = $this->getTableSchema()) === false) {
			return ["[['" . implode("', '", $this->getColumnNames()) . "'], 'safe']"];
		}
		$types = [];
		
		$variablesToSkip = $this->getVariablesToSkip();
		
		foreach ($table->columns as $column) {
			
			if(in_array($column->name, $variablesToSkip)){
				continue;
			}
			
			switch ($column->type) {
				case Schema::TYPE_TINYINT:
				case Schema::TYPE_SMALLINT:
				case Schema::TYPE_INTEGER:
				case Schema::TYPE_BIGINT:
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
				default:
					$types['safe'][] = $column->name;
					break;
			}
		}
		
		$rules = [];
		foreach ($types as $type => $columns) {
			$rules[] = "[['" . implode("', '", $columns) . "'], '$type']";
		}
		
		return $rules;
	}
	
	
	/**
	 * Generates code for active search field
	 * 
	 * @param string $attribute        	
	 * @return string
	 */
	public function generateActiveSearchField($attribute) {
		$tableSchema = $this->getTableSchema ();
		if ($tableSchema === false) {
			return "\$form->field(\$model, '$attribute')";
		}
		
		$column = $tableSchema->columns [$attribute];
		if ($column->phpType === 'boolean') {
			return "\$form->field(\$model, '$attribute')->checkbox()";
		}
		
		return "\$form->field(\$model, '$attribute')";
	}
	
	
	/**
	 * Generates the attribute labels for the search model.
	 * 
	 * @return array the generated attribute labels (name => label)
	 */
	public function generateSearchLabels() {
		/* @var $model \yii\base\Model */
		$model = new $this->modelClass ();
		$attributeLabels = $model->attributeLabels ();
		$labels = [ ];
		foreach ( $this->getColumnNames () as $name ) {
			if (isset ( $attributeLabels [$name] )) {
				$labels [$name] = $attributeLabels [$name];
			} else {
				if (! strcasecmp ( $name, 'id' )) {
					$labels [$name] = 'ID';
				} else {
					$label = Inflector::camel2words ( $name );
					if (! empty ( $label ) && substr_compare ( $label, ' id', - 3, 3, true ) === 0) {
						$label = substr ( $label, 0, - 3 );
					}
					$labels [$name] = $label;
				}
			}
		}
		
		return $labels;
	}
}
