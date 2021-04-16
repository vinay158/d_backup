<script>
	$(document).ready(function(){
		 CKEDITOR.replace(  'ckeditor_full_desc_editor1', 
									{ customConfig : 'config.js' }
							);
	});
</script>	




<div class="modal-body edit-form">
<div class="gen-holder">

	<div class="gen-panel-holder"  style="width: 100% !important;">

	<div class="gen-panel">

		
		<div class="mb-3 main-content-label"><?php echo ucfirst($action_type); ?> Row</div>

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
	$('.pre_loader').show();
	
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
			$('.pre_loader').hide();
			$('.save_full_row_add_btn').css("pointer-events", "all");
			//$('.saveProgramButton').removeAttr("disabled");
			//alert(data);
            // your callback here
        },
        error: function (error) {
			$('.pre_loader').show();
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

	<input type="text" value="<?php echo !empty($detail) ? $detail->title : ''; ?>" name="title" id="" class="field required_field" placeholder="Enter title here"  style="width: 98%"/>

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
	<h1>Photo uploader</h1><br />
	<?php if(!empty($detail->photo)): ?>
	<div><img id='fullrow_img' src="<?php echo base_url().'upload/programs/'.$detail->photo;?>" style="width: 100px; clear:both;" /></div>
	<?php endif;?>
	<input type="file" name="userfile" field_name="fullrow_photo" class="programImage" accept="image/*"  />
	<input type="hidden" name="photo" id="fullrow_photo"  value="<?php echo !empty($detail) ? $detail->photo : ''; ?>"  />
	
	<?php if(!empty($detail->photo)){ 
			echo "<a href='javascript:void(0);' id='delete_fullrow_img' number='".$detail->id."'>Delete image</a>";
			}
	?>	
	
		<div>
		</div>
</div>



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

	<textarea type="text" name="description" id="ckeditor_full_desc_editor1" class="field ckeditor" placeholder=""  style="width: 98%"/><?php echo !empty($detail) ? $detail->description : ''; ?></textarea>


</div>
 
<input type="hidden" name="update" value="Save" class="" />
<?php if($action_type == "edit" && !empty($item_id)){ ?>
	<input type="hidden" name="item_id" value="<?php echo $item_id; ?>" class="" />
<?php } ?>
 </div>
          <div class="modal-footer">
            <div class="pre_loader" style="display:none"><img src="<?=base_url();?>assets_admin/img/pre_loader.gif"></div>
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
