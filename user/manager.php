<?php 
require_once('../ConnectDB/connectDB.php');
require_once('../Library/library.php');
ob_start();
session_start();



if (isset($_SESSION['nguoidung'])) {
    $conn = connectDB();
// include 'post_update.php';

    $idCustomer = $_SESSION['nguoidung']['id_nd'];
    $result = $conn -> query("SELECT * FROM nguoi_dung WHERE id_nd = ".$idCustomer."");
    $row = $result -> fetch_assoc();
    $email = $row['email'];

    // $idP = $_SESSION['nguoidung']['id_pt'];
    // $result = $conn -> query("SELECT * FROM phong WHERE id_pt = ".$idP."");
    // $row = $result -> fetch_assoc();
 
    $records_per_page = 5;

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $start_from = ($page - 1) * $records_per_page;
    
    // Lấy tổng số bản ghi
    $sql_total = "SELECT COUNT(*) AS total FROM bai_dang WHERE id_nd = ".$idCustomer." ";
    $result_total = $conn->query($sql_total);
    $row_total = $result_total->fetch_assoc();
    $total_records = $row_total['total'];
    $total_pages = ceil($total_records / $records_per_page);
    
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
    <link rel="stylesheet" href="../detail/cmt.css">
    <link rel="stylesheet" href="./user.css">
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
                            <a class="nav-link " href="../message_user/index.php">
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
<div class="container_list">
    <div class="listingsLoaded">
        <div class="my_list">
            <?php 
                $conn = connectDB();
                $idCustomer = $_SESSION['nguoidung']['id_nd'];
                $result = $conn -> query("SELECT * FROM nguoi_dung WHERE id_nd = ".$idCustomer."");

                if ($result -> num_rows > 0) {
                while($row = $result -> fetch_assoc()) {
                    
                    $ngaysinh = $row['ngaysinh'];
                    $birthdate = new DateTime($ngaysinh);
                    $today = new DateTime();
                    $age = $today->diff($birthdate)->y; // Lấy số năm
            ?>
                <div class="profile">
                    <div class="avt">
                        <img src="../img/avata/<?php echo $row['hinhanh']?>" class="avt-img" alt="">
                    </div>
                    <div class="info">
                        <h3> <?php echo $row['hoten'];?> </h3>
                        <h5><?php echo $age ?> tuổi, giới tính <?php echo $row['gioitinh'];?></h5>
                        <h5>Địa chỉ: <?php echo $row['dia_chi'];?> </h5>
                        <h5>Số điện thoại:<?php echo $row['sdt'];?> </h5>
                        <a href="#">
                        <button class="ho-so" id="hoso">
                            <i class="fa-solid fa-pencil "></i>              
                                <span>Chỉnh sửa hồ sơ</span>
                        </button>
                        </a>
                      
                    </div>
                    <div class="edit_tin" style="margin-left: 115px;">
                        
                        <a href="./manager_edit_tin.php">
                            <button class="ho-so" >
                                <i class="fa-solid fa-pencil "></i>              
                                <span>Chỉnh sửa tin tìm trọ</span>
                            </button>
                        </a>
                    </div>
                </div>
                <div class="content">
                     <a href="../home/home.php">
                        <button class="con">
                            <i class="fa-solid fa-home ic"></i>              
                                <span>Cung cấp chổ ở</span>
                        </button>
                        </a>
                        <a href="../search-home/sea_home.php">
                        <button class="con">
                            <i class="fa-solid fa-user ic"></i>              
                                <span>Tìm kiếm chổ ở</span>
                        </button>
                        </a>
                  </div>
        </div>
        <?php }} ?>
    </div>
</div>

<div class="container_list text-center">
    <div class="listingsLoaded">
        <h5>Danh sách nhà cho thuê</h5>
        <div class="edit_adress">
                      
                    <?php 
                          $conn = connectDB();
     


                              $binhluan = $conn -> query("SELECT p.id_pt,bl.id_bl,bl.noidung,bl.ngaydang,nd.hoten,nd.hinhanh FROM binh_luan bl INNER join phong p inner join nguoi_dung nd ON p.id_pt = bl.id_pt and bl.id_nd = nd.id_nd 
                               WHERE nd.id_nd = ".$idCustomer." ORDER BY bl.id_bl DESC ");
                                //  $binhluan = $conn -> query("SELECT bl.id_bl,bl.noidung,bl.ngaydang,nd.hoten,nd.hinhanh FROM binh_luan bl INNER join phong p inner join nguoi_dung nd ON p.id_pt = bl.id_pt and bl.id_nd = nd.id_nd  WHERE p.id_pt = ".$idProduct."  ORDER BY bl.id_bl DESC ");
                               
                                $result = $conn->query("SELECT DISTINCT p.so_luong_nguoi,tn.ten_tiennghi,qd.ten_quydinh,p.dien_tich_phong,tnc.ten_tnc,bd.ngay_dang,co.dien_tich,l.ten_loai,nd.gioitinh,nd.hoten,bd.trang_thai,bd.id_bd,p.id_pt,bdp.gia,p.gia_dien,p.gia_nuoc,co.dia_chi,ha.anh,bd.ngay_thue_trong,nd.id_nd 
                                FROM cho_o co inner join nguoi_dung nd inner join bai_dang bd inner join bai_dang_phong bdp inner join phong p INNER join hinh_anh ha INNER JOIN loai l INNER JOIN tien_nghi_chung tnc INNER JOIN tien_nghi tn INNER JOIN quy_dinh qd
                                ON tn.id_pt = p.id_pt and qd.id_pt = p.id_pt and co.id_loai = l.id_loai and tnc.id_cho = co.id_cho and ha.id_pt = p.id_pt and p.id_cho = co.id_cho and bdp.id_pt = p.id_pt and bdp.id_bd = bd.id_bd and co.id_bd = bd.id_bd and co.id_nd = nd.id_nd and bd.id_nd = nd.id_nd WHERE nd.id_nd = ".$idCustomer."  and ha.anh_dai_dien = 1 LIMIT $start_from, $records_per_page;");
                            //  $current_time = new DateTime();
                             if ($result->num_rows > 0) {
                                while($row = $result-> fetch_assoc()) {
                                    // if(isset($row['anh_dai_dien']) == 1){
                                        // $post_time = new DateTime($row['ngaydang']);
                                        // $interval = $post_time->diff($current_time);
                                        $id_P = $row['id_pt'];

                        ?>
                          <form action="" method="post">
                    <div class="from_list_home">
                        <div class="edit_hide">
                            <?php 
                            if($row['trang_thai'] == 1) {
                                echo '<button class="hide" type="submit" name="update" value="'.$row['id_bd'].'">Ẩn</button>';
                            } else {
                                echo '<button class="hide" type="submit" name="update" value="'.$row['id_bd'].'" style="background-color: #F44336 !important;">Đã Ẩn</button>';
                            }
                            ?>
                            <button class="hide" type="submit" name="edit" value="<?php echo $row['id_bd']; ?>">Hiện</button>
                        </div>
                    </div>

                    <div class="container_home_list">
                        <div class="list_modal">
                            <div class="list_left">
                                <div class="list_navi">
                                    <ul style="padding: 0; margin: 0; list-style-type: none;">
                                        <li class="list_item">
                                            <i class="fa-regular fa-image"></i>           
                                            <span>Hình ảnh</span>
                                        </li>
                                    </ul>
                                </div>

                                <div class="img_main" style="height: 258px;">
                                    <img src="../img/<?php echo $row['anh']; ?>" class="w-100 h-100 img_m img-fluid" alt="">
                                </div>   
                            </div>

                            <div class="list_right">
                                <div class="primary_info">
                                    <div class="list_user">
                                        <div class="name" style="display:none;">
                                            <span class="fw-bold">Người cho thuê: <?php echo $row['id_pt']; ?></span>
                                        </div>
                                        <div class="name">
                                            <span class="fw-bold">Người cho thuê: <?php echo $row['hoten']; ?></span>
                                        </div>
                                        <div class="user_info">
                                            <span><?php echo $age; ?> tuổi. <?php echo $row['gioitinh']; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="secon_info">
                                    <div class="list_commo">
                                        <i class="fa-solid fa-building" style="font-size: 26px;"></i>
                                        <span style="display: block;"><?php echo $row['ten_loai']; ?></span> 
                                    </div>
                                    <div class="list_commo">
                                        <i class="fa-solid fa-chart-area" style="font-size: 26px;"></i>
                                        <span style="display: block;"><?php echo $row['dien_tich']; ?> m²</span> 
                                    </div>
                                    <div class="list_commo">
                                        <i class="fa-solid fa-money-bill"></i>
                                        <span style="display: block;"><?php echo number_format($row['gia']); ?> VNĐ/ tháng</span> 
                                    </div>
                                    <div class="list_commo">
                                        <i class="fa-solid fa-user li" style="font-size: 26px; color: #000;"></i>
                                        <span style="display: block;">Không có người ở: <?php echo $row['so_luong_nguoi']; ?></span> 
                                    </div>
                                </div>
                                <div class="messa_info">
                                    <span style="font-size: 14px; letter-spacing: .01em; text-align: left; line-height: 1.45em;"><?php echo $row['mo_ta']; ?></span>
                                </div>
                                <div class="listing_details_container">
                                    <table class="listing_details">
                                        <thead>
                                            <tr>
                                                <th>THÔNG BÁO</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><label class="fw-bold">Ngày đăng:</label></td>
                                                <td class="capitalize_td"><?php echo $row['ngay_dang']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><label class="fw-bold">Ngày thuê trống:</label></td>
                                                <td class="capitalize_td"><?php echo $row['ngay_thue_trong']; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="listing_details">
                                        <thead>
                                            <tr>
                                                <th>CHỔ Ở</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><label class="fw-bold">Địa chỉ:</label></td>
                                                <td class="capitalize_td"><?php echo $row['dia_chi']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><label class="fw-bold">Loại:</label></td>
                                                <td class="capitalize_td"><?php echo $row['ten_loai']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><label class="fw-bold">Tiện nghi chung:</label></td>
                                                <td class="capitalize_td"><?php echo $row['ten_tnc']; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="listing_details">
                                        <thead>
                                            <tr>
                                                <th>Phòng</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><label class="fw-bold">Diện tích:</label></td>
                                                <td class="capitalize_td"><?php echo $row['dien_tich_phong']; ?> m²</td>
                                            </tr>
                                            <tr>
                                                <td><label class="fw-bold">Giá điện:</label></td>
                                                <td class="capitalize_td"><?php echo $row['gia_dien']; ?> VNĐ</td>
                                            </tr>
                                            <tr>
                                                <td><label class="fw-bold">Giá nước:</label></td>
                                                <td class="capitalize_td"><?php echo $row['gia_nuoc']; ?> VNĐ</td>
                                            </tr>
                                            <tr>
                                                <td><label class="fw-bold">Tiện nghi:</label></td>
                                                <td class="capitalize_td"><?php echo $row['ten_tiennghi']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><label class="fw-bold">Quy định:</label></td>
                                                <td class="capitalize_td"><?php echo $row['ten_quydinh']; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="listing_details">
                                        <div class="cmt_title">
                                            <font>Bình luận</font>
                                        </div>
                                        <div class="comment">
                                            <?php  
                                         
                                                     // Truy vấn bình luận theo id_pt
                                            $binhluan2 = $conn->query("
                                            SELECT 
                                                bl.id_bl,
                                                bl.noidung,
                                                bl.ngaydang,
                                                nd.hoten,
                                                nd.hinhanh 
                                            FROM 
                                                binh_luan bl 
                                            INNER JOIN 
                                                nguoi_dung nd ON bl.id_nd = nd.id_nd 
                                            WHERE 
                                                bl.id_pt = " .$id_P. " 
                                            ORDER BY 
                                                bl.id_bl DESC
                                        ");
                                            if ($binhluan2 && $binhluan2 -> num_rows > 0 ) {
                                                while($bl = $binhluan2->fetch_assoc()) { ?>  
                                                    <div class="show_cmt">
                                                        <div class="cmt_item">
                                                            <div class="id_name">
                                                                <div class="show_accout">
                                                                    <img src="../img/avata/<?php echo $bl['hinhanh']; ?>" class="img__avatar_cmt">
                                                                    <span><?php echo $bl['hoten']; ?></span>
                                                                </div>
                                                                <div class="time__comment"><?php echo $bl['ngaydang']; ?></div>
                                                            </div>
                                                            <div class="content_cmt" align="left">
                                                                <p><?php echo $bl['noidung']; ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                            <?php }} ?>
                                        </div>   
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                                    <?php 
                                    echo'
                                    <a href="../detail/manager.php?id='.$row["id_pt"].'" class="submit nav-link" > 
                                    <div class="sub_user_h" style="font-size: 18px; width: 74px !important;">
                                    Sửa
                                    </div>
                                    </a>
                                    ';
                                    ?>

                            <?php 
                            }}   
                            ?>
                             <?php 
                               
                if(isset($_POST['update'])) {
                  $valSP = $_POST['update'];
                  $conn = connectDB();
                  $resultFinal = $conn -> query("UPDATE bai_dang SET trang_thai = 0 WHERE id_bd = ".$valSP."");
                  if ($resultFinal) {
                      header("Refresh:1");
                      echo '<span class="notification__success" style="color : #42c174;">Ẩn Thành Công !</span>';
                    
                  } else {
                      echo '<span class="notification__fail">Ẩn Thất Bại !</span>';
                  }
              }elseif(isset($_POST['edit'])){
                $valSP = $_POST['edit'];
                $conn = connectDB();
                $resultFinal = $conn -> query("UPDATE bai_dang SET trang_thai = 1, ngay_dang = now() WHERE id_bd = ".$valSP."");
                if ($resultFinal) {
                    header("Refresh:1");
                    echo '<span class="notification__success" style="color : #42c174;">Hiện Thành Công !</span>';
                  
                } else {
                    echo '<span class="notification__fail">Hiện Thất Bại !</span>';
                }
              }
              ?>
                          
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

</div>

<!-- thongtin -->

<div class="home_user_tt" id="home_user_tt">

    <div class="home_lis text-center" id="home_lis" >

        <div class="click_x">

                <button id="click_x_home" class="fw-bold">
                    <i class="fa-solid fa-times "></i>              
                </button>
        </div>
     
            <div class="container_user_list">
                <div class="list_modal_user">
                    
                       <!-- end setting item -->
                  <div class="setting_adress">
                <div class="title_setting">
                    <h2>Thông tin cá nhân</h2>
                </div>
                <!-- end title_setting -->
                <div class="edit_adress">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form_group">
                            <?php personalInformation($_SESSION['nguoidung']['id_nd']);?>
                        </div>
                        <div class="btn_u" style="    padding-top: 124px;">

                            <button class="bnt_submit" name="bntEditAdress" id="bnt_UpdateAdress" onclick="return showInpAdress()" value="edit">Thay đổi</button>
                        </div>
                    </form>
                    <?php 
                        if (isset($_POST['bntEditAdress']) == 'update') {
                          updatePersonalInformation($_POST['hoten'], $_POST['email'], $_POST['sdt'], $_POST['diachi'], $_POST['ghichu'], $_POST['ngansach'],$_POST['hinhanh'], $_SESSION['nguoidung']['id_nd']);
                        }
                    ?>
                </div>
            </div>
                   
                </div>
            </div>
        
      

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
                                   
                                            header("location: ../user/manager.php");
                                        
                                            echo "<span style='color: #56fb41;'>Đăng Ký Tài Khoản Thành Công !</span>";

                                   
                                } else {
                                    echo "Tài Khoản Hoặc Mật Khẩu Không Đúng !";
                                }

                                
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
<script src="./styleJs.js"></script>

</body>
</html>
<?php } ?>