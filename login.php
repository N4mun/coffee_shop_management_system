<?php

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'dbms_project';

session_start();

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
	die("Connection : failed (เชื่อมต่อฐานข้อมูล ไม่ สำเร็จ)" . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * from employee where username = '".$username."' AND password = '".$password."'";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result);

    if($row["position"]=="พนักงาน") {
        
        $_SESSION["username"]=$username;
        $_SESSION["f_name"]=$row["f_name"];
        $_SESSION["l_name"]=$row["l_name"];
        $_SESSION["position"]=$row["position"];
        $_SESSION["user_id"]=$row["user_id"];
        header("location:userhome.php");
    }

    else if($row["position"]=="ผู้ดูแลระบบ") {

        $_SESSION["username"]=$username;
        $_SESSION["f_name"]=$row["f_name"];
        $_SESSION["l_name"]=$row["l_name"];
        $_SESSION["position"]=$row["position"];
        $_SESSION["user_id"]=$row["user_id"];
        header("location:adminhome.php");
    }

    else {
        echo "username or password incorrect";
    }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
    <style>
        .box {
            padding-bottom: 30px;
            width: 40%;
            margin: 200px;
            border: 1px solid #D3D3D3;
            border-radius: 30px;
            box-shadow: 3px 1px #F5F5F5;
        }
        input {
            padding: 10px;
            width: 70%;
        }
    </style>
</head>
<body>

<center>
    <div class="box shadow p-3 mb-5 bg-body-tertiary rounded-4">
    <h1>เข้าสู่ระบบ</h1>
    
    <form action = "#" method = "POST">
    <div>
        <input type="text" name="username" placeholder="Username" required>
    </div><br>
    <div>
        <input type="password" name="password" placeholder="Password" required>
    </div><br>
    <div>
        <input type="submit" value="Login">
    </div>
    </form>

    </div>
</center>

</body>
</html>