<?php
$user_level = $this->session->userdata('user_level');
$user_name = $this->session->userdata('user');
// only super admin allowed
?>


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
	<!--<div class="mb-3 main-content-label page_main_heading">Virtual Training</div>

<div class="">

<!--<div class="btn-addentry add_entry_button"></div>-->
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
								  <p>You have <span class="total_alternating_full_width_row"><?php echo !empty($contact) ? count($contact) : 0; ?></span> Entries</p>
								</div>
								<div>
								
							 <?php if($user_level == 1 && $user_name == 'master' && $multi_location['field_value'] == 1) {?>
							<a href="admin/<?=$link_type?>/add" class="button_class btn btn-indigo ">Add Location</a>
							<?php } ?>

								</div>
							  </div>
							  
			<ul class="ajax_record_sortable alternating_full_width_row"  table_name="tblcontact" >
			
<?php
$sr_contact=0;
// DOJO 19/11
$count_locations = count($contact);


if(!empty($contact)):?>
<?php
$totalContacts = $contact;
// DOJO 19/11
$checkMainLocation = array();
foreach($contact as $contactLocation){
		if($contactLocation->main_location != 0){
			$checkMainLocation[] = $contactLocation;
		}
}
$multipleLocaion =  count($checkMainLocation);
foreach($contact as $contact):
$sr_contact++; 
?>



					<li   id="menu_<?=$contact->id?>" class="full_width_row_<?=$contact->id?> az-contact-info-header contactLocation contact<?=$contact->id?>">
						<div class="manager-item media">
							<div style="float:left;">
								<div class="badge-no"><?=$sr_contact?>.</div>
								
								<?php 
									$contactType = '';
									if($contact->school_location_type == "default" && $contact->turn_on_nested_location == 1){
										$contactType = ' ( Main Nested Location )';
									}elseif($contact->school_location_type == "nested"){
										$this->db->select(array('id','name'));
										$parentContact = $this->query_model->getBySpecific('tblcontact','id',$contact->parent_id);
										$parent_name = !empty($parentContact) ? $parentContact[0]->name : '';
										
										$contactType = ' ( Child Nested Location of :-'.$parent_name.')';
									}
								?>
								
								<h4 class="full_width_row_heading_<?=$contact->id?>">
									<?php if($user_level == 2 && $multi_location['field_value'] == 0){ ?>
										<a href="javascript:void(0)" ><?=$contact->name;?></a>
									<?php }else{ ?>
										<a href="javascript:void(0)" ><?=$contact->name.$contactType;?></a>
									<?php } ?>
								
								</h4>
							</div>
							<div class="manager-item-opts">
							
							
						<nav class="nav">
							<label class="rdiobox">
							 <input type="radio" name="main_location" class="main_location checkboxLocation<?=$contact->id?>" 
									<?php if($count_locations > 1){ 
												if($contact->main_location == 1 && $multipleLocaion != 0){ 
														echo 'checked=checked'; }
														 else { 
															if($sr_contact == 1){
															echo 'checked=checked';
															}	
														}
												} else { echo 'checked=checked'; } 
								?> number="<?=$contact->id;?>" value="1"/><span> &nbsp; </span></label>
								
								
								
							  <a href="admin/<?=$link_type;?>/edit/<?=$contact->id;?>" class="badge badge-primary">Edit</a>
								
								<?php if($multi_location['field_value'] == 1) { ?>
								
									<!--<a id="<?=$contact->id?>"  title="<?=$contact->name;?>" number="<?=$contact->id?>"  class="lb-preview badge badge-primary addDuplicateProgram">Duplicate</a> -->
									
									<a  class="badge badge-primary ajax_record_duplicate" data-toggle="modal" data-target="#popupDuplicateItem" item_id="<?=$contact->id;?>"   table_name="tblcontact" item_title="<?=$contact->name;?>" section_type="full_width" form_action="admin/contact/duplicate_contact" redirect_path="admin/contact/view">Duplicate</a>
								<?php }?>
								 <?php if(count($totalContacts) > 1){ ?>
								 
									<a id="delitem_<?=$contact->id?>" class="delete_item badge badge-primary" number="<?=$contact->id?>" title="Delete <?=$contact->name;?>">Delete</a>
									
									<a class="badge badge-primary ajax_contact_delete_<?=$contact->id?>" data-toggle="modal" data-target="#popupDeleteRecord" item_id="<?=$contact->id;?>"   table_name="tblcontact" item_title="<?=$contact->name;?>" section_type="full_width" style="display:none">Delete</a>
								 <?php } ?>
									
									<a href="javascript:void(0)" id="unpub_<?=$contact->id; ?>" class="ajax_record_publish"  table_name="tblcontact"  is_new="0">
								<div class="az-toggle az-toggle-success alternate_full_width_toogle toogle_btn <?php echo ($contact->published == 1) ? 'on' : '';?>" publish_type="<?php echo ($contact->published == 1) ? 0 : 1;?>"><span></span>
								<input type="hidden" name="publish_type" value="<?php echo ($contact->published == 1) ? 0 : 1;?>" class="publish_type" />
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

<script language="javascript">
	/** DOJO 19/11 **/
	
	$(window).load(function(){
		var location_id = $('.contactLocation').length;
		if(location_id >= 1){
					
					var mod_type = $("#mod_type").val().toLowerCase();
					$.ajax({ 					
					type: 'POST',						
					url: 'admin/'+mod_type+'/makeMainLocation',						
					data: { location_id :location_id}					
					}).done(function(msg){ 
					/*$("#success_message").html("<b>Successfully change main location.</b>");
						setTimeout(function() {
							$('#success_message').fadeOut('slow');
						}, 3000);*/
					
					});		
				
		}
	});
	
	$(document).ready(function(){
	
	$(".main_location").click(function(){
		
		var answer = confirm ("Are you sure you want to change main location?");
		if (answer){		
			var location_id = $(this).attr("number");	
			var mod_type = $("#mod_type").val().toLowerCase();
			$.ajax({ 					
			type: 'POST',						
			url: 'admin/'+mod_type+'/selectMainLocation',						
			data: { location_id :location_id}					
			}).done(function(msg){

			$('#responsePopup').modal('show');
			$('#responsePopup').find('.action_response_msg').html('Successfully changed main location.');
				setTimeout(function() {
					$('#responsePopup').modal('hide');
					window.location.href= "admin/contact/view";
					}, 3000);
			
			});	
		}
		else{		
			return false;
		}
		
		});
	})
	</script>
	
<script language="javascript">
$(document).ready(function(){


/*$(".addDuplicateProgram").click(function(){
		$(".duplicateContact #dropdown-holder").hide();
		$(".duplicateContact #dropdown-holder").slideDown(200);
		$(".drop-add-title").html("Duplicate Contact");
		$("#location_name").val($(this).attr('title'));
		$("#contact_id").val($(this).attr('number'));
		
	});*/



$(".featured").click(function(){
	
	var pub_id = $(this).attr("id").substr(6);
	var mod_type = $("#mod_type").val().toLowerCase();
	var featured_type = $(this).parents(".manager-item-opts").children(".featured_type").val();
	//alert (publish_type);
	$.ajax({ 					
		type: 'POST',						
		url: 'admin/'+mod_type+'/featured',						
		data: { pub_id : pub_id, featured_type: featured_type }					
	}).done(function(msg){ 
		if(msg != null){
		//alert(msg);
			setTimeout("window.location.reload()",1000);
		}
		else{
			setTimeout('$("#alert-holder").html("<div><b class=red>Unable to featured.</b></div>")',1000);
		//alert(msg);
		}
	});
	return false;
});

// DOJO 19/11

	
	$(".delete_item").click(function(){
		var locations = $('.contactLocation').length;
		var contact_id = $(this).attr('number');
		var error = 0;
		if(locations == 1){
			//alert('please select any other location for delete'); return false;
			error = 1;
		}
		var checked = $('.checkboxLocation'+contact_id).attr('checked');
		
		if(checked == 'checked'){
			error = 1;
			//alert('please select any other location for delete'); return false;
		}
		
		if(error == 1){
			alert('Main location or single location can not be delete.'); return false;
		}else{
			
			//$('.checkboxLocation'+contact_id).attr('checked', true);
			$('#popupDeleteRecord').modal('show');
			
			var item_id = $('.ajax_contact_delete_'+contact_id).attr('item_id');
			var table_name = $('.ajax_contact_delete_'+contact_id).attr('table_name');
			var item_title = $('.ajax_contact_delete_'+contact_id).attr('item_title');
			var section_type = $('.ajax_contact_delete_'+contact_id).attr('section_type');
			
			$('#popupDeleteRecord').find('.delete_modal_title').html(item_title);
			$('#popupDeleteRecord').find('#delete_record_id').val(item_id);
			$('#popupDeleteRecord').find('#delete_record_table_name').val(table_name);
			$('#popupDeleteRecord').find('#delete_record_section_type').val(section_type);
		}
		
		
	})
	
	
	
})
</script>



	