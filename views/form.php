<?php
include '../config/db_connect.php';
include '../include/session_check.php';

// Check if the user is logged in
check_login();

// Get user details
include '../include/applicant_session.php';

// $table_name = ($user_type === 'Applicant') ? 'Applicants' : 'Admins';

// Prepare and execute SQL query to retrieve user details
$sql = "SELECT * FROM applicants WHERE id_applicant = ?";
$stmt = $conn->prepare($sql);
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
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SPLM Membership Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/form.css">
    <style>
        .form-section {
            display: none;
        }
        .form-section.active {
            display: block;
        }
        .button-group {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?php include '../include/header.php' ?>
    <main class="container my-5">
        <h1 class="text-center mb-4">Membership Application Form</h1>
        <form id="applicationForm" action="../core/form.php" method="post" enctype="multipart/form-data" class="p-4 bg-white rounded shadow">
            <!-- Section 1: Personal Information -->
            <div class="form-section active">
                <div class="row">
                    <div class="col-md-4">
                        <label for="first_name" class="form-label">First Name:</label>
                        <input type="text" id="first_name" name="first_name" class="form-control" required>
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
                        <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($user_details["email"]); ?>" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label for="phone" class="form-label">Phone:</label>
                        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user_details["phone"]); ?>" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label for="national_id" class="form-label">National ID:</label>
                        <input type="text" id="national_id" name="national_id" value="<?php echo htmlspecialchars($user_details["national_id"]); ?>" class="form-control" required>
                    </div>
                </div>
                <div class="button-group">
                    <button type="button" class="btn btn-primary" onclick="nextSection()">Next</button>
                </div>
            </div>
            <!-- Section 2: Address and Education -->
            <div class="form-section">
                <div class="row">
                    <div class="col-md-4">
                        <label for="residential_city" class="form-label">Address:</label>
                        <input type="text" id="residential_city" name="residential_city" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label for="education_level" class="form-label">Education Level:</label>
                        <input type="text" id="education_level" name="education_level" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label for="profession" class="form-label">Profession:</label>
                        <input type="text" id="profession" name="profession" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label for="previous_party_affiliation" class="form-label">Previous Party Affiliation:</label>
                        <input type="text" id="previous_party_affiliation" name="previous_party_affiliation" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label for="date_of_join_splm" class="form-label">Date of Joining SPLM:</label>
                        <input type="date" id="date_of_join_splm" name="date_of_join_splm" class="form-control" required>
                    </div>
                </div>
                <div class="button-group">
                    <button type="button" class="btn btn-secondary" onclick="prevSection()">Previous</button>
                    <button type="button" class="btn btn-primary" onclick="nextSection()">Next</button>
                </div>
            </div>
            <!-- Section 3: Additional Information -->
            <div class="form-section">
                <div class="row">
                    <div class="col-md-4">
                        <label for="dob" class="form-label">Date of Birth:</label>
                        <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($user_details["dob"]); ?>" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label for="gender" class="form-label">Gender:</label>
                        <select id="gender" name="gender" class="form-control" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="marital_status" class="form-label">Marital Status:</label>
                        <select id="marital_status" name="marital_status" class="form-control" required>
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Divorced">Divorced</option>
                            <option value="Widowed">Widowed</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="statename" class="form-label">State:</label>
                        <input type="text" id="statename" name="statename" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label for="county" class="form-label">County:</label>
                        <input type="text" id="county" name="county" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label for="payam" class="form-label">Payam:</label>
                        <input type="text" id="payam" name="payam" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label for="boma" class="form-label">Boma:</label>
                        <input type="text" id="boma" name="boma" class="form-control" required>
                    </div>
                </div>
                <div class="button-group">
                    <button type="button" class="btn btn-secondary" onclick="prevSection()">Previous</button>
                    <button type="submit" class="btn btn-primary">Submit Application</button>
                </div>
            </div>
        </form>
    </main>
    <?php include '../include/footer.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentSection = 0;
        const sections = document.querySelectorAll('.form-section');

        function showSection(index) {
            sections.forEach((section, i) => {
                section.classList.toggle('active', i === index);
            });
        }

        function nextSection() {
            if (currentSection < sections.length - 1) {
                currentSection++;
                showSection(currentSection);
            }
        }

        function prevSection() {
            if (currentSection > 0) {
                currentSection--;
                showSection(currentSection);
            }
        }

        showSection(currentSection);
    </script>
</body>
</html>
