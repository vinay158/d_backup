<?php $this->load->view("admin/include/header"); ?>

<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<!--<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>-->

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->

<!--<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>-->
<script src="js/ckeditor_full/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		 CKEDITOR.replace(  'ckeditor_mini', 
									{ customConfig : 'config.js' }
							);
	
		
	});
</script>

	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js" type="text/javascript"></script>
	
	<script src="color_overlay_opacity_pickier/js/spectrum.js" type="text/javascript"></script>
	<script src="color_overlay_opacity_pickier/js/toc.js" type="text/javascript"></script>
	<script src="color_overlay_opacity_pickier/js/docs.js" type="text/javascript"></script>
	<script src="color_overlay_opacity_pickier/js/prettify.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="color_overlay_opacity_pickier/css/spectrum.css">
	


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

<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">About Header</h2>
			</div>
			
		  </div>
	  </div>
	   <div class="row row-sm program-cat-page">

          <div class="col-sm-12 col-xl-12 az-content-body-contacts"  >
			<div class="card pd-sm-20 edit-form">

<div class="gen-holder">

	<div class="gen-panel-holder"  style="width: 100% !important;">

	<div class="gen-panel">

		
		
		<?php 
			if(!empty($multiLocation) && $multiLocation[0]->field_value ==1 &&   $multiAbout[0]->field_value ==1 ){ 
				if(!empty($allLocations)){
		?>
		<div class="panel-body">

		<div class="panel-body-holder">

		<div class="form-holder">
		
		<div class="mb-3 main-content-label page_main_heading">Duplicate Location Data</div>
		
		<!--<h1>Duplicate About Page Data</h1> -->
		<form id="blog_form" action="<?php echo base_url().'admin/about/duplicate_location_data' ?>" method="post" enctype="multipart/form-data">
			<div class="form-light-holder">
				<h1>Duplicate Location Data</h1>
					<select name="duplicate_data_location_id" id="window" class="field" required>
					<option value="">-Select Location-</option>
					<?php foreach($allLocations as  $location):?>
					<option value="<?=$location->id?>" <?php //if(!empty($pagedetails) && $pagedetails[0]->override_logo == $override_logo->s_no){ echo 'selected=selected';} ?>><?=$location->name?></option>
					<?php endforeach;?>
					</select>
					
					<input name="location_id" value="<?= $location_id; ?>" type="hidden">
				</div>
				
				<div class="form-white-holder" style="padding-bottom:20px;">
					<input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />
				</div>
			</form>
		</div>
		</div>
		</div>
			<?php } } ?>

		<div class="panel-body">

		<div class="panel-body-holder">

		<div class="form-holder">


<div class="mb-3 main-content-label page_main_heading">Edit: About Header</div>

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
<h1>Override Logo</h1>
	<select name="override_logo" id="window" class="field">
	<?php foreach($override_logos as  $override_logo):?>
	<option value="<?=$override_logo->s_no?>" <?php if(!empty($pagedetails) && $pagedetails[0]->override_logo == $override_logo->s_no){ echo 'selected=selected';} ?>><?=$override_logo->logo_name?></option>
	<?php endforeach;?>
	</select>
</div>


<div class="form-light-holder">

	<h1>Title</h1>

	<textarea type="text" name="title" id="ckeditor_mini" class="field ckeditor full_width_input" placeholder=""  style=""/><?php if(!empty($pagedetails)){ echo $pagedetails[0]->title; } ?></textarea>

</div>

<div class="form-light-holder " style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;"><b>Parallax Background</b></h1>
	<h1 style="padding-bottom: 5px;">IMAGE UPLOADER</h1>
	
	<div class="custom-file half_width_custom_file">
			<input type="file" name="left_photo"  class="custom-file-input" id="customFile1" accept="image/*" />
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	
	<?php if(!empty($pagedetails[0]->left_photo)): ?>
	<div><img id='img_left' src="<?=base_url().'upload/about_header/'.$pagedetails[0]->left_photo;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-left-photo" value="<?=$pagedetails[0]->left_photo;?>" />
	<?php endif;?>
	
	<?php if(!empty($pagedetails[0]->left_photo)){ 
			echo "<a href='javascript:void(0);' id='delete_img_left'>Delete image</a>";
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

<div class="form-light-holder">
	<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs'>
    <div id='docs-content'>
		<input id="full_colorpicker_opacity" name="background_color" class="colourTextValue" value="<?php if(!empty($pagedetails)){ echo $pagedetails[0]->background_color; }?>" />
    </div>
	
 </div>
</div>
 <div class="form-light-holder">
		<h1>Meta Title</h1>
			<input type="text" value="<?php if(!empty($pagedetails)){ echo $this->query_model->getStrReplaceAdmin($pagedetails[0]->meta_title); }?>" name="meta_title" id="meta_title" class="field full_width_input" placeholder="Meta title" style=""/>
	</div>
<div class="form-light-holder">
	<h1>Body Id</h1>
	<input type="text" name="body_id" class="field full_width_input" value="<?php if(!empty($pagedetails)){ echo $this->query_model->getStrReplaceAdmin($pagedetails[0]->body_id); }?>">
</div>
<div style="clear:both;"/>
<input type="hidden" value="<?= $location_id; ?>" name="location_id" class="location_id" />
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

<!------------ recent items ----------------->

<?php $this->load->view("admin/include/footer");?>

