<?php
$adminRole = false;
if (isset($_GET['role'])) {
    if ($_GET['role'] != 'admin') {
        header("location: login.php?error=noAdmin");
        exit();
    }
    $adminRole = true;
} else {
    header("location: login.php?error=noAdmin");
    exit();
}
?>


<!DOCTYPE html>
<html>

<head>
    <!-- <meta http-equiv="refresh" content="5"> -->
</head>

<body>
    <?php include 'header.php';
    require 'ac_hook.php' ?>
    <style>
        .form-wrap {
            width: 100%;
            min-height: 500px;
            display: flex;
            justify-content: center;
            margin-top: 24px;
        }

        .form-contain {
            border-radius: 30px;
            padding: 18px 12px;
            color: #fff;
        }

        .form-title {
            text-align: center;
        }

        .form-box {
            margin-top: 24;
        }

        .signup-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .signup-form input {
            padding: 12px 24px;
            border-radius: 24px;
            font-size: 16px;
            color: #000;
        }

        #signup {
            padding: 18px 32px;
            border-radius: 30px;
            border: none;
            background-color: #21a0ab;
            font-size: 18px;
        }
    </style>


    <div id="" class="form-wrap">
        <div class="form-contain">
            <h2 class="form-title">Đăng kí thành viên vip</h2>
            <div class="form-box">
                <form class="signup-form" action="ac_signup.php" method="post" enctype="multipart/form-data">
                    <input type="text" name="hoten" id="hoten" placeholder="Họ tên" required />
                    <input type="text" name="dienthoai" id="dienthoai" placeholder="Số điện thoại" required />
                    <input type="text" name="email" id="email" placeholder="Email" required />
                    <input type="text" name="mathe" id="mathe" placeholder="Mã thẻ" required />
                    <button type="submit" name="signup" id="signup">Đăng kí và tạo thẻ</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>