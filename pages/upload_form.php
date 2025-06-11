<?php
include '../auth/koneksi.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File (Versi Alternatif)</title>
</head>
<body>
    <div class="container">
        <h2>Upload Foto Produk ke Direktori htdocs</h2>
        <form action="upload_handler.php" method="post" enctype="multipart/form-data">
            <label for="foto_produk">Pilih Foto Produk untuk di-Upload:</label>
            <input type="file" name="foto_produk" id="foto_produk" required><br>
            <small>Hanya gambar (JPG, JPEG, PNG) diizinkan. Maksimal 2MB.</small><br><br>
            <input type="submit" value="Upload Foto" name="submit">
        </form>

        <?php
        // Menampilkan pesan dari upload_handler.php jika ada
        session_start();
        if (isset($_SESSION['upload_message'])) {
            $message = $_SESSION['upload_message'];
            $type = $_SESSION['upload_type'];
            echo "<div class='message {$type}' style='display:block;'>{$message}</div>";
            unset($_SESSION['upload_message']);
            unset($_SESSION['upload_type']);
        }
        ?>
    </div>
</body>
</html>