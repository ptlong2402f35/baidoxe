<?php
$path_dir = __DIR__ . '';
include $path_dir . "/connectDB.php";
include 'popup.php';

if (isset($_POST['signup'])) {

    $userName = $_POST['userName'];
    // $userPhone = $_POST['phone'];
    // $userEmail = $_POST['email'];
    $password = $_POST['password'];
    $sql = "insert into tk values(?,?,0,0)";
    // try {
    //     $statement = $connection->prepare($sql);

    //     $statement->bindParam(1, $userName);
    //     $statement->bindParam(2, $password);
    //     $statement->execute();
    // } catch (PDOException $e) {
    //     echo $e->getMessage();
    //     redirect("staffCreate", "Đã có lỗi xảy ra");
    // }

    redirect("staffCreate", "Thành công");
    header("location: staffCreate.php");
}
