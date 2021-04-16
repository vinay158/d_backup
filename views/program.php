
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
	$(window).load(function(){
		var selected = $('input[name=call_or_schedule]:checked').val();
		
		if(selected == 'call'){
					$('.callDiv').hide();
		} else{
			$('.callDiv').show();
		}
	});
</script>

<style type="text/css">
	
	.programPageSection {
    display: flex;
    flex-direction: column;
	width:100%;
}
<?php if(!empty($allProgramSections)){
	foreach($allProgramSections as $program_section){
?>
.programPageSection > .<?php echo $program_section->section ?> {order: <?php echo $program_section->pos ?>; display: <?php echo ($program_section->published == 1) ? 'block' : 'none'; ?>; } 
<?php 
	}
} ?>

	</style>

	
<!-- Navigation -->
<!--<div class="mobile-contact">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 text-center"> <span class="no title-p"> <?= $program_detail->program; ?></span>
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
      <div class="clearfix"></div>
    </div>
  </div>
</div> -->
<section id="program-main" class="program-trial-form <?php if($this->query_model->get_gdpr_compliant() == 1){?> gdpr-enable <?php } ?> "   style="background-image:url('<?php echo 'upload/programs/'.$program_detail->background_image; ?>')  !important;" >
  <span class="overlay" style=" <?php echo !empty($program_detail->background_color) ? 'background:'.$program_detail->background_color.'  !important' : ''; ?>"></span>
  <div class="container">
    <div class="row">
      <div class="col-md-12 hidden-xs mobile-tab-hidden">
        <a href="javascript:void(0);" onclick="javascript:history.go(-1)" class="prev-page"><i class="fa fa-angle-left"></i> <?php echo $this->query_model->getStaticTextTranslation('back_to_previous_page'); ?></a>
      </div>
   <?php if($program_detail->header_image_video == "image"){ ?>   
      <div class="col-sm-4 col-md-4 text-span4  hidden-xs mobile-tab-hidden ">
         <?php 
		 if($program_detail->show_override_logo == 1){
			if($site_settings[0]->override_logo == 1){
				if($program_detail->override_logo != 1){
					
				$about_header_logo = $this->query_model->getbySpecific('tbloverride_logos','s_no', $program_detail->override_logo);
				
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
		 <?php } } ?> 
        <div class="program-desc program-heading">
           <h2 style="<?php echo !empty($program_detail->header_title_background_color) ? 'background-color:'.$program_detail->header_title_background_color : ''; ?>;padding: 15px 20px;"><?= $this->query_model->getDescReplace($program_detail->header_title); ?></h2>
          <p><?= $this->query_model->getDescReplace($program_detail->header_desc); ?></p>
          
        </div>
      </div>
      <div class="col-sm-4 col-md-4 hidden-xs vertical-image">
        <img src="<?php echo base_url(); ?>upload/programs/<?= $program_detail->header_image; ?>" class="img-responsive"  alt="<?= $this->query_model->getDescReplace($program_detail->header_image_alt_text); ?>">
      </div>
	  
   <?php }elseif($program_detail->header_image_video == "video"){ ?>
   
   <div class="col-sm-8 col-md-8 hidden-xs mobile-tab-hidden ">
   
		<?php 
		/* if($program_detail->show_override_logo == 1){
			if($site_settings[0]->override_logo == 1){
				if($program_detail->override_logo != 1){
					
				$about_header_logo = $this->query_model->getbySpecific('tbloverride_logos','s_no', $program_detail->override_logo);
				
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
		 <?php } }*/ ?> 
          
        <div class="program-desc program-heading">
           <h2><?= $this->query_model->getDescReplace($program_detail->header_title); ?></h2>
        </div>
		<div class="video-box-cont">
		<?php if($program_detail->header_video_type == 'youtube_video'){ ?>
		<?php if(!empty($program_detail->header_youtube_video)){ ?>
			 
			 <iframe src="<?php echo $this->query_model->changeVideoPathHttp($program_detail->header_youtube_video); ?>?rel=0&amp;controls=0&amp;showinfo=0&amp;autoplay=0"  allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="" width="560" height="315" frameborder="0"></iframe>
			 
		  <?php } } elseif($program_detail->header_video_type == 'vimeo_video'){ ?>
		  <?php if(!empty($program_detail->header_vimeo_video)){ ?>
		   
		   <iframe src="<?php echo $this->query_model->changeVideoPathHttp($program_detail->header_vimeo_video); ?>?rel=0&amp;showinfo=0&amp;autoplay=0"  allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="" width="560" height="315" frameborder="0"></iframe>
		 
	  <?php } }?>
		</div>
      </div>
   
   <?php }  ?>
	  
      <div class="col-md-4 col-sm-4 form-schedule form-span4 ">
        <div class="program-trial">
          <div class="red-block text-center">
            <h1><?= $this->query_model->getDescReplace($program_detail->program); ?><br>
			<?= $this->query_model->getDescReplace($program_detail->opt1_title); ?>
            <div class="big_triangle_wrapper">  
			<div class="big_triangle"></div>  
			</div>
          </div>
		  <?php if($program_detail->program_type == "birthday_page" || $program_detail->program_type == "summer_camp"){ ?>
	  <?php $this->load->view('includes/sidebar/bday_form', array('program_detail'=>$program_detail)); ?>
	  <?php } else { ?>
          <div class="white-block redeem-offer-block">
		  <?php if($program_detail->show_full_form_1 == 0){ ?>
          <h3><?= $this->query_model->getDescReplace($program_detail->opt1_text); ?></h3>
		  <?php } ?>
             <script>
				   
		$(document).ready(function(){
			
			
		$('.contactFormSubmit_6').click(function(){
		
					var err = 0
					
					
					
					<?php if($program_detail->show_full_form_1 == 1){ ?>
					
					var name=$('#first_name6').val();
					//alert(name); return false;
					if(name.length == 0){
						var err = 1;
						$('#first_name6').after('<div class="reds name_error6"><?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?></div>');
					}else{
						if(! /\s/g.test(name)){
							var err = 1;
							$('#first_name6').after('<div class="reds name_error6"><?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?></div>');
						}
					}
					
					/*var last_name=$('#last_name6').val();
					if(last_name.length == 0){
						var err = 1;
						$('#last_name6').after('<div class="reds last_name_error6"><?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?></div>');
					}*/
					
										
										
					var telephoneId = 'telephone6';
					var phoneError = 'phone_error6';
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
				<?php } ?>		
						
					
					
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
					<?php } */?>

					
					if(err == 0){
						<?php if($program_detail->show_full_form_1 == 1){ ?>
							$("#form_6").attr('action','<?=base_url().$trial_offer_slug->slug?>');
						<?php }else{ ?>
								$("#form_6").attr('action','<?=base_url()?>starttrial/saveLeadsByEmails');
						<?php } ?>
						
						return true;
					} else{
						$("#form_6").attr('action','#');
						return false;
					}
			
			});
			
			
			
				
		<?php if($program_detail->show_full_form_1 == 1){ ?>
			
			$('#first_name6').keyup(function(){
					if($(this).val().length > 0){
						$('.name_error6').hide();
					} else{
						$('#first_name6').after('<div class="reds name_error6"><?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?></div>');
						
					}
			});
			
			$('#last_name6').keyup(function(){
					if($(this).val().length > 0){
						$('.last_name_error6').hide();
					} else{
						$('#last_name6').after('<div class="reds last_name_error6"><?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?></div>');
						
					}
			});
			
			$('#telephone6').keyup(function(){
					
				$('.phone_error6').hide();
			});
		<?php } ?>
			
			
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
				
				
			<?php /* if($this->query_model->get_gdpr_compliant() == 1){?>
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
			<?php 
			$emailOnlyForm1 = 0;
			/*if(!empty($program_detail) && $program_detail->show_full_form_1 == 1){
				$emailOnlyForm1 = 0;
			}*/
		  ?>
		  
		  <?php if($emailOnlyForm1 == 0){ ?>
		  <form action="#"  method="post" class="get_started_form mini_form small_mini_form" id="form_6">
		  <?php echo $this->query_model->getCaptchaInputFields('opt_in_form'); ?>
            <div class="form-group <?php echo ($program_detail->show_full_form_1 == 1) ? 'full-program-form' : ''; ?>">
			
			<?php if($program_detail->show_full_form_1 == 1){ ?>
			
			 <input type="text" id="first_name6" name="name" class="form-control" placeholder="<?php echo $this->query_model->getStaticTextTranslation('first_name'); ?>" onfocus="this.placeholder = ''"   onBlur="textAlphabatic(this)" maxlength="<?php echo $this->query_model->fullNameInputMaxLength(); ?>" error_class="name_error6" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?>" >
			 
			 <input type="text" name="last_name" id="last_name6" class="form-control optinlastname" placeholder="<?php echo $this->query_model->getStaticTextTranslation('last_name'); ?>"  onfocus="this.placeholder = ''" onBlur="textAlphabatic(this)" maxlength="25" error_class="last_name_error" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?>"  >
			 
			<input type="text" name="phone" id="telephone6" class="form-control <?php echo $getPhoneNumberClass; ?>" placeholder="<?php echo $this->query_model->getStaticTextTranslation('phone'); ?>" onfocus="this.placeholder = ''" error_class="phone_error6" onBlur="phoneValidation(this)" maxlength="<?php echo $phoneNumberMaxLength; ?>"   >
			<?php } ?>
			<input type="text" id="fax" name="fax" class="optinfax"   placeholder="Fax Number" value="">

			
			<?php if($multiSchoolOrLocation == 1 ){ ?>
			<?php if($multiLocation[0]->field_value == 1  && count($form_allLocations) >= 1){ ?>
		    <select class=" form-control" name="school_interest" id="school_6">
               <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_location'); ?></option>
					<?php foreach($form_allLocations as $location): ?>
						<option  value="<?=$location->id;?>" ><?=$location->name;?> </option>
					<?php endforeach;?>   
              </select>
			 <?php } ?>
			<?php } ?>
               <input type="text" class="form-control" id="form_email_6" name="form_email_2" placeholder="<?php echo $this->query_model->getStaticTextTranslation('enter_your_email_address'); ?>">
			
			<?php if($program_detail->show_full_form_1 == 1){ ?>
			   <?php if(!empty($twilioApi)){?>
			   <div class=" twilio_checkbox" >
				  <input type="checkbox" class="form-control" name="twilio_checkbox" value="1"> <?php echo $twilioApi->checkbox_text ?>
			   </div>
				<?php } ?>
		   <?php } ?>
		   <input type="text" id="comment" name="comment" class="optincomment"   placeholder="Write your comment here..." value="">
<input type="checkbox" class="optincheck" name="contact_me_by_phone" value="1">
		    <?php if($this->query_model->get_gdpr_compliant() == 1){?>
			<div class="email_optin_gdpr_compliant_checkbox" >
				<input type="hidden" name="ip_address" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
				
				
			  <input type="checkbox" class="form-control" id="gdpr_compliant_6" name="gdpr_compliant_checkbox" value="1"><?php echo $gdpr_compliant_txt2; ?><br/><span><?php echo $gdpr_compliant_txt1; ?></span>
		   </div>
		 <?php } ?>
		   
					 <input type="hidden" name="page_url" value="<?php echo isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';  ?>" />
					 <input type="hidden" name="miniform" value="true" />
					 <input type="hidden" name="program_name" value="<?= $program_detail->program; ?>" />
					 <input type="hidden" name="program_id" value="<?= $program_detail->id; ?>" />
			
					 <input type="hidden" name="program_cat_id" value="<?= $category_detail[0]->cat_id; ?>" />
					 <input type="hidden" name="send_location" value="0" />
					<!-- <input type="hidden" name="trial_offer_id" value="<?= $trial_offer_id; ?>" /> --> 
					 <input type="hidden" name="redirection_type" value="<?= $program_detail->redirection_type; ?>" />
					 <?php if($program_detail->redirection_type == "dojocart"){ ?>
						<input type="hidden" name="dojocart_id" value="<?= $program_detail->dojocart_id; ?>" />
					 <?php }elseif($program_detail->redirection_type == "third_party_url"){ ?>
						 <input type="hidden" name="third_party_url" value="<?= $program_detail->third_party_url; ?>" />
					<?php }elseif($program_detail->redirection_type == "thankyou_page"){ ?>
						 <input type="hidden" name="thankyou_page_id" value="<?= $program_detail->thankyou_page_id; ?>" />
					 <?php }else{ ?>
						<input type="hidden" name="trial_offer_id" value="<?= $program_detail->trial_offer_id; ?>" />
					 <?php } ?>
            </div>
            <!-- <a href="#" class="redeem-offer">View Web Specials!</a> -->
			
<input type="text" id="website" name="website" class="optinwebsite"  placeholder="Website" value="">
<input type="text"  class="ywedobjeo" name="x2o3d_<?php echo $this->query_model->setAndGetUniqueNumberForCustomField(); ?>" value="<?php echo time(); ?>"  placeholder="Serial Number"/>
			<input type="hidden" name="is_unique_trial" value="<?php echo ($this->query_model->isTrialOfferUnique() == 'unique_') ? 1 : 0; ?>" />
			<button class="redeem-offer contactFormSubmit_6" name="submitEmail" value="submitEmail" type="submit" ><?php echo !empty($program_detail->opt1_submit_btn_text) ? $program_detail->opt1_submit_btn_text :  $this->query_model->getStaticTextTranslation('view_web_specials'); ?></button>
			</form>
		  <?php } ?>
          </div>
	  <?php } ?>
        </div>
        <span class="triangle">
          <p><?php echo $this->query_model->getStaticTextTranslation('We_respect_your_privacy'); ?></p>
        </span>
      </div>
	  
	  <?php if($program_detail->header_image_video == "image"){ ?> 
      <div class="col-sm-4 col-md-4 text-span4  hidden-sm hidden-md hidden-lg mobile-tab-visible">
        <?php 
			if($site_settings[0]->override_logo == 1){
				if($program_detail->override_logo != 1){
					
				$about_header_logo = $this->query_model->getbySpecific('tbloverride_logos','s_no', $program_detail->override_logo);
				
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
        <div class="program-desc">
          <h2 style="background-color: rgba(0,0,0,0.5);padding: 15px;"><?= $this->query_model->getDescReplace($program_detail->header_title); ?></h2>
          <p><?= $this->query_model->getDescReplace($program_detail->header_desc); ?></p>
          
        </div>
      </div>
	  <?php }elseif($program_detail->header_image_video == "video"){ ?>
	  <div style="clear:both"></div>
		<div class="col-sm-12 col-md-12 header-mobile hidden-sm hidden-md hidden-lg mobile-tab-visible">
          
		  <?php 
		/* if($program_detail->show_override_logo == 1){
			if($site_settings[0]->override_logo == 1){
				if($program_detail->override_logo != 1){
					
				$about_header_logo = $this->query_model->getbySpecific('tbloverride_logos','s_no', $program_detail->override_logo);
				
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
		 <?php } }*/ ?> 
		 
        <div class="program-desc program-heading">
           <h2><?= $this->query_model->getDescReplace($program_detail->header_title); ?></h2>
        </div>
		<div class="video-box-cont">
		<?php if($program_detail->header_video_type == 'youtube_video'){ ?>
		<?php if(!empty($program_detail->header_youtube_video)){ ?>
			 
			 <iframe src="<?php echo $this->query_model->changeVideoPathHttp($program_detail->header_youtube_video); ?>?rel=0&amp;controls=0&amp;showinfo=0&amp;autoplay=0"  allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="" width="560" height="315" frameborder="0"></iframe>
			 
		  <?php } } elseif($program_detail->header_video_type == 'vimeo_video'){ ?>
		  <?php if(!empty($program_detail->header_vimeo_video)){ ?>
		   
		   <iframe src="<?php echo $this->query_model->changeVideoPathHttp($program_detail->header_vimeo_video); ?>?rel=0&amp;showinfo=0&amp;autoplay=0"  allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="" width="560" height="315" frameborder="0"></iframe>
		 
	  <?php } }?>
		</div>
      </div>
	  
	  <?php } ?> 

    </div>
  </div>
</section>

<div class="programPageSection">
<?php if(!empty($program_detail->html_editor)){ ?>
<section id="html-row" class="section  html_editor_section">
    <div class="row">
      <div class="col-md-12  col-sm-12">
	  <?= $this->query_model->getDescReplace($program_detail->html_editor); ?>
      </div>
    </div>
</section>
<?php } ?>

<?php if(!empty($program_detail->question_headline)){ ?>
<section id="question" class="question_headline_section">
<div class="container">
    <div class="row">
      <?= $this->query_model->getDescReplace($program_detail->question_headline); ?>
    </div>
  </div>
</section>
<?php } ?>

<section id="mom-dad" class="white_stripe_section" style="<?php echo !empty($program_detail->white_stripe_background_color) ? 'background:'.$program_detail->white_stripe_background_color.'  !important' : ''; ?>">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
	 
			<div class="image-block" style="float:<?php echo ($program_detail->body_img_position == "right") ? 'right' : 'left'; ?>">
    		 <img src="<?php echo base_url(); ?>upload/programs/<?= $program_detail->body_image; ?>"  alt="<?= $this->query_model->getDescReplace($program_detail->body_image_alt_text); ?>">
    		 </div>
    		 <div class="right-block-text">
    		 	<h2><?= $this->query_model->getDescReplace($program_detail->body_title); ?></h2>
    		 	<div class="desc-text">
		        <?= $this->query_model->getDescReplace($program_detail->body_desc); ?>
		        </div>
    		 </div>
    		
    	</div>
    </div>
  </div>
</section>
<!-- <section id="mom-son" class="white_stripe_section" style="<?php echo !empty($program_detail->white_stripe_background_color) ? 'background:'.$program_detail->white_stripe_background_color.'  !important' : ''; ?>">
  <div class="container">
    <div class="row">
	<?php 
		$body_img_position = 'pull-left';
		$body_text_position = 'pull-right';
		if($program_detail->body_img_position == "right"){
			$body_img_position = 'pull-right';
			$body_text_position = 'pull-left';
		}
	?>
      <div class="col-md-3 ">
        <img src="<?php echo base_url(); ?>upload/programs/<?= $program_detail->body_image; ?>"  alt="<?= $this->query_model->getDescReplace($program_detail->body_image_alt_text); ?>">
      </div>
      <div class="col-md-9 <?= $body_text_position; ?>">
        <div class="desc-text">
        <?= $this->query_model->getDescReplace($program_detail->body_desc); ?>
        </div>
      </div>
    </div>
  </div>  
</section> -->
<section id="life-skills" class="pos-rel benefits_1_section"  style="background-image:url('<?php echo 'upload/programs/'.$program_detail->benefits_background_image; ?>') ; <?php echo !empty($program_detail->benefits_background_color) ? 'background:'.$program_detail->benefits_background_color.'  !important' : ''; ?>">
 <!-- <span class="overlay" style=" <?php echo !empty($program_detail->benefits_background_color) ? 'background:'.$program_detail->benefits_background_color.'  !important' : ''; ?>"></span> -->
  <div class="container">
    <div class="row">
      <h2><?= $this->query_model->getDescReplace($program_detail->benefits_title); ?></h2>
	  <p><?= $this->query_model->getDescReplace($program_detail->benefits_desc); ?></p>
      <div class="col-sm-4">
        <?php if(!empty($program_detail->benefits_image_1)){ ?>
			 <img src="<?php echo base_url(); ?>upload/programs/<?= $program_detail->benefits_image_1; ?>" class=""   alt="<?= $this->query_model->getDescReplace($program_detail->benefits_image_1_alt_text); ?>"> 
		  <?php } ?>
        <p><?= $this->query_model->getDescReplace($program_detail->benefits_headline_1); ?></p>
      </div>
      <div class="col-sm-4">
        <?php if(!empty($program_detail->benefits_image_2)){ ?>
			 <img src="<?php echo base_url(); ?>upload/programs/<?= $program_detail->benefits_image_2; ?>" class=""   alt="<?= $this->query_model->getDescReplace($program_detail->benefits_image_2_alt_text); ?>"> 
		  <?php } ?>
        <p><?= $this->query_model->getDescReplace($program_detail->benefits_headline_2); ?></p>
        
      </div>
      <div class="col-sm-4">
        <?php if(!empty($program_detail->benefits_image_3)){ ?>
			 <img src="<?php echo base_url(); ?>upload/programs/<?= $program_detail->benefits_image_3; ?>" class=""  alt="<?= $this->query_model->getDescReplace($program_detail->benefits_image_3_alt_text); ?>"> 
		  <?php } ?>
        <p><?= $this->query_model->getDescReplace($program_detail->benefits_headline_3); ?></p>
        
      </div>
    </div>
  </div>
</section>

      <section class="section video_row_section" id="discover"  style="background-image:url('<?php echo 'upload/programs/'.$program_detail->video_background_image; ?>')  !important;">
         <span class="overlay" style="<?php echo !empty($program_detail->video_background_color) ? 'background:'.$program_detail->video_background_color : ''; ?>"></span>
         <div class="container">
            <div class="row">
               <div class="col-md-8 col-md-push-2">
			   <h2><?= $this->query_model->getDescReplace($program_detail->video_title); ?></h2>
			   <p><?= $this->query_model->getDescReplace($program_detail->video_desc); ?></p>
				 <?php if($program_detail->video_type == 'youtube_video'){ ?>
						<?php if(!empty($program_detail->youtube_video)){ ?>
								  <div class="video-inner">
									 <iframe  height="390" src="<?php echo $this->query_model->changeVideoPathHttp($program_detail->youtube_video); ?>?rel=0&amp;controls=0&amp;showinfo=0&amp;autoplay=0" frameborder="0" allowfullscreen ></iframe>
									 <span class="video-overlay">
										<div class=""></div>
									 </span>
								  </div>
								   <?php } } else{ ?>
							  <?php if(!empty($program_detail->vimeo_video)){ ?>
							  <div class="video-inner">
									 <iframe  height="390" src="<?php echo $this->query_model->changeVideoPathHttp($program_detail->vimeo_video); ?>?rel=0&amp;showinfo=0&amp;autoplay=0" frameborder="0" allowfullscreen ></iframe>
									 <span class="video-overlay">
										<div class=""></div>
									 </span>
								  </div>
								<?php } } ?> 
                  
               </div>
            </div>
         </div>
      </section>
<?php 
	if(!empty($allProgramRows)){
		foreach($allProgramRows as $program_row){
			
			$body_img_position = 'leftImgBox';
			$body_text_position = 'pull-right';
			if($program_row->photo_side == "right"){
				$body_img_position = 'rightImgBox';
				$body_text_position = 'pull-left';
			}
	?>
<section id="toggle-block" class="clearfix blue-bg share-section full_width_row_section">

         <div class="content-box <?= $body_text_position ?>" style="<?php echo !empty($program_row->background_color) ? 'background:'.$program_row->background_color : ''; ?>">
		 
          <h2><?= $this->query_model->getDescReplace($program_row->title); ?></h2>
         
          <p><?= $this->query_model->getDescReplace($program_row->description); ?></p>
            </div>
			
            <div class="relative-block <?= $body_img_position; ?>">
                <div class="full-bg-toggle-a" style="background-image:url('<?php echo 'upload/programs/'.$program_row->photo; ?>'); ">
                   <span class="cyan-overlay"></span>
                </div>
            </div>
       <div class="clearfix"></div>
  </section>
	<?php } } ?>

  <section id="get-started"  class="pos-rel call_to_action_section"  style="background-image:url('<?php echo 'upload/programs/'.$program_detail->action_background_image; ?>')  !important;">
  <span class="overlay" style="<?php echo !empty($program_detail->action_background_color) ? 'background:'.$program_detail->action_background_color : ''; ?>"></span>
  <div class="container">
    <div class="row">
      <h2><?= $this->query_model->getDescReplace($program_detail->action_title); ?></h2>
	  <p><?= $this->query_model->getDescReplace($program_detail->action_desc); ?></p>
      <div class="col-sm-4">
        <?php 
			if(!empty($program_detail->action_image_1)){ 
			$action_link_url_1 = (isset($program_detail->action_link_url_1) && !empty($program_detail->action_link_url_1)) ? $program_detail->action_link_url_1 : base_url().$trial_offer_slug->slug.'/'.$trialCatSlug;
		?>
		<a href="<?=$action_link_url_1?>">
			 <img src="<?php echo base_url(); ?>upload/programs/<?= $program_detail->action_image_1; ?>" class=""   alt="<?= $this->query_model->getDescReplace($program_detail->action_image_1_alt_text); ?>"> 
		</a>
		  <?php } ?>
        <h3><?= $this->query_model->getDescReplace($program_detail->action_headline_1); ?></h3>
        <p> <?= $this->query_model->getDescReplace($program_detail->action_desc_1); ?></p>
      </div>
      <div class="col-sm-4">
        <?php 
			if(!empty($program_detail->action_image_2)){ 
				$action_link_url_2 = (isset($program_detail->action_link_url_2) && !empty($program_detail->action_link_url_2)) ? $program_detail->action_link_url_2 : base_url().$trial_offer_slug->slug.'/'.$trialCatSlug;
		?>
		<a href="<?=$action_link_url_2?>">
			 <img src="<?php echo base_url(); ?>upload/programs/<?= $program_detail->action_image_2; ?>" class=""  alt="<?= $this->query_model->getDescReplace($program_detail->action_image_2_alt_text); ?>"> 
			 </a>
		  <?php } ?>
        <h3><?= $this->query_model->getDescReplace($program_detail->action_headline_2); ?></h3>
        <p> <?= $this->query_model->getDescReplace($program_detail->action_desc_2); ?></p>
      </div>
	  
	   <div class="col-sm-4">
        <?php 
			if(!empty($program_detail->action_image_3)){ 
				$action_link_url_3 = (isset($program_detail->action_link_url_3) && !empty($program_detail->action_link_url_3)) ? $program_detail->action_link_url_3 : base_url().$trial_offer_slug->slug.'/'.$trialCatSlug;
		?>
		<a href="<?=$action_link_url_3?>">
			 <img src="<?php echo base_url(); ?>upload/programs/<?= $program_detail->action_image_3; ?>" class=""  alt="<?= $this->query_model->getDescReplace($program_detail->action_image_3_alt_text); ?>"> 
		</a>
		  <?php } ?>
        <h3><?= $this->query_model->getDescReplace($program_detail->action_headline_3); ?></h3>
        <p> <?= $this->query_model->getDescReplace($program_detail->action_desc_3); ?></p>
      </div>
    </div>
  </div>
</section>


<section class="difference-block headling_section" id="difference" style="background-image:url('<?php echo 'upload/programs/'.$program_detail->headling_background_image; ?>')  !important;">
         <span class="overlay" style="<?php echo !empty($program_detail->headling_background_color) ? 'background:'.$program_detail->headling_background_color : ''; ?>"></span>
         <div class="container">
            <div class="row text-center">
               <div class="col-sm-12 col-md-12">
                  <div class="text-center">
                     <h2><?= $this->query_model->getDescReplace($program_detail->headling_title); ?></h2>
                     <p><?= $this->query_model->getDescReplace($program_detail->headling_desc); ?></p>
                  </div>   
                  <div class="col-sm-4 col-md-4">
                     <div class="block-box">
                        <p><?= $this->query_model->getDescReplace($program_detail->headling_headline_1); ?></p>
                        
                     </div>
                  </div>  
                  <div class="col-sm-4 col-md-4">
                     <div class="block-box">
                        <p><?= $this->query_model->getDescReplace($program_detail->headling_headline_2); ?></p>
                     </div>
                  </div>  
                  <div class="col-sm-4 col-md-4">
                     <div class="block-box">
                        <p><?= $this->query_model->getDescReplace($program_detail->headling_headline_3); ?></p>
                     </div>
                  </div>   
               </div>
            </div>
         </div>
      </section>
      <section id="parents" class="text-center statistics_section"  style="background-image:url('<?php echo 'upload/programs/'.$program_detail->statistics_background_image; ?>')  !important;">
         <span class="overlay" style="<?php echo !empty($program_detail->statistics_background_color) ? 'background:'.$program_detail->statistics_background_color : ''; ?>"></span>
         <div class="container">
            <div class="row">
               <div class="col-md-12 col-sm-12">
                  <div class="text-center">
                     <h2><?= $this->query_model->getDescReplace($program_detail->statistics_title); ?></h2>
                     
                  </div>
               </div>
                  <div class="col-sm-4">
                    <?php if(!empty($program_detail->statistics_image_1)){ ?>
					 <img src="<?php echo base_url(); ?>upload/programs/<?= $program_detail->statistics_image_1; ?>" class=""   alt="<?= $this->query_model->getDescReplace($program_detail->statistics_image_1_alt_text); ?>"> 
				  <?php } ?>
                    <h2><?= $this->query_model->getDescReplace($program_detail->statistics_headline_1); ?></h2>
                    <p> <?= $this->query_model->getDescReplace($program_detail->statistics_desc_1); ?></p>
                  </div>
                 <div class="col-sm-4">
                    <?php if(!empty($program_detail->statistics_image_2)){ ?>
					 <img src="<?php echo base_url(); ?>upload/programs/<?= $program_detail->statistics_image_2; ?>" class=""   alt="<?= $this->query_model->getDescReplace($program_detail->statistics_image_2_alt_text); ?>"> 
				  <?php } ?>
                    <h2><?= $this->query_model->getDescReplace($program_detail->statistics_headline_2); ?></h2>
                    <p> <?= $this->query_model->getDescReplace($program_detail->statistics_desc_2); ?></p>
                  </div>
                 <div class="col-sm-4">
                    <?php if(!empty($program_detail->statistics_image_3)){ ?>
					 <img src="<?php echo base_url(); ?>upload/programs/<?= $program_detail->statistics_image_3; ?>" class=""   alt="<?= $this->query_model->getDescReplace($program_detail->statistics_image_3_alt_text); ?>"> 
				  <?php } ?>
                    <h2><?= $this->query_model->getDescReplace($program_detail->statistics_headline_3); ?></h2>
                    <p> <?= $this->query_model->getDescReplace($program_detail->statistics_desc_3); ?></p>
                  </div>
                  <div class="col-md-10 col-md-push-1 col-sm-12 stats">
                    
                    
                    <p><?= $this->query_model->getDescReplace($program_detail->statistics_desc); ?></p>
                  </div>
            </div>
         </div>
      </section>
      <section id="life-skills" class="ways sky-bg benefits_2_section" style="background-image:url('<?php echo 'upload/programs/'.$program_detail->benefits_2_background_image; ?>')  !important;<?php echo !empty($program_detail->benefits_2_background_color) ? 'background:'.$program_detail->benefits_2_background_color : ''; ?>">
        <div class="container">
          <div class="row">
            <h2><?= $this->query_model->getDescReplace($program_detail->benefits_2_title); ?></h2>
            <p><?= $this->query_model->getDescReplace($program_detail->benefits_2_desc); ?></p>
            <div class="col-sm-4">
               <?php if(!empty($program_detail->benefits_2_image_1)){ ?>
			 <img src="<?php echo base_url(); ?>upload/programs/<?= $program_detail->benefits_2_image_1; ?>" class=""   alt="<?= $this->query_model->getDescReplace($program_detail->benefits_2_image_1_alt_text); ?>"> 
		  <?php } ?>
              <h3><?= $this->query_model->getDescReplace($program_detail->benefits_2_headline_1); ?></h3>
              <p><?= $this->query_model->getDescReplace($program_detail->benefits_2_desc_1); ?></p>
            </div>
            <div class="col-sm-4">
               <?php if(!empty($program_detail->benefits_2_image_2)){ ?>
			 <img src="<?php echo base_url(); ?>upload/programs/<?= $program_detail->benefits_2_image_2; ?>" class=""  alt="<?= $this->query_model->getDescReplace($program_detail->benefits_2_image_2_alt_text); ?>"> 
		  <?php } ?>
              <h3><?= $this->query_model->getDescReplace($program_detail->benefits_2_headline_2); ?></h3>
              <p><?= $this->query_model->getDescReplace($program_detail->benefits_2_desc_2); ?></p>
            </div>
             <div class="col-sm-4">
               <?php if(!empty($program_detail->benefits_2_image_3)){ ?>
			 <img src="<?php echo base_url(); ?>upload/programs/<?= $program_detail->benefits_2_image_3; ?>" class=""  alt="<?= $this->query_model->getDescReplace($program_detail->benefits_2_image_3_alt_text); ?>"> 
		  <?php } ?>
              <h3><?= $this->query_model->getDescReplace($program_detail->benefits_2_headline_3); ?></h3>
              <p><?= $this->query_model->getDescReplace($program_detail->benefits_2_desc_3); ?></p>
            </div>
          </div>
        </div>
      </section>
<!-- features program section -->
<section id="ata-ad" class="white_stripe_2_section">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
         <?php if(!empty($program_detail->white_stripe2_image)){ ?>
			 <img src="<?php echo base_url(); ?>upload/programs/<?= $program_detail->white_stripe2_image; ?>" class=""  alt="<?= $this->query_model->getDescReplace($program_detail->white_stripe2_image_alt_text); ?>"> 
		  <?php } ?>
        <?= $this->query_model->getDescReplace($program_detail->white_stripe2_desc); ?>
      </div>
    </div>
  </div>
</section>
<?php 
if(!empty($allLittleProgramRows)){
		foreach($allLittleProgramRows as $program_row){
			$class1 = '';
				$class2 = '';
			if($program_row->photo_side == "right"){
				$class1 = ' col-md-push-8';
				$class2 = '  col-md-pull-4';
			}
?>
<section id="" class="cyan-bg little_row_section"  style="background:<?php echo !empty($program_row->background_color) ? $program_row->background_color : ''; ?>">
  <div class="container">
    <div class="row">
      <div class="col-md-10 col-md-push-1">
        <div class="row">
          <div class="col-md-4 img-over <?= $class1; ?>">
            <img src="<?php echo 'upload/programs/'.$program_row->photo; ?>" style="top:<?php echo !empty($program_row->img_top_spacing) ? $program_row->img_top_spacing : 0; ?>px;" alt="<?= $this->query_model->getDescReplace($program_row->photo_alt_text); ?>">
          </div>
          <div class="col-md-8 <?= $class2; ?>">
            <div class="text-block">
            <h2><?= $this->query_model->getDescReplace($program_row->title); ?></h2>
            <p><?= $this->query_model->getDescReplace($program_row->description); ?></p>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php } }?>


	 <?php if(!empty($myTestimonials)): ?>
      <section id="testi-block" class="testimonial testimonial-trial testimonial_section">
         <div class="container">
            <div class="row">
			<?php if(!empty($program_detail->testimonials_h2_text)){ ?>
			<div class="col-md-12 text-center">
				<h2><?= $this->query_model->getDescReplace($program_detail->testimonials_h2_text); ?></h2>
			</div>
			<?php } ?>
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
	  
<?php if(!empty($allProgramFaqs)){ ?>
  <section id="faq" class="faq_section">
       <div class="container">
         <div class="row">
          <div class="col-md-12 text-center">
            <h2><?php  !empty($program_detail->faqs_h2_text) ? $this->query_model->getDescReplace($program_detail->faqs_h2_text) : $this->query_model->getStaticTextTranslation('frequently_asked_questions'); ?></h2>
          </div>
		  <?php foreach($allProgramFaqs as $faq){ ?>
           <div class="col-md-6 col-sm-6">
             <div class="faq-left">
               <label><?= $this->query_model->getDescReplace($faq->title); ?></label>
              <?= $this->query_model->getDescReplace($faq->description); ?>

             </div>
            
           </div>
           <div class="col-md-6 col-sm-6">
            
              <div class="faq-right">
               <label><?= $this->query_model->getDescReplace($faq->title_2); ?></label>
               <?= $this->query_model->getDescReplace($faq->description_2); ?>

             </div>
           </div>
		  <div class="clearfix"></div>
		  <?php } ?>  
         </div>
       </div>
     </section>
<?php } ?>

<section id="get-started" class="gift benefits_3_section" style="background-image:url('<?php echo 'upload/programs/'.trim($program_detail->benefits_3_background_image); ?>')  !important;">
<span class="overlay" style="<?php echo !empty($program_detail->benefits_3_background_color) ? 'background:'.$program_detail->benefits_3_background_color : ''; ?>"></span>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <h2><?= $this->query_model->getDescReplace($program_detail->benefits_3_title); ?></h2>
         <p><?= $this->query_model->getDescReplace($program_detail->benefits_3_desc); ?></p>
      </div>
       <div class="col-sm-4">
		   <?php if(!empty($program_detail->benefits_3_image_1)){ ?>
		   <a href="<?=base_url().$trial_offer_slug->slug.'/'.$trialCatSlug?>">
		 <img src="<?php echo base_url(); ?>upload/programs/<?= $program_detail->benefits_3_image_1; ?>" class=""  alt="<?= $this->query_model->getDescReplace($program_detail->benefits_3_image_1_alt_text); ?>"> 
		 </a>
	  <?php } ?>
		  <h2><?= $this->query_model->getDescReplace($program_detail->benefits_3_headline_1); ?></h2>
		 </div>
		 <div class="col-sm-4">
		   <?php if(!empty($program_detail->benefits_3_image_2)){ ?>
		   <a href="<?=base_url().$trial_offer_slug->slug.'/'.$trialCatSlug?>">
		 <img src="<?php echo base_url(); ?>upload/programs/<?= $program_detail->benefits_3_image_2; ?>" class=""  alt="<?= $this->query_model->getDescReplace($program_detail->benefits_3_image_2_alt_text); ?>"> 
		 </a>
	  <?php } ?>
		  <h2><?= $this->query_model->getDescReplace($program_detail->benefits_3_headline_2); ?></h2>
		 </div>
		 
		 <div class="col-sm-4">
		   <?php if(!empty($program_detail->benefits_3_image_3)){ ?>
		   <a href="<?=base_url().$trial_offer_slug->slug.'/'.$trialCatSlug?>">
		 <img src="<?php echo base_url(); ?>upload/programs/<?= $program_detail->benefits_3_image_3; ?>" class=""  alt="<?= $this->query_model->getDescReplace($program_detail->benefits_3_image_3_alt_text); ?>"> 
		 </a>
	  <?php } ?>
		  <h2><?= $this->query_model->getDescReplace($program_detail->benefits_3_headline_3); ?></h2>
		 </div>
		 
		 
    </div>
  </div>
</section>
</div>
<section class="trial-form trial-form-about-footer" id="trial-program">
         <div class="container">
            <div class="row">
               <div class="col-md-12 text-center">
                  <h2>
				  <?php if(!empty($program_detail->opt_2_title)){
					  $this->query_model->getDescReplace($program_detail->opt_2_title);
				  }else{ 
						$this->query_model->getDescReplace($program_detail->program);
						echo ' '.$this->query_model->getStaticTextTranslation('exclusive_web_offer');
				  } ?>
				  </h2>
                  <h1> <?php if(!empty($program_detail->opt_2_text)) { $this->query_model->getDescReplace($program_detail->opt_2_text);  } else { echo $this->query_model->getStaticTextTranslation('act_now'); }?> </h1>
                  <!--<p><?= $this->query_model->getDescReplace($program_detail->opt_2_title); ?></p>
                  <h3><?= $this->query_model->getDescReplace($program_detail->opt_2_text); ?></h3> -->
               </div>
            </div>
         </div>
      </section>
	  
	  <?php 
		$emailOnlyForm2 = 1;
		if(!empty($program_detail) && $program_detail->show_full_form_2 == 1){
			$emailOnlyForm2 = 0;
		}
	  ?>
	  <?php if($emailOnlyForm2 == 1){ ?>
	  
	  <div class="started-block white-bg green-color p-b-40" style="margin-bottom:70px;">
	   <span></span>
				   <script>
				   
		$(document).ready(function(){
			
			
		$('.contactFormSubmit_7').click(function(){
		
					var err = 0
					
					
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
					<?php } */ ?>
					
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
						$('.email_error').hide();
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
	<form action="#"  method="post" class="get_started_form mini_form small_mini_form" id="form_7">
	<?php echo $this->query_model->getCaptchaInputFields('opt_in_form'); ?>
                  <div class="search-box">
				  <?php if($multiSchoolOrLocation == 1 ){ ?>
			<?php if($multiLocation[0]->field_value == 1  && count($form_allLocations) >= 1){ ?>
		    <select class="form-control" name="school_interest" id="school_7">
               <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_location'); ?></option>
					<?php foreach($form_allLocations as $location): ?>
						<option  value="<?=$location->id;?>" ><?=$location->name;?> </option>
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
					 <input type="hidden" name="program_name" value="<?= $program_detail->program; ?>" />
						 <input type="hidden" name="program_id" value="<?= $program_detail->id; ?>" />
			
					 <input type="hidden" name="program_cat_id" value="<?= $category_detail[0]->cat_id; ?>" />
					 <!--<input type="hidden" name="trial_offer_id" value="<?= $trial_offer_id; ?>" /> -->
					 <input type="hidden" name="redirection_type" value="<?= $program_detail->redirection_type; ?>" />
					 <?php if($program_detail->redirection_type == "dojocart"){ ?>
						<input type="hidden" name="dojocart_id" value="<?= $program_detail->dojocart_id; ?>" />
					 <?php }elseif($program_detail->redirection_type == "third_party_url"){ ?>
						 <input type="hidden" name="third_party_url" value="<?= $program_detail->third_party_url; ?>" />
					<?php }elseif($program_detail->redirection_type == "thankyou_page"){ ?>
						 <input type="hidden" name="thankyou_page_id" value="<?= $program_detail->thankyou_page_id; ?>" />
					 <?php }else{ ?>
						<input type="hidden" name="trial_offer_id" value="<?= $program_detail->trial_offer_id; ?>" />
					 <?php } ?>
					 
					 <input type="hidden" name="is_unique_trial" value="<?php echo ($this->query_model->isTrialOfferUnique() == 'unique_') ? 1 : 0; ?>" />
					 <input type="text" id="website" name="website" class="optinwebsite"  placeholder="Website" value="">
<input type="text"  class="ywedobjeo" name="x2o3d_<?php echo $this->query_model->setAndGetUniqueNumberForCustomField(); ?>" value="<?php echo time(); ?>"  placeholder="Serial Number"/>
                     <button class="btn-red contactFormSubmit_7" name="submitEmail" value="submitEmail" type="submit" ><?php echo $gdpr_compliant_submit_btn_text; ?>  </button>
					 
                  </div>
			  </form>
				   </div>
	  <?php } else{ ?>
	  
	  
	  		
<div class="trial-form about-trial-form about-bg">
  <div class="container">
    
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
                            onfocus="this.placeholder = ''" onBlur="textAlphabatic(this)" maxlength="25" error_class="last_name_error" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?>"
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
              <select class="locationBox contact-form-line" name="school_interest" id="school1">
               <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_location'); ?></option>
					<?php foreach($form_allLocations as $location): ?>
						<option  value="<?=$location->id;?>" ><?=$location->name;?> </option>
					<?php endforeach;?>   
              </select>
              <span class="fa fa-map-marker form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
			 <?php } ?>
			 
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
						
						
					  <input type="checkbox" class="form-control" id="gdpr_compliant_1" name="gdpr_compliant_checkbox" value="1"><?php echo $gdpr_compliant_txt2; ?><br/><span><?php echo $gdpr_compliant_txt1; ?></span>
				   </div>
				 <?php } ?>
			   
            <div class="<?php if($multiLocation[0]->field_value == 0){ echo 'inline_mid_form singleLocationFormButton'; }?> started-btn" >
				<input type="hidden" name="miniform" value="true" />
                <input type="text" id="website" name="website" class="optinwebsite"  placeholder="Website" value="">
<input type="text"  class="ywedobjeo" name="x2o3d_<?php echo $this->query_model->setAndGetUniqueNumberForCustomField(); ?>" value="<?php echo time(); ?>"  placeholder="Serial Number"/>
				<input type="hidden" name="page_url" value="<?php echo isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';  ?>" />
				<input type="hidden" name="program_name" value="<?= $program_detail->program; ?>" />
			
				<input type="hidden" name="program_cat_id" value="<?= $category_detail[0]->cat_id; ?>" />
				<!-- <input type="hidden" name="trial_offer_id" value="<?= $trial_offer_id; ?>" /> -->
				<input type="hidden" name="redirection_type" value="<?= $program_detail->redirection_type; ?>" />
					 <?php if($program_detail->redirection_type == "dojocart"){ ?>
						<input type="hidden" name="dojocart_id" value="<?= $program_detail->dojocart_id; ?>" />
					 <?php }elseif($program_detail->redirection_type == "third_party_url"){ ?>
						 <input type="hidden" name="third_party_url" value="<?= $program_detail->third_party_url; ?>" />
					<?php }elseif($program_detail->redirection_type == "thankyou_page"){ ?>
						 <input type="hidden" name="thankyou_page_id" value="<?= $program_detail->thankyou_page_id; ?>" />
					 <?php }else{ ?>
						<input type="hidden" name="trial_offer_id" value="<?= $program_detail->trial_offer_id; ?>" />
					 <?php } ?>
					 
					 <input type="hidden" name="is_unique_trial" value="<?php echo ($this->query_model->isTrialOfferUnique() == 'unique_') ? 1 : 0; ?>" />
              <input class="mini_formSubmit contactFormSubmit1 submit <?php if($multiLocation[0]->field_value == 0){ echo 'getStartedMargin'; } else { echo 'getStartedMarginAuto'; } ?>" type="submit" class="" value="<?php echo $this->query_model->getStaticTextTranslation('submit'); ?>" />
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


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
          <div class="col-sm-12 text-center"> <span class="no title-p"><?= $program_detail->program; ?>
	  	
	  </span>
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
			
		$('.contactFormSubmit3').click(function(){
		
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
					
					/*var telephone=$('#telephone2').val();
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
      <form class="d-bg-c contact-form content_contact_form"action="contactus/send" method="post">
	  <?php echo $this->query_model->getCaptchaInputFields('contact_us_form'); ?>
	 <input type="hidden" name="hid_location" value="<?= !empty($contactDetail) ? $contactDetail->id : '' ?>" />
	  <div class="message">
				<div id="alert"></div>
	  </div>
        <div style="position:relative;">
          <input type="text" name="name" id="first_name2"  class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('first_name'); ?>" onFocus="this.placeholder = ''"   onBlur="textAlphabatic(this)" maxlength="<?php echo $this->query_model->fullNameInputMaxLength(); ?>" error_class="name_error2" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?>" >
          <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
          <div style="position:relative;" class="optinlastname">
          <input type="text" name="last_name" id="last_name2" class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('last_name'); ?>" onFocus="this.placeholder = ''"  onBlur="textAlphabatic(this)" maxlength="25" error_class="last_name_error" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?>" >
          <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
		  
		  <div style="position:relative;">
          <input type="text" name="phone" id="telephone2" class="contact-form-line   <?php echo $getPhoneNumberClass; ?>" placeholder="<?php echo $this->query_model->getStaticTextTranslation('phone'); ?>" onFocus="this.placeholder = ''" error_class="phone_error2" onBlur="phoneValidation(this)" maxlength="<?php echo $phoneNumberMaxLength; ?>"  >
		  <span class="fa fa-phone form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span></div>
        <input type="text" id="fax" name="fax" class="optinfax"   placeholder="Fax Number" value="">

        <div style="position:relative;">
          <input type="email"  name="form_email_2" id="form_email2"  class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('email'); ?>" onFocus="this.placeholder = ''" onBlur="this.placeholder = '<?php echo $this->query_model->getStaticTextTranslation('email'); ?>'">
          <span class="fa fa-envelope form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
       
	    <div style="position:relative;">
		<?php if($multiLocation[0]->field_value == 1){ ?>
          <select class="locationBox contact-form-line getContactPageUrl" id="school2" name="school">
            <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_location'); ?></option>
					<?php foreach($form_allLocations_contact as $location): ?>
						<option  value="<?=$location->name;?>"  slug="<?=$location->slug;?>"><?=$location->name;?> </option>
					<?php endforeach;?>   
          </select>
		  <?php } ?>
          <span class="fa fa-map-marker form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
		
        <div style="position:relative;"> <span class="site_theme_text fa fa-comment form-control-feedback move_input_icon" aria-hidden="true"></span>
          <textarea  name="message" id="message2" class="contact-form-area" placeholder="message" onFocus="this.placeholder = ''" onBlur="this.placeholder = 'Message'"></textarea>
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
		
<input type="text" id="website" name="website" class="optinwebsite"  placeholder="Website" value="">
<input type="text"  class="ywedobjeo" name="x2o3d_<?php echo $this->query_model->setAndGetUniqueNumberForCustomField(); ?>" value="<?php echo time(); ?>"  placeholder="Serial Number"/>
		<?php
			$contact_page_slug = $this->query_model->getConatctPageSlug();
		?>
		<input type="hidden" class="conatct_page_url" name="page_url" value="<?php echo !empty($contact_page_slug) ? $contact_page_slug : '/'; ?>" />
        <input type="submit" value="<?php echo $this->query_model->getStaticTextTranslation('send_message'); ?>" class="btn btn-readmore  btn-block submit button contactFormSubmit3">
      </form>
    <div class="clearfix"></div>
  </div>
</section>

<script src="js/new/jquery-1.11.0.js"></script>




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


<!--<script src="js/new/jquery.maskedinput.js"></script>
<script type="text/javascript">
jQuery(function($){
   $(".phone_number").mask("999-999-9999",{placeholder:""});
});
</script>-->
<?php $this->load->view('includes/footer'); ?> 

<?php $forms = array('opt_in_form','contact_us_form');
echo $this->query_model->getGoogleCaptchaScript($forms); ?>