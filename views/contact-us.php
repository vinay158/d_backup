<?php $this->load->view('includes/header'); ?>

<?php  $this->load->view('includes/header/masthead'); ?>
<?php $phoneNumberMaxLength = $this->query_model->phoneNumberMaxLength(); 

	  $getPhoneNumberClass = $this->query_model->getPhoneNumberClass(); 
	  
	  /*** getting gdpr text **/
 $gdprCompliantText = $this->query_model->getGdprCompliantText();
 $gdpr_compliant_txt1 = (isset($gdprCompliantText['gdpr_compliant_txt1'])) ? $gdprCompliantText['gdpr_compliant_txt1'] : '';
 $gdpr_compliant_txt2 = (isset($gdprCompliantText['gdpr_compliant_txt2'])) ? $gdprCompliantText['gdpr_compliant_txt2'] : '';
 $gdpr_compliant_submit_btn_text = (isset($gdprCompliantText['gdpr_compliant_submit_btn_text'])) ? $gdprCompliantText['gdpr_compliant_submit_btn_text'] : '';
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<!--<section class="mobile-contact">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 text-center"> <span class="no title-p"><?= $contactDetail->name; ?></span>
        <div class="row">
          <?php if($site_settings->hide_window != 'hide'): ?>
            <div class="col-xs-6 row-btn"> 
			<a class="btn btn-theme"  href="<?php echo $this->query_model->getTrialOfferUrl($site_settings->url_call_to_action); ?>" target="<?php if($site_settings->window == 'new'): echo '_blank'; endif; ?>"> 
			<?php $this->query_model->getStrReplace($site_settings->call_to_action); ?></a> 
			</div>
			<?php endif; ?><div class="col-xs-6 row-btn"> 
		  	<?php if($multiLocation[0]->field_value == 1 ){ ?>
				<a class="btn btn-theme" href="javascript:void(0);"  target="_blank"> <i class="fa fa-map-marker"></i> <?php echo ' '.count($allLocations).' '.$this->query_model->getStaticTextTranslation('locations'); ?></a>
			<?php } else{ ?>
		  	<a class="btn btn-theme" href="<?php echo  $this->query_model->getFindUs($contactDetail->address,$contactDetail->suite,$contactDetail->city,$contactDetail->state,$contactDetail->zip); ?>"  target="_blank"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?> </a> 
			<?php } ?> 
			
			</div>
        </div>
      </div>
      <div class="clearfix"></div>
    
    </div>
  </div>
</section> -->

<section id="main-address">
  <div class="container">
    <div class="row">
     
      <div class="col-md-8 col-xs-12 col-sm-6 col-md-push-4">
        <div class="address">
          <h2><?=  $this->query_model->getStrReplace($contactDetail->name); ?></h2>
          <h4><i class="fa fa-phone"></i><?=  $contactDetail->phone; ?></h4>
          <h4><i class="fa fa-map-marker"></i><?php if($contactDetail->address != ''){ echo $contactDetail->address.','; } ?>
				<?php if($contactDetail->suite != ''){ echo $contactDetail->suite.','; } ?>
				<?php if($contactDetail->city != ''){ echo $contactDetail->city.','; } ?>
				<?php if($contactDetail->state != ''){ echo $contactDetail->state.' '; } ?>
				<?php if($contactDetail->zip != ''){ echo $contactDetail->zip; } ?></h4>
          <p><?= $this->query_model->getDescReplace($contactDetail->content); ?></p>
        </div>
        <div class="social-ul pull-left">
		<?php 
		$social_contact_icon_details = $this->query_model->getSocialContactIcons($contactDetail);
		//echo '<pre>'; print_r($social_contact_icon_details); die;
		if(!empty($social_contact_icon_details)){
				
					$social_contact_twitter = $social_contact_icon_details->twitter;
					$social_contact_fb = $social_contact_icon_details->fb;
				//	$social_contact_logo = $social_contact_icon_details->sitelogo;		
					$social_contact_gplus = $social_contact_icon_details->gplus;
					$social_contact_youtube = $social_contact_icon_details->youtube;
					$social_contact_instagram = $social_contact_icon_details->instagram;
					$social_contact_yelp = $social_contact_icon_details->yelp;
					$social_contact_linkedIn = $social_contact_icon_details->linkedIn;
					$social_contact_vimeo = $social_contact_icon_details->vimeo;
					$google_reviews = $social_contact_icon_details->google_reviews;
					$facebook_reviews = $social_contact_icon_details->facebook_reviews;
	
		?>
           <ul>
		    
		    <?php if($social_contact_fb != ''): ?><li class="social-facebook"><a href="<?= $social_contact_fb; ?>" target="_blank"><i class="fa fa-facebook"></i></a></li><?php endif; ?>
            <?php if($social_contact_twitter != ''): ?><li class="social-twitter"><a href="<?= $social_contact_twitter; ?>" target="_blank"><i class="fa fa-twitter"></i></a></li><?php endif; ?>
            <?php if($social_contact_instagram != ''): ?><li class="social-instagram"><a href="<?= $social_contact_instagram; ?>" target="_blank"><i class="fa fa-instagram"></i></a></li><?php endif; ?>
            <?php if($social_contact_gplus != ''): ?><li class="social-google"><a href="<?= $social_contact_gplus; ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li><?php endif; ?>
            <?php if($social_contact_youtube != ''): ?><li class="social-youtube"><a href="<?= $social_contact_youtube; ?>" target="_blank"><i class="fa fa-youtube-square"></i></a></li><?php endif; ?>
            <?php if($social_contact_vimeo != ''): ?><li class="social-vimeo"><a href="<?= $social_contact_vimeo; ?>" target="_blank"><i class="fa fa-vimeo-square"></i></a></li><?php endif; ?>
			<?php if($social_contact_yelp != ''): ?><li class="social-yelp"><a href="<?= $social_contact_yelp; ?>" target="_blank"><i class="fa fa-yelp"></i></a></li><?php endif; ?>
			<?php if($social_contact_linkedIn != ''): ?><li class="social-linkedin"><a href="<?= $social_contact_linkedIn; ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li><?php endif; ?> 
			
			
			<?php if($facebook_reviews != ''): ?><li class="fb-review"><a href="<?= $facebook_reviews; ?>/reviews/" target="_blank"><img src="images/fbreviews.jpg"></a></li><?php endif; ?> 
			
			<?php if($google_reviews != ''): ?><li class="fb-review"><a href="https://search.google.com/local/writereview?placeid=<?= $google_reviews; ?>" target="_blank"><img src="images/googlereviews.jpg"></a></li><?php endif; ?> 
			
       </ul>
		<?php } ?>
        </div>
      </div>
       <div class="col-md-4 col-xs-12 col-sm-6 col-md-pull-8">
        <div class="working-hours">
          <h3><?php echo $this->query_model->getStaticTextTranslation('hours_of_opreation'); ?></h3>
          <div class="clearfix"></div>
		  <?php $today = date('l'); ?>
          <ul>
           	<?php foreach($contactTime as $contact_time){ ?>
		   	 <li <?php if($today == $contact_time->week_day): echo 'class = active'; endif; ?>>
			 	<a href="#"><span class="day"><?= $contact_time->week_day ?> </span> <span class="timing">
					<?php if($contact_time->closed != 1 && $contact_time->custom_text_checkbox != 1){ 
							$start_time = $contact_time->start_hour.':'.$contact_time->start_min.' '.$contact_time->start_am_pm;
							
							$end_time = $contact_time->end_hour.':'.$contact_time->end_min.' '.$contact_time->end_am_pm;
							
							echo $start_time.' - '.$end_time;
						} else{
							if($contact_time->custom_text_checkbox == 1){
								if(!empty($contact_time->custom_text)){ echo $contact_time->custom_text; } else{ echo $this->query_model->getStaticTextTranslation('closed'); }
							}else{
								echo $this->query_model->getStaticTextTranslation('closed');
							}
							
						}
					?>
					
					</span> 
				</a> 
			</li>
			<?php } ?>
			
         
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

	 
 <?php if($multiSchool == 1){ ?>   
<section id="find-location">
         <div class="container">
            <div class="row text-center">
               <div class="col-md-3">
                  <h2><?php echo $this->query_model->getStaticTextTranslation('find_location'); ?></h2>
				</div>
	<?php $formPageUrl = !empty($_SERVER['REDIRECT_QUERY_STRING']) ? ltrim($_SERVER['REDIRECT_QUERY_STRING'], '/') : ''; ?>
    <form method="get" class="inline-box" action="<?php echo base_url().$formPageUrl; ?>#map_div5">
	<div class="col-md-3">
               
    <div class="inline_mid_form ">
        <select id="dropdown-states" name="state" class="contact-form-line">
            <option><?php echo $this->query_model->getStaticTextTranslation('choose_state'); ?></option>
            <?php

            if(!empty($uniqueStatesList)){
            	$state = '';
            	 if(isset($_GET['state']) && !empty($_GET['state'])){
					    $state = $_GET['state'];

					  }
            	foreach ($uniqueStatesList as $states) {
            		?>
            		<option value="<?php echo $states->state ;?>"  <?php if($state == $states->state ){ echo 'selected=selected'; } ?>  ><?php echo $states->state ;?></option>
        <?php
            	}
            }
        ?>
          
        </select> 
    </div>
	</div>
	
    <div class="col-md-6">
               
      <div class=" inline-box ">

       <div id="ajax-dropdown-city"></div>
    </div>
	</div>
    </form> 
    
               </div>
            </div>
         </div>
      </section>
 <?php } ?>
 
<div class="clearfix"></div>
<section class="map-main">
  <div id="location-map">
    <div id="map_div5"></div>
  </div>
  
  <!-- form -->
 <!-- <section class="mobile-contact">
    <div class="container">
      <div class="row">
       <div class="col-sm-12 text-center"> <span class="no title-p"><?= $contactDetail->name; ?></span>
        <div class="row">
          <?php if($site_settings->hide_window != 'hide'): ?>
            <div class="col-xs-6 row-btn"> 
			<a class="btn btn-theme"  href="<?php echo $this->query_model->getTrialOfferUrl($site_settings->url_call_to_action); ?>" target="<?php if($site_settings->window == 'new'): echo '_blank'; endif; ?>"> 
			<?php $this->query_model->getStrReplace($site_settings->call_to_action); ?></a> 
			</div>
			<?php endif; ?><div class="col-xs-6 row-btn"> 
		  	<?php if($multiLocation[0]->field_value == 1 ){ ?>
				<a class="btn btn-theme" href="javascript:void(0);"  target="_blank"> <i class="fa fa-map-marker"></i> <?php echo ' '.count($allLocations).' '.$this->query_model->getStaticTextTranslation('locations'); ?></a>
			<?php } else{ ?>
		  	<a class="btn btn-theme" href="<?php echo  $this->query_model->getFindUs($contactDetail->address,$contactDetail->suite,$contactDetail->city,$contactDetail->state,$contactDetail->zip); ?>"  target="_blank"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?> </a> 
			<?php } ?> 
			
			</div>
        </div>
      </div>
      </div>
    </div>
  </section> -->
  <div class="outer-form">
    <script>
		$(document).ready(function(){
			
			
		$('.contactFormSubmit2').click(function(){
		
					var err = 0
					var name=$('#first_name2').val();
					//alert(name); return false;
					if(name.length == 0){
						var err = 1;
						$('#first_name2').after('<div class="reds name_error2"><?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?></div>');
					}else{
						if(! /\s/g.test(name)){
							var err = 1;
							$('#first_name2').after('<div class="reds name_error2"><?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?></div>');
						}
					}
					
					/*var last_name=$('#last_name2').val();
					if(last_name.length == 0){
						var err = 1;
						$('#last_name2').after('<div class="reds last_name_error2"><?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?></div>');
					}*/
					
					/*var telephone=$('#telephone2').val();
					<?php if($site_settings->phone_required == 1){ ?>
                                                 <?php if($site_settings->international_phone_fields != 1){ ?>
					if(telephone.length <= 11 || telephone.length == 0){
						var err = 1;
						$('#telephone2').after('<div class="reds phone_error2"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
						
					} 
                                        <?php } } ?> */
					
					var telephoneId = 'telephone2';
					var phoneError = 'phone_error2';
					var telephone=$('#'+telephoneId).val();
					<?php 
						if($site_settings->international_phone_fields != 1){
							if($site_settings->phone_required == 1){ ?>
						if(telephone.length <= <?php echo $phoneNumberMaxLength - 1; ?> || telephone.length == 0){
							var err = 1;
							$('#'+telephoneId).after('<div class="reds '+phoneError+'"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
							
						} 
						<?php //}
						}else{ ?>
						
							if(telephone.length <= <?php echo $phoneNumberMaxLength - 1; ?> && telephone.length > 0){
									$('#'+telephoneId).after('<div class="reds '+phoneError+' "><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
									var err = 1;
								}else{
									//var err = 0;
									$('.'+phoneError).hide();
								}
					<?php 	} 
						}else{
							if($site_settings->phone_required == 1){
					?>
					
					
						var filter = /^[- +()]*[0-9][- +()0-9]*$/;
						if (filter.test(telephone)) {
							$('.'+phoneError).hide();
						}
						else {
							$('#'+telephoneId).after('<div class="reds '+phoneError+'"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
							var err = 1;
						}	
					<?php }else{ ?>
							if(telephone.length == 0){
								$('.'+phoneError).hide();
							}else{
								var filter = /^[- +()]*[0-9][- +()0-9]*$/;
								if (filter.test(telephone)) {
									$('.'+phoneError).hide();
								}
								else {
									$('#'+telephoneId).after('<div class="reds '+phoneError+'"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
									var err = 1;
								}	
							}	
					<?php		}	?> 
					
					<?php }?>
						
					
					var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
					var email=$('#form_email2').val();
					if(email.length == 0 || emailfilter.test($("#form_email2").val()) == false){
						var err = 1;
						$('#form_email2').after('<div class="reds email_error2"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
					}
					
					
					
					<?php if($multiLocation[0]->field_value == 1 ){ ?>
					var school=$('#school2').val();
					if(school == '' || school == null){
						var err = 1;
						$('#school2').after('<div class="reds school_name_error2"><?php echo $this->query_model->getStaticTextTranslation('select_your_location'); ?></div>');
					}
					<?php } ?>
					
					var message=$('#message2').val();
					//alert(name); return false;
					if(message.length == 0){
						var err = 1;
						$('#message2').after('<div class="message_error message_error2"><?php echo $this->query_model->getStaticTextTranslation('enter_your_message'); ?></div>');
					}
					
					<?php /*if($this->query_model->get_gdpr_compliant() == 1){?>
						var gdpr_compliant_id= 'gdpr_compliant_2';
						var gdpr_compliant_error= 'gdpr_compliant_error2';
						if($('#'+gdpr_compliant_id).is(":checked")){
							$('.'+gdpr_compliant_error).hide();
						}else{
							var err = 1;
							$('#'+gdpr_compliant_id).after('<div class="reds '+gdpr_compliant_error+'"><?php echo $this->query_model->getStaticTextTranslation('receiving_information'); ?></div>');
						}
					<?php }*/ ?>
					
					
					//alert(err); return false;
					if(err == 0){
						return true;
					} else{
						return false;
					}
			
			});
			
			
			$('#first_name2').keyup(function(){
					if($(this).val().length > 0){
						$('.name_error2').hide();
					} else{
						$('#first_name2').after('<div class="reds name_error2"><?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?></div>');
						
					}
			});
			
			$('#last_name2').keyup(function(){
					if($(this).val().length > 0){
						$('.last_name_error2').hide();
					} else{
						$('#last_name2').after('<div class="reds last_name_error2"><?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?></div>');
						
					}
			});
			
			$('#telephone2').keyup(function(){
					/*if($(this).val().length <= 11){
						
						<?php if($site_settings->phone_required == 0){ ?>
							if($(this).val().length == 0){
								$('.phone_error2').hide();
							}else{
                                                               <?php if($site_settings->international_phone_fields == 1){ ?>
                                                                $('.phone_error2').hide();
                                                            <?php  }else{ ?>
								$('#telephone2').after('<div class="reds phone_error2"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
                                                            <?php  } ?>
							}
						<?php }else{ ?>
                                                            <?php if($site_settings->international_phone_fields == 1){ ?>
                                                                $('.phone_error2').hide();
                                                            <?php  }else{ ?>
								$('#telephone2').after('<div class="reds phone_error2"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
                                                            <?php  } ?>
						<?php } ?>
					} 
					
					if($(this).val().length == 12){
						$('.phone_error2').hide();
						
					} */
					
					$('.phone_error2').hide();
			});
			
			
			$('#form_email2').keyup(function(){
					if($(this).val().length > 0){
						$('.email_error2').hide();
					} else{
						$('#form_email2').after('<div class="reds email_error2"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
						
					}
			});
			
			
			<?php if($multiLocation[0]->field_value == 1 ){ ?>
			$('#school2').change(function(){
					if($(this).val() != ''){
						$('.school_name_error2').hide();
					} else{
						$('.school_name_error2').show();
						$('#school2').after('<div class="reds school_name_error2"><?php echo $this->query_model->getStaticTextTranslation('select_your_location'); ?></div>');
						
					}
			});
			<?php } ?>
			
			$('#message2').keyup(function(){
					if($(this).val().length > 0){
						$('.message_error2').hide();
					} else{
						$('#message2').after('<div class="message_error message_error2"><?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?></div>');
						
					}
			});
			
			
			<?php /*if($this->query_model->get_gdpr_compliant() == 1){?>
					var gdpr_compliant_id= 'gdpr_compliant_2';
					var gdpr_compliant_error= 'gdpr_compliant_error2';
					$('#'+gdpr_compliant_id).click(function(){
							if($(this).is(':checked')){
								$('.'+gdpr_compliant_error).hide();
							}else{
								$('.'+gdpr_compliant_error).show();
							}
						})
				<?php }*/ ?>  
			
		});

	</script>	
      <form class="d-bg-c contact-form content_contact_form"action="contactus/send" method="post">
	  <?php echo $this->query_model->getCaptchaInputFields('contact_us_form'); ?>
	 <input type="hidden" name="hid_location" value="<?= !empty($contactDetail) ? $contactDetail->id : '' ?>" />
	  <div class="message">
				<div id="alert"></div>
	  </div>
        <div style="position:relative;">
          <input type="text" name="name" id="first_name2"  class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('first_name'); ?>" onFocus="this.placeholder = ''" onBlur="textAlphabatic(this)" maxlength="<?php echo $this->query_model->fullNameInputMaxLength(); ?>" error_class="name_error2" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?>" >
          <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
          <div style="position:relative;" class="optinlastname">
          <input type="text" name="last_name" id="last_name2" class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('last_name'); ?>" onFocus="this.placeholder = ''" onBlur="textAlphabatic(this)" maxlength="25" error_class="last_name_error" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?>">
          <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
        <div style="position:relative;">
          <input type="text" name="phone" id="telephone2" class="contact-form-line <?php echo $getPhoneNumberClass; ?>" placeholder="<?php echo $this->query_model->getStaticTextTranslation('phone'); ?>" onFocus="this.placeholder = ''"  error_class="phone_error2" onBlur="phoneValidation(this)" maxlength="<?php echo $phoneNumberMaxLength; ?>" >
          <span class="fa fa-phone form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
		  <input type="text" id="fax" name="fax" class="optinfax"   placeholder="Fax Number" value="">

        <div style="position:relative;">
          <input type="email"  name="form_email_2" id="form_email2"  class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('email'); ?>" onFocus="this.placeholder = ''" onBlur="this.placeholder = '<?php echo $this->query_model->getStaticTextTranslation('email'); ?>'">
          <span class="fa fa-envelope form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
       
	    <div style="position:relative;">
		<?php if($multiLocation[0]->field_value == 1){ ?>
          <select class="locationBox contact-form-line getContactPageUrl" id="school2" name="school">
            <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_location'); ?></option>
					<?php foreach($allLocations as $location): ?>
						<option  value="<?=$location->name;?>" <?php if($contactDetail->id == $location->id){ echo 'selected=selected'; } ?> slug="<?=$location->slug;?>"><?=$location->name;?> </option>
					<?php endforeach;?>   
          </select>
		  <?php } ?>
          <span class="fa fa-map-marker form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
		
        <div style="position:relative;"> <span class="site_theme_text fa fa-comment form-control-feedback move_input_icon" aria-hidden="true"></span>
          <textarea  name="message" id="message2" class="contact-form-area" placeholder="<?php echo $this->query_model->getStaticTextTranslation('message'); ?>" onFocus="this.placeholder = ''" onBlur="this.placeholder = '<?php echo $this->query_model->getStaticTextTranslation('message'); ?>'"></textarea>
        </div>
		
		<?php if(!empty($twilioApi)){?>
		<div style="position:relative;"> 
		   <div class=" twilio_checkbox" >
			  <input type="checkbox" class="contact-form-line" name="twilio_checkbox" value="1"> <?php echo $twilioApi->checkbox_text ?>
		   </div>
		 </div>
		 <?php } ?>
		 <input type="text" id="comment" name="comment" class="optincomment"   placeholder="Write your comment here..." value="">
<input type="checkbox" class="optincheck" name="contact_me_by_phone" value="1">
		  <?php if($this->query_model->get_gdpr_compliant() == 1){?>
		   <div style="position:relative;">
			<div class="email_optin_gdpr_compliant_checkbox" >
				<input type="hidden" name="ip_address" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
				
				<input type="checkbox" class="form-control" id="gdpr_compliant_2" name="gdpr_compliant_checkbox" value="1"><?php echo $gdpr_compliant_txt1; ?>
		   </div>
		   </div>
		 <?php } ?>
		 
		<input type="hidden" value="" name='email' id='email' class="submit button" style="display:none" />			
		<input type="text" id="website" name="website" class="optinwebsite"  placeholder="Website" value="">
<input type="text"  class="ywedobjeo" name="x2o3d_<?php echo $this->query_model->setAndGetUniqueNumberForCustomField(); ?>" value="<?php echo time(); ?>"  placeholder="Serial Number"/>
		<?php
			$contact_page_slug = $this->query_model->getConatctPageSlug($contactDetail->id);
		?>
		<input type="hidden" class="conatct_page_url" name="page_url" value="<?php echo !empty($contact_page_slug) ? $contact_page_slug : '/'; ?>" />
        <input type="submit" value="<?php echo $this->query_model->getStaticTextTranslation('send_message'); ?>" class="btn btn-readmore  btn-block submit button contactFormSubmit2">
      </form>
    <div class="clearfix"></div>
  </div>
</section>
<!-- map area -->
<?php if($multiSchool == 0){ ?>
 <?php if($multiLocation[0]->field_value == 1){ ?>
 <?php if(!empty($allLocations) && count($allLocations) >= 2): ?> 
<section class="location-title">
    <div class="container">
        <div class="row">
          <div class="text-center">
            <h2><?php echo $this->query_model->getStaticTextTranslation('our_locations'); ?>:</h2>
          </div>
        </div>
    </div>
</section>

<section class="map-list mobile-map-list">

    <div class="container">
	
    <div class="row ">
	
			<?php 
					$mapBoxClassArr = array(
											'2' => array('all_row' => 'col-lg-6 col-md-6 col-sm-6'),
											'3' => array('all_row' => 'col-lg-4 col-md-4 col-sm-4'),
											'4' => array('all_row' => 'col-lg-3 col-md-3 col-sm-6'),
											'5' => array('all_row' => 'col-md-13'),
											'6' => array('all_row' => 'col-lg-4 col-md-4 col-sm-4'),
											'7' => array('all_row' => 'col-lg-3 col-md-3 col-sm-6','last_row'=>'col-lg-4 col-md-4 col-sm-4'),
											'8' => array('all_row' => 'col-lg-3 col-md-3 col-sm-6'),
											'9' => array('all_row' => 'col-md-13','last_row'=>'col-lg-3 col-md-3 col-sm-6'),
											'10' => array('all_row' => 'col-md-13'),
											'11' => array('all_row' => 'col-lg-3 col-md-3 col-sm-6','last_row'=>'col-lg-4 col-md-4 col-sm-4'),
											'12' => array('all_row' => 'col-lg-3 col-md-3 col-sm-3'),
											'13' => array('all_row' => 'col-md-13','last_row'=>'col-lg-4 col-md-4 col-sm-4'),
											'14' => array('all_row' => 'col-md-13','last_row'=>'col-lg-3 col-md-3 col-sm-3'),
											'15' => array('all_row' => 'col-md-13')
										);
					
					$i = 1;
					foreach($allLocations as $location){
						
						$total_location = count($allLocations);
						$map_box_cls = 'col-lg-4 col-md-4 col-sm-4';
						
						if(isset($mapBoxClassArr[$total_location]['all_row'])){
							
							if(isset($mapBoxClassArr[$total_location]['last_row'])){
								
								$modules_number = ($total_location == 9 || $total_location == 13 || $total_location == 14) ? 5 : 4;
								
								$last_row_numbers =  $total_location - ($total_location % $modules_number);
								
								if($i > $last_row_numbers){
									$map_box_cls = $mapBoxClassArr[$total_location]['last_row'];
								}else{
									$map_box_cls = $mapBoxClassArr[$total_location]['all_row'];
								}
								
							}else{
								$map_box_cls = $mapBoxClassArr[$total_location]['all_row'];
							}
						}
						
						
				?>
					<div class="<?php echo $map_box_cls; ?> col-xs-12">
					  <?php $address1 =  $this->query_model->getFullAddress($location->address,$location->suite,$allLocations[0]->city,$location->state,$location->zip); ?>   		
					  <h2><a href="<?= $contact_slug->slug.'/'.$location->slug; ?>" class="contactMapTitle"><?= $location->name; ?></a></h2>
					  <p class="normal_text"><?php echo  $address1; ?></p>
					  <div class="map-btn">
						 <button class="btn btn-theme"> <a href="tel:<?= $location->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $location->phone ?></a></button>
						 <a class="" href="<?php echo  $this->query_model->getFindUs($location->address,$location->suite,$location->city,$location->state,$location->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
						 <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$location->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
					  </div>
					  <div id="location_map_<?php echo $i; ?>" class="map_manage  hidden-xs"></div>
				   </div>
			   <?php $i++; } ?>
			   
	
  </div>
</section>
<?php endif; ?>
<?php } } ?>

<?php if(!empty($contactDetail->seo_text)){ ?>
<div class="description-txt">
  <div class="container">
    <div class="row">
      <div class="inner-desc preColoums">
	  		
			<p class="preDescription"><?= $this->query_model->getDescReplace($contactDetail->seo_text); ?></p>
			
       </div>
    </div>
  </div>
</div>
<?php } ?>


<?php 
	$city = '';
	 if(isset($_GET['city']) && !empty($_GET['city'])){
			$city = $_GET['city'];

	}
?>
<script>
$(window).load(function(){

		// get cities, on click dropdown states
			var stateName = $( "#dropdown-states option:selected" ).val();
			//alert(stateName);
			if(stateName != 'Choose State'){
					$.ajax({

						url : '<?php echo base_url("site/getCityData"); ?>',
						type : 'POST',
						data :{stateName:stateName, cityName:'<?php echo $city; ?>'},
						success:function(data){
	                    $('#ajax-dropdown-city').html(data);
	                	}

				});
			}
			
				

	});
$(document).ready(function(){
	// get cities, on click dropdown states
			$('#dropdown-states').change(function(){
				var stateName = $(this).val();
				//$('.map_div5').removeAttr('id');
				//$('.map_div5').attr('id', 'map_div5_new'); 
				//alert(newid);
				$.ajax({

						url : '<?php echo base_url("site/getCityData"); ?>',
						type : 'POST',
						data :{stateName:stateName},
						success:function(data){
	                    $('#ajax-dropdown-city').html(data);
	                	}

				});

			});
})
</script>

<!--
<script src="js/new/jquery.maskedinput.js"></script>
<script type="text/javascript">
jQuery(function($){
   $(".phone_number").mask("999-999-9999",{placeholder:""});
});
</script>-->
<?php $this->load->view('includes/footer'); ?>

<?php $forms = array('contact_us_form');
echo $this->query_model->getGoogleCaptchaScript($forms); ?>

