<div id="map"></div>
<script src="https://unpkg.com/leaflet@1.3.0/dist/leaflet.js"></script>
<script src="js/leaflet-search.js"></script>

<script>
	//sample data values for populate map
	var data = [
		<?php $sql = "SELECT *  from trambanle a, congtydaumoi e, phuongxa b, quanhuyen c, tinhtp d, loaixangdau f where f.l_ma = a.l_ma and  a.ct_ma = e.ct_ma and  a.px_ma=b.px_ma and b.qh_ma = c.qh_ma and c.tinhtp_ma = d.tinhtp_ma";
	$result = $conn->query($sql);
	while($row = $result->fetch_array()) {
		?>
		{"loai":"<?php echo $row['l_ten'] ?>","tinhtp_ten":"<?php echo $row['tinhtp_ten'] ?>","qh_ten":"<?php echo $row['qh_ten'] ?>","px_ten":"<?php echo $row['px_ten'] ?>","loc":[<?php echo $row['t_lat'] ?>,<?php echo $row['t_long'] ?>], "logo":"<?php echo $row['ct_logo'] ?>", "title":"<?php echo $row['t_ten'] ?>","t_ma":"<?php echo $row['t_ma'] ?>", "icon":"images/<?php echo $row['ct_logo']  ?>"},
		<?php
	  }
?>	  
	];

	var map = L.map('map').setView([10.0279603, 105.7664918], 15);
var layer = new L.TileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
  maxZoom: 20,
  subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
});
map.addLayer(layer);
	 var markersLayer = new L.LayerGroup();	//layer contain searched elements
	 map.addLayer(markersLayer);
	
	function customTip(text,val) {
		return '<a href="#">'+text+'<em style="background:'+text+'; width:14px;height:14px;float:right"></em></a>';
	}

	// Add search control to the map
var searchControl = new L.Control.Search({
  layer: markersLayer,
  buildTip: customTip,
  autoType: false,
  zoom: 18,
  markerLocation: true
}).addTo(map);


for (i in data) {
  var title = data[i].title,  
    loc = data[i].loc,
    loai = data[i].loai,
    logo = data[i].logo,
    t_ma = data[i].t_ma,     
    xa= data[i].px_ten,
    huyen= data[i].qh_ten,
    tinh= data[i].tinhtp_ten,  
    iconUrl = data[i].icon,
    shadowUrl = 'https://static.vecteezy.com/system/resources/thumbnails/013/169/186/small/oval-shadow-for-object-or-product-png.png', // add this line
    icon = new L.Icon({
      iconUrl: iconUrl,
      iconSize: [35, 40],
      shadowUrl: shadowUrl, // add this line
      shadowSize: [50, 50], // add this line
      shadowAnchor: [25, 0] // add this line
    }),
    marker = new L.Marker(new L.latLng(loc), {logo:logo,title: title, icon: icon,t_ma:t_ma});
  
 // marker.bindPopup(title);
  marker.bindPopup("<div style='font-size: 16px;'><b>" + title + "</b></div>" + "<br>" + xa+ ", " + huyen+ ", " + tinh+ "<br>" + loai);
  markersLayer.addLayer(marker);
  searchControl.on('search:locationfound', function(e) {
    if (e.layer === marker) {
      marker.openPopup();
    }
  });
}


function searchMarkerById(id) {
  for (var i = 0; i < data.length; i++) {
    if (data[i].t_ma == id) {
      var marker = markersLayer.getLayers()[i]; // get the marker from the layer
      map.setView(marker.getLatLng(), 18); // zoom the map to the marker's location
      marker.openPopup(); // open the marker's popup
      break; // exit the loop
    }
  }
}

</script>

<script type="text/javascript"> 
    function thongbao(){
      Swal.fire({
  //title: 'Bạn chưa đăng nhập',
  text: "Bạn có muốn đăng xuất?",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  cancelButtonText: 'Huỷ ',
  confirmButtonText: 'Đăng Xuất'
}).then((result) => {
  if (result.isConfirmed) {
    window.location="logout.php";
  }
})
    }


</script>


<script type="text/javascript" src="/labs-common.js"></script>