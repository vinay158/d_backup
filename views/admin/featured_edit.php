<?php $this->load->view("admin/include/header"); ?>
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
	
	});
</script>
<script>
	$(window).load(function(){
		$('.progaramUrl').html($('.landing_program').val());
			
			if($('.program_name').val() != ''){
				$('.landing_program_category').attr('required', false);
			}
			
			if($('.landing_program_category').val() != ''){
				$('.program_name').attr('required', false);
			}
			
			
		if($('#custom_url_checkbox').is(":checked")){
			$('.programDropdownBox').hide();
			$('.custom_url_textbox').show();
			$('#program_category_name').attr('required',false);
			$('#program_name').attr('required',false);
		}else{
			$('.programDropdownBox').show();
			$('.custom_url_textbox').hide();
		}
		
	});
	$(document).ready(function(){
		$('.landing_program').change(function(){
			$('.progaramUrl').html($(this).val());
			$('.CatProgaramUrl').html('');
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
		$('.program_cat_id').val(0);	
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "admin/featuredprograms/getProgram",
			data: { program_id: prg_id }
		})		
		.done(function( obj ) {
			//alert(base_url+obj['photo']);
			//alert( "name: "+obj['name']+'\nsummery: '+obj['featuredSummery']);
			$(".program_title").val(obj['name']);
			$("#program_description").val(obj['ages']);
			/*if(obj['photo'] == ''){
				$("#photo").attr('required', 'required');
			}else{
				
				//$("#autoloadimg").html('<img src="'+base_url+obj['photo']+'">');
				//$('.old_program_img').val(obj['photo']);	
				$(".photofeature").removeAttr('required');
				
			}*/
			
		});
	});
	
	
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
		$('.program_id').val(0);
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

<div class="az-content-body-left  advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Edit: Featured Program</h2>
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

<div class="mb-3 main-content-label page_main_heading">Edit: Featured Program</div>


		
	 <?php if($detail['p_type'] == 'program'){ ?>	

		<div class="form-light-holder row row-xs align-items-center programDropdownBox">
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
					<option number="<?= $stand_program[0]->id ?>" value="<?php echo $program_url; ?>" <?php if($detail['program_id'] == $stand_program[0]->id){ echo 'selected=selected'; } ?>><?= $stand_program[0]->program ?></option>
				<?php  } ?>
			</select>
				<input type="hidden" name="program_id" class="program_id" value="<?php if(!empty($detail['program_id'])){ echo $detail['program_id']; } ?>" />
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
				<option number="<?= $program_category->cat_id ?>" value="<?php echo $program_category_url; ?>" category="<?= $program_category->cat_name ?>" <?php if($detail['program_cat_id'] == $program_category->cat_id){ echo 'selected=selected'; } ?>><?= $program_category->cat_name ?></option>
			<?php }  } ?>
		</select>
		<input type="hidden" name="program_cat_id" class="program_cat_id" value="<?php if(!empty($detail['program_cat_id'])){ echo $detail['program_cat_id']; } ?>" />
		<br />
		<p class="CatProgaramUrl"></p>
		
		
	
		  </div>
</div>		


	
	<?php } ?>

 <?php if($detail['p_type'] == 'program'){ ?>
	<div class="form-light-holder">
	<label class="ckbox mg-b-10">
        	<input type="checkbox" id="custom_url_checkbox" name="custom_url_checkbox" value="1" <?php echo ($detail['custom_url_checkbox'] == 1) ? 'checked=checked' : ''?>><span>Custom Url? </span></label>
        </div>
		<div class="form-light-holder custom_url_textbox">
        	<h1>Custom Url</h1>
            <input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($detail['custom_url'])?>" name="custom_url"  id="custom_url" class="field custom_url" class="field custom_url full_width_input" style="width:90%" placeholder="Enter Custom Url"/>
        </div>
 <?php } ?>
		
		<div class="form-light-holder">
        	<h1>Program Title</h1>
            <input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($detail['program_title'])?>" name="program_title"  id="program_title" class="field program_title full_width_input"required="required" maxlength="20"/>
			<p><i>Character Limit 20 characters</i></p>
        </div>
		
		
        
		<!---- DOJO 30/11 ----->
		<div class="form-light-holder">
        	<h1>Program Description</h1>
            <input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($detail['program_description']);?>" name="program_description" id="program_description" class="field full_width_input" maxlength="25"/>
			<p><i>Character Limit 25 characters</i></p>
        </div>
		
		<!---- End Code -->      
		<!---- End Code -->
		
       <?php if($detail['p_type'] == 'advert'){ ?>
        <div class="form-light-holder">
        	<div class="adsUrl">
			<h1>URL</h1>
            <input type="text" value="<?=$detail['url']?>" name="url" id="url" class="field" required="required"/>
			<p><i>Please include the http:// before your URL</i></p>
			</div>
	
	
			<div class="linkTarget">
			<h1>Link Target</h1>
			<select name="target" id="target" class="field" >
			<option value="_blank"  <?=$detail['target'] == "_blank" ? "selected='selected'" : ""; ?>>Blank</option>
			<option value="_self" <?=$detail['target'] == "_self" ? "selected='selected'" : ""; ?>>Self</option>
			</select>
			</div>
			
        </div>
       <?php } ?>
        
        
        <div class="form-light-holder">
        	<h1>Featured summary</h1>
        	<textarea type="text" name="summary" id="ckeditor_mini" class="ckeditor featured_summary" placeholder="Enter your summery here" /><?=$detail['summary']?></textarea>
        	<p><i>Character Limit 150 characters</i></p>
    	</div>
        
        <div class="form-light-holder  d-md-flex  dual_input" style="overflow:auto;">
		<div class="adsUrl form-group">
            <h1 style="padding-bottom: 5px;">Choose a Photo</h1>
			<div class="custom-file half_width_custom_file">
					<input type="file" name="userfile"  class="custom-file-input" id="customFile1"  accept="image/*" />
				<label class="custom-file-label" for="customFile">Choose file</label></div>
				<p><i>Recommended image size: 370 x 543</i></p>
            <?php
				$base_url = base_url();
				
				if(!empty($detail['photo'])){
					echo '<img src="'.$base_url.$detail['photo_thumb'].'"  class="thumbImg" style="width:100px"/>';
				}
			?>
            </div>
	
			<div class="linkTarget form-group">
				<h1>Image alt text</h1>
				<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($detail['image_alt']);?>" name="image_alt" id="image_alt" class="field" placeholder="image alt text"/>
			</div>
           
		</div>
        
              

	<!--<input type="hidden" name="program_id" id="program_id"  value="<?=$program_id?>" />-->
	<input type="submit" name="update" value="Save" class="btn-save savefeaturedPro" style="float:left;" />
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


<?php $this->load->view("admin/include/footer");?>