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
        $con->query("UPDATE donors SET status = 'approved' WHERE id = $id");
    } elseif ($_GET['action'] === 'reject') {
        $con->query("UPDATE donors SET status = 'rejected' WHERE id = $id");
    } elseif ($_GET['action'] === 'delete') {
        $con->query("DELETE FROM donors WHERE id = $id");
    } elseif ($_GET['action'] === 'edit') {
        $edit_id = $id;
        $edit_row = $con->query("SELECT * FROM donors WHERE id = $id")->fetch_assoc();
    }
    if ($_GET['action'] !== 'edit') {
        header("Location: donors.php");
        exit;
    }
}

// Handle update action
if (isset($_POST['update_donor'])) {
    $id = intval($_POST['id']);
    $fullname = $_POST['fullname'];
    $dob = $_POST['dob'];
    $sex = $_POST['sex'];
    $bloodgroup = $_POST['bloodgroup'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $town = $_POST['town'];
    $state = $_POST['state'];
    $con->query("UPDATE donors SET fullname='$fullname', dob='$dob', sex='$sex', bloodgroup='$bloodgroup', mobile='$mobile', email='$email', town='$town', state='$state' WHERE id=$id");
    header("Location: donors.php");
    exit;
}

$result = $con->query("SELECT * FROM donors");
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
    padding: 4px 8px;
    border-radius: 4px;
    color: #fff;
    font-weight: bold;
    text-decoration: none;
    margin: 2px;
    transition: background 0.2s, transform 0.2s;
    box-shadow: 0 1px 2px #bbb;
    font-size: 16px;
    vertical-align: middle;
    min-width: 28px;
    min-height: 28px;
    width: 32px !important;
    height: 32px !important;
    text-align: center;
    line-height: 1;
}
.edit-form .action-btn {
    width: auto !important;
    height: auto !important;
    min-width: 80px;
    min-height: 36px;
    font-size: 18px;
    padding: 8px 20px;
    margin: 8px 8px 0 0;
    display: inline-block;
}
.action-btn i {
    margin: 0;
    font-size: 16px;
    background: none !important;
    border-radius: 0 !important;
    width: auto !important;
    height: auto !important;
    padding: 0 !important;
    color: #fff;
}
.action-edit { background: #527f63; }
.action-edit:hover { background: #388E3C; transform: scale(1.08); }
.action-delete { background: #bb0000; }
.action-delete:hover { background: #880000; transform: scale(1.08); }
.action-approve { background: #4CAF50; }
.action-approve:hover { background: #388E3C; transform: scale(1.08); }
.action-reject { background: #bb0000; }
.action-reject:hover { background: #880000; transform: scale(1.08); }
.edit-form { background: #fff; border-radius: 10px; box-shadow: 0 2px 8px #bbb; padding: 20px; margin-bottom: 20px; }
.edit-form input, .edit-form select { margin-bottom: 10px; width: 100%; padding: 6px; border-radius: 5px; border: 1px solid #ccc; }
</style>
</head>
<body>
<div class="col-12" style="height: 350px">
    <div id="comname">
        <i class="fa fa-balance-scale" aria-hidden="true"></i><br><br>BLOOD <b>DONATION</b>
    </div>
    <div style="width:100%;text-align:center;position:relative;z-index:11;top:120px;">
        <span class="info2" style="position:static;display:inline-block;left:auto;top:auto;margin-bottom:10px;">MANAGE DONORS</span>
    </div>
    <img class="myFrontPic col-12" src="../images/img23.jpg" style="height: 350px;">
</div>
<div class="col-12" style="overflow: auto; padding: 0 5% 0 5%;">
    <div class="col-12" style="text-align: left; padding: 2%; background-color: rgb(217, 219, 224);">
        <?php if (isset($edit_row)): ?>
        <form class="edit-form" method="post" action="donors.php">
            <h3>Edit Donor</h3>
            <input type="hidden" name="id" value="<?= $edit_row['id'] ?>">
            <label>Full Name</label>
            <input type="text" name="fullname" value="<?= htmlspecialchars($edit_row['fullname']) ?>" required>
            <label>Date of Birth</label>
            <input type="date" name="dob" value="<?= htmlspecialchars($edit_row['dob']) ?>" required>
            <label>Gender</label>
            <select name="sex" required>
                <option value="male" <?= $edit_row['sex']=='male'?'selected':'' ?>>Male</option>
                <option value="female" <?= $edit_row['sex']=='female'?'selected':'' ?>>Female</option>
                <option value="other" <?= $edit_row['sex']=='other'?'selected':'' ?>>Other</option>
            </select>
            <label>Blood Group</label>
            <input type="text" name="bloodgroup" value="<?= htmlspecialchars($edit_row['bloodgroup']) ?>" required>
            <label>Mobile</label>
            <input type="text" name="mobile" value="<?= htmlspecialchars($edit_row['mobile']) ?>" required>
            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($edit_row['email']) ?>" required>
            <label>Town</label>
            <input type="text" name="town" value="<?= htmlspecialchars($edit_row['town']) ?>">
            <label>State</label>
            <input type="text" name="state" value="<?= htmlspecialchars($edit_row['state']) ?>" required>
            <button class="action-btn action-edit" type="submit" name="update_donor"><i class="fa fa-save"></i>Save</button>
            <a class="action-btn action-delete" href="donors.php"><i class="fa fa-times"></i>Cancel</a>
        </form>
        <?php endif; ?>
        <table border="1" style="width:100%; background:white;">
            <tr>
                <th>ID</th><th>Username</th><th>Full Name</th><th>DOB</th><th>Gender</th><th>Blood Group</th><th>Mobile</th><th>Email</th><th>Town</th><th>State</th><th>Status</th><th>Actions</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= htmlspecialchars($row['fullname']) ?></td>
                <td><?= htmlspecialchars($row['dob']) ?></td>
                <td><?= htmlspecialchars($row['sex']) ?></td>
                <td><?= htmlspecialchars($row['bloodgroup']) ?></td>
                <td><?= htmlspecialchars($row['mobile']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['town']) ?></td>
                <td><?= htmlspecialchars($row['state']) ?></td>
                <td><?= isset($row['status']) ? htmlspecialchars($row['status']) : 'approved' ?></td>
                <td>
                    <a class="action-btn action-edit" title="Edit" href="donors.php?action=edit&id=<?= $row['id'] ?>"><i class="fa fa-pencil"></i></a>
                    <a class="action-btn action-delete" title="Delete" href="donors.php?action=delete&id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this donor?');"><i class="fa fa-trash"></i></a>
                    <?php if (!isset($row['status']) || $row['status'] !== 'approved'): ?>
                        <a class="action-btn action-approve" title="Approve" href="donors.php?action=approve&id=<?= $row['id'] ?>"><i class="fa fa-check"></i></a>
                    <?php endif; ?>
                    <?php if (isset($row['status']) && $row['status'] !== 'rejected'): ?>
                        <a class="action-btn action-reject" title="Reject" href="donors.php?action=reject&id=<?= $row['id'] ?>"><i class="fa fa-times"></i></a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <br>
        <a class="dashboard-btn" href="dashboard.php">Back to Dashboard</a>
    </div>
</div>
<div id="footer" class="col-12" style="margin: 0; padding: 0;overflow: auto;">
    <?php include "../footer.php"; ?>
</div>
</body>
</html> 