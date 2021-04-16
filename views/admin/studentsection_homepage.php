<?php $this->load->view("admin/include/header"); ?>
<!-- end head contents -->
<!-- wysiwyg editor script -->
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
 <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
    <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>  

<script src="js/ckeditor_full/ckeditor.js"></script>
<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Student Section <?php echo $title ?></h2>
			</div>
			
		  </div>
	  </div>
	   <div class="row row-sm program-cat-page">

          <div class="col-sm-12 col-xl-12 az-content-body-contacts"  >
			<div class="card pd-sm-20 edit-form">	
<div class="gen-holder">
		<div class="gen-panel">
			
<div class="panel-body">
<div class="panel-body-holder">
<div class="manager-items custom">
<div class=" floatNone" style="margin-bottom:25px;">
<form action="<?=base_url()?>admin/offers/miniformvalues" method="post">
<div class="mb-3 main-content-label page_main_heading">Edit: Student Section <?php echo $title ?></div>
<div class="form-light-holder">
	<a id="published" class="checkbox <?php if($mini_form_detail[0]->homepage_referral_box == 1) echo "check-on"; else echo "check-off"; ?>"></a>
	<h1 class="inline" style="background:none">Show Homepage Sticky Note?</h1>
	<input type="hidden" value="<?=$mini_form_detail[0]->homepage_referral_box?>" name="homepage_referral_box" class="hidden_cb" />
</div>
<div class="form-light-holder">
    	<span class="field_title">Homepage Sticky Note Title</span><br />
       <input type="text" name="homepage_referral_title"  class="field  full_width_input" value="<?= $mini_form_detail[0]->homepage_referral_title ?>" style="" />&nbsp;
</div>


<div class="form-light-holder">
    	<span class="field_title">
    	Homepage Sticky Note Description</span><br />
		<textarea class="ckeditor" name="homepage_referral_desc"><?= $mini_form_detail[0]->homepage_referral_desc ?></textarea>
</div>
<div class="form-light-holder">
    	<span class="field_title">Homepage Head Title</span><br />
       <input type="text" name="title" required="" class="field  full_width_input" value="<?= !empty($page_title)? $page_title[0]->title:''; ?>" />&nbsp;
       <input type="hidden" name="id" value="1"  />
</div>

<div class="form-light-holder">
	<a id="published" class="checkbox_event <?php if($mini_form_detail[0]->show_home_recent_event == 1) echo "check-on"; else echo "check-off"; ?>"></a>
	<h1 class="inline" style="background:none">Show Homepage Upcoming Events Box?</h1>
	<input type="hidden" value="<?=$mini_form_detail[0]->show_home_recent_event?>" name="show_home_recent_event" class="hidden_cb" />
</div>

<div class="form-light-holder   row row-xs align-items-center  categoryTypeBox" style="<?php if($mini_form_detail[0]->show_home_recent_event == 1){ echo 'display:show'; }else{ echo 'display:none';  }  ?>">
<div class="col-md-3">
<label class="rdiobox">
	<input type="radio" name="event_category_type" class="category_type" value="all_categories" <?php  if($mini_form_detail[0]->event_category_type == "all_categories"){ echo 'checked=checked'; } ?>><span>Show All Categories 
	</span></label>	</div>
	<div class="col-md-3">
	<label class="rdiobox">
	<input type="radio" class="category_type" name="event_category_type" value="custom_categories" <?php  if($mini_form_detail[0]->event_category_type == "custom_categories"){ echo 'checked=checked'; } ?>><span> Select Categories
	</span></label>	</div>
</div>


<?php if(!empty($categories)){ ?>
<div class="form-light-holder  row row-xs align-items-center customCategoryTypeBox" style="<?php if($mini_form_detail[0]->event_category_type == "custom_categories"){ echo 'display:show'; }else{ echo 'display:none';  }  ?>">
	<?php
		
		$selected_categories = unserialize($mini_form_detail[0]->event_show_categories);
		
	?>
	<?php foreach($categories as $category){ ?>
	<div class="col-md-3">
	<label class="ckbox mg-b-10">
		<input type="checkbox" name="event_show_categories[]" value="<?php echo $category->cat_id; ?>" <?php if(!empty($selected_categories) && in_array($category->cat_id ,$selected_categories)){ echo "checked=checked"; } ?>><span><?php echo $category->cat_name; ?> </span></label>
	</div>
	<?php } ?>
</div>
<?php } ?>

<div class="form-light-holder">
	<a id="published" class="checkbox_upload <?php if($mini_form_detail[0]->show_home_recent_upload == 1) echo "check-on"; else echo "check-off"; ?>"></a>
	<h1 class="inline" style="background:none">Show Homepage Recent Uploads Box?</h1>
	<input type="hidden" value="<?=$mini_form_detail[0]->show_home_recent_upload?>" name="show_home_recent_upload" class="hidden_cb" />
</div>

<div class="form-light-holder">
	<a id="published" class="checkbox_post <?php if($mini_form_detail[0]->show_home_recent_post == 1) echo "check-on"; else echo "check-off"; ?>"></a>
	<h1 class="inline" style="background:none">Show Homepage Recent Posts Box?</h1>
	<input type="hidden" value="<?=$mini_form_detail[0]->show_home_recent_post?>" name="show_home_recent_post" class="hidden_cb" />
</div>


<div class="form-light-holder">
    	<input type="submit" name="update" value="Update" class="btn-save" />
</div>
</form>	</div>

		</div>

		</div>

	</div>

	</div>

</div>
</div>
</div>
</div>

<script language="javascript">
$(document).ready(function(){

	$(".form-light-holder .checkbox, .form-light-holder .checkbox_upload, .form-light-holder .checkbox_post").click(function(){
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

	
	$(".form-light-holder .checkbox_event").click(function(){
		if($(this).hasClass("check-on")){
			$(this).removeClass("check-on");
			$(this).addClass("check-off");
			$(this).parents(".form-light-holder").children(".hidden_cb").val("0");
			
			$(".categoryTypeBox").hide();
			$(".customCategoryTypeBox").hide();
		}
		else
		{
			$(this).removeClass("check-off");
			$(this).addClass("check-on");
			$(this).parents(".form-light-holder").children(".hidden_cb").val("1");
			
			$(".categoryTypeBox").show();
			
			var category_type = $("input[name='event_category_type']:checked").val();
			if(category_type == "custom_categories"){
				$('.customCategoryTypeBox').show();
			}else{
				$('.customCategoryTypeBox').hide();
			}
			
		}
	});

	$('.category_type').click(function(){
		
			var value = $(this).val();
			
			if(value == "custom_categories"){
				$('.customCategoryTypeBox').show();
			}else{
				$('.customCategoryTypeBox').hide();
			}
			
		});
});
</script>
<!-- recent items -->
<?php $this->load->view("admin/include/footer");?>
