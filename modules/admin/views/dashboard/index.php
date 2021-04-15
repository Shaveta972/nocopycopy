<?php
use app\widgets\PageHeader;
use yii\helpers\Url;
use app\widgets\GridView;

$this->title = \Yii::t ( 'app', 'Dashboard' );
$this->params ['breadcrumbs'] [] = 'Index';
?>
<!-- Content Header (Page header) -->
<?php
echo PageHeader::widget ( [ 
		'title' => $this->title,
		'subtitle' => \Yii::t ( 'app', 'Control Panel' ) 
] )?>


	<!-- Small boxes (Stat box) -->
	<div class="row">
		
		<div class="col-lg-12 col-xs-6">
			<!-- small box -->
			<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Latest Users</h3>

              <div class="box-tools pull-right">
			  <a href="<?php echo Url::to(['/admin/user/'], $schema = true) ?>" class="btn btn-sm btn-info btn-flat pull-left">View All Users</a>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

			<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
		[
			'class' => 'yii\grid\SerialColumn'
		],
		'first_name',
		'email',
		'title',
		'contact_number',
		[
			'attribute' => 'state_id',
			'class' => '\dixonstarter\togglecolumn\ToggleColumn'
		],
        'created_at:datetime',
        // ...
    ],
]) ?>
             
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <!-- <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a> -->
           
            </div>
            <!-- /.box-footer -->
          </div>
		</div>

	</div>
	<!-- /.row -->

