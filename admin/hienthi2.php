<?php
    // Connect to the database
    $conn = mysqli_connect("localhost", "root", "", "congtyxangdau"); 

    // Check if the form has been submitted
    if(isset($_POST['hienthi'])){
        // Get the selected company IDs
        $ct_ma = isset($_POST['congty']) ? $_POST['congty'] : array();

        // Construct the SQL query with a prepared statement to prevent SQL injection
        $sql = "SELECT * FROM trambanle WHERE ct_ma IN (".str_repeat('?,', count($ct_ma) - 1)."?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, str_repeat('i', count($ct_ma)), ...$ct_ma);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
       echo "var map = L.map('mapid').setView([10.7799, 106.6897], 10);";
        // Create a Leaflet layer group for the markers
        echo "var markers = L.layerGroup();\n";

        // Loop through the results and display the markers
        while($r = mysqli_fetch_assoc($res)) {
            echo "var marker = L.marker([" . $r['t_lat'] . ", " . $r['t_long'] . "]).bindPopup('" . $r['t_ten'] . "');\n";
            echo "markers.addLayer(marker);\n";
        }

        // Add the markers layer to the map
        echo " var marker.addTo(map)\n";
    }
?>

<html>
    <head>
        <title>ung dung dau tien</title>

        <link rel="stylesheet" href="css/style.css">
        <script src="js/index.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA==" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js" integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg==" crossorigin=""></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <!-- CSS only -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-9a9X+2xndz71SLG4J4hB3g3fDAtyH+6yS5Jn1mh6XcbU6fPn6I6Y07+6o/P5yf8" crossorigin="anonymous">
        <body>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <form method="post">
                        <h2>Chọn các công ty để hiển thị trạm bán lẻ</h2>
                        <div class="form-check">
                            <?php
                                // Fetch the companies from the database
                                $sql = "SELECT * FROM congtydaumoi";
                                $res = mysqli_query($conn, $sql);
                                                            // Display the checkboxes for the companies
                            while($r = mysqli_fetch_assoc($res)) {
                                echo "<input type='checkbox' class='form-check-input' name='congty[]' value='" . $r['ct_ma'] . "' id='ct_" . $r['ct_ma'] . "'/>";
                                echo "<label class='form-check-label' for='ct_" . $r['ct_ma'] . "'>" . $r['ct_ten'] . "</label><br/>";
                            }
                        ?>
                    </div>
                    <br/>
                    <button type="submit" class="btn btn-primary" name="hienthi">Hiển thị</button>
                </form>
            </div>
            <div class="col-md-6">
                <div id="mapid"></div>
            </div>
        </div>
    </div>
</body>
<script>
    var map = L.map('mapid').setView([10.7799, 106.6897], 10);
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiaGFubmFoZW5nYiIsImEiOiJja2JzbXczcTIwMzI4MnNwYzZibWJtb2YzIn0.IovKdJkWwy6yquU6NnT6Gw', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
            '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
            'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: 'your.mapbox.access.token'
    }).addTo(map);
</script> 
</html> 
