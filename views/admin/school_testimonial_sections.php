<?php $this->load->view("admin/include/header"); ?>



<script language="javascript">
$(window).load(function(){
	if($('.student_section_hidden_cb').val() == 1){
		$('.all_testimonials').hide();
		$('.unique_testimonial_part').show();
	}else{
		$('.all_testimonials').show();
		$('.unique_testimonial_part').hide();
	}
})
$(document).ready(function(){
	
	
	$(".student_section .student_section_checkbox").click(function(){
		
		if($(this).hasClass("check-on")){
			$(this).removeClass("check-on");
			$(this).addClass("check-off");
			$(this).parents(".form-light-holder").children(".student_section_hidden_cb").val("0");
			$('.all_testimonials').show();
			$('.unique_testimonial_part').hide();
			
			var unique_testimonial = 0;
		}
		else
		{
			$(this).removeClass("check-off");
			$(this).addClass("check-on");
			$(this).parents(".form-light-holder").children(".student_section_hidden_cb").val("1");
			$('.all_testimonials').hide();
			$('.unique_testimonial_part').show();
			
			var unique_testimonial = 1;
		}
	
	var location_id = $('#location_id').val();
	
	$.ajax({ 					
			type: 'POST',						
			url: 'admin/school/save_unique_testimonial',						
			data: { unique_testimonial : unique_testimonial,location_id:location_id, type: "uniqueTestimonial"}					
			}).done(function(msg){ 
			if(msg != null){
			//alert(msg);
			//setTimeout("window.location.reload()",1000);
			}
		}); 
		
	});
	
	$("#delete_img").click(function(){
		
		$('#img').hide();
		var location_id=$(this).attr('location');
		
		var image_path=$('#img').attr('src');
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/school/deleteAboutImg',						
		data: { location_id : location_id,image_path:image_path }					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			$('#last-photo').val('');
			//setTimeout("window.location.href='admin/"+mod_type+"/edit/"+staff_id+"'",1000);
		}
		
		});

	});
	
})
</script>

<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Testimonial / Trial Offer</h2>
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

<div class="mb-3 main-content-label page_main_heading">Testimonial Section</div>
<form action="" method="post"  enctype="multipart/form-data">

<div class="form-light-holder student_section">
		<a id="status" class="student_section_checkbox  <?php if(!empty($pagedetails) && $pagedetails[0]->unique_testimonial == 1) echo "check-on"; else echo "check-off"; ?>"> &nbsp; </a>
		<h1 class="inline">Unique Testimonial</h1>
		
		<input type="hidden" value="<?php if(!empty($pagedetails) && $pagedetails[0]->unique_testimonial == 1) echo 1; else echo 0; ?>" name="unique_testimonial" class="student_section_hidden_cb" />
</div>

<div class="all_testimonials">

<?php if(!empty($testimonials)){ ?>
<div class="form-light-holder">
	<h1>Testimonials</h1><br/>
	<?php foreach($testimonials as $testimonial){ 
			$selectedTesti = (!empty($pagedetails[0]) && !empty($pagedetails[0]->testimonial_ids)) ? unserialize($pagedetails[0]->testimonial_ids) : '';
			
			
	?>
	<label class="ckbox mg-b-10">
		<input type="checkbox" name="testimonial_ids[]" value="<?php echo $testimonial->id; ?>" <?php echo (!empty($selectedTesti) && (in_array($testimonial->id , $selectedTesti))) ? 'checked=checked' : ''; ?>><span><?php echo $testimonial->title.' ('.$testimonial->name.')'; ?> </span></label>
	<?php } ?>
</div>
<?php } ?>

<div class="form-new-holder">
<input type="hidden" value="<?= $location_id; ?>" name="location_id" class="location_id" id="location_id" />
<input type="hidden" value="testimonial" name="form_type" />
		<input type="submit" name="update" value="Save" class="btn-save" />
</div>

</div>


</form>

</div>

		</div>

		</div>

	</div>
<div class="unique_testimonial_part">

<!--<div class="btn-addentry add_entry_button"></div>-->
<h1 > &nbsp;&nbsp; </h1>


<div class="program_full_detail  new_lisiting_block default_template" id="AlternatingFullWidth">

				<!--<div class="mb-3 main-content-label" >Testimonials</div> -->
				<div class="row row-xs align-items-center  mg-b-5">
					<div class="col-md-12">
						<p>You may rearrange the order of the items below by dragging them above or below other item rows. Changes will automatically be saved.</p>
					</div>
					
				</div>
				
				<div class="row row-xs align-items-center mg-b-20  alternating-row-section ">
					
					<div class="col-md-12 mg-t-5 mg-md-t-0 ">
						<div class="az-content-body ">
			
							<div class="az-mail-header">
								<div>
								  <h4 class="az-content-title mg-b-5">Testimonials</h4>
								  <p>You have <span class="total_alternating_full_width_row"><?php echo !empty($schoolTestimonials) ? count($schoolTestimonials) : 0; ?></span> Entries</p>
								</div>
								<div>
								 <a href="admin/school/add_school_testimonial/<?php echo $location_id; ?>" class="button_class btn btn-indigo ">Add Testimonial</a>
								</div>
							  </div>
							  
			<ul class="ajax_record_sortable alternating_full_width_row"  table_name="tbl_school_testimonials" >

			<?php
			$sr_testimonials=0; 
							
			if(!empty($schoolTestimonials)):
			 foreach($schoolTestimonials as $row):
			 $sr_testimonials++;
			?>


					<li   id="menu_<?=$row->id?>" class="full_width_row_<?=$row->id?> az-contact-info-header">
						<div class="manager-item media">
							<div style="float:left;">
								<div class="badge-no"><?=$sr_testimonials?>. </div>
								
									
								<h4 class="full_width_row_heading_<?=$row->id?>"><a href="javascript:void(0)" ><?=$row->name;?> </a></h4>
							</div>
							<div class="manager-item-opts">
							
							
						<nav class="nav">
							 
							  <a href="admin/<?=$link_type?>/edit_school_testimonial/<?=$row->id;?>" class="badge badge-primary">Edit</a>
							  
									<a class="badge badge-primary ajax_record_delete" data-toggle="modal" data-target="#popupDeleteRecord" item_id="<?=$row->id;?>"   table_name="tbl_school_testimonials" item_title="<?=$row->name;?>" section_type="full_width">Delete</a>
									
									<a href="javascript:void(0)" id="unpub_<?=$row->id; ?>" class="ajax_record_publish"  table_name="tbl_school_testimonials"  is_new="0">
								<div class="az-toggle az-toggle-success alternate_full_width_toogle toogle_btn <?php echo ($row->published == 1) ? 'on' : '';?>" publish_type="<?php echo ($row->published == 1) ? 0 : 1;?>"><span></span>
								<input type="hidden" name="publish_type" value="<?php echo ($row->published == 1) ? 0 : 1;?>" class="publish_type" />
								</div></a>
						</nav>



							</div>
						</div>
					</li>
<?php endforeach;?>								

<?php else: ?>

<?php endif;?>
								</ul>

	<input type="hidden" name="mod_type" value="<?=$link_type;?>" id="mod_type" />		
			
						
						
				</div>
			</div>
		</div>
</div>

</div>	

<h1 > &nbsp;&nbsp; </h1>
<form action="" method="post"  enctype="multipart/form-data">

<div class="mb-3 main-content-label page_main_heading">Trial Offer Section</div>


<div class="form-light-holder trialoffer_section">
		
		<a id="status" class="trialoffer_checkbox  <?php if(!empty($pagedetails) && $pagedetails[0]->unique_trial_offer == 1) echo "check-on"; else echo "check-off"; ?>"> &nbsp; </a>
		<h1 class="inline">Unique Trial Offer</h1>
		<input type="hidden" value="<?php if(!empty($pagedetails) && $pagedetails[0]->unique_trial_offer == 1) echo 1; else echo 0; ?>" name="unique_trial_offer" class="trialoffer_hidden_cb" />
</div>

<div class="all_trial_offers">

<?php  if(!empty($all_trial_categories)){ ?>
<div class="form-light-holder">
	<h1>Trial Offers</h1><br/>
	<?php foreach($all_trial_categories as $trial_category){ 
			$selectedTesti = (!empty($pagedetails[0]) && !empty($pagedetails[0]->trial_offer_ids)) ? unserialize($pagedetails[0]->trial_offer_ids) : '';
			
			
	?>
	<label class="ckbox mg-b-10 ">
		<input type="checkbox" name="trial_offer_ids[]" value="<?php echo $trial_category->id; ?>" <?php echo (!empty($selectedTesti) && (in_array($trial_category->id , $selectedTesti))) ? 'checked=checked' : ''; ?>><span><?php echo $trial_category->name; ?> </span></label>
	<?php } ?>
</div>
<?php } ?>

<div class="form-new-holder">
<input type="hidden" value="<?= $location_id; ?>" name="location_id" class="location_id" id="location_id" />
<input type="hidden" value="trial_offer" name="form_type" />
		<input type="submit" name="update" value="Save" class="btn-save" />
</div>

</div>


</form>



	</div>
</div>
</div>
</div>
</div>



<!----------------------------->



<!------- Trail offer section ---->


<script language="javascript">
$(window).load(function(){
	if($('.trialoffer_hidden_cb').val() == 1){
		$('.all_trial_offers').show();
	}else{
		$('.all_trial_offers').hide();
	}
})
$(document).ready(function(){
	
	
	$(".trialoffer_section .trialoffer_checkbox").click(function(){
		
		if($(this).hasClass("check-on")){
			$(this).removeClass("check-on");
			$(this).addClass("check-off");
			$(this).parents(".form-light-holder").children(".trialoffer_hidden_cb").val("0");
			$('.all_trial_offers').hide();
			
			var unique_trial_offer = 0;
		}
		else
		{
			$(this).removeClass("check-off");
			$(this).addClass("check-on");
			$(this).parents(".form-light-holder").children(".trialoffer_hidden_cb").val("1");
			$('.all_trial_offers').show();
			
			var unique_trial_offer = 1;
		}
	
	var location_id = $('#location_id').val();
	
	$.ajax({ 					
			type: 'POST',						
			url: 'admin/school/save_unique_trialoffer',						
			data: { unique_trial_offer : unique_trial_offer,location_id:location_id, type: "uniqueTestimonial"}					
			}).done(function(msg){ 
			if(msg != null){
			//alert(msg);
			//setTimeout("window.location.reload()",1000);
			}
		}); 
		
	});
	
	
})
</script>


<?php $this->load->view("admin/include/footer");?>