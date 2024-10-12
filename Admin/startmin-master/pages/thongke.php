

<?php

// [Date]
// ;Defines the default timezone used by the date functions
// ;http://php.net/date.timezone
// date.timezone = Europe/Athens
/* server timezone */
define('CONST_SERVER_TIMEZONE', 'UTC');
/* server dateformat */

require_once('../../../ConnectDB/connectDB.php');

$conn = connectDB();
    ob_start();
    session_start();
    function shortenAddress($address, $maxLength = 30) {
        if (strlen($address) > $maxLength) {
            return substr($address, 0, $maxLength) . '...'; // Thêm '...' vào cuối
        }
        return $address;
    }
    $sql = $conn->query("SELECT ph.ten_phuong AS phuong, COUNT(p.id_pt) AS so_luong_phong FROM cho_o co INNER JOIN phong p INNER JOIN phuong ph ON co.id_phuong = ph.id_phuong and co.id_cho = p.id_cho GROUP BY co.id_phuong;");

    $chart_data = [];
    while ($val = mysqli_fetch_array($sql)) {
        $chart_data[] = array(
            'dc' => shortenAddress($val['phuong'], 30), // Rút gọn địa chỉ
            'sl' => $val['so_luong_phong']
        );
    }
    
    echo $data = json_encode($chart_data);


?>
