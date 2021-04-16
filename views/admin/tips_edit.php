<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
    <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>    

	<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>	
    <link rel="stylesheet" href="/resources/demos/style.css" />
    
    <script language="javascript">
	$(document).ready(function(){
		
	$(".form-light-holder .checkbox").click(function(){
		if($(this).hasClass("check-on")){
			$(this).removeClass("check-on");
			$(this).addClass("check-off");
			$(this).parents(".form-light-holder").children(".hidden_cb").val("off");
		}
		else
		{
			$(this).removeClass("check-off");
			$(this).addClass("check-on");
			$(this).parents(".form-light-holder").children(".hidden_cb").val("on");
		}
	});
	
	});


    </script>
    
<div class="gen-holder">
	<div class="gen-panel-holder" style="width: 100%">
	<div class="gen-panel">
		<div class="panel-title">
			<div class="panel-title-name">Edit Entry</div>
		</div>
		<div class="panel-body">
		<div class="panel-body-holder">
		<div class="form-holder">

<form id="blog_form" action="" method="post" enctype="multipart/form-data">


<div class="form-light-holder">
	<a id="published" class="checkbox <?php if($details->published=="on") echo "check-on"; else echo "check-off";?>"></a>
	<h1 class="inline">Publish This</h1>
	<input type="hidden" value="<?=$details->published?>" name="feature" class="hidden_cb" />
</div>


<div class="form-light-holder">
	<h1>Heading 1</h1>
	<input type="text" value="<?=($details->heading1)?>" name="heading1" id="heading1" maxlength="82"/>
</div>
<div class="form-light-holder">
	<h1>Heading 2</h1>
	<input type="text" name="heading2" value="<?=($details->heading2)?>" id="heading2" maxlength="61"/>
</div>
<div class="form-light-holder" style="">
	<h1>Description</h1>
		<textarea id="frm-text" name="description" class="ckeditor" placeholder="Your description" ><?=($details->description);?></textarea>
	</div>

<div class="form-light-holder">
	<h1><strong>"Get Tips" Email Settings</strong></h1>
</div>

<div class="form-light-holder">
	<h1>Subject</h1>
	<input type="text" value="<?=$details->email_subject?>" name="email_subject" id="email_subject" class="field"/>
</div>

<div class="form-light-holder" style="">
    <h1>Email Body</h1>	
    <textarea id="frm-text" name="email_body" class="ckeditor" placeholder="Email Body" ><?=$details->email_body;?></textarea>
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
	</div></div></div>
<br style="clear:both"		 /><br />
<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>