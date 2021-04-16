<?php //echo '<pre>'; print_r($pagedetails); die; ?>
<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script src="js/ckeditor_full/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		 CKEDITOR.replace(  'mini_editor', 
									{ customConfig : 'config.js' }
							);
	
	 
	});
</script>
<?php if(!empty($pagedetails)) :?>		
<?php foreach($pagedetails as $blogitem):?>


<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Edit Menu</h2>
			</div>
			
		  </div>
	  </div>
	   <div class="row row-sm program-cat-page">

          <div class="col-sm-12 col-xl-12 az-content-body-contacts"  >
			<div class="card pd-sm-20 edit-form">
			
<div class="gen-holder">
	<div class="gen-panel-holder" style="width: 100%;">
	<div class="gen-panel">
		
		<div class="panel-body">
		<div class="panel-body-holder">
		<div class="form-holder">
        <div class="mb-3 main-content-label page_main_heading">Edit: Menu</div>
        
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
		<input type="text" value="<?=ucwords($blogitem->title);?>" name="title" id="main_title" class="field full_width_input"/>
		<!-- <div style="margin-bottom:10px;">
			Title will appear in the URL as: <em id="sef_title"><?=base_url()."view/".$blogitem->id;?></em>
		</div> --> 
	</div>
	


	<div class="form-light-holder" style="">
		<!--
		<textarea name="text" class="textarea" id="frm-text"><?=html_entity_decode($blogitem->content);?></textarea>
		-->
		<textarea name="content" class="ckeditor" id="mini_editor"><?=$blogitem->content;?></textarea>
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
	
	<?php //if($blogitem->slug == "our_facility"){?>		
	
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
		<?php //$this->load->view("admin/include/facility-upload-modal"); ?>
	<!--------- end modal for category -------------->

<?php //$this->load->view("admin/include/facility_gallery_listing"); ?>
<!------------ recent items ----------------->
<?php //$this->load->view("admin/include/footer");?>
			</div>
		</div>
		</div>
		
	<?php //} ?>		
	<?php endforeach;?>
<?php endif;?>

	</div>
</div>