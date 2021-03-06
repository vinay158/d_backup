<?php $this->load->view("admin/include/header"); ?>

<div class="az-content-body-left advanced_page custom_full_page form_module_listing_page" >
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

<?php 

	if(!empty($form_types)){ 
		foreach($form_types as $form_type){
			
?>
<?php if(!empty($form_modules[$form_type->type])): ?>
<h1 > &nbsp;&nbsp; </h1>


<div class="program_full_detail new_lisiting_block default_template" id="AlternatingFullWidth">

				<div class="mb-3 main-content-label " style="margin-top:0px !important" ><?php echo $form_type->name; ?></div>
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
								  <h4 class="az-content-title mg-b-5"><?php echo $form_type->name; ?></h4>
								 &nbsp;&nbsp;&nbsp; <p>You have <span class="total_alternating_full_width_row_<?php echo $form_type->type; ?>"><?php echo !empty($form_modules[$form_type->type]) ? count($form_modules[$form_type->type]) : 0; ?></span> Entries</p>
								</div>
								
							  </div>
							  
			<ul class="ajax_record_sortable alternating_full_width_row"  table_name="tbl_form_modules" >

			
			<?php
				$deleteBtnLimit = 1;
				if($form_type->id == 1){
					$deleteBtnLimit = 3;
				}elseif($form_type->id == 2){
					$deleteBtnLimit = 4;
				}elseif($form_type->id == 3){
					$deleteBtnLimit = 2;
				}elseif($form_type->id == 4){
					$deleteBtnLimit = 3;
				}
				$i = 1;
				foreach($form_modules[$form_type->type] as $row):
					
					$is_complate_connected = $this->query_model->checkAllFormsConnectedAutoResponder($row);
					
						$this->db->select(array('page_name'));
						$page_instances = $this->query_model->getbySpecific('tbl_form_instances','form_module_id', $row->id);
						//echo '<pre>page_instances'; print_r($page_instances); die;
				?>
				

					<li   id="menu_<?=$row->id?>" class="full_width_row_<?php echo $row->id; ?> az-contact-info-header">
						<div class="manager-item media <?php echo ($is_complate_connected == 0) ? ' connection_issue' :''; ?>">
							<div style="float:left;">
								<div class="badge-no"><?=$i?>. </div>
								
									
								<h4 class="full_width_row_heading_<?=$row->id?>"><a href="javascript:void(0)" ><?=$row->name;?> </a><em><?php echo !empty($row->connected_type) ? ' - '.$row->connected_type : '';?></em></h4>
								<?php if(!empty($page_instances)){ ?>
								<p class="listing_form_instances_box">
										<span class="heading">Page Instances: </span>
									<?php 
										$p = 1;
										foreach($page_instances as $page_instance){ ?>
										<span class="form_instances"><?php echo $page_instance->page_name; ?>
										<?php 
											if(count($page_instances) > 1 && $p < count($page_instances)){ 
												echo ',';
											} 
										?>
										</span>
									<?php $p++; } ?>
								</p>
							<?php } ?>
							</div>
							<div class="manager-item-opts">
							
							
						<nav class="nav">
							
							<?php if($user_level == 1) {?> 
							  <a href="admin/<?=$link_type;?>/edit/<?=$row->id;?>" class="badge badge-primary">Edit</a>
							  
							  <a  class="badge badge-primary ajax_record_duplicate" data-toggle="modal" data-target="#popupDuplicateItem" item_id="<?=$row->id;?>"   table_name="tbl_form_modules" item_title="<?=$row->name;?>" section_type="full_width" form_action="admin/<?=$link_type?>/duplicate_form" redirect_path="admin/<?=$link_type?>/view">Duplicate</a>
							  
							  <?php if($i > $deleteBtnLimit){ ?>
							 <a class="badge badge-primary ajax_record_delete" data-toggle="modal" data-target="#popupDeleteRecord" item_id="<?=$row->id;?>"   table_name="tbl_form_modules" item_title="<?=$row->name;?>" section_type="full_width_row_<?php echo $form_type->type; ?>">Delete</a>
							  <?php } ?>
							<?php } ?>
							
						</nav>



							</div>
						</div>
					</li>
<?php $i++; endforeach;?>	
								</ul>

	
			
						
						
				</div>
			</div>
		</div>
</div>
<?php endif;?>
<?php } } ?>
</div>	
	<input type="hidden" name="mod_type" value="<?=$link_type;?>" id="mod_type" />	
	</div>			

		
</div>
</div>
</div>
</div>
</div>
<?php $this->load->view("admin/include/footer");?>
