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
    <!-- <meta http-equiv="refresh" content="5"> -->
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
                <th>Trạng thái</th>
                <th>Đăng kí bởi</th>
                <th>
                    Ngày tạo
                </th>
            </tr>

            <?php
            $path_dir = __DIR__ . '';
            include $path_dir . "/connectDB.php";
            $cardInfo = getCardInfo($connection);

            foreach ($cardInfo as $info) {
                echo "<tr>";
                echo "<td>" . $info['code'] . "</td>";
                echo "<td>";
                echo ($info['status'] === strval(1)) ? "Đang hoạt động" :  "Không hoạt động";
                echo "</td>";
                echo "<td>";
                echo ($info['userPhone']) ? $info['userPhone'] :  "Chưa đăng kí";
                echo "</td>";
                echo "<td>" . $info['createdAt'] . "</td>";;
                echo "</tr>";
            };
            ?>
        </table>
    </div>

</body>

</html>