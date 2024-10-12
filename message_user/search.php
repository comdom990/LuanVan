<?php
    require_once('../ConnectDB/connectDB.php'); 
    ob_start();
    session_start();
    $conn=connectDB();
    $outgoing_id = $_SESSION['nguoidung']['id_nd'] ?? 0;
    $searchTerm = mysqli_real_escape_string($conn,$_POST['searchTerm']);
    $output='';
    $sql=$conn->query("SELECT * FROM nguoi_dung WHERE not id_nd ={$outgoing_id} AND (hoten LIKE'%{$searchTerm}%')");
    if(mysqli_num_rows($sql)>0){
        include "data.php";
    }else{
        $output.="Không có ai";
    }
    echo $output;
?>