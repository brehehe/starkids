<?php

namespace App\Http\Controllers\Admin\Prescription;

use App\Http\Controllers\Controller;
use App\Models\Transaction\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class PrescriptionController extends Controller
{
    /**
     * Display prescription view
     */
    public function show($transactionId)
    {
        try {
            $transaction = Transaction::with([
                'patient.company',
                'patient.userDetail',
                'doctor',
                'location',
                'poly',
                'transactionDetails' => function ($query) {
                    $query->whereIn('type_transaction', ['medicine', 'recipe']);
                },
            ])->findOrFail($transactionId);

            // Get prescription details
            $prescriptionData = $this->preparePrescriptionData($transaction);

            return view('layout.receipt.prescription', $prescriptionData);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Resep tidak ditemukan.');
        }
    }

    /**
     * Display copy prescription view
     */
    public function showCopy($transactionId)
    {

        try {
            $transaction = Transaction::with([
                'patient.company',
                'patient.userDetail',
                'doctor',
                'location',
                'poly',
                'transactionDetails' => function ($query) {
                    $query->whereIn('type_transaction', ['medicine', 'recipe']);
                },
            ])->findOrFail($transactionId);

            // Get prescription details
            $prescriptionData = $this->preparePrescriptionData($transaction);
            $prescriptionData['isCopy'] = true;

            return view('layout.receipt.prescription-copy', $prescriptionData);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Copy resep tidak ditemukan.');
        }
    }

    /**
     * Print prescription
     */
    public function print($transactionId)
    {
        try {
            $transaction = Transaction::with([
                'patient.company',
                'patient.userDetail',
                'doctor',
                'location',
                'poly',
                'transactionDetails' => function ($query) {
                    $query->whereIn('type_transaction', ['medicine', 'recipe']);
                },
            ])->findOrFail($transactionId);

            // Check if user has permission to print this prescription
            if (! $this->canViewPrescription($transaction)) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            // Get prescription details
            $prescriptionData = $this->preparePrescriptionData($transaction);

            return view('layout.receipt.prescription', $prescriptionData);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Prescription not found'], 404);
        }
    }

    /**
     * Print copy prescription
     */
    public function printCopy($transactionId)
    {
        try {
            $transaction = Transaction::with([
                'patient.company',
                'patient.userDetail',
                'doctor',
                'location',
                'poly',
                'transactionDetails' => function ($query) {
                    $query->whereIn('type_transaction', ['medicine', 'recipe']);
                },
            ])->findOrFail($transactionId);

            // Get prescription details
            $prescriptionData = $this->preparePrescriptionData($transaction);
            $prescriptionData['isCopy'] = true;

            return view('layout.receipt.prescription-copy', $prescriptionData);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Copy prescription not found'], 404);
        }
    }

    /**
     * Check if user can view prescription
     */
    private function canViewPrescription($transaction)
    {
        $user = Auth::user();

        // Super admin can view all prescriptions
        if ($user->hasRole('Super Admin')) {
            return true;
        }

        // Same company check
        if ($user->company_id !== $transaction->patient->company_id) {
            return false;
        }

        // Doctor can view their own prescriptions
        if ($user->hasRole('Dokter') && $user->id === $transaction->doctor_id) {
            return true;
        }

        // Pharmacist can view all prescriptions in their company
        if ($user->hasRole('Apoteker')) {
            return true;
        }

        // Admin can view all prescriptions in their company
        if ($user->hasRole('Admin')) {
            return true;
        }

        // Patient can view their own prescriptions
        if ($user->hasRole('Pasien') && $user->id === $transaction->patient_id) {
            return true;
        }

        return false;
    }

    /**
     * Prepare prescription data for view
     */
    private function preparePrescriptionData($transaction)
    {
        $patient = $transaction->patient;
        $doctor = $transaction->doctor;
        $poly = $transaction->poly;

        // Calculate patient age
        $patientAge = $patient->userDetail && $patient->userDetail->birth_date
            ? Carbon::parse($patient->userDetail->birth_date)->age
            : null;

        // Get patient gender
        $patientGender = $patient->userDetail && $patient->userDetail->administrative_gender
            ? ($patient->userDetail->administrative_gender === 'male' ? 'Laki-laki' : 'Perempuan')
            : '-';

        // Get clinic/company info
        $clinicInfo = [
            'name' => $patient?->company?->name ?? 'Klinik Sehat Mandiri',
            'address' => $patient?->company?->address ?? 'Jl. Kesehatan No. 123',
            'phone' => $patient?->company?->phone ?? '(021) 1234-5678',
            'email' => $patient?->company?->email ?? 'info@klinik.com',
        ];

        // Prepare medicines data
        $medicines = $transaction->transactionDetails->map(function ($detail, $index) {
            return [
                'no' => $index + 1,
                'name' => $detail->name,
                'details' => $detail->description ?? 'Tablet, Generik',
                'dosage' => $detail->dosage ?? '1 x 1',
                'quantity' => $detail->quantity.' '.($detail->unit ?? 'tablet'),
                'instruction' => $detail->instruction ?? 'Diminum sesuai petunjuk dokter',
            ];
        });

        return [
            'prescription' => [
                'number' => $transaction->code_consultation ?? $transaction->code,
                'date' => $transaction->created_at->format('d/m/Y'),
                'time' => $transaction->created_at->format('H:i:s'),
                'consultation_code' => $transaction->code_consultation ?? 'POLI0001',
            ],
            'clinic' => $clinicInfo,
            'doctor' => [
                'name' => $doctor?->name ?? '-',
                'specialization' => $doctor?->userDetail?->specialization ?? 'Dokter Umum',
                'sip' => $doctor?->userDetail?->sip ?? '503/SIP/2023/DINKES-JKT',
                'str' => $doctor?->userDetail?->str ?? '11234567890123',
            ],
            'location' => [
                'name' => $poly?->name ?? $transaction->location?->name ?? '-',
                'address' => $clinicInfo['address'],
                'phone' => $clinicInfo['phone'],
            ],
            'patient' => [
                'name' => $patient->name,
                'age' => $patientAge ? $patientAge.' Tahun' : '-',
                'gender' => $patientGender,
                'address' => $patient->userDetail->address ?? '-',
                'phone' => $patient->phone ?? '-',
                'diagnosis' => $transaction->diagnosis ?? 'Diagnosis tidak tersedia',
            ],
            'medicines' => $medicines,
            'notes' => $this->generatePrescriptionNotes($transaction),
            'pharmacist' => [
                'name' => 'Apt. Sarah Wijaya, S.Farm',
                'position' => 'Apoteker',
                'license' => 'SIA: 01.2023.APT.DKI',
            ],
        ];
    }

    /**
     * Generate prescription notes
     */
    private function generatePrescriptionNotes($transaction)
    {
        $notes = [
            'Kontrol kembali: 2 minggu kemudian atau jika ada keluhan',
            'Simpan obat di tempat sejuk, kering, dan terhindar dari sinar matahari langsung',
            'Jika ada efek samping yang tidak biasa, segera hubungi dokter',
            'Habiskan obat sesuai petunjuk dokter, jangan menghentikan pengobatan tanpa konsultasi',
            'Bawa resep ini jika kontrol kembali ke dokter',
        ];

        // Add specific notes based on transaction type or condition
        if ($transaction->type === 'konsultasi') {
            $notes[] = 'Konsultasi rutin diperlukan untuk memantau kondisi kesehatan';
        }

        return $notes;
    }

    /**
     * Get prescription list for current user
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Transaction::with(['patient', 'doctor', 'location'])
            ->where('consultation', 'yes')
            ->where('status', '!=', 'draft_consultation');

        // Filter based on user role
        if ($user->hasRole('Dokter')) {
            $query->where('doctor_id', $user->id);
        } elseif ($user->hasRole('Pasien')) {
            $query->where('patient_id', $user->id);
        } elseif (! $user->hasRole('Super Admin')) {
            // Admin and Pharmacist can see all in their company
            $query->whereHas('patient', function ($q) use ($user) {
                $q->where('company_id', $user->company_id);
            });
        }

        // Search functionality
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', '%'.$search.'%')
                    ->orWhere('code_consultation', 'like', '%'.$search.'%')
                    ->orWhere('patient_name', 'like', '%'.$search.'%')
                    ->orWhere('doctor_name', 'like', '%'.$search.'%');
            });
        }

        $prescriptions = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.prescription.index', compact('prescriptions'));
    }
}
