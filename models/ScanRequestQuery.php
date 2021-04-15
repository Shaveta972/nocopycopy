<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ScanRequest]].
 *
 * @see ScanRequest
 */
class ScanRequestQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['state_id'=>ScanRequest::STATE_PUBLISHED]);
    }

 	public function withDeleted()
    {
        return $this->andWhere(['isDeleted'=>[0,1]]);
    }


    /**
     * {@inheritdoc}
     * @return ScanRequest[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ScanRequest|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
