<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Produk</title>
</head>

<body>
    <h1>List Produk</h1>
    <button>
        <a href="tambah-produk-view.php">Tambah Produk</a>
    </button>
    <br><br>
    <table border="3">
        <tr>
            <th>No</th>
            <th>Kode Produk</th>
            <th>Nama Produk</th>
            <th>Deskripsi</th>
            <th>Harga Jual</th>
            <th>Stok</th>
            <th>Satuan</th>
            <th>Kategori</th>
            <th>Foto Produk</th>
            <th>Tanggal Dibuat</th>
            <th>Tanggal Diperbarui</th>
            <th>Aksi</th>
        </tr>
        <?php
        include '../auth/koneksi.php';

        $index = 1;
        $data = mysqli_query($koneksi, "select * from produk");

        while ($d = mysqli_fetch_array($data)) {
        ?>

            <tr>
                <td>
                    <?php echo $index++; ?>
                </td>
                <td>
                    <?php echo $d['kode_produk']; ?>
                </td>
                <td>
                    <?php echo $d['nama_produk']; ?>
                </td>
                <td>
                    <?php echo $d['deskripsi']; ?>
                </td>
                <td>
                    <?php echo $d['harga_jual']; ?>
                </td>
                <td>
                    <?php echo $d['stok']; ?>
                </td>
                <td>
                    <?php echo $d['satuan']; ?>
                </td>
                <td>
                    <?php echo $d['kategori']; ?>
                </td>
                <td>
                    <?php if (!empty($d['foto_produk'])): ?>
                        <img src="../uploads/<?php echo $d['foto_produk']; ?>" alt="Foto <?php echo $d['nama_produk']; ?>" style="width: 100px; height: auto;">
                    <?php else: ?>
                        <p>Tidak ada foto</p>
                    <?php endif; ?>
                </td>
                <td>
                    <?php echo $d['tanggal_dibuat']; ?>
                </td>
                <td>
                    <?php echo $d['tanggal_diperbarui']; ?>
                </td>

                <td>
                    <button class="edit">
                        <a href="edit-produk-view.php?id_produk=<?php echo $d['id_produk'] ?>">EDIT</a>
                    </button>
                    <button class="hapus">
                        <a href="../handler/hapus_produk_handler.php?id_produk=<?php echo $d['id_produk'] ?>">HAPUS</a>
                    </button>
                </td>
            </tr>
        <?php
        }
        ?>
    </table><br><br>
    <button>
        <a href="menu-produk-view.php">Kembali</a>
    </button>
</body>

</html>