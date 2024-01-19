<?php
	session_start();

?>

<?php include "admin/ketnoi.php"?>
<!DOCTYPE  > 
<html> 
<link rel="stylesheet" href="admin/css/style.css">

<!-- <link rel="stylesheet" href="admin/css/style2.css"> -->
<head> 
  <title>Quản Lý Trạm Xăng</title> 
<link rel="icon" href="admin/images/logo.png" type="image/png">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<link rel="stylesheet" href="admin/css/style.css">
<link rel="stylesheet" href="admin/css/style2.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA==" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js" integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg==" crossorigin=""></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<link rel="stylesheet" href="admin/css/leaflet-search.css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- <link rel="stylesheet" href="css/style2.css" /> -->
</head>

<body>
<style>
#left{
    position: absolute;
    left: 0px;
    
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
    border: none
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
.huyenxa{
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  resize: vertical;
  padding:15px;
  border-radius:15px;
  border:0;
  box-shadow:4px 4px 10px rgba(0,0,0,0.2);
 }
 .leaflet-routing-container {
  background-color: white;
}

 .image-container {
        display: flex; /* Sử dụng flexbox để căn chỉnh hình ảnh và văn bản */
        align-items: center; /* Căn giữa theo chiều dọc */
        margin-bottom: 20px; /* Khoảng cách dưới */
    }

    .image-container img {
        width: 40px; /* Kích thước hình vuông */
        height: 40px; /* Kích thước hình vuông */
        object-fit: cover; /* Đảm bảo hình ảnh không bị méo */
        border-radius: 20%; /* Bo tròn hình ảnh */
        margin-right: 10px; /* Khoảng cách bên phải */
    }

    .image-container p {
        text-align: left; /* Căn trái nội dung */
    }
</style>
<?php 
include "nav.php"; 
?>

<div style=" border: none;" class="overflow-auto" id="left">

<form method="POST" action="timkiem.php" enctype="multipart/form-data" >
               
                  <h4 style="color: #4CAF50;"> <a style="text-decoration: none;" href="index.php"><i style="color:black" class="fas fa-chevron-left"></i> </a>Tìm kiếm trạm xăng dầu</h4> 
                  <?php  
		
        if (isset($_SESSION['user'])){ 
          $user= $_SESSION['user'];
          ?>       
                   <p id="congty" class="huyenxa"> <?php }?>
                 
                   <?php
  $noidung = isset($_POST['noidung']) ? $_POST['noidung'] : '';
?>
<input value="<?php echo $noidung ?>" type="text" class="huyenxa" name="noidung" id="huyen" />
                    <!-- <input  type="test" class="huyenxa" name="noidung" id="huyen" /> -->
                     
                  
      <button name="timkiem" type="submit" class="signupbtn" >Tìm kiếm </button> 
      </form> 
      <p><i>Kết Quả tìm kiếm</i>.</p>

      <?php     
        if (isset($_POST['timkiem'])) {
          $noidung = $_POST['noidung'];
        } else {
            echo $noidung = false;
        }

        // if(isset($_POST['timkiem'])){
            // $huyen = $_POST['huyen'];
            $sql = "SELECT  * FROM trambanle a, loaixangdau b, congtydaumoi c WHERE a.ct_ma = c.ct_ma and a.l_ma = b.l_ma  and (l_ten LIKE '%$noidung%' or ct_ten LIKE '%$noidung%')";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($result)) {
              $currentValue = $row['ct_ten'] . "_" . $row['t_ten'];  ?>
  <a href="#" id="<?php echo $row['t_ma'] ?>" onclick="searchMarkerById(this.id)">
                        <div class="image-container">
                            <img src="admin/images/<?php echo $row['ct_logo'] ?>" alt="Logo" />
                            <p><?php echo "" . $currentValue; ?></p>                 
                        </div>
                </a>
              <!-- echo "Trạm: ".$row['t_ten']." <br>Công ty: ".$row['ct_ten']." <br>"; -->
             <?php  
        }
      ?>
     
            
        </div>
<div id="map"></div>
<script src="admin/js/leaflet-search.js"></script>
<script src="admin/leaflet/leaflet-routing-machine.js"></script>


<script>
var data = [
		<?php $sql = "SELECT *  from trambanle a, congtydaumoi e, phuongxa b, quanhuyen c, tinhtp d, loaixangdau f, dg g where f.l_ma = g.l_ma and f.l_ma = a.l_ma and  a.ct_ma = e.ct_ma and  a.px_ma=b.px_ma and b.qh_ma = c.qh_ma and c.tinhtp_ma = d.tinhtp_ma";
	$result = $conn->query($sql);
	while($row = $result->fetch_array()) {
		?>
		{"gia":"<?php echo number_format($row['gia']) ?>","loai":"<?php echo $row['l_ten'] ?>","tinhtp_ten":"<?php echo $row['tinhtp_ten'] ?>","qh_ten":"<?php echo $row['qh_ten'] ?>","px_ten":"<?php echo $row['px_ten'] ?>","loc":[<?php echo $row['t_lat'] ?>,<?php echo $row['t_long'] ?>], "logo":"<?php echo $row['ct_logo'] ?>", "title":"<?php echo $row['t_ten'] ?>","t_ma":"<?php echo $row['t_ma'] ?>", "icon":"admin/images/<?php echo $row['ct_logo']  ?>"},
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

for ( var i in data) {
  var title = data[i].title,  
    loc = data[i].loc,
    loai = data[i].loai,
    logo = data[i].logo,
    gia = data[i].gia,
   
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
    marker = new L.Marker(new L.latLng(loc), {title: title, icon: icon});
    marker.on('click', function(e) {
    var clickedLocation = e.latlng;
    var destination = L.latLng(clickedLocation.lat, clickedLocation.lng);

    routingControl.spliceWaypoints(routingControl.getWaypoints().length - 1, 1, destination);
  });
 

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
    if (data[i].t_ma == id) {
      var marker = markersLayer.getLayers()[i]; // get the marker from the layer
      map.setView(marker.getLatLng(), 18); // zoom the map to the marker's location
      marker.openPopup(); // open the marker's popup
      break; // exit the loop
    }
  }
}


var routingControl = null;

// L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
//   attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
//   maxZoom: 18
// }).addTo(map);

// Lấy vị trí hiện tại của người dùng (sử dụng Geolocation HTML5)
if (navigator.geolocation) {
  navigator.geolocation.getCurrentPosition(function(position) {
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;
    var currentLocation = L.latLng(latitude, longitude);

    // Tạo marker cho vị trí hiện tại
    var currentMarker = L.marker(currentLocation).addTo(map);
    currentMarker.bindPopup("Vị trí hiện tại của bạn").openPopup();

    // Thêm control chỉ đường và sử dụng vị trí hiện tại làm điểm bắt đầu
    routingControl = L.Routing.control({
      waypoints: [
        currentLocation
      ],
     
      routeWhileDragging: true
    }).addTo(map);

  });
} else {
  alert("Trình duyệt của bạn không hỗ trợ Geolocation.");
}








</script>
</body>
</html>