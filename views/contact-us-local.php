<?php $this->load->view('includes/header'); ?>

<body class="inside_page two_column left_sidebar sidebar_wide">

<?php $this->load->view('includes/header/masthead'); ?>

<div class="main container clearfix">
	
	<ul class="sidebar vertical two_column clearfix">
	
		<?php $this->load->view('includes/sidebar/sidebar_contact'); ?>
		
	</ul>
	<!-- END .sidebar .vertical -->
	
	<div class="main_content two_column" id="top">
	<?php if(!empty($msg)): ?>
		<?php if($msg = 1) : ?>
		<h4>You're birthday request has been successfully sent. <a href="birthdayparties">go back.</a></h4>
		<?php else: ?>
		<h4>Email sending Failed. Please try again. <a href="birthdayparties">go back.</a></h4>
		<?php endif; ?>
	<?php else: ?>
		<?php if(!empty($content)): ?>
		<?php foreach($content as $content) :?>	
		<h1><?=$content->title?></h1>
		

		<span class="page_content"><?=html_entity_decode($content->content);?></span>
		<?php endforeach;?>
		<?php endif;?>
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
		$(".content_contact_form").submit(function(){
		var err = 0;
		$(".content_contact_form label").each(function(){
			$(this).css("color", "#FFF05D");
		});
		
		if($("#form_name_2").val().length == 0){
		err = 1;
		cl = $("#form_name_2").attr("id");
		$("."+cl).css("color", "red");
		}if($("#form_email_2").val().length == 0 || emailfilter.test($("#form_email_2").val()) == false){
		err = 1;
		cl = $("#form_email_2").attr("id");
		$("."+cl).css("color", "red");
		}if($("#form_message_2").val().length == 0 ){
		err = 1;
		cl = $("#form_message_2").attr("id");
		$("."+cl).css("color", "red");
		}
		
		if( err != 0 ){
		$(".message #alert").html("Please fill in the contact form correctly.");
		$(".message").fadeIn(300);
		event.preventDefault();
		}
		});
		});
		</script>
		<form action="contactus/send" class="contact_form content_contact_form" method="post">
					
			<div class="message">
				<div id="alert"></div>
			</div>
			<!-- END .message -->
			
			<ul class="form_fields">
			
				<li class="clearfix">
					<label class="form_name_2">Name</label>
					<input type="text" name="name" id="form_name_2" />
				</li>
				
				<li class="clearfix">
					<label class="form_phone_2">Phone</label>
					<input type="text" name="phone1" maxlength="3" class="phone_1" id="form_phone_2"  onkeypress="return numbersonly(event)" />
					<input type="text" name="phone2" maxlength="3" class="phone_2"  onkeypress="return numbersonly(event)" />
					<input type="text" name="phone3" maxlength="4" class="phone_3"  onkeypress="return numbersonly(event)" />
				</li>
				
				<li class="clearfix">
					<label class="form_email_2">Email</label>
					<input type="text" name="email" id="form_email_2" />
				</li>
				
				<?php if(count($contact) > 1) : ?>				
				<li class="clearfix">
					<label class="form_school_2">School</label>
					<select name="school" id="form_school_2">
						<option value="0">Please choose one&hellip;</option>
						<option disabled="disabled">-------------------------</option>

						<?php foreach($contact as $con): ?>
						<option value="<?=$con->name;?>"><?=$con->name;?></option>
						<?php endforeach;?>

					</select>
				</li>
				<?php endif;?>				

				<li class="clearfix">
					<label class="form_message_2">Message</label>
					<textarea name="message" id="form_message_2"></textarea>
				</li>
				
				<li class="clearfix">
					<input type="submit" value="Submit" class="submit button" />
					<input type="reset" value="Reset" class="reset button" />
				</li>
			
			</ul>
			<!-- END .form_fields -->
			
		</form>
		<!-- END #contact_form -->
	<?php endif;?>
	</div>
	<!-- END .main_content -->
	
</div>
<!-- .main .container -->

<?php $this->load->view('includes/footer'); ?>