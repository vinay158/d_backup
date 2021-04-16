<?php $this->load->view("admin/include/header"); ?>
<script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
<script src="js/ckeditor_full/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		 CKEDITOR.replace(  'ckeditor_mini_sub_title', 
									{ customConfig : 'config.js' }
							);
							
		 CKEDITOR.replace(  'ckeditor_mini', 
									{ customConfig : 'config.js' }
							);
	
		CKEDITOR.replace(  'embed_video_text', 
									{ customConfig : 'config.js' }
							);
		
	});
</script>

<script>
	$(window).load(function(){
		
		$.each( $( ".image_video" ), function() {
		if($(this).attr('checked') == 'checked'){
			var radio_button_value = $(this).val();
	
			if(radio_button_value == "image"){
				$('.welcome_video').hide();
				
			}
			if(radio_button_value == "video"){
				$('.welcome_image').hide();
					
				$.each( $( ".video_img_type" ), function() {
					if($(this).attr('checked') == 'checked'){
						var video_imgradio_button_value = $(this).val();
							
						if(video_imgradio_button_value == "upload_image"){
							$('.welcome_video_image').show();
						}else{
							$('.welcome_video_image').hide();
						}
					}
				});
			}
		}
	});
	
	
		var videoType = $('select.videoType option:selected').val();
		
		if(videoType == "youtube_video"){
				$('.vimeo_video').hide();
				$('.youtube_video').show();
				$('.orButton').hide();
				$('.embed_video').hide();
			}
			if(videoType == "vimeo_video"){
				$('.youtube_video').hide();
				$('.vimeo_video').show();	
				$('.orButton').hide();
				$('.embed_video').hide();
			}
			
			
			if(videoType == "embed_video"){
				$('.youtube_video').hide();
				$('.vimeo_video').hide();
				$('.orButton').hide();
				$('.embed_video').show();
			}


		if($('.without_login_virtual_training_hidden_cb').val() == 1){
			$('.virtual_classes_button_url').hide();
		}else{
			$('.virtual_classes_button_url').show();
		}


	})
	
	
	$(document).ready(function(){
		
		$('.image_video').click(function(){
			var radio_button_value = $(this).val();
			
			if(radio_button_value == "image"){
				$('.welcome_video').hide();
				$('.welcome_image').show();
				$('.welcome_video_image').hide();
				
			}
			if(radio_button_value == "video"){
				$('.welcome_image').hide();
				$('.welcome_video').show();
					
			$.each( $( ".video_img_type" ), function() {
				if($(this).attr('checked') == 'checked'){
					var video_imgradio_button_value = $(this).val();
						
					if(video_imgradio_button_value == "upload_image"){
						$('.welcome_video_image').show();
					}else{
						$('.welcome_video_image').hide();
					}
				}
			});
				
			}
		});
		
		$('.videoType').change(function(){
		var videoType = $(this).val();
		
		if(videoType == "youtube_video"){
				$('.vimeo_video').hide();
				$('.youtube_video').show();
				$('.orButton').hide();
				$('.embed_video').hide();
			}
			if(videoType == "vimeo_video"){
				$('.youtube_video').hide();
				$('.vimeo_video').show();	
				$('.orButton').hide();
				$('.embed_video').hide();
			}
			
			
			if(videoType == "embed_video"){
				$('.youtube_video').hide();
				$('.vimeo_video').hide();
				$('.orButton').hide();
				$('.embed_video').show();
			}
});

$(".virtual_training .virtual_training_checkbox").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form-light-holder").children(".virtual_training_hidden_cb").val("0");
		
		

	}

	else{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form-light-holder").children(".virtual_training_hidden_cb").val("1");
		
		

	}

	});
	
$(".without_login_virtual_training .without_login_virtual_training_checkbox").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form-light-holder").children(".without_login_virtual_training_hidden_cb").val("0");
		$('.virtual_classes_button_url').show();
	}

	else{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form-light-holder").children(".without_login_virtual_training_hidden_cb").val("1");
		
		$('.virtual_classes_button_url').hide();

	}

	});
	
	
	$("#delete_video_img").click(function(){

		$('#img_left').hide();
		var record_id=1;
		var image_name = $(this).attr('image_name');
		
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/virtual_training/delete_img',						
		data: { record_id : record_id,image_name:image_name}					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			$('.last-photo').val('');
			//setTimeout("window.location.href='admin/"+mod_type+"/edit/"+staff_id+"'",1000);
		}
		});

	});
	
		
	})
</script>

<div class="gen-holder">
		<div class="gen-panel">
			<div class="panel-title">
				<div class="panel-title-name">Virtual Training</div>
				
			</div>
<div class="panel-body">
<div class="panel-body-holder">
<div class="manager-items custom">
<div class="border" style="width:100%; float:left; margin-bottom:15px;">


<div class="border floatNone" style="float:none !important">


<form action="" method="post"  enctype="multipart/form-data">


<div class="form-light-holder without_login_virtual_training">

        <a id="" class="without_login_virtual_training_checkbox <?php if(!empty($detail) && $detail[0]->without_login_virtual_training ==1){ echo "check-on"; }else { echo "check-off";} ?>"></a>

	<span class="field_title">Show on Main Site (won’t be password protected)</span>

	<input type="hidden" value="<?php if(!empty($detail) && $detail[0]->without_login_virtual_training ==1){ echo 1; }else { echo 0;} ?>" name="without_login_virtual_training" class="without_login_virtual_training_hidden_cb" />

</div>
<div class="form-light-holder virtual_classes_button_url">
	<span class="field_title">Virtual Classes Button URL</span>
	<input type="text" value="<?php if(!empty($detail)){ echo $this->query_model->getStrReplaceAdmin($detail[0]->virtual_classes_button_url); } ?>" name="virtual_classes_button_url"  class="field full_width_input" placeholder=""  style=""/>
	
</div>
<div class="form-light-holder ">
<input type="checkbox" name="hide_virtual_classes_button" value="1" <?php if(!empty($detail) && $detail[0]->hide_virtual_classes_button ==1){ echo "checked=checked"; }else { echo "";} ?>>Hide Virtual Classes Button
</div>

<div class="form-light-holder">
	<span class="field_title">Heading</span>
	<input type="text" value="<?php if(!empty($detail)){ echo $this->query_model->getStrReplaceAdmin($detail[0]->title); }else{ echo 'Virtual Training'; } ?>" name="title"  class="field full_width_input" placeholder=""  style=""/>
</div>
<div class="form-light-holder" style="display:none">
	<span class="field_title">Heading description</span>
	<textarea type="text" name="sub_title" id="ckeditor_mini_sub_title" class="field ckeditor full_width_input" placeholder=""  style=""/><?php echo !empty($detail) ? $detail[0]->sub_title : '';?></textarea>
</div>


<div class="form-light-holder virtual_training">

        <a id="" class="virtual_training_checkbox <?php if(!empty($detail) && $detail[0]->show_zoom_logo ==1){ echo "check-on"; }else { echo "check-off";} ?>"></a>

	<span class="field_title"> Show Zoom Logo?</span>

	<input type="hidden" value="<?php if(!empty($detail) && $detail[0]->show_zoom_logo ==1){ echo 1; }else { echo 0;} ?>" name="show_zoom_logo" class="virtual_training_hidden_cb" />

</div>


<div class="form-light-holder">

	<span class="field_title">Image Or Video</span><br/>

	<input type="radio" class="image_video" name="image_video" value="image" <?php if(!empty($detail) && $detail[0]->image_video == 'image'){ echo 'checked=checked'; } ?>  /> Image <br />
	<input type="radio" class="image_video" name="image_video" value="video"  <?php if(!empty($detail) && $detail[0]->image_video == 'video'){ echo 'checked=checked'; } ?>  /> Video

</div>
<div class="welcome_image">
<div class="form-light-holder" style="overflow:auto;">
	<span class="field_title">IMAGE UPLOADER</span><br/>
	<?php if(!empty($detail) && !empty($detail[0]->photo)): ?>
	<div><img id='img_left' src="<?=base_url().'upload/slider_video/'.$detail[0]->photo;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" class="last-photo" name="last-photo" value="<?=$detail[0]->photo;?>" />
	<?php endif;?>
	<input type="file" name="userfile" id="photo" accept="image/*" />
	<?php if(!empty($detail) && !empty($detail[0]->photo)){ 
			echo "<a href='javascript:void(0);'  id='delete_video_img' image_name='".$detail[0]->photo."'>Delete image</a>";
			}
	?>
</div>



</div>


<div class="form-light-holder welcome_video">

	<div class="adsUrl">
		<span class="field_title">Video Type</span>
		<select name="video_type" id="" class="field videoType" >
		<option value="youtube_video" <?php if(!empty($detail) && $detail[0]->video_type == 'youtube_video'){ echo 'selected=selected'; } ?>>Youtube Video</option>
		<option value="vimeo_video" <?php if(!empty($detail) && $detail[0]->video_type == 'vimeo_video'){ echo 'selected=selected'; } ?>  >Vimeo Video</option>
		<option value="embed_video" <?php if(!empty($detail) && $detail[0]->video_type == 'embed_video'){ echo 'selected=selected'; } ?>  >Embed Video</option>
	</select>
	
	</div>
	<div class="linkTarget">
	<div class="youtube_video">
	<span class="field_title">Youtube Video</span>
	<input type="text" name="youtube_video" value="<?php if(!empty($detail)){ echo $detail[0]->youtube_video; }?>" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://www.youtube.com/embed/UWCbfxwwC-I
	</div>
	</div>
	<span class="orButton">OR</span>
	<div class="vimeo_video">
	<span class="field_title">Vimeo Video</span>
	<input type="text" name="vimeo_video" value="<?php if(!empty($detail)){ echo $detail[0]->vimeo_video; } ?>" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://player.vimeo.com/video/167143332
	</div>
	</div>

	

	</div>
	
</div>

<div class="form-light-holder embed_video">
	<span class="field_title">Embed Video Html</span>
	<textarea name="embed_video_text"  id="embed_video_text"  class="ckeditor"><?php if(!empty($detail)){ echo $this->query_model->getStrReplaceAdmin($detail[0]->embed_video_text); } ?></textarea>
</div>	

<div class="form-light-holder">
	<span class="field_title">Description Title</span>
	<input type="text" value="<?php if(!empty($detail)){ echo $this->query_model->getStrReplaceAdmin($detail[0]->desc_title); }else{ echo 'Taking Virtual Classes with {school_name} is super easy!'; } ?>" name="desc_title"  class="field full_width_input" placeholder=""  style=""/>
</div>
<div class="form-light-holder">
	<span class="field_title">Description</span>
	<textarea type="text" name="desc_short" id="ckeditor_mini" class="field ckeditor full_width_input" placeholder=""  style=""/><?php echo !empty($detail) ? $detail[0]->desc_short : " I'll have Melanie write you some text for this";?></textarea>
</div>




<div class="form-light-holder">
		<input type="submit" name="update" value="Update" class="btn-save" />
</div>
</form>

</div>
</div>
<div class="border">

<!--<div class="btn-addentry add_entry_button"></div>-->

<h1>Virtual Training Class Types <a href="admin/virtual_training/add_row" class="button_class">Add Virtual Training Class Type</a></h1>

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
url: "admin/"+mod_type1+"/sortRows",
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
	url: 'admin/'+mod_type+'/publishRows',						
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
var location_id = $('.location_id').val();
$("#delete-item-id").val(del_item_id);
$("#location-id").val(location_id);
$(".delete-holder-item").hide();
$(".delete-holder-item").slideDown(300);
//exit(0);
})
})
</script>
<?php
$sr_testimonials=0; 


				
if(!empty($rows)):?>
<?php foreach($rows as $row):
 $sr_testimonials++;
?>
									<li   id="menu_<?=$row->id?>">
										<div class="manager-item">
											<div style="float:left;">
												<h2><?=$sr_testimonials?></h2>
												
                                                    
												<h1><a href="admin/<?=$link_type?>/edit_row/<?=$row->id;?>" ><?=$row->class_name;?></a></h1>
											</div>
											<div class="manager-item-opts"><a href="admin/<?=$link_type?>/edit_row/<?=$row->id;?>" class="lb-preview">Edit</a><?php if($row->published == 1){?>
											<a id="unpub_<?=$row->id; ?>" class="unpublish" title="Unpublish <?=$row->class_name?>">Unpublish</a>
											<input type="hidden" name="publish_type" value="0" class="publish_type" />
											<?php }else{ ?>
											<input type="hidden" name="publish_type" value="1" class="publish_type" />
											<a id="unpub_<?=$row->id; ?>" class="unpublish" title="Publish <?=$row->class_name?>">Publish</a>
											<?php }?><a id="delitem_<?=$row->id?>" class="delete_item" title="Delete <?=$row->class_name;?>">Delete</a></div>
										</div>
									</li>
<?php endforeach;?>								
<input type="hidden" name="mod_type" value="<?=$link_type;?>" id="mod_type" />
<?php else: ?>
<?php endif;?>
								</ul>
<br />
</div>				
</div>

</div>

<?php $this->load->view("admin/include/conf_delete_item"); ?>
</div>
</div>
<?php $this->load->view("admin/include/footer");?>