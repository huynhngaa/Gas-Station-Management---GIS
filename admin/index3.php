<?php
	session_start();
  if (!isset($_SESSION['use'])) {
    header('Location: login.php');
    exit();
}

?>
<?php include "ketnoi.php"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<?php include "head.php" ?>

<body>
<style>
#left{
    position: absolute;
    left: 0px;
    padding-top:2%;
    width: 22%;
    height: 94%;
    box-shadow: rgba(0, 0, 0, 0.25) 0px 0.0625em 0.0625em, rgba(0, 0, 0, 0.25) 0px 0.125em 0.5em, rgba(255, 255, 255, 0.1) 0px 0px 0px 1px inset;
    z-index: 10000;
    
}
#map{
    position: absolute;
    right: 0px;
    width: 78%;
    height: 94%;
    
    /* box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); */
 }
.dangxuat {
  position: absolute;
  bottom: 8px;
  left: 14px;
  font-size: 18px;
  width: 90%;
 
}
.navbar{
  height: 40px;
  box-shadow: rgba(0, 0, 0, 0.25) 0px 0.0625em 0.0625em, rgba(0, 0, 0, 0.25) 0px 0.125em 0.5em, rgba(255, 255, 255, 0.1) 0px 0px 0px 1px inset; z-index: 10000;
}
.nav-item .nav-link:focus, 
.nav-item .nav-link:hover, 
.nav-item .nav-link:active,
.nav-item .nav-link:visited {
  background-color: #f1f1f1;
 
}
.modal-content {
  width: 150%;
    margin-left: -200px;
}

</style>  
<?php include "nav.php";
include "left.php";
 ?>
 <div id="map"></div>
<script src="https://unpkg.com/leaflet@1.3.0/dist/leaflet.js"></script>
<script src="js/leaflet-search.js"></script>

<script>


	//sample data values for populate map
	var data = [
	<?php $sql = "SELECT a.*, b.ct_ten,b.ct_logo, GROUP_CONCAT(c.l_ten SEPARATOR ', ') as fuels 
		FROM trambanle a
		INNER JOIN congtydaumoi b ON a.ct_ma = b.ct_ma
		LEFT JOIN loaixangdau c ON FIND_IN_SET(c.l_ma, a.l_ma)
		GROUP BY a.t_ma";
	$result = $conn->query($sql);
	while($row = $result->fetch_array()) {
	?>
	{"loc":[<?php echo $row['t_lat'] ?>,<?php echo $row['t_long'] ?>], "title":"<?php echo $row['t_ten'] ?>", "icon":"images/<?php echo $row['ct_logo'] ?>", "company":"<?php echo $row['ct_ten'] ?>", "fuels":"<?php echo $row['fuels'] ?>"},
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

var searchControl = new L.Control.Search({
  layer: markersLayer,
  propertyName: 'company', // Search the 'company' property in the marker data
  buildTip: customTip,
  autoType: false,
  zoom: 18,
  markerLocation: true
}).addTo(map);

// Populate map with markers from sample data
for (i in data) {
	var title = data[i].title,  //value searched
		loc = data[i].loc,       //position found
		iconUrl = data[i].icon,  // icon URL for this location
		company = data[i].company, // name of the parent company
		fuels = data[i].fuels, // types of fuel sold
		icon = new L.Icon({
			iconUrl: iconUrl,
			iconSize: [30, 30]     // Adjust as needed
		}),
		marker = new L.Marker(new L.latLng(loc), {title: title, icon: icon});
	
	marker.bindPopup("<b>" + title + "</b><br>" + company + "<br>Loại xăng: " + fuels);
	marker.options.company = company; // Add the 'company' property to the marker options
	
	markersLayer.addLayer(marker);
  
}








function searchMarkerById(id) {
  for (var i = 0; i < data.length; i++) {
    if (data[i].ct_ma == id) {
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



<!-- Navbar -->
      

<script>
  $('#myModal2').on('show.bs.modal', function (e) {
    $('#myModal').modal('hide');
  });
</script>

</body>
</html>
