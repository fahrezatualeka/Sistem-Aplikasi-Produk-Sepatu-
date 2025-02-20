<?php

namespace App\Exports;

use App\Models\ReportPurchase;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;

class ReportPurchaseExport implements FromCollection, WithHeadings, WithEvents
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
{
    return $this->data->map(function ($report_purchase, $index) {
        return [
            $index + 1,  // Menambahkan nomor urut (dimulai dari 1)
            $report_purchase->brand->name,
            $report_purchase->category->name,
            $report_purchase->product->name,
            $report_purchase->name,
            'Rp' . number_format($report_purchase->purchase_price, 0, ',', '.'),
            'Rp' . number_format($report_purchase->sale_price, 0, ',', '.'),
            $report_purchase->quantity,
            'Rp' . number_format($report_purchase->subtotal, 0, ',', '.'),
            'Rp' . number_format($report_purchase->profit, 0, ',', '.'),
            \Carbon\Carbon::parse($report_purchase->date)->locale('id')->isoFormat('D MMMM YYYY'),
        ];
    });
}

public function headings(): array
{
    // Header kolom yang akan ditampilkan
    return [
        'No',
        'Brand',
        'Kategori',
        'Produk',
        'Pemasok',
        'Harga Pembelian',
        'Harga Penjualan',
        'Jumlah',
        'Subtotal',
        'Profit/Keuntungan',
        'Tanggal Pembelian'
    ];
}

public function registerEvents(): array
{
    return [
        AfterSheet::class => function (AfterSheet $event) {
            $sheet = $event->sheet;

            // menambahkan judul besar di atas header tabel (baris pertama)
            $sheet->mergeCells('A1:K1'); // menggabungkan sel A1 hingga E1
            $sheet->setCellValue('A1', 'Data Laporan Pembelian Produk'); //,menetapkan judul
            // menambahkan style pada judul
            $sheet->getStyle('A1')->applyFromArray([
                'font' => [
                    'size' => 16,
                    'bold' => true,
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ]);

            // mengatur tinggi baris pertama (judul) agar terlihat lebih baik
            $sheet->getRowDimension(1)->setRowHeight(20); // baris untuk judul

            // menambahkan header kolom pada baris kedua
            $headers = $this->headings();
            foreach ($headers as $key => $value) {
                $sheet->setCellValueByColumnAndRow($key + 1, 2, $value); // tamba heading pada baris 2
            }

            // menambahkan style untuk header kolom (baris kedua)
            $sheet->getStyle('A2:K2')->applyFromArray([
                'font' => [
                    'bold' => true,
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ]);

            // mengatur  tinggi baris kedua (header) agar terlihat lebih baik
            $sheet->getRowDimension(2)->setRowHeight(20); // Baris untuk header kolom

            // menambahkan data pada baris ketiga dan seterusnya
            $data = $this->collection();  // Ambil data yang sudah dimapping

            // menambah data ke dalam sheet dimulai dari baris ketiga
            $row = 3; // baris pertama untuk data dimulai  di baris 3
            foreach ($data as $report_purchase) {
                foreach ($report_purchase as $key => $value) {
                    $sheet->setCellValueByColumnAndRow($key + 1, $row, $value);
                }
                $row++;
            }

            // tambah style untuk data (baris ketiga dan seterusnya)
            $sheet->getStyle("A3:K" . ($row - 1))->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ]);

            // mengatur lebar kolom secaraotomatis
            foreach (range('A', 'K') as $columnID) {
                $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }
        },
    ];
}


}