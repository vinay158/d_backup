<?php $this->load->view("admin/include/header"); ?>

<link rel="stylesheet" href="<?=base_url();?>css/blue/style.css" type="text/css" media="print, projection, screen" />
<link href="<?=base_url();?>assets_admin/lib/lightslider/css/lightslider.min.css" rel="stylesheet">
<link href="<?=base_url();?>assets_admin/lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet">

   <script>
   $(window).load(function(){
	   var sort_date = $(".sort_dates").val();
		if(sort_date == "custom_range"){
			$('.custom_daterange_box').show();
			$('.dateRange').attr('required',true);
		}else{
			$('.custom_daterange_box').hide();
			$('.dateRange').attr('required',false);
		}
   })
   $(document).ready(function(){
	   /*$('.view_lead_detail').click(function(){
		   var lead_id = $(this).attr('lead_id');
		   $("#lead_"+lead_id).show();
		   $( "#lead_"+lead_id ).dialog();
	   })*/
	   
	    $('.view_lead_detail').click(function(){
		   var lead_id = $(this).attr('lead_id');
		   var email = $(this).attr('email');
		   var popup_title = $(this).attr('popup_title');
		   var lead_type = $(this).attr('lead_type');
		   
		   $.ajax({
				url : '<?=base_url();?>admin/leads/ajax_trial_lead_info',
				type :'POST',
				dataType :'html',
				data : {lead_id : lead_id, email : email,lead_type:lead_type, action: 'get_record'}
			}).done(function(result){
				//$('#popupLeadInfo').modal('show');
				$('#popupLeadInfo').modal({
					backdrop: 'static',
					keyboard: false
				})
				$('.user_name_info').html(popup_title);
				$('#order_lead_info').html(result);
			});
	   })
	   
	  /* $('.view_lead_detail').click(function(){
		   var lead_id = $(this).attr('lead_id');
		   var email = $(this).attr('email');
		   var popup_title = $(this).attr('popup_title');
		   
		   $.ajax({
				url : '<?=base_url();?>admin/leads/ajax_trial_lead_info',
				type :'POST',
				dataType :'html',
				data : {lead_id : lead_id, email : email, action: 'get_record'}
			}).done(function(result){
				$('#popupLeadInfo').modal('show');
				$('.user_name_info').html(popup_title);
				$('#order_lead_info').html(result);
			});
	   })*/
	   
	   
	   $('#location_sort').change(function(){
			/*var location = $(this).val();
			var queryString = '';
			<?php if(isset($_GET['date'])){ ?>
					queryString = '?date='+"<?php echo $_GET['date'] ?>&location="+location;
			<?php }else{ ?>
					queryString = "?location="+location;
			<?php } ?>
			
			var redirect_path = "<?php echo base_url().ltrim($_SERVER['REDIRECT_QUERY_STRING'],'/') ?>"+queryString;
			//alert(redirect_path); return false;
			window.location.href = redirect_path;*/
			
		})
		
		$('.sort_dates').change(function(){
			var sort_date = $(this).val();
			if(sort_date == "custom_range"){
				$('.custom_daterange_box').show();
				$('.dateRange').attr('required',true);
			}else{
				$('.custom_daterange_box').hide();
				$('.dateRange').attr('required',false);
			}
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
	
	/*$('.delete_record').click(function(){
		
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
	});*/
	
	
	/*$("#myTable").tablesorter({ }); 
	
	var mod_type = $("#mod_type").val().toLowerCase();*/
	
	
	
})

/*function deleteEntry(id){		
		
	if(confirm('Are you sure to delete this record??<?=base_url();?>admin/leads/deleteOnlineTrialLead/'+id)){
		window.location = '<?=base_url();?>admin/leads/deleteOnlineTrialLead/'+id;
		return true;
	}
}*/


</script>

<div class="az-content-body-left advanced_page custom_full_page onlinedojo_users_page user_attendance_page rank_traker_api_page order_listing_page" >
	<div class="az-content-header d-block d-md-flex">
		 <div class="col-md-12 col-lg-12 col-xl-12 mg-b-20 position-top">
				<div class="float-left az-dashboard-one-title">
				 <h2 class="az-dashboard-title"><?= $title ?>  </h2>
					
				</div>
				<div class="float-right back_to_kanban_box">
						
						<a href="<?php echo base_url().'admin/kanban_leads'; ?>"><button class="btn btn-with-icon btn-block"><i class="typcn typcn-folder"></i>Switch to Column View</button></a>
						
					</div>
			</div>
		  
		  
	  </div>
	   <div class="row row-sm program-cat-page" style="clear:both">

          <div class="col-sm-12 col-xl-12 az-content-body-contacts"  >
			<div class="card pd-sm-20 edit-form">
<form  method="get" action="">				
<div class="gen-holder">
		<div class="gen-panel searchbox">
			
			<h1 > &nbsp;&nbsp; </h1>
			<div class="mb-3 main-content-label page_main_heading"><?=$title?> : <?php echo (strtotime($start_date) != strtotime($end_date)) ?  date('d M Y', strtotime($start_date)).' to '.date('d M Y', strtotime($end_date)) : date('d M Y', strtotime($start_date)); ?></div>
			
			<div class="form-new-holder">
			<div class="row row-xs align-items-center">
				
				<div class="col-md-12  mg-t-5 mg-md-t-0">
				<div class="row mg-t-10">
				<div class="col-md-2">
						<h1>Status</h1>
						<select name="lead_status" id="" class="field search_field">
							<option value="">-All Status-</option>
							<?php foreach($kanban_lead_all_status as $key => $status){ ?>
								<option value="<?php echo $status->id; ?>" <?php echo (isset($_GET['lead_status']) && $_GET['lead_status'] == $status->id) ? "selected=selected" : ''; ?>><?php echo $status->title; ?></option>
							<?php } ?>
						</select>
					</div>
				
				<div class="col-md-2">
						<h1>Tag</h1>
						<select name="tags" id="" class="field search_field">
							<option value="">-All Tag-</option>
							<?php foreach($kanban_lead_tags as $key => $val){ ?>
								<option value="<?php echo $val->tag; ?>" <?php echo (isset($_GET['tags']) && $_GET['tags'] == $val->tag) ? "selected=selected" : ''; ?>><?php echo $val->tag; ?></option>
							<?php } ?>
						</select>
					</div>
					
				<div class="col-lg-2">
						<h1>Lead Type</h1>
						<select name="lead_type" id="" class="field search_field">
							<option value="all">-All Types-</option>
							<?php foreach($lead_types as $key => $val){ ?>
								<option value="<?php echo $key; ?>" <?php echo (isset($_GET['lead_type']) && $_GET['lead_type'] == $key) ? "selected=selected" : ''; ?>><?php echo $val; ?></option>
							<?php } ?>
						</select>
					</div>
				
					<div class="col-lg-2">
						<h1>Date Range</h1>
						<select name="date_sort" id="" class="field sort_dates search_field">
							<?php foreach($dateRanges['sorting_list'] as $key => $val){ ?>
								<option value="<?php echo $key; ?>" <?php echo ($key == $date_sort) ? 'selected=selected' : '' ?>><?php echo $val; ?></option>
							<?php } ?>
						</select>
					</div>
					<link rel="stylesheet" href="/resources/demos/style.css" />
					<script>
					$(function() {
						$( "#start_date" ).datepicker({ dateFormat: "yy-mm-dd",maxDate: new Date() });
						$( "#end_date" ).datepicker({ dateFormat: "yy-mm-dd",maxDate: new Date() });
					});
					</script>
							<div class="col-lg-2 custom_daterange_box" style="display:none">
								<h1>Start Date</h1>
								<input type="text" value="<?php echo $start_date; ?>" name="start_date" id="start_date" class="dateRange field" placeholder="mm/dd/yyyy" maxlength="10"/>
							</div>
							<div class="col-lg-2 custom_daterange_box" style="display:none">
								<h1>End Date</h1>
								<input type="text" value="<?php echo $end_date; ?>" name="end_date" id="end_date" class="dateRange field" placeholder="mm/dd/yyyy" maxlength="10"/>
							</div>
							
					<?php if($multiLocation[0]->field_value == 1){ ?>
					<div class="col-lg-2">
						<h1>Location</h1>
							<select  id='location_sort' name="location" class="field search_field">
								<option value="">-All Locations-</option>
								<?php foreach($allLocations as $location){ ?>
								<option value="<?php echo $location->id ?>" <?php echo (isset($_GET['location']) && $_GET['location'] == $location->id) ? "selected=selected" : ''; ?>><?php echo $location->name; ?></option>
								<?php } ?>
							</select>
					</div><!-- col-3 -->
					<?php } ?>
							
							<div class="col-lg-2">
								<h1>&nbsp;</h1>
								<input type="submit" value="Search" class="searchbtn btn-save" />
							</div>
							
							
					
					</div>
				</div>
			</div>
			</div>

</form>	
<div style="clear:both"></div>
			
			
			
			  <div class="az-content-body-left online_dojo_users_list" >
			  
			  <div class="az-content-header d-block d-md-flex">
				
				<div class="col-lg-12" style="padding:0px">
					
					<div class="col-lg-12 float-left nopadding import_csv_box">
					 <form action="<?=base_url();?>admin/leads/importOrderLeads" method="post" enctype="multipart/form-data">
							<div class="col-lg-3 float-left nopadding">
							<div class="custom-file half_width_custom_file">
							<input type="file" name="importCsv" class="custom-file-input" id="customFile1">
							<label class="custom-file-label" for="customFile">Choose file</label></div>
							</div>
							<div class="col-lg-2 float-left">
							<input type="submit" name="submitCsv" class="submitCsv btn-save" value="Import">
							</div>
							<div class="col-lg-3 float-left">
							 <a href="<?=base_url();?>admin/leads/exportorderleads/?location=<?php echo (isset($_GET['location'])) ? $_GET['location'] : ''; ?>" class="button_class btn btn-outline-light">Export List</a> 
							</div>
						</form>
					</div>
					
				</div>
				<div class="clearfix"></div>
			  </div>	


       <div class="row">

          <div class="col-sm-12 col-xl-12 nopadding rank_traker_response">
			<h1>&nbsp;</h1>
							
							
							<form id="allDeleteForm" method="post" action="<?php echo base_url().'admin/leads/deleteAllLeads' ?>">
							<input type="hidden" name="table_name" value="tblorders">
							<input type="hidden" name="redirect_url" value="admin/leads">
                            <table id="example3" class=" table ">
                                <thead>
                                
                                   <!-- <th align="left"> &nbsp; </th> -->
                                    <th class="wd-5p">S.No</th>
                                    <th class="wd-5p">Name</th>
                                    <th class="wd-5p">Phone</th>
                                    <th class="wd-5p">Email</th>
                                    <th class="wd-5p">School</th>
									<th class="wd-5p">Type</th>
									<th class="wd-5p">Payment Status</th>
									<th class="wd-5p">Status</th>
									<th class="wd-10p">Date</th>
                                    <th class="wd-5p">Action</th>
                                </thead>
                                <tbody>
                            <?php if(!empty($all_leads)):?>    
                                <?php 
								
								$site_currency_type = $this->query_model->getSiteCurrencyType();
								$n = 1;
								foreach($all_leads as $order):
									
								?>
                                
                                <tr class="order_lead_<?php echo $order->id ?> <?php echo $order->lead_type; ?>_<?php echo $order->id ?>">
                                   <!-- <td><input type="checkbox" class="checkbox_list" name="lead_ids[<?php echo $order->id ?>]" value="<?php echo $order->id ?>"></td> -->
                                    <td><?=$n?></td>
                                    <td><?=$order->name.' '.$order->last_name?></td>
                                    <td><?=$order->phone?></td>
                                    <td><?=$order->email?></td>
                                   
                                    
                                    <td>
									<?php 
										$this->db->select(array('id','name'));
										$school_detail = $this->query_model->getbySpecific('tblcontact','id',$order->location_id); 
										if(!empty($school_detail)){ echo $school_detail[0]->name;}
									?>
									</td>
									
									
									<td><?php //echo ($order->offer_type == "paid") ? '<span class="badge badge-pill badge-danger">Paid Trial</span>' : '<span class="badge badge-pill badge-secondary">Free Trial </span>'; 
									?>
									<span class="badge badge-pill badge-secondary"><?php echo ucwords(str_replace('_',' ',$order->lead_type)) ?> <?php echo !empty($order->last_order_id) ? ' - Upsell' : ''; ?></span>
									
									
									</td>
									<td><?php echo !empty($order->trans_status) ?  ucfirst($order->trans_status) : '';  ?></td>
									<td><?php echo !empty($order->kanban_status_id) ?  $this->query_model->getKanbanStatusNameByID($order->kanban_status_id) : '';  ?></td>
									
									<td><?php echo date('M d, Y ', strtotime($order->created)); ?></td>
                                    <td ><!--<a href="<?=base_url();?>admin/leads/edittrial/<?=$order->id?>">Edit</a> -->
									
									<a href="javascript:void(0)" class="view_lead_detail" lead_type="<?php echo $order->lead_type; ?>" lead_id="<?php echo $order->id; ?>" email="<?php echo $order->email; ?>" popup_title="<?=$order->email?>" ><i class="fa fa-eye"></i></a>
									
									 &nbsp;&nbsp;
									 
                                    
									<a class="ajax_lead_record_delete" data-toggle="modal" data-target="#popupDeleteLeadRecord" item_id="<?=$order->id;?>" email="<?php echo $order->email; ?>"  lead_type="<?php echo $order->lead_type; ?>" item_title="<?=$order->email;?>"><i class="fa fa-trash"></i></a>
									
									</td>
									
                                </tr>
                                
                                <?php $n++; endforeach;?>	
								<?php endif; ?>
                            </tbody>
						</table>
						</form>
							
          </div>
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

<?php //$this->load->view("admin/include/conf_delete_item"); ?>



<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>

<script src="<?=base_url();?>assets_admin/lib/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url();?>assets_admin/lib/datatables.net-dt/js/dataTables.dataTables.min.js"></script>
<script src="<?=base_url();?>assets_admin/lib/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=base_url();?>assets_admin/lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js"></script>


<script type="text/javascript">

$(document).ready(function() {
   // For a doughnut chart
		$('.table').DataTable({
		 "ordering": true,
			responsive: true,
				language: {
				searchPlaceholder: 'Search...',
				sSearch: '',
			}
        });
		
		
		$('[data-toggle="popover"]').popover();

        $('[data-popover-color="head-primary"]').popover({
          template: '<div class="popover popover-head-primary" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>'
        });
		
		
		$('body').on('click','.ajax_lead_info_record_delete', function(){
			var item_id = $(this).attr('item_id');
			var lead_type = $(this).attr('lead_type');
			var item_title = $(this).attr('item_title');
			var email = $(this).attr('email');
			var form_action = "admin/leads/ajax_delete_single_lead";
			if (!confirm('Are you sure?')) return false;
			$.ajax({ 					
			type: 'POST',						
			url: form_action,						
			data: { item_id : item_id,lead_type:lead_type,item_title:item_title,email:email, action:'delete_single_lead'}					
			}).done(function(msg){ 
			if(msg == 1){
				
				$('.'+lead_type+'_'+item_id).remove();
				
			}
			else{
				alert("Oops! Something went wrong!");
				return false;
						
			}
		})
	})
	
		
});
</script>

<div id="popupLeadInfo" class="modal">
      <div class="modal-dialog modal-dialog-centered sortable-box" role="document">
        <div class="modal-content modal-content-demo">
          <div class="modal-header">
            <h6 class="modal-title user_name_info">User Attendance Info</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
		  <div class="modal-body">
				<div id="order_lead_info"></div>
		  </div>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->
