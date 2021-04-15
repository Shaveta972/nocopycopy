<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Payment Confirm';
?>
<div class="payment-confirm dashboard">
    <div class="container">
        <div class="jumbotron text-xs-center bg-transparent">
            <div class="d-flex justify-content-center">
                <i class="fa fa-thumbs-o-up fa-5x text-success text-center"></i>
            </div>
            <div class="d-flex justify-content-center mt-3 mb-3">
                <h1 class="display-3">Thank You!</h1>
            </div>
            <p class="lead align-center text-center"><strong>Payment Successful</strong></p>
            <hr>
            <!-- <p>
    Having trouble? <a href="">Contact us</a>
  </p> -->
            <div class="d-flex justify-content-center">
                <p class="lead">
                    <a class="btn btn-blue btn-sm" href="<?php echo Url::to(['/']); ?>" role="button">Continue to homepage</a>
                </p>
            </div>
        </div>



    </div>
</div>