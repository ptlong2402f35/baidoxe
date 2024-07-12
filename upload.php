
<?php
$totalCount = 10;
$usedCount;
$fee = 0;
$path_dir = __DIR__ . '';
include $path_dir . "/connectDB.php";
require 'ac_hook.php';
if (isset($_POST['method']) && isset($_POST['uid'])) {
    // echo "<script type='text/javascript'>alert('dcmmmmm');</script>";
    $mathe = $_POST['uid'];
    $check = checkCardValid($mathe, $connection);
    $usedCount = countUsedCard($connection);
    if ($_POST['method'] === 'detect') {
        $fMethod = checkMethodDetect($mathe, $connection);
        if ($check && $fMethod === "in") {
            // echo $mathe;
            updateCardIn($mathe, $connection);
            createTransactions($mathe, $connection);
            $usedCount += 1;
        }
        if ($check && $fMethod === "out") {
            updateCardOut($mathe, $connection);
            $fee = calcFee($mathe, $connection);
            updateTransactions($mathe, $fee, $connection);
            updateWallet($fee, $connection);
            $usedCount -= 1;
        }
        if (!$check) {
            echo "invalid-0-" . ($totalCount - $usedCount);
            return;
        }
        echo $fMethod . "-" . $fee . "-" . ($totalCount - $usedCount);
    }
}

?>