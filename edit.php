
<?php
include 'koneksi.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    die("ID buah tidak valid.");
}

$stmt = mysqli_prepare($conn, "SELECT * FROM buah WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$buah = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$buah) {
    die("Data buah tidak ditemukan.");
}

$nama = $buah['nama_buah'];
$warna = $buah['warna'];
$harga = $buah['harga'];
$pesan = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST['nama_buah']);
    $warna = trim($_POST['warna']);
    $harga = filter_var($_POST['harga'], FILTER_VALIDATE_INT);

    if ($nama !== "" && $warna !== "" &&
        $harga !== false && $harga >= 0) {

        $stmt = mysqli_prepare(
            $conn,
            "UPDATE buah
             SET nama_buah = ?, warna = ?, harga = ?
             WHERE id = ?"
        );

        mysqli_stmt_bind_param(
            $stmt, "ssii", $nama, $warna, $harga, $id
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
    <title>Edit Buah</title>
</head>
<body>

<h2>Edit Data Buah</h2>

<p><?= htmlspecialchars($pesan); ?></p>

<form method="POST">
    <label>Nama Buah:</label><br>
    <input type="text" name="nama_buah"
           value="<?= htmlspecialchars($nama); ?>" required>
    <br><br>

    <label>Warna Buah:</label><br>
    <input type="text" name="warna"
           value="<?= htmlspecialchars($warna); ?>" required>
    <br><br>

    <label>Harga per Kg:</label><br>
    <input type="number" name="harga" min="0"
           value="<?= htmlspecialchars((string)$harga); ?>" required>
    <br><br>

    <button type="submit">Simpan Perubahan</button>
    <a href="index.php">Kembali</a>
</form>

</body>
</html>
