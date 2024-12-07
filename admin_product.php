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
            <h1 class="mb-4 h2 alert alert-dark" role="alert">สินค้า</h1>
            <button type="button" class="btn btn-success mb-4" data-bs-toggle="modal" data-bs-target="#exampleModal">
                เพิ่ม
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">เพิ่มข้อมูลสินค้า</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="insert_product.php">
                                <label>ชื่อสินค้า</label><br>
                                <input type="text" name="prod_name" class="form-control" placeholder="ชื่อสินค้า"
                                    required><br>
                                <label>ประเภทสินค้า</label><br>
                                <select name="cateprod_name" class="form-select" aria-label="Default select example"
                                    required>
                                    <option selected>เลือก</option>
                                    <?php
                                    $sql = "SELECT * FROM cate_prod";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='{$row["cateprod_id"]}'>{$row["cateprod_name"]}</option>";
                                    }
                                    ?>
                                </select><br>
                                <label>ชนิดสินค้า</label><br>
                                <select name="prod_detail" class="form-select" aria-label="Default select example"
                                    required>
                                    <option selected>เลือก</option>
                                    <option value="ร้อน">ร้อน</option>
                                    <option value="เย็น">เย็น</option>
                                    <option value="ปั่น">ปั่น</option>
                                </select><br>
                                <label>ราคา(บาท)</label><br>
                                <input type="text" name="prod_price" class="form-control" placeholder="ราคา(บาท)"
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
            <button type="button" class="btn btn-success mb-4 ms-4" data-bs-toggle="modal"
                data-bs-target="#cateprodModal">
                เพิ่ม-ลบ ประเภท
            </button>

            <!-- Modal -->
            <div class="modal fade" id="cateprodModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">เพิ่ม-ลบ : ประเภทสินค้า</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="insert_cateprod.php">
                                <div class="d-flex flex-row mb-3">
                                    <input type="text" name="cateprod_name" class="form-control"
                                        placeholder="ชื่อประเภทสินค้า" required>
                                    <button type="submit" class="btn btn-success">เพิ่ม</button>
                                </div>
                                <table class="table table-striped shadow p-3 mb-5 bg-body-tertiary rounded">
                                    <tr>
                                        <th>No.</th>
                                        <th>รายการประเภท</th>
                                        <th>เลือก</th>
                                    </tr>
                                    <?php
                                    $sql = "SELECT * FROM cate_prod";
                                    $result = mysqli_query($conn,$sql);
                                    $counter2 = 1;
                                    while($row=mysqli_fetch_array($result)){
                                    ?>
                                    <tr>
                                        <td><?=$counter2?></td>
                                        <td><?=$row["cateprod_name"]?></td>
                                        <td><a href="delete_cateprod.php?cateprod_id=<?=$row["cateprod_id"]?>"
                                                class="btn btn-danger" onclick="Del(this.href);return false;">ลบ</a>
                                        </td>
                                    </tr>
                                    <?php
                                    $counter2++;
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
                    <th>ชนิด</th>
                    <th>ราคา(บาท)</th>
                    <th>แก้ไข</th>
                    <th>ลบ</th>
                    <th>เพิ่ม/ลบ : ส่วนผสม</th>   
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
                        <button type="button" class="btn btn-warning mb-4" data-bs-toggle="modal"
                            data-bs-target="#editModal<?=$row["prod_id"]?>">
                            แก้ไข
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="editModal<?=$row["prod_id"]?>" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">แก้ไขข้อมูล</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="update_product.php">
                                            <input type="hidden" name="prod_id" value="<?=$row['prod_id']?>">
                                            <label>ชื่อสินค้า</label><br>
                                            <input type="text" name="prod_name" class="form-control"
                                                value="<?=$row['prod_name']?>"><br>
                                            <label>ประเภทสินค้า</label><br>
                                            <select name="cateprod_name" class="form-select"
                                                aria-label="Default select example" required>
                                                <option selected disabled>เลือก</option>
                                                <?php
                            $sql_categories = "SELECT * FROM cate_prod";
                            $result_categories = mysqli_query($conn, $sql_categories);
                            while ($category = mysqli_fetch_assoc($result_categories)) {
                                $selected = ($category['cateprod_id'] == $row['cateprod_id']) ? 'selected' : '';
                                echo "<option value='{$category["cateprod_id"]}' $selected>{$category["cateprod_name"]}</option>";
                            }
                            ?>
                                            </select><br>
                                            <label>ชนิดสินค้า</label><br>
                                            <select name="prod_detail" class="form-select"
                                                aria-label="Default select example" required>
                                                <option selected disabled>เลือก</option>
                                                <option value="ร้อน"
                                                    <?php if($row['prod_detail'] == "ร้อน") echo "selected"; ?>>ร้อน
                                                </option>
                                                <option value="เย็น"
                                                    <?php if($row['prod_detail'] == "เย็น") echo "selected"; ?>>เย็น
                                                </option>
                                                <option value="ปั่น"
                                                    <?php if($row['prod_detail'] == "ปั่น") echo "selected"; ?>>ปั่น
                                                </option>
                                            </select><br>
                                            <label>ราคา(บาท)</label><br>
                                            <input type="text" name="prod_price" class="form-control"
                                                value="<?=$row['prod_price']?>"><br>
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
                    <td><a href="delete_product.php?prod_id=<?=$row["prod_id"]?>" class="btn btn-danger"
                            onclick="Del(this.href);return false;">ลบ</a></td>
                            <td>
                        <button type="button" class="btn btn-success mb-4 ms-4" data-bs-toggle="modal"
                            data-bs-target="#catemateModal<?=$row["prod_id"]?>">
                            เพิ่ม/ลบ : ส่วนผสม
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="catemateModal<?=$row["prod_id"]?>" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">เพิ่ม/ลบ : ส่วนผสมสินค้า
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
                                                    <th>เลือก</th>
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
                                                    <td><a href="delete_ing.php?ing_id=<?=$row["ing_id"]?>"
                                                            class="btn btn-danger"
                                                            onclick="Del(this.href);return false;">ลบ</a>
                                                    </td>
                                                </tr>
                                                <?php
                                    $counter1++;
                                    }
                                    ?>
                                            </table>
                                            <h4>เพิ่มส่วนผสม</h4>
                                            <label>ชื่อ</label><br>
                                            <select name="mate_name" class="form-select"
                                                aria-label="Default select example" required>
                                                <option selected>เลือก</option>
                                                <?php
                                    $sql2 = "SELECT * FROM material";
                                    $result2 = mysqli_query($conn, $sql2);
                                    while ($row = mysqli_fetch_assoc($result2)) {
                                    ?>
                                                <option value="<?=$row["mate_id"]?>"><?=$row["mate_name"]?></option>
                                                <?php
                                    }
                                    ?>
                                            </select><br>
                                            <label>ขนาด</label><br>
                                            <input type="text" name="ing_balance" class="form-control"
                                                placeholder="ชื่อประเภทวัตถุดิบ-อุปกรณ์" required>
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