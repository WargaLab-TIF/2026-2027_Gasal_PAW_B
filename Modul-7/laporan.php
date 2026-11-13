<?php
include 'koneksi.php';

$tanggal_mulai = $_GET['tanggal_mulai'] ?? date('Y-m-01');
$tanggal_selesai = $_GET['tanggal_selesai'] ?? date('Y-m-d');

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
    die("Rentang tanggal tidak valid!");
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

while ($row = mysqli_fetch_assoc($result)) {
    $data_laporan[] = $row;
}

$query_ringkasan = mysqli_prepare($conn, "
    SELECT
        COUNT(DISTINCT pelanggan_id) AS total_pelanggan,
        COALESCE(SUM(total), 0) AS total_pendapatan
    FROM transaksi
    WHERE waktu_transaksi BETWEEN ? AND ?
");

mysqli_stmt_bind_param(
    $query_ringkasan,
    "ss",
    $tanggal_mulai,
    $tanggal_selesai
);

mysqli_stmt_execute($query_ringkasan);

$result_ringkasan = mysqli_stmt_get_result($query_ringkasan);

$ringkasan = mysqli_fetch_assoc($result_ringkasan);

$total_pelanggan = $ringkasan['total_pelanggan'];
$total_pendapatan = $ringkasan['total_pendapatan'];

$label_tanggal = [];
$data_pendapatan = [];

foreach ($data_laporan as $data) {

    $label_tanggal[] = date(
        'd-m-Y',
        strtotime($data['tanggal'])
    );

    $data_pendapatan[] = (int) $data['total_pendapatan'];
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reporting Penjualan</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 30px;
            color: #333;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        h2 {
            color: #333;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.08);
        }

        .filter {
            display: flex;
            gap: 15px;
            align-items: end;
            flex-wrap: wrap;
        }

        .form-group {
            flex: 1;
            min-width: 180px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="date"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button, .btn {
            padding: 9px 14px;
            color: white;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
            display: inline-block;
            font-size: 14px;
        }

        .tampilkan {
            background: #2878c8;
        }

        .cetak {
            background: #555;
        }

        .excel {
            background: #198754;
        }

        .ringkasan {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .box-ringkasan {
            background: white;
            padding: 25px;
            border-radius: 8px;
            border-left: 5px solid #2878c8;
            box-shadow: 0 2px 5px rgba(0,0,0,0.08);
        }

        .box-ringkasan h3 {
            font-size: 15px;
            color: #777;
        }

        .box-ringkasan p {
            font-size: 24px;
            font-weight: bold;
            color: #2878c8;
        }

        .grafik {
            position: relative;
            width: 100%;
            height: 350px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        th {
            background: #2878c8;
            color: white;
        }

        tr:nth-child(even) {
            background: #f4f6f9;
        }

        .aksi {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }

        .periode {
            margin-bottom: 15px;
        }

        .kosong {
            padding: 20px;
            color: #777;
        }

        @media (max-width: 600px) {
            body {
                margin: 15px;
            }

            .ringkasan {
                grid-template-columns: 1fr;
            }

            .filter {
                flex-direction: column;
                align-items: stretch;
            }
        }

        @media print {
            body {
                background: white;
                margin: 10px;
            }

            .no-print {
                display: none !important;
            }

            .card, .box-ringkasan {
                box-shadow: none;
                border: 1px solid #ddd;
                break-inside: avoid;
            }

            .grafik {
                height: 300px;
            }

            th {
                background: #ddd !important;
                color: black !important;
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Reporting Laporan Penjualan</h2>

    <p>Laporan rekapitulasi data penjualan</p>

    <div class="card no-print">

        <h3>Filter Laporan</h3>

        <form method="GET" class="filter">

            <div class="form-group">

                <label>Tanggal Mulai</label>

                <input
                    type="date"
                    name="tanggal_mulai"
                    value="<?= htmlspecialchars($tanggal_mulai); ?>"
                    max="<?= date('Y-m-d'); ?>"
                    required
                >

            </div>

            <div class="form-group">

                <label>Tanggal Selesai</label>

                <input
                    type="date"
                    name="tanggal_selesai"
                    value="<?= htmlspecialchars($tanggal_selesai); ?>"
                    max="<?= date('Y-m-d'); ?>"
                    required
                >

            </div>

            <button type="submit" class="tampilkan">
                Tampilkan
            </button>

        </form>

    </div>

    <div class="ringkasan">

        <div class="box-ringkasan">

            <h3>Jumlah Pelanggan Unik</h3>

            <p>
                <?= number_format($total_pelanggan, 0, ',', '.'); ?>
            </p>

        </div>

        <div class="box-ringkasan">

            <h3>Total Pendapatan Keseluruhan</h3>

            <p>
                Rp <?= number_format($total_pendapatan, 0, ',', '.'); ?>
            </p>

        </div>

    </div>

    <div class="card">

        <h3>Grafik Batang Penjualan Harian</h3>

        <div class="grafik">

            <canvas id="grafikPenjualan"></canvas>

        </div>

    </div>

    <div class="card">

        <h3>Rekapitulasi Data Penjualan Harian</h3>

        <div class="aksi no-print">

            <button
                type="button"
                onclick="window.print()"
                class="cetak"
            >
                Cetak
            </button>

            <a
                href="export_excel.php?tanggal_mulai=<?= urlencode($tanggal_mulai); ?>&tanggal_selesai=<?= urlencode($tanggal_selesai); ?>"
                class="btn excel"
            >
                Ekspor Excel
            </a>

        </div>

        <p class="periode">

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
                                Rp <?= number_format(
                                    $data['total_pendapatan'],
                                    0,
                                    ',',
                                    '.'
                                ); ?>
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
                        <td colspan="3" class="kosong">
                            Tidak ada transaksi pada periode ini.
                        </td>
                    </tr>

                <?php } ?>

            </tbody>

            <tfoot>

                <tr>

                    <th>Total</th>

                    <th>
                        Rp <?= number_format(
                            $total_pendapatan,
                            0,
                            ',',
                            '.'
                        ); ?>
                    </th>

                    <th>
                        <?= count($data_laporan); ?> Hari Transaksi
                    </th>

                </tr>

            </tfoot>

        </table>

    </div>

</div>

<script>

const labelTanggal = <?= json_encode($label_tanggal); ?>;

const dataPendapatan = <?= json_encode($data_pendapatan); ?>;

const ctx = document.getElementById('grafikPenjualan');

const grafikPenjualan = new Chart(ctx, {

    type: 'bar',

    data: {

        labels: labelTanggal,

        datasets: [{

            label: 'Total Pendapatan',

            data: dataPendapatan,

            backgroundColor: 'rgba(40, 120, 200, 0.7)',

            borderColor: 'rgba(40, 120, 200, 1)',

            borderWidth: 1

        }]

    },

    options: {

        responsive: true,

        maintainAspectRatio: false,

        scales: {

            x: {

                title: {
                    display: true,
                    text: 'Tanggal Transaksi'
                }

            },

            y: {

                beginAtZero: true,

                title: {
                    display: true,
                    text: 'Total Pendapatan (Rupiah)'
                },

                ticks: {

                    callback: function(value) {

                        return 'Rp ' +
                            value.toLocaleString('id-ID');

                    }

                }

            }

        },

        plugins: {

            tooltip: {

                callbacks: {

                    label: function(context) {

                        return 'Pendapatan: Rp ' +
                            context.raw.toLocaleString('id-ID');

                    }

                }

            }

        }

    }

});


window.addEventListener('beforeprint', function() {
    grafikPenjualan.resize();
});

window.addEventListener('afterprint', function() {
    grafikPenjualan.resize();
});

</script>

</body>
</html>