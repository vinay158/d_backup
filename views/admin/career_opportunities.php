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
						
		CKEDITOR.replace(  'ckeditor_mini', 
									{ customConfig : 'mini_config.js' }
							);
				
	});
</script>

<script language="javascript">
$(window).load(function(){
	if($('.hidden_cb1').val() == 1){
		$('.carrer_opportunities_box').show();
	}else{
		$('.carrer_opportunities_box').hide();
	}
})
$(document).ready(function(){

$(".form-light-holder .checkbox1").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form-light-holder").children(".hidden_cb1").val("0");
		
		$('.carrer_opportunities_box').hide();
		
	}

	else

	{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form-light-holder").children(".hidden_cb1").val("1");
		
		$('.carrer_opportunities_box').show();
	}

})

})

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

<form id="blog_form" action="" method="post" enctype="multipart/form-data">
<div class="mb-3 main-content-label page_main_heading">Edit: <?php echo $title; ?> Page</div>
<div class="form-light-holder">
	<a id="published" class="checkbox1 <?php echo (!empty($detail) && $detail[0]->is_display == 1) ? 'check-on' : 'check-off'; ?>"></a>

	<h1 class="inline">Career Page?</h1>

	<input type="hidden" value="<?php echo (!empty($detail) && $detail[0]->is_display == 1) ? 1 : 0; ?>" name="is_display" class="hidden_cb1" />

</div>

<div class="carrer_opportunities_box">
	
	<div class="form-light-holder">
	<h1>Title</h1>
	<input type="text" value="<?php echo !empty($detail) ? $this->query_model->getStrReplaceAdmin($detail[0]->title) : 'Career Opportunities' ; ?>" name="title" id="title" class="field full_width_input" placeholder="Enter Your Page Title Here" style=""/>	
	<div class="ErrorMessage ErrorMessage_title"></div>
</div>

<!-- <div class="form-light-holder">
	<h1>Slug</h1>
	<input type="text" value="<?php echo !empty($detail) ? $detail[0]->slug : '' ; ?>" name="slug" id="slug" class="field"/>&nbsp;
	(Leave blank to use Title, or create your own (no spaces or characters))
    
</div> -->

<div class="form-light-holder" style="">
	<h1>Description</h1>
	<textarea name="description"  id="ckeditor_full" class="ckeditor" ><?php echo !empty($detail) ? $detail[0]->description : '' ; ?></textarea>
</div>

<div class="form-light-holder" style="">
	<h1>Terms & Conditions</h1>
	<textarea name="terms_conditions"  id="ckeditor_mini" class="ckeditor" ><?php echo !empty($detail) ? $detail[0]->terms_conditions : '' ; ?></textarea>
</div>

<div class="form-light-holder" style="">
<h1>Meta Title</h1>
	<textarea name="meta_title" id="frm-text"><?php echo !empty($detail) ? $detail[0]->meta_title : '' ; ?></textarea>
	
</div>
<div class="form-light-holder" style="">
	<h1>Meta Description</h1>
	<textarea name="meta_desc" class="" id="frm-text"><?php echo !empty($detail) ? $detail[0]->meta_desc  : '' ; ?></textarea>
	
</div>

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
