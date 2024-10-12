<?php 
require_once('../ConnectDB/connectDB.php');
require_once('../Library/library.php');
ob_start();
session_start();

$conn = connectDB();

$idcategory = '';
if(isset($_GET['idcategory'])){
    $idcategory = $_GET['idcategory'];
    $result = $conn->query("SELECT * FROM nguoi_dung where gioi_tinh = $idcategory");
} else {
    $result = $conn->query("SELECT * FROM nguoi_dung");
} 
$category = $conn->query("SELECT * FROM nguoi_dung");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CO'House</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../home/home.css">
    <link rel="stylesheet" href="../home/home_list.css">
    <link rel="stylesheet" href="../home/main.css">
    <link rel="stylesheet" href="../home/base.css">
    <link rel="stylesheet" href="../search-home/sea.css">
    <link rel="stylesheet" href="./detail.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css">
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
                        <li class="nav-item_home ">
                            <a class="nav-link " href="../home/home.php">
                            <i class="fa-solid fa-bed "></i>

                                <Button class="home">
                                    Cung cấp chỗ ở
                                </Button>
                            </a>
                        </li>   
                        <li class="nav-item_home">
                            <a class="nav-link " href="../message_user/index.php">
                            <i class="fa-solid fa-comment "></i>

                                <Button class="home">
                                    Tin nhắn
                                </Button>
                            </a>
                        </li>
                      
                        <div class="account" style=" margin-top: -27px !important;">
                    
                    <?php disLogin(1)?>
              </div>
                      
                     
                    </ul>
            
        </div>
        <div class="search-menu">
                <div class="search-list">
                    <div class="search_filter">
                        <div class="search">
                        <form action="./search.php" class="d-flex ">
                            <input class="form-control me-2" name="search" type="search" placeholder="Nhập địa chỉ" aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">
                            <i class="fa-solid fa-search se"></i>
                            </button>
                        </form>
                        </div>
                    </div>
                </div>
                <div class="search-tool">
                        <div class="age-selection">
                            <div class="age_u">
                                        <label for="min-age">Tuổi tối thiểu:</label>
                                        <select id="min-age" name="min-age">
                                            <?php for ($i = 0; $i <= 60; $i++): ?>
                                                <option value="<?php echo $i; ?>"><?php echo $i; ?> tuổi</option>
                                            <?php endfor; ?>
                                        </select>

                                        <span>-</span>

                                        <label for="max-age">Tuổi tối đa:</label>
                                        <select id="max-age" name="max-age">
                                            <?php for ($i = 0; $i <= 90; $i++): ?>
                                                <option value="<?php echo $i; ?>"><?php echo $i; ?> tuổi</option>
                                            <?php endfor; ?>
                                        </select>
                                </div>

                                    <button onclick="filterUsers()" class="btn_user_age">Lọc</button>
                                    <select name="facilities" onchange="location = this.value;" class="tienghi_list">
                                            <option value="list_user.php">Lựa chọn giới tính</option>
                                            <option value="list_user.php">Tất cả</option>
                                            <option value="list_user_nam.php">Nam</option>
                                            <option value="list_user_nu.php">Nữ</option>
                                            
                                        </select>   
                                </div>
       
                        

                </div>
        </div>
    </header>
<div class="container_list_home" >
<div class="grid">
        <div class="grid__row app__content">
            
            <div class="grid__column-10">
               
                <div class="home-product">
                    <div class="grid__row ">
                    <?php 
                            if ($result->num_rows > 0) {
                                while($row = $result-> fetch_assoc()) {
                                    if(isset($row['ghichu']) && $row['ghichu'] !== ''){

                                    $ngaysinh = $row['ngaysinh'];
                                    $birthdate = new DateTime($ngaysinh);
                                    $today = new DateTime();
                                    $age = $today->diff($birthdate)->y; // Lấy số năm
                        ?>
                            <div class="grid__column-2-4 ">  
                              
                                    <div class="home-product-item"  href="details.php?id_product=<?=$row['id_xe']?>&idcategory=<?=$row['id_danhmuc']?>" class="product-item__link">
                                    <!-- <div class="home-pruduct-item__img" style="background-image: url(https://cdn1.viettelstore.vn/images/Product/ProductImage/medium/1675652850.jpeg);"></div> -->
                                         <img src="../img/avata/<?= $row['hinhanh'] ?>" class="w-100" style="    height: 200px;    border-radius: 10px;" alt="<?= $row['ten_xe']?>"/>
                                    <!-- <img src="../img/<?= $row['anh_xe'] ?>" class="w-100" alt="<?= $row['ten_xe']?>"/> -->
                                    
                                    <h2 class="home-pruduct-name fw-bold" style="font-size: 20px; height:30px;"> <?= $row['hoten'] ?> </h2>
                                    <h4 class="home-pruduct-name" style="font-size: 20px;">  <?= $row['gioitinh']?>, <?php echo $age ?> tuổi</h4>
                                    <h6 class="home-pruduct-name" style="font-size: 18px;    height: 40px;"> Ngân sách tối đa  <?= number_format($row['ngansach']) ?> VNĐ/tháng</h6>
                                    <p class="home-pruduct-name conten-us"><?= $row['ghichu'] ?></p>
                                
                                    <?php 
                                    echo'
                                    <a href="../detail/list_user.php?id='.$row["id_nd"].'" class="submit nav-link" > 
                                    <div class="sub_user">
                                    Xem thông tin
                                    </div>
                                    </a>
                                    ';
                                    ?>
                                    
                                    
                                    
                                    <!-- <a href="../Product_Detail/sanpham.php?id='.$row["id_product"].'">Mua Ngay</a> -->
                                    
                                </div>  
                             

                            </div>
                            <?php }}}  ?>
            </div>
        </div>
      </div>
      </div>
</div>
</div>

<div class="home_user" id="home_list">

    <div class="home_lis text-center" id="home_lis" >

        <div class="click_x">
            <a href="../search-home/list_user.php">

                <button id="click_x_home" class="fw-bold">
                    <i class="fa-solid fa-times "></i>              
                </button>
            </a>
        </div>
        <?php 
              if(isset($_GET['id'])) {
                global $idProduct;
                $idProduct = $_GET['id'];
                $conn = connectDB();
                $result = $conn -> query("SELECT * FROM nguoi_dung WHERE id_nd = ".$idProduct."");
                if ($result->num_rows > 0) {
                    
                  $row = $result->fetch_assoc();
                  $ngaysinh = $row['ngaysinh'];
                    $birthdate = new DateTime($ngaysinh);
                    $today = new DateTime();
                    $age = $today->diff($birthdate)->y; // Lấy số năm
                  echo '
            <div class="container_home_list">
                <div class="list_modal">
                    <div class="list_left">
                     
                      <img src="../img/avata/'.$row['hinhanh'].'" class="w-100 h-100" style="" alt=""/>

                    </div>
                    <div class="list_right">
                        <div class="primary_info">
                            <div class="list_user">
                                <div class="name">
                                    <span class="fw-bold">'.$row['hoten'].'</span>
                                </div>
                                <div class="user_info">
                                    <span> '.$age.' tuổi. '.$row['gioitinh'].'</span>
                                </div>
                                 <div class="user_info">
                                    <span>  Số điện thoại: '.$row['sdt'].'</span>
                                </div>
                                
                                '; ?>
                                <div class="user_info">
                                    <span>Ngân sách tối đa: <?= number_format($row['ngansach']) ?> VNĐ / tháng</span>
                                </div>
                                <?php echo' 
                            </div>
                        </div>
                    
                        <div class="messa_info">
                            <span style="font-size: 14px;letter-spacing: .01em;text-align: left;line-height: 1.45em; vertical-align: inherit;" >'.$row['ghichu'].'</span>
                        </div>
                        
                    </div>
                    <div class="list_footer">
                        <div class="listing_footer_buttons">
                            <div class="listing_footer_buttons_container" style="float: left;">
                                     <button class="mes" >
                                   <a href="../message_user/index.php?id_nd= '.$row['id_nd'].'" class="submit nav-link" > 
                                     <i class="fa-regular fa-envelope"></i>           
                                      Gửi tin nhắn
                                 </a>
                                </button>
                                
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        
       ';
                }
              } else {

              }
                  ?>

    </div>

</div>

    <!-- login -->
<div class="home_lgin" id="home_lgin">

    <div class="home_lg text-center" id="home_lg" >

    <div class="home_lg" id="home_lg">
        <div class="click_x">
            <button id="click_x_lg" class="fw-bold">
            <i class="fa-solid fa-times "></i>              
            </button>
        </div>
            <div class="logo_signup" style="    padding-top: 61px;">
                <img src="../img/logo.jpg" alt="" class="" style="width:60px;">
            </div>
        
    
                <h2>Đăng Nhập</h2>
                <div class="form-box">
                    <div class="form-value">
                        <form action="" name="mf" id="formLG" class="signup" method="post" onsubmit="return checkLogin()">
                            <div class="inputbox">
                                <ion-icon name="mail-outline"></ion-icon>
                                <i class="fa-solid fa-user lg home"></i>
                                <input type="text" id="valuserName" class="input_lg" name="userName" placeholder="Tên Đăng Nhập" required>

                            </div>
                            <div class="inputbox">
                                <ion-icon name="lock-closed-outline"></ion-icon>
                                <i class="fa-solid fa-lock home"></i>
                                <input type="password" id="valpassWord"  class="input_lg" name="passWord" placeholder="Mật Khẩu"  required>

                            </div>
                            <!-- <div class="forget">
                                <label for=""><input type="checkbox" name="ghinho">Ghi Nhớ Tui  <a href="#" class="fw-bold">Nhớ Mật Khẩu</a></label>

                            </div> -->
                            <div class="submit">
                                <input type="submit" name="bnt-submit" value="Đăng Nhập">
                            </div>
                        
                            <span id="disError">
                            <?php
                            if (isset($_POST['bnt-submit']) && $_POST['bnt-submit'] == 'Đăng Nhập') {
                                $user = $_POST['userName'];
                                $passWord = md5($_POST['passWord']);
                                $conn = connectDB();
                                $result = $conn->query("SELECT * FROM nguoi_dung WHERE tentaikhoan = '$user' and matkhau = '$passWord'");
                                if ($result->num_rows > 0) {
                                    $row = $result -> fetch_assoc();
                                    if ($row['disabled'] != 1) {    
                                        $_SESSION['nguoidung'] = $row;
                                        if ($_SESSION['nguoidung']['id_vaitro'] == 1) {
                                            header("location: ../Admin/");
                                        } else {
                                            header("location: ./list_user.php");
                                        }
                                    } else {
                                        echo 'Tài khoản này đã bị vô hiệu hóa. Vui lòng liên hệ với tổng đài để được hỗ trợ !';
                                    }
                                } else {
                                    echo "Tài Khoản Hoặc Mật Khẩu Không Đúng !";
                                }

                                // if(isset($_POST['ghinho']) &&($_POST['ghinho']) ){
                                //     setcookie("ten_nguoidung",$user,time()+(86400*7));
                                //     setcookie("nguoidung",$passWord,time()+(86400*7));
                                //     echo"Ghi nho!";
                                // }
                            }
                            ?>
                    </span>
                        </form>
                    </div>
            </div>

    </div>
    </div>

</div>
<footer>
    <div class="footer" style="background-image: url('https://www.lacartedescolocs.fr/assets/backgrounds/header_bg-8e48a21d4f3b4e87d988fbc77732705322506141957f1fe09e088dbde7f58ff6.png');"></div>
</footer>
<script src="../main.js"></script>
<script src="https://code.jquery.com/ui/1.14.0/jquery-ui.js"></script>

<script>
  $( function() {
    $( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: 500,
      values: [ 75, 300 ],
      slide: function( event, ui ) {
        $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
      }
    });
    $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
      " - $" + $( "#slider-range" ).slider( "values", 1 ) );
  } );
  </script>

</body>
</html>
