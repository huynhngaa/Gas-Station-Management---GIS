<?php
	session_start();
 include "ketnoi.php"?>
  <?php
 
  mysqli_set_charset($conn, 'UTF8');
  $ct_ma= $_POST['congty'];
?>
<html>
<head>
 

<title>Quản lý trạm xăng</title> 
<link rel="icon" href="images/logo.png" type="image/png">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA==" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js" integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg==" crossorigin=""></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.min.js" integrity="sha512-7rusk8kGPFynZWu26OKbTeI+QPoYchtxsmPeBqkHIEXJxeun4yJ4ISYe7C6sz9wdxeE1Gk3VxsIWgCZTc+vX3g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<link rel="stylesheet" href="css/leaflet-search.css" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Font Awesome -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;700&display=swap" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
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


<div id="map">
<div style="background-color: white; position: absolute;z-index: 500; margin-left: 50px; padding-top:5px">
<?php
       
       $q = "SELECT * FROM congtydaumoi where ct_ma=$ct_ma";
       $res = mysqli_query( $conn, $q );
      $r = mysqli_fetch_array($res) ?>
  <h5 style="color:#FE5A1D"><b>Thống kê số lượng trạm của <?php echo $r['ct_ten']?></b> </h5>
</div>
</div>
<script>
       var mapOptions = {
      center: [10.0279603,105.7664918],
      zoom: 14
      };

      var map = L.map('map').setView([10.1090045,105.5728619], 11);
      var tiles =  L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
        maxZoom: 19,
        subdomains:['mt0']
      }).addTo(map);
    
     
       var statesData = {
      "type": "FeatureCollection",
      "crs": { "type": "name", "properties": { "name": "urn:ogc:def:crs:OGC:1.3:CRS84" } },                                                                                                                                  
      "features": [
        <?php
       
                    $query = "SELECT * FROM quanhuyen";
                    $result = mysqli_query( $conn, $query );
                    while($row = mysqli_fetch_array($result)){ ?> { "type": "Feature", "properties": {"Ten_Tinh": "Cần Thơ", 
                                                          "Ten_Huyen": "<?php echo $row['qh_ten'] ;?>", 
                                                          "Tram_Xang":<?php  
                                                                $e = "SELECT count(*) as 'tong' FROM quanhuyen a, phuongxa d, trambanle f  where f.px_ma=d.px_ma and d.qh_ma = a.qh_ma and f.ct_ma = '$ct_ma' and a.qh_ma = '".$row['qh_ma']."'; ";
                                                                $t = mysqli_query( $conn,$e );
                                                                if(mysqli_num_rows($t) == true){
                                                                    while( $y = mysqli_fetch_array( $t ) ) {
                                                                        echo $y['tong'];
                                                                    }
                                                                }else{
                                                                    echo "0";
                                                                }
                                                          ?>}, 
                                                          "geometry": { "type": "Polygon", "coordinates": [ [ 
                                                                                                              <?php
                                                                                                                  $q = "SELECT * FROM  ct_quanhuyen where qh_ma = '".$row['qh_ma']."' ";
                                                                                                                  $r = mysqli_query( $conn, $q );
                                                                                                                  while($ro = mysqli_fetch_array($r)){  ?>
                                                                                                                    [<?php echo $ro['x'] ?>,<?php echo $ro['y'] ?>],
                                                                                                                <?php  } ?>
                                                                                                            ] 
                                                                                                          ] 
                                                                      } 
                      },
                     <?php } ?>  
                  ]
        } 
       
     
      function getColor(d) {
      return d >= 6? '#7a0177' :
           d >= 5  ? '#ae017e' :
           d >= 4 ? '#dd3497' :
           d >= 3  ? '#f768a1' :
           d >=2 ? '#fa9fb5' :
           d >=1  ? '#fcc5c0' :
                      '#fde0dd';
        }
      function style(feature) {
          return {
              fillColor: getColor(feature.properties.Tram_Xang),
              weight: 2,
              opacity: 1,
              color: 'white',
              dashArray: '3',
              fillOpacity: 2
          };
      }

      L.geoJson(statesData, {
        style: style,
        onEachFeature: function(feature, layer) {
          layer.on({
            mouseover: function(e) {
              var popupContent = "<b>" + feature.properties.Ten_Huyen + "</b><br>" + "Số lượng trạm xăng: " + feature.properties.Tram_Xang ;
              layer.bindPopup(popupContent).openPopup();
            },
            mouseout: function(e) {
              layer.unbindPopup();
            }
          });
        }
      }).addTo(map);

      
     
    </script>





</body>
</html>
