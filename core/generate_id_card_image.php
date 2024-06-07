<?php
function generateMemberIDCard($user_id, $first_name, $middle_name, $surname, $gender, $dob, $national_id, $residential_city, $statename, $county, $payam, $boma, $date_of_join_splm) {
    // Create an image
    $width = 400;
    $height = 250;
    $image = imagecreatetruecolor($width, $height);

    // Colors
    $background_color = imagecolorallocate($image, 255, 255, 255);
    $text_color = imagecolorallocate($image, 0, 0, 0);
    $highlight_color = imagecolorallocate($image, 0, 102, 204);

    // Fill background
    imagefilledrectangle($image, 0, 0, $width, $height, $background_color);

    // Set the path to your font
    $font_path = '../assets/fonts/arial.ttf';

    // Add text to image
    $y = 20;
    $line_height = 20;
    imagettftext($image, 12, 0, 10, $y, $text_color, $font_path, "First Name: $first_name");
    $y += $line_height;
    imagettftext($image, 12, 0, 10, $y, $text_color, $font_path, "Middle Name: $middle_name");
    $y += $line_height;
    imagettftext($image, 12, 0, 10, $y, $text_color, $font_path, "Surname: $surname");
    $y += $line_height;
    imagettftext($image, 12, 0, 10, $y, $text_color, $font_path, "Gender: $gender");
    $y += $line_height;
    imagettftext($image, 12, 0, 10, $y, $text_color, $font_path, "DOB: $dob");
    $y += $line_height;
    imagettftext($image, 12, 0, 10, $y, $text_color, $font_path, "National ID: $national_id");
    $y += $line_height;
    imagettftext($image, 12, 0, 10, $y, $text_color, $font_path, "Residential City: $residential_city");
    $y += $line_height;
    imagettftext($image, 12, 0, 10, $y, $text_color, $font_path, "State: $statename");
    $y += $line_height;
    imagettftext($image, 12, 0, 10, $y, $text_color, $font_path, "County: $county");
    $y += $line_height;
    imagettftext($image, 12, 0, 10, $y, $text_color, $font_path, "Payam: $payam");
    $y += $line_height;
    imagettftext($image, 12, 0, 10, $y, $text_color, $font_path, "Boma: $boma");
    $y += $line_height;
    imagettftext($image, 12, 0, 10, $y, $text_color, $font_path, "Date of Join SPLM: $date_of_join_splm");
    $y += $line_height;
    $issue_date = date('Y-m-d');
    $expiry_date = date('Y-m-d', strtotime('+1 year'));
    imagettftext($image, 12, 0, 10, $y, $highlight_color, $font_path, "Issue Date: $issue_date");
    $y += $line_height;
    imagettftext($image, 12, 0, 10, $y, $highlight_color, $font_path, "Expiry Date: $expiry_date");

    // Save the image
    $output_path = "../id_cards/$national_id.png";
    imagepng($image, $output_path);

    // Clean up
    imagedestroy($image);

    return $output_path;
}
?>
