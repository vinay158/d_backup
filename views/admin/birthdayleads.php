<?php $this->load->view("admin/include/header"); ?>
<link rel="stylesheet" href="<?=base_url();?>css/blue/style.css" type="text/css" media="print, projection, screen" />
 <script>
   $(document).ready(function(){
	   $('.view_lead_detail').click(function(){
		   var lead_id = $(this).attr('lead_id');
		   $("#lead_"+lead_id).show();
		   $( "#lead_"+lead_id ).dialog();
	   })
   })
  </script>
<style>
<!--
.manager-items .manager-item {
	min-height: 49px !important;
}
-->


<!-- .delete_all_box{ margin-left: 30px; margin-right: 10px;}
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
} -->

</style>
<script language="javascript">
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
				url : '<?=base_url();?>admin/leads/delete_birthday_leads',
				type :'POST',
				dataType :'json',
				data : {number : number, action: 'delete_record'}
			}).done(function(result){
				if(result == 1){
					
					var redirect_url = '<?=base_url();?>admin/leads/birthdayparties';
					if(month_record != ''){
						redirect_url = '<?=base_url();?>admin/leads/birthdayparties?date='+month_record;
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
		
	if(confirm('Are you sure to delete this record??')){
		window.location = '<?=base_url();?>admin/leads/deletebday/'+id;
		return true;
	}
} */

</script>
<div class="gen-holder">
		<div class="gen-panel">
			<div class="panel-title">
				<div class="panel-title-name"><?=$title?></div>				
			</div>
			<?php if(!empty($parties)){ ?>
            <!-- <div class="delete_all_box">
            <input type="checkbox" class="mainCheckbox"><a href="javascript:void(0);" class="deleteAllLeads">Delete Leads</a>
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
				<li class="next_prev"><a href="<?php echo 'admin/'.$link_type.'?date='.$preDate; ?>" class="btn btn-primary" >  &lt; Prev  </a>  </li>
				
				<li class="active"> <?php echo date('F Y', strtotime($activeDate)); ?>  </li>
				<?php if(!empty($nextDate) && $nextDate < $currentDate){ ?>
				 <li class="next_prev"> <a href="<?php echo 'admin/'.$link_type.'?date='.$nextDate; ?>" class="btn btn-primary  "> Next   &gt;  </a></li> 
			<?php } ?>
			</ul>
			
			<div class="panel-body ordersListTable">
				<div class="panel-body-holder">
					<div class="manager-items custom">
						<div class="border floatNone">
							<h1><?=$title?> <a href="<?=base_url();?>admin/leads/exportbday" class="button_class">Export List</a>
							<div class="import-csv-leads">
							<form action="<?=base_url();?>admin/leads/importBdayPartiesLeads" method="post" enctype="multipart/form-data">
								<input type="file" name="importCsv">
								<input type="submit" name="submitCsv" class="submitCsv" value="Import">
							</form>
							</div>
							</h1>
                           

							<?php if(!empty($parties)):?>
							<form id="allDeleteForm" method="post" action="<?php echo base_url().'admin/leads/deleteAllLeads' ?>">
							<input type="hidden" name="table_name" value="tblbirthdayparty">
							<input type="hidden" name="redirect_url" value="admin/leads/birthdayparties">
                            <table cellpadding="2" cellspacing="2" width="100%" id="myTable" class="tablesorter">
                                <thead>
                                
                                    <th align="left"> S.No </th>
                                    <th align="left">Name</th>
                                    <th align="left">Phone</th>
                                    <th align="left">E-mail</th>
									<th align="left">School</th>
                                    <th align="left">Party Date</th>
                                    <th align="left">Guests</th>
                                 	<th align="left">Date</th>
                                    <th>&nbsp;</th>
                                </thead>
                                <tbody>
                                
                                <?php 
								$i = $number;
								foreach($parties as $party):?>
                                
                                <tr>
									<!--<td><input type="checkbox" class="checkbox_list" name="lead_ids[<?php echo $party->id ?>]" value="<?php echo $party->id ?>"></td> -->
                                   
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo ucfirst($party->name). ' '.$party->last_name; ?></td>
                                    <td><?=$party->phone?></td>
                                    <td><?=$party->email?></td>
									<td>
										<?php 
											$school_detail = $this->query_model->getbySpecific('tblcontact','id',$party->location_id); 
											if(!empty($school_detail)){ echo $school_detail[0]->name;}
										?>
									</td>
                                    <td><?=$party->party_date?></td>
                                    <td><?=$party->guests?></td>
                                    <td><?php echo date('M d, Y ', strtotime($party->date_added)); ?></td>
                                    <td><!--<a href="<?=base_url();?>admin/leads/editbdaylead/<?=$party->id?>">Edit</a><br /> -->
									<a href="javascript:void(0);" class="view_lead_detail" lead_id="<?=$party->id?>">View Lead Details</a> || 
                                    	<a href="javascript:void(0)" class='delete_record' number="<?=$party->id?>" >Delete</a>
										
										
										<!--- POPUP VIEW LEAD INFO ---->
										<div class="view_lead_info" id="lead_<?php echo $party->id ?>" title="<?= $title ?>" style="display:none;">
										  <table  cellpadding="2" cellspacing="2" width="100%">
											<tr>
												<td>Name : <?=ucfirst($party->name). ' '.$party->last_name;?></td>
												<td>Email : <a href="mailto:<?=$party->email?>"><?=$party->email?></a></td>
											</tr>
											<tr>
												<td>Phone: <a href="tel:<?=$party->phone?>"><?=$party->phone?></td>
												<td>
													School: <?php 
													$school_detail = $this->query_model->getbySpecific('tblcontact','id',$party->location_id); 
													if(!empty($school_detail)){ echo $school_detail[0]->name;}
												?>
												</td>
												
											</tr>
											
										<tr><td>Created Date : <?php echo date('M d, Y ', strtotime($party->date_added)); ?></td></tr>
										
										<?php if($party->guests != "" && $party->party_date != ""){ ?>
											<tr>
												<td>Guests: <?=$party->guests?></td>
												
												<td>Party Date : <a href="mailto:<?=$party->party_date?>"><?=$party->party_date?></a></td>
											</tr>
										<?php } else{ ?>
											<tr>
												<td>Reserve Or Schedule : <?=$party->reserve_or_schedule?></td>

												
											</tr>
										<?php } ?>

										<?php if($this->query_model->get_gdpr_compliant() == 1){ ?>
											<tr>
											<!--<td>IP Address : <?php echo $party->ip_address; ?></td> -->
											<td>GDPR : <?php echo ($party->gdpr_compliant_checkbox = 1) ? 'Yes' : 'No'; ?></td>
											</tr>
											<?php } ?>
											
											<tr>
											<td>Client IP Address : <?php echo $party->ip_address; ?></td>
											<td>Client Country : <?php echo $party->client_country_name; ?></td>
											</tr>
										  </table>
										</div>
									
										
										</td>
										
										
                                </tr>
                                
                                <?php $i++; endforeach;?>	
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
			<?php if(isset($_GET['date'])){ ?>
					queryString = '?date='+"<?php echo $_GET['date'] ?>";
					href_url = href_url+queryString;
					$(this).attr('href',href_url);
			<?php } ?>
			
		})
	})
</script>

<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>