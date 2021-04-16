<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<?php $this->load->view('includes/header'); ?>


<?php  $this->load->view('includes/header/masthead'); ?>

<section id="main-address">
  <div class="container">
    <div class="row">
      <div class="col-md-12	 col-xs-12 col-sm-6">
        
      </div>
      
    </div>
  </div>
</section>

<div class="main container clearfix">
	
	
	<!-- END .sidebar .vertical -->
	
	<div class="main_content two_column" id="top" style="padding:20px 0 400px;">
	<?php if(!empty($msg)): ?>
		<?php if($msg = 1) : ?>
		<h1 style="text-align:center;"><?php echo $this->query_model->getStaticTextTranslation('thankyou'); ?></h1>
		<p style="text-align:center;margin-top:10px;"><?php echo $this->query_model->getStaticTextTranslation('your_message_sent'); ?></p>
		<p style="text-align:center;margin-top:10px;"><a class="btn btn-readmore read-small" href=""><?php echo $this->query_model->getStaticTextTranslation('back_to_homepage'); ?></a></p>
		<?php else: ?>
		<p><?php echo $this->query_model->getStaticTextTranslation('email_sending_failed'); ?><a href="birthdayparties"><?php echo $this->query_model->getStaticTextTranslation('go_back'); ?></a></p>
		<?php endif; ?>
	<?php else: ?>
		<?php if(!empty($content)): ?>
		<?php foreach($content as $content) :?>	
		<h1><?=$content->title?></h1>
		<span class="page_content"><?php	$_msg= html_entity_decode($content->content);	
							$_msg=str_replace('(Your School Name)',$site_title, $_msg);		
			echo $_msg;?>	
		</span>	
		<?php endforeach;?>
		<?php endif;?>
	<?php endif;?>
	</div>
	<!-- END .main_content -->
	
</div>
<!-- .main .container -->

<?php $this->load->view('includes/footer'); ?>