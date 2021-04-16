<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
<link rel="stylesheet" href="/resources/demos/style.css" />
<!--<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>-->
<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>
--><script src="https://code.jquery.com/jquery-1.8.2.js"></script>
<script src="https://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
<script src="js/ckeditor_full/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		 CKEDITOR.replace(  'ckeditor_mini_header_title', 
									{ customConfig : 'config.js' }
							);
							
		 CKEDITOR.replace(  'ckeditor_mini_header_desc', 
									{ customConfig : 'config.js' }
							);
		
		CKEDITOR.replace(  'img_text_headline',
									{  customConfig : 'config.js' }
						);
						
		CKEDITOR.replace(  'ckeditor_full_body_desc',
									{  customConfig : 'config.js' }
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

	$(document).ready(function(){
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
	})
</script>
<style>

.label-text{padding-top:35px;font-size:18px;color:#a438ff;padding-bottom: 5px;}	
</style>

<?php 
	$display_class = '';
	if($user_level != 1){
		$display_class = 'display_class';
	}

?>

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
			
          </div><!-- az-contacts-list -->

        </div> <!-- az-content-left -->
        <div class="az-content-body az-content-body-contacts">
			
				<div class="az-mail-header">
            <div>
              <h4 class="az-content-title mg-b-5">ADD CATEGORY</h4>
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

<div class="page-section" id="CategoryBasicSection">

<div class="form-light-holder">
	<a id="published" class="show_override_logo_checkbox check-off" ></a>
	<h1 class="inline">Show Override Logo</h1>
	<input type="hidden" value="0" name="show_override_logo" class="show_override_logo_hidden_cb" />
</div>

<div class="form-light-holder override_logo_box">
<h1>Override Logo</h1>
	<select name="override_logo" id="window" class="field">
	<?php foreach($override_logos as  $override_logo):?>
	<option value="<?=$override_logo->s_no?>"><?=$override_logo->logo_name?></option>
	<?php endforeach;?>
	</select>
</div>

<div class="form-light-holder  d-md-flex  dual_input">
	<div class="adsUrl form-group">
		<h1>Title</h1>
		<input type="text" value="" name="name" id="name" class="field" placeholder="Enter your name here"/>
	</div>
	<div class="linkTarget form-group">
		<h1>Page Template</h1>
			<select name="page_template" id="" class="field pageTemplate">
				<option value="default" selected="selected">Default</option>
				<option value="condensed">Program Category Condensed</option>
			</select>
	</div>
</div>

<div class="form-light-holder  d-md-flex  dual_input">
<div class="adsUrl form-group">
	<h1>Slug (URL Rewriting)</h1>
	<input type="text" value="" name="slug" id="slug" class="field" placeholder="Enter your slug here"/>
	</br></em>Note: Slug will automatically generate from title if left blank</em>
</div>

<div class="linkTarget form-group default_template">
	<h1>Ages</h1>
	<input type="text" value="" name="ages" id="" class="field" placeholder="Enter Ages here"/>
</div>
</div>

<div class="default_template">
<div class="form-light-holder   d-md-flex  dual_input">
	<div class="adsUrl  form-group">
		<h1>Redirection Type</h1>
		<label class="rdiobox">
		<input type="radio" value="trial_offer" class="redirection_type" name="redirection_type" checked /><span>Trial Offer</span></label>
		<label class="rdiobox">
		<input type="radio" value="dojocart" class="redirection_type" name="redirection_type"/><span>Dojocart</span></label>
		<label class="rdiobox">
		<input type="radio" value="thankyou_page" class="redirection_type" name="redirection_type" /><span>Thank you Page</span></label>
		<label class="rdiobox">
		<input type="radio" value="third_party_url" class="redirection_type" name="redirection_type" /><span>Third Party Url</span></label>
	</div>
	
	<div class="linkTarget  form-group">
		
		<div class="trial_offer_list"  style="display:none">
		<h1>Trial offer categories</h1>
			<select name="trial_offer_id" class="field">
			<option value="">-Select-</option>
			<?php foreach($trialCategories as  $trialCategory):?>
			<option value="<?=$trialCategory->id?>"><?=$trialCategory->name?></option>
			<?php endforeach;?>
			</select>
		</div>

		<div class="dojocart_list" style="display:none">
		<h1>Dojocarts</h1>
			<select name="dojocart_id" class="field">
			<option value="">-Select-</option>
			<?php foreach($dojocarts as  $dojocart):?>
			<option value="<?=$dojocart->id?>"><?=$dojocart->product_title?></option>
			<?php endforeach;?>
			</select>
		</div>


		<div class="thankyou_page_list" style="display:none">
		<h1>Thankyou Pages</h1>
			<select name="thankyou_page_id" class="field">
			<option value="">-Select-</option>
			<?php foreach($thankyou_pages as  $thankyou_page):?>
			<option value="<?=$thankyou_page->id?>"><?=$thankyou_page->title?></option>
			<?php endforeach;?>
			</select>
		</div>


		<div class="third_party_url" style="display:none">
		<h1>Third Party Url</h1>
			<input type="text" name="third_party_url" value="">
		</div>
	</div>
</div>


</div>

</div>



<div class="page-section" id="Headersection">
<div class="mb-3 main-content-label">Header Section</div>

<div class="form-light-holder">
	<h1>Header</h1>
	<textarea type="text" id="ckeditor_mini_header_title" name="header_title" class="field  full_width_input"></textarea>
</div>

<div class="form-light-holder">
	<h1>Header Description</h1>
	<div class="shorterCkeditor"><textarea name="header_desc" id="ckeditor_mini_header_desc" class="text ckeditor"></textarea></div>
</div>

<div class="default_template">
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Header Image</h1>
	
	<div class="custom-file half_width_custom_file">
		<input type="file" name="userfile"   class="custom-file-input" id="customFile1"  accept="image/*"  />
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	
	</div>
	
	<div class="linkTarget form-group">
		<h1>Image alt text</h1>
		<input value="" name="header_photo_alt_text" id="" class="field" placeholder="image alt text" type="text">
	</div>
		
		<!-- <div>
		<h1>Image Top Spacing</h1>

	<input type="text" name="header_photo_top_spacing" id="header_photo_top_spacing" class="field  header_photo_top_spacing" placeholder=""  style="width: 7%" value=""/> <span style="font-size:15px"><strong>px</strong></span><br/>
	<em>Note: Please use only integer or float value. don't use "px" in input field</em>
		</div> -->
</div>
</div>
<div class="form-light-holder   d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	<h1 >BACKGROUND IMAGE</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="background_image"   class="custom-file-input" id="customFile2"  accept="image/*"  />
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	</div>
	
	<div class="linkTarget form-group">
	<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs'>
    <div id='docs-content'>
		<input id="full_colorpicker_opacity" name="background_color" class="colourTextValue" value="" />
    </div>
	
		</div>
	</div>
</div>

	
</div>	

<div class="page-section" id="WhiteStripeFirstSection">
<div class="mb-3 main-content-label">White Stripe Under Header Section</div>
<div class="form-light-holder">
	<h1>Body Title</h1>
	<textarea type="text" id="ckeditor_mini_body_title" name="body_title"  class="field  full_width_input"></textarea>
</div>

<div class="default_template">
<div class="form-light-holder">
	<h1>Body Description</h1>
	<textarea name="body_desc" id="ckeditor_full_body_desc" class="text ckeditor"></textarea>
	
</div>
<div class="form-light-holder   d-md-flex  dual_input ">
	<div class="adsUrl form-group">
		<h1>Video Type</h1>
		<select name="video_type" id="" class="field videoType" >
		<option value="youtube_video" selected="selected">Youtube Video</option>
		<option value="vimeo_video" >Vimeo Video</option>
		</select>
	</div>
	<div class="linkTarget form-group">
		<div class="welcome_video">
			<div class="youtube_video">
			<h1>Youtube Video</h1>
			<input type="text" name="youtube_video" value="" class="field" >
			<div style="font-style:italic;font-size:11px;margin-left:12px;">
				eg. https://www.youtube.com/embed/UWCbfxwwC-I
			</div>
			</div>
			<span class="orButton">OR</span>
			<div class="vimeo_video">
			<h1>Vimeo Video</h1>
			<input type="text" name="vimeo_video" value="" class="field" >
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
	<input type="text" name="action_title" value="" class="field  full_width_input">
</div>

<div class="form-light-holder">
	<h1>Call to Action description</h1>
	<div class="shorterCkeditor"><textarea name="action_desc" id="ckeditor_mini_action_desc" class="text ckeditor"></textarea></div>
</div>
<div class="form-light-holder   d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">BACKGROUND IMAGE</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="action_background_image"   class="custom-file-input" id="customFile3"  accept="image/*"  />
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	
	
	</div>
	
	<div class="linkTarget form-group">
	<h1> Color Overlay And Opacity  Picker</h1>
	<div id='docs_action'>
    <div id='docs-content-action'>
		<input id="action_colorpicker_opacity" name="action_background_color" class="colourTextValueAction" value="" />
    </div>
	
 </div>
		</div>
</div>



<div class="form-light-holder">
	<h1>Headline #1</h1>
	<input type="text" name="action_headline_1" value="" class="field  full_width_input">
</div>
<div class="form-light-holder   d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #1</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="action_image_1"   class="custom-file-input" id="customFile4"  accept="image/*"  />
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	
	
	</div>
	
	<div class="linkTarget form-group">
		<h1 >Image alt text</h1>
		<input name="action_image_1_alt_text" id="" class="field" placeholder="image alt text" type="text">
		</div>
</div>

<div class="form-light-holder">
	<h1>Headline #2</h1>
	<input type="text" name="action_headline_2" value="" class="field  full_width_input">
</div>
<div class="form-light-holder   d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #2</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="action_image_2"   class="custom-file-input" id="customFile5"  accept="image/*"  />
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	</div>
	
	<div class="linkTarget form-group">
		<h1>Image alt text</h1>
		<input name="action_image_2_alt_text" id="" class="field" placeholder="image alt text" type="text">
		</div>
</div>

<div class="form-light-holder">
	<h1>Headline #3</h1>
	<input type="text" name="action_headline_3" value="" class="field  full_width_input">
</div>
<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
		<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #3</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="action_image_3"   class="custom-file-input" id="customFile6"  accept="image/*"  />
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	</div>
	
	<div class="linkTarget form-group">
		<h1 >Image alt text</h1>
		<input name="action_image_3_alt_text" id="" class="field" placeholder="image alt text" type="text">
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
	<textarea name="img_text_headline" id="img_text_headline" class="text ckeditor"></textarea>
	
</div>

<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	 
	<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #1</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="img_text_image_1"   class="custom-file-input" id="customFile7"  accept="image/*"  />
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	</div>
	
	<div class="linkTarget form-group">
		<h1>Image alt text</h1>
		<input name="img_text_image_1_alt_text" id="" class="field" placeholder="image alt text" type="text">
		</div>
	
</div>
<div class="form-light-holder">
	<h1>Title #1</h1>
	<input type="text" name="img_text_title_1" value="" class="field  full_width_input">
</div>


<div class="form-light-holder">
	<h1>Description #1</h1>
	<input type="text" name="img_text_desc_1" value="" class="field  full_width_input">
</div>



<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
		<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #2</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="img_text_image_2"   class="custom-file-input" id="customFile8"  accept="image/*"  />
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	
	</div>
	
	<div class="linkTarget form-group">
		<h1 >Image alt text</h1>
		<input name="img_text_image_2_alt_text" id="" class="field" placeholder="image alt text" type="text">
		</div>
</div>
<div class="form-light-holder">
	<h1>Title #2</h1>
	<input type="text" name="img_text_title_2" value="" class="field  full_width_input">
</div>


<div class="form-light-holder">
	<h1>Description #2</h1>
	<input type="text" name="img_text_desc_2" value="" class="field  full_width_input">
</div>




<div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Image uploader #3</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="img_text_image_3"   class="custom-file-input" id="customFile9"  accept="image/*"  />
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	
	</div>
	
	<div class="linkTarget form-group">
		<h1>Image alt text</h1>
		<input name="img_text_image_3_alt_text" id="" class="field" placeholder="image alt text" type="text">
		</div>
</div>

<div class="form-light-holder">
	<h1>Title #3</h1>
	<input type="text" name="img_text_title_3" value="" class="field  full_width_input">
</div>


<div class="form-light-holder">
	<h1>Description #3</h1>
	<input type="text" name="img_text_desc_3" value="" class="field  full_width_input">
</div>
</div>
</div>

<div class="default_template">
<div class="page-section" id="EmailOptin">

<div class="mb-3 main-content-label">Email Opt-in #1</div>

<div class="form-light-holder">

	<h1>Opt-In Title</h1>
	
	<textarea type="text" id="ckeditor_mini_opt1_title" name="opt1_title" class="field ckeditor  full_width_input"></textarea>
</div>
<div class="form-light-holder">

	<h1>Opt-In Text</h1>
	<input type="text" value="" name="opt1_text" id="" class="field full_width_input" placeholder=""  style=""/>
</div>
<div class="form-light-holder">

	<h1>Submit Button Text</h1>
	<input type="text" value="" name="opt1_submit_btn_text" id="" class="field full_width_input" placeholder=""  style=""/>
</div>
<div class="form-light-holder">
	<a id="published" class="checkbox1 check-off"></a>

	<h1 class="inline">Show Full Form </h1>

	<input type="hidden" value="0" name="show_full_form_1" class="hidden_cb1" />

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

<div class="mb-3 main-content-label">Email Opt-in #2</div>

<div class="form-light-holder">

	<h1>Opt-In Title</h1>
	<input type="text" value="" name="opt_2_title" id="" class="field full_width_input" placeholder=""  style=""/>
</div>

<div class="form-light-holder">

	<h1>Opt-In Text</h1>
	<input type="text" value="" name="opt_2_text" id="" class="field full_width_input" placeholder=""  style=""/>
</div>

<div class="form-light-holder form2checkbox">

	<a id="published" class="checkbox2 check-off"></a>

	<h1 class="inline">Show Full Form </h1>

	<input type="hidden" value="0" name="show_full_form_2" class="hidden_cb2" />

</div>
</div>
</div>


<div class="page-section" id="IconRows">
<div class="condensed_template">
<div class="mb-3 main-content-label">Icon Rows</div>
<div class="form-light-holder">
	<h1>Icon Row #1</h1>
	<input type="text" name="icon_row_1" value="" class="field  full_width_input">
</div>

<div class="form-light-holder">
	<h1>Icon Row #2</h1>
	<input type="text" name="icon_row_2" value="" class="field  full_width_input">
</div>

<div class="form-light-holder">
	<h1>Icon Row #3</h1>
	<input type="text" name="icon_row_3" value="" class="field  full_width_input">
</div>
</div>
</div>

<h1>&nbsp;</h1>

<div style="display:none">
 <div class="form-light-holder">
	<h1>Online Trial Title</h1>
	<input type="text" name="trial_title" value="" class="field  full_width_input">
</div>

<div class="form-light-holder">
	<h1>Online Trial description</h1>
	<div class="shorterCkeditor"><textarea name="trial_desc" id="ckeditor_mini_trial_desc" class="text ckeditor"></textarea></div>
</div>


<div class="form-light-holder">
    	<h1>Mini-form Offer Title</h1>
       <input type="text" class="half_field" name="mini_form_offer_title" value=""  />&nbsp;
</div>
<div class="form-light-holder">
    	<h1>Mini-form Offer Description</h1>
       <input type="text" class="half_field" name="mini_form_offer_desc" value="" />&nbsp;
</div>

<div class="form-light-holder">
    	<h1>Mini-form Button 1 Text</h1>
       <input type="text" class="half_field" name="mini_form_button1_text" value="" />&nbsp;
</div>

<div class="form-light-holder">
    	<h1>Mini-form Buton 2 Text</h1>
       <input type="text" class="half_field" name="mini_form_button2_text" value="" />&nbsp;
</div>
</div>

<div class="page-section" id="SeoMeta">

<div class="mb-3 main-content-label">Seo/Meta Details</div>
<div class="form-light-holder">
	<h1>Meta Title</h1>
	<input type="text" name="meta_title" value="" class="field">
</div>

<div class="form-light-holder" style="">
	<h1>Meta Description</h1>
	<textarea name="meta_desc" class="ckeditor" id="frm-text"></textarea>
</div>


<div class="form-light-holder <?= $display_class ?>">
	<h1>Body Id</h1>
	<input type="text" name="body_id" class="field">
</div>

<div class="form-light-holder">
	<a id="published" class="checkbox check-on"></a>
	<h1 class="inline">Publish This</h1>
	<input type="hidden" value="1" name="published" class="hidden_cb" />
</div>

<div class="form-light-holder hide_from_navigation">
	<a id="published" class="hide_from_navigation_checkbox check-off"></a>
	<h1 class="inline">Hide from Navigation</h1>
	<input type="hidden" value="0" name="hide_from_navigation" class="hide_from_navigation_hidden_cb" />
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
   color: '',
   
});

$("#action_colorpicker_opacity").spectrum({
   color: '',
   
});

$('.btn-save').click(function(){
	var bg_color = $('#docs').find('.sp-preview-inner').css("background-color");
	var bg_color_action = $('#docs_action').find('.sp-preview-inner').css("background-color");
	
	
	$('.colourTextValue').val(bg_color);
	$('.colourTextValueAction').val(bg_color_action);
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
	$('.az-toggle').on('click', function(){
	  $(this).toggleClass('on');
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
	
	
</script>

