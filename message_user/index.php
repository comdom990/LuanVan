<?php 
require_once('../ConnectDB/connectDB.php');
require_once('../Library/library.php');
ob_start();
session_start();



if (isset($_SESSION['nguoidung'])) {
    $conn = connectDB();
    $idCustomer = $_SESSION['nguoidung']['id_nd'];
    $result = $conn -> query("SELECT * FROM nguoi_dung WHERE id_nd = ".$idCustomer."");
    $row = $result -> fetch_assoc();

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
    <title>O'House</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../home/home_list.css">
    <link rel="stylesheet" href="../home/main.css">
    <link rel="stylesheet" href="../home/base.css">
    <link rel="stylesheet" href="../home/home.css">
    <link rel="stylesheet" href="./user.css">
    <link rel="stylesheet" href="./tinnhan.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
   

.received-message {
    color: red; /* Màu đỏ cho tin nhắn nhận */
}
</style>
</head>
<body>
    <header>
        <div class="header_main" style="background-image: url('https://www.lacartedescolocs.fr/assets/backgrounds/header_bg-8e48a21d4f3b4e87d988fbc77732705322506141957f1fe09e088dbde7f58ff6.png');">
            
        <div class="logo_home">
                        <a href="../index.php">

                        <img src="../img/lone.png" alt="" class="logo_header">
                        </a>

                    </div>
                    <ul class="nav navi_home">
                      
                        <li class="nav-item_home">
                            <a class="nav-link sig" href="../search-home/sea_home.php">
                            <i class="fa-solid fa-search "></i>

                                <Button class="home">
                                    Tìm kiếm chỗ ở
                                </Button>
                            </a>
                        </li>
                        <li class="nav-item_home">
                            <a class="nav-link " href="../home/home.php">
                            <i class="fa-solid fa-bed "></i>

                                <Button class="home">
                                    Cung cấp chỗ ở
                                </Button>
                            </a>
                        </li>
                        <li class="nav-item_home">
                            <a class="nav-link " href="./index.php">
                            <i class="fa-solid fa-comment "></i>

                                <Button class="home">
                                Tin nhắn
                            </Button>
                            </a>
                        </li>
                        <div class="account"  style=" margin-top: -27px !important;">
                    
                    <?php disLogin(1)?>
              </div>
                        <!-- <li class="nav-item_home">
                            <a class="nav-link " href="#">
                            <i class="fa-solid fa-sign-in "></i>

                                <Button class="home" id="log">
                                    Đăng nhập
                                </Button></a>
                        </li> -->
                      
                     
                    </ul>
                    
        </div>
    </header>
<div class="contain">

    <div class="main1">
        <div class="wrapper1">
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

            </div>
        </section>
    </div>
  </div>   
  <script src="../js/user.js"></script>
  
  <div class="main2">
    <div class="wrapper_tn">
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
            <!-- <i class="fas fa-arrow-left"></i> -->
          </a>
          <?php 
                if (!empty($row['hinhanh'])) {
                    echo '<img src="../img/avata/' . $row['hinhanh'] . '" alt="">';
                } else {
                    echo '<img src="../img/avata/avata_emty.png" alt="">';
                }
        ?>
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
            <button  class="bt_user">

              <i class="fab fa-telegram-plane"></i>
            </button>
        </form>
      </section>
    </div>

    <!-- <script src="../js/user.js"></script> -->
    <script src="../js/chat.js"></script>
  </div>
<!-- thongtin -->
</div>



    <!-- login -->

<footer>
    <div class="footer" style="background-image: url('https://www.lacartedescolocs.fr/assets/backgrounds/header_bg-8e48a21d4f3b4e87d988fbc77732705322506141957f1fe09e088dbde7f58ff6.png');"></div>
</footer>
<script src="../main.js"></script>
<script src="./styleJs.js"></script>

</body>
</html>
<?php }  else {
    echo "<script>alert('Bạn hãy đăng nhập để vào hệ thống!'); window.location.href = '../index.php';</script>";
}
?>
