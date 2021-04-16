<div class="form-light-holder" id="schedule2" style="display:none;">
    <div style="float:left;">
    	<h1>Date</h1>
		<input type="text" value="" name="date1[]" id="date2" class="field mydatetimepicker" placeholder="mm/dd/yyyy" maxlength="10" style="width: 200px; margin: 0;"/>
		<input type="hidden" value="" name="" id="date_hidden2" class="myhiddenvalue" maxlength="10"/>
    </div>
	
    <div style="float:left; margin-left: 20px;">
        <h1>Repeat</h1>
        <select name="repeat1[]" id="repeat1"   style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
        <option value="never">Never</option>
        <option value="Every week">Every week</option>
        <option value="Every year">Every year</option>
        </select>
    </div>
    
    <div style="float:left; margin-left: 20px;" id="time_grp1" class="time_grp1">
    
    	<div style="float: left; width: 275px;">
            <h1>Start</h1>
            
            <select type="text" class="date_check1" name="start_hr1[]" id="start_hr1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Hour</option>
                <?php                 
                 foreach($hrs as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                }
                ?>
            </select>
            
            <select type="text" class="date_check1" name="start_min1[]" id="start_min1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Min</option>
                <?php                		 
                 foreach($mins as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                }
                ?>
            </select>
            
            <select type="text" class="date_check1" name="start_ampm1[]" id="start_ampm1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
            	<option value="AM">AM</option>
            	<option value="PM">PM</option>
            </select>
		</div>
            
		<div  style="float: left; margin-left: 20px;  width:275px">
            <h1>End</h1>
            <select type="text" class="date_check1" name="end_hr1[]" id="end_hr1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Hour</option>
                <?php foreach($hrs as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                } ?>
            </select>
            
            <select type="text" class="date_check1" name="end_min1[]" id="end_min1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Min</option>
                <?php foreach($mins as $time){
						echo "<option value='".$time."'>".$time."</option>";
					} ?>
            </select>
            
            <select type="text"  class="date_check1" name="end_ampm1[]" id="end_ampm1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option value="AM">AM</option>
            	<option value="PM">PM</option>
            </select>
            
		</div>
    </div>
	
    <div style="clear:both"></div>
    <input type="checkbox" name="allday1[]" id="allday1" class="allday1" value="1" /> All day
    
    <div style="clear:both"></div>
</div>

<div class="form-light-holder" id="schedule3" style="display:none;">
    <div style="float:left;">
    	<h1>Date</h1>
		<input type="text" value="" name="date1[]" id="date3" class="field mydatetimepicker" placeholder="mm/dd/yyyy" maxlength="10" style="width: 200px; margin: 0;"/>
		<input type="hidden" value="" name="" id="date_hidden3" class="myhiddenvalue" maxlength="10"/>
    </div>
	
    <div style="float:left; margin-left: 20px;">
        <h1>Repeat</h1>
        <select name="repeat1[]" id="repeat1"   style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
        <option value="never">Never</option>
        <option value="Every week">Every week</option>
        <option value="Every year">Every year</option>
        </select>
    </div>
    
    <div style="float:left; margin-left: 20px;" id="time_grp1" class="time_grp1">
    
    	<div style="float: left; width: 275px;">
            <h1>Start</h1>
            
            <select type="text" class="date_check1" name="start_hr1[]" id="start_hr1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Hour</option>
                <?php                 
                 foreach($hrs as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                }
                ?>
            </select>
            
            <select type="text" class="date_check1" name="start_min1[]" id="start_min1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Min</option>
                <?php                		 
                 foreach($mins as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                }
                ?>
            </select>
            
            <select type="text" class="date_check1" name="start_ampm1[]" id="start_ampm1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
            	<option value="AM">AM</option>
            	<option value="PM">PM</option>
            </select>
		</div>
            
		<div  style="float: left; margin-left: 20px;  width:275px">
            <h1>End</h1>
            <select type="text" class="date_check1" name="end_hr1[]" id="end_hr1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Hour</option>
                <?php foreach($hrs as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                } ?>
            </select>
            
            <select type="text" class="date_check1" name="end_min1[]" id="end_min1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Min</option>
                <?php foreach($mins as $time){
						echo "<option value='".$time."'>".$time."</option>";
					} ?>
            </select>
            
            <select type="text"  class="date_check1" name="end_ampm1[]" id="end_ampm1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option value="AM">AM</option>
            	<option value="PM">PM</option>
            </select>
            
		</div>
    </div>
	
    <div style="clear:both"></div>
    <input type="checkbox" name="allday1[]" id="allday1" class="allday1" value="1" /> All day
    
    <div style="clear:both"></div>
</div>

<div class="form-light-holder" id="schedule4" style="display:none;">
    <div style="float:left;">
    	<h1>Date</h1>
		<input type="text" value="" name="date1[]" id="date4" class="field mydatetimepicker" placeholder="mm/dd/yyyy" maxlength="10" style="width: 200px; margin: 0;"/>
		<input type="hidden" value="" name="" id="date_hidden4" class="myhiddenvalue" maxlength="10"/>
    </div>
	
    <div style="float:left; margin-left: 20px;">
        <h1>Repeat</h1>
        <select name="repeat1[]" id="repeat1"   style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
        <option value="never">Never</option>
        <option value="Every week">Every week</option>
        <option value="Every year">Every year</option>
        </select>
    </div>
    
    <div style="float:left; margin-left: 20px;" id="time_grp1" class="time_grp1">
    
    	<div style="float: left; width: 275px;">
            <h1>Start</h1>
            
            <select type="text" class="date_check1" name="start_hr1[]" id="start_hr1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Hour</option>
                <?php                 
                 foreach($hrs as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                }
                ?>
            </select>
            
            <select type="text" class="date_check1" name="start_min1[]" id="start_min1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Min</option>
                <?php                		 
                 foreach($mins as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                }
                ?>
            </select>
            
            <select type="text" class="date_check1" name="start_ampm1[]" id="start_ampm1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
            	<option value="AM">AM</option>
            	<option value="PM">PM</option>
            </select>
		</div>
            
		<div  style="float: left; margin-left: 20px;  width:275px">
            <h1>End</h1>
            <select type="text" class="date_check1" name="end_hr1[]" id="end_hr1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Hour</option>
                <?php foreach($hrs as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                } ?>
            </select>
            
            <select type="text" class="date_check1" name="end_min1[]" id="end_min1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Min</option>
                <?php foreach($mins as $time){
						echo "<option value='".$time."'>".$time."</option>";
					} ?>
            </select>
            
            <select type="text"  class="date_check1" name="end_ampm1[]" id="end_ampm1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option value="AM">AM</option>
            	<option value="PM">PM</option>
            </select>
            
		</div>
    </div>
	
    <div style="clear:both"></div>
    <input type="checkbox" name="allday1[]" id="allday1" class="allday1" value="1" /> All day
    
    <div style="clear:both"></div>
</div>

<div class="form-light-holder" id="schedule5" style="display:none;">
    <div style="float:left;">
    	<h1>Date</h1>
		<input type="text" value="" name="date1[]" id="date5" class="field mydatetimepicker" placeholder="mm/dd/yyyy" maxlength="10" style="width: 200px; margin: 0;"/>
		<input type="hidden" value="" name="" id="date_hidden5" class="myhiddenvalue" maxlength="10"/>
    </div>
	
    <div style="float:left; margin-left: 20px;">
        <h1>Repeat</h1>
        <select name="repeat1[]" id="repeat1"   style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
        <option value="never">Never</option>
        <option value="Every week">Every week</option>
        <option value="Every year">Every year</option>
        </select>
    </div>
    
    <div style="float:left; margin-left: 20px;" id="time_grp1" class="time_grp1">
    
    	<div style="float: left; width: 275px;">
            <h1>Start</h1>
            
            <select type="text" class="date_check1" name="start_hr1[]" id="start_hr1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Hour</option>
                <?php                 
                 foreach($hrs as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                }
                ?>
            </select>
            
            <select type="text" class="date_check1" name="start_min1[]" id="start_min1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Min</option>
                <?php                		 
                 foreach($mins as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                }
                ?>
            </select>
            
            <select type="text" class="date_check1" name="start_ampm1[]" id="start_ampm1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
            	<option value="AM">AM</option>
            	<option value="PM">PM</option>
            </select>
		</div>
            
		<div  style="float: left; margin-left: 20px;  width:275px">
            <h1>End</h1>
            <select type="text" class="date_check1" name="end_hr1[]" id="end_hr1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Hour</option>
                <?php foreach($hrs as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                } ?>
            </select>
            
            <select type="text" class="date_check1" name="end_min1[]" id="end_min1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Min</option>
                <?php foreach($mins as $time){
						echo "<option value='".$time."'>".$time."</option>";
					} ?>
            </select>
            
            <select type="text"  class="date_check1" name="end_ampm1[]" id="end_ampm1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option value="AM">AM</option>
            	<option value="PM">PM</option>
            </select>
            
		</div>
    </div>
	
    <div style="clear:both"></div>
    <input type="checkbox" name="allday1[]" id="allday1" class="allday1" value="1" /> All day
    
    <div style="clear:both"></div>
</div>

<div class="form-light-holder" id="schedule6" style="display:none;">
    <div style="float:left;">
    	<h1>Date</h1>
		<input type="text" value="" name="date1[]" id="date6" class="field mydatetimepicker" placeholder="mm/dd/yyyy" maxlength="10" style="width: 200px; margin: 0;"/>
		<input type="hidden" value="" name="" id="date_hidden6" class="myhiddenvalue" maxlength="10"/>
    </div>
	
    <div style="float:left; margin-left: 20px;">
        <h1>Repeat</h1>
        <select name="repeat1[]" id="repeat1"   style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
        <option value="never">Never</option>
        <option value="Every week">Every week</option>
        <option value="Every year">Every year</option>
        </select>
    </div>
    
    <div style="float:left; margin-left: 20px;" id="time_grp1" class="time_grp1">
    
    	<div style="float: left; width: 275px;">
            <h1>Start</h1>
            
            <select type="text" class="date_check1" name="start_hr1[]" id="start_hr1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Hour</option>
                <?php                 
                 foreach($hrs as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                }
                ?>
            </select>
            
            <select type="text" class="date_check1" name="start_min1[]" id="start_min1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Min</option>
                <?php                		 
                 foreach($mins as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                }
                ?>
            </select>
            
            <select type="text" class="date_check1" name="start_ampm1[]" id="start_ampm1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
            	<option value="AM">AM</option>
            	<option value="PM">PM</option>
            </select>
		</div>
            
		<div  style="float: left; margin-left: 20px;  width:275px">
            <h1>End</h1>
            <select type="text" class="date_check1" name="end_hr1[]" id="end_hr1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Hour</option>
                <?php foreach($hrs as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                } ?>
            </select>
            
            <select type="text" class="date_check1" name="end_min1[]" id="end_min1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Min</option>
                <?php foreach($mins as $time){
						echo "<option value='".$time."'>".$time."</option>";
					} ?>
            </select>
            
            <select type="text"  class="date_check1" name="end_ampm1[]" id="end_ampm1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option value="AM">AM</option>
            	<option value="PM">PM</option>
            </select>
            
		</div>
    </div>
	
    <div style="clear:both"></div>
    <input type="checkbox" name="allday1[]" id="allday1" class="allday1" value="1" /> All day
    
    <div style="clear:both"></div>
</div>

<div class="form-light-holder" id="schedule7" style="display:none;">
    <div style="float:left;">
    	<h1>Date</h1>
		<input type="text" value="" name="date1[]" id="date7" class="field mydatetimepicker" placeholder="mm/dd/yyyy" maxlength="10" style="width: 200px; margin: 0;"/>
		<input type="hidden" value="" name="" id="date_hidden7" class="myhiddenvalue" maxlength="10"/>
    </div>
	
    <div style="float:left; margin-left: 20px;">
        <h1>Repeat</h1>
        <select name="repeat1[]" id="repeat1"   style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
        <option value="never">Never</option>
        <option value="Every week">Every week</option>
        <option value="Every year">Every year</option>
        </select>
    </div>
    
    <div style="float:left; margin-left: 20px;" id="time_grp1" class="time_grp1">
    
    	<div style="float: left; width: 275px;">
            <h1>Start</h1>
            
            <select type="text" class="date_check1" name="start_hr1[]" id="start_hr1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Hour</option>
                <?php                 
                 foreach($hrs as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                }
                ?>
            </select>
            
            <select type="text" class="date_check1" name="start_min1[]" id="start_min1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Min</option>
                <?php                		 
                 foreach($mins as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                }
                ?>
            </select>
            
            <select type="text" class="date_check1" name="start_ampm1[]" id="start_ampm1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
            	<option value="AM">AM</option>
            	<option value="PM">PM</option>
            </select>
		</div>
            
		<div  style="float: left; margin-left: 20px;  width:275px">
            <h1>End</h1>
            <select type="text" class="date_check1" name="end_hr1[]" id="end_hr1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Hour</option>
                <?php foreach($hrs as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                } ?>
            </select>
            
            <select type="text" class="date_check1" name="end_min1[]" id="end_min1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Min</option>
                <?php foreach($mins as $time){
						echo "<option value='".$time."'>".$time."</option>";
					} ?>
            </select>
            
            <select type="text"  class="date_check1" name="end_ampm1[]" id="end_ampm1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option value="AM">AM</option>
            	<option value="PM">PM</option>
            </select>
            
		</div>
    </div>
	
    <div style="clear:both"></div>
    <input type="checkbox" name="allday1[]" id="allday1" class="allday1" value="1" /> All day
    
    <div style="clear:both"></div>
</div>

<div class="form-light-holder" id="schedule8" style="display:none;">
    <div style="float:left;">
    	<h1>Date</h1>
		<input type="text" value="" name="date1[]" id="date8" class="field mydatetimepicker" placeholder="mm/dd/yyyy" maxlength="10" style="width: 200px; margin: 0;"/>
		<input type="hidden" value="" name="" id="date_hidden8" class="myhiddenvalue" maxlength="10"/>
    </div>
	
    <div style="float:left; margin-left: 20px;">
        <h1>Repeat</h1>
        <select name="repeat1[]" id="repeat1"   style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
        <option value="never">Never</option>
        <option value="Every week">Every week</option>
        <option value="Every year">Every year</option>
        </select>
    </div>
    
    <div style="float:left; margin-left: 20px;" id="time_grp1" class="time_grp1">
    
    	<div style="float: left; width: 275px;">
            <h1>Start</h1>
            
            <select type="text" class="date_check1" name="start_hr1[]" id="start_hr1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Hour</option>
                <?php                 
                 foreach($hrs as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                }
                ?>
            </select>
            
            <select type="text" class="date_check1" name="start_min1[]" id="start_min1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Min</option>
                <?php                		 
                 foreach($mins as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                }
                ?>
            </select>
            
            <select type="text" class="date_check1" name="start_ampm1[]" id="start_ampm1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
            	<option value="AM">AM</option>
            	<option value="PM">PM</option>
            </select>
		</div>
            
		<div  style="float: left; margin-left: 20px;  width:275px">
            <h1>End</h1>
            <select type="text" class="date_check1" name="end_hr1[]" id="end_hr1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Hour</option>
                <?php foreach($hrs as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                } ?>
            </select>
            
            <select type="text" class="date_check1" name="end_min1[]" id="end_min1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Min</option>
                <?php foreach($mins as $time){
						echo "<option value='".$time."'>".$time."</option>";
					} ?>
            </select>
            
            <select type="text"  class="date_check1" name="end_ampm1[]" id="end_ampm1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option value="AM">AM</option>
            	<option value="PM">PM</option>
            </select>
            
		</div>
    </div>
	
    <div style="clear:both"></div>
    <input type="checkbox" name="allday1[]" id="allday1" class="allday1" value="1" /> All day
    
    <div style="clear:both"></div>
</div>

<div class="form-light-holder" id="schedule9" style="display:none;">
    <div style="float:left;">
    	<h1>Date</h1>
		<input type="text" value="" name="date1[]" id="date9" class="field mydatetimepicker" placeholder="mm/dd/yyyy" maxlength="10" style="width: 200px; margin: 0;"/>
		<input type="hidden" value="" name="" id="date_hidden9" class="myhiddenvalue" maxlength="10"/>
    </div>
	
    <div style="float:left; margin-left: 20px;">
        <h1>Repeat</h1>
        <select name="repeat1[]" id="repeat1"   style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
        <option value="never">Never</option>
        <option value="Every week">Every week</option>
        <option value="Every year">Every year</option>
        </select>
    </div>
    
    <div style="float:left; margin-left: 20px;" id="time_grp1" class="time_grp1">
    
    	<div style="float: left; width: 275px;">
            <h1>Start</h1>
            
            <select type="text" class="date_check1" name="start_hr1[]" id="start_hr1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Hour</option>
                <?php                 
                 foreach($hrs as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                }
                ?>
            </select>
            
            <select type="text" class="date_check1" name="start_min1[]" id="start_min1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Min</option>
                <?php                		 
                 foreach($mins as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                }
                ?>
            </select>
            
            <select type="text" class="date_check1" name="start_ampm1[]" id="start_ampm1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
            	<option value="AM">AM</option>
            	<option value="PM">PM</option>
            </select>
		</div>
            
		<div  style="float: left; margin-left: 20px;  width:275px">
            <h1>End</h1>
            <select type="text" class="date_check1" name="end_hr1[]" id="end_hr1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Hour</option>
                <?php foreach($hrs as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                } ?>
            </select>
            
            <select type="text" class="date_check1" name="end_min1[]" id="end_min1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Min</option>
                <?php foreach($mins as $time){
						echo "<option value='".$time."'>".$time."</option>";
					} ?>
            </select>
            
            <select type="text"  class="date_check1" name="end_ampm1[]" id="end_ampm1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option value="AM">AM</option>
            	<option value="PM">PM</option>
            </select>
            
		</div>
    </div>
	
    <div style="clear:both"></div>
    <input type="checkbox" name="allday1[]" id="allday1" class="allday1" value="1" /> All day
    
    <div style="clear:both"></div>
</div>

<div class="form-light-holder" id="schedule10" style="display:none;">
    <div style="float:left;">
    	<h1>Date</h1>
		<input type="text" value="" name="date1[]" id="date10" class="field mydatetimepicker" placeholder="mm/dd/yyyy" maxlength="10" style="width: 200px; margin: 0;"/>
		<input type="hidden" value="" name="" id="date_hidden10" class="myhiddenvalue" maxlength="10"/>
    </div>
	
    <div style="float:left; margin-left: 20px;">
        <h1>Repeat</h1>
        <select name="repeat1[]" id="repeat1"   style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
        <option value="never">Never</option>
        <option value="Every week">Every week</option>
        <option value="Every year">Every year</option>
        </select>
    </div>
    
    <div style="float:left; margin-left: 20px;" id="time_grp1" class="time_grp1">
    
    	<div style="float: left; width: 275px;">
            <h1>Start</h1>
            
            <select type="text" class="date_check1" name="start_hr1[]" id="start_hr1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Hour</option>
                <?php                 
                 foreach($hrs as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                }
                ?>
            </select>
            
            <select type="text" class="date_check1" name="start_min1[]" id="start_min1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Min</option>
                <?php                		 
                 foreach($mins as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                }
                ?>
            </select>
            
            <select type="text" class="date_check1" name="start_ampm1[]" id="start_ampm1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
            	<option value="AM">AM</option>
            	<option value="PM">PM</option>
            </select>
		</div>
            
		<div  style="float: left; margin-left: 20px;  width:275px">
            <h1>End</h1>
            <select type="text" class="date_check1" name="end_hr1[]" id="end_hr1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Hour</option>
                <?php foreach($hrs as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                } ?>
            </select>
            
            <select type="text" class="date_check1" name="end_min1[]" id="end_min1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Min</option>
                <?php foreach($mins as $time){
						echo "<option value='".$time."'>".$time."</option>";
					} ?>
            </select>
            
            <select type="text"  class="date_check1" name="end_ampm1[]" id="end_ampm1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option value="AM">AM</option>
            	<option value="PM">PM</option>
            </select>
            
		</div>
    </div>
	
    <div style="clear:both"></div>
    <input type="checkbox" name="allday1[]" id="allday1" class="allday1" value="1" /> All day
    
    <div style="clear:both"></div>
</div>

<div class="form-light-holder" id="schedule11" style="display:none;">
    <div style="float:left;">
    	<h1>Date</h1>
		<input type="text" value="" name="date1[]" id="date11" class="field mydatetimepicker" placeholder="mm/dd/yyyy" maxlength="10" style="width: 200px; margin: 0;"/>
		<input type="hidden" value="" name="" id="date_hidden11" class="myhiddenvalue" maxlength="10"/>
    </div>
	
    <div style="float:left; margin-left: 20px;">
        <h1>Repeat</h1>
        <select name="repeat1[]" id="repeat1"   style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
        <option value="never">Never</option>
        <option value="Every week">Every week</option>
        <option value="Every year">Every year</option>
        </select>
    </div>
    
    <div style="float:left; margin-left: 20px;" id="time_grp1" class="time_grp1">
    
    	<div style="float: left; width: 275px;">
            <h1>Start</h1>
            
            <select type="text" class="date_check1" name="start_hr1[]" id="start_hr1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Hour</option>
                <?php                 
                 foreach($hrs as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                }
                ?>
            </select>
            
            <select type="text" class="date_check1" name="start_min1[]" id="start_min1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Min</option>
                <?php                		 
                 foreach($mins as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                }
                ?>
            </select>
            
            <select type="text" class="date_check1" name="start_ampm1[]" id="start_ampm1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
            	<option value="AM">AM</option>
            	<option value="PM">PM</option>
            </select>
		</div>
            
		<div  style="float: left; margin-left: 20px;  width:275px">
            <h1>End</h1>
            <select type="text" class="date_check1" name="end_hr1[]" id="end_hr1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Hour</option>
                <?php foreach($hrs as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                } ?>
            </select>
            
            <select type="text" class="date_check1" name="end_min1[]" id="end_min1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Min</option>
                <?php foreach($mins as $time){
						echo "<option value='".$time."'>".$time."</option>";
					} ?>
            </select>
            
            <select type="text"  class="date_check1" name="end_ampm1[]" id="end_ampm1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option value="AM">AM</option>
            	<option value="PM">PM</option>
            </select>
            
		</div>
    </div>
	
    <div style="clear:both"></div>
    <input type="checkbox" name="allday1[]" id="allday1" class="allday1" value="1" /> All day
    
    <div style="clear:both"></div>
</div>

<div class="form-light-holder" id="schedule12" style="display:none;">
    <div style="float:left;">
    	<h1>Date</h1>
		<input type="text" value="" name="date1[]" id="date12" class="field mydatetimepicker" placeholder="mm/dd/yyyy" maxlength="10" style="width: 200px; margin: 0;"/>
		<input type="hidden" value="" name="" id="date_hidden12" class="myhiddenvalue" maxlength="10"/>
    </div>
	
    <div style="float:left; margin-left: 20px;">
        <h1>Repeat</h1>
        <select name="repeat1[]" id="repeat1"   style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
        <option value="never">Never</option>
        <option value="Every week">Every week</option>
        <option value="Every year">Every year</option>
        </select>
    </div>
    
    <div style="float:left; margin-left: 20px;" id="time_grp1" class="time_grp1">
    
    	<div style="float: left; width: 275px;">
            <h1>Start</h1>
            
            <select type="text" class="date_check1" name="start_hr1[]" id="start_hr1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Hour</option>
                <?php                 
                 foreach($hrs as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                }
                ?>
            </select>
            
            <select type="text" class="date_check1" name="start_min1[]" id="start_min1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Min</option>
                <?php                		 
                 foreach($mins as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                }
                ?>
            </select>
            
            <select type="text" class="date_check1" name="start_ampm1[]" id="start_ampm1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
            	<option value="AM">AM</option>
            	<option value="PM">PM</option>
            </select>
		</div>
            
		<div  style="float: left; margin-left: 20px;  width:275px">
            <h1>End</h1>
            <select type="text" class="date_check1" name="end_hr1[]" id="end_hr1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Hour</option>
                <?php foreach($hrs as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                } ?>
            </select>
            
            <select type="text" class="date_check1" name="end_min1[]" id="end_min1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Min</option>
                <?php foreach($mins as $time){
						echo "<option value='".$time."'>".$time."</option>";
					} ?>
            </select>
            
            <select type="text"  class="date_check1" name="end_ampm1[]" id="end_ampm1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option value="AM">AM</option>
            	<option value="PM">PM</option>
            </select>
            
		</div>
    </div>
	
    <div style="clear:both"></div>
    <input type="checkbox" name="allday1[]" id="allday1" class="allday1" value="1" /> All day
    
    <div style="clear:both"></div>
</div>

<div class="form-light-holder" id="schedule13" style="display:none;">
    <div style="float:left;">
    	<h1>Date</h1>
		<input type="text" value="" name="date1[]" id="date13" class="field mydatetimepicker" placeholder="mm/dd/yyyy" maxlength="10" style="width: 200px; margin: 0;"/>
		<input type="hidden" value="" name="" id="date_hidden13" class="myhiddenvalue" maxlength="10"/>
    </div>
	
    <div style="float:left; margin-left: 20px;">
        <h1>Repeat</h1>
        <select name="repeat1[]" id="repeat1"   style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
        <option value="never">Never</option>
        <option value="Every week">Every week</option>
        <option value="Every year">Every year</option>
        </select>
    </div>
    
    <div style="float:left; margin-left: 20px;" id="time_grp1" class="time_grp1">
    
    	<div style="float: left; width: 275px;">
            <h1>Start</h1>
            
            <select type="text" class="date_check1" name="start_hr1[]" id="start_hr1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Hour</option>
                <?php                 
                 foreach($hrs as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                }
                ?>
            </select>
            
            <select type="text" class="date_check1" name="start_min1[]" id="start_min1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Min</option>
                <?php                		 
                 foreach($mins as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                }
                ?>
            </select>
            
            <select type="text" class="date_check1" name="start_ampm1[]" id="start_ampm1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
            	<option value="AM">AM</option>
            	<option value="PM">PM</option>
            </select>
		</div>
            
		<div  style="float: left; margin-left: 20px;  width:275px">
            <h1>End</h1>
            <select type="text" class="date_check1" name="end_hr1[]" id="end_hr1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Hour</option>
                <?php foreach($hrs as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                } ?>
            </select>
            
            <select type="text" class="date_check1" name="end_min1[]" id="end_min1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Min</option>
                <?php foreach($mins as $time){
						echo "<option value='".$time."'>".$time."</option>";
					} ?>
            </select>
            
            <select type="text"  class="date_check1" name="end_ampm1[]" id="end_ampm1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option value="AM">AM</option>
            	<option value="PM">PM</option>
            </select>
            
		</div>
    </div>
	
    <div style="clear:both"></div>
    <input type="checkbox" name="allday1[]" id="allday1" class="allday1" value="1" /> All day
    
    <div style="clear:both"></div>
</div>



<div class="form-light-holder" id="schedule14" style="display:none;">
    <div style="float:left;">
    	<h1>Date</h1>
		<input type="text" value="" name="date1[]" id="date14" class="field mydatetimepicker" placeholder="mm/dd/yyyy" maxlength="10" style="width: 200px; margin: 0;"/>
		<input type="hidden" value="" name="" id="date_hidden14" class="myhiddenvalue" maxlength="10"/>
    </div>
	
    <div style="float:left; margin-left: 20px;">
        <h1>Repeat</h1>
        <select name="repeat1[]" id="repeat1"   style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
        <option value="never">Never</option>
        <option value="Every week">Every week</option>
        <option value="Every year">Every year</option>
        </select>
    </div>
    
    <div style="float:left; margin-left: 20px;" id="time_grp1" class="time_grp1">
    
    	<div style="float: left; width: 275px;">
            <h1>Start</h1>
            
            <select type="text" class="date_check1" name="start_hr1[]" id="start_hr1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Hour</option>
                <?php                 
                 foreach($hrs as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                }
                ?>
            </select>
            
            <select type="text" class="date_check1" name="start_min1[]" id="start_min1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Min</option>
                <?php                		 
                 foreach($mins as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                }
                ?>
            </select>
            
            <select type="text" class="date_check1" name="start_ampm1[]" id="start_ampm1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
            	<option value="AM">AM</option>
            	<option value="PM">PM</option>
            </select>
		</div>
            
		<div  style="float: left; margin-left: 20px;  width:275px">
            <h1>End</h1>
            <select type="text" class="date_check1" name="end_hr1[]" id="end_hr1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Hour</option>
                <?php foreach($hrs as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                } ?>
            </select>
            
            <select type="text" class="date_check1" name="end_min1[]" id="end_min1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option disabled="disabled">Select Min</option>
                <?php foreach($mins as $time){
						echo "<option value='".$time."'>".$time."</option>";
					} ?>
            </select>
            
            <select type="text"  class="date_check1" name="end_ampm1[]" id="end_ampm1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
                <option value="AM">AM</option>
            	<option value="PM">PM</option>
            </select>
            
		</div>
    </div>
	
    <div style="clear:both"></div>
    <input type="checkbox" name="allday1[]" id="allday1" class="allday1" value="1" /> All day
    
    <div style="clear:both"></div>
</div>


<script>
$(document).ready(function(){
	$( "#date2" ).datepicker({ dateFormat: "yy-mm-dd",altFormat: 'yy/mm/dd', altField:'#date_hidden2'});
	$( "#date3" ).datepicker({ dateFormat: "yy-mm-dd",altFormat: 'yy/mm/dd', altField:'#date_hidden3'});
	$( "#date4" ).datepicker({ dateFormat: "yy-mm-dd",altFormat: 'yy/mm/dd', altField:'#date_hidden4'});
	$( "#date5" ).datepicker({ dateFormat: "yy-mm-dd",altFormat: 'yy/mm/dd', altField:'#date_hidden5'});
	$( "#date6" ).datepicker({ dateFormat: "yy-mm-dd",altFormat: 'yy/mm/dd', altField:'#date_hidden6'});
	$( "#date7" ).datepicker({ dateFormat: "yy-mm-dd",altFormat: 'yy/mm/dd', altField:'#date_hidden7'});
	$( "#date8" ).datepicker({ dateFormat: "yy-mm-dd",altFormat: 'yy/mm/dd', altField:'#date_hidden8'});
	$( "#date9" ).datepicker({ dateFormat: "yy-mm-dd",altFormat: 'yy/mm/dd', altField:'#date_hidden9'});
	$( "#date10" ).datepicker({ dateFormat: "yy-mm-dd",altFormat: 'yy/mm/dd', altField:'#date_hidden10'});
	$( "#date11" ).datepicker({ dateFormat: "yy-mm-dd",altFormat: 'yy/mm/dd', altField:'#date_hidden11'});
	$( "#date12" ).datepicker({ dateFormat: "yy-mm-dd",altFormat: 'yy/mm/dd', altField:'#date_hidden12'});
	$( "#date13" ).datepicker({ dateFormat: "yy-mm-dd",altFormat: 'yy/mm/dd', altField:'#date_hidden13'});
	$( "#date14" ).datepicker({ dateFormat: "yy-mm-dd",altFormat: 'yy/mm/dd', altField:'#date_hidden14'});
})
</script>

