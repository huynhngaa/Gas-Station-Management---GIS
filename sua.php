<?php
	session_start();
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
if(isset($_POST['sua'])){
  // Lấy dữ liệu từ form
  $t_ma = $_POST['matram'];
  $t_ten = $_POST['ten'];
  $t_diachi = $_POST['diachi'];
  $t_sdt = $_POST['sdt'];
  $t_lat = $_POST['vido'];
  $t_long = $_POST['kinhdo'];
  $ct_ma = $user['ct_ma'];
  $l_ma = 1;
  $px_ma = $_POST['xa'];
$sql_sua="UPDATE `trambanle` SET `t_ten`='$t_ten',`t_diachi`='$t_diachi',`t_sdt`=' $t_sdt',`t_lat`=' $t_lat',`t_long`='$t_long',`l_ma`='$l_ma',`px_ma`='$px_ma' WHERE t_ma=$t_ma";
  // Thêm dữ liệu vào cơ sở dữ liệu
  // $sql_them = "INSERT INTO trambanle(t_ten,t_diachi,t_sdt,t_lat,t_long,ct_ma,l_ma,px_ma) VALUE('".$t_ten."','".$t_diachi."','".$t_sdt."','".$t_lat."','".$t_long."','".$ct_ma."','".$l_ma."','".$px_ma."')";
  try {
    if ($conn->query($sql_sua) === TRUE) {
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
            text: 'Đã có lỗi xảy ra, vui lòng thử lại !!!',
        })
    </script>";
}

}

?>
<?php include "nav.php"; ?>

<div style=" border: none;" class="overflow-auto" id="left">

<form method="POST" action="sua.php" enctype="multipart/form-data" >
                <div class="container">
                  <h4 style="color: #4CAF50;"> <a style="text-decoration: none;" href="index.php"><i style="color:black" class="fas fa-chevron-left"></i> </a>Sửa trạm xăng dầu</h4>
                  
                  <hr>
                 <label for="ten"><b>Tên trạm</b></label>
                 <input type="hidden"  name="matram" >
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
                    
                 <p id="congty" class="huyenxa"><?php echo $user['ct_ten'] ?></p> <?php }?>
                  <label for="huyen"><b>Chọn quận/huyện:</b></label>
                  <select class="huyenxa" name="huyen" id="huyen">
                    <option value="1">--Chọn quận/huyện--</option>
                    <?php
                    // Kết nối cơ sở dữ liệu
                    $conn = mysqli_connect('localhost', 'root', '', 'congty');

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
                  <select class="huyenxa" name="xa" id="xa"  readonly>
                    <option value="">--Chọn xã/phường--</option>                  
                  </select>               
                  <label for="address"><b>Địa chỉ</b></label>
                  <input type="text" placeholder="Nhập tên đường" name="diachi" required>
                               
                  </div>
      <button name="sua" type="submit" class="signupbtn" >Sửa</button>  
      
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
		<?php $sql = "SELECT *  from trambanle a, congtydaumoi b, phuongxa c, quanhuyen d WHERE a.ct_ma = b.ct_ma and a.px_ma=c.px_ma and c.qh_ma=d.qh_ma";
	$result = $conn->query($sql);
	while($row = $result->fetch_array()) {


		?>
		{"mact":"<?php echo $row['ct_ma'] ?>","dc":"<?php echo $row['t_diachi'] ?>","matram":"<?php echo $row['t_ma'] ?>","loc":[<?php echo $row['t_lat'] ?>,<?php echo $row['t_long'] ?>],"xa":"<?php echo $row['px_ma'] ?>","quan":"<?php echo $row['qh_ma'] ?>", "title":"<?php echo $row['t_ten'] ?>", "congty":"<?php echo $row['ct_ten'] ?>","sdt":"<?php echo $row['t_sdt'] ?>", "icon":"admin/images/<?php echo $row['ct_logo'] ?>"},
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

////



// Populate map with markers from sample data
var session = "<?php echo $user['ct_ma']; ?>";
// Populate map with markers from sample data
for (i in data) {
  if (data[i].mact == session) { // kiểm tra nếu mã trạm bằng session đang đăng nhập
    var title = data[i].title,
      loc = data[i].loc,
      congty = data[i].congty,
      iconUrl = data[i].icon,
      sdt = data[i].sdt,
      xa = data[i].xa,
      quan = data[i].quan,
      mact = data[i].mact,
      matram = data[i].matram,
      dc = data[i].dc,
      shadowUrl = 'https://static.vecteezy.com/system/resources/thumbnails/013/169/186/small/oval-shadow-for-object-or-product-png.png', // add this line
    icon = new L.Icon({
      iconUrl: iconUrl,
      iconSize: [35, 40],
      shadowUrl: shadowUrl, // add this line
      shadowSize: [50, 50], // add this line
      shadowAnchor: [25, 0] // add this line
    }),
      marker = new L.Marker(new L.latLng(loc), {
        title: title,
        icon: icon,
        congty: congty,
        sdt: sdt,
        loc: loc,
        xa: xa,
        quan: quan,
        matram: matram,
        dc: dc,
        mact: mact
      });

    // Thêm marker vào map nếu mact = session
    if (mact == session) {
      marker.addTo(map);
    }

    // thêm popup vào marker
    marker.bindPopup("<b>" + title + "</b><br>" + congty + "<br>" + xa + ", " + quan);

    // Thêm sự kiện click vào marker
    marker.on('click', function(e) {
      // Lấy thông tin dữ liệu từ marker
      var matram = this.options.matram;
      var tenTram = this.options.title;
      var sdt = this.options.sdt;
      var loc = this.options.loc;
      var vido = loc[0];
      var kinhdo = loc[1];
      var congty = this.options.congty;
      var huyen = this.options.quan;

      var xa = this.options.xa;
      var diaChi = this.options.dc;

      // Đưa dữ liệu vào các ô input của form
      $('input[name="matram"]').val(matram);
      $('input[name="ten"]').val(tenTram);
      $('input[name="sdt"]').val(sdt);
      $('p[id="congty"]').text(congty);
      $('input[name="vido"]').val(vido);
      $('input[name="kinhdo"]').val(kinhdo);

      // Set the district, ward, and commune values of the marker to the corresponding select elements
      $('select[name="huyen"]').val(huyen).trigger('change'); // Trigger the change event to update the ward select element
      $('select[name="xa"]').val(xa).trigger('change');// Set the commune value to the corresponding input element
      $('input[name="diachi"]').val(diaChi);
    });
  }
}



</script>


<script type="text/javascript" src="/labs-common.js"></script>

</body>
</html>