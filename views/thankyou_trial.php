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
<?php 
	$paymentGateway = 1;
	$action_value = '#';
	if(!empty($paymentDetail)){
      if($paymentDetail[0]->authorize_net_payment == 1 || $paymentDetail[0]->braintree_payment == 1     || $paymentDetail[0]->stripe_payment == 1 || $paymentDetail[0]->stripe_ideal_payment == 1   || $paymentDetail[0]->paypal_payment == 1   ){
		  
		  if(!empty($trialOfferDetail)){
          
		  if( !empty($paymentDetail[0]->authorize_net_payment) && $paymentDetail[0]->authorize_net_payment == 1 ){
                  $action_value = 'trial_upsells_payment/authorized_payment_gateway/'.$trialOfferDetail->id;
                }

                if( !empty($paymentDetail[0]->braintree_payment) && $paymentDetail[0]->braintree_payment == 1 ){
                  $action_value = 'trial_upsells_payment/brainTreePaymentGateway/'.$trialOfferDetail->id;
                }
				
				 if( !empty($paymentDetail[0]->stripe_payment) && $paymentDetail[0]->stripe_payment == 1 ){
                  $action_value = 'trial_upsells_payment/stripe_payment_gateway/'.$trialOfferDetail->id;
                }
				
				if( !empty($paymentDetail[0]->stripe_ideal_payment) && $paymentDetail[0]->stripe_ideal_payment == 1 ){
                  $action_value = 'trial_upsells_payment/stripe_ideal_payment_gateway/'.$trialOfferDetail->id;
                }
				
				if( !empty($paymentDetail[0]->paypal_payment) && $paymentDetail[0]->paypal_payment == 1 ){
                  $action_value = 'trial_upsells_payment/paypal_payment_gateway/'.$trialOfferDetail->id;
                }
		  }
      }
        else{
		$action_value = '#';
         $paymentGateway = 0;
        }
		
	
	$paymentBoxDisplay = 'none';
	if(isset($trial_type) && !empty($trial_type)){
		if($trial_type == "free"){
			$paymentBoxDisplay = 'block';
		}elseif($trial_type == "paid"){
			
			if($paymentDetail[0]->authorize_net_payment == 1 || $paymentDetail[0]->stripe_ideal_payment == 1 ){
				$paymentBoxDisplay = 'block';
			}else{
				if($stripePayment['stripe_payment'] == 1 && $stripePayment['stripe_sca_payment'] == 1 ){
					$paymentBoxDisplay = 'block';
				}else{
					$paymentBoxDisplay = 'none';
				}
			}
		}
	}
	
	
	}
        
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>


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
				 
				 <?php if($paymentGateway == 1 && !empty($upsells)){ ?>
               <div class="col-md-10 col-md-push-1">
                  <div class="upgrade-block">
				   
				 
                    <?php echo $this->query_model->str_replace_trial_upsells($upsells[0]->upsell_top_text, $upsells[0]->id); ?>
                  </div>
                    <?php if($upsells[0]->video_type == 'youtube_video'){ ?>
						<?php if(!empty($upsells[0]->youtube_video)){ ?>
							  <div class="video-inner">
								 <iframe  height="390" src="<?php echo $this->query_model->changeVideoPathHttp(trim($upsells[0]->youtube_video)); ?>?rel=0&amp;controls=0&amp;showinfo=0&amp;autoplay=0" frameborder="0" allowfullscreen ></iframe>
								 <span class="video-overlay">
									<div class=""></div>
								 </span>
							  </div>
							   <?php } } else{ ?>
						  <?php if(!empty($upsells[0]->vimeo_video)){ ?>
						  <div class="video-inner">
								 <iframe  height="390" src="<?php echo $this->query_model->changeVideoPathHttp(trim($upsells[0]->vimeo_video)); ?>?rel=0&amp;showinfo=0&amp;autoplay=0" frameborder="0" allowfullscreen ></iframe>
								 <span class="video-overlay">
									<div class=""></div>
								 </span>
							  </div>
							<?php } } ?> 
							
                  <div class="upgrade-btn">
                    <h2><?php echo $this->query_model->str_replace_trial_upsells($upsells[0]->up_title, $upsells[0]->id); ?></h2>
                    <div class="upgrade-btn-block">
                      <a href="javascript:void(0)" class="yesNoBtn yes" type="yes">
						<img src="images/upgrade.png">
                      </a>
                    </div>
                   <?php echo $this->query_model->str_replace_trial_upsells($upsells[0]->description, $upsells[0]->id); ?>
				   
                   <a href="javascript:void(0)" class="yesNoBtn no no-thanks" type="no">
                        
						<?php echo $this->query_model->str_replace_trial_upsells($upsells[0]->no, $upsells[0]->id); ?>
					</a>
                  </div>
               </div>
			   <input type="hidden" id="upsellType" value="no">
				 <?php } ?>
            </div>
         </div>
      </section>

<?php if($paymentGateway == 1){ ?>	  

	 <?php if(!empty($upsells)){ ?> 
	  <section id="dojocart_payment" style="display:none">
         <div class="container">
            <div class="row">
			<div class="col-md-12 col-xs-12">
			 
				
               <div class="col-md-12 col-sm-12">
                  <div class="form-step text-center payment-form">

                     <form action="#" id="upsellCartForm" method="POST">
					<?php echo $this->query_model->getCaptchaInputFields('trial_form'); ?> 
					<?php 
						$a = 1;
						foreach($upsells as $upsell){
					?>
					<!--  <div class="col-md-12 col-sm-12">
					  <h3><?php echo  $upsell->up_title ?> $<?php echo  $upsell->up_price ?></h3>

					<div class="checkbox set-checkbox">

              <p><?= $upsell->yes ?><input status_type="no" upsale_id="<?php echo $upsell->id; ?>"class="set-redio is-checked upsellcheckbox chk_<?php echo $a; ?>_1"  name="yes" num_id="<?= $a; ?>"  value="1" type="checkbox"   upsell_price="<?php echo $upsell->up_price; ?>">
              <input type="hidden" name="upsale_id[]" class="upsale_checkbox_<?php echo $upsell->id; ?>" value=""></p>
				</div>

				<div class="checkbox ">
							  <p><?= $upsell->no ?><input status_type="no" upsale_id="<?php echo $upsell->id; ?>" class="set-redio is-checked  upsellcheckbox chk_<?php echo $a; ?>_0"  name="no" num_id="<?= $a;?>"  value="0" type="checkbox"     upsell_price="<?php echo $upsell->up_price; ?>"></p>
							</div>
				</div> -->
					<?php $a++; } ?>

					<div class="" style="display:<?php echo $paymentBoxDisplay; ?>">
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
						<div class="col-md-12 col-sm-12">
                           <div class="form-group">
                              <input class="form-control " placeholder="<?php echo $this->query_model->getStaticTextTranslation('account_holder_name'); ?>"  name="account_holder_name" id="account_holder_name"type="text">
                           </div>
                        </div>
						<div class="col-md-12 col-sm-12">
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
                              <input class="form-control   <?php if( !empty($paymentDetail[0]->authorize_net_payment) && $paymentDetail[0]->authorize_net_payment == 1 ){ echo ''; } ?>" placeholder="<?php echo $this->query_model->getStaticTextTranslation('credit_card_number'); ?>"  name="credit_card_number" id="credit_card_number" data-stripe="number" type="text">
                           </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                           <div class="form-group"  id="credit-card-cvv">
                              <input class="form-control disablecopypaste" value="" placeholder="<?php echo $this->query_model->getStaticTextTranslation('cvv'); ?>"  name="cvv" id="cvv" type="password"  autocomplete="off">
                           </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                           <div class="form-group"  id="credit-card-expiration-month">
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
                           <div class="form-group"  id="credit-card-expiration-year">
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
					<?php } ?>
					<?php } ?>
					<?php } ?>
					</div>
					
                        <div class="col-md-12 col-sm-12">
                           <div class="order-price">
                              <h3>Order Total:  <span class="total"><?php echo $this->query_model->getSiteCurrencyType(); ?><?php echo !empty($upsells) ?$upsells[0]->up_price : 0; ?></a></h3>
                           </div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                           <div class="form-group">
						   <div class="trialErrorMessage"></div>
						   
						   <input type="hidden" name="trial_id" value="<?php echo $trial_id; ?>" id="trial_id"  offer="<?php echo $trial_type; ?>"/>
						   <input type="hidden" name="order_id" value="<?php echo $order_id; ?>" id="order_id" />
						   <input type="hidden" name="trialOfferId" value="<?php echo $trial_id; ?>" />
						   <input type="hidden" name="upsale_id[]" value="<?php echo !empty($upsells) ? $upsells[0]->id : 0; ?>"></p>
						   <input name="amount" id="total_amount" value="<?php echo !empty($upsells) ? $upsells[0]->up_price : 0; ?>" type="hidden">
						     <input type="text"  name="last_name" class="optinlastname" placeholder="Last Name" value="">
							<input type="text" id="fax" name="fax" class="optinfax"   placeholder="Fax Number" value="">

							<input type="text" id="comment" name="comment" class="optincomment"   placeholder="Write your comment here..." value="">
							<input type="checkbox" class="optincheck" name="contact_me_by_phone" value="1">

							<input type="text" id="website" name="website" class="optinwebsite"  placeholder="Website" value="">
							<input type="text"  class="ywedobjeo" name="x2o3d_<?php echo $this->query_model->setAndGetUniqueNumberForCustomField(); ?>" value="<?php echo time(); ?>"  placeholder="Serial Number"/>
						    <input type="hidden" name="page_url" id="page_url" value="<?php echo '/'.$action_value;  ?>" />
							
                             <!-- <input type="submit" name="submit" class="btn-green btn-block submitOfferTrial" value="<?php echo $this->query_model->getStaticTextTranslation('purchase_now'); ?>"> -->
							 
							 <input  name="payment_method_nonce" type="hidden" id="payment_method_nonce" />

							<input  type="hidden" id="client_token" value="<?php echo !empty($clientToken) ? '1' : '0';  ?>" />
				
							 <input  type="hidden" id="form_error" value="1" />
							  <button id="card-button" class="button-exclusive btn btn-green btn-block submitOfferTrial  client_secret" data-secret=""><?php echo $this->query_model->getStaticTextTranslation('purchase_now'); ?></button> 
							  
							 <!-- <button id="card-button" class="button-exclusive btn btn-default client_secret" data-secret="">Submit Payment</button> -->
							<?php if($trial_type == "free"){ ?> 
							<a href="javascript:void(0)" class="btn-blue btn-block submitBrintreePaid "  style="display:none"><?php echo $this->query_model->getStaticTextTranslation('purchase_now'); ?> </a>
							<?php } ?>
							
				
                           </div>
                        </div>
                        <div class="clearfix"></div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </section>
	<?php }else{?>
	
	

	<?php  } ?> 
<?php }else{ ?>
<div class="upgrade-btn">
	<a href="<?php echo base_url(); ?>" class="no-thanks"><?php echo $this->query_model->getStaticTextTranslation('go_back_homepage'); ?></a>
  </div>
<?php  } ?>
		
	<script>
	
	/*$(window).load(function(){
		$.each($('.upsellcheckbox'),function(){
			$(this).attr('checked',false);
		});
		$('#total_amount').val(0);
		$('.total').html('$0');
		
		
	}); */
	
	$(window).load(function(){
		$("#cvv").val('');
		
		<?php if($trial_type == "free"){ ?>
		$(".submitOfferTrial").removeAttr('disabled');
		
		var cToken = $('#client_token').val();
		
		if(cToken == 1){

			$('.submitOfferTrial').hide();

			$('.submitBrintreePaid').show();

		}else{

			$('.submitOfferTrial').show();

			$('.submitBrintreePaid').hide();

		}
		<?php  } ?>
		
		
	})
	
		$(document).ready(function(){
			
		// disble browser go back button 	
		window.history.pushState(null, "", window.location.href);        
        window.onpopstate = function() {
			setTimeout("window.location.href='<?php echo base_url().'starttrial/distoryTrialSession'; ?>'",500);
           // window.history.pushState(null, "", window.location.href);
        };
		
		window.addEventListener("popstate", function(e) {
			loadPage(location.pathname);
		});
		
		// check  page reloaded or not
		  if (performance.navigation.type == 1) {
			setTimeout("window.location.href='<?php echo base_url().'starttrial/distoryTrialSession'; ?>'",500);
		  }
			
// Upsell Section 
/*$('.upsellcheckbox').click(function(){
	
    var number = $(this).attr('num_id');
    var total_amount =  $('#total_amount').val();
    var value = $(this).val();
	var upsale_id = $(this).attr('upsale_id');
	 
    // new varibles 05/12
  	var upsell_price = $(this).attr('upsell_price');
  	
  	if($(this).is(":checked")) {
		$('.upsale_checkbox_'+upsale_id).val(upsale_id);
		if(value == 1){
			$('.chk_'+number+'_'+0).attr('status_type','yes');
            $('.chk_'+number+'_'+1).attr('status_type','yes');
            $('.chk_'+number+'_'+0).attr('checked',false);
			
			total_amount = parseFloat(total_amount) + parseFloat(upsell_price);
		}else{
			 var status_type = $(this).attr('status_type');
            if(status_type == 'no' && value == 0){
            		$('.upsale_checkbox_'+upsale_id).val('');
             }else{
             		$('.upsale_checkbox_'+upsale_id).val('');
					total_amount = parseFloat(total_amount) - parseFloat(upsell_price);
			 }
			 
			 $('.chk_'+number+'_'+1).attr('status_type','no');
            $('.chk_'+number+'_'+0).attr('status_type','no');
            $('.chk_'+number+'_'+1).attr('checked',false);
		}
		
	}else{
			$('.upsale_checkbox_'+upsale_id).val('');
            $('.chk_'+number+'_'+1).attr('status_type','no');
            $('.chk_'+number+'_'+0).attr('status_type','no');
			  var status_type = $(this).attr('status_type');
			if(status_type == 'no' && value == 0){
				
			 }else{	
				total_amount = parseFloat(total_amount) - parseFloat(upsell_price);
			 }
			
	}
	total_amount = total_amount.toFixed(2);
	$('#total_amount').val(total_amount);
	$('.total').html('$'+total_amount);

}); */
			
			
		 $('input.disablecopypaste').bind('copy paste', function (e) {
		   e.preventDefault();
		});
		
		$('.submitOfferTrial').click(function(){
			
			$('#paymentMethodResult').html('');
			
			$('#email').val($('#form_email').val());
			var trial_id = $('#trial_id').val();
			var total_amount = $('#total_amount').val();
			
			if(trial_id == 0){
				$('.trialErrorMessage').html('<h3><?php echo $this->query_model->getStaticTextTranslation('choose_trial_offer_to_proceed'); ?></h3>');
				return false;
			}
			
			if(total_amount == 0){
				$('.trialErrorMessage').html('<h3><?php echo $this->query_model->getStaticTextTranslation('choose_an_upsell'); ?></h3>');
				return false;
			}
			
			
			
		
					var err = 0;
					
					
					var offerType = $('#trial_id').attr('offer');
					//alert(offerType);
					
					var paymentType = '';
					<?php if($paymentDetail[0]->paypal_payment == 0){ ?>
					<?php if($paymentDetail[0]->authorize_net_payment == 1){ ?>
						paymentType = 'authorized';
					<?php } ?>
					//alert(paymentType); return false;
					
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
						if(offerType == "free" || paymentType == "authorized"){
						var card_name=$('#card_name').val();
							//alert(card_name); return false;
							if(card_name.length == 0){
								var err = 1;
								$('#card_name').after('<div class="reds card_name_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_card_name'); ?></div>');
							}
						}
						<?php if($stripePayment['stripe_payment'] == 1 && $stripePayment['stripe_sca_payment'] == 1 ){ ?> 
						
						<?php } else{ ?>
					
					if(offerType == "free" || paymentType == "authorized"){
						
								
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
						
						/*if($('#term_condition').is(':checked')){
							
						}else{
							var err = 1;
							$('#term_condition').after('<div class="reds term_condition_error">Check term and conditions</div>');
						} */
								
					}
				<?php } ?>
			<?php } ?>
			<?php } ?>
					
					$('#form_error').val(err);
					if(err == 0){
						
						<?php if(!empty($paymentDetail) && $paymentDetail[0]->braintree_payment == 1 && $trial_type == "free"){?>

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
							
						$('#upsellCartForm').attr('action','<?php echo $action_value ?>');
						//$(this).prop('disabled', true);
						//$(this).hide();
						$(this).after('<a href="javascript:void(0)" class="btn-blue btn-block processinBtn"  ><?php echo $this->query_model->getStaticTextTranslation('processing_please_wait'); ?></a>');
						return true;
					} else{
						<?php if(!empty($paymentDetail) && $paymentDetail[0]->braintree_payment == 1 && $trial_type == "free"){?>

								

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
						$('#upsellCartForm').attr('action','#');
						//$(this).prop('disabled', false);
						//$(this).show();
						$('.processinBtn').hide();
						
						return false;
					}
		});
		
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

			 /* $('#credit_card_number').keypress(function(event){

		       if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
		           event.preventDefault(); //stop character from entering input
		       }

		   }); */
		   
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
			
			/*$('#term_condition').click(function(){
				if($(this).is(':checked')){
					$('.term_condition_error').hide();
				}else{
					$('.term_condition_error').show();
				}
			}) */
		
		})
	</script>

	 	
	
	
	
	
	
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
					<?php } */?>
					
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
  
  
  <script>
	
	$(window).load(function(){
		if($('#upsellType').val() == "yes"){
			$('#dojocart_payment').show();
		}else{
			$('#dojocart_payment').hide();
		}
		
	});
		$(document).ready(function(){
			$('.yesNoBtn').click(function(){
				//alert($(this).attr('type')); return false;
				if($(this).attr('type') == "yes"){
					$('#dojocart_payment').show();
					$('#upsellType').val('yes');
					<?php if($stripePayment['stripe_payment'] == 1 && $stripePayment['stripe_sca_payment'] == 1 ){ ?> 
						<?php if($stripePayment['multi_location'] == 1){ ?>
							var location_id = "<?php echo isset($postData['location_id']) ? $postData['location_id'] : ''; ?>";
							
						<?php }else{ 
								$mainLoc =  $this->query_model->getMainLocation();
								$stripe_sca_location_id = $mainLoc[0]->id;
						?>
							var location_id = "<?php echo $stripe_sca_location_id; ?>";
							
						<?php } ?>
							var location_id = "<?php echo isset($postData['location_id']) ? $postData['location_id'] : ''; ?>";
							var amount = $('#total_amount').val();
								
							if(amount > 0 && (location_id != '' || location_id != null)){
								amount = amount.replace('.','');
								$.ajax({

									url : '<?php echo base_url("starttrial/ajaxStripePaymentIntent"); ?>',
										type : 'POST',
										dataType :'json',
										data :{location_id:location_id, amount:amount, stripe_action: 'CreatePaymentIntent'},
										success:function(data){
											
											if(data.res == 1){
												$('#payment_intent_id').val(data.payment_intent_id);
												$('.client_secret').attr('data-secret',data.client_secret);
											}
											
										}

								});
							}
							
					<?php } ?>
				}
				if($(this).attr('type') == "no"){
					$('#dojocart_payment').hide();
					$('#upsellType').val('no');
					setTimeout("window.location.href='<?php echo base_url().'starttrial/unsetTrialSession'; ?>'",1000);
				}
			});
		});	
			
	</script>

  
<?php if($stripePayment['stripe_payment'] == 1 && $stripePayment['stripe_sca_payment'] == 1 ){ ?> 



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
			 
			 $('.submitOfferTrial').show();
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
		  var form = document.getElementById('upsellCartForm');
		  form.submit();
		  return false;
		}
	  });
	  
});

// Handle form submission.
var form = document.getElementById('upsellCartForm');
form.addEventListener('submit', function(event) {
	
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
});

$('#submit-form').click(function(){
	var form = document.getElementById('upsellCartForm');
	// Submit the form
	form.submit();
});

// Submit the form with the token ID.
function stripeTokenHandler(token) {
  // Insert the token ID into the form so it gets submitted to the server
  var form = document.getElementById('upsellCartForm');
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




<?php if(!empty($clientToken) && $trial_type == "free"){ ?>





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

var expirationYear = document.querySelector('#exp_year');

var cardname = document.querySelector('#card_name');

//var expirationDate = document.querySelector('#expiration-date');

//var postalCode = document.querySelector('#postal-code');



var fields = {

  number: ccFields.querySelector('#credit-card-number'),

  cvv: ccFields.querySelector('#credit-card-cvv'),

  expirationMonth: ccFields.querySelector('#credit-card-expiration-month'),

  expirationDate: ccFields.querySelector('#credit-card-expiration-year'),
  
  cardname: ccFields.querySelector('#credit-card-name'),

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

  expirationYear.value = values[3];
  
  
 // cardholderName.value = values[4];

  //expirationDate.value = values[2];

  //postalCode.value = values[3];

});



tokenize.addEventListener('click', function () {

  var values = {

    number: number.value,

    expirationMonth: expirationMonth.value,

    expirationYear: expirationYear.value,

    //expirationDate: expirationDate.value,

    cvv: cvv.value,
	
   // cardholderName: cardholderName.value,

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

  

  
<?php $this->load->view('includes/footer'); ?> 

<?php $forms = array('opt_in_form','contact_us_form');
echo $this->query_model->getGoogleCaptchaScript($forms); ?>