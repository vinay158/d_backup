<?php $site_settings = $this->query_model->getbyTable("tblsite"); ?>
<?php $phoneNumberMaxLength = $this->query_model->phoneNumberMaxLength(); 

	  $getPhoneNumberClass = $this->query_model->getPhoneNumberClass(); 
?>
<script>
		$(document).ready(function(){
			$('.birthday_redio').click(function(){
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
		$('.bdayFormSubmit1').click(function(){
		
					var err = 0
					var name=$('#first_name1').val();
					if(name.length == 0){
						var err = 1;
						$('#first_name1').after('<div class="reds name_error">Enter your first name</div>');
					}
					
					var last_name=$('#last_name1').val();
					if(last_name.length == 0){
						var err = 1;
						$('#last_name1').after('<div class="reds last_name_error">Enter your last name</div>');
					}
					
					
					/*var telephone=$('#telephone1').val();
					<?php if($site_settings[0]->phone_required == 1){ ?>
					if(telephone.length <= 11 || telephone.length == 0){
						var err = 1;
						$('#telephone1').after('<div class="reds phone_error">Enter a valid phone number</div>');
						
					} 
					<?php } ?> */
					
						var telephoneId = 'telephone1';
					var phoneError = 'phone_error';
					var telephone=$('#'+telephoneId).val();
					<?php 
						if($site_settings[0]->international_phone_fields != 1){
							if($site_settings[0]->phone_required == 1){ ?>
						if(telephone.length <= <?php echo $phoneNumberMaxLength - 1; ?> || telephone.length == 0){
							var err = 1;
							$('#'+telephoneId).after('<div class="reds '+phoneError+'">Enter a valid phone number</div>');
							
						} 
						<?php //}
						}else{ ?>
						
							if(telephone.length <= <?php echo $phoneNumberMaxLength - 1; ?> && telephone.length > 0){
									$('#'+telephoneId).after('<div class="reds '+phoneError+' ">Enter a valid phone number</div>');
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
							$('#'+telephoneId).after('<div class="reds '+phoneError+'">Enter a valid phone number</div>');
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
									$('#'+telephoneId).after('<div class="reds '+phoneError+'">Enter a valid phone number</div>');
									var err = 1;
								}	
							}	
					<?php		}	?> 
					
					<?php }?>
						
						
					
					var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
					var email=$('#form_email1').val();
					if(email.length == 0 || emailfilter.test($("#form_email1").val()) == false){
						var err = 1;
						$('#form_email1').after('<div class="reds email_error">Enter a valid email address</div>');
					}
					
				var selected = $('input[name=call_or_schedule]:checked').val();
				
				if(selected != 'call'){
					
					
					var party_date=$('#party_date1').val();
					if(party_date.length == 0){
						var err = 1;
						$('#party_date1').after('<div class="reds party_date_error">Enter your party date and time</div>');
					}
					
					var party_guests=$('#party_guests1').val();
					if(party_guests == '' || party_guests == null){
						var err = 1;
						$('#party_guests1').after('<div class="reds party_guests_error">Select your number of guests</div>');
					}
				}
					if(err == 0){
						return true;
					} else{
						return false;
					}
			
			});
			
			
			$('#first_name1').keyup(function(){
					if($(this).val().length > 0){
						$('.name_error').hide();
					} else{
						$('#first_name1').after('<div class="reds name_error">Enter your first name</div>');
						
					}
			});
			
			
			
			$('#last_name1').keyup(function(){
					if($(this).val().length > 0){
						$('.last_name_error').hide();
					} else{
						$('#last_name1').after('<div class="reds last_name_error">Enter your last name</div>');
						
					}
			});
			
			
			
			$('#telephone1').keyup(function(){
					/*if($(this).val().length <= 11){
						
						//$('#telephone').after('<div class="reds phone_error">Enter a valid phone number</div>');
						<?php if($site_settings[0]->phone_required == 0){ ?>
							if($(this).val().length == 0){
								$('.phone_error').hide();
							}else{
								$('#telephone1').after('<div class="reds phone_error">Enter a valid phone number</div>');
							}
						<?php }else{ ?>
								$('#telephone1').after('<div class="reds phone_error">Enter a valid phone number</div>');
						<?php } ?>
						
					} 
					
					if($(this).val().length == 12){
						$('.phone_error').hide();
						
					} */
					$('.phone_error').hide();
			});
			
			
			$('#form_email1').keyup(function(){
					var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
					var email=$('#form_email1').val();
					if($(this).val().length > 0 || emailfilter.test($("#form_email1").val()) == false){
						$('.email_error').hide();
					} else{
						$('#form_email1').after('<div class="reds email_error">Enter a valid email address</div>');
						
					}
			});
			
			
			
			$('#party_date1').keyup(function(){
					if($(this).val().length > 0){
						$('.party_date_error').hide();
					} else{
						$('#party_date1').after('<div class="reds party_date_error">Enter your party date and time name</div>');
						
					}
			});
			
			$('#party_guests1').change(function(){
						if($(this).val() != ''){
							$('.party_guests_error').hide();
						} else{
							$('.party_guests_error').show();
							$('#party_guests1').after('<div class="reds party_guests_error">Select your number of guests</div>');
							
						}
				});
			
		});

	</script>
        <div class="trial-form program-form details-spacing">
         <h2>Schedule Your Party!</h2>
		 
		<form method="post" action="sendmail/send" class="get_started_form mini_form form-program">
			<div class="inline_mid_form" >
				 <input type="radio" name="call_or_schedule" value="schecdule" id="schedule_party" class="birthday_redio" checked="checked" /> Schedule a Birthday Party<br />
				<input type="radio" name="call_or_schedule" id="more_info" value="call" class="birthday_redio" /> Call me with more information
			  
			</div>
            <div class="inline_mid_form w-half" >
              <input type="text" id="first_name1" name="bday_name" class="contact-form-line" placeholder="Name"
                            onfocus="this.placeholder = ''"   onBlur="textAlphabatic(this)" maxlength="25" error_class="name_error" error_msg="Enter your first name" >
              <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
            
			<div class="inline_mid_form  w-half" >
              <input type="text" id="last_name1" name="last_name" class="contact-form-line" placeholder="Last Name"
                            onfocus="this.placeholder = ''"  onBlur="textAlphabatic(this)" maxlength="25" error_class="last_name_error" error_msg="Enter your last name" >
              <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
			  
            <div class="inline_mid_form " >
              <input type="email" name="bday_email"  id="form_email1"  class="contact-form-line" placeholder="Email"
                            onfocus="this.placeholder = ''" onBlur="this.placeholder = 'Email'"
                            >
              <span class="fa fa-envelope form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
            <div class="inline_mid_form " >
              <input type="text" name="bday_phone"  id="telephone1"  class="contact-form-line  <?php echo $getPhoneNumberClass; ?>" placeholder="Phone"
                            onfocus="this.placeholder = ''"  error_class="phone_error"  onBlur="phoneValidation(this)" maxlength="<?php echo $phoneNumberMaxLength; ?>"  
                            >
              <span class="fa fa-phone form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
         
		 <div class="callDiv">  
		 
		 <div class="inline_mid_form  w-half" >
              <input type="text" id="party_date1" name="party_date" class="contact-form-line" placeholder="Date & Time"
                            onfocus="this.placeholder = ''" onBlur="this.placeholder = 'Date & Time'">
              <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
		  <div class="inline_mid_form w-half" >
		      <select class="locationBox contact-form-line" name="party_guests" id="party_guests1">
               <option value="">Guests</option>
					<option value="1-5">1-5</option>

					<option value="6-10">6-10</option>

					<option value="more than 10">10+</option>
              </select>
            
		 </div>
		</div> 
		 
			  
            <div class="started-btn-program">
			<input type="hidden" value="" name='email' id='email' class="submit button" style="display:none" />
			<input type="text" id="website" name="website" style="display:none" autocomplete="off">
			<input type="hidden" name="page_url" value="<?php echo isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';  ?>" />
			<button type="submit" class="btn btn-red  submit bdayFormSubmit1"> I want to get started now! <br>
              <span class="s-btn">Schedule my party!</span></button>
			
			  
			</div>
          </form>
 </div>
   
     
		<!-- END #contact_form -->