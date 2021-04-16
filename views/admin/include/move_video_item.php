

<link rel="stylesheet" type="text/css" media="screen" href="../../css/admin/dropdown.css" />

<!-----

<link rel="stylesheet" type="text/css" media="screen" href="../../css/admin/login-style.css" />

----->



<div id="dropdown-holder" class="onlinedojo_move_video" style="display: none">

  <div class="dropdown-panel">

    
		<div class="dropdown-title">

		  <div style="float:left;" class="drop-add-title">Move Video</div>

		  <div class="btn-close"><a class="close-btn"></a></div>

		</div>

		<div class="dropdown-body" >

		    <form action="admin/onlinedojo_video_albums/moveOnlineDojoVideos" method="post" id="operateform">

			<div class="form-item">

				<h1>Albums</h1>
					
				<?php 
					$this->db->where("category", 26);
					$albums = $this->query_model->getbyTable("tbl_onlinedojo_galleryname");
				?>
				<?php if(!empty($albums)){ ?>
				<select class="field" name="album_id">
					<option value="">-Select video album-</option>
					<?php foreach($albums as $album){  ?>	
						<option value="<?php echo $album->id ?>"><?php echo $album->album ?></option>
					<?php } ?>
				</select>
				<?php } ?>
			</div>

           <input type="hidden" name="move_video_type" id="move_video_type"  value="video_to_album">
           <input type="hidden" name="video_id" id="video_id"  value="0">

		</div>

		<div class="dropdown-bottom" >

			<input type="submit" name="submit" value="Save" class="btn-save" style="float:left;">

			

			
		

    </form>


		</div>

	</div>

</div>



