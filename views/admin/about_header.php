<?php $this->load->view("admin/include/header"); ?>

<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->

<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>

<script language="javascript" type="text/javascript">

jQuery(document).ready(function(){

    $('#headline').keyup(function(e){

            var max = 100;

            var len = $(this).val().length;

            if (len >= max) {

            	e.preventDefault();

                $('#charNum').text(' you have reached the limit');                

                $("#headline").attr('maxlength','45');                            	          

            }else {

                var char = max - len;

                $('#charNum').text( char + ' characters left');

            }

	});



    $('#frm-text').keyup(function(e){

        var max = 500;

        var len = $(this).val().length;

        if (len >= max) {

        	e.preventDefault();

            $('#charNumtblurb').text(' you have reached the limit');                

            $("#frm-text").attr('maxlength','200');                            	          

        }else {

            var char = max - len;

            $('#charNumtblurb').text( char + ' characters left');

        }

});

});





</script>



<div class="gen-holder">

	<div class="gen-panel-holder"  style="width: 100% !important;">

	<div class="gen-panel">

		<div class="panel-title">

			<div class="panel-title-name">Edit About Header</div>

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

/** DOJO 18/11 **/
$("#delete_img_right").click(function(){

		$('#img_right').hide();
		var id=1;
		var photo = 'right_photo';
		var image_path=$('#img_right').attr('src');
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/about/deleteAboutImg',						
		data: { id : id,image_path:image_path,photo:photo}					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			//setTimeout("window.location.href='admin/"+mod_type+"/edit/"+staff_id+"'",1000);
		}
		});

	});
	
	
/** DOJO 18/11 **/
$("#delete_img_left").click(function(){

		$('#img_left').hide();
		var id=1;
		var photo = 'left_photo';
		var image_path=$('#img_left').attr('src');
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/about/deleteAboutImg',						
		data: { id : id,image_path:image_path,photo:photo}					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			
			//setTimeout("window.location.href='admin/"+mod_type+"/edit/"+staff_id+"'",1000);
		}
		});

	});
	

	
})
</script>
<?php if(!empty($pagedetails)): ?>

<?php foreach($pagedetails as $row) : ?>





<div class="form-light-holder">

	<h1>Title</h1>

	<input type="text" value="<?=$row->title;?>" name="title" id="headline" class="field full_width_input" placeholder="Enter title here"  style=""/>

	<span id='charNum'></span>

</div>

<div class="form-light-holder" style="overflow:auto;">
	<h1 style="padding-bottom: 5px;">Choose a Left Photo</h1>
	<?php if(!empty($row->left_photo)): ?>
	<div><img id='img_left' src="<?=base_url().'upload/about_header/'.$row->left_photo;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-left-photo" value="<?=$row->left_photo;?>" />
	<?php endif;?>
	<input type="file" name="left_photo" id="photo_left" accept="image/*" />
	<?php if(!empty($row->left_photo)){ 
			echo "<a href='javascript:void(0);' class='delete_image_btn_new' id='delete_img_left'>Delete image</a>";
			}
	?>	
	
</div>

<div class="form-light-holder" style="overflow:auto;">
	<h1 style="padding-bottom: 5px;">Choose a Right Photo</h1>
	<?php if(!empty($row->right_photo)): ?>
	<div><img id='img_right' src="<?=base_url().'upload/about_header/'.$row->right_photo;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-right-photo" value="<?=$row->right_photo;?>" />
	<?php endif;?>
	<input type="file" name="right_photo" id="photo_right" accept="image/*" />
	<?php if(!empty($row->right_photo)){ 
			echo "<a href='javascript:void(0);' id='delete_img_right'>Delete image</a>";
			}
	?>	
	
</div>






<!-- 

<div class="form-light-holder" style="overflow:auto;">



	<h1 style="padding-bottom: 5px;">Choose a Photo</h1>

	<?php if(!empty($row->photo)): ?>

	<div><img src="<?=$row->photo;?>" style="width: 100px; clear:both;" /></div>

	<input type="hidden" name="last-photo" value="<?=$row->photo;?>" />

	<?php endif;?>

	<input type="file" name="userfile" id="photo" accept="image/*" />

		<div>

		</div>

</div>

-->







<!-- 

<div class="form-light-holder">

	<h1>Bullet Headline</h1>

	<input type="text" value="<?=$row->bulhead?>" name="bulhead" id="bulhead" class="field" placeholder="Enter bullet headline here"/>

</div>



<div class="form-light-holder" style="padding-bottom:30px;">

	<h1  style="padding-bottom: 5px;">Bullet Contents</h1>

	<textarea name="bulcont" class="ckeditor" id="frm-text2"><?=$row->bulcont;?></textarea>

</div>

-->



<div class="form-white-holder" style="padding-bottom:20px;">

	<input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />

</div>

<?php endforeach; ?>

<?php endif; ?>

</form>

		</div>

		</div>

		</div>

	</div>

	</div>

<br style="clear:both" /><br />

<!------------ recent items ----------------->

<?php $this->load->view("admin/include/footer");?>

