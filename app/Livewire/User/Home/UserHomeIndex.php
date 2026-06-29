<?php

namespace App\Livewire\User\Home;

use App\Models\Company\Company;
use App\Models\Poly\Poly;
use App\Models\Transaction\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class UserHomeIndex extends Component
{
    // Booking form properties
    public $booking_name;

    public $booking_nik;

    public $booking_phone;

    public $booking_email;

    public $booking_birthdate;

    public $booking_gender;

    public $booking_address;

    public $booking_doctor;

    public $booking_date;

    public $booking_time;

    public $booking_notes;

    public $booking_agreement = false;

    // Selected booking data
    public $selected_branch_id;

    public $selected_poly_id;

    public $selected_doctor_id;

    public $selected_date;

    public $selected_time;

    // Company data
    public $company;

    public function mount()
    {
        // Get default company or first company
        $this->company = Company::with('companyDetail')->first();

        // Set minimum date for booking
        $this->booking_date = now()->addDay()->format('Y-m-d');
    }

    protected $rules = [
        'booking_name' => 'required|string|max:255',
        'booking_nik' => 'required|string|size:16|regex:/^[0-9]{16}$/',
        'booking_phone' => 'required|string|max:20',
        'booking_email' => 'nullable|email|max:255',
        'booking_birthdate' => 'required|date|before:today',
        'booking_gender' => 'required|in:L,P',
        'booking_address' => 'required|string|max:500',
        'booking_doctor' => 'required|exists:users,id',
        'booking_date' => 'required|date|after:today',
        'booking_time' => 'required',
        'booking_notes' => 'nullable|string|max:1000',
        'booking_agreement' => 'accepted',
    ];

    protected $messages = [
        'booking_name.required' => 'Nama lengkap wajib diisi',
        'booking_nik.required' => 'NIK wajib diisi',
        'booking_nik.size' => 'NIK harus 16 digit',
        'booking_nik.regex' => 'NIK hanya boleh berisi angka',
        'booking_phone.required' => 'Nomor telepon wajib diisi',
        'booking_email.email' => 'Format email tidak valid',
        'booking_birthdate.required' => 'Tanggal lahir wajib diisi',
        'booking_birthdate.before' => 'Tanggal lahir tidak valid',
        'booking_gender.required' => 'Jenis kelamin wajib dipilih',
        'booking_address.required' => 'Alamat wajib diisi',
        'booking_doctor.required' => 'Pilih dokter terlebih dahulu',
        'booking_date.required' => 'Tanggal konsultasi wajib dipilih',
        'booking_date.after' => 'Tanggal konsultasi minimal besok',
        'booking_time.required' => 'Waktu konsultasi wajib dipilih',
        'booking_agreement.accepted' => 'Anda harus menyetujui syarat dan ketentuan',
    ];

    public function submitBooking()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            // Create transaction for booking
            $transactionCode = 'BKG'.date('ymd').str_pad(
                Transaction::whereDate('created_at', Carbon::now())->count() + 1,
                4,
                '0',
                STR_PAD_LEFT
            );

            $doctor = User::findOrFail($this->booking_doctor);
            $poly = Poly::where('company_id', $this->company->id)->first();

            // Create booking transaction
            $transaction = Transaction::create([
                'code' => $transactionCode,
                'code_consultation' => 'ONLINE'.str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                'doctor_id' => $this->booking_doctor,
                'doctor_name' => $doctor->name,
                'poly_id' => $poly ? $poly->id : null,
                'poly_name' => $poly ? $poly->name : 'Online Consultation',
                'patient_name' => $this->booking_name,
                'patient_phone' => $this->booking_phone,
                'patient_email' => $this->booking_email,
                'date' => $this->booking_date,
                'time' => $this->booking_time,
                'notes' => $this->booking_notes,
                'type' => 'booking',
                'status' => 'pending_confirmation',
                'consultation' => 'yes',
                'type_customer' => 'online',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            // Reset form
            $this->reset([
                'booking_name',
                'booking_phone',
                'booking_email',
                'booking_doctor',
                'booking_time',
                'booking_notes',
            ]);

            // Set next day as default
            $this->booking_date = now()->addDay()->format('Y-m-d');

            // Show success notification
            $this->dispatch('notification', [
                'type' => 'success',
                'message' => 'Booking berhasil! Kami akan menghubungi Anda untuk konfirmasi.',
            ]);

            // Send notification email/SMS (you can implement this)
            // $this->sendBookingNotification($transaction);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Booking submission error: '.$e->getMessage());

            $this->dispatch('notification', [
                'type' => 'error',
                'message' => 'Terjadi kesalahan. Silakan coba lagi.',
            ]);
        }
    }

    private function getBranches()
    {
        return [
            [
                'id' => 1,
                'name' => 'Klinik Sehat Mandiri Pusat',
                'city' => 'Jakarta Pusat',
                'address' => 'Jl. Sudirman No. 123, Jakarta Pusat',
                'phone' => '(021) 1234-5678',
                'image' => asset('img/branch-1.jpg'),
                'hours' => 'Senin - Sabtu: 08:00 - 20:00',
                'distance' => '2.5 km',
                'specialties' => ['Umum', 'Anak', 'Mata'],
            ],
            [
                'id' => 2,
                'name' => 'Klinik Sehat Mandiri Selatan',
                'city' => 'Jakarta Selatan',
                'address' => 'Jl. Kemang Raya No. 456, Jakarta Selatan',
                'phone' => '(021) 2345-6789',
                'image' => asset('img/branch-2.jpg'),
                'hours' => 'Senin - Sabtu: 08:00 - 20:00',
                'distance' => '3.8 km',
                'specialties' => ['Umum', 'Jantung', 'Bedah'],
            ],
            [
                'id' => 3,
                'name' => 'Klinik Sehat Mandiri Utara',
                'city' => 'Jakarta Utara',
                'address' => 'Jl. Pantai Indah No. 789, Jakarta Utara',
                'phone' => '(021) 3456-7890',
                'image' => asset('img/branch-3.jpg'),
                'hours' => 'Senin - Sabtu: 08:00 - 20:00',
                'distance' => '5.2 km',
                'specialties' => ['Umum', 'Kulit', 'THT'],
            ],
        ];
    }

    private function getPolies()
    {
        return [
            [
                'id' => 1,
                'name' => 'Poli Umum',
                'description' => 'Pemeriksaan kesehatan umum dan konsultasi medis',
                'icon' => 'fas fa-user-md',
                'doctor_count' => 5,
                'avg_duration' => 15,
                'price' => 100000,
            ],
            [
                'id' => 2,
                'name' => 'Poli Anak',
                'description' => 'Pemeriksaan dan perawatan kesehatan anak',
                'icon' => 'fas fa-baby',
                'doctor_count' => 3,
                'avg_duration' => 20,
                'price' => 120000,
            ],
            [
                'id' => 3,
                'name' => 'Poli Mata',
                'description' => 'Pemeriksaan dan perawatan mata',
                'icon' => 'fas fa-eye',
                'doctor_count' => 2,
                'avg_duration' => 25,
                'price' => 150000,
            ],
            [
                'id' => 4,
                'name' => 'Poli Jantung',
                'description' => 'Pemeriksaan dan perawatan jantung',
                'icon' => 'fas fa-heartbeat',
                'doctor_count' => 2,
                'avg_duration' => 30,
                'price' => 200000,
            ],
            [
                'id' => 5,
                'name' => 'Poli Kulit',
                'description' => 'Pemeriksaan dan perawatan kulit',
                'icon' => 'fas fa-hand-paper',
                'doctor_count' => 2,
                'avg_duration' => 20,
                'price' => 130000,
            ],
            [
                'id' => 6,
                'name' => 'Poli THT',
                'description' => 'Pemeriksaan telinga, hidung, dan tenggorokan',
                'icon' => 'fas fa-head-side-mask',
                'doctor_count' => 2,
                'avg_duration' => 25,
                'price' => 140000,
            ],
        ];
    }

    private function getDoctorSchedules()
    {
        return [
            [
                'id' => 1,
                'name' => 'Dr. Ahmad Santoso, Sp.PD',
                'specialization' => 'Dokter Spesialis Penyakit Dalam',
                'experience' => '15 tahun pengalaman',
                'photo' => asset('img/doctor-1.jpg'),
                'rating' => 4.8,
                'reviews' => 150,
                'consultation_fee' => 200000,
                'available_times' => [
                    ['time' => '08:00', 'available_slots' => 3],
                    ['time' => '09:00', 'available_slots' => 2],
                    ['time' => '10:00', 'available_slots' => 4],
                    ['time' => '14:00', 'available_slots' => 3],
                    ['time' => '15:00', 'available_slots' => 2],
                    ['time' => '16:00', 'available_slots' => 1],
                ],
            ],
            [
                'id' => 2,
                'name' => 'Dr. Sari Wulandari, Sp.A',
                'specialization' => 'Dokter Spesialis Anak',
                'experience' => '12 tahun pengalaman',
                'photo' => asset('img/doctor-2.jpg'),
                'rating' => 4.9,
                'reviews' => 200,
                'consultation_fee' => 180000,
                'available_times' => [
                    ['time' => '08:00', 'available_slots' => 2],
                    ['time' => '09:00', 'available_slots' => 3],
                    ['time' => '10:00', 'available_slots' => 2],
                    ['time' => '13:00', 'available_slots' => 4],
                    ['time' => '14:00', 'available_slots' => 3],
                    ['time' => '15:00', 'available_slots' => 2],
                ],
            ],
            [
                'id' => 3,
                'name' => 'Dr. Budi Hartono, Sp.M',
                'specialization' => 'Dokter Spesialis Mata',
                'experience' => '10 tahun pengalaman',
                'photo' => asset('img/doctor-3.jpg'),
                'rating' => 4.7,
                'reviews' => 120,
                'consultation_fee' => 220000,
                'available_times' => [
                    ['time' => '09:00', 'available_slots' => 2],
                    ['time' => '10:00', 'available_slots' => 3],
                    ['time' => '11:00', 'available_slots' => 2],
                    ['time' => '14:00', 'available_slots' => 3],
                    ['time' => '15:00', 'available_slots' => 2],
                    ['time' => '16:00', 'available_slots' => 1],
                ],
            ],
        ];
    }

    private function getServices()
    {
        return [
            [
                'id' => 1,
                'name' => 'Konsultasi Umum',
                'description' => 'Pemeriksaan kesehatan umum dengan dokter berpengalaman',
                'icon' => 'fas fa-stethoscope',
                'price' => 150000,
            ],
            [
                'id' => 2,
                'name' => 'Pemeriksaan Laboratorium',
                'description' => 'Berbagai tes laboratorium dengan hasil akurat',
                'icon' => 'fas fa-flask',
                'price' => 200000,
            ],
            [
                'id' => 3,
                'name' => 'Medical Check Up',
                'description' => 'Pemeriksaan kesehatan menyeluruh untuk deteksi dini',
                'icon' => 'fas fa-heart',
                'price' => 500000,
            ],
            [
                'id' => 4,
                'name' => 'Konsultasi Spesialis',
                'description' => 'Konsultasi dengan dokter spesialis sesuai kebutuhan',
                'icon' => 'fas fa-user-md',
                'price' => 300000,
            ],
            [
                'id' => 5,
                'name' => 'Farmasi',
                'description' => 'Penyediaan obat-obatan dengan resep dokter',
                'icon' => 'fas fa-pills',
                'price' => 50000,
            ],
            [
                'id' => 6,
                'name' => 'Home Care',
                'description' => 'Layanan kesehatan di rumah untuk kenyamanan Anda',
                'icon' => 'fas fa-home',
                'price' => 400000,
            ],
        ];
    }

    private function getDoctors()
    {
        // Get doctors from database or return sample data
        $doctors = User::where('type_user', 'doctor')
            ->where('company_id', $this->company->id ?? 1)
            ->select('id', 'name', 'email', 'phone')
            ->limit(6)
            ->get();

        if ($doctors->isEmpty()) {
            // Sample data if no doctors in database
            return [
                [
                    'id' => 1,
                    'name' => 'Dr. Ahmad Santoso, Sp.PD',
                    'specialization' => 'Spesialis Penyakit Dalam',
                    'experience' => '10+ tahun pengalaman',
                    'rating' => '4.9',
                    'reviews' => '150',
                    'photo' => asset('img/doctor1.jpg'),
                ],
                [
                    'id' => 2,
                    'name' => 'Dr. Sari Dewi, Sp.A',
                    'specialization' => 'Spesialis Anak',
                    'experience' => '8+ tahun pengalaman',
                    'rating' => '4.8',
                    'reviews' => '120',
                    'photo' => asset('img/doctor2.jpg'),
                ],
                [
                    'id' => 3,
                    'name' => 'Dr. Budi Hartono, Sp.OG',
                    'specialization' => 'Spesialis Kandungan',
                    'experience' => '12+ tahun pengalaman',
                    'rating' => '4.9',
                    'reviews' => '200',
                    'photo' => asset('img/doctor3.jpg'),
                ],
            ];
        }

        return $doctors->map(function ($doctor) {
            return [
                'id' => $doctor->id,
                'name' => $doctor->name,
                'specialization' => 'Dokter Umum',
                'experience' => '5+ tahun pengalaman',
                'rating' => '4.8',
                'reviews' => '100',
                'photo' => asset('img/doctor-placeholder.jpg'),
            ];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.user.home.user-home-index', [
            'services' => $this->getServices(),
            'doctors' => $this->getDoctors(),
            'branches' => $this->getBranches(),
            'polies' => $this->getPolies(),
            'doctorSchedules' => $this->getDoctorSchedules(),
            'company' => $this->company,
        ])->extends('layout.user.app');
    }
}
