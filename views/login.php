<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery.1.7.2.min.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="<?=THEMEPATH;?>themes/global/css/login-style.css" />
<link href="http://localhost/themes/global/css/jquery.fancybox.css?v=2.0.6" rel="stylesheet" type="text/css" media="screen" />
<script src="http://localhost/themes/global/js/fancybox/jquery.fancybox.pack.js?v=2.0.6" type="text/javascript"></script>
<script src="http://localhost/themes/global/js/fancybox/helpers/jquery.fancybox-media.js?v=1.0.0" type="text/javascript"></script>

<script language="javascript" type="text/javascript">


	$(document).ready(function(){
		$("#login-animation").fancybox();
	/***********************************
	Validate Login Credential Through 
	authentication
	************************************/

	  $(document).keypress(function(e){
           
            if(e.which == 13 || e.which == 32){
            	
            	return false;
                
            	$('.btn-login').trigger('click');
                // Close my modal window
            }
      });			
		
	$(".btn-login").click(function(){
	//alert("A");
	//$('#alert-holder').fadeIn().html("<div><img src='img/_loading.gif' width='18px'/> Validating Credentials.</div>");		
	$('#alert-holder').fadeIn().html("<div> Validating Credentials.</div>");	
	var user = $("#user").val();
	var password = $("#password").val();
	var request=$.ajax({ 					
				type: 'POST',						
				url: '<?=base_url();?>admin/login/validate_credential',						
				data: { user : user , password : password }					
			});
			request.done(function(msg){
				
				if(eval(msg) == 1){
					//alert('in');									
					window.location = "<?=base_url();?>admin/dashboard";
					return false;					
				}
				else{
					$("#alert-holder").html("<div><b class=red>Invalid Credentials! Try Again.</b></div>");
					//alert(2);
					$("#user").attr("value","");
				}
			});

			/*request.fail(function(jqXHR, textStatus) {
			alert( "Request failed: " + textStatus );
				return false;
			});*/
		
		return false;
		
   	//stop sending loopback
	});
	
	/**********************************
	This will trigger the remember me
	animation and value setting
	**********************************/
	$("#rememberme-check").click(function(){
	if(!$(this).attr("disabled")){
		if($(this).hasClass("check-on")){
			$(this).removeClass("check-on");
			$(this).addClass("check-off");
			$("#rememberme").val("NO");
		}
		else{
			$(this).removeClass("check-off");
			$(this).addClass("check-on");
			$("#rememberme").val("YES");
		}
	}
	return false; });	
	
	/*********************************
	Trigger alert window to hide
	*********************************/
	/*$("#alert-holder").click(function(){
		$(this).fadeOut(500);
	});*/
	
	})
</script> 


<!--<div class="head-logo">
<div class="head-logo-inner">
<div class="head-thelogo"></div>
</div>
</div>
		--><div class="gen-holder content-narrow" id="login-animation">
		<div class="gen-panel-holder panel-wide">
		<div class="gen-panel">
			<div class="panel-title">

				<div class="panel-title-name">Login</div>
			</div>
			<div class="panel-body" style="padding-bottom:0;">
			<div class="panel-body-holder">
				<div id="login_form">
						<form id='loginForm' action="" method='post'> 
						<div class="form-light-holder">
							<input type="text" class="field" name="user" id="user" tabindex="1" placeholder="Username" />
						</div>
						<div class="form-light-holder">
							<input type="password" class="field" name="password" id="password" tabindex="2" placeholder="Password" />
						</div>
						<!--<div class="form-light-holder">
							<a rel="publish" id="rememberme-check" class="checkbox check-off"></a>
							<h1 class="inline">Remember Me</h1>
							<input type="hidden" value="NO" name="rememberme" id="rememberme" />
						</div>
						--><div class="form-white-holder" style="margin-bottom:26px;">
							<!--<div class="form-link" style="float:right;padding-top:4px;">
								<a href="" class="forgot-link">Forgot Your Password?</a>
							</div>
							--><input type="button" value="Login" class="btn-login" style="float:left;" />
						</div>
						<br />
					</form>
				</div>
				<div id="forgot_form" style="display:none;">
					<form method="post" name="forgotpass">
						<div class="form-light-holder">
							<input type="text" class="field" name="username" tabindex="1" value="Username" />
						</div>
						<div class="form-light-holder">
							<input type="text" class="field" name="email" tabindex="e" value="Email Address" />
						</div>
						<div class="form-white-holder" style="margin-bottom:26px;">
							<div class="form-link" style="float:right;padding-top:4px;">
								<a href="" class="login-link">Login Now</a>
							</div>
							<input type="button" value="Submit" class="btn-submit" style="float:left;" />
						</div>
						<br />
				</div>
			</div>
			</div>
		</div>
		</div>		
			<?php exit; ?>
