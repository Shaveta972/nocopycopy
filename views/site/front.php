<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = \Yii::t('app', 'Home');
?>
<?php echo \yii2mod\alert\Alert::widget(); ?>
<main>
  <section class="banner-sec">
    <div class="outer">
      <div class="container">
        <div class="row">
          <div class="col-md-10 offset-md-1">
            <div class="inner">
              <div class="search-bar">
                <span>Your Plagiarism Checker</span>
                <h2>Authenticity,</h2>
                <h2 class="light">Now verified.</h2>
              </div>
              <form class="form-inline">
                <div class="input-group mb-3 search-input">
                <?php
                    if (Yii::$app->user->isGuest) { ?>
                <input type="text" class="form-control" readonly placeholder="Enter text or upload file to check for plagiarism and paraphrased content" 
                  aria-label="Enter text or upload file to check for plagiarism and paraphrased content" 
                  aria-describedby="basic-addon2" onclick="window.location.href='<?php echo Url::to(['/site/login']);?>'">
                    <?php } else { 
                      ?>
                     
                  <input type="text" class="form-control openModal"  placeholder="Enter text or upload file to check for plagiarism and paraphrased content" 
                  aria-label="Enter text or upload file to check for plagiarism and paraphrased content" 
                  aria-describedby="basic-addon2" data-url='<?php echo Url::to(['/scan/text-scan']);?>'>
                  <?php  } ?>
                 
                 
                  <div class="input-group-prepend theme-gradient">
                    <?php
                    if (!Yii::$app->user->isGuest) { ?>
        
                      <button id="textScan"  href="<?php echo Url::to(['/scan/text-scan']);?>" type="button" class="input-group-text bg-transparent border-0 openModal">
                        <?php echo Html::img('@web/themes/frontend/images/scan.png', ['alt' => "scan"]) ?>
                      </button>
                    <?php } else { ?>
                      <a class="input-group-text bg-transparent border-0 btn-loading" href="<?php echo Url::to(['/site/login']) ?>">
                        <?php echo Html::img('@web/themes/frontend/images/scan.png', ['alt' => "scan"]) ?>
                      </a>
                    <?php
                  }
                  ?>
                  </div>
                </div>
              </form>
              <ul class="links">
                <li>
                    <div class="upload-btn-wrapper">
                    <?php
                    if (!Yii::$app->user->isGuest) { ?>
                    <button id="fileScan" class="btn theme-gradient openModal"  href="<?php echo Url::to(['/scan/file-scan']);?>" >
                    <?php } else { ?>
                      <button class="btn theme-gradient"  onclick="window.location.href='<?php echo Url::to(['/site/login']) ?>'" >
                    <?php } ?>
                     Start 
                 <?php echo Html::img('@web/themes/frontend/images/upload.png', ['alt' => "upload"]) ?>
                  </button>
                    <input type="file" name="myfile">
                  </div> 
                </li>
                <li>
               <?php if (!Yii::$app->user->isGuest) { ?>
                  <button href="<?php echo Url::to(['/scan/url-scan']);?>" id="urlScan"  class="openModal bg-transparent border-0 text-bgray">Check via web pages URL
                   <?php echo Html::img('@web/themes/frontend/images/link.png', ['alt' => "link"]) ?></button>
               <?php } else { ?>
                <a href="<?php echo Url::to(['/site/login']); ?>">Check via web pages URL
                   <?php echo Html::img('@web/themes/frontend/images/link.png', ['alt' => "link"]) ?></a>
               <?php } ?>
                </li>
              </ul>
            </div>
          </div>
          <!--col-md-12-->
        </div>
      </div>
    </div>
  </section>
  
  <section class="use-sec">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="theme-heading">
            <h1>Why Use NoCopyCopy</h1>
            <p>NoCopyCopy provides a broad spectrum of web platform services and mobile application which <br>verifies the authenticity of documents and digitization solution services for organization <br>
              
              <br>
              <br>
              <hr></hr>
              <br>
             <h1>Solutions</h1>
          </div>
        </div>
        <div class="col-md-4">
          <div class="box h-100">
            <div class="pic">
              <?php echo Html::img('@web/themes/frontend/images/use1.jpg', ['alt' => "use1"]) ?>
            </div>
            <div class="content">
              <a href="#">Plagiarism Checking</a>
              <p>NoCopyCopy helps to provide proper referencing and plagiarism checking of intellectual work to students, lecturers, bloggers, executives and individuals while also prevents plagiarisation of intellectual property across Universities and Institutions in Nigeria and West Africa</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="box h-100">
            <div class="pic">
              <?php echo Html::img('@web/themes/frontend/images/use2.jpg', ['alt' => "use2"]) ?>
            </div>
            <div class="content">
              <a href="#">Digitization Services</a>
              <p>NoCopyCopy offers custom end-to-end solutions for your digitization projects. And also saddled with the responsibility of preserving materials in digital format which are heavily reliant on research, development and problem solving.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="box h-100">
            <div class="pic">
              <?php echo Html::img('@web/themes/frontend/images/use3.jpg', ['alt' => "use3"]) ?>
            </div>
            <div class="content">
              <a href="#">Edtech Solutions</a>
              <p>NoCopyCopy provides a bouquet of EdTech solutions which includes; Digital Library, Mobile Learning and Digital Content Creation</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="plans-section">
	<div class="container">
  <div class="theme-heading">
        <h1>Pricing</h1>
      </div>
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
							         if($value->is_published == 1) { ?>
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

        </section>

  <section class="discover">
    <div class="outer">
      <div class="container">
        <div class="row">

          <div class="col-md-6 text-right p-0">
            <div class="iphone">
              <?php echo Html::img('@web/themes/frontend/images/iphone-image.png', ['alt' => "iphone"]) ?>
            </div>
          </div>
          <div class="col-md-4 offset-md-1">
            <div class="idea h-100">
              <?php echo Html::img('@web/themes/frontend/images/idea.png', ['alt' => "user"]) ?>
              <h3>Detect plagiarism and paraphrased content using advanced
                AI technology.</h3>
              <p>NoCopyCopy plagiarism checker can detect plagiarism from billions of web pages as well as from ProQuest’s academic databases.</p>
              <a href="#" class="btn theme-gradient">Discover More <i class="fa fa-angle-right" aria-hidden="true"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="testimonials">
    <div class="container">
      <div class="theme-heading">
        <h1>Testimonials</h1>
      </div>
      <div class="card-columns">
                
          <?php 
          if ($testimonials) {
              foreach ($testimonials as $data) {
                  ?>
            <div class="card">
            <div class="card-body">
            <p class="card-text">
            <?= $data['testimonials_html_text'] ?>
            </p>
          </div>
          <div class="card-footer">
            <div class="user">
             <?php Yii::setAlias('imagesUrl', '@web/uploads/testimonials'); ?>
            <img style="width:50px; height:50px" class="rounded-circle" alt ="testimonial-image" src='<?php echo \Yii::getAlias('@imagesUrl') . '/' . $data['testimonials_image']; ?>' class="d-block">
              <?php //echo Html::img('@web/themes/frontend/images/user.jpg', ['alt' => "user", 'class' => 'rounded-circle']) ?>
            </div>
            <h4><?= $data['testimonials_name'] ?></h4>
            <small class="text-muted"><?= $data['testimonials_country'] ?></small>
          </div>
        </div>
        <?php
              }
          } ?>
      </div>
    </div>
  </section>

  <section class="subscription">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="content">
            <h1>Get NoCopyCopy today!</h1>
            <a class="btn theme-gradient btn-subscription" href="<?php echo Url::to(['/site/plans']) ?>">View Subscription <i class="fa fa-angle-right" aria-hidden="true"></i></a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="demo">
    <div class="location">
      <div class="map">
        <?php echo Html::img('@web/themes/frontend/images/map-office-Ajah.jpg', ['alt' => "map"]) ?>
      </div>
    </div>
    <div class="help_desk">
      <div class="container">
        <div class="row">
          <div class="col-md-10 mx-auto">
            <div class="dialogue_box">
              <h1>Hi! How can we help?</h1>
              <p>Help is just a click away. Our support team helps you deploy, implement, and support NoCopyCopy so that you achieve the best results.</p>
              <ul>
                <li>
                  <i class="fa fa-envelope" aria-hidden="true"></i>
                  <h5 href="#">info@nocopycopy.ng</h5>
                  <span>Email</span>
                </li>
                <li>
                  <i class="fa fa-mobile" aria-hidden="true"></i>
                  <h5 href="#">+234 703 529 3779</h5>
                  <span>Phone</span>
                </li>
                <li>
                  <i class="fa fa-map-marker" aria-hidden="true"></i>
                  <h5 href="#">14B Lateef Jakande Street</h5>
                  <span>Address</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="social_links">
      <ul>
        <li><a href="https://instagram.com/nocopycopy/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
        <li><a href="https://twitter.com/nocopycopy/" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
        <li><a href="https://facebook.com/nocopycopy/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
      </ul>
    </div>
  </section>
  <section class="copyright">
    <div class="container">
      <div class="inner">
        <div class="pic">
          <?php echo Html::img('@web/themes/frontend/images/home-logo.png', ['alt' => "home-logo"]) ?>
        </div>
        <div class="text">All Rights Reserved 2020 | NoCopyCopy.</div>
      </div>
    </div>
  </section>
  <div class="modal inmodal" id="modalScan" tabindex="-1" role="dialog" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <h4 class="modal-title text-blue">Start your NoCopyCopy scan</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <div id='modalContent'></div>
            </div>            
        </div>
    </div>
</div>
<?php
$script = <<< JS
    //Open Text Modal And Saved
    $(document).on('click',".openModal",function(e) {
      $("#modalScan").modal("show");
      if(typeof($(this).attr("data-url")) != "undefined" && $(this).attr("data-url") !== null) {
        $("#modalScan").find("#modalContent").load($(this).attr("data-url"));
      }
      else {
       $("#modalScan").find("#modalContent").load($(this).attr("href"));
     }
  });   //Open File Modal And Saved
   
JS;
$this->registerJs($script);
?>
</main>
