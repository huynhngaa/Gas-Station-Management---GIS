<?php
	session_start();
?>
<?php include "admin/ketnoi.php" ?>
<?php
if(isset($_POST['thongke'])){
  $ct_ma = $_POST['congty'];
  
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
      array('label' => 'Quận huyện', 'type' => 'string'),
      array('label' => 'Số lượng trạm xăng', 'type' => 'number'),
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
 

<title>Quản lý trạm xăng</title> 
<link rel="icon" href="admin/images/logo.png" type="image/png">

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
<!-- Navbar -->
<div id="map">
<div style="margin-left:20%;margin-right:20%;margin-top:4%" >
 <form  class="row" method="post">
    <select  name="congty" class="custom-select col-8" id="pet-select">
   <option value="">--Chọn công ty đầu mối--</option>
<?php
$query = "SELECT * FROM congtydaumoi ";
$result = mysqli_query( $conn, $query );

while($row = mysqli_fetch_array($result)){ ?>
   <option value="<?php echo $row['ct_ma']?>"> <?php echo $row['ct_ten']?></option>
 <?php } ?>
</select>
        <input style="margin-left:5px;" class="col-3 btn btn-success" type="submit" name="thongke" value="Thống kê"/>
    </form>
</div>

<script>

    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
    
        var data = new google.visualization.DataTable(<?php echo $jsonTable; ?>);
<?php $q = "SELECT * FROM congtydaumoi where ct_ma = $ct_ma ";
$res = mysqli_query( $conn, $q );

$r = mysqli_fetch_array($res) ?> 

        var options = {
            title: 'Số lượng trạm xăng của <?php echo $r['ct_ten'] ?>',
            legend: { position: 'none' },
            vAxis: {
    format: '0'
  },
  colors: ['#76A7FA']
  
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('column_chart'));
        chart.draw(data, options);
    }
</script>
<div id="column_chart" style="width:90%; height: 500px;"></div>

</div> 


</body>
</html>
