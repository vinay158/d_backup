 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<?php if($this->session->userdata('error_message') == 1){	 ?>
<script type="text/javascript">
    $(window).load(function(){
        $('#loginmodal').modal('show');
    });
</script>
<?php } ?>
<script type="text/javascript">
$(document).ready(function(){
		$('.student_section_login_btn').click(function(){
			$('.ErrorMsgNotLogin').hide();
			$('#login-password').val('');
		});
	});
</script>

<?php 
$site_settings = $this->query_model->getbyTable("tblsite");
$mainLocation = $this->query_model->getMainLocation("tblcontact");
$multi_student_section = $this->query_model->getbySpecific("tblconfigcalendar", 'id',8);
?>
 <?php 
 	$pageurl = '';
 	if(isset($_SERVER['REQUEST_URI'])){
		$pageurl = explode('/',$_SERVER['REQUEST_URI']);
		if(isset($pageurl[1])){
			$pageurl = $pageurl[1];
		}
	}
 ?>
 
  <?php 
	if($settings->override_logo == 1){
			if($settings->override_nav_bar_logo != 1)
			{
			
			$footer_logo = $this->query_model->getbySpecific('tbloverride_logos','s_no', $settings->override_nav_bar_logo);
			
				if(!empty($footer_logo)){
				
					$nav_bar_logo = base_url().'upload/override_logos/'.$footer_logo[0]->logos;
					$nav_bar_logo_alt = $footer_logo[0]->logo_alt;
		
				} else{ 
					$nav_bar_logo = $logo;
					$nav_bar_logo_alt = $settings->logo_alt;
			
			}
		} else{
			$nav_bar_logo = $logo;
			$nav_bar_logo_alt = $settings->logo_alt;
		
 			 } 
 		} else{ 
			$nav_bar_logo = $logo;
			$nav_bar_logo_alt = $settings->logo_alt;
	 }
?>
<?php $current_url = base_url(); ?>
<?php //$current_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['CONTEXT_PREFIX'].'/'; ?>
 <!-- Navigation -->
      <nav id="navigation" class="navbar navbar-inverse  main-nav  <?php if($pageurl == 'programs' || $pageurl == 'ourprograms'){ echo ' hidden-md hidden-lg'; }?>" >
         <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
               <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
               <span class="sr-only">Toggle navigation</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               </button>
               <a class="navbar-brand hidden-xs" href="<?php base_url(); ?>"><img src="<?=$nav_bar_logo?>" alt="<?php $this->query_model->getStrReplace($nav_bar_logo_alt); ?>" class="logoImg" ></a>
            </div>
            <div class="user-mobile-control">
                <?php 
					$mobileLogoImg = $nav_bar_logo;
					if(!empty($settings->unique_logo_mob)){
						$mobileLogoImg = 'upload/unique_logo/'.$settings->unique_logo_mob;
					} 
				?>
               <div class="logo">
                   <a class="logo-m" href="<?php base_url(); ?>"><img src="<?=$mobileLogoImg?>" alt="<?php $this->query_model->getStrReplace($nav_bar_logo_alt); ?>" class="logoImg" ></a>
               </div> 
			   
			   <?php if($multi_student_section[0]->field_value == 1){ ?>
               <div class="login">
			   		<?php if($this->session->userdata('student_session_login') == 1){ ?>
						<a href="<?php echo base_url().'studentsection' ?>"  class="login-user"  style="float:right;"> <i class="fa fa-3x fa-user"></i></a> 
						<?php } else {  ?>
								<?php if($settings->st_sec_external_link == 1){ ?>
								<a href="<?php echo $settings->st_sec_button_url; ?>"  class="login-user" style="float:right;"><i class="fa fa-3x fa-user"></i></a> 
							<?php } else{ ?>
								<a href="javascript:void('0')" data-toggle="modal" data-target="#loginmodal" data-whatever="@mdo" class="login-user" style="float:right;"> <i class="fa fa-3x fa-user"></i> </a>
							<?php } ?>
				 <?php } ?>
               </div>
			 <?php } ?>
			 
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			
				<?php front_menu(0, 3, 'nav navbar-nav navbar-left', 'dropdown  horizontal-dropdown '); ?>
				
               <!-- right user menu -->
			   <?php if($settings->hide_window != 'hide'): ?>
               <div class="btn-trial"><a class="btn slide" href="<?php echo $this->query_model->getTrialOfferUrl($settings->url_call_to_action); ?>" target="<?php if($site_settings[0]->window == 'new'): echo '_blank'; endif; ?>"> <?php $this->query_model->getStrReplace($settings->call_to_action); ?> </a></div>
               <ul class="user-menu nav navbar-nav navbar-right">
                  <li> <a href="https://m.me/ATA-Martial-Arts-Demo-Location-1705436799469161" target="_blank"> <img src="images/message-icon.png"></a> </li>
               </ul>
            </div>
			<?php endif; ?>
            <!-- /.navbar-collapse -->
         </div>
         <!-- /.container -->
      </nav>
	  
	  
	  
     
<script>

	$(document).ready(function(){
		
		$('#login-password').bind("enterKey",function(e){
			var password = $('#login-password').val();
   			
		});
		
		$('#login-password').keyup(function(e){
			if(e.keyCode == 13)
			{
				$(this).trigger("enterKey");
			}
		});


		$('.loginButton').click(function(){
			
			$('#loginform').removeAttr('action');
			
			var password = $('#login-password').val();
			
			checklogin(password);
		});
		
	});
	

 function checklogin(password){
 			$.ajax({ 					
				type: 'POST',						
				url: '<?php echo $current_url; ?>payment/checkstudentlogin',						
				data: { password : password}				
				}).done(function(msg){
				
				if(msg == 1){
					setTimeout("window.location.href='<?php echo $current_url; ?>studentsection'",1000);
				}
				else{
					$('.ErrorMsgNotLogin').show();
					$('.ErrorMsgNotLogin').html('Password is incorrect, please try again.');
					return false;					
				}
			});
}
</script>
<div id="loginmodal" class="modal fade " tabindex="-1" role="dialog">
  <div class="modal-dialog modal-xs">
    <div class="modal-content">
      <div class="modal-header" align="center">
       <button type="button" class="close student_section_login_btn" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2><?php echo $settings->ss_login_popup_text; ?></h2>
        
        </div>
      <div class="modal-body text-center">
      
       <div class="login-form">
          <form id="loginform" class="form-horizontal" role="form" method="post" action="<?php echo base_url().'payment/checkstudentloginToEnterKey' ?>">
		  				<span class="ErrorMsgNotLogin" style="display:none"><?php if($this->session->userdata('error_message') == 1){ echo 'Password is incorrect, please try again.'; }	 ?>
						</span>
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                        <input id="login-password" type="password" class="form-control" name="password" placeholder="Password">
                                    </div>
                                    
                                    <div class="login-btn">
                                      <a id="btn-login" href="javascript:void(0)" class="btn btn-theme btn-lg btn-block loginButton">Login  </a>
                                    </div>  
          </form>
       </div>
       
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
  