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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-100 max-w-screen-sm mx-auto">
    <section class="bg-gray-100">
        <h1 class="pt-20 font-bold text-5xl">Advanced Financial System</h1>
        <h2 class="font-semibold text-xl py-5">Balance
            <?php echo 'Rp ' . number_format((float) $balance, 2, ',', '.');  ?>
        </h2>
        <form action="process.php" method="post">

            <div class="bg-white rounded-xl shadow p-5">
                <div class="flex items-center">
                    <p class="">Transaction Type : </p>
                    <select class="py-2 px-3 border-2 mx-5 rounded-md" name="type" required>
                        <option value="income">income</option>
                        <option value="expense">expense</option>
                    </select>
                </div>
                <div class="flex items-center pt-5">
                    <p>Amount : </p>
                    <input class="py-2 px-3 border-2 ml-5 rounded-md" type="number" name="amount"></input>
                </div>

            </div>
            <input class="rounded my-5 py-3 px-4 bg-green-500 font-semibold text-white" type="submit"></input>
        </form>
        <div class="py-10">
            <?php
            $fileRead = fopen('file.csv', 'r');
            if ($fileRead) {
                echo '<table class="w-full py-2 rounded-xl bg-white table-auto shadow">';
                echo '<tr class="border-b-2 border-black">';
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