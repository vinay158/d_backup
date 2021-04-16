<?php $this->load->view("admin/include/header"); ?>
<!-- end head contents -->
<!-- wysiwyg editor script -->
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
<link rel="stylesheet" href="/resources/demos/style.css" />
<!--<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>-->
<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>
--><script src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>

<script src="js/ckeditor_full/ckeditor.js"></script>


<script language="javascript">
$(window).load(function(){
	$.each( $( ".lightbox_or_url" ), function() {
		if($(this).attr('checked') == 'checked'){
			var radio_button_value = $(this).val();
	
			if(radio_button_value == "lightbox"){
				$('.info_url').hide();
			}
			if(radio_button_value == "url"){
				$('.info_lightbox').hide();
			}
		}
	});
	
	
});
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

$('.lightbox_or_url').click(function(){
	var radio_button_value = $(this).val();
	
	if(radio_button_value == "lightbox"){
		$('.info_url').hide();
		$('.info_lightbox').show();
	}
	if(radio_button_value == "url"){
		$('.info_lightbox').hide();
		$('.info_url').show();
	}
});

})
</script>
<div class="gen-holder">
	<div class="gen-panel-holder"  style="width: 100% !important;">
	<div class="gen-panel">
		<div class="panel-title">
			<div class="panel-title-name">Edit Instructor</div>
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

	$("#delete_img").click(function(){
		$('#img').hide();
		var staff_id=$('#staff_id').val();
		var image_path=$('#img').attr('src');
					
		//var mod_type = $("#contact_mod").val().toLowerCase();
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/school/staff_img_delete',						
		data: { staff_id : staff_id,image_path:image_path }					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			//setTimeout("window.location.href='admin/"+mod_type+"/edit/"+staff_id+"'",1000);
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});

	});
	
})
</script>
<?php if(isset($details)):?>
<?php foreach($details as $d_row): ?>
<div class="form-light-holder">
	<h1>Name</h1>
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($d_row->name); ?>" name="name" id="name" class="field" placeholder="Enter your name here"/>
	<input type="hidden" value="<?=$d_row->id;?>" name="staff_id" id="staff_id" >
	
</div>

<?php /*?> <?php if($IsAllowMultiStaff){ ?>
<div class="form-light-holder">
    <h1>Location</h1>		
    <?php echo form_dropdown('location_id', $locations, $d_row->location_id); ?>
</div>

<?php } ?><?php */?>



<!-- DOJO 01/12-->
<div class="form-light-holder">
	<h1>Designation</h1>
	<input type="text" name="designation" value="<?php echo $this->query_model->getStrReplaceAdmin($d_row->designation); ?>" class="field">
</div>

<!--<div class="form-light-holder">
	<h1>Year Experience</h1>
	<input type="text" name="experience" value="<?=$d_row->experience?>" class="field">
</div>-->
<!--- end code -->





<div class="form-light-holder">
	<a id="published" class="checkbox <?php if($d_row->published==1) echo "check-on"; else echo "check-off";?>"></a>
	<h1 class="inline">Publish This</h1>
	<input type="hidden" value="<?=$d_row->published?>" name="publish" class="hidden_cb" />
</div>

<div class="form-white-holder" style="padding-bottom:20px;">
<input type="hidden" value="<?=$d_row->location_id;?>" name="location_id" class="location_id" />
	<input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />
</div>
<?php endforeach; ?>
<?php endif; ?>
</form>

		</div>
		</div>
		</div>
	</div>
	</div>
<br style="clear:both"		 /><br />
<!-- recent items -->
<?php $this->load->view("admin/include/footer");?>
