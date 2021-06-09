<!DOCTYPE html>

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

?>

  <head>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
 <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<base href="<?=base_url();?>">
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


  </head>

  <body class="az-body az-body-sidebar">


<?php $this->load->view("admin/include/navigator-links");?>

<div class="az-content az-content-dashboard-ten">
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
			
			
			<?php if($this->session->userdata("user_level") == 1) { ?>
	
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
			<?php } ?>

          </div><!-- az-header-center -->

          <div class="az-header-right">
            <div class="az-btn-view-site">
              <a class="btn btn-outline-indigo btn-with-icon btn-block"  href="<?=base_url();?>" target="_blank"><i class="typcn typcn-device-laptop"></i> View Your Website</a>
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
			
            <div class="az-header-message">

              <a href="#"><i class="typcn typcn-messages"></i></a>

            </div><!-- az-header-message -->

           

            <div class="dropdown az-profile-menu">

              <a href="" class="az-img-user"><i class="typcn typcn-user"></i></a>

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
		$is_space_need = 1;
		$pagesListForSpaceArr = array('dashboard'); 
		
		if($this->uri->segment(2) != ""){
			if(in_array($this->uri->segment(2),$pagesListForSpaceArr)){
				$is_space_need = 0;
			}
		}else{
			$is_space_need = 0;
		}
		
		if($is_space_need == 1){
	?>
      <div class="az-content-header d-block d-md-flex mg-t-0 top_header_extra_spacing">

        <div>

        </div>
	
      </div>
		<?php } ?>
