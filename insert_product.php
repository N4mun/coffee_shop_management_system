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

$prod_name = $_POST['prod_name'];
$cateprod_name = $_POST['cateprod_name'];
$prod_detail = $_POST['prod_detail'];
$prod_price = $_POST['prod_price'];


$sql = "INSERT INTO product(prod_name,prod_detail,prod_price,cateprod_id) VALUES('$prod_name','$prod_detail','$prod_price','$cateprod_name')";
$result = mysqli_query($conn,$sql);
if($result){
    echo "<script>window.location='admin_product.php'</script>";
}else{
    echo "<script>alert('ไม่สามารถบันทึกข้อมูลได้');</script>";
}
mysqli_close($conn);
?>