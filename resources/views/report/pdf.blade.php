<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Produk</title>
    <style>
                @page {
            size: A4 landscape;
            margin: 5mm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }
        h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 5px;
            vertical-align: middle; /* Menyelaraskan teks secara vertikal */
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Laporan Produk</h2>
    <table>
        <thead>
            <tr>
                <th style="width: 0px">No</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga Pembelian</th>
                <th>Harga Penjualan</th>
                <th>Stok</th>
                <th>Profit/Keuntungan</th>
                <th>Nama Customer</th>
                <th>Jenis Transaksi</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $report)
                <tr>
                    <td >{{ $index + 1 }}</td>
                    <td>{{ $report->product->name ?? 'Produk tidak ditemukan' }}</td>

                            <td>{{ ucfirst($report->category) }}</td>
                            
                            <td>Rp {{ number_format($report->purchase_price, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($report->sale_price, 0, ',', '.') }}</td>
                            <td>{{ $report->stock }}</td>
                            <td>Rp {{ number_format($report->profit, 0, ',', '.') }}</td>
                            
                            
                            
                            <td>{{ $report->name ?? 'Tidak ada customer' }}</td>
                            <td>{{ $report->transaction_type ?? 'Tidak ada transaksi' }}</td>


                            <td>{{ $report->quantity }}</td>
                            <td>Rp {{ number_format($report->subtotal, 0, ',', '.') }}</td>
                            <td>{{ date('d-m-Y', strtotime($report->date)) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
