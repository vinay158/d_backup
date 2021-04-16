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
    
	<?php

	
if($this->session->userdata("user_level") == 1) {
	$display_third_party_url = 'display:block';
	
	$is_master_admin = true;
} else {
	$is_master_admin = false;	
	$display_third_party_url = 'display:none';
}
?>
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
	
	
	
// Show Term & Conditions
$(".show_term_condition_required .show_term_condition_checkbox").click(function(){
		if($(this).hasClass("check-on")){
			$(this).removeClass("check-on");
			$(this).addClass("check-off");
			$(this).parents(".form-light-holder").children(".show_term_condition_hidden_cb").val("0");
			$('#hide_show_term_condition').hide();
			//var show_price = 0;
			
		}
		else
		{
			$(this).removeClass("check-off");
			$(this).addClass("check-on");
			$(this).parents(".form-light-holder").children(".show_term_condition_hidden_cb").val("1");
			$('#hide_show_term_condition').show();
			//var show_price = 1;
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
			  <h2 class="az-dashboard-title">Add: Trial Offer</h2>
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

<div class="mb-3 main-content-label page_main_heading">Add: Trial Offer</div>

<form id="blog_form" action="" method="post" enctype="multipart/form-data">



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
<?php if(!empty($categories)){ ?>
<div class="form-light-holder">
<h1>Trial Categories</h1>
	<select name="cat_id" id="cat_id" class="field">
	<?php foreach($categories as  $cat):?>
	<option value="<?=$cat->id?>" <?php echo ($cat->id == $this->uri->segment(4)) ? 'selected=selected' : ''?>><?=$cat->name?></option>
	<?php endforeach;?>
	</select>
</div>
<?php } ?>

<div class="form-light-holder" style="display:none">
<h1>Override Logo</h1>
	<select name="override_logo" id="window" class="field">
	<?php foreach($override_logos as  $override_logo):?>
	<option value="<?=$override_logo->s_no?>"><?=$override_logo->logo_name?></option>
	<?php endforeach;?>
	</select>
</div>

 <div class="form-light-holder" style="display:none">
        <h1>Page Title</h1>
        <input type="text" name="title"  id="title" class="field  full_width_input" placeholder="Enter Title here"  />
    </div>
    
    <div class="form-light-holder" style="display:none;">
        <h1>Page Description</h1>	
        <textarea id="frm-text" name="description" class="ckeditor" placeholder="Your description here" ></textarea>
    </div>

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
				<input type="radio"  name="trial" value="1" id="Paid" class="radio"  /> <span>Paid Trial</span>
			  </label>
			</div>
			<?php } ?>
			<div class="col-lg-10 mg-t-20 mg-lg-t-0">
			  <label class="rdiobox">
				<input type="radio"  name="trial" value="0" id="Free" class="radio"  checked="checked" /> <span>Free Trial</span>
			  </label>
			</div><!-- col-3 -->
			</div>
		</div>
	</div>

</div>


	<div class="form-light-holder">
	
		<h1><strong>Trial Info</strong></h1>
		
        <h1>Offer Title</h1>
        <input type="text" name="offer_title" id="offer_title" class="field full_width_input"  maxlength="100" style=""   placeholder="Enter Offer Title here"/>
    </div>
    <div class="form-light-holder" style="display:none">
        <h1>Offer Description</h1>
        <input type="text" name="offer_description"  id="offer_description" maxlength="100" class="field full_width_input" placeholder="Enter Offer Description here"/>
    </div>
	<div class="form-light-holder">
        <h1>Large Offer Text Override</h1>
        <input type="text" name="large_offer_text" id="offer_title" class="field full_width_input"   placeholder="Large Offer Text Override"/>
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
			<div class=""><h3><a href="javascript:void(0);" class="btn btn-outline-light AddMoreButton">Add More Feature</a></h3></div>
		
        	&#10687; <input type="text"  name="features[1]" id="features" class="field"  placeholder="Enter Features here"/><br>
			
		</div>
    </div>
	

<?php if($payment_selected == 1){ ?>
<div class="paid_trial">   
	<!--<div class="form-light-holder" style="">
        <h1>Additional Text 1</h1>	
        <textarea id="frm-text" name="additional_text_1" class="ckeditor" placeholder="Enter Additional Text 1 Here" ></textarea>
    </div>
    <div class="form-light-holder">
        <h1>Additional Text 2</h1>
        <input type="text"  name="additional_text_2" id="additional_text_2" class="field" placeholder="Enter Additional Text 2 Here" style="width:98%"/>
    </div>
	<div class="form-light-holder">
        <h1>Additional Text 3</h1>
        <input type="text"  name="additional_text_3" id="additional_text_3" class="field" placeholder="Enter Additional Text 2 Here" style="width:98%"/>
    </div>-->
    <div class="form-light-holder" id="trial_amt">
        <h1><?php echo $this->query_model->getSiteCurrencyTypeForAdmin() ?> Trial Amount</h1>
        <input type="text"  name="amount" id="amount" class="field" placeholder="Enter trial amount here"/><br>
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
});
$(document).ready(function(){
$(".form-light-holder_2 .checkbox_2").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents(".form-light-holder_2").children(".hidden_cb_2").val("0");
		$('.template_box').hide();
		$('.api_key').attr('required',false);
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents(".form-light-holder_2").children(".hidden_cb_2").val("1");
		$('.template_box').show();
		$('.api_key').attr('required',true);
	}
})




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
<div style="display:block" class="thirdPartyUrlBox">
<div class="form-light-holder form-light-holder_2">
	<a id="published" class="checkbox_2 <?php echo $checkbox_check; ?> " ></a>
	<h1 class="inline">Third Party Url for Free Trial</h1>
	<input type="hidden" value="<?php if(!empty($special)){ echo $special->third_party_tiral_url_type; } else{ echo 0; }?>" name="third_party_tiral_url_type" class="hidden_cb_2 hiddenButton" />
</div>



<div class="form-light-holder template_box" style="display:none">
		<h1>Third Party Url</h1>
		<input type="text" value="<?php if(!empty($special)){ echo $special->third_party_trial_url; }?>" name="third_party_trial_url" class="api_key full_width_input" />
</div>
</div>

<div class="form-light-holder child_name_required">
		<a id="" class="child_name_checkbox check-off"></a>
		<h1 class="inline">Child’s Name</h1>
		<input type="hidden" value="0" name="is_child_name" class="child_name_hidden_cb" />
				
</div>

<div class="form-light-holder show_term_condition_required">
		<a id="status" class="show_term_condition_checkbox check-off"></a>
		<h1 class="inline">Show Terms & Conditions?</h1>
		<input type="hidden" value="0" name="show_term_condition" class="show_term_condition_hidden_cb" />
		
		
</div>

<div class="form-light-holder" style=" display:none" id="hide_show_term_condition">
	<h1>Terms & Conditions</h1>
	<textarea name="term_condition"  id="ckeditor_full_term_condition" class="ckeditor" ></textarea>
</div>


<!-- Upsell Section Start -->
<div class="form-light-holder upsale_required">
		<a id="status" class="upsale_checkbox check-off"></a>
		<h1 class="inline">Add Upsell? </h1>
		<input type="hidden" value="0" name="upsale" class="upsale_hidden_cb" />
</div>
<div id="upsale_option">
<!-- <div class=""><h3><a href="javascript:void(0);" class="AddMoreUpsale">Add Another Upsell</a></h3></div> -->

<div class="form-light-holder">

		<h1>Upsell Top Text</h1>		
		<textarea name="data[1][upsell_top_text]" class="ckeditor" id="upsell_top_text" style="height: 74px" ></textarea>
	</div>
	
<div class="form-light-holder d-md-flex  dual_input ">
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
	<span class="orButton">OR</span>
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
	<h1> Upsell Offer Title </h1>
	<input type="text" value="" name="data[1][up_title]" id="up_title" class="field full_width_input" placeholder=""/>	
	<br/><em>Example: Add a Uniform for only $19.99! (reg. $49))</em>
</div>

<div class="form-light-holder manage-pricerow">
	<h1> Upsell Offer Price</h1>
	<div class="price-validate">
	<?php echo $this->query_model->getSiteCurrencyTypeForAdmin() ?><input type="text" value="" name="data[1][up_price]" id="up_price" class="field up_price" number="1" placeholder="Enter Price"  style="width:100px"/>
	<div class="ErrorMessage ErrorMessage_up_price1"></div>
	</div>	
	
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		Please enter the amount in decimal form. Do not use any characters such as "$” or “%". Example: "49.99" or “7”.
	</div>
</div>

<div class="form-light-holder" style="display:none">
	<h1>Upsell “Yes Please! Text” Description</h1>
	<input type="text" value="" name="data[1][yes]" id="yes" class="field full_width_input" placeholder=""/>	
</div>
<div class="form-light-holder">
	<h1>Upsell “No Thank You! Text” Description</h1>
	<input type="text" value="" name="data[1][no]" id="no" class="field full_width_input" placeholder=""/>	
</div>

<div class="form-light-holder">
		<h1>Upsell Bottom Text</h1>		
		<textarea name="data[1][description]" class="ckeditor" id="sub_title" style="height: 74px" ></textarea>
	</div>	
<div class="form-light-holder" style="display:none">
	<h1>Upsell Text</h1>
	<input type="text" value="" name="data[1][text_1]" class="field" placeholder="" style="width:40%"/>	
</div>
	
</div>
<!-- Upsell Section End -->



   <!-- <div class="form-light-holder" id="paypal_email">
        <h1>Paypal Email Address</h1>
        <input type="text" value="<?=$special->paypal_email?>" name="email" id="email" class="field" placeholder="Enter paypal email address here"/>
    </div>-->

    
    <div class="form-white-holder" style="padding-bottom:20px;">
	<!-- <input type="hidden" name="cat_id" value="<?php echo $this->uri->segment(4); ?>"> -->
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
<input type="hidden" class="totalAddMoreFeatures" value="1"  />
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

<input type="hidden" class="totalAddMoreUpsales" value="1"  />
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
	$('#upsale_option').hide();
	
	
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
				$('#upsale_option').append('&nbsp;<div class="form-light-holder"><h1> Upsell #'+b+' Title</h1><input type="text" value="" name="data['+b+'][up_title]" id="up_title" class="field" placeholder="" style="width:40%"/></div><div class="form-light-holder manage-pricerow"><h1>Upsell #'+b+' Price</h1><div class="price-validate"><?php echo $this->query_model->getSiteCurrencyTypeForAdmin() ?><input type="text" required="required" value="" name="data['+b+'][up_price]" id="up_price" class="field up_price" number="'+b+'" placeholder="Enter Price" style="width:86%"/><div class="ErrorMessage ErrorMessage_up_price'+b+'"></div></div><div style="font-style:italic;font-size:11px;margin-left:12px;">Please enter the amount in decimal form. Do not use any characters such as "$” or “%". Example: "49.99" or “7”.	</div><div class="price-validate tax_hide_show"><div class="ErrorMessage ErrorMessage_sales_tax_main'+b+'"></div></div></div><div class="form-light-holder"><h1>Upsell #'+b+' “YES PLEASE! TEXT” DESCRIPTION</h1><input type="text" value="" name="data['+b+'][yes]" id="yes" class="field" placeholder="" style="width:40%"/></div><div class="form-light-holder"><h1>Upsell #'+b+'  “NO THANK YOU! TEXT” DESCRIPTION</h1><input type="text" value="" name="data['+b+'][no]" id="no" class="field" placeholder="" style="width:40%"/></div>');
			
		});



});
</script>

<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>