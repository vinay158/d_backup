<?php $this->load->view('includes/header'); ?>
<body class="inside_page full_width">

<?php  $this->load->view('includes/header/masthead'); ?>

<div class="main container clearfix">
	<?php if(!$loginRequired){ ?>
	<div class="main_content" id="top" style="display:block;text-align:center;">
		<img src="upload/ustream.png" style="margin:auto;"><br><br>
        <iframe src="http://www.ustream.tv/embed/12702064" width="608" height="368" scrolling="no" frameborder="0" style="border: 0px none transparent;"></iframe>
	</div>
	<?php  } ?>
	<!-- END .main_content -->
	
</div>
<!-- .main .container -->
<!--Start front login page -->
<?php 
if($loginRequired){
	$this->load->view('includes/login_front');
}
?>
<!--End front login page -->


<?php $this->load->view('includes/footer'); ?> 
