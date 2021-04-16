<?php $this->load->view("admin/include/header"); ?>


<!---------- end head contents ---------------->
<input type="hidden" name="mod_type" value="<?=$link_type;?>" id="mod_type" />
<!----- Include Blog Panel Body ---------------->

<div class="az-content-body-left advanced_page custom_full_page onlinedojo_users_page" >
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

<div class="mb-3 main-content-label page_main_heading"><?php echo !empty($userDetail) ? 'Edit' : 'Add New';?> Online Dojo User</div>

<!--<h1><?=$title?><a href="admin/<?=$link_type?>/add" class="button_class">Add Entry</a></h1> -->

<form action="<?=base_url()?>admin/onlinedojo_users/view" method="post">
<!--- end ---->


<p style="color:red"><?php echo !empty($recordError) ? $recordError : ''; ?></p>

 <div class="form-light-holder  d-md-flex  dual_input">
		<div class="adsUrl form-group">
			<h1>First Name</h1>
			<input type="text" name="firstname" value="<?php echo !empty($userDetail) ? $userDetail->firstname : '';?>" />
		</div>
	
		<div class="linkTarget form-group">
			<h1>Last Name</h1>
			<input type="text" name="lastname" value="<?php echo !empty($userDetail) ? $userDetail->lastname : '';?>" />
		
		</div>
    </div>
	
	<div class="form-light-holder   d-md-flex  dual_input">
		<div class="adsUrl form-group">
			<h1>Email Address</h1>
			<input type="text" name="email" required="required" value="<?php echo !empty($userDetail) ? $userDetail->email : '';?>" <?php echo !empty($userDetail) ? 'readonly=readonly' : '';?>/>
		</div>
	
		<div class="linkTarget form-group">
			<?php if(!empty($userDetail)){ ?>
				<h1>Password</h1>
				<input type="text" name="password"  placeholder="xxxxxxxxx" />
				
			<?php } ?>
		</div>
    </div>
	
	
   
   <input type="hidden" name="request_action" value="<?php echo !empty($userDetail) ? 'edit' : 'add';?>" >
   <input type="hidden" name="request_id" value="<?php echo !empty($userDetail) ? $userDetail->id : 0;?>" >
    <div class="form-new-holder">
    	<input type="submit" name="update" value="Save" class="btn-save" />
   </div>


</form>

			</div>

		</div>

		
	
	
<script language="javascript">
	
$(document).ready(function(){
	
	
	$('body').on('click','.mainCheckbox',function(){
		if($(this).is(":checked")){
			$.each($('.checkbox_list'), function(){
				$(this).prop( "checked", true);
			})
		}else{
			$.each($('.checkbox_list'), function(){
				$(this).prop( "checked", false);
			})
			
		}
	})
	
	
	
	$('body').on('click','.deleteAllLeads',function(){
		if(confirm('Deleting User will delete all their attendance records too. Do you confirm to delete ?')){
			$('#allDeleteForm').submit();
		}
	})
	
	
	$('body').on('click','.edit_onlinedojo_user',function(){
		   var user_id = $(this).attr('user_id');
		   var popup_title = $(this).attr('popup_title');
		   
		   $.ajax({
				url : '<?=base_url();?>admin/onlinedojo_users/ajax_onlinedojo_user_edit',
				type :'POST',
				dataType :'html',
				data : {user_id : user_id, action: 'edit_user'}
			}).done(function(result){
				
				$('#popupEditDojoUser').modal('show');
				$('#edit_dojo_user_form').html(result);
			});
			
		  
		   
		   
	   })
	
	
	
var mod_type1 = $("#mod_type").val().toLowerCase();

$(".ui-sortable").sortable({
update : function () {
serial = $('.ui-sortable').sortable('serialize');
$.ajax({
url: "admin/"+mod_type1+"/sortthis",
type: "post",
data: serial,
error: function(){
alert("theres an error with AJAX");
}
});
}
});


/*$('#location_sort').change(function(){
			var location = $(this).val();
			var queryString = "?location="+location;
			
			var redirect_path = "<?php echo base_url().ltrim($_SERVER['REDIRECT_QUERY_STRING'],'/') ?>"+queryString;
			
			window.location.href = redirect_path;
			
		})*/



$('body').on('click','.unpublish',function(){
	var pub_id = $(this).attr("id").substr(6);
	var mod_type = $("#mod_type").val().toLowerCase();
	
	var publish_type = $(this).parents(".table_action_col").children(".publish_type").val();
	
	$.ajax({ 					
	type: 'POST',						
	url: 'admin/'+mod_type+'/publish',						
	data: { pub_id : pub_id, publish_type: publish_type }					
	}).done(function(msg){ 
	if(msg != null){
	//alert(msg);
	setTimeout("window.location.reload()",1000);
	}
	else{
	setTimeout('$("#alert-holder").html("<div><b class=red>Unable to Unpublish.</b></div>")',1000);
	//alert(msg);
	}
	});
	
});

	
/*$('body').on('click','.delete_item',function(){
var del_item_id = $(this).attr("id").substr(8);
$("#delete-item-id").val(del_item_id);
$(".delete-holder-item").hide();
$(".delete-holder-item").slideDown(300);
return false;
})*/
})
</script>

<div class="clearfix"></div>
<div class="searchbox">

<!--<div class="btn-addentry add_entry_button"></div>-->
<h1 > &nbsp;&nbsp; </h1>
<div class="mb-3 main-content-label page_main_heading">OnlineDojo Users</div>
		<div class="row row-xs align-items-center">
	
	<div class="col-md-12  mg-t-5 mg-md-t-0">
	<div class="row mg-t-10">
			
			
			<?php 
				$session_search_data = $this->session->userdata('onlineuser_search_data'); 
				$this->session->unset_userdata('onlineuser_search_data');
			?>
			<?php if($multiLocation[0]->field_value == 1){ ?>
			<div class="col-lg-3">
			  	<span>Location</span><br/>  
					<select  id='location_sort' class="field onlineuser_search_dropdown" type="location">
						<option value="">-All Locations-</option>
						<?php foreach($allLocations as $location){ ?>
						<option value="<?php echo $location->id ?>" <?php echo (isset($session_search_data['location']) && $session_search_data['location'] == $location->id) ? "selected=selected" : ''; ?>><?php echo $location->name; ?></option>
						<?php } ?>
						<option value="virtual_student_only" <?php echo (isset($session_search_data['location']) && $session_search_data['location'] == "virtual_student_only") ? "selected=selected" : ''; ?>>Virtual student only</option>
					</select>
			</div>
			<div class="col-lg-3">
			  <span>Number of records</span><br/>
					<?php
						if($_SERVER['HTTP_HOST'] == "localhost"){
							$sort_numbers = array(1,2,3,4,5,6,7,10,20,50,100);
						}else{
							$sort_numbers = array(10,20,50,100,150,200,250,300,400,500,1000);
						}	
					?>
					<select  id='sort_numbers' class="field onlineuser_search_dropdown"  type="sort_number">
						<?php 
						
							foreach($sort_numbers as $key => $sort_number){
								
								$selected_sort_num = '';
								if(isset($session_search_data['per_page']) && $session_search_data['per_page'] == $sort_number){
									$selected_sort_num = 'selected=selected';
								}else{
									if($sort_number == 10){
										$selected_sort_num = 'selected=selected';
									}
								}
						?>
						<option value="<?php echo $sort_number ?>" data-sort="<?php echo $sort_number;  ?>" <?php echo $selected_sort_num; ?>><?php echo $sort_number; ?></option>
						<?php } ?>
						
					</select>
			</div>
			<div class="col-lg-3">
			 <span>Name</span><br/>
				<input type="text" id="user_name"  class="field onlineuser_search_input" placeholder="Search for Name" type="user_name" value="<?php echo (isset($session_search_data['user_name']) && !empty($session_search_data['user_name'])) ? $session_search_data['user_name'] : ''; ?>">
			
			</div>
			<div class="col-lg-3">
			  <span>Email Address</span><br/>
				<input type="text" id="user_email"  class="field onlineuser_search_input" placeholder="Search for Email Address" type="user_email"  value="<?php echo (isset($session_search_data['user_email']) && !empty($session_search_data['user_email'])) ? $session_search_data['user_email'] : ''; ?>">
			</div>
			
			<?php } ?>
		
		</div>
	</div>
</div>
</div>
	
		<div style="clear:both"></div>
			
			
			
			  <div class="az-content-body-left online_dojo_users_list" >
			  
			  <div class="az-content-header d-block d-md-flex">
				
				<div class="col-lg-12" style="padding:0px">
					<div class="col-lg-3 float-left delete_box">
						<?php if(!empty($users_list)){ ?>
						<div class="delete_all_box">
							<span>&nbsp;</span><br/>
							<label class="ckbox">
							<input type="checkbox" class="mainCheckbox"><span><a href="javascript:void(0);"  class="btn btn-outline-light deleteAllLeads">Delete Users</a></span></label>
						</div>
					<?php } ?>
					</div>
					<div class="col-lg-4 float-left">
					 <h2 class="az-content-title tx-20 mg-b-5 mg-b-lg-8">OnlineDojo Users  <span class="totalResults"></span></h2>
					</div>
					<div class="col-lg-5 float-left csv_upload_box">
					 <div class="import-csv-leads">
							<?php 
								$password_setting = $this->query_model->getbyTable("tbl_password_pro");
								
								if($password_setting[0]->password_protection_type == "multiple"){
							?>
							<form action="<?=base_url();?>admin/onlinedojo_users/importUsers" method="post" enctype="multipart/form-data">
								 <div class="col-lg-8 nopadding float-left">
									<div class="custom-file half_width_custom_file">
									<input type="file" name="importCsv" class="custom-file-input" id="customFile1">
									<label class="custom-file-label" for="customFile">Choose file</label></div>
								</div><div class="col-lg-4 nopadding  float-left">
									<input type="submit" name="submitCsv" class="btn-save submitCsv" value="Import CSV">
								</div>
							</form>
								<?php } ?>
							</div>
					</div>
				</div>
				<div class="clearfix"></div>
			
				

			  </div>	

       <div class="row">

          <div class="col-sm-12 col-xl-12 nopadding">
			
			<?php if(!empty($users_list)):?>
				<form id="allDeleteForm" method="post" action="<?php echo base_url().'admin/onlinedojo_users/deleteAllUsers' ?>">
				<input type="hidden" name="table_name" value="tbl_onlinedojo_users">
				<input type="hidden" name="redirect_url" value="admin/onlinedojo_users/view">
			
			
			<table id="example1" class="table">
              <thead>
                  <tr>
					  <th >&nbsp; </th>
                      <th >S.No</th>
					  <th class="wd-15p">First Name</th>
                      <th class="wd-15p">last Name</th>
                      <th class="wd-15p">E-mail</th>
                      <th class="wd-5p">Type</th>
                      <th class="wd-15p">Phone</th>
					  <?php if($multiLocation[0]->field_value == 1){ ?>
                      <th class="wd-20p">Location</th>
					  <?php } ?>
                      <th class="wd-20p">Date</th>
                      <th class="wd-10p">Action</th>
                  </tr>
              </thead>
              <tbody  id="userResults">
                 <tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td style="text-align:center"><b>Loading....</b></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				 </tr>  
              </tbody> 
			<!--  <tbody>
                  <tr>
                    <td>1</td>
                    <td> </td>
                    <td> </td>
                    <td>testing@test.com</td> 
                    <td>Master Parks Black Belt America of Freehold</td>
                    <td>No</td>
                    <td><span class="badge badge-pill badge-secondary">Free Trial </span></td>
                    <td>Apr 25, 2019 </td>
                    <td>Apr 25, 2019 </td>
                    <td>Apr 25, 2019 </td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td> </td>
                    <td> </td>
                    <td>testing@test.com</td> 
                    <td>Master Parks Black Belt America of Freehold</td>
                    <td>No</td>
                    <td><span class="badge badge-pill badge-danger">Paid Trial</span></td>
                    <td>Apr 25, 2019 </td>
                    <td>Apr 25, 2019 </td>
                    <td>Apr 25, 2019 </td>
                  </tr>
                  
              </tbody> -->
            </table>
			
			</form>
			<?php endif; ?>
          </div>
        </div>
     </div><!-- az-content-body -->
			
			
		
		
<div class="">

<!--<div class="btn-addentry add_entry_button"></div>-->
<h1 > &nbsp;&nbsp; </h1>


<div class="program_full_detail page-section new_lisiting_block default_template" id="AlternatingFullWidth">

				<div class="mb-3 main-content-label" >User Email Templates</div>
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
								  <h4 class="az-content-title mg-b-5">User Email Templates</h4>
								  <p>&nbsp; &nbsp; &nbsp; &nbsp; You have <span class="total_alternating_full_width_row"><?php echo !empty($email_templates) ? count($email_templates) : 0; ?></span> Entries</p>
								</div>
								
							  </div>
							  
			<ul class=" alternating_full_width_row"  table_name="tbl_users_email_templates" >

			<?php
			$sr_testimonials=0; 
							
			if(!empty($email_templates)):
			 foreach($email_templates as $row):
			 $sr_testimonials++;
			?>


					<li   id="menu_<?=$row->id?>" class="full_width_row_<?=$row->id?> az-contact-info-header">
						<div class="manager-item media">
							<div style="float:left;">
								<div class="badge-no"><?=$sr_testimonials?>. </div>
								
									
								<h4 class="full_width_row_heading_<?=$row->id?>"><a href="javascript:void(0)" ><?=$row->title;?> </a></h4>
							</div>
							<div class="manager-item-opts">
							
							
						<nav class="nav">
							 
							  <a href="admin/<?=$link_type;?>/edit_onlineusers_email_template/<?=$row->id;?>" class="badge badge-primary">Edit</a>
							  
								
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

	</div>

<!--<div class="view_lead_info" id="userEditPopup" title="<?= $title ?>" style="display:none;">

</div> --->

<?php //$this->load->view("admin/include/conf_delete_user"); ?>


<script>
	$(window).load(function(){
		/*$.each($('.startPagination a'), function(){
			var href_url = $(this).attr('href');
			var queryString = '';
			<?php if(isset($_GET['location'])){?>
					queryString = '?location=<?php echo $_GET['location'] ?>';
			<?php } ?>
			
			href_url = href_url+queryString;
			$(this).attr('href',href_url);
		})*/
		
		var user_name = $("#user_name").val();
		var user_email = $("#user_email").val();
		var location_sort = $("#location_sort").val();
		var sort_numbers = $("#sort_numbers").val();
		
		callAjaxForResult(user_name,user_email,location_sort,sort_numbers);
	})
	
	$(document).ready(function(){
		$('.onlineuser_search_input').keyup(function(){
			var user_name = $("#user_name").val();
			var user_email = $("#user_email").val();
			var location_sort = $("#location_sort").val();
			var sort_numbers = $("#sort_numbers").val();
			
			callAjaxForResult(user_name,user_email,location_sort,sort_numbers);
			
		})
		
		$('.onlineuser_search_dropdown').change(function(){
			var user_name = $("#user_name").val();
			var user_email = $("#user_email").val();
			var location_sort = $("#location_sort").val();
			var sort_numbers = $("#sort_numbers").val();
			
			
			callAjaxForResult(user_name,user_email,location_sort,sort_numbers);
			
		})
		
		
		

	})
	
	function callAjaxForResult(user_name,user_email,location_sort,sort_numbers){
			
			 $.ajax({
				url : '<?=base_url();?>admin/onlinedojo_users/ajax_online_user_list',
				type :'POST',
				dataType :'html',
				data : {user_name : user_name,user_email : user_email,location_sort : location_sort,sort_numbers : sort_numbers, action: 'get_user'}
			}).done(function(result){
				$('#userResults').html(result);
				
				var total_record = $('.online_user_data').length;
				$('.totalResults').html('Result Found: '+total_record);
				//alert(sort_numbers+'===>'+total_record);
				if(sort_numbers < total_record){
					$('#sort_numbers option').filter(function() {
						return $(this).data('sort') >= parseInt(total_record, 10);
					  }).first().prop('selected', true);
				}
				
			});
			
		}
		
		
</script>

<!--------- end of include --------------->

<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>

	
    <link href="<?=base_url();?>assets_admin/lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet">

    <!-- <link href="<?=base_url();?>assets_admin/lib/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet">
		<link href="<?=base_url();?>assets_admin/lib/select2/css/select2.min.css" rel="stylesheet"> -->
	
    <script src="<?=base_url();?>assets_admin/lib/datatables.net/js/jquery.dataTables.min.js"></script>

    <script src="<?=base_url();?>assets_admin/lib/datatables.net-dt/js/dataTables.dataTables.min.js"></script>

    <script src="<?=base_url();?>assets_admin/lib/datatables.net-responsive/js/dataTables.responsive.min.js"></script>

    <script src="<?=base_url();?>assets_admin/lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js"></script>
	<script src="<?=base_url();?>assets_admin/lib/select2/js/select2.min.js"></script>
	<script src="<?=base_url();?>assets_admin/js/dashboard.sampledata.js"></script>

 <script>

      $(function(){

        'use strict'
		
        /* ----------------------------------- */

        /* Dashboard content */

        $('#example1').DataTable({
			responsive: true,
			paging: false,
			searching: false,
			info: false,
			ordering: false,
			
        });
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });



      });

    </script>
	
	<div id="popupEditDojoUser" class="modal">
      <div class="modal-dialog modal-dialog-centered sortable-box" role="document">
        <div class="modal-content modal-content-demo">
          <div class="modal-header">
            <h6 class="modal-title">Edit OnlineDojo User</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
				<div id="edit_dojo_user_form"></div>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->
	
	