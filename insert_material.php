<?php

session_start();

if(!isset($_SESSION["username"])) {

    header("location:login.php");

}

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'dbms_project';

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
	die("Connection : failed (เชื่อมต่อฐานข้อมูล ไม่ สำเร็จ)" . mysqli_connect_error());
}

$typemate = $_POST['typemate']; 
$mate_name = $_POST['matename'];
$unit_name = $_POST['unitname'];


$sql = "INSERT INTO material (mate_name, catemate_id, unit_id) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'sss', $mate_name, $typemate, $unit_name);
$result = mysqli_stmt_execute($stmt);

if($result){
    echo "<script>window.location='admin_material.php'</script>";
}else{
    echo "<script>alert('ไม่สามารถบันทึกข้อมูลได้');</script>";
}
mysqli_close($conn);
?>