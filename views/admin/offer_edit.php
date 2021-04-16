<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
    <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
    <!--<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>-->
    <link rel="stylesheet" href="/resources/demos/style.css" />
	
	<script src="js/ckeditor_full/ckeditor.js"></script>
	
	
    <script>
    $(function() {
        $( ".datepicker" ).datepicker({ dateFormat: "yy-mm-dd" });

    });
    </script>
    <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
    <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
    <link rel="stylesheet" href="/resources/demos/style.css" />
    <script>
    $(function() {
        $( "#start" ).datepicker({ dateFormat: "yy-mm-dd" });

    });
    $(function() {
        $( "#expire" ).datepicker({ dateFormat: "yy-mm-dd" });

    });
    </script>
	

<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Edit: Referral Reward</h2>
			</div>
			
		  </div>
	  </div>
	   <div class="row row-sm program-cat-page">

          <div class="col-sm-12 col-xl-12 az-content-body-contacts"  >
			<div class="card pd-sm-20 edit-form">
			
<div class="gen-holder">
	<div class="gen-panel-holder" style="width: 100%">
	<div class="gen-panel">
		
		<div class="panel-body">
		<div class="panel-body-holder">		
		<div class="form-holder">
<div class="mb-3 main-content-label page_main_heading">Edit: Referral Reward</div>
<form id="blog_form" action="" method="post" enctype="multipart/form-data">
<?php if(!empty($details)): ?>
<?php foreach($details as $details):?>
<div class="form-light-holder">
	<h1>Coupon Name</h1>
	<input type="text" value="<?=$details->name?>" name="name" id="name" class="field full_width_input" placeholder="Enter coupon name here"/>
</div>
<!--<div class="form-light-holder">
	<h1>Special Offer</h1>
	<textarea name="offer" class="field" rows="2" placeholder="Your special offer"><?=$details->offers?></textarea>
</div>-->
<div class="form-light-holder" style="">
	<h1>Offer Description</h1>
	<!--<textarea id="frm-text" name="desc" class="textarea" rows="4" placeholder="Your offer description"><?=html_entity_decode($details->desc);?></textarea>
	--><textarea id="frm-text" name="desc" class="ckeditor" rows="4" placeholder="Your offer description"><?=$details->desc;?></textarea>
</div>
<div class="form-light-holder   d-md-flex  dual_input">

	<div class="adsUrl form-group">
		<h1>Start Date</h1>
		<input type="text" value="<?=$details->start?>" name="start" id="start" class="field datepicker" placeholder="mm/dd/yyyy" maxlength="10"/>
	</div>
	
	<div class="linkTarget form-group">
		<h1>Expiration Date</h1>
		<input type="text" value="<?=$details->expire?>" name="expire" id="expire" class="field datepicker" placeholder="mm/dd/yyyy" maxlength="10"/>
	</div>
</div>
<div class="form-light-holder">
	<h1>Upload Photo</h1>
		<div class="custom-file half_width_custom_file">
			
			<input type="file" name="userfile" class="custom-file-input"  id="customFile1" accept="image/*" />
		<label class="custom-file-label" for="customFile">Choose file</label></div>
	<?php if(!empty($details->photo)): ?>
	<div><img id="img" src="<?=$details->photo;?>" style="width: 100px; clear:both;" /></div>
	<input type="hidden" name="last-photo" value="<?=$details->photo;?>" />
	<?php endif;?>
	
	<input type="hidden" value="<?=$details->id?>" name="offer_id" id="offer_id" >
	<?php if($details->photo){ 
			echo "<a href='javascript:void(0);' class='delete_image_btn_new'  id='delete_img'>Delete image</a>";
			}
	?>
</div>
<div class="form-white-holder" style="padding-bottom:20px;">
	<input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />
	
	
</div>
<?php endforeach;?>
<?php endif; ?>
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

<script language="javascript">
$(document).ready(function(){	

	$("#delete_img").click(function(){
				
		var offer_id=$('#offer_id').val();
		var image_path=$('#img').attr('src');
		//alert(offer_id); return false;		
		var mod_type = 'offers';
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/'+mod_type+'/delete_offer_image',						
		data: { offer_id: offer_id,image_path:image_path }					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			setTimeout("window.location.href='admin/"+mod_type+"/edit/"+offer_id+"'",1000);
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});

	});

	
})
</script>
<!------------ recent items ----------------->	
<?php $this->load->view("admin/include/footer");?>