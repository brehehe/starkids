<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        @page {
            margin: 28px 30px 40px 30px;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #1f2937;
        }
        .header-container {
            border-bottom: 2px solid #1E3A8A;
            padding-bottom: 8px;
            margin-bottom: 12px;
        }
        .clinic-name {
            font-size: 16px;
            font-weight: bold;
            color: #1E3A8A;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
        }
        .clinic-sub {
            font-size: 9px;
            color: #4b5563;
            margin-top: 2px;
        }
        .report-title-section {
            margin-bottom: 12px;
        }
        .report-title {
            font-size: 13px;
            font-weight: bold;
            color: #111827;
            text-transform: uppercase;
            margin: 0 0 3px 0;
        }
        .report-meta {
            font-size: 9px;
            color: #6b7280;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table.data-table th {
            background-color: #1E3A8A;
            color: #ffffff;
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            padding: 6px 5px;
            border: 0.5px solid #1E3A8A;
            text-align: left;
        }
        table.data-table td {
            padding: 5px;
            border: 0.5px solid #e5e7eb;
            font-size: 9px;
            vertical-align: top;
        }
        table.data-table tr:nth-child(even) td {
            background-color: #f9fafb;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .font-bold {
            font-weight: bold;
        }
        .total-row td {
            background-color: #e0e7ff !important;
            font-weight: bold;
            color: #1e3a8a;
            border-top: 1.5px solid #1e3a8a;
            border-bottom: 1.5px solid #1e3a8a;
        }
        .empty-row td {
            text-align: center;
            color: #9ca3af;
            padding: 15px;
            font-style: italic;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 10px;
        }
        .meta-table td {
            vertical-align: top;
            font-size: 9px;
        }
    </style>
</head>
<body>
    <div class="header-container">
        <table style="width: 100%;">
            <tr>
                <td style="vertical-align: middle;">
                    <div class="clinic-name">{{ $company->name ?? 'Starkids Medical Center' }}</div>
                    <div class="clinic-sub">
                        {{ $company->companyDetail->address ?? ($company->description ?? '') }}
                        @if(!empty($company->phone)) | Telp: {{ $company->phone }} @endif
                        @if(!empty($company->email)) | Email: {{ $company->email }} @endif
                    </div>
                </td>
                <td style="text-align: right; vertical-align: middle;">
                    <span style="font-size: 8px; color: #9ca3af; text-transform: uppercase; font-weight: bold;">Dokumen Resmi</span>
                </td>
            </tr>
        </table>
    </div>

    <table class="meta-table">
        <tr>
            <td style="width: 65%;">
                <div class="report-title">{{ $title }}</div>
                @if(!empty($period))
                    <div class="report-meta"><strong>Periode:</strong> {{ $period }}</div>
                @endif
            </td>
            <td style="width: 35%; text-align: right;">
                <div class="report-meta"><strong>Dicetak pada:</strong> {{ $generated_at }}</div>
                <div class="report-meta"><strong>Oleh:</strong> {{ $user }}</div>
                <div class="report-meta"><strong>Total Data:</strong> {{ count($rows) }} baris</div>
            </td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                @foreach ($columns as $col)
                    @php
                        $headerText = is_array($col) ? ($col['label'] ?? '') : $col;
                        $align = is_array($col) ? ($col['align'] ?? 'left') : 'left';
                        $width = is_array($col) ? ($col['width'] ?? null) : null;
                    @endphp
                    <th class="text-{{ $align }}" @if($width) style="width: {{ $width }};" @endif>
                        {{ $headerText }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse ($rows as $row)
                <tr>
                    @foreach ($row as $cellIndex => $cell)
                        @php
                            $colDef = $columns[$cellIndex] ?? null;
                            $align = is_array($colDef) ? ($colDef['align'] ?? 'left') : 'left';
                        @endphp
                        <td class="text-{{ $align }}">{!! $cell !!}</td>
                    @endforeach
                </tr>
            @empty
                <tr class="empty-row">
                    <td colspan="{{ count($columns) }}">Tidak ada data yang ditemukan</td>
                </tr>
            @endforelse
        </tbody>
        @if (!empty($totals))
            <tfoot>
                <tr class="total-row">
                    @foreach ($totals as $totalIndex => $totalCell)
                        @php
                            $colDef = $columns[$totalIndex] ?? null;
                            $align = is_array($colDef) ? ($colDef['align'] ?? 'left') : 'left';
                        @endphp
                        <td class="text-{{ $align }}">{!! $totalCell !!}</td>
                    @endforeach
                </tr>
            </tfoot>
        @endif
    </table>
</body>
</html>

