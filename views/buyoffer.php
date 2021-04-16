<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<?php $this->load->view('includes/header'); ?>
<?php  $this->load->view('includes/header/payment_masthead'); ?>
<?php $phoneNumberMaxLength = $this->query_model->phoneNumberMaxLength(); 

	  $getPhoneNumberClass = $this->query_model->getPhoneNumberClass(); 
?>
<?php //echo $this->session->userdata('refferal_url'); die;?>
<!-- Navigation --> 
<?php 
$site_setting_service = $this->query_model->getSiteSetting();
$site_url = base_url();
$location_detail_service = $this->query_model->getSchoolDetail(); 
$offer_detail_service = $this->query_model->getTrialOfferDetail(); 
$main_location = $this->query_model->getMainLocation(); 

$site_settings = $this->query_model->getSiteSetting();
$site_settings = $site_settings[0];

$domain_host = base_url();
$check_pay_method = $this->uri->segment(2);
?>


<style>
.reds {left:11px!important;position: absolute !important;top:61px!important; z-index: 2 !important;}
.sign {
  margin-bottom: 0;
  position: relative;
}
.sign >.reds{top:30px !important;left:0px!important;}
</style>
<script>
	$(document).ready(function(){
		
		$('.submitPaymentButton').click(function(){

			var err = 0
			
			
			
			var name=$('#name').val();
					//alert(name); return false;
					if(name.length == 0){
						var err = 1;
						$('#name').after('<div class="reds name_error">Enter your name</div>');
						return false;
					}
			
			var last_name=$('#last_name').val();
					//alert(last_name); return false;
					if(last_name.length == 0){
						var err = 1;
						$('#last_name').after('<div class="reds last_name_error">Enter your last name</div>');
						return false;
					}

			var address=$('#address').val();
					//alert(name); return false;
					if(address.length == 0){
						var err = 1;
						$('#address').after('<div class="reds address_error">Enter your Address</div>');
						return false;
					}
										
			var city=$('#city').val();
					//alert(city); return false;
					if(city.length == 0){
						var err = 1;
						$('#city').after('<div class="reds city_error">Enter your city</div>');
						return false;
					}
					
			var zip=$('#zip').val();
					//alert(zip); return false;
					if(zip.length == 0){
						var err = 1;
						$('#zip').after('<div class="reds zip_error">Enter your zip</div>');
						return false;
					}
					
			var card_name=$('#card_name').val();
					//alert(card_name); return false;
					if(card_name.length == 0){
						var err = 1;
						$('#card_name').after('<div class="reds card_name_error">Enter your card name</div>');
						return false;
					}
					
			var credit_card_number=$('#credit_card_number').val();
					//alert(credit_card_number); return false;
					if(credit_card_number.length == 0){
						var err = 1;
						$('#credit_card_number').after('<div class="reds credit_card_number_error">Enter your credit card number</div>');
						return false;
					}
					
			var cvv=$('#cvv').val();
					//alert(cvv); return false;
					if(cvv.length == 0){
						var err = 1;
						$('#cvv').after('<div class="reds cvv_error">Enter your cvv</div>');
						return false;
					}
					
			var applicant_signature=$('#applicant_signature').val();
					//alert(applicant_signature); return false;
					if(applicant_signature.length == 0){
						var err = 1;
						$('#applicant_signature').after('<div class="reds applicant_signature_error">Enter your applicant signature</div>');
						return false;
					}
			
			var exp_month=$('#exp_month').val();
					if(exp_month == '' || exp_month == null){
						var err = 1;
						$('#exp_month').after('<div class="reds exp_month_error">Select Exp month</div>');
						return false;
					}
					
			var exp_year=$('#exp_year').val();
					if(exp_year == '' || exp_year == null){
						var err = 1;
						$('#exp_year').after('<div class="reds exp_year_error">Select Exp year</div>');
						return false;
					}
					
			var state=$('#state').val();
					if(state == '' || state == null){
						var err = 1;
						$('#state').after('<div class="reds state_error">Select state</div>');
						return false;
					}
					
			/*var telephone=$('#telephone').val();
					
					<?php if($site_settings->phone_required == 1){ ?>
                                              <?php if($site_settings->international_phone_fields != 1){ ?>
					if(telephone.length <= 11 || telephone.length == 0){
						var err = 1;
						$('#telephone').after('<div class="reds phone_error">Enter a valid phone number</div>');
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
							$('#'+telephoneId).after('<div class="reds '+phoneError+'">Enter a valid phone number</div>');
							return false;
						} 
						<?php //}
						}else{ ?>
						
							if(telephone.length <= <?php echo $phoneNumberMaxLength - 1; ?> && telephone.length > 0){
									$('#'+telephoneId).after('<div class="reds '+phoneError+' ">Enter a valid phone number</div>');
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
							$('#'+telephoneId).after('<div class="reds '+phoneError+'">Enter a valid phone number</div>');
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
									$('#'+telephoneId).after('<div class="reds '+phoneError+'">Enter a valid phone number</div>');
									var err = 1;
									return false;
								}	
							}	
					<?php		}	?> 
					
					<?php }?>
						
						
					
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
								$('#telephone').after('<div class="reds phone_error">Enter a valid phone number</div>');
                                                            <?php  } ?>
							}
						<?php }else{ ?>
                                                            <?php if($site_settings->international_phone_fields == 1){ ?>
                                                                $('.phone_error').hide();
                                                            <?php  }else{ ?>
								$('#telephone').after('<div class="reds phone_error">Enter a valid phone number</div>');
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
						$('#name').after('<div class="reds name_error">Enter your name</div>');
						
					}
			});
			
			$('#last_name').keyup(function(){
					if($(this).val().length > 0){
						$('.last_name_error').hide();
					} else{
						$('#last_name').after('<div class="reds last_name_error">Enter your last name</div>');
						
					}
			});
			
			$('#city').keyup(function(){
					if($(this).val().length > 0){
						$('.city_error').hide();
					} else{
						$('#city').after('<div class="reds city_error">Enter your city</div>');
						
					}
			});
			
			$('#zip').keyup(function(){
					if($(this).val().length > 0){
						$('.zip_error').hide();
					} else{
						$('#zip').after('<div class="reds zip_error">Enter your zip</div>');
						
					}
			});
			
			$('#card_name').keyup(function(){
					if($(this).val().length > 0){
						$('.card_name_error').hide();
					} else{
						$('#card_name').after('<div class="reds card_name_error">Enter your card name</div>');
						
					}
			});

			  $('#credit_card_number').keypress(function(event){

		       if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
		           event.preventDefault(); //stop character from entering input
		       }

		   });

			$('.cc_number').keyup(function(){
		        var ccnum = $(this).val();
		        var two_digit = ccnum.substr(0, 2);
		        

		        var reg_amcExp =  new RegExp('^3[47][0-9]{13}$');
		        if( two_digit == 34 || two_digit == 37 || reg_amcExp.test(ccnum)){
		          $('.cc_number').after('<div class="reds cc_number_error">American Express not Accecpted, Please use visa or Master</div>');
		          $('.credit_card_number_error').hide();
		        } else{
		          $('.cc_number_error').hide();
		          $('.credit_card_number_error').hide();

		        } 


      });
			
			$('#credit_card_number').keyup(function(){
					if($(this).val().length > 0){
						$('.credit_card_number_error').hide();
					} else{
						$('#credit_card_number').after('<div class="reds credit_card_number_error">Enter your credit card number</div>');
						
					}
			});
			
			$('#cvv').keyup(function(){
					if($(this).val().length > 0){
						$('.cvv_error').hide();
					} else{
						$('#cvv').after('<div class="reds cvv_error">Enter your cvv</div>');
						
					}
			});
			
			$('#applicant_signature').keyup(function(){
					if($(this).val().length > 0){
						$('.applicant_signature_error').hide();
					} else{
						$('#applicant_signature').after('<div class="reds applicant_signature_error">Enter your applicant signature</div>');
						
					}
			});
			
			
			$('#address').keyup(function(){
					if($(this).val().length > 0){
						$('.address_error').hide();
					} else{
						$('#address').after('<div class="reds address_error">Enter your Address</div>');
						
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


  <form class="" method="post" action="<?php echo $domain_host; ?>payment/authorized_payment_gateway">

<section id="payment-block">

  <div class="container">

    <div class="row">

    <div class="col-md-6 col-xs-12 col-sm-6">

      <div class="theme-logo">

	    <img src="<?php echo $site_url.$site_setting_service[0]->sitelogo; ?>"  alt="<?php echo $this->query_model->getDescReplace($site_setting_service[0]->logo_alt); ?>">

      </div> 

      <div class="secure">

        <h2>PURCHASE TRIAL OFFER!<br> SECURE CHECK OUT</h2>

      </div>

      <div class="contact-form-payment">

        <h3>Contact Info</h3>

      

        <div class="col-md-6 col-sm-6">

          <div class="form-group">

          <label>First Name</label>

          <input type="text" class="form-control" name="name" value="<?php if(isset($_POST['name'])){ echo $_POST['name']; } ?>" id="name" placeholder="First Name" onfocus="this.placeholder = ''"   onBlur="textAlphabatic(this)" maxlength="25" error_class="name_error" error_msg="Enter your first name" >

          </div>

        </div>  

        <div class="col-md-6 col-sm-6">

          <div class="form-group">

          <label>Last Name</label>

          <input type="text" class="form-control" name="last_name" value="<?php if(isset($_POST['last_name'])){ echo $_POST['last_name']; } ?>" id="last_name" placeholder="Last Name"  onBlur="textAlphabatic(this)" maxlength="25" error_class="last_name_error" error_msg="Enter your last name" >

          </div>

        </div>  

        <div class="col-md-12">

          <div class="form-group">

          <label>Address</label>

          <input type="text" id="address" class="form-control" name="address">

          </div>

        </div>

        <div class="col-md-12">

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

              <option value="">Choose State</option>

            	 <?php foreach($state_list as $row => $key):?>



					<option value="<?=$key?>"><?=$row?></option>

				

				<?php endforeach;?>

            </select>

          </div>

        </div> 

        <div class="col-md-6 col-sm-6">

          <div class="form-group">

          <label>Zip</label>

          <input type="text" class="form-control" name="zip" id="zip">

          </div>

        </div>  

        <div class="col-md-6 col-sm-6">

          <div class="form-group">

          <label>Phone</label>

          <input type="text" id="telephone" class="form-control   <?php echo $getPhoneNumberClass; ?>" name="phone" value="<?php if(isset($_POST['phone'])){ echo $_POST['phone']; } ?>"  error_class="phone_error" onBlur="phoneValidation(this)" maxlength="<?php echo $phoneNumberMaxLength; ?>" >

          </div>

        </div>  

       <!-- </form>-->

        <h3>Payment Info</h3>

        <!--<form class="row">-->

          <div class="col-md-12">

            <img src="images/cards.png" class="pull-right">

          </div> 

          <div class="col-md-12">

            <div class="form-group">

            <label>Name on Card</label>

            <input type="text" class="form-control" name="card_name" id="card_name">
			
            </div>

          </div>

          <div class="col-md-6 col-sm-6">
            <div class="form-group">
            <label>Credit Card Number</label>
			<input type="text" class="form-control cc_number" name="credit_card_number" id="credit_card_number">

            <!-- <input type="text" class="form-control" name="credit_card_number" id="credit_card_number"> -->
            </div>
          </div>  

          <div class="col-md-6 col-sm-6">

            <div class="form-group">

            <label>CVV</label>

            <input type="text" class="form-control" name="cvv" id="cvv">

            </div>

          </div> 

          <div class="col-md-6 col-sm-6">

            <div class="form-group">

            <label>Exp Month</label>
			<?php $months = array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December'); ?>
			  <!--<input type="text" class="form-control" name="exp_month" required="required"> -->
			 <select class="form-control" name="exp_month" id="exp_month">

              <option value="">Choose Month</option>

            	 <?php foreach($months as $row => $key):?>



					<option value="<?=$row?>"><?=$key?></option>

				

				<?php endforeach;?>

            </select>
            </div>

          </div>  

          <div class="col-md-6 col-sm-6">

            <div class="form-group">

            <label>Exp Year</label>
			<?php 
						$cur_year = date('Y');
						$years = array();
						for ($i=1; $i<=30; $i++) {
							$years[] = $cur_year++;
						}
						//echo '<pre>'; print_r($years); die;
			?>
            <!--<input type="text" class="form-control" name="exp_year" required="required"> -->
			<select class="form-control" name="exp_year" id="exp_year">

              <option value="">Choose Years</option>
			
			<?php foreach($years as $key => $year){ ?>
				<option value="<?php echo $year; ?>"><?php echo $year; ?></option>
			<?php } ?>
            	 
			
			

			<input type="hidden" name="miniform" value="" /> 
<input type="hidden" name="page_url" value="<?php echo isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';  ?>" />
               <input type="text" id="website" name="website" style="display:none" autocomplete="off">

            </div>

          </div>  

       

      </div>

    </div>

	  <div class="col-md-6 col-xs-12 col-sm-6">

        <div class="address-info">
		<?php if(!empty($location_detail_service)){ ?>
          <h4><?php echo $location_detail_service[0]->address; ?></h4>

          <h4><?php echo $location_detail_service[0]->city.', '.$location_detail_service[0]->state.' '.$location_detail_service[0]->zip; ?></h4>

          <p><a href="mailto:<?php echo $location_detail_service[0]->email; ?>"><?php echo $location_detail_service[0]->email; ?></a></p>
		<?php } ?>
        </div>

        <div class="clearfix"></div>

		<?php if(!empty($offer_detail_service)):?>

        	<div class="policy">

          <div class="price text-center">

            <h2><?php  $this->query_model->getDescReplace($offer_detail_service[0]->title); ?><br>

            	<?php if(!empty($offer_detail_service[0]->amount)){ ?>

					$ <?= $offer_detail_service[0]->amount ?>

				<?php } else { echo 'FREE'; } ?>

			</h2>

          </div>

        <div class="offers text-center">

          <p><?php $this->query_model->getDescReplace($offer_detail_service[0]->description );?></p>

          <ul class="offer-list">

		  	<?php 

				$features = unserialize($offer_detail_service[0]->features);	

				foreach($features as $feature): 

			?>

          	  <li><?php $this->query_model->getDescReplace($feature); ?></li>

			<?php endforeach; ?>

          </ul>


        </div>

        <div class="refund-policy">

          <label>Refund Policy: </label>

          <p>This trial offer is non refundable, and expires 12 months from purchasing day. You may transfer this trial offer to a friend or a family member by contacting the school directly.</p>

          <p>The charges will appear on your statement as: <br>

          <?php  $this->query_model->getDescReplace($site_settings->title);?>.

          </p>

          

          <label>Privacy Policy</label>

          <p>Customer information is collected for the purpose of processing your order. This information is kept confidential and is not shared.</p>  

        </div>

        </div>

		<?php endif; ?>

      </div>

    </div>

  </div>

</section>

<section id="billing-payment">

  <div class="container">

    <div class="row">

      <div class="col-md-12">

        <div class="billing-agreement">

          <label>Billing and Payment</label>

          <p>Billing and payment for this transaction is processed by <?php  $this->query_model->getDescReplace($site_settings->title);?>. By clicking submit you (the customer) authorize <?php  $this->query_model->getDescReplace($site_settings->title);?> to charge your credit card or bank account for the amount displayed on this page, and acknowledge full understanding of the terms and conditions indicated in this agreement.</p>



          <p>Customer assumes all responsibility for any bank fees incurred as a result of this transaction.</p> <br>
          <p> For Billing Inquiries please contact us via email at <?php echo $main_location[0]->email; ?>. By phone at <?php echo $main_location[0]->phone; ?>. Via Mail by writing to: <?php  $this->query_model->getDescReplace($site_settings->title);?>, <?php echo $main_location[0]->address; ?><?php  if(!empty($main_location[0]->suite)){ echo ', '.$main_location[0]->suite; }; ?> &#8226; <?php echo $main_location[0]->city; ?> <?php echo $main_location[0]->state; ?> <?php echo $main_location[0]->zip; ?></p>

          <br>

          <label>Applicant Agreement</label>

          <p>By digitally signing this form I agree to the terms and conditions stated above.  By filling out the above form and checking the terms and conditions box, I understand that I am legally bound to such terms and acknowledge this by providing a digital signature at the bottom of this section. I am a person of sound mind and I am the person in the application above.</p>

          <br>

<!--           <p><b>Applicant Signature -</b> Please enter your full name below:</p>

          <p class="sign">

            <input type="text" class="form-control" name="applicant_signature" id="applicant_signature">

          </p> -->

          </div>

          <div>I agree to the terms and conditions:  <input type="checkbox" required="" name="term_condition" value="1" ></div>

          <div class="submit-order">
<?php //echo '<pre>';print_r($offer_detail_service); die; ?>
		    <input type="hidden" name="amount" value="<?php if(!empty($offer_detail_service)){ echo $offer_detail_service[0]->amount; } ?>" />

		    <input type="hidden" name="program_id" value="<?php if(isset($_POST['program'])){ echo $_POST['program']; } ?>" />

		    <input type="hidden" name="location_id" value="<?php if(isset($_POST['location_id'])){ echo $_POST['location_id']; } ?>" />

			<input type="hidden" name="email" value="<?php if(isset($_POST['form_email_2'])){ echo $_POST['form_email_2']; } ?>" />

			<input type="hidden" name="trial_id" value="<?php if(isset($_POST['trial_id'])){ echo $_POST['trial_id']; } ?>" id="trial_id" />
			
			<input type="hidden" name="refferal_url" value="<?php if(isset($_POST['refferal'])){ $this->session->set_userdata('refferal_url',$_POST['refferal']); echo $_POST['refferal']; } ?>" />
			

           <!--  <input type="submit" name="submit" class="btn btn-theme" value="Submit Order"> </button> -->
            <input type="submit" name="submit" class="btn btn-theme submitPaymentButton" value="Submit Order"> </button>

          </div>

      </div>

    </div>

  </div>

</section>

 </form>



<?php $this->load->view('includes/footer'); ?> 



