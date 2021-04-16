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
<style>
<!--
.manager-items .manager-item {
	min-height: 49px !important;
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
				url : '<?=base_url();?>admin/leads/delete_cart_leads',
				type :'POST',
				dataType :'json',
				data : {number : number, action: 'delete_record'}
			}).done(function(result){
				if(result == 1){
					
					var redirect_url = '<?=base_url();?>admin/leads/cartorders';
					if(month_record != ''){
						redirect_url = '<?=base_url();?>admin/leads/cartorders?date='+month_record;
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
		window.location = '<?=base_url();?>admin/leads/deletecartLead/'+id;
		return true;
	}
} */

</script>
<div class="gen-holder">
		<div class="gen-panel">
			<div class="panel-title">
				<div class="panel-title-name"><?= $title ?></div>				
			</div>
               <?php if(!empty($cartorders)){ ?>
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
				<li class="next_prev"><a href="<?php echo 'admin/'.$link_type.'?date='.$preDate; ?>&location=<?php echo (isset($_GET['location'])) ? $_GET['location'] : ''; ?>" class="btn btn-primary" >   &lt; Prev  </a>  </li>
				
				<li class="active">  <?php echo date('F Y', strtotime($activeDate)); ?> </li>
				<?php if(!empty($nextDate) && $nextDate < $currentDate){ ?>
				 <li class="next_prev"> <a href="<?php echo 'admin/'.$link_type.'?date='.$nextDate; ?>&location=<?php echo (isset($_GET['location'])) ? $_GET['location'] : ''; ?>" class="btn btn-primary  "> Next &gt; </a></li> 
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
						<div class="border floatNone">
							<h1><?=$title?> <a href="<?=base_url();?>admin/leads/exportcartorderleads/?location=<?php echo (isset($_GET['location'])) ? $_GET['location'] : ''; ?>" class="button_class">Export List</a>
							<div class="import-csv-leads">
							<form action="<?=base_url();?>admin/leads/importCartOrderLeads" method="post" enctype="multipart/form-data">
								<input type="file" name="importCsv">
								<input type="submit" name="submitCsv" class="submitCsv" value="Import">
							</form>
							</div>
							</h1>
                           

							<?php if(!empty($cartorders)):?>
							<form id="allDeleteForm" method="post" action="<?php echo base_url().'admin/leads/deleteAllLeads' ?>">
							<input type="hidden" name="table_name" value="tbl_dojocart_orders">
							<input type="hidden" name="redirect_url" value="admin/leads/cartorders">
                            
                          
                            <table cellpadding="2" cellspacing="2" width="100%" id="myTable" class="tablesorter">
                                <thead>
                                
                                   
                                    <th align="left">S.No</th>
                                    <th align="left">Name</th>
                                    <th align="left">Phone</th>
                                    <th align="left">E-mail</th>
									 <th align="left">Dojo Cart</th>
									 <th align="left">Location</th>
									<th align="left">Trial</th>
									<th align="left">Amount</th>
									<th align="left">Status</th>
									<th align="left">Date</th>
                                    <th>&nbsp;</th>
                                </thead>
                                <tbody>
                                
                                <?php 
								
								$site_currency_type = $this->query_model->getSiteCurrencyType();
								$i = $number;
								foreach($cartorders as $order):
										$dojo_cart = $this->query_model->getBySpecific('tbl_dojocarts', 'id', $order->product_id);
										
										$locationDetail = $this->query_model->getBySpecific('tblcontact', 'id', $order->location);
										
								?>
                                
                                <tr>
									<!--<td><input type="checkbox" class="checkbox_list" name="lead_ids[<?php echo $order->id ?>]" value="<?php echo $order->id ?>"></td> -->
                                   <td><?php echo $i; ?></td>
                                    <td><?=$order->name.' '.$order->last_name?></td>
                                    <td><?=$order->phone?></td>
                                    <td><?=$order->email?></td>
									<td><?php echo !empty($dojo_cart) ? $dojo_cart[0]->product_title : '--';?></td>
									
									<td><?php echo !empty($locationDetail) ? $locationDetail[0]->name : '--';?></td>
									
                                    <td><?php if(!empty($order->offer_type)){ echo $order->offer_type; }  ?></td>
									<td><?php if(!empty($order->amount)) { echo $site_currency_type.$order->amount; } else { echo 'N/A'; } ?></td>
									
									<td><?php echo $order->trans_status; ?></td>
									<td><?php echo date('M d, Y ', strtotime($order->created)); ?></td>
                                    <td><a href="javascript:void(0);" class="view_lead_detail" lead_id="<?=$order->id?>">View Lead Details</a> || 
									
                                    	<a href="javascript:void(0)" class='delete_record' number="<?=$order->id?>" >Delete</a>
										
										
										<!--- POPUP VIEW LEAD INFO ---->
										<div class="view_lead_info" id="lead_<?php echo $order->id ?>" title="<?= $title ?>" style="display:none;">
										  <table  cellpadding="2" cellspacing="2" width="100%">
										  <?php if($order->is_multi_item_dojocart != 1){ ?>
											<tr>
												<td>Name : <?=ucfirst($order->name).' '.$order->last_name?></td>
												<td>Email : <a href="mailto:<?=$order->email?>"><?=$order->email?></a></td>
											</tr>
										  <?php } ?>
										  
										  <?php 
											if($order->is_multi_item_dojocart == 1){
												$this->db->group_by('contact_name');
												$this->db->select('contact_name');
												$this->db->where('dojocart_id',$order->product_id);
													$order_contacts = $this->query_model->getBySpecific('tbl_dojocart_order_items','order_id',$order->id);
												if(!empty($order_contacts)){
													$i = 1;
													foreach($order_contacts as $order_contact){
											?>
											<tr>
												<td colspan="2">#<?php echo $i ?> Name : <?=$order_contact->contact_name?></td>
												
											</tr>
										<?php $i++; }  } ?>
										  <tr>
												<td colspan="2">Email : <a href="mailto:<?=$order->email?>"><?=$order->email?></a></td>
											</tr>
										  <?php } ?>
										  
											<tr>
												<td>Phone: <a href="tel:<?=$order->phone?>"><?=$order->phone?></a></td>
												<td>Location: <?php echo !empty($locationDetail) ? $locationDetail[0]->name : '';?></td>
											</tr>
											<tr>
												<td>Dojo Cart: <?php echo !empty($dojo_cart) ? $dojo_cart[0]->product_title : '';?></td>
												<td>Trial: <?php if(!empty($order->offer_type)){ echo $order->offer_type; }  ?></td>
											</tr>
											
											<?php 
												if($order->is_multi_item_dojocart != 1){ 
													$upsells = $this->query_model->getBySpecific('dojocart_order_upsells','order_id',$order->id);
													
											?>
											<tr>
												<td>Quantity: <?php echo $order->quantity; ?></td>
												<?php if(!empty($upsells)){ ?>
												<td>Dojocart Amount: 
													<?php 
														$cartamount = 0;
														if(!empty($upsells)){
															foreach($upsells as $upsell){
																$cartamount += $upsell->total_amount;
															}
														}
														$amount =  !empty($order->amount) ? $order->amount : 0;
														$coupon_discount_amount = !empty($order->coupon_discount) ? $order->coupon_discount : 0;
														echo number_format(($amount + $coupon_discount_amount - $cartamount),2);
													?>
												</td> 
												<?php } ?>
											</tr>
												<?php
													
													if(!empty($upsells)){
														echo '<tr>';
														$i = 0;
														foreach($upsells as $upsell){
															
															if($i %2 == 0){
																echo '</tr><tr>';
															}
												?>
													<td>
														<b>Upsell : <?= $upsell->upsell_title;?></b><br/>
														Amount : <?=$site_currency_type?><?= number_format($upsell->amount - $upsell->sale_tax_amount,2);?><br/>
														Qty : <?= $upsell->qty;?><br/>
														------------------------<br/>
														Sub Total : <?=$site_currency_type?><?= number_format(($upsell->amount - $upsell->sale_tax_amount) * $upsell->qty,2);?><br/>
														Sale Tax : <?=$site_currency_type?><?= number_format($upsell->sale_tax_amount * $upsell->qty,2);?><br/>
														Total : <?=$site_currency_type?><?= number_format($upsell->total_amount,2);?><br/>
													</td>
												<?php 
														$i++;
													
														}
															echo '<tr/>';
													}
												?>
											<?php } ?>
											
											<?php 
												if($order->is_multi_item_dojocart == 1){
													$this->db->where('dojocart_id',$order->product_id);
													$dojocartOrderItems = $this->query_model->getBySpecific('tbl_dojocart_order_items','order_id',$order->id);
													
													if(!empty($dojocartOrderItems)){
											?>			
											<tr>
													<td style="background-color:#d897e8"><b>Items</b></td>
													<td style="background-color:#d897e8"><b>Qty & Amount</b></td>
												</tr>
											<?php
														foreach($dojocartOrderItems as $order_item){
											?>
												<tr>
													<td><?php echo $order_item->contact_name.': '.$order_item->item_title; ?> </td>
													<td><?php echo $order_item->qty; ?>x
													<?php echo $site_currency_type.$order_item->total_amount; ?>= <?php echo $site_currency_type; ?><?php echo $order_item->qty*$order_item->total_amount; ?></td>
												</tr>
												
											
												<?php } } } ?>
											<tr>
												<td>Coupon Code : <?php echo $order->coupon_code; ?></td>
												<td>Coupon Discount: <?php echo !empty($order->coupon_discount) ? $site_currency_type.$order->coupon_discount : ''; ?></td>
											</tr>
											<tr>
												
												<td>Date : <?php echo date('M d, Y ', strtotime($order->created)); ?></td>
												<td>Tax : <?php echo $order->tax; ?></td>
												
												</td>
											</tr>
											
											<tr>
												<td>Status: <?php echo $order->trans_status; ?></td>
												<td>Amount: <?php if(!empty($order->amount)) { echo $site_currency_type.number_format($order->amount,2); } else { echo ''; } ?></td>
											</tr>
											<?php 
											$customFieldsArr = array();
											if(!empty($order->custom_fields)){
													$custom_fields = unserialize($order->custom_fields);
													if(!empty($custom_fields)){
														
														foreach($custom_fields as $key => $val){
															$this->db->select(array('id','label_text','type'));
															$custom_field_detail = $this->query_model->getBySpecific('tbl_dojocart_custom_fields', 'id', $key);
															if(!empty($custom_field_detail)){
																$customFieldsArr[$key]['label_text'] = $custom_field_detail[0]->label_text;
																$customFieldsArr[$key]['type'] = $custom_field_detail[0]->type;
																$customFieldsArr[$key]['value'] = $val;
																
															}
															
														}
													}
											}
											
											?>
											<?php
											if(!empty($customFieldsArr)){
												foreach($customFieldsArr as $custom_field){
											?>
												<tr>
													<td><?php $this->query_model->getDescReplace($custom_field['label_text'])  ?> (Custom Field):
													<?php 
														if($custom_field['type'] == "checkbox"){
															if(!empty($custom_field['value'])){
																echo implode(', ',$custom_field['value']);
															}
														}else{
															echo $custom_field['value'];
														} 
													?>
												
													
													</td>
												</tr>
											
											<?php } }  ?>
											
											<tr>
											<td>Client IP Address : <?php echo $order->ip_address; ?></td>
											<td>Client Country : <?php echo $order->client_country_name; ?></td>
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


<!-- recent items -->
<?php $this->load->view("admin/include/footer");?>