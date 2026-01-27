<?php

session_start();
    if (!isset($_SESSION['user'])){
        $_SESSION['error'] = "Please login!";
        header("location: index.php");
    }


require 'vendor/autoload.php';

use Dompdf\Adapter\GD;
use Dompdf\Dompdf;
use Dompdf\Options;

// 1. CONFIGURATION
// Replace this with your actual Sheetbest API URL
$api_url = 'https://api.sheetbest.com/sheets/eb063465-9a3d-49c9-9922-76fde01f3c24';

// 2. FETCH DATA FROM SHEETBEST
// We use file_get_contents for simplicity, but cURL is robust for production
$json_data = file_get_contents($api_url);
$data = json_decode($json_data, true); // Decode JSON into an associative array

$fontPath = __DIR__ . '/THSarabunNew.ttf';

// Verify the font exists before running
if (!file_exists($fontPath)) {
    die("Error: The file 'font.ttf' was not found in " . __DIR__);
}

if (!$data) {
    die('Error fetching data from Sheetbest.');
}


// 3. BUILD THE HTML STRUCTURE
// Dompdf works best with Tables for tabular data. Avoid Flexbox/Grid.
$html = '
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @font-face {
            font-family: "ThaiFont";
            src: url("' . $fontPath . '") format("truetype");
            font-weight: normal;
            font-style: normal;
        }

        body {
            font-family: "ThaiFont", sans-serif;
            font-size: 20px;
            line-height: 1.4;
        }
        h1 { text-align: center; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; color: #333; }
        tr:nth-child(even) { background-color: #f9f9f9; }
    </style>
</head>
<body>
    <h1>Data Report</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Machine_ID</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>';

// 4. LOOP THROUGH DATA AND CREATE ROWS
foreach ($data as $row) {
    // Ensure you use the exact keys as they appear in your JSON (Google Sheet headers)
    $id = isset($row['id']) ? $row['id'] : '-';
    $Date = isset($row['Date']) ? $row['Date'] : '-';
    $Machine_ID = isset($row['Machine_ID']) ? $row['Machine_ID'] : '-';
    $Data = isset($row['Data']) ? $row['Data'] : '-';

    if ($id == 0) {continue;}
    
    $html .= "<tr>
                <td>{$id}</td>
                <td>{$Date}</td>
                <td>{$Machine_ID}</td>
                <td>{$Data}</td>
              </tr>";
}

$html .= '
        </tbody>
    </table>
    <p style="font-size: 18px; color: #777; margin-top: 20px;">Generated on ' . date('Y-m-d H:i:s') . '</p>
</body>
</html>';

// 5. INITIALIZE DOMPDF
$options = new Options();
$options->set('isRemoteEnabled', true); // Enable this if you have images in your HTML
$options->set('chroot', __DIR__);
$dompdf = new Dompdf($options);

// 6. LOAD HTML AND RENDER
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// 7. OUTPUT THE PDF
// "Attachment" => false opens it in the browser
// "Attachment" => true downloads it immediately
$dompdf->stream("Data.pdf", ["Attachment" => false]);

?>