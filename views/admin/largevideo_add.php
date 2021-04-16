<?php $this->load->view("admin/include/header"); ?>
<!-- end head contents -->
<!--wysiwyg editor script -->
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>-->

<link id="jquiCSS" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/ui-lightness/jquery-ui.css" type="text/css" media="all">
	<link href="colorpicker/css/evol.colorpicker.min.css" rel="stylesheet" />
	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js" type="text/javascript"></script>-->
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js" type="text/javascript"></script>
	<script src="colorpicker/js/evol.colorpicker.min.js" type="text/javascript"></script>
<script src="js/ckeditor_full/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		 CKEDITOR.replace(  'ckeditor_mini', 
									{ customConfig : 'mini_half_configy.js' }
							);
	
		
	});
</script>
<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Large video</h2>
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
<script>
	$(window).load(function(){
	
	if($('.hidden_cb').val() == 1){
		$('.adsUrl_manage').show();
	}else{
		$('.adsUrl_manage').hide();
	}
	
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
<script language="javascript">


$(document).ready(function(){
	$("#main_title").keyup(function(){
		$("#sef_title").html($(this).val());
	});
	
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
<script language="javascript">
$(document).ready(function(){
	$("#main_title").keyup(function(){
		$("#sef_title").html($(this).val());
	})

	$("#delete_img").click(function(){
		$('#img').hide();
		var v_id=$('#v_id').val();
		var image_path=$('#img').attr('src');
		
		var mod_type = 'home';
		//alert(staff_id);
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/'+mod_type+'/deletebgImg',						
		data: { v_id : v_id, image_path:image_path }					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			//setTimeout("window.location.href='admin/"+mod_type+"/edit/"+testimonials_id+"'",1000);
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});

	});
	
})
</script>
<form id="blog_form" action="" method="post" enctype="multipart/form-data">
<div class="mb-3 main-content-label page_main_heading">Edit: Large Video</div>
<div class="form-light-holder">

	<h1>Headline</h1>

	<textarea type="text" name="headline" id="ckeditor_mini" class="field ckeditor headline full_width_input" placeholder="Enter headline here"  style=""/><?php echo !empty($pagedetails) ? $pagedetails[0]->headline : '';?></textarea>
	<p><i>Character Limit 320 characters</i></p>
	<span id='charNum'></span>

</div>

<div class="form-light-holder  d-md-flex  dual_input  welcome_video">
	<div class="adsUrl  form-group">
		<h1>Video Type</h1>
		<select name="video_type" id="" class="field videoType" >
		<option value="youtube_video" <?php if(!empty($pagedetails) && $pagedetails[0]->video_type == 'youtube_video'){ echo 'selected=selected'; } ?>>Youtube Video</option>
		<option value="vimeo_video" <?php if(!empty($pagedetails) && $pagedetails[0]->video_type == 'vimeo_video'){ echo 'selected=selected'; } ?>  >Vimeo Video</option>
	</select>
	</div>

	<div class="linkTarget form-group">
	
	
	<div class="youtube_video">
	<h1>Youtube Video</h1>
	<input type="text" name="youtube_video" value="<?php if(!empty($pagedetails) && $pagedetails[0]->youtube_video != ''){ echo $pagedetails[0]->youtube_video; } ?>" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://www.youtube.com/embed/UWCbfxwwC-I
	</div>
	</div>
	
	<span class="orButton">OR</span>
	
	<div class="vimeo_video">
	<h1>Vimeo Video</h1>
	<input type="text" name="vimeo_video" value="<?php if(!empty($pagedetails) && $pagedetails[0]->vimeo_video != ''){echo $pagedetails[0]->vimeo_video; } ?>" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://player.vimeo.com/video/167143332
	</div>
	</div>
	
	</div>
	
</div>


<?php if( empty($pagedetails) ){ ?>
<div class="welcome_image" style="display:none">
<div class="form-light-holder" style="overflow:auto;">
 <h1 style="padding-bottom: 5px;">Upload Background Image</h1>
 
 <input type="file" name="userfile" id="photo" accept="image/*" />
  
</div>

</div>
 <?php } else{ ?>
<div class="welcome_image"  style="display:none">
<div class="form-light-holder" style="overflow:auto;">
 <h1 style="padding-bottom: 5px;">Upload Background Image</h1>
 <?php 
    if(isset($pagedetails[0]->background_image) && !empty($pagedetails[0]->background_image)){
 ?>
   <div>
 <img id="img" style="width: 100px; clear:both;" src="upload/largevideo/<?php echo $pagedetails[0]->background_image;?>">
    <?php if(isset($_POST['update'])){
     
     if($_FILES['userfile']['name'] == ""){
     
    $_FILES['userfile']['name'] = $pagedetails[0]->background_image;
    
     }
     else{
      $_FILES['userfile']['name'] = time().$_FILES['userfile']['name'];
      
     }
       }
    ?>
   </div>
 <?php 
  }
 ?>
 
 <input type="hidden" name="v_id" id="v_id" value="<?php echo $pagedetails[0]->id; ?>">
 <input type="file" name="userfile" id="photo" accept="image/*" />
 <?php if(!empty($pagedetails[0]->background_image)){ 
   echo "<a href='javascript:void(0);' class='delete_image_btn_new'  id='delete_img'>Delete image</a>";
   }
 ?> 
  
</div>

</div>
<?php } ?>


<!-- <div class="form-light-holder">

	<div class="adsUrl" style="width:auto; padding-right:70px;">
		<h1  style="padding-bottom:10px;">show logo</h1>
		<a id="published" class="checkbox check-on" ></a>
		
		<input type="hidden" value="" name="show_logo" class="hidden_cb" />
	</div>
	
		
	</div> -->












<div style="clear:both;"/>


<!-- <script type="text/javascript">
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
});
	
	
});
</script> -->

<script language="javascript">
$(document).ready(function(){
$(".form-light-holder .checkbox").click(function(){
	
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents(".form-light-holder").children().children(".hidden_cb").val("0");
		$('.adsUrl_manage').hide();
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents(".form-light-holder").children().children(".hidden_cb").val("1");
		$('.adsUrl_manage').show();
	}
})
})
</script>


<!-- <div class="form-light-holder">
	<h1>Background Color</h1>
	<input type="hidden" name="background_color" value="<?php if(!empty($pagedetails)){ echo $pagedetails[0]->background_color; }?>" class="colourTextValue" placeholder="Background Color" readonly="readonly" />
	<input id="cpFocus" class="coloPick" value="<?php if(!empty($pagedetails)){ echo $pagedetails[0]->background_color; }?>" />
	<div id="cpDiv" style="display:none"></div>
	
</div> -->


<div class="form-light-holder">
	<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs'>
    <div id='docs-content'>
		<input id="full_colorpicker_opacity" name="background_color" class="colourTextValue" value="<?php if(!empty($pagedetails)){ echo $pagedetails[0]->background_color; }?>" />
    </div>
	
 </div>
</div>




<div class="form-light-holder">

	<a id="published" class="checkbox <?php echo (!empty($pagedetails) && $pagedetails[0]->show_button == 1) ? 'check-on' : 'check-off'; ?>"></a>
<div>
	<h1 class="inline">Show Button</h1>
	
	<input type="hidden" value="<?php echo (!empty($pagedetails)) ? $pagedetails[0]->show_button : 0; ?>" name="show_button" class="hidden_cb" />
</div>
</div>

<div class="adsUrl_manage">
<div class="form-light-holder   d-md-flex  dual_input">
<div class="adsUrl form-group">
	<h1>Button Text</h1>
	<input type="text" class="adsText input_manage" name="button_text" value="<?php echo (!empty($pagedetails) && !empty($pagedetails[0]->button_text)) ? $pagedetails[0]->button_text : '';?>" id="" placeholder="Enter Button Text here" />
	</div>
	
	<div class="linkTarget form-group button1_link">
	<h1>Button Url</h1>
	<?php 
		$multiLocation = $this->query_model->getbyTable("tblconfigcalendar");
		$multiLocation = isset($multiLocation[0]) ? $multiLocation[0]->field_value : 0;
		
		$button_link = (!empty($pagedetails) && !empty($pagedetails[0]->button_link)) ? $pagedetails[0]->button_link : '';
		$readonly = 0;
		if($multiLocation == 0){
			$main_location = $this->query_model->getMainLocation("tblcontact");
			$about_us_slug = $this->query_model->getbySpecific('tblmeta', 'id', 21);
			$about_us_slug = $about_us_slug[0]->slug;
			$button_link = base_url().$about_us_slug.'/'.strtolower(str_replace(' ','-',$main_location[0]->city));
			$readonly = 1;
		}
	?>
	<input type="text" class="adsUrl input_manage" name="button_link" value="<?php echo $button_link; ?>" id="" placeholder="Enter Button Link here" <?php echo ($readonly == 1) ? "readOnly = readonly" : ''; ?> />
	</div>
	
</div>	
<div class="form-light-holder   d-md-flex  dual_input ">
	<div class="adsUrl  form-group">
	
		<h1>Button Link Target</h1>
		<select name="button_link_target" id="target" class="field input_manage" >
		<option value="_blank" <?php echo (!empty($pagedetails) && $pagedetails[0]->button_link_target == "_blank") ? "selected='selected'" : "";?>>Blank</option>
		<option value="_self" <?php echo (!empty($pagedetails) && $pagedetails[0]->button_link_target == "_self") ? "selected='selected'" : "";?>>Self</option>
		</select>
	</div>
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
</div>
<!------------ recent items ----------------->
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
<?php $this->load->view("admin/include/footer");?>
