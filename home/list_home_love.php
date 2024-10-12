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
// Kiểm tra nếu người dùng đã đăng nhập
if (isset($_SESSION['nguoidung'])) {
    $idCustomer = $_SESSION['nguoidung']['id_nd']; // Giả sử id được lưu trong session


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
} elseif (isset($_GET['idphuong'])) {
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
} else {
    $result = $conn->query("SELECT ttbl.nhom,co.ten_co,bd.id_bd, p.id_pt, nd.hoten, co.dia_chi, bd.mo_ta, bdp.gia, ha.anh_dai_dien, ha.anh, nd.id_nd
     FROM cho_o co INNER JOIN nguoi_dung nd INNER JOIN bai_dang bd INNER JOIN bai_dang_phong bdp INNER JOIN phong p INNER JOIN hinh_anh ha INNER JOIN tt_binh_luan ttbl
      ON co.id_bd = bd.id_bd AND co.id_nd = nd.id_nd AND nd.id_nd = bd.id_nd AND bdp.id_bd = bd.id_bd AND p.id_pt = ha.id_pt AND p.id_cho = co.id_cho AND ttbl.id_pt = p.id_pt
     WHERE ha.anh_dai_dien = 1 AND ttbl.nhom = 1
     LIMIT $start_from, $records_per_page;");
}

$category = $conn->query("SELECT * FROM loai");
$phuong = $conn->query("SELECT * FROM phuong");


    // Đếm số bình luận
    $tb = "SELECT count(bl.id_pt) as soluong FROM tt_binh_luan bl WHERE bl.id_nd = $idCustomer;";
    $resulttb = mysqli_query($conn, $tb);
    $rowtb = mysqli_fetch_array($resulttb);
    $tongtb = $rowtb['soluong'];



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CO'House</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="./home.css">
    <link rel="stylesheet" href="./love.css">
    <link rel="stylesheet" href="./home_list.css">
    <link rel="stylesheet" href="./main.css">
    <link rel="stylesheet" href="./base.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css">
<style>
       #map {
      height: 500px;
      width: 100%;
    }
    .card{
        border: 2px solid #ccc; 
    }
    .card_check{
        border: 3px solid red;
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
    </header>
<div class="container_list_home" >
<div class="grid">
        <div class="grid__row app__content">
             
            <div class="grid__column-10">
               
                <div class="home-product">
                    <div class="row" id="btn_compare" style="display: none;">
                             <div class="col-sm-12">

                                 <form action="compare.php" method="post" >
                                     <input type="hidden" id="card_one" name="card_one"/>        
                                     <input type="hidden" id="card_two" name="card_two"/>     
                                     <input type="submit" value="So sánh" class="btn btn-success" style="float: right;    padding: 0;  width: 90px;">   
                                    </form>
                                </div>           
                    </div>

                    <div class="grid__row ">
                    <?php 
                            if ($result->num_rows > 0) {
                                while($row = $result-> fetch_assoc()) {
                                    // if(isset($row['anh_dai_dien']) == 1){
                        ?>
                            <div class="grid__column-2-4 ">  
                                
                                
                                <div class="home-product-item card compare_card<?= $row['id_bd'] ?>"  href="../detail/list_home.php?id_product=<?=$row['id_pt']?>&idcategory=<?=$row['id_loai']?>" class="product-item__link">
                                    <form id="form__input__product" action="" method="post" enctype="multipart/form-data">
                                            <button class="exit_home" name="delete" type="submit" value="<?= $row['id_pt'] ?>">Xóa</button>
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
                                    
                                </form>
                                <button class="submit nav-link sub_user compare" rel="<?= $row['id_bd'] ?>" style="margin-bottom: 10px;">So sánh</button>
                            </div>  

                            </div>
                            <?php }}  
                              if(isset($_POST['delete'])) {
                                $valSP = $_POST['delete'];
                                $conn = connectDB();

                                // xóa sản phẩm
                                $resultFinal = $conn -> query("DELETE FROM tt_binh_luan WHERE id_pt = ".$valSP."");
                                if ($resultFinal) {
                                    echo '<span class="notification__success">Xóa Thành Công !</span>';
                                    header('Refresh:1');

                                } else {
                                    echo '<span class="notification__fail">Xóa Thất Bại !</span>';
                                }

                            }
                            ?>
                     

            </div>
        </div>
      </div>
      </div>
</div>
</div>
<!-- ss -->
<script>
$(document).ready(function(){
    $(document).on('click', '.compare', function() {
        var id = $(this).attr('rel');
        var size_class = $('.card_check').length;

        if (size_class >= 2) {
            if ($(".compare_card" + id).hasClass("card_check")) {
                $(".compare_card" + id).removeClass("card_check");
                if ($('#card_one').val() === id) {
                    $('#card_one').val('');
                } else if ($('#card_two').val() === id) {
                    $('#card_two').val('');
                }
            } else {
                alert("Bạn chỉ có thể so sánh tối đa 2 sản phẩm.");
            }
        } else {
            if (size_class > 0) {
                $('#btn_compare').show();
            }

            if ($(".compare_card" + id).hasClass("card_check")) {
                $(".compare_card" + id).removeClass("card_check");
                if ($('#card_one').val() === id) {
                    $('#card_one').val('');
                } else if ($('#card_two').val() === id) {
                    $('#card_two').val('');
                }
            } else {
                $(".compare_card" + id).addClass("card_check");

                var pro1 = $('#card_one').val();
                var pro2 = $('#card_two').val();
                if (pro1 === "") {
                    $('#card_one').val(id);
                } else if (pro2 === "") {
                    $('#card_two').val(id);
                }
            }
        }
    });
});
</script>

<style>
.compare.selected {
    background-color: #007bff; /* Màu nền khi được chọn */
    color: #ffffff; /* Màu chữ khi được chọn */
}
</style>
    <!-- login -->
    <?php 

// Hiển thị phân trang
echo "<div class='pagination'>";
if ($page > 1) {
    echo "<a href='?page=" . ($page - 1) . "'>Trước</a> ";
}

for ($i = 1; $i <= $total_pages; $i++) {
    if ($i == $page) {
        echo "<strong>$i</strong> "; // Trang hiện tại
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
<?php 
} else {
    $tongtb = 0; // Nếu chưa đăng nhập, số bình luận là 0
    echo "<script>alert('Bạn hãy đăng nhập để vào hệ thống!'); window.location.href = '../index.php';</script>";
    
}
?>
</html>
