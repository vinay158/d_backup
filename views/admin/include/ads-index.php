<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title"><?=$title?> Manager</h2>
			</div>
			
		  </div>
	  </div>
	   <div class="row row-sm program-cat-page">

          <div class="col-sm-12 col-xl-12 az-content-body-contacts"  >
			<div class="card pd-sm-20 edit-form">
			
<div class="gen-holder">

	<div class="gen-panel-holder"  style="width: 100% !important;">
	
	<?php 
	/*if($user_level==1){ 
		$siteData = $this->query_model->getbyTable("tblsite");
	?>
	<div class="form-light-holder" style="background:none !important;margin-top: 9px !important;text-align:right;">
		<a id="published" style="margin-top: 9px !important;margin-right: 9px!important;float:right;" class="checkbox <?=$siteData[0]->is_mailing_required ? "check-on" : "check-off"; ?>" ></a>
		<h1 class="inline">Mailing List Sign-Up&nbsp;&nbsp;</h1>
		<input type="hidden" value="<?=$siteData[0]->is_mailing_required?>" name="published" name="" class="hidden_mailing" />
		<input type="hidden" value="<?=$siteData[0]->id?>" id="site_id" name="site_id" class="hidden_mailing" />
	</div>
	<?php }*/ ?>


<div class="">

<!--<div class="btn-addentry add_entry_button"></div>-->
<h1 > &nbsp;&nbsp; </h1>


<div class="program_full_detail page-section new_lisiting_block default_template" id="AlternatingFullWidth">

				<div class="mb-3 main-content-label " style="margin-top:0px !important" ><?=$title?></div>
				<div class="row row-xs align-items-center  mg-t-25 mg-b-5">
					<div class="col-md-12">
						<p>You may rearrange the order of the items below by dragging them above or below other item rows. Changes will automatically be saved.</p>
					</div>
					
				</div>
				
				<div class="row row-xs align-items-center mg-b-20  alternating-row-section ">
					
					<div class="col-md-12 mg-t-5 mg-md-t-0 ">
						<div class="az-content-body ">
			
							<div class="az-mail-header">
								<div>
								  <h4 class="az-content-title mg-b-5"><?=$title?></h4>
								  <p>You have <span class="total_alternating_full_width_row"><?php echo !empty($slides) ? count($slides) : 0; ?></span> entries</p>
								</div>
								<div>
								 <a href="admin/<?=$link_type?>/add" class="button_class btn btn-indigo ">Add Advertisement</a>
								</div>
							  </div>
							  
			<ul class="ajax_record_sortable alternating_full_width_row"  table_name="tblads" >

			<?php
			$sr_testimonials=0; 
							
			if(!empty($slides)):
			 foreach($slides as $row):
			 $sr_testimonials++;
			?>


					<li   id="menu_<?=$row->id?>" class="full_width_row_<?=$row->id?> az-contact-info-header">
						<div class="manager-item media">
							<div style="float:left;">
								<div class="badge-no"><?=$sr_testimonials?>.</div>
								
								<?php 
														
									if($row->image_video == 'video') { 
												if($row->video_type == 'youtube_video'){
													$img_src = "http://i.ytimg.com/vi/".$row->video_id."/0.jpg";
													
												}
												
												elseif($row->video_type == 'vimeo_video'){
													$img_src= $this->query_model->getViemoVideoImage($row->video_id);
													
												}
												
									 } else {
											$img_src = $row->photo;
									 }
									
								?>
							
								<div class="imgbox"><img src="<?php echo !empty($img_src) ? $img_src : base_url().'assets_admin/img/no-image.png'?>" class="list_img">	</div>
													
								<h4 class="full_width_row_heading_<?=$row->id?>"><a href="javascript:void(0)" ><?=$row->title;?> </a></h4>
							</div>
							<div class="manager-item-opts">
							
							
						<nav class="nav">
							 
							  <a href="admin/ads/edit/<?=$row->id?>" class="badge badge-primary">Edit</a>
							  
									<a class="badge badge-primary ajax_record_delete" data-toggle="modal" data-target="#popupDeleteRecord" item_id="<?=$row->id;?>"   table_name="tblads" item_title="<?=$row->title;?>" section_type="full_width">Delete</a>
									
									<a href="javascript:void(0)" id="unpub_<?=$row->id; ?>" class="ajax_record_publish"  table_name="tblads"  is_new="0">
								<div class="az-toggle az-toggle-success alternate_full_width_toogle toogle_btn <?php echo ($row->published == 1) ? 'on' : '';?>" publish_type="<?php echo ($row->published == 1) ? 0 : 1;?>"><span></span>
								<input type="hidden" name="publish_type" value="<?php echo ($row->published == 1) ? 0 : 1;?>" class="publish_type" />
								</div></a>
						</nav>



							</div>
						</div>
					</li>
<?php endforeach;?>								

<?php else: ?>

<?php endif;?>
								</ul>

	<input type="hidden" name="mod_type" value="<?=$link_type;?>" id="mod_type" />		
			
						
						
				</div>
			</div>
		</div>
</div>

</div>	

	</div>			

		
</div>
</div>
</div>
</div>
</div>

<script language="javascript">
$(document).ready(function(){

<?php if($user_level==1){ ?>

var pub_id = $('#site_id').val();
var mod_type = $("#mod_type").val().toLowerCase();
$(".form-light-holder .checkbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents(".form-light-holder").children(".hidden_cb").val("0");

		$.ajax({ 					
			type: 'POST',						
			url: 'admin/'+mod_type+'/publish_mailling',						
			data: { pub_id : pub_id, publish_type: 0 }					
			}).done(function(msg){ 
				if(msg != null){
					alert('Mailing Unpublished');
					setTimeout("window.location.reload()",1000);
				}
			});
		
	}
	else
	{
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/'+mod_type+'/publish_mailling',						
		data: { pub_id : pub_id, publish_type: 1 }					
		}).done(function(msg){ 
			if(msg != null){
				alert('Mailing Published');
				setTimeout("window.location.reload()",1000);
			}		
		});		
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents(".form-light-holder").children(".hidden_mailing").val("1");
	

	}
});		
<?php } ?>

})
</script>


<?php 
	function getThumbnailImage($v_id){

		//echo $v_id; die;
			if($v_id){
				$url="http://vimeo.com/api/v2/video/".$v_id.".php";						
				$data=file_get_contents($url);						
				$data=unserialize($data);
			//	echo '<pre>'; print_r($data); die;					
				return ($data[0]['thumbnail_large']); 
				
			}else{
				return 0;
			}	
	}
?>
