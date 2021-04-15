<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii2tech\ar\softdelete\SoftDeleteBehavior;

class BaseActiveRecord extends ActiveRecord {
	public function behaviors() {
		return [ 
				[ 
						'class' => TimestampBehavior::className (),
						'createdAtAttribute' => 'created_at',
						'updatedAtAttribute' => 'updated_at' 
				],
				'softDeleteBehavior' => [ 
						'class' => SoftDeleteBehavior::className (),
						'softDeleteAttributeValues' => [ 
								'isDeleted' => 1 
						] 
				] 
		];
	}
	
	
	public function beforeSoftDelete()
	{
		$this->deleted_at = time(); // log the deletion date
		return true;
	}
	
	
	public function beforeValidate() {
		if ($this->isNewRecord && (\Yii::$app instanceof \yii\web\Application)) {
			$this->created_by = \Yii::$app->user->id;
		}
		return parent::beforeValidate ();
	}
}
