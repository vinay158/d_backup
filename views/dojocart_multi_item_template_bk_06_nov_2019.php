<?php $this->load->view('includes/header'); ?>

<?php $this->load->view('includes/header/dojocart_head'); ?>


<?php 
$site_setting_service = $this->query_model->getSiteSetting();
$site_url = base_url();
$location_detail_service = $this->query_model->getSchoolDetail(); 

$offer_detail_service = $this->query_model->getTrialOfferDetail(); 

$main_location = $this->query_model->getMainLocation(); 

$site_settings = $this->query_model->getSiteSetting();
$site_settings = $site_settings[0];

$domain_host = base_url();
$paymentDetail = $this->query_model->getbySpecific('tbl_payments','id',1);
//echo '<pre>paymentDetail'; print_r($paymentDetail); die;
 $site_currency_type = $this->query_model->getSiteCurrencyType(); 
 ?>
<?php $phoneNumberMaxLength = $this->query_model->phoneNumberMaxLength(); 

	  $getPhoneNumberClass = $this->query_model->getPhoneNumberClass(); 
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
 $(window).load(function(){
	
	var site_currency_type = $('#site_currency_type').val();
	
	$('#quantity').val(1);
	$('#hide_quantity').val(1);
	$(".upsellcheckbox").attr('checked',false);
	var alreadyTotal_price = $("#total_price").html();
	alreadyTotal_price = alreadyTotal_price.replace(site_currency_type, '');
	$('#total_amount').val(alreadyTotal_price);
	
})
  $(document).ready(function(){
     $('input.disablecopypaste').bind('copy paste', function (e) {
		   e.preventDefault();
		});
		
	var site_currency_type = $('#site_currency_type').val();	
    $('#submitPaymentButton').click(function(){     
      
      var err = 0;
	/*	var name=$('#name').val();

          if(name.length == 0){ 
            $('#name').after('<div class="reds name_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_name'); ?></div>');
			err = 1;
            return false;
          }

      var last_name=$('#last_name').val();
         
          if(last_name.length == 0){
            $('#last_name').after('<div class="reds last_name_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?></div>');
            err = 1;
            return false;
          }*/
		  
		$.each($('.name'),function(){
			var number = $(this).attr('number');
			var name=$(this).val();
				 $('.name_'+number+'_error').remove();
			  if(name.length == 0){ 
			  
				$(this).after('<div class="reds name_'+number+'_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_name'); ?></div>');
				err = 1;
				//return false;
			  }
		});
		
		/*$.each($('.last_name'),function(){
			var number = $(this).attr('number');
			var last_name=$(this).val();
			$('.last_name_'+number+'_error').remove();
			  if(last_name.length == 0){ 
			   
				$(this).after('<div class="reds last_name_'+number+'_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?></div>');
				err = 1;
				//return false;
			  }
		})*/

      var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
          var email=$('#email').val();
          if(email.length == 0 || emailfilter.test($("#email").val()) == false){
            $('#email').after('<div class="reds email_error"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
           err = 1;
            return false;
          }
          
    /*  var telephone=$('#telephone').val();
          
          <?php if($site_settings->phone_required == 1){ ?>
                                              <?php if($site_settings->international_phone_fields != 1){ ?>
          if(telephone.length <= 11 || telephone.length == 0){
            $('#telephone').after('<div class="reds phone_error"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
            return false;
            
          } 
                    <?php } } ?> */
		var telephoneId = 'telephone';
		var phoneError = 'phone_error';
		var telephone=$('#'+telephoneId).val();
		<?php 
						if($site_settings->international_phone_fields != 1){
							if($site_settings->phone_required == 1){ ?>
						if(telephone.length <= <?php echo $phoneNumberMaxLength - 1; ?> || telephone.length == 0){
							var err = 1;
							$('#'+telephoneId).after('<div class="reds '+phoneError+'"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
							return false;
						} 
						<?php //}
						}else{ ?>
						
							if(telephone.length <= <?php echo $phoneNumberMaxLength - 1; ?> && telephone.length > 0){
									$('#'+telephoneId).after('<div class="reds '+phoneError+' "><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
									var err = 1;
									return false;
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
							return false;
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
									return false;
								}	
							}	
					<?php		}	?> 
					
					<?php }?>
						
		
			<?php if($multiLocation[0]->field_value == 1 ){ ?>
					var school=$('#location_id').val();
					if(school == '' || school == null){
						var err = 1;
						$('#location_id').after('<div class="reds location_id_error"><?php echo $this->query_model->getStaticTextTranslation('select_your_location'); ?></div>');
						return false;
					}
					<?php } ?>	
					

     /* var address=$('#address').val();

          if(address.length == 0){
            $('#address').after('<div class="reds address_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_address'); ?></div>');
            err = 1;
            return false;
          }

      var city=$('#city').val();

          if(city.length == 0){
            $('#city').after('<div class="reds city_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_city'); ?></div>');
            err = 1;
            return false;
          }
 
       var state=$('#state').val();

          if(state == '' || state == null){
            $('#state').after('<div class="reds state_error"><?php echo $this->query_model->getStaticTextTranslation('select_state'); ?></div>');
            err = 1;
            return false;
          }

      var zip=$('#zip').val();

          if(zip.length == 0){
            $('#zip').after('<div class="reds zip_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_zip'); ?></div>');
            err = 1;
            return false;
          } */
   
<?php if($single_record->payment_type == 'paid'){ ?> 
var is_free_payment = $('#is_free_payment').val();
	if(is_free_payment == 0){
	<?php if($paymentDetail[0]->stripe_ideal_payment == 1){ ?>
							
		var account_holder_name=$('#account_holder_name').val();
		//alert(card_name); return false;
		if(account_holder_name.length == 0){
			var err = 1;
			$('#account_holder_name').after('<div class="reds account_holder_name_error"><?php echo $this->query_model->getStaticTextTranslation('enter_account_name'); ?></div>');
			return false;
		}
		
		var bank_name=$('#bank_name').val();
		if(bank_name == '' || bank_name == null){
			var err = 1;
			$('#bank_name').after('<div class="reds bank_name_error"><?php echo $this->query_model->getStaticTextTranslation('select_bank_name'); ?></div>');
			return false;
		}
		
	<?php }else{?>
      var card_name=$('#card_name').val();

          if(card_name.length == 0){

            $('#card_name').after('<div class="reds card_name_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_card_name'); ?></div>');
            err = 1;
            return false;
          }
    
    <?php if($stripePayment['stripe_payment'] == 1 && $stripePayment['stripe_sca_payment'] == 1 ){ ?> 
						
	<?php } else{ ?>
      var credit_card_number=$('#credit_card_number').val();

          if(credit_card_number.length == 0){
            $('#credit_card_number').after('<div class="reds credit_card_number_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_card_number'); ?></div>');
            err = 1;
            return false;
          }
          
      var cvv=$('#cvv').val();

          if(cvv.length == 0){
            $('#cvv').after('<div class="reds cvv_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_cvv'); ?></div>');
            err = 1;
            return false;
          }
          
     /* var applicant_signature=$('#applicant_signature').val();

          if(applicant_signature.length == 0){
            $('#applicant_signature').after('<div class="reds applicant_signature_error"><?php echo $this->query_model->getStaticTextTranslation('enter_applicant_signature'); ?></div>');
            err = 1;
            return false;
          } */
      
      var exp_month=$('#exp_month').val();

          if(exp_month == '' || exp_month == null){
            $('#exp_month').after('<div class="reds exp_month_error"><?php echo $this->query_model->getStaticTextTranslation('select_exp_month'); ?></div>');
            err = 1;
            return false;
          }
          
      var exp_year=$('#exp_year').val();

          if(exp_year == '' || exp_year == null){
            $('#exp_year').after('<div class="reds exp_year_error"><?php echo $this->query_model->getStaticTextTranslation('select_exp_year'); ?></div>');
           err = 1;
            return false;
          }
	<?php } } ?>
	}
<?php } ?>

     $('#form_error').val(err);
		
		if(err == 0){
			//$(this).prop('disabled', true);
			$(this).hide();
			$(this).after('<a href="javascript:void(0)" class="btn-blue btn-block processinBtn"  ><?php echo $this->query_model->getStaticTextTranslation('processing_please_wait'); ?></a>');
			return true;
		} else{
			//$(this).prop('disabled', false);
			$(this).show();
			$('.processinBtn').hide();			
			return false;
		}

         
      
    });
    
    $('#telephone').keyup(function(){
          
		   $('.phone_error').hide();
      });
	 
      
     
      
	  

      $('#email').keyup(function(){
          var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
          var email=$('#email').val();
          if($(this).val().length > 0){
            $('.email_error').hide();
          } else{
            $('#email').after('<div class="reds email_error"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
            
          }
      });
      
      
	
		<?php if($multiLocation[0]->field_value == 1 ){ ?>
		$('#location_id').change(function(){
				if($(this).val() != ''){
					$('.location_id_error').hide();
				} else{
					$('.location_id_error').show();
					$('#location_id').after('<div class="reds location_id_error"><?php echo $this->query_model->getStaticTextTranslation('select_your_location'); ?></div>');
					
				}
		});
		<?php } ?>
		

    
      
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
			
      
      $('.cc_number').keyup(function(){
        var ccnum = $(this).val();
        var two_digit = ccnum.substr(0, 2);
        //alert(two_digit); return false;

        var reg_amcExp =  new RegExp('^3[47][0-9]{13}$');
        if( two_digit == 34 || two_digit == 37 || reg_amcExp.test(ccnum)){
          $('.cc_number').after('<div class="reds cc_number_error"><?php echo $this->query_model->getStaticTextTranslation('card_not_accecpted'); ?></div>');
          $('.credit_card_number_error').hide();
        } else{
          $('.cc_number_error').hide();
          $('.credit_card_number_error').hide();

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
	  
<?php } ?>
  
      $('#applicant_signature').keyup(function(){
          if($(this).val().length > 0){
            $('.applicant_signature_error').hide();
          } else{
            $('#applicant_signature').after('<div class="reds applicant_signature_error"><?php echo $this->query_model->getStaticTextTranslation('enter_applicant_signature'); ?></div>');
            
          }
      });
      
      
     
      
      
    
  });
</script>
<?php
  
  if($single_record->video_type == "youtube_video"){
    $videoDisplay = !empty($single_record->youtube_video) ? 1 : 0;
  }elseif($single_record->video_type == "vimeo_video"){
    $videoDisplay = !empty($single_record->vimeo_video) ? 1 : 0;
  }else{
    $videoDisplay = 0;
  }
?>
<?php if( $videoDisplay == 1){ ?>

<section id="video-advertisement" class="video-top-line" style="background-image:url('upload/largevideo/y-player.jpg'); background-color: #000">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
			 <div class="video-inner">
               <?php if(!empty($single_record->youtube_video) && $single_record->video_type == 'youtube_video') { ?>
                  
                    <iframe width="100%" height="" src="<?php echo $single_record->youtube_video ?>?modestbranding=1&autohide=1&showinfo=0&controls=1&rel=0" frameborder="0" allowfullscreen></iframe>
                
                <?php } else{ ?>
<?php if(!empty($single_record->vimeo_video) && $single_record->video_type == 'vimeo_video') { ?>
                    <iframe width="100%" height="" src="<?php echo $single_record->vimeo_video ?>" frameborder="0" allowfullscreen></iframe>
                
                  <?php }}?>
				  </div>
            </div>
        </div>
    </div>
</section>
<?php } ?>


<!-- payment here -->
<section id="payment-block">
  <div class="container-fluid paymentBlockPart">
    <div class="row">
      <div class="col-md-5 col-xs-12 col-sm-6 col-md-push-7">
       <div class="policy cart-policy">
          <div class="price text-center">
            <div class="logo-right">
			<?php 
			if($single_record->override_logo != ''){
				if($single_record->override_logo != 1){
					$dojo_cart_logo = $this->query_model->getbySpecific('tbloverride_logos','s_no', $single_record->override_logo);
						if(!empty($dojo_cart_logo)){
		  ?>
		  <img src="<?php echo base_url().'upload/override_logos/'.$dojo_cart_logo[0]->logos; ?>" class="" alt="<?php $this->query_model->getStrReplace($dojo_cart_logo[0]->logo_alt); ?>"> 
		  <?php } }else{ ?>
			<img src="<?php echo $site_settings->sitelogo ?>" alt="<?php $this->query_model->getStrReplace($site_settings->logo_alt); ?>">
			<?php } } ?>
            
            
            </div>
            <h2 class="cart-price"><?php if(!empty($single_record->offer_title)) { $this->query_model->getDescReplace($single_record->offer_title); } ?></h2>
          </div>
        <div class="offers">
          <ul class="offer-list">
             <?php if(!empty($single_record->features)) {
                $features = unserialize($single_record->features);
                foreach ($features as $value) {
                
            ?>
            <li><i class="fa fa-check"></i><?php echo $value ?></li>
            <?php } } ?>
          </ul>
        </div>
        <div class="offer-description">
          <p><?php if(!empty($single_record->offer_description)) { $this->query_model->getDescReplace($single_record->offer_description); } ?></p>
        </div>
		<?php if(!empty($single_record->offer_image)) { ?>
            <img class="" src="upload/dojocarts/<?php echo $single_record->offer_image;  ?>" alt="<?php $this->query_model->getDescReplace($single_record->offer_image_alt_text); ?>" class="img-responsive img-centered" width="378">
            <?php } ?>
			
			<?php if($single_record->money_back_img == 1){  ?><img src="images/money-back.png"> <?php } ?>
        </div>
      </div>

    <div class="col-md-7 col-xs-12 col-sm-6 col-md-pull-5">
    <div class="media-body">
            <h2 class="media-heading">
			<?php if(!empty($single_record->product_title)) { $this->query_model->getDescReplace($single_record->product_title); } ?></h2>
            <?php if(!empty($single_record->product_description)) { $this->query_model->getDescReplace($single_record->product_description); } ?>
          </div>
          
		   <?php
		$original_payment_url = '';
		 $custom_payment_url = $domain_host.'dojocartpayment/buyspecial/'.$single_record->id;
       if($paymentDetail[0]->authorize_net_payment == 1 || $paymentDetail[0]->braintree_payment == 1     || $paymentDetail[0]->stripe_payment == 1  || $paymentDetail[0]->stripe_ideal_payment == 1  ){
          if (!empty($single_record->payment_type && $single_record->payment_type == 'paid') ) {
                if( !empty($paymentDetail[0]->authorize_net_payment) && $paymentDetail[0]->authorize_net_payment == 1 ){
                  $action_value = 'dojocartpayment/authorized_payment_gateway/'.$single_record->id;
                }

                if( !empty($paymentDetail[0]->braintree_payment) && $paymentDetail[0]->braintree_payment == 1 ){
                  $action_value = 'dojocartpayment/brainTreePaymentGateway/'.$single_record->id;
                }
				
				 if( !empty($paymentDetail[0]->stripe_payment) && $paymentDetail[0]->stripe_payment == 1 ){
                  $action_value = 'dojocartpayment/stripe_payment_gateway/'.$single_record->id;
                }
				
				if( !empty($paymentDetail[0]->stripe_ideal_payment) && $paymentDetail[0]->stripe_ideal_payment == 1 ){
                  $action_value = 'dojocartpayment/stripe_ideal_payment_gateway/'.$single_record->id;
                }
            }else{
                $action_value = 'dojocartpayment/buyspecial/'.$single_record->id;
              }
      }
        else{
          $action_value = 'dojocartpayment/buyspecial/'.$single_record->id;
        }
		$original_payment_url = $domain_host.$action_value;
		
        ?>
		
		<div class="contact-form-payment">
		<hr>
		  
        <h3><?php echo $this->query_model->getStaticTextTranslation('contact_information'); ?> </h3>
        <form class="row" method="post" id="paymentForm" action="<?php echo $domain_host.$action_value; ?>">
		
		

      <input type="hidden" name="miniform" value="" /> 
	  <input type="hidden" name="page_url" value="<?php echo isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';  ?>" />
      <input type="text" id="website" name="website" style="display:none" autocomplete="off">
      <input type="hidden" id="" name="is_multi_item_dojocart" value="1">
	  <input type="hidden" name="is_free_payment" id="is_free_payment" value="0">
	  <input type="hidden"  id="original_payment_url" value="<?php echo $original_payment_url; ?>">
	  <input type="hidden" id="custom_payment_url" value="<?php echo $custom_payment_url; ?>">

		
        <div class="col-md-12 col-sm-12">

          <div class="form-group">
	
          <input type="text" class="form-control name" name="contact_name[1]" value="" number="1" id="name" placeholder="<?php echo $this->query_model->getStaticTextTranslation('first_name'); ?>" onBlur="textAlphabatic(this)" maxlength="<?php echo $this->query_model->fullNameInputMaxLength(); ?>"" error_class="name_1_error" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?>" >
          <input type="hidden" name="product_id" value="<?php echo $single_record->id; ?>">

          </div>

        </div>  

        <div class="col-md-6 col-sm-6 display_none_lname">

          <div class="form-group">

          <input type="text" class="form-control last_name" name="contact_last_name[1]"  number="1"  value="" id="last_name" placeholder="<?php echo $this->query_model->getStaticTextTranslation('last_name'); ?>"  onBlur="textAlphabatic(this)" maxlength="25" error_class="last_name_1_error" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?>">

          </div>

        </div>
		<div class="clearfix"></div>
		<input type="hidden" class="totalContacts" value="1">
		<div class="col-md-12 col-sm-12">
			<a href="javascript:void(0);" class="addMoreContacts">Would you like to add another ?</a>
		</div>
		
		<div id="AddContacts"> </div>
		<div class="clearfix"></div>
		

          <div class="col-md-6 col-sm-6">

          <div class="form-group">

           <input type="email" class="form-control" name="email" value="" id="email"  placeholder="<?php echo $this->query_model->getStaticTextTranslation('email'); ?>" >

          </div>

        </div>  

        <div class="col-md-6 col-sm-6">

          <div class="form-group">

           <input type="text" id="telephone" class="form-control  <?php echo $getPhoneNumberClass; ?>" name="phone" value=""  error_class="phone_error" onBlur="phoneValidation(this)" maxlength="<?php echo $phoneNumberMaxLength; ?>"  placeholder="<?php echo $this->query_model->getStaticTextTranslation('phone'); ?>" >

          </div>

        </div>   

		<?php if($multiLocation[0]->field_value == 1){ ?>
		<div class="col-md-12 col-sm-12">
		 <div class="form-group">

            <select class="form-control <?php echo ($stripePayment['stripe_payment'] == 1 && $stripePayment['stripe_sca_payment'] == 1 ) ? 'stripe_sca_location' : ''; ?>" name="location_id" id="location_id">
			  <option value="">-<?php echo $this->query_model->getStaticTextTranslation('select_location'); ?>- </option>
              <?php foreach($form_allLocations as $allLocation){ ?>
              <option value="<?=$allLocation->id?>"><?=$allLocation->name?></option>
			  <?php } ?>

            </select>

          </div>
		 </div> 
		<?php } ?>
        <!--<div class="col-md-12">

          <div class="form-group">

          <label>Address</label>

          <input type="text" id="address" class="form-control" name="address">

          </div>

        </div>

        <div class="col-md-6 col-sm-6">

          <div class="form-group">

          <label>Address Line 2</label>

          <input type="text" class="form-control" name="address_line2">

          </div>

        </div>

        <div class="col-md-6 col-sm-6">

          <div class="form-group">

          <label>City</label>

          <input type="text" class="form-control" name="city" id="city">

          </div>

        </div> 

    

<?php 

$state_list = array ('Alabama'=>"AL", 'Alaska'=>"AK", 'Arizona'=>"AZ", 'Arkansas'=>"AR", 'California'=>"CA", 'Colorado'=>"CO", 'Connecticut'=>"CT", 'Delaware'=>"DE", 'District Of Columbia'=>"DC", 'Florida'=>"FL", 'Georgia'=>"GA", 'Hawaii'=>"HI", 'Idaho'=>"ID", 'Illinois'=>"IL", 'Indiana'=>"IN", 'Iowa'=>"IA", 'Kansas'=>"KS", 'Kentucky'=>"KY", 'Louisiana'=>"LA", 'Maine'=>"ME", 'Maryland'=>"MD", 'Massachusetts'=>"MA", 'Michigan'=>"MI", 'Minnesota'=>"MN", 'Mississippi'=>"MS", 'Missouri'=>"MO", 'Montana'=>"MT", 'Nebraska'=>"NE", 'Nevada'=>"NV", 'New Hampshire'=>"NH", 'New Jersey'=>"NJ", 'New Mexico'=>"NM", 'New York'=>"NY", 'North Carolina'=>"NC", 'North Dakota'=>"ND", 'Ohio'=>"OH", 'Oklahoma'=>"OK", 'Oregon'=>"OR", 'Pennsylvania'=>"PA", 'Rhode Island'=>"RI", 'South Carolina'=>"SC", 'South Dakota'=>"SD", 'Tennessee'=>"TN", 'Texas'=>"TX", 'Utah'=>"UT", 'Vermont'=>"VT", 'Virginia'=>"VA", 'Washington'=>"WA", 'West Virginia'=>"WV", 'Wisconsin'=>"WI", 'Wyoming'=>"WY");

?>

        <div class="col-md-6 col-sm-6">

          <div class="form-group">

          <label>State</label>

            <select class="form-control" name="state" id="state">

              <option value=""><?php echo $this->query_model->getStaticTextTranslation('select_state'); ?></option>
               <?php foreach($state_list as $row => $key):?>
              <option value="<?=$key?>"><?=$row?></option>
                <?php endforeach;?>

            </select>

          </div>

        </div> 

        <div class="col-md-6 col-sm-6">

          <div class="form-group">

          <label>Zip</label>

          <input type="text" class="form-control" name="zip" id="zip"  maxlength="6">

          </div>

        </div> -->

		
		<?php 
			if(!empty($custom_fields)){
				
				foreach($custom_fields as $custom_field){
					if(!empty($custom_field->label_text)){
		?>
			<div class="col-md-6 col-sm-6">

			  <div class="form-group">

			  <label><?php $this->query_model->getDescReplace(ucfirst($custom_field->label_text)) ?></label>

			  <?php if($custom_field->type == "text"){ ?>
				  <input type="text" class="form-control" name="custom_field[<?php echo $custom_field->id ?>]" >
			  <?php }elseif($custom_field->type == "dropdown"){ 
					$dropdownValues = !empty($custom_field->dropdown_values) ? unserialize($custom_field->dropdown_values) : '';
					if(!empty($dropdownValues)){
			  ?>
				  <select name="custom_field[<?php echo $custom_field->id ?>]" class="form-control">
				  <option value="">-<?php echo $this->query_model->getStaticTextTranslation('contact_information'); ?>-</option>
				  <?php foreach($dropdownValues as $value){
							if(!empty($value)){
							$value = ucfirst($value);
					  ?>
						<option value="<?php $this->query_model->getDescReplace($value) ?>"><?php $this->query_model->getDescReplace($value) ?></option>
				  <?php } } ?>
				  </select>
			  <?php } }elseif($custom_field->type == "checkbox"){ 
					$checkboxValues = !empty($custom_field->dropdown_values) ? unserialize($custom_field->dropdown_values) : '';
					if(!empty($checkboxValues)){
						foreach($checkboxValues as $value){
							if(!empty($value)){
							$value = ucfirst($value);
			  ?>
				<label class="radio-inline"><input type="checkbox" class="" name="custom_field[<?php echo $custom_field->id ?>][]" value="<?php $this->query_model->getDescReplace($value) ?>" > <?php $this->query_model->getDescReplace($value) ?></label>
			  <?php } } } } ?>
				

			  </div>

			</div>
			
		<?php 
					}
				}
			}
		?>
		
		
		<?php
			$this->db->select(array('id','sales_taxable','sales_tax_main','multi_item_sales_taxable'));
			$dojocartDetail = $this->query_model->getBySpecific('tbl_dojocarts','id',$single_record->id);
			
			if(!empty($dojocart_items))
			{
				foreach($dojocart_items as $item)
				{ 
				
				$saleTaxArr = $this->query_model->getDojocartItemSaleTax($dojocartDetail, $item->sales_tax,$item->item_price); 
			$amount = $item->item_price;
			$amount_without_tax = $item->item_price;
			$sale_tax_amount = 0;
			if($saleTaxArr['result'] == 2){
				$amount = $saleTaxArr['amount_with_tax'];
				$sale_tax_amount = $saleTaxArr['sale_tax_amount'];
			}
		?>
		
		
		<div class="col-md-12 col-sm-12 dojocart_item_<?php echo $item->id; ?>">
			<h5><?php echo $item->item_title; ?> </h5>
			<b>Details</b>
			<?php echo $item->item_description; ?>
			
			
			Quantity:
			<select class="dojocart_item_qty item_qty_<?php echo $item->id; ?>" item_id="<?php echo $item->id; ?>"   item_title="<?php echo $item->item_title; ?>" amount="<?php echo $amount; ?>" amount_without_tax="<?php echo $amount_without_tax ?>" multi_sale_tax_amount="<?php echo $sale_tax_amount; ?>">
				<?php for($i = 1; $i<= 15; $i++){ ?>
					<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php } ?>
			</select>
			<!--<input type="hidden" class="item_old_qty_<?php echo $item->id; ?>" value="1">
			<input type="hidden" class="item_amount_without_tax_<?php echo $item->id; ?>" value="<?php echo $amount_without_tax ?>">
			<input type="hidden" class="item_amount_with_tax_<?php echo $item->id; ?>" value="<?php echo $amount; ?>">
			<input type="hidden" class="item_saletax_amount_<?php echo $item->id; ?>" value="<?php echo $sale_tax_amount; ?>"> -->
			
			<p><b>Amount: </b> <?php echo $site_currency_type; ?><?php echo $item->item_price; ?><br/>
			<?php 
			$sale_tax_amount = 0;
			if($saleTaxArr['result'] == 2){
				$amount = $saleTaxArr['amount_with_tax'];
				$sale_tax_amount = $saleTaxArr['sale_tax_amount'];
			?>
			<b>Sale Tax: </b> <?php echo $saleTaxArr['sale_tax']; ?>% <br/>
			<!--<b>Item Amount: </b> <?php echo $saleTaxArr['amount_with_tax']; ?> <br/></p> -->
			<?php } ?>
			
			
			Who is this item for? (check all that apply)<br/>
			<div class="contact_name_checkbox_<?php echo $item->id; ?>">
				<div class="contact_box_1"><label class="radio-inline">
				<input type="checkbox"  class="contactCheckbox contact_item_<?php echo $item->id; ?> contact_checkbox_1"   item_title="<?php echo $item->item_title; ?>"  item_id="<?php echo $item->id; ?>"  amount="<?php echo $amount; ?>" amount_without_tax="<?php echo $amount_without_tax ?>" qty="1" contact_number="1"  is_checked="0" multi_sale_tax_amount="<?php echo $sale_tax_amount; ?>">  <span class="checkbox_firstname_1"></span> <span class="checkbox_lastname_1"></span></label><br/></div>
			</div>
			
			<hr/>
		</div>

		<?php 
				}
			}
		?>
		
		<div class="order_summary">
			<h4><b>Order Summary</b><h4>
			<div class="order_summary_text">Nothing is currently in your cart. Choose an item above.
			</div>
		</div>

        <?php if($paymentDetail[0]->authorize_net_payment == 1 || $paymentDetail[0]->braintree_payment == 1  || $paymentDetail[0]->stripe_payment == 1  || $paymentDetail[0]->stripe_ideal_payment == 1 ) {
        if($single_record->payment_type == 'paid'){ ?>
		
		<div class="payment_information">
        
		<div class="col-md-12 col-xs-12">
		<hr>
        <h3><?php echo $this->query_model->getStaticTextTranslation('payment_info'); ?>
            <img src="images/cards.png" ></h3>
        </div>
		
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
		<div class="col-md-12">

            <div class="form-group">
			
				<input type="text" class="form-control " name="card_name" id="card_name" placeholder="<?php echo $this->query_model->getStaticTextTranslation('name_on_card'); ?>">
      
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
          <div class="col-md-6 col-sm-6">

            <div class="form-group">
				<input type="text" class="form-control <?php if( !empty($paymentDetail[0]->authorize_net_payment) && $paymentDetail[0]->authorize_net_payment == 1 ){ echo ''; } ?>" name="credit_card_number" id="credit_card_number"  placeholder="<?php echo $this->query_model->getStaticTextTranslation('credit_card_number'); ?>">
            
      
            </div>

          </div>  

          <div class="col-md-6 col-sm-6">

            <div class="form-group">

             <input type="password" class="form-control disablecopypaste" name="cvv" id="cvv" placeholder="<?php echo $this->query_model->getStaticTextTranslation('security_code'); ?>" autocomplete="off">

            </div>

          </div> 

          <div class="col-md-6 col-sm-6">

            <div class="form-group">

             <?php $months = array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December'); ?>
        <!--<input type="text" class="form-control" name="exp_month" required="required"> -->
       <select class="form-control" name="exp_month" id="exp_month">

              <option value="">--<?php echo $this->query_model->getStaticTextTranslation('exp_month'); ?>--</option>

               <?php foreach($months as $row => $key):?>



          <option value="<?=$row?>"><?=$key?></option>

        

        <?php endforeach;?>

            </select>
            </div>

          </div>  

          <div class="col-md-6 col-sm-6">

            <div class="form-group">

      <?php 
            $cur_year = date('Y');
            $years = array();
            for ($i=1; $i<=30; $i++) {
              $years[] = $cur_year++;
            }

      ?>

      <select class="form-control" name="exp_year" id="exp_year">

              <option value="">--<?php echo $this->query_model->getStaticTextTranslation('exp_year'); ?>--</option>
      
      <?php foreach($years as $key => $year){ ?>
        <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
      <?php } ?>
       </select>        
      
      
          </div>

        </div>
        </div>
		<?php } } ?>
          <div class="clearfix"></div>
          
            <?php
              // Sales_tax_main is ON/OFF 
              if(!empty($single_record->sales_taxable) && $single_record->sales_taxable == 1) {
               $sales_tax_main = $single_record->sales_tax_main;
              }else{
                $sales_tax_main = 0;
              }
            ?>
			
			 <?php if(!empty($single_record->show_quantity) && $single_record->show_quantity == 1) { 
					$qtyDisplay = "block";
				}else{
					$qtyDisplay = "none";
				}
		?>
          <div class="col-md-12 col-xs-12" style="display:<?php echo $qtyDisplay; ?>">
            <div class="offer-block">
                 <div class="quantity">
                  <label><?php echo $this->query_model->getStaticTextTranslation('quantity'); ?></label>
				  
                <span class="inputvalue">
				<span class="upDownButton btn btn-default btn-sm" type="add">+</span>
				<input id="quantity" name="quantity" type="text" min="1" value="1" sales_price="<?= $single_record->price; ?>" sales_tax="<?php echo $sales_tax_main; ?>" readonly="true"/>
				<span class="upDownButton btn btn-default btn-sm" type="sub">-</span>
				</span>
				
                  <input id="price" type="hidden" name="" value="<?= $single_record->price; ?>">
                  <input type="hidden" id="hide_quantity" name="hide_quantity" value="1">
                </div>
            </div> 
         </div>
        

            <?php
                
              $amount_salestax = $this->query_model->get_percent($single_record->price, $sales_tax_main);
			 
	          ?>
            
			
        

<!--Upsells Section-->
  <?php 
 if(!empty($single_record->upsale) && $single_record->upsale == 1) {

  if(!empty($upsells)){ 
    
        $a = 1;
        foreach($upsells as $upsell_opt){ 
  ?>

<div class="col-md-12 col-xs-12">
<hr>

 <h3><?=$upsell_opt->up_title.' '.$site_currency_type.$upsell_opt->up_price?></h3>

<div class="checkbox set-checkbox">
<?php
              // sales_tax_main is ON/OFF In Upsale
              if(!empty($single_record->sales_taxable) && $single_record->sales_taxable == 1) {
               $sales_tax = $upsell_opt->sales_tax;
              }else{
                $sales_tax = 0;
              } 
            $amount_up_salestax = $this->query_model->get_percent($upsell_opt->up_price, $sales_tax);
?>
              <p><?= $upsell_opt->yes ?><input status_type="no" upsale_id="<?php echo $upsell_opt->id; ?>"  price="<?php echo $amount_up_salestax; ?>" class="set-redio is-checked upsellcheckbox chk_<?php echo $a; ?>_1"  name="yes" num_id="<?= $a; ?>"  value="1" type="checkbox" upsell_tax="<?php echo $sales_tax; ?>" upsell_price="<?php echo $upsell_opt->up_price; ?>">
              <input type="hidden" name="upsale_id[]" class="upsale_checkbox_<?php echo $upsell_opt->id; ?>" value=""></p>
</div>

<div class="checkbox ">
              <p><?= $upsell_opt->no ?><input status_type="no" upsale_id="<?php echo $upsell_opt->id; ?>"  price="<?php echo $amount_up_salestax; ?>"  class="set-redio is-checked  upsellcheckbox chk_<?php echo $a; ?>_0"  name="no" num_id="<?= $a;?>"  value="0" type="checkbox"  upsell_tax="<?php echo $sales_tax; ?>" upsell_price="<?php echo $upsell_opt->up_price; ?>"></p>
            </div>
</div>

<?php 
 $a++; }
  }?>


<?php
} ?>

<div class="clearfix"></div>

          <?php }
        } ?>
    

<?php 
 /*if(!empty($single_record->sales_taxable) && $single_record->sales_taxable == 1) {
               $sales_tax_main = $single_record->sales_tax_main;
              }else{
                $sales_tax_main = 0;
              }
$amount_salestax = $this->query_model->get_percent($single_record->price, $sales_tax_main); */
			 
      if($single_record->payment_type == "paid"){ ?>
<div class="col-md-12 col-xs-12">
	<div class="offer-block">
		
     
			<div class="total-price" style="display: <?php  if( $single_record->multi_item_sales_taxable == 1 || $single_record->sales_taxable == 1){ echo 'block'; } else{ echo 'none'; }?>">
              <label><?php echo $this->query_model->getStaticTextTranslation('subtotal'); ?>:</label>
              <span></span><span id="total"><?php echo $this->query_model->getSiteCurrencyType(); ?>0</span>
              <input id="amount" type="hidden" name="amount" value="0">
            </div>

            <div class="total-price">
              <label><?php echo $this->query_model->getStaticTextTranslation('tax'); ?>:</label>
              <span></span><span id="total_tax"><?php echo $this->query_model->getSiteCurrencyType(); ?>0</span>
              <input id="total_tax_amount" type="hidden" name="total_tax_amount" value="0">
            </div>
         
		
		<div class="total-price coupon_discont_price_box" style="display:none">
              <label><?php echo $this->query_model->getStaticTextTranslation('coupon_discount'); ?>:</label>
              <span></span><span id="coupon_discont_html"></span>
              <input id="coupon_discont" value="" type="hidden">
        </div>
			
		<div class="total-price">
              <label><?php echo $this->query_model->getStaticTextTranslation('total'); ?>:</label>
              <span></span><span id="total_price"><?php echo $this->query_model->getSiteCurrencyType(); ?><?php  echo number_format($amount_salestax,2); ?></span>
              <input id="total_amount" name="amount" value="<?php  echo number_format($amount_salestax,2); ?>" type="hidden">
            </div>
		
		
	</div></div>	
	<?php } ?>	
		
		
		<!--- Coupon Part ----->
		<?php if($single_record->payment_type == "paid" && !empty($single_record->coupon_code) && $single_record->coupon_code == 1) { ?>
		<div class="clearfix"></div>
<div class="row couponBox"> 		
		<div class="col-md-12 col-sm-12" id="couponResult">       </div> 
		
		  <div class="col-md-4 col-sm-4">
			<div class="form-group">
				<label><?php echo $this->query_model->getStaticTextTranslation('do_you_have_promo_code'); ?>?</label>
				<input type="text" id="coupon" class="form-control" value="" placeholder="Promo code">
				<input type="hidden" id="dojocart_id" value="<?php echo $single_record->id; ?>" >
				<input type="hidden" id="applied_coupon" value="0" >
				<input type="hidden" name="coupon_code" id="coupon_code" value="" >
				<input type="hidden" name="coupon_discount" id="coupon_discount" value="" >
			</div>
		</div>
		<div class="col-md-8 col-sm-8">
			<div class="form-group">
				<a class="btn btn-default" id="applyCouponBtn"><?php echo $this->query_model->getStaticTextTranslation('apply_coupon'); ?></a>
			</div>
		</div>
		</div>
		<?php } ?>
		<!--- end coupon -->
	</div>	
	
	<hr>
      <div id="billing-payment">
        <div class="row">
      <div class="col-md-12">
      <?php if(!empty($single_record->show_term_condition) && $single_record->show_term_condition == 1) { ?>
        <div class="offer-agreement"><p><?php if(!empty($single_record->term_condition)) { echo $single_record->term_condition; } ?></p>
        </div>
           <div class="checkbox ">
              <label><input type="checkbox" name="term_condition" id="tc" value="1"><?php echo $this->query_model->getStaticTextTranslation('i_agree_term_condition'); ?></label>
            </div>
			
		<?php if(!empty($twilioApi)){?>
			   <div class="checkbox twilio_checkbox">
              <label>
				  <input type="checkbox" class="" name="twilio_checkbox" value="1"> <?php echo $twilioApi->checkbox_text ?>
			   </label>
            </div>
		   <?php } ?>
            <div class="purchase-now">
         <!-- <input type="submit" id="submitPaymentButton" name="submit" class="btn btn-theme btn-lg btn-block" disabled value="<?php if(!empty($single_record->submit_btn_text)){ $this->query_model->getDescReplace($single_record->submit_btn_text); }else{ echo 'Submit'; }   ?>"> -->
		
		<input  type="hidden" id="form_error" value="1" />
			<button id="submitPaymentButton" class="button-exclusive btn btn-theme btn-lg btn-block  client_secret" data-secret=""><?php if(!empty($single_record->submit_btn_text)){ $this->query_model->getDescReplace($single_record->submit_btn_text); }else{ echo 'Submit'; }   ?></button> 
          </div>
            <?php } else{ ?>
			
			
		<?php if(!empty($twilioApi)){?>
			   <div class="checkbox twilio_checkbox">
              <label>
				  <input type="checkbox" class="" name="twilio_checkbox" value="1"> <?php echo $twilioApi->checkbox_text ?>
			   </label>
            </div>
		   <?php } ?>
          <div class="purchase-now">
          	
				
          <!--<input type="submit" id="submitPaymentButton" name="submit" class="btn btn-theme btn-lg btn-block" value="<?php if(!empty($single_record->submit_btn_text)){ $this->query_model->getDescReplace($single_record->submit_btn_text); }else{ echo 'Submit'; }   ?>">-->
		  
		  <input  type="hidden" id="form_error" value="1" />
			<button id="submitPaymentButton" class="button-exclusive btn btn-theme btn-lg btn-block  client_secret" data-secret=""><?php if(!empty($single_record->submit_btn_text)){ $this->query_model->getDescReplace($single_record->submit_btn_text); }else{ echo 'Submit'; }   ?></button> 
						
         <!--  <a href="#" class="btn btn-theme btn-lg btn-block"> <?php echo $this->query_model->getStaticTextTranslation('purchase_now'); ?></a> -->
          </div>
          <?php } ?>
      </div>
    </div>
     
		  
		  </div>
    </div>
  </div>
</section>



<script type="text/javascript">
 
$(document).ready(function(){
	
	
	var site_currency_type = $('#site_currency_type').val();
    var sales_price = $("#quantity").attr('sales_price');
    var sales_tax = $("#quantity").attr('sales_tax');
    //var priceWithSalesTax = (parseFloat(sales_price) * parseFloat(sales_tax)) / 100;
    var priceWithSalesTax = 0;
    $('#total_tax').html(site_currency_type+priceWithSalesTax.toFixed(2));
    $('#total_tax_amount').val(site_currency_type+priceWithSalesTax.toFixed(2));
        
  
  $("#quantity").keypress(function (evt) {
    evt.preventDefault();
});

    $(".upDownButton").click(function(){
		var site_currency_type = $('#site_currency_type').val();
		var oldQuantity = $('#quantity').val();
		if(oldQuantity == "" || oldQuantity == null){
			oldQuantity = 0;
		}
		var upDownType = $(this).attr('type');
		var quantity = oldQuantity;
		if(upDownType == 'add'){
			quantity = parseInt(oldQuantity) + 1;
		}
		
		if(upDownType == 'sub'){
			quantity = parseInt(oldQuantity) - 1;
			if(quantity <= 0){
				quantity = 1;
			}
		}
        
		$('#quantity').val(quantity); 
		
       
        var price = $("#price").val();
        var total = quantity * price;

        var sales_price = $("#quantity").attr('sales_price');
        var sales_tax = $("#quantity").attr('sales_tax');
        var priceWithSalesTax = (parseFloat(sales_price) * parseFloat(sales_tax)) / 100; //0.20
		var alreadySaleTaxAmount = $("#total_tax").html();
		alreadySaleTaxAmount = alreadySaleTaxAmount.replace(site_currency_type, '');
		
		var sub_amount = $("#total").html();
	sub_amount = sub_amount.replace(site_currency_type, '');
	
       // var total_tax = (parseFloat(total) * parseFloat(sales_tax)) / 100; 
       // $('#total_tax').html('$'+total_tax.toFixed(2));
        

        var priceWithSalesTax = parseFloat(priceWithSalesTax) + parseFloat(sales_price); 


        var hide_quantity = $("#hide_quantity").val();
        
        var total_price = $('#total_amount').val();

         if(parseInt(quantity) > parseInt(hide_quantity)){
			var total_amount =  parseFloat(total_price) + parseFloat(priceWithSalesTax);
           
			var priceWithSalesTax = (parseFloat(sales_price) * parseFloat(sales_tax)) / 100; //0.20 sale tax
			var total_tax = parseFloat(alreadySaleTaxAmount) + parseFloat(priceWithSalesTax);
			var tot_sub_amount = parseFloat(sub_amount) + parseFloat(sales_price);
         }else {
            if(parseInt(quantity) != parseInt(hide_quantity)){
              var total_amount =  parseFloat(total_price) - parseFloat(priceWithSalesTax);
              var priceWithSalesTax = (parseFloat(sales_price) * parseFloat(sales_tax)) / 100; //0.20 sale tax
				var total_tax = parseFloat(alreadySaleTaxAmount) - parseFloat(priceWithSalesTax);
				var tot_sub_amount = parseFloat(sub_amount) - parseFloat(sales_price);
            }
             
          
         }

         // With Upsale OR Total Price
         if(parseInt(quantity) != parseInt(hide_quantity)){
          $('#total_price').html(site_currency_type+total_amount.toFixed(2));
          $('#total_amount').val(total_amount.toFixed(2));

          // Without Upsale OR Subtotal Price
          $("#total").text(site_currency_type+tot_sub_amount.toFixed(2));
          $("#amount").val(tot_sub_amount.toFixed(2));
          $('#hide_quantity').val(quantity);
		  $('#total_tax').html(site_currency_type+total_tax.toFixed(2));
		  $('#total_tax_amount').val(site_currency_type+total_tax.toFixed(2));
		 
		 checkAmountAndAction(total_amount.toFixed(2)); //new kz 11/07/2019
         }

    }); 



$('#tc').click(function() {
        if ($(this).is(':checked')) {
          $('#submitPaymentButton').removeAttr('disabled');
            
        }else {
            alert('<?php echo $this->query_model->getStaticTextTranslation('accept_term_and_condition'); ?>');
            $('#submitPaymentButton').attr('disabled', 'disabled');
        }
    });

	
	
	// apply coupon
	$("#applyCouponBtn").click(function(){
		var site_currency_type = $('#site_currency_type').val();
		$(".coupon_discont_price_box").hide();
		var coupon_code = $('#coupon').val();
		var dojocart_id = $('#dojocart_id').val();
		var applied_coupon = $("#applied_coupon").val();
		var coupon_discont = $("#coupon_discont").val();
		var total_amount = $("#total_amount").val();
		
		//alert('coupon_code=>'+coupon_code+'<=dojocart_id=>'+dojocart_id);
		$.ajax({
			type : 'POST',
			url : '<?php echo base_url().'site/ajaxApplyCoupon' ?>',
			dataType : 'json',
			data : {coupon_code : coupon_code,dojocart_id:dojocart_id,total_amount:total_amount},
			
		}).done(function(result){
			if(result.status == 1){
				//alert('1');
				var discount_type = result.discount_type;
				var discount_percent = result.discount_percent;
				var couponDiscount = result.discount;
				
				var discountOff = site_currency_type+result.discount;
				if(discount_type == "percent"){
					var old_total_price = $("#total_amount").val();
					if(applied_coupon == 0){
						couponDiscount = (parseFloat(old_total_price) * parseFloat(discount_percent)) / 100;
						
					}else if(applied_coupon == 1){
						couponDiscount = parseFloat(old_total_price) + parseFloat(coupon_discont);
						couponDiscount = (parseFloat(couponDiscount) * parseFloat(discount_percent)) / 100;
					}
					couponDiscount = couponDiscount.toFixed(2);
					discountOff = result.discount_percent+'%';
				}
				
				$("#couponResult").html('<div class="alert alert-success"><?php echo $this->query_model->getStaticTextTranslation('you_have_appiled_promo_code'); ?> “'+coupon_code+'” <?php echo $this->query_model->getStaticTextTranslation('to_receive'); ?> “'+discountOff+'” <?php echo $this->query_model->getStaticTextTranslation('off'); ?>.</div>' );
				$(".coupon_discont_price_box").show();
				$("#coupon_discont_html").html('-'+site_currency_type+couponDiscount);
				$("#coupon_discont").val(couponDiscount);
				
				
				
				if(applied_coupon == 0){
					//alert('pass');
					var oldTotalPrice = $("#total_amount").val();
					var newPrice = parseFloat(oldTotalPrice) - parseFloat(couponDiscount);
					newPrice = newPrice.toFixed(2);
				}else if(applied_coupon == 1){
					//alert('fail');
					var oldTotalPrice = $("#total_amount").val();
					//alert('oldTotalPrice=>'+oldTotalPrice+'<=couponDiscount=>'+couponDiscount+'<=coupon_discont=>'+coupon_discont); 
					var newPrice = (parseFloat(oldTotalPrice) - parseFloat(couponDiscount)) + parseFloat(coupon_discont);
					newPrice = newPrice.toFixed(2);
				}
				
				$("#total_price").html(site_currency_type+newPrice);
				$("#total_amount").val(newPrice);
				
				$("#applied_coupon").val(1);
				$("#coupon_code").val(coupon_code);
				$("#coupon_discount").val(couponDiscount);
				checkAmountAndAction(newPrice); //new kz 11/07/2019
			}else{
				
				if(applied_coupon == 1){
					//alert('1'); return false;
					var oldTotalPrice = $("#total_amount").val();
					var newPrice = parseFloat(oldTotalPrice) + parseFloat(coupon_discont);
					$("#total_price").html(site_currency_type+newPrice);
					$("#total_amount").val(newPrice);
					
					
				}
				$("#applied_coupon").val(0);
				$("#coupon_code").val('');
				$("#coupon_discount").val(0);
				
				var couponErr = '<?php echo $this->query_model->getStaticTextTranslation('invalid_promo_code'); ?>';
				if(result.status == 2){
					couponErr = '<?php echo $this->query_model->getStaticTextTranslation('expired_promo_code'); ?>';
				}
				$("#couponResult").html('<div class="alert alert-danger">'+couponErr+'</div>' );
				checkAmountAndAction(newPrice); //new kz 11/07/2019
			}
		});
	});
	


// Upsell Section 
$('.upsellcheckbox').click(function(){
	var site_currency_type = $('#site_currency_type').val();
    var number = $(this).attr('num_id');
    var amount_sub_total =  $('#total_amount').val();
    var price = $(this).attr('price');
    var value = $(this).val();
	  var upsale_id = $(this).attr('upsale_id');
	 
    // new varibles 05/12
  	var upsell_tax = $(this).attr('upsell_tax');
  	var upsell_price = $(this).attr('upsell_price');
  	var alreadySaleTaxAmount = $("#total_tax").html();
  	alreadySaleTaxAmount = alreadySaleTaxAmount.replace(site_currency_type, '');
  	
  	var sub_amount = $("#total").html();
  	sub_amount = sub_amount.replace(site_currency_type, '');
  	
  	if($(this).is(":checked")) {
        
        $('.upsale_checkbox_'+upsale_id).val(upsale_id);
        if(value == 1){

          
          var tot_sub_amount = parseFloat(sub_amount) + parseFloat(upsell_price);
		  $('#total').html(site_currency_type+tot_sub_amount.toFixed(2));	
		  
           var total_amount =  parseFloat(amount_sub_total) + parseFloat(price);
            $('#total_price').html(site_currency_type+total_amount.toFixed(2));
            $('#total_amount').val(total_amount.toFixed(2));
             $('.chk_'+number+'_'+0).attr('status_type','yes');
             $('.chk_'+number+'_'+1).attr('status_type','yes');
            $('.chk_'+number+'_'+0).attr('checked',false);
			
			var priceWithSalesTax = (parseFloat(upsell_price) * parseFloat(upsell_tax)) / 100; //0.20 sale tax
			var total_tax = parseFloat(alreadySaleTaxAmount) + parseFloat(priceWithSalesTax);
			$('#total_tax').html(site_currency_type+total_tax.toFixed(2));
      $('#total_tax_amount').val(site_currency_type+total_tax.toFixed(2));
			
           checkAmountAndAction(total_amount.toFixed(2)); //new kz 11/07/2019


        }else{
             var status_type = $(this).attr('status_type');
            if(status_type == 'no' && value == 0){
            		$('.upsale_checkbox_'+upsale_id).val('');
             }else{
             		$('.upsale_checkbox_'+upsale_id).val('');
                  var total_amount =  parseFloat(amount_sub_total) - parseFloat(price);

                $('#total_price').html(site_currency_type+total_amount.toFixed(2));
                $('#total_amount').val(total_amount.toFixed(2));
				
				var priceWithSalesTax = (parseFloat(upsell_price) * parseFloat(upsell_tax)) / 100; //0.20 sale tax
				var total_tax = parseFloat(alreadySaleTaxAmount) - parseFloat(priceWithSalesTax);
				$('#total_tax').html(site_currency_type+total_tax.toFixed(2));
        $('#total_tax_amount').val(site_currency_type+total_tax.toFixed(2));
				  
				  var tot_sub_amount = parseFloat(sub_amount) - parseFloat(upsell_price);
				  $('#total').html(site_currency_type+tot_sub_amount.toFixed(2));
				 
				 checkAmountAndAction(total_amount.toFixed(2)); //new kz 11/07/2019
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
         
            var total_amount =  parseFloat(amount_sub_total) - parseFloat(price);
              $('#total_price').html(site_currency_type+total_amount.toFixed(2));
              $('#total_amount').val(total_amount.toFixed(2));
			  
			  var priceWithSalesTax = (parseFloat(upsell_price) * parseFloat(upsell_tax)) / 100; //0.20 sale tax
				var total_tax = parseFloat(alreadySaleTaxAmount) - parseFloat(priceWithSalesTax);
				$('#total_tax').html(site_currency_type+total_tax.toFixed(2));
        $('#total_tax_amount').val(site_currency_type+total_tax.toFixed(2));
				
				var tot_sub_amount = parseFloat(sub_amount) - parseFloat(upsell_price);
				//alert('sub_amount=>'+sub_amount+'upsell_price=>'+upsell_price); return false;
				$('#total').html(site_currency_type+tot_sub_amount.toFixed(2));
				
				checkAmountAndAction(total_amount.toFixed(2)); //new kz 11/07/2019

          }
         
           
    }

});

$('input.example').on('change', function() {
    $('input.example').not(this).prop('checked', false);  
});


// kz 22-04-2019

$('.addMoreContacts').click(function(){
		var totalContacts = $('.totalContacts').val();
		var i = parseInt(totalContacts) + Number(1);
		if(i <= 5){
			$('.addMoreContacts').show();
		}else{
			$('.addMoreContacts').hide();
		}
		var number = '1th';
		
		var j = i % 10,
			k = i % 100;
		if (j == 1 && k != 11) {
			number = i + "st";
		}else if (j == 2 && k != 12) {
			number = i + "nd";
		}else if (j == 3 && k != 13) {
			number = i + "rd";
		}else{
			number = i + "th";
		}
		// 
		
		$('.totalContacts').val(i);
		
			$('#AddContacts').append('<div class="contact_number_'+i+'"><div class="col-md-11 col-sm-11"><div class="form-group"><input type="text" class="form-control name" name="contact_name['+i+']" value=""  number="'+i+'"  placeholder="'+number+' <?php echo $this->query_model->getStaticTextTranslation('first_name'); ?>" onBlur="textAlphabatic(this)" maxlength="<?php echo $this->query_model->fullNameInputMaxLength(); ?>"" error_class="name_'+i+'_error" error_msg="'+number+' <?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?>" ></div></div><div class="col-md-5 col-sm-5 display_none_lname"><div class="form-group"><input type="text" class="form-control last_name"  number="'+i+'"  name="contact_last_name['+i+']" value=""  placeholder="'+number+' <?php echo $this->query_model->getStaticTextTranslation('last_name'); ?>"  onBlur="textAlphabatic(this)" maxlength="25" error_class="last_name_'+i+'_error" error_msg="'+number+' <?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?>"></div></div><div class="col-md-1 col-sm-1"><i class="fa fa-close remove_contacts" style="cursor:pointer;"   number="'+i+'"></i></div></div><div class="clearfix"></div>');
			
			<?php if(!empty($dojocart_items)){
					foreach($dojocart_items as $item){ 
						$amount = $item->item_price;
						$amount_without_tax = $item->item_price;
						$sale_tax_amount = 0;
						$saleTaxArr = $this->query_model->getDojocartItemSaleTax($dojocartDetail, $item->sales_tax,$item->item_price);
						if($saleTaxArr['result'] == 2){
							$amount = $saleTaxArr['amount_with_tax'];
							$sale_tax_amount = $saleTaxArr['sale_tax_amount'];
						}
			?>
			$('.contact_name_checkbox_<?php echo $item->id; ?>').append('<div class="contact_box_'+i+'"><label class="radio-inline"><input type="checkbox"  class="contactCheckbox  contact_item_<?php echo $item->id; ?> contact_checkbox_'+i+'" contact_number="'+i+'" is_checked="0" item_title="<?php echo $item->item_title; ?>"  item_id="<?php echo $item->id; ?>"  amount="<?php echo $amount; ?>"  amount_without_tax="<?php echo $amount_without_tax ?>"  qty="1" multi_sale_tax_amount="<?php echo $sale_tax_amount; ?>"> <span class="checkbox_firstname_'+i+'"></span> <span class="checkbox_lastname_'+i+'"></span></label><br/></div>');
			<?php } } ?>
		
	});
	
	$('body').on('click','.remove_contacts',function(){
		var contact_number = $(this).attr('number');
		$('.contact_number_'+contact_number).remove();
		var totalContacts = $('.totalContacts').val();
		var i = parseInt(totalContacts) - Number(1);
		$('.totalContacts').val(i);
		
		if(i <= 5){
			$('.addMoreContacts').show();
		}else{
			$('.addMoreContacts').hide();
		}
		
		
		$('.contact_box_'+contact_number).remove();
		
		calculate_order_amount();
		
	})

	
	$('body').on('click','.contactCheckbox',function(){
		
		var ch_item_id = $(this).attr('item_id');
		var ch_contact_number = $(this).attr('contact_number');
		var ch_amount = $(this).attr('amount');
		var is_checked = $(this).attr('is_checked');
		
		if($(this).is(":checked")){
			$(this).attr('is_checked',1);
		}else{
			$(this).attr('is_checked',0);
		}
		
		calculate_order_amount();
	})
	
	
	$('body').on('change','.dojocart_item_qty', function(){
		
		var qty = $(this).val();
		var item_id = $(this).attr('item_id');
		$('.os_qty_'+item_id).html(qty);
		
		calculate_order_amount();
		
	})
	
	
	$('body').on('keyup','.name',function(){
		 
		  var number = $(this).attr('number');
          if($(this).val().length > 0){
			
            $('.name_'+number+'_error').hide();
			$('.checkbox_firstname_'+number).text($(this).val());
			
			
          } else{
			 $('.name_'+number+'_error').remove();
            $(this).after('<div class="reds name_'+number+'_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_name'); ?></div>');
            
          }
		  
		  calculate_order_amount();
      });
	  
	  
	  
	$('body').on('blur','.name',function(){
		// alert('dsfsadfdsaf');
		  var number = $(this).attr('number');
          if($(this).val().length > 0){
			
            $('.name_'+number+'_error').hide();
			$('.checkbox_firstname_'+number).text($(this).val());
			
			
          } else{
			 $('.name_'+number+'_error').remove();
            $(this).after('<div class="reds name_'+number+'_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_name'); ?></div>');
            
          }
		  
		  calculate_order_amount();
      });
	  
	  
	   $('body').on('keyup','.last_name',function(){
		  var number = $(this).attr('number');
          if($(this).val().length > 0){
            $('.last_name_'+number+'_error').hide();
			 $('.checkbox_lastname_'+number).text($(this).val());
			 
			
          } else{
			$('.last_name_'+number+'_error').remove();
            $('#last_name').after('<div class="reds last_name_'+number+'_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?></div>');
            
          }
		  
		  calculate_order_amount();
      });
	  
	function calculate_order_amount(){
		var site_currency_type = $('#site_currency_type').val();
		var total_amount = 0;
		var sub_amount = 0;
		var amount_sub_total = 0;
		var total_multi_sale_tax_amount = 0;
		var single_sale_taxable = '<?php echo $single_record->sales_taxable ?>';
		var single_sale_tax_percent = '<?php echo $single_record->sales_tax_main ?>';
		var multi_item_sales_taxable = '<?php echo $single_record->multi_item_sales_taxable ?>';
		var single_sale_tax_amount = '';
		
		$('.order_summary_text').html('');
		var order_summery_text = '';
		$.each($('.contactCheckbox'), function(){
				
					var item_title = $(this).attr('item_title');
					var item_id = $(this).attr('item_id');
					var amount = $(this).attr('amount');
					var amount_without_tax = $(this).attr('amount_without_tax');
					var multi_sale_tax_amount = $(this).attr('multi_sale_tax_amount');
					var qty = $(this).attr('qty');
					var contact_number = $(this).attr('contact_number');
					var item_qty = $('.item_qty_'+item_id).val();
					var checked = $(this).attr('is_checked');
					var firstname = $('.checkbox_firstname_'+contact_number).html();
					var lastname = $('.checkbox_lastname_'+contact_number).html();
				if(checked == 1){
					if(firstname.length > 0 || lastname.length > 0){
						
						summary_list_id = item_id+'_'+contact_number;
						var item_full_text = firstname+' '+lastname+': '+item_title+' ('+item_qty+'x'+site_currency_type+amount+')';
						order_summery_text += '<div class="order_summary_list"><span class="os_text_'+summary_list_id+'">'+firstname+' '+lastname+': '+item_title+':- </span> <span class="os_qty_'+item_id+'">'+item_qty+'</span> x '+site_currency_type+'<span class="os_amount_'+summary_list_id+'">'+amount+'</span></div><input type="hidden" name="dojocartItem['+item_id+']['+contact_number+'][contact_number]" value="'+contact_number+'"><input type="hidden" name="dojocartItem['+item_id+']['+contact_number+'][qty]" value="'+item_qty+'"><input type="hidden" name="dojocartItem['+item_id+']['+contact_number+'][amount]" value="'+amount_without_tax+'"><input type="hidden" name="dojocartItem['+item_id+']['+contact_number+'][first_name]" value="'+firstname+'"><input type="hidden" name="dojocartItem['+item_id+']['+contact_number+'][last_name]" value="'+lastname+'"><input type="hidden" name="dojocartItem['+item_id+']['+contact_number+'][item_full_text]" value="'+item_full_text+'"><input type="hidden" name="dojocartItem['+item_id+']['+contact_number+'][item_title]" value="'+item_title+'"><input type="hidden" name="dojocartItem['+item_id+']['+contact_number+'][sale_tax_amount]" value="'+multi_sale_tax_amount+'"><input type="hidden" name="dojocartItem['+item_id+']['+contact_number+'][total_amount]" value="'+amount+'"><br/>';
						
						amount = parseFloat(amount) * item_qty;
						amount_without_tax = parseFloat(amount_without_tax) * item_qty;
						sub_amount = parseFloat(sub_amount) + parseFloat(amount_without_tax);
						
						if(multi_item_sales_taxable == 1){
							multi_sale_tax_amount = parseFloat(multi_sale_tax_amount) * item_qty;
							total_multi_sale_tax_amount = parseFloat(total_multi_sale_tax_amount) + parseFloat(multi_sale_tax_amount);
							//total_amount = parseFloat(total_amount) + parseFloat(amount);
						}
						
						
						total_amount = parseFloat(total_amount) + parseFloat(amount);
						
						

						
					}
				}
			})
		//alert(sub_amount+'=>'+single_sale_tax_amount+'=>'+total_amount);
		if(sub_amount != ''){
			sub_amount = sub_amount.toFixed(2);
		}
		  
		  
		if(total_amount != ''){
			total_amount = total_amount.toFixed(2);
		}
		
		if(single_sale_tax_amount != ''){
			single_sale_tax_amount = single_sale_tax_amount.toFixed(2);
		}
			// sale tax for single 
			
			if(single_sale_taxable == 1 && single_sale_tax_percent != ''){
				single_sale_tax_amount = (parseFloat(sub_amount) * parseFloat(single_sale_tax_percent)) / 100;
				
				//var total_tax = parseFloat(alreadySaleTaxAmount) + parseFloat(priceWithSalesTax);
				$('#total_tax').html(site_currency_type+single_sale_tax_amount.toFixed(2));
				$('#total_tax_amount').val(site_currency_type+single_sale_tax_amount.toFixed(2));
				 total_amount =  parseFloat(sub_amount) + parseFloat(single_sale_tax_amount);
			}
			
			// sale tax for single multiple
			if(multi_item_sales_taxable == 1){
				$('#total_tax').html(site_currency_type+total_multi_sale_tax_amount.toFixed(2));
				$('#total_tax_amount').val(site_currency_type+total_multi_sale_tax_amount.toFixed(2));
			}
			
			//alert('total_amount=>'+total_amount);
			$('#total').html(site_currency_type+sub_amount);
			$('#amount').val(sub_amount);
			
			var applied_coupon = $("#applied_coupon").val();
			var coupon_discount = $("#coupon_discont").val();
			
			if(applied_coupon == 1 && coupon_discount > 0){
				if(total_amount > 0){
					total_amount = parseFloat(total_amount) - parseFloat(coupon_discount);
				}else{
					total_amount = 0;
				}
				
			}
			
			//alert(applied_coupon+'==>'+coupon_discont+'==>'+total_amount);
            $('#total_price').html(site_currency_type+total_amount);
            $('#total_amount').val(total_amount);
			checkAmountAndAction(total_amount); //new kz 11/07/2019
		  
		if(order_summery_text == ""){
			order_summery_text = 'Nothing is currently in your cart. Choose an item above.';
		}
		$('.order_summary_text').html(order_summery_text);
	}
	
	
	

/**** new code for check amount
// if amount is min to 0 then payment option won't show
***/
function checkAmountAndAction(amount){
	var original_payment_url = $('#original_payment_url').val();
	var custom_payment_url = $('#custom_payment_url').val();
	
  if(amount <= 0){
	 $('#is_free_payment').val(1);
	 //$('.payment_information').hide();
	 $('#paymentForm').attr('action',custom_payment_url);
	 $('#submitPaymentButton').prop("disabled",true)
  }else{
	 //$('.payment_information').show();
	 $('#is_free_payment').val(0);
	 $('#paymentForm').attr('action',original_payment_url);
	  $('#submitPaymentButton').prop("disabled",false)
  }
}
	

});	

</script>





<?php if($stripePayment['stripe_payment'] == 1 && $stripePayment['stripe_sca_payment'] == 1 ){ ?> 



<script>
	$(document).ready(function(){
		<?php if($stripePayment['multi_location'] == 1){ ?>
			$('.stripe_sca_location').change(function(){
				var location_id = $(this).val();
				var amount = $('#total_amount').val();
				if(amount <= 0){
					amount = '0.52';
				}
				
				if(amount > 0 && (location_id != '' || location_id != null)){
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
var cardButton = document.getElementById('submitPaymentButton');
var clientSecret = cardButton.dataset.secret;

cardButton.addEventListener('click', function(ev) {
	 $('#submitPaymentButton').show();
	$('.processinBtn').hide();
	if($('#form_error').val() == 1){
			//alert('some fields are required');
			console.log('some fields are required');
			return false;
		}
		
	var payment_intent_id = $('#payment_intent_id').val();
	var location_id = $('.stripe_sca_location').val();
	var amount = $('#total_amount').val();
	
	
	if(amount > 0 && (location_id != '' || location_id != null) && (payment_intent_id != '' || payment_intent_id != null)){
		amount = amount.replace('.','');
		$.ajax({

			url : '<?php echo base_url("starttrial/ajaxStripePaymentIntent"); ?>',
				type : 'POST',
				dataType :'json',
				data :{location_id:location_id,payment_intent_id : payment_intent_id, amount:amount, stripe_action: 'UpdatePaymentIntent'},
				success:function(data){
					
					if(data.res == 1){
						
					}
					
				}

		});
	}
	
	
	alert('Your payment is process-' + payment_intent_id);
	
	cardholderName = document.getElementById('card_name');
	cardButton = document.getElementById('submitPaymentButton');
	clientSecret = cardButton.dataset.secret;
	
	
		
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
			
			 $('#submitPaymentButton').show();
			 $('.processinBtn').hide();
			// alert('error==>'+result.error.message);
			console.log('error==>'+result.error.message);
			return false;
		  // Display error.message in your UI.
		} else {
		  // The payment has succeeded. Display a success message.
		 //$('#card-success').html('The payment has succeeded.');
		 
		 // alert('pass The payment has succeeded. Display a success message.=>'+result);
		  console.log('pass The payment has succeeded. Display a success message.=>'+result);
		  
		  $('.client_secret').removeClass('submitOfferTrial');
		  var form = document.getElementById('paymentForm');
		  form.submit();
		  return false;
		}
	  });
	  
});

// Handle form submission.
var form = document.getElementById('paymentForm');
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
	var form = document.getElementById('paymentForm');
	// Submit the form
	form.submit();
});

// Submit the form with the token ID.
function stripeTokenHandler(token) {
  // Insert the token ID into the form so it gets submitted to the server
  var form = document.getElementById('paymentForm');
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




<?php $this->load->view('includes/dojocart_footer'); ?> 

