<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Aktivitas Klinik</title>
    <style>
        @page {
            margin: 25px 25px 35px 25px;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 8px;
            line-height: 1.3;
            color: #1f2937;
        }
        .header-container {
            border-bottom: 2px solid #1E3A8A;
            padding-bottom: 6px;
            margin-bottom: 8px;
        }
        .clinic-name {
            font-size: 14px;
            font-weight: bold;
            color: #1E3A8A;
            text-transform: uppercase;
            margin: 0;
        }
        .clinic-sub {
            font-size: 8px;
            color: #4b5563;
        }
        .section-title {
            font-size: 10px;
            font-weight: bold;
            color: #1E3A8A;
            text-transform: uppercase;
            margin: 10px 0 4px 0;
            padding-bottom: 2px;
            border-bottom: 1px solid #93c5fd;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        table.data-table th {
            background-color: #1E3A8A;
            color: #ffffff;
            font-weight: bold;
            font-size: 7.5px;
            text-transform: uppercase;
            padding: 4px 3px;
            border: 0.5px solid #1E3A8A;
            text-align: center;
        }
        table.data-table td {
            padding: 3px;
            border: 0.5px solid #e5e7eb;
            font-size: 7.5px;
        }
        table.data-table tr:nth-child(even) td {
            background-color: #f9fafb;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .font-bold { font-weight: bold; }
        .page-break { page-break-before: always; }
    </style>
</head>
<body>
    <div class="header-container">
        <table style="width: 100%;">
            <tr>
                <td>
                    <div class="clinic-name">{{ $company->name ?? 'Starkids Medical Center' }}</div>
                    <div class="clinic-sub">
                        {{ $company->companyDetail->address ?? ($company->description ?? '') }} | Telp: {{ $company->phone ?? '-' }}
                    </div>
                </td>
                <td style="text-align: right; vertical-align: middle;">
                    <div style="font-size: 11px; font-weight: bold; color: #111827;">LAPORAN AKTIVITAS KLINIK</div>
                    <div style="font-size: 8px; color: #6b7280;">Periode: {{ $period }} | Dicetak: {{ $generated_at }}</div>
                </td>
            </tr>
        </table>
    </div>

    {{-- SECTION 1: Kunjungan Klinik --}}
    <div class="section-title">1. Ringkasan Kunjungan Pasien</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 25px;">No</th>
                <th class="text-left">Kategori / Kelompok Pasien</th>
                <th style="width: 70px;">Laki-Laki</th>
                <th style="width: 70px;">Perempuan</th>
                <th style="width: 80px;">Total Kunjungan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($clinicVisitRows as $row)
                <tr>
                    <td class="text-center">{{ $row[0] }}</td>
                    <td class="text-left">{{ $row[1] }}</td>
                    <td class="text-center">{{ $row[2] }}</td>
                    <td class="text-center">{{ $row[3] }}</td>
                    <td class="text-center font-bold">{{ $row[4] }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Tidak ada data</td></tr>
            @endforelse
        </tbody>
    </table>

    {{-- SECTION 2: Top 10 Penyakit --}}
    <div class="section-title">2. 10 Besar Penyakit Terbanyak</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 25px;">No</th>
                <th style="width: 80px;">Kode ICD-10</th>
                <th class="text-left">Nama Penyakit / Diagnosa</th>
                <th style="width: 60px;">Laki-Laki</th>
                <th style="width: 60px;">Perempuan</th>
                <th style="width: 70px;">Total Kasus</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($topPainRows as $row)
                <tr>
                    <td class="text-center">{{ $row[0] }}</td>
                    <td class="text-center font-bold">{{ $row[1] }}</td>
                    <td class="text-left">{{ $row[2] }}</td>
                    <td class="text-center">{{ $row[3] }}</td>
                    <td class="text-center">{{ $row[4] }}</td>
                    <td class="text-center font-bold">{{ $row[5] }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Tidak ada data</td></tr>
            @endforelse
        </tbody>
    </table>

    {{-- SECTION 3: Morbiditas Pasien Rawat Jalan --}}
    <div class="page-break"></div>
    <div class="section-title">3. Distribusi Morbiditas Pasien Berdasarkan Golongan Umur & Jenis Kelamin</div>
    <table class="data-table">
        <thead>
            <tr>
                <th rowspan="2" style="width: 20px;">No</th>
                <th rowspan="2" style="width: 45px;">Kode</th>
                <th rowspan="2" class="text-left">Nama Penyakit</th>
                <th colspan="2">0-28 H</th>
                <th colspan="2">28H-1Th</th>
                <th colspan="2">1-4 Th</th>
                <th colspan="2">5-14 Th</th>
                <th colspan="2">15-24 Th</th>
                <th colspan="2">25-44 Th</th>
                <th colspan="2">45-59 Th</th>
                <th colspan="2">&gt;59 Th</th>
                <th colspan="2">Total Seks</th>
                <th rowspan="2" style="width: 35px;">Grand Total</th>
            </tr>
            <tr>
                <th>L</th><th>P</th>
                <th>L</th><th>P</th>
                <th>L</th><th>P</th>
                <th>L</th><th>P</th>
                <th>L</th><th>P</th>
                <th>L</th><th>P</th>
                <th>L</th><th>P</th>
                <th>L</th><th>P</th>
                <th>L</th><th>P</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($morbiditasRows as $row)
                <tr>
                    <td class="text-center">{{ $row[0] }}</td>
                    <td class="text-center font-bold">{{ $row[1] }}</td>
                    <td class="text-left">{{ $row[2] }}</td>
                    <td class="text-center">{{ $row[3] }}</td><td class="text-center">{{ $row[4] }}</td>
                    <td class="text-center">{{ $row[5] }}</td><td class="text-center">{{ $row[6] }}</td>
                    <td class="text-center">{{ $row[7] }}</td><td class="text-center">{{ $row[8] }}</td>
                    <td class="text-center">{{ $row[9] }}</td><td class="text-center">{{ $row[10] }}</td>
                    <td class="text-center">{{ $row[11] }}</td><td class="text-center">{{ $row[12] }}</td>
                    <td class="text-center">{{ $row[13] }}</td><td class="text-center">{{ $row[14] }}</td>
                    <td class="text-center">{{ $row[15] }}</td><td class="text-center">{{ $row[16] }}</td>
                    <td class="text-center">{{ $row[17] }}</td><td class="text-center">{{ $row[18] }}</td>
                    <td class="text-center font-bold">{{ $row[19] }}</td>
                    <td class="text-center font-bold">{{ $row[20] }}</td>
                    <td class="text-center font-bold" style="background-color: #dbeafe;">{{ $row[21] }}</td>
                </tr>
            @empty
                <tr><td colspan="22" class="text-center">Tidak ada data morbiditas</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>

