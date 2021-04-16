<div class="gen-holder">
		<div class="gen-panel">
			<div class="panel-title">
				<div class="panel-title-name"><?=$title?> Manager</div>
				
			</div>
<div class="panel-body">
<div class="panel-body-holder">
<div class="manager-items custom">
<div class="border">
<h1>Top Navigation Links</h1>
<div class="btn-addentry add_entry_button"><a href="admin/<?=$link_type?>/add" style="">Add Entry</a></div>
<div class="dragDropContent">
	You may rearrange the order of the items below by dragging them above or below other item rows. Changes will automatically be saved.
</div>
<ul class="cat_sort ui-sortable" style="">
<script language="javascript">
$(document).ready(function(){


var mod_type1 = $("#mod_type").val().toLowerCase();

$(".ui-sortable").sortable({
update : function () {
serial = $('.ui-sortable').sortable('serialize');
$.ajax({
url: "admin/"+mod_type1+"/sortthis",
type: "post",
data: serial,
error: function(){
alert("theres an error with AJAX");
}
});
}
});

$(".unpublish").click(function(){
	var pub_id = $(this).attr("id").substr(6);
	var mod_type = $("#mod_type").val().toLowerCase();
	var publish_type = $(this).parents(".manager-item-opts").children(".publish_type").val();
	//alert (publish_type);
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
$(".delete_item").click(function(){
var del_item_id = $(this).attr("id").substr(8);
$("#delete-item-id").val(del_item_id);
$(".delete-holder-item").hide();
$(".delete-holder-item").slideDown(300);
//exit(0);
return false;
})
})
</script>
<?php $sr_staff=0;
if(!empty($staff)):?>
<?php foreach($staff as $staff):
$sr_staff++;  
?>
								<li id="menu_<?=$staff->id?>">
										<div class="manager-item">
											<div style="float:left;">
												<!-- <h2><?=$staff->id?></h2> -->
												<h2><?= $sr_staff;?></h2>
												<h1><a href="admin/<?=$link_type?>/edit/<?=$staff->id;?>" ><?=$staff->name;?></a></h1>
											</div>
											<div class="manager-item-opts"><a href="admin/<?=$link_type?>/edit/<?=$staff->id;?>" class="lb-preview">Edit</a>
											<a id="delitem_<?=$staff->id?>" class="delete_item" title="Delete <?=$staff->name;?>">Delete</a></div>
										</div>
									</li>
<?php endforeach;?>								
<input type="hidden" name="mod_type" value="<?=$link_type;?>" id="mod_type" />
<?php else: ?>
<div class="empty"><a href="admin/<?=$link_type?>/add" class="nothing-yet">Add an Entry to this Category</a></div>
<?php endif;?>
								</ul>
<br />
</div>				
</div>

</div>

<?php $this->load->view("admin/include/conf_delete_item"); ?>
</div>
</div>
