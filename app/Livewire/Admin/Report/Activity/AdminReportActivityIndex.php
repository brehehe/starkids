<?php

namespace App\Livewire\Admin\Report\Activity;

use App\Models\Company\Company;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionIcd10;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Livewire\Component;

class AdminReportActivityIndex extends Component
{
    public $selectedMonth;

    public $year;

    public $months = [
        'january' => 'Januari',
        'february' => 'Februari',
        'march' => 'Maret',
        'april' => 'April',
        'may' => 'Mei',
        'june' => 'Juni',
        'july' => 'Juli',
        'august' => 'Agustus',
        'september' => 'September',
        'october' => 'Oktober',
        'november' => 'November',
        'december' => 'Desember',
        'total' => 'Total',
    ];

    public $companies;

    public $activities = [];

    public function mount()
    {
        $this->selectedMonth = Str::lower(Carbon::now()->format('F'));
        $this->year = date('Y');
        $this->companies = Company::with(['companyDetail:id,company_id,address'])
            ->select('id', 'name', 'code', 'code_health_facility', 'pic_name', 'phone', 'email')
            ->first()
            ->toArray();
        $this->accumulateData();
    }

    public function selectMonth($month)
    {
        $this->selectedMonth = $month;
        $this->accumulateData();
    }

    public function updatedYear()
    {
        $this->accumulateData();
    }

    public function accumulateData()
    {
        $this->activities = [];

        $this->activities = [
            'pain_data' => [
                'pain_data' => $this->getPainData(),
                'top_pain_data' => $this->getTopPainData(),
            ],
            'clinic_visit_data' => $this->getClinicVisitData(),
        ];
    }

    public function getClinicVisitData()
    {
        // Date range
        if ($this->selectedMonth === 'total') {
            $dateRange = [
                Carbon::create($this->year)->startOfYear(),
                Carbon::create($this->year)->endOfYear(),
            ];
        } else {
            $monthNumber = array_search(
                strtolower($this->selectedMonth),
                array_map('strtolower', array_keys($this->months))
            ) + 1;

            $dateRange = [
                Carbon::create($this->year, $monthNumber)->startOfMonth(),
                Carbon::create($this->year, $monthNumber)->endOfMonth(),
            ];
        }

        // 🔑 FIRST VISIT MAP
        $firstVisitMap = Transaction::query()
            ->selectRaw('patient_id, MIN(created_at) as first_visit_at')
            ->groupBy('patient_id')
            ->pluck('first_visit_at', 'patient_id');

        $transactions = Transaction::with([
            'patient.userDetail',
            'transactionIcd10.icd10',
            'insurance',
        ])
            ->whereBetween('created_at', $dateRange)
            ->where('type', 'konsultasi')
            ->get();

        $rows = [
            1 => ['name' => 'Jumlah kunjungan rawat jalan ke Klinik', 'new_l' => 0, 'new_p' => 0, 'old_l' => 0, 'old_p' => 0],
            2 => ['name' => 'Jumlah kunjungan rawat inap ke klinik', 'new_l' => 0, 'new_p' => 0, 'old_l' => 0, 'old_p' => 0],
            3 => ['name' => 'Jumlah kunjungan pasien gangguan jiwa ke klinik', 'new_l' => 0, 'new_p' => 0, 'old_l' => 0, 'old_p' => 0],
            4 => ['name' => 'Jumlah kunjungan peserta JKN', 'new_l' => 0, 'new_p' => 0, 'old_l' => 0, 'old_p' => 0],
            5 => ['name' => 'Jumlah kunjungan peserta asuransi kesehatan lainnya', 'new_l' => 0, 'new_p' => 0, 'old_l' => 0, 'old_p' => 0],
        ];

        foreach ($transactions as $t) {
            if (! $t->patient || ! isset($firstVisitMap[$t->patient_id])) {
                continue;
            }

            $detail = $t->patient->userDetail;
            $gender = strtolower($detail->administrative_gender ?? $detail->sex ?? '');
            $isMale = in_array($gender, ['male', 'laki-laki', 'l', 'm']);

            // 🔑 NEW / OLD based on FIRST TRANSACTION
            $isNewVisit = $t->created_at->equalTo($firstVisitMap[$t->patient_id]);

            $increment = function ($row) use (&$rows, $isNewVisit, $isMale) {
                if ($isNewVisit) {
                    $isMale ? $rows[$row]['new_l']++ : $rows[$row]['new_p']++;
                } else {
                    $isMale ? $rows[$row]['old_l']++ : $rows[$row]['old_p']++;
                }
            };

            // 1. Rawat Jalan
            $increment(1);

            // 3. Gangguan Jiwa
            $hasMentalDisorder = $t->transactionIcd10->contains(
                fn ($item) => $item->icd10 && str_starts_with($item->icd10->code, 'F')
            );

            if ($hasMentalDisorder) {
                $increment(3);
            }

            // 4 & 5. Insurance
            $insName = strtolower($t->insurance?->name ?? '');

            if (str_contains($insName, 'bpjs') || str_contains($insName, 'jkn')) {
                $increment(4);
            } elseif ($t->insurance_id) {
                $increment(5);
            }
        }

        return collect($rows)->values();
    }

    public function getAllMonthsExportData()
    {
        $originalMonth = $this->selectedMonth;
        $allData = [];

        foreach ($this->months as $key => $label) {
            $this->selectedMonth = $key;

            // Header for Sheet
            $sheetRows = [];
            $sheetRows[] = ['LAPORAN BULANAN KEGIATAN KLINIK - '.strtoupper($label).' '.$this->year];
            $sheetRows[] = []; // Spacer

            // A. Data Umum
            $sheetRows[] = ['A. DATA UMUM'];
            $sheetRows[] = ['No', 'Uraian', 'Data'];
            $dataUmum = [
                'Nama Klinik' => $this->companies['name'] ?? '-',
                'Kode Faskes' => $this->companies['code_health_facility'] ?? '-',
                'Alamat Lengkap Klinik' => $this->companies['companyDetail']['address'] ?? '-',
                'Nama Pimpinan Klinik' => $this->companies['pic_name'] ?? '-',
                'Telepon/ Ponsel Klinik' => $this->companies['phone'] ?? '-',
                'e-mail Klinik' => $this->companies['email'] ?? '-',
                'Bulan & Tahun Pelaporan' => $label.' '.$this->year,
            ];
            $i = 1;
            foreach ($dataUmum as $k => $v) {
                $sheetRows[] = [$i++, $k, $v];
            }
            $sheetRows[] = [];

            // B. Data Kelahiran
            $sheetRows[] = ['B. DATA KELAHIRAN DI KLINIK'];
            $sheetRows[] = ['No', 'Nama Bayi', 'L/P', 'Nama Orang Tua', 'Alamat Lengkap', 'Tgl & Jam Lahir', 'Umur Kehamilan', 'BB/TB', 'Normal/Dirujuk'];
            $sheetRows[] = [];

            $sheetRows[] = ['Jumlah Bayi Baru Lahir Mendapat IMD', ''];
            $sheetRows[] = [];

            // C. Data Kematian
            $sheetRows[] = ['C. DATA KEMATIAN DI KLINIK'];
            $sheetRows[] = ['No', 'Nama', 'NIK', 'Umur', 'Alamat', 'L/P', 'Tgl Meninggal', 'Tempat', 'Sebab (Diagnosa)', 'Sebab (ICD 10)'];
            $sheetRows[] = [];

            // D. Data Kesakitan
            $sheetRows[] = ['D. DATA KESAKITAN DI KLINIK'];

            // D.1 Top 10
            $sheetRows[] = ['2. Data Kesakitan Terbanyak (Top 10)'];
            $sheetRows[] = ['No', 'Jenis Penyakit', 'ICD 10', 'L', 'P', 'Total'];

            $topPain = $this->getTopPainData();
            foreach ($topPain as $idx => $row) {
                $sheetRows[] = [$idx + 1, $row['icd10_name'], $row['icd10_code'], $row['total_male'], $row['total_female'], $row['total_cases']];
            }
            $sheetRows[] = [];

            // D.2 All Pain
            $sheetRows[] = ['1. Data Kesakitan Lengkap'];
            $sheetRows[] = ['No', 'Jenis Penyakit', 'ICD 10',
                '0-7hr(L+P)', '8-28hr(L+P)', '1-11bln(L+P)', '1-4th(L+P)', '5-9th(L+P)',
                '10-14th(L+P)', '15-19th(L+P)', '20-44th(L+P)', '45-59th(L+P)', '>59th(L+P)',
                'L', 'P', 'Total',
            ];

            $painData = $this->getPainData();
            foreach ($painData as $idx => $row) {
                $ag = $row['age_groups'];
                $sheetRows[] = [
                    $idx + 1,
                    $row['icd10_name'],
                    $row['icd10_code'],
                    $ag['0-7_days']['male'] + $ag['0-7_days']['female'],
                    $ag['8-28_days']['male'] + $ag['8-28_days']['female'],
                    $ag['1-11_months']['male'] + $ag['1-11_months']['female'],
                    $ag['1-4_years']['male'] + $ag['1-4_years']['female'],
                    $ag['5-9_years']['male'] + $ag['5-9_years']['female'],
                    $ag['10-14_years']['male'] + $ag['10-14_years']['female'],
                    $ag['15-19_years']['male'] + $ag['15-19_years']['female'],
                    $ag['20-44_years']['male'] + $ag['20-44_years']['female'],
                    $ag['45-59_years']['male'] + $ag['45-59_years']['female'],
                    $ag['above_59_years']['male'] + $ag['above_59_years']['female'],
                    $row['total_male'],
                    $row['total_female'],
                    $row['grand_total'],
                ];
            }
            $sheetRows[] = [];

            // E. DATA PELAYANAN KESEHATAN KLINIK
            $sheetRows[] = ['E. DATA PELAYANAN KESEHATAN KLINIK'];

            // E.1 Kunjungan
            $sheetRows[] = ['1. Data Kunjungan Klinik'];
            $sheetRows[] = ['No', 'Kegiatan', 'Kunjungan Baru (L)', 'Kunjungan Baru (P)', 'Kunjungan Lama (L)', 'Kunjungan Lama (P)'];

            $visits = $this->getClinicVisitData();
            $totalNewL = 0;
            $totalNewP = 0;
            $totalOldL = 0;
            $totalOldP = 0;

            foreach ($visits as $idx => $row) {
                $sheetRows[] = [$idx + 1, $row['name'], $row['new_l'], $row['new_p'], $row['old_l'], $row['old_p']];
                if ($idx < 2) {
                    $totalNewL += $row['new_l'];
                    $totalNewP += $row['new_p'];
                    $totalOldL += $row['old_l'];
                    $totalOldP += $row['old_p'];
                }
            }
            $sheetRows[] = ['', 'Total', $totalNewL, $totalNewP, $totalOldL, $totalOldP];
            $sheetRows[] = [];

            // Data Rujukan (No number in view)
            $sheetRows[] = ['Data Rujukan'];
            $sheetRows[] = ['No', 'Kegiatan', 'L', 'P'];
            $rujukanItems = [
                'Jumlah pasien yang dirujuk ke Puskesmas, klinik rawat inap (terkait Program Nasional)',
                'Jumlah pasien penyakit menular yang dirujuk ke Rumah Sakit',
                'Jumlah pasien penyakit tidak menular dirujuk ke Rumah Sakit',
                'Jumlah pasien yang dirujuk balik dari Puskesmas dan klinik rawat inap.',
                'Jumlah pasien yang dirujuk balik dari Rumah Sakit',
            ];
            foreach ($rujukanItems as $idx => $item) {
                $sheetRows[] = [$idx + 1, $item, '', ''];
            }
            $sheetRows[] = ['', 'Total', '0', '0'];
            $sheetRows[] = [];

            // E.2 Rawat Inap
            $sheetRows[] = ['2. Data Pasien Rawat Inap'];
            $sheetRows[] = ['No', 'Kegiatan', 'L', 'P'];
            $rawatInapItems = [
                'Jumlah pasien rawat inap',
                'Jumlah ibu hamil, melahirkan, nifas dengan gangguan kesehatan dirawat inap',
                'Jumlah anak berumur < 5 tahun sakit dirawat inap',
                'Jumlah pasien yang menderita cedera/ kecelakaan dirawat inap',
                'Jumlah pasien penyakit tidak menular dirawat inap',
                'Jumlah pasien yang keluar sembuh dari rawat inap Klinik',
            ];
            foreach ($rawatInapItems as $idx => $item) {
                $sheetRows[] = [$idx + 1, $item, '', ''];
            }
            $sheetRows[] = ['', 'Total', '0', '0'];
            $sheetRows[] = [];

            // E.3 KB
            $sheetRows[] = ['3. Data Pelayanan Keluarga Berencana'];
            $sheetRows[] = ['No', 'Kegiatan', 'Data'];
            $kbItems = [
                'Jumlah pelayanan IUD',
                'Jumlah pelayanan PIL KB',
                'Jumlah pelayanan kondom',
                'Jumlah pelayanan obat vaginal',
                'Jumlah pelayanan Metode Operasi Pria (MOP)',
                'Jumlah pelayanan Metode Operasi Wanita (MOW)',
                'Jumlah pelayanan suntik KB',
                'Jumlah pelayanan implant KB',
                'Lain-lain',
            ];
            foreach ($kbItems as $idx => $item) {
                $sheetRows[] = [$idx + 1, $item, ''];
            }
            $sheetRows[] = ['', 'Total', '0'];
            $sheetRows[] = [];

            // 4. Gigi
            $sheetRows[] = ['4. Data Pelayanan Kesehatan Gigi dan Mulut'];
            $sheetRows[] = ['No', 'Kegiatan', 'L', 'P'];
            $gigiItems = [
                'Jumlah penambalan gigi tetap',
                'Jumlah penambalan gigi sulung',
                'Jumlah pencabutan gigi tetap',
                'Jumlah pencabutan gigi sulung',
                'Jumlah pembersihan karang gigi',
                'Jumlah premedikasi/ pengobatan',
                'Jumlah pelayanan rujukan gigi',
                'Jumlah pemasangan gigi tiruan',
                'Lain-lain',
            ];
            foreach ($gigiItems as $idx => $item) {
                $sheetRows[] = [$idx + 1, $item, '', ''];
            }
            $sheetRows[] = ['', 'Total', '0', '0'];
            $sheetRows[] = [];

            // 5. Laboratorium
            $sheetRows[] = ['5. Data Pelayanan Laboratorium'];
            $sheetRows[] = ['No', 'Kegiatan', 'L', 'P'];
            $labItems = [
                'Jumlah pemeriksaan hematologi',
                'Jumlah pemeriksaan kimia klinik',
                'Jumlah pemeriksaan urinalisa',
                'Jumlah pemeriksaan mikrobiologi dan parasitologi',
                'Jumlah pemeriksaan imunologi',
                'Jumlah pemeriksaan tinja',
                'Lain-lain',
            ];
            foreach ($labItems as $idx => $item) {
                $sheetRows[] = [$idx + 1, $item, '', ''];
            }
            $sheetRows[] = ['', 'Total', '0', '0'];
            $sheetRows[] = [];

            // 6. Penunjang
            $sheetRows[] = ['6. Data Pelayanan Penunjang'];
            $sheetRows[] = ['No', 'Kegiatan', 'L', 'P'];
            $penunjangItems = [
                'Jumlah pemeriksaan radiologi',
                'Jumlah pemeriksaan USG',
                'Jumlah pelayanan rehabilitasi medik',
                'Jumlah pelayanan akupunktur medik',
                'Jumlah pelayanan treadmill',
                'Jumlah pelayanan terapi ozon',
                'Jumlah pelayanan terapi alternatif',
                'Lain-lain',
            ];
            foreach ($penunjangItems as $idx => $item) {
                $sheetRows[] = [$idx + 1, $item, '', ''];
            }
            $sheetRows[] = ['', 'Total', '0', '0'];
            $sheetRows[] = [];

            // 7. Farmasi
            $sheetRows[] = ['7. Data Pelayanan Kefarmasian'];
            $sheetRows[] = ['No', 'Kegiatan', 'Data'];
            $farmasiItems = [
                'Jumlah pengkajian dan pelayanan resep',
                'Jumlah konseling',
                'Jumlah Pelayanan Informasi Obat (PIO)',
            ];
            foreach ($farmasiItems as $idx => $item) {
                $sheetRows[] = [$idx + 1, $item, ''];
            }
            $sheetRows[] = ['', 'Total', '0'];
            $sheetRows[] = [];

            // 8. Estetika
            $sheetRows[] = ['8. Data Pelayanan Estetika'];
            $sheetRows[] = ['No', 'Kegiatan', 'L', 'P'];
            $estItems = [
                'Jumlah perawatan Akne',
                'Jumlah perawatan Parut Akne',
                'Jumlah perawatan Hiperpigmentasi',
                'Jumlah perawatan Penuaan Kulit',
                'Jumlah perawatan Nevus',
                'Jumlah perawatan Keratoris Seborik',
                'Jumlah perawatan Veruka/Kutil',
                'Jumlah perawatan Bau Badan',
                'Jumlah perawatan Hiperhidrosis',
                'Jumlah perawatan Selulit',
                'Jumlah perawatan Strecth Mark',
                'Jumlah perawatan Kerontokan Rambut',
                'Jumlah perawatan Ketombe',
                'Jumlah perawatan Keloid',
                'Jumlah perawatan Tatto',
                'Jumlah perawatan Hirsutisme',
                'Jumlah perawatan Obesitas',
                'Lain-lain',
            ];
            foreach ($estItems as $idx => $item) {
                $sheetRows[] = [$idx + 1, $item, '', ''];
            }
            $sheetRows[] = ['', 'Total', '0', '0'];
            $sheetRows[] = [];

            // 9. Tindakan Estetika
            $sheetRows[] = ['9. Data Tindakan Medik Pelayanan Estetika'];
            $sheetRows[] = ['No', 'Kegiatan', 'L', 'P'];
            $tindakanEstItems = [
                'Facial',
                '  a. manual',
                '  b. mekanik',
                '  c. elektrik',
                'Perawatan Badan',
                '  a. manual',
                '  b. mekanik',
                '  c. elektrik',
                'Dermabrasi',
                'Mikrodermabrasi',
                'Chemical Peeling',
                '  - superfisial',
                '  - medium',
                '  - deep',
                'Dengan Laser',
                'Dengan IPL',
                'Dengan LHE',
                'Dengan Cauter',
                'Filler Augmentasi',
                'Mesoterapi',
                'Tindakan Operasi',
                '  1. ...',
                '  2. ...',
                '  3. dst',
                'Liposuction',
                'Suntik Botox',
                'Implan',
                'Lain-lain',
            ];
            foreach ($tindakanEstItems as $idx => $item) {
                $sheetRows[] = [$idx + 1, $item, '', ''];
            }
            $sheetRows[] = ['', 'Total', '0', '0'];

            $allData[$label] = $sheetRows;
        }

        $this->selectedMonth = $originalMonth;

        return $allData;
    }

    public function getPainData()
    {
        // Check if total (all year) or specific month
        if ($this->selectedMonth === 'total') {
            $yearStart = Carbon::create($this->year, 1, 1)->startOfYear();
            $yearEnd = Carbon::create($this->year, 12, 31)->endOfYear();
            $dateRange = [$yearStart, $yearEnd];
        } else {
            // Convert month name to month number
            $monthNumber = array_search($this->selectedMonth, array_map('strtolower', array_keys($this->months))) + 1;
            $monthStart = Carbon::create($this->year, $monthNumber, 1)->startOfMonth();
            $monthEnd = $monthStart->copy()->endOfMonth();
            $dateRange = [$monthStart, $monthEnd];
        }

        $data = TransactionIcd10::with(['icd10', 'transaction.patient'])
            ->whereBetween('created_at', $dateRange)
            ->get()
            ->groupBy('icd10_id')
            ->map(function ($items, $icd10Id) {
                $icd10 = $items->first()->icd10;

                // Initialize age groups and gender counts
                $ageGroups = [
                    '0-7_days' => ['male' => 0, 'female' => 0],
                    '8-28_days' => ['male' => 0, 'female' => 0],
                    '1-11_months' => ['male' => 0, 'female' => 0],
                    '1-4_years' => ['male' => 0, 'female' => 0],
                    '5-9_years' => ['male' => 0, 'female' => 0],
                    '10-14_years' => ['male' => 0, 'female' => 0],
                    '15-19_years' => ['male' => 0, 'female' => 0],
                    '20-44_years' => ['male' => 0, 'female' => 0],
                    '45-59_years' => ['male' => 0, 'female' => 0],
                    'above_59_years' => ['male' => 0, 'female' => 0],
                ];

                foreach ($items as $item) {
                    if (! $item->transaction || ! $item->transaction->patient) {
                        continue;
                    }

                    $patient = $item->transaction->patient;
                    $patient_detail = $patient->userDetail;
                    $dob = $patient_detail->birth_date ?? $patient_detail->dob ?? null;
                    $gender = strtolower($patient_detail->administrative_gender ?? $patient_detail->sex ?? '');

                    if (! $dob) {
                        continue;
                    }

                    $birthDate = Carbon::parse($dob);
                    $ageInDays = $birthDate->diffInDays(now());
                    $ageInMonths = $birthDate->diffInMonths(now());
                    $ageInYears = $birthDate->diffInYears(now());

                    $genderKey = in_array($gender, ['male', 'laki-laki', 'l', 'm']) ? 'male' : 'female';

                    // Categorize by age group
                    if ($ageInDays <= 7) {
                        $ageGroups['0-7_days'][$genderKey]++;
                    } elseif ($ageInDays <= 28) {
                        $ageGroups['8-28_days'][$genderKey]++;
                    } elseif ($ageInMonths <= 11) {
                        $ageGroups['1-11_months'][$genderKey]++;
                    } elseif ($ageInYears <= 4) {
                        $ageGroups['1-4_years'][$genderKey]++;
                    } elseif ($ageInYears <= 9) {
                        $ageGroups['5-9_years'][$genderKey]++;
                    } elseif ($ageInYears <= 14) {
                        $ageGroups['10-14_years'][$genderKey]++;
                    } elseif ($ageInYears <= 19) {
                        $ageGroups['15-19_years'][$genderKey]++;
                    } elseif ($ageInYears <= 44) {
                        $ageGroups['20-44_years'][$genderKey]++;
                    } elseif ($ageInYears <= 59) {
                        $ageGroups['45-59_years'][$genderKey]++;
                    } else {
                        $ageGroups['above_59_years'][$genderKey]++;
                    }
                }

                // Calculate totals
                $totalMale = collect($ageGroups)->sum('male');
                $totalFemale = collect($ageGroups)->sum('female');

                return [
                    'icd10_code' => $icd10->code ?? '-',
                    'icd10_name' => $icd10->display ?? '-',
                    'age_groups' => $ageGroups,
                    'total_male' => $totalMale,
                    'total_female' => $totalFemale,
                    'grand_total' => $totalMale + $totalFemale,
                ];
            })
            ->values();

        return $data;
    }

    public function getTopPainData()
    {
        // Check if total (all year) or specific month
        if ($this->selectedMonth === 'total') {
            $yearStart = Carbon::create($this->year, 1, 1)->startOfYear();
            $yearEnd = Carbon::create($this->year, 12, 31)->endOfYear();
            $dateRange = [$yearStart, $yearEnd];
        } else {
            // Convert month name to month number
            $monthNumber = array_search($this->selectedMonth, array_map('strtolower', array_keys($this->months))) + 1;
            $monthStart = Carbon::create($this->year, $monthNumber, 1)->startOfMonth();
            $monthEnd = $monthStart->copy()->endOfMonth();
            $dateRange = [$monthStart, $monthEnd];
        }

        $data = TransactionIcd10::with(['icd10', 'transaction.patient.userDetail'])
            ->whereBetween('created_at', $dateRange)
            ->get()
            ->groupBy('icd10_id')
            ->map(function ($items) {
                $icd10 = $items->first()->icd10;

                $maleCount = 0;
                $femaleCount = 0;

                foreach ($items as $item) {
                    if (! $item->transaction || ! $item->transaction->patient) {
                        continue;
                    }

                    $patient = $item->transaction->patient;
                    $patient_detail = $patient->userDetail;
                    $gender = strtolower($patient_detail->administrative_gender ?? $patient_detail->sex ?? '');

                    if (in_array($gender, ['male', 'laki-laki', 'l', 'm'])) {
                        $maleCount++;
                    } else {
                        $femaleCount++;
                    }
                }

                return [
                    'icd10_code' => $icd10->code ?? '-',
                    'icd10_name' => $icd10->display ?? '-',
                    'total_male' => $maleCount,
                    'total_female' => $femaleCount,
                    'total_cases' => $maleCount + $femaleCount,
                ];
            })
            ->sortByDesc('total_cases')
            ->values();

        return $data;
    }

    public function render()
    {
        return view('livewire.admin.report.activity.admin-report-activity-index')
            ->extends('layout.app')
            ->section('content');
    }
}
