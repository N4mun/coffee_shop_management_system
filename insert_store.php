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

$sto_date = $_POST['sto_date'];
$type_mate = $_POST['type_mate'];
$mate_name = $_POST['mate_name'];
$sto_size = $_POST['sto_size'];
$sto_amount = $_POST['sto_amount'];
$sto_price = $_POST['sto_price'];
$user_id = $_POST['user_id'];

$sto_balance = $sto_size * $sto_amount;

$sql = "INSERT INTO store(sto_date,mate_id,sto_size,sto_amount,sto_balance,sto_price,user_id) VALUES(NOW(),'$mate_name','$sto_size','$sto_amount','$sto_balance','$sto_price',$user_id)";
$result = mysqli_query($conn,$sql);

if ($result) {
    // Update balance in material table
    $update_balance_sql = "UPDATE material SET balance = balance + $sto_balance WHERE mate_id = $mate_name";
    $update_balance_result = mysqli_query($conn, $update_balance_sql);
    
    if ($update_balance_result) {
        echo "<script>window.location='user_material.php'</script>";
    } else {
        echo "<script>alert('ไม่สามารถอัปเดตยอดคงเหลือในตารางวัตถุดิบได้');</script>";
    }
} else {
    echo "<script>alert('ไม่สามารถบันทึกข้อมูลได้');</script>";
}

mysqli_close($conn);
?>