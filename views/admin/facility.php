<?php $this->load->view("admin/include/header"); ?>

<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>



<div class="gen-holder">

	<div class="gen-panel-holder" style="width: 100%;">

	<div class="gen-panel">

		<div class="panel-title">

			<div class="panel-title-name">

            	<?php

					if($title){

						echo $title;

					}else{

						echo 'Add Facility';

					}

				?>                

			</div>

		</div>

        

		<div class="panel-body">

			<div class="panel-body-holder">

				<div class="form-holder">



					<form id="blog_form" action="admin/about/updatefacility" method="post">

						<div class="form-light-holder">

							<h1>Title</h1>		

							<input type="text" value="<?=ucwords($title);?>" name="title" id="main_title" class="field"/>

						</div>

                        

                        <?php /*if($IsAllowMultiFacility){ ?>

                        <div class="form-light-holder">

							<h1>Location</h1>		

							<?php echo form_dropdown('location_id', $locations, $location_id); ?>

						</div>

                        

                        <?php } */?>

	

						<div class="form-light-holder" style="">

							<textarea name="text" class="ckeditor" id="frm-text"><?=$content;?></textarea>

						</div>

                        <div class="form-light-holder">

							<h1>Meta Title</h1>		

							<input type="text" value="<?=($meta_title);?>" name="meta_title" id="meta_title" class="field"/>

						</div>

                        <div class="form-light-holder">

                            <h1>Meta Description</h1>

                            <textarea name="meta_desc" id="frm-text" style="width: 820px;"><?=$meta_desc?></textarea>

                            <p>use following variable to replace relevent values<br />

                                {school_name}, {city}, {state}, {cit_state}, {county}<br />

                                {nearby_location1}, {nearby_location2}, <br />

                                {main_martial_arts_style}, {martial_arts_style}

                            </p>

                        </div>



						<div class="form-white-holder" style="padding-bottom:20px;">

                        	<input type="hidden" name="facility_id" value="<?=$id?>" />

                            <input type="hidden" name="is_main" value="<?=$is_main?>" />

                            <input type="hidden" name="location_id" value="<?=$location_id?>" />

							<input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />

						</div>	

					</form>

				</div>

			</div>

		</div>

<?php

if($id){

?>	

	<style>

	

	.panel-body {

    	padding-bottom: 5px !important;

	}

	

	</style>

	



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

		//exit(0);

		})

		});

</script>

	

	<!------- include modal for category ----------->

		<?php $this->load->view("admin/include/facility-upload-modal"); ?>

	<!--------- end modal for category -------------->



		<?php $this->load->view("admin/include/facility_gallery_listing"); ?>

 <?php

}

?>

		</div>

	</div>

</div>



	<!------------ recent items ----------------->

	<?php $this->load->view("admin/include/footer");?>



