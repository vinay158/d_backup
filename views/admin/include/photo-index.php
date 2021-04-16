<div class="gen-holder">
		<div class="gen-panel">
			<div class="panel-title">
<!--				<div class="panel-title-name"><?=$title?> Manager</div>-->
				
			</div>
<div class="panel-body">
<div class="panel-body-holder">
<div class="manager-items custom">
<div class="border">
<h1>Facility Photos</h1>
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

$(".delete_item").click(function(){
var del_item_id = $(this).attr("id").substr(8);
$("#delete-item-id").val(del_item_id);
$(".delete-holder-item").hide();
$(".delete-holder-item").slideDown(300);
//exit(0);
})
})
</script>
<?php if(!empty($staff)):?>
<?php foreach($staff as $staff): ?>
									<li   id="menu_<?=$staff->id?>">
										<div class="manager-item">
											<div style="float:left;">
												<h2><?=$staff->id?></h2><div class="manager-item-image" style="overflow: hidden; ">
													<img src="<?=$staff->photo?>" style="display: inline-block; width: 100px; margin-top: -14px; ">										</div>
												<h1><a><?=$staff->name;?></a></h1>
											</div>
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
