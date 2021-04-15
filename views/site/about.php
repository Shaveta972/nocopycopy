<?php
use yii\helpers\Html;
$this->title = \Yii::t('app','About Us');

$this->registerMetaTag(['name' => 'keywords', 'content' => 'yii, developing, views,
      meta, tags']);
$this->registerMetaTag(['name' => 'description', 'content' => 'This is the description
      of this page!'], 'description');
?>
<div class="wrapper-inner">
	<div class="about-page">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<h2>About Us</h2>
					<div class="about-content-top">
						<h5>We are committed to serving our customers well and work to
							improve the life, wellbeing and happiness of people.</h5>
						<h6>We have been a pioneer in legacy products that fulfill a
							requirement in a simple and dependable manner. We aim to lead the
							way in expanding global consciousness of legacy foresight.</h6>
						<h6>Our Charity and Personal divisions each provide a fair and
							dependable service for our highly valued customers.</h6>
					</div>
				</div>
			</div>
			<div class="row mt-3 align-items-center">
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="about-img">
					<?php echo Html::img('@web/img/about-img-1.jpg')?>
				</div>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="about-content-middle">
						<h2>Charity</h2>
						<p>Legacy philanthropy accounts for approximately a third of
							annual funding for charitable causes, yet just seven percent of
							people choose to leave a charitable legacy gift.</p>
						<p>We work to make leaving a charitable legacy a more rewarding
							experience and offer people a simple, stable mechanism to support
							good causes.</p>
						<p>The <q>My Charitable Legacy</q> overall purpose is to provide
							additional revenue streams for charitable causes and
							organizations, assisting in the advancement of their objectives.</p>
					</div>
				</div>
			</div>
			<div class="row mt-3 align-items-center">

				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="about-content-middle">
						<h2>Personal</h2>
						<p>Originating from philanthropy roots, customer interaction has
							lead us to extend the scope of our services to provide the same
							simple, stable mechanism to help customers make provision for
							funeral costs or to support loved ones when they are no longer
							around.</p>
						<p class="text-primary">Around the globe individuals, families and
							charitable causes benefit from our services.</p>
						<p>We run an efficient operating model enabling our services to be
							highly competitive whilst providing exceptional customer service.</p>
					</div>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="about-img">
						<?php echo Html::img('@web/img/about-img-2.jpg')?>
					</div>
				</div>
			</div>
		</div>
	</div>



	<div class="home-contact">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-6">
					<div class="home-contact-inner text-center">
						<?php echo Html::img('@web/img/contact-message.png')?>
						<h3>
							Web chat <br> with us now
						</h3>
					</div>
				</div>
				<div class="col-md-6 col-sm-6 border-left">
					<div class="home-contact-inner text-center">
						<?php echo Html::img('@web/img/contact-mobile.png')?>
						<h3>Call us</h3>
						<h6>Give us a call and speak to our friendly team.</h6>
						<h3 class="text-red">
							<a href="tel:0800 088 5494" class="text-red">0800 088 5494</a>
						</h3>
						<address>
							Monday to Friday, 10am to 6pm <br> Saturday closed <br> Sunday
							and Bank Holidays, closed
						</address>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
