<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <form action="../handler//register_handler.php" method="POST">
        <table>
            <tr>
                <td>User Name: </td>
                <td><input type="text" name="username"></td>
            </tr>
            <tr>
                <td>Pasword: </td>
                <td><input type="password" name="password"></td>
            </tr>
            <tr>
                <td>Nama Lengkap: </td>
                <td><input type="text" name="nama_lengkap"></td>
            </tr>
            <tr>
                <td>Role: </td>
                <td>
                    <select name="role" id="">
                        <option value="kasir" selected>Kasir</option>
                        <option value="admin">admin</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Status: </td>
                <td>
                    <select name="status" id="">
                        <option value="Inactive" selected>Inactive</option>
                        <option value="active">Active</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <button type="submit">Kirim</button>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>