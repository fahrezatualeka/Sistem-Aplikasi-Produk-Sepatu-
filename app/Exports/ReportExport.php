<?php

namespace App\Exports;

use App\Models\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;

class ReportExport implements FromCollection, WithHeadings, WithEvents
{

    public function collection()
{
    $data = Report::latest()->get(); // urutan data

    // ambil data dari tabel report
    // Pastikan data berjumlah 6 dan mapping data
    return $data->map(function ($report, $index) {
        return [
            $index + 1,  // Menambahkan nomor urut (dimulai dari 1)
            $report->product->name ?? 'Produk tidak ditemukan',
            $report->category,
            $report->purchase_price,
            $report->sale_price,
            $report->stock,
            $report->profit,
            $report->$report->name ?? 'Tidak ada customer',
            $report->transaction_type ?? 'Tidak ada transaksi',
            $report->quantity,
            $report->subtotal,
            $report->date,
        ];
    });
}

public function headings(): array
{
    // Header kolom yang akan ditampilkan
    return [
        'No',
        'Nama Produk',
        'Kategori',
        'Harga Pembelian',
        'Harga Penjualan',
        'Stok',
        'Profit/Keuntungan',
        'Nama Customer',
        'Jenis Transaksi',
        'Jumlah',
        'Subtotal',
        'Tanggal'
    ];
}

public function registerEvents(): array
{
    return [
        AfterSheet::class => function (AfterSheet $event) {
            $sheet = $event->sheet;

            // menambahkan judul besar di atas header tabel (baris pertama)
            $sheet->mergeCells('A1:L1'); // menggabungkan sel A1 hingga E1
            $sheet->setCellValue('A1', 'Data Laporan Produk'); //,menetapkan judul
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
            $sheet->getStyle('A2:L2')->applyFromArray([
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
            foreach ($data as $report) {
                foreach ($report as $key => $value) {
                    $sheet->setCellValueByColumnAndRow($key + 1, $row, $value);
                }
                $row++;
            }

            // tambah style untuk data (baris ketiga dan seterusnya)
            $sheet->getStyle("A3:L" . ($row - 1))->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ]);

            // mengatur lebar kolom secaraotomatis
            foreach (range('A', 'L') as $columnID) {
                $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }
        },
    ];
}


}