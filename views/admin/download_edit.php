<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>
<script>
	$(window).load(function(){
		var check_stand_alone_page = $('.stand_alone_page_button').val();
		if(check_stand_alone_page == 0){
			$('.stand_alone_page').hide();
		}
		$.each( $( ".radio" ), function() {
			if($(this).attr('checked') == 'checked'){
				if($(this).val() == 1){
					$('.paid_trial').show();
				} else {
					$('.paid_trial').hide();
				}
			}
		});
		
		
		var videoType = $('select.videoType option:selected').val();
	
			if(videoType == "youtube_video"){
				$('.vimeo_video').hide();
				$('.youtube_video').show();
				$('.orButton').hide();
			}
			if(videoType == "vimeo_video"){
				$('.youtube_video').hide();
				$('.vimeo_video').show();
				$('.orButton').hide();
			}
	});
	
	
$(document).ready(function(){
	$('.videoType').change(function(){
		var videoType = $(this).val();
		
		if(videoType == "youtube_video"){
			$('.vimeo_video').hide();
			$('.youtube_video').show();
			$('.orButton').hide();
		}
		if(videoType == "vimeo_video"){
			$('.youtube_video').hide();
			$('.vimeo_video').show();
			$('.orButton').hide();
		}
	});
});
</script>


<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Edit: Download</h2>
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
<div class="mb-3 main-content-label page_main_heading">Edit: Download</div>
<form id="blog_form" action="" method="post" enctype="multipart/form-data">
<?php if(!empty($details)): ?>
<?php foreach($details as $details): ?>
<div class="form-light-holder  d-md-flex  dual_input" style="">
		<div class="adsUrl form-group">
			<h1>Download Name</h1>
			<input type="text" value="<?=$details->name?>" name="name" id="name" class="field" placeholder="Enter your name here" />
		</div>
		<div class="linkTarget form-group">
		
			<h1>Category</h1>
			<select name="category" id="category" class="field" style="" >
			<?php if($is_download_thread == 1){ ?>
				<?php echo $this->query_model->getCategoryDropdownOptions('downloads',0, 0,$details->category); ?>
			<?php }else{ ?>
				<?php
				if(!empty($cat)):
				foreach($cat as $cat):
				?>
				<option value="<?=$cat->cat_id?>" <?php if($details->category == $cat->cat_id) echo "selected='selected'";?>><?=$cat->cat_name?></option>
				<?php
				endforeach;
				endif;
				?>
			<?php } ?>
			</select>
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
});

$("#delete_img").click(function(){

	var id=$('#program_id').val();
		var image_path=$('#img').attr('src');
					
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/downloads/delete',						
		data: { id : id,image_path:image_path }					
		}).done(function(msg){ 
		if(eval(msg) == 1){		
			setTimeout("window.location.href='admin/downloads/edit/"+id+"'",1000);			
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});
 });
 
 
 
$("#delete_files").click(function(){

	var id=$('#program_id').val();
				
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/downloads/delete_files',						
		data: { id : id}					
		}).done(function(msg){ 
		if(eval(msg) == 1){		
			setTimeout("window.location.href='admin/downloads/edit/"+id+"'",1000);			
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});
 });
 
	
 
})
</script>


<div class="form-light-holder   d-md-flex  dual_input" style="overflow:auto;">
		<div class="adsUrl form-group">
			<h1 style="padding-bottom: 5px;">Choose a Photo</h1>
			<div class="custom-file half_width_custom_file">
				<input type="file" name="userfile" class="custom-file-input" id="customFile1"  accept="image/*" />
			<label class="custom-file-label" for="customFile">Choose file</label></div>
			
			<?php if(!empty($details->photo)): ?>
			<div><img id="img" src="upload/downloads/<?=$details->photo;?>" style="width: 100px; clear:both;" /></div>
			<input type="hidden" name="last-photo" value="<?=$details->photo;?>" />
			<?php endif;?>
			
			<?php if($details->photo){ 
					echo "<a href='javascript:void(0);' id='delete_img' class='delete_image_btn_new' >Delete image</a>";
					}
			?>	
			</div>
		<div class="linkTarget form-group">
			<h1 style="padding-bottom: 5px;">File for Students</h1>
			<div class="custom-file half_width_custom_file">
				<input type="file" name="files"  class="custom-file-input" id="customFile2"  />
			<label class="custom-file-label" for="customFile">Choose file</label></div>
			<?php if(!empty($details->files)): ?>
			
			<?php 
				$image_Detail = explode('.',$details->files);
					if($image_Detail[1] == 'jpg' || $image_Detail[1] == 'jpeg' || $image_Detail[1] == 'png' || $image_Detail[1] == 'gif'){
			?>
			<div><img src="upload/downloads/<?=$details->files;?>" style="width: 100px; clear:both;" /></div>
			<?php } elseif($image_Detail[1] == 'pdf'){ ?>
			<img src="images/pdf_icon.png" style="width: 100px; clear:both;" />
			<?php } else { ?>
			<div><img  src="images/Files-Folders.png" style="width: 100px; clear:both;" /></div>
			<?php } ?>
			<div><?=$details->files;?></div>
			<input type="hidden" name="last_files" value="<?=$details->files;?>" />
			<?php endif;?>
			
			<?php if($details->files){ 
					echo "<a href='javascript:void(0);' id='delete_files' number='".$details->id."'>Delete File</a>";
				}
			?>	
		</div>
</div>



<div class="form-light-holder" style="">
	<h1>Download Description</h1>
	<textarea name="desc" class="" id="frm-text"><?=$details->desc;?></textarea>
</div>

<div class="form-white-holder" style="padding-bottom:20px;">
	<input type="hidden" value="<?=$details->id?>" name="id" id="program_id" class="hidden_cb" />
	<input type="hidden" value="<?=($this->uri->segment(5) && $this->uri->segment(6))?$this->uri->segment(5).'/'.$this->uri->segment(6):'';?>" name="redirect" id="redirect" class="hidden_cb" />	
	<input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />
</div>
<?php endforeach;?>
<?php endif;?>
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
