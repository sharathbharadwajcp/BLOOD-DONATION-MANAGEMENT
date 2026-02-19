<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
include '../DB_conn.php';

// Handle approve/reject actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    if ($_GET['action'] === 'approve') {
        $con->query("UPDATE requests SET status = 'approved' WHERE id = $id");
    } elseif ($_GET['action'] === 'reject') {
        $con->query("UPDATE requests SET status = 'rejected' WHERE id = $id");
    }
    header("Location: requests.php");
    exit;
}

$result = $con->query("SELECT * FROM requests");
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="../css/main2.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.action-btn {
    display: inline-block;
    padding: 8px 18px;
    border-radius: 5px;
    color: #fff;
    font-weight: bold;
    text-decoration: none;
    margin: 0 4px;
    transition: background 0.2s, transform 0.2s;
    box-shadow: 0 2px 6px #bbb;
}
.action-approve {
    background: #4CAF50;
}
.action-approve:hover {
    background: #388E3C;
    transform: scale(1.08);
}
.action-reject {
    background: #bb0000;
}
.action-reject:hover {
    background: #880000;
    transform: scale(1.08);
}
.action-btn i {
    margin-right: 6px;
}
</style>
</head>
<body>
<div class="col-12" style="height: 350px">
    <div id="comname">
        <i class="fa fa-balance-scale" aria-hidden="true"></i><br><br>BLOOD <b>DONATION</b>
    </div>
    <span class="info2" style="left: 40%">BLOOD REQUESTS</span>
    <img class="myFrontPic col-12" src="../images/img23.jpg" style="height: 350px;">
</div>
<div class="col-12" style="overflow: auto; padding: 0 5% 0 5%;">
    <div class="col-12" style="text-align: left; padding: 2%; background-color: rgb(217, 219, 224);">
        <table border="1" style="width:100%; background:white;">
            <tr>
                <th>ID</th><th>Patient Name</th><th>Blood Group</th><th>Status</th><th>Actions</th>
            </tr>
            <?php while($row = $result && $row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['patient_name']) ?></td>
                <td><?= htmlspecialchars($row['blood_group']) ?></td>
                <td><?= htmlspecialchars($row['status']) ?></td>
                <td>
                    <?php if ($row['status'] !== 'approved'): ?>
                        <a class="action-btn action-approve" href="requests.php?action=approve&id=<?= $row['id'] ?>"><i class="fa fa-check"></i>Approve</a>
                    <?php endif; ?>
                    <?php if ($row['status'] !== 'rejected'): ?>
                        <a class="action-btn action-reject" href="requests.php?action=reject&id=<?= $row['id'] ?>"><i class="fa fa-times"></i>Reject</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <br>
        <a class="qw" href="dashboard.php">Back to Dashboard</a>
    </div>
</div>
<div id="footer" class="col-12" style="margin: 0; padding: 0;overflow: auto;">
    <?php include "../footer.php"; ?>
</div>
</body>
</html> 