<?php 
require_once('../ConnectDB/connectDB.php');
require_once('../Library/library.php');
ob_start();
session_start();

$conn = connectDB();
$idcategory = '';
if(isset($_GET['idcategory'])){
    $idcategory = $_GET['idcategory'];
    $result = $conn->query("SELECT * FROM cho_o where id_loai = $idcategory");
} else {
    $result = $conn->query("SELECT dia_chi FROM cho_o co ");
} 
$category = $conn->query("SELECT * FROM loai");


$sql = "SELECT dia_chi FROM cho_o ";
$result_map = $conn->query($sql);
?>


<!DOCTYPE html>
<html>
<head>
  <title>Hiển thị địa chỉ trên bản đồ OpenStreetMap</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                    <button class="love_btn">
                    <i class="fa-regular fa-heart oa"></i>
                        <span>Lựa chọn yêu thích</span>
                        <?php echo $tongtb; ?>

                    </button>
                </div>
        </div>
</header>
                    <h1>Hiển thị địa chỉ trên bản đồ OpenStreetMap</h1>
                    <div id="map"></div>

                    <?php
                    
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
                            echo "Tọa độ của địa chỉ '" . $address . "' là: ";
                            echo'<br>';
                            echo "Latitude: " . $latitude . ", Longitude: " . $longitude;
                            $markers[count($markers) - 1]['latitude'] = $latitude;
                            $markers[count($markers) - 1]['longitude'] = $longitude;
                        } else {
                            echo "Không tìm thấy tọa độ của địa chỉ '" . $address . "'.";
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
                        <?php } ?>
                    </script>

  
</body>
</html>