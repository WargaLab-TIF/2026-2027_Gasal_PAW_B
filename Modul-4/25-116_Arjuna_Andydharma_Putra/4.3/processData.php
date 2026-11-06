<!DOCTYPE html>
<html>
<head>
    <title>Posted Data</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background-color: #f5f5f5; }
        .result { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); max-width: 500px; }
        h1 { color: #333; border-bottom: 2px solid #2196F3; padding-bottom: 10px; }
        p { margin: 8px 0; font-family: monospace; }
    </style>
</head>
<body>
    <div class="result">
        <h1>Posted data:</h1>
        <?php
        foreach ($_POST as $key => $value) {
            echo "<p>($key) => ($value)</p>";
        }
        // Contoh akses individual (opsional, sesuai contoh di modul):
        // $surname = $_POST['surname'];
        ?>
    </div>
</body>
</html>
