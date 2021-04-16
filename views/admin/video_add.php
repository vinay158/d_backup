<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<!-- <script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script> -->
<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>
<div class="gen-holder">
	<div class="gen-panel-holder"  style="width: 100% !important;">
	<div class="gen-panel">
		<div class="panel-title">
			<div class="panel-title-name">Add Video</div>
		</div>
		<div class="panel-body">
		<div class="panel-body-holder">
		<div class="form-holder">

<form id="blog_form" action="" method="post" enctype="multipart/form-data">
<script language="javascript">
$(window).load(function(){
	
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
	})
	
	
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
	
})
</script>
<div class="form-light-holder">
	<h1>Name</h1>
	<input type="text" value="" name="name" id="name" class="field" placeholder="Enter your name here"/>	
</div>

 
<div class="form-light-holder">
	<h1>Video Type</h1>
	<select name="video_type" id="" class="field videoType" >
	<option value="youtube_video" >Youtube Video</option>
	<option value="vimeo_video" >Vimeo Video</option>
</select>
</div>
<div class="form-light-holder  d-md-flex  dual_input  welcome_video">
	<div class="youtube_video form-group">
	<h1>Youtube Video</h1>
	<input type="text" name="youtube_video" value="" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://www.youtube.com/embed/XGSy3_Czz8k
	</div>
	</div>
	<div class="vimeo_video  form-group">
	<h1>Vimeo Video</h1>
	<input type="text" name="vimeo_video" value="" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://player.vimeo.com/video/17054419
	</div>
	</div>
</div>

<input type="hidden" value="<?php if(!empty($location_id)){ echo $location_id; } ?>" name="location_id" class="location_id" />
<div class="form-white-holder" style="padding-bottom:20px;">
	<input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />
</div>
</form>



		</div>
		</div>
		</div>
	</div>
	</div>
<br style="clear:both"		 /><br />
<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>
