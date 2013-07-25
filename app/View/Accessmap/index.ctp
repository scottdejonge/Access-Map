<div id="map_canvas"></div>

<script type="text/javascript">

var markerSize = 65;
var infoBoxState = false;
var streetView = new google.maps.StreetViewService();

function initialize() {

	var markerObject = new Object();

	$('.category').toggle(function() {
	
		var cat_code = $(this).attr('data-cat');
		if(!$(this).hasClass('downloaded')) {
			getMarkersFromServer(cat_code);
		}
		if(markerObject[cat_code]) {
			markerObject[cat_code]["display"] = true;
			//console.log("display is " + markerObject[cat_code]["display"] + " for " + cat_code);
		}	
		$(this).removeClass('deselected');
		refreshMarkers();
		
	}, function() {
	
		$(this).addClass('deselected');

		var cat_code = $(this).attr('data-cat');

		if(markerObject[cat_code]) {
			for(var marker_id in markerObject[cat_code]["markers"]) {
				var marker = markerObject[cat_code]["markers"][marker_id];
				mgr.removeMarker(marker);
			}
			markerObject[cat_code]["display"] = false;
			//console.log("display is " + markerObject[cat_code]["display"] + " for " + cat_code);
		}
		infoBox.close();
		refreshMarkers();
	});
	
	var brisbane = new google.maps.LatLng(-27.470924772181082, 153.02348971366882);
	
	// Google Map Options		
	var mapOptions = {
		zoom: 14,
		maxZoom: 18,
		minZoom: 10,
		scrollWheel: false,
		center: brisbane,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		mapTypeControl: false,
		panControl: false,
		zoomControl: false,
		scaleControl: false,
		streetViewControl: false
	}
	
	// Create the Map
	map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
	
	// Styling the Map
	var mapStyle = [ {
		featureType: "poi.park", elementType: "all", elementType: "geometry", stylers: [ { visibility: "on" }, { hue: "#A8BB43" } , { lightness: -10 } ] },{
		featureType: "poi.medical", elementType: "all", elementType: "geometry", stylers: [ { visibility: "on" }, { hue: "#C72518" } , { lightness: -10 } ] },{
		featureType: "poi.sports_complex", elementType: "all", elementType: "geometry", stylers: [ { visibility: "on" }, { hue: "#ECD14A" } , { lightness: -10 } ] },{
		featureType: "landscape.man_made", elementType: "all", stylers: [ { visibility: "simplified" } ] },{
		featureType: "poi", elementType: "all", elementType: "labels", stylers: [ { visibility: "off" } ] },{
		featureType: "water", elementType: "all", stylers: [ { visibility: "on" }, { hue: "#2957b3" }, { saturation: 50 } , { lightness: 10 } ] },{
		featureType: "road.highway", elementType: "all", stylers: [ { visibility: "on" }, { saturation: -100 }, { lightness: 25 }  ] },{
		featureType: "road.arterial", elementType: "all", stylers: [ { visibility: "on" }, { saturation: -100 }, { lightness: 25 } ] }
	];
	
	var styledMapOptions = {map: map, name: "accessmap"}
	var styledMap =  new google.maps.StyledMapType(mapStyle,styledMapOptions);
	
	map.mapTypes.set('accessmap', styledMap);
	map.setMapTypeId('accessmap');
	
	// Zoom In Control
	var zoomInControlDiv = document.createElement('DIV');
	var zoomInControl = new ZoomInControl(zoomInControlDiv, map);
	zoomInControlDiv.index = 1;
	map.controls[google.maps.ControlPosition.LEFT_TOP].push(zoomInControlDiv);
	
	// Zoom Out Control
	var zoomOutControlDiv = document.createElement('DIV');
	var zoomOutControl = new ZoomOutControl(zoomOutControlDiv, map);
	zoomOutControlDiv.index = 1;
	map.controls[google.maps.ControlPosition.LEFT_TOP].push(zoomOutControlDiv);
	
	// Home Control
	var homeControlDiv = document.createElement('DIV');
	var homeControl = new HomeControl(homeControlDiv, map);
	homeControlDiv.index = 1;
	map.controls[google.maps.ControlPosition.LEFT_TOP].push(homeControlDiv);
	
	// Create the Infowindow
	infowindow = new google.maps.InfoWindow({content: '', zIndex: 999});
	
	// Create the InfoBox
	var infoBoxOptions = {
		disableAutoPan: false,
		maxWidth: 0,
		pixelOffset: new google.maps.Size(-27,-216),
		zIndex: null,
		closeBoxMargin: "0",
		closeBoxURL: "../img/close.png",
		infoBoxClearance: new google.maps.Size(1, 1),
		isHidden: false,
		pane: "floatPane",
		enableEventPropagation: false
    };

    infoBox = new InfoBox(infoBoxOptions);
    
	// Create the Markers
	function getMarkersFromServer(cat_code) {
		//accessmap.com.au
		$.getJSON('/ajax/data/' + cat_code, function(data) {
		
			$.each(data, function(i, accessmap) {
				$('.category[data-cat="'+ cat_code +'"]').addClass('downloaded');
		
				for(var point in accessmap) {
				
					var id = accessmap[point]['id'];
					var location = accessmap[point]['location'];
					var suburb = accessmap[point]['suburb'];
					var region = accessmap[point]['region'];
					var rating = accessmap[point]['rating'];
					var description = accessmap[point]['description'];	
					var category = accessmap[point]['category'];
					var subcategory = accessmap[point]['subcategory'];				
					var latitude = accessmap[point]['latitude'];
					var longitude = accessmap[point]['longitude'];
					var streetViewURL = 'http://cbk0.google.com/cbk?output=thumbnail&w=430&h=65&ll='+latitude+','+longitude+'';
					
					// Cutom Marker Images
					var custommarker = new google.maps.MarkerImage('img/markers/' + category + '/' + subcategory + '.png',
						new google.maps.Size(markerSize, markerSize),
						new google.maps.Point(0,0),
						new google.maps.Point(32,65),
						new google.maps.Size(markerSize,markerSize)
					);
					
					custommarker.scaledSize = new google.maps.Size(markerSize, markerSize);
					
					var position = new google.maps.LatLng(latitude, longitude);
					
					// Make a Marker	
					var marker = new google.maps.Marker({
						position: position, 
						animation: google.maps.Animation.DROP,
						icon: custommarker,
						title: location
					});   
					
					if(!markerObject[cat_code]) {
						markerObject[cat_code] = {
							'display': true,
							'markers': {}
						};
					}
					
					markerObject[cat_code]["markers"][id] = marker;
					
					var ratingString = "";
					for(var i = 0; i < rating; i++) {
						ratingString = ratingString + '<img src=\'/img/star.png\' />'
					}
					
					var contentString =
					'<div>' +
						'<img class="streetview" src="'+streetViewURL+'" />' +
						'<h1>' + location + '</h1>' +
						'<div id=\'ratings\'><img src=\'/img/star.png\' />' + ratingString + '</div>' +
						'<p><strong>Description: </strong>' + description + '</p>' +
						'<p><strong>Suburb: </strong>' + suburb + '</p>' +
						'<div id=\'footer\' class=\'' + category + '\'>'+
							'<img src=\'/img/icons/' + category + '/'+ subcategory + '.png\'>' +
							'<small>' + category.replace(/_/g, ' ') + ' - ' + subcategory.replace(/_/g, ' ') + '</small>' +
						'<div>' +
					'</div>';
			        
					google.maps.event.addListener(marker, 'click', function() {
						infoBox.setContent(contentString);
						infoBox.open(map, marker);
						//map.panTo(position);
						infoBoxState = true;
					});
					
					// Add the Marker to the Marker Manager
					mgr.addMarker(marker)
				}
			});
			refreshMarkers();
		});
	}
	
	google.maps.event.addListener(map, 'click', function() {
		if (infoBoxState == true) {
			infoBox.close();
			infoBoxState = false;
		}
	});
	
	// Marker Manager
	var listener = google.maps.event.addListener(map, 'bounds_changed', function() {
		console.log("Maker Manager Setup");
		setupMarkers();
		google.maps.event.removeListener(listener);
	});
	
	// Setup Markers
	function setupMarkers() {
		var mgrOptions = { borderPadding: 0, trackMarkers: true };
		mgr = new MarkerManager(map, mgrOptions);
		google.maps.event.addListener(mgr, 'loaded', function() {
			refreshMarkers();
		});
	}

	// Get Markers
	function getMarkers(n, zoomLevel) {		
		var markers = new Array();
		// loop through the markers
		adding:	for(var cat_code in markerObject) {
			// check if we should show it
			if(markerObject[cat_code]["display"]) {
				for(var marker_id in markerObject[cat_code]["markers"]) {
					markers.push(markerObject[cat_code]["markers"][marker_id]);
					n--;
					if(!n) { 
						break adding;
					}
				}
			}
		}
		//console.log("markers length is " + markers.length);
		return markers;
	}

	// Refresh Markers
	function refreshMarkers() {
		console.log("Refreshing Markers");
				mgr.addMarkers(getMarkers(200), 10);
		mgr.addMarkers(getMarkers(250), 11);
		mgr.addMarkers(getMarkers(350), 12);
		mgr.addMarkers(getMarkers(500), 13);
		mgr.addMarkers(getMarkers(750), 14);
		mgr.addMarkers(getMarkers(1500), 15);
		mgr.addMarkers(getMarkers(5000), 16);
		
		/*
mgr.addMarkers(getMarkers(1000), 10);
		mgr.addMarkers(getMarkers(500), 16);
*/
		mgr.refresh();
	}
	
	google.maps.event.addListener(map, 'bounds_changed', function() {
		console.log("blbk");
		refreshMarkers();
	});
}

google.maps.event.addDomListener(window, 'load', initialize);

</script>