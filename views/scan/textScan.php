<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="text-scan-form">
    <?php

    $form = \yii\widgets\ActiveForm::begin([
        'id' => 'text-scan-form',
        'action' => Url::to([
            'scan/ajax-send-request'
        ]),
        'enableAjaxValidation' => false
    ]);
    ?>
    <?php 

    if (Yii::$app->user->identity->is_subadmin ===  User::STUDENT_SUBADMIN) {
        echo $form->field($model, 'subject_code')->textInput()->label('Assignment Code');
    }
    ?>
    <?php
    echo $form->field($model, 'process_value', [
        'options' => [
            'class' => 'form-group'
        ],
        'template' => '{input}{hint}{error}'
    ])->textarea([
        'placeholder' => 'Enter Text',
        'rows' => '12'
    ]);
    ?>
    <?php echo $form->field($model, 'process_type')->hiddenInput(['value' => 'text'])->label(false); ?>
    <div class="form-group d-flex justify-content-center">
        <?= Html::submitButton(Yii::t('app', 'Scan'), ['class' => 'btn btn-main']); ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
$user_id = Yii::$app->user->getId();
$redirect = Url::to(['user/dashboard/' . $user_id]);

echo $this->registerJs("$(document).ready(function($) {
	$('body').on('beforeSubmit', 'form#text-scan-form', function (e) {
       e.preventDefault();
	   var form = $(this);
       var formData = form.serialize();
       $('body').loadingModal({
        position: 'auto',
        text: '',
        color: '#fff',
        opacity: '0.7',
        backgroundColor: 'rgb(0,0,0)',
        animation: 'doubleBounce'
      });
	  $.ajax({
			url: form.attr('action'),
			type: 'post',
			data: formData,
			dataType : 'json',
			success: function (response, status, xhr) {
                if(response.data.id != '0'){
                    $('#modalScan').modal('hide');
                    Swal.fire({
                        title: 'Success!',
                        type: 'success',
                        text: 'Your scan request has been submitted. Please wait for a while. The results will be dispalyed shortly',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Continue'
                      }).then((result) => {
                        if (result.value) {
                            window.location.href= '$redirect';
                        }
                      });
    
                }else{
                    Swal.fire({
                        title: 'Error!',
                        type: 'error',
                        text: response.data.message
                       });
                }
            },
        }).done(function() {
               $('body').loadingModal('hide');

	  });
	  
	  return false;
      })
    });
    ") ?>