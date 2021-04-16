<?php $this->load->view('includes/header'); ?>

<body class="inside_page two_column left_sidebar">

<?php $this->load->view('includes/header/masthead'); ?>

<div class="main container clearfix">
	
	<ul class="sidebar vertical two_column clearfix">
	
		<?php $this->load->view('includes/sidebar/programs_nav'); ?>
		
	</ul>
	<!-- END .sidebar .vertical -->
	
	<div class="main_content two_column" id="top"> 
	
	<?php if(!empty($cat_name)):?>
		<h1><?=$cat_name;?></h1>
	<?php else :?>
		<h1>Our Programs</h1>
	<?php endif;?>	
	
		<ul class="list_style_content programs">
		<?php if(!empty($page)): ?>
		<?php foreach($page as $page): ?>
		<?php //echo "<pre>";print_r($page);exit;?>
			<li class="list_section">
		
				<dl class="content">
				
					<dt class="section_img">
					<?php if(!empty($page->photo)):?>
					<img src="<?=$page->photo?>" alt="" width="130" />
					<?php else: ?>
					<img src="<?=THEMEPATH;?>themes/global/images/bio_img.jpg" alt="" />
					<?php endif;?>
					</dt>
					<?php $subcat_name=str_replace(" ",'-',trim($page->program)); ?>
					<dd class="header"><a id="<?=$subcat_name;?>"><h2><?=$page->program; ?></h2></a></dd>
					<dd class="button_list" style="margin-top:5px!important;margin-bottom:15px;">
						<?php if(isset($special_prog_hide) && $special_prog_hide==1):
								if($page->trial == 1):
						?>
							<a href="#" class="button scroll">Start Trial</a>
							<?php endif;?>
						<?php endif; ?>
						<a href="#" class="button scroll">Email Us</a>
						<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Ffacebook.com%2Flordoftheringstrilogy&amp;send=false&amp;layout=button_count&amp;width=130&amp;show_faces=false&amp;action=recommend&amp;colorscheme=light&amp;font=lucida+grande&amp;height=21&amp;appId=368121076553974" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:130px; height:21px;" allowTransparency="true"></iframe>
					</dd>
					<!-- END .button_list -->
					
					<dd class="blurb">
					<p class="page_content"><?=html_entity_decode($page->desc)?></p>
					</dd>
					<!-- END .blurb -->
				
				</dl>
				<!-- END .content -->
			
			</li>
			<!-- END .list_section -->
	<?php endforeach; ?>
	<?php endif;?>	
		</ul>
		<!-- END .list_style_content .staff -->
	
	</div>
	<!-- END .main_content -->
	
</div>
<!-- .main .container -->

<?php $this->load->view('includes/footer'); ?>