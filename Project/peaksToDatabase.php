<?php
session_start();
if(empty($_SESSION['login_userid']))
{
	header("Location:login.php");
}

require_once("connect_members.php");
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
print_r($temps);
$date = date('Y-m-d H:i:s');
print_r($date);
$sql2 = "INSERT INTO peaks (userid, measure_time, firstPeaks, secondPeaks, thirdPeaks, fourthPeaks, fifthPeaks, sixthPeaks, seventhPeaks, eighthPeaks, ninthPeaks, tenthPeaks, eleventhPeaks, twelvethPeaks) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
if($stmt = mysqli_prepare($link, $sql2)){
	mysqli_stmt_bind_param($stmt, 'ssssssssssssss', $param_userid, $param_datetime, $param_peak1, $param_peak2, $param_peak3, $param_peak4, $param_peak5, $param_peak6, $param_peak7, $param_peak8, $param_peak9, $param_peak10, $param_peak11, $param_peak12);
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
	if(mysqli_stmt_execute($stmt)){
		echo('success!');
	}
	else{
		echo('error!');
	}
}

?>