<?php $this->load->view("admin/include/header"); ?>
<div class="az-content-body-left advanced_page custom_full_page form_module_page" >
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
	<!--<div class="mb-3 main-content-label page_main_heading">Virtual Training</div>

<div class="">

<!--<div class="btn-addentry add_entry_button"></div>-->
<h1 > &nbsp;&nbsp; </h1>


<div class="program_full_detail page-section new_lisiting_block default_template" id="AlternatingFullWidth">

				<div class="mb-3 main-content-label " style="margin-top:0px !important" ><?=$title?></div>
				
				
				<div class="row row-xs align-items-center mg-b-20  alternating-row-section ">
					
					<div class="col-md-12 mg-t-5 mg-md-t-0 ">
						<div class="az-content-body ">
			
							<div class="az-mail-header">
								<div>
								  <h4 class="az-content-title mg-b-5"><?=$title?></h4>
								  <p>You have <span class="total_alternating_full_width_row"><?php echo !empty($details) ? count($details) : 0; ?></span> Entries</p>
								</div>
								<div>
								<?php if($user_level == 1) {?>
								 <a href="admin/<?=$link_type?>/add" class="button_class btn btn-indigo ">Add New</a>
								<?php } ?>
								</div>
							  </div>
							  
			<ul class=" alternating_full_width_row"  table_name="tbl_form_thankyou_pages" >

			<?php
			$sr_testimonials=0; 
			
			$notDeletedIds = array(8,9,10,12);	
			
			if(!empty($details)):
			
			 foreach($details as $row):
			 
			 $sr_testimonials++;
			 
			 $this->db->select(array('id','name'));
			 $form_instances = $this->query_model->getbySpecific('tbl_form_modules','thankyou_page_id', $row->id);
			 
			?>


					<li   id="menu_<?=$row->id?>" class="full_width_row_<?=$row->id?> az-contact-info-header">
						<div class="manager-item media">
							<div style="float:left;">
								<div class="badge-no"><?=$sr_testimonials?>. </div>
								<h4 class="full_width_row_heading_<?=$row->id?>"><a href="javascript:void(0)" ><?=$row->title;?></a></h4>
								
								<?php if(!empty($form_instances)){ ?>
								<p class="listing_form_instances_box">
										<span class="heading">Form Instances: </span>
									<?php 
										$i = 1;
										foreach($form_instances as $form_instance){ ?>
										<span class="form_instances"><?php echo $form_instance->name; ?>
										<?php 
											if(count($form_instances) > 1 && $i < count($form_instances)){ 
												echo ',';
											} 
										?>
										</span>
									<?php $i++; } ?>
								</p>
							<?php } ?>
							</div>
							<div class="manager-item-opts">
							
							
						<nav class="nav">
						
							 <?php if($user_level == 1) { ?>
							 
							  <a href="admin/<?=$link_type;?>/edit/<?=$row->id;?>" class="badge badge-primary">Edit</a>
							  
							  <?php if(!in_array($row->id,$notDeletedIds)){ ?>
							  <a class="badge badge-primary ajax_record_delete" data-toggle="modal" data-target="#popupDeleteRecord" item_id="<?=$row->id;?>"   table_name="tbl_form_thankyou_pages" item_title="<?=$row->title;?>" section_type="full_width">Delete</a>
							  <?php } ?>
							<?php } ?>
							
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
</div>
<?php $this->load->view("admin/include/footer");?>