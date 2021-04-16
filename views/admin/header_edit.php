<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<div class="gen-holder">
	<div class="gen-panel-holder"  style="width: 100% !important;">
	<div class="gen-panel">
		<div class="panel-title">
			<div class="panel-title-name">Add Entry</div>
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
<?php if(!empty($con)) : ?>
<?php foreach($con as $con) : ?>
<div class="form-light-holder">
	<h1>Page</h1>
	<select name="page" id="page" style="width: 100%">
	<option value="home" <?=$con->url == "home" ? "selected='selected'" : "";?>>Home</option>
	<option value="ourschool" <?=$con->url == "ourschool" ? "selected='selected'" : "";?>>Our School</option>
	<option value="ourfacility" <?=$con->url == "ourfacility" ? "selected='selected'" : "";?>>Our Facility</option>
	<option value="ourstaff"  <?=$con->url == "ourstaff" ? "selected='selected'" : "";?>>Our Instructors</option>
	<option value="ourphilosophy"  <?=$con->url == "ourphilosophy" ? "selected='selected'" : "";?>>Our Philosophy</option>
	<option value="schoolrules"  <?=$con->url == "schoolrules" ? "selected='selected'" : "";?>>School Rules</option>
	<option value="faq"  <?=$con->url == "faq" ? "selected='selected'" : "";?>>FAQ</option>
	<option value="events"  <?=$con->url == "events" ? "selected='selected'" : "";?>>Events / Schedule</option>
	<option value="news"  <?=$con->url == "news" ? "selected='selected'" : "";?>>News</option>
	<option value="gallery"  <?=$con->url == "gallery" ? "selected='selected'" : "";?>>Gallery</option>
	<option value="ourprograms"  <?=$con->url == "ourprograms" ? "selected='selected'" : "";?>>Our Programs</option>
	<option value="birthdayparties"  <?=$con->url == "birthdayparties" ? "selected='selected'" : "";?>>Birthday Parties</option>
	<option value="specialoffers"  <?=$con->url == "specialoffers" ? "selected='selected'" : "";?>>Special Offers</option>
	<option value="contactus"  <?=$con->url == "contactus" ? "selected='selected'" : "";?>>Contact Us</option>
	</select>
</div>
<input type="hidden" name="last-photo" value="<?=$con->photo?>" />
<div class="form-light-holder" style="overflow:auto;">
	<h1 style="padding-bottom: 5px;">Choose a Photo</h1>
	<?php if(!empty($con->photo)): ?>
	<div><img src="<?=$con->photo;?>" style="width: 100px; clear:both;" /></div>
	<?php endif;?>
	<input type="file" name="userfile" id="photo" accept="image/*" />
		<div>
		</div>
</div>
<?php endforeach;?>
<?php endif;?>
<div class="form-white-holder" style="padding-bottom:20px;">
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
