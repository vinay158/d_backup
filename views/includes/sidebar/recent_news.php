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

$_SLUG = array('news');

foreach($_SLUG as $needle) {
	$slug = array_search($needle, $_URL);
	if($slug == false) { $$needle = $needle; } 
	else { $$needle = $slug; }
}

?>		
			<ul class="recent_news">
				<?php foreach($sideitems as $row): ?>
				<li>
				<!--<a href="<?=$news?>/index/<?=$row->id?>">-->
                <a href="<?=$news?>/<?=$row->slug?>">
				<?=$row->title?>
				<span  class="meta_date"><?=date_format(date_create($row->timestamp), "F dS, Y");?></span>
				</a>
				</li>
				<?php endforeach;?>
			</ul>
			<!-- END .recent_news -->