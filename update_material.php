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

$mate_id=$_POST["mate_id"];
$type_mate=$_POST["type_mate"];
$unit_name=$_POST["unit_name"];
$balance=$_POST["balance"];
$mate_name=$_POST["mate_name"];




$sql = "UPDATE material set catemate_id='$type_mate',unit_id='$unit_name',balance='$balance',mate_name='$mate_name' WHERE mate_id='$mate_id'";
$result = mysqli_query($conn,$sql);
if($result){
    echo "<script>window.location='admin_material.php'</script>";
}else{
    echo "<script>alert('ไม่สามารถแก้ไขข้อมูลได้');</script>";
}
mysqli_close($conn);
?>