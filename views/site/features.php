<?php
use yii\bootstrap4\ActiveForm;
use yii\bootstrap\Html;

$this->title = \Yii::t('app', 'Features');
?>

<div class="container">
    <section class="my-5 custom-features-section">

        <div class="theme-heading">
            <h1>Why Use NoCopyCopy</h1>
            <p>NoCopyCopy provides a broad spectrum of web platform services and mobile application which <br>
verifies the authenticity of documents and digitization solution services for organization  <br>
            </p>
          </div>

        <!-- Grid row -->
        <div class="row align-items-center">
            <div class="col-lg-5 text-center text-lg-left">
                <div class="iphone">
                    <?php echo Html::img('@web/themes/frontend/images/iphone.png', ['alt' => "iphone", 'class' => "img-fluid"]) ?>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="features-list my-5">
                    <!-- Grid row -->
                    <div class="row mb-3">
                        <div class="col-1">
                            <div class="feature-icon">
                                <i class="fas fa-share fa-lg"></i>
                            </div>
                        </div>
                        <div class="col-xl-10 col-md-11 col-10">
                            <div class="content">
                                <h3 class="mb-3">Plagiarism Checking</h3>
                                <p class="grey-text">NoCopyCopy helps to provide proper referencing and plagiarism checking of intellectual work to students, lecturers, bloggers, executives and individuals while also prevents plagiarisation of intellectual property across Universities and Institutions in Nigeria and West Africa</p>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-1">
                            <div class="feature-icon">
                                <i class="fas fa-share fa-lg"></i>
                            </div>
                        </div>
                        <div class="col-xl-10 col-md-11 col-10">
                            <div class="content">
                                <h3 class="mb-3">Digitization Services</h3>
                                <p class="grey-text">NoCopyCopy offers custom end-to-end solutions for your digitization projects. And also saddled with the responsibility of preserving materials in digital format which are heavily reliant on research, development and problem solving</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-1">
                            <div class="feature-icon">
                                <i class="fas fa-share fa-lg"></i>
                            </div>
                        </div>
                        <div class="col-xl-10 col-md-11 col-10">
                            <div class="content">
                                <h3 class="mb-3">Edtech Solutions</h3>
                                <p class="grey-text">NoCopyCopy provides a bouquet of EdTech solutions which includes; Digital Library, Mobile Learning and Digital Content Creation</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Grid row-->
            </div>
            <!--Grid column-->
        </div>
        <!-- Grid row -->
    </section>
</div>
