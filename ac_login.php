<?php
$path_dir = __DIR__ . '';
include $path_dir . "/connectDB.php";

if (isset($_POST['login'])) {

	$Usermail = $_POST['username'];
	$Userpass = $_POST['pwd'];

	if (empty($Usermail) || empty($Userpass)) {
		header("location: login.php?error=emptyfields");
		exit();
	}

	$sql = "select * from `tk` where username = ?";
	$checkLogin = false;
	try {
		$statement = $connection->prepare($sql);
		$statement->bindParam(1, $Usermail);
		$statement->execute();
		$data = $statement->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		echo $e->getMessage();
	}
	echo ($data[0]['username']);
	if ($data && $data[0]['username'] === $Usermail && $data[0]['password'] === $Userpass) {
		$checkLogin = true;
		header("location: parkingManagement.php?role=admin");
		exit();
	}
	if (!$data) {
		header("location: login.php?error=invalidEmail");
		exit();
	}
	if ($data && $data[0]['username'] === $Usermail && $data[0]['password'] !== $Userpass) {
		header("location: login.php?error=wrongpassword");
		exit();
	}
} else {
	header("location: login.php");
	exit();
}
