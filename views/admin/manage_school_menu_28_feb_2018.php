<?php $this->load->view("admin/include/header"); ?>




<!-- end head contents -->
<!-- wysiwyg editor script -->
<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>


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
	
</style>


<div class="gen-holder">
		<div class="gen-panel">
			<div class="panel-title">
				<div class="panel-title-name"><?php echo $title; ?> Manager </div>
			
			</div>
<div class="panel-body">
				<div class="panel-body-holder ">
					<div class="manager-items custom">
					<h1><?php echo $title; ?> Manager 
					
					<?php if(empty($menu)){?>
						<a href="admin/menu/default_rearrange_school_menu/1" class="button_class">Default Re-Arrange School Menu</a> 
					<?php }else{ ?>
						<a href="admin/menu/update_school_menu/1" class="button_class">Update Menu</a> </h1>
					<?php } ?>
					
					<!--  End category items -->
						<div class="">
							<div id="content-replace">
							    
								
								
								<style>
									
								.container {
								  margin: 50px auto;
								  width: 500px;
								  text-align: center;
								}
								.container > .dropdown {
								  margin: 0 20px;
								  vertical-align: top;
								}
								
								.dropdown {
								  display: inline-block;
								  position: relative;
								  overflow: hidden;
								  height: 28px;
								  width: 150px;
								  background: #f2f2f2;
								  border: 1px solid;
								  border-color: white #f7f7f7 #f5f5f5;
								  border-radius: 3px;
								  background-image: -webkit-linear-gradient(top, transparent, rgba(0, 0, 0, 0.06));
								  background-image: -moz-linear-gradient(top, transparent, rgba(0, 0, 0, 0.06));
								  background-image: -o-linear-gradient(top, transparent, rgba(0, 0, 0, 0.06));
								  background-image: linear-gradient(to bottom, transparent, rgba(0, 0, 0, 0.06));
								  -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.08);
								  box-shadow: 0 1px 1px rgba(0, 0, 0, 0.08);
								}
								.dropdown:before, .dropdown:after {
								  content: '';
								  position: absolute;
								  z-index: 2;
								  top: 9px;
								  right: 10px;
								  width: 0;
								  height: 0;
								  border: 4px dashed;
								  border-color: #888 transparent;
								  pointer-events: none;
								}
								.dropdown:before {
								  border-bottom-style: solid;
								  border-top: none;
								}
								.dropdown:after {
								  margin-top: 7px;
								  border-top-style: solid;
								  border-bottom: none;
								}
								
								.dropdown-select {
								  position: relative;
								  width: 130%;
								  margin: 0;
								  padding: 6px 8px 6px 10px;
								  height: 28px;
								  line-height: 14px;
								  font-size: 12px;
								  color: #62717a;
								  text-shadow: 0 1px white;
								  /* Fallback for IE 8 */
								  background: #f2f2f2;
								  /* "transparent" doesn't work with Opera */
								  background: rgba(0, 0, 0, 0) !important;
								  border: 0;
								  border-radius: 0;
								  -webkit-appearance: none;
								}
								.dropdown-select:focus {
								  z-index: 3;
								  width: 100%;
								  color: #394349;
								  outline: 2px solid #49aff2;
								  outline: 2px solid -webkit-focus-ring-color;
								  outline-offset: -2px;
								}
								.dropdown-select > option {
								  margin: 3px;
								  padding: 6px 8px;
								  text-shadow: none;
								  background: #f2f2f2;
								  border-radius: 3px;
								  cursor: pointer;
								}
								
								/* Fix for IE 8 putting the arrows behind the select element. */
								.lt-ie9 .dropdown {
								  z-index: 1;
								}
								.lt-ie9 .dropdown-select {
								  z-index: -1;
								}
								.lt-ie9 .dropdown-select:focus {
								  z-index: 3;
								}
								
								/* Dirty fix for Firefox adding padding where it shouldn't. */
								@-moz-document url-prefix() {
								  .dropdown-select {
									padding-left: 6px;
								  }
								}
								
								.dropdown-dark {
								  background: #444;
								  border-color: #111 #0a0a0a black;
								  background-image: -webkit-linear-gradient(top, transparent, rgba(0, 0, 0, 0.4));
								  background-image: -moz-linear-gradient(top, transparent, rgba(0, 0, 0, 0.4));
								  background-image: -o-linear-gradient(top, transparent, rgba(0, 0, 0, 0.4));
								  background-image: linear-gradient(to bottom, transparent, rgba(0, 0, 0, 0.4));
								  -webkit-box-shadow: inset 0 1px rgba(255, 255, 255, 0.1), 0 1px 1px rgba(0, 0, 0, 0.2);
								  box-shadow: inset 0 1px rgba(255, 255, 255, 0.1), 0 1px 1px rgba(0, 0, 0, 0.2);
								}
								.dropdown-dark:before {
								  border-bottom-color: #aaa;
								}
								.dropdown-dark:after {
								  border-top-color: #aaa;
								}
								.dropdown-dark .dropdown-select {
								  color: #aaa;
								  text-shadow: 0 1px black;
								  /* Fallback for IE 8 */
								  background: #444;
								}
								.dropdown-dark .dropdown-select:focus {
								  color: #ccc;
								}
								.dropdown-dark .dropdown-select > option {
								  background: #444;
								  text-shadow: 0 1px rgba(0, 0, 0, 0.4);
								}
								
								.selectMenu {font-size: 12px;}
								
								.selectMenuDiv {margin-left: 17px;margin-top: 7px;}
								</style>
							
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

<?php $this->load->view("admin/include/footer");?>

