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



$fname=$_POST["fname"];
$lname=$_POST["lname"];
$tel=$_POST["tel"];
$sex=$_POST["sex"];


$sql = "UPDATE employee set f_name='$fname',l_name='$lname',tel='$tel',sex='$sex'";
$result = mysqli_query($conn,$sql);
if($result){
    echo "<script>window.location='user_member.php'</script>";
}else{
    echo "<script>alert('ไม่สามารถแก้ไขข้อมูลได้');</script>";
}
mysqli_close($conn);
?>