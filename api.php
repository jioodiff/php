<?php

include 'koneksi.php';

header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];

// ==========================
// GET DATA
// ==========================
if($method == 'GET'){

    $data = [];

    $query = mysqli_query($koneksi,
        "SELECT * FROM users ORDER BY id ASC"
    );

    while($row = mysqli_fetch_assoc($query)){
        $data[] = $row;
    }

    echo json_encode([
        "status" => true,
        "message" => "Berhasil mengambil data",
        "data" => $data
    ]);
}

// ==========================
// TAMBAH DATA
// ==========================
elseif($method == 'POST'){

    $nama  = $_POST['nama'] ?? '';
    $sandi = $_POST['sandi'] ?? '';

    $query = mysqli_query($koneksi,
        "INSERT INTO users(nama, sandi)
         VALUES('$nama','$sandi')"
    );

    if($query){

        echo json_encode([
            "status" => true,
            "message" => "Data berhasil ditambahkan"
        ]);

    }else{

        echo json_encode([
            "status" => false,
            "message" => "Gagal tambah data"
        ]);
    }
}

// ==========================
// UPDATE DATA
// ==========================
elseif($method == 'PUT'){

    parse_str(file_get_contents("php://input"), $_PUT);

    $id    = $_PUT['id'];
    $nama  = $_PUT['nama'];
    $sandi = $_PUT['sandi'];

    $query = mysqli_query($koneksi,
        "UPDATE users
         SET nama='$nama',
             sandi='$sandi'
         WHERE id=$id"
    );

    if($query){

        echo json_encode([
            "status" => true,
            "message" => "Data berhasil diupdate"
        ]);

    }else{

        echo json_encode([
            "status" => false,
            "message" => "Gagal update data"
        ]);
    }
}

// ==========================
// DELETE DATA
// ==========================
elseif($method == 'DELETE'){

    parse_str(file_get_contents("php://input"), $_DELETE);

    $id = $_DELETE['id'];

    $query = mysqli_query($koneksi,
        "DELETE FROM users WHERE id=$id"
    );

    if($query){

        echo json_encode([
            "status" => true,
            "message" => "Data berhasil dihapus"
        ]);

    }else{

        echo json_encode([
            "status" => false,
            "message" => "Gagal hapus data"
        ]);
    }
}
?>
