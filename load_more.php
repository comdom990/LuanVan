<?php
require_once('./ConnectDB/connectDB.php');
$conn = connectDB();


$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;

$query = "SELECT  p.id_pt, nd.hoten,co.dia_chi,bd.mo_ta,bdp.gia,ha.anh_dai_dien,ha.anh,nd.id_nd FROM cho_o co inner join nguoi_dung nd inner join bai_dang bd inner join bai_dang_phong bdp inner join phong p INNER join hinh_anh ha
     ON  co.id_bd = bd.id_bd and co.id_nd = nd.id_nd and nd.id_nd = bd.id_nd and bdp.id_bd = bd.id_bd and p.id_pt = ha.id_pt and p.id_cho = co.id_cho 
     WHERE ha.anh_dai_dien = 1  LIMIT $offset, $limit"; // Thay your_table_name bằng tên bảng của bạn
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        ?>
        <div class="col">
            <div class="p-3">
                <div class="hot_city">
                    <img src="./img/<?= $row['anh'] ?>" alt="" class="img_hou w-100" style="height: 150px;">
                    <div class="title_hou">
                        <h3 class="andress" style="font-size: 12px;"><?= $row['dia_chi'] ?></h3>
                        <p class="sl">Giá tiền: <?= number_format($row['gia']) ?> VNĐ/tháng</p>
                    </div>
                </div>
            </div>
            <a href="./detail/list_home.php?id=<?= $row['id_pt'] ?>" class="submit nav-link">
                <div class="sub_user">Xem</div>
            </a>
        </div>
        <?php 
    }
} else {
    echo ''; // Không còn bài đăng nào để hiển thị
}

$conn->close();
?>