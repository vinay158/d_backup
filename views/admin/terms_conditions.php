<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<!--<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>-->
<script src="js/ckeditor_full/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		
	
		CKEDITOR.replace(  'ckeditor_full',
									{  customConfig : 'config.js' }
						);
				
	});
</script>
<div class="az-content-body-left  advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title"><?php echo $title; ?> Page</h2>
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
<div class="mb-3 main-content-label page_main_heading">Edit: <?php echo $title; ?> Page</div>
<form id="blog_form" action="" method="post" enctype="multipart/form-data">

<div class="form-light-holder">
	<h1>Title</h1>
	<input type="text" value="<?php echo !empty($detail) ? $this->query_model->getStrReplaceAdmin($detail[0]->title) : '' ; ?>" name="title" id="title" class="field full_width_input" placeholder="Enter Your Page Title Here" />	
	<div class="ErrorMessage ErrorMessage_title"></div>
</div>

<div class="form-light-holder">
	<h1>Slug</h1>
	<input type="text" value="<?php echo !empty($detail) ? $detail[0]->slug : '' ; ?>" name="slug" id="slug" class="field full_width_input"/>
	
	<span>(Leave blank to use Title, or create your own (no spaces or characters))</span>
    
</div>

<div class="form-light-holder" style="">
	<h1>Description</h1>
	<textarea name="description"  id="ckeditor_full" class="ckeditor" ><?php echo !empty($detail) ? $detail[0]->description : '' ; ?></textarea>
</div>
<div class="form-light-holder" style="">
<h1>Meta Title</h1>
	<textarea name="meta_title" id="frm-text"><?php echo !empty($detail) ? $detail[0]->meta_title : '' ; ?></textarea>
	
</div>
<div class="form-light-holder" style="">
	<h1>Meta Description</h1>
	<textarea name="meta_desc" class="" id="frm-text"><?php echo !empty($detail) ? $detail[0]->meta_desc  : '' ; ?></textarea>
	
</div>

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

<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>
