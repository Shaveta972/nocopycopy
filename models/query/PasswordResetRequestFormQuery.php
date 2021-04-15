<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[PasswordResetRequestForm]].
 *
 * @see PasswordResetRequestForm
 */
class PasswordResetRequestFormQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['state_id'=>PasswordResetRequestForm::STATE_PUBLISHED]);
    }

 	public function withDeleted()
    {
        return $this->andWhere(['isDeleted'=>[0,1]]);
    }


    /**
     * {@inheritdoc}
     * @return PasswordResetRequestForm[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PasswordResetRequestForm|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
