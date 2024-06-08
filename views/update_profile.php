<?php
include '../config/db_connect.php';
// Ensure session variables are set
include '../include/session_check.php';


// Get session variables
include '../include/admin_session.php';
include '../include/admin_session.php';

// Determine the table name based on user type
$table_name = '';
if ($user_type === 'Applicant') {
    $table_name = 'Applicants';
} elseif ($user_type === 'Admin') {
    $table_name = 'Admins';
} else {
    // Handle unexpected user type
    die('Invalid user type.');
}

// Prepare and execute SQL query to retrieve user details
$sql = "SELECT * FROM $table_name WHERE id_applicant = ?";
$stmt = $conn->prepare($sql);

$sql = "SELECT * FROM $table_name WHERE id_admin = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user_details = $result->fetch_assoc();
} else {
    // User not found in the respective table
    header("Location: login.php");
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/form.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main class="container my-5">
        <h1 class="text-center mb-4">Update Profile</h1>
        <form action="../core/update_profile.php" method="post" enctype="multipart/form-data" class="p-4 bg-white rounded shadow">
            <div class="row">
                <div class="col-md-4">
                    <label for="first_name" class="form-label">First Name:</label>
                    <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user_details["first_name"]); ?>" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label for="middle_name" class="form-label">Middle Name:</label>
                    <input type="text" id="middle_name" name="middle_name" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="surname" class="form-label">Last Name:</label>
                    <input type="text" id="surname" name="surname" value="<?php echo htmlspecialchars($user_details["username"]); ?>" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user_details["email"]); ?>" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label for="phone" class="form-label">Phone:</label>
                    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user_details["phone"]); ?>" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label for="national_id" class="form-label">National ID:</label>
                    <input type="text" id="national_id" name="national_id" value="<?php echo htmlspecialchars($user_details["national_id"]); ?>" class="form-control" required>
                </div>
                <!-- Add other fields as necessary -->
            </div>
            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </div>
        </form>
    </main>
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
