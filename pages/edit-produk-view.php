<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
</head>

<body>
    <h2>Edit Data Produk</h2>
    <br />
    <a href="list-produk-view.php">KEMBALI</a>
    <br /><br />




    <!-- // // Cek apakah id_produk ada di URL
// if (!isset($_GET['id_produk'])) { -->
    <!-- //     echo "<script>alert('ID produk tidak ditemukan!');window.location='listproduk.php';</script>"; -->
    <!-- //     exit;
// } -->

    <!-- // $id_produk = $_GET['id_produk'];
// $data = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk='$id_produk'");
// if(mysqli_num_rows($data) == 0){ -->
    <!-- //     echo "<script>alert('Data produk tidak ditemukan!');window.location='listproduk.php';</script>"; -->
    <!-- //     exit;
// } -->


    <?php
    include '../auth/koneksi.php';

    $id_produk = $_GET['id_produk'];
    $data = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk='$id_produk'");
    while ($d = mysqli_fetch_array($data)) {
    ?>

        <form method="post" action="update_produk_handler.php" enctype="multipart/form-data">
            <table>
                <tr>
                    <td><input type="hidden" name="id_produk" value="<?php echo $d['id_produk']; ?>"></td>
                </tr>
                <tr>
                    <td>Kode Produk</td>
                    <td><input type="text" name="kode_produk" value="<?php echo $d['kode_produk']; ?>" required></td>
                </tr>
                <tr>
                    <td>Nama Produk</td>
                    <td><input type="text" name="nama_produk" value="<?php echo $d['nama_produk']; ?>" required></td>
                </tr>
                <tr>
                    <td>Deskripsi</td>
                    <td><textarea name="deskripsi" rows="4" cols="30" required><?php echo $d['deskripsi']; ?></textarea></td>
                </tr>
                <tr>
                    <td>Harga Jual</td>
                    <td><input type="number" name="harga_jual" value="<?php echo $d['harga_jual']; ?>" required></td>
                </tr>
                <tr>
                    <td>Stok</td>
                    <td><input type="number" name="stok" value="<?php echo $d['stok']; ?>" required></td>
                </tr>
                <tr>
                    <td>Satuan</td>
                    <td><input type="text" name="satuan" value="<?php echo $d['satuan']; ?>" required></td>
                </tr>
                <tr>
                    <td>Kategori</td>
                    <td><input type="text" name="kategori" value="<?php echo $d['kategori']; ?>" required></td>
                </tr>
                <tr>
                    <td>Foto Produk</td>
                    <td>
                        <input type="file" name="foto_produk">
                        <br>
                        <?php if ($d['foto_produk'] != '') { ?>
                            <img src="uploads/<?php echo $d['foto_produk']; ?>" width="100">
                        <?php } ?>
                        <input type="hidden" name="foto_produk_lama" value="<?php echo $d['foto_produk']; ?>">
                        <br><small>*Kosongkan jika tidak ingin mengubah foto</small>
                    </td>
                </tr>
                <tr>
                    <td>Tanggal Dibuat</td>
                    <td><input type="date" name="tanggal_dibuat" value="<?php echo $d['tanggal_dibuat']; ?>" required></td>
                </tr>
                <tr>
                    <td>Tanggal Diperbarui</td>
                    <td><input type="date" name="tanggal_diperbarui" value="<?php echo $d['tanggal_diperbarui']; ?>" required></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="SIMPAN"></td>
                </tr>
            </table>
        </form>
    <?php
    }
    ?>
</body>

</html>