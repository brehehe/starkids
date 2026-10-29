<div>
    <div class="prescription-container">
        <div class="watermark">COPY RESEP</div>

        <!-- Copy Indicator (Hidden by default, shown when needed) -->
        <div class="copy-indicator" style="display: none;">
            {{-- COPY RESEP --}}
        </div>

        <div class="content">
            @php
                $company = $company ?? ($transaction?->company ?? Auth::user()?->company);
            @endphp
            <!-- Header -->
            <div class="header">
                <div class="logo-section">
                    @if ($company?->logo)
                        <img src="{{ asset('storage/' . $company->logo) }}"
                            style="width: 175px; height: 75px; margin-left: 50px; object-fit: contain;" alt="Logo">
                    @else
                        <img src="{{ asset('asset/img/logo.png') }}"
                            style="width: 175px; height: 75px; margin-left: 50px; object-fit: contain;" alt="Logo">
                    @endif
                </div>

                <div class="title-section">
                    <div class="prescription-title">COPY RESEP</div>
                    <div class="document-type">Medical Prescription</div>
                </div>

                <div class="prescription-info">
                    <div class="prescription-number">No. RCP-2025-0001</div>
                    <div>Tanggal: {{ date('d/m/Y') }}</div>
                    <div>Waktu: {{ date('H:i:s') }}</div>
                    <div>Kode Konsultasi: POLI0001</div>
                </div>
            </div>

            <!-- Doctor Info -->
            <div class="doctor-info">
                <div class="doctor-card">
                    <div class="doctor-title">Dokter Pemeriksa</div>
                    <div class="doctor-details">
                        <div><strong>{{ $transaction->doctor?->name ?? '-' }}</strong></div>
                        <div>{{ $transaction->doctor?->userDetail?->specialization ?? '-' }}</div>
                        <div>SIP: {{ $transaction->doctor?->userDetail?->sip_number ?? '-' }}</div>
                        {{-- <div>STR: {{ $transaction->doctor?->userDetail?->license_number ?? '-' }}</div> --}}
                    </div>
                </div>

                <div class="doctor-card">
                    <div class="doctor-title">Poli/Klinik</div>
                    <div class="doctor-details">
                        <div><strong>{{ $transaction?->location?->name ?? ($company?->name ?? config('app.name')) }}</strong></div>
                        <div>{{ $company?->name ?? config('app.name') }}</div>
                        <div>{{ $company?->companyDetail?->address ?? '-' }}</div>
                        <div>{{ $company?->companyDetail?->city ?? '-' }},
                            {{ $company?->companyDetail?->postal_code ?? '' }}
                        </div>
                        <div>Telp: {{ $company?->phone ?? '-' }}</div>
                    </div>
                </div>
            </div>

            <!-- Patient Info -->
            <div class="patient-info">
                <div class="patient-title">Data Pasien</div>
                <div class="patient-details">
                    <div class="patient-row">
                        <div class="patient-label">Nama</div>
                        <div class="patient-colon">:</div>
                        <div class="patient-value">{{ $transaction->patient?->name ?? ($transaction->patient_name ?? '-') }}</div>
                    </div>
                    <div class="patient-row">
                        <div class="patient-label">Umur</div>
                        <div class="patient-colon">:</div>
                        <div class="patient-value">
                            @php
                                $birthDateStr = $transaction?->patient?->userDetail?->birth_date;
                                if ($birthDateStr) {
                                    $birthDate = Carbon\Carbon::parse($birthDateStr);
                                    $now = Carbon\Carbon::now();
                                    $years = $birthDate->diff($now)->y;
                                    $months = $birthDate->diff($now)->m;
                                    $days = $birthDate->diff($now)->d;
                                    $ageString = "{$years} tahun {$months} bulan {$days} hari";
                                } else {
                                    $ageString = '-';
                                }
                            @endphp

                            {{ $ageString }}
                        </div>
                    </div>
                    <div class="patient-row">
                        <div class="patient-label">Jenis Kelamin</div>
                        <div class="patient-colon">:</div>
                        <div class="patient-value">
                            {{ ($transaction->patient?->userDetail?->administrative_gender == 'male' ? 'Laki - Laki' : ($transaction->patient?->userDetail?->administrative_gender == 'female' ? 'Perempuan' : '-')) }}
                        </div>
                    </div>
                    <div class="patient-row">
                        <div class="patient-label">Alamat</div>
                        <div class="patient-colon">:</div>
                        <div class="patient-value">{{ $transaction->patient?->userDetail?->address ?? '-' }}</div>
                    </div>
                    <div class="patient-row">
                        <div class="patient-label">No. Telepon</div>
                        <div class="patient-colon">:</div>
                        <div class="patient-value">{{ $transaction->patient?->phone ?? '-' }}</div>
                    </div>
                    <div class="patient-row">
                        <div class="patient-label">Diagnosis</div>
                        <div class="patient-colon">:</div>
                        <div class="patient-value">
                            {{ $transactionDiagnosas?->assessment ?? ($transaction->diagnosis ?? '-') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Prescription Table -->
            <table class="prescription-table">
                <thead>
                    <tr>
                        <th class="no-col">No</th>
                        <th class="medicine-col">Nama Obat & Sediaan</th>
                        <th class="quantity-col">Jumlah</th>
                        <th>Aturan Pakai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaction->transactionRecipes as $recipe)
                        {{-- baris pertama untuk nomor, jumlah, aturan pakai --}}
                        <tr>
                            <td class="no-col" rowspan="{{ $recipe->transactionDetail->count() }}">
                                /R{{ $loop->iteration }}
                            </td>

                            {{-- ambil obat pertama --}}
                            @php $firstDetail = $recipe->transactionDetail->first(); @endphp
                            <td class="medicine-col">{{ $firstDetail->product->name ?? '-' }}</td>

                            <td class="quantity-col" rowspan="{{ $recipe->transactionDetail->count() }}">
                                {{ $recipe->numero_recipe ?? 0 }}
                            </td>
                            <td rowspan="{{ $recipe->transactionDetail->count() }}">
                                {{ $recipe->description ?? '-' }}
                            </td>
                        </tr>

                        {{-- looping sisa obat --}}
                        @foreach ($recipe->transactionDetail->skip(1) as $detail)
                            <tr>
                                <td class="medicine-col">{{ $detail->product->name ?? '-' }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>

            <!-- Bottom Section -->
            <div class="bottom-section" style="justify:end">
                <div class="signature-section text-right">
                    <div class="signature-location">
                        Surabaya, {{ Carbon\Carbon::now()->format('d F Y') }} <br>
                    </div>
                    <br>
                    <div class="signature-line"></div>
                </div>
            </div>
        </div>
        <!-- Action Buttons -->
        <div class="action-buttons"
            style="position: fixed; top: 20px; right: 20px; z-index: 1000; display: flex; gap: 10px;">
            <button onclick="printPrescription()" class="btn btn-print">
                <i class="fas fa-print"></i> Cetak
            </button>
            <button onclick="downloadPDF()" class="btn btn-download">
                <i class="fas fa-download"></i> Download
            </button>
        </div>
    </div>
</div>