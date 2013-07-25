<?php
foreach($points as $point) :
	$category = strtolower(str_replace("&","and",str_replace(" ","_",str_replace("/","",$point['Accessmap']['category']))));
	$subcategory = strtolower(str_replace("&","and",str_replace(" ","_",str_replace("/","",$point['Accessmap']['subcategory']))));
	$location = strtolower($point['Accessmap']['suburb']);
	$name = strtolower($point['Accessmap']['location']);
	$rating = $point['Accessmap']['rating'];
?>

<div class="location">
	<h1><?php echo $name; ?></h1>
	<div id="ratings">

		<?php for ($i = 0; $i < $rating + 1; $i += 1) : ?>
		<img src="img/star.png" alt="star" />
		<?php endfor; ?>
		<p>
			<?php echo $point['Accessmap']['description'];?>
		</p>
	</div>

	<p><strong>Suburb: </strong><?php echo $location; ?></p>
	<p><strong>Description: </strong><?php echo $point['Accessmap']['description']; ?></p>
	<div id="footer" class="<?php echo $category; ?>">
		<img src="/img/icons/<?php echo "{$category}/{$subcategory}"; ?>.png">
		<small><?php echo $point['Accessmap']['category'] . ' - ' . $point['Accessmap']['subcategory']; ?></small>
	</div>
</div>

<?php endforeach; ?>