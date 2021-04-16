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
		 CKEDITOR.replace(  'ckeditor_mini', 
									{ customConfig : 'config.js' }
							);
	
		
	});
</script>	


<script language="javascript" type="text/javascript">



jQuery(document).ready(function(){

    $('#headline').keyup(function(e){

            var max = 100;

            var len = $(this).val().length;

            if (len >= max) {

            	e.preventDefault();

                $('#charNum').text(' you have reached the limit');                

                $("#headline").attr('maxlength','45');                            	          

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



<div class="gen-holder">

	<div class="gen-panel-holder"  style="width: 100% !important;">

	<div class="gen-panel">

		<div class="panel-title">

			<div class="panel-title-name">Edit Full Width Row</div>

		</div>

		<div class="panel-body">

		<div class="panel-body-holder">

		<div class="form-holder">



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
$("#delete_img").click(function(){

		$('#img').hide();
		//var location_id=$('.location_id').val();
		var id=$(this).attr('number');
		//var photo = 'left_photo';
		//var image_path=$('#img_left').attr('src');
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/programs/deleteProgramCatRowImage',						
		data: { id : id}					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			
			//setTimeout("window.location.href='admin/"+mod_type+"/edit/"+staff_id+"'",1000);
		}
		});

	});
	

	
})
</script>


<div class="form-light-holder">

	<h1>Title</h1>

	<input type="text" value="<?php if(!empty($pagedetails)){ echo $this->query_model->getStrReplaceAdmin($pagedetails[0]->title); } ?>" name="title" id="" class="field full_width_input" placeholder="Enter title here"  style="" required/>

</div>

<div class="form-light-holder">

	<h1>Photo on Right/ Left</h1>

	<select name="photo_side" class="field" required>
		<option value="">-select-</option>
		<option value="right" <?php echo (!empty($pagedetails) && $pagedetails[0]->photo_side == "right") ? 'selected=selected' : '' ?>>Photo on Right</option>
		<option value="left" <?php echo (!empty($pagedetails) && $pagedetails[0]->photo_side == "left") ? 'selected=selected' : '' ?>>Photo on Left</option>
	</select>

</div>
<div class="form-light-holder" style="overflow:auto;">
	<h1>Photo uploader</h1><br />
	<?php if(!empty($pagedetails[0]->photo)): ?>
	<div><img id='img' src="<?php echo base_url().'upload/program_category/'.$pagedetails[0]->photo;?>" style="width: 100px; clear:both;" /></div>
	<input type="hidden" name="last-photo" value="<?=$pagedetails[0]->photo;?>" />
	<?php endif;?>
	<input type="file" name="userfile" id="photo"  accept="image/*"  />
	<?php if(!empty($pagedetails[0]->photo)){ 
			echo "<a href='javascript:void(0);' id='delete_img' class='delete_image_btn_new'  number='".$pagedetails[0]->id."'>Delete image</a>";
			}
	?>	
	
		<div>
		</div>
</div>

<!--<div class="form-light-holder" style="overflow:auto;">
	<h1 style="padding-bottom: 5px;">Choose a Right Photo</h1>
	<?php if(!empty($pagedetails[0]->right_photo)): ?>
	<div><img id='img_right' src="<?=base_url().'upload/about_header/'.$pagedetails[0]->right_photo;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-right-photo" value="<?=$pagedetails[0]->right_photo;?>" />
	<?php endif;?>
	<input type="file" name="right_photo" id="photo_right" accept="image/*" />
	<?php if(!empty($pagedetails[0]->right_photo)){ 
			echo "<a href='javascript:void(0);' id='delete_img_right'>Delete image</a>";
			}
	?>	
		<div>
		</div>
</div>-->

<!-- <div class="form-light-holder">
	<h1> Color Overlay Picker</h1>
	<input type="hidden" name="background_color" value="<?php if(!empty($pagedetails)){ echo $pagedetails[0]->background_color; }?>" class="colourTextValue" placeholder="Background Color" readonly="readonly" />
	<input id="cpFocus" class="coloPick" value="<?php if(!empty($pagedetails)){ echo $pagedetails[0]->background_color; }?>" />
	<div id="cpDiv" style="display:none"></div>
	
</div> --->

<!-- <div class="form-light-holder">
	<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs'>
    <div id='docs-content'>
		<input id="full_colorpicker_opacity" name="background_color" class="colourTextValue" value="<?php if(!empty($pagedetails)){ echo $pagedetails[0]->background_color; }?>" />
    </div>
	
 </div>
 </div> -->



<div class="form-light-holder">

	<h1>Content</h1>

	<textarea type="text" name="description" id="ckeditor_mini" class="field ckeditor full_width_input" placeholder=""  style=""/><?php echo !empty($pagedetails) ? $pagedetails[0]->description : '';?></textarea>

	<span id='charNum'></span>

</div>
 

<div style="clear:both;"/>
<div class="form-white-holder" style="padding-bottom:20px;">

	<input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />

</div>



</form>

		</div>

		</div>

		</div>

	</div>

	</div>

<br style="clear:both" /><br />

<script type="text/javascript">

/*
	jQuery Document ready
*/
$(document).ready(function()
{

/* $('.sp-preview-inner').css('background-color','<?php if(!empty($pagedetails)){ echo $pagedetails[0]->background_color; }?>');

$('.sp-thumb-light').attr("data-color", '<?php if(!empty($pagedetails)){ echo $pagedetails[0]->background_color; }?>'); */

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

<!------------ recent items ----------------->

<?php $this->load->view("admin/include/footer");?>

