<?php $this->load->view('includes/header'); ?>

<body class="inside_page two_column left_sidebar">

<?php $this->load->view('includes/header/masthead'); ?>
<?php
		$pageURL = 'http://';
		if (isset($_SERVER['HTTPS']) && filter_var($_SERVER['HTTPS'], FILTER_VALIDATE_BOOLEAN))
		$pageURL .= 'https://';
			
		if ($_SERVER["SERVER_PORT"] != "80"):
		  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		 else:
		  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		endif;
?>
<div class="main container clearfix">
	
	<ul class="sidebar vertical two_column clearfix">
		<?php $this->load->view('includes/sidebar/feature_boxes'); ?>
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
		});
	</script>	
	
	<div class="main_content two_column" id="top">
		<div class="fb-recommend-container">
			<div class="fb-like" data-href="<?php echo $pageURL?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true" data-action="recommend"></div>
		</div>
		<h1>F.A.Q.</h1>
		
		<div class="button_list">
			<?php if(!empty($cat)):?>
			<?php $i = 1;?>
			<?php foreach($cat as $cat): ?>
				<a href="#section_<?=$i++?>" class="button scroll"><?=$cat->cat_name?></a>
			<?php endforeach; endif;?>
		</div>
		<!-- END .button_list -->
		
		<ul class="list_style_content faq">
		<?php if(!empty($cat_t)): ?>
		<?php $i = 1;?>
		<?php foreach($cat_t as $cat_t): ?>
			<li class="list_section">
		
				<dl class="content">
				
					<dt><h3 id="section_<?=$i++;?>"><?=$cat_t->cat_name?></h3></dt><br>
					<?php
					$this->db->order_by("pos", "ASC"); 
					$faq = $this->query_model->getbySpecific("tblfaq", "category", $cat_t->cat_id);
					?>
					<?php if(!empty($faq)): $count = 1; $tcount = count($faq);?>
					<?php foreach($faq as $faq):?>
					<?php if($faq->published=='1'):?>
					<style>
					.question p{ padding-top: 0 !important; padding-bottom: 0 !important; }
					.question p:first-child{ padding-top: 20px; !important; }
					.answer p{ padding-top: 0 !important; padding-bottom: 0 !i
					<dd class="qumportant; }
					</style>estion">
						<p><?=html_entity_decode($faq->ques);?></p>
					</dd>
					<!-- END .question -->
					<br/>
					<dd class="answer">
						<p><?=html_entity_decode($faq->ans);?></p>
					</dd>
					<?php if($count < $tcount ):?>
					<hr style="border:none; border-bottom: #3E3E3E solid 1px; margin-top: 30px; margin-bottom:30px; background:none" />
					<?php endif;?>
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
		<?php endforeach; endif;?>
		</ul>
		<!-- END .list_style_content .faq -->
	
	</div>
	<!-- END .main_content -->
	
</div>
<!-- .main .container -->

<?php $this->load->view('includes/footer'); ?>
