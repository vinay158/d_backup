<?php $this->load->view("admin/include/header"); ?>
<style>
	.display-none {display:none !important}
	.button1,.button2 {
		font-weight: bold;
	}
</style>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<!--<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script> -->
<!--<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>-->
<script src="js/ckeditor_full/ckeditor.js"></script>
<link id="jquiCSS" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/ui-lightness/jquery-ui.css" type="text/css" media="all">
	<link href="colorpicker/css/evol.colorpicker.min.css" rel="stylesheet" />
	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js" type="text/javascript"></script>-->
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js" type="text/javascript"></script>
	<script src="colorpicker/js/evol.colorpicker.min.js" type="text/javascript"></script>
	
	<script src="js/jquery.sticky-sidebar.js" type="text/javascript"></script>
<script>
	$(document).ready(function(){
		 CKEDITOR.replace(  'ckeditor_mini_header_title', 
									{ customConfig : 'config.js' }
							);
							
		 CKEDITOR.replace(  'ckeditor_mini_header_desc', 
									{ customConfig : 'config.js' }
							
									
		CKEDITOR.replace(  'ckeditor_full_body_desc',
									{  customConfig : 'config.js' }
						);
						
		CKEDITOR.replace(  'ckeditor_mini_trial_desc', 
									{ customConfig : 'mini_config.js' }
							);	

/**********/
		CKEDITOR.replace(  'ckeditor_full_body_desc1',
									{  customConfig : 'config.js' }
						);
						
		CKEDITOR.replace(  'ckeditor_mini_body_title1', 
									{ customConfig : 'mini_config.js' }
							);
		
		
		CKEDITOR.replace(  'ckeditor_mini_action_desc', 
									{ customConfig : 'mini_config.js' }
							);

		CKEDITOR.replace(  'ckeditor_mini_benefits_desc', 
									{ customConfig : 'mini_config.js' }
							);
							
		CKEDITOR.replace(  'ckeditor_mini_headling_desc', 
									{ customConfig : 'mini_config.js' }
							);
							
							
		CKEDITOR.replace(  'ckeditor_mini_statistics_desc', 
									{ customConfig : 'mini_config.js' }
							);
							
			CKEDITOR.replace(  'ckeditor_mini_benefits_2_desc', 
									{ customConfig : 'mini_config.js' }
							);
							
			CKEDITOR.replace(  'ckeditor_mini_benefits_3_desc', 
									{ customConfig : 'mini_config.js' }
							);
							
		CKEDITOR.replace(  'ckeditor_mini_white_stripe2_desc', 
									{ customConfig : 'mini_config.js' }
							);
							
		CKEDITOR.replace(  'ckeditor_full_program_cat_summary', 
									{ customConfig : 'config.js' }
							);
							
		CKEDITOR.replace(  'ckeditor_full_html_editor', 
									{ customConfig : 'config.js' }
							);
							
							
		CKEDITOR.replace(  'ckeditor_mini_headline1', 
									{ customConfig : 'config.js' }
						);
						
		CKEDITOR.replace(  'ckeditor_mini_headline2', 
									{ customConfig : 'config.js' }
						);
						
						
		CKEDITOR.replace(  'ckeditor_mini_headline3', 
									{ customConfig : 'config.js' }
						);
		
		CKEDITOR.replace(  'ckeditor_mini_video_desc', 
									{ customConfig : 'config.js' }
						);
						
		CKEDITOR.replace(  'ckeditor_mini_opt1_title', 
									{ customConfig : 'config.js' }
							);	

		CKEDITOR.replace(  'ckeditor_mini_question_headline', 
									{ customConfig : 'config.js' }
							);
					
	});
</script>

<script language="javascript">
$(window).load(function(){
	
	
		
	
		var program_type = $("#program_type").val();
		
		if(program_type == "birthday_page" || program_type == "summer_camp"){
			if(program_type == "birthday_page"){
				$('.button1').html("Schedule a Birthday Party");
				$('.button2').html("Call me with more information");
			}else{
				$('.button1').html("Reserve A Spot For Your Child");
				$('.button2').html("Schedule a phone consultation");
			}
			$("#redirection_button1_box").show();
			$("#redirection_button2_box").show();
			$("#redirection_default_box").hide();
			if(program_type == "birthday_page"){
				$(".GuestValuesBox").show();
			}else{
				$(".GuestValuesBox").hide();
			}
		}else{
			$("#redirection_button1_box").hide();
			$("#redirection_button2_box").hide();
			$("#redirection_default_box").show();
			$(".GuestValuesBox").hide();
		}
	
	$.each( $( ".button1_redirection_type" ), function() {
		if($(this).attr('checked') == 'checked'){
			var redirection_type = $(this).val();
	
			if(redirection_type == "dojocart"){
				$('.button1_trial_offer_list').hide();
				$('.button1_dojocart_list').show();
				$('.button1_third_party_url').hide();
				$('.button1_thankyou_page_list').hide();
			}else if(redirection_type == "third_party_url"){
				$('.button1_trial_offer_list').hide();
				$('.button1_dojocart_list').hide();
				$('.button1_third_party_url').show();
				$('.button1_thankyou_page_list').hide();
			}else if(redirection_type == "thankyou_page"){
				$('.button1_trial_offer_list').hide();
				$('.button1_dojocart_list').hide();
				$('.button1_third_party_url').hide();
				$('.button1_thankyou_page_list').show();
			}else{
				$('.button1_trial_offer_list').show();
				$('.button1_dojocart_list').hide();
				$('.button1_third_party_url').hide();
				$('.button1_thankyou_page_list').hide();
			}
		}
	});
	
	$.each( $( ".button2_redirection_type" ), function() {
		if($(this).attr('checked') == 'checked'){
		var redirection_type = $(this).val();
	
			if(redirection_type == "dojocart"){
				$('.button2_trial_offer_list').hide();
				$('.button2_dojocart_list').show();
				$('.button2_third_party_url').hide();
				$('.button2_thankyou_page_list').hide();
			}else if(redirection_type == "third_party_url"){
				$('.button2_trial_offer_list').hide();
				$('.button2_dojocart_list').hide();
				$('.button2_third_party_url').show();
				$('.button2_thankyou_page_list').hide();
			}else if(redirection_type == "thankyou_page"){
				$('.button2_trial_offer_list').hide();
				$('.button2_dojocart_list').hide();
				$('.button2_third_party_url').hide();
				$('.button2_thankyou_page_list').show();
			}else{
				$('.button2_trial_offer_list').show();
				$('.button2_dojocart_list').hide();
				$('.button2_third_party_url').hide();
				$('.button2_thankyou_page_list').hide();
			}
		}
	});
	
	
	
	$.each( $( ".redirection_type" ), function() {
		if($(this).attr('checked') == 'checked'){
			var redirection_type = $(this).val();
	
			if(redirection_type == "dojocart"){
				$('.trial_offer_list').hide();
				$('.dojocart_list').show();
				$('.third_party_url').hide();
				$('.thankyou_page_list').hide();
			}else if(redirection_type == "third_party_url"){
				$('.trial_offer_list').hide();
				$('.dojocart_list').hide();
				$('.third_party_url').show();
				$('.thankyou_page_list').hide();
			}else if(redirection_type == "thankyou_page"){
				$('.trial_offer_list').hide();
				$('.dojocart_list').hide();
				$('.third_party_url').hide();
				$('.thankyou_page_list').show();
			}else{
				$('.trial_offer_list').show();
				$('.dojocart_list').hide();
				$('.third_party_url').hide();
				$('.thankyou_page_list').hide();
			}
			
		}
	});
	
	if($('.receive_class_button_hidden_cb').val() == 0){
		$('.DetailBox').hide();
	}
	
	
	if($('.show_override_logo_hidden_cb').val() == 0){
		$('.override_logo_box').hide();
	}
	
	
	var header_videoType = $('select.header_videoType option:selected').val();
	
	if(header_videoType == "youtube_video"){
		$('.header_vimeo_video').hide();
		$('.header_youtube_video').show();
		$('.header_orButton').hide();
	}
	if(header_videoType == "vimeo_video"){
		$('.header_youtube_video').hide();
		$('.header_vimeo_video').show();
		$('.header_orButton').hide();
	}
	
	$.each( $( ".header_image_video" ), function() {
		if($(this).attr('checked') == 'checked'){
			var header_radio_button_value = $(this).val();
	
			if(header_radio_button_value == "image"){
				$('.header_welcome_video').hide();
				
			}
			if(header_radio_button_value == "video"){
				$('.header_welcome_image').hide();
			}
		}
	});
			
	
	
});
$(document).ready(function(){
	
	
	
	$('.header_videoType').change(function(){
	var header_videoType = $(this).val();
	
	if(header_videoType == "youtube_video"){
		$('.header_vimeo_video').hide();
		$('.header_youtube_video').show();
		$('.header_orButton').hide();
	}
	if(header_videoType == "vimeo_video"){
		$('.header_youtube_video').hide();
		$('.header_vimeo_video').show();
		$('.header_orButton').hide();
	}
});


$('.header_image_video').click(function(){
	var header_radio_button_value = $(this).val();
	
	if(header_radio_button_value == "image"){
		$('.header_welcome_video').hide();
		$('.header_welcome_image').show();
		
	}
	if(header_radio_button_value == "video"){
		$('.header_welcome_image').hide();
		$('.header_welcome_video').show();
	
		
	}
});


	$('#program_type').change(function(){
		var program_type = $(this).val();
		if(program_type == "birthday_page" || program_type == "summer_camp"){
			if(program_type == "birthday_page"){
				$('.button1').html("Schedule a Birthday Party");
				$('.button2').html("Call me with more information");
			}else{
				$('.button1').html("Reserve A Spot For Your Child");
				$('.button2').html("Schedule a phone consultation");
			}
			$("#redirection_button1_box").show();
			$("#redirection_button2_box").show();
			$("#redirection_default_box").hide();
			if(program_type == "birthday_page"){
				$(".GuestValuesBox").show();
			}else{
				$(".GuestValuesBox").hide();
			}
		}else{
			$("#redirection_button1_box").hide();
			$("#redirection_button2_box").hide();
			$("#redirection_default_box").show();
			$(".GuestValuesBox").hide();
		}
	});
	
	$('.button1_redirection_type').click(function(){
		var redirection_type = $(this).val();
	
			if(redirection_type == "dojocart"){
				$('.button1_trial_offer_list').hide();
				$('.button1_dojocart_list').show();
				$('.button1_third_party_url').hide();
				$('.button1_thankyou_page_list').hide();
			}else if(redirection_type == "third_party_url"){
				$('.button1_trial_offer_list').hide();
				$('.button1_dojocart_list').hide();
				$('.button1_third_party_url').show();
				$('.button1_thankyou_page_list').hide();
			}else if(redirection_type == "thankyou_page"){
				$('.button1_trial_offer_list').hide();
				$('.button1_dojocart_list').hide();
				$('.button1_third_party_url').hide();
				$('.button1_thankyou_page_list').show();
			}else{
				$('.button1_trial_offer_list').show();
				$('.button1_dojocart_list').hide();
				$('.button1_third_party_url').hide();
				$('.button1_thankyou_page_list').hide();
			}
	});
	
	$('.button2_redirection_type').click(function(){
		var redirection_type = $(this).val();
	
			if(redirection_type == "dojocart"){
				$('.button2_trial_offer_list').hide();
				$('.button2_dojocart_list').show();
				$('.button2_third_party_url').hide();
				$('.button2_thankyou_page_list').hide();
			}else if(redirection_type == "third_party_url"){
				$('.button2_trial_offer_list').hide();
				$('.button2_dojocart_list').hide();
				$('.button2_third_party_url').show();
				$('.button2_thankyou_page_list').hide();
			}else if(redirection_type == "thankyou_page"){
				$('.button2_trial_offer_list').hide();
				$('.button2_dojocart_list').hide();
				$('.button2_third_party_url').hide();
				$('.button2_thankyou_page_list').show();
			}else{
				$('.button2_trial_offer_list').show();
				$('.button2_dojocart_list').hide();
				$('.button2_third_party_url').hide();
				$('.button2_thankyou_page_list').hide();
			}
	});
	
	
	
	$('.redirection_type').click(function(){
		var redirection_type = $(this).val();
	
			if(redirection_type == "dojocart"){
				$('.trial_offer_list').hide();
				$('.dojocart_list').show();
				$('.third_party_url').hide();
				$('.thankyou_page_list').hide();
			}else if(redirection_type == "third_party_url"){
				$('.trial_offer_list').hide();
				$('.dojocart_list').hide();
				$('.third_party_url').show();
				$('.thankyou_page_list').hide();
			}else if(redirection_type == "thankyou_page"){
				$('.trial_offer_list').hide();
				$('.dojocart_list').hide();
				$('.third_party_url').hide();
				$('.thankyou_page_list').show();
			}else{
				$('.trial_offer_list').show();
				$('.dojocart_list').hide();
				$('.third_party_url').hide();
				$('.thankyou_page_list').hide();
			}
	});
	
	
	
	
$(".form-light-holder .receive_class_button_checkbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents(".form-light-holder").children(".receive_class_button_hidden_cb").val("0");
		$('.DetailBox').hide();
		
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents(".form-light-holder").children(".receive_class_button_hidden_cb").val("1");
		$('.DetailBox').show();
		
	}
	
	
})


	$(".form-light-holder .show_override_logo_checkbox").click(function(){
		if($(this).hasClass("check-on")){
			$(this).removeClass("check-on");
			$(this).addClass("check-off");
			$(this).parents(".form-light-holder").children(".show_override_logo_hidden_cb").val("0");
			$('.override_logo_box').hide();
			
		}
		else
		{
			$(this).removeClass("check-off");
			$(this).addClass("check-on");
			$(this).parents(".form-light-holder").children(".show_override_logo_hidden_cb").val("1");
			$('.override_logo_box').show();
			
		}
	
})


$('.saveProgramButton').click(function(){
		var name=$('#name').val();
		var slug = $('#slug').val();
		var type='add';
		var form =$("#blog_form");
		
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/programs/check_slug',						
		data: {type:type,slug:slug,name:name }					
		}).done(function(msg){ 
		if(msg == 0){
			
			form.submit();	
		}
		else{
			alert("Oops! Slug already exits please change it");
			return false;
					
		}
		});
})



// upload image by ajax
$('.programImage').change(function(){
	var file = $(this)[0].files[0];
	var field_name = $(this).attr('field_name');
	var upload = new Upload(file);
	
	upload.doUpload(field_name);
		
})



	var Upload = function (file) {
    this.file = file;
};

Upload.prototype.getType = function() {
    return this.file.type;
};
Upload.prototype.getSize = function() {
    return this.file.size;
};
Upload.prototype.getName = function() {
   var uniqueNumber = new Date().getTime(); 
	var imageName = uniqueNumber+this.file.name;
	//alert(imageName+'==>'+uniqueNumber);
    return imageName;
};
Upload.prototype.doUpload = function (field_name) {
	$('.saveProgramButton').attr("disabled", "disabled");
    
    var that = this;
    var formData = new FormData();

    // add assoc key values, this will be posts values
    formData.append("file", this.file, this.getName());
    formData.append("upload_file", true);
	
	//$("#"+field_name).val(this.file.name);
	//$("#"+field_name).val(this.getName());
	
    $.ajax({
        type: "POST",
        url: "admin/programs/ajaxSaveProgramImage",
        xhr: function () {
            var myXhr = $.ajaxSettings.xhr();
            if (myXhr.upload) {
				myXhr.upload.addEventListener('progress', that.progressHandling, false);
            }
            return myXhr;
        },
        success: function (data) {
			$("#"+field_name).val(data);
			$('.saveProgramButton').removeAttr("disabled");
			
            // your callback here
        },
        error: function (error) {
			$('.saveProgramButton').removeAttr("disabled");
			
            // handle error
        },
        async: true,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        timeout: 60000
    });
};

Upload.prototype.progressHandling = function (event) {
	
    
};



})
</script>

<div class="az-content-body-left advanced_page" >

       <div class="row row-sm">

          <div class="col-sm-12 col-xl-12"  >
			<div class="card pd-sm-20 program-cat-page program-detail-page">
				<div class="container">
	  
	  
        
    <div class="az-content az-content-app az-content-contacts pd-b-0">
      <div class="container">
        <div class="az-content-left az-content-left-contacts">


         <div class="az-mail-header">
            <div>
              <h4 class="az-content-title mg-b-5">Program Sections</h4>
			   
				  
            </div>
            
          </div>
		
		<?php $page_url = '';//base_url().'admin/programs/edit/'.$details[0]->id.'/view/'.$details[0]->category; ?>
          <div id="azContactList" class="az-contacts-list">
			
			<a href="<?php echo $page_url; ?>#ProgramBasicSection" class="az-contact-item">
              <div class="az-contact-body">
                <h6>Program Info & Category Summary</h6>
              </div><!-- az-contact-body -->
				
            </a>
			
			<!--<a href="<?php echo $page_url; ?>#ProgramCatSummary" class="az-contact-item">
              <div class="az-contact-body">
                <h6>Program Category Summary</h6>
              </div>
				
            </a> --->
			
            <a href="<?php echo $page_url; ?>#QuestionHeadline" class="az-contact-item">
              <div class="az-contact-body">
                <h6>Question Headline Section 	</h6>
              </div><!-- az-contact-body -->
				
            </a><!-- az-contact-item -->
			
            <a href="<?php echo $page_url; ?>#Headersection" class="az-contact-item ">
              <div class="az-contact-body">
                 <h6>Header Section</h6>
              </div><!-- az-contact-body -->
			  
            </a><!-- az-contact-item -->
			<a href="<?php echo $page_url; ?>#WhiteStripeFirstSection" class="az-contact-item ">
			
              <div class="az-contact-body">
                <h6>White Stripe Under Header Section</h6>
              </div><!-- az-contact-body -->
				
            </a><!-- az-contact-item -->
			
			<a href="<?php echo $page_url; ?>#BenefitsRowImagesFirstSection" class="az-contact-item">
              <div class="az-contact-body">
                <h6>Benefits with 3 images Section</h6>
              </div><!-- az-contact-body -->
				
            </a><!-- az-contact-item -->
			
			<a href="<?php echo $page_url; ?>#videorowsection" class="az-contact-item">
              <div class="az-contact-body">
                <h6>Video Row Section</h6>
              </div><!-- az-contact-body -->
				 
            </a><!-- az-contact-item -->
			
			<a href="<?php echo $page_url; ?>#Calltoaction3ImagesSection" class="az-contact-item">
              <div class="az-contact-body">
                <h6>Call to Action with 3 Images Section</h6>
              </div><!-- az-contact-body -->
				
            </a>
			
			<a href="<?php echo $page_url; ?>#HeadingboxesSection" class="az-contact-item">
              <div class="az-contact-body">
                <h6>Heading with 3 boxes Section</h6>
              </div><!-- az-contact-body -->
				  
            </a><!-- az-contact-item -->
			
			
			<a href="<?php echo $page_url; ?>#StatisticsimagesSection" class="az-contact-item">
              <div class="az-contact-body">
                <h6>Statistics with 3 images Section</h6>
              </div><!-- az-contact-body -->
				  
            </a><!-- az-contact-item -->
			
			
			
			<a href="<?php echo $page_url; ?>#BenefitsRowImagesSecondSection" class="az-contact-item">
              <div class="az-contact-body">
                <h6>Benefits Row2 with 3 Images Section</h6>
              </div><!-- az-contact-body -->
				 
            </a><!-- az-contact-item -->
			
			<a href="<?php echo $page_url; ?>#WhiteStripeSecondSection" class="az-contact-item ">
			
              <div class="az-contact-body">
                <h6>White Stripe Row 2 Section</h6>
              </div><!-- az-contact-body -->
				
            </a>
			
			<a href="<?php echo $page_url; ?>#BenefitsRowImagesThirdSection" class="az-contact-item">
              <div class="az-contact-body">
                <h6>Benefits Row2 with 3 Images Section</h6>
              </div><!-- az-contact-body -->
				 
            </a>
			
			<a href="<?php echo $page_url; ?>#EmailOptin" class="az-contact-item">
              <div class="az-contact-body">
                <h6>Email Opt-in #1 & #2</h6>
              </div><!-- az-contact-body -->
				 
            </a>
			
			
			
			<a href="<?php echo $page_url; ?>#testimonials_faqs" class="az-contact-item">
              <div class="az-contact-body">
                <h6>Testimonials & Faqs</h6>
              </div><!-- az-contact-body -->
				 
            </a><!-- az-contact-item -->
			
			
			<a href="<?php echo $page_url; ?>#Htmleditor_Basic_detail" class="az-contact-item">
              <div class="az-contact-body">
                <h6>Html Editor & Basic Detail</h6>
              </div><!-- az-contact-body -->
            </a>
			
          </div><!-- az-contacts-list -->

        </div> <!-- az-content-left -->
        <div class="az-content-body az-content-body-contacts">
			
				<div class="az-mail-header">
            <div>
              <h4 class="az-content-title mg-b-5">ADD PROGRAM</h4>
            </div>
            
          </div>
				
				<div class=" edit-form edit_form_box">
				

<form id="blog_form" action="" method="post" enctype="multipart/form-data">
<div class="gen-holder">
	<div class="gen-panel-holder"  style="width: 100% !important;">
	<div class="gen-panel">
		
		
		<style type="text/css">
		#sidebar{ z-index:999}
#sidebar .sidebar__inner {
   background: #fff;
   padding: 10px 13px 0px;
   float: left;
   position: relative;
   left: 10px;
  box-shadow: -5px -1px 17px #ccc;
   z-index: 999 !important;
}

#sidebar .sidebar__inner .form-white-holder{ padding:10px 5px !important;}		
#sidebar .inner-wrapper-sticky .btn-save{ display:inline-block; float:none !important;}	

.label-text{padding-top:35px;font-size:18px;color:#a438ff;padding-bottom: 5px;}	
		
</style>
		
		<!--<div id="sidebar">
			<div class="sidebar__inner">
<div class="form-white-holder" style="padding-bottom:20px;">
	
	<input type="button" name="update" value="Save" class="btn-save saveProgramButton"  action_type="save" />
	<input type="button" name="update" value="Save & Continue" class="btn-save saveProgramButton" action_type="save_and_continue"  style="width:160px;margin-left:3px"/>
</div>
</div>
</div> -->

		<div class="panel-body"  id="content">
		<div class="panel-body-holder">
		<div class="form-holder">

<script language="javascript">

$(window).load(function(){
		var check_stand_alone_page = $('.checkbx2').val();
		if(check_stand_alone_page == 0){
			$('.stand_alone_page').hide();
		}
		
		if($('.checkbx1').val() == 1){
			$('#landing_page_box').show();
		} else if($('.checkbx1').val() == 0){
			$('#landing_page_box').hide();
			
		}
		
	
		
	
$.each( $( ".radio" ), function() {
			if($(this).attr('checked') == 'checked'){
				if($(this).val() == 1){
					$('.paid_trial').show();
				} else {
					$('.paid_trial').hide();
				}
			}
		});
		
		
		$.each( $( ".image_video" ), function() {
		if($(this).attr('checked') == 'checked'){
			var radio_button_value = $(this).val();
	
			if(radio_button_value == "image"){
				$('.welcome_video').hide();
			}
			if(radio_button_value == "video"){
				$('.welcome_image').hide();
			}
		}
	});
	
	var videoType = $('select.videoType option:selected').val();
	
	if(videoType == "youtube_video"){
		$('.vimeo_video').hide();
		$('.youtube_video').show();
		$('.orButton').hide();
	}
	if(videoType == "vimeo_video"){
		$('.youtube_video').hide();
		$('.vimeo_video').show();
		$('.orButton').hide();
	}
				
	

	});
	
	
$(document).ready(function(){
	$("#main_title").keyup(function(){
		$("#sef_title").html($(this).val());
	});
	
	
	$('.image_video').click(function(){
	var radio_button_value = $(this).val();
	
	if(radio_button_value == "image"){
		$('.welcome_video').hide();
		$('.welcome_image').show();
	}
	if(radio_button_value == "video"){
		$('.welcome_image').hide();
		$('.welcome_video').show();
	}
});
	
	
$('.videoType').change(function(){
	var videoType = $(this).val();
	
	if(videoType == "youtube_video"){
		$('.vimeo_video').hide();
		$('.youtube_video').show();
		$('.orButton').hide();
	}
	if(videoType == "vimeo_video"){
		$('.youtube_video').hide();
		$('.vimeo_video').show();
		$('.orButton').hide();
	}
});




});
</script>
<div class="page-section" id="ProgramBasicSection">
<div class="mb-3 main-content-label">Program Basic Information</div>
<div class="form-light-holder">
	<a id="published" class="show_override_logo_checkbox check-off" ></a>
	<h1 class="inline">Show Override Logo</h1>
	<input type="hidden" value="0" name="show_override_logo" class="show_override_logo_hidden_cb" />
</div>

<div class="form-light-holder override_logo_box">
<h1>Override Logo</h1>
	<select name="override_logo" id="override_logo" class="field">
	<?php foreach($override_logos as  $override_logo):?>
	<option value="<?=$override_logo->s_no?>"><?=$override_logo->logo_name?></option>
	<?php endforeach;?>
	</select>
</div>
<div class="form-light-holder  d-md-flex  dual_input">
	<div class="adsUrl form-group">
		<h1>Program Name</h1>
		<input type="text" value="" name="name" id="name" class="field" placeholder="Enter your program name here"/>
	</div>
	<div class="linkTarget form-group">
		<h1>Button Name</h1>
		<input type="text" value="" name="btnname" id="btnname" class="field" placeholder="Enter your button name here"/>
	</div>
	
</div>
<div class="form-light-holder  d-md-flex  dual_input">
<div class="adsUrl form-group">
	<h1>Slug (URL Rewriting)</h1>
	<input type="text" value="" name="slug" id="slug" class="field" placeholder="Enter your slug here"/>
	</br></em>Note: Slug will automatically generate from program name if left blank</em>
	
	</div>
	<div class="linkTarget form-group">
		<h1>Ages</h1>
	<input type="text" value="" name="ages" id="" class="field" placeholder="Enter Ages here" />
	</div>
	
	
</div>
<div class="form-light-holder  d-md-flex  dual_input" style="">
		<div class="adsUrl form-group">
			<h1>Category</h1>
			<select name="category" class="field" id="category" style="" >
			<?php
			if(!empty($cat)):
			foreach($cat as $cat):
			?>
			<option value="<?=$cat->cat_id?>" <?php if($this->uri->segment(4) == $cat->cat_id) echo "selected='selected'";?>><?=$cat->cat_name?></option>
			<?php
			endforeach;
			endif;
			?>
			</select>
		</div>
	<div class="linkTarget form-group">
	<h1>Program Type</h1>
		<select name="program_type" id="program_type" class="field" style="" >
		<option value="program_page" >Program Page</option>
		<option value="birthday_page"  >Birthday Page</option>
		<option value="summer_camp"  >Summer Camp</option>
		</select>
	</div>
	
</div>


<div id="redirection_default_box">
<div class="form-light-holder d-md-flex  dual_input">
	<div class="adsUrl form-group">
	<h1>Redirection Type</h1>
	<label class="rdiobox">
	<input type="radio" value="trial_offer" class="redirection_type" name="redirection_type" <?php echo (empty($cat_detail) || empty($cat_detail[0]->redirection_type) ||  $cat_detail[0]->redirection_type == "trial_offer") ? "checked=checked" : '';?> /><span>Trial Offer</span></label>
	
	<label class="rdiobox">
	<input type="radio" value="dojocart" class="redirection_type" name="redirection_type" <?php echo (!empty($cat_detail) && $cat_detail[0]->redirection_type == "dojocart") ? "checked=checked" : ''; ?> /><span>Dojocart</span></label>
	
	<label class="rdiobox">
	<input type="radio" value="thankyou_page" class="redirection_type" name="redirection_type" <?php echo (!empty($cat_detail) && $cat_detail[0]->redirection_type == "thankyou_page") ? "checked=checked" : ''; ?> /><span>Thank you Page</span></label>
	
	<label class="rdiobox">
	<input type="radio" value="third_party_url" class="redirection_type" name="redirection_type"  <?php echo (!empty($cat_detail) && $cat_detail[0]->redirection_type == "third_party_url") ? "checked=checked" : ''; ?> /><span>Third Party Url</span></label>
	</div>
	
	<div class="linkTarget form-group">
		<h1>Redirection Link</h1>
		<div class="trial_offer_list" style="display:none">
			<select name="trial_offer_id" class="field" >
			<option value="">-Select-</option>
			<?php foreach($trialCategories as  $trialCategory):?>
			<option value="<?=$trialCategory->id?>"  <?php echo (!empty($cat_detail) && $cat_detail[0]->redirection_type == "trial_offer" && $trialCategory->id == $cat_detail[0]->trial_offer_id) ? "selected=selected" : ''; ?>><?=$trialCategory->name?></option>
			<?php endforeach;?>
			</select>
		</div>
		<div class=" dojocart_list" style="display:none">
			<select name="dojocart_id" class="field">
			<option value="">-Select-</option>
			<?php foreach($dojocarts as  $dojocart):?>
			<option value="<?=$dojocart->id?>" <?php echo (!empty($cat_detail) && $cat_detail[0]->redirection_type == "dojocart" && $dojocart->id == $cat_detail[0]->dojocart_id) ? "selected=selected" : ''; ?>><?=$dojocart->product_title?></option>
			<?php endforeach;?>
			</select>
		</div>

		<div class="thankyou_page_list" style="display:none">
			<select name="thankyou_page_id" class="field">
			<option value="">-Select-</option>
			<?php foreach($thankyou_pages as  $thankyou_page):?>
			<option value="<?=$thankyou_page->id?>"   <?php echo (!empty($cat_detail) && $cat_detail[0]->redirection_type == "thankyou_page" && $thankyou_page->id == $cat_detail[0]->thankyou_page_id) ? "selected=selected" : ''; ?>><?=$thankyou_page->title?></option>
			<?php endforeach;?>
			</select>
		</div>


		<div class="third_party_url" style="display:none">
			<input type="text" name="third_party_url" value="<?php echo (!empty($cat_detail) && $cat_detail[0]->redirection_type == "third_party_url") ? $cat_detail[0]->third_party_url : ''; ?>">
		</div>
	</div>
</div>

</div>





<div id="redirection_button1_box" style="display:none">
<h1 class="button1">Button 1</h1>
<div class="form-light-holder d-md-flex  dual_input">
	<div class="adsUrl form-group">
		
		<h1>Redirection Type</h1>
		<label class="rdiobox">
		<input type="radio" value="trial_offer" class="button1_redirection_type" name="button1_redirection_type" checked /><span>Trial Offer</span></label>
		<label class="rdiobox">
		<input type="radio" value="dojocart" class="button1_redirection_type" name="button1_redirection_type" /><span>Dojocart</span></label>
		<label class="rdiobox">
		<input type="radio" value="thankyou_page" class="button1_redirection_type" name="button1_redirection_type" /><span>Thank you Page</span></label>
		<label class="rdiobox">
		<input type="radio" value="third_party_url" class="button1_redirection_type" name="button1_redirection_type"/><span>Third Party Url</span></label>
	</div>
	<div class="linkTarget form-group">
		<h1>Redirection Link</h1>	
		<div class="button1_trial_offer_list" style="display:none">
			<select name="button1_trial_offer_id" class="field" >
			<option value="">-Select-</option>
			<?php foreach($trialCategories as  $trialCategory):?>
			<option value="<?=$trialCategory->id?>" ><?=$trialCategory->name?></option>
			<?php endforeach;?>
			</select>
		</div>
		<div class=" button1_dojocart_list" style="display:none">
			<select name="button1_dojocart_id" class="field">
			<option value="">-Select-</option>
			<?php foreach($dojocarts as  $dojocart):?>
			<option value="<?=$dojocart->id?>" ><?=$dojocart->product_title?></option>
			<?php endforeach;?>
			</select>
		</div>

		<div class="button1_thankyou_page_list" style="display:none">
			<select name="button1_thankyou_page_id" class="field">
			<option value="">-Select-</option>
			<?php foreach($thankyou_pages as  $thankyou_page):?>
			<option value="<?=$thankyou_page->id?>"><?=$thankyou_page->title?></option>
			<?php endforeach;?>
			</select>
		</div>


		<div class="button1_third_party_url" style="display:none">
			<input type="text" name="button1_third_party_url" value="">
		</div>
	
	</div>
</div>

</div>





<div id="redirection_button2_box" style="display:none">
<h1 class="button2">Button 2</h1>
<div class="form-light-holder  d-md-flex  dual_input">
	<div class="adsUrl form-group">
	<h1>Redirection Type</h1>
	<label class="rdiobox">
		<input type="radio" value="trial_offer" class="button2_redirection_type" name="button2_redirection_type" checked /><span>Trial Offer</span></label>
		<label class="rdiobox">
		<input type="radio" value="dojocart" class="button2_redirection_type" name="button2_redirection_type"/><span>Dojocart</span></label>
		<label class="rdiobox">
		<input type="radio" value="thankyou_page" class="button2_redirection_type" name="button2_redirection_type"  /><span>Thank you Page</span></label>
		<label class="rdiobox">
		<input type="radio" value="third_party_url" class="button2_redirection_type" name="button2_redirection_type" /><span>Third Party Url</span></label>
	</div>
	<div class="linkTarget form-group">
		<h1>Redirection Link</h1>
		<div class="button2_trial_offer_list" style="display:none">
			<select name="button2_trial_offer_id" class="field" >
			<?php foreach($trialCategories as  $trialCategory):?>
			<option value="<?=$trialCategory->id?>"><?=$trialCategory->name?></option>
			<?php endforeach;?>
			</select>
		</div>
		<div class="button2_dojocart_list" style="display:none">
			<select name="button2_dojocart_id" class="field">
			<?php foreach($dojocarts as  $dojocart):?>
			<option value="<?=$dojocart->id?>" ><?=$dojocart->product_title?></option>
			<?php endforeach;?>
			</select>
		</div>

		<div class="button2_thankyou_page_list" style="display:none">
			<select name="button2_thankyou_page_id" class="field">
			<?php foreach($thankyou_pages as  $thankyou_page):?>
			<option value="<?=$thankyou_page->id?>"><?=$thankyou_page->title?></option>
			<?php endforeach;?>
			</select>
		</div>


		<div class="button2_third_party_url" style="display:none">
			<input type="text" name="button2_third_party_url" value="">
		</div>
	</div>
</div>

</div>


<div class="form-light-holder">
		<h1>Connect to trial offer category</h1>
			<select name="connect_trial_offer_id" class="field" >
			<option value="0" >--Select--</option>
			<?php foreach($trialCategories as  $trialCategory):?>
			<option value="<?=$trialCategory->id?>" ><?=$trialCategory->name?></option>
			<?php endforeach;?>
			</select>
		</div>


<div class="form-light-holder display-none">
        <h1>Features</h1>
		<div id="AddMoreFeatures">
			<div class=""><h3><a href="javascript:void(0);" class="AddMoreButton">Add More</a></h3></div>
			
			&#10687;<input type="text"  name="features[1]" id="features" value="" class="field"  placeholder="Enter Features here"/><br>
			
		</div>
    </div>
	
	
	
<div class="form-light-holder display-none" style="">
	<h1>Description</h1>
	<!--<textarea name="text" class="textarea" id="frm-text"></textarea>
	--><textarea name="text" id="ckeditor_full_body_desc" class="ckeditor" id="frm-text"></textarea>
</div>

<div class="form-light-holder display-none" style="overflow:auto;">
	<h1 style="padding-bottom: 5px;">Choose a Photo</h1>
	<input type="file" name="userfile" id="photo" accept="image/*" />
		<div>
		</div>
</div>

<div class="mb-3 main-content-label">Program Category Summary</div>



<div class="form-light-holder">
	<h1>Summary</h1>
	<textarea name="program_cat_summary" id="ckeditor_full_program_cat_summary" class="text ckeditor" style="width:50%"></textarea>
	
</div>

<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Image</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="program_cat_image"  class="custom-file-input" id="customFile1" accept="image/*" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
	
	</div>
	<div class="linkTarget form-group">
		<h1 >Image alt text</h1>
		<input value="" name="program_cat_image_alt_text" id="" class="field"  type="text">
		</div>
	
</div>
<div class="form-light-holder  d-md-flex  dual_input">
	<div class="adsUrl form-group">
<h1>PHOTO ON RIGHT/ LEFT</h1>
	<select name="cat_photo_side" class="field">
		<option value="right">Photo on Right</option>
		<option value="left" selected="selected">Photo on Left</option>
	</select>
	</div>
	<div class="linkTarget form-group">
		<h1>Image Top Spacing (pixels)</h1>
		<input type="text" name="program_cat_img_top_spacing" id="program_cat_img_top_spacing" class="field  img_top_spacing" placeholder=""  style="width: 100% !important" value=""/> <!--<span style="font-size:15px"><strong>px</strong></span>--><br/>
		<em>Note: Please use only integer or float value. don't use "px" in<br/>  input field</em>
	</div>
</div>

</div>

<div style="display:<?php echo ($multiSchool == 1) ? 'block' :'none'; ?>">
<div class="mb-3 main-content-label">Featured Program Image Section</div>
<div class="form-light-holder d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Featured Program Image</h1>
	<!--<input type="file" name="benefits_3_background_image" id="photo_left" accept="image/*" /> -->
	<div class="custom-file half_width_custom_file">
		<input type="file" field_name="featured_program_img" class="programImage custom-file-input" id="customFile2" accept="image/*" />
	<input type="hidden" name="featured_program_img" id="featured_program_img"   />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
	
	
	</div>
	<div class="linkTarget form-group">
	<h1 >Image alt text</h1>
	<input value="" name="featured_program_img_alt_text" id="" class="field"  type="text">
	</div>
</div>
</div>


<div class="form-light-holder form3checkbox">

	<a id="show_learn_more" class="checkbox3 check-on"></a>

<h1 class="inline">Show Learn More Button</h1>
	
	
	<input type="hidden" value="1" name="show_learn_more" class="hidden_cb3" />

</div>


<div style="display:<?php if($user_level != 1 ){ echo 'none'; } ?>">
<div class="form-light-holder landing_page">
	
	<a id="free_trials" class="checkbox_landing_page check-off"></a>
	<h1 class="inline">Link to other landing page</h1>
	<input type="hidden"  name="landing_checkbox" class=" stand_alone_page_button checkbx1" />
</div>
<div id="landing_page_box" style="display:none">

<div class="form-light-holder">
<div class="row row-xs align-items-center">
<div class="col-md-5">
	<h1>Select Program</h1>
	
		<select name="landing_program" id="" class="field landing_program"  style="width:100% !important" >
			<option value="">-Select Program-</option>
			<?php foreach($leanding_programs as $stand_program){
					 $cateogry_detail = $this->query_model->getbySpecific('tblcategory','cat_id', $stand_program->category);
						$program_url = '';
						if($stand_program->landing_checkbox == 1){
							if(!empty($stand_program->landing_program)){
								$program_url = $stand_program->landing_program;
							}elseif(!empty($stand_program->landing_page_url)){
								$program_url = $stand_program->landing_page_url;
							}
						}else{
							$program_url = $program_slug.'/'.$cateogry_detail[0]->cat_slug.'/'.$stand_program->program_slug;
						}
			?>
				<option number="<?php echo $stand_program->id ?>" value="<?php echo $program_url; ?>"><?= $stand_program->program ?></option>
				
			<?php  } ?>
		</select>
		<input type="hidden" name="landing_program_id" class="landing_program_id" value="" />
	</div>
	<div class="col-md-2 text-center">
	<h1 class="orbtn">OR</h1>
	</div>
	<div class="col-md-5">
	<h1>Landing Page Url</h1>
		<input type="text" value="" name="landing_page_url" class="field landing_page_url full_width_input" placeholder="Enter Url here" />
		
	</div>
	<!--<div class="col-md-12 text-right">
	<p class="urlErrorMsg"></p>
	</div>  -->
</div>		
</div>		
	</div>	
	</div>	
	
	
	

<div class="form-light-holder receive_class_button">
	<a id="published" class="receive_class_button_checkbox check-off" ></a>
	<h1 class="inline">receive class schedule & pricing</h1>
	<input type="hidden" value="0" name="receive_class_button" class="receive_class_button_hidden_cb" />
</div>
<div  class="DetailBox">
<div class="form-light-holder d-md-flex  dual_input">
	
    <div class="adsUrl form-group">
		<h1>Button Text</h1>
		<input type="text" value="" name="receive_button_text" id="name" class="field" placeholder="Enter your button text here" />
	</div>
	<div class="linkTarget form-group">
		<h1>Button Link</h1>
	<input type="text" value="" name="receive_button_link" id="btnname" class="field" placeholder="Enter your button url here"/>
	</div>
    
</div>
</div>

	

<div class="program_full_detail">
<div class="GuestValuesBox">
<div class="mb-3 main-content-label">Guests Dropdown Values</div>
 <div class="form-light-holder">
        <h1>Guests Dropdown Values</h1>
		<div id="AddMoreGuests">
			<div class=""><h3><a href="javascript:void(0);" class="AddMoreButtonGuestValues">Add More</a></h3></div>
			&#10687;<input type="text"  name="guests_values[1]" id="guests_values" value="1-5" class="field"   placeholder="Enter Guest Value here"/><br>
			&#10687;<input type="text"  name="guests_values[2]" id="guests_values" value="6-10" class="field"   placeholder="Enter Guest Value here"/><br>
			&#10687;<input type="text"  name="guests_values[3]" id="guests_values" value="10+" class="field"   placeholder="Enter Guest Value here"/><br>
		</div>
		<input type="hidden" class="totalAddMoreGuestValues" value="3"  />
		<script language="javascript" type="text/javascript">
			
			$(document).ready(function(){
				$('.AddMoreButtonGuestValues').click(function(){
					var totalAddMoreGuestValues = $('.totalAddMoreGuestValues').val();
					var i = parseInt(totalAddMoreGuestValues) + Number(1);
					$('.totalAddMoreGuestValues').val(i);
					
						$('#AddMoreGuests').append('<span class="GuestValuesBox_'+i+'"> &#10687;<input type="text"  name="guests_values['+i+']" id="guests_values" class="field"  placeholder="Enter Guest Value here"/><i class="fa fa-close" style="cursor:pointer;" onclick="$(this).parent().remove();">Delete</i><br></span>');
					
				});
			});	 
			
		</script>
    </div>
    </div>

<div class="page-section" id="QuestionHeadline">
<div class="mb-3 main-content-label">Question Headline Section</div>
<div class="form-light-holder">

	<h1>Question Headline</h1>
	
	
	<textarea type="text" id="ckeditor_mini_question_headline" name="question_headline" class="field ckeditor  full_width_input" style=""></textarea>
</div>
</div>

<div class="page-section" id="Headersection">
<div class="mb-3 main-content-label">Header Section</div>

<div class="form-light-holder">
	<h1>Header</h1>
	<textarea type="text" id="ckeditor_mini_header_title" name="header_title" class="field ckeditor  full_width_input" style=""></textarea>
</div>

<div class="form-light-holder">

	<div class="row row-xs align-items-center">
	<div class="col-md-2">
		<label class="form-label mg-b-0">IMAGE OR VIDEO</label>
	</div>
	<div class="col-md-10  mg-t-5 mg-md-t-0">
	<div class="row mg-t-10">
		<div class="col-lg-2">
		  <label class="rdiobox">
			<input type="radio" class="header_image_video" name="header_image_video" value="image" checked="checked"/>
			<span>Image</span>
		  </label>
		</div><!-- col-3 -->
		<div class="col-lg-9 mg-t-20 mg-lg-t-0">
		  <label class="rdiobox">
			<input type="radio" class="header_image_video" name="header_image_video" value="video"  />
			<span>Video</span>
		  </label>
		</div><!-- col-3 -->
		</div>
	</div>
</div>

</div>
<div class="header_welcome_video">
<div class="form-light-holder d-md-flex  dual_input">
	<div class="adsUrl form-group">
		<h1>Video Type</h1>
		<select name="header_video_type" id="" class="field header_videoType" >
		<option value="youtube_video" selected="selected">Youtube Video</option>
		<option value="vimeo_video" >Vimeo Video</option>
	</select>
	
	</div>
	<div class="linkTarget form-group">
	<div class="header_youtube_video">
	<h1>Youtube Video</h1>
	<input type="text" name="header_youtube_video" value="" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://www.youtube.com/embed/UWCbfxwwC-I
	</div>
	</div>
	<span class="header_orButton">OR</span>
	<div class="header_vimeo_video">
	<h1>Vimeo Video</h1>
	<input type="text" name="header_vimeo_video" value="" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://player.vimeo.com/video/17054419
	</div>
	</div>
	</div>
	
</div>
</div>

<div class="header_welcome_image">
<div class="form-light-holder">
	<h1> Header Title Color Overlay And Opacity  Picker</h1>
	<div id='docs-header-title'>
    <div id='docs-content-header-title'>
		<input id="header_title_colorpicker_opacity" name="header_title_background_color" class="colourHeaderTitleValue" value="" />
    </div>
	
 </div>
</div>


<div class="form-light-holder">
	<h1>Header Description</h1>
	<div class="shorterCkeditor"><textarea name="header_desc" id="ckeditor_mini_header_desc" class="text ckeditor"></textarea></div>
</div>
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Header Image</h1>
	
	<div class="custom-file half_width_custom_file">
		<input type="file" name="userfile" class="custom-file-input" id="customFile3"  accept="image/*"  />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
	
		</div>
	<div class="linkTarget form-group">
		<h1 >Image alt text</h1>
		<input value="" name="header_image_alt_text" id="" class="field"  type="text">
		</div>
	
	
</div>
</div>
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">

	<div class="adsUrl form-group">
	
	<h1 >Background Image</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="background_image" class="custom-file-input" id="customFile4" accept="image/*" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
	
		</div>
	<div class="linkTarget form-group">
	<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs-header'>
    <div id='docs-content-header'>
		<input id="full_colorpicker_opacity" name="background_color" class="colourTextValue" value="" />
    </div>
	
 </div>
		</div>
</div>

</div>	



<div class="page-section" id="WhiteStripeFirstSection">
<div class="mb-3 main-content-label">White Stripe Under Header Section</div>
<div class="form-light-holder">
	<h1>Body Title</h1>
	<textarea type="text" name="body_title" id="ckeditor_mini_body_title1" class="field ckeditor  full_width_input" style=""></textarea>
</div>
<div class="form-light-holder">
	<h1>Body Description</h1>
	<textarea name="body_desc" id="ckeditor_full_body_desc1" class="text ckeditor" style="width:50%"></textarea>
	
</div>



<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
		<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Body Image</h1>
	
	<div class="custom-file half_width_custom_file">
		<input type="file" name="body_image" class="custom-file-input" id="customFile5" accept="image/*" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
	</div>
	<div class="linkTarget form-group">
		<h1 >Image alt text</h1>
		<input value="" name="body_image_alt_text" id="" class="field"  type="text">
		</div>
</div>
<div class="form-light-holder  d-md-flex  dual_input">
	<div class="adsUrl form-group">
	<h1>Image Position</h1>
	<select name="body_img_position" class="field">
		<option value="left" >Left</option>
		<option value="right" >Right</option>
	</select>
		</div>
	<div class="linkTarget form-group">
		<h1> Color Overlay And Opacity  Picker</h1>
		<div id='docs-white_stripe'>
		<div id='docs-content-white_stripe'>
			<input id="white_stripe_colorpicker_opacity" name="white_stripe_background_color" class="colourTextValueWhiteStripe" value="" />
		</div>
	 </div>
	</div>
	
</div>


</div>



<div class="page-section" id="BenefitsRowImagesFirstSection">
<div class="mb-3 main-content-label">Benefits with 3 images Section</div>
<div class="form-light-holder">
	<h1>Benefits Title</h1>
	<input type="text" name="benefits_title" value="" class="field full_width_input" style="">
</div>

<div class="form-light-holder">
	<h1>Benefits description</h1>
	<div class="shorterCkeditor"><textarea name="benefits_desc" id="ckeditor_mini_benefits_desc" class="text ckeditor"></textarea></div>
</div>

	
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
		<div class="adsUrl form-group">
	<h1 >Background Image</h1>
	
	<div class="custom-file half_width_custom_file">
		<input type="file" name="benefits_background_image" class="custom-file-input" id="customFile6" accept="image/*" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
	</div>
	<div class="linkTarget form-group">
		<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs-benefits'>
    <div id='docs-content-benefits'>
		<input id="benefits_colorpicker_opacity" name="benefits_background_color" class="colourTextValueBenefits" value="" />
    </div>
	
 </div>
	</div>
</div>



<div class="form-light-holder">
	<h1>Headline #1</h1>
	<input type="text" name="benefits_headline_1" value="" class="field full_width_input" style="">
</div>
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #1</h1>
	
	<div class="custom-file half_width_custom_file">
		<input type="file" name="benefits_image_1" class="custom-file-input" id="customFile7" accept="image/*" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
	
	</div>
	<div class="linkTarget form-group">
		<h1 >Image alt text</h1>
		<input value="" name="benefits_image_1_alt_text" id="" class="field"  type="text">
		</div>
	
</div>


<div class="form-light-holder">
	<h1>Headline #2</h1>
	<input type="text" name="benefits_headline_2" value="" class="field full_width_input" style="">
</div>
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #2</h1>
	
	<div class="custom-file half_width_custom_file">
		<input type="file" name="benefits_image_2"  class="custom-file-input" id="customFile8" accept="image/*" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
	
		</div>
	<div class="linkTarget form-group">
		<h1 >Image alt text</h1>
		<input value="" name="benefits_image_2_alt_text" id="" class="field benefits_image_2_alt_text"  type="text">
		</div>
	
</div>

<div class="form-light-holder">
	<h1>Headline #3</h1>
	<input type="text" name="benefits_headline_3" value="" class="field full_width_input" style="">
</div>
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #3</h1>
	
	<div class="custom-file half_width_custom_file">
		<input type="file" name="benefits_image_3" class="custom-file-input" id="customFile9" accept="image/*" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
		</div>
	<div class="linkTarget form-group">
		<h1 >Image alt text</h1>
		<input value="" name="benefits_image_3_alt_text" id="" class="field "  type="text">
		</div>
</div>
</div>



<div class="page-section" id="videorowsection">
	<div class="mb-3 main-content-label">Video Row</div>
	<div class="form-light-holder">
		<h1>Video Title</h1>
		<input type="text" name="video_title" value="" class="field full_width_input" style="">
	</div>
	<div class="form-light-holder">
		<h1>Video Description</h1>
		<div class="shorterCkeditor"><textarea name="video_desc" id="ckeditor_mini_video_desc" class="text ckeditor"></textarea></div>
	</div>

	<div class="form-light-holder d-md-flex  dual_input">
	<div class="adsUrl form-group">
		<h1>Video Type</h1>
		<select name="video_type" id="" class="field videoType" >
		<option value="youtube_video" >Youtube Video</option>
		<option value="vimeo_video" >Vimeo Video</option>
	</select>
	
	</div>
	<div class="linkTarget form-group">
	<div class="youtube_video">
	<h1>Youtube Video</h1>
	<input type="text" name="youtube_video" value="" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://www.youtube.com/embed/UWCbfxwwC-I
	</div>
	</div>
	<span class="orButton">OR</span>
	<div class="vimeo_video">
	<h1>Vimeo Video</h1>
	<input type="text" name="vimeo_video" value="" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://player.vimeo.com/video/17054419
	</div>
	</div>
	</div>
	
</div>




<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	<h1>Background Image</h1>

	<div class="custom-file half_width_custom_file">
			<input type="file" name="video_background_image" class="custom-file-input" id="customFile10" accept="image/*" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>

</div>
	<div class="linkTarget form-group">
	<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs-video'>
    <div id='docs-content-video'>
		<input id="video_colorpicker_opacity" name="video_background_color" class="colourTextValueVideo" value="" />
    </div>
	
 </div>
	</div>
	
</div>


</div>



<div class="page-section" id="Calltoaction3ImagesSection">
<div class="mb-3 main-content-label">Call to Action with 3 Images Section</div>
<div class="form-light-holder">
	<h1>Call to Action Title</h1>
	<input type="text" name="action_title" value="" class="field  full_width_input">
</div>

<div class="form-light-holder">
	<h1>Call to Action description</h1>
	<div class="shorterCkeditor"><textarea name="action_desc" id="ckeditor_mini_action_desc" class="text ckeditor"></textarea></div>
</div>

	
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
		<div class="adsUrl form-group">
	<h1 >Background Image</h1>

	<div class="custom-file half_width_custom_file">
			<input type="file" name="action_background_image" class="custom-file-input" id="customFile11" accept="image/*" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
	
	</div>
	<div class="linkTarget form-group">
		<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs-action'>
    <div id='docs-content-action'>
		<input id="action_colorpicker_opacity" name="action_background_color" class="colourTextValueAction" value="" />
    </div>
	
 </div>
	</div>
</div>



<div class="form-light-holder">
	<h1>Title #1</h1>
	<input type="text" name="action_headline_1" value="" class="field full_width_input" style="">
</div>
<div class="form-light-holder">
	<h1>Description #1</h1>
	<input type="text" name="action_desc_1" value="" class="field full_width_input" style="">
</div>
<div class="form-light-holder">
	<h1>Image Link Url #1</h1>
	<input type="text" name="action_link_url_1" value="" class="field full_width_input" style="">
</div>
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #1</h1>
	
	<div class="custom-file half_width_custom_file">
		<input type="file" name="action_image_1" class="custom-file-input" id="customFile12" accept="image/*" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
	
		</div>
	<div class="linkTarget form-group">
		<h1 >Image alt text</h1>
		<input value="" name="action_image_1_alt_text" id="" class="field "  type="text">
		</div>
	
</div>


<div class="form-light-holder">
	<h1>Title #2</h1>
	<input type="text" name="action_headline_2" value="" class="field full_width_input" style="">
</div>
<div class="form-light-holder">
	<h1>Description #2</h1>
	<input type="text" name="action_desc_2" value="" class="field full_width_input" style="">
</div>
<div class="form-light-holder">
	<h1>Image Link Url #2</h1>
	<input type="text" name="action_link_url_2" value="" class="field full_width_input" style="">
</div>
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #2</h1>
	
	<div class="custom-file half_width_custom_file">
		<input type="file" name="action_image_2"  class="custom-file-input" id="customFile13" accept="image/*" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
	</div>
	<div class="linkTarget form-group">
		<h1 >Image alt text</h1>
		<input value="" name="action_image_2_alt_text" id="" class="field "  type="text">
		</div>
</div>

<div class="form-light-holder">
	<h1>Title #3</h1>
	<input type="text" name="action_headline_3" value="" class="field full_width_input" style="">
</div>
<div class="form-light-holder">
	<h1>Description #3</h1>
	<input type="text" name="action_desc_3" value="" class="field full_width_input" style="">
</div>
<div class="form-light-holder">
	<h1>Image Link Url #3</h1>
	<input type="text" name="action_link_url_3" value="" class="field full_width_input" style="">
</div>
<div class="form-light-holder d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	<h1 >Image uploader #3</h1>
	
	<div class="custom-file half_width_custom_file">
		<input type="file" name="action_image_3"  class="custom-file-input" id="customFile14" accept="image/*" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
	</div>
	<div class="linkTarget form-group">
		<h1 >Image alt text</h1>
		<input value="" name="action_image_3_alt_text" id="" class="field"  type="text">
		</div>
</div>
</div>


<div class="page-section" id="HeadingboxesSection">
<div class="mb-3 main-content-label">Heading with 3 boxes Section</div>
<div class="form-light-holder">
	<h1>Heading  Title</h1>
	<input type="text" name="headling_title" value="" class="field full_width_input" style="">
</div>

<div class="form-light-holder">
	<h1>Heading description</h1>
	<div class="shorterCkeditor"><textarea name="headling_desc" id="ckeditor_mini_headling_desc" class="text ckeditor"></textarea></div>
</div>

	
<div class="form-light-holder d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Background Image</h1>
	
	<div class="custom-file half_width_custom_file">
		<input type="file" name="headling_background_image"  class="custom-file-input" id="customFile14" accept="image/*" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
</div>
	<div class="linkTarget form-group">
		<h1> Color Overlay And Opacity  Picker</h1>
		<div id='docs-headling'>
		<div id='docs-content-headling'>
			<input id="headling_colorpicker_opacity" name="headling_background_color" class="colourTextValueHeadling" value="" />
		</div>
		
	 </div>
	</div>
	
</div>



<div class="form-light-holder">
	<h1>Headline #1</h1>
	<textarea type="text" id="ckeditor_mini_headline1" name="headling_headline_1" class="field ckeditor  full_width_input"></textarea>
</div>



<div class="form-light-holder">
	<h1>Headline #2</h1>
	<textarea type="text" id="ckeditor_mini_headline2" name="headling_headline_2" class="field ckeditor  full_width_input"></textarea>
</div>


<div class="form-light-holder">
	<h1>Headline #3</h1>
	<textarea type="text" id="ckeditor_mini_headline3" name="headling_headline_3" class="field ckeditor  full_width_input"></textarea>
</div>
</div>




<div class="page-section" id="StatisticsimagesSection">
<div class="mb-3 main-content-label">Statistics with 3 images Section</div>
<div class="form-light-holder">
	<h1>Statistics Title</h1>
	<input type="text" name="statistics_title" value="" class="field  full_width_input">
</div>

<div class="form-light-holder">
	<h1>Statistics description</h1>
	<div class="shorterCkeditor"><textarea name="statistics_desc" id="ckeditor_mini_statistics_desc" class="text ckeditor"></textarea></div>
</div>

	
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
		<div class="adsUrl form-group">
	<h1 >Background Image</h1>
	
	<div class="custom-file half_width_custom_file">
		<input type="file" name="statistics_background_image" class="custom-file-input" id="customFile15" accept="image/*" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
</div>
	<div class="linkTarget form-group">
		<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs-statistics'>
    <div id='docs-content-statistics'>
		<input id="statistics_colorpicker_opacity" name="statistics_background_color" class="colourTextValueStatistics" value="" />
    </div>
	
 </div>
	</div>
</div>


<div class="form-light-holder">
	<h1>Title #1</h1>
	<input type="text" name="statistics_headline_1" value="" class="field  full_width_input">
</div>
<div class="form-light-holder">
	<h1>Description #1</h1>
	<input type="text" name="statistics_desc_1" value="" class="field  full_width_input">
</div>
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #1</h1>
	
	<div class="custom-file half_width_custom_file">
		<input type="file" name="statistics_image_1"  class="custom-file-input" id="customFile16" accept="image/*" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
		</div>
	<div class="linkTarget form-group">
		<h1 >Image alt text</h1>
		<input value="" name="statistics_image_1_alt_text" id="" class="field "  type="text">
		</div>
</div>


<div class="form-light-holder">
	<h1>Title #2</h1>
	<input type="text" name="statistics_headline_2" value="" class="field  full_width_input">
</div>
<div class="form-light-holder">
	<h1>Description #2</h1>
	<input type="text" name="statistics_desc_2" value="" class="field  full_width_input">
</div>
<div class="form-light-holder d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #2</h1>
	
	<div class="custom-file half_width_custom_file">
		<input type="file" name="statistics_image_2" class="custom-file-input" id="customFile17" accept="image/*" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
		</div>
	<div class="linkTarget form-group">
		<h1 >Image alt text</h1>
		<input value="" name="statistics_image_2_alt_text" id="" class="field"  type="text">
		</div>
</div>

<div class="form-light-holder">
	<h1>Title #3</h1>
	<input type="text" name="statistics_headline_3" value="" class="field  full_width_input">
</div>
<div class="form-light-holder">
	<h1>Description #3</h1>
	<input type="text" name="statistics_desc_3" value="" class="field  full_width_input">
</div>
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #3</h1>
	
	<div class="custom-file half_width_custom_file">
		<input type="file" name="statistics_image_3"  class="custom-file-input" id="customFile18" accept="image/*" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
	</div>
	<div class="linkTarget form-group">
		<h1 >Image alt text</h1>
		<input value="" name="statistics_image_3_alt_text" id="" class="field"  type="text">
		</div>
</div>
</div>





<div class="page-section" id="BenefitsRowImagesSecondSection">
<div class="mb-3 main-content-label">Benefits Row2 with 3 Images Section</div>
<div class="form-light-holder">
	<h1>Benefits Row2 Title</h1>
	<input type="text" name="benefits_2_title" value="" class="field full_width_input" style="">
</div>

<div class="form-light-holder">
	<h1>Benefits Row2 description</h1>
	<div class="shorterCkeditor"><textarea name="benefits_2_desc" id="ckeditor_mini_benefits_2_desc" class="text ckeditor"></textarea></div>
</div>

	
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	<h1>Background Image</h1>
	
	<div class="custom-file half_width_custom_file">
		<input type="file" name="benefits_2_background_image" class="custom-file-input" id="customFile19" accept="image/*" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>

</div>
	<div class="linkTarget form-group">
		<h1> Color Overlay And Opacity  Picker</h1>
		<div id='docs-benefits_2'>
		<div id='docs-content-benefits_2'>
			<input id="benefits_2_colorpicker_opacity" name="benefits_2_background_color" class="colourTextValueBenefits_2" value="" />
		</div>
		
	 </div>
	</div>
</div>



<div class="form-light-holder">
	<h1>Title #1</h1>
	<input type="text" name="benefits_2_headline_1" value="" class="field  full_width_input">
</div>
<div class="form-light-holder">
	<h1>Description #1</h1>
	<input type="text" name="benefits_2_desc_1" value="" class="field  full_width_input">
</div>
<div class="form-light-holder d-md-flex  dual_input" style="overflow:auto;">
		<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #1</h1>
	
	<div class="custom-file half_width_custom_file">
		<input type="file" name="benefits_2_image_1"  class="custom-file-input" id="customFile20" accept="image/*" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
	</div>
	<div class="linkTarget form-group">
		<h1 >Image alt text</h1>
		<input value="" name="benefits_2_image_1_alt_text" id="" class="field"  type="text">
		</div>
</div>


<div class="form-light-holder">
	<h1>Title #2</h1>
	<input type="text" name="benefits_2_headline_2" value="" class="field  full_width_input">
</div>
<div class="form-light-holder">
	<h1>Description #2</h1>
	<input type="text" name="benefits_2_desc_2" value="" class="field  full_width_input">
</div>
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #2</h1>
	
	<div class="custom-file half_width_custom_file">
		<input type="file" name="benefits_2_image_2"  class="custom-file-input" id="customFile21" accept="image/*" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
	</div>
	<div class="linkTarget form-group">
		<h1 >Image alt text</h1>
		<input value="" name="benefits_2_image_2_alt_text" id="" class="field"  type="text">
	</div>
</div>

<div class="form-light-holder">
	<h1>Title #3</h1>
	<input type="text" name="benefits_2_headline_3" value="" class="field  full_width_input">
</div>
<div class="form-light-holder">
	<h1>Description #3</h1>
	<input type="text" name="benefits_2_desc_3" value="" class="field  full_width_input">
</div>
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #3</h1>
	
	<div class="custom-file half_width_custom_file">
		<input type="file" name="benefits_2_image_3"  class="custom-file-input" id="customFile22" accept="image/*" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
	</div>
	<div class="linkTarget form-group">
		<h1 >Image alt text</h1>
		<input value="" name="benefits_2_image_3_alt_text" id="" class="field"  type="text">
		</div>
</div>
</div>




<div class="page-section" id="WhiteStripeSecondSection">
<div class="mb-3 main-content-label">White Stripe Row 2 Section</div>
<!-- <div class="form-light-holder">
	<h1>Title</h1>
	<input type="text" name="white_stripe2_title" value="" class="field" style="width:98%">
</div> -->
<div class="form-light-holder">
	<h1>Content</h1>
	<div class="shorterCkeditor"><textarea name="white_stripe2_desc" id="ckeditor_mini_white_stripe2_desc" class="text ckeditor"></textarea></div>
</div>

<!--<div class="form-light-holder">
<h1>Override Logo</h1>
	<select name="white_stripe2_override_logo" id="window" class="field">
	<?php foreach($override_logos as  $override_logo):?>
	<option value="<?=$override_logo->s_no?>" ><?=$override_logo->logo_name?></option>
	<?php endforeach;?>
	</select>
</div> -->

<div class="form-light-holder d-md-flex  dual_input" style="overflow:auto;">
		<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Image</h1>
	
	<div class="custom-file half_width_custom_file">
		<input type="file" name="white_stripe2_image"  class="custom-file-input" id="customFile23" accept="image/*" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
	
	</div>
	<div class="linkTarget form-group">
	<h1 >Image alt text</h1>
	<input value="" name="white_stripe2_image_alt_text" id="" class="field"  type="text">
	</div>
	
</div>
</div>


<div class="page-section" id="BenefitsRowImagesThirdSection">
<div class="mb-3 main-content-label">Benefits Row3 with 3 Images Section</div>
<div class="form-light-holder">
	<h1>Benefits Row3 Title</h1>
	<input type="text" name="benefits_3_title" value="" class="field  full_width_input">
</div>

<div class="form-light-holder">
	<h1>Benefits Row3 description</h1>
	<div class="shorterCkeditor"><textarea name="benefits_3_desc" id="ckeditor_mini_benefits_3_desc" class="text ckeditor"></textarea></div>
</div>

	
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	<h1 >Background Image</h1>
	<!--<input type="file" name="benefits_3_background_image" id="photo_left" accept="image/*" /> -->
	<div class="custom-file half_width_custom_file">
		<input type="file" field_name="benefits_3_background_image" class="programImage custom-file-input" id="customFile24" accept="image/*" />
		<input type="hidden" name="benefits_3_background_image" id="benefits_3_background_image"   />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
</div>
	<div class="linkTarget form-group">
		<h1> Color Overlay And Opacity  Picker</h1>
		<div id='docs-benefits_3'>
		<div id='docs-content-benefits_3'>
			<input id="benefits_3_colorpicker_opacity" name="benefits_3_background_color" class="colourTextValuebenefits_3" value="" />
		</div>
		
	 </div>
	</div>
	
</div>

<div class="form-light-holder">
	<h1>Title #1</h1>
	<input type="text" name="benefits_3_headline_1" value="" class="field  full_width_input">
</div>

<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #1</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" field_name="benefits_3_image_1" class="programImage custom-file-input" id="customFile25" accept="image/*" />
	<input type="hidden" name="benefits_3_image_1" id="benefits_3_image_1" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
	
		</div>
	<div class="linkTarget form-group">
	<h1 >Image alt text</h1>
	<input value="" name="benefits_3_image_1_alt_text" id="" class="field"  type="text">
	</div>
</div>


<div class="form-light-holder">
	<h1>Title #2</h1>
	<input type="text" name="benefits_3_headline_2" value="" class="field  full_width_input">
</div>

<div class="form-light-holder d-md-flex  dual_input" style="overflow:auto;">
		<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #2</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" field_name="benefits_3_image_2" class="programImage custom-file-input" id="customFile26" accept="image/*" />
	<input type="hidden" name="benefits_3_image_2" id="benefits_3_image_2"  />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
	
	</div>
	<div class="linkTarget form-group">
	<h1 >Image alt text</h1>
	<input value="" name="benefits_3_image_2_alt_text" id="" class="field"  type="text">
	</div>
</div>

<div class="form-light-holder">
	<h1>Title #3</h1>
	<input type="text" name="benefits_3_headline_3" value="" class="field  full_width_input">
</div>
<div class="form-light-holder d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #3</h1>
	<div class="custom-file half_width_custom_file">
		
	<input type="file" field_name="benefits_3_image_3" class="programImage custom-file-input" id="customFile27" accept="image/*" />
	<input type="hidden" name="benefits_3_image_3" id="benefits_3_image_3" />		
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
	
	</div>
	<div class="linkTarget form-group">
	<h1 >Image alt text</h1>
	<input value="" name="benefits_3_image_3_alt_text" id="" class="field"  type="text">
	</div>
</div>
</div>


<div class="page-section" id="EmailOptin">
<div class="mb-3 main-content-label">Email Opt-in #1</div>
<div class="form-light-holder">

	<h1>Opt-In Title</h1>
	
	
	<textarea type="text" id="ckeditor_mini_opt1_title" name="opt1_title" class="field ckeditor  full_width_input"></textarea>
</div>
<div class="form-light-holder">

	<h1>Opt-In Text</h1>
	<input type="text" value="" name="opt1_text" id="" class="field full_width_input" placeholder=""  style=""/>
</div>


<div class="form-light-holder">

	<h1>Submit Button Text</h1>
	<input type="text" value="" name="opt1_submit_btn_text" id="" class="field full_width_input" placeholder=""  style=""/>
</div>

<div class="form-light-holder form1checkbox">
	<a id="published" class="checkbox1 check-off"></a>

	<h1 class="inline">Show Full Form </h1>

	<input type="hidden" value="0" name="show_full_form_1" class="hidden_cb1" />

</div>




<script language="javascript">

$(document).ready(function(){

$(".form1checkbox .checkbox1").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form1checkbox").children(".hidden_cb1").val("0");

		
	}

	else

	{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form1checkbox").children(".hidden_cb1").val("1");
	}

})


$(".form2checkbox .checkbox2").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form2checkbox").children(".hidden_cb2").val("0");

		
	}

	else

	{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form2checkbox").children(".hidden_cb2").val("1");
	}

})

})

</script>

<div class="mb-3 main-content-label">Email Opt-in #2</div>

<div class="form-light-holder">

	<h1>Opt-In Title</h1>
	<input type="text" value="" name="opt_2_title" id="" class="field full_width_input" placeholder=""  style=""/>
</div>

<div class="form-light-holder">

	<h1>Opt-In Text</h1>
	<input type="text" value="" name="opt_2_text" id="" class="field full_width_input" placeholder=""  style=""/>
</div>

<div class="form-light-holder form2checkbox">

	<a id="published" class="checkbox2 check-off"></a>

	<h1 class="inline">Show Full Form </h1>

	<input type="hidden" value="0" name="show_full_form_2" class="hidden_cb2" />

</div>
</div>


<div class="page-section" id="testimonials_faqs">
<div class="mb-3 main-content-label">Testimonials Section</div>

<div class="form-light-holder">
	<h1>h2 above the testimonials</h1>
	<input type="text" value="" name="testimonials_h2_text" id="" class="field" placeholder="h2 above the testimonials" />
</div>

<?php if(!empty($testimonials)){ ?>
<div class="form-light-holder">
	<h1>Testimonials</h1>
	<?php foreach($testimonials as $testimonial){ 
			
	?>
	<label class="ckbox mg-b-10">
		<input type="checkbox" name="testimonial_ids[]" value="<?php echo $testimonial->id ?>"><span> <?php echo $testimonial->title.' ('.$testimonial->name.')'; ?> </span></label>
	<?php } ?>
</div>
<?php } ?>

<div class="mb-3 main-content-label">FAQs Section</div>

<div class="form-light-holder">
	<h1>h2 above the faqs</h1>
	<input type="text" value="" name="faqs_h2_text" id="" class="field" placeholder="h2 above the faqs" />
</div>

<?php if(!empty($programFaqs)){ ?>
<div class="form-light-holder">
	<h1>FAQs</h1>
	<?php foreach($programFaqs as $program_faq){ 
				
	?><label class="ckbox mg-b-10">
		<input type="checkbox" name="faq_ids[]" value="<?php echo $program_faq->id; ?>"><span> <?php echo $program_faq->title.' / '.$program_faq->title_2; ?> </span></label>
	<?php } ?>
</div>
<?php } ?>
</div>

<h1 style="padding-bottom: 5px;"> &nbsp; </h1>
		
	
<script language="javascript">
$(window).load(function(){
	if($('.hidden_cb3').val() == 0){
		$('.checkbox_landing_page').addClass("check-off");
		$('.checkbox_landing_page').removeClass("check-on");
		$('.checkbx1').val('0');
		$('#landing_page_box').hide();
		$('.program_full_detail').hide();
	}else{
		$('.program_full_detail').show();
	}
})
$(document).ready(function(){

$(".form3checkbox .checkbox3").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form3checkbox").children(".hidden_cb3").val("0");

		$('.checkbox_landing_page').addClass("check-off");
		$('.checkbox_landing_page').removeClass("check-on");
		$('.checkbx1').val('0');
		$('#landing_page_box').hide();
		$('.program_full_detail').hide();
	}

	else

	{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form3checkbox").children(".hidden_cb3").val("1");
		$('.program_full_detail').show();
	}

})

})

</script>
<div style="display:<?php if($user_level != 1 ){ echo 'none'; } ?>">
	
	
<script language="javascript">
$(document).ready(function(){

	$('.landing_program').change(function(){
		if($(this).val() != ''){
			var program_id = $( ".landing_program option:selected" ).attr('number');
			$('.landing_program_id').val(program_id);
			$('.landing_page_url').attr('readonly','readonly');
			$('.urlErrorMsg').show();
			$('.urlErrorMsg').html('<i>Please Diselect Program</i>');
			$('.landing_page_url').val('');
		} else{
			$('.landing_page_url').attr('readonly',false);
			$('.urlErrorMsg').hide();
		}
	});
	
	
$(".landing_page .checkbox_landing_page").click(function(){
	if($(this).hasClass("check-on")){
		$('.stand_alone_page').hide();
		$('.checkbx2').val(0);
		$('.landing_page_box').show();
		$('#landing_page_box').hide();
		/*$('.checkbox').removeClass("check-off");
		$('.checkbox').addClass("check-on");*/
		
		
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents(".landing_page").children(".stand_alone_page_button").val("0");
	}
	else
	{
		$('.landing_page_box').hide();
		$('.stand_alone_page').hide();
		$('.checkbx2').val(0);
		$('#landing_page_box').show();
		$('.checkbox').addClass("check-off");
		$('.checkbox').removeClass("check-on");
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents(".landing_page").children(".stand_alone_page_button").val("1");
	}
});


$(".form-light-holder .checkbox").click(function(){
	if($(this).hasClass("check-on")){
		
		//$('.landing_page').show();
		$('.checkbx1').val(0);
		$('#landing_page_box').hide();
		$('.stand_alone_page').hide();
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents(".form-light-holder").children(".hidden_cb").val("0");
		
	}
	else
	{
		
		//$('.landing_page').hide();
		$('.checkbx1').val(0);
		$('.stand_alone_page').show();
		$('#landing_page_box').hide();
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$('.checkbox_landing_page').addClass("check-off");
		$('.checkbox_landing_page').removeClass("check-on");
		$(this).parents(".form-light-holder").children(".hidden_cb").val("1");
		/*if($('checkbx1').val() == 1){
			$('#landing_page_box').show();
		} else{
			$('#landing_page_box').hide();
		}*/
	}
});
})
</script>

<div class="form-light-holder display-none">
	<a id="free_trials" class="checkbox check-off"></a>
	<h1 class="inline">Show stand-alone page for this program?</h1>
	<input type="hidden" value="0" name="stand_alone_page" class="hidden_cb stand_alone_page_button checkbx2" />
</div>

<div class="stand_alone_page display-none">
	<div class="form-light-holder d-md-flex  dual_input">
	<div class="adsUrl form-group">
		<h1>Stand-Alone Program Name</h1>
		<input type="text" value="" name="stand_program_name" class="field" placeholder="Enter Your Stand-Alone Program Name Here"/>
	</div>
	<div class="linkTarget form-group">
		<h1>Stand-Alone Ages</h1>
		<input type="text" value="" name="stand_program_ages" class="field" placeholder="Enter Stand-Alone Ages Here"/>
	</div>
	
</div>
	

	
<!-------- - Image And Video - ------------>
<div class="form-light-holder">

	<h1>Image Or Video</h1>
	<label class="rdiobox">
	<input type="radio" class="image_video" name="image_video" value="image"  /><span> Image </span></label>
	<label class="rdiobox">
	<input type="radio" class="image_video" name="image_video" value="video" checked="checked" /> <span>Video</span></label>

</div>
<div class="welcome_image">
<div class="form-light-holder d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Choose a Photo</h1>
	
		
		
	<div class="custom-file half_width_custom_file">
		<input type="file" name="userfile_2" class="custom-file-input" id="customFile28" accept="image/*" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
		</div>
		<div class="linkTarget form-group">
		<h1>Image alt text</h1>
	<input type="text" value="" name="image_alt" id="image_alt" class="field full_width_input" />
		</div>
		<div>
		</div>
</div>

</div>
<div class="form-light-holder welcome_video  d-md-flex  dual_input">
	<div class="adsUrl form-group">
		<h1>Video Type</h1>
		<select name="video_type" id="" class="field videoType" >
		<option value="youtube_video">Youtube Video</option>
		<option value="vimeo_video" >Vimeo Video</option>
	</select>
	
	</div>
	<div class="linkTarget form-group">
	<div class="youtube_video">
	<h1>Youtube Video</h1>
	<input type="text" name="youtube_video" value="" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://www.youtube.com/embed/UWCbfxwwC-I
	</div>
	</div>
	<span class="orButton">OR</span>
	<div class="vimeo_video">
	<h1>Vimeo Video</h1>
	<input type="text" name="vimeo_video" value="" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://player.vimeo.com/video/17054419
	</div>
	</div>
	</div>
	
</div>

<!--------------------->
	

<div class="form-light-holder">	
<div id="AddMoreStandAlonePage">
	<div class=""><h3><a href="javascript:void(0);" class="AddMoreStandAlonePageButton">Add More</a></h3></div>
	
<div class="standPages">
	<div class="form-light-holder">
		<h1>#1 Title </h1>
		<textarea name="data[1][title]" id="ckeditor_mini_stand_page_name1" class="ckeditor" placeholder="Enter your name here" /></textarea>
	</div>
		<div class="form-light-holder" style="">
			<h1>#1 Description </h1>
			 <textarea name="data[1][desc]" class="ckeditor" id="ckeditor_full_stand_page_desc_1"></textarea>
		</div>
		
		<div class="form-light-holder" style="overflow:auto;">
				<h1 style="padding-bottom: 5px;">#1 Image </h1>
				<input type="file" name="stand_page_photo1" id="" accept="image/*" />
			<div>
		</div>
	</div>
	<div class="form-light-holder">
	<h1>Background Color</h1>
	<input type="hidden" name="data[1][background_color]"  class="colourTextValue myNewColor_1" placeholder="Background Color"  readonly="readonly" />
	<input id="cpFocus" class="coloPick"    />
	<div id="cpDiv" style="display:none"></div>
	
</div>
</div>

</div>
</div>	
</div>


<!-- 05/12 -->
<div class=" display-none">
<div class="form-light-holder">
	<h1>Online Trial Title</h1>
	<input type="text" name="trial_title" value="" class="field  full_width_input">
</div>

<div class="form-light-holder">
	<h1>Online Trial description</h1>
	<div class="shorterCkeditor"><textarea name="trial_desc" id="ckeditor_mini_trial_desc" class="text ckeditor"></textarea></div>
</div>

<div class="form-light-holder">
    	<h1>Mini-form Offer Title</h1>
       <input type="text" class="half_field" name="mini_form_offer_title" value=""  style="width:98%" />&nbsp;
</div>
<div class="form-light-holder">
    	<h1>Mini-form Offer Description</h1>
       <input type="text" class="half_field" name="mini_form_offer_desc" value=""  style="width:98%" />&nbsp;
</div>

<div class="form-light-holder">
    	<h1>Mini-form Button 1 Text</h1>
       <input type="text" class="half_field" name="mini_form_button1_text" value=""  style="width:98%" />&nbsp;
</div>

<div class="form-light-holder">
    	<h1>Mini-form Buton 2 Text</h1>
       <input type="text" class="half_field" name="mini_form_button2_text" value=""  style="width:98%" />&nbsp;
</div>
</div>

<div class="page-section" id="Htmleditor_Basic_detail">
<div class="mb-3 main-content-label">HTML Editor</div>
<div class="form-light-holder">
	<h1>HTML Editor</h1>
	<textarea name="html_editor" id="ckeditor_full_html_editor" class="text ckeditor" style="width:50%"></textarea>
	
</div>

<div class="mb-3 main-content-label">Basic Detail</div>
<div class="form-light-holder">
		<h1>Meta Title</h1>
			<input type="text" value="" name="meta_title" id="meta_title" class="field full_width_input" placeholder="Meta title" style=""/>
	</div>
	
<div class="form-light-holder" style="">
<h1>Meta Description</h1>
	<textarea name="meta_desc" id="frm-text"></textarea>
</div>

<div class="form-light-holder">
	<h1>Body Id</h1>
	<input type="text" name="body_id" class="field">
</div>

		
<script>
$(window).load(function(){
	
	$.each( $( ".show_location_type" ), function() {
		if($(this).attr('checked') == 'checked'){
			var show_location_type = $(this).val();
	
			if(show_location_type == "select_location"){
				$('.locationSelectBox').attr('required' , true);
				$('.locationsDropdown').show();
			}else{
				$('.locationSelectBox').attr('required' , false);
				$('.locationsDropdown').hide();
			}
		}
	});
});

	$(document).ready(function(){
		$('.show_location_type').click(function(){
			var show_location_type = $(this).val();
			if(show_location_type == "select_location"){
				$('.locationSelectBox').attr('required' , true);
				$('.locationsDropdown').show();
			}else{
				$('.locationSelectBox').attr('required' , false);
				$('.locationsDropdown').hide();
			}
		});
	});
</script>
	
<div class="form-light-holder">

	<h1>SHOW ALL LOCATIONS Or SELECT LOCATIONS TO SHOW</h1>
	
	<label class="rdiobox">
	<input type="radio" class="show_location_type" name="show_location_type" value="show_all" checked="checked" /><span> SHOW ALL LOCATIONS </span></label>
	
	<label class="rdiobox">
	<input type="radio" class="show_location_type" name="show_location_type" value="select_location"  /><span> SELECT LOCATIONS TO SHOW</span></label>

</div>

<?php 
	if(!empty($dojo_cart_allLocations)){
		
?>
<div class="form-light-holder locationsDropdown  d-md-flex  dual_input">
	<div class="adsUrl form-group">
		<h1>Locations</h1>
		<select name="locations[]" id="" class="field locationSelectBox" required='true' multiple="true" style="height:200px">
		<?php foreach($dojo_cart_allLocations as $location){ ?>
			<option value="<?php echo $location->id; ?>"><?php echo $location->name; ?></option>
		<?php } ?>
	</select>
	
	</div>	
</div>
<?php } ?>

</div>
</div>
</div>
<input type="hidden" value="<?='view/'.$this->uri->segment(4);?>" name="redirect" id="redirect" class="hidden_cb" />
	<input type="hidden" value="save" name="action_type" id="action_type" />





		</div>
		</div>
		</div>
	</div>
	</form>
	</div>

</div>
				
				<div class="tx-center pd-y-20 bg-gray-200" id="bottom"> 
				<!--<a href="" class="btn btn-az-primary" data-toggle="modal" data-target="#modaldemo1">Submit</a>
				<a href="" class="btn btn-az-primary" data-toggle="modal" data-target="#modaldemo1">Submit & Continue</a>-->
				
				<input type="button"  name="update" value="Save" class=" save_program_form btn btn-az-primary saveProgramButton" action_type="save"/> 
				<input type="button"  name="update" value="Save & Continue" class="save_program_form btn btn-az-primary saveProgramButton"  action_type="save_and_continue" style="width:160px;margin-left:3px" />
			</div>

			
			</div>
        </div><!-- az-content-body -->
      </div></div>
    </div><!-- az-content -->
</div>
				
			</div>
			
      	
			
     </div>
     </div>
	 

<input type="hidden" class="totalAddMoreFeatures" value="1"  />
<input type="hidden" class="totalAddMoreStandAlonePage" value="1"  />
<script type="text/javascript">
window.onload = function () {
    var loadTime = window.performance.timing.domContentLoadedEventEnd-window.performance.timing.navigationStart; 
   
   setTimeout(function(){ 
	 $('#sidebar').stickySidebar({
		topSpacing: 0,
		bottomSpacing: 60,
	  });
		
  }, loadTime);
  
}
/*$(document).ready(function() { 
  setTimeout(function(){ 
	 $('#sidebar').stickySidebar({
		topSpacing: 0,
		bottomSpacing: 60,
	  });
		
  }, 5000);
	  
 }); */
 
</script>
<script type="text/javascript">
/*
	jQuery Document ready
*/
$(document).ready(function()
{

	
	/*
		adding click event hanlder for theme links.
		this handler will load the jQuery UI theme from the
		html we have write in link.
		it will load that theme to html dynamically
	*/
    $('.css').click(function()
	{
		/*
			we have given jquiCSS id to link tag inside head section
			below code replace old css with selected css.
		*/
        $('#jquiCSS').attr('href','http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/'+this.innerHTML+'/jquery-ui.css');
    });
	
	// Events demo
	
    $('.coloPick').colorpicker();
	
   
	
	
	$('.coloPick').click(function(){
		
		$('#cpDiv').show();
		
		/*var color_value = $('#cpDiv').colorpicker("val");
		$(this).val(color_value);
		$('.colourTextValue').val(color_value);*/
	
	});
	
	
	$('#cpDiv').mouseout(function(){
		
		/*var color_value = $('#cpDiv').colorpicker("val");
		$('.coloPick').val(color_value);
		$('.colourTextValue').val(color_value);*/
		$('#cpDiv').hide();
	});
	

$('.save_program_form').click(function(){
	
	//var bg_color = $('.evo-pointer').attr("style");
	
	//var background_color = bg_color.replace('background-color:', '');
	
	//$('.colourTextValue').val(background_color);
	
	var color_box = 1;
	$.each($('.evo-pointer'), function(){
		var bg_color = $(this).attr("style");
		var background_color = bg_color.replace('background-color:', '');
		$('.myNewColor_'+color_box).val(background_color);
		color_box++;	
	});
	
});
	
	
});
</script>
<script language="javascript" type="text/javascript">
 	
	$(document).ready(function(){
	
		$('.AddMoreButton').click(function(){
			var totalAddMoreFeatures = $('.totalAddMoreFeatures').val();
			var i = parseInt(totalAddMoreFeatures) + Number(1);
			$('.totalAddMoreFeatures').val(i);
			
				$('#AddMoreFeatures').append('&#10687;<input type="text"  name="features['+i+']" id="features" class="field" placeholder="Enter Features here"/><br>');
			
		});
		
		$('.AddMoreStandAlonePageButton').click(function(){
			var totalAddMoreFeatures = $('.totalAddMoreStandAlonePage').val();
			var b = parseInt(totalAddMoreFeatures) + Number(1);
			$('.totalAddMoreStandAlonePage').val(b);
				var ckeditor_id = 'ckeditor_mini_stand_page_name_'+b;
				var full_ckeditor_id = 'ckeditor_full_stand_page_desc_'+b;
				//alert(ckeditor_id);
						
				$('#AddMoreStandAlonePage').append('<div class="standPages"><div class="form-light-holder"><h1>#'+b+' Title </h1><textarea type="text" value="" name="data['+b+'][title]" id="'+ckeditor_id+'" class="field" placeholder="Enter your name here" /></textarea></div><div class="form-light-holder" style=""><h1>#'+b+' Description </h1><textarea name="data['+b+'][desc]" class="ckeditor" id="'+full_ckeditor_id+'"></textarea></div><div class="form-light-holder" style="overflow:auto;"><h1 style="padding-bottom: 5px;">#'+b+' Image </h1><div><input type="file" name="stand_page_photo'+b+'" id="" accept="image/*" /><div></div></div></div><div class="form-light-holder"><h1>Background Color</h1><input type="hidden" name="data['+b+'][background_color]"  class="colourTextValue myNewColor_'+b+'" placeholder="Background Color"  readonly="readonly" /><input id="cpFocus" class="coloPick"    /><div id="cpDiv" style="display:none"></div>');
				
					 CKEDITOR.replace(  ckeditor_id, 
									{ customConfig : 'config.js' }
							);
							
							
					CKEDITOR.replace(  full_ckeditor_id, 
									{ customConfig : 'config.js' }
							);
				$('.coloPick').colorpicker();	
					
			
		});
	});	 
	
</script>



<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js" type="text/javascript"></script>
<script src="color_overlay_opacity_pickier/js/spectrum.js" type="text/javascript"></script>
	<script src="color_overlay_opacity_pickier/js/toc.js" type="text/javascript"></script>
	<script src="color_overlay_opacity_pickier/js/docs.js" type="text/javascript"></script>
	<script src="color_overlay_opacity_pickier/js/prettify.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="color_overlay_opacity_pickier/css/spectrum.css">
	

<script type="text/javascript">

/*
	jQuery Document ready
*/
$(document).ready(function()
{


$("#full_colorpicker_opacity").spectrum({
   color: '',
   
});

$("#action_colorpicker_opacity").spectrum({
   color: '',
   
});

$("#benefits_colorpicker_opacity").spectrum({
   color: '',
   
});

$("#video_colorpicker_opacity").spectrum({
   color: '',
   
}); 

$("#statistics_colorpicker_opacity").spectrum({
   color: '',
   
});

$("#headling_colorpicker_opacity").spectrum({
   color: '',
   
});

$("#benefits_2_colorpicker_opacity").spectrum({
   color: '',
   
}); 

$("#benefits_3_colorpicker_opacity").spectrum({
   color: '',
   
});


$("#white_stripe_colorpicker_opacity").spectrum({
   color: '',
   
}); 


$("#header_title_colorpicker_opacity").spectrum({
   color: '',
   
});
 

$('.save_program_form').click(function(){
	var action_type = $(this).attr('action_type');
	$('#action_type').val(action_type);
	$(this).append("<input type='hidden' name='scroll_top' value='"+$(document).scrollTop()+"'>");
	
	
	var bg_color = $('#docs-header').find('.sp-preview-inner').css("background-color");
	var bg_color_action = $('#docs-action').find('.sp-preview-inner').css("background-color");
	var bg_color_benefits = $('#docs-benefits').find('.sp-preview-inner').css("background-color");
	var bg_color_video = $('#docs-video').find('.sp-preview-inner').css("background-color");
	var bg_color_headling = $('#docs-headling').find('.sp-preview-inner').css("background-color");
	var bg_color_statistics = $('#docs-statistics').find('.sp-preview-inner').css("background-color");
	var bg_color_benefits_2 = $('#docs-benefits_2').find('.sp-preview-inner').css("background-color");
	var bg_color_benefits_3 = $('#docs-benefits_3').find('.sp-preview-inner').css("background-color");
	var bg_white_stripe = $('#docs-white_stripe').find('.sp-preview-inner').css("background-color");
	var bg_header_title = $('#docs-header-title').find('.sp-preview-inner').css("background-color");
	
	
	//alert(bg_color); return false; //benefits_2
	$('.colourTextValue').val(bg_color);
	$('.colourTextValueAction').val(bg_color_action);
	$('.colourTextValueBenefits').val(bg_color_benefits);
	$('.colourTextValueVideo').val(bg_color_video);
	$('.colourTextValueHeadling').val(bg_color_headling);
	$('.colourTextValueStatistics').val(bg_color_statistics);
	$('.colourTextValueBenefits_2').val(bg_color_benefits_2);
	$('.colourTextValueBenefits_3').val(bg_color_benefits_3);
	$('.colourTextValueWhiteStripe').val(bg_white_stripe);
	$('.colourHeaderTitleValue').val(bg_header_title);
});
	
});
</script>

<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>

<script>

	 new PerfectScrollbar('#azContactList', {
	  suppressScrollX: true
	});
		
		
	 var nav = $('.az-content-left-contacts');

    $(window).scroll(function () {
        if ($(this).scrollTop() > 125) {
            nav.addClass("f-nav");
        } else {
            nav.removeClass("f-nav");
        }
    });
	
	$('.az-contact-item').on('click touch', function() {
         

	  $('body').addClass('az-content-body-show');
	})        
	$('.az-toggle').on('click', function(){
	  $(this).toggleClass('on');
	})
	
	
</script>
