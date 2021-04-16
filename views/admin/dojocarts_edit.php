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
<div class="gen-holder">
	<div class="gen-panel-holder"  style="width: 100% !important;">
	<div class="gen-panel">
		<div class="panel-title">
			<div class="panel-title-name">Edit DojoCart:  <?php echo $deatail->template; ?> Template</div>
		</div>
		<div class="panel-body">
		<div class="panel-body-holder">		
		<div class="form-holder">

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
});
</script>



<div class="form-light-holder">
	<h1> Product Name</h1>
	<input type="text" value="<?php echo $deatail->product_title; ?>" name="product_title" id="title" class="field full_width_input" placeholder="Enter Your Offer Name Here" style=""/>	
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

<div class="form-light-holder" style="">
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
			echo "<a href='javascript:void(0);' id='delete_img' class='delete_image_btn_new' >Delete image</a>";
			}
	?>	
</div> -->

<div class="form-light-holder">
<h1>Logo</h1>
	<select name="override_logo" id="window" class="field">
	<option value="">-Select logo-</option>
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

<div class="form-light-holder  d-md-flex  dual_input   welcome_video">
	<div class="adsUrl form-group">
		<h1>Video Type</h1>
		<select name="video_type" id="" class="field videoType" >
		<option value="youtube_video" <?php if($deatail->video_type == 'youtube_video'){ echo 'selected=selected'; } ?>>Youtube Video</option>
		<option value="vimeo_video" <?php if($deatail->video_type == 'vimeo_video'){ echo 'selected=selected'; } ?>  >Vimeo Video</option>
	</select>
	
	</div>
	<div class="linkTarget  form-group">
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


<div class="form-light-holder">
	<h1> Bullet Points Title</h1>
	<input type="text" value="<?php echo $deatail->offer_title; ?>" name="offer-title" id="offer-title" class="field full_width_input" placeholder="Enter Your Offer Headline Text Here" style=""/>	
</div>

 <div class="form-light-holder">
        <h1> Bullet Points</h1>
		<div id="AddMoreFeatures">
			<div class=""><h3><a href="javascript:void(0);" class="AddMoreButton">Add Another Feature</a></h3></div>
			<?php 
			
			$features = unserialize($deatail->features);
			
					if(!empty($features)){
					$i = 1;
					foreach($features as $feature){
			 ?>
			 <span class="featureBox_<?= $i ?>">
			 <a feature="<?php echo $feature; ?>" number="<?= $i ?>" href="javascript:void(0)" class="delete_features" >Delete </a>
        	&#10687;<input type="text"  name="features[<?= $i ?>]" id="features" value="<?= $feature; ?>" class="field"   placeholder="Enter Features here"/>
			
			<br>
			
			<?php $i++; ?></span>
				
			<?php }  } else { ?>
			<div class=""><h3><a href="javascript:void(0);" class="AddMoreButton">Add Another Feature</a></h3></div>
			<span class="featureBox_1"><input type="text"  name="features[1]" id="features" value="" class="field"   placeholder="Enter Your Feature Text Here"/><br></span>
			<span class="featureBox_2"><input type="text"  name="features[2]" id="features" value="" class="field"   placeholder="Enter Your Feature Text Here"/><br></span>
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
		$( "#publish_date" ).datepicker({ dateFormat: "yy-mm-dd" });
    });
    </script>

<div class="form-light-holder" style="">
	<h1> Bullet Points Description</h1>
	<textarea name="offer_description" id="offer_description" class="ckeditor"><?php echo $deatail->offer_description; ?></textarea>
</div>

<div class="form-light-holder" style="overflow:auto;">
	<?php if(!empty($deatail->offer_image)) { echo "<div><img id='img2' src='upload/dojocarts/".$deatail->offer_image."' width='120' ></div>";
	}
	?>
	<input type="hidden" name="old_offer_image" id="old_offer_image" value="<?=$deatail->offer_image?>" />
	<h1 style="padding-bottom: 5px;">Upload Sidebar Image </h1>
	<input type="file" name="userfile2" id="photo" accept="image/*" />
		<?php if($deatail->offer_image){ 
			echo "<a href='javascript:void(0);' id='delete_img_offer' class='delete_image_btn_new' >Delete image</a>";
			}
	?>
		<div>
		</div>
</div>

<!-- Show price, quantity, upsell if paid start -->

<div class="form-light-holder">
	<h1>Do you want to accept credit card payments for this product?</h1>
	<select name="payment_type" class="payment_type">
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
		<h1 class="inline">Product Price ($)</h1>
		<div class="price-validate">
		<input type="text" value="<?php echo $deatail->price; ?>" name="price" id="price" class="field " placeholder="Enter Price" style="width:100px; margin-left: 10px;" /><div class="ErrorMessage ErrorMessage_price"></div> </div>
		<div class="price-validate tax_hide_show">
		<span style="padding-left: 15px;">Sales Tax (%)</span>
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
<div class=""><h3><a href="javascript:void(0);" class="AddMoreUpsale">Add Another Upsell</a></h3></div>
	<?php if(!empty($upsells)){ 
				$a = 1;
				foreach($upsells as $upsell_opt){
	?>

<a href="javascript:void(0)" class="delete_upsell" number="<?=$upsell_opt->id?>">Delete This Upsell</a>
<div class="form-light-holder">
	<h1>Upsell # <?= $a ?>  Title</h1>
	<input type="text" value="<?=$upsell_opt->up_title?>" name="data[<?= $a ?>][up_title]" id="up_title" class="field" placeholder="" style="width:40%"/>
</div>	
<div class="form-light-holder manage-pricerow">
	<h1>Upsell # <?= $a ?> Price</h1>
	<div class="price-validate">
	$<input type="text" value="<?=$upsell_opt->up_price?>" name="data[<?= $a ?>][up_price]" id="up_price" class="field up_price" number="<?= $a ?>" placeholder="" style="width:100px"/><div class="ErrorMessage ErrorMessage_up_price<?= $a ?>"></div>
	</div>
	<div class="price-validate tax_hide_show">
	<span style="padding-left: 15px;">Sales Tax (%)</span>	
	<input type="text" value="<?=$upsell_opt->sales_tax?>"  name="data[<?= $a ?>][sales_tax]" id="sales_tax" class="field sales_tax_main" number="<?= $a ?>" placeholder="%" style="width:100px; margin-left: 10px;" /><div class="ErrorMessage ErrorMessage_sales_tax_main<?= $a ?>"></div>
	</div>
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		Please enter the amount in decimal form. Do not use any characters such as "$” or “%". Example: "49.99" or “7”.
	</div>

</div>
<div class="form-light-holder">
	<h1>Upsell # <?= $a ?> “Yes Please! Text” Description</h1>
	<input type="text" value="<?=$upsell_opt->yes?>" name="data[<?= $a ?>][yes]" id="yes" class="field" placeholder="" style="width:40%"/>	
</div>
<div class="form-light-holder">
	<h1>Upsell # <?= $a ?> “No Thank You! Text” Description</h1>
	<input type="text" value="<?=$upsell_opt->no?>" name="data[<?= $a ?>][no]" id="no" class="field" placeholder="" style="width:40%"/>	
</div>
	<?php 
			$a++; 
		}
	 } else { 
?>
<div class="form-light-holder">
	<h1>Upsell #1 Title</h1>
	<input type="text" value="" name="data[1][up_title]" id="up_title" class="field" placeholder="" style="width:40%"/>	
</div>
<div class="form-light-holder manage-pricerow">
	<h1>Upsell #1 Price</h1>
	<div class="price-validate">
	$<input type="text" value="" name="data[1][up_price]" id="up_price" class="field up_price" number="1" placeholder="Enter Price" style="width:100px"/>
		<div class="ErrorMessage ErrorMessage_up_price1"></div>
	</div>
	<div class="price-validate tax_hide_show">
	<span style="padding-left: 15px;">Sales Tax (%)</span>
	<input type="text" value=""  name="data[1][sales_tax]" id="sales_tax" class="field sales_tax_main" number="1" placeholder="%" style="width:100px; margin-left: 10px;" />
	<div class="ErrorMessage ErrorMessage_sales_tax_main1"></div>
</div>

	</div>

		
<div class="form-light-holder">
	<h1>Upsell #1 “Yes Please! Text” Description</h1>
	<input type="text" value="" name="data[1][yes]" id="yes" class="field" placeholder="" style="width:40%"/>	
</div>
<div class="form-light-holder">
	<h1>Upsell #1 “No Thank You! Text” Description</h1>
	<input type="text" value="" name="data[1][no]" id="no" class="field" placeholder="" style="width:40%"/>	
</div>
<?php } ?>
	
</div>
<!-- Upsell Section End -->


</div>
<!-- Show price, quantity, upsell if paid end-->


<div class="form-light-holder show_term_condition_required">
		<a id="status" class="show_term_condition_checkbox <?php if($deatail->show_term_condition == 1) echo "check-on"; else echo "check-off"; ?>"></a>
		<h1 class="inline">Show Terms & Conditions</h1>
		<input type="hidden" value="<?php echo $deatail->show_term_condition ?>" name="show_term_condition" class="show_term_condition_hidden_cb" />
				
</div>

<div class="form-light-holder" style="" id="hide_show_term_condition">
	<h1>Terms & Conditions</h1>
	<textarea name="term_condition"  id="ckeditor_full_term_condition" class="ckeditor" ><?php echo $deatail->term_condition; ?></textarea>
</div>


<div class="form-light-holder coupon_code_required">
		<a id="status" class="coupon_code_checkbox   <?php if($deatail->coupon_code == 1) echo "check-on"; else echo "check-off"; ?>"></a>
		<h1 class="inline">Add Coupon Code?</h1>
		<input type="hidden" value="<?php echo !empty($deatail) ? $deatail->coupon_code : 0; ?>" name="coupon_code" class="coupon_code_hidden_cb" />
</div>
<div class="addMoreCoupons"  style=" display:<?php if($deatail->coupon_code == 1) echo "block"; else echo "none"; ?>" id="hide_coupon_code">
<h3><a href="javascript:void(0);" class="AddMoreCouponsButton">Add Coupons</a></h3>

<?php 
	if(!empty($coupons)){
		$i = 1;
		foreach($coupons as $coupon){ 
?>
	
<div class="form-light-holder coupon_<?php echo $coupon->id; ?>" style="position: relative">
		<div class="adsUrl">
				<h1>#<?php echo $i; ?> Coupon Code Name </h1>
		<input value="<?php echo $coupon->coupon_code_name; ?>" name="Coupons[<?php echo $i; ?>][coupon_code_name]" class="field" placeholder=""  type="text" >	
			</div>
			<div class="linkTarget">
				<h1>#<?php echo $i; ?> Discount Amount? </h1>
		<input value="<?php echo $coupon->coupon_discount_amount; ?>" name="Coupons[<?php echo $i; ?>][coupon_discount_amount]" class="field sales_tax_main" placeholder="" type="text">
		
		
		</div>
		<?php if($i != 1){ ?>
	<i class="fa fa-close deleteCoupon" number="<?php echo $coupon->id; ?>" style="cursor:pointer; right:15px;position: absolute; top:10px;color:red"> Delete</i>
		<?php } ?>
</div>		
<?php 	$i++;		
		}
	}else{
?>

<div class="form-light-holder">
		<div class="adsUrl">
				<h1>#1 Coupon Code Name </h1>
		<input value="" name="Coupons[1][coupon_code_name]" class="field" placeholder=""  type="text">	
			</div>
			<div class="linkTarget">
				<h1>#1 Discount Amount? </h1>
		<input value="" name="Coupons[1][coupon_discount_amount]" class="field" placeholder="" type="text">
		</div>
	
</div>
	<?php } ?>
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
			//var show_price = 0;
			
		}
		else
		{
			$(this).removeClass("check-off");
			$(this).addClass("check-on");
			$(this).parents(".form-light-holder").children(".coupon_code_hidden_cb").val("1");
			$('#hide_coupon_code').show();
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

<div class="form-light-holder">
	<h1> Meta Title</h1>
	<input type="text" value="<?php echo $deatail->meta_title; ?>" name="meta_title" id="" class="field full_width_input" placeholder="" style=""/>	

</div>

<div class="form-light-holder">
	<h1> Meta Description</h1>
	<textarea name="meta_desc" id="frm-text"><?php echo $deatail->meta_desc; ?></textarea>
	use following variable to replace relevent values<br>

        {school_name}, {city}, {state}, {city state}, {county}<br>

        {nearby_location1}, {nearby_location2}, <br>

        {main_martial_arts_style}, {martial_arts_style}

    
</div>

<div class="form-light-holder">
	<a id="published" class="checkbox <?php if($deatail->published == 1) echo "check-on"; else echo "check-off"; ?>"></a>
	<h1 class="inline">Publish This</h1>
	<input type="hidden" value="<?php echo $deatail->published; ?>" name="published" class="hidden_cb" />
</div>


<div class="form-white-holder" style="padding-bottom:20px;">
	<input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />
</div>
<input type="hidden" value="<?=$dojo_cart_id?>" name="dojo_cart_id" id="dojo_cart_id" >	
</form>



		</div>
		</div>
		</div>
	</div>
	</div>

<br style="clear:both"/><br />
<input type="hidden" class="totalAddMoreFeatures" value="<?php if(count($features) >= 1){ echo count($features); } else { echo 2; } ?>"  />
<input type="hidden" class="totalAddMoreUpsales" value="<?php if(count($upsells) >= 1){ echo count($upsells); } else { echo 1; } ?>"  />


<input type="hidden" class="totalAddMoreCoupons" value="<?php if(count($coupons) >= 1){ echo count($coupons); } else { echo 1; } ?>"  />
<script language="javascript" type="text/javascript">
 	
	$(document).ready(function(){

			$('.AddMoreButton').click(function(){
			var totalAddMoreFeatures = $('.totalAddMoreFeatures').val();
			var i = parseInt(totalAddMoreFeatures) + Number(1);
			$('.totalAddMoreFeatures').val(i);
			
				$('#AddMoreFeatures').append('<span class="featureBox_'+i+'"><i class="fa fa-close" style="cursor:pointer;" onclick="$(this).parent().remove();"> Delete</i><input type="text"  name="features['+i+']" id="features" class="field" placeholder="Enter Your Feature Text Here"/><br></span>');
			
		});

			$('.AddMoreUpsale').click(function(){
			var totalAddMoreUpsales = $('.totalAddMoreUpsales').val();
			var b = parseInt(totalAddMoreUpsales) + Number(1);
			$('.totalAddMoreUpsales').val(b);
			

				/*$('#upsale_option').append('<div class="form-light-holder"><h1> Upsell #'+b+' Title</h1><input type="text" value="" name="data['+b+'][up_title]" id="up_title" class="field" placeholder="" style="width:40%"/></div><div class="form-light-holder"><h1>Upsell #'+b+' Price</h1>$<input type="text" required="required" value="" name="data['+b+'][up_price]" id="up_price" class="field up_price" number="'+b+'" placeholder="Enter Price" style="width:10%"/><input type="text" value=""  name="data['+b+'][sales_tax]" id="sales_tax" class="field sales_tax_main" placeholder="%" style="width:10%; margin-left: 10px;" /><div class="ErrorMessage ErrorMessage_up_price'+b+'"></div></div><div class="form-light-holder"><h1>Upsell #'+b+' “YES PLEASE! TEXT” DESCRIPTION</h1><input type="text" value="" name="data['+b+'][yes]" id="yes" class="field" placeholder="" style="width:40%"/></div><div class="form-light-holder"><h1>Upsell #'+b+'  “NO THANK YOU! TEXT” DESCRIPTION</h1><input type="text" value="" name="data['+b+'][no]" id="no" class="field" placeholder="" style="width:40%"/></div>');*/

				$('#upsale_option').append('<div class="form-light-holder"><h1> Upsell #'+b+' Title</h1><input type="text" value="" name="data['+b+'][up_title]" id="up_title" class="field" placeholder="" style="width:40%"/></div><div class="form-light-holder manage-pricerow"><h1>Upsell #'+b+' Price</h1><div class="price-validate">$<input type="text" required="required" value="" name="data['+b+'][up_price]" id="up_price" class="field up_price" number="'+b+'" placeholder="Enter Price" style="width:100px"/><div class="ErrorMessage ErrorMessage_up_price'+b+'"></div></div><div class="price-validate tax_hide_show"><span style="padding-left: 15px;">Sales Tax (%)</span><input type="text" value=""  name="data['+b+'][sales_tax]" id="sales_tax" class="field sales_tax_main" number="'+b+'" placeholder="%" style="width:100px; margin-left: 10px;" /><div class="ErrorMessage ErrorMessage_sales_tax_main'+b+'"></div></div></div><div class="form-light-holder"><h1>Upsell #'+b+' “YES PLEASE! TEXT” DESCRIPTION</h1><input type="text" value="" name="data['+b+'][yes]" id="yes" class="field" placeholder="" style="width:40%"/></div><div class="form-light-holder"><h1>Upsell #'+b+'  “NO THANK YOU! TEXT” DESCRIPTION</h1><input type="text" value="" name="data['+b+'][no]" id="no" class="field" placeholder="" style="width:40%"/></div>');
			
		});

		
		$('.AddMoreCouponsButton').click(function(){
			var totalAddMoreCoupons = $('.totalAddMoreCoupons').val();
			var k = parseInt(totalAddMoreCoupons) + Number(1);
			$('.totalAddMoreCoupons').val(k);
			
				$('.addMoreCoupons').append('<div class="form-light-holder" style="position:relative"><div class="adsUrl"><h1>#'+k+' Coupon Code Name</h1><p></p><input value="" name="Coupons['+k+'][coupon_code_name]" class="field" placeholder="" type="text"></div><div class="linkTarget"><h1>#'+k+' Discount Amount?</h1><input value="" name="Coupons['+k+'][coupon_discount_amount]" class="field sales_tax_main" placeholder="" type="text"></div><i class="fa fa-close" style="cursor:pointer; right:15px; top:10px; position:absolute;color:red" onclick="$(this).parent().remove();"> Delete</i></div>');
			
		});
		
		
	});	 
	
</script>
<!-- recent items -->
<?php $this->load->view("admin/include/footer");?>
