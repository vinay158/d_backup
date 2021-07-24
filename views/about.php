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
<?php 

$_URL = array();

$query = $this->db->get( 'tblmeta' );

$result = $query->result();

foreach( $result as $row )

{

	if(!empty($row->slug) && !empty($row->page)) {

		$_URL[trim($row->slug)] = trim($row->page);

	}

}



$_SLUG = array('ourschool', 'ourfacility', 'ourstaff' , 'ourphilosophy', 'schoolrules', 'schoolrules', 'faq', 'events', 'news', 'videogallery','photogallery', 'ourprograms' , 'starttrial' , 'testimonials' , 'signin');


foreach($_SLUG as $needle) {

	$slug = array_search($needle, $_URL);

	if($slug == false) { $$needle = $needle; } 

	else { $$needle = $slug; } 

}

?>

<style type="text/css">.fancybox-custom .fancybox-skin {box-shadow: 0 0 50px #222;}</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script>
	$(window).load(function(){
			
			$('#loader').show();
			$.ajax({
			
					url: '<?=base_url();?>about/get_social_news_data/<?php echo $location_id; ?>',
					
					type: 'post',
					
					data: {type: 'social_news'},

					
					dataType: 'html',
					
					success: function(result) {
						$('#loader').hide();
						$('.socialNewsData').html(result);
						
						/*var $divs = $(".social_items");
						var numericallyOrderedDivs = $divs.sort(function (a, b) {
							return $(a).find("h2").text() < $(b).find("h2").text();
						});
						$("#social-news ul").html(numericallyOrderedDivs);*/
						
						$('#all_elements .social_items').sort(sortDescending).appendTo('#all_elements');
						
						function sortDescending(a, b) {
							var date1 = $(b).find("h2").text();
							var date2 = $(a).find("h2").text();
							 return (date1 < date2) ? -1 : (date1 > date2) ? 1 : 0;
						};
						
					}
				  
			});
	});
</script>

<style>
	.hidePosts{ display:none !important;}
</style>
<link rel="stylesheet" type="text/css" href="lightbox/jquery.fancybox.css?v=2.1.5" media="screen" />
	<script type="text/javascript" src="lightbox/lib/jquery-1.10.1.min.js"></script>
	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="lightbox/jquery.fancybox.js?v=2.1.5"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			/*
			 *  Simple image gallery. Uses default settings
			 */

			$('.fancybox').fancybox();

			/*
			 *  Different effects
			 */

			

			$('.fancybox').fancybox({
			  padding: 0,
			  helpers: {
				overlay: {
				  locked: false
				}
			  }
			});
		});
	</script>


		<div class="mobile-visible">
      <section id="about-trial-form" class="trial-form about-trial-form">
         <div class="container">
            <div class="row">
               <div class="col-md-12 text-center">
                 <div class="heading">
				  <?php if(!empty($aboutEmailOption) && !empty($aboutEmailOption[0]->opt1_text)) {
							$this->query_model->getDescReplace($aboutEmailOption[0]->opt1_text); 
				  }else{
					echo $this->query_model->getStaticTextTranslation('enter_email_view_current_web_specials');
				  }  ?>
				  
				  </div>
               </div>
            </div>
         </div>
      </section>
	
	  <?php 
		$emailOnlyForm1 = 1;
		if(!empty($aboutEmailOption) && $aboutEmailOption[0]->show_full_form_1 == 1){
			$emailOnlyForm1 = 0;
		}
	  ?>
	    </div>
		
	 <?php if($emailOnlyForm1 == 1){ ?>
	 <div class="mobile-visible">
      <div class="started-block white-bg">
	   <span></span>
				   <script>
				   
		$(document).ready(function(){
			
			
		$('.contactFormSubmit_8').click(function(){
		
					var err = 0
					
					
					var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
					var email=$('#form_email_8').val();
					if(email.length == 0 || emailfilter.test($("#form_email_8").val()) == false){
						var err = 1;
						$('#form_email_8').after('<div class="reds email_error8"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
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
						$('.email_error8').hide();
					} else{
						$('#form_email_8').after('<div class="reds email_error8"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
						
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
			<?php }*/ ?>   	
					
			
			
		});

	</script>
	<form action="#"  method="post" class="get_started_form mini_form small_mini_form" id="form_8">
	<?php echo $this->query_model->getCaptchaInputFields('opt_in_form'); ?>
                  <div class="search-box <?php if($multiSchoolOrLocation == 1 && $multiLocation[0]->field_value == 1  && count($form_allLocations) >= 1){ echo "multi-search-box"; } ?>">
				  
				  <?php if($this->query_model->showProgramsListOnFroms() == 1){
					$programsArr =  $this->query_model->programsListOnFromDropdowns(); 
							if(!empty($programsArr)){
						?>
						<!--	<select class="form-control" name="program_id" id="">
								 <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_program'); ?></option>
								 <?php foreach($programsArr as $program): ?>
								 <option  value="<?=$program->id;?>" ><?=$program->program;?> </option>
								 <?php endforeach;?>   
							  </select> -->
					 
					 <?php } }  ?>
					 
				  <?php if($multiSchoolOrLocation == 1){ ?>
					<?php if($multiLocation[0]->field_value == 1  && count($form_allLocations) >= 1){ ?>
					<select class="form-control" name="school_interest" id="school_8">
					   <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_location'); ?></option>
							<?php foreach($form_allLocations as $location): ?>
								<option  value="<?=$location->id;?>" <?php if($mainLocation[0]->id == $location->id){ echo 'selected=selected'; }?>><?=$location->name;?> </option>
							<?php endforeach;?>   
					  </select>
					 <?php } ?>
				  <?php } ?>
				  
				   <input type="text"  name="last_name" class="optinlastname" placeholder="Last Name" value="">

                     <input type="text" class="form-control" id="form_email_8" name="form_email_2" placeholder="<?php echo $this->query_model->getStaticTextTranslation('enter_your_email_address'); ?>">
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
					 
					 
					 <input type="hidden" name="page_url" value="<?php echo isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';  ?>" />
					 
					  <?php if($multiSchoolOrLocation == 0){ ?>
					 <input type="hidden" name="school_interest" value="<?php echo !empty($page_location_id) ? $page_location_id : ''; ?>" />
					  <?php } ?>
					  
					 <input type="hidden" name="miniform" value="true" />
					 <input type="text" id="website" name="website" class="optinwebsite"  placeholder="Website" value="">
<input type="text"  class="ywedobjeo" name="x2o3d_<?php echo $this->query_model->setAndGetUniqueNumberForCustomField(); ?>" value="<?php echo time(); ?>"  placeholder="Serial Number"/>
                     <button class="btn-red contactFormSubmit_8" name="submitEmail" value="submitEmail" type="submit" ><?php echo $gdpr_compliant_submit_btn_text; ?></button>
                  </div>
			  </form>
				   </div>
				   </div>
	 <?php }else{ ?>
	 
<div class="mobile-visible">	 			
<div class="trial-form about-trial-form about-alt-bg">
  <div class="container">
    <div class="row">
			<?php
			/*$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
				$special_offer_data = $this->query_model->getbyTable("$tblspecialoffer");								
				$speical_offer_setting = $special_offer_data[0];*/
			?>
			
            <script>
		$(document).ready(function(){
				
		$('.contactFormSubmit_9').click(function(){
		
					var err = 0
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
					
					/*var telephone=$('#telephone').val();
					<?php if($site_settings[0]->phone_required == 1){ ?>
                                                <?php if($site_settings[0]->international_phone_fields != 1){ ?>
					if(telephone.length <= 9 || telephone.length == 0){
						var err = 1;
						$('#telephone').after('<div class="reds phone_error"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
						
					} 
                                        <?php } } ?> */
										
					var telephoneId = 'telephone_9';
					var phoneError = 'phone_error_9';
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
					/*if($(this).val().length <= 11){
						
						<?php if($site_settings[0]->phone_required == 0){ ?>
							if($(this).val().length == 0){
								$('.phone_error').hide();
							}else{
                                                             <?php if($site_settings[0]->international_phone_fields == 1){ ?>
                                                                $('.phone_error').hide();
                                                            <?php  }else{ ?>
								$('#telephone').after('<div class="reds phone_error"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
                                                            <?php  } ?>
							}
						<?php }else{ ?>
                                                             <?php if($site_settings[0]->international_phone_fields == 1){ ?>
                                                                $('.phone_error').hide();
                                                            <?php  }else{ ?>
								$('#telephone').after('<div class="reds phone_error"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
                                                            <?php  } ?>
						<?php } ?>
						
					} 
					
					if($(this).val().length == 12){
						$('.phone_error').hide();
						
					} */
					
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
      <!-- <div class="col-md-12 text-center">
         <h2><?php  $this->query_model->getStrReplace($site_settings[0]->mini_form_offer_title);?></h2>
          <p> <?php  $this->query_model->getDescReplace($site_settings[0]->mini_form_offer_desc);?></p>
      </div> -->
    </div>
    <div class="row">
      <div class="col-xs-12">
        <form action="<?=base_url().$trial_offer_slug->slug?>"  method="post" class="get_started_form mini_form" >
		  <?php echo $this->query_model->getCaptchaInputFields('opt_in_form'); ?>
            <div class="inline_mid_form " >
              <input type="text" id="first_name_9" name="name" class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('first_name'); ?>" onfocus="this.placeholder = ''"   onBlur="textAlphabatic(this)" maxlength="<?php echo $this->query_model->fullNameInputMaxLength(); ?>" error_class="name_error_9" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?>" >
              <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
           <div class="inline_mid_form optinlastname" >
              <input type="text" name="last_name" id="last_name_9" class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('last_name'); ?>"  onfocus="this.placeholder = ''" onBlur="textAlphabatic(this)" maxlength="25" error_class="last_name_error_9" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?>"  >
              <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
            <div class="inline_mid_form " >
              <input type="email" name="form_email_2" id="form_email_9" class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('email'); ?>" onfocus="this.placeholder = ''" onBlur="this.placeholder = '<?php echo $this->query_model->getStaticTextTranslation('email'); ?>'"  >
              <span class="fa fa-envelope form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
            <div class="inline_mid_form " >
			
			
			<input type="text" name="phone" id="telephone_9" class="contact-form-line <?php echo $getPhoneNumberClass; ?>" placeholder="<?php echo $this->query_model->getStaticTextTranslation('phone'); ?>" onfocus="this.placeholder = ''" error_class="phone_error_9" onBlur="phoneValidation(this)" maxlength="<?php echo $phoneNumberMaxLength; ?>"   >
			
              <span class="fa fa-phone form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
			  
			 <input type="text" id="fax" name="fax" class="optinfax"   placeholder="Fax Number" value="">

			
            <?php if($multiLocation[0]->field_value == 1  && count($form_allLocations) >= 1){ ?>
		    <div class="inline_mid_form " >
              <select class="locationBox contact-form-line form_location_dropdown" name="school_interest" id="school_9" number="2">
               <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_location'); ?></option>
					<?php foreach($form_allLocations as $location): ?>
						<option  value="<?=$location->id;?>" <?php if($mainLocation[0]->id == $location->id){ echo 'selected=selected'; }?>><?=$location->name;?> </option>
					<?php endforeach;?>   
              </select>
              <span class="fa fa-map-marker form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
			 <?php } ?>
			 
				 <?php if($this->query_model->showProgramsListOnFroms() == 1){
					
					$programsArr =  $this->query_model->programsListOnFromDropdowns(); 
						if(!empty($programsArr)){
				?>
				<div class="inline_mid_form " >
				<select class="contact-form-line form_program_dropdown program_dropdown_2" name="program_id" id="">
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
						
						
					  <input type="checkbox" class="form-control" id="gdpr_compliant_9" name="gdpr_compliant_checkbox" value="1"><?php echo $gdpr_compliant_txt2; ?><span><?php echo $gdpr_compliant_txt1; ?></span>
				   </div>
				 <?php } ?>
			   
            <div class="<?php if($multiLocation[0]->field_value == 0){ echo 'inline_mid_form singleLocationFormButton'; }?> started-btn" >
				<input type="hidden" name="miniform" value="true" />
                 <input type="text" id="website" name="website" class="optinwebsite"  placeholder="Website" value="">
<input type="text"  class="ywedobjeo" name="x2o3d_<?php echo $this->query_model->setAndGetUniqueNumberForCustomField(); ?>" value="<?php echo time(); ?>"  placeholder="Serial Number"/>
				<input type="hidden" name="page_url" value="<?php echo isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';  ?>" />
              <input class="mini_formSubmit contactFormSubmit_9  submit <?php if($multiLocation[0]->field_value == 0){ echo 'getStartedMargin'; } else { echo 'getStartedMarginAuto'; } ?>" type="submit" class="" value="<?php echo $this->query_model->getStaticTextTranslation('submit'); ?>" /> 
            </div>
          </form>
      </div>
    </div>
  </div>
</div>
</div>

	 <?php } ?>
      <section class="section" id="about-top" style="background-image:url('<?php echo !empty($aboutHeader) ? 'upload/about_header/'.$aboutHeader[0]->left_photo : ''; ?>')  !important;">
         <span class="overlay" style="<?php echo !empty($aboutHeader) ? 'background:'.$aboutHeader[0]->background_color : ''; ?>"></span>
         <div class="container">
            <div class="row">
               <div class="col-md-12 col-sm-12 text-center">
                  <?php 
					if($site_settings[0]->override_logo == 1){
						if(!empty($aboutHeader) && $aboutHeader[0]->override_logo != 1){
							
						$about_header_logo = $this->query_model->getbySpecific('tbloverride_logos','s_no', $aboutHeader[0]->override_logo);
							if(!empty($about_header_logo)){
							
					?>
					<img src="<?php echo base_url().'upload/override_logos/'.$about_header_logo[0]->logos; ?>" class="about-logo 1" alt="<?php $this->query_model->getStrReplace($about_header_logo[0]->logo_alt); ?>"> 
					<?php 
							} else { ?>
					<img src="<?php echo $site_settings[0]->sitelogo ?>" class="about-logo 2" alt="<?php $this->query_model->getStrReplace($site_settings[0]->logo_alt); ?>">		
					 <?php }
							
						} else{
							
					?>
					<img src="<?php echo $site_settings[0]->sitelogo ?>" class="about-logo 3" alt="<?php $this->query_model->getStrReplace($site_settings[0]->logo_alt); ?>">
					<?php } } else{ ?>
						<img src="<?php echo $site_settings[0]->sitelogo ?>" class="about-logo 4" alt="<?php $this->query_model->getStrReplace($site_settings[0]->logo_alt); ?>">
					<?php } ?>
					<div class="clearboth"></div>
                  <?php if(!empty($aboutHeader)){ $this->query_model->getStrReplace($aboutHeader[0]->title); }?>
                  <div class="clearboth"></div>
				   <?php if(!empty($mainLocation)){ ?>
				   <div class="clearboth"></div>
                  <h3><?= $mainLocation[0]->phone?></h3>          
<div class="clearboth"></div>				  
				  <p><?php if($mainLocation[0]->address != ''){ echo $mainLocation[0]->address.','; } ?>
				<?php if($mainLocation[0]->suite != ''){ echo $mainLocation[0]->suite.','; } ?>
				<?php if($mainLocation[0]->city != ''){ echo $mainLocation[0]->city.','; } ?>
				<?php if($mainLocation[0]->state != ''){ echo $mainLocation[0]->state.' '; } ?>
				<?php if($mainLocation[0]->zip != ''){ echo $mainLocation[0]->zip; } ?></p>
				  <?php } ?>
               </div>
            </div>
         </div>
      </section>
      <header id="stick-nav">
         <div class="container">
            <div class="row">
               <div class="sub-navigation hidden-xs">
			   <?php front_menu(0, 8, '', ''); ?>
                 <!-- <ul>
                     <li><a href="#about-us">About Us</a></li>
                     <li><a href="#facility">Our facility</a></li>
                     <li><a href="#staff"> Instructors </a></li>
                     <li><a href="#instagram-feeds">Photos</a></li>
                     <li><a href="#news">News</a></li>
                     <li><a href="#testi-block">Testimonials</a></li>
                     <li><a href="#direction">Directions</a></li>
                  </ul> -->
               </div>
            </div>
         </div>
      </header>
      <div class="mobile-hidden">
      <section id="about-trial-form" class="trial-form about-trial-form">
         <div class="container">
            <div class="row">
               <div class="col-md-12 text-center">
                  <h2> 
				  <?php if(!empty($aboutEmailOption) && !empty($aboutEmailOption[0]->opt1_text)) {
							$this->query_model->getDescReplace($aboutEmailOption[0]->opt1_text); 
				  }else{
					echo $this->query_model->getStaticTextTranslation('enter_email_view_current_web_specials');  
				  }  ?>
				  </h2>
               </div>
            </div>
         </div>
      </section>
	
	  <?php 
		$emailOnlyForm1 = 1;
		if(!empty($aboutEmailOption) && $aboutEmailOption[0]->show_full_form_1 == 1){
			$emailOnlyForm1 = 0;
		}
	  ?>
	    </div>
	  <?php if($emailOnlyForm1 == 1){ ?>
	    <div class="mobile-hidden">
      <div class="started-block white-bg">
	   <span></span>
				   <script>
				   
		$(document).ready(function(){
			
			
		$('.contactFormSubmit_6').click(function(){
		
					var err = 0
					
					
					var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
					var email=$('#form_email_6').val();
					if(email.length == 0 || emailfilter.test($("#form_email_6").val()) == false){
						var err = 1;
						$('#form_email_6').after('<div class="reds email_error6"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
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
					<?php }*/ ?>

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
						$('.email_error6').hide();
					} else{
						$('#form_email_6').after('<div class="reds email_error6"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
						
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
			<?php } */ ?> 
			
			
		});

	</script>
	<form action="#"  method="post" class="get_started_form mini_form small_mini_form" id="form_6">
	<?php echo $this->query_model->getCaptchaInputFields('opt_in_form'); ?>
                  <div class="search-box <?php if($multiSchoolOrLocation == 1 && $multiLocation[0]->field_value == 1  && count($form_allLocations) >= 1){ echo " multi-search-box"; } ?>">
				  
				   <?php if($this->query_model->showProgramsListOnFroms() == 1){
					$programsArr =  $this->query_model->programsListOnFromDropdowns(); 
							if(!empty($programsArr)){
						?>
							<!--<select class="form-control" name="program_id" id="">
								 <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_program'); ?></option>
								 <?php foreach($programsArr as $program): ?>
								 <option  value="<?=$program->id;?>" ><?=$program->program;?> </option>
								 <?php endforeach;?>   
							  </select>-->
					 
					 <?php } }  ?>
					 
					 
				   <?php if($multiSchoolOrLocation == 1){ ?>
					<?php if($multiLocation[0]->field_value == 1  && count($form_allLocations) >= 1){ ?>
					<select class=" form-control" name="school_interest" id="school_6">
					   <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_location'); ?></option>
							<?php foreach($form_allLocations as $location): ?>
								<option  value="<?=$location->id;?>" <?php if($mainLocation[0]->id == $location->id){ echo 'selected=selected'; }?>><?=$location->name;?> </option>
							<?php endforeach;?>   
					  </select>
					 <?php } ?>
				  <?php } ?>
					
					 <input type="text"  name="last_name" class="optinlastname" placeholder="Last Name" value="">


                     <input type="text" class="form-control" id="form_email_6" name="form_email_2" placeholder="<?php echo $this->query_model->getStaticTextTranslation('enter_your_email_address'); ?>">
					 
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
							
						
						  <input type="checkbox" class="form-control"  id="gdpr_compliant_6"  name="gdpr_compliant_checkbox" value="1"><?php echo $gdpr_compliant_txt2; ?><span><?php echo $gdpr_compliant_txt1; ?></span>
					   </div>
					 <?php } ?>
					   
					 <input type="hidden" name="page_url" value="<?php echo isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';  ?>" />
					 
					  <?php if($multiSchoolOrLocation == 0){ ?>
					 <input type="hidden" name="school_interest" value="<?php echo !empty($page_location_id) ? $page_location_id : ''; ?>" />
					  <?php } ?>
					  
					 <input type="hidden" name="miniform" value="true" />
					  
				<input type="text" id="website" name="website" class="optinwebsite"  placeholder="Website" value="">
				<input type="text"  class="ywedobjeo" name="x2o3d_<?php echo $this->query_model->setAndGetUniqueNumberForCustomField(); ?>" value="<?php echo time(); ?>"  placeholder="Serial Number"/>
                     <button class="btn-red contactFormSubmit_6" name="submitEmail" value="submitEmail" type="submit" ><?php echo $gdpr_compliant_submit_btn_text; ?></button> 
                  </div>
			  </form>
				   </div>
				   </div>
	  <?php } else { ?>
<div class="mobile-hidden">			
<div class="trial-form about-trial-form about-alt-bg">
  <div class="container">
    <div class="row">
			<?php
		/*	$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
				$special_offer_data = $this->query_model->getbyTable("$tblspecialoffer");								
				$speical_offer_setting = $special_offer_data[0];*/
			?>
			
            <script>
		$(document).ready(function(){
				
		$('.contactFormSubmit').click(function(){
		
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
					
					/*var telephone=$('#telephone').val();
					<?php if($site_settings[0]->phone_required == 1){ ?>
                                                <?php if($site_settings[0]->international_phone_fields != 1){ ?>
					if(telephone.length <= 9 || telephone.length == 0){
						var err = 1;
						$('#telephone').after('<div class="reds phone_error"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
						
					} 
                                        <?php } } ?> */
										
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
					/*if($(this).val().length <= 11){
						
						<?php if($site_settings[0]->phone_required == 0){ ?>
							if($(this).val().length == 0){
								$('.phone_error').hide();
							}else{
                                                             <?php if($site_settings[0]->international_phone_fields == 1){ ?>
                                                                $('.phone_error').hide();
                                                            <?php  }else{ ?>
								$('#telephone').after('<div class="reds phone_error"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
                                                            <?php  } ?>
							}
						<?php }else{ ?>
                                                             <?php if($site_settings[0]->international_phone_fields == 1){ ?>
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
      <!-- <div class="col-md-12 text-center">
         <h2><?php  $this->query_model->getStrReplace($site_settings[0]->mini_form_offer_title);?></h2>
          <p> <?php  $this->query_model->getDescReplace($site_settings[0]->mini_form_offer_desc);?></p>
      </div> -->
    </div>
    <div class="row">
      <div class="col-xs-12">
        <form action="<?=base_url().$trial_offer_slug->slug?>"  method="post" class="get_started_form mini_form" >
		  <?php echo $this->query_model->getCaptchaInputFields('opt_in_form'); ?>
            <div class="inline_mid_form " >
              <input type="text" id="first_name" name="name" class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('first_name'); ?>" onfocus="this.placeholder = ''"   onBlur="textAlphabatic(this)" maxlength="<?php echo $this->query_model->fullNameInputMaxLength(); ?>" error_class="name_error" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?>" >
              <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
           <div class="inline_mid_form optinlastname" >
              <input type="text" name="last_name" id="last_name" class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('last_name'); ?>"  onfocus="this.placeholder = ''" onBlur="textAlphabatic(this)" maxlength="25" error_class="last_name_error" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?>"  >
              <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
            <div class="inline_mid_form " >
              <input type="email" name="form_email_2" id="form_email" class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('email'); ?>" onfocus="this.placeholder = ''" onBlur="this.placeholder = '<?php echo $this->query_model->getStaticTextTranslation('email'); ?>'"  >
              <span class="fa fa-envelope form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
            <div class="inline_mid_form " >
			
			
			<input type="text" name="phone" id="telephone" class="contact-form-line <?php echo $getPhoneNumberClass; ?>" placeholder="<?php echo $this->query_model->getStaticTextTranslation('phone'); ?>" onfocus="this.placeholder = ''" error_class="phone_error" onBlur="phoneValidation(this)" maxlength="<?php echo $phoneNumberMaxLength; ?>"   >
			
              <span class="fa fa-phone form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
			
			<input type="text" id="fax" name="fax" class="optinfax"   placeholder="Fax Number" value="">
	
            <?php if($multiLocation[0]->field_value == 1  && count($form_allLocations) >= 1){ ?>
		    <div class="inline_mid_form " >
              <select class="locationBox contact-form-line form_location_dropdown" name="school_interest" id="school" number="3">
               <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_location'); ?></option>
					<?php foreach($form_allLocations as $location): ?>
						<option  value="<?=$location->id;?>" <?php if($mainLocation[0]->id == $location->id){ echo 'selected=selected'; }?>><?=$location->name;?> </option>
					<?php endforeach;?>   
              </select>
              <span class="fa fa-map-marker form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
			 <?php } ?>
			 
			   
			<?php if($this->query_model->showProgramsListOnFroms() == 1){
					
						$programsArr =  $this->query_model->programsListOnFromDropdowns(); 
							if(!empty($programsArr)){
					?>
					<div class="inline_mid_form " >
					<select class="contact-form-line  form_program_dropdown program_dropdown_3" name="program_id" id="">
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
						
					  <input type="checkbox" class="form-control"  id="gdpr_compliant" name="gdpr_compliant_checkbox" value="1"><?php echo $gdpr_compliant_txt2; ?><span><?php echo $gdpr_compliant_txt1; ?></span>
				   </div>
				 <?php } ?>
			   
            <div class="<?php if($multiLocation[0]->field_value == 0){ echo 'inline_mid_form singleLocationFormButton'; }?> started-btn" >
				<input type="hidden" name="miniform" value="true" />
                 <input type="text" id="website" name="website" class="optinwebsite"  placeholder="Website" value="">
				<input type="text"  class="ywedobjeo" name="x2o3d_<?php echo $this->query_model->setAndGetUniqueNumberForCustomField(); ?>" value="<?php echo time(); ?>"  placeholder="Serial Number"/>
				<input type="hidden" name="page_url" value="<?php echo isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';  ?>" />
              <input class="mini_formSubmit contactFormSubmit  submit <?php if($multiLocation[0]->field_value == 0){ echo 'getStartedMargin'; } else { echo 'getStartedMarginAuto'; } ?>" type="submit" class="" value="<?php echo $this->query_model->getStaticTextTranslation('submit'); ?>" />
            </div>
          </form>
      </div>
    </div>
  </div>
</div>
</div>

	  <?php } ?>
     
      <div class="clearfix"></div>
	  
	  <?php if(!empty($aboutUs)){ ?>
	  <section class="ads feature-program clearfix school-owner-about" id="about-us">
         <div class="container" id="">
            <div class="row">
			<?php 
				if(empty($aboutUs[0]->photo)){
					$colClass = 'col-md-12 col-sm-12 text-center';
				}else{
					$colClass = 'col-md-8 ';
				}
			?>
			<?php  if(!empty($aboutUs[0]->photo)){ ?>
               <div class="col-md-4">
                  <div class="relative">
                     <img src="<?php echo base_url().'upload/about_us/'.$aboutUs[0]->photo;?>" class="img-responsive school-owner-a" style="left:40px; top:<?php echo !empty($aboutUs[0]->img_top_spacing) ? $aboutUs[0]->img_top_spacing : 0; ?>px;" alt="<?php $this->query_model->getDescReplace($aboutUs[0]->photo_alt_text) ?>">
                  </div>
               </div>
			<?php } ?>
               <div class="<?php echo $colClass; ?> owner-info">
                  <h3><?= $this->query_model->getDescReplace($aboutUs[0]->title); ?></h3>
                  <h2><?= $this->query_model->getDescReplace($aboutUs[0]->sub_title); ?></h2>
                  <p><?= $this->query_model->getDescReplace($aboutUs[0]->description); ?></p>
                  
               </div>
            </div>
         </div>
      </section>
	  <?php } ?>
	  
	  
	  <?php 
		if(!empty($aboutusRows)){
				foreach($aboutusRows as $aboutus_row){
					if($aboutus_row->photo_side == "right"){
		?>			

			<section id="toggle-block" class="clearfix  <?php echo empty($aboutus_row->background_color) ? 'cyan-bg' : ''; ?>  share-section">
			 
					 <div class="content-box"  style="<?php echo !empty($aboutus_row->background_color) ? 'background:'.$aboutus_row->background_color.' !important' : ''; ?>">
					   <h2><?= $this->query_model->getDescReplace($aboutus_row->title); ?></h2>
								 <p><?= $this->query_model->getDescReplace($aboutus_row->description); ?></p>
								 
								<?php if(!empty($aboutus_row->button_text) && !empty($aboutus_row->button_url)){ ?>
								 <a href="<?php echo $aboutus_row->button_url; ?>" class="btn-theme"><?php echo $aboutus_row->button_text; ?> <i class="fa fa-angle-right"></i></a>
								<?php } ?>
								
						</div>
			  
						  <div class="relative-block">
							<div class="full-bg-toggle-a" style="background-image:url('<?php echo 'upload/about_us/'.$aboutus_row->photo; ?>')  !important;">
							   <!--<span class="cyan-overlay" style="<?php echo !empty($aboutus_row->background_color) ? 'background:'.$aboutus_row->background_color : ''; ?>"></span> -->
							</div>
						</div>
				  </section>		
		
					<?php } else{ ?>
					
					
					  <section id="toggle-block" class="clearfix <?php echo empty($aboutus_row->background_color) ? 'dark-bg' : ''; ?> share-section">
					  
							 <div class="content-box block-right" style="<?php echo !empty($aboutus_row->background_color) ? 'background:'.$aboutus_row->background_color.' !important'  : ''; ?>">
						   
							<h2><?= $this->query_model->getDescReplace($aboutus_row->title); ?></h2>
								 <p><?= $this->query_model->getDescReplace($aboutus_row->description); ?></p>
								 
								<?php if(!empty($aboutus_row->button_text) && !empty($aboutus_row->button_url)){ ?>
								 <a href="<?php echo $aboutus_row->button_url; ?>" class="btn-theme"><?php echo $aboutus_row->button_text; ?> <i class="fa fa-angle-right"></i></a>
								<?php } ?>
							</div>
				  
							<div class="relative-block toggle-b-set">
								<div class="full-bg-toggle-b" style="background-image:url('<?php echo 'upload/about_us/'.$aboutus_row->photo; ?>">
								   <!-- <span class="cyan-overlay" style="<?php echo !empty($aboutus_row->background_color) ? 'background:'.$aboutus_row->background_color : ''; ?>"></span> -->
								</div>
							</div>
						 
					  </section>
					
					<?php } ?>
		
		<?php } } ?>
	  
	  
      <div class="clearfix"></div>
      <!-- feature section -->
	  <?php 
	 
		$videoSection = (!empty($aboutContent) && $aboutContent[0]->video_section == 1) ? 1 : 0 ;
	  ?>
	  <?php if($videoSection == 1){ ?>
      <section class="section" id="facility">

         <div class="container">
            <div class="row">
               <div class="col-md-8 col-md-push-2">
			
			   
					<?php if(!empty($aboutContent) && $aboutContent[0]->image_video == 'video'){  ?>
						 <?php if($aboutContent[0]->video_type == 'youtube_video'){ ?>
								<?php if(!empty($aboutContent[0]->youtube_video)){ ?>
					 <div class="video-inner">
                     <iframe  height="390" src="<?php echo $this->query_model->changeVideoPathHttp($aboutContent[0]->youtube_video); ?>?rel=0&amp;controls=0&amp;showinfo=0&amp;autoplay=0" frameborder="0" allowfullscreen ></iframe>
                     <span class="video-overlay">
                        <div class=""></div>
                     </span>
                  </div>
				  <?php } } else{ ?>
				  <?php if(!empty($aboutContent[0]->vimeo_video)){ ?>
				   <div class="video-inner">
                     <iframe  height="390" src="<?php echo $this->query_model->changeVideoPathHttp($aboutContent[0]->vimeo_video); ?>?rel=0&amp;showinfo=0&amp;autoplay=0" frameborder="0" allowfullscreen ></iframe>
                     <span class="video-overlay">
                        <div class=""></div>
                     </span>
                  </div>
				  <?php } } ?> 
					 <?php } else { ?>
							<?php if(!empty($aboutContent) && !empty($aboutContent[0]->photo)){ ?>
							<img class="img-responsive center-block" src="<?php echo base_url().'upload/about_us/'.$aboutContent[0]->photo; ?>"  alt="<?= $this->query_model->getDescReplace($aboutContent[0]->image_alt); ?>" />
							<?php } ?>
					 
					 <?php } ?>
	 
	  
				<?php if(!empty($aboutContent)){ ?>
                  <div class="video-block text-center">
                     <h2><?= $this->query_model->getStrReplace($aboutContent[0]->title); ?></h2>
                     <p><?= $this->query_model->getDescReplace($aboutContent[0]->sub_title); ?></p>
                  </div>
				  <?php } ?>
				  
               </div>
            </div>
         </div>
      </section>
      <div class="clearfix"></div>
	  <?php } ?>
	  
	  <?php if(!empty($aboutTheAta)){ ?>
      <section class="difference-block" id="difference" style="background-image:url('<?php echo 'upload/about_the_ata/'.$aboutTheAta[0]->left_photo; ?>')  !important;">
         <span class="overlay"  id="about-ata" style="<?php echo !empty($aboutTheAta[0]->background_color) ? 'background:'.$aboutTheAta[0]->background_color : ''; ?>"></span>
         <div class="container">
            <div class="row text-center">
               <div class="col-sm-12 col-md-12">
                  <div class="text-center">
                     <h2><?php $this->query_model->getDescReplace($aboutTheAta[0]->title); ?></h2>
                  </div>   
                  <div class="col-sm-4 col-md-4">
                     <div class="block-box">
                        <p><?php $this->query_model->getDescReplace($aboutTheAta[0]->box_1_text); ?></p>
                        <!-- <img src="images/logo.png"> -->
                     </div>
                  </div>  
                  <div class="col-sm-4 col-md-4">
                     <div class="block-box">
                        <p><?php $this->query_model->getDescReplace($aboutTheAta[0]->box_2_text); ?></p>
                     </div>
                  </div>  
                  <div class="col-sm-4 col-md-4">
                     <div class="block-box">
                        <p><?php $this->query_model->getDescReplace($aboutTheAta[0]->box_3_text); ?></b></p>
                     </div>
                  </div>   
               </div>
            </div>
         </div>
      </section>
      <section class="features-list-about">
		<h2><?php $this->query_model->getDescReplace($aboutTheAta[0]->full_box_title); ?></h2>
         <div class="row">
            <div class="col-md-4 col-sm-4">
               <div class="block-a">
                  <h3><?php $this->query_model->getDescReplace($aboutTheAta[0]->full_box_1_text); ?></h3>
               </div>
            </div>
            <div class="col-md-4 col-sm-4">
               <div class="block-b">
                  <h3><?php $this->query_model->getDescReplace($aboutTheAta[0]->full_box_2_text); ?></h3>
               </div>
            </div>
            <div class="col-md-4 col-sm-4">
               <div class="block-c">
                  <h3><?php $this->query_model->getDescReplace($aboutTheAta[0]->full_box_3_text); ?></h3>
               </div>
            </div>
         </div>
      </section>
	  
     <section class="web-special">
         <div class="container">
            <div class="row">
               <div class="col-md-12 col-sm-12">
                  <div class="text-center">
                     <?php $this->query_model->getDescReplace($aboutTheAta[0]->description); ?>
                     <div class="ata-timeline-block">
					
					<?php if(!empty($aboutTheAta) && $aboutTheAta[0]->show_timeline == 1){ ?>
                     <h2 class="timeline-heading"><?php 
					 if(!empty($aboutTheAta[0]->timeline_title)){
						$this->query_model->getDescReplace($aboutTheAta[0]->timeline_title);
					 }else{
						 echo 'ATA History';
					 }
						?></h2>
                     <p>
						<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
						<div id="example2.1" style="height: 100px;"></div>
						  
						<script type="text/javascript">
						  google.charts.load("current", {packages:["timeline"]});
						  google.charts.setOnLoadCallback(drawChart);
						  function drawChart() {
						    var container = document.getElementById('example2.1');
						    var chart = new google.visualization.Timeline(container);
						    var dataTable = new google.visualization.DataTable();

						    dataTable.addColumn({ type: 'string', id: 'Term' });
						    dataTable.addColumn({ type: 'string', id: 'Name' });
						   dataTable.addColumn({ type: 'string', role: 'tooltip' });
						    dataTable.addColumn({ type: 'date', id: 'Start' });
						    dataTable.addColumn({ type: 'date', id: 'End' });

						    dataTable.addRows([
						      [ 'ATA History', 'Grand Master Haeng Ung Lee earns 1st degree black belt in Korea', 'Grand Master Haeng Ung Lee earns 1st degree black belt in Korea', new Date(1954, 1, 1), new Date(1962, 1, 1) ],
						      [ 'ATA History', 'Grand Master Lee arrives in the US and starts teaching Taekwondo', 'Grand Master Lee arrives in the US and starts teaching Taekwondo', new Date(1962, 1, 1), new Date(1969, 1, 1) ],
						      [ 'ATA History', 'ATA Is founded in Omaha, NE', 'ATA Is founded in Omaha, NE', new Date(1969, 1, 1), new Date(1983, 1, 1) ],
						      [ 'ATA History', 'Grand Master Lee creates and introduces the Songahm Taekwondo curriculum', 'Grand Master Lee creates and introduces the Songahm Taekwondo Curriculum', new Date(1983, 1, 1), new Date(1986, 1, 1) ],
						      [ 'ATA History', 'ATA initiates the Karate for Kids program', 'ATA initiates the Karate for Kids program', new Date(1986, 1, 1), new Date(2006, 1, 1) ],
						      [ 'ATA History', 'ATA records a major milestone, with over 1 million students taught', 'ATA records a major milestone, with over 1 million students taught',  new Date(2006, 1, 1),  new Date(2017, 1, 1) ]]);

						     
						   var options = {
						     colors: ['#de0404', '#3395a1', '#304076','#de0404', '#3395a1', '#304076'],
						    };
						   
						   chart.draw(dataTable, options);
						  }
						</script></p>
					<?php } ?>
						</div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      
	  <?php } ?>

	  
	  <section class="trial-form trial-form-about-footer" id="register">
         <div class="container">
            <div class="row">
               <div class="col-md-12 text-center">
           		  <h2><?php 
				  if(!empty($aboutEmailOption)){
					 $this->query_model->getDescReplace($aboutEmailOption[0]->opt_2_title); 
				  }else{
					 echo $this->query_model->getStaticTextTranslation('imagine_yourself'); 
				  }
				    ?><?php //echo $this->query_model->getStaticTextTranslation('imagine_yourself'); ?></h2>
                  <p><?php 
				  if(!empty($aboutEmailOption)){
					$this->query_model->getDescReplace($aboutEmailOption[0]->opt_2_text);
				  }else{
					  echo $this->query_model->getStaticTextTranslation('price_with_no_commitments');
				  }
				  ?><?php //echo $this->query_model->getStaticTextTranslation('price_with_no_commitments'); ?></p>
                  <h3 class="head-one"><?php if(!empty($aboutEmailOption) && $aboutEmailOption[0]->show_email_opt_form == 1){ ?> 1: <?php } ?>
				  <?php echo $this->query_model->getStaticTextTranslation('choose_program_of_interest'); ?> <?php if(!empty($aboutEmailOption) && $aboutEmailOption[0]->show_email_opt_form == 0){ ?> : <?php } ?></h3>
                 
                  <div class="select-program">
				  
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
				//$('.selectedTrial'+offer_id).html('Selected');
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
				
				/*$.each($('.selectedOffer'), function(){
					$(this).html("Select");
				}); */
				
				var offer_id = $(this).attr('id');
				var cat_slug = $(this).attr('cat_slug');
				
				$('#check'+offer_id).addClass('activeTrial');
				$('#checkbox_'+offer_id).prop( "checked", true );
				//$('.selectedTrial'+offer_id).html('Selected');
				$('.trialErrorMessage').html('');
				$('.trial_cat_id').val(offer_id);
				//$('.trial_cat_id_full_form').val(offer_id);
				
				//$('.mini_trial_offer_form').attr('action','<?php echo base_url().$trial_offer_slug->slug.'/' ?>'+cat_slug);
				//$('.full_trial_offer_form').attr('action','<?php echo base_url().$trial_offer_slug->slug.'/' ?>'+cat_slug);
				
			});
		
		
		
	  });
	  </script>
	 
			<?php 
				$i = 0;
				foreach($trial_categories as $trial_cat){
					
					if($i % 2 == 0){
						$block_class = 'left-block';
						$box_class = ' left-g';
					}else{
						$block_class = 'right-block';
						$box_class = ' right-g';
					}
					
			?>	  
                
				  <div  id="<?=$trial_cat->id; ?>" cat_slug="<?=$trial_cat->slug; ?>"  class="check-select trialButton">
				  <?php if(!empty($aboutEmailOption) && $aboutEmailOption[0]->show_email_opt_form == 1){ ?> 
                     <a  id="check<?=$trial_cat->id; ?>"  href="javascript:void(0)" class="check-left ">
                   <div class="control-group -g">
					
                         <label class="control control-checkbox">
                            <span class="selectedOffer selectedTrial<?=$trial_cat->id; ?>">  <?php $this->query_model->getDescReplace($trial_cat->name); ?></span>
                                 <input id="checkbox_<?=$trial_cat->id; ?>"   trial_cat_id="<?=$trial_cat->id; ?>"   type="checkbox"  class="trial_offer_checkbox" />
                             <div class="control_indicator"></div>
                         </label>
                        
                     </div>
                     </a>
				  <?php } else{?>
					
						<a  id="check<?=$trial_cat->id; ?>"  href="javascript:void(0)" class="check-left trial_offer_button" url="<?php echo base_url().$trial_offer_slug->slug.'/'.$trial_cat->slug; ?>">
						
							<div class="control-group g">
								<label class="control ">
									<?php $this->query_model->getDescReplace($trial_cat->name); ?>
								</label>
							</div>
						</a>
					
				  <?php } ?>
                  </div>
				<?php } ?>
				<div class="clearfix"></div>
				<?php if(!empty($aboutEmailOption) && $aboutEmailOption[0]->show_email_opt_form == 1){ ?> 
                  <h3>2: <?php echo $this->query_model->getStaticTextTranslation('redeem_trial_offer'); ?></h3>
				<?php } ?>
				
				<form id="trial_offer_link_form" method="post" action="<?php echo base_url().'site/set_location_id_form'; ?>"  style="display:none">
					<input type="hidden" name="school_interest" value="<?php echo $location_id; ?>">
					<input type="hidden" name="redirect_url" class="redirect_url" value="">
				</form>
				<p class="trialErrorMessage"></p>
				  
				  <!-- <div  id="2" class="check-select trialButton">
                     <a href="javascript:void(0)" class="check-left ">
                   <div class="control-group -g">
                         <label class="control control-checkbox">
                            <span class="selectedOffer selectedTrial2"> Adult Programs</span>
                                 <input id="checkbox_2" type="checkbox"  class="trial_offer_checkbox" />
                             <div class="control_indicator"></div>
                         </label>
                        
                     </div>
                     </a>
                  </div> -->
                  
                  </div>
               </div>
            
    
	
	
	  <?php 
		$emailOnlyForm2 = 1;
		//echo '<pre>aboutEmailOption'; print_R($aboutEmailOption); die;
		if(!empty($aboutEmailOption) && $aboutEmailOption[0]->show_full_form_2 == 1){
			$emailOnlyForm2 = 0;
		}
	  ?>
	  <?php if($emailOnlyForm2 == 1){ ?>
	  <?php if(!empty($aboutEmailOption) && $aboutEmailOption[0]->show_email_opt_form == 1){ ?> 
				  <?php //if($multiSchoolOrLocation == 1){ ?>
					<?php //if($multiLocation[0]->field_value == 1  && count($form_allLocations) >= 1){ ?>
	  <div class="selectboxdesign started-block white-bg green-color <?php if($this->query_model->get_gdpr_compliant() == 1){?>gdpr_enabled<?php } ?>">
	   <span></span>
	   
	   <?php if(!empty($aboutEmailOption) && $aboutEmailOption[0]->show_email_opt_form == 1){ ?>
				   <script>
				   
		$(document).ready(function(){
			
			
		$('.contactFormSubmit_7').click(function(){
		
					var err = 0
					var trial_id = $('.trial_cat_id').val();
					if(trial_id == 0){
						$('.trialErrorMessage').html('<h3><?php echo $this->query_model->getStaticTextTranslation('choose_trial_offer_category'); ?></h3>');
						return false;
					}
					
					var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
					var email=$('#form_email_7').val();
					if(email.length == 0 || emailfilter.test($("#form_email_7").val()) == false){
						var err = 1;
						$('#form_email_7').after('<div class="reds email_error7"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
					}
					
					<?php if($multiSchoolOrLocation == 1 ){ ?>
					var school=$('#school_7').val();
					if(school == '' || school == null){
						var err = 1;
						$('#school_7').after('<div class="reds school_name_error7"><?php echo $this->query_model->getStaticTextTranslation('select_your_location'); ?></div>');
					}
					<?php } ?>
					
					<?php /*if($this->query_model->get_gdpr_compliant() == 1){?>
						var gdpr_compliant_id= 'gdpr_compliant_7';
						var gdpr_compliant_error= 'gdpr_compliant_error7';
						if($('#'+gdpr_compliant_id).is(":checked")){
							$('.'+gdpr_compliant_error).hide();
						}else{
							var err = 1;
							$('#'+gdpr_compliant_id).after('<div class="reds '+gdpr_compliant_error+'"><?php echo $this->query_model->getStaticTextTranslation('receiving_information'); ?></div>');
						}
					<?php }*/ ?>

					
					if(err == 0){
						$("#form_7").attr('action','<?=base_url()?>starttrial/saveLeadsByEmails');
						return true;
					} else{
						$("#form_7").attr('action','#');
						return false;
					}
			
			});
			
			
			$('#form_email_7').keyup(function(){
					var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
					var email=$('#form_email_7').val();
					if($(this).val().length > 0 || emailfilter.test($("#form_email_7").val()) == false){
						$('.email_error7').hide();
					} else{
						$('#form_email_7').after('<div class="reds email_error7"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
						
					}
			});
			
			<?php if($multiSchoolOrLocation == 1 ){ ?>
            	$('#school_7').change(function(){
            			if($(this).val() != ''){
            				$('.school_name_error7').hide();
            			} else{
            				$('.school_name_error7').show();
            				$('#school_7').after('<div class="reds school_name_error7"><?php echo $this->query_model->getStaticTextTranslation('select_your_location'); ?></div>');
            				
            			}
            	});
            	<?php } ?>
				
			<?php /*if($this->query_model->get_gdpr_compliant() == 1){?>
				var gdpr_compliant_id= 'gdpr_compliant_7';
				var gdpr_compliant_error= 'gdpr_compliant_error7';
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
	<?php }else{?>
	 <script>
				   
		$(document).ready(function(){
			$('.contactFormSubmit_7').click(function(){
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
		if(!empty($aboutEmailOption) && $aboutEmailOption[0]->show_email_opt_form == 0){
			$form_action_url = base_url()."starttrial/redirectEmailOptinForm";
			$goBtnClass = "only-go-button";
		}
	?>
	<form action="<?php echo $form_action_url; ?>"  method="post" class="get_started_form mini_form mini_trial_offer_form small_mini_form" id="form_7">
	<?php echo $this->query_model->getCaptchaInputFields('opt_in_form'); ?>
                  <div class="search-box <?php if($multiSchoolOrLocation == 1 && $multiLocation[0]->field_value == 1  && count($form_allLocations) >= 1){ echo " multi-search-box"; } ?>">
				  
				   <?php if($this->query_model->showProgramsListOnFroms() == 1){
					$programsArr =  $this->query_model->programsListOnFromDropdowns(); 
							if(!empty($programsArr)){
						?>
							<!-- <select class="form-control" name="program_id" id="">
								 <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_program'); ?></option>
								 <?php foreach($programsArr as $program): ?>
								 <option  value="<?=$program->id;?>" ><?=$program->program;?> </option>
								 <?php endforeach;?>   
							  </select> -->
					 
					 <?php } }  ?>
					 
				<?php if(!empty($aboutEmailOption) && $aboutEmailOption[0]->show_email_opt_form == 1){ ?> 
				  <?php if($multiSchoolOrLocation == 1){ ?>
					<?php if($multiLocation[0]->field_value == 1  && count($form_allLocations) >= 1){ ?>
					<select class=" form-control" name="school_interest" id="school_7">
					   <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_location'); ?></option>
							<?php foreach($form_allLocations as $location): ?>
								<option  value="<?=$location->id;?>" <?php if($mainLocation[0]->id == $location->id){ echo 'selected=selected'; }?>><?=$location->name;?> </option>
							<?php endforeach;?>   
					  </select>
					 <?php } ?>
				  <?php } ?>
					 <input type="text"  name="last_name" class="optinlastname" placeholder="Last Name" value="">

                     <input type="text" class="form-control" id="form_email_7" name="form_email_2" placeholder="<?php echo $this->query_model->getStaticTextTranslation('enter_your_email_address'); ?>">
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
							
							
						  <input type="checkbox" class="form-control" id="gdpr_compliant_7" name="gdpr_compliant_checkbox" value="1"><?php echo $gdpr_compliant_txt2; ?><br/><span><?php echo $gdpr_compliant_txt1; ?></span>
					   </div>
					 <?php } ?>
					 
				    <input type="hidden" name="page_url" value="<?php echo isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';  ?>" />
					 <input type="hidden" name="miniform" value="true" />
					
					<?php if($multiSchoolOrLocation == 0){ ?>
					 <input type="hidden" name="school_interest" value="<?php echo !empty($page_location_id) ? $page_location_id : ''; ?>" />
					 <?php } ?>
					 
					 <input type="hidden" name="redirection_type" value="trial_offer" />
					 <input type="hidden" class="trial_cat_id" name="trial_offer_id" value="0" />
					 <input name="send_trial_cat_tag_ac" value="1" type="hidden">
					 <input type="text" id="website" name="website" class="optinwebsite"  placeholder="Website" value="">
					<input type="text"  class="ywedobjeo" name="x2o3d_<?php echo $this->query_model->setAndGetUniqueNumberForCustomField(); ?>" value="<?php echo time(); ?>"  placeholder="Serial Number"/>
					 <button class="btn-red contactFormSubmit_7 <?php echo $goBtnClass; ?>" name="submitEmail" value="submitEmail" type="submit" ><?php echo $gdpr_compliant_submit_btn_text; ?></button>
				<?php } ?>
					
					 
                  </div>
			  </form>
				   </div>

				  
		  <?php //} ?>
		  <?php //} ?>
		  <?php } ?>
      </div>
      </div>
	  <?php } else{ ?>
		
		
<div class="trial-form about-trial-form about-bg">
  <div class="container">
    <!-- <div class="row">
      <div class="col-md-12 text-center">
        <h2><?php  $this->query_model->getStrReplace($site_settings[0]->mini_form_offer_title);?></h2>
          <p> <?php  $this->query_model->getDescReplace($site_settings[0]->mini_form_offer_desc);?></p>
      </div>
    </div> -->
    <div class="row">
      <div class="col-xs-12">
	 		 <?php
			/* $tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
				$special_offer_data = $this->query_model->getbyTable("$tblspecialoffer");								
				$speical_offer_setting = $special_offer_data[0];*/
			?>
			
            <script>
		$(document).ready(function(){
			
			
		$('.contactFormSubmit1').click(function(){
		
					var err = 0
					var trial_id = $('.trial_cat_id').val();
					if(trial_id == 0){
						$('.trialErrorMessage').html('<h3><?php echo $this->query_model->getStaticTextTranslation('choose_trial_offer_category'); ?></h3>');
						return false;
					}
					
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
					<?php if($site_settings[0]->phone_required == 1){ ?>
                                                 <?php if($site_settings[0]->international_phone_fields != 1){ ?>
					if(telephone.length <= 11 || telephone.length == 0){
						var err = 1;
						$('#telephone1').after('<div class="reds phone_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
						
					}
                                        <?php } } ?>  */
										
										
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
					
					
					<?php if($multiLocation[0]->field_value == 1 ){ ?>
					var school=$('#school1').val();
					if(school == '' || school == null){
						var err = 1;
						$('#school1').after('<div class="reds school_name_error1"><?php echo $this->query_model->getStaticTextTranslation('select_your_location'); ?></div>');
					}
					<?php } ?>
					
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
						
					}*/
					
				$('.phone_error1').hide();
			});
			
			
			$('#form_email1').keyup(function(){
					var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
					var email=$('#form_email1').val();
					if($(this).val().length > 0 || emailfilter.test($("#form_email1").val()) == false){
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
         <form action="<?=base_url().$trial_offer_slug->slug?>"  method="post" class="get_started_form mini_form_2">
		 <?php echo $this->query_model->getCaptchaInputFields('opt_in_form'); ?>
          <div class="inline_mid_form " >
              <input type="text" id="first_name1" name="name" class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('first_name'); ?>"
                            onfocus="this.placeholder = ''"   onBlur="textAlphabatic(this)" maxlength="<?php echo $this->query_model->fullNameInputMaxLength(); ?>" error_class="name_error1" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?>" >
              <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
           <div class="inline_mid_form optinlastname" >
              <input type="text" name="last_name" id="last_name1" class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('last_name'); ?>"
                            onfocus="this.placeholder = ''" onBlur="textAlphabatic(this)" maxlength="25" error_class="last_name_error1" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?>"
                            >
              <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
            <div class="inline_mid_form " >
              <input type="text" name="form_email_2" id="form_email1" class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('email'); ?>"
                            onfocus="this.placeholder = ''" onBlur="this.placeholder = '<?php echo $this->query_model->getStaticTextTranslation('email'); ?>'"  
                            >
              <span class="fa fa-envelope form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
            <div class="inline_mid_form " >
			
			
			<input type="text" name="phone" id="telephone1" class="contact-form-line  <?php echo $getPhoneNumberClass; ?>" placeholder="<?php echo $this->query_model->getStaticTextTranslation('phone'); ?>"
                            onfocus="this.placeholder = ''"  error_class="phone_error1" onBlur="phoneValidation(this)" maxlength="<?php echo $phoneNumberMaxLength; ?>" 
                            >
			
              <span class="fa fa-phone form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
			  
			 <input type="text" id="fax" name="fax" class="optinfax"   placeholder="Fax Number" value="">

				
            <?php if($multiLocation[0]->field_value == 1  && count($form_allLocations) >= 1){ ?>
		    <div class="inline_mid_form " >
              <select class="locationBox contact-form-line form_location_dropdown" name="school_interest" id="school1" number="4">
               <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_location'); ?></option>
					<?php foreach($form_allLocations as $location): ?>
						<option  value="<?=$location->id;?>" <?php if($selectedLocaiton == $location->id){ echo 'selected=selected'; } ?>><?=$location->name;?> </option>
					<?php endforeach;?>   
              </select>
              <span class="fa fa-map-marker form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
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
					
					
				  <input type="checkbox" class="form-control" id="gdpr_compliant_1" name="gdpr_compliant_checkbox" value="1"><?php echo $gdpr_compliant_txt2; ?><span><?php echo $gdpr_compliant_txt1; ?></span>
			   </div>
			 <?php } ?>
			   
            <div class="<?php if($multiLocation[0]->field_value == 0){ echo 'inline_mid_form singleLocationFormButton'; }?> started-btn" >
				<input type="hidden" name="miniform" value="true" />
                <input type="text" id="website" name="website" class="optinwebsite"  placeholder="Website" value="">
<input type="text"  class="ywedobjeo" name="x2o3d_<?php echo $this->query_model->setAndGetUniqueNumberForCustomField(); ?>" value="<?php echo time(); ?>"  placeholder="Serial Number"/>
				<input type="hidden" name="page_url" value="<?php echo isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';  ?>" />
				  <input type="hidden" name="redirection_type" value="trial_offer" />
				<input type="hidden" class="trial_cat_id" name="trial_offer_id" value="0" />
				<input name="send_trial_cat_tag_ac" value="1" type="hidden">
              <input class="mini_formSubmit contactFormSubmit1 submit <?php if($multiLocation[0]->field_value == 0){ echo 'getStartedMargin'; } else { echo 'getStartedMarginAuto'; } ?>" type="submit" class="" value="<?php echo $gdpr_compliant_submit_btn_text; ?>" />
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

	  
	  <?php } ?>
	  </section>
	  
	  <?php if(!empty($ourStaffs)){ ?>
      <section id="staff">
         <div class="container">
            <div class="row">
               <div class="col-sm-12 col-md-12">
                  <div class="staff-block">
                     <ul>
					 <?php foreach($ourStaffs as $staff){ ?>
                        <li>
					 <?php  if($staff->not_linked == 1){ ?>
                       <?php if($staff->lightbox_or_url == 'url'){ ?>
					   <a href="<?php echo $staff->url ?>" target="<?php echo $staff->target; ?>">
					   <?php }else{ ?>
						<a class="staffInfoPopUp" href="javascript:void(0)" number="<?= $staff->id?>"  data-toggle="modal" data-target=".staff-popup">
						
					   <?php } ?>
                           <img  src="<?php base_url(); ?>upload/staff/thumb/<?= $staff->photo; ?>" alt="<?= $this->query_model->getStrReplace($staff->photo_alt_text); ?>">
					 		<div class="staff-hover">
					 			<button class="btn btn-theme btn-bio"><?php echo $this->query_model->getStaticTextTranslation('read_bio'); ?></button>
					 			
					 		</div>
                        </a>
					 <?php }else{ ?>
							<img  src="<?php base_url(); ?>upload/staff/thumb/<?= $staff->photo; ?>" alt="<?= $this->query_model->getStrReplace($staff->photo_alt_text); ?>">
					 <?php } ?>
                          <h3><?= $this->query_model->getStrReplace($staff->name); ?></h3>
                          <h4><?= $this->query_model->getStrReplace($staff->position); ?></h4>
                          <p><?= $this->query_model->getStrReplace($staff->belt); ?></p> 
						  
						</li>
					 <?php } ?>
						</ul>
                  </div>
               </div>
            </div>
         </div>
      </section>
	  
	  <?php } ?>
	  
	  
<?php 
$apiKeys =$this->query_model->getbySpecific('tblapikey','location_id', $location_id);
if(!empty($apiKeys)){
		$apiKeys = $apiKeys[0];
	} else{
		$apiKeys = '';
	}
if(!empty($apiKeys->instragram_user_id) && !empty($apiKeys->instragram_access_token)){ 

 $instragram_images = $this->query_model->userMedia($apiKeys->instragram_user_id, $apiKeys->instragram_access_token); 

?>
      <section id="instagram-feeds">
	  <style>
			.instragramImages{ float:left;}
		</style>
	  <script>
				$(window).load(function(){
					$('.ShowMoreIntImg').hide();
					$('.countIntImages').val(10)
				});
				
				$(document).ready(function(){
					$('.showMoreInstragram').click(function(){
						//$('.ShowMoreIntImg').show();
						var countImages = $('.countIntImages').val();
						var showImages = parseInt(countImages) + Number(5);
						$('.countIntImages').val(showImages);
						$.each( $( ".instragramImages" ), function() {
							 var number = $(this).attr('number');
							
							 if(number > 10 && number <= showImages){
							 	$(this).css('display', 'inline-block');
								
							 }
						});
					});
					
				});
			</script>
			<input type="hidden" class="countIntImages" value="10"  />
		
         <div class="feed-list">
            <ul>
			
			 <?php
				$ins_media = $instragram_images; 
				if(isset($ins_media['data'])){
				$i = 1; 
				foreach ($ins_media['data'] as $vm): 
				$ShowMoreIntImg = '';
					if($i > 10){
						$ShowMoreIntImg = 'ShowMoreIntImg';
					}
					
					//$img = $vm['images']['thumbnail']['url'];
					$img = $vm['images']['standard_resolution']['url'];
					$img = str_replace('s150x150','s320x320',$img);
					$main_img = $vm['images']['standard_resolution']['url'];
					$link = $vm["link"];
				?>
               <li class="<?php echo $ShowMoreIntImg; ?> instragramImages"  number="<?php echo $i; ?>">
                  <a href="javascript:void(0)">
                     <img src="<?php echo $img; ?>"  class="intImage">
                     <span class="overlay"></span>
                  </a>
				  
				  
				 <div class="insta-caption" >
					<div class="review-detail manage_lightboxthumb">
					   <a href="<?php echo $main_img; ?>" class="fancybox"  data-fancybox-group="gallery" title="<?php echo $this->query_model->getStaticTextTranslation('likes'); ?>: <?php echo $vm['likes']['count']; ?> &nbsp; <?php echo $this->query_model->getStaticTextTranslation('comments'); ?>: <?php echo $vm['comments']['count']; ?>"> 
					  <p><span>
					 
					  <i class="fa fa-heart"></i> <?php echo $this->query_model->getStaticTextTranslation('likes'); ?>:<?php echo $vm['likes']['count']; ?></span> <span><i class="fa fa-comment"></i> <?php echo $this->query_model->getStaticTextTranslation('comments'); ?>: <?php echo $vm['comments']['count']; ?></span> </p>
					</a>
					</div>
				  </div> 
               </li>
                <?php $i++; endforeach; ?>
            </ul>
			<?php } ?>
         </div>
		 <div class="clearfix"></div>
         <div class="action-btn-block">
		 <?php if(isset($ins_media['data']) && count($ins_media['data']) > 5){ ?>
        	<a href="javascript:void(0);" class="load-more showMoreInstragram"><?php echo $this->query_model->getStaticTextTranslation('load_more'); ?></a> 
		<?php } ?>
		<?php if(isset($ins_media['data'])) { ?>
            <a href="#" class="follow-btn"><i class="fa fa-instagram"></i> <?php echo $this->query_model->getStaticTextTranslation('follow'); ?> </a>
		<?php } ?>
         </div>

      </section>
<?php } ?>

     <!-- <section id="fb-feed">
         <div class="container-fluid">
            <div class="row text-center">
               <div class="col-md-12">
                  <h2>Facebook feed here</h2>
               </div>
            </div>
         </div>
      </section> -->
	  
	  <?php 
	$apiKeys =$this->query_model->getbySpecific('tblapikey','location_id', $location_id);
	
	if(!empty($apiKeys)){
		$apiKeys = $apiKeys[0];
	} else{
		$apiKeys = '';
	}
	
	//echo '<pre>'; print_r($apiKeys); die;
	$blank = 0;
	
	
	if(empty($apiKeys->twitter_user_name) || empty($apiKeys->twitter_consumer_key) || empty($apiKeys->twitter_consumer_secret) || empty($apiKeys->twitter_access_token) || empty($apiKeys->twitter_access_token_secret)){
		$blank += 1;
	}
	
	if(empty($apiKeys->facebook_user_id) || empty($apiKeys->facebook_access_token)){
		$blank += 1;
	}
	
	if(empty($apiKeys->google_plus_id) || empty($apiKeys->google_plus_api_key)){ 
		$blank += 1;
	} 
	
	
	if(empty($apiKeys->youtube_channel_id) || empty($apiKeys->youtube_api_key)){
		$blank += 1;
	}
	
	
?>
<?php if($blank < 4){ ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/2.2.2/isotope.pkgd.js"></script>
<section id="news" class="socialNewsData">

    	<div id="loader" style="margin-left: 45%"><img src="images/ajax_loader.gif" /></div> 

</section>
<?php } ?>

       <div class="clearfix"></div>
	   
	    <?php if(!empty($myTestimonials)){ ?>
  
  <section class="testimonial" id="testi-block"  style="background-image:url('<?php echo !empty($site_settings[0]->testimonial_background)?$site_settings[0]->testimonial_background:'';?>')">
         <span class="overlay"></span>
         <div class="container">
            <div class="container content">
               <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                  <!-- Indicators --> 
                  <ol class="carousel-indicators testimonial-indicator">
				   <?php 
					  $m = 0;
					$totalTestimonials = count($myTestimonials);
					if($totalTestimonials > 1):
					  foreach($myTestimonials as $testimonial):
					  
				  ?>
                     <li data-target="#carousel-example-generic" data-slide-to="<?= $m ?>" class="<?php if($m == 0){ echo 'active'; } ?>"></li>
                   <?php     $m++;
						endforeach;
					endif;
				  ?>  
                  </ol>
				  
				 
					  
                  <!-- Wrapper for slides --> 
                  <div class="carousel-inner">
				  <?php if(!empty($myTestimonials)): ?>
				  <?php 
				$n = 1;
				foreach($myTestimonials as $testimonial):
				?>
                     <div class="item  <?php if($n == 1){ echo 'active'; } ?>">
                        <div class="row">
                           <div class="col-xs-12">
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
                                          <div class="desc">
										  <?php //$content = preg_replace('#\<p>[{\w},\s\d"]+\</p>#', "", $testimonial->content); ?> 
										  <?= 
										    $this->query_model->getStrReplace(strip_tags(html_entity_decode($testimonial->content))); 
										  ?></div>
                                          <p class="f-name"><?= $this->query_model->getStrReplace($testimonial->name); ?></p>
                                          <p class="accent-txt d-txt"><?= $this->query_model->getStrReplace($testimonial->title); ?></p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
					 <?php 
				$n++; 
				endforeach; ?>
            <?php endif; ?>
					 
					 </div>
                  <!-- Controls -->  
               </div>
            </div>
         </div>
      </section>
     
  
  <?php } ?>
	 
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
	  
<section class="map-main" id="direction">
  <div id="location-map">
    <div id="map_div5"></div>
  </div>
  
  <!-- form -->
 <!-- <section class="mobile-contact">
    <div class="container">
      <div class="row">
        <div class="col-sm-12 text-center"> <span class="no  title-p"><?= $mainLocation[0]->name; ?></span>
        <div class="row">
           <?php if($site_settings[0]->hide_window != 'hide'): ?>
            <div class="col-xs-6 row-btn"> 
			<a class="btn btn-theme"  href="<?php echo $this->query_model->getTrialOfferUrl($site_settings[0]->url_call_to_action); ?>" target="<?php if($site_settings[0]->window == 'new'): echo '_blank'; endif; ?>"> 
			<?php $this->query_model->getStrReplace($site_settings[0]->call_to_action); ?></a> 
			</div>
			<?php endif; ?>
			<div class="col-xs-6 row-btn"> 
		  <?php if($multiLocation[0]->field_value == 1 ){ ?>
				<a class="btn btn-theme" href="javascript:void(0);"  target="_blank"> <i class="fa fa-map-marker"> </i><?php echo ' '.count($allLocations).' '.$this->query_model->getStaticTextTranslation('locations'); ?></a>
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
					
					/* var telephone=$('#telephone2').val();
					<?php if($site_settings[0]->phone_required == 1){ ?>
                                                <?php if($site_settings[0]->international_phone_fields != 1){ ?>
					if(telephone.length <= 11 || telephone.length == 0){
						var err = 1;
						$('#telephone2').after('<div class="reds phone_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
						
					} 
                                        <?php } } ?> */
										
					var telephoneId = 'telephone2';
					var phoneError = 'phone_error2';
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
						
						<?php if($site_settings[0]->phone_required == 0){ ?>
							if($(this).val().length == 0){
								$('.phone_error2').hide();
							}else{
                                                            <?php if($site_settings[0]->international_phone_fields == 1){ ?>
                                                                $('.phone_error2').hide();
                                                            <?php  }else{ ?>
								$('#telephone2').after('<div class="reds phone_error2"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
                                                             <?php  } ?>
							}
						<?php }else{ ?>
                                                            <?php if($site_settings[0]->international_phone_fields == 1){ ?>
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
    <form class="d-bg-c contact-form content_contact_form" action="contactus/send" method="post" >
	<?php echo $this->query_model->getCaptchaInputFields('contact_us_form'); ?>
	 <input type="hidden" name="hid_location" value="<?= !empty($contactDetail) ? $contactDetail->id : '' ?>" />
	  <div class="message">
				<div id="alert"></div>
	  </div>
        <div style="position:relative;">
          <input type="text" name="name" id="first_name2"  class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('first_name'); ?>" onFocus="this.placeholder = ''"   onBlur="textAlphabatic(this)" maxlength="<?php echo $this->query_model->fullNameInputMaxLength(); ?>" error_class="name_error2" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?>" >
          <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
          <div style="position:relative;" class="optinlastname">
          <input type="text" name="last_name" id="last_name2" class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('last_name'); ?>" onFocus="this.placeholder = ''"  onBlur="textAlphabatic(this)" maxlength="25" error_class="last_name_error2" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?>" >
          <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
        <div style="position:relative;">
          <input type="text" name="phone"id="telephone2" class="contact-form-line  <?php echo $getPhoneNumberClass; ?>" placeholder="<?php echo $this->query_model->getStaticTextTranslation('phone'); ?>" onFocus="this.placeholder = ''" error_class="phone_error2"  onBlur="phoneValidation(this)" maxlength="<?php echo $phoneNumberMaxLength; ?>" >
          <span class="fa fa-phone form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
<input type="text" id="fax" name="fax" class="optinfax"   placeholder="Fax Number" value="">
       
	   <div style="position:relative;">
          <input type="email"  name="form_email_2" id="form_email2"  class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('email'); ?>" onFocus="this.placeholder = ''" onBlur="this.placeholder = '<?php echo $this->query_model->getStaticTextTranslation('email'); ?>'">
          <span class="fa fa-envelope form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
         
		<div style="position:relative;">
		<?php if($multiLocation[0]->field_value == 1 ){ ?>
          <select class="locationBox contact-form-line getContactPageUrl" id="school2" name="school">
            <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_location'); ?></option>
					<?php foreach($form_allLocations as $location): ?>
						<option  value="<?=$location->name;?>" <?php if($mainLocation[0]->id == $location->id){ echo 'selected=selected'; }?> slug="<?=$location->slug;?>"><?=$location->name;?> </option>
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
		<?php
		
			$contact_page_slug = $this->query_model->getConatctPageSlug($mainLocation[0]->id);
		?>
		<input type="hidden" class="conatct_page_url" name="page_url" value="<?php echo !empty($contact_page_slug) ? $contact_page_slug : '/'; ?>" />	
		<input type="text" id="website" name="website" class="optinwebsite"  placeholder="Website" value="">
<input type="text"  class="ywedobjeo" name="x2o3d_<?php echo $this->query_model->setAndGetUniqueNumberForCustomField(); ?>" value="<?php echo time(); ?>"  placeholder="Serial Number"/>
        <input type="submit" value="<?php echo $this->query_model->getStaticTextTranslation('send_message'); ?>" class="btn btn-readmore  btn-block submit button contactFormSubmit2">
      </form>
    <div class="clearfix"></div>
  </div>
</section>
<?php if(!empty($seoContent['seo_text'])){ ?>
<div class="description-txt">
  <div class="container">
    <div class="row">
      <div class="inner-desc preColoums">
	  		
			<p class="preDescription"><?= $this->query_model->getDescReplace($seoContent['seo_text']); ?></p>
			
       </div>
    </div>
  </div>
</div>
<?php } ?>


<script>
	$(document).ready(function(){
		$('.staffInfoPopUp').click(function(){
			var number = $(this).attr('number');
				
				$.ajax({
			
					url: '<?=base_url();?>about/get_staff_detail',
					
					type: 'post',
					
					data: {staff_id: number},

					
					dataType: 'html',
					
					success: function(result) {
						$('#staffDetail').html(result);
						
					}
				  
			});
		});
		
	
	});
	
	
</script>
<div class="modal fade bs-example-modal-lg staff-popup" id="staffDetail"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	
</div>

<script>
   // DOM ready
   $(function() {
     
      // Create the dropdown base
      $("<select />").appendTo("#stick-nav");
      
      // Create default option "Go to..."
      $("<option />", {
         "selected": "selected",
         "value"   : "",
         "text"    : "Select Menu"
      }).appendTo("#stick-nav select");
      
      // Populate dropdown with menu items
      $("#stick-nav a").each(function() {
       var el = $(this);
       $("<option />", {
           "value"   : el.attr("href"),
           "text"    : el.text()
       }).appendTo("#stick-nav select");
      });
      
     // To make dropdown actually work
     // To make more unobtrusive: http://css-tricks.com/4064-unobtrusive-page-changer/
      $("#stick-nav select").change(function() {
	  	var value = $(this).val();
		
		var pathname = window.location.pathname; // Returns path only
		var url = window.location.href;
		//window.location = pathname +'?<?php echo $contactDetail->slug; ?>' +  $(this).find("option:selected").val()
		window.location = pathname +  $(this).find("option:selected").val()
      });
   
   });
  </script> 
<!-- fix nav script --> 
<script>
   $(document).ready(function(){
     $(window).bind('scroll', function() {
        var scroll = $(window).scrollTop();
        if (scroll >= 200) {
        $(".main-header").addClass("fixed");
    } else {
        $(".main-header").removeClass("fixed");
    }
    });
  });
</script> 
<script>
   $(document).ready(function(){
    $('.sub-navigation li a').click(function(){
      var $this = $(this);
      $('.sub-navigation li').removeClass('active');
         $this.parent('li').addClass('active');
    });

     $(window).bind('scroll', function() {
        var scroll = $(window).scrollTop();
        if (scroll >= 350) { 
          $('#stick-nav').addClass('fixed');/*
           $('section').addClass('set-space')*/
    } else {
         $('#stick-nav').removeClass('fixed');/*
           $('section').removeClass('set-space')*/
    }
    
    });
  });
</script> 
<script type="text/javascript">
jQuery(' a[href^="#"]').click(function(e) {
 
    jQuery('html,body').animate({ scrollTop: jQuery(this.hash).offset().top - 100}, 1000);
 
    return false;
 
    e.preventDefault();
 
});



</script>


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

<?php $forms = array('opt_in_form','contact_us_form');
echo $this->query_model->getGoogleCaptchaScript($forms); ?>

<!--<script src="js/new/jquery.maskedinput.js"></script>
<script type="text/javascript">
jQuery(function($){
   $(".phone_number").mask("999-999-9999",{placeholder:""});
});
</script>-->
<?php $this->load->view('includes/footer'); ?> 
