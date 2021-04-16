<?php 
$site_settings = $this->query_model->getbyTable("tblsite");
$mainLocation = $this->query_model->getMainLocation("tblcontact");
$multi_student_section = $this->query_model->getbySpecific("tblconfigcalendar", 'id',8);
?>
<nav id="navigation" class="navbar navbar-inverse  main-nav " >
  <div class="container"> 
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      </div>
    <div class="user-mobile-control">
      <div class="logo"> <a class="logo-m" href="<?php echo base_url(); ?>"><img src="<?=$settings->sitelogo?>" alt="<?=$settings->logo_alt?>" class="logoImg"></a> </div>
      <div class="login"> <a href="<?php echo base_url().'students/logout' ?>" class="login-user" style="float:right;"> <i class="fa fa-sign-out" aria-hidden="true"></i>
		</a> </div>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	<?php front_menu(0, 2, 'nav navbar-nav navbar-left', 'dropdown'); ?>
    
      <!-- right user menu -->
      <ul class="user-menu nav navbar-nav navbar-right back-to">
        <li> <a href="<?php echo base_url(); ?>" class="sky-txt"><i class="fa fa-angle-left"></i> <?php echo $this->query_model->getStaticTextTranslation('main_site'); ?></a> </li>
      </ul>
      </div>
    <!-- /.navbar-collapse --> 
  </div>
  <!-- /.container --> 
</nav>
