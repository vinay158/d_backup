<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/sha1.js"></script>
<div class="gen-holder">
	<div class="gen-panel-holder" style="width: 100%;">
	<div class="gen-panel">
		<div class="panel-title">
			<div class="panel-title-name">User Account | <?=$this->session->userdata("user");?></div>
		</div>
		<div class="panel-body">
		<div class="panel-body-holder">
		<div class="form-holder">
<script language="javascript">
$(document).ready(function(){
$(".changepass").click(function(){
	
$(this).hide();
$("#change").val(1);
$(".password-holder").show();
$(".changepass").show();
return false;
//event.preventDefault();

});
$("#user_form").submit(function(){
var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
var err_msg = "There are some errors on the form. \n";
var err = 0 ;
if( $("#user").val().length == 0 || $("#fname").val().length == 0 || $("#lname").val().length == 0 || $("#email").val().length == 0 || ($("#change").val() == 1 && $("#newpass").val().length == 0))
{
err_msg += "- Some required fields are missing.\n";
err++;
}
if(emailfilter.test($("#email").val()) == false)
{
err_msg += "- Invalid Email address.\n";
err++;
}
if( ($("#change").val() == 1) && ( $("#newpass").val() != $("#newpass1").val() ) )
{
err_msg += "- Passwords didn't match.\n";
err++;
}
if( err > 0 ){
alert(err_msg);
return false;
//event.preventDefault();
}
});
});
</script>
<form id="user_form" action="" method="post">
<?php if(!empty($user)) : ?>

<?php foreach($user as $user) : ?>
<?php  // DOJO 30/11
	 $user_type=$this->session->userdata('user_type');
		if($user_type != 'facebook'){
?>
<input type="hidden" name="id" value="<?=$user->id?>" />

<div class="form-light-holder">
	<h1>Username</h1>
	<input type="text" value="<?=$user->user?>" name="user" id="user" class="field"  placeholder="Enter Username here"/>
</div>

<div class="form-light-holder">
	<h1>Password</h1>
	<button class="changepass">Change Password</button>
	<div style="display: none" class="password-holder">
	<input type="hidden" name="change" id="change" value="0" />
	<input type="text" value="" name="newpass" id="newpass" class="field"  placeholder="Enter new password here"/>
	<input type="text" value="" name="newpass1" id="newpass1" class="field"  placeholder="Repeat new password here"/>
	</div>
</div>
<?php } // end code ?>
<div class="form-light-holder">
	<h1>First Name</h1>
	<input type="text" value="<?=$user->fname?>" name="fname" id="fname" class="field"  placeholder="Enter first name here"/>
</div>

<div class="form-light-holder">
	<h1>Last Name</h1>
	<input type="text" value="<?=$user->lname?>" name="lname" id="lname" class="field"  placeholder="Enter Last Name here"/>
</div>

<div class="form-light-holder">
	<h1>Email Address</h1>
	<input type="text" value="<?=$user->email?>" name="email" id="email" class="field"  placeholder="Enter email address here"/>
</div>

<div class="form-white-holder" style="padding-bottom:20px;">
	<input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />
</div>
</form>



		</div>
		</div>
		</div>
	</div>
	</div>
	<?php endforeach;?>
<?php endif;?>

























	
	</div></div></div>
<br style="clear:both"		 /><br />
<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>
