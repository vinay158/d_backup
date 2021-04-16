<?php $this->load->view('includes/header'); ?>
<?php  $this->load->view('includes/header/masthead'); ?>
<?php $phoneNumberMaxLength = $this->query_model->phoneNumberMaxLength(); 

	  $getPhoneNumberClass = $this->query_model->getPhoneNumberClass(); 
	  
	   $multiSchoolOrLocation = $this->query_model->checkMultiSchoolOrLocationIsOn();
	   
		 
 /*** getting gdpr text **/
$gdprCompliantText = $this->query_model->getGdprCompliantText();
 $gdpr_compliant_txt1 = (isset($gdprCompliantText['gdpr_compliant_txt1'])) ? $gdprCompliantText['gdpr_compliant_txt1'] : '';
 $gdpr_compliant_txt2 = (isset($gdprCompliantText['gdpr_compliant_txt2'])) ? $gdprCompliantText['gdpr_compliant_txt2'] : '';
 $gdpr_compliant_submit_btn_text = (isset($gdprCompliantText['gdpr_compliant_submit_btn_text'])) ? $gdprCompliantText['gdpr_compliant_submit_btn_text'] : '';
?>
<?php 

$_URL = array();

$query = $this->db->get( 'tblmeta' );

$result = $query->result();

foreach( $result as $row )

{

	if(!empty($row->slug) && !empty($row->page)) {

	$_URL[trim($row->slug)] = trim($row->page);

	}

}



$_SLUG = array('ourschool', 'ourfacility', 'ourstaff' , 'ourphilosophy', 'schoolrules', 'schoolrules', 'faq', 'events', 'news', 'videogallery','photogallery', 'ourprograms' , 'starttrial' , 'testimonials' , 'signin');


foreach($_SLUG as $needle) {

	$slug = array_search($needle, $_URL);

	if($slug == false) { $$needle = $needle; } 

	else { $$needle = $slug; } 

}

$mymainLocation = $this->query_model->getMainLocation();
?>


<style type="text/css">.fancybox-custom .fancybox-skin {box-shadow: 0 0 50px #222;}</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script>
	$(window).load(function(){
			
			$('#loader').show();
			$.ajax({
			
					url: '<?=base_url();?>schools/get_school_social_news_data/<?php echo $location_id; ?>',
					
					type: 'post',
					
					data: {type: 'social_news'},

					
					dataType: 'html',
					
					success: function(result) {
						$('#loader').hide();
						$('.socialNewsData').html(result);
						
						/*var $divs = $(".social_items");
						var numericallyOrderedDivs = $divs.sort(function (a, b) {
							return $(a).find("h2").text() < $(b).find("h2").text();
						});
						$("#social-news ul").html(numericallyOrderedDivs);*/
						
						$('#all_elements .social_items').sort(sortDescending).appendTo('#all_elements');
						
						function sortDescending(a, b) {
							var date1 = $(b).find("h2").text();
							var date2 = $(a).find("h2").text();
							 return (date1 < date2) ? -1 : (date1 > date2) ? 1 : 0;
						};
						
					}
				  
			});
	});
</script>

<style>
	.hidePosts{ display:none !important;}
</style>
<link rel="stylesheet" type="text/css" href="lightbox/jquery.fancybox.css?v=2.1.5" media="screen" />
	<script type="text/javascript" src="lightbox/lib/jquery-1.10.1.min.js"></script>
	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="lightbox/jquery.fancybox.js?v=2.1.5"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			/*
			 *  Simple image gallery. Uses default settings
			 */

			$('.fancybox').fancybox();

			/*
			 *  Different effects
			 */

			

			$('.fancybox').fancybox({
			  padding: 0,
			  helpers: {
				overlay: {
				  locked: false
				}
			  }
			});
		});
	</script>



	<?php if(!empty($schoolHeader)){ ?>
      <section class="section " id="school-top" style="background-image:url('<?php echo !empty($schoolHeader) ? 'upload/about_school_header/'.$schoolHeader[0]->left_photo : ''; ?>')  !important;">
         <span class="overlay"  style="<?php echo !empty($schoolHeader) ? 'background:'.$schoolHeader[0]->background_color : ''; ?>"></span>
         <span class="overlay-top"></span>
         <div class="container">
            <div class="row">
               <div class="offer-block-school">
                 <div class="col-sm-12 col-md-12">
                   <div class="row">
                     <div class="col-sm-6 col-md-5">
						 
                       <h2><?php if(!empty($schoolHeader) && !empty($schoolHeader[0]->opt1_title)) {
								$this->query_model->getDescReplace($schoolHeader[0]->opt1_title,$is_child_location,$original_location_id); 
					  }else{
						echo $this->query_model->getStaticTextTranslation('view_current_web_specials'). $locationDetail[0]->city.', '.$locationDetail[0]->state .'!';  
					  }  ?></h2>
                       <p><?php if(!empty($schoolHeader) && !empty($schoolHeader[0]->opt1_text)) {
								$this->query_model->getDescReplace($schoolHeader[0]->opt1_text,$is_child_location,$original_location_id); 
					  }?></p>
                     </div>
					 
					 <?php 
						$emailOnlyForm1 = 1;
						if(!empty($schoolHeader) && $schoolHeader[0]->show_full_form_1 == 1){
							$emailOnlyForm1 = 0;
						}
					  ?>
					  
					  <?php if($emailOnlyForm1 == 1){ ?>
					  
					   <script>
				   
						$(document).ready(function(){
							
							
						$('.contactFormSubmit_6').click(function(){
						
									var err = 0
									
									
									var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
									var email=$('#form_email_6').val();
									if(email.length == 0 || emailfilter.test($("#form_email_6").val()) == false){
										var err = 1;
										$('#form_email_6').after('<div class="reds email_error6"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
									}
									
							<?php if($multiSchoolOrLocation == 1 ){ ?>
							var school=$('#school_6').val();
							if(school == '' || school == null){
								var err = 1;
								$('#school_6').after('<div class="reds school_name_error6"><?php echo $this->query_model->getStaticTextTranslation('select_your_location'); ?></div>');
							}
							<?php } ?>
							
							<?php /*if($this->query_model->get_gdpr_compliant() == 1){?>
								var gdpr_compliant_id= 'gdpr_compliant';
								var gdpr_compliant_error= 'gdpr_compliant_error';
								if($('#'+gdpr_compliant_id).is(":checked")){
									$('.'+gdpr_compliant_error).hide();
								}else{
									var err = 1;
									$('#'+gdpr_compliant_id).after('<div class="reds '+gdpr_compliant_error+'"><?php echo $this->query_model->getStaticTextTranslation('receiving_information'); ?></div>');
								}
							<?php }*/ ?>
									
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
										$('#form_email_6').after('<div class="reds email_error6"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
										
									}
							});
							
				<?php if($multiSchoolOrLocation == 1 ){ ?>
            	$('#school_6').change(function(){
            			if($(this).val() != ''){
            				$('.school_name_error6').hide();
            			} else{
            				$('.school_name_error6').show();
            				$('#school_6').after('<div class="reds school_name_error6"><?php echo $this->query_model->getStaticTextTranslation('select_your_location'); ?></div>');
            				
            			}
            	});
            	<?php } ?>
				
				<?php /*if($this->query_model->get_gdpr_compliant() == 1){?>
					var gdpr_compliant_id= 'gdpr_compliant';
					var gdpr_compliant_error= 'gdpr_compliant_error';
					$('#'+gdpr_compliant_id).click(function(){
							if($(this).is(':checked')){
								$('.'+gdpr_compliant_error).hide();
							}else{
								$('.'+gdpr_compliant_error).show();
							}
						})
				<?php } */?>  
							
							
						});

					</script>
                     <div class="col-sm-6 col-md-7">
                     <form action="#"  method="post" class="small_mini_form" id="form_6">  
					 <?php echo $this->query_model->getCaptchaInputFields('opt_in_form'); ?>
					 
					  <?php if($multiSchoolOrLocation == 1 ){ ?>
						   <?php if($multiLocation[0]->field_value == 1  && count($form_allLocations) >= 1){ ?>
							  <select class=" form-control form_location_dropdown" name="school_interest" id="school_6" number="1">
							   <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_location'); ?></option>
									<?php foreach($form_allLocations as $location): ?>
										<option  value="<?=$location->id;?>" <?php if($selectedLocaiton == $location->id){ echo 'selected=selected'; } ?>><?=$location->name;?> </option>
									<?php endforeach;?>   
							  </select>
						 <?php } ?>
					 <?php  } ?>
					 
					 <?php if($this->query_model->showProgramsListOnFroms() == 1){
					$programsArr =  $this->query_model->programsListOnFromDropdowns(); 
							if(!empty($programsArr)){
						?>
							<select class="form-control  form_program_dropdown program_dropdown_1" name="program_id" id="">
								 <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_program'); ?></option>
								 <?php foreach($programsArr as $program): ?>
								 <option  value="<?=$program->id;?>" ><?=$program->program;?> </option>
								 <?php endforeach;?>   
							  </select>
					 
					 <?php } }  ?>
					 <input type="text"  name="last_name" class="optinlastname" placeholder="Last Name" value="">

					    <input type="text" class="form-control" id="form_email_6" name="form_email_2" placeholder="<?php echo $this->query_model->getStaticTextTranslation('enter_your_email_address'); ?>">
						<input type="text" id="fax" name="fax" class="optinfax"   placeholder="Fax Number" value="">

						<?php if(!empty($twilioApi)){?>
						   <div class=" twilio_checkbox email_optin_twilio_checkbox" >
							  <input type="checkbox" class="form-control" name="twilio_checkbox" value="1"> <?php echo $twilioApi->checkbox_text ?>
						   </div>
					   <?php } ?>
		   
					<?php if($this->query_model->get_gdpr_compliant() == 1){?>
						<div class="email_optin_gdpr_compliant_checkbox" >
							<input type="hidden" name="ip_address" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
							
							
						  <input type="checkbox" class="form-control" id="gdpr_compliant" name="gdpr_compliant_checkbox" value="1"><?php echo $gdpr_compliant_txt2; ?><span><?php echo $gdpr_compliant_txt1; ?></span>
					   </div>
					 <?php } ?>
					 
					 <input type="text" id="comment" name="comment" class="optincomment"   placeholder="Write your comment here..." value="">
<input type="checkbox" class="optincheck" name="contact_me_by_phone" value="1">
		   
					 <input type="hidden" name="page_url" value="<?php echo isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';  ?>" />
					 
					 <?php if($multiSchoolOrLocation == 0){ ?>
					 <input type="hidden" name="school_interest" value="<?php echo !empty($page_location_id) ? $page_location_id : ''; ?>" />
					 <?php } ?>
					 <input type="hidden" name="miniform" value="true" />
					 <input type="text" id="website" name="website" class="optinwebsite"  placeholder="Website" value="">
<input type="text"  class="ywedobjeo" name="x2o3d_<?php echo $this->query_model->setAndGetUniqueNumberForCustomField(); ?>" value="<?php echo time(); ?>"  placeholder="Serial Number"/>
                     <button class="view-offer contactFormSubmit_6" name="submitEmail" value="submitEmail" type="submit" ><?php if(!empty($schoolHeader) && !empty($schoolHeader[0]->opt1_btn_text)) {
								$this->query_model->getDescReplace($schoolHeader[0]->opt1_btn_text,$is_child_location,$original_location_id); 
					  }else{ echo $this->query_model->getStaticTextTranslation('view_trial_offer'); }?></button>
                       
					   
					  </form>
                     </div>
					  <?php } ?>
                   </div>
                 </div>
               </div> 
               <div class="col-md-12 col-sm-12">
                  <h2><?php $this->query_model->getDescReplace($schoolHeader[0]->title,$is_child_location,$original_location_id);  ?></h2>
                  <p><?php $this->query_model->getDescReplace($schoolHeader[0]->description,$is_child_location,$original_location_id);  ?></p>
                 <!-- <ul>
                    <li>1. Something Here</li>
                    <li>2. Something Here</li>
                    <li>3. Something Here</li>
                  </ul> -->
                  <div class="action-btn">
                       
					  <?php if($schoolHeader[0]->buttons == '2_button'){ 
                        if($schoolHeader[0]->link_button1 == 'link_to_page'){
                        
                        $linkurl_1 = $this->query_model->getChangeUrl($schoolHeader[0]->button1_page_link);
                        
                        } else{
                        $linkurl_1 = $schoolHeader[0]->button1_link;
                        }
                        
                        if($schoolHeader[0]->link_button2 == 'link_to_page'){
                        $linkurl_2 = $this->query_model->getChangeUrl($schoolHeader[0]->button2_page_link);
                        } else{
                        $linkurl_2 = $schoolHeader[0]->button2_link;
                        }
                        ?>
                     <a href="<?php echo $linkurl_1; ?>"  target="<?php echo $schoolHeader[0]->button1_link_target; ?>" class="<?php //echo $schoolHeader[0]->button1_button_class; ?> left  action-control"><?php echo $schoolHeader[0]->button1_text; ?> <i class="fa  fa-angle-right"></i></a>  <br/>
                     <a href="<?php echo $linkurl_2; ?>"  target="<?php echo $schoolHeader[0]->button2_link_target; ?>" class="<?php //echo $schoolHeader[0]->button2_button_class; ?> right  action-control-right"><?php echo $schoolHeader[0]->button2_text; ?> <i class="fa  fa-angle-right"></i></a>
                     <?php } ?>
                     <?php if($schoolHeader[0]->buttons == '1_button'){ 
                        if($schoolHeader[0]->link_button1 == 'link_to_page'){
                        		$linkurl_single = $schoolHeader[0]->button1_page_link;
                        	} else{
                        		$linkurl_single = $schoolHeader[0]->button1_link;
                        	}
                        ?>
                     <a href="<?php echo $linkurl_single; ?>"  target="<?php echo isset($schoolHeader[0]->button1_link_target) ? $schoolHeader[0]->button1_link_target : ''; ?>" class="<?php echo isset($schoolHeader[0]->button1_button_class) ? $schoolHeader[0]->button1_button_class : ''; ?> left  action-control"><?php echo isset($schoolHeader[0]->button1_text) ? $schoolHeader[0]->button1_text : ''; ?> <i class="fa  fa-angle-right"></i></a> 
                     <?php } ?>
					 
                  </div>
               </div>
            </div>
         </div>
      </section>
	
	<?php if(!empty($schoolHeader[0]->header_summery)){ ?>
      <section id="school-quote">
        <div class="container">
          <div class="row">
            <div class="col-sm-12">
              <p><?php $this->query_model->getDescReplace($schoolHeader[0]->header_summery,$is_child_location,$original_location_id);  ?></p>
            </div>
          </div>
        </div>
      </section>
	<?php } ?>	
	  <?php } ?>


	  <?php if(!empty($aboutContent)){ ?>
      <section class="ads feature-program clearfix school-owner-about" id="feature-new" >
         <div class="container">
            <div class="row">
               <div class="col-md-4">
                  <div class="relative" >
                     <img src="<?php echo base_url().'upload/school_about_us/'.$aboutContent[0]->photo; ?>" class="img-responsive school-owner-a" style="top:<?php echo !empty($aboutContent[0]->img_top_spacing) ? $aboutContent[0]->img_top_spacing : 0; ?>px;" alt="<?php $this->query_model->getDescReplace($aboutContent[0]->image_alt,$is_child_location,$original_location_id);  ?>">
                  </div>
               </div>
               <div class="col-md-8 col-sm-8 owner-info">
                  <h3><?php $this->query_model->getDescReplace($aboutContent[0]->title,$is_child_location,$original_location_id);  ?></h3>
                  <h2><?php $this->query_model->getDescReplace($aboutContent[0]->sub_title,$is_child_location,$original_location_id);  ?></h2>
                  <p><?php $this->query_model->getDescReplace($aboutContent[0]->description,$is_child_location,$original_location_id);  ?></p>
                  
               </div>
            </div>
         </div>
      </section>
	  <?php } ?>
	
	<?php 
		if(!empty($schoolRows)){
				foreach($schoolRows as $aboutus_row){
					if($aboutus_row->photo_side == "right"){
		?>			

			<section id="toggle-block" class="clearfix  <?php echo empty($aboutus_row->background_color) ? 'cyan-bg' : ''; ?>  share-section">
			 
					 <div class="content-box"  style="<?php echo !empty($aboutus_row->background_color) ? 'background:'.$aboutus_row->background_color.' !important' : ''; ?>">
					   <h2><?= $this->query_model->getDescReplace($aboutus_row->title,$is_child_location,$original_location_id); ?></h2>
								 <p><?= $this->query_model->getDescReplace($aboutus_row->description,$is_child_location,$original_location_id); ?></p>
								 
								<?php if(!empty($aboutus_row->button_text) && !empty($aboutus_row->button_url)){ ?>
								 <a href="<?php echo $aboutus_row->button_url; ?>" class="btn-theme"><?php echo $aboutus_row->button_text; ?> <i class="fa fa-angle-right"></i></a>
								<?php } ?>
								
						</div>
			  
						  <div class="relative-block">
							<div class="full-bg-toggle-a" style="background-image:url('<?php echo 'upload/school_about_us/'.$aboutus_row->photo; ?>')  !important;">
							   <!--<span class="cyan-overlay" style="<?php echo !empty($aboutus_row->background_color) ? 'background:'.$aboutus_row->background_color : ''; ?>"></span> -->
							</div>
						</div>
				  </section>		
		
					<?php } else{ ?>
					
					
					  <section id="toggle-block" class="clearfix <?php echo empty($aboutus_row->background_color) ? 'dark-bg' : ''; ?> share-section">
					  
							 <div class="content-box block-right" style="<?php echo !empty($aboutus_row->background_color) ? 'background:'.$aboutus_row->background_color.' !important'  : ''; ?>">
						   
							<h2><?= $this->query_model->getDescReplace($aboutus_row->title,$is_child_location,$original_location_id); ?></h2>
								 <p><?= $this->query_model->getDescReplace($aboutus_row->description,$is_child_location,$original_location_id); ?></p>
								 
								<?php if(!empty($aboutus_row->button_text) && !empty($aboutus_row->button_url)){ ?>
								 <a href="<?php echo $aboutus_row->button_url; ?>" class="btn-theme"><?php echo $aboutus_row->button_text; ?> <i class="fa fa-angle-right"></i></a>
								<?php } ?>
							</div>
				  
							<div class="relative-block toggle-b-set">
								<div class="full-bg-toggle-b" style="background-image:url('<?php echo 'upload/school_about_us/'.$aboutus_row->photo; ?>">
								   <!-- <span class="cyan-overlay" style="<?php echo !empty($aboutus_row->background_color) ? 'background:'.$aboutus_row->background_color : ''; ?>"></span> -->
								</div>
							</div>
						 
					  </section>
					
					<?php } ?>
		
		<?php } } ?>

	    

	<?php if(!empty($schoolPrograms)){ ?>
      <section id="ads-container" class="school-kids">
        <div class="container">
          <div class="row">
            <div class="grid">
			<?php
			foreach($schoolPrograms as $schoolProgram){
				foreach($schoolProgram as $program){ 
					$category_detail =	$this->query_model->getbySpecific('tblcategory', 'cat_id', $program->category);
			?>
                <div class="col-md-4">
                    <figure class="effect-ming">
					<?php if(!empty($program->featured_program_img)){ ?>
                        <img class="img-responsive"  src="<?php echo base_url().'upload/programs/'.$program->featured_program_img; ?>"  alt="<?= $this->query_model->getDescReplace($program->featured_program_img_alt_text,$is_child_location,$original_location_id); ?>">
					<?php } ?>
                        <figcaption>
                            <h2><?php $this->query_model->getDescReplace($program->program,$is_child_location,$original_location_id);  ?></h2>
                            <h3><?php $this->query_model->getDescReplace($program->ages,$is_child_location,$original_location_id);  ?></h3>
                            <p>
							<?php 
							$program_url = '';
								if($program->landing_checkbox == 1){ 
									
									if(!empty($program->landing_program)){
										$program_url = $program->landing_program;
									}else{
										$program_url = $program->landing_page_url;
									}
								} elseif($program->show_learn_more == 0){
									$program_url = base_url().$program_slug.'/'.$category_detail[0]->cat_slug.'/#'.str_replace(' ','-',trim($program->program));
								}else{
									$program_url = base_url().$program_slug.'/'.$category_detail[0]->cat_slug.'/'.$program->program_slug;
								}
							?>
							<a href="<?php echo $program_url; ?>"><?php echo $this->query_model->getStaticTextTranslation('learn_more'); ?>
							</a>
							
							</p>

                        </figcaption>
                    </figure>
                </div>
			<?php } } ?>
                
            </div>  
          </div>
        </div>
    </section>
	<?php } ?>

	   <?php if(!empty($schoolTextSection)){ ?>
      <section class="getting-started-school">
        <div class="container">
          <div class="row">
            <div class="col-sm-12">
              <h2><?php $this->query_model->getDescReplace($schoolTextSection[0]->getting_started_title,$is_child_location,$original_location_id);  ?></h2>
            </div>
          </div>
        </div>
      </section>
      <section id="steps-3">
         <div class="container-fluid">
                         <div class="row">
                           <div class="col-sm-4">
                             <div class="icon">1</div>
                             <h3><?php $this->query_model->getDescReplace($schoolTextSection[0]->getting_started_box_1_text,$is_child_location,$original_location_id);  ?></h3>
                           </div>
                           <div class="col-sm-4">
                             <div class="icon">2</div>
                             <h3><?php $this->query_model->getDescReplace($schoolTextSection[0]->getting_started_box_2_text,$is_child_location,$original_location_id);  ?></h3>
                           </div>
                           <div class="col-sm-4">
                             <div class="icon">3</div>
                             <h3><?php $this->query_model->getDescReplace($schoolTextSection[0]->getting_started_box_3_text,$is_child_location,$original_location_id);  ?></h3>
                           </div>
                         </div>
                       </div>
      </section>
	   <?php } ?>
	  
	  
      <div class="clearfix"></div>
      <!-- feature section -->
	  <?php 
	  $videoSection = (!empty($schoolVideoSection) && $schoolVideoSection[0]->video_section == 1) ? 1 : 0 ;
		
		if($videoSection == 1){
	  ?>
      <section class="section" id="about-us">
         <div class="container">
            <div class="row">
               <div class="col-md-8 col-md-push-2">
                  
				  
					<?php if(!empty($schoolVideoSection) && $schoolVideoSection[0]->image_video == 'video'){  ?>
						 <?php if($schoolVideoSection[0]->video_type == 'youtube_video'){ ?>
								<?php if(!empty($schoolVideoSection[0]->youtube_video)){ ?>
					 <div class="video-inner">
                     <iframe  height="390" src="<?php echo $this->query_model->changeVideoPathHttp($schoolVideoSection[0]->youtube_video); ?>?rel=0&amp;controls=0&amp;showinfo=0&amp;autoplay=0" frameborder="0" allowfullscreen ></iframe>
                     <span class="video-overlay">
                        <div class=""></div>
                     </span>
                  </div>
				  <?php } } else{ ?>
				  <?php if(!empty($schoolVideoSection[0]->vimeo_video)){ ?>
				   <div class="video-inner">
                     <iframe  height="390" src="<?php echo $this->query_model->changeVideoPathHttp($schoolVideoSection[0]->vimeo_video); ?>?rel=0&amp;showinfo=0&amp;autoplay=0" frameborder="0" allowfullscreen ></iframe>
                     <span class="video-overlay">
                        <div class=""></div>
                     </span>
                  </div>
				  <?php } } ?> 
					 <?php } else { ?>
							<?php if(!empty($schoolVideoSection) && !empty($schoolVideoSection[0]->photo)){ ?>
							<img class="img-responsive center-block" src="<?php echo base_url().'upload/school_about_us/'.$schoolVideoSection[0]->photo; ?>"  alt="<?= $this->query_model->getDescReplace($schoolVideoSection[0]->image_alt,$is_child_location,$original_location_id); ?>" />
							<?php } ?>
					 
					 <?php } ?>
					 
                  <div class="video-blcok text-center">
                     <h2><?= $this->query_model->getStrReplace($schoolVideoSection[0]->title,$is_child_location,$original_location_id); ?></h2>
                     <p><?= $this->query_model->getStrReplace($schoolVideoSection[0]->sub_title,$is_child_location,$original_location_id); ?></p>
                  </div>
               </div>
            </div>
         </div>
      </section>
		<?php } ?>
      <div class="clearfix"></div>
	  
	  <?php if(!empty($schoolTextSection)){ ?>
      <section class="difference-block" id="difference"  style="background-image:url('<?php echo 'upload/school_about_us/'.$schoolTextSection[0]->left_photo; ?>')  !important;">
         <span class="overlay"  style="<?php echo !empty($schoolTextSection[0]->background_color) ? 'background:'.$schoolTextSection[0]->background_color : ''; ?>"></span>
         <div class="container">
            <div class="row text-center">
               <div class="col-sm-12 col-md-12">
                  <div class="text-center">
                     <h2><?= $this->query_model->getStrReplace($schoolTextSection[0]->box_title); ?></h2>
                  </div>   
                  <div class="col-sm-4 col-md-4">
                     <div class="block-box">
                        <p><?= $this->query_model->getStrReplace($schoolTextSection[0]->box_1_text); ?> </p>
                        
                     </div>
                  </div>  
                  <div class="col-sm-4 col-md-4">
                     <div class="block-box">
                        <p><?= $this->query_model->getStrReplace($schoolTextSection[0]->box_2_text); ?> </p>
                     </div>
                  </div>  
                  <div class="col-sm-4 col-md-4">
                     <div class="block-box">
                        <p><?= $this->query_model->getStrReplace($schoolTextSection[0]->box_3_text); ?> </p>
                     </div>
                  </div>   
               </div>
               <div class="col-md-12">
                  <p class="lead"> <?= $this->query_model->getStrReplace($schoolTextSection[0]->box_description); ?> </p>
               </div>
            </div>
         </div>
      </section>
   
      <section class="features-list-about">
         <div class="row">
			<?php if(!empty($schoolTextSection[0]->full_box_title)){ ?>
			 <div class="col-md-12 col-sm-12 full_box_title">
               <div class="block">
                  <h3><?= $this->query_model->getStrReplace($schoolTextSection[0]->full_box_title); ?></h3>
               </div>
            </div>
			<?php } ?>
			
            <div class="col-md-4 col-sm-4">
               <div class="block-a">
                  <h3><?= $this->query_model->getStrReplace($schoolTextSection[0]->full_box_1_text); ?></h3>
               </div>
            </div>
            <div class="col-md-4 col-sm-4">
               <div class="block-b">
                  <h3><?= $this->query_model->getStrReplace($schoolTextSection[0]->full_box_2_text); ?></h3>
               </div>
            </div>
            <div class="col-md-4 col-sm-4">
               <div class="block-c">
                  <h3><?= $this->query_model->getStrReplace($schoolTextSection[0]->full_box_3_text); ?></h3>
               </div>
            </div>
         </div>
      </section>
      <section class="web-special">
         <div class="container">
            <div class="row">
               <div class="col-md-12 col-sm-12">
                  <div class="text-center">
                     <?= $this->query_model->getStrReplace($schoolTextSection[0]->description); ?>
                     
					 
					 <?php if(!empty($schoolTextSection) && $schoolTextSection[0]->show_timeline == 1){ ?>
					 <h2 class="timeline-heading">
					 <?php 
					 if(!empty($schoolTextSection[0]->timeline_title)){
						$this->query_model->getDescReplace($schoolTextSection[0]->timeline_title,$is_child_location,$original_location_id);
					 }else{
						 echo $this->query_model->getStaticTextTranslation('ata_timeline');
					 }
						?>
						</h2>
                     <p><p>
						<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
						<div id="example2.1" style="height: 100px;"></div>
						  
						<script type="text/javascript">
						  google.charts.load("current", {packages:["timeline"]});
						  google.charts.setOnLoadCallback(drawChart);
						  function drawChart() {
						    var container = document.getElementById('example2.1');
						    var chart = new google.visualization.Timeline(container);
						    var dataTable = new google.visualization.DataTable();

						    dataTable.addColumn({ type: 'string', id: 'Term' });
						    dataTable.addColumn({ type: 'string', id: 'Name' });
						   dataTable.addColumn({ type: 'string', role: 'tooltip' });
						    dataTable.addColumn({ type: 'date', id: 'Start' });
						    dataTable.addColumn({ type: 'date', id: 'End' });

						    dataTable.addRows([
						      [ 'ATA Timeline', 'Eternal Grand Master H. U. Lee received 1st degree Black Belt in Korea', 'Eternal Grand Master H. U. Lee received 1st degree Black Belt in Korea', new Date(1954, 1, 1), new Date(1962, 1, 1) ],
						      [ 'ATA Timeline', 'Eternal Grand Master H.U. Lee arrives in the USA and starts teaching Taekwondo', 'Eternal Grand Master H.U. Lee arrives in the USA and starts teaching Taekwondo', new Date(1962, 1, 1), new Date(1969, 1, 1) ],
						      [ 'ATA Timeline', 'ATA Is founded', 'ATA Is founded', new Date(1969, 1, 1), new Date(1983, 1, 1) ],
						      [ 'ATA Timeline', 'Songahm Taekwondo is first introduced by GM H.U. Lee who created it', 'Songahm Taekwondo is first introduced by GM H.U. Lee who created it', new Date(1983, 1, 1), new Date(1986, 1, 1) ],
						      [ 'ATA Timeline', 'Karate for Kids Program begins', 'Karate for Kids Program begins', new Date(1986, 1, 1), new Date(2006, 1, 1) ],
						      [ 'ATA Timeline', 'ATA passes the 1 Million member mark of students taught', 'ATA passes the 1 Million member mark of students taught',  new Date(2006, 1, 1),  new Date(2017, 1, 1) ]]);
						     
						   var options = {
						     colors: ['#de0404', '#3395a1', '#304076','#de0404', '#3395a1', '#304076'],
						    };
						   
						   chart.draw(dataTable, options);
						  }
						</script></p></p>
                     <h3><?= $this->query_model->getStrReplace($schoolTextSection[0]->timeline_text); ?></h3>
					 <?php } ?>
                  </div>
               </div>
            </div>
         </div>
      </section>
	  <?php } ?>
      <section class="trial-form trial-form-about-footer">
         <div class="container">
            <div class="row">
               <div class="col-md-12 text-center">
                  <h2> <?php if(!empty($schoolHeader) && !empty($schoolHeader[0]->opt_2_title)) {
						$this->query_model->getDescReplace($schoolHeader[0]->opt_2_title,$is_child_location,$original_location_id); 
				  }else{
					echo $this->query_model->getStaticTextTranslation('limited_trial_offer_available');
				  }  ?></h2>
                  <p><?php if(!empty($schoolHeader) && !empty($schoolHeader[0]->opt_2_text)) {
						$this->query_model->getDescReplace($schoolHeader[0]->opt_2_text,$is_child_location,$original_location_id); 
				  }  ?></p>
                  <h3><?php echo $this->query_model->getStaticTextTranslation('take_action_now'); ?></h3>
                  <div class="select-program">
				  <?php if(!empty($schoolOfferCategories)){ ?>
				  
				  <script>
	  $(window).load(function(){
		 
		$.each($('.trial_offer_checkbox'), function(){
		if($(this).is(':checked')){
				var offer_id = $(this).attr('trial_cat_id');
				//alert(offer_id); 
				//var offer_id = $(this).attr('id');
				var cat_slug = $(this).parent().parent().parent().parent().attr('cat_slug');
				
				$('#check'+offer_id).addClass('activeTrial');
				$('#checkbox_'+offer_id).prop( "checked", true );
				//$('.selectedTrial'+offer_id).html('Selected');
				$('.trialErrorMessage').html('');
				$('.trial_cat_id').val(offer_id);
				//$('.trial_cat_id_full_form').val(offer_id);
				
				//$('.mini_trial_offer_form').attr('action','<?php echo base_url().$trial_offer_slug->slug.'/' ?>'+cat_slug);
				//$('.full_trial_offer_form').attr('action','<?php echo base_url().$trial_offer_slug->slug.'/' ?>'+cat_slug);
					
		}
	});
	});
	  $(document).ready(function(){
		
		
		$('.trialButton').click(function(){
			
				$.each($('.activeTrial'), function(){
					$(this).removeClass('activeTrial');
				});
				
				$.each($('.trial_offer_checkbox'), function(){
					$(this).attr("checked", false);
				});
				
				/*$.each($('.selectedOffer'), function(){
					$(this).html("Select");
				}); */
				
				var offer_id = $(this).attr('id');
				var cat_slug = $(this).attr('cat_slug');
				
				$('#check'+offer_id).addClass('activeTrial');
				$('#checkbox_'+offer_id).prop( "checked", true );
				//$('.selectedTrial'+offer_id).html('Selected');
				$('.trialErrorMessage').html('');
				$('.trial_cat_id').val(offer_id);
				//$('.trial_cat_id_full_form').val(offer_id);
				
				//$('.mini_trial_offer_form').attr('action','<?php echo base_url().$trial_offer_slug->slug.'/' ?>'+cat_slug);
				//$('.full_trial_offer_form').attr('action','<?php echo base_url().$trial_offer_slug->slug.'/' ?>'+cat_slug);
				
			});
		
		
		
	  });
	  </script>
	 
				  
					<?php 
					
				$i = 0;
				foreach($schoolOfferCategories as $trial_cat){
					
					if($i % 2 == 0){
						$block_class = 'left-block';
						$box_class = ' left-g';
					}else{
						$block_class = 'right-block';
						$box_class = ' right-g';
					}
					
			?>	  
                
				  <div  id="<?=$trial_cat->id; ?>" cat_slug="<?=$trial_cat->slug; ?>"  class="check-select trialButton">
				  <?php if(!empty($schoolHeader) && $schoolHeader[0]->show_email_opt_form == 1){ ?>
                     <a  id="check<?=$trial_cat->id; ?>"  href="javascript:void(0)" class="check-left ">
                   <div class="control-group -g">
                         <label class="control control-checkbox">
                            <span class="selectedOffer selectedTrial<?=$trial_cat->id; ?>">  <?php $this->query_model->getDescReplace($trial_cat->name,$is_child_location,$original_location_id); ?></span>
                                 <input id="checkbox_<?=$trial_cat->id; ?>"   trial_cat_id="<?=$trial_cat->id; ?>"   type="checkbox"  class="trial_offer_checkbox" />
                             <div class="control_indicator"></div>
                         </label>
                        
                     </div>
                     </a>
				  <?php }else { ?>
				  <a  id="check<?=$trial_cat->id; ?>"   href="javascript:void(0)" class="check-left trial_offer_button"   url="<?php echo base_url().$trial_offer_slug->slug.'/'.$trial_cat->slug; ?>" >
							<div class="control-group g">
								<label class="control ">
									<?php $this->query_model->getDescReplace($trial_cat->name,$is_child_location,$original_location_id); ?>
								</label>
							</div>
						</a>
				  <?php } ?>
                  </div>
					<?php } } ?>
				  </div>
               </div>
            </div>
         </div>
      </section>
	  
	  <form id="trial_offer_link_form" method="post" action="<?php echo base_url().'site/set_location_id_form'; ?>" style="display:none">
			<input type="hidden" name="school_interest" value="<?php echo $location_id; ?>">
			<input type="hidden" name="redirect_url" class="redirect_url" value="">
			
		</form>
	  <p class="trialErrorMessage"></p>
	  <?php 
		$emailOnlyForm2 = 1;
		if(!empty($schoolHeader) && $schoolHeader[0]->show_full_form_2 == 1){
			$emailOnlyForm2 = 0;
		}
	  ?>
	  <?php if(!empty($schoolHeader) && $schoolHeader[0]->show_email_opt_form == 1){ ?>
       <?php if($emailOnlyForm2 == 1){ ?>
	  
	  <div class="started-block white-bg green-color">
	  
	   <span></span>
				   <script>
				   
		$(document).ready(function(){
			
			
		$('.contactFormSubmit_7').click(function(){
		
					var err = 0
					var trial_id = $('.trial_cat_id').val();
					if(trial_id == 0){
						$('.trialErrorMessage').html('<h3><?php echo $this->query_model->getStaticTextTranslation('choose_trial_offer_category'); ?></h3>');
						return false;
					}
					
					var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
					var email=$('#form_email_7').val();
					if(email.length == 0 || emailfilter.test($("#form_email_7").val()) == false){
						var err = 1;
						$('#form_email_7').after('<div class="reds email_error7"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
					}
					
					<?php if($multiSchoolOrLocation == 1 ){ ?>
							var school=$('#school_7').val();
							if(school == '' || school == null){
								var err = 1;
								$('#school_7').after('<div class="reds school_name_error7"><?php echo $this->query_model->getStaticTextTranslation('select_your_location'); ?></div>');
							}
							<?php } ?>
                  	
					<?php /*if($this->query_model->get_gdpr_compliant() == 1){?>
						var gdpr_compliant_id= 'gdpr_compliant_7';
						var gdpr_compliant_error= 'gdpr_compliant_error7';
						if($('#'+gdpr_compliant_id).is(":checked")){
							$('.'+gdpr_compliant_error).hide();
						}else{
							var err = 1;
							$('#'+gdpr_compliant_id).after('<div class="reds '+gdpr_compliant_error+'"><?php echo $this->query_model->getStaticTextTranslation('receiving_information'); ?></div>');
						}
					<?php }*/ ?>
					
					
					if(err == 0){
						$("#form_7").attr('action','<?=base_url()?>starttrial/saveLeadsByEmails');
						return true;
					} else{
						$("#form_7").attr('action','#');
						return false;
					}
			
			});
			
			
			$('#form_email_7').keyup(function(){
					var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
					var email=$('#form_email_7').val();
					if($(this).val().length > 0 || emailfilter.test($("#form_email_7").val()) == false){
						$('.email_error7').hide();
					} else{
						$('#form_email_7').after('<div class="reds email_error7"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
						
					}
			});
			
				<?php if($multiSchoolOrLocation == 1 ){ ?>
            	$('#school_7').change(function(){
            			if($(this).val() != ''){
            				$('.school_name_error7').hide();
            			} else{
            				$('.school_name_error7').show();
            				$('#school_7').after('<div class="reds school_name_error7"><?php echo $this->query_model->getStaticTextTranslation('select_your_location'); ?></div>');
            				
            			}
            	});
            	<?php } ?>
				
				<?php /*if($this->query_model->get_gdpr_compliant() == 1){?>
					var gdpr_compliant_id= 'gdpr_compliant_7';
					var gdpr_compliant_error= 'gdpr_compliant_error7';
					$('#'+gdpr_compliant_id).click(function(){
							if($(this).is(':checked')){
								$('.'+gdpr_compliant_error).hide();
							}else{
								$('.'+gdpr_compliant_error).show();
							}
						})
				<?php }*/ ?> 
			
		});

	</script>
	<form action="#"  method="post" class="get_started_form mini_form mini_trial_offer_form small_mini_form" id="form_7">
	<?php echo $this->query_model->getCaptchaInputFields('opt_in_form'); ?>
                  <div class="search-box">
				  

					 
				  <?php if($multiSchoolOrLocation == 1 ){ ?>
            	
				  <?php if($multiLocation[0]->field_value == 1  && count($form_allLocations) >= 1){ ?>
					<select class="form-control form_location_dropdown" name="school_interest" id="school_7" number="2">
					   <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_location'); ?></option>
							<?php foreach($form_allLocations as $location): ?>
								<option  value="<?=$location->id;?>" <?php if($selectedLocaiton == $location->id){ echo 'selected=selected'; } ?>><?=$location->name;?> </option>
							<?php endforeach;?>   
					  </select>
					 <?php } ?>
				  <?php } ?>
				  
				  
				   <?php if($this->query_model->showProgramsListOnFroms() == 1){
					$programsArr =  $this->query_model->programsListOnFromDropdowns(); 
							if(!empty($programsArr)){
						?>
							<select class="form-control  form_program_dropdown program_dropdown_2" name="program_id" id="">
								 <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_program'); ?></option>
								 <?php foreach($programsArr as $program): ?>
								 <option  value="<?=$program->id;?>" ><?=$program->program;?> </option>
								 <?php endforeach;?>   
							  </select>
					 
					 <?php } }  ?>
			  <input type="text"  name="last_name" class="optinlastname" placeholder="Last Name" value="">

                     <input type="text" class="form-control" id="form_email_7" name="form_email_2" placeholder="<?php echo $this->query_model->getStaticTextTranslation('enter_your_email_address'); ?>">
					<input type="text" id="fax" name="fax" class="optinfax"   placeholder="Fax Number" value="">

					<?php if(!empty($twilioApi)){?>
			   <div class=" twilio_checkbox email_optin_twilio_checkbox" >
				  <input type="checkbox" class="form-control" name="twilio_checkbox" value="1"> <?php echo $twilioApi->checkbox_text ?>
			   </div>
		   <?php } ?>
		   
		   <?php if($this->query_model->get_gdpr_compliant() == 1){?>
				<div class="email_optin_gdpr_compliant_checkbox" >
					<input type="hidden" name="ip_address" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
					
					
				  <input type="checkbox" class="form-control" id="gdpr_compliant_7" name="gdpr_compliant_checkbox" value="1"><?php echo $gdpr_compliant_txt2; ?><span><?php echo $gdpr_compliant_txt1; ?></span>
			   </div>
			 <?php } ?>
			 <input type="text" id="comment" name="comment" class="optincomment"   placeholder="Write your comment here..." value="">
<input type="checkbox" class="optincheck" name="contact_me_by_phone" value="1">
		   
					 <input type="hidden" name="page_url" value="<?php echo isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';  ?>" />
					 <input type="hidden" name="miniform" value="true" />
					
					<?php if($multiSchoolOrLocation == 0){ ?>
					 <input type="hidden" name="school_interest" value="<?php echo !empty($page_location_id) ? $page_location_id : ''; ?>" />
					  <?php } ?>
					  
					 <input type="hidden" class="trial_cat_id" name="trial_offer_id" value="0" />
					 <input type="hidden" name="redirection_type" value="trial_offer" />
					 <input name="send_trial_cat_tag_ac" value="1" type="hidden">
					<input type="text" id="website" name="website" class="optinwebsite"  placeholder="Website" value="">
<input type="text"  class="ywedobjeo" name="x2o3d_<?php echo $this->query_model->setAndGetUniqueNumberForCustomField(); ?>" value="<?php echo time(); ?>"  placeholder="Serial Number"/>
					 <button class="btn-red contactFormSubmit_7" name="submitEmail" value="submitEmail" type="submit" ><?php echo $gdpr_compliant_submit_btn_text; ?></button>
					 
                  </div>
			  </form>
				   </div>
	  <?php } else{ ?>
		
		
<div class="trial-form about-trial-form about-bg">
  <div class="container">
    <!-- <div class="row">
      <div class="col-md-12 text-center">
        <h2><?php  $this->query_model->getStrReplace($site_settings[0]->mini_form_offer_title,$is_child_location,$original_location_id);?></h2>
          <p> <?php  $this->query_model->getDescReplace($site_settings[0]->mini_form_offer_desc,$is_child_location,$original_location_id);?></p>
      </div>
    </div> -->
    <div class="row">
      <div class="col-xs-12">
	 		 <?php
			/* $tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
				$special_offer_data = $this->query_model->getbyTable("$tblspecialoffer");								
				$speical_offer_setting = $special_offer_data[0];*/
			?>
			
            <script>
		$(document).ready(function(){
			
			
		$('.contactFormSubmit1').click(function(){
		
					var err = 0
					var trial_id = $('.trial_cat_id').val();
					if(trial_id == 0){
						$('.trialErrorMessage').html('<h3><?php echo $this->query_model->getStaticTextTranslation('choose_trial_offer_category'); ?></h3>');
						return false;
					}
					
					var name=$('#first_name1').val();
					//alert(name); return false;
					if(name.length == 0){
						var err = 1;
						$('#first_name1').after('<div class="reds name_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?></div>');
					}else{
						if(! /\s/g.test(name)){
							var err = 1;
							$('#first_name1').after('<div class="reds name_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?></div>');
						}
					}
					
					/*var last_name=$('#last_name1').val();
					if(last_name.length == 0){
						var err = 1;
						$('#last_name1').after('<div class="reds last_name_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?></div>');
					}*/
					
					/*var telephone=$('#telephone1').val();
					<?php if($site_settings[0]->phone_required == 1){ ?>
                                                 <?php if($site_settings[0]->international_phone_fields != 1){ ?>
					if(telephone.length <= 11 || telephone.length == 0){
						var err = 1;
						$('#telephone1').after('<div class="reds phone_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
						
					}
                                        <?php } } ?>  */
										
										
					var telephoneId = 'telephone1';
					var phoneError = 'phone_error1';
					var telephone=$('#'+telephoneId).val();
					<?php 
						if($site_settings[0]->international_phone_fields != 1){
							if($site_settings[0]->phone_required == 1){ ?>
						if(telephone.length <= <?php echo $phoneNumberMaxLength - 1; ?> || telephone.length == 0){
							var err = 1;
							$('#'+telephoneId).after('<div class="reds '+phoneError+'"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
							
						} 
						<?php //}
						}else{ ?>
						
							if(telephone.length <= <?php echo $phoneNumberMaxLength - 1; ?> && telephone.length > 0){
									$('#'+telephoneId).after('<div class="reds '+phoneError+' "><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
									var err = 1;
								}else{
									//var err = 0;
									$('.'+phoneError).hide();
								}
					<?php 	} 
						}else{
							if($site_settings[0]->phone_required == 1){
					?>
					
					
						var filter = /^[- +()]*[0-9][- +()0-9]*$/;
						if (filter.test(telephone)) {
							$('.'+phoneError).hide();
						}
						else {
							$('#'+telephoneId).after('<div class="reds '+phoneError+'"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
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
									$('#'+telephoneId).after('<div class="reds '+phoneError+'"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
									var err = 1;
								}	
							}	
					<?php		}	?> 
					
					<?php }?>
						
						
					
					var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
					var email=$('#form_email1').val();
					if(email.length == 0 || emailfilter.test($("#form_email1").val()) == false){
						var err = 1;
						$('#form_email1').after('<div class="reds email_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
					}
					
					
					<?php if($multiLocation[0]->field_value == 1 ){ ?>
					var school=$('#school1').val();
					if(school == '' || school == null){
						var err = 1;
						$('#school1').after('<div class="reds school_name_error1"><?php echo $this->query_model->getStaticTextTranslation('select_your_location'); ?></div>');
					}
					<?php } ?>
					
					<?php /*if($this->query_model->get_gdpr_compliant() == 1){?>
						var gdpr_compliant_id= 'gdpr_compliant_1';
						var gdpr_compliant_error= 'gdpr_compliant_error1';
						if($('#'+gdpr_compliant_id).is(":checked")){
							$('.'+gdpr_compliant_error).hide();
						}else{
							var err = 1;
							$('#'+gdpr_compliant_id).after('<div class="reds '+gdpr_compliant_error+'"><?php echo $this->query_model->getStaticTextTranslation('receiving_information'); ?></div>');
						}
					<?php }*/ ?>

					
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
						$('#first_name1').after('<div class="reds name_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?></div>');
						
					}
			});
			
			$('#last_name1').keyup(function(){
					if($(this).val().length > 0){
						$('.last_name_error1').hide();
					} else{
						$('#last_name1').after('<div class="reds last_name_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?></div>');
						
					}
			});
			
			$('#telephone1').keyup(function(){
					/*if($(this).val().length <= 11){
						
						<?php if($site_settings[0]->phone_required == 0){ ?>
							if($(this).val().length == 0){
								$('.phone_error1').hide();
							}else{
                                                               <?php if($site_settings[0]->international_phone_fields == 1){ ?>
                                                                $('.phone_error1').hide();
                                                            <?php  }else{ ?>
								$('#telephone1').after('<div class="reds phone_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
                                                            <?php  } ?>
							}
						<?php }else{ ?>
                                                            <?php if($site_settings[0]->international_phone_fields == 1){ ?>
                                                                $('.phone_error1').hide();
                                                            <?php  }else{ ?>
								$('#telephone1').after('<div class="reds phone_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
                                                             <?php  } ?>
						<?php } ?>
					} 
					
					if($(this).val().length == 12){
						$('.phone_error1').hide();
						
					}*/
					
				$('.phone_error1').hide();
			});
			
			
			$('#form_email1').keyup(function(){
					var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
					var email=$('#form_email1').val();
					if($(this).val().length > 0 || emailfilter.test($("#form_email1").val()) == false){
						$('.email_error1').hide();
					} else{
						$('#form_email1').after('<div class="reds email_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
						
					}
			});
			
			<?php if($multiLocation[0]->field_value == 1 ){ ?>
			$('#school1').change(function(){
					if($(this).val() != ''){
						$('.school_name_error1').hide();
					} else{
						$('.school_name_error1').show();
						$('#school1').after('<div class="reds school_name_error1"><?php echo $this->query_model->getStaticTextTranslation('select_your_location'); ?></div>');
						
					}
			});
			<?php } ?>
			
			<?php /*if($this->query_model->get_gdpr_compliant() == 1){?>
				var gdpr_compliant_id= 'gdpr_compliant_1';
				var gdpr_compliant_error= 'gdpr_compliant_error1';
				$('#'+gdpr_compliant_id).click(function(){
						if($(this).is(':checked')){
							$('.'+gdpr_compliant_error).hide();
						}else{
							$('.'+gdpr_compliant_error).show();
						}
					})
			<?php }*/ ?> 
			
			
		});

	</script>
         <form action="<?=base_url().$trial_offer_slug->slug?>"  method="post" class="get_started_form mini_form_2">
		 <?php echo $this->query_model->getCaptchaInputFields('opt_in_form'); ?>
          <div class="inline_mid_form " >
              <input type="text" id="first_name1" name="name" class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('first_name'); ?>"
                            onfocus="this.placeholder = ''"   onBlur="textAlphabatic(this)" maxlength="<?php echo $this->query_model->fullNameInputMaxLength(); ?>" error_class="name_error1" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?>" >
              <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
           <div class="inline_mid_form optinlastname" >
              <input type="text" name="last_name" id="last_name1" class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('last_name'); ?>"
                            onfocus="this.placeholder = ''" onBlur="textAlphabatic(this)" maxlength="25" error_class="last_name_error1" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?>"
                            >
              <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
            <div class="inline_mid_form " >
              <input type="text" name="form_email_2" id="form_email1" class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('email'); ?>"
                            onfocus="this.placeholder = ''" onBlur="this.placeholder = '<?php echo $this->query_model->getStaticTextTranslation('email'); ?>'"  
                            >
              <span class="fa fa-envelope form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
            <div class="inline_mid_form " >
			
			
			<input type="text" name="phone" id="telephone1" class="contact-form-line  <?php echo $getPhoneNumberClass; ?>" placeholder="<?php echo $this->query_model->getStaticTextTranslation('phone'); ?>"
                            onfocus="this.placeholder = ''"  error_class="phone_error1" onBlur="phoneValidation(this)" maxlength="<?php echo $phoneNumberMaxLength; ?>" 
                            >
			
              <span class="fa fa-phone form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
			  
			  <input type="text" id="fax" name="fax" class="optinfax"   placeholder="Fax Number" value="">

            <?php if($multiLocation[0]->field_value == 1  && count($form_allLocations) >= 1){ ?>
		    <div class="inline_mid_form " >
              <select class="locationBox contact-form-line form_location_dropdown" name="school_interest" id="school1" number="3">
               <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_location'); ?></option>
					<?php foreach($form_allLocations as $location): ?>
						<option  value="<?=$location->id;?>" <?php if($selectedLocaiton == $location->id){ echo 'selected=selected'; } ?>><?=$location->name;?> </option>
					<?php endforeach;?>   
              </select>
              <span class="fa fa-map-marker form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
			 <?php } ?>
			 
			  <?php if($this->query_model->showProgramsListOnFroms() == 1){
					
						$programsArr =  $this->query_model->programsListOnFromDropdowns(); 
							if(!empty($programsArr)){
					?>
					<div class="inline_mid_form " >
					<select class="contact-form-line  form_program_dropdown program_dropdown_3" name="program_id" id="">
						 <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_program'); ?></option>
						 <?php foreach($programsArr as $program): ?>
						 <option  value="<?=$program->id;?>" ><?=$program->program;?> </option>
						 <?php endforeach;?>   
					  </select>
					</div>
				<?php } } ?>
				
			 
			 <?php if(!empty($twilioApi)){?>
			   <div class="inline_mid_form twilio_checkbox" >
                  <input type="checkbox" class="" name="twilio_checkbox" value="1"> <?php echo $twilioApi->checkbox_text ?>
               </div>
			   <?php } ?>
			   
			 <input type="text" id="comment" name="comment" class="optincomment"   placeholder="Write your comment here..." value="">
<input type="checkbox" class="optincheck" name="contact_me_by_phone" value="1">  
			 <?php if($this->query_model->get_gdpr_compliant() == 1){?>
					<div class="inline_mid_form gdpr_compliant_checkbox" >
						<input type="hidden" name="ip_address" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
						
						
					  <input type="checkbox" class="form-control" id="gdpr_compliant_1" name="gdpr_compliant_checkbox" value="1"><?php echo $gdpr_compliant_txt2; ?><span><?php echo $gdpr_compliant_txt1; ?></span>
				   </div>
				 <?php } ?>
			
			   
            <div class="<?php if($multiLocation[0]->field_value == 0){ echo 'inline_mid_form singleLocationFormButton'; }?> started-btn" >
				<input type="hidden" name="miniform" value="true" />
                
				<input type="text" id="website" name="website" class="optinwebsite"  placeholder="Website" value="">
<input type="text"  class="ywedobjeo" name="x2o3d_<?php echo $this->query_model->setAndGetUniqueNumberForCustomField(); ?>" value="<?php echo time(); ?>"  placeholder="Serial Number"/>

				<input type="hidden" name="page_url" value="<?php echo isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';  ?>" />
				
				<input type="hidden" class="trial_cat_id" name="trial_offer_id" value="0" />
				<input type="hidden" name="redirection_type" value="trial_offer" />
				<input name="send_trial_cat_tag_ac" value="1" type="hidden">
              <input class="mini_formSubmit contactFormSubmit1 submit <?php if($multiLocation[0]->field_value == 0){ echo 'getStartedMargin'; } else { echo 'getStartedMarginAuto'; } ?>" type="submit" class="" value="<?php echo $this->query_model->getStaticTextTranslation('go'); ?>" />
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

	  
	  <?php } } ?>
	  
	  
	   <?php if(!empty($ourStaffs)){ ?>
      <section id="staff">
         <div class="container">
            <div class="row">
               <div class="col-sm-12 col-md-12">
                  <div class="staff-block">
                     <ul>
					 <?php foreach($ourStaffs as $staff){ ?>
                        <li>
					 <?php  if($staff->not_linked == 1){ ?>
                       <?php if($staff->lightbox_or_url == 'url'){ ?>
					   <a href="<?php echo $staff->url ?>" target="<?php echo $staff->target; ?>">
					   <?php }else{ ?>
						<a class="staffInfoPopUp" href="javascript:void(0)" number="<?= $staff->id?>"  data-toggle="modal" data-target=".staff-popup">
						
					   <?php } ?>
                           <img  src="<?php base_url(); ?>upload/school_staff/thumb/<?= $staff->photo; ?>" alt="<?= $this->query_model->getStrReplace($staff->photo_alt_text); ?>">
					 		<div class="staff-hover">
					 			<button class="btn btn-theme btn-bio"><?php echo $this->query_model->getStaticTextTranslation('read_bio'); ?></button>
					 			
					 		</div>
                        </a>
					 <?php }else{ ?>
							<img  src="<?php base_url(); ?>upload/school_staff/thumb/<?= $staff->photo; ?>" alt="<?= $this->query_model->getStrReplace($staff->photo_alt_text); ?>">
					 <?php } ?>
                          <h3><?= $this->query_model->getStrReplace($staff->name); ?></h3>
                          <h4><?= $this->query_model->getStrReplace($staff->position); ?></h4>
                          <p><?= $this->query_model->getStrReplace($staff->belt); ?></p> 
						  
						</li>
					 <?php } ?>
						</ul>
                  </div>
               </div>
            </div>
         </div>
      </section>
	  
	  <?php } ?>
	  
	    
<?php 
$apiKeys =$this->query_model->getbySpecific('tblschool_apikey','location_id', $location_id);
if(!empty($apiKeys)){
		$apiKeys = $apiKeys[0];
	} else{
		$apiKeys = '';
	}
if(!empty($apiKeys->instragram_user_id) && !empty($apiKeys->instragram_access_token)){ 

 $instragram_images = $this->query_model->userMedia($apiKeys->instragram_user_id, $apiKeys->instragram_access_token); 
 
?>
      <section id="instagram-feeds">
	  <style>
			.instragramImages{ float:left;}
		</style>
	  <script>
				$(window).load(function(){
					$('.ShowMoreIntImg').hide();
					$('.countIntImages').val(10)
				});
				
				$(document).ready(function(){
					$('.showMoreInstragram').click(function(){
						//$('.ShowMoreIntImg').show();
						var countImages = $('.countIntImages').val();
						var showImages = parseInt(countImages) + Number(5);
						$('.countIntImages').val(showImages);
						$.each( $( ".instragramImages" ), function() {
							 var number = $(this).attr('number');
							
							 if(number > 10 && number <= showImages){
							 	$(this).css('display', 'inline-block');
								
							 }
						});
					});
					
				});
			</script>
			<input type="hidden" class="countIntImages" value="10"  />
			
         <div class="feed-list">
            <ul>
			 <?php
				$ins_media = $instragram_images; 
				
				$i = 1; 
				foreach ($ins_media['data'] as $vm): 
				$ShowMoreIntImg = '';
					if($i > 10){
						$ShowMoreIntImg = 'ShowMoreIntImg';
					}
					
					//$img = $vm['images']['thumbnail']['url'];
					$img = $vm['images']['standard_resolution']['url'];
					$img = str_replace('s150x150','s320x320',$img);
					$main_img = $vm['images']['standard_resolution']['url'];
					$link = $vm["link"];
				?>
               <li class="<?php echo $ShowMoreIntImg; ?> instragramImages"  number="<?php echo $i; ?>">
                  <a href="javascript:void(0)">
                     <img src="<?php echo $img; ?>"  class="intImage" >
                     <span class="overlay"></span>
                  </a>
				  
				  
				 <div class="insta-caption" >
					<div class="review-detail manage_lightboxthumb">
					   <a href="<?php echo $main_img; ?>" class="fancybox"  data-fancybox-group="gallery" title="<?php echo $this->query_model->getStaticTextTranslation('likes'); ?>: <?php echo $vm['likes']['count']; ?> &nbsp; <?php echo $this->query_model->getStaticTextTranslation('comments'); ?>: <?php echo $vm['comments']['count']; ?>"> 
					  <p><span>
					 
					  <i class="fa fa-heart"></i> <?php echo $this->query_model->getStaticTextTranslation('likes'); ?>:<?php echo $vm['likes']['count']; ?></span> <span><i class="fa fa-comment"></i> <?php echo $this->query_model->getStaticTextTranslation('comments'); ?>: <?php echo $vm['comments']['count']; ?></span> </p>
					</a>
					</div>
				  </div> 
               </li>
                <?php $i++; endforeach; ?>
            </ul>
         </div>
		 <div class="clearfix"></div>
         <div class="action-btn-block">
		 <?php if(count($ins_media['data']) > 5){ ?>
        	<a href="javascript:void(0);" class="load-more showMoreInstragram"><?php echo $this->query_model->getStaticTextTranslation('load_more'); ?></a> 
		<?php } ?>
            <a href="#" class="follow-btn"><i class="fa fa-instagram"></i> <?php echo $this->query_model->getStaticTextTranslation('follow'); ?> </a>
         </div>
      </section>
<?php } ?>

     
	  	  <?php 
	$apiKeys =$this->query_model->getbySpecific('tblschool_apikey','location_id', $location_id);
	
	if(!empty($apiKeys)){
		$apiKeys = $apiKeys[0];
	} else{
		$apiKeys = '';
	}
	
	//echo '<pre>'; print_r($apiKeys); die;
	$blank = 0;
	
	
	if(empty($apiKeys->twitter_user_name) || empty($apiKeys->twitter_consumer_key) || empty($apiKeys->twitter_consumer_secret) || empty($apiKeys->twitter_access_token) || empty($apiKeys->twitter_access_token_secret)){
		$blank += 1;
	}
	
	if(empty($apiKeys->facebook_user_id) || empty($apiKeys->facebook_access_token)){
		$blank += 1;
	}
	
	if(empty($apiKeys->google_plus_id) || empty($apiKeys->google_plus_api_key)){ 
		$blank += 1;
	} 
	
	
	if(empty($apiKeys->youtube_channel_id) || empty($apiKeys->youtube_api_key)){
		$blank += 1;
	}
	
	
?>
<?php if($blank < 4){ ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/2.2.2/isotope.pkgd.js"></script>
 <div id="news" class="socialNewsData">
				<div id="loader" ><img src="images/ajax_loader.gif" /></div>
		 </div>
<?php } ?>

       <div class="clearfix"></div>
	     <?php if(!empty($schoolTestimonials)){ ?>
      <section class="testimonial" id="testi-block"  style="background-image:url('<?php echo !empty($site_settings[0]->testimonial_background)?$site_settings[0]->testimonial_background:'';?>')">
         <span class="overlay"></span>
         <div class="container">
            <div class="container content">
               <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                  <!-- Indicators --> 
                  <ol class="carousel-indicators testimonial-indicator">
                     <?php 
						 $m = 0;
						$totalTestimonials = count($schoolTestimonials);
						if($totalTestimonials > 1):
						  foreach($schoolTestimonials as $testimonial):
						  
					  ?>
						 <li data-target="#carousel-example-generic" data-slide-to="<?= $m ?>" class="<?php if($m == 0){ echo 'active'; } ?>"></li>
					   <?php     $m++;
							endforeach;
						endif;
					  ?>  
                  </ol>
                  <!-- Wrapper for slides --> 
                    <div class="carousel-inner">
				  <?php if(!empty($schoolTestimonials)): ?>
				  <?php 
					$n = 1;
					foreach($schoolTestimonials as $testimonial):
					?>
                     <div class="item  <?php if($n == 1){ echo 'active'; } ?>">
                        <div class="row">
                           <div class="col-xs-12">
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
                                          <div class="desc">
										  <?php //$content = preg_replace('#\<p>[{\w},\s\d"]+\</p>#', "", $testimonial->content); ?> 
										  <?= 
										    $this->query_model->getStrReplace(strip_tags(html_entity_decode($testimonial->content))); 
										  ?></div>
                                          <p class="f-name"><?= $this->query_model->getStrReplace($testimonial->name); ?></p>
                                          <p class="accent-txt d-txt"><?= $this->query_model->getStrReplace($testimonial->title); ?></p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
					 <?php 
				$n++; 
				endforeach; ?>
            <?php endif; ?>
					 
					 </div>
					 <!-- Controls -->  
               </div>
            </div>
         </div>
      </section>
      <div class="clearfix"></div>
		 <?php } ?>
		

	<?php if(!empty($contactDetail)){ ?>
      <section id="school-location">
       <div class="container">
           <div class="row">
               <div class="col-md-5 col-xs-12">
                     <?php if($contactDetail->photo != ''){ ?>
                 <img src="<?php echo base_url().$contactDetail->photo; ?>" class="img-responsive"> 
                 <?php } ?> 
                  
               </div>
               <div class="col-md-4 col-xs-12">
                   <div class="school-address">
                       <h2><?=  $this->query_model->getDescReplace($contactDetail->name,$is_child_location,$original_location_id); ?></h2>
                       <p class="red-txt"><span class="fa fa-phone"></span> <span class="no"><?=  $contactDetail->phone; ?></span> </p>
                       <p class="black-txt"><span class="fa fa-map-marker"></span> <span class="address">
						<?php if($contactDetail->address != ''){ echo $contactDetail->address.','; } ?>
                       	<?php if($contactDetail->suite != ''){ echo $contactDetail->suite.','; } ?>
						<?php if($contactDetail->city != ''){ echo $contactDetail->city.','; } ?>
						<?php if($contactDetail->state != ''){ echo $contactDetail->state.' '; } ?>
						<?php if($contactDetail->zip != ''){ echo $contactDetail->zip; } ?>
						</span></p>
                        <p class="red-txt"><span class="fa fa-envelope"></span> <span class="no">
						<?php if($contactDetail->email != ''){ 
                        	$email_addresses=  explode(',', $contactDetail->email);
							if(!empty($email_addresses)){
								foreach($email_addresses as $email){
									echo $email.'<br/>';
								}
							}
							} ?>
						</span> </p>
                        
				<?php $today = date('l'); ?>
						
				<?php if($contactDetail->location_type != "coming_soon_location"){ ?>		
                       <ul class="working-hours">
           	<?php foreach($contactTime as $contact_time){ ?>
		   	 <li <?php if($today == $contact_time->week_day): echo 'class = active'; endif; ?>>
			 	<a href="#"><span class="day"><?= $contact_time->week_day ?> </span> 
			 	<span class="timing">
					<?php if($contact_time->closed != 1 && $contact_time->custom_text_checkbox != 1){ 
							$start_time = $contact_time->start_hour.':'.$contact_time->start_min.' '.$contact_time->start_am_pm;
							
							$end_time = $contact_time->end_hour.':'.$contact_time->end_min.' '.$contact_time->end_am_pm;
							
							echo $start_time.' - '.$end_time;
						} else{
							if($contact_time->custom_text_checkbox == 1){
								if(!empty($contact_time->custom_text)){ echo $contact_time->custom_text; } else{ echo $this->query_model->getStaticTextTranslation('closed'); }
							}else{
								echo $this->query_model->getStaticTextTranslation('closed');
							}
							
						}
					?>
					
					</span> 
				</a> 
			</li>
			<?php } ?>
</span></a> </li>
                      </ul>
				<?php } ?>
				</div>
               </div>
               <div class="col-md-3 col-xs-12">
                    <div class="team-member" id="main-address" style="height: 427px;">
                        <h3><?php echo $this->query_model->getStaticTextTranslation('team_members'); ?></h3>
                        
						 <?php if(!empty($teamMembers)) {
								//echo '<pre>'; print_r($teamMembers); die;
								foreach ($teamMembers as $key => $teamMembers) {	?>

							<label><?php echo $teamMembers->name; ?></label> 
							<span><?php echo $teamMembers->designation; ?></span>
						<?php
								}
							} 
						?>
          
                        <div class="social-ul pull-left">
               <?php 
			  // $social_contact_icon_details = $this->query_model->getSocialContactIcons($contactDetail);
					//echo '<pre>'; print_r($social_contact_icon_details); die;
					if(!empty($contactDetail)){
					$social_contact_twitter = $contactDetail->twitter;
					$social_contact_fb = $contactDetail->fb;
				//	$social_contact_logo = $contactDetail->sitelogo;		
					$social_contact_gplus = $contactDetail->gplus;
					$social_contact_youtube = $contactDetail->youtube;
					$social_contact_instagram = $contactDetail->instagram;
					$social_contact_yelp = $contactDetail->yelp;
					$social_contact_linkedIn = $contactDetail->linkedIn;
					$social_contact_vimeo = $contactDetail->vimeo;
	
			   ?>
                 <ul>

	             <?php if($social_contact_fb != ''): ?><li class="social-facebook"><a href="<?= $social_contact_fb; ?>" target="_blank"><i class="fa fa-facebook"></i></a></li><?php endif; ?>
	            <?php if($social_contact_twitter != ''): ?><li class="social-twitter"><a href="<?= $social_contact_twitter; ?>" target="_blank"><i class="fa fa-twitter"></i></a></li><?php endif; ?>
	            <?php if($social_contact_instagram != ''): ?><li class="social-instagram"><a href="<?= $social_contact_instagram; ?>" target="_blank"><i class="fa fa-instagram"></i></a></li><?php endif; ?>
	            <?php if($social_contact_gplus != ''): ?><li class="social-google"><a href="<?= $social_contact_gplus; ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li><?php endif; ?>
	            <?php if($social_contact_youtube != ''): ?><li class="social-youtube"><a href="<?= $social_contact_youtube; ?>" target="_blank"><i class="fa fa-youtube-square"></i></a></li><?php endif; ?>
	            <?php if($social_contact_vimeo != ''): ?><li class="social-vimeo"><a href="<?= $social_contact_vimeo; ?>" target="_blank"><i class="fa fa-vimeo-square"></i></a></li><?php endif; ?>
				<?php if($social_contact_yelp != ''): ?><li class="social-yelp"><a href="<?= $social_contact_yelp; ?>" target="_blank"><i class="fa fa-yelp"></i></a></li><?php endif; ?>
				<?php if($social_contact_linkedIn != ''): ?><li class="social-linkedin"><a href="<?= $social_contact_linkedIn; ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li><?php endif; ?> 
			   

            </ul>
					<?php } ?>
      

                       </div>
                    </div>
                   
               </div>
           </div>
       </div>
   </section>
	<?php } ?>
	  
	  <section class="map-main" id="direction">
         <div id="location-map">
            <div id="map_div5"></div>
         </div>
         <!-- form -->
        <!-- <section class="mobile-contact">
            <div class="container">
               <div class="row">
                  <div class="col-sm-12 text-center">
                     <span class="no">888-876-DOJO</span>
                     <p class="normal_text">123 Street Road, City ST, 12345</p>
                     <div class="row">
                        <div class="col-xs-6 row-btn"> <a class="btn btn-theme"> <?php echo $this->query_model->getStaticTextTranslation('free_trial_class'); ?> </a> </div>
                        <div class="col-xs-6 row-btn"> <a class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?> </a> </div>
                     </div>
                  </div>
               </div>
            </div>
         </section> -->
		 
		 
  <div class="outer-form">
  
  <script>
		$(document).ready(function(){
			
		$('.contactFormSubmit2').click(function(){
		
					var err = 0
					var name=$('#first_name2').val();
					//alert(name); return false;
					if(name.length == 0){
						var err = 1;
						$('#first_name2').after('<div class="reds name_error2"><?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?></div>');
					}else{
						if(! /\s/g.test(name)){
							var err = 1;
							$('#first_name2').after('<div class="reds name_error2"><?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?></div>');
						}
					}
					
					/*var last_name=$('#last_name2').val();
					if(last_name.length == 0){
						var err = 1;
						$('#last_name2').after('<div class="reds last_name_error2"><?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?></div>');
					}*/
					
					/* var telephone=$('#telephone2').val();
					<?php if($site_settings[0]->phone_required == 1){ ?>
                                                <?php if($site_settings[0]->international_phone_fields != 1){ ?>
					if(telephone.length <= 11 || telephone.length == 0){
						var err = 1;
						$('#telephone2').after('<div class="reds phone_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
						
					} 
                                        <?php } } ?> */
										
					var telephoneId = 'telephone2';
					var phoneError = 'phone_error2';
					var telephone=$('#'+telephoneId).val();
					<?php 
						if($site_settings[0]->international_phone_fields != 1){
							if($site_settings[0]->phone_required == 1){ ?>
						if(telephone.length <= <?php echo $phoneNumberMaxLength - 1; ?> || telephone.length == 0){
							var err = 1;
							$('#'+telephoneId).after('<div class="reds '+phoneError+'"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
							
						} 
						<?php //}
						}else{ ?>
						
							if(telephone.length <= <?php echo $phoneNumberMaxLength - 1; ?> && telephone.length > 0){
									$('#'+telephoneId).after('<div class="reds '+phoneError+' "><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
									var err = 1;
								}else{
									//var err = 0;
									$('.'+phoneError).hide();
								}
					<?php 	} 
						}else{
							if($site_settings[0]->phone_required == 1){
					?>
					
					
						var filter = /^[- +()]*[0-9][- +()0-9]*$/;
						if (filter.test(telephone)) {
							$('.'+phoneError).hide();
						}
						else {
							$('#'+telephoneId).after('<div class="reds '+phoneError+'"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
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
									$('#'+telephoneId).after('<div class="reds '+phoneError+'"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
									var err = 1;
								}	
							}	
					<?php		}	?> 
					
					<?php }?>
						
					
					var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
					var email=$('#form_email2').val();
					if(email.length == 0 || emailfilter.test($("#form_email2").val()) == false){
						var err = 1;
						$('#form_email2').after('<div class="reds email_error2"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
					}
					
					
					
					<?php if($multiLocation[0]->field_value == 1 ){ ?>
					var school=$('#school2').val();
					if(school == '' || school == null){
						var err = 1;
						$('#school2').after('<div class="reds school_name_error2"><?php echo $this->query_model->getStaticTextTranslation('select_your_location'); ?></div>');
					}
					<?php } ?>
					
					var message=$('#message2').val();
					//alert(name); return false;
					if(message.length == 0){
						var err = 1;
						$('#message2').after('<div class="message_error message_error2"><?php echo $this->query_model->getStaticTextTranslation('enter_your_message'); ?></div>');
					}
					
					<?php /*if($this->query_model->get_gdpr_compliant() == 1){?>
					var gdpr_compliant_id= 'gdpr_compliant_2';
					var gdpr_compliant_error= 'gdpr_compliant_error2';
					if($('#'+gdpr_compliant_id).is(":checked")){
						$('.'+gdpr_compliant_error).hide();
					}else{
						var err = 1;
						$('#'+gdpr_compliant_id).after('<div class="reds '+gdpr_compliant_error+'"><?php echo $this->query_model->getStaticTextTranslation('receiving_information'); ?></div>');
					}
				<?php }*/ ?>
					
					
					
					//alert(err); return false;
					if(err == 0){
						return true;
					} else{
						return false;
					}
			
			});
			
			
			$('#first_name2').keyup(function(){
					if($(this).val().length > 0){
						$('.name_error2').hide();
					} else{
						$('#first_name2').after('<div class="reds name_error2"><?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?></div>');
						
					}
			});
			
			$('#last_name2').keyup(function(){
					if($(this).val().length > 0){
						$('.last_name_error2').hide();
					} else{
						$('#last_name2').after('<div class="reds last_name_error2"><?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?></div>');
						
					}
			});
			
			$('#telephone2').keyup(function(){
					/*if($(this).val().length <= 11){
						
						<?php if($site_settings[0]->phone_required == 0){ ?>
							if($(this).val().length == 0){
								$('.phone_error2').hide();
							}else{
                                                            <?php if($site_settings[0]->international_phone_fields == 1){ ?>
                                                                $('.phone_error2').hide();
                                                            <?php  }else{ ?>
								$('#telephone2').after('<div class="reds phone_error2"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
                                                             <?php  } ?>
							}
						<?php }else{ ?>
                                                            <?php if($site_settings[0]->international_phone_fields == 1){ ?>
                                                                $('.phone_error2').hide();
                                                            <?php  }else{ ?>
								$('#telephone2').after('<div class="reds phone_error2"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
                                                            <?php  } ?>
						<?php } ?>
						
					} 
					
					if($(this).val().length == 12){
						$('.phone_error2').hide();
						
					} */
					
					$('.phone_error2').hide();
			});
			
			
			$('#form_email2').keyup(function(){
					if($(this).val().length > 0){
						$('.email_error2').hide();
					} else{
						$('#form_email2').after('<div class="reds email_error2"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
						
					}
			});
			
			<?php if($multiLocation[0]->field_value == 1 ){ ?>
			$('#school2').change(function(){
					if($(this).val() != ''){
						$('.school_name_error2').hide();
					} else{
						$('.school_name_error2').show();
						$('#school2').after('<div class="reds school_name_error2"><?php echo $this->query_model->getStaticTextTranslation('select_your_location'); ?></div>');
						
					}
			});
			<?php } ?>
			
			$('#message2').keyup(function(){
					if($(this).val().length > 0){
						$('.message_error2').hide();
					} else{
						$('#message2').after('<div class="message_error message_error2"><?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?></div>');
						
					}
			});
			
			
			<?php /*if($this->query_model->get_gdpr_compliant() == 1){?>
				var gdpr_compliant_id= 'gdpr_compliant_2';
				var gdpr_compliant_error= 'gdpr_compliant_error2';
				$('#'+gdpr_compliant_id).click(function(){
						if($(this).is(':checked')){
							$('.'+gdpr_compliant_error).hide();
						}else{
							$('.'+gdpr_compliant_error).show();
						}
					})
			<?php }*/ ?> 
			
			
			
		});

	</script>	
    <form class="d-bg-c contact-form content_contact_form" action="contactus/send" method="post" >
	<?php echo $this->query_model->getCaptchaInputFields('contact_us_form'); ?>
	 <input type="hidden" name="hid_location" value="<?= !empty($contactDetail) ? $contactDetail->id : '' ?>" />
	  <div class="message">
				<div id="alert"></div>
	  </div>
        <div style="position:relative;">
          <input type="text" name="name" id="first_name2"  class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('first_name'); ?>" onFocus="this.placeholder = ''"   onBlur="textAlphabatic(this)" maxlength="<?php echo $this->query_model->fullNameInputMaxLength(); ?>" error_class="name_error2" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?>" >
          <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
          <div style="position:relative;" class="optinlastname">
          <input type="text" name="last_name" id="last_name2" class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('last_name'); ?>" onFocus="this.placeholder = ''"  onBlur="textAlphabatic(this)" maxlength="25" error_class="last_name_error" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?>" >
          <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
        <div style="position:relative;">
          <input type="text" name="phone"id="telephone2" class="contact-form-line  <?php echo $getPhoneNumberClass; ?>" placeholder="<?php echo $this->query_model->getStaticTextTranslation('phone'); ?>" onFocus="this.placeholder = ''" error_class="phone_error2"  onBlur="phoneValidation(this)" maxlength="<?php echo $phoneNumberMaxLength; ?>" >
          <span class="fa fa-phone form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
		  <input type="text" id="fax" name="fax" class="optinfax"   placeholder="Fax Number" value="">

        <div style="position:relative;">
          <input type="email"  name="form_email_2" id="form_email2"  class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('email'); ?>" onFocus="this.placeholder = ''" onBlur="this.placeholder = '<?php echo $this->query_model->getStaticTextTranslation('email'); ?>'">
          <span class="fa fa-envelope form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
         
		<div style="position:relative;">
		<?php if($multiLocation[0]->field_value == 1 ){ ?>
          <select class="locationBox contact-form-line getContactPageUrl" id="school2" name="school">
            <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_location'); ?></option>
					<?php foreach($form_allLocations as $location): ?>
						<option  value="<?=$location->name;?>" <?php if($contactDetail->id == $location->id){ echo 'selected=selected'; }?> slug="<?=$location->slug;?>"><?=$location->name;?> </option>
					<?php endforeach;?>   
          </select>
		  <?php } ?>
          <span class="fa fa-map-marker form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
		  
		
        <div style="position:relative;"> <span class="site_theme_text fa fa-comment form-control-feedback move_input_icon" aria-hidden="true"></span>
          <textarea  name="message" id="message2" class="contact-form-area" placeholder="<?php echo $this->query_model->getStaticTextTranslation('message'); ?>" onFocus="this.placeholder = ''" onBlur="this.placeholder = '<?php echo $this->query_model->getStaticTextTranslation('message'); ?>'"></textarea>
        </div>
		
		<?php if(!empty($twilioApi)){?>
		<div style="position:relative;"> 
		   <div class=" twilio_checkbox" >
			  <input type="checkbox" class="contact-form-line" name="twilio_checkbox" value="1"> <?php echo $twilioApi->checkbox_text ?>
		   </div>
		 </div>
		 <?php } ?>
		 <input type="text" id="comment" name="comment" class="optincomment"   placeholder="Write your comment here..." value="">
		<input type="checkbox" class="optincheck" name="contact_me_by_phone" value="1">
		  <?php if($this->query_model->get_gdpr_compliant() == 1){?>
		   <div style="position:relative;">
			<div class="email_optin_gdpr_compliant_checkbox" >
				<input type="hidden" name="ip_address" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
				
				<input type="checkbox" class="form-control" id="gdpr_compliant_2" name="gdpr_compliant_checkbox" value="1"><?php echo $gdpr_compliant_txt1; ?>
		   </div>
		   </div>
		 <?php } ?>
		
		<input type="hidden" value="" name='email' id='email' class="submit button" style="display:none" />	
		<?php
			$contact_page_slug = $this->query_model->getConatctPageSlug($contactDetail->id);
		?>
		<input type="hidden" class="conatct_page_url" name="page_url" value="<?php echo !empty($contact_page_slug) ? $contact_page_slug : '/'; ?>" />	
		<input type="text" id="website" name="website" class="optinwebsite"  placeholder="Website" value="">
<input type="text"  class="ywedobjeo" name="x2o3d_<?php echo $this->query_model->setAndGetUniqueNumberForCustomField(); ?>" value="<?php echo time(); ?>"  placeholder="Serial Number"/>
        <input type="submit" value="<?php echo $this->query_model->getStaticTextTranslation('send_message'); ?>" class="btn btn-readmore  btn-block submit button contactFormSubmit2">
      </form>
    <div class="clearfix"></div>
  </div>
</section>
      


	  
	  
	  
<script>
	$(document).ready(function(){
		$('.staffInfoPopUp').click(function(){
			var number = $(this).attr('number');
				
				$.ajax({
			
					url: '<?=base_url();?>site/get_school_staff_detail',
					
					type: 'post',
					
					data: {staff_id: number},

					
					dataType: 'html',
					
					success: function(result) {
						$('#staffDetail').html(result);
						
					}
				  
			});
		});
		
	
	});
	
	
</script>
<div class="modal fade bs-example-modal-lg staff-popup" id="staffDetail"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	
</div>


<?php $this->load->view('includes/footer'); ?> 


<?php $forms = array('opt_in_form','contact_us_form');
echo $this->query_model->getGoogleCaptchaScript($forms); ?>