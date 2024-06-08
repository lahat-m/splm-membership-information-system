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
<?php include '../include/header.php' ?>
<main>
    <div class="container login-container">
        <div class="row">
            <div class="col-md-7 d-none d-md-flex justify-content-center align-items-center">
                <img src="../assets/images/login-image.svg" alt="Login Image" class="login-image" width="400px">
            </div>
            <div class="col-md-5 d-flex flex-column justify-content-center align-items-center">
                <h1>
                    <img src="../assets/images/login.svg" alt="" width="50px">
                    Login</h1>
                <form class="login-form outline" action="../core/login.php" method="POST">
                    <div class="mb-3">
                        <label for="login_identifier" class="form-label">Email or Username</label>
                        <input type="text" class="form-control" id="login_identifier" name="login_identifier" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                    <small class="d-block mt-2">
                        <a href="register.php">Don't Have an Account? Register</a>
                    </small>
                    <?php if (isset($error)) { ?>
                    <div class="text-danger mt-2">
                        <?php echo $error; ?>
                    </div>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
</main>
<?php include '../include/footer.php' ?>
</body>
</html>