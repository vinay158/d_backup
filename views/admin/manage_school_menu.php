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

<div class="az-content-body-left advanced_page custom_full_page menu_manager_page school_menu_page" >
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
				<div class="panel-body-holder ">
					<div class="manager-items custom">
					<h1><?php echo $title; ?> Manager 
					
					<?php if(empty($menu)){?>
						<a href="admin/menu/default_rearrange_school_menu/1" class="btn btn-outline-light button_class">Default Re-Arrange School Menu</a> 
					<?php }else{ ?>
						<a href="admin/menu/default_rearrange_school_menu/1/update" class="btn btn-outline-light button_class">Update Menu</a> </h1>
					<?php } ?>
					
					<!--  End category items -->
						<div class="">
							<div id="content-replace">
							    
								
								
								
							
								<div class="cf nestable-lists">

                                    <div class="dd" id="nestable2">
                                    <?php print_school_menu(0, 1); ?>
                                    </div>
                        
                            </div>
								
								
							</div>
						</div>	
					</div>
					<?php //$this->load->view("admin/include/conf_delete_item"); ?>
					

				</div>
			</div> 
		</div>
	</div>
	</div>		

	</div>
</div>

<script type="text/javascript" language="javascript">

$(document).ready(function(){
	$('.dd-item').on('mousedown', function() {
		var list_id = $(this).data('id');
		var parent_id = $(this).data('parent_id');
		
		if(parent_id > 0){
			$.each($('.dd-item'), function(){
				//alert('menu_parent_id'+parent_id);
				$(this).removeClass('menu_parent_id'+parent_id);
			})
		}
		
		//alert(list_id);
		$(this).removeClass('new_school_row'); 
		if(list_id > 0 && parent_id > 0){
			
			 $.ajax({
									 
					   type: "POST",
					 
					   url: '<?=base_url();?>admin/menu/updateIsNewRow',
					 
					   data: {list_id:list_id,parent_id:parent_id}, // serializes the form's elements.
					 
					   success: function(data)
					   {
						 
					   }
					 
				});
		}
});
	
    var updateOutput = function(e)
    {
	
		//console.log(e);return false;
        var list   = e.length ? e : $(e.target),
            output = list.data('output');
        if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize')));
			
			
			 $.ajax({
									 
					   type: "POST",
					 
					   url: '<?=base_url();?>admin/menu/setSchoolMenuManager',
					 
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
	
       group: 1,
	   maxDepth :5
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
					 
					   url: '<?php echo base_url();?>admin/menu/deleteSchoolMenuPage?slot_id=' + $(this).attr('number'),
					 
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

<?php $this->load->view("admin/include/footer");?>

