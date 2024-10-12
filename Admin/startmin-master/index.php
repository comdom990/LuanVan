<?php 
    require_once('../../ConnectDB/connectDB.php'); 
    ob_start();
    session_start();
    $conn = connectDB();
    $user_id = 0;
    $name = '';
        if(!empty($_SESSION['nguoi_dung'])){
            $user_id = $_SESSION['nguoi_dung']['id_nd'] ?? 0;
            $result = $conn->query("SELECT * FROM nguoi_dung where id_nd = '$user_id'");
            $result = $result->fetch_all(MYSQLI_ASSOC);
            $name = $result[0]['tentaikhoan'];
          
        }
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="refresh" content="0;url=pages/index.php">
    <title>Startmin</title>
    <script language="javascript">
        window.location.href = "pages/index.php"
    </script>
</head>
<body>
<a href="pages/index.php">Go to Demo</a>
</body>
</html>
