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

$cateprod_id=$_GET['cateprod_id'];
$sql="DELETE FROM cate_prod WHERE cateprod_id=$cateprod_id";
if(mysqli_query($conn,$sql)){
    echo "<script>alert('ลบข้อมูลเรียบร้อย');</script>";
    echo "<script>window.location='admin_product.php'</script>";
}else{
    echo "Error : " . $sql . "<br>" .mysqli_error($conn);
    echo "<script>alert('ไม่สามารถลบข้อมูลได้');</script>";
}

mysqli_close($conn);

?>