<?php $this->load->view("admin/include/header"); ?>

<!---------- end head contents ---------------->


<!---------------wysiwyg editor script ------------>

<!--<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>-->

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->

<!--<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>-->
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js" type="text/javascript"></script>
	
	<script src="color_overlay_opacity_pickier/js/spectrum.js" type="text/javascript"></script>
	<script src="color_overlay_opacity_pickier/js/toc.js" type="text/javascript"></script>
	<script src="color_overlay_opacity_pickier/js/docs.js" type="text/javascript"></script>
	<script src="color_overlay_opacity_pickier/js/prettify.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="color_overlay_opacity_pickier/css/spectrum.css">
<script src="js/ckeditor_full/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		 CKEDITOR.replace(  'ckeditor_mini', 
									{ customConfig : 'config.js' }
							);
	
		
	 CKEDITOR.replace(  'ckeditor_mini_2', 
									{ customConfig : 'config.js' }
							);
		
		
	});
</script>	


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
<div class="az-content-header d-block d-md-flex mg-t-0">

        <div>

        </div>
	
      </div>
<div class="az-content-body-left  advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Add: <?php echo $title; ?></h2>
			</div>
			
		  </div>
	  </div>
	   <div class="row row-sm program-cat-page">

          <div class="col-sm-12 col-xl-12 az-content-body-contacts"  >
			<div class="card pd-sm-20 edit-form">

<div class="gen-holder">

	<div class="gen-panel-holder"  style="width: 100% !important;">

	<div class="gen-panel">

		

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

<div class="mb-3 main-content-label page_main_heading">Add: <?php echo $title; ?></div>
<div class="form-light-holder">

	<h1>Question #1</h1>

	<input type="text" value="" name="title" id="" class="field full_width_input" placeholder="Enter title here"  style="" required/>

</div>



<div class="form-light-holder">

	<h1>Answer #1</h1>

	<textarea type="text" name="description" id="ckeditor_mini" class="field ckeditor full_width_input" placeholder=""  style=""/></textarea>


</div>
 
  
 
<div class="form-light-holder">

	<h1>Question #2</h1>

	<input type="text" value="" name="title_2" id="" class="field full_width_input" placeholder="Enter title here"  style="" required/>

</div>



<div class="form-light-holder">

	<h1>Answer #2</h1>

	<textarea type="text" name="description_2" id="ckeditor_mini_2" class="field ckeditor full_width_input" placeholder=""  style=""/></textarea>

</div>

<div style="clear:both;"/>
<div class="form-white-holder" style="padding-bottom:20px;">

	<input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />

</div>



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
</div>

<script type="text/javascript">

/*
	jQuery Document ready
*/
$(document).ready(function()
{



$("#full_colorpicker_opacity").spectrum({
   color: '',
   
});

$('.btn-save').click(function(){
	var bg_color = $('.sp-thumb-active').data("color");
	//alert(bg_color); return false;
	$('.colourTextValue').val(bg_color);
});
	
	
});
</script>

<!------------ recent items ----------------->

<?php $this->load->view("admin/include/footer");?>

