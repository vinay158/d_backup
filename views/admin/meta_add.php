<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<script language="javascript">
$(document).ready(function(){
var base = $("#base").val();

$("#page").change(function(){
	
var page_url = $(this).val();
//$("#url").val(base+page_url);
$("#url").val(page_url);
});

$("#url").blur(function(){	
	var page_url = $("#page").val();
	var url= $("#url").val();	
	if(url==''){
		alert('Oops! Please select page.');
		$("#page").focus();
		return false;
	}/*else if(!url.match("^"+base+"")){			
		alert('Oops! Entered URL is not proper');
		return false;
	}*/
	return true;	
	
});

});
</script>
<div class="gen-holder">
	<div class="gen-panel-holder" style="width: 100%;">
	<div class="gen-panel">
		<div class="panel-title">
			<div class="panel-title-name">Meta Keywords / URL Rewriting</div>
		</div>
		<div class="panel-body">
		<div class="panel-body-holder">
		<div class="form-holder">
<p style="padding: 0 10px;">
use following variables to replace values<br />
{school_name}<br />
{city}<br />
{state}<br />
{city_state}<br />
{nearby_location1}<br />
{nearby_location2}<br />
{county}<br />
{main_martial_arts_style}<br />
{martial_arts_style}
</p>

<form id="blog_form" action="" method="post">
<input type="hidden" name="base_url" value="<?=base_url()?>" id="base" />
<div class="form-light-holder">
	<h1>Meta Title</h1>
	<input type="text" value="" name="title" id="main_title" class="field"  placeholder="Enter Meta Title here"/>
</div>

<div class="form-light-holder" style="">
	<h1>Meta Description</h1>
	<textarea name="desc" class="textarea" id="frm-text" rows="4" placeholder="Enter Meta Description Here"></textarea>
</div>

<!--<div class="form-light-holder" style="padding-bottom:30px;">
	<h1>Meta Keywords</h1>
	<textarea name="keywords" class="textarea" id="frm-text" rows="4" placeholder="Enter Meta Keywords here. Separate each keywords with comma(,)."></textarea>
</div>-->

<div class="form-light-holder">
	<h1>Page</h1>
	<select name="page" id="page" style="width: 100%">
	<option value="home">Home</option>
	<option value="specialoffers">Special Offers</option>
	<option value="ourschool">Our School</option>
	<option value="ourfacility">Our Facility</option>
	<option value="ourstaff">Our Instructors</option>
	<option value="ourphilosophy">Our Philosophy</option>
	<option value="schoolrules">School Rules</option>
	<option value="faq">FAQ</option>
	<option value="events">Events / Schedule</option>
	<option value="news">News</option>	
	<option value="photogallery" >Photo Gallery</option>
	<option value="videogallery" >Video Gallery</option>
	<option value="ourprograms">Our Programs</option>
	<option value="birthdayparties">Birthday Parties</option>
	<option value="starttrial">Start Trial</option>	
	<option value="contactus">Contact Us</option>
    <option value="testimonials">Testimonials</option>
     <option value="buyspecial">Buy Special</option>
	</select>
</div>

<div class="form-light-holder">
	<h1>URL Rewriting</h1>
	
	
	<?php
	//$bas_url=base_url();
	$url=  isset($meta->url)?$meta->url:'';?>	
	<input type="text" value="<?=$url;?>" name="url" id="url" class="field"  placeholder="URL Rewriting"/>	
	<!--<h2>Please include the before your URL</h2>
--></div>


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
