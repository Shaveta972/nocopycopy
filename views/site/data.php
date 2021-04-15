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
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Please Select Role</h4>
        <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
      </div>
      <?php $form = ActiveForm::begin(['options' => ['class' => 'data-sign']]); ?>
      <!-- Modal body -->
      <div class="modal-body">
    
      <?php
       echo $form->field($model, 'user_category_id', ['options' => ['class' => 'form-group col-md-12 mb-0 user_categories'], 'template' => '{input}{hint}{error}'])->dropDownList(
                                            $listData,['prompt'=>'Select Role']
       ); ?>
  
      <?php
      echo $form->field($model, 'school_name', [
                                            'options' => [
                                                'class' => 'form-group col-md-12 mb-0',
                                                'id' => 'education_input'
                                            ],
                                            'template' => '{input}{hint}{error}'
                                        ])->textInput([
                                            'placeholder' => 'School Name'
                                        ]);  
                                        echo $form->field($model, 'business_name', [
                                            'options' => [
                                                'class' => 'form-group col-md-12 mb-0',
                                                'id' =>'business_input'
                                            ],
                                            'template' => '{input}{hint}{error}'
                                        ])->textInput([
                                            'placeholder' => 'Business Name'
                                        ]);   
                                        ?>
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

echo $this->registerJs("$(function() {
    $('.user_categories').change(function() {
        var selectedValue = $(this).find('option:selected').val();
        $.ajax({
         url: 'categories',
         type: 'post',
         data: {id : selectedValue},
         success: function(response){
             if(response.category_type == 'Business'){
              $('#business_input').css('display','block');
              $('#education_input').css('display','none');
             }
             else if(response.category_type == 'Education'){
                $('#business_input').css('display','none');
                $('#education_input').css('display','block');
               }
               else{
                $('#business_input').css('display','none');
                $('#education_input').css('display','none');
               }
          
         }
       });
      });
    });") ?>

<style>
    #education_input, #business_input{
        display: none;
    }
    </style>