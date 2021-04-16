<?php //echo '<pre>'; print_r($pagedetails); die; ?>
<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>
<?php if(!empty($pagedetails)) :?>		
<?php foreach($pagedetails as $blogitem):?>
<div class="gen-holder">
	<div class="gen-panel-holder" style="width: 100%;">
	<div class="gen-panel">
		<div class="panel-title">
			<div class="panel-title-name"><?=$blogitem->title;?></div>
		</div>
		<div class="panel-body">
		<div class="panel-body-holder">
		<div class="form-holder">
        
        
<script type="text/javascript">
	function validateForm() {
    var title = document.forms["myForm"]["title"].value;
    if (title == null || title == "") {
        alert("Page Title must be filled out");
        return false;
    }
	
	var sort_order = document.forms["myForm"]["sort_order"].value;
    if (!Number(sort_order)) {
        alert("Page Order must be filled out");
        return false;
    }
}
</script>
<form id="page_form" action="" method="post" onsubmit="return validateForm()" name="myForm">
	<div class="form-light-holder">
		<h1>Title</h1>		
		<input type="text" value="<?=ucwords($blogitem->title);?>" name="title" id="main_title" class="field"/>
		<!-- <div style="margin-bottom:10px;">
			Title will appear in the URL as: <em id="sef_title"><?=base_url()."view/".$blogitem->id;?></em>
		</div> --> 
	</div>
	
<div class="form-light-holder">
	<h1>Slug</h1>
	<input type="text" value="<?=$blogitem->slug;?>" name="slug" id="name" class="field" placeholder="Enter your slug here"/>
</div>

<div class="form-light-holder">
	<h1>Page Order</h1>
	<input type="text" value="<?=$blogitem->sort_order;?>" name="sort_order" id="sort_order" class="field" placeholder="Enter your Page Order here"/>
</div>
<div class="form-light-holder" style="">
<h1>Page Type</h1>
<select name="type" id="category" style="width: 100%; background:#FFF; border: none; border-radius: 5px; padding: 5px" >
<?php
	$pageTemplates = array('0' => 'Normal', '1' => 'Blog' , '2' => 'Testimonials', '3' => 'Contact us');
	foreach($pageTemplates as $key => $templates){
?>
<option value="<?php echo $key; ?>"><?php echo $templates; ?></option>
<?php } ?>
</select>
</div>

	<div class="form-light-holder" style="">
		<!--
		<textarea name="text" class="textarea" id="frm-text"><?=html_entity_decode($blogitem->content);?></textarea>
		-->
		<textarea name="content" class="ckeditor" id="frm-text"><?=$blogitem->content;?></textarea>
	</div>
        
	<div class="form-light-holder">
	<h1>Meta Title</h1>
	<input type="text" value="<?=$blogitem->meta_title;?>" name="meta_title" id="name" class="field" placeholder="Enter your Meta Title here"/>
</div>
	<div class="form-light-holder">
	<h1>Meta Description</h1>
	<input type="text" value="<?=$blogitem->meta_description;?>" name="meta_description" id="name" class="field" placeholder="Enter your Meta Description here"/>
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

<div class="form-light-holder">

	<?php $published = $blogitem->published; ?>
    <?php if($published == 1){ ?>
	<a id="free_trials" class="checkbox check-on"></a>
	<h1 class="inline">Show Start Trial button</h1>
	<input type="hidden" value="0" name="published" class="hidden_cb" />
    <?php } else { ?>
    <a id="free_trials" class="checkbox check-off"></a>
	<h1 class="inline">Show Start Trial button</h1>
	<input type="hidden" value="1" name="published" class="hidden_cb" />
    <?php } ?>
</div>
	<div class="form-white-holder" style="padding-bottom:20px;">
		<input type="submit" name="update" value="Update" class="btn-save" style="float:left;" />
	</div>
    

	
	<!--<div class="btn-save">-->
	<!--	<a style="" href="admin/staff/add"></a>-->
	<!--</div>-->
	
		</form>
	</div>
	</div>
	</div>
	
	<?php if($blogitem->slug == "our_facility"){?>		
	
	<style>
	
	.panel-body {
    	padding-bottom: 5px !important;
	}
	
	</style>
	

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
		$("#delete-item-id").val(del_item_id);
		$("#dropdown-holder").hide();
		$(".dropdown-edit").hide();
		$(".delete-holder-item").hide();
		$(".delete-holder-item").slideDown(300);
		//exit(0);
		})
		});
</script>

	
	<?php // $this->load->view("admin/include/conf_delete_photo"); ?>
	<!------- include modal for category ----------->
		<?php $this->load->view("admin/include/facility-upload-modal"); ?>
	<!--------- end modal for category -------------->

<?php $this->load->view("admin/include/facility_gallery_listing"); ?>
<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>
			</div>
		</div>
		</div>
		
	<?php } ?>		
	<?php endforeach;?>
<?php endif;?>

	</div>
</div>