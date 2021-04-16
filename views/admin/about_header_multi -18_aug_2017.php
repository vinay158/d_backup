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

			<div class="panel-title-name">Edit About Header</div>

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

	<input type="text" value="<?php if(!empty($pagedetails)){ echo $pagedetails[0]->title; } ?>" name="title" id="" class="field full_width_input" placeholder="Enter title here"  style=""/>

	<span id='charNum'></span>

</div>

<div class="form-light-holder" style="overflow:auto;">
	
	<h1 style="padding-bottom: 5px;"><b>Parallax Background</b></h1>
	<h1 style="padding-bottom: 5px;">IMAGE UPLOADER</h1>
	<?php if(!empty($pagedetails[0]->left_photo)): ?>
	<div><img id='img_left' src="<?=base_url().'upload/about_header/'.$pagedetails[0]->left_photo;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-left-photo" value="<?=$pagedetails[0]->left_photo;?>" />
	<?php endif;?>
	<input type="file" name="left_photo" id="photo_left" accept="image/*" />
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
		<input id="full" name="background_color" class="colourTextValue" value="<?php if(!empty($pagedetails)){ echo $pagedetails[0]->background_color; }?>" />
    </div>
	
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

<br style="clear:both" /><br />

<script type="text/javascript">

/*
	jQuery Document ready
*/
$(document).ready(function()
{

$('.sp-preview-inner').css('background-color','<?php if(!empty($pagedetails)){ echo $pagedetails[0]->background_color; }?>');

$('.sp-thumb-light').attr("data-color", '<?php if(!empty($pagedetails)){ echo $pagedetails[0]->background_color; }?>');

$("#full").spectrum({
   color: '<?php if(!empty($pagedetails)){ echo $pagedetails[0]->background_color; }?>',
   /* flat: false,
    showInput: true,
    showInitial: true,
    allowEmpty: true,
    showAlpha: true,
    disabled: false,
    localStorageKey: true,
    showPalette: true, //
    showPaletteOnly: false,
    togglePaletteOnly: true,
    showSelectionPalette: true,//
    clickoutFiresChange: true,//
    cancelText: "cancel",
    chooseText: "choose",
    togglePaletteMoreText: "more",
    togglePaletteLessText: "less",
    containerClassName: "",
    replacerClassName: "",
    preferredFormat: false,
    maxSelectionSize: 7,
    theme: "sp-light",
    palette: [["#ffffff", "#000000", "#ff0000", "#ff8000", "#ffff00", "#008000", "#0000ff", "#4b0082", "#9400d3","#f0f8ff","#faebd7","#0ff","#7fffd4","#f0ffff","#f5f5dc","#ffebcd","#00f","#8a2be2","#a52a2a","#deb887","#ea7e5d","#5f9ea0","#7fff00","#d2691e","#ff7f50","#6495ed","#fff8dc","#dc143c","#0ff","#00008b","#008b8b","#b8860b","#a9a9a9","#006400","#bdb76b","#8b008b","#556b2f","#ff8c00","#9932cc","#8b0000","#e9967a","#8fbc8f","#483d8b","#2f4f4f","#00ced1","#9400d3","#ff1493","#00bfff","#696969","#1e90ff","#b22222","#fffaf0","#228b22","#f0f","#dcdcdc","#f8f8ff","#ffd700","#daa520","#808080","#008000","#adff2f","#808080","#f0fff0","#ff69b4","#cd5c5c","#4b0082","#fffff0","#f0e68c","#e6e6fa","#fff0f5","#7cfc00","#fffacd","#add8e6","#f08080","#e0ffff","#fafad2","#d3d3d3","#90ee90","#d3d3d3","#ffb6c1","#ffa07a","#20b2aa","#87cefa","#789","#b0c4de","#ffffe0","0f0","#32cd32","#faf0e6","#f0f","#800000","#66cdaa","#0000cd","#ba55d3","#9370db","#3cb371"]],
     selectionPalette: [],*/
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

