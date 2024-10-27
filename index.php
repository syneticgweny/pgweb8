<?php
// Sesuaikan dengan setting MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pgweb_acara8";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mengecek apakah ada permintaan hapus data
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $delete_sql = "DELETE FROM sleman WHERE id = ?";

    // Menggunakan prepared statement untuk keamanan
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        echo "<p style='text-align:center;color:green;'>Data berhasil dihapus</p>";
    } else {
        echo "<p style='text-align:center;color:red;'>Gagal menghapus data</p>";
    }
    $stmt->close();
}

// Menampilkan data dari tabel
$sql = "SELECT * FROM sleman";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            background-color: #FFD1DC;
            /* Warna soft pink */
            font-family: Arial, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
            background-color: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #FF69B4;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        td {
            text-align: right;
        }

        h2 {
            text-align: center;
            color: #FF69B4;
        }

        .delete-btn {
            background-color: #FF69B4;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
        }

        .delete-btn:hover {
            background-color: #FF85B2;
        }
    </style>
</head>

<body>

    <h2>Data Penduduk Kecamatan Sleman</h2>

    <?php
    if ($result->num_rows > 0) {
        echo "<table><tr>
<th>Kecamatan</th>
<th>Longitude</th>
<th>Latitude</th>
<th>Luas</th>
<th>Jumlah Penduduk</th>
<th>Aksi</th></tr>";

        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td align='left'>" . htmlspecialchars($row["Kecamatan"]) . "</td><td>" .
                htmlspecialchars($row["Longitude"]) . "</td><td>" .
                htmlspecialchars($row["Latitude"]) . "</td><td>" .
                htmlspecialchars($row["Luas"]) . "</td><td>" .
                htmlspecialchars($row["Jumlah_penduduk"]) . "</td>
            <td><a class='delete-btn' href='index.php?delete_id=" . $row["id"] . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Delete</a></td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='text-align:center;'>0 results</p>";
    }

    $conn->close();
    ?>

</body>

</html>