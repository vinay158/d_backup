
<link rel="stylesheet" type="text/css" media="screen" href="../../css/admin/dropdown.css" />
<!-----
<link rel="stylesheet" type="text/css" media="screen" href="../../css/admin/login-style.css" />
----->
<div id="dropdown-holder" class="dropdown-edit" style="display: none">
  <div class="dropdown-panel">
    <div class="dropdown-title">
      <div style="float:left;" class="drop-add-title">Add Dojocart Product</em></div>
      <div class="btn-close"><a class="close-btn"></a></div>
    </div>
	<script language="javascript">
	$(document).ready(function(){
		$("#operateform").submit(function(){
			if($("#cat_title").val().length <= 0 &&  $("#cat_title").val()!=undefined ){
			event.preventDefault();
			}
		});
	});
	</script>

		<div class="dropdown-body">
		    <form action="admin/<?=$link_type?>/saveDojoCartTemplate" method="post" id="operateform" onSubmit="javascript:return testUrlForMedia(this);">
			
			<div class="form-item">
			<h1>Select Template</h1>
			<?php $templates = array('default' => 'Products Template', 'events' => 'Events Template', 'tournaments' => 'Tournaments Template','ata_cr_xma' => 'ATA CR XMA Template','tiger_blank' => 'Tiger Blank Template','novice_blank' => 'Novice Blank Template','traditional_blank' => 'Traditional Blank Template','multi_item_dojocart'=>'Multi Item Dojocart'); ?>
			<select name="dojo_cart_template" id="dojo_cart_template" style="width: 100%;">
				<?php foreach($templates as $key => $val): ?>
				<option value='<?=$key?>'><?=$val?></option>
				<?php endforeach;?>
				</select>
			</div>
			<hr>
			<div class="form-item">
				<script language="javascript">
				$(document).ready(function(){
					$("#album-cover").click(function(){
						if($(this).hasClass("check-on"))
						{
							$(this).removeClass("check-on").addClass("check-off");
							$("#album-cover-val").val("0");
						}
						else
						{
							$(this).removeClass("check-off").addClass("check-on");
							$("#album-cover-val").val("1");
						}
					})
				})
				</script>
				
			</div>
		</div>
		<div class="dropdown-bottom">
			<input type="submit" name="submit" value="Save" class="btn-save" style="float:left;">
			
			<script language="javascript">
			$(document).ready(function(){
				$("#delete").click(function(){
					$(this).parents("#dropdown-holder").slideToggle(300);
					$(".delete-holder").hide();
					$(".delete-holder").slideDown(300);
					$("#delete-id").val($("#edit_id").val());
				});
			});
			
			</script>
		
    </form>
		</div>
	</div>
</div>

