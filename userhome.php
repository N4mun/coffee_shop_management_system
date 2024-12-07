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
            <h1 class="mb-4 h2 alert alert-dark" role="alert">หน้าแรก</h1>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="text-primary">รับคำสั่งซื้อสินค้า</h4>
                <div class="ml-auto">
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#incomeModal">
                        ดูข้อมูลยอดขาย
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="incomeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">ข้อมูลยอดขาย
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="insert_ingredient.php">
                                        <?php
                                        $totalItemsSold = 0;
                                        $totalNetAmount = 0;
                                        error_reporting(0);
                                        ?>
                                        <table class="table table-striped shadow p-3 mb-5 bg-body-tertiary rounded">
                                            <div class="d-flex flex-row mb-3">
                                                <?php
                                                // Set the default timezone
                                                date_default_timezone_set('Asia/Bangkok');
                                                // Get the current date
                                                $currentDate = date("d/m/Y");
                                                ?>
                                                <h4 class="me-4">ตารางข้อมูล : </h4>
                                                <input class="form-control" type="text"
                                                    value="<?php echo $currentDate; ?>"
                                                    aria-label="Disabled input example" style="width:auto" disabled
                                                    readonly>
                                            </div>
                                            <tr>
                                                <th>No.</th>
                                                <th>ชื่อ-นามสกุล</th>
                                                <th>วัน/เวลา</th>
                                                <th>รายการสินค้า</th>
                                                <th>จำนวน(ea)</th>
                                                <th>ราคา(บาท)</th>
                                            </tr>
                                            <?php
                                            $sql = "SELECT * FROM income,employee,product WHERE income.user_id = employee.user_id AND income.prod_id = product.prod_id AND income_date=curdate()";
                                            $result = mysqli_query($conn,$sql);
                                            $counter = 1;
                                            while($row=mysqli_fetch_array($result)){
                                            ?>
                                            <tr>
                                                <td><?=$counter?></td>
                                                <td><?=$row["f_name"]?> <?=$row["l_name"]?></td>
                                                <td><?=$row["income_date"]?> <?=$row["income_time"]?></td>
                                                <td><?=$row["prod_name"]?> <?=$row["prod_detail"]?></td>
                                                <td><?=$row["income_amount"]?></td>
                                                <td><?=$row["income_price"]?></td>
                                            </tr>
                                            <?php
                                                // Increment total items sold by the quantity of this item
                                                $totalItemsSold += $row["income_amount"];
                                                // Calculate the total net amount for this item and add it to the total net amount
                                                $totalNetAmount += $row["income_price"];
                                                $counter++;
                                            }
                                            ?>
                                            <tr>
                                                <td colspan="4"><strong>Total</strong></td>
                                                <td><strong><?php echo $totalItemsSold; ?> ea</strong></td>
                                                <td><strong><?php echo $totalNetAmount; ?> บาท</strong></td>
                                            </tr>
                                        </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">ยกเลิก</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <button type="button" class="btn btn-success mb-4" data-bs-toggle="modal" data-bs-target="#exampleModal">
                เลือกสินค้า
            </button>

            <?php
            // Set the default timezone
            date_default_timezone_set('Asia/Bangkok');
            // Get the current date
            $currentDate = date("d/m/Y");
            ?>

            <div class="d-flex flex-row mb-3">
                <h4 class="me-4">ตารางข้อมูล : </h4>
                <input class="form-control" type="text" value="<?php echo $currentDate; ?>"
                    aria-label="Disabled input example" style="width:auto" disabled readonly>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">เพิ่มคำสั่งซื้อสินค้า</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="insert_basket.php">
                                <input type="hidden" name="user_id" class="form-control" readonly
                                    value="<?php echo $_SESSION["user_id"] ?>">
                                <label>วันที่</label><br>
                                <input type="text" name="income_date" class="form-control" readonly
                                    value="<?php echo date('d/m/Y'); ?>"><br>
                                <label>เวลา</label><br>
                                <input type="text" name="income_time" class="form-control" readonly
                                    value="<?php echo date('H:i:s'); ?>"><br>

                                <label>ชื่อสินค้า</label><br>
                                <select name="prod_name" class="form-select" aria-label="Default select example"
                                    required>
                                    <option selected>เลือก</option>
                                    <?php
                                    $sql2 = "SELECT * FROM product ORDER BY prod_name";
                                    $result2 = mysqli_query($conn, $sql2);
                                    while ($row = mysqli_fetch_assoc($result2)) {
                                    echo "<option value='{$row["prod_id"]}|{$row["prod_price"]}|{$row["prod_name"]}|{$row["prod_detail"]}'>{$row["prod_name"]}{$row["prod_detail"]}</option>";
                                    }
                                    ?>
                                </select><br>

                                <label>จำนวน(ea)</label><br>
                                <input type="text" name="income_amount" class="form-control" placeholder="จำนวน(ea)"
                                    required><br>
                                
                                    <label>หมายเหตุ</label><br>
                                    <input type="text" name="comment" class="form-control" placeholder="หมายเหตุ">

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
                    <th>สินค้า</th>
                    <th>ราคา(บาท)</th>
                    <th>จำนวน(ea)</th>
                    <th>รวม(บาท)</th>
                    <th>หมายเหตุ</th>
                    <th>การดำเนินการ</th>
                </tr>
                <?php 
    $net_total = 0; // Initialize net total variable
    $counter = 1;
    foreach ($_SESSION['basket'] as $item): 
        $net_total += $item['income_price']; // Add income price to net total
    ?>
                <tr>
                    <td><?=$counter?></td>
                    <td>
                        <?php
            // Fetch prod_name and prod_detail based on prod_id
            $prod_id = $item['prod_id'];
            $sql = "SELECT prod_name, prod_detail FROM product WHERE prod_id = $prod_id";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            echo $row['prod_name'] . ' ' . $row['prod_detail'];
            ?>
                    </td>
                    <td><?php echo $item['prod_price']; ?></td>
                    <td><?php echo $item['income_amount']; ?></td>
                    <td><?php echo $item['income_price']; ?></td>
                    <td><?php echo $item['comment'];?></td>
                    <td>
                        <form action="delete_basket.php" method="POST">
                            <input type="hidden" name="item_index" value="<?=$counter-1?>">
                            <button type="submit" class="btn btn-danger">ลบ</button>
                        </form>
                    </td>
                </tr>
                <?php 
    $counter++;
    endforeach; 
    ?>
            </table>
            <div class="float-end me-5">
                <!-- Display net total below the table -->
                <h4>ยอดรวม: <?php echo $net_total; ?> บาท</h4>

                <form action="insert_income.php" method="POST">
                    <input type="hidden" name="net_total" value="<?php echo $net_total; ?>">
                    <!-- Pass net total as a hidden input -->
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </form>
            </div>


        </div>


    </div>
</body>

</html>