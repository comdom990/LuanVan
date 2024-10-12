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

$idphuong = '';
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
}elseif (isset($_GET['idphuong'])) {
    $idphuong = (int)$_GET['idphuong'];
    $result = $conn->query("SELECT ph.id_phuong,p.id_pt, nd.hoten, co.dia_chi, bd.mo_ta, bdp.gia, ha.anh_dai_dien, ha.anh, nd.id_nd 
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
        ");
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



$sql = "SELECT bd.id_bd,p.id_pt, nd.hoten,co.dia_chi,bd.mo_ta,bdp.gia,ha.anh_dai_dien,ha.anh,nd.id_nd,l.ten_loai,co.dien_tich FROM cho_o co inner join nguoi_dung nd inner join bai_dang bd inner join bai_dang_phong bdp inner join phong p INNER join hinh_anh ha INNER JOIN loai l
        ON co.id_loai = l.id_loai and co.id_bd = bd.id_bd and co.id_nd = nd.id_nd and nd.id_nd = bd.id_nd and bdp.id_bd = bd.id_bd and p.id_pt = ha.id_pt and p.id_cho = co.id_cho WHERE ha.anh_dai_dien = 1";
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

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css" />
<script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>
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
                        <form action="./list_home_map2.php" method="GET" class="d-flex " role="search">
                            <input class="form-control me-2" name="address" type="search" placeholder="Bạn đang tìm chỗ ở ở đâu?" aria-label="Search" required>
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
                            <div class="grid" style="width: 1481px !important;">
                                    <div class="grid__row app__content" style="padding-top: 0 !important;">
                                    
                                        <div class="grid__column-10" style="width:70% !important;">
                                        
                                            <div class="home-product">
                                                <div id="map" style="height: 553px;z-index: 1;"></div>
                                            
                                            </div>
                                        </div>

                            <div class="grid__row" style="width: 30%; height: 75vh; overflow-y: auto; float: right; background-color: white; padding: 10px;">
                                <?php 
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                ?>
                                    <div class="grid__column-2-4 post-info" id="post-info-<?= $row['id_bd'] ?>" style="width: 42% !important;height: 380px !important;">  
                                        <div class="home-product-item card compare_card<?= $row['id_bd'] ?>" href="../detail/list_home.php?id_product=<?=$row['id_pt']?>&idcategory=<?=$row['id_loai']?>" class="product-item__link">
                                            <img src="../img/<?= $row['anh'] ?>" class="w-100" style="height: 170px;" alt="<?= $row['ten_pt']?>"/>
                                            <h2 class="home-pruduct-item__name fw-bold"><?= $row['hoten'] ?></h2>
                                            <h4 class="home-pruduct-item__name">Địa chỉ: <?= $row['dia_chi'] ?></h4>
                                            <p class="home-pruduct-item__name"><?= $row['mo_ta'] ?></p>
                                            <div class="home-pruduct-item__price">
                                                <span class="home-pruduct-item__price-mới"><span class="fw-bold" style="color: #000; font-size: 20px;"><?= number_format($row['gia']) ?></span> /tháng</span>
                                            </div>
                                            <a href="../detail/list_home.php?id=<?= $row['id_pt'] ?>" class="submit nav-link"> 
                                                <div class="sub_user4">Xem thông tin</div>
                                            </a>
                                        </div>  
                                    </div>
                                <?php 
                                    }
                                } 
                                ?>
                            </div>
      </div>
</div>
</div>

  

<?php                  
   
   $markers = array();
   while($row = mysqli_fetch_array($result_map,MYSQLI_BOTH)) {
       $address = $row['dia_chi'];
       $hoten = $row['hoten'];
       $gia = $row['gia'];
       $ten_loai = $row['ten_loai'];
       $dien_tich = $row['dien_tich'];
       $id_pt = $row['id_pt'];
       $id_bd = $row['id_bd'];
       $markers[] = array(
           'diachi' => $address,
           'gia' => $gia,
           'ten_loai' => $ten_loai,
           'dien_tich' => $dien_tich,
           'id_pt' => $id_pt,
           'id_bd' => $id_bd,
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



<footer>
    <div class="footer" style="background-image: url('https://www.lacartedescolocs.fr/assets/backgrounds/header_bg-8e48a21d4f3b4e87d988fbc77732705322506141957f1fe09e088dbde7f58ff6.png');"></div>
</footer>
<script src="../main.js"></script>
<script src="https://code.jquery.com/ui/1.14.0/jquery-ui.js"></script>


                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var map = L.map('map').setView([10.0343, 105.7811], 13);
                
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                        }).addTo(map);
                     // Initialize marker cluster group here
        var markerClusterGroup = L.markerClusterGroup();
            map.addLayer(markerClusterGroup);
                        let markers = [];
                        <?php foreach ($markers as $marker): ?>
                            (function() {
                                let marker = L.marker([<?php echo $marker['latitude']; ?>, <?php echo $marker['longitude']; ?>]).addTo(map)
                                    .bindPopup("<strong>Địa chỉ:</strong> <?php echo htmlspecialchars($marker['diachi']); ?><br>" +
                                                "<strong>Họ tên chủ:</strong> <?php echo htmlspecialchars($marker['hoten']); ?><br>" +
                                                "<strong>Loại:</strong> <?php echo htmlspecialchars($marker['ten_loai']); ?><br>" +
                                                "<strong>Diện tích:</strong> <?php echo htmlspecialchars($marker['dien_tich']); ?> m²<br>" +
                                                "<strong>Giá:</strong> <?php echo htmlspecialchars(number_format($marker['gia'])); ?> VNĐ / tháng<br>", 
                                                { closeButton: false });
                
                                markers.push(marker);  
                
                                let postInfoId = 'post-info-<?= $marker['id_bd']; ?>';
                                let postInfoElement = document.querySelector(`#${postInfoId}`);
                                
                                if (postInfoElement) {
                                    postInfoElement.addEventListener('mouseover', function() {
                                        marker.openPopup();
                                        map.setView(marker.getLatLng(), 15); 
                                        this.classList.add('hover'); 
                                    });
                
                                    postInfoElement.addEventListener('mouseout', function() {
                                        marker.closePopup(); 
                                        this.classList.remove('hover'); 
                                    });
                                }
                         marker.on('mouseover', function(e) {
                            this.openPopup();
                            document.querySelector('#post-info-<?= $marker['id_bd']; ?>').classList.add('hover');
                        });
                
                       marker.on('mouseout', function(e) {
                            this.closePopup();
                
                            document.querySelector('#post-info-<?= $marker['id_bd']; ?>').classList.remove('hover');
                        });
                                // Sự kiện click để chuyển đến trang chi tiết
                                marker.on('click', function() {
                                    window.location.href = "../detail/list_home.php?id=<?php echo $marker['id_pt']; ?>";
                                });
                            })();
                        <?php endforeach; ?>
       // Search functionality
   

<?php if (isset($_GET['address'])): ?>
                var address = "<?php echo htmlspecialchars($_GET['address']); ?>";
                var url = "https://nominatim.openstreetmap.org/search?q=" + encodeURIComponent(address) + "&format=json&limit=1";

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            var lat = data[0].lat;
                            var lon = data[0].lon;
                            map.setView([lat, lon], 13);

                            // Clear existing markers and circles
                            markerClusterGroup.clearLayers();

                            // Create a marker for the searched location
                            var searchMarker = L.marker([lat, lon]).bindPopup("<strong>Tên địa điểm:</strong> " + data[0].display_name + "<br><strong>Địa chỉ:</strong> " + address).openPopup();
                            markerClusterGroup.addLayer(searchMarker); // Add to cluster group

                            // Create a circle around the searched location
                            var radius = 1000; // Set the radius in meters
                            var circle = L.circle([lat, lon], {
                                color: 'blue',
                                fillColor: '#30f',
                                fillOpacity: 0.5,
                                radius: radius // Radius in meters
                            }).addTo(map);

                            // Optional: Add a popup to the circle
                            circle.bindPopup("Vòng tròn tìm kiếm: " + radius + " m");
                        } else {
                            alert("Không tìm thấy địa chỉ.");
                        }
                    })
                    .catch(error => console.error('Lỗi:', error));
            <?php endif; ?>
        });
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
