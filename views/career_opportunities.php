<?php $this->load->view('includes/header'); ?>

<?php $this->load->view('includes/header/masthead'); ?>
<style>
.reds{top:55px !important}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
 
  $(document).ready(function(){
    
    $('#submitCarrerForm').click(function(){  
      var err = 0;
	  
		   var name=$('#name').val();
			if(name.length == 0){ 
            $('#name').after('<div class="reds name_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_name'); ?></div>');
			err = 1;
          }

     

		 var address=$('#address').val();
			if(address.length == 0){
            $('#address').after('<div class="reds address_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_name'); ?></div>');
            err = 1;
          }

      var city=$('#city').val();
		if(city.length == 0){
            $('#city').after('<div class="reds city_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_city'); ?></div>');
            err = 1;
          }
 
       var state=$('#state').val();
		if(state == '' || state == null){
            $('#state').after('<div class="reds state_error"><?php echo $this->query_model->getStaticTextTranslation('select_state'); ?></div>');
            err = 1;
          }

      var zip=$('#zip').val();
		if(zip.length == 0){
            $('#zip').after('<div class="reds zip_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_zip'); ?></div>');
            err = 1;
          } 
		  
      var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
          var email=$('#email').val();
          if(email.length == 0 || emailfilter.test($("#email").val()) == false){
            $('#email').after('<div class="reds email_error"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
           err = 1;
          }
          
		var birthdate=$('#birthdate').val();
		if(birthdate.length == 0){
            $('#birthdate').after('<div class="reds birthdate_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_birthday'); ?></div>');
            err = 1;
          } 
		  
		var age=$('#age').val();
		if(age.length == 0){
            $('#age').after('<div class="reds age_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_age'); ?></div>');
            err = 1;
          } 
		  
	var email_signature=$('#email_signature').val();

          if(email_signature.length == 0){
            $('#email_signature').after('<div class="reds email_signature_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_esignature'); ?></div>');
            err = 1;
          }
      
     
      
	  if(err == 0){
			return true;
		} else{
			return false;
		}

         
      
    });
    
    $('#telephone').keyup(function(){
         
		   $('.phone_error').hide();
      });
	 
      
      $('#name').keyup(function(){
          if($(this).val().length > 0){
            $('.name_error').hide();
          } else{
            $('#name').after('<div class="reds name_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_name'); ?></div>');
            
          }
      });
	  
	   $('#address').keyup(function(){
          if($(this).val().length > 0){
            $('.address_error').hide();
          } else{
            $('#address').after('<div class="reds address_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_name'); ?></div>');
            
          }
      });
	  
	  
	   $('#city').keyup(function(){
          if($(this).val().length > 0){
            $('.city_error').hide();
          } else{
            $('#city').after('<div class="reds city_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_city'); ?></div>');
            
          }
      });
	  
	   $('#state').change(function(){
          if($(this).val() != ''){
            $('.state_error').hide();
          } else{
            $('.state_error').show();
            //$('#state').after('<div class="reds state_error">Select your state</div>');
            
          }
      });
	  
	  $('#zip').keyup(function(){
          if($(this).val().length > 0){
            $('.zip_error').hide();
          } else{
            $('#zip').after('<div class="reds zip_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_zip'); ?></div>');
            
          }
      }); 
	  
	   $('#email').keyup(function(){
          var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
          var email=$('#email').val();
          if($(this).val().length > 0){
            $('.email_error').hide();
          } else{
            $('#email').after('<div class="reds email_error"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
            
          }
      });

     
      
      $('#birthdate').keyup(function(){
          if($(this).val().length > 0){
            $('.birthdate_error').hide();
          } else{
            $('#birthdate').after('<div class="reds birthdate_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_birthday'); ?></div>');
            
          }
      });
	  
	   $('#age').keyup(function(){
          if($(this).val().length > 0){
            $('.age_error').hide();
          } else{
            $('#age').after('<div class="reds age_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_age'); ?></div>');
            
          }
      });
      
      $('#email_signature').keyup(function(){
          if($(this).val().length > 0){
            $('.email_signature_error').hide();
          } else{
            $('#email_signature').after('<div class="reds email_signature_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_esignature'); ?></div>');
            
          }
      });
      
      
     
      
   
    
  });
</script>


<!-- payment here -->
<section id="payment-block" class="career_opportunities_page">
  <div class="container paymentBlockPart">
    <div class="row">
      <!--<div class="col-md-5 col-xs-12 col-sm-6 col-md-push-7 hidden-xs">
        <div class="policy cart-policy">
	   
	   </div>
      </div> -->

    <div class="col-md-12 ">
          
		   
		
		<div class="contact-form-payment">
		 <h3><?php $this->query_model->getDescReplace(ucwords($detail[0]->title));  ?></h3>
		
		<p><?php $this->query_model->getDescReplace($detail[0]->description);  ?></p>
        <hr>
		
		<form class="row" method="post" id="paymentForm" action="<?php echo base_url().'carrer/save_carrer_form'; ?>">
		
		
		<div class="col-md-12 col-sm-12"><h3><?php echo $this->query_model->getStaticTextTranslation('personal_info'); ?></h3></div>
        <div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('your_name'); ?> (<?php echo $this->query_model->getStaticTextTranslation('required'); ?>)</b></label>
			  <input type="text" class="form-control" name="name" value="" id="name" placeholder="<?php echo $this->query_model->getStaticTextTranslation('your_name'); ?>">
			</div>
		</div>  
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('your_address'); ?> (<?php echo $this->query_model->getStaticTextTranslation('required'); ?>)</b></label>
			  <input type="text" class="form-control" name="address" value="" id="address" placeholder="<?php echo $this->query_model->getStaticTextTranslation('your_address'); ?>" >
			</div>
		</div> 

		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('city'); ?> (<?php echo $this->query_model->getStaticTextTranslation('required'); ?>)</b></label>
			  <input type="text" class="form-control" name="city" value="" id="city" placeholder="<?php echo $this->query_model->getStaticTextTranslation('your'); ?> <?php echo $this->query_model->getStaticTextTranslation('city'); ?>" >
			</div>
		</div>

		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('state'); ?>  (<?php echo $this->query_model->getStaticTextTranslation('required'); ?>)</b></label>
			  <input type="text" class="form-control" name="state" value="" id="state" placeholder="<?php echo $this->query_model->getStaticTextTranslation('your'); ?> <?php echo $this->query_model->getStaticTextTranslation('state'); ?>" >
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('zip_code'); ?>  (<?php echo $this->query_model->getStaticTextTranslation('required'); ?>)</b></label>
			  <input type="text" class="form-control" name="zip" value="" id="zip" placeholder="<?php echo $this->query_model->getStaticTextTranslation('your'); ?><?php echo $this->query_model->getStaticTextTranslation('zip_code'); ?>" >
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('best_way_to_contact_you'); ?></b></label>
			  <select name="contact_way" class="form-control">
				  <option value="<?php echo $this->query_model->getStaticTextTranslation('home_phone'); ?>"><?php echo $this->query_model->getStaticTextTranslation('home_phone'); ?></option>
				  <option value="<?php echo $this->query_model->getStaticTextTranslation('cell_phone'); ?>"><?php echo $this->query_model->getStaticTextTranslation('cell_phone'); ?></option>
				  <option value="<?php echo $this->query_model->getStaticTextTranslation('email'); ?>"><?php echo $this->query_model->getStaticTextTranslation('email'); ?></option>
			  </select>
			</div>
		</div>

		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('home_phone_number'); ?> (<?php echo $this->query_model->getStaticTextTranslation('required'); ?>)</b></label>
			  <input type="text" class="form-control" name="home_phone_number" value="" id="home_phone_number" placeholder="<?php echo $this->query_model->getStaticTextTranslation('your'); ?> <?php echo $this->query_model->getStaticTextTranslation('home_phone_number'); ?>" >
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('cell_phone_number'); ?> </b></label>
			  <input type="text" class="form-control" name="cell_phone_number" value="" id="" placeholder="<?php echo $this->query_model->getStaticTextTranslation('your'); ?> <?php echo $this->query_model->getStaticTextTranslation('cell_phone_number'); ?>"  >
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('email'); ?> (<?php echo $this->query_model->getStaticTextTranslation('required'); ?>)</b></label>
			  <input type="text" class="form-control" name="email" value="" id="email" placeholder="<?php echo $this->query_model->getStaticTextTranslation('your'); ?> <?php echo $this->query_model->getStaticTextTranslation('email'); ?> " >
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('birthdate'); ?> (<?php echo $this->query_model->getStaticTextTranslation('required'); ?>)</b></label>
			  <input type="text" class="form-control" name="birthdate" value="" id="birthdate" placeholder="<?php echo $this->query_model->getStaticTextTranslation('your'); ?> <?php echo $this->query_model->getStaticTextTranslation('birthdate'); ?> " >
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('age'); ?> (<?php echo $this->query_model->getStaticTextTranslation('required'); ?>)</b></label>
			  <input type="text" class="form-control" name="age" value="" id="age" placeholder="<?php echo $this->query_model->getStaticTextTranslation('your'); ?> <?php echo $this->query_model->getStaticTextTranslation('age'); ?> ">
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('gender'); ?> (<?php echo $this->query_model->getStaticTextTranslation('required'); ?>) </b></label>
			 <select name="gender" class="form-control" id="gender">
				<option value="<?php echo $this->query_model->getStaticTextTranslation('male'); ?>"><?php echo $this->query_model->getStaticTextTranslation('male'); ?></option>
				<option value="<?php echo $this->query_model->getStaticTextTranslation('female'); ?>"><?php echo $this->query_model->getStaticTextTranslation('female'); ?></option>
			</select>
			</div>
		</div>
		

		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('positin_applying_for'); ?> </b></label>
			  <input type="text" class="form-control" name="position" value="" id="" placeholder="<?php echo $this->query_model->getStaticTextTranslation('positin_applying_for'); ?>  ">
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('specify_hours_part_time'); ?> </b></label>
			  <input type="text" class="form-control" name="specify_hours" value="" id="" placeholder="<?php echo $this->query_model->getStaticTextTranslation('specify_hours_part_time'); ?>  ">
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('specify_start_date'); ?> </b></label>
			  <input type="text" class="form-control" name="spacify_start_date" value="" id="" placeholder="<?php echo $this->query_model->getStaticTextTranslation('specify_start_date'); ?> ">
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('highest_level_of_school'); ?> </b></label>
				<select name="school_level" class="form-control">
					<option value="<?php echo $this->query_model->getStaticTextTranslation('graduted_high_school'); ?>"><?php echo $this->query_model->getStaticTextTranslation('graduted_high_school'); ?></option>
					<option value="<?php echo $this->query_model->getStaticTextTranslation('currently_in_high_school'); ?>"><?php echo $this->query_model->getStaticTextTranslation('currently_in_high_school'); ?></option>
					<option value="<?php echo $this->query_model->getStaticTextTranslation('enrolled_in_College'); ?>"><?php echo $this->query_model->getStaticTextTranslation('enrolled_in_College'); ?></option>
					<option value="<?php echo $this->query_model->getStaticTextTranslation('some_college'); ?>"><?php echo $this->query_model->getStaticTextTranslation('some_college'); ?></option>
					<option value="<?php echo $this->query_model->getStaticTextTranslation('graduated_college'); ?>"><?php echo $this->query_model->getStaticTextTranslation('graduated_college'); ?></option>
					<option value="<?php echo $this->query_model->getStaticTextTranslation('associates_degree'); ?>"><?php echo $this->query_model->getStaticTextTranslation('associates_degree'); ?></option>
					<option value="<?php echo $this->query_model->getStaticTextTranslation('bachelors_degree'); ?>"><?php echo $this->query_model->getStaticTextTranslation('bachelors_degree'); ?></option>
					<option value="<?php echo $this->query_model->getStaticTextTranslation('masters_degree'); ?>"><?php echo $this->query_model->getStaticTextTranslation('masters_degree'); ?></option>
				</select>
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('type_degree_earned'); ?> </b></label>
			  <input type="text" class="form-control" name="degree_earned" value="" id="" placeholder="<?php echo $this->query_model->getStaticTextTranslation('type_degree_earned'); ?> ">
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('name_of_school_last_attended'); ?> </b></label>
			  <input type="text" class="form-control" name="last_attended" value="" id="" placeholder="<?php echo $this->query_model->getStaticTextTranslation('name_of_school_last_attended'); ?> ">
			</div>
		</div>
		
		<div class="col-md-12 col-sm-12">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('special_skills_or_qualifications'); ?> </b></label>
			  <textarea class="form-control" name="special_skills_detail"> </textarea>
			</div>
		</div>
		
		<div class="col-md-12 col-sm-12">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('previous_training_coaching'); ?>  </b></label>
			  <textarea class="form-control" name="previous_training_detail"> </textarea>
			</div>
		</div>
		
		<div class="col-md-12 col-sm-12"><h3><?php echo $this->query_model->getStaticTextTranslation('present_employer'); ?></h3></div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('present_employer'); ?> </b></label>
			  <input type="text" class="form-control" name="present_employer" value="" id="" placeholder="<?php echo $this->query_model->getStaticTextTranslation('present_employer'); ?> ">
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('supervisor_name'); ?> </b></label>
			  <input type="text" class="form-control" name="present_supervisor_name" value="" id="" placeholder="<?php echo $this->query_model->getStaticTextTranslation('supervisor_name'); ?> ">
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('supervisor_contact_number'); ?> </b></label>
			  <input type="text" class="form-control" name="present_supervisor_contact" value="" id="" placeholder="<?php echo $this->query_model->getStaticTextTranslation('supervisor_contact_number'); ?> ">
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('contact_reference'); ?> </b></label>
				<select name="conatct_refernce" class="form-control">
					<option value="<?php echo $this->query_model->getStaticTextTranslation('yes'); ?>"><?php echo $this->query_model->getStaticTextTranslation('yes'); ?></option>
					<option value="<?php echo $this->query_model->getStaticTextTranslation('no'); ?>"><?php echo $this->query_model->getStaticTextTranslation('no'); ?></option>
				</select>
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('work_address'); ?> </b></label>
			  <input type="text" class="form-control" name="present_work_address" value="" id="" placeholder="<?php echo $this->query_model->getStaticTextTranslation('work_address'); ?> ">
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('duties_performed'); ?> </b></label>
			  <input type="text" class="form-control" name="present_duties_preformed" value="" id="" placeholder="<?php echo $this->query_model->getStaticTextTranslation('duties_performed'); ?> ">
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('start_date'); ?> </b></label>
			  <input type="text" class="form-control" name="present_start_date" value="" id="" placeholder="<?php echo $this->query_model->getStaticTextTranslation('start_date'); ?> ">
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('end_date'); ?> </b></label>
			  <input type="text" class="form-control" name="present_end_date" value="" id="" placeholder="<?php echo $this->query_model->getStaticTextTranslation('end_date'); ?> ">
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('starting_salary'); ?> </b></label>
			  <input type="text" class="form-control" name="present_starting_salary" value="" id="" placeholder="<?php echo $this->query_model->getStaticTextTranslation('starting_salary'); ?> ">
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('ending_salary'); ?> </b></label>
			  <input type="text" class="form-control" name="present_ending_salary" value="" id="" placeholder="<?php echo $this->query_model->getStaticTextTranslation('ending_salary'); ?> ">
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('reason_for_leaving'); ?> </b></label>
			  <input type="text" class="form-control" name="present_leaving_reason" value="" id="" placeholder="<?php echo $this->query_model->getStaticTextTranslation('reason_for_leaving'); ?> ">
			</div>
		</div>
		
		<div class="col-md-12 col-sm-12">
			<h3><?php echo $this->query_model->getStaticTextTranslation('previous_employer'); ?> </h3>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('previous_employer'); ?> </b></label>
			  <input type="text" class="form-control" name="previous_employer" value="" id="" placeholder="<?php echo $this->query_model->getStaticTextTranslation('previous_employer'); ?> ">
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('supervisor_name'); ?> </b></label>
			  <input type="text" class="form-control" name="previous_supervisor_name" value="" id="" placeholder="<?php echo $this->query_model->getStaticTextTranslation('supervisor_name'); ?> ">
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('supervisor_contact_number'); ?> </b></label>
			  <input type="text" class="form-control" name="previous_contact_number" value="" id="" placeholder="<?php echo $this->query_model->getStaticTextTranslation('supervisor_contact_number'); ?> ">
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('work_address'); ?> </b></label>
			  <input type="text" class="form-control" name="previous_work_address" value="" id="" placeholder="<?php echo $this->query_model->getStaticTextTranslation('work_address'); ?> ">
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('duties_performed'); ?> </b></label>
			  <input type="text" class="form-control" name="previous_duties_performed" value="" id="" placeholder="<?php echo $this->query_model->getStaticTextTranslation('duties_performed'); ?> ">
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('start_date'); ?> </b></label>
			  <input type="text" class="form-control" name="previous_start_date" value="" id="" placeholder="<?php echo $this->query_model->getStaticTextTranslation('start_date'); ?> ">
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('end_date'); ?> </b></label>
			  <input type="text" class="form-control" name="previous_end_date" value="" id="" placeholder="<?php echo $this->query_model->getStaticTextTranslation('end_date'); ?> ">
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('starting_salary'); ?> </b></label>
			  <input type="text" class="form-control" name="previous_starting_salary" value="" id="" placeholder="<?php echo $this->query_model->getStaticTextTranslation('starting_salary'); ?> ">
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('ending_salary'); ?> </b></label>
			  <input type="text" class="form-control" name="previous_ending_salary" value="" id="" placeholder="<?php echo $this->query_model->getStaticTextTranslation('ending_salary'); ?> ">
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('reason_for_leaving'); ?> </b></label>
			  <input type="text" class="form-control" name="previous_leaving_reason" value="" id="" placeholder="<?php echo $this->query_model->getStaticTextTranslation('reason_for_leaving'); ?> ">
			</div>
		</div>
		
		<div class="col-md-12 col-sm-12">
			<h3><?php echo $this->query_model->getStaticTextTranslation('referral_info'); ?></h3>
		</div>
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('referral_name'); ?> </b></label>
			  <input type="text" class="form-control" name="first_referral_name" value="" id="" placeholder="<?php echo $this->query_model->getStaticTextTranslation('referral_name'); ?> ">
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('contact_number'); ?> </b></label>
			  <input type="text" class="form-control" name="first_referral_contact_number" value="" id="" placeholder="<?php echo $this->query_model->getStaticTextTranslation('contact_number'); ?> ">
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('number_of_years_known'); ?> </b></label>
			  <input type="text" class="form-control" name="first_referral_years_known" value="" id="" placeholder="<?php echo $this->query_model->getStaticTextTranslation('number_of_years_known'); ?> ">
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('relationship'); ?> </b></label>
			  <input type="text" class="form-control" name="first_referral_relationship" value="" id="" placeholder="<?php echo $this->query_model->getStaticTextTranslation('relationship'); ?> ">
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('referral_name'); ?>  </b></label>
			  <input type="text" class="form-control" name="second_referral_name" value="" id="" placeholder="<?php echo $this->query_model->getStaticTextTranslation('referral_name'); ?>  ">
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('contact_number'); ?> </b></label>
			  <input type="text" class="form-control" name="second_referral_contact_number" value="" id="" placeholder="<?php echo $this->query_model->getStaticTextTranslation('contact_number'); ?> ">
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('number_of_years_known'); ?> </b></label>
			  <input type="text" class="form-control" name="second_referral_years_known" value="" id="" placeholder="<?php echo $this->query_model->getStaticTextTranslation('number_of_years_known'); ?> ">
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('relationship'); ?> </b></label>
			  <input type="text" class="form-control" name="second_referral_relationship" value="" id="" placeholder="<?php echo $this->query_model->getStaticTextTranslation('relationship'); ?> ">
			</div>
		</div>
		
		<div class="col-md-12 col-sm-12">
			<div class="form-group">
				<label><?php $this->query_model->getDescReplace($detail[0]->terms_conditions);  ?></label>
			  </div>
		</div>
		
		<div class="col-md-12 col-sm-12">
			<div class="form-group">
				<label><b><?php echo $this->query_model->getStaticTextTranslation('esignature'); ?> (<?php echo $this->query_model->getStaticTextTranslation('required'); ?>) </b></label>
			  <input type="text" class="form-control" name="email_signature" value="" id="email_signature" placeholder="<?php echo $this->query_model->getStaticTextTranslation('esignature'); ?>">
			</div>
		</div>
		
		
		<div class="col-md-12 col-sm-12">
			<div class="form-group">
				<input type="submit" name="submit" value="<?php echo $this->query_model->getStaticTextTranslation('submit'); ?>" class="btn btn-theme" id="submitCarrerForm">
			</div>
		</div>
		
		
		
		
		
		
		
	</div>	
	
	<hr>  
	</div>
     
		  
		  </div>
    </div>
  </div>
</section>




<?php $this->load->view('includes/footer'); ?> 

