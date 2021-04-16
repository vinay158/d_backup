<?php $phoneNumberMaxLength = $this->query_model->phoneNumberMaxLength(); ?>
<?php $this->query_model->generatingUniqueIds();  ?>
<input type="hidden" id="site_currency_type" value="<?php echo $this->query_model->getSiteCurrencyType(); ?>" >
<?php
  $settings = $this->query_model->getbyTable("tblsite");

  if(!empty($settings)):

    foreach($settings as $settings):

      
      $logo = $settings->sitelogo;
      
      
    endforeach; 

  endif;

$website_settings = $this->query_model->getbySpecific('tblsite','id', 1);
if($website_settings[0]->phone_required == 0){
if($website_settings[0]->international_phone_fields != 1){ 

?>
  <script>
  function set(elem)
  {
    var x = '';
    var error_class = $(elem).attr("error_class");
    if($(elem).val().length <= 3){
      $(elem).after('<div class="reds '+error_class+' ">Enter a valid phone number</div>');
    }else if($(elem).val().length <= 5 && $(elem).val().length > 3){
      x = $(elem).val().replace(/\D/g, '').match(/(\d{3})/);
      $(elem).val('' + x[1] + ' ');
      $(elem).after('<div class="reds '+error_class+' ">Enter a valid phone number</div>');
    }
    else if($(elem).val().length <= 9 && $(elem).val().length > 3){
      x = $(elem).val().replace(/\D/g, '').match(/(\d{3})(\d{3})/);
      $(elem).val('' + x[1] + ' ' + x[2] + ' ');
      $(elem).after('<div class="reds '+error_class+' ">Enter a valid phone number</div>');
    }
    else if($(elem).val().length <= 11 && $(elem).val().length > 9){
      x = $(elem).val().replace(/\D/g, '').match(/(\d{3})(\d{3})(\d{4})/);
      $(elem).val('' + x[1] + ' ' + x[2] + ' ' + x[3]);
      $(elem).after('<div class="reds '+error_class+' ">Enter a valid phone number</div>');
    }else{
      x = $(elem).val().replace(/\D/g, '').match(/(\d{3})(\d{3})(\d{4})/);
      $(elem).val('' + x[1] + ' ' + x[2] + ' ' + x[3]);
    }
    
    
    if($(elem).val().length <= 11){
      $(elem).after('<div class="reds '+error_class+' ">Enter a valid phone number</div>');
      }else{
      
      $(elem).removeClass('phone_number');
      
      $('.'+error_class).hide();
      
      }
    }
</script>
<?php } } ?>

  <script>
	function textAlphabatic(elem){
		var error_class = $(elem).attr("error_class");
		var error_msg = $(elem).attr("error_msg");
		var value = $.trim($(elem).val());
		if(/^\s*$/.test(value)){
			value = '';
		}
		
		if (! /^[a-zA-Z ]+$/.test(value)) {
			$(elem).after('<div class="reds '+error_class+' ">'+error_msg+'</div>');
			$(elem).val('');
		}else{
			if(value.length > 25){
				$(elem).after('<div class="reds '+error_class+' ">'+error_msg+'</div>');
				$(elem).val('');
			}else{
				if (typeof alreadyTotal_price === "undefined") {
					$(elem).val(value);
					$('.'+error_class).hide();
				}else{
					if(field_name == "name"){
						if(! /\s/g.test(value)){
							$(elem).after('<div class="reds '+error_class+' ">'+error_msg+'</div>');
							$(elem).val(value);
						}
					}else{
						$(elem).val(value);
						$('.'+error_class).hide();
					}
				}
				
			}
		}
	}
	
	function phoneValidation(elem){
		var error_class = $(elem).attr("error_class");
		var value = $(elem).val();
		//var int_value = (int)value;
		//alert(int_value);
		<?php 
			if($website_settings[0]->international_phone_fields != 1){
				if($website_settings[0]->phone_required == 1){ ?>
				if(value.length <= <?php echo $phoneNumberMaxLength - 1; ?>){
					$(elem).after('<div class="reds '+error_class+' ">Enter a valid phone number</div>');
					$(elem).val(value);
				}else if(value.length > <?php echo $phoneNumberMaxLength; ?>){
					$(elem).after('<div class="reds '+error_class+' ">Enter a valid phone number</div>');
					$(elem).val(value);
				}else{
					$('.'+error_class).hide();
				}
				<?php }else{ ?>
				if(value.length <= <?php echo $phoneNumberMaxLength - 1; ?> && value.length > 0){
					$(elem).after('<div class="reds '+error_class+' ">Enter a valid phone number</div>');
					$(elem).val(value);
				}else{
					$('.'+error_class).hide();
				}
			<?php } } else{ 
					
					if($website_settings[0]->phone_required == 1){
					?>
					
				  var filter = /^[- +()]*[0-9][- +()0-9]*$/;
					if (filter.test(value)) {
						$('.'+error_class).hide();
					}
					else {
						$(elem).after('<div class="reds '+error_class+'">Enter a valid phone number</div>');
						$(elem).val(value);
					}	
						 
					<?php 		}else{ ?>
						if(telephone.length == 0){
							$('.'+error_class).hide();
						}else{
							var filter = /^[- +()]*[0-9][- +()0-9]*$/;
							if (filter.test(value)) {
								$('.'+error_class).hide();
							}
							else {
								$(elem).after('<div class="reds '+error_class+'">Enter a valid phone number</div>');
								$(elem).val(value);
							}	
						}
								
					<?php		}	?> 
					
					<?php }?>
		
		
	}
	
	
	/*function phoneValidation(elem){
		var error_class = $(elem).attr("error_class");
		var value = $(elem).val();
		//var int_value = (int)value;
		//alert(int_value);
		if (!$.isNumeric(value ) && value != '') {
			//alert(1);
			$(elem).after('<div class="reds '+error_class+' ">Enter a valid phone number</div>');
			$(elem).val(value);
		}else{
			//alert(2);
			<?php 
			if($website_settings[0]->international_phone_fields != 1){
				if($website_settings[0]->phone_required == 1){ ?>
				if(value.length <= 9){
					$(elem).after('<div class="reds '+error_class+' ">Enter a valid phone number</div>');
					$(elem).val(value);
				}else if(value.length > 10){
					$(elem).after('<div class="reds '+error_class+' ">Enter a valid phone number</div>');
					$(elem).val(value);
				}else{
					$('.'+error_class).hide();
				}
				<?php }else{ ?>
				if(value.length <= 9 && value.length > 0){
					$(elem).after('<div class="reds '+error_class+' ">Enter a valid phone number</div>');
					$(elem).val(value);
				}else{
					$('.'+error_class).hide();
				}
			<?php } }  ?>
			
		}
		
		
	} */
  </script>
  
  
<!-- <script src="js/jquery.maskedinput_new.js" type="text/javascript"></script> -->
<script src="js/jquery.mask_new2.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
	$('.phone_number').mask('(000) 000-0000');
	<?php if($website_settings[0]->international_phone_masking == 1 && !empty($website_settings[0]->international_phone_masking_format)){ ?>
		var international_phone_masking_format = "<?php echo $website_settings[0]->international_phone_masking_format; ?>";
		$('.international_phone_number').mask(international_phone_masking_format);
	<?php } ?>
});
/*jQuery(function($){
   $(".phone_number").mask("(999) 999-9999",{placeholder:"(XXX) XXX-XXXX"});
});*/
 /*$('.phone_number')
        
	.keydown(function (e) {
		var key = e.charCode || e.keyCode || 0;
		$phone = $(this);
                <?php 
                    $international_phone_validation = $this->query_model->checkInternationalPhoneField();
                        
                        if($international_phone_validation == 'off'){
                ?> 
               
		// Auto-format- do not expose the mask as the user begins to type
		if (key !== 8 && key !== 9) {
			if ($phone.val().length === 3) {
				$phone.val($phone.val() + ' ');
			}
						
			if ($phone.val().length === 7) {
				$phone.val($phone.val() + ' ');
			}
		}
                    <?php } ?>
		// Allow numeric (and tab, backspace, delete) keys only
		return (key == 8 || 
				key == 9 ||
				key == 46 ||
				(key >= 48 && key <= 57) ||
				(key >= 96 && key <= 105));
                       
	})
	
	.bind('focus click', function () {
		$phone = $(this);
		
		if ($phone.val().length === 0) {
			$phone.val('');
		}
		else {
			var val = $phone.val();
			//$phone.val('').val(val); // Ensure cursor remains at the end
		}
	})
	
	.blur(function () {
		$phone = $(this);
		
		if ($phone.val() === '(') {
			$phone.val('');
		}
	}); */

 </script>
 <?php $cronJobs = $this->query_model->checkCronJobsForCoupons(); ?>
<script>
$(window).load(function(){
	
})
	$(document).ready(function(){
		<?php if(isset($cronJobs['trial_offer']) && $cronJobs['trial_offer'] == 1){ ?>
		$.ajax({ 					
				type: 'POST',						
				url: '<?php echo base_url(); ?>site/checkExpiredTrialOfferCoupons',
				data: { type : "checkExpiredTrialOffer"}
				
				}).done(function(msg){
				
			});
		<?php } ?>	
		
		<?php if(isset($cronJobs['trial_offer']) && $cronJobs['trial_offer'] == 1){ ?>
		$.ajax({ 					
				type: 'POST',						
				url: '<?php echo base_url(); ?>site/checkExpiredDojocartCoupons',
				data: { type : "checkExpiredDojocart"}
				
				}).done(function(msg){
				
				
			});
		<?php } ?>
	})
</script>


<footer class="footer">
  <div class="container">
    <div class="row">
      <div class="col-md-3  col-sm-3">

         <?php 
          if($settings->override_logo == 1){
            if($settings->override_footer_logo != 1){
            
            $footer_logo = $this->query_model->getbySpecific('tbloverride_logos','s_no', $settings->override_footer_logo);
            
              if(!empty($footer_logo)){
        ?>
        <img style="max-width:100px;" src="<?php echo base_url().'upload/override_logos/'.$footer_logo[0]->logos; ?>" class="img-responsive" alt="<?php $this->query_model->getStrReplace($footer_logo[0]->logo_alt); ?>"> 
        <?php 
            } else{ ?>
          <img src="<?php echo $logo; ?>" class="img-responsive" alt="<?php $this->query_model->getStrReplace($settings->logo_alt); ?>">  
            
        <?php   }
        
            
          } else{
            
        ?>
         <img src="<?php echo $logo; ?>" class="img-responsive" alt="<?php $this->query_model->getStrReplace($settings->logo_alt); ?>"> 
        <?php } } else{ ?>
           <img style="max-width:100px;" src="<?php echo $logo; ?>" class="img-responsive" alt="<?php $this->query_model->getStrReplace($settings->logo_alt); ?>"> 
        <?php } ?>
      
      
<?php 
$folder_name = $_SERVER['CONTEXT_PREFIX'];
$_SERVER['REQUEST_URI'] = str_replace($folder_name,'',$_SERVER['REQUEST_URI']);
$events_slug = $this->query_model->getbySpecific('tblmeta', 'id', 27);
    $events_slug = $events_slug[0];
                
    $student_section_slug = $this->query_model->getbySpecific('tblmeta', 'id', 47);
    $student_section_slug = $student_section_slug[0];
    
    
  $pageurl = '';
  $action_url = '';
  if(isset($_SERVER['REQUEST_URI'])){
    $pageurl = explode('/',$_SERVER['REQUEST_URI']);
    $pageurl_2 = explode('/',$_SERVER['REQUEST_URI']);
    
    if(isset($pageurl[1])){
      $pageurl = $pageurl[1];
    }
    if(isset($pageurl_2[2])){
      $action_url = $pageurl_2[2];
    }
  }


$folder_name = $_SERVER['CONTEXT_PREFIX'];
$slug = str_replace($folder_name,'',$_SERVER['REQUEST_URI']);


  if(!empty($slug)){
    
    if($pageurl == $student_section_slug->slug && $action_url == 'videos'){
      $video_slug = '/'.$student_section_slug->slug.'/videos';
      $addCodeForCurrentPage = $this->query_model->getbySpecific('tbladdcode','page_slug',$video_slug);
    }else{
      $addCodeForCurrentPage = $this->query_model->getbySpecific('tbladdcode','page_slug',$slug);
    }
  
    $override_code_above_body = array();
    if(!empty($addCodeForCurrentPage)){
      foreach($addCodeForCurrentPage as $addCodeForCurrent){
        if($addCodeForCurrent->code_checked == 1){
          $override_code_footer[] = $addCodeForCurrent->id;
        }
        $this->query_model->getStrReplace($addCodeForCurrent->footer_code);
       }
    }
  }

if(empty($override_code_footer)){ 
  $page_slug_type = 'ALL';
  if($pageurl == $student_section_slug->slug || $pageurl == $events_slug->slug){
    $page_slug_type = 'ALL_Student_Section';
  }

    $addCodeAllPages = $this->query_model->getbySpecific('tbladdcode','page_slug',$page_slug_type);
     foreach($addCodeAllPages as $addCodeAllPage){
      $this->query_model->getStrReplace($addCodeAllPage->footer_code);
      //echo '<br>';
     }
}
?>
      </div>

      <div class="col-md-9  col-sm-9">
      <div class="copyright custom-copy-right">
          <p> &#169; <?php  echo date('Y'); ?> <?php echo $_SERVER['SERVER_NAME']; ?> All Rights Reserved. | 
            <a href="http://websitedojo.com/" style="color:#FFF;" target="_blank">Martial Arts Websites by WebsiteDojo.com</a></p>
        </div>
      </div>
    </div>
  </div>
</footer>
<div class="cleaarfix"></div>

<!-- jQuery --> 
<!-- <script src="js/new/jquery.js"></script> --> 
<script src="js/new/main.js"></script> 
<!-- Bootstrap Core JavaScript --> 
<script src="js/new/bootstrap.min.js"></script> 
<script src="js/new/imagesloaded.pkgd.min.js" type="text/javascript"></script> 
<script src="js/new/plugins.js" type="text/javascript"></script> 
<script type="text/javascript" src="js/new/jquery.jcarousel.min.js"></script> 
<script type="text/javascript" src="js/new/jcarousel.responsive.js"></script> 
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script> 
</body>
</html>