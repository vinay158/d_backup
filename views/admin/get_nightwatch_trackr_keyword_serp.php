
<?php 
if($respose == 1){
	if(isset($keyword_serp_data->serp) && !empty($keyword_serp_data->serp)){ 
	$i = 1;
		foreach($keyword_serp_data->serp as $serp_data){
?>

<div class="srep_preview_record">
	<div class="col-sm-1 s_no float-left nopadding"><?php echo $i; ?>. </div>
	<div class="col-sm-11 result float-left nopadding">
		<h6 class="heading"><a href="<?php echo $serp_data->href; ?>"><?php echo $serp_data->title; ?></a></h6>
		<p class="url"><?php echo $serp_data->href; ?></p>
		<p class="description"><?php echo $serp_data->description; ?></p>
	</div>
</div>

<?php $i++; } } } ?>
