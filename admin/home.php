<?php
//index.php
$conn = mysqli_connect("localhost", "root", "", "congtyxangdau");


$query = "SELECT * FROM congtydaumoi ";
$result = mysqli_query( $conn, $query );
$rows = array();

//$row = mysqli_fetch_array($result);
$table = array();
$table['cols'] = array(
 array(
  'label' => 'Date Time', 
  'type' => 'datetime'
 ),
 array(
  'label' => 'Temperature (°C)', 
  'type' => 'number'
 )
);

// while($row = mysqli_fetch_array($result))
// {
//  $sub_array = array();
//  $datetime = explode(".", $row["datetime"]);
//  $sub_array[] =  array(
//       "v" => 'Date(' . $datetime[0] . '000)'
//      );
//  $sub_array[] =  array(
//       "v" => $row["sensors_temperature_data"]
//      );
//  $rows[] =  array(
//      "c" => $sub_array
//     );
// }
// $table['rows'] = $rows;
// $jsonTable = json_encode($table);

?>


<html>
 <head>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <!-- <script type="text/javascript">
   google.charts.load('current', {'packages':['corechart']});
   google.charts.setOnLoadCallback(drawChart);
   function drawChart()
   {
    var data = new google.visualization.DataTable(<?php echo $jsonTable; ?>);

    var options = {
     title:'Sensors Data',
     legend:{position:'bottom'},
     chartArea:{width:'95%', height:'65%'}
    };

    var chart = new google.visualization.LineChart(document.getElementById('line_chart'));

    chart.draw(data, options);
   }
  </script> -->
  <style>
  .page-wrapper
  {
   width:1000px;
   margin:0 auto;
  }
  </style>
 </head>  
 <body>
  <div class="page-wrapper">
   <br />
   <h2>Thống kê số lượng trạm xăng</h2>
             
             <label for="pet-select">Chọn công ty đầu mối:</label>

             <select id="pet-select">
   <option value="">--Chọn công ty đầu mối--</option>
<?php
$query = "SELECT * FROM congtydaumoi ";
$result = mysqli_query( $conn, $query );
while($row = mysqli_fetch_array($result)){ ?>
   <option><?php echo $row['ct_ten']?></option>
 <?php } ?>
 <option style="color:red" >tg</option>
</select>

<button class="searc"><i class="fas fa-search"></i> Tìm kiếm</button>
   <h2 align="center">Display Google Line Chart with JSON PHP & Mysql</h2>
  </div>
 </body>
</html>