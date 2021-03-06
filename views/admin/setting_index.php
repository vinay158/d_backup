<?php $this->load->view("admin/include/header"); ?>
<!-- end head contents -->
<!---wysiwyg editor script -->
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<div class="az-content-body-left advanced_page custom_full_page site_setting_page " >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Site Settings</h2>
			</div>
			
		  </div>
	  </div>
	   <div class="row row-sm program-cat-page">

          <div class="col-sm-12 col-xl-12 az-content-body-contacts"  >
			<div class="card pd-sm-20 edit-form">
			
<div class="gen-holder">
	<div class="gen-panel-holder"  style="width: 100% !important;">
	<div class="gen-panel">
		
		<div class="panel-body">
		<div class="panel-body-holder">				 
		<div class="form-holder">
		
		
<div class="mb-3 main-content-label page_main_heading">Edit: Site Settings</div>

<script language="javascript">

$(window).load(function(){
		
			if($('.override_logo').is(":checked") == 1){
				$('#AddMoreStandAlonePage').show();
			} else{
				$('#AddMoreStandAlonePage').hide();
			}
			
			if($('.braintree_hidden_cb').val() == 0){
		$('.BraintreeDetailBox').hide();
	}else{
		$('.BraintreeDetailBox').show();
	}
			
			if($('.student_section_hidden_cb').val() == 1){
				$('.student_section_box').show();
			}else{
				$('.student_section_box').hide();
			}
			
			
			if($('.international_phone_fields_hidden_cb').val() == 1){
				$('.international_phone_masking').show();
			}else{
				$('.international_phone_masking').hide();
			}
			
			if($('.countries_allow_hidden_cb').val() == 1){
				$('.show_countries_list').show();
			}else{
				$('.show_countries_list').hide();
			}
});


function fnCheckEmail(){
	var email = $.trim($("#email").val());
		
	if(email != ''){
		var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
	
		if(emailfilter.test(email) == false){
			alert("invalid email");
			return false;
		}
	}else{
		alert("Please enter an email.");
		return false;
	}
}

$(document).ready(function(){
	$("#main_title").keyup(function(){
		$("#sef_title").html($(this).val());
	});
	
	$('.override_logo').click(function(){
			if($('.override_logo').is(":checked")){
				$('#AddMoreStandAlonePage').show();
			} else{
				$('#AddMoreStandAlonePage').hide();
			}
	});
	
	$(".student_section .student_section_checkbox").click(function(){
		if($(this).hasClass("check-on")){
			$(this).removeClass("check-on");
			$(this).addClass("check-off");
			$(this).parents(".form-light-holder").children(".student_section_hidden_cb").val("0");
			$('.student_section_box').hide();
			
			var student_section_value = 0;
		}
		else
		{
			$(this).removeClass("check-off");
			$(this).addClass("check-on");
			$(this).parents(".form-light-holder").children(".student_section_hidden_cb").val("1");
			$('.student_section_box').show();
			
			var student_section_value = 1;
		}
	
	$.ajax({ 					
			type: 'POST',						
			url: 'admin/multilocation/set_muti_student_section',						
			data: { student_section_value : student_section_value}					
			}).done(function(msg){ 
			if(msg != null){
			//alert(msg);
			//setTimeout("window.location.reload()",1000);
			}
		});
})


$(".phone_number_required .phone_number_checkbox").click(function(){
		if($(this).hasClass("check-on")){
			$(this).removeClass("check-on");
			$(this).addClass("check-off");
			$(this).parents(".form-light-holder").children(".phone_number_hidden_cb").val("0");
			var phone_required = 0;
		}
		else
		{
			$(this).removeClass("check-off");
			$(this).addClass("check-on");
			$(this).parents(".form-light-holder").children(".phone_number_hidden_cb").val("1");
			var phone_required = 1;
		}
	//alert(phone_number_required); return false;
	$.ajax({ 					
			type: 'POST',						
			url: 'admin/setting/savePhoneNumberRequired',						
			data: { phone_required : phone_required}					
			}).done(function(msg){ 
			if(msg != null){
			//alert(msg);
			//setTimeout("window.location.reload()",1000);
			}
		});
})


// Developer1 Code Start


$(".https_required .https_checkbox").click(function(){
		if($(this).hasClass("check-on")){
			$(this).removeClass("check-on");
			$(this).addClass("check-off");
			$(this).parents(".form-light-holder").children(".https_hidden_cb").val("0");
			var https = 0;
		}
		else
		{
			$(this).removeClass("check-off");
			$(this).addClass("check-on");
			$(this).parents(".form-light-holder").children(".https_hidden_cb").val("1");
			var https = 1;
		}
	//alert(phone_number_required); return false;
	$.ajax({ 					
			type: 'POST',						
			url: 'admin/setting/saveHttps',						
			data: { https : https}					
			}).done(function(msg){ 
			if(msg != null){
			//alert(msg);
			//setTimeout("window.location.reload()",1000);
			}
		});
});


// Developer1 Code End


	
	$(".delete_override_logo").click(function(){

	if(confirm('Are you sure you want to delete this image?')){
		var logo_id=$(this).attr('number');
		
		
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/setting/delete_override_logo',						
		data: { id : logo_id}					
		}).done(function(msg){ 
		if(eval(msg) == 1){		
			$('.stand_page_'+logo_id).remove();
			//setTimeout("window.location.href='admin/setting'",1000);			
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});
	}

	});


		$("#unique_logo_mob").click(function(){

		var id=1;
		
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/setting/delete_unique_logo_mob',						
		data: { id : id}					
		}).done(function(msg){ 
		if(eval(msg) == 1){		
			$("#div_unique_logo_mob").hide();
			//setTimeout("window.location.href='admin/setting'",1000);			
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});

	});
	
	
		$("#favicon_icon_img").click(function(){

			var id=1;
			
			$.ajax({ 					
			type: 'POST',						
			url: 'admin/setting/delete_favicon_icon_img',						
			data: { id : id}					
			}).done(function(msg){ 
			if(eval(msg) == 1){		
				$("#div_favicon_icon_img").hide();		
			}
			else{
				alert("Oops! Unable to Delete, Please check folder permission.");
				return false;					
			}
			});

		});
		
	
		$("#delete_og_image").click(function(){

		var id=1;
		
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/setting/delete_og_image',						
		data: { id : id}					
		}).done(function(msg){ 
		if(eval(msg) == 1){		
			$("#div_og_image").hide();
			//setTimeout("window.location.href='admin/setting'",1000);			
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});

	});
	

});
</script>

<script language="javascript">

$(document).ready(function(){

$(".international_phone_fields .international_phone_fields_checkbox").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form-light-holder").children(".international_phone_fields_hidden_cb").val("0");

		$('.international_phone_masking').hide();
	}

	else

	{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form-light-holder").children(".international_phone_fields_hidden_cb").val("1");
		$('.international_phone_masking').show();
	}

	});


	
	$(".messenger_icon .messenger_icon_checkbox").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form-light-holder").children(".messenger_icon_hidden_cb").val("0");

	}

	else

	{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form-light-holder").children(".messenger_icon_hidden_cb").val("1");

	}

	});
	
	
	
	$(".tilt_bg_class .tilt_bg_class_checkbox").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form-light-holder").children(".tilt_bg_class_hidden_cb").val("0");

	}

	else

	{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form-light-holder").children(".tilt_bg_class_hidden_cb").val("1");

	}

	});
	
	
	
	$(".gdpr_compliant .gdpr_compliant_checkbox").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form-light-holder").children(".gdpr_compliant_hidden_cb").val("0");

	}

	else

	{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form-light-holder").children(".gdpr_compliant_hidden_cb").val("1");

	}

	});
	
	
	$(".download_thread .download_thread_checkbox").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form-light-holder").children(".download_thread_hidden_cb").val("0");

	}

	else

	{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form-light-holder").children(".download_thread_hidden_cb").val("1");

	}

	});
	
	
	$(".video_thread .video_thread_checkbox").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form-light-holder").children(".video_thread_hidden_cb").val("0");

	}

	else

	{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form-light-holder").children(".video_thread_hidden_cb").val("1");

	}

	});
	
	
	
	$(".countries_allow .countries_allow_checkbox").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form-light-holder").children(".countries_allow_hidden_cb").val("0");
		
		$('.show_countries_list').hide();

	}

	else

	{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form-light-holder").children(".countries_allow_hidden_cb").val("1");
		$('.show_countries_list').show();

	}

	});
	
	$(".bdy_form_location_dropdown .bdy_form_location_dropdown_checkbox").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form-light-holder").children(".bdy_form_location_dropdown_hidden_cb").val("0");

	}

	else

	{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form-light-holder").children(".bdy_form_location_dropdown_hidden_cb").val("1");

	}

	});
	
	
	
	$(".canadian_dollar .canadian_dollar_checkbox").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form-light-holder").children(".canadian_dollar_hidden_cb").val("USD");

	}

	else

	{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form-light-holder").children(".canadian_dollar_hidden_cb").val("CAD");

	}

	});
	
	
	$(".forms_programs_dropdown .forms_programs_dropdown_checkbox").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form-light-holder").children(".forms_programs_dropdown_hidden_cb").val("0");

	}

	else

	{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form-light-holder").children(".forms_programs_dropdown_hidden_cb").val("1");

	}

	});
	
	
	/*$(".email_marketing .email_marketing_checkbox").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form-light-holder").children(".email_marketing_hidden_cb").val("0");

	}

	else

	{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form-light-holder").children(".email_marketing_hidden_cb").val("1");

	}

	}); */
	
	
	$('.small_large_logo').click(function(){
		if($(this).val() == "large_logo"){
			$('.large_logo_margin_left').show();
		}else{
			$('.large_logo_margin_left').hide();
		}
	})

});

</script>

<?php 
	$display_class = '';
	if($user_level != 1){
		$display_class = 'display_class';
	}
	
	
	$social_icon_display = '';
	if($multi_location[8]->field_value == 1){ 
		$social_icon_display = 'display_class';	
	}


	//echo $social_icon_display; die;

?>

<form id="blog_form" action="" method="post" enctype="multipart/form-data">
<div class="form-light-holder student_section checkboxbtm">
		<a id="status" class="student_section_checkbox  <?php if($student_section[0]->field_value == 1) echo "check-on"; else echo "check-off"; ?>"></a>
		<h1 class="inline">Student Section</h1>
		<input type="hidden" value="<?php echo $student_section[0]->field_value; ?>" name="status" class="student_section_hidden_cb" />
</div>

<?php if(!empty($setting)): ?>
<?php foreach($setting as $setting) :?>

	<?php 
$st_sec_external_link = 'check-off';
	if(!empty($setting)){
		if($setting->st_sec_external_link == 1){
			$st_sec_external_link = 'check-on';
		}else{
			$st_sec_external_link = 'check-off';
		}
	}
?>

<div class="student_section_box">
<div class="form-light-holder checkboxbtm">
	<a id="published" class="braintree_checkbox <?php echo $st_sec_external_link; ?> " ></a>
	<h1 class="inline">Student Section External Link</h1>
	<input type="hidden" value="<?php if(!empty($setting)){ echo $setting->st_sec_external_link; } else{ echo 0; }?>" name="st_sec_external_link" class="braintree_hidden_cb" />
</div>

<div  class="BraintreeDetailBox">
<div class="form-light-holder">
	<div class="adsUrl">
	<h1>Student Section Button Text</h1>
	<input type="text" value="<?php if(!empty($setting)){ echo $setting->st_sec_button_text; }?>" name="st_sec_button_text" class="field" placeholder="Enter Your Button Text"  />
</div><div class="linkTarget">
	<h1>Student Section Button URL</h1>
	<input type="text" value="<?php if(!empty($setting)){ echo $setting->st_sec_button_url; }?>" name="st_sec_button_url" class="field"  placeholder="Enter Your Button Url"  />
</div>
	</div>


</div>

<div class="form-light-holder  d-md-flex  dual_input">
	<div class="adsUrl form-group">
		<h1>Student Section Login Button Text</h1>
		<input type="text" required="required" value="<?php echo $this->query_model->getStrReplaceAdmin($setting->ss_login_text); ?>" name="ss_login_text" id="ss_login_text" class="field" placeholder="Student Section Login Button Text"/>
	</div>
	
	<div class="linkTarget form-group">
		<h1>Student Section Login Button Class</h1>
		<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($setting->ss_login_button_class); ?>" name="ss_login_button_class" id="" class="field" placeholder="Student Section Login Button Class"/>
	</div>
</div>


<div class="form-light-holder d-md-flex  dual_input">
	<div class="adsUrl form-group">
		<h1>Student Section Login Popup Text</h1>
		<input type="text" required="required" value="<?php echo $this->query_model->getStrReplaceAdmin($setting->ss_login_popup_text); ?>" name="ss_login_popup_text" id="ss_login_popup_text" class="field" placeholder="Student Section Login Popup Text"/>
	</div>
	
	<div class="linkTarget form-group">
		<h1>Student Section Login Popup Class</h1>
		<input type="text"  value="<?php echo $this->query_model->getStrReplaceAdmin($setting->ss_login_popup_class); ?>" name="ss_login_popup_class" id="" class="field" placeholder="Student Section Login Popup Class"/>
	</div>

</div>


<div class="form-light-holder">
<div class="row row-xs align-items-center">
	<div class="col-md-4">
		<label class="form-label mg-b-0"><h1>Show Student Login Button Position</h1></label>
	</div>
	<div class="col-md-8  mg-t-5 mg-md-t-0">
	<div class="row mg-t-10">
		<div class="col-lg-3">
		  <label class="rdiobox">
			<input type="radio" name="ss_login_btn_position"  class="ss_login_btn_position"   value="navigation"  <?php echo ($setting->ss_login_btn_position == 'navigation') ? 'checked=checked' : ''; ?>>
			<span>Navigation</span>
		  </label>
		</div><!-- col-3 -->
		<div class="col-lg-9 mg-t-20 mg-lg-t-0">
		  <label class="rdiobox">
			<input type="radio" name="ss_login_btn_position" class="ss_login_btn_position"  value="header" <?php echo (empty($setting->ss_login_btn_position) || $setting->ss_login_btn_position == 'header') ? 'checked=checked' : ''; ?>> 
			<span>Header</span>
		  </label>
		</div><!-- col-3 -->
		</div>
	</div>
</div>
</div></div>

<div class="form-light-holder checkboxbtm  phone_number_required">
		<a id="status" class="phone_number_checkbox  <?php if($setting->phone_required == 1) echo "check-on"; else echo "check-off"; ?>"></a>
		<h1 class="inline">Make Phone Number Fields Required</h1>
		<input type="hidden" value="<?php echo $setting->phone_required; ?>" name="phone_required" class="phone_number_hidden_cb" />
</div>
    
    
 

<div class="form-light-holder checkboxbtm international_phone_fields">

        <a id="published" class="international_phone_fields_checkbox <?php if($setting->international_phone_fields ==1){ echo "check-on"; }else { echo "check-off";} ?>"></a>

	<h1 class="inline">Use International Phone & Address Fields</h1>

	<input type="hidden" value="<?php echo $setting->international_phone_fields?>" name="international_phone_fields" class="international_phone_fields_hidden_cb" />

</div>

<div class="form-light-holder   d-md-flex   dual_input international_phone_masking">
	<div class="adsUrl  form-group">
	<label class="ckbox">
		<input type="checkbox" value="1" name="international_phone_masking" <?php echo ($setting->international_phone_masking == 1) ? 'checked=checked' : '';?>><span>Custom Phone Number Masking?</span></label>
	</div>
	<div class="linkTarget  form-group">
		<h1>Phone Number Masking Format</h1>
		<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($setting->international_phone_masking_format); ?>" name="international_phone_masking_format" id="international_phone_masking_format" class="field contactHalfDivInput" placeholder="Phone Number Masking Format" maxlength="20"/>	<br/>
		<em>Note: International Phone Number Masking Format Example: +44 0000 000000</em>
	</div>
	
</div>

<!--<div class="form-light-holder multi_social_icons_required">
		<a id="status" class="multi_social_icons_checkbox  <?php if($setting->multi_social_icons == 1) echo "check-on"; else echo "check-off"; ?>"></a>
		<h1 class="inline">multi-social icons</h1>
		<input type="hidden" value="<?php echo $setting->multi_social_icons; ?>" name="multi_social_icons" class="multi_social_icons_hidden_cb" />
</div>-->

<div class="form-light-holder checkboxbtm messenger_icon">
		<a id="status" class="messenger_icon_checkbox  <?php if($setting->messenger_icon == 1) echo "check-on"; else echo "check-off"; ?>"></a>
		<h1 class="inline">Messenger icon</h1>
		<input type="hidden" value="<?php echo $setting->messenger_icon; ?>" name="messenger_icon" class="messenger_icon_hidden_cb" />
</div>


<!-- <div class="form-light-holder email_marketing">
		<a id="status" class="email_marketing_checkbox  <?php if($setting->email_marketing == 1) echo "check-on"; else echo "check-off"; ?>"></a>
		<h1 class="inline">Email Marketing</h1>
		<input type="hidden" value="<?php echo $setting->email_marketing; ?>" name="email_marketing" class="email_marketing_hidden_cb" />
</div> -->

<div class="form-light-holder   d-md-flex   dual_input ">
	<div class="adsUrl form-group">
		<h1>School Name</h1>
		<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($setting->title); ?>" name="title" id="title" class="field" placeholder="School Name"/>	
	</div>
	<div class="linkTarget form-group">
		<h1>H1 Tag</h1>
		<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($setting->h1_tag); ?>" name="h1_tag" id="h1_tag" class="field contactHalfDivInput" placeholder="H1 Tag"/>	
	</div>
	
</div>
<!-- DOJO 17/11 -->



<!--<div class="form-light-holder" <?php if($multi_location[0]->field_value == 1){ echo 'style="display:none"'; } ?>>
	<h1>Text next to Phone Number</h1>
	<input type="text" value="<?php if($setting->phone_number_text != ''){ echo $setting->phone_number_text; } else { echo 'free phone consultation'; }?>" name="phone_number_text" id="phone_number_text" class="field" placeholder="Text next to Phone Number"/>
</div> -->

<div class="form-light-holder" <?php if($multi_location[0]->field_value == 0){ echo 'style="display:none"'; } ?>>
	<h1>Top Bar Text</h1>
	<input type="text" value="<?php if($setting->top_bar_text != ''){ echo $this->query_model->getStrReplaceAdmin($setting->top_bar_text); } else { echo '{locations_number} Locations in {city}'; }?>" name="top_bar_text" id="top_bar_text" class="field" placeholder="Top Bar Text"/>
</div>

<style>
.callToAction{width:50%; float:left;}
.windowDropdown{width:50%; float:left;}
#window{margin-top:8px}
.hideWindow{margin-top:0}
</style>
<!-- DOJO 30/11 -->
<div class="form-new-holder  d-md-flex   dual_input "style="padding-bottom:0px !important; margin-bottom:0px !important;">
	<div class="adsUrl form-group">
	<h1>Call to Action</h1>
	<input type="text" value="<?php if($setting->call_to_action != ''){ echo $this->query_model->getStrReplaceAdmin($setting->call_to_action); } else { echo 'Try a Free Trial Class!'; }?>" name="call_to_action" id="call_to_action" class="field opreationHoursInput" placeholder="Call to Action"/>
	<p class="hideWindow">
	<label class="ckbox">
	<input type="checkbox" name="hide_window" value="hide" <?php if($setting->hide_window == 'hide') echo 'checked="checked"'; ?> /><span>Hide Call To Action Button</span></label></p>
	</div>
	<div class="linkTarget form-group">
	<h1>Call to Action Link</h1>
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($setting->url_call_to_action); ?>" name="url_call_to_action" id="url_call_to_action" class="field opreationHoursInput" placeholder="URL"/>
	<p class="">
	<label class="ckbox"><input type="checkbox" name="link_third_party_url" value="1" <?php if($setting->link_third_party_url == 1) echo 'checked="checked"'; ?> /><span>Link To Third Party URL</span></label></p>
	
	</div>
	
</div>

<div class="form-light-holder" style="padding-top:0px;">

	
	<h1>Call to Action Link Window</h1>
	<?php 
	 $windows = array ('same'=>"Same Window", 'new'=>"New Window");
	?>
	<select name="window" id="window" class="field">
	<?php foreach($windows as $window_key => $window):?>
	<option value="<?=$window_key?>" <?php if($setting->window == $window_key) echo 'selected="selected"'; ?>><?=$window?></option>
	<?php endforeach;?>
	</select>

</div>


<!-- End Code -->
<?php /*?><div class="form-light-holder">
	<h1>Phone</h1>
	<input type="text" value="<?=$setting->phone?>" name="phone" id="phone" class="field" placeholder="Phone"/>
</div>

<div class="form-light-holder">
	<h1>Address</h1>
	<input type="text" value="<?=$setting->address?>" name="address" id="address" class="field" placeholder="Address"/>
</div>

<div class="form-light-holder">
	<h1>City</h1>
	<input type="text" value="<?=$setting->city?>" name="city" id="city" class="field" placeholder="City"/>
</div>

<div class="form-light-holder">
	<h1>State</h1>
<?php 
 $state_list = array ('alabama'=>"AL", 'Alaska'=>"AK", 'Arizona'=>"AZ", 'Arkansas'=>"AR", 'California'=>"CA", 'Colorado'=>"CO", 'Connecticut'=>"CT", 'Delaware'=>"DE", 'District Of Columbia'=>"DC", 'Florida'=>"FL", 'Georgia'=>"GA", 'Hawaii'=>"HI", 'Idaho'=>"ID", 'Illinois'=>"IL", 'Indiana'=>"IN", 'Iowa'=>"IA", 'Kansas'=>"KS", 'Kentucky'=>"KY", 'Louisiana'=>"LA", 'Maine'=>"ME", 'Maryland'=>"MD", 'Massachusetts'=>"MA", 'Michigan'=>"MI", 'Minnesota'=>"MN", 'Mississippi'=>"MS", 'Missouri'=>"MO", 'Montana'=>"MT", 'Nebraska'=>"NE", 'Nevada'=>"NV", 'New Hampshire'=>"NH", 'New Jersey'=>"NJ", 'New Mexico'=>"NM", 'New York'=>"NY", 'North Carolina'=>"NC", 'North Dakota'=>"ND", 'Ohio'=>"OH", 'Oklahoma'=>"OK", 'Oregon'=>"OR", 'Pennsylvania'=>"PA", 'Rhode Island'=>"RI", 'South Carolina'=>"SC", 'South Dakota'=>"SD", 'Tennessee'=>"TN", 'Texas'=>"TX", 'Utah'=>"UT", 'Vermont'=>"VT", 'Virginia'=>"VA", 'Washington'=>"WA", 'West Virginia'=>"WV", 'Wisconsin'=>"WI", 'Wyoming'=>"WY");
?>
<select name="state" id="state" style="width: 100%; ">
<?php foreach($state_list as $row => $key):?>
<option value="<?=$key?>" <?php if($setting->state == $key) echo 'selected="selected"'; ?>><?=$row?></option>
<?php endforeach;?>
</select>
</div>

<div class="form-light-holder">
	<h1>Zip</h1>
	<input type="text" value="<?=$setting->zip?>" name="zip" id="zip" class="field" placeholder="Zip"/>
</div><?php */?>


<div class="form-light-holder <?php echo $social_icon_display; ?>">
	<div class="adsUrl">
		<h1>Facebook URL</h1>
		<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($setting->fb)?>" name="fb" id="fb" class="field" placeholder="Facebook"/>
	</div>
	<div class="linkTarget">
		<h1>Twitter URL</h1>
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($setting->twitter);?>" name="twitter" id="twitter" class="field" placeholder="twitter"/>
	</div>	
	
</div>


<div class="form-light-holder <?php echo $social_icon_display; ?>">
	<div class="adsUrl">
	<h1>Instagram URL</h1>
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($setting->instagram);?>" name="instagram" id="instagram" class="field" placeholder="Instagram"/>
	
	</div>
	<div class="linkTarget">
	<!--<h1>Google Plus URL</h1>
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($setting->gplus);?>" name="gplus" id="gplus" class="field" placeholder="Google Plus"/>-->
	<h1>LinkedIn URL</h1>
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($setting->linkedIn);?>" name="linkedIn" id="linkedIn" class="field" placeholder="LinkedIn"/>
	</div>	
	
</div>


<!-- DOJO 17/11 -->
<div class="form-light-holder  <?php echo $social_icon_display; ?>">
	<div class="adsUrl">
	<h1>Youtube URL</h1>
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($setting->youtube);?>" name="youtube" id="youtube" class="field" placeholder="Youtube"/>
	</div>
	<div class="linkTarget">
	<h1>Vimeo URL</h1>
		<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($setting->vimeo);?>" name="vimeo" id="vimeo" class="field" placeholder="Vimeo"/>
	
	</div>
	
</div>

<div class="form-light-holder  <?php echo $social_icon_display; ?>">
	<h1>Yelp URL</h1>
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($setting->yelp);?>" name="yelp" id="yelp" class="field" placeholder="Yelp"/>
</div>

<div class="form-light-holder  <?php echo $social_icon_display; ?>">
	<div class="adsUrl">
	<h1>Google Reviews</h1>
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($setting->google_reviews);?>" name="google_reviews" id="google_reviews" class="field" placeholder="Google Reviews"/>
	<br/><em>Only Add Google Place Id</em>
	</div>
	<div class="linkTarget">
	<h1>Facebook Reviews</h1>
		<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($setting->facebook_reviews);?>" name="facebook_reviews" id="facebook_reviews" class="field" placeholder="Facebook Reviews"/>
	<br/><em>Only Add Facebook Page Url</em>
	</div>
	
</div>

<!-- End Code -->
<div class="form-light-holder">
	<div class="adsUrl">
	<h1>Email</h1>
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($setting->email);?>" name="email" id="email" class="field" placeholder="Email"/>
	</div>
	<div class="linkTarget">
	<h1>Text Address</h1>
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($setting->text_address);?>" name="text_address" id="phone" class="field " placeholder="Text Address" />
	</div>
</div>
<?php if($multi_location[0]->field_value == 1){ ?>
<div class="form-light-holder">
	<h1>Home/Program Map Zoom Level</h1>
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($setting->home_program_map_zoom);?>" name="home_program_map_zoom" id="phone" class="field " placeholder="Home/Program Map Zoom Level" />
</div>
<?php } ?>
<div class="<?= $display_class ?>">
<div class="form-light-holder  d-md-flex  dual_input">
	<div class="adsUrl form-group">
		<h1>Nav Bar Logo</h1>
		<select name="override_nav_bar_logo" id="window" class="field">
		<?php foreach($override_logos as  $override_logo):?>
		<option value="<?=$override_logo->s_no?>" <?php if($setting->override_nav_bar_logo == $override_logo->s_no){ echo 'selected=selected';} ?>><?=$override_logo->logo_name?></option>
		<?php endforeach;?>
		</select>
	
	</div>
	
	<div class="linkTarget form-group">
		<h1>Footer Logo</h1>
		<select name="override_footer_logo" id="window" class="field">
		<?php foreach($override_logos as  $override_logo):?>
		<option value="<?=$override_logo->s_no?>" <?php if($setting->override_footer_logo == $override_logo->s_no){ echo 'selected=selected';} ?>><?=$override_logo->logo_name?></option>
		<?php endforeach;?>
		</select>
	</div>
</div>

<div class="form-light-holder">
	<div class="row row-xs align-items-center">
		<div class="col-md-3">
			<label class="form-label mg-b-0"><h1>small logo / large logo</h1></label>
		</div>
		<div class="col-md-9  mg-t-5 mg-md-t-0">
		<div class="row mg-t-10">
			<div class="col-lg-3">
			  <label class="rdiobox">
				<input type="radio" name="small_large_logo" class="small_large_logo"  value="small_logo" <?php echo (empty($setting->small_large_logo) || $setting->small_large_logo == 'small_logo') ? 'checked=checked' : ''; ?>> <span>Small Logo </span>
			  </label>
			</div><!-- col-3 -->
			<div class="col-lg-9 mg-t-20 mg-lg-t-0">
			  <label class="rdiobox">
				<input type="radio" name="small_large_logo"  class="small_large_logo"   value="large_logo"  <?php echo ($setting->small_large_logo == 'large_logo') ? 'checked=checked' : ''; ?>><span>Large Logo </span>
			  </label>
			</div><!-- col-3 -->
			</div>
		</div>
	</div>
</div>

<div class="form-light-holder large_logo_margin_left" style="overflow:auto;display:<?php echo ($setting->small_large_logo == "large_logo") ? 'block' : 'none';  ?>">

	<h1>margin-left</h1>
	<input type="text" value="<?=$setting->large_logo_margin_left?>" name="large_logo_margin_left" class="field" placeholder="Margin Left"  style="width: 7%"/> <span style="font-size:15px"><strong>px</strong></span><br/>
	<em>Note: Please use only integer or float value. don't use "px" in input field</em>
	
</div>


<div class="form-light-holder" style="overflow:auto;">
	
	<div class="adsUrl">
		<h1 style="padding-bottom: 5px;">Choose a Photo</h1>
		<div class="custom-file half_width_custom_file">
		<input type="file" name="userfile"  class="custom-file-input" id="customFile1"  accept="image/*" />
		<label class="custom-file-label" for="customFile">Choose file</label></div>
	
		<div>
			<img src="<?=$setting->sitelogo?>" style="width:100px" />
			<input type="hidden" name="old-logo" value="<?=$setting->sitelogo?>" id="old-logo" />
		</div>
	
	</div>
	<div class="linkTarget">
		<h1>Logo alt text</h1>
		<input type="text" value="<?=$setting->logo_alt?>" name="logo_alt" id="logo_alt" class="field" placeholder="image alt text"/>
	</div>
	
</div>


<div class="form-light-holder checkboxbtm" style="overflow:auto;">
<label class="ckbox">
<input type="checkbox" name="override_logo" class="override_logo" <?php if($setting->override_logo == 1){ echo 'checked=checked'; }?> value="1" /><span>Add Another Logo</span></label>
</div>





<div id="AddMoreStandAlonePage" style="display:none">
	<div class="form-new-holder">	
	<div class=""><h3><a href="javascript:void(0);" class="btn btn-outline-light AddMoreStandAlonePageButton">Add More Logos</a></h3></div>

<?php  if(!empty($override_logos)){ 
				$a = 2;
				foreach($override_logos as $override_logo){
				if($override_logo->id != 1){
	?>
		<div class="standPages  stand_page_<?=$override_logo->id?>">
			
			
			<div class="form-light-holder" style="overflow:auto;">
				<div class="adsUrl">
			<a href="javascript:void(0)" class="delete_override_logo" number="<?=$override_logo->id?>">Delete Override Logo</a>
						<h1 style="padding-bottom: 5px;">#<?= $a ?> Image </h1>
						<div class="custom-file half_width_custom_file">
							<input type="file" name="logos<?= $a ?>" class="custom-file-input" id="customFile<?echo $a ?>1" accept="image/*" />
						<label class="custom-file-label" for="customFile">Choose file</label></div>
						
						<?php if(!empty($override_logo->logos)): ?>
						<div><?php if($override_logo->logos != 'Null'){ ?>
							<img id="img_<?=$override_logo->id;?>" src="upload/override_logos/<?=$override_logo->logos;?>" style="width: 100px; clear:both;" />
							<?php } ?>	</div>
						<input type="hidden" name="data[<?= $a ?>][last_stand_photo]" value="<?=$override_logo->logos;?>" />
						<?php endif;?>
				</div>
				<div class="linkTarget">
						<h1>Logo Name</h1>
						<input type="text" value="<?=$override_logo->logo_name?>" name="data[<?= $a ?>][logo_name]" id="yelp" class="field" placeholder="Logo Name"/>
						
						<h1>Logo alt text</h1>
						<input type="text" value="<?=$override_logo->logo_alt?>" name="data[<?= $a ?>][logo_alt]" id="logo_alt" class="field" placeholder="image alt text"/>
						<input type="hidden" value="<?=$override_logo->s_no?>" name="data[<?= $a ?>][s_no]"/>
				</div>
			</div>
			
	</div>
	<?php 
			$a++; 
			}
		}
	 } else { 
?>	
<div class="standPages">
		<div class="form-light-holder" style="overflow:auto;">
			<div class="adsUrl">
				<h1>#1 Logo</h1>
				<h1 style="padding-bottom: 5px;">Choose a Photo</h1>
				<div class="custom-file half_width_custom_file">
					<input type="file" name="logos1"  class="custom-file-input" id="customFile11" accept="image/*" />
				<label class="custom-file-label" for="customFile">Choose file</label></div>
				
			</div>
			<div class="linkTarget">
					<h1>Logo Name</h1>
					<input type="text" value="" name="data[2][logo_name]" id="yelp" class="field" placeholder="Logo Name"/>
					
					<h1>Logo alt text</h1>
					<input type="text" value="" name="data[2][logo_alt]" id="logo_alt" class="field" placeholder="image alt text"/>
					<input type="hidden" value="1" name="data[2][s_no]"/>
			
			</div>
				
		</div>
		
</div>
<?php } ?>
</div>
</div>


</div>


<input type="hidden" class="totalAddMoreStandAlonePage"  value="<?php if(!empty($override_logos_s_no)){ echo $override_logos_s_no[0]->s_no; } else{ echo '2'; } ?>"  />

<script language="javascript">
$(document).ready(function(){

$(".form-light-holder .checkbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents(".form-light-holder").children(".hidden_cb").val("0");
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents(".form-light-holder").children(".hidden_cb").val("1");
	}
})


$(".form-light-holder .braintree_checkbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents(".form-light-holder").children(".braintree_hidden_cb").val("0");
		$('.BraintreeDetailBox').hide();
		
		// set on the value(1) of check login button
		/*$('.login_check_fields_checkbox').removeClass('check-off');
		$('.login_check_fields_checkbox').addClass('check-on');
		$('.login_check_fields_hidden_cb').val('1');*/

	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents(".form-light-holder").children(".braintree_hidden_cb").val("1");
		$('.BraintreeDetailBox').show();
		$('.AuthorizeDetailBox').hide();
		$('.authorizecheckbox').removeClass('check-on');
		$('.authorizecheckbox').addClass('check-off');
		$('.authorize_hidden_cb').val('0');

		// set off the value(0) of check login button
		/*$('.login_check_fields_checkbox').removeClass('check-on');
		$('.login_check_fields_checkbox').addClass('check-off');
		$('.login_check_fields_hidden_cb').val('0');*/


	}
})


$('.AddMoreStandAlonePageButton').click(function(){
			var totalAddMoreFeatures = $('.totalAddMoreStandAlonePage').val();
			var b = parseInt(totalAddMoreFeatures) + Number(1);
			$('.totalAddMoreStandAlonePage').val(b);
						
				//$('#AddMoreStandAlonePage').append('<div class="standPages"><div class="form-light-holder" style="overflow:auto;"><h1>#'+b+' Logo</h1><h1 style="padding-bottom: 5px;">Choose a Photo</h1><input type="file" name="logos'+b+'" id="photo" accept="image/*"  required="required" /></div><div class="form-light-holder" style="overflow:auto;"><div class="adsUrl"><h1>Logo Name</h1><input type="text" name="data['+b+'][logo_name]" id="yelp" class="field" placeholder="Logo Name"/></div><div class="linkTarget"><h1>Logo alt text</h1><input type="text" name="data['+b+'][logo_alt]" id="" class="field" placeholder="image alt text"/><input type="hidden" value="'+b+'" name="data['+b+'][s_no]"/></div></div></div>');
				
				$('#AddMoreStandAlonePage').append('<div class="standPages"><div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;"><div class="adsUrl form-group"><a href="javascript:void(0)" class="delete_override_logo" onclick="$(this).parent().parent().parent().remove();">Delete Override Logo</a><h1 style="padding-bottom: 5px;">#'+b+' Image </h1><div class="custom-file half_width_custom_file"><input type="file" name="logos2" class="custom-file-input" id="customFile1'+b+'1" accept="image/*"><label class="custom-file-label" for="customFile">Choose file</label></div></div><div class="linkTarget form-group"><h1>Logo Name</h1><input type="text" value="" name="data['+b+'][logo_name]" id="yelp" class="field" placeholder="Logo Name"><h1>Logo alt text</h1><input type="text" value="" name="data['+b+'][logo_alt]" id="logo_alt" class="field" placeholder="image alt text"><input type="hidden" value="'+b+'" name="data['+b+'][s_no]"></div></div></div>');
				
				
		});
		
		
})
</script>

<div class="form-light-holder" style="overflow:auto;">
	<div class="adsUrl">
		<h1 style="padding-bottom: 5px;">Upload a Favicon Icon</h1>
		
		<div class="custom-file half_width_custom_file">
		<input type="file" name="favicon_icon_img"  class="custom-file-input" id="customFile2"  accept="image/*" />
		<label class="custom-file-label" for="customFile">Choose file</label></div>
		
		<p>Note: Image size should be 16x16</p>
		
		<input type="hidden" name="old_favicon_icon_img" id="old_favicon_icon_img" value="<?=$setting->favicon_icon_img?>" />
		
		<div id="div_favicon_icon_img"><?php if(!empty($setting->favicon_icon_img)){ ?>
								<img id="img_<?=$setting->id;?>" src="upload/unique_logo/<?=$setting->favicon_icon_img;?>" style="width: 100px; clear:both;" />
								<?php } ?>	
			<?php if($setting->favicon_icon_img){ 
				echo "<a href='javascript:void(0);' id='favicon_icon_img'>Delete image</a>";
				}
		?>
		</div>
	
	</div>
	<div class="linkTarget">
		
		<h1 style="padding-bottom: 5px;">Upload an Og-Image</h1>
		<div class="custom-file half_width_custom_file">
		<input type="file" name="userfile3"  class="custom-file-input" id="customFile3" accept="image/*" />
		<label class="custom-file-label" for="customFile">Choose file</label></div>
		
		<p><em>Images should be 1200x1200</em></p>
		
		<input type="hidden" name="old_offer_image" id="old_offer_image" value="<?=$setting->unique_logo_mob?>" />
		
		

		
		<div id="div_og_image"><?php if(!empty($setting->og_image)){ ?>
								<img id="img_<?=$setting->id;?>" src="upload/unique_logo/<?=$setting->og_image;?>" style="width: 100px; clear:both;" />
								<?php } ?>	
			<?php if($setting->og_image){ 
				echo "<a href='javascript:void(0);' id='delete_og_image'>Delete image</a>";
				}
		?>
		</div>
			<div>
			</div>
		
	</div>
	
</div>

<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Upload an Unique Logo For Mobile Header</h1>
		<div class="custom-file half_width_custom_file">
		<input type="file" name="userfile2"  class="custom-file-input" id="customFile4" accept="image/*" />
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	
		<input type="hidden" name="old_offer_image" id="old_offer_image" value="<?=$setting->unique_logo_mob?>" />
		
		<div id="div_unique_logo_mob"><?php if(!empty($setting->unique_logo_mob)){ ?>
								<img id="img_<?=$setting->id;?>" src="upload/unique_logo/<?=$setting->unique_logo_mob;?>" style="width: 100px; clear:both;" />
								<?php } ?>	
			<?php if($setting->unique_logo_mob){ 
				echo "<a href='javascript:void(0);' id='unique_logo_mob'>Delete image</a>";
				}
		?>
		</div>
		</div>
	
	<div class="linkTarget form-group">
			<h1 style="padding-top: 5px;">Image alt text</h1>
		<input value="<?php echo $setting->unique_logo_mob_alt_text; ?>" name="unique_logo_mob_alt_text" id="" class="field" placeholder="image alt text" type="text">
			</div>
	
</div>



<!-- Developer1 Code Start -->
<div class="form-light-holder https_required checkboxbtm">
		<a id="status" class="https_checkbox  <?php if($setting->https == 1) echo "check-on"; else echo "check-off"; ?>"></a>
		<h1 class="inline">Turn https ON</h1>
		<input type="hidden" value="<?php echo $setting->https; ?>" name="https" class="https_hidden_cb" />
</div>



<!-- Developer1 Code End -->

<div class="form-light-holder">
	<h1> Google Maps API key</h1>
	<input type="text" value="<?php if($setting->map_api_key != ''){ echo $setting->map_api_key; } ?>" name="map_api_key" id="map_api_key" class="field" placeholder="Google Maps API key"/>
</div>

<div class="form-light-holder">
	<div class="row row-xs align-items-center">
		<div class="col-md-4">
			<label class="form-label mg-b-0"><h1>Horizontal Or Vertical Dropdown Menu</h1></label>
		</div>
		<div class="col-md-8  mg-t-5 mg-md-t-0">
		<div class="row mg-t-10">
			<div class="col-lg-3">
			  <label class="rdiobox">
				<input type="radio" name="horizontal_vertical_menu" class="horizontal_vertical_menu"  value="horizontal" <?php echo (empty($setting->horizontal_vertical_menu) || $setting->horizontal_vertical_menu == 'horizontal') ? 'checked=checked' : ''; ?>><span>Horizontal</span>
			  </label>
			</div><!-- col-3 -->
			<div class="col-lg-9 mg-t-20 mg-lg-t-0">
			  <label class="rdiobox">
				<input type="radio" name="horizontal_vertical_menu"  class="horizontal_vertical_menu"   value="vertical"  <?php echo ($setting->horizontal_vertical_menu == 'vertical') ? 'checked=checked' : ''; ?>><span>Vertical</span>
			  </label>
			</div><!-- col-3 -->
			</div>
		</div>
	</div>

</div>

<div class="form-light-holder tilt_bg_class checkboxbtm">
		<a id="status" class="tilt_bg_class_checkbox  <?php if($setting->tilt_bg_class == 1) echo "check-on"; else echo "check-off"; ?>"></a>
		<h1 class="inline">tilt-bg Class On Home Page</h1>
		<input type="hidden" value="<?php echo $setting->tilt_bg_class; ?>" name="tilt_bg_class" class="tilt_bg_class_hidden_cb" />
</div>


<div class="form-light-holder gdpr_compliant checkboxbtm">
		<a id="status" class="gdpr_compliant_checkbox  <?php if($setting->gdpr_compliant == 1) echo "check-on"; else echo "check-off"; ?>"></a>
		<h1 class="inline">GDPR Compliant Version</h1>
		<input type="hidden" value="<?php echo $setting->gdpr_compliant; ?>" name="gdpr_compliant" class="gdpr_compliant_hidden_cb" />
</div>


<div class="form-light-holder forms_programs_dropdown checkboxbtm" style="display:block">
		<a id="status" class="forms_programs_dropdown_checkbox  <?php if($setting->forms_programs_dropdown == 1) echo "check-on"; else echo "check-off"; ?>"></a>
		<h1 class="inline">Programs Dropdown For Forms</h1>
		<input type="hidden" value="<?php echo $setting->forms_programs_dropdown; ?>" name="forms_programs_dropdown" class="forms_programs_dropdown_hidden_cb" />
</div>

<div class="form-light-holder download_thread checkboxbtm">
		<a id="status" class="download_thread_checkbox  <?php if($setting->download_thread == 1) echo "check-on"; else echo "check-off"; ?>"></a>
		<h1 class="inline">Download Nested Menu</h1>
		<input type="hidden" value="<?php echo $setting->download_thread; ?>" name="download_thread" class="download_thread_hidden_cb" />
</div>

<div class="form-light-holder video_thread checkboxbtm">
		<a id="status" class="video_thread_checkbox  <?php if($setting->video_thread == 1) echo "check-on"; else echo "check-off"; ?>"></a>
		<h1 class="inline">Video Nested Menu</h1>
		<input type="hidden" value="<?php echo $setting->video_thread; ?>" name="video_thread" class="video_thread_hidden_cb" />
</div>

<?php if($multi_location[0]->field_value == 1){ ?>
<div class="form-light-holder bdy_form_location_dropdown checkboxbtm">
		<a id="status" class="bdy_form_location_dropdown_checkbox  <?php if($setting->bdy_form_location_dropdown == 1) echo "check-on"; else echo "check-off"; ?>"></a>
		<h1 class="inline">Birthday Page / Summer Camp Page Location Dropdown</h1>
		<input type="hidden" value="<?php echo $setting->bdy_form_location_dropdown; ?>" name="bdy_form_location_dropdown" class="bdy_form_location_dropdown_hidden_cb" />
</div>
<?php } ?>

<div class="form-light-holder countries_allow ">
		<a id="status" class="countries_allow_checkbox  <?php if($setting->allow_countries == 1) echo "check-on"; else echo "check-off"; ?>"></a>
		<h1 class="inline">Countries ?</h1>
		<input type="hidden" value="<?php echo $setting->allow_countries; ?>" name="allow_countries" class="countries_allow_hidden_cb" />
</div>

<div class="form-light-holder show_countries_list" style="display:none">
	<div class="row row-xs align-items-center">
	<?php 
		if(!empty($countries)){
			foreach($countries as $country){
	?>
	<div class="col-md-2">
	<label class="ckbox">
		<input type="checkbox" name="country_data[<?php echo $country->id ?>]" value="<?php echo $country->id ?>" <?php echo ($country->status == 1) ? "checked=checked" : ''; ?>><span><?php echo $country->country_name ?></span></label>&nbsp;&nbsp; 
	</div>
	<?php 
			} 
		}	
	?>
	</div>
</div>



<!-- <div class="form-light-holder canadian_dollar">
		<a id="status" class="canadian_dollar_checkbox  <?php if($setting->site_currency_type == 'CAD') echo "check-on"; else echo "check-off"; ?>"></a>
		<h1 class="inline">CAD Dollar?</h1>
		<input type="hidden" value="<?php echo $setting->site_currency_type; ?>" name="site_currency_type" class="canadian_dollar_hidden_cb" />
</div> -->

<?php 
	$currencies = $this->query_model->getAllCurrencies();
	
	if(!empty($currencies)){
?>
<div class="form-light-holder ">
		<h1>Currency</h1>
		<select name="site_currency_type" class="field">
	<?php  foreach($currencies as $currency){ ?>
		
			<option value="<?php echo $currency['currency_code']; ?>" <?php echo ($setting->site_currency_type == $currency['currency_code']) ? 'selected=selected' : '' ; ?>><?php echo $currency['currency']; ?></option>
		
	<?php } ?>
	</select>
</div>
<?php  } ?>

<div class="form-light-holder">
	<div class="adsUrl">
	<h1>Countries</h1>
	<?php $continents = array('Africa','America','Antarctica','Arctic','Asia','Atlantic','Australia','Europe','Indian','Pacific');

$countries =array("AF" => "Afghanistan","AL" => "Albania","DZ" => "Algeria","AS" => "American Samoa","AD" => "Andorra","AO" => "Angola","AI" => "Anguilla","AQ" => "Antarctica","AG" => "Antigua and Barbuda","AR" => "Argentina","AM" => "Armenia","AW" => "Aruba","AU" => "Australia","AT" => "Austria","AZ" => "Azerbaijan","BS" => "Bahamas","BH" => "Bahrain","BD" => "Bangladesh","BB" => "Barbados","BY" => "Belarus","BE" => "Belgium","BZ" => "Belize","BJ" => "Benin","BM" => "Bermuda","BT" => "Bhutan","BO" => "Bolivia","BA" => "Bosnia and Herzegovina","BW" => "Botswana","BV" => "Bouvet Island","BR" => "Brazil","IO" => "British Indian Ocean Territory","BN" => "Brunei Darussalam","BG" => "Bulgaria","BF" => "Burkina Faso","BI" => "Burundi","KH" => "Cambodia","CM" => "Cameroon","CA" => "Canada","CV" => "Cape Verde","KY" => "Cayman Islands","CF" => "Central African Republic","TD" => "Chad","CL" => "Chile","CN" => "China","CX" => "Christmas Island","CC" => "Cocos (Keeling) Islands","CO" => "Colombia","KM" => "Comoros","CG" => "Congo","CD" => "Congo, the Democratic Republic of the","CK" => "Cook Islands","CR" => "Costa Rica","CI" => "Cote D'Ivoire","HR" => "Croatia","CU" => "Cuba","CY" => "Cyprus","CZ" => "Czech Republic","DK" => "Denmark","DJ" => "Djibouti","DM" => "Dominica","DO" => "Dominican Republic","EC" => "Ecuador","EG" => "Egypt","SV" => "El Salvador","GQ" => "Equatorial Guinea","ER" => "Eritrea","EE" => "Estonia","ET" => "Ethiopia","FK" => "Falkland Islands (Malvinas)","FO" => "Faroe Islands","FJ" => "Fiji","FI" => "Finland","FR" => "France","GF" => "French Guiana","PF" => "French Polynesia","TF" => "French Southern Territories","GA" => "Gabon","GM" => "Gambia","GE" => "Georgia","DE" => "Germany","GH" => "Ghana","GI" => "Gibraltar","GR" => "Greece","GL" => "Greenland","GD" => "Grenada","GP" => "Guadeloupe","GU" => "Guam","GT" => "Guatemala","GN" => "Guinea","GW" => "Guinea-Bissau","GY" => "Guyana","HT" => "Haiti","HM" => "Heard Island and Mcdonald Islands","VA" => "Holy See (Vatican City State)","HN" => "Honduras","HK" => "Hong Kong","HU" => "Hungary","IS" => "Iceland","IN" => "India","ID" => "Indonesia","IR" => "Iran, Islamic Republic of","IQ" => "Iraq","IE" => "Ireland","IL" => "Israel","IT" => "Italy","JM" => "Jamaica","JP" => "Japan","JO" => "Jordan","KZ" => "Kazakhstan","KE" => "Kenya","KI" => "Kiribati","KP" => "Korea, Democratic People's Republic of","KR" => "Korea, Republic of","KW" => "Kuwait","KG" => "Kyrgyzstan","LA" => "Lao People's Democratic Republic","LV" => "Latvia","LB" => "Lebanon","LS" => "Lesotho","LR" => "Liberia","LY" => "Libyan Arab Jamahiriya","LI" => "Liechtenstein","LT" => "Lithuania","LU" => "Luxembourg","MO" => "Macao","MK" => "Macedonia, the Former Yugoslav Republic of","MG" => "Madagascar","MW" => "Malawi","MY" => "Malaysia","MV" => "Maldives","ML" => "Mali","MT" => "Malta","MH" => "Marshall Islands","MQ" => "Martinique","MR" => "Mauritania","MU" => "Mauritius","YT" => "Mayotte","MX" => "Mexico","FM" => "Micronesia, Federated States of","MD" => "Moldova, Republic of","MC" => "Monaco","MN" => "Mongolia","MS" => "Montserrat","MA" => "Morocco","MZ" => "Mozambique","MM" => "Myanmar","NA" => "Namibia","NR" => "Nauru","NP" => "Nepal","NL" => "Netherlands","AN" => "Netherlands Antilles","NC" => "New Caledonia","NZ" => "New Zealand","NI" => "Nicaragua","NE" => "Niger","NG" => "Nigeria","NU" => "Niue","NF" => "Norfolk Island","MP" => "Northern Mariana Islands","NO" => "Norway","OM" => "Oman","PK" => "Pakistan","PW" => "Palau","PS" => "Palestinian Territory, Occupied","PA" => "Panama","PG" => "Papua New Guinea","PY" => "Paraguay","PE" => "Peru","PH" => "Philippines","PN" => "Pitcairn","PL" => "Poland","PT" => "Portugal","PR" => "Puerto Rico","QA" => "Qatar","RE" => "Reunion","RO" => "Romania","RU" => "Russian Federation","RW" => "Rwanda","SH" => "Saint Helena","KN" => "Saint Kitts and Nevis","LC" => "Saint Lucia","PM" => "Saint Pierre and Miquelon","VC" => "Saint Vincent and the Grenadines","WS" => "Samoa","SM" => "San Marino","ST" => "Sao Tome and Principe","SA" => "Saudi Arabia","SN" => "Senegal","CS" => "Serbia and Montenegro","SC" => "Seychelles","SL" => "Sierra Leone","SG" => "Singapore","SK" => "Slovakia","SI" => "Slovenia","SB" => "Solomon Islands","SO" => "Somalia","ZA" => "South Africa","GS" => "South Georgia and the South Sandwich Islands","ES" => "Spain","LK" => "Sri Lanka","SD" => "Sudan","SR" => "Suriname","SJ" => "Svalbard and Jan Mayen","SZ" => "Swaziland","SE" => "Sweden","CH" => "Switzerland","SY" => "Syrian Arab Republic","TW" => "Taiwan, Province of China","TJ" => "Tajikistan","TZ" => "Tanzania, United Republic of","TH" => "Thailand","TL" => "Timor-Leste","TG" => "Togo","TK" => "Tokelau","TO" => "Tonga","TT" => "Trinidad and Tobago","TN" => "Tunisia","TR" => "Turkey","TM" => "Turkmenistan","TC" => "Turks and Caicos Islands","TV" => "Tuvalu","UG" => "Uganda","UA" => "Ukraine","AE" => "United Arab Emirates","GB" => "United Kingdom","US" => "United States","UM" => "United States Minor Outlying Islands","UY" => "Uruguay","UZ" => "Uzbekistan","VU" => "Vanuatu","VE" => "Venezuela","VN" => "Viet Nam","VG" => "Virgin Islands, British","VI" => "Virgin Islands, U.s.","WF" => "Wallis and Futuna","EH" => "Western Sahara","YE" => "Yemen","ZM" => "Zambia","ZW" => "Zimbabwe");
	?>
		<select name="country_code" id="" class="field country_code_dropdown">
			<option value="">-Select-</option>
			<?php foreach($countries as $country_code => $country){ ?>
			<option value="<?php echo $country_code; ?>" <?php echo ($setting->country_code == $country_code) ? 'selected=selected' : ''; ?> ><?php echo $country; ?></option>
			<?php } ?>
		</select>
	</div>
	<div class="linkTarget">
		<h1>Timezones</h1>
		<?php //$timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL); ?>
		<select name="timezone" id="" class="field timezone_dropdown">
				<option value="">-Select-</option>
				
			</select>
	
	</div>
</div>

<div class="form-light-holder">
	<h1>Layout Type</h1>
	<?php $front_layout_types = array('default_layout'=>'Default', 'new_layout'=> 'New Layout'); ?>
	<select name="front_layout_type" id="" class="field">
			<?php foreach($front_layout_types as $key => $layout){ ?>
			<option value="<?php echo $key; ?>" <?php echo ($setting->front_layout_type == $key) ? 'selected=selected' : ''; ?> ><?php echo $layout; ?></option>
			<?php } ?>
		</select>
</div>

<?php if($user_level==1){ ?>
	<!--<div class="form-light-holder">
		<a id="status" class="checkbox <?php if($setting->status == 1) echo "check-on"; else echo "check-off"; ?>"></a>
		<h1 class="inline">Site Running</h1>
		<input type="hidden" value="<?=$setting->status?>" name="status" class="hidden_cb" />
	</div>-->
	
	<!--<div class="form-light-holder" style="overflow:auto;">
		<input type="checkbox" name="ata_database" class="" <?php if($setting->ata_database == 1){ echo 'checked=checked'; }?> value="1" /> ATA DB
	</div> -->
	
	
	<div class="form-light-holder" style="overflow:auto;">
	
	<div class="align-items-center">
	<div class="col-md-4">
		<label class="form-label mg-b-0"><h1>Database</h1></label>
	</div>
	<div class="col-md-8  mg-t-5 mg-md-t-0">
	<div class="row mg-t-10">
		<div class="col-lg-2">
		  <label class="rdiobox">
			<input type="radio" name="ata_database" class="" <?php if($setting->ata_database == 0){ echo 'checked=checked'; }?> value="0" /><span>Non-ATA</span>
		  </label>
		</div>
		<div class="col-lg-2">
		  <label class="rdiobox">
			<input type="radio" name="ata_database" class="" <?php if($setting->ata_database == 1){ echo 'checked=checked'; }?> value="1" /><span>ATA</span>
		  </label>
		</div>
		<div class="col-lg-2">
		  <label class="rdiobox">
			<input type="radio" name="ata_database" class="" <?php if($setting->ata_database == 2){ echo 'checked=checked'; }?> value="2" /><span>CKD</span>
		  </label>
		</div>
		<div class="col-lg-2">
		  <label class="rdiobox">
			<input type="radio" name="ata_database" class="" <?php if($setting->ata_database == 3){ echo 'checked=checked'; }?> value="3" /><span>Gtma</span>
		  </label>
		</div>
		
		</div>
	</div>
</div>
	
	</div>
	
<?php } ?>

<?php endforeach;?>
<?php endif; ?>

<div class="form-white-holder" style="padding-bottom:20px;">
	<input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />
</div>
</form>



		</div>

		</div>

		</div>

	</div>

	</div>

</div>
</div>
</div>
</div>
</div>

<script>
$(window).load(function(){
	var country_code = $(".country_code_dropdown").val();
	
	get_timezone_by_country_code(country_code,'on_load');
})

	$(document).ready(function(){
		$('.country_code_dropdown').change(function(){
			var country_code = $(this).val();
			//alert(country_code);
			get_timezone_by_country_code(country_code,'change');
		})
	})
	
	function get_timezone_by_country_code(country_code, action_type){
		
		if(country_code == "" || country_code == null){
			
				alert('please select country');
			}else{
				 $.ajax({
					url : '<?=base_url();?>admin/setting/ajax_get_timezone_by_country_code',
					type :'POST',
					dataType :'json',
					data : {country_code : country_code, action: 'get_timezone_by_country_code'}
				}).done(function(result){
					
						
						$('.timezone_dropdown').empty();
						
						$.each(result, function(index, element) {
							
							var selected_timezone = '<?php echo $setting->timezone ?>';
							var selected = '';
							if(action_type == "on_load"){
								if(selected_timezone == element){
									selected = "selected = selected";
								}
							}
							$('.timezone_dropdown').append('<option value="'+element+'" '+selected+'>'+element+'</option>');
						});
						
				});
				
			}
	}
</script>
<!-- recent items -->
<?php $this->load->view("admin/include/footer");?>
