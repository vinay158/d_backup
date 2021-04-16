<?php $this->load->view("admin/include/header"); ?>

<style>
	.display-none {display:none !important}
</style>
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
	});
</script>
<script>
	$(window).load(function(){
		
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
			
			
		//var stang_page = $('.standPages').length;
		for(var i = 1; i <= $('.standPages').length; i++) {
			var exit_stand_page_name = 'ckeditor_mini_stand_page_name'+i;
			CKEDITOR.replace( exit_stand_page_name,
									{  customConfig : 'config.js' }
						);
						
			/*CKEDITOR.replace( exit_stand_page_desc,
									{  customConfig : 'config.js' }
						);*/
		}


	});
	
	
$(document).ready(function(){
	
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

 $(".deleteOtherImages").click(function(){
		$(this).parents('.form-light-holder').find('img').hide();
		$(this).parents('.form-light-holder').find('.old_image_value').val('');
		
		var program_id=$(this).attr('number');
		var field_name=$(this).attr('field_name');
			
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



})
</script>

<div class="gen-holder">
	<div class="gen-panel-holder"  style="width: 100% !important;">
	<div class="gen-panel">
		<div class="panel-title">
			<div class="panel-title-name">Edit Program</div>
		</div>
		<div class="panel-body">
		<div class="panel-body-holder">
		<div class="form-holder">

<?php 
	$display_class = '';
	if($user_level != 1){
		$display_class = 'display_class';
	}

?>


<form id="blog_form" class="programForm" action="" method="post" enctype="multipart/form-data">
<?php if(!empty($details)): ?>
<?php foreach($details as $details): ?>

<div class="form-light-holder">
<h1>Override Logo</h1>
	<select name="override_logo" id="window" class="field">
	<?php foreach($override_logos as  $override_logo):?>
	<option value="<?=$override_logo->s_no?>" <?php if($details->override_logo == $override_logo->s_no){ echo 'selected=selected';} ?>><?=$override_logo->logo_name?></option>
	<?php endforeach;?>
	</select>
</div>


<div class="form-light-holder">
	<div class="adsUrl">
		<h1>Program Name</h1>
		<input type="text" value="<?=$details->program?>" name="name" id="name" class="field" placeholder="Enter your name here" />
	</div>
	<div class="linkTarget">
		<h1>Button Name</h1>
	<input type="text" value="<?=$details->buttonName?>" name="btnname" id="btnname" class="field" placeholder="Enter your button name here"/>
	</div>
	
</div>
<div class="form-light-holder">
	<h1>Slug</h1>
	<input type="text" value="<?=$details->program_slug;?>" name="slug" id="slug" class="field" placeholder="Enter your slug here"/>
</div>

<div class="form-light-holder" style="padding-bottom:30px;">
	<div class="adsUrl">
		<h1>Category</h1>
		<select name="category" id="category" style="width: 70%; background:#FFF; border: none; border-radius: 5px; padding: 5px" >
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
	<div class="linkTarget display-none">
		<h1>Ages</h1>
		<input type="text" value="<?=$details->ages?>" name="ages" id="" class="field" placeholder="Enter Ages here" />
	</div>
	
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
        	&#10687;<input type="text"  name="features[<?= $i ?>]" id="features" value="<?= $feature; ?>" class="field"  placeholder="Enter Features here"/><br>
			<?php $i++; } } else { ?>
			&#10687;<input type="text"  name="features[1]" id="features" value="" class="field"  placeholder="Enter Features here"/><br>
			<?php } ?>
		</div>
    </div>
	
	
	
<div class="form-light-holder display-none" style="padding-bottom:30px;">
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
			echo "<a href='javascript:void(0);' id='delete_img'>Delete image</a>";
			}
	?>	
		<div>
		</div>
</div>

<!--------------------->
<h1 style="padding-bottom: 5px;"><b>Header Section:-</b></h1>
<div class="form-light-holder">
	<h1>Header</h1>
	<textarea type="text" id="ckeditor_mini_header_title" name="header_title" class="field ckeditor" style="width:98%"><?=$details->header_title;?></textarea>
</div>

<div class="form-light-holder">
	<h1>Header Description</h1>
			<div class="shorterCkeditor"><textarea name="header_desc"  id="ckeditor_mini_header_desc" class="text ckeditor shorterCkeditor"><?=$details->header_desc;?></textarea></div>
</div>
<div class="form-light-holder" style="overflow:auto;">
			<h1 style="padding-bottom: 5px;">Header image</h1>
			<?php if(!empty($details->header_image)): ?>
			<div><img id="header_img" src="upload/programs/<?=$details->header_image;?>" style="width: 100px; clear:both;" /></div>
			<input type="hidden" id="last_header_image" name="last_header_image" value="<?=$details->header_image;?>" />
			<?php endif;?>
			<input type="file" name="header_image" id="header_photo" accept="image/*" />
			<?php if($details->header_image){ 
					echo "<a href='javascript:void(0);' id='delete_header_img'>Delete image</a>";
					}
			?>	
		<div>
		</div>
</div>
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Background Image</h1>
	<?php if(!empty($details->background_image)): ?>
	<div><img id='img_bg' src="<?=base_url().'upload/programs/'.$details->background_image;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-background_image" class="old_image_value" value="<?=$details->background_image;?>" />
	<?php endif;?>
	<input type="file" name="background_image" id="photo_left" accept="image/*" />
	<?php if(!empty($details->background_image)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages' field_name='background_image'  number='".$details->id."'>Delete image</a>";
			}
	?>	
		<div>
		</div>
</div>

<div class="form-light-holder">
	<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs-header'>
    <div id='docs-content-header'>
		<input id="full_colorpicker_opacity" name="background_color" class="colourTextValue" value="<?php if(!empty($details)){ echo $details->background_color; }?>" />
    </div>
	
 </div>
</div>	



<h1 style="padding-bottom: 5px;"><b>White Stripe Under Header Section:-</b></h1>
<div class="form-light-holder">
	<h1>Body Title</h1>
	<textarea type="text" name="body_title" id="ckeditor_mini_body_title1" class="field ckeditor" style="width:98%"><?=$details->body_title;?></textarea>
</div>
<div class="form-light-holder">
	<h1>Body Description</h1>
	<textarea name="body_desc" id="ckeditor_full_body_desc1" class="text ckeditor" style="width:50%"><?=$details->body_desc;?></textarea>
	
</div>

<div class="form-light-holder">
	<h1>Image Position</h1>
	<select name="body_img_position" class="field">
		<option value="left" <?php echo (!empty($details) && $details->body_img_position == "left") ? 'selected=selected' : ''; ?>>Left</option>
		<option value="right"  <?php echo (!empty($details) && $details->body_img_position == "right") ? 'selected=selected' : ''; ?>>Right</option>
	</select>
	
</div>

<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Body Image</h1>
	<?php if(!empty($details->body_image)): ?>
	<div><img id='img_body_image' src="<?=base_url().'upload/programs/'.$details->body_image;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-body_image" class="old_image_value" value="<?=$details->body_image;?>" />
	<?php endif;?>
	<input type="file" name="body_image" id="body_image" accept="image/*" />
	<?php if(!empty($details->body_image)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages' field_name='body_image'  number='".$details->id."'>Delete image</a>";
			}
	?>	
		<div>
		</div>
</div>
<div class="form-light-holder">
	<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs-white_stripe'>
    <div id='docs-content-white_stripe'>
		<input id="white_stripe_colorpicker_opacity" name="white_stripe_background_color" class="colourTextValueWhiteStripe" value="<?php if(!empty($details)){ echo $details->white_stripe_background_color; }?>" />
    </div>
	
 </div>
</div>



<h1 style="padding-bottom: 5px;"><b>Benefits with 3 images Section:-</b></h1>
<div class="form-light-holder">
	<h1>Benefits Title</h1>
	<input type="text" name="benefits_title" value="<?=$details->benefits_title;?>" class="field" style="width:98%">
</div>

<div class="form-light-holder">
	<h1>Benefits description</h1>
	<div class="shorterCkeditor"><textarea name="benefits_desc" id="ckeditor_mini_benefits_desc" class="text ckeditor"><?=$details->benefits_desc;?></textarea></div>
</div>

	
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Background Image</h1>
	<?php if(!empty($details->benefits_background_image)): ?>
	<div><img id='img_bg_action' src="<?=base_url().'upload/programs/'.$details->benefits_background_image;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-benefits_background_image"  class="old_image_value"  value="<?=$details->benefits_background_image;?>" />
	<?php endif;?>
	<input type="file" name="benefits_background_image" id="photo_left" accept="image/*" />
	<?php if(!empty($details->benefits_background_image)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages' field_name='benefits_background_image'  number='".$details->id."'>Delete image</a>";
			}
	?>	
		<div>
		</div>
</div>

<div class="form-light-holder">
	<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs-benefits'>
    <div id='docs-content-benefits'>
		<input id="benefits_colorpicker_opacity" name="benefits_background_color" class="colourTextValueBenefits" value="<?php if(!empty($details)){ echo $details->benefits_background_color; }?>" />
    </div>
	
 </div>
</div>

<div class="form-light-holder">
	<h1>Headline #1</h1>
	<input type="text" name="benefits_headline_1" value="<?=$details->benefits_headline_1;?>" class="field" style="width:98%">
</div>
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Image uploader #1</h1>
	<?php if(!empty($details->benefits_image_1)): ?>
	<div><img id='img_bg_action_image_1' src="<?=base_url().'upload/programs/'.$details->benefits_image_1;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-benefits_image_1" class="old_image_value"  value="<?=$details->benefits_image_1;?>" />
	<?php endif;?>
	<input type="file" name="benefits_image_1" id="benefits_image_1" accept="image/*" />
	<?php if(!empty($details->benefits_image_1)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages' field_name='benefits_image_1'  number='".$details->id."'>Delete image</a>";
			}
	?>	
		<div>
		</div>
</div>


<div class="form-light-holder">
	<h1>Headline #2</h1>
	<input type="text" name="benefits_headline_2" value="<?=$details->benefits_headline_2;?>" class="field" style="width:98%">
</div>
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Image uploader #2</h1>
	<?php if(!empty($details->benefits_image_2)): ?>
	<div><img id='img_bg_action_image_2' src="<?=base_url().'upload/programs/'.$details->benefits_image_2;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-benefits_image_2"  class="old_image_value"  value="<?=$details->benefits_image_2;?>" />
	<?php endif;?>
	<input type="file" name="benefits_image_2" id="benefits_image_2" accept="image/*" />
	<?php if(!empty($details->benefits_image_2)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages' field_name='benefits_image_2'  number='".$details->id."'>Delete image</a>";
			}
	?>	
		<div>
		</div>
</div>

<div class="form-light-holder">
	<h1>Headline #3</h1>
	<input type="text" name="benefits_headline_3" value="<?=$details->benefits_headline_3;?>" class="field" style="width:98%">
</div>
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Image uploader #3</h1>
	<?php if(!empty($details->benefits_image_3)): ?>
	<div><img id='img_bg_action_image_3' src="<?=base_url().'upload/programs/'.$details->benefits_image_3;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-benefits_image_3"  class="old_image_value"  value="<?=$details->benefits_image_3;?>" />
	<?php endif;?>
	<input type="file" name="benefits_image_3" id="benefits_image_3" accept="image/*" />
	<?php if(!empty($details->benefits_image_3)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages' field_name='benefits_image_3'  number='".$details->id."'>Delete image</a>";
			}
	?>	
		<div>
		</div>
</div>


	<h1 style="padding-bottom: 5px;"><b>Video Row:-</b></h1>
	
	<div class="form-light-holder">
	<div class="adsUrl">
		<h1>Video Type</h1>
		<select name="video_type" id="" class="field videoType" >
		<option value="youtube_video" <?php if($details->video_type == 'youtube_video'){ echo 'selected=selected'; } ?>>Youtube Video</option>
		<option value="vimeo_video" <?php if($details->video_type == 'vimeo_video'){ echo 'selected=selected'; } ?>  >Vimeo Video</option>
	</select>
	
	</div>
	<div class="linkTarget">
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




<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Background Image</h1>
	<?php if(!empty($details->video_background_image)): ?>
	<div><img id='img_bg_action' src="<?=base_url().'upload/programs/'.$details->video_background_image;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-video_background_image"  class="old_image_value"  value="<?=$details->video_background_image;?>" />
	<?php endif;?>
	<input type="file" name="video_background_image" id="photo_left" accept="image/*" />
	<?php if(!empty($details->video_background_image)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages' field_name='video_background_image'  number='".$details->id."'>Delete image</a>";
			}
	?>	
		<div>
		</div>
</div>

<div class="form-light-holder">
	<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs-video'>
    <div id='docs-content-video'>
		<input id="video_colorpicker_opacity" name="video_background_color" class="colourTextValueVideo" value="<?php if(!empty($details)){ echo $details->video_background_color; }?>" />
    </div>
	
 </div>
</div>



<h1 style="padding-bottom: 5px;"><b>Call to Action with 3 Images Section:-</b></h1>
<div class="form-light-holder">
	<h1>Call to Action Title</h1>
	<input type="text" name="action_title" value="<?=$details->action_title;?>" class="field" style="width:98%">
</div>

<div class="form-light-holder">
	<h1>Call to Action description</h1>
	<div class="shorterCkeditor"><textarea name="action_desc" id="ckeditor_mini_action_desc" class="text ckeditor"><?=$details->action_desc;?></textarea></div>
</div>

	
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Background Image</h1>
	<?php if(!empty($details->action_background_image)): ?>
	<div><img id='img_bg_action' src="<?=base_url().'upload/programs/'.$details->action_background_image;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-action_background_image"  class="old_image_value"  value="<?=$details->action_background_image;?>" />
	<?php endif;?>
	<input type="file" name="action_background_image" id="photo_left" accept="image/*" />
	<?php if(!empty($details->action_background_image)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages' field_name='action_background_image'  number='".$details->id."'>Delete image</a>";
			}
	?>	
		<div>
		</div>
</div>

<div class="form-light-holder">
	<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs-action'>
    <div id='docs-content-action'>
		<input id="action_colorpicker_opacity" name="action_background_color" class="colourTextValueAction" value="<?php if(!empty($details)){ echo $details->action_background_color; }?>" />
    </div>
	
 </div>
</div>

<div class="form-light-holder">
	<h1>Title #1</h1>
	<input type="text" name="action_headline_1" value="<?=$details->action_headline_1;?>" class="field" style="width:98%">
</div>
<div class="form-light-holder">
	<h1>Description #1</h1>
	<input type="text" name="action_desc_1" value="<?=$details->action_desc_1;?>" class="field" style="width:98%">
</div>
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Image uploader #1</h1>
	<?php if(!empty($details->action_image_1)): ?>
	<div><img id='img_bg_action_image_1' src="<?=base_url().'upload/programs/'.$details->action_image_1;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-action_image_1"   class="old_image_value"  value="<?=$details->action_image_1;?>" />
	<?php endif;?>
	<input type="file" name="action_image_1" id="action_image_1" accept="image/*" />
	<?php if(!empty($details->action_image_1)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages' field_name='action_image_1'  number='".$details->id."'>Delete image</a>";
			}
	?>	
		<div>
		</div>
</div>


<div class="form-light-holder">
	<h1>Title #2</h1>
	<input type="text" name="action_headline_2" value="<?=$details->action_headline_2;?>" class="field" style="width:98%">
</div>
<div class="form-light-holder">
	<h1>Description #2</h1>
	<input type="text" name="action_desc_2" value="<?=$details->action_desc_2;?>" class="field" style="width:98%">
</div>
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Image uploader #2</h1>
	<?php if(!empty($details->action_image_2)): ?>
	<div><img id='img_bg_action_image_2' src="<?=base_url().'upload/programs/'.$details->action_image_2;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-action_image_2"   class="old_image_value" value="<?=$details->action_image_2;?>" />
	<?php endif;?>
	<input type="file" name="action_image_2" id="action_image_2" accept="image/*" />
	<?php if(!empty($details->action_image_2)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages' field_name='action_image_2'  number='".$details->id."'>Delete image</a>";
			}
	?>	
		<div>
		</div>
</div>

<div class="form-light-holder">
	<h1>Title #3</h1>
	<input type="text" name="action_headline_3" value="<?=$details->action_headline_3;?>" class="field" style="width:98%">
</div>
<div class="form-light-holder">
	<h1>Description #3</h1>
	<input type="text" name="action_desc_3" value="<?=$details->action_desc_3;?>" class="field" style="width:98%">
</div>
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Image uploader #3</h1>
	<?php if(!empty($details->action_image_3)): ?>
	<div><img id='img_bg_action_image_3' src="<?=base_url().'upload/programs/'.$details->action_image_3;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-action_image_3"  class="old_image_value"  value="<?=$details->action_image_3;?>" />
	<?php endif;?>
	<input type="file" name="action_image_3" id="action_image_3" accept="image/*" />
	<?php if(!empty($details->action_image_3)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages' field_name='action_image_3'  number='".$details->id."'>Delete image</a>";
			}
	?>	
		<div>
		</div>
</div>




<h1 style="padding-bottom: 5px;"><b>Headling with 3 boxes Section:-</b></h1>
<div class="form-light-holder">
	<h1>Headling  Title</h1>
	<input type="text" name="headling_title" value="<?=$details->headling_title;?>" class="field" style="width:98%">
</div>

<div class="form-light-holder">
	<h1>Headling description</h1>
	<div class="shorterCkeditor"><textarea name="headling_desc" id="ckeditor_mini_headling_desc" class="text ckeditor"><?=$details->headling_desc;?></textarea></div>
</div>

	
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Background Image</h1>
	<?php if(!empty($details->headling_background_image)): ?>
	<div><img id='img_bg_action' src="<?=base_url().'upload/programs/'.$details->headling_background_image;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-headling_background_image"   class="old_image_value"  value="<?=$details->headling_background_image;?>" />
	<?php endif;?>
	<input type="file" name="headling_background_image" id="photo_left" accept="image/*" />
	<?php if(!empty($details->headling_background_image)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages' field_name='headling_background_image'  number='".$details->id."'>Delete image</a>";
			}
	?>	
		<div>
		</div>
</div>

<div class="form-light-holder">
	<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs-headling'>
    <div id='docs-content-headling'>
		<input id="headling_colorpicker_opacity" name="headling_background_color" class="colourTextValueHeadling" value="<?php if(!empty($details)){ echo $details->headling_background_color; }?>" />
    </div>
	
 </div>
</div>

<div class="form-light-holder">
	<h1>Headline #1</h1>
	<input type="text" name="headling_headline_1" value="<?=$details->headling_headline_1;?>" class="field" style="width:98%">
</div>



<div class="form-light-holder">
	<h1>Headline #2</h1>
	<input type="text" name="headling_headline_2" value="<?=$details->headling_headline_2;?>" class="field" style="width:98%">
</div>


<div class="form-light-holder">
	<h1>Headline #3</h1>
	<input type="text" name="headling_headline_3" value="<?=$details->headling_headline_3;?>" class="field" style="width:98%">
</div>




<h1 style="padding-bottom: 5px;"><b>Statistics with 3 images Section:-</b></h1>
<div class="form-light-holder">
	<h1>Statistics Title</h1>
	<input type="text" name="statistics_title" value="<?=$details->statistics_title;?>" class="field" style="width:98%">
</div>

<div class="form-light-holder">
	<h1>Statistics description</h1>
	<div class="shorterCkeditor"><textarea name="statistics_desc" id="ckeditor_mini_statistics_desc" class="text ckeditor"><?=$details->statistics_desc;?></textarea></div>
</div>

	
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Background Image</h1>
	<?php if(!empty($details->statistics_background_image)): ?>
	<div><img id='img_bg_action' src="<?=base_url().'upload/programs/'.$details->statistics_background_image;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-statistics_background_image"   class="old_image_value"  value="<?=$details->statistics_background_image;?>" />
	<?php endif;?>
	<input type="file" name="statistics_background_image" id="photo_left" accept="image/*" />
	<?php if(!empty($details->statistics_background_image)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages' field_name='statistics_background_image'  number='".$details->id."'>Delete image</a>";
			}
	?>	
		<div>
		</div>
</div>

<div class="form-light-holder">
	<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs-statistics'>
    <div id='docs-content-statistics'>
		<input id="statistics_colorpicker_opacity" name="statistics_background_color" class="colourTextValueStatistics" value="<?php if(!empty($details)){ echo $details->statistics_background_color; }?>" />
    </div>
	
 </div>
</div>

<div class="form-light-holder">
	<h1>Title #1</h1>
	<input type="text" name="statistics_headline_1" value="<?=$details->statistics_headline_1;?>" class="field" style="width:98%">
</div>
<div class="form-light-holder">
	<h1>Description #1</h1>
	<input type="text" name="statistics_desc_1" value="<?=$details->statistics_desc_1;?>" class="field" style="width:98%">
</div>
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Image uploader #1</h1>
	<?php if(!empty($details->statistics_image_1)): ?>
	<div><img id='img_bg_statistics_image_1' src="<?=base_url().'upload/programs/'.$details->statistics_image_1;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-statistics_image_1"  class="old_image_value"  value="<?=$details->statistics_image_1;?>" />
	<?php endif;?>
	<input type="file" name="statistics_image_1" id="statistics_image_1" accept="image/*" />
	<?php if(!empty($details->statistics_image_1)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages' field_name='statistics_image_1'  number='".$details->id."'>Delete image</a>";
			}
	?>	
		<div>
		</div>
</div>


<div class="form-light-holder">
	<h1>Title #2</h1>
	<input type="text" name="statistics_headline_2" value="<?=$details->statistics_headline_2;?>" class="field" style="width:98%">
</div>
<div class="form-light-holder">
	<h1>Description #2</h1>
	<input type="text" name="statistics_desc_2" value="<?=$details->statistics_desc_2;?>" class="field" style="width:98%">
</div>
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Image uploader #2</h1>
	<?php if(!empty($details->statistics_image_2)): ?>
	<div><img id='img_bg_statistics_image_2' src="<?=base_url().'upload/programs/'.$details->statistics_image_2;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-statistics_image_2"  class="old_image_value"  value="<?=$details->statistics_image_2;?>" />
	<?php endif;?>
	<input type="file" name="statistics_image_2" id="statistics_image_2" accept="image/*" />
	<?php if(!empty($details->statistics_image_2)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages' field_name='statistics_image_2'  number='".$details->id."'>Delete image</a>";
			}
	?>	
		<div>
		</div>
</div>

<div class="form-light-holder">
	<h1>Title #3</h1>
	<input type="text" name="statistics_headline_3" value="<?=$details->statistics_headline_3;?>" class="field" style="width:98%">
</div>
<div class="form-light-holder">
	<h1>Description #3</h1>
	<input type="text" name="statistics_desc_3" value="<?=$details->statistics_desc_3;?>" class="field" style="width:98%">
</div>
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Image uploader #3</h1>
	<?php if(!empty($details->statistics_image_3)): ?>
	<div><img id='img_bg_action_image_3' src="<?=base_url().'upload/programs/'.$details->statistics_image_3;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-statistics_image_3" class="old_image_value"  value="<?=$details->statistics_image_3;?>" />
	<?php endif;?>
	<input type="file" name="statistics_image_3" id="statistics_image_3" accept="image/*" />
	<?php if(!empty($details->statistics_image_3)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages' field_name='statistics_image_3'  number='".$details->id."'>Delete image</a>";
			}
	?>	
		<div>
		</div>
</div>





<h1 style="padding-bottom: 5px;"><b>Benefits Row2 with 3 Images Section:-</b></h1>
<div class="form-light-holder">
	<h1>Benefits Row2 Title</h1>
	<input type="text" name="benefits_2_title" value="<?=$details->benefits_2_title;?>" class="field" style="width:98%">
</div>

<div class="form-light-holder">
	<h1>Benefits Row2 description</h1>
	<div class="shorterCkeditor"><textarea name="benefits_2_desc" id="ckeditor_mini_benefits_2_desc" class="text ckeditor"><?=$details->benefits_2_desc;?></textarea></div>
</div>

	
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Background Image</h1>
	<?php if(!empty($details->benefits_2_background_image)): ?>
	<div><img id='img_bg_action' src="<?=base_url().'upload/programs/'.$details->benefits_2_background_image;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-benefits_2_background_image" class="old_image_value"  value="<?=$details->benefits_2_background_image;?>" />
	<?php endif;?>
	<input type="file" name="benefits_2_background_image" id="photo_left" accept="image/*" />
	<?php if(!empty($details->benefits_2_background_image)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages' field_name='benefits_2_background_image'  number='".$details->id."'>Delete image</a>";
			}
	?>	
		<div>
		</div>
</div>

<div class="form-light-holder">
	<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs-benefits_2'>
    <div id='docs-content-benefits_2'>
		<input id="benefits_2_colorpicker_opacity" name="benefits_2_background_color" class="colourTextValueBenefits_2" value="<?php if(!empty($details)){ echo $details->benefits_2_background_color; }?>" />
    </div>
	
 </div>
</div>

<div class="form-light-holder">
	<h1>Title #1</h1>
	<input type="text" name="benefits_2_headline_1" value="<?=$details->benefits_2_headline_1;?>" class="field" style="width:98%">
</div>
<div class="form-light-holder">
	<h1>Description #1</h1>
	<input type="text" name="benefits_2_desc_1" value="<?=$details->benefits_2_desc_1;?>" class="field" style="width:98%">
</div>
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Image uploader #1</h1>
	<?php if(!empty($details->benefits_2_image_1)): ?>
	<div><img id='img_bg_benefits_2_image_1' src="<?=base_url().'upload/programs/'.$details->benefits_2_image_1;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-benefits_2_image_1" class="old_image_value"  value="<?=$details->benefits_2_image_1;?>" />
	<?php endif;?>
	<input type="file" name="benefits_2_image_1" id="benefits_2_image_1" accept="image/*" />
	<?php if(!empty($details->benefits_2_image_1)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages' field_name='benefits_2_image_1'  number='".$details->id."'>Delete image</a>";
			}
	?>	
		<div>
		</div>
</div>


<div class="form-light-holder">
	<h1>Title #2</h1>
	<input type="text" name="benefits_2_headline_2" value="<?=$details->benefits_2_headline_2;?>" class="field" style="width:98%">
</div>
<div class="form-light-holder">
	<h1>Description #2</h1>
	<input type="text" name="benefits_2_desc_2" value="<?=$details->benefits_2_desc_2;?>" class="field" style="width:98%">
</div>
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Image uploader #2</h1>
	<?php if(!empty($details->benefits_2_image_2)): ?>
	<div><img id='img_bg_statistics_image_2' src="<?=base_url().'upload/programs/'.$details->benefits_2_image_2;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-benefits_2_image_2"  class="old_image_value" value="<?=$details->benefits_2_image_2;?>" />
	<?php endif;?>
	<input type="file" name="benefits_2_image_2" id="benefits_2_image_2" accept="image/*" />
	<?php if(!empty($details->benefits_2_image_2)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages' field_name='benefits_2_image_2'  number='".$details->id."'>Delete image</a>";
			}
	?>	
		<div>
		</div>
</div>

<div class="form-light-holder">
	<h1>Title #3</h1>
	<input type="text" name="benefits_2_headline_3" value="<?=$details->benefits_2_headline_3;?>" class="field" style="width:98%">
</div>
<div class="form-light-holder">
	<h1>Description #3</h1>
	<input type="text" name="benefits_2_desc_3" value="<?=$details->benefits_2_desc_3;?>" class="field" style="width:98%">
</div>
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Image uploader #3</h1>
	<?php if(!empty($details->benefits_2_image_3)): ?>
	<div><img id='img_bg_action_image_3' src="<?=base_url().'upload/programs/'.$details->benefits_2_image_3;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-benefits_2_image_3" class="old_image_value"  value="<?=$details->benefits_2_image_3;?>" />
	<?php endif;?>
	<input type="file" name="benefits_2_image_3" id="benefits_2_image_3" accept="image/*" />
	<?php if(!empty($details->benefits_2_image_3)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages' field_name='benefits_2_image_3'  number='".$details->id."'>Delete image</a>";
			}
	?>	
		<div>
		</div>
</div>




<h1 style="padding-bottom: 5px;"><b>White Stripe Row 2 Section:-</b></h1>
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

<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Image</h1>
	<?php if(!empty($details->white_stripe2_image)): ?>
	<div><img id='img_white_stripe2_image' src="<?=base_url().'upload/programs/'.$details->white_stripe2_image;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-white_stripe2_image" class="old_image_value" value="<?=$details->body_image;?>" />
	<?php endif;?>
	<input type="file" name="white_stripe2_image" id="white_stripe2_image" accept="image/*" />
	<?php if(!empty($details->white_stripe2_image)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages' field_name='white_stripe2_image'  number='".$details->id."'>Delete image</a>";
			}
	?>	
		<div>
		</div>
</div>



<h1 style="padding-bottom: 5px;"><b>Benefits Row3 with 3 Images Section:-</b></h1>
<div class="form-light-holder">
	<h1>Benefits Row3 Title</h1>
	<input type="text" name="benefits_3_title" value="<?=$details->benefits_3_title;?>" class="field" style="width:98%">
</div>

<div class="form-light-holder">
	<h1>Benefits Row3 description</h1>
	<div class="shorterCkeditor"><textarea name="benefits_3_desc" id="ckeditor_mini_benefits_3_desc" class="text ckeditor"><?=$details->benefits_3_desc;?></textarea></div>
</div>

	
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Background Image</h1>
	<?php if(!empty($details->benefits_3_background_image)): ?>
	<div><img id='img_bg_action' src="<?=base_url().'upload/programs/'.$details->benefits_3_background_image;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-benefits_3_background_image" class="old_image_value"  value="<?=$details->benefits_3_background_image;?>" />
	<?php endif;?>
	<input type="file" name="benefits_3_background_image" id="photo_left" accept="image/*" />
	<?php if(!empty($details->benefits_3_background_image)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages' field_name='benefits_3_background_image'  number='".$details->id."'>Delete image</a>";
			}
	?>	
		<div>
		</div>
</div>

<div class="form-light-holder">
	<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs-benefits_3'>
    <div id='docs-content-benefits_3'>
		<input id="benefits_3_colorpicker_opacity" name="benefits_3_background_color" class="colourTextValuebenefits_3" value="<?php if(!empty($details)){ echo $details->benefits_3_background_color; }?>" />
    </div>
	
 </div>
</div>

<div class="form-light-holder">
	<h1>Title #1</h1>
	<input type="text" name="benefits_3_headline_1" value="<?=$details->benefits_3_headline_1;?>" class="field" style="width:98%">
</div>

<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Image uploader #1</h1>
	<?php if(!empty($details->benefits_3_image_1)): ?>
	<div><img id='img_bg_benefits_3_image_1' src="<?=base_url().'upload/programs/'.$details->benefits_3_image_1;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-benefits_3_image_1" class="old_image_value"  value="<?=$details->benefits_3_image_1;?>" />
	<?php endif;?>
	<input type="file" name="benefits_3_image_1" id="benefits_3_image_1" accept="image/*" />
	<?php if(!empty($details->benefits_3_image_1)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages' field_name='benefits_3_image_1'  number='".$details->id."'>Delete image</a>";
			}
	?>	
		<div>
		</div>
</div>


<div class="form-light-holder">
	<h1>Title #2</h1>
	<input type="text" name="benefits_3_headline_2" value="<?=$details->benefits_3_headline_2;?>" class="field" style="width:98%">
</div>

<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Image uploader #2</h1>
	<?php if(!empty($details->benefits_3_image_2)): ?>
	<div><img id='img_bg_statistics_image_2' src="<?=base_url().'upload/programs/'.$details->benefits_3_image_2;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-benefits_3_image_2"  class="old_image_value" value="<?=$details->benefits_3_image_2;?>" />
	<?php endif;?>
	<input type="file" name="benefits_3_image_2" id="benefits_3_image_2" accept="image/*" />
	<?php if(!empty($details->benefits_3_image_2)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages' field_name='benefits_3_image_2'  number='".$details->id."'>Delete image</a>";
			}
	?>	
		<div>
		</div>
</div>

<div class="form-light-holder">
	<h1>Title #3</h1>
	<input type="text" name="benefits_3_headline_3" value="<?=$details->benefits_3_headline_3;?>" class="field" style="width:98%">
</div>
<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;">Image uploader #3</h1>
	<?php if(!empty($details->benefits_3_image_3)): ?>
	<div><img id='img_bg_action_image_3' src="<?=base_url().'upload/programs/'.$details->benefits_3_image_3;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-benefits_3_image_3" class="old_image_value"  value="<?=$details->benefits_3_image_3;?>" />
	<?php endif;?>
	<input type="file" name="benefits_3_image_3" id="benefits_3_image_3" accept="image/*" />
	<?php if(!empty($details->benefits_3_image_3)){ 
			echo "<a href='javascript:void(0);'  class='deleteOtherImages' field_name='benefits_3_image_3'  number='".$details->id."'>Delete image</a>";
			}
	?>	
		<div>
		</div>
</div>





<h1><b>Email Opt-in #1</b></h1>

<div class="form-light-holder">

	<h1>Opt-In Text</h1>
	<input type="text" value="<?php echo (!empty($details) && !empty($details->opt1_text)) ? $details->opt1_text : ''; ?>" name="opt1_text" id="" class="field" placeholder=""  style="width: 98%"/>
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
<br/>
<h1><b>Email Opt-in #2</b></h1>

<div class="form-light-holder">

	<h1>Opt-In Title</h1>
	<input type="text" value="<?php echo (!empty($details) && !empty($details->opt1_text)) ? $details->opt_2_title : ''; ?>" name="opt_2_title" id="" class="field" placeholder=""  style="width: 98%"/>
</div>

<div class="form-light-holder">

	<h1>Opt-In Text</h1>
	<input type="text" value="<?php echo (!empty($details) && !empty($details->opt1_text)) ? $details->opt_2_text : ''; ?>" name="opt_2_text" id="" class="field" placeholder=""  style="width: 98%"/>
</div>

<div class="form-light-holder form2checkbox">

	<a id="published" class="checkbox2 <?php echo (!empty($details) && $details->show_full_form_2 == 1) ? 'check-on' : 'check-off'; ?>"></a>

	<h1 class="inline">Show Full Form </h1>

	<input type="hidden" value="<?php echo (!empty($details) && $details->show_full_form_2 == 1) ? 1 : 0; ?>" name="show_full_form_2" class="hidden_cb2" />

</div>



	

	

	
<h1 style="padding-bottom: 5px;"> &nbsp; </h1>

		
	
<script language="javascript">
$(window).load(function(){
	if($('.hidden_cb3').val() == 0){
		$('.checkbox_landing_page').addClass("check-off");
		$('.checkbox_landing_page').removeClass("check-on");
		$('.checkbx1').val('0');
		$('#landing_page_box').hide();
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
	}

	else

	{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form3checkbox").children(".hidden_cb3").val("1");
	}

})

})

</script>
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
	<h1>Select Program</h1>
		<select name="landing_program"  id="" class="field landing_program" >
			<option value="">-Select Program-</option>
			<?php foreach($stand_programs as $stand_program){
					$cateogry_detail = $this->query_model->getbySpecific('tblcategory','cat_id', $stand_program[0]->category);
					if($stand_program[0]->id != $this->uri->segment(4)){
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
				<option  number="<?php echo $stand_program[0]->id ?>" value="<?php echo $program_url; ?>" <?php if($details->landing_program_id == $stand_program[0]->id){ echo 'selected=selected';} ?>><?= $stand_program[0]->program ?></option>
			<?php } } ?>
		</select>
		<input type="hidden" name="landing_program_id" class="landing_program_id" value="<?php if(!empty($details->landing_program_id)){ echo $details->landing_program_id ; } ?>" />
		<br />
	<span class="orbtn">OR</span>
	
	<h1>Landing Page Url</h1>
		<input type="text" value="<?=$details->landing_page_url?>" name="landing_page_url" class="field landing_page_url" placeholder="Enter Url here" />
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
<div class="form-light-holder">
	<div class="adsUrl">
		<h1>Stand-Alone Program Name</h1>
		<input type="text" value="<?=$details->stand_program_name;?>" name="stand_program_name" class="field" placeholder="Enter Your Stand-Alone Program Name Here"/>
	</div>
	<div class="linkTarget">
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
	<div class="adsUrl">
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
		<div class="linkTarget">
		<h1>Image alt text</h1>
	<input type="text" value="<?php echo $details->image_alt; ?>" name="image_alt" id="image_alt" class="field" placeholder="image alt text"/>
		</div>
		<div>
		</div>
</div>

</div>
<div class="form-light-holder welcome_video">
	<div class="adsUrl">
		<h1>Video Type</h1>
		<select name="video_type" id="" class="field videoType" >
		<option value="youtube_video" <?php if($details->video_type == 'youtube_video'){ echo 'selected=selected'; } ?>>Youtube Video</option>
		<option value="vimeo_video" <?php if($details->video_type == 'vimeo_video'){ echo 'selected=selected'; } ?>  >Vimeo Video</option>
	</select>
	
	</div>
	<div class="linkTarget">
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
				<div class="form-light-holder" style="padding-bottom:30px;">
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
		<div class="form-light-holder" style="padding-bottom:30px;">
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
	<input type="text" name="trial_title" value="<?=$details->trial_title;?>" class="field" style="width:98%">
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

<div class="form-light-holder receive_class_button">
	<a id="published" class="receive_class_button_checkbox <?php if($details->receive_class_button == 1) echo "check-on"; else echo "check-off";?>" ></a>
	<h1 class="inline">receive class schedule & pricing</h1>
	<input type="hidden" value="<?php if(!empty($details)){ echo $details->receive_class_button; } else{ echo 0; }?>" name="receive_class_button" class="receive_class_button_hidden_cb" />
</div>
<div  class="DetailBox">
<div class="form-light-holder">
	
    <div class="adsUrl">
		<h1>Button Text</h1>
		<input type="text" value="<?=$details->receive_button_text?>" name="receive_button_text" id="name" class="field" placeholder="Enter your button text here" />
	</div>
	<div class="linkTarget">
		<h1>Button Link</h1>
	<input type="text" value="<?=$details->receive_button_link?>" name="receive_button_link" id="btnname" class="field" placeholder="Enter your button url here"/>
	</div>
    
</div>

</div>

<div class="form-light-holder">
		<h1>Meta Title</h1>
			<input type="text" value="<?=$details->meta_title?>" name="meta_title" id="meta_title" class="field" placeholder="Meta title" style="width: 98%"/>
	</div>
<div class="form-light-holder <?php echo $display_class; ?>">
	<h1>Body Id</h1>
	<input type="text" name="body_id" value="<?=$details->body_id;?>" class="field">
</div>
<div class="form-white-holder" style="padding-bottom:20px;">
	<input type="hidden" value="<?=$details->id?>" name="program_id" id="program_id" class="hidden_cb" />
	<input type="hidden" value="<?=$this->uri->segment(6)?>" id="category_id" class="" />
	<input type="hidden" name="current_program_id" value="<?= $this->uri->segment(4); ?>" />
	<input type="hidden" value="<?=($this->uri->segment(5) && $this->uri->segment(6))?$this->uri->segment(5).'/'.$this->uri->segment(6):'';?>" name="redirect" id="redirect" class="hidden_cb" />	
	<input type="button"  name="update" value="Save" class="btn-save saveProgramButton" style="float:left;" />
</div>
<?php endforeach;?>
<?php endif;?>
</form>



		</div>
		</div>
		</div>
	</div>
	</div>

<br style="clear:both"		 />

<input type="hidden" class="totalAddMoreFeatures" value="<?php if(count($features) >= 1){ echo count($features); } else { echo 1; } ?>"  />
<input type="hidden" class="totalAddMoreStandAlonePage" value="<?php if(count($stand_pages) >= 1){ echo count($stand_pages); } else { echo 1; } ?>"  />
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

$('.btn-save').click(function(){
	var bg_color = $('#docs-header').find('.sp-preview-inner').css("background-color");
	var bg_color_action = $('#docs-action').find('.sp-preview-inner').css("background-color");
	var bg_color_benefits = $('#docs-benefits').find('.sp-preview-inner').css("background-color");
	var bg_color_video = $('#docs-video').find('.sp-preview-inner').css("background-color");
	var bg_color_headling = $('#docs-headling').find('.sp-preview-inner').css("background-color");
	var bg_color_statistics = $('#docs-statistics').find('.sp-preview-inner').css("background-color");
	var bg_color_benefits_2 = $('#docs-benefits_2').find('.sp-preview-inner').css("background-color");
	var bg_color_benefits_3 = $('#docs-benefits_3').find('.sp-preview-inner').css("background-color");
	var bg_white_stripe = $('#docs-white_stripe').find('.sp-preview-inner').css("background-color");
	
	
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
$.ajax({
url: "admin/"+mod_type1+"/sortProgramFullWidthRows/<?=$details->id;?>",
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
$(".cat_sort_2").sortable({
update : function () {
serial = $('.cat_sort_2').sortable('serialize');
$.ajax({
url: "admin/"+mod_type1+"/sortProgramLittleRows/<?=$details->id;?>",
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
$.ajax({
url: "admin/"+mod_type1+"/sortProgramSections/<?=$details->id;?>",
type: "post",
data: serial,
error: function(){
alert("theres an error with AJAX");
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
	exit(0);
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
exit(0);
})
})
</script>
<div class="gen-holder">
		<div class="gen-panel">
			<div class="panel-title">
				<div class="panel-title-name">Alternating Full Width Rows</div>
				
			</div>
<div class="panel-body">
<div class="panel-body-holder">
<div class="manager-items custom">

<div class="border">

<!--<div class="btn-addentry add_entry_button"></div>-->

<h1>Alternating Full Width Rows <a href="admin/<?=$link_type?>/add_program_row/<?=$details->id?>/view/<?=$details->category?>" class="button_class">Add Full Width Row</a></h1>

<div class="dragDropContent">
	You may rearrange the order of the items below by dragging them above or below other item rows. Changes will automatically be saved.
</div>
<ul class="cat_sort_1 ui-sortable" style="">

<?php
$sr_testimonials=0; 


				
if(!empty($programRows)):?>
<?php foreach($programRows as $about_us_row):
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
                                                    
												<h1><a href="admin/<?=$link_type?>/edit/<?=$about_us_row->id;?>" ><?=$about_us_row->title;?>   ( <?php echo ucfirst($about_us_row->photo_side);?> )</a></h1>
											</div>
											<div class="manager-item-opts"><a href="admin/<?=$link_type?>/edit_program_row/<?=$about_us_row->id;?>" class="lb-preview">Edit</a><?php if($about_us_row->published == 1){?>
											<a id="unpub_<?=$about_us_row->id; ?>" class="unpublish"  table_name="tbl_program_rows" title="Unpublish <?=$about_us_row->title?>">Unpublish</a>
											<input type="hidden" name="publish_type" value="0" class="publish_type" />
											<?php }else{ ?>
											<input type="hidden" name="publish_type" value="1" class="publish_type" />
											<a id="unpub_<?=$about_us_row->id; ?>"  table_name="tbl_program_rows" class="unpublish" title="Publish <?=$about_us_row->title?>">Publish</a>
											<?php }?><a program_id="<?=$about_us_row->program_id?>" cat_id="<?=$about_us_row->cat_id?>" table_name="tbl_program_rows" id="delitem_<?=$about_us_row->id?>" class="delete_item" title="Delete <?=$about_us_row->title;?>">Delete</a></div>
										</div>
									</li>
<?php endforeach;?>								
<input type="hidden" name="mod_type" value="<?=$link_type;?>" id="mod_type" />
<?php else: ?>
<div class="empty"><a href="admin/<?=$link_type?>/add_program_row/<?=$details->id?>/view/<?=$details->category?>" class="nothing-yet">Add Full Width Row</a></div>
<?php endif;?>
								</ul>
<br />
</div>				
</div>

</div>


</div>
</div>
</div>

<div class="gen-holder">
		<div class="gen-panel">
			<div class="panel-title">
				<div class="panel-title-name">Alternating Little Rows</div>
				
			</div>
<div class="panel-body">
<div class="panel-body-holder">
<div class="manager-items custom">

<div class="border">

<!--<div class="btn-addentry add_entry_button"></div>-->

<h1>Alternating Little Rows <a href="admin/<?=$link_type?>/add_program_little_row/<?=$details->id?>/view/<?=$details->category?>" class="button_class">Add Little Row</a></h1>

<div class="dragDropContent">
	You may rearrange the order of the items below by dragging them above or below other item rows. Changes will automatically be saved.
</div>
<ul class="cat_sort_2 ui-sortable" style="">

<?php
$sr_testimonials=0; 


				
if(!empty($programLittleRows)):?>
<?php foreach($programLittleRows as $about_us_row):
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
                                                    
												<h1><a href="admin/<?=$link_type?>/edit/<?=$about_us_row->id;?>" ><?=$about_us_row->title;?>   ( <?php echo ucfirst($about_us_row->photo_side);?> )</a></h1>
											</div>
											<div class="manager-item-opts"><a href="admin/<?=$link_type?>/edit_program_little_row/<?=$about_us_row->id;?>" class="lb-preview">Edit</a><?php if($about_us_row->published == 1){?>
											<a id="unpub_<?=$about_us_row->id; ?>" class="unpublish"  table_name="tbl_program_little_rows" title="Unpublish <?=$about_us_row->title?>">Unpublish</a>
											<input type="hidden" name="publish_type" value="0" class="publish_type" />
											<?php }else{ ?>
											<input type="hidden" name="publish_type" value="1" class="publish_type" />
											<a id="unpub_<?=$about_us_row->id; ?>"  table_name="tbl_program_little_rows" class="unpublish" title="Publish <?=$about_us_row->title?>">Publish</a>
											<?php }?><a program_id="<?=$about_us_row->program_id?>" cat_id="<?=$about_us_row->cat_id?>" table_name="tbl_program_little_rows" id="delitem_<?=$about_us_row->id?>" class="delete_item" title="Delete <?=$about_us_row->title;?>">Delete</a></div>
										</div>
									</li>
<?php endforeach;?>								
<input type="hidden" name="mod_type" value="<?=$link_type;?>" id="mod_type" />
<?php else: ?>
<div class="empty"><a href="admin/<?=$link_type?>/add_program_little_row/<?=$details->id?>/view/<?=$details->category?>" class="nothing-yet">Add Little Row</a></div>
<?php endif;?>
								</ul>
<br />
</div>				
</div>

</div>

</div>
</div>
</div>


<div class="gen-holder">
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
</div>



<div class="gen-holder">
		<div class="gen-panel">
			<div class="panel-title">
				<div class="panel-title-name">Manage Program Sections Position</div>
				
			</div>
<div class="panel-body">
<div class="panel-body-holder">
<div class="manager-items custom">

<div class="border">

<!--<div class="btn-addentry add_entry_button"></div>-->

<h1>Manage Program Sections Position <a href="admin/<?=$link_type?>/default_program_sections/<?=$details->id?>/view/<?=$details->category?>" class="button_class">Default Re-Arrange</a></h1>

<div class="dragDropContent">
	You may rearrange the order of the items below by dragging them above or below other item rows. Changes will automatically be saved.
</div>
<ul class="cat_sort_4 ui-sortable" style="">

<?php
$sr_testimonials=0; 


$sectionArr = array('white_stripe_section'=>'White Stripe Under Header Section','benefits_1_section'=>'Benefits with 3 images Section','video_row_section'=>'Video Row Section','call_to_action_section'=>'Call to Action with 3 Images Section','headling_section'=>'Headling with 3 boxes Section','statistics_section'=>'Statistics with 3 images Section','benefits_2_section'=>'Benefits Row2 with 3 Images Section','white_stripe_2_section'=>'White Stripe Row 2 Section','benefits_3_section'=>'Benefits Row3 with 3 Images Section','full_width_row_section'=>'Alternating Full Width Rows','little_row_section'=>'Alternating Little Rows','faq_section'=>'Faqs','testimonial_section'=>'Testimonials');
			
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
</div>

<?php $this->load->view("admin/include/conf_delete_program_rows"); ?>


<!------------ recent items ----------------->



<?php $this->load->view("admin/include/footer");?>
