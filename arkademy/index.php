<?php
    $server = "localhost";
    $user = "root";
    $password = "";
    $database = "arkademy";

    $koneksi = mysqli_connect($server, $user, $password, $database)or die(mysqli_error($koneksi));

    if(isset($_POST['bsimpan']))
    {
        //Pengujian apakah data akan diedit atau disimpan baru
        if($_GET['hal'] == "edit")
        {
            //Data akan diedit
            $edit = mysqli_query($koneksi, " UPDATE produk set
                                            nama_produk = '$_POST[nama_produk]',
                                            keterangan = '$_POST[keterangan]',
                                            harga = '$_POST[harga]',
                                            jumlah = '$_POST[jumlah]'
                                            WHERE nama_produk = '$_GET[id]'
                                            ");
    if($edit)
    {
        echo "<script>
        alert('Edit Data Sukses');
        document.location='index.php';
        </script>";
    }
    else
    {
        echo "<script>
        alert('Edit Data Gagal');
        document.location='index.php';
        </script>";
    }
        }else
        {
            //Data akan disimpan baru
            $simpan = mysqli_query($koneksi, "INSERT INTO produk (nama_produk, keterangan, harga, jumlah)
                                        VALUES ('$_POST[nama_produk]', '$_POST[keterangan]', '$_POST[harga]', '$_POST[jumlah]')");
    if($simpan)
    {
        echo "<script>
        alert('Simpan Data Sukses');
        document.location='index.php';
        </script>";
    }
    else
    {
        echo "<script>
        alert('Simpan Data Gagal');
        document.location='index.php';
        </script>";
    }
        }





        
}   

if(isset($_GET['hal']))
{
    if($_GET['hal'] == "edit")
    {
        $tampil = mysqli_query($koneksi, "SELECT * FROM produk WHERE nama_produk = '$_GET[id]'");
        $data = mysqli_fetch_array($tampil);
        if($data)
        {
            $vnamaproduk = $data['nama_produk'];
            $vketerangan = $data['keterangan'];
            $vharga = $data['harga'];
            $vjumlah = $data['jumlah'];
        }
    }
    else if ($_GET['hal'] == "hapus")
    {
        //Persiapan hapus data
        $hapus = mysqli_query($koneksi, "DELETE FROM produk WHERE nama_produk = '$_GET[id]'");
        if($hapus)
        {
            echo "<script>
            alert('Hapus Data Sukses');
            document.location='index.php';
            </script>";
        }
    }
}

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>Arkademy</title>
  </head>
  <body>
        <div class="container">
        <h1 class="text-center">Data Produk</h1>
        <div class="card mt-5">
    <div class="card-header bg-primary text-white">
        Form Input Data Produk
    </div>
    <div class="card-body">
        <form method="post" action="">
            <div class="form-group">
                <label>Produk </label>
                <input type="text" name="nama_produk" value="<?=@$vnamaproduk?>" class="form-control" placeholder="Masukan Nama Produk" required>
            </div>
        <form method="post" action="">
            <div class="form-group">
                <label>Keterangan </label>
                <input type="text" name="keterangan" value="<?=@$vketerangan?>" class="form-control" placeholder="Masukan Keterangan Produk" required>
            </div>
        <form method="post" action="">
            <div class="form-group">
                <label>Harga </label>
                <input type="text" name="harga" value="<?=@$vharga?>" class="form-control" placeholder="Masukan Harga Produk" required>
            </div>
        <form method="post" action="">
            <div class="form-group">
                <label>Jumlah </label>
                <input type="text" name="jumlah" value="<?=@$vjumlah?>" class="form-control" placeholder="Masukan Jumlah Produk" required>
            </div>
        <button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
        <button type="reset" class="btn btn-danger" name="reset">Batal</button>
        </form>
</div>
<!-------------------->
<div class="card-header bg-success text-white">
        Daftar Produk
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tr>
                <th>No.</th>
                <th>Nama Produk</th>
                <th>Keterangan</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Action</th>
            </tr>
            <?php
            $no = 1;
                $tampil = mysqli_query($koneksi, "SELECT * from produk order by nama_produk desc");
                while($data = mysqli_fetch_array($tampil)) :
            ?>
            <tr>
                <td><?=$no++;?></td>
                <td><?=$data['nama_produk']?></td>
                <td><?=$data['keterangan']?></td>
                <td><?=$data['harga']?></td>
                <td><?=$data['jumlah']?></td>
                <td>
                    <a href="index.php?hal=edit&id=<?=$data['nama_produk']?>" class="btn btn-warning">Edit</a>
                    <a href="index.php?hal=hapus&id=<?=$data['nama_produk']?>" 
                    onclick="return confirm('Yakin ingin hapus data?')" class="btn btn-danger">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
    </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>