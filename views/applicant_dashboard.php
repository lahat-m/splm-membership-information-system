<?php
include '../config/db_connect.php';
include '../include/session_check.php';

// Check if the user is logged in and is an applicant
check_login('Applicant');

// Get applicant details from session
include '../include/applicant_session.php';

// Fetch application status
$query = "SELECT application_status FROM applications WHERE id_application = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($application_status);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Applicant Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/applicant_dashboard.css">
</head>
<body>
<?php include '../include/header.php' ?>
    <main class="container mt-3">
        <div class="dashboard-header">
            <h1 class="display-4">Welcome to Your Dashboard</h1>
            <p class="lead">Hello, <?php echo htmlspecialchars($username); ?>!</p>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Application Information</h5>
                        <p class="card-text"><strong>User ID:</strong> <?php echo htmlspecialchars($user_id); ?></p>
                        <p class="card-text"><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                        <p class="card-text"><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
                        <hr>
                        <?php if ($application_status): ?>
                            <p class="card-text">
                                Your application status is:
                                <span id="application_status" class="badge bg-info status-badge">
                                    <?php echo htmlspecialchars($application_status); ?>
                                </span>
                            </p>
                        <?php else: ?>
                            <a href="../views/form.php" class="btn btn-custom">Make Application</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include '../include/footer.php' ?>
</body>
</html>
