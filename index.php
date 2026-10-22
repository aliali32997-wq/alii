
<?php
include 'koneksi.php';

$data = mysqli_query($conn, "SELECT * FROM buah");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Jenis Buah</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f4f4f4;
        }
        h2 {
            color: #287d43;
        }
        a, button {
            padding: 8px 12px;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .tambah {
            background: #287d43;
            color: white;
        }
        .edit {
            background: #f0ad4e;
            color: black;
        }
        .hapus {
            background: #dc3545;
            color: white;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background: #287d43;
            color: white;
        }
    </style>
</head>
<body>

<h2>Sistem Informasi Data Jenis Buah</h2>

<a href="tambah.php" class="tambah">+ Tambah Buah</a>

<table>
    <tr>
        <th>No</th>
        <th>Nama Buah</th>
        <th>Warna</th>
        <th>Harga per Kg</th>
        <th>Aksi</th>
    </tr>

    <?php
    $no = 1;
    while ($row = mysqli_fetch_assoc($data)) {
    ?>
    <tr>
        <td><?= $no++; ?></td>
        <td><?= htmlspecialchars($row['nama_buah']); ?></td>
        <td><?= htmlspecialchars($row['warna']); ?></td>
        <td>Rp<?= number_format($row['harga'], 0, ',', '.'); ?></td>
        <td>
            <a class="edit"
               href="edit.php?id=<?= $row['id']; ?>">Edit</a>

            <form action="hapus.php" method="POST"
                  style="display:inline"
                  onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                <input type="hidden" name="id"
                       value="<?= $row['id']; ?>">
                <button type="submit" class="hapus">Hapus</button>
            </form>
        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
