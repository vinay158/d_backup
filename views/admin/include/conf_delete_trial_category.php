<div class="delete-holder-item conf_delete_trial_category" style="display: none;">
  <form action="admin/<?=$link_type;?>/deleteTrialCategory" method="post">
  <div class="dropdown-panel">
    <div class="dropdown-title">
      <div style="float:left;">Confirmation</div>
      <div class="btn-close"><a class="close-btn"></a></div>
    </div>
    
    <div class="dropdown-body">
	    <div class="form-item">
		    <h1>Are you sure you want to delete this?</h1><br>
		    <span class="catNote" style="">Note: This will permanently delete all Blog Entires in this Category, as well as all the Comments associated with those Blog Entries.</span>
			<input type="hidden" name="delete-item-id" id="delete-category-id" value=""/>
		    
	    </div>
    </div>
    <div class="dropdown-bottom">
		
	    <input type="submit" value="Delete" class="btn-delete actionButtons" style="float:left;">
		<script language="javascript">
		$(document).ready(function(){
			$(".btn-cancel").click(function(){
				$(this).parents(".delete-holder-item").slideUp(300);
			})
		});
		</script>
	    <input type="button" value="Cancel" class="btn-cancel actionButtons" style="float:left;">
    </div>
  </div></form>
</div>


