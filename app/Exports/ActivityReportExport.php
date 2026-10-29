<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ActivityReportExport implements WithMultipleSheets
{
    public function __construct(
        protected array $clinicVisitRows,
        protected array $topPainRows,
        protected array $morbiditasRows,
        protected string $periodName = ''
    ) {}

    public function sheets(): array
    {
        return [
            new GenericArrayExport(
                ['No', 'Kelompok / Kategori Kunjungan', 'Laki-Laki', 'Perempuan', 'Total Kunjungan'],
                $this->clinicVisitRows,
                'Kunjungan Klinik'
            ),
            new GenericArrayExport(
                ['No', 'Kode ICD-10', 'Nama Penyakit / Diagnosa', 'Laki-Laki', 'Perempuan', 'Total Kasus'],
                $this->topPainRows,
                'Top 10 Penyakit'
            ),
            new GenericArrayExport(
                [
                    'No',
                    'Kode ICD-10',
                    'Nama Penyakit',
                    '0-28 Hari (L)', '0-28 Hari (P)',
                    '28H-1Th (L)', '28H-1Th (P)',
                    '1-4 Th (L)', '1-4 Th (P)',
                    '5-14 Th (L)', '5-14 Th (P)',
                    '15-24 Th (L)', '15-24 Th (P)',
                    '25-44 Th (L)', '25-44 Th (P)',
                    '45-59 Th (L)', '45-59 Th (P)',
                    '>59 Th (L)', '>59 Th (P)',
                    'Total Laki-laki',
                    'Total Perempuan',
                    'Total Keseluruhan',
                ],
                $this->morbiditasRows,
                'Morbiditas Penyakit'
            ),
        ];
    }
}
