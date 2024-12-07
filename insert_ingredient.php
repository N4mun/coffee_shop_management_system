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

$ing_balance = $_POST['ing_balance'];
$mate_name = $_POST['mate_name'];
$prod_id = $_POST['prod_id'];


$sql = "INSERT INTO ingredient(ing_balance,mate_id,prod_id) VALUES('$ing_balance','$mate_name','$prod_id')";
$result = mysqli_query($conn,$sql);
if($result){
    echo "<script>window.location='admin_product.php'</script>";
}else{
    echo "<script>alert('ไม่สามารถบันทึกข้อมูลได้');</script>";
}
mysqli_close($conn);
?>