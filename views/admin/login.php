<?php 

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

?>

<?php 
	// DOJO 03/11
	$ref_url = 'admin/dashboard';
	if(isset($_GET['ref_url'])){
		$ref_url = $_GET['ref_url'];
	}
	
	if(isset($_GET['ref_url']) && $_GET['ref_url'] == 'admin'){
		$ref_url = 'admin/dashboard';
	}
	
	
$reffer_url = base_url().$ref_url;
	
	$admin_after_login_redirct_url = $this->session->userdata('admin_after_login_redirct_url');
	if($admin_after_login_redirct_url != ""){
		$reffer_url = $admin_after_login_redirct_url;
	}elseif(isset($_SERVER['HTTP_REFERER'])){
		$reffer_url = $_SERVER['HTTP_REFERER'];
	}
	
	//echo $reffer_url; 
	
	
$pwa_setting = $this->query_model->getbySpecific('tbl_pwa_settings', 'id', 1);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
   
    
    <!-- Required meta tags -->
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


    <title><?php echo $site_settings['title']; ?> - Admin Login </title>

    <!-- vendor css -->
    <link href="<?=base_url();?>assets_admin/lib/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="<?=base_url();?>assets_admin/lib/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="<?=base_url();?>assets_admin/lib/typicons.font/typicons.css" rel="stylesheet">

    <!--  CSS -->
    <link rel="stylesheet" href="<?=base_url();?>assets_admin/css/style.css">
    <link rel="stylesheet" href="<?=base_url();?>assets_admin/css/admin_development.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="<?=base_url();?>assets_admin/js/admin_development.js"></script>

  </head>
  <body class="az-body">
    <div class="login_page az-signin-wrapper">
      <div class="az-card-signin">
       <a href="<?=base_url();?>" class="az-logo"><img src="<?php echo base_url().'assets_admin/img/logo.png'; ?>" alt=""></a>
        <div class="az-signin-header">
          <h4 >Dojo Panel Login</h4>
          <h2><?php echo $site_settings['title']; ?></h2>
		  
		  
			 <div class="form-group text-center">
				<!--<div class=" FacebookError"><?php echo $this->session->userdata('facebookError'); ?></div>-->
				<?php 
					if(isset($_GET['fb_error']) && $_GET['fb_error'] == 1){
						if(isset($_GET['fb_error_res']) && !empty($_GET['fb_error_res'])){
				?>
				<div class="facebook_error_msg">
				<p class="facebookErrorText">Incorrect Facebook Login</p><p>The facebook login you entered does not have access to this CMS. </p><p>Please try using the facebook account we connected to your CMS.</p><p>Contact Website Dojo Support if you need assistance, <span class="emailAddress"><a href="mailto:support@websitedojo.com?Subject=Incorrect Facebook Login" class="button scroll">support@websitedojo.com</a><span>.</p><p class="logoutFBtext"><a href="<?php echo $_GET['fb_error_res']; ?>" TARGET = "_blank" class="facebookLogout">Try Again</a></p><p class="tryAgain" style="display:none;">Try Again</p>
				</div>
				<?php 
						}
					}
				?>
				<a href="<?=base_url();?>admin/facebooklogin/login"><img src="<?php echo base_url().'/img/new/fb.png'; ?>"  alt="fb-btn"></a>
				<div class="or_login_text"> <span>Or</span></div>
			  </div> 
          <form action="<?=base_url();?>admin/login/validate_credential" method="post">
		  
		  <?php
			if($this->session->userdata('admin_login_error') == 1){ 
				 $this->session->unset_userdata('admin_login_error'); 
		  ?>
		  <div class="admin_login_error alert alert-danger" role="alert"><span>Invalid Credentials! Try Again.</span></div>
		<?php } ?>
		
        
		<div class="form-group">
              <label>Username</label>
			  <div class="input-group">
			  <input type="text" class="form-control" name="user" for="name" id="user" tabindex="1"  value="<?php if(isset($_COOKIE['user'])){ echo $_COOKIE['user']; } ?>" >
			  </div>
            </div><!-- form-group -->
			
			<div class="form-group">
              <label>Password</label>
			  <div class="input-group">
			  <input type="password" class="form-control" id="admin_login_password" name="password" for="name" tabindex="1"  input_type="hide" value="<?php if(isset($_COOKIE['password'])){ echo $_COOKIE['password']; } ?>" >
			  <div class="input-group-append view_password">
				
				<span class="input-group-text" id="basic-addon2"><i class="far fa-eye"></i></span>
			  </div>
			  </div>
            </div>
            
			
			
			<!-- form-group --> 
			<div class="form-group">
				<div class="checkbox">
					<label><input type="checkbox" name="RememberMe" id="RememberMeLogin" <?php if(isset($_COOKIE['password'])){ echo 'checked=checked'; } ?> value="1"  /> Remember me</label>
				</div>
				
            </div>  
			<input type="hidden" name="reffer_url" value="<?= $reffer_url ?>">
            <button class="btn btn-az-primary btn-block" type="submit"  value="Sign In"  >Sign In</button>
          </form>
        </div><!-- az-signin-header -->
        <div class="az-signin-footer">
           <p><a href="">Forgot password?</a></p>
          <p>Need Help? <a style="
    color: #000;
" href="mailto:info@websitedojo.com">info@websitedojo.com</a></p>
        </div><!-- az-signin-footer -->
      </div><!-- az-card-signin -->
    </div><!-- az-signin-wrapper -->
	
<?php if(!empty($pwa_setting) && $pwa_setting[0]->type == 1){ ?>
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
    <script src="<?=base_url();?>assets_admin/lib/jquery/jquery.min.js"></script>
    <script src="<?=base_url();?>assets_admin/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?=base_url();?>assets_admin/lib/ionicons/ionicons.js"></script>

    <script src="<?=base_url();?>assets_admin/js/azia.js"></script>
   
	
  </body>
</html>
