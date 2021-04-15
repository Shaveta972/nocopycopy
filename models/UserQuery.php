<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[UserEditProfile]].
 *
 * @see UserEditProfile
 */
class UserQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['state_id'=>UserEditProfile::STATE_PUBLISHED]);
    }

 	public function withDeleted()
    {
        return $this->andWhere(['isDeleted'=>[0,1]]);
    }


    /**
     * {@inheritdoc}
     * @return UserEditProfile[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return UserEditProfile|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
