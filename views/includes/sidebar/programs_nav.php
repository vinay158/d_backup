<?php
$_URL = array();
$query = $this->db->get( 'tblmeta' );
$result = $query->result();
foreach( $result as $row )
{
	if(!empty($row->slug) && !empty($row->page)) {
		$_URL[trim($row->slug)] = trim($row->page);
	}
}

$_SLUG = array('ourprograms');

foreach($_SLUG as $needle) {
	$slug = array_search($needle, $_URL);
	if($slug == false) { $$needle = $needle; } 
	else { $$needle = $slug; }
}

?>		
		<li class="sidebar_nav">
			
			<ul class="accordion_nav">
			<?php 
			$program_nav = $this->query_model->getCategory("programs");
			if(!empty($program_nav)) {
				foreach($program_nav as $nav_item_prog) {
					$published = 1;
					$query_sub = $this->query_model->getbySpecificRecord("tblprogram", "category", $nav_item_prog->cat_id,$published);
					if(isset($query_sub) && !empty($query_sub)) {
			?>
					<li>
					<a href="#" class="button"><?=$nav_item_prog->cat_name?></a>
					<ul class="sub_menu">
						<?php
						foreach($query_sub as $subnav_item_prog) {
							$cat_name=str_replace(" ",'-',trim($nav_item_prog->cat_name)); 
							$subcat_name=str_replace(" ",'-',trim($subnav_item_prog->program));  
						?>
						<li><a href="<?=$ourprograms?>/view/<?=$subnav_item_prog->id?>/<?=$cat_name?>#<?=$subcat_name;?>"><?=trim($subnav_item_prog->program);?></a></li>
						<?php } ?>
					</ul>
					</li>
				<?php
					}
				}
			 } 
			?>
			</ul>
			<!-- END .accordion_nav -->
		
		</li>
		<!-- sidebar_nav -->
