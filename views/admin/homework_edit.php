<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>	
<div class="gen-holder">
	<div class="gen-panel-holder"  style="width: 100% !important;">
	<div class="gen-panel">
		<div class="panel-title">
			<div class="panel-title-name">Edit Entry</div>
		</div>
		<div class="panel-body">
		<div class="panel-body-holder">
		<div class="form-holder">

<form id="blog_form" action="" method="post" enctype="multipart/form-data">
<script language="javascript">
$(document).ready(function(){
	$("#main_title").keyup(function(){
		$("#sef_title").html($(this).val());
	})
})
</script>
<?php if(!empty($blogdetails)): ?>
<?php foreach($blogdetails as $row): ?>

<div class="form-light-holder">
	<h1>FAQ Title:</h1>
	<input type="text" name="title" value="<?=$row->title?>" id="title" class="input"  />
</div>

<div class="form-light-holder" style="">
	<h1>Question:</h1>
	<!--<textarea name="ques" class="textarea" id="frm-text1"><?=$row->ques;?></textarea>
	--><textarea name="ques" class="ckeditor" id="frm-text1"><?=$row->ques;?></textarea>
</div>

<div class="form-light-holder" style="">
	<h1>Answer:</h1>
	<!--<textarea name="ans" class="textarea" id="frm-text"><?=$row->ans;?></textarea>
	-->
	<textarea name="ans" class="ckeditor" id="frm-text"><?=$row->ans;?></textarea>
</div>
<script language="javascript">
$(document).ready(function(){
$(".form-light-holder .checkbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents(".form-light-holder").children(".hidden_cb").val("0");
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents(".form-light-holder").children(".hidden_cb").val("1");
	}
})
})
</script>
<div class="form-light-holder">
	<a id="published" class="checkbox <?php if($row->published == 1) echo "check-on"; else echo "check-off";?>"></a>
	<h1 class="inline">Publish This</h1>
	<input type="hidden" value="<?=$row->published?>" name="published" class="hidden_cb" />
</div>
<?php endforeach; ?>
<?php endif; ?>
<div class="form-white-holder" style="padding-bottom:20px;">
	<input type="hidden" value="<?=$this->uri->segment(5).'/'.$this->uri->segment(6);?>" name="redirect" class="" />
	<input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />
</div>
</form>
		</div>
		</div>
		</div>
	</div>
	</div>

<br style="clear:both"		 /><br />
<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>