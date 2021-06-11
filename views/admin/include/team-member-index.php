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

<h1 > &nbsp;&nbsp; </h1>


<div class="program_full_detail page-section new_lisiting_block default_template" id="AlternatingFullWidth">

				<div class="mb-3 main-content-label " style="margin-top:0px !important" ><?=$title?></div>
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
								  <p>You have <span class="total_alternating_full_width_row"><?php echo !empty($team) ? count($team) : 0; ?></span> Entries</p>
								</div>
								<div>
								
								<?php if($this->uri->segment(4) != ''){ ?>
								<!--<a href="admin/school/team_member_add/<?=$this->uri->segment(4) ?>" class="button_class btn btn-indigo ">Add Team Member</a>-->
								
								<a href="javascript:void(0)" class="button_class btn btn-indigo  full_alternate_popup" data-toggle="modal" data-target="#fullAlternatePopup" action_type="add" item_id="" table_name="tbl_team_members" location_id="<?php echo $location_id; ?>" table_name="tbl_team_members" form_type="full_width_row">Add Team Member</a>
								
								<?php } else { ?>
								<!--<a href="admin/school/team_member_add"  class="button_class btn btn-indigo ">Add Team Member</a> -->
								<a href="javascript:void(0)" class="button_class btn btn-indigo   full_alternate_popup" data-toggle="modal"  data-target="#fullAlternatePopup" action_type="add" item_id="" table_name="tbl_team_members" location_id="<?php echo $location_id; ?>"  form_type="full_width_row">Add Team Member</a>
								
								<?php } ?>

								 
								</div>
							  </div>
							  
			<ul class="ajax_record_sortable alternating_full_width_row"  table_name="tbl_team_members" >

			<?php
			$sr_testimonials=0; 
							
			if(!empty($team)):
			 foreach($team as $row):
			 $sr_testimonials++;
			?>


					<li   id="menu_<?=$row->id?>" class="full_width_row_<?=$row->id?> az-contact-info-header">
						<div class="manager-item media">
							<div style="float:left;">
								<div class="badge-no"><?=$sr_testimonials?>. </div>
								
								<h4 class="full_width_row_heading_<?=$row->id?>"><a href="javascript:void(0)" ><?=$row->name;?> <?= !empty($row->designation) ? '( '.$row->designation.' )' : '';?> </a></h4>
							</div>
							<div class="manager-item-opts">
							
							
						<nav class="nav">
							 
							 <!-- <a href="admin/school/team_member_edit/<?=$row->id;?>" class="badge badge-primary">Edit</a>-->
							 <a href="javascript:void(0)" class="badge-primary badge full_alternate_popup" data-toggle="modal" data-target="#fullAlternatePopup" action_type="edit" item_id="<?=$row->id?>"  table_name="tbl_team_members" form_type="full_width_row"  location_id="<?php echo $location_id; ?>" >Edit</a>
							  
									<a class="badge badge-primary ajax_record_delete" data-toggle="modal" data-target="#popupDeleteRecord" item_id="<?=$row->id;?>"   table_name="tbl_team_members" item_title="<?=$row->name;?>" section_type="full_width">Delete</a>
									
									<a href="javascript:void(0)" id="unpub_<?=$row->id; ?>" class="ajax_record_publish pubish_btn_<?=$row->id?>"  table_name="tbl_team_members"  is_new="0">
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
</div>

<script>
	
	$(document).ready(function(){
		
		$('body').on('click','.full_alternate_popup', function(){
		
			var action_type = $(this).attr('action_type');
			var item_id = $(this).attr('item_id');
			var table_name = $(this).attr('table_name');
			var form_type = $(this).attr('form_type');
			var location_id = $(this).attr('location_id');
			//fullAlternatePopup
			
			$('#fullAlternatePopup').find('.modal-title').html(action_type + ': Team Member');
			
			$.ajax({

					url : 'admin/<?=$link_type;?>/ajax_team_member_popup',
					type : 'POST',
					data :{action_type : action_type, item_id : item_id,table_name:table_name,form_type:form_type,location_id:location_id},
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
					url : 'admin/<?=$link_type;?>/ajax_save_team_member',
					dataType : 'json',
					data: { formData : formData, published: published}					
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
							
							var total_record = $('.total_alternating_'+form_type).html();
							total_record = parseInt(total_record) + 1; 
							$('.total_alternating_'+form_type).html(total_record);
						
							var on_off_btn =  '';
							if(data.published == 1){
								on_off_btn = 'on';
							}
							
							$('.alternating_'+form_type).append('<li id="menu_'+data.id+'" class="full_width_row_'+data.id+'  az-contact-info-header ui-sortable-handle"><div class="manager-item media"><div style="float:left;"><div class="badge-no">'+new_number+'.</div><h4 class="'+form_type+'_heading_'+data.id+'"><a href="javascript:void(0)">'+data.title+' ( '+data.designation+' ) </a></h4></div><div class="manager-item-opts"><nav class="nav"><a href="javascript:void(0)" class="badge-primary badge full_alternate_popup" data-toggle="modal" data-target="#fullAlternatePopup" action_type="edit" item_id="'+data.id+'" table_name="tbl_team_members" form_type="full_width_row" location_id="<?php echo $location_id; ?>">Edit</a><a class="badge badge-primary ajax_record_delete" data-toggle="modal" data-target="#popupDeleteRecord" item_id="'+data.id+'" table_name="tbl_team_members" item_title="'+data.title+'" section_type="full_width">Delete</a><a href="javascript:void(0)" id="unpub_'+data.id+'" class="ajax_record_publish pubish_btn_'+data.id+'" table_name="tbl_team_members" is_new="1"><div class="az-toggle az-toggle-success alternate_full_width_toogle toogle_btn '+on_off_btn+'" publish_type="'+data.published+'"><span></span><input type="hidden" name="publish_type" value="'+data.published+'" class="publish_type"></div></a></nav></div></div></li>');
							
							
							//$('#fullAlternatePopup').find('.close').trigger('click');
							$('#fullAlternatePopup').modal('hide');
							
							$('#responsePopup').find('.action_response_msg').html('Successfully added!');
						}else{
							var item_id = data.id;
							var form_type = data.form_type;
							//alert('.'+form_type+'_heading_'+item_id); return false;
							$('.'+form_type+'_heading_'+item_id).html('<a href="javascript:void(0)" >'+data.title +' ( '+data.designation+' )</a>');
							
							var on_off_btn =  '';
							if(data.published == 1){
								on_off_btn = 'on';
							}
							
							$('.pubish_btn_'+item_id).attr('is_new',1);
							$('.pubish_btn_'+item_id).html('<div class="az-toggle az-toggle-success alternate_full_width_toogle toogle_btn '+on_off_btn+'" publish_type="'+data.published+'"><span></span><input type="hidden" name="publish_type" value="'+data.published+'" class="publish_type"></div>');
							
							
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