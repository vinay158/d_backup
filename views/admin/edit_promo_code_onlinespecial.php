<?php $this->load->view("admin/include/header"); ?>

<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<!--<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>-->

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->

<!--<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>-->


<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Edit: Promo Code</h2>
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

<div class="mb-3 main-content-label page_main_heading">Edit: Promo Code</div>

<form id="blog_form" action="" method="post" enctype="multipart/form-data">

<script language="javascript">

$(window).load(function(){
	$.each($('.connect_to_trials'),  function(){
		if($(this).attr('checked') == 'checked'){
			var connect_to_trials_value = $(this).val();
	
			if(connect_to_trials_value == "all_trials"){
				$('.trial_offers_checkboxes').hide();
			}
			if(connect_to_trials_value == "some_trials"){
				$('.trial_offers_checkboxes').show();
			}
		}
	})
	
	var discount_type = $('#discount_type').val();
	
	if(discount_type == "percent"){
		$('.amount_box').hide();
		$('.percent_box').show();
		$('#discount_amount').attr('required',false);
		$('#discount_percent').attr('required',true);
	}else{
		$('.amount_box').show();
		$('.percent_box').hide();
		$('#discount_amount').attr('required',true);
		$('#discount_percent').attr('required',false);
	}
})

$(document).ready(function(){
	
	$('#discount_type').change(function(){
		var discount_type = $(this).val();
		if(discount_type == "percent"){
			$('.amount_box').hide();
			$('.percent_box').show();
			$('#discount_amount').attr('required',false);
			$('#discount_percent').attr('required',true);
		}else{
			$('.amount_box').show();
			$('.percent_box').hide();
			$('#discount_amount').attr('required',true);
			$('#discount_percent').attr('required',false);
		}
	})
	

function validateDecimal(value) {
        var RE = /^\d*\.?\d*$/;
        if(RE.test(value)){
           return true;
        }else{
        	return false;
        }
    }

	
		$("#discount_amount").keyup(function(){
	
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
		
		
		$("#discount_percent").keyup(function(){
	
			var result = validateDecimal($(this).val());
			//alert(result); return false;
			if(result == false){
				$(this).val('');
			$('.ErrorMessage_percent').html(' *Please add numeric only');
				error = false;
			}else{
				$('.ErrorMessage_percent').html('');
			}
		});
		
		

		
		
$('.connect_to_trials').click(function(){
	var connect_to_trials_value = $(this).val();
	
	if(connect_to_trials_value == "all_trials"){
		$('.trial_offers_checkboxes').hide();
	}
	if(connect_to_trials_value == "some_trials"){
		$('.trial_offers_checkboxes').show();
	}
});
	
	
})
</script>


<div class="form-light-holder   d-md-flex  dual_input">
		<div class="adsUrl form-group">

	<h1>Promo Code Name</h1>

	<input type="text" value="<?php echo !empty($pagedetails) ? $pagedetails[0]->title : ''; ?>" name="title" id="" class="field" placeholder="Enter Promo Code Name here"  required/>
	
	</div>
	
	<div class="linkTarget form-group">
		
	<h1>Discount Type</h1>
	<select name="discount_type" class="field" id="discount_type">
		<option value="amount" <?php echo (!empty($pagedetails) && $pagedetails[0]->discount_type == "amount") ? "selected=selected" : ''; ?>>Amount</option>
		<option value="percent" <?php echo (!empty($pagedetails) && $pagedetails[0]->discount_type == "percent") ? "selected=selected" : ''; ?>>Percent</option>
	</select>
	
	</div>

</div>


<div class="form-light-holder  d-md-flex  dual_input">
		<div class="adsUrl form-group">
	<div class="amount_box">
		<h1>Value in Amount (<?php echo $this->query_model->getSiteCurrencyTypeForAdmin() ?>)</h1>

		<input type="text" value="<?php echo !empty($pagedetails) ? $pagedetails[0]->discount_amount : ''; ?>" name="discount_amount" id="discount_amount" class="field" placeholder="Value in Amount (<?php echo $this->query_model->getSiteCurrencyTypeForAdmin() ?>)"/>
		<div class="ErrorMessage ErrorMessage_price" style="color:#ff0000"></div>
	</div>
	
	<div class="percent_box">
	
		<h1>Value in Percent (%)</h1>

		<input type="text" value="<?php echo !empty($pagedetails) ? $pagedetails[0]->discount_percent : ''; ?>" name="discount_percent" id="discount_percent" class="field" placeholder="Value in Percent (%)"  />
		<div class="ErrorMessage ErrorMessage_percent" style="color:#ff0000"></div>

	</div>
	
	</div>
	
	<div class="linkTarget form-group">
		
		<div class="publishDateBox">
			<h1>Expiry Date</h1>
			<input type="text" value="<?php echo $pagedetails[0]->expiry_date; ?>" name="expiry_date" id="date" class="field" placeholder="mm/dd/yyyy" maxlength="10" required />	
		</div>
	
	</div>
	
</div>


<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
    <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
    <link rel="stylesheet" href="/resources/demos/style.css" />
    <script>
    $(function() {
        $( "#date" ).datepicker({ dateFormat: "yy-mm-dd" });
    });
    </script>


<div class="form-light-holder">
<div class="row row-xs align-items-center">
	<div class="col-md-4">
		<label class="form-label mg-b-0"><h1>Connect to all trials or some trials</h1></label>
	</div>
	<div class="col-md-8  mg-t-5 mg-md-t-0">
	<div class="row mg-t-10">
		<div class="col-lg-3">
		  <label class="rdiobox">
			<input type="radio" class="connect_to_trials" name="connect_to_trials" value="all_trials" <?php echo (!empty($pagedetails) && ($pagedetails[0]->connect_to_trials == "all_trials")) ? 'checked=checked' : ''; ?> />
			<span>ALL Trials</span>
		  </label>
		</div><!-- col-3 -->
		<div class="col-lg-9 mg-t-20 mg-lg-t-0">
		  <label class="rdiobox">
			<input type="radio" class="connect_to_trials" name="connect_to_trials" value="some_trials" <?php echo (!empty($pagedetails) && ($pagedetails[0]->connect_to_trials == "some_trials")) ? 'checked=checked' : ''; ?>   />
			<span>Some Trials</span>
		  </label>
		</div><!-- col-3 -->
		</div>
	</div>
</div>
</div>


<?php if(!empty($trial_offers)){
		 $selectedTrialOffers = (!empty($pagedetails) && !empty($pagedetails[0]->trial_offers)) ? unserialize($pagedetails[0]->trial_offers) : '';
	?>
<div class="form-light-holder trial_offers_checkboxes" style="display:<?php echo (!empty($pagedetails) && ($pagedetails[0]->connect_to_trials == "some_trials")) ? 'block' : 'none'; ?>">

	<h1>Trial Offers</h1>
	<div class="row row-xs align-items-center">
	
	<div class="col-md-12  mg-t-5 mg-md-t-0">
	<div class="row mg-t-10">
	
	<?php foreach($trial_offers as $offer){ ?>
	<div class="col-lg-12 checkbox_spaces">
	<label class="ckbox">
	<input type="checkbox" class="" name="trial_offers[<?php echo $offer->id; ?>]" value="<?php echo $offer->id; ?>"  <?php echo (!empty($selectedTrialOffers) && in_array($offer->id, $selectedTrialOffers)) ? 'checked=checked' : ''; ?> /><span><?php echo $offer->offer_title; ?> </span></label>
	</div>
	<?php } ?>
	
	</div>
	</div>
	</div>
</div>
<?php } ?>

<div style="clear:both;"/>
<div class="form-white-holder" style="padding-bottom:20px;">

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


<!------------ recent items ----------------->

<?php $this->load->view("admin/include/footer");?>

