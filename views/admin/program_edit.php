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
<script>
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
	
	
		if($('.checkbx1').val() == 1){
			$('#landing_page_box').show();
		} else if($('.checkbx1').val() == 0){
			$('#landing_page_box').hide();
			
		}
		
		if($('.checkbx2').val() == 1){
			$('.stand_alone_page').show();
		} else if($('.checkbx2').val() == 0){
			$('.stand_alone_page').hide();
			
		}
		
		/*if($('.landing_program').val() != ''){
			$('.landing_page_url').attr('readonly','readonly');
			$('.urlErrorMsg').show();
			$('.urlErrorMsg').html('<i>Please Diselect Program</i>');
			$('.landing_page_url').val('');
		} else{
			$('.landing_page_url').attr('readonly',false);
			$('.urlErrorMsg').hide();
		}*/
		
		if($('.landing_page_url').val() != ''){
			$(".landing_program option:selected").removeAttr("selected");
			$('.landing_page_url').attr('readonly',false);
			$('.urlErrorMsg').hide();
		}
	
	
		/*var check_stand_alone_page = $('.stand_alone_page_button').val();
		if(check_stand_alone_page == 0){
			$('.stand_alone_page').hide();
		}*/
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
			
			
		//var stang_page = $('.standPages').length;
		/*for(var i = 1; i <= $('.standPages').length; i++) {
			var exit_stand_page_name = 'ckeditor_mini_stand_page_name'+i;
			CKEDITOR.replace( exit_stand_page_name,
									{  customConfig : 'config.js' }
						);
						
			
		}*/


	});
	
	
$(document).ready(function(){
	
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


 $(".deleteOtherImages").click(function(){
		$(this).parents('.form-light-holder').find('img').hide();
		$(this).parents('.form-light-holder').find('.old_image_value').val('');
		
		var program_id=$(this).attr('number');
		var field_name=$(this).attr('field_name');
		
		$('#'+field_name).val('');
		//var mod_type = $("#contact_mod").val().toLowerCase();
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/programs/deleteOtherImages',						
		data: { program_id : program_id,field_name:field_name }					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			
			//setTimeout("window.location.href='admin/programs/edit/"+program_id+"'",1000);			
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});
	

 });
 
$('.saveProgramButton').click(function(){
		var program_id=$('#program_id').val();
		var name=$('#name').val();
		var slug = $('#slug').val();
		var type='edit';
		var form =$("#blog_form");
		
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/programs/check_slug',						
		data: { program_id : program_id,type:type,slug:slug,name:name }					
		}).done(function(msg){ 
		if(msg == 0){
			
			form.submit();	
		}
		else{
			alert("Oops! Slug already exits please change it");
			return false;
					
		}
		});
});	

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
			//alert(data);
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


/********************** new code for popup *********************/
$('body').on('click','.delete_item', function(){
		var item_id = $(this).attr('item_id');
		var table_name = $(this).attr('table_name');
		var item_title = $(this).attr('item_title');
		var section_type = $(this).attr('section_type');
		
		$('#popupDeleteItem').find('.modal-title').html(item_title);
		$('#popupDeleteItem').find('#delete_item_id').val(item_id);
		$('#popupDeleteItem').find('#delete_item_table_name').val(table_name);
		$('#popupDeleteItem').find('#delete_item_section_type').val(section_type);
	})
	
	
 	$('body').on('click','.popup_delete_btn', function(){
		
		
		var formData = $('#popupDeleteItem').find('form').serialize();
		var form_action = $('#popupDeleteItem').find('form').attr('action');
		var item_id = $('#popupDeleteItem').find('#delete_item_id').val();
		var section_type = $('#popupDeleteItem').find('#delete_item_section_type').val();
		//alert('.'+section_type+'_'+item_id); return false;
		
		
		$.ajax({ 					
			type: 'POST',						
			url: form_action,						
			data: { formData : formData}					
			}).done(function(msg){ 
			if(msg == 1){
				
				var form_type = 'full_width_row';
				if(section_type == "little_row"){
					var form_type = "little_row";
				}
				
				var total_record = $('.total_alternating_'+form_type).html();
				//alert(section_type+'==>'+form_type+'==>'+'.total_alternating_'+form_type+'==>'+total_record); return false;
				total_record = parseInt(total_record) - 1; 
				$('.total_alternating_'+form_type).html(total_record);
				
				
				
				$('.'+form_type+'_'+item_id).remove();
				$('#popupDeleteItem').modal('hide');
				
				$('#responsePopup').modal('show');
				$('#responsePopup').find('.action_response_msg').html('Successfully deleted!');
				
				reArrageCustomListSortPositions();
				
				setTimeout(function() {$('#responsePopup').modal('hide');}, 3000);
				
				
				
			}
			else{
				alert("Oops! Something went wrong!");
				return false;
						
			}
		});
			
	})
	
	
	
	function reArrageCustomListSortPositions(){
		if ( $(".alternating_full_width_row").length ) {
			$.each($('.alternating_full_width_row'),function(k, v){
				var sort_list_li = $(this).find('li');
				$.each(sort_list_li,function(key, value){
					$(this).find('.badge-no').html(parseInt(key)+1+'.');
				});
			});
		}
		
		if ( $(".alternating_little_row").length ) {
			$.each($('.alternating_little_row'),function(k, v){
				var sort_list_li = $(this).find('li');
				$.each(sort_list_li,function(key, value){
					$(this).find('.badge-no').html(parseInt(key)+1+'.');
				});
			});
		}
		
	}
	
	
	
	$('body').on('click','.full_alternate_popup', function(){
		
		var action_type = $(this).attr('action_type');
		var item_id = $(this).attr('item_id');
		var table_name = $(this).attr('table_name');
		var form_type = $(this).attr('form_type');
		//fullAlternatePopup
		
		if(form_type == "full_width_row"){
			$('#fullAlternatePopup').find('.modal-title').html(action_type + ' Alternating Full Width Row');
		}else{
			$('#fullAlternatePopup').find('.modal-title').html(action_type + ' Alternating Little Row');
		}
		
		
		
		$.ajax({

				url : 'admin/programs/ajax_full_alternate_popup',
				type : 'POST',
				data :{action_type : action_type, item_id : item_id,table_name:table_name,form_type:form_type},
				success:function(data){
					$('#form_alternate_popup').html(data);
					
					var full_desc = $('.ckfull_desc_editor1').html();
					CKEDITOR.instances['ckeditor_full_desc_editor1'].setData(full_desc);
					
					if(form_type == "little_row"){
						var littlerow_title = $('.ckfull_littlerow_title').html();
						CKEDITOR.instances['ckeditor_littlerow_title'].setData(littlerow_title);
					}
				}

		});
		
		
			
	})
	
	$('body').on('keyup','.required_field', function(){
		var check = $(this).val();
		if(check == '') {
			$(this).css('border','1px solid red');
		}else{
			$(this).css('border','1px solid rgb(223,223,223)');
		}
	});
	
	$('body').on('change','.required_field', function(){
		var check = $(this).val();
		if(check == '') {
			$(this).css('border','1px solid red');
		}else{
			$(this).css('border','1px solid rgb(223,223,223)');
		}
	});
	
	$('body').on('click','.save_full_row_add_btn', function(){
		
		var full_desc = CKEDITOR.instances['ckeditor_full_desc_editor1'].getData();
		var alt_row_form_type = $("#alt_row_form_type").val();
		var littlerow_title = "";
		if(alt_row_form_type == "little_row"){
			littlerow_title = CKEDITOR.instances['ckeditor_littlerow_title'].getData();
		}
		
		$('.form_error_msg').hide();
		var error = 0;
		$.each($('.required_field'),function(){
			var check = $(this).val();
			if(check == '') {
				$(this).css('border','1px solid red');
				error = 1;
			}
		})
		
		if(error == 0){
			
			var formData = $('#fullAlternateAddForm').serialize();
			
			$.ajax({ 					
				type: 'POST',						
				url : 'admin/programs/ajax_save_full_alternate_row',
				dataType : 'json',
				data: { formData : formData,littlerow_title:littlerow_title,full_desc:full_desc}					
				}).done(function(data){ 
				
				if(data.res == 1){
					
					if(data.form_action == "add"){
						
						var form_type = data.form_type;
						var total_numbers = $('.alternating_'+form_type+' li').length;
						var new_number = 1;
						if(new_number > 0){
							new_number = parseInt(total_numbers) + 1;
						}
						
						var total_record = $('.total_alternating_'+form_type).html();
						total_record = parseInt(total_record) + 1; 
						$('.total_alternating_'+form_type).html(total_record);
						
						$('.alternating_'+form_type).append('<li id="menu_'+data.id+'" class="'+form_type+'_'+data.id+'   az-contact-info-header ui-sortable-handle "><div class="manager-item media"><div style="float:left;"><div class="badge-no">'+new_number+'.</div><h4 class="'+form_type+'_heading_'+data.id+'"><a href="javascript:void(0)">'+data.title+' ( '+data.photo_side+' )</a></h4></div><div class="manager-item-opts"><nav class="nav"><a href="javascript:void(0)" class="badge badge-primary  full_alternate_popup" data-toggle="modal" data-target="#fullAlternatePopup" action_type="edit" item_id="'+data.id+'" table_name="'+data.table_name+'" form_type="'+form_type+'">Edit</a><a class="badge badge-primary delete_item" data-toggle="modal" data-target="#popupDeleteItem" item_id="'+data.id+'" table_name="'+data.table_name+'" item_title="'+data.title+'" section_type="'+form_type+'">Delete</a><a href="javascript:void(0)" id="unpub_'+data.id+'" class="sections_unpublish" table_name="'+data.table_name+'" is_new="1"><div class="az-toggle az-toggle-success alternate_full_width_toogle toogle_btn on" publish_type="0"><span></span><input type="hidden" name="publish_type" value="0" class="publish_type"></div></a></nav></div></div></li>');
						
						$('#fullAlternatePopup').modal('hide');
						
						$('#responsePopup').find('.action_response_msg').html('Successfully added!');
					}else{
						var item_id = data.id;
						var form_type = data.form_type;
						//alert('.'+form_type+'_heading_'+item_id); return false;
						$('.'+form_type+'_heading_'+item_id).find('a').html(data.title+' ( '+data.photo_side + ' )' );
						
						$('#fullAlternatePopup').modal('hide');
						
						$('#responsePopup').find('.action_response_msg').html('Successfully updated!');
					
					}
					
					$('#responsePopup').modal('show');
					setTimeout(function() {$('#responsePopup').modal('hide');}, 3000);
					
				}
			});
			
		}else{
			$('.form_error_msg').show();
		}
		
			
	})
	
	
});
</script>

<script language="javascript">
$(window).load(function(){
	if($('.receive_class_button_hidden_cb').val() == 0){
		$('.DetailBox').hide();
	}
	
	if($('.show_override_logo_hidden_cb').val() == 0){
		$('.override_logo_box').hide();
	}
	
});
$(document).ready(function(){
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



})
</script>
<?php 
	$display_class = '';
	if($user_level != 1){
		$display_class = 'display_class';
	}

?>

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
            <div>
			<nav class="pull-right"><a   data-toggle="modal" data-target="#modaldemo8" class="modal-effect badge-primary badge">Manage Order</a>
			
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
                <h6>Program </h6>
              </div>
				
            </a> -->
			
            <a href="<?php echo $page_url; ?>#QuestionHeadline" class="az-contact-item">
              <div class="az-contact-body">
                <h6>Question Headline </h6>
              </div><!-- az-contact-body -->
				
            </a><!-- az-contact-item -->
			
            <a href="<?php echo $page_url; ?>#Headersection" class="az-contact-item ">
              <div class="az-contact-body">
                 <h6>Header</h6>
              </div><!-- az-contact-body -->
			  
            </a><!-- az-contact-item -->
			<a href="<?php echo $page_url; ?>#WhiteStripeFirstSection" class="az-contact-item ">
			
              <div class="az-contact-body">
                <h6>White Stripe Under Header</h6>
              </div><!-- az-contact-body -->
				
            </a><!-- az-contact-item -->
			
			<a href="<?php echo $page_url; ?>#BenefitsRowImagesFirstSection" class="az-contact-item">
              <div class="az-contact-body">
                <h6>Benefits with 3 images</h6>
              </div><!-- az-contact-body -->
				
            </a><!-- az-contact-item -->
			
			<a href="<?php echo $page_url; ?>#videorowsection" class="az-contact-item">
              <div class="az-contact-body">
                <h6>Video Row</h6>
              </div><!-- az-contact-body -->
				 
            </a><!-- az-contact-item -->
			
			<a href="<?php echo $page_url; ?>#Calltoaction3ImagesSection" class="az-contact-item">
              <div class="az-contact-body">
                <h6>Call to Action with 3 Images</h6>
              </div><!-- az-contact-body -->
				
            </a>
			
			<a href="<?php echo $page_url; ?>#HeadingboxesSection" class="az-contact-item">
              <div class="az-contact-body">
                <h6>Heading with 3 boxes</h6>
              </div><!-- az-contact-body -->
				  
            </a><!-- az-contact-item -->
			
			
			<a href="<?php echo $page_url; ?>#StatisticsimagesSection" class="az-contact-item">
              <div class="az-contact-body">
                <h6>Statistics with 3 images</h6>
              </div><!-- az-contact-body -->
				  
            </a><!-- az-contact-item -->
			
			
			
			<a href="<?php echo $page_url; ?>#BenefitsRowImagesSecondSection" class="az-contact-item">
              <div class="az-contact-body">
                <h6>Benefits Row 2 with 3 Images</h6>
              </div><!-- az-contact-body -->
				 
            </a><!-- az-contact-item -->
			
			<a href="<?php echo $page_url; ?>#WhiteStripeSecondSection" class="az-contact-item ">
			
              <div class="az-contact-body">
                <h6>White Stripe Row 2</h6>
              </div><!-- az-contact-body -->
				
            </a>
			
			<a href="<?php echo $page_url; ?>#BenefitsRowImagesThirdSection" class="az-contact-item">
              <div class="az-contact-body">
                <h6>Benefits Row 3 with 3 Images</h6>
              </div><!-- az-contact-body -->
				 
            </a>
			
			<a href="<?php echo $page_url; ?>#EmailOptin" class="az-contact-item">
              <div class="az-contact-body">
                <h6>Email Opt-in #1 & #2</h6>
              </div><!-- az-contact-body -->
				 
            </a>
			
			
			
			<a href="<?php echo $page_url; ?>#testimonials_faqs" class="az-contact-item">
              <div class="az-contact-body">
                <h6>Testimonials & FAQs</h6>
              </div><!-- az-contact-body -->
				 
            </a><!-- az-contact-item -->
			
			
			<a href="<?php echo $page_url; ?>#Htmleditor_Basic_detail" class="az-contact-item">
              <div class="az-contact-body">
                <h6>HTML Editor & Basic Details</h6>
              </div><!-- az-contact-body -->
            </a>
			
			
			<a href="<?php echo $page_url; ?>#AlternatingFullWidth" class="az-contact-item">
              <div class="az-contact-body">
                <h6>Alternating Full Width Rows</h6>
              </div><!-- az-contact-body -->
            </a><!-- az-contact-item -->
			<a href="<?php echo $page_url; ?>#AlternatingLittleRows" class="az-contact-item">
              <div class="az-contact-body">
                <h6>Alternating Little Rows</h6>
              </div><!-- az-contact-body -->
            </a><!-- az-contact-item -->

			
          </div><!-- az-contacts-list -->

        </div> <!-- az-content-left -->
        <div class="az-content-body az-content-body-contacts">
			
				<div class="az-mail-header">
            <div>
              <h4 class="az-content-title mg-b-5">EDIT PROGRAM</h4>
            </div>
            
          </div>
				
				<div class=" edit-form edit_form_box">
					<form id="blog_form" class="programForm" action="" method="post" enctype="multipart/form-data">
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

/*.inner-wrapper-sticky{ bottom:0px !important; top:inherit !important;} */
#sidebar .sidebar__inner .form-white-holder{ padding:10px 5px !important;}		
#sidebar .inner-wrapper-sticky .btn-save{ display:inline-block; float:none !important;}		

.label-text{padding-top:35px;font-size:18px;color:#a438ff;padding-bottom: 5px;}	
	
</style>
		
	<!--	<div id="sidebar">
			<div class="sidebar__inner">
<div class="form-white-holder" style="padding-bottom:20px;">
	
	<input type="button"  name="update" value="Save" class="btn-save saveProgramButton" action_type="save"/> 
	<input type="button"  name="update" value="Save & Continue" class="btn-save saveProgramButton"  action_type="save_and_continue" style="width:160px;margin-left:3px" />
	
</div>
</div>
</div> -->
		<div class="panel-body"  id="content">
		<div class="panel-body-holder">
		<div class="form-holder">


<?php if(!empty($details)): ?>
<?php foreach($details as $details): ?>
<div >
<div class="page-section" id="ProgramBasicSection">
<div class="mb-3 main-content-label">Program Basic Information</div>
<div class="form-light-holder">
	<a id="published" class="show_override_logo_checkbox <?php if($details->show_override_logo == 1) echo "check-on"; else echo "check-off";?>" ></a>
	<h1 class="inline">Show Override Logo</h1>
	<input type="hidden" value="<?php if(!empty($details)){ echo $details->show_override_logo; } else{ echo 0; }?>" name="show_override_logo" class="show_override_logo_hidden_cb" />
</div>
<div class="form-light-holder override_logo_box">
<h1>Override Logo</h1>
	<select name="override_logo" id="override_logo" class="field">
	<?php foreach($override_logos as  $override_logo):?>
	<option value="<?=$override_logo->s_no?>" <?php if($details->override_logo == $override_logo->s_no){ echo 'selected=selected';} ?>><?=$override_logo->logo_name?></option>
	<?php endforeach;?>
	</select>
</div>


<div class="form-light-holder  d-md-flex  dual_input">
	<div class="adsUrl form-group">
		<h1>Program Name</h1>
		<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($details->program);?>" name="name" id="name" class="field" placeholder="Enter your name here" />
	</div>
	<div class="linkTarget form-group">
		<h1>Button Name</h1>
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($details->buttonName);?>" name="btnname" id="btnname" class="field" placeholder="Enter your button name here"/>
	</div>
	
</div>
<div class="form-light-holder  d-md-flex  dual_input">
<div class="adsUrl  form-group">
	<h1>Slug (URL Rewriting)</h1>
	<input type="text" value="<?=$details->program_slug;?>" name="slug" id="slug" class="field" placeholder="Enter your slug here"/>
	</br></em>Note: Slug will automatically generate from  program name  if left blank</em>
	</div>
	<div class="linkTarget  form-group">
		<h1>Ages</h1>
		<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($details->ages);?>" name="ages" id="" class="field" placeholder="Enter Ages here" />
	</div>
</div>

<div class="form-light-holder  d-md-flex  dual_input" style="">
	<div class="adsUrl  form-group">
		<h1>Category</h1>
		<select name="category" id="category" class="field" style="" >
		<?php
		if(!empty($cat)):
		foreach($cat as $cat):
		?>
		<option value="<?=$cat->cat_id?>" <?php if($details->category == $cat->cat_id) echo "selected='selected'";?>><?=$cat->cat_name?></option>
		<?php
		endforeach;
		endif;
		?>
		</select>
	</div>
	<div class="linkTarget  form-group">
	<h1>Program Type</h1>
		<select name="program_type" id="program_type" class="field" style="" >
		<option value="program_page" <?php echo ($details->program_type == "program_page") ? 'selected=selected' : ''; ?>>Program Page</option>
		<option value="birthday_page"  <?php echo ($details->program_type == "birthday_page") ? 'selected=selected' : ''; ?>>Birthday Page</option>
		<option value="summer_camp"  <?php echo ($details->program_type == "summer_camp") ? 'selected=selected' : ''; ?>>Summer Camp</option>
		</select>
	</div>
	
</div>

<div id="redirection_default_box">
<div class="form-light-holder  d-md-flex  dual_input">
	<div class="adsUrl  form-group">
		<h1>Redirection Type</h1>
		<label class="rdiobox">
		<input type="radio" value="trial_offer" class="redirection_type" name="redirection_type" <?php echo ($details->redirection_type == "trial_offer") ? 'checked=checked' : ''; ?> /><span>Trial Offer</span></label>
		<label class="rdiobox">
		<input type="radio" value="dojocart" class="redirection_type" name="redirection_type" <?php echo ($details->redirection_type == "dojocart") ? 'checked=checked' : ''; ?> /><span>Dojocart</span></label>
		
		<label class="rdiobox">
		<input type="radio" value="thankyou_page" class="redirection_type" name="redirection_type" <?php echo ($details->redirection_type == "thankyou_page") ? 'checked=checked' : ''; ?> /><span>Thank you Page</span></label>
		
		<label class="rdiobox">
		<input type="radio" value="third_party_url" class="redirection_type" name="redirection_type" <?php echo ($details->redirection_type == "third_party_url") ? 'checked=checked' : ''; ?> /><span>Third Party Url</span></label>
	</div>
	
	<div class="linkTarget  form-group">
		<h1>Redirection Link</h1>	
		<div class="trial_offer_list" style="display:none">
			<select name="trial_offer_id" class="field" >
			<option value="">-Select-</option>
			<?php foreach($trialCategories as  $trialCategory):?>
			<option value="<?=$trialCategory->id?>" <?php if($details->trial_offer_id == $trialCategory->id){ echo 'selected=selected';} ?>><?=$trialCategory->name?></option>
			<?php endforeach;?>
			</select>
		</div>
		<div class="dojocart_list" style="display:none">
			<select name="dojocart_id" class="field">
			<option value="">-Select-</option>
			<?php foreach($dojocarts as  $dojocart):?>
			<option value="<?=$dojocart->id?>" <?php if($details->dojocart_id == $dojocart->id){ echo 'selected=selected';} ?>><?=$dojocart->product_title?></option>
			<?php endforeach;?>
			</select>
		</div>


		<div class="thankyou_page_list" style="display:none">
			<select name="thankyou_page_id" class="field">
			<option value="">-Select-</option>
			<?php foreach($thankyou_pages as  $thankyou_page):?>
			<option value="<?=$thankyou_page->id?>" <?php if($details->thankyou_page_id == $thankyou_page->id){ echo 'selected=selected';} ?>><?=$thankyou_page->title?></option>
			<?php endforeach;?>
			</select>
		</div>


		<div class="third_party_url" style="display:none">
			<input type="text" name="third_party_url" value="<?php echo $this->query_model->getStrReplaceAdmin($details->third_party_url);?>">
		</div>
	</div>
</div>

</div>



<div id="redirection_button1_box" style="display:none">
<h1 class="button1">Button 1</h1>
<div class="form-light-holder  d-md-flex  dual_input">
	<div class="adsUrl  form-group">
		<h1>Redirection Type</h1>
		<label class="rdiobox">
		<input type="radio" value="trial_offer" class="button1_redirection_type" name="button1_redirection_type" <?php echo ($details->button1_redirection_type == "trial_offer") ? 'checked=checked' : ''; ?> /><span>Trial Offer</span></label>
		
		<label class="rdiobox">
		<input type="radio" value="dojocart" class="button1_redirection_type" name="button1_redirection_type" <?php echo ($details->button1_redirection_type == "dojocart") ? 'checked=checked' : ''; ?> /><span>Dojocart</span></label>
		
		<label class="rdiobox">
		<input type="radio" value="thankyou_page" class="button1_redirection_type" name="button1_redirection_type" <?php echo ($details->button1_redirection_type == "thankyou_page") ? 'checked=checked' : ''; ?> /><span>Thank you Page</span></label>
		
		<label class="rdiobox">
		<input type="radio" value="third_party_url" class="button1_redirection_type" name="button1_redirection_type" <?php echo ($details->button1_redirection_type == "third_party_url") ? 'checked=checked' : ''; ?> /><span>Third Party Url</span></label>
		
	</div>
	<div class="linkTarget  form-group">
		<h1>Redirection Link</h1>	
		<div class="button1_trial_offer_list" style="display:none">
			<select name="button1_trial_offer_id" class="field" >
			<option value="">-Select-</option>
			<?php foreach($trialCategories as  $trialCategory):?>
			<option value="<?=$trialCategory->id?>" <?php if($details->button1_trial_offer_id == $trialCategory->id){ echo 'selected=selected';} ?>><?=$trialCategory->name?></option>
			<?php endforeach;?>
			</select>
		</div>
		<div class="button1_dojocart_list" style="display:none">
			<select name="button1_dojocart_id" class="field">
			<option value="">-Select-</option>
			<?php foreach($dojocarts as  $dojocart):?>
			<option value="<?=$dojocart->id?>" <?php if($details->button1_dojocart_id == $dojocart->id){ echo 'selected=selected';} ?>><?=$dojocart->product_title?></option>
			<?php endforeach;?>
			</select>
		</div>

		<div class="button1_thankyou_page_list" style="display:none">
			<select name="button1_thankyou_page_id" class="field">
			<option value="">-Select-</option>
			<?php foreach($thankyou_pages as  $thankyou_page):?>
			<option value="<?=$thankyou_page->id?>" <?php if($details->button1_thankyou_page_id == $thankyou_page->id){ echo 'selected=selected';} ?>><?=$thankyou_page->title?></option>
			<?php endforeach;?>
			</select>
		</div>
		<div class="button1_third_party_url" style="display:none">
			<input type="text" name="button1_third_party_url" value="<?php echo $this->query_model->getStrReplaceAdmin($details->button1_third_party_url);?>">
		</div>
	</div>
</div>

</div>





<div id="redirection_button2_box" style="display:none">
<h1 class="button2">Button 2</h1>
<div class="form-light-holder  d-md-flex  dual_input">
	<div class="adsUrl  form-group">
		<h1>Redirection Type</h1>
		<label class="rdiobox">
		<input type="radio" value="trial_offer" class="button2_redirection_type" name="button2_redirection_type" <?php echo ($details->button2_redirection_type == "trial_offer") ? 'checked=checked' : ''; ?> /></span>Trial Offer</span></label>
		<label class="rdiobox">
		<input type="radio" value="dojocart" class="button2_redirection_type" name="button2_redirection_type" <?php echo ($details->button2_redirection_type == "dojocart") ? 'checked=checked' : ''; ?> /></span>Dojocart</span></label>
		<label class="rdiobox">
		<input type="radio" value="thankyou_page" class="button2_redirection_type" name="button2_redirection_type" <?php echo ($details->button2_redirection_type == "thankyou_page") ? 'checked=checked' : ''; ?> /></span>Thank you Page</span></label>
		<label class="rdiobox">
		<input type="radio" value="third_party_url" class="button2_redirection_type" name="button2_redirection_type" <?php echo ($details->button2_redirection_type == "third_party_url") ? 'checked=checked' : ''; ?> /></span>Third Party Url</span></label>
	</div>
	<div class="linkTarget  form-group">
		<h1>Redirection Link</h1>	
		<div class="button2_trial_offer_list" style="display:none">
			<select name="button2_trial_offer_id" class="field" >
			<option value="">-Select-</option>
			<?php foreach($trialCategories as  $trialCategory):?>
			<option value="<?=$trialCategory->id?>" <?php if($details->button2_trial_offer_id == $trialCategory->id){ echo 'selected=selected';} ?>><?=$trialCategory->name?></option>
			<?php endforeach;?>
			</select>
		</div>
		<div class="button2_dojocart_list" style="display:none">
			<select name="button2_dojocart_id" class="field">
			<option value="">-Select-</option>
			<?php foreach($dojocarts as  $dojocart):?>
			<option value="<?=$dojocart->id?>" <?php if($details->button2_dojocart_id == $dojocart->id){ echo 'selected=selected';} ?>><?=$dojocart->product_title?></option>
			<?php endforeach;?>
			</select>
		</div>

		<div class="button2_thankyou_page_list" style="display:none">
			<select name="button2_thankyou_page_id" class="field">
			<option value="">-Select-</option>
			<?php foreach($thankyou_pages as  $thankyou_page):?>
			<option value="<?=$thankyou_page->id?>" <?php if($details->button2_thankyou_page_id == $thankyou_page->id){ echo 'selected=selected';} ?>><?=$thankyou_page->title?></option>
			<?php endforeach;?>
			</select>
		</div>
		<div class="button2_third_party_url" style="display:none">
			<input type="text" name="button2_third_party_url" value="<?php echo $this->query_model->getStrReplaceAdmin($details->button2_third_party_url);?>">
		</div>
	</div>
</div>

</div>

<div class="form-light-holder">
		<h1>Connect to trial offer category</h1>
			<select name="connect_trial_offer_id" class="field" >
			<option value="0" >--Select--</option>
			<?php foreach($trialCategories as  $trialCategory):?>
			<option value="<?=$trialCategory->id?>" <?php if($details->connect_trial_offer_id == $trialCategory->id){ echo 'selected=selected';} ?>><?=$trialCategory->name?></option>
			<?php endforeach;?>
			</select>
		</div>
		

<div class="form-light-holder display-none">
        <h1>Features</h1>
		<div id="AddMoreFeatures">
		
			<div class=""><h3><a href="javascript:void(0);" class="AddMoreButton">Add More</a></h3></div>
			<?php $features = unserialize($details->features);
					
					if(!empty($features)){
						$i = 1;
						foreach($features as $feature){
			 ?>
        	&#10687;<input type="text"  name="features[<?= $i ?>]" id="features" value="<?php echo $this->query_model->getStrReplaceAdmin($feature); ?>" class="field"  placeholder="Enter Features here"/><br>
			<?php $i++; } } else { ?>
			&#10687;<input type="text"  name="features[1]" id="features" value="" class="field"  placeholder="Enter Features here"/><br>
			<?php } ?>
		</div>
    </div>
	
	
	
<div class="form-light-holder display-none" style="">
	<h1>Description</h1>
	<!--<textarea name="text" class="textarea" id="frm-text"><?=html_entity_decode($details->desc);?></textarea>
	--><textarea name="text" id="ckeditor_full_body_desc" class="ckeditor" id="frm-text"><?=$details->desc;?></textarea>
</div>

<div class="form-light-holder display-none" style="overflow:auto;">
	<h1 style="padding-bottom: 5px;">Choose a Photo</h1>
	<?php if(!empty($details->photo)): ?>
	<div><img id="img" src="<?=$details->photo;?>" style="width: 100px; clear:both;" /></div>
	<input type="hidden" name="last-photo" id="last-photo" value="<?=$details->photo;?>" />
	<?php endif;?>
	<input type="file" name="userfile" id="photo" accept="image/*" />
	<?php if($details->photo){ 
			echo "<a href='javascript:void(0);' class=' delete_image_btn_new' id='delete_img'>Delete image</a>";
			}
	?>	
		<div>
		</div>
</div>


<div class="mb-3 main-content-label">Program Category Summary</div>

<div class="form-light-holder">
	<h1>Summary</h1>
	<textarea name="program_cat_summary" id="ckeditor_full_program_cat_summary" class="text ckeditor" style="width:50%"><?=$details->program_cat_summary;?></textarea>
	
</div>

<div class="form-light-holder   d-md-flex  dual_input" style="overflow:auto;">
		<div class="adsUrl  form-group">
	<h1 style="padding-bottom: 5px;">Image</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="program_cat_image"  class="custom-file-input" id="customFile1">
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	<?php if(!empty($details->program_cat_image)): ?>
	<div><img id='img_program_cat' src="<?=base_url().'upload/programs/'.$details->program_cat_image;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-program_cat_image" class="old_image_value" value="<?=$details->program_cat_image;?>" />
	<?php endif;?>
	
	
	<?php if(!empty($details->program_cat_image)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages delete_image_btn_new' field_name='program_cat_image'  number='".$details->id."'>Delete image</a>";
			}
	?>	
	</div>
	
	<div class="linkTarget  form-group">
		<h1 style="">Image alt text</h1>
		<input value="<?php echo $this->query_model->getStrReplaceAdmin($details->program_cat_image_alt_text); ?>" name="program_cat_image_alt_text" id="" class="field"  type="text">
		</div>
</div>
<div class="form-light-holder   d-md-flex  dual_input">
	<div class="adsUrl  form-group">
		<h1>PHOTO ON RIGHT/ LEFT</h1>
			<select name="cat_photo_side" class="field">
				<option value="right" <?php echo ($details->cat_photo_side == "right") ? 'selected=selected' : ''; ?>>Photo on Right</option>
				<option value="left" <?php echo ($details->cat_photo_side == "left") ? 'selected=selected' : ''; ?>>Photo on Left</option>
			</select>
		</div>
	
	<div class="linkTarget  form-group">
		<h1>Image Top Spacing (pixels)</h1>
	<input type="text" name="program_cat_img_top_spacing" id="program_cat_img_top_spacing" class="field  img_top_spacing" placeholder=""  style="width: 100% !important" value="<?php echo $this->query_model->getStrReplaceAdmin($details->program_cat_img_top_spacing);?>"/> <!--<span style="font-size:15px"><strong>px</strong></span>--><br/>
	<em>Note: Please use only integer or float value. don't use "px" in<br/>  input field</em>
	</div>
</div>

</div>

<div style="display:<?php echo ($multiSchool == 1) ? 'block' :'none'; ?>">

<div class="mb-3 main-content-label">Featured Program Image</div>
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Featured Program Image</h1>
	
	<div class="custom-file half_width_custom_file">
		<input type="file" field_name="featured_program_img" class="custom-file-input programImage" accept="image/*"  id="customFile2" />
		<input type="hidden" name="featured_program_img" id="featured_program_img"  value="<?=$details->featured_program_img;?>"  />
	
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	
	
	<?php if(!empty($details->featured_program_img)): ?>
	<div><img id='img_bg_action' src="<?=base_url().'upload/programs/'.$details->featured_program_img;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-featured_program_img" class="old_image_value"  value="<?=$details->featured_program_img;?>" />
	<?php endif;?>
	<!--<input type="file" name="featured_program_img" id="photo_left" accept="image/*" /> -->
	<?php if(!empty($details->featured_program_img)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages delete_image_btn_new' field_name='featured_program_img'  number='".$details->id."'>Delete image</a>";
			}
	?>	
		<div>
	<h1 style="padding-top: 5px;">Image alt text</h1>
	<input value="<?php echo $details->featured_program_img_alt_text; ?>" name="featured_program_img_alt_text" id="" class="field full_width_input"  type="text">
	</div>
</div>
</div>


<div class="form-light-holder form3checkbox">

	<a id="show_learn_more" class="checkbox3 <?php echo (!empty($details) && $details->show_learn_more == 1) ? 'check-on' : 'check-off'; ?>"></a>

<h1 class="inline">Show Learn More Button</h1>
	
	
	<input type="hidden" value="<?php echo (!empty($details) && $details->show_learn_more == 1) ? 1 : 0; ?>" name="show_learn_more" class="hidden_cb3" />

</div>


<div class="form-light-holder landing_page <?php echo $display_class; ?>">
	
	<a id="free_trials" class="checkbox_landing_page <?php if($details->landing_checkbox == 1) echo "check-on"; else echo "check-off";?>"></a>
	<h1 class="inline">Link to other landing page</h1>
	<input type="hidden" value="<?=$details->landing_checkbox?>" name="landing_checkbox" class=" stand_alone_page_button checkbx1" />
</div>
<div id="landing_page_box" style="display:<?php if($user_level != 1 && $details->landing_checkbox == 0){ echo 'none'; } else{ echo 'block'; }  ?>">
<div class="form-light-holder">
<div class="row row-xs align-items-center">
<div class="col-md-5">
	<h1>Select Program</h1>
		<select name="landing_program"  id="" class="field landing_program" style="width:100% !important" >
			<option value="">-Select Program-</option>
			<?php foreach($leanding_programs as $stand_program){
					$this->db->select(array('cat_id','cat_slug'));
					$cateogry_detail = $this->query_model->getbySpecific('tblcategory','cat_id', $stand_program->category);
					
					if($stand_program->id != $this->uri->segment(4)){
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
				<option  number="<?php echo $stand_program->id ?>" value="<?php echo $program_url; ?>" <?php if($details->landing_program_id == $stand_program->id){ echo 'selected=selected';} ?>><?= $stand_program->program ?></option>
			<?php } } ?>
		</select>
		<input type="hidden" name="landing_program_id" class="landing_program_id" value="<?php if(!empty($details->landing_program_id)){ echo $details->landing_program_id ; } ?>" />
	</div>
	<div class="col-md-2 text-center">
	<h1 class="orbtn">OR</h1>
	</div>
	<div class="col-md-5">
	<h1>Landing Page Url</h1>
		<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($details->landing_page_url);?>" name="landing_page_url" class="field landing_page_url full_width_input" placeholder="Enter Url here" />
		
	</div>
	<!--<div class="col-md-12 text-right">
	<p class="urlErrorMsg"></p>
	</div>  -->
</div>		
		
	</div>
	</div>


<div class="form-light-holder receive_class_button">
	<a id="published" class="receive_class_button_checkbox <?php if($details->receive_class_button == 1) echo "check-on"; else echo "check-off";?>" ></a>
	<h1 class="inline">receive class schedule & pricing</h1>
	<input type="hidden" value="<?php if(!empty($details)){ echo $details->receive_class_button; } else{ echo 0; }?>" name="receive_class_button" class="receive_class_button_hidden_cb" />
</div>
<div  class="DetailBox">
<div class="form-light-holder  d-md-flex  dual_input">
	
    <div class="adsUrl  form-group">
		<h1>Button Text</h1>
		<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($details->receive_button_text);?>" name="receive_button_text" id="name" class="field" placeholder="Enter your button text here" />
	</div>
	<div class="linkTarget  form-group">
		<h1>Button Link</h1>
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($details->receive_button_link);?>" name="receive_button_link" id="btnname" class="field" placeholder="Enter your button url here"/>
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
			<?php $guests_values = !empty($details->guests_values) ?  unserialize($details->guests_values) : '';
					if(!empty($guests_values)){
					$i = 1;
					foreach($guests_values as $guests_value){
			 ?>
        	<span class="featureBox_<?= $i ?>">
			 &#10687;<input type="text"  name="guests_values[<?= $i ?>]" id="guests_values" value="<?php echo $this->query_model->getStrReplaceAdmin( $guests_value); ?>" class="field"   placeholder="Enter Guest Value here"/>
			 <?php if($i > 1){ ?>
			 <i class="fa fa-close" style="cursor:pointer;" onclick="$(this).parent().remove();">Delete</i>
			 <?php }?>
			<br> </span>
			<?php $i++; }  } else { ?>
			&#10687;<input type="text"  name="guests_values[1]" id="guests_values" value="1-5" class="field"   placeholder="Enter Guest Value here"/><br>
			&#10687;<input type="text"  name="guests_values[2]" id="guests_values" value="6-10" class="field"   placeholder="Enter Guest Value here"/><br>
			&#10687;<input type="text"  name="guests_values[3]" id="guests_values" value="10+" class="field"   placeholder="Enter Guest Value here"/><br>
			<?php } ?>
		</div>
		<input type="hidden" class="totalAddMoreGuestValues" value="<?php if(count($guests_values) >= 1){ echo count($guests_values); } else { echo 3; } ?>"  />
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
<div class="mb-3 main-content-label">Question Headline</div>
<div class="form-light-holder">

	<h1>Question Headline</h1>
	
	
	<textarea type="text" id="ckeditor_mini_question_headline" name="question_headline" class="field ckeditor full_width_input" style=""><?php echo (!empty($details) && !empty($details->question_headline)) ? $details->question_headline : ''; ?></textarea>
</div>
</div>

<div class="page-section" id="Headersection">
<div class="mb-3 main-content-label">Header</div>
<div class="form-light-holder">
	<h1>Header</h1>
	<textarea type="text" id="ckeditor_mini_header_title" name="header_title" class="field ckeditor full_width_input" style=""><?=$details->header_title;?></textarea>
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
			<input type="radio" class="header_image_video" name="header_image_video" value="image" <?php if(!empty($details) && $details->header_image_video == 'image'){ echo 'checked=checked'; } elseif(empty($details->header_image_video)){  echo 'checked=checked'; } ?>  />
			<span>Image</span>
		  </label>
		</div><!-- col-3 -->
		<div class="col-lg-9 mg-t-20 mg-lg-t-0">
		  <label class="rdiobox">
			<input type="radio" class="header_image_video" name="header_image_video" value="video" <?php if(!empty($details) && $details->header_image_video == 'video'){ echo 'checked=checked'; }?> />
			<span>Video</span>
		  </label>
		</div><!-- col-3 -->
		</div>
	</div>
</div>

</div>
<div class="header_welcome_video">
<div class="form-light-holder  d-md-flex  dual_input">
	<div class="adsUrl  form-group">
		<h1>Video Type</h1>
		<select name="header_video_type" id="" class="field header_videoType" >
		<option value="youtube_video" <?php if($details->header_video_type == 'youtube_video'){ echo 'selected=selected'; } ?>>Youtube Video</option>
		<option value="vimeo_video" <?php if($details->header_video_type == 'vimeo_video'){ echo 'selected=selected'; } ?>  >Vimeo Video</option>
	</select>
	
	</div>
	<div class="linkTarget  form-group">
	<div class="header_youtube_video">
	<h1>Youtube Video</h1>
	<input type="text" name="header_youtube_video" value="<?=$details->header_youtube_video;?>" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://www.youtube.com/embed/UWCbfxwwC-I
	</div>
	</div>
	<span class="header_orButton">OR</span>
	<div class="header_vimeo_video">
	<h1>Vimeo Video</h1>
	<input type="text" name="header_vimeo_video" value="<?=$details->header_vimeo_video;?>" class="field" >
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
		<input id="header_title_colorpicker_opacity" name="header_title_background_color" class="colourHeaderTitleValue" value="<?php if(!empty($details)){ echo $details->header_title_background_color; }?>" />
    </div>
	
 </div>
</div>
<div class="form-light-holder">
	<h1>Header Description</h1>
			<div class="shorterCkeditor"><textarea name="header_desc"  id="ckeditor_mini_header_desc" class="text ckeditor shorterCkeditor"><?=$details->header_desc;?></textarea></div>
</div>
<div class="form-light-holder   d-md-flex  dual_input" style="overflow:auto;">
		<div class="adsUrl  form-group">
			<h1 style="padding-bottom: 5px;">Header image</h1>
			
			<div class="custom-file half_width_custom_file">
			<input type="file" name="header_image"  class="custom-file-input" id="customFile3" accept="image/*" />
			<label class="custom-file-label" for="customFile">Choose file</label></div>
			
			<?php if(!empty($details->header_image)): ?>
			<div><img id="header_img" src="upload/programs/<?=$details->header_image;?>" style="width: 100px; clear:both;" /></div>
			<input type="hidden" id="last_header_image" name="last_header_image" value="<?=$details->header_image;?>" />
			<?php endif;?>
			
			<?php if($details->header_image){ 
					echo "<a href='javascript:void(0);' class=' delete_image_btn_new' id='delete_header_img'>Delete image</a>";
					}
			?>	
		</div>
	
	<div class="linkTarget  form-group">
		<h1 >Image alt text</h1>
		<input value="<?php echo $this->query_model->getStrReplaceAdmin($details->header_image_alt_text); ?>" name="header_image_alt_text" id="" class="field"  type="text">
		</div>
</div>
</div>
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl  form-group">
	<h1>Background Image</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="background_image" class="custom-file-input" id="customFile4" accept="image/*" />
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	
	<?php if(!empty($details->background_image)): ?>
	<div><img id='img_bg' src="<?=base_url().'upload/programs/'.$details->background_image;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-background_image" class="old_image_value" value="<?=$details->background_image;?>" />
	<?php endif;?>
	
	<?php if(!empty($details->background_image)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages delete_image_btn_new' field_name='background_image'  number='".$details->id."'>Delete image</a>";
			}
	?>	
	</div>
	
	<div class="linkTarget  form-group">
		<h1> Color Overlay And Opacity  Picker</h1>
		<div id='docs-header'>
		<div id='docs-content-header'>
			<input id="full_colorpicker_opacity" name="background_color" class="colourTextValue" value="<?php if(!empty($details)){ echo $details->background_color; }?>" />
		</div>
		
	 </div>
	</div>
</div>

	
</div>	


<div class="page-section" id="WhiteStripeFirstSection">
<div class="mb-3 main-content-label">White Stripe Under Header</div>
<div class="form-light-holder">
	<h1>Body Title</h1>
	<textarea type="text" name="body_title" id="ckeditor_mini_body_title1" class="field ckeditor full_width_input" style=""><?=$details->body_title;?></textarea>
</div>
<div class="form-light-holder">
	<h1>Body Description</h1>
	<textarea name="body_desc" id="ckeditor_full_body_desc1" class="text ckeditor" style="width:50%"><?=$details->body_desc;?></textarea>
	
</div>



<div class="form-light-holder   d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl  form-group">
	
	<h1 style="padding-bottom: 5px;">Body Image</h1>
	
	<div class="custom-file half_width_custom_file">
		<input type="file" name="body_image" class="custom-file-input" id="customFile5" accept="image/*" />		
		<label class="custom-file-label" for="customFile">Choose file</label>
	</div>

	
	<?php if(!empty($details->body_image)): ?>
	<div><img id='img_body_image' src="<?=base_url().'upload/programs/'.$details->body_image;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-body_image" class="old_image_value" value="<?=$details->body_image;?>" />
	<?php endif;?>
	
	<?php if(!empty($details->body_image)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages delete_image_btn_new' field_name='body_image'  number='".$details->id."'>Delete image</a>";
			}
	?>	
	</div>
	
	<div class="linkTarget  form-group">
		<h1 >Image alt text</h1>
		<input value="<?php echo $this->query_model->getStrReplaceAdmin($details->body_image_alt_text); ?>" name="body_image_alt_text" id="" class="field"  type="text">
		</div>
</div>
<div class="form-light-holder   d-md-flex  dual_input">
	<div class="adsUrl  form-group">
	<h1>Image Position</h1>
	<select name="body_img_position" class="field">
		<option value="left" <?php echo (!empty($details) && $details->body_img_position == "left") ? 'selected=selected' : ''; ?>>Left</option>
		<option value="right"  <?php echo (!empty($details) && $details->body_img_position == "right") ? 'selected=selected' : ''; ?>>Right</option>
	</select>
	</div>
	
	<div class="linkTarget  form-group">
		<h1> Color Overlay And Opacity  Picker</h1>
		<div id='docs-white_stripe'>
		<div id='docs-content-white_stripe'>
			<input id="white_stripe_colorpicker_opacity" name="white_stripe_background_color" class="colourTextValueWhiteStripe" value="<?php if(!empty($details)){ echo $details->white_stripe_background_color; }?>" />
		</div>
		
	 </div>
	</div>
	
</div>

</div>


<div class="page-section" id="BenefitsRowImagesFirstSection">
<div class="mb-3 main-content-label">Benefits with 3 images</div>
<div class="form-light-holder">
	<h1>Benefits Title</h1>
	<input type="text" name="benefits_title" value="<?=$details->benefits_title;?>" class="field full_width_input" style="">
</div>

<div class="form-light-holder">
	<h1>Benefits description</h1>
	<div class="shorterCkeditor"><textarea name="benefits_desc" id="ckeditor_mini_benefits_desc" class="text ckeditor"><?=$details->benefits_desc;?></textarea></div>
</div>

	
<div class="form-light-holder   d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl  form-group">
	<h1 >Background Image</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="benefits_background_image"  class="custom-file-input" id="customFile6" accept="image/*" />	
	<label class="custom-file-label" for="customFile">Choose file</label>
	</div>
	<?php if(!empty($details->benefits_background_image)): ?>
	<div><img id='img_bg_action' src="<?=base_url().'upload/programs/'.$details->benefits_background_image;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-benefits_background_image"  class="old_image_value"  value="<?=$details->benefits_background_image;?>" />
	<?php endif;?>
	
	<?php if(!empty($details->benefits_background_image)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages delete_image_btn_new' field_name='benefits_background_image'  number='".$details->id."'>Delete image</a>";
			}
	?>	
	</div>
	
	<div class="linkTarget  form-group">
		<h1> Color Overlay And Opacity  Picker</h1>
			<div id='docs-benefits'>
			<div id='docs-content-benefits'>
				<input id="benefits_colorpicker_opacity" name="benefits_background_color" class="colourTextValueBenefits" value="<?php if(!empty($details)){ echo $details->benefits_background_color; }?>" />
			</div>
			
		 </div>
		</div>
</div>



<div class="form-light-holder">
	<h1>Headline #1</h1>
	<input type="text" name="benefits_headline_1" value="<?php echo $this->query_model->getStrReplaceAdmin($details->benefits_headline_1);?>" class="field full_width_input" style="">
	
</div>
<div class="form-light-holder   d-md-flex  dual_input" style="overflow:auto;">
		<div class="adsUrl  form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #1</h1>
	
	<div class="custom-file half_width_custom_file">
		<input type="file" name="benefits_image_1" class="custom-file-input" id="customFile7" accept="image/*" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>

	<?php if(!empty($details->benefits_image_1)): ?>
	<div><img id='img_bg_action_image_1' src="<?=base_url().'upload/programs/'.$details->benefits_image_1;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-benefits_image_1" class="old_image_value"  value="<?=$details->benefits_image_1;?>" />
	<?php endif;?>
	
	<?php if(!empty($details->benefits_image_1)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages delete_image_btn_new' field_name='benefits_image_1'  number='".$details->id."'>Delete image</a>";
			}
	?>	
	</div>
	
	<div class="linkTarget  form-group">
		<h1 >Image alt text</h1>
		<input value="<?php echo $this->query_model->getStrReplaceAdmin($details->benefits_image_1_alt_text); ?>" name="benefits_image_1_alt_text" id="" class="field "  type="text">
		</div>
</div>


<div class="form-light-holder ">
	<h1>Headline #2</h1>
	<input type="text" name="benefits_headline_2" value="<?php echo $this->query_model->getStrReplaceAdmin($details->benefits_headline_2);?>" class="field full_width_input" style="">
</div>
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl  form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #2</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="benefits_image_2"  class="custom-file-input" id="customFile8" accept="image/*" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
	<?php if(!empty($details->benefits_image_2)): ?>
	<div><img id='img_bg_action_image_2' src="<?=base_url().'upload/programs/'.$details->benefits_image_2;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-benefits_image_2"  class="old_image_value"  value="<?=$details->benefits_image_2;?>" />
	<?php endif;?>
	
	<?php if(!empty($details->benefits_image_2)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages delete_image_btn_new' field_name='benefits_image_2'  number='".$details->id."'>Delete image</a>";
			}
	?>	
	</div>
	
	<div class="linkTarget  form-group">
		<h1 >Image alt text</h1>
		<input value="<?php echo $this->query_model->getStrReplaceAdmin($details->benefits_image_2_alt_text); ?>" name="benefits_image_2_alt_text" id="" class="field "  type="text">
		</div>
</div>

<div class="form-light-holder">
	<h1>Headline #3</h1>
	<input type="text" name="benefits_headline_3" value="<?php echo $this->query_model->getStrReplaceAdmin($details->benefits_headline_3);?>" class="field full_width_input" style="">
</div>
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
		<div class="adsUrl  form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #3</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="benefits_image_3"  class="custom-file-input" id="customFile9" accept="image/*" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>

	<?php if(!empty($details->benefits_image_3)): ?>
	<div><img id='img_bg_action_image_3' src="<?=base_url().'upload/programs/'.$details->benefits_image_3;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-benefits_image_3"  class="old_image_value"  value="<?=$details->benefits_image_3;?>" />
	<?php endif;?>
	
	<?php if(!empty($details->benefits_image_3)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages delete_image_btn_new' field_name='benefits_image_3'  number='".$details->id."'>Delete image</a>";
			}
	?>	
	</div>
	
	<div class="linkTarget  form-group">
		<h1 >Image alt text</h1>
		<input value="<?php echo $this->query_model->getStrReplaceAdmin($details->benefits_image_3_alt_text); ?>" name="benefits_image_3_alt_text" id="" class="field"  type="text">
		</div>
</div>

</div>

<div class="page-section" id="videorowsection">
	<div class="mb-3 main-content-label">Video Row</div>
	<div class="form-light-holder">
		<h1>Video Title</h1>
		<input type="text" name="video_title" value="<?php echo $this->query_model->getStrReplaceAdmin($details->video_title);?>" class="field full_width_input" style="">
	</div>
	<div class="form-light-holder">
		<h1>Video Description</h1>
		<div class="shorterCkeditor"><textarea name="video_desc" id="ckeditor_mini_video_desc" class="text ckeditor"><?=$details->video_desc;?></textarea></div>
	</div>

	<div class="form-light-holder  d-md-flex  dual_input">
	<div class="adsUrl  form-group">
		<h1>Video Type</h1>
		<select name="video_type" id="" class="field videoType" >
		<option value="youtube_video" <?php if($details->video_type == 'youtube_video'){ echo 'selected=selected'; } ?>>Youtube Video</option>
		<option value="vimeo_video" <?php if($details->video_type == 'vimeo_video'){ echo 'selected=selected'; } ?>  >Vimeo Video</option>
	</select>
	
	</div>
	<div class="linkTarget  form-group">
	<div class="youtube_video">
	<h1>Youtube Video</h1>
	<input type="text" name="youtube_video" value="<?=$details->youtube_video;?>" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://www.youtube.com/embed/UWCbfxwwC-I
	</div>
	</div>
	<span class="orButton">OR</span>
	<div class="vimeo_video">
	<h1>Vimeo Video</h1>
	<input type="text" name="vimeo_video" value="<?=$details->vimeo_video;?>" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://player.vimeo.com/video/17054419
	</div>
	</div>
	</div>
	
</div>




<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl  form-group">
	<h1 >Background Image</h1>
	<div class="custom-file half_width_custom_file">
			<input type="file" name="video_background_image" class="custom-file-input" id="customFile10" accept="image/*" />
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
	<?php if(!empty($details->video_background_image)): ?>
	<div><img id='img_bg_action' src="<?=base_url().'upload/programs/'.$details->video_background_image;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-video_background_image"  class="old_image_value"  value="<?=$details->video_background_image;?>" />
	<?php endif;?>
	
	<?php if(!empty($details->video_background_image)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages delete_image_btn_new' field_name='video_background_image'  number='".$details->id."'>Delete image</a>";
			}
	?>	
	</div>
	
	<div class="linkTarget  form-group">
		<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs-video'>
    <div id='docs-content-video'>
		<input id="video_colorpicker_opacity" name="video_background_color" class="colourTextValueVideo" value="<?php if(!empty($details)){ echo $details->video_background_color; }?>" />
    </div>
	
 </div>
	</div>
</div>


</div>


<div class="page-section" id="Calltoaction3ImagesSection">
<div class="mb-3 main-content-label">Call to Action with 3 Images</div>
<div class="form-light-holder">
	<h1>Call to Action Title</h1>
	<input type="text" name="action_title" value="<?php echo $this->query_model->getStrReplaceAdmin($details->action_title);?>" class="field full_width_input" style="">
</div>

<div class="form-light-holder">
	<h1>Call to Action description</h1>
	<div class="shorterCkeditor"><textarea name="action_desc" id="ckeditor_mini_action_desc" class="text ckeditor"><?=$details->action_desc;?></textarea></div>
</div>

	
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
		<div class="adsUrl  form-group">
	<h1>Background Image</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="action_background_image"  class="custom-file-input" id="customFile11" accept="image/*" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
	<?php if(!empty($details->action_background_image)): ?>
	<div><img id='img_bg_action' src="<?=base_url().'upload/programs/'.$details->action_background_image;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-action_background_image"  class="old_image_value"  value="<?=$details->action_background_image;?>" />
	<?php endif;?>
	
	<?php if(!empty($details->action_background_image)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages delete_image_btn_new' field_name='action_background_image'  number='".$details->id."'>Delete image</a>";
			}
	?>	
	</div>
	
	<div class="linkTarget  form-group">
		<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs-action'>
    <div id='docs-content-action'>
		<input id="action_colorpicker_opacity" name="action_background_color" class="colourTextValueAction" value="<?php if(!empty($details)){ echo $details->action_background_color; }?>" />
    </div>
	
 </div>
		</div>
</div>



<div class="form-light-holder">
	<h1>Title #1</h1>
	<input type="text" name="action_headline_1" value="<?php echo $this->query_model->getStrReplaceAdmin($details->action_headline_1);?>" class="field full_width_input" style="">
</div>
<div class="form-light-holder">
	<h1>Description #1</h1>
	<input type="text" name="action_desc_1" value="<?php echo $this->query_model->getStrReplaceAdmin($details->action_desc_1);?>" class="field full_width_input" style="">
</div>
<div class="form-light-holder">
	<h1>Image Link Url #1</h1>
	<input type="text" name="action_link_url_1" value="<?php echo $this->query_model->getStrReplaceAdmin($details->action_link_url_1);?>" class="field full_width_input" style="">
</div>
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl  form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #1</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="action_image_1"  class="custom-file-input" id="customFile12" accept="image/*" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
	<?php if(!empty($details->action_image_1)): ?>
	<div><img id='img_bg_action_image_1' src="<?=base_url().'upload/programs/'.$details->action_image_1;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-action_image_1"   class="old_image_value"  value="<?=$details->action_image_1;?>" />
	<?php endif;?>
	
	<?php if(!empty($details->action_image_1)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages delete_image_btn_new' field_name='action_image_1'  number='".$details->id."'>Delete image</a>";
			}
	?>	
	</div>
	
	<div class="linkTarget  form-group">
		<h1>Image alt text</h1>
		<input value="<?php echo $this->query_model->getStrReplaceAdmin($details->action_image_1_alt_text); ?>" name="action_image_1_alt_text" id="" class="field "  type="text">
		</div>
</div>


<div class="form-light-holder">
	<h1>Title #2</h1>
	<input type="text" name="action_headline_2" value="<?php echo $this->query_model->getStrReplaceAdmin($details->action_headline_2);?>" class="field full_width_input" style="">
</div>
<div class="form-light-holder">
	<h1>Description #2</h1>
	<input type="text" name="action_desc_2" value="<?php echo $this->query_model->getStrReplaceAdmin($details->action_desc_2);?>" class="field full_width_input" style="">
</div>
<div class="form-light-holder">
	<h1>Image Link Url #2</h1>
	<input type="text" name="action_link_url_2" value="<?php echo $this->query_model->getStrReplaceAdmin($details->action_link_url_2);?>" class="field full_width_input" style="">
</div>
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
		<div class="adsUrl  form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #2</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="action_image_2" class="custom-file-input" id="customFile13" accept="image/*" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
	<?php if(!empty($details->action_image_2)): ?>
	<div><img id='img_bg_action_image_2' src="<?=base_url().'upload/programs/'.$details->action_image_2;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-action_image_2"   class="old_image_value" value="<?=$details->action_image_2;?>" />
	<?php endif;?>
	
	<?php if(!empty($details->action_image_2)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages delete_image_btn_new' field_name='action_image_2'  number='".$details->id."'>Delete image</a>";
			}
	?>	
	</div>
	
	<div class="linkTarget  form-group">
		<h1>Image alt text</h1>
		<input value="<?php echo $this->query_model->getStrReplaceAdmin($details->action_image_2_alt_text); ?>" name="action_image_2_alt_text" id="" class="field "  type="text">
		</div>
</div>

<div class="form-light-holder">
	<h1>Title #3</h1>
	<input type="text" name="action_headline_3" value="<?php echo $this->query_model->getStrReplaceAdmin($details->action_headline_3);?>" class="field full_width_input" style="">
</div>
<div class="form-light-holder">
	<h1>Description #3</h1>
	<input type="text" name="action_desc_3" value="<?php echo $this->query_model->getStrReplaceAdmin($details->action_desc_3);?>" class="field full_width_input" style="">
</div>
<div class="form-light-holder">
	<h1>Image Link Url #3</h1>
	<input type="text" name="action_link_url_3" value="<?php echo $this->query_model->getStrReplaceAdmin($details->action_link_url_3);?>" class="field full_width_input">
</div>
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
		<div class="adsUrl  form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #3</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="action_image_3"  class="custom-file-input" id="customFile14" accept="image/*" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
	<?php if(!empty($details->action_image_3)): ?>
	<div><img id='img_bg_action_image_3' src="<?=base_url().'upload/programs/'.$details->action_image_3;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-action_image_3"  class="old_image_value"  value="<?=$details->action_image_3;?>" />
	<?php endif;?>
	
	<?php if(!empty($details->action_image_3)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages delete_image_btn_new' field_name='action_image_3'  number='".$details->id."'>Delete image</a>";
			}
	?>	
	</div>
	
	<div class="linkTarget  form-group">
		<h1 >Image alt text</h1>
		<input value="<?php echo $this->query_model->getStrReplaceAdmin($details->action_image_3_alt_text); ?>" name="action_image_3_alt_text" id="" class="field "  type="text">
		</div>
</div>

</div>

<div class="page-section" id="HeadingboxesSection">
<div class="mb-3 main-content-label">Heading with 3 boxes</div>
<div class="form-light-holder">
	<h1>Heading  Title</h1>
	<input type="text" name="headling_title" value="<?php echo $this->query_model->getStrReplaceAdmin($details->headling_title);?>" class="field full_width_input">
</div>

<div class="form-light-holder">
	<h1>Heading description</h1>
	<div class="shorterCkeditor"><textarea name="headling_desc" id="ckeditor_mini_headling_desc" class="text ckeditor"><?=$details->headling_desc;?></textarea></div>
</div>

	
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl  form-group">
	<h1>Background Image</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="headling_background_image"  class="custom-file-input" id="customFile15" accept="image/*" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>

	<?php if(!empty($details->headling_background_image)): ?>
	<div><img id='img_bg_action' src="<?=base_url().'upload/programs/'.$details->headling_background_image;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-headling_background_image"   class="old_image_value"  value="<?=$details->headling_background_image;?>" />
	<?php endif;?>
	
	<?php if(!empty($details->headling_background_image)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages delete_image_btn_new' field_name='headling_background_image'  number='".$details->id."'>Delete image</a>";
			}
	?>	
	</div>
	
	<div class="linkTarget  form-group">
	<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs-headling'>
    <div id='docs-content-headling'>
		<input id="headling_colorpicker_opacity" name="headling_background_color" class="colourTextValueHeadling" value="<?php if(!empty($details)){ echo $details->headling_background_color; }?>" />
    </div>
	
 </div>
		</div>
</div>



<div class="form-light-holder">
	<h1>Headline #1</h1>
	<textarea type="text" id="ckeditor_mini_headline1" name="headling_headline_1" class="field ckeditor full_width_input"><?=$details->headling_headline_1;?></textarea>
</div>



<div class="form-light-holder">
	<h1>Headline #2</h1>
	<textarea type="text" id="ckeditor_mini_headline2" name="headling_headline_2" class="field ckeditor full_width_input"><?=$details->headling_headline_2;?></textarea>
</div>


<div class="form-light-holder">
	<h1>Headline #3</h1>
	<textarea type="text" id="ckeditor_mini_headline3" name="headling_headline_3" class="field ckeditor full_width_input"><?=$details->headling_headline_3;?></textarea>
</div>

</div>

<div class="page-section" id="StatisticsimagesSection">
<div class="mb-3 main-content-label">Statistics with 3 images</div>
<div class="form-light-holder">
	<h1>Statistics Title</h1>
	<input type="text" name="statistics_title" value="<?php echo $this->query_model->getStrReplaceAdmin($details->statistics_title);?>" class="field full_width_input">
</div>

<div class="form-light-holder">
	<h1>Statistics description</h1>
	<div class="shorterCkeditor"><textarea name="statistics_desc" id="ckeditor_mini_statistics_desc" class="text ckeditor"><?=$details->statistics_desc;?></textarea></div>
</div>

	
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl  form-group">
	<h1>Background Image</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="statistics_background_image"  class="custom-file-input" id="customFile16" accept="image/*" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
	<?php if(!empty($details->statistics_background_image)): ?>
	<div><img id='img_bg_action' src="<?=base_url().'upload/programs/'.$details->statistics_background_image;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-statistics_background_image"   class="old_image_value"  value="<?=$details->statistics_background_image;?>" />
	<?php endif;?>
	
	<?php if(!empty($details->statistics_background_image)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages delete_image_btn_new' field_name='statistics_background_image'  number='".$details->id."'>Delete image</a>";
			}
	?>	
	</div>
	
	<div class="linkTarget  form-group">
		<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs-statistics'>
    <div id='docs-content-statistics'>
		<input id="statistics_colorpicker_opacity" name="statistics_background_color" class="colourTextValueStatistics" value="<?php if(!empty($details)){ echo $details->statistics_background_color; }?>" />
    </div>
	
 </div>
	
		</div>
</div>



<div class="form-light-holder">
	<h1>Title #1</h1>
	<input type="text" name="statistics_headline_1" value="<?php echo $this->query_model->getStrReplaceAdmin($details->statistics_headline_1);?>" class="field full_width_input">
</div>
<div class="form-light-holder">
	<h1>Description #1</h1>
	<input type="text" name="statistics_desc_1" value="<?php echo $this->query_model->getStrReplaceAdmin($details->statistics_desc_1);?>" class="field full_width_input">
</div>
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
		<div class="adsUrl  form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #1</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="statistics_image_1"  class="custom-file-input" id="customFile17" accept="image/*" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
	<?php if(!empty($details->statistics_image_1)): ?>
	<div><img id='img_bg_statistics_image_1' src="<?=base_url().'upload/programs/'.$details->statistics_image_1;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-statistics_image_1"  class="old_image_value"  value="<?=$details->statistics_image_1;?>" />
	<?php endif;?>
	
	<?php if(!empty($details->statistics_image_1)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages delete_image_btn_new' field_name='statistics_image_1'  number='".$details->id."'>Delete image</a>";
			}
	?>	
	</div>
	
	<div class="linkTarget  form-group">
		<h1>Image alt text</h1>
		<input value="<?php echo $this->query_model->getStrReplaceAdmin($details->statistics_image_1_alt_text); ?>" name="statistics_image_1_alt_text" id="" class="field "  type="text">
		</div>
</div>


<div class="form-light-holder">
	<h1>Title #2</h1>
	<input type="text" name="statistics_headline_2" value="<?php echo $this->query_model->getStrReplaceAdmin($details->statistics_headline_2);?>" class="field full_width_input">
</div>
<div class="form-light-holder">
	<h1>Description #2</h1>
	<input type="text" name="statistics_desc_2" value="<?php echo $this->query_model->getStrReplaceAdmin($details->statistics_desc_2);?>" class="field full_width_input">
</div>
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
		<div class="adsUrl  form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #2</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="statistics_image_2"  class="custom-file-input" id="customFile18" accept="image/*" />	
	<label class="custom-file-label" for="customFile">Choose file</label>
	</div>
	
	<?php if(!empty($details->statistics_image_2)): ?>
	<div><img id='img_bg_statistics_image_2' src="<?=base_url().'upload/programs/'.$details->statistics_image_2;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-statistics_image_2"  class="old_image_value"  value="<?=$details->statistics_image_2;?>" />
	<?php endif;?>
	
	<?php if(!empty($details->statistics_image_2)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages delete_image_btn_new' field_name='statistics_image_2'  number='".$details->id."'>Delete image</a>";
			}
	?>	
	</div>
	
	<div class="linkTarget  form-group">
		<h1 >Image alt text</h1>
		<input value="<?php echo $this->query_model->getStrReplaceAdmin($details->statistics_image_2_alt_text); ?>" name="statistics_image_2_alt_text" id="" class="field"  type="text">
		</div>
</div>

<div class="form-light-holder">
	<h1>Title #3</h1>
	<input type="text" name="statistics_headline_3" value="<?php echo $this->query_model->getStrReplaceAdmin($details->statistics_headline_3);?>" class="field full_width_input">
</div>
<div class="form-light-holder">
	<h1>Description #3</h1>
	<input type="text" name="statistics_desc_3" value="<?php echo $this->query_model->getStrReplaceAdmin($details->statistics_desc_3);?>" class="field full_width_input">
</div>
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
		<div class="adsUrl  form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #3</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="statistics_image_3"  class="custom-file-input" id="customFile19" accept="image/*" />
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
	<?php if(!empty($details->statistics_image_3)): ?>
	<div><img id='img_bg_action_image_3' src="<?=base_url().'upload/programs/'.$details->statistics_image_3;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-statistics_image_3" class="old_image_value"  value="<?=$details->statistics_image_3;?>" />
	<?php endif;?>
	
	<?php if(!empty($details->statistics_image_3)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages delete_image_btn_new' field_name='statistics_image_3'  number='".$details->id."'>Delete image</a>";
			}
	?>	
		</div>
	
	<div class="linkTarget  form-group">
		<h1 >Image alt text</h1>
		<input value="<?php echo $this->query_model->getStrReplaceAdmin($details->statistics_image_3_alt_text); ?>" name="statistics_image_3_alt_text" id="" class="field"  type="text">
		</div>
</div>

</div>


<div class="page-section" id="BenefitsRowImagesSecondSection">
<div class="mb-3 main-content-label">Benefits Row 2 with 3 Images</div>
<div class="form-light-holder">
	<h1>Benefits Row 2 Title</h1>
	<input type="text" name="benefits_2_title" value="<?php echo $this->query_model->getStrReplaceAdmin($details->benefits_2_title);?>" class="field full_width_input">
</div>

<div class="form-light-holder">
	<h1>Benefits Row 2 description</h1>
	<div class="shorterCkeditor"><textarea name="benefits_2_desc" id="ckeditor_mini_benefits_2_desc" class="text ckeditor"><?=$details->benefits_2_desc;?></textarea></div>
</div>

	
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl  form-group">
	<h1 >Background Image</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="benefits_2_background_image"  class="custom-file-input" id="customFile20" accept="image/*" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
	<?php if(!empty($details->benefits_2_background_image)): ?>
	<div><img id='img_bg_action' src="<?=base_url().'upload/programs/'.$details->benefits_2_background_image;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-benefits_2_background_image" class="old_image_value"  value="<?=$details->benefits_2_background_image;?>" />
	<?php endif;?>
	
	<?php if(!empty($details->benefits_2_background_image)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages delete_image_btn_new' field_name='benefits_2_background_image'  number='".$details->id."'>Delete image</a>";
			}
	?>	
	</div>
	
	<div class="linkTarget  form-group">
		<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs-benefits_2'>
    <div id='docs-content-benefits_2'>
		<input id="benefits_2_colorpicker_opacity" name="benefits_2_background_color" class="colourTextValueBenefits_2" value="<?php if(!empty($details)){ echo $details->benefits_2_background_color; }?>" />
    </div>
	
 </div>
		</div>
</div>



<div class="form-light-holder">
	<h1>Title #1</h1>
	<input type="text" name="benefits_2_headline_1" value="<?php echo $this->query_model->getStrReplaceAdmin($details->benefits_2_headline_1);?>" class="field full_width_input">
</div>
<div class="form-light-holder">
	<h1>Description #1</h1>
	<input type="text" name="benefits_2_desc_1" value="<?php echo $this->query_model->getStrReplaceAdmin($details->benefits_2_desc_1);?>" class="field full_width_input">
</div>
<div class="form-light-holder d-md-flex  dual_input" style="overflow:auto;">
		<div class="adsUrl  form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #1</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="benefits_2_image_1"  class="custom-file-input" id="customFile21" accept="image/*" />
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
	<?php if(!empty($details->benefits_2_image_1)): ?>
	<div><img id='img_bg_benefits_2_image_1' src="<?=base_url().'upload/programs/'.$details->benefits_2_image_1;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-benefits_2_image_1" class="old_image_value"  value="<?=$details->benefits_2_image_1;?>" />
	<?php endif;?>
	
	<?php if(!empty($details->benefits_2_image_1)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages delete_image_btn_new' field_name='benefits_2_image_1'  number='".$details->id."'>Delete image</a>";
			}
	?>	
	</div>
	
	<div class="linkTarget  form-group">
		<h1 >Image alt text</h1>
		<input value="<?php echo $this->query_model->getStrReplaceAdmin($details->benefits_2_image_1_alt_text); ?>" name="benefits_2_image_1_alt_text" id="" class="field"  type="text">
		</div>
</div>


<div class="form-light-holder">
	<h1>Title #2</h1>
	<input type="text" name="benefits_2_headline_2" value="<?php echo $this->query_model->getStrReplaceAdmin($details->benefits_2_headline_2);?>" class="field full_width_input">
</div>
<div class="form-light-holder">
	<h1>Description #2</h1>
	<input type="text" name="benefits_2_desc_2" value="<?php echo $this->query_model->getStrReplaceAdmin($details->benefits_2_desc_2);?>" class="field full_width_input">
</div>
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
		<div class="adsUrl  form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #2</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="benefits_2_image_2" class="custom-file-input" id="customFile22" accept="image/*" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
	<?php if(!empty($details->benefits_2_image_2)): ?>
	<div><img id='img_bg_statistics_image_2' src="<?=base_url().'upload/programs/'.$details->benefits_2_image_2;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-benefits_2_image_2"  class="old_image_value" value="<?=$details->benefits_2_image_2;?>" />
	<?php endif;?>
	
	<?php if(!empty($details->benefits_2_image_2)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages delete_image_btn_new' field_name='benefits_2_image_2'  number='".$details->id."'>Delete image</a>";
			}
	?>	
		</div>
	
	<div class="linkTarget  form-group">
		<h1>Image alt text</h1>
		<input value="<?php echo $this->query_model->getStrReplaceAdmin($details->benefits_2_image_2_alt_text); ?>" name="benefits_2_image_2_alt_text" id="" class="field"  type="text">
		</div>
</div>

<div class="form-light-holder">
	<h1>Title #3</h1>
	<input type="text" name="benefits_2_headline_3" value="<?php echo $this->query_model->getStrReplaceAdmin($details->benefits_2_headline_3);?>" class="field full_width_input">
</div>
<div class="form-light-holder">
	<h1>Description #3</h1>
	<input type="text" name="benefits_2_desc_3" value="<?=$details->benefits_2_desc_3;?>" class="field full_width_input">
</div>
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl  form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #3</h1>
	<div class="custom-file half_width_custom_file">
			<input type="file" name="benefits_2_image_3"  class="custom-file-input" id="customFile23" accept="image/*" />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
	<?php if(!empty($details->benefits_2_image_3)): ?>
	<div><img id='img_bg_action_image_3' src="<?=base_url().'upload/programs/'.$details->benefits_2_image_3;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-benefits_2_image_3" class="old_image_value"  value="<?=$details->benefits_2_image_3;?>" />
	<?php endif;?>

	<?php if(!empty($details->benefits_2_image_3)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages delete_image_btn_new' field_name='benefits_2_image_3'  number='".$details->id."'>Delete image</a>";
			}
	?>	
		</div>
	
	<div class="linkTarget  form-group">
		<h1 >Image alt text</h1>
		<input value="<?php echo $this->query_model->getStrReplaceAdmin($details->benefits_2_image_3_alt_text); ?>" name="benefits_2_image_3_alt_text" id="" class="field"  type="text">
		</div>
</div>
</div>


<div class="page-section" id="WhiteStripeSecondSection">
<div class="mb-3 main-content-label">White Stripe Row 2</div>
<!-- <div class="form-light-holder">
	<h1>Title</h1>
	<input type="text" name="white_stripe2_title" value="<?=$details->white_stripe2_title;?>" class="field" style="width:98%">
</div> -->
<div class="form-light-holder">
	<h1>Content</h1>
	<div class="shorterCkeditor"><textarea name="white_stripe2_desc" id="ckeditor_mini_white_stripe2_desc" class="text ckeditor"><?=$details->white_stripe2_desc;?></textarea></div>
</div>


<!-- <div class="form-light-holder">
<h1>Override Logo</h1>
	<select name="white_stripe2_override_logo" id="window" class="field">
	<?php foreach($override_logos as  $override_logo):?>
	<option value="<?=$override_logo->s_no?>" <?php if($details->white_stripe2_override_logo == $override_logo->s_no){ echo 'selected=selected';} ?>><?=$override_logo->logo_name?></option>
	<?php endforeach;?>
	</select>
</div> -->

<div class="form-light-holder d-md-flex  dual_input" style="overflow:auto;">
		<div class="adsUrl  form-group">
	<h1 style="padding-bottom: 5px;">Image</h1>
	<div class="custom-file half_width_custom_file">
			<input type="file" name="white_stripe2_image"  class="custom-file-input" id="customFile24" accept="image/*" />	
	<label class="custom-file-label" for="customFile">Choose file</label>
	</div>

	<?php if(!empty($details->white_stripe2_image)): ?>
	<div><img id='img_white_stripe2_image' src="<?=base_url().'upload/programs/'.$details->white_stripe2_image;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-white_stripe2_image" class="old_image_value" value="<?=$details->white_stripe2_image;?>" />
	<?php endif;?>

	<?php if(!empty($details->white_stripe2_image)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages delete_image_btn_new' field_name='white_stripe2_image'  number='".$details->id."'>Delete image</a>";
			}
	?>	
	</div>
	
	<div class="linkTarget  form-group">
		<h1 >Image alt text</h1>
		<input value="<?php echo $this->query_model->getStrReplaceAdmin($details->white_stripe2_image_alt_text); ?>" name="white_stripe2_image_alt_text" id="" class="field"  type="text">
		</div>
</div>
</div>

<div class="page-section" id="BenefitsRowImagesThirdSection">
<div class="mb-3 main-content-label">Benefits Row 3 with 3 Images</div>
<div class="form-light-holder">
	<h1>Benefits Row 3 Title</h1>
	<input type="text" name="benefits_3_title" value="<?php echo $this->query_model->getStrReplaceAdmin($details->benefits_3_title);?>" class="field full_width_input">
</div>

<div class="form-light-holder">
	<h1>Benefits Row 3 description</h1>
	<div class="shorterCkeditor"><textarea name="benefits_3_desc" id="ckeditor_mini_benefits_3_desc" class="text ckeditor"><?=$details->benefits_3_desc;?></textarea></div>
</div>

	
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
		<div class="adsUrl  form-group">
	<h1 >Background Image</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" field_name="benefits_3_background_image"  class="programImage custom-file-input"  id="customFile25" accept="image/*" />
	<input type="hidden" name="benefits_3_background_image" id="benefits_3_background_image"  value="<?=$details->benefits_3_background_image;?>"  />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>

	<?php if(!empty($details->benefits_3_background_image)): ?>
	<div><img id='img_bg_action' src="<?=base_url().'upload/programs/'.$details->benefits_3_background_image;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-benefits_3_background_image" class="old_image_value"  value="<?=$details->benefits_3_background_image;?>" />
	<?php endif;?>
	<!--<input type="file" name="benefits_3_background_image" id="photo_left" accept="image/*" /> -->
	
	<?php if(!empty($details->benefits_3_background_image)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages delete_image_btn_new' field_name='benefits_3_background_image'  number='".$details->id."'>Delete image</a>";
			}
	?>	
		</div>
	
	<div class="linkTarget  form-group">
		<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs-benefits_3'>
    <div id='docs-content-benefits_3'>
		<input id="benefits_3_colorpicker_opacity" name="benefits_3_background_color" class="colourTextValuebenefits_3" value="<?php if(!empty($details)){ echo $details->benefits_3_background_color; }?>" />
    </div>
	
 </div>
		</div>
</div>



<div class="form-light-holder">
	<h1>Title #1</h1>
	<input type="text" name="benefits_3_headline_1" value="<?php echo $this->query_model->getStrReplaceAdmin($details->benefits_3_headline_1);?>" class="field full_width_input">
</div>

<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl  form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #1</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" field_name="benefits_3_image_1" class="programImage custom-file-input" id="customFile26" accept="image/*" />
	<input type="hidden" name="benefits_3_image_1" id="benefits_3_image_1"  value="<?=$details->benefits_3_image_1;?>"  />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>

	<?php if(!empty($details->benefits_3_image_1)): ?>
	<div><img id='img_bg_benefits_3_image_1' src="<?=base_url().'upload/programs/'.$details->benefits_3_image_1;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-benefits_3_image_1" class="old_image_value"  value="<?=$details->benefits_3_image_1;?>" />
	<?php endif;?>
	
	<?php if(!empty($details->benefits_3_image_1)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages delete_image_btn_new' field_name='benefits_3_image_1'  number='".$details->id."'>Delete image</a>";
			}
	?>	
	</div>
	
	<div class="linkTarget  form-group">
		<h1>Image alt text</h1>
		<input value="<?php echo $this->query_model->getStrReplaceAdmin($details->benefits_3_image_1_alt_text); ?>" name="benefits_3_image_1_alt_text" id="" class="field "  type="text">
		</div>
</div>


<div class="form-light-holder">
	<h1>Title #2</h1>
	<input type="text" name="benefits_3_headline_2" value="<?php echo $this->query_model->getStrReplaceAdmin($details->benefits_3_headline_2);?>" class="field full_width_input">
</div>

<div class="form-light-holder d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl  form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #2</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" field_name="benefits_3_image_2" class="programImage custom-file-input" id="customFile27" accept="image/*" />
		<input type="hidden" name="benefits_3_image_2" id="benefits_3_image_2"  value="<?=$details->benefits_3_image_2;?>"   />	
	<label class="custom-file-label" for="customFile">Choose file</label>
	</div>

	<?php if(!empty($details->benefits_3_image_2)): ?>
	<div><img id='img_bg_statistics_image_2' src="<?=base_url().'upload/programs/'.$details->benefits_3_image_2;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-benefits_3_image_2"  class="old_image_value" value="<?=$details->benefits_3_image_2;?>" />
	<?php endif;?>
	
	<?php if(!empty($details->benefits_3_image_2)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages delete_image_btn_new' field_name='benefits_3_image_2'  number='".$details->id."'>Delete image</a>";
			}
	?>	
	</div>
	
	<div class="linkTarget  form-group">
		<h1 >Image alt text</h1>
		<input value="<?php echo $this->query_model->getStrReplaceAdmin($details->benefits_3_image_2_alt_text); ?>" name="benefits_3_image_2_alt_text" id="" class="field "  type="text">
		</div>
</div>

<div class="form-light-holder">
	<h1>Title #3</h1>
	<input type="text" name="benefits_3_headline_3" value="<?php echo $this->query_model->getStrReplaceAdmin($details->benefits_3_headline_3);?>" class="field full_width_input">
</div>
<div class="form-light-holder d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl  form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #3</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" field_name="benefits_3_image_3" class="programImage custom-file-input" id="customFile28" accept="image/*" />
	<input type="hidden" name="benefits_3_image_3" id="benefits_3_image_3" value="<?=$details->benefits_3_image_3;?>"  />	
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
	<?php if(!empty($details->benefits_3_image_3)): ?>
	<div><img id='img_bg_action_image_3' src="<?=base_url().'upload/programs/'.$details->benefits_3_image_3;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-benefits_3_image_3" class="old_image_value"  value="<?=$details->benefits_3_image_3;?>" />
	<?php endif;?>
	
	<?php if(!empty($details->benefits_3_image_3)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages delete_image_btn_new' field_name='benefits_3_image_3'  number='".$details->id."'>Delete image</a>";
			}
	?>	
	</div>
	
	<div class="linkTarget  form-group">
		<h1 >Image alt text</h1>
		<input value="<?php echo $this->query_model->getStrReplaceAdmin($details->benefits_3_image_3_alt_text); ?>" name="benefits_3_image_3_alt_text" id="" class="field "  type="text">
		</div>
</div>
</div>




<div class="page-section" id="EmailOptin">
<div class="mb-3 main-content-label">Email Opt-in #1</div>
<div class="form-light-holder">

	<h1>Opt-In Title</h1>
	
	
	<textarea type="text" id="ckeditor_mini_opt1_title" name="opt1_title" class="field ckeditor full_width_input"><?php echo (!empty($details) && !empty($details->opt1_title)) ? $details->opt1_title : ''; ?></textarea>
</div>
<div class="form-light-holder">

	<h1>Opt-In Text</h1>
	<input type="text" value="<?php echo (!empty($details) && !empty($details->opt1_text)) ? $details->opt1_text : ''; ?>" name="opt1_text" id="" class="field full_width_input" placeholder=""  style=""/>
</div>

<div class="form-light-holder">

	<h1>Submit Button Text</h1>
	<input type="text" value="<?php echo (!empty($details) && !empty($details->opt1_submit_btn_text)) ? $details->opt1_submit_btn_text : ''; ?>" name="opt1_submit_btn_text" id="" class="field full_width_input" placeholder=""  style=""/>
</div>

<div class="form-light-holder form1checkbox">
	<a id="published" class="checkbox1 <?php echo (!empty($details) && $details->show_full_form_1 == 1) ? 'check-on' : 'check-off'; ?>"></a>

	<h1 class="inline">Show Full Form </h1>

	<input type="hidden" value="<?php echo (!empty($details) && $details->show_full_form_1 == 1) ? 1 : 0; ?>" name="show_full_form_1" class="hidden_cb1" />

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
	<input type="text" value="<?php echo (!empty($details) && !empty($details->opt_2_title)) ? $this->query_model->getStrReplaceAdmin($details->opt_2_title) : ''; ?>" name="opt_2_title" id="" class="field full_width_input" placeholder=""  style=""/>
</div>

<div class="form-light-holder">

	<h1>Opt-In Text</h1>
	<input type="text" value="<?php echo (!empty($details) && !empty($details->opt_2_text)) ? $this->query_model->getStrReplaceAdmin($details->opt_2_text) : ''; ?>" name="opt_2_text" id="" class="field full_width_input" placeholder=""  style=""/>
</div>

<div class="form-light-holder form2checkbox">

	<a id="published" class="checkbox2 <?php echo (!empty($details) && $details->show_full_form_2 == 1) ? 'check-on' : 'check-off'; ?>"></a>

	<h1 class="inline">Show Full Form </h1>

	<input type="hidden" value="<?php echo (!empty($details) && $details->show_full_form_2 == 1) ? 1 : 0; ?>" name="show_full_form_2" class="hidden_cb2" />

</div>

</div>
<div class="page-section" id="testimonials_faqs">
<div class="mb-3 main-content-label">Testimonials</div>

<div class="form-light-holder">
	<h1>h2 above the testimonials</h1>
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($details->testimonials_h2_text); ?>" name="testimonials_h2_text" id="" class="field" placeholder="h2 above the testimonials" />
</div>

<?php if(!empty($testimonials)){ ?>
<div class="form-light-holder">
	<h1>Testimonials</h1>
	<?php foreach($testimonials as $testimonial){ 
			$selectedTesti = !empty($details->testimonial_ids) ? unserialize($details->testimonial_ids) : '';
			
			
	?>
	<label class="ckbox mg-b-10">
		<input type="checkbox" name="testimonial_ids[]" value="<?php echo $testimonial->id; ?>" <?php echo (!empty($selectedTesti) && (in_array($testimonial->id , $selectedTesti))) ? 'checked=checked' : ''; ?>> <span><?php echo $testimonial->title.' ('.$testimonial->name.')'; ?>  </span></label>
	<?php } ?>
</div>
<?php } ?>



<div class="mb-3 main-content-label">FAQs</div>

<div class="form-light-holder">
	<h1>h2 above the faqs</h1>
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($details->faqs_h2_text); ?>" name="faqs_h2_text" id="" class="field" placeholder="h2 above the faqs" />
</div>

<?php if(!empty($programFaqs)){ ?>
<div class="form-light-holder">
	<h1>FAQs</h1>
	<?php foreach($programFaqs as $program_faq){ 
			$selectedTesti = !empty($details->faq_ids) ? unserialize($details->faq_ids) : '';
			
			
	?>
	<label class="ckbox mg-b-10">
		<input type="checkbox" name="faq_ids[]" value="<?php echo $program_faq->id; ?>" <?php echo (!empty($selectedTesti) && (in_array($program_faq->id , $selectedTesti))) ? 'checked=checked' : ''; ?>><span> <?php echo $program_faq->title.' / '.$program_faq->title_2; ?> </span></label>
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

$("#delete_img").click(function(){

	
		var program_id=$('#program_id').val();
		var image_path=$('#img').attr('src');
					
		//var mod_type = $("#contact_mod").val().toLowerCase();
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/programs/delete',						
		data: { program_id : program_id,image_path:image_path }					
		}).done(function(msg){ 
		if(eval(msg) == 1){		
			$('#img').hide();
			$('#last-photo').val('');
			//setTimeout("window.location.href='admin/programs/edit/"+program_id+"'",1000);			
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});
	

 });
 
 
 $("#delete_header_img").click(function(){

	
		var program_id=$('#program_id').val();
		var image_path=$('#header_img').attr('src');
					
		//var mod_type = $("#contact_mod").val().toLowerCase();
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/programs/delete_header_image',						
		data: { program_id : program_id,image_path:image_path }					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			$('#header_img').hide();
			$("#last_header_image").val('');
			//setTimeout("window.location.href='admin/programs/edit/"+program_id+"'",1000);			
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});
	

 });
 
 
  
 $("#delete_userfile_2").click(function(){
		
		var program_id=$('#program_id').val();
		var image_path=$('#userf_img').attr('src');
		//alert(image_path+program_id); return false;
		
		//var category_id = $('#category_id').val();
		
		//alert("window.location.href="+path+"")	; return false;	
		//var mod_type = $("#contact_mod").val().toLowerCase();
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/programs/delete_userfile_2',						
		data: { program_id : program_id,image_path:image_path }					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			$('#userf_img').hide();
			$('.last-photo-2').val('');
			$('#delete_userfile_2').hide();
			//alert('pass');
			//setTimeout("window.location.href='admin/programs/edit/"+program_id+"'",1000);	
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});
	

 });
 
 
 $(".stand_page_delete_img").click(function(){

	
		var stand_page_id=$(this).attr('number');
		var image_path=$('#img'+stand_page_id).attr('src');
		var program_id = $('#program_id').val();
		var category_id = $('#category_id').val();
		//alert("#standImg"+stand_page_id); return false;
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/programs/delete_stand_page_img',						
		data: { stand_page_id : stand_page_id,image_path:image_path }					
		}).done(function(msg){ 
		if(eval(msg) == 1){		
			$(".standImg"+stand_page_id).hide();
			$("#last_stand_photo"+stand_page_id).val('');
			//setTimeout("window.location.href='admin/programs/edit/"+program_id+"'",1000);			
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});

	});
	
	
	
	$(".delete_stand_page").click(function(){

		var stand_page_id=$(this).attr('number');
		var program_id = $('#program_id').val();
		var category_id = $('#category_id').val();
		
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/programs/delete_stand_page',						
		data: { stand_page_id : stand_page_id}					
		}).done(function(msg){ 
		if(eval(msg) == 1){		
			$('.stand_page_'+stand_page_id).hide();
			setTimeout("window.location.href='admin/programs/edit/"+program_id+"'",1000);			
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});

	});
	
 
})
</script>


<div class="form-light-holder <?php echo $display_class; ?> display-none">
	<a id="free_trials" class="checkbox <?php if($details->stand_alone_page == 1) echo "check-on"; else echo "check-off";?>"></a>
	<h1 class="inline">Show stand-alone page for this program?</h1>
	<input type="hidden" value="<?=$details->stand_alone_page?>" name="stand_alone_page" class="hidden_cb stand_alone_page_button checkbx2" />
</div>


<div class="stand_alone_page display-none"  style="display:<?php if($user_level != 1 && $details->stand_alone_page == 0){ echo 'none'; } else{ echo 'block'; }  ?>">
<div class="form-light-holder  d-md-flex  dual_input">
	<div class="adsUrl  form-group">
		<h1>Stand-Alone Program Name</h1>
		<input type="text" value="<?=$details->stand_program_name;?>" name="stand_program_name" class="field" placeholder="Enter Your Stand-Alone Program Name Here"/>
	</div>
	<div class="linkTarget  form-group">
		<h1>Stand-Alone Ages</h1>
		<input type="text" value="<?=$details->stand_program_ages;?>" name="stand_program_ages" class="field" placeholder="Enter Stand-Alone Ages Here"/>
	</div>
	
</div>
	

<!-------- - Image And Video - ------------>
<!--<div class="form-light-holder">

	<h1>Image Or Video</h1>

	<input type="radio" class="image_video" name="image_video" value="image" <?php if($details->image_video == 'image'){ echo 'checked=checked'; } ?>  /> Image <br />
	<input type="radio" class="image_video" name="image_video" value="video" <?php if($details->image_video == 'video'){ echo 'checked=checked'; } elseif(empty($details->image_video)){  echo 'checked=checked'; }?> /> Video

</div>
<div class="welcome_image">
<div class="form-light-holder" style="overflow:auto;">
	<div class="adsUrl  form-group">
	<h1 style="padding-bottom: 5px;">Choose a Photo</h1>
	<?php if(!empty($details->image)): ?>
	<div><img id='userf_img' src="<?=base_url().'upload/programs/'.$details->image;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" class="last-photo-2" name="last-photo-2" value="<?=$details->image;?>" />
	<?php endif;?>
		
		<input type="file" name="userfile_2" id="userfile_2" accept="image/*" />
		
		<?php if(!empty($details->image)){ 
				echo "<a href='javascript:void(0);' id='delete_userfile_2'>Delete image</a>";
				}
		?>	
		</div>
		<div class="linkTarget  form-group">
		<h1>Image alt text</h1>
	<input type="text" value="<?php echo $details->image_alt; ?>" name="image_alt" id="image_alt" class="field" />
		</div>
		<div>
		</div>
</div>

</div>
<div class="form-light-holder welcome_video">
	<div class="adsUrl  form-group">
		<h1>Video Type</h1>
		<select name="video_type" id="" class="field videoType" >
		<option value="youtube_video" <?php if($details->video_type == 'youtube_video'){ echo 'selected=selected'; } ?>>Youtube Video</option>
		<option value="vimeo_video" <?php if($details->video_type == 'vimeo_video'){ echo 'selected=selected'; } ?>  >Vimeo Video</option>
	</select>
	
	</div>
	<div class="linkTarget  form-group">
	<div class="youtube_video">
	<h1>Youtube Video</h1>
	<input type="text" name="youtube_video" value="<?=$details->youtube_video;?>" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://www.youtube.com/embed/UWCbfxwwC-I
	</div>
	</div>
	<span class="orButton">OR</span>
	<div class="vimeo_video">
	<h1>Vimeo Video</h1>
	<input type="text" name="vimeo_video" value="<?=$details->vimeo_video;?>" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://player.vimeo.com/video/17054419
	</div>
	</div>
	</div>
	
</div> -->





<h1 style="padding-bottom: 5px;"><b>Stand Alone Pages:-</b></h1>
<div class="form-light-holder">	
<div id="AddMoreStandAlonePage">
	<div class=""><h3><a href="javascript:void(0);" class="AddMoreStandAlonePageButton">Add More</a></h3></div>
	<?php if(!empty($stand_pages)){ 
				$a = 1;
				foreach($stand_pages as $stand_page){
	?>
		<div class="standPages  stand_page_<?=$stand_page->id?>">
			
			<div class="form-light-holder">
			<a href="javascript:void(0)" class="delete_stand_page" number="<?=$stand_page->id?>">Delete Row #<?= $a ?></a>
				<h1>#<?= $a ?> Title </h1>
				<textarea type="text" name="data[<?= $a ?>][title]" id="ckeditor_mini_stand_page_name<?= $a ?>" class="field" placeholder="Enter your name here" /><?=$stand_page->title?></textarea>
			</div>
				<div class="form-light-holder" style="">
					<h1>#<?= $a ?> Description </h1>
					 <textarea name="data[<?= $a ?>][desc]" class="ckeditor" id="ckeditor_mini_stand_page_desc<?= $a ?>"><?=$stand_page->desc?></textarea>
				</div>
				<div class="form-light-holder" style="overflow:auto;">
						<h1 style="padding-bottom: 5px;">#<?= $a ?> Image </h1>
						<?php if(!empty($stand_page->stand_page_photo)): ?>
						<div class="standImg<?=$stand_page->id;?>"><?php if($stand_page->stand_page_photo != 'Null'){ ?>
							<img id="img_<?=$stand_page->id;?>" src="upload/programs/<?=$stand_page->stand_page_photo;?>" style="width: 100px; clear:both;" />
							<?php } ?>	</div>
						<input type="hidden" name="data[<?= $a ?>][last_stand_photo]" id="last_stand_photo<?php echo $stand_page->id;  ?>" value="<?=$stand_page->stand_page_photo;?>" />
						<?php endif;?>
						
						<input type="file" name="stand_page_photo<?= $a ?>" id="" accept="image/*" />
						<?php if($stand_page->stand_page_photo){ 
								echo "<a href='javascript:void(0);' class='stand_page_delete_img' number='".$stand_page->id."'>Delete image</a>";
								}
						?>	
					<div>
				</div>
			</div>
			
			<div class="form-light-holder">
	<h1>Background Color</h1>
	<input type="hidden" name="data[<?= $a ?>][background_color]"  class="colourTextValue myNewColor_<?php echo $a; ?>" value="<?php if(!empty($stand_page->background_color)){ echo $stand_page->background_color; }?>" placeholder="Background Color" readonly="readonly" />
	<input id="cpFocus" class="coloPick" value="<?php if(!empty($stand_page->background_color)){ echo $stand_page->background_color; }?>"  />
	<div id="cpDiv" style="display:none"></div>
	
</div>
		</div>
	<?php 
			$a++; 
		}
	 } else { 
?>
<div class="standPages">
	<div class="form-light-holder">
		<h1>#1 Title </h1>
		<textarea name="data[1][title]" id="ckeditor_mini_stand_page_name1" class="ckeditor" placeholder="Enter your name here" /></textarea>
	</div>
		<div class="form-light-holder" style="">
			<h1>#1 Description </h1>
			 <textarea name="data[1][desc]" class="ckeditor" id="ckeditor_mini_stand_page_desc1"></textarea>
		</div>
		<div class="form-light-holder" style="overflow:auto;">
				<h1 style="padding-bottom: 5px;">#1 Image </h1>
				<input type="file" name="stand_page_photo1" id="" accept="image/*" />
			<div>
		</div>
		<div class="form-light-holder">
	<h1>Background Color</h1>
	<input type="hidden" name="data[1][background_color]"  class="colourTextValue myNewColor_1" placeholder="Background Color"  readonly="readonly" />
	<input id="cpFocus" class="coloPick"    />
	<div id="cpDiv" style="display:none"></div>
	
</div>
	</div>
</div>
<?php  } ?>


</div>
</div>	
</div>

<!-- 05/12 -->
<div class="display-none">
<div class="form-light-holder">
	<h1>Online Trial Title</h1>
	<input type="text" name="trial_title" value="<?=$details->trial_title;?>" class="field full_width_input">
</div>

<div class="form-light-holder">
	<h1>Online Trial description</h1>
	<div class="shorterCkeditor"><textarea name="trial_desc" id="ckeditor_mini_trial_desc" class="text ckeditor"><?=$details->trial_desc;?></textarea></div>
</div>

<div class="form-light-holder">
    	<h1>Mini-form Offer Title</h1>
       <input type="text" class="half_field" name="mini_form_offer_title" value="<?= $details->mini_form_offer_title ?>"  style="width:98%" />&nbsp;
</div>
<div class="form-light-holder">
    	<h1>Mini-form Offer Description</h1>
       <input type="text" class="half_field" name="mini_form_offer_desc" value="<?= $details->mini_form_offer_desc ?>"  style="width:98%" />&nbsp;
</div>

<div class="form-light-holder">
    	<h1>Mini-form Button 1 Text</h1>
       <input type="text" class="half_field" name="mini_form_button1_text" value="<?= $details->mini_form_button1_text ?>"  style="width:98%" />&nbsp;
</div>

<div class="form-light-holder">
    	<h1>Mini-form Buton 2 Text</h1>
       <input type="text" class="half_field" name="mini_form_button2_text" value="<?= $details->mini_form_button2_text ?>"  style="width:98%" />&nbsp;
</div>
</div>

<div class="page-section" id="Htmleditor_Basic_detail">
<div class="mb-3 main-content-label">HTML Editor</div>
<div class="form-light-holder">
	<h1>HTML Editor</h1>
	<textarea name="html_editor" id="ckeditor_full_html_editor" class="text ckeditor" style="width:50%"><?=$details->html_editor;?></textarea>
	
</div>

<div class="mb-3 main-content-label">Basic Detail</div>
<div class="form-light-holder">
		<h1>Meta Title</h1>
			<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($details->meta_title)?>" name="meta_title" id="meta_title" class="field full_width_input" placeholder="Meta title" style=""/>
	</div>
<div class="form-light-holder" style="">
<h1>Meta Description</h1>
	<textarea name="meta_desc" id="frm-text"><?php echo $this->query_model->getStrReplaceAdmin($details->meta_desc);?></textarea>
</div>

<div class="form-light-holder <?php echo $display_class; ?>">
	<h1>Body Id</h1>
	<input type="text" name="body_id" value="<?php echo $this->query_model->getStrReplaceAdmin($details->body_id);?>" class="field">
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
	<input type="radio" class="show_location_type" name="show_location_type" value="show_all" <?php echo ($details->show_location_type == "show_all" ) ? 'checked=checked' : ''; ?> /> <span>SHOW ALL LOCATIONS </span></label>
	
	<label class="rdiobox">
	<input type="radio" class="show_location_type" name="show_location_type" value="select_location" <?php echo ($details->show_location_type == "select_location" ) ? 'checked=checked' : ''; ?> /> <span>SELECT LOCATIONS TO SHOW </span></label>

</div>

<?php 
	if(!empty($dojo_cart_allLocations)){
		$selectedLocations = !empty($details->locations) ? unserialize($details->locations) : array();
		
?>
<div class="form-light-holder locationsDropdown  d-md-flex  dual_input">
	<div class="adsUrl  form-group">
		<h1>Locations</h1>
		<select name="locations[]" id="" class="field locationSelectBox" required='true' multiple="true" style="height:400px">
		<?php foreach($dojo_cart_allLocations as $location){ ?>
			<option value="<?php echo $location->id; ?>" <?php echo (!empty($selectedLocations) && in_array($location->id, $selectedLocations)) ? 'selected=selected' : ''; ?>><?php echo $location->name; ?></option>
		<?php } ?>
	</select>
	
	</div>	
</div>
<?php } ?>


</div>
</div>

<input type="hidden" value="<?=$details->id?>" name="program_id" id="program_id" class="hidden_cb" />
<input type="hidden" value="<?=$this->uri->segment(6)?>" id="category_id" class="" />
<input type="hidden" name="current_program_id" value="<?= $this->uri->segment(4); ?>" />
<input type="hidden" value="<?=($this->uri->segment(5) && $this->uri->segment(6))?$this->uri->segment(5).'/'.$this->uri->segment(6):'';?>" name="redirect" id="redirect" class="hidden_cb" />	
<input type="hidden" value="save" name="action_type" id="action_type" />
</div>

<?php endforeach;?>
<?php endif;?>
</div>




		</div>
		</div>
		
</form>
		</div>
	</div>
	</div>
	
	
	<!---------- Other Boxes ---------------->
	
	<br style="clear:both"		 />

<input type="hidden" class="totalAddMoreFeatures" value="<?php if(count($features) >= 1){ echo count($features); } else { echo 1; } ?>"  />

<input type="hidden" class="totalAddMoreStandAlonePage" value="<?php if(count($stand_pages) >= 1){ echo count($stand_pages); } else { echo 1; } ?>"  />
<script type="text/javascript">
window.onload = function () {
    var loadTime = window.performance.timing.domContentLoadedEventEnd-window.performance.timing.navigationStart; 
   
   setTimeout(function(){ 
	 $('#sidebar').stickySidebar({
		topSpacing: 0,
		bottomSpacing: 60,
	  });
		
  }, loadTime);
  
  <?php /*if(!empty($details->scroll_top)){ ?>
  $('body,html').animate({scrollTop: "<?php echo $details->scroll_top ?>"}, loadTime);
  <?php }*/ ?>
  
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


$(document).ready(function()
{


$("#full_colorpicker_opacity").spectrum({
   color: '<?php if(!empty($pagedetails)){ echo $details->background_color; }?>',
   
});

$("#action_colorpicker_opacity").spectrum({
   color: '<?php if(!empty($pagedetails)){ echo $details->action_background_color; }?>',
   
});

$("#benefits_colorpicker_opacity").spectrum({
   color: '<?php if(!empty($pagedetails)){ echo $details->benefits_background_color; }?>',
   
});

$("#video_colorpicker_opacity").spectrum({
   color: '<?php if(!empty($pagedetails)){ echo $details->video_background_color; }?>',
   
});

$("#headling_colorpicker_opacity").spectrum({
   color: '<?php if(!empty($pagedetails)){ echo $details->headling_background_color; }?>',
   
}); 

$("#statistics_colorpicker_opacity").spectrum({
   color: '<?php if(!empty($pagedetails)){ echo $details->statistics_background_color; }?>',
   
}); 

$("#benefits_2_colorpicker_opacity").spectrum({
   color: '<?php if(!empty($pagedetails)){ echo $details->benefits_2_background_color; }?>',
   
}); 

$("#benefits_3_colorpicker_opacity").spectrum({
   color: '<?php if(!empty($pagedetails)){ echo $details->benefits_3_background_color; }?>',
   
}); 

$("#white_stripe_colorpicker_opacity").spectrum({
   color: '<?php if(!empty($pagedetails)){ echo $details->white_stripe_background_color; }?>',
   
});

$("#header_title_colorpicker_opacity").spectrum({
   color: '<?php if(!empty($pagedetails)){ echo $details->header_title_background_color; }?>',
   
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


<script language="javascript">
$(document).ready(function(){


var mod_type1 = $("#mod_type").val().toLowerCase();

try{
$(".cat_sort_1").sortable({
update : function () {
serial = $('.cat_sort_1').sortable('serialize');
sort_list_li = $(this).find('li');
$.ajax({
url: "admin/"+mod_type1+"/sortProgramFullWidthRows/<?=$details->id;?>",
type: "post",
data: serial,
success: function(){
	$.each(sort_list_li,function(key, value){
		$(this).find('.badge-no').html(parseInt(key)+1+'.');
	});
}
});
}
});
} catch(e) {  }

try{
$(".cat_sort_2").sortable({
update : function () {
serial = $('.cat_sort_2').sortable('serialize');
sort_list_li = $(this).find('li');
$.ajax({
url: "admin/"+mod_type1+"/sortProgramLittleRows/<?=$details->id;?>",
type: "post",
data: serial,
success: function(){
	$.each(sort_list_li,function(key, value){
		$(this).find('.badge-no').html(parseInt(key)+1+'.');
	});
}
});
}
});
} catch(e) {  }


try{
$(".cat_sort_3").sortable({
update : function () {
serial = $('.cat_sort_3').sortable('serialize');
$.ajax({
url: "admin/"+mod_type1+"/sortProgramFaqs/<?=$details->id;?>",
type: "post",
data: serial,
error: function(){
alert("theres an error with AJAX");
}
});
}
});
} catch(e) {  }


try{
$(".cat_sort_4").sortable({
update : function () {
serial = $('.cat_sort_4').sortable('serialize');
sort_list_li = $(this).find('li');
$.ajax({
url: "admin/"+mod_type1+"/sortProgramSections/<?=$details->id;?>",
type: "post",
data: serial,
success: function(){
	$.each(sort_list_li,function(key, value){
		$(this).find('.badge-no').html(parseInt(key)+1+'.');
	});
}
});
}
});
} catch(e) {  }

$(".unpublish").click(function(){
	var pub_id = $(this).attr("id").substr(6);
	var mod_type = $("#mod_type").val().toLowerCase();
	var table_name = $(this).attr('table_name');
	var publish_type = $(this).parents(".manager-item-opts").children(".publish_type").val();
	//alert (publish_type);
	$.ajax({ 					
	type: 'POST',						
	url: 'admin/'+mod_type+'/publishProgramRows',						
	data: { pub_id : pub_id, publish_type: publish_type,table_name: table_name }					
	}).done(function(msg){ 
	if(msg != null){
	//alert(msg);
	setTimeout("window.location.reload()",1000);
	}
	else{
	setTimeout('$("#alert-holder").html("<div><b class=red>Unable to Unpublish.</b></div>")',1000);
	//alert(msg);
	}
	});
	//exit(0);
});

$("body").on('click','.sections_unpublish',function(){
	//alert('adsfdasf');
	var pub_id = $(this).attr("id").substr(6);
	var mod_type = $("#mod_type").val().toLowerCase();
	var table_name = $(this).attr('table_name');
	var is_new = $(this).attr('is_new');
	var publish_type = $(this).children(".toogle_btn").attr('publish_type');
	//alert(pub_id+'=>'+mod_type+'=>'+table_name+'=>'+is_new+'=>'+publish_type); return false;
	var updated_type = 1;
	if(publish_type == 1){
		updated_type = 0;
	}
	
	
	if(is_new == 1){
		if(updated_type == 1){
			$(this).find('.az-toggle').removeClass('on');
		}else{
			$(this).find('.az-toggle').addClass('on');
		}
	}
	
	$(this).children(".toogle_btn").attr('publish_type',updated_type); 
	
	$.ajax({ 					
	type: 'POST',						
	url: 'admin/'+mod_type+'/publishProgramRows',						
	data: { pub_id : pub_id, publish_type: publish_type,table_name: table_name }					
	}).done(function(msg){ 
	if(msg == 1){
		
	}
	else{
	//setTimeout('$("#alert-holder").html("<div><b class=red>Unable to Unpublish.</b></div>")',1000);
	//alert(msg);
	}
	});
	
});

$(".delete_item").click(function(){
var del_item_id = $(this).attr("id").substr(8);
var delete_program_id = $(this).attr("program_id");
var delete_cat_id = $(this).attr("cat_id");
var table_name = $(this).attr("table_name");
$("#delete-item-id").val(del_item_id);
$("#delete_program_id").val(delete_program_id);
$("#delete-cat-id").val(delete_cat_id);
$("#table_name").val(table_name);
$(".delete-holder-item").hide();
$(".delete-holder-item").slideDown(300);
//exit(0);
})
})
</script>
<input type="hidden" name="mod_type" value="<?=$link_type;?>" id="mod_type" />
				
<div class="program_full_detail page-section new_lisiting_block " id="AlternatingFullWidth">
				<div class="mb-3 main-content-label" >Alternating Full Width Rows</div>
				<div class="row row-xs align-items-center  mg-t-25 mg-b-5">
					<div class="col-md-12">
						<p>You may rearrange the order of the items below by dragging them above or below other item rows. Changes will automatically be saved.</p>
					</div>
					
				</div>
				
				<div class="row row-xs align-items-center mg-b-20  alternating-row-section ">
					
					<div class="col-md-12 mg-t-5 mg-md-t-0 ">
						<div class="az-content-body ">
			
							<div class="az-mail-header">
								<div>
								  <h4 class="az-content-title mg-b-5">Alternating Full Width Rows</h4>
								  <p>You have <span class="total_alternating_full_width_row"><?php echo !empty($programRows) ? count($programRows) : 0; ?></span> Entries</p>
								</div>
								<div>
								 <a href="javascript:void(0)" class="button_class btn btn-indigo  full_alternate_popup" data-toggle="modal" data-target="#fullAlternatePopup" action_type="add" item_id="" table_name="tbl_program_rows" form_type="full_width_row">Add Full Width Row</a>
								</div>
							  </div>
							  
							<ul class="cat_sort_1 ui-sortable alternating_full_width_row" style="">

<?php
$sr_testimonials=0; 


				
if(!empty($programRows)):?>
<?php foreach($programRows as $about_us_row):
 $sr_testimonials++;
?>


									<li   id="menu_<?=$about_us_row->id?>" class="full_width_row_<?=$about_us_row->id?> az-contact-info-header">
										<div class="manager-item media">
											<div style="float:left;">
												<div class="badge-no"><?=$sr_testimonials?>.</div>
												
                                                    
												<h4 class="full_width_row_heading_<?=$about_us_row->id?>"><a href="javascript:void(0)" ><?=$about_us_row->title;?>   ( <?php echo ucfirst($about_us_row->photo_side);?> )</a></h4>
											</div>
											<div class="manager-item-opts">
											
											
										<nav class="nav">
											 
											  <a href="javascript:void(0)" class="badge badge-primary  full_alternate_popup" data-toggle="modal" data-target="#fullAlternatePopup" action_type="edit" item_id="<?=$about_us_row->id;?>"  table_name="tbl_program_rows" form_type="full_width_row">Edit</a>
											  
													<a class="badge badge-primary delete_item" data-toggle="modal" data-target="#popupDeleteItem" item_id="<?=$about_us_row->id;?>"   table_name="tbl_program_rows" item_title="<?=$about_us_row->title;?>" section_type="full_width">Delete</a>
													<!--<div class="az-toggle az-toggle-success alternate_full_width_toogle on"><span></span></div> -->
													
													<a href="javascript:void(0)" id="unpub_<?=$about_us_row->id; ?>" class="sections_unpublish"  table_name="tbl_program_rows"  is_new="0">
												<div class="az-toggle az-toggle-success alternate_full_width_toogle toogle_btn <?php echo ($about_us_row->published == 1) ? 'on' : '';?>" publish_type="<?php echo ($about_us_row->published == 1) ? 0 : 1;?>"><span></span>
												<input type="hidden" name="publish_type" value="<?php echo ($about_us_row->published == 1) ? 0 : 1;?>" class="publish_type" />
												</div></a>
										</nav>
			
			
			
											</div>
										</div>
									</li>
<?php endforeach;?>								

<?php else: ?>

<?php endif;?>
								</ul>

			
			
						
						
				</div>
			</div>
		</div>
</div>



<div class="gen-holder program_full_detail page-section new_lisiting_block" id="AlternatingLittleRows">
				<div class="mb-3 main-content-label" >Alternating Little Rows</div>
				<div class="row row-xs align-items-center  mg-t-25 mg-b-5">
					<div class="col-md-12">
						<p>You may rearrange the order of the items below by dragging them above or below other item rows. Changes will automatically be saved.</p>
					</div>
					
				</div>
				
				<div class="row row-xs align-items-center mg-b-20 alternating-row-section ">
					
					<div class="col-md-12 mg-t-5 mg-md-t-0 ">
						<div class="az-content-body ">
			
							<div class="az-mail-header">
								<div>
								  <h4 class="az-content-title mg-b-5">Alternating Little Rows</h4>
								  <p>You have <span class="total_alternating_little_row"><?php echo !empty($programLittleRows) ? count($programLittleRows) : 0; ?></span> Entries</p>
								</div>
								<div>
								 <a href="javascript:void(0)" class="button_class btn btn-indigo  full_alternate_popup" data-toggle="modal" data-target="#fullAlternatePopup" action_type="add" item_id="" table_name="tbl_program_little_rows" form_type="little_row">Add Little Row</a>
								</div>
							  </div>
							  
						<ul class="cat_sort_2 ui-sortable alternating_little_row" style="">

					<?php
					$sr_testimonials=0; 


									
					if(!empty($programLittleRows)):?>
					<?php foreach($programLittleRows as $about_us_row):
					 $sr_testimonials++;
					 
					 $about_us_row->title = !empty($about_us_row->title) ? strip_tags($about_us_row->title) : '';
					?>
					<li   id="menu_<?=$about_us_row->id?>" class="little_row_<?=$about_us_row->id;?> az-contact-info-header">
						<div class="manager-item media">
							<div style="float:left" >
								
								<div class="badge-no"><?=$sr_testimonials?>. </div>	
								<h4  class="little_row_heading_<?=$about_us_row->id?>"><a href="javascript:void(0)" ><?=$about_us_row->title;?>   ( <?php echo ucfirst($about_us_row->photo_side);?> )</a></h4>
							</div>
							<div class="manager-item-opts">
							
							
							
							<nav class="nav">
							  
							  <a href="javascript:void(0)" class="badge badge-primary  full_alternate_popup" data-toggle="modal" data-target="#fullAlternatePopup" action_type="edit" item_id="<?=$about_us_row->id;?>"  table_name="tbl_program_little_rows" form_type="little_row">Edit</a>
							  
									<a class="badge badge-primary delete_item" data-toggle="modal" data-target="#popupDeleteItem" item_id="<?=$about_us_row->id;?>"   table_name="tbl_program_little_rows" item_title="<?=$about_us_row->title;?>"  section_type="little_row">Delete</a>
									<!--<div class="az-toggle az-toggle-success alternate_full_width_toogle on"><span></span></div> -->
									
									<a href="javascript:void(0)" id="unpub_<?=$about_us_row->id; ?>" class="sections_unpublish"  table_name="tbl_program_little_rows"  is_new="0">
								<div class="az-toggle az-toggle-success alternate_little_toogle toogle_btn <?php echo ($about_us_row->published == 1) ? 'on' : '';?>" publish_type="<?php echo ($about_us_row->published == 1) ? 0 : 1;?>"><span></span>
								<input type="hidden" name="publish_type" value="<?php echo ($about_us_row->published == 1) ? 0 : 1;?>" class="publish_type" />
								</div></a>
						</nav>
							
							</div>
						</div>
					</li>
<?php endforeach;?>								
<input type="hidden" name="mod_type" value="<?=$link_type;?>" id="mod_type" />
<?php else: ?>

<?php endif;?>
				</ul>
	  


				</div>
			</div>
		</div>
</div>


							  
							  

<?php /*<div class="gen-holder">
		<div class="gen-panel">
			<div class="panel-title">
				<div class="panel-title-name">Faqs</div>
				
			</div>
<div class="panel-body">
<div class="panel-body-holder">
<div class="manager-items custom">

<div class="border">

<!--<div class="btn-addentry add_entry_button"></div>-->

 <h1>Faqs <a href="admin/<?=$link_type?>/add_program_faq/<?=$details->id?>/view/<?=$details->category?>" class="button_class">Add Faq</a></h1>

<div class="dragDropContent">
	You may rearrange the order of the items below by dragging them above or below other item rows. Changes will automatically be saved.
</div>
<ul class="cat_sort_3 ui-sortable" style="">

<?php
$sr_testimonials=0; 


				
if(!empty($programFaqs)):?>
<?php foreach($programFaqs as $about_us_row):
 $sr_testimonials++;
?>
									<li   id="menu_<?=$about_us_row->id?>">
										<div class="manager-item">
											<div style="float:left;">
												<!-- <h2><?=$about_us_row->id?></h2> --><h2><?=$sr_testimonials?></h2>
												<!--<div class="manager-item-image" style="overflow: hidden; ">
                                                <?php
													if($about_us_row->photo){
												?>
													<img src="<?=$about_us_row->photo?>" style="display: inline-block; width: 100px; margin-top: -14px; ">
                                                <?php
													}
                                                ?>
												</div>-->
                                                    
												<h1><a href="admin/<?=$link_type?>/edit/<?=$about_us_row->id;?>" ><?=$about_us_row->title;?>  </a></h1>
											</div>
											<div class="manager-item-opts"><a href="admin/<?=$link_type?>/edit_program_faq/<?=$about_us_row->id;?>" class="lb-preview">Edit</a><?php if($about_us_row->published == 1){?>
											<a id="unpub_<?=$about_us_row->id; ?>" class="unpublish"  table_name="tbl_program_faqs" title="Unpublish <?=$about_us_row->title?>">Unpublish</a>
											<input type="hidden" name="publish_type" value="0" class="publish_type" />
											<?php }else{ ?>
											<input type="hidden" name="publish_type" value="1" class="publish_type" />
											<a id="unpub_<?=$about_us_row->id; ?>"  table_name="tbl_program_faqs" class="unpublish" title="Publish <?=$about_us_row->title?>">Publish</a>
											<?php }?><a program_id="<?=$about_us_row->program_id?>" cat_id="<?=$about_us_row->cat_id?>" table_name="tbl_program_faqs" id="delitem_<?=$about_us_row->id?>" class="delete_item" title="Delete <?=$about_us_row->title;?>">Delete</a></div>
										</div>
									</li>
<?php endforeach;?>								
<input type="hidden" name="mod_type" value="<?=$link_type;?>" id="mod_type" />
<?php else: ?>
<div class="empty"><a href="admin/<?=$link_type?>/add_program_faq/<?=$details->id?>/view/<?=$details->category?>" class="nothing-yet">Add Faq</a></div>
<?php endif;?>
								</ul>
<br />
</div>				
</div>

</div>

</div>
</div>
</div> */ ?>



<!--<div class="gen-holder program_full_detail">
		<div class="gen-panel">
			<div class="panel-title">
				<div class="panel-title-name">Manage Program Sections Position</div>
				
			</div>
<div class="panel-body">
<div class="panel-body-holder">
<div class="manager-items custom">

<div class="border">


<h1>Manage Program Sections Position <a href="admin/<?=$link_type?>/default_program_sections/<?=$details->id?>/view/<?=$details->category?>" class="modal-effect badge-primary badge">Default Re-Arrange</a></h1>

<div class="dragDropContent">
	You may rearrange the order of the items below by dragging them above or below other item rows. Changes will automatically be saved.
</div>
<ul class="cat_sort_4 ui-sortable" style="">

<?php
$sr_testimonials=0; 


$sectionArr = array('question_headline_section'=>'Question Headline Section','white_stripe_section'=>'White Stripe Under Header Section','benefits_1_section'=>'Benefits with 3 images Section','video_row_section'=>'Video Row Section','call_to_action_section'=>'Call to Action with 3 Images Section','headling_section'=>'Heading with 3 boxes Section','statistics_section'=>'Statistics with 3 images Section','benefits_2_section'=>'Benefits Row2 with 3 Images Section','white_stripe_2_section'=>'White Stripe Row 2 Section','benefits_3_section'=>'Benefits Row3 with 3 Images Section','full_width_row_section'=>'Alternating Full Width Rows','little_row_section'=>'Alternating Little Rows','faq_section'=>'Faqs','testimonial_section'=>'Testimonials','html_editor_section'=>'HTML Editor');
			
if(!empty($programSections)):?>
<?php foreach($programSections as $about_us_row):
 $sr_testimonials++;
?>
									<li   id="menu_<?=$about_us_row->id?>">
										<div class="manager-item">
											<div style="float:left;">
												
                                                 <h2><?=$sr_testimonials?></h2>   
												<h1><a href="javascript:void(0)" ><?=$sectionArr[$about_us_row->section];?>  </a></h1>
											</div>
											<div class="manager-item-opts"><?php if($about_us_row->published == 1){?>
											<a id="unpub_<?=$about_us_row->id; ?>" class="unpublish"  table_name="tbl_program_sections" title="Unpublish <?= $sectionArr[$about_us_row->section]?>">Unpublish</a>
											<input type="hidden" name="publish_type" value="0" class="publish_type" />
											<?php }else{ ?>
											<input type="hidden" name="publish_type" value="1" class="publish_type" />
											<a id="unpub_<?=$about_us_row->id; ?>"  table_name="tbl_program_sections" class="unpublish" title="Publish <?=$sectionArr[$about_us_row->section]?>">Publish</a>
											<?php }?></div>
										</div>
									</li>
<?php endforeach;?>								
<input type="hidden" name="mod_type" value="<?=$link_type;?>" id="mod_type" />
<?php else: ?>
<?php endif;?>
								</ul>
<br />
</div>				
</div>

</div>

</div>
</div>
</div> -->



	
	
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
	 




<?php $this->load->view("admin/include/conf_delete_program_rows"); ?>


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
	
	
	
	$('.modal-effect').on('click', function(e){
	  e.preventDefault();
	  var effect = $(this).attr('data-effect');
	  $('#modaldemo8').addClass(effect);
	});
	

</script>

<div id="modaldemo8" class="modal">
      <div class="modal-dialog modal-dialog-centered sortable-box" role="document">
        <div class="modal-content modal-content-demo">
          <div class="modal-header">
            <h6 class="modal-title">Manage Program Position</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <ul id="sortable" class="cat_sort_4 ui-sortable">	
<?php
$sr_testimonials=0; 


$sectionArr = array('question_headline_section'=>'Question Headline','white_stripe_section'=>'White Stripe Under Header','benefits_1_section'=>'Benefits with 3 images','video_row_section'=>'Video Row','call_to_action_section'=>'Call to Action with 3 Images','headling_section'=>'Heading with 3 boxes','statistics_section'=>'Statistics with 3 images','benefits_2_section'=>'Benefits Row 2 with 3 Images','white_stripe_2_section'=>'White Stripe Row 2','benefits_3_section'=>'Benefits Row 3 with 3 Images','full_width_row_section'=>'Alternating Full Width Rows','little_row_section'=>'Alternating Little Rows','faq_section'=>'FAQs','testimonial_section'=>'Testimonials','html_editor_section'=>'HTML Editor');
			
if(!empty($programSections)):?>
<?php foreach($programSections as $about_us_row):
 $sr_testimonials++;
?>			
				<li class="ui-state-default"  id="menu_<?=$about_us_row->id?>"><div class="badge-no"><?=$sr_testimonials?></div><h6><?=$sectionArr[$about_us_row->section];?></h6> 
				
				<!--<a href="javascript:void(0)" id="unpub_<?=$about_us_row->id; ?>" class="sections_unpublish"  table_name="tbl_program_sections">
				<div class="az-toggle az-toggle-success program_section_toogle toogle_btn  <?php echo ($about_us_row->published == 1) ? 'on' : '';?>" publish_type="<?php echo ($about_us_row->published == 1) ? 0 : 1;?>"><span></span>
				<input type="hidden" name="publish_type" value="<?php echo ($about_us_row->published == 1) ? 0 : 1;?>" class="publish_type" />
				</div></a> --->
				
				<a href="javascript:void(0)" id="unpub_<?=$about_us_row->id; ?>" class="sections_unpublish"  table_name="tbl_program_sections" is_new="0">
				<div class="az-toggle az-toggle-success program_section_toogle toogle_btn <?php echo ($about_us_row->published == 1) ? 'on' : '';?>" publish_type="<?php echo ($about_us_row->published == 1) ? 0 : 1;?>"><span></span>
				<input type="hidden" name="publish_type" value="<?php echo ($about_us_row->published == 1) ? 0 : 1;?>" class="publish_type" />
				</div></a>
				
				
				</li>
				
<?php endforeach;?>								
<input type="hidden" name="mod_type" value="<?=$link_type;?>" id="mod_type" />
<?php else: ?>
<?php endif;?>
			</ul>
          </div>
          <div class="modal-footer">
            <!--<button type="button" class="btn btn-indigo closePopup" modal_id="modaldemo8">Save changes</button> -->
            <a href="admin/<?=$link_type?>/default_program_sections/<?=$details->id?>/view/<?=$details->category?>" class="btn btn-outline-light" >Default Re-Arrange</a>
          </div>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->



 <div id="popupDeleteItem" class="modal">
      <div class="modal-dialog modal-dialog-centered sortable-box" role="document">
        <div class="modal-content modal-content-demo">
          <div class="modal-header">
            <h6 class="modal-title"></h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
		  <form action="admin/<?=$link_type;?>/delete_program_row" method="post" id="deleteForm">
          <div class="modal-body edit-form">
             <div class="row row-xs align-items-center delete_popup_text_block">
					<div class="col-md-12 mg-t-5 mg-md-t-0 text-center">
						<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
						<h2 class="heading">Are you sure?</h2>
						<h5 class="subheading">You will not be able to recover the deleted record.</h5>
					</div>
				</div>
				<input type="hidden" name="delete-item-id" id="delete_item_id" value="">
				<input type="hidden" name="table_name" id="delete_item_table_name" value="">
				<input type="hidden"  id="delete_item_section_type" value="">
          </div>
          <div class="modal-footer">
			  <div class="col-md-6 text-left">
				<a href="javascript:void(0)" class="btn btn-indigo popup_cancel_btn" data-dismiss="modal">No, cancel please!</a>
			  </div>
			   <div class="col-md-6 text-right">
				<a href="javascript:void(0)" class="btn btn-indigo popup_delete_btn">Yes, Delete It!</a>
			   </div>
          </div>
		  </form>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->
	
	
	<div id="fullAlternatePopup" class="modal">
      <div class="modal-dialog modal-dialog-centered sortable-box" role="document">
        <div class="modal-content modal-content-demo">
          <div class="modal-header">
            <h6 class="modal-title"></h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
		  <form id="fullAlternateAddForm" action="" method="post" enctype="multipart/form-data">
		  <div id="form_alternate_popup"></div>
		  
		  <input type="hidden" name="program_id" value="<?php echo $this->uri->segment(4) ?>" class="" />
		  <input type="hidden" name="cat_id" value="<?php echo $this->uri->segment(6) ?>" class="" />
		  </form>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->
	
	
	