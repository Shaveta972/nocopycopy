<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[UserPlans]].
 *
 * @see UserPlans
 */
class UserPlansQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['state_id'=>UserPlans::STATE_PUBLISHED]);
    }

 	public function withDeleted()
    {
        return $this->andWhere(['isDeleted'=>[0,1]]);
    }


    /**
     * {@inheritdoc}
     * @return UserPlans[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return UserPlans|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
