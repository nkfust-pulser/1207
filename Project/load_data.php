<?php
session_start();
if(empty($_SESSION['login_userid'])){
	header('Location:login.php');
	exit(); 
}
require_once("connect_members.php");
$userid = $user_real_name = $user_mail_address = $user_sex = $user_phone = $user_height = $user_weight = "";
$userid = $_SESSION['login_userid'];
$sql = "SELECT userid, username, mail_address, user_sex, user_phone, user_height, user_weight FROM users_information where userid = ?";
if($stmt = mysqli_prepare($link, $sql)){
	mysqli_stmt_bind_param($stmt, 's', $param_userid);
	$param_userid = $userid;
	if(mysqli_stmt_execute($stmt)){
		mysqli_stmt_store_result($stmt);
		if(mysqli_stmt_num_rows($stmt) == 1){
			mysqli_stmt_bind_result($stmt,$userid,$user_real_name,$user_mail_address,$user_sex,$user_phone,$user_height,$user_weight);
			if(mysqli_stmt_fetch($stmt)){
				$_SESSION['userid'] = $userid;
				$_SESSION['user_real_name'] = $user_real_name;
				$_SESSION['user_mail_address'] = $user_mail_address;
				$_SESSION['user_sex'] = $user_sex;
				$_SESSION['user_phone'] = $user_phone;
				$_SESSION['user_height'] = $user_height;
				$_SESSION['user_weight'] = $user_weight;
				header("Location:dash4.php");
			}
		}
	}
	echo("不知道哪裡出錯了...抱歉請重新登入");
}
mysqli_stmt_close($stmt);
$array2 = array();
$sql = "SELECT measure_time FROM measure_time ORDER BY measure_time DESC";
if($stmt = mysqli_prepare($link,$sql)){
	if(mysqli_stmt_execute($stmt)){
		mysqli_stmt_bind_result($stmt, $file_names);
		while(mysqli_stmt_fetch($stmt)){

			$array2[] = $file_names;
		}
	}
}
mysqli_stmt_close($stmt);
$last_date = $array2[0];
$_SESSION['latest_date'] = $last_date;
$last_filename1 = str_replace('-',"",$last_date);
$last_filename2 = str_replace(':',"",$last_filename1);
$last_filename3 = str_replace(" ","",$last_filename2);
$_SESSION['which_file'] = $last_filename3;

if(!(empty($_SESSION['which_file']))){
	$python = "D:\\Python36\\python.exe";
	$pythonscript = "C:\\xampp\\htdocs\\Project\\python\\ff3-4.py";

	$item = $_SESSION['which_file'];
	$output = array();
	$cmd = ("$python $pythonscript $item");
	exec("$cmd",$output);

	$_SESSION['theData'] = $output;
}
?>

<?php
mysqli_close($link);
?>