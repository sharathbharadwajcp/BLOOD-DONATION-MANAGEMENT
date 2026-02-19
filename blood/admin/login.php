<?php
session_start();
include '../DB_conn.php';

if (isset($_SESSION['admin_logged_in'])) {
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $con->prepare("SELECT * FROM admin WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="../css/main2.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div class="col-12" style="height: 350px">
    <div id="comname">
        <i class="fa fa-balance-scale" aria-hidden="true"></i><br><br>BLOOD <b>DONATION</b>
    </div>
    <span class="info2" style="left: 40%">ADMIN LOGIN</span>
    <img class="myFrontPic col-12" src="../images/img23.jpg" style="height: 350px;">
</div>
<div class="col-12" style="overflow: auto; padding: 0 30% 0 30%;">
    <div class="col-12" style="text-align: left; padding: 5%; background-color: rgb(217, 219, 224);">
        <form action="login.php" method="post">
            <label>Username</label><br>
            <input class="in" type="text" name="username" placeholder="Enter Username" required style="color: black;"><br><br>
            <label>Password</label><br>
            <input class="in" type="password" name="password" placeholder="Password" required style="color: black;"><br><br>
            <input class="qw" style="font-size: 16px; color: white;" type="submit" value="Login">
            <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        </form>
    </div>
</div>
<div id="footer" class="col-12" style="margin: 0; padding: 0;overflow: auto;">
    <?php include "../footer.php"; ?>
</div>
</body>
</html> 