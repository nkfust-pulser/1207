<?php 
require_once('connect_members.php');
if(!(empty(trim($_POST['mail_sent'])))){

	$sql = "SELECT id FROM members_account WHERE mail_address = ?";
	if($stmt = mysqli_prepare($link,$sql)){
		mysqli_stmt_bind_param($stmt, 's', $param_mail);
		$param_mail = $_POST['mail_sent'];
		if(mysqli_stmt_execute($stmt)){
			mysqli_stmt_store_result($stmt);
			if(mysqli_stmt_num_rows($stmt) == 1){
				echo('此信箱已被採用');
			}else{
			}
		}
	}
	mysqli_stmt_close($stmt);
}
?>