<?php
$cats = array();
foreach($access as $point) {	
	$unicat = array();
	$cats[] = $point['Accessmap']['category'];
}
$cats = array_unique($cats);
?>

<ul class="categories">
	<?php foreach($cats as $cat): 
		$category = strtolower(str_replace("&","and",str_replace(" ","_",str_replace("/","",$cat))));
	?>
	<li class="category <?php echo $category;?> deselected" data-cat="<?php echo $cat;?>">
		<img src="/img/icons/<?php echo $category; ?>.png" />
		<p><?php echo $cat; ?></p>
	</li>
	<?php endforeach; ?>
</ul>