<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rekap Total Input</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        h1 {
            background-color: #176B87;
            color: #FFFFFF;
            padding: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        table {
            width: 60%;
            margin: 20px auto;
            background-color: #FFFFFF;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        th, td {
            padding: 10px;
            border: 1px solid #333;
            text-align: left;
        }

        th {
            background-color: #176B87;
            color: #FFFFFF;
        }

        tr:nth-child(even) {
            background-color: #f0f0f0;
        }

        .button-container {
            margin: 9px;
        }

        .button {
            background-color: #176B87;
            color: #FFFFFF;
            padding: 6px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin: 5px;
        }

        .button:hover {
            background-color: #144F6E;
        }

        /* Style for the search input */
        .search-input {
            padding: 6px;
            font-size: 14px;
            border: 1px solid #333;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Rekap Total Input</h1>
    <div class="button-container">
        <a href="log.php" class="button">Kembali</a>
        <button onclick="window.location.reload()" class="button">Refresh</button>
    </div>

    <form method="get" action="">
        <label for="search">Cari NIM:</label>
        <input type="text" name="search" id="search" class="search-input">
        <input type="submit" value="Cari" class="button">
    </form>

    <table>
        <tr>
            <th>NIM</th>
            <th>Total Input</th>
        </tr>
        <?php
        // Koneksi ke database
        $hostname = "localhost";
        $username = "akarkuadrat";
        $password = "";
        $database = "dbkuadratppl";

        $conn = new mysqli($hostname, $username, $password, $database);

        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        $search = isset($_GET['search']) ? $_GET['search'] : '';

        // Query untuk mencari berdasarkan NIM
        $sql = "SELECT NIM, COUNT(*) AS total FROM hasil_perhitungan WHERE NIM LIKE '%$search%' GROUP BY NIM";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['NIM'] . "</td>";
                echo "<td>" . $row['total'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='2'>Tidak ada data ditemukan.</td></tr>";
        }
        ?>
    </table>
</body>
</html>
