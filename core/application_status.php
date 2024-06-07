<?php
include '../config/db_connect.php';

if (isset($_GET['id']) && isset($_GET['application_status'])) {
    $id = intval($_GET['id']);
    $application_status = $_GET['application_status'];

    $sql = "UPDATE applications SET application_status=? WHERE id_application=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $application_status, $id);

    if ($stmt->execute()) {
        header("Location: ../views/admin_dashboard.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
