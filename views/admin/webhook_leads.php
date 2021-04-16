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
				url : '<?=base_url();?>admin/leads/delete_webhook_leads',
				type :'POST',
				dataType :'json',
				data : {number : number, action: 'delete_record'}
			}).done(function(result){
				if(result == 1){
					
					var redirect_url = '<?=base_url();?>admin/leads/webhook_leads';
					if(month_record != ''){
						redirect_url = '<?=base_url();?>admin/leads/webhook_leads?date='+month_record;
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
		window.location = '<?=base_url();?>admin/leads/deletecontactlead/'+id;
		return true;
	}
} */

</script>
<div class="gen-holder">
		<div class="gen-panel">
			<div class="panel-title">
				<div class="panel-title-name"><?= $title; ?></div>				
			</div>
             <?php if(!empty($contacts)){ ?>
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
				
				<li class="active">  <?php echo date('F Y', strtotime($activeDate)); ?>  </li>
				<?php if(!empty($nextDate) && $nextDate < $currentDate){ ?>
				 <li class="next_prev"> <a href="<?php echo 'admin/'.$link_type.'?date='.$nextDate; ?>" class="btn btn-primary  "> Next  &gt; </a></li> 
			<?php } ?>
			</ul>
			
			
			<div class="panel-body ordersListTable">
				<div class="panel-body-holder">
					<div class="manager-items custom">
						<div class="border floatNone">
							<h1><?=$title?> <a href="<?=base_url();?>admin/leads/exportWebhookLeads"  class="button_class">Export List</a></h1>
                            

							<?php if(!empty($contacts)):?>
							<form id="allDeleteForm" method="post" action="<?php echo base_url().'admin/leads/deleteAllLeads' ?>">
							<input type="hidden" name="table_name" value="tbl_webhook_leads">
							<input type="hidden" name="redirect_url" value="admin/leads/webhook_leads">
                            
                            <table cellpadding="2" cellspacing="2" width="100%" id="myTable" class="tablesorter">
                                <thead>
									<th>S.No</th>
                                    <th align="left">Name</th>
                                    <th align="left">Phone</th>
                                    <th align="left">E-mail</th>
                                 	<th align="left">Date</th>
                                    <th>&nbsp;</th>
                                </thead>
                                <tbody>
                                
                                <?php 
								$i = $number;
								foreach($contacts as $contact):
									$webhookApi = $this->query_model->getBySpecific('tbl_webhook_apis_incoming', 'id',$contact->webhook_incoming_api_id);
								?>
                                
                                <tr>
									<!-- <td><input type="checkbox" class="checkbox_list" name="lead_ids[<?php echo $contact->id ?>]" value="<?php echo $contact->id ?>"></td> -->
									<td><?php echo $i; ?></td>
                                   
                                    <td><?php echo $contact->name.' '.$contact->last_name; ?></td>
                                    <td><?=$contact->phone_number?></td>
                                    <td><?=$contact->email?></td>
                                    <td><?php echo date('M d, Y ', strtotime($contact->created)); ?></td>
                                    <td><!--<a href="<?=base_url();?>admin/leads/editcontactlead/<?=$contact->id?>">Edit</a><br /> -->
									<a href="javascript:void(0);" class="view_lead_detail" lead_id="<?=$contact->id?>">View Lead Details</a> || 
									
                                    	<a href="javascript:void(0)" class='delete_record' number="<?=$contact->id?>" >Delete</a>
										
										
										<!--- POPUP VIEW LEAD INFO ---->
										<div class="view_lead_info" id="lead_<?php echo $contact->id ?>" title="<?= $title ?>" style="display:none;">
										  <table  cellpadding="2" cellspacing="2" width="100%">
										  <tr>
												<td colspan="2">Webhook Api : <?php echo !empty($webhookApi) ? $webhookApi[0]->api_name : '';?></td>
											</tr>
											<tr>
												<td>Name : <?=ucfirst($contact->name).' '.$contact->last_name?></td>
												<td>Email : <a href="mailto:<?=$contact->email?>"><?=$contact->email?></a></td>
											</tr>
											<tr>
												<td>Phone: <a href="tel:<?=$contact->phone_number?>"><?=$contact->phone_number?></a></td>
												<td>Website Url: <?php  echo $contact->current_website_url ; ?>
													</td>
											</tr>
											
											<tr>
												<td>Ip Address: <?=$contact->ip_address?></td>
												<td>Page Name : <?php  echo $contact->page_name ; ?>
													</td>
											</tr>
											
											<tr>
												<td>School Name: <?=$contact->school_name?></td>
												<td>Program: <?php  echo $contact->program ; ?>
													</td>
											</tr>
											
											<tr>
												<td>Last Updated: <?php  echo $contact->last_updated ; ?></td>
												<td>Inquiry Date: <?php  echo $contact->inquiry_date ; ?>
													</td>
											</tr>
											
											
											
											<tr>
											<td>Variant: <?php  echo $contact->variant ; ?>
													</td>
											<td>Date : <?php echo date('M d, Y ', strtotime($contact->created)); ?></td>
											</tr>
											<tr>
											<td colspan="2">Additional Comments : <?php echo $contact->additional_comments; ?></td>
											
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