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

$cate_prod = $_POST['cateprod_name'];

$sql = "INSERT INTO cate_prod(cateprod_name) VALUES('$cate_prod')";
$result = mysqli_query($conn,$sql);
if($result){
    echo "<script>window.location='admin_product.php'</script>";
}else{
    echo "<script>alert('ไม่สามารถบันทึกข้อมูลได้');</script>";
}
mysqli_close($conn);
?>