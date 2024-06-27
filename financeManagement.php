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
    require 'ac_hook.php' ;
    $path_dir = __DIR__ . '';
            include $path_dir . "/connectDB.php";?>
    <style>
        .finanDivWrap {
            margin-top: 64px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
        }
        .totalDiv, .feeDiv, .vipDiv{
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
    </style>


    <div class="finanDivWrap">
        <div class="finanDivContent">
            <div class="totalDiv">
                <div class="counter">
                    <label>Tổng Thu nhập:</label>
                    <label><?php
                        $finanMoney = calcAllFinance($connection);
                        $vipCount = numberVipFinance($connection);
                        if(!$finanMoney) $finanMoney = 0;
                        if($vipCount) $vipCount = 0;
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
                        if($feeCount) echo $feeCount;
                        else echo "---";
                    ?></label>
                </div>
                <div class="total">
                    <label>Thu nhập:</label>
                    <label><?php 
                        $finanMoney = calcAllFinance($connection);
                        if($finanMoney) echo $finanMoney;
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
                        if($vipCount) echo $vipCount;
                        else echo 0;
                    ?></label>
                </div>
                <div class="total">
                    <label>Thu nhập:</label>
                    <label><?php 
                        $vipCount = numberVipFinance($connection);
                        if($vipCount) echo $vipCount * 200000;
                        else echo "---";
                    ?>đ</label>
                </div>
            </div>
        </div>
    </div>

</body>

</html>