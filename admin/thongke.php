<?php $conn = mysqli_connect ("localhost", "root", "", "congtyxangdau"); ?>
<?php 
if(isset($_POST['thongke'])){
    $ct_ma= $_POST['ct_ma'];
    // $query = 'SELECT qh_ten, COUNT(*) AS sl_tram FROM tramxanga GROUP BY qh_ten';
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
      $res = mysqli_query($conn, $query);
      $rows = array();
      $table = array();
      
      $table['cols'] = array(
       array(
        'label' => 'District', 
        'type' => 'string'
       ),
       array(
        'label' => 'Số lượng trạm xăng', 
        'type' => 'number',
        
       )
      );
      
      while($row = mysqli_fetch_array($res))
      {
       $sub_array = array();
       $sub_array[] =  array(
            "v" => $row["qh_ten"]
           
           );
       $sub_array[] =  array(
            "v" => (int) $row["sl_tram"]
           );
       $rows[] =  array(
           "c" => $sub_array
          );
      }
      $table['rows'] = $rows;
      $jsonTable = json_encode($table);
      
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

<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-Wa6XNz6StJU6ZG/JbYsxDs/NgkMaW8DvFyQTJr2r3qC3MIl8TnTgTgk7wGMKkMfW" crossorigin="anonymous"></script>

<script type="text/javascript">
   google.charts.load('current', {'packages':['corechart']});
   google.charts.setOnLoadCallback(drawChart);
   function drawChart()
   {
    var data = new google.visualization.DataTable(<?php echo $jsonTable; ?>);
    <?php
    $q = "SELECT * FROM congtydaumoi WHERE ct_ma = 3";
    $res = mysqli_query( $connect, $q );
    $r = mysqli_fetch_assoc($res);
// Assuming that $r["qh_ten"] contains the name of a district
$districtName = $r["ct_ten"];
?>
    var options = {
     title:'Số lượng trạm xăng của <?php echo $districtName ?>',
     legend:{position:'bottom'},
     chartArea:{width:'95%', height:'70%'},
     vAxis: {
    format: '0'
  },
  colors: ['#76A7FA']
  
    };

    var chart = new google.visualization.ColumnChart(document.getElementById('column_chart'));

    chart.draw(data, options);
   }
  </script>
    </head>
    <body>
        <div class="container">
             <h2>Thống kê số lượng trạm xăng</h2>
             <form action="thongke.php" method="post">
              <label for="pet-select">Chọn công ty đầu mối:</label>

              <select name="ct_ma" id="pet-select">
   <option value="">--Chọn công ty đầu mối--</option>
<?php
$query = "SELECT * FROM congtydaumoi ";
$result = mysqli_query( $conn, $query );
while($row = mysqli_fetch_array($result)){ ?>
   <option value="<?php echo $row['ct_ma']?>"> <?php echo $row['ct_ten']?></option>
 <?php } ?>
</select>
<input name="thongke" style=" background-color: #4CAF50;color: white;padding: 14px 20px;margin: 8px 0;border: 1px solid rgba(0, 117, 33, 0.453);cursor: pointer; opacity: 0.9;" type="submit" VALUE ="thong ke ">
</form>  

<div id="column_chart" style="width: 100%; height: 500px"></div>       
             <!-- Button trigger modal -->


        </div>
       
    </body>

</html>