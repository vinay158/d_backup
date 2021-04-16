<?php $this->load->view("admin/include/header"); ?>
<?php $paymentDetail = $this->query_model->getbySpecific('tbl_payments','id',1);?>
<!-- end head contents -->
<!--wysiwyg editor script -->
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<!--<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>-->
<script src="js/ckeditor_full/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		
	
		CKEDITOR.replace(  'ckeditor_full',
									{  customConfig : 'config.js' }
						);
				CKEDITOR.replace(  'ckeditor_full_term_condition',
									{  customConfig : 'config.js' }
						);
				CKEDITOR.replace(  'offer_description', 
									{ customConfig : 'mini_half_configy.js' }
							);
		
	});
</script>
<div class="az-content-body-left advanced_page dojocart_edit_page" >

       <div class="row row-sm">

          <div class="col-sm-12 col-xl-12"  >
			<div class="card pd-sm-20 program-cat-page program-detail-page">
				<div class="container">
	  
	  
        
    <div class="az-content az-content-app az-content-contacts pd-b-0">
      <div class="container">
        <div class="az-content-left az-content-left-contacts">


         <div class="az-mail-header">
            <div>
              <h4 class="az-content-title mg-b-5">Template Sections</h4>
			   
				  
            </div>
            <div>
			
			
			</div>
          </div>
		
		<?php $page_url = ''; ?>
          <div id="azContactList" class="az-contacts-list">
			
			<a href="<?php echo $page_url; ?>#DojocartInfo" class="az-contact-item">
              <div class="az-contact-body">
                <h6>Dojocart Info</h6>
              </div>
            </a>
			<a href="<?php echo $page_url; ?>#BulletPoints" class="az-contact-item">
              <div class="az-contact-body">
                <h6>Right Sidebar Section</h6>
              </div>
            </a>
			<a href="<?php echo $page_url; ?>#PaymentTypes" class="az-contact-item">
              <div class="az-contact-body">
                <h6>Payment Setting & Upsells</h6>
              </div>
            </a>
			<a href="<?php echo $page_url; ?>#Term_Conditions" class="az-contact-item">
              <div class="az-contact-body">
                <h6>Terms & Conditions</h6>
              </div>
            </a>
			<a href="<?php echo $page_url; ?>#CouponCodes" class="az-contact-item">
              <div class="az-contact-body">
                <h6>Coupon Codes</h6>
              </div>
            </a>
			
			<a href="<?php echo $page_url; ?>#CustomFields" class="az-contact-item">
              <div class="az-contact-body">
                <h6>Custom Fields</h6>
              </div>
            </a>
			
			<a href="<?php echo $page_url; ?>#SeoMeta" class="az-contact-item">
              <div class="az-contact-body">
                <h6>Seo/Meta Details</h6>
              </div>
            </a>
			
			
			
			
          </div><!-- az-contacts-list -->

        </div> <!-- az-content-left -->
        <div class="az-content-body az-content-body-contacts">
			
				<div class="az-mail-header">
            <div>
              <h4 class="az-content-title mg-b-5">Add DojoCart:  <?php echo $this->session->userdata('dojo_cart_template'); ?> Template</h4>
            </div>
            
          </div>
				
				<div class=" edit-form edit_form_box">
				

<form id="blog_form" action="" method="post" enctype="multipart/form-data">
<style>
.ErrorMessage{color:#FF0000}
</style>
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
	
	
	/** updated 31-july-2018 **/
	var coupon_code_hidden_cb = $('.coupon_code_hidden_cb').val();
	if(coupon_code_hidden_cb == 1){
		$.each($('.coupon_discount_type'),function(){
			var discount_type = $(this).val();
			var number = $(this).attr('number');
			if(discount_type == "percent"){
				$('.amount_box'+number).hide();
				$('.percent_box'+number).show();
				$('.discount_amount'+number).attr('required',false);
				$('.discount_percent'+number).attr('required',true);
			}else{
				$('.amount_box'+number).show();
				$('.percent_box'+number).hide();
				$('.discount_amount'+number).attr('required',true);
				$('.discount_percent'+number).attr('required',false);
			}
		})
	}
	
	


});

$(document).ready(function(){




	$('.btn-save').click(function(){
		
	var error = true;
		if($('#title').val() == ''){
			$('.ErrorMessage_title').html(' *DojoCart Special Offer is Required');
			error = false;
		}

/*	   if($('#price').val() == ''){
			$('.ErrorMessage_price').html(' *Offer Price is Required');
			error = false;
		}*/
		
		/* if($('.hasDatepicker').val() == ''){
			$('.ErrorMessage_date').html(' *News Date is Required');
			error = false;
		}*/
	return error;
	});



	function limitText(limitField, limitCount, limitNum) {
		if (limitField.value.length > limitNum) {
			limitField.value = limitField.value.substring(0, limitNum);
		} else {
			limitCount.value = limitNum - limitField.value.length;
		}
	}

function validateDecimal(value) {
        var RE = /^\d*\.?\d*$/;
        if(RE.test(value)){
           return true;
        }else{
        	return false;
        }
    }

// Upsale Price

	$("body").on('keyup','.up_price',function(){
		var number= $(this).attr('number');
		var result = validateDecimal($(this).val());
		if(result == false){
			$(this).val('');
			$('.ErrorMessage_up_price'+number).html(' *Please add numeric only');
		}else{
			$('.ErrorMessage_up_price'+number).html('');
		}
		
	});

	// Upsale Percentage

	$("body").on('keyup','.sales_tax_main',function(){
		var number= $(this).attr('number');
		var result = validateDecimal($(this).val());
		if(result == false){
			$(this).val('');
			$('.ErrorMessage_sales_tax_main'+number).html(' *Please add numeric only');
		}else{
			$('.ErrorMessage_sales_tax_main'+number).html('');
		}
		
	});

	// Offer Price

		$("#price").keyup(function(){

		var result = validateDecimal($(this).val());
		//alert(result); return false;
		if(result == false){
		$('.ErrorMessage_price').html(' *Please add numeric only');
			error = false;
		}else{
			$('.ErrorMessage_price').html('');
		}
	});

	// Offer Percentage Price

		$("#sales_tax_main").keyup(function(){

		var result = validateDecimal($(this).val());
		//alert(result); return false;
		if(result == false){
		$('.ErrorMessage_sales_tax_main').html(' *Please add numeric only');
			error = false;
		}else{
			$('.ErrorMessage_sales_tax_main').html('');
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



});

</script>

<div class="page-section" id="DojocartInfo">
<div class="form-light-holder">
	<h1> Product Name</h1>
	<input type="text" value="" name="product_title" id="title" class="field full_width_input" placeholder="Enter Your Offer Name Here" style=""/>	
	<div class="ErrorMessage ErrorMessage_title"></div>
</div>

<div class="form-light-holder">
	<h1>SEO-Friendly-URL</h1>
	<?php echo base_url().'promo/'; ?>
	<input type="text" value="" name="slug" id="slug" class="field"/><br/>
    (This is the link to this DojoCart product page) 
	<br/>
	(Leave blank to use Title, or create your own (no spaces or characters))
</div>

<div class="form-light-holder" style="">
	<h1>Product Description</h1>
	<textarea name="product_description"  id="ckeditor_full" class="ckeditor" ></textarea>

</div>

<!--<div class="form-light-holder" style="overflow:auto;">
	<h1 style="padding-bottom: 5px;">Upload an Image for Your Offer </h1>
	<input type="file" name="userfile1" id="photo" accept="image/*" />
		<div>
		</div>
</div> -->
<div class="form-light-holder">
<h1>Logo</h1>
	<select name="override_logo" id="window" class="field">
	<!-- <option value="">-Select logo-</option> -->
	<?php foreach($override_logos as  $override_logo):?>
	<option value="<?=$override_logo->s_no?>" ><?=$override_logo->logo_name?></option>
	<?php endforeach;?>
	</select>
</div>

<div class="form-light-holder money_back_img_required">
		<a id="status" class="money_back_img_checkbox check-off"></a>
		<h1 class="inline">Show 100% Money Back Guarantee Image? </h1>
		<input type="hidden" value="0" name="money_back_img" class="money_back_img_hidden_cb" />
</div>

<div class="form-light-holder satisfaction_gurantee_img_required">
		<a id="status" class="satisfaction_gurantee_img_checkbox check-off"></a>
		<h1 class="inline">Show 100% Satisfaction Guarantee Image? </h1>
		<input type="hidden" value="0" name="satisfaction_gurantee_img" class="satisfaction_gurantee_img_hidden_cb" />
</div>


<!-- Choose Video Section Start-->
<div class="form-light-holder d-md-flex  dual_input   welcome_video">
	<div class="adsUrl form-group">
		<h1>Video Type</h1>
		<select name="video_type" id="" class="field videoType" >
		<option value="youtube_video">Youtube Video</option>
		<option value="vimeo_video" >Vimeo Video</option>
	</select>
	
	</div>
	<div class="linkTarget form-group">
	<div class="youtube_video">
	<h1>Video</h1>
	<input type="text" name="youtube_video" value="" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		ex: https://www.youtube.com/embed/Pu5p1kDbR9I
	</div>
	</div>
 	<span class="orButton">OR</span>
	<div class="vimeo_video">
	<h1>Vimeo Video</h1>
	<input type="text" name="vimeo_video" value="" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		ex: https://player.vimeo.com/video/22859566
	</div>
	</div>
	</div>
	
</div>
</div>

<!-- Choose Video Section Start-->

<div class="page-section" id="BulletPoints">
<div class="mb-3 main-content-label">Right Sidebar Section</div>

<div class="form-light-holder">
	<h1> Bullet Points Title</h1>
	<input type="text" value="" name="offer-title" id="offer-title" class="field full_width_input" placeholder="Enter Your Offer Headline Text Here" style=""/>	
</div>

 <div class="form-light-holder">
        <h1>Bullet Points</h1>
		<div id="AddMoreFeatures">
			<div class=""><h3><a href="javascript:void(0);" class="btn btn-outline-light AddMoreButton">Add Another Feature</a></h3></div>
			<span class="featureBox_1"><input type="text"  name="features[1]" id="features" value="" class="field"   placeholder="Enter Your Feature Text Here"/><br></span>
			<span class="featureBox_2"><input type="text"  name="features[2]" id="features" value="" class="field"   placeholder="Enter Your Feature Text Here"/><br></span>
			
		</div>
    </div>

 <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
    <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
    <link rel="stylesheet" href="/resources/demos/style.css" />
    <script>
    $(function() {
        $( "#date" ).datepicker({ dateFormat: "yy-mm-dd" });
		
		/** updated 31-july-2018 **/
		$( ".expiry_date" ).datepicker({ dateFormat: "yy-mm-dd" });
		$( "#publish_date" ).datepicker({ dateFormat: "yy-mm-dd" });
    });
    </script>

<div class="form-light-holder" style="">
	<h1> Bullet Points Description</h1>
	<textarea name="offer_description" id="offer_description" class="ckeditor"></textarea>
</div>

<div class="form-light-holder   d-md-flex   dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	<h1 style="padding-bottom: 5px;">Upload Sidebar Image </h1>
	<div class="custom-file half_width_custom_file">
	<input type="file" name="userfile2" class="custom-file-input" id="customFile1" accept="image/*">
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	
	</div>
	<div class="linkTarget form-group">
		<h1 >Image alt text</h1>
	<input value="" name="offer_image_alt_text" id="" class="field" placeholder="image alt text" type="text">
		</div>
</div>

</div>

<div class="page-section" id="PaymentTypes">
<div class="mb-3 main-content-label">Payment Setting & Upsells</div>

<div class="form-light-holder">
	<h1> Do you want to accept credit card payments for this product?</h1>
	<select name="payment_type" class="field payment_type">
	<option value="free">Free product</option>
	<?php if($paymentDetail[0]->authorize_net_payment == 1 || $paymentDetail[0]->braintree_payment == 1  || $paymentDetail[0]->stripe_payment == 1  || $paymentDetail[0]->stripe_ideal_payment == 1  ){ ?>
	<option value="paid">Paid product</option>
	<?php } ?>
	</select>	
</div>


<div id="hide_show_p_quant">

<div class="form-light-holder salestax_required">
		<a id="status" class="salestax_checkbox check-off"></a>
		<h1 class="inline">Add Sales Tax? </h1>
		<input type="hidden" value="0" name="sales_taxable" class="salestax_hidden_cb" />
</div>

<div class="form-light-holder manage-pricerow" >
<h1 class="inline">Product Price (<?php echo $this->query_model->getSiteCurrencyTypeForAdmin() ?>)</h1>
<div class="price-validate">
<input type="text" value="" name="price" id="price" class="field" placeholder="Enter Price" style="width:100px; margin-left: 10px;" /><div class="ErrorMessage ErrorMessage_price"></div>
</div>
<div class="price-validate tax_hide_show">
<h1 style="padding-left: 10px;">Sales Tax (%)</h1>
<input type="text" value="" name="sales_tax_main" id="sales_tax_main" class="field sales_tax_main" placeholder="%" style="width:100px; margin-left: 10px;" />
<div class="ErrorMessage ErrorMessage_sales_tax_main"></div>
</div>
<div style="font-style:italic;font-size:11px;margin-left:12px;">
		Please enter the amount in decimal form. Do not use any characters such as "$” or “%". Example: "49.99" or “7”.
	</div>
</div>		


<div class="form-light-holder showquantity_required" style="" >
	<a id="status" class="showquantity_checkbox check-off"></a>
		<h1 class="inline">Add Quantity Option? </h1>
		<input type="hidden" value="0" name="show_quantity" class="showquantity_hidden_cb" />
</div>

<!-- Upsell Section Start -->

<div class="form-light-holder upsale_required">
		<a id="status" class="upsale_checkbox check-off"></a>
		<h1 class="inline">Add Upsells? </h1>
		<input type="hidden" value="0" name="upsale" class="upsale_hidden_cb" />
</div>
<div id="upsale_option">
<div class=""><h3><a href="javascript:void(0);" class="btn btn-outline-light AddMoreUpsale">Add Another Upsell</a></h3></div>
<div class="multi_item_boxes">
<div class="form-light-holder">
	<h1><b>Upsell #1</b></h1>
	<h1> Upsell #1 Title</h1>
	<input type="text" value="" name="data[1][up_title]" id="up_title" class="field full_width_input" placeholder="" style="width:40%"/>	
</div>

<div class="form-light-holder manage-pricerow">
	<h1> Upsell #1 Price</h1>
	<div class="price-validate">
	<?php echo $this->query_model->getSiteCurrencyTypeForAdmin() ?><input type="text" value="" name="data[1][up_price]" id="up_price" class="field up_price" number="1" placeholder="Enter Price" style="width:100px"/>
	<div class="ErrorMessage ErrorMessage_up_price1"></div>
	</div>	
	<div class="price-validate tax_hide_show">
	<h1 style="padding-left: 10px;">Sales Tax (%)</h1>
		<input type="text" value=""  name="data[1][sales_tax]" id="sales_tax" class="field sales_tax_main" number="1" placeholder="%" style="width:100px; margin-left: 10px;" /><div class="ErrorMessage ErrorMessage_sales_tax_main1"></div>
	</div>

	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		Please enter the amount in decimal form. Do not use any characters such as "$” or “%". Example: "49.99" or “7”.
	</div>
</div>

<div class="form-light-holder">
<label class="ckbox">
	<input type="checkbox" name="data[1][is_qty_apply]" value="1" ><span>Show Quantity Option For Upsell? </span></label>
</div>	

<div class="form-light-holder">
	<h1>Upsell #1 “Yes Please! Text” Description</h1>
	<input type="text" value="" name="data[1][yes]" id="yes" class="field full_width_input" placeholder="" style="width:40%"/>	
</div>
<div class="form-new-holder">
	<h1>Upsell #1 “No Thank You! Text” Description</h1>
	<input type="text" value="" name="data[1][no]" id="no" class="field full_width_input" placeholder="" style="width:40%"/>	
</div>

	
</div>
</div>
<!-- Upsell Section End -->


</div>
</div>

<div class="page-section" id="Term_Conditions">
<div class="mb-3 main-content-label">Terms & Conditions</div>
<div class="form-light-holder show_term_condition_required">
		<a id="status" class="show_term_condition_checkbox check-off"></a>
		<h1 class="inline">Show Terms & Conditions?</h1>
		<input type="hidden" value="0" name="show_term_condition" class="show_term_condition_hidden_cb" />
		
		
</div>

<div class="form-light-holder" style="" id="hide_show_term_condition">
	<h1>Terms & Conditions</h1>
	<textarea name="term_condition"  id="ckeditor_full_term_condition" class="ckeditor" ></textarea>
</div>
</div>


<div class="page-section" id="CouponCodes">
<div class="mb-3 main-content-label">Coupon Codes</div>
<div class="form-light-holder coupon_code_required">
		<a id="status" class="coupon_code_checkbox check-off"></a>
		<h1 class="inline">Add Coupon Code?</h1>
		<input type="hidden" value="0" name="coupon_code" class="coupon_code_hidden_cb" />
</div>

<div class="addMoreCoupons"  style=" display:none" id="hide_coupon_code">
<h3><a href="javascript:void(0);" class="btn btn-outline-light  AddMoreCouponsButton">Add Coupon</a></h3>
<div class="form-light-holder multi_item_boxes">
		<div class="adsUrl">
				<h1>#1 Coupon Code Name </h1>
		<input value="" name="Coupons[1][coupon_code_name]" class="field coupon_required" placeholder=""  type="text" >	
			</div>
			<div class="linkTarget">
				
				<h1>Expiry Date</h1>
				<input type="text" value="" name="Coupons[1][expiry_date]" id="" class="field expiry_date  coupon_required" placeholder="yyyy-mm-dd" maxlength="10" />
			</div>
		
		<div class="adsUrl">
				<h1>#1 Discount Type</h1>
				<select name="Coupons[1][coupon_discount_type]" class="field coupon_discount_type" id="" number="1">
					<option value="amount">Amount</option>
					<option value="percent">Percent</option>
				</select>
	
				
			</div>
			<div class="linkTarget">
			
				<div class="amount_box1">
					<h1>#1 Value in Amount (<?php echo $this->query_model->getSiteCurrencyTypeForAdmin() ?>) </h1>
					<input type="text" value="" name="Coupons[1][coupon_discount_amount]" id="" number="1" class="field coupon_amount discount_amount1 coupon_required" placeholder="Value in Amount (<?php echo $this->query_model->getSiteCurrencyTypeForAdmin() ?>)"/>
					<div class="ErrorMessage ErrorMessage_price1" style="color:#ff0000"></div>
				</div>
				
				<div class="percent_box1" style="display:none">
					<h1>#1 Value in Percent (%)</h1>
					<input type="text" value="" name="Coupons[1][coupon_discount_percent]" id=""  number="1"  class="field coupon_percent discount_percent1" placeholder="Value in Percent (%)"  />
					<div class="ErrorMessage ErrorMessage_percent1" style="color:#ff0000"></div>
				</div>
			</div>
	
</div>
</div>
</div>


<div class="page-section" id="CustomFields">
<div class="mb-3 main-content-label">Custom Fields</div>
<h3><a href="javascript:void(0);" class="btn btn-outline-light  AddMoreCustomFields">Add Custom Fields</a></h3>
<div id="addMoreFields">
	
	
</div>
</div>

<script language="javascript">
$(document).ready(function(){
	$('#hide_show_p_quant').hide();
	$('#hide_show_term_condition').hide();
	$('#upsale_option').hide();
	$('.tax_hide_show').hide();

	$('.payment_type').change(function(){
		var type = $(this).val();
		if (type == 'free'){
			$('#price').attr('required', false);
			$('#hide_show_p_quant').hide();
		}else{
			$('#hide_show_p_quant').show();
			$('#price').attr('required', 'required');
		}

	});

// Publish button	

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


// Sales Taxable Item

$(".salestax_required .salestax_checkbox").click(function(){
		if($(this).hasClass("check-on")){
			$(this).removeClass("check-on");
			$(this).addClass("check-off");
			$(this).parents(".form-light-holder").children(".salestax_hidden_cb").val("0");
			//$('#up_price').attr('required', false);
			$('.tax_hide_show').hide();
			//var show_price = 0;
			
		}
		else
		{
			$(this).removeClass("check-off");
			$(this).addClass("check-on");
			$(this).parents(".form-light-holder").children(".salestax_hidden_cb").val("1");
			$('.tax_hide_show').show();
			//$('#up_price').attr('required', 'required');
			//var show_price = 1;
		}
	
});


// Show Quantity
$(".showquantity_required .showquantity_checkbox").click(function(){
		if($(this).hasClass("check-on")){
			$(this).removeClass("check-on");
			$(this).addClass("check-off");
			$(this).parents(".form-light-holder").children(".showquantity_hidden_cb").val("0");
			
		}
		else
		{
			$(this).removeClass("check-off");
			$(this).addClass("check-on");
			$(this).parents(".form-light-holder").children(".showquantity_hidden_cb").val("1");
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


// Coupon code
$(".coupon_code_required .coupon_code_checkbox").click(function(){
		if($(this).hasClass("check-on")){
			$(this).removeClass("check-on");
			$(this).addClass("check-off");
			$(this).parents(".form-light-holder").children(".coupon_code_hidden_cb").val("0");
			$('#hide_coupon_code').hide();
			$('.coupon_required,.coupon_percent').attr('required',false);
			//var show_price = 0;
			
		}
		else
		{
			$(this).removeClass("check-off");
			$(this).addClass("check-on");
			$(this).parents(".form-light-holder").children(".coupon_code_hidden_cb").val("1");
			$('#hide_coupon_code').show();
			$('.coupon_required').attr('required',true);
			//var show_price = 1;
		}
	
});


// Show 100% Money Back Guarantee Image? 
$(".money_back_img_required .money_back_img_checkbox").click(function(){
		if($(this).hasClass("check-on")){
			$(this).removeClass("check-on");
			$(this).addClass("check-off");
			$(this).parents(".form-light-holder").children(".money_back_img_hidden_cb").val("0");
		}
		else
		{
			$(this).removeClass("check-off");
			$(this).addClass("check-on");
			$(this).parents(".form-light-holder").children(".money_back_img_hidden_cb").val("1");
		}
	
});


// Coupon code
$(".satisfaction_gurantee_img_required .satisfaction_gurantee_img_checkbox").click(function(){
		if($(this).hasClass("check-on")){
			$(this).removeClass("check-on");
			$(this).addClass("check-off");
			$(this).parents(".form-light-holder").children(".satisfaction_gurantee_img_hidden_cb").val("0");
		}
		else
		{
			$(this).removeClass("check-off");
			$(this).addClass("check-on");
			$(this).parents(".form-light-holder").children(".satisfaction_gurantee_img_hidden_cb").val("1");
		}
	
});

});
</script>

<div class="page-section" id="SeoMeta">
<div class="mb-3 main-content-label">Seo/Meta Details</div>

<div class="form-light-holder">
	<h1> Meta Title</h1>
	<input type="text" value="" name="meta_title" id="" class="field full_width_input" placeholder="" style=""/>	

</div>

<div class="form-light-holder">
	<h1> Meta Description</h1>
	<textarea name="meta_desc" id="frm-text"></textarea>
	use following variable to replace relevent values<br>

        {school_name}, {city}, {state}, {city state}, {county}<br>

        {nearby_location1}, {nearby_location2}, <br>

        {main_martial_arts_style}, {martial_arts_style}

    
</div>
<div class="form-light-holder   d-md-flex  dual_input">
	<div class="adsUrl form-group">
		<h1>Body Class</h1>
		<input type="text" name="body_class" class="field" value="">
	</div>
	
	<div class="linkTarget form-group">
		<h1>Body Id</h1>
		<input type="text" name="body_id" class="field" value="">
	</div>
</div>

<div class="form-light-holder  d-md-flex  dual_input">
	<div class="adsUrl form-group">
		
		<h1>Unique Email Address</h1>
		<input type="text" name="unique_email_address" class="field" value="">
	</div>
	
	<div class="linkTarget form-group">
		<h1>Submit button text</h1>
		<input type="text" name="submit_btn_text" class="field" value="">
	</div>
</div>

		
<script>
$(window).load(function(){
	
	$.each( $( ".show_location_type" ), function() {
		if($(this).attr('checked') == 'checked'){
			var show_location_type = $(this).val();
	
			if(show_location_type == "select_location"){
				$('.locationSelectBox').attr('required' , true);
				$('.locationsDropdown').show();
			}else{
				$('.locationSelectBox').attr('required' , false);
				$('.locationsDropdown').hide();
			}
		}
	});
});

	$(document).ready(function(){
		$('.show_location_type').click(function(){
			var show_location_type = $(this).val();
			if(show_location_type == "select_location"){
				$('.locationSelectBox').attr('required' , true);
				$('.locationsDropdown').show();
			}else{
				$('.locationSelectBox').attr('required' , false);
				$('.locationsDropdown').hide();
			}
		});
	});
</script>
	
<div class="form-light-holder">

<div class="row row-xs align-items-center">
	<div class="col-md-12">
		<label class="form-label mg-b-0"><h1>SHOW ALL LOCATIONS Or SELECT LOCATIONS TO SHOW</h1></label>
	</div>
	<div class="col-md-12  mg-t-5 mg-md-t-0">
	<div class="row mg-t-10">
		<div class="col-lg-4">
		  <label class="rdiobox">
			<input type="radio" class="show_location_type" name="show_location_type" value="show_all" checked="checked" /> <span>SHOW ALL LOCATIONS</span>
		  </label>
		</div><!-- col-3 -->
		<div class="col-lg-8 mg-t-20 mg-lg-t-0">
		  <label class="rdiobox">
			<input type="radio" class="show_location_type" name="show_location_type" value="select_location"  /><span>SELECT LOCATIONS TO SHOW</span>
		  </label>
		</div><!-- col-3 -->
		</div>
	</div>
</div>
</div>

<?php 
	if(!empty($dojo_cart_allLocations)){
		
?>
<div class="form-light-holder locationsDropdown">
	<h1>Locations</h1>
		<select name="locations[]" id="" class="field locationSelectBox" required='true' multiple="true" style="height:200px">
		<?php foreach($dojo_cart_allLocations as $location){ ?>
			<option value="<?php echo $location->id; ?>"><?php echo $location->name; ?></option>
		<?php } ?>
	</select>
</div>
<?php } ?>
 <div class="form-light-holder">
	<a id="published" class="checkbox check-on"></a>
	<h1 class="inline">Publish This</h1>
	<input type="hidden" value="1" name="published" class="hidden_cb" />
	&nbsp;
    (if left blank, post will be published immediately)
</div>
</div>


		

	<div class="tx-center pd-y-20 bg-gray-200" id="bottom"> 
				<input type="hidden" value="<?php echo $this->session->userdata('dojo_cart_template'); ?>" name="template" class="hidden_cb" />
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


	
<input type="hidden" class="totalAddMoreFeatures" value="2"  />
<input type="hidden" class="totalAddMoreUpsales" value="1"  />
<input type="hidden" class="totalAddMoreCoupons" value="1"  />
<input type="hidden" class="totalAddMoreCustomFields" value="0"  />

<script language="javascript" type="text/javascript">
 	
	$(document).ready(function(){
		
		/** updated 31-july-2018 **/	
	function validateDecimal(value) {
        var RE = /^\d*\.?\d*$/;
        if(RE.test(value)){
           return true;
        }else{
        	return false;
        }
    }


			$('.AddMoreButton').click(function(){
			var totalAddMoreFeatures = $('.totalAddMoreFeatures').val();
			var i = parseInt(totalAddMoreFeatures) + Number(1);
			$('.totalAddMoreFeatures').val(i);
			
				$('#AddMoreFeatures').append('<span class="featureBox_'+i+'"><input type="text"  name="features['+i+']" id="features" class="field" placeholder="Enter Your Feature Text Here"/>&nbsp; &nbsp; <i class="fa fa-times" style="cursor:pointer;" onclick="$(this).parent().remove();"></i><br></span>');
			
		});
		
		

			$('.AddMoreUpsale').click(function(){
			var totalAddMoreUpsales = $('.totalAddMoreUpsales').val();
			var b = parseInt(totalAddMoreUpsales) + Number(1);
			$('.totalAddMoreUpsales').val(b);
				$('#upsale_option').append('<div class="multi_item_boxes"><div class="form-light-holder"><h1><b>Upsell #'+b+'</b></h1><h1> Upsell #'+b+' Title</h1><input type="text" value="" name="data['+b+'][up_title]" id="up_title" class="field full_width_input" placeholder=""/></div><div class="form-light-holder manage-pricerow"><h1>Upsell #'+b+' Price</h1><div class="price-validate"><?php echo $this->query_model->getSiteCurrencyTypeForAdmin() ?><input type="text" required="required" value="" name="data['+b+'][up_price]" id="up_price" class="field up_price" number="'+b+'" placeholder="Enter Price" style="width:100px"/><div class="ErrorMessage ErrorMessage_up_price'+b+'"></div></div><div class="price-validate tax_hide_show"><h1 style="padding-left: 10px;">Sales Tax (%)</h1><input type="text" value=""  name="data['+b+'][sales_tax]" id="sales_tax" class="field sales_tax_main" number="'+b+'" placeholder="%" style="width:100px; margin-left: 10px;" /><div class="ErrorMessage ErrorMessage_sales_tax_main'+b+'"></div></div></div><div class="form-light-holder"><label class="ckbox"><input type="checkbox" name="data['+b+'][is_qty_apply]" value="1" ><span>Show Quantity Option For Upsell?</span></label></div><div class="form-light-holder"><h1>Upsell #'+b+' “YES PLEASE! TEXT” DESCRIPTION</h1><input type="text" value="" name="data['+b+'][yes]" id="yes" class="field full_width_input" placeholder="" /></div><div class="form-new-holder"><h1>Upsell #'+b+'  “NO THANK YOU! TEXT” DESCRIPTION</h1><input type="text" value="" name="data['+b+'][no]" id="no" class="field full_width_input" placeholder="" /></div></div>');
			
		});

$('.AddMoreCouponsButton').click(function(){
			var totalAddMoreCoupons = $('.totalAddMoreCoupons').val();
			var k = parseInt(totalAddMoreCoupons) + Number(1);
			$('.totalAddMoreCoupons').val(k);
			
				
				$('.addMoreCoupons').append('<div class="form-light-holder multi_item_boxes" style="position:relative"><div class="adsUrl"><h1>#'+k+' Coupon Code Name</h1><input value="" name="Coupons['+k+'][coupon_code_name]" class="field coupon_required" placeholder="" type="text" required></div><div class="linkTarget"><h1>Expiry Date</h1><input value="" name="Coupons['+k+'][expiry_date]" id="exp_datepicker'+k+'" class="field" placeholder="yyyy-mm-dd" maxlength="10" required="" type="text"></div><div class="adsUrl"><h1>#'+k+' Discount Type</h1><select name="Coupons['+k+'][coupon_discount_type]" class="field coupon_discount_type" id="" number="'+k+'"><option value="amount" selected="selected">Amount</option><option value="percent">Percent</option></select></div><div class="linkTarget"><div class="amount_box'+k+'" ><h1>#'+k+' Value in Amount (<?php echo $this->query_model->getSiteCurrencyTypeForAdmin() ?>) </h1><input value="" name="Coupons['+k+'][coupon_discount_amount]" id="" number="'+k+'" class="field coupon_amount discount_amount'+k+'" placeholder="Value in Amount (<?php echo $this->query_model->getSiteCurrencyTypeForAdmin() ?>)" type="text" required><div class="ErrorMessage ErrorMessage_price'+k+'" style="color:#ff0000"></div></div><div class="percent_box'+k+'" style="display:none"><h1>#'+k+' Value in Percent (%)</h1><input value="" name="Coupons['+k+'][coupon_discount_percent]" id="" number="'+k+'" class="field coupon_percent discount_percent'+k+'" placeholder="Value in Percent (%)" type="text"><div class="ErrorMessage ErrorMessage_percent'+k+'" style="color:#ff0000"></div></div></div><i class="fa fa-close" style="cursor:pointer; right:0px; top:10px; position:absolute;color:red" onclick="$(this).parent().remove();"> Delete</i></div>');
				
				
				$( "#exp_datepicker"+k).datepicker({ dateFormat: "yy-mm-dd" });
			
		});
		
		
		
		// add more custom fields
		$('.AddMoreCustomFields').click(function(){
			
			var custom_field_box = $('.custom_field_box').length;
			if(custom_field_box >= 10){
				alert('You Have Already Added 10 Custom Fileds'); return false;
			}
			
			var totalAddMoreCustomFields = $('.totalAddMoreCustomFields').val();
			var k = parseInt(totalAddMoreCustomFields) + Number(1);
			$('.totalAddMoreCustomFields').val(k);
			
			
				$('#addMoreFields').append('<div class="custom_field_box multi_item_boxes"><h1><b>Custom Field #'+k+'</b></h1><i class="fa fa-close" style="cursor:pointer; right:15px; top:10px;color:red; float:right" onclick="$(this).parent().remove();"> Delete</i><div class="form-new-holder"><h1>Field Type</h1><select name="custom_field['+k+'][type]" class="field field_type" number="'+k+'"><option value="text">Text</option><option value="dropdown">Dropdown</option><option value="checkbox">Checkbox</option></select></div><div class="form-new-holder"><h1>Label Text</h1><input value="" name="custom_field['+k+'][label_text]" class="field" placeholder="" type="text"></div><div class="drodownbox_'+k+'" number="'+k+'" style="display:none"><div class="form-new-holder"><a href="javascript:void(0);" class="btn btn-outline-light AddMoreDropdownValues"  number="'+k+'">Add Values</a><h1>Value #1</h1><input value="" name="custom_field['+k+'][dropdown_values][1]" class="field" placeholder="" type="text"></div><div class="add_moreDropdownValues'+k+'"></div><input type="hidden" class="totalAddMoreDropdownValues_'+k+'" value="1"  /></div></div>');
				
			
			
		});
		
		$('body').on('click','.AddMoreDropdownValues',function(){
			var number = $(this).attr('number');
			var totalAddMoreDropdownValues = $('.totalAddMoreDropdownValues_'+number).val();
			var m = parseInt(totalAddMoreDropdownValues) + Number(1);
			$('.totalAddMoreDropdownValues_'+number).val(m);
			//alert(m);
			$('.add_moreDropdownValues'+number).append('<div class="form-new-holder"><h1>Value #'+m+'</h1><input value="" name="custom_field['+number+'][dropdown_values]['+m+']" class="field" placeholder="" type="text"><i class="fa fa-close" style="cursor:pointer; right:15px; top:10px;color:red" onclick="$(this).parent().remove();"> Delete</i></div>');
			
		})
		
		$('body').on('change','.field_type',function(){
			var field_type = $(this).val();
			var number = $(this).attr('number');
			
			if(field_type == "dropdown" || field_type == "checkbox"){
				$('.drodownbox_'+number).show();
			}else{
				$('.drodownbox_'+number).hide();
			}
		})
		

		
		
		/** updated 31-july-2018 **/
		$('body').on('change','.coupon_discount_type',function(){
			var discount_type = $(this).val();
			var number = $(this).attr('number');
			if(discount_type == "percent"){
				$('.amount_box'+number).hide();
				$('.percent_box'+number).show();
				$('.discount_amount'+number).attr('required',false);
				$('.discount_percent'+number).attr('required',true);
			}else{
				$('.amount_box'+number).show();
				$('.percent_box'+number).hide();
				$('.discount_amount'+number).attr('required',true);
				$('.discount_percent'+number).attr('required',false);
			}
		})
		
		
		
		$("body").on('keyup','.coupon_amount',function(){
	
			var result = validateDecimal($(this).val());
			var number = $(this).attr('number');
			
			if(result == false){
			
				$(this).val('');
			$('.ErrorMessage_price'+number).html(' *Please add numeric only');
				error = false;
			}else{
				$('.ErrorMessage_price'+number).html('');
			}
		});
		
		
		$("body").on('keyup','.coupon_percent',function(){
			
			var result = validateDecimal($(this).val());
			
			var number = $(this).attr('number');
			//alert(result); return false;
			if(result == false){
				$(this).val('');
			$('.ErrorMessage_percent'+number).html(' *Please add numeric only');
				error = false;
			}else{
				$('.ErrorMessage_percent'+number).html('');
			}
		});
		
		
		
	});	 
	
</script>


<!-- recent items -->
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

</script>
