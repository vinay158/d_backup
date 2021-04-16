<script language="javascript">
$(document).ready(function(){
$(".form-light-holder .checkbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents(".form-light-holder").children(".hidden_cb").val("0");
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents(".form-light-holder").children(".hidden_cb").val("1");
	}
})
})
</script>
<div class="form-light-holder">

	<a id="allow_comments" class="checkbox check-on"></a>
	<h1 class="inline">Commenting</h1>
	<input type="hidden" value="1" name="allow_comments" class="hidden_cb" />
</div>
<div class="form-light-holder">
	<a id="shared" class="checkbox check-off"></a>
	<h1 class="inline">Share This</h1>
	<input type="hidden" value="1" name="shared" class="hidden_cb" />
</div>
<div class="form-light-holder">
	<a id="published" class="checkbox check-on"></a>
	<h1 class="inline">Publish This</h1>
	<input type="hidden" value="1" name="published" class="hidden_cb" />
</div>
