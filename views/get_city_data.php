 <div class="col-md-6">
<div class="inline_mid_form">
<select class="contact-form-line" name="city">
           
            <?php

            if(!empty($city_lists)){
            	$city = '';
          		  if(!empty($cityName)){
          		  	$city = $cityName;
          		  }

            	foreach ($city_lists as $cities) {
            		?>
            		<option value="<?php echo $cities->city ;?>"  <?php if($city == $cities->city){ echo 'selected=selected'; } ?>  ><?php echo $cities->city ;?>
            			
            		</option>
        <?php
            	}
            }
        ?>
        </select> 
</div>
</div>
 <div class="col-md-6">
     <div class="inline_mid_form  started-btn">
  
        <input type="submit" class="btn-theme">
</div>
</div>

