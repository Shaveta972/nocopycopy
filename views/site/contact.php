<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

$this->title = \Yii::t('app', 'Contact Us');
?>
<div class="container">
<div class=" contact_us">




      
      <section class="getontouch-section my-5 custom-features-section">
          <div class="theme-heading">

      <h1>GET IN TOUCH WITH US</h1>
</div>
          <div class="container">
              <div class="row justify-content-center">
                  <div class="col-xl-5 col-lg-6">
                      <div class="contactus--detail">
                          <div class="contactus--detail__row">
                        
                              <i>  <?php echo Html::img('@web/themes/frontend/new_images/phone.svg', ['alt' => "call"]); ?></i>
                              <div class="contactus--detail__col">
                                  <h5>Call us on</h5>
                                  <a href="#">+01 783 4238 346</a>
                                  <a href="#">+01 975 3463 342</a>
                              </div>
                          </div>
                          <div class="contactus--detail__row">
                              <i>  <?php echo Html::img('@web/themes/frontend/new_images/email.svg', ['alt' => "email"]); ?>
                                  </i>
                              <div class="contactus--detail__col">
                                  <h5>Leave a message</h5>
                                  <a href="#">support@nocopycopy.ng</a>
                                  <a href="#">sale@gmail.com</a>
                              </div>
                          </div>
                          <div class="contactus--detail__row">
                              <i>  <?php echo Html::img('@web/themes/frontend/new_images/location.svg', ['alt' => "location"]); ?>
                                  </i>
                              <div class="contactus--detail__col">
                                  <h5>Address</h5>
                                  <p>14 Lateef Jakande Rd<br>
                                  Agidingbi, Ikeja, Nigeria.
                                  </p>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-xl-5 col-lg-6">
                      <div class="contact-form_card">
                          <h5>Please leave a message and we will contact you soon</h5>
                          <?php $form = ActiveForm::begin(['options' => ['class' => 'row g-3', 'enctype' => 'multipart/form-data']]) ?>
      
               <?= $form->field($model, 'first_name', ['options' => ['class' =>'col-12 position-relative']])
                            ->textInput([
                                'placeholder' =>'Enter First Name',
                                'class' => ''
                            ])->label(false);
                            ?>
                            
                          <?= $form->field($model, 'last_name', ['options' => ['class' =>'col-12 position-relative']])
                            ->textInput([
                                'placeholder' => 'Enter LastName',
                                'class' => ''
                            ])->label(false);
                            ?>
                              <?= $form->field($model, 'email', ['options' => ['class' =>'col-12 position-relative']])
                            ->textInput([
                                'placeholder' => 'Enter EmailAdress',
                                'class' => ''
                            ])->label(false);
                            ?>
                                 <?= $form->field($model, 'phone_number', ['options' => ['class' =>'col-12 position-relative']])
                            ->textInput([
                                'placeholder' => 'Enter Phone Number',
                                'class' => ''
                            ])->label(false);
                            ?>
                             
                              <div class="col-12 position-relative">
                                  <textarea type="text" rows="5" class="form-control " id="" placeholder="Enter Message"></textarea>
                              </div>
                          
                              <div class="col-12 text-center">
                              <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-blue px-md-5 btn-rounded']) ?>
                              </div>
                              <?php ActiveForm::end() ?>
                      </div>
                  </div>
              </div>
          </div>
      </section>
      


      </div>

<!-- Section: Contact v.1 -->
  </div>

