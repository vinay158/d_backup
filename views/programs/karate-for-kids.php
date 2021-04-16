
<?php $this->load->view('includes/header'); ?>

<?php  $this->load->view('includes/header/masthead'); ?>
<?php $phoneNumberMaxLength = $this->query_model->phoneNumberMaxLength(); 

	  $getPhoneNumberClass = $this->query_model->getPhoneNumberClass(); 
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
	$(window).load(function(){
		var selected = $('input[name=call_or_schedule]:checked').val();
		
		if(selected == 'call'){
					$('.callDiv').hide();
		} else{
			$('.callDiv').show();
		}
	});
</script>


<!-- Navigation -->
<div class="mobile-contact">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 text-center"> <span class="no title-p"> Our Program</span>
        <div class="row">
          <div class="col-xs-6 row-btn"> <a class="btn btn-theme"> Free Trial Class </a> </div>
          <div class="col-xs-6 row-btn"> <a class="btn btn-theme"> <i class="fa fa-map-marker"></i> Find Us </a> </div>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
</div>
<section id="program-main" class="program-trial-form" style="background-image:url('./images/about-top.jpg');">
  <span class="overlay"></span>
  <div class="container">
    <div class="row">
      <div class="col-md-12 hidden-xs mobile-tab-hidden">
        <a href="#" class="prev-page"><i class="fa fa-angle-left"></i> Back to Previous Page</a>
      </div>
      
      <div class="col-sm-4 col-md-4 text-span4 hidden-xs mobile-tab-hidden ">
        <img src="images/logo-white.png">
        <div class="program-desc">
          <h2  style="background-color: rgba(0,0,0,0.5);padding: 15px;">Helping Parents Raise Confident Leaders</h2>
          <p>Karate for kids will help your child develop essetnial skills that they can apply to all areas of life. Getting started is is easy:</p>
          <ul>
          <li>&bull; Purchase 10 Classes, only $10!</li>
          <li>&bull; Schedule 1st Class</li>
          <li>&bull; Get A Free Uniform!</li>
          </ul>
        </div>
      </div>
      <div class="col-sm-4 col-md-4 hidden-xs vertical-image">
        <img src="images/program-kid.png" class="img-responsive">
      </div>
      <div class="col-md-4 col-sm-4 form-schedule form-span4 ">
        <div class="program-trial">
          <div class="red-block text-center">
            <h1>Karate For Kids<br><strong>10 Classes<br>only $10!</strong></h1>
            <h2>Includes a<br>FREE UNIFORM!</h2>
            <div class="big_triangle_wrapper">  
      <div class="big_triangle"></div>  
      </div>
          </div>
          <div class="white-block redeem-offer-block">
          <h3>Join Our Confidence Building
            Martial Arts Classes
            In Bentonville, Ar</h3>
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Enter your email address" name="">
            </div>
            <a href="#" class="redeem-offer">Redeem trial offer</a>
            
          </div>
        </div>
        <span class="triangle">
          <p>We respect your privacy and will NEVER sell, rent<br>or share your email address.</p>
        </span>
      </div>

      <div class="col-sm-4 col-md-4 text-span4 hidden-sm hidden-md hidden-lg mobile-tab-visible ">
        <img src="images/logo-white.png">
        <div class="program-desc">
          <h2  style="background-color: rgba(0,0,0,0.5);padding: 15px;">Helping Parents Raise Confident Leaders</h2>
          <p>Karate for kids will help your child develop essetnial skills that they can apply to all areas of life. Getting started is is easy:</p>
          <ul>
          <li>&bull; Purchase 10 Classes, only $10!</li>
          <li>&bull; Schedule 1st Class</li>
          <li>&bull; Get A Free Uniform!</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
<section id="mom-dad">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-sm-12">
        <p>Mom & Dad,</p>
        <h2>We understand how many challenges you face as a parent,<br> raising a child in the modern world</h2>

      </div>
    </div>
  </div>
</section>
<section id="mom-son">
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <img src="images/mom-son.png" class="img-responsive">
      </div>
      <div class="col-md-9">
        <div class="desc-text">
        <p>Teaching children to know right from wrong is one of the toughest challenges parents have to face.</p>

        <p>You want your child to have the tools to succeed in life, but protecting them from peer pressure, bullying and internet predators can make any parent feel overwhelmed with anxiety and stress.</p>

        <p>The good news is that at ATA Martial Arts in Bentonville, our Karate for Kids program is the perfect companion to help you raise a strong, confident leader, teaching confidence, focus & self-defense skills.</p>
        <h3>Parenting should not have to be a stressful task you face alone!</h3>
        <h3>Let ATA Martial Arts Help You Equip Your Child For Success In The Real World.</h3>
        </div>
      </div>
    </div>
  </div>  
</section>
<section id="life-skills">
  <div class="container">
    <div class="row">
      <h2><strong>ATA Karate For Kids</strong> Teaches Life Skills</h2>
      <div class="col-sm-4">
        <img src="images/skill-1.png">
        <p>Positive Mental Attitude</p>
      </div>
      <div class="col-sm-4">
        <img src="images/skill-2.png">
        <p>High Goal Setting</p>
        
      </div>
      <div class="col-sm-4">
        <img src="images/skill-3.png">
        <p>Respect & Self Confidence</p>
        
      </div>
    </div>
  </div>
</section>


      <section class="section" id="discover">
         <span class="gray-overlay"></span>
         <div class="container">
            <div class="row">
               <div class="col-md-8 col-md-push-2">
                 
                  <div class="player-inner">
                    <iframe  height="390" src="https://www.youtube.com/embed/zFuSxrGvfy8?rel=0&amp;controls=0&amp;showinfo=0&amp;autoplay=0" frameborder="0" allowfullscreen ></iframe>
                  </div>
               </div>
            </div>
         </div>
      </section>
<section id="toggle-block" class="clearfix blue-bg share-section">
         <div class="content-box">
          <h2>ATA Martial Arts<br> Is Your Partner In Parenting</h2>
          <h3>We teach the same values you teach at home, in a positive, safe & fun environment.</h3>
          <p>The foundation of the Karate for Kids curriculum is the education and development of life-skills such as positive mental attitude, high goal setting, perseverance, self-control and confidence.</p>
            </div>
  
            <div class="relative-block">
                <div class="full-bg-toggle-a" style="background-image:url('./images/kids.jpg'); ">
                   <span class="cyan-overlay"></span>
                </div>
            </div>
       
  </section>

  <section id="get-started">
  <div class="container">
    <div class="row">
      <h2>Getting Started Is Easy!</h2>
      <div class="col-sm-4">
        <img src="images/reedem.png">
        <h3>Redeem</h3>
        <p> Our 10 Lesson Trial<br> for only $9.99</p>
      </div>
      <div class="col-sm-4">
        <img src="images/calendar.png">
        <h3>Schedule</h3>
        <p> Your Child's First<br>Semi-Private Lesson</p>
      </div>
      <div class="col-sm-4">
        <img src="images/pickup.png">
        <h3>Pickup</h3>
        <p>Your Child’s Free Uniform &<br>Begin Martial Arts!</p>
      </div>
    </div>
  </div>
</section>
<section class="difference-block" id="difference" style="background-image: url(./images/testi-bg.jpg);">
         <span class="overlay"></span>
         <div class="container">
            <div class="row text-center">
               <div class="col-sm-12 col-md-12">
                  <div class="text-center">
                     <h2><strong>What Makes Fayetteville ATA Martial Arts Different</strong> From other<br> Karate &amp; Taekwondo Schools?</h2>
                  </div>   
                  <div class="col-sm-4 col-md-4">
                     <div class="block-box">
                        <p>The country’s<b> largest</b> martial arts organization. </p>
                        <img src="images/logo.png">
                     </div>
                  </div>  
                  <div class="col-sm-4 col-md-4">
                     <div class="block-box">
                        <p><b>130,000 active members </b> &amp; over 1 million students trained since 1969.</p>
                     </div>
                  </div>  
                  <div class="col-sm-4 col-md-4">
                     <div class="block-box">
                        <p>Each instructor has passed an intensive certification process based on <b>40 years of tradition, research &amp; development.</b></p>
                     </div>
                  </div>   
               </div>
            </div>
         </div>
      </section>
      <section id="parents" class="text-center">
         <div class="container">
            <div class="row">
               <div class="col-md-12 col-sm-12">
                  <div class="text-center">
                     <h2><strong>Parents,</strong> Did You Know...</h2>
                  </div>
               </div>
                  <div class="col-sm-4">
                    <img src="images/fact-1.png">
                    <h2>1 OUT OF 4 KIDS</h2>
                    <p> is a victim of bullying</p>
                  </div>
                  <div class="col-sm-4">
                    <img src="images/fact-2.png">
                    <h2>42.5% OF TEENS </h2>
                    <p>in the US try drugs</p>
                  </div>
                  <div class="col-sm-4">
                    <img src="images/fact-3.png">
                    <h2>25% OF H.S. STUDENTS </h2>
                    <p>fail to graduate on time</p>
                  </div>
                  <div class="col-md-10 col-md-push-1 col-sm-12 stats">
                    <h2><strong>DO NOT LET YOUR CHILD BECOME A STATISTIC.</strong></h2>
                    <p class="lead">Equip them with the tools to succeed in the real world with ATA Martial Arts.</p>
                    <p>Since 1969, over one million students have trained in one of the 950 ATA Licensed schools. Our students regularly go on to join Ivy schools and become community leaders. The values they learn during their martial arts journey are the same you teach at home and last a lifetime.</p>
                  </div>
            </div>
         </div>
      </section>
      <section id="life-skills" class="ways sky-bg">
        <div class="container">
          <div class="row">
            <h2>3 Ways Our Kids Martial Arts Classes<br><strong>Help Your Child Reach Their Potential:</strong></h2>
            <div class="col-sm-4">
              <img src="images/team-work.png" class="img-responsive">
              <h3>TEAMWORK SKILLS</h3>
              <p>Social interaction teaches kids
                how to effectively work as
                part of a team.</p>
            </div>
            <div class="col-sm-4">
              <img src="images/fitness.png" class="img-responsive">
              <h3>PHYSICAL FITNESs</h3>
              <p>Martial arts helps improve
                coordination and is an
                excellent form of exercise.</p>
            </div>
            <div class="col-sm-4">
              <img src="images/healthy.png" class="img-responsive">
              <h3>BUILD HEALTHY HABITS</h3>
              <p>Building healthy habits early
                on can help prevent obesity
                and diabetes later in life.</p>
            </div>
          </div>
        </div>
      </section>
<!-- features program section -->
<section id="ata-ad">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <img src="images/logo.png">
        <h2>At Bentonville ATA Martial Arts, it is our mission to help you raise a confident,<br> focused leader with the life-transforming experience that is martial arts.</h2>
      </div>
    </div>
  </div>
</section>
<section id="learn-goal" class="cyan-bg ">
  <div class="container">
    <div class="row">
      <div class="col-md-10 col-md-push-1">
        <div class="row">
          <div class="col-md-4 img-over">
            <img src="images/goal.png">
          </div>
          <div class="col-md-8">
            <div class="text-block">
            <h2>Learn Goal-Setting Skills</h2>
            <p>Belt testing provides an excellent exercise for kids in learning how to set and achieve goals. Their self-esteem will continue to rise with each accomplishment as they watch their hard work pay off.</p>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section id="improve-focus" class="white-bg ">
  <div class="container">
    <div class="row">
      <div class="col-md-10 col-md-push-1">
        <div class="row">
          
          <div class="col-md-4 img-over col-md-push-8">
            <img src="images/focus.png" class="">
          </div>
          <div class="col-md-8 col-md-pull-4">
            <div class="text-block">
            <h2>Improve Focus and Self-Control</h2>
            <p>Complex physical activities such as martial arts have proven to strengthen the brain’s neural networks, helping kids improve their focus and self-control. This can be especially beneficial for kids with ADD/ADHD.</p>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="learn-goal" class="blue-bg ">
  <div class="container">
    <div class="row">
      <div class="col-md-10 col-md-push-1">
        <div class="row">
          <div class="col-md-4 img-over">
            <img src="images/sense.png">
          </div>
          <div class="col-md-8">
            <div class="text-block">
            <h2>A Strong Sense of Respect</h2>
            <p>The traditional nature of martial arts teaches kids respect in their classes, whether they are taking a bow or waiting patiently for the next set of instructions. This sense of respect also helps kids improve their grades, while improving their listening skills at home and in school.</p>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

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
<section id="faq">
       <div class="container">
         <div class="row">
          <div class="col-md-12 text-center">
            <h2>Frequently Asked Questions</h2>
          </div>
           <div class="col-md-6 col-sm-6">
             <div class="faq-left">
               <label>What Age Groups Are Available for Karate for Kids? </label>
               <p>Our Pre-School program is ages 3-6, while Pre-Teens is Ages 7-12</p>

               <label>What Happens After I Purchase the Trial Offer?  </label>
               <p>You will receive an email with instructions on how to schedule your first class.  One of our instructors will call you, or you may call the school directly.</p>

               <label>I Love All the Benefits Such as Confidence, Self-Esteem, and Focus … But Will My Kid Have Fun? </label>
               <p>Our Martial Arts classes' primary goal is to make sure our students have fun in a playful, safe environment.  Come and see a class for yourself - the kids have a blast and our instructors do too.</p>
             </div>
            
           </div>
           <div class="col-md-6 col-sm-6">
            
              <div class="faq-right">
               <label>Are There Long Membership Commitments?</label>
               <p>We offer month to month memberships as well as savings on longer plans</p>

               <label>Will My Child Be Fighting Other Children?  </label>
               <p>Absolutely not.  Although they will learn cool martial arts and self-defense moves, your child will learn how to AVOID fights, not pick them.</p>

               <label>Does My Child Need to Have Previous Experience or Any Particular Fitness Level to Enroll in Martial Arts Classes? </label>
               <p>No, our classes are a good mix of boys and girls of all fitness levels.  Beginners train alongside some of the more experienced kids, helping each other out in a fun team environment.</p>
             </div>
           </div>


         </div>
       </div>
     </section>

<section id="get-started" class="gift" style="background-image:url('./images/about-top.jpg');">
<span class="overlay"></span>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <h2>Give your child the gift of a lifetime</h2>
        <h3>Begin your child's martial arts journey for only $55.00</h3>
        <p>This is a limited time offer!<br>Only 25 total spots are available.</p>
      </div>
      <div class="col-sm-4">
        <img src="images/reedem.png">
        <h2>Trial Offer = <br>No Commitments</h2>
      </div>
      <div class="col-sm-4">
        <img src="images/pickup.png">
        <h2>Free Uniform & <br>
        Private Lesson Included<br>
        ($200 Value)</h2>
      </div>
      <div class="col-sm-4">
        <img src="images/money.png">
        <h2>100% Money Back<br>Guaranteed!</h2>
      </div>
    </div>
  </div>
</section>
 <section class="trial-form trial-form-about-footer" id="trial-program">
         <div class="container">
            <div class="row">
               <div class="col-md-12 text-center">
                  <h2>Karate For Kids</h2>
                  <h1>10 Classes Only $10!</h1>
                  <p>Includes a FREE UNIFORM!</p>
               </div>
            </div>
         </div>
      </section>
      <div class="started-block white-bg green-color p-b-40">
         <span></span>
         <div class="search-box">
            <input type="text" class="form-control" name="" placeholder="Enter your email address">
            <button class="btn-red">Get Info</button>
         </div>
      </div>
	  
	  
	  
	
	  
	  
<section class="map-main" id="direction">
  <div id="location-map">
    <div id="map_div5"></div>
  </div>
  
  <!-- form -->
  <section class="mobile-contact">
      <div class="container">
        <div class="row">
          <div class="col-sm-12 text-center">
		   <span class="no"><?= $mainLocation[0]->phone ?></span>
		  <p class="normal_text"><?php echo  $this->query_model->getFullAddress($mainLocation[0]->address,$mainLocation[0]->suite,$mainLocation[0]->city,$mainLocation[0]->state,$mainLocation[0]->zip); ?></p>
        <div class="row">
          <?php if($site_settings[0]->hide_window != 'hide'): ?>
            <div class="col-xs-6 row-btn"> 
			<a class="btn btn-theme"  href="<?php echo $this->query_model->getTrialOfferUrl($site_settings[0]->url_call_to_action); ?>" target="<?php if($site_settings[0]->window == 'new'): echo '_blank'; endif; ?>"> 
			<?php $this->query_model->getStrReplace($site_settings[0]->call_to_action); ?></a> 
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
			
		$('.contactFormSubmit3').click(function(){
		
					var err = 0
					var name=$('#first_name2').val();
					//alert(name); return false;
					if(name.length == 0){
						var err = 1;
						$('#first_name2').after('<div class="reds name_error2">Enter your first name</div>');
					}
					
					var last_name=$('#last_name2').val();
					if(last_name.length == 0){
						var err = 1;
						$('#last_name2').after('<div class="reds last_name_error2">Enter your last name</div>');
					}
					
					/*var telephone=$('#telephone2').val();
					<?php if($site_settings[0]->phone_required == 1){ ?>
                                                <?php if($site_settings[0]->international_phone_fields != 1){ ?>
					if(telephone.length <= 11 || telephone.length == 0){
						var err = 1;
						$('#telephone2').after('<div class="reds phone_error1">Enter a valid phone number</div>');
						
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
							if($site_settings[0]->phone_required == 1){
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
					var email=$('#form_email2').val();
					if(email.length == 0 || emailfilter.test($("#form_email2").val()) == false){
						var err = 1;
						$('#form_email2').after('<div class="reds email_error2">Enter a valid email address</div>');
					}
					
					
					
					<?php if($multiLocation[0]->field_value == 1 ){ ?>
					var school=$('#school2').val();
					if(school == '' || school == null){
						var err = 1;
						$('#school2').after('<div class="reds school_name_error2">Select your location</div>');
					}
					<?php } ?>
					
					var message=$('#message2').val();
					//alert(name); return false;
					if(message.length == 0){
						var err = 1;
						$('#message2').after('<div class="message_error message_error2">Enter your message</div>');
					}
					
					
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
						$('#first_name2').after('<div class="reds name_error2">Enter your first name</div>');
						
					}
			});
			
			$('#last_name2').keyup(function(){
					if($(this).val().length > 0){
						$('.last_name_error2').hide();
					} else{
						$('#last_name2').after('<div class="reds last_name_error2">Enter your last name</div>');
						
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
								$('#telephone2').after('<div class="reds phone_error2">Enter a valid phone number</div>');
                                                            <?php  } ?>
							}
						<?php }else{ ?>
                                                            <?php if($site_settings[0]->international_phone_fields == 1){ ?>
                                                                $('.phone_error2').hide();
                                                            <?php  }else{ ?>
								$('#telephone2').after('<div class="reds phone_error2">Enter a valid phone number</div>');
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
						$('#form_email2').after('<div class="reds email_error2">Enter a valid email address</div>');
						
					}
			});
			
			
			<?php if($multiLocation[0]->field_value == 1 ){ ?>
			$('#school2').change(function(){
					if($(this).val() != ''){
						$('.school_name_error2').hide();
					} else{
						$('.school_name_error2').show();
						$('#school2').after('<div class="reds school_name_error2">Select your location</div>');
						
					}
			});
			<?php } ?>
			
			$('#message2').keyup(function(){
					if($(this).val().length > 0){
						$('.message_error2').hide();
					} else{
						$('#message2').after('<div class="message_error message_error2">Enter your first name</div>');
						
					}
			});
			
			
			
			
		});

	</script>	
      <form class="d-bg-c contact-form content_contact_form"action="contactus/send" method="post">
	 <input type="hidden" name="hid_location" value="<?= !empty($contactDetail) ? $contactDetail->id : '' ?>" />
	  <div class="message">
				<div id="alert"></div>
	  </div>
        <div style="position:relative;">
          <input type="text" name="name" id="first_name2"  class="contact-form-line" placeholder="First Name" onFocus="this.placeholder = ''"   onBlur="textAlphabatic(this)" maxlength="25" error_class="name_error" error_msg="Enter your first name" >
          <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
          <div style="position:relative;">
          <input type="text" name="last_name" id="last_name2" class="contact-form-line" placeholder="Last Name" onFocus="this.placeholder = ''"  onBlur="textAlphabatic(this)" maxlength="25" error_class="last_name_error" error_msg="Enter your last name" >
          <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
		  
		  <div style="position:relative;">
          <input type="text" name="phone" id="telephone2" class="contact-form-line   <?php echo $getPhoneNumberClass; ?>" placeholder="Phone" onFocus="this.placeholder = ''" error_class="phone_error2" onBlur="phoneValidation(this)" maxlength="<?php echo $phoneNumberMaxLength; ?>"  > <span class="fa fa-phone form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span></div>
        
        <div style="position:relative;">
          <input type="email"  name="form_email_2" id="form_email2"  class="contact-form-line" placeholder="Email" onFocus="this.placeholder = ''" onBlur="this.placeholder = 'Email'">
          <span class="fa fa-envelope form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
       
	    <div style="position:relative;">
		<?php if($multiLocation[0]->field_value == 1){ ?>
          <select class="locationBox contact-form-line getContactPageUrl" id="school2" name="school">
            <option value="">Choose a Location</option>
					<?php foreach($form_allLocations as $location): ?>
						<option  value="<?=$location->name;?>"  slug="<?=$location->slug;?>"><?=$location->name;?> </option>
					<?php endforeach;?>   
          </select>
		  <?php } ?>
          <span class="fa fa-map-marker form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
		
        <div style="position:relative;"> <span class="site_theme_text fa fa-comment form-control-feedback move_input_icon" aria-hidden="true"></span>
          <textarea  name="message" id="message2" class="contact-form-area" placeholder="Message" onFocus="this.placeholder = ''" onBlur="this.placeholder = 'Message'"></textarea>
        </div>
		
		<input type="hidden" value="" name='email' id='email' class="submit button" style="display:none" />			
		<input type="text" id="website" name="website" style="display:none" autocomplete="off">
		<?php
			$contact_page_slug = $this->query_model->getConatctPageSlug();
		?>
		<input type="hidden" class="conatct_page_url" name="page_url" value="<?php echo !empty($contact_page_slug) ? $contact_page_slug : '/'; ?>" />
        <input type="submit" value="Send Message" class="btn btn-readmore  btn-block submit button contactFormSubmit3">
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

