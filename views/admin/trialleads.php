<?php $this->load->view("admin/include/header"); ?>
<link rel="stylesheet" href="<?=base_url();?>css/blue/style.css" type="text/css" media="print, projection, screen" />
<style>
<!--
.manager-items .manager-item {
	min-height: 49px !important;
}
-->
</style>

<script language="javascript">
$(document).ready(function(){
	
	$("#myTable").tablesorter({ headers: { 6: { sorter: false} }}); 
	
	var mod_type = $("#mod_type").val().toLowerCase();
	
})

function deleteEntry(id){		
		
	if(confirm('Are you sure to delete this record??')){
		window.location = '<?=base_url();?>/admin/leads/deletetrial/'+id;
		return true;
	}
}
	
</script>

<div class="gen-holder">
		<div class="gen-panel">
			<div class="panel-title">
				<div class="panel-title-name">Online Trial Leads</div>				
			</div>
             
			<div class="panel-body">
				<div class="panel-body-holder">
					<div class="manager-items custom">
						<div class="border floatNone">
							<h1><?=$title?> <a href="<?=base_url();?>admin/leads/exporttrials" class="button_class" >Export List</a></h1>&nbsp;
                            

							<?php if(!empty($trials)):?>

                            <table cellpadding="2" cellspacing="2" width="100%" id="myTable" class="tablesorter">
                                <thead>
                                <tr>
                                    <th align="left">Name</th>
                                    <th align="left" width="100px;">Phone</th>
                                    <th align="left">E-mail</th>
                                    <th align="left" width="50px;">Age</th>
                                    <th align="left">Program</th>
                                    <th align="left">School</th>
                                    <th align="left">Message</th>
                                    <th align="left">Payment Status</th>
                                 	<th align="left">Date</th>
                                    <th align="left">&nbsp;</th>
                                 </tr>
                                </thead>
                                <tbody>
                                
                                <?php foreach($trials as $trial):?>
                                
                                <tr>
                                    <td><?=$trial->name?></td>
                                    <td><?=$trial->phone?></td>
                                    <td><?=$trial->email?></td>
                                    <td><?=$trial->age?></td>
                                    <td><?=$trial->program_of_interest?></td>
                                    <td><?=$trial->school_of_interest?></td>
                                    <td><?=$trial->message?></td>
                                    <td>
                                    	<?php 
											if($trial->payment_status == 'Completed'){
												echo 'Paid';
											}
										?>
                                    </td>
                                    <td><?php echo date('M d, Y ', strtotime($trial->date_added)); ?></td>
                                    <td><a href="<?=base_url();?>/admin/leads/edittrial/<?=$trial->id?>">Edit</a><br />
                                    	<a onclick="return deleteEntry(<?=$trial->id?>)">Delete</a></td>
                                </tr>
                                
                                <?php endforeach;?>	
                            </tbody>
						</table>
							<?php endif; ?>
						</div>
					</div>
				</div> 
			</div>

</div>
</div>

<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>