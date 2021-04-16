<?php $this->load->view("admin/include/header"); ?>
<link rel="stylesheet" href="<?=base_url();?>css/blue/style.css" type="text/css" media="print, projection, screen" />
   <script>
   $(document).ready(function(){
	   $('.view_lead_detail').click(function(){
		   var lead_id = $(this).attr('lead_id');
		   $("#lead_"+lead_id).show();
		   $( "#lead_"+lead_id ).dialog();
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


<!--<style>
.eye {
   width: 13px;
  height: 13px;
  border: solid 1px #000;
  border-radius:  75% 15%;
  position: relative;
  transform: rotate(45deg);
}
.eye:before {
  content: '';
  display: block;
  position: absolute;
  width: 5px;
  height: 5px;
  border: solid 1px #000;
  border-radius: 50%;
  left: 3px;
  top: 3px;
}

/* Tooltip container */
.tooltip {
    position: relative;
    display: inline-block;
    border-bottom: 1px dotted black; /* If you want dots under the hoverable text */
}

/* Tooltip text */
.tooltip .tooltiptext {
    visibility: hidden;
    width: 320px;
    background-color: black;
    color: #fff;
    text-align: center;
    padding: 5px 0;
    border-radius: 6px;
 
    /* Position the tooltip text - see examples below! */
    position: absolute;
    z-index: 1;
}

/* Show the tooltip text when you mouse over the tooltip container */
.tooltip:hover .tooltiptext {
    visibility: visible;
	 top: -5px;
    right: 105%; 
}

.delete_all_box{ margin-left: 30px; margin-right: 10px;}
.delete_all_box a {
	background-color: #ed1c24;
	border: none;
	color: white;
	padding: 1px 10px;
	text-align: center;
	text-decoration: none;
	display: inline-block;
	font-size: 14px;
	border-radius: 12px;
	font-weight: 400;
}

</style> -->

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
		
		if(confirm('Are you sure to delete this record??')){
			var number = $(this).attr('number');
			$.ajax({
				url : '<?=base_url();?>admin/leads/delete_order_leads',
				type :'POST',
				dataType :'json',
				data : {number : number, action: 'delete_record'}
			}).done(function(result){
				if(result == 1){
					var redirect_url = '<?=base_url();?>admin/leads/orders_email_only_leads';
					if(month_record != ''){
						redirect_url = '<?=base_url();?>admin/leads/orders_email_only_leads?date='+month_record;
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
			<?php if(!empty($orders)){ ?>
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
				<li class="next_prev"><a href="<?php echo 'admin/'.$link_type.'?date='.$preDate; ?>&location=<?php echo (isset($_GET['location'])) ? $_GET['location'] : ''; ?>" class="btn btn-primary" >   &lt; Prev  </a>  </li>
				
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
				</select>
			</li>
			<?php } ?>
			</ul>
			
			
			<div class="panel-body ordersListTable">
				<div class="panel-body-holder">
					<div class="manager-items custom">
						<div class="border floatNone ">
							<h1><?=$title?> <a href="<?=base_url();?>admin/leads/export_email_only_leads/?location=<?php echo (isset($_GET['location'])) ? $_GET['location'] : ''; ?>" class="button_class">Export List</a></h1>
                           

							<?php if(!empty($orders)):?>
							<form id="allDeleteForm" method="post" action="<?php echo base_url().'admin/leads/deleteAllLeads' ?>">
							<input type="hidden" name="table_name" value="tblorders">
							<input type="hidden" name="redirect_url" value="admin/leads/orders">
                            <table cellpadding="2" cellspacing="2" width="100%" id="myTable" class="tablesorter ">
                                <thead>
                                
                                   <!-- <th align="left"> &nbsp; </th> -->
                                    <th align="left">S.No</th>
									
									<th align="left">Name</th>
									<th align="left">Phone</th>
									<th align="left">E-mail</th>
                                    <th align="left">School</th>
									<th align="left">Program</th>
                                    <th align="left">Page Url</th>
									<th align="left">Date</th>
                                    <th  style="width:100px">&nbsp;</th>
                                </thead>
                                <tbody>
                                
                                <?php 
								$n = $number;
								foreach($orders as $order):
								
									$offerDetail = $this->query_model->getBySpecific('tblspecialoffer', 'id', $order->trial_id);
									//echo '<pre>offerDetail'; print_r($offerDetail); die;
								?>
                                
                                <tr>
                                   <!-- <td><input type="checkbox" class="checkbox_list" name="lead_ids[<?php echo $order->id ?>]" value="<?php echo $order->id ?>"></td> -->
                                    <td><?=$n?></td>
									
									<td><?=$order->name.' '.$order->last_name?></td>
                                    <td><?=$order->phone?></td>
                                    <td><?=$order->email?></td>
                                    <td><?php 
													$school_detail = $this->query_model->getbySpecific('tblcontact','id',$order->location_id); 
													if(!empty($school_detail)){ echo $school_detail[0]->name;}
												?></td>
                                   
                                   <td><?php 
												$program_detail = $this->query_model->getbySpecific('tblprogram','id',$order->program_id); 
												if(!empty($program_detail)){ echo $program_detail[0]->program; }
											?></td>
                                   <td><?php echo ($order->page_url != '/') ? $order->page_url : 'Home Page'; ?></td>
									
									<td><?php echo date('M d, Y h:i A', strtotime($order->created)); ?></td>
                                    <td style="width:13%"><!--<a href="<?=base_url();?>admin/leads/edittrial/<?=$order->id?>">Edit</a> -->
									
									<a href="javascript:void(0);" class="view_lead_detail" lead_id="<?php echo $order->id ?>">View Lead Details</a>
									 || 
                                    	<a href="javascript:void(0)" class='delete_record' number="<?=$order->id?>" >Delete</a>
										
										<!--- POPUP VIEW LEAD INFO ---->
										<div class="view_lead_info" id="lead_<?php echo $order->id ?>" title="<?= $title ?>" style="display:none;">
										  <table  cellpadding="2" cellspacing="2" width="100%">
										  <tr>
											<td>Name: <?=$order->name.' '.$order->last_name?></td>
											<td>Phone: <?=$order->phone?></td>
										  </tr>
											<tr>
												<td>Email : <a href="mailto:<?=$order->email?>"><?=$order->email?></a></td>
												<td>School: <?php 
													$school_detail = $this->query_model->getbySpecific('tblcontact','id',$order->location_id); 
													if(!empty($school_detail)){ echo $school_detail[0]->name;}
												?></td>
											</tr>
											
											<tr>
												<td>Program : <?php 
												$program_detail = $this->query_model->getbySpecific('tblprogram','id',$order->program_id); 
												if(!empty($program_detail)){ echo $program_detail[0]->program; }
											?></td>
													
											</tr>
											<?php if($this->query_model->get_gdpr_compliant() == 1){ ?>
											<tr>
											<td>IP Address : <?php echo $order->ip_address; ?></td>
											<td>GDPR : <?php echo ($order->gdpr_compliant_checkbox = 1) ? 'Yes' : 'No'; ?></td>
											</tr>
											<?php } ?>
											<tr>
											<td>Page Url : <?php echo ($order->page_url != '/') ? $order->page_url : 'Home Page'; ?></td>
											<td>Date : <?php echo date('M d, Y ', strtotime($order->created)); ?></td>
											</tr>
										  </table>
										</div>
									
									
										</td>
										
										
										
									
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
			<?php }elseif($_GET['location']){?>
					queryString = '?location=<?php echo $_GET['location'] ?>";
			<?php }
				
			} ?>
			
			href_url = href_url+queryString;
			$(this).attr('href',href_url);
			
		})
	})
	
	
	
</script>

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