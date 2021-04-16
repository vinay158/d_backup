<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<?php $this->load->view('includes/header'); ?>

<?php  $this->load->view('includes/header/masthead'); ?>


<script>
	$(document).ready(function(){
		$('.trial_offer_checkbox').click(function(){
				
				var offer_id = $(this).attr('number');
				
				if($(this).is(':checked')){
					
					$('.selectedTrial'+offer_id).html('Selected');
				
				}else {
					
					$('.selectedTrial'+offer_id).html('Select');
				
				}

		});
	});
</script>

<div id="trial-quote">
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-push-2 col-xs-12  text-center ">
        <h2><?= $this->query_model->getStrReplace($site_settings->mini_form_offer_title); ?></h2>
      </div>
      <div class="clearfix"></div>
      <div class="desc text-center">
        <p><?= $this->query_model->getDescReplace($site_settings->mini_form_offer_desc); ?></p>
      </div>
    </div>
  </div>
</div>
<div class="logo-main logo-set-trial"> <img src="<?php echo base_url(); ?><?= $site_settings->sitelogo; ?>" alt="<?= $this->query_model->getStrReplace($site_settings->logo_alt); ?>"> </div>
<div class="spacer"></div>
<div class="clearfix"></div>
<section id="pricing">
  <div class="container">
    <div class="row">
      <div class="box-title">
        <label>step 1:  choose your trial </label>
      </div>
      <div class="col-md-10 col-md-push-1">
        <div class="row">
		 <?php echo $trials_value; ?>
         <!-- <div class="col-md-6 col-xs-12 col-sm-6">
            <div class="price-detail text-center">
              <div class="header r-bg">
              <h3>Free Trial class</h3>
              <p>Web Only Offer! Web Only Offer! Web Only Off</p>
              </div>
              <div class="price">
                <h2>Free</h2>
              </div>
              <ul class="feature-list">
                <li>Feature 1 Goes Here</li>
                <li>Processus dynamicus qui sequitur</li>
                <li>Feature 1 Goes Here
                <li>Processus dynamicus qui sequitur</li>
              </ul>
                <div class="buttons-container">
                  <a class="btn-animate" href="javascript:void(0);">
                    <span class="btn-text"><input type="checkbox" name="" /> Select</span> 
                     <span class="btn-slide-text">Fill out your info below to <br>redeem this Web Special Offer!</span>
                  </a>
                </div>
            </div>
          </div>
           <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="price-detail text-center">
              <div class="header b-bg">
              <h3>2 weeks of classes</h3>
              <p class="sky-txt" >Web Only Offer!</p>
              </div>
              <div class="price">
                <h2>$69</h2>
              </div>
              <ul class="feature-list">
                <li>Feature 1 Goes Here</li>
                <li>Processus dynamicus qui sequitur</li>
                <li>Feature 1 Goes Here
                <li>Processus dynamicus qui sequitur</li>
              </ul>
               <div class="buttons-container">
                  <a class="btn-animate blue" href="#">
                    <span class="btn-text"><i class="fa fa-check-square-o"></i> Select</span> 
                    <span class="btn-slide-text">Fill out your info below to <br>redeem this Web Special Offer!</span>
                  </a>
                </div>
            </div>
          </div>-->
        </div>
      </div>
    </div>
  </div>
</section>
<div class="spacer"></div>
<div class="trial-form dark-form">
  <div class="container">
    <div class="row">
        <div class="box-title">
        <label>Step 2: Fill in Your Info</label>
      </div>
      <div class="col-xs-12 col-md-10 col-md-push-1">
        <form action="starttrial/buyspecial" method="post">
          <div class="inline_mid_form ">
            <input type="text" name="first_name" class="contact-form-line" placeholder="First Name" onFocus="this.placeholder = ''" onBlur="this.placeholder = 'First Name'" required="required">
            <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
          <div class="inline_mid_form ">
            <input type="text" name="last_name" class="contact-form-line" placeholder="Last Name" onFocus="this.placeholder = ''" onBlur="this.placeholder = 'Last Name'" required="required">
            <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
          <div class="inline_mid_form ">
            <input type="text" name="email" class="contact-form-line" placeholder="Email" onFocus="this.placeholder = ''" onBlur="this.placeholder = 'Email'" required="required">
            <span class="fa fa-envelope form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
          <div class="inline_mid_form ">
            <input type="text" name="phone" class="contact-form-line" placeholder="Phone" onFocus="this.placeholder = ''" onBlur="this.placeholder = 'Phone'" required="required">
            <span class="fa fa-phone form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
          <div class="inline_mid_form ">
            <select class=" contact-form-line" id="location" required="required">
              <option>Choose Location</option>
              <option>Choose Location 1</option>
              <option>Choose Location 2</option>
              <option>Choose Location 3</option>
            </select>
            <span class="fa fa-map-marker form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> </div>
          <div class="started-btn trial-btn">
            <input type="submit" class="" value="GET STARTED">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="spacer50"></div>
<!-- news section -->
<section id="achievement">
  <div class="container">
    <div class="row">
      <div class="col-md-10 col-md-push-1 col-xs-12">
        <div class="achievement-box text-center row"> 
        <p class="one">A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart. I am alone, and feel the charm of existence in this spot, which was created for the bliss of souls like mine. I am so happy. My entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
        <div class="achieve-slogan">
          <p class="sky-txt"><i>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart. </i></p>  
        </div>
        </div>
        <div class="arrow-b"></div>
        <div class="result">
          <h2>Achieve amazing results in just 2 weeks</h2>
        </div>
      </div>
    </div>
  </div>
</section>

<?php $this->load->view('includes/footer'); ?> 

