<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<script src="js/ckeditor_full/ckeditor.js"></script>
<script>
	/*$(document).ready(function(){
		 CKEDITOR.replace(  'ckeditor_mini', 
									{ customConfig : 'mini_config.js' }
							);
	
	}); */
</script>

<div class="az-content-body-left advanced_page custom_full_page " >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Edit: Advertisement</h2>
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

$(window).load(function(){
	$.each( $( ".image_video" ), function() {
		if($(this).attr('checked') == 'checked'){
			var radio_button_value = $(this).val();
	
			if(radio_button_value == "image"){
				if($('.image_value').val() != '' || $('.image_value').val() != null){
					$('#photo').attr('required', false);
				}else{
					$('#photo').attr('required', true);
				}
				$('.welcome_video').hide();
			}
			if(radio_button_value == "video"){
				$('#photo').attr('required', false);
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
	})
	
	$('.SaveAds').click(function(){
		/*if($('#url').val() == ''){
			alert('Please: Enter Advertisement url'); return false;
		}*/
	});
	
	
	$('.image_video').click(function(){
	var radio_button_value = $(this).val();
	
	if(radio_button_value == "image"){
		if($('.image_value').val() != '' || $('.image_value').val() != null){
			$('#photo').attr('required', false);
		} else{
			$('#photo').attr('required', true);
		}
		$('.welcome_video').hide();
		$('.welcome_image').show();
	}
	if(radio_button_value == "video"){
		$('#photo').attr('required', false);
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


})
</script>
<div class="mb-3 main-content-label page_main_heading">Edit: Advertisement</div>

<?php if(!empty($ads)): ?>
<?php foreach($ads as $ads) : ?>
<div class="form-light-holder">
<h1>Advertisement Name</h1>
	<input type="text" name="title" value="<?php echo $this->query_model->getStrReplaceAdmin($ads->title)?>" id="title" placeholder="Enter Advertisement Title here" class="full_width_input"   maxlength="25" required="required" />
        	<p><i>Character Limit 25 characters  </i></p>
</div>

<div class="form-light-holder">
<h1>Advertisement description</h1>
<input type="text" name="summary" value="<?php echo $this->query_model->getStrReplaceAdmin($ads->summary); ?>" id="" placeholder="Enter Advertisement description here"    maxlength="25"  style="width: 100%"/>

	<!-- <textarea name="summary" id="ckeditor_mini" class="ckeditor"  placeholder="Enter Advertisement Summary here"  style="width: 98%" maxlength="270" required="required" /><?= $ads->summary; ?></textarea> -->
        	<p><i>Character Limit 25 characters  </i></p>
	<!--<h2>Please include the http:// before your URL</h2>-->
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
			<input type="radio" class="image_video" name="image_video" value="image" <?php if($ads->image_video == 'image'){ echo 'checked=checked'; }elseif(empty($ads->image_video)){  echo 'checked=checked'; } ?>  />
			<span>Image</span>
		  </label>
		</div><!-- col-3 -->
		<div class="col-lg-9 mg-t-20 mg-lg-t-0">
		  <label class="rdiobox">
			<input type="radio" class="image_video" name="image_video" value="video" <?php if($ads->image_video == 'video'){ echo 'checked=checked'; } ?> />
			<span>Video</span>
		  </label>
		</div><!-- col-3 -->
		</div>
	</div>
</div>
</div>


<div class="welcome_image">

<div class="form-light-holder  d-md-flex  dual_input " style="overflow:auto;">

<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Choose a Photo</h1>
	
	<div class="custom-file half_width_custom_file">
			<input type="file" name="userfile" class="custom-file-input" id="customFile1" accept="image/*" />
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	<p><i>Recommended image size: 800x580</i></p>
	
	<?php 
		if(isset($ads->photo) && !empty($ads->photo)){
	?>
			<div>
				<img style="width: 100px; clear:both;" src="<?php echo $ads->photo_thumb; ?>">
			</div>
	<?php 
		}
	?>
	
	<input type="hidden" class="image_value" value="<?= $ads->photo_thumb; ?>" />
	
	</div>
	
	<div class="linkTarget form-group">
		 <h1>Image alt text</h1>
		<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($ads->image_alt); ?>" name="image_alt" id="image_alt" class="field " placeholder="image alt text"/>
	</div>
</div>

<div class="form-light-holder">
	<div class="adsUrl">
	<h1>Advertisement URL</h1>
	<input type="text" name="url" value="<?php echo $this->query_model->getStrReplaceAdmin($ads->url)?>" id="url" placeholder="Enter Advertisement url here" />
	
	</div>
	
	
	<div class="linkTarget">
	
	<h1>Link Target</h1>
	<select name="target" id="target" class="field" >
	<option value="_blank" <?=$ads->target == "_blank" ? "selected='selected'" : ""; ?>>Blank</option>
	<option value="_self" <?=$ads->target == "_self" ? "selected='selected'" : ""; ?>>Self</option>
	</select>
	</div>
	<p><i>Please include the http:// before your URL</i></p>
</div>

</div>

<div class="form-light-holder d-md-flex  dual_input   welcome_video">
	<div class="adsUrl form-group">
		<h1>Video Type</h1>
		<select name="video_type" id="" class="field videoType" >
		<option value="youtube_video" <?php if($ads->video_type == 'youtube_video'){ echo 'selected=selected'; } ?>>Youtube Video</option>
		<option value="vimeo_video" <?php if($ads->video_type == 'vimeo_video'){ echo 'selected=selected'; } ?>  >Vimeo Video</option>
	</select>
	
	</div>
	<div class="linkTarget form-group">
	<div class="youtube_video">
	<h1>Youtube Video</h1>
	<input type="text" name="youtube_video" value="<?=$ads->youtube_video;?>" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://www.youtube.com/embed/UWCbfxwwC-I
	</div>
	</div>
	<span class="orButton">OR</span>
	<div class="vimeo_video">
	<h1>Vimeo Video</h1>
	<input type="text" name="vimeo_video" value="<?=$ads->vimeo_video;?>" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://player.vimeo.com/video/17054419
	</div>
	</div>
	</div>
	
</div>

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

<div class="form-light-holder">
	<a id="published" class="checkbox <?=$ads->published ? "check-on" : "check-off"; ?>" ></a>
	<h1 class="inline">Publish This</h1>
	<input type="hidden" value="<?=$ads->published?>" name="published" class="hidden_cb" />
</div>
<div class="form-white-holder" style="padding-bottom:20px;">
	<input type="submit" name="update" value="Save" class="btn-save SaveAds" style="float:left;" />
</div>
<?php endforeach; ?>
<?php endif; ?>
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