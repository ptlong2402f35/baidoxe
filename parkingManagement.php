<?php
$adminRole = false;
if (isset($_GET['role'])) {
    if ($_GET['role'] != 'admin') {
        header("location: login.php?error=noAdmin");
        exit();
    }
    $adminRole = true;
} else {
    header("location: login.php?error=noAdmin");
    exit();
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="refresh" content="2">
</head>

<body>
    <?php include 'header.php';
    require 'ac_hook.php' ?>
    <style>
        #table-show {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #table-show td,
        #table-show th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #table-show tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #table-show tr:hover {
            background-color: #ddd;
        }

        #table-show th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #00A8A9;
            color: white;
        }
    </style>


    <div id="parking" class="parking">
        <table id="table-show">
            <tr>
                <th>Mã thẻ</th>
                <th>Đối tượng</th>
                <th>Thời gian vào bến</th>
                <th>
                    Chi tiết
                </th>
            </tr>

            <?php
            $path_dir = __DIR__ . '';
            include $path_dir . "/connectDB.php";
            $parkingInfo = getParkingInfo($connection);
            $sql = "SELECT * FROM logs ORDER BY id DESC";
            foreach ($parkingInfo as $info) {
                echo "<tr>";
                echo "<td>" . $info['code'] . "</td>";
                echo "<td>";
                echo ($info['userPhone'] && strlen($info['userPhone'])) ? "Đăng kí vip" :  "Khách";
                echo "</td>";
                echo "<td>" . $info['signIn'] . "</td>";
                echo "<td>" . "<button>Xem chi tiết</button>" . "</td>";
                echo "</tr>";
            };
            ?>
        </table>
    </div>

</body>

</html>