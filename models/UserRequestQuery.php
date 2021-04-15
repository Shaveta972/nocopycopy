<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[UserRequest]].
 *
 * @see UserRequest
 */
class UserRequestQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['state_id'=>UserRequest::STATE_PUBLISHED]);
    }

 	public function withDeleted()
    {
        return $this->andWhere(['isDeleted'=>[0,1]]);
    }


    /**
     * {@inheritdoc}
     * @return UserRequest[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return UserRequest|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
