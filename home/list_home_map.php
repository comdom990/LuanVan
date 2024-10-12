<?php 
require_once('../ConnectDB/connectDB.php');
require_once('../Library/library.php');
ob_start();
session_start();

$conn = connectDB();

$records_per_page = 5;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $records_per_page;

// Lấy tổng số bản ghi
$sql_total = "SELECT COUNT(*) AS total FROM bai_dang";
$result_total = $conn->query($sql_total);
$row_total = $result_total->fetch_assoc();
$total_records = $row_total['total'];
$total_pages = ceil($total_records / $records_per_page);

$idcategory = '';
if (isset($_GET['idcategory'])) {
    $idcategory = (int)$_GET['idcategory'];
    $result = $conn->query("SELECT p.id_pt, nd.hoten, co.dia_chi, bd.mo_ta, bdp.gia, ha.anh_dai_dien, ha.anh, nd.id_nd 
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
} else {
    $result = $conn->query("SELECT bd.id_bd, p.id_pt, nd.hoten, co.dia_chi, bd.mo_ta, bdp.gia, ha.anh_dai_dien, ha.anh, nd.id_nd 
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
        AND bd.trang_thai = 1 
        LIMIT $start_from, $records_per_page;");
}

$category = $conn->query("SELECT * FROM loai");

// Nếu không cần kiểm tra đăng nhập, có thể bỏ qua đoạn này:
// if (isset($_SESSION['nguoidung'])) {
//     $idCustomer = $_SESSION['nguoidung']['id_nd'];
//     // Đếm số bình luận
//     $tb = "SELECT count(bl.id_pt) as soluong FROM tt_binh_luan bl WHERE bl.id_nd = $idCustomer;";
//     $resulttb = mysqli_query($conn, $tb);
//     $rowtb = mysqli_fetch_array($resulttb);
//     $tongtb = $rowtb['soluong'];
// }


$sql = "SELECT p.id_pt, nd.hoten,co.dia_chi,bd.mo_ta,bdp.gia,ha.anh_dai_dien,ha.anh,nd.id_nd FROM cho_o co inner join nguoi_dung nd inner join bai_dang bd inner join bai_dang_phong bdp inner join phong p INNER join hinh_anh ha
        ON  co.id_bd = bd.id_bd and co.id_nd = nd.id_nd and nd.id_nd = bd.id_nd and bdp.id_bd = bd.id_bd and p.id_pt = ha.id_pt and p.id_cho = co.id_cho";
$result_map = $conn->query($sql);

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
                    <a href="./list_home_love.php">

                        <button class="love_btn">
                            <i class="fa-regular fa-heart oa"></i>
                            <span>Lựa chọn yêu thích</span>
                            <?php echo $tongtb; ?>
                        </button>
                    </a>
                    
                    <a href="">

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
            <div class="grid__column-2">
                <nav class="category">
                    <!-- <h3 class="category__heading">
                        <i class=" category__heading-icon fas fa-list"></i>
                        THUÊ XE DU LỊCH</h3> -->
                    
                    <ul class="category-list"> 
                        
                        <li class="category-item ">
                            <a href="./list_home.php" class="category-item__link">Tất Cả Loại Chổ Ở</a>
                        </li>
                       
                        <?php 
                                if ($category->num_rows > 0) {
                                    while($row = $category-> fetch_assoc()) {
                        ?>
                        <li class="category-item ">
                            <a href="./list_home.php?idcategory=<?=$row['id_loai']?>" class="category-item__link"><?= $row['ten_loai']?></a>
                        </li>
                        <?php }} ?>
                    
                        
                    </ul>
                    <!-- <div class="price-list">
                        
                        <p>
                        <label for="amount">Khoảng Giá Lọc:</label>
                        <input type="text" id="amount" readonly="" style="border:0; color:#333; ">
                        </p>
                        <div id="slider-range"></div>
                    </div> -->
                
                    <ul class="category-list"> 
                        
                        <li class="category-item ">
                            <a href="./list_home.php" class="category-item__link">Sắp xếp giá</a>
                        </li>
                       
                        <li class="category-item ">
                            <a href="./list_home_asc.php" class="category-item__link">Từ thấp đến cao</a>
                            <a href="./list_home_desc.php" class="category-item__link">Từ cao đến thấp</a>
                        </li>
                      
                    
                        
                    </ul>
                    <select name="facilities" onchange="location = this.value;" class="tienghi_list">
                        <option value="list_home.php">Chọn tiện nghi</option>
                        <option value="list_home.php">Tất cả</option>
                        <option value="wifi.php">Wifi</option>
                        <option value="maylanh.php">Máy lạnh</option>
                        <option value="bancong.php">Ban công</option>
                        <option value="maygiat.php">Máy giặt</option>
                        <option value="noithat.php">Có nội thất</option>
                    </select>
                </nav>
            </div>
            <div class="grid__column-10">
               
                <div class="home-product">
                    <div class="grid__row ">
                    <?php 
                            if ($result->num_rows > 0) {
                                while($row = $result-> fetch_assoc()) {
                                    // if(isset($row['nhom']) == 1){
                        ?>
                            <div class="grid__column-2-4 ">  
                                <button href="" class="nav-link" id="home_l">

                                    <div class="home-product-item"  href="../detail/list_home.php?id_product=<?=$row['id_pt']?>&idcategory=<?=$row['id_loai']?>" class="product-item__link">
                                    <!-- <div class="home-pruduct-item__img" style="background-image: url(https://cdn1.viettelstore.vn/images/Product/ProductImage/medium/1675652850.jpeg);"></div> -->
                                        <img src="../img/<?= $row['anh'] ?>" class="w-100" style="    height: 170px;" alt="<?= $row['ten_pt']?>"/>
                                    <!-- <img src="https://images.lacartedescolocs.fr/tipis-listing-pictures/listing-2bca74d7e4081a6e80283ae0b6b7b592/2594345/medium.jpg" class="w-100" alt="<?= $row['ten_xe']?>"/> -->
                                    
                                    <h2 class="home-pruduct-item__name fw-bold"> <?= $row['hoten'] ?></h2>
                                    <h4 class="home-pruduct-item__name">Địa chỉ: <?= $row['dia_chi'] ?> </h4>
                                    <p class="home-pruduct-item__name"><?= $row['mo_ta'] ?></p>
                                    <div class="home-pruduct-item__price">
                                        <span class="home-pruduct-item__price-mới"><span class="fw-bold" style="color: #000; font-size: 20px;"><?= number_format($row['gia']) ?></span> /tháng </span>   
                                        
                                    </div> 
                                   
                                    
                                    <?php 
                                    echo'
                                    <a href="../detail/list_home.php?id='.$row["id_pt"].'" class="submit nav-link" > 
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
                            <?php }} 
                        // }
                         ?>
                     

            </div>
        </div>
      </div>
      </div>
</div>
</div>

    <!-- login -->
<div class="home_lgin2" id="home_lgin">

<div class="home_lg2 text-center" id="home_lg2" >

  <div class="home_lg2" id="home_lg2">
    <div class="click_x">
        <a href="./list_home.php">

            <button id="click_x_lg" class="fw-bold">
                <i class="fa-solid fa-times "></i>              
            </button>
        </a>
            </div>
            <h2>Bảng đồ các địa điểm nhà trọ</h2>
        <div id="map"></div>
  

      </div>
</div>

</div>






<!-- map -->
<?php

                    $markers = array();
                    while($row = mysqli_fetch_array($result_map,MYSQLI_BOTH)) {
                        $address = $row['dia_chi'];
                        $hoten = $row['hoten'];

                        $markers[] = array(
                            'diachi' => $address,
                            'hoten' => $hoten
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
                        // var map = L.map('map').setView([<?php echo $latitude; ?>, <?php echo $longitude; ?>], 13);
                        var map = L.map('map').setView([<?php echo $markers[0]['latitude']; ?>, <?php echo $markers[0]['longitude']; ?>], 13);
                        // Thêm lớp bản đồ OpenStreetMap
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                        }).addTo(map);

                        // Thêm một marker tại tọa độ của địa chỉ
                        // L.marker([<?php echo $latitude; ?>, <?php echo $longitude; ?>]).addTo(map)
                        // .bindPopup("<?php echo $address; ?>");
                        // Thêm các marker tại tọa độ của từng địa chỉ
                        <?php foreach ($markers as $marker) { ?>
                            L.marker([<?php echo $marker['latitude']; ?>, <?php echo $marker['longitude']; ?>]).addTo(map)
                            .bindPopup("<?php echo $marker['diachi']; ?>");
                            L.marker([<?php echo $marker['latitude']; ?>, <?php echo $marker['longitude']; ?>]).addTo(map)
                            .bindPopup("<?php echo $marker['hoten']; ?>");
                            
                        <?php } ?>
                    </script>












<footer>
    <div class="footer" style="background-image: url('https://www.lacartedescolocs.fr/assets/backgrounds/header_bg-8e48a21d4f3b4e87d988fbc77732705322506141957f1fe09e088dbde7f58ff6.png');"></div>
</footer>
<script src="../main.js"></script>
<script src="https://code.jquery.com/ui/1.14.0/jquery-ui.js"></script>


</body>
</html>
