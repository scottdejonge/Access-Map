var userPositionMarker = null;

function userPosition() {

	navigator.geolocation.getCurrentPosition(function(position) {
	
		var position = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
				
		if(userPositionMarker) {
			if(userPositionMarker.getPosition().equals(position)) {
				map.panTo(position);
				return;
			} else {		
				userPositionMarker.setMap(null);
			}
		}

		var homeCustomIcon= new google.maps.MarkerImage('img/markers/home.png',
			new google.maps.Size(markerSize, markerSize),
			new google.maps.Point(0,0),
			new google.maps.Point(18,42),
			new google.maps.Size(markerSize, markerSize)
		);
		
		homeCustomIcon.scaledSize = new google.maps.Size(markerSize, markerSize);
		
		var homeMarker = new google.maps.Marker({
			position: position, 
			animation: google.maps.Animation.DROP,
			map: map,
			icon: homeCustomIcon,
			title: 'You Are Here'
		});  
		
		userPositionMarker = homeMarker;
				
		google.maps.event.addListener(homeMarker, 'click', function() {
			//infowindow.setContent('<h1>You Are Here.</h1>'); 
			//infowindow.open(map, this); 
			map.panTo(position);
		});

	
		map.panTo(position);
	}, 
		function() { 
			handleNoGeolocation(true); 
		}
	);
}