<?php 
require_once('./ConnectDB/connectDB.php');
require_once('./Library/library.php');
ob_start();
session_start();
$conn = connectDB();
$limit = 8; // Số bài đăng ban đầu
$idcategory = '';
if(isset($_GET['idcategory'])){
    $idcategory = $_GET['idcategory'];
    $result = $conn->query("SELECT  p.id_pt, nd.hoten,co.dia_chi,bd.mo_ta,bdp.gia,ha.anh_dai_dien,ha.anh,nd.id_nd FROM cho_o co inner join nguoi_dung nd inner join bai_dang bd inner join bai_dang_phong bdp inner join phong p INNER join hinh_anh ha
     ON  co.id_bd = bd.id_bd and co.id_nd = nd.id_nd and nd.id_nd = bd.id_nd and bdp.id_bd = bd.id_bd and p.id_pt = ha.id_pt and p.id_cho = co.id_cho WHERE ha.anh_dai_dien = 1 AND co.id_loai = $idcategory LIMIT $limit");
} else {
    $result = $conn->query("SELECT  p.id_pt, nd.hoten,co.dia_chi,bd.mo_ta,bdp.gia,ha.anh_dai_dien,ha.anh,nd.id_nd FROM cho_o co inner join nguoi_dung nd inner join bai_dang bd inner join bai_dang_phong bdp inner join phong p INNER join hinh_anh ha
     ON  co.id_bd = bd.id_bd and co.id_nd = nd.id_nd and nd.id_nd = bd.id_nd and bdp.id_bd = bd.id_bd and p.id_pt = ha.id_pt and p.id_cho = co.id_cho WHERE ha.anh_dai_dien = 1 LIMIT $limit; ");
} 
$category = $conn->query("SELECT * FROM loai");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CO'House</title>
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/res_index.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="header " style="background-image: url('https://www.lacartedescolocs.fr/assets/backgrounds/aquarelle-fa461c75c279366d8ded034c08181d87f4319cae8f99c44085748b828499fa21.jpg');background-position: center; background-size: cover;">
    <div class="container">
        <div class="home_search_table">
            <div class="home_header col-md-8 col-lg-10">
                    <div class="logo">
                        <a href="./index.php">

                            <img src="./img/lone.png" alt="" class="logo_header">
                        </a>

                    </div>
                    <!-- lg lớn hơn or bằng 992 md nhỏ hơn 992 -->
                  <div class="account ">
                    
                        <?php disLogin(0)?>
                  </div>
                
            </div>
          
            <div class="home_search mt-3">
                <div class="home_search_wrap">
                        <div class="wrapper">
                                    <ul class="nav nav-underline justify-content-center">
                                              
                                                <li class="nav-item ">
                                                    <a class="nav-link" href="./home/list_home.php">Tôi đang tìm chổ ở</a>
                                                </li>
                                                <li class="nav-item-r">
                                                    <a class="nav-link" href="./search-home/list_user.php">Tôi cung cấp chổ ở</a>
                                                </li>
                                               
                                    </ul>
                        </div>
                        <!-- <nav class="navbar  text-center">
                                    <div class="container-fluid">
                                        <form class="d-flex as" role="search" method="GET" action="./home/list_home_map2.php">
                                        <input class="form-control me-2" type="search" name ="address"placeholder="Bạn đang tìm chổ ở ở đâu?" aria-label="Search">
                                        <button class="btn btn-outline-success as" type="submit">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                        </button>
                                        </form>
                                    </div>
                        </nav> -->
                       
                        <nav class="navbar text-center mt-3">
                            <div class="container-fluid ">
                                <form class="d-flex as" role="search" method="GET" action="./home/search_map_2.php">
                                    <input class="form-control me-2 " type="search" name="address" placeholder="Bạn đang tìm chỗ ở ở đâu?" aria-label="Search" required>
                                    <button class="btn btn-outline-success as" type="submit">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </form>
                            </div>
                        </nav>

                        <ul class="nav nav-underline justify-content-center mt-3">
                                              
                                                <li class="nav-item ">
                                                    <a class="nav-link" href="./home/list_home_map4.php">Tìm kiếm theo vị trí của bạn</a>
                                                </li>
                                               
                                               
                                    </ul>
                   
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="home_about">
            <div class="container px-4 text-center ">
                    <div class="row gx-5">
                        <div class="col">
                        <div class="p-3">
                            <h2 class="home_title">GIÀNH CHO MỌI NGƯỜI</h2>
                            <div class="home_content">
                                <font style="vertical-align: inherit;">Đầu tiên, nền tảng này hoàn toàn miễn phí, giúp người dùng tiết kiệm chi phí khi tìm kiếm và đăng tin. Giao diện thân thiện và dễ sử dụng, cùng với khả năng tìm kiếm linh hoạt theo địa điểm, giá cả và tiện ích, mang lại trải nghiệm thuận tiện. </font>
                            </div>
                        </div>
                        </div>
                        <div class="col">
                        <div class="p-3">
                        <h2 class="home_title">TIỆN LỢI, AN TOÀN VÀ MIỄN PHÍ</h2>
                            <div class="home_content">
                                <font style="vertical-align: inherit;">Không có hoa hồng gián tiếp hoặc tùy ý, dịch vụ hoàn toàn miễn phí cho tất cả mọi người. Các danh sách được đăng sẽ được kiểm tra thủ công để đảm bảo an toàn cho giao dịch của bạn. Bản đồ tương tác cùng với định vị địa lý giúp bạn tối ưu hóa quá trình tìm kiếm, tiết kiệm thời gian trong các thủ tục.</font>
                            </div>
                        </div>
                        </div>
                    </div>
            </div>
    </div>

    <div class="home_publish text-center">
        <h3 >BẠN CÓ CHỖ Ở SẴN KHÔNG?</h3>
        <a href="./home/home.php">
            <button class="publish">
            <i class="fa-solid fa-plus "></i>
            <font style="vertical-align: inherit;">Nhấp vào đây cung cấp nhà ở của bạn</font>
            </button>
        </a>
    </div>

    <main class="main">
        <div class="home_rank_content">
            <div class="home_rank">
                <div class="home_rank_container">
                    <h3 style="    font-size: 18px;margin-top: 16px;">
                         <font style="vertical-align: inherit;">BẠN ĐANG TÌM KIẾM MỘT NGÔI NHÀ? CÁC KHU VỰC CHÍNH CỦA CHÚNG TÔI:</font>
                    </h3>
                    <div class="home_rank_list">
                            <ul class="nav nav-tabs fs-4">
                                    <li class="nav-item" style="width:19%;margin-right: 4px;">
                                        <a class="nav-link " aria-current="page" href="./index.php">Các Loại</a>
                                    </li>
                                    <?php 
                                if ($category->num_rows > 0) {
                                    while($row = $category-> fetch_assoc()) {
                        ?>
                               <li class="nav-item " style="width:19%;margin-right: 4px;">
                            <a href="./index.php?idcategory=<?=$row['id_loai']?>" class="nav-link"><?= $row['ten_loai']?></a>
                        </li>
                        <?php }} ?>
                            </ul>
                           
                       

                                    <div class="container text-center">
                                        <div class="row row-cols-2 row-cols-lg-4 col-lg-14 col-md-14 g-2 g-lg-3" id="posts-container">
                                        <?php 
                                     
             
                                                    if ($result->num_rows > 0) {
                                                        while($row = $result-> fetch_assoc()) {
                                                            // if(isset($row['nhom']) == 1){
                                                ?>
                                            <div class="col">
                                                <div class="p-3">
                                                        <div class="hot_city">
                                                                <img src="./img/<?= $row['anh'] ?>" alt="" class="img_hou w-100" style="    height: 150px;">
                                                            <div class="title_hou">
                                                                <h3 class="andress" style="    font-size: 12px;"><?= $row['dia_chi'] ?></h3>
                                                                <p class="sl">Giá tiền:<?= number_format($row['gia'])  ?> VNĐ/tháng</p>
                                                            </div>
                                                            </div>
                                                        </div>
                                                        <?php 
                                                        echo'
                                                        <a href="./detail/list_home.php?id='.$row["id_pt"].'" class="submit nav-link" > 
                                                        <div class="sub_user">
                                                        Xem 
                                                        </div>
                                                        </a>
                                                        ';
                                                        ?>
                                                </div>
                            <?php }} 
                         ?>
                                            

                                        </div>
                                        <button id="load-more" class="btn btn-primary">Xem thêm</button>
                                    </div>



                            
                    </div>
                </div>
            </div>
        </div>



    </main>

    <script>
let offset = <?= $limit ?>; // Số bài đăng đã hiển thị
const limit = 10; // Số bài đăng sẽ tải thêm

document.getElementById('load-more').addEventListener('click', function() {
    fetch(`load_more.php?offset=${offset}&limit=${limit}`)
        .then(response => response.text())
        .then(data => {
            if (data.trim()) {
                document.getElementById('posts-container').insertAdjacentHTML('beforeend', data);
                offset += limit; // Cập nhật offset
            } else {
                // Nếu không còn bài đăng nào, ẩn nút "Xem thêm"
                document.getElementById('load-more').style.display = 'none';
            }
        })
        .catch(error => console.error('Error:', error));
});
</script>

<div class="home_bg" id="home_bg">
   
    <div class="home_signup" id="home_sign">
        <div class="click_x">
            <button id="click_x" class="fw-bold">
            <i class="fa-solid fa-times "></i>
                
            </button>
        </div>
            <div class="logo_signup">
                <img src="./img/logo.jpg" alt="" class="logo_header">
            </div>
            <div class="home_signup_cat">
                <p>Tận dụng tất cả các tính năng của trang web ngay bây giờ bằng cách tạo tài khoản miễn phí của bạn:</p>
            </div>
            <div class="user">
                <a href="./login/creatLogin.php">
                <button class="publish_home">
                <i class="fa-solid fa-user "></i>
                <font style="vertical-align: inherit;">Tôi đang tìm chổ ở</font>
                </button>
                </a>
            </div>  
                <div class="home" style="padding-top: 10px;">
                    <a href="./login/creatLogin.php" >
                        <button class="publish_home">
                            <i class="fa-solid fa-home "></i>
                            <font style="vertical-align: inherit;">Tôi cung cấp chổ ở</font>
                        </button>
                    </a>
                </div>
    </div>

</div>

<div class="home_lgin" id="home_lgin">

    <div class="home_lg text-center" id="home_lg" >
    
        <div class="home_lg" id="home_lg">
            <div class="click_x">
                <button id="click_x_lg" class="fw-bold">
                <i class="fa-solid fa-times "></i>              
                </button>
            </div>
                <div class="logo_signup" style="    padding-top: 61px;">
                    <img src="./img/logo.jpg" alt="" class="" style="width:60px;">
                </div>
            
        
                    <h2>Đăng Nhập</h2>
                    <div class="form-box">
                        <div class="form-value">
                            <form action="" name="mf" id="formLG" class="signup" method="post" onsubmit="return checkLogin()">
                                <div class="inputbox">
                                    <ion-icon name="mail-outline"></ion-icon>
                                    <i class="fa-solid fa-user lg"></i>
                                    <input type="text" id="valuserName" class="input_lg" name="userName" placeholder="Tên Đăng Nhập" required>

                                </div>
                                <div class="inputbox">
                                    <ion-icon name="lock-closed-outline"></ion-icon>
                                    <i class="fa-solid fa-lock dn"></i>
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
                                        $userId = $_SESSION['nguoidung']['id_nd']; // Hoặc cách truy cập khác tùy vào cấu trúc session

                                        // Cập nhật trạng thái người dùng
                                        $stmt = $conn->query("UPDATE nguoi_dung SET status = 'Truy cập' WHERE id_nd = ".$userId." ");
                                        
                                        // Kiểm tra nếu câu lệnh chuẩn bị thành công
                                        if ($stmt) {
                                            header("Refresh:1");
                                            echo '<span class="notification__success" style="color : #42c174;">Hiện Thành Công !</span>';
                                          
                                        } else {
                                            echo '<span class="notification__fail">Hiện Thất Bại !</span>';
                                        }




                                        if ($_SESSION['nguoidung']['id_vaitro'] == 1) {
                                            header("location: ../Admin/");
                                        } else {
                                            header("location: ./index.php");
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
    <div class="footer" style="background-image: url('https://www.lacartedescolocs.fr/assets/backgrounds/header_bg-8e48a21d4f3b4e87d988fbc77732705322506141957f1fe09e088dbde7f58ff6.png');">
       
    </div>
</footer>

<script src="./main.js"></script>
</body>
</html>