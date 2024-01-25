<?php
$columnValues = array();
$targetColumnIndex = 1;
$targetTypeIndex = 0; // Indeks kolom yang berisi tipe data (income atau expense)
$fileOpen = fopen('file.csv', 'r');
$balance = 0;

if ($fileOpen) {
    while (($row = fgetcsv($fileOpen)) !== false) {
        if (isset($row[$targetColumnIndex]) && isset($row[$targetTypeIndex])) {
            $amount = (float) $row[$targetColumnIndex];
            $type = $row[$targetTypeIndex];

            // Memperbarui nilai balance berdasarkan tipe data
            if ($type == 'income') {
                $balance += $amount;
            } elseif ($type == 'expense') {
                $balance -= $amount;
            }

            // Menambahkan nilai amount ke dalam array
            $columnValues[] = $amount;
        }
    }

    fclose($fileOpen);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <section class="max-w-screen-xl">
        <h1>Advnace Financial System</h1>
        <h2>Balance
            <?php echo 'Rp ' . number_format((float) $balance, 2, ',', '.');  ?>
        </h2>
        <form action="process.php" method="post">
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
            if ($fileRead) {
                echo '<table>';
                echo '<tr>';
                echo '<th>Type</th>';
                echo '<th>Amount</th>';
                echo '<th>Date</th>';
                echo '</tr>';

                while (($row = fgetcsv($fileRead)) !== false) {
                    if (is_array($row)) {
                        echo '<tr>';

                        foreach ($row as $index => $cell) {
                            if ($index === 1) {
                                echo '<td>Rp ' . number_format((float) $cell, 2, ',', '.') . '</td>';
                            } else {
                                echo '<td>' . htmlspecialchars($cell) . '</td>';
                            }
                        }

                        echo '</tr>';
                    }
                }

                fclose($fileRead);

                echo '</table>';
            } else {
                echo 'Error opening the file.';
            }
            ?>
        </div>
    </section>
</body>

</html>