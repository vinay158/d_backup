<?php $this->load->view('includes/header'); ?>
<?php  $this->load->view('includes/header/masthead'); ?>
<?php $phoneNumberMaxLength = $this->query_model->phoneNumberMaxLength(); 
   $getPhoneNumberClass = $this->query_model->getPhoneNumberClass(); 
   
     $multiSchoolOrLocation = $this->query_model->checkMultiSchoolOrLocationIsOn();
	 
	 
	  /*** getting gdpr text **/
$gdprCompliantText = $this->query_model->getGdprCompliantText();
 $gdpr_compliant_txt1 = (isset($gdprCompliantText['gdpr_compliant_txt1'])) ? $gdprCompliantText['gdpr_compliant_txt1'] : '';
 $gdpr_compliant_txt2 = (isset($gdprCompliantText['gdpr_compliant_txt2'])) ? $gdprCompliantText['gdpr_compliant_txt2'] : '';
 $gdpr_compliant_submit_btn_text = (isset($gdprCompliantText['gdpr_compliant_submit_btn_text'])) ? $gdprCompliantText['gdpr_compliant_submit_btn_text'] : '';
 
   ?>
<?php $sessionLeadData = $this->session->userdata('sessionLeadsData'); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<?php if(!empty($header)){ ?>
<script>
   $(window).load(function(){
   $.each($('.trial_offer_checkbox_mobile'), function(){
   if($(this).is(':checked')){
   	var offer_id = $(this).attr('trial_cat_id');
   	//alert(offer_id); 
   	//var offer_id = $(this).attr('id');
   	var cat_slug = $(this).parent().parent().parent().parent().attr('cat_slug');
   	
   	$('#check_mobile'+offer_id).addClass('activeTrial_mobile');
   	$('#checkbox_mobile_'+offer_id).prop( "checked", true );
   	$('.selectedTrial_mobile'+offer_id).html('<?php echo $this->query_model->getStaticTextTranslation('selected') ?>');
   	$('.trialErrorMessage_mobile').html('');
   	$('.trial_cat_id_mobile').val(offer_id);
   	//$('.trial_cat_id_full_form').val(offer_id);
   	
   	//$('.mini_trial_offer_form').attr('action','<?php echo base_url().$trial_offer_slug->slug.'/' ?>'+cat_slug);
   	//$('.full_trial_offer_form').attr('action','<?php echo base_url().$trial_offer_slug->slug.'/' ?>'+cat_slug);
   		
   }
   });
   
   
   $.each($('.flex-box'),function(){
	   var child_box = $(this).children('.specialoffer_block').length;
	   if(child_box == 0 || child_box == 1 || child_box == 3){
		   $(this).addClass('odd-row');
	   }else{
		   $(this).addClass('even-row');
	   }
   })
   
   });
   $(document).ready(function(){
   
   
   $('.trialButton_mobile').click(function(){
   
   	$.each($('.activeTrial_mobile'), function(){
   		$(this).removeClass('activeTrial_mobile');
   	});
   	
   	$.each($('.trial_offer_checkbox_mobile'), function(){
   		$(this).attr("checked", false);
   	});
   	
   	$.each($('.selectedOffer_mobile'), function(){
   		$(this).html("<?php echo $this->query_model->getStaticTextTranslation('select') ?>");
   	});
   	
   	var offer_id = $(this).attr('id');
   	var cat_slug = $(this).attr('cat_slug');
   	
   	$('#check_mobile'+offer_id).addClass('activeTrial_mobile');
   	$('#checkbox_mobile_'+offer_id).prop( "checked", true );
   	$('.selectedTrial_mobile'+offer_id).html('<?php echo $this->query_model->getStaticTextTranslation('selected') ?>');
   	$('.trialErrorMessage_mobile').html('');
   	$('.trial_cat_id_mobile').val(offer_id);
   	//$('.trial_cat_id_full_form').val(offer_id);
   	
   	//$('.mini_trial_offer_form').attr('action','<?php echo base_url().$trial_offer_slug->slug.'/' ?>'+cat_slug);
   	//$('.full_trial_offer_form').attr('action','<?php echo base_url().$trial_offer_slug->slug.'/' ?>'+cat_slug);
   	
   });
   
   
   
   });
</script>
<div class="mobile-visible">
<section id="web-offers">
   <div class="label-option">
      <?php if(!empty($email_options) && $email_options->require_opt_in == 1){ ?>
      <h3> 1: <?php echo $this->query_model->getStaticTextTranslation('choose_program_of_interest'); ?></h3>
	<?php }else{ ?>
	<h3> <?php echo $this->query_model->getStaticTextTranslation('choose_program_of_interest'); ?> : </h3>
	<?php } ?>
   </div>
   <div class="flex-box">
      <?php 
         $i = 0;
		 $p = 1;
		 
		 $totalCatArr = array();
		 $total_cats = 0;
		 foreach($trial_categories as $trial_cat){
			 if($trial_cat->hide_from_trial_page == 0){
				$totalCatArr[$trial_cat->id] = $trial_cat->id;
			 }
		 }
		 $total_cats = count($totalCatArr);
		$y = 0;
         foreach($trial_categories as $trial_cat){
         	
         	if($trial_cat->hide_from_trial_page == 0){
         		
			$isUniqueTrial = $this->query_model->isTrialOfferUnique();
			$special_offer_table = ($isUniqueTrial == "unique_") ? '_unique_specialoffer' : 'specialoffer';
         	$this->db->where("display_trial", 1);
         	$this->db->where("cat_id", $trial_cat->id);
         	$offers = $this->query_model->getbyTable('tbl'.$special_offer_table);
         
			$number = 3;
			if(in_array($total_cats,array(2,4))){
				$number = 2;
			}
			
			
			
			if($total_cats == 6){
				if($number != 3){
					if($i % $number == 0){
						$y = 1-$y;
					}
				}
			}else{
				if($i % $number == 0){
					$y = 1-$y;
				}
			}
			
			
			if($y == 1){
				if($total_cats == 6){
					$block_class = 'right-block 1';
					$box_class = ' right-g';
				}else{
					$block_class = 'left-block 0';
					$box_class = ' left-g';
				}
				
				$y = 1-$y;
			}else{
				if($total_cats == 6){
					$block_class = 'left-block 0';
					$box_class = ' left-g';
				}else{
					$block_class = 'right-block 1';
					$box_class = ' right-g';
				}
				
				$y = 1-$y;
			}
			
         	/*if($i % $number == 0){
         		$block_class = 'left-block 0';
         		$box_class = ' left-g';
         	}else{
				$last_box = $p / 3;
				if (is_float($last_box)) {
					$block_class = 'right-block 1';
					$box_class = ' right-g';
				} else {
					$block_class = 'left-block 2';
					$box_class = ' left-g';
				}
         		
         	}*/
         ?>
		 
	<?php if($isUniqueTrial == ""){?>
      <div class="<?=$block_class ?> specialoffer_block  random-trial-<?=$trial_cat->slug; ?>">
         <h3> <?php $this->query_model->getDescReplace($trial_cat->heading); ?></h3>
         <h2> <?php $this->query_model->getDescReplace($trial_cat->name); ?></h2>
         <?php if(count($offers) > 0){ ?>
         <p><?php echo count($offers); ?> <?php echo (count($offers) >1) ? $this->query_model->getStaticTextTranslation('web_specials') : $this->query_model->getStaticTextTranslation('web_special') ?> <?php echo $this->query_model->getStaticTextTranslation('available'); ?></p>
         <div id="<?=$trial_cat->id; ?>" cat_slug="<?=$trial_cat->slug; ?>" class="check-select trialButton_mobile">
		 <?php $isTrialOfferUnique = $this->query_model->isTrialOfferUnique(); ?>
            <?php  if((!empty($email_options)) && ($email_options->require_opt_in == 1)){ ?>
            <a  id="check_mobile<?=$trial_cat->id; ?>"  href="javascript:void(0)" class="btn-animate  white-btn check ">
               <div class="control-group <?php echo $box_class; ?>">
                  <label class="control control-checkbox">
                     <span class="selectedOffer_mobile selectedTrial_mobile<?=$trial_cat->id; ?>"> <?php echo $this->query_model->getStaticTextTranslation('select'); ?></span>
                     <input id="checkbox_mobile_<?=$trial_cat->id; ?>"  trial_cat_id="<?=$trial_cat->id; ?>"  type="checkbox" class="trial_offer_checkbox_mobile" />
                     <div class="control_indicator"></div>
                  </label>
               </div>
            </a>
           <!-- <a href="<?php echo $trial_offer_slug->slug.'/'.$trial_cat->slug; ?>" class="btn-animate white-btn check ">
               <div class="control-group <?php echo $box_class; ?>">
                  <label class="control control-checkbox text-center">
                  <span class="selectedTrial_mobile<?=$trial_cat->id; ?>"> Select</span>
                  </label>
               </div>
            </a> -->
            <?php  }else{ ?>
			
			<?php 
					$view_special_url = base_url().$trial_offer_slug->slug.'/'.$trial_cat->slug;
					if($isUniqueTrial == "unique_"){
						$view_special_url = $this->query_model->getViewSpecialUrl($trial_cat);
					}
				?>
			
				<a  id="check<?=$trial_cat->id; ?>"  href="<?php echo $view_special_url; ?>" class="btn-animate  white-btn check ">
				   <div class="control-group <?php echo $box_class; ?>">
						  <label class="control "><?php echo $this->query_model->getStaticTextTranslation('view_specials'); ?>
							<?php // $this->query_model->getDescReplace($trial_cat->name); ?>
						</label>
				   </div>
				</a>
			<?php } ?>
         </div>
         <?php }else{?>
         <p><?php echo $this->query_model->getStaticTextTranslation('no_web_special_available'); ?></p>
         <?php } ?>
      </div>
	<?php }else{ ?>
		
		<div class="<?=$block_class ?> specialoffer_block 1  random-trial-<?=$trial_cat->slug; ?>">
         <h3> <?php $this->query_model->getDescReplace($trial_cat->heading); ?></h3>
         <h2> <?php $this->query_model->getDescReplace($trial_cat->name); ?></h2>
         <p> <?php $this->query_model->getDescReplace($trial_cat->box_web_special); ?></p>
         <div id="<?=$trial_cat->id; ?>" cat_slug="<?=$trial_cat->slug; ?>" class="check-select trialButton">
		 <?php 
					$view_special_url = base_url().$trial_offer_slug->slug.'/'.$trial_cat->slug;
					if($isUniqueTrial == "unique_"){
						$view_special_url = $this->query_model->getViewSpecialUrl($trial_cat);
					}
				?>
				<a  id="check<?=$trial_cat->id; ?>"  href="<?php echo $trial_cat->box_button_url; ?>" class="btn-animate  white-btn check ">
				   <div class="control-group <?php echo $box_class; ?>">
						  <label class="control ">  <?php $this->query_model->getDescReplace($trial_cat->box_button_text); ?>
							
						</label>
				   </div>
				</a>
				
         </div>
         
      </div>
	
	<?php } ?>
      <?php $i++; $p++; 
			 if($i%$number == 0){
				echo "</div><div class='flex-box'>";
			}
	  } } ?>
   </div>
   </div>
</section>
</div>
<div class="mobile-visible">
<?php 
   $showMiniform = 0;
   if(!empty($email_options)){
   	if($email_options->show_full_form == 1){
   			$showMiniform = 2;
   		}else{
   			$showMiniform = 1;
   		}
   }
    ?>
<?php if(!empty($email_options) && $email_options->require_opt_in == 1){ ?>	
<?php if($showMiniform != 0){ ?>
<section class="trial-form inner-trial">
   <span class="vert-set"></span>
   <div class="container">
      <div class="row">
         <div class="col-md-12 text-center">
            <h2> 2: <?php echo $this->query_model->getStaticTextTranslation('redeem_current_trial_offers'); ?>:</h2>
            <!-- <h2>
               <?php if(!empty($email_options) && !empty($email_options->title)) {
                  $this->query_model->getDescReplace($email_options->title); 
                  }else{
                  //echo 'Opt-in to redeem current trial offers and view pricing & details:';  
                  }  ?>
               </h2>
               
                           <p>
               <?php if(!empty($email_options) && !empty($email_options->text)) {
                  $this->query_model->getDescReplace($email_options->text); 
                  }else{
                  echo 'Opt-in to redeem current trial offers and view pricing & details:';  
                  }  ?>
               </p> -->
			   
			
			   
            <p class="trialErrorMessage_mobile"></p>
            <?php if($showMiniform == 1){ ?>
            <div class="started-block">
               <span></span>
			    <?php if(!empty($email_options) && $email_options->require_opt_in == 1){ ?> 
               <script>
                  $(document).ready(function(){
                  	
                  	
                  $('.contactFormSubmit_8').click(function(){
                  
                  			var err = 0
                  			var trial_id = $('.trial_cat_id_mobile').val();
                  			if(trial_id == 0){
                  				$('#form_email_8').after('<div class="reds email_error_8"><?php echo $this->query_model->getStaticTextTranslation('select_trial_offer_cat_above'); ?></div>');
                  				//$('.trialErrorMessage').html('<h3><?php echo $this->query_model->getStaticTextTranslation('choose_trial_offer_category'); ?></h3>');
                  				return false;
                  			}
                  			$('.email_error_8').hide();
                  			var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
                  			var email=$('#form_email_8').val();
                  			if(email.length == 0 || emailfilter.test($("#form_email_8").val()) == false){
                  				var err = 1;
                  				$('#form_email_8').after('<div class="reds email_error_8"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
                  			}
                  			
                  			<?php if($multiSchoolOrLocation == 1 ){ ?>
							var school=$('#school_8').val();
							if(school == '' || school == null){
								var err = 1;
								$('#school_8').after('<div class="reds school_name_error8"><?php echo $this->query_model->getStaticTextTranslation('select_your_location'); ?></div>');
							}
							<?php } ?>
							
							<?php /*if($this->query_model->get_gdpr_compliant() == 1){?>
								var gdpr_compliant_id= 'gdpr_compliant_8';
								var gdpr_compliant_error= 'gdpr_compliant_error8';
								if($('#'+gdpr_compliant_id).is(":checked")){
									$('.'+gdpr_compliant_error).hide();
								}else{
									var err = 1;
									$('#'+gdpr_compliant_id).after('<div class="reds '+gdpr_compliant_error+'"><?php echo $this->query_model->getStaticTextTranslation('receiving_information'); ?></div>');
								}
							<?php }*/ ?>
							
                  			
                  			if(err == 0){
                  				$("#form_8").attr('action','<?=base_url()?>starttrial/saveLeadsByEmails');
                  				return true;
                  			} else{
                  				$("#form_8").attr('action','#');
                  				return false;
                  			}
                  	
                  	});
                  	
                  	
                  	$('#form_email_8').keyup(function(){
                  			var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
                  			var email=$('#form_email_8').val();
                  			if($(this).val().length > 0 || emailfilter.test($("#form_email_8").val()) == false){
                  				$('.email_error_8').hide();
                  			} else{
                  				$('#form_email_8').after('<div class="reds email_error_8"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
                  				
                  			}
                  	});
                  	
					<?php if($multiSchoolOrLocation == 1 ){ ?>
            	$('#school_8').change(function(){
            			if($(this).val() != ''){
            				$('.school_name_error8').hide();
            			} else{
            				$('.school_name_error8').show();
            				$('#school_8').after('<div class="reds school_name_error8"><?php echo $this->query_model->getStaticTextTranslation('select_your_location'); ?></div>');
            				
            			}
            	});
            	<?php } ?>
				
				
				<?php /*if($this->query_model->get_gdpr_compliant() == 1){?>
					var gdpr_compliant_id= 'gdpr_compliant_8';
					var gdpr_compliant_error= 'gdpr_compliant_error8';
					$('#'+gdpr_compliant_id).click(function(){
							if($(this).is(':checked')){
								$('.'+gdpr_compliant_error).hide();
							}else{
								$('.'+gdpr_compliant_error).show();
							}
						})
				<?php } */?> 
                  	
                  });
                  
               </script>
				<?php }else{?>
				 <script>
							   
					$(document).ready(function(){
						
						$('.contactFormSubmit_8').click(function(){
							var trial_id = $('.trial_cat_id_mobile').val();
								if(trial_id == 0){
									$('.trialErrorMessage_mobile').html('<h3><?php echo $this->query_model->getStaticTextTranslation('choose_trial_offer_category'); ?></h3>');
									return false;
								}
						});
						
						
					});

				</script> 
				<?php } ?>
				   <?php
				$form_action_url = "#";
				$goBtnClass = "";
				if(!empty($email_options) && $email_options->require_opt_in == 0){
					$form_action_url = base_url()."starttrial/redirectEmailOptinForm";
					$goBtnClass = "only-go-button";
				}
			?>
			
               <form action="<?php echo $form_action_url; ?>"  method="post" class="get_started_form mini_form mini_trial_offer_form    small_mini_form" id="form_8">
			    <?php echo $this->query_model->getCaptchaInputFields('opt_in_form'); ?>
                  <div class="search-box">
				  
				   
					 
				   <?php if(!empty($email_options) && $email_options->require_opt_in == 1){ ?> 
				 <?php if($multiSchoolOrLocation == 1 ){ ?>
				   <?php if($multiLocation[0]->field_value == 1  && count($form_allLocations) >= 1){ ?>
                          <select class="form-control form_location_dropdown" name="school_interest" id="school_8" number="1">
                                 <option value=""><?php echo $this->query_model->getStaticTextTranslation('Choose a Location'); ?></option>
                                 <?php foreach($form_allLocations as $location): ?>
                                 <option  value="<?=$location->id;?>" <?php echo (isset($sessionLeadData['school_interest']) && $sessionLeadData['school_interest'] == $location->id) ? 'selected=selected' : ''; ?>><?=$location->name;?> </option>
                                 <?php endforeach;?>   
                              </select>
                           <?php } ?>
				 <?php  } ?>
				 
				 <?php if($this->query_model->showProgramsListOnFroms() == 1){
					$programsArr =  $this->query_model->programsListOnFromDropdowns(); 
							if(!empty($programsArr)){
						?>
							<select class="form-control  form_program_dropdown program_dropdown_1" name="program_id" id="">
								 <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_program'); ?></option>
								 <?php foreach($programsArr as $program): ?>
								 <option  value="<?=$program->id;?>" ><?=$program->program;?> </option>
								 <?php endforeach;?>   
							  </select>
					 
					 <?php } }  ?>
					
					 <input type="text"  name="last_name" class="optinlastname" placeholder="Last Name" value="">

                     <input type="text" class="form-control" id="form_email_8" name="form_email_2" placeholder="Enter your email address" value="<?php echo (isset($sessionLeadData['form_email_2'])) ? $sessionLeadData['form_email_2'] : ''; ?>">
					 <input type="text" id="fax" name="fax" class="optinfax"   placeholder="Fax Number" value="">

					 <?php if(!empty($twilioApi)){?>
				   <div class=" twilio_checkbox email_optin_twilio_checkbox" >
					  <input type="checkbox" class="form-control" name="twilio_checkbox" value="1"> <?php echo $twilioApi->checkbox_text ?>
				   </div>
			   <?php } ?>	
			   <input type="text" id="comment" name="comment" class="optincomment"   placeholder="Write your comment here..." value="">
<input type="checkbox" class="optincheck" name="contact_me_by_phone" value="1">
			   <?php if($this->query_model->get_gdpr_compliant() == 1){?>
						<div class="email_optin_gdpr_compliant_checkbox" >
							<input type="hidden" name="ip_address" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
							
							
						  <input type="checkbox" class="form-control" id="gdpr_compliant_8" name="gdpr_compliant_checkbox" value="1"><?php echo $gdpr_compliant_txt2; ?><span><?php echo $gdpr_compliant_txt1; ?></span>
					   </div>
					 <?php } ?>
			   
				   <?php  } ?>
				   
                     <input type="hidden" class="trial_cat_id_mobile" name="trial_offer_id" value="0" />
					   <input type="hidden" name="redirection_type" value="trial_offer" />
                     <input type="hidden" name="page_url" value="<?php echo isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';  ?>" />
                     <input type="hidden" name="send_location" value="0" />
                     <input name="send_trial_cat_tag_ac" value="1" type="hidden">
                     <input type="hidden" name="miniform" value="true" />
					  <input type="text" id="website" name="website" class="optinwebsite"  placeholder="Website" value="">
<input type="text"  class="ywedobjeo" name="x2o3d_<?php echo $this->query_model->setAndGetUniqueNumberForCustomField(); ?>" value="<?php echo time(); ?>"  placeholder="Serial Number"/>
                     <button class="btn-red contactFormSubmit_8  <?php echo $goBtnClass; ?>" name="submitEmail" value="submitEmail" type="submit" ><?php echo $gdpr_compliant_submit_btn_text; ?></button>
                  </div>
               </form>
            </div>
            <?php } if($showMiniform == 2){ ?>
            <div class="trial-form about-trial-form about-alt-bg">
               <div class="container">
                  <div class="row">
                     <script>
                        $(document).ready(function(){
                        		
                        $('.contactFormSubmit_9').click(function(){
                        		
                        			var err = 0;
                        			var trial_id = $('.trial_cat_id_mobile').val();
                        			if(trial_id == 0){
                        				$('.trialErrorMessage_mobile').html('<h3><?php echo $this->query_model->getStaticTextTranslation('choose_trial_offer_category'); ?></h3>');
                        				return false;
                        			}
                        			
                        			var name=$('#first_name_9').val();
                        			//alert(name); return false;
                        			if(name.length == 0){
                        				var err = 1;
                        				$('#first_name_9').after('<div class="reds name_error_9"><?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?></div>');
                        			}else{
										if(! /\s/g.test(name)){
											var err = 1;
											$('#first_name_9').after('<div class="reds name_error_9"><?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?></div>');
										}
									}
                        			
                        			/*var last_name=$('#last_name_9').val();
                        			if(last_name.length == 0){
                        				var err = 1;
                        				$('#last_name_9').after('<div class="reds last_name_error_9"><?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?></div>');
                        			}*/
                        			
                        			
                        								
                        			var telephoneId = 'telephone_9';
                        			var phoneError = 'phone_error_9';
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
                        			var email=$('#form_email_9').val();
                        			if(email.length == 0 || emailfilter.test($("#form_email_9").val()) == false){
                        				var err = 1;
                        				$('#form_email_9').after('<div class="reds email_error_9"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
                        			}
                        			
                        			
                        			<?php if($multiLocation[0]->field_value == 1 ){ ?>
                        			var school=$('#school_9').val();
                        			if(school == '' || school == null){
                        				var err = 1;
                        				$('#school_9').after('<div class="reds school_name_error_9"><?php echo $this->query_model->getStaticTextTranslation('select_your_location'); ?></div>');
                        			}
                        			<?php } ?>
                        			
                        			<?php /*if($this->query_model->get_gdpr_compliant() == 1){?>
									var gdpr_compliant_id= 'gdpr_compliant_9';
									var gdpr_compliant_error= 'gdpr_compliant_error9';
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
                        	
                        	
                        	$('#first_name_9').keyup(function(){
                        			if($(this).val().length > 0){
                        				$('.name_error_9').hide();
                        			} else{
                        				$('#first_name_9').after('<div class="reds name_error_9"><?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?></div>');
                        				
                        			}
                        	});
                        	
                        	$('#last_name_9').keyup(function(){
                        			if($(this).val().length > 0){
                        				$('.last_name_error_9').hide();
                        			} else{
                        				$('#last_name_9').after('<div class="reds last_name_error_9"><?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?></div>');
                        				
                        			}
                        	});
                        	
                        	$('#telephone_9').keyup(function(){
                        			
                        			
                        			$('.phone_error_9').hide();
                        	});
                        	
                        	
                        	$('#form_email_9').keyup(function(){
                        			var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
                        			var email=$('#form_email_9').val();
                        			if($(this).val().length > 0 || emailfilter.test($("#form_email_9").val()) == false){
                        				$('.email_error_9').hide();
                        			} else{
                        				$('#form_email_9').after('<div class="reds email_error_9"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
                        				
                        			}
                        	});
                        	
                        	<?php if($multiLocation[0]->field_value == 1 ){ ?>
                        	$('#school_9').change(function(){
                        			if($(this).val() != ''){
                        				$('.school_name_error_9').hide();
                        			} else{
                        				$('.school_name_error_9').show();
                        				$('#school_9').after('<div class="reds school_name_error_9"><?php echo $this->query_model->getStaticTextTranslation('select_your_location'); ?></div>');
                        				
                        			}
                        	});
                        	<?php } ?>
                        	
							<?php /*if($this->query_model->get_gdpr_compliant() == 1){?>
								var gdpr_compliant_id= 'gdpr_compliant_9';
								var gdpr_compliant_error= 'gdpr_compliant_error9';
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
                  </div>
                  <div class="row">
                     <div class="col-xs-12">
                        <form action="<?=base_url().$trial_offer_slug->slug?>"  method="post" class="full_trial_offer_form get_started_form mini_form" >
						 <?php echo $this->query_model->getCaptchaInputFields('opt_in_form'); ?>
                           <div class="inline_mid_form " >
                              <input type="text" id="first_name_9" name="name" class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('first_name'); ?>" onfocus="this.placeholder = ''"   onBlur="textAlphabatic(this)" maxlength="<?php echo $this->query_model->fullNameInputMaxLength(); ?>" error_class="name_error_9" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?>" value="<?php echo (isset($sessionLeadData['name'])) ? $sessionLeadData['name'] : ''; ?>">
                              <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> 
                           </div>
                           <div class="inline_mid_form optinlastname" >
                              <input type="text" name="last_name" id="last_name_9" class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('last_name'); ?>"  onfocus="this.placeholder = ''" onBlur="textAlphabatic(this)" maxlength="25" error_class="last_name_error" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?>"   value="<?php echo (isset($sessionLeadData['last_name'])) ? $sessionLeadData['last_name'] : ''; ?>">
                              <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> 
                           </div>
                           <div class="inline_mid_form " >
                              <input type="email" name="form_email_2" id="form_email_9" class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('email'); ?>" onfocus="this.placeholder = ''" onBlur="this.placeholder = '<?php echo $this->query_model->getStaticTextTranslation('email'); ?>'"   value="<?php echo (isset($sessionLeadData['form_email_2'])) ? $sessionLeadData['form_email_2'] : ''; ?>" >
                              <span class="fa fa-envelope form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> 
                           </div>
                           <div class="inline_mid_form " >
                              <input type="text" name="phone" id="telephone_9" class="contact-form-line <?php echo $getPhoneNumberClass; ?>" placeholder="<?php echo $this->query_model->getStaticTextTranslation('login'); ?>" onfocus="this.placeholder = ''" error_class="phone_error_9" onBlur="phoneValidation(this)" maxlength="<?php echo $phoneNumberMaxLength; ?>"    value="<?php echo (isset($sessionLeadData['phone'])) ? $sessionLeadData['phone'] : ''; ?>"  >
                              <span class="fa fa-phone form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> 
                           </div>
						   <input type="text" id="fax" name="fax" class="optinfax"   placeholder="Fax Number" value="">

										
					 
							
                           <?php if($multiLocation[0]->field_value == 1  && count($form_allLocations) >= 1){ ?>
                           <div class="inline_mid_form " >
                              <select class="locationBox contact-form-line form_location_dropdown" name="school_interest" id="school_9" number="2">
                                 <option value=""><?php echo $this->query_model->getStaticTextTranslation('Choose a Location'); ?></option>
                                 <?php foreach($form_allLocations as $location): ?>
                                 <option  value="<?=$location->id;?>" <?php echo (isset($sessionLeadData['school_interest']) && $sessionLeadData['school_interest'] == $location->id) ? 'selected=selected' : ''; ?>><?=$location->name;?> </option>
                                 <?php endforeach;?>   
                              </select>
                              <span class="fa fa-map-marker form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> 
                           </div>
                           <?php } ?>
						   
						   <?php if($this->query_model->showProgramsListOnFroms() == 1){
								
									$programsArr =  $this->query_model->programsListOnFromDropdowns(); 
										if(!empty($programsArr)){
								?>
								<div class="inline_mid_form " >
								<select class="contact-form-line  form_program_dropdown program_dropdown_2" name="program_id" id="">
									 <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_program'); ?></option>
									 <?php foreach($programsArr as $program): ?>
									 <option  value="<?=$program->id;?>" ><?=$program->program;?> </option>
									 <?php endforeach;?>   
								  </select>
								</div>
							<?php } } ?>
						   
						   <?php if(!empty($twilioApi)){?>
							   <div class=" inline_mid_form twilio_checkbox " >
								  <input type="checkbox" class="form-control" name="twilio_checkbox" value="1"> <?php echo $twilioApi->checkbox_text ?>
							   </div>
						   <?php } ?>
					<input type="text" id="comment" name="comment" class="optincomment"   placeholder="Write your comment here..." value="">
					<input type="checkbox" class="optincheck" name="contact_me_by_phone" value="1">
					<?php if($this->query_model->get_gdpr_compliant() == 1){?>
					<div class="inline_mid_form gdpr_compliant_checkbox" >
						<input type="hidden" name="ip_address" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
						
						
					  <input type="checkbox" class="form-control" id="gdpr_compliant_9" name="gdpr_compliant_checkbox" value="1"><?php echo $gdpr_compliant_txt2; ?><span><?php echo $gdpr_compliant_txt1; ?></span>
				   </div>
				 <?php } ?>						   
					   
                           <div class="<?php if($multiLocation[0]->field_value == 0){ echo 'inline_mid_form singleLocationFormButton'; }?> started-btn" >
                              <input type="hidden" name="miniform" value="true" />
                              <input type="text" id="website" name="website" class="optinwebsite"  placeholder="Website" value="">
<input type="text"  class="ywedobjeo" name="x2o3d_<?php echo $this->query_model->setAndGetUniqueNumberForCustomField(); ?>" value="<?php echo time(); ?>"  placeholder="Serial Number"/>
                              <input type="hidden" name="page_url" value="<?php echo isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';  ?>" />
                              <input type="hidden" class="trial_cat_id_mobile" name="trial_offer_id" value="0" />
							  <input type="hidden" name="redirection_type" value="trial_offer" />
                              <input name="send_trial_cat_tag_ac" value="1" type="hidden">
                              <input class="mini_formSubmit contactFormSubmit_9  submit <?php if($multiLocation[0]->field_value == 0){ echo 'getStartedMargin'; } else { echo 'getStartedMarginAuto'; } ?>" type="submit" class="" value="GO" />
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
            <?php } ?>
         </div>
      </div>
   </div>
</section>
<?php } } ?>
</div>

<section class="top-section" style="background-image:url('<?php echo 'upload/onlinespecial/'.$header->left_photo; ?>')  !important;">
   <span class="overlay" style="<?php echo !empty($header->background_color) ? 'background:'.$header->background_color : ''; ?>"></span>
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <div class="text-center top-block">
               <?= $this->query_model->getDescReplace($header->description); ?>
            </div>
         </div>
      </div>
   </div>
</section>
<?php } ?>
<?php 
   if(!empty($onlinespecialRows)){
   		foreach($onlinespecialRows as $row){
   			if($row->photo_side == "right"){
   ?>	
<section id="toggle-block" class="clearfix">
   <div class="content-box">
      <h2><?= $this->query_model->getDescReplace($row->title); ?></h2>
      <p><?= $this->query_model->getDescReplace($row->description); ?></p>
   </div>
   <div class="relative-block">
      <div class="full-bg-toggle"  style="background-image:url('<?php echo 'upload/onlinespecial/'.$row->photo; ?>')  !important;"></div>
   </div>
</section>
<?php }else{ ?>
<section id="toggle-block" class="clearfix">
   <div class="content-box  block-right">
      <h2><?= $this->query_model->getDescReplace($row->title); ?></h2>
      <p><?= $this->query_model->getDescReplace($row->description); ?></p>
   </div>
   <div class="relative-block  toggle-b-set">
      <div class="full-bg-toggle"  style="background-image:url('<?php echo 'upload/onlinespecial/'.$row->photo; ?>')  !important;"></div>
   </div>
</section>
<?php } ?>
<?php } } ?>
<?php if(!empty($text_sections)){ ?>
<section id="user-ad">
   <div class="container">
      <div class="row">
         <div class="col-md-4">
            <div class="relative">
               <img src="<?php echo 'upload/onlinespecial/'.$text_sections->photo; ?>" class="img-responsive school-owner-a" style="left:40px; top:-15px;" alt="<?= $this->query_model->getDescReplace($text_sections->photo_alt_text); ?>">
            </div>
         </div>
         <div class="col-md-8 owner-info">
            <h2><?= $this->query_model->getDescReplace($text_sections->sub_title); ?></h2>
            <p><?= $this->query_model->getDescReplace($text_sections->description); ?></p>
         </div>
      </div>
   </div>
</section>
<?php } ?>	  
<?php if(!empty($trial_categories)){ ?>
<script>
   $(window).load(function(){
   $.each($('.trial_offer_checkbox'), function(){
   if($(this).is(':checked')){
   	var offer_id = $(this).attr('trial_cat_id');
   	//alert(offer_id); 
   	//var offer_id = $(this).attr('id');
   	var cat_slug = $(this).parent().parent().parent().parent().attr('cat_slug');
   	
   	$('#check'+offer_id).addClass('activeTrial');
   	$('#checkbox_'+offer_id).prop( "checked", true );
   	$('.selectedTrial'+offer_id).html('<?php echo $this->query_model->getStaticTextTranslation('selected') ?>');
   	$('.trialErrorMessage').html('');
   	$('.trial_cat_id').val(offer_id);
   	//$('.trial_cat_id_full_form').val(offer_id);
   	
   	//$('.mini_trial_offer_form').attr('action','<?php echo base_url().$trial_offer_slug->slug.'/' ?>'+cat_slug);
   	//$('.full_trial_offer_form').attr('action','<?php echo base_url().$trial_offer_slug->slug.'/' ?>'+cat_slug);
   		
   }
   });
   });
   $(document).ready(function(){
   
   
   $('.trialButton').click(function(){
   
   	$.each($('.activeTrial'), function(){
   		$(this).removeClass('activeTrial');
   	});
   	
   	$.each($('.trial_offer_checkbox'), function(){
   		$(this).attr("checked", false);
   	});
   	
   	$.each($('.selectedOffer'), function(){
   		$(this).html("<?php echo $this->query_model->getStaticTextTranslation('select') ?>");
   	});
   	
   	var offer_id = $(this).attr('id');
   	var cat_slug = $(this).attr('cat_slug');
   	
   	$('#check'+offer_id).addClass('activeTrial');
   	$('#checkbox_'+offer_id).prop( "checked", true );
   	$('.selectedTrial'+offer_id).html('<?php echo $this->query_model->getStaticTextTranslation('selected') ?>');
   	$('.trialErrorMessage').html('');
   	$('.trial_cat_id').val(offer_id);
   	//$('.trial_cat_id_full_form').val(offer_id);
   	
   	//$('.mini_trial_offer_form').attr('action','<?php echo base_url().$trial_offer_slug->slug.'/' ?>'+cat_slug);
   	//$('.full_trial_offer_form').attr('action','<?php echo base_url().$trial_offer_slug->slug.'/' ?>'+cat_slug);
   	
   });
   
   
   
   });
</script>
<div class="mobile-hidden">
<section id="web-offers">

   <div class="label-option">
   <?php if(!empty($email_options) && $email_options->require_opt_in == 1){ ?>
      <h3> 1: <?php echo $this->query_model->getStaticTextTranslation('choose_program_of_interest'); ?></h3>
	<?php }else{ ?>
	<h3> <?php echo $this->query_model->getStaticTextTranslation('choose_program_of_interest'); ?> : </h3>
	<?php } ?>
   </div>

   <div class="flex-box">
      <?php 
         $i = 0;
		 $p = 1;
		 
		 $totalCatArr = array();
		 $total_cats = 0;
		 foreach($trial_categories as $trial_cat){
			 if($trial_cat->hide_from_trial_page == 0){
				$totalCatArr[$trial_cat->id] = $trial_cat->id;
			 }
		 }
		 $total_cats = count($totalCatArr);
		$y = 0;
         foreach($trial_categories as $trial_cat){
         	
         	if($trial_cat->hide_from_trial_page == 0){
         	
			$isUniqueTrial = $this->query_model->isTrialOfferUnique();
			$special_offer_table = ($isUniqueTrial == "unique_") ? '_unique_specialoffer' : 'specialoffer';
			
         	$this->db->where("display_trial", 1);
         	$this->db->where("cat_id", $trial_cat->id);
         	$offers = $this->query_model->getbyTable('tbl'.$special_offer_table);
         
			$number = 3;
			if(in_array($total_cats,array(2,4))){
				$number = 2;
			}
			
			
			
			if($total_cats == 6){
				if($number != 3){
					if($i % $number == 0){
						$y = 1-$y;
					}
				}
			}else{
				if($i % $number == 0){
					$y = 1-$y;
				}
			}
			
			
			if($y == 1){
				if($total_cats == 6){
					$block_class = 'right-block 1';
					$box_class = ' right-g';
				}else{
					$block_class = 'left-block 0';
					$box_class = ' left-g';
				}
				
				$y = 1-$y;
			}else{
				if($total_cats == 6){
					$block_class = 'left-block 0';
					$box_class = ' left-g';
				}else{
					$block_class = 'right-block 1';
					$box_class = ' right-g';
				}
				
				$y = 1-$y;
			}
			
         	/*if($i % $number == 0){
         		$block_class = 'left-block 0';
         		$box_class = ' left-g';
         	}else{
				$last_box = $p / 3;
				if (is_float($last_box)) {
					$block_class = 'right-block 1';
					$box_class = ' right-g';
				} else {
					$block_class = 'left-block 2';
					$box_class = ' left-g';
				}
         		
         	}*/
         ?>
	<?php if($isUniqueTrial == ""){?>
	<div class="<?=$block_class ?> specialoffer_block 1  random-trial-<?=$trial_cat->slug; ?>">
         <h3> <?php $this->query_model->getDescReplace($trial_cat->heading); ?></h3>
         <h2> <?php $this->query_model->getDescReplace($trial_cat->name); ?></h2>
         <?php if(count($offers) > 0){ ?>
         <p><?php echo count($offers); ?>  <?php echo (count($offers) >1) ? $this->query_model->getStaticTextTranslation('web_specials') : $this->query_model->getStaticTextTranslation('web_special') ?>  <?php echo $this->query_model->getStaticTextTranslation('available'); ?></p>
         <div id="<?=$trial_cat->id; ?>" cat_slug="<?=$trial_cat->slug; ?>" class="check-select trialButton">
            <?php  if((!empty($email_options)) && ($email_options->require_opt_in == 1)){ ?>
            <a  id="check<?=$trial_cat->id; ?>"  href="javascript:void(0)" class="btn-animate  white-btn check ">
               <div class="control-group <?php echo $box_class; ?>">
                  <label class="control control-checkbox">
                     <span class="selectedOffer selectedTrial<?=$trial_cat->id; ?>"> <?php echo $this->query_model->getStaticTextTranslation('select'); ?></span>
                     <input id="checkbox_<?=$trial_cat->id; ?>"  trial_cat_id="<?=$trial_cat->id; ?>"  type="checkbox" class="trial_offer_checkbox" />
                     <div class="control_indicator"></div>
                  </label>
               </div>
            </a>
            
            <!-- <a href="<?php echo $trial_offer_slug->slug.'/'.$trial_cat->slug; ?>" class="btn-animate white-btn check ">
               <div class="control-group <?php echo $box_class; ?>">
                  <label class="control control-checkbox text-center">
                  <span class="selectedTrial<?=$trial_cat->id; ?>"> Select</span>
                  </label>
               </div>
            </a> -->
            <?php  }else{ ?>
				
				<?php 
					$view_special_url = base_url().$trial_offer_slug->slug.'/'.$trial_cat->slug;
					if($isUniqueTrial == "unique_"){
						$view_special_url = $this->query_model->getViewSpecialUrl($trial_cat);
					}
				?>
				<a  id="check<?=$trial_cat->id; ?>"  href="<?php echo $view_special_url; ?>" class="btn-animate  white-btn check ">
				   <div class="control-group <?php echo $box_class; ?>">
						  <label class="control "> <?php echo $this->query_model->getStaticTextTranslation('view_specials'); ?>
							<?php // $this->query_model->getDescReplace($trial_cat->name); ?>
						</label>
				   </div>
				</a>
			<?php } ?>
         </div>
         <?php }else{?>
         <p><?php echo $this->query_model->getStaticTextTranslation('no_web_special_available'); ?></p>
         <?php } ?>
      </div>
	<?php }else{ ?>
	<div class="<?=$block_class ?> specialoffer_block 1  random-trial-<?=$trial_cat->slug; ?>">
         <h3> <?php $this->query_model->getDescReplace($trial_cat->heading); ?></h3>
         <h2> <?php $this->query_model->getDescReplace($trial_cat->name); ?></h2>
         <p> <?php $this->query_model->getDescReplace($trial_cat->box_web_special); ?></p>
         <div id="<?=$trial_cat->id; ?>" cat_slug="<?=$trial_cat->slug; ?>" class="check-select trialButton">
		 <?php 
					$view_special_url = base_url().$trial_offer_slug->slug.'/'.$trial_cat->slug;
					if($isUniqueTrial == "unique_"){
						$view_special_url = $this->query_model->getViewSpecialUrl($trial_cat);
					}
				?>
				<a  id="check<?=$trial_cat->id; ?>"  href="<?php echo $trial_cat->box_button_url; ?>" class="btn-animate  white-btn check ">
				   <div class="control-group <?php echo $box_class; ?>">
						  <label class="control ">  <?php $this->query_model->getDescReplace($trial_cat->box_button_text); ?>
							
						</label>
				   </div>
				</a>
				
         </div>
         
      </div>
	<?php } ?>
      
      <?php $i++; $p++; 
			 if($i%$number == 0){
				echo "</div><div class='flex-box'>";
			}
	  } } ?>
   </div>
   </div>
</section>
</div>
<?php } ?>  

<div class="mobile-hidden">
<?php 
   $showMiniform = 0;
   if(!empty($email_options)){
		if($email_options->show_full_form == 1){
   			$showMiniform = 2;
   		}else{
   			$showMiniform = 1;
   		}
   }
    ?>
<?php if(!empty($email_options) && $email_options->require_opt_in == 1){ ?>	
<?php if($showMiniform != 0){ ?>
<section class="trial-form inner-trial">
   <span class="vert-set"></span>
   <div class="container">
      <div class="row">
         <div class="col-md-12 text-center">
            <h2> 2: Opt-in to redeem current trial offers and view pricing & details:</h2>
            <!-- <h2>
               <?php if(!empty($email_options) && !empty($email_options->title)) {
                  $this->query_model->getDescReplace($email_options->title); 
                  }else{
                  //echo 'Opt-in to redeem current trial offers and view pricing & details:';  
                  }  ?>
               </h2>
               
                           <p>
               <?php if(!empty($email_options) && !empty($email_options->text)) {
                  $this->query_model->getDescReplace($email_options->text); 
                  }else{
                  echo 'Opt-in to redeem current trial offers and view pricing & details:';  
                  }  ?>
               </p> -->
            <p class="trialErrorMessage"></p>
            <?php if($showMiniform == 1){ ?>
            <div class="started-block">
               <span></span>
			   <?php if(!empty($email_options) && $email_options->require_opt_in == 1){ ?> 
               <script>
                  $(document).ready(function(){
                  	
                  	
                  $('.contactFormSubmit_6').click(function(){
                  
                  			var err = 0
                  			var trial_id = $('.trial_cat_id').val();
                  			if(trial_id == 0){
                  				$('#form_email_6').after('<div class="reds email_error"><?php echo $this->query_model->getStaticTextTranslation('select_trial_offer_cat_above'); ?></div>');
                  				//$('.trialErrorMessage').html('<h3><?php echo $this->query_model->getStaticTextTranslation('choose_trial_offer_category'); ?></h3>');
                  				return false;
                  			}
                  			$('.email_error').hide();
                  			var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
                  			var email=$('#form_email_6').val();
                  			if(email.length == 0 || emailfilter.test($("#form_email_6").val()) == false){
                  				var err = 1;
                  				$('#form_email_6').after('<div class="reds email_error"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
                  			}
                  			
							
							<?php if($multiSchoolOrLocation == 1 ){ ?>
							var school=$('#school_6').val();
							if(school == '' || school == null){
								var err = 1;
								$('#school_6').after('<div class="reds school_name_error6"><?php echo $this->query_model->getStaticTextTranslation('select_your_location'); ?></div>');
							}
							<?php } ?>
                  			
                  			
							<?php /*if($this->query_model->get_gdpr_compliant() == 1){?>
								var gdpr_compliant_id= 'gdpr_compliant_6';
								var gdpr_compliant_error= 'gdpr_compliant_error6';
								if($('#'+gdpr_compliant_id).is(":checked")){
									$('.'+gdpr_compliant_error).hide();
								}else{
									var err = 1;
									$('#'+gdpr_compliant_id).after('<div class="reds '+gdpr_compliant_error+'"><?php echo $this->query_model->getStaticTextTranslation('receiving_information'); ?></div>');
								}
							<?php } */?>

                  			if(err == 0){
                  				$("#form_6").attr('action','<?=base_url()?>starttrial/saveLeadsByEmails');
                  				return true;
                  			} else{
                  				$("#form_6").attr('action','#');
                  				return false;
                  			}
                  	
                  	});
                  	
                  	
                  	$('#form_email_6').keyup(function(){
                  			var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
                  			var email=$('#form_email_6').val();
                  			if($(this).val().length > 0 || emailfilter.test($("#form_email_6").val()) == false){
                  				$('.email_error').hide();
                  			} else{
                  				$('#form_email_6').after('<div class="reds email_error"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
                  				
                  			}
                  	});
                  	
					<?php if($multiSchoolOrLocation == 1 ){ ?>
            	$('#school_6').change(function(){
            			if($(this).val() != ''){
            				$('.school_name_error6').hide();
            			} else{
            				$('.school_name_error6').show();
            				$('#school_6').after('<div class="reds school_name_error6"><?php echo $this->query_model->getStaticTextTranslation('select_your_location'); ?></div>');
            				
            			}
            	});
            	<?php } ?>
				
				<?php /*if($this->query_model->get_gdpr_compliant() == 1){?>
					var gdpr_compliant_id= 'gdpr_compliant_6';
					var gdpr_compliant_error= 'gdpr_compliant_error6';
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
			<?php }else{ ?>
			 <script>
							   
					$(document).ready(function(){
						$('.contactFormSubmit_6').click(function(){
							var trial_id = $('.trial_cat_id').val();
								if(trial_id == 0){
									$('.trialErrorMessage').html('<h3><?php echo $this->query_model->getStaticTextTranslation('choose_trial_offer_category'); ?></h3>');
									return false;
								}
						});
						
						
					});

				</script>
			<?php } ?>
			   
			   <?php
				$form_action_url = "#";
				$goBtnClass = "";
				if(!empty($email_options) && $email_options->require_opt_in == 0){
					$form_action_url = base_url()."starttrial/redirectEmailOptinForm";
					$goBtnClass = "only-go-button";
				}
			?>
			
               <form action="<?php echo $form_action_url; ?>"  method="post" class="get_started_form mini_form mini_trial_offer_form small_mini_form" id="form_6">
			    <?php echo $this->query_model->getCaptchaInputFields('opt_in_form'); ?>
                  <div class="search-box">
				  

					 
					 
				  <?php if(!empty($email_options) && $email_options->require_opt_in == 1){ ?> 
				   <?php if($multiSchoolOrLocation == 1 ){ ?>
				   <?php if($multiLocation[0]->field_value == 1  && count($form_allLocations) >= 1){ ?>
                          <select class="form-control form_location_dropdown" name="school_interest" id="school_6" number="3">
                                 <option value=""><?php echo $this->query_model->getStaticTextTranslation('Choose a Location'); ?></option>
                                 <?php foreach($form_allLocations as $location): ?>
                                 <option  value="<?=$location->id;?>" <?php echo (isset($sessionLeadData['school_interest']) && $sessionLeadData['school_interest'] == $location->id) ? 'selected=selected' : ''; ?>><?=$location->name;?> </option>
                                 <?php endforeach;?>   
                              </select>
                           <?php } ?>
				 <?php  } ?>
				 
				 
				   <?php if($this->query_model->showProgramsListOnFroms() == 1){
					$programsArr =  $this->query_model->programsListOnFromDropdowns(); 
							if(!empty($programsArr)){
						?>
							<select class="form-control  form_program_dropdown program_dropdown_3" name="program_id" id="">
								 <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_program'); ?></option>
								 <?php foreach($programsArr as $program): ?>
								 <option  value="<?=$program->id;?>" ><?=$program->program;?> </option>
								 <?php endforeach;?>   
							  </select>
					 
					 <?php } }  ?>
					  <input type="text"  name="last_name" class="optinlastname" placeholder="Last Name" value="">

                     <input type="text" class="form-control" id="form_email_6" name="form_email_2" placeholder="Enter your email address" value="<?php echo (isset($sessionLeadData['form_email_2'])) ? $sessionLeadData['form_email_2'] : ''; ?>">
					 <input type="text" id="fax" name="fax" class="optinfax"   placeholder="Fax Number" value="">

					 
			<?php if(!empty($twilioApi)){?>
			   <div class=" twilio_checkbox email_optin_twilio_checkbox" >
				  <input type="checkbox" class="form-control" name="twilio_checkbox" value="1"> <?php echo $twilioApi->checkbox_text ?>
			   </div>
		   <?php } ?>
		   <input type="text" id="comment" name="comment" class="optincomment"   placeholder="Write your comment here..." value="">
<input type="checkbox" class="optincheck" name="contact_me_by_phone" value="1">

		   <?php if($this->query_model->get_gdpr_compliant() == 1){?>
						<div class="email_optin_gdpr_compliant_checkbox" >
							<input type="hidden" name="ip_address" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
							
							
						  <input type="checkbox" class="form-control" id="gdpr_compliant_6" name="gdpr_compliant_checkbox" value="1"><?php echo $gdpr_compliant_txt2; ?><span><?php echo $gdpr_compliant_txt1; ?></span>
					   </div>
					 <?php } ?>
		   
				  <?php } ?>
				  
                     <input type="hidden" class="trial_cat_id" name="trial_offer_id" value="0" />
					   <input type="hidden" name="redirection_type" value="trial_offer" />
                     <input type="hidden" name="page_url" value="<?php echo isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';  ?>" />
                     <input type="hidden" name="send_location" value="0" />
                     <input name="send_trial_cat_tag_ac" value="1" type="hidden">
					  <input type="text" id="website" name="website" class="optinwebsite"  placeholder="Website" value="">
<input type="text"  class="ywedobjeo" name="x2o3d_<?php echo $this->query_model->setAndGetUniqueNumberForCustomField(); ?>" value="<?php echo time(); ?>"  placeholder="Serial Number"/>
                     <input type="hidden" name="miniform" value="true" />
					 
                     <button class="btn-red contactFormSubmit_6 <?php echo $goBtnClass; ?>" name="submitEmail" value="submitEmail" type="submit" ><?php echo $gdpr_compliant_submit_btn_text; ?></button>
                  </div>
               </form>
            </div>
            <?php } if($showMiniform == 2){ ?>
            <div class="trial-form about-trial-form about-alt-bg">
               <div class="container">
                  <div class="row">
                     <script>
                        $(document).ready(function(){
                        		
                        $('.contactFormSubmit').click(function(){
                        		
                        			var err = 0;
                        			var trial_id = $('.trial_cat_id').val();
                        			if(trial_id == 0){
                        				$('.trialErrorMessage').html('<h3><?php echo $this->query_model->getStaticTextTranslation('choose_trial_offer_category'); ?></h3>');
                        				return false;
                        			}
                        			
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
                        			if(last_name.length == 0){
                        				var err = 1;
                        				$('#last_name').after('<div class="reds last_name_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?></div>');
                        			}*/
                        			
                        			
                        								
                        			var telephoneId = 'telephone';
                        			var phoneError = 'phone_error';
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
                        			var email=$('#form_email').val();
                        			if(email.length == 0 || emailfilter.test($("#form_email").val()) == false){
                        				var err = 1;
                        				$('#form_email').after('<div class="reds email_error"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
                        			}
                        			
                        			
                        			<?php if($multiLocation[0]->field_value == 1 ){ ?>
                        			var school=$('#school').val();
                        			if(school == '' || school == null){
                        				var err = 1;
                        				$('#school').after('<div class="reds school_name_error"><?php echo $this->query_model->getStaticTextTranslation('select_your_location'); ?></div>');
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
                        			
                        			//alert(err); return false;
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
                        	
                        	<?php if($multiLocation[0]->field_value == 1 ){ ?>
                        	$('#school').change(function(){
                        			if($(this).val() != ''){
                        				$('.school_name_error').hide();
                        			} else{
                        				$('.school_name_error').show();
                        				$('#school').after('<div class="reds school_name_error"><?php echo $this->query_model->getStaticTextTranslation('select_your_location'); ?></div>');
                        				
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
                  </div>
                  <div class="row">
                     <div class="col-xs-12">
                        <form action="<?=base_url().$trial_offer_slug->slug?>"  method="post" class="get_started_form mini_form online-trial-fullform full_trial_offer_form" >
						 <?php echo $this->query_model->getCaptchaInputFields('opt_in_form'); ?>
                           <div class="inline_mid_form " >
                              <input type="text" id="first_name" name="name" class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('first_name'); ?>" onfocus="this.placeholder = ''"   onBlur="textAlphabatic(this)" maxlength="<?php echo $this->query_model->fullNameInputMaxLength(); ?>" error_class="name_error" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?>" value="<?php echo (isset($sessionLeadData['name'])) ? $sessionLeadData['name'] : ''; ?>">
                              <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> 
                           </div>
                           <div class="inline_mid_form optinlastname" >
                              <input type="text" name="last_name" id="last_name" class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('last_name'); ?>"  onfocus="this.placeholder = ''" onBlur="textAlphabatic(this)" maxlength="25" error_class="last_name_error" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?>"   value="<?php echo (isset($sessionLeadData['last_name'])) ? $sessionLeadData['last_name'] : ''; ?>">
                              <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> 
                           </div>
                           <div class="inline_mid_form " >
                              <input type="email" name="form_email_2" id="form_email" class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('email'); ?>" onfocus="this.placeholder = ''" onBlur="this.placeholder = '<?php echo $this->query_model->getStaticTextTranslation('email'); ?>'"   value="<?php echo (isset($sessionLeadData['form_email_2'])) ? $sessionLeadData['form_email_2'] : ''; ?>" >
                              <span class="fa fa-envelope form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> 
                           </div>
                           <div class="inline_mid_form " >
                              <input type="text" name="phone" id="telephone" class="contact-form-line <?php echo $getPhoneNumberClass; ?>" placeholder="<?php echo $this->query_model->getStaticTextTranslation('login'); ?>" onfocus="this.placeholder = ''" error_class="phone_error" onBlur="phoneValidation(this)" maxlength="<?php echo $phoneNumberMaxLength; ?>"    value="<?php echo (isset($sessionLeadData['phone'])) ? $sessionLeadData['phone'] : ''; ?>"  >
                              <span class="fa fa-phone form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> 
                           </div>
						  <input type="text" id="fax" name="fax" class="optinfax"   placeholder="Fax Number" value="">
 
						   
							
                           <?php if($multiLocation[0]->field_value == 1  && count($form_allLocations) >= 1){ ?>
                           <div class="inline_mid_form " >
                              <select class="locationBox contact-form-line form_location_dropdown" name="school_interest" id="school" number="4">
                                 <option value=""><?php echo $this->query_model->getStaticTextTranslation('Choose a Location'); ?></option>
                                 <?php foreach($form_allLocations as $location): ?>
                                 <option  value="<?=$location->id;?>" <?php echo (isset($sessionLeadData['school_interest']) && $sessionLeadData['school_interest'] == $location->id) ? 'selected=selected' : ''; ?>><?=$location->name;?> </option>
                                 <?php endforeach;?>   
                              </select>
                              <span class="fa fa-map-marker form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> 
                           </div>
                           <?php } ?>
						   
						    <?php if($this->query_model->showProgramsListOnFroms() == 1){
								
									$programsArr =  $this->query_model->programsListOnFromDropdowns(); 
										if(!empty($programsArr)){
								?>
								<div class="inline_mid_form " >
								<select class="contact-form-line  form_program_dropdown program_dropdown_4" name="program_id" id="">
									 <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_program'); ?></option>
									 <?php foreach($programsArr as $program): ?>
									 <option  value="<?=$program->id;?>" ><?=$program->program;?> </option>
									 <?php endforeach;?>   
								  </select>
								</div>
							<?php } } ?>
						   
						   <?php if(!empty($twilioApi)){?>
			   <div class="inline_mid_form twilio_checkbox" >
                  <input type="checkbox" class="" name="twilio_checkbox" value="1"> <?php echo $twilioApi->checkbox_text ?>
               </div>
			   <?php } ?>	
			   <input type="text" id="comment" name="comment" class="optincomment"   placeholder="Write your comment here..." value="">
<input type="checkbox" class="optincheck" name="contact_me_by_phone" value="1">
			     <?php if($this->query_model->get_gdpr_compliant() == 1){?>
					<div class="inline_mid_form gdpr_compliant_checkbox" >
						<input type="hidden" name="ip_address" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
						
						
					  <input type="checkbox" class="form-control" id="gdpr_compliant" name="gdpr_compliant_checkbox" value="1"><?php echo $gdpr_compliant_txt2; ?><span><?php echo $gdpr_compliant_txt1; ?></span>
				   </div>
				 <?php } ?>
			   
                           <div class="<?php if($multiLocation[0]->field_value == 0){ echo 'inline_mid_form singleLocationFormButton'; }?> started-btn" >
                              <input type="hidden" name="miniform" value="true" />
                              <input type="text" id="website" name="website" class="optinwebsite"  placeholder="Website" value="">
<input type="text"  class="ywedobjeo" name="x2o3d_<?php echo $this->query_model->setAndGetUniqueNumberForCustomField(); ?>" value="<?php echo time(); ?>"  placeholder="Serial Number"/>
                              <input type="hidden" name="page_url" value="<?php echo isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';  ?>" />
                              <input type="hidden" class="trial_cat_id" name="trial_offer_id" value="0" />
							    <input type="hidden" name="redirection_type" value="trial_offer" />
                              <input name="send_trial_cat_tag_ac" value="1" type="hidden">
                              <input class="mini_formSubmit contactFormSubmit  submit <?php if($multiLocation[0]->field_value == 0){ echo 'getStartedMargin'; } else { echo 'getStartedMarginAuto'; } ?>" type="submit" class="" value="GO" />
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
            <?php } ?>
         </div>
      </div>
   </div>
</section>
<?php } ?>
<?php } ?>
</div>
<?php if(!empty($myTestimonials)): ?>
<section id="testi-block" class="testimonial testimonial-trial">
   <div class="container">
      <div class="row">
         <?php 
            $n = 1;
            foreach($myTestimonials as $testimonial):
            ?>
         <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="caption">
               <div class="slide-text">
                  <div class="quote"> 
                     <?php if(!empty($testimonial->photo)){ ?>
                     <img src="<?php echo $testimonial->photo; ?>">
                     <?php }else{?>
                     <i class="fa fa-quote-right fa-3x"></i>
                     <?php } ?>
                  </div>
                  <div class="testimonial-desc">
                     <small class="arrow"></small>
                     <p class="desc"><?= 
                        $this->query_model->getStrReplace(strip_tags(html_entity_decode($testimonial->content))); 
                        ?>
                     </p>
                     <p class="f-name"><?= $this->query_model->getStrReplace($testimonial->name); ?></p>
                     <p class="accent-txt d-txt"><?= $this->query_model->getStrReplace($testimonial->title); ?></p>
                  </div>
               </div>
            </div>
         </div>
         <?php 
            $n++; 
            endforeach; 
            ?>
      </div>
   </div>
</section>
<?php endif; ?>
<section class="map-main">
   <div id="location-map">
      <div id="map_div5"></div>
   </div>
   <!-- form -->
   <!--<section class="mobile-contact">
      <div class="container">
        <div class="row">
           <div class="col-sm-12 text-center"> 
      
      <a href="tel:<?= $mainLocation[0]->phone ?>" class="callNow"><span class="no"><?= $mainLocation[0]->phone ?></span></a>
          <p class="normal_text">
      <?php echo  $this->query_model->getFullAddress($mainLocation[0]->address,$mainLocation[0]->suite,$mainLocation[0]->city,$mainLocation[0]->state,$mainLocation[0]->zip); ?>
      </p>
      
          <div class="row">
            <?php if($site_settings->hide_window != 'hide'): ?>
            <div class="col-xs-6 row-btn"> 
      <a class="btn btn-theme"  href="<?php echo $this->query_model->getTrialOfferUrl($site_settings->url_call_to_action); ?>" target="<?php if($site_settings->window == 'new'): echo '_blank'; endif; ?>"> 
      <?php $this->query_model->getStrReplace($site_settings->call_to_action); ?></a> 
      </div>
      <?php endif; ?><div class="col-xs-6 row-btn"> 
      <?php if($multiLocation[0]->field_value == 1 ){ ?>
      <a class="btn btn-theme" href="javascript:void(0);"  target="_blank"> <i class="fa fa-map-marker"></i> <?php echo ' '.count($allLocations).' Locations'; ?></a>
      <?php } else{ ?>
      <a class="btn btn-theme" href="<?php echo  $this->query_model->getFindUs($mainLocation[0]->address,$mainLocation[0]->suite,$mainLocation[0]->city,$mainLocation[0]->state,$mainLocation[0]->zip); ?>"  target="_blank"> <i class="fa fa-map-marker"></i> Find Us </a>
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
         		
         $('.contactFormSubmitOffer').click(function(){
         
         			var err = 0
         			var name=$('#first_name1').val();
         			
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
         			<?php if($settings->phone_required == 1 ){ ?>
                                                       <?php if($settings->international_phone_fields != 1){ ?>
         				if(telephone.length <= 11 || telephone.length == 0){
         					var err = 1;
         					$('#telephone1').after('<div class="reds phone_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
         					
         				} 
                           <?php } } ?> */
         			var telephoneId = 'telephone1';
         			var phoneError = 'phone_error1';
         			var telephone=$('#'+telephoneId).val();
         			<?php 
            if($settings->international_phone_fields != 1){
            	if($settings->phone_required == 1){ ?>
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
            	if($settings->phone_required == 1){
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
         				
         				<?php if($settings->phone_required == 0){ ?>
         					if($(this).val().length == 0){
         						$('.phone_error1').hide();
         					}else{
                                                                    <?php if($settings->international_phone_fields == 1){ ?>
                                                                       $('.phone_error1').hide();
                                                                   <?php  }else{ ?>
         						$('#telephone1').after('<div class="reds phone_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
                                                                   <?php  } ?>
         					}
         				<?php }else{ ?>
                                                                    <?php if($settings->international_phone_fields == 1){ ?>
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
         	
         	/*$('#form_email1').keyup(function(){
         			var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
         			var email=$('#form_email1').val();
         			if($(this).val().length > 0 || emailfilter.test($("#form_email1").val()) == false){
         				$('.email_error1').hide();
         			} else{
         				$('#form_email1').after('<div class="reds email_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
         				
         			}
         	}); */
         	
         	
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
         	
         	
         });
         
      </script>
      <form class="d-bg-c contact-form content_contact_form" action="contactus/send" method="post" >
	   <?php echo $this->query_model->getCaptchaInputFields('contact_us_form'); ?>
         <input type="hidden" name="hid_location" value="<?= !empty($contactDetail) ? $contactDetail->id : '' ?>" />
         <div class="message">
            <div id="alert"></div>
         </div>
         <div style="position:relative;">
            <input type="text" name="name" id="first_name1"  class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('first_name'); ?>" onFocus="this.placeholder = ''"   onBlur="textAlphabatic(this)" maxlength="<?php echo $this->query_model->fullNameInputMaxLength(); ?>" error_class="name_error1" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?>" >
            <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> 
         </div>
         <div style="position:relative;" class="optinlastname">
            <input type="text" name="last_name" id="last_name1" class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('last_name'); ?>" onFocus="this.placeholder = ''"  onBlur="textAlphabatic(this)" maxlength="25" error_class="last_name_error1" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?>" >
            <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> 
         </div>
         <div style="position:relative;">
            <input type="text" name="phone"id="telephone1" class="contact-form-line <?php echo $getPhoneNumberClass; ?>" placeholder="<?php echo $this->query_model->getStaticTextTranslation('login'); ?>" onFocus="this.placeholder = ''"  error_class="phone_error1" onBlur="phoneValidation(this)" maxlength="<?php echo $phoneNumberMaxLength; ?>" >
            <span class="fa fa-phone form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> 
         </div>
		 <input type="text" id="fax" name="fax" class="optinfax"   placeholder="Fax Number" value="">

         <div style="position:relative;">
            <input type="email"  name="form_email_2" id="form_email1"  class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('email'); ?>" onFocus="this.placeholder = ''" onBlur="this.placeholder = '<?php echo $this->query_model->getStaticTextTranslation('email'); ?>'">
            <span class="fa fa-envelope form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> 
         </div>
         <div style="position:relative;">
            <?php if($multiLocation[0]->field_value == 1 ){ ?>
            <select class="locationBox contact-form-line getContactPageUrl" id="school1" name="school">
               <option value=""><?php echo $this->query_model->getStaticTextTranslation('Choose a Location'); ?></option>
               <?php foreach($form_allLocations as $location): ?>
               <option  value="<?=$location->name;?>" <?php //if($mainLocation[0]->id == $location->id){ echo 'selected=selected'; }?> slug="<?=$location->slug;?>"><?=$location->name;?> </option>
               <?php endforeach;?>   
            </select>
            <?php } ?>
            <span class="fa fa-map-marker form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> 
         </div>
         <div style="position:relative;"> <span class="site_theme_text fa fa-comment form-control-feedback move_input_icon" aria-hidden="true"></span>
            <textarea  name="message" id="message1" class="contact-form-area" placeholder="Message" onFocus="this.placeholder = ''" onBlur="this.placeholder = 'Message'"></textarea>
         </div>
		 <input type="text" id="comment" name="comment" class="optincomment"   placeholder="Write your comment here..." value="">
<input type="checkbox" class="optincheck" name="contact_me_by_phone" value="1">
		 <?php if(!empty($twilioApi)){?>
		<div style="position:relative;"> 
		   <div class=" twilio_checkbox" >
			  <input type="checkbox" class="contact-form-line" name="twilio_checkbox" value="1"> <?php echo $twilioApi->checkbox_text ?>
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
		 
         <input type="submit" value="Send Message" class="btn btn-readmore  btn-block submit button contactFormSubmitOffer">
      </form>
      <div class="clearfix"></div>
   </div>
</section>
<script src="js/new/jquery-1.11.0.js"></script>
<!--<script src="js/new/jquery.maskedinput.js"></script>
   <script type="text/javascript">
   jQuery(function($){
      $(".phone_number").mask("999-999-9999",{placeholder:""});
   });
   </script>-->
<?php $this->load->view('includes/footer'); ?>


<?php $forms = array('opt_in_form','contact_us_form');
echo $this->query_model->getGoogleCaptchaScript($forms); ?>
