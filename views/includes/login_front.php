<a href="#login_form" id="loginarea" style="display:none" >Try now</a>
	<div style="display:none" >
	<form id="login_form" method="post" action="">
	    <p id="login_error">Please, Enter Username and Password</p>
	    <p  id="password_error">Oops! Wrong password</p>
		<p>
			<label for="login_name">Username:</label>
			<input type="text" id="login_name" name="login_name" size="25" />
		</p>
		<p>
			<label for="login_pass">Password:&nbsp;</label>
			<input type="password" id="login_pass" name="login_pass" size="25" />			
		</p>
		<p>
			<input type="hidden" value="<?=$albumId;?>" name="album_id" id="album_id" />
			<input type="hidden" value="<?=$action;?>" name="action" id="action" />
			<span id="submit_button"><input type="submit" value="Login" /></span>
			<span id="loader"><img src="themes/global/img/ajax-loader.gif"/></span>
						
		</p>
	</form>
</div>
<script language="javascript" type="text/javascript">
	
	$(document).ready(function(){
		$('#loader').hide();
		$('#password_error').hide();

		 $(document).click(function(e) {
		        if (e.target.id == 'fancybox-overlay') {
		            window.location.reload();
		        }
		   });
		
		$(document).keyup(function(e){			  			  	           
		    if(e.keyCode == 27 ){
		        window.location.reload();
		    	return false;
		    }	            
		});  			
		
		$("#loginarea").fancybox().trigger('click');
		
		$("#login_form").bind("submit", function(e) {			
			$('#password_error').hide();			
			e.stopPropagation(); e.preventDefault();
			$('#submit_button').hide();
			$('#loader').show();
			// event.stopPropagation();
			if ($("#login_pass").val().length < 1) {
				$("#login_error").show();
			    $.fancybox.update();
			    $('#submit_button').show();
				$('#loader').hide();
			    return false;
			}else{
				$("#login_error").hide();
			}
			//return false;
			$.fancybox.showLoading();			 
			$.ajax({
				type		: "POST",
				cache	: false,
				//url		: "/authprocess",
				url		: "/dojo_v2/authprocess",
				data		: $(this).serializeArray(),
				success: function(data) {
					if(data.trim()==1){
						//$.fancybox('You are logged in successfully !');
						setTimeout(function() {
							$.fancybox.close();
						}, 2000);
						window.location.reload();												
					}
					if(data.trim()==0){
						$('#login_error').hide();
						$('#password_error').show();
						$('#submit_button').show();
						$('#loader').hide();						
					}				
				}
			});

			return false;
		});
		
});

setInterval(function(){
	$('.fancybox-close').hide();
	$('.fancybox-close').remove();
},100);	
	
</script>