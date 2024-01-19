<html>
    <head>

        <title>google map</title>

        <link rel="stylesheet" href="css/style.css">
        <script src="js/index.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA==" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js" integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg==" crossorigin=""></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    </head>

    <body>
        <style>#left{
    position: absolute;
    left: 0px;
    width: 20%;
    height: 100%;
    border: 1px solid black;
}
#map{
    position: absolute;
    right: 0px;
    width: 80%;
    height: 100%;
    border: 1px solid black;
}</style>
        <div class="overflow-auto" id="left">
            <form method="POST" action="xuly/xuly.php"  >
                <div class="container">
                  <h4>Thêm trạm xăng dầu</h4>
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
                  <select class="huyenxa" name="congty" id="cty">
                    <option value="">--Chọn công ty--</option>
                  
                  </select>
                  <label for="huyen"><b>Chọn quận/huyện:</b></label>
                  <select class="huyenxa" name="huyen" id="huyen">
                    <option value="1">--Chọn quận/huyện--</option>
                    <?php
                    // Kết nối cơ sở dữ liệu
                    $conn = mysqli_connect('localhost', 'root', '', 'coffe_store');

                    // Lấy danh sách các huyện
                    $sql = "SELECT h_ma, h_ten FROM huyen";
                    $result = mysqli_query($conn, $sql);

                    // Hiển thị danh sách các huyện trong thẻ select
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . $row['h_ma'] . '">' . $row['h_ten'] . '</option>';
                    }
                   ?>
                  </select>
                  <label for="xa"><b>Chọn xã/phường:</b></label>
                  <select class="huyenxa" name="xa" id="xa">
                    <option value="">--Chọn xã/phường--</option>                  
                  </select>               
                  <label for="address"><b>Địa chỉ</b></label>
                  <input type="text" placeholder="Nhập tên đường" name="diachi" required>
                    <button name="them" type="submit" class="signupbtn" >Thêm</button>                 
                  </div>

              </form>
              <script>
                 $(document).ready(function() {
            // Gửi yêu cầu khi thay đổi giá trị của thẻ select chọn huyện
                 $('#huyen').change(function() {
                  var h_ma = $(this).val();
                   $.ajax({
                    url: 'get_phuongxa.php',
                    type: 'POST',
                    data: {h_ma: h_ma},
                    dataType: 'json',
                    success: function(data) {
                        // Xóa danh sách xã cũ và hiển thị danh sách xã mới
                        $('#xa').find('option').remove().end().append('<option value="">--Chọn xã--</option>');
                        $.each(data, function(index, element) {
                            $('#xa').append('<option value="' + element.x_ma + '">' + element.x_ten + '</option>');
                        });
                    }
                });
            });
        });
    </script>
              
           
        </div>

        <div id="map"></div>
        <!-- <div id="right"></div> -->

        <script>
            var mapOptions = {center: [10.0279603,105.7664918], zoom: 10};
            var map = new L.map('map', mapOptions);
            var layer = new
            L.TileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{ maxZoom: 20,subdomains:['mt0','mt1','mt2','mt3']});
            map.addLayer(layer);


            <?php
            // Kết nối đến CSDL

            $conn = mysqli_connect( 'localhost', 'root', '', 'congtyxangdau' );

            // Kiểm tra kết nối thành công hay không

            if ( !$conn ) {
                //loi ket noi csdl

                echo 'Error: Unable to connect to MySQL.' . PHP_EOL;

                echo 'Debugging errno: ' . mysqli_connect_errno() . PHP_EOL;

                echo 'Debugging error: ' . mysqli_connect_error() . PHP_EOL;

                exit;

            } else {
                mysqli_set_charset( $conn, 'utf8' );
            }
            //hiện hình ảnh theo mã công ty 3
            $query = "select * from trambanle where ct_ma = '3'";
            $result = mysqli_query( $conn, $query );
            while( $row = mysqli_fetch_array( $result, MYSQLI_BOTH) ) { 
                ?>
                    // Khai báo biến để trỏ đến marker
                
                    var greenIcon = L.icon({
                    iconUrl: 'https://cdn.haitrieu.com/wp-content/uploads/2022/01/Icon-Petrolimex-PLX.png',

                    iconSize:     [40, 45], // size of the icon
                    iconAnchor:   [39, 44] // point of the icon which will correspond to marker's location
                });
                    var r = new L.marker([<?php echo $row["t_lat"]?>, <?php echo $row["t_long"]?>], 
                    {
                        icon: greenIcon,
                        title: "<?php echo $row["t_ten"]?>"
                                       
                    });
                    
                    r.addTo(map)
                        .bindPopup('<?php echo $row["t_ten"]?>')
                        .openPopup();
                    
                <?php
            } 
            ?>
            // hiện hình ảnh theo mã công ty 4
            <?php
            $query = "select * from trambanle where ct_ma = '4'";
                        $result = mysqli_query( $conn, $query );
                        while( $row = mysqli_fetch_array( $result, MYSQLI_BOTH) ) { 
                            ?>
                                // Khai báo biến để trỏ đến marker
                            
                                var greenIcon = L.icon({
                                iconUrl: 'http://3.bp.blogspot.com/-ncVDZhUyIdg/T4JNtKJXyWI/AAAAAAAABUE/MSlrZ6HHhYw/s1600/logo+petrovietnam.jpg',

                                iconSize:     [40, 45], // size of the icon
                                iconAnchor:   [39, 44] // point of the icon which will correspond to marker's location
                            });
                                var r = new L.marker([<?php echo $row["t_lat"]?>, <?php echo $row["t_long"]?>], 
                                {
                                    icon: greenIcon,
                                    title: "<?php echo $row["t_ten"]?>"
                                                
                                });
                                
                    r.addTo(map)
                        .bindPopup('<?php echo $row["t_ten"]?>')
                        .openPopup();
                    
                <?php
            } 
            ?>

            
        </script>

    </body>

</html>