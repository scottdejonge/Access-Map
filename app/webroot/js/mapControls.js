/*
function HelpControl(controlDiv, map) {

  controlDiv.style.margin = '20px 0px 0px 20px';
  controlDiv.style.zIndex = '9999';
  
  var controlUI = document.createElement('DIV');
  controlUI.style.cursor = 'pointer';
  controlUI.style.textAlign = 'center';
  controlUI.title = 'Home';
  controlDiv.appendChild(controlUI);

  var controlText = document.createElement('DIV');
  controlText.style.fontFamily = 'Arial,sans-serif';
  controlText.style.fontSize = '16px';
  controlText.innerHTML = '<img src="../img/help.png">';
  controlText.style.zIndex = '999';
  controlUI.appendChild(controlText);

  google.maps.event.addDomListener(controlUI, 'click', function() {
	if (overlayState == false) {
		$('#overlay').show();	
		overlayState = true;
	} else {
		$('#overlay').hide();	
		overlayState = false;
	}
  });
}
*/

function ZoomInControl(controlDiv, map) {
  controlDiv.style.margin = '100px 0px 0px 20px';
  controlDiv.style.zIndex = '9999';
  
  var controlUI = document.createElement('DIV');
  controlUI.style.cursor = 'pointer';
  controlUI.style.textAlign = 'center';
  controlUI.title = 'Click to Zoom In';
  controlDiv.appendChild(controlUI);

  var controlText = document.createElement('DIV');
  controlText.style.fontFamily = 'Arial,sans-serif';
  controlText.style.fontSize = '16px';
  controlText.innerHTML = '<img src="../img/zoomin.png">';
  controlText.style.zIndex = '999';
  controlUI.appendChild(controlText);

  google.maps.event.addDomListener(controlUI, 'click', function() {
	 var newZoom = map.getZoom() + 1; 
 	 map.setZoom(newZoom); 
  });
}

function ZoomOutControl(controlDiv, map) {

  controlDiv.style.margin = '10px 0px 0px 20px';
  controlDiv.style.zIndex = '9999';
  
  var controlUI = document.createElement('DIV');
  controlUI.style.cursor = 'pointer';
  controlUI.style.textAlign = 'center';
  controlUI.title = 'Click to Zoom Out';
  controlDiv.appendChild(controlUI);

  var controlText = document.createElement('DIV');
  controlText.style.fontFamily = 'Arial,sans-serif';
  controlText.style.fontSize = '16px';
  controlText.innerHTML = '<img src="../img/zoomout.png">';
  controlText.style.zIndex = '999';
  controlUI.appendChild(controlText);

  google.maps.event.addDomListener(controlUI, 'click', function() {
	 var newZoom = map.getZoom() - 1; 
 	 map.setZoom(newZoom); 
  });
}

function HomeControl(controlDiv, map) {

  controlDiv.style.margin = '10px 0px 0px 20px';
  controlDiv.style.zIndex = '999';
  
  var controlUI = document.createElement('DIV');
  controlUI.style.cursor = 'pointer';
  controlUI.style.textAlign = 'center';
  controlUI.title = 'Home';
  controlDiv.appendChild(controlUI);

  var controlText = document.createElement('DIV');
  controlText.style.fontFamily = 'Arial,sans-serif';
  controlText.style.fontSize = '16px';
  controlText.innerHTML = '<img src="../img/home.png">';
  controlText.style.zIndex = '999';
  controlUI.appendChild(controlText);

  google.maps.event.addDomListener(controlUI, 'click', function() {
	if(navigator.geolocation) {
		userPosition();	
		//homeMarker.setMap(null);
	} else { 
		handleNoGeolocation(false); 
	}
  });
}