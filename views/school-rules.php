<?php $this->load->view('includes/header'); ?>

<body class="inside_page two_column left_sidebar">

<?php $this->load->view('includes/header/masthead'); ?>
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
<div class="main container clearfix">
	
	<ul class="sidebar vertical two_column clearfix">
	
		<?php $this->load->view('includes/sidebar/feature_boxes'); ?>
		
	</ul>
	<!-- END .sidebar .vertical -->
	
	<div class="main_content two_column" id="top">
		<div class="fb-recommend-container">
			<div class="fb-like" data-href="<?php echo $pageURL?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-action="recommend">
			</div>
		</div>
		<h1>School Rules</h1>
		
		<div class="button_list">
		<?php if(!empty($rules)): ?>
		<?php $i =1;?>
		<?php foreach($rules as $heading_rules):?>
		<?php if($heading_rules->published == 1):?>
			<a href="#section_<?=$i++?>" class="button scroll"><?=$heading_rules->title?></a>
		<?php endif;endforeach;endif;?>
		</div>
		<!-- END .button_list -->
		
		<ul class="list_style_content rules">
		<?php if(!empty($rules)): ?>
		<?php $i =1;?>
		<?php foreach($rules as $rules):?>
		<?php if($rules->published == 1):?>
			<li class="list_section">
		
				<dl class="content">
				
					<dt><h3 id="section_<?=$i++;?>"><?=$rules->title?></h3></dt>
					<dd>
					<span class="page_content"><?=html_entity_decode($rules->content)?></span>
					</dd>
				
				</dl>
				<!-- END .content -->
			
			</li>
			<!-- END .list_section -->
<?php endif;endforeach;endif;?>		
		
		</ul>
		<!-- END .list_style_content .rules -->
	
	</div>
	<!-- END .main_content -->
	
</div>
<!-- .main .container -->

<?php $this->load->view('includes/footer'); ?>
