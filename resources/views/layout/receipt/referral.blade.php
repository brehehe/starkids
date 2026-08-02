<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Rujukan - {{ $transaction->code }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Arial', sans-serif; font-size: 14px; line-height: 1.5; color: #000; background: #f5f5f5; padding: 20px; display: flex; justify-content: center; }
        .container { width: 210mm; min-height: 297mm; background: #fff; padding: 20mm; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); }
        .header { display: flex; align-items: center; gap: 15px; border-bottom: 3px solid #2563eb; padding-bottom: 12px; margin-bottom: 20px; text-align: left; }
        .logo-box { flex-shrink: 0; }
        .header-logo { max-height: 80px; width: auto; object-fit: contain; }
        .company-info { flex-grow: 1; }
        .company-name { font-size: 20px; font-weight: bold; color: #16a34a; margin-bottom: 3px; line-height: 1.2; text-transform: none; }
        .company-address, .company-contact, .company-city { font-size: 13px; font-weight: bold; color: #000; line-height: 1.3; }
        .title { text-align: center; font-size: 18px; font-weight: bold; text-decoration: underline; margin-bottom: 20px; }
        .content-section { margin-bottom: 20px; }
        .row { display: flex; margin-bottom: 8px; }
        .label { width: 150px; flex-shrink: 0; }
        .colon { width: 10px; flex-shrink: 0; }
        .value { flex-grow: 1; }
        .text-justify { text-align: justify; }
        .signature-area { margin-top: 50px; display: flex; justify-content: flex-end; }
        .signature-box { text-align: center; width: 250px; }
        .doctor-name { font-weight: bold; text-decoration: underline; margin-top: 80px; }
        
        .action-buttons { position: fixed; top: 20px; right: 20px; display: flex; gap: 10px; }
        .btn { padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; color: white; }
        .btn-print { background: #2196F3; }
        
        @media print {
            body { background: #fff; padding: 0; }
            .container { width: 100%; min-height: auto; padding: 10mm; box-shadow: none; }
            .action-buttons { display: none; }
        }
    </style>
</head>
<body>
    <div class="action-buttons">
        <button class="btn btn-print" onclick="window.print()">Cetak Surat Rujukan</button>
    </div>

    <div class="container">
        <div class="header">
            <div class="logo-box">
                @if (!empty($transaction->company?->logo))
                    <img src="{{ asset('storage/' . $transaction->company->logo) }}" alt="Logo" class="header-logo">
                @else
                    <img src="{{ asset('asset/img/logo-starkids.png') }}" alt="Logo" class="header-logo">
                @endif
            </div>
            <div class="company-info">
                <div class="company-name">{{ $transaction->company->name ?? 'Klinik Utama Starkids Medical Center' }}</div>
                @if(isset($transaction->company->companyDetail->address) || isset($transaction->company->address))
                    <div class="company-address">{{ $transaction->company->companyDetail->address ?? $transaction->company->address }}</div>
                @endif
                <div class="company-contact">
                    @if(!empty($transaction->company->phone)) Telp. {{ $transaction->company->phone }}. @endif
                    @if(!empty($transaction->company->email)) Email: {{ $transaction->company->email }} @endif
                </div>
                @if(isset($transaction->company->companyDetail->city) || isset($transaction->company->companyDetail->postal_code))
                    <div class="company-city">{{ trim(($transaction->company->companyDetail->city ?? '') . ' ' . ($transaction->company->companyDetail->postal_code ?? '')) }}</div>
                @endif
            </div>
        </div>

        <div class="title">SURAT RUJUKAN</div>

        <div class="content-section">
            <div class="row">
                <div class="label">Kepada Yth.</div>
                <div class="colon">:</div>
                <div class="value">
                    <strong>{{ $reference->doctor_name ?? '-' }}</strong><br>
                    di {{ $reference->hospital ?? '-' }}
                </div>
            </div>
            <div class="row" style="margin-top: 15px;">
                <div class="label">Tanggal Rujukan</div>
                <div class="colon">:</div>
                <div class="value">{{ $reference->date_refer ? \Carbon\Carbon::parse($reference->date_refer)->format('d F Y') : '-' }}</div>
            </div>
        </div>

        <div class="content-section">
            <p>Bersama surat ini, kami merujuk pasien di bawah ini:</p>
            <div class="row" style="margin-top: 10px;">
                <div class="label">Nama Pasien</div>
                <div class="colon">:</div>
                <div class="value">{{ $transaction->patient->name ?? '-' }}</div>
            </div>
            <div class="row">
                <div class="label">Tanggal Lahir/Usia</div>
                <div class="colon">:</div>
                <div class="value">
                    @if($transaction->patient && $transaction->patient->userDetail && $transaction->patient->userDetail->birth_date)
                        {{ \Carbon\Carbon::parse($transaction->patient->userDetail->birth_date)->format('d-m-Y') }} 
                        ({{ \Carbon\Carbon::parse($transaction->patient->userDetail->birth_date)->age }} thn)
                    @else
                        -
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="label">Jenis Kelamin</div>
                <div class="colon">:</div>
                <div class="value">
                    @if($transaction->patient && $transaction->patient->userDetail && $transaction->patient->userDetail->administrative_gender)
                        {{ $transaction->patient->userDetail->administrative_gender === 'male' ? 'Laki-Laki' : 'Perempuan' }}
                    @else
                        -
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="label">Alamat</div>
                <div class="colon">:</div>
                <div class="value">{{ $transaction->patient->userDetail->address ?? '-' }}</div>
            </div>
        </div>

        <div class="content-section" style="margin-top: 20px;">
            <p class="text-justify">
                <strong>Keterangan Rujukan:</strong><br><br>
                {!! nl2br(e($reference->description ?? '-')) !!}
            </p>
        </div>

        <div class="content-section" style="margin-top: 20px;">
            <p class="text-justify">Demikian surat rujukan ini dibuat untuk dapat dipergunakan sebagaimana mestinya. Atas bantuan dan kerjasamanya, kami ucapkan terima kasih.</p>
        </div>

        <div class="signature-area">
            <div class="signature-box">
                <div>Hormat Kami,</div>
                <div>Dokter Perujuk</div>
                <div class="doctor-name">{{ $transaction->doctor->name ?? '-' }}</div>
                <div>{{ $transaction->doctor->userDetail->str ? 'STR: '.$transaction->doctor->userDetail->str : '' }}</div>
            </div>
        </div>
    </div>
    
    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        }
    </script>
</body>
</html>
