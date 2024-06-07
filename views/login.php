<?php
session_start();
include '../config/db_connect.php';

if (isset($_SESSION['login_error'])) {
    $error = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/login.css">

</head>

<body>
<?php
    include 'header.php'
?>

    <div class="container mt-5">
        <h1>Login</h1>
        <form class="login-form row-mb-3" action="../core/login.php" method="POST">
            <div class="mb-2">
                <label for="login_identifier" class="form-label">Email or Username</label>
                <input type="text" class="form-control" id="login_identifier" name="login_identifier" required>
            </div>
            <div class="mb-2">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            <small>
                <a href="register.php">Doesn't Have Account? Register</a>
            </small>
            <?php if (isset($error)) { ?>
            <div class="text-danger">
                <?php echo $error; ?>
            </div>
            <?php } ?>
        </form>
    </div>

</body>
<?php
    include 'footer.php'
    ?>

</html>