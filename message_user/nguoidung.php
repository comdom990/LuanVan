<?php
require_once('../ConnectDB/connectDB.php'); 
ob_start();
session_start();
$conn = connectDB();
$user_id = 0;

    if(!empty($_SESSION['nguoidung'])){
        $user_id = $_SESSION['nguoidung']['id_nd'] ?? 0;
     
        $result = $conn->query("SELECT * FROM nguoi_dung where id_nd = '$user_id'");
        $result = $result->fetch_all(MYSQLI_ASSOC);
        
      
    }
$outgoing_id = $_SESSION['nguoidung']['id_nd'] ?? 0;
$sql=$conn->query("SELECT * FROM nguoi_dung where not id_nd ={$outgoing_id} ");
$output='';
if(mysqli_num_rows($sql)==0){
    $output.="Không má nào hoạt động";
}elseif(mysqli_num_rows($sql)>0){
    include "data.php"; 

}
echo $output;
?>