<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ArmadaReportExport implements FromView, ShouldAutoSize, WithStyles
{
    public function __construct(
        private readonly string $view,
        private readonly array $data
    ) {
    }

    public function view(): View
    {
        return view($this->view, $this->data);
    }

    // Fitur tambahan: Otomatis merapikan lebar kolom
    public function styles(Worksheet $sheet)
    {
        return [
            // Menebalkan baris pertama (Header)
            1 => ['font' => ['bold' => true]],
        ];
    }
}
