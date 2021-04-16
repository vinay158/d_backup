<div class="row">

          <div class="col-sm-12 col-xl-12">
<table id="example2"  class="table table-bordered">
	<thead>
		<tr>
			<td><strong>Class Name</strong></td>
			<td><strong>Day </strong></td>
			<td><strong>Attendance Date </strong></td>
			<td><strong>School</strong></td>
		</tr>
	</thead>
    <tbody >
		<?php 
			if(!empty($attendances)){
				foreach($attendances  as $attendance){
		?>
			
		<tr>
			<td><?php echo ucfirst($attendance->class_name); ?> </td>
			<td><?php echo $attendance->today_weekday; ?> </td>
			<td><?php echo date('d M, Y ', strtotime($attendance->attendance_date)); ?></td>
			<td><?php echo ucfirst($attendance->location); ?> </td>
		</tr>	
			<?php } } ?>
	</tbody> 
</table>
<br/>
Total Attendance:  <?php echo count($attendances); ?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Last Attendance: <?php echo !empty($last_attendance) ? date('d M, Y ', strtotime($last_attendance[0]->attendance_date)) : ''; ?>

</div>
</div>