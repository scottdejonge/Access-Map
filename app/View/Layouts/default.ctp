<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Access Map</title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<link rel="shortcut icon" href="../img/favicon.ico">
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Oswald">
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
	<link href="http://code.google.com/apis/maps/documentation/javascript/examples/default.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="/js/infoBox.js"></script>
	<script type="text/javascript" src="/js/jquery.popover-1.0.6.js"></script>
	<script type="text/javascript" src="/js/markerManager.js"></script>
	<script type="text/javascript" src="/js/userPosition.js"></script>
	<script type="text/javascript" src="/js/mapControls.js"></script>
	<style type="text/css">@import url(/css/style.css);</style>
	<link rel="stylesheet" type="text/css" href="/css/mobile.css" media="screen and (max-width: 1188px)" />
	
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	
	<link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-72x72-precomposed.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="apple-touch-icon-144x144-precomposed.png" /> 
	<link rel="apple-touch-icon" sizes="57x57" href="apple-touch-icon-57x57-precomposed.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-114x114-precomposed.png" />
	
	<link rel="apple-touch-startup-image" sizes="320x480" href="apple-touch-startup-image-320x480.png" />

	<link rel="apple-touch-startup-image" sizes="640x960" href="apple-touch-startup-image-640x960.png" />

	<link rel="apple-touch-startup-image" sizes="768x1004" href="apple-touch-startup-image-768x1004.png" />
	<link rel="apple-touch-startup-image" sizes="1024x748" href="apple-touch-startup-image-1024x748.png" />
	<link rel="apple-touch-startup-image" sizes="1536x2008" href="apple-touch-startup-image-1536x2008.png" />
	<link rel="apple-touch-startup-image" sizes="2048x1496" href="apple-touch-startup-image-2048x1496.png" />
	
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-27681313-1']);
	  _gaq.push(['_setDomainName', 'accessmap.com.au']);
	  _gaq.push(['_trackPageview']);
	
	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	
	</script>
	
	<script>	
		$(document).ready(function() {
			$('.category').each(function() {
				var cat = $(this).children().last().html();
				$(this).popover({
					trigger: 'hover',
					title: cat
				});
			});
			
			$('#dialogue').draggable({ containment: 'parent' });
			
			$('.close').click(function() {
				$('#dialogue').hide();
			});
			
			$('#help').click(function() {
				$('#dialogue').show();
			});
			
		});	
	</script>

<body>

<div id="map-container">

	<div id="help" class="view">
		<img src="img/help.png">
	</div>
	
	<div id="dialogue">
		<div class="close"><img src="../img/close_white.png"></div>
		<h1>Access Map</h1>
		<p>Access Map aims to provide information relating to accessibility of Brisbane locations.</p>
		<ul>
			<li><img src="../img/zoomin.png">Zoom In.</li>
			<li><img src="../img/zoomout.png">Zoom Out.</li>
			<li><img src="../img/home.png">Find Location.</li>
		</ul>
		<p>See more information at: <a href="http://about.accessmap.com.au/">http://about.accessmap.com.au/</a>.</p>
		<p>Data is from the <a href="http://data.brisbane.qld.gov.au/index.php/dataset/brisbane-access-ratings-database/">Brisbane City Council</a>, <a href="http://creativecommons.org/licenses/by/3.0/au/">(CC BY 3.0)</a></p>
	</div>
	
	<div id="map">
		<?php echo $content_for_layout; ?>
	</div>
	
	<!--
<div id="overlay">
		<div id="zoomin">Zoom In Button</div>
		<div id="zoomout">Zoom Out Button</div>
		<div id="userposition">Mark your Position</div>
		<div id="nav">Filter the categories that display on the Map</div>	
		<div id="overlay-background"></div>
	</div>
	
-->
	<div id="copyright">
		<p>Data is from the <a href="http://data.brisbane.qld.gov.au/index.php/dataset/brisbane-access-ratings-database/">Brisbane City Council</a></p>
		<p><a href="http://creativecommons.org/licenses/by/3.0/au/">(CC BY 3.0)</a></p>
	</div>

	<div id="navigation">
		<div id="logo"><img src="../img/logo_small.png"></div>
		<h1>AccessMap</h1>
		<div id="categories">
			<?php echo $this->element('categories'); ?>
		</div>
	</div>
	
</div>

</body>
</html>