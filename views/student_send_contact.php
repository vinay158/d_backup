<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<?php $this->load->view('includes/header'); ?>


<?php  $this->load->view('includes/student_header/masthead'); ?>

<?php $phoneNumberMaxLength = $this->query_model->phoneNumberMaxLength(); 

	  $getPhoneNumberClass = $this->query_model->getPhoneNumberClass(); 
	  
	  	  /*** getting gdpr text **/
 $gdprCompliantText = $this->query_model->getGdprCompliantText();
 $gdpr_compliant_txt1 = (isset($gdprCompliantText['gdpr_compliant_txt1'])) ? $gdprCompliantText['gdpr_compliant_txt1'] : '';
 $gdpr_compliant_txt2 = (isset($gdprCompliantText['gdpr_compliant_txt2'])) ? $gdprCompliantText['gdpr_compliant_txt2'] : '';
 $gdpr_compliant_submit_btn_text = (isset($gdprCompliantText['gdpr_compliant_submit_btn_text'])) ? $gdprCompliantText['gdpr_compliant_submit_btn_text'] : '';
?>

<script>
$(document).ready(function(){
			
		// disble browser go back button 	
		window.history.pushState(null, "", window.location.href);        
        window.onpopstate = function() {
			//setTimeout("window.location.href='<?php echo base_url().'starttrial/distoryTrialSession'; ?>'",500);
            window.history.pushState(null, "", window.location.href);
        };
		
		
});
</script>

<section class="success">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <h2><?php echo $this->query_model->getStaticTextTranslation('success'); ?>!</h2>
        </div>
      </div>
    </div>
  </section>
<section class="section" id="upgrade">
         <div class="container">
            <div class="row">
			<div class="col-md-10 col-md-push-1">
                  <div class="upgrade-block">
			<?php 
				if(!empty($thankyou_message)){
				$this->query_model->getDescReplace($thankyou_message);
				}
			?>
      </div>
      
    </div>
  </div>
  </div>
 </section>
  
<?php $this->load->view('includes/footer'); ?>