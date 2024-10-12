<?php
    require_once('../ConnectDB/connectDB.php'); 
    ob_start();
    session_start();
    $conn = connectDB();
    $user_id = 0;
    
        if(!empty($_SESSION['nguoidung'])){
            $user_id = $_SESSION['nguoidung']['id_nd'] ?? 0;
          
            if(isset($user_id)){
                $outgoing_id = mysqli_real_escape_string($conn,$_POST['outgoing_id']) ;
                $incoming_id = mysqli_real_escape_string($conn,$_POST['incoming_id']);
                
              $output="";
              $sql="SELECT * FROM tin_nhan t INNER JOIN nguoi_dung n ON t.id_nd = n.id_nd 
                    WHERE (t.id_nd='$incoming_id' and t.id_nd1='$outgoing_id') OR
                     (t.id_nd='$outgoing_id' AND t.id_nd1='$incoming_id') ORDER BY id_tn ";
             
             $query=mysqli_query($conn,$sql);
               if(mysqli_num_rows($query)>0){
                
                while($row = mysqli_fetch_assoc($query)){
                    if($row['id_nd1'] === $outgoing_id){
                        $output .='<div class="chat outgoing">
                                        <div class="details">
                                            <p>'.$row['noi_dung'].'</p>
                                        </div>
                                    </div>';
                    }else{
                        $output .='<div class="chat incoming">
                                        <img src="../img/avata/'.$row['hinhanh'].'" alt="">
                                        <div class="details">
                                            <p>'.$row['noi_dung'].'</p>
                                        </div>
                                    </div>';
                    }
                }
                echo $output;
               }
            }
          
        }
    
?>