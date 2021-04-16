<?php $this->load->view("admin/include/header"); ?>


<!-- end head contents -->
<!-- wysiwyg editor script -->
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>



<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->

<!--<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>-->

<link id="jquiCSS" rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/ui-lightness/jquery-ui.css" type="text/css" media="all">
	<link href="colorpicker/css/evol.colorpicker.min.css" rel="stylesheet" />
	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js" type="text/javascript"></script>-->
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js" type="text/javascript"></script>
	<script src="colorpicker/js/evol.colorpicker.min.js" type="text/javascript"></script>


<script src="js/ckeditor_full/ckeditor.js"></script>

<script>
	$(window).load(function(){
	
	$.each( $( ".image_video" ), function() {
		if($(this).attr('checked') == 'checked'){
			var radio_button_value = $(this).val();
	
			if(radio_button_value == "image"){
				$('.welcome_video').hide();
				
			}
			if(radio_button_value == "video"){
				$('.welcome_image').hide();
					
				$.each( $( ".video_img_type" ), function() {
					if($(this).attr('checked') == 'checked'){
						var video_imgradio_button_value = $(this).val();
							
						if(video_imgradio_button_value == "upload_image"){
							$('.welcome_video_image').show();
						}else{
							$('.welcome_video_image').hide();
						}
					}
				});
			}
		}
	});
	
	$.each( $( ".buttonType" ), function() {
		if($(this).attr('checked') == 'checked'){
	var button_value = $(this).val();
		
		if(button_value == "no_button"){
			$('.button1').hide();
			$('.button2').hide();
		}
		
		if(button_value == "1_button"){
			$('.button1').show();
			$('.button2').hide();
		}
		
		if(button_value == "2_button"){
			$('.button1').show();
			$('.button2').show();
		}
	}
	});
	
	
	var videoType = $('select.videoType option:selected').val();
	
	if(videoType == "youtube_video"){
		$('.vimeo_video').hide();
		$('.remote_video').hide();
		$('.youtube_video').show();
		$('.orButton').hide();
		$('.local_video').hide();
	}
	if(videoType == "vimeo_video"){
		$('.youtube_video').hide();
		$('.remote_video').hide();
		$('.vimeo_video').show();	
		$('.orButton').hide();
		$('.local_video').hide();
	}
	if(videoType == "remote_video"){
		$('.youtube_video').hide();
		$('.vimeo_video').hide();
		$('.remote_video').show();
		$('.orButton').hide();
		$('.local_video').hide();
	}
	
	if(videoType == "local_video"){
		$('.youtube_video').hide();
		$('.vimeo_video').hide();
		$('.remote_video').hide();
		$('.orButton').hide();
		$('.local_video').show();
	}

	$.each( $( ".link_button1" ), function() {
		if($(this).attr('checked') == 'checked'){
			var radio_button_value = $(this).val();
	
			if(radio_button_value == "link_to_page"){
				$('.button1_page_link').show();
				$('.button1_link').hide();
			}
			if(radio_button_value == "link_to_url"){
				$('.button1_page_link').hide();
				$('.button1_link').show();
			}
		}
	});
	
	
	$.each( $( ".link_button2" ), function() {
		if($(this).attr('checked') == 'checked'){
			var radio_button_value = $(this).val();
	
			if(radio_button_value == "link_to_page"){
				$('.button2_page_link').show();
				$('.button2_link').hide();
			}
			if(radio_button_value == "link_to_url"){
				$('.button2_page_link').hide();
				$('.button2_link').show();
			}
		}
	});


$(function(){


CKEDITOR.config.toolbar = [
   ['Styles','Format','Font','FontSize'],
   ['Bold','Italic','Underline','StrikeThrough','-','Undo','Redo','-','Cut','Copy','Paste','Find','Replace','-','Outdent','Indent','-','Print'],
  ] ;


 CKEDITOR.replace( 'ckeditor',
    {
        toolbar : 'Basic', /* this does the magic */
        uiColor : '#9AB8F3'
    });


	});	
	
	
	});
</script>

<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Edit: Slider</h2>
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

<form id="blog_form" action="" method="post" enctype="multipart/form-data">
<script language="javascript">


$(document).ready(function(){
	$("#main_title").keyup(function(){
		$("#sef_title").html($(this).val());
	});
	
	
	
$('.deleteVideo').click(function(){
	var slider_id = $(this).attr('slider_id');
	var field_name =  $(this).attr('field_name');
	var video_path =  $(this).attr('video_path');
	$(this).parents().parents('span').hide();
	$.ajax({ 					
		type: 'POST',						
		url: 'admin/slider/delete_local_video',						
		data: { slider_id : slider_id,field_name: field_name,video_path: video_path}					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			$('#'.field_name).val('');
		}
		});
		
})

	
	$('.link_button1').change(function(){
		var button1 = $(this).val();
		if(button1 == 'link_to_page'){
			$('.button1_page_link').show();
			$('.button1_link').hide();
		}
		
		if(button1 == 'link_to_url'){
			$('.button1_page_link').hide();
			$('.button1_link').show();
		}
	});
	
	
	$('.link_button2').change(function(){
		var button1 = $(this).val();
		if(button1 == 'link_to_page'){
			$('.button2_page_link').show();
			$('.button2_link').hide();
		}
		
		if(button1 == 'link_to_url'){
			$('.button2_page_link').hide();
			$('.button2_link').show();
		}
	});
	
$('.image_video').click(function(){
	var radio_button_value = $(this).val();
	
	if(radio_button_value == "image"){
		$('.welcome_video').hide();
		$('.welcome_image').show();
		$('.welcome_video_image').hide();
		
	}
	if(radio_button_value == "video"){
		$('.welcome_image').hide();
		$('.welcome_video').show();
			
	$.each( $( ".video_img_type" ), function() {
		if($(this).attr('checked') == 'checked'){
			var video_imgradio_button_value = $(this).val();
				
			if(video_imgradio_button_value == "upload_image"){
				$('.welcome_video_image').show();
			}else{
				$('.welcome_video_image').hide();
			}
		}
	});
		
	}
});


$('.video_img_type').click(function(){
	var radio_button_value = $(this).val();
	
	if(radio_button_value == "automatically"){
		$('.welcome_video_image').hide();
	}
	if(radio_button_value == "upload_image"){
		$('.welcome_video_image').show();
				
		
	}
});
	
	
$('.videoType').change(function(){
	var videoType = $(this).val();
	
	if(videoType == "youtube_video"){
		$('.vimeo_video').hide();
		$('.remote_video').hide();
		$('.youtube_video').show();
		$('.orButton').hide();
		$('.local_video').hide();
	}
	if(videoType == "vimeo_video"){
		$('.youtube_video').hide();
		$('.remote_video').hide();
		$('.vimeo_video').show();
		$('.orButton').hide();
		$('.local_video').hide();
	}

	if(videoType == "remote_video"){
		$('.youtube_video').hide();
		$('.vimeo_video').hide();
		$('.remote_video').show();
		$('.orButton').hide();
		$('.local_video').hide();
	}
	
	if(videoType == "local_video"){
		$('.youtube_video').hide();
		$('.vimeo_video').hide();
		$('.remote_video').hide();
		$('.orButton').hide();
		$('.local_video').show();
	}
});



$("#delete_video_img").click(function(){

		$('#img_left').hide();
		var slider_id=$(this).attr('slider_id');
		
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/slider/delete_video_img',						
		data: { slider_id : slider_id}					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			$('.last-video_img').val('');
			//setTimeout("window.location.href='admin/"+mod_type+"/edit/"+staff_id+"'",1000);
		}
		});

	});
		
		
	$('.demoInputBox').change(function(){
		var file = $(this)[0].files[0];
		var field_name = $(this).attr('field_name');
		var process_id = $(this).attr('process_id');
		$('#'+process_id).show();
		var upload = new Upload(file);

			// maby check size or type here with upload.getSize() and upload.getType()

			// execute upload
			upload.doUpload(field_name,process_id);
		
	});
	
	
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
    return this.file.name;
};
Upload.prototype.doUpload = function (field_name,process_id) {
    var that = this;
    var formData = new FormData();

    // add assoc key values, this will be posts values
    formData.append("file", this.file, this.getName());
    formData.append("upload_file", true);
	
	$("#"+field_name).val(this.file.name);
	
    $.ajax({
        type: "POST",
        url: "admin/slider/saveLocalVideos",
        xhr: function () {
            var myXhr = $.ajaxSettings.xhr();
            if (myXhr.upload) {
				myXhr.upload.addEventListener('progress', that.progressHandling, false);
				myXhr.upload.myParam = process_id;
            }
            return myXhr;
        },
        success: function (data) {
			
            // your callback here
        },
        error: function (error) {
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
	
    var percent = 0;
    var position = event.loaded || event.position;
    var total = event.total;
    var progress_bar_id = "#"+event.target.myParam;
    if (event.lengthComputable) {
        percent = Math.ceil(position / total * 100);
    }
    // update progressbars classes so it fits your code
    $(progress_bar_id + " .progress-bar").css("width", +percent + "%");
    $(progress_bar_id + " .status").text(percent + "%");
};


	
})
</script>

<div class="mb-3 main-content-label page_main_heading">Edit: Slider</div>

<?php if(!empty($slides)) : ?>
<?php foreach($slides as $slides) :?>

<div class="form-light-holder">
	
	<div class="row row-xs align-items-center">
	<div class="col-md-2">
		<label class="form-label mg-b-0">IMAGE OR VIDEO</label>
	</div>
	<div class="col-md-10  mg-t-5 mg-md-t-0">
	<div class="row mg-t-10">
		<div class="col-lg-2">
		  <label class="rdiobox">
			<input type="radio" class="image_video" name="image_video" value="image" <?php if(!empty($slides) && $slides->image_video == 'image'){ echo 'checked=checked'; } elseif(empty($slides->image_video)){  echo 'checked=checked'; } ?>  />
			<span>Image</span>
		  </label>
		</div><!-- col-3 -->
		<div class="col-lg-9 mg-t-20 mg-lg-t-0">
		  <label class="rdiobox">
			<input type="radio" class="image_video" name="image_video" value="video" <?php if(!empty($slides) && $slides->image_video == 'video'){ echo 'checked=checked'; }?> />
			<span>Video</span>
		  </label>
		</div><!-- col-3 -->
		</div>
	</div>
</div>
</div>

<div class="welcome_image">
<div class="form-light-holder" style="overflow:auto;">
	<h1 style="padding-bottom: 5px;"><b>Parallax Background</b></h1>
	<h1 style="padding-bottom: 5px;">IMAGE UPLOADER</h1>
	<div class="custom-file half_width_custom_file">		
	<input type="file" name="userfile"  class="custom-file-input" id="customFile1"  accept="image/*" />
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	
	<?php 
		if(isset($slides->photo) && !empty($slides->photo)){
	?>
			<div>
				<img style="width: 100px; clear:both;" src="<?php echo $slides->photo; ?>">
				
			</div>
	<?php 
		}
	?>
	
	
		<div>
		</div>
</div>


<div class="form-light-holder">
	<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs-photo_background_color'>
    <div id='docs-content'>
		<input id="full_background_color_opacity" name="photo_background_color" class="photoBackgroundTextValue" value="<?php if(!empty($slides)){ echo $slides->photo_background_color; }?>" />
    </div>
	
 </div>
</div>

</div>

<div class="form-light-holder  d-md-flex  dual_input welcome_video">

	<div class="adsUrl form-group">
		<h1>Video Type</h1>
		<select name="video_type" id="" class="field videoType" >
		<option value="youtube_video" <?php if(!empty($slides) && $slides->video_type == 'youtube_video'){ echo 'selected=selected'; } ?>>Youtube Video</option>
		<option value="vimeo_video" <?php if(!empty($slides) && $slides->video_type == 'vimeo_video'){ echo 'selected=selected'; } ?>  >Vimeo Video</option>
		<!--<option value="remote_video" <?php if(!empty($slides) && $slides->video_type == 'remote_video'){ echo 'selected=selected'; } ?>  >Remote Video</option> -->
		<option value="local_video" <?php if(!empty($slides) && $slides->video_type == 'local_video'){ echo 'selected=selected'; } ?>  >Self Hosted Video</option>
	</select>
	
	</div>
	<div class="linkTarget form-group">
	<div class="youtube_video">
	<h1>Youtube Video</h1>
	<input type="text" name="youtube_video" value="<?php if(!empty($slides)){ echo $slides->youtube_video; }?>" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. https://www.youtube.com/embed/UWCbfxwwC-I
	</div>
	</div>
	<span class="orButton">OR</span>
	<div class="vimeo_video">
	<h1>Vimeo Video</h1>
	<input type="text" name="vimeo_video" value="<?php if(!empty($slides)){ echo $slides->vimeo_video; } ?>" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. https://player.vimeo.com/video/167143332
	</div>
	</div>

	<span class="orButton">OR</span>
	<div class="remote_video">
	<h1>Remote Video</h1>
	<input type="text" name="remote_video" value="<?php if(!empty($slides)){ echo $slides->remote_video; } ?>" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. https://dojodigitalmedia.com/videos/small.mp4
	</div>
	</div>
	

	</div>
	
</div>

<style>
	#progress-wrp, #progress-wrp-2 {
    border: 1px solid #0099CC;
    padding: 1px;
    position: relative;
    height: 30px;
    border-radius: 3px;
    margin: 10px;
    text-align: left;
    background: #fff;
    box-shadow: inset 1px 3px 6px rgba(0, 0, 0, 0.12);
}
#progress-wrp .progress-bar, #progress-wrp-2 .progress-bar{
    height: 100%;
    border-radius: 3px;
    background-color: #12CC1A;
    width: 0;
    box-shadow: inset 1px 1px 10px rgba(0, 0, 0, 0.11);
}
#progress-wrp .status,#progress-wrp-2 .status{
    top:3px;
    left:50%;
    position:absolute;
    display:inline-block;
    color: #000000;
}
	</style>
<div class="welcome_video">	

<div class="form-light-holder local_video"  style="display:none">

	
		<h1>Mp4 Video</h1>
		<div class="custom-file half_width_custom_file">
		<input type="file" class="custom-file-input demoInputBox" field_name="local_video_mp4" process_id="progress-wrp"   id="customFile2" accept="video/*"  />
		<label class="custom-file-label" for="customFile">Choose file</label></div>
		<p>Note: upload only mp4 video <p>
	
		<?php if(!empty($slides) && !empty($slides->local_video_mp4)){ ?>
	<span><?php echo $slides->local_video_mp4; ?> <b><a href="javascript:void(0)" class="deleteVideo" field_name="local_video_mp4" slider_id="<?php echo $slides->id; ?>" video_path="upload/local_videos/<?php echo $slides->local_video_mp4; ?>"> DELETE</a> </b></span><br/>
	<?php } ?>
	
	<input type="hidden" name="local_video_mp4" id="local_video_mp4" value="<?php if(!empty($slides)){ echo $slides->local_video_mp4; } ?>">
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
	
	<div id="progress-wrp"  style="display:none">
    <div class="progress-bar"></div>
    <div class="status">0%</div>
</div>
		
	</div>
	
	
</div>

<div class="form-light-holder local_video"  style="display:none">

	
	<h1>Webm Video</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" class="demoInputBox custom-file-input" id="customFile3" field_name="local_video_webm"  process_id="progress-wrp-2"  accept="video/*" />
	
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	<p>Note: upload only webm video </p>
	
	<?php if(!empty($slides) && !empty($slides->local_video_webm)){ ?>
	<span><?php echo $slides->local_video_webm; ?>  <b><a href="javascript:void(0)" class="deleteVideo" field_name="local_video_webm" slider_id="<?php echo $slides->id; ?>"  video_path="upload/local_videos/<?php echo $slides->local_video_webm; ?>">DELETE</a></b> </span><br/>
	<?php } ?>
	<input type="hidden" name="local_video_webm" id="local_video_webm" value="<?php if(!empty($slides)){ echo $slides->local_video_webm; } ?>">
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
	<div id="progress-wrp-2"   style="display:none">
    <div class="progress-bar"></div>
    <div class="status">0%</div>
</div>
	
	</div>
	
	
	
</div>

</div>

</div>

<div class="form-light-holder welcome_video">
	<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs-video_background_color'>
    <div id='docs-content'>
		<input id="video_colorpicker_opacity" name="video_overlay_color" class="videoColourTextOverlayValue" value="<?=$slides->video_overlay_color?>" />
    </div>
	
 </div>
</div>

<div class="form-light-holder welcome_video">

<div class="row row-xs align-items-center">
	<div class="col-md-3">
		<label class="form-label mg-b-0"><h1>Upload tablet/mobile image</h1></label>
	</div>
	<div class="col-md-9  mg-t-5 mg-md-t-0">
	<div class="row mg-t-10">
		<div class="col-lg-6">
		  <label class="rdiobox">
			<input type="radio" class="video_img_type" name="video_img_type" value="automatically" <?php if(!empty($slides) && $slides->video_img_type == 'automatically'){ echo 'checked=checked'; } elseif(empty($slides->video_img_type)){  echo 'checked=checked'; } ?>    /> 
			<span> Automatically pull from youtube/vimeo</span>
		  </label>
		</div><!-- col-3 -->
		<div class="col-lg-6 mg-t-20 mg-lg-t-0">
		  <label class="rdiobox">
			<input type="radio" class="video_img_type" name="video_img_type" value="upload_image" <?php if(!empty($slides) && $slides->video_img_type == 'upload_image'){ echo 'checked=checked'; }?> />
			<span>Upload custom image</span>
		  </label>
		</div><!-- col-3 -->
		</div>
	</div>
	<br/><div style="font-style:italic;font-size:11px;margin-left:12px;color:rgb(135,135,135)"><em>Recommended image size: 1600x800</em></div>
</div>
</div>


<div class="welcome_video_image" style="display:none">
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Upload Video Thumbnail Image</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="custom_video_thumbnail" class="custom-file-input" id="customFile4" accept="image/*" />
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	
	<?php 
		if(isset($slides->custom_video_thumbnail) && !empty($slides->custom_video_thumbnail)){
	?>
			<div>
				<img style="width: 100px; clear:both;" src="<?php echo $slides->custom_video_thumbnail; ?>">
				<input name="old_custom_thumbnail_img" value="<?php echo $slides->custom_video_thumbnail; ?>" type="hidden" />
			</div>
	<?php 
		}
	?>
	</div>
	<div class="linkTarget form-group">
	
			<h1 style="padding-top: 5px;">Image alt text</h1>
	<input value="<?php echo $slides->custom_video_thumbnail_alt_text; ?>" name="custom_video_thumbnail_alt_text" id="" class="field" placeholder="image alt text" type="text">
	</div>
</div>

</div>

<!-- <div class="form-light-holder welcome_video">
	<h1>Background Pattern Overlay</h1>
	<input type="radio" class="" name="background_overlay" value="hide" <?php if(!empty($slides) && $slides->background_overlay == 'hide'){ echo 'checked=checked'; } elseif(empty($slides->background_overlay)){  echo 'checked=checked'; } ?>    /> Hidden 
	<input type="radio" class="" name="background_overlay" value="show" <?php if(!empty($slides) && $slides->background_overlay == 'show'){ echo 'checked=checked'; }?> /> Show
</div> -->

<div class="form-light-holder welcome_video">
	<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs-background_color'>
    <div id='docs-content'>
		<input id="full_colorpicker_opacity" name="background_overlay_color" class="colourTextOverlayValue" value="<?=$slides->background_overlay_color?>" />
    </div>
	
 </div>
</div>

<h1 style="padding-bottom: 5px;" class="">&nbsp;</h1>


<div class="form-light-holder   d-md-flex  dual_input" style="overflow:auto;">
		<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Top Layer .png Image Uploader</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="video_img" class=" custom-file-input" id="customFile5" accept="image/*" />
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	
	<?php if(!empty($slides->video_img)): ?>
	<div><img id='img_left' src="<?=base_url().'upload/slider_video/'.$slides->video_img;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" class="last-video_img" name="last-video_img" value="<?=$slides->video_img;?>" />
	<?php endif;?>
	
	<?php if(!empty($slides->video_img)){ 
			echo "<a href='javascript:void(0);' class='delete_image_btn_new'  slider_id='".$slides->id."'  id='delete_video_img'>Delete image</a>";
			}
	?>	
		<div>

		</div>
	</div>
	
	
	<div class="linkTarget form-group">	
	<h1 style="padding-top: 5px;">Image alt text</h1>
	<input value="<?php echo $this->query_model->getStrReplaceAdmin($slides->video_img_alt_text);?>" name="video_img_alt_text" id="" class="field" placeholder="image alt text" type="text">
	</div>
</div>




<div class="form-light-holder" style="display:none">

		<div class="adsUrl" style="width:auto; padding-right:70px;">
					<h1 style="padding-bottom:10px;">show logo</h1>
			<a id="published" class="checkbox <?=$slides->show_logo ? "check-on" : "check-off"; ?>" ></a>

			<input type="hidden" value="<?=$slides->show_logo?>" name="show_logo" class="hidden_cb" />
		</div>
		
		<div class="linkTarget">
		<h1>Override Logo</h1>
			<select name="override_logo" id="window" class="field">
			<?php foreach($override_logos as  $override_logo):?>
			<option value="<?=$override_logo->s_no?>" <?php if($slides->override_logo == $override_logo->s_no){ echo 'selected=selected';} ?>><?=$override_logo->logo_name?></option>
			<?php endforeach;?>
			</select>
		</div>
</div>


<div class="form-light-holder">
	<div class="row row-xs align-items-center">
	<div class="col-md-2 ">
		<label class="form-label  mg-t-10  mg-b-0"><h1 class="inline">Slide Template</h1></label>
	</div>
	<div class="col-md-10  mg-t-5 mg-md-t-0">
	<div class="row mg-t-10">
		<div class="col-lg-3">
		  <label class="rdiobox">
			<input type="radio" name="slide_template" value="center_wide" <?php if($slides->slide_template == 'center_wide'){ echo 'checked=checked';} ?> /><span>Center wide</span>
		  </label>
		</div><!-- col-3 -->
		<div class="col-lg-3">
		  <label class="rdiobox">
			<input type="radio" name="slide_template" value="center_condensed" <?php if($slides->slide_template == 'center_condensed'){ echo 'checked=checked';} ?>/><span>Center Condensed</span>
		  </label>
		</div><!-- col-3 -->
		<div class="col-lg-3">
		  <label class="rdiobox">
			<input type="radio" name="slide_template" value="text_left" <?php if($slides->slide_template == 'text_left'){ echo 'checked=checked';} ?>/><span>Text Left</span>
		  </label>
		</div><!-- col-3 -->
		<div class="col-lg-3">
		  <label class="rdiobox">
			<input type="radio" name="slide_template" value="text_right" <?php if($slides->slide_template == 'text_right'){ echo 'checked=checked';} ?>/><span>Text Right</span>
		  </label>
		</div><!-- col-3 -->
		</div>
	</div>
</div>
	
</div>

<div class="form-light-holder">
	<div class="row row-xs align-items-center">
	<div class="col-md-2 ">
		<label class="form-label  mg-t-10  mg-b-0"><h1 class="inline">Buttons</h1></label>
	</div>
	<div class="col-md-10  mg-t-5 mg-md-t-0">
	<div class="row mg-t-10">
		<div class="col-lg-3">
		  <label class="rdiobox">
			<input type="radio" name="buttons" class="buttonType" value="no_button" <?php if($slides->buttons == 'no_button'){ echo 'checked=checked';} ?> /><span>No Buttons</span>
		  </label>
		</div><!-- col-3 -->
		<div class="col-lg-3">
		  <label class="rdiobox">
			<input type="radio" name="buttons" class="buttonType"  value="1_button" <?php if($slides->buttons == '1_button'){ echo 'checked=checked';} ?>/><span>1 Button</span>
		  </label>
		</div><!-- col-3 -->
		<div class="col-lg-3">
		  <label class="rdiobox">
			<input type="radio" name="buttons" class="buttonType"  value="2_button" <?php if($slides->buttons == '2_button'){ echo 'checked=checked';} ?>/><span>2 Button</span>
		  </label>
		</div><!-- col-3 -->
		
		</div>
	</div>
</div>

	
</div>




<div class="form-light-holder button1">
	<div class="adsUrl adsUrl_manage" style="width:11%">
	<h1 class="inline">Buttons</h1>
	<label class="rdiobox">
	<input type="radio" name="link_button1" class="link_button1" value="link_to_url" <?php if($slides->link_button1 == 'link_to_url'){ echo 'checked=checked'; }?> /><span>Link to url</span>
		  </label>
	
	<label class="rdiobox">
	<input type="radio" name="link_button1" class="link_button1" value="link_to_page"  <?php if($slides->link_button1 == 'link_to_page'){ echo 'checked=checked'; }?> /><span>Link to page</span>
		  </label>
	
	</div>
	<div class="adsUrl adsUrl_manage" style="width:41%">
	<h1>Button #1 Text</h1>
	<input type="text" class="adsText input_manage" name="button1_text" value="<?php echo $this->query_model->getStrReplaceAdmin($slides->button1_text); ?>" id="" placeholder="Enter Button #1 Text here" />
	</div>
	
	<div class="adsUrl adsUrl_manage button1_link" style="width:41%">
	<h1>Button #1 Url</h1>
	<input type="text" class="adsUrl input_manage" name="button1_link" value="<?php echo $this->query_model->getStrReplaceAdmin($slides->button1_link);?>" id="" placeholder="Enter Button #1 Link here" />
	</div>
	
	
	<div class="adsUrl adsUrl_manage button1_page_link" style="width:41%">
	<h1>Button #1 Page Link</h1>
		<select name="button1_page_link" id="target" class="field input_manage " >
		<option value="">-Select-</option>
			<?php foreach($pages as $key => $page){ ?>
				<option value="<?= $key ?>" <?php if($slides->button1_page_link == $key){ echo 'selected=selected'; } ?> ><?= $page ?></option>
			<?php } ?>
		</select>
	</div>
	
	
	<div class="linkTarget adsUrl_manage">
	
		<h1>Button #1 Link Target</h1>
		<select name="button1_link_target" id="target" class="field input_manage" >
		<option value="_blank" <?=$slides->button1_link_target == "_blank" ? "selected='selected'" : ""; ?>>Blank</option>
		<option value="_self" <?=$slides->button1_link_target == "_self" ? "selected='selected'" : ""; ?>>Self</option>
		</select>
	</div>
	
	<div class="linkTarget adsUrl_manage">
	
		<h1>Button #1 Button Class</h1>
		<select name="button1_button_class" id="target" class="field input_manage" >
		<option value="btn-readmore"   <?=$slides->button1_button_class == "btn-readmore" ? "selected='selected'" : ""; ?>>Theme Default</option>
		<option value="btn-white"  <?=$slides->button1_button_class == "btn-white" ? "selected='selected'" : ""; ?>>White</option>
		<option value="btn-black"  <?=$slides->button1_button_class == "btn-black" ? "selected='selected'" : ""; ?>>Black</option>
		
		</select>
	</div>
	
</div>

<div class="form-light-holder button2">
	<div class="adsUrl adsUrl_manage" style="width:11%">
	<h1 class="inline">Buttons</h1>
	
	<label class="rdiobox">
	<input type="radio" name="link_button2" class="link_button2" value="link_to_url"   <?php if($slides->link_button2 == 'link_to_url'){ echo 'checked=checked'; }?> /><span>Link to url</span>
		  </label>
		  
	<label class="rdiobox">
	<input type="radio" name="link_button2" class="link_button2" value="link_to_page"  <?php if($slides->link_button2 == 'link_to_page'){ echo 'checked=checked'; }?> /><span>Link to page</span>
		  </label>
	
	</div>
	
	<div class="adsUrl adsUrl_manage"  style="width:41%">
	<h1>Button #2 Text</h1>
	<input type="text" class="adsText input_manage" name="button2_text" value="<?php echo $this->query_model->getStrReplaceAdmin($slides->button2_text);?>" id="" placeholder="Enter Button #2 Text here" />
	</div>
	
	
	<div class="adsUrl adsUrl_manage button2_link" style="width:41%">
	<h1>Button #2 Url</h1>
	<input type="text" class="adsUrl input_manage" name="button2_link" value="<?php echo $this->query_model->getStrReplaceAdmin($slides->button2_link); ?>" id="" placeholder="Enter Button #1 Link here" />
	</div>
	
	
	<div class="adsUrl adsUrl_manage button2_page_link" style="width:41%">
	<h1>Button #2 Page Link</h1>
		<select name="button2_page_link" id="target" class="field input_manage " >
		<option value="">-Select-</option>
			<?php foreach($pages as $key => $page2){ ?>
				<option value="<?= $key ?>"  <?php if( $slides->button2_page_link == $key){ echo 'selected=selected'; } ?> ><?= $page2 ?></option>
			<?php } ?>
		</select>
	</div>
	
	
	
	
	<div class="linkTarget adsUrl_manage">
	
		<h1>Button #2 Link Target</h1>
		<select name="button2_link_target" id="target" class="field input_manage" >
		<option value="_blank" <?=$slides->button2_link_target == "_blank" ? "selected='selected'" : ""; ?>>Blank</option>
		<option value="_self" <?=$slides->button2_link_target == "_self" ? "selected='selected'" : ""; ?>>Self</option>
		</select>
	</div>
	
	<div class="linkTarget adsUrl_manage">
	
		<h1>Button #2 Button Class</h1>
		<select name="button2_button_class" id="target" class="field input_manage" >
		<option value="btn-readmore"   <?=$slides->button2_button_class == "btn-readmore" ? "selected='selected'" : ""; ?>>Theme Default</option>
		<option value="btn-white"  <?=$slides->button2_button_class == "btn-white" ? "selected='selected'" : ""; ?>>White</option>
		<option value="btn-black"  <?=$slides->button2_button_class == "btn-black" ? "selected='selected'" : ""; ?>>Black</option>
		</select>
	</div>
	
</div>





<!--<div class="form-light-holder">
	<h1>Background Color</h1>
	<input type="color" class="colorPicker" name="background_color" value="<?=$slides->background_color?>" style="height: 32px;" id="" placeholder="Enter Background Color here" />
	
</div>-->


<div class="form-light-holder">
	<h1>Slide Text</h1>
	<textarea name="slide_text"  id="frm-text" class="ckeditor"><?=$slides->slide_text?></textarea>
	<em>Character Limit 150 characters</em>
</div>	

<!--Other Demo-->
<div class="form-light-holder"  style="display:none">
	<h1>Background Color</h1>
	<input type="hidden" name="background_color" value="<?=$slides->background_color?>" class="colourTextValue" placeholder="Background Color" readonly="readonly" />
	<input id="cpFocus" class="coloPick" value="<?=$slides->background_color?>" />
	<div id="cpDiv" style="display:none"></div>
	
</div>
<div style="clear:both;"/>


<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js" type="text/javascript"></script>
<script src="color_overlay_opacity_pickier/js/spectrum.js" type="text/javascript"></script>
	<script src="color_overlay_opacity_pickier/js/toc.js" type="text/javascript"></script>
	<script src="color_overlay_opacity_pickier/js/docs.js" type="text/javascript"></script>
	<script src="color_overlay_opacity_pickier/js/prettify.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="color_overlay_opacity_pickier/css/spectrum.css">
<script type="text/javascript">
$(document).ready(function() { 
	 $('#local_video_mp4').change(function(e) {	
		if($(this).val()) {
			e.preventDefault();
			$('#loader-icon').show();
			$(this).ajaxSubmit({ 
				target:   '#targetLayer', 
				beforeSubmit: function() {
				  $("#progress-bar").width('0%');
				},
				uploadProgress: function (event, position, total, percentComplete){	
					$("#progress-bar").width(percentComplete + '%');
					$("#progress-bar").html('<div id="progress-status">' + percentComplete +' %</div>')
				},
				success:function (){
					$('#loader-icon').hide();
				},
				resetForm: true 
			}); 
			return false; 
		}
	});
}); 

</script>	

<script type="text/javascript">
/*
	jQuery Document ready
*/
$(document).ready(function()
{

	$("#full_colorpicker_opacity").spectrum({
   color: '<?=$slides->background_overlay_color?>',
   
});

$("#video_colorpicker_opacity").spectrum({
   color: '<?=$slides->video_overlay_color?>',
   
});

$("#full_background_color_opacity").spectrum({
   color: '<?=$slides->photo_background_color?>',
   
});

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
        $('#jquiCSS').attr('href','https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/'+this.innerHTML+'/jquery-ui.css');
    });
	
	// Events demo
	
    $('#cpFocus').colorpicker();
	
   
	
	
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
	var bg_color = $('.evo-pointer').attr("style");
	
	var background_color = bg_color.replace('background-color:', '');
	
	$('.colourTextValue').val(background_color);
	
	//var bg_color_overlay = $('.sp-thumb-active').data("color");
	var background_color = $('#docs-background_color').find('.sp-preview-inner').css("background-color");
	var video_background_color = $('#docs-video_background_color').find('.sp-preview-inner').css("background-color");
	var photo_background_color = $('#docs-photo_background_color').find('.sp-preview-inner').css("background-color");
	
	$('.colourTextOverlayValue').val(bg_color_overlay);
	$('.videoColourTextOverlayValue').val(video_background_color);
	$('.photoBackgroundTextValue').val(photo_background_color);
});
	
	
});
</script>


<script language="javascript">

$(document).ready(function(){
$(".form-light-holder .checkbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents(".form-light-holder").children().children(".hidden_cb").val("0");
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents(".form-light-holder").children().children(".hidden_cb").val("1");
	}
})

$('.buttonType').click(function(){
	var button_value = $(this).val();
	
	if(button_value == "no_button"){
		$('.button1').hide();
		$('.button2').hide();
	}
	
	if(button_value == "1_button"){
		$('.button1').show();
		$('.button2').hide();
	}
	
	if(button_value == "2_button"){
		$('.button1').show();
		$('.button2').show();
	}
})

})
</script>

<div class="form-white-holder" style="padding-bottom:20px;">
	<input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />
</div>
</form>
<?php endforeach;?>
<?php endif;?>


		</div>

		</div>

		</div>

	</div>

	</div>

</div>
</div>
</div>
</div>

<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>
