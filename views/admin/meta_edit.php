<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<script language="javascript">
$(document).ready(function(){

var base = $("#base").val();

if( $("#url").val().length == 0 )
{
var pgurl = $("#page").val();
$("#url").val(base+pgurl);
}
$("#page").change(function(){

var page_url = $(this).val();
//$("#url").val(base+page_url);
$("#url").val(page_url);
});

//$("#url").focus(function(){
//var page_url = $("#page").val();
//$(this).val(base+page_url);
//});

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
<div class="az-content-body-left  advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Edit Meta URL : <?php echo   isset($meta[0]->page)? ucfirst($meta[0]->page):'';?></h2>
			</div>
			
		  </div>
	  </div>
	   <div class="row row-sm program-cat-page">

          <div class="col-sm-12 col-xl-12 az-content-body-contacts"  >
			<div class="card pd-sm-20 edit-form">
<div class="gen-holder">
	<div class="gen-panel-holder" style="width: 100%;">
	<div class="gen-panel">

		<div class="panel-body">
		<div class="panel-body-holder">
		<div class="form-holder">

<div class="mb-3 main-content-label page_main_heading">Edit: <?php echo   isset($meta[0]->page)?ucfirst($meta[0]->page):'';?></div>

<form id="blog_form" action="" method="post">
<?php if(!empty($meta)) : ?>
<?php foreach($meta as $meta) : ?>
<input type="hidden" name="base_url" value="<?=base_url()?>" id="base" />
<div class="form-light-holder">
	<h1>Meta Title</h1>
	<input type="text" value="<?=$meta->title?>" name="title" id="main_title" class="field full_width_input"  placeholder="Enter Meta Title here"/>
</div>

<div class="form-light-holder" style="">
	<h1>Meta Description</h1>
	<textarea name="desc" class="textarea" id="frm-text" rows="4" placeholder="Enter Meta Description Here"><?=$meta->desc?></textarea>
</div>

<!--<div class="form-light-holder" style="">
	<h1>Meta Keywords</h1>
	<textarea name="keywords" class="textarea" id="frm-text" rows="4" placeholder="Enter Meta Keywords here. Separate each keywords with comma(,)."><?=$meta->keywords?></textarea>
</div>-->

<!-- <div class="form-light-holder">
	<h1>Page</h1>
	<select name="page" id="page" style="width: 100%">
	<option value="home" <?=$meta->page == "home" ? "selected='selected'": "";?>>Home</option>
	<option value="about" <?=$meta->page == "about" ? "selected='selected'": "";?>>About Us</option>
		
		<option value="blogs" <?=$meta->page == "blogs" ? "selected='selected'": "";?>>Blogs</option>
		
		<option value="promo" <?=$meta->page == "promo" ? "selected='selected'": "";?>>Promo</option>
		<option value="schools" <?=$meta->page == "schools" ? "selected='selected'": "";?>>School</option>
		<option value="pages" <?=$meta->page == "pages" ? "selected='selected'": "";?>>Page</option>
		<option value="studentsection" <?=$meta->page == "studentsection" ? "selected='selected'": "";?>>Student Section</option>
		
	<option value="specialoffers" <?=$meta->page == "specialoffers" ? "selected='selected'": "";?>>Special Offers</option>
	<option value="ourschool" <?=$meta->page == "ourschool" ? "selected='selected'": "";?>>Our School</option>
	<option value="ourfacility" <?=$meta->page == "ourfacility" ? "selected='selected'": "";?>>Our Facility</option>
	<option value="ourstaff" <?=$meta->page == "ourstaff" ? "selected='selected'": "";?>>Our Instructors</option>
	<option value="ourphilosophy" <?=$meta->page == "ourphilosophy" ? "selected='selected'": "";?>>Our Philosophy</option>
	<option value="schoolrules" <?=$meta->page == "schoolrules" ? "selected='selected'": "";?>>School Rules</option>
	<option value="faq" <?=$meta->page == "faq" ? "selected='selected'": "";?>>FAQ</option>
	<option value="events" <?=$meta->page == "events" ? "selected='selected'": "";?>>Events / Schedule</option>
	<option value="news" <?=$meta->page == "news" ? "selected='selected'": "";?>>News</option>
	<option value="photogallery" <?=$meta->page == "photogallery" ? "selected='selected'": "";?>>Photo Gallery</option>
	<option value="videogallery" <?=$meta->page == "videogallery" ? "selected='selected'": "";?>>Video Gallery</option>
	<option value="ourprograms" <?=$meta->page == "ourprograms" ? "selected='selected'": "";?>>Our Programs</option>
	<option value="birthdayparties" <?=$meta->page == "birthdayparties" ? "selected='selected'": "";?>>Birthday Parties</option>
	<option value="starttrial" <?=$meta->page == "starttrial" ? "selected='selected'": "";?>>Start Trial</option>	
	<option value="contactus" <?=$meta->page == "contactus" ? "selected='selected'": "";?>>Contact Us</option>
    <option value="testimonials" <?=$meta->page == "testimonials" ? "selected='selected'": "";?>>Testimonials</option>
        <option value="buyspecial" <?=$meta->page == "buyspecial" ? "selected='selected'": "";?>>Buy Special</option>
		
		
	</select>
</div>

<div class="form-light-holder">
	<h1>URL Rewriting</h1>
		
	<?php
	$url=  isset($meta->url)?$meta->url:'';?>	
	<input type="text" value="<?=$url;?>" name="url" id="url" class="field"  placeholder="URL Rewriting"/>
	</div> --->

<div class="form-light-holder" >
<p class="p_tag_heading" style="margin-left:0px">
Use following variables to replace values<br />
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
