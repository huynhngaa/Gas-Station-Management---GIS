<?php
// Kết nối cơ sở dữ liệu
$conn = mysqli_connect('localhost', 'root', '', 'congtyxangdau');

// Nhận dữ liệu qh_ma từ yêu cầu POST
$qh_ma = $_POST['qh_ma'];

// Câu truy vấn lấy danh sách các xã tương ứng với huyện được chọn
$sql = "SELECT px_ma, px_ten FROM phuongxa WHERE qh_ma = '$qh_ma'";
$result = mysqli_query($conn, $sql);

// Chuyển đổi kết quả truy vấn sang dạng JSON và trả về
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}
echo json_encode($data);
?>
