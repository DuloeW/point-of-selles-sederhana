<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register Page</title>
  <link rel="icon" type="image/png" href="../assets/d-logo.png">
  <link rel="stylesheet" href="../assets/output.css">
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-600 to-blue-500">
  <div class="w-full max-w-md px-6 lg:px-1 pb-5 relative z-10">
    <!-- Welcome Text -->
    <div class="text-center mb-8">
      <h1 class="text-white text-5xl font-extrabold leading-snug drop-shadow-md">
        Join<br />
        Team <span class="text-yellow-300">d'Carts</span>
      </h1>
    </div>

    <!-- Glass Form -->
    <div class="p-8 rounded-2xl bg-white/20 backdrop-blur-lg shadow-xl border border-white/30">
      <h2 class="text-3xl font-bold text-white text-center mb-6">Register</h2>

      <form action="../handler/register_handler.php" method="POST">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
          <!-- Username -->
          <div class="mb-4">
            <label class="block text-sm text-white mb-1">Username</label>
            <input type="text" name="username" placeholder="Masukkan Username" required
              class="w-full px-4 py-2 rounded-lg bg-white/30 text-white placeholder-white/70 border border-white/30 focus:outline-none focus:ring-2 focus:ring-blue-200" />
          </div>

          <!-- Password -->
          <div class="mb-4">
            <label class="block text-sm text-white mb-1">Password</label>
            <input type="password" name="password" placeholder="Masukkan Password" required
              class="w-full px-4 py-2 rounded-lg bg-white/30 text-white placeholder-white/70 border border-white/30 focus:outline-none focus:ring-2 focus:ring-blue-200" />
          </div>

          <!-- Nama Lengkap -->
          <div class="mb-4">
            <label class="block text-sm text-white mb-1">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" placeholder="Masukkan Nama Lengkap" required
              class="w-full px-4 py-2 rounded-lg bg-white/30 text-white placeholder-white/70 border border-white/30 focus:outline-none focus:ring-2 focus:ring-blue-200" />
          </div>

          <!-- Role -->
          <div class="mb-4">
            <label class="block text-sm text-white mb-1">Role</label>
            <select name="role" required
              class="w-full px-4 py-2 rounded-lg bg-white/30 text-white border border-white/30 focus:outline-none focus:ring-2 focus:ring-blue-200">
              <option value="kasir" class="text-gray-800">Kasir</option>
              <option value="admin" class="text-gray-800">Admin</option>
            </select>
          </div>

          <!-- Kunci Unik -->
          <div class="mb-6 col-span-2">
            <label class="block text-sm text-white mb-1">Kunci Unik</label>
            <input type="password" name="kunci_unik" placeholder="Masukkan Kunci Unik" required
              class="w-full px-4 py-2 rounded-lg bg-white/30 text-white placeholder-white/70 border border-white/30 focus:outline-none focus:ring-2 focus:ring-blue-200" />
          </div>
        </div>

        <!-- Tombol Register -->
        <div class="mb-2">
          <button type="submit"
            class="w-full py-3 text-lg bg-gradient-to-r from-purple-700 via-purple-500 to-blue-500 text-white font-bold rounded-lg border border-white/30 shadow-lg transform scale-95 hover:scale-100 hover:ring-2 hover:ring-white/50 transition duration-300">
            Register
          </button>
        </div>

        <div class="mb-4 flex justify-center items-center text-sm space-x-1">
          <span class="text-white">Sudah terdaftar?</span>
          <a href="login-view.php" class="text-purple-700 no-underline hover:no-underline focus:no-underline active:no-underline">
            Masuk di sini
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