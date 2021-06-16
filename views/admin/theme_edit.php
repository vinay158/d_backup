<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>
<script>
	$(window).load(function(){
		var check_stand_alone_page = $('.stand_alone_page_button').val();
		if(check_stand_alone_page == 0){
			$('.stand_alone_page').hide();
		}
		$.each( $( ".radio" ), function() {
			if($(this).attr('checked') == 'checked'){
				if($(this).val() == 1){
					$('.paid_trial').show();
				} else {
					$('.paid_trial').hide();
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
});
</script>

<div class="az-content-body-left  advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title"><?php echo $title; ?></h2>
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

<form id="blog_form" action="" method="post" enctype="multipart/form-data">
<?php  if(!empty($details)): ?>

<div class="mb-3 main-content-label page_main_heading">Edit: Theme</div>
<div class="form-light-holder">
	<h1>Theme Name</h1>
	<input type="text" value="<?=$details->theme_name?>" name="theme_name" id="name" class="field " placeholder="Enter your theme name here" />
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
});

$("#delete_img").click(function(){

	var id=$('#program_id').val();
		var image_path=$('#img').attr('src');
					
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/themes/delete',						
		data: { id : id,image_path:image_path }					
		}).done(function(msg){ 
		if(eval(msg) == 1){		
			setTimeout("window.location.href='admin/themes/edit/"+id+"'",1000);			
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});
 });
 
 
 
$("#delete_files").click(function(){

	var id=$('#program_id').val();
				
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/themes/delete_files',						
		data: { id : id}					
		}).done(function(msg){ 
		if(eval(msg) == 1){		
			setTimeout("window.location.href='admin/themes/edit/"+id+"'",1000);			
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});
 });
 
	
 
})
</script>





<div class="form-light-holder" style="overflow:auto;">
			<h1 style="padding-bottom: 5px;">Css File</h1>
			
			<div class="custom-file half_width_custom_file">
				
			<input type="file" name="files" class="custom-file-input" id="customFile1" accept=".css" />
			<label class="custom-file-label" for="customFile">Choose file</label></div>
			
			<div><img  src="images/Files-Folders.png" style="width: 100px; clear:both;" /></div>
			<div><?=$details->files;?></div>
			<input type="hidden" name="last_files" value="<?=$details->files;?>" />
			
			<?php if($details->files){ 
					echo "<a href='javascript:void(0);' id='delete_files' number='".$details->id."'>Delete File</a>";
				}
			?>	
		<div>
		</div>
		<p><i>Note: please upload only css file</i></p>
</div>
<div class="form-white-holder" style="padding-bottom:20px;">
	<input type="hidden" value="<?=$details->id?>" name="id" id="program_id" class="hidden_cb" />
	<input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />
</div>
<?php endif;?>
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
