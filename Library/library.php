<?php 

// hiển thị logo
function logo($note){
    $conn = connectDB();
    $result = $conn -> query("SELECT * FROM diachi ");
    $row = $result -> fetch_assoc();
    if ($note == 0) {
        echo '
            <img class="img-fluid" src="../images/'.$row['logo'].'" alt="Theme-Logo" />
        ';
    } else if ($note ==1) {
        echo '
            <img class="img-fluid" src="../../images/'.$row['logo'].'" alt="Theme-Logo" />
        ';
    } else if ($note ==2) {
        echo '
            <img src="../images/'.$row['logo'].'" alt="logo HiMe" />
        ';
    } else if ($note ==3) {
        echo '
            <img src="./images/'.$row['logo'].'" alt="logo HiMe" />
        ';
    }
}

//  hiển thị đường link tới trang quản trị nếu đăng nhập bằng tài khản Admin(2)
function disAdmin2($note) {
  if(isset($_SESSION['nguoidung'])) {
      $conn = connectDB();
      global $idCustomer; 
      $idCustomer = $_SESSION['nguoidung']['id_nguoidung'];
      $result = $conn -> query("SELECT isAdmin FROM user WHERE idUser = ".$idCustomer."");
      $row = $result -> fetch_assoc();
      if ($row['isAdmin']==1) {
          if ($note == 0) {
              echo '<div class="linkAdmin">
                      <a href="../Admin/"><i class="fab fa-expeditedssl"></i> Quản Trị Trang Web</a>
                      </div>';
          } else if ($note ==1) {
              echo'<div class="linkAdmin">
                      <a href="../Admin/"><i class="fab fa-expeditedssl"></i> Quản Trị Trang Web</a>
                  </div>';
              
          }
      }
    }
}
// hiên thi avata comment 
function disAvata() {
  if(isset($_SESSION['nguoidung'])) {
    $conn = connectDB();
        $idCustomer = $_SESSION['nguoidung']['id_nguoidung'];
        $result = $conn -> query("SELECT ten_nguoidung,anh_nguoidung FROM nguoidung WHERE id_nguoidung = ".$idCustomer."");
        $row = $result -> fetch_assoc();
          echo '<img src="../images/avata/'.$row['anh_nguoidung'].'" class = "avata_comment_top" alt="">';
  }
}

// hiện thì ảnh khi đẵ đăng nhập nếu chưa đăng nhập thì hiện thị đăng nhập đăng ký
function disLogin($note) {
    if(isset($_SESSION['nguoidung'])) {
        $conn = connectDB();
        $idCustomer = $_SESSION['nguoidung']['id_nd'];
        $result = $conn -> query("SELECT hoten,hinhanh FROM nguoi_dung WHERE id_nd = ".$idCustomer."");
        $row = $result -> fetch_assoc();
        if ($note ==0) {
            echo '
        
            

                  <div class="dropdown nav navigasion">
                        <a class="btn  dropdown-toggle index" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                              <div class="user__name" onclick="showNavUser()">
                              <img src ="./img/avata/'.$row['hinhanh'].'" class="img__avatar" style="    width: 24px;">
                              <span class="userName">'.$row['hoten'].'</span>
                              </div>
                        </a>

                        <ul class="dropdown-menu " aria-labelledby="dropdownMenuLink">
                        <li><a class="tk dropdown-item" href="./search-home/sea_home.php">Tìm kiếm chỗ ở</a></li>
                        <li><a class="tk dropdown-item" href="./home/home.php"> Cung cấp chỗ ở</a></li>
                        <li><a class="tk dropdown-item" href="./user/manager.php"> Trang cá nhân</a></li>
                        <li><a class="tk dropdown-item" href="./login/logout.php"> Đăng xuất</a></li>
                        </ul>
                </div>
            ';
        }else if($note ==1){
          echo '
        
            

          <div class="dropdown nav navigasion " style="    padding-top: 24px;">
                <a class="btn  dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                      <div class="user__name" onclick="showNavUser()">
                      <img src ="../img/avata/'.$row['hinhanh'].'" class="img__avatar" style="    width: 24px;">
                      <span class="userName">'.$row['hoten'].'</span>
                      </div>
                </a>

                <ul class="dropdown-menu " aria-labelledby="dropdownMenuLink">
                <li><a class="tk dropdown-item" href="../search-home/sea_home.php">Tìm kiếm chỗ ở</a></li>
                <li><a class="tk dropdown-item" href="../home/home.php"> Cung cấp chỗ ở</a></li>
                <li><a class="tk dropdown-item" href="../user/manager.php"> Trang cá nhân</a></li>
                <li><a class="tk dropdown-item" href="../login/logout.php"> Đăng xuất</a></li>
                </ul>
        </div>
    ';
        }
    } else {
        echo '
        <ul class="nav navigasion ">
                      
                        <li class="nav-item-sign ">
                                        <a class="nav-link sig" href="#">
                                <Button id="sign">
                                    Đăng ký
                                </Button>
                            </a>
                        </li>
                        <li class="nav-item-log">
                                      <a class="nav-link log" href="#">
                                <Button id="log">
                                    Đăng nhập
                                </Button></a>

                        </li>
                     
                    </ul>
        ';
    }
      
}

// hiện thị giỏ hàng và số lượng sản phẩm đang có trong giỏ hàng

function cart($note) {
    if (isset($_SESSION['nguoidung'])) {
        $idCustomer = $_SESSION['nguoidung']['id_nguoidung'];
        $conn = connectDB();
        $resultCount = $conn -> query("SELECT CD.id_cartDetail FROM cart C INNER JOIN cartdetail CD INNER JOIN user U INNER JOIN product P ON C.id_user = U.idUser AND C.idCartDetail = CD.id_cartDetail AND CD.id_product = P.id_product AND U.idUser =".$idCustomer."");
        $countCart = $resultCount -> num_rows;
        if ($note == 0) {
            echo'
              <div class="cart_icon">
                <i class="fas fa-shopping-cart"></i>
                <sub>'.$countCart.'</sub>
              </div>';
        } else if ($note == 1) {
            echo'
              <div class="cart_icon">
                <i class="fas fa-shopping-cart"></i>
                <sub>'.$countCart.'</sub>
              </div>';
        }
      }
}

// show scombo
// function showProductHot () {
//     $conn = connectDB();
//               $result = $conn->query("SELECT * FROM product WHERE id_category = 1");
//               if ($result->num_rows > 0) {
//                 while ($row = $result->fetch_assoc()) {
//                   echo '
//                     <a href="./Product_Detail/sanpham.php?id='.$row['id_product'].'">
//                       <div class="item-product-hot">
//                         <div class="item-product-hot-img">
//                           <img class="product-img" src="./images/'.$row['image'].'" alt=""/>
//                         </div>
//                         <div class="item-product-information ">
//                           <p class="name-product ">'.$row['nameProduct'].'</p>

//                         </div>
//                       </div>
//                       <!-- end  item-product-hot-->
//                     </a>
//                   ';
//                 }
//               }
// }










// Mua Ngay
// <span class="price-product">'.number_format($row['price']).' đ</span>

// 
// show sản phẩm theo loại tham số truyền vào là mã loại
function showProductCategory($category) {
    $conn = connectDB();
    $result = $conn->query("SELECT * FROM product WHERE id_category = '".$category."' LIMIT 0,8");
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo '
        <div class="item-product-hot">
          <div class="item-product-hot-img">
            <img src="./images/'.$row['image'].'" alt="" />
            <a href="./Product_Detail/sanpham.php?id='.$row["id_product"].'">Mua Ngay</a>
            <span class="discount">- '.$row['discount'].'%</span>
          </div>
          <div class="item-product-information">
            <a href="./Product_Detail/sanpham.php?id='.$row["id_product"].'" class="name-product">'.substr($row['nameProduct'],0,24).'</a>
            <span class="priceSaled-product">'.number_format(ceil(($row['price']-($row['price']*$row['discount'])/100))).' đ</span>
            <span class="price-product">'.number_format($row['price']).' đ</span>

          </div>
        </div>
        <!-- end  item-product-hot-->
        ';
      }
    }
}

//  đếm số lượt xem
function updateView() {
    if (isset($_GET['id'])) {
        $conn = connectDB();
        $idProduct = $_GET['id'];
        $conn->query("UPDATE xe SET luotxem = luotxem + 1 WHERE xe.id_xe = ".$idProduct."");
    }
}

// thêm sản phẩm vào giỏ hàng
// buy now 
function buyProduct() {
  if (isset($_GET['id'])) {
      if (isset($_POST['bnt_buyNow']) || isset($_POST['bnt_add_cart']) ) { 
        $conn = connectDB();  
        // $size = $_POST['listChooseSize']; 
        $idProduct = $_GET['id']; //id sản phẩm
        $idCustomer = $_SESSION['nguoidung']['id_nguoidung']; //id user
        $qty = $_POST['valQty']; // số lượng

        $sql1 = "INSERT INTO chitietgiohang VALUES (null,'$idProduct','$qty')";
        $result2 = $conn ->query($sql1);

        $result = $conn -> query("SELECT max(id_chitietgiohang) AS 'id_chitietgiohang' FROM chitietgiohang");
        $row = $result->fetch_assoc();

        $sql2 = "INSERT INTO giohang VALUES (null,".$idCustomer.",".$row['id_chitietgiohang'].")";
        $result3 = $conn ->query($sql2);
        
        if (isset($_POST['bnt_buyNow'])) {
          header('location: ../Cart/giohang.php');
        } else if(isset($_POST['bnt_add_cart'])){
          
          header('location: ../Product_Detail/sanpham.php?id='. $idProduct.'');
        
        }
      }
    }
}

function buyProduct2() {
  if (isset($_GET['idOder'])) {
      if (isset($_POST['bnt_buyNow']) || isset($_POST['bnt_add_cart']) ) { 
        $conn = connectDB();  
        // $size = $_POST['listChooseSize']; 
        $idOder = $_GET['idOder']; //id sản phẩm
        $idCustomer = $_SESSION['nguoidung']['id_nguoidung']; //id user
        $qty = $_POST['valQty']; // số lượng

        $sql1 = "INSERT INTO hoadon_thanhtoan VALUES (null,'$idOder',, current_timestamp())";
        $result2 = $conn ->query($sql1);

       
        
       
      }
    }
}
// hiển thị thông tin sản phẩm
// show information product
function productInF($idProduct) {
    if (isset($_GET['id'])) {
        $conn = connectDB();
        $result = $conn->query("SELECT * FROM xe WHERE id_xe=".$idProduct."");
        if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo '
        <div class="border_detail">

          <div class="details_product_title">
              <h2>'.$row['ten_xe'].'</h2>
          </div>
          <div class="details_content">
            <p>'.$row['thongtin_xe'].'</p>
          </div>
        </div>

        '; 
      }
    }
      
}

// Hiển thị các sản phẩm tương tự
function showProductSimilar($idProduct) {
    if(isset($_GET['id'])) {
        $conn = connectDB();
        $result = $conn->query("SELECT * FROM xe WHERE id_xe=".$idProduct."");
        if ($result->num_rows > 0) {
        $rowParent = $result->fetch_assoc();
            $result = $conn -> query("SELECT * FROM xe WHERE id_danhmuc = ".$rowParent['id_danhmuc']." AND id_xe != ".$idProduct." ORDER BY RAND() LIMIT 0, 4");
            if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                echo '
                <div class="item-product-hot">
                <div class="item-product-hot-img">
                  <img src="../images/'.$row['anh_xe'].'" alt="" />
                  <a href="../Product_Detail/sanpham.php?id='.$row["id_xe"].'">Đặt Xe</a>
                </div>
                <div class="item-product-information">
                  <a href="../Product_Detail/sanpham.php?id='.$row["id_xe"].'" class="name-product">'.substr($row['ten_xe'],0,24).'</a>
                  <span class="priceSaled-product">'.number_format($row['gia_xe']).' đ</span>
                </div>
              </div>
              <!-- end  item-product-hot-->
                ';
              }
            }
        }
      }
    
}

// Hiện thị bình luân của khách hàng trong từng sản phẩm
// function showCommentProduct() {
//     if (isset($_GET['id'])) {
//         $idProduct = $_GET['id'];
//         $conn = connectDB();
//         $result = $conn -> query("SELECT * FROM product PR INNER JOIN comment CM INNER JOIN user U ON CM.id_product = PR.id_product AND CM.user_id = U.idUser  WHERE CM.disabled NOT IN (1) AND PR.id_product=".$idProduct."");
//         if ($result->num_rows > 0) {
//           while($row = $result->fetch_assoc()){
//             echo '
//               <div class="comment_item">
//                 <div class="id_name_member">
//                     <div class="show__account">
//                         <img src ="../images/avata/'.$row['image'].'" class="img__avatar">
//                         <span>'.$row['userName'].'</span>
//                     </div>
//                     <div class="time__comment">'.$row['date'].'</div>
//                 </div>
//                 <!-- end id_name_member -->
//                 <div class="content_comment_member">
//                   <p>'.$row['content'].'</p>
//                   </div>
//                   <div class="rep_comment_member">
//                   <p>'.$row['rep_comment'].'</p>
//                   </div>
//               </div>
//               <!-- end comment_item -->
//               ';
//           }
//         }
//       }
    
// }


//  hiển thị sản phẩm theo danh mục
function showProductCategory2($category) {
    $conn = connectDB();
    if ($category==0) {
      $result = $conn->query("SELECT * FROM product");
    } else {
      $result = $conn->query("SELECT * FROM product WHERE id_category = '".$category."'");
    }
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo '
        <div class="item-product-hot">
          <div class="item-product-hot-img">
            <img src="../images/'.$row['image'].'" alt="" />
            <a href="../Product_Detail/sanpham.php?id='.$row["id_product"].'">Mua Ngay</a>
            <span class="discount">- '.$row['discount'].'%</span>
          </div>
          <div class="item-product-information">
            <a href="../Product_Detail/sanpham.php?id='.$row["id_product"].'" class="name-product">'.$row['nameProduct'].'</a>
            <span class="priceSaled-product">'.number_format(ceil(($row['price']-($row['price']*$row['discount'])/100))).' đ</span>
            <span class="price-product">'.number_format($row['price']).' đ</span>
          </div>
        </div>
        <!-- end  item-product-hot-->
        ';
      }
    }
}

// hiện thị theo nhiều loại sản phẩm
function showListCategory($category) {
  $conn = connectDB();
  foreach($category as $value){
    $result = $conn->query("SELECT * FROM product WHERE id_category = '".$value."'");
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo '
        <div class="item-product-hot">
          <div class="item-product-hot-img">
            <img src="../images/'.$row['image'].'" alt="" />
            <a href="../Product_Detail/sanpham.php?id='.$row["id_product"].'">Mua Ngay</a>
            <span class="discount">- '.$row['discount'].'%</span>
          </div>
          <div class="item-product-information">
            <a href="../Product_Detail/sanpham.php?id='.$row["id_product"].'" class="name-product">'.$row['nameProduct'].'</a>
            <span class="priceSaled-product">'.number_format(ceil(($row['price']-($row['price']*$row['discount'])/100))).' đ</span>
            <span class="price-product">'.number_format($row['price']).' đ</span>
          </div>
        </div>
        <!-- end  item-product-hot-->
        ';
      }
    }
  }
}

// hiển thị các loại sản phẩm trong danh mục -> trang sản phẩm
function showCategory($idCategory) {
  $conn = connectDB();
  if ($idCategory==0) {
    $result = $conn -> query("SELECT * FROM category");
    if ($result -> num_rows >0) {
      echo'<li><span class="label-Sp">Tất cả</span><input type="checkbox" name="" onclick="chekboxAll()" checked="checked" onsubmit="submit()"></li>';
      while ($row = $result ->fetch_assoc()) {
        echo'
          <li><span class="label-Sp">'.$row['nameCategory'].'</span><input type="checkbox" checked="checked" class="valCheckbox" name="valCheckbox[]" value="'.$row['id_category'].'"></li>
        ';
      }
    }
  } else {
    $result = $conn -> query("SELECT * FROM category");
    if ($result -> num_rows >0) {
      echo'<li><span class="label-Sp">Tất cả</span><input type="checkbox" name="" onclick="chekboxAll()" onsubmit="submit()"></li>';
      while ($row = $result ->fetch_assoc()) {
        if ($row['id_category']==$idCategory) {
        echo'<li><span class="label-Sp">'.$row['nameCategory'].'</span><input type="checkbox" class="valCheckbox" name="valCheckbox[]" checked="checked" value="'.$row['id_category'].'"></li>';
        } else {
        echo' <li><span class="label-Sp">'.$row['nameCategory'].'</span><input type="checkbox" class="valCheckbox" name="valCheckbox[]" value="'.$row['id_category'].'"></li>';
        }
      }
    }
  }
}


// hiển thị từ khóa tìm kiếm
function disTxtSearch($txtSearch) {
  echo '<span class="disTxtSearch">- '.$txtSearch.'</span>';
}

// hiển thị thông báo
function showNotification($idUser) {
  $conn = connectDB();
  $result = $conn -> query("SELECT * FROM notification WHERE id_user = ".$idUser." ORDER BY id DESC ");
  if ($result -> num_rows > 0) {
    while($row = $result -> fetch_assoc()) {
      echo '
        <li>
          <div class="show_Notification-item">
            <h5>Chào mừng bạn đến với HiMe</h5>
            <p>Bạn đã đăng ký thành công và được tặng một mã free ship:<span class="codeDiscount"> '.$row['value'].'</span></p>
          </div>
        </li>';
    }
  } else {
    echo '<li><div class="show_Notification-item"><h5>Chưa có thông báo nào !</h5></div></li>';
  }
  
}

//  hiển thị số lượt thông báo
function showCountNotification($idUser) {
  $conn = connectDB();
  $result = $conn -> query("SELECT * FROM notification WHERE id_user = ".$idUser." ORDER BY id DESC ");
  if ($result -> num_rows > 0) {
    echo $result -> num_rows;
  } else {
    echo "0";
  }
}


// hiển thị giỏ hàng khi hover vào nút giỏ hàng

function showCartMini($idCustomer, $note) {
  $conn = connectDB();
  $result = $conn -> query("SELECT * FROM cart C INNER JOIN cartdetail CD INNER JOIN user U INNER JOIN product P ON C.id_user = U.idUser AND C.idCartDetail = CD.id_cartDetail AND CD.id_product = P.id_product AND U.idUser =".$idCustomer."");
  if ($result -> num_rows > 0) {
    while($row = $result -> fetch_assoc()) {
      if ($note == 1) {
        echo '
        <li>
          <img  src="./images/' .$row['images'].'" alt="">
          <div class="information_product">
            <span class="name_product">'.$row['nameProduct'].' <i class="price__item_cart">X '.$row['qty'].'</i></span>
            <span class="totalCash">'.number_format($row['price']).' đ</span>
          </div>
          <div class="delete_cart">
            <button name="deleteCart" value = "'.$row['id_cartDetail'].'"><i class="fas fa-trash-alt"></i></button>
          </div>
        </li>
      ';
      } else if ($note == 2) {
        echo '
        <li>
          <img src="../images/'.$row['image'].'" alt="">
          <div class="information_product">
            <span class="name_product">'.$row['nameProduct'].' <i class="price__item_cart">X '.$row['qty'].'</i></span>
            <span class="totalCash">'.number_format($row['price']).' đ</span>
          </div>
          <div class="delete_cart">
            <button name="deleteCart" value = "'.$row['id_cartDetail'].'"><i class="fas fa-trash-alt"></i></button>
          </div>
        </li>
      ';
      }
    }
  } else {
    echo '<li class="cartEmpty">Giỏ Hàng Trống !</li>';
  }

}

// hiện thị đơn hàng trong userManager
function  showOdered($idCusomer) {
  $conn = connectDB();
  global $totalCash;
  global $totalCashPro;
  $totalCash = 0;
  
  $result = $conn -> query("SELECT MAX(O.id_hopdong), P.anh_xe, P.ten_xe,O.gia,O.qty, P.id_xe FROM hopdong O INNER JOIN trangthai INNER JOIN  xe P ON  O.id_xe = P.id_xe AND O.trangthai = trangthai.id  WHERE O.id_nguoidung = ".$_SESSION['nguoidung']['id_nguoidung']."   AND O.trangthai NOT IN (6,3) ORDER BY O.id_hopdong DESC ");
  if($result -> num_rows > 0){
    while($row = $result -> fetch_assoc()) {
      echo '
      <div class="product_oder-item">
        <div class="product_oder-item-img">
          <img src="../images/'.$row['anh_xe'].'" alt="">
        </div>
        <!-- end product_oder-item-img -->
        <div class="product_oder-item-information">
          <a href="../Product_Detail/sanpham.php?id='.$row['id_xe'].'"><h4>'.$row['ten_xe'].'</h4></a>
          <span>Thời gian thuê: '.$row['qty'].' Ngày</span>
        </div>
        <div class="product_oder-item-cash">Đơn Giá: <i>'.number_format($row['gia']).' đ</i></div>
      </div>
      <!-- end product_oder-item  -->
      ';
      $phantram = 30;
      $price = ($row['gia']*$phantram)/100;
    
        $totalCashPro += ($price*$row['qty']);
      $totalCash = ($row['gia']- $totalCashPro);
    }
  }
}


function showOderedXe($idUser) {
  
  $conn = connectDB();
  $result = $conn -> query("SELECT P.anh_xe, P.ten_xe,O.gia,O.qty, P.id_xe FROM hopdong O INNER JOIN  xe P ON  O.id_xe = P.id_xe  WHERE O.id_nguoidung = ".$_SESSION['nguoidung']['id_nguoidung']." AND O.trangthai NOT IN (6,3) ORDER BY O.id_hopdong DESC  ");

  $row = $result -> fetch_assoc();
  echo '
  <div class="from_group_item">
      <span >Tên Xe:</span>
      <select name="inpXe" id="inp__Xe" required style="display: none;">

      <option value="'.$row['id_xe'].'">'.$row['ten_xe'].'</option>

      </select>
      <input type="text" required name="txtFullName" disabled value="'.$row['ten_xe'].'">

  </div>
';

}
function  showOdered2($idCusomer) {
  $conn = connectDB();
  global $totalCashPro;
  $totalCashPro = 0;
  $result = $conn -> query("SELECT P.anh_xe, P.ten_xe,O.gia,O.qty, P.id_xe,G.noidung,G.ngaygiao FROM hopdong O INNER JOIN bb_giao G INNER JOIN  xe P ON  O.id_xe = P.id_xe and O.id_hopdong = G.id_hopdong and P.id_xe = G.id_xe WHERE O.id_nguoidung = ".$_SESSION['nguoidung']['id_nguoidung']."  ");
  if($result -> num_rows > 0){
    while($row = $result -> fetch_assoc()) {
      echo '
      
        <!-- end product_oder-item-img -->
      
          <input type="text" required name="txtFullName" disabled value="'.$row['noidung'].'">
     

      <!-- end product_oder-item-->

      
      ';
      $totalCashPro += ($row['price']*$row['qty']);
    }
  }
}

function  showOderedGiao($idCusomer) {
  $conn = connectDB();
  global $totalCashPro;
  $totalCashPro = 0;
  $result = $conn -> query("SELECT G.noidung FROM hopdong O INNER JOIN bb_giao G  ON   O.idOder = G.idOder  WHERE O.idUser = ".$_SESSION['nguoidung']['id_nguoidung']."  ");
  if($result -> num_rows > 0){
    while($row = $result -> fetch_assoc()) {
      echo '
      
        <!-- end product_oder-item-img -->
      

          <div class="from_group_item">
          <span >Tình trạng xe:</span>
          <input type="text" required name="txtFullName" disabled value="'.$row['noidung'].'">

      </div>
      <!-- end product_oder-item-->

      
      ';
      $totalCashPro += ($row['price']*$row['qty']);
    }
  }
}
function  showOderedNgay($idCusomer) {
  $conn = connectDB();
  global $totalCashPro;
  $totalCashPro = 0;
  $result = $conn -> query("SELECT G.ngaygiao FROM orderr O INNER JOIN bb_giao G  ON   O.idOder = G.idOder  WHERE O.idUser = ".$_SESSION['nguoidung']['id_nguoidung']."   ");
  if($result -> num_rows > 0){
    while($row = $result -> fetch_assoc()) {
      echo '
    
          <input type="text" required name="txtFullName" disabled value="'.$row['ngaygiao'].'">

      ';
      $totalCashPro += ($row['price']*$row['qty']);
    }
  }
}
// tính tổng tiền của từng đơn hàng 
// function totalCashOrder($idCusomer, $orderDate) {
//   $conn = connectDB();
//   $totalCash = 0;
//   $result = $conn -> query("SELECT * FROM orderr O INNER JOIN oderdetail OD INNER JOIN product P ON O.id_oderDetail = OD.id_oderDetail AND OD.id_product = P.id_product WHERE O.idUser = ".$idCusomer." AND O.dateOrder = '".$orderDate."'");
//   if($result -> num_rows > 0){
//     while($row = $result -> fetch_assoc()) {
//       $totalCash += ((($row['price']-($row['price']*$row['discount'])/100))*$row['qty']);
//     }
//   }
//   return number_format($totalCash);
// }

// hủy đơn hàng

function cancelOrder() {
  if (isset($_POST['bntCancel'])) {
    $conn = connectDB();
    $idOder = $_POST['bntCancel'];
    $conn -> query("UPDATE hopdong SET trangthai = 6 WHERE hopdong.id_hopdong = '".$idOder."' AND hopdong.id_nguoidung = ".$_SESSION['nguoidung']['id_nguoidung']."");
    header("Refresh:0");
  }
}

// xác nhận đã nhận hàng
function successOrder() {
  if (isset($_POST['bntSuccess'])) {
    $conn = connectDB();
    $idOder = $_POST['bntSuccess'];
    $conn -> query("UPDATE hopdong SET trangthai = 3 WHERE hopdong.id_hopdong = '".$idOder."' AND hopdong.id_nguoidung = ".$_SESSION['nguoidung']['id_nguoidung']."");
    header("Refresh:0");

  }
}

function successOrder2() {
  if (isset($_POST['bnt_insert_data'])) {
    $conn = connectDB();
    $valTen = $_POST['inpTen']; // category
    $valXe = $_POST['inpXe']; // category
    $conn -> query("INSERT INTO hoadon_thanhtoan VALUES(null, '$valTen','$valXe',current_timestamp())");
    echo '<span class="notification__success">Bạn Đã Ghi Nhận Thành Công !</span>';
    header("Refresh:0");


  }
}

function successOrder3() {
  if (isset($_POST['bnt_insert_data']) ) {
    $conn = connectDB();
    $valTen = $_POST['inpTen']; // category
    $valXe = $_POST['inpXe']; // category
    $valDate = $_POST['inpDate']; //date
    $informationProduct = $_POST['product_desc']; // information product

    $sql = "INSERT INTO bb_tra VALUES (null,'$valTen','$valXe','$valDate','$informationProduct')";
    if ($conn->query($sql)) {
         echo '<span class="notification__success">Bạn Đã Ghi Nhận Thành Công !</span>';
    } else {
        // echo '<span class="notification__fail">Không Thể Thêm Sản Phẩm Này. Vui lòng thử lại !</span>';
    }
  header('Refresh:0');

  }
  
}

function successOrder4() {
  if (isset($_POST['bnt_insert_data']) ) {
    $conn = connectDB();
    $valinpTebSC = $_POST['inpTenSC']; // category
    $valTen = $_POST['inpTen']; // category
    $valXe = $_POST['inpXe']; // category
    $valDate = $_POST['inpDateSC']; //date
    $TienSC = $_POST['TienSC']; //date
    $informationProduct = $_POST['product_descSC']; // information product

    $sql = "INSERT INTO bb_suco VALUES (null,'$valinpTebSC','$valTen','$valXe','$valDate','$informationProduct','$TienSC')";
    if ($conn->query($sql)) {
        // echo '<span class="notification__success">Bạn Đã Thêm Thành Công !</span>';
    } else {
        // echo '<span class="notification__fail">Không Thể Thêm Sản Phẩm Này. Vui lòng thử lại !</span>';
    }
  header('Refresh:0');

  }
}

function showContactDetail($idContactCM) {
  $conn = connectDB();
  $result = $conn -> query("SELECT * FROM `lienhe` ORDER BY date DESC ");
  if ($result -> num_rows > 0) {
      while($row = $result -> fetch_assoc()){
          echo '
              <div class="item_comment">
                  <div class="header_comment">
                      <div class="user">                         
                          <span>'.$row['hoten'].'</span>
                      </div>
                      <div class="time_comment">
                          <span>'.$row['ngay'].'</span>
                      </div>
                      
                  </div>
                  <div class="time_comment" style="margin-left: 18px;">
                  <span>'.$row['email'].'</span>
                 </div>
                  <!-- end header_comment -->
                  <div class="content_comment">
                      <p>'.$row['noidung'].'</p>
                      <div class="bnt-delete_comment">
                          <td class="box__bnt">
                          <button class="bnt__category category__delete" name ="delete" value="'.$row['id'].'">Xóa</button>
                          </td>
                      </div>
                  </div>
                  
                 
                  <!-- end content_comment -->
              </div>
              <!-- end item_comment -->
          ';
      }
  } else {
    echo '<h5 style="color: #b51f1f;">Không có bình luận nào !</h5>';
  }
  
}
// lưu thông tin đơn hàng vào session
function addDataSession($idOder,$fullName,$mail,$phone,$adress,$txtNote,$diemdi,$diemden,$ngaythue,$giacoc) {
  if (!isset($_SESSION['infOrder'])) {
    if (empty($txtNote)) {
      $txtNote = 'Không';
    }
    $_SESSION['infOrder'] = array();
    $_SESSION['infOrder']['id_hopdong'] = $idOder;
    $_SESSION['infOrder']['hoten_nguoidung'] = $fullName;
    $_SESSION['infOrder']['email_nguoidung'] = $mail;
    $_SESSION['infOrder']['sdt_nguoidung'] = $phone;
    $_SESSION['infOrder']['diachi_nguoidung'] = $adress;
    $_SESSION['infOrder']['txtNote'] = $txtNote;
    $_SESSION['infOrder']['diemdi'] = $diemdi;
    $_SESSION['infOrder']['diemden'] = $diemden;
    $_SESSION['infOrder']['ngaythue'] = $ngaythue;
    $_SESSION['infOrder']['giacoc'] = $giacoc;


  }
}





// lưu dữ liệu đặt hàng vào database
// ghi chú: phần này phải insert dữ liệu vào 2 bảng trong đó có bảng oder và orderDetail.
//  Để có thể insert nhiều bảng cùng lúc thì phải sử dụng vòng lặp. có bao nhiêu sản phẩm trong giỏ hàng thì phải lặp lại bấy nhiêu lần
//  phải inset bảng oderDetail trước sau đó mới insert được bảng order (! phần này hơi khó hiểu đọc kỹ nhé ae!!)
// 
function insertOrder() {
  $idUser = $_SESSION['nguoidung']['id_nguoidung'];
  $fullName = $_SESSION['infOrder']['hoten_nguoidung'];
  $phone = $_SESSION['infOrder']['sdt_nguoidung'];
  $mail = $_SESSION['infOrder']['email_nguoidung'];
  $adress = $_SESSION['infOrder']['diachi_nguoidung'];
  $txtNote = $_SESSION['infOrder']['txtNote'];
  $diemdi = $_SESSION['infOrder']['diemdi'];
  $diemden = $_SESSION['infOrder']['diemden'];
  $ngaythue = $_SESSION['infOrder']['ngaythue'];
  $giacoc = $_SESSION['infOrder']['giacoc'];
  $qty = $_SESSION['infOrder']['qty'];

  $conn = connectDB();
  $result1 = $conn -> query("SELECT * FROM giohang C INNER JOIN chitietgiohang CD INNER JOIN nguoidung U INNER JOIN xe P ON C.id_nguoidung = U.id_nguoidung AND C.id_chitietgiohang = CD.id_chitietgiohang AND CD.id_xe = P.id_xe AND U.id_nguoidung =".$_SESSION['nguoidung']['id_nguoidung']."");
  if ($result1 -> num_rows > 0) {
    while($row = $result1 -> fetch_assoc()){
      $price = $row['gia_xe'];
     
      $conn -> query("INSERT INTO hopdong VALUES (null,".$row['id_xe'].",".$idUser.", 1, '".$fullName."', '".$phone."', '".$mail."', '".$adress."', '".$txtNote."','". $diemdi."','".$diemden."','".$ngaythue."','".$giacoc."',  ".$price.",".$row['qty']." )");
      

    }
  }

  // Saukhi lưu được dữ liệu vào order rồi thì tiến hành xóa bảng cart
  $conn -> query("DELETE FROM giohang WHERE giohang.id_nguoidung = ".$idUser."");
  
}


function insertOrder2() {
  if(isset($_SESSION['hopdong'])) {
  $conn = connectDB();
  $result = $conn -> query("SELECT * FROM hopdong O INNER JOIN hoadon_thanhtoan HD INNER JOIN nguoidung U ON O.id_hopdong = HD.id_hopdong AND U.id_nguoidung =".$_SESSION['nguoidung']['id_nguoidung']."");
  if ($result -> num_rows > 0) {
    while($row = $result -> fetch_assoc()) {
    
      $conn -> query("INSERT INTO hoadon_thanhtoan VALUES (null,".$row['id_hopdong']." , current_timestamp())");


    }
  }}

  
}
function insertNotification($title, $content, $value, $idUser) {
  $conn = connectDB();
  $conn -> query("INSERT INTO diachi VALUES (null,'".$title."','".$content."','".$value."',".$idUser.")");
}

//hiện thị lịch sử đơn hàng
function showHistoryOrderProduct($id_product, $idCustomer) {
  $connF = connectDB();
  global $totalHistoryItemPrice;
  $totalHistoryItemPrice = 0;
  $resultF = $connF -> query("SELECT P.ten_xe, P.id_xe,O.id_xe, O.qty, O.gia FROM hopdong O  INNER JOIN xe P ON  O.id_xe = P.id_xe WHERE O.id_nguoidung = ".$idCustomer." AND O.id_xe = '".$id_product."'");
  if ($resultF -> num_rows > 0) {
    while($rowF = $resultF -> fetch_assoc()) {
          echo "| <a href='../Product_Detail/sanpham.php?id=".$rowF['id_xe']."'>".$rowF['ten_xe']."</a>"." |";
          $totalHistoryItemPrice += ($rowF['gia']*$rowF['qty']);
    }
  }
}

//  hiển thị các quận huyện
function showDistrict() {
  $conn = connectDB();
  $result = $conn -> query("SELECT * FROM location_district WHERE location_district.provinceid = '01'");
  if ($result -> num_rows > 0) {
    while($row = $result -> fetch_assoc()) {
      echo '<option value="'.$row['districtid'].'">'.$row['name'].'</option>';
    }
  }
}

// data Quận huyện ajax 
function dataLocation() {
    $conn = connectDB();
    if (isset($_POST['idDistrictA'])) {
      $key = $_POST['idDistrictA'];
      $resultA = $conn -> query("SELECT * FROM location_ward WHERE location_ward.districtid = '".$key."'");
      if ($resultA -> num_rows > 0) {
          while($rowA = $resultA -> fetch_assoc()) {
              echo '<option value="'.$rowA['wardid'].'">'.$rowA['name'].'</option>';
          }
      }
    }
}

// hiện thị số sao (điểm số feedback)

// function showStar($countStar) {
//     for ($i=0; $i < $countStar; $i++) { 
//       echo '<i class="fas fa-star"></i>';
//     }
//     for ($j = 0; $j < 5-$i; $j++) {
//       echo '<i class="far fa-star"></i>';
//     }
// }
// lấy ra url của hiện Tại
function getCurURL()
{
    if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
        $pageURL = "https://";
    } else {
      $pageURL = 'http://';
    }
    if (isset($_SERVER["SERVER_PORT"]) && $_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}              
// lưu dữ liệu feedback
// function insertFeedBack($idUser, $codeOrder, $pointStar, $contentFeedback) {
//   $conn = connectDB();
//   $result = $conn -> query("SELECT * FROM hopdong O INNER JOIN oderdetail OD ON O.id_oderDetail = OD.id_oderDetail WHERE O.codeOrder = '".$codeOrder."' AND O.idUser = ".$idUser."" );
//   while ($row = $result ->fetch_assoc()) {
//     $conn -> query("INSERT INTO feedback VALUES (null, ".$idUser.", ".$row['id_product'].", '".$contentFeedback."', ".$pointStar.", null)");
//   }
// }

// update ảnh đại diện user
function updateAvatar($img, $idUser) {
  $conn = connectDB();
  $conn -> query("UPDATE nguoidung SET anh_nguoidung = '".$img."' WHERE id_nguoidung = ".$idUser."");
  header("Refresh:0");
}

// hiện thị Thông tin liên hệ
function personalInformation($idUser) {
  
  $conn = connectDB();
  $result = $conn -> query("SELECT * FROM nguoi_dung WHERE id_nd = ".$idUser."");
    if ($result -> num_rows > 0) {
      while($row = $result -> fetch_assoc()) {
        
  echo '
        <div class="from_list_home">
          <div class="from_l">
              <div class="avt">
                                <img src="../img/avata/'.$row['hinhanh'].' " class="w-100" style=" height: 170px;" alt=""/>
        </div>
          </div>
        <div class="from_r">
          <div class="from_group_item">
              <label for="">Họ tên:</label>
              <input type="text" id="btn" class="input_user" required name="hoten" disabled value="'.$row['hoten'].'">
          </div>
          <div class="from_group_item" style = "    margin-right: 45px;">
              <label for="">Số điện thoại:</label>
              <input type="text" id="btn" class="input_user" required name="sdt" disabled value="'.$row['sdt'].'">
          </div>
          <div class="from_group_item" style = "    margin-right: -9px;">
              <label for="">Email:</label>
              <input type="text" id="btn" class="input_user" required  name="email" disabled value="'.$row['email'].'">
          </div>
          <div class="from_group_item"style = "    margin-right: 27px;">
              <label for="">Ngày sinh:</label>
              <input type="date" required class="input_user" name="date" disabled value="'.$row['ngaysinh'].'">
          </div>
          <div class="from_group_item"style = "    margin-right: -197px;">
              <label for="">Địa chỉ:</label>
              <input type="text" id="btn" class="input_user" required  name="diachi" disabled value="'.$row['dia_chi'].'">
          </div>
          <div class="from_group_item"style = "    margin-right: -197px;">
              <label for="">Ghi chú:</label>
              <input type="text" id="btn" class="input_user" required  name="ghichu" disabled value="'.$row['ghichu'].'">

          </div>
           <div class="from_group_item"style = "    margin-right: -177px;">
              <label for="">Ngân sách:</label>
              <input type="text" id="btn" class="input_user" required  name="ngansach" disabled value="'.$row['ngansach'].'">
          </div>
               <div class="from_group_item"style = "    margin-right: -286px">
                 <label for="">Hình ảnh:</label>
                <input type="file" name="hinhanh" id="inp__img" class="valInp" accept=".jpg, .jpeg, .png, .jfif" required/>

          </div>
        </div>

</div>
  ';
} }
    }
function personalInformationG($idUser) {
  
  $conn = connectDB();
  $result = $conn -> query("SELECT * FROM user WHERE idUser = ".$idUser."");
  $row = $result -> fetch_assoc();
  echo '
  <div class="from_group_item">
      <span >Bên nhận:</span>
      <input type="text" required name="txtFullName" id="inp__Ten" disabled value="'.$row['fullName'].'">

  </div>
 <div class="from_group_item">
  <span >Đại diện bên nhận:</span>
  <input type="text" required name="txtFullName" disabled value="'.$row['fullName'].'">

</div>
  <div class="from_group_item">
      <span >Số Điện Thoại:</span>
      <input type="text" required name="txtFullName" disabled value="'.$row['phone'].'">


  </div>
  <div class="from_group_item">
      <span >Địa Chỉ:</span>
      <input type="text" required name="txtFullName" disabled value="'.$row['adress'].'">
  </div>';
}


function personalInformationTT($idUser) {
  
  $conn = connectDB();
  $result = $conn -> query("SELECT * FROM user WHERE idUser = ".$idUser."");
  $row = $result -> fetch_assoc();
  echo '
  <div class="from_group_item">
      <span >Bên nhận:</span>
      <input type="text" required name="txtFullName" id="inp__Ten" disabled value="'.$row['fullName'].'">

  </div>
 <div class="from_group_item">
  <span >Đại diện bên nhận:</span>
  <input type="text" required name="txtFullName" disabled value="'.$row['fullName'].'">

</div>
  <div class="from_group_item">
      <span >Số Điện Thoại:</span>
      <input type="text" required name="txtFullName" disabled value="'.$row['phone'].'">


  </div>
  <div class="from_group_item">
      <span >Địa Chỉ:</span>
      <input type="text" required name="txtFullName" disabled value="'.$row['adress'].'">
  </div>';
}
function personalInformation2($idUser) {
  
  $conn = connectDB();
  $result = $conn -> query("SELECT * FROM user WHERE idUser = ".$idUser."");
  $row = $result -> fetch_assoc();
  echo '
  <div class="from_group_item">
      <span >Bên nhận:</span>
      <input type="text" required name="txtFullName" id="inp__Ten" disabled value="'.$row['fullName'].'">

  </div>
 <div class="from_group_item">
  <span >Đại diện bên nhận:</span>
  <input type="text" required name="txtFullName" disabled value="'.$row['fullName'].'">

</div>
  <div class="from_group_item">
      <span >Số Điện Thoại:</span>
      <input type="text" required name="txtFullName" disabled value="'.$row['phone'].'">


  </div>
  <div class="from_group_item">
      <span >Địa Chỉ:</span>
      <input type="text" required name="txtFullName" disabled value="'.$row['adress'].'">
  </div>';
}

function personalInformationTravaSuCo() {
  
  $conn = connectDB();
  $result = $conn -> query("SELECT * FROM diachi");
  $row = $result -> fetch_assoc();
  echo '
  <div class="from_group_item">
      <span >Bên nhận:</span>
      <input type="text" required name="txtFullName" id="inp__Ten" disabled value="Công Ty HIME">

  </div>
 <div class="from_group_item">
  <span >Đại diện bên nhận:</span>
  <input type="text" required name="txtFullName" disabled value="Công Ty HIME">

</div>
<div class="from_group_item">
<span >Email:</span>
<input type="text" required name="txtFullName" disabled value="'.$row['email'].'">

</div>
  <div class="from_group_item">
      <span >Số Điện Thoại:</span>
      <input type="text" required name="txtFullName" disabled value="'.$row['sdt'].'">


  </div>
  <div class="from_group_item">
      <span >Địa Chỉ:</span>
      <input type="text" required name="txtFullName" disabled value="'.$row['diachi'].'">
  </div>';
}
function personalInformation3($idUser) {
  
  $conn = connectDB();
  $result = $conn -> query("SELECT * FROM nguoidung  WHERE id_nguoidung = ".$idUser." ");
  $row = $result -> fetch_assoc();
  echo '
 
 <div class="from_group_item">
  <span >Đại diện bên trả:</span>
  <input type="text" required name="txtFullName" disabled value="'.$row['hoten_nguoidung'].'">

</div>
  <div class="from_group_item">
      <span >Số Điện Thoại:</span>
      <input type="text" required name="txtFullName" disabled value="'.$row['sdt_nguoidung'].'">


  </div>
  <div class="from_group_item">
      <span >Địa Chỉ:</span>
      <input type="text" required name="txtFullName" disabled value="'.$row['diachi_nguoidung'].'">


  </div>';
}
function personalInformationTen($idUser) {
 
  $conn = connectDB();
  $result = $conn -> query("SELECT * FROM hopdong O WHERE O.id_nguoidung = ".$idUser." ");
  $row = $result -> fetch_assoc();
  echo '
  <div class="from_group_item">
      <span >Bên Trả:</span>
      <select name="inpTen" id="inp__Ten"  required style="display: none;">

           <option  value="'.$row['id_hopdong'].'">'.$row['ten_khach'].'</option>
      </select>
      <input type="text" required name="txtFullName" disabled value="'.$row['ten_khach'].'">

  </div>
';
}
function editPassWord($idUser,$passTrue,$passOld,$passNew){
  if ($passTrue == md5($passOld)) {
    $conn = connectDB();
    $result = $conn -> query("UPDATE nguoidung SET matkhau_nguoidung = '".md5($passNew)."' WHERE nguoidung.id_nguoidung = ".$idUser.";");
    if ($result) {
      echo '<span style="color: green;">Bạn đã thay đổi mật khẩu thành công</span>';
      $_SESSION['nguoidung']['matkhau_nguoidung'] = md5($passNew);
    } else {
      echo "Không thể thay đổi mật khẩu !";
    }
  } else {
    echo 'Sai mật khẩu. Vui lòng nhập lại !';
  }
}

// hiện thị số điện thoại của website
function showPhoneWeb() {
  $conn = connectDB();
  $result = $conn->query("SELECT * FROM information");
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo $row['phone'];
  }
}










// -------------------------- Admin --------------------
// admin: avata admin
function avatar($id,$note) {
    $conn = connectDB();
    $result = $conn -> query("SELECT * FROM nguoidung WHERE id_nguoidung = '".$id."'");
    $row = $result -> fetch_assoc();
    if ($note == 0) {
        echo '
            <img src=".././images/avata/'.$row['anh_nguoidung'].'" class="img-radius" alt="User-Profile-Image">
            <span>'.$row['ten_nguoidung'].'</span>
        ';
    } else if ($note ==1) {
        echo '
            <img class="img-80 img-radius" src=".././images/avata/'.$row['anh_nguoidung'].'" alt="User-Profile-Image">
            <div class="user-details">
                <span id="more-details">'.$row['ten_nguoidung'].'<i class="fa fa-caret-down"></i></span>
            </div>
        ';
    }
    else if ($note ==2){
        echo '
            <img src="../../images/avata/'.$row['anh_nguoidung'].'" class="img-radius" alt="User-Profile-Image">
            <span>'.$row['ten_nguoidung'].'</span>
        ';
    }
    else if ($note ==3){
        echo '
            <img class="img-80 img-radius" src="../../images/avata/'.$row['anh_nguoidung'].'" alt="User-Profile-Image">
            <div class="user-details">
                <span id="more-details">'.$row['ten_nguoidung'].'<i class="fa fa-caret-down"></i></span>
            </div>
        ';
    }
}
// admin:  vai trò  khách hàng
function role() {
    $conn = connectDB();
    $result = $conn -> query("SELECT * FROM vaitro");
    if ($result -> num_rows > 0) {
        while($row = $result -> fetch_assoc()) {
            echo '
                <option value="'.$row['id_vaitro'].'">'.$row['ten_vaitro'].'</option>
            ';

        }
    }

}

// admin: up imager
function upFile($name,$url) {
    $nameIMG = $_FILES[$name]['name'];
    $tmp_name = $_FILES[$name]['tmp_name'];
    move_uploaded_file($tmp_name, $url. $nameIMG);
    return $nameIMG;
}

// admin:  insert into customer
function insertCustomer($userName,$passWord,$emailCustomer,$isAdmin,$role,$nameUrlImgae) {
    $conn = connectDB();
    $result = $conn -> query("INSERT INTO nguoidung (id_nguoidung, ten_nguoidung, matkhau_nguoidung, email_nguoidung, isAdmin, id_vaitro, anh_nguoidung) VALUES (null,'".$userName."','".md5($passWord)."','".$emailCustomer."',b'".$isAdmin."',".$role.",'".$nameUrlImgae."')");
    if ($result) {
      echo '<span class="notification__success">Bạn Đã Thêm Thành Công !</span>';
    } else {
      echo '<span class="notification__fail">Không Thể Thêm Mới. Vui Lòng Thử Lại !</span>';
    }
}

// admin: update customer
function updateCustomer($idCustomer,$userName,$emailCustomer,$isAdmin,$role,$nameUrlImgae) {
    $conn = connectDB();
    $result = $conn->query("UPDATE nguoidung SET ten_nguoidung = '".$userName."', email_nguoidung = '".$emailCustomer."', isAdmin= b'".$isAdmin."',id_vaitro = '".$role."', anh_nguoidung ='".$nameUrlImgae."' WHERE nguoidung.id_nguoidung = ".$idCustomer."");
    if (!$result) {
      echo '<span class="notification__fail">Sửa Thất Bại. Vui Lòng Thử Lại !</span>';
    } else {
      echo '<span class="notification__success">Sửa Thành Công !</span>';
    }
}

// admin: delete select customer
 function deleteCustomer($valCheckbox) {
     $conn = connectDB();
    foreach ($valCheckbox as $idCustomer) {
        $resultFinalB = $conn -> query("UPDATE nguoidung SET disabled = b'0' WHERE nguoidung.id_nguoidung = ".$idCustomer."");
        if (isset($resultFinalB)) {
            if (!$resultFinalB) {
              echo '<span class="notification__fail">Bỏ Chặn Thất Bại. Vui Lòng Thử Lại !</span>';
            } else {
              echo '<script>
              alert("Bạn đã khôi phục thành công !");
              window.location.assign("./index.php");
              </script>';
            }
        }
    }
 }

 // admin: delete customer in turn 
 function deleteInTurn($idCustomer) {
    $conn = connectDB();
    $result = $conn -> query("SELECT * FROM nguoidung WHERE id_nguoidung = ".$idCustomer."");
    $row = $result -> fetch_assoc();
    if ($row['disabled'] != 1) {

      $resultFinal = $conn -> query("UPDATE nguoidung SET disabled = b'1' WHERE nguoidung.id_nguoidung = ".$idCustomer."");
      if (!$resultFinal) {
        echo '<span class="notification__fail">Chặn Thất Bại. Vui Lòng Thử Lại !</span>';
      } else {
        echo '<script>
        alert("Bạn đã vô hiệu hóa thành công !");
        window.location.assign("./index.php");
        </script>';
      }
    } else {

      $resultFinal = $conn -> query("UPDATE nguoidung SET disabled = b'0' WHERE nguoidung.id_nguoidung = ".$idCustomer."");
      if (!$resultFinal) {
        echo '<span class="notification__fail">Bỏ Chặn Thất Bại. Vui Lòng Thử Lại !</span>';
      } else {
        echo '<script>
        alert("Bạn đã khôi phục thành công !");
        window.location.assign("./index.php");
        </script>';
      }
    }

 }

 // admin:  hiển thị thông tin khi click vào nút sửa
 function showData() {
    if (isset($_POST['editCustomer'])) {
        $conn = connectDB();
        $idCustomer = $_POST['editCustomer'];
        $result = $conn->query("SELECT * FROM nguoidung WHERE id_nguoidung='".$idCustomer."'");
        if ($result->num_rows > 0) {
            // hiện thị dữ liệu
            $row = $result->fetch_assoc();
            echo "
                <script type='text/javascript'>
                document.getElementById('bnt_add_data').innerHTML = 'Cập Nhật';
                document.getElementById('bnt_add_data').value = 'Cập Nhật';
                document.getElementById('code__customer').value = '".$row['id_nguoidung']."';
                document.getElementById('name__customer').value = '".$row['ten_nguoidung']."';
                document.getElementById('email__customer').value = '".$row['email_nguoidung']."';
                document.getElementById('role').value = '".$row['id_vaitro']."';
                document.getElementsByName('inpSpecial')[".$row['isAdmin']."].checked = 'checked';
                document.querySelector('.title__customer__add').innerText = 'Sửa Thành Viên';
                document.querySelectorAll('.pass__customer')[0].style.display = 'none';
                document.querySelector('#pass__customer').disabled = true;
                document.querySelectorAll('.pass__customer')[1].style.display = 'none';
                document.querySelector('#en__pass__customer').disabled = true;
                document.querySelector('#inp__img').type = 'text';
                document.querySelector('#inp__img').value = '".$row['anh_nguoidung']."';
            </script>
            ";
            
        }
    }
 }

 // admin: tổng quan về số bình luận của sản phẩm
 function showComment() {
     $conn = connectDB();
     $result = $conn -> query("SELECT bl.id_product, hh.nameProduct , COUNT(*) AS 'countComment' , MAX(bl.date) AS 'maxDate', MIN(bl.date) AS 'minDate' FROM comment bl JOIN product hh ON hh.id_product=bl.id_product WHERE bl.disabled NOT IN (1) GROUP BY bl.id_product HAVING countComment > 0");
     if ($result -> num_rows > 0) {
         while($row = $result -> fetch_assoc()) {
            echo '
            <tr>
                <td>'.$row['nameProduct'].'</td>
                <td>'.$row['countComment'].'</td>
                <td>'.$row['minDate'].'</td>
                <td>'.$row['maxDate'].'</td>
                <td class="box__bnt">
                <a href="./commentDetail.php?idProduct='.$row['id_product'].'"><button class="bnt__comment comment__edit">Chi Tiết</button></a>
                </td>
            </tr> 
             
            ';
         }
     }


 }
//  function showFeedback() {
//   $conn = connectDB();
//   $result = $conn -> query("SELECT bl.idProduct, hh.nameProduct , COUNT(*) AS 'countComment' , MAX(bl.dateFeedback	) AS 'maxDate', MIN(bl.dateFeedback	) AS 'minDate' FROM feedback bl JOIN product hh ON hh.id_product=bl.idProduct WHERE bl.disabled NOT IN (1) GROUP BY bl.idProduct HAVING countComment > 0");
//   if ($result -> num_rows > 0) {
//       while($row = $result -> fetch_assoc()) {
//          echo '
//          <tr>
//              <td>'.$row['nameProduct'].'</td>
//              <td>'.$row['countComment'].'</td>
//              <td>'.$row['minDate'].'</td>
//              <td>'.$row['maxDate'].'</td>
//              <td class="box__bnt">
//              <a href="./feedDetail.php?idProduct='.$row['idProduct'].'"><button class="bnt__comment comment__edit">Chi Tiết</button></a>
//              </td>
//          </tr> 
          
//          ';
//       }
//   }


// }

 //
 function showContactad() {
  $conn = connectDB();
  $result = $conn -> query("SELECT *  FROM lienhe ");
  if ($result -> num_rows > 0) {
      while($row = $result -> fetch_assoc()) {
         echo '
         <tr>
         <td><input type="checkbox" name="checkbox[]" value="'.$row['id'].'"/></td>
             <td>'.$row['hoten'].'</td>
             <td>'.$row['email'].'</td>
             <td>'.$row['ngay'].'</td>
             <td>'.$row['noidung'].'</td>
             <td class="box__bnt">
             <button class="bnt__product product__delete" onclick="return confirmDelete()" name="delete" value="'.$row['id'].'">Xóa</button>

             </td>
         </tr> 
          
         ';
      }
  }


}



//
function updateLogoSetting($img) {
  $conn = connectDB();
  $conn -> query("UPDATE diachi SET logo = '".$img."'");
  header("Refresh:0");
}
// nameimg 
function nameImgLogo() {
  $conn = connectDB();
  $result = $conn -> query("SELECT logo FROM diachi");
  $row = $result -> fetch_assoc();
  echo '<span>'.$row['logo'].'</span>';
}
// nameimg 
function nameimg($idUser) {
  $conn = connectDB();
  $result = $conn -> query("SELECT anh_nguoidung FROM nguoidung WHERE nguoidung.id_nguoidung = ".$idUser."");
  $row = $result -> fetch_assoc();
  echo '<span>'.$row['anh_nguoidung'].'</span>';
}

// admin showAdress
function showAdress() {
  
  $conn = connectDB();
  $result = $conn -> query("SELECT * FROM diachi");
  $row = $result -> fetch_assoc();
  echo '
  <div class="from_group_item">
      <label for="">Địa Chỉ:</label>
      <input type="text" required name="txtAdress" disabled value="'.$row['diachi'].'">
  </div>';
}

// admin updateAdress
function updateAddress($txtAdress) {
  try {
    $conn = connectDB();
    $conn -> query("UPDATE diachi SET diachi = '".$txtAdress."'");
    header('Refresh:0');
  } catch (Exception $e) {
    echo '<p>Cập Nhật Lỗi</p>';
  }
}
// admin updateAdress
  function updatePersonalInformation($fullName, $email, $phone, $adress,$ghichu,$ngansach,$hinhanh, $idUser) {
  try {
    $nameIMG = $_FILES['hinhanh']['name'];
    $tmp_name = $_FILES['hinhanh']['tmp_name'];
    move_uploaded_file($tmp_name, "img/avata/". $nameIMG);
    $conn = connectDB();
    $conn -> query("UPDATE nguoi_dung SET hoten= '".$fullName."', email = '".$email."', sdt = '".$phone."', dia_chi = '".$adress."',ghichu = '".$ghichu."' , ngansach = '".$ngansach."', hinhanh = '".$nameIMG."' WHERE id_nd = ".$idUser."");

    // cập nhật session
    $_SESSION['nguoidung']['hoten'] = $fullName;
    $_SESSION['nguoidung']['sdt'] = $phone;
    $_SESSION['nguoidung']['email'] = $email;
    $_SESSION['nguoidung']['dia_chi'] = $adress;
    $_SESSION['nguoidung']['ghichu'] = $ghichu;
    $_SESSION['nguoidung']['ngansach'] = $ngansach;
    $_SESSION['nguoidung']['hinhanh'] = $nameIMG;
    
    header('Refresh:0');
  } catch (Exception $e) {
    echo '<p>Lỗi</p>';
  }
}
// admin showContact
function showContact() {
  $conn = connectDB();
  $result = $conn -> query("SELECT * FROM diachi");
  $row = $result -> fetch_assoc();
  echo '
    <div class="from_group_item">
      <label for="">Số Điện Thoại:</label>
      <input type="number" name="txtNumber" required placeholder="(+84)" disabled value="'.$row['sdt'].'">
    </div>
    <div class="from_group_item">
      <label for="">Email:</label>
      <input type="email" name="txtEmail" required disabled value="'.$row['email'].'">
    </div>';
                                                        
}

// admin updateContact
function updateContact($valPhone, $valEmail) {
  $conn = connectDB();
  $result = $conn -> query("UPDATE diachi SET sdt = '".$valPhone."', email = '".$valEmail."';");
  header('Refresh:0');
}

// Hiện thị các sản phẩm của đơn hàng đó
function showProductOrderItem($idCusomer, $idOder) {
  global $totalCashProduct;
  $totalCashProduct = 0;
  $connA = connectDB();
  $resultA = $connA -> query("SELECT P.anh_xe, P.id_xe, P.ten_xe, O.gia, O.qty FROM hopdong O INNER JOIN xe P ON  O.id_xe = P.id_xe WHERE O.id_nguoidung = ".$idCusomer." AND O.id_hopdong = '".$idOder."'");
  if ($resultA -> num_rows > 0) {
      while($rowA = $resultA -> fetch_assoc()) {
        echo '
            <div class="list-main-product-item">
              <div class="list-main-product-img">
                  <img src="../../images/'.$rowA['anh_xe'].'" alt="">
              </div>
              <div class="list-main-product-name">
                  <a href="../../Product_Detail/sanpham.php?id='.$rowA['id_xe'].'">'.$rowA['ten_xe'].'</a>
                  <span class="price">Đơn Giá: <b>'.number_format($rowA['gia']).' đ</b></span>
              </div>
              <div class="list-main-product-qty">
                  <span class="qty"><b>'.$rowA['qty'].'</b> Ngày</span>
              </div>
            </div>
            <!-- end list-main-product-item -->
        ';
        $totalCashProduct += $rowA['qty']*$rowA['gia'];
      }
  }
}
function showProductOrderItem2($idCusomer, $idOder) {
  global $totalCashProduct;
  $totalCashProduct = 0;
  $connA = connectDB();
  $resultA = $connA -> query("SELECT P.anh_xe, P.id_xe, P.ten_xe, O.gia, O.qty FROM hopdong O INNER JOIN xe P ON  O.id_xe = P.id_xe WHERE O.id_nguoidung = ".$idCusomer." AND O.id_hopdong = '".$idOder."'");
  if ($resultA -> num_rows > 0) {
      while($rowA = $resultA -> fetch_assoc()) {
        echo '
            <div class="list-main-product-item">
              <div class="list-main-product-img">
                  <img src="../images/'.$rowA['anh_xe'].'" alt="">
              </div>
              <div class="list-main-product-name">
                  <a href="../../Product_Detail/sanpham.php?id='.$rowA['id_xe'].'">'.$rowA['ten_xe'].'</a>
                  <span class="price">Đơn Giá: <b>'.number_format($rowA['gia']).' đ</b></span>
              </div>
              <div class="list-main-product-qty">
                  <span class="qty"><b>'.$rowA['qty'].'</b> Ngày</span>
              </div>
            </div>
            <!-- end list-main-product-item -->
        ';
        $totalCashProduct += $rowA['qty']*$rowA['gia'];
      }
  }
}

// Hiện thị các option trạng thái
function showStatus($statusNow) {
  $connB = connectDB();
  $resultB = $connB -> query("SELECT * FROM trangthai WHERE trangthai.id NOT IN (1,6) AND trangthai.id > ".$statusNow."");
  if ($resultB -> num_rows > 0) {
      while($rowB = $resultB -> fetch_assoc()) {
        echo '<option value="'.$rowB['id'].'">'.$rowB['ten_trangthai'].'</option>';
      }
  }
}
// cập nhật trạng thái đơn hàng trong admin
function updateStatus($idCusomer, $idOder, $valStatus) {
    $connC = connectDB();
    $connC -> query("UPDATE hopdong SET hopdong.trangthai = ".$valStatus." WHERE  hopdong.id_nguoidung = ".$idCusomer." AND hopdong.id_hopdong = '".$idOder."'");
    
}

// show scombo
function showProductHot () {
  $conn = connectDB();
            $result = $conn->query("SELECT * FROM xe WHERE id_danhmuc = 1");
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo '
                  <a href="./Product_Detail/sanpham.php?id='.$row['id_xe'].'">
                    <div class="item-product-hot">
                      <div class="item-product-hot-img">
                        <img class="product-img" src="./images/'.$row['anh_xe'].'" alt=""/>
                        <span class="price">'.number_format($row['gia_xe']).' đ</span>
                      </div>
                      <div class="item-product-information">
                        <p class="name-product">'.$row['ten_xe'].'</p>

                      </div>
                    </div>
                    <!-- end  item-product-hot-->
                  </a>
                ';
              }
            }
}







error_reporting(0);
define("SMTP_HOST","smtp.gmail.com");
define("SMTP_POST","465");
define("SMTP_UNAME","ndh09092002@gmail.com");
define("SMTP_FWORD","HiME");
