<?php
$path_dir = __DIR__ . '';
include $path_dir . "/connectDB.php";
include $path_dir . "/popup.php";
function updateActiveCard($status, $mathe, $connection)
{
    $sql = "UPDATE `card` set active=? where `card`.code = ?";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $status);
        $statement->bindParam(2, $mathe);
        echo '<script>';
        echo 'console.log("update do === ' . '");';
        echo '</script>';
        $statement->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
        redirect("cardManagement", "Da co loi");
    }
    redirect("cardManagement", "Thành công");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'updatestatus') {
    $code = isset($_POST['code']) ? $_POST['code'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : 1;
    updateActiveCard($status, $code, $connection);
} else {
    echo "Invalid request.";
}
