<?php $this->load->view("admin/include/header"); ?>

<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->
<script src="js/new/jquery.maskMoney.js"></script>


<script language="javascript" type="text/javascript"></script>


<div class="az-content-body-left  advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title"><?php echo $title; ?></h2>
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


<div class="mb-3 main-content-label">Email Opt-in</div>

<div class="form-light-holder">
	<a id="published" class="checkbox1 <?php echo (!empty($pagedetails) && $pagedetails[0]->show_full_form == 1) ? 'check-on' : 'check-off'; ?>"></a>

	<h1 class="inline">Show Full Form </h1>

	<input type="hidden" value="<?php echo (!empty($pagedetails) && $pagedetails[0]->show_full_form == 1) ? 1 : 0; ?>" name="show_full_form" class="hidden_cb1" />

</div>

<div class="form-light-holder">

	<h1>Opt-In Title</h1>
	<input type="text" value="<?php echo (!empty($pagedetails) && !empty($pagedetails[0]->title)) ? $this->query_model->getStrReplaceAdmin($pagedetails[0]->title) : ''; ?>" name="title" id="" class="field full_width_input" placeholder=""  style=""/>
</div>

<div class="form-light-holder">

	<h1>Opt-In Text</h1>
	<input type="text" value="<?php echo (!empty($pagedetails) && !empty($pagedetails[0]->text)) ? $this->query_model->getStrReplaceAdmin($pagedetails[0]->text) : ''; ?>" name="text" id="" class="field full_width_input" placeholder=""  style=""/>
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

