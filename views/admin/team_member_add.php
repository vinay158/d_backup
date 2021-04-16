<?php $this->load->view("admin/include/header"); ?>
<!-- end head contents -->
<!---wysiwyg editor script -->
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<!-- <script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script> -->
<!--<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>-->

<script src="js/ckeditor_full/ckeditor.js"></script>


<div class="gen-holder">
	<div class="gen-panel-holder"  style="width: 100% !important;">
	<div class="gen-panel">
		<div class="panel-title">
			<div class="panel-title-name">Add Team Member</div>
		</div>
		<div class="panel-body">
		<div class="panel-body-holder">
		<div class="form-holder">

<form id="blog_form" action="" method="post" enctype="multipart/form-data">
<script language="javascript">
$(window).load(function(){
	$.each( $( ".lightbox_or_url" ), function() {
		if($(this).attr('checked') == 'checked'){
			var radio_button_value = $(this).val();
	
			if(radio_button_value == "lightbox"){
				$('.info_url').hide();
			}
			if(radio_button_value == "url"){
				$('.info_lightbox').hide();
			}
		}
	});
	
	
});
$(document).ready(function(){
	$("#main_title").keyup(function(){
		$("#sef_title").html($(this).val());
	});
	
	$('.lightbox_or_url').click(function(){
	var radio_button_value = $(this).val();
	
	if(radio_button_value == "lightbox"){
		$('.info_url').hide();
		$('.info_lightbox').show();
	}
	if(radio_button_value == "url"){
		$('.info_lightbox').hide();
		$('.info_url').show();
	}
});
})
</script>
<div class="form-light-holder">
	<h1>Name</h1>
	<input type="text" value="" name="name" id="name" class="field" placeholder="Enter your name here"/>	
</div>

 <?php /*?><?php if($IsAllowMultiStaff){ ?>
<div class="form-light-holder">
    <h1>Location</h1>		
    <?php echo form_dropdown('location_id', $locations); ?>
</div>

<?php } ?><?php */?>

<!-- <div class="form-light-holder" style="overflow:auto;">
	<h1 style="padding-bottom: 5px;">Choose a Photo</h1>
	<input type="file" name="userfile" id="photo" accept="image/*" />
		<div>
		</div>
</div>

<div class="form-light-holder">
	<h1>Image Alt</h1>
	<input type="text" name="image_alt" value="" class="field">
</div> -->

<!-- DOJO 01/12 -->
<div class="form-light-holder">
	<h1>Designation</h1>
	<input type="text" name="designation" value="" class="field" placeholder="Enter your designation">
</div>

<!--<div class="form-light-holder">
	<h1>Year Experience</h1>
	<input type="text" name="experience" value="" class="field">
</div>-->
<!-- end code -->



<!-- <div class="form-light-holder" style="padding-bottom:30px;">
	<h1>Instructor Bio</h1>
	<textarea name="text" class="textarea" id="frm-text"></textarea>
	<textarea id="frm-text" name="text" class="ckeditor" ></textarea>
</div> -->


<div class="form-white-holder" style="padding-bottom:20px;">
<input type="hidden" value="<?php if(!empty($location_id)){ echo $location_id; } ?>" name="location_id" class="location_id" />
	<input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />
</div>
</form>



		</div>
		</div>
		</div>
	</div>
	</div>
<br style="clear:both" /><br />
<!-- recent items -->
<?php $this->load->view("admin/include/footer");?>
