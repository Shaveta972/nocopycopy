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
      <div class="modal" id="myModal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Additional Information</h4>
            </div>
            <?php $form = ActiveForm::begin(['options' => ['class' => 'data-sign']]); ?>
            <!-- Modal body -->
            <div class="modal-body">

         
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
      </div>
  </div>
</div>
<?php
$script = <<< JS
window.addEventListener('load', show());
function show(){
  $('#myModal').modal('show');
}
JS;
$this->registerJs($script);
?>