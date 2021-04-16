<style>
<!--
.manager-items .manager-item {
	min-height: 49px !important;
}
-->
</style>



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
<div class="btn-addentry"><a href="admin/<?=$link_type?>/add" style=""></a></div>
<ul class="cat_sort ui-sortable" style="">
<script language="javascript">
$(document).ready(function(){
/*try{
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
} catch(e) {  }*/	
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
	//exit(0);
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
<?php
$sr_header=0;  
if(!empty($slides)):?>
<?php foreach($slides as $slides):
$sr_header++; 
?>
									<li>
										<div class="manager-item">
											<div style="float:left;">
												<!-- <h2><?=$slides->id?></h2> --><h2><?=$sr_header?></h2><div class="manager-item-image" style="overflow: hidden; ">
													<img src="<?=$slides->photo?>" style="display: inline-block; width: 100px; margin-top: -14px; ">										</div>
												<h1><a href="admin/header/edit/<?=$slides->id?>" ><?=$slides->url;?></a></h1>
											</div>
											<div class="manager-item-opts"><a href="admin/header/edit/<?=$slides->id?>">Edit</a><a id="delitem_<?=$slides->id?>" class="delete_item" title="Delete <?=$slides->url;?>">Delete</a></div>
										</div>
									</li>
<?php endforeach;?>								
<input type="hidden" name="mod_type" value="<?=$link_type;?>" id="mod_type" />
<?php else: ?>
<div class="empty"><a href="admin/<?=$link_type?>/add" class="nothing-yet">Add new Page Header Image</a></div>
<?php endif;?>
								</ul>
<br />
</div>				
</div>

</div>

<?php $this->load->view("admin/include/conf_delete_item"); ?>
</div>
</div>
