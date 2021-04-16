<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<script language="javascript">

$(document).ready(function(){	

	$(".unpublish").click(function(){
	
		var pub_id = $(this).attr("id").substr(6);
		
		var publish_type = $(this).parents(".manager-item-opts").children(".publish_type").val();

		$.ajax({ 					
			type: 'POST',						
			url: 'admin/about/publishfacility',						
			data: { pub_id : pub_id, publish_type: publish_type }					
		}).done(function(msg){ 
			if(msg != null){
				setTimeout("window.location.reload()",1000);
			}
			else{
				setTimeout('$("#alert-holder").html("<div><b class=red>Unable to Unpublish.</b></div>")',1000);
			}
		});
		
		return false;
	});
	
	$(".delete_item").click(function(){
		var del_item_id = $(this).attr("id").substr(8);
		$("#delete-item-id").val(del_item_id);
		$(".delete-holder-item").hide();
		$(".delete-holder-item").slideDown(300);
		//exit(0);
	})
})
</script>

<div class="gen-holder">
	<div class="gen-panel">
		<div class="panel-title">
			<div class="panel-title-name"><?=$title?> Manager</div>				
		</div>
        
		<div class="panel-body">
			<div class="panel-body-holder">
				<div class="manager-items custom">
					<div class="border">
						<h1><?=$title?></h1>
                        
						<?php /*if($IsAllowMultiFacility == 1) {?>
                        	<div class="btn-addentry"><a href="admin/about/addfacility" style=""></a></div>
                        <?php } */?>                       
                        
                        <?php
							if(!$has_main){
						?>
                        		<span style="float: right"><a href="admin/about/addmainfacility">Create Landing Facility page</a></span>
                        <?php
							}
						?>

						<?php
                        	$sr_facility=0; 
                        	if(!empty($facilities)):
                        		echo '<ul class="cat_sort" style="">';
								
                         		foreach($facilities as $facility):
                        			$sr_facility++; 
                        ?>
									<li id="menu_<?=$facility->id?>">
										<div class="manager-item">
											<div style="float:left;">									
												<h2><?=$sr_facility?></h2>
												<h1><a href="admin/about/addfacility/<?=$facility->id;?>"><?=$facility->title;?></a> - <?=$facility->name;?></h1>
											</div>
                                            
											<div class="manager-item-opts">
                                            	<a href="admin/about/addfacility/<?=$facility->id;?>" class="lb-preview">Edit</a>
                                                
												<?php if($facility->published == 1){?>
													<a id="unpub_<?=$facility->id; ?>" class="unpublish" title="Unpublish <?=$facility->title?>">Unpublish</a>
													<input type="hidden" name="publish_type" value="0" class="publish_type" />
												<?php }else{ ?>
													<input type="hidden" name="publish_type" value="1" class="publish_type" />
													<a id="unpub_<?=$facility->id;?>" class="unpublish" title="Publish <?=$facility->title?>">Publish</a>
												<?php }?>
                                                
												<!-- <a id="delitem_<?=$facility->id?>" class="delete_item" title="Delete <?=$facility->title;?>">Delete</a> -->
											</div>
										</div>
									</li>
						<?php 	
								endforeach;
								echo '</ul>';
						?>							
					<?php else: ?>
						<div class="empty"><a href="admin/about/addfacility" class="nothing-yet">Add an Entry to this Section</a></div>
					<?php endif;?>
					<br />
				</div>				
				</div>

			</div>

			<?php $this->load->view("admin/include/conf_delete_facility"); ?>
		</div>
	</div>
</div>

<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>
