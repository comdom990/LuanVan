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


 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CO'House</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../home/home.css">
    <link rel="stylesheet" href="./sea.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                      
                        <li class="nav-item_home active">
                            <a class="nav-link sig" href="#">
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
    </header>
<div class="container_list">
    <div class="list_home text-center">
        <h2 style="font-size: 18px;">BẠN ĐANG TÌM NGƯỜI THUÊ NHÀ HAY BẠN CÙNG PHÒNG?</h1>
        <h2 style="font-size: 16px;">Đăng tin miễn phí trong vòng chưa đầy 5 phút:</h2>

        <form id="form__input__category" action="" method="post" enctype="multipart/form-data">        
         
            
            <div class="form__group code__product"  >
                <div class="form_icon">
                    <i class="fa-solid fa-magnifying-glass"></i>
                     <label for="" class="map">Tìm Kiếm </label>
                </div>
                <div class="form_in">
                    <!-- <div class="form_cho">
                        <label for="" class="">Bạn đang tìm kiếm chổ ở nào?</label>
                        <select name="inpSelectCategory" class="choo" id="inp__category" required>
                            <option value="">-- Chọn Loại Chổ Ở --</option>
                            
                        </select>
                    </div> -->
                    <div class="form_ns">
                        <label for="" class="">Ngân sách tối đa: </label>
                        <input type="text" id="valns" class="dt" name="ns" value=""placeholder="VD: 1tr600"  />
                    </div>

                </div>
            </div>

            <div class="form__group code__product"  >
                <div class="form_icon" style="margin-left: -1px;">
                     <i class="fa-solid fa-user"></i>
                     <label for="" class="map">Thông Tin Cá Nhân </label>
                </div>
                <div class="form_in">
                    <div class="form_ht"  style="     margin-left: 183px;padding-bottom: 10px; ">
                            <label for="" class="">Họ và Tên: </label>
                            <input type="text" id="valdt"  class="ht" name="ht" value="<?php echo $row['hoten']?>"placeholder="Nhập Họ và Tên" disabled />
                            
                        </div>
                
                    <div class="form_gt"  style="     margin-left: 196px;padding-bottom: 10px; ">
                        <label for="" class="">Giới tính: </label>
                        <input type="text" id="valdt"  class="gt" name="gt" value="<?php echo $row['gioitinh']?>"placeholder="Nhập Giới tính"  disabled/>
                        
                    </div>
                    <div class="form_ns"  style="     margin-left: 186px; ">
                        <label for="" class="">Ngày sinh: </label>
                        <input type="date" id="valdt"  class="ns" name="ngaysinh" value="<?php echo $row['ngaysinh']?>"placeholder="Nhập Giới tính"  disabled/>
                        
                    </div>
                  
                </div>
            </div>
       
            <div class="form__group code__product"  >
                <div class="form_icon">
                     <i class="fa-solid fa-phone"></i>
                     <label for="" class="map">Liên Lạc </label>
                </div>
                <div class="form_in">
                   <div class="form_em"  style="     margin-left: 218px; ">
                        <label for="" class="">Email: </label>
                        <input type="text" id="valdt"  class="ll" name="email" value="<?php echo $row['email']?>"placeholder="Nhập Email"  disabled/>
                        
                    </div>
                    <div class="form_lh"  style=" padding-top: 10px; margin-left: 165px;  ">
                        <label for="" class="">Số điện thoại: </label>
                        <input type="text" id="valdt"  class="sdt" name="sdt" value="<?php echo $row['sdt']?>"placeholder="Nhập số điện thoại"  disabled/>
                        
                    </div>
                </div>
            </div>

            <div class="form__group code__product"  >
                <div class="form_icon">
                     <i class="fa-solid fa-tablet"></i>
                     <label for="" class="map">Ghi Chú </label>
                </div>
                <div class="form_in">
                  
                    <div class="form_lh"  style=" padding-top: 10px;  ">
                    <textarea rows="6" cols="70" name="gc" class="dt" id="product_desc" placeholder="Hãy giới thiệu bản thân..."></textarea>

                    </div>
                </div>
            </div>


            
            <!-- end img__category -->
            
            <div class="bnt_category">
            <button id="bnt_add" class="bnt_add" name="bnt_add" value="Thêm Mới">Thêm mới</button>
            
            </div>
            <!-- end bnt_category -->
         </form>
         <?php 
                                                    $id_tailieu='';
                                                // insert data
                                                $conn = connectDB();
                                                if (isset($_POST['bnt_add']) and $_POST['bnt_add'] == 'Thêm Mới') {
                                                    $ns = $_POST['ns']; // nameProduct
                                                    $ht = $_POST['ht']; // price product
                                                    $gt = $_POST['gt'];
                                                    $ns = $_POST['ns'];
                                                    $email = $_POST['email'];
                                                    $sdt = $_POST['sdt'];
                                                    $gc = $_POST['gc'];
                                                   
                                                    $sql = "UPDATE nguoi_dung SET ghichu = '$gc',ngansach = '$ns'  WHERE nguoi_dung.id_nd = ".$idCustomer."; ";
                                                    if ($conn->query($sql)) {
                                                        echo '<span class="notification__success">Bạn Đã Thêm Thành Công !</span>';
                                                    } else {
                                                        echo '<span class="notification__fail">Không Thể Thêm Sản Phẩm Này. Vui lòng thử lại !</span>';
                                                    }
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
                                            header("location: ./sea_home.php");
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

</body>
</html>
<?php }  else {
    echo "<script>alert('Bạn hãy đăng nhập để vào hệ thống!'); window.location.href = '../index.php';</script>";
}
?>
