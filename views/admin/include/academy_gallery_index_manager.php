<script src="js/ckeditor_full/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		<?php 
			if(!empty($week_academy_pages)){
				
				foreach($week_academy_pages as $week_academy_page){ 
		?>
		 CKEDITOR.replace(  'ckeditor_mini_sub_title_<?php echo $week_academy_page->id ?>', 
									{ customConfig : 'config.js' }
							);
							
			<?php } } ?>
	});
</script>
<style>
.manager-items .manager-item{
	min-height: 49px !important;
}
</style>

<script>
$(document).ready(function(){
	
	$(".without_login_virtual_training .without_login_virtual_training_checkbox").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form-light-holder").children(".without_login_virtual_training_hidden_cb").val("0");
	}

	else{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form-light-holder").children(".without_login_virtual_training_hidden_cb").val("1");
		

	}

	});
	
	
});

</script>
<div class="az-content-body-left advanced_page custom_full_page academy_gallery_page" >
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

	
<?php if(!empty($week_academy_pages)){ ?>
<form action="<?=base_url()?>admin/academy_videos/duplicateAcademySection" method="post">
	<div class="" style="margin-left:30px">
		<select name="week_academy_id" class="field" required>
		<option value="">-Select section-</option>
		<?php foreach($week_academy_pages as $week_academy_page){ ?>
			<option value="<?php echo $week_academy_page->id; ?>"><?php echo $week_academy_page->title; ?></option>
		<?php } ?>
		</select>
		
		
	</div>
	<div class="" style="margin-left:30px">
		<input type="submit" name="update" value="Duplicate Section" class="btn-save" style="margin-top:10px !important;width:200px !important"  onclick="return confirm('Are you sure you want to duplicate this section?')" />
	</div>
</form>
	<?php } ?>
	</div>

	</div>

	</div>

</div>
	

<div class="">

<!--<div class="btn-addentry add_entry_button"></div>-->
<h1 > &nbsp;&nbsp; </h1>	
<?php 
	if(!empty($week_academy_pages)){
		$i = 1;
		foreach($week_academy_pages as $week_academy_page){
			
			$this->db->order_by("pos", "ASC");
			$this->db->where("week_academy_id", $week_academy_page->id);
			$blogs = $this->query_model->getbySpecific("tbl_academy_galleryname", "category", $this->uri->segment(4));
			
?>
<div class="panel-body">
				<div class="panel-body-holder manager">
					<div class="form-holder">

					<form action="<?=base_url()?>admin/offers/editStudentAcademyPageTitle" method="post">
<?php if($i == 1){ ?>
<div class="mb-3 main-content-label page_main_heading">8 Week academy</div>
<div class="form-light-holder without_login_virtual_training">

        <a id="" class="without_login_virtual_training_checkbox <?php if(!empty($academy_videos) && $academy_videos[0]->academy_videos ==1){ echo "check-on"; }else { echo "check-off";} ?>"></a>

	<span class="field_title"> &nbsp; 8 Week academy</span>

	<input type="hidden" value="<?php if(!empty($academy_videos) && $academy_videos[0]->academy_videos ==1){ echo 1; }else { echo 0;} ?>" name="academy_videos" class="without_login_virtual_training_hidden_cb" />

</div>
<input type="hidden" value="1" name="is_update_academy_videos">
<?php }else{ ?>
<div class="mb-3 main-content-label page_main_heading">#<?php echo $i; ?> Section <span style="float:right"><a href="<?php echo base_url().'admin/academy_videos/deleteSection/'.$week_academy_page->id ?>" class="delete_row_btn"  onclick="return confirm('Are you sure you want to delete this section?')"> Delete Section</a></span></div>


<?php } ?>
					<div class="form-light-holder">
					    	<span class="field_title">Gallery/Video Head Title</span><br />
					       <input type="text" name="title" required="" value="<?= !empty($week_academy_page)? $week_academy_page->title:''; ?>" class="field full_width_input" style="" />&nbsp;
					       <input type="hidden" name="id" value="8"  />
					       <input type="hidden" name="redirect" value="admin/academy_videos/view/26" />
					</div>
					
					<div class="form-light-holder">
	<span class="field_title">Description</span>
	<textarea type="text" name="academy_videos_desc" id="ckeditor_mini_sub_title_<?php echo $week_academy_page->id ?>" class="field ckeditor full_width_input" placeholder=""  style=""/><?php echo (!empty($week_academy_page) && !empty($week_academy_page->description)) ? $week_academy_page->description : '';?></textarea>
</div>

<div class="form-light-holder">
					    	<span class="field_title">Sort Number</span><br />
					       <input type="text" name="pos" required="" value="<?= !empty($week_academy_page)? $week_academy_page->pos:''; ?>" />&nbsp;
					</div>
				
<div class="form-light-holder academy_section_<?php echo $week_academy_page->id ?>">

        <a id="" class="academy_section_checkbox_<?php echo $week_academy_page->id ?> <?php if(!empty($week_academy_page) && $week_academy_page->published ==1){ echo "check-on"; }else { echo "check-off";} ?>"></a>

	<span class="field_title"> &nbsp; Published ?</span>

	<input type="hidden" value="<?php if(!empty($week_academy_page) && $week_academy_page->published ==1){ echo 1; }else { echo 0;} ?>" name="published" class="academy_section_hidden_cb_<?php echo $week_academy_page->id ?>" />

</div>
					
<input type="hidden" value="<?php echo $week_academy_page->id ?>" name="week_academy_id" >

					<div class="form-new-holder">
					    	<input type="submit" name="update" value="Update" class="btn-save" />
					</div>

					</form>
					
					<script>
							$(document).ready(function(){
								
								$(".academy_section_<?php echo $week_academy_page->id ?> .academy_section_checkbox_<?php echo $week_academy_page->id ?>").click(function(){

								if($(this).hasClass("check-on")){

									$(this).removeClass("check-on");

									$(this).addClass("check-off");

									$(this).parents(".form-light-holder").children(".academy_section_hidden_cb_<?php echo $week_academy_page->id ?>").val("0");
								}

								else{

									$(this).removeClass("check-off");

									$(this).addClass("check-on");

									$(this).parents(".form-light-holder").children(".academy_section_hidden_cb_<?php echo $week_academy_page->id ?>").val("1");
									

								}

								});
							})
						</script>
		</div>
		</div>
		</div>


					<div class="">

<!--<div class="btn-addentry add_entry_button"></div>-->
<h1 > &nbsp;&nbsp; </h1>


<div class="program_full_detail page-section new_lisiting_block default_template" id="AlternatingFullWidth">

				<!--<div class="mb-3 main-content-label" >Virtual Training Class Types</div>-->
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
								  <p>You have <span class="total_alternating_full_width_row_<?php echo $week_academy_page->id ?>"><?php echo !empty($blogs) ? count($blogs) : 0; ?></span> Entries</p>
								</div>
								<div>
								 <a href="admin/<?=$link_type?>/add/<?=$this->uri->segment(4);?>/<?=$week_academy_page->id;?>" class="button_class btn btn-indigo ">Add Video Album</a>
								</div>
							  </div>
							  
				<ul class="ajax_record_sortable alternating_full_width_row"  table_name="tbl_academy_galleryname" >

				<?php
				$sr_testimonials=0; 
								
				if(!empty($blogs)):
				 foreach($blogs as $row):
				 $sr_testimonials++;
				?>


						<li   id="menu_<?=$row->id?>" class="full_width_row_<?=$row->id?> az-contact-info-header">
							<div class="manager-item media">
								<div style="float:left;">
									<div class="badge-no"><?=$sr_testimonials?>. </div>
									
									<img src="<?php echo !empty($row->cover) ? $row->cover : base_url().'assets_admin/img/no-image.png'?>" class="list_img">	
									<h4 class="full_width_row_heading_<?=$row->id?>"><a href="javascript:void(0)" ><?=character_limiter($row->album, 15);?> </a></h4>
								</div>
								<div class="manager-item-opts">
								
								
							<nav class="nav">
								 
								  <a href="admin/<?=$link_type?>/edit/<?=$row->id."/".$this->uri->segment(4); ?>" class="badge badge-primary">Add <?=$this->uri->segment(4) == 25 ? "Photos": "Videos";?></a>
								  
										<a class="badge badge-primary ajax_record_delete" data-toggle="modal" data-target="#popupDeleteRecord" item_id="<?=$row->id;?>"   table_name="tbl_academy_galleryname" item_title="<?=$row->album;?>" section_type="full_width_row_<?php echo $week_academy_page->id; ?>">Delete</a>
										
										<a href="javascript:void(0)" id="unpub_<?=$row->id; ?>" class="ajax_record_publish"  table_name="tbl_academy_galleryname"  is_new="0">
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
	<?php $i++; } } ?>
		</div>
	</div>



</div>	
</div>			
</div>
</div>
</div>
</div>
<?php //$this->load->view("admin/include/conf_delete_item"); ?>
	<!------- include modal for category ----------->
	<?php //$this->load->view("admin/include/cat-modal"); ?>
	<!--------- end modal for category -------------->
	
	<!------- include modal for category ----------->
	<?php $this->load->view("admin/include/confirmation-modal"); ?>
	<!--------- end modal for category -------------->