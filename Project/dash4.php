<?php
session_start();
if(empty($_SESSION['login_userid'])){
    session_destroy();
    header("Location:index.php");
    exit();
}
require_once("connect_members.php");
$sql = "SELECT measure_time FROM peaks WHERE measure_time = ?";
if($stmt = mysqli_prepare($link, $sql)){
    mysqli_stmt_bind_param($stmt, 's', $param_time);
    $param_time = $_SESSION['latest_date'];
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) == 0){
            $temps = array_fill(1, 12, 0);
            print_r($temps);
            $theData = $_SESSION['theData'];
            $indexes = explode(" ", $theData[1]);
            $numbers = explode(" ",$theData[2]);
            $values = explode(" ",$theData[3]);

            foreach($numbers as $key => $vals){
                $temps[(int)$indexes[$key]] = $vals;
            }
            foreach($values as $key => $vals){
                $temps[(int)$indexes[$key]] = $temps[(int)$indexes[$key]]."-".$vals;
            }
            foreach($temps as $key => $vals){
                if($vals == 0)
                {
                    $temps[$key] = null;
                }
            }
            $date = date('Y-m-d H:i:s');
            $sql2 = "INSERT INTO peaks (userid, measure_time, firstPeaks, secondPeaks, thirdPeaks, fourthPeaks, fifthPeaks, sixthPeaks, seventhPeaks, eighthPeaks, ninthPeaks, tenthPeaks, eleventhPeaks, twelvethPeaks) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            if($stmt2 = mysqli_prepare($link, $sql2)){
                mysqli_stmt_bind_param($stmt2, 'ssssssssssssss', $param_userid, $param_datetime, $param_peak1, $param_peak2, $param_peak3, $param_peak4, $param_peak5, $param_peak6, $param_peak7, $param_peak8, $param_peak9, $param_peak10, $param_peak11, $param_peak12);
                $param_userid = $_SESSION['login_userid'];
                $param_datetime = $_SESSION['latest_date'];
                $param_peak1 = $temps[1];
                $param_peak2 = $temps[2];
                $param_peak3 = $temps[3];
                $param_peak4 = $temps[4];
                $param_peak5 = $temps[5];
                $param_peak6 = $temps[6];
                $param_peak7 = $temps[7];
                $param_peak8 = $temps[8];
                $param_peak9 = $temps[9];
                $param_peak10 = $temps[10];
                $param_peak11 = $temps[11];
                $param_peak12 = $temps[12];
                if(mysqli_stmt_execute($stmt2)){
                }
                else{
                }
            }
            mysqli_stmt_close($stmt2);
        }
    }
}
mysqli_stmt_close($stmt);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>

    <style>
    path {stroke-width: 4;fill: none;}
    .axis {shape-rendering: crispEdges;}
    .x.axis line {stroke: lightgrey;}
    .x.axis .minor {stroke-opacity: .5;}
    .x.axis path {display: none;}
    .y.axis line, .y.axis path {fill: none;stroke: #000;stroke-width: 1;}
</style>

<title>Dashboard 4.0</title>

<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap.css" rel="stylesheet">
<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="custom_css/dash4_top_nav.css" rel="stylesheet">
<link href="custom_css/dash4_css.css" rel="stylesheet">
<link href="custom_css/custom_sidebar.css" rel="stylesheet">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Custom Fonts -->

</head>

<body>
    <!-- sidebar and topnav -->
    <div id="wrapper">
        <div class="overlay"></div>
        <!-- Sidebar -->
        <nav id="sidebar">
          <div class="sidebar-header">
            <div class="text-right"><h2>PULSER 2.0</h2></div>
            <div id="dismiss"><span class="glyphicon glyphicon-remove"></span></div></div>
            <ul class="list-unstyled components">
                <li class="active"><a href="dash4.php"><label>Dashboard</label></a></li>
                <div class="sidebar_inside_padding1"></div>
                <li><a href="date_map1.php"><span class="glyphicon glyphicon-th-list"></span>紀錄搜尋</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-user"></span>社群</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-book"></span>說明</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-info-sign"></span>關於我們</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-earphone"></span>聯絡我們</a></li>
            </ul>
            <ul class="list-unstyled CTAs">
                <li><a href="index.php"><span class="glyphicon glyphicon-home"></span>首頁</a></li>
                <li><a href="profile.php"><span class="glyphicon glyphicon-cog"></span>個人資訊設定</a></li>
            </ul>
        </nav>
        <!--Sidebar-->
        <div style="height:5px;background: #000;"></div>
        <!-- top-nav -->
        <nav class="navbar navbar-default" role="navigation">
            <div class="container-fluid" id="navbar-container">
                <div class="navbar-header">
                    <button id="theButton" type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="glyphicon glyphicon-chevron-down"></span> 
                    </button>
                    <a class="navbar-brand"><i id="sidebarCollapse" class="fa fa-bars" aria-hidden="true"></i></a>
                    <a id="homepage" class="navbar-brand" href="index.php"><i class="fa fa-home" aria-hidden="true"></i><label>PULSER 2.0</label></a>

                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                 <ul class="nav navbar-nav navbar-right">
                    <li><a href="profile.php"><i class="fa fa-user-circle-o" aria-hidden="true"></i><?php echo($_SESSION['login_userid']);?></a></li>
                    <li><a href="logout.php"><i id="sign_out_i" class="fa fa-sign-out" aria-hidden="true"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>
        <!--<ul class="nav navbar-nav navbar-left">
            <li>
                <a href="index.php">
                    <i class="fa fa-home" aria-hidden="true"></i>
                    <label>PULSER 2.0</label>
                </a>
            </li>
            <li class="menu"><a><i id="sidebarCollapse" class="fa fa-bars" aria-hidden="true"></i></a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="profile.php"><i class="fa fa-user-circle-o" aria-hidden="true"></i><?php echo($_SESSION['login_userid']);?></a></li>
            <li><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i></a></li>
        </ul>-->

        <!-- top-nav -->
    </div>
    <!-- sidebar and topnav -->
    <!-- page-wrapper -->
    <div id="page-wrapper">
        <!-- page-wrapper-container-fluid -->
        <div class="container-fluid">
           <!--row of dashboard4.0-->
           <div class="row">
            <div style="height:20px;"></div>
            <div class="container-fluid text-center">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label id="page-header">Dashboard 2.0</label>
                </div>
            </div>
            <div class="clearfix"></div>
            <div style="height:20px;"></div>
        </div>
        <div class="text-center dash_title list-unstyled">
          <li>
            <a><span class="glyphicon glyphicon-calendar dash4_today_span"></span></a>
            <label id="today-label">今天</label><label id="DATE"></label>
        </li>
    </div>
    <div style="height:20px;"></div>
    <!--row of dashboard4.0-->


    <!--4panel-row-->
    <div class="row">
        <!--red_panel-->
        <div class="col-lg-3 col-md-3 col-xs-12">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-12 text-right">
                            <div>
                                <span class="glyphicon glyphicon-grain"></span><label>生理</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <span class="pull-left">
                        <div>身高</div>
                        <div>體重</div>
                    </span>
                    <span class="pull-right">
                        <div><?php echo($_SESSION['user_height']);?>公分</div>
                        <div><?php echo($_SESSION['user_weight']);?>公斤</div>
                    </span>
                    <div class="clearfix"></div>
                </div>

            </div>
        </div>
        <!--red_panel-->
        <!--primary_panel-->
        <div class="col-lg-3 col-md-3 col-xs-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-12 text-right">
                            <div><span class="glyphicon glyphicon-zoom-in"></span><label>測量</label></div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <span class="pull-left">
                        <div>最近脈搏測量</div>
                    </span>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!--primary_panel-->
        <!--yellow_panel-->
        <div class="col-lg-3 col-md-3 col-xs-12">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-12 text-right">
                            <div><span class="glyphicon glyphicon-tint"></span><label>健康值</label></div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <span class="pull-left">
                        <div><span class="glyphicon glyphicon-warning-sign"></span><label>危險</label></div>
                    </span>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!--yellow_panel-->
        <!--green_panel-->
        <div class="col-lg-3 col-md-3 col-xs-12">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-12 text-right">
                            <div><span class="glyphicon glyphicon-equalizer"></span><label>建議</label></div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <span class="pull-left">
                        <div>醫師建議</div>
                    </span>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!--green_panel-->
    </div>
    <!--4panel-row-->
    <div style="height:40px;"></div>

    <!--RAW-->
    <div class="dash4_map">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-bar-chart-o fa-fw"></i>
                    <label class="dash4_map_label">原始圖型</label>
                </h3>
            </div>
            <div class="panel-body">
                <div id="container_raw" class="svg-container"></div>
            </div>
        </div>

        <!--RAW-->
        <div class="dash4_map_spacewhite"></div>
        <!--FFT-->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-bar-chart-o fa-fw"></i>
                    <label class="dash4_map_label">FFT圖型</label>
                </h3>
            </div>
            <div class="panel-body">
                <div id="container_fft" class="svg-container"></div>
            </div>
        </div>
        <!--FFT-->
        <div class="dash4_map_spacewhite"></div>
        <!--FFT-PeakLoad-->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-bar-chart-o fa-fw"></i>
                    <label class="dash4_map_label">FFT-30圖型</label>
                </h3>
            </div>
            <div class="panel-body">
                <div id="container_fft30" class="svg-container"></div>
            </div>
        </div>
        <!--FFT-PeakLoad-->

        <div class="dash4_map_spacewhite"></div>

        <!-- table -->
    <!--<div class="row">
        <div class="col-lg-12 dash4_map">
            <div class="panel-heading">
                <h3 class="panel-title text-center">
                    <i class="fa fa-bar-chart-o fa-fw"></i>
                    <label class="dash4_map_label">12 Peaks</label>
                </h3>
            </div>
            <div id="12Peaks">
                <table class="table table-striped table-bordered table-list table-hover" id="table-peaks"  border='1'>
                    <tr><td></td><td></td><td></td></tr>
                    <tr><td></td><td></td><td></td></tr>
                    <tr><td></td><td></td><td></td></tr>
                    <tr><td></td><td></td><td></td></tr>
                    <tr><td></td><td></td><td></td></tr>
                    <tr><td></td><td></td><td></td></tr>
                    <tr><td></td><td></td><td></td></tr>
                    <tr><td></td><td></td><td></td></tr>
                    <tr><td></td><td></td><td></td></tr>
                    <tr><td></td><td></td><td></td></tr>
                    <tr><td></td><td></td><td></td></tr>
                    <tr><td></td><td></td><td></td></tr>
                    <tr><td></td><td></td><td></td></tr>
                    <tr><td colspan="3"></td></tr>
                </table>
            </div>
        </div>
    </div>-->
    <!-- table -->


</div>
<!-- page-wrapper-container-fluid -->
<div style="height:40px;"></div>

</div>
<!-- page-wrapper -->



<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type='text/javascript'></script>

<!--custom_javascript-->

<script src="js/raw.js"></script>
<script src="js/fft.js"></script>
<script src="js/fft_30.js"></script>
<script src="js/today_date.js"></script>
<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<!-- jQuery Custom Scroller CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
      $("#sidebar").mCustomScrollbar({
        theme: "minimal"
    });

      $('#dismiss, .overlay').on('click', function () {
        $('#sidebar').removeClass('active');
        $('.overlay').fadeOut();
    });

      $('#sidebarCollapse').on('click', function () {
        $('#sidebar').addClass('active');
        $('.overlay').fadeIn();
        $('.collapse.in').toggleClass('in');
    });
  });
</script>
</body>

</html>

