<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'congtyxangdau2';

// Create connection
$conn = new mysqli( $servername, $username, $password, $dbname );
if ( $conn->connect_error ) {
    die( 'Không kết nối: ' . $conn->connect_error );
}

mysqli_set_charset( $conn, 'UTF8' );

?>
<html>
<head>
<title>ung dung dau tien</title>

<link rel = 'stylesheet' href = './style.css'>
<script src = 'js/index.js'></script>
<link rel = 'stylesheet' href = 'https://unpkg.com/leaflet@1.4.0/dist/leaflet.css' integrity = 'sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA==' crossorigin = ''/>
<script src = 'https://unpkg.com/leaflet@1.4.0/dist/leaflet.js' integrity = 'sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg==' crossorigin = ''></script>
<link rel = 'stylesheet' href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css' />
<script type = 'text/javascript' src = 'https://www.gstatic.com/charts/loader.js'></script>
<script type = 'text/javascript' src = '//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
<!-- CSS only -->
<link rel = 'stylesheet' href = 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css' integrity = 'sha384-9a9X+2xndz71SLG4J4hB3g3fDAtyH+6yS5Jn1mh6XcbU6fPn6I6Y07+6o/P5yf8' crossorigin = 'anonymous'>

<!-- JavaScript Bundle with Popper -->

</head>
<body>
<div id = 'left'>
<h2>Thống kê số lượng trạm xăng</h2>
<form action = 'huyen.php' method = 'post'>
<label for = 'pet-select'>Chọn công ty đầu mối:</label>

<select name = 'ct_ma' id = 'pet-select'>
<option value = ''>--Chọn công ty đầu mối--</option>
<?php
$query = 'SELECT * FROM congtydaumoi ';
$result = mysqli_query( $conn, $query );
while( $row = mysqli_fetch_array( $result ) ) {
    ?>
    <option value = "<?php echo $row['ct_ma']?>"> <?php echo $row[ 'ct_ten' ]?></option>
    <?php }
    ?>
    </select>
    <input name = 'thongke' style = ' background-color: #4CAF50;color: white;padding: 14px 20px;margin: 8px 0;border: 1px solid blue;cursor: pointer;width: 100%; opacity: 0.9;' type = 'submit' VALUE = 'thong ke '>
    </form>
    <!-- Button trigger modal -->

    </div>
    <div id = 'map'></div>
    <!-- <div id = 'right'></div> -->

    <script>
    var mapOptions = {
        center: [ 10.0279603, 105.7664918 ], zoom: 10}
        ;
        var map = new L.map( 'map', mapOptions );
        var layer = new
        L.TileLayer( 'http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20, subdomains:[ 'mt0', 'mt1', 'mt2', 'mt3' ]}
        );
        map.addLayer( layer );
        // Icon options
        var iconOptions = {
            iconUrl: 'images/logo.png',
            iconSize: [ 50, 50 ]
        }
        // Creating a custom icon
        var customIcon = L.icon( iconOptions );

        // Creating Marker Options
        var markerOptions = {
            title: 'Đại học Cần Thơ',
            clickable: true,
            draggable: true,
            icon: customIcon
        }
        var marker = new L.marker( [ 10.02998651715615, 105.77057238168852 ], markerOptions );
        // Adding popup to the marker
        marker.bindPopup( 'Khu II Đại học Cần Thơ' ).openPopup();
        marker. addTo( map );
        </script>

        </body>

        </html>