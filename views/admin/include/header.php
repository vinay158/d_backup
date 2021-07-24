<!DOCTYPE html>
<?php //$this->query_model->getNewNotification();?>	
<html lang="en">

<?php $this->output->set_header("HTTP/1.0 200 OK");
$this->output->set_header("HTTP/1.1 200 OK");
$this->output->set_header('Last-Modified: '.gmdate('D, d M Y H:i:s', strtotime(date('Y-m-d H:i:s'))).' GMT');
$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
$this->output->set_header("Cache-Control: post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache");
/*$redirect_page = '';
if(isset($_SERVER['REQUEST_URI'])){

    $prefix = $_SERVER['REQUEST_URI'];
    $sitePrefix = explode('/', $prefix);
    
    if(!empty($sitePrefix) && isset($sitePrefix[1])){
        $redirect_page = $sitePrefix[1];
         
        if($redirect_page == 'admin'  && $_SERVER['REQUEST_SCHEME'] == 'https'){
			$siteUrl = $this->query_model->getSiteUrl();
            $redirectUrl = 'http://'.$siteUrl.$_SERVER['REQUEST_URI'];   
			
            redirect($redirectUrl,'location',301);
        }
    }
}*/
$this->db->select(array('https','title'));
$query = $this->db->get_where('tblsite', array( 'id' => 1));
		$site_settings = $query->row_array();
		
		$check_http = $site_settings['https'];

$redirect_page = '';

$folder = $_SERVER['CONTEXT_PREFIX'];





$_SERVER['REQUEST_URI'] = str_replace($folder,'',$_SERVER['REQUEST_URI']);
$siteUrl = $this->query_model->getSiteUrl();

$scriptUrl = (isset($_SERVER['SCRIPT_URI']) && !empty($_SERVER['SCRIPT_URI'])) ? parse_url($_SERVER['SCRIPT_URI']) : '';
$scriptUrl = isset($scriptUrl['host']) ? $scriptUrl['host'] : '';

if(isset($_SERVER['REQUEST_URI'])){

	$prefix = $_SERVER['REQUEST_URI'];
	$sitePrefix = explode('/', $prefix);
	
	if(!empty($sitePrefix) && isset($sitePrefix[1])){
		
		$redirect_page = $sitePrefix[1];
		
		if ( $_SERVER['REQUEST_SCHEME'] == 'http' && $check_http == 1) {
			$redirectUrl = 'https://'.$siteUrl.$_SERVER['REQUEST_URI'];
			
			redirect($redirectUrl,'location',301);
		}
		
		
		if($_SERVER['REQUEST_SCHEME'] == 'https' && $check_http == 0){
				
			redirect("http://".$siteUrl.$_SERVER['REQUEST_URI'],'location',301);
		}
	
		$mainSiteUrl = str_replace($folder,'',$siteUrl);
		$mainSiteUrl = strtolower($mainSiteUrl);
		$scriptUrl = strtolower($scriptUrl);
		if($scriptUrl != $mainSiteUrl){
			
			if( $_SERVER['REQUEST_SCHEME'] == 'https' && $check_http == 1){
				$redirectUrl = 'https://'.$siteUrl.$_SERVER['REQUEST_URI'];
				
				redirect($redirectUrl,'location',301);
			}
		}
		
	}
} 


$this->db->select(array('id','user','login_time','is_switched_user'));
$userDetail = $this->query_model->getBySpecific('tbladmin','id',$this->session->userdata("userid"));
if(!empty($userDetail)){
	
	if($userDetail[0]->is_switched_user == 1){
		$login_time = $userDetail[0]->login_time;
		if(!empty($login_time)){
			
			$expiry_time = $login_time + 48*60*60;
			$current_time = time();
			
			if($current_time > $expiry_time){
				
				//$this->session->set_userdata('switch_user_error','Session expired.. please login again');
				
				redirect('admin/logout');
				
			}
		}
	}
}


$pwa_setting = $this->query_model->getbySpecific('tbl_pwa_settings', 'id', 1);

?>

  <head>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
 <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


	<?php  if(!empty($pwa_setting) && $pwa_setting[0]->type == 1){ ?>
	<!-- ////working code for PWA App -->
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="application-name" content="<?php echo $pwa_setting[0]->name ?>">
	<!--<link rel="icon" sizes="512x512" href="/upload/pwa_icons/<?php echo $pwa_setting[0]->icon_image ?>">-->

	<!-- Add to homescreen for Safari on iOS -->
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="<?php echo $pwa_setting[0]->theme_color ?>">
	<meta name="apple-mobile-web-app-title" content="<?php echo $pwa_setting[0]->name ?>">
	<!--<link rel="apple-touch-icon" href="/upload/pwa_icons/<?php echo $pwa_setting[0]->icon_image ?>"> -->

	<link rel="manifest" href="manifest.json">
	<meta name="theme-color" content="<?php echo $pwa_setting[0]->theme_color ?>"/>
	<!--<link href="/images/icons/splash-640x1136.png" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
	<link href="/images/icons/splash-750x1334.png" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
	<link href="/images/icons/splash-1242x2208.png" media="(device-width: 621px) and (device-height: 1104px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
	<link href="/images/icons/splash-1125x2436.png" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
	<link href="/images/icons/splash-828x1792.png" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
	<link href="/images/icons/splash-1242x2688.png" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
	<link href="/images/icons/splash-1536x2048.png" media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
	<link href="/images/icons/splash-1668x2224.png" media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
	<link href="/images/icons/splash-1668x2388.png" media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
	<link href="/images/icons/splash-2048x2732.png" media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />-->

	<!-- Tile for Win8 -->
	<meta name="msapplication-TileColor" content="<?php echo $pwa_setting[0]->theme_color ?>">
	<meta name="msapplication-TileImage" content="/upload/pwa_icons/<?php echo $pwa_setting[0]->icon_image ?>">
	<?php } ?>
	<!--<meta name="google-site-verification" content="FkS1r3e9yxZiwNSmUkb94EwdXUWn-Lhe7t0Ro0iOEPI" />
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">-->
    <base href="<?=base_url()?>" /> 
    <!-- Meta -->

    <meta name="description" content="Website Dojo - <?=(isset($title))?$title:'Administrator';?>">

    <meta name="author" content="ThemePixels">



   <title><?php echo $site_settings['title']; ?> - <?=(isset($title))?$title:'Administrator';?></title>



    <!-- vendor css -->

    <link href="<?=base_url();?>assets_admin/lib/fontawesome-free/css/all.min.css" rel="stylesheet">

    <link href="<?=base_url();?>assets_admin/lib/ionicons/css/ionicons.min.css" rel="stylesheet">

    <link href="<?=base_url();?>assets_admin/lib/typicons.font/typicons.css" rel="stylesheet">

    <link href="<?=base_url();?>assets_admin/lib/morris.js/morris.css" rel="stylesheet">

    <link href="<?=base_url();?>assets_admin/lib/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">

    <link href="<?=base_url();?>assets_admin/lib/jqvmap/jqvmap.min.css" rel="stylesheet">
	<!-- azia CSS -->
<link rel="stylesheet" href="<?=base_url();?>assets_admin/css/style.css">
	
  
	

	
<!--<script src="https://code.jquery.com/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?=THEMEPATH;?>themes/global/js/jquery-ui-1.10.1.js" type="text/javascript" ></script> -->
<script src="https://code.jquery.com/jquery-2.2.4.min.js" type="text/javascript"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js" type="text/javascript"></script>
<link id="jquiCSS" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/ui-lightness/jquery-ui.css" type="text/css" media="all">
<script src="<?=base_url();?>assets_admin/lib/bootstrap/js/bootstrap.bundle.min.js"></script>

<script language="javascript" type="text/javascript"> var baseurl= '<?=base_url();?>';</script>
<script language="javascript" type="text/javascript" src="<?=base_url();?>js/jquery.tablesorter.js"></script>
<script language="javascript" type="text/javascript"  src="<?=base_url();?>js/jquery.nestable.js"></script>

<script src="<?=base_url();?>assets_admin/js/admin_development.js"></script>  

<link rel="stylesheet" href="<?=base_url();?>assets_admin/css/admin_old_style.css">
<link rel="stylesheet" href="<?=base_url();?>assets_admin/css/admin_development.css">

	<?php  if(!empty($pwa_setting) && $pwa_setting[0]->type == 1){ ?>
<script type="text/javascript">

    // Initialize the service worker
    if ('serviceWorker' in navigator) {
		
        navigator.serviceWorker.register('serviceworker.js', {
            scope: '.'
        }).then(function (registration) {
            // Registration was successful
            console.log('ServiceWorker registration successful with scope: '+registration.scope);
        }, function (err) {
            // registration failed :(
            console.log('ServiceWorker registration failed: '+ err);
        });
    }
</script>
<?php } ?>

  </head>

  <body class="az-body az-body-sidebar">


<?php $this->load->view("admin/include/navigator-links");?>

<?php 
$is_home_page = 0;
$pagesListForSpaceArr = array('dashboard'); 

if($this->uri->segment(2) != ""){
	if(in_array($this->uri->segment(2),$pagesListForSpaceArr)){
		$is_home_page = 1;
	}
}else{
	$is_home_page = 1;
}

?>

<div class="az-content az-content-dashboard-ten <?php echo ($is_home_page == 1) ? ' dashboard dashboard_page' : ''; ?>">

<?php 
	if($is_home_page == 1){ 
		if($this->session->userdata("user_level") == 1) { 
?>
<div class="mg-t-65 mg-b-10 stickyalert" style="text-align: center; ">
				<div class="alert alert-solid-danger" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
					<strong>
						<?php $checkFormModuleConncted =  $this->query_model->checkFormModuleConncted(); ?>
						<?php 
						if(isset($checkFormModuleConncted['form_instances']) && isset($checkFormModuleConncted['form_module'])){ 
							
							echo '<div class="form_instance_mising_old">Form module not connected!</div>';
						
						}else{ 
								if(isset($checkFormModuleConncted['form_instances'])){
									
									echo '<div class="form_instance_mising_old">Form Instances not connected!</div>';
									
								}elseif(isset($checkFormModuleConncted['form_module'])){
									
									echo '<div class="form_instance_mising_old">Form not connected!</div>';
									
								}
							}
						?>
					</strong>
				  </div><div class="alert alert-solid-info" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
					<strong>
						<?php 
							$activeApis = $this->query_model->getActiveApisNames();
							if(!empty($activeApis)){
								$i = 1;
								echo '<div class="active_apis_list_old">';
								foreach($activeApis as $active_api){
									$comma = ($i != count($activeApis)) ? ", " : ' ';
									echo $active_api.$comma;
								$i++;
								}
								echo "API's are ON.</div>";
							}
						?>
					</strong>
				  </div>
			</div>
<?php } } ?>
			
<div class="az-content-body ">
    <div class="az-content-body-left">

      <div class="az-header">

        <div class="container-fluid">

          <div class="az-header-left">

            <a href="" id="azSidebarToggle" class="az-header-menu-icon"><span></span></a>

          </div><!-- az-header-left -->

          <div class="az-header-center">
            <!--<input type="search" class="form-control" placeholder="Search for anything...">

            <button class="btn"><i class="fas fa-search"></i></button>-->
			
			
			<?php /*if($this->session->userdata("user_level") == 1) { ?>
	
			<?php $checkFormModuleConncted =  $this->query_model->checkFormModuleConncted(); ?>
			<?php 
			if(isset($checkFormModuleConncted['form_instances']) && isset($checkFormModuleConncted['form_module'])){ 
				
				echo '<div class="form_instance_mising">Form module not connected!</div>';
			
			}else{ 
					if(isset($checkFormModuleConncted['form_instances'])){
						
						echo '<div class="form_instance_mising">Form Instances not connected!</div>';
						
					}elseif(isset($checkFormModuleConncted['form_module'])){
						
						echo '<div class="form_instance_mising">Form not connected!</div>';
						
					}
				}
			?>
			
			<?php 
				$activeApis = $this->query_model->getActiveApisNames();
				if(!empty($activeApis)){
					$i = 1;
					echo '<div class="active_apis_list">';
					foreach($activeApis as $active_api){
						$comma = ($i != count($activeApis)) ? ", " : ' ';
						echo $active_api.$comma;
					$i++;
					}
					echo "API's are ON.</div>";
				}
			?>
			<?php }*/ ?>

          </div><!-- az-header-center -->

          <div class="az-header-right">
            <div class="az-btn-view-site">
              <a class="btn btn-outline-indigo btn-with-icon btn-block"  href="<?=base_url();?>" target="_blank"><!--<i class="typcn typcn-device-laptop"></i>--> View Your Website</a>
            </div> 
			<?php
				$is_switch_to_crm =  $this->query_model->is_switch_to_crm_applied();
				
				$userDetail = $this->query_model->getBySpecific('tbladmin','id',$this->session->userdata("userid"));
				$userDetail = !empty($userDetail) ? $userDetail[0] : '';
				
				if($is_switch_to_crm == 1 && !empty($userDetail) && !empty($userDetail->secret_key) && !empty($userDetail->access_token)){
					
			?>
					
				<div class="az-btn-view-site admin_desktop_view">
				  <a class="btn btn-outline-indigo btn-with-icon btn-block"  href="<?=base_url();?>admin/user/switch_login"><i class="fa fa-user"></i> Switch to CRM</a>
				</div>
			<?php } ?>
			
<?php $notifications =  $this->query_model->getNewNotification(); ?>

<?php if(empty($notifications)){?>
	<style>
		.az-header-notification > a.new::before{background-color:#fff}
	</style>
<?php }?>		
			<div class="dropdown az-header-notification ">
            <a href="" class="new"><i class="typcn typcn-bell"></i></a>
            <div class="dropdown-menu">
              <div class="az-dropdown-header mg-b-20 d-sm-none">
                <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
              </div>
              <h6 class="az-notification-title">Notifications</h6>
              <p class="az-notification-text">You have <?php echo !empty($notifications) ? count($notifications) : 0; ?> unread notification</p>
              <div class="az-notification-list">
			  
			  <?php if(!empty($notifications)){
					foreach($notifications as $notification){
						if($notification->notification_type == "message"){
							
							$this->db->select(array('image'));
							$profile_img = $this->query_model->getBySpecific('tbl_lead_profile_img','email',$notification->email);
							 
							 $user_image = !empty($profile_img) ? base_url().'upload/kanban_user_profiles/thumb/'.$profile_img[0]->image : base_url().'assets_admin/img/lead_blank_profile_img.png';
				?>
				 <div class="media">
                  <div class="az-img-user"><img src="<?php echo $user_image; ?>" alt=""></div>
                  <div class="media-body">
				  <a href="<?php echo base_url().'admin/twilio_sms_messenger?kanban_user_phone_number='.$notification->phone; ?>" style="color:#031b4e" target="_blank">
                    <p><strong><?php echo $notification->name; ?></strong> 
					<?php echo ($notification->total_msgs > 1) ? 'send you '.$notification->total_msgs.' messages.' : 'send a new message.';?>
					</p>
					<?php if(isset($notification->message) && !empty($notification->message)){ ?>
					<p>
						<?php echo (strlen($notification->message) > 50) ? substr($notification->message,0,50).'...' : $notification->message; ?>
					</p>
					<?php } ?>
                    <span><?php echo date('M d h:i a', strtotime($notification->msg_created)); ?></span>
					</a>
                  </div>
                </div>
			<?php 	
						}	
					} 
				}
			  ?>
			  
              </div><!-- az-notification-list -->
            <!--  <div class="dropdown-footer"><a href="">View All Notifications</a></div>-->
            </div><!-- dropdown-menu -->
          </div>
		  
           <!-- <div class="az-header-message">
              <a href="#"><i class="typcn typcn-bell"></i></a>
            </div>--><!-- az-header-message -->
			<div class="az-header-message">
              <a href="https://intercom.help/dojo-industries/en/" target="_blank"><i class="fa fa-question-circle"></i></a>
            </div><!-- az-header-message --> 
			
			

           

            <div class="dropdown az-profile-menu">

              <span><?php echo $this->session->userdata("fname").' '.$this->session->userdata("lname") ?></span> <a href="" class="az-img-user"><i class="typcn typcn-user"></i></a>

               <div class="dropdown-menu">

                <div class="az-dropdown-header d-sm-none">
                  <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                </div>
				
				<a href="" class="dropdown-item txt-indigo"> My Profile</a>
                <a href="" class="dropdown-item"> Overview</a>

                <a href="" class="dropdown-item"> Account</a>
                
				
				
                <?php if($this->session->userdata("user_level") == 1) {?>
						<a href="admin/adduser" class="dropdown-item">Add Users</a>
				<?php }?>
				<?php 
					$email_marketing_permission = $this->query_model->getOtherPagePermissions($this->session->userdata("userid"), 'admin/email_marketing');
					if($email_marketing_permission == 1){
						$email_marketing_setting = $this->query_model->getByTable('tblsite');
						if(!empty($email_marketing_setting) && $email_marketing_setting[0]->email_marketing == 1){
 				 ?>
					<a href="<?=base_url();?>admin/email_marketing" class="dropdown-item"> Email Marketing <i class="fa fa-envelope"></i></a>
					<?php } } ?>
				<?php 
				$chargifyApi = $this->query_model->getbySpecific('tbl_chargify', 'id', 1);
				if(!empty($chargifyApi) && $chargifyApi[0]->type == 1){
					$chargify_permission = $this->query_model->getOtherPagePermissions($this->session->userdata("userid"), 'admin/chargify_api');
					if($chargify_permission == 1){
				 ?>
					<a href="<?=base_url();?>admin/chargify_api" class="dropdown-item"> Billing</a>
				<?php } } ?>
				
				
				
                <a href="<?=base_url();?>admin/site_statistics/report" class="dropdown-item">Site Statistics</a>
				
				<?php
					$is_switch_to_crm =  $this->query_model->is_switch_to_crm_applied();
					
					$userDetail = $this->query_model->getBySpecific('tbladmin','id',$this->session->userdata("userid"));
					$userDetail = !empty($userDetail) ? $userDetail[0] : '';
					
					if($is_switch_to_crm == 1 && !empty($userDetail) && !empty($userDetail->secret_key) && !empty($userDetail->access_token)){
					
				?>
				
				<a href="<?=base_url();?>admin/user/switch_login" class="dropdown-item admin_mobile_view">Switch to CRM</a>
				<?php } ?>
                
				<a href="admin/logout" class="dropdown-item">Sign Out</a>

              </div><!-- dropdown-menu -->

            </div>

          </div><!-- az-header-right -->

        </div><!-- container -->

      </div><!-- az-header -->

	<?php 
		if($is_home_page == 0){
	?>
      <div class="az-content-header d-block d-md-flex mg-t-0 top_header_extra_spacing">

        <div>

        </div>
	
      </div>
		<?php } ?>
