<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Penjualan</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            text-align: center;
        }
        .container {
            width: 100%;
            max-width: 400px;
            margin: auto;
            border: 1px solid #000;
            padding: 15px;
            text-align: left;
        }
        .header {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }
        .separator {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 5px;
        }
        .right {
            text-align: right;
        }
        .total {
            font-size: 16px;
            font-weight: bold;
        }
        .footer {
            margin-top: 10px;
            font-size: 12px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            Nota Penjualan
        </div>
        <div class="separator"></div>
        <table>
            <tr>
                <td>Tanggal</td>
                <td class="right">{{ \Carbon\Carbon::parse($data->date)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
            </tr>
            <tr>
                <td>Produk Sepatu</td>
                <td class="right">{{ $data->product->name }}</td>
            </tr>
            <tr>
                <td>Pelanggan</td>
                <td class="right">{{ $data->name }}</td>
            </tr>
            <tr>
                <td>Jumlah</td>
                <td class="right">{{ $data->quantity }} Produk</td>
            </tr>
            <tr>
                <td>Harga</td>
                <td class="right">Rp{{ number_format($data->price, 0, ',', '.') }}</td>
            </tr>
            <tr>
            
        </table>
        <div class="separator"></div>
        <table>
            <tr>
                <td class="total">Subtotal</td>
                <td class="right total">Rp{{ number_format($data->subtotal, 0, ',', '.') }}</td>
            </tr>
        </table>
        <div class="separator"></div>
        <div class="footer">
            Terima kasih telah melakukan penjualan produk.
        </div>
    </div>
</body>
</html>