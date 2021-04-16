<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>	
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
<script src="http://websitedojo.com/demo/dynamic_ele.js"></script>

<!-- <script src="http://localhost/websitedojo/dynamic_ele.js"></script> -->

<link rel="stylesheet" href="/resources/demos/style.css" />
<script>
$(function() {
	$( "#date1" ).datepicker({ dateFormat: "yy-mm-dd",altFormat: 'yy/mm/dd',altField:'#date_hidden1'});

});
</script>
<div class="gen-holder">
	<div class="gen-panel-holder" style="width: 100%">
	<div class="gen-panel">
		<div class="panel-title">
			<div class="panel-title-name">Edit Exception [<?php echo date_format(date_create($details[0]->mydate), 'F d, Y').' '.$details[0]->start.' - '.$details[0]->end.' '.$details[0]->repeat; ?>]</div>
		</div>
		<div class="panel-body">
		<div class="panel-body-holder">
		<div class="form-holder">

<form id="blog_form" action="" method="post" onSubmit="javascript:return date_validate();">
<?php if(!empty($details)): ?>

<?php foreach($details as $details): ?>

<div class="form-light-holder">
	<h1>Event Title</h1>
	<input type="text" value="<?=$details->title;?>" name="title" id="main_title" class="field" placeholder="Enter your event title here" disabled="disabled" />
</div>

<?php if(!empty($exceptions)) :?>
<div>
<ul>
<?php
	foreach($exceptions as $excp){
?>
	<li><?php echo date_format(date_create($excp->exception_date), 'F d, Y'); ?>&nbsp;
    	<a href="admin/calendar/delete_exception/<?=$excp->id.'/cal/'.$this->uri->segment(4)?>">Remove</a>
    </li>
<?php
	}
?>
</ul>
</div>
<?php endif; ?>
<div class="form-light-holder">
	<h1>Date</h1>

	<input type="text" value="" name="date1" id="date1" class="field" placeholder="mm/dd/yyyy" maxlength="10"/>
	<input type="hidden" value="" name="date_hidden1" id="date_hidden"   maxlength="10"/>	
</div>

<div style="clear:both;"></div>    
<div style="float: right; margin: 10px;"><input type="button" value="Add More Exceptions" id="addexception" /></div>

<div style="clear:both"></div>    
    
<span id="dyn_content"></div>
<div style="clear:both"></div> 

<div class="form-light-holder" style="padding-bottom:30px;">	
    <textarea name="text" class="ckeditor" id="frm-text"><?=$details->exception_text;?></textarea>
</div>

<div class="form-white-holder" style="padding-bottom:20px;">
	<input type="hidden" name="counter" id="counter" value="1" />
	<input type="hidden" value="<?=$this->uri->segment(5).'/'.$this->uri->segment(6);?>" name="redirect" class="" />
	<input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />
</div>
<?php endforeach;?>
<?php endif;?>
</form>
		</div>
		</div>
		</div>
	</div>
	</div>

	</div></div></div>
<br style="clear:both"		 /><br />

<script>
$(document).ready(function(){	
	<?php if($details->isWhole){ ?>
			$("#allday").change();
		<?php } ?>

});
</script>
<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>

