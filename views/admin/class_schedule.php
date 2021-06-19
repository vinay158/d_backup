<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		$(".form-light-holder .checkbox").click(function(){
			if($(this).hasClass("check-on")){
				$(this).removeClass("check-on");
				$(this).addClass("check-off");
				$(this).parents(".form-light-holder").children(".hidden_cb").val("0");
				var publish = 0;
			}
			else
			{
				$(this).removeClass("check-off");
				$(this).addClass("check-on");
				$(this).parents(".form-light-holder").children(".hidden_cb").val("1");
				var publish = 1;
			}
			
			$.ajax({ 					
			type: 'POST',						
			url: 'admin/classschedule/save_class_schedule_button',						
			data: { publish : publish}					
			}).done(function(msg){ 
			if(msg != null){
			//alert(msg);
			//setTimeout("window.location.reload()",1000);
			}
		});
		});
	});
</script>


<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Class Schedule</h2>
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
		
		<!--<div class="mb-3 main-content-label page_main_heading">Edit: Class Schedule</div>-->
		
<div class="form-light-holder">
	<a id="published" class="checkbox <?php if($site_setting[0]->class_schedule_button==1) echo "check-on";   else echo "check-off"; ?>"></a>
	<span class="inline" style="margin-left: 10px">Show Class Schedule Button</span>
	<input type="hidden" value="<?php if(!empty($site_setting)){ echo $site_setting[0]->class_schedule_button; }?>" name="published" class="hidden_cb" />
</div>
<form id="blog_form" action="" method="post" enctype="multipart/form-data">
<script language="javascript">
$(document).ready(function(){



$("#delete_img").click(function(){

	var answer = confirm('Are you sure you want to delete image? This will also delete image from featured programs.');
	if (answer)
	{
		var program_id=$('#program_id').val();
		var image_path=$('#img').attr('src');
					
		var mod_type = $("#contact_mod").val().toLowerCase();
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/'+mod_type+'/delete',						
		data: { program_id : program_id,image_path:image_path }					
		}).done(function(msg){ 
		if(eval(msg) == 1){		
			setTimeout("window.location.href='admin/"+mod_type+"/edit/"+program_id+"'",1000);			
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});
	}
	else
	{
	   return false;
	}
//stand_page_delete_img

 });
 
 $(".stand_page_delete_img").click(function(){

	
		var id=$(this).attr('number');
		var image_path=$('#img'+id).attr('src');
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/classschedule/delete_class_schedule_img',						
		data: { id : id,image_path:image_path }					
		}).done(function(msg){ 
		if(eval(msg) == 1){		
			
			setTimeout("window.location.href='admin/classschedule'",1000);			
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});

	});
	
	
	
	$(".delete_stand_page").click(function(){
		//if($('.standPages').length > 1){
				var id=$(this).attr('number');
				
				$.ajax({ 					
				type: 'POST',						
				url: 'admin/classschedule/delete_classs_chedule',						
				data: { id : id}					
				}).done(function(msg){ 
				if(eval(msg) == 1){		
					$('.class_schedule_'+id).hide();
					$('.stand_page_'+id).remove();
					//setTimeout("window.location.href='admin/classschedule'",1000);			
				}
				else{
					alert("Oops! Unable to Delete, Please check folder permission.");
					return false;					
				}
			});
		/*} else {
				alert('Error: Minimum 1 records')
		}*/
	});
	
	
	
	$('.saveClassSch').click(function(){
		setTimeout("window.location.href='admin/classschedule'",500);	
	});
 
})
</script>
<style>
.standPages{margin-bottom:15px; }
</style>

<div class="">	
<div id="AddMoreStandAlonePage">
	
	<?php if(!empty($class_schedules)){ 
				$a = 1;
				foreach($class_schedules as $class_schedule){
	?>
		<div class="standPages  stand_page_<?=$class_schedule->id?>">
			<div class="col-sm-12 col-xl-12">
				<div class="mb-3 main-content-label page_main_heading">Class Schedule #<?= $a ?>
					<span style="float:right"><a href="javascript:void(0)" class="delete_stand_page delete_row_custom_btn" number="<?=$class_schedule->id?>">Delete</a></span>
				</div>
			</div>
			
			<div class="form-light-holder">
			
				<h1>Button Name #<?= $a ?> </h1>
				<input type="text" value="<?=$class_schedule->button_name?>" name="data[<?= $a ?>][button_name]" id="name" class="field full_width_input" placeholder="Enter your name here" />
			</div>
				
				<div class="form-light-holder" style="overflow:auto;">
						<h1 style="padding-bottom: 5px;">Files #<?= $a ?> </h1>
						<div class="custom-file half_width_custom_file">
						<input type="file" name="stand_page_photo<?= $a ?>" class="custom-file-input" id="customFile<?= $a ?>"  />
					<label class="custom-file-label" for="customFile">Choose file</label></div>
						
						
						<?php if(!empty($class_schedule->files)): ?>
						<div><?php if($class_schedule->files != 'Null'){
										$file_full_path = 'upload/class_schedule/'.$class_schedule->files;
											$fileDetail = getimagesize($file_full_path);
												if(!empty($fileDetail)){
							?>
							
							<img id="img_<?=$class_schedule->id;?>" class="class_sch_image" src="upload/class_schedule/<?=$class_schedule->files;?>" style="width: 100px; clear:both;" />
							<br /><?=$class_schedule->files ?>
							<?php } else { ?>
							
							<img id="img_<?=$class_schedule->id;?>" class="class_sch_image" src="images/pdf_icon.png" style="width: 100px; clear:both;" />
							<br /><?=$class_schedule->files ?>
							<?php } } ?>	</div>
						<input type="hidden" name="data[<?= $a ?>][last_stand_photo]" value="<?=$class_schedule->files;?>" />
						<?php endif;?>
						
						<?php if($class_schedule->files){ 
								//echo "<a href='javascript:void(0);' class='stand_page_delete_img' number='".$class_schedule->id."'>Delete image</a>";
								}
						?>	
					<div>
				</div>
			</div>
		</div>
		
		
	<?php 
			$a++; 
		}
	 } else { 
?>
<div class="standPages">
<div class="mb-3 main-content-label page_main_heading">Class Schedule #1</div>
	<div class="form-light-holder">
		<h1>Title #1</h1>
		<input type="text" value="" name="data[1][button_name]" id="name" class="field full_width_input" placeholder="Enter your name here" />
	</div>
		
		<div class="form-light-holder" style="overflow:auto;">
				<h1 style="padding-bottom: 5px;">Image #1  </h1>
				<div class="custom-file half_width_custom_file">
						<input type="file" name="stand_page_photo1" class="custom-file-input" id="customFile1"  />
					<label class="custom-file-label" for="customFile">Choose file</label></div>
				
			<div>
		</div>
	</div>
</div>
<?php  } ?>

</div>

<h3><a href="javascript:void(0);" class="btn btn-outline-light AddMoreStandAlonePageButton">Add Another Schedule</a></h3>
</div>

<div class="form-white-holder" style="padding-bottom:20px;">
<input type="hidden" value="1" name="class_schedule_id" class="hidden_cb" />
	<input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />
</div>
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


<input type="hidden" class="totalAddMoreStandAlonePage" value="<?php if(count($class_schedules) >= 1){ echo count($class_schedules); } else { echo 1; } ?>"  />
<script language="javascript" type="text/javascript">
 	
	$(document).ready(function(){
		
		
		$('.AddMoreStandAlonePageButton').click(function(){
			var totalAddMoreFeatures = $('.totalAddMoreStandAlonePage').val();
			var b = parseInt(totalAddMoreFeatures) + Number(1);
			$('.totalAddMoreStandAlonePage').val(b);
				
				//$('#AddMoreStandAlonePage').append('<div class="standPages"><div class="form-light-holder"><h1>#'+b+' Title </h1><input type="text" value="" name="data['+b+'][button_name]" id="name" class="field " placeholder="Enter your name here" /></div><div class="form-light-holder" style="overflow:auto;"><h1 style="padding-bottom: 5px;">#'+b+' Image </h1><div><input type="file" class="class_sch_image" name="stand_page_photo'+b+'" id="" required="required" /><div></div></div></div>');
				
				$('#AddMoreStandAlonePage').append('<div class="standPages"><div class="col-sm-12 col-xl-12"><div class="mb-3 main-content-label page_main_heading">Class Schedule #'+b+'<span style="float:right"><a href="javascript:void(0)" class="delete_row_custom_btn" onclick="$(this).parent().parent().parent().parent().remove();"  number="'+b+'">Delete</a></span></div></div><div class="form-light-holder"><h1> Button Name #'+b+' </h1><input type="text" value="" name="data['+b+'][button_name]" id="name" class="field full_width_input" placeholder="Enter your name here"></div><div class="form-light-holder" style="overflow:auto;"><h1 style="padding-bottom: 5px;">Files #'+b+' </h1><div class="custom-file half_width_custom_file"><input type="file" name="stand_page_photo'+b+'" class="custom-file-input" id="customFile'+b+'"><label class="custom-file-label" for="customFile">Choose file</label></div><div></div></div></div>');
				
				
			
		});
	});	 
	
</script>
<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>
