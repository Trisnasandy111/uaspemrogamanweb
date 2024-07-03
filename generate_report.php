<?php
include 'db.php';

$groups = ['A', 'B', 'C', 'D'];

echo "<!DOCTYPE html>
<html>
<head>
    <title>Laporan Klasemen UEFA EURO 2024</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h2 {
            text-align: center;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
        .button-container {
            display: flex;
            justify-content: space-between;
            width: 80%;
            margin: 20px auto;
        }
        .button-container a,
        .button-container button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .button-container button:hover,
        .button-container a:hover {
            background-color: #45a049;
        }
    </style>
    <script>
        function printReport() {
            window.print();
        }
    </script>
</head>
<body>";

echo "<div class='button-container'>
        <a href='cetak_pdf.php'>Cetak PDF</a>
        <button onclick='printReport()'>Print</button>
      </div>";

foreach ($groups as $group) {
    echo "<h2>Group $group</h2>";
    echo "<table>
            <tr>
                <th>Tim</th>
                <th>Menang</th>
                <th>Seri</th>
                <th>Kalah</th>
                <th>Poin</th>
                <th>Aksi</th>
            </tr>";
    
    $group_id = array_search($group, $groups) + 1;
    $query = "SELECT * FROM teams WHERE group_id='$group_id' ORDER BY points DESC, name ASC";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['name']}</td>
                    <td>{$row['wins']}</td>
                    <td>{$row['draws']}</td>
                    <td>{$row['losses']}</td>
                    <td>{$row['points']}</td>
                    <td>
                        <a href='edit_team.php?id={$row['id']}'>Edit</a> | 
                        <a href='delete_team.php?id={$row['id']}' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Hapus</a>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr>
                <td colspan='6'>Tidak ada data untuk grup ini.</td>
              </tr>";
    }
    echo "</table>";
}

echo "</body></html>";

$conn->close();
?>
