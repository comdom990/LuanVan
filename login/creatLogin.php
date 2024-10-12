<?php 
require_once('../ConnectDB/connectDB.php');
require_once('../Library/library.php');
ob_start();
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CO'House</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../home/home.css">
    <link rel="stylesheet" href="./creat.css">
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
                        <img src="../img/logo.jpg" alt="" class="logo_header">
                        </a>
                    </div>
                    <ul class="nav navi_home">
                      
                        <!-- <li class="nav-item_home">
                            <a class="nav-link sig" href="#">
                            <i class="fa-solid fa-search "></i>

                                <Button class="home">
                                    Tìm kiếm chỗ ở
                                </Button>
                            </a>
                        </li>
                        <li class="nav-item_home">
                            <a class="nav-link " href="#">
                            <i class="fa-solid fa-bed "></i>

                                <Button class="home">
                                    Cung cấp chỗ ở
                                </Button>
                            </a>
                        </li> -->
                      
                        <li class="nav-item_home">
                            <a class="nav-link " href="#">
                            <i class="fa-solid fa-sign-in "></i>

                                <Button class="home" id="log">
                                    Đăng nhập
                                </Button></a>
                        </li>
                      
                     
                    </ul>
            
        </div>
    </header>
<div class="container_list">
    <div class="form-value-dk text-center">
                <form action="" name="mf" id="formLG" method="post" onsubmit="return checkLogin()" enctype="multipart/form-data">
                    <h2 >Đăng Ký</h2>
                    <div class="inputbox-dk">
                        <ion-icon name="person-outline"></ion-icon>
                        <i class="ico fa-solid fa-user "></i>
                        <input type="text" id="valuserName" class="dktk" name="userName" placeholder="Nhập tên đăng nhập"   required>
                    </div>
                    <div class="inputbox-dk">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <i class="ico fa-solid fa-lock dk"></i>
                        <input type="password" id="valpassWord" class="dktk" name="passWord" placeholder="Nhập mật Khẩu"  required>
                    </div>
                                   
                    <div class="inputbox-dk">
                      <ion-icon name="mail-outline"></ion-icon>
                      <i class="ico fa-solid fa-envelope"></i>
                      <input type="email" id="valemail" class="dktk" name="email" placeholder="Email" required>
                   </div>
                   <div class="inputbox-dk">
                      <ion-icon name="mail-outline"></ion-icon>
                      <i class="ico fa-solid fa-user "></i>
                      <input type="text" id="valHovaTen" class="dktk" name="hovaten" placeholder="Nhập họ và tên" required>
                   </div>
                   <div class="inputbox-dk">
                      <ion-icon name="mail-outline"></ion-icon>
                      <i class="ico fa-solid fa-calendar-days"></i>
                      <input type="date" id="valNS" class="dktk" name="ngaysinh" placeholder="Ngay sinh" required>
                   </div>
                   <div class="inputbox-dk" style="    margin-left: -4px;">
                      <ion-icon name="mail-outline"></ion-icon>
                      <i class="ico fa-solid fa-venus-mars"></i>
                      <div class="check_gt">

                          <span>Nam</span>
                          <input type="checkbox" id="valNam" class="cb" name="gioitinh" placeholder="Nhập giới tính" value="Nam" >
                        </div>
                      <div class="check_gt">

                      <span>Nữ</span>
                      <input type="checkbox" id="valNu" class="cb" name="gioitinh" placeholder="Nhập giới tính" value="Nữ" >
                      </div>
                   </div>

                   <div class="inputbox-dk">
                      <ion-icon name="mail-outline"></ion-icon>
                      <i class="ico fa-solid fa-phone"></i>
                      <input type="text" id="valSDT" class="dktk" name="sdt" placeholder="Nhập số điện thoại" required>
                   </div>

                   <div class="inputbox-dk" style="    margin-left: 4px;">
                      <ion-icon name="mail-outline"></ion-icon>
                      <i class="ico fa-solid fa-map-marker"></i>
                      <input type="text" id="valDC" class="dktk" name="diachi" placeholder="Nhập địa chỉ" required>
                   </div>
                   <div class="inputbox-dk">
                      <i class="ico fa-solid fa-camera"></i>
                      <input type="file" name="upFile" id="inp__img" class="valInp" accept=".jpg, .jpeg, .png, .jfif" required/>

                      
                   </div>
                   <!-- <div class="inputbox-dk" style="">
                      <ion-icon name="mail-outline"></ion-icon>
                      <i class="ico fa-solid fa-user-plus"></i>
                      <label for="">Thêm hình đại diện</label> <br>
                      <input style="" type="file" class="avt" name="upFile" id="inp__img"  class="valInp" accept=".jpg, .jpeg, .png, .jfif" required/>

                   </div> -->
                   <!-- <div class="register" style="    padding-top: 40px;">
                        <p>Đã có tài khoản <a href="./index.php">Đăng Nhập</a></p>
                    </div> -->
                    <div class="submit" style="    padding-bottom: 40px;">
                         <input type="submit" name="bnt-submit" value="Đăng Ký">
                    </div>
                    <span id="disError">
                    <?php
                        if (isset($_POST['bnt-submit']) && $_POST['bnt-submit'] == 'Đăng Ký') {
                            $user = $_POST['userName'];
                            $passWord = $_POST['passWord'];
                            $email = $_POST['email'];
                            $hovaten = $_POST['hovaten'];
                            $ngaysinh = $_POST['ngaysinh'];
                            $gioitinh = $_POST['gioitinh'];
                            $sdt = $_POST['sdt'];
                            $diachi = $_POST['diachi'];
                                // img product 
                                $nameIMG = $_FILES['upFile']['name'];
                                $tmp_name = $_FILES['upFile']['tmp_name'];
                                move_uploaded_file($tmp_name, "img/avata/". $nameIMG);
                            // Validate input
                            if (empty($user) || empty($passWord) || empty($email) || empty($hovaten)) {
                                echo "<span style='color: red;'>Vui lòng điền đầy đủ thông tin!</span>";
                                return;
                            }

                         
                                  
                            // Connect to the database
                            $conn = connectDB();

                            // Check if username or email already exists
                            $sql = "SELECT * FROM nguoi_dung WHERE tentaikhoan = '$user' OR email = '$email'";
                            $result = $conn->query($sql);

                            if ($result && $result->num_rows > 0) {
                                echo "<span style='color: red;'>Tên Đăng Nhập Hoặc Email Đã Tồn Tại!</span>";
                            } else {
                                // Insert new user
                                $sql = "INSERT INTO nguoi_dung (hoten, ngaysinh, gioitinh, sdt, tentaikhoan, matkhau, email, dia_chi,hinhanh) VALUES ('".$hovaten."', '".$ngaysinh."', '".$gioitinh."', '".$sdt."', '".$user."', '".md5($passWord)."', '".$email."', '".$diachi."', '".$nameIMG."')";
                                
                                if ($conn->query($sql) === TRUE) {
                                    echo "<span style='color: #56fb41;'>Đăng Ký Tài Khoản Thành Công!</span>";
                                    echo '<script>setTimeout(function() { window.location=\'creatLogin.php\'; }, 2000);</script>';
                                } else {
                                    echo "<span style='color: red;'>Đã xảy ra lỗi khi đăng ký tài khoản!</span>";
                                }
                            }

                            $conn->close(); // Close the database connection
                        }
                        ?>
                </span>
                </form>
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
                                            header("location: ../index.php");
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