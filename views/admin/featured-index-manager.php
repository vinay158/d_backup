<style>
<!--
.manager-items .manager-item {
	min-height: 49px !important;
}

#dropdown-holder, .delete-holder, .delete-holder-advert {
    left: 0;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 2000;
}
-->
</style>

<script language="javascript">
$(document).ready(function(){
var mod_type1 = $("#mod_type").val().toLowerCase();
	
	$(".delete_item").click(function(){
		var del_item_id = $(this).attr("id").substr(8);
		$("#delete-item-id").val(del_item_id);
		$(".delete-holder-item").hide();
		$(".delete-holder-item").slideDown(300);
		//exit(0);
	})
	
	$(".delete_advert").click(function(){
		var del_item_id = $(this).attr("id").substr(8);
		$("#delete-advert-id").val(del_item_id);
		$(".delete-holder-advert").hide();
		$(".delete-holder-advert").slideDown(300);
		//exit(0);
	})
	
	$(".ui-sortable2").sortable({
		update : function () {
			serial = $('.ui-sortable2').sortable('serialize');
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
	
	$(".ui-sortable3").sortable({
		update : function () {
			serial = $('.ui-sortable2').sortable('serialize');
			$.ajax({
				url: "admin/"+mod_type1+"/sortadvert",
				type: "post",
				data: serial,
				error: function(){
					alert("theres an error with AJAX");
				}
			});
		}
	});
});
</script>

<div class="gen-holder">
	<div class="gen-panel">
		<div class="panel-title">
			<div class="panel-title-name"><?=$title?> Manager</div>
		</div>
            
		<div class="panel-body">
			<div class="panel-body-holder">
				<div class="manager-items custom" style="min-height:0px;">
					<div class="border">
                    	<h1><?=$title?> </h1>			
            			<div class="btn-addentry"><a href="admin/<?=$link_type?>/add" style=""></a></div>

						<ul class="cat_sort ui-sortable2" style="">
						<?php
                        $sr_staff=0; 
                        if(!empty($programs)):

                        	foreach($programs as $program): 
                         	$sr_staff++;
                        ?>
							<li id="menu_<?=$program->id?>">
								<div class="manager-item">
									<div style="float:left;">
										<h2><?=$sr_staff?></h2>											
										<div class="manager-item-image" style="overflow: hidden;">
											<img src="<?=base_url()?>upload/featuredprograms/thumb/<?=$program->photo?>" style="display: inline-block; width: 100px; margin-top: -14px; ">
										</div>
										<h1><a href="admin/featuredprograms/edit/<?=$program->id; ?>"><?=$program->program_title;?></a></h1>
									</div>
										
									<div class="manager-item-opts">
											<a href="admin/<?=$link_type;?>/edit/<?=$program->id;?>" class="lb-preview">Edit</a>
											<a id="delitem_<?=$program->id?>" class="delete_item" title="Delete <?=$program->program_title;?>">Delete</a>
									</div>
								</div>
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
