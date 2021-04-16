<?php $this->load->view('includes/header'); ?>

<?php  $this->load->view('includes/header/masthead'); ?>
<?php $phoneNumberMaxLength = $this->query_model->phoneNumberMaxLength(); 

	  $getPhoneNumberClass = $this->query_model->getPhoneNumberClass(); 
	  
	  $paymentDetail = $this->query_model->getbySpecific('tbl_payments','id',1);
	  
	
	  
	/*** getting gdpr text **/
 $gdprCompliantText = $this->query_model->getGdprCompliantText();
 $gdpr_compliant_txt1 = (isset($gdprCompliantText['gdpr_compliant_txt1'])) ? $gdprCompliantText['gdpr_compliant_txt1'] : '';
 $gdpr_compliant_txt2 = (isset($gdprCompliantText['gdpr_compliant_txt2'])) ? $gdprCompliantText['gdpr_compliant_txt2'] : '';
 $gdpr_compliant_submit_btn_text = (isset($gdprCompliantText['gdpr_compliant_submit_btn_text'])) ? $gdprCompliantText['gdpr_compliant_submit_btn_text'] : '';
?>
<?php $sessionLeadData = $this->session->userdata('sessionLeadsData');?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<?php 
	$topSection = 0;
	if($trial_offer_cat->text_or_video == "video"){
		if($trial_offer_cat->video_type == 'youtube_video'){
			if(!empty($trial_offer_cat->youtube_video)){
				$topSection = 1;
			}
		}elseif($trial_offer_cat->video_type == 'vimeo_video'){
			if(!empty($trial_offer_cat->vimeo_video)){
				$topSection = 1;
			}
		}
	}else{
		if(!empty($trial_offer_cat->text)){
			$topSection = 1;
		}
	}
?>

<?php if($topSection == 1){ ?>
  <section class="top-section" id="trial-kids" style="background-image:url('<?php echo 'upload/onlinespecial/'.$trial_offer_cat->left_photo; ?>')  !important;">
         <span class="overlay" style="<?php echo !empty($trial_offer_cat->background_color) ? 'background:'.$trial_offer_cat->background_color.' !important;' : ''; ?>"></span>
		 
         <div class="container">
            <div class="row">
			<?php if($trial_offer_cat->text_or_video == "video"){ ?>
				
			   <div class="col-md-8 col-md-push-2">
                  <!--<div class="player-inner"> -->
				   <?php if($trial_offer_cat->video_type == 'youtube_video'){ ?>
						<?php if(!empty($trial_offer_cat->youtube_video)){ ?>
								  <div class="video-inner">
									 <iframe  height="390" src="<?php echo $trial_offer_cat->youtube_video; ?>?rel=0&amp;controls=0&amp;showinfo=0&amp;autoplay=0" frameborder="0" allowfullscreen ></iframe>
									 <span class="video-overlay">
										<div class=""></div>
									 </span>
								  </div>
								   <?php } } else{ ?>
							  <?php if(!empty($trial_offer_cat->vimeo_video)){ ?>
							  <div class="video-inner">
									 <iframe  height="390" src="<?php echo $trial_offer_cat->vimeo_video; ?>?rel=0&amp;showinfo=0&amp;autoplay=0" frameborder="0" allowfullscreen ></iframe>
									 <span class="video-overlay">
										<div class=""></div>
									 </span>
								  </div>
								<?php } } ?> 
                  <!--</div> -->
                 
               </div>
			<?php }else{ ?>
				 <div class="col-md-12">
					  <div class="text-center header-text">
						 <h2><?= $this->query_model->getDescReplace($trial_offer_cat->text); ?></h2> 
					  </div>
				   </div>
				   
			<?php } ?>
              
			   
            </div>
         </div>
      </section>
<?php } ?>  
	  
	  <?php if($trial_offer_cat->show_icon_rows == 1){ ?>
      <section id="steps-3">
         <div class="container-fluid">
                         <div class="row">
                           <div class="col-sm-4">
                             <div class="icon">1</div>
                             <h3><?= $this->query_model->getDescReplace($trial_offer_cat->icon_1_text); ?></h3>
                           </div>
                           <div class="col-sm-4">
                             <div class="icon">2</div>
                             <h3><?= $this->query_model->getDescReplace($trial_offer_cat->icon_2_text); ?></h3>
                           </div>
                           <div class="col-sm-4">
                             <div class="icon">3</div>
                             <h3><?= $this->query_model->getDescReplace($trial_offer_cat->icon_3_text); ?></h3>
                           </div>
                         </div>
                       </div>
      </section>
	  <?php } ?>
	  
      <section class="trial-form border-none">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2><?= $this->query_model->getDescReplace($trial_offer_cat->text_2); ?></h2>

                 <div class="form-step text-center">
                     <h2><strong><?php echo $this->query_model->getStaticTextTranslation('step'); ?> 1:</strong> <?php echo $this->query_model->getStaticTextTranslation('choose_your_trial_offer'); ?> </h2>
                  </div>
                </div>
            </div>
        </div>
    </section>
		
    
       

<?php 
$query=$this->db->query('SELECT * FROM tblsite')->row();
$domain_host = base_url();
?>

<script>
	$(window).load(function(){
		
		var site_currency_type = $('#site_currency_type').val();
		
		$.each($('.trial_offer_checkbox'), function(){
		if($(this).is(':checked')){
				var offer_id = $(this).attr('number');
				
				var offer_type  = $(this).parent().parent().parent().parent().attr('offer');
				
				var cToken = $('#client_token').val();
				//alert(offer_type);
				$('#trial_id').val(offer_id);
				$('#trial_id').attr('offer', offer_type);
				
				
				$('#is_show_term_condition').val(0);
				$(".term_condition_box").hide();
				$(".term_condition_trial_"+offer_id).show();
				var show_term_condition = $('.show_term_condition_'+offer_id).val();
				
				$('.term_condition_checkbox').hide();
				$('.term_condition_checkbox').html('');
				if(show_term_condition == 1){
					$('.term_condition_checkbox').show();
					$('.term_condition_checkbox').html('<div class="checkbox  pull-left"><label><input type="checkbox" name="term_condition"  class="trial_offer_term_condition"  id="term_condition" value="1"><?php echo $this->query_model->getStaticTextTranslation('i_agree_term_condition'); ?></label></div>');
					$('#is_show_term_condition').val(1);
				}
				
				//var offer_type = $('#trial_id').attr('offer');
				
				//alert(offer_type);
				if(offer_type == 'free'){
					$('.trialform').attr('action','starttrial/buyspecial');
					$('.trialform').attr('method','post');
					
					$('#page_url').val('/starttrial/buyspecial');
					
					
					//new changes 31/july/2017
					$('#payment').hide();
					$('.submitOfferTrial').val('<?php echo $this->query_model->getStaticTextTranslation('get_started'); ?>');
					//$('.submitOfferTrial').addClass('btn-blue');
					//$('.submitOfferTrial').removeClass('btn-green');
					
					
					$('#thankyou-block').show();
					$('#dojocart_payment').show();
					$('.submitOfferTrial').show();
					$('.submitBrintreePaid').hide();
					//$('#term_condition').attr('required', false);
				}
				
				if(offer_type == 'paid'){
					var payment_url = $('#payment_url').val();
					var form_action_url = $('#form_action_url').val();
					var form_method = $('#form_method').val();
					//$('.trialform').attr('action','http://try.fitness/payment/buyoffer');
					$('.trialform').attr('action','<?php echo $domain_host; ?>payment/'+form_action_url);
					$('.trialform').attr('method','post');
					
					$('#page_url').val('/payment/'+payment_url);
					
					
					//new changes 31/july/2017
					$('#payment').show();
					$('.submitOfferTrial').val('<?php echo $this->query_model->getStaticTextTranslation('purchase_now'); ?>');
					//$('.submitOfferTrial').addClass('btn-green');
					//$('.submitOfferTrial').removeClass('btn-blue');
					var amount =  $(this).parent().parent().parent().parent().attr('amount');
					//alert(amount);
					$('#amount').val(amount);
					$('#main_offer_price').val(amount);
					$('.order-price').html(site_currency_type+amount);
					$('.offer-price').html(site_currency_type+amount);
					//$('#term_condition').attr('required', true);
					
					$('#thankyou-block').hide();
					$('#dojocart_payment').hide();
					
					if(cToken == 1){
						$('.submitOfferTrial').hide();
						$('.submitBrintreePaid').show();
					}else{
						$('.submitOfferTrial').show();
						$('.submitBrintreePaid').hide();
					}
					
					
					<?php if($stripePayment['stripe_payment'] == 1 && $stripePayment['stripe_sca_payment'] == 1 ){ 
							$mainLoc =  $this->query_model->getMainLocation();
							$location_id = $mainLoc[0]->id;
							
							if($multiLocation[0]->field_value == 0){
								
								$mainLoc =  $this->query_model->getMainLocation();
								$stripe_sca_location_id = $mainLoc[0]->id;
					?>
					
					
						var location_id = '<?php echo $stripe_sca_location_id ?>';
						var offer_type = $('#trial_id').attr('offer');
						var amount = $('#amount').val();
						
						if(amount > 0 && offer_type == "paid" && (location_id > 0)){
							amount = amount.replace('.','');
							$.ajax({

								url : '<?php echo base_url("starttrial/ajaxStripePaymentIntent"); ?>',
									type : 'POST',
									dataType :'json',
									data :{location_id:location_id, amount:amount, stripe_action: 'CreatePaymentIntent'},
									success:function(data){
										
										if(data.res == 1){
											//alert(data.payment_intent_id+ '==>'+data.client_secret);
											$('#payment_intent_id').val(data.payment_intent_id);
											$('.client_secret').attr('data-secret',data.client_secret);
										}
									}

							});
						}
					<?php } } ?>
					
					
				}
			
				
				var is_child_name  = $(this).parent().parent().parent().parent().attr('is_child_name');
				
				if(is_child_name== 1){
					$('#first_name').attr('placeholder',"<?php echo $this->query_model->getStaticTextTranslation('your_full_name'); ?>");
					$('.child_name_box').show();
				}else if(is_child_name == 0){
					$('#first_name').attr('placeholder',"<?php echo $this->query_model->getStaticTextTranslation('first_name'); ?>");
					$('.child_name_box').hide();
				}
				$('#is_child_name').val(is_child_name);
				$('#check'+offer_id).addClass('activeTrial');
				$('#checkbox_'+offer_id).prop( "checked", true );
				$('.selectedTrial'+offer_id).html('<?php echo $this->query_model->getStaticTextTranslation('selected') ?>');
				
		}
	});
	
	$(".submitOfferTrial").removeAttr('disabled');
	
	});
	$(document).ready(function(){
		
		var site_currency_type = $('#site_currency_type').val();
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
				$('#trial_id').val(offer_id);
				$('#trial_id').attr('offer', $(this).attr('offer'));
				
				
				$('#is_show_term_condition').val(0);
				$(".term_condition_box").hide();
				$(".term_condition_trial_"+offer_id).show();
				var show_term_condition = $('.show_term_condition_'+offer_id).val();
				$('.term_condition_checkbox').hide();
				$('.term_condition_checkbox').html('');
				if(show_term_condition == 1){
					$('.term_condition_checkbox').show();
					$('.term_condition_checkbox').html('<div class="checkbox  pull-left"><label><input type="checkbox" name="term_condition" class="trial_offer_term_condition" id="term_condition" value="1"><?php echo $this->query_model->getStaticTextTranslation('i_agree_term_condition'); ?></label></div>');
					$('#is_show_term_condition').val(1);
				}
				
				var offer_type = $('#trial_id').attr('offer');
				var cToken = $('#client_token').val();
			
				if(offer_type == 'free'){
					var form_action = $('.trialform').attr('action','starttrial/buyspecial');
					var form_action = $('.trialform').attr('method','post');
					
					$('#page_url').val('/starttrial/buyspecial');
					
					//new changes 31/july/2017
					$('#payment').hide();
					$('.submitOfferTrial').val('<?php echo $this->query_model->getStaticTextTranslation('get_started'); ?>');
					//$('.submitOfferTrial').addClass('btn-blue');
					//$('.submitOfferTrial').removeClass('btn-green');
					$('#thankyou-block').show();
					$('#dojocart_payment').show();
					$('.submitOfferTrial').show();
					$('.submitBrintreePaid').hide();
					//$('#term_condition').attr('required', false);
				}
				
				if(offer_type == 'paid'){
					var payment_url = $('#payment_url').val();
					var form_method = $('#form_method').val();
					var form_action_url = $('#form_action_url').val();
					//var form_action = $('.trialform').attr('action','payment/buyoffer');
					
					//var form_action = $('.trialform').attr('action','payment/'+payment_url);
					var form_action = $('.trialform').attr('action','<?php echo $domain_host; ?>payment/'+form_action_url);

					var form_action = $('.trialform').attr('method','post');
					
					$('#page_url').val('/payment/'+payment_url);
					
					//new changes 31/july/2017
					$('#payment').show();
					$('.submitOfferTrial').val('<?php echo $this->query_model->getStaticTextTranslation('purchase_now'); ?>');
					//$('.submitOfferTrial').addClass('btn-green');
					//$('.submitOfferTrial').removeClass('btn-blue');
					
					var amount =  $(this).attr('amount');
					$('#amount').val(amount);
					$('#main_offer_price').val(amount);
					$('.offer-price').html(site_currency_type+amount);
					$('.order-price').html(site_currency_type+amount);
					$('#thankyou-block').hide();
					$('#dojocart_payment').hide();
					
					if(cToken == 1){
						$('.submitOfferTrial').hide();
						$('.submitBrintreePaid').show();
					}else{
						$('.submitOfferTrial').show();
						$('.submitBrintreePaid').hide();
					}
					//$('#term_condition').attr('required', true);
					
					<?php if($stripePayment['stripe_payment'] == 1 && $stripePayment['stripe_sca_payment'] == 1 ){ 
							$mainLoc =  $this->query_model->getMainLocation();
							$location_id = $mainLoc[0]->id;
					?>
					var location_id = 0;
					<?php if($stripePayment['multi_location'] == 0){ ?>
						location_id = '<?php echo $location_id; ?>';
						
					<?php  }else if($stripePayment['multi_location'] == 1){ ?>
						location_id = $('.stripe_sca_location').val();
					<?php } ?>
					//alert(location_id);
						
						var offer_type = $('#trial_id').attr('offer');
						var amount = $('#amount').val();
						
						if(amount > 0 && offer_type == "paid" && (location_id > 0)){
							amount = amount.replace('.','');
							$.ajax({

								url : '<?php echo base_url("starttrial/ajaxStripePaymentIntent"); ?>',
									type : 'POST',
									dataType :'json',
									data :{location_id:location_id, amount:amount, stripe_action: 'CreatePaymentIntent'},
									success:function(data){
										
										if(data.res == 1){
											//alert(data.payment_intent_id+ '==>'+data.client_secret);
											$('#payment_intent_id').val(data.payment_intent_id);
											$('.client_secret').attr('data-secret',data.client_secret);
										}
									}

							});
						}
					<?php } ?>
				}
			
			
				$('#check'+offer_id).addClass('activeTrial');
				$('#checkbox_'+offer_id).prop( "checked", true );
				$('.selectedTrial'+offer_id).html('<?php echo $this->query_model->getStaticTextTranslation('selected') ?>');
				$('.trialErrorMessage').html('');
				
				var is_child_name = $(this).attr('is_child_name');
				
				$('#is_child_name').val(is_child_name);
				if(is_child_name== 1){
					$('#first_name').attr('placeholder',"<?php echo $this->query_model->getStaticTextTranslation('your_full_name'); ?>");
					$('.child_name_box').show();
					
				}else if(is_child_name == 0){
					$('#first_name').attr('placeholder',"<?php echo $this->query_model->getStaticTextTranslation('first_name'); ?>");
					$('.child_name_box').hide();
				}
				
				
			});
		
		
		 $('input.disablecopypaste').bind('copy paste', function (e) {
		   e.preventDefault();
		});
		
		$('.submitOfferTrial').click(function(){
			$('#paymentMethodResult').html('');
			$('#email').val($('#form_email').val());
			var trial_id = $('#trial_id').val();
			var cToken = $('#client_token').val();
			var offerType = $('#trial_id').attr('offer');
			
			if(trial_id == 0){
				$('.trialErrorMessage').html('<h3><?php echo $this->query_model->getStaticTextTranslation('select_trial_offers_above'); ?></h3>');
				return false;
			}
			
				
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
					if(last_name.length == 0){
						var err = 1;
						$('#last_name').after('<div class="reds last_name_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?></div>');
					}*/
					
					
					
					if($('#is_child_name').val() == 1){
						var child_name=$('#child_name').val();
						if(child_name.length == 0){
							var err = 1;
							$('#child_name').after("<div class='reds child_name_error'><?php echo $this->query_model->getStaticTextTranslation('enter_child_name'); ?></div>");
						}
					}
					
										
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
					
					
					<?php 
						if(!empty($all_programs)){ 
							if(count($all_programs) > 1){ 
					?>
					var program=$('#program1').val();
					if(program == '' || program == null){
						var err = 1;
						$('#program1').after('<div class="reds program_name_error1"><?php echo $this->query_model->getStaticTextTranslation('select_your_program'); ?></div>');
					}
					<?php } } ?>
			
					<?php if($multiLocation[0]->field_value == 1 ){ ?>
					var school=$('#school').val();
					if(school == '' || school == null){
						var err = 1;
						$('#school').after('<div class="reds school_name_error"><?php echo $this->query_model->getStaticTextTranslation('select_your_location'); ?></div>');
					}
					<?php } ?>
					
					var offerType = $('#trial_id').attr('offer');
					//alert(offerType);
					if(offerType == "paid"){
						<?php if($paymentDetail[0]->paypal_payment == 0){ ?>
						<?php if($paymentDetail[0]->stripe_ideal_payment == 1){ ?>
							
							
							var account_holder_name=$('#account_holder_name').val();
							//alert(card_name); return false;
							if(account_holder_name.length == 0){
								var err = 1;
								$('#account_holder_name').after('<div class="reds account_holder_name_error"><?php echo $this->query_model->getStaticTextTranslation('enter_account_name'); ?></div>');
							}
							
							var bank_name=$('#bank_name').val();
							if(bank_name == '' || bank_name == null){
								var err = 1;
								$('#bank_name').after('<div class="reds bank_name_error"><?php echo $this->query_model->getStaticTextTranslation('select_bank_name'); ?></div>');
							}
							
						<?php }else{?>
						var card_name=$('#card_name').val();
							//alert(card_name); return false;
							if(card_name.length == 0){
								var err = 1;
								$('#card_name').after('<div class="reds card_name_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_card_name'); ?></div>');
							}
								
						<?php if($stripePayment['stripe_payment'] == 1 && $stripePayment['stripe_sca_payment'] == 1 ){ ?> 
						
						<?php } else{ ?>
						
						var credit_card_number=$('#credit_card_number').val();
								//alert(credit_card_number); return false;
								if(credit_card_number.length == 0){
									var err = 1;
									$('#credit_card_number').after('<div class="reds credit_card_number_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_card_number'); ?></div>');
								}
								
						var cvv=$('#cvv').val();
								//alert(cvv); return false;
								if(cvv.length == 0){
									var err = 1;
									$('#cvv').after('<div class="reds cvv_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_cvv'); ?></div>');
								}
								
						
						var exp_month=$('#exp_month').val();
								if(exp_month == '' || exp_month == null){
									var err = 1;
									$('#exp_month').after('<div class="reds exp_month_error"><?php echo $this->query_model->getStaticTextTranslation('select_exp_month'); ?></div>');
								}
								
						var exp_year=$('#exp_year').val();
								if(exp_year == '' || exp_year == null){
									var err = 1;
									$('#exp_year').after('<div class="reds exp_year_error"><?php echo $this->query_model->getStaticTextTranslation('select_exp_year'); ?></div>');
								}
						<?php } ?>
						<?php } ?>
						<?php } ?>
						
						/*if($('#term_condition').is(':checked')){
							
						}else{
							var err = 1;
							$('#term_condition').after('<div class="reds term_condition_error">Check term and conditions</div>');
						} */
								
					}
					
					var is_show_term_condition = $("#is_show_term_condition").val();
					if(is_show_term_condition == 1){
						if($("#term_condition").is(":checked")){
							$('.term_condition_error').hide();
						}else{
							var err = 1;
							$('#term_condition').after('<div class="reds term_condition_error"><?php echo $this->query_model->getStaticTextTranslation('check_terms_conditions'); ?> </div>');
						}
					}
					
					
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
					$('#form_error').val(err);
					if(err == 0){
						<?php 
							/**$ip_address = $_SERVER['REMOTE_ADDR'];
							$this->db->where('ip_address_status',0);
							$lastMiniFormOrderDetail = $this->query_model->getBySpecific('tblorders','ip_address',$ip_address);
							
							if(!empty($lastMiniFormOrderDetail)){
								$updateData = array('ip_address_status' => 1);
								$this->query_model->update('tblorders',$lastMiniFormOrderDetail[0]->id,$updateData);
							} **/
						?>
						
						/*if(cToken == 1 && offerType == "paid"){
							 $('#tokenize').trigger('click');
							
						}else{
							return true;
						} */
						
						//$(this).prop('disabled', true);
						
						if(offerType == "paid"){
							<?php if(!empty($paymentDetail) && $paymentDetail[0]->braintree_payment == 1){?>
							var payment_method_nonce = $('#payment_method_nonce').val();
							if(payment_method_nonce != ""){
								$(this).hide();
								$(".submitBrintreePaid").hide();
							}else{
								$(this).hide();
								$("#paymentMethodResult").html('<div class="alert alert-danger"> <?php echo $this->query_model->getStaticTextTranslation('invalid_credit_card_detail'); ?></div>' ); 
								return false;
							}
								
								
							<?php }else{ ?>
							
								$(this).hide();
							<?php } ?>
						}else{
							$(this).hide();
						}
						
						$(this).after('<a href="javascript:void(0)" class="btn-blue btn-block processinBtn"  ><?php echo $this->query_model->getStaticTextTranslation('processing_please_wait'); ?></a>');
						return true;
						
					} else{
						//$(this).prop('disabled', false);
						
						if(offerType == "paid"){
							<?php if(!empty($paymentDetail) && $paymentDetail[0]->braintree_payment == 1){?>
								
								var payment_method_nonce = $('#payment_method_nonce').val();
								if(payment_method_nonce != ""){
									$(this).hide();
								}else{
									$(this).hide();
									$("#paymentMethodResult").html('<div class="alert alert-danger"> <?php echo $this->query_model->getStaticTextTranslation('invalid_credit_card_detail'); ?></div>' ); 
									return false;
								}
								
							<?php }else{ ?>
							
								$(this).show();
							<?php } ?>
						}else{
							$(this).show();
						}
						
						
						$('.processinBtn').hide();
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
			
			/*var is_child_name = $('#is_child_name').val();
			if(is_child_name == 1){
				$('#child_name').keyup(function(){
					if($(this).val().length > 0){
						$('.child_name_error').hide();
					} else{
						$('#child_name').after('<div class="reds child_name_error"><?php echo $this->query_model->getStaticTextTranslation('enter_child_name'); ?></div>');
						
					}
				});
			}*/
			
			if($('#is_child_name').val() == 1){
				$('#child_name').keyup(function(){
					if($(this).val().length > 0){
						$('.child_name_error').hide();
					} else{
						$('#child_name').after("<div class='reds child_name_error'><?php echo $this->query_model->getStaticTextTranslation('enter_child_name'); ?></div>");
						
					}
				});
				
			}
			
			/*$('#last_name').keyup(function(){
					if($(this).val().length > 0){
						$('.last_name_error').hide();
					} else{
						$('#last_name').after('<div class="reds last_name_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?></div>');
						
					}
			});*/
			
			$('#telephone').keyup(function(){
					/*if($(this).val().length <= 11){
						
						<?php if($site_settings->phone_required == 0){ ?>
							if($(this).val().length == 0){
								$('.phone_error').hide();
							}else{
                                                            <?php if($site_settings->international_phone_fields == 1){ ?>
                                                                $('.phone_error').hide();
                                                            <?php  }else{ ?>
								$('#telephone').after('<div class="reds phone_error"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
                                                            <?php  } ?>
							}
						<?php }else{ ?>
                                                            <?php if($site_settings->international_phone_fields == 1){ ?>
                                                                $('.phone_error').hide();
                                                            <?php  }else{ ?>
								$('#telephone').after('<div class="reds phone_error"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
                                                             <?php  } ?>
						<?php } ?>
					} 
					
					if($(this).val().length == 12){
						$('.phone_error').hide();
						
					}*/
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
			
			<?php 
				if(!empty($all_programs)){ 
					if(count($all_programs) > 1){ 
			?>
			$('#program1').change(function(){
					if($(this).val() != ''){
						$('.program_name_error1').hide();
					} else{
						$('.program_name_error1').show();
						$('#program1').after('<div class="reds program_name_error1"><?php echo $this->query_model->getStaticTextTranslation('select_your_program'); ?></div>');
						
					}
			});
			<?php } } ?>
			
			
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
		
			<?php if($paymentDetail[0]->paypal_payment == 0){ ?>
			<?php if($paymentDetail[0]->stripe_ideal_payment == 1){ ?>
					$('#account_holder_name').keyup(function(){
							if($(this).val().length > 0){
								$('.account_holder_name_error').hide();
							} else{
								$('#account_holder_name').after('<div class="reds account_holder_name_error"><?php echo $this->query_model->getStaticTextTranslation('enter_account_name'); ?></div>');
								
							}
					});
						
					$('#bank_name').change(function(){
						
						if($(this).val() != ''){
							$('.bank_name_error').hide();
						} else{
							$('.bank_name_error').show();
							$('#bank_name').after('<div class="reds bank_name_error"><?php echo $this->query_model->getStaticTextTranslation('select_bank_name'); ?></div>');
						}
				});
			<?php }else{ ?>
			
			$('#card_name').keyup(function(){
					if($(this).val().length > 0){
						$('.card_name_error').hide();
					} else{
						$('#card_name').after('<div class="reds card_name_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_card_name'); ?></div>');
						
					}
			});

			$("#credit_card_number").keydown(function(e) {
				// Allow: backspace, delete, tab, escape, enter and .
				if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
				  // Allow: Ctrl+A,Ctrl+C,Ctrl+V, Command+A
				  ((e.keyCode == 65 || e.keyCode == 86 || e.keyCode == 67) && (e.ctrlKey === true || e.metaKey === true)) ||
				  // Allow: home, end, left, right, down, up
				  (e.keyCode >= 35 && e.keyCode <= 40)) {
					 
				  // let it happen, don't do anything
				  return;
				}
				// Ensure that it is a number and stop the keypress
				if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				  e.preventDefault();
				}
				
			  });
  
			 /* $('#credit_card_number').keypress(function(event){

		       if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
		           event.preventDefault(); //stop character from entering input
		       }
			   
			   //event.target.value = event.target.value.replace(/[^0-9]/g,'')

			 }); */


			$('.cc_number').keyup(function(){
		        var ccnum = $(this).val();
		        var two_digit = ccnum.substr(0, 2);
		        

		        var reg_amcExp =  new RegExp('^3[47][0-9]{13}$');
		        if( two_digit == 34 || two_digit == 37 || reg_amcExp.test(ccnum)){
		          $('.cc_number').after('<div class="reds cc_number_error"><?php echo $this->query_model->getStaticTextTranslation('card_not_accecpted'); ?></div>');
		          $('.credit_card_number_error').hide();
		        } else{
		          $('.cc_number_error').hide();
		          $('.credit_card_number_error').hide();

		        } 


      });
			
			$('#credit_card_number').keyup(function(){
				
				
					if($(this).val().length > 0){
						var value = $(this).val();
						if (!$.isNumeric(value )) {
							$(this).val('');
							$('#credit_card_number').after('<div class="reds credit_card_number_error"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_credit_card_number'); ?></div>');
						}else{
							
							$('.credit_card_number_error').hide();
						}
					} else{
						$('#credit_card_number').after('<div class="reds credit_card_number_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_card_number'); ?></div>');
						
					}
			});
			
			$('#cvv').keyup(function(){
					if($(this).val().length > 0){
						$('.cvv_error').hide();
					} else{
						$('#cvv').after('<div class="reds cvv_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_cvv'); ?></div>');
						
					}
			});
			
			$('#exp_month').change(function(){
					if($(this).val() != ''){
						$('.exp_month_error').hide();
					} else{
						$('.exp_month_error').show();
						//$('#exp_month').after('<div class="reds exp_month_error">Select your Exp month</div>');
						
					}
			});
			
			$('#exp_year').change(function(){
					if($(this).val() != ''){
						$('.exp_year_error').hide();
					} else{
						$('.exp_year_error').show();
						//$('#exp_year').after('<div class="reds exp_year_error">Select your Exp year</div>');
						
					}
			});
			
			<?php } } ?>
			
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
			
			var is_show_term_condition = $("#is_show_term_condition").val();
					if(is_show_term_condition == 1){
						$('#term_condition').click(function(){
							if($(this).is(':checked')){
								$('.term_condition_error').hide();
							}else{
								$('.term_condition_error').show();
							}
						})
						
					}
			
			
			
			
			/*$('#term_condition').click(function(){
				if($(this).is(':checked')){
					$('.term_condition_error').hide();
				}else{
					$('.term_condition_error').show();
				}
			}) */
		
		
		
	});
</script>
	  



       <section id="web-offers" class="kids-trial-offer">
         <div class="flex-box">
			<?php echo $trials_value; ?>
		 </div>
      </section>
	  
	   <form action="starttrial/buyspecial" method="post" class="trialform" id="my-payment-form">
	   <?php echo $this->query_model->getCaptchaInputFields('trial_form'); ?>
      <section id="step-form">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="form-step text-center">
                     <h2><strong><?php echo $this->query_model->getStaticTextTranslation('step'); ?> 2:</strong> <?php echo $this->query_model->getStaticTextTranslation('fill_in_your_info_below'); ?></h2>
                    
		<div class="col-md-12 col-sm-12">
			   <div class="form-group text-left">
				  <h3><?php echo $this->query_model->getStaticTextTranslation('contact_information'); ?></h3>
			   </div>
			</div>			
          <div class="col-md-6 col-sm-6">
			<div class="form-group">
            <input type="text" value="<?php echo (isset($sessionLeadData['name'])) ? $sessionLeadData['name'] : ''; ?>" id="first_name" name="name" class="form-control" placeholder="<?php echo $this->query_model->getStaticTextTranslation('first_name'); ?>" onFocus="this.placeholder = ''"   onBlur="textAlphabatic(this)" maxlength="<?php echo $this->query_model->fullNameInputMaxLength(); ?>" error_class="name_error" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?>">
			</div>
		</div>
         <div class="col-md-6 col-sm-6 optinlastname">
			<div class="form-group">
            <input type="text" value="<?php echo (isset($sessionLeadData['last_name'])) ? $sessionLeadData['last_name'] : ''; ?>" id="last_name" name="last_name" class="form-control" placeholder="<?php echo $this->query_model->getStaticTextTranslation('last_name'); ?>" onFocus="this.placeholder = ''" onBlur="textAlphabatic(this)" maxlength="25" error_class="last_name_error" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?>"  >
           
			</div>
		</div>
		
		
           <div class="col-md-6 col-sm-6">
			<div class="form-group">
		  
            <input type="text" value="<?php echo (isset($sessionLeadData['form_email_2'])) ? $sessionLeadData['form_email_2'] : ''; ?>" id="form_email" name="form_email_2" class="form-control" placeholder="<?php echo $this->query_model->getStaticTextTranslation('email'); ?>" onFocus="this.placeholder = ''" onBlur="this.placeholder = '<?php echo $this->query_model->getStaticTextTranslation('email'); ?>'" >
            
			</div>
		</div>
		
		<div class="child_name_box" style="display:none">
			<div class="col-md-6 col-sm-6">
			<div class="form-group">
            <input type="text" value="" id="child_name" name="child_name" class="form-control" placeholder="<?php echo $this->query_model->getStaticTextTranslation('child_name'); ?>" onFocus="this.placeholder = ''"   onBlur="textAlphabatic(this)" maxlength="<?php echo $this->query_model->fullNameInputMaxLength(); ?>"" error_class="child_name_error" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_child_name'); ?>">
			</div>
		</div>
         <div class="col-md-6 col-sm-6">
			<div class="form-group">
            <input type="text" value="" id="child_age" name="child_age" class="form-control" placeholder="<?php echo $this->query_model->getStaticTextTranslation('child_age'); ?>"  maxlength="25">
           
			</div>
		</div>
		</div>
           <div class="col-md-6 col-sm-6">
			<div class="form-group">
            <input type="text"  value="<?php echo (isset($sessionLeadData['phone'])) ? $sessionLeadData['phone'] : ''; ?>"name="phone" id="telephone" class="form-control   <?php echo $getPhoneNumberClass; ?>" placeholder="<?php echo $this->query_model->getStaticTextTranslation('phone'); ?>" onFocus="this.placeholder = ''"  error_class="phone_error" onBlur="phoneValidation(this)" maxlength="<?php echo $phoneNumberMaxLength; ?>">
            
			</div>
			</div>
			<input type="text" id="fax" name="fax" class="optinfax"   placeholder="Fax Number" value="">

			<?php if($multiLocation[0]->field_value == 1  && count($trialLocations) >= 1){ ?>
			   <div class="col-md-6 col-sm-6">
				<div class="form-group">
				<select class=" form-control form_trial_location_dropdown <?php echo ($stripePayment['stripe_payment'] == 1 && $stripePayment['stripe_sca_payment'] == 1 ) ? 'stripe_sca_location' : ''; ?>" name="location_id" id="school" number="1">
				  <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_location'); ?></option>
				  <?php foreach($trialLocations as $location): ?>
						<option  value="<?=$location->id;?>"  <?php echo (isset($sessionLeadData['school_interest']) && $sessionLeadData['school_interest'] == $location->id) ? 'selected=selected' : ''; ?>><?=$location->name;?> </option>
				  <?php endforeach;?>   
				</select>
			   
				</div>
				</div>
			<?php  } ?>
			<div class="clearfix"></div>
			<?php if(!empty($all_programs)){?>
			
			<?php  if(count($all_programs) > 1){ ?>
			   <div class="<?php echo ($multiLocation[0]->field_value == 1  && count($trialLocations) >= 1) ?  'col-md-6 col-sm-6' : 'col-md-12 col-sm-12'?>">
				<div class="form-group">
				<select class="form-control form_trial_program_dropdown trial_program_dropdown_1"  name="program_id" id="program1">
				  <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_program'); ?></option>
				  <?php foreach($all_programs as $program): ?>
						<option  value="<?=$program->id;?>" <?php if(!empty($program_id) && $program_id == $program->id){ echo 'selected=selected'; }  ?> ><?=$program->buttonName;?> </option>
				  <?php endforeach;?>   
				</select>
				
				</div>
				</div>
				<?php }else{?>
					<?php 
						$i = 0;
						foreach($all_programs as $program){
							if($i == 0){
					?>
					<input type="hidden" name="program_id" value="<?php echo !empty($program) ? $program->id : 0; ?>">
				<?php } } } ?>
			<?php } ?>
		
		 <div class="clearfix"></div>
		
		<?php if(!empty($twilioApi)){?>
			   <div class=" twilio_checkbox" >
				  <input type="checkbox" class="form-control" name="twilio_checkbox" value="1"> <?php echo $twilioApi->checkbox_text ?>
			   </div>
		   <?php } ?>	
         

					</div>
               </div>
            </div>
         </div>
      </section>
	  
	   <section id="payment" style="display:none">
         <div class="container">
            <div class="row">
               <div class="col-md-12 col-sm-12">
                  <div class="form-step text-center payment-form">
					
                        <div class="col-md-6 col-sm-6">
                           <div class="form-group text-left">
                              <h3><?php echo $this->query_model->getStaticTextTranslation('payment_information'); ?></h3>
                           </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                           <div class="form-group text-right">
                           <img src="images/cards.png">
                           </div>
                        </div>
                        <div class="clearfix"></div>
						<div class="col-md-12 col-sm-12">
						<div id="paymentMethodResult"></div>
						</div> 
				<?php if($paymentDetail[0]->paypal_payment == 0){ ?>
					<?php if($paymentDetail[0]->stripe_ideal_payment == 1){ ?>
						<div class="col-md-6 col-sm-6">
                           <div class="form-group">
                              <input class="form-control " placeholder="<?php echo $this->query_model->getStaticTextTranslation('account_holder_name'); ?>"  name="account_holder_name" id="account_holder_name"type="text">
                           </div>
                        </div>
						<div class="col-md-6 col-sm-6">
                           <div class="form-group" id="">
                              <?php $bankNames = array('abn_amro'=>'ABN AMRO','asn_bank'=>'ASN Bank','bunq'=>'Bunq','handelsbanken'=>'Handelsbanken','ing'=>'ING','knab'=>'Knab','moneyou'=>'Moneyou','rabobank'=>'Rabobank','regiobank'=>'RegioBank','sns_bank'=>'SNS Bank (De Volksbank)','triodos_bank'=>'Triodos Bank','van_lanschot'=>'Van Lanschot'); ?>
								 <select class="form-control" name="bank_name" id="bank_name">
									<option value="">-<?php echo $this->query_model->getStaticTextTranslation('select_bank'); ?>-</option>
										<?php foreach($bankNames as $key => $value):?>
											<option value="<?=$key?>"><?=$value?></option>
										<?php endforeach;?>
									</select>
                           </div>
                        </div>
						<div class="clearfix"></div>
					<?php }else{ ?>
					<div class="col-md-12 col-sm-12">
                           <div class="form-group" id="credit-card-name">
                              <input class="form-control " placeholder="<?php echo $this->query_model->getStaticTextTranslation('name_on_card'); ?>"  name="card_name" id="card_name"type="text">
                           </div>
                        </div>
                    <?php if($stripePayment['stripe_payment'] == 1 && $stripePayment['stripe_sca_payment'] == 1 ){ ?>
					<div class="clearfix"></div>
					<div  class="col-sm-12 col-xs-12" id="card-element">
						  <!-- A Stripe Element will be inserted here. -->
					</div>
					<div class="clearfix"></div>
					<div class="col-sm-12 col-xs-12">
						
						 <div id="card-errors" role="alert"></div>
						 <div id="card-success" role="alert"></div>
						<input type="hidden" id="payment_intent_id" name="payment_intent_id" value="" >
						
					</div>
					<?php }else{ ?>
						
					<div id="credit-card-fields">
					   <div class="col-md-6 col-sm-6">
                           <div class="form-group" id="credit-card-number">
                              <input class="form-control " placeholder="<?php echo $this->query_model->getStaticTextTranslation('credit_card_number'); ?>"  name="credit_card_number" id="credit_card_number" data-stripe="number" type="text">
                           </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                           <div class="form-group" id="credit-card-cvv">
                              <input class="form-control disablecopypaste" placeholder="<?php echo $this->query_model->getStaticTextTranslation('cvv'); ?>"  name="cvv" id="cvv" type="password" autocomplete="off">
                           </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                           <div class="form-group" id="credit-card-expiration-month">
                              <?php $months = array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December'); ?>
			  <!--<input type="text" class="form-control" name="exp_month" required="required"> -->
			 <select class="form-control" name="exp_month" id="exp_month" data-stripe="exp_month">

              <option value=""><?php echo $this->query_model->getStaticTextTranslation('exp_month'); ?></option>

            	 <?php foreach($months as $row => $key):?>



					<option value="<?=$row?>"><?=$key?></option>

				

				<?php endforeach;?>

            </select>
                           </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                           <div class="form-group" id="credit-card-expiration-year">
						   <?php 
						$cur_year = date('Y');
						$years = array();
						for ($i=1; $i<=30; $i++) {
							$years[] = $cur_year++;
						}
						//echo '<pre>'; print_r($years); die;
			?>
                           <select class="form-control" name="exp_year" id="exp_year" data-stripe="exp_year">

						  <option value=""><?php echo $this->query_model->getStaticTextTranslation('exp_year'); ?></option> 
						
						<?php foreach($years as $key => $year){ ?>
							<option value="<?php echo $year; ?>"><?php echo $year; ?></option>
						<?php } ?>
							 
						</select>
                           </div>
                        </div>
					</div>
				<?php } } } ?>
                        
                       
						
						<?php if(!empty($show_trialoffer_coupons) && $show_trialoffer_coupons == 1) { ?>
					<div class="clearfix"></div>
				<div class="row couponBox" style=" background:none"> 		
						<div class="col-md-12 col-sm-12" id="couponResult">       </div> 
						
						  
						</div>
						
						
						<?php } ?>
						
						
						
                        <div class="col-md-12 col-sm-12 manage-coupon">
                           <div class="offer-price-list form-horizontal">
						   
						   <?php if(!empty($show_trialoffer_coupons) && $show_trialoffer_coupons == 1) { ?>
						   <div class="col-md-6 col-sm-6">
						   
							<div class="form-group">
							<div class="col-sm-12">
								<!--<label><?php echo $this->query_model->getStaticTextTranslation('do_you_have_promo_code'); ?>?</label> -->
								<input type="text" id="coupon" class="form-control bdr-green" value="" placeholder="Enter Your Promo Code">
								<input type="hidden" id="applied_coupon" value="0" >
								<input type="hidden" name="coupon_code" id="coupon_code" value="" >
								<input type="hidden" name="coupon_discount" id="coupon_discount" value="" >
								
							</div>
							</div>
							<div class="form-group text-left">
							<div class="col-sm-12">
								<a class="btn btn-success"  style="margin-top:10px;" id="applyCouponBtn"><?php echo $this->query_model->getStaticTextTranslation('apply_coupon'); ?></a>
								</div>
							</div>
						
						</div>
						   <?php } ?>
						   
							  <div class="form-horizontal  col-sm-6 pull-right">

<?php if(!empty($show_trialoffer_coupons) && $show_trialoffer_coupons == 1) { ?>							  
  <div class="form-group">
    <label class="control-label col-sm-7 total-price-value total-text" ><?php echo $this->query_model->getStaticTextTranslation('trial_offer'); ?>:</label>
    <div class="col-sm-5">
    <p class="form-control-static text-left  ">  <span class="offer-price total-price-value total-text"></span></p>
    </div>
  </div>
   <div class="form-group">
    <label class="control-label col-sm-7 text-success total-price-value total-text" ><?php echo $this->query_model->getStaticTextTranslation('discount'); ?>:</label>
    <div class="col-sm-5">
	<div class="total-price coupon_discont_price_box total-price-value" style="">
							  <span class="text-success total-text" id="coupon_discont_html"style="float:left; text-align:left;"><?php echo $this->query_model->getSiteCurrencyType(); ?>0</span>
							  <input id="coupon_discont" value="" type="hidden">
						</div>
    </div>
  </div>
<?php } ?>

   <div class="form-group">
    <label class="control-label col-sm-7" ><Strong class="total-price-value total-text"><?php echo $this->query_model->getStaticTextTranslation('total'); ?>:</strong></label>
    <div class="col-sm-5">
    <p class="form-control-static text-left"> <Strong class="order-price total-text"></strong></p>
    </div>
  </div>
							  
							  
							  
                           </div>
						   <div class="clearfix"></div>
						   </div>
                        </div>
						
						
						
                       <!--  <div class="col-sm-12 col-md-12">
                           <div class="form-group">
                              <a href="#" class=" btn-green btn-block"><?php echo $this->query_model->getStaticTextTranslation('purchase_now'); ?></a>
                           </div>
                        </div> -->
                        <div class="clearfix"></div>
                  </div>
               </div>
            </div>
         </div>
      </section>
     
	 
	 <div class="form-step text-center marginTop0">
	  <div class="col-sm-12 col-md-12 started-btn trial-btn">
		  <div class="form-group">
		  
		  <?php
			if(!empty($trials)){
				foreach($trials as $trial){
					
					if($trial->show_term_condition == 1){
			?>
			<div class="term_condition_box term_condition_trial_<?php echo $trial->id; ?>" style="display:none">
				<input type="hidden" class="show_term_condition_<?php echo $trial->id; ?>" value="<?php echo $trial->show_term_condition; ?>" >
				<div class="offer-agreement"><p><?php if(!empty($trial->term_condition)) { echo $trial->term_condition; } ?></p>
				</div>
				
			</div>
			<?php
					}
				}
			}
		  ?>
		  
		  <input type="hidden" value="0" id="is_show_term_condition">
		  <div class="term_condition_checkbox" style="display:none">
		   
		  </div>
		  
		  <?php
		
			
			$payment_url = $this->query_model->getbySpecific('tbl_payments','id',1);
			
			$p_url = '';
			$form_action_url = '';
					if(!empty($payment_url)){
						if($payment_url[0]->authorize_net_payment == 1){
								$p_url = 'buyoffer';
								$form_action_url = 'authorized_payment_gateway';
						}elseif($payment_url[0]->braintree_payment == 1){
								$p_url = 'brainTreebuyoffer';
								$form_action_url = 'brainTreePaymentGateway';
						}elseif($payment_url[0]->stripe_payment == 1){
								$p_url = 'stripePaymentbuyoffer';
								$form_action_url = 'stripe_payment_gateway';
						}elseif($payment_url[0]->stripe_ideal_payment == 1){
								$p_url = 'stripeIdealPaymentbuyoffer';
								$form_action_url = 'stripe_ideal_payment_gateway';
						}elseif($payment_url[0]->paypal_payment == 1){
								$p_url = 'paypalPaymentbuyoffer';
								$form_action_url = 'paypal_payment_gateway';
						}
						
					}
			
		?>
		<input type="hidden" value="<?php echo $p_url; ?>" id="payment_url" />
		<input type="hidden" value="<?php echo $form_action_url; ?>" id="form_action_url" />
		 </div>
		 <input type="text" id="comment" name="comment" class="optincomment"   placeholder="Write your comment here..." value="">
<input type="checkbox" class="optincheck" name="contact_me_by_phone" value="1">
		 <div class="form-group">
				<?php if($this->query_model->get_gdpr_compliant() == 1){?>
				
					<div class=" gdpr_compliant_checkbox" >
						<input type="hidden" name="ip_address" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
						
						
					  <input type="checkbox" class="form-control" id="gdpr_compliant" name="gdpr_compliant_checkbox" value="1"><?php echo $gdpr_compliant_txt2; ?><br/><span><?php echo $gdpr_compliant_txt1; ?></span>
				   </div>
				 <?php } ?>
				 
		  		<div class="trialErrorMessage"></div>
		  		<input type="hidden" name="trial_offer_cat_id" id="trial_offer_cat_id" value="<?php echo $trial_offer_cat->id ?>" />
		  		<input type="hidden" name="trial_id" value="0" id="trial_id" />
				
		   		<input type="hidden" name="miniform" value="<?php  echo !empty($miniform) ? $miniform : '';?>" /> 
                <input type="text" id="website" name="website" class="optinwebsite"  placeholder="Website" value="">
<input type="text"  class="ywedobjeo" name="x2o3d_<?php echo $this->query_model->setAndGetUniqueNumberForCustomField(); ?>" value="<?php echo time(); ?>"  placeholder="Serial Number"/>
				<input type="hidden"  name="refferal" value="<?php echo $domain_host; ?>">	
                <input type="hidden" name="page_url" id="page_url" value="<?php echo isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';  ?>" />
				
				
				
				
				<input name="amount" id="amount" value="0" type="hidden">
				<input id="main_offer_price" value="0" type="hidden">
				<input name="send_trial_ac" value="1" type="hidden">
				<input name="send_program_ac" value="1" type="hidden">
				
				<input type="hidden" name="email" value="<?php if(!empty($formEmail)){ echo $formEmail; } ?>" id="email" />
				
				
				<input  name="payment_method_nonce" type="hidden" id="payment_method_nonce" />
				<input  type="hidden" id="client_token" value="<?php echo !empty($clientToken) ? '1' : '0';  ?>" />
				<input  type="hidden" id="form_error" value="1" />
				<input type="hidden" name="is_child_name" id="is_child_name" value="0" >
				
				
				<!--<input type="submit" name="submit" id="<?php echo ($stripePayment['stripe_payment'] == 1 && $stripePayment['stripe_sca_payment'] == 1 ) ? 'card-button' : ''; ?>"  class="btn-blue btn-block submitOfferTrial client_secret" value="<?php echo $this->query_model->getStaticTextTranslation('get_started'); ?>" data-secret=""  disabled> -->
				
				<button id="card-button" class="button-exclusive btn btn-default btn-blue btn-block submitOfferTrial  client_secret" data-secret=""><?php echo $this->query_model->getStaticTextTranslation('get_started'); ?></button>
						
						
				
            	<a href="javascript:void(0)" class="btn-blue btn-block submitBrintreePaid "  style="display:none"><?php echo $this->query_model->getStaticTextTranslation('purchase_now'); ?> </a>
				
				
				
          </div>
          </div>
          </div>
         <div class="clearfix"></div>
		
	 
	 
      </form>
	  
	  <button id="tokenize" class="display-none">Get Token</button> 
	
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
            <?php if($site_settings->hide_window != 'hide'): ?>
            <div class="col-xs-6 row-btn"> 
			<a class="btn btn-theme"  href="<?php echo $this->query_model->getTrialOfferUrl($site_settings->url_call_to_action); ?>" target="<?php if($site_settings->window == 'new'): echo '_blank'; endif; ?>"> 
			<?php $this->query_model->getStrReplace($site_settings->call_to_action); ?></a> 
			</div>
			<?php endif; ?><div class="col-xs-6 row-btn"> 
			<?php if($multiLocation[0]->field_value == 1 ){ ?>
				<a class="btn btn-theme" href="javascript:void(0);"  target="_blank"> <i class="fa fa-map-marker"></i> <?php echo ' '.count($trialLocations).' '.$this->query_model->getStaticTextTranslation('locations'); ?></a>
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
	
     <form class="d-bg-c contact-form content_contact_form" action="contactus/send" method="post" >
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
		
		 <?php 
		$twilioApi =  $this->query_model->getTwilioApiType();
		 if(!empty($twilioApi)){?>
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
        <input type="submit" value="<?php echo $this->query_model->getStaticTextTranslation('send_message'); ?>" class="btn btn-readmore  btn-block submit button contactFormSubmitOffer">
      </form>
      <div class="clearfix"></div>
    </div>
  </section>
  


<script src="js/new/jquery-1.11.0.js"></script>
<script>
	$(document).ready(function(){
	var site_currency_type = $('#site_currency_type').val();	
	// apply coupon
	$("#applyCouponBtn").click(function(){

		$(".coupon_discont_price_box").hide();
		var coupon_code = $('#coupon').val();
		var trial_id = $('#trial_id').val();
		var applied_coupon = $("#applied_coupon").val();
		var coupon_discont = $("#coupon_discont").val();
		var main_offer_price = $("#main_offer_price").val();
		//alert('coupon_code=>'+coupon_code+'<=dojocart_id=>'+dojocart_id);
		$.ajax({
			type : 'POST',
			url : '<?php echo base_url().'site/ajaxApplyCouponTrialOffers' ?>',
			dataType : 'json',
			data : {coupon_code : coupon_code,trial_id:trial_id},
			
		}).done(function(result){
			//alert(result.status); return false;
			if(result.status == 1){
				//alert('1');
				var discount_type = result.discount_type;
				var discount_percent = result.discount_percent;
				var couponDiscount = result.discount;
				
				var discountOff = site_currency_type+result.discount;
				if(discount_type == "percent"){
					couponDiscount = (parseFloat(main_offer_price) * parseFloat(discount_percent)) / 100;
					couponDiscount = couponDiscount.toFixed(2);
					discountOff = result.discount_percent+'%';
				}
				
				
				
				$("#couponResult").html('<div class="alert alert-success"><?php echo $this->query_model->getStaticTextTranslation('you_have_appiled_promo_code'); ?> “'+coupon_code+'” <?php echo $this->query_model->getStaticTextTranslation('login'); ?> “'+discountOff+'” off.</div>' );
				$(".coupon_discont_price_box").show();
				$("#coupon_discont_html").html('-'+site_currency_type+couponDiscount);
				$("#coupon_discont").val(couponDiscount);
				
				
				
				if(applied_coupon == 0){
					//alert('pass');
					var oldTotalPrice = $("#amount").val();
					//var newPrice = parseFloat(oldTotalPrice) - parseFloat(couponDiscount);
					var newPrice = parseFloat(main_offer_price) - parseFloat(couponDiscount);
				}else if(applied_coupon == 1){
					//alert('fail');
					var oldTotalPrice = $("#amount").val();
					//var newPrice = (parseFloat(oldTotalPrice) - parseFloat(couponDiscount)) + parseFloat(coupon_discont);
					var newPrice = parseFloat(main_offer_price) - parseFloat(couponDiscount);
				}
				//alert(applied_coupon+'===>'+newPrice+'===>'+couponDiscount+'===>'+coupon_discont);
				
				newPrice = newPrice.toFixed(2);
				$(".order-price").html(site_currency_type+newPrice);
				$("#amount").val(newPrice);
				
				$("#applied_coupon").val(1);
				$("#coupon_code").val(coupon_code);
				$("#coupon_discount").val(couponDiscount);
			}else{
				
				if(applied_coupon == 1){
					//alert('1'); return false;
					var oldTotalPrice = $("#amount").val();
					var newPrice = parseFloat(oldTotalPrice) + parseFloat(coupon_discont);
					newPrice = newPrice.toFixed(2);
				
					$(".order-price").html(site_currency_type+newPrice);
					$("#amount").val(newPrice);
					
					
				}
				$("#applied_coupon").val(0);
				$("#coupon_code").val('');
				$("#coupon_discount").val(0);
				
				var couponErr = '<?php echo $this->query_model->getStaticTextTranslation('invalid_promo_code'); ?>';
				if(result.status == 2){
					couponErr = '<?php echo $this->query_model->getStaticTextTranslation('expired_promo_code'); ?>';
				}
				$("#couponResult").html('<div class="alert alert-danger">'+couponErr+'</div>' );
			}
		});
	});
	
	})
</script>

<?php if(!empty($clientToken)){ ?>


<script src="https://js.braintreegateway.com/web/3.23.0/js/client.min.js"></script>
<!-- TODO change to select box -->
<div class="display-none"> <select id="autofill">
  <option value="" disabled selected>Autofill</option>
  <option value="4111111111111111,123,12/2019,12345">Valid Card</option>
  <option value="4111111111111113,123,12/2019,12345">Bad Number</option>
  <option value="4111111111111111,123a,12/2019,12345">Bad CVV</option>
  <option value="4111111111111111,123,12/2019,12345&">Bad Postal Code</option>
  <option value="4111111111111113,123a,12/2019,12345%">Bad Everything</option>
</select>
<button id="clear-errors">Clear Errors</button> 

<div id="top-level-error-message" class="error-message"></div>
</div>


<script>
// Put your client token here
var AUTHORIZATION = '<?php echo $clientToken; ?>';

var client;

//var autofill = document.querySelector('#autofill');
var autofill = document.querySelector('#autofill');
var clearErrors = document.querySelector('#clear-errors');
var tokenize = document.querySelector('#tokenize');

var ccFields = document.querySelector('#credit-card-fields');
//var billingAddressFields = document.querySelector('#billing-address-fields');

var number = document.querySelector('#credit_card_number');
var cvv = document.querySelector('#cvv');
var expirationMonth = document.querySelector('#exp_month');
var expirationYear = document.querySelector('#exp_year');var cardname = document.querySelector('#card_name');
//var expirationDate = document.querySelector('#expiration-date');
//var postalCode = document.querySelector('#postal-code');

var fields = {
  number: ccFields.querySelector('#credit-card-number'),
  cvv: ccFields.querySelector('#credit-card-cvv'),
  expirationMonth: ccFields.querySelector('#credit-card-expiration-month'),
  expirationDate: ccFields.querySelector('#credit-card-expiration-year'),    cardname: ccFields.querySelector('#credit-card-name'),
  //expirationDate: ccFields.querySelector('#credit-card-expiration-date'),
  //postalCode: billingAddressFields.querySelector('#billing-address-postal-code')
};

function resetErrors() {
  var i;
  var errors = document.querySelectorAll('.error-message');

  for (i = 0; i < errors.length; i++) {
    errors[i].textContent = '';
  }
}

function renderFieldErrors(err) {
  err.forEach(function (field) {
    if (field.fieldErrors) {
      renderFieldErrors(field.fieldErrors);
    } else if (field.field in fields) {
      fields[field.field].querySelector('.error-message').textContent = field.message;
    }
  });
}

clearErrors.addEventListener('click', resetErrors);

autofill.addEventListener('change', function () {
  var values = autofill.value.split(',');

  number.value = values[0];
  cvv.value = values[1];
  expirationMonth.value = values[2];
  expirationYear.value = values[3];     // cardholderName.value = values[4];
  //expirationDate.value = values[2];
  //postalCode.value = values[3];
});

tokenize.addEventListener('click', function () {
  var values = {
    number: number.value,
    expirationMonth: expirationMonth.value,
    expirationYear: expirationYear.value,
    //expirationDate: expirationDate.value,
    cvv: cvv.value,	   // cardholderName: cardholderName.value,
   /* billingAddress: {
      postalCode: postalCode.value
    } */
  };

  resetErrors();

  client.request({
    endpoint: 'payment_methods/credit_cards',
    method: 'post',
    data: {
      creditCard: values
    }
  }, function (err, result) {
    var rawRequestError;

    if (err) {
      rawRequestError = err.details.originalError;

      if (rawRequestError.fieldErrors && rawRequestError.fieldErrors.length > 0) {
        renderFieldErrors(rawRequestError.fieldErrors[0].fieldErrors);
      } else {
        console.log('Something unexpected went wrong.');
        console.log(err);
      }
      return;
    }
	
	$('#payment_method_nonce').val(result.creditCards[0].nonce);

	//alert('Success: ' + result.creditCards[0].nonce); 
	
	
  });
});


braintree.client.create({
  authorization: AUTHORIZATION
}, function (clientErr, clientInstance) {
  if (clientErr) {
    console.log(clientErr);
    return;
  }
  client = clientInstance;
});


$(document).ready(function(){
	$('.submitBrintreePaid').click(function(){
		//$('#payment_method_nonce').val('');
		$('#tokenize').trigger('click');
		
		
		setTimeout(function () {
				var payment_method_nonce = $('#payment_method_nonce').val();
				if(payment_method_nonce != ''){
					//$('.submitBrintreePaid').hide();
					$('.submitOfferTrial').trigger('click');
					
				}else{
					$('.submitOfferTrial').trigger('click');
					//alert('Your card detail is wrong!'); return false;
				}
				
			}, 2000);
			
		
		
		/*$('#tokenize').trigger('click');
		var payment_method_nonce = $('#payment_method_nonce').val();
		
		 setTimeout(function () {
				$('.submitOfferTrial').trigger('click');
			}, 2000); */
	})
	
})

</script>

<?php } ?>

<script>
	$(window).load(function(){
		var selected_location  = $('.form_trial_location_dropdown').val();
		var trial_cat_id = $("#trial_offer_cat_id").val();
		var number = $('.form_trial_location_dropdown').attr('number');
		
		if(selected_location != '' || selected_location != null){
			$.ajax({

				url : '<?php echo base_url("site/get_program_ids_by_location_id_for_trialoffer"); ?>',
					type : 'POST',
					dataType :'json',
					data :{location_id:selected_location, trial_cat_id:trial_cat_id},
					success:function(data){
						if(data != ''){
							
							$('.trial_program_dropdown_'+number).empty();
							
							$('.trial_program_dropdown_'+number).append('<option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_program'); ?></option>');
							$.each(data, function(index, element) {
								$('.trial_program_dropdown_'+number).append('<option value="'+element.id+'">'+element.program+'</option>');
							});
							
							$('.trial_program_dropdown_'+number).removeAttr('disabled');
							
						}
					}

			});
		}
		
		$('.trial_program_dropdown_'+number).attr('disabled',true);
		
	})
	$(document).ready(function(){
		$('.form_trial_location_dropdown').change(function(){
				
				var location_id = $(this).val();
				var trial_cat_id = $("#trial_offer_cat_id").val();
				var number = $(this).attr('number');
				
				if(location_id != '' && location_id != null){
					$.ajax({

						url : '<?php echo base_url("site/get_program_ids_by_location_id_for_trialoffer"); ?>',
							type : 'POST',
							dataType :'json',
							data :{location_id:location_id, trial_cat_id:trial_cat_id},
							success:function(data){
								if(data != ''){
									
									$('.trial_program_dropdown_'+number).empty();
									
									$('.trial_program_dropdown_'+number).append('<option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_program'); ?></option>');
									$.each(data, function(index, element) {
										$('.trial_program_dropdown_'+number).append('<option value="'+element.id+'">'+element.program+'</option>');
									});
									
									$('.trial_program_dropdown_'+number).removeAttr('disabled');
									
									
								}
							}

					});
				}else{
					$('.trial_program_dropdown_'+number).val('');
					$('.trial_program_dropdown_'+number).attr('disabled',true);
				}
				
			})
	})

</script>

<?php if($stripePayment['stripe_payment'] == 1 && $stripePayment['stripe_sca_payment'] == 1 ){ ?> 



<script>
	$(document).ready(function(){
		<?php if($stripePayment['multi_location'] == 1){ ?>
			$('.stripe_sca_location').change(function(){
				var location_id = $(this).val();
				var offer_type = $('#trial_id').attr('offer');
				var amount = $('#amount').val();
				
				if(amount > 0 && offer_type == "paid" && (location_id != '' || location_id != null)){
					amount = amount.replace('.','');
					$.ajax({

						url : '<?php echo base_url("starttrial/ajaxStripePaymentIntent"); ?>',
							type : 'POST',
							dataType :'json',
							data :{location_id:location_id, amount:amount, stripe_action: 'CreatePaymentIntent'},
							success:function(data){
								
								if(data.res == 1){
									//alert(data.payment_intent_id+ '==>'+data.client_secret);
									$('#payment_intent_id').val(data.payment_intent_id);
									$('.client_secret').attr('data-secret',data.client_secret);
								}
								
							}

					});
				}
				
			})
		<?php } ?>
	})
</script>

<script src="https://js.stripe.com/v3/"></script>
<script>
$(document).ready(function(){
	
	// Create a Stripe client.
	var stripe = Stripe("<?php echo $stripePayment['stripe_publishable_key']; ?>");

	// Create an instance of Elements.
	var elements = stripe.elements();
	console.log(stripe);
	
	// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
  base: {
    color: '#32325d',
    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: 'antialiased',
    fontSize: '16px',
    '::placeholder': {
      color: '#aab7c4'
    }
  },
  invalid: {
    color: '#fa755a',
    iconColor: '#fa755a'
  }
};

// Create an instance of the card Element.
var card = elements.create('card', {
			hidePostalCode: true,
			style : style
			}
		);

// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');

// Handle real-time validation errors from the card Element.
card.addEventListener('change', function(event) {
  var displayError = document.getElementById('card-errors');
  if (event.error) {
    displayError.textContent = event.error.message;
	
  } else {
    displayError.textContent = '';
  }
});


var cardholderName = document.getElementById('card_name');
var cardButton = document.getElementById('card-button');
var clientSecret = cardButton.dataset.secret;

cardButton.addEventListener('click', function(ev) {
	cardholderName = document.getElementById('card_name');
	cardButton = document.getElementById('card-button');
	clientSecret = cardButton.dataset.secret;
	
	var offer_type = $('#trial_id').attr('offer');
	//alert(offer_type);
	if(offer_type != '' && offer_type == "paid"){
		
		if($('#form_error').val() == 1){
			//alert('some fields are required');
			console.log('some fields are required');
			return false;
		}
		
	  stripe.handleCardPayment(
		clientSecret, card, {
		  payment_method_data: {
			billing_details: {
				name: cardholderName.value
				}
		  }
		}
	  ).then(function(result) {
		 
		if (result.error) {
			
			var displayError = document.getElementById('card-errors');
			  if (result.error.message) {
				displayError.textContent = result.error.message;
				
			  } else {
				displayError.textContent = '';
			  }
			
			$('.submitOfferTrial  ').show();
			$('.processinBtn').hide();			
			console.log('error==>'+result.error.message);
			return false;
		  // Display error.message in your UI.
		} else {
		  // The payment has succeeded. Display a success message.
		 //$('#card-success').html('The payment has succeeded.');
		 
		 // alert('pass The payment has succeeded. Display a success message.=>'+result);
		  console.log('pass The payment has succeeded. Display a success message.=>'+result);
		  
		  $('.client_secret').removeClass('submitOfferTrial');
		  var form = document.getElementById('my-payment-form');
		  form.submit();
		  return false;
		}
	  });
	  
		}
});

// Handle form submission.
var form = document.getElementById('my-payment-form');
form.addEventListener('submit', function(event) {
	var offer_type = $('#trial_id').attr('offer');
	//alert('step2'+offer_type);
	if(offer_type == "paid"){
		  event.preventDefault();

		  stripe.createToken(card).then(function(result) {
			if (result.error) {
			  // Inform the user if there was an error.
			  var errorElement = document.getElementById('card-errors');
			  errorElement.textContent = result.error.message;
			} else {
			  // Send the token to your server.
			  stripeTokenHandler(result.token);
			}
		  });
	}
});

$('#submit-form').click(function(){
	var form = document.getElementById('my-payment-form');
	// Submit the form
	form.submit();
});

// Submit the form with the token ID.
function stripeTokenHandler(token) {
  // Insert the token ID into the form so it gets submitted to the server
  var form = document.getElementById('my-payment-form');
  var hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'stripeToken');
  hiddenInput.setAttribute('value', token.id);
  form.appendChild(hiddenInput);

  // Submit the form
  //form.submit();
}
});


</script>
<?php } ?>

<?php $this->load->view('includes/footer'); ?> 
<?php $forms = array('trial_form','contact_us_form');
echo $this->query_model->getGoogleCaptchaScript($forms); ?>
     