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
		<?php $sql = "SELECT * FROM congtydaumoi a, phuongxa b, quanhuyen c, tinhtp d, loaixangdau f, dg WHERE a.ct_ma = dg.ct_ma and f.l_ma = dg.l_ma and a.px_ma=b.px_ma and b.qh_ma = c.qh_ma and c.tinhtp_ma = d.tinhtp_ma";
	$result = $conn->query($sql);
	while($row = $result->fetch_array()) {
		?>
		{"gia":"<?php echo number_format($row['gia']) ?>","loai":"<?php echo $row['l_ten'] ?>","tinhtp_ten":"<?php echo $row['tinhtp_ten'] ?>","qh_ten":"<?php echo $row['qh_ten'] ?>","px_ten":"<?php echo $row['px_ten'] ?>","loc":[<?php echo $row['ct_lat'] ?>,<?php echo $row['ct_long'] ?>], "title":"<?php echo $row['ct_ten'] ?>","ct_ma":"<?php echo $row['ct_ma'] ?>", "icon":"images/<?php echo $row['ct_logo'] ?>"},
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
    t_ma = data[i].t_ma, 
    xa= data[i].px_ten,
    huyen= data[i].qh_ten,
    loai= data[i].loai,
    gia= data[i].gia,
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
   
    marker = new L.Marker(new L.latLng(loc), {title: title, icon: icon, t_ma: t_ma});
    marker.bindPopup("<div style='font-size: 16px;'><b>" + title + "</b></div>" + "<br>" +"<div style='font-size: 13px;'>Loại xăng/dầu <b> " + loai + ": " +gia+ " đ</b></div>"+ "<br>" + xa+ ", " + huyen+ ", " + tinh );

  markersLayer.addLayer(marker);
  searchControl.on('search:locationfound', function(e) {
    if (e.layer === marker) {
      marker.openPopup();
    }
  });
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


<script type="text/javascript" src="/labs-common.js"></script>
<!-- Navbar -->
      

<script>
  $('#myModal2').on('show.bs.modal', function (e) {
    $('#myModal').modal('hide');
  });
</script>

</body>
</html>
