<?php
require_once ('config.php');
require_once ('database.php');
session_start();
$conn = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
if ($conn === false) {
    die("ERROR: Không thể kết nối. " . mysqli_connect_error());
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
</head>

<body>
<h1>LOGIN</h1>

<?php

// Kiểm tra xem Người dùng có sử dụng Ghi nhớ Đăng nhập không?
if(isset($_COOKIE['is_logged'])) {
    // Lấy thông tin từ COOKIE từ Web Browser của client gởi đến
    $username_logged = isset($_COOKIE['username_logged']) ? $_COOKIE['username_logged'] : '';
    $_SESSION['UserName'] = $_COOKIE['username_logged'];
    echo "Xin chào <b>$username_logged</b>! Bạn đã đăng nhập rồi.";
    echo "Bạn sẽ được chuyển đến trang chủ trong 5s;";
    echo '<script>setTimeout(function(){ window.location="index.php" }, 5000);</script>';
    die;
}
?>

<!-- Form Login -->
<form name="frmLogin" method="post" action="">
    Tài khoản: <input type="text" name = "UserName" id="UserName" /><br />
    Mật khẩu: <input type="text" name = "Password" id="Password" /><br />
    Ghi nhớ đăng nhập: <input type="checkbox" name="remember_me" id="remember_me" value="1" /><br />
    <input type="submit" name="btnLogin" value="Đăng nhập" />
</form>

<?php

// Xử lý nếu người dùng có bấm nút "btnLogin"
if(isset($_POST['btnLogin'])) {
    // Lấy thông tin người dùng gởi đến Server
    $UserName = isset($_POST['UserName']) ? $_POST['UserName'] : false;
    $UserName = str_replace('/[^0-9]/', '', $UserName);
    $Password = isset($_POST['Password']) ? $_POST['Password'] : false;
    $Password = str_replace('/[^0-9]/', '', $Password);
    $UserName = mysqli_real_escape_string($conn, $UserName);
    $Password = mysqli_real_escape_string($conn, $Password);
    $Password = md5($Password);
    //$UserName = isset($_POST['UserName'])?(string)(int)$_POST['UserName']:false;
    //$Password = isset($_POST['Password'])?(string)(int)$_POST['Password']:false;
    //$UserName = $_POST['UserName'];
    //$Password = $_POST['Password'];
    $sql = " select * from user where UserName = '$UserName' and Password = '$Password '";
    //UserName = mysqli_real_escape_string($conn,$UserName);
    //$Password = mysqli_real_escape_string($conn,$Password);
    //$sql= $conn->real_escape_string($sql);
    //$rows = mysqli_query($conn,"
	//			select * from user where UserName = '$UserName' and Password = '$Password '
	//		");
    //$rows = $conn->query($sql);
    $rows = mysqli_query($conn,$sql);
    // Đối với checkbox cần kiểm tra xem giá trị có tồn tại hay không?
    // Nếu có thì lấy giá trị do người dùng checked; nếu không thì phải gán giá trị mặc định
    $remember_me = isset($_POST['remember_me']) ? 1 : 0;
    $count = mysqli_num_rows($rows);
    $row_save = mysqli_fetch_array($rows);
    if($count == 1) {

        // Nếu người dùng có chọn "Ghi nhớ Đăng nhập"
        // => tiến hành lưu thông tin vào COOKIE và gởi lại người dùng
        if($remember_me == 1) {
            // Thiết lập Cookie "Ghi nhớ đăng nhập" trong 15' ~ 3600s
            setcookie('is_logged', true, time()+ 120, '/');

            // Thiết lập Cookie "Tên username đã đăng nhập" trong 15' ~ 3600s
            setcookie("username_logged", $UserName, time() + 120 ,"/","", 0);
        }
        $_SESSION['UserName'] = $UserName;
        // Hiển thị thông tin chào mừng
        if($row_save['Lever'] == 1){
            header('Location: index.php?UserName='.$UserName);
        }
        if($row_save['Lever'] == 2){
            header('Location: index_sv.php?UserName='.$UserName);
        }
    } else {
        echo "Đăng nhập thất bại!";
    }
}
?>


</body>

</html>