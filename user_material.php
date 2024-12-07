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
            <h1 class="mb-4 h2 alert alert-dark" role="alert">วัตถุดิบ-อุปกรณ์</h1>
            <button type="button" class="btn btn-success mb-4" data-bs-toggle="modal" data-bs-target="#exampleModal">
                การสั่งซื้อ
            </button>

            <?php
            // Set the default timezone
            date_default_timezone_set('Asia/Bangkok');
            // Get the current date
            $currentDate = date("d/m/Y");
            ?>

            <div class="d-flex flex-row mb-3">
                <h4 class="me-4">ตารางข้อมูล : </h4>
                <input class="form-control" type="text" value="<?php echo $currentDate; ?>" aria-label="Disabled input example" style="width:auto" disabled readonly>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">การสั่งซื้อวัตถุดิบ-อุปกรณ์</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="insert_store.php">
                                <input type="hidden" name="user_id" class="form-control" readonly
                                    value="<?php echo $_SESSION["user_id"] ?>">
                                <label>วันที่</label><br>
                                <input type="text" name="sto_date" class="form-control" readonly
                                    value="<?php echo date('d/m/Y'); ?>"><br>
                                <label>ชื่อ</label><br>
                                <select name="mate_name" class="form-select" aria-label="Default select example"
                                    required>
                                    <option selected>เลือก</option>
                                    <?php
                                    $sql = "SELECT * FROM material";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <option value="<?=$row["mate_id"]?>"><?=$row["mate_name"]?></option>
                                    <?php
                                    }
                                    ?>
                                </select><br>
                                <label>ขนาด</label><br>
                                <input type="text" name="sto_size" class="form-control" placeholder="ขนาด" required><br>
                                <label>จำนวน(ea)</label><br>
                                <input type="text" name="sto_amount" class="form-control" placeholder="จำนวนต่อชิ้น"
                                    required><br>
                                <label>ราคา(บาท)</label><br>
                                <input type="text" name="sto_price" class="form-control" placeholder="ราคา(บาท)"
                                    required><br>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-striped shadow p-3 mb-5 bg-body-tertiary rounded">
                <tr>
                    <th>No.</th>
                    <th>ชื่อ</th>
                    <th>ขนาด</th>
                    <th>จำนวน</th>
                    <th>ปริมาณสุทธิ</th>
                    <th>ราคา(บาท)</th>
                    <th>เลือก</th>
                </tr>
                <?php
                $sql = "SELECT * FROM material,store,cate_mate,mate_unit WHERE material.mate_id = store.mate_id AND material.unit_id = mate_unit.unit_id AND material.catemate_id = cate_mate.catemate_id AND sto_date=curdate()";
                $result = mysqli_query($conn,$sql);
                $counter = 1;
                while($row=mysqli_fetch_array($result)){
                ?>
                <tr>
                    <td><?=$counter?></td>
                    <td><?=$row["mate_name"]?></td>
                    <td><?=$row["sto_size"]?> <?=$row["unit_name"]?></td>
                    <td><?=$row["sto_amount"]?></td>
                    <td><?=$row["sto_balance"]?> <?=$row["unit_name"]?></td>
                    <td><?=$row["sto_price"]?></td>
                    <td><a href="delete_store.php?sto_id=<?=$row["sto_id"]?>" class="btn btn-danger"
                            onclick="Del(this.href);return false;">ลบ</a></td>
                </tr>
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