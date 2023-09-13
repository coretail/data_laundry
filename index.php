<?php
$servername = "localhost";
$username = "root"; // Ganti dengan nama pengguna MySQL Anda
$password = ""; // Ganti dengan kata sandi MySQL Anda
$dbname = "db_crudlaundry"; // Ganti dengan nama database yang ingin Anda gunakan

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
} else {
    echo "";
}

if(isset($_POST['bsimpan'])){

    //test apakah data akan diedit/simpan baru
    if(isset($_GET['hal']) == "edit"){
        //data akan diedit
        $edit = mysqli_query($conn, "UPDATE data_laundry SET
                                            `Nama Laundry` = '$_POST[tnama_laundry]',
                                            Alamat = '$_POST[talamat]',
                                            `No Telp` = '$_POST[tnomor_telepon]',
                                            `Terima Cuci Karpet` = '$_POST[tterima_karpet]'
                                        WHERE id = '$_GET[id]'
                                            ");
        //uji edit sukses
        if($edit){
            echo "<script>
                    alert('Berhasil Edit');
                    document.location='index.php';
                </script>";
        }else{
            echo "<script>
                    alert('Edit Gagal');
                    document.location='index.php';
                </script>";
        }                                   
    }else{
        //data akan disimpan baru 
        //simpan baru
        $save = mysqli_query($conn, "INSERT INTO data_laundry (`Nama Laundry`, Alamat, `No Telp`, `Terima Cuci Karpet`)
            VALUES (
                    '$_POST[tnama_laundry]',
                    '$_POST[talamat]',
                    '$_POST[tnomor_telepon]',
                    '$_POST[tterima_karpet]'
                    )");
            if($save){
                echo "<script>
                alert('Berhasil Simpan');
                document.location='index.php';
                </script>";
            }else{
                echo "<script>
                alert('Simpan Gagal');
                document.location='index.php';
                </script>";
                }
    }

    
}
//variable data yg akan di edit
$v_id = "";
$vnama = "";
$valamat = "";
$vno_telp = "";
$vkarpet = "";

//test tombol edit diklik
if(isset($_GET['hal'])) {
    //test edit data
    if($_GET['hal'] == "edit"){
        //show data yg akan diedit
        $tampil = mysqli_query($conn, "SELECT * FROM data_laundry WHERE id = '$_GET[id]' ");
        $data = mysqli_fetch_array($tampil);
        if($data){
            //jika data ada maka ditampung ke variable
            $vnama = $data['Nama Laundry'];
            $valamat = $data['Alamat'];
            $vno_telp = $data['No Telp'];
            $vkarpet = $data['Terima Cuci Karpet'];
        }
    }else if($_GET['hal'] == "delete"){
        //persiapan hapus data
        $delete =  mysqli_query($conn, "DELETE FROM data_laundry WHERE id = '$_GET[id]' ");
        if($delete){
            echo "<script>
            alert('Berhasil Hapus Data');
            document.location='index.php';
            </script>";
        }else{
            echo "<script>
            alert('Hapus Data Gagal');
            document.location='index.php';
            </script>";
            }
    }
}



?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD Toko Laundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
        <!--------------------open------------------------>
    <h1 class = "text-center">Data Toko Laundry</h1>
    <div class="row">
        <div class="col-md-12 mx-auto">
        <div class="card text-center">
            <div class="card-header bg-info">
                Input Laundry
            </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nama Laundry</label>
                            <input type="text" name = "tnama_laundry" value = "<?= $vnama ?>" class="form-control" placeholder="Masukkan Nama Laundry">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <input type="text" name = "talamat" value = "<?= $valamat ?>" class="form-control" placeholder="Masukkan Alamat Laundry">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" name = "tnomor_telepon" value = "<?= $vno_telp ?>" class="form-control" placeholder="Masukkan Nomor Telepon">
                        </div>
                        <div>
                            <label class="form-label">Terima Laundry Karpet?</label>
                            <select class="form-select" name="tterima_karpet" aria-label="Default select example">
                                <option selected class="text-muted">Pilih!</option>
                                <option value="1" <?= ($vkarpet == 1) ? 'selected' : ''; ?>>Ya</option>
                                <option value="0" <?= ($vkarpet == 0) ? 'selected' : ''; ?>>Tidak</option>
                            </select>
                        </div>

                        <div class="text-center">
                            <hr>               
                            <button class="btn btn-primary" name="bsimpan" type="submit">Save</button>
                            <button class="btn btn-danger" name="bkosongkan" type="reset">Reset</button>        
                        </div>
                    </form>
                </div>
                <div class="card-footer text-muted bg-info">
                    
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 mx-auto mt-3">
        <div class="card text-center">
            <div class="card-header bg-info">
                Data Laundry
            </div>
                <div class="card-body">
                    <div class="col-md6">
                        <form method="POST">
                            <div class="input-group mb-5 mx auto">
                                <input type="text" name="tcari" class="form-control" placeholder="Pencarian">
                                <button class="btn btn-primary" name="bcari" type="submit">Search</button>
                                <a href="index.php" class="btn btn-dark" name="bkembali">Reset</a>
                                
                            </div>

                        </form>
                    </div>
                    <table class="table table-dark table-hover">
                        <tr>
                            <th>No.</th>
                            <th>ID</th>
                            <th>Nama Laundry</th>
                            <th>Alamat</th>
                            <th>No Telp</th>
                            <th>Terima Cuci Karpet</th>
                            <th>Aksi</th>
                        </tr>
                        <?php
                            $num = 1;
                            //pencarian data
                            //jika tombol search diklik
                            if(isset($_POST['bcari'])){
                                //tampilkan data yg dicari
                                $keyword = $_POST['tcari'];
                                $q = "SELECT * FROM data_laundry WHERE `Nama Laundry` LIKE '%$keyword%' or ID LIKE '%$keyword%' or Alamat LIKE '%$keyword%' ORDER BY ID DESC";

                            }else {
                                $q = "SELECT * FROM data_laundry ORDER BY ID DESC";
                            }

                            $show = mysqli_query($conn, $q);
                            while($data = mysqli_fetch_array($show)) : 
                        ?>

                        <tr>
                            <td><?=$num++ ?></td>
                            <td><?=$data['ID']?></td>
                            <td><?=$data['Nama Laundry']?></td>
                            <td><?=$data['Alamat']?></td>
                            <td><?=$data['No Telp']?></td>
                            <td><?= ($data['Terima Cuci Karpet'] == 1) ? 'Ya' : 'Tidak'; ?></td>
                            <td>
                                <a href="index.php?hal=edit&id=<?=$data['ID']?>" class="btn btn-warning">Edit</a>
                                <a href="index.php?hal=delete&id=<?=$data['ID']?>" class="btn btn-danger" onclick="return confirm('Apakah Amda yakin akan memnghapus data ini?')">Delete</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </table>
                </div>
                <div class="card-footer text-muted bg-info">
                    
                </div>
            </div>
        </div>

    <!--------------------close------------------------>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>