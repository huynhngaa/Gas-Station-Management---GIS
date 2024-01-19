<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8' />
	<title>Leaflet and Mapbox Directions Example</title>
	<meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />

	<!-- Load Leaflet from CDN -->
	<link rel='stylesheet' href='https://unpkg.com/leaflet/dist/leaflet.css' />
	<script src='https://unpkg.com/leaflet/dist/leaflet.js'></script>

	<!-- Load Mapbox GL JS and Geocoder from CDN -->
	<script src='https://api.mapbox.com/mapbox-gl-js/v2.4.1/mapbox-gl.js'></script>
	<link href='https://api.mapbox.com/mapbox-gl-js/v2.4.1/mapbox-gl.css' rel='stylesheet' />
	<script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.js'></script>
	<link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.css' type='text/css' />

	<!-- Load Leaflet Search Plugin from CDN -->
	<link rel="stylesheet" href="https://unpkg.com/leaflet-search/dist/leaflet-search.min.css" />
	<script src="https://unpkg.com/leaflet-search/dist/leaflet-search.min.js"></script>
	<style>
		#map {
			height: 500px;
			width: 100%;
		}
	</style>
</head>
<body>
	<div id='map'></div>
	<script>
		// Initialize Leaflet map
		// var map = L.map('map').setView([51.505, -0.09], 13);
		var map = L.map('map').setView([10.0279603, 105.7664918], 15);
var layer = new L.TileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
  maxZoom: 20,
  subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
});
map.addLayer(layer);
	 var markersLayer = new L.LayerGroup();	//layer contain searched elements
	 map.addLayer(markersLayer);
		// Initialize Mapbox GL JS and directions control
		mapboxgl.accessToken = 'pk.eyJ1IjoiaHV5bmhuZ2EiLCJhIjoiY2xnajV4OGt3MGp3MDNmcDR0MjVuZTQxbiJ9.Tx546eIoBUlgx2UwnVmy4g';
		var directions = new MapboxDirections({
			accessToken: mapboxgl.accessToken,
			unit: 'metric',
			profile: 'mapbox/walking',
		});
		map.addControl(directions, 'top-left');

		// Initialize Leaflet search plugin
		var searchControl = new L.Control.Search({
			position: 'topright',
			layer: markersLayer,
			initial: false,
			propertyName: 'name',
			marker: false,
			moveToLocation: function(latlng) {
				map.setView(latlng, 16);
			},
		});
		map.addControl(searchControl);

		// Add a default marker for the user's current location
		var userMarker = null;
		map.locate({ setView: true, maxZoom: 16 });
		function onLocationFound(e) {
			if (userMarker != null) {
				map.removeLayer(userMarker);
			}
			userMarker = L.marker(e.latlng).addTo(map);
		}
		map.on('locationfound', onLocationFound);

		// Add markers layer to map
		var markersLayer = L.layerGroup().addTo(map);

		// Add a sample marker to the map
		var marker = L.marker([51.5, -0.09]).addTo(markersLayer);
		marker.bindPopup('Hello world!');

		// Add an event listener to open the popup of the marker when it's found by the search control
		searchControl.on('search:locationfound', function(e) {
			if (e.layer === marker) {
				marker.openPopup();
			}
		});

		directions.on('route', function(e) {
// Remove previous route layers
map.eachLayer(function(layer) {
if (layer instanceof L.Polyline) {
map.removeLayer(layer);
}
});


// Add the new route layer
var routeLayer = L.geoJSON(e.route.geometry).addTo(map);

// Fit the map to the bounds of the route
map.fitBounds(routeLayer.getBounds());
});

// Add an event listener to show a message if the route calculation fails
directions.on('error', function(e) {
alert('Unable to calculate route. Please try again.');
});
</script>

</body>
</html>
