<?php
session_start();

if (isset($_SESSION['id_user'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Aplikasi Penjualan</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f5f4fa;
            padding: 30px;
            color: #252b40;
        }

        h1 {
            color: #493b78;
            text-align: center;
        }

        h2 {
            color: #493b78;
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
        }

        th {
            background: #493b78;
            color: white;
            padding: 16px;
        }

        td {
            padding: 14px;
            text-align: center;
            border-bottom: 1px solid #eeeaf5;
        }

        tr:hover {
            background: #f0edfa;
        }

        a {
            display: inline-block;
            color: white;
            background: #8064c8;
            padding: 9px 15px;
            border-radius: 7px;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            background: #6248a5;
        }

        .no-print button {
            background: #8064c8;
            color: white;
            border: none;
            padding: 9px 15px;
            border-radius: 7px;
            cursor: pointer;
        }

        .no-print button:hover {
            background: #6248a5;
        }

        .no-print input[type="date"] {
            padding: 8px;
            border: 1px solid #8064c8;
            border-radius: 7px;
            color: #493b78;
            accent-color: #8064c8;
        }

        .no-print a {
            background: #8064c8;
        }

        .no-print a:hover {
            background: #6248a5;
        }       

        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>

</head>
<body>

    <h2>Login Aplikasi Penjualan</h2>

    <form action="proses_login.php" method="POST">
        <label>Username</label>
        <input type="text" name="username" required>

        <br><br>

        <label>Password</label>
        <input type="password" name="password" required>

        <br><br>

        <button type="submit">Login</button>
    </form>

</body>
</html>
