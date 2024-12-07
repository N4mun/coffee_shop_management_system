<?php

session_start();

if (!isset($_SESSION["username"])) {
    header("location:login.php");
    exit();
}

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'dbms_project';

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection : failed (เชื่อมต่อฐานข้อมูล ไม่ สำเร็จ)" . mysqli_connect_error());
}

$sto_id = $_GET['sto_id'];

// Fetching the sto_balance to be subtracted from the material balance
$fetch_sto_balance_sql = "SELECT sto_balance, mate_id FROM store WHERE sto_id = $sto_id";
$result = mysqli_query($conn, $fetch_sto_balance_sql);
$row = mysqli_fetch_assoc($result);
$sto_balance = $row['sto_balance'];
$mate_id = $row['mate_id'];

// Deleting the record from store table
$delete_sql = "DELETE FROM store WHERE sto_id = $sto_id";
if (mysqli_query($conn, $delete_sql)) {
    // Decreasing balance in material table
    $update_balance_sql = "UPDATE material SET balance = balance - $sto_balance WHERE mate_id = $mate_id";
    if (mysqli_query($conn, $update_balance_sql)) {
        echo "<script>alert('ยกเลิกคำสั่งซื้อและลดยอดคงเหลือสำเร็จ');</script>";
        echo "<script>window.location='user_material.php'</script>";
    } else {
        echo "<script>alert('ไม่สามารถลดยอดคงเหลือในตารางวัตถุดิบได้');</script>";
    }
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}

mysqli_close($conn);

?>
