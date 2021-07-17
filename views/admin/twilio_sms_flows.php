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

	if(!empty($twilio_sms_flows)){ 
		foreach($twilio_sms_flows as $twilio_sms_flow){
			
?>
<h1 > &nbsp;&nbsp; </h1>


<div class="program_full_detail new_lisiting_block default_template" id="AlternatingFullWidth">

				<div class="mb-3 main-content-label " style="margin-top:0px !important" >
				<span class="flow_title_<?php echo $twilio_sms_flow->id; ?>"><?php echo $twilio_sms_flow->title; ?></span>
				<input type="text" value="<?php echo $twilio_sms_flow->title; ?>" class="flow_title_edit_input flow_title_input_<?php echo $twilio_sms_flow->id; ?>"  flow_id="<?php echo $twilio_sms_flow->id; ?>" style="display:none">
				<a href="javascript:void(0)" class="flow_title_edit" flow_id="<?php echo $twilio_sms_flow->id; ?>"><i class="fas fa-edit "></i></a>
				
				<span style="float:right">
				
				<?php if(!empty($pages_list)){ ?>
					<select class="field page_list_dropdown flow_page_url"  flow_id="<?php echo $twilio_sms_flow->id; ?>">
						
						<?php if($twilio_sms_flow->id == 1){ ?>
							<option value="all_forms"  <?php echo ($twilio_sms_flow->page_url == "all_forms") ? 'selected=selected' : ''; ?>>All Forms</option>
						<?php }else{ ?>
							<option value="">--Select Page--</option>
							<?php foreach($pages_list as $key => $pages){ ?>
								<option value=""><?php echo isset($form_types_list[$key]) ? $form_types_list[$key] : ''; ?></option>
								<?php foreach($pages as $url => $page_name){ 
										$page_url = !empty($twilio_sms_flow->action_id) ? $twilio_sms_flow->page_url.'~'.$twilio_sms_flow->action_id : $twilio_sms_flow->page_url;
										
								?>
									<option value="<?php echo $url; ?>" <?php echo ($page_url == $url) ? 'selected=selected' : ''; ?>><?php echo $page_name; ?></option>
								<?php } ?>
							<?php } ?>
						<?php } ?>
					</select>
				<?php } ?>
				<a  class="duplicate_mail_flow_btn ajax_record_duplicate" data-toggle="modal" data-target="#popupDuplicateItem" item_id="<?=$twilio_sms_flow->id;?>"   table_name="twilio_sms_flows" item_title="<?=$twilio_sms_flow->title;?>" section_type="full_width" form_action="admin/<?=$link_type?>/duplicate_form" redirect_path="admin/<?=$link_type?>">Duplicate SMS Flow</a>
				
				<?php if($twilio_sms_flow->id != 1){ ?>
					<a id="delitem_<?=$twilio_sms_flow->id?>" class="duplicate_mail_flow_btn ajax_record_delete" title='Delete <?=$twilio_sms_flow->title;?>' data-toggle="modal" data-target="#popupDeleteRecord" item_id="<?=$twilio_sms_flow->id;?>"   table_name="twilio_sms_flows" item_title="<?=$twilio_sms_flow->title;?>" section_type="little_row"><i class="fa fa-trash" ></i> Delete</a>
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
								  <h4 class="az-content-title mg-b-5 flow_title_<?php echo $twilio_sms_flow->id; ?>">
								 <?php echo $twilio_sms_flow->title; ?></h4>
								  <p>You have <span class="total_alternating_full_width_row_<?php echo $twilio_sms_flow->id; ?>"><?php echo !empty($twilio_sms_templates['days_template'][$twilio_sms_flow->id]) ? count($twilio_sms_templates['days_template'][$twilio_sms_flow->id]) : 0; ?></span> Entries</p>
								</div>
								<div>
								 <a href="admin/<?=$link_type;?>/add_template/<?php echo $twilio_sms_flow->id; ?>" class="button_class btn btn-indigo ">Add New Template</a>
								</div>
							  </div>
							  
			<!-- ajax_record_sortable  class for sort templates--->				  
			<ul class=" alternating_full_width_row"  table_name="tbl_twilio_sms_templates" id="sms_flow_<?php echo $twilio_sms_flow->id; ?>">

			
			<?php
				$deleteBtnLimit = 1;
				$i = 1;
				foreach($twilio_sms_templates['days_template'][$twilio_sms_flow->id] as $row):
				
				?>
				

					<li   id="menu_<?=$row->id?>" class="full_width_row_<?php echo $row->id; ?> az-contact-info-header">
						<div class="manager-item media">
							<div style="float:left;">
								<div class="badge-no"><?=$i?>. </div>
								
									
								<h4 class="full_width_row_heading_<?=$row->id?>"><a href="javascript:void(0)" ><?=$row->title;?> </a><em><?php echo isset($template_types[$row->template_type]) ? ' - '.$template_types[$row->template_type] : '';?></em>
								
								<em>
									<?php 
										if($row->template_type == "day_1"){
											echo '(Sent immediately)';
										}else{
											echo !empty($row->send_sms_time) ? '('.date('h:i A', strtotime($row->send_sms_time)).')' : '';
										}
									?>
								</em>
								</h4>
								
								
							</div>
							<div class="manager-item-opts">
							
							
						<nav class="nav">
							
							<?php if($user_level == 1) {?> 
							 
							  <a href="admin/<?=$link_type;?>/edit_template/<?php echo $row->id; ?>" class="badge badge-primary">Edit</a>
							  
							  <a  class="badge badge-primary ajax_record_duplicate" data-toggle="modal" data-target="#popupDuplicateItem" item_id="<?=$row->id;?>"   table_name="tbl_twilio_sms_templates" item_title="<?=$row->title;?>" section_type="full_width" form_action="admin/<?=$link_type?>/duplicate_form" redirect_path="admin/<?=$link_type?>">Duplicate</a>
							  
							  <?php if($row->template_type != "day_1"){ ?>
							 <a class="badge badge-primary ajax_record_delete" data-toggle="modal" data-target="#popupDeleteRecord" item_id="<?=$row->id;?>"   table_name="tbl_twilio_sms_templates" item_title="<?=$row->title;?>" section_type="full_width_row_<?php echo $twilio_sms_flow->id; ?>">Delete</a>
							  <?php } ?>
							<?php } ?>
							
						</nav>



							</div>
						</div>
					</li>
<?php $i++; endforeach;?>	
								</ul>
				</div>
			
			<?php if(isset($twilio_sms_templates['other_templates'][$twilio_sms_flow->id]) && !empty($twilio_sms_templates['other_templates'][$twilio_sms_flow->id])){?>	
				<div class="az-content-body ">
					<div class="az-mail-header">
								<div style="margin-top:50px">
								  <h4 class="az-content-title mg-b-5">Paid Trial and Admin Template</h4>
								</div>
								
							  </div>
							  
			<!-- ajax_record_sortable  class for sort templates--->				  
			<ul class=" alternating_full_width_row"  table_name="tbl_twilio_sms_templates" id="email_flow_paid_trial<?php echo $twilio_sms_flow->id; ?>">

			
			<?php
				$deleteBtnLimit = 1;
				$i = 1;
				foreach($twilio_sms_templates['other_templates'][$twilio_sms_flow->id] as $row):
				
				?>
				

					<li   id="menu_<?=$row->id?>" class="full_width_row_<?php echo $row->id; ?> az-contact-info-header">
						<div class="manager-item media">
							<div style="float:left;">
								<div class="badge-no"><?=$i?>. </div>
								
									
								<h4 class="full_width_row_heading_<?=$row->id?>"><a href="javascript:void(0)" ><?=$row->title;?> </a><em><?php echo isset($template_types[$row->template_type]) ? ' - '.$template_types[$row->template_type] : '';?></em></h4>
								
							</div>
							<div class="manager-item-opts">
							
							
						<nav class="nav">
							
							<?php if($user_level == 1) {?> 
							  <a href="admin/<?=$link_type;?>/edit_template/<?php echo $row->id; ?>" class="badge badge-primary">Edit</a>
							  
							<!--  <a  class="badge badge-primary ajax_record_duplicate" data-toggle="modal" data-target="#popupDuplicateItem" item_id="<?=$row->id;?>"   table_name="tbl_twilio_sms_templates" item_title="<?=$row->title;?>" section_type="full_width" form_action="admin/<?=$link_type?>/duplicate_form" redirect_path="admin/<?=$link_type?>">Duplicate</a>
							  
							  <?php //if($i > $deleteBtnLimit){ ?>
							 <a class="badge badge-primary ajax_record_delete" data-toggle="modal" data-target="#popupDeleteRecord" item_id="<?=$row->id;?>"   table_name="tbl_twilio_sms_templates" item_title="<?=$row->title;?>" section_type="full_width_row_<?php echo $twilio_sms_flow->id; ?>">Delete</a>
							  <?php //} ?>-->
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
			url: "admin/twilio_smsflow/ajax_update_flow_title",						
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
		
		
		$('body').on('change','.flow_page_url',function(){
			var flow_id = $(this).attr('flow_id');
			var page_url = $(this).val();
			if(page_url == "" || page_url == null){
				alert('Please select page for sms flow'); return false
			}else{
				$.ajax({ 					
					type: 'POST',						
					url: "admin/twilio_smsflow/ajax_update_flow_page_url",						
					data: { flow_id : flow_id,page_url:page_url,'action':'update_page_url'}					
					}).done(function(msg){ 
					if(msg == 1){
						
					}
					else{
						alert("Oops! Something went wrong!");
						return false;
								
					}
				});
			}
			
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
