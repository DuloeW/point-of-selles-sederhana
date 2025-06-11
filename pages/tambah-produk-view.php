<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title> 
</head>
<body>
  <h1>Tambah Produk</h1>

    <button>
        <a href="list-produk-view.php">kembali</a>
    </button>
<br><br>
    <form action="../handler/tambahaksi.php" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td><label for="kode_produk">Kode Produk</label></td>
                <td><input type="text" name="kode_produk" required></td>
            </tr>
            <tr>
                <td><label for="nama_produk">Nama Produk</label></td>
                <td><input type="text" name="nama_produk" required></td>
            </tr>
            <tr>
                <td><label for="deskripsi">Deskripsi</label></td>
                <td><textarea name="deskripsi" rows="4" cols="30" required></textarea></td>
            </tr>
            <tr>
                <td><label for="harga_jual">Harga Jual</label></td>
                <td><input type="number" name="harga_jual" required></td>
            </tr>
            <tr>
                <td><label for="stok">Stok</label></td>
                <td><input type="number" name="stok" required></td>
            </tr>
            <tr>
                <td><label for="satuan">Satuan</label></td>
                <td><input type="text" name="satuan" required></td>
            </tr>
            <tr>
                <td><label for="kategori">Kategori</label></td>
                <td><input type="text" name="kategori" required></td>
            </tr>
            <tr>
                <td><label for="foto_produk">Foto Produk</label></td>
                <td><input type="file" name="foto_produk" accept="image/*" required></td>
            </tr>
            <tr>
                <td></td>
                <td><small>*<i>Format: JPG, JPEG, PNG. Max size: 2MB</i></small></td>
            </tr>
            <tr>
                <td><label for="tanggal_dibuat">Tanggal Dibuat</label></td>
                <td><input type="date" name="tanggal_dibuat" required></td>             
            </tr>
            <tr>
                <td><label for="tanggal_diperbarui">Tanggal Diperbarui</label></td>
                <td><input type="date" name="tanggal_diperbarui" required></td>             
            </tr>
            
        </table><br><br>    
        <button class="kirim" type="submit">KIRIM</button>
          <button class="reset" type="reset">RESET</button>
    </form>
</body>
</html>