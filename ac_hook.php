
<?php


function getParkingInfo($connection)
{
    $sql = "SELECT * from `card` where status = 1 ORDER BY updatedAt DESC";
    try {
        $statement = $connection->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    } catch (PDOException $e) {
        $e->getMessage();
    }
    return null;
}

function getUserInfo($connection)
{
    $sql = "SELECT * from `user` ";
    try {
        $statement = $connection->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    } catch (PDOException $e) {
        $e->getMessage();
    }
    return null;
}

function getCardInfo($connection)
{
    $sql = "SELECT * from `card` ";
    try {
        $statement = $connection->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    } catch (PDOException $e) {
        $e->getMessage();
    }
    return null;
}

function updateCardIn($mathe, $connection)
{
    $todaydate = date("Y-m-d");
    $now = date('Y-m-d', strtotime($todaydate));
    echo $now;
    $sql = "UPDATE `card` set status=1,signIn=?,updatedAt=? where `card`.code = ?";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement =  $connection->prepare($sql);

        $statement->bindParam(1, $now);
        $statement->bindParam(2, $now);
        $statement->bindParam(3, $mathe);
        $statement->execute();

        $connection = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    return null;
}

function updateCardOut($mathe, $connection)
{
    $todaydate = date("Y-m-d");
    $now = date('Y-m-d', strtotime($todaydate));
    $sql = "UPDATE `card` set status=0,signIn=null,updatedAt=? where `card`.code = ? ";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement =  $connection->prepare($sql);

        $statement->bindParam(1, $now);
        $statement->bindParam(2, $mathe);
        $statement->execute();

        $connection = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    return null;
}

function chechCardValid($mathe, $connection)
{
    $sql = "SELECT * from `card` where code=? ";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $mathe);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if ($data) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        $e->getMessage();
    }
    return null;
}
