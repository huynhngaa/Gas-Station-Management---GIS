<!-- index.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Chọn huyện và xã tương ứng</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <form>
        <label for="qh_select">Chọn huyện:</label>
        <select id="qh_select" name="qh_select">
            <option value="">--Chọn huyện--</option>
            <?php
            // Kết nối cơ sở dữ liệu
            $conn = mysqli_connect('localhost', 'root', '', 'ten_csdld');

            // Lấy danh sách các huyện
            $sql = "SELECT qh_ma, qh_ten FROM quanhuyen";
            $result = mysqli_query($conn, $sql);

            // Hiển thị danh sách các huyện trong thẻ select
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<option value="' . $row['qh_ma'] . '">' . $row['qh_ten'] . '</option>';
            }
            ?>
        </select>
        <br>
        <label for="px_select">Chọn xã:</label>
        <select id="px_select" name="px_select">
            <option value="">--Chọn xã--</option>
        </select>
    </form>

    <script>
        $(document).ready(function() {
            // Gửi yêu cầu khi thay đổi giá trị của thẻ select chọn huyện
            $('#qh_select').change(function() {
                var qh_ma = $(this).val();
                $.ajax({
                    url: 'get_phuongxa.php',
                    type: 'POST',
                    data: {qh_ma: qh_ma},
                    dataType: 'json',
                    success: function(data) {
                        // Xóa danh sách xã cũ và hiển thị danh sách xã mới
                        $('#px_select').find('option').remove().end().append('<option value="">--Chọn xã--</option>');
                        $.each(data, function(index, element) {
                            $('#px_select').append('<option value="' + element.px_ma + '">' + element.px_ten + '</option>');
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>

<!-- get_phuongxa.php -->
