<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[UserRecords]].
 *
 * @see UserRecords
 */
class UserRecordsQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['state_id'=>UserRecords::STATE_PUBLISHED]);
    }

 	public function withDeleted()
    {
        return $this->andWhere(['isDeleted'=>[0,1]]);
    }


    /**
     * {@inheritdoc}
     * @return UserRecords[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return UserRecords|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
