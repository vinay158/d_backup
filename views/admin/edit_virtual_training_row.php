<?php $this->load->view("admin/include/header"); ?>

<!---------- end head contents ---------------->


<!---------------wysiwyg editor script ------------>

<!--<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>-->

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->

<!--<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>-->
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js" type="text/javascript"></script>
	
	<script src="color_overlay_opacity_pickier/js/spectrum.js" type="text/javascript"></script>
	<script src="color_overlay_opacity_pickier/js/toc.js" type="text/javascript"></script>
	<script src="color_overlay_opacity_pickier/js/docs.js" type="text/javascript"></script>
	<script src="color_overlay_opacity_pickier/js/prettify.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="color_overlay_opacity_pickier/css/spectrum.css">
<script src="js/ckeditor_full/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		 CKEDITOR.replace(  'embed_video_text', 
									{ customConfig : 'config.js' }
							);
	
	
		CKEDITOR.replace(  'instructions_description', 
									{ customConfig : 'config.js' }
							);
	
		CKEDITOR.replace(  'live_class_embed', 
									{ customConfig : 'config.js' }
							);
		
	});
</script>	


<script>
	$(window).load(function(){
		var videoType = $('select.videoType option:selected').val();
		
		if(videoType == "youtube_video"){
				$('.vimeo_video').hide();
				$('.youtube_video').show();
				$('.orButton').hide();
				$('.embed_video').hide();
			}
			if(videoType == "vimeo_video"){
				$('.youtube_video').hide();
				$('.vimeo_video').show();	
				$('.orButton').hide();
				$('.embed_video').hide();
			}
			
			
			if(videoType == "embed_video"){
				$('.youtube_video').hide();
				$('.vimeo_video').hide();
				$('.orButton').hide();
				$('.embed_video').show();
			}



	})
	
	
	$(document).ready(function(){
		
		$('.videoType').change(function(){
		var videoType = $(this).val();
		
		if(videoType == "youtube_video"){
				$('.vimeo_video').hide();
				$('.youtube_video').show();
				$('.orButton').hide();
				$('.embed_video').hide();
			}
			if(videoType == "vimeo_video"){
				$('.youtube_video').hide();
				$('.vimeo_video').show();	
				$('.orButton').hide();
				$('.embed_video').hide();
			}
			
			
			if(videoType == "embed_video"){
				$('.youtube_video').hide();
				$('.vimeo_video').hide();
				$('.orButton').hide();
				$('.embed_video').show();
			}
});


	})
</script>


<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Edit: Virtual Training Class Type</h2>
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

<div class="mb-3 main-content-label page_main_heading">Edit: Virtual Training Class Type</div>

<form id="blog_form" action="" method="post" enctype="multipart/form-data">

<script language="javascript">



$(document).ready(function(){

	$("#main_title").keyup(function(){

		$("#sef_title").html($(this).val());

	})

/** DOJO 18/11 **/
/*$("#delete_img_right").click(function(){

		$('#img_right').hide();
		var location_id=$('.location_id').val();
		var photo = 'right_photo';
		var image_path=$('#img_right').attr('src');
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/about/deleteAboutImgMultiLocation',						
		data: { location_id : location_id,image_path:image_path,photo:photo}					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			//setTimeout("window.location.href='admin/"+mod_type+"/edit/"+staff_id+"'",1000);
		}
		});

	});*/
	
	
/** DOJO 18/11 **/
$("#delete_img_left").click(function(){

		$('#img_left').hide();
		var location_id=$('.location_id').val();
		var photo = 'left_photo';
		var image_path=$('#img_left').attr('src');
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/about/deleteAboutImgMultiLocation',						
		data: { location_id : location_id,image_path:image_path,photo:photo}					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			
			//setTimeout("window.location.href='admin/"+mod_type+"/edit/"+staff_id+"'",1000);
		}
		});

	});
	

	
})
</script>


<div class="form-light-holder">

	<h1>Class Name</h1>

	<input type="text" value="<?php echo !empty($pagedetails->class_name) ? $pagedetails->class_name : ''; ?>" name="class_name" id="" class="field full_width_input" placeholder=""  style="" required/>

</div>

<div class="form-light-holder">

	<h1>Sub Text</h1>

	<input type="text" value="<?php echo !empty($pagedetails->ages) ? $pagedetails->ages : ''; ?>" name="ages" id="" class="field full_width_input" placeholder=""  style="" />

</div>


<div class="form-light-holder   d-md-flex dual_input  welcome_video">

	<div class="adsUrl form-group">
		<h1>Warm-Up Video</h1>
		<select name="video_type" id="" class="field videoType" >
		<option value="youtube_video" <?php echo ($pagedetails->video_type == "youtube_video") ? "selected=selected" : ''; ?>>Youtube Video</option>
		<option value="vimeo_video"  <?php echo ($pagedetails->video_type == "vimeo_video") ? "selected=selected" : ''; ?>>Vimeo Video</option>
		<option value="embed_video"   <?php echo ($pagedetails->video_type == "embed_video") ? "selected=selected" : ''; ?>>Embed Video</option>
	</select>
	
	</div>
	<div class="linkTarget form-group">
	<div class="youtube_video">
	<h1>Youtube Video</h1>
	<input type="text" name="youtube_video" value="<?php echo !empty($pagedetails->youtube_video) ? $pagedetails->youtube_video : ''; ?>" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://www.youtube.com/embed/UWCbfxwwC-I
	</div>
	</div>
	<span class="orButton">OR</span>
	<div class="vimeo_video">
	<h1>Vimeo Video</h1>
	<input type="text" name="vimeo_video" value="<?php echo !empty($pagedetails->vimeo_video) ? $pagedetails->vimeo_video : ''; ?>" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://player.vimeo.com/video/167143332
	</div>
	</div>

	

	</div>
	
</div>

<div class="form-light-holder embed_video">
	<span class="field_title">Embed Video Html</span>
	<textarea name="embed_video_text"  id="embed_video_text"  class="ckeditor"><?php echo !empty($pagedetails->embed_video_text) ? $pagedetails->embed_video_text : ''; ?></textarea>
</div>	


<div class="form-light-holder">
	<span class="field_title">Instructions Title</span>
	<input type="text" value="<?php echo !empty($pagedetails->instructions_title) ? $pagedetails->instructions_title : ''; ?>" name="instructions_title"  class="field full_width_input" placeholder=""  style=""/>
</div>
<div class="form-light-holder">
	<span class="field_title">Instructions description</span>
	<textarea type="text" name="instructions_description" id="instructions_description" class="field ckeditor full_width_input" placeholder=""  style=""/><?php echo !empty($pagedetails->instructions_description) ? $pagedetails->instructions_description : ''; ?></textarea>
</div>

<?php 
	$weekDays = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
?>

<?php 
$i = 0;
foreach($weekDays as $day){ ?>
<div class="form-light-holder">
	<?php if($i == 0){ ?>
	<p>Example: 3:30 PM or 3:30 PM, 5:30 PM</p>
	<?php } ?>
	
	<div class="row row-xs align-items-center">
		<div class="col-md-1">
			<label class="form-label mg-b-0"><h1><?php echo $day; ?></h1></label>
		</div>
		<div class="col-md-11  mg-t-5 mg-md-t-0">
		<div class="row mg-t-10">
			<div class="col-lg-5">
				<input type="text" value="<?php echo isset($row_times[$day]->time) ? $row_times[$day]->time : ''; ?>" name="weekDays[<?php echo $day; ?>][time]" id="" class="field opreationHoursInput" placeholder="">
			</div><!-- col-3 -->
			<div class="col-lg-7 mg-t-20 mg-lg-t-0">
				 <label class="ckbox">
					<input type="checkbox" name="weekDays[<?php echo $day; ?>][no_classes]" value="1" <?php echo (isset($row_times[$day]->no_classes) && $row_times[$day]->no_classes == 1) ? 'checked=checked' : ''; ?>><span> Not available 
	</span>
            </label>
			</div><!-- col-3 -->
			</div>
		</div>
	</div>
	</div>
<?php $i++; } ?>

<div class="form-light-holder"  style="display:none">
	<span class="field_title">LIVE Class Embed</span>
	<textarea name="live_class_embed"  id="live_class_embed"  class="ckeditor"><?php echo !empty($pagedetails->live_class_embed) ? $pagedetails->live_class_embed : ''; ?></textarea>
</div>	

<div class="form-light-holder">

	<h1>Zoom Meeting ID</h1>

	<input type="text" value="<?php echo !empty($pagedetails->zoom_metting_id) ? $pagedetails->zoom_metting_id : ''; ?>" name="zoom_metting_id" id="" class="field " placeholder=""  />

</div>
 

<div style="clear:both;"/>
<div class="form-white-holder" style="padding-bottom:20px;">

	<input type="hidden" name="rows_id" value="<?php echo !empty($pagedetails->id) ? $pagedetails->id : ''; ?>"/>
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


<!------------ recent items ----------------->

<?php $this->load->view("admin/include/footer");?>

