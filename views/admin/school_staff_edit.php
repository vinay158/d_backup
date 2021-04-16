<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
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
	if($('.hidden_cb2').val()== 0){
		$('.show_lightbox_and_url').hide();
	}else{
		$('.show_lightbox_and_url').show();
	}
	
	
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
$(".form1checkbox .checkbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents(".form1checkbox").children(".hidden_cb").val("0");
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents(".form1checkbox").children(".hidden_cb").val("1");
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

<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Edit Instructor</h2>
			</div>
			
		  </div>
	  </div>
	   <div class="row row-sm program-cat-page">

          <div class="col-sm-12 col-xl-12 az-content-body-contacts"  >
			<div class="card pd-sm-20 edit-form">
			
<div class="gen-holder">
	<div class="gen-panel-holder"  style="width: 100% !important;">
	<div class="gen-panel">
		
		<div class="panel-body">
		<div class="panel-body-holder">
		<div class="form-holder">
<div class="mb-3 main-content-label page_main_heading">Edit: Instructor</div>
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
	
	
	
	$("#delete_lightbox_photo").click(function(){
		$('#lightbox_photo_img').hide();
		var staff_id=$('#staff_id').val();
		var lightbox_photo=$('#lightbox_photo_img').attr('src');
					
		//var mod_type = $("#contact_mod").val().toLowerCase();
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/school/delete_staff_lightbox_photo',						
		data: { staff_id : staff_id,lightbox_photo:lightbox_photo }					
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
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($d_row->name); ?>" name="name" id="name" class="field full_width_input" placeholder="Enter your name here"/>
	<input type="hidden" value="<?=$d_row->id;?>" name="staff_id" id="staff_id" >
	
</div>

<?php /*?> <?php if($IsAllowMultiStaff){ ?>
<div class="form-light-holder">
    <h1>Location</h1>		
    <?php echo form_dropdown('location_id', $locations, $d_row->location_id); ?>
</div>

<?php } ?><?php */?>

<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Thumbnail Image</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="userfile" class="custom-file-input" id="customFile1" accept="image/*">
		<label class="custom-file-label" for="customFile">Choose file</label></div>
		
	<?php if(!empty($d_row->photo)): ?>
	<div><img id='img' src="<?=base_url().'upload/school_staff/'.$d_row->photo;?>" style="width: 100px; clear:both;" /></div>
	<input type="hidden" name="last-photo" value="<?=$d_row->photo;?>" />
	<?php endif;?>
	<?php if(!empty($d_row->photo)){ 
			echo "<a href='javascript:void(0);' id='delete_img' class='delete_image_btn_new' >Delete image</a>";
			}
	?>	
	
	</div>
	
	<div class="linkTarget form-group">
		<h1 style="padding-top: 5px;">Image alt text</h1>
	<input value="<?php echo $d_row->photo_alt_text; ?>" name="photo_alt_text" id="" class="field" placeholder="image alt text" type="text">
		</div>
</div>

<!-- <div class="form-light-holder">
	<h1>Image Alt</h1>
	<input type="text" name="image_alt" value="<?=$d_row->image_alt ?>" class="field">
</div> -->



<!-- DOJO 01/12--->
<div class="form-light-holder   d-md-flex  dual_input">
	<div class="adsUrl form-group">
	<h1>Position</h1>
	<input type="text" name="position" value="<?php echo $this->query_model->getStrReplaceAdmin($d_row->position); ?>" class="field">
		</div>
	
	<div class="linkTarget form-group">
		<h1>Belt Rank</h1>
		<input type="text" name="belt" value="<?php echo $this->query_model->getStrReplaceAdmin($d_row->belt );?>" class="field">

	</div>
</div>


<!--<div class="form-light-holder">
	<h1>Year Experience</h1>
	<input type="text" name="experience" value="<?=$d_row->experience?>" class="field">
</div>-->
<!--- end code --->



<script language="javascript">

$(document).ready(function(){

$(".form2checkbox .checkbox2").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form2checkbox").children(".hidden_cb2").val("0");

		$('.show_lightbox_and_url').hide();
	}

	else

	{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form2checkbox").children(".hidden_cb2").val("1");
		$('.show_lightbox_and_url').show();
	}

})

})

</script>
<div class="form-light-holder form2checkbox">

	<a id="published" class="checkbox2 <?php echo (!empty($d_row) && $d_row->not_linked == 1) ? 'check-on' : 'check-off'; ?>"></a>
<h1 class="inline">Show a lightbox or link to URL</h1>
	<input type="hidden" value="<?php echo (!empty($d_row) && $d_row->not_linked == 1) ? 1 : 0; ?>" name="not_linked" class="hidden_cb2" />

</div>
<div class="show_lightbox_and_url">
<div class="form-light-holder ">
	<div class="row row-xs align-items-center">
	
	<div class="col-md-12  mg-t-5 mg-md-t-0">
	<div class="row mg-t-10">
		<div class="col-lg-3">
		  <label class="rdiobox">
			<input type="radio" class="lightbox_or_url" name="lightbox_or_url" value="lightbox" <?php if(!empty($d_row) && $d_row->lightbox_or_url == 'lightbox'){ echo 'checked=checked'; }elseif(empty($d_row->lightbox_or_url)){  echo 'checked=checked'; } ?>  /><span> Show bio in lightbox</span>
		  </label>
		</div><!-- col-3 -->
		<div class="col-lg-3">
		  <label class="rdiobox">
			<input type="radio" class="lightbox_or_url" name="lightbox_or_url" value="url" <?php if(!empty($d_row) && $d_row->lightbox_or_url == 'url'){ echo 'checked=checked'; } elseif(empty($d_row->lightbox_or_url)){  echo 'checked=checked'; }?> /><span>Link to URL</span>
		  </label>
		</div><!-- col-3 -->
		
		</div>
	</div>
</div>

</div>
<div class="info_lightbox">
	
<div class="form-light-holder   d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Lightbox Image</h1>
	<div class="custom-file half_width_custom_file">
	<input type="file" name="lightbox_photo" class="custom-file-input" id="customFile2" accept="image/*">
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	<?php if(!empty($d_row->lightbox_photo)): ?>
	<div><img id='lightbox_photo_img' src="<?=base_url().'upload/school_staff/'.$d_row->lightbox_photo;?>" style="width: 100px; clear:both;" /></div>
	<input type="hidden" name="last-lightbox_photo" value="<?=$d_row->lightbox_photo;?>" />
	<?php endif;?>
	<?php if(!empty($d_row->lightbox_photo)){ 
			echo "<a href='javascript:void(0);' id='delete_lightbox_photo' class='delete_image_btn_new' >Delete image</a>";
			}
	?>	
	
	</div>
	
	<div class="linkTarget form-group">
			<h1 style="padding-top: 5px;">Image alt text</h1>
	<input value="<?=$d_row->lightbox_photo_alt_text;?>" name="lightbox_photo_alt_text" id="" class="field" placeholder="image alt text" type="text">
		</div>
</div>

<div class="form-light-holder" style="">
	<!--<textarea name="text" class="textarea" id="frm-text"><?=$d_row->content?></textarea>
	-->
	<h1>Instructor Bio</h1>
	<textarea name="text" class="ckeditor" id="frm-text"><?=$d_row->content?></textarea>
</div>

</div>
<div class="form-light-holder info_url">
	<div class="adsUrl">
			<h1>URL</h1>
            <input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($d_row->url)?>" name="url" id="url" class="field"/>
			
	</div>
	
	
	<div class="linkTarget">
			<h1>Link Target</h1>
			<select name="target" id="target" class="field" >
			<option value="_blank" <?php if($d_row->target == '_blank'){ echo 'selected=selected'; }?> >Blank</option>
			<option value="_self" <?php if($d_row->target == '_self'){ echo 'selected=selected'; }?>>Self</option>
			</select>
	</div>
			
	
</div>
</div>
<div class="form-light-holder form1checkbox">
	<a id="published" class="checkbox <?php if($d_row->published==1) echo "check-on"; else echo "check-off";?>"></a>
	<h1 class="inline">Publish This</h1>
	<input type="hidden" value="<?=$d_row->published?>" name="published" class="hidden_cb" />
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

</div>
</div>
</div>
</div>
<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>
