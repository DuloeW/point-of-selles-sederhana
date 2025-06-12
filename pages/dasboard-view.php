<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dasboard</title>
    <link rel="stylesheet" href="../assets/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="flex w-full h-screen bg-gray-100">
    <?php include '../components/sidebar.php' ?>
    <div class="flex-1 flex flex-col gap-3">
        <div class="w-full h-16 p-3 pl-5 bg-white flex items-center justify-between shadow-md shadow-gray-200">
            <!-- header -->
             <p class="font-bold text-xl text-orange-500">Dashboard</p>
             <div class="text-neutral-600 text-right mr-3">
                <p class="font-bold">Kasir: <span>Mujianto</span></p>
                <p class="text-xs text-gray-500 font-semibold tracking-wider">12/6/2025</p>
             </div>
        </div>

        <!-- containner main content -->
        <main class="flex-1 flex flex-col space-y-6 w-full h-screen p-5 overflow-y-auto">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl p-6 text-white shadow-md shadow-gray-200 flex items-center justify-between">
                <div>
                    <p class="text-3xl font-bold">Selamat Datang, Mujianto!</p>
                    <p class="text-blue-100">Dashboard Kasir - Kamis, 12 Juni 2025</p>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold">11.23</p>
                    <p class="text-blue-100">Waktu Sekarang</p>
                </div>
            </div>

            <?php include '../components/card-informasi.php' ?>
        </main>
    </div>
</body>
</html>