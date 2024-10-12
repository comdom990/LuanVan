<?php

require_once('../ConnectDB/connectDB.php'); 
ob_start();
session_start();
$conn = connectDB();
$user_id = 0;
$name = '';
    if(!empty($_SESSION['nguoidung'])){
        $user_id = $_SESSION['nguoidung']['id_nd'] ?? 0;
     
        $result = $conn->query("SELECT * FROM nguoi_dung where id_nd = '$user_id'");
        $result = $result->fetch_all(MYSQLI_ASSOC);
        $name = $result[0]['tentaikhoan'];
      
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./tinnhan.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

</head>
<body>
    
<div class="main">
    <div class="wrapper">
      <section class="chat-area">
      <header>
        <?php 
            $id_nd='';
            if(isset($_GET['id_nd'])){
                $id_nd = $_GET['id_nd'];
            }
          $sql_nd=$conn->query("SELECT * FROM nguoi_dung where id_nd='$id_nd'");
          if(mysqli_num_rows($sql_nd)>0){
            $row= mysqli_fetch_assoc($sql_nd);
          }
          ?>
          <a href="trangchutinnhan.php" class="back-icon">
            <i class="fas fa-arrow-left"></i>
          </a>
          <img src="../img/avata/<?=$row['hinhanh']?>" alt="">
          <div class="details">
            <span><?=$row['hoten']?></span>
            <div></div>
          </div>
          
        </header>
        <div class="chat-box">
          
        </div>
        <form action="#" class="typing-area" autocomplete="off">
          <input type="text" name="outgoing_id" class="outgoing_id" value="<?php echo $_SESSION['nguoidung']['id_nd'] ?? 0;?>" hidden>
          <input type="text" name="incoming_id" class="incoming_id" value="<?php echo $id_nd;?>" hidden>
          <input type="text" name="message" class="input-field" placeholder="Nhập nội dung ở đây...">
            <button>

              <i class="fab fa-telegram-plane"></i>
            </button>
        </form>
      </section>
    </div>

    <!-- <script src="../js/user.js"></script> -->
    <script src="../js/chat.js"></script>
  </div>
</body>
</html>