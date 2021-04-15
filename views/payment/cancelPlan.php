<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
?>
<div class="site-data plans">
<div class="container">
<div class="col-md-8">
<div class="modal inmodal" id="modalCancelPlan" tabindex="-1" role="dialog" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <h4 class="modal-title text-blue">Start your scan</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <div id='modalContent'></div>
            </div>            
        </div>
    </div>
</div>
<?php $form = ActiveForm::begin(['options' => ['id' => 'cancel-plan']]); ?>
      <!-- Modal body -->
     
      <div class="modal-body">
				<p>Do you really want to cancel this plan? This process cannot be undone.</p>
     
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
      <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-main mr-2']) ?>
        <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
      </div>
      <?php ActiveForm::end(); ?>

</div>

</div>
</div>

