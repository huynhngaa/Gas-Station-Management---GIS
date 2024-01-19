
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="leaflet/leaflet.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css"/>
   <script src="leaflet/leaflet.js"></script>
   <script src="leaflet/leaflet-heat.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="leaflet/leaflet-routing-machine.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<!-- <html>
<head>
    <title>Bản đồ</title>
   
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="leaflet/leaflet.css">
   
    
    
   
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <link rel="stylesheet" href="leaflet/leaflet-routing-machine.css">
 
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
   
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>  
   
  
    
    
</head> -->
<body>
    <style>
#left {
    position: absolute;
    width: 29%;
    height: 95%;
    border: 1px solid blue;
}
#map{
    left: 29%;
    width: 70%;
    height: 95%;
    border: 1px solid rgb(0, 255, 21);
}

</style>


<div  id="left" > 

</div>
<div id="map"></div>

    
    <script>
        


var map = L.map('map').setView([10.0279603,105.7664918], 13);
var tiles =  L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
  maxZoom: 19,
  subdomains:['mt0']
}).addTo(map);

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
    //ket noi den csdl

    mysqli_set_charset( $conn, 'utf8' );
    // đọc và ghi dữ liệu dạng utf8

}

// Viết câu truy vấn

$query = "SELECT * FROM trambanle ";

// Thực thi truy vấn

$result = mysqli_query( $conn, $query );

// Duyệt kết quả trả về

while( $row = mysqli_fetch_array( $result, MYSQLI_BOTH) ) { 
    ?>
       
        // Khai báo biến để trỏ đến marker
        var r = new L.marker([<?php echo $row["t_lat"]?>, <?php echo $row["t_long"]?>], {
            title: "<?php echo $row["t_ten"]?>",
            alt: "Đại học Cần Thơ khu II"
        });
        r.addTo(map)
            .bindPopup('<?php echo $row["t_ten"]?>')
            .openPopup();
        
    <?php
} 
?>
var greenIcon = L.icon({
    iconUrl: 'logo.png',
    iconSize:     [45, 45], // size of the icon
});
var Icon = L.icon({
    iconUrl: 'giphy.gif',
    iconSize:     [45, 60], // size of the icon
});
var Iconnew = L.icon({
    iconUrl: 'maker.png',
    iconSize:     [45, 60], // size of the icon
});



  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;
    var marker = L.marker([latitude, longitude],{icon: Icon}).addTo(map);
    marker.bindPopup("Bạn đang ở đây").openPopup();
})};


    </script>
</body>
</html>