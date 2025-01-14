<?php 
    require_once('../../../ConnectDB/connectDB.php'); 
    
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
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Startmin - Bootstrap Admin Theme</title>

        <!-- Bootstrap Core CSS -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="../css/metisMenu.min.css" rel="stylesheet">

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
        <script src="https://www.gstatic.com/charts/loader.js"></script>   
    </head>

    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">Chợ Sale - Admin</a>
                </div>

                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <ul class="nav navbar-nav navbar-left navbar-top-links">
                    <li><a href="../../../trangchu.php"><i class="fa fa-home fa-fw"></i> Website</a></li>
                </ul>

                <ul class="nav navbar-right navbar-top-links">
                    <li class="dropdown navbar-inverse">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-bell fa-fw"></i> <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu dropdown-alerts">
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-comment fa-fw"></i> New Comment
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                        <span class="pull-right text-muted small">12 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-envelope fa-fw"></i> Message Sent
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-tasks fa-fw"></i> New Task
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a class="text-center" href="#">
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i> <?= $user_id == 0 ? 'Tài khoản' : $name ?> <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                        <?php if($user_id == 0) { ?>
                            <li><a class="dropdown-item" href="./../../../login/dangnhap.php"></i>Đăng nhập</a></li>
                            <li><a class="dropdown-item" href="./../../../login/dangky.php"></i>Đăng ký</a></li>
                        <?php } else { ?>
                            <li><a class="dropdown-item" href="./../../../login/dangxuat.php"> Đăng xuất</a></li>
                            <li><a class="dropdown-item" href="./Ad_trangcanhan.php">Hồ sơ của tôi</a></li>
                        <?php } ?>
                            <!-- <li>
                                <a href="../../../trangcanhan.php"><i class="fa fa-user fa-fw"></i>Hồ sơ của tôi</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="../../../login/dangnhap.php"><i class="fa fa-sign-out fa-fw"></i>Đăng xuất</a>
                            </li> -->
                        </ul>
                    </li>
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
                            <a href="index.php" class="active"><i class="fa fa-dashboard fa-fw"></i> Tổng Quát</a>
                        </li>
                      
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Thống kê<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="morris_nguoidung.php">Người dùng</a>
                                </li>
                                <li>
                                    <a href="morris_baidang.php">Bài đăng</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-files-o fa-fw"></i> Danh sách<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="./nguoidung_tables.php">Người dùng</a>
                                </li>
                                <li>
                                    <a href="./baidang_table.php">Bài đăng</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
            </aside>
            <!-- /.sidebar -->
                   
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">Thống kê người dùng</h1>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                    <div class="row row-chart">
                        <div class="col-lg-6">
                            <div
                            id="myChart" style="width:100%; max-width:600px; height:500px;">
                            </div>
                            <!-- <div class="panel panel-default">
                                <div class="panel-heading">
                                    Area Chart Example
                                </div>
                                <div class="panel-body">
                                    <h2>Thống Kê Người Dùng</h2>
                                    <span id="text-date"></span>
                                    <div id="morris-area-chart" style="height: 250px;"></div>
                                    
                                </div>
                               
                            </div> -->
                            <!-- /.panel -->
                        </div>
                
                    </div>
                    <!-- /.row -->
                </div>
               
                   
                <!-- /.container-fluid -->
            </div>
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
        <!-- <script type="text/javascript">
        $(document).ready(function(){
            thongke();
            var char = new Morris.Donut({
                // ID of the element in which to draw the chart.
                element: 'morris-area-chart',
                label: ['Số người dùng là'],
                value: ['quantity']
            });
            function thongke(){
                var text = 'Theo ngày';
                $('#text-date').text(text);
                $.ajax({
                    url:"thongke_nd.php",
                    method:"POST",
                    dataType: "JSON",

                    success: function(data){
                        char.setData(data);
                        $('#text-date').text(text);
                    }
                });
            }
       
    });
    </script> 
           -->

        <script>
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

        // Set Data
        const data = google.visualization.arrayToDataTable([
        ['Vai Trò', 'Số người dùng'],
        <?php 
            $conn = connectDB();
            $result = $conn -> query("SELECT v.ten_vt as mon,count(b.id_nd) as sl FROM nguoi_dung b INNER JOIN vai_tro v on b.id_vt=v.id_vt GROUP BY v.ten_vt");
            while ($row = $result -> fetch_assoc()) {
                echo "['".$row['mon']."', ".$row['sl']."],";
            }   
        ?>
        ]);
       
        // Set Options
        const options = {
        title:'Thống kê người dùng theo vai trò'
        };

        // Draw
        const chart = new google.visualization.PieChart(document.getElementById('myChart'));
        chart.draw(data, options);

        }
        </script>
                                       
    </body>

</html>