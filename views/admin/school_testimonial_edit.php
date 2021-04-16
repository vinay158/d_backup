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
<script>
	$(document).ready(function(){
		 CKEDITOR.replace(  'ckeditor_mini', 
									{ customConfig : 'mini_config.js' }
							);
	
	});
</script>
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
<script language="javascript">
$(document).ready(function(){
	$("#main_title").keyup(function(){
		$("#sef_title").html($(this).val());
	})

	$("#delete_img").click(function(){
		
		$('#img').hide();
		var testimonials_id=$('#testimonials_id').val();
		var image_path=$('#img').attr('src');
		
		var mod_type = 'school';
		//alert(staff_id);
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/'+mod_type+'/delete_testimonial_img',						
		data: { testimonials_id : testimonials_id, image_path:image_path }					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			$('#last-photo').val('');
			//setTimeout("window.location.href='admin/"+mod_type+"/edit/"+testimonials_id+"'",1000);
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});

	});
	
})
</script>
<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Edit: School Testimonial</h2>
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
<div class="mb-3 main-content-label page_main_heading">Edit: School Testimonial</div>
<form id="blog_form" action="" method="post" enctype="multipart/form-data">
<?php if(isset($details)):?>
<?php foreach($details as $d_row): ?>
<div class="form-light-holder">
	<h1>Name</h1>
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($d_row->name); ?>" name="name" id="name" class="field full_width_input" placeholder="Enter your name here"/>
	<input type="hidden" value="<?=$d_row->id;?>" name="testimonials_id" id="testimonials_id" >
	
</div>


<div class="form-light-holder">
	<h1>Title</h1>
	<input type="text" name="title" value="<?php echo $this->query_model->getStrReplaceAdmin($d_row->title); ?>" class="field full_width_input">
</div>


<div class="form-light-holder" style="overflow:auto;">

	<h1 style="padding-bottom: 5px;">Choose a Photo</h1>
	<div class="custom-file half_width_custom_file">
			<input type="file" name="userfile" class="custom-file-input" id="customFile1" accept="image/*">
			<label class="custom-file-label" for="customFile">Choose file</label></div>
			<p><i>Recommended image size: 250 x 250</i></p>
			
	<?php if(!empty($d_row->photo)): ?>
	<div><img id='img' src="<?=$d_row->photo;?>" style="width: 100px; clear:both;" /></div>
	<input type="hidden" name="last-photo" id="last-photo" value="<?=$d_row->photo;?>" />
	<?php endif;?>
	<?php if(!empty($d_row->photo)){ 
			echo "<a href='javascript:void(0);' id='delete_img' class='delete_image_btn_new' >Delete image</a>";
			}
	?>	
	
	
</div>

<div class="form-light-holder" style="">
	<!--<textarea name="text" class="textarea" id="frm-text"><?=$d_row->content?></textarea>
	-->
	<h1>Testimonial</h1>
	<textarea name="text" class="ckeditor" id="ckeditor_mini"><?=$d_row->content?></textarea>
	<p><i>Character Limit 650 characters  </i></p>
</div>
<div class="form-light-holder">
	<a id="published" class="checkbox <?php if($d_row->published==1) echo "check-on"; else echo "check-off";?>"></a>
	<h1 class="inline">Publish This</h1>
	<input type="hidden" value="<?=$d_row->published?>" name="publish" class="hidden_cb" />
</div>

<div class="form-white-holder" style="padding-bottom:20px;">

	<input type="hidden" name="location_id" value="<?php echo $d_row->location_id; ?>">
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
