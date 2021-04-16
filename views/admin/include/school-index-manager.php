<?php
$user_level = $this->session->userdata('user_level');
$user_id = $this->session->userdata('userid');
$user_name = $this->session->userdata('user');
// only super admin allowed
?>


<div class="az-content-body-left advanced_page custom_full_page school_lisiting_page" >
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

if($user_level == 1) {
?>

					<li   id="menu_<?=$contact->id?>" class="full_width_row_<?=$contact->id?> az-contact-info-header contactLocation contact<?=$contact->id?>">
						<div class="manager-item media">
							<div style="float:left;">
								<div class="badge-no"><?=$sr_contact?>. </div>
								
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
									<a href="javascript:void(0)" ><?=$contact->name.$contactType;?></a>
								</h4>
							</div>
							<div class="manager-item-opts">
							
							
						<nav class="nav" style="display:block">
							
							<?php if($contact->school_location_type == "default"){ ?>
							<a href="admin/<?=$link_type;?>/about_school_header/<?=$contact->id;?>" class="lb-preview badge badge-primary ">Header</a>
							<a href="admin/<?=$link_type;?>/about_ourschool/<?=$contact->id;?>" class="lb-preview badge badge-primary ">Instructor / Rows</a>
							<a href="admin/<?=$link_type;?>/text_sections/<?=$contact->id;?>" class="lb-preview badge badge-primary ">About / Programs</a>
							<a href="admin/<?=$link_type;?>/video_section/<?=$contact->id;?>" class="lb-preview badge badge-primary ">Video</a> 
							<a href="admin/<?=$link_type;?>/school_apikeys/<?=$contact->id;?>" class="lb-preview badge badge-primary ">Social Keys</a> 
							<a href="admin/<?=$link_type;?>/testimonial_sections/<?=$contact->id;?>" class="lb-preview badge badge-primary ">Testimonial / Trial Offer</a>
							<?php } ?>
							
							<?php if($contact->turn_on_nested_location != 1 || $contact->turn_on_nested_location == "nested"){ ?>
							<a href="admin/<?=$link_type;?>/team_member_index/<?=$contact->id;?>" class="lb-preview badge badge-primary ">Team Member</a>
							<a href="admin/<?=$link_type;?>/school_staff_index/<?=$contact->id;?>" class="lb-preview badge badge-primary ">Our Instructor</a>
							<?php } ?>
							
						</nav>



							</div>
						</div>
					</li>
		<?php }else{ ?>
		<?php $userPermissions = $this->query_model->getUserPermission($user_id); ?>
			<?php if(!empty($userPermissions)){ ?>
					<li   id="menu_<?=$contact->id?>" class="full_width_row_<?=$contact->id?> az-contact-info-header contactLocation contact<?=$contact->id?>">
						<div class="manager-item media">
							<div style="float:left;">
								<div class="badge-no"><?=$sr_contact?>. </div>
								
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
									<a href="javascript:void(0)" ><?=$contact->name.$contactType;?></a>
								</h4>
							</div>
							<div class="manager-item-opts">
							
							
						<nav class="nav">
							
							<?php if($contact->school_location_type == "default"){ ?>
							<?php if(strstr($userPermissions[0]->slug, 'admin/school/about_school_header')){ ?>
							<a href="admin/<?=$link_type;?>/about_school_header/<?=$contact->id;?>" class="lb-preview badge badge-primary ">Header</a>
							<?php } ?>
							
							<?php if(strstr($userPermissions[0]->slug, 'admin/school/about_ourschool')){ ?>
							<a href="admin/<?=$link_type;?>/about_ourschool/<?=$contact->id;?>" class="lb-preview badge badge-primary ">Instructor / Rows</a>
							<?php } ?>
							
							<?php if(strstr($userPermissions[0]->slug, 'admin/school/text_sections')){ ?>
							<a href="admin/<?=$link_type;?>/text_sections/<?=$contact->id;?>" class="lb-preview badge badge-primary ">About / Programs</a>
							<?php } ?>
							
							<?php if(strstr($userPermissions[0]->slug, 'admin/school/video_section')){ ?>
							<a href="admin/<?=$link_type;?>/video_section/<?=$contact->id;?>" class="lb-preview badge badge-primary ">Video</a>
							<?php } ?>
							
							<?php if(strstr($userPermissions[0]->slug, 'admin/school/school_apikeys')){ ?>
							<a href="admin/<?=$link_type;?>/school_apikeys/<?=$contact->id;?>" class="lb-preview badge badge-primary ">Social Keys</a>
							<?php } ?> <br/><br/>
							
							
							<?php if(strstr($userPermissions[0]->slug, 'admin/school/testimonial_sections')){ ?>
							<a href="admin/<?=$link_type;?>/testimonial_sections/<?=$contact->id;?>" class="lb-preview badge badge-primary ">Testimonial / Trial Offer</a>
							<?php } ?>
							
							
							<?php } ?>
							
							
							<?php if($contact->turn_on_nested_location != 1 || $contact->turn_on_nested_location == "nested"){ ?>
							<?php if(strstr($userPermissions[0]->slug, 'admin/school/team_member_index')){ ?>
							<a href="admin/<?=$link_type;?>/team_member_index/<?=$contact->id;?>" class="lb-preview badge badge-primary ">Team Member</a>
							<?php } ?>
							
							<?php if(strstr($userPermissions[0]->slug, 'admin/school/school_staff_index')){ ?>
							<a href="admin/<?=$link_type;?>/school_staff_index/<?=$contact->id;?>" class="lb-preview badge badge-primary ">Our Instructor</a>
							<?php } ?>
							<?php } ?>
							
							
						</nav>



							</div>
						</div>
					</li>
		<?php } } ?>
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
	
	
	</script>
