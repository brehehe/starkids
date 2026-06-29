<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persetujuan Tindakan Medis - {{ $transaction->code }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Arial', sans-serif; font-size: 14px; line-height: 1.5; color: #000; background: #f5f5f5; padding: 20px; display: flex; justify-content: center; }
        .container { width: 210mm; min-height: 297mm; background: #fff; padding: 20mm; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); }
        .header { border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; text-align: center; }
        .company-name { font-size: 20px; font-weight: bold; text-transform: uppercase; margin-bottom: 5px; }
        .company-address { font-size: 12px; }
        .title { text-align: center; font-size: 16px; font-weight: bold; text-decoration: underline; margin-bottom: 20px; text-transform: uppercase;}
        .content-section { margin-bottom: 20px; }
        .row { display: flex; margin-bottom: 8px; align-items: flex-end; }
        .label { width: 170px; flex-shrink: 0; }
        .colon { width: 15px; flex-shrink: 0; }
        .value { flex-grow: 1; min-height: 21px; }
        .blank-line { border-bottom: 1px solid #000; flex-grow: 1; height: 20px; }
        .blank-line-inline { display: inline-block; border-bottom: 1px solid #000; }
        .text-justify { text-align: justify; }
        .signature-area { margin-top: 50px; display: flex; justify-content: space-between; padding: 0 20px; }
        .signature-box { text-align: center; width: 250px; }
        
        .action-buttons { position: fixed; top: 20px; right: 20px; display: flex; gap: 10px; }
        .btn { padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; color: white; }
        .btn-print { background: #2196F3; }
        
        ol { margin-left: 20px; margin-top: 10px; margin-bottom: 10px; }
        li { margin-bottom: 5px; text-align: justify; }

        @media print {
            body { background: #fff; padding: 0; }
            .container { width: 100%; min-height: auto; padding: 10mm; box-shadow: none; }
            .action-buttons { display: none; }
        }
    </style>
</head>
<body>
    <div class="action-buttons">
        <button class="btn btn-print" onclick="window.print()">Cetak Persetujuan</button>
    </div>

    <div class="container">
        <div class="header">
            <div class="company-name">{{ $transaction->company->name ?? 'Klinik Mediction' }}</div>
            <div class="company-address">{{ $transaction->company->address ?? 'Alamat Klinik' }} | Telp: {{ $transaction->company->phone ?? '-' }}</div>
        </div>

        <div class="title">LEMBAR PERSETUJUAN TINDAKAN MEDIS<br>(INFORMED CONSENT)</div>

        <div class="content-section">
            <p style="margin-bottom: 15px;">Yang bertanda tangan di bawah ini:</p>
            <div class="row">
                <div class="label">Nama</div>
                <div class="colon">:</div>
                @if(isset($transaction->consent_signee['name']) && !empty($transaction->consent_signee['name']))
                    <div class="value" style="border-bottom: 1px solid #000;"><strong>{{ $transaction->consent_signee['name'] }}</strong></div>
                @else
                    <div class="blank-line"></div>
                @endif
            </div>
            <div class="row">
                <div class="label">Tanggal Lahir/Usia</div>
                <div class="colon">:</div>
                @if(isset($transaction->consent_signee['age_or_dob']) && !empty($transaction->consent_signee['age_or_dob']))
                    <div class="value" style="border-bottom: 1px solid #000;">{{ $transaction->consent_signee['age_or_dob'] }}</div>
                @else
                    <div class="blank-line"></div>
                    <div style="margin: 0 15px;">/</div>
                    <div class="blank-line" style="flex-grow: 0; width: 100px;"></div>
                    <div style="margin-left: 15px;">Tahun</div>
                @endif
            </div>
            <div class="row">
                <div class="label">Alamat</div>
                <div class="colon">:</div>
                @if(isset($transaction->consent_signee['address']) && !empty($transaction->consent_signee['address']))
                    <div class="value" style="border-bottom: 1px solid #000;">{{ $transaction->consent_signee['address'] }}</div>
                @else
                    <div class="blank-line"></div>
                @endif
            </div>
            <div class="row">
                <div class="label">No. Telepon / HP</div>
                <div class="colon">:</div>
                @if(isset($transaction->consent_signee['phone']) && !empty($transaction->consent_signee['phone']))
                    <div class="value" style="border-bottom: 1px solid #000;">{{ $transaction->consent_signee['phone'] }}</div>
                @else
                    <div class="blank-line"></div>
                @endif
            </div>
            <div class="row" style="margin-top: 15px;">
                <div class="label">Hubungan dgn Pasien</div>
                <div class="colon">:</div>
                @if(isset($transaction->consent_signee['relationship']) && !empty($transaction->consent_signee['relationship']))
                    <div class="value"><strong>{{ $transaction->consent_signee['relationship'] }}</strong></div>
                @else
                    <div class="value" style="display: flex; gap: 20px; flex-wrap: wrap;">
                        <label>[ &nbsp;&nbsp;&nbsp; ] Diri Sendiri</label>
                        <label>[ &nbsp;&nbsp;&nbsp; ] Suami/Istri</label>
                        <label>[ &nbsp;&nbsp;&nbsp; ] Orang Tua</label>
                        <label style="display: flex; align-items: flex-end;">[ &nbsp;&nbsp;&nbsp; ] Lainnya: <div class="blank-line-inline" style="width: 150px; margin-left: 10px; height: 18px;"></div></label>
                    </div>
                @endif
            </div>
        </div>

        <div class="content-section" style="margin-top: 30px;">
            <p style="margin-bottom: 15px;">Dengan ini menyatakan <strong>SESUNGGUHNYA MEMBERIKAN PERSETUJUAN</strong> untuk dilakukan Tindakan Medis terhadap pasien:</p>
            <div class="row">
                <div class="label">Nama Pasien</div>
                <div class="colon">:</div>
                <div class="value"><strong>{{ $transaction->patient->name ?? '-' }}</strong></div>
            </div>
            <div class="row">
                <div class="label">No Rekam Medis (RM)</div>
                <div class="colon">:</div>
                <div class="value">{{ $transaction->patient->userDetail->rm_number ?? '-' }}</div>
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
        </div>

        <div class="content-section" style="margin-top: 30px;">
            <p style="margin-bottom: 15px;">Tindakan medis yang akan dilakukan berupa:</p>
            <div style="padding-left: 20px;">
                @php
                    $actions = is_array($transaction->consent_actions) ? $transaction->consent_actions : [];
                    $actionCount = max(count($actions), 5); // Minimal 5 baris seperti format sebelumnya
                @endphp

                @for ($i = 0; $i < $actionCount; $i++)
                    <div style="display: flex; align-items: flex-end; margin-bottom: 20px;">
                        <div style="margin-right: 15px;">{{ $i + 1 }}.</div>
                        @if (isset($actions[$i]) && trim($actions[$i]) !== '')
                            <div class="value" style="border-bottom: 1px solid #000; padding: 0 10px; font-weight: bold;">
                                {{ $actions[$i] }}
                            </div>
                        @else
                            <div class="blank-line"></div>
                        @endif
                    </div>
                @endfor
            </div>
        </div>

        <div class="content-section text-justify" style="margin-top: 30px;">
            <p>Saya menyatakan bahwa:</p>
            <ol>
                <li>Saya telah menerima penjelasan dari dokter <strong>{{ $transaction->doctor->name ?? '-' }}</strong> mengenai diagnosis penyakit, tujuan tindakan medis, alternatif pengobatan, risiko, dan kemungkinan komplikasi yang dapat terjadi.</li>
                <li>Saya telah memahami sepenuhnya penjelasan tersebut dan merasa puas dengan jawaban serta informasi yang diberikan.</li>
                <li>Saya memberikan wewenang kepada dokter dan tim medis yang ditunjuk untuk melakukan tindakan medis tersebut sebagaimana perlunya dalam penanganan kondisi pasien.</li>
            </ol>
            <p style="margin-top: 15px;">Demikian surat persetujuan tindakan medis ini saya buat dengan penuh kesadaran dan tanpa paksaan dari pihak mana pun.</p>
        </div>

        <div class="signature-area">
            <div class="signature-box">
                <div>Yang Menyatakan,</div>
                <div>(Pasien/Keluarga Pasien)</div>
                <div style="margin-top: 80px; display: flex; justify-content: center; align-items: center;">
                    (<div class="blank-line-inline" style="width: 200px; margin: 0 5px;"></div>)
                </div>
            </div>
            <div class="signature-box">
                <div>Dokter Pelaksana Tindakan,</div>
                <div><br></div>
                <div style="margin-top: 80px;">
                    @if(isset($transaction->doctor->name))
                        <strong><u style="text-underline-offset: 4px;">{{ $transaction->doctor->name }}</u></strong>
                    @else
                        <div style="display: flex; justify-content: center; align-items: center;">
                            (<div class="blank-line-inline" style="width: 200px; margin: 0 5px;"></div>)
                        </div>
                    @endif
                </div>
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
