<?php $this->load->view("admin/include/header"); ?>

<style>
	.display-none {display:none !important}
	.button1,.button2 {
		font-weight: bold;
	}
</style>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<!--<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>-->
<script src="js/ckeditor_full/ckeditor.js"></script>
<link id="jquiCSS" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/ui-lightness/jquery-ui.css" type="text/css" media="all">
	<link href="colorpicker/css/evol.colorpicker.min.css" rel="stylesheet" />
	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js" type="text/javascript"></script>-->
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js" type="text/javascript"></script>
	<script src="colorpicker/js/evol.colorpicker.min.js" type="text/javascript"></script>
	<script src="js/jquery.sticky-sidebar.js" type="text/javascript"></script>

	<script language="javascript">

$(window).load(function(){
	
	$.each($('.language'),function(){
		if($(this).is(':checked')){
			var language = $(this).val();
		
			if(language == "english"){
				$('.otherLanguageName').hide();
			}else{
				$('.otherLanguageName').show();
			}
		}
	})
	
})

$(document).ready(function(){
	$("#main_title").keyup(function(){
		$("#sef_title").html($(this).val());
	})

	$('.language').click(function(){
		var language = $(this).val();
		
		if(language == "english"){
			$('.otherLanguageName').hide();
		}else{
			$('.otherLanguageName').show();
		}
		
	})
	
	

$('.btn-save').click(function(){
	
	$(this).append("<input type='hidden' name='scroll_top' value='"+$(document).scrollTop()+"'>");
	
});
	
	
})
</script>

<div class="az-content-body-left advanced_page advanced_page static_texts_and_traslations" >

       <div class="row row-sm">

          <div class="col-sm-12 col-xl-12"  >
			<div class="card pd-sm-20 program-cat-page program-detail-page">
				<div class="container">
	  
	  
        
    <div class="az-content az-content-app az-content-contacts pd-b-0">
      <div class="container">
        <div class="az-content-left az-content-left-contacts">


         <div class="az-mail-header">
            <div>
              <h4 class="az-content-title mg-b-5"><?php echo $title; ?></h4>
			   
				  
            </div>
            <div>
			
			
			</div>
          </div>
		
		<?php $page_url = ''; ?>
          <div id="azContactList" class="az-contacts-list">
			
			<a href="<?php echo $page_url; ?>#Common" class="az-contact-item">
              <div class="az-contact-body">
                <h6>Common Texts</h6>
              </div>
            </a>
		
			<a href="<?php echo $page_url; ?>#ProgramPage" class="az-contact-item welcome_image">
              <div class="az-contact-body">
                <h6>Program Category and Program Detail Page</h6>
              </div>
            </a>
			
			<a href="<?php echo $page_url; ?>#TrialPage" class="az-contact-item welcome_image">
              <div class="az-contact-body">
                <h6>Trial Offer and Free Paid Trial Offer Page</h6>
              </div>
            </a>
			
			<a href="<?php echo $page_url; ?>#ContactPage" class="az-contact-item welcome_image">
              <div class="az-contact-body">
                <h6>Contact Us Page</h6>
              </div>
            </a>
			
			<a href="<?php echo $page_url; ?>#DojocartPage" class="az-contact-item welcome_image">
              <div class="az-contact-body">
                <h6>Dojocart Page</h6>
              </div>
            </a>
			
			<a href="<?php echo $page_url; ?>#ThankyouPage" class="az-contact-item welcome_image">
              <div class="az-contact-body">
                <h6>Career Thank You Page</h6>
              </div>
            </a>
			
			<a href="<?php echo $page_url; ?>#PageNotFound" class="az-contact-item welcome_image">
              <div class="az-contact-body">
                <h6>Page Not Found</h6>
              </div>
            </a>
			
			<a href="<?php echo $page_url; ?>#StudentSection" class="az-contact-item welcome_image">
              <div class="az-contact-body">
                <h6>Student Section</h6>
              </div>
            </a>
			
			<a href="<?php echo $page_url; ?>#BlogPage" class="az-contact-item welcome_image">
              <div class="az-contact-body">
                <h6>Blogs and Blog Detail Page</h6>
              </div>
            </a>
			
			<a href="<?php echo $page_url; ?>#MiniTrialForm" class="az-contact-item welcome_image">
              <div class="az-contact-body">
                <h6>Contact and Mini Trial Forms</h6>
              </div>
            </a>
			
			<a href="<?php echo $page_url; ?>#BdyForm" class="az-contact-item welcome_image">
              <div class="az-contact-body">
                <h6>Birthday Party and Summer Camp Form</h6>
              </div>
            </a>
			
			<a href="<?php echo $page_url; ?>#FreePaidTrialForm" class="az-contact-item welcome_image">
              <div class="az-contact-body">
                <h6>Free and Paid Trial Offer Forms</h6>
              </div>
            </a>
			
			<a href="<?php echo $page_url; ?>#CarrerForm" class="az-contact-item welcome_image">
              <div class="az-contact-body">
                <h6>Career Opportunities Form</h6>
              </div>
            </a>
			
			
			
			
          </div><!-- az-contacts-list -->

        </div> <!-- az-content-left -->
        <div class="az-content-body az-content-body-contacts">
			
				<div class="az-mail-header">
            <div>
              <h4 class="az-content-title mg-b-5"><?php echo $title; ?></h4>
            </div>
            
          </div>
				
				<div class=" edit-form edit_form_box">

<form id="blog_form" class="programForm" action="" method="post" enctype="multipart/form-data">
<div class="gen-holder" style="display:flex !important">
	<div class="gen-panel-holder" style="width:100% !important">
	<div class="gen-panel">
		
	
		<div class="panel-body"  id="content">
		<div class="panel-body-holder">
		<div class="form-holder">
				
<?php $staticTextArr['Common Texts'] = array(
									'learn_more'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Learn More'), //--
									'play_video'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Play Video'), //--
									'read_more'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Read More'), //--
									'login'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Login'), //--
									'submit'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Submit'), //--
									'go'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'GO'),//--
									'our_locations'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Our Locations'), //--
									'send_message' =>array('input_type'=>'text','screenshoot_url'=>'','text'=> 'Send Message'),  //--
									'all_rights_reserved'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'All Rights Reserved. | Martial Arts Websites by '),  //--
									'view_large_map'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'View Larger Map'), //--
									'category_interest'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Category Of Interest'), 
									'program_interest'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Program Of Interest'),
									'an_error_occurred'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'An error occurred, please try again.'),
									'choose_your_trial_offer'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Choose Your Trial Offer'), //--
									'fill_in_your_info_below'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Fill in Your Info Below'), //done
									'step'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Step'), //--
									'success'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Success'),  //--
									'failed'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Failed'), //--
									'go_back_homepage'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Go back to the homepage'), //upsell_thankyou_page //--
									'load_more'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Load More'), //about and school insta and fb feeds //--
									'take_action_now'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Take Action Now!'), //school page //--
									'read_bio'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Read Bio'), //school page //--
									'likes'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Likes'), //school page //--
									'comments'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Comments'), //school page //--
									'follow'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Follow'), //school page //--
									'ata_timeline'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'ATA Timeline'), //school page //--
									'team_members'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Team Members'), //school page //--
									'limited_trial_offer_available'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Limited Trial Offers Available'), //about page //--
									
									'view_web_specials'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'View Web Specials!'), //--
									'view_current_web_specials'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'opt-in to view our<br> current web specials<br> in '), //--
									 
									'redeem_trial_offer'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Opt–in to redeem trial offer'), //--
									'choose_trial_offer_to_proceed'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'You must choose a Trial Offer in order to proceed!'),  //--
									'choose_an_upsell'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'You must choose an upsell!'), //--
									'view_trial_offer'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'View Trial Offer'), //--
									'all'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'All'), //--
									'imagine_yourself'=>array('input_type'=>'textarea','screenshoot_url'=>'','text'=>'imagine yourself or your child as a strong, confident leader.'), //--
									'incorrect_password'=>array('input_type'=>'textarea','screenshoot_url'=>'','text'=>'Password is incorrect, please try again'), //--
									'password'=>array('input_type'=>'textarea','screenshoot_url'=>'','text'=>'Password'), //--
									'locations'=>array('input_type'=>'textarea','screenshoot_url'=>'','text'=>'Locations'), 
									'no_news'=>array('input_type'=>'textarea','screenshoot_url'=>'','text'=>'No news at this time, please check back later!'), 
									
									'price_with_no_commitments'=>array('input_type'=>'textarea','screenshoot_url'=>'','text'=>'This is your chance to try our martial arts program at a reduced price with no commitments!'),  //--
									'cookies_disclimer'=>array('input_type'=>'textarea','screenshoot_url'=>'','text'=>'We use cookies to improve your browsing experience and help us improve our websites. Our company and carefully selected third parties use cookies to show you more relevant ads online. For more information, please <a href="{base_url}privacy-policy">click Here</a>. By continuing to use our website, you agree to our use of such cookies.'), //done
									'gdpr_compliant_txt1'=>array('input_type'=>'textarea','screenshoot_url'=>'','text'=>'By clicking the submit button you agree to our <a href="{base_url}terms-and-conditions" target="_blank">Terms & Conditions</a> and <a href="{base_url}privacy-policy" target="_blank">Privacy Policy.</a>'),  //done
									
									
									'gdpr_compliant_txt2'=>array('input_type'=>'textarea','screenshoot_url'=>'','text'=>'To help you on your martial arts journey, we’d love to send you tailored offers and information via email. Please tick this box if you agree.'), //done
									'enter_email_view_current_web_specials'=>array('input_type'=>'textarea','screenshoot_url'=>'','text'=>'Enter your Email to View Current Web-Specials & Pricing'), //done
								
								);
	
		//echo '<pre>staticTextArr'; print_R($staticTextArr); die;
		$staticTextArr['Program Category and Program Detail Page'] = array(
							//our-programs and Program Details
							'We_respect_your_privacy'=>array('input_type'=>'textarea','screenshoot_url'=>'','text'=>'We respect your privacy and will NEVER sell, rent<br>or share your email address.'), //--
							'ages'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Ages'),//--
							'back_to_previous_page'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Back to Previous Page'), //program //--
							'frequently_asked_questions'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Frequently Asked Questions'),//program //--
						);
		
		$staticTextArr['Trial Offer and Free Paid trial offer Page'] = array(
							/* Trial Offer and Free Paid trial offer*/
							'paid'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'PAID'),//trial-offer //--
							'free'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'FREE'),//trial-offer //--
							'choose_program_of_interest'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'CHOOSE PROGRAM OF INTEREST'),//trial-offer //--
							'web_special'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Web Special'),
							'web_specials'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Web Specials'), //--
							'available' =>array('input_type'=>'text','screenshoot_url'=>'','text'=> 'Available'),//trial-offer //--
							'select' =>array('input_type'=>'text','screenshoot_url'=>'','text'=> 'Select'),//trial-offer  //--
							'selected'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Selected'), //--
							'view_specials' =>array('input_type'=>'text','screenshoot_url'=>'','text'=> 'VIEW SPECIALS'),//trial-offer //--
							'no_web_special_available' =>array('input_type'=>'text','screenshoot_url'=>'','text'=> 'No Web Special Available'),//trial-offer //--
							'redeem_current_trial_offers' =>array('input_type'=>'textarea','screenshoot_url'=>'','text'=> 'Opt-in to redeem current trial offers and view pricing & details'),//trial-offer //-- 
							'select_trial_offer_cat_above' =>array('input_type'=>'textarea','screenshoot_url'=>'','text'=> 'Oops! First you must select a Trial Offer Category above'),//trial-offer //-- 
							'choose_trial_offer_category' =>array('input_type'=>'text','screenshoot_url'=>'','text'=> 'You must choose a Trial Offer category!'), //-- 
							'exclusive_web_offer'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'exclusive Web Offer'),//trial-offer //-- 
							'i_agree_term_condition'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'I agree to the Terms & Conditions'),//start_trial //-- 
							'payment'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Payment'),
							'payment_failure'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Payment Failure'),
							'payment_success'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Payment Success'),
							'error_string'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Error String'),
							'press_go_back_button'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Press back button to go back to the previous page'),
							'select_trial_offers_above'=>array('input_type'=>'textarea','screenshoot_url'=>'','text'=>'Oops! First you must select one of the Trial Offers above'),//start_trial //-- 
							'account_holder_name'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Account Holder Name'),
							'select_bank'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Select Bank'),
							'enter_account_name'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Enter Your Account Name'),
							'select_bank_name'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Select Bank Name'),
					);
					
		$staticTextArr['Contact Us Page'] = array(
									/* Contact Us */
									'contact_us'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Contact Us'), //--
									'find_us'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Find Us'), //contact_us //-- 
									'find_location'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Find Location'), //contact_us //-- 
									'choose_state'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Choose State'), //contact_us //-- 
									'hours_of_opreation'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Hours of Operation'), //-- 
									'view_contact_page'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'View Contact Page'),  //issue
									'closed'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Closed'),  //issue
									);
		
		$staticTextArr['Dojocart Page'] = array(
						'select_location'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Select Location'), //-- 
						'payment_info'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Payment Info'),//--
						'quantity'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Quantity'),//--
						'subtotal'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'SubTotal'),//--
						'tax'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Tax'),
						'coupon_discount'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Coupon Discount'), //-- 
						'promo_discount'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Promo Discount'), //--  
						'number_of_attendees'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Number of Attendees'),//--
						'enter_valid_credit_card_number'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Enter your valid credit card number'),//--
						'card_not_accecpted'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'American Express not Accecpted, Please use visa or Master'), //--
						'enter_applicant_signature'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Enter your applicant signature'),//--
						'event_date'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Event Date'), //-
						'event_time'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Event Time'), //-
						'tournament_date'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Tournament Date'), //-
						'tournament_time'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Tournament Time'), //-
						'dob'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'DOB'), //-
						'ata'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'ATA'), //-
						'school'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'School'), //-
						'region'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Region'), //-
						'city'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'City'), //-
						'instructor'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Instructor'), //-
						'school_phone'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'School Phone'), //-
						
						'additional_info'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Additional Info'), //-
						'do_you_have_promo_code'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Do you have a promo code'),//--
						'accept_term_and_condition'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Please accept term & condtion to submit the data'), //--
						'you_have_appiled_promo_code'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Success! You have applied promo code'), //--
						'to_receive'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'to receive'),//--
						'off'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'off'),//--
						//'quantity'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Quantity'),
						'invalid_promo_code'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Invalid Promo Code'),//done
						'expired_promo_code'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Expired Promo Code'),//done
						'updated_cart_promo_code_error'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Cart was updated, please apply coupon again.'),//done
						'coupon_not_applicable'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Coupon Not Applicable'),//done
						'thank_for_submission'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Thank you for your submission'),//done
						'check_email_for_additional_info'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Please check your email for additional info'),//done
						'security_code'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Security Code'),//done
						
					);
		
		//all done
		$staticTextArr['Career ThankYou Page'] = array(
						/* carrer_thankyou_page */
						'thankyou'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Thank You!'), //--
						'your_message_sent'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Your message was sent!'), //done //carrer_thankyou_page
						'back_to_homepage'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Back to Homepage'), //--
						'email_sending_failed'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Email sending Failed. Please try again.'), //--
						'go_back'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Go Back.'), //--
					);
		
		//all done
		$staticTextArr['Page Not Found'] = array(
						/* Page Not Found */
						'page_not_found'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Page Not Found'), //--
						'we_are_sorry_page_not_found'=>array('input_type'=>'textarea','screenshoot_url'=>'','text'=>"We're sorry, the page you requested could not be found."), //--
					);
					
		$staticTextArr['Student Section'] = array(
								//student section
								'instructor_area' =>array('input_type'=>'text','screenshoot_url'=>'','text'=> 'Instructor Area'), //--
								'downloads' =>array('input_type'=>'text','screenshoot_url'=>'','text'=> 'Downloads'), //--
								'view_all' =>array('input_type'=>'text','screenshoot_url'=>'','text'=> 'View All'), //--
								'download' =>array('input_type'=>'text','screenshoot_url'=>'','text'=> 'Download'), //--
								'student_section' =>array('input_type'=>'text','screenshoot_url'=>'','text'=> 'Student Section'), //--
								'free_trial_class' =>array('input_type'=>'text','screenshoot_url'=>'','text'=> 'Free Trial Class'), //--
								
								'video_gallery' =>array('input_type'=>'text','screenshoot_url'=>'','text'=> 'Video Gallery'), //--
								'back_to_video_gallery' =>array('input_type'=>'text','screenshoot_url'=>'','text'=> 'Back to video Gallery'),  //--
								'sub_categories' =>array('input_type'=>'text','screenshoot_url'=>'','text'=> 'Sub Categories'),//--
								'videos' =>array('input_type'=>'text','screenshoot_url'=>'','text'=> 'Videos'),//--
								'video' =>array('input_type'=>'text','screenshoot_url'=>'','text'=> 'Video'),//--
								'videos_of' =>array('input_type'=>'text','screenshoot_url'=>'','text'=> 'Videos of'),//--
								'view_album' =>array('input_type'=>'text','screenshoot_url'=>'','text'=> 'View Album'),//--
								'expires' =>array('input_type'=>'text','screenshoot_url'=>'','text'=> 'Expires'),//--
								'older_news' =>array('input_type'=>'text','screenshoot_url'=>'','text'=> 'Older News'),//--
								'newer_news' =>array('input_type'=>'text','screenshoot_url'=>'','text'=> 'Newer News'),//--
							);
		// all done					
		$staticTextArr['Blogs and Blog Detail Page'] = array(
						/* Blog and blog detail Page **/
						'blog'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Blog'), //blog_detail //--
						'posted'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Posted'), //blog_detail //-- 
						'recent_posts'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Recent Posts'), //blog_detail //--
						'archive'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Archive'), //blog_detail //--
						'older_post'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Older Post'), //blog_detail //--
						'newer_post'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Newer Post'), //blog_detail //--
						'continue_reading'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Continue Reading'), //blog //--
						'recent_uploads'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Recent Uploads'), //news //--
						'upcoming_events'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Upcoming Events'), //news //--
						'hover_events_for_more_info'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Note: hover events for more information'), //news //--
						
					);
					
		$staticTextArr['Contact and Mini Trial Forms'] = array(
						/* contact us forms  and mini trial offer forms **/
						'enter_your_first_name'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Enter Your First Name & Last Name'),//--
						'enter_your_last_name'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Enter your last name'), //--
						'enter_valid_phone_number'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Enter a valid phone number'),//-- 
						'enter_valid_email_address'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Enter a valid email address'),//-- 
						'enter_your_message'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Enter your message'), //-- 
						'receiving_information'=>array('input_type'=>'textarea','screenshoot_url'=>'','text'=>'Please click box to agree to receiving information'), //--
						'first_name'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Full Name'),//-- 
						'your_full_name'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Your Full Name'),//-- 
						'last_name'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Last Name'),//-- 
						'phone'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Phone'),//--
						'email'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Email'),//-- 
						'enter_your_email_address'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Enter your email address'),//-- 
						'choose_a_location'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Choose a Location'),//--
						'choose_a_program'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Choose a Program'),//--
						'message'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Message'),//--
						'child_name'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>"Child's Name"),//-- 
						'enter_child_name'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>"Enter Your Child's Name"),//-- 
						'child_age'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>"Child's Age"),//-- 
					);		
			
		// all done
		$staticTextArr['Birthday Party and Summer Camp Form']= array(
							//birthday party form
							'enter_your_party_time'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Enter your party date and time'), //--
							'select_guest_numbers'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Select your number of guests'),//--
							'schedule_a_bdy_party'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Schedule a Birthday Party'),//--
							'call_me_with_more_info'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Call me with more information'),//--
							'reserve_spot_for_your_child'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Reserve a spot for your child'),//--
							'schedule_phone_consultation'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Schedule a phone consultation'),//--
							'guests'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Guests'),//--
							//'schedule_my_party'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Schedule my party'),//--
							'date_and_time'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Date & Time'),//--
					);

		$staticTextArr['Free and Paid Trial Offer Forms'] = array(
						/* Free and Paid Trial Offer Forms */
						'contact_information'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Contact Information'),//--
						'payment_information'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Payment Information'),//--
						'purchase_now'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'PURCHASE NOW'), //start_trial //--
						'get_started'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'GET STARTED'),//start_trial  //-- 
						'select_your_program'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Select your program'),//start_trial //--
						'select_your_location'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Select your location'),//start_trial //--
						'enter_your_card_name'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Enter your card name'),//start_trial //--
						'enter_your_card_number'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Enter your credit card number'),//start_trial //--
						'enter_your_cvv'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Enter your cvv'),//start_trial //--
						'cvv'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'CVV'),//start_trial //--
						'select_exp_month'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Select Exp month'),//start_trial  //--
						'select_exp_year'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Select Exp year'),//start_trial //--
						'check_terms_conditions'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Check Terms & Conditions'),//start_trial  //--
						//'agree_receving_information'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Please click box to agree to receiving information'),//start_trial
						'invalid_credit_card_detail'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'You entered an invalid credit card detail'),//start_trial //--
						'processing_please_wait'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Processing... Please wait'),//start_trial //--
						'choose_program'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Choose Program'),//start_trial //--
						'choose_location'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Choose Location'),//start_trial //--
						'name_on_card'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Name on card'),//start_trial //--
						'credit_card_number'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Credit Card Number'),//start_trial //--
						'exp_month'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Expiration Month'),//start_trial //--
						'exp_year'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Expiration Year'),//start_trial //--
						'apply_coupon'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Apply Coupon'),//start_trial //--
						'trial_offer'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Trial Offer'),//start_trial //--
						'discount'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Discount'),//start_trial //done
						'total'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Total'),//start_trial //done
					);

		//all done
		$staticTextArr['Career Opportunities Form'] = array(
						/*career opportunities form */
						'enter_your_name'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Enter your name'),//done
						'enter_your_address'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Enter your Address'),//done
						'enter_your_city'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Enter your city'),//done
						'select_state'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Select state'),//done
						'enter_your_zip'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Enter your zip'),//done
						//'enter_valid_email_address'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Enter a valid email address'),
						'enter_your_birthday'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Enter your birthdate'),//done
						'enter_your_age'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Enter your age'),//done
						'enter_your_esignature'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Enter your E-Signature'),//done
						'personal_info'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Personal Info'), //done
						'required'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Required'),
						'your_name'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Your Name'),//done
						'your_address'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Your Address'),//done
						'city'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'City'),
						'your'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Your'),
						'zip_code'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Zip Code'),
						'best_way_to_contact_you'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Best way to contact you'),
						'home_phone'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Home Phone'), //done
						'cell_phone'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Cell Phone'), //done
						//'email'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'E-mail'),
						'home_phone_number'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Home Phone Number '),
						'cell_phone_number'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Cell Phone Number'),
						'birthdate'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Birthdate'),
						'age'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Age'),
						'gender'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Gender'),
						'male'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Male'),
						'female'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Female'),
						'positin_applying_for'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Position(s) Applying For'),
						'specify_hours_part_time'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Specify Hours if Part Time'),
						'specify_start_date'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Specify Start Date'),
						'highest_level_of_school'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Highest Level of School'),
						'graduted_high_school'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Graduated High School'),
						'currently_in_high_school'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Currently In High School'),
						'enrolled_in_College'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Enrolled in College'),
						'some_college'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Some College'),
						'graduated_college'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Graduated College'),
						'associates_degree'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Associates Degree'),
						'bachelors_degree'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Bachelors Degree'),
						'masters_degree'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Masters Degree'),
						'type_degree_earned'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Type of Degree Earned'),
						'name_of_school_last_attended'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Name of School Last Attended'),
						'special_skills_or_qualifications'=>array('input_type'=>'textarea','screenshoot_url'=>'','text'=>'What special skills or qualifications do you feel would enhance your ability to work with us?'),
						'previous_training_coaching'=>array('input_type'=>'textarea','screenshoot_url'=>'','text'=>'Please list your previous Training/Coaching experiences including where this was received'),
						'present_employer'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Present Employer'),
						'supervisor_name'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>"Supervisor's Name"),
						'supervisor_contact_number'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>"Supervisor's Contact Number"),
						'contact_reference'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'May we contact them as a reference?'),
						'yes'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Yes'),
						'no'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'No'),
						'work_address'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Work Address'),
						'duties_performed'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Duties Performed'),
						'start_date'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Start Date'),
						'end_date'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'End Date'),
						'starting_salary'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Starting Salary'),
						'ending_salary'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Ending  Salary'),
						'reason_for_leaving'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Reason for Leaving'),
						'previous_employer'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Previous Employer'),
						'referral_info'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Referral Info'),
						'referral_name'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Referral Name'),
						'contact_number'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Contact Number'),
						'number_of_years_known'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Number of Years Known'),
						'relationship'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'Relationship'),
						'esignature'=>array('input_type'=>'text','screenshoot_url'=>'','text'=>'E-Signature')
					);
	
		
	//echo '<pre>staticTextArr'; print_r($staticTextArr); die;				
	?>
	
	
<div class="form-light-holder ">
	<div class="adsUrl">
		<label class="rdiobox">
		<input type="radio" class="language" name="language" value="english" <?php echo ((isset($singleRecord[0])  && $singleRecord[0]->type == "english") || !isset($singleRecord[0])) ? 'checked=checked' : ''; ?>><span> English</span></label>
		
	</div>
	<div class="linkTarget">
		<label class="rdiobox" style="display:inline-block !important"><input type="radio" class="language" name="language" value="other_language"  <?php echo (isset($singleRecord[0])  && $singleRecord[0]->type == "other_language") ? 'checked=checked' : ''; ?>><span> <?php echo (isset($singleRecord[0])  && !empty($singleRecord[0]->other_language_name)) ? $singleRecord[0]->other_language_name : ' Other Language'; ?></span>
		</label>
		<div class="otherLanguageName"  style="display:none; margin-left:53%">
			<input type="text" value="<?php echo (isset($singleRecord[0])  && !empty($singleRecord[0]->other_language_name)) ? ucfirst($singleRecord[0]->other_language_name) : ''; ?>" name="other_language_name" id="" class="field" placeholder="Language Name">
		</div>
		
		
		
	</div>
</div>

<div class="form-light-holder">
<?php 
	foreach($staticTextArr as $page_name => $static_text){
		
		$pageSectionIds = array(
								'Common Texts'=>'Common',
								'Program Category and Program Detail Page' => 'ProgramPage',
								'Trial Offer and Free Paid trial offer Page' => 'TrialPage',
								'Contact Us Page' => 'ContactPage',
								'Dojocart Page' => 'DojocartPage',
								'Career ThankYou Page' => 'ThankyouPage',
								 'Page Not Found' => 'PageNotFound',
								'Student Section' => 'StudentSection',
								'Blogs and Blog Detail Page' => 'BlogPage',
								'Contact and Mini Trial Forms' => 'MiniTrialForm',
								'Birthday Party and Summer Camp Form' => 'BdyForm',
								'Free and Paid Trial Offer Forms' => 'FreePaidTrialForm',
								 'Career Opportunities Form' => 'CarrerForm',
								);
?>
	<div class="page-section" id="<?php echo isset($pageSectionIds[$page_name]) ? $pageSectionIds[$page_name] : ''; ?>">
		<div class="mb-3 main-content-label"><?php echo isset($pageSectionIds[$page_name]) ? $page_name : ''; ?></div>
	
	<?php foreach($static_text as $key => $text_data){ ?>
	<div class="adsUrl">
		<!--<h1>English</h1> -->
		<!--<input type="radio" name="translation[<?php echo $key ?>][type]" value="english" <?php echo ((isset($records[$key])  && $records[$key]['type'] == "english") || !isset($records[$key])) ? 'checked=checked' : ''; ?>> -->
		
		<?php if($text_data['input_type'] == "textarea"){ ?>
			<textarea class="field" placeholder="English Text" name="translation[<?php echo $key ?>][english]"><?php echo (isset($records[$key])) ? $records[$key]['english_text'] : $text_data['text']; ?></textarea>
		<?php }else{ ?> 
			<input type="text" value="<?php echo (isset($records[$key])) ? $records[$key]['english_text'] : $text_data['text']; ?>" name="translation[<?php echo $key ?>][english]" id="" class="field" placeholder="English Text">	
		<?php } ?>
		
	</div>
	<div class="linkTarget">
		<!-- <h1>Translate</h1> -->
		<!--<input type="radio" name="translation[<?php echo $key ?>][type]" value="translate"  <?php echo (isset($records[$key])  && $records[$key]['type'] == "translate") ? 'checked=checked' : ''; ?>> -->
		
		<?php if($text_data['input_type'] == "textarea"){ ?>
			<textarea class="field" placeholder="Translate" name="translation[<?php echo $key ?>][translate]"><?php echo (isset($records[$key])) ? $records[$key]['translate'] : ''; ?></textarea>
		<?php }else{ ?> 
			<input type="text" value="<?php echo (isset($records[$key])) ? $records[$key]['translate'] : ''; ?>" name="translation[<?php echo $key ?>][translate]" id="" class="field contactHalfDivInput" placeholder="Translate">	
		<?php } ?>
		
	</div>
	

	<?php } ?> 
		</div>
	<?php  } ?>
</div>
		
		<div>




		</div>
		</div>
		

		</div>
	</div>
	</div>
	
	</div>
	</div>
	</div>





	<div class="tx-center pd-y-20 bg-gray-200" id="bottom"> 
				
				
				<input type="submit"  name="update" value="Save" class="save_program_form btn btn-az-primary saveProgramButton" />
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

<br style="clear:both"		 />

<script type="text/javascript">
/*window.onload = function () {
    var loadTime = window.performance.timing.domContentLoadedEventEnd-window.performance.timing.navigationStart; 
   
   setTimeout(function(){ 
	 $('#sidebar').stickySidebar({
		topSpacing: 0,
		bottomSpacing: 60,
	  });
		
  }, loadTime);
  
  <?php if(isset($singleRecord[0]) && !empty($singleRecord[0]->scroll_top)){ ?>
  $('body,html').animate({scrollTop: "<?php echo $singleRecord[0]->scroll_top ?>"}, loadTime);
  <?php } ?>
  
}*/

</script>



<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js" type="text/javascript"></script>
<script src="color_overlay_opacity_pickier/js/spectrum.js" type="text/javascript"></script>
	<script src="color_overlay_opacity_pickier/js/toc.js" type="text/javascript"></script>
	<script src="color_overlay_opacity_pickier/js/docs.js" type="text/javascript"></script>
	<script src="color_overlay_opacity_pickier/js/prettify.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="color_overlay_opacity_pickier/css/spectrum.css">
	

<!------------ recent items ----------------->



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
	

</script>




