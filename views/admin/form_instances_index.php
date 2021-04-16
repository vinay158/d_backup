<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script language="javascript">
	/** DOJO 19/11 **/
	
	$(window).load(function(){
		var location_id = $('.contactLocation').length;
		if(location_id >= 1){
					
					var mod_type = $("#mod_type").val().toLowerCase();
					$.ajax({ 					
					type: 'POST',						
					url: 'admin/'+mod_type+'/makeMainLocation',						
					data: { location_id :location_id}					
					}).done(function(msg){ 
					/*$("#success_message").html("<b>Successfully change main location.</b>");
						setTimeout(function() {
							$('#success_message').fadeOut('slow');
						}, 3000);*/
					
					});		
				
		}
	});
			$(document).ready(function(){
			
			$(".main_location").click(function(){
				
				var answer = confirm ("Are you Sure you want to change theme?");
				if (answer){		
					var theme_id = $(this).attr("number");
						
					var mod_type = $("#mod_type").val().toLowerCase();
					$.ajax({ 					
					type: 'POST',						
					url: 'admin/'+mod_type+'/selectMainTheme',						
					data: { theme_id :theme_id}					
					}).done(function(msg){ 
					/*$("#success_message").html("<b>Successfully change main location.</b>");
						setTimeout(function() {
							$('#success_message').fadeOut('slow');
						}, 3000);*/
					
					$("#success_message").html("<b>Successfully change theme.</b>");
						setTimeout(function() {
							$('#success_message').fadeOut('slow');
						}, 3000);
					});		
				}
				else{		
					return false;
				}
				
				});
			})
			</script>



			
<script language="javascript">
$(document).ready(function(){


$(".unpublish").click(function(){
	
	var pub_id = $(this).attr("id");
	var mod_type = $("#mod_type").val();
	var publish_type = $(this).parents(".manager-item-opts").children(".publish_type").val();
	
	$.ajax({ 					
	type: 'POST',						
	url: 'admin/'+mod_type+'/publish',						
	data: { pub_id : pub_id, publish_type: publish_type }					
	}).done(function(msg){ 
	if(msg != null){
	//alert(msg);
	setTimeout("window.location.reload()",1000);
	}
	else{
	setTimeout('$("#alert-holder").html("<div><b class=red>Unable to Unpublish.</b></div>")',1000);
	//alert(msg);
	}
	});
	return false;
});


// DOJO 19/11
$(".delete_item").click(function(){
	
	//return false;
	var del_item_id = $(this).attr("number");
	$("#delete-item-id").val(del_item_id);
	$(".delete-holder-item").hide();
	$(".delete-holder-item").slideDown(300);
	
})
})
</script>
<script language="javascript">
					$(document).ready(function(){
						$(".addcats").click(function(){
						$("#dropdown-holder").hide();
						$(".delete-holder").hide();	
						$("#dropdown-holder").slideDown(200);
						$(".drop-add-title").html("Duplicate Form");
						$("#form_title").val($(this).attr('title'));
						$("#form_id").val($(this).attr('id'));
						$(".sef_title").html("");
						$("#shared").removeClass("check-on");
						$("#shared").addClass("check-off");
						$("#shared-id").val(0);
						$("#operation").val("add");
						$(".btn-delete").hide();
						});
					});
					</script>
					
<div class="az-content-body-left advanced_page form_instances_page" >

       <div class="row row-sm">

          <div class="col-sm-12 col-xl-12"  >
			<div class="card pd-sm-20 program-cat-page program-detail-page">
				<div class="container">
	  
	  
        
    <div class="az-content az-content-app az-content-contacts pd-b-0">
      <div class="container">
        <div class="az-content-left az-content-left-contacts">


         <div class="az-mail-header">
            <div>
              <h4 class="az-content-title mg-b-5">Sections</h4>
			   
				  
            </div>
            <div>
			
			
			</div>
          </div>
		
		<?php $page_url = ''; ?>
          <div id="azContactList" class="az-contacts-list">
			
			<?php
				if(!empty($form_types)){ 
					foreach($form_types as $form_type){
			?>
			<a href="<?php echo $page_url; ?>#<?php echo $form_type->type; ?>" class="az-contact-item">
              <div class="az-contact-body">
                <h6><?php echo $form_type->name; ?></h6>
              </div>
            </a>
			<?php } } ?>
			
			
          </div><!-- az-contacts-list -->

        </div> <!-- az-content-left -->
        <div class="az-content-body az-content-body-contacts">
			
				<div class="az-mail-header">
            <div>
              <h4 class="az-content-title mg-b-5"><?=$title?> Manager</h4>
            </div>
            
          </div>
				
				<div class=" edit-form edit_form_box">
			
<div class="gen-holder"  style="display:flex !important">

	<div class="gen-panel-holder"  style="width: 100% !important;">

	<div class="gen-panel">

		
		<div class="panel-body">

		<div class="panel-body-holder">

		<div class="form-holder">

			
<form id="blog_form" class="" action="" method="post">

<?php 
	if(!empty($form_types)){ 
		foreach($form_types as $form_type){
?>

		<div class="page-section" id="<?php echo $form_type->type; ?>">
		<div class="mb-3 main-content-label"><?php echo $form_type->name; ?></div>
		
		<?php 
			if(!empty($pages_list[$form_type->type])){
				$i = 0;
				foreach($pages_list[$form_type->type] as $url => $page_name){
					//$url = '/starttrial/buyspecial~4:/trial-offer/children';
					$mainUrl = $url;
					$pageViewUrl = $url;
					$mainUrlData = explode(':',$url);
					//echo '<pre>mainUrlData'; print_r($mainUrlData); die;
					$mainUrl = (isset($mainUrlData[0]) && !empty($mainUrlData[0])) ? $mainUrlData[0] : $url;
					$pageViewUrl = (isset($mainUrlData[1]) && !empty($mainUrlData[1])) ? $mainUrlData[1] : $url;
					
					
					$pageData = explode('~',$url);
					if(isset($pageData[1]) && !empty($pageData[1])){
						$actionData = explode(':',$pageData[1]);
						if(isset($actionData[0]) && !empty($actionData[0])){
							$action_id = $actionData[0];
						}
						
					}else{
						$action_id = 0;
					}
					
					
					$url = $pageData[0];
					
					if($action_id > 0){
						$this->db->where("action_id",$action_id);
					}
					$this->db->where("page_url",$url);
					$exitResult = $this->query_model->getbySpecific('tbl_form_instances', 'form_type_id',$form_type->id);
					$selected_form_module = !empty($exitResult) ? $exitResult[0]->form_module_id : 0;	
		?>
				<div class="form-light-holder  d-md-flex  dual_input <?php echo ($selected_form_module == 0) ? 'notconnected_form_instance' :''; ?>">
					<div class="adsUrl  form-group">
						<h1><?php echo $page_name; ?></h1>
						<p class="form-module-page-instances"><?php echo $pageViewUrl; ?></p>
					</div>
					<div class="linkTarget  form-group">
						
						<?php if(!empty($form_modules[$form_type->type])){ ?>
							<select class="field" name="data[<?php echo $form_type->id; ?>][<?php echo $i; ?>][form_module_id]">
							<?php if($selected_form_module == 0){ ?>
								<option value="">-Select Form -</option>
							<?php } ?>
								<?php foreach($form_modules[$form_type->type] as $form_module){	?>
									<option value="<?php echo $form_module->id; ?>" <?php echo ($selected_form_module == $form_module->id) ? "selected=selected" : ''; ?>><?php echo $form_module->name; ?></option>
								<?php } ?>
							</select>
							
							<input type="hidden" name="data[<?php echo $form_type->id; ?>][<?php echo $i; ?>][page_name]" value="<?php echo strip_tags($page_name); ?>">
							<input type="hidden" name="data[<?php echo $form_type->id; ?>][<?php echo $i; ?>][page_url]" value="<?php echo $mainUrl; ?>">
							<input type="hidden" name="data[<?php echo $form_type->id; ?>][<?php echo $i; ?>][form_type_id]" value="<?php echo $form_type->id; ?>">
							<input type="hidden" name="data[<?php echo $form_type->id; ?>][<?php echo $i; ?>][action_id]" value="<?php echo $action_id; ?>">
						<?php } ?>
					
					</div>
					
				</div>
			<?php $i++; } } ?>
				</div>		
		
	<?php } } ?>
	
				
				
				</div>
				</div>
				</div>
				</div>
				</div>
				</div>
				</div>
				

	<div class="tx-center pd-y-20 bg-gray-200 submit_btn_box" id="bottom" > 
				
				<!--<input type="submit" name="update" value="Save" class=" save_program_form btn btn-az-primary saveProgramButton" /> -->
				
				<input type="hidden" name="mod_type" value="<?=$link_type;?>" id="mod_type" />
				<input name="submit" value="Save" class="btn-save saveProgramButton"  type="submit">
				</div>
	</div>
	




	
				</form>
				</div>
				</div>
				</div>
				</div>
				</div>
				
				

			
			</div>
        </div><!-- az-content-body -->
      </div></div>
    </div><!-- az-content -->
</div>
				
			</div>
			
      	
			
     </div>
<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>

<script>

	
	 new PerfectScrollbar('#azContactList', {
	  suppressScrollX: true
	});
		
		
	 var nav = $('.az-content-left-contacts');

    $(window).scroll(function () {
        if ($(this).scrollTop() > 125) {
            nav.addClass("f-nav");
        } else {
            nav.removeClass("f-nav");
        }
    });
	
	$('.az-contact-item').on('click touch', function() {
         

	  $('body').addClass('az-content-body-show');
	})      
	
	$('.az-contact-item').on('click touch', function() {
		var selected_href = $(this).attr('href');
		setTimeout(function() {
			
			$.each($('.az-contact-item'), function(){
				//alert(selected_href+'==>'+$(this).attr('href'));
				if($(this).attr('href') == selected_href){
					$(this).addClass('selected');
				}else{
					$(this).removeClass('selected');
				}
			})
		}, 1000);
	});

</script>
