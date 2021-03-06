<?php $this->load->view("admin/include/header"); ?>

<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<!--<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>-->

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->

<!--<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>-->
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js" type="text/javascript"></script>
	
	<script src="color_overlay_opacity_pickier/js/spectrum.js" type="text/javascript"></script>
	<script src="color_overlay_opacity_pickier/js/toc.js" type="text/javascript"></script>
	<script src="color_overlay_opacity_pickier/js/docs.js" type="text/javascript"></script>
	<script src="color_overlay_opacity_pickier/js/prettify.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="color_overlay_opacity_pickier/css/spectrum.css">
<script src="js/ckeditor_full/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		 CKEDITOR.replace(  'ckeditor_mini', 
									{ customConfig : 'config.js' }
							);
	
		CKEDITOR.replace(  'black_box_description', 
									{ customConfig : 'config.js' }
							);
	
	//
		 CKEDITOR.replace(  'box_1_text', 
									{ customConfig : 'config.js' }
							);
							
							
		CKEDITOR.replace(  'box_2_text', 
									{ customConfig : 'config.js' }
							);
							
		CKEDITOR.replace(  'box_3_text', 
									{ customConfig : 'config.js' }
							);
	
		
	});
</script>

<style>
.label-text{padding-top:35px;font-size:18px;color:#a438ff;padding-bottom: 5px;}	
</style>

<script language="javascript" type="text/javascript">



jQuery(document).ready(function(){

    $('#headline').keyup(function(e){

            var max = 100;

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



    $('#frm-text').keyup(function(e){

        var max = 500;

        var len = $(this).val().length;

        if (len >= max) {

        	e.preventDefault();

            $('#charNumtblurb').text(' you have reached the limit');                

            $("#frm-text").attr('maxlength','200');                            	          

        }else {

            var char = max - len;

            $('#charNumtblurb').text( char + ' characters left');

        }

});

});





</script>


<div class="az-content-body-left advanced_page school_text_sections" >

       <div class="row row-sm">

          <div class="col-sm-12 col-xl-12"  >
			<div class="card pd-sm-20 program-cat-page program-detail-page">
				<div class="container">
	  
	  
        
    <div class="az-content az-content-app az-content-contacts pd-b-0">
      <div class="container">
        <div class="az-content-left az-content-left-contacts">


         <div class="az-mail-header">
            <div>
              <h4 class="az-content-title mg-b-5"><?php echo $title; ?></h4>
			   
				  
            </div>
            <div>
			
			
			</div>
          </div>
		
		<?php $page_url = ''; ?>
          <div id="azContactList" class="az-contacts-list">
			
			<a href="<?php echo $page_url; ?>#BlackBoxText" class="az-contact-item">
              <div class="az-contact-body">
                <h6>Black Box Text</h6>
              </div>
            </a>
		
			<a href="<?php echo $page_url; ?>#GreenBoxText" class="az-contact-item welcome_image">
              <div class="az-contact-body">
                <h6>Green Box Text</h6>
              </div>
            </a>
			
			<a href="<?php echo $page_url; ?>#GettingStarted" class="az-contact-item welcome_image">
              <div class="az-contact-body">
                <h6>Getting Started Text</h6>
              </div>
            </a>
			
			<a href="<?php echo $page_url; ?>#ProgramsSection" class="az-contact-item welcome_image">
              <div class="az-contact-body">
                <h6>Programs</h6>
              </div>
            </a>
			
			<a href="<?php echo $page_url; ?>#TimelineSection" class="az-contact-item welcome_image">
              <div class="az-contact-body">
                <h6>Timeline</h6>
              </div>
            </a>
			
			
			
          </div><!-- az-contacts-list -->

        </div> <!-- az-content-left -->
        <div class="az-content-body az-content-body-contacts">
			
				<div class="az-mail-header">
            <div>
              <h4 class="az-content-title mg-b-5"><?php echo $title; ?></h4>
            </div>
            
          </div>
				
				<div class=" edit-form edit_form_box">


<div class="gen-holder">

	<div class="gen-panel-holder"  style="width: 106% !important">

	<div class="gen-panel">

		

		<div class="panel-body">

		<div class="panel-body-holder">

		<div class="form-holder">



<form id="blog_form" action="" method="post" enctype="multipart/form-data">

<script language="javascript">



$(document).ready(function(){

	$("#main_title").keyup(function(){

		$("#sef_title").html($(this).val());

	})


$("#delete_img_left").click(function(){

		$('#img_left').hide();
		var location_id=$('.location_id').val();
		var photo = 'left_photo';
		var image_path=$('#img_left').attr('src');
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/school/deleteTextSectionBoxImg',						
		data: { location_id : location_id,image_path:image_path,photo:photo}					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			$("#last-photo").val('');
			//setTimeout("window.location.href='admin/"+mod_type+"/edit/"+staff_id+"'",1000);
		}
		});

	});
	

	
})
</script>

<!-- <div class="form-light-holder">
<h1>Override Logo</h1>
	<select name="override_logo" id="window" class="field">
	<?php foreach($override_logos as  $override_logo):?>
	<option value="<?=$override_logo->s_no?>" <?php if(!empty($pagedetails) && $pagedetails[0]->override_logo == $override_logo->s_no){ echo 'selected=selected';} ?>><?=$override_logo->logo_name?></option>
	<?php endforeach;?>
	</select>
</div> -->
<div class="page-section" id="BlackBoxText">
<div class="mb-3 main-content-label">Black Box  Text</div>
<div class="form-light-holder">

	<h1>Title</h1>

	<input type="text" value="<?php if(!empty($pagedetails)){ echo $this->query_model->getStrReplaceAdmin($pagedetails[0]->box_title); } ?>" name="box_title"  class="field full_width_input" placeholder="Enter title here"  style=""/>
	<span id='charNum'></span>
</div>

 

<div class="form-light-holder">

	<h1>Description </h1>

	<textarea type="text" name="box_description" id="black_box_description" class="field ckeditor full_width_input" placeholder=""  style=""/><?php echo !empty($pagedetails) ? $pagedetails[0]->box_description : '';?></textarea>

</div>

<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
		<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;"><b>Parallax Background</b></h1>
	<h1 >IMAGE UPLOADER</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="left_photo" class=" custom-file-input" id="customFile1" accept="image/*">
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	
	<?php if(!empty($pagedetails[0]->left_photo)): ?>
	<div><img id='img_left' src="<?=base_url().'upload/school_about_us/thumb/'.$pagedetails[0]->left_photo;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-left-photo" value="<?=$pagedetails[0]->left_photo;?>" />
	<?php endif;?>
	
	<?php if(!empty($pagedetails[0]->left_photo)){ 
			echo "<a href='javascript:void(0);' id='delete_img_left' class='delete_image_btn_new' >Delete image</a>";
			}
	?>	
	</div>
	
	
	<div class="linkTarget form-group" style="margin-top: 29px;">	
	
	<h1> Color Overlay And Opacity  Picker</h1>
		<div id='docs'>
		<div id='docs-content'>
			<input id="full_colorpicker_opacity" name="background_color" class="colourTextValue" value="<?php if(!empty($pagedetails)){ echo $pagedetails[0]->background_color; } ?>" />
		</div>
		
	 </div>
		</div>
</div>


 

<div class="form-light-holder">

	<h1>Box 1 Text </h1>

	<textarea type="text" name="box_1_text" id="box_1_text" class="field ckeditor full_width_input" placeholder=""  style=""/><?php echo !empty($pagedetails) ? $pagedetails[0]->box_1_text : '';?></textarea>

</div>


<div class="form-light-holder">

	<h1>Box 2 Text </h1>
<textarea type="text" name="box_2_text" id="box_2_text" class="field ckeditor full_width_input" placeholder=""  style=""/><?php echo !empty($pagedetails) ? $pagedetails[0]->box_2_text : '';?></textarea>

</div>


<div class="form-light-holder">

	<h1>Box 3 Text </h1>

	<textarea type="text" name="box_3_text" id="box_3_text" class="field ckeditor full_width_input" placeholder=""  style=""/><?php echo !empty($pagedetails) ? $pagedetails[0]->box_3_text : '';?></textarea>

</div>

</div>
<div class="page-section" id="GreenBoxText">
<div class="mb-3 main-content-label">Green Box Text</div>
<div class="form-light-holder">

	<h1>Title </h1>

	<input type="text" value="<?php if(!empty($pagedetails)){ echo $this->query_model->getStrReplaceAdmin($pagedetails[0]->full_box_title); } ?>" name="full_box_title"  class="field full_width_input" placeholder="Enter Title"  style=""/>
</div>
<div class="form-light-holder">

	<h1>Box 1 Text </h1>

	<input type="text" value="<?php if(!empty($pagedetails)){ echo $this->query_model->getStrReplaceAdmin($pagedetails[0]->full_box_1_text); } ?>" name="full_box_1_text"  class="field full_width_input" placeholder="Enter box 1 text"  style=""/>
</div>


<div class="form-light-holder">

	<h1>Box 2 Text </h1>
<input type="text" value="<?php if(!empty($pagedetails)){ echo $this->query_model->getStrReplaceAdmin($pagedetails[0]->full_box_2_text); } ?>" name="full_box_2_text"  class="field full_width_input" placeholder="Enter box 2 text"  style=""/>

</div>


<div class="form-light-holder">

	<h1>Box 3 Text </h1>

	<input type="text" value="<?php if(!empty($pagedetails)){ echo $this->query_model->getStrReplaceAdmin($pagedetails[0]->full_box_3_text); } ?>" name="full_box_3_text"  class="field full_width_input" placeholder="Enter box 3 text"  style=""/>

</div>

<div class="form-light-holder">

	<h1>Content</h1>

	<textarea type="text" name="description" id="ckeditor_mini" class="field ckeditor full_width_input" placeholder=""  style=""/><?php echo !empty($pagedetails) ? $pagedetails[0]->description : '';?></textarea>

	<span id='charNum'></span>

</div>

</div>
<div class="page-section" id="GettingStarted">
<div class="mb-3 main-content-label">Getting Started Text</div>
<div class="form-light-holder">

	<h1>Title </h1>

	<input type="text" value="<?php if(!empty($pagedetails)){ echo $this->query_model->getStrReplaceAdmin($pagedetails[0]->getting_started_title); } ?>" name="getting_started_title"  class="field full_width_input" placeholder="Enter Title"  style=""/>
</div>
<div class="form-light-holder">

	<h1>Box 1 Text </h1>

	<input type="text" value="<?php if(!empty($pagedetails)){ echo $this->query_model->getStrReplaceAdmin($pagedetails[0]->getting_started_box_1_text); } ?>" name="getting_started_box_1_text"  class="field full_width_input" placeholder="Enter box 1 text"  style=""/>
</div>


<div class="form-light-holder">

	<h1>Box 2 Text </h1>
<input type="text" value="<?php if(!empty($pagedetails)){ echo $this->query_model->getStrReplaceAdmin($pagedetails[0]->getting_started_box_2_text); } ?>" name="getting_started_box_2_text"  class="field full_width_input" placeholder="Enter box 2 text"  style=""/>

</div>


<div class="form-light-holder">

	<h1>Box 3 Text </h1>

	<input type="text" value="<?php if(!empty($pagedetails)){ echo $this->query_model->getStrReplaceAdmin($pagedetails[0]->getting_started_box_3_text); } ?>" name="getting_started_box_3_text"  class="field full_width_input" placeholder="Enter box 3 text"  style=""/>

</div>

</div>
<div class="page-section" id="ProgramsSection">
<div class="mb-3 main-content-label">Programs</div>

<?php if(!empty($programPages)){ ?>
<div class="form-light-holder">
	<h1>Prorgams</h1>
	  <span style="color:red">(Note: select any 12 programs)</span><br/>
	  <div class="row row-xs align-items-center">
	<?php 
		foreach($programPages as $key => $program){ 
			$selectedPrograms = (!empty($pagedetails) && !empty($pagedetails[0]->program_ids)) ? unserialize($pagedetails[0]->program_ids) : '';
			
			$selectedProgramsData = isset($selectedPrograms[$key]) ? $selectedPrograms[$key] : '';
			
	?>
	<?php if(isset($program['category']) && !empty($program['category'])){ ?>
	<div class="col-md-12 ">
		<h1 class="program_cat_title"><?php echo $program['category']; ?></h1>
	</div>
	<?php } ?>
	<div class="col-md-12 ">
		<div class="col-md-1 float-left">
		<label class="ckbox">
		<input type="checkbox" class="programCheckbox" name="program_ids[<?php echo $key; ?>][program_id]" value="<?php echo $key; ?>" <?php echo (!empty($selectedProgramsData) && $selectedProgramsData['program_id'] == $key) ? 'checked=checked' : ''; ?>><span>&nbsp;</span></label>
		</div>
		<div class="col-md-3 float-left">
		<input type="text" name="program_ids[<?php echo $key; ?>][order_number]" value="<?php echo !empty($selectedProgramsData) ? $selectedProgramsData['order_number'] : ''; ?>" style="width:100%" placeholder="Sort Number">
		</div>
		<div class="col-md-8 float-left">
			<h1 class="program_heading"><?php echo $program['program_title']; ?> <?php echo $program['program_title']; ?> </h1>
		</div>
	</div>	
	<?php } ?>
	</div>
</div>
<?php } ?>


<script language="javascript">
$(window).load(function(){
	if($('.hidden_cb2').val() == 1){
		$('.timelineTitle').show();
	}else{
		$('.timelineTitle').hide();
	}
})
$(document).ready(function(){

$(".form2checkbox .checkbox2").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form2checkbox").children(".hidden_cb2").val("0");
		
		$('.timelineTitle').hide();
		
	}

	else

	{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form2checkbox").children(".hidden_cb2").val("1");
		
		$('.timelineTitle').show();
	}

})


$('.programCheckbox').click(function(){
	if($(this).is(':checked')){
		var number = 0;
		$.each($('.programCheckbox'), function(){
			if($(this).is(':checked')){
				number += 1;
			}
		})
		
		if(number > 12){
			$(this).prop("checked", false);
			alert('you can select any 12 programs');
			
		}
	}
})

})

</script>

</div>
<div class="page-section" id="TimelineSection">
<div class="mb-3 main-content-label">Timeline</div>
<div class="form-light-holder form2checkbox">

	<a id="published" class="checkbox2 <?php echo (!empty($pagedetails) && $pagedetails[0]->show_timeline == 1) ? 'check-on' : 'check-off'; ?>"></a>

	<h1 class="inline">Timeline? </h1>

	<input type="hidden" value="<?php echo (!empty($pagedetails) && $pagedetails[0]->show_timeline == 1) ? 1 : 0; ?>" name="show_timeline" class="hidden_cb2" />

</div>


<div class="form-light-holder timelineTitle">

	<h1>Timeline Title </h1>

	<input type="text" value="<?php if(!empty($pagedetails)){ echo $this->query_model->getStrReplaceAdmin($pagedetails[0]->timeline_title); } ?>" name="timeline_title"  class="field full_width_input" placeholder="Enter Timeline Title"  style=""/>

</div>

<div class="form-light-holder timelineTitle">

	<h1>Timeline Text </h1>

	<input type="text" value="<?php if(!empty($pagedetails)){ echo $this->query_model->getStrReplaceAdmin($pagedetails[0]->timeline_text); } ?>" name="timeline_text"  class="field full_width_input" placeholder="Enter Timeline Text"  style=""/>

</div>
</div>

<input type="hidden" value="<?= $location_id; ?>" name="location_id" class="location_id" />



</div>

	<div class="tx-center pd-y-20 bg-gray-200" id="bottom"> 
				
				<input type="submit" name="update" value="Save" class=" save_program_form btn btn-az-primary saveProgramButton" />
				</div>
				</form>
				</div>
				</div>
				
				

			
			</div>
			</div>
			</div>
			</div>
        </div><!-- az-content-body -->
      </div></div>
    </div><!-- az-content -->
</div>
				
			</div>
			
      	
			
     </div>

<br style="clear:both"		 /><br />

<script type="text/javascript">

/*
	jQuery Document ready
*/
$(document).ready(function()
{



$("#full_colorpicker_opacity").spectrum({
   color: '<?php if(!empty($pagedetails)){ echo $pagedetails[0]->background_color; }?>',
   
});


$('.btn-save').click(function(){
	var bg_color = $('.sp-thumb-active').data("color");
	//alert(bg_color); return false;
	$('.colourTextValue').val(bg_color);
});
	
	
});
</script>

<!------------ recent items ----------------->

<?php $this->load->view("admin/include/footer");?>
<script>

	
	 new PerfectScrollbar('#azContactList', {
	  suppressScrollX: true
	});
		
		
	 var nav = $('.az-content-left-contacts');

    $(window).scroll(function () {
        if ($(this).scrollTop() > 125) {
            nav.addClass("f-nav");
        } else {
            nav.removeClass("f-nav");
        }
    });
	
	$('.az-contact-item').on('click touch', function() {
      
	  $('body').addClass('az-content-body-show');
	})      
	
	

</script>

