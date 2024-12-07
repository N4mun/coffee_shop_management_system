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
    <title>Admin Materialpage</title>
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
            <li><a href="adminhome.php">หน้าแรก</a></li>
            <li><a href="admin_material.php">วัตถุดิบ-อุปกรณ์</a></li>
            <li><a href="admin_product.php">สินค้า</a></li>
            <li><a href="admin_member.php">ผู้ใช้ระบบ</a></li>
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
                เพิ่ม
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">เพิ่มข้อมูลวัตถุดิบ-อุปกรณ์</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="insert_material.php">
                                <label>ชื่อ</label><br>
                                <input type="text" name="matename" class="form-control"
                                    placeholder="ชื่อวัตถุดิบ-อุปกรณ์" required><br>
                                <label>ประเภท</label><br>
                                <select name="typemate" class="form-select" aria-label="Default select example"
                                    required>
                                    <option selected>เลือก</option>
                                    <?php
                                    $sql = "SELECT * FROM cate_mate";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='{$row["catemate_id"]}'>{$row["type_mate"]}</option>";
                                    }
                                    ?>
                                </select><br>
                                <label>หน่วยนับ</label><br>
                                <select name="unitname" class="form-select" aria-label="Default select example"
                                    required>
                                    <option selected>เลือก</option>
                                    <?php
                                    $sql = "SELECT * FROM mate_unit";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='{$row["unit_id"]}'>{$row["unit_name"]}</option>";
                                    }
                                    ?>
                                </select><br>
                                
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-success mb-4 ms-4" data-bs-toggle="modal"
                data-bs-target="#catemateModal">
                เพิ่ม-ลบ ประเภท
            </button>

            <!-- Modal -->
            <div class="modal fade" id="catemateModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">เพิ่ม-ลบ : ประเภทวัตถุดิบ-อุปกรณ์</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="insert_catemate.php">
                                <div class="d-flex flex-row mb-3">
                                    <input type="text" name="typemate" class="form-control"
                                        placeholder="ชื่อประเภทวัตถุดิบ-อุปกรณ์" required>
                                    <button type="submit" class="btn btn-success">เพิ่ม</button>
                                </div>
                                <table class="table table-striped shadow p-3 mb-5 bg-body-tertiary rounded">
                                    <tr>
                                        <th>No.</th>
                                        <th>รายการประเภท</th>
                                        <th>เลือก</th>
                                    </tr>
                                    <?php
                                    $sql = "SELECT * FROM cate_mate";
                                    $result = mysqli_query($conn,$sql);
                                    while($row=mysqli_fetch_array($result)){
                                    ?>
                                    <tr>
                                        <td><?=$row["catemate_id"]?></td>
                                        <td><?=$row["type_mate"]?></td>
                                        <td><a href="delete_catemate.php?catemate_id=<?=$row["catemate_id"]?>"
                                                class="btn btn-danger" onclick="Del(this.href);return false;">ลบ</a>
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-success mb-4 ms-4" data-bs-toggle="modal"
                data-bs-target="#mateunitModal">
                เพิ่ม-ลบ หน่วยนับ
            </button>

            <!-- Modal -->
            <div class="modal fade" id="mateunitModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">เพิ่ม-ลบ : หน่วยนับวัตถุดิบ-อุปกรณ์</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="insert_mateunit.php">
                                <div class="d-flex flex-row mb-3">
                                    <input type="text" name="unit_name" class="form-control"
                                        placeholder="ชื่อหน่วยนับวัตถุดิบ-อุปกรณ์" required>
                                    <button type="submit" class="btn btn-success">เพิ่ม</button>
                                </div>
                                <table class="table table-striped shadow p-3 mb-5 bg-body-tertiary rounded">
                                    <tr>
                                        <th>No.</th>
                                        <th>รายการหน่วยนับ</th>
                                        <th>เลือก</th>
                                    </tr>
                                    <?php
                                    $sql = "SELECT * FROM mate_unit";
                                    $result = mysqli_query($conn,$sql);
                                    while($row=mysqli_fetch_array($result)){
                                    ?>
                                    <tr>
                                        <td><?=$row["unit_id"]?></td>
                                        <td><?=$row["unit_name"]?></td>
                                        <td><a href="delete_mateunit.php?unit_id=<?=$row["unit_id"]?>"
                                                class="btn btn-danger" onclick="Del(this.href);return false;">ลบ</a>
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-striped shadow p-3 mb-5 bg-body-tertiary rounded">
                <tr>
                    <th>No.</th>
                    <th>ประเภท</th>
                    <th>ชื่อ</th>
                    <th>ปริมาณสุทธิ</th>
                    <th>หน่วยนับ</th>
                    <th>แก้ไข</th>
                    <th>ลบ</th>
                </tr>
                <?php
                $sql = "SELECT * FROM material,mate_unit,cate_mate WHERE material.unit_id = mate_unit.unit_id AND material.catemate_id = cate_mate.catemate_id ORDER BY type_mate";
                $result = mysqli_query($conn,$sql);
                $counter = 1;
                while($row=mysqli_fetch_array($result)){
                ?>
                <tr>
                    <td><?=$counter?></td>
                    <td><?=$row["type_mate"]?></td>
                    <td><?=$row["mate_name"]?></td>
                    <td><?=$row["balance"]?></td>
                    <td><?=$row["unit_name"]?></td>
                    <td><button type="button" class="btn btn-warning mb-4" data-bs-toggle="modal"
                            data-bs-target="#editModal<?=$row["mate_id"]?>">
                            แก้ไข
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="editModal<?=$row["mate_id"]?>" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">แก้ไขข้อมูล</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="update_material.php">
                                        <input type="hidden" name="mate_id" class="form-control"
                                                value=<?=$row['mate_id']?>>
                                            <label>ชื่อ</label><br>
                                            <input type="text" name="mate_name" class="form-control"
                                                value=<?=$row['mate_name']?>><br>
                                            <label>ประเภท</label><br>
                                            <select name="type_mate" class="form-select"
                                                aria-label="Default select example" required>
                                                <option selected disabled>เลือก</option>
                                                <?php
                                                $sql1 = "SELECT * FROM cate_mate";
                                                $result1 = mysqli_query($conn, $sql1);
                                                while ($catemate_row = mysqli_fetch_assoc($result1)) {
                                                    if ($catemate_row['type_mate'] == $row['type_mate']) {
                                                        echo "<option value='{$catemate_row["catemate_id"]}' selected>{$catemate_row["type_mate"]}</option>";
                                                    } else {
                                                        echo "<option value='{$catemate_row["catemate_id"]}'>{$catemate_row["type_mate"]}</option>";
                                                    }
                                                }
                                                ?>
                                            </select><br>
                                            <label>หน่วยนับ</label><br>
                                            <select name="unit_name" class="form-select"
                                                aria-label="Default select example" required>
                                                <option selected disabled>เลือก</option>
                                                <?php
                                                $sql2 = "SELECT * FROM mate_unit";
                                                $result2 = mysqli_query($conn, $sql2);
                                                while ($unit_row = mysqli_fetch_assoc($result2)) {
                                                    if ($unit_row['unit_name'] == $row['unit_name']) {
                                                        echo "<option value='{$unit_row["unit_id"]}' selected>{$unit_row["unit_name"]}</option>";
                                                    } else {
                                                        echo "<option value='{$unit_row["unit_id"]}'>{$unit_row["unit_name"]}</option>";
                                                    }
                                                }
                                                ?>
                                            </select><br>
                                            <label>ปริมาณสุทธิ</label><br>
                                            <input type="text" name="balance" class="form-control"
                                            disabled readonly    value=<?=$row['balance']?>><br>
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
                    </td>
                    <td><a href="delete_material.php?mate_id=<?=$row["mate_id"]?>" class="btn btn-danger"
                            onclick="Del(this.href);return false;">ลบ</a></td>
                </tr>

                <?php
                $counter++; 
                }
                mysqli_close($conn); //ปิดการเชื่อมต่อข้อมูล
                ?>
            </table>

        </div>
    </div>
</body>

</html>