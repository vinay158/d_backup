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

<form action="<?=base_url()?>/admin/meta/updatemetavariable" method="post">	
	<p style="padding:5px;text-align:center;">
	<?php
		$meta_school_name = isset($meta_data->meta_school_name) ? $meta_data->meta_school_name : '';
		$meta_city = isset($meta_data->meta_city) ? $meta_data->meta_city : '';
		$meta_state = isset($meta_data->meta_state) ? $meta_data->meta_state : '';
		$meta_city_state = isset($meta_data->meta_city_state) ? $meta_data->meta_city_state : '';
		$meta_nearbylocation1 = isset($meta_data->meta_nearbylocation1) ? $meta_data->meta_nearbylocation1 : '';
		$meta_nearbylocation2 = isset($meta_data->meta_nearbylocation2) ? $meta_data->meta_nearbylocation2 : '';
		$meta_county = isset($meta_data->meta_county) ? $meta_data->meta_county : '';
		$meta_main_martial_arts_style = isset($meta_data->meta_main_martial_arts_style) ? $meta_data->meta_main_martial_arts_style : '';
		$meta_martial_arts_style = isset($meta_data->meta_martial_arts_style) ? $meta_data->meta_martial_arts_style : '';
		$main_instructor = isset($meta_data->main_instructor) ? $meta_data->main_instructor : '';
		$est_year = isset($meta_data->est_year) ? $meta_data->est_year : '';
		$current_location = isset($meta_data->current_location) ? $meta_data->current_location : '';
	?>
	
	<div style="width:100%;text-align:center;">
	<strong>Enter values and use variables to replace values in meta information</strong>			
	</div>	
	<table cellpadding="0" cellspacing="0" >
		<tr>
			<td>School Name</td>
			<td><input type="text" name="meta_school_name" value="<?=$meta_school_name?>" />&nbsp;{school_name}</td>
		</tr>
		<tr>
			<td>City</td>
			<td><input type="text" name="meta_city" value="<?=$meta_city?>" />&nbsp;{city}</td>
		</tr>
		<tr>
			<td>State</td>
			<td><input type="text" name="meta_state" value="<?=$meta_state?>" />&nbsp;{state}</td>
		</tr> 
		<tr>
			<td>City, State</td>
			<td><input type="text" name="meta_city_state" value="<?=$meta_city_state?>" />&nbsp;{city state}</td>
		</tr>   
		<tr>
			<td>Near By Location 1</td>
			<td><input type="text" name="meta_nearbylocation1" value="<?=$meta_nearbylocation1?>" />&nbsp;{nearby_location1}</td>
		</tr>
		<tr>
			<td>Near By Location 2</td>
			<td><input type="text" name="meta_nearbylocation2" value="<?=$meta_nearbylocation2?>" />&nbsp;{nearby_location2}</td>
		</tr>
		<tr>
			<td>County</td>
			<td><input type="text" name="meta_county" value="<?=$meta_county?>" />&nbsp;{county}</td>
		</tr>
		<tr>
			<td>Main Martial Arts Style</td>
			<td><input type="text" name="meta_main_martial_arts_style" value="<?=$meta_main_martial_arts_style?>" />&nbsp;{main_martial_arts_style}</td>
		</tr>
		<tr>
			<td>Martial Arts Style</td>
			<td><input type="text" name="meta_martial_arts_style" value="<?=$meta_martial_arts_style?>" />&nbsp;{martial_arts_style}</td>
		</tr>
		<tr>
			<td>Trial Offer 1</td>
			<td><input type="text" name="trial_offer1" value="<?=$meta_martial_arts_style?>" />&nbsp;{trial_offer1}</td>
		</tr>
		<tr>
			<td>Trial Offer 2</td>
			<td><input type="text" name="trial_offer2" value="<?=$meta_martial_arts_style?>" />&nbsp;{trial_offer2}</td>
		</tr>
		
		<tr>
			<td>Main Instructor</td>
			<td><input type="text" name="main_instructor" value="<?=$main_instructor?>" />&nbsp;{main_instructor}</td>
		</tr>
		<tr>
			<td>Est Year</td>
			<td><input type="text" name="est_year" value="<?=$est_year?>" />&nbsp;{est_year}</td>
		</tr>
		<tr>
			<td>Current Location</td>
			<td><input type="text" name="current_location" value="<?=$current_location?>" />&nbsp;{current_location}</td>
		</tr>
		
		
		<tr>
			<td colspan="2"><input type="submit" name="update" value="Update" class="btn-save" /></td>
		</tr>
	</table>	
</form>
</p>
<div style="font-style:italic;font-size:11px;margin:12px 155px;">
	You may rearrange the order of the items below by dragging them above or below other item rows. Changes will automatically be saved.
</div>
<ul class="cat_sort ui-sortable" style="">
<script language="javascript">
$(document).ready(function(){
	var mod_type = $("#mod_type").val().toLowerCase();	
try{
		$(".ui-sortable").sortable({
		update : function () {
		serial = $('.ui-sortable').sortable('serialize');
		$.ajax({
		url: "admin/"+mod_type+"/sortthis",
		type: "post",
		data: serial,
		error: function(){
		alert("theres an error with AJAX");
		}
		});
		}
		});
} catch(e) {  }		
$(".unpublish").click(function(){
	var pub_id = $(this).attr("id").substr(6);
	
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
$sr_meta=0; 
if(!empty($meta)):?>
<?php foreach($meta as $meta):
$sr_meta++; 
?>
									<li  id="menu_<?=$meta->id?>">
										<div class="manager-item">
											<div style="float:left;">
												<!-- <h2><?=$meta->id?></h2> -->
												<h2><?=$sr_meta?></h2>
												<h1><a href="admin/<?=$link_type?>/edit/<?=$meta->id?>"><?=$meta->title;?></a></h1>
											</div>
											<div class="manager-item-opts">
											<a href="admin/<?=$link_type?>/edit/<?=$meta->id?>">Edit</a>
											<a id="delitem_<?=$meta->id?>" class="delete_item" title="Delete <?=$meta->title;?>">Delete</a></div>
										</div>
									</li>
<?php endforeach;?>								
<input type="hidden" name="mod_type" value="<?=$link_type;?>" id="mod_type" />
<?php else: ?>
<div class="empty"><a href="admin/<?=$link_type?>/add" class="nothing-yet">Add New Meta Tags / URL Rewriting entry</a></div>
<?php endif;?>
								</ul>
<br />
</div>				
</div>

</div>

<?php $this->load->view("admin/include/conf_delete_item"); ?>
</div>
</div>
