<?php
session_start();
if (isset($_SESSION['register_error'])) {
    $error = $_SESSION['register_error'];
    unset($_SESSION['register_error']);
}

// Check if user_type is already logged in
if (isset($_SESSION['user_type'])) {
    // Check the user_type type and redirect to the appropriate dashboard
    if ($_SESSION['user_type'] === 'Admin') {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: applicant_dashboard.php");
    }
    exit();
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/register.css">
</head>

<body>
<?php
    include 'header.php'
    ?>
    <div class="container">
        <h1>Sign Up</h1>
        <form action="../core/register.php" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" required>
            </div>
            <div class="mb-3">
                <label for="middle_name" class="form-label">Middle Name</label>
                <input type="text" class="form-control" id="middle_name" name="middle_name">
            </div>
            <div class="mb-3">
                <label for="surname" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="surname" name="surname" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="date" class="form-control" id="dob" name="dob" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="mb-3">
                <label for="national_id" class="form-label">ID Number</label>
                <input type="text" class="form-control" id="national_id" name="national_id" required>
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-select" id="gender" name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
            </div>
            <div class="mb-3">
                <label for="user_type" class="form-label">Register As</label>
                <select class="form-select" id="user_type" name="user_type" required>
                    <option value="">Select User_type</option>
                    <option value="Applicant">Applicant</option>
                    <option value="Admin">Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="register">Sign Up</button>
            <small>
            <a href="login.php">Alreay Have Account? Login</a>
        </small>
            <?php if (isset($error)) { ?>
            <div class="text-danger mt-3">
                <?php echo $error; ?>
            </div>
            <?php } ?>
        </form>
    </div>

    <?php
    include 'footer.php'
    ?>
</body>
</html>