

<link rel="stylesheet" type="text/css" media="screen" href="../../css/admin/dropdown.css" />

<!-----

<link rel="stylesheet" type="text/css" media="screen" href="../../css/admin/login-style.css" />

----->


<div class="duplicateProgram">
<div id="dropdown-holder" style="display: none">

  <div class="dropdown-panel">

    <div class="dropdown-title">

      <div style="float:left;" class="drop-add-title">Duplicate Program</em></div>

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

		    <form action="admin/<?=$link_type?>/duplicate_program" method="post" id="operateform">

			<div class="form-item">

				<h1>Program Title</h1>
					<div style="margin-bottom:10px;">

						Note: If you want then change program title 

					</div>

				

				<input type="text" name="program_title" id="program_title" class="field" value="">
				<input type="hidden" name="program_id" id="program_id" class="field" value="">
				<input type="hidden" name="category_id" id="category_id" class="field" value="">

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
				
				$(".close-btn").click(function(){
					$(this).parents("#dropdown-holder").slideUp(300);
				});

			});

			</script>

		

    </form>

		
		</div>

	</div>

</div>
</div>


