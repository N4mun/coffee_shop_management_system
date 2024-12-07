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

$username = $_SESSION["username"]; // Get the username of the currently logged-in user

$sql = "SELECT * FROM employee WHERE username = '$username'"; // Modify the query to fetch data only for the currently logged-in user
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Memberpage</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .containers {
        display: flex;
    }

    .navbar {
        height: 110px;
        background-color: #65451F;
    }

    .navbar img {
        width: 200px;
        height: 100px;
        float: left;
        object-fit: cover;
    }

    .navbar ul {
        list-style: none;
        display: flex;
        float: right;
        margin-left: 100px;
    }

    .navbar ul li {
        margin: 25px;
        margin-top: 40px;
        background-color: green;
        padding: 10px;
    }

    .navbar ul li a {
        text-decoration: none;
        color: white;
    }

    .left {
        background-color: #765827;
        width: 15%;
        height: auto;
        padding: 20px;
    }

    .user-box {
        background-color: #C8AE7D;
        text-align: center;
        padding-top: 25px;
        padding-bottom: 25px;
    }

    .user-box p {
        font-size: 20px;
    }

    .logout-button a {
        text-decoration: none;
        color: white;
    }

    .logout-button {
        background-color: #C21807;
        text-align: center;
        padding: 10px;
        margin-top: 10px;
        border-radius: 10px;
    }

    .main {
        flex: 1;
        width: 85%;
        min-height: 100vh;
        padding: 20px;
    }
    </style>
</head>

<body>

    <div class="navbar">
        <img src="coffee.png" alt="coffee_logo">
        <ul>
            <li><a href="userhome.php">หน้าแรก</a></li>
            <li><a href="user_material.php">วัตถุดิบ-อุปกรณ์</a></li>
            <li><a href="user_product.php">สินค้า</a></li>
            <li><a href="user_member.php">ผู้ใช้ระบบ</a></li>
        </ul>
    </div>
    <div class="containers">
        <div class="left">
            <div class="user-box">
                <p>ผู้ใช้ระบบ</p>
                <?php echo $_SESSION["username"] ?><br><br>
                <p>ชื่อ-นามสกุล</p>
                <?php echo $_SESSION["f_name"] . " " . $_SESSION["l_name"] ?><br><br>
                <p>ตำแหน่ง</p>
                <?php echo $_SESSION["position"] ?><br>
            </div>
            <div class="logout-button">
                <a href="logout.php">ออกจากระบบ</a>
            </div>
        </div>
        <div class="main">
            <h1 class="mb-4 h2 alert alert-dark text-center">ผู้ใช้ระบบ</h1>
            <div class="card mx-auto p-2 shadow p-3 mb-5 bg-body-tertiary rounded" style="width: 30rem;">
                <h5 class="card-header text-center">ข้อมูลผู้ใช้ระบบ</h5>
                <div class="card-body">
                    <?php while ($row = mysqli_fetch_array($result)) { ?>
                    <form method="POST">
                        <label>Username</label><br>
                        <input type="text" name="username" class="form-control" disabled readonly
                            value=<?=$row['username']?>><br>
                        <label>Password</label><br>
                        <input type="text" name="password" class="form-control" disabled readonly
                            value=<?=$row['password']?>><br>
                        <label>ชื่อ</label><br>
                        <input type="text" name="fname" class="form-control" disabled readonly value=<?=$row['f_name']?>><br>
                        <label>นามสกุล</label><br>
                        <input type="text" name="lname" class="form-control" disabled readonly value=<?=$row['l_name']?>><br>
                        <label>เพศ</label><br>
                        <input type="text" name="tel" class="form-control" disabled readonly value=<?=$row['sex']?>><br>
                        <label>เบอร์โทรศัพท์</label><br>
                        <input type="text" name="tel" class="form-control" disabled readonly value=<?=$row['tel']?>><br>
                        <label>ตำแหน่ง</label><br>
                        <input type="text" name="tel" class="form-control" disabled readonly value=<?=$row['position']?>><br>
                    </form>
                    <button type="button" class="btn btn-warning mb-4" data-bs-toggle="modal"
                        data-bs-target="#editModal<?=$row["user_id"]?>">
                        แก้ไข
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="editModal<?=$row["user_id"]?>" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header p-3 mb-2 bg-warning text-dark">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">แก้ไขข้อมูลผู้ใช้ระบบ</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="user_update_member.php">
                                        <label>ชื่อ</label><br>
                                        <input type="text" name="fname" class="form-control"
                                            value=<?=$row['f_name']?>><br>
                                        <label>นามสกุล</label><br>
                                        <input type="text" name="lname" class="form-control"
                                            value=<?=$row['l_name']?>><br>
                                        <label>เพศ</label><br>
                                        <select name="sex" class="form-select" aria-label="Default select example">
                                            <option value="เลือก" <?php if($row['sex'] == "เลือก") echo "selected"; ?>>
                                                เลือก</option>
                                            <option value="ชาย" <?php if($row['sex'] == "ชาย") echo "selected"; ?>>
                                                ชาย</option>
                                            <option value="หญิง" <?php if($row['sex'] == "หญิง") echo "selected"; ?>>
                                                หญิง</option>
                                            <option value="อื่นๆ" <?php if($row['sex'] == "อื่นๆ") echo "selected"; ?>>
                                                อื่นๆ</option>
                                        </select><br>
                                        <label>เบอร์โทรศัพท์</label><br>
                                        <input type="text" name="tel" class="form-control" value=<?=$row['tel']?>><br>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">ยกเลิก</button>
                                    <button type="submit" class="btn btn-primary">บันทึก</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 
                    }
                    mysqli_close($conn); 
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>