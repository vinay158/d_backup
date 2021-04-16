<?php $this->load->view("admin/include/header"); 
$this->load->helper('url');	
?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<!--<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>-->
<script src="js/ckeditor_full/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		 CKEDITOR.replace(  'ckeditor_mini', 
									{ customConfig : 'mini_config.js' }
							);
							
		 CKEDITOR.replace(  'ckeditor_mini2', 
									{ customConfig : 'mini_config.js' }
							);
	
	});
</script>
<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Add: Featured Program</h2>
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


<script language="javascript">

$(document).ready(function(){
	
		$('.landing_program').change(function(){
			$('.progaramUrl').html($(this).val());
			$('.CatProgaramUrl').html('');
		});
		
		
		
	
	var base_url = '<?=base_url()?>';
	
	$("#main_title").keyup(function(){
		$("#sef_title").html($(this).val());
	})
	
	$("input[name$='type']").click(function(){		
		
		if($(this).attr("value")=="program"){

			$("#advert").hide();

			$("#program").show();

		}

		if($(this).attr("value")=="advertisement"){

			$("#program").hide();

			$("#advert").show();

		}

	});
	
	$(".program_name").change(function()
	{
		/* setting currently changed option value to option variable */		
		//var prg_id = $(this).val();
		//
		
		if($(this).val() != '' || $(this).val() != null){
			$(".landing_program_category option:selected").removeAttr("selected");
			$('.landing_program_category').attr('required', false);
		}
		var program_id = $( ".program_name option:selected" ).attr('number');
		//$('.landing_program_id').val(program_id);
		var prg_id = program_id;
		$('.program_id').val(prg_id);	
				
		$.ajax({
			type: "POST",
			dataType: "json",
			url: base_url+"admin/featuredprograms/getProgram",
			data: { program_id: prg_id }
		})		
		.done(function( obj ) {
			//alert(base_url+obj['photo']);
			//alert( "name: "+obj['name']+'\nsummery: '+obj['featuredSummery']);
			$(".program_title").val(obj['name']);
			$("#program_description").val(obj['ages']);
			if(obj['photo'] == ''){
				$("#photo").attr('required', 'required');
			}else{
				
				//$("#autoloadimg").html('<img src="'+base_url+obj['photo']+'">');
				//$('.old_program_img').val(obj['photo']);	
				$(".photofeature").removeAttr('required');
				
			}
			
		});
	});
	
	
	
	
	
	$("#advert").hide();
	$("#program").show();
	
	
	$('.savefeaturedPro').click(function(){
		var selected_image = $('.photofeature').val();
		if(selected_image != ''){
			$('.old_program_img').val('');	
		}
		
		
	});
})
</script>

<script>
	$(document).ready(function(){
		
	$("#program_category_name").change(function()
	{
		/* setting currently changed option value to option variable */		
		//var prg_id = $(this).val();
		
		if($(this).val() != '' || $(this).val() != null){
			$(".program_name option:selected").removeAttr("selected");
			$('.program_name').attr('required', false);
		}
		var program_id = $( ".landing_program_category option:selected" ).attr('number');
		var category_name = $( ".landing_program_category option:selected" ).attr('category');
		
		//$('.landing_program_id').val(program_id);
		var prg_cat_id = program_id;
		$('.program_cat_id').val(prg_cat_id);	
		
		$('.program_title').val(category_name);
		$('#program_description').val('');	
		$('.CatProgaramUrl').html($(this).val());
		$('.progaramUrl').html('');
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "admin/featuredprograms/getProgramCategory",
			data: { program_cat_id: prg_cat_id }
		})		
		.done(function( obj ) {
			$('#program_title').val(category_name);
			
		});
	});
	
	
	$('#custom_url_checkbox').click(function(){
		if($(this).is(":checked")){
			$('.programDropdownBox').hide();
			$('.custom_url_textbox').show();
			$('#program_category_name').attr('required',false);
			$('#program_name').attr('required',false);
		}else{
			$('.programDropdownBox').show();
			$('.custom_url_textbox').hide();
		}
	})
	
	});
</script>
<div class="mb-3 main-content-label page_main_heading">Add: Featured Program</div>
<div class="form-light-holder  row row-xs align-items-center ">
<div class="col-md-3">
<label class="rdiobox">
	<input type="radio" name="type" id="type" value="program" checked="checked" /><span>Featured program
</span></label>	</div>
<div class="col-md-3">
	<label class="rdiobox">
    <input type="radio" name="type" id="type" value="advertisement" /><span>Advertisement
	</span></label>	
</div>
</div>

<div id="program" style="display: block;">
    <form id="blog_form" action="<?=base_url()?>admin/featuredprograms/add" method="post" enctype="multipart/form-data">
     
<div class="form-light-holder row row-xs align-items-center  programDropdownBox">
	
	<div class="col-md-5 opreationHoursDiv">
	<h1>Select Program</h1>
		<select name="program_url" id="program_name" class="field landing_program program_name"  required="required">
			<option value="">-Select Program-</option>
			<?php foreach($stand_programs as $stand_program){ 
						$cateogry_detail = $this->query_model->getbySpecific('tblcategory','cat_id', $stand_program[0]->category);
						$program_url = '';
						if($stand_program[0]->landing_checkbox == 1){
							if(!empty($stand_program[0]->landing_program)){
								$program_url = $stand_program[0]->landing_program;
							}elseif(!empty($stand_program[0]->landing_page_url)){
								$program_url = $stand_program[0]->landing_page_url;
							}
						}else{
							$program_url = $program_slug.'/'.$cateogry_detail[0]->cat_slug.'/'.$stand_program[0]->program_slug;
						}
			
			?>
				<option number="<?= $stand_program[0]->id ?>" value="<?php echo $program_url; ?>"><?= $stand_program[0]->program ?></option>
			<?php  } ?>
		</select>
		<input type="hidden" name="program_id" class="program_id" value="" />
		<br />
		<p class="progaramUrl"></p>
	</div>	
		
		<div class="col-md-2">
		 <h1 class="opreationHoursDiv"> OR</h1>
		 </div>
		 
		 <div class="col-md-5 opreationHoursDiv">
		 
				<h1>Select Program Category</h1>
				<select name="program_category_url" id="program_category_name" class="field landing_program_category"  required="required">
					<option value="">-Select Program Category-</option>
					<?php foreach($program_categories as $program_category){  
								
								$this->db->where('published', 1);
								$this->db->order_by('id', 'desc');
								$this->db->limit(1);
								$category_pro_id = $this->query_model->getbySpecific('tblprogram', 'category', $program_category->cat_id);
								
								if(!empty($category_pro_id)){
									$program_category_url = $program_slug.'/'.$program_category->cat_slug;
								
					?>
						<option number="<?= $program_category->cat_id ?>" value="<?php echo $program_category_url; ?>" category="<?= $program_category->cat_name ?>"><?= $program_category->cat_name ?></option>
					<?php }  } ?>
				</select>
				<input type="hidden" name="program_cat_id" class="program_cat_id" value="" /><br />
				<p class="CatProgaramUrl"></p>
		</div>
		
	
</div>	

		<div class="form-light-holder">
			<label class="ckbox mg-b-10">
        	<input type="checkbox" id="custom_url_checkbox" name="custom_url_checkbox" value="1" ><span>Custom Url? </span></label>
        </div>
		<div class="form-light-holder custom_url_textbox" style="display:none">
        	<h1>Custom Url</h1>
            <input type="text" value="" name="custom_url"  id="custom_url" class="field custom_url full_width_input" class="field" style="width:90%" placeholder="Enter Custom Url"/>
        </div>

        <div class="form-light-holder">
        	<h1>Program Title</h1>
            <input type="text" value="" name="program_title" id="program_title" class="field program_title full_width_input" required="required" maxlength="20"/>
			<p><i>Character Limit 20 characters</i></p>
        </div>
         <!---- DOJO 30/11 ----->
		<div class="form-light-holder">
        	<h1>Program Description</h1>
            <input type="text"  name="program_description" id="program_description" class="field full_width_input"  maxlength="25"/>
			<p><i>Character Limit 25 characters</i></p>
        </div>       
		<!---- End Code -->
        <!-- <div class="form-light-holder">
        	<h1>URL</h1>
            <input type="text" value="" name="url" id="url" class="field" required="required"/>
        </div> -->
        
        <div class="form-light-holder">
        	<h1>Featured summary</h1>
			<textarea type="text" name="summary" id="ckeditor_mini" class="ckeditor featured_summary" placeholder="Enter your summery here" />Follow this link for a detailed explanation of this featured section of our website.</textarea>
        	<p><i>Character Limit 150 characters</i></p>
    	</div>
        
        <div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
			<div class="adsUrl form-group">
				<h1 style="padding-bottom: 5px;">Choose a Photo</h1>
				<div class="custom-file half_width_custom_file">
						<input type="file" name="userfile" id="customFile1" class="custom-file-input photofeature" accept="image/*"  required="required" />
					<label class="custom-file-label" for="customFile">Choose file</label></div>
					 <p><i>Recommended image size: 370 x 543</i></p>
				<div id="autoloadimg"></div>
			</div>
	
			<div class="linkTarget form-group">
				<h1>Image alt text</h1>
            <input type="text" value="" name="image_alt" id="image_alt" class="field" placeholder="image alt text" />
			</div>
		</div>
        
       
    	
		<input type="hidden" name="old_program_img" class="old_program_img"  />
		<div class="form-white-holder" style="padding-bottom:20px;">           
            <input type="submit" name="update" value="Save" class="btn-save savefeaturedPro" style="float:left;" />
        </div>
    </form>
</div>

<div id="advert">

    <form id="blog_form" action="<?=base_url()?>admin/featuredprograms/addadvert" method="post" enctype="multipart/form-data">

        <div class="form-light-holder">
        	<h1>Title</h1>
            <input type="text" value="" name="title" id="title" class="field full_width_input" required="required" maxlength="25"/>
			<p><i>The program title has a limit of 25 characters</i></p>
        </div>
        
		<div class="form-light-holder">
        	<h1>Description</h1>
        	<input type="text" value="" name="description" id="description" class="field featured_summary" placeholder="Enter your description here" maxlength="32"  />
        	<p><i>The program description has a limit of 32 characters</i></p>
    	</div>
		
        <div class="form-light-holder">
        	<div class="adsUrl">
			<h1>URL</h1>
            <input type="text" value="" name="url" id="url" class="field" required="required"/>
			<p><i>Please include the http:// before your URL</i></p>
			</div>
	
	
			<div class="linkTarget">
			<h1>Link Target</h1>
			<select name="target" id="target" class="field" >
			<option value="_blank" >Blank</option>
			<option value="_self">Self</option>
			</select>
			</div>
			
        </div>
        
        
         <div class="form-light-holder">
        	<h1>Summary</h1>
        	<textarea type="text" name="summary" id="ckeditor_mini2"  class="ckeditor field featured_summary" placeholder="Enter your summery here" maxlength="270" /></textarea>
        	<p><i>The featured summary has a limit of 270 characters</i></p>
    	</div>
        <div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
			<div class="adsUrl form-group">
            <h1 style="padding-bottom: 5px;">Choose a Photo</h1>            
            
			<div class="custom-file half_width_custom_file">
				<input type="file" name="userfile" class="custom-file-input" id="customFile2"  accept="image/*" required="required" />
				<label class="custom-file-label" for="customFile">Choose file</label></div>
				
			<p><i>Image should be at least 690 pixels in width and 608 pixels in height</i></p>
			
			</div>
			<div class="linkTarget form-group">
				
				<h1>Image alt text</h1>
				<input type="text" value="" name="image_alt" id="image_alt" class="field" placeholder="image alt text"/>
			
			</div>
		</div>
        
       
        <!--<div class="form-light-holder">
            <h1>Image description</h1>
            <textarea rows="10" cols="70" name="image_description" id="image_description"></textarea>	
        </div>-->
    
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
<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>
