
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<?php if($this->session->userdata('error_message') == 1){	 ?>
<script type="text/javascript">
    $(window).load(function(){
		$('.ErrorMsgNotLogin').show();
        $('#loginmodal').modal('show');
    });
</script>
<?php } ?>
<script type="text/javascript">
$(document).ready(function(){
		$('.student_section_login_btn').click(function(){
			$('.ErrorMsgNotLogin').hide();
			$('#login-password').val('');
		});
	});
</script>

<?php 
$site_settings = $this->query_model->getbyTable("tblsite");
$password_setting = $this->query_model->getbyTable("tbl_password_pro");
$mainLocation = $this->query_model->getMainLocation("tblcontact");

$multi_student_section = $this->query_model->getbySpecific("tblconfigcalendar", 'id',8);


?>
 <?php 
 	$pageurl = '';
 	if(isset($_SERVER['REQUEST_URI'])){
		$pageurl = explode('/',$_SERVER['REQUEST_URI']);
		if(isset($pageurl[1])){
			//$pageurl = $pageurl[1];
		}
	}
 ?>
 
  <?php 
	if($settings->override_logo == 1){
			if($settings->override_nav_bar_logo != 1)
			{
			
			$footer_logo = $this->query_model->getbySpecific('tbloverride_logos','s_no', $settings->override_nav_bar_logo);
			
				if(!empty($footer_logo)){
				
					$nav_bar_logo = base_url().'upload/override_logos/'.$footer_logo[0]->logos;
					$nav_bar_logo_alt = $footer_logo[0]->logo_alt;
		
				} else{ 
					$nav_bar_logo = $logo;
					$nav_bar_logo_alt = $settings->logo_alt;
			
			}
		} else{
			$nav_bar_logo = $logo;
			$nav_bar_logo_alt = $settings->logo_alt;
		
 			 } 
 		} else{ 
			$nav_bar_logo = $logo;
			$nav_bar_logo_alt = $settings->logo_alt;
	 }
?>
<?php $current_url = base_url(); ?>
<?php 
	$show_nav = 1;
	//echo '<pre>pageurl'; print_r($pageurl); die;
	if(isset($pageurl[1]) && $pageurl[1] == 'programs'){
		if(isset($pageurl[2]) && !empty($pageurl[2]) && !isset($pageurl[3])){
			$this->db->select('page_template');
			$program_cat_detail = $this->query_model->getBySpecific('tblcategory','cat_slug',$pageurl[2]);
			//echo '<pre>program_cat_detail'; print_r($program_cat_detail); die;
			if(!empty($program_cat_detail)){
				$show_nav = ($program_cat_detail[0]->page_template == "condensed") ? 1 : 0;
			}
		}elseif(isset($pageurl[3])){
			$show_nav = 0;
		}
		
		if($show_nav == 0){
			if(!empty($pageurl) && in_array('thank-you',$pageurl)){
				$show_nav = 1;
			}
			
		}
	}
 ?>
<?php //$current_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['CONTEXT_PREFIX'].'/'; ?>
 <!-- Navigation -->
      <nav id="navigation" class="navbar navbar-inverse  main-nav  <?php if($show_nav == 0){ echo ' hidden-md hidden-lg'; }?>" >
	  
	  <?php
		$mobile_location_flag_url = '';
		$mobile_location = 0;
		$multiSchoolHeader = $this->query_model->getbyTable("tblconfigcalendar");
		$multiSchoolHeader = isset($multiSchoolHeader[11]) ? $multiSchoolHeader[11]->field_value : 0;
		
		$multiLocationHeader = $this->query_model->getbyTable("tblconfigcalendar");
		
		if($multiSchoolHeader == 1){
			$mobile_location = 1;
			$mobile_location_flag_url = base_url().'#find-location';
		}else{
			if($multiLocationHeader[0]->field_value == 1){
				$mobile_location = 1;
				$mobile_location_flag_url = base_url().'#our-locations';
			}
		}
	  ?>
         <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
               <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
               <span class="sr-only">Toggle navigation</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               </button>
               <!--<a class="navbar-brand hidden-xs" href="<?php base_url(); ?>"><img src="<?=$nav_bar_logo?>" alt="<?php $this->query_model->getStrReplace($nav_bar_logo_alt); ?>" class="logoImg" ></a> -->
			   
			   <?php if($mobile_location == 1){ ?>
					 <a href="<?php echo $mobile_location_flag_url; ?>" class="phone-icon mobile-visible"> <i class="fa  fa-phone"></i> </a>
			   <?php }else{ ?>
					<a href="tel:<?php echo !empty($mainLocation) ? $mainLocation[0]->phone : ''; ?>" class="phone-icon mobile-visible"> <i class="fa  fa-phone"></i> </a>
			   <?php } ?>
			  
                <a class="navbar-brand hidden-xs" href="<?php base_url(); ?>"><img src="<?=$nav_bar_logo?>" alt="<?php $this->query_model->getStrReplace($nav_bar_logo_alt); ?>"></a>
				
            </div>
            <div class="user-mobile-control">
                <?php 
					$mobileLogoImg = $nav_bar_logo;
					$navBarLogoAlt = $nav_bar_logo_alt;
					if(!empty($settings->unique_logo_mob)){
						$mobileLogoImg = 'upload/unique_logo/'.$settings->unique_logo_mob;
						$navBarLogoAlt = $settings->unique_logo_mob_alt_text;
					} 
				?>
               <div class="logo">
                   <a class="logo-m" href="<?php base_url(); ?>"><img src="<?=$mobileLogoImg?>" alt="<?php $this->query_model->getStrReplace($navBarLogoAlt); ?>" class="logoImg" ></a>
               </div> 
			   
			   <div class="login">
			   <?php if($mobile_location == 1){ ?>
					<a href="<?php echo $mobile_location_flag_url; ?>"   target="_blank" class="location-icon"> <i class="fa  fa-map-marker"></i> </a>
			   <?php }else{ ?>
					<a href="<?php echo  $this->query_model->getFindUs($mainLocation[0]->address,$mainLocation[0]->suite,$mainLocation[0]->city,$mainLocation[0]->state,$mainLocation[0]->zip); ?>"   target="_blank" class="location-icon"> <i class="fa  fa-map-marker"></i> </a>
			   <?php } ?>
			   
			   
                   
			 <?php 
			   //if($site_settings[0]->ss_login_btn_position == "header"){
					if($multi_student_section[0]->field_value == 1){ ?>
               
			   		<?php if($this->session->userdata('student_session_login') == 1){ ?>
						<a href="<?php echo base_url().'students' ?>"  class="login-user"  > <i class="fa  fa-user"></i></a> 
						<?php } else {  ?>
								<?php if($settings->st_sec_external_link == 1){ ?>
								<a href="<?php echo $settings->st_sec_button_url; ?>"  class="login-user"><i class="fa  fa-user"></i></a> 
							<?php } else{ ?>
								<!--<a href="javascript:void('0')" data-toggle="modal" data-target="#loginmodal" data-whatever="@mdo" class="login-user"> <i class="fa  fa-user"></i> </a>-->
								<a href="<?php echo base_url().'students/onlinedojo' ?>" class="login-user"> <i class="fa fa-user"></i></a>
							<?php } ?>
				 <?php } ?>
				 
				   <?php } //}?>
               </div>
			 
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			
				<?php front_menu(0, 3, 'nav navbar-nav navbar-left', 'dropdown  horizontal-dropdown '); ?>
				
               <!-- right user menu -->
			   
			   <?php if($settings->ss_login_btn_position == "navigation"){ ?>
				 <div class="<?php echo $settings->ss_login_button_class; ?> hidden-xs">
				<?php if($studentSection->field_value == 1){ ?>
				    <?php if($this->session->userdata('student_session_login') == 1){ ?>
								<a href="<?php echo base_url().'students' ?>" class="login-top"> 
								<i class="fa fa-user"></i><?php echo $settings->ss_login_text; ?></a>
						<?php } else { ?>
							<?php if($settings->st_sec_external_link == 1){ ?>
								<a href="<?php echo $settings->st_sec_button_url; ?>"  class="student_section_login_btn login-top">  <i class="fa fa-user"></i><?php echo $settings->st_sec_button_text; ?></a> 
							<?php } else{ ?>

					<?php if($settings->login_check_fields == 0){
						$student_session_login = array('student_session_login' => 1);
						$this->session->set_userdata($student_session_login);

					 ?>
					<a href="<?php echo base_url().'students' ?>" class="login-top"> <i class="fa fa-user"></i> <?php echo $settings->ss_login_text; ?></a>
					<?php }else{ ?>
							<?php if($password_setting[0]->password_protection_type == "single"){ ?>
								<!--<a href="javascript:void('0')" data-toggle="modal" data-target="#loginmodal" data-whatever="@mdo" class="student_section_login_btn login-top">  <i class="fa fa-user"></i><?php echo $settings->ss_login_text; ?></a> -->
								<a href="<?php echo base_url().'students/onlinedojo' ?>" class="login-top"> <i class="fa fa-user"></i> <?php echo $settings->ss_login_text; ?></a>
							<?php } elseif($password_setting[0]->password_protection_type == "multiple"){ ?>
								<a href="<?php echo base_url().'students/onlinedojo' ?>" class="login-top"> <i class="fa fa-user"></i> <?php echo $settings->ss_login_text; ?></a>
							<?php } ?>
							<?php }} ?>
						<?php } ?>
				<?php }   ?>
				</div>
			   <?php } ?>
				
			   <?php if($settings->hide_window != 'hide'): ?>
               <div class="btn-trial"><a class="btn slide" href="<?php echo $this->query_model->getTrialOfferUrl($settings->url_call_to_action); ?>" target="<?php if($site_settings[0]->window == 'new'): echo '_blank'; endif; ?>"> <?php $this->query_model->getStrReplace($settings->call_to_action); ?> </a></div>
			   
			   <?php if($settings->messenger_icon == 1){ ?>
               <ul class="user-menu nav navbar-nav navbar-right">
                  <li> <a href="https://m.me/ATA-Martial-Arts-Demo-Location-1705436799469161" target="_blank"> <img src="images/message-icon.png"></a> </li>
               </ul>
			   <?php } ?>
            </div>
			<?php endif; ?>
            <!-- /.navbar-collapse -->
         </div>
         <!-- /.container -->
      </nav>
	  
	  
	  
     
<script>

	$(document).ready(function(){
		
		$('#login-password').bind("enterKey",function(e){
			var password = $('#login-password').val();
   			
		});
		
		$('#login-password').keyup(function(e){
			if(e.keyCode == 13)
			{
				$(this).trigger("enterKey");
			}
		});


		$('.loginButton').click(function(){
			
			$('#loginform').removeAttr('action');
			
			var password = $('#login-password').val();
			
			var location_id = $('#school_location_id').val();
			
			checklogin(password,location_id);
		});
		
	});
	

 function checklogin(password,location_id){
 			$.ajax({ 					
				type: 'POST',						
				url: '<?php echo $current_url; ?>payment/checkstudentlogin',						
				data: { password : password,location_id: location_id}				
				}).done(function(msg){
				
				if(msg == 1){
					
					var redirect_url = '';
					<?php $password_setting = $this->query_model->getbyTable("tbl_password_pro");
					if($password_setting[0]->virtual_training == 1){
					?>
						 redirect_url = '/virtualtraining';
					<?php } ?>
					
					setTimeout("window.location.href='<?php echo $current_url; ?>students"+redirect_url+"'",1000);
				}
				else{
					$('.ErrorMsgNotLogin').show();
					$('.ErrorMsgNotLogin').html('<?php echo $this->query_model->getStaticTextTranslation('incorrect_password'); ?>');
					return false;					
				}
			});
}
</script>
<!--<div id="loginmodal" class="modal fade <?php echo $settings->ss_login_popup_class; ?>" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-xs">
    <div class="modal-content">
      <div class="modal-header" align="center">
       <button type="button" class="close student_section_login_btn" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2><?php echo $settings->ss_login_popup_text; ?></h2>
        
        </div>
      <div class="modal-body text-center">
      
       <div class="login-form">
          <form id="loginform" class="form-horizontal" role="form" method="post" action="<?php echo base_url().'payment/checkstudentloginToEnterKey' ?>">
		  				<span class="ErrorMsgNotLogin" style="display:none"><?php if($this->session->userdata('error_message') == 1){ echo $this->query_model->getStaticTextTranslation('incorrect_password'); }	 ?>
						</span>
						
						 <?php
						 
						 $multiSchool = $this->query_model->getbyTable("tblconfigcalendar");
						 $multiSchool = isset($multiSchool[11]) ? $multiSchool[11]->field_value : 0;
		
							$this->db->where("location_type", 'regular_link');
							/*if($multiSchool == 1){
								$this->db->where("main_location", 0);
							}*/
							$this->db->where("published", 1);
							$this->db->order_by("state","asc");
							$form_allLocations = $this->query_model->getbyTable("tblcontact"); 
							
							
							$multi_student_password = $this->query_model->getbySpecific("tblconfigcalendar",'id',15);
							$multi_student_password = !empty($multi_student_password) ? $multi_student_password[0]->field_value : 0;
						?>
						<?php if($multi_student_password == 1){ ?>
							<div style="margin-bottom: 25px" >
				 
				 
								<select class="form-control" name="location_id"style="height:40px" id="school_location_id">
							   <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_location'); ?></option>
									<?php foreach($form_allLocations as $location): ?>
										<option  value="<?=$location->id;?>" ><?php echo ucfirst($location->state.' - '.$location->name);?> </option>
									<?php endforeach;?>   
							  </select>
							</div>
						<?php }else{ ?>
							<input type="hidden" value="0" id="school_location_id">
						<?php } ?>
							
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                        <input id="login-password" type="password" class="form-control" name="password" placeholder="<?php echo $this->query_model->getStaticTextTranslation('password'); ?>">
                                    </div>
                                    
                                    <div class="login-btn">
                                      <a id="btn-login" href="javascript:void(0)" class="btn btn-theme btn-lg btn-block loginButton"><?php echo $this->query_model->getStaticTextTranslation('login'); ?>  </a>
                                    </div>  
					<?php $this->session->unset_userdata('error_message'); ?>
          </form>
       </div>
       
      </div>
    </div>
  </div>
</div> --->


  