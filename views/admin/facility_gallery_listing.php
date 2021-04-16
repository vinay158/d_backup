<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<style>
<!--
.manager-items .manager-item {
	min-height: 49px !important;
}
-->
</style>

<script language="javascript" type="text/javascript">
	function goBack()
	{
		window.history.back()
	}
	
	$(document).ready(function(){

		var mod_type1 = $("#mod_type").val().toLowerCase();
						
		try{
			$(".ui-sortable").sortable({
				update : function () {
					serial = $('.ui-sortable').sortable('serialize');
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
						
		$("#details_t").hide();
		
		$("#Media").click(function(){
			$("#details_t").hide();
			$("#gallery").show();
			$(this).addClass("active");
			$("#Edit").removeClass("active");
		});
		
		$("#Edit").click(function(){
			$("#gallery").hide();
			$("#details_t").show();
			$(this).addClass("active");
			$("#Media").removeClass("active");
		});
		
		$(".edit_item").click(function(){								 
				//alert($("#album_cover").val());
				$("#dropdown-holder").hide();
				$(".dropdown-edit").hide();
				$(".delete-holder-item").hide();	
				$(".dropdown-edit").slideDown(200);
				var media_id = $(this).attr("id").substr(5);
				
				var loc = $("#media_link_"+media_id).val();
				var desc = $("#desc_"+media_id).html();	
				$(".drop-add-title em").text("ID # "+media_id);							
				$("#operation").val("edit");
				$("#edit_id").val(media_id);
				$("#media_desc").val(desc);							
		});
	});
</script>
		
<div class="panel-body" id="gallery">		
	<div class="panel-body-holder" style='padding-top:0px'>
		<div class="manager-items custom">
			<div class="border">
				<h1 id="h1-title">Facility pics		
					<div style='float:right'>			
						<?php if($count_media<=12):?>
                            <input type="submit" id='Upload' name="update" value="Upload" style='width:100px; float:left;' class="btn-upload" />								
                        <?php endif; ?>
						
					</div>
				</h1>
                
				<div style="font-style:italic;font-size:11px;margin:12px 155px;">
					You may rearrange the order of the items below by dragging them above or below other item rows. Changes will automatically be saved.
				</div>                
				
				<?php
					$sr=0; 
					if(!empty($media)):

                	echo '<ul class="cat_sort ui-sortable">';

						foreach($media as $media):
						$sr++; 
				?>
						<li id="menu_<?=$media->id?>">
							<div class="manager-item">
								<div>
									<h2><?= $sr;?></h2>		
                                    <div class="manager-item-image" style="overflow: hidden;">
                                        <img src="<?=$media->photo?>" style="display: inline-block; width: 100px; margin-top: -14px; ">
                                    </div>
                                    
									<h1><a id="edit_<?=$media->id?>" class="edit_item"><?=character_limiter(rawurldecode($media->photo), 40);?></a></h1>
		
			 						<span style='display:none' id="desc_<?=$media->id?>"><?=$media->desc;?></span>
								</div>
                                
								<div class="manager-item-opts">
                                    <a id="edit_<?=$media->id?>" class="edit_item" title="Edit Media <?=$media->desc;?>">Edit</a>		
                                    <a id="delitem_<?=$media->id?>" class="delete_item" title="Delete <?=$media->desc;?>">Delete</a>
								</div>
							</div>
						</li>
				<?php 	
						endforeach;
						echo '</ul>';
					else:	
				?>
					<h1>No Media Uploaded Yet.</h1>
				<?php endif;?>
		
			</div>
			<input type="hidden" name="mod_type" value="about" id="mod_type" />	
		</div>
	</div>
</div>
		
<div class="panel-body" id="details_t" style="display:none"></div>

<script language="javascript">
$(document).ready(function(){
	$("#Upload").click(function(){
		$("#dropdown-holder").hide();
		$(".dropdown-edit").hide();
		$(".delete-holder-item").hide();	
		$("#dropdown-holder").slideDown(200);
	});

	$(".close-btn").click(function(){
		$("#dropdown-holder").slideUp(200);
		$(".delete-holder-item").slideUp(200);	
		$(".dropdown-edit").slideUp(200);
	});
	
	$(".delete_item").click(function(){
		var del_item_id = $(this).attr("id").substr(8);
		$("#delete-item-id").val(del_item_id);
		$("#dropdown-holder").hide();
		$(".dropdown-edit").hide();
		$(".delete-holder-item").hide();
		$(".delete-holder-item").slideDown(300);
		return false;
	})
});
</script>


<br style="clear:both" /><br />
<!------- include modal for category ----------->	
<?php  $this->load->view("admin/include/conf_delete_facility_media"); ?>
<?php  $this->load->view("admin/include/facility-gallery-modal"); ?>