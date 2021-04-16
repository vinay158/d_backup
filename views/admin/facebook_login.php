<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script language="javascript" type="text/javascript">
	$(document).ready(function(){
    	$('#FacebookLogin').submit();
	});
</script>

 
 <form name="User" action="<?php echo $login_url; ?>" id="FacebookLogin" method="post">
 <input type="hidden" name="email" />
 </form>