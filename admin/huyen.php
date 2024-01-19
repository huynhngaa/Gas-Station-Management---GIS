<?php include "ketnoi.php"?>
  <?php
 
  mysqli_set_charset($conn, 'UTF8');
  $ct_ma= $_POST['ct_ma'];
?>
<html>
<head>
<title>ung dung dau tien</title>

<link rel = 'stylesheet' href = 'css/style.css'>
<script src = 'js/index.js'></script>
<link rel = 'stylesheet' href = 'https://unpkg.com/leaflet@1.4.0/dist/leaflet.css' integrity = 'sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA==' crossorigin = ''/>
<script src = 'https://unpkg.com/leaflet@1.4.0/dist/leaflet.js' integrity = 'sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg==' crossorigin = ''></script>
<link rel = 'stylesheet' href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css' />
<script type = 'text/javascript' src = 'https://www.gstatic.com/charts/loader.js'></script>
<script type = 'text/javascript' src = '//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
<!-- CSS only -->
<link rel = 'stylesheet' href = 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css' integrity = 'sha384-9a9X+2xndz71SLG4J4hB3g3fDAtyH+6yS5Jn1mh6XcbU6fPn6I6Y07+6o/P5yf8' crossorigin = 'anonymous'>

     
</head>
<body>


 
<div id = 'left'>

<?php
$u = "SELECT * FROM congtydaumoi where ct_ma = '$ct_ma'  ";
$p = mysqli_query( $conn, $u );
$wo = mysqli_fetch_assoc( $p );
?>
<h2>Thống kê số lượng trạm xăng</h2>
<form action = 'huyen.php' method = 'post'>
<label for = 'pet-select'>Chọn công ty đầu mối:</label>

<select name = 'ct_ma' id = 'pet-select'>
<option value = '<?php echo $wo['ct_ma'] ?>'><?php echo $wo['ct_ten']  ?></option>
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
<div  id="map"></div>
<div id="right"></div>
 
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
      return d > 11? '#800026' :
           d > 6  ? '#BD0026' :
           d > 4 ? '#E31A1C' :
           d > 3  ? '#FC4E2A' :
           d > 2 ? '#FD8D3C' :
           d > 1  ? '#FEB24C' :
           d > 0.5   ? '#FED976' :
                      '#FFEDA0';
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