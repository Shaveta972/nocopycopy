<?php

namespace app\models;

use Yii;

class RoleSelectForm extends \app\models\BaseActiveRecord
{
    public $user_category_id;
    public $school_name;
    public $business_name;
    public $is_subadmin;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // ['role', 'trim'],
            // ['title', 'required' , 'message' => 'Please enter your designation.', 'on' =>'additional' ],
            ['is_subadmin', 'required' , 'message' => 'Please select a role.', 'on' =>'additional' ],
            ['user_category_id', 'required' , 'message' => 'Please select a role.' ],
            ['school_name','safe'],
            ['business_name','safe'],
             
          
        ];
    }
}


