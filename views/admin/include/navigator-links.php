<?php
 if($this->session->userdata("user_level") == 1) {
	$is_master_admin = true;
} else {
	$is_master_admin = false;	
}


	$redirect_url = $_SERVER['REDIRECT_QUERY_STRING']; 
	
	if(!empty($redirect_url)){
		
		$redirect_url = ltrim($redirect_url, '/');
		
		$replaceArr = array('/view/22','/view/27','/view/26','/view/60','/view/1');
		
		$notReplacedArr = array('admin/offers/view','admin/form_modules/view','admin/form_instances/view');
		if (in_array($redirect_url, $notReplacedArr)) {
			
		}elseif(strpos($redirect_url, 'admin/dojocart') !== false) {
			$redirect_url = str_replace('/view','/index',$redirect_url);
		}elseif(strpos($redirect_url, 'admin/form_emailsignatures') !== false) {
			$redirect_url = str_replace('/add','',$redirect_url);
		}elseif($redirect_url == "admin"){
			$redirect_url = "admin/dashboard";
		}else{
			if($redirect_url != "admin/school/view" && $redirect_url != "admin/albums/view"){
				$replaceArr[] = '/view';
			}
		}
		$redirect_url = str_replace($replaceArr,'',$redirect_url);
	}
	
	//echo $redirect_url; die;
	
?>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="<?=base_url();?>assets_admin/js/admin_development.js"></script>-->
	
    <div class="az-sidebar">

      <div class="az-sidebar-header">

        <a href="<?=base_url();?>admin" class="az-logo"><img src="<?=base_url();?>assets_admin/img/logo.png" alt=""></a>

      </div><!-- az-sidebar-header -->

      

       <div class="az-sidebar-body">

        <ul class="nav">

          <li class="nav-label">Main Menu </li>
			
			
		   <?php cms_menu(0, 7, $this->session->userdata('userid'), $this->session->userdata('user_level'),'nav-link '); ?>
		   
        

        </ul><!-- nav -->

      </div><!-- az-sidebar-body -->

    </div><!-- az-sidebar -->
	
	<input type="hidden" id="cms_redirect_url" value="<?php echo $redirect_url; ?>">
