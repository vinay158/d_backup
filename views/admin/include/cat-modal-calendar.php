<link rel="stylesheet" type="text/css" media="screen" href="../../css/admin/dropdown.css" />
<!-----
<link rel="stylesheet" type="text/css" media="screen" href="../../css/admin/login-style.css" />
----->

<div id="dropdown-holder" style="display: none">
  <div class="dropdown-panel">
    <div class="dropdown-title">
      <div style="float:left;" class="drop-add-title">Edit Category <em>ID# 1</em></div>
      <div class="btn-close"><a class="close-btn"></a></div>
    </div>
	<script language="javascript">
	$(document).ready(function(){
		$("#operateform").submit(function(){
			if($("#cat_title").val().length <= 0){
			event.preventDefault();
			}
		});
	});
	</script>

		<div class="dropdown-body">
		    <form action="admin/<?=$link_type?>/operateCategory" method="post" id="operateform">
			<div class="form-item">
				<h1>Title</h1>
				<input type="hidden" name="edit_id" id="edit_id" value="0" />
				<input type="text" name="name" id="cat_title" class="field" value="">
				<!--<div style="margin-bottom:10px;">
					Title will appear in the URL as: <em class="sef_title"></em>
				</div>-->				
				</div>
						<hr>
			<div class="form-item">
				<h1>Color</h1>
				<select  name="color" id="cat_color" style="width:100%; padding:3px;" >
				<option value="blue">blue</option>
				<option value="yellow">yellow</option>
				
				<option value="green">green</option>
				<option value="orange">orange</option>
				<option value="gray">gray</option>
				<option value="pink">pink</option>
				<option value="purple">purple</option>
				<option value="brown">brown</option>
				<option value="red">red</option>
				<option value="violet">violet</option>
				
				<option value="light_blue">light blue</option>
				<option value="light_yellow">light yellow</option>
				<option value="light_green">light green</option>
				<option value="light_orange">light orange</option>
				<option value="light_gray">light gray</option>
				<option value="light_pink">light pink</option>
				<option value="light_purple">light purple</option>
				<option value="light_brown">light brown</option>
				<option value="light_red">light red</option>
				<option value="light_violet">light violet</option>
				</select>
			</div>
			<hr>
			<div class="form-item">
				<script language="javascript">
				$(document).ready(function(){
					$("#shared").click(function(){
						if($(this).hasClass("check-on"))
						{
							$(this).removeClass("check-on").addClass("check-off");
							$("#shared-id").val("0");
						}
						else
						{
							$(this).removeClass("check-off").addClass("check-on");
							$("#shared-id").val("1");
						}
					})
				})
				</script>
				<!--  
				<a id="shared" class="checkbox category"></a>			
				<h1 class="inline">Allow Other Users to Post into This Category</h1>
				-->
				<input type="hidden" name="operation" value="" id="operation" />
				<input type="hidden" value="1" name="shared" id="shared-id">
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
		<input type="button" value="Delete" class="btn-delete fromCat" id="delete" style="float: left; ">
		</div>
	</div>
</div>

