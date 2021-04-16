<?php $this->load->view("admin/include/header"); ?>
<!--<script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script> -->
<script src="js/ckeditor_full/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		 CKEDITOR.replace(  'ckeditor_mini_sub_title', 
									{ customConfig : 'config.js' }
							);
							
		 CKEDITOR.replace(  'ckeditor_mini', 
									{ customConfig : 'config.js' }
							);
	
		CKEDITOR.replace(  'embed_video_text', 
									{ customConfig : 'config.js' }
							);
		
	});
</script>

<script>
	$(window).load(function(){
		
		$.each( $( ".image_video" ), function() {
		if($(this).attr('checked') == 'checked'){
			var radio_button_value = $(this).val();
	
			if(radio_button_value == "image"){
				$('.welcome_video').hide();
				
			}
			if(radio_button_value == "video"){
				$('.welcome_image').hide();
					
				$.each( $( ".video_img_type" ), function() {
					if($(this).attr('checked') == 'checked'){
						var video_imgradio_button_value = $(this).val();
							
						if(video_imgradio_button_value == "upload_image"){
							$('.welcome_video_image').show();
						}else{
							$('.welcome_video_image').hide();
						}
					}
				});
			}
		}
	});
	
	
		var videoType = $('select.videoType option:selected').val();
		
		if(videoType == "youtube_video"){
				$('.vimeo_video').hide();
				$('.youtube_video').show();
				$('.orButton').hide();
				$('.embed_video').hide();
			}
			if(videoType == "vimeo_video"){
				$('.youtube_video').hide();
				$('.vimeo_video').show();	
				$('.orButton').hide();
				$('.embed_video').hide();
			}
			
			
			if(videoType == "embed_video"){
				$('.youtube_video').hide();
				$('.vimeo_video').hide();
				$('.orButton').hide();
				$('.embed_video').show();
			}


		if($('.without_login_virtual_training_hidden_cb').val() == 1){
			$('.virtual_classes_button_url').hide();
		}else{
			$('.virtual_classes_button_url').show();
		}


	})
	
	
	$(document).ready(function(){
		
		$('.image_video').click(function(){
			var radio_button_value = $(this).val();
			
			if(radio_button_value == "image"){
				$('.welcome_video').hide();
				$('.welcome_image').show();
				$('.welcome_video_image').hide();
				
			}
			if(radio_button_value == "video"){
				$('.welcome_image').hide();
				$('.welcome_video').show();
					
			$.each( $( ".video_img_type" ), function() {
				if($(this).attr('checked') == 'checked'){
					var video_imgradio_button_value = $(this).val();
						
					if(video_imgradio_button_value == "upload_image"){
						$('.welcome_video_image').show();
					}else{
						$('.welcome_video_image').hide();
					}
				}
			});
				
			}
		});
		
		$('.videoType').change(function(){
		var videoType = $(this).val();
		
		if(videoType == "youtube_video"){
				$('.vimeo_video').hide();
				$('.youtube_video').show();
				$('.orButton').hide();
				$('.embed_video').hide();
			}
			if(videoType == "vimeo_video"){
				$('.youtube_video').hide();
				$('.vimeo_video').show();	
				$('.orButton').hide();
				$('.embed_video').hide();
			}
			
			
			if(videoType == "embed_video"){
				$('.youtube_video').hide();
				$('.vimeo_video').hide();
				$('.orButton').hide();
				$('.embed_video').show();
			}
});

$(".virtual_training .virtual_training_checkbox").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form-light-holder").children(".virtual_training_hidden_cb").val("0");
		
		

	}

	else{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form-light-holder").children(".virtual_training_hidden_cb").val("1");
		
		

	}

	});
	
$(".without_login_virtual_training .without_login_virtual_training_checkbox").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form-light-holder").children(".without_login_virtual_training_hidden_cb").val("0");
		$('.virtual_classes_button_url').show();
	}

	else{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form-light-holder").children(".without_login_virtual_training_hidden_cb").val("1");
		
		$('.virtual_classes_button_url').hide();

	}

	});
	
	
	$("#delete_video_img").click(function(){

		$('#img_left').hide();
		var record_id=1;
		var image_name = $(this).attr('image_name');
		
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/virtual_training/delete_img',						
		data: { record_id : record_id,image_name:image_name}					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			$('.last-photo').val('');
			//setTimeout("window.location.href='admin/"+mod_type+"/edit/"+staff_id+"'",1000);
		}
		});

	});
	
		
	})
</script>

<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Virtual Training</h2>
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

<div class="mb-3 main-content-label page_main_heading">Virtual Training</div>

<form action="" method="post"  enctype="multipart/form-data">


<div class="form-light-holder without_login_virtual_training">

        <a id="" class="without_login_virtual_training_checkbox <?php if(!empty($detail) && $detail[0]->without_login_virtual_training ==1){ echo "check-on"; }else { echo "check-off";} ?>"></a>

	<h1 class="inline"> Show on Main Site (won’t be password protected)</h1>

	<input type="hidden" value="<?php if(!empty($detail) && $detail[0]->without_login_virtual_training ==1){ echo 1; }else { echo 0;} ?>" name="without_login_virtual_training" class="without_login_virtual_training_hidden_cb" />

</div>
<div class="form-light-holder virtual_classes_button_url">
	<span class="field_title"> Virtual Classes Button URL</span>
	<input type="text" value="<?php if(!empty($detail)){ echo $this->query_model->getStrReplaceAdmin($detail[0]->virtual_classes_button_url); } ?>" name="virtual_classes_button_url"  class="field full_width_input" placeholder=""  style=""/>
	
</div>
<div class="form-light-holder ">
 <label class="ckbox">
<input type="checkbox" name="hide_virtual_classes_button" value="1" <?php if(!empty($detail) && $detail[0]->hide_virtual_classes_button ==1){ echo "checked=checked"; }else { echo "";} ?>><span>Hide Virtual Classes Button</span>
            </label>
</div>

<div class="form-light-holder">
	<span class="field_title">Heading</span>
	<input type="text" value="<?php if(!empty($detail)){ echo $this->query_model->getStrReplaceAdmin($detail[0]->title); }else{ echo 'Virtual Training'; } ?>" name="title"  class="field full_width_input" placeholder=""  style=""/>
</div>
<div class="form-light-holder" style="display:none">
	<span class="field_title">Heading description</span>
	<textarea type="text" name="sub_title" id="ckeditor_mini_sub_title" class="field ckeditor full_width_input" placeholder=""  style=""/><?php echo !empty($detail) ? $detail[0]->sub_title : '';?></textarea>
</div>


<div class="form-light-holder virtual_training">

        <a id="" class="virtual_training_checkbox <?php if(!empty($detail) && $detail[0]->show_zoom_logo ==1){ echo "check-on"; }else { echo "check-off";} ?>"></a>

	<h1 class="inline"> Show Zoom Logo?</h1>

	<input type="hidden" value="<?php if(!empty($detail) && $detail[0]->show_zoom_logo ==1){ echo 1; }else { echo 0;} ?>" name="show_zoom_logo" class="virtual_training_hidden_cb" />

</div>


<div class="form-light-holder">
	<div class="row row-xs align-items-center">
	<div class="col-md-2">
		<label class="form-label mg-b-0">IMAGE OR VIDEO</label>
	</div>
	<div class="col-md-10  mg-t-5 mg-md-t-0">
	<div class="row mg-t-10">
		<div class="col-lg-2">
		  <label class="rdiobox">
			<input type="radio" class="image_video" name="image_video" value="image" <?php if(!empty($detail) && $detail[0]->image_video == 'image'){ echo 'checked=checked'; } ?>  />
			<span>Image</span>
		  </label>
		</div><!-- col-3 -->
		<div class="col-lg-9 mg-t-20 mg-lg-t-0">
		  <label class="rdiobox">
			<input type="radio" class="image_video" name="image_video" value="video"  <?php if(!empty($detail) && $detail[0]->image_video == 'video'){ echo 'checked=checked'; } ?>  />
			<span>Video</span>
		  </label>
		</div><!-- col-3 -->
		</div>
	</div>
</div>
</div>
<div class="welcome_image">
<div class="form-light-holder" style="overflow:auto;">
	<h1>IMAGE UPLOADER</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="userfile" class="custom-file-input" id="customFile1"  accept="image/*" />
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	
	<?php if(!empty($detail) && !empty($detail[0]->photo)): ?>
	<div><img id='img_left' src="<?=base_url().'upload/slider_video/'.$detail[0]->photo;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" class="last-photo" name="last-photo" value="<?=$detail[0]->photo;?>" />
	<?php endif;?>
	
	<?php if(!empty($detail) && !empty($detail[0]->photo)){ 
			echo "<a href='javascript:void(0);'  id='delete_video_img' class='delete_image_btn_new'  image_name='".$detail[0]->photo."'>Delete image</a>";
			}
	?>
</div>

</div>


<div class="form-light-holder   d-md-flex dual_input welcome_video">

	<div class="adsUrl form-group">
		<h1>Video Type</h1>
		<select name="video_type" id="" class="field videoType" >
		<option value="youtube_video" <?php if(!empty($detail) && $detail[0]->video_type == 'youtube_video'){ echo 'selected=selected'; } ?>>Youtube Video</option>
		<option value="vimeo_video" <?php if(!empty($detail) && $detail[0]->video_type == 'vimeo_video'){ echo 'selected=selected'; } ?>  >Vimeo Video</option>
		<option value="embed_video" <?php if(!empty($detail) && $detail[0]->video_type == 'embed_video'){ echo 'selected=selected'; } ?>  >Embed Video</option>
	</select>
	
	</div>
	<div class="linkTarget form-group">
	<div class="youtube_video">
	<h1>Youtube Video</h1>
	<input type="text" name="youtube_video" value="<?php if(!empty($detail)){ echo $detail[0]->youtube_video; }?>" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://www.youtube.com/embed/UWCbfxwwC-I
	</div>
	</div>
	<span class="orButton">OR</span>
	<div class="vimeo_video">
	<h1>Vimeo Video</h1>
	<input type="text" name="vimeo_video" value="<?php if(!empty($detail)){ echo $detail[0]->vimeo_video; } ?>" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://player.vimeo.com/video/167143332
	</div>
	</div>

	

	</div>
	
</div>

<div class="form-light-holder  embed_video">
	<span class="field_title">Embed Video Html</span>
	<textarea name="embed_video_text"  id="embed_video_text"  class="ckeditor"><?php if(!empty($detail)){ echo $this->query_model->getStrReplaceAdmin($detail[0]->embed_video_text); } ?></textarea>
</div>	

<div class="form-light-holder">
	<span class="field_title">Description Title</span>
	<input type="text" value="<?php if(!empty($detail)){ echo $this->query_model->getStrReplaceAdmin($detail[0]->desc_title); }else{ echo 'Taking Virtual Classes with {school_name} is super easy!'; } ?>" name="desc_title"  class="field full_width_input" placeholder=""  style=""/>
</div>
<div class="form-light-holder">
	<span class="field_title">Description</span>
	<textarea type="text" name="desc_short" id="ckeditor_mini" class="field ckeditor full_width_input" placeholder=""  style=""/><?php echo !empty($detail) ? $detail[0]->desc_short : " I'll have Melanie write you some text for this";?></textarea>
</div>


<div class="form-new-holder">
		<input type="submit" name="update" value="Update" class="btn-save" />
</div>
</form>

			</div>

		</div>

		</div>

	</div>
	
	
<div class="">

<!--<div class="btn-addentry add_entry_button"></div>-->
<h1 > &nbsp;&nbsp; </h1>


<div class="program_full_detail page-section new_lisiting_block default_template" id="AlternatingFullWidth">

				<div class="mb-3 main-content-label" >Virtual Training Class Types</div>
				<div class="row row-xs align-items-center  mg-t-25 mg-b-5">
					<div class="col-md-12">
						<p>You may rearrange the order of the items below by dragging them above or below other item rows. Changes will automatically be saved.</p>
					</div>
					
				</div>
				
				<div class="row row-xs align-items-center mg-b-20  alternating-row-section ">
					
					<div class="col-md-12 mg-t-5 mg-md-t-0 ">
						<div class="az-content-body ">
			
							<div class="az-mail-header">
								<div>
								  <h4 class="az-content-title mg-b-5">Virtual Training Class Types</h4>
								  <p>You have <span class="total_alternating_full_width_row"><?php echo !empty($rows) ? count($rows) : 0; ?></span> Entries</p>
								</div>
								<div>
								 <a href="admin/virtual_training/add_row" class="button_class btn btn-indigo ">Add Virtual Training Class Type</a>
								</div>
							  </div>
							  
			<ul class="ajax_record_sortable alternating_full_width_row"  table_name="tbl_virtual_training_rows" >

			<?php
			$sr_testimonials=0; 
							
			if(!empty($rows)):
			 foreach($rows as $row):
			 $sr_testimonials++;
			?>


					<li   id="menu_<?=$row->id?>" class="full_width_row_<?=$row->id?> az-contact-info-header">
						<div class="manager-item media">
							<div style="float:left;">
								<div class="badge-no"><?=$sr_testimonials?>. </div>
								
									
								<h4 class="full_width_row_heading_<?=$row->id?>"><a href="javascript:void(0)" ><?=$row->class_name;?> </a></h4>
							</div>
							<div class="manager-item-opts">
							
							
						<nav class="nav">
							 
							  <a href="admin/<?=$link_type?>/edit_row/<?=$row->id;?>" class="badge badge-primary">Edit</a>
							  
									<a class="badge badge-primary ajax_record_delete" data-toggle="modal" data-target="#popupDeleteRecord" item_id="<?=$row->id;?>"   table_name="tbl_virtual_training_rows" item_title="<?=$row->class_name;?>" section_type="full_width">Delete</a>
									
									<a href="javascript:void(0)" id="unpub_<?=$row->id; ?>" class="ajax_record_publish"  table_name="tbl_virtual_training_rows"  is_new="0">
								<div class="az-toggle az-toggle-success alternate_full_width_toogle toogle_btn <?php echo ($row->published == 1) ? 'on' : '';?>" publish_type="<?php echo ($row->published == 1) ? 0 : 1;?>"><span></span>
								<input type="hidden" name="publish_type" value="<?php echo ($row->published == 1) ? 0 : 1;?>" class="publish_type" />
								</div></a>
						</nav>



							</div>
						</div>
					</li>
<?php endforeach;?>								

<?php else: ?>

<?php endif;?>
								</ul>

	<input type="hidden" name="mod_type" value="<?=$link_type;?>" id="mod_type" />		
			
						
						
				</div>
			</div>
		</div>
</div>

</div>	

	</div>			

		
</div>
</div>
</div>
</div>

<?php //$this->load->view("admin/include/conf_delete_item"); ?>
<?php $this->load->view("admin/include/footer");?>