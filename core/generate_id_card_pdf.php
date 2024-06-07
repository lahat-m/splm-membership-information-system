<?php
require('../fpdf/fpdf.php');

function generateMemberIDCardPDF($user_id, $first_name, $middle_name, $surname, $gender, $dob, $national_id, $residential_city, $statename, $county, $payam, $boma, $date_of_join_splm) {
    $issue_date = date('Y-m-d');
    $expiry_date = date('Y-m-d', strtotime('+1 year'));

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);

    $pdf->Cell(0, 10, "Member ID Card", 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);

    $pdf->Cell(0, 10, "First Name: $first_name", 0, 1);
    $pdf->Cell(0, 10, "Middle Name: $middle_name", 0, 1);
    $pdf->Cell(0, 10, "Surname: $surname", 0, 1);
    $pdf->Cell(0, 10, "Gender: $gender", 0, 1);
    $pdf->Cell(0, 10, "Date of Birth: $dob", 0, 1);
    $pdf->Cell(0, 10, "National ID: $national_id", 0, 1);
    $pdf->Cell(0, 10, "Residential City: $residential_city", 0, 1);
    $pdf->Cell(0, 10, "State: $statename", 0, 1);
    $pdf->Cell(0, 10, "County: $county", 0, 1);
    $pdf->Cell(0, 10, "Payam: $payam", 0, 1);
    $pdf->Cell(0, 10, "Boma: $boma", 0, 1);
    $pdf->Cell(0, 10, "Date of Join SPLM: $date_of_join_splm", 0, 1);
    $pdf->Cell(0, 10, "Issue Date: $issue_date", 0, 1);
    $pdf->Cell(0, 10, "Expiry Date: $expiry_date", 0, 1);

    $output_path = "../id_cards/$national_id.pdf";
    $pdf->Output('F', $output_path);

    return $output_path;
}
?>
