<?php
	session_start();

?>

<?php include "ketnoi.php"?>
<!DOCTYPE  > 
<html> 
<link rel="stylesheet" href="css/style.css">

<!-- <link rel="stylesheet" href="admin/css/style2.css"> -->
<head> 
<title></title> 
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
 $user= $_SESSION['user'];
if(isset($_POST['sua'])){
  // Lấy dữ liệu từ form
  $ct_ma = $_POST['matram'];
  $t_ten = $_POST['ten'];
  $t_diachi = $_POST['diachi'];
  $t_sdt = $_POST['sdt'];
  $t_lat = $_POST['vido'];
  $t_long = $_POST['kinhdo'];
 $ct_pass=1;
  $ql_ma =  $user['ql_ma'];
  $px_ma = $_POST['xa'];
  $logo = $_FILES['logo']['name'];
	$logo_tmp_name = $_FILES['logo']['tmp_name'];
$sql_sua="UPDATE `congtydaumoi` 
SET `ct_ten`='$t_ten',`ct_diachi`='$t_diachi',`ct_sdt`='$t_sdt',`ct_lat`=' $t_lat',`ct_long`='$t_long',`ql_ma`='$ql_ma',`px_ma`='$px_ma',`ct_pass`=' $ct_pass',`ct_logo`='$logo' WHERE ct_ma = $ct_ma";
   try {
    if ($conn->query($sql_sua) === TRUE) {
        move_uploaded_file($logo_tmp_name, 'images/' . $logo);
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
                  
                <label for="long"><b>Chọn quản lý:</b></label>
               
                    
                <input type="text"  placeholder="Nhập quản lý" name="quanly" required>
                  <label for="huyen"><b>Chọn quận/huyện:</b></label>
                  <select class="huyenxa" name="huyen" id="huyen">
                    <option >--Chọn quận/huyện--</option>
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
                  <select class="huyenxa" name="xa" id="xa"  readonly>
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
		<?php $sql = "SELECT *  from congtydaumoi a, quanly b, phuongxa c, quanhuyen d, tinhtp e where a.px_ma = c.px_ma and c.qh_ma=d.qh_ma and d.tinhtp_ma = e.tinhtp_ma and a.ql_ma = b.ql_ma";
	$result = $conn->query($sql);
	while($row = $result->fetch_array()) {
		?>
		{"loc":[<?php echo $row['ct_lat'] ?>,<?php echo $row['ct_long'] ?>],"px_ten":"<?php echo $row['px_ma'] ?>","tinhtp_ten":"<?php echo $row['tinhtp_ma'] ?>","qh_ten":"<?php echo $row['qh_ma'] ?>","ql_ten":"<?php echo $row['ql_ten'] ?>","ct_sdt":"<?php echo $row['ct_sdt'] ?>", "ct_diachi":"<?php echo $row['ct_diachi'] ?>", "px_ma":"<?php echo $row['px_ma'] ?>", "title":"<?php echo $row['ct_ten'] ?>","ct_ma":"<?php echo $row['ct_ma'] ?>", "icon":"images/<?php echo $row['ct_logo']  ?>"},
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
    ql_ten = data[i].ql_ten,
    ct_sdt = data[i].ct_sdt,
    px_ten = data[i].px_ten,
    qh_ten= data[i].qh_ten,
    ct_ma= data[i].ct_ma,
    tp = data[i].tinhtp_ten,
    ct_diachi = data[i].ct_diachi,       
    iconUrl = data[i].icon, 
    shadowUrl = 'https://static.vecteezy.com/system/resources/thumbnails/013/169/186/small/oval-shadow-for-object-or-product-png.png', // add this line
    icon = new L.Icon({
      iconUrl: iconUrl,
      iconSize: [35, 40],
      shadowUrl: shadowUrl, // add this line
      shadowSize: [50, 50], // add this line
      shadowAnchor: [25, 0] // add this line
  
    }),
    marker = new L.Marker(new L.latLng(loc), {ct_ma:ct_ma,tp:tp,qh_ten:qh_ten,px_ten:px_ten,ql_ten:ql_ten,loc: loc,title,title: title, icon: icon,ct_diachi:ct_diachi,ct_sdt:ct_sdt});
  
//   marker.bindPopup(title);
  markersLayer.addLayer(marker);
  marker.on('click', function(e) {

      var tenTram = this.options.title;
       var sdt = this.options.ct_sdt;
       var ct_ma = this.options.ct_ma;
       var ql_ten = this.options.ql_ten;
       var loc = this.options.loc;
        var vido = loc[0];
         var kinhdo = loc[1];
     var congty = this.options.ct_ten;
       var qh_ten = this.options.qh_ten;
       var tp = this.options.tp;
       var px_ten = this.options.px_ten;
       var diaChi = this.options.ct_diachi;

      // Đưa dữ liệu vào các ô input của form
      $('input[name="matram"]').val(ct_ma);
      $('input[name="ten"]').val(tenTram);
       $('input[name="sdt"]').val(sdt);
        $('input[name="quanly"]').val(ql_ten);
       $('input[name="vido"]').val(vido);
       $('input[name="kinhdo"]').val(kinhdo);
       document.getElementById('huyen').value =qh_ten;
       document.getElementById('xa').value =px_ten;
       
      // Set the district, ward, and commune values of the marker to the corresponding select elements
     // $('select[name="huyen"]').val(qh_ten).trigger('change'); 
      //$('select[name="xa"]').val(px_ten).trigger('change'); // Trigger the change event to update the ward select element
     // $('input[name="xa"]').val(px_ten); // Set the commune value to the corresponding input element
       $('input[name="diachi"]').val(diaChi);
    });
}
// Populate map with markers from sample data


    // Thêm sự kiện click vào marker
   
  



</script>


<script type="text/javascript" src="/labs-common.js"></script>

</body>
</html>