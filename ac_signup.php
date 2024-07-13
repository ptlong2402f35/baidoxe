<?php
$path_dir = __DIR__ . '';
include $path_dir . "/connectDB.php";
include "popup.php";

if (isset($_POST['signup'])) {

    $userName = $_POST['hoten'];
    $userPhone = $_POST['dienthoai'];
    $userEmail = $_POST['email'];
    $userCode = $_POST['mathe'];
    $todaydate = date("Y-m-d H:i:s");
    $now = date('Y-m-d H:i:s', strtotime($todaydate));
    //check card exist and user owner
    $existCard = null;
    $checkExistSql = "select * from card where code = ?";
    try {
        $statement = $connection->prepare($checkExistSql);

        $statement->bindParam(1, $userCode);
        $statement->execute();
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        echo '<script>';
        echo 'console.log("check exist === ' . $data . '");';
        echo '</script>';
        $existCard = $data;
    } catch (PDOException $e) {
        echo $e->getMessage();
        redirect("createUser", "Đã có lỗi xảy ra");
    }

    if (!$existCard) {
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
        $sqlCard = "insert into card values(?,0,?,null,?,?,1, null)";
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
    } else {
        $sqlDeleteCard = "delete from user where cardCode = ?";
        try {
            $statement = $connection->prepare($sqlDeleteCard);

            $statement->bindParam(1, $userCode);
            $statement->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            redirect("createUser", "Đã có lỗi xảy ra");
        }
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
        $crSqlCard = "update card set userPhone = ?,active = 1 where code=?";
        try {
            $statement = $connection->prepare($crSqlCard);

            $statement->bindParam(1, $userPhone);
            $statement->bindParam(2, $userCode);
            $statement->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            redirect("createUser", "Đã có lỗi xảy ra");
        }
        redirect("createUser", "Tạo mới User và cập nhật thẻ thành công");
    }
}
