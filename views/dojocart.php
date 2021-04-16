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

?>


<style>
.reds {left:11px!important;position: absolute !important;top:61px!important; z-index: 2 !important;}
.sign {
  margin-bottom: 0;
  position: relative;
}
.sign >.reds{top:30px !important;left:0px!important;}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
 $(window).load(function(){
	
	
	$('#<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?>').val(1);
	$('#hide_<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?>').val(1);
	$(".upsellcheckbox").attr('checked',false);
	var alreadyTotal_price = $("#total_price").html();
	alreadyTotal_price = alreadyTotal_price.replace('$', '');
	$('#total_amount').val(alreadyTotal_price);
	
})
  $(document).ready(function(){
    
    $('#submitPaymentButton').click(function(){     
      
      var err = 0;
      var name=$('#name').val();

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
          }

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
		if (!$.isNumeric(telephone ) && telephone.length > 0) {
			var err = 1;
			$('#'+telephoneId).after('<div class="reds '+phoneError+'"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
			return false;
		}else{
			<?php if($site_settings->phone_required == 1){ ?>
			<?php //if($settings->international_phone_fields != 1){ ?>
			if(telephone.length <= 9 || telephone.length == 0){
				//alert('0');
				var err = 1;
				$('#'+telephoneId).after('<div class="reds '+phoneError+'"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
				return false;
			} 
			<?php //}
			}else{ ?>
			
				if(telephone.length <= 9 && telephone.length > 0){
						//alert('2'); 
						$('#'+telephoneId).after('<div class="reds '+phoneError+' "><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
						var err = 1;
						return false;
					}else{
						//alert('3'); 
						//var err = 0;
						$('.'+phoneError).hide();
					}
			<?php } ?>
		}
			

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
          
      var card_name=$('#card_name').val();

          if(card_name.length == 0){

            $('#card_name').after('<div class="reds card_name_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_card_name'); ?></div>');
            err = 1;
            return false;
          }
          
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
          
      var applicant_signature=$('#applicant_signature').val();

          if(applicant_signature.length == 0){
            $('#applicant_signature').after('<div class="reds applicant_signature_error"><?php echo $this->query_model->getStaticTextTranslation('enter_applicant_signature'); ?></div>');
            err = 1;
            return false;
          }
      
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
          
		
		if(err == 0){
			return true;
		} else{
			return false;
		}

         
      
    });
    
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
            
          } */
		   $('.phone_error').hide();
      });
	 
      
      $('#name').keyup(function(){
          if($(this).val().length > 0){
            $('.name_error').hide();
          } else{
            $('#name').after('<div class="reds name_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_name'); ?></div>');
            
          }
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
      
      $('#last_name').keyup(function(){
          if($(this).val().length > 0){
            $('.last_name_error').hide();
          } else{
            $('#last_name').after('<div class="reds last_name_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?></div>');
            
          }
      });
      
    /*  $('#city').keyup(function(){
          if($(this).val().length > 0){
            $('.city_error').hide();
          } else{
            $('#city').after('<div class="reds city_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_city'); ?></div>');
            
          }
      });
      
      $('#zip').keyup(function(){
          if($(this).val().length > 0){
            $('.zip_error').hide();
          } else{
            $('#zip').after('<div class="reds zip_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_zip'); ?></div>');
            
          }
      }); 
	   $('#address').keyup(function(){
          if($(this).val().length > 0){
            $('.address_error').hide();
          } else{
            $('#address').after('<div class="reds address_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_address'); ?></div>');
            
          }
      });
      
      $('#state').change(function(){
          if($(this).val() != ''){
            $('.state_error').hide();
          } else{
            $('.state_error').show();
            //$('#state').after('<div class="reds state_error">Select your state</div>');
            
          }
      });
	  */
      
      $('#card_name').keyup(function(){
          if($(this).val().length > 0){
            $('.card_name_error').hide();
          } else{
            $('#card_name').after('<div class="reds card_name_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_card_name'); ?></div>');
            
          }
      });
      

      $('#credit_card_number').keypress(function(event){

           if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
               event.preventDefault(); //stop character from entering input
           }

          if($(this).val().length > 0){
            $('.credit_card_number_error').hide();
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
      
      $('#applicant_signature').keyup(function(){
          if($(this).val().length > 0){
            $('.applicant_signature_error').hide();
          } else{
            $('#applicant_signature').after('<div class="reds applicant_signature_error"><?php echo $this->query_model->getStaticTextTranslation('enter_applicant_signature'); ?></div>');
            
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
    
  });
</script>


<!-- dojo cart payment here -->
<section id="payment-block">
  <div class="container">
    <div class="row">
    <div class="col-md-12 col-xs-12">
      <div class="dojocart">
        <div class="media">
          <a class="media-left">
		  <?php if($single_record->override_logo != ''){
					$dojo_cart_logo = $this->query_model->getbySpecific('tbloverride_logos','s_no', $single_record->override_logo);
						if(!empty($dojo_cart_logo)){
		  ?>
		  <img src="<?php echo base_url().'upload/override_logos/'.$dojo_cart_logo[0]->logos; ?>" class="about-logo 1" alt="<?php $this->query_model->getStrReplace($dojo_cart_logo[0]->logo_alt); ?>"> 
		  <?php } } ?>
		  
          <?php /*if(!empty($single_record->product_image)) { ?>
            <img class="" src="upload/dojocarts/<?php echo $single_record->product_image;  ?>" alt="dojo">
            <?php } */ ?>
          </a>
          <div class="media-body">
            <h2 class="media-heading"><?php if(!empty($single_record->product_title)) { $this->query_model->getDescReplace($single_record->product_title); } ?></h2>
            <?php if(!empty($single_record->product_description)) { $this->query_model->getDescReplace($single_record->product_description); } ?>
          </div>
          <div class="gurantee-image hidden-sm hidden-xs">
             <?php if($single_record->money_back_img == 1){  ?><img src="images/money-back.png"> <?php } ?>
          </div>
        </div>
      </div>
    </div>

<div class="clearfix"></div>
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
<section id="video-advertisement">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
               
                <?php if(!empty($single_record->youtube_video) && $single_record->video_type == 'youtube_video') { ?>
                   <div class="player-inner">
                    <iframe width="100%" height="" src="<?php echo $single_record->youtube_video ?>?modestbranding=1&autohide=1&showinfo=0&controls=1&rel=0" frameborder="0" allowfullscreen></iframe>
                
                <?php } else{ ?>
<?php if(!empty($single_record->vimeo_video) && $single_record->video_type == 'vimeo_video') { ?>
                    <iframe width="100%" height="" src="<?php echo $single_record->vimeo_video ?>" frameborder="0" allowfullscreen></iframe>
                </div>
                  <?php }}?>
                  </div>
            </div>
        </div>
    
</section>
<?php } ?>

  <div class="container">
    <div class="row">
      <div class="col-md-5 col-xs-12 col-sm-6 col-md-push-7">
       <div class="policy cart-policy">
          <div class="price text-center">
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
            <img class="" src="upload/dojocarts/<?php echo $single_record->offer_image;  ?>" alt="<?php $this->query_model->getDescReplace($single_record->offer_image_alt_text); ?>" class="img-responsive img-centered">
            <?php } ?>
        </div>
      </div>

    <div class="col-md-7 col-xs-12 col-sm-6 col-md-pull-5">
      <div class="contact-form-payment">
      <?php 
      if($paymentDetail[0]->authorize_net_payment == 1 || $paymentDetail[0]->braintree_payment == 1  ){
          if (!empty($single_record->payment_type && $single_record->payment_type == 'paid') ) {
                if( !empty($paymentDetail[0]->authorize_net_payment) && $paymentDetail[0]->authorize_net_payment == 1 ){
                  $action_value = 'dojocartpayment/authorized_payment_gateway/'.$single_record->id;
                }

                if( !empty($paymentDetail[0]->braintree_payment) && $paymentDetail[0]->braintree_payment == 1 ){
                  $action_value = 'dojocartpayment/brainTreePaymentGateway/'.$single_record->id;
                }
            }else{
                $action_value = 'dojocartpayment/buyspecial/'.$single_record->id;
              }
      }
        else{
          $action_value = 'dojocartpayment/buyspecial/'.$single_record->id;
        }
        ?>
        <h3>Contact Info </h3>
        <form class="row" method="post" id="paymentForm" action="<?php echo $domain_host.$action_value; ?>">
        <div class="col-md-6 col-sm-6">

          <div class="form-group">

          <label><?php echo $this->query_model->getStaticTextTranslation('first_name'); ?></label>

          <input type="text" class="form-control" name="name" value="" id="name" placeholder="<?php echo $this->query_model->getStaticTextTranslation('first_name'); ?>" onfocus="this.placeholder = ''"   onBlur="textAlphabatic(this)" maxlength="25" error_class="name_error" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?>" >
          <input type="hidden" name="product_id" value="<?php echo $single_record->id; ?>">

          </div>

        </div>  

        <div class="col-md-6 col-sm-6">

          <div class="form-group">

          <label><?php echo $this->query_model->getStaticTextTranslation('last_name'); ?></label>

          <input type="text" class="form-control" name="last_name" value="" id="last_name" placeholder="<?php echo $this->query_model->getStaticTextTranslation('last_name'); ?>"  onBlur="textAlphabatic(this)" maxlength="25" error_class="last_name_error" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?>">

          </div>

        </div>

          <div class="col-md-6 col-sm-6">

          <div class="form-group">

          <label>Email</label>

          <input type="email" class="form-control" name="email" value="" id="email">

          </div>

        </div>  

        <div class="col-md-6 col-sm-6">

          <div class="form-group">

          <label>Phone</label>

          <input type="text" id="telephone" class="form-control" name="phone" value=""  error_class="phone_error" onBlur="phoneValidation(this)" maxlength="10" >

          </div>

        </div>   

		<?php if($multiLocation[0]->field_value == 1){ ?>
		<div class="col-md-12 col-sm-12">
		 <div class="form-group">

          <label>Location </label>

            <select class="form-control" name="location_id" id="location_id">

              <?php foreach($allLocations as $allLocation){ ?>
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



        <?php if($paymentDetail[0]->authorize_net_payment == 1 || $paymentDetail[0]->braintree_payment == 1 ) {
        if($single_record->payment_type == 'paid'){ ?>
        <h3>Payment Info</h3>
          <div class="col-md-12">
            <div class="clearfix"></div>
            <img src="images/cards.png" >
            <p>&nbsp;</p>
          </div> 
          <div class="col-md-12">

            <div class="form-group">

            <label><?php echo $this->query_model->getStaticTextTranslation('name_on_card'); ?></label>

            <input type="text" class="form-control" name="card_name" id="card_name">
      
            </div>

          </div>

          <div class="col-md-6 col-sm-6">

            <div class="form-group">

            <label><?php echo $this->query_model->getStaticTextTranslation('credit_card_number'); ?></label>
            <?php if( !empty($paymentDetail[0]->authorize_net_payment) && $paymentDetail[0]->authorize_net_payment == 1 ){ ?>

            <input type="text" class="form-control cc_number" name="credit_card_number" id="credit_card_number">
            <?php } else { ?>

            <input type="text" class="form-control" name="credit_card_number" id="credit_card_number">
            <?php } ?>
      
            </div>

          </div>  

          <div class="col-md-6 col-sm-6">

            <div class="form-group">

            <label>Security Code</label>

            <input type="text" class="form-control" name="cvv" id="cvv">

            </div>

          </div> 

          <div class="col-md-6 col-sm-6">

            <div class="form-group">

            <label><?php echo $this->query_model->getStaticTextTranslation('exp_month'); ?></label>
      <?php $months = array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December'); ?>
        <!--<input type="text" class="form-control" name="exp_month" required="required"> -->
       <select class="form-control" name="exp_month" id="exp_month">

              <option value="">Month</option>

               <?php foreach($months as $row => $key):?>



          <option value="<?=$row?>"><?=$key?></option>

        

        <?php endforeach;?>

            </select>
            </div>

          </div>  

          <div class="col-md-6 col-sm-6">

            <div class="form-group">

            <label><?php echo $this->query_model->getStaticTextTranslation('exp_year'); ?></label>
      <?php 
            $cur_year = date('Y');
            $years = array();
            for ($i=1; $i<=30; $i++) {
              $years[] = $cur_year++;
            }

      ?>

      <select class="form-control" name="exp_year" id="exp_year">

              <option value="">Year</option>
      
      <?php foreach($years as $key => $year){ ?>
        <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
      <?php } ?>
               
      
      

      <input type="hidden" name="miniform" value="" /> 
      <input type="text" id="website" name="website" style="display:none" autocomplete="off">

          </div>

        </div>
  
          <div class="clearfix"></div>
          
            <?php
              // Sales_tax_main is ON/OFF 
              if(!empty($single_record->sales_taxable) && $single_record->sales_taxable == 1) {
               $sales_tax_main = $single_record->sales_tax_main;
              }else{
                $sales_tax_main = 0;
              }
            ?>
        <?php if(!empty($single_record->show_<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?>) && $single_record->show_<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?> == 1) { ?>
          <div class="col-md-12 col-xs-12">
            <div class="offer-block">
                 <div class="<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?>">
                  <label><?php echo $this->query_model->getStaticTextTranslation('quantity'); ?></label>
				  
                <span>
				<span class="upDownButton btn btn-default btn-sm" type="add">+</span>
				<input id="<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?>" name="<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?>" type="text" min="1" value="1" sales_price="<?= $single_record->price; ?>" sales_tax="<?php echo $sales_tax_main; ?>" readonly="true"/>
				<span class="upDownButton btn btn-default btn-sm" type="sub">-</span>
				</span>
				
                  <input id="price" type="hidden" name="" value="<?= $single_record->price; ?>">
                  <input type="hidden" id="hide_<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?>" name="hide_<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?>" value="1">
                </div>
            </div> 
         </div>
            <?php } else{ ?>

            <div style="display:none">
              <div class="col-md-12 col-xs-12">
                <div class="offer-block">
                  <div class="<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?>">
                  <label><?php echo $this->query_model->getStaticTextTranslation('quantity'); ?></label>
                    <span>
					<span class="upDownButton btn" type="add">+</span>
					<input id="<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?>" name="<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?>" type="text" min="1" value="1" sales_price="<?= $single_record->price; ?>" sales_tax="<?php echo $sales_tax_main; ?>" readonly="true"/>
					<span class="upDownButton btn" type="sub">-</span>
					</span>
                  <input id="price" type="hidden" name="" value="<?= $single_record->price; ?>">
                  <input type="hidden" id="hide_<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?>" name="hide_<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?>" value="1">
                  </div>
                </div>
            </div> 
          </div>

            <?php
                      }
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
 <h3><?=$upsell_opt->up_title.' $'.$upsell_opt->up_price?></h3>

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
              <label><?= $upsell_opt->yes ?><input status_type="no" upsale_id="<?php echo $upsell_opt->id; ?>"  price="<?php echo $amount_up_salestax; ?>" class="set-redio is-checked upsellcheckbox chk_<?php echo $a; ?>_1"  name="yes" num_id="<?= $a; ?>"  value="1" type="checkbox" upsell_tax="<?php echo $sales_tax; ?>" upsell_price="<?php echo $upsell_opt->up_price; ?>">
              <input type="hidden" name="upsale_id[]" class="upsale_checkbox_<?php echo $upsell_opt->id; ?>" value=""></label>
</div>

<div class="checkbox ">
              <label><?= $upsell_opt->no ?><input status_type="no" upsale_id="<?php echo $upsell_opt->id; ?>"  price="<?php echo $amount_up_salestax; ?>"  class="set-redio is-checked  upsellcheckbox chk_<?php echo $a; ?>_0"  name="no" num_id="<?= $a;?>"  value="0" type="checkbox"  upsell_tax="<?php echo $sales_tax; ?>" upsell_price="<?php echo $upsell_opt->up_price; ?>"></label>
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
      </div>

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
		
      <?php  
      
      if(!empty($single_record->sales_taxable) && $single_record->sales_taxable == 1){ ?>
			<div class="total-price">
              <label>SubTotal:</label>
              <span></span><span id="total">$<?php  echo $single_record->price; ?></span>
              <input id="amount" type="hidden" name="amount" value="<?php echo $single_record->price; ?>">
            </div>

            <div class="total-price">
              <label>Tax:</label>
              <span></span><span id="total_tax">$<?php echo $amount_salestax; ?></span>
              <input id="total_tax_amount" type="hidden" name="total_tax_amount" value="">
            </div>
            
		<?php }else{ ?>
			<div style="display:none">
			<div class="total-price">
              <label>SubTotal:</label>
              <span></span><span id="total">$<?php  echo $single_record->price; ?></span>
              <input id="amount" type="hidden" name="amount" value="<?php echo $single_record->price; ?>">
            </div>

            <div class="total-price">
              <label>Tax:</label>
              <span></span><span id="total_tax">$<?php echo $amount_salestax; ?></span>
            </div>
			</div>
			
		<?php } ?>
		
		<div class="total-price coupon_discont_price_box" style="display:none">
              <label><?php echo $this->query_model->getStaticTextTranslation('coupon_discount'); ?>:</label>
              <span></span><span id="coupon_discont_html"></span>
              <input id="coupon_discont" value="" type="hidden">
        </div>
			
		<div class="total-price">
              <label>Total:</label>
              <span></span><span id="total_price">$<?php echo $amount_salestax; ?></span>
              <input id="total_amount" name="amount" value="<?php  echo $amount_salestax; ?>" type="hidden">
            </div>
		
		
	</div></div>	
	<?php } ?>	
		
		
		<!--- Coupon Part ----->
		<?php if(!empty($single_record->coupon_code) && $single_record->coupon_code == 1) { ?>
		<div class="clearfix"></div>
<div class="row couponBox"> 		
		<div class="col-md-12 col-sm-12" id="couponResult">       </div> 
		
		  <div class="col-md-4 col-sm-4">
			<div class="form-group">
				<label>Do you have a coupon?</label>
				<input type="text" id="coupon" class="form-control" value="" >
				<input type="hidden" id="dojocart_id" value="<?php echo $single_record->id; ?>" >
				<input type="hidden" id="applied_coupon" value="0" >
				<input type="hidden" name="coupon_code" id="coupon_code" value="" >
				<input type="hidden" name="coupon_discount" id="coupon_discount" value="" >
			</div>
		</div>
		<div class="col-md-8 col-sm-8">
			<div class="form-group">
				<a class="btn btn-default" id="applyCouponBtn">Apply Coupon</a>
			</div>
		</div>
		</div>
		<?php } ?>
		<!--- end coupon -->
		
      <div id="billing-payment">
        <div class="row">
      <div class="col-md-12">
      <?php if(!empty($single_record->show_term_condition) && $single_record->show_term_condition == 1) { ?>
        <div class="offer-agreement"><p><?php if(!empty($single_record->term_condition)) { echo $single_record->term_condition; } ?></p>
        </div>
           <div class="checkbox ">
              <label><input type="checkbox" name="term_condition" id="tc" value="1">I agree to the Terms & Condition</label>
            </div>
            <div class="purchase-now">
          <input type="submit" id="submitPaymentButton" name="submit" class="btn btn-theme btn-lg btn-block" disabled value="<?php echo $this->query_model->getStaticTextTranslation('purchase_now'); ?>"> </button>
          </div>
            <?php } else{ ?>
          <div class="purchase-now">
          <input type="submit" id="submitPaymentButton" name="submit" class="btn btn-theme btn-lg btn-block" value="<?php echo $this->query_model->getStaticTextTranslation('purchase_now'); ?>"> </button>
         <!--  <a href="#" class="btn btn-theme btn-lg btn-block"> <?php echo $this->query_model->getStaticTextTranslation('purchase_now'); ?></a> -->
          </div>
          <?php } ?>
      </div>
    </div>
      </div>
      
      </form>
    </div>
    </div>
  </div>
</section>
 </div>
  </div>
<!-- dojo cart payment ends here -->

<script type="text/javascript">
 
$(document).ready(function(){
	
    var sales_price = $("#<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?>").attr('sales_price');
    var sales_tax = $("#<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?>").attr('sales_tax');
    var priceWithSalesTax = (parseFloat(sales_price) * parseFloat(sales_tax)) / 100;
    $('#total_tax').html('$'+priceWithSalesTax.toFixed(2));
    $('#total_tax_amount').val('$'+priceWithSalesTax.toFixed(2));
        
  
  $("#<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?>").keypress(function (evt) {
    evt.preventDefault();
});

    $(".upDownButton").click(function(){
		var old<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?> = $('#<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?>').val();
		if(old<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?> == "" || old<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?> == null){
			old<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?> = 0;
		}
		var upDownType = $(this).attr('type');
		var <?php echo $this->query_model->getStaticTextTranslation('quantity'); ?> = old<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?>;
		if(upDownType == 'add'){
			<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?> = parseInt(old<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?>) + 1;
		}
		
		if(upDownType == 'sub'){
			<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?> = parseInt(old<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?>) - 1;
			if(<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?> <= 0){
				<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?> = 1;
			}
		}
        
		$('#<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?>').val(<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?>); 
		
       
        var price = $("#price").val();
        var total = <?php echo $this->query_model->getStaticTextTranslation('quantity'); ?> * price;

        var sales_price = $("#<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?>").attr('sales_price');
        var sales_tax = $("#<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?>").attr('sales_tax');
        var priceWithSalesTax = (parseFloat(sales_price) * parseFloat(sales_tax)) / 100; //0.20
		var alreadySaleTaxAmount = $("#total_tax").html();
		alreadySaleTaxAmount = alreadySaleTaxAmount.replace('$', '');
		
		var sub_amount = $("#total").html();
	sub_amount = sub_amount.replace('$', '');
	
       // var total_tax = (parseFloat(total) * parseFloat(sales_tax)) / 100; 
       // $('#total_tax').html('$'+total_tax.toFixed(2));
        

        var priceWithSalesTax = parseFloat(priceWithSalesTax) + parseFloat(sales_price); 


        var hide_<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?> = $("#hide_<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?>").val();
        
        var total_price = $('#total_amount').val();

         if(parseInt(<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?>) > parseInt(hide_<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?>)){
			var total_amount =  parseFloat(total_price) + parseFloat(priceWithSalesTax);
           
			var priceWithSalesTax = (parseFloat(sales_price) * parseFloat(sales_tax)) / 100; //0.20 sale tax
			var total_tax = parseFloat(alreadySaleTaxAmount) + parseFloat(priceWithSalesTax);
			var tot_sub_amount = parseFloat(sub_amount) + parseFloat(sales_price);
         }else {
            if(parseInt(<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?>) != parseInt(hide_<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?>)){
              var total_amount =  parseFloat(total_price) - parseFloat(priceWithSalesTax);
              var priceWithSalesTax = (parseFloat(sales_price) * parseFloat(sales_tax)) / 100; //0.20 sale tax
				var total_tax = parseFloat(alreadySaleTaxAmount) - parseFloat(priceWithSalesTax);
				var tot_sub_amount = parseFloat(sub_amount) - parseFloat(sales_price);
            }
             
          
         }

         // With Upsale OR Total Price
         if(parseInt(<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?>) != parseInt(hide_<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?>)){
          $('#total_price').html('$'+total_amount.toFixed(2));
          $('#total_amount').val(total_amount.toFixed(2));

          // Without Upsale OR Subtotal Price
          $("#total").text('$'+tot_sub_amount.toFixed(2));
          $("#amount").val(tot_sub_amount.toFixed(2));
          $('#hide_<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?>').val(<?php echo $this->query_model->getStaticTextTranslation('quantity'); ?>);
		  $('#total_tax').html('$'+total_tax.toFixed(2));
      $('#total_tax_amount').val('$'+total_tax.toFixed(2));
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
		$(".coupon_discont_price_box").hide();
		var coupon_code = $('#coupon').val();
		var dojocart_id = $('#dojocart_id').val();
		var applied_coupon = $("#applied_coupon").val();
		var coupon_discont = $("#coupon_discont").val();
		//alert('coupon_code=>'+coupon_code+'<=dojocart_id=>'+dojocart_id);
		$.ajax({
			type : 'POST',
			url : '<?php echo base_url().'site/ajaxApplyCoupon' ?>',
			dataType : 'json',
			data : {coupon_code : coupon_code,dojocart_id:dojocart_id},
			
		}).done(function(result){
			if(result.status == 1){
				var couponDiscount = result.discount;
				$("#couponResult").html('<div class="alert alert-success">Successfully You have get $'+couponDiscount+' discount on "'+coupon_code+'" coupon code</div>' );
				$(".coupon_discont_price_box").show();
				$("#coupon_discont_html").html('-$'+couponDiscount);
				$("#coupon_discont").val(couponDiscount);
				
				
				
				if(applied_coupon == 0){
					var oldTotalPrice = $("#total_amount").val();
					var newPrice = parseFloat(oldTotalPrice) - parseFloat(couponDiscount);
				}else if(applied_coupon == 1){
					var oldTotalPrice = $("#total_amount").val();
					//alert('oldTotalPrice=>'+oldTotalPrice+'<=couponDiscount=>'+couponDiscount+'<=coupon_discont=>'+coupon_discont); 
					var newPrice = (parseFloat(oldTotalPrice) - parseFloat(couponDiscount)) + parseFloat(coupon_discont);
				}
				
				$("#total_price").html('$'+newPrice);
				$("#total_amount").val(newPrice);
				
				$("#applied_coupon").val(1);
				$("#coupon_code").val(coupon_code);
				$("#coupon_discount").val(couponDiscount);
			}else{
				$("#couponResult").html('<div class="alert alert-danger">Invalid Coupon Code</div>' );
			}
		});
	});
	
});

// Upsell Section 
$('.upsellcheckbox').click(function(){

    var number = $(this).attr('num_id');
    var amount_sub_total =  $('#total_amount').val();
    var price = $(this).attr('price');
    var value = $(this).val();
	  var upsale_id = $(this).attr('upsale_id');
	 
    // new varibles 05/12
  	var upsell_tax = $(this).attr('upsell_tax');
  	var upsell_price = $(this).attr('upsell_price');
  	var alreadySaleTaxAmount = $("#total_tax").html();
  	alreadySaleTaxAmount = alreadySaleTaxAmount.replace('$', '');
  	
  	var sub_amount = $("#total").html();
  	sub_amount = sub_amount.replace('$', '');
  	
  	if($(this).is(":checked")) {
        
        $('.upsale_checkbox_'+upsale_id).val(upsale_id);
        if(value == 1){

          
          var tot_sub_amount = parseFloat(sub_amount) + parseFloat(upsell_price);
		  $('#total').html('$'+tot_sub_amount.toFixed(2));	
		  
           var total_amount =  parseFloat(amount_sub_total) + parseFloat(price);
            $('#total_price').html('$'+total_amount.toFixed(2));
            $('#total_amount').val(total_amount.toFixed(2));
             $('.chk_'+number+'_'+0).attr('status_type','yes');
             $('.chk_'+number+'_'+1).attr('status_type','yes');
            $('.chk_'+number+'_'+0).attr('checked',false);
			
			var priceWithSalesTax = (parseFloat(upsell_price) * parseFloat(upsell_tax)) / 100; //0.20 sale tax
			var total_tax = parseFloat(alreadySaleTaxAmount) + parseFloat(priceWithSalesTax);
			$('#total_tax').html('$'+total_tax.toFixed(2));
      $('#total_tax_amount').val('$'+total_tax.toFixed(2));
			
           


        }else{
             var status_type = $(this).attr('status_type');
            if(status_type == 'no' && value == 0){
            		$('.upsale_checkbox_'+upsale_id).val('');
             }else{
             		$('.upsale_checkbox_'+upsale_id).val('');
                  var total_amount =  parseFloat(amount_sub_total) - parseFloat(price);

                $('#total_price').html('$'+total_amount.toFixed(2));
                $('#total_amount').val(total_amount.toFixed(2));
				
				var priceWithSalesTax = (parseFloat(upsell_price) * parseFloat(upsell_tax)) / 100; //0.20 sale tax
				var total_tax = parseFloat(alreadySaleTaxAmount) - parseFloat(priceWithSalesTax);
				$('#total_tax').html('$'+total_tax.toFixed(2));
        $('#total_tax_amount').val('$'+total_tax.toFixed(2));
				  
				  var tot_sub_amount = parseFloat(sub_amount) - parseFloat(upsell_price);
				  $('#total').html('$'+tot_sub_amount.toFixed(2));
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
              $('#total_price').html('$'+total_amount.toFixed(2));
              $('#total_amount').val(total_amount.toFixed(2));
			  
			  var priceWithSalesTax = (parseFloat(upsell_price) * parseFloat(upsell_tax)) / 100; //0.20 sale tax
				var total_tax = parseFloat(alreadySaleTaxAmount) - parseFloat(priceWithSalesTax);
				$('#total_tax').html('$'+total_tax.toFixed(2));
        $('#total_tax_amount').val('$'+total_tax.toFixed(2));
				
				var tot_sub_amount = parseFloat(sub_amount) - parseFloat(upsell_price);
				//alert('sub_amount=>'+sub_amount+'upsell_price=>'+upsell_price); return false;
				$('#total').html('$'+tot_sub_amount.toFixed(2));
          }
         
           
    }

});

$('input.example').on('change', function() {
    $('input.example').not(this).prop('checked', false);  
});



</script>


<?php $this->load->view('includes/dojocart_footer'); ?> 

