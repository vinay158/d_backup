<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<!-- <script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script> -->
<!--<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>-->
<script src="js/ckeditor_full/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		 CKEDITOR.replace(  'ckeditor_mini', 
									{ customConfig : 'mini_config.js' }
							);
	
	});
</script>
<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title"><?php echo $title; ?></h2>
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


<div class="mb-3 main-content-label page_main_heading"><?php echo $title; ?></div>

<form id="blog_form" action="" method="post" enctype="multipart/form-data">
<script language="javascript">
$(document).ready(function(){
	$("#main_title").keyup(function(){
		$("#sef_title").html($(this).val());
	})
})
</script>
<div class="form-light-holder">
	<h1>Name</h1>
	<input type="text" value="" name="name" id="name" class="field full_width_input" placeholder="Enter your name here"/>	
</div>

<!--<div class="form-light-holder" style="overflow:auto;">
	<h1 style="padding-bottom: 5px;">Choose a Photo</h1>
	<input type="file" name="userfile" id="photo" accept="image/*" />
		<div>
		</div>
</div>-->

<div class="form-light-holder">
	<h1>Title</h1>
	<input type="text" name="title" value="" class="field full_width_input">
</div>


<div class="form-light-holder " style="overflow:auto;">
	<h1 style="padding-bottom: 5px;">Choose a Photo</h1>
		<div class="custom-file half_width_custom_file">
			<input type="file" name="userfile" class="custom-file-input" id="customFile1" accept="image/*">
			<label class="custom-file-label" for="customFile">Choose file</label></div>
		<p><i>Recommended image size: 250 x 250</i></p>
</div>

<div class="form-light-holder" style="">
	<!-- <textarea name="text" class="textarea" id="frm-text"></textarea> -->
	<h1>Testimonial</h1>
	<textarea name="text" class="ckeditor" id="ckeditor_mini" ></textarea>
	<p><i>Character Limit 650 characters  </i></p>
</div>


<div class="form-white-holder" style="padding-bottom:20px;">
	<input type="hidden" name="location_id" value="<?php echo $location_id; ?>">
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
