<?php
require_once('../../../ConnectDB/connectDB.php');

// Kết nối cơ sở dữ liệu
$conn = connectDB();
ob_start();
session_start();

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Truy vấn số lượt xem của các bài đăng
$sql = "SELECT bd.id_bd, co.dia_chi, bd.luot_xem 
        FROM bai_dang bd 
        INNER JOIN cho_o co ON co.id_bd = bd.id_bd 
        ORDER BY bd.luot_xem DESC";

$result = $conn->query($sql);

// Kiểm tra truy vấn
if (!$result) {
    die("Truy vấn thất bại: " . $conn->error);
}

$chart_data = [];
while ($val = mysqli_fetch_assoc($result)) {
    $chart_data[] = array(
        'id' => $val['id_bd'],
        'tieu_de' => $val['dia_chi'],
        'luot_xem' => $val['luot_xem']
    );
}

// Trả về dữ liệu dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($chart_data);

// Đóng kết nối
$conn->close();
?>