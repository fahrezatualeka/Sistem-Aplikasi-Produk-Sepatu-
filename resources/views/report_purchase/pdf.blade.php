<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Laporan Pembelian Produk</title>
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
            vertical-align: middle; /* menyelaraskan teks secara vertikal */
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Data Laporan Pembelian Produk</h2>
    <table>
        <thead>
            <tr>
                <th style="width: 0px">No</th>
                <th>Brand</th>
                <th>Kategori</th>
                <th>Produk</th>
                <th>Pemasok</th>
                <th>Harga Pembelian</th>
                <th>Harga Penjualan</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
                <th>Profit/Keuntungan</th>
                <th>Tanggal Pembelian</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $key => $report_purchase)
            <tr>
                <td>{{ $key + 1 }}</td>

                <td>{{ $report_purchase->brand->name}}</td>
                <td>{{ $report_purchase->category->name}}</td>
                <td>{{ $report_purchase->product->name}}</td>
                <td>{{ $report_purchase->name}}</td>

                
                <td>Rp{{ number_format($report_purchase->purchase_price, 0, ',', '.') }}</td>
                <td>Rp{{ number_format($report_purchase->sale_price, 0, ',', '.') }}</td>
                
                
                
                
                
                <td>{{ $report_purchase->quantity }}</td>
                <td>Rp{{ number_format($report_purchase->subtotal, 0, ',', '.') }}</td>
                <td>Rp{{ number_format($report_purchase->profit, 0, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($report_purchase->date)->locale('id')->isoFormat('D MMMM YYYY') }}</td>


                
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
