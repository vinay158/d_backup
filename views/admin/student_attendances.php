<?php $this->load->view("admin/include/header"); ?>

<link rel="stylesheet" href="<?=base_url();?>css/blue/style.css" type="text/css" media="print, projection, screen" />

   <script>
   $(document).ready(function(){
	   $('.student_attendance_info').click(function(){
		   var user_id = $(this).attr('user_id');
		   var start_date = $(this).attr('start_date');
		   var end_date = $(this).attr('end_date');
		   var location = $(this).attr('location');
		   var popup_title = $(this).attr('popup_title');
		   
		   $.ajax({
				url : '<?=base_url();?>admin/student_attendances/ajax_student_attendance_info',
				type :'POST',
				dataType :'html',
				data : {user_id : user_id, start_date : start_date, end_date : end_date, location : location, action: 'get_record'}
			}).done(function(result){
				$('#popupAttendanceInfo').modal('show');
				$('.user_name_info').html(popup_title);
				$('#user_attidance_info').html(result);
			});
			
		  
		   
	   })
	   
	   
	   $('.attendance_email_cron').click(function(){
		   var attendance_email_cron = $(this).val();
		  
		   $.ajax({
				url : '<?=base_url();?>admin/student_attendances/ajax_set_attendance_email_cron',
				type :'POST',
				dataType :'html',
				data : {attendance_email_cron : attendance_email_cron, action: 'attendance_email_cron'}
			}).done(function(result){
				
			});
			
		   
	   })
	   
	   
	   $('#location_sort').change(function(){
		  
			var location = $(this).val();
			var start_date = $("#start_date").val();
			var end_date = $("#end_date").val();
			var queryString = '';
			<?php if(isset($_GET['start_date'])){ ?>
					queryString = '?start_date='+start_date+'&end_date='+end_date+'&location='+location;
			<?php }else{ ?>
					queryString = '?start_date='+start_date+'&end_date='+end_date+'&location='+location;
			<?php } ?>
			
			var redirect_path = "<?php echo base_url().'admin/student_attendances' ?>"+queryString;
			//alert(redirect_path); return false;
			window.location.href = redirect_path;
			
		})
		
		$('.dateRange').change(function(){
			var start_date = $("#start_date").val();
			var end_date = $("#end_date").val();
			var location = $("#location_sort").val();
			var queryString = '';
			<?php if(isset($_GET['location'])){ ?>
					queryString = '?start_date='+start_date+'&end_date='+end_date+'&location='+location;
			<?php }else{ ?>
					queryString = '?start_date='+start_date+'&end_date='+end_date;
			<?php } ?>
			
			var redirect_path = "<?php echo base_url().'admin/student_attendances' ?>"+queryString;
			//alert(redirect_path); return false;
			window.location.href = redirect_path;
			
		})
		
		
   })
  </script>



<script >
$(document).ready(function(){
	
	
	$('.mainCheckbox').click(function(){
		if($(this).is(":checked")){
			$.each($('.checkbox_list'), function(){
				$(this).attr('checked','checked');
			})
		}else{
			$.each($('.checkbox_list'), function(){
				$(this).removeAttr('checked');
			})
			
		}
	})
	
	
	
})




</script>
<div class="az-content-body-left advanced_page custom_full_page onlinedojo_users_page user_attendance_page" >
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
		<div class="gen-panel searchbox">
			
			<h1 > &nbsp;&nbsp; </h1>
			<div class="mb-3 main-content-label page_main_heading"><?=$title?></div>
					<div class="row row-xs align-items-center">
				
				<div class="col-md-12  mg-t-5 mg-md-t-0">
				<div class="row mg-t-10">
				
			<?php if(!empty($student_attendances)){ ?>
            <!--<div class="delete_all_box">
            <input type="checkbox" class="mainCheckbox"><a href="javascript:void(0);"  class="deleteAllLeads">Delete Leads</a>
			</div> -->
			<?php } ?>
			
			
			<?php 
				/*$currentDate = date('Y-m-d');
				$activeDate = $currentDate;
				$preDate = date('Y-m', strtotime('-1 month', strtotime($currentDate)));
				$nextDate = '';
				if(isset($_GET['date']) && !empty($_GET['date'])){
					$preDate = date('Y-m', strtotime('-1 month', strtotime($_GET['date'])));
					$activeDate = date('Y-m', strtotime('+1 month', strtotime($preDate)));
					$nextDate = date('Y-m', strtotime('+2 month', strtotime($preDate)));
				}
			?>
			<li class="next_prev"><a href="<?php echo 'admin/'.$link_type.'?date='.$preDate; ?>&location=<?php echo (isset($_GET['location'])) ? $_GET['location'] : ''; ?>" class="btn btn-primary" >  &lt; Prev </a>  </li>
			
			<li class="active">  <?php echo date('F Y', strtotime($activeDate)); ?>  </li>
			<?php if(!empty($nextDate) && $nextDate < $currentDate){ ?>
			 <li class="next_prev"> <a href="<?php echo 'admin/'.$link_type.'?date='.$nextDate; ?>&location=<?php echo (isset($_GET['location'])) ? $_GET['location'] : ''; ?>" class="btn btn-primary  "> Next &gt;</a></li> 
		<?php }*/ ?>
		
		<!--<li class="active">   <?php echo date('F Y'); ?>  </li> -->
		<?php if($multiLocation[0]->field_value == 1){ ?>
			<div class="col-lg-3">
			<span>Location</span>
				<select  id='location_sort' class="field">
					<option value="">-All Locations-</option>
					<?php foreach($allLocations as $location){ ?>
					<option value="<?php echo $location->id ?>" <?php echo (isset($_GET['location']) && $_GET['location'] == $location->id) ? "selected=selected" : ''; ?>><?php echo $location->name; ?></option>
					<?php } ?>
					<option value="virtual_student_only" <?php echo (isset($_GET['location']) && $_GET['location'] == "virtual_student_only") ? "selected=selected" : ''; ?>>Virtual student only</option>
				</select>
			</div>
			<?php } ?>
			
    <!--<script src="http://code.jquery.com/jquery-1.8.2.js"></script>
    <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script> -->
    <link rel="stylesheet" href="/resources/demos/style.css" />
    <script>
    $(function() {
        $( "#start_date" ).datepicker({ dateFormat: "yy-mm-dd",maxDate: new Date() });
		$( "#end_date" ).datepicker({ dateFormat: "yy-mm-dd",maxDate: new Date() });
    });
    </script>
			<div class="col-lg-3">
				<span>Start Date</span>
				<input type="text" value="<?php echo $start_date; ?>" name="start_date" id="start_date" class="dateRange field" placeholder="mm/dd/yyyy" maxlength="10"/>
			</div>
			<div class="col-lg-3">
				<span>End Date</span>
				<input type="text" value="<?php echo $end_date; ?>" name="end_date" id="end_date" class="dateRange field" placeholder="mm/dd/yyyy" maxlength="10"/>
			</div>
		
			
		
		
		
		
			
			<div class="col-lg-3">
					<span>Email for attendance report</span><br/>
					<div class="align-items-center">
						<div class="col-md-12  mg-t-5 mg-md-t-0">
							<div class="row mg-t-10">
								<div class="col-lg-6">
									<label class="rdiobox">
									<input type="radio" class="attendance_email_cron" name="attendance_email_cron" value="daily" <?php echo (!empty($attendance_cron) && $attendance_cron[0]->attendance_email_cron == "daily") ? 'checked=checked' : ''; ?>><span>Daily</span></label>
								</div>
								<div class="col-lg-6">
									<label class="rdiobox">
									<input type="radio" class="attendance_email_cron" name="attendance_email_cron" value="weekly"  <?php echo (!empty($attendance_cron) && $attendance_cron[0]->attendance_email_cron == "weekly") ? 'checked=checked' : ''; ?>><span>Weekly </span></label>
								</div>
							</div>
						</div>
					</div>
			</div>
			
	</div>
</div>
</div>

<div style="clear:both"></div>
	<div style="clear:both"></div>
			
			
			
			  <div class="az-content-body-left online_dojo_users_list" >
			  
			  <div class="az-content-header d-block d-md-flex">
				
				<div class="col-lg-12" style="padding:0px">
					
					<div class="col-lg-6 float-left nopadding">
					 <h2 class="az-content-title tx-20 mg-b-5 mg-b-lg-8"><?=$title?></h2>
					</div>
					<div class="col-lg-6 float-left nopadding text-right">
					 <a href="<?=base_url();?>admin/student_attendances/exportAttendance?location=<?php echo (isset($_GET['location'])) ? $_GET['location'] : ''; ?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>" class="button_class btn btn-outline-light">Export Attendance</a> 
					</div>
				</div>
				<div class="clearfix"></div>
			  </div>	


       <div class="row">

          <div class="col-sm-12 col-xl-12 nopadding">
			
			<form id="allDeleteForm" method="post" action="">
					<input type="hidden" name="table_name" value="tblorders">
					<input type="hidden" name="redirect_url" value="admin/leads/orders">
			
			
			<table id="example1" class="table">
              <thead>
                  <tr>
					<!-- <th align="left"> &nbsp; </th> -->
					<th>S.No</th>
					<th>Student name</th>
					<th>School</th>
					<th>Attendance count</th>
					<th>Last attendance</th>
					<th>Action</th>
                  </tr>
              </thead>
              <tbody >
			  <?php if(!empty($student_attendances)):?>
				
                 <?php 
								
					$n = $number;
					foreach($student_attendances as $student_attendance):
					
						//$this->db->where("DATE_FORMAT(attendance_date,'%Y-%m')", $month);
						$this->db->where('attendance_date >=', $start_date);
						$this->db->where('attendance_date <=', $end_date);
						$this->db->where('user_id',$student_attendance->user_id);
						$this->db->from("tbl_student_attendance");
						$count_attendance =  $this->db->count_all_results();
						
						$this->db->order_by('id','desc');
						$this->db->limit(1);
						$this->db->select(array('attendance_date'));
						//$this->db->where("DATE_FORMAT(attendance_date,'%Y-%m')", $month);
						$last_attendance = $this->query_model->getBySpecific('tbl_student_attendance','user_id',$student_attendance->user_id);
						
						$this->db->select(array('firstname','lastname'));
						$userDetail = $this->query_model->getBySpecific('tbl_onlinedojo_users','id',$student_attendance->user_id);
					
						$username = !empty($userDetail) ? $userDetail[0]->firstname.' '.$userDetail[0]->lastname : $student_attendance->user_name;
					?>
					
					<tr>
						<td><?=$n?></td>
						<td><?=$username?></td>
						<td><?=$student_attendance->location?></td>
						<td><?=$count_attendance?></td>
						<td><?php echo date('d M, Y ', strtotime($last_attendance[0]->attendance_date)); ?></td>
						<td> 
						<div class="action_btn"><a href="javascript:void(0)" class="student_attendance_info" user_id="<?php echo $student_attendance->user_id; ?>" start_date="<?php echo $start_date; ?>" end_date="<?php echo $end_date; ?>" location="<?php echo (isset($_GET['location'])) ? $_GET['location'] : ''; ?>" popup_title="<?= $title ?>- <?php echo $username; ?>"> More Info </a> </div></td>
					</tr>
					
					<?php $n++; endforeach;?>
				
				<?php endif; ?>
              </tbody> 
			
            </table>
			
			</form>
          </div>
        </div>
		<div class="col-md-12 pagination_block nopadding" style="top:20px">
				<span class="displaying_text">
							<?php 							
								if($config['page'] != 1){
									$startRecord = ($config['page'] - 1) * $config['per_page'];
									$endRecord = $config['page']  * $config['per_page'];
									
									if($config['total_rows'] < $endRecord){
										if(($startRecord+1) != $config['total_rows']){
											echo 'Displaying '.($startRecord+1).' - '.$config['total_rows'].' of '.$config['total_rows'];
										} else {
											echo 'Displaying '.($startRecord+1).' of '.$config['total_rows'];
										}
									}else{
										echo 'Displaying '.($startRecord+1).' - '.$endRecord.' of '.$config['total_rows'];
									}
								} else{
									$endRecord = $config['per_page'];
									if($config['per_page'] < $config['total_rows']){
										echo 'Displaying 1'.' - '.$endRecord.' of '.$config['total_rows'];
									}
									
								}
							?>
				</span>
				<span class="startPagination">
								
							<?php  echo $paginglinks;?>
								
						</span>
			  
			  </div>
     </div><!-- az-content-body -->
	 
	 
	 

	 
	</div>			

		
</div>
</div>
</div>
</div>
</div>

	</div>
	
	
	
	<input type="hidden" class="month_record" value="<?php echo isset($_GET['date']) ? $_GET['date'] : ''; ?>">

<script>
	$(window).load(function(){
		$.each($('.startPagination a'), function(){
			var href_url = $(this).attr('href');
			var queryString = '';
			<?php if(isset($_GET['start_date']) && isset($_GET['location'])){ ?>
					queryString = '?start_date='+"<?php echo $_GET['start_date']; ?>"+'&end_date='+"<?php echo $_GET['end_date']; ?>"+'&location='+"<?php echo $_GET['location']; ?>";
			<?php }else{ 
					if(isset($_GET['start_date'])){ ?>
						queryString = '?start_date='+"<?php echo $_GET['start_date']; ?>"+'&end_date='+"<?php echo $_GET['end_date']; ?>"+'&location='+"<?php echo $_GET['location']; ?>";
			<?php }elseif(isset($_GET['location'])){?>
					queryString = '?location=<?php echo $_GET['location'] ?>";
			<?php }
				
			} ?>
			
			href_url = href_url+queryString;
			$(this).attr('href',href_url);
		})
	})
</script>

	 
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
		
		$('#example2').DataTable({
			responsive: true,
			paging: false,
			searching: false,
			info: false,
			ordering: false,
			
        });
		
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });



      });

    </script>
	
	<div id="popupAttendanceInfo" class="modal">
      <div class="modal-dialog modal-dialog-centered sortable-box" role="document">
        <div class="modal-content modal-content-demo">
          <div class="modal-header">
            <h6 class="modal-title user_name_info">User Attendance Info</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
		  <div class="modal-body">
				<div id="user_attidance_info"></div>
		  </div>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->