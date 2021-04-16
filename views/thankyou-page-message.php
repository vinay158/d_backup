<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
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

<script>
$(document).ready(function(){
		
		// disble browser go back button 	
		window.history.pushState(null, "", window.location.href);        
        window.onpopstate = function() {
			//setTimeout("window.location.href='<?php echo base_url().'starttrial/distoryTrialSession'; ?>'",500);
            window.history.pushState(null, "", window.location.href);
        };
		
		window.addEventListener("popstate", function(e) {
			alert('pass'+location.pathname);
			loadPage(location.pathname);
		});
		
});
</script>

<section class="success">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <h2><?php echo $this->query_model->getStaticTextTranslation('success'); ?>!</h2>
        </div>
      </div>
    </div>
  </section>
<section class="section" id="upgrade">
         <div class="container">
            <div class="row">
			<div class="col-md-10 col-md-push-1">
                  <div class="upgrade-block">
			<?php 
				if(!empty($thankyou_message)){
				$this->query_model->getDescReplace($thankyou_message);
				}
			?>
      </div>
      
    </div>
  </div>
  </div>
 </section>
  
  
  
	
	
	<section class="map-main">
    <div id="location-map">
      <div id="map_div5"></div>
    </div>
    <!-- form -->
	
   <!-- <section class="mobile-contact">
      <div class="container">
        <div class="row">
           <div class="col-sm-12 text-center"> 
		
		  <a href="tel:<?= $mainLocation[0]->phone ?>" class="callNow"><span class="no"><?= $mainLocation[0]->phone ?></span></a>
          <p class="normal_text">
		  	<?php echo  $this->query_model->getFullAddress($mainLocation[0]->address,$mainLocation[0]->suite,$mainLocation[0]->city,$mainLocation[0]->state,$mainLocation[0]->zip); ?>
		</p>
		
          <div class="row">
            <?php if($site_settings[0]->hide_window != 'hide'): ?>
            <div class="col-xs-6 row-btn"> 
			<a class="btn btn-theme"  href="<?php echo $this->query_model->getTrialOfferUrl($site_settings[0]->url_call_to_action); ?>" target="<?php if($site_settings[0]->window == 'new'): echo '_blank'; endif; ?>"> 
			<?php $this->query_model->getStrReplace($site_settings[0]->call_to_action); ?></a> 
			</div>
			<?php endif; ?><div class="col-xs-6 row-btn"> 
			<?php if($multiLocation[0]->field_value == 1 ){ ?>
				<a class="btn btn-theme" href="javascript:void(0);"  target="_blank"> <i class="fa fa-map-marker"></i> <?php echo ' '.count($allLocations).' '.$this->query_model->getStaticTextTranslation('locations'); ?></a>
			<?php } else{ ?>
			<a class="btn btn-theme" href="<?php echo  $this->query_model->getFindUs($mainLocation[0]->address,$mainLocation[0]->suite,$mainLocation[0]->city,$mainLocation[0]->state,$mainLocation[0]->zip); ?>"  target="_blank"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?> </a>
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
				
		$('.contactFormSubmit1').click(function(){
		
					var err = 0
					var name=$('#first_name1').val();
					//alert(name); return false;
					if(name.length == 0){
						var err = 1;
						$('#first_name1').after('<div class="reds name_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?></div>');
					}else{
						if(! /\s/g.test(name)){
							var err = 1;
							$('#first_name1').after('<div class="reds name_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?></div>');
						}
					}
					
					/*var last_name=$('#last_name1').val();
					if(last_name.length == 0){
						var err = 1;
						$('#last_name1').after('<div class="reds last_name_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?></div>');
					}*/
					
					/*var telephone=$('#telephone1').val();
					<?php if($site_settings[0]->phone_required == 1 ){ ?>
                                                <?php if($site_settings[0]->international_phone_fields != 1){ ?>
						if(telephone.length <= 11 || telephone.length == 0){
							var err = 1;
							$('#telephone1').after('<div class="reds phone_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
							
						} 
                    <?php } } ?> */
					var telephoneId = 'telephone1';
					var phoneError = 'phone_error1';
					var telephone=$('#'+telephoneId).val();
					<?php 
						if($site_settings[0]->international_phone_fields != 1){
							if($site_settings[0]->phone_required == 1){ ?>
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
							if($site_settings[0]->phone_required == 1){
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
					var email=$('#form_email1').val();
					if(email.length == 0 || emailfilter.test($("#form_email1").val()) == false){
						var err = 1;
						$('#form_email1').after('<div class="reds email_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
					}
					//school1
					
					<?php if($multiLocation[0]->field_value == 1 ){ ?>
					var school=$('#school1').val();
					if(school == '' || school == null){
						var err = 1;
						$('#school1').after('<div class="reds school_name_error1"><?php echo $this->query_model->getStaticTextTranslation('select_your_location'); ?></div>');
					}
					<?php } ?>
					
					var message=$('#message1').val();
					//alert(name); return false;
					if(message.length == 0){
						var err = 1;
						$('#message1').after('<div class="message_error message_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_your_message'); ?></div>');
					}
					
					
					<?php /*if($this->query_model->get_gdpr_compliant() == 1){?>
						var gdpr_compliant_id= 'gdpr_compliant_1';
						var gdpr_compliant_error= 'gdpr_compliant_error1';
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
			
			
			$('#first_name1').keyup(function(){
					if($(this).val().length > 0){
						$('.name_error1').hide();
					} else{
						$('#first_name1').after('<div class="reds name_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?></div>');
						
					}
			});
			
			$('#last_name1').keyup(function(){
					if($(this).val().length > 0){
						$('.last_name_error1').hide();
					} else{
						$('#last_name1').after('<div class="reds last_name_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?></div>');
						
					}
			});
			
			

			$('#telephone1').keyup(function(){
					/*if($(this).val().length <= 11){
						
						<?php if($site_settings[0]->phone_required == 0){ ?>
							if($(this).val().length == 0){
								$('.phone_error1').hide();
							}else{
                                                             <?php if($site_settings[0]->international_phone_fields == 1){ ?>
                                                                $('.phone_error1').hide();
                                                            <?php  }else{ ?>
								$('#telephone1').after('<div class="reds phone_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
                                                            <?php  } ?>
							}
						<?php }else{ ?>
                                                             <?php if($site_settings[0]->international_phone_fields == 1){ ?>
                                                                $('.phone_error1').hide();
                                                            <?php  }else{ ?>
								$('#telephone1').after('<div class="reds phone_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
						 <?php  } ?>
                                                <?php } ?>
						
					}
					
					if($(this).val().length == 12){
						$('.phone_error1').hide();
						
					} */
					
					$('.phone_error1').hide();
			});
			
			
			$('#form_email1').keyup(function(){
					if($(this).val().length > 0){
						$('.email_error1').hide();
					} else{
						$('#form_email1').after('<div class="reds email_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
						
					}
			});
			
			<?php if($multiLocation[0]->field_value == 1 ){ ?>
			$('#school1').change(function(){
					if($(this).val() != ''){
						$('.school_name_error1').hide();
					} else{
						$('.school_name_error1').show();
						$('#school1').after('<div class="reds school_name_error1"><?php echo $this->query_model->getStaticTextTranslation('select_your_location'); ?></div>');
						
					}
			});
			<?php } ?>
			
			$('#message1').keyup(function(){
					if($(this).val().length > 0){
						$('.message_error1').hide();
					} else{
						$('#message1').after('<div class="message_error message_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?></div>');
						
					}
			});
			
			<?php /*if($this->query_model->get_gdpr_compliant() == 1){?>
				var gdpr_compliant_id= 'gdpr_compliant_1';
				var gdpr_compliant_error= 'gdpr_compliant_error1';
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
	
     <form class="d-bg-c contact-form content_contact_form"action="contactus/send" method="post" >
	  <?php echo $this->query_model->getCaptchaInputFields('contact_us_form'); ?>
	 <input type="hidden" name="hid_location" value="<?= !empty($contactDetail) ? $contactDetail->id : '' ?>" />
	  <div class="message">
				<div id="alert"></div>
	  </div>
	    <div style="position:relative;">
		
          <input type="text" name="name" id="first_name1"  class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('first_name'); ?>" onFocus="this.placeholder = ''"   onBlur="textAlphabatic(this)" maxlength="<?php echo $this->query_model->fullNameInputMaxLength(); ?>" error_class="name_error1" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?>" >
          <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
          <div style="position:relative;" class="optinlastname">
          <input type="text" name="last_name" id="last_name1" class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('last_name'); ?>" onFocus="this.placeholder = ''"  onBlur="textAlphabatic(this)" maxlength="25" error_class="last_name_error1" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?>" >
          <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
        <div style="position:relative;">
          <input type="text" name="phone"id="telephone1" class="contact-form-line <?php echo $getPhoneNumberClass; ?>" placeholder="<?php echo $this->query_model->getStaticTextTranslation('phone'); ?>" onFocus="this.placeholder = ''"  error_class="phone_error1" onBlur="phoneValidation(this)" maxlength="<?php echo $phoneNumberMaxLength; ?>" >
          <span class="fa fa-phone form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
		  <input type="text" id="fax" name="fax" class="optinfax"   placeholder="Fax Number" value="">

        <div style="position:relative;">
          <input type="email"  name="form_email_2" id="form_email1"  class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('email'); ?>" onFocus="this.placeholder = ''" onBlur="this.placeholder = '<?php echo $this->query_model->getStaticTextTranslation('email'); ?>'">
          <span class="fa fa-envelope form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
         
		<div style="position:relative;">
		<?php if($multiLocation[0]->field_value == 1 ){ ?>
          <select class="locationBox contact-form-line getContactPageUrl" id="school1" name="school">
            <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_location'); ?></option>
					<?php foreach($form_allLocations as $location): ?>
						<option  value="<?=$location->name;?>" <?php //if($mainLocation[0]->id == $location->id){ echo 'selected=selected'; }?> slug="<?=$location->slug;?>"><?=$location->name;?> </option>
					<?php endforeach;?>   
          </select>
		  <?php } ?>
          <span class="fa fa-map-marker form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
		  
		
        <div style="position:relative;"> <span class="site_theme_text fa fa-comment form-control-feedback move_input_icon" aria-hidden="true"></span>
          <textarea  name="message" id="message1" class="contact-form-area" placeholder="<?php echo $this->query_model->getStaticTextTranslation('message'); ?>" onFocus="this.placeholder = ''" onBlur="this.placeholder = '<?php echo $this->query_model->getStaticTextTranslation('message'); ?>'"></textarea>
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
				
				<input type="checkbox" class="form-control" id="gdpr_compliant_1" name="gdpr_compliant_checkbox" value="1"><?php echo $gdpr_compliant_txt1; ?>
		   </div>
		   </div>
		 <?php } ?>
		
		<input type="hidden" value="" name='email' id='email' class="submit button" style="display:none" />			
		 <input type="text" id="website" name="website" class="optinwebsite"  placeholder="Website" value="">
<input type="text"  class="ywedobjeo" name="x2o3d_<?php echo $this->query_model->setAndGetUniqueNumberForCustomField(); ?>" value="<?php echo time(); ?>"  placeholder="Serial Number"/>
		<?php
			$contact_page_slug = $this->query_model->getConatctPageSlug();
		?>
		<input type="hidden" class="conatct_page_url" name="page_url" value="<?php echo !empty($contact_page_slug) ? $contact_page_slug : '/'; ?>" />
        <input type="submit" value="<?php echo $this->query_model->getStaticTextTranslation('send_message'); ?>" class="btn btn-readmore  btn-block submit button contactFormSubmit1">
      </form>
      <div class="clearfix"></div>
    </div>
  </section>
  

<?php $this->load->view('includes/footer'); ?>

<?php $forms = array('contact_us_form');
echo $this->query_model->getGoogleCaptchaScript($forms); ?>