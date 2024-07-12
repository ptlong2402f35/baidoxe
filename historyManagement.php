<?php
include 'header.php';
$adminRole = false;
// if (isset($_GET['role'])) {
//     if ($_GET['role'] != 'admin') {
//         header("location: login.php?error=noAdmin");
//         exit();
//     }
//     $adminRole = true;
// } else {
//     header("location: login.php?error=noAdmin");
//     exit();
// }
$username = null;
$role = null;
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    if ($role != 1) {
        header("location: login.php");
    }
} else {
    header("location: login.php");
}
?>


<!DOCTYPE html>
<html>

<head>
    <!-- <meta http-equiv="refresh" content="2"> -->
</head>

<body>
    <?php
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

        .filterContent>form {
            display: flex;
            align-items: start;
            justify-content: start;
            margin: 12px 0 24px;
            gap: 24px;
        }
    </style>

    <div class="filterDivWrapper">
        <div class="filterContent">
            <form action="" method="post">
                <label for="start_date_his">Start Date:</label>
                <input type="date" id="start_date_his" name="start_date_his" value="null">
                <br>
                <label for="end_date_his">End Date:</label>
                <input type="date" id="end_date_his" name="end_date_his" value="null">
                <br>
                <input type="submit" value="Lọc">
            </form>
        </div>
    </div>

    <div id="parking" class="parking">
        <table id="table-show">
            <tr>
                <th>Mã thẻ</th>
                <th>Đối tượng</th>
                <th>Thời gian vào bến</th>
                <th>Thời gian ra bến</th>
                <th>
                    Phí gửi xe
                </th>
            </tr>

            <?php
            $path_dir = __DIR__ . '';
            include $path_dir . "/connectDB.php";
            $start_date = null;
            $end_date = null;
            $transactions = [];
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $start_date = $_POST['start_date_his'];
                $end_date = $_POST['end_date_his'];

                // Chuyển đổi ngày thành timestamp để so sánh
                // $start_date = strtotime($start_date);
                // $end_date = strtotime($end_date);

                $transactions = getTransactionsWithDate($start_date, $end_date, $connection);
            } else {
                $transactions = getTransactionsWithDate($start_date, $end_date, $connection);
            }

            // echo "<script>console.log('" . json_encode($transactions) . "');</script>";

            foreach ($transactions as $info) {
                echo "<tr>";
                echo "<td>" . $info['cardCode'] . "</td>";
                echo "<td>";
                echo ($info['userPhone'] && strlen($info['userPhone'])) ? "Đăng kí vip" :  "Khách";
                echo "</td>";
                echo "<td>" . $info['signIn']  . "</td>";
                echo "<td>";
                echo $info['signOut'] ? $info['signOut'] : "Chưa rời bến";
                echo "</td>";
                echo "<td>";
                echo ($info['value'] || $info['value'] >= 0) ? $info['value'] : "Chưa rời bến";
                echo "</td>";
                echo "</tr>";
            };
            ?>
        </table>
    </div>

</body>

<!-- <script>
    let transactionsData = <?php print_r($jsTrans) ?>;
</script> -->

</html>