<?php $this->load->view("admin/include/header"); ?>
<script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
<script src="js/ckeditor_full/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		 CKEDITOR.replace(  'ckeditor_mini', 
									{ customConfig : 'config.js' }
							);
	
		
	});
</script>

<script language="javascript">
$(document).ready(function(){
	
	$("#delete_img").click(function(){
		
		$('#img').hide();
		var id=$(this).attr('number');
		
		var mod_type = 'setting';
		//alert(staff_id);
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/about/delete_about_us_image',						
		data: { id : id}					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			//setTimeout("window.location.href='admin/testimonials/view'",1000);
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});

	});
	
})
</script>

<div class="gen-holder">
		<div class="gen-panel">
			<div class="panel-title">
				<div class="panel-title-name">Welcome Area</div>
				
			</div>
<div class="panel-body">
<div class="panel-body-holder">
<div class="manager-items custom">
<div class="border" style="width:100%; float:left; margin-bottom:15px;">


<div class="border floatNone" style="float:none !important">


<form action="" method="post"  enctype="multipart/form-data">

<div class="form-light-holder">
	<span class="field_title">Title</span>
	<input type="text" value="<?php if(!empty($pagedetails)){ echo $this->query_model->getStrReplaceAdmin($pagedetails[0]->title); } ?>" name="title"  class="field full_width_input" placeholder="Enter title here"  style=""/>
</div>


<div class="form-light-holder">
	<span class="field_title">Sub Title</span>
	<input type="text" value="<?php if(!empty($pagedetails)){ echo $this->query_model->getStrReplaceAdmin($pagedetails[0]->sub_title); } ?>" name="sub_title"  class="field full_width_input" placeholder="Enter sub title here"  style=""/>
</div>

<div class="form-light-holder">
	<span class="field_title">Content</span>
	<textarea type="text" name="description" id="ckeditor_mini" class="field ckeditor full_width_input" placeholder=""  style=""/><?php echo !empty($pagedetails) ? $pagedetails[0]->description : '';?></textarea>
</div>

<div class="form-light-holder" style="overflow:auto;">
	<span class="field_title"><b>Photo uploader </b></span><br />
	<?php if(!empty($pagedetails[0]->photo)): ?>
	<div><img id='img' src="<?php echo base_url().'upload/about_us/'.$pagedetails[0]->photo;?>" style="width: 100px; clear:both;" /></div>
	<input type="hidden" name="last-photo" value="<?=$pagedetails[0]->photo;?>" />
	<?php endif;?>
	<input type="file" name="userfile" id="photo"  accept="image/*"  />
	<?php if(!empty($pagedetails[0]->photo)){ 
			echo "<a href='javascript:void(0);' id='delete_img' number='".$pagedetails[0]->id."'>Delete image</a>";
			}
	?>	
	
		<div>
		<span class="field_title"><b>Image alt text</b></span><br />
	<input value="<?php echo !empty($pagedetails) ? $this->query_model->getStrReplaceAdmin($pagedetails[0]->photo_alt_text) : ''; ?>" name="photo_alt_text" id="" class="field" placeholder="image alt text" type="text">
		</div>
</div>
<div class="form-light-holder">
	<span class="field_title">Image Top Spacing</span><br />
	<input type="text" name="img_top_spacing" id="img_top_spacing" class="field  img_top_spacing" placeholder=""  style="width: 7%" value="<?php echo !empty($pagedetails) ? $pagedetails[0]->img_top_spacing : ''?>"/> <span style="font-size:15px"><strong>px</strong></span><br/>
	<em>Note: Please use only integer or float value. don't use "px" in input field</em>
	
</div>
<div class="form-light-holder">
<input type="hidden" value="<?= $location_id; ?>" name="location_id" class="location_id" />
		<input type="submit" name="update" value="Update" class="btn-save" />
</div>
</form>

</div>
</div>
<div class="border">

<!--<div class="btn-addentry add_entry_button"></div>-->

<h1>Full Width Rows <a href="admin/about/add_aboutus_row/<?php echo $location_id; ?>" class="button_class">Add Full Width Row</a></h1>

<div class="dragDropContent">
	You may rearrange the order of the items below by dragging them above or below other item rows. Changes will automatically be saved.
</div>
<ul class="cat_sort ui-sortable" style="">
<script language="javascript">
$(document).ready(function(){


var mod_type1 = $("#mod_type").val().toLowerCase();
try{
$(".ui-sortable").sortable({
update : function () {
serial = $('.ui-sortable').sortable('serialize');
$.ajax({
url: "admin/"+mod_type1+"/sortAboutusRows/<?php echo $location_id; ?>",
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
	var mod_type = $("#mod_type").val().toLowerCase();
	var publish_type = $(this).parents(".manager-item-opts").children(".publish_type").val();
	//alert (publish_type);
	$.ajax({ 					
	type: 'POST',						
	url: 'admin/'+mod_type+'/publishAboutusRows',						
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
	exit(0);
});
$(".delete_item").click(function(){
var del_item_id = $(this).attr("id").substr(8);
var location_id = $('.location_id').val();
$("#delete-item-id").val(del_item_id);
$("#location-id").val(location_id);
$(".delete-holder-item").hide();
$(".delete-holder-item").slideDown(300);
exit(0);
})
})
</script>
<?php
$sr_testimonials=0; 


				
if(!empty($aboutUsRows)):?>
<?php foreach($aboutUsRows as $about_us_row):
 $sr_testimonials++;
?>
									<li   id="menu_<?=$about_us_row->id?>">
										<div class="manager-item">
											<div style="float:left;">
												<!-- <h2><?=$about_us_row->id?></h2> --><h2><?=$sr_testimonials?></h2>
												<!--<div class="manager-item-image" style="overflow: hidden; ">
                                                <?php
													if($about_us_row->photo){
												?>
													<img src="<?=$about_us_row->photo?>" style="display: inline-block; width: 100px; margin-top: -14px; ">
                                                <?php
													}
                                                ?>
												</div>-->
                                                    
												<h1><a href="admin/<?=$link_type?>/edit_aboutus_row/<?=$about_us_row->id;?>" ><?=$about_us_row->title;?>    ( <?php echo ucfirst($about_us_row->photo_side);?> )</a></h1>
											</div>
											<div class="manager-item-opts"><a href="admin/about/edit_aboutus_row/<?=$about_us_row->id;?>" class="lb-preview">Edit</a><?php if($about_us_row->published == 1){?>
											<a id="unpub_<?=$about_us_row->id; ?>" class="unpublish" title="Unpublish <?=$about_us_row->title?>">Unpublish</a>
											<input type="hidden" name="publish_type" value="0" class="publish_type" />
											<?php }else{ ?>
											<input type="hidden" name="publish_type" value="1" class="publish_type" />
											<a id="unpub_<?=$about_us_row->id; ?>" class="unpublish" title="Publish <?=$about_us_row->title?>">Publish</a>
											<?php }?><a id="delitem_<?=$about_us_row->id?>" class="delete_item" title="Delete <?=$about_us_row->title;?>">Delete</a></div>
										</div>
									</li>
<?php endforeach;?>								
<input type="hidden" name="mod_type" value="<?=$link_type;?>" id="mod_type" />
<?php else: ?>
<div class="empty"><a href="admin/<?=$link_type?>/add_aboutus_row/<?php echo $location_id; ?>" class="nothing-yet">Add Full Width Row</a></div>
<?php endif;?>
								</ul>
<br />
</div>				
</div>

</div>

<?php $this->load->view("admin/include/conf_delete_about_rows"); ?>
</div>
</div>
<?php $this->load->view("admin/include/footer");?>