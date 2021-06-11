<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<!--<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script> -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
<link rel="stylesheet" href="/resources/demos/style.css" />
<!--<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>-->
<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>
-->
<!--<script src="https://code.jquery.com/jquery-1.8.2.js"></script>
<script src="https://code.jquery.com/ui/1.9.0/jquery-ui.js"></script> -->

<script src="js/ckeditor_full/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		 CKEDITOR.replace(  'ckeditor_mini_header_title', 
									{ customConfig : 'config.js' }
							);
							
		CKEDITOR.replace(  'ckeditor_full_body_desc',
									{  customConfig : 'config.js' }
						);
						
		
		CKEDITOR.replace(  'img_text_headline',
									{  customConfig : 'config.js' }
						);
						
		 CKEDITOR.replace(  'ckeditor_mini_header_desc', 
									{ customConfig : 'config.js' }
							);
		
		
		CKEDITOR.replace(  'ckeditor_mini_opt1_title', 
									{ customConfig : 'config.js' }
							);	

		 CKEDITOR.replace(  'ckeditor_mini_body_title', 
									{ customConfig : 'mini_config.js' }
							);	
							
		CKEDITOR.replace(  'ckeditor_mini_action_desc', 
									{ customConfig : 'mini_config.js' }
							);	
		
		CKEDITOR.replace(  'ckeditor_mini_trial_desc', 
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
		
		$('.hide_from_navigation').hide();
		$('.hide_from_navigation_hidden_cb').val(0);
		$('.hide_from_navigation_checkbox').removeClass("check-on");
		$('.hide_from_navigation_checkbox').addClass("check-off");
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents(".form-light-holder").children(".hidden_cb").val("1");
		
		$('.hide_from_navigation').show();
	}
})

$(".hide_from_navigation .hide_from_navigation_checkbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents(".hide_from_navigation").children(".hide_from_navigation_hidden_cb").val("0");
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents(".hide_from_navigation").children(".hide_from_navigation_hidden_cb").val("1");
	}
})

})
</script>

<?php 
	$display_class = '';
	if($user_level != 1){
		$display_class = 'display_class';
	}

?>

<style>
.shorterCkeditor{width:60%}
.label-text{padding-top:35px;font-size:18px;color:#a438ff;padding-bottom: 5px;}	
</style>

<div class="az-content-body-left advanced_page" >

       <div class="row row-sm">

          <div class="col-sm-12 col-xl-12"  >
			<div class="card pd-sm-20 program-cat-page program-detail-page">
				<div class="container">
	  
	  
        
    <div class="az-content az-content-app az-content-contacts pd-b-0">
      <div class="container">
        <div class="az-content-left az-content-left-contacts">


         <div class="az-mail-header">
            <div>
              <h4 class="az-content-title mg-b-5">Category Sections</h4>
		  </div>
		  <div class="default_template">
			<nav class="pull-right"><a   data-toggle="modal" data-target="#modaldemo8" class="modal-effect badge-primary badge">Manage Order</a>
			
			</div>
            
          </div>
		
		<?php $page_url = '';//base_url().'admin/programs/edit/'.$details[0]->id.'/view/'.$details[0]->category; ?>
          <div id="azContactList" class="az-contacts-list">
			
			<a href="<?php echo $page_url; ?>#CategoryBasicSection" class="az-contact-item">
              <div class="az-contact-body">
                <h6>Category Info</h6>
              </div><!-- az-contact-body -->
            </a>
			
            <a href="<?php echo $page_url; ?>#Headersection" class="az-contact-item ">
              <div class="az-contact-body">
                 <h6>Header Section</h6>
              </div><!-- az-contact-body -->
            </a><!-- az-contact-item -->
			<a href="<?php echo $page_url; ?>#WhiteStripeFirstSection" class="az-contact-item ">
			
              <div class="az-contact-body">
                <h6>White Stripe Under Header Section</h6>
              </div><!-- az-contact-body -->
            </a><!-- az-contact-item -->
			
			<a href="<?php echo $page_url; ?>#Calltoaction3ImagesSection" class="az-contact-item default_template">
              <div class="az-contact-body">
                <h6>Call to Action with 3 Images Section</h6>
              </div><!-- az-contact-body -->
            </a>
			
			<a href="<?php echo $page_url; ?>#Images3WithTextSection" class="az-contact-item default_template">
              <div class="az-contact-body">
                <h6>3 Images with Text Section</h6>
              </div><!-- az-contact-body -->
				
            </a><!-- az-contact-item -->
			
			
			<a href="<?php echo $page_url; ?>#EmailOptin" class="az-contact-item default_template">
              <div class="az-contact-body">
                <h6>Email Opt-in #1 & #2</h6>
              </div><!-- az-contact-body -->
				 
            </a>
			
			<a href="<?php echo $page_url; ?>#IconRows" class="az-contact-item condensed_template">
              <div class="az-contact-body">
                <h6>Icon Rows</h6>
              </div><!-- az-contact-body -->
            </a>
			
			<a href="<?php echo $page_url; ?>#SeoMeta" class="az-contact-item ">
              <div class="az-contact-body">
                <h6>SEO/Meta Details</h6>
              </div><!-- az-contact-body -->
            </a>
			
			<a href="<?php echo $page_url; ?>#AlternatingFullWidth" class="az-contact-item default_template">
              <div class="az-contact-body">
                <h6>Alternating Full Width Rows</h6>
              </div><!-- az-contact-body -->
            </a>
			
          </div><!-- az-contacts-list -->

        </div> <!-- az-content-left -->
        <div class="az-content-body az-content-body-contacts">
			
				<div class="az-mail-header">
            <div>
              <h4 class="az-content-title mg-b-5">EDIT CATEGORY</h4>
            </div>
            
          </div>
				
			<div class=" edit-form edit_form_box">

<form id="blog_form" action="" method="post" enctype="multipart/form-data">				
<div class="gen-holder" style="display:flex">
	<div class="gen-panel-holder"  style="width: 100% !important;">
	<div class="gen-panel">
		
		<div class="panel-body">
		<div class="panel-body-holder">
		<div class="form-holder">

<script language="javascript">
$(window).load(function(){
	
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
	
	
	if($('.show_override_logo_hidden_cb').val() == 0){
		$('.override_logo_box').hide();
	}
	
	$.each( $( ".redirection_type" ), function() {
		if($(this).attr('checked') == 'checked'){
			var redirection_type = $(this).val();
	
			if(redirection_type == "dojocart"){
				$('.trial_offer_list').hide();
				$('.dojocart_list').show();
				$('.third_party_url').hide();
				$('.thankyou_page_list').hide();
			}else if(redirection_type == "third_party_url"){
				$('.trial_offer_list').hide();
				$('.dojocart_list').hide();
				$('.third_party_url').show();
				$('.thankyou_page_list').hide();
			}else if(redirection_type == "thankyou_page"){
				$('.trial_offer_list').hide();
				$('.dojocart_list').hide();
				$('.third_party_url').hide();
				$('.thankyou_page_list').show();
			}else{
				$('.trial_offer_list').show();
				$('.dojocart_list').hide();
				$('.third_party_url').hide();
				$('.thankyou_page_list').hide();
			}
			
		}
	});
	
});
$(document).ready(function(){
	$("#main_title").keyup(function(){
		$("#sef_title").html($(this).val());
	});
	
	$('.redirection_type').click(function(){
		var redirection_type = $(this).val();
	
			if(redirection_type == "dojocart"){
				$('.trial_offer_list').hide();
				$('.dojocart_list').show();
				$('.third_party_url').hide();
				$('.thankyou_page_list').hide();
			}else if(redirection_type == "third_party_url"){
				$('.trial_offer_list').hide();
				$('.dojocart_list').hide();
				$('.third_party_url').show();
				$('.thankyou_page_list').hide();
			}else if(redirection_type == "thankyou_page"){
				$('.trial_offer_list').hide();
				$('.dojocart_list').hide();
				$('.third_party_url').hide();
				$('.thankyou_page_list').show();
			}else{
				$('.trial_offer_list').show();
				$('.dojocart_list').hide();
				$('.third_party_url').hide();
				$('.thankyou_page_list').hide();
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

	$("#delete_img").click(function(){
		$('#img').hide();
		var cat_id=$('#cat_id').val();
		var image_path=$('#img').attr('src');
					
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/programs/deleteImg',						
		data: { cat_id : cat_id,image_path:image_path }					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			$("#last-photo").val('');
			//setTimeout("window.location.href='admin/"+mod_type+"/edit/"+staff_id+"'",1000);
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});

	});

	
	$("#delete_background_img").click(function(){
		$('#img_bg').hide();
		var cat_id=$('#cat_id').val();
		var image_path=$('#img_bg').attr('src');
					
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/programs/deleteCatBackgroundImg',						
		data: { cat_id : cat_id,image_path:image_path }					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			$("#last-background_image").val('');
			//setTimeout("window.location.href='admin/"+mod_type+"/edit/"+staff_id+"'",1000);
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});

	});

	
	
	$("#delete_action_background_img").click(function(){
		$('#img_bg_action').hide();
		var cat_id=$('#cat_id').val();
		var image_path=$('#img_bg_action').attr('src');
					
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/programs/deleteCatActionBackgroundImg',						
		data: { cat_id : cat_id,image_path:image_path }					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			$("#last-action_background_image").val('');
			//setTimeout("window.location.href='admin/"+mod_type+"/edit/"+staff_id+"'",1000);
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});

	});

	
	$(".delete_action_image").click(function(){
		
		var cat_id=$('#cat_id').val();
		var type=$(this).attr('type');
		
		$('#img_bg_action_image_'+type).hide();		
		
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/programs/deleteCatActionImages',						
		data: { cat_id : cat_id, type: type}					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			$("#last-action_image_"+type).val('');
			//setTimeout("window.location.href='admin/"+mod_type+"/edit/"+staff_id+"'",1000);
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});

	});
	
	//img_text_image_2
	
	$(".delete_img_text_image").click(function(){
		
		var cat_id=$('#cat_id').val();
		var type=$(this).attr('type');
		
		$('#img_bg_img_text_image_'+type).hide();		
		
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/programs/deleteCatImgTextImage',						
		data: { cat_id : cat_id, type: type}					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			$("#last-img_text_image_"+type).val('');
			//setTimeout("window.location.href='admin/"+mod_type+"/edit/"+staff_id+"'",1000);
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});

	});
	
		
	$(".form-light-holder .show_override_logo_checkbox").click(function(){
		if($(this).hasClass("check-on")){
			$(this).removeClass("check-on");
			$(this).addClass("check-off");
			$(this).parents(".form-light-holder").children(".show_override_logo_hidden_cb").val("0");
			$('.override_logo_box').hide();
			
		}
		else
		{
			$(this).removeClass("check-off");
			$(this).addClass("check-on");
			$(this).parents(".form-light-holder").children(".show_override_logo_hidden_cb").val("1");
			$('.override_logo_box').show();
			
		}
	
})


	
	
})
</script>
<?php foreach($categories as $prog_cat): ?>

<div class="page-section" id="CategoryBasicSection">

<div class="form-light-holder">
	<a id="published" class="show_override_logo_checkbox <?php if($prog_cat->show_override_logo == 1) echo "check-on"; else echo "check-off";?>" ></a>
	<h1 class="inline">Show Override Logo</h1>
	<input type="hidden" value="<?php if(!empty($prog_cat)){ echo $prog_cat->show_override_logo; } else{ echo 0; }?>" name="show_override_logo" class="show_override_logo_hidden_cb" />
</div>
<div class="form-light-holder override_logo_box">
<h1>Override Logo</h1>
	<select name="override_logo" id="window" class="field">
	<?php foreach($override_logos as  $override_logo):?>
	<option value="<?=$override_logo->s_no?>" <?php if($prog_cat->override_logo == $override_logo->s_no){ echo 'selected=selected';} ?>><?=$override_logo->logo_name?></option>
	<?php endforeach;?>
	</select>
</div>

<div class="form-light-holder  d-md-flex  dual_input">
	<div class="adsUrl form-group">
		<h1>Title</h1>
		<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($prog_cat->cat_name); ?>" name="name" id="name" class="field" placeholder="Enter your name here"/>
		<input type="hidden" value="<?=$prog_cat->cat_id;?>" name="edit_id" id="cat_id" >
	</div>
	<div class="linkTarget form-group">
		<h1>Page Template</h1>
		<select name="page_template" id="" class="field pageTemplate">
			<option value="default" <?php echo ($prog_cat->page_template == "default") ? 'selected=selected' : ''; ?>>Default</option>
			<option value="condensed"  <?php echo ($prog_cat->page_template == "condensed") ? 'selected=selected' : ''; ?>>Program Category Condensed</option>
		</select>
	</div>
		
</div>




<div class="form-light-holder d-md-flex  dual_input">
	<div class="adsUrl form-group">
		<h1>Slug (URL Rewriting)</h1>
		<input type="text" value="<?=$prog_cat->cat_slug;?>" name="slug" id="slug" class="field" placeholder="Enter your slug here"/>
		</br></em>Note: Slug will automatically generate from title if left blank</em>
	</div>
	<div class="default_template linkTarget form-group">
		<h1>Ages</h1>
		<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($prog_cat->ages);?>" name="ages" id="" class="field" placeholder="Enter Ages here"/>
	</div>
</div>



<div class="default_template">
<div class="form-light-holder   d-md-flex  dual_input">
	<div class="adsUrl  form-group">
	
		<h1>Redirection Type</h1>
		<label class="rdiobox">
		<input type="radio" value="trial_offer" class="redirection_type" name="redirection_type" <?php echo ($prog_cat->redirection_type == "trial_offer") ? 'checked=checked' : ''; ?> /><span>Trial Offer</span></label>
		<label class="rdiobox">
		<input type="radio" value="dojocart" class="redirection_type" name="redirection_type" <?php echo ($prog_cat->redirection_type == "dojocart") ? 'checked=checked' : ''; ?> /><span>Dojocart</span></label>
		<label class="rdiobox">
		<input type="radio" value="thankyou_page" class="redirection_type" name="redirection_type" <?php echo ($prog_cat->redirection_type == "thankyou_page") ? 'checked=checked' : ''; ?> /><span>Thank you Page</span></label>
		<label class="rdiobox">
		<input type="radio" value="third_party_url" class="redirection_type" name="redirection_type" <?php echo ($prog_cat->redirection_type == "third_party_url") ? 'checked=checked' : ''; ?> /><span>Third Party Url</span></label>
	</div>
	
	<div class="linkTarget  form-group">
		<div class="trial_offer_list" style="display:none">
			<h1>Trial offer categories</h1>
				<select name="trial_offer_id" class="field" >
				<option value="">-Select-</option>
				<?php foreach($trialCategories as  $trialCategory):?>
				<option value="<?=$trialCategory->id?>" <?php if($prog_cat->trial_offer_id == $trialCategory->id){ echo 'selected=selected';} ?>><?=$trialCategory->name?></option>
				<?php endforeach;?>
				</select>
			</div>
			<div class="dojocart_list" style="display:none">
			<h1>Dojocarts</h1>
				<select name="dojocart_id" class="field">
				<option value="">-Select-</option>
				<?php foreach($dojocarts as  $dojocart):?>
				<option value="<?=$dojocart->id?>" <?php if($prog_cat->dojocart_id == $dojocart->id){ echo 'selected=selected';} ?>><?=$dojocart->product_title?></option>
				<?php endforeach;?>
				</select>
			</div>

			<div class="thankyou_page_list" style="display:none">
			<h1>Thankyou Pages</h1>
				<select name="thankyou_page_id" class="field">
				<option value="">-Select-</option>
				<?php foreach($thankyou_pages as  $thankyou_page):?>
				<option value="<?=$thankyou_page->id?>" <?php if($prog_cat->thankyou_page_id == $thankyou_page->id){ echo 'selected=selected';} ?>><?=$thankyou_page->title?></option>
				<?php endforeach;?>
				</select>
			</div>

			<div class="third_party_url" style="display:none">
			<h1>Third Party Url</h1>
				<input type="text" name="third_party_url" value="<?php echo $this->query_model->getStrReplaceAdmin($prog_cat->third_party_url);?>">
			</div>

	</div>
</div>

</div>
</div>


<div class="page-section" id="Headersection">
<div class="mb-3 main-content-label">Header Section</div>
<div class="form-light-holder">
	<h1>Header</h1>
	<textarea type="text" id="ckeditor_mini_header_title" name="header_title" class="field  full_width_input"><?=$prog_cat->header_title;?></textarea>
</div>

<div class="form-light-holder">
	<h1>Header Description</h1>
	<div class=""><textarea name="header_desc"  id="ckeditor_mini_header_desc" class="text ckeditor shorterCkeditor"><?=$prog_cat->header_desc;?></textarea></div>
</div>
<div class="default_template">
<div class="form-light-holder   d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl  form-group">
	<h1 style="padding-bottom: 5px;">Header Image</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="userfile"   class="custom-file-input" id="customFile1"  accept="image/*"  />
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	
	<?php if(!empty($prog_cat->header_photo)): ?>
	<div><img id='img' src="<?=base_url().'upload/program_category/'.$prog_cat->header_photo;?>" style="width: 100px; clear:both;" /></div>	
	<input type="hidden" id="last-photo" name="last-photo" value="<?=$prog_cat->header_photo;?>" />
	<?php endif;?>
	
	<?php if(!empty($prog_cat->header_photo)){ 
			echo "<a href='javascript:void(0);' id='delete_img' class='delete_image_btn_new' >Delete image</a>";
			}
	?>
	
	</div>
	<div class="linkTarget  form-group">
		<h1 style="">Image alt text</h1>
		<input value="<?php echo $this->query_model->getStrReplaceAdmin($prog_cat->header_photo_alt_text); ?>" name="header_photo_alt_text" id="" class="field" placeholder="image alt text" type="text">
	</div>
		
		<!--<div>
		<h1>Image Top Spacing</h1>

	<input type="text" name="header_photo_top_spacing" id="header_photo_top_spacing" class="field  header_photo_top_spacing" placeholder=""  style="width: 7%" value="<?php echo $this->query_model->getStrReplaceAdmin($prog_cat->header_photo_top_spacing)?>"/> <span style="font-size:15px"><strong>px</strong></span><br/>
	<em>Note: Please use only integer or float value. don't use "px" in input field</em>
	
		</div> -->
</div>
</div>

	
<div class="form-light-holder   d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl  form-group">
	<h1 >Background Image</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="background_image" class="custom-file-input" id="customFile2" accept="image/*" />
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	
	<?php if(!empty($prog_cat->background_image)): ?>
	<div><img id='img_bg' src="<?=base_url().'upload/program_category/'.$prog_cat->background_image;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-background_image" value="<?=$prog_cat->background_image;?>" />
	<?php endif;?>
	
	<?php if(!empty($prog_cat->background_image)){ 
			echo "<a href='javascript:void(0);' id='delete_background_img' class='delete_image_btn_new'  number='".$prog_cat->cat_id."'>Delete image</a>";
			}
	?>	
	</div>
	<div class="linkTarget  form-group">
		<h1> Color Overlay And Opacity  Picker</h1>
		<div id='docs'>
		<div id='docs-content'>
			<input id="full_colorpicker_opacity" name="background_color" class="colourTextValue" value="<?php if(!empty($prog_cat)){ echo $prog_cat->background_color; }?>" />
		</div>
	</div>
</div>

</div>	
</div>	

<div class="page-section" id="WhiteStripeFirstSection">
<div class="mb-3 main-content-label">White Stripe Under Header Section</div>
<div class="form-light-holder">
	<h1>Body Title</h1>
	<textarea type="text" name="body_title" id="ckeditor_mini_body_title" class="field  full_width_input"><?=$prog_cat->body_title;?></textarea>
</div>
<div class="default_template">
<div class="form-light-holder">
	<h1>Body Description</h1>
	<textarea name="body_desc" id="ckeditor_full_body_desc" class="text ckeditor" style="width:50%"><?=$prog_cat->body_desc;?></textarea>
	
</div>
<div class="form-light-holder">
	<div class="adsUrl">
		<h1>Video Type</h1>
		<select name="video_type" id="" class="field videoType" >
		<option value="youtube_video" <?php if($prog_cat->video_type == 'youtube_video'){ echo 'selected=selected'; } ?>>Youtube Video</option>
		<option value="vimeo_video" <?php if($prog_cat->video_type == 'vimeo_video'){ echo 'selected=selected'; } ?>  >Vimeo Video</option>
		</select>
	</div>
	<div class="linkTarget">
		<div class="welcome_video">
			<div class="youtube_video">
			<h1>Youtube Video</h1>
			<input type="text" name="youtube_video" value="<?=$prog_cat->youtube_video;?>" class="field" >
			<div style="font-style:italic;font-size:11px;margin-left:12px;">
				eg. https://www.youtube.com/embed/UWCbfxwwC-I
			</div>
			</div>
			<span class="orButton">OR</span>
			<div class="vimeo_video">
			<h1>Vimeo Video</h1>
			<input type="text" name="vimeo_video" value="<?=$prog_cat->vimeo_video;?>" class="field" >
			<div style="font-style:italic;font-size:11px;margin-left:12px;">
				eg. https://player.vimeo.com/video/17054419
			</div>
			</div>
		</div>
	</div>
	
</div>
</div>
</div>

<div class="default_template">
<div class="page-section" id="Calltoaction3ImagesSection">
<div class="mb-3 main-content-label">Call to Action with 3 Images Section</div>
<div class="form-light-holder">
	<h1>Call to Action Title</h1>
	<input type="text" name="action_title" value="<?php echo $this->query_model->getStrReplaceAdmin($prog_cat->action_title);?>" class="field  full_width_input">
</div>

<div class="form-light-holder">
	<h1>Call to Action description</h1>
	<div class=""><textarea name="action_desc" id="ckeditor_mini_action_desc" class="text ckeditor"><?=$prog_cat->action_desc;?></textarea></div>
</div>

	
<div class="form-light-holder   d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl  form-group">
	<h1>Background Image</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="action_background_image" class="custom-file-input" id="customFile3" accept="image/*" />
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	
	<?php if(!empty($prog_cat->action_background_image)): ?>
	<div><img id='img_bg_action' src="<?=base_url().'upload/program_category/'.$prog_cat->action_background_image;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-action_background_image" value="<?=$prog_cat->action_background_image;?>" />
	<?php endif;?>
	<?php if(!empty($prog_cat->action_background_image)){ 
			echo "<a href='javascript:void(0);' id='delete_action_background_img' class='delete_image_btn_new'  number='".$prog_cat->cat_id."'>Delete image</a>";
			}
	?>	
		
		
	</div>
	<div class="linkTarget  form-group">
		<h1> Color Overlay And Opacity  Picker</h1>
		<div id='docs_action'>
		<div id='docs-content-action'>
			<input id="action_colorpicker_opacity" name="action_background_color" class="colourTextValueAction" value="<?php if(!empty($prog_cat)){ echo $prog_cat->action_background_color; }?>" />
		</div>
		
	 </div>
	</div>
</div>



<div class="form-light-holder">
	<h1>Headline #1</h1>
	<input type="text" name="action_headline_1" value="<?php echo $this->query_model->getStrReplaceAdmin($prog_cat->action_headline_1);?>" class="field  full_width_input">
</div>
<div class="form-light-holder   d-md-flex  dual_input" style="overflow:auto;">
	
	<div class="adsUrl  form-group">
		<h1 style="padding-bottom: 5px;">Image uploader #1</h1>
		<div class="custom-file half_width_custom_file">
			<input type="file" name="action_image_1" class="custom-file-input" id="customFile4" accept="image/*" />
		<label class="custom-file-label" for="customFile">Choose file</label></div>
	
		<?php if(!empty($prog_cat->action_image_1)): ?>
		<div><img id='img_bg_action_image_1' src="<?=base_url().'upload/program_category/'.$prog_cat->action_image_1;?>" style="width: 150px; clear:both;" /></div>
		<input type="hidden" name="last-action_image_1" value="<?=$prog_cat->action_image_1;?>" />
		<?php endif;?>
		
		<?php if(!empty($prog_cat->action_image_1)){ 
				echo "<a href='javascript:void(0);' class='delete_action_image delete_image_btn_new'  id='delete_action_action_image_1'  type='1'  number='".$prog_cat->cat_id."'>Delete image</a>";
				}
		?>
	</div>
	
	<div class="linkTarget  form-group">
		<h1 >Image alt text</h1>
		<input value="<?php echo $this->query_model->getStrReplaceAdmin($prog_cat->action_image_1_alt_text); ?>" name="action_image_1_alt_text" id="" class="field" placeholder="image alt text" type="text">
	</div>
	
</div>


<div class="form-light-holder">
	<h1>Headline #2</h1>
	<input type="text" name="action_headline_2" value="<?php echo $this->query_model->getStrReplaceAdmin($prog_cat->action_headline_2);?>" class="field  full_width_input">
</div>
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl  form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #2</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="action_image_2" class="custom-file-input" id="customFile5" accept="image/*" />
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	<?php if(!empty($prog_cat->action_image_2)): ?>
	<div><img id='img_bg_action_image_2' src="<?=base_url().'upload/program_category/'.$prog_cat->action_image_2;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-action_image_2" value="<?=$prog_cat->action_image_2;?>" />
	<?php endif;?>
	
	<?php if(!empty($prog_cat->action_image_2)){ 
			echo "<a href='javascript:void(0);' class='delete_action_image delete_image_btn_new'  id='delete_action_action_image_2' type='2' number='".$prog_cat->cat_id."'>Delete image</a>";
			}
	?>	
	</div>
	
	<div class="linkTarget  form-group">
		<h1 >Image alt text</h1>
		<input value="<?php echo $this->query_model->getStrReplaceAdmin($prog_cat->action_image_2_alt_text); ?>" name="action_image_2_alt_text" id="" class="field" placeholder="image alt text" type="text">
		</div>
</div>

<div class="form-light-holder">
	<h1>Headline #3</h1>
	<input type="text" name="action_headline_3" value="<?php echo $this->query_model->getStrReplaceAdmin($prog_cat->action_headline_3);?>" class="field  full_width_input">
</div>
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl  form-group">
		<h1 style="padding-bottom: 5px;">Image uploader #3</h1>
		<div class="custom-file half_width_custom_file">
		<input type="file" name="action_image_3" class="custom-file-input" id="customFile6" accept="image/*" />
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	
		<?php if(!empty($prog_cat->action_image_3)): ?>
		<div><img id='img_bg_action_image_3' src="<?=base_url().'upload/program_category/'.$prog_cat->action_image_3;?>" style="width: 150px; clear:both;" /></div>
		<input type="hidden" name="last-action_image_3" value="<?=$prog_cat->action_image_3;?>" />
		<?php endif;?>
		
		<?php if(!empty($prog_cat->action_image_3)){ 
				echo "<a href='javascript:void(0);' class='delete_action_image delete_image_btn_new' id='delete_action_action_image_3' type='3' number='".$prog_cat->cat_id."'>Delete image</a>";
				}
		?>	
	</div>
	
	<div class="linkTarget  form-group">
		<h1 >Image alt text</h1>
		<input value="<?php echo $this->query_model->getStrReplaceAdmin($prog_cat->action_image_3_alt_text); ?>" name="action_image_3_alt_text" id="" class="field" placeholder="image alt text" type="text">
		</div>
</div>
</div>
</div>


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

<div class="default_template">
<div class="page-section" id="Images3WithTextSection">
<div class="mb-3 main-content-label">3 images + Text Section</div>


<div class="form-light-holder">
	<h1>Headline</h1>
	
	<textarea name="img_text_headline" id="img_text_headline" class="text ckeditor"><?=$prog_cat->img_text_headline;?></textarea>
</div>

<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl  form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #1</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="img_text_image_1" class="custom-file-input" id="customFile7" accept="image/*" />
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	
	<?php if(!empty($prog_cat->img_text_image_1)): ?>
	<div><img id='img_bg_img_text_image_1' src="<?=base_url().'upload/program_category/'.$prog_cat->img_text_image_1;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-img_text_image_1" value="<?=$prog_cat->img_text_image_1;?>" />
	<?php endif;?>
	<?php if(!empty($prog_cat->img_text_image_1)){ 
			echo "<a href='javascript:void(0);' class='delete_img_text_image delete_image_btn_new'  id='delete_img_text_image_1'  type='1'  number='".$prog_cat->cat_id."'>Delete image</a>";
			}
	?>	
	</div>
	
	<div class="linkTarget  form-group">
		<h1 >Image alt text</h1>
		<input value="<?php echo $this->query_model->getStrReplaceAdmin($prog_cat->img_text_image_1_alt_text); ?>" name="img_text_image_1_alt_text" id="" class="field" placeholder="image alt text" type="text">
		</div>
</div>
<div class="form-light-holder">
	<h1>Title #1</h1>
	<input type="text" name="img_text_title_1" value="<?php echo $this->query_model->getStrReplaceAdmin($prog_cat->img_text_title_1);?>" class="field  full_width_input">
</div>


<div class="form-light-holder">
	<h1>Description #1</h1>
	<input type="text" name="img_text_desc_1" value="<?php echo $this->query_model->getStrReplaceAdmin($prog_cat->img_text_desc_1);?>" class="field  full_width_input">
</div>



<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	
	<div class="adsUrl  form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #2</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="img_text_image_2" class="custom-file-input" id="customFile8" accept="image/*" />
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	
	<?php if(!empty($prog_cat->img_text_image_2)): ?>
	<div><img id='img_bg_img_text_image_2' src="<?=base_url().'upload/program_category/'.$prog_cat->img_text_image_2;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-img_text_image_2" value="<?=$prog_cat->img_text_image_2;?>" />
	<?php endif;?>
	
	<?php if(!empty($prog_cat->img_text_image_2)){ 
			echo "<a href='javascript:void(0);' class='delete_img_text_image delete_image_btn_new'  id='delete_img_text_image_2'  type='2'  number='".$prog_cat->cat_id."'>Delete image</a>";
			}
	?>	
	</div>
	
	<div class="linkTarget  form-group">
		<h1>Image alt text</h1>
		<input value="<?php echo $this->query_model->getStrReplaceAdmin($prog_cat->img_text_image_2_alt_text); ?>" name="img_text_image_2_alt_text" id="" class="field" placeholder="image alt text" type="text">
		</div>
</div>
<div class="form-light-holder">
	<h1>Title #2</h1>
	<input type="text" name="img_text_title_2" value="<?php echo $this->query_model->getStrReplaceAdmin($prog_cat->img_text_title_2);?>" class="field  full_width_input">
</div>


<div class="form-light-holder">
	<h1>Description #2</h1>
	<input type="text" name="img_text_desc_2" value="<?php echo $this->query_model->getStrReplaceAdmin($prog_cat->img_text_desc_2);?>" class="field  full_width_input">
</div>




<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl  form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #3</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="img_text_image_3" class="custom-file-input" id="customFile9" accept="image/*" />
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	
	<?php if(!empty($prog_cat->img_text_image_3)): ?>
	<div><img id='img_bg_img_text_image_3' src="<?=base_url().'upload/program_category/'.$prog_cat->img_text_image_3;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-img_text_image_3" value="<?=$prog_cat->img_text_image_3;?>" />
	<?php endif;?>
	
	<?php if(!empty($prog_cat->img_text_image_3)){ 
			echo "<a href='javascript:void(0);' class='delete_img_text_image delete_image_btn_new'  id='delete_img_text_image_3'  type='3'  number='".$prog_cat->cat_id."'>Delete image</a>";
			}
	?>	
	</div>
	
	<div class="linkTarget  form-group">
		<h1 style="">Image alt text</h1>
		<input value="<?php echo $this->query_model->getStrReplaceAdmin($prog_cat->img_text_image_3_alt_text); ?>" name="img_text_image_3_alt_text" id="" class="field" placeholder="image alt text" type="text">
		</div>
</div>

<div class="form-light-holder">
	<h1>Title #3</h1>
	<input type="text" name="img_text_title_3" value="<?php echo $this->query_model->getStrReplaceAdmin($prog_cat->img_text_title_3);?>" class="field  full_width_input">
</div>


<div class="form-light-holder">
	<h1>Description #3</h1>
	<input type="text" name="img_text_desc_3" value="<?php echo $this->query_model->getStrReplaceAdmin($prog_cat->img_text_desc_3);?>" class="field  full_width_input">
</div>
</div>
</div>

<div class="default_template">
<div class="page-section" id="EmailOptin">
<div class="mb-3 main-content-label">Email Opt-in #1</div>

<div class="form-light-holder">

	<h1>Opt-In Title</h1>
	
	
	<textarea type="text" id="ckeditor_mini_opt1_title" name="opt1_title" class="field ckeditor  full_width_input"><?php echo (!empty($prog_cat) && !empty($prog_cat->opt1_title)) ? $prog_cat->opt1_title : ''; ?></textarea>
</div>

<div class="form-light-holder">

	<h1>Opt-In Text</h1>
	<input type="text" value="<?php echo (!empty($prog_cat) && !empty($prog_cat->opt1_text)) ? $prog_cat->opt1_text : ''; ?>" name="opt1_text" id="" class="field full_width_input" placeholder=""  style=""/>
</div>

<div class="form-light-holder">

	<h1>Submit Button Text</h1>
	<input type="text" value="<?php echo (!empty($prog_cat) && !empty($prog_cat->opt1_submit_btn_text)) ? $prog_cat->opt1_submit_btn_text : ''; ?>" name="opt1_submit_btn_text" id="" class="field full_width_input" placeholder=""  style=""/>
</div>

<div class="form-light-holder">
	<a id="published" class="checkbox1 <?php echo (!empty($prog_cat) && $prog_cat->show_full_form_1 == 1) ? 'check-on' : 'check-off'; ?>"></a>

	<h1 class="inline">Show Full Form </h1>

	<input type="hidden" value="<?php echo (!empty($prog_cat) && $prog_cat->show_full_form_1 == 1) ? 1 : 0; ?>" name="show_full_form_1" class="hidden_cb1" />

</div>




<script language="javascript">

$(document).ready(function(){

$(".form2checkbox .checkbox2").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form2checkbox").children(".hidden_cb2").val("0");

		
	}

	else

	{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form2checkbox").children(".hidden_cb2").val("1");
	}

})

})

</script>
<br/>
<div class="mb-3 main-content-label">Email Opt-in #2</div>

<div class="form-light-holder">

	<h1>Opt-In Title</h1>
	<input type="text" value="<?php echo (!empty($prog_cat) && !empty($prog_cat->opt_2_title)) ? $prog_cat->opt_2_title : ''; ?>" name="opt_2_title" id="" class="field full_width_input" placeholder=""  style=""/>
</div>

<div class="form-light-holder">

	<h1>Opt-In Text</h1>
	<input type="text" value="<?php echo (!empty($prog_cat) && !empty($prog_cat->opt_2_text)) ? $prog_cat->opt_2_text : ''; ?>" name="opt_2_text" id="" class="field full_width_input" placeholder=""  style=""/>
</div>

<div class="form-light-holder form2checkbox">

	<a id="published" class="checkbox2 <?php echo (!empty($prog_cat) && $prog_cat->show_full_form_2 == 1) ? 'check-on' : 'check-off'; ?>"></a>

	<h1 class="inline">Show Full Form </h1>

	<input type="hidden" value="<?php echo (!empty($prog_cat) && $prog_cat->show_full_form_2 == 1) ? 1 : 0; ?>" name="show_full_form_2" class="hidden_cb2" />

</div>
</div>
</div>


<div class="page-section" id="IconRows">
<div class="condensed_template">
<div class="mb-3 main-content-label">Icon Rows</div>
<div class="form-light-holder">
	<h1>Icon Row #1</h1>
	<input type="text" name="icon_row_1" value="<?php echo $this->query_model->getStrReplaceAdmin($prog_cat->icon_row_1);?>" class="field  full_width_input">
</div>

<div class="form-light-holder">
	<h1>Icon Row #2</h1>
	<input type="text" name="icon_row_2" value="<?php echo $this->query_model->getStrReplaceAdmin($prog_cat->icon_row_2);?>" class="field  full_width_input">
</div>

<div class="form-light-holder">
	<h1>Icon Row #3</h1>
	<input type="text" name="icon_row_3" value="<?php echo $this->query_model->getStrReplaceAdmin($prog_cat->icon_row_3);?>" class="field  full_width_input">
</div>
</div>
</div>


<h1>&nbsp;</h1>
<div style="display:none">
<div class="form-light-holder">
	<h1>Online Trial Title</h1>
	<input type="text" name="trial_title" value="<?=$prog_cat->trial_title;?>" class="field  full_width_input">
</div>

<div class="form-light-holder">
	<h1>Online Trial description</h1>
	<div class="shorterCkeditor"><textarea name="trial_desc" id="ckeditor_mini_trial_desc" class="text ckeditor"><?=$prog_cat->trial_desc;?></textarea></div>
</div>

<!-- 05/12 -->
<div class="form-light-holder">
    	<h1>Mini-form Offer Title</h1>
       <input type="text" class="half_field" name="mini_form_offer_title" value="<?= $prog_cat->mini_form_offer_title ?>"  />&nbsp;
</div>
<div class="form-light-holder">
    	<h1>Mini-form Offer Description</h1>
       <input type="text" class="half_field" name="mini_form_offer_desc" value="<?= $prog_cat->mini_form_offer_desc ?>" />&nbsp;
</div>

<div class="form-light-holder">
    	<h1>Mini-form Button 1 Text</h1>
       <input type="text" class="half_field" name="mini_form_button1_text" value="<?= $prog_cat->mini_form_button1_text ?>" />&nbsp;
</div>

<div class="form-light-holder">
    	<h1>Mini-form Buton 2 Text</h1>
       <input type="text" class="half_field" name="mini_form_button2_text" value="<?= $prog_cat->mini_form_button2_text ?>" />&nbsp;
</div>
</div>
<div class="page-section" id="SeoMeta">
<div class="mb-3 main-content-label">Seo/Meta Details</div>
<div class="form-light-holder">
	<h1>Meta Title</h1>
	<input type="text" name="meta_title" value="<?=$prog_cat->meta_title ?>" class="field">
</div>

<div class="form-light-holder" style="">
	<h1>Meta Description</h1>
	<textarea name="meta_desc" class="ckeditor" id="frm-text"><?=$prog_cat->meta_desc?></textarea>
</div>

<div class="form-light-holder  <?= $display_class ?>">
	<h1>Body Id</h1>
	<input type="text" name="body_id" value="<?=$prog_cat->body_id;?>" class="field">
</div>

<div class="form-light-holder">
	<a id="published" class="checkbox <?php if($prog_cat->published==1) echo "check-on"; else echo "check-off";?>"></a>
	<h1 class="inline">Publish This</h1>
	<input type="hidden" value="<?=$prog_cat->published?>" name="published" class="hidden_cb" />
</div>


<div class="form-light-holder hide_from_navigation">
	<a id="published" class="hide_from_navigation_checkbox <?php if($prog_cat->hide_from_navigation==1) echo "check-on"; else echo "check-off";?>"></a>
	<h1 class="inline">Hide from Navigation</h1>
	<input type="hidden" value="<?=$prog_cat->hide_from_navigation?>" name="hide_from_navigation" class="hide_from_navigation_hidden_cb" />
</div>
</div>


<?php endforeach; ?>


<input type="hidden" name="mod_type" value="<?=$link_type;?>" id="mod_type" />
				
<div class="program_full_detail page-section new_lisiting_block default_template" id="AlternatingFullWidth">
				<div class="mb-3 main-content-label" >Alternating Full Width Rows</div>
				<div class="row row-xs align-items-center  mg-t-25 mg-b-5">
					<div class="col-md-12">
						<p>You may rearrange the order of the items below by dragging them above or below other item rows. Changes will automatically be saved.</p>
					</div>
					
				</div>
				
				<div class="row row-xs align-items-center mg-b-20  alternating-row-section ">
					
					<div class="col-md-12 mg-t-5 mg-md-t-0 ">
						<div class="az-content-body ">
			
							<div class="az-mail-header">
								<div>
								  <h4 class="az-content-title mg-b-5">Alternating Full Width Rows</h4>
								  <p>You have <span class="total_alternating_full_width_row"><?php echo !empty($programCatRows) ? count($programCatRows) : 0; ?></span> Entries</p>
								</div>
								<div>
								 <a href="javascript:void(0)" class="button_class btn btn-indigo  full_alternate_popup" data-toggle="modal" data-target="#fullAlternatePopup" action_type="add" item_id="" table_name="tbl_program_cat_rows" form_type="full_width_row">Add Full Width Row</a>
								</div>
							  </div>
							  
							<ul class="cat_sort_1 ui-sortable alternating_full_width_row" style="">

<?php
$sr_testimonials=0; 


				
if(!empty($programCatRows)):?>
<?php foreach($programCatRows as $about_us_row):
 $sr_testimonials++;
?>


									<li   id="menu_<?=$about_us_row->id?>" class="full_width_row_<?=$about_us_row->id?> az-contact-info-header">
										<div class="manager-item media">
											<div style="float:left;">
												<div class="badge-no"><?=$sr_testimonials?>. </div>
												
                                                    
												<h4 class="full_width_row_heading_<?=$about_us_row->id?>"><a href="javascript:void(0)" ><?=$about_us_row->title;?>   ( <?php echo ucfirst($about_us_row->photo_side);?> )</a></h4>
											</div>
											<div class="manager-item-opts">
											
											
										<nav class="nav">
											 
											  <a href="javascript:void(0)" class="badge badge-primary  full_alternate_popup" data-toggle="modal" data-target="#fullAlternatePopup" action_type="edit" item_id="<?=$about_us_row->id;?>"  table_name="tbl_program_cat_rows" form_type="full_width_row">Edit</a>
											  
													<a class="badge badge-primary delete_item" data-toggle="modal" data-target="#popupDeleteItem" item_id="<?=$about_us_row->id;?>"   table_name="tbl_program_cat_rows" item_title="<?=$about_us_row->title;?>" section_type="full_width">Delete</a>
													<!--<div class="az-toggle az-toggle-success alternate_full_width_toogle on"><span></span></div> -->
													
													<a href="javascript:void(0)" id="unpub_<?=$about_us_row->id; ?>" class="sections_unpublish"  table_name="tbl_program_cat_rows"  is_new="0">
												<div class="az-toggle az-toggle-success alternate_full_width_toogle toogle_btn <?php echo ($about_us_row->published == 1) ? 'on' : '';?>" publish_type="<?php echo ($about_us_row->published == 1) ? 0 : 1;?>"><span></span>
												<input type="hidden" name="publish_type" value="<?php echo ($about_us_row->published == 1) ? 0 : 1;?>" class="publish_type" />
												</div></a>
										</nav>
			
			
			
											</div>
										</div>
									</li>
<?php endforeach;?>								

<?php else: ?>

<?php endif;?>
								</ul>

			
			
						
						
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
	
			<div class="tx-center pd-y-20 bg-gray-200" id="bottom"> 
				
				<input type="submit" name="update" value="Save" class=" save_program_form btn btn-az-primary saveProgramButton" />
				</div>
				</form>
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

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js" type="text/javascript"></script>
<script src="color_overlay_opacity_pickier/js/spectrum.js" type="text/javascript"></script>
	<script src="color_overlay_opacity_pickier/js/toc.js" type="text/javascript"></script>
	<script src="color_overlay_opacity_pickier/js/docs.js" type="text/javascript"></script>
	<script src="color_overlay_opacity_pickier/js/prettify.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="color_overlay_opacity_pickier/css/spectrum.css">
	

<script type="text/javascript">

/*
	jQuery Document ready
*/
$(document).ready(function()
{


$("#full_colorpicker_opacity").spectrum({
   color: '<?php if(!empty($pagedetails)){ echo $pagedetails[0]->background_color; }?>',
   
});

$("#action_colorpicker_opacity").spectrum({
   color: '<?php if(!empty($pagedetails)){ echo $pagedetails[0]->action_background_color; }?>',
   
});

$('.btn-save').click(function(){
	var bg_color = $('#docs').find('.sp-preview-inner').css("background-color");
	var bg_color_action = $('#docs_action').find('.sp-preview-inner').css("background-color");
	
	
	$('.colourTextValue').val(bg_color);
	$('.colourTextValueAction').val(bg_color_action);
});
	
	
});
</script>

<script language="javascript">
$(document).ready(function(){


var mod_type1 = $("#mod_type").val().toLowerCase();
try{
$(".cat_sort_1").sortable({
update : function () {
serial = $('.cat_sort_1').sortable('serialize');
sort_list_li = $(this).find('li');
$.ajax({
url: "admin/"+mod_type1+"/sortProgramCatRows/<?=$prog_cat->cat_id?>",
type: "post",
data: serial,
success: function(){
	$.each(sort_list_li,function(key, value){
		$(this).find('.badge-no').html(parseInt(key)+1+'.');
	});
}
});
}
});
} catch(e) {  }


try{
$(".cat_sort_4").sortable({
update : function () {
serial = $('.cat_sort_4').sortable('serialize');
sort_list_li = $(this).find('li');
$.ajax({
url: "admin/"+mod_type1+"/sortProgramCatSections/<?=$prog_cat->cat_id?>",
type: "post",
data: serial,
success: function(){
	$.each(sort_list_li,function(key, value){
		$(this).find('.badge-no').html(parseInt(key)+1+'.');
	});
}
});
}
});
} catch(e) {  }

$("body").on('click','.sections_unpublish',function(){
	//alert('adsfdasf');
	var pub_id = $(this).attr("id").substr(6);
	var mod_type = $("#mod_type").val().toLowerCase();
	var table_name = $(this).attr('table_name');
	var is_new = $(this).attr('is_new');
	var publish_type = $(this).children(".toogle_btn").attr('publish_type');
	//alert(pub_id+'=>'+mod_type+'=>'+table_name+'=>'+is_new+'=>'+publish_type); return false;
	var updated_type = 1;
	if(publish_type == 1){
		updated_type = 0;
	}
	
	
	if(is_new == 1){
		if(updated_type == 1){
			$(this).find('.az-toggle').removeClass('on');
		}else{
			$(this).find('.az-toggle').addClass('on');
		}
	}
	
	$(this).children(".toogle_btn").attr('publish_type',updated_type); 
	
	$.ajax({ 					
	type: 'POST',						
	url: 'admin/'+mod_type+'/publishProgramRows',						
	data: { pub_id : pub_id, publish_type: publish_type,table_name: table_name }					
	}).done(function(msg){ 
	if(msg == 1){
		
	}
	else{
	//setTimeout('$("#alert-holder").html("<div><b class=red>Unable to Unpublish.</b></div>")',1000);
	//alert(msg);
	}
	});
	
});


$('.az-toggle').on('click', function(){
		 $(this).toggleClass('on');
	})



/********************** new code for popup *********************/
$('body').on('click','.delete_item', function(){
		var item_id = $(this).attr('item_id');
		var table_name = $(this).attr('table_name');
		var item_title = $(this).attr('item_title');
		var section_type = $(this).attr('section_type');
		
		$('#popupDeleteItem').find('.modal-title').html(item_title);
		$('#popupDeleteItem').find('#delete_item_id').val(item_id);
		$('#popupDeleteItem').find('#delete_item_table_name').val(table_name);
		$('#popupDeleteItem').find('#delete_item_section_type').val(section_type);
	})
	
	
 	$('body').on('click','.popup_delete_btn', function(){
		
		
		var formData = $('#popupDeleteItem').find('form').serialize();
		var form_action = $('#popupDeleteItem').find('form').attr('action');
		var item_id = $('#popupDeleteItem').find('#delete_item_id').val();
		var section_type = $('#popupDeleteItem').find('#delete_item_section_type').val();
		//alert('.'+section_type+'_'+item_id); return false;
		
		
		$.ajax({ 					
			type: 'POST',						
			url: form_action,						
			data: { formData : formData}					
			}).done(function(msg){ 
			if(msg == 1){
				
				var form_type = 'full_width_row';
				if(section_type == "little_row"){
					var form_type = "little_row";
				}
				
				var total_record = $('.total_alternating_'+form_type).html();
				
				total_record = parseInt(total_record) - 1; 
				$('.total_alternating_'+form_type).html(total_record);
				
				
				
				$('.'+form_type+'_'+item_id).remove();
				$('#popupDeleteItem').modal('hide');
				
				$('#responsePopup').modal('show');
				$('#responsePopup').find('.action_response_msg').html('Successfully deleted!');
				setTimeout(function() {$('#responsePopup').modal('hide');}, 3000);
				
				
				
			}
			else{
				alert("Oops! Something went wrong!");
				return false;
						
			}
		});
			
	})
	
	
	$('body').on('click','.full_alternate_popup', function(){
		
		var action_type = $(this).attr('action_type');
		var item_id = $(this).attr('item_id');
		var table_name = $(this).attr('table_name');
		var form_type = $(this).attr('form_type');
		//fullAlternatePopup
		
		if(form_type == "full_width_row"){
			$('#fullAlternatePopup').find('.modal-title').html(action_type + ': Alternating Full Width Row');
		}else{
			$('#fullAlternatePopup').find('.modal-title').html(action_type + ': Alternating Little Row');
		}
		
		
		
		$.ajax({

				url : 'admin/programs/ajax_program_cat_rows_popup',
				type : 'POST',
				data :{action_type : action_type, item_id : item_id,table_name:table_name,form_type:form_type},
				success:function(data){
					$('#form_alternate_popup').html(data);
					
					var full_desc = $('.ckfull_desc_editor1').html();
					CKEDITOR.instances['ckeditor_full_desc_editor1'].setData(full_desc);
					
					if(form_type == "little_row"){
						var littlerow_title = $('.ckfull_littlerow_title').html();
						CKEDITOR.instances['ckeditor_littlerow_title'].setData(littlerow_title);
					}
				}

		});
		
		
			
	})
	
	$('body').on('keyup','.required_field', function(){
		var check = $(this).val();
		if(check == '') {
			$(this).css('border','1px solid red');
		}else{
			$(this).css('border','1px solid rgb(223,223,223)');
		}
	});
	
	$('body').on('change','.required_field', function(){
		var check = $(this).val();
		if(check == '') {
			$(this).css('border','1px solid red');
		}else{
			$(this).css('border','1px solid rgb(223,223,223)');
		}
	});
	
	$('body').on('click','.save_full_row_add_btn', function(){
		
		var full_desc = CKEDITOR.instances['ckeditor_full_desc_editor1'].getData();
		var alt_row_form_type = $("#alt_row_form_type").val();
		var littlerow_title = "";
		if(alt_row_form_type == "little_row"){
			littlerow_title = CKEDITOR.instances['ckeditor_littlerow_title'].getData();
		}
		
		$('.form_error_msg').hide();
		var error = 0;
		$.each($('.required_field'),function(){
			var check = $(this).val();
			if(check == '') {
				$(this).css('border','1px solid red');
				error = 1;
			}
		})
		
		if(error == 0){
			
			var formData = $('#fullAlternateAddForm').serialize();
			
			$.ajax({ 					
				type: 'POST',						
				url : 'admin/programs/ajax_save_category_full_alternate_row',
				dataType : 'json',
				data: { formData : formData,littlerow_title:littlerow_title,full_desc:full_desc}					
				}).done(function(data){ 
				
				if(data.res == 1){
					
					if(data.form_action == "add"){
						
						var form_type = data.form_type;
						var total_numbers = $('.alternating_'+form_type+' li').length;
						var new_number = 1;
						if(new_number > 0){
							new_number = parseInt(total_numbers) + 1;
						}
						
						var total_record = $('.total_alternating_'+form_type).html();
						total_record = parseInt(total_record) + 1; 
						$('.total_alternating_'+form_type).html(total_record);
						
						$('.alternating_'+form_type).append('<li id="menu_'+data.id+'" class="'+form_type+'_'+data.id+'   az-contact-info-header ui-sortable-handle "><div class="manager-item media"><div style="float:left;"><div class="badge-no">'+new_number+'.</div><h4 class="'+form_type+'_heading_'+data.id+'"><a href="javascript:void(0)">'+data.title+' ( '+data.photo_side+' )</a></h4></div><div class="manager-item-opts"><nav class="nav"><a href="javascript:void(0)" class="badge badge-primary  full_alternate_popup" data-toggle="modal" data-target="#fullAlternatePopup" action_type="edit" item_id="'+data.id+'" table_name="'+data.table_name+'" form_type="'+form_type+'">Edit</a><a class="badge badge-primary delete_item" data-toggle="modal" data-target="#popupDeleteItem" item_id="'+data.id+'" table_name="'+data.table_name+'" item_title="'+data.title+'" section_type="'+form_type+'">Delete</a><a href="javascript:void(0)" id="unpub_'+data.id+'" class="sections_unpublish" table_name="'+data.table_name+'" is_new="1"><div class="az-toggle az-toggle-success alternate_full_width_toogle toogle_btn on" publish_type="0"><span></span><input type="hidden" name="publish_type" value="0" class="publish_type"></div></a></nav></div></div></li>');
						
						$('#fullAlternatePopup').modal('hide');
						
						$('#responsePopup').find('.action_response_msg').html('Successfully added!');
					}else{
						var item_id = data.id;
						var form_type = data.form_type;
						//alert('.'+form_type+'_heading_'+item_id); return false;
						$('.'+form_type+'_heading_'+item_id).find('a').html(data.title+' ( '+data.photo_side + ' )' );
						
						$('#fullAlternatePopup').modal('hide');
						
						$('#responsePopup').find('.action_response_msg').html('Successfully updated!');
					
					}
					
					$('#responsePopup').modal('show');
					setTimeout(function() {$('#responsePopup').modal('hide');}, 3000);
					
				}
			});
			
		}else{
			$('.form_error_msg').show();
		}
		
			
	})
	
	

})
</script>


<script>
$(window).load(function(){
	var template = $('.pageTemplate').val();
		
	if(template == "condensed"){
		$('.default_template').hide();
		$('.condensed_template').show();
	}else{
		$('.default_template').show();
		$('.condensed_template').hide();
	}
})
	$('.pageTemplate').change(function(){
		var template = $(this).val();
		
		if(template == "condensed"){
			$('.default_template').hide();
			$('.condensed_template').show();
		}else{
			$('.default_template').show();
			$('.condensed_template').hide();
		}
	})
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
	
	$('.az-contact-item').on('click touch', function() {
		var selected_href = $(this).attr('href');
		setTimeout(function() {
			
			$.each($('.az-contact-item'), function(){
				//alert(selected_href+'==>'+$(this).attr('href'));
				if($(this).attr('href') == selected_href){
					$(this).addClass('selected');
				}else{
					$(this).removeClass('selected');
				}
			})
		}, 1000);
	});
	
	$('body').on('click','.az-toggle', function(){
	  $(this).toggleClass('on');
	})
	
	
	$('.modal-effect').on('click', function(e){
	  e.preventDefault();
	  var effect = $(this).attr('data-effect');
	  $('#modaldemo8').addClass(effect);
	});
	
</script>


<div id="modaldemo8" class="modal">
      <div class="modal-dialog modal-dialog-centered sortable-box" role="document">
        <div class="modal-content modal-content-demo">
          <div class="modal-header">
            <h6 class="modal-title">Manage Program Category Position</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <ul id="sortable" class="cat_sort_4 ui-sortable">	
<?php
$sr_testimonials=0; 

$sectionArr = array('white_stripe_section'=>'White Stripe Under Header Section','full_width_row_section'=>'Full Width Rows Section','call_to_action_section'=>'Call to Action with 3 Images Section','images_text_section'=>'3 images + Text Section','program_listing_section'=>'Porgrams Listing');
			
if(!empty($programSections)):?>
<?php foreach($programSections as $about_us_row):
 $sr_testimonials++;
?>		
				<li class="ui-state-default"  id="menu_<?=$about_us_row->id?>"><div class="badge-no"><?=$sr_testimonials?></div><h6><?=$sectionArr[$about_us_row->section];?></h6> 
				
				
				<a href="javascript:void(0)" id="unpub_<?=$about_us_row->id; ?>" class="sections_unpublish"  table_name="tbl_program_cat_sections" is_new="0">
				<div class="az-toggle az-toggle-success program_section_toogle toogle_btn <?php echo ($about_us_row->published == 1) ? 'on' : '';?>" publish_type="<?php echo ($about_us_row->published == 1) ? 0 : 1;?>"><span></span>
				<input type="hidden" name="publish_type" value="<?php echo ($about_us_row->published == 1) ? 0 : 1;?>" class="publish_type" />
				</div></a>
				
				
				</li>
				
<?php endforeach;?>								
<input type="hidden" name="mod_type" value="<?=$link_type;?>" id="mod_type" />
<?php else: ?>
<?php endif;?>
			</ul>
          </div>
          <div class="modal-footer">
            <a href="admin/<?=$link_type?>/default_program_cat_sections/<?=$prog_cat->cat_id?>" class="btn btn-outline-light" >Default Re-Arrange</a>
          </div>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->
	
	
	
 <div id="popupDeleteItem" class="modal">
      <div class="modal-dialog modal-dialog-centered sortable-box" role="document">
        <div class="modal-content modal-content-demo">
          <div class="modal-header">
            <h6 class="modal-title"></h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
		  <form action="admin/<?=$link_type;?>/delete_program_row" method="post" id="deleteForm">
          <div class="modal-body edit-form">
            <div class="row row-xs align-items-center delete_popup_text_block">
					<div class="col-md-12 mg-t-5 mg-md-t-0 text-center">
						<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
						<h2 class="heading">Are you sure?</h2>
						<h5 class="subheading">You will not be able to recover the deleted record.</h5>
					</div>
				</div>
				<input type="hidden" name="delete-item-id" id="delete_item_id" value="">
				<input type="hidden" name="table_name" id="delete_item_table_name" value="">
				<input type="hidden"  id="delete_item_section_type" value="">
          </div>
          <div class="modal-footer">
			  <div class="col-md-6 text-left">
				<a href="javascript:void(0)" class="btn btn-indigo popup_cancel_btn" data-dismiss="modal">No, cancel please !</a>
			  </div>
			   <div class="col-md-6 text-right">
				<a href="javascript:void(0)" class="btn btn-indigo popup_delete_btn">Yes, Delete It !</a>
			   </div>
          </div>
		  </form>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->
	
	
	<div id="fullAlternatePopup" class="modal">
      <div class="modal-dialog modal-dialog-centered sortable-box" role="document">
        <div class="modal-content modal-content-demo">
          <div class="modal-header">
            <h6 class="modal-title"></h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
		  <form id="fullAlternateAddForm" action="" method="post" enctype="multipart/form-data">
		  <div id="form_alternate_popup"></div>
		  
		  <input type="hidden" name="cat_id" value="<?php echo $this->uri->segment(4) ?>" class="" />
		  </form>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->
	
	
