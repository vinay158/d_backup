<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<!-- <script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script> -->
<!--<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>-->

<script src="js/ckeditor_full/ckeditor.js"></script>


<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Add Instructor</h2>
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
<div class="mb-3 main-content-label page_main_heading">Add: Instructor</div>
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
	<input type="text" value="" name="name" id="name" class="field full_width_input" placeholder="Enter your name here"/>	
</div>

 <?php /*?><?php if($IsAllowMultiStaff){ ?>
<div class="form-light-holder">
    <h1>Location</h1>		
    <?php echo form_dropdown('location_id', $locations); ?>
</div>

<?php } ?><?php */?>

<div class="form-light-holder   d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Thumbnail Image</h1>
		<div class="custom-file half_width_custom_file">
		<input type="file" name="userfile" class="custom-file-input" id="customFile1" accept="image/*">
		<label class="custom-file-label" for="customFile">Choose file</label></div>
		
	</div>
	
	<div class="linkTarget form-group">
			<h1 style="padding-top: 5px;">Image alt text</h1>
	<input value="" name="photo_alt_text" id="" class="field" placeholder="image alt text" type="text">
		</div>
</div>

<!-- <div class="form-light-holder">
	<h1>Image Alt</h1>
	<input type="text" name="image_alt" value="" class="field">
</div> -->

<!-- DOJO 01/12 --->
<div class="form-light-holder   d-md-flex  dual_input">
		<div class="adsUrl form-group">
		<h1>Position</h1>
		<input type="text" name="position" value="" class="field">
		</div>
	
	<div class="linkTarget form-group">
		<h1>Belt Rank</h1>
		<input type="text" name="belt" value="" class="field">
	</div>
</div>



<!--<div class="form-light-holder">
	<h1>Year Experience</h1>
	<input type="text" name="experience" value="" class="field">
</div>-->
<!-- end code --->


<script language="javascript">

$(document).ready(function(){

$(".form2checkbox .checkbox2").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form2checkbox").children(".hidden_cb2").val("0");

		$('.show_lightbox_and_url').hide();
	}

	else

	{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form2checkbox").children(".hidden_cb2").val("1");
		$('.show_lightbox_and_url').show();
	}

})

})

</script>
<div class="form-light-holder form2checkbox">
	<a id="published" class="checkbox2 check-on"></a>
	<h1 class="inline">Show a lightbox or link to URL</h1>

	<input type="hidden" value="1" name="not_linked" class="hidden_cb2" />

</div>
<div class="show_lightbox_and_url">
<div class="form-light-holder">
	<div class="row row-xs align-items-center">
	
	<div class="col-md-12  mg-t-5 mg-md-t-0">
	<div class="row mg-t-10">
		<div class="col-lg-3">
		  <label class="rdiobox">
			<input type="radio" class="lightbox_or_url" name="lightbox_or_url" value="lightbox" checked="checked"  /><span> Show bio in lightbox</span>
		  </label>
		</div><!-- col-3 -->
		<div class="col-lg-3">
		  <label class="rdiobox">
			<input type="radio" class="lightbox_or_url" name="lightbox_or_url" value="url" /><span>Link to URL</span>
		  </label>
		</div><!-- col-3 -->
		
		</div>
	</div>
</div>


</div>
<div class="info_lightbox">
		
<div class="form-light-holder   d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Lightbox Image</h1>
	<div class="custom-file half_width_custom_file">
			<input type="file" name="lightbox_photo" class="custom-file-input" id="customFile2" accept="image/*">
			<label class="custom-file-label" for="customFile">Choose file</label></div>
			
	</div>
	
	<div class="linkTarget form-group">
			<h1 style="padding-top: 5px;">Image alt text</h1>
	<input value="" name="lightbox_photo_alt_text" id="" class="field" placeholder="image alt text" type="text">
		</div>
</div>


<div class="form-light-holder" style="">
	<h1>Instructor Bio</h1>
	<!-- <textarea name="text" class="textarea" id="frm-text"></textarea> -->
	<textarea id="frm-text" name="text" class="ckeditor" ></textarea>
</div>
</div>
<div class="form-light-holder info_url">
	<div class="adsUrl">
			<h1>URL</h1>
            <input type="text" value="" name="url" id="url" class="field"/>
			
	</div>
	
	
	<div class="linkTarget">
			<h1>Link Target</h1>
			<select name="target" id="target" class="field" >
			<option value="_blank" >Blank</option>
			<option value="_self">Self</option>
			</select>
	</div>
			
	
</div>
</div>



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

</div>
</div>
</div>
</div>
<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>
