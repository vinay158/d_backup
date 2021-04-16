

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

			<div class="form-item">

				<h1>Title</h1>

				<input type="hidden" name="edit_id" id="edit_id" value="0" />

				<input type="text" name="name" id="cat_title" class="field" value="">


			</div>

			
			<div class="form-item">

				<h1>Heading</h1>

				<input type="text" name="heading" id="cat_heading" class="field" value="">


			</div>

			
			<div class="form-item">

				<h1>Slug</h1>

				<input type="text" name="slug" id="cat_slug" class="field" value="">


			</div>

            
            

            

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

				<input type="hidden" name="operation" value="" id="operation" />

				<input type="hidden" value="1" name="shared" id="shared-id">

			</div>

		</div>

		<div class="dropdown-bottom" >

			<input type="submit" name="submit" value="Save" class="btn-save" style="float:left;">

			

			<!-- <script language="javascript">

			$(document).ready(function(){

				$("#delete").click(function(){

					$(this).parents("#dropdown-holder").slideToggle(300);

					$(".delete-holder").hide();

					$(".delete-holder").slideDown(300);

					$("#delete-id").val($("#edit_id").val());

				});

			});

			</script> -->

		

    </form>

		<!-- <input type="button" value="Delete" class="btn-delete fromCat" id="delete" style="float: left; "> -->

		</div>

	</div>

</div>



