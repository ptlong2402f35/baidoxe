
<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');


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
    $todaydate = date("Y-m-d H:i:s");
    $now = date('Y-m-d H:i:s', strtotime($todaydate));

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
    $todaydate = date("Y-m-d H:i:s");
    $now = date('Y-m-d H:i:s', strtotime($todaydate));
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

function checkCardValid($mathe, $connection)
{
    $sql = "SELECT * from `card` where code=? ";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $mathe);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if ($data && $data[0]['active'] === 1) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        $e->getMessage();
    }
    return null;
}

function checkMethodDetect($mathe, $connection)
{
    $sql = "SELECT * from `card` where code=? ";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $mathe);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if ($data && $data[0]['status'] === 1) {
            return "out";
        } else {
            return "in";
        }
    } catch (PDOException $e) {
        $e->getMessage();
    }
    return null;
}

function calcFee($mathe, $connection)
{
    $sql = "SELECT * from `card` where code=? ";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $mathe);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if ($data && $data[0]) {
            $card = $data[0];
            if ($card['userPhone']) return 0;
            $start = new DateTime($card['signIn']);
            $end = new DateTime();
            $distance = $start->diff($end);
            if ($distance->days > 0) {
                return 30000;
            } else {
                if ($distance->h > 12) {
                    return 20000;
                }
                return 10000;
            }
        } else {
            return false;
        }
    } catch (PDOException $e) {
        $e->getMessage();
    }
    return null;
}

function createTransactions($mathe, $connection)
{
    $todaydate = date("Y-m-d H:i:s");
    $now = date('Y-m-d H:i:s', strtotime($todaydate));
    $getSql = "SELECT * from `card` where `card`.code = ? ";
    $userPhone = null;
    try {
        $statement = $connection->prepare($getSql);
        $statement->bindParam(1, $mathe);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if ($data && $data[0]) {
            $userPhone = $data[0]['userPhone'];
        } else {
            return false;
        }
    } catch (PDOException $e) {
        $e->getMessage();
    }
    $sql = "insert into transactions values(?,null,?,?,null,?,?)";
    try {
        $statement = $connection->prepare($sql);

        $statement->bindParam(1, $mathe);
        $statement->bindParam(2, $userPhone);
        $statement->bindParam(3, $now);
        $statement->bindParam(4, $now);
        $statement->bindParam(5, $now);
        $statement->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function updateTransactions($mathe, $fee, $connection)
{
    $todaydate = date("Y-m-d H:i:s");
    $now = date('Y-m-d H:i:s', strtotime($todaydate));
    $sql = "UPDATE `transactions` set `transactions`.value=?,signOut=?,updatedAt=? where `transactions`.cardCode = ? and `transactions`.signOut is null";
    try {
        $statement = $connection->prepare($sql);

        $statement->bindParam(1, $fee);
        $statement->bindParam(2, $now);
        $statement->bindParam(3, $now);
        $statement->bindParam(4, $mathe);
        $statement->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function updateWallet($fee, $connection)
{
    $getSql = "SELECT * from `tk` where `tk`.userName = 'admin' ";
    $totalMoney = 0;
    try {
        $statement = $connection->prepare($getSql);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if ($data && $data[0]) {
            $totalMoney = $data[0]['totalMoney'];
        } else {
            return false;
        }
    } catch (PDOException $e) {
        $e->getMessage();
    }

    $sql = "UPDATE `tk` set totalMoney=? where `tk`.userName = 'admin'";
    $total = $totalMoney + $fee;
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $total);
        $statement->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function getTransactions($connection)
{
    $sql = "SELECT * from `transactions` ORDER BY updatedAt DESC";
    try {
        $statement = $connection->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if ($data) {
            return $data;
        }
        return [];
    } catch (PDOException $e) {
        $e->getMessage();
    }
    return null;
}

function calcAllFinance($connection)
{
    $calcTrans = getTransactions($connection);
    $totalTrans = 0;
    foreach ($calcTrans as $trans) {
        if ($trans['value']) {
            $totalTrans += $trans['value'];
        }
    }

    return $totalTrans;
}

function numberFee($connection)
{
    $sql = "select COUNT(*) as count
            FROM transactions
            WHERE userPhone = null and signOut != null;";
    try {
        $statement = $connection->prepare($sql);
        $statement->execute();
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        return $data['count'];
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function numberVipFinance($connection)
{
    $sql = "select COUNT(*) as count
            FROM card
            WHERE userPhone != null;";
    try {
        $statement = $connection->prepare($sql);
        $statement->execute();
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        return $data['count'];
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function countUsedCard($connection)
{
    $sql = "select COUNT(*) as count from `card` WHERE `card`.status = 1";
    try {
        $statement = $connection->prepare($sql);
        $statement->execute();
        $data = $statement->fetch(PDO::FETCH_ASSOC);

        return $data['count'];
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//filter date for finance

function getTransactionsWithDate($start, $end, $connection)
{
    echo '<script>';
    echo 'console.log("check === ' . addslashes($start) . addslashes($end) . '");';
    echo '</script>';
    if (!$start || !$end) {
        return getTransactions($connection);
    }

    $sql = "SELECT * from `transactions` where createdAt >= ? and createdAt <= ? ORDER BY updatedAt DESC";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $start);
        $statement->bindParam(2, $end);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);

        if ($data) {
            return $data;
        }
        return [];
    } catch (PDOException $e) {
        $e->getMessage();
    }
    return null;
}
