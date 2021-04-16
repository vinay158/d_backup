

<link rel="stylesheet" type="text/css" media="screen" href="../../css/admin/dropdown.css" />

<!-----

<link rel="stylesheet" type="text/css" media="screen" href="../../css/admin/login-style.css" />

----->


<div class="duplicateContact">
<div id="dropdown-holder" style="display: none">

  <div class="dropdown-panel">

    <div class="dropdown-title">

      <div style="float:left;" class="drop-add-title">Duplicate Contact</em></div>

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

		    <form action="admin/<?=$link_type?>/duplicate_contact" method="post" id="operateform">

			<div class="form-item">

				<h1>Location Title</h1>
					<div style="margin-bottom:10px;">

						Note: If you want then change location title

					</div>

				

				<input type="text" name="location_name" id="location_name" class="field" value="">
				<input type="hidden" name="contact_id" id="contact_id" class="field" value="">

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


