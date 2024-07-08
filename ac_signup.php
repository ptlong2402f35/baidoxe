<?php
$path_dir = __DIR__ . '';
include $path_dir . "/connectDB.php";
include "popup.php";

if (isset($_POST['signup'])) {

    $userName = $_POST['hoten'];
    $userPhone = $_POST['dienthoai'];
    $userEmail = $_POST['email'];
    $userCode = $_POST['mathe'];
    $now = date("d-m-Y H:i:s");
    $sql = "insert into user values(?,?,?,?,?,?)";
    try {
        $statement = $connection->prepare($sql);

        $statement->bindParam(1, $userName);
        $statement->bindParam(2, $userPhone);
        $statement->bindParam(3, $userEmail);
        $statement->bindParam(4, $userCode);
        $statement->bindParam(5, $now);
        $statement->bindParam(6, $now);
        $statement->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
        redirect("createUser", "Đã có lỗi xảy ra");
    }

    $sqlCard = "insert into card values(?,0,?,null,?,?)";
    try {
        $statement = $connection->prepare($sqlCard);

        $statement->bindParam(1, $userCode);
        $statement->bindParam(2, $userPhone);
        $statement->bindParam(3, $now);
        $statement->bindParam(4, $now);
        $statement->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
        redirect("createUser", "Đã có lỗi xảy ra");
    }
    redirect("createUser", "Thành công");
}
