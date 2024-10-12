<?php
while ($row = mysqli_fetch_assoc($sql)) {
    $sql2 = "SELECT t.id_nd1, t.id_nd, t.id_tn, t.noi_dung 
             FROM tin_nhan t 
             INNER JOIN nguoi_dung n ON (t.id_nd = n.id_nd OR t.id_nd1 = n.id_nd)
             WHERE (t.id_nd = {$row['id_nd']} OR t.id_nd1 = {$row['id_nd']})
             AND (t.id_nd1 = {$outgoing_id} OR t.id_nd = {$outgoing_id}) 
             ORDER BY t.id_tn DESC LIMIT 1";
              
    $query2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($query2);

    if ($row2) { // Kiểm tra nếu có tin nhắn
        $result = $row2['noi_dung'];
        $you = ($outgoing_id == $row2['id_nd1']) ? "Bạn: " : ""; // Kiểm tra người gửi
        
        // Xử lý nội dung tin nhắn
        $noi_dung = (strlen($result) > 28) ? substr($result, 0, 20) . '...' : $result;
        $noi_dung = ($you) ? '<span class="sent-message">' . htmlspecialchars($noi_dung) . '</span>' : 
                             '<span class="received-message">' . htmlspecialchars($noi_dung) . '</span>'; // Thêm màu sắc
    } else {
        $result = "Không có tin nhắn";
        $noi_dung = '<span>' . htmlspecialchars($result) . '</span>';
        $you = ""; // Không có tin nhắn
    }

    // Kiểm tra trạng thái người dùng
    $offline = (isset($row['status']) && $row['status'] == "Không truy cập") ? "offline" : "";

    // Tạo output
    $output .= '<a class="text-decoration-none" href="./index.php?id_nd=' . $row['id_nd'] . '">
        <div class="content">
            <img src="../img/avata/' . $row['hinhanh'] . '" alt="">
            <div class="details">
                <span>' . $row['hoten'] . '</span>
                <p>' . $you . $noi_dung . '</p>
            </div>
        </div>
        <div class="status-dot ' . $offline . '"><i class="fa-solid fa-circle"></i></div>
    </a>';
}
?>