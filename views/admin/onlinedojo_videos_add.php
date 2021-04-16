<?php $this->load->view("admin/include/header"); ?>



<!-- end head contents -->
<!-- wysiwyg editor script -->
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>



<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->

<!--<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>-->

<link id="jquiCSS" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/ui-lightness/jquery-ui.css" type="text/css" media="all">
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
	
	
	var videoType = $('select.videoType option:selected').val();
	$('.video_format_mp4').hide();
	$('.video_format_webm').hide();
	$('.video_format_mov').hide();
	$('.video_format_mkv').hide();
	
	if(videoType == "youtube_video"){
		$('.vimeo_video').hide();
		$('.remote_video').hide();
		$('.youtube_video').show();
		$('.orButton').hide();
		$('.local_video').hide();
		$('.embed_video').hide();
		$('.video_cover_image').hide();
		
		$('.video_format_mp4').hide();
		$('.video_format_webm').hide();
		$('.video_format_mov').hide();
		$('.video_format_mkv').hide();
	}
	if(videoType == "vimeo_video"){
		$('.youtube_video').hide();
		$('.remote_video').hide();
		$('.vimeo_video').show();	
		$('.orButton').hide();
		$('.local_video').hide();
		$('.embed_video').hide();
		$('.video_cover_image').hide();
		$('.video_format_mp4').hide();
		$('.video_format_webm').hide();
		$('.video_format_mov').hide();
		$('.video_format_mkv').hide();
	}
	if(videoType == "remote_video"){
		$('.youtube_video').hide();
		$('.vimeo_video').hide();
		$('.remote_video').show();
		$('.orButton').hide();
		$('.local_video').hide();
		$('.embed_video').hide();
		$('.video_cover_image').hide();
		$('.video_format_mp4').hide();
		$('.video_format_webm').hide();
		$('.video_format_mov').hide();
		$('.video_format_mkv').hide();
	}
	
	if(videoType == "local_video"){
		$('.youtube_video').hide();
		$('.vimeo_video').hide();
		$('.remote_video').hide();
		$('.orButton').hide();
		$('.local_video').show();
		$('.embed_video').hide();
		$('.video_cover_image').show();
		$('.video_format_mp4').hide();
		$('.video_format_webm').hide();
		$('.video_format_mov').hide();
		$('.video_format_mkv').hide();
		
		var video_format = $('select.video_format option:selected').val();
	
		if(video_format == "mp4"){
			$('.video_format_mp4').show();
			$('.video_format_webm').hide();
			$('.video_format_mov').hide();
			$('.video_format_mkv').hide();
		}
		if(video_format == "webm"){
			$('.video_format_mp4').hide();
			$('.video_format_webm').show();
			$('.video_format_mov').hide();
			$('.video_format_mkv').hide();
		}
		if(video_format == "mov"){
			$('.video_format_mp4').hide();
			$('.video_format_webm').hide();
			$('.video_format_mov').show();
			$('.video_format_mkv').hide();
		}
		
		if(video_format == "mkv"){
			$('.video_format_mp4').hide();
			$('.video_format_webm').hide();
			$('.video_format_mov').hide();
			$('.video_format_mkv').show();
		}

	}
	
	if(videoType == "embed_video"){
		$('.youtube_video').hide();
		$('.vimeo_video').hide();
		$('.remote_video').hide();
		$('.orButton').hide();
		$('.local_video').hide();
		$('.embed_video').show();
		$('.video_cover_image').show();
		$('.video_format_mp4').hide();
		$('.video_format_webm').hide();
		$('.video_format_mov').hide();
		$('.video_format_mkv').hide();
	}

	

	


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
			  <h2 class="az-dashboard-title">Edit: Video</h2>
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


<div class="mb-3 main-content-label page_main_heading">Edit: Video</div>
<?php $unique_id= uniqid(); ?>
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
		url: 'admin/onlinedojo_videos/delete_local_video',						
		data: { slider_id : slider_id,field_name: field_name,video_path: video_path}					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			$('#'.field_name).val('');
		}
		});
		
})


	
	

	
$('.videoType').change(function(){
	var videoType = $(this).val();
	
	if(videoType == "youtube_video"){
		$('.vimeo_video').hide();
		$('.remote_video').hide();
		$('.youtube_video').show();
		$('.orButton').hide();
		$('.local_video').hide();
		$('.embed_video').hide();
		$('.video_cover_image').hide();
		$('.video_format_mp4').hide();
		$('.video_format_webm').hide();
		$('.video_format_mov').hide();
		$('.video_format_mkv').hide();
	}
	if(videoType == "vimeo_video"){
		$('.youtube_video').hide();
		$('.remote_video').hide();
		$('.vimeo_video').show();
		$('.orButton').hide();
		$('.local_video').hide();
		$('.embed_video').hide();
		$('.video_cover_image').hide();
		
		$('.video_format_mp4').hide();
		$('.video_format_webm').hide();
		$('.video_format_mov').hide();
		$('.video_format_mkv').hide();
	}

	if(videoType == "remote_video"){
		$('.youtube_video').hide();
		$('.vimeo_video').hide();
		$('.remote_video').show();
		$('.orButton').hide();
		$('.local_video').hide();
		$('.embed_video').hide();
		$('.video_cover_image').hide();
		$('.video_format_mp4').hide();
		$('.video_format_webm').hide();
		$('.video_format_mov').hide();
		$('.video_format_mkv').hide();
	}
	
	if(videoType == "local_video"){
		$('.youtube_video').hide();
		$('.vimeo_video').hide();
		$('.remote_video').hide();
		$('.orButton').hide();
		$('.local_video').show();
		$('.embed_video').hide();
		$('.video_cover_image').show();
		$('.video_format_mp4').hide();
		$('.video_format_webm').hide();
		$('.video_format_mov').hide();
		$('.video_format_mkv').hide();
		
		var video_format = $('select.video_format option:selected').val();
	
		if(video_format == "mp4"){
			$('.video_format_mp4').show();
			$('.video_format_webm').hide();
			$('.video_format_mov').hide();
			$('.video_format_mkv').hide();
		}
		if(video_format == "webm"){
			$('.video_format_mp4').hide();
			$('.video_format_webm').show();
			$('.video_format_mov').hide();
			$('.video_format_mkv').hide();
		}
		if(video_format == "mov"){
			$('.video_format_mp4').hide();
			$('.video_format_webm').hide();
			$('.video_format_mov').show();
			$('.video_format_mkv').hide();
		}
		
		if(video_format == "mkv"){
			$('.video_format_mp4').hide();
			$('.video_format_webm').hide();
			$('.video_format_mov').hide();
			$('.video_format_mkv').show();
		}
	}
	
	if(videoType == "embed_video"){
		$('.youtube_video').hide();
		$('.vimeo_video').hide();
		$('.remote_video').hide();
		$('.orButton').hide();
		$('.local_video').hide();
		$('.embed_video').show();
		$('.video_cover_image').show();
		$('.video_format_mp4').hide();
		$('.video_format_webm').hide();
		$('.video_format_mov').hide();
		$('.video_format_mkv').hide();
	}
});

	
$('.video_format').change(function(){
	var video_format = $(this).val();
	
	if(video_format == "mp4"){
		$('.video_format_mp4').show();
		$('.video_format_webm').hide();
		$('.video_format_mov').hide();
		$('.video_format_mkv').hide();
	}
	if(video_format == "webm"){
		$('.video_format_mp4').hide();
		$('.video_format_webm').show();
		$('.video_format_mov').hide();
		$('.video_format_mkv').hide();
	}
	if(video_format == "mov"){
		$('.video_format_mp4').hide();
		$('.video_format_webm').hide();
		$('.video_format_mov').show();
		$('.video_format_mkv').hide();
	}
	
	if(video_format == "mkv"){
		$('.video_format_mp4').hide();
		$('.video_format_webm').hide();
		$('.video_format_mov').hide();
		$('.video_format_mkv').show();
	}
	
});





$("#delete_video_img").click(function(){

		$('#img_left').hide();
		var slider_id=$(this).attr('slider_id');
		
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/onlinedojo_videos/delete_video_img',						
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
    return '<?php echo $unique_id; ?>'+this.file.name;
};
Upload.prototype.doUpload = function (field_name,process_id) {
    var that = this;
    var formData = new FormData();

    // add assoc key values, this will be posts values
    formData.append("file", this.file, this.getName());
    formData.append("upload_file", true);
	
	$("#"+field_name).val('<?php echo $unique_id; ?>'+this.file.name);
	
    $.ajax({
        type: "POST",
        url: "admin/onlinedojo_videos/saveLocalVideos",
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



<div class="form-light-holder" >

	<h1>Video Title</h1>
	<input  name="video_title" id="" class="field full_width_input" placeholder="" type="text" value="" style="">
</div>

<div class="form-light-holder d-md-flex  dual_input  welcome_video">

	<div class="adsUrl form-group">
		<h1>Video Type</h1>
		<select name="video_type" id="" class="field videoType" >
		<option value="youtube_video" >Youtube Video</option>
		<option value="vimeo_video"  >Vimeo Video</option>
		<!--<option value="remote_video" <?php if(!empty($slides) && $slides->video_type == 'remote_video'){ echo 'selected=selected'; } ?>  >Remote Video</option> -->
		<!--<option value="local_video"  >Self Hosted Video</option> -->
		<option value="embed_video" >Embed Video</option>
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
		eg. http://player.vimeo.com/video/167143332
	</div>
	</div>

	<span class="orButton">OR</span>
	<div class="remote_video">
	<h1>Remote Video</h1>
	<input type="text" name="remote_video" value="" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://dojodigitalmedia.com/videos/small.mp4
	</div>
	</div>
	

	</div>
	
</div>

<style>
	#progress-wrp, #progress-wrp-2 , #progress-wrp-3 , #progress-wrp-4{
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
#progress-wrp .progress-bar, #progress-wrp-2 .progress-bar, #progress-wrp-3 .progress-bar, #progress-wrp-4 .progress-bar{
    height: 100%;
    border-radius: 3px;
    background-color: #12CC1A;
    width: 0;
    box-shadow: inset 1px 1px 10px rgba(0, 0, 0, 0.11);
}
#progress-wrp .status,#progress-wrp-2 .status,#progress-wrp-3 .status,#progress-wrp-4 .status{
    top:3px;
    left:50%;
    position:absolute;
    display:inline-block;
    color: #000000;
}
	</style>
<div class="welcome_video">	


<div class="form-light-holder local_video">
	<h1>Video Format </h1>
		<select name="video_format" id="" class="field video_format" >
		<option value="" selected="selected">-Select Video Format-</option>
		<option value="mp4" >MP4</option>
		<option value="webm"  >Webm</option>
		<option value="mov"  >MOV</option>
		<!--<option value="mkv" >MKV</option>-->
	</select>
</div>

<div class="form-light-holder video_format_mp4"  style="display:none">

	<div class="adsUrl">
		<h1>Mp4 Video</h1>
		
	<input type="file" class="demoInputBox" field_name="local_video_mp4" process_id="progress-wrp"  accept="video/*"  />
	<input type="hidden" name="local_video_mp4" id="local_video_mp4" value="">
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
	
	<div id="progress-wrp"  style="display:none">
    <div class="progress-bar"></div>
    <div class="status">0%</div>
</div>
		Note: upload only mp4 video 
	</div>
		
	
	</div>
	<div class="linkTarget">
	
	</div>
	
</div>

<div class="form-light-holder video_format_webm"  style="display:none">

	<div class="adsUrl">
	<h1>Webm Video</h1>
	
	<input type="file" class="demoInputBox" field_name="local_video_webm"  process_id="progress-wrp-2"  accept="video/*" />
	<input type="hidden" name="local_video_webm" id="local_video_webm" value="">
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
	<div id="progress-wrp-2"   style="display:none">
    <div class="progress-bar"></div>
    <div class="status">0%</div>
</div>
		Note: upload only webm video 
	</div>
	
	</div>
	<div class="linkTarget">
	

	</div>
	
</div>

<div class="form-light-holder video_format_mov"  style="display:none">

	<div class="adsUrl">
		<h1>MOV Video</h1>
		
	<input type="file" class="demoInputBox" field_name="local_video_mov" process_id="progress-wrp-3"  accept="video/*"  />
	<input type="hidden" name="local_video_mov" id="local_video_mov" value="">
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
	
	<div id="progress-wrp-3"  style="display:none">
    <div class="progress-bar"></div>
    <div class="status">0%</div>
</div>
		Note: upload only MOV video 
	</div>
		
	
	</div>
	<div class="linkTarget">
	
	</div>
	
</div>

<div class="form-light-holder video_format_mkv"  style="display:none">

	<div class="adsUrl">
		<h1>MKV Video</h1>
		
	<input type="file" class="demoInputBox" field_name="local_video_mkv" process_id="progress-wrp-4"  accept="video/*"  />
	<input type="hidden" name="local_video_mkv" id="local_video_mkv" value="">
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
	
	<div id="progress-wrp-4"  style="display:none">
    <div class="progress-bar"></div>
    <div class="status">0%</div>
</div>
		Note: upload only MKV video 
	</div>
		
	
	</div>
	<div class="linkTarget">
	
	</div>
	
</div>

<div class="form-light-holder video_cover_image" style="overflow:auto;display:none">
	
	<h1 style="padding-bottom: 5px;">Video Cover Image</h1>
	
	<div class="custom-file half_width_custom_file">
			<input type="file" name="userfile" class="custom-file-input" id="customFile1" accept="image/*">
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	
	
	
</div>
</div>

</div>





	
<style>.adsUrl_manage {
  float: left;
  width: 22%;
}

.adsUrl_manage .input_manage{
  width: 87%;
  margin:0;
}
</style>


<div class="form-light-holder embed_video">
	<h1>Embed Video Html</h1>
	<textarea name="embed_video_text"  id="" class="ckeditor"></textarea>
</div>	

<div class="form-light-holder">
	<h1>Slide Text</h1>
	<textarea name="slide_text"  id="frm-text" class="ckeditor"></textarea>
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

<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>
