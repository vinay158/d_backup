
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>lightbox/video_lightbox/css/lightbox.min.css">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>lightbox/video_lightbox/js/lightbox.js"></script>
<!-- unpkg : use the latest version of Video.js -->
<link href="https://unpkg.com/video.js/dist/video-js.min.css" rel="stylesheet">
<script src="https://unpkg.com/video.js/dist/video.min.js"></script>

	
<?php $this->load->view('includes/header'); ?>
<?php  $this->load->view('includes/student_header/masthead'); ?>
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
		
		
		$('.submitSignUpForm').click(function(){
			 var err = 0;
			
			
			
			var name=$('#first_name2').val();
			if(name.length == 0){
				var err = 1;
				$('#first_name2').after('<div class="reds name_error2">Enter Your First Name</div>');
			}
			
			  
			var last_name=$('#last_name2').val();
			if(last_name.length == 0){
				var err = 1;
				$('#last_name2').after('<div class="reds last_name_error2"><?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?></div>');
			}
			
			
			var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
			var email=$('#form_email2').val();
			if(email.length == 0 || emailfilter.test($("#form_email2").val()) == false){
				var err = 1;
				$('#form_email2').after('<div class="reds email_error2"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
			}
			
			<?php /*if($multiLocation[0]->field_value == 1 ){ ?>
				var school=$('#school2').val();
				if(school == '' || school == null){
					var err = 1;
					$('#school2').after('<div class="reds school_name_error2"><?php echo $this->query_model->getStaticTextTranslation('select_your_location'); ?></div>');
				}
				<?php }*/ ?>
				
				
			
			$('.ErrorMsgNotLogin').html('');
			var password = $('.new_password').val();
			var confirmPassword = $('.confirm_password').val();
			if(password != ""){
				if (password != confirmPassword) {
					var err = 1;
					$('.ErrorMsgNotLogin').html('Your password and confirmation password do not match..');
				}
			}
			
			
		
			if(err == 0){
				return true;
			} else{
				return false;
			}
		  
		})
		
		
		$('#first_name2').keyup(function(){
					if($(this).val().length > 0){
						$('.name_error2').hide();
					} else{
						$('#first_name2').after('<div class="reds name_error2">Enter Your First Name</div>');
						
					}
			});
			
			$('#last_name2').keyup(function(){
					if($(this).val().length > 0){
						$('.last_name_error2').hide();
					} else{
						$('#last_name2').after('<div class="reds last_name_error2"><?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?></div>');
						
					}
			});
			
			
			$('#form_email2').keyup(function(){
					if($(this).val().length > 0){
						$('.email_error2').hide();
					} else{
						$('#form_email2').after('<div class="reds email_error2"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
						
					}
			});
			
			
			<?php /*if($multiLocation[0]->field_value == 1 ){ ?>
			$('#school2').change(function(){
					if($(this).val() != ''){
						$('.school_name_error2').hide();
					} else{
						$('.school_name_error2').show();
						$('#school2').after('<div class="reds school_name_error2"><?php echo $this->query_model->getStaticTextTranslation('select_your_location'); ?></div>');
						
					}
			});
			<?php }*/ ?>
			
			
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
			
				
		  <div class="col-sm-8 col-sm-offset-2 text-center login_box">
			 <div class="login-form">
			 <?php $get_unique_id = $this->query_model->getUniqueNumberForCustomField(); ?>
				<form class="row" method="post" id="" action="">
		
			
			<?php if($this->session->userdata('edit_profile_success_message')){ ?> 
					<div class="col-md-12 col-sm-12 text-center">
						<?php 
							echo $this->session->userdata('edit_profile_success_message');
							
							$this->session->unset_userdata('edit_profile_success_message');  
						?>
						<br/>
						<br/>
						</div> 
				  <?php } ?>			
			<span class="ErrorMsgNotLogin">
			<?php 
				if($this->session->userdata('edit_profile_error_message')){ 
						echo $this->session->userdata('edit_profile_error_message');
						$this->session->unset_userdata('edit_profile_error_message');  
				}
			?>
			</span>
		
			<div class="col-md-6 col-sm-6">
				<div class="form-group">
				  <input type="text" class="form-control" name="firstname"  id="first_name2" placeholder="First Name" value="<?php echo $user->firstname; ?>">
				</div>
			</div>  
			
			<div class="col-md-6 col-sm-6">
				<div class="form-group">
				  <input type="text" class="form-control" name="lastname" value="<?php echo $user->lastname; ?>" id="last_name2" placeholder="<?php echo $this->query_model->getStaticTextTranslation('last_name'); ?>">
				</div>
			</div> 

			<div class="col-md-6 col-sm-6">
				<div class="form-group">
				  <input type="text" class="form-control" name="email" value="<?php echo $user->email; ?>" id="form_email2" placeholder="<?php echo $this->query_model->getStaticTextTranslation('email'); ?>" readonly>
				</div>
			</div>

			
			
			<div class="col-md-6 col-sm-6">
				<div class="form-group">
				  <input type="text" class="form-control" name="phone" value="<?php echo $user->phone; ?>" id="phone" placeholder="<?php echo $this->query_model->getStaticTextTranslation('phone'); ?>">
				</div>
			</div>
			
			<div class="col-md-6 col-sm-6">
				<div class="form-group">
				  <input type="text" class="form-control new_password" name="password" value="" id="password" placeholder="<?php echo $this->query_model->getStaticTextTranslation('password'); ?>">
				</div>
			</div>
			
			<div class="col-md-6 col-sm-6">
				<div class="form-group">
				  <input type="text" class="form-control confirm_password" name="confirm_password" value="" id="password" placeholder="Confirm <?php echo $this->query_model->getStaticTextTranslation('password'); ?>">
				</div>
			</div>
			
			
			<!--<div class="col-md-6 col-sm-6">
				<div class="form-group">
				  <input type="text" class="form-control" name="dojo_password" value="" id="phone" placeholder="Dojo <?php echo $this->query_model->getStaticTextTranslation('password'); ?>">
				</div>
			</div>
			
			
			<?php if($multiLocation[0]->field_value == 1){ ?>
			<div class="col-md-6 col-sm-6">
				<div class="form-group">
				  <select name="location" class="form-control" id="school2">
					  <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_location'); ?></option>
					  <?php foreach($allLocations as $location): ?>
						<option  value="<?=$location->id;?>"  <?php echo (!empty($user->location_id) && $user->location_id == $location->id) ? "selected=selected" : ''; ?>><?=$location->name;?> </option>
					<?php endforeach;?>
					<option value="virtual_student_only"  <?php echo (!empty($user->location_id) && $user->location_id == "virtual_student_only") ? "selected=selected" : ''; ?>>Virtual student only</option>
					
				  </select>
				</div>
			</div>
			<?php } ?> -->

		<input type="hidden" class="page_url" name="page_url" value="<?php echo !empty($signup_slug) ? '/'.$signup_slug->slug : ''; ?>" />
		
		<div class="col-md-12 col-sm-12">
			<div class="form-group">
				<input type="submit" name="submit" value="Update" class="btn btn-readmore submitSignUpForm btn-block submit button" id="">
			</div>
		</div>
		
		
		
		
		
		
		
	</form>
				
			 </div>
		  </div>
	   </div>
	  
	</div>
 </section>      
      





<?php $this->load->view('includes/footer'); ?> 

