<?php
use yii\helpers\Html;

$this->title = \Yii::t ( 'app', 'Bequest Direct' );
?>

<div class="home-banner">
	<?php echo Html::img('@web/img/home-banner.jpg',['alt'=>"Bequest banner"])?>
	<div class="home-overlay">
		<div class="container h-100">
			<div class="row h-100 align-items-center">
				<div class="col-md-6 col-sm-6">
					<div class="banner-content">
						<h1>Helping You Plan Ahead</h1>
						<h5>We provide a reliable, stable mechanism to
							help customers make future provision for themselves, their loved
							ones and for causes that they care about.</h5>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="home-plans">
	<div class="container">
		<div class="row">
			<div class="col-md-9 col-sm-9">
				<h2>Inflation-linked cash plan</h2>
				<h5 class="text-primary">Our simple plan pays out an
					inflation-linked cash sum on death.</h5>
				<ul>
					<li>Pay money in and on death the plan pays out a cash sum direct
						to the beneficiary you have named.</li>
					<li>You never pay in more than is paid out.</li>
					<li>The plan is paid out within 24 hours of a payout request,
						before probate as it is outside your estate, so it is there when
						it's needed.</li>
					<li>The plan locks in today's prices as it is inflation-linked.</li>
					<li>The beneficiary does not have any rights to the cash sum until
						your death.</li>
					<li>You can change the beneficiary at anytime.</li>
					<li>You can cash-in your plan at anytime.</li>
				</ul>
			</div>
			<div class="col-md-3 col-sm-3">
				<div class="plans-circle align-items-center">Pay in less for a
					bigger payout than over 50 Life Insurance</div>
			</div>
		</div>
	</div>
</div>

<div class="home-cashplan">
	<div class="container">
		<div class="text-center">
			<h2>Our Inflation-Linked Cash Plan</h2>
		</div>
		<div class="mt-4 card-deck home-cashplan-slider">
			<div class="card">
				<div class="cashplan">
					<div class="cashplan-img">
					<?php echo Html::img('@web/img/cash-plan-1.jpg',['alt'=>"cash plan"])?>
					
					</div>
					<div class="cashplan-content">
						<h3>Funeral Plan</h3>
						<p>Inflation-linked cash funeral plan.</p>
						<div class="text-center">
							<a href="javascript:void(0);" class="btn btn-primary">View More</a>
						</div>
					</div>
				</div>
			</div>
			<div class="card">
				<div class="cashplan">
					<div class="cashplan-img">
					<?php echo Html::img('@web/img/cash-plan-2.jpg',['alt'=>"cash plan"])?>
						
					</div>
					<div class="cashplan-content">
						<h3>Prepaid Funeral Top-Up Plan</h3>
						<p>Make provision for expenses that are not included within a
							prepaid funeral plan.</p>
						<div class="text-center">
							<a href="javascript:void(0);" class="btn btn-primary">View More</a>
						</div>
					</div>
				</div>
			</div>
			<div class="card">
				<div class="cashplan">
					<div class="cashplan-img">
					<?php echo Html::img('@web/img/cash-plan-3.jpg',['alt'=>"cash plan"])?>
					</div>
					<div class="cashplan-content">
						<h3>Loved Ones Plan</h3>
						<p>Support loved ones with a inflation-linked cash sum paid on
							death.</p>
						<div class="text-center">
							<a href="javascript:void(0);" class="btn btn-primary">View More</a>
						</div>
					</div>
				</div>
			</div>
			<div class="card">
				<div class="cashplan">
					<div class="cashplan-img">
					<?php echo Html::img('@web/img/cash-plan-4.jpg',['alt'=>"cash plan"])?>
					</div>
					<div class="cashplan-content">
						<h3>Charitable Legacy Plan</h3>
						<p>Be amazing an support a charity.</p>
						<div class="text-center">
							<a href="javascript:void(0);" class="btn btn-primary">View More</a>
						</div>
					</div>
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
				<?php echo Html::img('@web/img/contact-message.png',['alt'=>""])?>
					<h3>
						Web chat <br> with us now
					</h3>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 border-left">
				<div class="home-contact-inner text-center">
				<?php echo Html::img('@web/img/contact-mobile.png',['alt'=>""])?>
					<h3>Call us</h3>
					<h6>Give us a call and speak to our friendly team.</h6>
					<h3 class="text-red">
						<a href="tel:0800 088 5494" class="text-red">0800 088 5494</a>
					</h3>
					<address>
						Monday to Friday, 10am to 6pm <br> Saturday closed <br> Sunday and
						Bank Holidays, closed
					</address>
				</div>
			</div>
		</div>
	</div>
</div>


