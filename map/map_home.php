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
    <link rel="stylesheet" href="../home/home.css">
    <link rel="stylesheet" href="../home/home_list.css">
    <link rel="stylesheet" href="../home/main.css">
    <link rel="stylesheet" href="../home/base.css">
    <link rel="stylesheet" href="../detail/detail.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css">

<!-- map-->

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</head>
<style>
    #map {
      height: 468px;
      width: 100%;
    }
  </style>
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
                        <div class="account"style="    margin-top: -27px !important;">
                    
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
                    
                    <a href="./list_home_map.php">

                            <button class="love_btn" id="map_cl">
                            <i class="fa-solid fa-map "></i>              
                                <span>Bản đồ</span>
                            </button>
                    </a>
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
                                    // if(isset($row['anh_dai_dien']) == 1){
                        ?>
                            <div class="grid__column-2-4 ">  
                                <button href="" class="nav-link" id="home_l">

                                    <div class="home-product-item"  href="details.php?id_product=<?=$row['id_xe']?>&idcategory=<?=$row['id_danhmuc']?>" class="product-item__link">
                                    <!-- <div class="home-pruduct-item__img" style="background-image: url(https://cdn1.viettelstore.vn/images/Product/ProductImage/medium/1675652850.jpeg);"></div> -->
                                        <img src="../img/<?= $row['anh'] ?>" class="w-100" style="    height: 170px;" alt="<?= $row['ten_xe']?>"/>
                                    <!-- <img src="https://images.lacartedescolocs.fr/tipis-listing-pictures/listing-2bca74d7e4081a6e80283ae0b6b7b592/2594345/medium.jpg" class="w-100" alt="<?= $row['ten_xe']?>"/> -->
                                    
                                    <h2 class="home-pruduct-item__name fw-bold"> <?= $row['ten_co'] ?></h2>

                                    <h4 class="home-pruduct-item__name">Địa chỉ: <?= $row['dia_chi'] ?> </h4>
                                    <p class="home-pruduct-item__name"><?= $row['mo_ta'] ?></p>
                                    <div class="home-pruduct-item__price">
                                        <span class="home-pruduct-item__price-mới"><span class="fw-bold" style="color: #000; font-size: 20px;"><?= $row['gia'] ?></span> /tháng </span>   
                                    </div> 
                                  
                                    <?php 
                                    echo'
                                    <a href="../detail/list_home.php?id='.$row["id_nd"].'" class="submit nav-link" > 
                                    <div class="sub_user">
                                    Xem thông tin
                                    </div>
                                    </a>
                                    ';
                                    ?>
                                    <!-- <a href="../Product_Detail/sanpham.php?id='.$row["id_product"].'">Mua Ngay</a> -->
                                    
                                </div>  
                             </button>

                            </div>
                            <?php }}  ?>
                     

            </div>
        </div>
      </div>
      </div>
</div>
</div>

<div class="home_list_detail" id="home_list">

    <div class="home_lis text-center" id="home_lis" >

        <div class="click_x">
            <a href="../home/list_home.php">

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
                $result = $conn -> query("SELECT  p.so_luong_nguoi,nd.hinhanh,ha.anh,nd.ngaysinh,p.id_pt,p.dien_tich_phong,p.gia_dien,p.gia_nuoc,tn.ten_tiennghi,qd.ten_quydinh,nd.hoten,co.dia_chi,bd.mo_ta,bdp.gia,ha.anh_dai_dien,ha.anh,nd.id_nd,nd.gioitinh,l.ten_loai,co.dien_tich,bd.ngay_dang,bd.ngay_thue_trong,tnc.ten_tnc
                 FROM cho_o co inner join nguoi_dung nd inner join bai_dang bd inner join bai_dang_phong bdp inner join phong p INNER join hinh_anh ha inner join quy_dinh qd inner join tien_nghi tn inner join tien_nghi_chung tnc inner join loai l 
             ON qd.id_pt = p.id_pt and tnc.id_cho = co.id_cho and co.id_bd = bd.id_bd and co.id_nd = nd.id_nd and nd.id_nd = bd.id_nd and bdp.id_bd = bd.id_bd and p.id_pt = ha.id_pt and p.id_cho = co.id_cho WHERE p.id_pt = ".$idProduct." and ha.anh_dai_dien = 1 ");
                
              $result_anh = $conn -> query("SELECT ha.anh,p.id_pt FROM phong p INNER join hinh_anh ha ON p.id_pt = ha.id_pt WHERE p.id_pt = ".$idProduct." and ha.anh_dai_dien = 0;");
              $binhluan = $conn -> query("SELECT bl.id_bl,bl.noidung,bl.ngaydang,nd.hoten,nd.hinhanh FROM binh_luan bl INNER join phong p inner join nguoi_dung nd ON p.id_pt = bl.id_pt and bl.id_nd = nd.id_nd  WHERE p.id_pt = ".$idProduct."  ORDER BY bl.id_bl DESC ");
              
              if ($result->num_rows > 0) {
                    while($row = $result-> fetch_assoc()) {
                    
                  $row = $result->fetch_assoc();
                  $ngaysinh = $row['ngaysinh'];
                  $birthdate = new DateTime($ngaysinh);
                  $today = new DateTime();
                  $age = $today->diff($birthdate)->y; // Lấy số năm 
                  echo '
          <form id="form__input__product" action="" method="post" enctype="multipart/form-data">

            <div class="container_home_list">
                <div class="list_modal">
                    <div class="list_left">
                        <div class="list_navi">
                            <ul style="  padding: 0; margin: 0; list-style-type: none;">
                            <li class="list_item" style="background: none !important;">
                            <i class="fa-regular fa-image"></i>           
                               
                                 <a href="../detail/list_home.php?id='.$row["id_pt"].'" class="map_link" >HÌNH ẢNH </a>
                            </li>
                            <li class="list_item">
                                <i class="fa-solid fa-map "></i>              
                                <a href="../map/map_home.php?id='.$row["id_pt"].'" class="map_link" >BẢN ĐỒ </a>
                            
                                    </li>
                                     <li class="list_nav_bd">
                                    <i class="fa-solid fa-bars"></i>              
                                    <a href="../detail/list_home_lq.php?price='.$row['gia'] .'&area='.$row['dien_tich_phong'] .'"  style=" color: #fff; text-decoration: none;">BÀI ĐĂNG LIÊN QUAN </a>
                            
                                    </li>
                            </ul>
                        </div>

                      ';?>
                           
                                    <div id="map"></div>
                                    <div class="lightbox">
                                        <div ></div>
                                        <img src="../img/sp1.jpg" class="img-fluid" alt="">
                                    </div>
                                    
                                </div>

                    <?php echo'
                    <div class="list_right">
                        <div class="primary_info">
                            <div class="list_user">
                            <div class="name" style="display:none;">
                                    <span class="fw-bold">Người cho thuê: '.$row['id_pt'].'</span>
                                </div>
                                <div class="name">
                                    <span class="fw-bold">Người cho thuê: '.$row['hoten'].'</span>
                                </div>
                                <div class="user_info">
                                    <span>'.$age.' tuổi. '.$row['gioitinh'].'</span>
                                </div>
                            </div>
                        </div>
                        <div class="secon_info">
                                <div class="list_commo">
                                    <i class="fa-solid fa-building " style=" font-size: 26px;"></i>
                                    <span style="display: block;">'.$row['ten_loai'].'</span> 
                                </div>
                                <div class="list_commo">
                                     <i class="fa-solid fa-chart-area" style=" font-size: 26px;"></i>
                                    <span style="display: block;">'.$row['dien_tich'].' m²</span> 
                                </div>
                                <div class="list_commo">
                                    <i class="fa-solid fa-money-bill"></i>
                                    <span style="display: block;">'. number_format($row['gia']) .' VNĐ/ tháng</span> 
                                </div>
                                <div class="list_commo">
                                    <i class="fa-solid fa-user li" style=" font-size: 26px;     color: #000;"></i>
                                    <span style="display: block;">Số người đang ở: '.$row['so_luong_nguoi'].'</span> 
                                </div>
                               
                        </div>
                        <div class="messa_info">
                            <span style="font-size: 14px;letter-spacing: .01em;text-align: left;line-height: 1.45em; vertical-align: inherit;" >'.$row['mo_ta'].'</span>
                        </div>
                        <div class="listing_details_container">
                            <table class="listing_details">
                                <thead>
                                    <tr>
                                        <th>
                                          <font style="vertical-align: inherit;">THÔNG BÁO</font>
                                        </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <label for="" class="fw-bold">Ngày đăng:</label>
                                        </td>
                                        <td class="capitalize_td">
                                            <font style="vertical-align: inherit;">
                                                <font style="vertical-align: inherit;">'.$row['ngay_dang'].'</font>
                                            </font>
                                        </td>
                                    </tr>
                                    <tr>
                                            <td>
                                                <label for="" class="fw-bold">Ngày thuê trống:</label>
                                            </td>
                                            <td class="capitalize_td">
                                                <font style="vertical-align: inherit;">
                                                    <font style="vertical-align: inherit;">'.$row['ngay_thue_trong'].'</font>
                                                </font>
                                            </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="listing_details">
                                <thead>
                                    <tr>
                                        <th>
                                          <font style="vertical-align: inherit;">CHỔ Ở</font>
                                        </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <label for="" class="fw-bold">Địa chỉ:</label>
                                        </td>
                                        <td class="capitalize_td">
                                            <font style="vertical-align: inherit;">
                                                <font style="vertical-align: inherit;">'.$row['dia_chi'].'</font>
                                            </font>
                                        </td>
                                    </tr>
                                    <tr>
                                            <td>
                                                <label for="" class="fw-bold">Loại:</label>
                                            </td>
                                            <td class="capitalize_td">
                                                <font style="vertical-align: inherit;">
                                                    <font style="vertical-align: inherit;">'.$row['ten_loai'].'</font>
                                                </font>
                                            </td>
                                    </tr>
                                    <tr>
                                            <td>
                                                <label for="" class="fw-bold">Tiện nghi chung:</label>
                                            </td>
                                            <td class="capitalize_td">
                                                <font style="vertical-align: inherit;">
                                                    <font style="vertical-align: inherit;">'.$row['ten_tnc'].'</font>
                                                </font>
                                            </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="listing_details">
                                <thead>
                                    <tr>
                                        <th>
                                          <font style="vertical-align: inherit;">Phòng</font>
                                        </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <label for="" class="fw-bold">Diện tích:</label>
                                        </td>
                                        <td class="capitalize_td">
                                            <font style="vertical-align: inherit;">
                                                <font style="vertical-align: inherit;">'.$row['dien_tich_phong'].' m²</font>
                                            </font>
                                        </td>
                                    </tr>
                                    <tr>
                                            <td>
                                                <label for="" class="fw-bold">Giá điện:</label>
                                            </td>
                                            <td class="capitalize_td">
                                                <font style="vertical-align: inherit;">
                                                    <font style="vertical-align: inherit;">'.number_format($row['gia_dien']).' VNĐ</font>
                                                </font>
                                            </td>
                                    </tr>
                                    <tr>
                                            <td>
                                                <label for="" class="fw-bold">Giá nước:</label>
                                            </td>
                                            <td class="capitalize_td">
                                                <font style="vertical-align: inherit;">
                                                    <font style="vertical-align: inherit;">'.number_format($row['gia_nuoc']).' VNĐ </font>
                                                </font>
                                            </td>
                                    </tr>
                                    <tr>
                                            <td>
                                                <label for="" class="fw-bold">Tiện nghi:</label>
                                            </td>
                                            <td class="capitalize_td">
                                                <font style="vertical-align: inherit;">
                                                    <font style="vertical-align: inherit;">'.$row['ten_tiennghi'].'</font>
                                                </font>
                                            </td>
                                            
                                    </tr>
                                    <tr>
                                            <td>
                                                <label for="" class="fw-bold">Quy định:</label>
                                            </td>
                                            <td class="capitalize_td">
                                                <font style="vertical-align: inherit;">
                                                    <font style="vertical-align: inherit;">'.$row['ten_quydinh'].'</font>
                                                </font>
                                            </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="listing_details">
                                    <div class="cmt_title">

                                        <font style="vertical-align: inherit;">Bình luận</font>
                                    </div>
                                        ';?>
                                <div class="comment">
                                <?php  if ($binhluan -> num_rows > 0) {
                                    while($bl = $binhluan -> fetch_assoc()){?>  
                                        <div class="show_cmt">
                                            <div class="cmt_item">
                                                <div class="id_name">
                                                    <div class="show_accout">
                                                        <img src ="../img/avata/<?php echo $bl['hinhanh']; ?>" class="img__avatar">
                                                        <span><?php echo $bl['hoten']; ?></span>
                                                    </div>
                                                    <div class="time__comment"><?php echo $bl['ngaydang']; ?></div>
                                                </div>
                                                <div class="content_cmt">
                                                    <p><?php echo $bl['noidung']; ?></p>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <?php }}?>
                                        
                                        <div class="input_comment">
                                            <?php if (isset($_SESSION['nguoidung'])): // Kiểm tra nếu người dùng đã đăng nhập ?>
                                                <form action="your_action_page.php" method="POST">
                                                    <input class="input_cmt" type="text" placeholder="Viết Bình Luận" name="content_comment"  />
                                                    <button name="bnt_sent_comment" class="btn_cmt" value="<?php echo $row['id_pt']; ?>">Bình Luận</button>
                                                </form>
                                            <?php else: ?>
                                                <p class="notification__error">Bạn cần <a href="../index.php">đăng nhập</a> để bình luận!</p>
                                            <?php endif; ?>
                                        </div>
    <?php
                                    echo'
                                </div>   
                                

                                

                            </div>



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
    ';
    
?>

                            <div class="listing_footer_buttons_love" style="    float: right;">
    
                                <?php if (isset($_SESSION['nguoidung'])): // Kiểm tra nếu người dùng đã đăng nhập ?>
                                    
                                        <div class="love">
                                                <button class="love_cl" type="submit" name="bnt_add" value="<?php echo $row['id_pt']; ?>">
                                                <i class="fa-regular fa-heart oa"></i>
                                                
                                                    <span>Ghi nhớ</span>
                                                </button>
                                            </div>
                                    <?php else: ?>
                                    <p class="notification__error_love">Bạn cần <a href="../index.php">đăng nhập</a> 
                                    <div class="love" style="float: right;">
                                                <button class="love_cl" type="submit" name="bnt_add" value="'.$row['id_pt'].'">
                                                <i class="fa-regular fa-heart oa"></i>
                                                
                                                    <span>Ghi nhớ</span>
                                                </button>
                                            </div>
                                    </p>
                                    <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                                        </form>
        
<?php                }
            }
              } 
              // insert data
              $conn = connectDB();
              if (isset($_POST['bnt_add']) and $_POST['bnt_add'] ) {
              $id_pt=$_POST['bnt_add'];
                $sql = $conn->query("INSERT INTO tt_binh_luan VALUES ('$idCustomer','$id_pt','1')");
                //    var_dump($sql);die();
                        if ($sql) { 
                            echo '<span class="notification__success" style=" top: 642px !important;  left: 610px !important;">Ghi Nhớ Thành Công !</span>';


                        } 

              }
               // insert data cmt
            elseif (isset($_POST['bnt_sent_comment']) and $_POST['bnt_sent_comment'] ) {
            $id_bl=$_POST['bnt_sent_comment'];
            $contentComment = $_POST['content_comment'];
            $sql2 = $conn->query("INSERT INTO binh_luan VALUES (null,'$idCustomer','$id_bl','$contentComment',now())");
            //    var_dump($sql2);die();
                    if ($sql2) { 
                        echo '<span class="notification__success" style=" top: 642px !important;  left: 610px !important;">Bình Luận Thành Công !</span>';
                        header('Refresh:1');

                    } 

            }
           
                  ?>

    </div>

</div>
<!-- map -->
<?php
                    
$sql = "SELECT co.dia_chi FROM cho_o co inner join phong p ON p.id_cho = co.id_cho  WHERE p.id_pt = ".$idProduct." ";
$result_map = $conn->query($sql);
                    $markers = array();
                    while($row = mysqli_fetch_array($result_map,MYSQLI_BOTH)) {
                        $address = $row['dia_chi'];

                        $markers[] = array(
                            'diachi' => $address
                        );

                    // $address = "Hẻm 58 Đường 3 Tháng 2, Phường Hưng Lợi, Quận Ninh Kiều, Thành phố Cần Thơ, 94908, Việt Nam";
                        
                    $url = "https://nominatim.openstreetmap.org/search?q=" . urlencode($address) . "&format=json&limit=1";

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3');

                    $response = curl_exec($ch);

                    if ($response === false) {
                        echo "Lỗi khi gọi API: " . curl_error($ch);
                    } else {
                        $data = json_decode($response, true);
                        if (count($data) > 0) {
                            $latitude = $data[0]["lat"];
                            $longitude = $data[0]["lon"];
                            // echo "Tọa độ của địa chỉ '" . $address . "' là: ";
                            // echo'<br>';
                            // echo "Latitude: " . $latitude . ", Longitude: " . $longitude;
                            $markers[count($markers) - 1]['latitude'] = $latitude;
                            $markers[count($markers) - 1]['longitude'] = $longitude;
                        } else {
                            // echo "Không tìm thấy tọa độ của địa chỉ '" . $address . "'.";
                        }
                    }}

                    
                    curl_close($ch);
                    ?>

                    <script>
                        // Tạo bản đồ và đặt tâm ở tọa độ của địa chỉ
                        var map = L.map('map').setView([<?php echo $markers[0]['latitude']; ?>, <?php echo $markers[0]['longitude']; ?>], 13);

                        // Thêm lớp bản đồ OpenStreetMap
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                        }).addTo(map);

                        // Thêm các marker tại tọa độ của từng địa chỉ
                        <?php foreach ($markers as $marker) { ?>
                            var marker = L.marker([<?php echo $marker['latitude']; ?>, <?php echo $marker['longitude']; ?>]).addTo(map);
                            
                            // Bind popup cho marker
                            marker.bindPopup("<?php echo $marker['diachi']; ?>");

                            // Hiển thị thông tin khi hover
                            marker.on('mouseover', function(e) {
                                this.openPopup();
                            });

                            marker.on('mouseout', function(e) {
                                this.closePopup();
                            });
                        <?php } ?>
                    </script>
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
