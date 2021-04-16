<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<!--<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>-->
<script src="js/ckeditor_full/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		
		CKEDITOR.replace(  'content',
									{  customConfig : 'config.js' }
						);
	});
</script>


<script language="javascript">

$(window).load(function(){
	$.each( $( ".image_video" ), function() {
		if($(this).attr('checked') == 'checked'){
			var radio_button_value = $(this).val();
	
			if(radio_button_value == "text"){
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
	
	<?php if($multi_school == 1){ ?>
	var selected_location = $('#location_id').val();
	
	if(selected_location > 0){
		$('.form2checkbox').hide();
	}else{
		$('.form2checkbox').show();
	}
	<?php } ?>
	
});

$(document).ready(function(){

	$("#main_title").keyup(function(){

		$("#sef_title").html($(this).val());

	})

/** DOJO 18/11 **/
$("#delete_img").click(function(){

		$('#img_left').hide();
		var id=$(this).attr('number');
		
		var image_path=$('#img_left').attr('src');
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/onlinespecial/deleteCategoryImage',						
		data: { id : id,image_path:image_path }					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			//setTimeout("window.location.href='admin/"+mod_type+"/edit/"+staff_id+"'",1000);
		}
		
		});

	});
	
$('.image_video').click(function(){
	var radio_button_value = $(this).val();
	
	if(radio_button_value == "text"){
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

<?php if($multi_school == 1){ ?>
$('#location_id').change(function(){
	var selected_location = $(this).val();
	if(selected_location > 0){
		$('.form2checkbox').hide();
		$('.checkbox2').removeClass("check-off");
		$('.checkbox2').addClass("check-on");
		$(".form2checkbox").find(".hidden_cb2").val("1");
	}else{
		$('.form2checkbox').show();
	}
})
<?php } ?>
	
})
</script>


<script language="javascript">
$(window).load(function(){
	if($('.hidden_cb1').val() == 1){
		$('.icon_rows_box').show();
	}else{
		$('.icon_rows_box').hide();
	}
})
$(document).ready(function(){

$('#title').keyup(function(){
	$('#text_2').val($(this).val()+' Trial Offers');
})

$(".form-light-holder .checkbox1").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form-light-holder").children(".hidden_cb1").val("0");

		$('.icon_rows_box').hide();
	}

	else

	{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form-light-holder").children(".hidden_cb1").val("1");
		$('.icon_rows_box').show();
	}

})

})

</script>

<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title"><?=$title?></h2>
			</div>
			
		  </div>
	  </div>
	   <div class="row row-sm program-cat-page">

          <div class="col-sm-12 col-xl-12 az-content-body-contacts"  >
			<div class="card pd-sm-20 edit-form">
			
<div class="gen-holder">
	<div class="gen-panel-holder" style="width: 100%;">
	<div class="gen-panel">
		<div class="panel-body">
		<div class="panel-body-holder">
		<div class="form-holder">

<div class="mb-3 main-content-label page_main_heading"><?=$title?></div>

<form id="blog_form" action="" method="post"  enctype="multipart/form-data">

<div class="form-light-holder">
		<h1>Title</h1>
			<input type="text" value="<?php if(!empty($pagedetails)){ echo $this->query_model->getStrReplaceAdmin($pagedetails[0]->name); } ?>" name="name" id="title" class="field full_width_input"  style="" placeholder="Category Title" required/>
	</div>
	
	
 <div class="form-light-holder">
		<h1>Heading</h1>
			<input type="text" value="<?php if(!empty($pagedetails)){ echo $this->query_model->getStrReplaceAdmin($pagedetails[0]->heading); } ?>" name="heading" id="heading" class="field full_width_input" style=""  placeholder="Category Heading"/>
	</div>
	
 <div class="form-light-holder">
		<h1>Slug</h1>
			<input type="text" value="<?php if(!empty($pagedetails)){ echo $this->query_model->getStrReplaceAdmin($pagedetails[0]->slug); } ?>" name="slug" id="slug" class="field full_width_input"  style=""  placeholder="Slug"/>
		<em>Note:- If you will empty it will automatically fill from title</em>
	</div>
	
<?php if($multi_school == 1){ ?>
<div class="form-light-holder">
		<h1>School</h1>
		<select name="location_id" id="location_id" class="field" >
		<option value="0">-Select-</option>
		<?php 
			if(!empty($locations)){ 
				foreach($locations as $location){
		?>
		<option value="<?php echo $location->id ?>" <?php echo (!empty($pagedetails) && $pagedetails[0]->location_id == $location->id) ? 'selected=selected' : ''; ?>><?php echo $location->name; ?></option>
		
			<?php } }  ?>
	</select>
	
	</div>
	
<?php } ?>
	
<div class="form-light-holder   d-md-flex  dual_input" style="overflow:auto;">
	
	<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;"><b>Parallax Background</b></h1>
	<h1 >IMAGE UPLOADER</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="left_photo" class="custom-file-input" id="customFile1" accept="image/*">
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	
	<?php if(!empty($pagedetails[0]->left_photo)): ?>
	<div><img id='img_left' src="<?=base_url().'upload/onlinespecial/'.$pagedetails[0]->left_photo;?>" style="width: 100px; clear:both;" /></div>
	<input type="hidden" name="last-left-photo" value="<?=$pagedetails[0]->left_photo;?>" />
	<?php endif;?>
	<?php if(!empty($pagedetails[0]->left_photo)){ 
			echo "<a href='javascript:void(0);' id='delete_img' class='delete_image_btn_new'  number='".$pagedetails[0]->id."'>Delete image</a>";
			}
	?>	
	</div>
	
	<div class="linkTarget form-group" style="margin-top:25px">
	<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs'>
    <div id='docs-content'>
		<input id="full_colorpicker_opacity" name="background_color" class="colourTextValue" value="<?php if(!empty($pagedetails)){ echo $pagedetails[0]->background_color; }?>" />
    </div>
	
 </div>
		</div>
</div>


<div class="form-light-holder">
	<div class="row row-xs align-items-center">
		<div class="col-md-2">
			<label class="form-label mg-b-0"><h1>Video Or Text</h1></label>
		</div>
		<div class="col-md-10  mg-t-5 mg-md-t-0">
		<div class="row mg-t-10">
			<div class="col-lg-2">
			  <label class="rdiobox">
				<input type="radio" class="image_video" name="text_or_video" value="text" <?php if(!empty($pagedetails) && $pagedetails[0]->text_or_video == 'text'){ echo 'checked=checked'; } ?>  /><span>Text</span>
			  </label>
			</div><!-- col-3 -->
			<div class="col-lg-9 mg-t-20 mg-lg-t-0">
			  <label class="rdiobox">
				<input type="radio" class="image_video" name="text_or_video" value="video" <?php if(!empty($pagedetails) && $pagedetails[0]->text_or_video == 'video'){ echo 'checked=checked'; } elseif(empty($pagedetails[0]->text_or_video)){  echo 'checked=checked'; }?> /><span>Video</span>
			  </label>
			</div><!-- col-3 -->
			</div>
		</div>
	</div>

</div>

<div class="welcome_image">
	<div class="form-light-holder">
		<h1>Text</h1>
		<textarea name="text" class="ckeditor" id="content"><?php if(!empty($pagedetails)){ echo $pagedetails[0]->text; }?></textarea>
	</div>
	
	
</div>
<div class="form-light-holder d-md-flex  dual_input  welcome_video">
	<div class="adsUrl form-group">
		<h1>Video Type</h1>
		<select name="video_type" id="" class="field videoType" >
		<option value="youtube_video" <?php if(!empty($pagedetails) && $pagedetails[0]->video_type == 'youtube_video'){ echo 'selected=selected'; } ?>>Youtube Video</option>
		<option value="vimeo_video" <?php if(!empty($pagedetails) && $pagedetails[0]->video_type == 'vimeo_video'){ echo 'selected=selected'; } ?>  >Vimeo Video</option>
	</select>
	
	</div>
	<div class="linkTarget form-group">
	<div class="youtube_video">
	<h1>Youtube Video</h1>
	<input type="text" name="youtube_video" value="<?php if(!empty($pagedetails)){ echo $pagedetails[0]->youtube_video; }?>" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://www.youtube.com/embed/UWCbfxwwC-I
	</div>
	</div>
	<span class="orButton">OR</span>
	<div class="vimeo_video">
	<h1>Vimeo Video</h1>
	<input type="text" name="vimeo_video" value="<?php if(!empty($pagedetails)){ echo $pagedetails[0]->vimeo_video; } ?>" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://player.vimeo.com/video/167143332
	</div>
	</div>
	</div>
	
</div>


<div class="form-light-holder">
		<h1>White Row w/ Text (Optional Override - by default the trial category name will be shown)</h1>
			<input type="text" value="<?php if(!empty($pagedetails)){ echo $pagedetails[0]->text_2; } ?>" name="text_2" id="text_2" class="field full_width_input"  style="" placeholder="White Row w/ Text"/>
	</div>
	
	
	<div class="form-light-holder">
	<a id="published" class="checkbox1 <?php echo (!empty($pagedetails) && $pagedetails[0]->show_icon_rows == 1) ? 'check-on' : 'check-off'; ?>"></a>

	<h1 class="inline">Show Icon Rows</h1>

	<input type="hidden" value="<?php echo (!empty($pagedetails) && $pagedetails[0]->show_icon_rows == 1) ? 1 : 0; ?>" name="show_icon_rows" class="hidden_cb1" />

</div>
</div>

<div class="icon_rows_box">	
<div class="form-light-holder">
		<h1>Icon Row #1</h1>
			<input type="text" value="<?php if(!empty($pagedetails)){ echo $this->query_model->getStrReplaceAdmin($pagedetails[0]->icon_1_text); } ?>" name="icon_1_text" id="icon_1_text" class="field full_width_input"  style="" placeholder="Icon 1 Text"/>
	</div>
	
	
	<div class="form-light-holder">
		<h1>Icon Row #2</h1>
			<input type="text" value="<?php if(!empty($pagedetails)){ echo $this->query_model->getStrReplaceAdmin($pagedetails[0]->icon_2_text); } ?>" name="icon_2_text" id="icon_2_text" class="field full_width_input"  style="" placeholder="Icon 2 Text"/>
	</div>
	
	
	<div class="form-light-holder">
		<h1>Icon Row #3</h1>
			<input type="text" value="<?php if(!empty($pagedetails)){ echo $this->query_model->getStrReplaceAdmin($pagedetails[0]->icon_3_text); } ?>" name="icon_3_text" id="icon_3_text" class="field full_width_input"  style="" placeholder="Icon 3 Text"/>
	</div>
</div>	
	
<div class="form-light-holder   d-md-flex  dual_input">
	<div class="adsUrl form-group">
		<h1>Body Id</h1>
		<input type="text" name="body_id" class="field" value="<?php if(!empty($pagedetails)){ echo $pagedetails[0]->body_id; }?>">
	</div>
	
	<div class="linkTarget form-group">
		<h1>Body Class</h1>
		<input type="text" name="body_class" class="field" value="<?php if(!empty($pagedetails)){ echo $pagedetails[0]->body_class; }?>">
	</div>
</div>	


<div class="form-light-holder" style="">
<h1>Meta Title</h1>
	<input type="text" name="meta_title" class="field full_width_input" value="<?php if(!empty($pagedetails)){ echo $pagedetails[0]->meta_title; }?>">
</div>

<div class="form-light-holder" style="">
<h1>Meta Description</h1>
	<textarea name="meta_desc" id="frm-text"><?php if(!empty($pagedetails)){ echo $pagedetails[0]->meta_desc; }?></textarea>
</div>	

<script language="javascript">

$(document).ready(function(){

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
<div class="form-light-holder form2checkbox">

	<h1 class="inline">Hide from trial offer</h1>
	
	<a id="published" class="checkbox2 <?php echo (!empty($pagedetails) && $pagedetails[0]->hide_from_trial_page == 1) ? 'check-on' : 'check-off'; ?>"></a>


	<input type="hidden" value="<?php echo (!empty($pagedetails) && $pagedetails[0]->hide_from_trial_page == 1) ? 1 : 0; ?>" name="hide_from_trial_page" class="hidden_cb2" />

</div>
	
	
	
		
	
<script language="javascript">

$(document).ready(function(){

$(".form3checkbox .checkbox3").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form3checkbox").children(".hidden_cb3").val("0");

		
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

	<h1 class="inline">Published</h1>
	
	<a id="published" class="checkbox3 <?php echo (!empty($pagedetails) && $pagedetails[0]->published == 1) ? 'check-on' : 'check-off'; ?>"></a>


	<input type="hidden" value="<?php echo (!empty($pagedetails) && $pagedetails[0]->published == 1) ? 1 : 0; ?>" name="published" class="hidden_cb3" />

</div>
	


	<div class="form-white-holder" style="padding-bottom:20px;">
		<input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />
	</div>
	
	<!--<div class="btn-save">-->
	<!--	<a style="" href="admin/staff/add"></a>-->
	<!--</div>-->
	
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
   color: '<?php if(!empty($pagedetails)){ echo $pagedetails[0]->background_color; }?>',
   
});

$('.btn-save').click(function(){
	var bg_color = $('.sp-thumb-active').data("color");
	//alert(bg_color); return false;
	$('.colourTextValue').val(bg_color);
});
	
	
});
</script>
<?php $this->load->view("admin/include/footer"); ?>
