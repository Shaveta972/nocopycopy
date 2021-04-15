<?php
use yii\bootstrap4\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;
use smladeoye\paystack\widget\PaystackWidget;

$this->title = \Yii::t('app', 'Plans');
?>
<div class="plans">
	<div class="container h-100 d-flex align-items-center justify-content-center">
		<div class="row">
			<div class="col-md-12 " >
			</div>
			<?php foreach ($plans as $key => $value) {
				$class = ($key % 2 != 0 ) ? 'blue-box' : '';
				?>
				<div class="col-md-4 " id="_<?php echo $value->id; ?>">
					<div class="box <?php echo $class; ?>">
					  
						<div class="top_heading px-4 py-3 border-bottom">
							  <?php if($value->is_published == 1){ ?>
							<h1><?php echo $value->price; ?> <span><?php echo $value->currency; ?></span></h1>
								<?php } ?>
							<span class="text-bgray"><?php echo $value->title; ?></span>
						</div>
					
						
						<div class="media border-bottom align-items-center px-4 py-3">
							<div class="media-body d-flex align-items-center mr-2">
								<span class="text-bgray">Credits</span>
								<span class="ml-auto text-info"><?php echo $value->number_credits;?> <?php echo ($value->number_words) ? "/ ".$value->number_words : ''; ?></span>
							</div>
							<i class="fa fa-check icon-text icon-text-xs d-flex text-info ml-auto pl-3"></i>
						</div>
						<div class="media border-bottom align-items-center px-4 py-3">
							<div class="media-body d-flex align-items-center mr-2" >
								<span class="text-bgray">Validity</span>
								<span class="ml-auto text-info"><?php echo $value->validity; ?> month(s)</span>
							</div>
							<i class="fa fa-check icon-text icon-text-xs d-flex text-info ml-auto pl-3"></i>
						</div>
						<div class="media align-items-center px-4 py-3 ">
							<div class="media-body d-flex justify-content-center">
								<?php if (!Yii::$app->user->isGuest) {
									   if ($planExistID == $value->id) {
										?>
									<?= Html::button('Cancel', ['value' => '', 'title' => 'Cancel', 'class' => 'showModalButton btn btn-success']); ?>
									<?php } else { ?>
										<?php if ($hidden == 1) { ?>
											  <?php if($value->is_published == 1) { ?>
											        <a href="<?php echo Url::to(['payment/product', 'plan_id' => $value->id]); ?>" class="btn theme-gradient mt-0 ">
												<i class="fa fa-shopping-cart pl-0 mr-1" aria-hidden="true"></i>Buy Now</a>
												<?php } else { ?>
													<a href="<?= Yii::$app->params['WEB_URL']; ?>site/contact/" class="btn theme-gradient mt-0 ">
												<i class="fa fa-phone pl-0 mr-1" aria-hidden="true"></i>Contact Us</a>
												
												
												
										<?php	
												}
									}
								}
							} else { ?>
							
							 <?php if($value->is_published == 1) { ?>
											        <a href="<?php echo Url::to(['site/register']); ?>" class="btn theme-gradient mt-0 ">
												<i class="fa fa-shopping-cart pl-0 mr-1" aria-hidden="true"></i>Buy Now</a>
												<?php } else { ?>
													<a href="<?= Yii::$app->params['WEB_URL']; ?>site/contact/" class="btn theme-gradient mt-0 ">
												<i class="fa fa-phone pl-0 mr-1" aria-hidden="true"></i>Contact Us</a>
												<?php } ?>
							
							
							
							
							<?php } 
							?>
							
							
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
	
		</div>
	</div>
</div>
<div class="modal inmodal" id="modalCancelPlan" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-confirm plan-modal">
		<?php

		$form = ActiveForm::begin([

				'id' => 'cancel-plan',
				'action' => Url::to(['payment/cancel']),
				'enableAjaxValidation' => false

			]); ?>
		<div class="modal-content">
			<div class="modal-header">
				<div class="icon-box">
					<i class="fa fa-times"></i>
				</div>
				<h4 class="modal-title">Are you sure?</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<p>Do you really want to cancel this plan? This process cannot be undone.</p>
				<?php echo $form->field($model, 'is_cancel')->hiddenInput(['value' => 1])->label(false); ?>
				<?php echo $form->field($model, 'id')->hiddenInput(['value' => $userPlanRecordID])->label(false); ?>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
				<?= Html::submitButton(Yii::t('app', 'Delete'), ['class' => 'btn btn-main btn-danger']); ?>
			</div>
		</div>
		<?php ActiveForm::end(); ?>

	</div>
</div>
<?php
$script = <<< JS
		$(document).on('click',".showModalButton",function(e) {
			$("#modalCancelPlan").modal("show"); });
JS;
$this->registerJs($script);
echo $this->registerJs("$(document).ready(function($) {
	$('body').on('beforeSubmit', 'form#cancel-plan', function (e) {
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
                        text: 'Your plan has cancelled successfully.',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Continue'
                      }).then((result) => {
                        if (result.value) {
                        window.location.href='plans';
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