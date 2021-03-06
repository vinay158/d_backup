<?php $this->load->view("admin/include/header"); ?>

<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->
<script src="js/new/jquery.maskMoney.js"></script>


<script language="javascript" type="text/javascript"></script>


<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title"><?php echo $title; ?></h2>
			</div>
			
		  </div>
	  </div>
	   <div class="row row-sm program-cat-page">

          <div class="col-sm-12 col-xl-12 az-content-body-contacts"  >
			<div class="card pd-sm-20 edit-form">
			
<div class="gen-holder">

	<div class="gen-panel-holder"  style="width: 100% !important;">

	<div class="gen-panel">

		

		<div class="panel-body" id="pwa_setting">

		<div class="panel-body-holder">

		<div class="form-holder">



<form id="blog_form" action="" method="post" enctype="multipart/form-data">




<div class="mb-3 main-content-label page_main_heading"><?php echo $title; ?></div>

<div class="form-light-holder">
	<a id="published" class="checkbox1 <?php echo (!empty($detail) && $detail->type == 1) ? 'check-on' : 'check-off'; ?>"></a>

	<h1 class="inline">PWA App</h1>

	<input type="hidden" value="<?php echo (!empty($detail) && $detail->type == 1) ? 1 : 0; ?>" name="type" class="hidden_cb1" />

</div>

<div class="form_box">
<div class="form-light-holder">

	<h1>Name</h1>
	<input type="text" value="<?php echo (!empty($detail) && !empty($detail->name)) ? $this->query_model->getStrReplaceAdmin($detail->name) : $site_setting[0]->title; ?>" name="name" id="" class="field full_width_input require_field" placeholder=""  style=""/>
</div>

<div class="form-light-holder">

	<h1>Short Name</h1>
	<input type="text" value="<?php echo (!empty($detail) && !empty($detail->short_name)) ? $this->query_model->getStrReplaceAdmin($detail->short_name) : $site_setting[0]->title; ?>" name="short_name" id="" class="field full_width_input require_field" placeholder=""  style=""/>
</div>


<div class="form-light-holder welcome_video">
	<h1> Theme Color</h1>
	<div id='docs-video_background_color'>
    <div id='docs-content'>
		<input id="video_colorpicker_opacity" name="theme_color" class="videoColourTextOverlayValue" value="<?php echo (!empty($detail) && !empty($detail->theme_color)) ? $detail->theme_color : ''; ?>" />
    </div>
	
 </div>
</div>

<div class="form-light-holder">
	<h1> Background Color</h1>
	<div id='docs-background_color'>
    <div id='docs-content'>
		<input id="full_colorpicker_opacity" name="background_color" class="colourTextOverlayValue" value="<?php echo (!empty($detail) && !empty($detail->background_color)) ? $detail->background_color : ''; ?>" />
    </div>
	
 </div>
</div>

<div class="form-light-holder">
	<h1 style="padding-bottom: 5px;">Icon Image</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="userfile"   class="custom-file-input <?php echo (!empty($detail) && !empty($detail->background_color)) ? '' : 'require_field' ?>" id="customFile1"  accept="image/png"  />
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	<br/><em>Note: Recommended image size: 512x512 and image type : png</em>
	
	<?php if(!empty($detail) && !empty($detail->icon_image)): ?>
	<div><img id='img' src="<?=base_url().'upload/pwa_icons/'.$detail->icon_image;?>" style="width: 100px; clear:both;" /></div>	
	<input type="hidden" id="last-photo" name="last-photo" value="<?=$detail->icon_image;?>" />
	<?php endif;?>
	
	<?php /*if(!empty($detail) && !empty($detail->icon_image)){ 
			echo "<a href='javascript:void(0);' id='delete_img' class='delete_image_btn_new' >Delete image</a>";
			}*/
	?>
	
	</div>
	


</div>
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



<script language="javascript">
$(window).load(function(){
	var hidden_cb1 = $('.hidden_cb1').val();
	if(hidden_cb1 == 1){
		$('.form_box').show();
		$('#pwa_setting .require_field').attr('required', 'required');
		
	}else{
		$('.form_box').hide();
		$('#pwa_setting .require_field').removeAttr('required');
	}
})
$(document).ready(function(){

$(".form-light-holder .checkbox1").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form-light-holder").children(".hidden_cb1").val("0");

		$('.form_box').hide();
		$('#pwa_setting .require_field').removeAttr('required');
	}

	else

	{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form-light-holder").children(".hidden_cb1").val("1");
		
		$('.form_box').show();
		$('#pwa_setting .require_field').attr('required', 'required');
	}

})

})

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
<?php 
$background_color = (!empty($detail) && !empty($detail->background_color)) ? $detail->background_color : ''; 
$theme_color = (!empty($detail) && !empty($detail->theme_color)) ? $detail->theme_color : '';
?>
	$("#full_colorpicker_opacity").spectrum({
	   color: '<?=$background_color?>',
	});

	$("#video_colorpicker_opacity").spectrum({
	   color: '<?=$theme_color?>',  
	});

	

$('.btn-save').click(function(){
	var bg_color = $('.evo-pointer').attr("style");
	
	var background_color = bg_color.replace('background-color:', '');
	
	$('.colourTextValue').val(background_color);
	
	//var bg_color_overlay = $('.sp-thumb-active').data("color");
	var background_color = $('#docs-background_color').find('.sp-preview-inner').css("background-color");
	var video_background_color = $('#docs-video_background_color').find('.sp-preview-inner').css("background-color");
	
	$('.colourTextOverlayValue').val(bg_color_overlay);
	$('.videoColourTextOverlayValue').val(video_background_color);
});
	
	
});
</script>


<?php $this->load->view("admin/include/footer");?>

