<?php
session_start();
if(empty($_SESSION['login_userid'])){
    session_destroy();
    header("Location:index.php");
    exit();
}

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

<title>Date and Map 1.0</title>

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
<link href="custom_css/date_map_css.css" rel="stylesheet">

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
                    <label id="page-header">紀錄查詢</label>
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

    <!--4panel-row-->
    <div class="chooser_date">
        <select id = "time_select"></select>
    </div>
    <!--RAW-->

    <div class="dash4_map">

        <div class="panel panel-default">
            <div class="panel-heading">
                <div style="display: inline;">
                    <button id="submitData_raw" type="button" class="btn btn-danger">RAW</button>
                    <button id="submitData_fft" type="button" class="btn btn-success">FFT</button>
                    <button id="submitData_fft30" type="button" class="btn btn-primary">FFT30</button>
                    <i class="fa fa-bar-chart-o fa-fw"></i>
                    <label  id="map_label">原始圖型</label>
                </div>


            </div>
            <div class="panel-body"><div id="container" class="svg-container"></div></div>
            
        </div>
    </div>
    <!-- page-wrapper-container-fluid -->
    <div style="height:40px;"></div>

</div>
<!-- page-wrapper -->



<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type='text/javascript'></script>

<!--custom_javascript-->
<script src="js/date_map_map.js"></script>
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
<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
<script>
    $(document).ready(function(){
        $.ajax({
            type: 'GET',
            url: 'test2.php',
            dataType: "json",  
            success: function(data) {
                loaddata(data);
            },
            error: function() {
                alert("ERROR");
            }
        });
    });


    function loaddata(d){
        var r = document.getElementById('time_select');
        var array1 = d;
        var t;
        var option = document.createElement("option");
        option.value = 0;
        option.text = "選擇時間";
        r.appendChild(option);
        for(t=0;t<array1.length;t++){
            option = document.createElement("option");
            option.value = array1[t];
            option.text = array1[t];
            r.appendChild(option);
        }
        document.getElementById("time_select").setAttribute("class","chooser");
    }
</script>

<script type="text/javascript">
    $("#submitData_raw").click(function(){
        var txt = document.getElementById('time_select').value;
        if(txt != 0){
            $.post("fromPython2.php",  {suggest: txt} ,function(data){
                console.log(txt);
                change_map_raw();
            });
        }
        else{
            console.log('raw_map_click error');
        }
    });
    $("#submitData_fft").click(function(){
        var txt = document.getElementById('time_select').value;
        if(txt != 0){
            $.post("fromPython2.php",  {suggest: txt} ,function(data){
                console.log(txt);
                change_map_fft();
            });
        }
        else{
            console.log('fft_map_click error');
        }
    });
    $("#submitData_fft30").click(function(){
        var txt = document.getElementById('time_select').value;
        if(txt != 0){
            $.post("fromPython2.php",  {suggest: txt} ,function(data){
                console.log(txt);
                change_map_fft30();
            });
        }
        else{
            console.log('fft30_map_click error');
        }
    });
</script>
<script type='text/javascript'>
    function change_map_raw()
    {
        d3.select('svg').remove();
        var x = '原始圖型';
        $.ajax({
            type: 'GET',
            url: 'fromPython2.php',
            dataType: "json",  
            success: function(data) {
                getRaw(data[5]);
            },
            error: function() {
                alert("ERROR");
            }
        });
        document.getElementById("map_label").innerHTML = x;
    }
    function change_map_fft()
    {
        d3.select('svg').remove();
        var x = "FFT圖型";
        $.ajax({
            type: 'GET',
            url: 'fromPython2.php',
            dataType: "json",  
            success: function(data) {
                getFFT(data[4],data[0]);
            },
            error: function() {
                alert("ERROR");
            }
        });
        document.getElementById("map_label").innerHTML = x;
    }
    function change_map_fft30()
    {
        d3.select('svg').remove();
        var x = "FFT-30圖型";
        $.ajax({
            type: 'GET',
            url: 'fromPython2.php',
            dataType: "json",  
            success: function(data) {
                getFFT30(data[4],data[0]);
            },
            error: function() {
                alert("ERROR");
            }
        });
        document.getElementById("map_label").innerHTML = x;
    }

</script>
</body>

</html>

