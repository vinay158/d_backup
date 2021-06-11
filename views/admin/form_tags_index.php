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

<?php 
	if(!empty($tagTypes)){
		foreach($tagTypes as $key => $tag_type){
?>
<h1 > &nbsp;&nbsp; </h1>
<div class="program_full_detail new_lisiting_block default_template" id="AlternatingFullWidth">

				<div class="mb-3 main-content-label " style="margin-top:0px !important" ><?php echo $tag_type; ?></div>
				
				
				<div class="row row-xs align-items-center mg-b-20  alternating-row-section ">
					
					<div class="col-md-12 mg-t-5 mg-md-t-0 ">
						<div class="az-content-body ">
			
							<div class="az-mail-header">
								<div>
								  <h4 class="az-content-title mg-b-5"><?php echo $tag_type; ?></h4>
								  <p>You have <span class="total_alternating_full_width_row_<?php echo $key; ?>"><?php echo (isset($tags[$key]) && !empty($tags[$key])) ? count($tags[$key]) : 0; ?></span> Entries</p>
								</div>
								<div>
								<?php if($user_level == 1) {?>
								 
								 <a href="javascript:void(0)" class="button_class btn btn-indigo  full_alternate_popup" data-toggle="modal" data-target="#fullAlternatePopup" action_type="add" item_id="" table_name="tbl_form_tags" table_name="tbl_form_tags" form_type="<?php echo $key; ?>">Add New</a>
								 
								<?php } ?>
								</div>
							  </div>
							  
			<ul class="alternating_<?php echo $key; ?>"  table_name="tbl_form_tags" >

			<?php
			$sr_testimonials=0; 
			
			
			
			if(isset($tags[$key]) && !empty($tags[$key])):
			
			 foreach($tags[$key] as $row):
			 
			 $sr_testimonials++;
			 
			 $form_instances = $this->query_model->getFormIntancesForTags($row->id, $key);
			 
			?>


					<li   id="menu_<?=$row->id?>" class="full_width_row_<?=$row->id?> az-contact-info-header">
						<div class="manager-item media">
							<div style="float:left;">
								<div class="badge-no"><?=$sr_testimonials?>.</div>
								<h4 class="<?php echo $key; ?>_heading_<?=$row->id?>"><a href="javascript:void(0)" ><?=$row->tag;?></a></h4>
								
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
						
							 <?php  if($user_level == 1) { ?>
							 
							    
							  <a href="javascript:void(0)" class="badge-primary badge full_alternate_popup" data-toggle="modal" data-target="#fullAlternatePopup" action_type="edit" item_id="<?=$row->id?>"  table_name="tbl_form_tags" form_type="<?php echo $key; ?>" >Edit</a>
							  
							  
							  
							 <a class="badge badge-primary ajax_record_delete" data-toggle="modal" data-target="#popupDeleteRecord" item_id="<?=$row->id;?>"   table_name="tbl_form_tags" item_title="<?=$row->tag;?>" section_type="full_width_row_<?php echo $key; ?>">Delete</a>
							<?php } ?>
							
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

<?php } } ?>


<input type="hidden" name="mod_type" value="<?=$link_type;?>" id="mod_type" />		
	

</div>	

	</div>			

		
</div>
</div>
</div>
</div>
</div>
<?php $this->load->view("admin/include/footer");?>

<script>
	
	$(document).ready(function(){
		
		$('body').on('click','.full_alternate_popup', function(){
		
			var action_type = $(this).attr('action_type');
			var item_id = $(this).attr('item_id');
			var table_name = $(this).attr('table_name');
			var form_type = $(this).attr('form_type');
			//fullAlternatePopup
			
			$('#fullAlternatePopup').find('.modal-title').html(action_type + ': Tag');
			
			$.ajax({

					url : 'admin/<?=$link_type;?>/ajax_tags_popup',
					type : 'POST',
					data :{action_type : action_type, item_id : item_id,table_name:table_name,form_type:form_type},
					success:function(data){
						
						$('#form_alternate_popup').html(data);
						
					}

			});
			
			
				
		})
		
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
		
		$('body').on('click','.save_full_row_add_btn', function(){
			
			var published = $('.required_mapping_fields_checkbox').attr('checkbox_value');
			
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
				
				var formData = $('#fullAlternateAddForm').serialize();
				
				$.ajax({ 					
					type: 'POST',						
					url : 'admin/<?=$link_type;?>/ajax_save_tag',
					dataType : 'json',
					data: { formData : formData}					
					}).done(function(data){ 
					
					if(data.res == 1){
						
						//setTimeout("window.location.href='admin/calendar/view/"+data.id+"'",1000);	
						
						if(data.form_action == "add"){
							
							var form_type = data.form_type;
							var total_numbers = $('.alternating_'+form_type+' li').length;
							var new_number = 1;
							if(new_number > 0){
								new_number = parseInt(total_numbers) + 1;
							}
							
							var total_record = $('.total_alternating_full_width_row_'+form_type).html();
							total_record = parseInt(total_record) + 1; 
							$('.total_alternating_full_width_row_'+form_type).html(total_record);
						
							var on_off_btn =  '';
							if(data.published == 1){
								on_off_btn = 'on';
							}
							
							$('.alternating_'+form_type).append('<li id="menu_'+data.id+'" class="full_width_row_'+data.id+'  az-contact-info-header ui-sortable-handle"><div class="manager-item media"><div style="float:left;"><div class="badge-no">'+new_number+'.</div><h4 class="'+form_type+'_heading_'+data.id+'"><a href="javascript:void(0)">'+data.title+'</a></h4></div><div class="manager-item-opts"><nav class="nav"><a href="javascript:void(0)" class="badge-primary badge full_alternate_popup" data-toggle="modal" data-target="#fullAlternatePopup" action_type="edit" item_id="'+data.id+'" table_name="tbl_form_tags" form_type="'+form_type+'">Edit</a><a class="badge badge-primary ajax_record_delete" data-toggle="modal" data-target="#popupDeleteRecord" item_id="'+data.id+'" table_name="tbl_form_tags" item_title="'+data.title+'" section_type="full_width_row_'+form_type+'">Delete</a></nav></div></div></li>');
							
							
							//$('#fullAlternatePopup').find('.close').trigger('click');
							$('#fullAlternatePopup').modal('hide');
							
							$('#responsePopup').find('.action_response_msg').html('Successfully added!');
						}else{
							var item_id = data.id;
							var form_type = data.form_type;
							//alert('.'+form_type+'_heading_'+item_id); return false;
							$('.'+form_type+'_heading_'+item_id).html('<a href="javascript:void(0)" >'+data.title +'</a>');
							
							
							
							
							//$('#fullAlternatePopup').find('.close').trigger('click');
							$('#fullAlternatePopup').modal('hide');
							
							$('#responsePopup').find('.action_response_msg').html('Successfully updated!');
						
						}
						
						$('#responsePopup').modal('show');
						setTimeout(function() {$('#responsePopup').modal('hide');}, 3000);
						
					}
				});
				
			}else{
				$('.form_error_msg').show();
			}
			
				
		})
		
	})

</script>

<div id="fullAlternatePopup" class="modal calendar_cat_form_popup">
      <div class="modal-dialog modal-dialog-centered sortable-box" role="document">
        <div class="modal-content modal-content-demo">
          <div class="modal-header">
            <h6 class="modal-title"></h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
		  <form id="fullAlternateAddForm" action="" method="post" enctype="multipart/form-data">
		  <div id="form_alternate_popup"></div>
		  
		  </form>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->
	