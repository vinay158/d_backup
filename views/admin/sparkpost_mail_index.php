<?php $this->load->view("admin/include/header"); ?>

<div class="az-content-body-left advanced_page custom_full_page form_module_listing_page sparkpost_mail_flow_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title"><?=$title?></h2>
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

	if(!empty($sparkpost_mail_flows)){ 
		foreach($sparkpost_mail_flows as $sparkpost_flow){
			
?>
<h1 > &nbsp;&nbsp; </h1>


<div class="program_full_detail new_lisiting_block default_template" id="AlternatingFullWidth">

				<div class="mb-3 main-content-label " style="margin-top:0px !important" >
				<span class="flow_title_<?php echo $sparkpost_flow->id; ?>"><?php echo $sparkpost_flow->title; ?></span>
				<input type="text" value="<?php echo $sparkpost_flow->title; ?>" class="flow_title_edit_input flow_title_input_<?php echo $sparkpost_flow->id; ?>"  flow_id="<?php echo $sparkpost_flow->id; ?>" style="display:none">
				<a href="javascript:void(0)" class="flow_title_edit" flow_id="<?php echo $sparkpost_flow->id; ?>"><i class="fas fa-edit "></i></a>
				
				<span style="float:right"><a  class="duplicate_mail_flow_btn ajax_record_duplicate" data-toggle="modal" data-target="#popupDuplicateItem" item_id="<?=$sparkpost_flow->id;?>"   table_name="tbl_sparkpost_mail_flows" item_title="<?=$sparkpost_flow->title;?>" section_type="full_width" form_action="admin/<?=$link_type?>/duplicate_form" redirect_path="admin/<?=$link_type?>">Duplicate Email Flow</a>
				
				<?php if($sparkpost_flow->id != 1){ ?>
					<a id="delitem_<?=$sparkpost_flow->id?>" class="duplicate_mail_flow_btn ajax_record_delete" title='Delete <?=$sparkpost_flow->title;?>' data-toggle="modal" data-target="#popupDeleteRecord" item_id="<?=$sparkpost_flow->id;?>"   table_name="tbl_sparkpost_mail_flows" item_title="<?=$sparkpost_flow->title;?>" section_type="little_row"><i class="fa fa-trash" ></i> Delete</a>
				<?php } ?>
				</span>
				
				
				</div>
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
								  <h4 class="az-content-title mg-b-5 flow_title_<?php echo $sparkpost_flow->id; ?>">
								 <?php echo $sparkpost_flow->title; ?></h4>
								  <p>You have <span class="total_alternating_full_width_row_<?php echo $sparkpost_flow->id; ?>"><?php echo !empty($sparkpost_templates['days_template'][$sparkpost_flow->id]) ? count($sparkpost_templates['days_template'][$sparkpost_flow->id]) : 0; ?></span> Entries</p>
								</div>
								
								<?php if(isset($sparkpost_templates['days_template'][$sparkpost_flow->id]) && count($sparkpost_templates['days_template'][$sparkpost_flow->id]) <= 6){ ?>
								<div>
								 <a href="admin/<?=$link_type;?>/add_template/<?php echo $sparkpost_flow->id; ?>" class="button_class btn btn-indigo ">Add New Template</a>
								</div>
								<?php } ?>
							  </div>
							  
			<!-- ajax_record_sortable  class for sort templates--->				  
			<ul class=" alternating_full_width_row"  table_name="tbl_sparkpost_mail_templates" id="email_flow_<?php echo $sparkpost_flow->id; ?>">

			
			<?php
				$deleteBtnLimit = 1;
				$i = 1;
				foreach($sparkpost_templates['days_template'][$sparkpost_flow->id] as $row):
				
				?>
				

					<li   id="menu_<?=$row->id?>" class="full_width_row_<?php echo $row->id; ?> az-contact-info-header">
						<div class="manager-item media">
							<div style="float:left;">
								<div class="badge-no"><?=$i?>. </div>
								
									
								<h4 class="full_width_row_heading_<?=$row->id?>"><a href="javascript:void(0)" ><?=$row->title;?> </a><em><?php echo isset($template_types[$row->template_type]) ? ' - '.$template_types[$row->template_type] : '';?></em></h4>
								
								<p class="listing_form_instances_box" style="text-align: center;">
									<span>
										<span class="heading">Template ID <br/><span class="form_instances"><?php echo $row->template_id; ?></span> </span>
									</span>
								
									<span>
										<span class="heading">Unique Confirmed Opens <br/><span class="form_instances"><?php echo isset($metrics_records[$row->template_id]['count_unique_confirmed_opened']) ? $metrics_records[$row->template_id]['count_unique_confirmed_opened'] : 0; ?></span> </span>
									</span>
									
									
									<span>
										<span class="heading">Sent <br/><span class="form_instances"><?php echo isset($metrics_records[$row->template_id]['count_sent']) ? $metrics_records[$row->template_id]['count_sent'] : 0; ?></span> </span>
									</span>
									
									
									<span>
										<span class="heading">Accepted <br/><span class="form_instances"><?php echo isset($metrics_records[$row->template_id]['count_accepted']) ? $metrics_records[$row->template_id]['count_accepted'] : 0; ?></span> </span>
									</span>
									
									
									<span>
										<span class="heading">Bounces <br/><span class="form_instances"><?php echo isset($metrics_records[$row->template_id]['count_bounce']) ? $metrics_records[$row->template_id]['count_bounce'] : 0; ?></span> </span>
									</span>
									
								</p>
								
								
								
							</div>
							<div class="manager-item-opts">
							
							
						<nav class="nav">
							
							<?php if($user_level == 1) {?> 
							 
							  <a href="admin/<?=$link_type;?>/edit_template/<?php echo $row->id; ?>" class="badge badge-primary">Edit</a>
							  
							  <a  class="badge badge-primary ajax_record_duplicate" data-toggle="modal" data-target="#popupDuplicateItem" item_id="<?=$row->id;?>"   table_name="tbl_sparkpost_mail_templates" item_title="<?=$row->title;?>" section_type="full_width" form_action="admin/<?=$link_type?>/duplicate_form" redirect_path="admin/<?=$link_type?>">Duplicate</a>
							  
							  <?php //if($i > $deleteBtnLimit){ ?>
							 <a class="badge badge-primary ajax_record_delete" data-toggle="modal" data-target="#popupDeleteRecord" item_id="<?=$row->id;?>"   table_name="tbl_sparkpost_mail_templates" item_title="<?=$row->title;?>" section_type="full_width_row_<?php echo $sparkpost_flow->id; ?>">Delete</a>
							  <?php //} ?>
							<?php } ?>
							
						</nav>



							</div>
						</div>
					</li>
<?php $i++; endforeach;?>	
								</ul>
				</div>
			
			<?php if(isset($sparkpost_templates['paid_template'][$sparkpost_flow->id]) && !empty($sparkpost_templates['paid_template'][$sparkpost_flow->id])){?>	
				<div class="az-content-body ">
					<div class="az-mail-header">
								<div style="margin-top:50px">
								  <h4 class="az-content-title mg-b-5"><?php echo str_replace('opt-ins','',strtolower($sparkpost_flow->title)) .' PAID TRIAL PURCHASED'; ?></h4>
								</div>
								
							  </div>
							  
			<!-- ajax_record_sortable  class for sort templates--->				  
			<ul class=" alternating_full_width_row"  table_name="tbl_sparkpost_mail_templates" id="email_flow_paid_trial<?php echo $sparkpost_flow->id; ?>">

			
			<?php
				$deleteBtnLimit = 1;
				$i = 1;
				foreach($sparkpost_templates['paid_template'][$sparkpost_flow->id] as $row):
				
				?>
				

					<li   id="menu_<?=$row->id?>" class="full_width_row_<?php echo $row->id; ?> az-contact-info-header">
						<div class="manager-item media">
							<div style="float:left;">
								<div class="badge-no"><?=$i?>. </div>
								
									
								<h4 class="full_width_row_heading_<?=$row->id?>"><a href="javascript:void(0)" ><?=$row->title;?> </a><em><?php echo isset($template_types[$row->template_type]) ? ' - '.$template_types[$row->template_type] : '';?></em></h4>
								
								<p class="listing_form_instances_box" style="text-align: center;">
									<span>
										<span class="heading">Template ID <br/><span class="form_instances"><?php echo $row->template_id; ?></span> </span>
									</span>
								
									<span>
										<span class="heading">Unique Confirmed Opens <br/><span class="form_instances"><?php echo isset($metrics_records[$row->template_id]['count_unique_confirmed_opened']) ? $metrics_records[$row->template_id]['count_unique_confirmed_opened'] : 0; ?></span> </span>
									</span>
									
									
									<span>
										<span class="heading">Sent <br/><span class="form_instances"><?php echo isset($metrics_records[$row->template_id]['count_sent']) ? $metrics_records[$row->template_id]['count_sent'] : 0; ?></span> </span>
									</span>
									
									
									<span>
										<span class="heading">Accepted <br/><span class="form_instances"><?php echo isset($metrics_records[$row->template_id]['count_accepted']) ? $metrics_records[$row->template_id]['count_accepted'] : 0; ?></span> </span>
									</span>
									
									
									<span>
										<span class="heading">Bounces <br/><span class="form_instances"><?php echo isset($metrics_records[$row->template_id]['count_bounce']) ? $metrics_records[$row->template_id]['count_bounce'] : 0; ?></span> </span>
									</span>
									
								</p>
								
								
								
							</div>
							<div class="manager-item-opts">
							
							
						<nav class="nav">
							
							<?php if($user_level == 1) {?> 
							  <a href="admin/<?=$link_type;?>/edit_template/<?php echo $row->id; ?>" class="badge badge-primary">Edit</a>
							  
							<!--  <a  class="badge badge-primary ajax_record_duplicate" data-toggle="modal" data-target="#popupDuplicateItem" item_id="<?=$row->id;?>"   table_name="tbl_sparkpost_mail_templates" item_title="<?=$row->title;?>" section_type="full_width" form_action="admin/<?=$link_type?>/duplicate_form" redirect_path="admin/<?=$link_type?>">Duplicate</a>-->
							  
							  <?php //if($i > $deleteBtnLimit){ ?>
							 <a class="badge badge-primary ajax_record_delete" data-toggle="modal" data-target="#popupDeleteRecord" item_id="<?=$row->id;?>"   table_name="tbl_sparkpost_mail_templates" item_title="<?=$row->title;?>" section_type="full_width_row_<?php echo $sparkpost_flow->id; ?>">Delete</a>
							  <?php //} ?> 
							<?php } ?>
							
						</nav>



							</div>
						</div>
					</li>
<?php $i++; endforeach;?>	
								</ul>
				</div>
			<?php } ?>	
				
				
			</div>
		</div>
</div>
<?php } } ?>
</div>	
	<input type="hidden" name="mod_type" value="<?=$link_type;?>" id="mod_type" />	
	</div>			

		
</div>
</div>
</div>
</div>
</div>

<script>
	$(document).ready(function(){
		$('body').on('click','.flow_title_edit',function(){
			var flow_id = $(this).attr('flow_id');
			
			$('.flow_title_input_'+flow_id).toggle('show');
			$('.flow_title_'+flow_id).toggle('hide');
			
		})
		
		$('body').on('keyup','.flow_title_edit_input',function(){
			var flow_id = $(this).attr('flow_id');
			var new_title = $(this).val();
			
			$.ajax({ 					
			type: 'POST',						
			url: "admin/sparkpost_mail/ajax_update_flow_title",						
			data: { flow_id : flow_id,title:new_title,'action':'update_title'}					
			}).done(function(msg){ 
			if(msg == 1){
				$('.flow_title_'+flow_id).html(new_title);
			}
			else{
				alert("Oops! Something went wrong!");
				return false;
						
			}
		});
		})
		
		
		/*$( ".flow_title_edit_input" ).mouseout(function() {
			$.each($('.flow_title_edit'),function(){
				var flow_id = $(this).attr('flow_id');
			
				$('.flow_title_input_'+flow_id).hide();
				$('.flow_title_'+flow_id).show();
			})
		});*/
		
		
	})
</script>
<?php $this->load->view("admin/include/footer");?>
