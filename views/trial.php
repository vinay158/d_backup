<?php $this->load->view('includes/header'); ?>

<?php  $this->load->view('includes/header/masthead'); ?>
<?php $phoneNumberMaxLength = $this->query_model->phoneNumberMaxLength(); 

	  $getPhoneNumberClass = $this->query_model->getPhoneNumberClass(); 
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<?php if(!empty($header)){ ?>
<section class="top-section" style="background-image:url('<?php echo 'upload/onlinespecial/'.$header->left_photo; ?>')  !important;">
         <span class="overlay" style="<?php echo !empty($header->background_color) ? 'background:'.$header->background_color : ''; ?>"></span>
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="text-center top-block">
				  <?= $this->query_model->getDescReplace($header->title); ?>
                  </div>
               </div>
            </div>
         </div>
      </section>
<?php } ?>

	<?php 
		if(!empty($onlinespecialRows)){
				foreach($onlinespecialRows as $row){
					if($row->photo_side == "right"){
		?>	
      <section id="toggle-block" class="clearfix">
         <div class="content-box">
            <h2><?= $this->query_model->getDescReplace($row->title); ?></h2>
            <p><?= $this->query_model->getDescReplace($row->description); ?></p>
            </div>
  
            <div class="relative-block">
                <div class="full-bg-toggle"  style="background-image:url('<?php echo 'upload/onlinespecial/'.$row->photo; ?>')  !important;"></div>
            </div>
      </section>
					<?php }else{ ?>
					
					<section id="toggle-block" class="clearfix">
						<div class="relative-block  toggle-b-set">
								<div class="full-bg-toggle"  style="background-image:url('<?php echo 'upload/onlinespecial/'.$row->photo; ?>')  !important;"></div>
							</div>
							
						 <div class="content-box  block-right">
							<h2><?= $this->query_model->getDescReplace($row->title); ?></h2>
							<p><?= $this->query_model->getDescReplace($row->description); ?></p>
							</div>
				  
							
					  </section>
					<?php } ?>
		<?php } } ?>
		
	<?php if(!empty($text_sections)){ ?>
	  <section id="user-ad">
         <div class="container">
            <div class="row">
               <div class="col-md-3"> 
                  <div class="owner-img">
                     <img src="<?php echo 'upload/onlinespecial/'.$text_sections->photo; ?>" class="img-responsive">
                  </div>
               </div>
               <div class="col-md-9">
                  <p><?= $this->query_model->getDescReplace($text_sections->description); ?></p>
               </div>
            </div>
         </div>
      </section>	
	<?php } ?>	  
	  
	  
	<?php if(!empty($trial_categories)){ ?>
	  <script>
	  $(document).ready(function(){
		
		
		$('.trialButton').click(function(){
			
				$.each($('.activeTrial'), function(){
					$(this).removeClass('activeTrial');
				});
				
				$.each($('.trial_offer_checkbox'), function(){
					$(this).attr("checked", false);
				});
				
				$.each($('.selectedOffer'), function(){
					$(this).html("Select");
				});
				
				var offer_id = $(this).attr('id');
				
				$('#check'+offer_id).addClass('activeTrial');
				$('#checkbox_'+offer_id).prop( "checked", true );
				$('.selectedTrial'+offer_id).html('Selected');
				$('.trialErrorMessage').html('');
				$('.trial_cat_id_mini_form').val(offer_id);
				$('.trial_cat_id_full_form').val(offer_id);
			});
		
		
		
	  });
	  </script>
      <section id="web-offers">
         <div class="flex-box">
		 <?php 
			$i = 0;
			foreach($trial_categories as $trial_cat){ 
				
				$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
				
				$this->db->where("published", 1);
				$this->db->where("cat_id", $trial_cat->id);
				$offers = $this->query_model->getbyTable("$tblspecialoffer");

				if($i % 2 == 0){
					$block_class = 'left-block';
					$box_class = ' left-g';
				}else{
					$block_class = 'right-block';
					$box_class = ' right-g';
				}
		?>
               <div class="<?=$block_class ?>">
                  <h3> <?php $this->query_model->getDescReplace($trial_cat->heading); ?></h3>
                  <h2> <?php $this->query_model->getDescReplace($trial_cat->name); ?></h2>
				  <?php if(count($offers) > 0){ ?>
                  <p><?php echo count($offers); ?> Web Specials Available</p>
                  <div id="<?=$trial_cat->id; ?>" class="check-select trialButton">
				  
				<?php 
				if(!empty($email_options)){
					if($email_options->require_opt_in == 1){ 
				?>
                     <a  id="check<?=$trial_cat->id; ?>"  href="javascript:void(0)" class="btn-animate  white-btn check ">
                   <div class="control-group <?php echo $box_class; ?>">
                         <label class="control control-checkbox">
                            <span class="selectedOffer selectedTrial<?=$trial_cat->id; ?>"> Select</span>
                                 <input id="checkbox_<?=$trial_cat->id; ?>" type="checkbox" class="trial_offer_checkbox" />
                             <div class="control_indicator"></div>
                         </label>
                        
                     </div>
                     </a>
				  
				  <?php }else{?>
						<a   href="javascript:void(0)" class="btn-animate white-btn check ">
						   <div class="control-group <?php echo $box_class; ?>">
								 <label class="control control-checkbox text-center">
									<span class="selectedTrial<?=$trial_cat->id; ?>"> Select</span>
								 </label>
								
							 </div>
							 </a>
				  <?php } } ?>
				  
                  </div>
				  <?php }else{?>
					 <p>No Web Specials Available</p>
					 <?php } ?>
                  </div>
				  
			   <?php $i++; } ?>
            </div>
		 
         </div>
      </section>
	<?php } ?>  
	
	
	<?php 
		$showMiniform = 0;
		if(!empty($email_options)){
			if($email_options->require_opt_in == 0){
				$showMiniform = 0;
			}else{
				if($email_options->show_full_form == 1){
					$showMiniform = 2;
				}else{
					$showMiniform = 1;
				}
			}
		}
	  ?>

	<?php if($showMiniform != 0){ ?>
      <section class="trial-form inner-trial">
         <div class="container">
            <div class="row">
               <div class="col-md-12 text-center">
                  <h2>
				  <?php if(!empty($email_options) && !empty($email_options->text)) {
							$this->query_model->getDescReplace($email_options->text); 
				  }else{
					echo 'Opt-in to redeem current trial offers and view pricing & details:';  
				  }  ?>
				  </h2>
                
				
				<?php if($showMiniform == 1){ ?>
                  <div class="started-block">
                  <span></span>
				   <script>
		$(document).ready(function(){
			
			
		$('.contactFormSubmit_6').click(function(){
		
					var err = 0
					
					
					var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
					var email=$('#form_email_6').val();
					if(email.length == 0 || emailfilter.test($("#form_email_6").val()) == false){
						var err = 1;
						$('#form_email_6').after('<div class="reds email_error">Enter a valid email address</div>');
					}
					
					
					
					if(err == 0){
						$("#form_6").attr('action','<?=base_url()?>starttrial/saveLeadsByEmails');
						return true;
					} else{
						$("#form_6").attr('action','#');
						return false;
					}
			
			});
			
			
			$('#form_email_6').keyup(function(){
					var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
					var email=$('#form_email_6').val();
					if($(this).val().length > 0 || emailfilter.test($("#form_email_6").val()) == false){
						$('.email_error').hide();
					} else{
						$('#form_email_6').after('<div class="reds email_error">Enter a valid email address</div>');
						
					}
			});
			
			
		});

	</script>
	<form action="#"  method="post" class="get_started_form mini_form" id="form_6">
                  <div class="search-box">
                     <input type="text" class="form-control" id="form_email_6" name="form_email_2" placeholder="Enter your email address">
					 <input type="hidden" class="trial_cat_id_mini_form" name="trial_cat_id" value="0" />
					 <input type="hidden" name="page_url" value="/" />
					 
					 <input type="hidden" name="miniform" value="true" />
                     <button class="btn-red contactFormSubmit_6" name="submitEmail" value="submitEmail" type="submit" >Get Info</button>
                  </div>
			  </form>
				   </div>
		<?php } if($showMiniform == 2){ ?>
			
<div class="trial-form about-trial-form about-alt-bg">
  <div class="container">
    <div class="row">
			
            <script>
		$(document).ready(function(){
				
		$('.contactFormSubmit').click(function(){
		
					var err = 0
					var name=$('#first_name').val();
					//alert(name); return false;
					if(name.length == 0){
						var err = 1;
						$('#first_name').after('<div class="reds name_error">Enter your first name</div>');
					}
					
					var last_name=$('#last_name').val();
					if(last_name.length == 0){
						var err = 1;
						$('#last_name').after('<div class="reds last_name_error">Enter your last name</div>');
					}
					
					
										
					var telephoneId = 'telephone';
					var phoneError = 'phone_error';
					var telephone=$('#'+telephoneId).val();
					<?php 
						if($site_settings->international_phone_fields != 1){
							if($site_settings->phone_required == 1){ ?>
						if(telephone.length <= <?php echo $phoneNumberMaxLength - 1; ?> || telephone.length == 0){
							var err = 1;
							$('#'+telephoneId).after('<div class="reds '+phoneError+'">Enter a valid phone number</div>');
							
						} 
						<?php //}
						}else{ ?>
						
							if(telephone.length <= <?php echo $phoneNumberMaxLength - 1; ?> && telephone.length > 0){
									$('#'+telephoneId).after('<div class="reds '+phoneError+' ">Enter a valid phone number</div>');
									var err = 1;
								}else{
									//var err = 0;
									$('.'+phoneError).hide();
								}
					<?php 	} 
						}else{
							if($site_settings->phone_required == 1){
					?>
					
					
						var filter = /^[- +()]*[0-9][- +()0-9]*$/;
						if (filter.test(telephone)) {
							$('.'+phoneError).hide();
						}
						else {
							$('#'+telephoneId).after('<div class="reds '+phoneError+'">Enter a valid phone number</div>');
							var err = 1;
						}	
					<?php }else{ ?>
							if(telephone.length == 0){
								$('.'+phoneError).hide();
							}else{
								var filter = /^[- +()]*[0-9][- +()0-9]*$/;
								if (filter.test(telephone)) {
									$('.'+phoneError).hide();
								}
								else {
									$('#'+telephoneId).after('<div class="reds '+phoneError+'">Enter a valid phone number</div>');
									var err = 1;
								}	
							}	
					<?php		}	?> 
					
					<?php }?>
						
						
					
					var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
					var email=$('#form_email').val();
					if(email.length == 0 || emailfilter.test($("#form_email").val()) == false){
						var err = 1;
						$('#form_email').after('<div class="reds email_error">Enter a valid email address</div>');
					}
					
					
					<?php if($multiLocation[0]->field_value == 1 ){ ?>
					var school=$('#school').val();
					if(school == '' || school == null){
						var err = 1;
						$('#school').after('<div class="reds school_name_error">Select your location</div>');
					}
					<?php } ?>
					
					
					
					//alert(err); return false;
					if(err == 0){
						return true;
					} else{
						return false;
					}
			
			});
			
			
			$('#first_name').keyup(function(){
					if($(this).val().length > 0){
						$('.name_error').hide();
					} else{
						$('#first_name').after('<div class="reds name_error">Enter your first name</div>');
						
					}
			});
			
			$('#last_name').keyup(function(){
					if($(this).val().length > 0){
						$('.last_name_error').hide();
					} else{
						$('#last_name').after('<div class="reds last_name_error">Enter your last name</div>');
						
					}
			});
			
			$('#telephone').keyup(function(){
					
					
					$('.phone_error').hide();
			});
			
			
			$('#form_email').keyup(function(){
					var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
					var email=$('#form_email').val();
					if($(this).val().length > 0 || emailfilter.test($("#form_email").val()) == false){
						$('.email_error').hide();
					} else{
						$('#form_email').after('<div class="reds email_error">Enter a valid email address</div>');
						
					}
			});
			
			<?php if($multiLocation[0]->field_value == 1 ){ ?>
			$('#school').change(function(){
					if($(this).val() != ''){
						$('.school_name_error').hide();
					} else{
						$('.school_name_error').show();
						$('#school').after('<div class="reds school_name_error">Select your location</div>');
						
					}
			});
			<?php } ?>
			
			
		});

	</script>
      
    </div>
    <div class="row">
      <div class="col-xs-12">
        <form action="<?=base_url()?>online-special"  method="post" class="get_started_form mini_form online-trial-fullform" >
		  
            <div class="inline_mid_form " >
              <input type="text" id="first_name" name="name" class="contact-form-line" placeholder="First Name" onfocus="this.placeholder = ''"   onBlur="textAlphabatic(this)" maxlength="25" error_class="name_error" error_msg="Enter your first name" >
              <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
           <div class="inline_mid_form " >
              <input type="text" name="last_name" id="last_name" class="contact-form-line" placeholder="Last Name"  onfocus="this.placeholder = ''" onBlur="textAlphabatic(this)" maxlength="25" error_class="last_name_error" error_msg="Enter your last name"  >
              <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
            <div class="inline_mid_form " >
              <input type="email" name="form_email_2" id="form_email" class="contact-form-line" placeholder="Email" onfocus="this.placeholder = ''" onBlur="this.placeholder = 'Email'"  >
              <span class="fa fa-envelope form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
            <div class="inline_mid_form " >
			
			
			<input type="text" name="phone" id="telephone" class="contact-form-line <?php echo $getPhoneNumberClass; ?>" placeholder="Phone" onfocus="this.placeholder = ''" error_class="phone_error" onBlur="phoneValidation(this)" maxlength="<?php echo $phoneNumberMaxLength; ?>"   >
			
              <span class="fa fa-phone form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
            <?php if($multiLocation[0]->field_value == 1  && count($form_allLocations) >= 1){ ?>
		    <div class="inline_mid_form " >
              <select class="locationBox contact-form-line" name="school_interest" id="school">
               <option value="">Choose a Location</option>
					<?php foreach($form_allLocations as $location): ?>
						<option  value="<?=$location->id;?>" <?php if($mainLocation[0]->id == $location->id){ echo 'selected=selected'; }?>><?=$location->name;?> </option>
					<?php endforeach;?>   
              </select>
              <span class="fa fa-map-marker form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
			 <?php } ?>
            <div class="<?php if($multiLocation[0]->field_value == 0){ echo 'inline_mid_form singleLocationFormButton'; }?> started-btn" >
				<input type="hidden" name="miniform" value="true" />
                <input type="text" id="website" name="website"  style="display:none;"  autocomplete="off">
				<input type="hidden" name="page_url" value="<?php echo isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';  ?>" />
				<input type="hidden" class="trial_cat_id_full_form" name="trial_cat_id" value="0" />
              <input class="mini_formSubmit contactFormSubmit  submit <?php if($multiLocation[0]->field_value == 0){ echo 'getStartedMargin'; } else { echo 'getStartedMarginAuto'; } ?>" type="submit" class="" value="GET STARTED" />
            </div>
          </form>
      </div>
    </div>
  </div>
</div>

		
		<?php } ?>
               </div>
            </div>
         </div>
      </section>
	<?php } ?>
	
	 <?php if(!empty($myTestimonials)): ?>
      <section id="testi-block" class="testimonial testimonial-trial">
         <div class="container">
            <div class="row">
			<?php 
				$n = 1;
				foreach($myTestimonials as $testimonial):
				?>
                <div class="col-md-12 col-sm-12 col-xs-12">
                                 <div class="caption">
                                    <div class="slide-text">
                                       <div class="quote"> 
                                         <?php if(!empty($testimonial->photo)){ ?>
                                          <img src="<?php echo $testimonial->photo; ?>">
										   <?php }else{?>
											<i class="fa fa-quote-right fa-3x"></i>
										   <?php } ?>
                                       </div>
                                       <div class="testimonial-desc">
                                          <small class="arrow"></small>
                                          <p class="desc"><?= 
										    $this->query_model->getStrReplace(strip_tags(html_entity_decode($testimonial->content))); 
										  ?>
										  </p>
                                          <p class="f-name"><?= $this->query_model->getStrReplace($testimonial->name); ?></p>
                                          <p class="accent-txt d-txt"><?= $this->query_model->getStrReplace($testimonial->title); ?></p>
                                       </div>
                                    </div>
                                 </div>
                              </div>

				<?php 
					$n++; 
					endforeach; 
				?>
							  </div>
         </div>
     </section>
        <?php endif; ?>
	
  <section class="map-main">
    <div id="location-map">
      <div id="map_div5"></div>
    </div>
    <!-- form -->
	
    <section class="mobile-contact">
      <div class="container">
        <div class="row">
           <div class="col-sm-12 text-center"> 
		
		  <a href="tel:<?= $mainLocation[0]->phone ?>" class="callNow"><span class="no"><?= $mainLocation[0]->phone ?></span></a>
          <p class="normal_text">
		  	<?php echo  $this->query_model->getFullAddress($mainLocation[0]->address,$mainLocation[0]->suite,$mainLocation[0]->city,$mainLocation[0]->state,$mainLocation[0]->zip); ?>
		</p>
		
          <div class="row">
            <?php if($site_settings->hide_window != 'hide'): ?>
            <div class="col-xs-6 row-btn"> 
			<a class="btn btn-theme"  href="<?php echo $this->query_model->getTrialOfferUrl($site_settings->url_call_to_action); ?>" target="<?php if($site_settings->window == 'new'): echo '_blank'; endif; ?>"> 
			<?php $this->query_model->getStrReplace($site_settings->call_to_action); ?></a> 
			</div>
			<?php endif; ?><div class="col-xs-6 row-btn"> 
			<?php if($multiLocation[0]->field_value == 1 ){ ?>
				<a class="btn btn-theme" href="javascript:void(0);"  target="_blank"> <i class="fa fa-map-marker"></i> <?php echo ' '.count($allLocations).' Locations'; ?></a>
			<?php } else{ ?>
			<a class="btn btn-theme" href="<?php echo  $this->query_model->getFindUs($mainLocation[0]->address,$mainLocation[0]->suite,$mainLocation[0]->city,$mainLocation[0]->state,$mainLocation[0]->zip); ?>"  target="_blank"> <i class="fa fa-map-marker"></i> Find Us </a>
			<?php } ?>
			 </div>
          </div>
        </div>
        </div>
      </div>
    </section>
    <div class="outer-form">
	
	<script>
		
		$(document).ready(function(){
				
		$('.contactFormSubmitOffer').click(function(){
		
					var err = 0
					var name=$('#first_name1').val();
					
					if(name.length == 0){
						var err = 1;
						$('#first_name1').after('<div class="reds name_error1">Enter your first name</div>');
					}
					
					var last_name=$('#last_name1').val();
					if(last_name.length == 0){
						var err = 1;
						$('#last_name1').after('<div class="reds last_name_error1">Enter your last name</div>');
					}
					
					/*var telephone=$('#telephone1').val();
					<?php if($settings->phone_required == 1 ){ ?>
                                                <?php if($settings->international_phone_fields != 1){ ?>
						if(telephone.length <= 11 || telephone.length == 0){
							var err = 1;
							$('#telephone1').after('<div class="reds phone_error1">Enter a valid phone number</div>');
							
						} 
                    <?php } } ?> */
					var telephoneId = 'telephone1';
					var phoneError = 'phone_error1';
					var telephone=$('#'+telephoneId).val();
					<?php 
						if($settings->international_phone_fields != 1){
							if($settings->phone_required == 1){ ?>
						if(telephone.length <= <?php echo $phoneNumberMaxLength - 1; ?> || telephone.length == 0){
							var err = 1;
							$('#'+telephoneId).after('<div class="reds '+phoneError+'">Enter a valid phone number</div>');
							
						} 
						<?php //}
						}else{ ?>
						
							if(telephone.length <= <?php echo $phoneNumberMaxLength - 1; ?> && telephone.length > 0){
									$('#'+telephoneId).after('<div class="reds '+phoneError+' ">Enter a valid phone number</div>');
									var err = 1;
								}else{
									//var err = 0;
									$('.'+phoneError).hide();
								}
					<?php 	} 
						}else{
							if($settings->phone_required == 1){
					?>
					
					
						var filter = /^[- +()]*[0-9][- +()0-9]*$/;
						if (filter.test(telephone)) {
							$('.'+phoneError).hide();
						}
						else {
							$('#'+telephoneId).after('<div class="reds '+phoneError+'">Enter a valid phone number</div>');
							var err = 1;
						}	
					<?php }else{ ?>
							if(telephone.length == 0){
								$('.'+phoneError).hide();
							}else{
								var filter = /^[- +()]*[0-9][- +()0-9]*$/;
								if (filter.test(telephone)) {
									$('.'+phoneError).hide();
								}
								else {
									$('#'+telephoneId).after('<div class="reds '+phoneError+'">Enter a valid phone number</div>');
									var err = 1;
								}	
							}	
					<?php		}	?> 
					
					<?php }?>
						
						
					
					var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
					var email=$('#form_email1').val();
					if(email.length == 0 || emailfilter.test($("#form_email1").val()) == false){
						var err = 1;
						$('#form_email1').after('<div class="reds email_error1">Enter a valid email address</div>');
					}
					//school1
					
					<?php if($multiLocation[0]->field_value == 1 ){ ?>
					var school=$('#school1').val();
					if(school == '' || school == null){
						var err = 1;
						$('#school1').after('<div class="reds school_name_error1">Select your location</div>');
					}
					<?php } ?>
					
					var message=$('#message1').val();
					//alert(name); return false;
					if(message.length == 0){
						var err = 1;
						$('#message1').after('<div class="message_error message_error1">Enter your message</div>');
					}
					
					
					//alert(err); return false;
					if(err == 0){
						return true;
					} else{
						return false;
					}
			
			});
			
			
			$('#first_name1').keyup(function(){
					if($(this).val().length > 0){
						$('.name_error1').hide();
					} else{
						$('#first_name1').after('<div class="reds name_error1">Enter your first name</div>');
						
					}
			});
			
			$('#last_name1').keyup(function(){
					if($(this).val().length > 0){
						$('.last_name_error1').hide();
					} else{
						$('#last_name1').after('<div class="reds last_name_error1">Enter your last name</div>');
						
					}
			});
			
			

			$('#telephone1').keyup(function(){
					/*if($(this).val().length <= 11){
						
						<?php if($settings->phone_required == 0){ ?>
							if($(this).val().length == 0){
								$('.phone_error1').hide();
							}else{
                                                             <?php if($settings->international_phone_fields == 1){ ?>
                                                                $('.phone_error1').hide();
                                                            <?php  }else{ ?>
								$('#telephone1').after('<div class="reds phone_error1">Enter a valid phone number</div>');
                                                            <?php  } ?>
							}
						<?php }else{ ?>
                                                             <?php if($settings->international_phone_fields == 1){ ?>
                                                                $('.phone_error1').hide();
                                                            <?php  }else{ ?>
								$('#telephone1').after('<div class="reds phone_error1">Enter a valid phone number</div>');
						 <?php  } ?>
                                                <?php } ?>
						
					}
					
					if($(this).val().length == 12){
						$('.phone_error1').hide();
						
					} */
					
					$('.phone_error1').hide();
			});
			
			
			$('#form_email1').keyup(function(){
					if($(this).val().length > 0){
						$('.email_error1').hide();
					} else{
						$('#form_email1').after('<div class="reds email_error1">Enter a valid email address</div>');
						
					}
			});
			
			/*$('#form_email1').keyup(function(){
					var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
					var email=$('#form_email1').val();
					if($(this).val().length > 0 || emailfilter.test($("#form_email1").val()) == false){
						$('.email_error1').hide();
					} else{
						$('#form_email1').after('<div class="reds email_error1">Enter a valid email address</div>');
						
					}
			}); */
			
			
			<?php if($multiLocation[0]->field_value == 1 ){ ?>
			$('#school1').change(function(){
					if($(this).val() != ''){
						$('.school_name_error1').hide();
					} else{
						$('.school_name_error1').show();
						$('#school1').after('<div class="reds school_name_error1">Select your location</div>');
						
					}
			});
			<?php } ?>
			
			$('#message1').keyup(function(){
					if($(this).val().length > 0){
						$('.message_error1').hide();
					} else{
						$('#message1').after('<div class="message_error message_error1">Enter your first name</div>');
						
					}
			});
			
			
		});

	</script>
	
     <form class="d-bg-c contact-form content_contact_form" action="contactus/send" method="post" >
	 <input type="hidden" name="hid_location" value="<?= !empty($contactDetail) ? $contactDetail->id : '' ?>" />
	  <div class="message">
				<div id="alert"></div>
	  </div>
	    <div style="position:relative;">
		
          <input type="text" name="name" id="first_name1"  class="contact-form-line" placeholder="First Name" onFocus="this.placeholder = ''"   onBlur="textAlphabatic(this)" maxlength="25" error_class="name_error1" error_msg="Enter your first name" >
          <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
          <div style="position:relative;">
          <input type="text" name="last_name" id="last_name1" class="contact-form-line" placeholder="Last Name" onFocus="this.placeholder = ''"  onBlur="textAlphabatic(this)" maxlength="25" error_class="last_name_error1" error_msg="Enter your last name" >
          <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
        <div style="position:relative;">
          <input type="text" name="phone"id="telephone1" class="contact-form-line <?php echo $getPhoneNumberClass; ?>" placeholder="Phone" onFocus="this.placeholder = ''"  error_class="phone_error1" onBlur="phoneValidation(this)" maxlength="<?php echo $phoneNumberMaxLength; ?>" >
          <span class="fa fa-phone form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
        <div style="position:relative;">
          <input type="email"  name="form_email_2" id="form_email1"  class="contact-form-line" placeholder="Email" onFocus="this.placeholder = ''" onBlur="this.placeholder = 'Email'">
          <span class="fa fa-envelope form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
         
		<div style="position:relative;">
		<?php if($multiLocation[0]->field_value == 1 ){ ?>
          <select class="locationBox contact-form-line getContactPageUrl" id="school1" name="school">
            <option value="">Choose a Location</option>
					<?php foreach($form_allLocations as $location): ?>
						<option  value="<?=$location->name;?>" <?php //if($mainLocation[0]->id == $location->id){ echo 'selected=selected'; }?> slug="<?=$location->slug;?>"><?=$location->name;?> </option>
					<?php endforeach;?>   
          </select>
		  <?php } ?>
          <span class="fa fa-map-marker form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
		  
		
        <div style="position:relative;"> <span class="site_theme_text fa fa-comment form-control-feedback move_input_icon" aria-hidden="true"></span>
          <textarea  name="message" id="message1" class="contact-form-area" placeholder="Message" onFocus="this.placeholder = ''" onBlur="this.placeholder = 'Message'"></textarea>
        </div>
		
		<input type="hidden" value="" name='email' id='email' class="submit button" style="display:none" />			
		<input type="text" id="website" name="website" style="display:none" autocomplete="off">
		<?php
			$contact_page_slug = $this->query_model->getConatctPageSlug();
		?>
		<input type="hidden" class="conatct_page_url" name="page_url" value="<?php echo !empty($contact_page_slug) ? $contact_page_slug : '/'; ?>" />
        <input type="submit" value="Send Message" class="btn btn-readmore  btn-block submit button contactFormSubmitOffer">
      </form>
      <div class="clearfix"></div>
    </div>
  </section>
  


<script src="js/new/jquery-1.11.0.js"></script>
<!--<script src="js/new/jquery.maskedinput.js"></script>
<script type="text/javascript">
jQuery(function($){
   $(".phone_number").mask("999-999-9999",{placeholder:""});
});
</script>-->
<?php $this->load->view('includes/footer'); ?> 
     