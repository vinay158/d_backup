<?php $this->load->view("admin/include/header"); ?>


<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title"><?=$title?> Manager</h2>
			</div>
			
		  </div>
	  </div>
	   <div class="row row-sm program-cat-page">

          <div class="col-sm-12 col-xl-12 az-content-body-contacts"  >
			<div class="card pd-sm-20 edit-form">
	  

<div class="gen-holder">

	<div class="gen-panel-holder"  style="width: 100% !important;">
	
<div class="">

<!--<div class="btn-addentry add_entry_button"></div>-->
<h1 > &nbsp;&nbsp; </h1>


<div class="program_full_detail page-section new_lisiting_block default_template" id="AlternatingFullWidth">

				<div class="mb-3 main-content-label" >Video Training Library</div>
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
								  <h4 class="az-content-title mg-b-5">Video Training Library</h4>
								  <p>You have <span class="total_alternating_full_width_row_onlinedojo_videos"><?php echo !empty($slides) ? count($slides) : 0; ?></span> Entries</p>
								</div>
								<div>
								 <a href="admin/<?=$link_type?>/add" class="button_class btn btn-indigo ">Add Video</a>
								</div>
							  </div>
							  
			<ul class="ajax_record_sortable alternating_full_width_row"  table_name="tbl_onlinedojo_videos" >

			<?php
			$sr_testimonials=0; 
							
			if(!empty($slides)):
			 foreach($slides as $row):
			 $sr_testimonials++;
			?>


					<li   id="menu_<?=$row->id?>" class="full_width_row_<?=$row->id?> az-contact-info-header">
						<div class="manager-item media">
							<div style="float:left;">
								<div class="badge-no"><?=$sr_testimonials?>. </div>
								
									
								<h4 class="full_width_row_heading_<?=$row->id?>"><a href="javascript:void(0)" ><?php echo ucfirst(strip_tags($row->video_title)); ?>  
								<em><?php 
										$video_type = $row->video_type;
										if($row->video_type == "local_video"){
											$video_type = "Self Hosted Video";
										}
									?>
								(<?php echo str_replace('_',' ',ucfirst($video_type)); ?>)</em> </a>
								</h4>
							</div>
							<div class="manager-item-opts">
							
							
						<nav class="nav">
							 
							  <a href="javascript:void(0)"  move_video_type="video_to_album" video_id="<?=$row->id?>" class="badge badge-primary move_video_item">Move video to album</a>
							  
							  <a href="admin/onlinedojo_videos/edit/<?=$row->id?>" class="badge badge-primary">Edit</a>
							  
									<a class="badge badge-primary ajax_record_delete" data-toggle="modal" data-target="#popupDeleteRecord" item_id="<?=$row->id;?>"   table_name="tbl_onlinedojo_videos" item_title="<?=$row->video_title;?>" section_type="full_width_row_onlinedojo_videos">Delete</a>
									
									<a href="javascript:void(0)" id="unpub_<?=$row->id; ?>" class="ajax_record_publish"  table_name="tbl_onlinedojo_videos"  is_new="0">
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

						
						
				</div>
			</div>
		</div>
</div>

</div>	

<div class="">

<!--<div class="btn-addentry add_entry_button"></div>-->
<h1 > &nbsp;&nbsp; </h1>


<div class="program_full_detail page-section new_lisiting_block default_template" id="AlternatingFullWidth">

				<div class="mb-3 main-content-label" >Video Albums</div>
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
								  <h4 class="az-content-title mg-b-5">Video Albums</h4>
								  <p>You have <span class="total_alternating_full_width_row_onlinedojo_album"><?php echo !empty($blogs) ? count($blogs) : 0; ?></span> Entries</p>
								</div>
								<div>
								 <a href="admin/<?=$album_link_type;?>/add" class="button_class btn btn-indigo ">Add Video Album</a>
								</div>
							  </div>
							  
			<ul class="ajax_record_sortable alternating_full_width_row"  table_name="tbl_onlinedojo_galleryname" >

			<?php
			$sr_testimonials=0; 
							
			if(!empty($blogs)):
			 foreach($blogs as $row):
			 $sr_testimonials++;
			 
			 
			 $this->db->limit(1);
			 $this->db->select(array('id','video_id','video_type','is_cover_image','video_img_type','custom_video_thumbnail'));
			 $this->db->where('published',1);
			 $this->db->where('is_cover_image',1);
			 $coverVideo = $this->query_model->getBySpecific('tbl_onlinedojo_media', 'album',$row->id);
			
			 if(empty($coverVideo)){
				 $this->db->limit(1);
				 $this->db->order_by('pos asc, id desc');
				 $this->db->select(array('id','video_id','video_type','is_cover_image','video_img_type','custom_video_thumbnail'));
				 $this->db->where('published',1);
				 $coverVideo = $this->query_model->getBySpecific('tbl_onlinedojo_media', 'album',$row->id); 
			 }
			 //echo '<prE>coverVideo'; print_r($coverVideo); die;
			 $cover_image = base_url().'assets_admin/img/no-image.png';
			 
			 if(!empty($coverVideo)){
				
				$videoData = array('video_type'=>$coverVideo[0]->video_type,'video_id'=>trim($coverVideo[0]->video_id), 'video_img_type' => $coverVideo[0]->video_img_type,'custom_video_thumbnail'=>$coverVideo[0]->custom_video_thumbnail);
				
				$cover_image = $this->query_model->getVideoThumbnilImage($videoData);
				
				
			 }
			?>


					<li   id="menu_<?=$row->id?>" class="full_width_row_<?=$row->id?> az-contact-info-header">
						<div class="manager-item media">
							<div style="float:left;">
								<div class="badge-no"><?=$sr_testimonials?>. </div>
								
								<img src="<?php echo $cover_image; ?>" class="list_img">	
								<h4 class="full_width_row_heading_<?=$row->id?>"><a href="javascript:void(0)" >
								<?=character_limiter($row->album, 15);?>								
								</a>
								</h4>
							</div>
							<div class="manager-item-opts">
							
							
						<nav class="nav">
							 
							  <a href="admin/<?=$album_link_type."/edit/".$row->id."/26"; ?>" class="badge badge-primary">Add <?=$this->uri->segment(4) == 25 ? "Photos": "Videos";?></a>
							  
							  <a class="badge badge-primary ajax_record_delete" data-toggle="modal" data-target="#popupDeleteRecord" item_id="<?=$row->id;?>"   table_name="tbl_onlinedojo_galleryname" item_title="<?=$row->album;?>" section_type="full_width_row_onlinedojo_album">Delete</a>
									
							  <a href="javascript:void(0)" id="unpub_<?=$row->id; ?>" class="ajax_record_publish"  table_name="tbl_onlinedojo_galleryname"  is_new="0">
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

<input type="hidden" name="mod_type" value="<?=$link_type;?>" id="mod_type" />
<input type="hidden" name="mod_type" value="<?=$album_link_type;?>" id="mod_type_album" />

<?php $this->load->view("admin/include/footer");?>

<script>

$(document).ready(function(){
	
	$('body').on('keyup','.required_field', function(){
		var check = $(this).val();
		if(check == '') {
			$(this).css('border','1px solid red');
		}else{
			$(this).css('border','1px solid rgb(223,223,223)');
		}
	});
	
	$('body').on('change','.required_field', function(){
		var check = $(this).val();
		if(check == '') {
			$(this).css('border','1px solid red');
		}else{
			$(this).css('border','1px solid rgb(223,223,223)');
		}
	});
	
	
	
	$('body').on('click','.move_video_item', function(){
		
		$("#popupMoveVideoItem").modal('show');
		
		var move_video_type = $(this).attr('move_video_type');
		var video_id = $(this).attr('video_id');
		
		$('#move_video_type').val(move_video_type);
		$('#video_id').val(video_id);
	})
	
	
	$('body').on('click','.update_move_item', function(){
		
		$('.form_error_msg').hide();
		var error = 0;
		$.each($('.required_field'),function(){
			var check = $(this).val();
			if(check == '') {
				$(this).css('border','1px solid red');
				error = 1;
			}
		})
		
		if(error == 0){
			 $( "#moveVideoItemForm" ).submit();
		}else{
			$('.form_error_msg').show();
		}
	})	
})

</script>

<div id="popupMoveVideoItem" class="modal">
      <div class="modal-dialog modal-dialog-centered sortable-box" role="document">
        <div class="modal-content modal-content-demo">
          <div class="modal-header">
            <h6 class="modal-title">Move Video</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
		 <form action="admin/onlinedojo_video_albums/moveOnlineDojoVideos" method="post" id="moveVideoItemForm">
          <div class="modal-body edit-form">
            <div class="row row-xs align-items-center">
					<div class="col-md-12 mg-t-5 mg-md-t-0">
						<h1>Video Albums</h1>
						<?php 
							$this->db->where("category", 26);
							$this->db->select(array('id','album'));
							$albums = $this->query_model->getbyTable("tbl_onlinedojo_galleryname");
						?>
						<?php if(!empty($albums)){ ?>
						<select class="field required_field" name="album_id">
							<option value="">-- Select video album -- </option>
							<?php foreach($albums as $album){  ?>	
								<option value="<?php echo $album->id ?>"><?php echo $album->album ?></option>
							<?php } ?>
						</select>
						<?php } ?>
						
						 <input type="hidden" name="move_video_type" id="move_video_type"  value="video_to_album">
						 <input type="hidden" name="video_id" id="video_id"  value="0">
					</div>
					
					
				</div>
				
				
		
          </div>
          <div class="modal-footer">
			<div class=" form_error_msg" style="display:none">Please select any video ablum..</div>
			<a href="javascript:void(0)" class="btn btn-indigo update_move_item">Save</a>
          </div>
		  </form>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->