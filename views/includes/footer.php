<?php $this->load->view('includes/footer/footer_nav'); ?>
<?php  $this->load->view('includes/footer/footer_aside'); ?>
<?php  $this->load->view('includes/footer/footer_bottom'); ?>

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
<?php if(count($allLocations) == 2){ 
  $address1 = $this->query_model->getMapPinAddress($allLocations[0]->slug, $allLocations[0]->name, $allLocations[0]->address, $allLocations[0]->suite, $allLocations[0]->city, $allLocations[0]->state, $allLocations[0]->zip, $currentpageurl);
  
  $address2 = $this->query_model->getMapPinAddress($allLocations[1]->slug, $allLocations[1]->name, $allLocations[1]->address, $allLocations[1]->suite, $allLocations[1]->city, $allLocations[1]->state, $allLocations[1]->zip, $currentpageurl);
  ?>
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
  	
  	
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[0]->latitude ?>, <?= $allLocations[0]->longitude ?>);
  		
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[0]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  			
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div1'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address1 ?>';
  	
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 2 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[1]->latitude ?>, <?= $allLocations[1]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[1]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div2'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address2 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<?php } ?>
<!-- script for small map 3 -->
<?php if(count($allLocations) == 3){ //$allLocations[0]->name
  //$address1 = $allLocations[0]->address.' '.$allLocations[0]->suite.' , '.$allLocations[0]->city.' , ' .$allLocations[0]->state.' , '.$allLocations[0]->zip;
  $address1 = $this->query_model->getMapPinAddress($allLocations[0]->slug, $allLocations[0]->name, $allLocations[0]->address, $allLocations[0]->suite, $allLocations[0]->city, $allLocations[0]->state, $allLocations[0]->zip, $currentpageurl);
  
  $address2 = $this->query_model->getMapPinAddress($allLocations[1]->slug, $allLocations[1]->name, $allLocations[1]->address, $allLocations[1]->suite, $allLocations[1]->city, $allLocations[1]->state, $allLocations[1]->zip, $currentpageurl);
  
  
  $address3 = $this->query_model->getMapPinAddress($allLocations[2]->slug, $allLocations[2]->name, $allLocations[2]->address, $allLocations[2]->suite, $allLocations[2]->city, $allLocations[2]->state, $allLocations[2]->zip, $currentpageurl);
  
  ?>
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[0]->latitude ?>, <?= $allLocations[0]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[0]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div3'), mapOptions);
  	
  	
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
   		var contentString = '<?php echo $address1 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 4 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[1]->latitude ?>, <?= $allLocations[1]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[1]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div4'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address2 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 1 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[2]->latitude ?>, <?= $allLocations[2]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[2]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div6'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address3 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<?php } ?>
<!-- script for small map 1 -->
<?php if(count($allLocations) == 4){ //$allLocations[0]->name
  $address1 = $this->query_model->getMapPinAddress($allLocations[0]->slug, $allLocations[0]->name, $allLocations[0]->address, $allLocations[0]->suite, $allLocations[0]->city, $allLocations[0]->state, $allLocations[0]->zip, $currentpageurl);
  
  $address2 = $this->query_model->getMapPinAddress($allLocations[1]->slug, $allLocations[1]->name, $allLocations[1]->address, $allLocations[1]->suite, $allLocations[1]->city, $allLocations[1]->state, $allLocations[1]->zip, $currentpageurl);
  
  
  $address3 = $this->query_model->getMapPinAddress($allLocations[2]->slug, $allLocations[2]->name, $allLocations[2]->address, $allLocations[2]->suite, $allLocations[2]->city, $allLocations[2]->state, $allLocations[2]->zip, $currentpageurl);
  
  $address4 = $this->query_model->getMapPinAddress($allLocations[3]->slug, $allLocations[3]->name, $allLocations[3]->address, $allLocations[3]->suite, $allLocations[3]->city, $allLocations[3]->state, $allLocations[3]->zip, $currentpageurl);
  
  
  ?>
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[0]->latitude ?>, <?= $allLocations[0]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[0]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div7'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address1 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 4 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[1]->latitude ?>, <?= $allLocations[1]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[1]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div8'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address2 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 1 -->
<script type="text/javascript">
  function initialize() {
  	
  
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[2]->latitude ?>, <?= $allLocations[2]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[2]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div9'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address3 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 10 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[3]->latitude ?>, <?= $allLocations[3]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[3]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div10'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address4 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<?php } ?>
<!-- script for small map 10 -->
<script>
  /*
  * declare map as a global variable
  */
  var map;
  
  /*
  * use google maps api built-in mechanism to attach dom events
  */
  
  google.maps.event.addDomListener(window, "load", function () {
  
  /*
  * create map
  */
  var map = new google.maps.Map(document.getElementById("map_div11"), {
  center: new google.maps.LatLng(40.5210516, -79.8575581),
  zoom: 12,
  mapTypeId: google.maps.MapTypeId.ROADMAP,
  disableDefaultUI: true,
   scrollwheel: false,
  navigationControl: false,
  mapTypeControl: false,
  scaleControl: false,
  draggable: true
  });
  
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
  
  /*
  * create infowindow (which will be used by markers)
  */
  var infoWindow = new google.maps.InfoWindow();
  
  /*
  * marker creater function (acts as a closure for html parameter)
  */
  function createMarker(options, html) {
  var marker = new google.maps.Marker(options);
  
  if (html) {
    google.maps.event.addListener(marker, "click", function () {
      infoWindow.setContent(html);
      infoWindow.open(options.map, this);
    });
    
    
   
  }
  return marker;
  
  
   var marker1 = new google.maps.Marker(options);
  
  if (html) {
    google.maps.event.addListener(marker1, "click", function () {
      infoWindow.setContent(html);
      infoWindow.open(options.map, this);
    });
    
    
   
  }
  return marker;
  }
  
  /*
  * add markers to map
  */
  
  
  var marker2 = createMarker({
  position: new google.maps.LatLng(40.5210516, -79.8575581),
  map: map
  }, '<div id="content-map">'+
                        
                        '<h3  id="firstHeading" class="firstHeading">123 Street Name, City, ST 12345</h3>'+
                        
                        '<a href="#">View Larger Map</a>'+
                        '</div>'+
                        '</div>');
  
  
  });
</script> 
<!-- script for small map 10 -->
<script>
  /*
  * declare map as a global variable
  */
  var map;
  
  /*
  * use google maps api built-in mechanism to attach dom events
  */
  
  google.maps.event.addDomListener(window, "load", function () {
  
  /*
  * create map
  */
  var map = new google.maps.Map(document.getElementById("map_div12"), {
  center: new google.maps.LatLng(40.5210516, -79.8575581),
  zoom: 12,
  mapTypeId: google.maps.MapTypeId.ROADMAP,
  disableDefaultUI: true,
   scrollwheel: false,
  navigationControl: false,
  mapTypeControl: false,
  scaleControl: false,
  draggable: true
  });
  
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
  
  /*
  * create infowindow (which will be used by markers)
  */
  var infoWindow = new google.maps.InfoWindow();
  
  /*
  * marker creater function (acts as a closure for html parameter)
  */
  function createMarker(options, html) {
  var marker = new google.maps.Marker(options);
  
  if (html) {
    google.maps.event.addListener(marker, "click", function () {
      infoWindow.setContent(html);
      infoWindow.open(options.map, this);
    });
    
    
   
  }
  return marker;
  
  
   var marker1 = new google.maps.Marker(options);
  
  if (html) {
    google.maps.event.addListener(marker1, "click", function () {
      infoWindow.setContent(html);
      infoWindow.open(options.map, this);
    });
    
    
   
  }
  return marker;
  }
  
  /*
  * add markers to map
  */
  
  
  var marker2 = createMarker({
  position: new google.maps.LatLng(40.5210516, -79.8575581),
  map: map
  }, '<div id="content-map">'+
                        
                        '<h3  id="firstHeading" class="firstHeading">123 Street Name, City, ST 12345</h3>'+
                        
                        '<a href="#">View Larger Map</a>'+
                        '</div>'+
                        '</div>');
  
  
  });
</script> 
<!-- script for small map 10 -->
<script>
  /*
  * declare map as a global variable
  */
  var map;
  
  /*
  * use google maps api built-in mechanism to attach dom events
  */
  
  google.maps.event.addDomListener(window, "load", function () {
  
  /*
  * create map
  */
  var map = new google.maps.Map(document.getElementById("map_div13"), {
  center: new google.maps.LatLng(40.5210516, -79.8575581),
  zoom: 12,
  mapTypeId: google.maps.MapTypeId.ROADMAP,
  disableDefaultUI: true,
   scrollwheel: false,
  navigationControl: false,
  mapTypeControl: false,
  scaleControl: false,
  draggable: true
  });
  
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
  
  /*
  * create infowindow (which will be used by markers)
  */
  var infoWindow = new google.maps.InfoWindow();
  
  /*
  * marker creater function (acts as a closure for html parameter)
  */
  function createMarker(options, html) {
  var marker = new google.maps.Marker(options);
  
  if (html) {
    google.maps.event.addListener(marker, "click", function () {
      infoWindow.setContent(html);
      infoWindow.open(options.map, this);
    });
    
    
   
  }
  return marker;
  
  
   var marker1 = new google.maps.Marker(options);
  
  if (html) {
    google.maps.event.addListener(marker1, "click", function () {
      infoWindow.setContent(html);
      infoWindow.open(options.map, this);
    });
    
    
   
  }
  return marker;
  }
  
  /*
  * add markers to map
  */
  
  
  var marker2 = createMarker({
  position: new google.maps.LatLng(40.5210516, -79.8575581),
  map: map
  }, '<div id="content-map">'+
                        
                        '<h3  id="firstHeading" class="firstHeading">123 Street Name, City, ST 12345</h3>'+
                        
                        '<a href="#">View Larger Map</a>'+
                        '</div>'+
                        '</div>');
  
  
  });
</script> 
<!-- script for small map 10 -->
<script>
  /*
  * declare map as a global variable
  */
  var map;
  
  /*
  * use google maps api built-in mechanism to attach dom events
  */
  
  google.maps.event.addDomListener(window, "load", function () {
  
  /*
  * create map
  */
  var map = new google.maps.Map(document.getElementById("map_div14"), {
  center: new google.maps.LatLng(40.5210516, -79.8575581),
  zoom: 12,
  mapTypeId: google.maps.MapTypeId.ROADMAP,
  disableDefaultUI: true,
   scrollwheel: false,
  navigationControl: false,
  mapTypeControl: false,
  scaleControl: false,
  draggable: true
  });
  
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
  
  /*
  * create infowindow (which will be used by markers)
  */
  var infoWindow = new google.maps.InfoWindow();
  
  /*
  * marker creater function (acts as a closure for html parameter)
  */
  function createMarker(options, html) {
  var marker = new google.maps.Marker(options);
  
  if (html) {
    google.maps.event.addListener(marker, "click", function () {
      infoWindow.setContent(html);
      infoWindow.open(options.map, this);
    });
    
    
   
  }
  return marker;
  
  
   var marker1 = new google.maps.Marker(options);
  
  if (html) {
    google.maps.event.addListener(marker1, "click", function () {
      infoWindow.setContent(html);
      infoWindow.open(options.map, this);
    });
    
    
   
  }
  return marker;
  }
  
  /*
  * add markers to map
  */
  
  
  var marker2 = createMarker({
  position: new google.maps.LatLng(40.5210516, -79.8575581),
  
  map: map
  }, '<div id="content-map">'+
                        
                        '<h3  id="firstHeading" class="firstHeading">123 Street Name, City, ST 12345</h3>'+
                        
                        '<a href="#">View Larger Map</a>'+
                        '</div>'+
                        '</div>');
  
  
  });
</script> 
<!-- script for small map 10 -->
<?php  if(count($allLocations) == 6){ //$allLocations[0]->name
  $address1 = $this->query_model->getMapPinAddress($allLocations[0]->slug, $allLocations[0]->name, $allLocations[0]->address, $allLocations[0]->suite, $allLocations[0]->city, $allLocations[0]->state, $allLocations[0]->zip, $currentpageurl);
  	
  	$address2 = $this->query_model->getMapPinAddress($allLocations[1]->slug, $allLocations[1]->name, $allLocations[1]->address, $allLocations[1]->suite, $allLocations[1]->city, $allLocations[1]->state, $allLocations[1]->zip, $currentpageurl);
  	
  	
  	$address3 = $this->query_model->getMapPinAddress($allLocations[2]->slug, $allLocations[2]->name, $allLocations[2]->address, $allLocations[2]->suite, $allLocations[2]->city, $allLocations[2]->state, $allLocations[2]->zip, $currentpageurl);
  	
  	$address4 = $this->query_model->getMapPinAddress($allLocations[3]->slug, $allLocations[3]->name, $allLocations[3]->address, $allLocations[3]->suite, $allLocations[3]->city, $allLocations[3]->state, $allLocations[3]->zip, $currentpageurl);
  	
  	$address5 = $this->query_model->getMapPinAddress($allLocations[4]->slug, $allLocations[4]->name, $allLocations[4]->address, $allLocations[4]->suite, $allLocations[4]->city, $allLocations[4]->state, $allLocations[4]->zip, $currentpageurl);
  	
  	$address6 = $this->query_model->getMapPinAddress($allLocations[5]->slug, $allLocations[5]->name, $allLocations[5]->address, $allLocations[5]->suite, $allLocations[5]->city, $allLocations[5]->state, $allLocations[5]->zip, $currentpageurl);
  	
  	
  ?>
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[0]->latitude ?>, <?= $allLocations[0]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[0]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div15'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address1 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 4 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[1]->latitude ?>, <?= $allLocations[1]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[1]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div16'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address2 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 1 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[2]->latitude ?>, <?= $allLocations[2]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[2]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div17'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address3 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 10 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[3]->latitude ?>, <?= $allLocations[3]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[3]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div18'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address4 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 10 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[4]->latitude ?>, <?= $allLocations[4]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[4]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div19'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address5 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 10 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[5]->latitude ?>, <?= $allLocations[5]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[5]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div20'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address6 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<?php } ?>
<?php  if(count($allLocations) == 7){ //$allLocations[0]->name
  $address1 = $this->query_model->getMapPinAddress($allLocations[0]->slug, $allLocations[0]->name, $allLocations[0]->address, $allLocations[0]->suite, $allLocations[0]->city, $allLocations[0]->state, $allLocations[0]->zip, $currentpageurl);
  
  $address2 = $this->query_model->getMapPinAddress($allLocations[1]->slug, $allLocations[1]->name, $allLocations[1]->address, $allLocations[1]->suite, $allLocations[1]->city, $allLocations[1]->state, $allLocations[1]->zip, $currentpageurl);
  
  
  $address3 = $this->query_model->getMapPinAddress($allLocations[2]->slug, $allLocations[2]->name, $allLocations[2]->address, $allLocations[2]->suite, $allLocations[2]->city, $allLocations[2]->state, $allLocations[2]->zip, $currentpageurl);
  
  $address4 = $this->query_model->getMapPinAddress($allLocations[3]->slug, $allLocations[3]->name, $allLocations[3]->address, $allLocations[3]->suite, $allLocations[3]->city, $allLocations[3]->state, $allLocations[3]->zip, $currentpageurl);
  
  $address5 = $this->query_model->getMapPinAddress($allLocations[4]->slug, $allLocations[4]->name, $allLocations[4]->address, $allLocations[4]->suite, $allLocations[4]->city, $allLocations[4]->state, $allLocations[4]->zip, $currentpageurl);
  
  $address6 = $this->query_model->getMapPinAddress($allLocations[5]->slug, $allLocations[5]->name, $allLocations[5]->address, $allLocations[5]->suite, $allLocations[5]->city, $allLocations[5]->state, $allLocations[5]->zip, $currentpageurl);
  
  $address7 = $this->query_model->getMapPinAddress($allLocations[6]->slug, $allLocations[6]->name, $allLocations[6]->address, $allLocations[6]->suite, $allLocations[6]->city, $allLocations[6]->state, $allLocations[6]->zip, $currentpageurl);
  
  ?>
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[0]->latitude ?>, <?= $allLocations[0]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[0]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div21'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address1 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 4 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[1]->latitude ?>, <?= $allLocations[1]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[1]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div22'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address2 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 1 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[2]->latitude ?>, <?= $allLocations[2]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[2]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div23'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address3 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 10 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[3]->latitude ?>, <?= $allLocations[3]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[3]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div24'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address4 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 10 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[4]->latitude ?>, <?= $allLocations[4]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[4]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div25'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address5 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 10 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[5]->latitude ?>, <?= $allLocations[5]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[5]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div26'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address6 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 10 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[6]->latitude ?>, <?= $allLocations[6]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[6]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div27'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address7 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<?php } ?>
<?php  if(count($allLocations) == 8){ //$allLocations[0]->name
  $address1 = $this->query_model->getMapPinAddress($allLocations[0]->slug, $allLocations[0]->name, $allLocations[0]->address, $allLocations[0]->suite, $allLocations[0]->city, $allLocations[0]->state, $allLocations[0]->zip, $currentpageurl);
  	
  	$address2 = $this->query_model->getMapPinAddress($allLocations[1]->slug, $allLocations[1]->name, $allLocations[1]->address, $allLocations[1]->suite, $allLocations[1]->city, $allLocations[1]->state, $allLocations[1]->zip, $currentpageurl);
  	
  	
  	$address3 = $this->query_model->getMapPinAddress($allLocations[2]->slug, $allLocations[2]->name, $allLocations[2]->address, $allLocations[2]->suite, $allLocations[2]->city, $allLocations[2]->state, $allLocations[2]->zip, $currentpageurl);
  	
  	$address4 = $this->query_model->getMapPinAddress($allLocations[3]->slug, $allLocations[3]->name, $allLocations[3]->address, $allLocations[3]->suite, $allLocations[3]->city, $allLocations[3]->state, $allLocations[3]->zip, $currentpageurl);
  	
  	$address5 = $this->query_model->getMapPinAddress($allLocations[4]->slug, $allLocations[4]->name, $allLocations[4]->address, $allLocations[4]->suite, $allLocations[4]->city, $allLocations[4]->state, $allLocations[4]->zip, $currentpageurl);
  	
  	$address6 = $this->query_model->getMapPinAddress($allLocations[5]->slug, $allLocations[5]->name, $allLocations[5]->address, $allLocations[5]->suite, $allLocations[5]->city, $allLocations[5]->state, $allLocations[5]->zip, $currentpageurl);
  	
  	$address7 = $this->query_model->getMapPinAddress($allLocations[6]->slug, $allLocations[6]->name, $allLocations[6]->address, $allLocations[6]->suite, $allLocations[6]->city, $allLocations[6]->state, $allLocations[6]->zip, $currentpageurl);
  	
  	$address8 = $this->query_model->getMapPinAddress($allLocations[7]->slug, $allLocations[7]->name, $allLocations[7]->address, $allLocations[7]->suite, $allLocations[7]->city, $allLocations[7]->state, $allLocations[7]->zip, $currentpageurl);
  ?>
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[0]->latitude ?>, <?= $allLocations[0]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[0]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div28'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address1 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 4 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[1]->latitude ?>, <?= $allLocations[1]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[1]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div29'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address2 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 1 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[2]->latitude ?>, <?= $allLocations[2]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[2]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div30'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address3 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 10 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[3]->latitude ?>, <?= $allLocations[3]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[3]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div31'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address4 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 10 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[4]->latitude ?>, <?= $allLocations[4]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[4]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div32'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address5 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 10 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[5]->latitude ?>, <?= $allLocations[5]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[5]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div33'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address6 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 10 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[6]->latitude ?>, <?= $allLocations[6]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[6]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div34'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address7 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 10 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[7]->latitude ?>, <?= $allLocations[7]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[7]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div35'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address8 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<?php } ?>
<?php  if(count($allLocations) == 9){ //$allLocations[0]->name
  $address1 = $this->query_model->getMapPinAddress($allLocations[0]->slug, $allLocations[0]->name, $allLocations[0]->address, $allLocations[0]->suite, $allLocations[0]->city, $allLocations[0]->state, $allLocations[0]->zip, $currentpageurl);
  
  $address2 = $this->query_model->getMapPinAddress($allLocations[1]->slug, $allLocations[1]->name, $allLocations[1]->address, $allLocations[1]->suite, $allLocations[1]->city, $allLocations[1]->state, $allLocations[1]->zip, $currentpageurl);
  
  
  $address3 = $this->query_model->getMapPinAddress($allLocations[2]->slug, $allLocations[2]->name, $allLocations[2]->address, $allLocations[2]->suite, $allLocations[2]->city, $allLocations[2]->state, $allLocations[2]->zip, $currentpageurl);
  
  $address4 = $this->query_model->getMapPinAddress($allLocations[3]->slug, $allLocations[3]->name, $allLocations[3]->address, $allLocations[3]->suite, $allLocations[3]->city, $allLocations[3]->state, $allLocations[3]->zip, $currentpageurl);
  
  $address5 = $this->query_model->getMapPinAddress($allLocations[4]->slug, $allLocations[4]->name, $allLocations[4]->address, $allLocations[4]->suite, $allLocations[4]->city, $allLocations[4]->state, $allLocations[4]->zip, $currentpageurl);
  
  $address6 = $this->query_model->getMapPinAddress($allLocations[5]->slug, $allLocations[5]->name, $allLocations[5]->address, $allLocations[5]->suite, $allLocations[5]->city, $allLocations[5]->state, $allLocations[5]->zip, $currentpageurl);
  
  $address7 = $this->query_model->getMapPinAddress($allLocations[6]->slug, $allLocations[6]->name, $allLocations[6]->address, $allLocations[6]->suite, $allLocations[6]->city, $allLocations[6]->state, $allLocations[6]->zip, $currentpageurl);
  
  $address8 = $this->query_model->getMapPinAddress($allLocations[7]->slug, $allLocations[7]->name, $allLocations[7]->address, $allLocations[7]->suite, $allLocations[7]->city, $allLocations[7]->state, $allLocations[7]->zip, $currentpageurl);
  
  $address9 =  $this->query_model->getMapPinAddress($allLocations[8]->slug, $allLocations[8]->name, $allLocations[8]->address, $allLocations[8]->suite, $allLocations[8]->city, $allLocations[8]->state, $allLocations[8]->zip, $currentpageurl);
  ?>
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[0]->latitude ?>, <?= $allLocations[0]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[0]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div40'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address1 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 4 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[1]->latitude ?>, <?= $allLocations[1]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[1]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div41'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address2 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 1 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[2]->latitude ?>, <?= $allLocations[2]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[2]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div42'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address3 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 10 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[3]->latitude ?>, <?= $allLocations[3]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[3]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div43'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address4 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 10 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[4]->latitude ?>, <?= $allLocations[4]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[4]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div44'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address5 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 10 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[5]->latitude ?>, <?= $allLocations[5]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[5]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div45'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address6 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 10 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[6]->latitude ?>, <?= $allLocations[6]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[6]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div46'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address7 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 10 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[7]->latitude ?>, <?= $allLocations[7]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[7]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div47'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address8 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[8]->latitude ?>, <?= $allLocations[8]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[8]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div48'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address9 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<?php } ?>
<?php  if(count($allLocations) == 10){ //$allLocations[0]->name
  $address1 = $this->query_model->getMapPinAddress($allLocations[0]->slug, $allLocations[0]->name, $allLocations[0]->address, $allLocations[0]->suite, $allLocations[0]->city, $allLocations[0]->state, $allLocations[0]->zip, $currentpageurl);
  	
  	$address2 = $this->query_model->getMapPinAddress($allLocations[1]->slug, $allLocations[1]->name, $allLocations[1]->address, $allLocations[1]->suite, $allLocations[1]->city, $allLocations[1]->state, $allLocations[1]->zip, $currentpageurl);
  	
  	
  	$address3 = $this->query_model->getMapPinAddress($allLocations[2]->slug, $allLocations[2]->name, $allLocations[2]->address, $allLocations[2]->suite, $allLocations[2]->city, $allLocations[2]->state, $allLocations[2]->zip, $currentpageurl);
  	
  	$address4 = $this->query_model->getMapPinAddress($allLocations[3]->slug, $allLocations[3]->name, $allLocations[3]->address, $allLocations[3]->suite, $allLocations[3]->city, $allLocations[3]->state, $allLocations[3]->zip, $currentpageurl);
  	
  	$address5 = $this->query_model->getMapPinAddress($allLocations[4]->slug, $allLocations[4]->name, $allLocations[4]->address, $allLocations[4]->suite, $allLocations[4]->city, $allLocations[4]->state, $allLocations[4]->zip, $currentpageurl);
  	
  	$address6 = $this->query_model->getMapPinAddress($allLocations[5]->slug, $allLocations[5]->name, $allLocations[5]->address, $allLocations[5]->suite, $allLocations[5]->city, $allLocations[5]->state, $allLocations[5]->zip, $currentpageurl);
  	
  	$address7 = $this->query_model->getMapPinAddress($allLocations[6]->slug, $allLocations[6]->name, $allLocations[6]->address, $allLocations[6]->suite, $allLocations[6]->city, $allLocations[6]->state, $allLocations[6]->zip, $currentpageurl);
  	
  	$address8 = $this->query_model->getMapPinAddress($allLocations[7]->slug, $allLocations[7]->name, $allLocations[7]->address, $allLocations[7]->suite, $allLocations[7]->city, $allLocations[7]->state, $allLocations[7]->zip, $currentpageurl);
  	
  	$address9 =  $this->query_model->getMapPinAddress($allLocations[8]->slug, $allLocations[8]->name, $allLocations[8]->address, $allLocations[8]->suite, $allLocations[8]->city, $allLocations[8]->state, $allLocations[8]->zip, $currentpageurl);
  	
  	$address10 = $this->query_model->getMapPinAddress($allLocations[9]->slug, $allLocations[9]->name, $allLocations[9]->address, $allLocations[9]->suite, $allLocations[9]->city, $allLocations[9]->state, $allLocations[9]->zip, $currentpageurl);
  	
  ?>
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[0]->latitude ?>, <?= $allLocations[0]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[0]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div51'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address1 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 4 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[1]->latitude ?>, <?= $allLocations[1]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[1]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div52'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address2 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 1 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[2]->latitude ?>, <?= $allLocations[2]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[2]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div53'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address3 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 10 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[3]->latitude ?>, <?= $allLocations[3]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[3]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div54'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address4 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 10 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[4]->latitude ?>, <?= $allLocations[4]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[4]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div55'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address5 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 10 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[5]->latitude ?>, <?= $allLocations[5]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[5]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
  
   		var map = new google.maps.Map(document.getElementById('map_div56'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address6 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 10 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[6]->latitude ?>, <?= $allLocations[6]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[6]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div57'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address7 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 10 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[7]->latitude ?>, <?= $allLocations[7]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[7]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div58'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address8 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[8]->latitude ?>, <?= $allLocations[8]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[8]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div59'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address9 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[9]->latitude ?>, <?= $allLocations[9]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[9]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div60'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address10 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<?php } ?>
<?php  if(count($allLocations) == 5){ //$allLocations[0]->name
  $address1 = $this->query_model->getMapPinAddress($allLocations[0]->slug, $allLocations[0]->name, $allLocations[0]->address, $allLocations[0]->suite, $allLocations[0]->city, $allLocations[0]->state, $allLocations[0]->zip, $currentpageurl);
  
  $address2 = $this->query_model->getMapPinAddress($allLocations[1]->slug, $allLocations[1]->name, $allLocations[1]->address, $allLocations[1]->suite, $allLocations[1]->city, $allLocations[1]->state, $allLocations[1]->zip, $currentpageurl);
  
  
  $address3 = $this->query_model->getMapPinAddress($allLocations[2]->slug, $allLocations[2]->name, $allLocations[2]->address, $allLocations[2]->suite, $allLocations[2]->city, $allLocations[2]->state, $allLocations[2]->zip, $currentpageurl);
  
  $address4 = $this->query_model->getMapPinAddress($allLocations[3]->slug, $allLocations[3]->name, $allLocations[3]->address, $allLocations[3]->suite, $allLocations[3]->city, $allLocations[3]->state, $allLocations[3]->zip, $currentpageurl);
  
  $address5 = $this->query_model->getMapPinAddress($allLocations[4]->slug, $allLocations[4]->name, $allLocations[4]->address, $allLocations[4]->suite, $allLocations[4]->city, $allLocations[4]->state, $allLocations[4]->zip, $currentpageurl);
  
  ?>
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[0]->latitude ?>, <?= $allLocations[0]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[0]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div5a'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address1 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 4 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[1]->latitude ?>, <?= $allLocations[1]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[1]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div5b'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address2 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 1 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[2]->latitude ?>, <?= $allLocations[2]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[2]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div5c'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address3 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 10 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[3]->latitude ?>, <?= $allLocations[3]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[3]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div5d'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address4 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<!-- script for small map 10 -->
<script type="text/javascript">
  function initialize() {
  	
  	/****** Change latitude and longitude here ******/
   		var myLatlng = new google.maps.LatLng(<?= $allLocations[4]->latitude ?>, <?= $allLocations[4]->longitude ?>);
  	
  	/****** Map Options *******/
   		var mapOptions = {
     			zoom: <?= $allLocations[4]->map_zoom_level ?>,
  			mapTypeId: google.maps.MapTypeId.ROADMAP,
  			disableDefaultUI: true,
  			scrollwheel: false,
  			navigationControl: false,
  			mapTypeControl: false,
  			scaleControl: false,
  			draggable: true,
     			center: myLatlng,
  	
  			
  			
   			};
  	
  	
   		var map = new google.maps.Map(document.getElementById('map_div5e'), mapOptions);
  	
  	
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
   		var contentString = '<?= $address5 ?>';
  
  	var infowindow = new google.maps.InfoWindow({
  	  		content: contentString,
  			disableAutoPan: true,
  			
  			
  		});
  	
  	/****** Map Marker Options *******/
  	var marker = new google.maps.Marker({
  	  		position: myLatlng,
  	  		map: map,
  	  		title: 'Googleplex (CodexWorld)',
  			
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
<?php } ?>
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