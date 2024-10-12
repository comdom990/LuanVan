<?php
    require_once('../ConnectDB/connectDB.php'); 
    require_once('../phpmailer/Exception.php'); 
    require_once('../phpmailer/PHPMailer.php'); 
    require_once('../phpmailer/SMTP.php'); 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    ob_start();
    session_start();
  
    $conn = connectDB();
    $user_id = 0;
        if(!empty($_SESSION['nguoidung'])){
            $user_id = $_SESSION['nguoidung']['id_nd'] ?? 0;
           
            
            if(isset($user_id)){
                $outgoing_id = mysqli_real_escape_string($conn,$_POST['outgoing_id']) ;
                $incoming_id = mysqli_real_escape_string($conn,$_POST['incoming_id']);
                $message = mysqli_real_escape_string($conn,$_POST['message']);
               
                if(!empty($message)){
                    $sql=$conn->query("INSERT INTO tin_nhan VALUES (null,'$incoming_id','$outgoing_id', '$message')") or die();
                     // Gửi email thông báo
                     // Lấy email và tên của người gửi
                            $sender_sql = $conn->query("SELECT hoten, email FROM nguoi_dung WHERE id_nd = '$outgoing_id'") or die();
                            $sender_row = mysqli_fetch_assoc($sender_sql);
                            $sender_name = $sender_row['hoten']; // Tên người gửi
                            $to = $recipient_row['email']; // Địa chỉ email của người nhận

                            // Lấy email của người nhận
                            $recipient_sql = $conn->query("SELECT email FROM nguoi_dung WHERE id_nd = '$incoming_id'") or die();
                            $recipient_row = mysqli_fetch_assoc($recipient_sql);
                            $to = $recipient_row['email']; // Địa chỉ email của người nhận

                            $subject = "Bạn có tin nhắn mới!";
                            $body = "Bạn đã nhận được một tin nhắn mới từ: " .$sender_name . "\nNội dung: " . $message;

                            // Khởi tạo PHPMailer
                            $mail = new PHPMailer(true); 
                            try {
                                //Server settings
                                $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Thay đổi theo nhu cầu
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
                                echo 'Gửi thành công';
                            } catch (Exception $e) {
                                echo "Lỗi. Mailer Error: {$mail->ErrorInfo}";
                            }




                }
            }
          
        }
    
?>