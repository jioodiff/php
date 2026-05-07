<?php
include 'koneksi.php';

// ==========================
// ERROR REPORT
// ==========================
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

    mysqli_query($koneksi, $query);

    header("Location: index.php");
    exit;
}

// ==========================
// HAPUS DATA
// ==========================
if (isset($_GET['hapus'])) {

    $id = (int) $_GET['hapus'];

    mysqli_query($koneksi, "DELETE FROM users WHERE id=$id");

    header("Location: index.php");
    exit;
}

// ==========================
// EDIT DATA
// ==========================
$edit = false;
$editData = null;

if (isset($_GET['edit'])) {

    $edit = true;

    $id = (int) $_GET['edit'];

    $result = mysqli_query($koneksi, "SELECT * FROM users WHERE id=$id");

    $editData = mysqli_fetch_assoc($result);
}

// ==========================
// UPDATE DATA
// ==========================
if (isset($_POST['update'])) {

    $id    = (int) $_POST['id'];
    $nama  = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $sandi = mysqli_real_escape_string($koneksi, $_POST['sandi']);

    $query = "UPDATE users 
              SET nama='$nama', sandi='$sandi' 
              WHERE id=$id";

    mysqli_query($koneksi, $query);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD Railway PHP</title>

    <style>
        body{
            font-family: Arial;
            padding:20px;
            background:#f5f5f5;
        }

        .container{
            max-width:900px;
            margin:auto;
            background:white;
            padding:20px;
            border-radius:10px;
        }

        h2{
            margin-bottom:15px;
        }

        input{
            padding:10px;
            width:100%;
            margin-bottom:10px;
            box-sizing:border-box;
        }

        button{
            padding:10px 15px;
            border:none;
            cursor:pointer;
            border-radius:5px;
        }

        .btn-tambah{
            background:#28a745;
            color:white;
        }

        .btn-update{
            background:#007bff;
            color:white;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:20px;
        }

        table, th, td{
            border:1px solid #ddd;
        }

        th{
            background:#333;
            color:white;
        }

        th, td{
            padding:10px;
            text-align:left;
        }

        a{
            text-decoration:none;
            padding:5px 10px;
            border-radius:5px;
            color:white;
        }

        .edit{
            background:orange;
        }

        .hapus{
            background:red;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>
        <?= $edit ? 'Edit Data' : 'Tambah Data'; ?>
    </h2>

    <form method="POST">

        <?php if($edit){ ?>
            <input type="hidden" name="id" value="<?= $editData['id']; ?>">
        <?php } ?>

        <input 
            type="text" 
            name="nama" 
            placeholder="Nama"
            value="<?= $edit ? $editData['nama'] : ''; ?>"
            required
        >

        <input 
            type="password" 
            name="sandi" 
            placeholder="Password"
            value="<?= $edit ? $editData['sandi'] : ''; ?>"
            required
        >

        <?php if($edit){ ?>

            <button type="submit" name="update" class="btn-update">
                Update
            </button>

        <?php } else { ?>

            <button type="submit" name="tambah" class="btn-tambah">
                Simpan
            </button>

        <?php } ?>

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
        $data = mysqli_query($koneksi, "SELECT * FROM users ORDER BY id DESC");

        while($d = mysqli_fetch_assoc($data)){
        ?>

        <tr>

            <td><?= $d['id']; ?></td>
            <td><?= $d['nama']; ?></td>
            <td><?= $d['sandi']; ?></td>

            <td>

                <a 
                    href="index.php?edit=<?= $d['id']; ?>" 
                    class="edit"
                >
                    Edit
                </a>

                <a 
                    href="index.php?hapus=<?= $d['id']; ?>" 
                    class="hapus"
                    onclick="return confirm('Yakin ingin hapus data?')"
                >
                    Hapus
                </a>

            </td>

        </tr>

        <?php } ?>

    </table>

</div>

</body>
</html>
