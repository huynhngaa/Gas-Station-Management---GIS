<?php
// Kết nối cơ sở dữ liệu
include "connnect.php";

// Nhận dữ liệu qh_ma từ yêu cầu POST
$h_ma = $_POST['h_ma'];

// Câu truy vấn lấy danh sách các xã tương ứng với huyện được chọn
$sql = "SELECT x_ma, x_ten FROM xa WHERE h_ma = '$h_ma'";
$result = mysqli_query($conn, $sql);

// Chuyển đổi kết quả truy vấn sang dạng JSON và trả về
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}
echo json_encode($data);
?>
