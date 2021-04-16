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

<div class="form-light-holder">
	<h1>Page</h1>
	<select name="page" id="page" style="width: 100%">
	<option value="home">Home</option>
	<option value="ourschool">Our School</option>
	<option value="ourfacility">Our Facility</option>
	<option value="ourstaff">Our Instructors</option>
	<option value="ourphilosophy">Our Philosophy</option>
	<option value="schoolrules">School Rules</option>
	<option value="faq">FAQ</option>
	<option value="events">Events / Schedule</option>
	<option value="news">News</option>
	<option value="gallery">Gallery</option>
	<option value="ourprograms">Our Programs</option>
	<option value="birthdayparties">Birthday Parties</option>
	<option value="specialoffers">Special Offers</option>
	<option value="contactus">Contact Us</option>
	</select>
</div>

<div class="form-light-holder" style="overflow:auto;">
	<h1 style="padding-bottom: 5px;">Choose a Photo</h1>
	<input type="file" name="userfile" id="photo" accept="image/*" />
		<div>
		</div>
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

<br style="clear:both"		 /><br />
<!------------ recent items ----------------->	
<?php $this->load->view("admin/include/footer");?>
