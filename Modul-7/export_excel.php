<?php
include 'koneksi.php';

$tanggal_mulai = $_GET['tanggal_mulai'] ?? '';
$tanggal_selesai = $_GET['tanggal_selesai'] ?? '';

function tanggalValid($tanggal) {

    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal)) {
        return false;
    }

    $bagian = explode('-', $tanggal);

    return checkdate(
        (int) $bagian[1],
        (int) $bagian[2],
        (int) $bagian[0]
    );
}

if (
    !tanggalValid($tanggal_mulai) ||
    !tanggalValid($tanggal_selesai) ||
    $tanggal_mulai > $tanggal_selesai
) {
    die("Tanggal tidak valid!");
}

$query = mysqli_prepare($conn, "
    SELECT
        DATE(waktu_transaksi) AS tanggal,
        SUM(total) AS total_pendapatan
    FROM transaksi
    WHERE waktu_transaksi BETWEEN ? AND ?
    GROUP BY DATE(waktu_transaksi)
    ORDER BY tanggal ASC
");

mysqli_stmt_bind_param(
    $query,
    "ss",
    $tanggal_mulai,
    $tanggal_selesai
);

mysqli_stmt_execute($query);

$result = mysqli_stmt_get_result($query);

$data_laporan = [];

$total_pendapatan = 0;

while ($row = mysqli_fetch_assoc($result)) {

    $data_laporan[] = $row;

    $total_pendapatan += $row['total_pendapatan'];
}

$nama_file = "laporan_penjualan_" .
    $tanggal_mulai . "_" .
    $tanggal_selesai . ".xls";

header("Content-Type: application/vnd.ms-excel; charset=UTF-8");

header(
    "Content-Disposition: attachment; filename=\"$nama_file\""
);

header("Cache-Control: max-age=0");

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <title>Laporan Penjualan</title>

    <style>

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #2878c8;
            color: white;
        }

    </style>

</head>

<body>

    <h2>LAPORAN REKAPITULASI PENJUALAN</h2>

    <p>
        Periode:
        <?= date('d-m-Y', strtotime($tanggal_mulai)); ?>

        sampai

        <?= date('d-m-Y', strtotime($tanggal_selesai)); ?>
    </p>

    <table>

        <thead>

            <tr>
                <th>No</th>
                <th>Total Pendapatan</th>
                <th>Tanggal Transaksi</th>
            </tr>

        </thead>

        <tbody>

            <?php if (count($data_laporan) > 0) { ?>

                <?php $no = 1; ?>

                <?php foreach ($data_laporan as $data) { ?>

                    <tr>

                        <td>
                            <?= $no++; ?>
                        </td>

                        <td>
                            <?= $data['total_pendapatan']; ?>
                        </td>

                        <td>
                            <?= date(
                                'd-m-Y',
                                strtotime($data['tanggal'])
                            ); ?>
                        </td>

                    </tr>

                <?php } ?>

            <?php } else { ?>

                <tr>
                    <td colspan="3">
                        Tidak ada data penjualan.
                    </td>
                </tr>

            <?php } ?>

        </tbody>

        <tfoot>

            <tr>

                <th>Total Pendapatan</th>

                <th>
                    <?= $total_pendapatan; ?>
                </th>

                <th>
                    <?= count($data_laporan); ?> Hari Transaksi
                </th>

            </tr>

        </tfoot>

    </table>

</body>

</html>