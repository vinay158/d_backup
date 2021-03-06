<?php $this->load->view('includes/footer/footer_nav'); ?>
<?php  $this->load->view('includes/footer/footer_aside'); ?>
<?php  $this->load->view('includes/footer/footer_bottom'); ?>


<style>
#google_translate_element {height: 0px;margin-top: -17px;}
.goog-te-banner-frame.skiptranslate {
    display: none !important;
    } 
body {top: 0px !important; }
.goog-logo-link {
    display:none !important;
} 
    
.goog-te-gadget{
    color: transparent !important;
}

.goog-te-combo *{ }

.goog-te-combo{
	//background-color: rgba(255,255,255,0.20) !important;
	//border: 1px solid rgba(255,255,255,0.50) !important;
	border: 1px solid #de1f26  !important;
	padding: 8px !important;
	//border-radius: 4px !important;
	font-size: 14px !important;
	line-height: 2rem !important;
	color:#fff;
	font-weight: bold;
	background: #de1f26;
	height: 38px;
	width: 142px;
	font-family: 'Helvetica Neue LT W01_55 Roman';
	margin-left: -15px !important;
}
</style>
<?php 
//echo '<pre>_COOKIE'; print_r($_COOKIE); 
/*if (isset($_COOKIE['googtrans'])) {
	unset($_COOKIE['googtrans']);
	setcookie('googtrans', null, -1, '/'); 
	//setcookie('googtrans', '/en/fr');
}else{
	unset($_COOKIE['googtrans']);
	setcookie('googtrans', '/en/fr');
}*/
 ?>
<script type="text/javascript">
function googleTranslateElementInit() {
  //new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages: "nl,en,fr,de,no,es,sv" }, 'google_translate_element');

  new google.translate.TranslateElement({pageLanguage: 'en', defaultLanguage: 'fr',includedLanguages: "nl,en,fr,de,no,es,sv" }, 'google_translate_element');
}



$(window).load(function(){
	/* $('select.goog-te-combo option')
		.filter(function() {
			return !this.value || $.trim(this.value).length == 0 || $.trim(this.text).length == 0;
		})
		.remove();
	*/
	$('.goog-te-combo option:first').text('English');
});

</script>
<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

  <?php 
	$thankyouMessage = $this->session->userdata('thankyouMessage');
	$is_mat_api_apply = $this->session->userdata('is_mat_api_apply');
	if(!empty($thankyouMessage)){
		$this->query_model->saveFormDataOnMATApi($thankyouMessage);
	}
  ?>
<?php $phoneNumberMaxLength = $this->query_model->phoneNumberMaxLength(); ?>
<?php $this->query_model->generatingUniqueIds();  ?>
<input type="hidden" id="site_currency_type" value="<?php echo $this->query_model->getSiteCurrencyType(); ?>" >
<?php 
  $website_settings = $this->query_model->getbySpecific('tblsite','id', 1);
  //if($website_settings[0]->phone_required == 0){
  if($website_settings[0]->international_phone_fields != 1){ ?>
<script>
  function set(elem)
  {
  	var x = '';
  	var error_class = $(elem).attr("error_class");
  	var value = $(elem).val();
  	value = value.replace(/\s+/g, '');
  	if (!$.isNumeric(value )) { 
  		$(elem).after('<div class="reds '+error_class+' "><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
  		$(elem).val('');
  	}
  	
  	if($(elem).val().length <= 3){
  		$(elem).after('<div class="reds '+error_class+' "><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
  	}else if($(elem).val().length <= 5 && $(elem).val().length > 3){
  		x = $(elem).val().replace(/\D/g, '').match(/(\d{3})/);
  		$(elem).val('' + x[1] + ' ');
  		$(elem).after('<div class="reds '+error_class+' "><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
  	}
  	else if($(elem).val().length <= 9 && $(elem).val().length > 3){
  		x = $(elem).val().replace(/\D/g, '').match(/(\d{3})(\d{3})/);
  		$(elem).val('' + x[1] + ' ' + x[2] + ' ');
  		$(elem).after('<div class="reds '+error_class+' "><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
  	}
  	else if($(elem).val().length <= 11 && $(elem).val().length > 9){
  		x = $(elem).val().replace(/\D/g, '').match(/(\d{3})(\d{3})(\d{4})/);
  		$(elem).val('' + x[1] + ' ' + x[2] + ' ' + x[3]);
  		$(elem).after('<div class="reds '+error_class+' "><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
  	}else{
  		x = $(elem).val().replace(/\D/g, '').match(/(\d{3})(\d{3})(\d{4})/);
  		$(elem).val('' + x[1] + ' ' + x[2] + ' ' + x[3]);
  	}
  	
  	
  	if($(elem).val().length <= 11){
  		$(elem).after('<div class="reds '+error_class+' "><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
  	  }else{
  		
  		$(elem).removeClass('phone_number');
  		
  		$('.'+error_class).hide();
  		
  	  }
     }
</script>
<?php } //} ?>
<script>
  function textAlphabatic(elem){
  	var error_class = $(elem).attr("error_class");
  	var error_msg = $(elem).attr("error_msg");
  	var field_name = $(elem).attr("name");
	
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
  
  function phoneValidation(elem){
  	var error_class = $(elem).attr("error_class");
  	var value = $(elem).val();
  	//var int_value = (int)value;
  	//alert(int_value);
  	<?php 
    if($website_settings[0]->international_phone_fields != 1){
    	if($website_settings[0]->phone_required == 1){ ?>
  			if(value.length <= <?php echo $phoneNumberMaxLength - 1; ?>){
  				$(elem).after('<div class="reds '+error_class+' "><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
  				$(elem).val(value);
  			}else if(value.length > <?php echo $phoneNumberMaxLength; ?>){
  				$(elem).after('<div class="reds '+error_class+' "><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
  				$(elem).val(value);
  			}else{
  				$('.'+error_class).hide();
  			}
  			<?php }else{ ?>
  			if(value.length <= <?php echo $phoneNumberMaxLength - 1; ?> && value.length > 0){
  				$(elem).after('<div class="reds '+error_class+' "><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
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
  					$(elem).after('<div class="reds '+error_class+'"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
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
  							$(elem).after('<div class="reds '+error_class+'"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
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
<script src="js/v5/jquery.mask_new2.js" type="text/javascript"></script>
<script>
  $(document).ready(function(){
  	$('.phone_number').mask('(000) 000-0000');
	
	<?php if($website_settings[0]->international_phone_masking == 1 && !empty($website_settings[0]->international_phone_masking_format)){ ?>
		var international_phone_masking_format = "<?php echo $website_settings[0]->international_phone_masking_format; ?>";
		$('.international_phone_number').mask(international_phone_masking_format);
	<?php } ?>
  	
  	// getting contact slug onchange location dropdown
  	$('body').on('change','.getContactPageUrl', function()
  	{
  		if($(this).val() != '')
  		{
  			
  			var location_slug = $('option:selected', this).attr('slug');
  			
  			<?php $contact_slug = $this->query_model->getbySpecific('tblmeta', 'id', 38); ?>
  			
  			var contact_url = '/<?php echo !empty($contact_slug) ? $contact_slug[0]->slug : ''; ?>/'+location_slug;
  			
  			$('.conatct_page_url').val(contact_url);
  		}
  	})
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
  	
  	
  	
  	/*function getContactPageUrl(location_name){
  		var location  = $(location_name).attr('slug');
  		alert(location); return false;
  		
  	} */
  	
  	
  
   
</script>


	
<?php 
  $currentpageurl = '';
   if(isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] != '/'){
   $folder_name = $_SERVER['CONTEXT_PREFIX'];
   $_SERVER['REQUEST_URI'] = str_replace($folder_name,'',$_SERVER['REQUEST_URI']);
   
   $currentpageurl = explode('/',$_SERVER['REQUEST_URI']);
   
   $currentpageurl = $currentpageurl[1];
  
   
   $contactMetaUrl = $this->query_model->getbySpecific('tblmeta', 'id', 38);
   
   $contactMetaUrl = $contactMetaUrl[0];
   if($contactMetaUrl->slug == $currentpageurl){
    $currentpageurl = $contactMetaUrl->slug;
   } else {
    $currentpageurl = '';
   }
   
  } 
  
  
  $home_program_map_zoom = '';
  $multiLocation = $this->query_model->getbyTable("tblconfigcalendar");
  if($multiLocation[0]->field_value == 1){
  $site_set = $this->query_model->getbyTable("tblsite");
  $folder_name = $_SERVER['CONTEXT_PREFIX'];
  $_SERVER['REQUEST_URI'] = str_replace($folder_name,'',$_SERVER['REQUEST_URI']);
  $page_slug = explode('/',$_SERVER['REQUEST_URI']);
  //echo '<pre>'; print_r($page_slug); die;
  $program_slug = $this->query_model->getbySpecific('tblmeta', 'id', 30);
  if(!empty($page_slug[1])){
  	if( $page_slug[1] == $program_slug[0]->slug){
  		$home_program_map_zoom = $site_set[0]->home_program_map_zoom;	
  	}else{
  		$home_program_map_zoom = '';
  	}
  }else{
  	$home_program_map_zoom = $site_set[0]->home_program_map_zoom;	
  }
  }
  
  
  
  ?>
<!-- jQuery -->
<!-- <script src="js/new/jquery.js"></script>
  --> <script src="js/new/main.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="js/new/bootstrap.min.js"></script>
<!-- Script to Activate the Carousel -->
<script>
$('.carousel_testi').carousel({
      interval: 6000 //changes the speed
  
  })
  
  $('.carousel_slider').carousel({
      interval: 5000 //changes the speed
  
  })
  
  $('.carousel').carousel({
      interval: false //changes the speed
  
  })
</script>
<script type="text/javascript">
  $(document).ready(function(){
      $('.google-maps').click(function () {
          $('.google-maps iframe').css("pointer-events", "auto");
      });
  });
</script>
<script src="js/v5/imagesloaded.pkgd.min.js" type="text/javascript"></script> 
<script src="js/v5/plugins.js" type="text/javascript"></script> 
<script type="text/javascript" src="js/v5/jquery.jcarousel.min.js"></script> 
<script type="text/javascript" src="js/v5/jcarousel.responsive.js"></script>
		
	<?php if($this->query_model->get_gdpr_compliant() == 1){ ?>	
		<link rel="stylesheet" href="cookie_disclamier/css/cookieDisclaimer.css">
       <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
        <script src="cookie_disclamier/jquery.cookieDisclaimer.js"></script>

		<script>
			$(function() {
				$('body').cookieDisclaimer({
                    style: "dark",
                    text: '<?php echo $this->query_model->getStaticTextTranslation('cookies_disclimer'); ?>',
                    policyBtn: {
                        active: false,
                        text: "Click Here",
                        link: "http://www.jqueryscript.net/privacy/"
                    },
					acceptBtn: {
                         text: "Close",
                    }
				});
                var cd = $('body').data('plugin_cookieDisclaimer');
                cd.cookiesList('html','#cookieList');
			});

		</script>
	<?php } ?>
	
<?php $cronJobs = $this->query_model->checkCronJobsForCoupons(); ?>


<script>
$(window).load(function(){
	<?php  
		if($this->query_model->showProgramsListOnFroms() == 1){
			$this->db->where('id',1);
			$multiLocation = $this->query_model->getByTable('tblconfigcalendar');
			
			if($multiLocation[0]->field_value == 1){
	?>
		$('.form_program_dropdown').attr('disabled',true);
		<?php } } ?>
		

	$.each($('.form_location_dropdown'), function(){
		var location_id  = $(this).val();
		var number = $(this).attr('number');
		
		if(location_id != ''){
			
			$.ajax({

						url : '<?php echo base_url("site/get_program_ids_by_location_id"); ?>',
							type : 'POST',
							dataType :'json',
							data :{location_id:location_id},
							success:function(data){
								if(data != ''){
									
									$('.program_dropdown_'+number).empty();
									
									$('.program_dropdown_'+number).append('<option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_program'); ?></option>');
									$.each(data, function(index, element) {
										$('.program_dropdown_'+number).append('<option value="'+element.id+'">'+element.program+'</option>');
									});
									
									$('.program_dropdown_'+number).removeAttr('disabled');
									
								}
							}

					});
		}
	})
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
		
		
		$('.form_location_dropdown').change(function(){
				var location_id = $(this).val();
				var number = $(this).attr('number');
				//alert(number); return false;
				if(location_id != '' || location_id != null){
					$.ajax({

						url : '<?php echo base_url("site/get_program_ids_by_location_id"); ?>',
							type : 'POST',
							dataType :'json',
							data :{location_id:location_id},
							success:function(data){
								if(data != ''){
									
									$('.program_dropdown_'+number).empty();
									
									$('.program_dropdown_'+number).append('<option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_program'); ?></option>');
									$.each(data, function(index, element) {
										$('.program_dropdown_'+number).append('<option value="'+element.id+'">'+element.program+'</option>');
									});
									
									$('.program_dropdown_'+number).removeAttr('disabled');
									//$(this).parent().parent('form').find('.form_program_dropdown').removeAttr('disabled');
								//	$('.form_location_dropdown').removeAttr('disabled');
									
								}
							}

					});
				}
				
			})
			
			
		$('.trial_offer_button').click(function(){
			var redirect_url = $(this).attr('url');
			
			$('.redirect_url').val(redirect_url);
			$('#trial_offer_link_form').submit();
			
			
		})
		
		$('.nestedSchoolLocation').click(function(){
			var location_id = $(this).attr('location_id');
			
			if(location_id != '' && location_id > 0){
				$.ajax({

						url : '<?php echo base_url("site/ajaxPopupForNestedSchool"); ?>',
							type : 'POST',
							dataType :'html',
							data :{location_id:location_id},
							success:function(data){
								//alert(data);
								$('.nestedSchoolPopup').html(data);
							}
					});
			}
		})
	})
</script>
<div class="nestedSchoolPopup"></div>

		
<?php $site_settings = $this->query_model->getbyTable("tblsite"); ?>
<?php if($_SERVER['SERVER_NAME'] != 'dojoservers.com'){ ?>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $site_settings[0]->map_api_key; ?>&libraries=places&callback=initMap"></script>
<?php }else{ ?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<?php } ?> 
<!-- AIzaSyAKxOnTZybksn5qmhRCKoslYLQN0gB8XnE -->
<!-- script for small map 1 -->
<?php if(!empty($allLocations) && count($allLocations) > 1): ?> 

<?php 
	$i = 1;
	foreach($allLocations as $location){
		 $map_marker_info = $this->query_model->getMapPinAddress($location->slug, $location->name, $location->address, $location->suite, $location->city, $location->state, $location->zip, $currentpageurl);
?>
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
  	
  	
   		var myLatlng = new google.maps.LatLng(<?= $location->latitude ?>, <?= $location->longitude ?>);
  		
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $location->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  			
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('location_map_'+'<?php echo $i; ?>'), mapOptions);
  	
  	
  	map.set('styles', [
   {
     featureType: 'administrative',
     elementType: 'labels.text.fill',
     stylers: [
       { color: '#444444' }
     ]
   }, {
     featureType: 'landscape',
     elementType: 'all',
     stylers: [
       {  color: '#f2f2f2'  }
     ]
   }, {
     featureType: 'poi',
     elementType: 'all',
     stylers: [
       { visibility:"off" }
     ]
   }, {
     featureType: 'road',
     elementType: 'all',
     stylers: [
       { saturation:-100 },
       { lightness: 45 }
     ]
   }
   
   
   , {
     featureType: 'road.highway',
     elementType: 'all',
     stylers: [
       { visibility:'simplified' }
     ]
   }, {
     featureType: 'road.arterial',
     elementType: 'labels.icon',
     stylers: [
       { visibility:"off" }
     ]
   }, {
     featureType: 'transit',
     elementType: 'all',
     stylers: [
       { visibility:"off" }
     ]
   }, {
     featureType: 'water',
     elementType: 'all',
     stylers: [
       { color:"#91d5e4" },
       { visibility:"on" }
     ]
   }
   
   
   , {
     featureType: 'water',
     elementType: 'geometry.fill',
     stylers: [
       { lightness:"55" }
     ]
   }
   , {
     featureType: 'water',
     elementType: 'labels.text.fill',
     stylers: [
       { color:"#ceedf3"},
       { visibility:"off" },
       {weight:"0.01"}
     ]
   }
   , {
     featureType: 'water',
     elementType: 'labels.text.stroke',
     stylers: [
       { color:"#ceedf3" }
     ]
   }
   
  ]);
  	/****** Info Window Contents *******/
   		var contentString = '<?= $map_marker_info ?>';
  	
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: '<?php echo $location->name; ?>',
  			
  		});
  		map.panBy(0, -80);
   
  	/****** Info Window With Click *******/
  	google.maps.event.addListener(marker, 'click', function() {
  		infowindow.open(map,marker);
  	});
   
   		/****** Info Window Without Click *******/
     	infowindow.open(map,marker);
  }
  
  google.maps.event.addDomListener(window, 'load', initialize);
  
  
</script> 
<?php $i++; } ?>


<?php endif; ?>

<?php     

  if(isset($_GET['city']) && !empty($_GET['city'])){
    $allLocations = $this->query_model->getLocationsListByCity($_GET['city']);
	//echo '<pre>allLocations'; print_r($allLocations); die;
  }
?>


<script>
  var infowindow = null;
  google.maps.event.addDomListener(window, 'load', initialize);
  <?php 
    $zoomLevel = 14;
    
	$multiSchoolValue = $this->query_model->getbyTable("tblconfigcalendar");
	$multiSchoolValue = isset($multiSchoolValue[11]) ? $multiSchoolValue[11]->field_value : 0;

	if(empty($mainLocation)){
      $mainLocation = $this->query_model->getMainLocation("tblcontact");
     }
    //echo '<pre>'; print_r($about_ContactDetail); die;
    if(!empty($contactDetail) && empty($about_ContactDetail)){
    	if(!empty($home_program_map_zoom)){
    		$zoomLevel = $home_program_map_zoom;
    	}else{
    		$zoomLevel = $contactDetail->single_map_zoom_level;
    	}
    	$mainLat = $contactDetail->latitude;
    	$mainLong = $contactDetail->longitude;
    	$mainLoca_id = $contactDetail->id;
    }elseif(!empty($about_ContactDetail)){
    		if(!empty($home_program_map_zoom)){
    			$zoomLevel = $home_program_map_zoom;
    		}else{
    			$zoomLevel = $about_ContactDetail[0]->single_map_zoom_level;
    		}
    		$mainLat = $about_ContactDetail[0]->latitude;
    		$mainLong = $about_ContactDetail[0]->longitude;
    		$mainLoca_id = $about_ContactDetail[0]->id;
    		
    } else {
    	$mainLat = $mainLocation[0]->latitude;
    	$mainLong = $mainLocation[0]->longitude;
    	if(!empty($multiLocation)){
    		if($multiLocation[0]->field_value == 0){
    			$mainLoca_id = $mainLocation[0]->id;
    		}else{
    			$mainLoca_id = 0;
    		}
    	}
    	
    	if(!empty($home_program_map_zoom)){
    		$zoomLevel = $home_program_map_zoom;
    	}else{
    		$zoomLevel = $mainLocation[0]->single_map_zoom_level;
    	}
    }
	
	if(isset($_GET['city']) && !empty($_GET['city'])){
			if(!empty($allLocations)){
				$mainLat = $allLocations[0]->latitude;
				$mainLong = $allLocations[0]->longitude;
				$zoomLevel = $allLocations[0]->single_map_zoom_level;
			}
	}else{
		if($multiSchoolValue == 1){
			$mainLat = '40.847724';
			$mainLong = '-111.588134';
			$zoomLevel = 4;
			
			if(preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"])){
				$mainLat = '38.283284';
				$mainLong = '-94.681077';
			}
		}
	}
	
	
		if(preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"])){
			$zoomLevel = $zoomLevel - 1;
		}

    
    //home_program_map_zoom
    
    
    ?>
  function initialize() {
    var centerMap = new google.maps.LatLng(<?= $mainLat; ?>, <?= $mainLong; ?>);
  var isDraggable = $(document).width() > 768 ? true : false;
     var myOptions = {
   draggable: isDraggable,
      zoom: <?= $zoomLevel; ?>,
      center: centerMap,
      scrollwheel: false,
      mapTypeId: 'roadmap', 
  zoomControlOptions: true,
      zoomControlOptions : {
           position    : google.maps.ControlPosition.RIGHT_TOP,
      },
    }
  
    var map = new google.maps.Map(document.getElementById("map_div5"), myOptions);
  map.set('styles', [
  {
  featureType: 'administrative',
  elementType: 'labels.text.fill',
  stylers: [
    { color: '#444444' }
  ]
  }, {
  featureType: 'landscape',
  elementType: 'all',
  stylers: [
    {  color: '#f2f2f2'  }
  ]
  }, {
  featureType: 'poi',
  elementType: 'all',
  stylers: [
    { visibility:"off" }
  ]
  }, {
  featureType: 'road',
  elementType: 'all',
  stylers: [
    { saturation:-100 },
    { lightness: 45 }
  ]
  }
  
  
  , {
  featureType: 'road.highway',
  elementType: 'all',
  stylers: [
    { visibility:'simplified' }
  ]
  }, {
  featureType: 'road.arterial',
  elementType: 'labels.icon',
  stylers: [
    { visibility:"off" }
  ]
  }, {
  featureType: 'transit',
  elementType: 'all',
  stylers: [
    { visibility:"off" }
  ]
  }, {
  featureType: 'water',
  elementType: 'all',
  stylers: [
    { color:"#91d5e4" },
    { visibility:"on" }
  ]
  }
  
  
  , {
  featureType: 'water',
  
  elementType: 'geometry.fill',
  stylers: [
    { lightness:"55" }
  ]
  }
  , {
  featureType: 'water',
  elementType: 'labels.text.fill',
  stylers: [
    { color:"#ceedf3"},
    { visibility:"off" },
    {weight:"0.01"}
  ]
  }
  , {
  featureType: 'water',
  elementType: 'labels.text.stroke',
  stylers: [
    { color:"#ceedf3" }
  ]
  }
  
  ]);
    setMarkers(map, sites);
  
   
  }
  <?php //echo '<pre>'; print_r($mainLocation); die; ?>
  <?php if($multiLocation[0]->field_value == 0): 
   // $mainLocationAddress = $mainLocation[0]->address.' '.$mainLocation[0]->city.' '.$mainLocation[0]->zip.' '.$mainLocation[0]->state;
   
   if(!empty($location->large_map_url)){
			$viewLargeMapUrl = $location->large_map_url;
		}else{
			$mainLocationAddress = $mainLocation[0]->address.' '.$mainLocation[0]->city.' '.$mainLocation[0]->zip.' '.$mainLocation[0]->state;
			$viewLargeMapUrl = 'https://www.google.com/maps/place/'.urlencode($mainLocationAddress);
		}
    ?>
  var sites = [
      ["<?php echo  $mainLocation[0]->name; ?>", '<?php echo  $mainLocation[0]->latitude; ?>', '<?php echo  $mainLocation[0]->longitude; ?>', <?php echo  $mainLocation[0]->id; ?>, '<div id="content-map"><h3  id="firstHeading" class="firstHeading">'+"<?php  echo  $mainLocation[0]->name; ?>"+'</h3><?= $mainLocation[0]->address; ?><?php if($mainLocation[0]->suite != ''){ echo ', '.$mainLocation[0]->suite; } ?></br><?php echo  $mainLocation[0]->city.', '.$mainLocation[0]->state.' '.$mainLocation[0]->zip.'</br><a href="'.$viewLargeMapUrl.'" target="_blank">View Larger Map</a></div>'; ?>'],
  
  ];
  <?php endif; ?>
  
  <?php 	if($multiLocation[0]->field_value == 1): ?>
  var sites = [
  <?php
    $loc = 1;
    foreach($allLocations as $location): 
    	if($location->latitude != '' || $location->longitude != ''):
    	
		//$multiLvationAddress = $location->address.' '.$location->city.' '.$location->zip.' '.$location->state;
		
		if(!empty($location->large_map_url)){
			$viewLargeMapUrl = $location->large_map_url;
		}else{
			$multiLvationAddress = $location->address.' '.$location->city.' '.$location->zip.' '.$location->state;
			$viewLargeMapUrl = 'https://www.google.com/maps/place/'.urlencode($multiLvationAddress);
		}
		
    ?>
  ["<?php echo $location->name; ?>", '<?php echo  $location->latitude; ?>', '<?php echo  $location->longitude; ?>', <?php echo $location->id; ?>, '<div id="content-map"><h3  id="firstHeading" class="firstHeading">'+"<?php echo  $location->name; ?>"+'</h3><?= $location->address; ?><?php if($location->suite != ''){ echo ', '.$location->suite; } ?></br><?php echo  $location->city.', '.$location->state.' '.$location->zip.'</br><a href="'.$viewLargeMapUrl.'" target="_blank">View Larger Map</a></div>'; ?>'],
  
  <?php endif; $loc++; endforeach; ?><?php echo '];'; ?><?php endif; ?>
  
  
  function setMarkers(map, markers) {
    for (var i = 0; i < markers.length; i++) {
      var sites = markers[i];
      var siteLatLng = new google.maps.LatLng(sites[1], sites[2]);
      var marker = new google.maps.Marker({
        position: siteLatLng,
        map: map,
        title: sites[0],
        zIndex: sites[3],
        html: sites[4]
      });
      var infowindow = new google.maps.InfoWindow({
        content: sites[4],
        maxWidth: 200
      });
  if(sites[3]==<?= $mainLoca_id; ?>)
      infowindow.open(map, marker);
  
      google.maps.event.addListener(marker, "click", function() {
        infowindow.setContent(this.html);
        infowindow.open(map, this);
      });
    }
  }
</script>


<style>
.map_manage .gm-style{top: 60px !important;}
</style>
<div class="gmap_hover_effect_box">
<style> 
.gm-ui-hover-effect { display: none !important; } /* remove infoWindow x */ 
</style>
</div>
<div id="map_classic" style="width: 100%; height: 0px !important;"></div>
 
  <script type="text/javascript">
   
    var locations = [
      ['Yukon', 65, -135, 1]
    ];
 
    var map = new google.maps.Map(document.getElementById('map_classic'), {
      zoom: 16,
      center: new google.maps.LatLng(40.7027497, -73.9870991),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
 
    var infowindow = new google.maps.InfoWindow();
    var marker, i;
    var bounds = new google.maps.LatLngBounds();   
 
    for (i = 0; i < locations.length; i++) { 
        marker = new google.maps.Marker({
          position: new google.maps.LatLng(locations[i][1], locations[i][2]),
          map: map
      });
 
	//map.panBy(0, -80);
      // click for info on each marker
      google.maps.event.addListener(marker, 'click', (function(marker, i) {
		  
		  
        return function() { 
		infowindow.setContent(locations[i][0]); 
		infowindow.open(map, marker); 
			
		}
      })(marker, i));
 
      // open info by default
      infowindow = new google.maps.InfoWindow({ content: locations[i][0], disableAutoPan: true, });
      infowindow.open(map, marker);
 
        bounds.extend(marker.position);     
    }
    map.fitBounds(bounds);
	
  </script>
   <script>
	$(window).load(function(){
		
		setTimeout(function() {
			
			$('.gm-ui-hover-effect').attr('style','background: rgba(0, 0, 0, 0) none repeat scroll 0% 0%;display: block !important;border: 0px none;margin: 0px;padding: 0px;text-transform: none;appearance: none;position: absolute;cursor: pointer;user-select: none;top: -6px;right: -6px;width: 30px;height: 30px;');
			
			$('.gmap_hover_effect_box').remove();
		 // alert('pass');
	}, 5000);
	})
</script>



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
  		//echo '<pre>'; print_r($pageurl); die;
  		if(isset($pageurl[1])){
  			$pageurl = $pageurl[1];
  		}
  		if(isset($pageurl_2[2])){
  			$action_url = $pageurl_2[2];
  		}
  	}
  
  
  $folder_name = $_SERVER['CONTEXT_PREFIX'];
  $slug = str_replace($folder_name,'',$_SERVER['REQUEST_URI']);
  
  
   
  
  //$folder_name = $_SERVER['CONTEXT_PREFIX'];
  //$slug = str_replace('/dojo_demov3/','',$_SERVER['REQUEST_URI']);
  
  if(!empty($slug)){
  	
  	if($pageurl == $student_section_slug->slug && $action_url == 'videos'){
  			$video_slug = '/'.$student_section_slug->slug.'/videos';
  			$addCodeForCurrentPage = $this->query_model->getbySpecific('tbladdcode','page_slug',$video_slug);
  		}else{
  			$addCodeForCurrentPage = $this->query_model->getbySpecific('tbladdcode','page_slug',$slug);
  		}
  	
  	
  	//$addCodeForCurrentPage = $this->query_model->getbySpecific('tbladdcode','page_slug',$slug);
  	$override_code_footer = array();
  	if(!empty($addCodeForCurrentPage)){
  		foreach($addCodeForCurrentPage as $addCodeForCurrent){
  			if($addCodeForCurrent->header_code_placed == 'above_body_tag'){
  				if($addCodeForCurrent->code_checked == 1){
  					$override_code_footer[] = $addCodeForCurrent->id;
  				}
  				$this->query_model->getStrReplace($addCodeForCurrent->header_code);
  			 }
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
  			if($addCodeAllPage->header_code_placed == 'above_body_tag'){
  				$this->query_model->getStrReplace($addCodeAllPage->header_code);
  			}
  		 }
  }		 
  ?>
  
  
 
</body>
</html>