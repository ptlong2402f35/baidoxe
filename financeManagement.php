<?php
include 'header.php';
// $adminRole = false;
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
    require 'ac_hook.php';
    $path_dir = __DIR__ . '';
    include $path_dir . "/connectDB.php"; ?>
    <style>
        .finanDivWrap {
            margin-top: 64px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
        }

        .totalDiv,
        .feeDiv,
        .vipDiv {
            margin-bottom: 24px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .total {
            color: greenyellow;
            margin-left: 64px;
        }

        .labelfinancediv {
            margin-right: 48px;
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
                <label for="start_date_fin">Start Date:</label>
                <input type="date" id="start_date_fin" name="start_date_fin" required>
                <br>
                <label for="end_date_fin">End Date:</label>
                <input type="date" id="end_date_fin" name="end_date_fin" required>
                <br>
                <input type="submit" value="Lọc">
            </form>
        </div>
    </div>
    <?php
        $start_date = null;
        $end_date = null;
        $finanMoney = 0;
        $vipCount = 0;
        $totalValue = 0;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $start_date = $_POST['start_date_his'];
            $end_date = $_POST['end_date_his'];
            $transactions = getTransactionsWithDate($start_date, $end_date, $connection);
        } else {
            $transactions = getTransactionsWithDate($start_date, $end_date, $connection);
        }
    ?>
    <div class="finanDivWrap">
        <div class="finanDivContent">
            <div class="totalDiv">
                <div class="counter">
                    <label>Tổng Thu nhập:</label>
                    <label><?php
                            $finanMoney = calcAllFinance($connection);
                            $vipCount = numberVipFinance($connection);
                            if (!$finanMoney) $finanMoney = 0;
                            if ($vipCount) $vipCount = 0;
                            echo $finanMoney + $vipCount * 200000;
                            ?>đ</label>
                </div>
            </div>
            <div class="feeDiv">
                <div class="labelfinancediv">
                    <label>Khách hàng bình thường:</label>
                </div>
                <div class="counter">
                    <label>Số lượng:</label>
                    <label><?php
                            $feeCount = numberFee($connection);
                            if ($feeCount) echo $feeCount;
                            else echo "---";
                            ?></label>
                </div>
                <div class="total">
                    <label>Thu nhập:</label>
                    <label><?php
                            $finanMoney = calcAllFinance($connection);
                            if ($finanMoney) echo $finanMoney;
                            else echo "---";
                            ?>đ</label>
                </div>
            </div>
            <div class="vipDiv">
                <div class="labelfinancediv">
                    <label>Khách hàng VIP:</label>
                </div>
                <div class="counter">
                    <label>Số lượng:</label>
                    <label><?php
                            $vipCount = numberVipFinance($connection);
                            if ($vipCount) echo $vipCount;
                            else echo 0;
                            ?></label>
                </div>
                <div class="total">
                    <label>Thu nhập:</label>
                    <label><?php
                            $vipCount = numberVipFinance($connection);
                            if ($vipCount) echo $vipCount * 200000;
                            else echo "---";
                            ?>đ</label>
                </div>
            </div>
        </div>
    </div>

</body>

</html>