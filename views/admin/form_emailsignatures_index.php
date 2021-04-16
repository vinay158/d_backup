<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<div class="gen-holder">
		<div class="gen-panel">
			<div class="panel-title">
				<div class="panel-title-name"><?=$title?> Manager</div>
				
			</div>
<div class="panel-body">
<div class="panel-body-holder">
<div class="manager-items custom">
<div class="border floatNone">
<h1><?=$title?><?php if($user_level == 1) {?><a href="admin/<?=$link_type?>/add" style="" class="button_class">Add Email Signature</a><?php } ?></h1>
<script language="javascript">
	
			$(document).ready(function(){
			
			$(".main_location").click(function(){
				
				var answer = confirm ("Are you Sure you want to change theme?");
				if (answer){		
					var theme_id = $(this).attr("number");
						
					var mod_type = $("#mod_type").val().toLowerCase();
					$.ajax({ 					
					type: 'POST',						
					url: 'admin/'+mod_type+'/selectMainTheme',						
					data: { theme_id :theme_id}					
					}).done(function(msg){ 
					/*$("#success_message").html("<b>Successfully change main location.</b>");
						setTimeout(function() {
							$('#success_message').fadeOut('slow');
						}, 3000);*/
					
					$("#success_message").html("<b>Successfully change theme.</b>");
						setTimeout(function() {
							$('#success_message').fadeOut('slow');
						}, 3000);
					});		
				}
				else{		
					return false;
				}
				
				});
			})
			</script>




<!--- DOJO 18/11 --->
<div id="success_message" style="text-align:center"></div>
<!--- end ---->


<ul class="cat_sort ui-sortable" style="">

			
<script language="javascript">
$(document).ready(function(){


$(".unpublish").click(function(){
	
	var pub_id = $(this).attr("id");
	var mod_type = $("#mod_type").val();
	var publish_type = $(this).parents(".manager-item-opts").children(".publish_type").val();
	
	$.ajax({ 					
	type: 'POST',						
	url: 'admin/'+mod_type+'/publish',						
	data: { pub_id : pub_id, publish_type: publish_type }					
	}).done(function(msg){ 
	if(msg != null){
	//alert(msg);
	setTimeout("window.location.reload()",1000);
	}
	else{
	setTimeout('$("#alert-holder").html("<div><b class=red>Unable to Unpublish.</b></div>")',1000);
	//alert(msg);
	}
	});
	return false;
});


// DOJO 19/11
$(".delete_item").click(function(){
	
	//return false;
	var del_item_id = $(this).attr("number");
	$("#delete-item-id").val(del_item_id);
	$(".delete-holder-item").hide();
	$(".delete-holder-item").slideDown(300);
	
})
})
</script>
<?php


if(!empty($details)):?>
<?php 

foreach($details as $detail):
//$sr_theme++; 
?>
									<li  id="menu_<?=$detail->id?>" class="contactLocation contact<?=$detail->id?>">
										<div class="manager-item">
											<div style="float:left;">
												<h2><?=$detail->id?></h2>
												<h1><a href="admin/<?=$link_type;?>/edit/<?=$detail->id;?>"><?=$detail->location_name;?></a></h1>
											</div>
											
											
											<?php if($user_level == 1) {?>
											<div class="manager-item-opts"><a href="admin/<?=$link_type;?>/edit/<?=$detail->id;?>" class="lb-preview">Edit</a>
                                            
											<a id="<?=$detail->id?>" class="delete_item" number="<?=$detail->id?>" title="Delete <?=$detail->tag;?>">Delete</a></div>
										</div>
										<?php } ?>
									</li>
									
<?php endforeach;?>								
<input type="hidden" name="mod_type" value="<?=$link_type;?>" id="mod_type" />
<?php else: ?>
<div class="empty"><a href="admin/<?=$link_type?>/add" class="nothing-yet">Add an Entry to this Section</a></div>
<?php endif;?>
								</ul>
<br />
</div>				
</div>

</div>

<?php $this->load->view("admin/include/conf_delete_item"); ?>
</div>
</div>

<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>
