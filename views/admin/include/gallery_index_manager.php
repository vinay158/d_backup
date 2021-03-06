<style>
.manager-items .manager-item{
	min-height: 49px !important;
}
</style>

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

	<div class="gen-panel">

		
		<div class="panel-body">

		<div class="panel-body-holder">

		<div class="form-holder">

	<div class="mb-3 main-content-label page_main_heading"><?=$title?> Manager</div>
	
					<form action="<?=base_url()?>admin/offers/editStudentPageTitle" method="post">

					<div class="form-light-holder">
					    	<span class="field_title">Gallery/Video Head Title</span><br />
					       <input type="text" name="title"  class="field full_width_input" required="" value="<?= !empty($page_title)? $page_title[0]->title:''; ?>" style="" />&nbsp;
					       <input type="hidden" name="id" value="7"  />
					       <input type="hidden" name="redirect" value="admin/gallery/view/26" />
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

				<div class="mb-3 main-content-label" ><?=$title?></div>
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
								  <h4 class="az-content-title mg-b-5"><?=$title?></h4>
								  <p>You have <span class="total_alternating_full_width_row"><?php echo !empty($blogs) ? count($blogs) : 0; ?></span> Entries</p>
								</div>
								<div>
								 <a href="admin/<?=$link_type?>/add/<?=$this->uri->segment(4);?>" class="button_class btn btn-indigo ">Add Add Video Album</a>
								</div>
							  </div>
							  
			<ul class="ajax_record_sortable alternating_full_width_row"  table_name="tblgalleryname" >

			<?php
			$sr_testimonials=0; 
							
			if(!empty($blogs)):
			 foreach($blogs as $row):
			 $sr_testimonials++;
			 
					$this->db->limit(1);
					 $this->db->select(array('id','video_id','video_type','is_cover_image','video_img_type','custom_video_thumbnail'));
					 $this->db->where('is_cover_image',1);
					 $this->db->where('published',1);
					 $coverVideo = $this->query_model->getBySpecific('tblmedia', 'album',$row->id);
					
					if(empty($coverVideo)){
						 $this->db->limit(1);
						 $this->db->order_by('pos asc, id desc');
						 $this->db->select(array('id','video_id','video_type','is_cover_image','video_img_type','custom_video_thumbnail'));
						 $this->db->where('published',1);
						 $coverVideo = $this->query_model->getBySpecific('tblmedia', 'album',$row->id); 
					 }
					 
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
								
								<img src="<?php echo !empty($cover_image) ? $cover_image : base_url().'assets_admin/img/no-image.png'?>" class="list_img">		
								<h4 class="full_width_row_heading_<?=$row->id?>"><a href="javascript:void(0)" ><?=character_limiter($row->album, 15);?></a></h4>
							</div>
							<div class="manager-item-opts">
							
							
						<nav class="nav">
							 
							  <a href="admin/<?=$link_type."/edit/".$row->id."/".$this->uri->segment(4); ?>" class="badge badge-primary">Add <?=$this->uri->segment(4) == 25 ? "Photos": "Videos";?></a>
							  
									<a class="badge badge-primary ajax_record_delete" data-toggle="modal" data-target="#popupDeleteRecord" item_id="<?=$row->id;?>"   table_name="tblgalleryname" item_title="<?=$row->album;?>" section_type="full_width">Delete</a>
									
									<a href="javascript:void(0)" id="unpub_<?=$row->id; ?>" class="ajax_record_publish"  table_name="tblgalleryname"  is_new="0">
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

	<!------- include modal for category ----------->
	<?php //$this->load->view("admin/include/cat-modal"); ?>
	<!--------- end modal for category -------------->
	
	<!------- include modal for category ----------->
	<?php $this->load->view("admin/include/confirmation-modal"); ?>
	<!--------- end modal for category -------------->