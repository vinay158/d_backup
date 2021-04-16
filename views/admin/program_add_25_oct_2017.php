<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<!--<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>-->
<script src="js/ckeditor_full/ckeditor.js"></script>
<link id="jquiCSS" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/ui-lightness/jquery-ui.css" type="text/css" media="all">
	<link href="colorpicker/css/evol.colorpicker.min.css" rel="stylesheet" />
	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js" type="text/javascript"></script>-->
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js" type="text/javascript"></script>
	<script src="colorpicker/js/evol.colorpicker.min.js" type="text/javascript"></script>
<script>
	$(document).ready(function(){
		 CKEDITOR.replace(  'ckeditor_mini_header_title', 
									{ customConfig : 'config.js' }
							);
		
		 CKEDITOR.replace(  'ckeditor_mini_stand_page_name1', 
									{ customConfig : 'config.js' }
							);	
		
		CKEDITOR.replace(  'ckeditor_full_stand_page_desc_1',
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
	});
</script>

<script language="javascript">
$(window).load(function(){
	if($('.receive_class_button_hidden_cb').val() == 0){
		$('.DetailBox').hide();
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



})
</script>

<div class="gen-holder">
	<div class="gen-panel-holder"  style="width: 100% !important;">
	<div class="gen-panel">
		<div class="panel-title">
			<div class="panel-title-name">Add Program</div>
		</div>
		<div class="panel-body">
		<div class="panel-body-holder">
		<div class="form-holder">

<form id="blog_form" action="" method="post" enctype="multipart/form-data">
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
<div class="form-light-holder">
<h1>Override Logo</h1>
	<select name="override_logo" id="window" class="field">
	<?php foreach($override_logos as  $override_logo):?>
	<option value="<?=$override_logo->s_no?>"><?=$override_logo->logo_name?></option>
	<?php endforeach;?>
	</select>
</div>
<div class="form-light-holder">
	<div class="adsUrl">
		<h1>Program Name</h1>
		<input type="text" value="" name="name" id="name" class="field" placeholder="Enter your name here"/>
	</div>
	<div class="linkTarget">
		<h1>Button Name</h1>
		<input type="text" value="" name="btnname" id="btnname" class="field" placeholder="Enter your button name here"/>
	</div>
	
</div>
<div class="form-light-holder">
	<h1>Slug</h1>
	<input type="text" value="" name="slug" id="slug" class="field" placeholder="Enter your slug here"/>
</div>
<div class="form-light-holder" style="padding-bottom:30px;">
		<div class="adsUrl">
			<h1>Category</h1>
			<select name="category" id="category" style="width: 70%; background:#FFF; border: none; border-radius: 5px; padding: 5px" >
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
	<div class="linkTarget">
		<h1>Ages</h1>
	<input type="text" value="" name="ages" id="" class="field" placeholder="Enter Ages here" />
	</div>
	
</div>



<div class="form-light-holder">
        <h1>Features</h1>
		<div id="AddMoreFeatures">
			<div class=""><h3><a href="javascript:void(0);" class="AddMoreButton">Add More</a></h3></div>
			
			&#10687;<input type="text"  name="features[1]" id="features" value="" class="field"  placeholder="Enter Features here"/><br>
			
		</div>
    </div>
	
	
	
<div class="form-light-holder" style="padding-bottom:30px;">
	<h1>Description</h1>
	<!--<textarea name="text" class="textarea" id="frm-text"></textarea>
	--><textarea name="text" id="ckeditor_full_body_desc" class="ckeditor" id="frm-text"></textarea>
</div>

<div class="form-light-holder" style="overflow:auto;">
	<h1 style="padding-bottom: 5px;">Choose a Photo</h1>
	<input type="file" name="userfile" id="photo" accept="image/*" />
		<div>
		</div>
</div>

<h1 style="padding-bottom: 5px;"><b>Header Section:-</b></h1>

<div class="form-light-holder">
	<h1>Header</h1>
	<textarea type="text" id="ckeditor_mini_header_title" name="header_title" class="field" style="width:98%"></textarea>
</div>

<div class="form-light-holder">
	<h1>Header Description</h1>
	<div class="shorterCkeditor"><textarea name="header_desc" id="ckeditor_mini_header_desc" class="text ckeditor"></textarea></div>
</div>
<div class="form-light-holder" style="overflow:auto;">

	<h1 style="padding-bottom: 5px;">Header Image</h1>
	
	<input type="file" name="userfile" id="photo"  accept="image/*"  />
	
		<div>
		</div>
</div>
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Background Image</h1>
	<input type="file" name="background_image" id="photo_left" accept="image/*" />
	
		<div>
		</div>
</div>

<div class="form-light-holder">
	<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs-header'>
    <div id='docs-content-header'>
		<input id="full_colorpicker_opacity" name="background_color" class="colourTextValue" value="" />
    </div>
	
 </div>
</div>	



<h1 style="padding-bottom: 5px;"><b>White Stripe Under Header Section:-</b></h1>
<div class="form-light-holder">
	<h1>Body Title</h1>
	<textarea type="text" name="body_title" id="ckeditor_mini_body_title1" class="field ckeditor" style="width:98%"></textarea>
</div>
<div class="form-light-holder">
	<h1>Body Description</h1>
	<textarea name="body_desc" id="ckeditor_full_body_desc1" class="text ckeditor" style="width:50%"></textarea>
	
</div>

<div class="form-light-holder">
	<h1>Image Position</h1>
	<select name="body_img_position" class="field">
		<option value="left" >Left</option>
		<option value="right" >Right</option>
	</select>
	
</div>

<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Body Image</h1>
	<input type="file" name="body_image" id="body_image" accept="image/*" />
</div>




<h1 style="padding-bottom: 5px;"><b>Benefits with 3 images Section:-</b></h1>
<div class="form-light-holder">
	<h1>Benefits Title</h1>
	<input type="text" name="benefits_title" value="" class="field" style="width:98%">
</div>

<div class="form-light-holder">
	<h1>Benefits description</h1>
	<div class="shorterCkeditor"><textarea name="benefits_desc" id="ckeditor_mini_benefits_desc" class="text ckeditor"></textarea></div>
</div>

	
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Background Image</h1>
	<input type="file" name="benefits_background_image" id="photo_left" accept="image/*" />
	
</div>

<div class="form-light-holder">
	<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs-benefits'>
    <div id='docs-content-benefits'>
		<input id="benefits_colorpicker_opacity" name="benefits_background_color" class="colourTextValueBenefits" value="" />
    </div>
	
 </div>
</div>

<div class="form-light-holder">
	<h1>Headline #1</h1>
	<input type="text" name="benefits_headline_1" value="" class="field" style="width:98%">
</div>
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Image uploader #1</h1>
	<input type="file" name="benefits_image_1" id="benefits_image_1" accept="image/*" />
	
</div>


<div class="form-light-holder">
	<h1>Headline #2</h1>
	<input type="text" name="benefits_headline_2" value="" class="field" style="width:98%">
</div>
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Image uploader #2</h1>
	<input type="file" name="benefits_image_2" id="benefits_image_2" accept="image/*" />
	
</div>

<div class="form-light-holder">
	<h1>Headline #3</h1>
	<input type="text" name="benefits_headline_3" value="" class="field" style="width:98%">
</div>
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Image uploader #3</h1>
	<input type="file" name="benefits_image_3" id="benefits_image_3" accept="image/*" />
	
</div>



	<h1 style="padding-bottom: 5px;"><b>Video Row:-</b></h1>
	
	<div class="form-light-holder">
	<div class="adsUrl">
		<h1>Video Type</h1>
		<select name="video_type" id="" class="field videoType" >
		<option value="youtube_video" >Youtube Video</option>
		<option value="vimeo_video" >Vimeo Video</option>
	</select>
	
	</div>
	<div class="linkTarget">
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




<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Background Image</h1>
	<input type="file" name="video_background_image" id="photo_left" accept="image/*" />
	
</div>

<div class="form-light-holder">
	<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs-video'>
    <div id='docs-content-video'>
		<input id="video_colorpicker_opacity" name="video_background_color" class="colourTextValueVideo" value="" />
    </div>
	
 </div>
</div>



<h1 style="padding-bottom: 5px;"><b>Call to Action with 3 Images Section:-</b></h1>
<div class="form-light-holder">
	<h1>Call to Action Title</h1>
	<input type="text" name="action_title" value="" class="field" style="width:98%">
</div>

<div class="form-light-holder">
	<h1>Call to Action description</h1>
	<div class="shorterCkeditor"><textarea name="action_desc" id="ckeditor_mini_action_desc" class="text ckeditor"></textarea></div>
</div>

	
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Background Image</h1>
	<input type="file" name="action_background_image" id="photo_left" accept="image/*" />
	
</div>

<div class="form-light-holder">
	<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs-action'>
    <div id='docs-content-action'>
		<input id="action_colorpicker_opacity" name="action_background_color" class="colourTextValueAction" value="" />
    </div>
	
 </div>
</div>

<div class="form-light-holder">
	<h1>Title #1</h1>
	<input type="text" name="action_headline_1" value="" class="field" style="width:98%">
</div>
<div class="form-light-holder">
	<h1>Description #1</h1>
	<input type="text" name="action_desc_1" value="" class="field" style="width:98%">
</div>
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Image uploader #1</h1>
	<input type="file" name="action_image_1" id="action_image_1" accept="image/*" />
	
</div>


<div class="form-light-holder">
	<h1>Title #2</h1>
	<input type="text" name="action_headline_2" value="" class="field" style="width:98%">
</div>
<div class="form-light-holder">
	<h1>Description #2</h1>
	<input type="text" name="action_desc_2" value="" class="field" style="width:98%">
</div>
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Image uploader #2</h1>
	<input type="file" name="action_image_2" id="action_image_2" accept="image/*" />
	
</div>

<div class="form-light-holder">
	<h1>Title #3</h1>
	<input type="text" name="action_headline_3" value="" class="field" style="width:98%">
</div>
<div class="form-light-holder">
	<h1>Description #3</h1>
	<input type="text" name="action_desc_3" value="" class="field" style="width:98%">
</div>
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Image uploader #3</h1>
	<input type="file" name="action_image_3" id="action_image_3" accept="image/*" />
	
</div>



<h1 style="padding-bottom: 5px;"><b>Headling with 3 boxes Section:-</b></h1>
<div class="form-light-holder">
	<h1>Headling  Title</h1>
	<input type="text" name="headling_title" value="" class="field" style="width:98%">
</div>

<div class="form-light-holder">
	<h1>Headling description</h1>
	<div class="shorterCkeditor"><textarea name="headling_desc" id="ckeditor_mini_headling_desc" class="text ckeditor"></textarea></div>
</div>

	
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Background Image</h1>
	<input type="file" name="headling_background_image" id="photo_left" accept="image/*" />
	
</div>

<div class="form-light-holder">
	<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs-headling'>
    <div id='docs-content-headling'>
		<input id="headling_colorpicker_opacity" name="headling_background_color" class="colourTextValueHeadling" value="" />
    </div>
	
 </div>
</div>

<div class="form-light-holder">
	<h1>Headline #1</h1>
	<input type="text" name="headling_headline_1" value="" class="field" style="width:98%">
</div>



<div class="form-light-holder">
	<h1>Headline #2</h1>
	<input type="text" name="headling_headline_2" value="" class="field" style="width:98%">
</div>


<div class="form-light-holder">
	<h1>Headline #3</h1>
	<input type="text" name="headling_headline_3" value="" class="field" style="width:98%">
</div>




<h1 style="padding-bottom: 5px;"><b>Statistics with 3 images Section:-</b></h1>
<div class="form-light-holder">
	<h1>Statistics Title</h1>
	<input type="text" name="statistics_title" value="" class="field" style="width:98%">
</div>

<div class="form-light-holder">
	<h1>Statistics description</h1>
	<div class="shorterCkeditor"><textarea name="statistics_desc" id="ckeditor_mini_statistics_desc" class="text ckeditor"></textarea></div>
</div>

	
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Background Image</h1>
	<input type="file" name="statistics_background_image" id="photo_left" accept="image/*" />
	
</div>

<div class="form-light-holder">
	<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs-statistics'>
    <div id='docs-content-statistics'>
		<input id="statistics_colorpicker_opacity" name="statistics_background_color" class="colourTextValueStatistics" value="" />
    </div>
	
 </div>
</div>

<div class="form-light-holder">
	<h1>Title #1</h1>
	<input type="text" name="statistics_headline_1" value="" class="field" style="width:98%">
</div>
<div class="form-light-holder">
	<h1>Description #1</h1>
	<input type="text" name="statistics_desc_1" value="" class="field" style="width:98%">
</div>
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Image uploader #1</h1>
	<input type="file" name="statistics_image_1" id="statistics_image_1" accept="image/*" />
	
</div>


<div class="form-light-holder">
	<h1>Title #2</h1>
	<input type="text" name="statistics_headline_2" value="" class="field" style="width:98%">
</div>
<div class="form-light-holder">
	<h1>Description #2</h1>
	<input type="text" name="statistics_desc_2" value="" class="field" style="width:98%">
</div>
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Image uploader #2</h1>
	<input type="file" name="statistics_image_2" id="statistics_image_2" accept="image/*" />
	
</div>

<div class="form-light-holder">
	<h1>Title #3</h1>
	<input type="text" name="statistics_headline_3" value="" class="field" style="width:98%">
</div>
<div class="form-light-holder">
	<h1>Description #3</h1>
	<input type="text" name="statistics_desc_3" value="" class="field" style="width:98%">
</div>
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Image uploader #3</h1>
	<input type="file" name="statistics_image_3" id="statistics_image_3" accept="image/*" />
	
</div>






<h1 style="padding-bottom: 5px;"><b>Benefits Row2 with 3 Images Section:-</b></h1>
<div class="form-light-holder">
	<h1>Benefits Row2 Title</h1>
	<input type="text" name="benefits_2_title" value="" class="field" style="width:98%">
</div>

<div class="form-light-holder">
	<h1>Benefits Row2 description</h1>
	<div class="shorterCkeditor"><textarea name="benefits_2_desc" id="ckeditor_mini_benefits_2_desc" class="text ckeditor"></textarea></div>
</div>

	
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Background Image</h1>
	<input type="file" name="benefits_2_background_image" id="photo_left" accept="image/*" />
	
</div>

<div class="form-light-holder">
	<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs-benefits_2'>
    <div id='docs-content-benefits_2'>
		<input id="benefits_2_colorpicker_opacity" name="benefits_2_background_color" class="colourTextValueBenefits_2" value="" />
    </div>
	
 </div>
</div>

<div class="form-light-holder">
	<h1>Title #1</h1>
	<input type="text" name="benefits_2_headline_1" value="" class="field" style="width:98%">
</div>
<div class="form-light-holder">
	<h1>Description #1</h1>
	<input type="text" name="benefits_2_desc_1" value="" class="field" style="width:98%">
</div>
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Image uploader #1</h1>
	<input type="file" name="benefits_2_image_1" id="benefits_2_image_1" accept="image/*" />
	
</div>


<div class="form-light-holder">
	<h1>Title #2</h1>
	<input type="text" name="benefits_2_headline_2" value="" class="field" style="width:98%">
</div>
<div class="form-light-holder">
	<h1>Description #2</h1>
	<input type="text" name="benefits_2_desc_2" value="" class="field" style="width:98%">
</div>
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Image uploader #2</h1>
	<input type="file" name="benefits_2_image_2" id="benefits_2_image_2" accept="image/*" />
	
</div>

<div class="form-light-holder">
	<h1>Title #3</h1>
	<input type="text" name="benefits_2_headline_3" value="" class="field" style="width:98%">
</div>
<div class="form-light-holder">
	<h1>Description #3</h1>
	<input type="text" name="benefits_2_desc_3" value="" class="field" style="width:98%">
</div>
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Image uploader #3</h1>
	<input type="file" name="benefits_2_image_3" id="benefits_2_image_3" accept="image/*" />
	
</div>




<h1 style="padding-bottom: 5px;"><b>White Stripe Row 2 Section:-</b></h1>
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

<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Image</h1>
	<input type="file" name="white_stripe2_image" id="white_stripe2_image" accept="image/*" />
	
</div>



<h1 style="padding-bottom: 5px;"><b>Benefits Row3 with 3 Images Section:-</b></h1>
<div class="form-light-holder">
	<h1>Benefits Row3 Title</h1>
	<input type="text" name="benefits_3_title" value="" class="field" style="width:98%">
</div>

<div class="form-light-holder">
	<h1>Benefits Row3 description</h1>
	<div class="shorterCkeditor"><textarea name="benefits_3_desc" id="ckeditor_mini_benefits_3_desc" class="text ckeditor"></textarea></div>
</div>

	
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Background Image</h1>
	<input type="file" name="benefits_3_background_image" id="photo_left" accept="image/*" />
	
</div>

<div class="form-light-holder">
	<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs-benefits_3'>
    <div id='docs-content-benefits_3'>
		<input id="benefits_3_colorpicker_opacity" name="benefits_3_background_color" class="colourTextValuebenefits_3" value="" />
    </div>
	
 </div>
</div>

<div class="form-light-holder">
	<h1>Title #1</h1>
	<input type="text" name="benefits_3_headline_1" value="" class="field" style="width:98%">
</div>

<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Image uploader #1</h1>
	<input type="file" name="benefits_3_image_1" id="benefits_3_image_1" accept="image/*" />
	
</div>


<div class="form-light-holder">
	<h1>Title #2</h1>
	<input type="text" name="benefits_3_headline_2" value="" class="field" style="width:98%">
</div>

<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Image uploader #2</h1>
	<input type="file" name="benefits_3_image_2" id="benefits_3_image_2" accept="image/*" />
	
</div>

<div class="form-light-holder">
	<h1>Title #3</h1>
	<input type="text" name="benefits_3_headline_3" value="" class="field" style="width:98%">
</div>
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Image uploader #3</h1>
	<input type="file" name="benefits_3_image_3" id="benefits_3_image_3" accept="image/*" />
	
</div>





<h1><b>Email Opt-in #1</b></h1>

<div class="form-light-holder">

	<h1>Opt-In Text</h1>
	<input type="text" value="" name="opt1_text" id="" class="field" placeholder=""  style="width: 98%"/>
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
<br/>
<h1><b>Email Opt-in #2</b></h1>

<div class="form-light-holder">

	<h1>Opt-In Title</h1>
	<input type="text" value="" name="opt_2_title" id="" class="field" placeholder=""  style="width: 98%"/>
</div>

<div class="form-light-holder">

	<h1>Opt-In Text</h1>
	<input type="text" value="" name="opt_2_text" id="" class="field" placeholder=""  style="width: 98%"/>
</div>

<div class="form-light-holder form2checkbox">

	<a id="published" class="checkbox2 check-off"></a>

	<h1 class="inline">Show Full Form </h1>

	<input type="hidden" value="0" name="show_full_form_2" class="hidden_cb2" />

</div>




<h1 style="padding-bottom: 5px;"> &nbsp; </h1>

<div style="display:<?php if($user_level != 1 ){ echo 'none'; } ?>">
<div class="form-light-holder landing_page">
	
	<a id="free_trials" class="checkbox_landing_page check-off"></a>
	<h1 class="inline">Link to other landing page</h1>
	<input type="hidden"  name="landing_checkbox" class=" stand_alone_page_button checkbx1" />
</div>
<div id="landing_page_box" style="display:none">
<div class="form-light-holder">
	<h1>Select Program</h1>
	
		<select name="landing_program" id="" class="field landing_program" >
			<option value="">-Select Program-</option>
			<?php foreach($stand_programs as $stand_program){
					 $cateogry_detail = $this->query_model->getbySpecific('tblcategory','cat_id', $stand_program[0]->category);
						$program_url = '';
						if($stand_program[0]->landing_checkbox == 1){
							if(!empty($stand_program[0]->landing_program)){
								$program_url = $stand_program[0]->landing_program;
							}elseif(!empty($stand_program[0]->landing_page_url)){
								$program_url = $stand_program[0]->landing_page_url;
							}
						}else{
							$program_url = $program_slug.'/'.$cateogry_detail[0]->cat_slug.'/'.$stand_program[0]->program_slug;
						}
			?>
				<option number="<?php echo $stand_program[0]->id ?>" value="<?php echo $program_url; ?>"><?= $stand_program[0]->program ?></option>
			<?php  } ?>
		</select>
		<input type="hidden" name="landing_program_id" class="landing_program_id" value="" />
		<br />
	<span class="orbtn">OR</span>
	<h1>Landing Page Url</h1>
		<input type="text" value="" name="landing_page_url" class="field landing_page_url" placeholder="Enter Url here" />
		<p class="urlErrorMsg"></p>
</div>		
		
	</div>	
	
	
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

<div class="form-light-holder">
	<a id="free_trials" class="checkbox check-off"></a>
	<h1 class="inline">Show stand-alone page for this program?</h1>
	<input type="hidden" value="0" name="stand_alone_page" class="hidden_cb stand_alone_page_button checkbx2" />
</div>

<div class="stand_alone_page">
	<div class="form-light-holder">
	<div class="adsUrl">
		<h1>Stand-Alone Program Name</h1>
		<input type="text" value="" name="stand_program_name" class="field" placeholder="Enter Your Stand-Alone Program Name Here"/>
	</div>
	<div class="linkTarget">
		<h1>Stand-Alone Ages</h1>
		<input type="text" value="" name="stand_program_ages" class="field" placeholder="Enter Stand-Alone Ages Here"/>
	</div>
	
</div>
	

	
<!-------- - Image And Video - ------------>
<div class="form-light-holder">

	<h1>Image Or Video</h1>

	<input type="radio" class="image_video" name="image_video" value="image"  /> Image <br />
	<input type="radio" class="image_video" name="image_video" value="video" checked="checked" /> Video

</div>
<div class="welcome_image">
<div class="form-light-holder" style="overflow:auto;">
	<div class="adsUrl">
	<h1 style="padding-bottom: 5px;">Choose a Photo</h1>
	
		
		<input type="file" name="userfile_2" id="userfile_2" accept="image/*" />
	
		</div>
		<div class="linkTarget">
		<h1>Image alt text</h1>
	<input type="text" value="" name="image_alt" id="image_alt" class="field" placeholder="image alt text"/>
		</div>
		<div>
		</div>
</div>

</div>
<div class="form-light-holder welcome_video">
	<div class="adsUrl">
		<h1>Video Type</h1>
		<select name="video_type" id="" class="field videoType" >
		<option value="youtube_video">Youtube Video</option>
		<option value="vimeo_video" >Vimeo Video</option>
	</select>
	
	</div>
	<div class="linkTarget">
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
		<div class="form-light-holder" style="padding-bottom:30px;">
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
<div class="form-light-holder">
	<h1>Online Trial Title</h1>
	<input type="text" name="trial_title" value="" class="field" style="width:98%">
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



<div class="form-light-holder receive_class_button">
	<a id="published" class="receive_class_button_checkbox check-off" ></a>
	<h1 class="inline">receive class schedule & pricing</h1>
	<input type="hidden" value="0" name="receive_class_button" class="receive_class_button_hidden_cb" />
</div>
<div  class="DetailBox">
<div class="form-light-holder">
	
    <div class="adsUrl">
		<h1>Button Text</h1>
		<input type="text" value="" name="receive_button_text" id="name" class="field" placeholder="Enter your button text here" />
	</div>
	<div class="linkTarget">
		<h1>Button Link</h1>
	<input type="text" value="" name="receive_button_link" id="btnname" class="field" placeholder="Enter your button url here"/>
	</div>
    
</div>
</div>

<div class="form-light-holder">
		<h1>Meta Title</h1>
			<input type="text" value="" name="meta_title" id="meta_title" class="field" placeholder="Meta title" style="width: 98%"/>
	</div>
<div class="form-light-holder">
	<h1>Body Id</h1>
	<input type="text" name="body_id" class="field">
</div>

</div>
<div class="form-white-holder" style="padding-bottom:20px;">
	<input type="hidden" value="<?='view/'.$this->uri->segment(4);?>" name="redirect" id="redirect" class="hidden_cb" />
	<input type="button" name="update" value="Save" class="btn-save saveProgramButton" style="float:left;" />
</div>
</form>



		</div>
		</div>
		</div>
	</div>
	</div>

<br style="clear:both"		 />

<input type="hidden" class="totalAddMoreFeatures" value="1"  />
<input type="hidden" class="totalAddMoreStandAlonePage" value="1"  />
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
	

$('.btn-save').click(function(){
	
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
						
				$('#AddMoreStandAlonePage').append('<div class="standPages"><div class="form-light-holder"><h1>#'+b+' Title </h1><textarea type="text" value="" name="data['+b+'][title]" id="'+ckeditor_id+'" class="field" placeholder="Enter your name here" /></textarea></div><div class="form-light-holder" style="padding-bottom:30px;"><h1>#'+b+' Description </h1><textarea name="data['+b+'][desc]" class="ckeditor" id="'+full_ckeditor_id+'"></textarea></div><div class="form-light-holder" style="overflow:auto;"><h1 style="padding-bottom: 5px;">#'+b+' Image </h1><div><input type="file" name="stand_page_photo'+b+'" id="" accept="image/*" /><div></div></div></div><div class="form-light-holder"><h1>Background Color</h1><input type="hidden" name="data['+b+'][background_color]"  class="colourTextValue myNewColor_'+b+'" placeholder="Background Color"  readonly="readonly" /><input id="cpFocus" class="coloPick"    /><div id="cpDiv" style="display:none"></div>');
				
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

$("#benefits_2_colorpicker_opacity").spectrum({
   color: '',
   
}); 

$("#benefits_3_colorpicker_opacity").spectrum({
   color: '',
   
}); 

$('.btn-save').click(function(){
	var bg_color = $('#docs-header').find('.sp-preview-inner').css("background-color");
	var bg_color_action = $('#docs-action').find('.sp-preview-inner').css("background-color");
	var bg_color_benefits = $('#docs-benefits').find('.sp-preview-inner').css("background-color");
	var bg_color_video = $('#docs-video').find('.sp-preview-inner').css("background-color");
	var bg_color_headling = $('#docs-headling').find('.sp-preview-inner').css("background-color");
	var bg_color_statistics = $('#docs-statistics').find('.sp-preview-inner').css("background-color");
	var bg_color_benefits_2 = $('#docs-benefits_2').find('.sp-preview-inner').css("background-color");
	var bg_color_benefits_3 = $('#docs-benefits_3').find('.sp-preview-inner').css("background-color");
	
	
	//alert(bg_color); return false; //benefits_2
	$('.colourTextValue').val(bg_color);
	$('.colourTextValueAction').val(bg_color_action);
	$('.colourTextValueBenefits').val(bg_color_benefits);
	$('.colourTextValueVideo').val(bg_color_video);
	$('.colourTextValueHeadling').val(bg_color_headling);
	$('.colourTextValueStatistics').val(bg_color_statistics);
	$('.colourTextValueBenefits_2').val(bg_color_benefits_2);
	$('.colourTextValueBenefits_3').val(bg_color_benefits_3);
});
	
});
</script>

<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>
