<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<!--<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>-->
<script src="js/ckeditor_full/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		 CKEDITOR.replace(  'sub_title', 
									{ customConfig : 'mini_config.js' }
							);
	
		CKEDITOR.replace(  'content',
									{  customConfig : 'config.js' }
						);
	});
</script>
<script language="javascript">

$(window).load(function(){
	$.each( $( ".image_video" ), function() {
		if($(this).attr('checked') == 'checked'){
			var radio_button_value = $(this).val();
	
			if(radio_button_value == "image"){
				$('.welcome_video').hide();
			}
			if(radio_button_value == "video"){
				$('.welcome_image').hide();
			}
		}
	});
	
	var videoType = $('select.videoType option:selected').val();
	
	if(videoType == "youtube_video"){
		$('.vimeo_video').hide();
		$('.youtube_video').show();
		$('.orButton').hide();
	}
	if(videoType == "vimeo_video"){
		$('.youtube_video').hide();
		$('.vimeo_video').show();
		$('.orButton').hide();
	}
	
	
});

$(document).ready(function(){

	$("#main_title").keyup(function(){

		$("#sef_title").html($(this).val());

	})

/** DOJO 18/11 **/
$("#delete_img").click(function(){

		$('#img').hide();
		var location_id=$(this).attr('location');
		
		var image_path=$('#img').attr('src');
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/home/deleteAboutImg',						
		data: { location_id : location_id,image_path:image_path }					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			//setTimeout("window.location.href='admin/"+mod_type+"/edit/"+staff_id+"'",1000);
		}
		
		});

	});
	
$('.image_video').click(function(){
	var radio_button_value = $(this).val();
	
	if(radio_button_value == "image"){
		$('.welcome_video').hide();
		$('.welcome_image').show();
	}
	if(radio_button_value == "video"){
		$('.welcome_image').hide();
		$('.welcome_video').show();
	}
});
	
	
$('.videoType').change(function(){
	var videoType = $(this).val();
	
	if(videoType == "youtube_video"){
		$('.vimeo_video').hide();
		$('.youtube_video').show();
		$('.orButton').hide();
	}
	if(videoType == "vimeo_video"){
		$('.youtube_video').hide();
		$('.vimeo_video').show();
		$('.orButton').hide();
	}
});
	
})
</script>



<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Video Section</h2>
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

<form id="blog_form" action="" method="post"  enctype="multipart/form-data">

<script language="javascript">

$(document).ready(function(){

$(".form-light-holder .checkbox1").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form-light-holder").children(".hidden_cb1").val("0");

		
	}

	else

	{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form-light-holder").children(".hidden_cb1").val("1");
	}

})

})

</script>
<div class="form-light-holder">
	<a id="published" class="checkbox1 <?php echo (!empty($pagedetails) && $pagedetails[0]->video_section == 1) ? 'check-on' : 'check-off'; ?>"></a>

	<h1 class="inline">Video Section </h1>

	<input type="hidden" value="<?php echo (!empty($pagedetails) && $pagedetails[0]->video_section == 1) ? 1 : 0; ?>" name="video_section" class="hidden_cb1" />

</div>

<div class="form-light-holder">

<div class="row row-xs align-items-center">
	<div class="col-md-2">
		<label class="form-label mg-b-0">IMAGE OR VIDEO</label>
	</div>
	<div class="col-md-10  mg-t-5 mg-md-t-0">
	<div class="row mg-t-10">
		<div class="col-lg-2">
		  <label class="rdiobox">
			<input type="radio" class="image_video" name="image_video" value="image" <?php if(!empty($pagedetails) && $pagedetails[0]->image_video == 'image'){ echo 'checked=checked'; } ?>  />
			<span>Image</span>
		  </label>
		</div><!-- col-3 -->
		<div class="col-lg-9 mg-t-20 mg-lg-t-0">
		  <label class="rdiobox">
			<input type="radio" class="image_video" name="image_video" value="video" <?php if(!empty($pagedetails) && $pagedetails[0]->image_video == 'video'){ echo 'checked=checked'; } elseif(empty($pagedetails[0]->image_video)){  echo 'checked=checked'; }?> /> 
			<span>Video</span>
		  </label>
		</div><!-- col-3 -->
		</div>
	</div>
</div>

</div>
<div class="welcome_image">
<div class="form-light-holder" style="overflow:auto;">
	<div class="adsUrl">
	<h1 style="padding-bottom: 5px;">Choose a Photo</h1>
	<div class="custom-file half_width_custom_file">
			<input type="file" name="userfile"  class="custom-file-input" id="customFile1" accept="image/*" />
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	<p><i>Image should be at least 525 pixels in width</i></p>
	
	<?php if(!empty($pagedetails) && !empty($pagedetails[0]->photo)): ?>
	<div><img id='img' src="<?=base_url().'upload/about_us/'.$pagedetails[0]->photo;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-photo" value="<?=$pagedetails[0]->photo;?>" />
	<?php endif;?>
		
		
		
		<?php if(!empty($pagedetails) && !empty($pagedetails[0]->photo)){ 
				echo "<a href='javascript:void(0);' id='delete_img' class='delete_image_btn_new'  location='".$pagedetails[0]->location_id."'>Delete image</a>";
				}
		?>	
		
		</div>
		<div class="linkTarget">
		<h1>Image alt text</h1>
	<input type="text" value="<?php if(!empty($pagedetails)){ echo $pagedetails[0]->image_alt; } ?>" name="image_alt" id="image_alt" class="field" placeholder="image alt text"/>
		</div>
		<div>
		</div>
</div>

</div>
<div class="form-light-holder  d-md-flex  dual_input welcome_video">
	<div class="adsUrl  form-group">
		<h1>Video Type</h1>
		<select name="video_type" id="" class="field videoType" >
		<option value="youtube_video" <?php if(!empty($pagedetails) && $pagedetails[0]->video_type == 'youtube_video'){ echo 'selected=selected'; } ?>>Youtube Video</option>
		<option value="vimeo_video" <?php if(!empty($pagedetails) && $pagedetails[0]->video_type == 'vimeo_video'){ echo 'selected=selected'; } ?>  >Vimeo Video</option>
	</select>
	
	</div>
	<div class="linkTarget  form-group">
	<div class="youtube_video">
	<h1>Youtube Video</h1>
	<input type="text" name="youtube_video" value="<?php if(!empty($pagedetails)){ echo $pagedetails[0]->youtube_video; }?>" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://www.youtube.com/embed/UWCbfxwwC-I
	</div>
	</div>
	<span class="orButton">OR</span>
	<div class="vimeo_video">
	<h1>Vimeo Video</h1>
	<input type="text" name="vimeo_video" value="<?php if(!empty($pagedetails)){ echo $pagedetails[0]->vimeo_video; } ?>" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://player.vimeo.com/video/167143332
	</div>
	</div>
	</div>
	
</div>
	
	
	<div class="form-light-holder">
		<h1>Title</h1>		
		<input type="text" value="<?php if(!empty($pagedetails)){ echo $this->query_model->getStrReplaceAdmin(ucwords($pagedetails[0]->title)); } ?>" name="title" id="main_title" class="field full_width_input" style=""/>
		<!-- <div style="margin-bottom:10px;">
			Title will appear in the URL as: <em id="sef_title"><?=base_url()."view/".$pagedetails[0]->id;?></em>
		</div> --> 
	</div>
	
	<!--- DOJO 01/12 --->
	<div class="form-light-holder">
		<h1>Sub Title</h1>		
		<textarea name="sub_title" class="ckeditor" id="sub_title" style="height: 74px" ><?php if(!empty($pagedetails)){ echo $pagedetails[0]->sub_title; } ?></textarea>
	</div>	
		
	<div class="form-light-holder" style=" display:none">
		
		<textarea name="text" class="ckeditor" id="content"><?php if(!empty($pagedetails)){ echo $pagedetails[0]->content; }?></textarea>
	</div>
	
	<!--<div class="form-light-holder">
		<h1>Meta Title</h1>
			<input type="text" value="<?php if(!empty($pagedetails)){ echo $pagedetails[0]->meta_title; }?>" name="meta_title" id="meta_title" class="field" placeholder="Meta title" style="width: 98%"/>
	</div> -->
	<div class="form-white-holder" style="padding-bottom:20px;">
	<input type="hidden" class="location_id" name="location_id" value="<?= $location_id;?>" />
		<input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />
	</div>
	
	<!--<div class="btn-save">-->
	<!--	<a style="" href="admin/staff/add"></a>-->
	<!--</div>-->
	
		</form>
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

			</div>
		</div>
		</div>
		
	<?php } } ?>		

	</div>
</div>

</div>

		</div>

		</div>

	</div>

	</div>

</div>
</div>
</div>
</div>


<?php $this->load->view("admin/include/footer");?>