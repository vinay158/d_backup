<script>
	$(document).ready(function(){
		 CKEDITOR.replace(  'ckeditor_full_desc_editor1', 
									{ customConfig : 'config.js' }
							);
							
							
		
							
		<?php if($form_type == "little_row" ){ ?>					
			
			CKEDITOR.replace(  'ckeditor_littlerow_title', 
									{ customConfig : 'config.js' }
							);
		<?php } ?>
		
		
		
	});
	
	
</script>	




<div class="modal-body edit-form">
<div class="gen-holder">

	<div class="gen-panel-holder"  style="width: 100% !important;">

	<div class="gen-panel">

		
		<!--<div class="mb-3 main-content-label"><?php echo ucfirst($action_type); ?> Row</div> -->

		<div class="panel-body">

		<div class="panel-body-holder">

		<div class="form-holder">





<script language="javascript">



$(document).ready(function(){

	$("#main_title").keyup(function(){

		$("#sef_title").html($(this).val());

	})


// upload image by ajax
$('body').on('change','.programImage',function(){
	
	var file = $(this)[0].files[0];
	var field_name = $(this).attr('field_name');
	var upload = new Upload(file);
	
	upload.doUpload(field_name);
		
})



	var Upload = function (file) {
    this.file = file;
};

Upload.prototype.getType = function() {
    return this.file.type;
};
Upload.prototype.getSize = function() {
    return this.file.size;
};
Upload.prototype.getName = function() {
	var uniqueNumber = new Date().getTime(); 
	var imageName = uniqueNumber+this.file.name;
	//alert(imageName+'==>'+uniqueNumber);
    return imageName;
};
Upload.prototype.doUpload = function (field_name) {
	$('.save_full_row_add_btn').css("pointer-events", "none");
	$('.upload_img_pre_loader').show();
	
    var that = this;
    var formData = new FormData();

    // add assoc key values, this will be posts values
    formData.append("file", this.file, this.getName());
    formData.append("upload_file", true);
	
	//$("#"+field_name).val(this.getName());
	
    $.ajax({
        type: "POST",
        url: "admin/programs/ajaxSaveFullRowImage",
        xhr: function () {
            var myXhr = $.ajaxSettings.xhr();
            if (myXhr.upload) {
				myXhr.upload.addEventListener('progress', that.progressHandling, false);
            }
            return myXhr;
        },
        success: function (data) {
			$("#"+field_name).val(data);
			$('.upload_img_pre_loader').hide();
			$('.save_full_row_add_btn').css("pointer-events", "all");
			//$('.saveProgramButton').removeAttr("disabled");
			//alert(data);
            // your callback here
        },
        error: function (error) {
			$('.upload_img_pre_loader').show();
			$('.save_full_row_add_btn').css("pointer-events", "none");
			//$('.saveProgramButton').removeAttr("disabled");
            // handle error
        },
        async: true,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        timeout: 60000
    });
};

Upload.prototype.progressHandling = function (event) {
	
    
};
	
	
$("#delete_fullrow_img").click(function(){

		$('#fullrow_img').hide();
		$(this).hide();
		
		var id=$(this).attr('number');
		
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/programs/deleteProgramRowImage',						
		data: { id : id}					
		}).done(function(msg){ 
		if(msg == 1){
			$('#fullrow_photo').val('');
			
		}
		});

	});
	

	
})
</script>
<div class=" form_error_msg" style="display:none">Please fill required fields..</div>

<div class="form-light-holder">

	<h1>Title</h1>

<?php if($form_type == "full_width_row"){ ?>
		<input type="text" value="<?php echo !empty($detail) ? $detail->title : ''; ?>" name="title" id="" class="field required_field full_width_input" placeholder="Enter title here"  style=""/>
<?php }elseif($form_type == "little_row" ){ ?>
		<textarea type="text" name="title" id="ckeditor_littlerow_title" class="field ckeditor full_width_input" placeholder=""  style=""/></textarea>
		
		<span class="ckfull_littlerow_title" style="display:none"><?php echo !empty($detail) ? $detail->title : ''; ?></span>
<?php } ?>
	
</div>

<div class="form-light-holder">

	<h1>Photo on Right/ Left</h1>

	<select name="photo_side" class="field required_field">
		<option value="">-select-</option>
		<option value="right" <?php echo (!empty($detail) && $detail->photo_side == "right") ?  'selected=selected' : ''; ?>>Photo on Right</option>
		<option value="left" <?php echo (!empty($detail) && $detail->photo_side == "left") ?  'selected=selected' : ''; ?>>Photo on Left</option>
	</select>

</div>
<div class="form-light-holder" style="overflow:auto;">
	<h1>Photo uploader</h1>
	<div class="adsUrl  form-group" style="width:90%">
	<div class="custom-file">
		<input type="file" name="userfile" field_name="fullrow_photo" class="programImage custom-file-input" id="customFileAltImg" accept="image/*"  />
		<input type="hidden" name="photo" id="fullrow_photo"  value="<?php echo !empty($detail) ? $detail->photo : ''; ?>"  />		
		<label class="custom-file-label" for="customFile">Choose file</label>
	</div>
	</div>
	<div class="linkTarget  form-group">
<div class="upload_img_pre_loader" style="display:none"><img src="<?=base_url();?>assets_admin/img/pre_loader.gif"></div>
</div>

	<?php if(!empty($detail->photo)): ?>
	<div><img id='fullrow_img' src="<?php echo base_url().'upload/programs/'.$detail->photo;?>" style="width: 100px; clear:both;" /></div>
	<?php endif;?>
	
	
	
	<?php if(!empty($detail->photo)){ 
			echo "<a href='javascript:void(0);'  class='delete_image_btn_new'  id='delete_fullrow_img' number='".$detail->id."'>Delete image</a>";
			}
	?>	
	
		<div>
		</div>
</div>

<?php if($form_type == "little_row"){ ?>
<div class="form-light-holder">
		<h1 style="padding-top: 5px;">Image alt text</h1>
		<input value="<?php echo !empty($detail) ? $detail->photo_alt_text : ''; ?>" name="photo_alt_text" id="" class="field" placeholder="image alt text" type="text">
		</div>
		
<div class="form-light-holder">
	<h1>Image Top Spacing</h1>
	<input type="text" name="img_top_spacing" id="img_top_spacing" class="field  img_top_spacing" placeholder=""  style="width: 20%" value="<?php echo !empty($detail) ? $detail->img_top_spacing : ''; ?>"/> <span style="font-size:15px"><strong>px</strong></span><br/>
	<em>Note: Please use only integer or float value. don't use "px" in input field</em>
	
</div>
<?php } ?>

 <div class="form-light-holder">
	<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs_afull'>
    <div id='docs_content_afull'>
		<input id="full_colorpicker_opacity_afull" name="background_color" class="colourTextValueAfull" value="<?php echo !empty($detail) ? $detail->background_color : ''; ?>" />
    </div>
	
 </div>
 </div> 

 



<div class="form-light-holder">

	<h1>Content</h1>

	<textarea type="text" name="description" id="ckeditor_full_desc_editor1" class="field ckeditor full_width_input" placeholder=""  style=""/></textarea>

	<span class="ckfull_desc_editor1" style="display:none"><?php echo !empty($detail) ? $detail->description : ''; ?></span>
</div>
 
<input type="hidden" name="update" value="Save" class="" />
<?php if($action_type == "edit" && !empty($item_id)){ ?>
	<input type="hidden" name="item_id" value="<?php echo $item_id; ?>" class="" />
<?php } ?>
<input type="hidden" name="table_name" value="<?php echo $table_name; ?>" class="" />
<input type="hidden" name="form_type" id="alt_row_form_type" value="<?php echo $form_type; ?>" class="" />
 </div>
          <div class="modal-footer">
            
			<a href="javascript:void(0)" class="btn btn-indigo save_full_row_add_btn">Save</a>
          </div>



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



$("#full_colorpicker_opacity_afull").spectrum({
   color: '',
   
});

$('.btn-save').click(function(){
	//var bg_color = $('.sp-thumb-active').data("color");
	var bg_color_afull = $('#docs_afull').find('.sp-preview-inner').css("background-color");
	//alert(bg_color); return false;
	$('.colourTextValueAfull').val(bg_color_afull);
});
	
	
});
</script>


<!------------ recent items ----------------->
