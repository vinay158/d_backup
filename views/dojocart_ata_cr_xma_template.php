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
?>
<?php $phoneNumberMaxLength = $this->query_model->phoneNumberMaxLength(); 

	  $getPhoneNumberClass = $this->query_model->getPhoneNumberClass(); 
?>

<?php 
      if($paymentDetail[0]->authorize_net_payment == 1 || $paymentDetail[0]->braintree_payment == 1     || $paymentDetail[0]->stripe_payment == 1 || $paymentDetail[0]->stripe_ideal_payment == 1  ){
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
            }else{
                $action_value = 'dojocartpayment/dojocart_buyspecial/'.$single_record->id;
              }
      }
        else{
          $action_value = 'dojocartpayment/dojocart_buyspecial/'.$single_record->id;
        }
        ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<link href="css/v5/form.css" rel="stylesheet" type="text/css">
<style>
.position_relative{position: relative !important;}
</style>
<script>

  $(document).ready(function(){
     $('input.disablecopypaste').bind('copy paste', function (e) {
		   e.preventDefault();
		});
		
	$('.submitDojocart').click(function(){
		var err = 0;
		$.each($('.required_field'), function(){
			var field_type = $(this).attr('field_type');
			var custom_field_id = $(this).attr('custom_field_id');
			var custom_field_title = $(this).attr('field_title');
			
			var field_value = $.trim($(this).val());
			
			if(field_type == "text" || field_type == "text_varchar" || field_type == "integer" || field_type == "dropdown" ){
				if(field_value == '' || field_value == null){
					err++;
					$('.field_error'+custom_field_id).remove();
					$(this).after('<div class="reds custom_field_error field_error'+custom_field_id+'">Please Enter Your '+custom_field_title+'</div>');
				}else{
					$('.field_error'+custom_field_id).hide();
					//$(this).after('<div class="reds field_error'+custom_field_id+'">Please Enter '+custom_field_title+'</div>');
				}
			}else if(field_type == "email"){
				var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
      			
      			if(field_value.length == 0 || emailfilter.test(field_value) == false){
      				err++;
					$('.field_error'+custom_field_id).remove();
					$(this).after('<div class="reds custom_field_error field_error'+custom_field_id+'">Please Enter  Your '+custom_field_title+'</div>');
      			}else{
					$('.field_error'+custom_field_id).hide();
				}
			}else if(field_type == "radio" || field_type == "checkbox"){
				var checked = 0;
				$.each($('.radio_custom_field_'+custom_field_id),function(){
					if(field_type == "radio"){
						if($(this).is(":checked")){
							checked = 1;
						}
					}else if(field_type == "checkbox"){
						if($(this).is(":checked")){
							checked = 1;
						}
					}
					
				})
				
				if(checked == 0){
					err++;
					$('.field_error'+custom_field_id).remove();
					$(this).after('<div class="reds custom_field_error field_error'+custom_field_id+'">Please Choose your '+custom_field_title+'</div>');
				}else{
					$('.field_error'+custom_field_id).hide();
				}
			}
			
		})
		
		<?php if(!empty($single_record->show_term_condition) && $single_record->show_term_condition == 1) { ?>
			if($(".term_condition").is(":checked")){
				$('.term_condition_error').hide();
			}else{
				err = 1;
				$('.term_condition').after('<div class="reds term_condition_error"><?php echo $this->query_model->getStaticTextTranslation('check_terms_conditions'); ?></div>');
			}
		<?php } ?>
		
		if(err == 0){
			$("#paymentForm").attr('action','<?php echo $domain_host.$action_value; ?>');
			$('#paymentForm').submit();
			return true;
		} else{
			$("#paymentForm").attr('action','#');
			return false;
		}
	})
	
	<?php if(!empty($single_record->show_term_condition) && $single_record->show_term_condition == 1) { ?>
	$('.term_condition').click(function(){
		if($(this).is(':checked')){
			$('.term_condition_error').hide();
		}else{
			$('.term_condition_error').show();
		}
	})
	<?php } ?>
	
	
	$('.required_field').keyup(function(){
		var field_type = $(this).attr('field_type');
		var custom_field_id = $(this).attr('custom_field_id');
		var custom_field_title = $(this).attr('field_title');
		
		var field_value = $.trim($(this).val());
		
		if(field_type != "text"){
			if(field_type == "text_varchar"){
				if(field_value == '' || field_value == null){
					$('.field_error'+custom_field_id).remove();
					$(this).after('<div class="reds custom_field_error field_error'+custom_field_id+'">Please Enter Your '+custom_field_title+'</div>');
					
				}else{
					$('.field_error'+custom_field_id).hide();
				}
			}else if(field_type == "email"){
				var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
      			
      			if(field_value.length == 0 || emailfilter.test(field_value) == false){
					$('.field_error'+custom_field_id).remove();
      				$(this).after('<div class="reds custom_field_error field_error'+custom_field_id+'">Please Enter  Your '+custom_field_title+'</div>');
      			}else{
					$('.field_error'+custom_field_id).hide();
				}
			}else if(field_type == "integer"){
				var filter = /^[- +()]*[0-9][- +()0-9]*$/;
					if (filter.test(field_value)) {
						
						$('.field_error'+custom_field_id).hide();
					}else{
						$('.field_error'+custom_field_id).remove();
						$(this).after('<div class="reds custom_field_error field_error'+custom_field_id+'">Please Enter  Your '+custom_field_title+'</div>');
					}
			}
		}
		
	})
	
	
	$('.options_required_checkbox').click(function(){
		var field_type = $(this).attr('field_type');
		var custom_field_id = $(this).attr('custom_field_id');
		var custom_field_title = $(this).attr('field_title');
		
		var field_value = $.trim($(this).val());
		
		if(field_type == "radio" || field_type == "checkbox"){
				var checked = 0;
				$.each($('.radio_custom_field_'+custom_field_id),function(){
					if(field_type == "radio"){
						if($(this).is(":checked")){
							checked = 1;
						}
					}else if(field_type == "checkbox"){
						if($(this).is(":checked")){
							checked = 1;
						}
					}
					
				})
				
				if(checked == 0){
					//err++;
					$('.field_error'+custom_field_id).remove();
					$(this).after('<div class="reds custom_field_error field_error'+custom_field_id+'">Please Choose your '+custom_field_title+'</div>');
				}else{
					$('.field_error'+custom_field_id).hide();
				}
			}
			
	})
    
	
	
	$('.options_required_dropdown').change(function(){
		var field_type = $(this).attr('field_type');
		var custom_field_id = $(this).attr('custom_field_id');
		var custom_field_title = $(this).attr('field_title');
		
		var field_value = $.trim($(this).val());
		
		if(field_type == "dropdown" ){
				if(field_value == '' || field_value == null){
					$('.field_error'+custom_field_id).remove();
					$(this).after('<div class="reds custom_field_error field_error'+custom_field_id+'">Please Enter Your '+custom_field_title+'</div>');
					
				}else{
					$('.field_error'+custom_field_id).hide();
				}
			}
			
	})
    
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
        <div >
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





 
		
<div class="paymentform dojocart_page">
	<form class="row" method="post" id="paymentForm" action="#">
	<?php echo $this->query_model->getCaptchaInputFields('dojo_cart_form'); ?>
	<input type="hidden" name="miniform" value="" /> 
	  <input type="hidden" name="page_url" value="<?php echo isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';  ?>" />
     
      <input type="hidden" id="" name="is_unique_dojocart" value="1">
	  
		<div class="container">
	      <div >
			<div class="col-md-12 text-center">
			<div class="col-md-12  col-sm-12">
			<?php if($single_record->override_logo != ''){
							$dojo_cart_logo = $this->query_model->getbySpecific('tbloverride_logos','s_no', $single_record->override_logo);
							
								if(!empty($dojo_cart_logo) && !empty($dojo_cart_logo[0]->logos)){
				  ?>
				  <img src="<?php echo base_url().'upload/override_logos/'.$dojo_cart_logo[0]->logos; ?>" class="img-responsive centerlogo" alt="<?php $this->query_model->getStrReplace($dojo_cart_logo[0]->logo_alt); ?>"> 
				  
				  <?php }else{?>
				  <img src="<?php echo base_url().$site_settings->sitelogo; ?>" class="img-responsive centerlogo" alt="<?php $this->query_model->getStrReplace($site_settings->logo_alt); ?>"> 
				  <?php } } ?>
		    </div>
		    <div class="clearfix"></div>
		   
			</div>
			
			 <div class="col-md-12  col-sm-12 text-center">
			<h2 class="unique_dojocart_title">
			REGIONAL TOURNAMENT REGISTRATION
			<?php //if(!empty($single_record->product_title)) { $this->query_model->getDescReplace($single_record->product_title); } ?></h2>
            <?php if(!empty($single_record->product_description)) { $this->query_model->getDescReplace($single_record->product_description); } ?>
            <br/>
            </div>
			
			
	         <div class="col-md-8 ">
	            <h2>COMPETITOR	INFORMATION:</h2>
				<div class="row"><?php 
			if(!empty($custom_fields)){
				
				foreach($custom_fields as $custom_field){
					if(!empty($custom_field->label_text)){
						if($custom_field->type != "checkbox"){
		?>
			<div class="<?php echo !empty($custom_field->field_coloumn_class) ? $custom_field->field_coloumn_class : 'col-md-12'; ?>">

			  <div class="form-group box_1">
			
			  <label><?php $this->query_model->getDescReplace(ucfirst($custom_field->label_text)) ?>:</label>
			

			  <?php if($custom_field->type == "text" && $custom_field->right_sidebar == 0 ){ ?>
				  <input type="text" class="form-control <?php echo ($custom_field->is_field_required == 1) ? 'required_field' : ''; ?>" field_title="<?php echo ucfirst(strtolower($custom_field->label_text)); ?>"  field_type="text" custom_field_id="<?php echo $custom_field->id; ?>"  name="custom_field[<?php echo $custom_field->id ?>]" placeholder="<?php $this->query_model->getDescReplace(ucfirst($custom_field->label_text)) ?>: <?php //echo ($custom_field->is_field_required == 1) ? '*' : ''; ?>" <?php echo ($custom_field->is_field_required == 1) ? 'onBlur="textAlphabatic(this)"' : ''; ?>  error_class="field_error<?php echo $custom_field->id; ?>" error_msg="Please Enter Your <?php echo ucfirst(strtolower($custom_field->label_text)); ?>" >
			  <?php }elseif(($custom_field->type == "email" || $custom_field->type == "text_varchar" ) && $custom_field->right_sidebar == 0){ ?>
				  <input type="text" class="form-control <?php echo ($custom_field->is_field_required == 1) ? 'required_field' : ''; ?>" field_title="<?php echo ucfirst(strtolower($custom_field->label_text)); ?>"  field_type="<?php echo $custom_field->type; ?>" custom_field_id="<?php echo $custom_field->id; ?>"  name="custom_field[<?php echo $custom_field->id ?>]" placeholder="<?php $this->query_model->getDescReplace(ucfirst($custom_field->label_text)) ?>: <?php //echo ($custom_field->is_field_required == 1) ? '*' : ''; ?>">
			  <?php }elseif($custom_field->type == "integer" && $custom_field->right_sidebar == 0){ ?>
				  <input type="text" class="form-control <?php echo ($custom_field->is_field_required == 1) ? 'required_field' : ''; ?>"  field_title="<?php echo ucfirst(strtolower($custom_field->label_text)); ?>"   field_type="integer"  custom_field_id="<?php echo $custom_field->id; ?>"  name="custom_field[<?php echo $custom_field->id ?>]" placeholder="<?php $this->query_model->getDescReplace(ucfirst($custom_field->label_text)) ?>:  <?php //echo ($custom_field->is_field_required == 1) ? '*' : ''; ?>" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
			 <?php }elseif($custom_field->type == "dropdown" && $custom_field->right_sidebar == 0){ 
					$dropdownValues = !empty($custom_field->dropdown_values) ? unserialize($custom_field->dropdown_values) : '';
					if(!empty($dropdownValues)){
			  ?>
				  <select name="custom_field[<?php echo $custom_field->id ?>]" class="form-control <?php echo ($custom_field->is_field_required == 1) ? 'required_field options_required_dropdown' : ''; ?>"  custom_field_id="<?php echo $custom_field->id; ?>"  field_title="<?php echo ucfirst(strtolower($custom_field->label_text)); ?>"   field_type="dropdown" >
				  <option value="">-<?php echo ucfirst($custom_field->label_text); ?>-</option>
				  <?php foreach($dropdownValues as $value){
							if(!empty($value)){
							$value = ucfirst($value);
					  ?>
						<option value="<?php $this->query_model->getDescReplace($value) ?>"><?php $this->query_model->getDescReplace($value) ?></option>
				  <?php } } ?>
				  </select>
			  <?php } }elseif($custom_field->type == "radio" && $custom_field->right_sidebar == 0){ 
					$dropdownValues = !empty($custom_field->dropdown_values) ? unserialize($custom_field->dropdown_values) : '';
					if(!empty($dropdownValues)){
			  ?>
				 <div class="form-group checkboxlist"> 
					<label for="firstName"><?php $this->query_model->getDescReplace(ucfirst($custom_field->label_text)) ?>: <?php //echo ($custom_field->is_field_required == 1) ? '*' : ''; ?></label>
				  <?php foreach($dropdownValues as $value){
							if(!empty($value)){
							$value = ucfirst($value);
					  ?>
					  	<div class="custom-control custom-checkbox ">
					          <input type="radio" class="custom-control-input radio_custom_field_<?php echo $custom_field->id; ?> <?php echo ($custom_field->is_field_required == 1) ? 'required_field options_required_checkbox' : ''; ?>"  field_title="<?php echo ucfirst(strtolower($custom_field->label_text)); ?>"  custom_field_id="<?php echo $custom_field->id; ?>"  field_type="radio" name="custom_field[<?php echo $custom_field->id ?>]" id="same-address" value="<?php $this->query_model->getDescReplace($value) ?>">
					          <label class="custom-control-label" for="same-address"><?php $this->query_model->getDescReplace($value) ?></label>
					        </div>
				  <?php } } ?>
				</div>
			  <?php } } ?>
				

			  </div>

			</div>
			
		<?php 			}
					}
				}
			}
		?>
		
			
			   </div> </div>
			   
			   
	         <div class="col-md-4 checkbox-list">

			 <?php 
			if(!empty($custom_fields)){
				
				foreach($custom_fields as $custom_field){
					if(!empty($custom_field->label_text)){
						if($custom_field->type == "checkbox" && $custom_field->right_sidebar == 0){
		?>
		<div class="<?php echo !empty($custom_field->field_coloumn_class) ? $custom_field->field_coloumn_class : 'col-md-12'; ?> box_2 position_relative">
		<h3 class="<?php echo ($custom_field->field_coloumn_class == 'col-md-6') ? 'small' : ''; ?> "><?php $this->query_model->getDescReplace(ucfirst($custom_field->label_text)) ?>:</h3>
		
			  
			<?php $checkboxValues = !empty($custom_field->dropdown_values) ? unserialize($custom_field->dropdown_values) : '';
					if(!empty($checkboxValues)){
						foreach($checkboxValues as $value){
							if(!empty($value)){
							$value = ucfirst($value);
			  ?>
				
				<div class="custom-control custom-checkbox position_relative">
		          <input type="checkbox" class="custom-control-input  radio_custom_field_<?php echo $custom_field->id; ?>  <?php echo ($custom_field->is_field_required == 1) ? 'required_field options_required_checkbox' : ''; ?>"    field_title="<?php echo ucfirst(strtolower($custom_field->label_text)); ?>"  custom_field_id="<?php echo $custom_field->id; ?>"  field_type="checkbox" id="same-address" name="custom_field[<?php echo $custom_field->id ?>][]" value="<?php $this->query_model->getDescReplace($value) ?>" >
		          <label class="custom-control-label" for="same-address"><?php $this->query_model->getDescReplace($value) ?></label>
		        </div>
				
			  <?php } } }  ?>
			  <br/>
			</div>	
			
			
		<?php 			}
					}
				}
			}
		?>
		<div class="col-md-12">
		<?php 
		if($single_record->template != "traditional_blank"){ 
			if(!empty($custom_fields)){
				$show_right_sidebar = 0;
				foreach($custom_fields as $custom_field){
					if(!empty($custom_field->label_text)){
						if($custom_field->right_sidebar == 1){
							$show_right_sidebar = 1;
						}
					}
				}
			}
			
			if(!empty($single_record->form_right_side_text)){
				$show_right_sidebar = 1;
			}
			
			
			if($show_right_sidebar == 1){
		?>	 
		<div class="greybox 2 ">
		 <?php 
				if(!empty($custom_fields)){
				foreach($custom_fields as $custom_field){
					if(!empty($custom_field->label_text)){
						if($custom_field->right_sidebar == 1){
		?>
			
			  <div class="<?php echo ($custom_field->type == 'checkbox' || $custom_field->type == 'radio')  ? '' : 'form-group';?> box_3  position_relative">
			
			 <!-- <label><?php $this->query_model->getDescReplace(ucfirst($custom_field->label_text)) ?>:</label> -->
			

			  <?php if($custom_field->type == "text" && $custom_field->right_sidebar == 1 ){ ?>
				  <input type="text" class="form-control  <?php echo ($custom_field->is_field_required == 1) ? 'required_field' : ''; ?>" field_title="<?php echo ucfirst(strtolower($custom_field->label_text)); ?>"  field_type="text" custom_field_id="<?php echo $custom_field->id; ?>"  name="custom_field[<?php echo $custom_field->id ?>]" placeholder="<?php $this->query_model->getDescReplace(ucfirst($custom_field->label_text)) ?>: <?php //echo ($custom_field->is_field_required == 1) ? '*' : ''; ?>" onBlur="textAlphabatic(this)" error_class="field_error<?php echo $custom_field->id; ?>" error_msg="Please Enter Your <?php echo ucfirst(strtolower($custom_field->label_text)); ?>" >
				  
			  <?php }elseif(($custom_field->type == "email" || $custom_field->type == "text_varchar" ) && $custom_field->right_sidebar == 1){ ?>
				  <input type="text" class="form-control <?php echo ($custom_field->is_field_required == 1) ? 'required_field' : ''; ?>" field_title="<?php echo ucfirst(strtolower($custom_field->label_text)); ?>"  field_type="text" custom_field_id="<?php echo $custom_field->id; ?>"  name="custom_field[<?php echo $custom_field->id ?>]" placeholder="<?php $this->query_model->getDescReplace(ucfirst($custom_field->label_text)) ?>: <?php //echo ($custom_field->is_field_required == 1) ? '*' : ''; ?>">
			  <?php }elseif($custom_field->type == "integer" && $custom_field->right_sidebar == 1){ ?>
				  <input type="text" class="form-control <?php echo ($custom_field->is_field_required == 1) ? 'required_field' : ''; ?>"  field_title="<?php echo ucfirst(strtolower($custom_field->label_text)); ?>"   field_type="integer"  custom_field_id="<?php echo $custom_field->id; ?>"  name="custom_field[<?php echo $custom_field->id ?>]" placeholder="<?php $this->query_model->getDescReplace(ucfirst($custom_field->label_text)) ?>:  <?php //echo ($custom_field->is_field_required == 1) ? '*' : ''; ?>" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
			 <?php }elseif($custom_field->type == "dropdown" && $custom_field->right_sidebar == 1){ 
					$dropdownValues = !empty($custom_field->dropdown_values) ? unserialize($custom_field->dropdown_values) : '';
					if(!empty($dropdownValues)){
			  ?>
				  <select name="custom_field[<?php echo $custom_field->id ?>]" class="form-control <?php echo ($custom_field->is_field_required == 1) ? 'required_field options_required_dropdown' : ''; ?>"  custom_field_id="<?php echo $custom_field->id; ?>"  field_title="<?php echo ucfirst(strtolower($custom_field->label_text)); ?>"   field_type="dropdown" >
				  <option value="">-<?php echo ucfirst($custom_field->label_text); ?>-</option>
				  <?php foreach($dropdownValues as $value){
							if(!empty($value)){
							$value = ucfirst($value);
					  ?>
						<option value="<?php $this->query_model->getDescReplace($value) ?>"><?php $this->query_model->getDescReplace($value) ?></option>
				  <?php } } ?>
				  </select>
			  <?php } }elseif($custom_field->type == "radio"  && $custom_field->right_sidebar == 1){ 
					$dropdownValues = !empty($custom_field->dropdown_values) ? unserialize($custom_field->dropdown_values) : '';
					if(!empty($dropdownValues)){
			  ?>
				 <div class="form-group checkboxlist"> 
					<label for="firstName"><?php $this->query_model->getDescReplace(ucfirst($custom_field->label_text)) ?>: <?php //echo ($custom_field->is_field_required == 1) ? '*' : ''; ?></label>
				  <?php foreach($dropdownValues as $value){
							if(!empty($value)){
							$value = ucfirst($value);
					  ?>
					  	<div class="custom-control custom-checkbox position_relative">
					          <input type="radio" class="custom-control-input radio_custom_field_<?php echo $custom_field->id; ?> <?php echo ($custom_field->is_field_required == 1) ? 'required_field options_required_checkbox' : ''; ?>"  field_title="<?php echo ucfirst(strtolower($custom_field->label_text)); ?>"  custom_field_id="<?php echo $custom_field->id; ?>"  field_type="radio" name="custom_field[<?php echo $custom_field->id ?>]" id="same-address" value="<?php $this->query_model->getDescReplace($value) ?>">
					          <label class="custom-control-label" for="same-address"><?php $this->query_model->getDescReplace($value) ?></label>
					        </div>
				  <?php } } ?>
				</div>
			  <?php } }elseif($custom_field->type == "checkbox" && $custom_field->right_sidebar == 1){ ?>
				<h3 class="<?php echo ($custom_field->field_coloumn_class == 'col-md-6') ? 'small' : ''; ?>"><?php $this->query_model->getDescReplace(ucfirst($custom_field->label_text)) ?>:</h3>
			<?php if($single_record->template == "traditional_blank"){ ?>
				<p>PLEASE CHECK THE APPROPRIATE COMPETITION DIVISION</p>
			<?php  } ?>
			  
			<?php $checkboxValues = !empty($custom_field->dropdown_values) ? unserialize($custom_field->dropdown_values) : '';
					if(!empty($checkboxValues)){
						foreach($checkboxValues as $value){
							if(!empty($value)){
							$value = ucfirst($value);
			  ?>
				
				<div class="custom-control custom-checkbox position_relativex">
		          <input type="checkbox" class="custom-control-input  radio_custom_field_<?php echo $custom_field->id; ?>  <?php echo ($custom_field->is_field_required == 1) ? 'required_field options_required_checkbox' : ''; ?>"    field_title="<?php echo ucfirst(strtolower($custom_field->label_text)); ?>"  custom_field_id="<?php echo $custom_field->id; ?>"  field_type="checkbox" id="same-address" name="custom_field[<?php echo $custom_field->id ?>][]" value="<?php $this->query_model->getDescReplace($value) ?>" >
		          <label class="custom-control-label" for="same-address"><?php $this->query_model->getDescReplace($value) ?></label>
		        </div>
				
			  <?php } } }  ?>
			  <?php } ?>
			  </div>

			
		<?php 			}
					}
				}
			}
		?>	
		
		
		 <?php echo !empty($single_record->form_right_side_text) ? $single_record->form_right_side_text : ''; ?>
		</div>
		<?php } } ?>
		
	   
			 </div>
		<?php 
		if($single_record->template == "traditional_blank"){ 
			if(!empty($custom_fields)){
				$show_right_sidebar = 0;
				foreach($custom_fields as $custom_field){
					if(!empty($custom_field->label_text)){
						if($custom_field->right_sidebar == 1){
							$show_right_sidebar = 1;
						}
					}
				}
			}
			
			if(!empty($single_record->form_right_side_text)){
				$show_right_sidebar = 1;
			}
			
			
			if($show_right_sidebar == 1){
		?>	 
		<div class="col-md-12"><div class="greybox 1 ">
		 <?php 
				if(!empty($custom_fields)){
				foreach($custom_fields as $custom_field){
					if(!empty($custom_field->label_text)){
						if($custom_field->right_sidebar == 1){
		?>
			
			  <div class="<?php echo ($custom_field->type == 'checkbox' || $custom_field->type == 'radio')  ? '' : 'form-group';?> box_3">
			
			 <!-- <label><?php $this->query_model->getDescReplace(ucfirst($custom_field->label_text)) ?>:</label> -->
			

			  <?php if($custom_field->type == "text" && $custom_field->right_sidebar == 1 ){ ?>
				  <input type="text" class="form-control <?php echo ($custom_field->is_field_required == 1) ? 'required_field' : ''; ?>" field_title="<?php echo ucfirst(strtolower($custom_field->label_text)); ?>"  field_type="text" custom_field_id="<?php echo $custom_field->id; ?>"  name="custom_field[<?php echo $custom_field->id ?>]" placeholder="<?php $this->query_model->getDescReplace(ucfirst($custom_field->label_text)) ?>: <?php //echo ($custom_field->is_field_required == 1) ? '*' : ''; ?>" <?php echo ($custom_field->is_field_required == 1) ? 'onBlur="textAlphabatic(this)"' : ''; ?>  error_class="field_error<?php echo $custom_field->id; ?>" error_msg="Please Enter Your <?php echo ucfirst(strtolower($custom_field->label_text)); ?>" >
				  
			  <?php }elseif(($custom_field->type == "email" || $custom_field->type == "text_varchar" ) && $custom_field->right_sidebar == 1){ ?>
				  <input type="text" class="form-control <?php echo ($custom_field->is_field_required == 1) ? 'required_field' : ''; ?>" field_title="<?php echo ucfirst(strtolower($custom_field->label_text)); ?>"  field_type="<?php echo $custom_field->type; ?>" custom_field_id="<?php echo $custom_field->id; ?>"  name="custom_field[<?php echo $custom_field->id ?>]" placeholder="<?php $this->query_model->getDescReplace(ucfirst($custom_field->label_text)) ?>: <?php //echo ($custom_field->is_field_required == 1) ? '*' : ''; ?>" onBlur="dojocartFormValidation(this)"  error_class="field_error<?php echo $custom_field->id; ?>" error_msg="Please Enter Your <?php echo ucfirst(strtolower($custom_field->label_text)); ?>" >
			  <?php }elseif($custom_field->type == "integer" && $custom_field->right_sidebar == 1){ ?>
				  <input type="text" class="form-control <?php echo ($custom_field->is_field_required == 1) ? 'required_field' : ''; ?>"  field_title="<?php echo ucfirst(strtolower($custom_field->label_text)); ?>"   field_type="integer"  custom_field_id="<?php echo $custom_field->id; ?>"  name="custom_field[<?php echo $custom_field->id ?>]" placeholder="<?php $this->query_model->getDescReplace(ucfirst($custom_field->label_text)) ?>:  <?php //echo ($custom_field->is_field_required == 1) ? '*' : ''; ?>" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
			 <?php }elseif($custom_field->type == "dropdown" && $custom_field->right_sidebar == 1){ 
					$dropdownValues = !empty($custom_field->dropdown_values) ? unserialize($custom_field->dropdown_values) : '';
					if(!empty($dropdownValues)){
			  ?>
				  <select name="custom_field[<?php echo $custom_field->id ?>]" class="form-control <?php echo ($custom_field->is_field_required == 1) ? 'required_field  options_required_dropdown' : ''; ?>"  custom_field_id="<?php echo $custom_field->id; ?>"  field_title="<?php echo ucfirst(strtolower($custom_field->label_text)); ?>"   field_type="dropdown" >
				  <option value="">-<?php echo ucfirst($custom_field->label_text); ?>-</option>
				  <?php foreach($dropdownValues as $value){
							if(!empty($value)){
							$value = ucfirst($value);
					  ?>
						<option value="<?php $this->query_model->getDescReplace($value) ?>"><?php $this->query_model->getDescReplace($value) ?></option>
				  <?php } } ?>
				  </select>
			  <?php } }elseif($custom_field->type == "radio"  && $custom_field->right_sidebar == 1){ 
					$dropdownValues = !empty($custom_field->dropdown_values) ? unserialize($custom_field->dropdown_values) : '';
					if(!empty($dropdownValues)){
			  ?>
				 <div class="form-group checkboxlist"> 
					<label for="firstName"><?php $this->query_model->getDescReplace(ucfirst($custom_field->label_text)) ?>: <?php //echo ($custom_field->is_field_required == 1) ? '*' : ''; ?></label>
				  <?php foreach($dropdownValues as $value){
							if(!empty($value)){
							$value = ucfirst($value);
					  ?>
					  	<div class="custom-control custom-checkbox position_relative">
					          <input type="radio" class="custom-control-input radio_custom_field_<?php echo $custom_field->id; ?> <?php echo ($custom_field->is_field_required == 1) ? 'required_field options_required_checkbox' : ''; ?>"  field_title="<?php echo ucfirst(strtolower($custom_field->label_text)); ?>"  custom_field_id="<?php echo $custom_field->id; ?>"  field_type="radio" name="custom_field[<?php echo $custom_field->id ?>]" id="same-address" value="<?php $this->query_model->getDescReplace($value) ?>">
					          <label class="custom-control-label" for="same-address"><?php $this->query_model->getDescReplace($value) ?></label>
					        </div>
				  <?php } } ?>
				</div>
			  <?php } }elseif($custom_field->type == "checkbox" && $custom_field->right_sidebar == 1){ ?>
				<h3 class="<?php echo ($custom_field->field_coloumn_class == 'col-md-6') ? 'small' : ''; ?>" ><?php $this->query_model->getDescReplace(ucfirst($custom_field->label_text)) ?>:</h3>
			<?php if($single_record->template == "traditional_blank"){ ?>
				<p>PLEASE CHECK THE APPROPRIATE COMPETITION DIVISION</p>
			<?php  } ?>
			  
			<?php $checkboxValues = !empty($custom_field->dropdown_values) ? unserialize($custom_field->dropdown_values) : '';
					if(!empty($checkboxValues)){
						foreach($checkboxValues as $value){
							if(!empty($value)){
							$value = ucfirst($value);
			  ?>
				
				<div class="custom-control custom-checkbox position_relative">
		          <input type="checkbox" class="custom-control-input  radio_custom_field_<?php echo $custom_field->id; ?>  <?php echo ($custom_field->is_field_required == 1) ? 'required_field options_required_checkbox' : ''; ?>"    field_title="<?php echo ucfirst(strtolower($custom_field->label_text)); ?>"  custom_field_id="<?php echo $custom_field->id; ?>"  field_type="checkbox" id="same-address" name="custom_field[<?php echo $custom_field->id ?>][]" value="<?php $this->query_model->getDescReplace($value) ?>" >
		          <label class="custom-control-label" for="same-address"><?php $this->query_model->getDescReplace($value) ?></label>
		        </div>
				
			  <?php } } }  ?>
			  <?php } ?>
			  </div></div>

			
		<?php 			}
					}
				}
			}
		?>	
		
		
		 <?php echo !empty($single_record->form_right_side_text) ? $single_record->form_right_side_text : ''; ?>
		</div>
		<?php } } ?>
		
		      </div>
			  
			 
		

		<div class="col-md-8">
			 <?php if(!empty($single_record->show_term_condition) && $single_record->show_term_condition == 1) { ?>
				 <div class="offer-agreement"><p><?php if(!empty($single_record->term_condition)) { echo $single_record->term_condition; } ?></p>
				</div>
				<div class="custom-control custom-checkbox position_relative">
				<div class="checkbox">
              <label><input type="checkbox" name="term_condition" id="tc" class="term_condition" value="1"></label><?php echo $this->query_model->getStaticTextTranslation('i_agree_term_condition'); ?>
			  </div>
			  </div>
            
			 <?php } ?>
				 <?php if(!empty($twilioApi)){?>
				   <div class="checkbox twilio_checkbox">
				  <label>
					  <input type="checkbox" class="" name="twilio_checkbox" value="1"> <?php echo $twilioApi->checkbox_text ?>
				   </label>
				</div>
			   <?php } ?>
			 
	         
 <input type="text"  name="last_name" class="optinlastname" placeholder="Last Name" value="">


<input type="text" id="fax" name="fax" class="optinfax"   placeholder="Fax Number" value="">



<input type="text" id="comment" name="comment" class="optincomment"   placeholder="Write your comment here..." value="">
<input type="checkbox" class="optincheck" name="contact_me_by_phone" value="1">


<input type="text" id="website" name="website" class="optinwebsite"  placeholder="Website" value="">
<input type="text"  class="ywedobjeo" name="x2o3d_<?php echo $this->query_model->setAndGetUniqueNumberForCustomField(); ?>" value="<?php echo time(); ?>"  placeholder="Serial Number"/>
	         	<!--<button class="submit-btn submitDojocart" name="submitEmail" value="submitdojocart"><?php if(!empty($single_record->submit_btn_text)){ $this->query_model->getDescReplace($single_record->submit_btn_text); }else{ echo 'Submit Now'; }   ?></button>-->
				
				<button class="submit-btn submitDojocart"><?php if(!empty($single_record->submit_btn_text)){ $this->query_model->getDescReplace($single_record->submit_btn_text); }else{ echo 'Submit Now'; }   ?></button>
		
	           </div>
		

	        
			 
			 
			 <?php if(!empty($single_record->form_bottom_text)) { ?>
	         <div class="col-md-8">
	         	<div class="competition_box">
	         		<?php  echo $single_record->form_bottom_text; ?>
	         	</div>
	         </div>
			 <?php } ?>
	      </div>
	   </div>
   </form>
</div>


<?php $this->load->view('includes/dojocart_footer'); ?> 

<?php $forms = array('dojo_cart_form');
echo $this->query_model->getGoogleCaptchaScript($forms); ?>