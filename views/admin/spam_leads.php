<?php $this->load->view("admin/include/header"); ?>

<link rel="stylesheet" href="<?=base_url();?>css/blue/style.css" type="text/css" media="print, projection, screen" />
<link href="<?=base_url();?>assets_admin/lib/lightslider/css/lightslider.min.css" rel="stylesheet">
<link href="<?=base_url();?>assets_admin/lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet">

   <script>
   $(document).ready(function(){
	   /*$('.view_lead_detail').click(function(){
		   var lead_id = $(this).attr('lead_id');
		   $("#lead_"+lead_id).show();
		   $( "#lead_"+lead_id ).dialog();
	   })*/
	   
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
				url : '<?=base_url();?>admin/leads/delete_s_leads',
				type :'POST',
				dataType :'json',
				data : {number : number, action: 'delete_record'}
			}).done(function(result){
				if(result == 1){
					
					var redirect_url = '<?=base_url();?>admin/leads/s_leads';
					if(month_record != ''){
						redirect_url = '<?=base_url();?>admin/leads/s_leads?date='+month_record;
					}
					window.location = redirect_url;
				}
			});
		}
	});
	
	$("#myTable").tablesorter({ }); 
	
	//var mod_type = $("#mod_type").val().toLowerCase();
	
})

/*function deleteEntry(id){		
		
	if(confirm('Are you sure to delete this record??')){
		window.location = '<?=base_url();?>admin/leads/deletecontactlead/'+id;
		return true;
	}
} */

</script>

<div class="az-content-body-left advanced_page custom_full_page onlinedojo_users_page user_attendance_page rank_traker_api_page order_listing_page spam_leads_page" >
	<div class="az-content-header d-block d-md-flex">
		 <div class="col-md-12 col-lg-12 col-xl-12 mg-b-20 position-top">
				<div class="float-left az-dashboard-one-title">
				 <h2 class="az-dashboard-title"><?= $title ?>  </h2>
					
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
			<div class="mb-3 main-content-label page_main_heading"><?=$title?></div>
			
			<div class="form-new-holder">
			<div class="row row-xs align-items-center">
				
				<div class="col-md-12  mg-t-5 mg-md-t-0 next_previous_box">
				<div class="row mg-t-10">
				<div class="col-md-4">
						 <?php if(!empty($contacts)){ ?>
						<!-- <div class="delete_all_box">
						<input type="checkbox" class="mainCheckbox"><a href="javascript:void(0);" class="deleteAllLeads">Delete Leads</a>
						</div> -->
						<?php } ?>
					</div>
				
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
				<div class="col-md-1">
						<a href="<?php echo 'admin/'.$link_type.'?date='.$preDate; ?>&location=<?php echo (isset($_GET['location'])) ? $_GET['location'] : ''; ?>" class="btn btn-primary" >  &lt;Prev  </a>  
					</div>
					
				<div class="col-lg-2 active">
						 <span><?php echo date('F Y', strtotime($activeDate)); ?> </span> 
					</div>
				
				<?php if(!empty($nextDate) && $nextDate < $currentDate){ ?>
					<div class="col-lg-1">
						 <a href="<?php echo 'admin/'.$link_type.'?date='.$nextDate; ?>&location=<?php echo (isset($_GET['location'])) ? $_GET['location'] : ''; ?>" class="btn btn-primary  "> Next&gt; </a>
					</div>
				<?php } ?>
				
				
				<?php /*if($multiLocation[0]->field_value == 1){ ?>
			<li style="margin-left:100px">
				<select  id='location_sort' class="field">
					<option value="">-All Locations-</option>
					<?php foreach($allLocations as $location){ ?>
					<option value="<?php echo $location->name ?>" <?php echo (isset($_GET['location']) && $_GET['location'] == $location->name) ? "selected=selected" : ''; ?>><?php echo $location->name; ?></option>
					<?php } ?>
				</select>
			</li>
			<?php }*/ ?>
							
					
					</div>
				</div>
			</div>
			</div>

</form>	
<div style="clear:both"></div>
			
			
			
			  <div class="az-content-body-left online_dojo_users_list" >
			  
			

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
									<th class="wd-5p">Program</th>
									<th class="wd-5p">Date</th>
									<th class="wd-10p">Action</th>
                                </thead>
                                <tbody>
                            <?php if(!empty($contacts)):?>    
                               <?php 
								$n = $number;
								foreach($contacts as $contact):
							?>
                                
                                <tr id="menu_<?php echo $contact->id; ?>" class="full_width_row_<?php echo $contact->id; ?>">
                                  <!-- <td><input type="checkbox" class="checkbox_list" name="lead_ids[<?php echo $contact->id ?>]" value="<?php echo $contact->id ?>"></td> -->
                                   <td><?php echo $n; ?></td>
                                   <td><?php echo $contact->name; ?></td>
                                    <td><?=$contact->phone?></td>
                                    <td><?=$contact->email?></td>
                                    <td><?=$contact->school?></td>
                                    <td><?=$contact->program?></td>
                                    <td><?php echo date('M d, Y ', strtotime($contact->created_at)); ?></td>
                                    <td><!--<a href="<?=base_url();?>admin/leads/editcontactlead/<?=$contact->id?>">Edit</a><br /> -->
										<!--<a href="javascript:void(0);" class="view_lead_detail" lead_id="<?=$contact->id?>">View Lead Details</a> || 
									
                                    	<a href="javascript:void(0)" class='delete_record' number="<?=$contact->id?>" >Delete</a>-->
										
										<div class="manager-item-opts">
											<nav class="nav" style="width:118px">
												 
												  <a href="javascript:void(0)" class="badge badge-primary view_lead_detail lb-preview "  lead_type="spam_lead" lead_id="<?php echo $contact->id; ?>" email="<?php echo $contact->email; ?>" popup_title="<?=$contact->email?>" > View</a>
												  
												 <a class="badge badge-primary ajax_record_delete" data-toggle="modal" data-target="#popupDeleteRecord" item_id="<?php echo $contact->id; ?>" table_name="tbl_sp_leads" item_title="<?=$contact->email?>" section_type="full_width">Delete</a>
												  
												
											</nav>

								</div>
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
		
		
		 $('body').on('click','.view_lead_detail',function(){
			   var lead_id = $(this).attr('lead_id');
			   var email = $(this).attr('email');
			   var popup_title = $(this).attr('popup_title');
			   
			   $.ajax({
					url : '<?=base_url();?>admin/leads/ajax_spam_lead_info',
					type :'POST',
					dataType :'html',
					data : {lead_id : lead_id, email : email, action: 'get_record'}
				}).done(function(result){
					//$('#popupLeadInfo').modal('show');
					$('#popupSpamLeadInfo').modal({
						backdrop: 'static',
						keyboard: false
					})
					$('.user_name_info').html(popup_title);
					$('#order_lead_info').html(result);
				});
		   })
		   
		
		
});
</script>

<div id="popupSpamLeadInfo" class="modal">
      <div class="modal-dialog modal-dialog-centered sortable-box" role="document" style="max-width:auto">
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
