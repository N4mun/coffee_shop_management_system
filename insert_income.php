<?php

session_start();

if (!isset($_SESSION["username"])) {
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

// Retrieve basket items from session
$basket = $_SESSION['basket'];

// Insert basket items into the income table
foreach ($basket as $item) {
    $income_date = $item['income_date'];
    $income_time = $item['income_time'];
    $income_amount = $item['income_amount'];
    $user_id = $item['user_id'];
    $prod_price = $item['prod_price'];
    $income_price = $item['income_price'];
    $prod_id = $item['prod_id'];
    $comment = $item['comment'];

    $sql = "INSERT INTO income (income_date, income_time, income_amount, user_id, income_price, prod_id, comment) 
            VALUES (NOW(), '$income_time', '$income_amount', '$user_id', '$income_price', '$prod_id', '$comment')";

    $result = mysqli_query($conn, $sql);
    $update_balance_sql = "UPDATE material,income,ingredient SET balance = balance - (ing_balance * $income_amount) WHERE income.prod_id = ingredient.prod_id AND ingredient.mate_id = material.mate_id";
    $update_balance_result = mysqli_query($conn, $update_balance_sql);

    if (!$result) {
        echo "<script>alert('ไม่สามารถบันทึกข้อมูลได้');</script>";
        exit; // Exit the loop if there's an error
    }
}

// Clear the basket after successful insertion
$_SESSION['basket'] = [];

// Redirect back to the homepage
echo "<script>window.location='userhome.php'</script>";

mysqli_close($conn);
?>
