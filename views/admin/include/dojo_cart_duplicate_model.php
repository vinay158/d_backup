

<link rel="stylesheet" type="text/css" media="screen" href="../../css/admin/dropdown.css" />

<!-----

<link rel="stylesheet" type="text/css" media="screen" href="../../css/admin/login-style.css" />

----->



<div id="dropdown-holder" class="dojocartDuplicateForm" style="display: none">

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

		    <form action="admin/<?=$link_type?>/duplicateDojocart" method="post" id="operateform">

			<div class="form-item">

				<h1>Title</h1>
					
				

				<input type="text" name="name" id="form_title" class="field" value="" required="true">
				<div style="margin-bottom:10px; color:red"> Note: Please change title.</div>

				<input type="hidden" name="form_id" id="form_id" class="field" value="">

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

		<input type="button" value="Delete" class="btn-delete fromCat" id="delete" style="float: left; ">

		</div>

	</div>

</div>



