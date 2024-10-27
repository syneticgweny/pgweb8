<?php
// Pastikan data POST tersedia dan lakukan sanitasi
$kecamatan = isset($_POST['kecamatan']) ? $_POST['kecamatan'] : '';
$longitude = isset($_POST['longitude']) ? $_POST['longitude'] : '';
$latitude = isset($_POST['latitude']) ? $_POST['latitude'] : '';
$luas = isset($_POST['luas']) ? $_POST['luas'] : '';
$jumlah_penduduk = isset($_POST['jumlah_penduduk']) ? $_POST['jumlah_penduduk'] : '';

// Cek apakah semua data diisi
if (empty($kecamatan) || empty($longitude) || empty($latitude) || empty($luas) || empty($jumlah_penduduk)) {
    die("Semua field harus diisi!");
}

// Konfigurasi MySQL
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

// Menggunakan prepared statement untuk keamanan
$stmt = $conn->prepare("INSERT INTO sleman (Kecamatan, Longitude, Latitude, Luas, Jumlah_penduduk) 
        VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sdddd", $kecamatan, $longitude, $latitude, $luas, $jumlah_penduduk);

if ($stmt->execute()) {
    echo "Data baru berhasil ditambahkan";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
