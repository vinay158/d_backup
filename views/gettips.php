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

			 $pageURL = base_url().'gettips';			 

		?>

        <div class="fb-recommend-container">

			<div class="fb-like" data-href="<?=$pageURL?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true" data-action="recommend">

			</div>

		</div>

        

        <h1>Get Tips</h1>

        <div class="special_offer_offer"><?=$gettips['heading2']?></div>

        <span class="page_content"><?=html_entity_decode($gettips['description']);?></span>

			

		

		

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

				

				if($("#form_email_2").val().length == 0 || emailfilter.test($("#form_email_2").val()) == false){

					err = 1;

					cl = $("#form_email_2").attr("id");

					$("."+cl).css("color", "red");

				}

			

				if( err != 0 ){

					$(".message #alert").html("<b>Please fill in the contact form correctly.</b>");

					$(".message").fadeIn(300);

					return false;

			

					event.preventDefault();

				}

			});

		});

		</script>

		

		<form action="gettips/send" class="trial_form content_trial_form" method="post">

					

			<div class="message">

				<div id="alert"></div>

			</div>

			<!-- END .message -->

			

			<ul class="form_fields">

			

				<li class="clearfix">

					<label class="form_name_2">Name</label>

					<input type="text" name="name" id="form_name_2" value=""  />

				</li>

				

				<li class="clearfix">

					<label class="form_phone_2">Phone</label>

					<input type="text" name="phone1" maxlength="3" value="" class="phone_1" id="form_phone_2"  onkeypress="return numbersonly(event)" />

					<input type="text" name="phone2" maxlength="3" value="" class="phone_2"  onkeypress="return numbersonly(event)" />

					<input type="text" name="phone3" maxlength="4" value=""  class="phone_3"  onkeypress="return numbersonly(event)" />

				</li>

				

				<li class="clearfix">

					<label class="form_email_2">Email</label>

					<input type="text" name="form_email_2" value="" id="form_email_2" /> </li>

                    <li class="clearfix">

                    <input type="hidden" name="miniform" value="true" />

                     <input type="text" id="website" name="website"  style="display:none"  autocomplete="off">

				</li>

			

				<li class="clearfix paynow">
                
                	<input type="text" id="website" name="website"  style="display:none;"  autocomplete="off">

					<input type="submit" class="submit button" name="submit" value="Submit">

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

