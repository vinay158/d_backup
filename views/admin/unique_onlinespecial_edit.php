<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
    <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>    
	<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>
	-->
<script src="js/ckeditor_full/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		 CKEDITOR.replace(  'sub_title', 
									{ customConfig : 'config.js' }
							);
							
		 CKEDITOR.replace(  'upsell_top_text', 
									{ customConfig : 'config.js' }
							);
	});
</script>	
	
    <link rel="stylesheet" href="/resources/demos/style.css" />
   

    <script language="javascript">
	$(window).load(function(){
		$.each( $( ".radio" ), function() {
			if($(this).attr('checked') == 'checked'){
				if($(this).val() == 1){
					$('.paid_trial').show();
					$('.thirdPartyUrlBox').hide();
				} else {
					$('.paid_trial').hide();
					$('.thirdPartyUrlBox').show();
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
		$('input#amount').blur(function(){			
				var	val=$(this).val();			
				if(!val.match(/^(?:[1-9]\d*(?:\.\d\d?)?|0\.[1-9]\d?|0\.0[1-9])$/))			
				{
				  alert('Oops! You have entered invalid characters in the trial amount field. Please enter the amount in decimal form. Do not use any characters such as "<?php echo $this->query_model->getSiteCurrencyTypeForAdmin() ?>". Example: "49.99"');
				  $(this).val('');				  
				  return false;
				}				    
		    });		 	
		
	$(".form-light-holder .checkbox").click(function(){
		if($(this).hasClass("check-on")){
			$(this).removeClass("check-on");
			$(this).addClass("check-off");
			$(this).parents(".form-light-holder").children(".hidden_cb").val("off");
		}
		else
		{
			$(this).removeClass("check-off");
			$(this).addClass("check-on");
			$(this).parents(".form-light-holder").children(".hidden_cb").val("on");
		}
	});

		$(".radio").click(function(){
			
			if($(this).val() == "0"){	// free
				$(".paid_trial").hide();
				$('.thirdPartyUrlBox').show();
				
			}else{	// paid
				$(".paid_trial").show();
				$('.thirdPartyUrlBox').hide();
			}
		})
		
		
	  $(function() {
	        $( ".datepicker" ).datepicker({ dateFormat: "yy-mm-dd" });
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
	
	});

    </script>
    <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
    <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
    <link rel="stylesheet" href="/resources/demos/style.css" />
    <script>
    $(function() {
        $( "#start" ).datepicker({ dateFormat: "yy-mm-dd" });

    });
    $(function() {
        $( "#expire" ).datepicker({ dateFormat: "yy-mm-dd" });

    });
    </script>


<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Edit: <?php echo $title; ?></h2>
			</div>
			
		  </div>
	  </div>
	   <div class="row row-sm program-cat-page">

          <div class="col-sm-12 col-xl-12 az-content-body-contacts"  >
			<div class="card pd-sm-20 edit-form">
	  
	  
<div class="gen-holder">
	<div class="gen-panel-holder" style="width: 100%">
	<div class="gen-panel">
		
		<div class="panel-body">
		<div class="panel-body-holder" >
		<div class="form-holder">

<div class="mb-3 main-content-label page_main_heading">Edit: <?php echo $title; ?></div>

<form id="blog_form" action="" method="post" enctype="multipart/form-data">

<?php
if($this->session->userdata("user_level") == 1) {
	$display_third_party_url = 'display:block';
	$is_master_admin = true;
} else {
	$is_master_admin = false;	
	$display_third_party_url = 'display:none';
}

?>
<?php 

	if(!empty($details)): 
	
	$special = $details[0];	
	
	$display_class = '';
	if($user_level != 1){
		$display_class = 'display_class';
	}
?>

<!--<div class="form-light-holder">
	<a id="published" class="checkbox <?php if($special->program_interest=="on") echo "check-on"; else echo "check-off";?>"></a>
	<h1 class="inline">Show Program of Interest on the online special form</h1>
	<input type="hidden" value="<?=$special->program_interest?>" name="program_interest" class="hidden_cb" />
</div>

<div class="form-light-holder">
	<a id="published" class="checkbox <?php if($special->international_phone=="on") echo "check-on"; else echo "check-off";?>"></a>
	<h1 class="inline">Show International Phone format</h1>
	<input type="hidden" value="<?=$special->international_phone?>" name="international_phone" class="hidden_cb" />
</div>-->

<?php 

	if($special->trial == 0){
		$free_checked = 'checked = checked';
		$paid_checked = '';
	}else{
		$paid_checked = 'checked= checked';
		$free_checked = '';
	}
?>

<?php //echo '<pre>'; print_r($special); die; ?>

<?php if(!empty($categories)){ ?>
<div class="form-light-holder">
<h1>Trial Categories</h1>
	<select name="cat_id" id="cat_id" class="field">
	<?php foreach($categories as  $cat):?>
	<option value="<?=$cat->id?>" <?php echo ($cat->id == $special->cat_id) ? 'selected=selected' : ''?>><?=$cat->name?></option>
	<?php endforeach;?>
	</select>
</div>
<?php } ?>

<div class="form-light-holder" style="display:none">
<h1>Override Logo</h1>
	<select name="override_logo" id="window" class="field">
	<?php foreach($override_logos as  $override_logo):?>
	<option value="<?=$override_logo->s_no?>" <?php if($special->override_logo == $override_logo->s_no){ echo 'selected=selected';} ?>><?=$override_logo->logo_name?></option>
	<?php endforeach;?>
	</select>
</div>


 <div class="form-light-holder" style="display:none">
        <h1>Page Title</h1>
        <input type="text" name="title" value="<?php echo $this->query_model->getStrReplaceAdmin($special->title);?>" id="title" class="field full_width_input" placeholder="Enter Title here" style=""/>
    </div>
    
    <div class="form-light-holder" style="display:none;">
        <h1>Page Description</h1>	
        <textarea id="frm-text" name="description" class="ckeditor" placeholder="Your description here" ><?=$special->description;?></textarea>
    </div>

<div class="<?php // echo $display_class; ?>">	
<div class="form-light-holder">
<div class="row row-xs align-items-center">
		<div class="col-md-12  mg-t-5 mg-md-t-0">
		<div class="row mg-t-10">
						<?php 
							$payment_result = $this->query_model->getbyTable('tbl_payments');
							
							$payment_selected = 1;
							if($payment_result[0]->authorize_net_payment == 0 && $payment_result[0]->braintree_payment == 0 && $payment_result[0]->stripe_payment == 0 && $payment_result[0]->stripe_ideal_payment == 0 && $payment_result[0]->paypal_payment == 0){
								$payment_selected = 0;
							}
						?>
	<?php if($payment_selected == 1){ ?>
	<div class="col-lg-2">
			  <label class="rdiobox">
	<input type="radio"  name="trial" value="1" id="Paid" class="radio" <?php echo $paid_checked; ?> /> <span>Paid Trial</span>
		  </label>
		</div>
	<?php } ?>
	<div class="col-lg-10 mg-t-20 mg-lg-t-0">
			  <label class="rdiobox">
	<input type="radio"  name="trial" value="0" id="Free" class="radio" <?php echo $free_checked; ?> /> <span>Free Trial</span>
			  </label>
			</div><!-- col-3 -->
			</div>
		</div>
	</div>
	
</div>
</div>

	<div class="form-light-holder">
		<h1><strong>Trial Info</strong></h1>
        <h1>Offer Title</h1>
        <input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($special->offer_title)?>" name="offer_title" id="offer_title" class="field full_width_input"  maxlength="100"    placeholder="Enter Offer Title here"/>
    </div>
    <div class="form-light-holder" style="display:none">
        <h1>Offer Description</h1>
        <input type="text" name="offer_description" value="<?php echo $this->query_model->getStrReplaceAdmin($special->offer_description);?>" id="offer_description" maxlength="100" class="field full_width_input" placeholder="Enter Offer Description here"/>
    </div>
	
	<div class="form-light-holder">
        <h1>Large Offer Text Override</h1>
        <input type="text" name="large_offer_text" id="offer_title" class="field full_width_input"  value="<?php echo $this->query_model->getStrReplaceAdmin($special->large_offer_text) ?>"  placeholder="Large Offer Text Override"/>
    </div>
	
	
	
	
  
  <!--  
    <div class="form-light-holder" style="">
        <h1>Offer Description</h1>	
        <textarea id="frm-text" name="miniform_desc_free" class="ckeditor" placeholder="Your offer description" ><?=$special->miniform_special_details_free;?></textarea>
    </div>
     <div class="form-light-holder">
    	<h1><strong>Dynamic Text from Direct Link</strong></h1>
    </div>
	<div class="form-light-holder">
        <h1>Special Name</h1>
        <input type="text" value="<?=$special->direct_special_name_free?>" name="direct_name_free" id="direct_name_free" class="field" placeholder="Enter special name here"/>
    </div>
    <div class="form-light-holder">
        <h1>Special Offer</h1>
        <input type="text" name="direct_offer_free" value="<?=$special->direct_special_offer_free?>" id="direct_offer_free" maxlength="40" class="field" placeholder="Enter special offer here"/>
    </div>
    
    <div class="form-light-holder" style="">
        <h1>Offer Description</h1>	
        <textarea id="frm-text" name="direct_desc_free" class="ckeditor" placeholder="Your offer description" ><?=$special->direct_special_details_free;?></textarea>
    </div>
	<div class="form-light-holder">
    	<h1><strong>Free Trial Info</strong></h1>
    </div>
	<div class="form-light-holder">
        <h1>Special Name</h1>
        <input type="text" value="<?=$special->miniform_special_name_paid?>" name="miniform_name_paid" id="miniform_name_paid" class="field" placeholder="Enter special name here"/>
    </div>
    <div class="form-light-holder">
        <h1>Special Offer</h1>
        <input type="text" name="miniform_offer_paid" value="<?=$special->miniform_special_offer_paid?>" id="miniform_offer_paid" maxlength="40" class="field" placeholder="Enter special offer here"/>
    </div>
    
    <div class="form-light-holder" style="">
        <h1>Offer Description</h1>	
        <textarea id="frm-text" name="miniform_desc_paid" class="ckeditor" placeholder="Your offer description" ><?=$special->miniform_special_details_paid;?></textarea>
    </div>
    
    
    
    <div class="form-light-holder">
    	<h1><strong>Dynamic Text from Direct Link</strong></h1>
    </div>
	<div class="form-light-holder">
        <h1>Special Name</h1>
        <input type="text" value="<?=$special->direct_special_name_paid?>" name="direct_name_paid" id="direct_name_paid" class="field" placeholder="Enter special name here"/>
    </div>
    <div class="form-light-holder">
        <h1>Special Offer</h1>
        <input type="text" name="direct_offer_paid" value="<?=$special->direct_special_offer_paid?>" id="direct_offer_paid" maxlength="40" class="field" placeholder="Enter special offer here"/>
    </div>
    
    <div class="form-light-holder" style="">
        <h1>Offer Description</h1>	
        <textarea id="frm-text" name="direct_desc_paid" class="ckeditor" placeholder="Your offer description" ><?=$special->direct_special_details_paid;?></textarea>
    </div>
    -->
 
 
 <div class="form-light-holder">
        <h1>Features</h1>
		<div id="AddMoreFeatures">
			<div class=""><h3><a href="javascript:void(0);" class="btn btn-outline-light  AddMoreButton">Add More Feature</a></h3></div>
			<?php $features = unserialize($special->features);
					if(!empty($features)){
					$i = 1;
					foreach($features as $feature){
			 ?>
        	&#10687; <input type="text"  name="features[<?= $i ?>]" id="features" value="<?php echo $this->query_model->getStrReplaceAdmin( $feature); ?>" class="field"   placeholder="Enter Features here"/>
			
			<br>
			<?php $i++; }  } else { ?>
			&#10687; <input type="text"  name="features[1]" id="features" value="" class="field"   placeholder="Enter Features here"/><br>
			<?php } ?>
		</div>
    </div>
	
<?php if($payment_selected == 1){ ?>	
<div class="paid_trial">   
	<!--<div class="form-light-holder" style="">
        <h1>Additional Text 1</h1>	
        <textarea id="frm-text" name="additional_text_1" class="ckeditor" placeholder="Enter Additional Text 1 Here" ><?=$special->additional_text_1;?></textarea>
    </div>
    <div class="form-light-holder">
        <h1>Additional Text 2</h1>
        <input type="text" value="<?=$special->additional_text_2?>" name="additional_text_2" id="additional_text_2" class="field" placeholder="Enter Additional Text 2 Here" style="width:98%"/>
    </div>
	<div class="form-light-holder">
        <h1>Additional Text 3</h1>
        <input type="text" value="<?=$special->additional_text_3?>" name="additional_text_3" id="additional_text_3" class="field" placeholder="Enter Additional Text 2 Here" style="width:98%"/>
    </div>-->
    <div class="form-light-holder" id="trial_amt">
        <h1><?php echo $this->query_model->getSiteCurrencyTypeForAdmin() ?> Trial Amount</h1>
        <input type="text" value="<?=$special->amount?>" name="amount" id="amount" class="field" placeholder="Enter trial amount here"/><br>
        <span>"Please enter the amount in decimal form.  Do not use any characters such as "$". Example: "49.99"."</span>
    </div>
</div>	
<?php } ?>




<script language="javascript">
$(window).load(function(){
	if($('.hiddenButton').val() == 0){
		$('.template_box').hide();
	}else{
		$('.template_box').show();
	}
	
	if($(".show_term_condition_hidden_cb").val() == 0){
		$('#hide_show_term_condition').hide();
	}
});
$(document).ready(function(){
$(".form-light-holder_2 .checkbox_2").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents(".form-light-holder_2").children(".hidden_cb").val("0");
		$('.template_box').hide();
		$('.api_key').attr('required',false);
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents(".form-light-holder_2").children(".hidden_cb").val("1");
		$('.template_box').show();
		$('.api_key').attr('required',true);
	}
})



// Show Term & Conditions
$(".show_term_condition_required .show_term_condition_checkbox").click(function(){
		if($(this).hasClass("check-on")){
			$(this).removeClass("check-on");
			$(this).addClass("check-off");
			$(this).parents(".form-light-holder").children(".show_term_condition_hidden_cb").val("0");
			$('#hide_show_term_condition').hide();
			
		}
		else
		{
			$(this).removeClass("check-off");
			$(this).addClass("check-on");
			$(this).parents(".form-light-holder").children(".show_term_condition_hidden_cb").val("1");
			$('#hide_show_term_condition').show();
		}
});



// Child Name
$(".child_name_required .child_name_checkbox").click(function(){
		if($(this).hasClass("check-on")){
			$(this).removeClass("check-on");
			$(this).addClass("check-off");
			$(this).parents(".form-light-holder").children(".child_name_hidden_cb").val("0");
			
		}
		else
		{
			$(this).removeClass("check-off");
			$(this).addClass("check-on");
			$(this).parents(".form-light-holder").children(".child_name_hidden_cb").val("1");
		}
});



})
</script>
<?php
	$checkbox_check = 'check-off';
	if(!empty($special)){
		if($special->third_party_tiral_url_type == 1){
			$checkbox_check = 'check-on';
		}else{
			$checkbox_check = 'check-off';
		}
		
		
	}
	
	
?>
<div style="<?php echo $display_third_party_url; ?>" class="thirdPartyUrlBox">
<div class="form-light-holder form-light-holder_2">
	<a id="published" class="checkbox_2 <?php echo $checkbox_check; ?> " ></a>
	<h1 class="inline">Third Party Url for Free Trial</h1>
	<input type="hidden" value="<?php if(!empty($special->third_party_tiral_url_type)){ echo $special->third_party_tiral_url_type;}else{ echo 0;} ?>" name="third_party_tiral_url_type" class="hidden_cb hiddenButton" />
</div>



<div class="form-light-holder template_box" style="display:none">
		<h1>Third Party Url</h1>
		<input type="text" value="<?php if(!empty($special)){ echo $this->query_model->getStrReplaceAdmin($special->third_party_trial_url); }?>" name="third_party_trial_url" class="api_key full_width_input" />
</div>
</div>


<div class="form-light-holder child_name_required">
		<a id="" class="child_name_checkbox <?php if($special->is_child_name == 1) echo "check-on"; else echo "check-off"; ?>"></a>
		<h1 class="inline">Child’s Name</h1>
		<input type="hidden" value="<?php echo $special->is_child_name ?>" name="is_child_name" class="child_name_hidden_cb" />
				
</div>



<div class="form-light-holder show_term_condition_required">
		<a id="status" class="show_term_condition_checkbox <?php if($special->show_term_condition == 1) echo "check-on"; else echo "check-off"; ?>"></a>
		<h1 class="inline">Show Terms & Conditions</h1>
		<input type="hidden" value="<?php echo $special->show_term_condition ?>" name="show_term_condition" class="show_term_condition_hidden_cb" />
				
</div>

<div class="form-light-holder" style="" id="hide_show_term_condition">
	<h1>Terms & Conditions</h1>
	<textarea name="term_condition"  id="ckeditor_full_term_condition" class="ckeditor" ><?php echo $special->term_condition; ?></textarea>
</div>



<!-- Upsell Section Start -->
<div class="form-light-holder upsale_required">
		<a id="status" class="upsale_checkbox <?php if($special->upsale == 1) echo "check-on"; else echo "check-off"; ?>"></a>
		<h1 class="inline">Add Upsell? </h1>
		<input type="hidden" value="<?= $special->upsale ;?>" name="upsale" class="upsale_hidden_cb" />
</div>

<div id="upsale_option">
<!-- <div class=""><h3><a href="javascript:void(0);" class="AddMoreUpsale">Add Another Upsell</a></h3></div> -->
	<?php if(!empty($upsells)){ 
				$a = 1;
				foreach($upsells as $upsell_opt){
	?>
<div class="upsell_box_<?=$upsell_opt->id?>">
&nbsp;
<div class="form-light-holder">
<a href="javascript:void(0)" class="delete_upsell" number="<?=$upsell_opt->id?>" style="float:right"><b>Delete Upsell </b></a>

		<h1>Upsell Top Text</h1>		
		<textarea name="data[<?= $a; ?>][upsell_top_text]" class="ckeditor" id="upsell_top_text" style="height: 74px" ><?php echo $this->query_model->getStrReplaceAdmin($upsell_opt->upsell_top_text);?></textarea>
	</div>
	
	

<div class="form-light-holder   d-md-flex  dual_input ">
	<div class="adsUrl form-group">
		<h1>Video Type</h1>
		<select name="data[<?= $a; ?>][video_type]" id="" class="field videoType" >
		<option value="youtube_video" <?php if($upsell_opt->video_type == 'youtube_video'){ echo 'selected=selected'; } ?>>Youtube Video</option>
		<option value="vimeo_video" <?php if($upsell_opt->video_type == 'vimeo_video'){ echo 'selected=selected'; } ?>  >Vimeo Video</option>
	</select>
	
	</div>
	<div class="linkTarget form-group">
	<div class="youtube_video">
	<h1>Youtube Video</h1>
	<input type="text" name="data[<?= $a; ?>][youtube_video]" value="<?=$upsell_opt->youtube_video;?>" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://www.youtube.com/embed/UWCbfxwwC-I
	</div>
	</div>
	<span class="orButton">OR</span>
	<div class="vimeo_video">
	<h1>Vimeo Video</h1>
	<input type="text" name="data[<?= $a; ?>][vimeo_video]" value="<?=$upsell_opt->vimeo_video;?>" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://player.vimeo.com/video/167143332
	</div>
	</div>
	</div>
	
</div>


<div class="form-light-holder">

	<h1>Upsell Offer Title</h1>
	<input type="text" value="<?=$upsell_opt->up_title?>" name="data[<?= $a ?>][up_title]" id="up_title" class="field full_width_input" placeholder="" style="width:40%"/>
	<br/>
	<em>Example: Add a Uniform for only $19.99! (reg. $49))</em>
</div>	
<div class="form-light-holder manage-pricerow">
	<h1>Upsell Offer Price</h1>
	<div class="price-validate">
	<?php echo $this->query_model->getSiteCurrencyTypeForAdmin() ?><input type="text" value="<?=$upsell_opt->up_price?>" name="data[<?= $a ?>][up_price]" id="up_price" class="field up_price" number="<?= $a ?>" placeholder="" style="width:100px"/><div class="ErrorMessage ErrorMessage_up_price<?= $a ?>"></div>
	</div>
	
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		Please enter the amount in decimal form. Do not use any characters such as "$” or “%". Example: "49.99" or “7”.
	</div>

</div>
<div class="form-light-holder" style="display:none">
	<h1>Upsell “Yes Please! Text” Description</h1>
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($upsell_opt->yes);?>" name="data[<?= $a ?>][yes]" id="yes" class="field full_width_input" placeholder=""/>	
</div>
<div class="form-light-holder">
	<h1>Upsell “No Thank You! Text” Description</h1>
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($upsell_opt->no);?>" name="data[<?= $a ?>][no]" id="no" class="field full_width_input" placeholder=""/>	
</div> 
<div class="form-light-holder">
		<h1>Upsell Bottom Text</h1>		
		<textarea name="data[<?= $a; ?>][description]" class="ckeditor" id="sub_title" style="height: 74px" ><?=$upsell_opt->description?></textarea>
	</div>
<div class="form-light-holder" style="display:none">
	<h1>Upsell Text</h1>
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($upsell_opt->text_1);?>" name="data[<?= $a ?>][text_1]" class="field" placeholder="" style="width:40%"/>	
</div>
	</div>
	<?php 
			$a++; 
		}
	 } else { 
?>

	


<div class="form-light-holder">

		<h1>Upsell Top Text</h1>		
		<textarea name="data[1][upsell_top_text]" class="ckeditor" id="upsell_top_text" style="height: 74px" ></textarea>
	</div>
	
	
<div class="form-light-holder  d-md-flex  dual_input ">
	<div class="adsUrl form-group">
		<h1>Video Type</h1>
		<select name="data[1][video_type]" id="" class="field videoType" >
		<option value="youtube_video" selected>Youtube Video</option>
		<option value="vimeo_video"  >Vimeo Video</option>
	</select>
	
	</div>
	<div class="linkTarget form-group">
	<div class="youtube_video">
	<h1>Youtube Video</h1>
	<input type="text" name="data[1][youtube_video]" value="" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://www.youtube.com/embed/UWCbfxwwC-I
	</div>
	</div>
	<div class="vimeo_video">
	<h1>Vimeo Video</h1>
	<input type="text" name="data[1][vimeo_video]" value="" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://player.vimeo.com/video/167143332
	</div>
	</div>
	</div>
	
</div>
<div class="form-light-holder">
	<h1>Upsell Offer Title</h1>
	<input type="text" value="" name="data[1][up_title]" id="up_title" class="field full_width_input" placeholder="" style="width:40%"/>	
	<br/><em>Example: Add a Uniform for only $19.99! (reg. $49))</em>
</div>
<div class="form-light-holder manage-pricerow">
	<h1>Upsell Offer Price</h1>
	<div class="price-validate">
	<?php echo $this->query_model->getSiteCurrencyTypeForAdmin() ?><input type="text" value="" name="data[1][up_price]" id="up_price" class="field up_price" number="1" placeholder="Enter Price" style="width:100px"/>
		<div class="ErrorMessage ErrorMessage_up_price1"></div>
	</div>
	
	</div>

		
<div class="form-light-holder" style="display:none">
	<h1>Upsell “Yes Please! Text” Description</h1>
	<input type="text" value="" name="data[1][yes]" id="yes" class="field full_width_input" placeholder="" />	
</div>
<div class="form-light-holder">
	<h1>Upsell “No Thank You! Text” Description</h1>
	<input type="text" value="" name="data[1][no]" id="no" class="field full_width_input" placeholder="" />	
</div>
<div class="form-light-holder">
		<h1>Upsell Bottom Text</h1>		
		<textarea name="data[1][description]" class="ckeditor" id="sub_title" style="height: 74px" ></textarea>
	</div>	
	<div class="form-light-holder" style="display:none">
	<h1>Upsell Text</h1>
	<input type="text" value="" name="data[1][text_1]" class="field" placeholder="" style="width:40%"/>	
</div>
<?php } ?>
	
</div>
<!-- Upsell Section End -->


   <!-- <div class="form-light-holder" id="paypal_email">
        <h1>Paypal Email Address</h1>
        <input type="text" value="<?=$special->paypal_email?>" name="email" id="email" class="field" placeholder="Enter paypal email address here"/>
    </div>-->

    
    <div class="form-white-holder" style="padding-bottom:20px;">
        <input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />
    </div>


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
<input type="hidden" id="trial_offer_id" value="<?php echo $this->uri->segment(4); ?>"  />
<input type="hidden" class="totalAddMoreFeatures" value="<?php if(count($features) >= 1){ echo count($features); } else { echo 1; } ?>"  />
<script language="javascript" type="text/javascript">
 	
	$(document).ready(function(){
		$('.AddMoreButton').click(function(){
			var totalAddMoreFeatures = $('.totalAddMoreFeatures').val();
			var i = parseInt(totalAddMoreFeatures) + Number(1);
			$('.totalAddMoreFeatures').val(i);
			
				$('#AddMoreFeatures').append('&#10687; <input type="text"  name="features['+i+']" id="features" class="field"  placeholder="Enter Features here"/><br>');
			
		});
	});	 
	
</script>


<input type="hidden" class="totalAddMoreUpsales" value="<?php if(count($upsells) >= 1){ echo count($upsells); } else { echo 1; } ?>"  />
<script language="javascript">
$(window).load(function(){
	$.each($('.radio'), function(){
		if($(this).is(':checked')){
			if($(this).val() == "0"){	// free
				$(".paid_trial").hide();
				$('.thirdPartyUrlBox').show();
				
			}else{	// paid
				$(".paid_trial").show();
				$('.thirdPartyUrlBox').hide();
			}
		}
		});
})
$(document).ready(function(){
	var ups = '<?php echo $special->upsale; ?>';
	
	// Upsale Option hide/show
	if(ups == 1){
		$('#upsale_option').show();
		$('#up_price').attr('required', 'required');

	}else{
		$('#up_price').attr('required', false);
		$('#upsale_option').hide();	
	}
	
	// Delete Individual Upsell
	$(".delete_upsell").click(function(){

		var upsell_id=$(this).attr('number');
		var trial_offer_id = $('#trial_offer_id').val();
		
		$('.upsell_box_'+upsell_id).remove();
		
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/unique_onlinespecial/delete_upsell',						
		data: { upsell_id : upsell_id}					
		}).done(function(msg){ 
		if(eval(msg) == 1){		
			//$('.stand_page_'+upsell_id).hide();
			setTimeout("window.location.href='admin/unique_onlinespecial/edit/"+trial_offer_id+"'",1000);			
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});

	});

	
	
	
// Upsell button
$(".upsale_required .upsale_checkbox").click(function(){
		if($(this).hasClass("check-on")){
			$(this).removeClass("check-on");
			$(this).addClass("check-off");
			$(this).parents(".form-light-holder").children(".upsale_hidden_cb").val("0");
			$('#up_price').attr('required', false);
			$('#upsale_option').hide();
			//var show_price = 0;
			
		}
		else
		{
			$(this).removeClass("check-off");
			$(this).addClass("check-on");
			$(this).parents(".form-light-holder").children(".upsale_hidden_cb").val("1");
			$('#upsale_option').show();
			$('#up_price').attr('required', 'required');
			//var show_price = 1;
		}
	
});




		$('.AddMoreUpsale').click(function(){
		var totalAddMoreUpsales = $('.totalAddMoreUpsales').val();
		var b = parseInt(totalAddMoreUpsales) + Number(1);
		$('.totalAddMoreUpsales').val(b);
			$('#upsale_option').append('&nbsp;<div class="form-light-holder"><h1> Upsell #'+b+' Title</h1><input type="text" value="" name="data['+b+'][up_title]" id="up_title" class="field" placeholder="" style="width:40%"/></div><div class="form-light-holder manage-pricerow"><h1>Upsell #'+b+' Price</h1><div class="price-validate">$<input type="text" required="required" value="" name="data['+b+'][up_price]" id="up_price" class="field up_price" number="'+b+'" placeholder="Enter Price" style="width:86%"/><div class="ErrorMessage ErrorMessage_up_price'+b+'"></div></div><div style="font-style:italic;font-size:11px;margin-left:12px;">Please enter the amount in decimal form. Do not use any characters such as "$” or “%". Example: "49.99" or “7”.	</div><div class="price-validate tax_hide_show"><div class="ErrorMessage ErrorMessage_sales_tax_main'+b+'"></div></div></div><div class="form-light-holder"><h1>Upsell #'+b+' “YES PLEASE! TEXT” DESCRIPTION</h1><input type="text" value="" name="data['+b+'][yes]" id="yes" class="field" placeholder="" style="width:40%"/></div><div class="form-light-holder"><h1>Upsell #'+b+'  “NO THANK YOU! TEXT” DESCRIPTION</h1><input type="text" value="" name="data['+b+'][no]" id="no" class="field" placeholder="" style="width:40%"/></div>');
		
	});



});
</script>
<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>