<?php
use app\models\User;
?>
<hr class="mb-4 mt-4">
<div class="result-row px-3 py-3">
	<div class="col-lg-12 col-xl-12 result-content">
		<div class="row d-flex justify-content-between">
		<div class="col-md-10">
			<h3 class="font-weight-bold mb-0">
				<strong><?php echo $model->title; ?></strong>
			</h3>
		</div>
			<div class="col-md-2">
			<table class="w-100">
				<tr>
					<td width="<?php echo $model->percents; ?>%">
						<div class="progress" style="height: 36px; margin-top: 5px">
						<?php if ($model->percents > 80) {
									$progressbarClassIndicator='bg-danger';
								}
								else if($model->percents > 40 ){
									$progressbarClassIndicator='bg-warning';
								}
								else{
									$progressbarClassIndicator='bg-info';
								}
						?>
							<div class="progress-bar <?php echo $progressbarClassIndicator;?>" role="progressbar" style="width:<?php echo $model->percents; ?>%" aria-valuenow="<?php echo $model->percents; ?>" aria-valuemin="0" aria-valuemax="<?php echo $model->percents; ?>"><?php echo $model->percents; ?>%</div>
						</div>
					</td>
				</tr>
			</table>
			</div>
		</div>
		<a href="<?php echo $model->url; ?>"> <span class="text-black result-link"><?php echo $model->url; ?></span></a>
		<p class="text-blue process-content mt-3"><?php echo User::limit_text($model->introduction, 35); ?></p>
		<div class="process-info d-flex justify-content-between">
			<a class="btn btn-red"> <i class="fa fa-bars pr-2 text-black"></i> <span class="clearfix d-none d-md-inline-block text-black"><?php echo $model->number_copied_words; ?> Words</span>
			</a>
			<!-- <a class="btn btn-main">
                            <span class="clearfix d-none d-md-inline-block text-white">Open Report</span>
                        </a> -->
		</div>
	</div>
</div>