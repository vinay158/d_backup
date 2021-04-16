<?php 
		
		//echo '<pre>'; print_r($checkedMenu); die;
		
		if(!empty($checkedMenu)){
		$checklist = array();
		
		foreach($checkedMenu as $check){
			
			$checklist[] = $check['page_id'];
			
			}
		}
		//	echo '<pre>'; print_r($test); die;

?>



<?php $this->load->view("admin/include/header"); ?>
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>/css/menu.css" />


<!-- end head contents -->
<!-- wysiwyg editor script -->

<style>
.manager-items .manager-item{
	min-height: 49px !important;
}
.deleteButton{cursor: pointer;
    float: right !important;
    margin-right: -8% !important;
    margin-top: -5% !important;}
	
.editButton{cursor: pointer;
    float: right !important;
    margin-right: -4% !important;
    margin-top: -5% !important;}
	
.editTitleBox{border: 1px solid gray; background: none repeat scroll 0% 0% rgb(230, 230, 230); padding-bottom:6%}

.editMenuTitle{padding-left: 3%;}

.container {
  margin: 50px auto;
  width: 500px;
  text-align: center;
}
.container > .dropdown {
  margin: 0 20px;
  vertical-align: top;
}
			
	
</style>
<script type="text/javascript">
	$(window).load(function(){
		$(".menusName option[value='<?php echo $this->uri->segment(4); ?>']").attr('selected','selected');
	});
	
	$(document).ready(function() {
    $('#selecctall').click(function(event) {  //on click
        if(this.checked) { // check select status
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"              
            });
        }else{
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });        
        }
    });
	
	
	$('.menusName').change(function(){
		var menu_id = $(this).val();
			window.location = "<?=base_url();?>admin/menu/manage/"+menu_id;
	});
   
});
</script>

<div class="az-content-body-left advanced_page custom_full_page menu_manager_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title"><?php echo $title; ?> Manager</h2>
			</div>
			
		  </div>
	  </div>
	   <div class="row row-sm program-cat-page">

          <div class="col-sm-12 col-xl-12 az-content-body-contacts"  >
			<div class="card pd-sm-20 edit-form">
			
<div class="gen-holder">
		<div class="gen-panel">
			<div class="mb-3 main-content-label page_main_heading"><?php echo $title; ?> Manager</div>
<div class="panel-body">
				<div class="panel-body-holder manager">
					<div class="manager-holder">
					<!-- category items -->
					<div id="l_cat_sort" class="manager-categories">
							<h1>Pages </h1>
                            <form method="post" action="admin/menu/manage/<?php echo $this->uri->segment(4); ?>">
							<div class="categories-holder">
							
							<ul style="" class="cat_sort ui-sortable chk-container" id="cat-items">
								<li class="select_all_box"><label class="ckbox"><input type="checkbox" id="selecctall"/><span>Select All</span></label></li>
                            <?php 
								if(!empty($pagesList)){
									foreach($pagesList as $page){
										
										
									
										//foreach($menu as $menus){
							?>
								<li id="menu_25">
								<div id="catid_25" class="categories-link active">
										<!--<a class="show-entries" id="cat25" href="admin/gallery/view/25">Photos</a>-->
									<label class="ckbox"><input class="checkbox1" type="checkbox" name="page_id[]" value="<?php echo $page->id;  ?>" <?php if(!empty($checklist)) { if(in_array($page->id, $checklist)) {echo 'checked="checked"';} } ?>   /><span><?php echo $page->title;  ?></span></label>
										
																				
								</div>
								</li>
                              <?php } } //} ?>
							  </ul>
                              <input type="hidden" name="menu_id" value="<?php echo $this->uri->segment(4); ?>" />
                              
							</div>
							<div>
							<input type="submit" name="save" value="Add To Menu" class="btn-save btn_add_to_menu"  />
							</div>
                            </form>
						</div>
					<!--  End category items -->
						<div class="manager-items">
							<div id="content-replace">
							    
								<h1 id="breadcrumbs"><?php echo $menuDetail[0]['title']; ?>
								
								<span class="selectMenu">Select Menu</span>
								<div class="dropdown">
								  <select name="one" class="dropdown-select menusName field">
									<?php foreach($menus as $menu){ ?>
									<option value="<?php echo $menu['id']; ?>"><?php echo ucfirst($menu['title']); ?></option>
									<?php } ?>
								  </select>
								</div></h1>
								
							
								<div class="cf nestable-lists">

                                    <div class="dd" id="nestable2">
                                    <?php print_menu(0, $this->uri->segment(4)); ?>
                                    </div>
                        
                            </div>
								
								
							</div>
						</div>	
					</div>
					<?php //$this->load->view("admin/include/conf_delete_item"); ?>
					<script language="javascript">
					$(document).ready(function(){
					
					$(".close-btn").click(function(){
					$("#dropdown-holder").slideUp(200);
					$(".delete-holder").slideUp(200);	
					});
																
					//var mod_type1=''; 
					if(typeof($("#mod_type")) === 'undefined' && $("#mod_type")!= null) {								    
						mod_type1 = $("#mod_type").val().toLowerCase();
				    }

					try {
						$(".ui-sortable2").sortable({
						update : function () {
						serial = $('.ui-sortable2').sortable('serialize');
						$.ajax({
						url: "admin/"+mod_type1+"/sortthis",
						type: "post",
						data: serial,
						error: function(){
						alert("theres an error with AJAX");
						}
						});
						}
						});
					} catch(e) {  }
					
					$(".unpublish").click(function(){
						var pub_id = $(this).attr("id").substr(6);
						var mod_type = $("#mod_type").val().toLowerCase();
						var publish_type = $(this).parents(".manager-item-opts").children(".publish_type").val();
						//alert (publish_type);
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
						//exit(0);
					});
					
					$(".delete_item").click(function(){
					var del_item_id = $(this).attr("id").substr(8);
					$("#delete-item-id").val(del_item_id);
					$(".delete-holder-item").hide();
					$(".delete-holder-item").slideDown(300);
					//exit(0);
					});



					
					$("#sortcats").click(function(){
					$(this).hide();
					$("#finishedsorting").show();
					$(".categories-link").each(function(){
					//$(this).children("span").empty();
					$(this).children("span").addClass("handle");
					$(this).children("span").children("a").css("visibility", "hidden");					
					});								
					return true;				
					});
					
					
					$("#finishedsorting").click(function(){											
					$(this).hide();											
					$("#sortcats").show();											
					$(".categories-link").each(function(){
					//$(this).children("span").empty();
					$(this).children("span").removeClass("handle");
					$(this).children("span").children("a").css("visibility", "visible");
					});
					window.location.reload();
					return true;					
					
					});


					
															
					});
					</script>
					

				</div>
			</div> 
		</div>
	</div>
	</div>		

	</div>
</div>

<script type="text/javascript" language="javascript">

$(document).ready(function(){

		
    var updateOutput = function(e)
    {
	
		//console.log(e);return false;
        var list   = e.length ? e : $(e.target),
            output = list.data('output');
        if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize')));
			
			
			 $.ajax({
									 
					   type: "POST",
					 
					   url: '<?=base_url();?>admin/menu/setMenuManager',
					 
					   data: {data:window.JSON.stringify(list.nestable('serialize'))}, // serializes the form's elements.
					 
					   success: function(data)
					   {
						  
					   }
					 
				});
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };



    // activate Nestable for list 2
    $('#nestable2').nestable({
	
       group: 1
	})
	
    .on('change', updateOutput);
	
	

    // output initial serialised data
    updateOutput($('#nestable2').data('output', $('#nestable2-output')));
	
	
	/******** Ajax Delete Menu page *********..*/
	$('.menuPageId').on('click',function(){
		
					  //console.log(2);
			var choise = confirm('Are you sure delete?');
			
			
			if(choise){
					//alert(choise);
			
						
						$.ajax({
									 
					   type: "POST",
					 
					   url: '<?php echo base_url();?>admin/menu/deleteMenuPage?slot_id=' + $(this).attr('number'),
					 
					   data: {id:$(this).attr('number')}, // serializes the form's elements.
					   dataType: 'json',
					   success: function(data){
					   	if(data == '1'){
					   		window.location.reload();
					   	}
					   	
					   	 	 
					   }
					 
				});
				
				}
				
				
					
					
					
	});
	
	
	/****Edit menu page list***...*/
	
	$('.editMenuPage').on('click', function(){
	
			$('#editTitle'+$(this).attr('number')).toggle('slow')
			
			
	});
});
</script>

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

