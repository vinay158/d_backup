<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>

<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Add: Download</h2>
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
<div class="mb-3 main-content-label page_main_heading">Add: Download</div>
<form id="blog_form" action="" method="post" enctype="multipart/form-data">


<div class="form-light-holder    d-md-flex  dual_input">
		<div class="adsUrl form-group">
			<h1>Download Name</h1>
			<input type="text" value="" name="name" id="name" class="field " placeholder="Enter your name here" style=""/>
		</div>
		<div class="linkTarget form-group">
			<h1>Category</h1>
				<select name="category" class="field" id="category">
				<?php if($is_download_thread == 1){ ?>
					<?php echo $this->query_model->getCategoryDropdownOptions('downloads',0, 0,$this->uri->segment(4)); ?>
				<?php }else{ ?>

					<?php
					if(!empty($cat)):
					foreach($cat as $cat):
					?>
					<option value="<?=$cat->cat_id?>" <?php if($this->uri->segment(4) == $cat->cat_id) echo "selected='selected'";?>><?=$cat->cat_name?></option>
					<?php
					endforeach;
					endif;
					?>
				<?php } ?>
				</select>
		</div>
</div>

<div class="form-light-holder    d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
		<h1 style="padding-bottom: 5px;">Choose a Photo</h1>
			<div class="custom-file half_width_custom_file">
				<input type="file" name="userfile" class="custom-file-input" id="customFile1"  accept="image/*" />
			<label class="custom-file-label" for="customFile">Choose file</label></div>
			
	</div>
	<div class="linkTarget form-group">
		<h1 style="padding-bottom: 5px;">File for Students</h1>
		<div class="custom-file half_width_custom_file">
			<input type="file" name="files"  class="custom-file-input" id="customFile2"  />
		<label class="custom-file-label" for="customFile">Choose file</label></div>
	</div>
</div>

<script language="javascript">
$(document).ready(function(){
$(".form-light-holder .checkbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents(".form-light-holder").children(".hidden_cb").val("0");
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents(".form-light-holder").children(".hidden_cb").val("1");
	}
})
})
</script>

<div class="form-light-holder">
	<h1>Download Description</h1>
	<textarea name="desc"></textarea>
</div>




<div class="form-white-holder" style="padding-bottom:20px;">
	<input type="hidden" value="<?='view/'.$this->uri->segment(4);?>" name="redirect" id="redirect" class="hidden_cb" />
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
