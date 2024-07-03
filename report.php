<?php
include 'db.php';

date_default_timezone_set('Asia/Jakarta'); // Set timezone ke Jakarta
$current_datetime = date('d M Y H:i:s'); // Dapatkan waktu dan tanggal sekarang

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
        .pdf-link {
            display: block;
            width: 80%;
            margin: 20px auto;
            text-align: right;
        }
        .datetime {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>";

echo "<div class='pdf-link'><a href='generate_pdf.php'>Cetak PDF</a></div>";

foreach ($groups as $group) {
    echo "<h2>Group $group</h2>";
    echo "<div class='datetime'>Per $current_datetime</div>"; // Tambahkan tampilan waktu dan tanggal sekarang
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
