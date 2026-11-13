<?php
// Koneksi ke database MySQL (default XAMPP/Laragon: user root, password kosong)
// PHP 8.1+ melempar exception jika koneksi gagal, jadi dibungkus try/catch
try {
    $koneksi = mysqli_connect("localhost", "root", "", "penjualan");
} catch (mysqli_sql_exception $e) {
    die("Koneksi database gagal: " . htmlspecialchars($e->getMessage()) .
        "<br>Pastikan MySQL Laragon sudah Start dan file db_penjualan.sql sudah di-import.");
}
mysqli_set_charset($koneksi, "utf8mb4");

/**
 * Mengambil data laporan penjualan pada rentang tanggal tertentu.
 * Dipakai bersama oleh index.php (tampilan) dan export_excel.php (ekspor).
 */
function ambilLaporan($koneksi, $mulai, $selesai)
{
    $laporan = [
        'rekap'            => [],
        'total_pendapatan' => 0,
        'total_pelanggan'  => 0,
    ];

    // Agregasi total pendapatan per hari (SUM + GROUP BY DATE)
    $sql = "SELECT DATE(waktu_transaksi) AS tgl, SUM(total) AS total_harian
            FROM transaksi
            WHERE waktu_transaksi BETWEEN ? AND ?
            GROUP BY DATE(waktu_transaksi)
            ORDER BY tgl ASC";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $mulai, $selesai);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    while ($r = mysqli_fetch_assoc($res)) {
        $laporan['rekap'][] = $r;
        $laporan['total_pendapatan'] += (int) $r['total_harian'];
    }
    mysqli_stmt_close($stmt);

    // Jumlah pelanggan unik (COUNT DISTINCT)
    $sql = "SELECT COUNT(DISTINCT pelanggan_id) AS jml
            FROM transaksi
            WHERE waktu_transaksi BETWEEN ? AND ?";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $mulai, $selesai);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    $laporan['total_pelanggan'] = (int) ($row['jml'] ?? 0);
    mysqli_stmt_close($stmt);

    return $laporan;
}

// Validasi format tanggal (YYYY-MM-DD)
function tanggalValid($tgl)
{
    $d = DateTime::createFromFormat('Y-m-d', $tgl);
    return $d && $d->format('Y-m-d') === $tgl;
}
