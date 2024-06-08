<?php
session_start();

include '../config/db_connect.php';

// Initialize $user_type with a default value
$user_type = '';

// Check if $user_type is set from a session or request
if (isset($_SESSION['user_type'])) {
    $user_type = $_SESSION['user_type'];
} elseif (isset($_POST['user_type'])) {
    $user_type = $_POST['user_type'];
}

// Debug: Print the value of $user_type
// echo "User type: $user_type";

// Now use $user_type safely
if ($user_type == 'Admin') {
    // Admin-specific code
} elseif ($user_type == 'Applicant') {
    // Applicant-specific code
} else {
    echo "Invalid user type.";
    exit;
}

$table_name = ($user_type === 'Applicant') ? 'applicants' : 'admins';

// Assuming $user_id is coming from session or request, ensure it's properly set
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : (isset($_POST['user_id']) ? $_POST['user_id'] : null);

// Check if $user_id is valid
if (!$user_id) {
    echo "Invalid user ID.";
    exit;
}

// Prepare and execute SQL query to retrieve user details
$sql = ($user_type === 'Applicant') ? "SELECT * FROM $table_name WHERE id_applicant = ?" : "SELECT * FROM $table_name WHERE id_admin = ?";
$stmt = $conn->prepare($sql);

// Check if prepare() was successful
if ($stmt === false) {
    die("Error preparing the statement: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user_details = $result->fetch_assoc();
} else {
    header("Location: login.php");
    exit();
}

$stmt->close();
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
    <?php include '../include/header.php'; ?>
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
                <!-- Include user type and user id hidden fields -->
                <input type="hidden" name="user_type" value="<?php echo $user_type; ?>">
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            </div>
            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </div>
        </form>
    </main>
    <?php include '../include/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>