<?php


$type = array_key_exists('type', $_POST) ? $_POST['type'] : '';
$amount = array_key_exists('type', $_POST) ? $_POST['amount'] : '';

// // Validasi data jika diperlukan
$balane = 0;
if ($type == 'income') {
    $balace += $amount;
} elseif ($type == 'expense'){
    $balance -= $amount;
}
// // Data yang ingin ditulis ke file CSV
$data = array(
    array($type, $amount)
);

// // Buka file CSV untuk ditulis
$file = fopen('file.csv', 'a'); // 'a' untuk mode append

// // Tulis data ke file CSV
foreach ($data as $row) {
    fputcsv($file, $row);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <section>
        <h1>Advnace Financial System</h1>
        <h2>Balance <?php echo $balane ?></h2>
        <form action="" method="post">
            <div class=" ">
                <p>Transaction Type : </p>
                <select name="type" required>
                    <option value="income">income</option>
                    <option value="expense">expense</option>
                </select>
            </div>
            <div class="flex ">
                <p>Amount : </p>
                <input type="number" name="amount"></input>
            </div>
            <div>
                <input type="submit"></input>
            </div>
        </form>
        <div>
                <?php
                $fileRead = fopen('file.csv', 'r');

                // Check if the file was successfully opened
                if ($fileRead) {
                    // Output the table structure
                    echo '<table>';
                    echo '<tr>';
                    echo '<th>Type</th>';
                    echo '<th>Amount</th>';
                    echo '<th>Date</th>';
                    echo '</tr>';

                    // Read the file line by line
                    while (($row = fgetcsv($fileRead)) !== false) {
                        // Output each row as a table row
                        echo '<tr>';
                        foreach ($row as $cell) {
                            echo '<td>' . htmlspecialchars($cell) . '</td>';
                        }
                        echo '</tr>';
                    }

                    // Close the file
                    fclose($file);

                    // Close the table structure
                    echo '</table>';
                } else {
                    // Display an error message if the file couldn't be opened
                    echo 'Error opening the file.';
                }
                ?>
        </div>
    </section>
</body>

</html>