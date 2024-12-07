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

// Retrieve product details from the form

$income_date = $_POST['income_date'];
$income_time = $_POST['income_time'];
$prod_id = $_POST['prod_name'];
$income_amount = $_POST['income_amount'];
$user_id = $_POST['user_id'];
$comment = $_POST['comment'];

$selected_option = explode('|', $_POST['prod_name']);
$prod_id = $selected_option[0];
$prod_price = $selected_option[1];
$prod_name = $selected_option[2];
$prod_detail = $selected_option[3];

$income_price = $prod_price * $income_amount;


// Add the product to the basket
$_SESSION['basket'][] = [
    'income_date' => $income_date,
    'income_time' => $income_time,
    'prod_id' => $prod_id,
    'income_amount' => $income_amount,
    'user_id' => $user_id,
    'prod_price' => $prod_price,
    'income_price' => $income_price,
    'prod_name' => $prod_name,
    'prod_detail' => $prod_detail,
    'comment' => $comment
];

// Redirect back to the main page or wherever necessary
header("Location: userhome.php");
exit();
?>
