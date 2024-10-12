<?php 
require_once('../ConnectDB/connectDB.php');
require_once('../Library/library.php');
ob_start();
session_start();
$idCustomer=0;
if (isset($_SESSION['nguoidung'])) {
    $conn = connectDB();
    $idCustomer = $_SESSION['nguoidung']['id_nd']??0;
    $result = $conn -> query("SELECT * FROM nguoi_dung WHERE id_nd = ".$idCustomer."");
    $row = $result -> fetch_assoc();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CO'House</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="./home.css">
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
                        <li class="nav-item_home active">
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
                        <div class="account" style=" margin-top: -27px !important;">
                    
                                <?php disLogin(1)?>
                        </div>
                      
                     
                    </ul>
            
        </div>
    </header>
<div class="container_list">
    <div class="list_home text-center">
        <h2 style="font-size: 18px;">BẠN ĐANG TÌM NGƯỜI THUÊ NHÀ HAY BẠN CÙNG PHÒNG?</h1>
        <h2 style="font-size: 16px;">Đăng tin miễn phí trong vòng chưa đầy 5 phút:</h2>

        <form id="form__input__category" action="" method="post" enctype="multipart/form-data">    
                
            <div class="form__group code__product"  >
                <div class="form_icon">
                     <i class="fa-solid fa-map-marker "></i>
                     <label for="" class="map">Địa Chỉ </label>
                </div>
                <div class="form_cho">
                        <label for="" class="">Thành phố:</label>
                        <select name="tp" id="inp__category" >
                            <option value="">-- Chọn TP --</option>
                            <?php 
                                                    $conn = connectDB();
                                                    $result = $conn -> query("SELECT * FROM thanh_pho");
                                                    if ($result->num_rows > 0) {
                                                        while($row = $result->fetch_assoc()){
                                                            echo'
                                                                <option value="'.$row['id_tp'].'">'.$row['ten_tp'].'</option>
                                                            ';
                                                        }
                                                    }
                                                ?>
                        </select>
                    </div>
                    <div class="form_cho" style="margin-left: 130px;">
                        <label for="" class="">Quận:</label>
                        <select name="cq" id="inp__category" >
                            <option value="">-- Chọn Quận --</option>
                            <?php 
                                                    $conn = connectDB();
                                                    $result = $conn -> query("SELECT * FROM quan");
                                                    if ($result->num_rows > 0) {
                                                        while($row = $result->fetch_assoc()){
                                                            echo'
                                                                <option value="'.$row['id_quan'].'">'.$row['ten_quan'].'</option>
                                                            ';
                                                        }
                                                    }
                                                ?>
                        </select>
                    </div>
                    <div class="form_cho" style="margin-left: 113px;">
                        <label for="" class="">Phường:</label>
                        <select name="phuong" id="inp__category" >
                            <option value="">-- Chọn Phường --</option>
                            <?php 
                                                    $conn = connectDB();
                                                    $result = $conn -> query("SELECT * FROM phuong");
                                                    if ($result->num_rows > 0) {
                                                        while($row = $result->fetch_assoc()){
                                                            echo'
                                                                <option value="'.$row['id_phuong'].'">'.$row['ten_phuong'].'</option>
                                                            ';
                                                        }
                                                    }
                                                ?>
                        </select>
                    </div>
                <div class="form_in">
                    <input type="text" id="valCategory" name="dc"  placeholder="Ví dụ: 91B" />

                </div>
            </div>
            
            <div class="form__group code__product"  >
                <div class="form_icon">
                     <i class="fa-solid fa-home "></i>
                     <label for="" class="map">Chổ Ở </label>
                </div>
                <div class="form_in">
                    <div class="form_cho">
                        <label for="" class="">Loại chổ ở:</label>
                        <select name="cho_o" id="inp__category" >
                            <option value="">-- Chọn Loại SP --</option>
                            <?php 
                                                    $conn = connectDB();
                                                    $result = $conn -> query("SELECT * FROM loai");
                                                    if ($result->num_rows > 0) {
                                                        while($row = $result->fetch_assoc()){
                                                            echo'
                                                                <option value="'.$row['id_loai'].'">'.$row['ten_loai'].'</option>
                                                            ';
                                                        }
                                                    }
                                                ?>
                        </select>
                    </div>
                    <div class="form_dt">
                        <label for="" class="">Diện tích: </label>
                        <input type="number" id="valdt" class="dt" name="dt" value=""placeholder="m²"  />
                    </div>
                    <div class="form_dt" style="padding-top: 6px;margin-left: 77px;">
                        <label for="" class="">Tên chổ ở: </label>
                        <input type="text" id="valdt" class="dt" name="ten" value=""placeholder="Nhập tên chổ ở"  />
                    </div>
                </div>
            </div>
            <div class="form__group code__product"  >
                <div class="form_icon" style="    margin-left: 0px !important;">
                     <i class="fa-solid fa-plus "></i>
                     <label for="" class="map">Tiện Nghi Chung</label>
                </div>
                <div class="form_in">
                        <div class="form_in_check" style="    float: right;     display: flex; justify-content: center;">
                    <div class="checkbox_con" style=" float: left;">
                        
                        <div class="form_tn">
                            <input type="checkbox" id="valdt" class="dt" name="tnc[]" value="Máy giặt"placeholder="m" style="width: 60px   !important;" />
                            <label for="">Máy giặt</label>               
                        </div>
                        <div class="form_tn" style="    padding-left: 3px;">
                            <input type="checkbox" id="valdt" class="dt" name="tnc[]" value="Ban công"placeholder="m" style="width: 60px   !important;" />
                            <label for="">Ban công</label>               
                        </div>
                        
                    </div>
                    <div class="checkbox_con" style=" float: right;">
                      
                        <div class="form_tn" style="padding-left: 118px;">
                            <input type="checkbox" id="valdt" class="dt" name="tnc[]" value="Nhà để xe"placeholder="m" style="width: 60px   !important;" />
                            <label for="">Nhà để xe</label>               
                        </div>
                        <div class="form_tn" style="padding-left: 162px;">
                            <input type="checkbox" id="valdt" class="dt" name="tnc[]" value="Khu vực phơi đồ"placeholder="m" style="width: 60px   !important;" />
                            <label for="">Khu vực phơi đồ</label>               
                        </div>
                    </div>
                    
                </div>
                </div>
            </div>

            <div class="form__group code__product"  >
                <div class="form_icon" style="    margin-left: 0px !important;">
                     <i class="fa-solid fa-plus "></i>
                     <label for="" class="map">Tiện Nghi Phòng</label>
                </div>
                <div class="form_in">
                        <div class="form_in_check" style="    float: right;     display: flex; justify-content: center;">
                    <div class="checkbox_con" style=" float: left;">
                        <div class="form_tn" style="padding-left: 1px;">
                            <input type="checkbox" id="valdt" class="dt" name="tn[]" value="Máy lạnh"placeholder="m" style="width: 60px   !important;    " />
                            <label for="">Máy lạnh</label>               
                        </div>
                        <div class="form_tn">
                            <input type="checkbox" id="valdt" class="dt" name="tn[]" value="Máy giặt"placeholder="m" style="width: 60px   !important;" />
                            <label for="">Máy giặt</label>               
                        </div>
                        <div class="form_tn" style="    padding-left: 4px;">
                            <input type="checkbox" id="valdt" class="dt" name="tn[]" value="Ban công"placeholder="m" style="width: 60px   !important;" />
                            <label for="">Ban công</label>               
                        </div>
                        
                    </div>
                    <div class="checkbox_con" style=" float: right;">
                        <div class="form_tn" style="padding-left: 122px;">
                            <input type="checkbox" id="valdt" class="dt" name="tn[]" value="Có nội thất"placeholder="m" style="width: 60px   !important;" />
                            <label for="">Có nội thất</label>               
                        </div>
                        <div class="form_tn" style="padding-left: 72px;">
                            <input type="checkbox" id="valdt" class="dt" name="tn[]" value="Wifi"placeholder="m" style="width: 60px !important;" />
                            <label for="">Wifi</label>               
                        </div>
                      
                    </div>
                    
                </div>
                </div>
            </div>

            <div class="form__group code__product"  >
                <div class="form_icon">
                     <i class="fa-solid fa-balance-scale "></i>
                     <label for="" class="map">Quy Định </label>
                </div>
                <div class="form_in_check" style="    float: right;">
                    <div class="checkbox_con" style=" float: left;">
                        <div class="form_tn" style="padding-left: 12px;">
                            <input type="checkbox" id="valdt" class="dt" name="qd[]" value="Chỉ giành cho nam"placeholder="m" style="width: 60px   !important;    " />
                            <label for="">Chỉ giành cho nam</label>               
                        </div>
                        <div class="form_tn">
                            <input type="checkbox" id="valdt" class="dt" name="qd[]" value="Chỉ giành cho nữ"placeholder="m" style="width: 60px   !important;" />
                            <label for="">Chỉ giành cho nữ</label>               
                        </div>
                    </div>
                    <div class="checkbox_con" style=" float: right;">
                        <div class="form_tn">
                            <input type="checkbox" id="valdt" class="dt" name="qd[]" value="Cho nuôi thú cưng"placeholder="m" style="width: 60px   !important;" />
                            <label for="">Cho nuôi thú cưng</label>               
                        </div>
                        <div class="form_tn" style="padding-left: 72px;">
                            <input type="checkbox" id="valdt" class="dt" name="qd[]" value="Cho phép dẫn bạn về phòng"placeholder="m" style="width: 60px !important;" />
                            <label for="">Cho phép dẫn bạn về phòng</label>               
                        </div>
                    </div>
                </div>
            </div>

            <div class="form__group code__product"  >
                <div class="form_icon">
                     <i class="fa-solid fa-bed bed"></i>
                     <label for="" class="map">Phòng Ngủ </label>
                </div>
                <div class="form_in">
                    
                    <div class="form_dt" style="    margin-right: 57px;">
                        <label for="" class="">Diện tích phòng: </label>
                        <input type="number" id="valdt" min="1" max="99" class="dt" name="dtp" value=""placeholder="m²"  />
                        
                    </div>
                    <div class="form_gd" style="    padding-top: 10px;">
                        <label for="" class="">Giá điện: </label>
                        <input type="text" id="valdt"  class="dt" name="gd" value=""placeholder="Nhập giá điện"  />
                        
                    </div>
                    <div class="form_gn"  style="    padding-top: 10px;margin-left: 121px;">
                        <label for="" class="">Giá nước: </label>
                        <input type="text" id="valdt"  class="dt" name="gn" value=""placeholder="Nhập giá nước"  />
                        
                    </div>
                    <div class="form_gn"  style="    padding-top: 10px;margin-left: 66px;">
                        <label for="" class="">Số người đang ở: </label>
                        <input type="number" id="valdt"  class="dt" name="sln" value=""placeholder="Nhập số người đang ở"  />
                        
                    </div>
                </div>
            </div>
       
            <div class="form__group code__product"  >
                <div class="form_icon">
                     <i class="fa-solid fa-tablet"></i>
                     <label for="" class="map">Bài Đăng </label>
                </div>
                <div class="form_in">
                   <div class="form_em"  style="     margin-left: 149px; ">
                        <label for="" class="":>Ngày thuê trống: </label>
                        <input type="date" id="valdt"  class="dt" name="ngay" value=""placeholder="Nhập ngày thuê trống"  />
                        
                    </div>
                    <div class="form_em"  style="     margin-left: 131px; padding-top: 10px;">
                        <label for="" class="">Thời gian cho thuê: </label>
                        <input type="text" id="valdt"  class="dt" name="tgct" value=""placeholder="Nhập thời gian cho thuê"  />
                        
                    </div>
                    <div class="form_lh"  style=" padding-top: 10px;     margin-left: 242px; ">
                        <label for="" class="">Giá: </label>
                        <input type="text" id="valdt"  class="dt" name="gia" value=""placeholder="Nhập giá phòng"  />
                        
                    </div>
                 
                    <div class="form_lh"  style=" padding-top: 10px;  ">
                    <textarea rows="6" cols="70" name="mota" class="dt" id="product_desc" placeholder="Nhập Mô Tả Bài Đăng"></textarea>

                    </div>
                </div>
            </div>


            <div class="form__group code__product"  >
                <div class="form_icon">
                     <i class="fa-solid fa-camera"></i>
                     <label for="" class="map">Hình Ảnh </label>
                </div>
                <div class="form_in">
                   <div class="form_em"  style="     margin-left: 149px; ">
                        <input style="margin: 33px;" type="file" name="files[]" id="inp__img" class="valInp" onchange="preview()" accept=".jpg, .jpeg, .png, .jfif" multiple />


                    </div>
                   
                </div>

                
            </div>
            <!-- end img__category -->
            
            <div class="bnt_category">
            <button id="bnt_add" class="bnt_add" name="bnt_insert_data" value="Thêm Mới">Thêm mới</button>
            </div>
            <!-- end bnt_category -->


            
         </form>
                                             <?php 
                                                // insert data
                                                $conn = connectDB();
                                                if (isset($_POST['bnt_insert_data']) and $_POST['bnt_insert_data'] == 'Thêm Mới') {
                                                    $diachi = $_POST['dc']; // nameProduct
                                                    //  price product
                                                    $dtp = $_POST['dtp'];
                                                    $gd = $_POST['gd'];
                                                    $gn = $_POST['gn'];
                                                    // $email = $_POST['email'];
                                                    // $sdt = $_POST['sdt'];
                                                    $ngay = $_POST['ngay'];
                                                    $mota = $_POST['mota'];
                                                    $dt = $_POST['dt'];
                                                    $cho = $_POST['cho_o']; 
                                                    $tgct = $_POST['tgct']; 
                                                    $gia = $_POST['gia']; 
                                                    $ttp = $_POST['ttp']; 
                                                    $phuong = $_POST['phuong']; 
                                                    $sln = $_POST['sln']; 
                                                    $ten = $_POST['ten']; 

                                                    $tn = $_POST['tn'];
                                                    $a=implode(',',$tn);
                                                    $qd = $_POST['qd'];
                                                    $b=implode(',',$qd);
                                                    $tnc = $_POST['tnc'];
                                                    $c=implode(',',$tnc);
                                                   
                                                    // INSERT INTO `bai_dang` (`id_bd`, `id_nd`, `mo_ta`, `ngay_dang`, `ngay_thue_trong`, `trang_thai`) VALUES (NULL, '10', 'dđ', '2024-08-14', '2024-08-21', 'ok');

                                                    $sql = $conn->query("INSERT INTO bai_dang VALUES (null,'$idCustomer','$mota',now(),'$ngay','1','0')");
                                            //    var_dump($sql);die();
                                                    if ($sql) { 
                                                        echo '<span class="notification__success">Bạn Đã Thêm Thành Công !</span>';
                                                       header("Refresh:0");

                                                    } else {
                                                        echo '<span class="notification__fail">Không Thể Thêm Sản Phẩm Này. Vui lòng thử lại !</span>';
                                                    }


                                                    //cho o
                                                   
                                                       $sqlSelectBD = $conn->query("SELECT * FROM bai_dang order by id_bd desc");
                                                       $sqlSelectBD = $sqlSelectBD->fetch_all(MYSQLI_ASSOC);
                                                       if(!empty($sqlSelectBD)){
                                                           $id_bd = $sqlSelectBD[0]['id_bd'] ?? 0;
                                                           $sql_O = $conn->query("INSERT INTO cho_o VALUES(null,'$cho','$idCustomer','$id_bd',' $phuong','$diachi','$dt','$ten')");
                                                       }

                                                        //phong
                                                
                                                        $sqlSelectCho = $conn->query("SELECT * FROM cho_o order by id_cho desc");
                                                        $sqlSelectCho = $sqlSelectCho->fetch_all(MYSQLI_ASSOC);
                                                        if(!empty($sqlSelectCho)){
                                                            $id_cho = $sqlSelectCho[0]['id_cho'] ?? 0;
                                                            $sql_P= $conn->query("INSERT INTO phong VALUES(null,'$id_cho','$dtp','$gd','$gn','$mota','$sln')");
                                                        }

                                                         //baidangphong
                                                        //  $sqlSelectBD = $conn->query("SELECT * FROM bai_dang order by id_bd desc");                                      
                                                         $sqlSelectP = $conn->query("SELECT * FROM phong order by id_pt desc");
                                                         $sqlSelectP = $sqlSelectP->fetch_all(MYSQLI_ASSOC);
                                                         if(!empty($sqlSelectCho) && !empty($sqlSelectBD)){
                                                             $id_P = $sqlSelectP[0]['id_pt'] ?? 0;
                                                               $id_bd = $sqlSelectBD[0]['id_bd'] ?? 0;
                                                             $sql_P= $conn->query("INSERT INTO bai_dang_phong VALUES('$id_bd','$id_P','$gia','$tgct')");
                                                         }

                                                         //hinh anh
                                                         if(!empty($sqlSelectP)){
                                                            for($i = 0; $i < count($_FILES['files']['tmp_name']); $i++) {
                                                                 $id_P = $sqlSelectP[0]['id_pt'] ?? 0;
                                                                $tmp_name = $_FILES['files']['tmp_name'][$i];
                                                                $name = $_FILES['files']['name'][$i];
                                                                move_uploaded_file($tmp_name, "img/". $name);
                                                                $is_thumbnail = $i == 0 ? 1 : 0;
                                                                $sqlHinhAnh = $conn->query("INSERT INTO hinh_anh VALUES(null,'$id_P','$name','$is_thumbnail')");
                                                            }
                                                        }

                                                            //tiennghi
                                                        //  $sqlSelectBD = $conn->query("SELECT * FROM bai_dang order by id_bd desc");                                      
                                                        // $sqlSelectP = $conn->query("SELECT * FROM phong order by id_pt desc");
                                                        // $sqlSelectP = $sqlSelectP->fetch_all(MYSQLI_ASSOC);
                                                        if(!empty($sqlSelectP)){
                                                            $id_P = $sqlSelectP[0]['id_pt'] ?? 0;
                                                            $sql_P= $conn->query("INSERT INTO tien_nghi VALUES(null,'$a','$id_P')");
                                                        }

                                                        if(!empty($sqlSelectP)){
                                                            $id_P = $sqlSelectP[0]['id_pt'] ?? 0;
                                                            $sql_P= $conn->query("INSERT INTO quy_dinh VALUES(null,'$b','$id_P')");
                                                        }

                                                        //tiennghichung
                                                        $sqlSelectCho = $conn->query("SELECT * FROM cho_o order by id_cho desc");
                                                        $sqlSelectCho = $sqlSelectCho->fetch_all(MYSQLI_ASSOC);
                                                        if(!empty($sqlSelectCho)){
                                                            $id_cho = $sqlSelectCho[0]['id_cho'] ?? 0;

                                                            $sql_TN= $conn->query("INSERT INTO tien_nghi_chung VALUES(null,'$c','$id_cho')");
                                                        }
                                                }
                                                ?>
    </div>
</div>


<footer>
    <div class="footer" style="background-image: url('https://www.lacartedescolocs.fr/assets/backgrounds/header_bg-8e48a21d4f3b4e87d988fbc77732705322506141957f1fe09e088dbde7f58ff6.png');"></div>
</footer>
<!-- <script src="../main.js"></script> -->

</body>
</html>
<?php }  else {
    echo "<script>alert('Bạn hãy đăng nhập để vào hệ thống!'); window.location.href = '../index.php';</script>";
}
?>