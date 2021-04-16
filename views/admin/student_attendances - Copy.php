<?php $this->load->view("admin/include/header"); ?>
<link rel="stylesheet" href="<?=base_url();?>css/blue/style.css" type="text/css" media="print, projection, screen" />

   <script>
   $(document).ready(function(){
	   $('.student_attendance_info').click(function(){
		   var user_id = $(this).attr('user_id');
		   var date = $(this).attr('month');
		   var location = $(this).attr('location');
		   
		   $.ajax({
				url : '<?=base_url();?>admin/student_attendances/ajax_student_attendance_info',
				type :'POST',
				dataType :'html',
				data : {user_id : user_id, date : date, location : location, action: 'get_record'}
			}).done(function(result){
				$('#attendanceInfo').html(result);
			});
			
		   $("#attendanceInfo").show();
		   $("#attendanceInfo").dialog();
		   
		   
	   })
	   
	   $('#location_sort').change(function(){
			var location = $(this).val();
			var queryString = '';
			<?php if(isset($_GET['date'])){ ?>
					queryString = '?date='+"<?php echo $_GET['date'] ?>&location="+location;
			<?php }else{ ?>
					queryString = "?location="+location;
			<?php } ?>
			
			var redirect_path = "<?php echo base_url().ltrim($_SERVER['REDIRECT_QUERY_STRING'],'/') ?>"+queryString;
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
	
	$('.deleteAllLeads').click(function(){
		if(confirm('Are you sure to delete these records?')){
			$('#allDeleteForm').submit();
		}
	})
	
	$('.delete_record').click(function(){
		
		var month_record = $('.month_record').val();
		//alert(redirect_url); return false;
		if(confirm('Are you sure to delete this record??')){
			var number = $(this).attr('number');
			$.ajax({
				url : '<?=base_url();?>admin/leads/delete_order_leads',
				type :'POST',
				dataType :'json',
				data : {number : number, action: 'delete_record'}
			}).done(function(result){
				if(result == 1){
					
					var redirect_url = '<?=base_url();?>admin/leads/orders';
					if(month_record != ''){
						redirect_url = '<?=base_url();?>admin/leads/orders?date='+month_record;
					}
					window.location = redirect_url;
				}
			});
		}
	});
	
	
	$("#myTable").tablesorter({ }); 
	
	var mod_type = $("#mod_type").val().toLowerCase();
	
	
	
})

/*function deleteEntry(id){		
		
	if(confirm('Are you sure to delete this record??<?=base_url();?>admin/leads/deleteOnlineTrialLead/'+id)){
		window.location = '<?=base_url();?>admin/leads/deleteOnlineTrialLead/'+id;
		return true;
	}
}*/


</script>
<div class="gen-holder">
		<div class="gen-panel">
			<div class="panel-title">
				<div class="panel-title-name"><?= $title ?></div>				
			</div>
			<?php if(!empty($student_attendances)){ ?>
            <!--<div class="delete_all_box">
            <input type="checkbox" class="mainCheckbox"><a href="javascript:void(0);"  class="deleteAllLeads">Delete Leads</a>
			</div> -->
			<?php } ?>
			
			<ul class="month-order-leads">
			<?php 
				$currentDate = date('Y-m-d');
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
		<?php } ?>
		
		
		<?php if($multiLocation[0]->field_value == 1){ ?>
			<li style="margin-left:100px">
				<select  id='location_sort' class="field">
					<option value="">-All Locations-</option>
					<?php foreach($allLocations as $location){ ?>
					<option value="<?php echo $location->id ?>" <?php echo (isset($_GET['location']) && $_GET['location'] == $location->id) ? "selected=selected" : ''; ?>><?php echo $location->name; ?></option>
					<?php } ?>
					<option value="virtual_student_only" <?php echo (isset($_GET['location']) && $_GET['location'] == "virtual_student_only") ? "selected=selected" : ''; ?>>Virtual student only</option>
				</select>
			</li>
			<?php } ?>
		
		</ul>
		
		
			
			<div class="panel-body ordersListTable">
				<div class="panel-body-holder">
					<div class="manager-items custom">
						<div class="border floatNone ">
							<h1><?=$title?> <a href="<?=base_url();?>admin/student_attendances/exportAttendance?location=<?php echo (isset($_GET['location'])) ? $_GET['location'] : ''; ?>&date=<?php echo (isset($_GET['date']) && !empty(isset($_GET['date']))) ? $_GET['date'] : date('Y-m'); ?>" class="button_class">Export List</a> 
							
		</h1>
                           
							
							<?php if(!empty($student_attendances)):?>
							<form id="allDeleteForm" method="post" action="<?php echo base_url().'admin/leads/deleteAllLeads' ?>">
							<input type="hidden" name="table_name" value="tblorders">
							<input type="hidden" name="redirect_url" value="admin/leads/orders">
                            <table cellpadding="2" cellspacing="2" width="100%" id="myTable" class="tablesorter ">
                                <thead>
                                
                                   <!-- <th align="left"> &nbsp; </th> -->
                                    <th align="left">S.No</th>
                                    <th align="left">Student name</th>
                                    <th align="left">Attendance count</th>
                                    <th align="left">Last attendance</th>
                                    <th  style="width:100px">&nbsp;</th>
                                </thead>
                                <tbody>
                                
                                <?php 
								
								$n = $number;
								foreach($student_attendances as $student_attendance):
								
									$this->db->where("DATE_FORMAT(attendance_date,'%Y-%m')", $month);
									$this->db->where('user_id',$student_attendance->user_id);
									$this->db->from("tbl_student_attendance");
									$count_attendance =  $this->db->count_all_results();
									
									$this->db->order_by('id','desc');
									$this->db->limit(1);
									$this->db->select(array('attendance_date'));
									//$this->db->where("DATE_FORMAT(attendance_date,'%Y-%m')", $month);
									$last_attendance = $this->query_model->getBySpecific('tbl_student_attendance','user_id',$student_attendance->user_id);
								
									
								?>
                                
                                <tr>
                                    <td><?=$n?></td>
                                    <td><?=$student_attendance->user_name?></td>
                                    <td><?=$count_attendance?></td>
                                    <td><?php echo date('d M, Y ', strtotime($last_attendance[0]->attendance_date)); ?></td>
                                    <td> <a href="javascript:void(0)" class="student_attendance_info" user_id="<?php echo $student_attendance->user_id; ?>" month="<?php echo $month; ?>" location="<?php echo (isset($_GET['location'])) ? $_GET['location'] : ''; ?>"> More Info </a> </td>
                                </tr>
                                
                                <?php $n++; endforeach;?>	
                            </tbody>
						</table>
						</form>
							<?php endif; ?>
						</div>
					</div>
					
					<br />
<style>
		.ActivePageNumber{
			border:1px solid #444444;
		border-radius:3px;
		-moz-border-radius:3px;
		-webkit-border-radius:3px;
		padding:4px 9px 1px;
		 text-decoration: none;
		 background:#444444;
		 color:#FFFFFF;
		 
		}
		
		
		.startPagination > a
		{
		border:1px solid #444444;
		border-radius:3px;
		-moz-border-radius:3px;
		-webkit-border-radius:3px;
		padding:6px 9px 6px 9px;
		 text-decoration: none;
		 color:#444444;
		 
		 
		}
		
		.startPagination > a
		{
		padding-bottom:1px;
		}
		
		.startPagination{ float:right;}
</style>				
<span class="startPagination"><?php  echo $paginglinks;?>

<span style="font-style:italic;font-size:11px;margin:12px 20px;">
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
			echo 'Dispalying 1'.' - '.$endRecord.' of '.$config['total_rows'];
		}
		
	}
?>
</span>
</span>

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
			<?php if(isset($_GET['date']) && isset($_GET['location'])){ ?>
					queryString = '?date='+"<?php echo $_GET['date'] ?>&location=<?php echo $_GET['location'] ?>";
			<?php }else{ 
					if(isset($_GET['date'])){ ?>
						queryString = '?date='+"<?php echo $_GET['date'] ?>";
			<?php }elseif(isset($_GET['location'])){?>
					queryString = '?location=<?php echo $_GET['location'] ?>";
			<?php }
				
			} ?>
			
			href_url = href_url+queryString;
			$(this).attr('href',href_url);
		})
	})
</script>

<div class="view_lead_info" id="attendanceInfo" title="<?= $title ?>" style="display:none;">


</div>
<?php $this->load->view("admin/include/conf_delete_item"); ?>
<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>

<style type="text/css">

.gen-holder {
  margin: 3% auto 0;
  width: 98%;
}

#myTable{}
#myTable tr th{ font-size:12px;}
#myTable tr td{ font-size:12px;}
</style>