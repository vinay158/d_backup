<?php $this->load->view("admin/include/header"); ?>

<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->
<script src="js/new/jquery.maskMoney.js"></script>
<script src="js/ckeditor_full/ckeditor.js"></script>

<script language="javascript" type="text/javascript">

jQuery(document).ready(function(){

    $('#headline').keyup(function(e){

            var max = 200;

            var len = $(this).val().length;

            if (len >= max) {

            	e.preventDefault();

                $('#charNum').text(' you have reached the limit');                

                $("#headline").attr('maxlength','99');                            	          

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


 $(document).ready(function () {
 		
	  // $(".usd_input").maskMoney({thousands:'', decimal:'.', allowZero:true, suffix: '',symbolPosition : 'right'});
	  
	  $(".usd_input").maskMoney({
prefix:' ', // The symbol to be displayed before the value entered by the user
allowZero:false, // Prevent users from inputing zero
allowNegative:true, // Prevent users from inputing negative values
defaultZero:false, // when the user enters the field, it sets a default mask using zero
thousands: '', // The thousands separator
decimal: '.' , // The decimal separator
precision: 2, // How many decimal places are allowed
affixesStay : false, // set if the symbol will stay in the field after the user exits the field.
symbolPosition : 'right' // use this setting to position the symbol at the left or right side of the value. default 'left'
}); //
	 
	 
	 
$('.number').keypress(function(event) {
  if ((event.which != 46 || $(this).val().indexOf('.') != -1) &&
    ((event.which < 48 || event.which > 57) &&
      (event.which != 0 && event.which != 8))) {
    event.preventDefault();
  }

  var text = $(this).val();

  if ((text.indexOf('.') != -1) &&
    (text.substring(text.indexOf('.')).length > 2) &&
    (event.which != 0 && event.which != 8) &&
    ($(this)[0].selectionStart >= text.length - 2)) {
    event.preventDefault();
  }
});
	 
	  
    });





</script>

<!--<input type="text" autocomplete="off" class="number" name="dollar_amt" placeholder="Enter number">-->

<div class="gen-holder">

	<div class="gen-panel-holder"  style="width: 100% !important;">

	<div class="gen-panel">

		<div class="panel-title">

			<div class="panel-title-name">Add Welcome Text</div>

		</div>

		<div class="panel-body">

		<div class="panel-body-holder">

		<div class="form-holder">



<form id="blog_form" action="" method="post" enctype="multipart/form-data">

<script language="javascript">

$(window).load(function(){
	$.each( $( ".image_video" ), function() {
		if($(this).attr('checked') == 'checked'){
			var radio_button_value = $(this).val();
	
			if(radio_button_value == "image"){
				$('.welcome_video').hide();
			}
			if(radio_button_value == "video"){
				$('.welcome_image').hide();
			}
		}
	});
	
	var videoType = $('select.videoType option:selected').val();
	
	if(videoType == "youtube_video"){
		$('.vimeo_video').hide();
		$('.youtube_video').show();
		$('.orButton').hide();
	}
	if(videoType == "vimeo_video"){
		$('.youtube_video').hide();
		$('.vimeo_video').show();
		$('.orButton').hide();
	}
	
	
});

$(document).ready(function(){

	$("#main_title").keyup(function(){

		$("#sef_title").html($(this).val());

	})

/** DOJO 18/11 **/
$("#delete_img").click(function(){

		$('#img').hide();
		var id=1;
		var image_path=$('#img').attr('src');
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/home/deleteAboutImg',						
		data: { id : id,image_path:image_path }					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			//setTimeout("window.location.href='admin/"+mod_type+"/edit/"+staff_id+"'",1000);
		}
		
		});

	});
	
$('.image_video').click(function(){
	var radio_button_value = $(this).val();
	
	if(radio_button_value == "image"){
		$('.welcome_video').hide();
		$('.welcome_image').show();
	}
	if(radio_button_value == "video"){
		$('.welcome_image').hide();
		$('.welcome_video').show();
	}
});
	
	
$('.videoType').change(function(){
	var videoType = $(this).val();
	
	if(videoType == "youtube_video"){
		$('.vimeo_video').hide();
		$('.youtube_video').show();
		$('.orButton').hide();
	}
	if(videoType == "vimeo_video"){
		$('.youtube_video').hide();
		$('.vimeo_video').show();
		$('.orButton').hide();
	}
});
	
})
</script>
<?php if(!empty($pagedetails)): ?>

<?php foreach($pagedetails as $row) : ?>



<!-- <div class="form-light-holder">

	<h1>Title</h1>

	<input type="text" value="<?=$row->title?>" name="title" id="title" class="field" placeholder="Enter tab title here"/>

</div> -->



<div class="form-light-holder">

	<h1>Headline</h1>

	<textarea type="text" name="headline" id="headline" class="field ckeditor headline full_width_input" placeholder="Enter headline here"  style=""/><?=$row->headline?></textarea>

	<span id='charNum'></span>

</div>
<div class="form-light-holder">

	<h1>Image Or Video</h1>

	<input type="radio" class="image_video" name="image_video" value="image" <?php if($row->image_video == 'image'){ echo 'checked=checked'; }?>  /> Image <br />
	<input type="radio" class="image_video" name="image_video" value="video" <?php if($row->image_video == 'video'){ echo 'checked=checked'; }?> /> Video

</div>

<div class="welcome_image">
<div class="form-light-holder" style="overflow:auto;">
	<div class="adsUrl">
	<h1 style="padding-bottom: 5px;">Choose a Photo</h1>
	<?php if(!empty($row->photo)): ?>
	<div><img id='img' src="<?=base_url().'upload/welcome_text/'.$row->photo;?>" style="width: 150px; clear:both;" /></div>
	<input type="hidden" name="last-photo" value="<?=$row->photo;?>" />
	<?php endif;?>
		
		<input type="file" name="userfile" id="photo" accept="image/*" />
		
		<?php if(!empty($row->photo)){ 
				echo "<a href='javascript:void(0);' id='delete_img'>Delete image</a>";
				}
		?>	
		<p><i>Image should be at least 525 pixels in width</i></p>
		</div>
		<div class="linkTarget">
		<h1>Image alt text</h1>
	<input type="text" value="<?php echo $row->image_alt; ?>" name="image_alt" id="image_alt" class="field" placeholder="image alt text"/>
		</div>
		<div>
		</div>
</div>

<div class="form-light-holder">
	
</div>
</div>



<div class="form-light-holder welcome_video">
	<div class="adsUrl">
		<h1>Video Type</h1>
		<select name="video_type" id="" class="field videoType" >
		<option value="youtube_video" <?php if($row->video_type == 'youtube_video'){ echo 'selected=selected'; } ?>>Youtube Video</option>
		<option value="vimeo_video" <?php if($row->video_type == 'vimeo_video'){ echo 'selected=selected'; } ?>  >Vimeo Video</option>
	</select>
	
	</div>
	<div class="linkTarget">
	<div class="youtube_video">
	<h1>Youtube Video</h1>
	<input type="text" name="youtube_video" value="<?=$row->youtube_video;?>" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://www.youtube.com/embed/UWCbfxwwC-I
	</div>
	</div>
	<span class="orButton">OR</span>
	<div class="vimeo_video">
	<h1>Vimeo Video</h1>
	<input type="text" name="vimeo_video" value="<?=$row->vimeo_video;?>" class="field" >
	<div style="font-style:italic;font-size:11px;margin-left:12px;">
		eg. http://player.vimeo.com/video/17054419
	</div>
	</div>
	</div>
	
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



<div class="form-light-holder">

	<h1  style="padding-bottom: 5px;">Text Blurb</h1>

	<textarea name="text" id="frm-text"  class="ckeditor" rows="10" cols="70"><?=$row->content?></textarea>

	<span id='charNumtblurb'></span>

</div>



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

