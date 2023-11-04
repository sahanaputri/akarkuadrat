<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kalkulator Akar Kuadrat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #808080;
            text-align: center;
        }

        #container {
            width: 800px;
            margin: 100px auto;
            background-color: #96B6C5;
            padding: 30px;
            padding-left: 10px;
            padding-top: 0px;
            padding-bottom: 45px;
            padding-right: 10px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(1, 1, 1, 1);
        }

        h1 {
            color: #333333;
        }

        label {
            font-weight: bold;
        }

        input[type="number"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
        }

        .button-container {
            display: flex;
            justify-content: space-around;
        }

        .button {
            background-color: #176B87;
            color: #FFFFFF;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #64CCC5;
        }

        #result {
            margin-top: 20px;
            font-weight: bold;
        }

        #log-container {
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #333;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }
        #result {
    margin-bottom: 20px; /* Adjust this value to control the spacing */
}

    </style>
</head>
<body>
    <div id="container">
    <?php
        session_start();

        if (isset($_SESSION['nim'])) {
            $nim = $_SESSION['nim'];
            echo "<div id='header' style='background-color: #176B87; color: #FFFFFF; font-weight: bold;'>Hello, $nim!</div>";
        }
    ?>
        <h1>Kalkulator Akar Kuadrat</h1>
        <br>
        <form method="POST">
            <label for="number">Masukkan Angka: </label>
            <input type="number" name="number" id="number" required>
            <div class="button-container">
                <button type="submit" class="button" name="calculate_api">API</button>
                <button type="submit" class="button" name="calculate_plsql">PL/SQL</button>
            </div>
        
     <?php
$hostname = "localhost";
$username = "akarkuadrat";
$password = "";
$database = "dbkuadratppl";

$conn = new mysqli($hostname, $username, $password, $database);

        require 'koneksi.php';
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['number'])) {
            $number = floatval($_POST['number']);
            $result = 0;
            $executionTime = 0;
            $currentDateTime = date('Y-m-d H:i:s'); // Tanggal waktu input
        
            if (isset($_POST['calculate_api'])) {
                $startTime = microtime(true); // Record start time
                // Hitung akar kuadrat dengan fungsi PHP
                $result = sqrt($number);
                $method = "API";
                $executionTime = microtime(true) - $startTime; // Calculate execution time
                $sql = "INSERT INTO hasil_perhitungan (NIM, Metode, Angka, Hasil, Tanggal, Waktu) 
                VALUES ('$nim', '$method', '$number', '$result', '$currentDateTime', '$executionTime')";
                $conn->query($sql);
            } elseif (isset($_POST['calculate_plsql'])) {
        // Koneksi ke database
        $hostname = "localhost";
        $username = "akarkuadrat";
        $password = "";
        $database = "dbkuadratppl";

        $conn = new mysqli($hostname, $username, $password, $database);

        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        $startTime = microtime(true); // Record start time
        // Eksekusi prosedur PL/SQL untuk menghitung akar kuadrat
        $sql = "CALL CalculateSquareRoot($number, @result)";
        $conn->query($sql);

        // Ambil hasil dari variabel OUT
        $result_query = $conn->query("SELECT @result as result");
        if ($result_query) {
            $result_row = $result_query->fetch_assoc();
            $result = $result_row['result'];
        }

        // Simpan hasil perhitungan ke dalam log
        $method = "PL/SQL";
        $executionTime = microtime(true) - $startTime; // Calculate execution time
        $sql = "INSERT INTO hasil_perhitungan (NIM, Metode, Angka, Hasil, Tanggal, Waktu) 
                VALUES ('$nim', '$method', '$number', '$result', '$currentDateTime', '$executionTime')";
        $conn->query($sql);

        // Update total input pengguna
        $sql = "UPDATE total_input SET total = total + 1 WHERE nim = '$nim'";
        $conn->query($sql);

        $conn->close();
    }

    // Record the current date and time
    $currentDateTime = date('Y-m-d H:i:s');
    echo ".";
    echo "<div id='result'>Hasil Akar Kuadrat dari $number yaitu $result</div>";

    // Simpan log ke dalam file atau database sesuai kebutuhan Anda
     // Simpan log ke dalam file atau database sesuai kebutuhan Anda
     $log = "$method | $number | $result | $currentDateTime | $executionTime ";
     file_put_contents("log.txt", $log . PHP_EOL, FILE_APPEND);
 }

?>
<form>
    <button type="sumbit" class="button" onclick="window.location.href = 'log.php';">Log Data</button>
    <button type="sumbit" class="button" onclick="window.location.href = 'rekap.php';">Recap</button>
    <button type="sumbit" class="button" onclick="window.location.href = 'logout.php';">Log Out</button>
</form>


</body>
</html>