<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\User;
/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="file-scan-form">
    <?php

$form = ActiveForm::begin([
        'options' => [
            'id' => 'filem',
            'enctype' => 'multipart/form-data'
        ]
    ])?>
        <?php 
    if (Yii::$app->user->identity->is_subadmin ==  User::STUDENT_SUBADMIN) {
        echo $form->field($model, 'subject_code')->textInput()->label('Assignment Code');
    }
    ?>
    <div class="file-field">
		<div class="z-depth-1-half mb-4">
			<img src="https://mdbootstrap.com/img/Photos/Others/placeholder.jpg"
				class="img-fluid" alt="example placeholder">
		</div>
		<div class="btn btn-mdb-color btn-rounded">
            <?php echo $form->field($model, 'file', ['options' => ['class' => 'form-group'], 'template' => '{input}{hint}'])->fileInput(); ?>
        </div>
        <?php echo $form->field($model, 'process_type')->hiddenInput(['value'=> 'file'])->label(false); ?>
    </div>
    <?php ActiveForm::end(); ?>

    <div class="form-group d-flex justify-content-center">
        <?=Html::submitButton(Yii::t('app', 'Scan'), ['class' => 'sbu btn btn-main']); ?>
    </div>

</div>
<?php
$action_url= Url::to(['scan/process-file']);
$user_id=Yii::$app->user->getId();
$redirect= Url::to(['user/dashboard/'.$user_id ]);
echo $this->registerJs('$(document).ready(function (e) {
    $(".sbu").on("click",(function(e) {
     e.preventDefault();
        $("body").loadingModal({
            position: "auto",
            text:"",
            color: "#fff",
            opacity: "0.7",
            backgroundColor: "rgb(0,0,0)",
            animation: "doubleBounce"
          });

     $.ajax({
          url: "'.$action_url.'",
          type: "POST",
          data:  new FormData($("#filem")[0]),
          contentType: false,
          cache: false,
          processData:false,
          success: function(response)
             {
                if(response.data.id != "0"){
                    Swal.fire({
                        title: "Success!",
                        type: "success",
                        text: "Your NoCopyCopy scan request has been submitted. Please wait for a while. The results will be dispalyed shortly",
                        showCancelButton: false,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Continue"
                      }).then((result) => {
                        if (result.value) {
                            window.location.href= "'.$redirect.'";
                        }
                      });
    
                }else{
                    Swal.fire({
                        title: "Error!",
                        type: "error",
                        text: response.data.message
                       });
                    }
            }       
       }).done(function() {
               $("body").loadingModal("hide");
	  });
    }));
   });')?>