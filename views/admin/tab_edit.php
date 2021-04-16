<?php $this->load->view("admin/include/header"); ?>

<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->
<script src="js/new/jquery.maskMoney.js"></script>
<script src="js/ckeditor_full/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		 CKEDITOR.replace(  'ckeditor_mini', 
									{ customConfig : 'mini_half_configy.js' }
							);
	
		CKEDITOR.replace(  'ckeditor_full',
									{  customConfig : 'config.js' }
						);
						
		
	});
</script>

<script language="javascript" type="text/javascript">

jQuery(document).ready(function(){

    $('#headline').keyup(function(e){

            var max = 200;

            var len = $(this).val().length;

            if (len >= max) {

            	e.preventDefault();

                $('#charNum').text(' you have reached the limit');                

                $("#headline").attr('maxlength','99');                            	          

            }else {

                var char = max - len;

                $('#charNum').text( char + ' characters left');

            }

	});



    $('#frm-text').keyup(function(e){

        var max = 500;

        var len = $(this).val().length;

        if (len >= max) {

        	e.preventDefault();

            $('#charNumtblurb').text(' you have reached the limit');                

            $("#frm-text").attr('maxlength','200');                            	          

        }else {

            var char = max - len;

            $('#charNumtblurb').text( char + ' characters left');

        }

});



});




</script>

<!--<input type="text" autocomplete="off" class="number" name="dollar_amt" placeholder="Enter number">-->
<div class="az-content-body-left  advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Welcome Text</h2>
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
	
	
});

$(document).ready(function(){

	$("#main_title").keyup(function(){

		$("#sef_title").html($(this).val());

	})

/** DOJO 18/11 **/
$("#delete_img").click(function(){

		$('#img').hide();
		var id=1;
		var image_path=$('#img').attr('src');
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/home/deleteAboutImg',						
		data: { id : id,image_path:image_path }					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			//setTimeout("window.location.href='admin/"+mod_type+"/edit/"+staff_id+"'",1000);
		}
		
		});

	});
	
	
$("#delete_background_image").click(function(){

		$('#background_image').hide();
		var id=1;
		//var image_path=$('#background_image').attr('src');
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/home/deleteAboutBackgroundImg',						
		data: { id : id}					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			//setTimeout("window.location.href='admin/"+mod_type+"/edit/"+staff_id+"'",1000);
		}
		
		});

	});
	
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
	
})
</script>
<?php if(!empty($pagedetails)): ?>

<?php foreach($pagedetails as $row) : ?>



<!-- <div class="form-light-holder">

	<h1>Title</h1>

	<input type="text" value="<?=$row->title?>" name="title" id="title" class="field" placeholder="Enter tab title here"/>

</div> -->

<div class="mb-3 main-content-label">Edit: Welcome Text</div>

<div class="form-light-holder">
<div class="row row-xs align-items-center">
	<div class="col-md-2">
		<label class="form-label mg-b-0">IMAGE OR VIDEO</label>
	</div>
	<div class="col-md-10  mg-t-5 mg-md-t-0">
	<div class="row mg-t-10">
		<div class="col-lg-2">
		  <label class="rdiobox">
			<input type="radio" class="image_video" name="image_video" value="image" <?php if($row->image_video == 'image'){ echo 'checked=checked'; }?>  />
			<span>Image</span>
		  </label>
		</div><!-- col-3 -->
		<div class="col-lg-9 mg-t-20 mg-lg-t-0">
		  <label class="rdiobox">
			<input type="radio" class="image_video" name="image_video" value="video" <?php if($row->image_video == 'video'){ echo 'checked=checked'; }?> />
			<span>Video</span>
		  </label>
		</div><!-- col-3 -->
		</div>
	</div>
</div>
</div>


<div class="welcome_image">
<div class="form-light-holder " style="overflow:auto;">
	<div class="adsUrl">
	<h1 style="padding-bottom: 5px;">Choose a Photo</h1>
	<div class="custom-file half_width_custom_file">
			<input type="file" name="userfile" class="custom-file-input" id="customFile1" accept="image/*" />
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	<?php if(!empty($row->photo)): ?>
	<div><img id='img' src="<?=base_url().'upload/welcome_text/'.$row->photo;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-photo" value="<?=$row->photo;?>" />
	<?php endif;?>
		
		<?php if(!empty($row->photo)){ 
				echo "<a href='javascript:void(0);' id='delete_img' class='delete_image_btn_new' >Delete image</a>";
				}
		?>	
		<p><i>Recommended image size: 360 x 605</i></p>
		</div>
		<div class="linkTarget">
		<h1>Image Top Spacing</h1>

	<input type="text" name="img_top_spacing" id="img_top_spacing" class="field  img_top_spacing" placeholder="" value="<?=$row->img_top_spacing?>"/> <span style="font-size:15px"><strong>px</strong></span><br/>
	<em>Note: Please use only integer or float value. don't use "px" in input field</em>
	
		<h1>Image alt text</h1>
	<input type="text" value="<?php echo $row->image_alt; ?>" name="image_alt" id="image_alt" class="field" placeholder="image alt text"/>
		</div>
		<div>
		</div>
</div>

</div>



<div class="form-light-holder   d-md-flex  dual_input welcome_video">
	<div class="adsUrl form-group">
		<h1>Video Type</h1>
		<select name="video_type" id="" class="field videoType" >
		<option value="youtube_video" <?php if($row->video_type == 'youtube_video'){ echo 'selected=selected'; } ?>>Youtube Video</option>
		<option value="vimeo_video" <?php if($row->video_type == 'vimeo_video'){ echo 'selected=selected'; } ?>  >Vimeo Video</option>
	</select>
	
	</div>
	<div class="linkTarget form-group">
	<div class="youtube_video">
	<h1>Youtube Video</h1>
	<input type="text" name="youtube_video" value="<?=$row->youtube_video;?>" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://www.youtube.com/embed/UWCbfxwwC-I
	</div>
	</div>
	<span class="orButton">OR</span>
	<div class="vimeo_video">
	<h1>Vimeo Video</h1>
	<input type="text" name="vimeo_video" value="<?=$row->vimeo_video;?>" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://player.vimeo.com/video/167143332
	</div>
	</div>
	</div>
	
</div>



<!-- 

<div class="form-light-holder" style="overflow:auto;">



	<h1 style="padding-bottom: 5px;">Choose a Photo</h1>

	<?php if(!empty($row->photo)): ?>

	<div><img src="<?=$row->photo;?>" style="width: 100px; clear:both;" /></div>

	<input type="hidden" name="last-photo" value="<?=$row->photo;?>" />

	<?php endif;?>

	<input type="file" name="userfile" id="photo" accept="image/*" />

		<div>

		</div>

</div>

-->

<div class="form-light-holder">

	<h1>Headline</h1>

	<textarea type="text" name="headline" id="ckeditor_mini" class="field ckeditor headline full_width_input" placeholder="Enter headline here"  style=""/><?=$row->headline?></textarea>

	<span id='charNum'></span>

</div>

<div class="form-light-holder">
	<h1  style="padding-bottom: 5px;">Text Blurb</h1>

	<textarea name="text" id="ckeditor_full"  class="ckeditor" rows="10" cols="70" ><?=$row->content?></textarea>

	<p><i>Character Limit 550 characters</i></p>

</div>




<script language="javascript">

$(document).ready(function(){

$(".form-light-holder .checkbox1").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form-light-holder").children(".hidden_cb1").val("0");

	}

	else

	{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form-light-holder").children(".hidden_cb1").val("1");

	}

})

})

</script>
<div class="form-light-holder">

	<a id="published" class="checkbox1 <?php if($row->read_more_button ==1) echo "check-on"; else echo "check-off";?>"></a>

	<h1 class="inline">Read More Button</h1>

	<input type="hidden" value="<?=$row->read_more_button?>" name="read_more_button" class="hidden_cb1" />

</div>



<!-- 

<div class="form-light-holder">

	<h1>Bullet Headline</h1>

	<input type="text" value="<?=$row->bulhead?>" name="bulhead" id="bulhead" class="field" placeholder="Enter bullet headline here"/>

</div>



<div class="form-light-holder" style="">

	<h1  style="padding-bottom: 5px;">Bullet Contents</h1>

	<textarea name="bulcont" class="ckeditor" id="frm-text2"><?=$row->bulcont;?></textarea>

</div>

-->

<div class="form-light-holder " style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;"><b>Parallax Background</b></h1>
	<h1 style="padding-bottom: 5px;">IMAGE UPLOADER</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="background_image" class="custom-file-input" id="customFile2" accept="image/*" />
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	<?php if(!empty($row->background_image)): ?>
	<div><img id='background_image' src="<?=base_url().'upload/welcome_text/'.$row->background_image;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-left-photo" value="<?=$row->background_image;?>" />
	<?php endif;?>
	
	<?php if(!empty($row->background_image)){ 
			echo "<a href='javascript:void(0);' id='delete_background_image' class='delete_image_btn_new' >Delete image</a>";
			}
	?>	
		<div>
		</div>
		
	<p><i>Recommended image size: 1670x1100</i></p>
</div>


<div class="form-light-holder">
	<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs'>
    <div id='docs-content'>
		<input id="full_colorpicker_opacity" name="background_color" class="colourTextValue" value="<?php if(!empty($row)){ echo $row->background_color; }?>" />
    </div>
	
 </div>
</div>




<div class="form-white-holder" style="padding-bottom:20px;">

	<input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />

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
   color: '<?php if(!empty($row)){ echo $row->background_color; }?>',
   
});

$('.btn-save').click(function(){
	var bg_color = $('.sp-thumb-active').data("color");
	//alert(bg_color); return false;
	$('.colourTextValue').val(bg_color);
});
	
	
});
</script>




<?php $this->load->view("admin/include/footer");?>

