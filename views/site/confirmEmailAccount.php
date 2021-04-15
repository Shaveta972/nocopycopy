<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Email Confirm';
?>
<div class="site-error plans mt-5">
<div class="container">
<div class="col-md-8">
   
    <div class="alert alert-success">
    Your profile is under review, We will send you email once it is approved by administrator. Thank your for your patience.
    </div>
    <p>
		<a href="<?php echo Url::to(['/']); ?>">Go to Home </a>
    </p>
	</div>
</div>
</div>
