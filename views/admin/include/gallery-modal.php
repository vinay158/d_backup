
<link rel="stylesheet" type="text/css" media="screen" href="../../css/admin/dropdown.css" />
<!-----
<link rel="stylesheet" type="text/css" media="screen" href="../../css/admin/login-style.css" />
----->
<div id="dropdown-holder" class="dropdown-edit" style="display: none">
  <div class="dropdown-panel">
    <div class="dropdown-title">
      <div style="float:left;" class="drop-add-title">Edit Media <em>ID# 1</em></div>
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
		    <form action="admin/<?=$link_type?>/operateMedia" method="post" id="operateform" onSubmit="javascript:return testUrlForMedia(this);">
			<div class="form-item">
				<h1>Caption</h1>
				<input type="hidden" name="edit_id" id="edit_id" value="0" />
				<input type="text" name="media_desc" id="media_desc" class="field" value="">
				<input type="hidden" name="cover_link" id="cover_link" value="" />
				<input type="hidden" name="redirection" value="admin/<?=$link_type?>/edit/<?=$this->uri->segment(4)."/".$this->uri->segment(5);?>" />
				<input type='hidden' name='video_type' id ='video_type_edit' value=''/>
				<input type='hidden' name='video_id' id ='video_id_edit' value=''/>
			</div>
			<?php
			if($type==2){ ?>  
			<div class="form-item">
				<h1>URL</h1>
				<input type="text" name="media_url" id="embed_edit" class="field" value="">
			</div>
			<?php } ?>
			
			<hr class="video_album_id">
			<div class="form-item video_album_id">
			<h1>Album</h1>
			<select name="edit-album" id="edit-album" style="width: 100%;">
				<?php 
				foreach($album as $album): 
					$week_academy_title = '';
					if(isset($album->week_academy_id) && !empty($album->week_academy_id)){
						
						$this->db->select('title');
						$week_academy = $this->query_model->getBySpecific('tbl_8_week_academy','id',$album->week_academy_id);
						
						$week_academy_title = !empty($week_academy) ? '-'. $week_academy[0]->title : '';
					}
					
				?>
				<option <?php if($album->id == $this->uri->segment(4)) echo "selected='selected'"; ?> value='<?=$album->id?>'><?=$album->album?> <?php echo $week_academy_title; ?> </option>
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
					<a id="album-cover" class="checkbox category check-off"></a>			
				<h1 class="inline">Album Cover</h1>
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

