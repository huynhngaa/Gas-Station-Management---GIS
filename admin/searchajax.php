<?php 
  include("ketnoi.php");
  
   $name = $_POST['name'];
  
   $sql = "SELECT * FROM trambanle, congtydaumoi where trambanle.ct_ma = congtydaumoi.ct_ma and ct_ten LIKE '$name%'";  
   $query = mysqli_query($conn,$sql);
   $data='';
   while($row = mysqli_fetch_assoc($query))
   {
       $data .=  "<tr><td>".$row['t_ten']."</td> </tr>";
   }
    echo $data;
 ?>