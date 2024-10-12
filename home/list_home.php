<?php 
require_once('../ConnectDB/connectDB.php');
require_once('../Library/library.php');
ob_start();
session_start();

$conn = connectDB();

$records_per_page = 10;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $records_per_page;

// Lấy tổng số bản ghi
$sql_total = "SELECT COUNT(*) AS total FROM bai_dang";
$result_total = $conn->query($sql_total);
$row_total = $result_total->fetch_assoc();
$total_records = $row_total['total'];
$total_pages = ceil($total_records / $records_per_page);

$idcategory = '';
$idphuong = '';
if (isset($_GET['idcategory'])) {
    $idcategory = (int)$_GET['idcategory'];
    $result = $conn->query("SELECT  co.ten_co,bd.id_bd,p.id_pt, nd.hoten, co.dia_chi, bd.mo_ta, bdp.gia, ha.anh_dai_dien, ha.anh, nd.id_nd 
        FROM cho_o co 
        INNER JOIN nguoi_dung nd 
        INNER JOIN bai_dang bd 
        INNER JOIN bai_dang_phong bdp 
        INNER JOIN phong p 
        INNER JOIN hinh_anh ha 
        ON co.id_bd = bd.id_bd 
        AND co.id_nd = nd.id_nd 
        AND nd.id_nd = bd.id_nd 
        AND bdp.id_bd = bd.id_bd 
        AND p.id_pt = ha.id_pt 
        AND p.id_cho = co.id_cho  
        WHERE ha.anh_dai_dien = 1 
        AND co.id_loai = $idcategory");
} elseif (isset($_GET['idphuong'])) {
    $idphuong = (int)$_GET['idphuong'];
    $result = $conn->query("SELECT  co.ten_co,bd.id_bd,ph.id_phuong,p.id_pt, nd.hoten, co.dia_chi, bd.mo_ta, bdp.gia, ha.anh_dai_dien, ha.anh, nd.id_nd 
        FROM cho_o co 
        INNER JOIN nguoi_dung nd 
        INNER JOIN bai_dang bd 
        INNER JOIN bai_dang_phong bdp 
        INNER JOIN phong p 
        INNER JOIN hinh_anh ha 
        INNER JOIN phuong ph
        ON co.id_bd = bd.id_bd 
        AND co.id_phuong = ph.id_phuong
        AND co.id_nd = nd.id_nd 
        AND nd.id_nd = bd.id_nd 
        AND bdp.id_bd = bd.id_bd 
        AND p.id_pt = ha.id_pt 
        AND p.id_cho = co.id_cho  
        WHERE ha.anh_dai_dien = 1 
        AND ph.id_phuong = $idphuong");
} 

else {
    $result = $conn->query("SELECT co.ten_co,bd.id_bd, p.id_pt, nd.hoten, co.dia_chi, bd.mo_ta, bdp.gia, ha.anh_dai_dien, ha.anh, nd.id_nd 
    FROM cho_o co INNER JOIN nguoi_dung nd INNER JOIN bai_dang bd INNER JOIN bai_dang_phong bdp INNER JOIN phong p INNER JOIN hinh_anh ha 
    ON co.id_bd = bd.id_bd AND co.id_nd = nd.id_nd AND nd.id_nd = bd.id_nd AND bdp.id_bd = bd.id_bd AND p.id_pt = ha.id_pt AND p.id_cho = co.id_cho
     WHERE ha.anh_dai_dien = 1 AND bd.trang_thai = 1 ORDER BY bd.id_bd DESC
        LIMIT $start_from, $records_per_page;");
}

$category = $conn->query("SELECT * FROM loai");
$phuong = $conn->query("SELECT * FROM phuong");

// Kiểm tra nếu người dùng đã đăng nhập
if (isset($_SESSION['nguoidung'])) {
    $idCustomer = $_SESSION['nguoidung']['id_nd']; // Giả sử id được lưu trong session
    // Đếm số bình luận
    $tb = "SELECT count(bl.id_pt) as soluong FROM tt_binh_luan bl WHERE bl.id_nd = $idCustomer;";
    $resulttb = mysqli_query($conn, $tb);
    $rowtb = mysqli_fetch_array($resulttb);
    $tongtb = $rowtb['soluong'];
} else {
    $tongtb = 0; // Nếu chưa đăng nhập, số bình luận là 0
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CO'House</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="./home.css">
    <link rel="stylesheet" href="./home_list.css">
    <link rel="stylesheet" href="./main.css">
    <link rel="stylesheet" href="./base.css">
    <link rel="stylesheet" href="./index_respon_home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css">
<!-- map-->

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<style>
    #map {
      height: 500px;
      width: 100%;
    }
 
  </style>
</head>
<body>
    <header>
        
        <div class="header_main" style="background-image: url('https://www.lacartedescolocs.fr/assets/backgrounds/header_bg-8e48a21d4f3b4e87d988fbc77732705322506141957f1fe09e088dbde7f58ff6.png');">
            
            <div class="logo_home col-md-2">
                <a href="../index.php">
                    <img src="../img/lone.png" alt="" class="logo_header">
                    </a>

            </div>
            <nav class="navbar navbar-expand-lg navbar-light ">
                <div class="container-fluid menu_header_ma">
                    <div class="btn_s_r">

                        <button class="navbar-toggler menu_list" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>
                        <div class="collapse navbar-collapse navbar_haeder justify-content-end" id="navbarNav">
                            <ul class="nav navi_home col-md-14 col-lg-14 navbar-nav">
                                
                                    <li class="nav-item_home  ">
                                        <a class="nav-link sig" href="../search-home/sea_home.php">
                                        <i class="fa-solid fa-search "></i>

                                            <Button class="home">
                                                Tìm kiếm chỗ ở
                                            </Button>
                                        </a>
                                    </li>
                            
                                
                                
                                    
                                    <li class="nav-item_home   ">
                                        <a class="nav-link " href="../home/home.php">
                                        <i class="fa-solid fa-bed "></i>

                                            <Button class="home">
                                                Cung cấp chỗ ở
                                            </Button>
                                        </a>
                                    </li>
                                    <li class="nav-item_home  ">
                                        <a class="nav-link " href="../message_user/index.php">
                                        <i class="fa-solid fa-comment "></i>

                                            <Button class="home">
                                                Tin nhắn
                                            </Button>
                                        </a>
                                    </li>
                                    <div class="account"style="    margin-top: -27px !important;">
                                
                                   <?php disLogin(1)?>
                                      </div>
                       
                             </ul>
            
                         </div>
                         </div>
                    </nav>
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
          <div class="navbar navbar-expand-lg navbar-light btn_tool">

                <div class="btn_s_r">

                        <button class="navbar-toggler menu_list" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>   
            <div class="collapse navbar-collapse navbar_ser justify-content-end" id="navbarNav">
                
                <div class="search-tool ">
                    <div class="dropdown2">
                            <button class="dropdown2-button" onclick="toggleDropdown2()">Chọn Theo Phường</button>
                            <div class="dropdown2-content" id="dropdown2Menu">
                                <a class="a-list" href="./list_home.php">Tất Cả</a>
                                <?php 
                                    if ($phuong->num_rows > 0) {
                                        while($row = $phuong->fetch_assoc()) {
                                ?>
                                <a class="a-list" href="./list_home.php?idphuong=<?=$row['id_phuong']?>"><?= $row['ten_phuong']?></a>
                                <?php }} ?>
                            </div>
                            
                        </div>
                   <div class="dropdown">
                        <button class="dropdown-button" onclick="toggleDropdown()">Chọn Loại Chỗ Ở</button>
                        <div class="dropdown-content" id="dropdownMenu">
                            <a class="a-list" href="./list_home.php">Tất Cả Loại Chổ Ở</a>
                            <?php 
                                if ($category->num_rows > 0) {
                                    while($row = $category->fetch_assoc()) {
                            ?>
                            <a class="a-list" href="./list_home.php?idcategory=<?=$row['id_loai']?>"><?= $row['ten_loai']?></a>
                            <?php }} ?>
                        </div>
                        
                    </div>
                    <!-- <ul class="category-list"> 
                        
                        <li class="category-item ">
                            <a href="./list_home.php" class="category-item__link">Sắp xếp giá</a>
                        </li>
                       
                        <li class="category-item ">
                            <a href="./list_home_asc.php" class="category-item__link">Từ thấp đến cao</a>
                            <a href="./list_home_desc.php" class="category-item__link">Từ cao đến thấp</a>
                        </li>

                    </ul> -->
                    <select name="facilities" onchange="location = this.value;" class="tienghi_list">
                        <option value="list_home.php">Sắp xếp giá</option>
                        <option value="list_home_asc.php">Từ thấp đến cao</option>
                        <option value="list_home_desc.php">Từ cao đến thấp</option>
                        
                    </select>   
                    <select name="facilities" onchange="location = this.value;" class="tienghi_list">
                        <option value="list_home.php">Chọn tiện nghi</option>
                        <option value="list_home.php">Tất cả</option>
                        <option value="wifi.php">Wifi</option>
                        <option value="maylanh.php">Máy lạnh</option>
                        <option value="bancong.php">Ban công</option>
                        <option value="maygiat.php">Máy giặt</option>
                        <option value="noithat.php">Có nội thất</option>
                    </select>                    
                   
                    <a href="./list_home_love.php">

                        <button class="love_btn">
                            <i class="fa-regular fa-heart oa"></i>
                            <span>Lựa chọn yêu thích</span>
                            <?php echo $tongtb; ?>
                        </button>
                    </a>
                    
                    <a href="./list_home_map3.php">

                            <button class="love_btn" id="map_cl">
                            <i class="fa-solid fa-map "></i>              
                                <span>Bản đồ</span>
                            </button>
                    </a>
                </div>
         </div>
    </div>
</div>
</header>
<div class="container_list_home" >
    <div class="grid">
        <div class="grid__row app__content">
           
            <div class="grid__column-10">
               
                <div class="home-product">
                    <!-- <div class="row" id="btn_compare" style="display: none;">
                             <div class="col-sm-12">

                                 <form action="compare.php" method="post" >
                                     <input type="hidden" id="card_one" name="card_one"/>        
                                     <input type="hidden" id="card_two" name="card_two"/>     
                                     <input type="submit" value="Compare Product" class="btn btn-success" style="float: right;">   
                                    </form>
                                </div>           
                    </div> -->


                    <div class="grid__row ">
                        <?php 
                            if ($result->num_rows > 0) {
                                while($row = $result-> fetch_assoc()) {
                                    // if(isset($row['nhom']) == 1){
                          ?>
                            <div class="grid__column-2-4 ">  

                                    <div class="home-product-item card compare_card<?= $row['id_bd'] ?>"  href="../detail/list_home.php?id_product=<?=$row['id_pt']?>&idcategory=<?=$row['id_loai']?>" class="product-item__link">
                                    <!-- <div class="home-pruduct-item__img" style="background-image: url(https://cdn1.viettelstore.vn/images/Product/ProductImage/medium/1675652850.jpeg);"></div> -->
                                        <img src="../img/<?= $row['anh'] ?>" class="w-100 card-img-top" style="    height: 170px;" alt="<?= $row['ten_pt']?>"/>
                                    <!-- <img src="https://images.lacartedescolocs.fr/tipis-listing-pictures/listing-2bca74d7e4081a6e80283ae0b6b7b592/2594345/medium.jpg" class="w-100" alt="<?= $row['ten_xe']?>"/> -->
                                    
                                    <h2 class="home-pruduct-item__name fw-bold"> <?= $row['ten_co'] ?></h2>
                                    <h4 class="home-pruduct-item__name">Địa chỉ: <?= $row['dia_chi'] ?> </h4>
                                    <p class="home-pruduct-item__name"><?= $row['mo_ta'] ?></p>
                                    <div class="home-pruduct-item__price">
                                        <span class="home-pruduct-item__price-mới"><span class="fw-bold" style="color: #000; font-size: 20px;"><?= number_format($row['gia']) ?></span> /tháng </span>   
                                        
                                    </div> 
                                    <!-- <button class="submit nav-link sub_user compare" rel="<?= $row['id_bd'] ?>">So sánh</button> -->
                                    
                                    <?php 
                                        echo'
                                            <form method="POST" action="">
                                        <button class="love_cl3" type="submit" name="bnt_add" value=" '.$row['id_bd'].' ">

                                                <div class="sub_user">
                                                Xem thông tin
                                                </div>
                                          </button>
                                           <input type="hidden" name="id_pt" value="'.$row["id_pt"].'">
                                          </form>
                                    ';
                                    ?>
                                  
                                    
                                    <!-- <a href="../Product_Detail/sanpham.php?id='.$row["id_product"].'">Mua Ngay</a> -->
                                    
                                     </div>  

                            </div>
                            <?php }} 
                        // }
                         ?>
              
                        <?php
                            // Kết nối cơ sở dữ liệu
                            $conn = connectDB();

                            // Kiểm tra nếu nút đã được nhấn
                            if (isset($_POST['bnt_add'])) {
                                $id_bd = $_POST['bnt_add'];

                                // Cập nhật số lượt xem
                                $sql = $conn->query("UPDATE bai_dang SET luot_xem = luot_xem + 1 WHERE id_bd = '$id_bd';");

                                // Chuyển hướng đến trang chi tiết bài đăng
                                $id_pt = $_POST['id_pt'];
                                header("Location: ../detail/list_home.php?id=$id_pt");
                                exit();
                            }
                        ?>

            </div>
        </div>
      </div>
      </div>
</div>
</div>

 
 
<?php 

// Hiển thị phân trang
echo "<div class='pagination'>";
if ($page > 1) {
    echo "<a href='?page=" . ($page - 1) . "'>Trước</a> ";
}

for ($i = 1; $i <= $total_pages; $i++) {
    if ($i == $page) {
        echo "<strong class='number'>$i</strong> "; // Trang hiện tại
    } else {
        echo "<a href='?page=$i'>$i</a> ";
    }
}

if ($page < $total_pages) {
    echo "<a href='?page=" . ($page + 1) . "'>Sau</a>";
}
echo "</div>";

?>



<!-- map -->


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
                                            header("location: ./list_home.php");
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

<script src="../main.js"></script>
<script src="https://code.jquery.com/ui/1.14.0/jquery-ui.js"></script>

<script>
    function toggleDropdown() {
        const dropdown = document.getElementById("dropdownMenu");
        dropdown.style.display = (dropdown.style.display === "block") ? "none" : "block";
    }

    // Đóng dropdown khi nhấp ra ngoài
    window.onclick = function(event) {
        if (!event.target.matches('.dropdown-button')) {
            const dropdowns = document.getElementsByClassName("dropdown-content");
            for (let i = 0; i < dropdowns.length; i++) {
                dropdowns[i].style.display = "none";
            }
        }
    }
</script>
<script>
    function toggleDropdown2() {
        document.getElementById("dropdown2Menu").classList.toggle("show");
    }

    // Đóng dropdown nếu người dùng nhấp ra ngoài
    window.onclick = function(event) {
        if (!event.target.matches('.dropdown2-button')) {
            var dropdowns = document.getElementsByClassName("dropdown2-content");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>
</body>
</html>
