<?php
session_start();
?>

<?php include "ketnoi.php"?>
<!DOCTYPE  > 
<html> 
<head> 
<title>Quản Lý Trạm Xăng</title> 
<link rel="icon" href="images/logo.png" type="image/png">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/style2.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA==" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js" integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg==" crossorigin=""></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<link rel="stylesheet" href="css/leaflet-search.css" />
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

</style>

<?php
if(isset($_POST['them'])){
  // Lấy dữ liệu từ form
  $t_ten = $_POST['ten'];
  $t_diachi = $_POST['diachi'];
  $t_sdt = $_POST['sdt'];
  $t_lat = $_POST['vido'];
  $t_long = $_POST['kinhdo'];

  $ql_ma = $_POST['quanly'];
  $ct_pass = md5($_POST['matkhau']);
  $px_ma = $_POST['xa'];
 
  $ct_logo = $_FILES['logo']['name'];
	$ct_logo_tmp_name = $_FILES['logo']['tmp_name'];
  // Thêm dữ liệu vào cơ sở dữ liệu
  $sql_them = "INSERT INTO congtydaumoi(ct_ten,ct_diachi,ct_sdt,ct_lat,ct_long,ql_ma,px_ma,ct_pass,ct_logo) VALUE('".$t_ten."','".$t_diachi."','".$t_sdt."','".$t_lat."','".$t_long."','".$ql_ma."','".$px_ma."','".$ct_pass."','".$ct_logo."')";
  if ($conn->query($sql_them) === TRUE) {
    move_uploaded_file($ct_logo_tmp_name, 'images/' . $ct_logo);
      // Hiển thị thông báo khi thêm dữ liệu thành công
      echo "<script>
          Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Thành công',
              showConfirmButton: false,
              timer: 1500
          })
      </script>";
  } else {
      // Hiển thị thông báo khi thêm dữ liệu thất bại
      echo "<script>
          Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Đã có lỗi xảy ra!',
          })
      </script>";
  }
}

?>
<?php include "nav.php";
 $user= $_SESSION['use'];
 ?>

<div class="overflow-auto" id="left">

            <form method="POST" action="add.php" enctype="multipart/form-data" >
                <div class="container">
                  <h4 style="color: #4CAF50;"> <a style="text-decoration: none;" href="index.php"><i style="color:black" class="fas fa-chevron-left"></i> </a>Thêm công ty đầu mối</h4>
                  <p>Bạn hãy điền thông tin bên dưới.</p>
                  <hr>
                 <label for="ten"><b>Tên công ty</b></label>
                  <input type="text" placeholder="Nhập tên" name="ten" required>
                 <label for="phone"><b>Số điện thoại</b></label>
                  <input type="number" placeholder="Nhập số điện thoại" name="sdt" required>
                <label for="lat"><b>Nhập vĩ độ ( Lat )</b></label>
                  <input type="text"  placeholder="Nhập vĩ độ" name="vido" required>
                <label for="long"><b>Nhập kinh độ ( Long )</b></label>
                  <input type="text"  placeholder="Nhập kinh độ" name="kinhdo" required>
                <label for="long"><b>Nhập mật khẩu</b></label>
                  <input type="password" class="huyenxa"  placeholder="Nhập mật khẩu" name="matkhau" required>

                  <input  value="<?php echo $user['ql_ma'] ?>" type="hidden"   name="quanly" required>
                  <label for="huyen"><b>Chọn quận/huyện:</b></label>
                  <select class="huyenxa" name="huyen" id="huyen">
                    <option value="1">--Chọn quận/huyện--</option>
                    <?php
                    // Kết nối cơ sở dữ liệu
                 

                    // Lấy danh sách các huyện
                    $sql = "SELECT qh_ma, qh_ten FROM quanhuyen";
                    $result = mysqli_query($conn, $sql);

                    // Hiển thị danh sách các huyện trong thẻ select
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . $row['qh_ma'] . '">' . $row['qh_ten'] . '</option>';
                    }
                   ?>
                  </select>
                  <label for="xa"><b>Chọn xã/phường:</b></label>
                  <select class="huyenxa" name="xa" id="xa">
                    <option value="">--Chọn xã/phường--</option>                  
                  </select>               
                  <label for="address"><b>Địa chỉ</b></label>
                  <input type="text" placeholder="Nhập tên đường" name="diachi" required>

                  <label for="address"><b>Logo</b></label>
  <div class="custom-file">
    <input name="logo" type="file" class="custom-file-input" id="customFile">
    <label class="custom-file-label" for="customFile">Choose file</label>
  </div>
        
                  </div>
      <button name="them" type="submit" class="signupbtn" >Thêm</button>  
      
              </form>   
                   <script>
                 $(document).ready(function() {
            // Gửi yêu cầu khi thay đổi giá trị của thẻ select chọn huyện
                 $('#huyen').change(function() {
                  var qh_ma = $(this).val();
                   $.ajax({
                    url: 'get_phuongxa.php',
                    type: 'POST',
                    data: {qh_ma: qh_ma},
                    dataType: 'json',
                    success: function(data) {
                        // Xóa danh sách xã cũ và hiển thị danh sách xã mới
                        $('#xa').find('option').remove().end().append('<option value="">--Chọn xã--</option>');
                        $.each(data, function(index, element) {
                            $('#xa').append('<option value="' + element.px_ma + '">' + element.px_ten + '</option>');
                        });
                    }
                });
            });
        });
    </script>
              
           
        </div>
<div id="map"></div>



<script src="https://unpkg.com/leaflet@1.3.0/dist/leaflet.js"></script>
<script src="js/leaflet-search.js"></script>
<script  type="text/javascript">
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
	//sample data values for populate map
	var data = [
		<?php $sql = "SELECT *  from congtydaumoi";
	$result = $conn->query($sql);
	while($row = $result->fetch_array()) {

		$iconUrl = isset($iconUrls[$row['ct_ma']]) ? $iconUrls[$row['ct_ma']] : 'https://example.com/default.png';

		?>
		{"loc":[<?php echo $row['ct_lat'] ?>,<?php echo $row['ct_long'] ?>], "title":"<?php echo $row['ct_ten'] ?>","ct_ma":"<?php echo $row['ct_ma'] ?>", "icon":"images/<?php echo $row['ct_logo']  ?>"},
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
// Define icon URLs for different location IDs

var currentMarker = null;

// Bắt sự kiện click trên bản đồ
map.on('click', function(e) {
  // Lấy tọa độ từ đối tượng sự kiện
  var lat = e.latlng.lat.toFixed(6);
  var lng = e.latlng.lng.toFixed(6);

  // Hiển thị tọa độ vào các ô input tương ứng
  document.getElementsByName("vido")[0].value = lat;
  document.getElementsByName("kinhdo")[0].value = lng;

  // Xóa marker cũ nếu đã tồn tại
  if (currentMarker !== null) {
    currentMarker.removeFrom(map);
  }

  // Tạo marker và thêm vào bản đồ
  currentMarker = L.marker([lat, lng]).addTo(map);
});


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

// Populate map with markers from sample data
for (i in data) {
  var title = data[i].title,  //value searched
    loc = data[i].loc,       //position found
    iconUrl = data[i].icon,  // icon URL for this location
    
    shadowUrl = 'https://static.vecteezy.com/system/resources/thumbnails/013/169/186/small/oval-shadow-for-object-or-product-png.png', // add this line
    icon = new L.Icon({
      iconUrl: iconUrl,
      iconSize: [40, 45],
      shadowUrl: shadowUrl, // add this line
      shadowSize: [50, 50], // add this line
      shadowAnchor: [25, 0] // add this line
    }),
    marker = new L.Marker(new L.latLng(loc), {title: title, icon: icon});
  
  marker.bindPopup(title);
  
  // Add marker to the markersLayer
  markersLayer.addLayer(marker);
  
  // Add a listener to the search control to open the popup when a result is clicked
  searchControl.on('search:locationfound', function(e) {
    if (e.layer === marker) {
      marker.openPopup();
    }
  });
}



</script>


<script type="text/javascript" src="/labs-common.js"></script>

</body>
</html>
