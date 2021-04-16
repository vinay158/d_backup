<?php $this->load->view("admin/include/header"); ?>

<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->
<script src="js/new/jquery.maskMoney.js"></script>


<script language="javascript" type="text/javascript"></script>


<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Email Opt-ins</h2>
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



<form id="blog_form" action="" method="post" enctype="multipart/form-data">




<script language="javascript">

$(document).ready(function(){

$(".form-light-holder .checkbox1").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form-light-holder").children(".hidden_cb1").val("0");

		
	}

	else

	{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form-light-holder").children(".hidden_cb1").val("1");
	}

})

})

</script>

<div class="mb-3 main-content-label page_main_heading">About Us Email Opt-in #1</div>

<div class="form-light-holder">

	<h1>Opt-In Text</h1>
	<input type="text" value="<?php echo (!empty($pagedetails) && !empty($pagedetails[0]->opt1_text)) ? $this->query_model->getStrReplaceAdmin($pagedetails[0]->opt1_text) : 'Enter your Email to View Current Web-Specials & Pricing'; ?>" name="opt1_text" id="" class="field full_width_input" placeholder=""  style=""/>
</div>

<div class="form-light-holder">
	<a id="published" class="checkbox1 <?php echo (!empty($pagedetails) && $pagedetails[0]->show_full_form_1 == 1) ? 'check-on' : 'check-off'; ?>"></a>

	<h1 class="inline">Show Full Form </h1>

	<input type="hidden" value="<?php echo (!empty($pagedetails) && $pagedetails[0]->show_full_form_1 == 1) ? 1 : 0; ?>" name="show_full_form_1" class="hidden_cb1" />

</div>




<script language="javascript">

$(document).ready(function(){

$(".form2checkbox .checkbox2").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form2checkbox").children(".hidden_cb2").val("0");

		
	}

	else

	{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form2checkbox").children(".hidden_cb2").val("1");
	}

})





$(".form3checkbox .checkbox3").click(function(){
	if($(this).hasClass("check-on")){
		
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents(".form3checkbox").children(".hidden_cb3").val("0");
		$(".checkbox2").addClass("check-off");
		$(".checkbox2").removeClass("check-on");
		$(".hidden_cb2").val("0");
	}else{

		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents(".form3checkbox").children(".hidden_cb3").val("1");
	}

})

})

</script>
<br/>
<div class="mb-3 main-content-label page_main_heading">About Us Email Opt-in #2</div>

<div class="form-light-holder form3checkbox">

	<a id="published" class="checkbox3 <?php echo (!empty($pagedetails) && $pagedetails[0]->show_email_opt_form == 1) ? 'check-on' : 'check-off'; ?>"></a>

	<h1 class="inline">Show Email Opt-in Form?</h1>

	<input type="hidden" value="<?php echo (!empty($pagedetails) && $pagedetails[0]->show_email_opt_form == 1) ? 1 : 0; ?>" name="show_email_opt_form" class="hidden_cb3" />

</div>

<div class="form-light-holder">

	<h1>Opt-In Title</h1>
	<input type="text" value="<?php echo (!empty($pagedetails) && !empty($pagedetails[0]->opt1_text)) ? $this->query_model->getStrReplaceAdmin($pagedetails[0]->opt_2_title) : 'Limited Trial Offers Available'; ?>" name="opt_2_title" id="" class="field full_width_input" placeholder=""  style=""/>
</div>

<div class="form-light-holder">

	<h1>Opt-In Text</h1>
	<input type="text" value="<?php echo (!empty($pagedetails) && !empty($pagedetails[0]->opt1_text)) ? $pagedetails[0]->opt_2_text : 'If you want to avoid paying regular pricing or missing out, <br>this is your chance to try our martial arts program for a ridiculously low price<br><strong>TAKE ACTION NOW!</strong>'; ?>" name="opt_2_text" id="" class="field full_width_input" placeholder=""  style=""/>
</div>

<div class="form-light-holder form2checkbox">

	<a id="published" class="checkbox2 <?php echo (!empty($pagedetails) && $pagedetails[0]->show_full_form_2 == 1) ? 'check-on' : 'check-off'; ?>"></a>

	<h1 class="inline">Show Full Form </h1>

	<input type="hidden" value="<?php echo (!empty($pagedetails) && $pagedetails[0]->show_full_form_2 == 1) ? 1 : 0; ?>" name="show_full_form_2" class="hidden_cb2" />

</div>





<div class="form-white-holder" style="padding-bottom:20px;">
	<input type="hidden" name="location_id" value="<?php echo $location_id; ?>">
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

