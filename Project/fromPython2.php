<?php 
session_start();

$python = "D:\\Python36\\python.exe";
$pythonscript = "C:\\xampp\\htdocs\\Project\\python\\ff3-4.py";

if(!(empty($_POST["suggest"]))){
	$_SESSION['date_map1'] = $_POST["suggest"];
}




$which_date = $_SESSION['date_map1'] ;
$which_filename1 = str_replace('-',"",$which_date);
$which_filename2 = str_replace(':',"",$which_filename1);
$which_filename3 = str_replace(" ","",$which_filename2);

$item = $which_filename3;

$output = array();
$cmd = ("$python $pythonscript $item");
exec("$cmd",$output);
echo json_encode($output);

?>