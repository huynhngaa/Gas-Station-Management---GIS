
<?php
// Kết nối đến cơ sở dữ liệu MySQL
$pdo = new PDO('mysql:host=localhost;dbname=congty2', 'root', '');

// Thực hiện truy vấn để lấy dữ liệu từ bảng 'locations'
$stmt = $pdo->query('SELECT * FROM trambanle a, loaixangdau b,congtydaumoi c  where a.l_ma =b.l_ma and a.ct_ma =c.ct_ma ');

// Tạo mảng chứa dữ liệu
$data = array('type' => 'FeatureCollection', 'features' => array());

// Đọc dữ liệu từ truy vấn và thêm vào mảng
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $feature = array(
        'type' => 'Feature',
        'geometry' => array(
            'type' => 'Point',  
            'coordinates' => array($row['t_long'], $row['t_lat'])
        ),
        'properties' => array(
          'name' => $row['t_ten'],
            'id' => $row['ct_ma'],
            'lx' => $row['l_ten'],
            'icon' => $row['ct_logo']
          
            
            
        )
    );
    array_push($data['features'], $feature);
}

// Chuyển đổi dữ liệu sang chuỗi JSON
$json = json_encode($data);

// Tạo tệp GeoJSON từ chuỗi JSON
$fp = fopen('locations.geojson', 'w');
fwrite($fp, $json);
fclose($fp);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Quản lý trạm xăng</title> 
<link rel="icon" href="admin/images/logo.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
      href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700"
      rel="stylesheet"
    />
    <!-- Mapbox GL JS -->
    <script src="https://api.tiles.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>
    <link
      href="https://api.tiles.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css"
      rel="stylesheet"
    />
    <!-- Geocoder plugin -->
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js"></script>
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css" type="text/css">
    <!-- Turf.js plugin -->
    <script src="https://npmcdn.com/@turf/turf/turf.min.js"></script>
    <style>
      body {
        color: #404040;
        font: 400 15px/22px 'Source Sans Pro', 'Helvetica Neue', sans-serif;
        margin: 0;
        padding: 0;
        -webkit-font-smoothing: antialiased;
      }

      * {
        box-sizing: border-box;
      }

      .sidebar {
        position: absolute;
        width: 25%;
        height: 100%;
        top: 0;
        left: 0;
        overflow: hidden;
        border-right: 1px solid rgba(0, 0, 0, 0.25);
      }
      .pad2 {
        padding: 20px;
      }

      .map {
        position: absolute;
        left: 25%;
        width: 75%;
        top: 0;
        bottom: 0;
      }

      h1 {
        font-size: 22px;
        margin: 0;
        font-weight: 400;
        line-height: 20px;
        padding: 20px 2px;
      }

      a {
        color: #404040;
        text-decoration: none;
      }

      a:hover {
        color: #101010;
      }

      .heading {
        background: #fff;
        border-bottom: 1px solid #eee;
        min-height: 60px;
        line-height: 60px;
        padding: 0 10px;
        background-color: #00853e;
        color: #fff;
      }

      .listings {
        height: 100%;
        overflow: auto;
        padding-bottom: 60px;
      }

      .listings .item {
        border-bottom: 1px solid #eee;
        padding: 10px;
        text-decoration: none;
      }

      .listings .item:last-child {
        border-bottom: none;
      }
      .listings .item .title {
        display: block;
        color: #00853e;
        font-weight: 700;
      }

      .listings .item .title small {
        font-weight: 400;
      }
      .listings .item.active .title,
      .listings .item .title:hover {
        color: #8cc63f;
      }
      .listings .item.active {
        background-color: #f8f8f8;
      }
      ::-webkit-scrollbar {
        width: 3px;
        height: 3px;
        border-left: 0;
        background: rgba(0, 0, 0, 0.1);
      }
      ::-webkit-scrollbar-track {
        background: none;
      }
      ::-webkit-scrollbar-thumb {
        background: #00853e;
        border-radius: 0;
      }

      .marker {
        border: none;
        cursor: pointer;
        height: 56px;
        width: 56px;
        /* background-image: url(marker.png); */
      }

      /* Marker tweaks */
      .mapboxgl-popup {
        padding-bottom: 50px;
      }

      .mapboxgl-popup-close-button {
        display: none;
      }
      .mapboxgl-popup-content {
        font: 400 15px/22px 'Source Sans Pro', 'Helvetica Neue', sans-serif;
        padding: 0;
        width: 180px;
      }

      .mapboxgl-popup-content h3 {
        background: #91c949;
        color: #fff;
        margin: -15px 0 0;
        padding: 10px;
        border-radius: 3px 3px 0 0;
        font-weight: 700;
      }

      .mapboxgl-popup-content h4 {
        margin: 0;
        padding: 10px;
        font-weight: 400;
      }

      .mapboxgl-popup-content div {
        padding: 10px;
      }

      .mapboxgl-popup-anchor-top > .mapboxgl-popup-content {
        margin-top: 15px;
      }

      .mapboxgl-popup-anchor-top > .mapboxgl-popup-tip {
        border-bottom-color: #91c949;
      }

      .mapboxgl-ctrl-geocoder {
        border-radius: 0;
        position: relative;
        top: 0;
        width: 800px;
        margin-top: 0;
        border: 0;
      }

      .mapboxgl-ctrl-geocoder > div {
        min-width: 100%;
        margin-left: 0;
      }
    </style>
  </head>
  <body>
  <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.1/mapbox-gl-directions.js"></script>
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.1/mapbox-gl-directions.css" type="text/css">
    <div class="sidebar">
      <div class="heading">
        <h1>Danh sách trạm bán lẻ</h1>
      </div>
   



      <div id="listings" class="listings"></div>
      
    </div>
    <div id="map" class="map"></div>
    <input type="text" id="searchInput" placeholder="Tìm kiếm theo tên" />

    <script>
      mapboxgl.accessToken = 'pk.eyJ1IjoiaHV5bmhuZ2EiLCJhIjoiY2xnajV4OGt3MGp3MDNmcDR0MjVuZTQxbiJ9.Tx546eIoBUlgx2UwnVmy4g';

      /**
       * Add the map to the page
       */
      const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v12',
        center: [105.771535,10.030320],
        zoom: 13,
       
      });

const nav = new mapboxgl.NavigationControl();
map.addControl(nav, 'top-right');

// Initialize the GeolocateControl.
const geolocate = new mapboxgl.GeolocateControl({
  positionOptions: {
    enableHighAccuracy: true
  },
  trackUserLocation: true
});
// Add the control to the map.
map.addControl(geolocate);







const directions = new MapboxDirections({
  accessToken: mapboxgl.accessToken,
  unit: 'metric',
  profile: 'mapbox/driving',
  language: 'vi',
  controls: {
    inputs: false,
    instructions: true
  }
});
map.addControl(directions, 'top-left');


fetch('locations.geojson')
  .then(response => response.json())
  .then(data => {
    const stores = data;
    // Do something with the GeoJSON data
 

     // const stores = 
    

      map.on('load', () => {  
        

       // Kết quả: 0.34322301099416244 (đơn vị kilometers)

        map.addSource('places', {
          'type': 'geojson',
          'data': stores
        });

        const geocoder = new MapboxGeocoder({
          accessToken: mapboxgl.accessToken,
          mapboxgl: mapboxgl,
          marker: true,
          bbox: [105.681875, 10.054843, 105.862016, 9.926315]
        });
        buildLocationList(stores);
        map.addControl(geocoder, 'top-left');
        addMarkers();


});
//////////////////////////////////////////////////////////////////////
      function getBbox(sortedStores, storeIdentifier, searchResult) {
        const lats = [
          sortedStores.features[storeIdentifier].geometry.coordinates[1],
          searchResult.coordinates[1]
        ];
        const lons = [
          sortedStores.features[storeIdentifier].geometry.coordinates[0],
          searchResult.coordinates[0]
        ];
        const sortedLons = lons.sort((a, b) => {
          if (a > b) {
            return 1;
          }
          if (a.distance < b.distance) {
            return -1;
          }
          return 0;
        });
        const sortedLats = lats.sort((a, b) => {
          if (a > b) {
            return 1;
          }
          if (a.distance < b.distance) {
            return -1;
          }
          return 0;
        });
        return [
          [sortedLons[0], sortedLats[0]],
          [sortedLons[1], sortedLats[1]]
        ];
      }
//////////////////////////////////////////////////////////////////////////////////////
    
function addMarkers() {
  for (const marker of stores.features) {
    // Get icon image from GeoJSON properties
    const iconImage = `admin/images/${marker.properties.icon}`;
    
    // Create img element for marker icon
    const iconImg = document.createElement('img');
    iconImg.src = iconImage;
    iconImg.style.width = '35px';
    iconImg.style.height = '40px';

    // Create div element for marker
    const el = document.createElement('div');
    el.id = `marker-${marker.properties.id}`;
    el.className = 'marker';
    el.appendChild(iconImg);

    new mapboxgl.Marker(el, { offset: [0, -23] })
      .setLngLat(marker.geometry.coordinates)
      .addTo(map);

    el.addEventListener('click', (e) => {
    //  flyToStore(marker);
      createPopUp(marker);
      const activeItem = document.getElementsByClassName('active');
      e.stopPropagation();
      if (activeItem[0]) {
        activeItem[0].classList.remove('active');
      }
      const listing = document.getElementById(
        `listing-${marker.properties.id}`
      );
      listing.classList.add('active');
    });
  }
}
////////////////////

// const filter = document.getElementById('filter');
// filter.addEventListener('change', function () {
//   const selectedId = filter.value;
//   for (const store of stores.features) {
//   const storesToShow = stores.features.filter(function (store) {
//     return store.properties.id.toString() === selectedId || selectedId === '';
//   });
  
//   buildLocationList();
// });

//////////////
function buildLocationList(stores) {
        
        for (const store of stores.features) {
         
          const listings = document.getElementById('listings');
          const listing = listings.appendChild(document.createElement('div'));
          listing.id = `listing-${store.properties.id}`;
          listing.className = 'item';
          const link = listing.appendChild(document.createElement('a'));
          link.href = '#';
          link.className = 'title';
          link.id = `link-${store.properties.id}`;
          link.innerHTML = `${store.properties.name}`;
        //  link.ad = `${store.properties.loai}`;
          const details = listing.appendChild(document.createElement('div'));
        //  details.innerHTML = `${store.properties.name}`;
         details.innerHTML = `${
  store.properties.id === 1 ? 'Công ty Petrolimex' :
  store.properties.id === 2 ? 'Công ty MIPECO' :
  store.properties.id === 3 ? 'Công ty PVOIL' :
  store.properties.id === 4 ? 'Công ty Orient Oil' : ''
}`;

geolocate.on('geolocate', function(e) {
  userLocation = [e.coords.longitude, e.coords.latitude];
  const options = { units: 'kilometers' };
const from = userLocation;
const to = store.geometry;
const distance = turf.distance(from, to, options);
console.log(distance); 

         // if (store.properties.distance) {
            const roundedDistance =
              Math.round(distance * 100) / 100;
            details.innerHTML += `<div><strong>${roundedDistance} kilometers</strong></div>`;});
       //  }
          link.addEventListener('click', function () {
  // Set destination to the coordinates of the store marker
  const destination = [store.geometry.coordinates[0], store.geometry.coordinates[1]];
  showRoute(destination);
  for (const feature of stores.features) {
    if (this.id === `link-${feature.properties.id}`) {
      flyToStore(feature);
      createPopUp(feature);
    }
  }

  // Highlight the active item in the location list
  const activeItem = document.getElementsByClassName('active');
  if (activeItem[0]) {
    activeItem[0].classList.remove('active');
  }
  this.parentNode.classList.add('active');
});



function showRoute(destination) {
  navigator.geolocation.getCurrentPosition(function (position) {
    const start = [position.coords.longitude, position.coords.latitude];

    const directions = new MapboxDirections({
      accessToken: mapboxgl.accessToken,
      unit: 'metric',
      profile: 'mapbox/driving',
      interactive: false,
      controls: {
        instructions: false,
      },
    });

    directions.setOrigin(start);
    directions.setDestination(destination);

    map.addControl(directions, 'top-left');

    directions.on('route', function (event) {
      const route = event.route;

      const geojson = {
        type: 'FeatureCollection',
        features: [
          {
            type: 'Feature',
            geometry: route.geometry,
          },
        ],
      };

      map.addLayer({
        id: 'route',
        type: 'line',
        source: {
          type: 'geojson',
          data: geojson,
        },
        paint: {
          'line-color': '#3b9ddd',
          'line-width': 5,
        },
      });

      const bounds = new mapboxgl.LngLatBounds();

      // route.geometry.coordinates.forEach(function (point) {
      //   bounds.extend(point);
      // });

      bounds.extend(start);
      bounds.extend(destination);

      map.fitBounds(bounds, { padding: 10 });

     // directions.remove();
    });
  });
}

        }



      }
   

      function flyToStore(currentFeature) {
        map.flyTo({
          center: currentFeature.geometry.coordinates,
          zoom: 15
        });
      }
      function createPopUp(currentFeature) {
        const popUps = document.getElementsByClassName('mapboxgl-popup');
        if (popUps[0]) popUps[0].remove();
        const popup = new mapboxgl.Popup({ closeOnClick: false })
          .setLngLat(currentFeature.geometry.coordinates)
          .setHTML(
            `<h4>${currentFeature.properties.name}</h4>`
          )
          .addTo(map);
      }
    });

    </script>
  </body>
</html>
