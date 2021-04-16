<div id="dropdown-holder" class="dropdown-edit" style="display: none">
  <div class="dropdown-panel">
    <div class="dropdown-title">
      <div style="float:left;" class="drop-add-title">Edit Media<em>ID# 1</em></div>
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
		    <form action="admin/about/operateMedia" method="post" id="operateform">
			<div class="form-item">
				<h1>Caption</h1>
				<input type="hidden" name="edit_id" id="edit_id" value="0" />
				<input type="text" name="media_desc" id="media_desc" class="field" value="">
				<input type="hidden" name="cover_link" id="cover_link" value="" />
				<input type="hidden" name="redirection" value="admin/about/facility" />
			</div>
			<div class="form-item">
				<script language="javascript">
				$(document).ready(function(){
					$("#album-cover").click(function(){
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
				<input type="hidden" name="operation" value="" id="operation" />
				<input type="hidden" value="1" name="album-cover-val" id="album-cover-val">
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

