<?php 

require_once('../ConnectDB/connectDB.php');
session_start();
ob_start();
$conn = connectDB();

// Giả sử bạn có ID người dùng trong session
if (isset($_SESSION['nguoidung'])) {
    $userId = $_SESSION['nguoidung']['id_nd']; // Hoặc cách truy cập khác tùy vào cấu trúc session

    // Cập nhật trạng thái người dùng
    $stmt = $conn->query("UPDATE nguoi_dung SET status = 'Không truy cập' WHERE id_nd = ".$userId." ");
    
    // Kiểm tra nếu câu lệnh chuẩn bị thành công
    if ($stmt) {
        header("Refresh:1");
        echo '<span class="notification__success" style="color : #42c174;">Hiện Thành Công !</span>';
      
    } else {
        echo '<span class="notification__fail">Hiện Thất Bại !</span>';
    }
}

// Xóa session
unset($_SESSION['nguoidung']);
$conn->close(); // Đóng kết nối
header('Location: ../index.php');
exit();

?>
