<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h2>Laporan Transaksi</h2>
    <p>Periode: {{ request('tanggal_awal') }} - {{ request('tanggal_akhir') }}</p>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
                <th>Akun</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $t)
                <tr>
                    <td>{{ $t->tanggal }}</td>
                    <td>{{ ucfirst($t->jenis) }}</td>
                    <td>Rp{{ number_format($t->jumlah, 0, ',', '.') }}</td>
                    <td>{{ $t->keterangan }}</td>
                    <td>{{ $t->account->nama_akun }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
