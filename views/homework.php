<?php $this->load->view('includes/header'); ?>

<body class="inside_page two_column left_sidebar">

<?php $this->load->view('includes/header/masthead'); ?>

<div class="main container clearfix">
	
	<ul class="sidebar vertical two_column clearfix">
	
		<?php  $this->load->view('includes/sidebar/feature_boxes'); ?>
		
	</ul>
	<!-- END .sidebar .vertical -->
	<script language="javascript">
	$(document).ready(function(){
	$(".question p:first-child").each(function(){
	var temp = $(this).text();
	$(this).html("<span>Q. "+temp+"</span>");
	});
	$(".answer p:first-child").each(function(){
	var temp = $(this).text();
	$(this).html("<span>A. </span>"+temp);
	});
	$("#proceed").click(function(){
		$('#proceed_click').value('1');
	    $("#form_details").slideToggle("slow");
	 });
	
	});
	</script>	
	<div class="main_content two_column" id="top">
	
		<h1>Homework</h1>
		<form action="homework/send" class="trial_form content_trial_form" method="post">
		<!--<div class="button_list">
		<?php if(!empty($cat)):?>
		<?php $i = 1;?>
		<?php foreach($cat as $cat): ?>
			<a href="#section_<?=$i++?>" class="button scroll"><?=$cat->cat_name?></a>
		<?php endforeach; endif;?>
		</div>
		--><!-- END .button_list -->
		<?php 
		if(in_array('ansNotEmpty',$error_arr)){
			echo "<font color='red'>Oops! please enter at least one answer</font>";
		}
			
		?>
		
		<ul class="list_style_content faq">
		
		<?php $i = 1;?>
		
			<li class="list_section">
		
				<dl class="content">				
					<!--<dt><h3 id="section_<?=$i++;?>"><?=$cat_t->cat_name?></h3></dt><br>
					--><?php
					//$this->db->order_by("pos", "ASC"); 
					//$faq = $this->query_model->getbySpecific("tblhomework", "category", $cat_t->cat_id);
					?>
					<?php if(!empty($faq)): $count = 1; $tcount = count($faq);?>
					<?php foreach($faq as $faq):?>
					
					<style>
					.question p{ padding-top: 0 !important; padding-bottom: 0 !important; }
					.question p:first-child{ padding-top: 20px; !important; }
					.answer p{ padding-top: 0 !important; padding-bottom: 0 !important; }
					</style>
					<dd class="question">
						<p><?=html_entity_decode($faq->ques);?></p>
					</dd>
					<!-- END .question -->
					<br/>
					<dd class="answer">
						<textarea rows="4" cols="100" id="<?=$faq->id;?>" name="ques[]"></textarea>						
					</dd>
					<?php if($count < $tcount):?>
					<hr style="border:none; border-bottom: #3E3E3E solid 1px; margin-top: 30px; margin-bottom:30px; background:none" />					
					<!-- END .answer -->
					<?php endif;?>
					<?php $count++; endforeach;?><?php else: ?>
					<dd><p>NO FAQ ADDED TO THIS SECTION YET.</p>
					</dd>
					<?php endif;?>
				</dl>
				<!-- END .content -->
			
			</li>
			<!-- END .list_section -->
					
		</ul>
		<!-- END .list_style_content .faq -->
		<div style='text-align:center'>		
			<input type="button" class="button_faq" id="proceed" name="proceed" value="Proceed">
		</div>
		<div  style="display:none" id="form_details">
			<ul class="form_fields">			
				<li class="clearfix">
					<label class="form_name_2">Student Name</label>
					<input type="text" name="name" id="form_name_2" />
				</li>				
				
				<li class="clearfix">
					<label class="form_email_2">Email</label>
					<input type="text" name="form_email_2" id="form_email_2" />
				</li>
				<li class="clearfix">
				<?php 
					if(in_array('emailNotValid',$error_arr)){
						echo "<div style='color:red;text-align:center'>Oops! please enter valid email address</div>";
					}?>
				</li>		
				
				<li class="clearfix">
					<label class="form_message_2">Message</label>
					<textarea name="message" id="form_message_2"></textarea>
				</li>
			<input type="hidden" name="homeworktitle" id="homeworktitle" value="<?=($faq->title)?$faq->title:'';?>" />
			<input type="text" name="proceed_click" id="proceed_click" value="0" />
			<li class="clearfix">
				<input type="submit" class="submit button" name="submit" value="Submit">
			</li>
		</div>	
	</form>
	</div>
	<!-- END .main_content -->
	
</div>
<!-- .main .container -->

<?php $this->load->view('includes/footer'); ?>