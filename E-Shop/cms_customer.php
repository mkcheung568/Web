<?php
session_start();
require('components/database.php');
$current_page = 'customer';
$error_message = '';
$valid = true;

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: index.php');
    exit();
}

if (isset($_POST['submit'])) {
    // check if username and password is empty
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $valid = false;
        $error_message = 'Username and password cannot be empty';
    }

    // check if username exists
    if ($valid) {
        $username_sql = "SELECT * FROM user WHERE username = :username";
        $username_stmt = $pdo->prepare($username_sql);
        $username_stmt->bindValue(':username', $_POST['username']);
        $username_stmt->execute();
        $username_row = $username_stmt->fetch(PDO::FETCH_ASSOC);
        if ($username_row) {
            $valid = false;
            $error_message = 'Username already exists';
        }
    }

    // insert
    if ($valid) {
        $sql = "INSERT INTO user (username, password, is_admin) VALUES (:username, :password, :is_admin)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':username', $_POST['username']);
        $stmt->bindValue(':password', hash('sha256', $_POST['password']));
        $stmt->bindValue(':is_admin', isset($_POST['is_admin']) ? 1 : 0);
        $stmt->execute();

        header('Location: cms_customer.php?mode=add');
    }
}

$user_sql = "SELECT * FROM user";
$user_stmt = $pdo->prepare($user_sql);
$user_stmt->execute();
$users = $user_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cms_customer_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
    <title>TECHLIVE | Online Shop Smart Device</title>
</head>

<body>
    <?php include_once('components/cms_header.php'); ?>

    <section id="page-header">
        <h2>Content Management System</h2>
        <h4>User Management</h4>
    </section>

    <section id="customer" class="section-p1">
        <table id="customer-table">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Admin?</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?= $user['username'] ?></td>
                        <td><?= $user['is_admin'] ? 'Yes' : 'No' ?></td>
                        <td><?= $user['delete_datetime'] == NULL ? 'Activated' : 'Deactivated' ?></td>
                        <td>
                            <?php if ($user['id'] != $_SESSION['user_id']) { ?>
                                <a class="action-link" href="cms_change_admin.php?id=<?= $user['id'] ?>" onclick="return confirm('Are you sure to <?= $user['is_admin'] ? 'demote' : 'promote' ?> <?= $user['username'] ?>?');"><?= $user['is_admin'] ? 'Demote from' : 'Promote to' ?> Admin</a> <br>
                                <a class="action-link" href="cms_delete_customer.php?id=<?= $user['id'] ?>" onclick="return confirm('Are you sure to <?= $user['delete_datetime'] == NULL ? 'deactivate' : 'activate' ?> <?= $user['username'] ?>?');"><?= $user['delete_datetime'] == NULL ? 'Deactivate' : 'Activate' ?> User</a>
                            <?php } else echo "N/A"; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button id="add-customer">Add user</button>
    </section>


    <!-- Add the form overlay and form elements -->
    <div id="customer-form-container">
        <form id="customer-form" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" onsubmit="return checkRegister();">
            <h3>Add Customer</h3>
            <label for="username">Username / Email:</label>
            <input type="text" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <label for="is_admin">Admin?</label>
            <input type="checkbox" id="is_admin" name="is_admin" value="1">
            <input type="submit" name="submit" value="Add" />
            <button type="button" id="cancel">Cancel</button>
        </form>
    </div>

    <script src="javascript/cms_customer_script.js"></script>
</body>

<script>
    <?php
    if (isset($_GET['mode'])) {
        if ($_GET['mode'] == 'admin') {
    ?>
            alert('Admin status changed successfully!');
        <?php
        } else if ($_GET['mode'] == 'delete') {
        ?>
            alert('User status changed successfully!');
        <?php
        } else if ($_GET['mode'] == 'add') {
        ?>
            alert('User added successfully!');
    <?php
        }
    }
    ?>
</script>

</html>