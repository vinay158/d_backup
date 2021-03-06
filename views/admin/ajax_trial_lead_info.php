<link rel="stylesheet" href="<?php echo base_url(); ?>lightbox/accordion/css/smk-accordion.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>lightbox/accordion/js/smk-accordion.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($){
		$(".accordion_example4").smk_Accordion({
			closeAble: true, //boolean
			closeOther: false, //boolean
		});
	});
</script>

<div class="row ajax_trial_lead_info">
<div class="col-sm-12 col-xl-12 color_box">
<?php foreach($lead_types as $key=> $lead_type){ ?>
	<div class="<?php echo ($key == "birthday_parties") ? 'col-sm-6' : 'col-sm-3'; ?> float-left  nopadding <?php echo $key; ?>"><p></p><?php echo $lead_type; ?></div>
<?php } ?>
</div>
<div class="col-sm-12 col-xl-12 main_lead">
	<div class="col-sm-6 float-left heading" style="padding-left:0px">
		<div><b>Name:</b> <?php echo $main_lead->name; ?></div>
	</div>
	<!--<div class="col-sm-6  float-left">
		<b>Email:</b> <?php echo $main_lead->email; ?>
	</div>-->
	<div class="col-sm-6  float-left heading" style="padding-right:0px">
		<div><b>Phone:</b> <?php echo $main_lead->phone; ?></div>
	</div>
	
</div>

	<div class="col-sm-12 col-xl-12 ">
		<div class="heading_box">
			<div class="time_ago">Time Ago</div>
			<div class="created_time">Lead Date</div>
			<div class="lead_type">Lead Type</div>
			<div class="lead_status">Status</div>
			<div class="lead_action">Action</div>
		</div>
		
		<div class="accordion_example4">
		<?php
		$site_currency_type = $this->query_model->getSiteCurrencyType();
		
			if(!empty($orders)){ 
				foreach($orders as $key=> $order_list){
					foreach($order_list as $order ){
		?>
			<div class="accordion_in <?php echo (isset($order->last_order_id) && $order->last_order_id > 0) ? 'upsell_trial' : $order->lead_type; ?>  <?php echo (isset($order->last_order_id) && $order->last_order_id > 0) ? 'upsell_trial' : $order->lead_type; ?>_<?=$order->id?>">
				<div class="acc_head">
					<div class="time_ago"><?php echo $this->query_model->getTimeAgo(date('Y-m-d H:i:s',$key)); ?></div>
					<div class="created_time"><?php echo date('M d, Y', strtotime($order->created)); ?></div>
					<div class="lead_type"><?php echo ucwords(str_replace('_',' ',$order->lead_type)) ?> <?php echo !empty($order->last_order_id) ? ' - Upsell' : ''; ?></div>
					<div class="lead_status"><?php echo !empty($order->trans_status) ?  ucfirst($order->trans_status) : '&nbsp; '; ?></div>
					<div class="lead_action">
					
					<!--<a class="ajax_lead_record_delete" data-toggle="modal" data-target="#popupDeleteLeadRecord" item_id="<?=$order->id;?>" email="<?php echo $order->email; ?>"  lead_type="<?php echo (isset($order->last_order_id) && $order->last_order_id > 0) ? 'upsell_trial' : $order->lead_type; ?>" item_title="<?=$order->email;?>"><i class="fa fa-trash"></i></a>--->
					<a class="ajax_lead_info_record_delete" item_id="<?=$order->id;?>" email="<?php echo $order->email; ?>"  lead_type="<?php echo (isset($order->last_order_id) && $order->last_order_id > 0) ? 'upsell_trial' : $order->lead_type; ?>" item_title="<?=$order->email;?>" item_title="<?=$order->email;?>"><i class="fa fa-trash"></i></a>
					
					</div>
					
					</div>
				<div class="acc_content">
					<div class=" col-sm-12 col-xl-12 nopadding  lead_info_box">
					<!--<div class="col-sm-12 float-left text-right nopadding  detail">
						<a class="ajax_lead_info_record_delete button_class btn btn-indigo " item_id="<?=$order->id;?>" email="<?php echo $order->email; ?>"  lead_type="<?php echo (isset($order->last_order_id) && $order->last_order_id > 0) ? 'upsell_trial' : $order->lead_type; ?>" item_title="<?=$order->email;?>" item_title="<?=$order->email;?>">Delete Lead</a>
					</div>-->
					<?php if($order->lead_type != "dojocart"){ ?>
						<div class="col-sm-6 float-left nopadding  detail">
								<div><b>Name:</b> <?php echo ucfirst($order->name).' '.$order->last_name; ?></div>
						</div>
						<div class="col-sm-6 float-left nopadding  detail">
							<div><b>Email:</b> <a href="mailto:<?=$order->email?>"><?=$order->email?></a></div>
						</div>
						
						<div class="col-sm-6 float-left nopadding detail">
							<div><b>Phone:</b>  <a href="tel:<?=$order->phone?>"><?=$order->phone?></a></div>
						</div>
					<?php } ?>
					
					<?php if($order->lead_type == "dojocart"){ ?>
							
							<?php 
								$this->db->select(array('product_title'));
								$dojo_cart = $this->query_model->getBySpecific('tbl_dojocarts', 'id', $order->product_id);
								
								$this->db->select(array('name'));
								$locationDetail = $this->query_model->getBySpecific('tblcontact', 'id', $order->location);
										
							?>
							
							<?php if($order->is_multi_item_dojocart != 1){ ?>
								<div class="col-sm-6 float-left nopadding  detail">
										<div><b>Name:</b> <?php echo ucfirst($order->name).' '.$order->last_name; ?></div>
								</div>
							<?php }else{ 
									
									$this->db->group_by('contact_name');
									$this->db->select('contact_name');
									$this->db->where('dojocart_id',$order->product_id);
									$order_contacts = $this->query_model->getBySpecific('tbl_dojocart_order_items','order_id',$order->id);
									//echo '<pre>order'; print_r($order); 
									if(!empty($order_contacts)){
										$i = 1;
										foreach($order_contacts as $order_contact){
							?>
								<div class="col-sm-6 float-left nopadding  detail">
									<div><b>#<?php echo $i ?> Name:</b> <?=$order_contact->contact_name?></div>
								</div>
								<?php $i++; }  } ?>
								
							<?php } ?>
							<div class="col-sm-6 float-left nopadding  detail">
								<div><b>Email:</b> <a href="mailto:<?=$order->email?>"><?=$order->email;?></a></div>
							</div>
							<div class="col-sm-6 float-left nopadding  detail">
								<div><b>Phone:</b> <a href="tel:<?=$order->phone?>"><?=$order->phone?></a></div>
							</div>
							<div class="col-sm-6 float-left nopadding  detail">
								<div><b>Location:</b> <?php echo !empty($locationDetail) ? $locationDetail[0]->name : '';?></div>
							</div>
							<div class="col-sm-6 float-left nopadding  detail">
								<div><b>Dojo Cart:</b> <?php echo !empty($dojo_cart) ? $dojo_cart[0]->product_title : '';?></div>
							</div>
							
							<div class="col-sm-6 float-left nopadding  detail">
								<div><b>Trial:</b> <?php if(!empty($order->offer_type)){ echo $order->offer_type; }  ?></div>
							</div>
							
							<?php 
								if($order->is_multi_item_dojocart != 1){
									
									$this->db->select(array('upsell_title','amount','sale_tax_amount','qty','total_amount'));
									$upsells = $this->query_model->getBySpecific('dojocart_order_upsells','order_id',$order->id);
							?>
								<div class="col-sm-6 float-left nopadding  detail">
									<div><b>Quantity:</b> <?php echo $order->quantity; ?></div>
								</div>
								<?php if(!empty($upsells)){ ?>
									<div class="col-sm-6 float-left nopadding  detail">
										<div><b>Dojocart Amount:</b>
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
										</div>
									</div>
								
									<?php
										//echo '<tr>';
										$i = 1;
										foreach($upsells as $upsell){
											/*if($i %2 == 0){
												echo '</tr><tr>';
											}*/
											$box_cls = 'col-sm-6';
											if(count($upsells) == 1){
												$box_cls = 'col-sm-12';
											}else{
												if(count($upsells) == $i){
													if($i % 2 == 0){
														$box_cls = 'col-sm-6';
													}
												}
											}
											
								?>
									<div class="<?php echo $box_cls; ?> float-left nopadding  detail">
										<div>
										<b>Upsell : <?= $upsell->upsell_title;?></b><br/>
										Amount : <?=$site_currency_type?><?= number_format($upsell->amount - $upsell->sale_tax_amount,2);?><br/>
										Qty : <?= $upsell->qty;?><br/>
										------------------------<br/>
										Sub Total : <?=$site_currency_type?><?= number_format(($upsell->amount - $upsell->sale_tax_amount) * $upsell->qty,2);?><br/>
										Sale Tax : <?=$site_currency_type?><?= number_format($upsell->sale_tax_amount * $upsell->qty,2);?><br/>
										Total : <?=$site_currency_type?><?= number_format($upsell->total_amount,2);?><br/>
									</div>
									</div>
								<?php $i++; } ?>
								
								<?php } ?>
								
							<?php }else{
									$this->db->select(array('contact_name','item_title','qty','total_amount'));
									$this->db->where('dojocart_id',$order->product_id);
									$dojocartOrderItems = $this->query_model->getBySpecific('tbl_dojocart_order_items','order_id',$order->id);
									if(!empty($dojocartOrderItems)){
							?>
							<div class="clearfix"></div>
								<div class="col-sm-4 float-left nopadding  detail">
									<div style="background: #ccc;"><b>Name</b></div>
								</div>
								<div class="col-sm-4 float-left nopadding  detail">
									<div style="background: #ccc;"><b>Item</b></div>
								</div>
								<div class="col-sm-4 float-left nopadding  detail">
									<div style="background: #ccc;"><b>Qty & Amount:</b></div>
								</div>
								<?php foreach($dojocartOrderItems as $order_item){ ?>
									<div class="col-sm-4 float-left nopadding  detail">
										<div><?php echo ucfirst($order_item->contact_name); ?></div>
									</div>
									<div class="col-sm-4 float-left nopadding  detail">
										<div><?php echo $order_item->item_title; ?></div>
									</div>
									<div class="col-sm-4 float-left nopadding  detail">
										<div><?php echo $order_item->qty; ?>x
											<?php echo $site_currency_type.$order_item->total_amount; ?>= <?php echo $site_currency_type; ?><?php echo $order_item->qty*$order_item->total_amount;?> 
											</div>
									</div>
								<?php } ?>
							<?php } } ?>
						
					<?php if(!empty($order->coupon_code)){ ?>
						<div class="col-sm-6 float-left nopadding  detail">
								<div><b>Coupon Code:</b> <?php echo $order->coupon_code; ?></div>
						</div>
						<div class="col-sm-6 float-left nopadding  detail">
								<div><b>Coupon Discount:</b> <?php echo !empty($order->coupon_discount) ? $site_currency_type.$order->coupon_discount : ''; ?></div>
						</div>
					<?php } ?>
						
						<div class="col-sm-6 float-left nopadding  detail">
							<div><b>Tax:</b> <?php echo $order->tax; ?></div>
						</div>
						<div class="col-sm-6 float-left nopadding  detail">
							<div><b>Total Amount:</b> <?php if(!empty($order->amount)) { echo $site_currency_type.number_format($order->amount,2); } else { echo ''; } ?></div>
						</div>
						<div class="col-sm-6 float-left nopadding  detail">
							<div><b>Status:</b> <?php echo !empty($order->trans_status) ?  ucfirst($order->trans_status) : '';  ?></div>
						</div>
						<div class="col-sm-6 float-left nopadding  detail">
							<div><b>Created Date:</b> <?php echo date('M d, Y  h:i A', strtotime($order->created)); ?></div>
						</div>
						
						
						
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
							<div class="col-sm-6 float-left nopadding  detail">
								<div><b><?php $this->query_model->getDescReplace($custom_field['label_text'])  ?> (Custom Field):</b>
								<?php 
									if($custom_field['type'] == "checkbox"){
										if(!empty($custom_field['value'])){
											echo implode(', ',$custom_field['value']);
										}
									}else{
										echo $custom_field['value'];
									} 
								?>
							
								
								</div>
							</div>
						
						<?php } }  ?>
						
						<div class="col-sm-6 float-left nopadding  detail">
							<div><b>Client IP Address:</b> <?php echo $order->ip_address; ?></div>
						</div>
						<div class="col-sm-6 float-left nopadding  detail">
							<div><b>Client Country:</b> <?php echo $order->client_country_name; ?></div>
						</div>
						
					
					
					<?php }elseif($order->lead_type == "birthday_parties"){ ?>
					
						
						
						<?php
							$this->db->select(array('name'));
							$school_detail = $this->query_model->getbySpecific('tblcontact','id',$order->location_id); 
							if(!empty($school_detail)){ 
						?>
						<div class="col-sm-6 float-left nopadding detail">
							<div><b>School:</b> 
							<?php echo $school_detail[0]->name; ?>
							</div>
						</div>
							<?php } ?>
						
						<?php if($order->guests != "" && $order->party_date != ""){ ?>
						<div class="col-sm-6 float-left nopadding detail">
							<div><b>Guests:</b>  <?=$order->guests?></div>
						</div>
						<div class="col-sm-6 float-left nopadding detail">
							<div><b>Party Date:</b>  <?=$order->party_date?></div>
						</div>
						<?php }else{?>
						<div class="col-sm-6 float-left nopadding detail">
							<div><b>Reserve Or Schedule:</b>  <?=$order->reserve_or_schedule?></div>
						</div>
						<?php } ?>
						
						
					
					<?php }elseif($order->lead_type == "contact_us"){ ?>
						
						
						<div class="col-sm-6 float-left nopadding detail">
							<div><b>School:</b>  <?php  echo $order->school ; ?></div>
						</div>
						<div class="col-sm-12 float-left nopadding detail">
							<div><b>Message:</b>  <?php  echo $order->message ; ?></div>
						</div>
						
						
					
					
					<?php }else{ ?>
						
						<?php 
							$tblspecialoffer = ($order->is_unique_trial == 1) ? 'tbl_unique_specialoffer' : 'tblspecialoffer';
							$this->db->select(array('offer_title','amount'));
							$offerDetail = $this->query_model->getBySpecific("$tblspecialoffer", 'id', $order->trial_id);
							
						?>
						
						
							
							<?php 
								$this->db->select(array('name'));
								$school_detail = $this->query_model->getbySpecific('tblcontact','id',$order->location_id); 
								if(!empty($school_detail)){
							?>
								<div class="col-sm-6 float-left nopadding detail">
									<div><b>School:</b> 
									<?php echo $school_detail[0]->name; ?>
									</div>
								</div>
							<?php } ?>
						<?php if(!empty($order->child_name)){ ?>
							<div class="col-sm-6 float-left nopadding detail">
								<div><b>Child's Name:</b>  <?=ucfirst($order->child_name)?></div>
							</div>
							<div class="col-sm-6 float-left nopadding detail">
								<div><b>Child's Age:</b> <?=$order->child_age?></div>
							</div>
						<?php } ?>
							
							<div class="col-sm-12 float-left nopadding detail">
								<div><b>Program:</b>
									<?php 
										$this->db->select('program');
										$program_detail = $this->query_model->getbySpecific('tblprogram','id',$order->program_id); 
										if(!empty($program_detail)){ echo $program_detail[0]->program; }
									?>
								</div>
							</div>
							<div class="col-sm-6 float-left nopadding detail">
								<div><b>Trial Name:</b> <?php echo !empty($offerDetail) ? $offerDetail[0]->offer_title : ''; ?></div>
							</div>
							<?php if(empty($order->last_order_id)){ ?>
							<div class="col-sm-6 float-left nopadding detail">
								<div>
									<b>Trial Type:</b> <?php echo !empty($order->offer_type) ? $order->offer_type : 'Email Opt-in'  ?> 
									
								<?php if($order->offer_type == "Paid"){ ?>
									(<?php echo !empty($offerDetail) ? $site_currency_type.$offerDetail[0]->amount : ''; ?>)
								<?php } ?>
								</div>
							</div>
							<?php } ?>
							<?php  if(!empty($order->offer_type)){ ?>
							<div class="col-sm-6 float-left nopadding detail">
								<div><b>Upsell:</b> <?php echo !empty($order->last_order_id) ? 'Yes' : 'No'; ?></div>
							</div>
							<?php } ?>
							
							<?php if(!empty($order->upsells_title)){ ?>
							<div class="col-sm-6 float-left nopadding  detail">
								<div><b>Upsell Name:</b> <?php echo !empty($order->upsells_title ) ? str_replace( 'Upsell :-','',$order->upsells_title)  : ''; ?></div>
							</div>
							<?php } ?>
							
							<?php if(!empty($order->coupon_code)){ ?>
							<div class="col-sm-6 float-left nopadding  detail">
								<div><b>Coupon Code:</b> <?php echo !empty($order->coupon_code) ?$order->coupon_code : ''; ?></div>
							</div>
							<div class="col-sm-6 float-left nopadding  detail">
								<div><b>Coupon Discount:</b> <?php echo !empty($order->offer_type) ? $site_currency_type.$order->coupon_discount : '';  ?></div>
							</div>
							<?php } ?>
							
							<?php if(!empty($order->trans_status)){ ?>
							<div class="col-sm-6 float-left nopadding  detail">
								<div><b>Status:</b> <?php echo !empty($order->trans_status) ?  ucfirst($order->trans_status) : '';  ?></div>
							</div>
							<?php } ?>
							
							<?php if(!empty($order->amount)){ ?>
							<div class="col-sm-6 float-left nopadding  detail">
								<div><b>Amount:</b> <?php if(!empty($order->trial_id)){ if(!empty($order->amount)) { echo $site_currency_type.$order->amount; } else { echo ''; } } ?></div>
							</div>
							<?php } ?>
							
							
							<div class="col-sm-12 float-left nopadding  detail">
								<div><b>Page Url:</b> <?php echo ($order->page_url != '/') ? $order->page_url : 'Home Page'; ?></div>
							</div>
						
						<?php } ?>
						
						
						<?php if($order->lead_type != "dojocart"){ ?>
							<div class="col-sm-6 float-left nopadding  detail">
								<div><b>Client IP Address:</b> <?php echo $order->ip_address; ?></div>
							</div>
							<div class="col-sm-6 float-left nopadding  detail">
								<div><b>Client Country:</b> <?php echo $order->client_country_name; ?></div>
							</div>
							<?php if($this->query_model->get_gdpr_compliant() == 1){ ?>
							<div class="col-sm-6 float-left  nopadding detail">
								<div><b>GDPR:</b> <?php echo ($order->gdpr_compliant_checkbox = 1) ? 'Yes' : 'No'; ?></div>
							</div>
							<?php } ?>
							<div class="col-sm-6 float-left nopadding  detail">
								<div><b>Created Date:</b> <?php echo date('M d, Y h:i A ', strtotime($order->created)); ?></div>
							</div>
						
						<?php } ?>
						
						<div class="col-sm-6 float-left nopadding  detail">
							<div><b>Kanban Status:</b> <?php echo !empty($order->kanban_status_id) ?  $this->query_model->getKanbanStatusNameByID($order->kanban_status_id) : '';  ?></div>
						</div>
						<div class="col-sm-6 float-left nopadding  detail">
							<div><b>Tags:</b> 
							
							<span>
							<?php 
								$lead_type = $this->query_model->getKanbanLeadTypeToOrderType($order->lead_type); 
								$tags = $this->query_model->getOrderTagsByOrderId($order->id,$lead_type);
								
									if(!empty($tags)){ 
										foreach($tags as $tag_id => $tag){
							?>
							<span class="badge badge-pill badge-primary kanban_tags kanban_tag_<?php echo $tag_id; ?>"><?php echo $tag; ?></span>
							<?php } } ?>
							</span>
							
							</div>
						</div>
						
						<p><?php //echo '<pre>order'; print_r($order); ?></p>
					</div>
				</div>
			</div>
			<?php } } } ?>
		</div>
			
		
	</div>
</div>
