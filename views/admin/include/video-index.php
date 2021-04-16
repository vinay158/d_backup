<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
<link rel="stylesheet" href="/resources/demos/style.css" />
<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>
<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>
--><script src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
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
})
</script>
<div class="gen-holder">
	<div class="gen-panel-holder"  style="width: 100% !important;">
	<div class="gen-panel">
		<div class="panel-title">
			<div class="panel-title-name">Edit Video</div>
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

	$("#delete_img").click(function(){
		$('#img').hide();
		var staff_id=$('#staff_id').val();
		var image_path=$('#img').attr('src');
					
		var mod_type = $("#contact_mod").val().toLowerCase();
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/'+mod_type+'/delete',						
		data: { staff_id : staff_id,image_path:image_path }					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			//setTimeout("window.location.href='admin/"+mod_type+"/edit/"+staff_id+"'",1000);
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});

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
	
})
</script>
<div class="form-light-holder">
	<h1>Name</h1>
	<input type="text" value="<?php if(!empty($details)){ echo  $details[0]->name;} ?>" name="name" id="name" class="field" placeholder="Enter your name here"/>
	<input type="hidden" value="<?php if(!empty($details)){echo  $details[0]->id; } ?>" name="staff_id" id="staff_id" >
	
</div>

<div class="form-light-holder">
	<h1>Video Type</h1>
	<select name="video_type" id="" class="field videoType" >
	<option value="youtube_video" <?php if(!empty($details)){   if($details[0]->video_type == 'youtube_video'){ echo 'selected=selected'; } }?>>Youtube Video</option>
	<option value="vimeo_video" <?php if(!empty($details)){  if($details[0]->video_type == 'vimeo_video'){ echo 'selected=selected'; } } ?>  >Vimeo Video</option>
</select>
</div>
<div class="form-light-holder d-md-flex  dual_input  welcome_video">
	<div class="youtube_video form-group">
	<h1>Youtube Video</h1>
	<input type="text" name="youtube_video" value="<?php if(!empty($details)){ echo $details[0]->youtube_video; }?>" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://www.youtube.com/embed/XGSy3_Czz8k
	</div>
	</div>
	<span class="orButton">OR</span>
	<div class="vimeo_video form-group">
	<h1>Vimeo Video</h1>
	<input type="text" name="vimeo_video" value="<?php if(!empty($details)){ echo $details[0]->vimeo_video;}?>" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://player.vimeo.com/video/17054419
	</div>
	</div>
</div>

<input type="hidden" value="<?php if(!empty($details)){ echo $details[0]->location_id;} else { echo $this->uri->segment(4); }?>" name="location_id" class="location_id" />
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