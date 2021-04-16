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


<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Add: Full Width Row</h2>
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
<div class="mb-3 main-content-label page_main_heading">Add: Full Width Row</div>

<div class="form-light-holder">

	<h1>Title</h1>

	<input type="text" value="" name="title" id="" class="field full_width_input" placeholder="Enter title here"  style="" required/>

</div>

<div class="form-light-holder   d-md-flex  dual_input">
	
	<div class="adsUrl form-group">
		<h1>Photo uploader</h1>
		<div class="custom-file half_width_custom_file">
				<input type="file" name="userfile" class="custom-file-input" id="customFile1"  accept="image/*"  />
			<label class="custom-file-label" for="customFile">Choose file</label></div>
	</div>
	<div class="linkTarget form-group">
		<h1>Photo on Right/ Left</h1>

		<select name="photo_side" class="field" required>
			<option value="">-select-</option>
			<option value="right">Photo on Right</option>
			<option value="left">Photo on Left</option>
		</select>
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
		<input id="full_colorpicker_opacity" name="background_color" class="colourTextValue" value="" />
    </div>
	
 </div>
 </div> 

 
<div class="form-light-holder">
	<div class="adsUrl">
	<h1>Button Text</h1>

	<input type="text" value="" name="button_text" id="" class="field" placeholder="Enter Button Text here"/>
	</div>
	
	<div class="linkTarget">
		
	<h1>Button URL </h1>

	<input type="text" value="" name="button_url" id="" class="field" placeholder="Enter Button URL  here"/>

	</div>
	
</div>



<div class="form-light-holder">

	<h1>Content</h1>

	<textarea type="text" name="description" id="ckeditor_mini" class="field ckeditor full_width_input" placeholder=""  style=""/></textarea>

	<span id='charNum'></span>

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
</div>

<script type="text/javascript">

/*
	jQuery Document ready
*/
$(document).ready(function()
{



$("#full_colorpicker_opacity").spectrum({
   color: '',
   
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

