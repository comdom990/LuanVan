<?php 
require_once('../ConnectDB/connectDB.php');
require_once('../Library/library.php');
ob_start();
session_start();



if (isset($_SESSION['nguoidung'])) {
    $conn = connectDB();
    $idCustomer = $_SESSION['nguoidung']['id_nd'];
    $result = $conn -> query("SELECT * FROM nguoi_dung WHERE id_nd = ".$idCustomer."");
    $row = $result -> fetch_assoc();

    // $idP = $_SESSION['nguoidung']['id_pt'];
    // $result = $conn -> query("SELECT * FROM phong WHERE id_pt = ".$idP."");
    // $row = $result -> fetch_assoc();
 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>O'House</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../home/home.css">
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



      
        <div class="container_home_list">
                <div class="list_modal">
                <?php 
              if(isset($_GET['id'])) {
                global $idProduct;
                $idProduct = $_GET['id'];
                $conn = connectDB();
                $result = $conn -> query("SELECT bdp.thoi_gian_cho_thue,p.so_luong_nguoi, bd.mo_ta,p.id_pt,p.dien_tich_phong,p.gia_dien,p.gia_nuoc,tn.ten_tiennghi,qd.ten_quydinh,nd.hoten,co.dia_chi,bd.mo_ta,bdp.gia,ha.anh_dai_dien,ha.anh,nd.id_nd,nd.gioitinh,l.ten_loai,co.dien_tich,bd.ngay_dang,bd.ngay_thue_trong,tnc.ten_tnc FROM cho_o co inner join quy_dinh qd inner join tien_nghi tn inner join tien_nghi_chung tnc inner join loai l inner join nguoi_dung nd inner join bai_dang bd inner join bai_dang_phong bdp inner join phong p INNER join hinh_anh ha 
                ON tnc.id_cho = co.id_cho and p.id_pt = tn.id_pt and p.id_pt = qd.id_pt and co.id_loai = l.id_loai and co.id_bd = bd.id_bd and co.id_nd = nd.id_nd and nd.id_nd = bd.id_nd and bdp.id_bd = bd.id_bd and p.id_pt = ha.id_pt and p.id_cho = co.id_cho  WHERE p.id_pt = ".$idProduct."");
                if ($result->num_rows > 0) {
                    
                  $row = $result->fetch_assoc();
                
                            echo '
   <div class="container_list">
    <div class="list_home text-center">
    <form id="form__input__category" action="" method="post" enctype="multipart/form-data">    
                  <div class="from_group_item" style="display:none;">
                                                    <label for="">Địa Chỉ:</label>
                                                    <input type="text" required name="id"  value=" '.$row['id_pt'].'">
                                                </div>
            <div class="form__group code__product"  >
                <div class="form_icon">
                     <i class="fa-solid fa-map-marker "></i>
                     <label for="" class="map">Địa Chỉ </label>
                </div>
            

                <div class="form_in">
                    <input type="text" id="valCategory" name="dc"  placeholder="" value="'.$row['dia_chi'].'" />

                </div>
            </div>
            
            <div class="form__group code__product"  >
                <div class="form_icon">
                     <i class="fa-solid fa-home "></i>
                     <label for="" class="map">Chổ Ở </label>
                </div>
                <div class="form_in">
                

                    <div class="form_dt">
                        <label for="" class="">Diện tích: </label>
                        <input type="number" id="valdt" class="dt" name="dt" value="'.$row['dien_tich'].'"placeholder="m²"  />
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
                                <input type="checkbox" name="tnc[]" value="Máy giặt" ' . (in_array("Máy giặt", explode(',', $row['ten_tnc'])) ? 'checked' : '') . ' />
                                
                                <label for="">Máy giặt</label>               
                            </div>
                            <div class="form_tn" style="    padding-left: 3px;">
                                 <input type="checkbox" name="tnc[]" value="Ban công" ' . (in_array("Ban công", explode(',', $row['ten_tnc'])) ? 'checked' : '') . ' /> 
                                <label for="">Ban công</label>               
                            </div>
                            
                        </div>
                        <div class="checkbox_con" style=" float: right;">
                        
                            <div class="form_tn" style="padding-left: 118px;">
                               <input type="checkbox" name="tnc[]" value="Nhà để xe" ' . (in_array("Nhà để xe", explode(',', $row['ten_tnc'])) ? 'checked' : '') . ' />
                                <label for="">Nhà để xe</label>               
                            </div>
                            <div class="form_tn" style="padding-left: 162px;">
                                <input type="checkbox" name="tnc[]" value="Khu vực phơi đồ" ' . (in_array("Khu vực phơi đồ", explode(',', $row['ten_tnc'])) ? 'checked' : '') . ' />
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
                          <input type="checkbox" name="tn[]" value="Máy lạnh" ' . (in_array("Máy lạnh", explode(',', $row['ten_tiennghi'])) ? 'checked' : '') . ' />
                            <label for="">Máy lạnh</label>               
                        </div>
                        <div class="form_tn">
                                 <input type="checkbox" name="tn[]" value="Máy giặc" ' . (in_array("Máy giặc", explode(',', $row['ten_tiennghi'])) ? 'checked' : '') . ' />
                            <label for="">Máy giặt</label>               
                        </div>
                        <div class="form_tn" style="    padding-left: 4px;">
                                 <input type="checkbox" name="tn[]" value="Ban công" ' . (in_array("Ban công", explode(',', $row['ten_tiennghi'])) ? 'checked' : '') . ' />
                            <label for="">Ban công</label>               
                        </div>
                        
                    </div>
                    <div class="checkbox_con" style=" float: right;">
                        <div class="form_tn" style="padding-left: 122px;">
                            <input type="checkbox" name="tn[]" value="Có nội thất" ' . (in_array("Có nội thất", explode(',', $row['ten_tiennghi'])) ? 'checked' : '') . ' /> 
                            <label for="">Có nội thất</label>               
                        </div>
                        <div class="form_tn" style="padding-left: 72px;">
                                 <input type="checkbox" name="tn[]" value="Wifi" ' . (in_array("Wifi", explode(',', $row['ten_tiennghi'])) ? 'checked' : '') . ' />
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
                                <input type="checkbox" name="tn[]" value="Chỉ giành cho nam" ' . (in_array("Chỉ giành cho nam", explode(',', $row['ten_quydinh'])) ? 'checked' : '') . ' />
                            <label for="">Chỉ giành cho nam</label>               
                        </div>
                        <div class="form_tn">
                                <input type="checkbox" name="tn[]" value="Chỉ giành cho nữ" ' . (in_array("Chỉ giành cho nữ", explode(',', $row['ten_quydinh'])) ? 'checked' : '') . ' />
                            <label for="">Chỉ giành cho nữ</label>               
                        </div>
                    </div>
                    <div class="checkbox_con" style=" float: right;">
                        <div class="form_tn">
                                <input type="checkbox" name="tn[]" value="Cho nuôi thú cưng" ' . (in_array("Cho nuôi thú cưng", explode(',', $row['ten_quydinh'])) ? 'checked' : '') . ' />
                            <label for="">Cho nuôi thú cưng</label>               
                        </div>
                        <div class="form_tn" style="padding-left: 72px;">
                                 <input type="checkbox" name="tn[]" value="Cho phép dẫn bạn về phòng" ' . (in_array("Cho phép dẫn bạn về phòng", explode(',', $row['ten_quydinh'])) ? 'checked' : '') . ' />
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
                        <input type="number" id="valdt" min="1" max="99" class="dt" name="dtp" value="'.$row['dien_tich'].'"placeholder="m²"  />  
                        
                    </div>
                    <div class="form_gd" style="    padding-top: 10px;">
                        <label for="" class="">Giá điện: </label>
                        <input type="text" id="valdt"  class="dt" name="gd" value="'.$row['gia_dien'].'" placeholder="Nhập giá điện"  /><span>k</span>
                        
                    </div>
                    <div class="form_gn"  style="    padding-top: 10px;margin-left: 121px;">
                        <label for="" class="">Giá nước: </label>
                        <input type="text" id="valdt"  class="dt" name="gn" value="'.$row['gia_nuoc'].'" placeholder="Nhập giá nước"  /><span>k</span>
                        
                    </div>
                    <div class="form_gn"  style="    padding-top: 10px;margin-left: 66px;">
                        <label for="" class="">Số người đang ở: </label>
                        <input type="number" id="valdt"  class="dt" name="sln" value="'.$row['so_luong_nguoi'].'" placeholder="Nhập số người đang ở"  />
                        
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
                        <input type="date" id="valdt"  class="dt" name="ngay" value="'.$row['ngay_thue_trong'].'"placeholder="Nhập ngày thuê trống"  />
                        
                    </div>
                    <div class="form_em"  style="     margin-left: 131px; padding-top: 10px;">
                        <label for="" class="">Thời gian cho thuê: </label>
                        <input type="text" id="valdt"  class="dt" name="tgct" value="'.$row['thoi_gian_cho_thue'].'"placeholder="Nhập thời gian cho thuê"  />
                        
                    </div>
                    <div class="form_lh"  style=" padding-top: 10px;     margin-left: 242px; ">
                        <label for="" class="">Giá: </label>
                        <input type="text" id="valdt"  class="dt" name="gia" value="'.number_format($row['gia']).'"placeholder="Nhập giá phòng"  /><span>VNĐ</span>
                        
                    </div>
                 
                    <div class="form_lh"  style=" padding-top: 10px;  ">
                    <textarea rows="6" cols="70" name="mota" class="dt" id="product_desc"   placeholder="Nhập Mô Tả Bài Đăng">'.$row['mo_ta'].'</textarea>

                    </div>
                </div>
            </div>


            <div class="form__group code__product"  >
                <div class="form_icon">
                     <i class="fa-solid fa-camera"></i>
                     <label for="" class="map">Hình Ảnh </label>
                </div>';?>
               <div class="form_in">
    <div class="form_em" style="margin-left: 149px;">
        <input style="margin: 33px;" type="file" name="files[]" id="inp__img" class="valInp" onchange="preview()" accept=".jpg, .jpeg, .png, .jfif" multiple />
        
        <div id="file_list">
            <?php 
                // Giả sử $row['anh'] chứa danh sách các tệp hình ảnh đã có, phân cách bằng dấu phẩy
                $existingImages = explode(',', $row['anh']);
                foreach ($existingImages as $image) {
                    $image = trim($image); // Loại bỏ khoảng trắng
                    if (!empty($image)) {
                        echo '<div style="margin: 5px; display: inline-block;">';
                        echo '<img src="../img/' . htmlspecialchars($image) . '" alt="Hình ảnh" style="width: 100px; height: auto;"/>'; // Hiển thị hình ảnh
                        echo '<p>' . htmlspecialchars(basename($image)) . '</p>'; // Hiển thị tên file
                        echo '</div>';
                    }
                }
            ?>
        </div> <!-- Khu vực hiển thị tên file -->
    </div>
</div>
<?php echo'
                
            </div>
          


            
            <button class="bnt_add" type="submit"  name="bnt_add" value="Cập Nhật">Cập Nhật</button>
         </form>
                        </div>
                        </div>
                    
                ';
                }
             
        }

         if (isset($_POST['bnt_add']) and $_POST['bnt_add'] == 'Cập Nhật') {
            $valSP = $_POST['id'];               
            $diachi = $_POST['dc'];
            $date = $_POST['ngay']; // nameProduct
            $giadien = $_POST['gd']; // price product
            $gia = $_POST['gia'];
            $gianuoc = $_POST['gn'];
            $tgct = $_POST['tgct'];
            //  price product
            $dtp = $_POST['dtp'];
            // $email = $_POST['email'];
            // $sdt = $_POST['sdt'];
            $ngay = $_POST['ngay'];
            $mota = $_POST['mota'];
            $dt = $_POST['dt'];
            $sln = $_POST['sln']; 
            $result = $conn->query("UPDATE phong p 
            INNER JOIN bai_dang_phong bdp ON p.id_pt = bdp.id_pt
             INNER JOIN bai_dang bd ON bdp.id_bd = bd.id_bd 
             INNER JOIN cho_o co ON bd.id_bd = co.id_bd 
             INNER JOIN nguoi_dung nd ON co.id_nd = nd.id_nd
              SET p.gia_dien = '".$giadien."', p.gia_nuoc = '".$gianuoc."', bdp.gia = '".$gia."', co.dia_chi = '".$diachi."' , bd.ngay_thue_trong = '".$date."', co.dien_tich = '".$dt."',p.dien_tich_phong = '".$dtp."',p.so_luong_nguoi = '".$sln."',bdp.thoi_gian_cho_thue = '".$tgct."',bd.mo_ta = '".$mota."'
            WHERE p.id_pt = ".$valSP."; ");
            if (!$result) {
                echo '<span class="notification__fail">Sửa Thất Bại !</span>';
            } else {
                echo '<span class="notification__success">Sửa Thành Công !</span>';

              
            }
        }
                  ?>
    </div>
</div>
</div>




   
<footer>
    <div class="footer" style="background-image: url('https://www.lacartedescolocs.fr/assets/backgrounds/header_bg-8e48a21d4f3b4e87d988fbc77732705322506141957f1fe09e088dbde7f58ff6.png');"></div>
</footer>


<script>
function preview() {
    const input = document.getElementById('inp__img');
    const fileList = document.getElementById('file_list');
    
    // Xóa danh sách hiện tại
    fileList.innerHTML = ''; 

    // Hiển thị các tệp đã có sẵn
    <?php 
        foreach ($existingImages as $image) {
            $image = trim($image); // Loại bỏ khoảng trắng
            if (!empty($image)) {
                echo 'fileList.innerHTML += \'<div style="margin: 5px; display: inline-block;">\' + ';
                echo '\' <img src="../img' . htmlspecialchars($image) . '" alt="Hình ảnh" style="width: 100px; height: auto;"/>\' + ';
                echo '\' <p>' . htmlspecialchars(basename($image)) . '</p></div>\';';
            }
        }
    ?>

    // Hiển thị các tệp mới được chọn
    for (let i = 0; i < input.files.length; i++) {
        const file = input.files[i];
        const reader = new FileReader();

        reader.onload = function(e) {
            const para = document.createElement('div');
            para.style.margin = '5px';
            para.style.display = 'inline-block';
            para.innerHTML = '<img src="' + e.target.result + '" alt="Hình ảnh" style="width: 100px; height: auto;"/>' +
                             '<p>' + file.name + '</p>';
            fileList.appendChild(para); // Thêm hình ảnh mới vào danh sách hiển thị
        };

        reader.readAsDataURL(file); // Đọc tệp dưới dạng URL
    }
}
</script>

</body>
</html>
<?php } ?>
