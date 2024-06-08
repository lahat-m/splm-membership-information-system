<?php
session_start();

// Redirect user if already logged in
if (isset($_SESSION['user_type'])) {
    $redirect_url = $_SESSION['user_type'] === 'Admin' ? 'admin_dashboard.php' : 'applicant_dashboard.php';
    header("Location: $redirect_url");
    exit();
}

// Handle registration errors
$error = isset($_SESSION['register_error']) ? $_SESSION['register_error'] : '';
unset($_SESSION['register_error']);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/register.css">
    <style>
        .pagination-step {
            display: none;
        }
        .pagination-step.active {
            display: block;
        }
    </style>
</head>
<body>
    <?php include '../include/header.php'; ?>

    <div class="container register-container">
        <div class="row">
            <div class="col-md-7 d-none d-md-flex justify-content-center align-items-center">
                <img src="../assets/images/login-image.svg" alt="Register Image" class="register-image" width="400px">
            </div>
            <div class="col-md-5 d-flex flex-column justify-content-center align-items-center">
                <h1>
                    <img src="../assets/images/register.svg" alt="" width="50px">
                    Sign Up
                </h1>
                <form class="register-form outline" id="registerForm" action="../core/register.php" method="post">
                    <div class="pagination-step active" id="step-1">
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
                        <button type="button" class="btn btn-primary w-100" onclick="nextStep()">Next</button>
                    </div>

                    <div class="pagination-step" id="step-2">
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
                        <button type="button" class="btn btn-secondary w-100 mb-2" onclick="prevStep()">Back</button>
                        <button type="button" class="btn btn-primary w-100" onclick="nextStep()">Next</button>
                    </div>

                    <div class="pagination-step" id="step-3">
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
                                <option value="">Select User Type</option>
                                <option value="Applicant">Applicant</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                        <button type="button" class="btn btn-secondary w-100 mb-2" onclick="prevStep()">Back</button>
                        <button type="submit" class="btn btn-primary w-100" name="register">Sign Up</button>
                    </div>

                    <small class="d-block mt-2">
                        <a href="register.php">Already Have Account? register</a>
                    </small>
                    <?php if ($error): ?>
                    <div class="text-danger mt-2">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>

    <?php include '../include/footer.php'; ?>

    <script>
        let currentStep = 1;

        function nextStep() {
            document.getElementById(`step-${currentStep}`).classList.remove('active');
            currentStep++;
            document.getElementById(`step-${currentStep}`).classList.add('active');
        }

        function prevStep() {
            document.getElementById(`step-${currentStep}`).classList.remove('active');
            currentStep--;
            document.getElementById(`step-${currentStep}`).classList.add('active');
        }
    </script>
</body>
</html>
