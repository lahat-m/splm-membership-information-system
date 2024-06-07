<?php
include '../config/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_application'])) {
    $id_application = $_POST['id_application'];

    $sql = "SELECT * FROM applications WHERE id_application = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id_application);
        $stmt->execute();
        $result = $stmt->get_result();
        $application_data = $result->fetch_assoc();
        $stmt->close();
    }

    if ($application_data) {
        echo '<div class="container mb-5">';
        echo '<div class="text-center mb-5">';
        echo '<img src="../assets/images/logo.jpg" alt="Logo" class="img-fluid" style="max-width: 150px;">';
        echo '</div>';
        echo '<h1 class="text-center">Applicant Form</h1>';
        echo '<div class="table-responsive">';
        echo '<table class="table table-bordered table-striped">';
        echo '<thead>';
        echo '<tr><th colspan="2" class="section-title">Personal Details</th></tr>';
        echo '</thead>';
        echo '<tbody>';
        foreach ($application_data as $key => $value) {
            if (!in_array($key, ['id_application', 'id_applicant', 'id_admin'])) {
                echo '<tr><td>' . ucwords(str_replace('_', ' ', $key)) . '</td><td>' . htmlspecialchars($value) . '</td></tr>';
            }
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
        echo '</div>';
    } else {
        echo '<p class="no-data">No application data found.</p>';
    }

    $conn->close();
}
?>
