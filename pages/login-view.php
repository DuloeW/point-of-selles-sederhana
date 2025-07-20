<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login Page</title>
  <link rel="icon" type="image/png" href="../assets/d-logo.png">
  <link rel="stylesheet" href="../assets/output.css">
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-600 to-blue-500">

  <div class="w-full max-w-md px-6 relative z-10">
    <!-- Welcome Text -->
    <div class="text-center mb-8">
      <h1 class="text-white text-5xl font-extrabold leading-snug drop-shadow-md">
        Welcome<br />
        Team <span class="text-yellow-300">d'Carts</span>
      </h1>
    </div>

    <!-- Glass Form -->
    <div class="p-8 rounded-2xl bg-white/20 backdrop-blur-lg shadow-xl border border-white/30">
      <h2 class="text-3xl font-bold text-white text-center mb-6">Login</h2>

      <form action="../handler/login_handler.php" method="POST">
        <!-- Username -->
        <div class="mb-4">
          <label class="block text-sm text-white mb-1">Username</label>
          <input type="text" name="username" placeholder="Masukkan Username" required
            class="w-full px-4 py-2 rounded-lg bg-white/30 text-white placeholder-white/70 border border-white/30 focus:outline-none focus:ring-2 focus:ring-blue-200" />
        </div>

        <!-- Password -->
        <div class="mb-6">
          <label class="block text-sm text-white mb-1">Password</label>
          <input type="password" name="password" placeholder="Masukkan Password" required
            class="w-full px-4 py-2 rounded-lg bg-white/30 text-white placeholder-white/70 border border-white/30 focus:outline-none focus:ring-2 focus:ring-blue-200" />

          <!-- PHP Notifikasi -->
          <?php
          if (isset($_GET['pesan'])) {
              if ($_GET['pesan'] == "gagal-user") {
                  echo "<div class='mt-3 px-4 py-2 text-sm text-red-100 bg-red-500/30 border border-red-400 rounded-lg'>
                          ❌ Login gagal: Username Salah.
                        </div>";
              } elseif ($_GET['pesan'] == "gagal-pass") {
                  echo "<div class='mt-3 px-4 py-2 text-sm text-red-100 bg-red-500/30 border border-red-400 rounded-lg'>
                          ❌ Login gagal: Password Salah.
                        </div>";
              } elseif ($_GET['pesan'] = "akun-nonaktif") {
                  echo "<div class='mt-3 px-4 py-2 text-sm text-red-100 bg-red-500/30 border border-red-400 rounded-lg'>
                          ❌ Login gagal: Akun Anda tidak aktif.
                        </div>";
              } else {
                  echo "<div class='mt-3 px-4 py-2 text-sm text-red-100 bg-red-500/30 border border-red-400 rounded-lg'>
                          ❌ Login gagal: Terjadi kesalahan, silakan coba lagi.
                        </div>";
              }
          }
          ?>
        </div>

        <!-- Tombol Login -->
         <div class="mb-3">
           <button type="submit"
             class="w-full py-3 text-lg bg-gradient-to-r from-purple-700 via-purple-500 to-blue-500 text-white font-bold rounded-lg border border-white/30 shadow-lg transform scale-95 hover:scale-100 hover:ring-2 hover:ring-white/50 transition duration-300">
             Login
           </button>
         </div>

        <div class="mb-4 flex justify-center items-center text-sm space-x-1">
      <span class="text-white">Masih belum punya akun?</span>
     <a href="register-view.php" class="text-purple-700 no-underline hover:no-underline focus:no-underline active:no-underline">
       Klik di sini
       </a>
      </div>
      </form>

      <p class="text-xs text-center text-white/70 mt-6">
        © 2025 d'Carts and Basket. All rights reserved.
      </p>
    </div>
  </div>

</body>
</html>
