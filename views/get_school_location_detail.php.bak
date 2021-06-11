 <div class="container">
           <div class="row">
               <div class="col-md-5 col-xs-12">
                     <?php if($contactDetail->photo != ''){ ?>
                 <img src="<?php echo base_url().$contactDetail->photo; ?>" class="img-responsive"> 
                 <?php } ?> 
                  
               </div>
               <div class="col-md-4 col-xs-12">
                   <div class="school-address">
                       <h2><?=  $this->query_model->getDescReplace($contactDetail->name); ?></h2>
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