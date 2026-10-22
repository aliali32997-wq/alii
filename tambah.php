
<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST['nama_buah']);
    $warna = trim($_POST['warna']);
    $harga = filter_var($_POST['harga'], FILTER_VALIDATE_INT);

    if ($nama !== "" && $warna !== "" &&
        $harga !== false && $harga >= 0) {

        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO buah (nama_buah, warna, harga)
             VALUES (?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt, "ssi", $nama, $warna, $harga
        );

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("Location: index.php");
        exit;
    } else {
        $pesan = "Isi semua kolom dengan benar.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Buah</title>
</head>
<body>

<h2>Tambah Data Buah</h2>

<?php if (isset($pesan)) echo $pesan; ?>

<form method="POST">
    <label>Nama Buah:</label><br>
    <input type="text" name="nama_buah" required>
    <br><br>

    <label>Warna Buah:</label><br>
    <input type="text" name="warna" required>
    <br><br>

    <label>Harga per Kg:</label><br>
    <input type="number" name="harga" min="0" required>
    <br><br>

    <button type="submit">Simpan</button>
    <a href="index.php">Kembali</a>
</form>

</body>
</html>
