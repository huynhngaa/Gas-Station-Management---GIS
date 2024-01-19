<?php include "admin/ketnoi.php"?>

<?php
// Connect to database


if(isset($_POST['thongke'])){
    $ct_ma = $_POST['ct_ma'];
    
    // Query to get the number of petrol stations in each district for the selected company
    $query = "SELECT c.qh_ten, COUNT(*) AS sl_tram 
        FROM trambanle a
        INNER JOIN phuongxa b ON a.px_ma = b.px_ma
        INNER JOIN quanhuyen c ON b.qh_ma = c.qh_ma
        WHERE a.ct_ma = $ct_ma 
        GROUP BY c.qh_ten
        UNION
        SELECT c.qh_ten, 0 AS sl_tram 
        FROM quanhuyen c
        WHERE c.qh_ma NOT IN (
            SELECT b.qh_ma 
            FROM trambanle a 
            INNER JOIN phuongxa b ON a.px_ma = b.px_ma
            INNER JOIN quanhuyen c ON b.qh_ma = c.qh_ma 
            WHERE a.ct_ma = $ct_ma
        )
        ORDER BY qh_ten ASC;
    ";
    
    // Execute query and get results
    $res = mysqli_query($conn, $query);
    
    // Create an array to store the data for the chart
    $rows = array();
    $table = array();
    $table['cols'] = array(
        array('label' => 'District', 'type' => 'string'),
        array('label' => 'Number of Petrol Stations', 'type' => 'number'),
    );
    
    // Loop through the query results and add the data to the array
    while($row = mysqli_fetch_array($res)) {
        $sub_array = array();
        $sub_array[] = array('v' => $row["qh_ten"]);
        $sub_array[] = array('v' => (int) $row["sl_tram"]);
        $rows[] = array('c' => $sub_array);
    }
    
    // Encode the array in JSON format
    $table['rows'] = $rows;
    $jsonTable = json_encode($table);
} 

?>

<html>
<head>
    <title>Petrol Station Chart</title>
    <!-- Load Google Charts API -->
    <title>ung dung dau tien</title>

<link rel="stylesheet" href="css/style.css">
<script src="js/index.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<link rel="stylesheet" href="admin/css/style.css">
<link rel="stylesheet" href="admin/css/style2.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA==" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js" integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg==" crossorigin=""></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<link rel="stylesheet" href="admin/css/leaflet-search.css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>
  
<div class="container">
    <form method="post">
    <select name="ct_ma" id="pet-select">
   <option value="">--Chọn công ty đầu mối--</option>
<?php
$query = "SELECT * FROM congtydaumoi ";
$result = mysqli_query( $conn, $query );

while($row = mysqli_fetch_array($result)){ ?>
   <option value="<?php echo $row['ct_ma']?>"> <?php echo $row['ct_ten']?></option>
 <?php } ?>
</select>
<input type="submit" name="thongke" value="Thống kê"  />

    </form>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<script>
    // Load the visualization library and set a callback
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        // Create the data table from the JSON data
        var data = new google.visualization.DataTable(<?php echo $jsonTable; ?>);
<?php $q = "SELECT * FROM congtydaumoi where ct_ma = $ct_ma ";
$res = mysqli_query( $conn, $q );

$r = mysqli_fetch_array($res) ?> 
        // Set chart options
        var options = {
            title: 'Số lượng trạm xăng của công ty <?php echo $r['ct_ten'] ?>',
            legend: { position: 'none' },
            vAxis: {
    format: '0'
  },
  colors: ['#76A7FA']
  
        };

        // Instantiate and draw the chart
        var chart = new google.visualization.ColumnChart(document.getElementById('column_chart'));
        chart.draw(data, options);
    }
</script>
<div id="column_chart" style="width:90%; height: 500px;"></div>
</div>
</body>
</html> 