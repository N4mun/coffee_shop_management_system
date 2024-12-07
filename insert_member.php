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

$username = $_POST['username'];
$password = $_POST['password'];
$f_name = $_POST['fname'];
$l_name = $_POST['lname'];
$sex = $_POST['sex'];
$tel = $_POST['tel'];
$position = $_POST['position'];

$sql = "INSERT INTO employee(username,password,f_name,l_name,sex,tel,position,date) VALUES('$username','$password','$f_name','$l_name','$sex','$tel','$position',NOW())";
$result = mysqli_query($conn,$sql);
if($result){
    echo "<script>window.location='admin_member.php'</script>";
}else{
    echo "<script>alert('ไม่สามารถบันทึกข้อมูลได้');</script>";
}
mysqli_close($conn);
?>