<?php $this->load->view("admin/include/header"); ?>
<?php $paymentDetail = $this->query_model->getbySpecific('tbl_payments','id',1); ?>
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
<?php $deatail = $details[0];?>
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
              <h4 class="az-content-title mg-b-5">Edit DojoCart:   <?php echo $deatail->template; ?> Template</h4>
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
			$(this).val('');
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


	$('.btn-save').click(function(){
		
	var error = true;
		if($('#title').val() == ''){
			$('.ErrorMessage_title').html(' *DojoCart Special Offer is Required');
			error = false;
		}
		
		/* if($('.hasDatepicker').val() == ''){
			$('.ErrorMessage_date').html(' *News Date is Required');
			error = false;
		}*/
	return error;
	});
	$("#main_title").keyup(function(){
		$("#sef_title").html($(this).val());
	})



	$("#delete_img").click(function(){
				
		var dojo_cart_id = $('#dojo_cart_id').val();
		var image_path=$('#img').attr('src');
					
		var mod_type = 'dojocart';
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/'+mod_type+'/delete',						
		data: { dojo_cart_id : dojo_cart_id,image_path:image_path }					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			setTimeout("window.location.href='admin/dojocart/edit/"+dojo_cart_id+"'",1000);
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});

	});

		$("#delete_img_offer").click(function(){
				
		var dojo_cart_id = $('#dojo_cart_id').val();
		var image_path=$('#img2').attr('src');
					
		var mod_type = 'dojocart';
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/'+mod_type+'/deleteOfferImg',						
		data: { dojo_cart_id : dojo_cart_id,image_path:image_path }					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			setTimeout("window.location.href='admin/dojocart/edit/"+dojo_cart_id+"'",1000);
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});

	});


			$(".delete_features").click(function(){
				
		var dojo_cart_id = $('#dojo_cart_id').val();
		var value=$(this).attr('feature');
		var number = $(this).attr('number');

		var mod_type = 'dojocart';
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/'+mod_type+'/deleteFeature',						
		data: { dojo_cart_id : dojo_cart_id,value:value }					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			$('.featureBox_'+number).remove();
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});

	});


	function limitText(limitField, limitCount, limitNum) {
		if (limitField.value.length > limitNum) {
			limitField.value = limitField.value.substring(0, limitNum);
		} else {
			limitCount.value = limitNum - limitField.value.length;
		}
	}
	
	
	$(".deleteCustomField").click(function(){
				
		var custom_field_id = $(this).attr('custom_field_id');
					
		var mod_type = 'dojocart';
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/'+mod_type+'/deleteCustomField',						
		data: { custom_field_id : custom_field_id}					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			$('.custom_box_'+custom_field_id).remove();
			//setTimeout("window.location.href='admin/dojocart/edit/"+dojo_cart_id+"'",1000);
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});

	});

	
});
</script>


<div class="page-section" id="DojocartInfo">
<div class="form-light-holder">
	<h1> Product Name</h1>
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($deatail->product_title); ?>" name="product_title" id="title" class="field full_width_input" placeholder="Enter Your Offer Name Here" style=""/>	
	<div class="ErrorMessage ErrorMessage_title"></div>
</div>

<div class="form-light-holder">
	<h1>SEO-Friendly-URL</h1>
	<?php echo base_url().'promo/'; ?>
	<input type="text" value="<?php echo $deatail->slug; ?>" name="slug" id="slug" class="field"/>&nbsp;
    (This is the link to this DojoCart product page) 
	<br/>
	(Leave blank to use Title, or create your own (no spaces or characters))
	
</div>

<div class="form-light-holder" style="padding-bottom:30px;">
	<h1>Product Description</h1>
	<textarea name="product_description"  id="ckeditor_full" class="ckeditor" ><?php echo $deatail->product_description; ?></textarea>
</div>


<!--<div class="form-light-holder" style="overflow:auto;">

	<?php if(!empty($deatail->product_image)) { echo "<img id='img' src='upload/dojocarts/".$deatail->product_image."' width='120' >";
	}
	?>
	<input type="hidden" name="old_product_image" id="old-image" value="<?=$deatail->product_image?>" />
	<h1 style="padding-bottom: 5px;">Upload an Image for Your Offer</h1>
	<input type="file" name="userfile1" id="photo" accept="image/*" />
	<?php if($deatail->product_image){ 
			echo "<a href='javascript:void(0);' class='delete_image_btn_new'  id='delete_img'>Delete image</a>";
			}
	?>	
</div> -->

<div class="form-light-holder">
<h1>Logo</h1>
	<select name="override_logo" id="window" class="field">
	<!-- <option value="">-Select logo-</option> -->
	<?php foreach($override_logos as  $override_logo):?>
	<option value="<?=$override_logo->s_no?>"  <?php if(!empty($deatail) && $deatail->override_logo == $override_logo->s_no){ echo 'selected=selected';} ?>><?=$override_logo->logo_name?></option>
	<?php endforeach;?>
	</select>
</div>

<div class="form-light-holder money_back_img_required">
		<a id="status" class="money_back_img_checkbox <?php if($deatail->money_back_img == 1) echo "check-on"; else echo "check-off"; ?>"></a>
		<h1 class="inline">Show 100% Money Back Guarantee Image? </h1>
		<input type="hidden" value="<?php echo !empty($deatail) ? $deatail->money_back_img : 0; ?>" name="money_back_img" class="money_back_img_hidden_cb" />
</div>

<div class="form-light-holder satisfaction_gurantee_img_required">
		<a id="status" class="satisfaction_gurantee_img_checkbox  <?php if($deatail->satisfaction_gurantee_img == 1) echo "check-on"; else echo "check-off"; ?>"></a>
		<h1 class="inline">Show 100% Satisfaction Guarantee Image? </h1>
		<input type="hidden" value="<?php echo !empty($deatail) ? $deatail->money_back_img : 0; ?>" name="satisfaction_gurantee_img" class="satisfaction_gurantee_img_hidden_cb" />
</div>

<div class="form-light-holder d-md-flex  dual_input   welcome_video">
	<div class="adsUrl form-group">
		<h1>Video Type</h1>
		<select name="video_type" id="" class="field videoType" >
		<option value="youtube_video" <?php if($deatail->video_type == 'youtube_video'){ echo 'selected=selected'; } ?>>Youtube Video</option>
		<option value="vimeo_video" <?php if($deatail->video_type == 'vimeo_video'){ echo 'selected=selected'; } ?>  >Vimeo Video</option>
	</select>
	
	</div>
	<div class="linkTarget form-group">
	<div class="youtube_video">
	<h1>Youtube Video</h1>
	<input type="text" name="youtube_video" value="<?=$deatail->youtube_video;?>" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		ex: https://www.youtube.com/embed/Pu5p1kDbR9I
	</div>
	</div>
	<span class="orButton">OR</span>
	<div class="vimeo_video">
	<h1>Vimeo Video</h1>
	<input type="text" name="vimeo_video" value="<?=$deatail->vimeo_video;?>" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		ex: https://player.vimeo.com/video/22859566
	</div>
	</div>
	</div>
	
</div>
</div>


<div class="page-section" id="BulletPoints">
<div class="mb-3 main-content-label">Right Sidebar Section</div>
<div class="form-light-holder">
	<h1> Bullet Points Title</h1>
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($deatail->offer_title); ?>" name="offer-title" id="offer-title" class="field full_width_input" placeholder="Enter Your Offer Headline Text Here" style=""/>	
</div>

 <div class="form-light-holder">
        <h1> Bullet Points</h1>
		<div id="AddMoreFeatures">
			<div class=""><h3><a href="javascript:void(0);" class="btn btn-outline-light AddMoreButton">Add Another Feature</a></h3></div>
			<?php 
			
			$features = unserialize($deatail->features);
			
					if(!empty($features)){
					$i = 1;
					foreach($features as $feature){
			 ?>
			 <span class="featureBox_<?= $i ?>">
			
        	&#10687; <input type="text"  name="features[<?= $i ?>]" id="features" value="<?php echo $this->query_model->getStrReplaceAdmin( $feature); ?>" class="field"   placeholder="Enter Features here"/>&nbsp; &nbsp; <a feature="<?php echo $feature; ?>" number="<?= $i ?>" href="javascript:void(0)" class="delete_features " > <i class="fa fa-times" ></i> </a>
			
			<br>
			
			<?php $i++; ?></span>
				
			<?php }  } else { ?>
			<span class="featureBox_1">&#10687; <input type="text"  name="features[1]" id="features" value="" class="field"   placeholder="Enter Your Feature Text Here"/><br></span>
			<span class="featureBox_2">&#10687; <input type="text"  name="features[2]" id="features" value="" class="field"   placeholder="Enter Your Feature Text Here"/><br></span>
			<?php } ?>
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


<div class="form-light-holder" style="padding-bottom:30px;">
	<h1> Bullet Points Description</h1>
	<textarea name="offer_description" id="offer_description" class="ckeditor"><?php echo $deatail->offer_description; ?></textarea>
</div>

<div class="form-light-holder  d-md-flex   dual_input" style="overflow:auto;">
		<div class="adsUrl form-group">
		<h1 style="padding-bottom: 5px;">Upload Sidebar Image </h1>
		<div class="custom-file half_width_custom_file">
	<input type="file" name="userfile2" class="custom-file-input" id="customFile1" accept="image/*">
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	
	<?php if(!empty($deatail->offer_image)) { echo "<div><img id='img2' src='upload/dojocarts/".$deatail->offer_image."' width='120' ></div>";
	}
	?>
	<input type="hidden" name="old_offer_image" id="old_offer_image" value="<?=$deatail->offer_image?>" />
	
		<?php if($deatail->offer_image){ 
			echo "<a href='javascript:void(0);' id='delete_img_offer' class='delete_image_btn_new' >Delete image</a>";
			}
	?>
		</div>
	<div class="linkTarget form-group">
		<h1 >Image alt text</h1>
	<input value="<?php echo $this->query_model->getStrReplaceAdmin($deatail->offer_image_alt_text); ?>" name="offer_image_alt_text" id="" class="field" placeholder="image alt text" type="text">
		</div>
</div>
</div>

<!-- Show price, quantity, upsell if paid start -->

<div class="page-section" id="PaymentTypes">
<div class="mb-3 main-content-label">Payment Setting & Upsells</div>
<div class="form-light-holder">
	<h1>Do you want to accept credit card payments for this product?</h1>
	<select name="payment_type" class="field payment_type">
	<option value="free"<?php if($deatail->payment_type == "free"){ echo "selected";} ?>>Free product</option>
	<option value="paid"<?php if($deatail->payment_type == "paid"){ echo "selected";} ?>>Paid product</option>
	</select>	
</div>
<div id="hide_show_p_quant">

<div class="form-light-holder salestax_required">
		<a id="status" class="salestax_checkbox <?php if($deatail->sales_taxable == 1) echo "check-on"; else echo "check-off"; ?>"></a>
		<h1 class="inline">Add Sales Tax?</h1>
		<input type="hidden" value="<?= $deatail->sales_taxable ;?>" name="sales_taxable" class="salestax_hidden_cb" />
</div>

		<div class="form-light-holder manage-pricerow">
		<h1 class="inline">Product Price (<?php echo $this->query_model->getSiteCurrencyTypeForAdmin() ?>)</h1>
		<div class="price-validate">
		<input type="text" value="<?php echo $deatail->price; ?>" name="price" id="price" class="field " placeholder="Enter Price" style="width:100px; margin-left: 10px;" /><div class="ErrorMessage ErrorMessage_price"></div> </div>
		<div class="price-validate tax_hide_show">
		<h1 style="padding-left: 10px;">Sales Tax (%)</h1>
		<input type="text" value="<?php echo $deatail->sales_tax_main; ?>" name="sales_tax_main" id="sales_tax_main" class="field sales_tax_main" placeholder="%" style="width:100px; margin-left: 10px;" /><div class="ErrorMessage ErrorMessage_sales_tax_main"></div>
		</div>
			<div style="font-style:italic;font-size:11px;margin-left:12px;">
			Please enter the amount in decimal form. Do not use any characters such as "$” or “%". Example: "49.99" or “7”.
			</div>
		

		</div>

		<div class="form-light-holder showquantity_required">
		<a id="status" class="showquantity_checkbox <?php if($deatail->show_quantity == 1) echo "check-on"; else echo "check-off"; ?>"></a>
		<h1 class="inline">Add Quantity Option? </h1>
		<input type="hidden" value="<?php echo $deatail->show_quantity; ?>" name="show_quantity" class="showquantity_hidden_cb" />
		</div>

<!-- Upsell Section Start -->
<div class="form-light-holder upsale_required">
		<a id="status" class="upsale_checkbox <?php if($deatail->upsale == 1) echo "check-on"; else echo "check-off"; ?>"></a>
		<h1 class="inline">Add Upsells? </h1>
		<input type="hidden" value="<?= $deatail->upsale ;?>" name="upsale" class="upsale_hidden_cb" />
</div>

<div id="upsale_option">
<div class=""><h3><a href="javascript:void(0);" class="btn btn-outline-light AddMoreUpsale">Add Another Upsell</a></h3></div>
	<?php if(!empty($upsells)){ 
				$a = 1;
				foreach($upsells as $upsell_opt){
	?>
<div class="multi_item_boxes">
<div class="">

<a href="javascript:void(0)" class="delete_upsell delete_image_btn_new" number="<?=$upsell_opt->id?>">Delete Upsell #<?= $a ?></a>
<h1><b>Upsell #<?= $a ?></b></h1>

</div>
<div class="form-light-holder">
	
	<h1>Upsell # <?= $a ?>  Title</h1>
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($upsell_opt->up_title); ?>" name="data[<?= $a ?>][up_title]" id="up_title" class="field full_width_input" placeholder=""/>
</div>	
<div class="form-light-holder manage-pricerow">
	<h1>Upsell # <?= $a ?> Price</h1>
	<div class="price-validate">
	<?php echo $this->query_model->getSiteCurrencyTypeForAdmin() ?><input type="text" value="<?=$upsell_opt->up_price?>" name="data[<?= $a ?>][up_price]" id="up_price" class="field up_price" number="<?= $a ?>" placeholder="" style="width:100px"/><div class="ErrorMessage ErrorMessage_up_price<?= $a ?>"></div>
	</div>
	<div class="price-validate tax_hide_show">
	<h1 style="padding-left: 10px;">Sales Tax (%)</h1>	
	<input type="text" value="<?=$upsell_opt->sales_tax?>"  name="data[<?= $a ?>][sales_tax]" id="sales_tax" class="field sales_tax_main" number="<?= $a ?>" placeholder="%" style="width:100px; margin-left: 10px;" /><div class="ErrorMessage ErrorMessage_sales_tax_main<?= $a ?>"></div>
	</div>
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		Please enter the amount in decimal form. Do not use any characters such as "$” or “%". Example: "49.99" or “7”.
	</div>

</div>
<div class="form-light-holder"><label class="ckbox">
	<input type="checkbox" name="data[<?= $a ?>][is_qty_apply]" value="1" <?php echo ($upsell_opt->is_qty_apply == 1) ? 'checked=checked' : '';?>> <span> Show Quantity Option For Upsell? </span></label>
</div>
<div class="form-light-holder">
	<h1>Upsell # <?= $a ?> “Yes Please! Text” Description</h1>
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($upsell_opt->yes)?>" name="data[<?= $a ?>][yes]" id="yes" class="field full_width_input" placeholder=""/>	
</div>
<div class="form-new-holder">
	<h1>Upsell # <?= $a ?> “No Thank You! Text” Description</h1>
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($upsell_opt->no)?>" name="data[<?= $a ?>][no]" id="no" class="field full_width_input" placeholder=""/>	
</div>
</div>
	<?php 
			$a++; 
		}
	 } else { 
?>
<div class="multi_item_boxes">
<div class="form-light-holder">
	<h1><b>Upsell #1</b></h1>
	<h1>Upsell #1 Title</h1>
	<input type="text" value="" name="data[1][up_title]" id="up_title" class="field full_width_input" placeholder="" style="width:40%"/>	
</div>
<div class="form-light-holder manage-pricerow">
	<h1>Upsell #1 Price</h1>
	<div class="price-validate">
	<?php echo $this->query_model->getSiteCurrencyTypeForAdmin() ?><input type="text" value="" name="data[1][up_price]" id="up_price" class="field up_price" number="1" placeholder="Enter Price" style="width:100px"/>
		<div class="ErrorMessage ErrorMessage_up_price1"></div>
	</div>
	<div class="price-validate tax_hide_show">
	<h1 style="padding-left: 10px;">Sales Tax (%)</h1>
	<input type="text" value=""  name="data[1][sales_tax]" id="sales_tax" class="field sales_tax_main" number="1" placeholder="%" style="width:100px; margin-left: 10px;" />
	<div class="ErrorMessage ErrorMessage_sales_tax_main1"></div>
</div>

	</div>

<div class="form-light-holder"><label class="ckbox">
	<input type="checkbox" name="data[1][is_qty_apply]" value="1" > <span> Show Quantity Option For Upsell? <span></label>
</div>		
<div class="form-light-holder">
	<h1>Upsell #1 “Yes Please! Text” Description</h1>
	<input type="text" value="" name="data[1][yes]" id="yes" class="field full_width_input" placeholder=""/>	
</div>
<div class="form-new-holder">
	<h1>Upsell #1 “No Thank You! Text” Description</h1>
	<input type="text" value="" name="data[1][no]" id="no" class="field full_width_input" placeholder=""/>	
</div>
</div>
<?php } ?>
	
</div>
</div>
<!-- Upsell Section End -->


</div>
<!-- Show price, quantity, upsell if paid end-->

<div class="page-section" id="Term_Conditions">
<div class="mb-3 main-content-label">Terms & Conditions</div>
<div class="form-light-holder show_term_condition_required">
		<a id="status" class="show_term_condition_checkbox <?php if($deatail->show_term_condition == 1) echo "check-on"; else echo "check-off"; ?>"></a>
		<h1 class="inline">Show Terms & Conditions</h1>
		<input type="hidden" value="<?php echo $deatail->show_term_condition ?>" name="show_term_condition" class="show_term_condition_hidden_cb" />
				
</div>

<div class="form-light-holder" style="padding-bottom:30px;" id="hide_show_term_condition">
	<h1>Terms & Conditions</h1>
	<textarea name="term_condition"  id="ckeditor_full_term_condition" class="ckeditor" ><?php echo $deatail->term_condition; ?></textarea>
</div>
</div>

<div class="page-section" id="CouponCodes">
<div class="mb-3 main-content-label">Coupon Codes</div>
<div class="form-light-holder coupon_code_required">
		<a id="status" class="coupon_code_checkbox   <?php if($deatail->coupon_code == 1) echo "check-on"; else echo "check-off"; ?>"></a>
		<h1 class="inline">Add Coupon Code?</h1>
		<input type="hidden" value="<?php echo !empty($deatail) ? $deatail->coupon_code : 0; ?>" name="coupon_code" class="coupon_code_hidden_cb" />
</div>
<div class="addMoreCoupons"  style="padding-bottom:30px; display:<?php if($deatail->coupon_code == 1) echo "block"; else echo "none"; ?>" id="hide_coupon_code">
<h3><a href="javascript:void(0);" class="btn btn-outline-light AddMoreCouponsButton">Add Coupons</a></h3>

<?php 
	if(!empty($coupons)){
		$i = 1;
		foreach($coupons as $coupon){ 
?>
	
<div class="form-light-holder multi_item_boxes coupon_<?php echo $coupon->id; ?>" style="position: relative">
		<div class="adsUrl">
				<h1>#<?php echo $i; ?> Coupon Code Name </h1>
		<input value="<?php echo $this->query_model->getStrReplaceAdmin($coupon->coupon_code_name); ?>" name="Coupons[<?php echo $i; ?>][coupon_code_name]" class="field coupon_required" placeholder=""  type="text" >	
			</div>
			<div class="linkTarget">
				
				<h1>Expiry Date</h1>
				<input type="text" value="<?php echo $coupon->expiry_date; ?>" name="Coupons[<?php echo $i; ?>][expiry_date]" id="" class="field expiry_date coupon_required" placeholder="yyyy-mm-dd" maxlength="10" />
			</div>
		
		<div class="adsUrl">
				<h1>#<?php echo $i; ?> Discount Type</h1>
				<select name="Coupons[<?php echo $i; ?>][coupon_discount_type]" class="field coupon_discount_type" id="" number="<?php echo $i; ?>">
					<option value="amount" <?php echo ($coupon->coupon_discount_type == "amount") ? "selected=selected" : ''; ?>>Amount</option>
					<option value="percent" <?php echo ($coupon->coupon_discount_type == "percent") ? "selected=selected" : ''; ?>>Percent</option>
				</select>
	
				
			</div>
			<div class="linkTarget">
			
				<div class="amount_box<?php echo $i; ?>">
					<h1>#<?php echo $i; ?> Value in Amount (<?php echo $this->query_model->getSiteCurrencyTypeForAdmin() ?>) </h1>
					<input type="text" value="<?php echo !empty($coupon) ? $coupon->coupon_discount_amount : ''; ?>" name="Coupons[<?php echo $i; ?>][coupon_discount_amount]" id="" number="<?php echo $i; ?>" class="field coupon_amount discount_amount<?php echo $i; ?> coupon_required_n" placeholder="Value in Amount (<?php echo $this->query_model->getSiteCurrencyTypeForAdmin() ?>)"/>
					<div class="ErrorMessage ErrorMessage_price<?php echo $i; ?>" style="color:#ff0000"></div>
				</div>
				
				<div class="percent_box<?php echo $i; ?>">
					<h1>#<?php echo $i; ?> Value in Percent (%)</h1>
					<input type="text" value="<?php echo !empty($coupon) ? $coupon->coupon_discount_percent : ''; ?>" name="Coupons[<?php echo $i; ?>][coupon_discount_percent]" id=""  number="<?php echo $i; ?>"  class="field coupon_percent discount_percent<?php echo $i; ?> coupon_required_n" placeholder="Value in Percent (%)"  />
					<div class="ErrorMessage ErrorMessage_percent<?php echo $i; ?>" style="color:#ff0000"></div>
				</div>
			</div>
			
		<?php // if($i != 1){ ?>
	<i class="fa fa-close deleteCoupon" number="<?php echo $coupon->id; ?>" style="cursor:pointer; right:15px;position: absolute; top:10px;color:red"> Delete</i>
		<?php //} ?>
</div>		
<?php 	$i++;		
		}
	}else{
?>

<div class="form-light-holder multi_item_boxes">
		<div class="adsUrl">
				<h1>#1 Coupon Code Name </h1>
		<input value="" name="Coupons[1][coupon_code_name]" class="field coupon_required" placeholder=""  type="text" >	
			</div>
			<div class="linkTarget">
				
				<h1>Expiry Date</h1>
				<input type="text" value="" name="Coupons[1][expiry_date]" id="" class="field expiry_date coupon_required" placeholder="yyyy-mm-dd" maxlength="10" />
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
	<?php } ?>
</div>
</div>

<div class="page-section" id="CustomFields">
<div class="mb-3 main-content-label">Custom Fields</div>
<h3><a href="javascript:void(0);" class="btn btn-outline-light AddMoreCustomFields">Add Custom Fields</a></h3>
<div id="addMoreFields">
<?php if(!empty($custom_fields)){
	$n = 1;
		foreach($custom_fields as $custom_field){
	?>
		<div class="custom_field_box multi_item_boxes custom_box_<?php echo $custom_field->id; ?>">
			<h1><b>Custom Field #<?= $n ?></b></h1>
				<i class="fa fa-close" style="cursor:pointer; right:15px; top:10px;color:red; float:right" > <a href="javascript:void(0);" class="deleteCustomField" custom_field_id="<?php echo $custom_field->id; ?>">Delete</a></i>
				<input type="hidden" name="custom_field[<?= $n ?>][custom_field_id]" value="<?php echo $custom_field->id; ?>">
				<div class="form-new-holder">
					<h1>Field Type</h1>
					<select name="custom_field[<?= $n ?>][type]" class="field field_type" number="<?= $n ?>">
						<option value="text" <?php echo ($custom_field->type =="text") ? 'selected=selected' : '';  ?>>Text</option>
						<option value="dropdown" <?php echo ($custom_field->type =="dropdown") ? 'selected=selected' : '';  ?>>Dropdown</option>
						<option value="checkbox" <?php echo ($custom_field->type =="checkbox") ? 'selected=selected' : '';  ?>>Checkbox</option>
					</select>
				</div>
				<div class="form-new-holder">
					<h1>Label Text</h1>
						<input value="<?php echo $this->query_model->getStrReplaceAdmin($custom_field->label_text); ?>" name="custom_field[<?=$n?>][label_text]" class="field" placeholder="" type="text">
				</div>
				
				<div class="drodownbox_<?=$n?>" number="<?=$n?>" style="display:<?php echo ($custom_field->type =="dropdown" || $custom_field->type =="checkbox" ) ? 'block' : 'none'; ?>"><div class="form-new-holder">
				
				
					<a href="javascript:void(0);" class="btn btn-outline-light AddMoreDropdownValues"  number="<?=$n?>">Add  Values</a>
					<?php 
					
					$selectedDropdownValues = !empty($custom_field->dropdown_values) ? unserialize($custom_field->dropdown_values) : '';
					
						if(!empty($selectedDropdownValues) && ($custom_field->type =="dropdown" || $custom_field->type =="checkbox")){ 
						$p = 1;
							foreach($selectedDropdownValues as $dropdown_value){
					?>
					<div >
						<h1> Value #<?=$p?></h1>
						<input value="<?php echo $this->query_model->getStrReplaceAdmin($dropdown_value); ?>" name="custom_field[<?=$n?>][dropdown_values][<?=$p?>]" class="field" placeholder="" type="text">
						<?php if($p != 1){ ?>
						<i class="fa fa-close" style="cursor:pointer; right:15px; top:10px;color:red" onclick="$(this).parent().remove();"> Delete</i>
						<?php } ?>
					</div>
						<?php $p++; } } ?>
				</div>
				<div class="add_moreDropdownValues<?=$n?>"></div>
				<input type="hidden" class="totalAddMoreDropdownValues_<?=$n?>" value="<?php echo (!empty($selectedDropdownValues)) ? count($selectedDropdownValues) : ''; ?>"  />
			</div>
		</div>

<?php $n++; } } ?>
</div>
</div>


<script language="javascript">
$(document).ready(function(){
	var pt = '<?php echo $deatail->payment_type; ?>';
	var stc = '<?php echo $deatail->show_term_condition; ?>';
	var ups = '<?php echo $deatail->upsale; ?>';
	var sales_taxable = '<?php echo $deatail->sales_taxable; ?>';

	if(pt == 'paid'){
		$('#hide_show_p_quant').show();

	}else{
		$('#hide_show_p_quant').hide();	
	} 

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

// Upsale Option hide/show
	if(ups == 1){
		$('#upsale_option').show();
		$('#up_price').attr('required', 'required');

	}else{
		$('#up_price').attr('required', false);
		$('#upsale_option').hide();	
	}

	// SALES TAXABLE ITEM
	if(sales_taxable == 1){
		$('.tax_hide_show').show();

	}else{
		$('.tax_hide_show').hide();	
	}

	if(stc == 1){
		$('#hide_show_term_condition').show();

	}else{
		$('#hide_show_term_condition').hide();	
	}
	//$('#hide_show_p_quant').hide();
	//$('#hide_show_term_condition').hide();

	// Delete Individual Upsell
	$(".delete_upsell").click(function(){

		var upsell_id=$(this).attr('number');
		var dojo_cart_id = $('#dojo_cart_id').val();

		
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/dojocart/delete_upsell',						
		data: { upsell_id : upsell_id}					
		}).done(function(msg){ 
		if(eval(msg) == 1){		
			//$('.stand_page_'+upsell_id).hide();
			setTimeout("window.location.href='admin/dojocart/edit/"+dojo_cart_id+"'",1000);			
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});

	});

	
	
	
	// Delete Individual Upsell
	$(".deleteCoupon").click(function(){

		var coupon_id=$(this).attr('number');

		
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/dojocart/delete_coupon',						
		data: { coupon_id : coupon_id}					
		}).done(function(msg){ 
		if(eval(msg) == 1){		
			$('.coupon_'+coupon_id).remove();
			//setTimeout("window.location.href='admin/dojocart/edit/"+dojo_cart_id+"'",1000);			
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});

	});


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
			
		}
		else
		{
			$(this).removeClass("check-off");
			$(this).addClass("check-on");
			$(this).parents(".form-light-holder").children(".show_term_condition_hidden_cb").val("1");
			$('#hide_show_term_condition').show();
		}
});



// Coupon code
$(".coupon_code_required .coupon_code_checkbox").click(function(){
		if($(this).hasClass("check-on")){
			$(this).removeClass("check-on");
			$(this).addClass("check-off");
			$(this).parents(".form-light-holder").children(".coupon_code_hidden_cb").val("0");
			$('#hide_coupon_code').hide();
			$('.coupon_required,.coupon_percent,.coupon_required_n').attr('required',false);
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
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($deatail->meta_title); ?>" name="meta_title" id="" class="field full_width_input" placeholder="" style=""/>	

</div>

<div class="form-light-holder">
	<h1> Meta Description</h1>
	<textarea name="meta_desc" id="frm-text"><?php echo $deatail->meta_desc; ?></textarea>
	use following variable to replace relevent values<br>

        {school_name}, {city}, {state}, {city state}, {county}<br>

        {nearby_location1}, {nearby_location2}, <br>

        {main_martial_arts_style}, {martial_arts_style}

    
</div>

<div class="form-light-holder   d-md-flex  dual_input">
	<div class="adsUrl form-group">
		<h1>Body Class</h1>
	<input type="text" name="body_class" class="field" value="<?php  echo $this->query_model->getStrReplaceAdmin($deatail->body_class);?>">
	</div>
	
	<div class="linkTarget form-group">
		<h1>Body Id</h1>
	<input type="text" name="body_id" class="field" value="<?php  echo $this->query_model->getStrReplaceAdmin($deatail->body_id);?>">
	</div>
</div>

<div class="form-light-holder  d-md-flex  dual_input">
	<div class="adsUrl form-group">
		
		<h1>Unique Email Address</h1>
	<input type="text" name="unique_email_address" class="field" value="<?php  echo $this->query_model->getStrReplaceAdmin($deatail->unique_email_address);?>">
	</div>
	
	<div class="linkTarget form-group">
		<h1>Submit button text</h1>
	<input type="text" name="submit_btn_text" class="field" value="<?php  echo $this->query_model->getStrReplaceAdmin($deatail->submit_btn_text);?>">
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
			<input type="radio" class="show_location_type" name="show_location_type" value="show_all" <?php echo ($deatail->show_location_type == "show_all" ) ? 'checked=checked' : ''; ?> /><span>SHOW ALL LOCATIONS</span>
		  </label>
		</div><!-- col-3 -->
		<div class="col-lg-8 mg-t-20 mg-lg-t-0">
		  <label class="rdiobox">
			<input type="radio" class="show_location_type" name="show_location_type" value="select_location" <?php echo ($deatail->show_location_type == "select_location" ) ? 'checked=checked' : ''; ?> /><span>SELECT LOCATIONS TO SHOW</span>
		  </label>
		</div><!-- col-3 -->
		</div>
	</div>
</div>

</div>

<?php 
	if(!empty($dojo_cart_allLocations)){
		$selectedLocations = !empty($deatail->locations) ? unserialize($deatail->locations) : array();
		
?>
<div class="form-light-holder locationsDropdown">
		<h1>Locations</h1>
		<select name="locations[]" id="" class="field locationSelectBox" required='true' multiple="true" style="height:400px">
		<?php foreach($dojo_cart_allLocations as $location){ ?>
			<option value="<?php echo $location->id; ?>" <?php echo (!empty($selectedLocations) && in_array($location->id, $selectedLocations)) ? 'selected=selected' : ''; ?>><?php echo $location->name; ?></option>
		<?php } ?>
	</select>
	
</div>
<?php } ?>


<div class="form-light-holder">
	<a id="published" class="checkbox <?php if($deatail->published == 1) echo "check-on"; else echo "check-off"; ?>"></a>
	<h1 class="inline">Publish This</h1>
	<input type="hidden" value="<?php echo $deatail->published; ?>" name="published" class="hidden_cb" />
</div>
</div>





	

	<div class="tx-center pd-y-20 bg-gray-200" id="bottom"> 
				<input type="hidden" value="<?=$dojo_cart_id?>" name="dojo_cart_id" id="dojo_cart_id" >	
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



<input type="hidden" class="totalAddMoreFeatures" value="<?php if(count($features) >= 1){ echo count($features); } else { echo 2; } ?>"  />
<input type="hidden" class="totalAddMoreUpsales" value="<?php if(count($upsells) >= 1){ echo count($upsells); } else { echo 1; } ?>"  />


<input type="hidden" class="totalAddMoreCoupons" value="<?php if(count($coupons) >= 1){ echo count($coupons); } else { echo 1; } ?>"  />
<input type="hidden" class="totalAddMoreCustomFields" value="<?php echo !empty($custom_fields) ? count($custom_fields) : 0; ?>"  />


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
			
				$('#AddMoreFeatures').append('<span class="featureBox_'+i+'">&#10687; <input type="text"  name="features['+i+']" id="features" class="field" placeholder="Enter Your Feature Text Here"/>&nbsp; &nbsp; <i class="fa fa-times" style="cursor:pointer;" onclick="$(this).parent().remove();"></i><br></span>');
			
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
		//$( ".expiry_date" ).datepicker();
		
		
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
