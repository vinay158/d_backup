<div class="delete-holder-item" style="display: none;">
  <form action="admin/<?=$link_type;?>/deleteitem" method="post" id="deleteForm">
  <div class="dropdown-panel">
    <div class="dropdown-title">
      <div style="float:left;">Confirmation</div>
      <div class="btn-close"><a class="close-btn"></a></div>
    </div>
    
    <div class="dropdown-body">
	    <div class="form-item">
		    <h1>Deleting User will delete all their attendance records too. <br/> Do you confirm to delete ?</h1><br>
		   
			<input type="hidden" name="delete-item-id" id="delete-item-id" value=""/>
		    <input type="hidden" name="category_loc" id="category_loc" value="<?=$this->uri->segment(4);?>" />
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


