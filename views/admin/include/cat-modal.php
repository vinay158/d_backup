

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



		<div class="dropdown-body" >

		    <form action="admin/<?=$link_type?>/operateCategory" method="post" id="operateform">

			<?php if(!empty($link_type) && $link_type == 'downloads'){ ?>
			<?php 
				$this->db->select('download_thread');
			$is_download_thread = $this->query_model->getByTable('tblsite');
			$is_download_thread = 	$is_download_thread[0]->download_thread;
			
				if($is_download_thread == 1){
			?>
			
			<div class="form-item">

				<h1>Category</h1>
				<select id="parent_id" name="parent_id" class="field">
				<option value="0">-Select Category-</option>
				<?php echo $this->query_model->getCategoryDropdownOptions('downloads',0, 0,0); ?>
				</select>
			</div>
			<?php } } ?>
			<div class="form-item">

				<h1>Title</h1>

				<input type="hidden" name="edit_id" id="edit_id" value="0" />

				<input type="text" name="name" id="cat_title" class="field" value="">

				<!--  

				<div style="margin-bottom:10px;">

					Title will appear in the URL as: <em class="sef_title"></em>

				</div>

				-->

			</div>

            <?php

				//echo 'link_type: '.$link_type;

				if($link_type == 'programs'){

			?>
            
            	<div class="form-item">

                    <h1>Meta Title</h1>
    
                    <input type="text" name="meta_title" id="meta_title" class="field" value="">                  
    
                </div>
                

                <div class="form-item">

                    <h1>Meta Description</h1>				

                    <textarea rows="8" cols="50" name="meta_desc" id="meta_desc"></textarea>

                    <p>use following variable to replace relevent values<br />

                        {school_name}, {city}, {state}, {city_state}, {county}<br />

                        {nearby_location1}, {nearby_location2}, <br />

                        {main_martial_arts_style}, {martial_arts_style}

                    </p>

                </div>

            <?php		

				}

			?>

            

            

            

            

			<!--

			<hr>

			-->

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

				<!--<a id="shared" class="checkbox category"></a>			

				<h1 class="inline">Allow Other Users to Post into This Category</h1>

				--><input type="hidden" name="operation" value="" id="operation" />

				<input type="hidden" value="1" name="shared" id="shared-id">

			</div>

		</div>

		<div class="dropdown-bottom" >

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



