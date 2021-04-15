<?php

use kartik\form\ActiveForm;
use yii\authclient\widgets\AuthChoice;
use kartik\password\PasswordInput;
use yii\helpers\Html;
use yii\helpers\Url;
echo \yii2mod\alert\Alert::widget();
$this->title = \Yii::t('app', 'Signup');

?>
<div class="signup-page signup-blue">
    <div class="container h-100">
        <div class="row no-gutters h-100">
            <div class="col-md-8 h-100">
                <div class="h-100">

                    <div class="row align-items-center h-100">
                        <div class="col-md-6">
                            <div class="signup-text text-white">
                                <h6>Sign Up Now!</h6>
                                <h1>
                                    <strong> Authenticity,</strong> <span>Request Early Access.</span>
                                </h1>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <?php
                            $form = ActiveForm::begin(['options' => ['class' => 'form-sign']])
                            ?>
                            <div class="form-sign-inner">

                                <div class="theme-heading mb-3">
                                    <h5>Create Account</h5>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6 col-lg-6">
                                    <?php
                                    echo $form->field($model, 'first_name', ['options' => ['class' => ''],'template' => '{input}{error}'])->textInput([ 'placeholder' => 'First Name']) ?>
</div>
<div class="col-md-6 col-lg-6">

                                    <?php echo $form->field($model, 'last_name', [
                                        'options' => ['class' => ''],
                                        'template' => '{input}{hint}{error}'
                                    ])->textInput([
                                        'placeholder' => 'Last Name'
                                    ]) ?>
                                    </div>
                            
                                       <div class="col-12">
                                    <?= $form->field($model, 'email', ['options' => ['class' => ''],'template' => '{input}{hint}{error}'])->textInput(['placeholder' => 'Email']) ?>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                    <?= $form->field($model, 'password', ['options' => ['class' => ''],'template' => '{input}{hint}{error}',])->widget(PasswordInput::classname(), ['pluginOptions' => ['showMeter' => false,'toggleMask' => false,]])->passwordInput(['placeholder' => 'Password']); ?>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                    <?php echo $form->field($model, 'confirmPassword', ['options' => [ 'class' => ''],'template' => '{input}{hint}{error}' ])->widget(PasswordInput::classname(), [
                                        'pluginOptions' => [
                                            'showMeter' => false,
                                            'toggleMask' => false,

                                        ],
                                    ])->passwordInput([
                                        'placeholder' => 'Confirm Password'
                                    ]) ?>
                                    </div>
                                  
                                    <?php
                                    if (!empty($referal_code)) {
                                        echo '<div class="col-12">';
                                         echo $form->field($model, 'is_subadmin', ['options' => ['class' => 'form-group col-md-12'], 
                                        'template' => '{input}{hint}{error}'])->dropDownList([
                                        '1' => 'Lecturer/Teacher', 
                                        '2' => 'Student Admin' , 
                                        '3' => 'Company Staff'],['prompt'=>'Select Role']);
echo '</div>';
                                        echo $form->field($model, 'user_category_id')->hiddenInput(['value' => 0])->label(false);
                                    } 
                                    
                                    
                                    
                                    else {
                                        echo '<div class="col-12">';
                                        echo $form->field($model, 'user_category_id', ['options' => ['class' => 'form-group col-md-12 user_categories'], 'template' => '{input}{hint}{error}'])->dropDownList(
                                            $listData,
                                            ['prompt' => 'Select Role']
                                        );
                                        echo '</div>';
                                        echo '<div class="col-12">';
                                        echo $form->field($model, 'school_name', [
                                            'options' => [
                                                'class' => 'form-group col-md-12',
                                                'id' => 'education_input'
                                            ],
                                            'template' => '{input}{hint}{error}'
                                        ])->textInput([
                                            'placeholder' => 'School Name'
                                        ]);
                                        echo '</div>';

                                        echo '<div class="col-12">';
                                        echo $form->field($model, 'business_name', [
                                            'options' => [
                                                'class' => 'form-group col-md-12',
                                                'id' => 'business_input'
                                            ],
                                            'template' => '{input}{hint}{error}'
                                        ])->textInput([
                                            'placeholder' => 'Business Name'
                                        ]);
                                        echo '</div>';

                                    }
                                    ?>
                                    <?php //echo $form->field($model, 'referal_code')->hiddenInput(['value' => $referal_code])->label(false); ?>
                                </div>
                                <!-- <div class="form-group">
                                    <?php
                                  //  echo $form->field($model, 'acordul_tc', ['options' => ['tag' => 'span'], 'template' => "{input}"])->checkbox([
                                     //  'label' => 'I agree to the <a href="/web/site/terms" target="_blank">Terms and Conditions</a>', 'class' => 'register-link-color', 'checked' => false
                                //    ]);
                                    ?>
                                </div> -->
                                <div class="form-sign-button pt-1 pb-1">
                                    <button type="submit" class="btn-main w-100">Create an Account</button>
                                </div>
                                 <?php if (empty($referal_code)) { ?>
                                <?php $authAuthChoice = AuthChoice::begin([
                                    'baseAuthUrl' => ['site/auth'],
                                    'popupMode' => false
                                ]);
                                ?>
                                <ul class="social-buttons d-flex justify-content-center mb-0">
                                    <?php foreach ($authAuthChoice->getClients() as $client) : ?>
                                        <li><?= $authAuthChoice->clientLink($client) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php AuthChoice::end(); ?>
                                
                                <?php } ?>
                                <div class="row">
                          <div class="col-12"><div class="signupagree mt-0 text-center">By continuing, you agree to our <a href="#">Terms and Conditions</a> and <a href="#">Privacy Policy.</a></div></div>
                      </div>
                                <div class="register-div  mt-2  d-flex justify-content-center">Already Registered?
                                    <?= Html::a('Login now', ['site/login'], ['class' => 'text-underline text-bgray register-link-color ml-1']) ?>
                                </div>
                            </div>
                            <?php ActiveForm::end() ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 position-img">
                <div class="signup-img">
                    <?php echo Html::img('@web/themes/frontend/images/sign-img.jpg', ['alt' => "sign-up"]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
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
              $('#education_input').val('');
             }
             else if(response.category_type == 'Education'){
                $('#business_input').css('display','none');
                $('#business_input').val('');
                $('#education_input').css('display','block');
               }
               else{
                $('#business_input').css('display','none');
                $('#education_input').css('display','none');
                $('#business_input').val('');
                $('#education_input').val('');
               }
          
         }
       });
      });
  });") ?>

<style>
    #education_input,
    #business_input {
        display: none;
    }
</style>