<?php
// Start session
session_start();

// Include database connection
include '../config//db_connect.php';


// Check if user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page
    header("Location: login.php");
    exit;
}
// Get the session user ID and user type
$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'];

// Initialize variables to store user details
$user_details = array();

// Determine which table to query based on user type
if ($user_type === 'Applicant') {
    $table_name = 'Applicants';
} elseif ($user_type === 'Admin') {
    $table_name = 'Admins';
}

// Prepare and execute SQL query to retrieve user details
$sql = "SELECT * FROM $table_name WHERE {$user_type}_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch user details
if ($result->num_rows > 0) {
    $user_details = $result->fetch_assoc();
} else {
    // User not found in the respective table
    // Redirect to login page
    header("Location: login.php");
    exit;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile </title>
    <link rel="shortcut icon" href="assets/img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css"> 
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <link rel="stylesheet" href="assets/css/profile.css">
</head>
<body>
<header>
        <div id="home">
            <img src="assets/img/logo.png" alt="Logo">
        </div>
        <button id="darkModeToggle" onclick="toggleDarkMode()">
         <img class="darkmodeimg" src="assets/img/darkmode.png" alt="">
        </button>
        <a href="logout.php" id="logout-link" ><img class="logout" src="assets/img/logout.png" alt="Logout"></a>
        <h1>NMS</h1>
    </header>
    <header class="top-header">
    <div class="user-details">
        <p>Welcome: <?php echo $user_details[$user_type . 'first_name'];?>
        | User ID: <?php echo $user_details[$user_type . 'applicant_id']; ?>
        | User_type: <?php echo $user_type ; ?></p>
    </div>
    <nav>
                <ul class="nav-links">
                    <li><a href="dashboard.php">Home</a></li>
                    <li><a href="profilepage.php">Update Profile</a></li>
                    <?php if($_SESSION['user_type'] == 'Admin'): ?>
                    <li><a href="viewrooms.php">Book Room</a></li>
                    <?php endif; ?></li>
                    <?php if($_SESSION['user_type'] == 'Applicant'): ?>
                    <li><a href="housekeepingservicespage.php">Request Housekeeping Service</a></li>
                    <?php endif; ?></li>
                </ul>
    </nav>
    </header>

    <main>
        <div class="container">
            <form action="updateprofile.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                <label for="user_typefirst_name">First Name:</label>
                <input type="text" id="user_typefirst_name" name="user_typefirst_name" value="<?php echo $user_details["{$user_type}first_name"]; ?>">

                <label for="user_type_lastname">Last Name:</label>
                <input type="text" id="user_type_lastname" name="user_type_lastname" value="<?php echo $user_details["{$user_type}_lastname"]; ?>">

                <label for="user_type_email">Email:</label>
                <input type="email" id="user_type_email" name="user_type_email" value="<?php echo $user_details["{$user_type}_email"]; ?>" readonly>

                <label for="user_type_nationalID">National ID:</label>
                <input type="text" id="user_type_nationalID" name="user_type_nationalID" value="<?php echo $user_details["{$user_type}_nationalID"]; ?>">

                <label for="user_type_gender">Gender:</label>
                <select id="user_type_gender" name="user_type_gender">
                    <option value="male" <?php if ($user_details["{$user_type}_gender"] === 'male') echo 'selected'; ?>>Male</option>
                    <option value="female" <?php if ($user_details["{$user_type}_gender"] === 'female') echo 'selected'; ?>>Female</option>
                </select>

                <label for="date_of_birth">Date of Birth:</label>
                <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo $user_details["date_of_birth"]; ?>">

                <label for="user_type_phonenumber">Phone Number:</label>
                <input type="text" id="user_type_phonenumber" name="user_type_phonenumber" value="<?php echo $user_details["{$user_type}_phonenumber"]; ?>">
                <div class="buttons">
                    <button type="submit" name="update_profile">Update</button>
                    <button type="reset">Clear</button>
                </div>
            </form>
        </div>
    </main>
    <script>
    // Check for success message
    <?php if (isset($_SESSION['success_message'])): ?>
        alert("<?php echo $_SESSION['success_message']; ?>");
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    // Check for error messages
    <?php if (isset($_SESSION['error_messages']) && !empty($_SESSION['error_messages'])): ?>
        <?php foreach ($_SESSION['error_messages'] as $error): ?>
            alert("<?php echo $error; ?>");
        <?php endforeach; ?>
        <?php unset($_SESSION['error_messages']); ?>
    <?php endif; ?>
</script>
    <script src="assets/js/dashboard.js"></script>
    <script src="assets/js/script.js"></script> 
</body>
</html>