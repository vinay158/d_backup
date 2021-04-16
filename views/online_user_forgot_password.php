<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>lightbox/video_lightbox/css/lightbox.min.css">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>lightbox/video_lightbox/js/lightbox.js"></script>
<!-- unpkg : use the latest version of Video.js -->
<link href="https://unpkg.com/video.js/dist/video-js.min.css" rel="stylesheet">
<script src="https://unpkg.com/video.js/dist/video.min.js"></script>

	
<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/header/masthead');  ?>
<style type="text/css">

.onlinedojo_video_login .login_box{margin-top:50px;background:#fafafa;padding:50px}
.onlinedojo_video_login {margin-bottom:100px;}
.onlinedojo_video_login .title-main {
    border: none;
    margin-top: 40px;
    margin-bottom: 0px!important;
}
.onlinedojo_video_login .title-main h2 {
    line-height: inherit!important;
}
</style>

<script type="text/javascript">
$(window).load(function(){
	
})
	$(document).ready(function(){
		
		
		$('.forgotPasswordSubmit').click(function(){
			$('.ErrorMsgNotLogin').html('');
			var password = $('.new_password').val();
			var confirmPassword = $('.confirm_password').val();
			
			if (password != confirmPassword) {
				$('.ErrorMsgNotLogin').html('Your password and confirmation password do not match..');
				return false;
			}
		})
	});		
</script>


<div class="mobile-contact">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 text-center"> <span class="no"><?php echo $this->query_model->getStaticTextTranslation('student_section'); ?></span>
        <div class="row">
          <?php if($site_settings[0]->hide_window != 'hide'): ?>
            <div class="col-xs-6 row-btn"> 
			<a class="btn btn-theme"  href="<?php echo $this->query_model->getTrialOfferUrl($site_settings[0]->url_call_to_action); ?>" target="<?php if($site_settings[0]->window == 'new'): echo '_blank'; endif; ?>"> 
			<?php $this->query_model->getStrReplace($site_settings[0]->call_to_action); ?></a> 
			</div>
			<?php endif; ?> <div class="col-xs-6 row-btn"> 
			<?php if($multiLocation[0]->field_value == 1 ){ ?>
				<a class="btn btn-theme" href="javascript:void(0);"  target="_blank"> <i class="fa fa-map-marker"> </i><?php echo ' '.count($allLocations).' '.$this->query_model->getStaticTextTranslation('locations'); ?></a>
			<?php } else{ ?>
			<a class="btn btn-theme" href="<?php echo  $this->query_model->getFindUs($mainLocation[0]->address,$mainLocation[0]->suite,$mainLocation[0]->city,$mainLocation[0]->state,$mainLocation[0]->zip); ?>"  target="_blank"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?> </a>
			<?php } ?>
			 </div>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
</div>
<!-- blog list -->


<section id="video-album" class="section onlinedojo_video_login onlineuser_forgot_password">
  <div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="title-main">
              <h2><span><?php echo $page_title; ?> </span></h2>
            </div>
		  <div class="col-sm-6 col-sm-offset-3 text-center login_box">
			 <div class="login-form">
			 
				<form id="loginform" class="form-horizontal" role="form" method="post" action="<?php echo base_url().'students/forgot_password' ?>">
				<div class="col-sm-12">
				  <?php $onlineuser_forgot_password_error = '';
						if($this->session->userdata('onlineuser_forgot_password_error')){ 
						
							$onlineuser_forgot_password_error = $this->session->userdata('onlineuser_forgot_password_error');  
							$this->session->unset_userdata('onlineuser_forgot_password_error');    
						}
					?>
				  <span class="ErrorMsgNotLogin"><?php echo $onlineuser_forgot_password_error; ?></span>
				   <div class="input-group">
					  <span class="input-group-addon"><i class="fa fa-user"></i></span>
					  <input id="login-user" type="text" class="form-control forgot_username" name="username" placeholder="Email address" required>
				   </div>
				 <div class="col-sm-12"><h2></h2></div>
				 </div><div class="col-sm-12">
				   <div class="input-group">
					  <span class="input-group-addon"><i class="fa fa-lock"></i></span>
					  <input id="login-password" type="password" class="form-control new_password" name="new_password" placeholder="New <?php echo $this->query_model->getStaticTextTranslation('password'); ?>" required>
				   </div>
				   <div class="col-sm-12"><h2></h2></div>
				  </div>
				  <div class="col-sm-12">
				   <div class="input-group">
					  <span class="input-group-addon"><i class="fa fa-lock"></i></span>
					  <input id="login-password" type="password" class="form-control confirm_password" name="confirm_password" placeholder="Confirm <?php echo $this->query_model->getStaticTextTranslation('password'); ?>" required>
				   </div>
				  </div>
				  <div class="col-sm-12">
				   <input type="submit" name="forgot_password" value="Send" class="btn btn-readmore forgotPasswordSubmit btn-block submit button">
				  </div>
				  <div class="col-sm-12"><h2></h2></div>
				</form>
				
			 </div>
		  </div>
	   </div>
	  
	</div>
 </section>      
      





<?php $this->load->view('includes/footer'); ?> 

