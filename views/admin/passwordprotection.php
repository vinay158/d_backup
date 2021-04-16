<?php $this->load->view("admin/include/header"); ?>

<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->

<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>





<div class="az-content-body-left advanced_page password_setting_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title"><?= $title; ?></h2>
			</div>
			
		  </div>
	  </div>
	   <div class="row row-sm program-cat-page">

          <div class="col-sm-12 col-xl-12 az-content-body-contacts"  >
			<div class="card pd-sm-20 edit-form">

<div class="gen-holder">

	<div class="gen-panel-holder"  style="width: 100% !important;">

	<div class="gen-panel">

		

		<div class="panel-body">

		<div class="panel-body-holder">

		<div class="form-holder">

<div class="mb-3 main-content-label page_main_heading">Edit: <?= $title; ?></div>

<form id="password_form" action="" method="post" enctype="multipart/form-data">

<script language="javascript">
$(window).load(function(){
	
	$('.password_on').hide();
	$('.single_password').hide();
	$('.multiple_password').hide();
	
	if($('.login_check_fields_hidden_cb').val() == 1){
		$('.password_on').show();
	}
	
	
	
	$.each( $( ".password_protection_type" ), function() {
			if($(this).attr('checked') == 'checked'){
				var password_protection_type = $(this).val();
				if(password_protection_type == "single"){
					$('.single_password').show();
					$('.multiple_password').hide();
				}else if(password_protection_type == "multiple"){
					$('.single_password').hide();
					$('.multiple_password').show();
				}
			}
		});
	
	
})

$(document).ready(function(){

	$("#main_title").keyup(function(){

		$("#sef_title").html($(this).val());

	})
	
	$(".login_check_fields .login_check_fields_checkbox").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form-light-holder").children(".login_check_fields_hidden_cb").val("0");

		$('.password_on').hide();
	}

	else{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form-light-holder").children(".login_check_fields_hidden_cb").val("1");
		
		$('.password_on').show();
	}

	});
	
	
	$(".virtual_training .virtual_training_checkbox").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form-light-holder").children(".virtual_training_hidden_cb").val("0");

	}

	else{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form-light-holder").children(".virtual_training_hidden_cb").val("1");

	}

	});
	
	
	$('.password_protection_type').change(function(){
		var password_protection_type = $(this).val();
		if(password_protection_type == "single"){
			$('.single_password').show();
			$('.multiple_password').hide();
		}else if(password_protection_type == "multiple"){
			$('.single_password').hide();
			$('.multiple_password').show();
		}
	})
	
	

})
</script>



<div class="form-light-holder login_check_fields">

        <a id="" class="login_check_fields_checkbox <?php if($setting->login_check_fields ==1){ echo "check-on"; }else { echo "check-off";} ?>"></a>

	<h1 class="inline">Password Protected Student Section</h1>

	<input type="hidden" value="<?php echo $setting->login_check_fields?>" name="login_check_fields" class="login_check_fields_hidden_cb" />

</div>

<div class="password_on" style="display:none">
	<div class="form-light-holder  row row-xs align-items-center ">
	<div class="col-md-3"><h1>Password Protection Type<h1></div>
	<div class="col-md-2">
	<label class="rdiobox">
		<input type="radio" name="password_protection_type" class="password_protection_type" value="single" <?php echo ($detail[0]->password_protection_type == "single") ? 'checked=checked' : ''; ?>><span>One Password 
	</span></label>	</div>
	<div class="col-md-2">
		<label class="rdiobox">
		<input type="radio" name="password_protection_type" class="password_protection_type" value="multiple" <?php echo ($detail[0]->password_protection_type == "multiple") ? 'checked=checked' : ''; ?>><span> Multiple Password
		</span></label>	
	</div>
	</div>

<div class="multiple_password" style="color:red; display:none">
<a href="<?php echo base_url().'admin/onlinedojo_users' ?>">Click here to create your student section user accounts</a>
<?php 
$signup_slug = $this->query_model->getbySpecific('tblmeta', 'id', 55);
$signup_slug = $signup_slug[0];



/*
$getSiteUrl = $this->query_model->getSiteUrl();
if($_SERVER['HTTP_HOST'] == "localhost"){
	$getSiteUrl = base_url();
}else{
	$getSiteUrl = str_replace('http','https',base_url());
}*/
$getSiteUrl = base_url();
$sign_up_url = $getSiteUrl."sign-up?requestAction=Signup_H&originUrl=".$getSiteUrl."&postLogin=".$getSiteUrl.$signup_slug->slug."&rd=true&postSignUp=".$getSiteUrl."new%2Fintro&ps=FW2dWHhET4j2cT9fFpH3nef8H6HNGv6ESNzL5GfP&referralInfoType=Signup_S&overrideLocaleData=en&viewPage=".$signup_slug->slug;
?>
<div class="form-light-holder">
<h1  style="padding-bottom: 5px;">SignUp Url</h1>
<textarea rows="3" style="padding: 10px;" readonly><?php echo $sign_up_url; ?></textarea>
</div>
</div>

<div class="form-light-holder single_password">

	<h1  style="padding-bottom: 5px;">Password</h1>
	<input type="password" name="password" value="<?php if(!empty($detail)){ echo $detail[0]->p_number; } ?>" />

</div>



</div>
<div class="form-light-holder virtual_training">
<h1 class="inline" style="margin-left:0px">Redirect After Login</h1> <br/><br/>
        <a id="" class="virtual_training_checkbox <?php if($detail[0]->virtual_training ==1){ echo "check-on"; }else { echo "check-off";} ?>"></a>

	<h1 class="inline">Virtual Training</h1>

	<input type="hidden" value="<?php echo $detail[0]->virtual_training?>" name="virtual_training" class="virtual_training_hidden_cb" />

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

</div>
</div>
</div>
</div>


<!------------ recent items ----------------->

<?php $this->load->view("admin/include/footer");?>

