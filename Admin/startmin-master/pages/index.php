<?php 
    require_once('../../../ConnectDB/connectDB.php'); 
    
    ob_start();
    session_start();
    $conn = connectDB();
   
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Admin</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <!-- Bootstrap Core CSS -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="../css/metisMenu.min.css" rel="stylesheet">

        <!-- Timeline CSS -->
        <link href="../css/timeline.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="../css/startmin.css" rel="stylesheet">

        <!-- Morris Charts CSS -->
        <link href="../css/morris.css" rel="stylesheet">
        <link href="../css/css.css" rel="stylesheet">
        <!-- Custom Fonts -->
        <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">CO'HOUSE</a>
                </div>

             

                <ul class="nav navbar-nav navbar-left navbar-top-links">
                    <li><a href="../../../trangchu.php"><i class="fa fa-home fa-fw"></i> Website</a></li>
                </ul>

               
                <!-- /.navbar-top-links -->
            </nav>

            <aside class="sidebar navbar-default" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="index.php" class="active active-title"><i class="fa fa-dashboard fa-fw"></i>Thống kê</a>
                        </li>
                      
                        <li>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a class="active-title" href="./morris_nguoidung.php">Người dùng</a>
                                </li>
                                <li>
                                    <a class="active-title" href="./morris_baidang.php">Bài đăng</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        
                        
                        
                    </ul>
                </div>
            </aside>
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">Tổng Quát</h1>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa-solid fa-tablet fa-5x" ></i>
                                            
                                            <!-- <i class="fa fa-comments fa-5x"></i> -->
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <?php 
                                            $conn = connectDB();
                                            $result = $conn -> query("SELECT COUNT(id_bd) AS 'SL' FROM bai_dang ");
                                            $row = $result-> fetch_assoc();
                                            echo'
                                            <div class="huge">'.$row["SL"].'</div>
                                            <div>Bài đăng</div>
                                            ';
                                            ?>
                                            </div>
                                        </div>
                                </div>
                                <a href="../../../home/list_home.php">
                                    <div class="panel-footer">
                                        <span class="pull-left">Xem chi tiết</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                        <i class="fa-solid fa-tablet fa-5x" ></i>

                                            <!-- <i class="fa fa-comments fa-5x"></i> -->
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <?php 
                                            $conn = connectDB();
                                            $result = $conn->query("SELECT COUNT(*) AS so_bai_dang FROM bai_dang WHERE DATE(ngay_dang) = CURDATE();");

                                            $row = $result-> fetch_assoc();
                                            echo'
                                            <div class="huge">'.$row["so_bai_dang"].'</div>
                                            <div>Số lượng bài đăng mới</div>
                                            ';
                                            ?>
                                            </div>
                                        </div>
                                </div>
                                <a href="../../../search-home/list_user.php">
                                    <div class="panel-footer">
                                        <span class="pull-left">Xem chi tiết</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-users fa-5x" ></i>
                                            <!-- <i class="fa fa-comments fa-5x"></i> -->
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <?php 
                                            $conn = connectDB();
                                            $result = $conn -> query("SELECT COUNT(id_nd) AS 'SL' FROM nguoi_dung WHERE ghichu IS NOT NULL AND ghichu <> '';");
                                            $row = $result-> fetch_assoc();
                                            echo'
                                            <div class="huge">'.$row["SL"].'</div>
                                            <div>Người tìm kiếm trọ</div>
                                            ';
                                            ?>
                                            </div>
                                        </div>
                                </div>
                                <a href="../../../search-home/list_user.php">
                                    <div class="panel-footer">
                                        <span class="pull-left">Xem chi tiết</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                        <i class="fa fa-users fa-5x" ></i>


                                            <!-- <i class="fa fa-comments fa-5x"></i> -->
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <?php 
                                            $conn = connectDB();
                                            $result = $conn->query("SELECT COUNT(*) AS id_nd FROM nguoi_dung ");

                                            $row = $result-> fetch_assoc();
                                            echo'
                                            <div class="huge">'.$row["id_nd"].'</div>
                                            <div>Số lượng người đăng ký</div>
                                            ';
                                            ?>
                                            </div>
                                        </div>
                                </div>
                                <a href="../../../search-home/list_user.php">
                                    <div class="panel-footer">
                                        <span class="pull-left">Xem chi tiết</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                     
                        
                    </div>
                    <!-- /.row -->
                    <!-- <div class="row">
                        <div class="col-lg-8">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-bar-chart-o fa-fw"></i> Area Chart Example
                                    <div class="pull-right">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                                Actions
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu pull-right" role="menu">
                                                <li><a href="#">Action</a>
                                                </li>
                                                <li><a href="#">Another action</a>
                                                </li>
                                                <li><a href="#">Something else here</a>
                                                </li>
                                                <li class="divider"></li>
                                                <li><a href="#">Separated link</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="panel-body">
                                    <div id="morris-area-chart"></div>
                                </div>
                               
                            </div>
                          
                            
                        </div>
                     
                        
                        
                    </div> -->
                    <!-- /.row -->
                     
                </div>
                
                <!-- /.container-fluid -->
                 
            </div>
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">Thống kê chổ ở theo địa chỉ</h1>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                    <div class="row row-chart">
                    <div class="col-lg-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Thống kê chổ ở theo địa chỉ
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <h2>Thống Kê Số Lượng chổ ở theo địa chỉ</h2>
                                    <span id="text-date"></span>
                                    <div id="morris-area-chart" style="height: 250px;"></div>
                                    
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
                        </div>
                        <div class="col-lg-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Thống kê bài đăng
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <!-- <h2>Thống Kê Số Lượng Bài Đăng Theo Người Dùng</h2> -->
                                    
                                    <div id="text-date" style=""></div>
                                    <div id="morris-area-chart2" style="height: 250px;"></div>
                                    
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
                        </div>
                        <!-- /.col-lg-6 -->
                       
                        <!-- /.col-lg-6 -->
                      
                        <!-- /.col-lg-6 -->
                    </div>
                    <!-- /.row -->
                </div>
               
                        <!-- Page-header end -->
                     
                   
                <!-- /.container-fluid -->
            </div>
            <!-- /.sidebar -->

            
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

           <!-- jQuery -->
           <script src="../js/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="../js/metisMenu.min.js"></script>

<!-- Morris Charts JavaScript -->
<script src="../js/raphael.min.js"></script>
<script src="../js/morris.min.js"></script>
<!-- <script src="../js/morris-data.js"></script> -->

<!-- Custom Theme JavaScript -->
<script src="../js/startmin.js"></script>

<!-- Custom Theme JavaScript -->
<script src="../js/startmin.js"></script>
               
    <script type="text/javascript">
    $(document).ready(function(){
        thongke();

        var char = new Morris.Bar({
            // ID of the element in which to draw the chart.
            element: 'morris-area-chart',
            xkey: 'dc', // Tên địa chỉ
            ykeys: ['sl'], // Số lượng chỗ ở
            labels: ['Số lượng nhà trọ'], // Nhãn cho trục y
            barColors: ['#0b62a4'], // Màu cho cột
            xLabelAngle: 45, // Góc hiển thị tên địa chỉ
            hideHover: 'auto' // Ẩn tooltip khi không di chuột
        });

        function thongke() {
            var text = 'Theo địa chỉ';
            $('#text-date').text(text);
            $.ajax({
                url: "thongke.php",
                method: "POST",
                dataType: "JSON",
                success: function(data) {
                    char.setData(data);
                    $('#text-date').text(text);
                }
            });
        }
    });
</script>



<script type="text/javascript">
    $(document).ready(function(){
        thongke();

        var char = new Morris.Bar({
            element: 'morris-area-chart2',
            xkey: 'tieu_de', // Tiêu đề bài đăng
            ykeys: ['luot_xem'], // Số lượt xem
            labels: ['Số lượt xem'], // Nhãn cho trục y
            barColors: ['#0b62a4'],
            hideHover: 'auto' // Ẩn tooltip khi không di chuột
        });

        function thongke() {
            var text = 'Thống kê số lượt xem bài đăng';
            $('#text-date').text(text);
            $.ajax({
                url: "thongke_baidang.php", // Đường dẫn tới tệp PHP
                method: "POST",
                dataType: "JSON",
                success: function(data) {
                    char.setData(data);
                    $('#text-date').text(text);
                }
            });
        }
    });
</script>

<script type="text/javascript">
$(document).ready(function(){
    thong_tk();
    var char = new Morris.Bar({
        // ID of the element in which to draw the chart.
        element: 'morris-area-chart-nd',
       
        xkey: 'username',
       
        ykeys: ['quantity'],
     
        labels: ['Số bài đăng']
    });
    function thong_tk(){
        var text = 'Theo người dùng';
        $('#text-date-nd').text(text);
        $.ajax({
            url:"thong_tk.php",
            method:"POST",
            dataType: "JSON",

            success: function(data){
                char.setData(data);
                $('#text-date-nd').text(text);
            }
        });
    }

});
</script> 
    </body>

</html>