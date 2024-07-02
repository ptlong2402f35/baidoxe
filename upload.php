
<?php
$totalCount = 10;
$usedCount;
$fee = 0;
$path_dir = __DIR__ . '';
include $path_dir . "/connectDB.php";
require 'ac_hook.php';
if (isset($_POST['method']) && isset($_POST['uid'])) {
    echo "<script type='text/javascript'>alert('dcmmmmm');</script>";
    $mathe = $_POST['uid'];
    if ($_POST['method'] === 'in') {
        $check = checkCardValid($mathe, $connection);
        if ($check) {
            echo $mathe;
            updateCardIn($mathe, $connection);
            createTransactions($mathe, $connection);
            $usedCount = countUsedCard($connection);
        }
    }
    if ($_POST['method'] === 'out') {
        $check = checkCardValid($mathe, $connection);
        if ($check) {
            updateCardOut($mathe, $connection);
            $fee = calcFee($mathe, $connection);
            updateTransactions($mathe, $fee, $connection);
            updateWallet($fee, $connection);
        }
    }
    echo $_POST['method'] . "-" . $fee . "-" . ($totalCount - $usedCount);
}

?>