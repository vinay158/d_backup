<?php 
	function getThumbnailImage($v_id){
			if($v_id){
				$url="http://vimeo.com/api/v2/video/".$v_id.".php";						
				$data=file_get_contents($url);						
				$data=unserialize($data);						
				return ($data[0]['user_portrait_medium']);
			}else{
				return 0;
			}	
	} ?>
<?php $this->load->view('includes/header'); ?>

<body class="inside_page full_width">

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
	
	<div class="main_content" id="top">
		<?php if(isset($album)){ ?>
		<div class="fb-recommend-container">
			<div class="fb-like" data-href="<?php echo $pageURL?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-action="recommend">
			</div>
		</div>
		<h1 class="center"><?php echo $this->query_model->getStaticTextTranslation('video'); ?> - <?php foreach($album as $album): ?>
		<?=$album->album; ?>
		<?php endforeach;?></h1>
		<?php } ?>
		
		<?php if(!empty($media)): ?>		
		<ul class="gallery_thumbs video_gallery">
			
			<?php foreach($media as $media):
			$v_id=trim($media->video_id);
			 $desc=$media->desc;			
			$src='';
			if($media->video_type=='youtube'){
				$src="http://img.youtube.com/vi/".$v_id."/0.jpg";	
			}
			if($media->video_type=='vimeo'){
				//http://vimeo.com/api/v2/video/17631561.php
				//$src=getThumbnailImage($v_id);
				$src=$this->query_model->getViemoVideoImage($v_id);
			}
			//get vimeo output		
					
			?>
			<li class="thumb"><a href="<?=$media->link?>" title="<?=$desc?>"><img src="<?=$src?>" width="210" height="152" alt="<?=$desc?>" /><br>
				<span style="text-align:center"><?=$media->desc?></span></a>
                
			</li>
				<?php endforeach; ?>

		</ul>
		<!-- END .photo_gallery -->
		<?php endif;?>
	</div>
	<!-- END .main_content -->
	
</div>
<!-- .main .container -->
<?php 
if($loginRequired){
	$this->load->view('includes/login_front');
}
?>

<?php $this->load->view('includes/footer'); ?>
