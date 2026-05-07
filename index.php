<?php
include 'koneksi.php';

// Tampilkan error
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ==========================
// TAMBAH DATA
// ==========================
if (isset($_POST['tambah'])) {

    $nama  = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $sandi = mysqli_real_escape_string($koneksi, $_POST['sandi']);

    $query = "INSERT INTO users (nama, sandi) VALUES ('$nama', '$sandi')";

    if (mysqli_query($koneksi, $query)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}

// ==========================
// HAPUS DATA
// ==========================
if (isset($_GET['hapus'])) {

    $id = (int) $_GET['hapus'];

    $query = "DELETE FROM users WHERE id = $id";

    if (mysqli_query($koneksi, $query)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP CRUD Railway</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            padding:20px;
        }

        input, button{
            padding:10px;
            margin:5px;
        }

        table{
            border-collapse: collapse;
            width:100%;
            margin-top:20px;
        }

        table, th, td{
            border:1px solid #ccc;
        }

        th, td{
            padding:10px;
            text-align:left;
        }

        a{
            color:red;
            text-decoration:none;
        }
    </style>
</head>
<body>

    <h2>Tambah Data</h2>

    <form method="POST">

        <input type="text" name="nama" placeholder="Nama" required>

        <!-- sebelumnya type="sandi" salah -->
        <input type="password" name="sandi" placeholder="Password" required>

        <button type="submit" name="tambah">Simpan</button>

    </form>

    <h2>Data Users</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Password</th>
            <th>Aksi</th>
        </tr>

        <?php
        $data = mysqli_query($koneksi, "SELECT * FROM users");

        while($d = mysqli_fetch_assoc($data)){
        ?>

        <tr>
            <td><?= $d['id']; ?></td>
            <td><?= $d['nama']; ?></td>
            <td><?= $d['sandi']; ?></td>
            <td>
                <a href="index.php?hapus=<?= $d['id']; ?>" onclick="return confirm('Yakin hapus data?')">
                    Hapus
                </a>
            </td>
        </tr>

        <?php } ?>

    </table>

</body>
</html>
