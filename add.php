<?php
	session_start();
  unset($_SESSION['loaixang']);
 if(!isset($_SESSION['loaixang'])){  
   $_SESSION['loaixang'] = array();
 }
 if(isset($_POST['loai'])){  
           foreach($_POST['loai'] as $l_ma => $loai){
               if($loai != 0){
               $_SESSION['loaixang'][$l_ma]= $loai;
               }
               else{
                   unset( $_SESSION['loaixang'][$l_ma]);
               }
 
           }
          
 }
?>

<?php include "admin/ketnoi.php"?>
<!DOCTYPE  > 
<html> 
<link rel="stylesheet" href="admin/css/style.css">

<!-- <link rel="stylesheet" href="admin/css/style2.css"> -->
<?php include "head.php" ?>

<body>
<style>#left{
    position: absolute;
    left: 0px;
    width: 22%;
    height: 94%;
    box-shadow: rgba(0, 0, 0, 0.25) 0px 0.0625em 0.0625em, rgba(0, 0, 0, 0.25) 0px 0.125em 0.5em, rgba(255, 255, 255, 0.1) 0px 0px 0px 1px inset;
    z-index: 10000;
    ;
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
 $user= $_SESSION['user'];
if(isset($_POST['them'])){
  $t_ten = $_POST['ten'];
  $t_diachi = $_POST['diachi'];
  $t_sdt = $_POST['sdt'];
  $t_lat = $_POST['vido'];
  $t_long = $_POST['kinhdo'];
  $ct_ma = $user['ct_ma'];
  $l_ma = $_POST['loai'];
  $px_ma = $_POST['xa'];
  if ( !empty( $_SESSION[ 'loaixang' ] ) ) {

    $loaixang = 'SELECT * FROM loaixangdau WHERE l_ma IN ('.implode( ',', array_keys( $_SESSION[ 'loaixang' ] ) ).')';
    $x = mysqli_query( $conn, $loaixang );
    $loai = array();
  
    while ( $row = mysqli_fetch_array( $x ) ) {
        $loai[] = $row;
  
    }
  }
  foreach ( $loai as $key => $q ) {
  // Thêm dữ liệu vào cơ sở dữ liệu
  $sql_them = "INSERT INTO trambanle(t_ten,t_diachi,t_sdt,t_lat,t_long,ct_ma,l_ma,px_ma) VALUE('".$t_ten."','".$t_diachi."','".$t_sdt."','".$t_lat."','".$t_long."','".$ct_ma."','".$q['l_ma']."','".$px_ma."')";
  try {
    if ($conn->query($sql_them) === TRUE) {
        // Hiển thị thông báo khi sửa dữ liệu thành công
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
        // Hiển thị thông báo khi sửa dữ liệu thất bại
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Không thể sửa dữ liệu',
            })
        </script>";
    }
    
} catch (mysqli_sql_exception $e) {
    // Hiển thị thông báo lỗi và ghi log lỗi
    $errorMessage = "Lỗi truy vấn SQL: " . $e->getMessage();
    error_log($errorMessage);
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Lỗi',
            text: 'Đã có lỗi xảy ra, vui lòng thử lại!!!',
        })
    </script>";
}
}
}
?>
<?php include "nav.php"; ?>

<div style=" border: none;" class="overflow-auto" id="left">

            <form method="POST" action="add.php" enctype="multipart/form-data" >
                <div class="container">
                  <h4 style="color: #4CAF50;"> <a style="text-decoration: none;" href="index.php"><i style="color:black" class="fas fa-chevron-left"></i> </a>Thêm trạm xăng dầu</h4>
                  <p>Bạn hãy điền thông tin bên dưới.</p>
                  <hr>
                 <label for="ten"><b>Tên trạm</b></label>
                  <input type="text" placeholder="Nhập tên" name="ten" required>
                 <label for="phone"><b>Số điện thoại</b></label>
                  <input type="number" placeholder="Nhập số điện thoại" name="sdt" required>
                <label for="lat"><b>Nhập vĩ độ ( Lat )</b></label>
                  <input type="text"  placeholder="Nhập vĩ độ" name="vido" required>
                <label for="long"><b>Nhập kinh độ ( Long )</b></label>
                  <input type="text"  placeholder="Nhập kinh độ" name="kinhdo" required>
                <label for="long"><b>Chọn công ty:</b></label>
                <?php  
		
      if (isset($_SESSION['user'])){ 
        $user= $_SESSION['user'];
        ?>
                 <p class="huyenxa"><?php echo $user['ct_ten'] ?></p> <?php }?>
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
                  <label for="address"><b>Loại xăng dầu</b></label>
<?php
  $sql = "SELECT * FROM loaixangdau";
  $result = mysqli_query($conn, $sql);

  // Hiển thị danh sách các huyện trong thẻ select
  while ($row = mysqli_fetch_assoc($result)) {
?>

                  <div class="custom-control custom-checkbox">
    <input value="<?php  echo $row['l_ma']?>" name="loai[<?php  echo $row['l_ma']?>]" type="checkbox" class="custom-control-input" id="customCheck<?php  echo $row['l_ma']?>">
    <label class="custom-control-label" for="customCheck<?php  echo $row['l_ma']?>"><?php  echo $row['l_ten']?></label>
  </div>        <?php } ?>

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
<div style="border: none;" id="map"></div>



<script src="https://unpkg.com/leaflet@1.3.0/dist/leaflet.js"></script>
<script src="admin/js/leaflet-search.js"></script>
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
		<?php $sql = "SELECT *  from trambanle a, congtydaumoi e, phuongxa b, quanhuyen c, tinhtp d where a.ct_ma = e.ct_ma and  a.px_ma=b.px_ma and b.qh_ma = c.qh_ma and c.tinhtp_ma = d.tinhtp_ma";
	$result = $conn->query($sql);
	while($row = $result->fetch_array()) {
		?>
		{"tinhtp_ten":"<?php echo $row['tinhtp_ten'] ?>","qh_ten":"<?php echo $row['qh_ten'] ?>","px_ten":"<?php echo $row['px_ten'] ?>","loc":[<?php echo $row['t_lat'] ?>,<?php echo $row['t_long'] ?>], "logo":"<?php echo $row['ct_logo'] ?>", "title":"<?php echo $row['t_ten'] ?>","t_ma":"<?php echo $row['t_ma'] ?>", "icon":"admin/images/<?php echo $row['ct_logo']  ?>"},
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
// Khởi tạo biến lưu trữ marker
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





	// var map = new L.Map('map', {zoom: 9, center: new L.latLng(data[0].loc) });	//set center from first location

	// map.addLayer(new L.TileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'));	//base layer

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
  marker.bindPopup("<div style='font-size: 16px;'><b>" + title + "</b></div>" + "<br>" + xa+ ", " + huyen+ ", " + tinh);
  markersLayer.addLayer(marker);
  searchControl.on('search:locationfound', function(e) {
    if (e.layer === marker) {
      marker.openPopup();
    }
  });
}

// // Populate map with markers from sample data
// for (i in data) {
//   var title = data[i].title,  //value searched
//     loc = data[i].loc,       //position found
//     iconUrl = data[i].icon,  // icon URL for this location
//     icon = new L.Icon({
//       iconUrl: iconUrl,
//       iconSize: [30, 30]     // Adjust as needed
//     }),
//     marker = new L.Marker(new L.latLng(loc), {title: title, icon: icon});
  
//   marker.bindPopup(title);
  
//   // Add marker to the markersLayer
//   markersLayer.addLayer(marker);
  
//   // Add a listener to the search control to open the popup when a result is clicked
//   searchControl.on('search:locationfound', function(e) {
//     if (e.layer === marker) {
//       marker.openPopup();
//     }
//   });
// }



</script>


<script type="text/javascript" src="/labs-common.js"></script>

</body>
</html>
