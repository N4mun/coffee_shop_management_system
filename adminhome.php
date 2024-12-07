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
            <h1 class="mb-4 h2 alert alert-dark" role="alert">หน้าแรก</h1>
            <div class="d-flex p-2 float-end">
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
                                <div class"container">
                                    <div class="row">
                                        <form method="post" action="adminhome.php">
                                            <h6>วันที่เริ่ม</ย>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <input type="date" name="start_date" class="form-control">
                                                    </div>
                                                </div><br>
                                                <h6>วันที่สิ้นสุด
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <input type="date" name="end_date" class="form-control">
                                                        </div>
                                                    </div><br>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <input type="submit" name="submit_date"
                                                                class="btn btn-primary" value="ค้นหา">
                                                        </div>
                                                    </div><br>
                                        </form>

                                        <?php
    if(isset($_POST['submit_date'])) {
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        $query = "SELECT * FROM income, employee, product WHERE income.user_id = employee.user_id AND income.prod_id = product.prod_id AND income_date BETWEEN '$start_date' AND '$end_date'";
        $result = mysqli_query($conn, $query);

        if($result) {
            if(mysqli_num_rows($result) > 0) {
                echo "<div class='col-lg-12'>
                        <table class='table table-striped'>
                            <tr>
                                <th>No.</th>
                                <th>ชื่อ-นามสกุล</th>
                                <th>วัน/เวลา</th>
                                <th>รายการสินค้า</th>
                                <th>จำนวน(ea)</th>
                                <th>ราคา(บาท)</th>
                            </tr>";
                $totalItemsSold = 0;
                $totalNetAmount = 0;
                $i = 1;
                while ($value = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>$i</td>
                            <td>{$value["f_name"]} {$value["l_name"]}</td>
                            <td>{$value["income_date"]} {$value["income_time"]}</td>
                            <td>{$value["prod_name"]} {$value["prod_detail"]}</td>
                            <td>{$value["income_amount"]}</td>
                            <td>{$value["income_price"]}</td>
                          </tr>";
                    $totalItemsSold += $value["income_amount"];
                    $totalNetAmount += $value["income_price"];
                    $i++;
                }
                
                
                echo "</table></div>";
                echo "<div class='col-lg-12'>
                <table class='table table-striped'>
                    <tr>
                        <td colspan='4'><strong>Total</strong></td>
                        <td><strong>{$totalItemsSold} ea</strong></td>
                        <td><strong>{$totalNetAmount} บาท</strong></td>
                    </tr>
                </table></div>";
            } else {
                echo "No data found";
            }
        } else {
            echo "Query execution failed: " . mysqli_error($conn);
        }

                    }else{

                    ?>

                                        <div class="col-lg-12">

                                            <table class="table table-striped">
                                                <tr>
                                                    <th>No.</th>
                                                    <th>ชื่อ-นามสกุล</th>
                                                    <th>วัน/เวลา</th>
                                                    <th>รายการสินค้า</th>
                                                    <th>จำนวน(ea)</th>
                                                    <th>ราคา(บาท)</th>
                                                </tr>
                                                <?php
                                $sql = "SELECT * FROM income,employee,product WHERE income.user_id = employee.user_id AND income.prod_id = product.prod_id";
                                $run = mysqli_query($conn,$sql);
                                $i=1;
                                $totalItemsSold = 0;
                                $totalNetAmount = 0;
                                while ($row=mysqli_fetch_assoc($run)) {

                                
                            ?>
                                                <tr>
                                                    <td><?=$i?></td>
                                                    <td><?=$row["f_name"]?> <?=$row["l_name"]?></td>
                                                    <td><?=$row["income_date"]?> <?=$row["income_time"]?></td>
                                                    <td><?=$row["prod_name"]?> <?=$row["prod_detail"]?></td>
                                                    <td><?=$row["income_amount"]?></td>
                                                    <td><?=$row["income_price"]?></td>
                                                </tr>

                                                <?php
                            $totalItemsSold += $row["income_amount"];
                            $totalNetAmount += $row["income_price"];
                            $i++;
                            }
                            ?>
                                                <tr>
                                                    <td colspan="4"><strong>Total</strong></td>
                                                    <td><strong><?php echo $totalItemsSold; ?> ea</strong></td>
                                                    <td><strong><?php echo $totalNetAmount; ?> บาท</strong></td>
                                                </tr>

                                            </table>

                                        </div>
                                        <?php } ?>
                                    </div>
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
            <div class="d-flex p-2 float-end">
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#storeModal">
                    ดูข้อมูลสต็อก
                </button>

                <!-- Modal -->
                <div class="modal fade" id="storeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">ข้อมูลสต็อก
                                </h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class"container">
                                    <div class="row">
                                        <h6>วันที่เริ่ม
                                            <form method="post" action="adminhome.php">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <input type="date" name="start_date" class="form-control">
                                                    </div>
                                                </div><br>
                                                <div class="col-lg-4">
                                                    <h6>วันที่เริ่ม
                                                        <div class="form-group">
                                                            <input type="date" name="end_date" class="form-control">
                                                        </div>
                                                </div><br>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <input type="submit" name="submit_date" class="btn btn-primary" value="ค้นหา">
                                                    </div>
                                                </div><br>
                                            </form>

                                            <?php
    if(isset($_POST['submit_date'])) {
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        $query = "SELECT * FROM material,store,cate_mate,mate_unit WHERE material.mate_id = store.mate_id AND material.unit_id = mate_unit.unit_id AND material.catemate_id = cate_mate.catemate_id AND sto_date BETWEEN '$start_date' AND '$end_date' ";
        $result = mysqli_query($conn, $query);

        if($result) {
            if(mysqli_num_rows($result) > 0) {
                echo "<div class='col-lg-12'>
                        <table class='table table-striped'>
                        <tr>
                        <th>No.</th>
                        <th>วันที่</th>
                        <th>ประเภท</th>
                        <th>ชื่อ</th>
                        <th>ขนาด</th>
                        <th>จำนวน(ea)</th>
                        <th>ปริมาณสุทธิ</th>
                        <th>ราคา(บาท)</th>
                    </tr>";

                $i = 1;
                while ($value = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>$i</td>
                            <td>{$value["sto_date"]}</td>
                            <td>{$value["type_mate"]}</td>
                            <td>{$value["mate_name"]}</td>
                            <td>{$value["sto_size"]} {$value["unit_name"]}</td>
                            <td>{$value["sto_amount"]}</td>
                            <td>{$value["sto_balance"]} {$value["unit_name"]}</td>
                            <td>{$value["sto_price"]}</td>
                          </tr>";
                    $i++;
                }
                
                
                echo "</table></div>";

            } else {
                echo "No data found";
            }
        } else {
            echo "Query execution failed: " . mysqli_error($conn);
        }

                    }else{

                    ?>

                                            <div class="col-lg-12">

                                                <table class="table table-striped">
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>วันที่</th>
                                                        <th>ประเภท</th>
                                                        <th>ชื่อ</th>
                                                        <th>ขนาด</th>
                                                        <th>จำนวน(ea)</th>
                                                        <th>ปริมาณสุทธิ</th>
                                                        <th>ราคา(บาท)</th>
                                                    </tr>
                                                    <?php
                                $sql = "SELECT * FROM material,store,cate_mate,mate_unit WHERE material.mate_id = store.mate_id AND material.unit_id = mate_unit.unit_id AND material.catemate_id = cate_mate.catemate_id";
                                $run = mysqli_query($conn,$sql);
                                $i=1;
                                while ($row=mysqli_fetch_assoc($run)) {

                                
                            ?>
                                                    <tr>
                                                        <td><?=$i?></td>
                                                        <td><?=$row["sto_date"]?></td>
                                                        <td><?=$row["type_mate"]?></td>
                                                        <td><?=$row["mate_name"]?></td>
                                                        <td><?=$row["sto_size"]?> <?=$row["unit_name"]?></td>
                                                        <td><?=$row["sto_amount"]?></td>
                                                        <td><?=$row["sto_balance"]?> <?=$row["unit_name"]?></td>
                                                        <td><?=$row["sto_price"]?></td>
                                                    </tr>

                                                    <?php
                            $i++;
                            }
                            ?>


                                                </table>

                                            </div>
                                            <?php } ?>
                                    </div>
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
            <?php
            $sql = "SELECT prod_name,SUM(income_amount) AS total_sold FROM income,product WHERE income.prod_id = product.prod_id GROUP BY product.prod_id ORDER BY total_sold DESC LIMIT 5";
            $result = $conn->query($sql);
            $products = array();
            $sales = array();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $products[] = $row["prod_name"];
                    $sales[] = (int)$row["total_sold"];
                }
            }
            ?>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <div>
                <h4 class="text-primary">5 อันดับ เมนูขายดีของร้าน</h4>
                <canvas id="barChart" width="800" height="250"></canvas>
                <script>
                var ctx = document.getElementById('barChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: <?php echo json_encode($products); ?>,
                        datasets: [{
                            label: 'จำนวนสินค้าที่ขายได้',
                            data: <?php echo json_encode($sales); ?>,
                            backgroundColor: 'skyblue'
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
                </script>
            </div>
        </div>
    </div>
</body>

</html>