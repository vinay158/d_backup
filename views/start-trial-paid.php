<?php $this->load->view('includes/header'); ?>


<body class="inside_page two_column left_sidebar">



<?php $this->load->view('includes/header/masthead'); ?>



<div class="main container clearfix">

	

	<ul class="sidebar vertical two_column clearfix">

	

		<?php  $this->load->view('includes/sidebar/feature_boxes'); ?>

		

	</ul>

	<!-- END .sidebar .vertical -->

	

	<div class="main_content two_column" id="top">

	

	<?php 

	if( isset($online_special_data)){	

	?>

    	<?php

			$pageURL = 'http://';

			if (isset($_SERVER['HTTPS']) && filter_var($_SERVER['HTTPS'], FILTER_VALIDATE_BOOLEAN))

				$pageURL .= 'https://';

				

			 if ($_SERVER["SERVER_PORT"] != "80") {

			  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];

			 } else {

			  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

			 }

		?>

        <div class="fb-recommend-container">

			<div class="fb-like" data-href="<?= $pageURL?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true" data-action="recommend">

			</div>

		</div>

   	 	<?php

				if(!empty($name) && !empty($form_email_2)){	// trough mini form

					

					$special_name = $online_special_data['miniform_special_name_paid'];

					$special_offer = $online_special_data['miniform_special_offer_paid'];

					$special_details = $online_special_data['miniform_special_details_paid'];

					

				}else{	// through direct link

					

					$special_name = $online_special_data['direct_special_name_paid'];

					$special_offer = $online_special_data['direct_special_offer_paid'];

					$special_details = $online_special_data['direct_special_details_paid'];

				}				

			

		?>

			<h1><?=$special_name?></h1>

			<div class="special_offer_offer"><?=$special_offer?></div>

			<span class="page_content"><?=html_entity_decode($special_details);?></span>

			

	<?php

	}

	?>	

    

		

	<script language="javascript">

		function numbersonly(evnt)

		{

			var unicode=evnt.charCode? evnt.charCode : evnt.keyCode

			if (unicode<=46||unicode>57 || unicode==47){	

				if(unicode == 8 || unicode == 9)

					return true;

				else

					return false;

			}	

		}

				

		$(document).ready(function(){

		

			var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;

			var cl = '';

			

			$(".content_trial_form").submit(function(){

				var err = 0;

		

				if($("#form_name_2").val().length == 0){

					err = 1;

					cl = $("#form_name_2").attr("id");

					$("."+cl).css("color", "red");

				}

				

				<?php

					

					if($online_special_data['international_phone'] == 'on'){

				?>

						if($("#form_phone_2").val().length == 0){

							err = 1;

							cl = $("#form_phone_2").attr("id");

							$("."+cl).css("color", "red");

						}

				<?php

					}else{

				?>

						if($(".phone_1").val().length == 0 || $(".phone_2").val().length == 0 || $(".phone_3").val().length == 0){

							err = 1;

							cl = $("#form_phone_2").attr("id");

							$("."+cl).css("color", "red");

						}

				<?php		

					}

				?>

					

		

				if($("#form_email_2").val().length == 0 || emailfilter.test($("#form_email_2").val()) == false){

					err = 1;

					cl = $("#form_email_2").attr("id");

					$("."+cl).css("color", "red");

				}

				

				if($("#form_message_2").val().length == 0 ){

					err = 1;

					cl = $("#form_message_2").attr("id");

					$("."+cl).css("color", "red");

				}		

		

				/*if($("#form_school_interest").val() == 0 ){

					err = 1;

					cl = $("#form_school_interest").attr("id");

					$("."+cl).css("color", "red");					

				}*/

				

		

				if( err != 0 ){

					$(".message #alert").html("<b>Please fill in the contact form correctly.</b>");

					$(".message").fadeIn(300);

					return false;

					

					event.preventDefault();

				}

			});

		});

		</script>

		

		<form action="starttrial/buyspecial" class="trial_form content_trial_form" method="post">

					

			<div class="message">

				<div id="alert"></div>

			</div>

			<!-- END .message -->

			

			<ul class="form_fields">

			

				<li class="clearfix">

					<label class="form_name_2">Student Name</label>

					<input type="text" name="name" id="form_name_2" value="<?=$name?>"  />

				</li>

				

				<li class="clearfix">

					<label class="form_phone_2">Phone</label>

                    

                    <?php

					

						if($online_special_data['international_phone'] == 'on'){

					?>

                    		<input type="text" name="phone" value="<?=$phone?>" class="phone" id="form_phone_2"  onkeypress="return numbersonly(event)" />

                    <?php		

						}else{

					?>

                            <input type="text" name="phone1" maxlength="3" value="<?=$phone1?>" class="phone_1" id="form_phone_2"  onkeypress="return numbersonly(event)" />

                            <input type="text" name="phone2" maxlength="3" value="<?=$phone2?>" class="phone_2"  onkeypress="return numbersonly(event)" />

                            <input type="text" name="phone3" maxlength="4" value="<?=$phone3?>"  class="phone_3"  onkeypress="return numbersonly(event)" />



                    <?php		

						}   

					?>

                    

				</li>

				

				<li class="clearfix">

					<label class="form_email_2">Email</label>

					<input type="text" name="form_email_2" value="<?=$form_email_2?>" id="form_email_2" />

				</li>

				

				<li class="clearfix">

					<label class="form_age_2">Age</label>

					<input type="text" name="age" id="form_age_2" />

				</li>

				<?php if ($multi_location_data == 1 && count($locations) >= 1 ) {?>

				<li class="clearfix">

					<label class="form_school_interest">School Of Interest</label>                     

					<select name="school_interest" id="form_school_interest">

						<option value="0">Please choose one&hellip;</option>

						<option disabled="disabled">-------------------------</option>

						<?php foreach($locations as $location): ?>

							<?php if($location->id == $school_interest):?>

                                <option selected="selected" value="<?=$location->id;?>"><?=$location->name;?></option> 

                            <?php else:?>

                                <option  value="<?=$location->id;?>"><?=$location->name;?> </option>

                            <?php endif;?>

						<?php endforeach;?>



					</select>

				</li>

				<?php } ?>

				

                <?php

					if($online_special_data['program_interest'] == 'on'){

						

						$prg_data= $this->db->query("select * from `tblprogram` where trial='1'") or die(mysqli_error($this->db->conn_id));

						$program = $prg_data->result();

        

				?>

				<li class="clearfix">

					<label class="form_school_2">Program Of Interest</label>

					<select name="program" id="form_school_2">

						<option value="0">Please choose one&hellip;</option>

						<option disabled="disabled">-------------------------</option>

						<?php foreach($program as $programs): ?>

						<?php if($programs->id==$program_id):?>

						<option  selected="selected" value="<?=$programs->id;?>"><?=$programs->program;?> </option> 

						<?php else:?>

						<option  value="<?=$programs->id;?>"><?=$programs->program;?> </option>

						<?php endif;?>

						<?php endforeach;?>



					</select>

				</li>

                

				<?php } ?>				



				<li class="clearfix">

					<label class="form_message_2">Message</label>

					<textarea name="message" id="form_message_2"></textarea>

				</li>



				<!-- <li>

					<label class="amount">Total: $<?=(isset($online_special_data['trial_amount'])) ? $online_special_data['trial_amount'] : ''?></label>

				</li> -->

               

               <li class="clearfix">

                   <input type="hidden" name="miniform" value="<?=$miniform?>" /> 
                   <input type="text" id="website" name="website" style="display:none" autocomplete="off">	

               </li> 

				<li class="clearfix paynow">

                	<input type="submit" name="paynow" value="Submit" class="submit button" />

				</li>

			</ul>

			<!-- END .form_fields -->

			

		</form>

		<!-- END #contact_form -->

	</div>

	<!-- END .main_content -->

</div>

<!-- .main .container -->



<?php $this->load->view('includes/footer'); ?>