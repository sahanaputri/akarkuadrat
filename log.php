<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #FFFFFF;
            text-align: center;
        }
        .title-box {
            background-color: #176B87;
            color: #FFFFFF;
            padding: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        table {
            width: 80%;
            margin: 20px auto;
            background-color: #96B6C5;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #333;
            text-align: left;
        }
        th {
            background-color: #176B87;
            color: #FFFFFF;
            cursor: pointer;
        }
        th:hover { /* Hover effect for the th elements */
            background-color: #144F6E;
        }
        tr:nth-child(even) {
            background-color: #F0F0F0;
        }
        .button-container {
            margin-top: 20px;
        }
        .sort-container {
            margin-top: 10px;
            text-align: center;
        }
        .button {
            background-color: #176B87;
            color: #FFFFFF;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin: 5px;
        }
        .button:hover {
            background-color: #144F6E;
        }
        .button-container button {
            font-size: 12px;
        }

        /* Style for the "Sort By" button */
        .sort-container label {
            color: #176B87;
            font-weight: bold;
            font-size: 16px;
        }

        .sort-container select {
            padding: 5px;
            font-size: 14px;
            background-color: #176B87;
            color: #FFFFFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .sort-container select:hover {
            background-color: #144F6E;
        }

        .sort-container input[type="submit"] {
            background-color: #176B87;
            color: #FFFFFF;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
        }
        .sort-container input[type="submit"]:hover {
            background-color: #144F6E;
        }

    </style>
</head>
<body>
<div class="title-box">
    <h1>Log Data</h1>
</div>

<div class="button-container">
    <button class="button" id="refresh-button" onclick="window.location.reload();">Refresh</button>
    <button class="button" id="back-button" onclick="window.location.href = 'kuadrat1.php';">Kembali</button>
</div>

<div class="sort-container">
    <form method="get" action="">
        <label for="sort-by">Sort By:</label>
        <select name="sort" id="sort-by">
            <option value="id">ID</option>
            <option value="NIM">NIM</option>
            <option value="Metode">Metode</option>
            <option value="Angka">Angka</option>
            <option value="Hasil">Hasil</option>
            <option value="Tanggal">Created at</option>
            <option value="Waktu">Time</option>
        </select>
        <label for="sort-order">Sort Order:</label>
        <select name="order" id="sort-order">
            <option value="asc">Ascending</option>
            <option value="desc">Descending</option>
        </select>
        <input type="submit" value="Sort">
    </form>
</div>

<table>
    <tr>
        <th>ID</th>
        <th>NIM</th>
        <th>Metode</th>
        <th>Angka</th>
        <th>Hasil</th>
        <th>Created at</th>
        <th>Time</th>
    </tr>
    <?php
    $hostname = "localhost";
    $username = "akarkuadrat";
    $password = "";
    $database = "dbkuadratppl";

    $conn = new mysqli($hostname, $username, $password, $database);

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    $sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'id';
    $sort_order = isset($_GET['order']) ? $_GET['order'] : 'asc';

    $sql = "SELECT * FROM hasil_perhitungan ORDER BY $sort_by $sort_order";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["NIM"] . "</td>";
            echo "<td>" . $row["Metode"] . "</td>";
            echo "<td>" . $row["Angka"] . "</td>";
            echo "<td>" . $row["Hasil"] . "</td>";
            echo "<td>" . $row["Tanggal"] . "</td>";
            echo "<td>" . $row["Waktu"] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>Tidak ada data ditemukan.</td></tr>";
    }

    $conn->close();
    ?>
</table>
</body>
</html>
