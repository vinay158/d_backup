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

   	 	

			<h1><?=$online_special_data['paid_offer_name']?></h1>

			<span class="page_content"><?=html_entity_decode($online_special_data['paid_offer_desc']);?></span>

			

	<?php

	}

	?>	

		

		 <form action="https://www.paypal.com/cgi-bin/webscr" method="post"> 

        <!--<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" id="paypal">-->

        

        	<input name="cmd" type="hidden" value="_xclick" />

            

             <input name="business" type="hidden" value="<?=$online_special_data['paypal_email']?>" /> 

            <!--<input type="hidden" name="business" value="businesskamla@paypal.com">-->

            

            

            <input name="notify_url" type="hidden" value="<?=base_url()?>starttrial/notifypayment" />

            <input name="return" type="hidden" value="<?=base_url()?>" />

            <input name="cancel_return" type="hidden" value="<?=base_url()?>" />

            

            <input name="item_name" type="hidden" value="Start Trial" />			    

			<input name="amount" type="hidden" value="<?=(isset($online_special_data['trial_amount']))?$online_special_data['trial_amount']:'0'?>" />

            

            <input name="receiver_email" type="hidden" value="<?=$post['form_email_2']?>" />			    

            

            <input name="currency_code" type="hidden" value="USD" />

            

			<input name="custom" type="hidden" value="<?=$post['form_email_2']?>" />			

			

			<input name="first_name" type="hidden" value="<?=$post['name']?>" />			

                





			<ul class="form_fields" style="margin:40px 0 0 -50px;">

				<li><label class="amount" style=" color: #e12a2a;

    font-size: medium; font-weight: bold; padding: 8px 0; position: relative;

    text-align: center; width: 720px;">Total: $<?=(isset($online_special_data['trial_amount'])) ? $online_special_data['trial_amount'] : ''?></label></li>

				<li class="clearfix paynow">

					                    <input type="submit" class="submit button" name="submit" value="Buy Now">

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

