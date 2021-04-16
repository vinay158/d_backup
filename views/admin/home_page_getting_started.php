<?php $this->load->view("admin/include/header"); ?>

<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->
<script src="js/new/jquery.maskMoney.js"></script>


<script language="javascript" type="text/javascript"></script>
<script src="js/ckeditor_full/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		CKEDITOR.replace(  'img_text_headline',
									{  customConfig : 'config.js' }
						);
		
		
		
		
	$(".delete_img_text_image").click(function(){
		
		//var cat_id=$('#cat_id').val();
		var type=$(this).attr('type');
		
		$('#img_bg_img_text_image_'+type).hide();		
		
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/home/deleteImgTextImage',						
		data: { type: type}					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			$("#last-img_text_image_"+type).val('');
			//setTimeout("window.location.href='admin/"+mod_type+"/edit/"+staff_id+"'",1000);
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});

	});
	
	
	});
</script>

<div class="az-content-body-left  advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Getting Started</h2>
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


<div class="mb-3 main-content-label page_main_heading">Edit: Getting Started</div>



<div class="form-light-holder">
	<h1>Headline</h1>
	
	<textarea name="headline" id="img_text_headline" class="text ckeditor"><?php echo $this->query_model->getStrReplaceAdmin($pagedetails->headline);?></textarea>
</div>

<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #1</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="image_1" class="custom-file-input " id="customFile" accept="image/*" />
	<label class="custom-file-label" for="customFile">Choose file</label>
	</div>
	<?php if(!empty($pagedetails->image_1)): ?>
	<div><img id='img_bg_img_text_image_1' src="<?=base_url().'upload/welcome_text/'.$pagedetails->image_1;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-img_text_image_1" value="<?=$pagedetails->image_1;?>" />
	<?php endif;?>
	
	<?php if(!empty($pagedetails->image_1)){ 
			echo "<a href='javascript:void(0);' class='delete_img_text_image delete_image_btn_new'  id='delete_img_text_image_1'  type='1'  number='".$pagedetails->id."'>Delete image</a>";
			}
	?>	
	 </div>
	
			<div class="linkTarget form-group">
				<h1 style="padding-top: 5px;">Image alt text</h1>
	<input value="<?php echo $this->query_model->getStrReplaceAdmin($pagedetails->image_1_alt_text); ?>" name="image_1_alt_text" id="" class="field" placeholder="image alt text" type="text">
		</div>
</div>
<div class="form-light-holder">
	<h1>Title #1</h1>
	<input type="text" name="title_1" value="<?php echo $this->query_model->getStrReplaceAdmin($pagedetails->title_1);?>" class="field full_width_input" style="">
</div>


<div class="form-light-holder">
	<h1>Description #1</h1>
	<input type="text" name="desc_1" value="<?php echo $this->query_model->getStrReplaceAdmin($pagedetails->desc_1);?>" class="field full_width_input" style="">
</div>



<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #2</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="image_2" class="custom-file-input " id="customFile1" accept="image/*" />
	<label class="custom-file-label" for="customFile">Choose file</label>
	</div>
	<?php if(!empty($pagedetails->image_2)): ?>
	<div><img id='img_bg_img_text_image_2' src="<?=base_url().'upload/welcome_text/'.$pagedetails->image_2;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-img_text_image_2" value="<?=$pagedetails->image_2;?>" />
	<?php endif;?>
	<?php if(!empty($pagedetails->image_2)){ 
			echo "<a href='javascript:void(0);' class='delete_img_text_image delete_image_btn_new'  id='delete_img_text_image_2'  type='2'  number='".$pagedetails->id."'>Delete image</a>";
			}
	?>	
	</div>
	
			<div class="linkTarget form-group">
				<h1 style="padding-top: 5px;">Image alt text</h1>
	<input value="<?php echo $this->query_model->getStrReplaceAdmin($pagedetails->image_2_alt_text); ?>" name="image_2_alt_text" id="" class="field" placeholder="image alt text" type="text">
		</div>
</div>
<div class="form-light-holder">
	<h1>Title #2</h1>
	<input type="text" name="title_2" value="<?php echo $this->query_model->getStrReplaceAdmin($pagedetails->title_2);?>" class="field full_width_input" style="">
</div>


<div class="form-light-holder">
	<h1>Description #2</h1>
	<input type="text" name="desc_2" value="<?php echo $this->query_model->getStrReplaceAdmin($pagedetails->desc_2);?>" class="field full_width_input" style="">
</div>




<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #3</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="image_3" class="custom-file-input " id="customFile1" accept="image/*" />
	<label class="custom-file-label" for="customFile">Choose file</label>
	</div>
	<?php if(!empty($pagedetails->image_3)): ?>
	<div><img id='img_bg_img_text_image_3' src="<?=base_url().'upload/welcome_text/'.$pagedetails->image_3;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-img_text_image_3" value="<?=$pagedetails->image_3;?>" />
	<?php endif;?>
	
	<?php if(!empty($pagedetails->image_3)){ 
			echo "<a href='javascript:void(0);' class='delete_img_text_image delete_image_btn_new'  id='delete_img_text_image_3'  type='3'  number='".$pagedetails->id."'>Delete image</a>";
			}
	?>	
	</div>
	
			<div class="linkTarget form-group">
				<h1 style="padding-top: 5px;">Image alt text</h1>
	<input value="<?php echo $this->query_model->getStrReplaceAdmin($pagedetails->image_3_alt_text); ?>" name="image_3_alt_text" id="" class="field" placeholder="image alt text" type="text">
		</div>
</div>

<div class="form-light-holder">
	<h1>Title #3</h1>
	<input type="text" name="title_3" value="<?php echo $this->query_model->getStrReplaceAdmin($pagedetails->title_3);?>" class="field full_width_input" style="">
</div>


<div class="form-light-holder">
	<h1>Description #3</h1>
	<input type="text" name="desc_3" value="<?php echo $this->query_model->getStrReplaceAdmin($pagedetails->desc_3);?>" class="field full_width_input" style="">
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

