<?php
session_start();
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
	echo '<script>';
	echo 'console.log("login oke === ' . $data[0]['username'] . '");';
	echo '</script>';
	if ($data && $data[0]['username'] === $Usermail && $data[0]['password'] === $Userpass) {
		$checkLogin = true;
		$_SESSION["username"] = $data[0]['username'];
		$_SESSION["role"] = $data[0]['role'];
		header("location: parkingManagement.php");
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
