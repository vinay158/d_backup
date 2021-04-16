<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script src="js/ckeditor_mini/ckeditor.js"></script>

<div class="gen-holder">
	<div class="gen-panel-holder" style="width: 100%;">
	<div class="gen-panel">
		<div class="panel-title">
			<div class="panel-title-name"><?=$title;?></div>
		</div>
		<div class="panel-body">
		<div class="panel-body-holder">
		<div class="form-holder">

	<div class="form-light-holder" style="padding-bottom:30px;">
		
		<textarea name="text" class="ckeditor" id="frm-text"><?php if(!empty($pagedetails)){ echo $pagedetails[0]->content; }?></textarea>
	</div>

	</div>
	</div>
	</div>
	
	<?php 
		if(!empty($pagedetails)){
			if($pagedetails[0]->slug == "our_facility"){?>		
	
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
		exit(0);
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
		
	<?php } } ?>		

	</div>
</div>