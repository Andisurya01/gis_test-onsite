<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the form data

    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $amount = isset($_POST['amount']) ? $_POST['amount'] : '';
    $tanggal = date("Y-m-d");
    $waktu = date("H:i:s");
    $date = "$tanggal $waktu";

    $data = array(
        array($type, $amount, $date)
    );

    $file = fopen('file.csv', 'a');
    foreach ($data as $row) {
        fputcsv($file, $row);
    }
    fclose($file);

    // Redirect to avoid form resubmission
    header('Location: index.php');
    exit();
}
?>
