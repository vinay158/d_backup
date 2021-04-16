<?php $site_settings = $this->query_model->getbyTable("tblsite"); ?>

<?php $phoneNumberMaxLength = $this->query_model->phoneNumberMaxLength(); 

	  $getPhoneNumberClass = $this->query_model->getPhoneNumberClass(); 
	  
	  $twilioApi = $this->query_model->getTwilioApiType();
	  
	  $multiSchoolOrLocation = $this->query_model->checkMultiSchoolOrLocationIsOn();
	  
	 
	/*** getting gdpr text **/
 $gdprCompliantText = $this->query_model->getGdprCompliantText();
 $gdpr_compliant_txt1 = (isset($gdprCompliantText['gdpr_compliant_txt1'])) ? $gdprCompliantText['gdpr_compliant_txt1'] : '';
 $gdpr_compliant_txt2 = (isset($gdprCompliantText['gdpr_compliant_txt2'])) ? $gdprCompliantText['gdpr_compliant_txt2'] : '';
 $gdpr_compliant_submit_btn_text = (isset($gdprCompliantText['gdpr_compliant_submit_btn_text'])) ? $gdprCompliantText['gdpr_compliant_submit_btn_text'] : '';
 
?>

		<script>
		
		$(window).load(function(){
			$.each( $( ".birthday_redio" ), function() {
				if($(this).attr('checked') == 'checked'){
					var redirection_type = $(this).attr('redirection_type');
					var trial_offer_id = $(this).attr('trial_offer_id');
					var dojocart_id = $(this).attr('dojocart_id');
					var third_party_url = $(this).attr('third_party_url');
					var thankyou_page_id = $(this).attr('thankyou_page_id');
					
					$('#redirection_type').val(redirection_type);
					
					if(redirection_type == "dojocart"){
						$('#redirection_value').attr('name','dojocart_id');
						$('#redirection_value').val(dojocart_id);
					}else if(redirection_type == "third_party_url"){
						$('#redirection_value').attr('name','third_party_url');
						$('#redirection_value').val(third_party_url);
					}else if(redirection_type == "thankyou_page"){
						$('#redirection_value').attr('name','thankyou_page_id');
						$('#redirection_value').val(thankyou_page_id);
					}else{
						$('#redirection_value').attr('name','trial_offer_id');
						$('#redirection_value').val(trial_offer_id);
					}
					
				}
			});
			
			$.each( $( ".reserve_or_schedule" ), function() {
				
				if($(this).attr('checked') == 'checked'){
					var redirection_type = $(this).attr('redirection_type');
					var trial_offer_id = $(this).attr('trial_offer_id');
					var dojocart_id = $(this).attr('dojocart_id');
					var third_party_url = $(this).attr('third_party_url');
					var thankyou_page_id = $(this).attr('thankyou_page_id');
					
					$('#redirection_type').val(redirection_type);
					
					if(redirection_type == "dojocart"){
						$('#redirection_value').attr('name','dojocart_id');
						$('#redirection_value').val(dojocart_id);
					}else if(redirection_type == "third_party_url"){
						$('#redirection_value').attr('name','third_party_url');
						$('#redirection_value').val(third_party_url);
					}else if(redirection_type == "thankyou_page"){
						$('#redirection_value').attr('name','thankyou_page_id');
						$('#redirection_value').val(thankyou_page_id);
					}else{
						$('#redirection_value').attr('name','trial_offer_id');
						$('#redirection_value').val(trial_offer_id);
					}
					
				}
			});
		})
		
		
		
		
		$(document).ready(function(){
			
			$('.birthday_redio').click(function(){
				var redirection_type = $(this).attr('redirection_type');
				var trial_offer_id = $(this).attr('trial_offer_id');
				var dojocart_id = $(this).attr('dojocart_id');
				var third_party_url = $(this).attr('third_party_url');
				var thankyou_page_id = $(this).attr('thankyou_page_id');
				
				$('#redirection_type').val(redirection_type);
				
				if(redirection_type == "dojocart"){
					$('#redirection_value').attr('name','dojocart_id');
					$('#redirection_value').val(dojocart_id);
				}else if(redirection_type == "third_party_url"){
					$('#redirection_value').attr('name','third_party_url');
					$('#redirection_value').val(third_party_url);
				}else if(redirection_type == "thankyou_page"){
						$('#redirection_value').attr('name','thankyou_page_id');
						$('#redirection_value').val(thankyou_page_id);
				}else{
					$('#redirection_value').attr('name','trial_offer_id');
					$('#redirection_value').val(trial_offer_id);
				}
				
				if($(this).val() == 'call'){
					$('#schedule_party').attr('checked', false);
					$('#more_info').attr('checked', true); 
					$('.callDiv').hide();
				} else{
					$('#schedule_party').attr('checked', true);
					$('#more_info').attr('checked', false); 
					$('.callDiv').show();
				}
				
				
			});
			
			$('.reserve_or_schedule').click(function(){
				var redirection_type = $(this).attr('redirection_type');
				var trial_offer_id = $(this).attr('trial_offer_id');
				var dojocart_id = $(this).attr('dojocart_id');
				var third_party_url = $(this).attr('third_party_url');
				var thankyou_page_id = $(this).attr('thankyou_page_id');
				
				$('#redirection_type').val(redirection_type);
				
				if(redirection_type == "dojocart"){
					$('#redirection_value').attr('name','dojocart_id');
					$('#redirection_value').val(dojocart_id);
				}else if(redirection_type == "third_party_url"){
					$('#redirection_value').attr('name','third_party_url');
					$('#redirection_value').val(third_party_url);
				}else if(redirection_type == "thankyou_page"){
						$('#redirection_value').attr('name','thankyou_page_id');
						$('#redirection_value').val(thankyou_page_id);
				}else{
					$('#redirection_value').attr('name','trial_offer_id');
					$('#redirection_value').val(trial_offer_id);
				}
				
				if($(this).val() == 'call'){
					$('#schedule_party').attr('checked', false);
					$('#more_info').attr('checked', true); 
					$('.callDiv').hide();
				} else{
					$('#schedule_party').attr('checked', true);
					$('#more_info').attr('checked', false); 
					$('.callDiv').show();
				}
				
				
			});
		$('.bdayFormSubmit').click(function(){
		
					var err = 0
					var name=$('#first_name').val();
					//alert(name); return false;
					if(name.length == 0){
						var err = 1;
						$('#first_name').after('<div class="reds name_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?></div>');
					}else{
						if(! /\s/g.test(name)){
							var err = 1;
							$('#first_name').after('<div class="reds name_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?></div>');
						}
					}
					
					/*var last_name=$('#last_name').val();
					//alert(name); return false;
					if(last_name.length == 0){
						var err = 1;
						$('#last_name').after('<div class="reds last_name_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?></div>');
					}*/
					
					
					
					/*var telephone=$('#telephone').val();
					<?php if($site_settings[0]->phone_required == 1){ ?>
					if(telephone.length <= 11 || telephone.length == 0){
						var err = 1;
						$('#telephone').after('<div class="reds phone_error">Enter a valid phone number</div>');
						
					} 
					<?php } ?> */
					
					var telephoneId = 'telephone';
					var phoneError = 'phone_error';
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
					var email=$('#form_email').val();
					if(email.length == 0 || emailfilter.test($("#form_email").val()) == false){
						var err = 1;
						$('#form_email').after('<div class="reds email_error"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
					}
				
			<?php if($program_detail->program_type != "summer_camp") { ?>
				var selected = $('input[name=call_or_schedule]:checked').val();
				if(selected != 'call'){
					
					
					
					var party_date=$('#party_date').val();
					if(party_date.length == 0){
						var err = 1;
						$('#party_date').after('<div class="reds party_date_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_party_time'); ?></div>');
					}
					
					var party_guests=$('#party_guests').val();
					if(party_guests == '' || party_guests == null){
						var err = 1;
						$('#party_guests').after('<div class="reds party_guests_error"><?php echo $this->query_model->getStaticTextTranslation('select_guest_numbers'); ?></div>');
					}
				}
			<?php } ?>
			
			
			<?php if($multiSchoolOrLocation == 1 && $site_settings[0]->bdy_form_location_dropdown == 1){ ?>
			var school=$('#bdy_school').val();
			if(school == '' || school == null){
				var err = 1;
				$('#bdy_school').after('<div class="reds bdy_school_name_error"><?php echo $this->query_model->getStaticTextTranslation('select_your_location'); ?></div>');
			}
			<?php } ?>
			
			<?php /*if($this->query_model->get_gdpr_compliant() == 1){?>
				var gdpr_compliant_id= 'gdpr_compliant';
				var gdpr_compliant_error= 'gdpr_compliant_error';
				if($('#'+gdpr_compliant_id).is(":checked")){
					$('.'+gdpr_compliant_error).hide();
				}else{
					var err = 1;
					$('#'+gdpr_compliant_id).after('<div class="reds '+gdpr_compliant_error+'"><?php echo $this->query_model->getStaticTextTranslation('receiving_information'); ?></div>');
				}
			<?php }*/ ?>
			
					if(err == 0){
						return true;
					} else{
						return false;
					}
			
			});
			
			
			$('#first_name').keyup(function(){
					if($(this).val().length > 0){
						$('.name_error').hide();
					} else{
						$('#first_name').after('<div class="reds name_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?></div>');
						
					}
			});
			
			
			
			$('#last_name').keyup(function(){
					if($(this).val().length > 0){
						$('.last_name_error').hide();
					} else{
						$('#last_name').after('<div class="reds last_name_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?></div>');
						
					}
			});
			
			
			
			$('#telephone').keyup(function(){
					/*if($(this).val().length <= 11){
						$('#telephone').after('<div class="reds phone_error">Enter a valid phone number</div>');
						<?php if($site_settings[0]->phone_required == 0){ ?>
							if($(this).val().length == 0){
								$('.phone_error').hide();
							}else{
								$('#telephone').after('<div class="reds phone_error">Enter a valid phone number</div>');
							}
						<?php }else{ ?>
								$('#telephone').after('<div class="reds phone_error">Enter a valid phone number</div>');
						<?php } ?>
						
					} 
					
					if($(this).val().length == 12){
						$('.phone_error').hide();
						
					} */
					$('.phone_error').hide();
			});
			
			
			$('#form_email').keyup(function(){
					var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
					var email=$('#form_email').val();
					if($(this).val().length > 0 || emailfilter.test($("#form_email").val()) == false){
						$('.email_error').hide();
					} else{
						$('#form_email').after('<div class="reds email_error"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
						
					}
			});
			
		<?php if($program_detail->program_type != "summer_camp") { ?>
			$('#party_date').keyup(function(){
					if($(this).val().length > 0){
						$('.party_date_error').hide();
					} else{
						$('#party_date').after('<div class="reds party_date_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_party_time'); ?></div>');
						
					}
			});
			
	
			$('#party_guests').change(function(){
						if($(this).val() != ''){
							$('.party_guests_error').hide();
						} else{
							$('.party_guests_error').show();
							$('#party_guests').after('<div class="reds party_guests_error"><?php echo $this->query_model->getStaticTextTranslation('select_guest_numbers'); ?></div>');
							
						}
				});
		<?php } ?>
		
		
		<?php if($multiSchoolOrLocation == 1 && $site_settings[0]->bdy_form_location_dropdown == 1){ ?>
			$('#bdy_school').change(function(){
					if($(this).val() != ''){
						$('.bdy_school_name_error').hide();
					} else{
						$('.bdy_school_name_error').show();
						$('#bdy_school').after('<div class="reds bdy_school_name_error"><?php echo $this->query_model->getStaticTextTranslation('select_your_location'); ?></div>');
						
					}
			});
			<?php } ?>
		
		<?php /*if($this->query_model->get_gdpr_compliant() == 1){?>
			var gdpr_compliant_id= 'gdpr_compliant';
			var gdpr_compliant_error= 'gdpr_compliant_error';
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
        <div class="trial-form birthday_form program-form details-spacing test">
       
		 
		<form method="post" action="sendmail/send" class="get_started_form mini_form form-program">
			<?php echo $this->query_model->getCaptchaInputFields('opt_in_form'); ?>
			<?php if($program_detail->program_type != "summer_camp") { ?>
			<div class="inline_mid_form" >
			 <input type="radio" name="call_or_schedule" value="schecdule" id="schedule_party" class="birthday_redio" checked="checked" redirection_type="<?php echo $program_detail->button1_redirection_type;  ?>" trial_offer_id="<?php echo $program_detail->button1_trial_offer_id;  ?>" dojocart_id="<?php echo $program_detail->button1_dojocart_id;  ?>" third_party_url="<?php echo $program_detail->button1_third_party_url;  ?>"  thankyou_page_id="<?php echo $program_detail->button1_thankyou_page_id;  ?>"  /> <?php echo $this->query_model->getStaticTextTranslation('schedule_a_bdy_party'); ?><br />
				<input type="radio" name="call_or_schedule" id="more_info" value="call" class="birthday_redio"  redirection_type="<?php echo $program_detail->button2_redirection_type;  ?>" trial_offer_id="<?php echo $program_detail->button2_trial_offer_id;  ?>" dojocart_id="<?php echo $program_detail->button2_dojocart_id;  ?>" third_party_url="<?php echo $program_detail->button2_third_party_url;  ?>" thankyou_page_id="<?php echo $program_detail->button2_thankyou_page_id;  ?>"  /> <?php echo $this->query_model->getStaticTextTranslation('call_me_with_more_info'); ?>
			</div>
			<?php }else{ ?>
				<div class="inline_mid_form" >
				 <input type="radio" name="reserve_or_schedule" value="<?php echo $this->query_model->getStaticTextTranslation('reserve_spot_for_your_child'); ?>" id="" class="reserve_or_schedule" checked="checked"  redirection_type="<?php echo $program_detail->button1_redirection_type;  ?>" trial_offer_id="<?php echo $program_detail->button1_trial_offer_id;  ?>" dojocart_id="<?php echo $program_detail->button1_dojocart_id;  ?>" third_party_url="<?php echo $program_detail->button1_third_party_url;  ?>"  thankyou_page_id="<?php echo $program_detail->button1_thankyou_page_id;  ?>"  /> <?php echo $this->query_model->getStaticTextTranslation('reserve_spot_for_your_child'); ?> <br />
					<input type="radio" name="reserve_or_schedule" id="" value="<?php echo $this->query_model->getStaticTextTranslation('schedule_phone_consultation'); ?>" class="reserve_or_schedule"  redirection_type="<?php echo $program_detail->button2_redirection_type;  ?>" trial_offer_id="<?php echo $program_detail->button2_trial_offer_id;  ?>" dojocart_id="<?php echo $program_detail->button2_dojocart_id;  ?>" third_party_url="<?php echo $program_detail->button2_third_party_url;  ?>"  thankyou_page_id="<?php echo $program_detail->button2_thankyou_page_id;  ?>"  /> <?php echo $this->query_model->getStaticTextTranslation('schedule_phone_consultation'); ?>
				</div>
				
			<?php } ?>
			
            <div class="inline_mid_form  w-full" >
              <input type="text" id="first_name" name="bday_name" class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('first_name'); ?>"
                            onfocus="this.placeholder = ''"  onBlur="textAlphabatic(this)"  maxlength="<?php echo $this->query_model->fullNameInputMaxLength(); ?>"  error_class="name_error" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?>" >
              <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
			  
			<div class="inline_mid_form  w-half optinlastname" >
              <input type="text" id="last_name" name="last_name" class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('last_name'); ?>"
                            onfocus="this.placeholder = ''"  onBlur="textAlphabatic(this)" maxlength="25" error_class="last_name_error" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?>" >
              <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
            
            <div class="inline_mid_form w-full" >
              <input type="email" name="bday_email"  id="form_email"  class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('email'); ?>"
                            onfocus="this.placeholder = ''" onBlur="this.placeholder = '<?php echo $this->query_model->getStaticTextTranslation('email'); ?>'"
                            >
              <span class="fa fa-envelope form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
            <div class="inline_mid_form w-full" >
              <input type="text" name="bday_phone"  id="telephone"  class="contact-form-line   <?php echo $getPhoneNumberClass; ?>" placeholder="<?php echo $this->query_model->getStaticTextTranslation('phone'); ?>" 
                            onfocus="this.placeholder = ''"  error_class="phone_error" onBlur="phoneValidation(this)" maxlength="<?php echo $phoneNumberMaxLength; ?>"  
                            >
              <span class="fa fa-phone form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
			  <input type="text" id="fax" name="fax" class="optinfax"   placeholder="Fax Number" value="">

			  <?php if($multiSchoolOrLocation == 1 ){ ?>
				<?php if($site_settings[0]->bdy_form_location_dropdown == 1  && count($form_allLocations) >= 1){ ?>
				<div class="inline_mid_form w-full" >
				<select class=" form-control" name="school_interest" id="bdy_school">
				   <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_location'); ?></option>
						<?php foreach($form_allLocations as $location): ?>
							<option  value="<?=$location->id;?>" ><?=$location->name;?> </option>
						<?php endforeach;?>   
				  </select>
				  </div>
				 <?php } ?>
				<?php } ?>
         
		 
		 
		<?php if($program_detail->program_type != "summer_camp") { ?>
			
		 <div class="callDiv">  
		
				<div class="inline_mid_form  w-half">
					  <input type="text" id="party_date" name="party_date" class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('date_and_time'); ?>"
									onfocus="this.placeholder = ''" onBlur="this.placeholder = 'Date & Time'">
					  <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> 
				  </div>
					  
					<div class="inline_mid_form  w-half" style="width: 100%;" >
					<?php $guests_values = !empty($program_detail->guests_values) ?  unserialize($program_detail->guests_values) : ''; ?>
					  <select class="locationBox contact-form-line" name="party_guests" id="party_guests">
					   <option value=""><?php echo $this->query_model->getStaticTextTranslation('guests'); ?></option>
					   <?php 
							if(!empty($guests_values)){
								foreach($guests_values as $guests_value){
						?>
								<option value="<?php echo $guests_value; ?>"><?php echo $guests_value; ?></option>
							<?php } }  ?>
							
					  </select>
					  <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> 
					</div>
		</div> 
		 <?php } ?>
		 
		 <?php if(!empty($twilioApi)){?>
			   <div class="inline_mid_form twilio_checkbox" >
                  <input type="checkbox" class="" name="twilio_checkbox" value="1"> <?php echo $twilioApi->checkbox_text ?>
               </div>
			   <?php } ?>
<input type="text" id="comment" name="comment" class="optincomment"   placeholder="Write your comment here..." value="">
<input type="checkbox" class="optincheck" name="contact_me_by_phone" value="1">
	<?php if($this->query_model->get_gdpr_compliant() == 1){?>
			<div class="inline_mid_form email_optin_gdpr_compliant_checkbox" >
				<input type="hidden" name="ip_address" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
				
			  <input type="checkbox" class="form-control" id="gdpr_compliant" name="gdpr_compliant_checkbox" value="1"><?php echo $gdpr_compliant_txt2; ?><br/><?php echo $gdpr_compliant_txt1; ?>
		   </div>
		 <?php } ?>			   
		
			  
            <div class="started-btn-program">
			<input type="hidden" value="" name='email' id='email' class="submit button" style="display:none" />
			<input type="text" id="website" name="website" class="optinwebsite"  placeholder="Website" value="">
<input type="text"  class="ywedobjeo" name="x2o3d_<?php echo $this->query_model->setAndGetUniqueNumberForCustomField(); ?>" value="<?php echo time(); ?>"  placeholder="Serial Number"/>
			<input type="hidden" name="page_url" value="<?php echo isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';  ?>" />
			<input type="hidden" name="program_type" value="<?php echo $program_detail->program_type;  ?>" />
			<!-- <button type="submit" class="btn btn-red  submit bdayFormSubmit"> I want to get started now! <br>
              <span class="s-btn"> Schedule my party! </span></button> -->
			<input type="hidden" name="redirection_type" id="redirection_type" value="<?php echo $program_detail->button1_redirection_type;  ?>" />
			<input type="hidden" name="program_id" value="<?= $program_detail->id; ?>" />
			<input type="hidden" name="program_cat_id" value="<?= $category_detail[0]->cat_id; ?>" />
			
			
			<?php 
				$redirection_value = '';
				if($program_detail->button1_redirection_type == "trial_offer"){
					$redirection_value = $program_detail->button1_trial_offer_id;
				}elseif($program_detail->button1_redirection_type == "dojocart"){
					$redirection_value = $program_detail->button1_dojocart_id;
				}elseif($program_detail->button1_redirection_type == "thankyou_page"){
					$redirection_value = $program_detail->button1_thankyou_page_id;
				}elseif($program_detail->button1_redirection_type == "third_party_url"){
					$redirection_value = $program_detail->button1_third_party_url;
				}
			?>
			<input type="hidden" name="" id="redirection_value" value="<?php echo $redirection_value; ?>" />
			
			<input type="hidden" name="is_unique_trial" value="<?php echo ($this->query_model->isTrialOfferUnique() == 'unique_') ? 1 : 0; ?>" />
			
			<button class="redeem-offer bdayFormSubmit"  type="submit"><?php echo !empty($program_detail->opt1_submit_btn_text) ? $program_detail->opt1_submit_btn_text : 'Schedule my party!'; ?></button>
			  
			</div>
          </form>
 </div>
 
 
 
		<!-- END #contact_form -->