<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>
<script language="javascript" type="text/javascript">

jQuery(document).ready(function(){
    $('#headline').keyup(function(e){
            var max = 45;
            var len = $(this).val().length;
            if (len >= max) {
            	e.preventDefault();
                $('#charNum').text(' you have reached the limit');                
                $("#headline").attr('maxlength','45');                            	          
            }else {
                var char = max - len;
                $('#charNum').text( char + ' characters left');
            }
	});
});


</script>

<div class="gen-holder">
	<div class="gen-panel-holder"  style="width: 100% !important;">
	<div class="gen-panel">
		<div class="panel-title">
			<div class="panel-title-name">Add Entry</div>
		</div>
		<div class="panel-body">
		<div class="panel-body-holder">
		<div class="form-holder">

<form id="blog_form" action="" method="post" enctype="multipart/form-data">
<script language="javascript">
$(document).ready(function(){
	$("#main_title").keyup(function(){
		$("#sef_title").html($(this).val());
	})
})
</script>
<?php if(!empty($pagedetails)): ?>
<?php foreach($pagedetails as $row) : ?>
<div class="form-light-holder">
	<h1>Title</h1>
	<input type="text" value="<?=$row->title?>" name="title" id="title" class="field" placeholder="Enter tab title here"/>
	<span id='charNum'></span>
</div>
<div class="form-light-holder">
	<h1>Headline</h1>
	<input type="text" value="<?=$row->headline?>" name="headline" id="headline" class="field" placeholder="Enter headline here"/>
	
</div>

<div class="form-light-holder" style="overflow:auto;">

	<h1 style="padding-bottom: 5px;">Choose a Photo</h1>
	<?php if(!empty($row->photo)): ?>
	<div><img src="<?=$row->photo;?>" style="width: 100px; clear:both;" /></div>
	<input type="hidden" name="last-photo" value="<?=$row->photo;?>" />
	<?php endif;?>
	<input type="file" name="userfile" id="photo" accept="image/*" />
		<div>
		</div>
</div>

<div class="form-light-holder" style="padding-bottom:30px;">
	<h1  style="padding-bottom: 5px;">Text Blurb</h1>
	<!--<textarea name="text" class="textarea" id="frm-text"><?=html_entity_decode($row->content);?></textarea>
	--><textarea name="text" class="ckeditor" id="frm-text"><?=$row->content;?></textarea>
</div>

<div class="form-light-holder">
	<h1>Bullet Headline</h1>
	<input type="text" value="<?=$row->bulhead?>" name="bulhead" id="bulhead" class="field" placeholder="Enter bullet headline here"/>
</div>

<div class="form-light-holder" style="padding-bottom:30px;">
	<h1  style="padding-bottom: 5px;">Bullet Contents</h1>
	<!--<textarea name="bulcont" class="textarea" id="frm-text2"><?=html_entity_decode($row->bulcont);?></textarea>
	-->
	<textarea name="bulcont" class="ckeditor" id="frm-text2"><?=$row->bulcont;?></textarea>
	
</div>


<div class="form-white-holder" style="padding-bottom:20px;">
	<input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />
</div>
<?php endforeach; ?>
<?php endif; ?>
</form>



		</div>
		</div>
		</div>
		<!-- facility pics start -->
		
<!--<script language="javascript" type="text/javascript">

tinyMCE.init({
        mode : "exact",
        elements : "frm-text",
		theme : "advanced",

		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,bullist,numlist,cut,copy,paste,link,unlink",
		theme_advanced_buttons2 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_resizing : false,
		width: "100%",
		height: "300",

		// Example content CSS (should be your site CSS)

		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",
		// Style formats
		style_formats : [

			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],
		// Replace values for the template plugin

		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
});
</script>
<style>

.manager-items .manager-item {
	min-height: 49px !important;
}

--></style>

<div class="gen-holder"> 
	<div class="gen-panel-holder" style="width: 100% !important;"> 
	<div class="gen-panel"> 
	 <script language="javascript" type="text/javascript">
					function goBack()
					  {
					  window.history.back()
					  }
					$(document).ready(function(){
					$("#details_t").hide();
					$("#Media").click(function(){
					$("#details_t").hide();
					$("#gallery").show();
					$(this).addClass("active");
					$("#Edit").removeClass("active");
					});
					$("#Edit").click(function(){
					$("#gallery").hide();
					$("#details_t").show();
					$(this).addClass("active");
					$("#Media").removeClass("active");
					});
					$(".edit_item").click(function(){
						//alert($("#album_cover").val());
							$("#dropdown-holder").hide();
							$(".dropdown-edit").hide();
							$(".delete-holder-item").hide();	
							$(".dropdown-edit").slideDown(200);
							var media_id = $(this).attr("id").substr(5);
							var loc = $("#media_link_"+media_id).val();
							var desc = $("#media_link_"+media_id).attr("class");
							$(".drop-add-title em").text("ID # "+media_id);
							var l_cover = $("#album_cover").val();
							if( l_cover == loc ){
							$("#album-cover").addClass("check-on");
							$("#album-cover").removeClass("check-off");
							$("#album-cover-val").val(1);
							}
							$("#operation").val("edit");
							$("#edit_id").val(media_id);
							$("#media_desc").val(desc);
							$("#cover_link").val(loc);
					});
					});
					</script>
		<div class="panel-body" id="gallery">
		<div class="panel-body-holder">
		<div class="manager-items custom">
		<div class="border">
		<h1>Facility Pics</h1>
		<div><a id="Upload" class="panel-title-links">Upload</a></div>
		<ul class="cat_sort ui-sortable" style="">
		<?php
		$sr=0; 
		if(!empty($media)):
		//echo "<pre>";print_r($pagedetails);exit;
		?>
		<?php foreach($media as $media):
		$sr++; 
		?>
		<li>
		<div class="manager-item">
		<div style="">
		<!-- <h2><?//=$media->id?></h2> -->
		<h2><?= $sr;?></h2>
		<?php if($media->type == 2): ?>
		<div class="manager-item-image" style="overflow: hidden; ">
		<img src="<?=$media->link?>" style="display: inline-block; width: 100px; margin-top: -14px; "></div>
		<h1><a id="edit_<?=$media->id?>" class="edit_item"><?=character_limiter($media->link, 40);?></a></h1>
		<?php //else: ?>
		<!-- <h1><a><?=character_limiter($media->link, 80);?></a></h1> -->
		<?php endif;?>
		</div>
		<div class="manager-item-opts">
		<a id="edit_<?=$media->id?>" class="edit_item" title="Edit Media <?=$media->desc;?>">Edit</a>
		<?php if($media->type == 2) : ?>
		 <input type="hidden" name="media_link_<?=$media->id?>" class="<?=$media->desc?>" id="media_link_<?=$media->id?>" value="<?=$media->link?>" />  
		<?php //else: ?>
		<!-- <input type="hidden" name="media_link_<?=$media->id?>" class="<?=$media->desc?>" id="media_link_<?=$media->id?>" value="http://img.youtube.com/vi/<?=$media->desc;?>/0.jpg" /> -->
		<?php endif; ?>
		<a id="delitem_<?=$media->id?>" class="delete_item" title="Delete <?=$media->desc;?>">Delete</a>
		</div>
		</div>
		<?php endforeach;?>
		<?php else:	?>
		<h1>No Media Uploaded Yet.</h1>
		<?php endif;?>
		
		</div>
		</div></div></div>
		
		<div class="panel-body" id="details_t">
		<div class="panel-body-holder">
		<div class="form-holder">

<form id="blog_form" action="" method="post">
<?php if(!empty($pagedetails)): ?>
<?php foreach($pagedetails as $pagedetail):?>
<div class="form-light-holder">
	<h1>Album Title</h1>
	<!-- <input type="text" value="<?//=$details->album?>" name="title" id="main_title" class="field"/>
	<input type="hidden" value="<?//=$details->id?>" name="id_of_album" id="album_id" /> -->
	<input type="hidden" value="<?=$pagedetail->photo?>" name="cover_of_album" id="album_cover" />
	<script language="javascript" type="text/javascript">
	$(document).ready(function(){
	var title_t = $("#main_title").val();
	var album_id = $("#album_id").val();
	$("#h1-title").html(title_t);
	$(".panel-title-name").html("Edit Album <span>" + title_t + " <em>ID #: " + album_id + "</em></span>");
	
	});
	</script>
</div> 

<!-- <div class="form-light-holder">
	<h1>Category</h1>
	<select name="category" id="category" style="width: 100%; background:#FFF; border: none; border-radius: 5px; padding: 5px;">
	<?php foreach($cat as $cat): ?>
	<option <?php if($details->category == $cat->cat_id) echo "selected='selected'" ;?> value="<?=$cat->cat_id?>"><?=$cat->cat_name?></option>
	<?php endforeach;?>
	</select>
</div> -->

<div class="form-light-holder" style="padding-bottom:30px;">
	<h1>Description</h1>
	<!--<textarea name="text" class="textarea" id="frm-text"><?=html_entity_decode($details->desc);?></textarea>
	-->
	<textarea name="text" class="ckeditor" id="frm-text"><?=$details->desc;?></textarea>
</div>
<script language="javascript">
$(document).ready(function(){
$(".form-light-holder .checkbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents(".form-light-holder").children(".hidden_cb").val("0");
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents(".form-light-holder").children(".hidden_cb").val("1");
	}
})
})
</script>  
<!-- <div class="form-light-holder">
	<a id="published" class="checkbox <?php if($details->published == 1) echo "check-on"; else echo "check-off";?>"></a>
	<h1 class="inline">Publish This</h1>
	<input type="hidden" value="<?=$details->published;?>" name="published" class="hidden_cb" />
</div> -->

<div class="form-white-holder" style="padding-bottom:20px;">
	<input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />
</div>
<?php endforeach;?>
<?php endif;?>
</form>



		</div>
		</div>
		</div>
	</div>
	</div>
<script language="javascript">
	$(document).ready(function(){
		$("#Upload").click(function(){
		$("#dropdown-holder").hide();
		$(".dropdown-edit").hide();
		$(".delete-holder-item").hide();	
		$("#dropdown-holder").slideDown(200);
		});
		$(".close-btn").click(function(){
		$("#dropdown-holder").slideUp(200);
		$(".delete-holder-item").slideUp(200);	
		$(".dropdown-edit").slideUp(200);
		});
		$(".delete_item").click(function(){
		var del_item_id = $(this).attr("id").substr(8);
		//alert(del_item_id);
		$("#delete-item-id").val(del_item_id);
		$("#dropdown-holder").hide();
		$(".dropdown-edit").hide();
		$(".delete-holder-item").hide();
		$(".delete-holder-item").slideDown(300);
		//exit(0);
		return false;
		})
		});
</script>


	</div></div>
			
		
		<!-- facility pics end -->
	</div>
	</div>

<br style="clear:both"		 /><br />
<!------------ recent items ----------------->
<?php $this->load->view("admin/include/facility_upload-modal"); ?>
<?php $this->load->view("admin/include/conf_delete_media"); ?>
<?php $this->load->view("admin/include/footer");?>
