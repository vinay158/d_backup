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
	
	$("#myTable").tablesorter({ }); 
	
	var mod_type = $("#mod_type").val().toLowerCase();
	
})

function deleteEntry(id){		
		
	if(confirm('Are you sure to delete this record??')){
		window.location = '<?=base_url();?>admin/leads/deletegettipslead/'+id;
		return true;
	}
}

</script>
<div class="gen-holder">
		<div class="gen-panel">
			<div class="panel-title">
				<div class="panel-title-name">Get Tips Leads</div>
			</div>
             
			<div class="panel-body">
				<div class="panel-body-holder">
					<div class="manager-items custom">
						<div class="border">
							<h1><?=$title?></h1>
                            <a href="<?=base_url();?>admin/leads/exportgettipsleads" style="float: right; padding-right: 15px;"><strong>Export List</strong></a>

							<?php if(!empty($tips)):?>

                            <table cellpadding="2" cellspacing="2" width="100%" id="myTable" class="tablesorter">
                                <thead>
                                
                                    <th align="left">Name</th>
                                    <th align="left">Phone</th>
                                    <th align="left">E-mail</th>                                    
                                 	<th align="left">Date</th>
                                    <th>&nbsp;</th>
                                </thead>
                                <tbody>
                                
                                <?php foreach($tips as $tip):?>
                                
                                <tr>
                                    <td><?=$tip->name?></td>
                                    <td><?=$tip->phone?></td>
                                    <td><?=$tip->email?></td>                                    
                                    <td><?php echo date('M d, Y ', strtotime($tip->date_added)); ?></td>
                                    <td><a href="<?=base_url();?>admin/leads/editgettipslead/<?=$tip->id?>">Edit</a><br />
                                    	<a onclick="return deleteEntry(<?=$tip->id?>)">Delete</a></td>
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