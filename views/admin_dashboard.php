<?php
session_start(); // Start the session

// Check if the admin is logged in
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'Admin') {
    header('Location: ../views/login.php'); // Redirect to login page if not logged in
    exit;
}

include '../config/db_connect.php';

// Fetch applications from the database
$sql = "SELECT id_application, surname, national_id, email, application_date, application_status FROM applications";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link rel="stylesheet" href="../assets/css/admin_dashboard.css">
</head>
<body>
<?php include 'header.php'; ?>
<div class="container mt-5">
    <h2>Applications</h2>
    <div class="row g-4 mb-6">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='col-md-6 mb-6'>";
                echo "<div class='card shadow-sm'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'><strong>Applicant Name:</strong> " . $row["surname"] . "</h5>";
                echo "<p class='card-text'><strong>National Id:</strong> " . $row["national_id"] . "</p>";
                echo "<p class='card-text'><strong>Email:</strong> " . $row["email"] . "</p>";
                echo "<div class='d-flex mb-5'>";
                echo "<button class='btn btn-primary btn-sm me-2' onclick='viewApplication(" . $row["id_application"] . ")'>View</button>";
                echo "<a href='../core/download_application.php?id=" . $row["id_application"] . "' class='btn btn-success btn-sm me-2'>Download</a>";
                if ($row["application_status"] == 'Pending') {
                    echo "<a href='../core/application_status.php?id=" . $row["id_application"] . "&application_status=Approved' class='btn btn-warning btn-sm me-2 mt-5'>Approve</a>";
                    echo "<a href='../core/application_status.php?id=" . $row["id_application"] . "&application_status=Rejected' class='btn btn-danger btn-sm me-2 mt-5'>Reject</a>";
                } else {
                    echo "<span class='badge bg-secondary'>" . $row["application_status"] . "</span>";
                }
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<div class='col-12'><p class='text-center'>No applications found</p></div>";
        }
        ?>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="applicationModal" tabindex="-1" aria-labelledby="applicationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="applicationModalLabel">Application Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="applicationDetails">
                <!-- Application details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    function viewApplication(id_application) {
        $.ajax({
            url: '../views/view_application.php',
            type: 'POST',
            data: { id_application: id_application },
            success: function(response) {
                $('#applicationDetails').html(response);
                $('#applicationModal').modal('show');
            }
        });
    }
</script>
</body>
</html>

<?php
$conn->close();
?>
