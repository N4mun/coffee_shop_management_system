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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Homepage</title>
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
        height: 100vh;
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
            <h1 class="mb-4 h2 alert alert-dark" role="alert">สินค้า</h1>
            <table class="table table-striped shadow p-3 mb-5 bg-body-tertiary rounded">
                <tr>
                    <th>No.</th>
                    <th>ประเภท</th>
                    <th>ชื่อ</th>
                    <th>ชนิด</th>
                    <th>ราคา(บาท)</th>
                    <th>ส่วนผสม</th>
                </tr>
                <?php
                $sql = "SELECT * FROM product,cate_prod WHERE product.cateprod_id = cate_prod.cateprod_id ORDER BY cateprod_name";
                $result = mysqli_query($conn,$sql);
                $counter = 1;
                while($row=mysqli_fetch_array($result)){
                ?>
                <tr>
                    <td><?=$counter?></td>
                    <td><?=$row["cateprod_name"]?></td>
                    <td><?=$row["prod_name"]?></td>
                    <td><?=$row["prod_detail"]?></td>
                    <td><?=$row["prod_price"]?></td>
                    <td>
                        <button type="button" class="btn btn-primary mb-4 ms-4" data-bs-toggle="modal"
                            data-bs-target="#catemateModal<?=$row["prod_id"]?>">
                            ส่วนผสม
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="catemateModal<?=$row["prod_id"]?>" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">ส่วนผสมสินค้า
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="insert_ingredient.php">
                                            <h4><?=$row["prod_name"]?> (<?=$row["prod_detail"]?>)</h4>
                                            <input type="hidden" name="prod_id" class="form-control"
                                                value=<?=$row['prod_id']?>>
                                            <table class="table table-striped shadow p-3 mb-5 bg-body-tertiary rounded">
                                                <tr>
                                                    <th>No.</th>
                                                    <th>ชื่อ</th>
                                                    <th>ขนาด</th>
                                                    <th>หน่วยนับ</th>
                                                </tr>
                                                <?php
                                                $sql1 = "SELECT * FROM ingredient,material,product,mate_unit WHERE ingredient.mate_id = material.mate_id AND ingredient.prod_id = product.prod_id AND material.unit_id = mate_unit.unit_id AND ingredient.prod_id = " . $row["prod_id"];;
                                                $result1 = mysqli_query($conn,$sql1);
                                                $counter1 = 1;
                                                while($row=mysqli_fetch_array($result1)){
                                                ?>
                                                <tr>
                                                    <td><?=$counter1?></td>
                                                    <td><?=$row["mate_name"]?></td>
                                                    <td><?=$row["ing_balance"]?></td>
                                                    <td><?=$row["unit_name"]?></td>
                                                </tr>
                                                <?php
                                                $counter1++;
                                                }
                                                ?>
                                            </table>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">ยกเลิก</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </td>

                    <?php
                $counter++; 
                }
                mysqli_close($conn); 
                ?>
            </table>
        </div>
    </div>
</body>

</html>