<?php 
require_once('../ConnectDB/connectDB.php');
require_once('../Library/library.php');
require_once('../phpmailer/Exception.php'); 
require_once('../phpmailer/PHPMailer.php'); 
require_once('../phpmailer/SMTP.php'); 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
ob_start();
session_start();

$sql_update= ("UPDATE bai_dang SET trang_thai='0' WHERE ngay_dang < NOW() - INTERVAL 7 DAY AND trang_thai='1';");






if (isset($_SESSION['nguoidung'])) {
    $conn = connectDB();
// include 'post_update.php';

    $idCustomer = $_SESSION['nguoidung']['id_nd'];
    $result = $conn -> query("SELECT * FROM nguoi_dung WHERE id_nd = ".$idCustomer."");
    $row = $result -> fetch_assoc();
    $email = $row['email'];

if ($conn->query($sql_update) === TRUE) {
             // Gửi email thông báo
                    
                     $sender_name = "CO'HOUSE"; 

                     // Lấy email của người nhận
                     $recipient_sql = $conn->query("SELECT email FROM nguoi_dung WHERE id_nd = '$idCustomer'") or die();
                     $recipient_row = mysqli_fetch_assoc($recipient_sql);
                     $to = $recipient_row['email']; // Địa chỉ email của người nhận

                     $subject = "Bạn có tin nhắn mới!";
                     $body = "Bạn đã nhận được một tin nhắn mới từ: " .$sender_name . "\nNội dung: Bài đăng đã qua 7 ngày sẽ ẩn bài đăng. Nếu bạn có nhu cầu hiển thị lại thì hãy chọn hiện trong trang cá nhân" ;

                     // Khởi tạo PHPMailer
                     $mail = new PHPMailer(true); 
                     try {
                         //Server settings
                         $mail->SMTPDebug = SMTP::DEBUG_OFF; // Thay đổi theo nhu cầu
                         $mail->isSMTP();
                         $mail->Host       = 'smtp.gmail.com';
                         $mail->SMTPAuth   = true;
                         $mail->Username   = 'ndh09092002@gmail.com';
                         $mail->Password   = 'incvteiautvcwbkv'; // Sử dụng mật khẩu ứng dụng nếu cần
                         $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Hoặc ENCRYPTION_SMTPS
                         $mail->Port       = 465; // Thay đổi theo loại mã hóa
                 
                         //Recipients
                         $mail->setFrom('huylatoi1133@gmail.com', 'Huy');
                         $mail->addAddress($to);
                 
                         //Content
                         $mail->isHTML(true);
                         $mail->CharSet = 'UTF-8'; // Đặt mã hóa là UTF-8
                         $mail->Subject = $subject;
                         $mail->Body    = $content;
                         $mail->Body    = nl2br($body);
                         
                         $mail->send();
                        //  echo 'Gửi thành công';
                        //  echo '
                        //  <scrip> console.log("DONE");</scrip>
                        //  '
                        ;
                     } catch (Exception $e) {
                         echo "Lỗi. Mailer Error: {$mail->ErrorInfo}";
                     }
} 
} 


?>