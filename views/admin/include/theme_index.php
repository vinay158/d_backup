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
				
				
				<div class="row row-xs align-items-center mg-b-20  alternating-row-section ">
					
					<div class="col-md-12 mg-t-5 mg-md-t-0 ">
						<div class="az-content-body ">
			
							<div class="az-mail-header">
								<div>
								  <h4 class="az-content-title mg-b-5"><?=$title?></h4>
								  <p>You have <span class="total_alternating_full_width_row"><?php echo !empty($themes) ? count($themes) : 0; ?></span> Entries</p>
								</div>
								<div>
								
							 <?php if($user_level == 1) {?>
							<a href="admin/<?=$link_type?>/add" class="button_class btn btn-indigo ">Add Theme</a>
							<?php } ?>

								</div>
							  </div>
							  
			<ul class="alternating_full_width_row"  table_name="tblthemes" >
			
<?php
$sr_contact=0;
// DOJO 19/11
$count_locations = count($themes);

if(!empty($themes)):?>
<?php 
// DOJO 19/11
$checkMainLocation = array();
foreach($themes as $contactLocation){
		if($contactLocation->main_theme != 0){
			$checkMainLocation[] = $contactLocation;
		}
}
$multipleLocaion =  count($checkMainLocation);
foreach($themes as $theme):
$sr_contact++; 
?>



					<li   id="menu_<?=$theme->id?>" class="full_width_row_<?=$theme->id?> az-contact-info-header contactLocation contact<?=$theme->id?>">
						<div class="manager-item media">
							<div style="float:left;">
								<div class="badge-no"><?=$sr_contact?>.</div>
								
								
								<h4 class="full_width_row_heading_<?=$theme->id?>">
									<a href="javascript:void(0)" ><?=$theme->theme_name;?></a>
								</h4>
							</div>
							<div class="manager-item-opts">
							
							
						<nav class="nav">
							<label class="rdiobox">
							 <input type="radio" name="main_location" class="main_location checkboxLocation<?=$theme->id?>" 
													<?php if($count_locations > 1){ 
																if($theme->main_theme == 1 && $multipleLocaion != 0){ 
																		echo 'checked=checked'; }
																		 else { 
																		 	if($sr_contact == 1){
																			echo 'checked=checked';
																			}	
																		}
																} 
												?> number="<?=$theme->id;?>" value="1"/><span>&nbsp; Apply &nbsp; </span></label>
								
								
								
							  <a href="admin/<?=$link_type;?>/edit/<?=$theme->id;?>" class="badge badge-primary">Edit</a>
								
								<a class="badge badge-primary ajax_record_delete" data-toggle="modal" data-target="#popupDeleteRecord" item_id="<?=$theme->id;?>"   table_name="tblthemes" item_title="<?=$theme->theme_name;?>" section_type="full_width">Delete</a>
								
								<a href="javascript:void(0)" id="unpub_<?=$theme->id; ?>" class="ajax_record_publish"  table_name="tblthemes"  is_new="0">
								<div class="az-toggle az-toggle-success alternate_full_width_toogle toogle_btn <?php echo ($theme->published == 1) ? 'on' : '';?>" publish_type="<?php echo ($theme->published == 1) ? 0 : 1;?>"><span></span>
								<input type="hidden" name="publish_type" value="<?php echo ($theme->published == 1) ? 0 : 1;?>" class="publish_type" />
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
					
					
					});		
				
		}
	});
	
	$(document).ready(function(){
			
			$(".main_location").click(function(){
				
				var answer = confirm ("Are you sure you want to change theme?");
				if (answer){		
					var theme_id = $(this).attr("number");
						
					var mod_type = $("#mod_type").val().toLowerCase();
					$.ajax({ 					
					type: 'POST',						
					url: 'admin/'+mod_type+'/selectMainTheme',						
					data: { theme_id :theme_id}					
					}).done(function(msg){ 
					
						$('#responsePopup').modal('show');
						$('#responsePopup').find('.action_response_msg').html('Successfully changed main theme.');
						setTimeout(function() {
							$('#responsePopup').modal('hide');
							window.location.href= "admin/themes/view";
							}, 3000);
							
							
					});		
				}
				else{		
					return false;
				}
				
				});
			})
			</script>
	