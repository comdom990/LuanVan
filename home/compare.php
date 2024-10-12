<?php
// Kết nối cơ sở dữ liệu
require_once('../ConnectDB/connectDB.php');
require_once('../Library/library.php');
$conn = connectDB();
ob_start();
session_start();



// Lấy ID sản phẩm từ form
$productId1 = $_POST['card_one'];
$productId2 = $_POST['card_two'];

// Truy vấn thông tin sản phẩm
$sql = "SELECT bd.id_bd,p.id_pt, nd.hoten,co.dia_chi,bd.mo_ta,bdp.gia,ha.anh,nd.id_nd,tn.ten_tiennghi,p.dien_tich_phong,p.gia_dien,p.gia_nuoc,qd.ten_quydinh,l.ten_loai,nd.sdt
         FROM cho_o co inner join nguoi_dung nd inner join bai_dang bd inner join bai_dang_phong bdp inner join phong p INNER join hinh_anh ha INNER JOIN tien_nghi tn INNER JOIN quy_dinh qd INNER JOIn loai l
        ON co.id_loai = l.id_loai and qd.id_pt = p.id_pt and tn.id_pt = p.id_pt and co.id_bd = bd.id_bd and co.id_nd = nd.id_nd and nd.id_nd = bd.id_nd and bdp.id_bd = bd.id_bd and p.id_pt = ha.id_pt and p.id_cho = co.id_cho WHERE ha.anh_dai_dien = 1 and bd.id_bd IN ('$productId1', '$productId2')";
$result = $conn->query($sql);

$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>So Sánh Sản Phẩm</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="./home.css">
    <link rel="stylesheet" href="./home_list.css">
    <link rel="stylesheet" href="./main.css">
    <link rel="stylesheet" href="./base.css">
    <link rel="stylesheet" href="./com.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css">
<!-- map-->

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <style>
        .product-card {
            border: 1px solid #ccc;
            padding: 15px;
            margin: 10px;
            border-radius: 6px;
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
      
    </header>
<div class="container">
    <h1 class="my-4">So Sánh Nhà Trọ</h1>
    <div class="row">
        <?php if (count($products) === 2): ?>
            <?php foreach ($products as $product): ?>
                <div class="col-md-6">
                    <div class="product-card ">
                        <img src="../img/<?= $product['anh'] ?>" class="img-fluid img-compa" alt="<?= $product['ten_pt'] ?>">
                        <h2><?= $product['ten_pt'] ?></h2>
                        <p><strong>Giá: </strong> <span style="color: red;"><?= number_format($product['gia']) ?> VNĐ</span></p>
                        <p><strong>Người cho thuê</strong>: <span> <?= $product['hoten'] ?></span></p>
                        <p><strong>Liên hệ:</strong> <span><?= $product['sdt'] ?></span></p>
                        <p><strong>Mô tả: </strong><span><?= $product['mo_ta'] ?></span></p>
                        <p><strong>Địa chỉ: </strong><span><?= $product['dia_chi'] ?></span></p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Thông Tin</th>
                                    <th>Chi Tiết</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr>
                                    <td><strong>Loại chổ ở:</strong></td>
                                    <td><?= $product['ten_loai'] ?> </td>
                                </tr>
                                <tr>
                                    <td><strong>Diện tích:</strong></td>
                                    <td><?= $product['dien_tich_phong'] ?> m²</td>
                                </tr>
                                <tr>
                                    <td><strong>Giá điện:</strong></td>
                                    <td><?= number_format($product['gia_dien']) ?> VNĐ</td>
                                </tr>
                                <tr>
                                    <td><strong>Giá nước:</strong></td>
                                    <td><?= number_format($product['gia_nuoc']) ?> VNĐ</td>
                                </tr>
                                <tr>
                                    <td><strong>Tiện nghi:</strong></td>
                                    <td><?= $product['ten_tiennghi'] ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Quy định:</strong></td>
                                    <td><?= $product['ten_quydinh'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Không tìm thấy thông tin sản phẩm để so sánh.</p>
        <?php endif; ?>
    </div>
</div>
<footer>
    <div class="footer" style="background-image: url('https://www.lacartedescolocs.fr/assets/backgrounds/header_bg-8e48a21d4f3b4e87d988fbc77732705322506141957f1fe09e088dbde7f58ff6.png');"></div>
</footer>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
