<?php
include '../fpdf/fpdf.php';
include '../config/db_connect.php';

if (isset($_GET['id'])) {
    $id_application = $_GET['id'];

    $sql = "SELECT * FROM applications WHERE id_application = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id_application);
        $stmt->execute();
        $result = $stmt->get_result();
        $application_data = $result->fetch_assoc();
        $stmt->close();
    }

    if ($application_data) {
        class PDF extends FPDF
        {
            function Header()
            {
                $this->SetFont('Arial', 'B', 12);
                $this->Cell(0, 10, 'Application Details', 0, 1, 'C');
                $this->Ln(10);
            }

            function Footer()
            {
                $this->SetY(-15);
                $this->SetFont('Arial', 'I', 8);
                $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
            }

            function ApplicationDetails($data)
            {
                foreach ($data as $key => $value) {
                    if (!in_array($key, ['id_application', 'id_applicant', 'id_admin'])) {
                        $this->SetFont('Arial', '', 12);
                        $this->Cell(50, 10, ucwords(str_replace('_', ' ', $key)) . ':', 0, 0);
                        $this->SetFont('Arial', 'B', 12);
                        $this->Cell(0, 10, $value, 0, 1);
                    }
                }
            }
        }

        $pdf = new PDF();
        $pdf->AddPage();
        $pdf->ApplicationDetails($application_data);
        $pdf->Output('D', 'application_' . $id_application . '.pdf');
    } else {
        echo "No application data found.";
    }
    $conn->close();
}
?>
