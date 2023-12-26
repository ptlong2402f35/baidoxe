
<?php
$path_dir = __DIR__ . '';
include $path_dir . "/connectDB.php";
require 'ac_hook.php';
if (isset($_POST['method']) && isset($_POST['uid'])) {
    echo "<script type='text/javascript'>alert('dcmmmmm');</script>";
    $mathe = $_POST['uid'];
    if ($_POST['method'] === 'in') {
        $check = chechCardValid($mathe, $connection);
        if ($check) {
            echo $mathe;
            updateCardIn($mathe, $connection);
        }
    }
    if ($_POST['method'] === 'out') {
        $check = chechCardValid($mathe, $connection);
        if ($check)
            updateCardOut($mathe, $connection);
    }
    echo $_POST['method'];
}

?>