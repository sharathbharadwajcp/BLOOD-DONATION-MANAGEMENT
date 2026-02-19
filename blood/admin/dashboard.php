<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
include '../DB_conn.php';
// Get stats
$donors_count = $con->query("SELECT COUNT(*) FROM donors")->fetch_row()[0];
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="../css/main2.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.admin-dashboard-bg {
    background: linear-gradient(135deg, #e0e4ea 0%, #f8fafc 100%);
    min-height: 100vh;
    padding: 0 0 60px 0;
}
.admin-center {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    min-height: 60vh;
}
.admin-welcome {
    color: #bb0000;
    font-size: 2em;
    font-weight: bold;
    margin: 40px 0 20px 0;
    text-align: center;
    letter-spacing: 1px;
}
.donor-card {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 24px 0 rgba(82,127,99,0.10), 0 1.5px 6px 0 rgba(82,127,99,0.10);
    padding: 48px 60px;
    margin: 30px 0 0 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 260px;
    min-height: 180px;
    transition: box-shadow 0.2s;
}
.donor-card:hover {
    box-shadow: 0 8px 32px 0 rgba(82,127,99,0.18), 0 3px 12px 0 rgba(82,127,99,0.18);
}
.donor-card .icon {
    font-size: 3.5em;
    color: #bb0000;
    margin-bottom: 18px;
}
.donor-card .count {
    font-size: 3.2em;
    color: #bb0000;
    font-weight: bold;
    margin-bottom: 10px;
}
.donor-card .label {
    font-size: 1.3em;
    color: #444;
    font-weight: 500;
    letter-spacing: 1px;
}
.dashboard-btns {
    margin-top: 40px;
    display: flex;
    gap: 24px;
    justify-content: center;
}
.dashboard-btn {
    background: #527f63;
    color: #fff !important;
    font-size: 1.2em;
    font-weight: bold;
    padding: 14px 36px;
    border-radius: 10px;
    text-decoration: none !important;
    transition: background 0.2s, transform 0.2s;
    box-shadow: 0 2px 6px #bbb;
    letter-spacing: 1px;
    margin: 0 8px;
}
.dashboard-btn:hover {
    background: #bb0000;
    color: #fff !important;
    transform: scale(1.05);
    text-decoration: none !important;
}
</style>
</head>
<body class="admin-dashboard-bg">
<div class="col-12" style="height: 350px; position: relative;">
    <div id="comname">
        <i class="fa fa-balance-scale" aria-hidden="true"></i><br><br>BLOOD <b>DONATION</b>
    </div>
    <div style="width:100%;text-align:center;position:relative;z-index:11;top:120px;">
        <span class="info2" style="position:static;display:inline-block;left:auto;top:auto;">ADMIN DASHBOARD</span>
    </div>
    <img class="myFrontPic col-12" src="../images/img23.jpg" style="height: 350px;">
</div>
<div class="admin-center">
    <div class="admin-welcome">Welcome, Admin!</div>
    <div class="donor-card">
        <div class="icon"><i class="fa fa-users"></i></div>
        <div class="count"><?= $donors_count ?></div>
        <div class="label">Total Donors</div>
    </div>
    <div class="dashboard-btns">
        <a class="dashboard-btn" href="donors.php">Manage Donors</a>
        <a class="dashboard-btn" href="logout.php">Logout</a>
    </div>
</div>
<div id="footer" class="col-12" style="margin: 0; padding: 0;overflow: auto;">
    <?php include "../footer.php"; ?>
</div>
</body>
</html> 