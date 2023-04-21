<?php
session_start();
require('components/database.php');
$current_page = 'login';

$error_message = '';
$valid = false;

if (isset($_POST['submit'])) {
    $valid = true;
    if ($_POST['mode'] == 'register') {
        if (!isset($_POST['email'])) {
            $valid = false;
            $error_message = 'Email is required\n';
        }
        // check whether password is set
        if (!isset($_POST['password'])) {
            $valid = false;
            $error_message = 'Password is required\n';
        }
        // check whether email is valid
        if ($valid) {
            $email = $_POST['email'];
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            $email = filter_var($email, FILTER_VALIDATE_EMAIL);
            if ($email === false) {
                $valid = false;
                $error_message = 'Invalid email\n';
            }
        }
        // check whether email already exists
        if ($valid) {
            $sql = "SELECT * FROM user WHERE username = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':email', $email);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $valid = false;
                $error_message = 'Email already exists\n';
            }
        }
        // add user to database
        if ($valid) {
            $password = $_POST['password'];
            $password = hash('sha256', $password);
            $sql = "INSERT INTO user (username, password) VALUES (:email, :password)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':password', $password);
            $stmt->execute();
        }
        // check whether user was added to database
        if ($valid) {
            $sql = "SELECT * FROM user WHERE username = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':email', $email);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$row) {
                $valid = false;
                $error_message = 'User not registered\n';
            }
        }
    } else if ($_POST['mode'] == 'login') {
        if (!isset($_POST['email']) || !isset($_POST['password'])) {
            $valid = false;
            $error_message = 'Email and password are required\n';
        }
        // check whether record exists
        if ($valid) {
            $sql = "SELECT * FROM user WHERE username = :email AND password = :password AND delete_datetime IS NULL";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':email', $_POST['email']);
            $stmt->bindValue(':password', hash('sha256', $_POST['password']));
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$row) {
                $valid = false;
                $error_message = 'Invalid email or password\n';
            }
            // generate session
            if ($valid) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['is_admin'] = $row['is_admin'] == 1 ? true : false;
                header('Location: index.php');
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
    <title>TECHLIVE | Online Shop Smart Device</title>
</head>

<body>
    <?php include_once('components/header.php'); ?>

    <section id="login" class="section-p1">
        <div class="account-page">
            <div class="container">
                <div class="row">
                    <div class="col-2">
                        <img src="../image/illustration/octopus.png" width="100%">
                    </div>

                    <div class="col-2">
                        <div class="form-container">
                            <div class="form-btn">
                                <span onclick="login()">Login</span>
                                <span onclick="register()">Register</span>
                                <hr id="Indicator">
                            </div>

                            <form id="LoginForm" method="POST" action="login.php">
                                <input type="hidden" name="mode" value="login">
                                <input type="text" name="email" placeholder="Email">
                                <input type="password" name="password" placeholder="Password">
                                <input type="submit" class="btn" name="submit" value="Login" />
                                <a href="#">Forgot Password</a>
                            </form>

                            <form id="RegForm" class="form-hidden" method="POST" action="login.php" onsubmit="return checkRegister(); ">
                                <input type="hidden" name="mode" value="register">
                                <!-- <input type="text" placeholder="Username"> -->
                                <input type="email" name="email" placeholder="Email" required />
                                <input type="password" name="password" id="password" placeholder="Password" required />
                                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required />
                                <input type="submit" class="btn" name="submit" value="Register" />
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</body>
<script src="javascript/login_script.js"></script>
<script>
    <?php if ($error_message != '') { ?>
        alert('<?=$error_message?>');
    <?php } ?>
    <?php if ($valid) { ?>
        alert('User registered successfully');
    <?php } ?>
</script>
</html>