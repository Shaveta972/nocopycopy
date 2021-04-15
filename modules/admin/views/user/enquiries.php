<?php
use app\widgets\GridView;
use app\widgets\PageHeader;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Enquiries List');
$this->params['breadcrumbs'][] = $this->title;
?>
<?= PageHeader::widget(['title' => $this->title]) ?>
<div class="user-index box box-primary">
    <?php 
    ?>
   
    <div class="box-body">
        <?php
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            // 'filterModel' => $searchModel,
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn'
                ],
                'first_name',
                'last_name',
                'email:email',
                'phone_number',
                'message',
                'created_at:datetime'
            ]
        ]);
        ?>
    </div>
</div>