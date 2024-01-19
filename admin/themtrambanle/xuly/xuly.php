<?php
include('../config/config.php');
$t_ten = $_POST['ten'];
$t_diachi = $_POST['diachi'];
$t_sdt = $_POST['sdt'];
$t_lat = $_POST['vido'];
$t_long = $_POST['kinhdo'];
$ct_ma = $_POST['congty'];
$l_ma = 1;
$px_ma = $_POST['xa'];
if(isset($_POST['them'])){
    $sql_them = "INSERT INTO trambanle(t_ten,t_diachi,t_sdt,t_lat,t_long,ct_ma,l_ma,px_ma) VALUE('".$t_ten."','".$t_diachi."','".$t_sdt."','".$t_lat."','".$t_long."','".$ct_ma."','".$l_ma."','".$px_ma."')";
    mysqli_query($mysqli,$sql_them); 
    // header('location:http://localhost/xangdau/');   
}else{ echo "Lỗi. Vui lòng kiểm tra lại thông tin";}
?>