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
                <th>Họ tên</th>
                <th>Số điện thoại</th>
                <th>Email</th>
                <th>
                    Mã thẻ
                </th>
            </tr>

            <?php
            $path_dir = __DIR__ . '';
            include $path_dir . "/connectDB.php";
            $userInfo = getUserInfo($connection);
           
            foreach ($userInfo as $info) {
                echo "<tr>";
                echo "<td>" . $info['name'] . "</td>";
                echo "<td>";
                echo $info['phone'];
                echo "</td>";
                echo "<td>" . $info['email'] . "</td>";
                echo "<td>" . $info['cardCode'] . "</td>";;
                echo "</tr>";
            };
            ?>
        </table>
    </div>

</body>

</html>