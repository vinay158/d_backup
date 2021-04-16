<?php $this->load->view('includes/header'); ?>

<body class="inside_page two_column left_sidebar">

<?php $this->load->view('includes/header/masthead'); ?>

<?php $pageURL = current_url(); ?>

<div class="main container clearfix">
	
	<ul class="sidebar vertical two_column clearfix">
	
		<?php  $this->load->view('includes/sidebar/feature_boxes'); ?>
		
	</ul>
	<!-- END .sidebar .vertical -->
	
	<div class="main_content two_column" id="top">
		<div class="fb-recommend-container">
			<div class="fb-like" data-href="<?php echo $pageURL; ?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-action="recommend">
			</div>
		</div>
		<h1>Testimonials</h1>
		
		<ul class="list_style_content staff">
		<?php 
			if(!empty($testimonials)):
				foreach($testimonials as $testimonial):
					if($testimonial->published == 1): 
		?>
		
			<li class="list_section">			
				<dl class="content">
					<?php if(isset($testimonial->photo) && !empty($testimonial->photo)): ?>
					<dt class="section_img">
						<img src="<?=$testimonial->photo?>" alt="" width="130" />
					</dt>
					<?php endif;?>
					<dd class="name"><p><span><?=ucwords($testimonial->name);?></span></p></dd>
					<dd class="degree"><p><?=$testimonial->title?></p></dd>
					<span class="page_content"><dd class="blurb"><p> <?=html_entity_decode($testimonial->content); ?></p></dd></span>				
				</dl>
				<!-- END .content -->			
			</li>
		<?php 
					endif;		
				endforeach;
			endif;
		?>
		</ul>
		<!-- END .list_style_content .staff -->
	
	</div>
	<!-- END .main_content -->
</div>
<!-- .main .container -->

<?php $this->load->view('includes/footer'); ?>
