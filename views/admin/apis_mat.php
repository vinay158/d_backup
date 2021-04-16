<!-- end head contents -->

<!---wysiwyg editor script -->

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->

<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>

<script language="javascript">
$(window).load(function(){
	if($('#mat .hidden_cb').val() == 0){
		$('#mat .DetailBox').hide();
		$('#mat .matFields').attr('required',false);
	}else{
		
		$('#mat .matFields').attr('required',true);
	}
	
	
	if($('#mat .multi_mat_hidden_cb').val() == 1){
		$('#mat .DetailBoxInfo').hide();
		$('#mat .MultiClubId').show();
		$('#mat .matFields').attr('required',false);
	}else{
		$('#mat .MultiClubId').hide();
	}
});
$(document).ready(function(){
$("#mat .form-light-holder1 .checkbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents("#mat .form-light-holder1").children("#mat .hidden_cb").val("0");
		$('#mat .DetailBox').hide();
		$('#mat .multi_kicksite_hidden_cb').val(0);
		$('#mat .multi_kicksite_checkbox').removeClass("check-on");
		$('#mat .multi_kicksite_checkbox').addClass("check-off");
		$('#mat .matFields').attr('required',false);
		
		$(this).parents("#mat .multi_mat").children("#mat .multi_mat_hidden_cb").val("0");
		$('#mat .multi_mat_checkbox').removeClass("check-on");
		$('#mat .multi_mat_checkbox').addClass("check-off");
		
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents("#mat .form-light-holder1").children("#mat .hidden_cb").val("1");
		$('#mat .DetailBox').show();
		$('#mat .matFields').attr('required',true);
		
		
	}
	
	
})



$("#mat .multi_mat .multi_mat_checkbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents("#mat .multi_mat").children("#mat .multi_mat_hidden_cb").val("0");
		
		$('#mat .MultiClubId').hide();
		if($("#mat .hidden_cb").val() == 1){
			$('#mat .DetailBoxInfo').show();
			$('#mat .matFields').attr('required',true);
		}else{
			$('#mat .DetailBoxInfo').hide();
			$('#mat .matFields').attr('required',false);
		}
		
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents("#mat .multi_mat").children("#mat .multi_mat_hidden_cb").val("1");
		$('#mat .DetailBoxInfo').hide();
		$('#mat .matFields').attr('required',false);
		$('#mat .MultiClubId').show();
	}
})

})
</script>
<?php $mat_result = $this->query_model->getbyTable("tbl_mat_api"); 
	if(!empty($mat_result) && !empty($mat_result[0]->url) && $mat_result[0]->type == 1){
?>
<script>

 var apiInfo = {                
                baseAddr: "<?php echo $mat_result[0]->url ?>",
                token: ""
            };

            $(function(){

                console.log("authentication");

                doLogin();

            });          

            function doLogin() {

                var loginData = {
                    grant_type: 'password',
                    username: '<?php echo $mat_result[0]->username ?>',
                    password: '<?php echo $mat_result[0]->password ?>'                    
                };

                $.ajax({
                    type: 'POST',
                    url: apiInfo.baseAddr + 'Token',
                    data: loginData
                }).done(function (e) {
                    console.dir(e);
					apiInfo.token = e.access_token;
				//	alert(apiInfo.token);
					// getting categories from map api
					var mat_categories = getCategories();
					 
                }).fail(function (x, s, e) {
                    console.log("error: " + e);
                });
            }
			
			
			function getCategories() {

                var headers = getHeaders();

                $.ajax({
					url: apiInfo.baseAddr + "api/Lookup/Categories?clubId=<?php echo $mat_result[0]->club_id ?>",
                    headers: headers,
                    type: 'get',
                    dataType: 'json'
					
                }).done(function (e) {
                    console.dir(e);
					$('.map_cat_text').show();
                   // default category
				    var $default_cat_id = $("#default_cat_id");
					var cat_contant = '';
					cat_contant += '<h1>Default Category ID</h1><select class="field" name="default_cat_id"><option value="">-Select MAT Category-</option>';
					var selected_default = "<?php echo (isset($apis_mat['detail']->default_cat_id)) ? $apis_mat['detail']->default_cat_id : ''; ?>"
						$.each(e, function(index,data) {
							if(data.id == selected_default){
								cat_contant += '<option value="'+data.id+'" selected="selected">'+data.displayText+'</option>';
							}else{
								cat_contant += '<option value="'+data.id+'">'+data.displayText+'</option>';
							}
						});
						cat_contant += '</select>';	
					$default_cat_id.append(cat_contant);
						
				   
				   // map categories
					var $mat_categories = $("#mat_categories");
					var map_contant = '';
					<?php 
					$selected_cats = (isset($apis_mat['detail']->map_categories) && !empty($apis_mat['detail']->map_categories)) ? unserialize($apis_mat['detail']->map_categories) : '';
					$selectedCatArr = array();
					if(!empty($selected_cats)){
						foreach($selected_cats as $cat){
							$selectedCatArr[$cat['dojo_cat_id']] = $cat['mat_cat_id'];
						}
					}
					
						/*$this->db->select(array('cat_id','cat_name'));
						$this->db->where('published',1);
						$dojo_cats = $this->query_model->getBySpecific('tblcategory','cat_type','programs');*/
						
						$dojo_programs = $this->query_model->getBySpecific('tblprogram','published',1);
						
						if(!empty($dojo_programs)){
							foreach($dojo_programs as $program){
								
								$selected_mat_cat = (isset($selectedCatArr[$program->id]) && !empty($selectedCatArr[$program->id])) ? $selectedCatArr[$program->id] : '';
					?>
			map_contant += "<div class='form-new-holder  d-md-flex  dual_input'><div class='adsUrl form-group'><input value='<?php echo str_replace("'",'',$program->program); ?>' class='field' type='text'  readonly='readonly'><input value='<?php echo $program->id; ?>' name='mat_cats[<?php echo $program->id; ?>][dojo_cat_id]' class='field' type='hidden'></div>";
					
					
						map_contant += '<div class="linkTarget form-group"><select class="field" name="mat_cats[<?php echo $program->id; ?>][mat_cat_id]"><option value="">-Select MAT Category-</option>';
						$.each(e, function(index,data) {
							if(data.id == '<?php echo $selected_mat_cat ?>'){
								map_contant += '<option value="'+data.id+'" selected="selected">'+data.displayText+'</option>';
							}else{
								map_contant += '<option value="'+data.id+'">'+data.displayText+'</option>';
							}
						});
						map_contant += '</select></div></div>';	
						<?php } } ?>
						
						
						
						$mat_categories.append(map_contant);

                }).fail(function (x, s, e) {

                    console.log("error: " + e);
                });
            }

			
			function getHeaders() {
                
                var headers = {};
                if (apiInfo.token) {
                    headers.Authorization = 'Bearer ' + apiInfo.token;
                }
                return headers;
            }
</script>
	<?php } ?>


		<div class="panel-body" id="mat">

		<div class="panel-body-holder">

		<div class="form-holder">



<form id="blog_form" action="<?php echo base_url(); ?>admin/apis_manager/apis_mat" method="post" enctype="multipart/form-data">



<?php
	$checkbox_check = 'check-off';
	$multi_mat_check = 'check-off';
	
	if(!empty($apis_mat['detail'])){
		if($apis_mat['detail']->type == 1){
			$checkbox_check = 'check-on';
		}else{
			$checkbox_check = 'check-off';
		}
		
		if($apis_mat['detail']->multi_mat_check == 1){
			$multi_mat_check = 'check-on';
		}else{
			$multi_mat_check = 'check-off';
		}
		
		
	}
	
	
?>


<div class="form-light-holder1  form-new-holder">
	<a id="published" class="checkbox <?php echo $checkbox_check; ?> " ></a>
	<h1 class="inline">MAT Api</h1>
	<input type="hidden" value="<?php if(!empty($apis_mat['detail'])){ echo $apis_mat['detail']->type; } else{ echo 0; }?>" name="type" class="hidden_cb" />
</div>
<?php if($multi_location[0]->field_value == 1){ ?>
<div class="form-light-holder2 multi_mat  form-new-holder">
	<a id="published" class="multi_mat_checkbox <?php echo $multi_mat_check; ?> " ></a>
	<h1 class="inline">MAT Api for each location?</h1>
	<input type="hidden" value="<?php if(!empty($apis_mat['detail'])){ echo $apis_mat['detail']->multi_mat_check; } else{ echo 0; }?>" name="multi_mat_check" class="multi_mat_hidden_cb" />
</div>
<?php } ?>

<div  class="DetailBox">
<div class="  form-new-holder">
	<h1>Api Mode</h1>
	<input type="radio" value="testing" name="api_mode" class=""  <?php echo (empty($apis_mat['detail']->api_mode) || $apis_mat['detail']->api_mode == "testing") ? 'checked=checked' : ''; ?>> Testing<br>
	<input type="radio" value="production" name="api_mode" class=""   <?php echo ($apis_mat['detail']->api_mode == "production") ? 'checked=checked' : ''; ?> > Production
</div>


<div class="  form-new-holder">
	<h1>URL</h1>
	<input type="text" value="<?php if(!empty($apis_mat['detail'])){ echo $apis_mat['detail']->url; }?>" name="url" class="field matFields" placeholder="Enter Your URL"  />
</div>
<div class="  form-new-holder">
	<h1>Username</h1>
	<input type="text" value="<?php if(!empty($apis_mat['detail'])){ echo $apis_mat['detail']->username; }?>" name="username" class="field matFields" placeholder="Enter Your Username"  />
</div>

<div class="  form-new-holder">
	<h1>Password</h1>
	<input type="text" value="<?php if(!empty($apis_mat['detail'])){ echo $apis_mat['detail']->password; }?>" name="password" class="field matFields" placeholder="Enter Your Password"  />
</div>

<div  class="MultiClubId">
<?php 
	if(!empty($allContacts)){
		foreach($allContacts as $contact){
			$selectedRecord = !empty($apis_mat['detail']->location_club_id) ? unserialize($apis_mat['detail']->location_club_id) : '';
			
?>
	<div class="  form-new-holder">
		<h1>Club ID- <?php echo $contact->name; ?></h1>
		<input type="text" value="<?php echo isset($selectedRecord[$contact->id]) ? $selectedRecord[$contact->id] : ''; ?>" name="location_club_id[<?php echo $contact->id; ?>]" class="field" placeholder="Enter <?php echo $contact->name; ?> Location Club Id"  />
		<br/>
	</div>
<?php 			
		}
	}
?>
</div>

<div  class="DetailBoxInfo">
<div class="  form-new-holder">
	<h1>Club ID</h1>
	<input type="text" value="<?php if(!empty($apis_mat['detail'])){ echo $apis_mat['detail']->club_id; }?>" name="club_id" class="field matFields" placeholder="Enter Your Club ID"  />
</div>

 
<!--<div class="">
	<h1>Default Category ID</h1>
	<input type="text" value="<?php if(!empty($apis_mat['detail'])){ echo $apis_mat['detail']->default_cat_id; }?>" name="default_cat_id" class="field matFields" placeholder="Enter Your Default Club ID"  /></div>-->
<div id="default_cat_id">

</div>	
	

<div class="map_cat_text " style="display:none">
	<div class="adsUrl ">
		<h1>Dojo Programs</h1>
		</div>
	<div class="linkTarget ">
		<h1>MAT Api Categories</h1>
	</div>
</div>
<div id="mat_categories">

</div>
</div>

</div>


<div class="form-white-holder   form-new-holder">

	<input type="submit" name="mat_update" value="Save" class="btn-save"  />

</div>

</form>

		</div>

		</div>

		</div>
		
		<div style="clear:both"></div>	
