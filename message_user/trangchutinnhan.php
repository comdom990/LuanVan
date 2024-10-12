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
      <section class="users">
        <header>
          <?php   
          $sql_nd=$conn->query("SELECT * FROM nguoi_dung where id_nd='$user_id'");
          if ($sql_nd -> num_rows > 0) {
                  while($row = $sql_nd -> fetch_assoc()){?>
          <div class="content">
            <img src="../img/avata/<?=$row['hinhanh']?>" alt="">
            <div class="details">
              <span><?=$row['hoten']?></span>
              <p></p>
            </div>
          </div>
          
        <?php }} ?>           
        </header>
        <div class="search">
          <span class="text">Lựa chọn bạn bè để trò chuyện</span>
          <input type="text" name="search" placeholder="Nhập tên để tìm kiếm">
          <button class=""><i class="fas fa-search"></i></button>
        </div>
        <div class="users-list">
                    <a href="#">
                      <div class="content"></div>
                    </a>
        </div>
      </section>
    </div>
  </div>   
  <script src="../js/user.js"></script>
</body>
</html>