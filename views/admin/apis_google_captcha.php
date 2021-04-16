
<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->

<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>

<script language="javascript">
$(window).load(function(){
	if($('#google_captcha  .hidden_cb').val() == 0){
		$('#google_captcha .template_box').hide();
	}else{
		$('#google_captcha .template_box').show();
	}
});
$(document).ready(function(){
$("#google_captcha .form-light-holder-mailchimp .checkbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents("#google_captcha .form-light-holder-mailchimp").children("#google_captcha .hidden_cb").val("0");
		$('#google_captcha .template_box').hide();
		$('#google_captcha .api_key').attr('required',false);
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents("#google_captcha .form-light-holder-mailchimp").children("#google_captcha .hidden_cb").val("1");
		$('#google_captcha .template_box').show();
		$('#google_captcha .api_key').attr('required',true);
	}
})

$('#google_captcha .btn-save').click(function(){
		if($('#google_captcha .hidden_cb').val() == 0){
			$('#google_captcha .api_key').attr('required',false);
		} else{
			$('#google_captcha .api_key').attr('required',true);
		}
});

})
</script>



		<div class="panel-body" id="google_captcha">

		<div class="panel-body-holder">

		<div class="form-holder">



<form id="blog_form" action="<?php echo base_url(); ?>admin/apis_manager/apis_google_captcha" method="post" enctype="multipart/form-data">



<?php
	$checkbox_check = 'check-off';
	if(!empty($apis_google_captcha['detail'])){
		if($apis_google_captcha['detail']->type == 1){
			$checkbox_check = 'check-on';
		}else{
			$checkbox_check = 'check-off';
		}
		
		
	}
	
	
?>
<div class="form-light-holder-mailchimp  form-new-holder">
	<a id="published" class="checkbox <?php echo $checkbox_check; ?> " ></a>
	<h1 class="inline">Google reCaptcha Api</h1>
	<input type="hidden" value="<?php if(!empty($apis_google_captcha['detail'])){ echo $apis_google_captcha['detail']->type; } else{ echo 0; }?>" name="type" class="hidden_cb" />
</div>


<div class="template_box" style="display:none">
<div class="form-new-holder">
		<h1>Google reCaptcha Site Key</h1>
		<input type="text" value="<?php if(!empty($apis_google_captcha['detail'])){ echo $apis_google_captcha['detail']->google_captcha_site_key; }?>" name="google_captcha_site_key" class="api_key" />
</div>
<div class="form-new-holder">
		<h1>Google reCaptcha Secret Key</h1>
		<input type="text" value="<?php if(!empty($apis_google_captcha['detail'])){ echo $apis_google_captcha['detail']->google_captcha_secret_key; }?>" name="google_captcha_secret_key" class="api_key" />
</div>

<div class="form-light-holder form-new-holder" style="border-bottom:none">
	<div class="row row-xs align-items-center">
	<?php 
		$form_types = array(
							'opt_in_form'=>'Opt-in Form',
							'trial_form'=>'Trial Offer Form',
							'contact_us_form'=>'Contact Us Form',
							'dojo_cart_form'=>'Dojocart Form'
						);
	?>
	
	<?php 
		foreach($form_types as $key => $form_type){ 
			$selectedForms = (!empty($apis_google_captcha['detail']) && $apis_google_captcha['detail']->form_types) ? unserialize($apis_google_captcha['detail']->form_types) : '';
	?>
		<div class="col-md-12">
			<label class="ckbox">
			<input type="checkbox" name="form_types[<?php echo $key; ?>]" value="<?php echo $key; ?>" <?php echo (!empty($selectedForms) && in_array($key, $selectedForms)) ? 'checked=checked' : ''; ?>><span><?php echo $form_type; ?></span></label>&nbsp;&nbsp; 
		</div>
	<?php } ?>
	</div>
</div>

</div>








<div class="form-white-holder  form-new-holder">

	<input type="submit" name="google_recaptcha_update" value="Save" class="btn-save"  />

</div>

</form>

		</div>

		</div>

		</div>

	

<!------------ recent items ----------------->


