	<div class="gen-panel" id="tags_gen_panel">
		<div class="panel-title">
			<div class="panel-title-name">Tags</div>
			<div class="panel-title-options">
				<div>
					<a id="tag_btn">My Tags</a>
				<script>
				$(document).ready(function(){
				$("#tag_btn").click(function(){
					if($(this).text().toLowerCase() == 'my tags')
					{
						$(this).text("Add New");
						$("#the-tags").show();
						$("#frm-add-new-tag").hide();						
					}
					else
					{
						$(this).text("My Tags");
						$("#the-tags").hide();
						$("#frm-add-new-tag").show();
					}
				})
				})
				</script>
				</div>
			</div>
		</div>
<div class="panel-body">
			<div class="panel-body-holder" id="tag_manager">
				<div class="tag-item" id="the-tags" style="display: none;">
					Tag this using Your existing Tags:<br />
					<div class="gen-tags" style="display:none;width:241px;">
						<a href="" class="gen-tag check-off">
							<div style="float:left"></div><div class="gen-tag-right"></div>
						</a>
					</div>
					<br />
				</div>
				<div id="frm-add-new-tag">
					<form id="frm-new-tag" action="" method="post">
					<div class="sidebar-item tag-item" id="add-new-tag">
						<h1>Add New Tags</h1>
						<input type="text" name="newtags" class="field" id="newtags" />
						Seperate Tags with <i>Commas</i>.
					</div>
					<script>
					$(document).ready(function(){
					$("#frm-new-tag").submit(function(){
					var newtags = $("#newtags").val().split(",");
					
					event.preventDefault();
					})
					})
					</script>
					<input type="submit" class="btn-add" style="margin-top:10px;" value="Add" />
					</form>
				</div>
			</div>
		</div>