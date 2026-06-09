<?php

namespace App\Livewire\Admin\Consultation\Consultation\Detail;

use App\Helpers\AlertHelper;
use App\Models\Branch\Branch;
use App\Models\Company\Company;
use App\Models\Encounter\Encounter;
use App\Models\HowToUse\HowToUse;
use App\Models\Icd\Icd10;
use App\Models\Icd\Icd9;
use App\Models\Location\Location;
use App\Models\Master\CodeSystem\Condition\MasterConditionBodySite;
use App\Models\Master\CodeSystem\Condition\MasterConditionCategory;
use App\Models\Master\CodeSystem\Condition\MasterConditionClinicalStatus;
use App\Models\Master\CodeSystem\Condition\MasterConditionCodeChiefComplaint;
use App\Models\Master\CodeSystem\Condition\MasterConditionSeverity;
use App\Models\Master\CodeSystem\Condition\MasterConditionVerificationStatus;
use App\Models\Master\CodeSystem\Consultation\MasterConsultationTerminology;
use App\Models\Master\CodeSystem\MedicationRequest\MasterMedicationRequestDosageRoute;
use App\Models\Medication\Medication;
use App\Models\MedicineType\MedicineType;
use App\Models\Patient\Patient;
use App\Models\Practitiont\Practitioner;
use App\Models\Product\Product;
use App\Models\Product\ProductPackage;
use App\Models\Product\ProductPrice;
use App\Models\Product\ProductStock;
use App\Models\Product\ProductType;
use App\Models\Promotion\PromotionSimplified;
use App\Models\Transaction\SupportingTransactionIcd10;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionCondition;
use App\Models\Transaction\TransactionDetail;
use App\Models\Transaction\TransactionDiagnosis;
use App\Models\Transaction\TransactionIcd10;
use App\Models\Transaction\TransactionIcd9;
use App\Models\Transaction\TransactionNurse;
use App\Models\Transaction\TransactionPhysicalExamination;
use App\Models\Transaction\TransactionPrimary;
use App\Models\Transaction\TransactionProduct;
use App\Models\Transaction\TransactionProofOfAction;
use App\Models\Transaction\TransactionRecipe;
use App\Models\Transaction\TransactionRecipeReal;
use App\Models\Transaction\TransactionRecipeRealDetail;
use App\Models\Transaction\TransactionReference;
use App\Models\Transaction\TransactionSecondary;
use App\Models\User;
use App\Models\User\AllergyMedicine;
use App\Models\User\UserControlSchedule;
use App\service\apiservice;
use App\Services\Promotion\PromotionSimplifiedService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;
use thiagoalessio\TesseractOCR\TesseractOCR;

class AdminConsultationConsultationDetailIndex extends Component
{
    use WithFileUploads, WithPagination;

    public $search;

    public $perPage = 5;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public $transaction_id;

    public $transaction;

    public $remaining_queue;

    public $promotion_simplified_id;

    public $get_tabs = ['diagnosa', 'observasi', 'tindakan', 'persetujuan-tindakan', 'odontogram', 'bukti-tindakan', 'resep', 'jadwal-kontrol', 'rujukan'];

    public $tab;

    // Diagnosa
    public $subjective;

    public $objective;

    public $assessment;

    public $plan;

    public $allergy_name;

    public $type;

    public $return_recommendation;

    public $transaction_nurses = [];

    public $transaction_icd10_tops = [];

    public $transaction_icd9s = [];

    public $patient_id;

    // Observasi
    public $head_circumference;

    public $heart_rate;

    public $breathing;

    public $blood_pressure_sistole;

    public $blood_pressure_diastole;

    public $body_temperature;

    public $height;

    public $weight;

    // Diagnosa Keluhan Utama
    public $description_primary;

    public $verification_status = 'confirmed';

    public $clinical_status = 'active';

    public $snomed_code = [];

    public $onset_datetime;

    public $transaction_icd10s = [];

    // Diagnosa Keluhan Sekunder / Penyerta
    public $description_secondary;

    public $supporting_verification_status;

    public $supporting_clinical_status;

    public $supporting_snomed_code;

    public $supporting_onset_datetime;

    public $supporting_transaction_icd10s = [];

    // Odontogram
    public $odontogram;

    public $odontogram_mode = 'manual'; // manual or product

    public $odontogram_name;

    public $odontogram_price;

    public $odontogram_product_id;

    public $odontogram_description;

    public $odontogram_discount_type = 'nominal';

    public $odontogram_discount = 0;

    public $transaction_odontograms = [];

    // Action
    public $transaction_actions = [];

    // Consent Actions (Persetujuan Tindakan)
    public $consent_actions = [];

    public $consent_signee = [];

    public $consent_document;

    public $is_insurance_claim = false;

    // Proof of Action
    public $proof_of_actions = [];

    public $patient_proof_of_actions = [];

    public $description;

    public $type_before_photo;

    public $before_photo;

    public $type_after_photo;

    public $after_photo;

    // Recipe
    public $recipes = [];

    public $transaction_recipe_id;

    // Jadwal Kontrol
    public $date;

    public $description_control;

    public $doctor_id;

    public $location_id;

    public $products = [];

    // Rujukan
    public $hospital_name;

    public $doctor_name;

    public $description_refer;

    public $date_refer;

    // Array
    public $medicine_types = [];

    public $supporting_products = [];

    public $locations = [];

    public $doctors = [];

    public $perawats = [];

    public $product_types = [];

    // Aturan Pakai
    public $name_how_to_use;

    public $description_how_to_use;

    public $day_how_to_use;

    public $time_how_to_use;

    public $is_outside_pharmacy;

    public $discount_type = 'rupiah';

    public $discount = 0;

    private $validStatuses = [
        'draft_consultation',
        'waiting_consultation',
        'call_consultation',
        'confirmation_call',
        'consultation',
        'pharmacy',
        'call_pharmacy',
        'sale_pharmacy',
        'draft',
        'process',
        'take_medicine',
    ];

    /**
     * Helper function to safely parse numeric values from formatted strings
     */
    private function parseNumericValue($value, $isFloat = false)
    {
        if (is_null($value) || $value === '') {
            return 0;
        }

        // Convert to string
        $value = (string) $value;

        // Jika ada koma dan titik, asumsikan titik = ribuan, koma = desimal
        if (strpos($value, ',') !== false && strpos($value, '.') !== false) {
            $value = str_replace('.', '', $value); // hapus pemisah ribuan
            $value = str_replace(',', '.', $value); // ubah desimal ke dot
        }
        // Jika hanya ada koma → anggap itu desimal
        elseif (strpos($value, ',') !== false) {
            $value = str_replace(',', '.', $value);
        }
        // Jika hanya ada titik → biarkan

        // ✅ pastikan konversi ke float dulu
        $numericValue = floatval($value);

        return $isFloat ? $numericValue : (int) ceil($numericValue);
    }

    /**
     * Helper function to safely parse float values
     */
    private function parseFloatValue($value)
    {
        return $this->parseNumericValue($value, true);
    }

    /**
     * Helper function to safely parse integer values
     */
    private function parseIntValue($value)
    {
        return $this->parseNumericValue($value, false);
    }

    public function mount()
    {
        $this->transaction_id = session('transaction_id', null);

        if ($this->transaction_id === null) {
            return redirect()->route('user.consultation.consultation');
        }

        $this->transaction = Transaction::with(['patient.userDetail', 'doctor.userDetail', 'controlDoctor', 'location'])->find($this->transaction_id);
        $this->patient_id = User::find($this->transaction->patient_id)->id;
        $this->consent_actions = is_array($this->transaction->consent_actions) ? $this->transaction->consent_actions : [];
        $this->consent_signee = is_array($this->transaction->consent_signee) ? $this->transaction->consent_signee : [];
        $this->product_types = Cache::remember('product_types_tindakan_paket', 3600, function () {
            return ProductType::whereIn('name', ['Tindakan', 'Paket', 'Jasa'])
                ->pluck('id')
                ->toArray();
        });

        $this->changeTab('diagnosa');
    }

    public function insurance()
    {
        return $this->belongsTo(insurance::class);
    }

    // Consent methods
    public function addConsentAction()
    {
        $this->consent_actions[] = '';
    }

    public function removeConsentAction($index)
    {
        if (isset($this->consent_actions[$index])) {
            unset($this->consent_actions[$index]);
            $this->consent_actions = array_values($this->consent_actions); // re-index
        }
    }

    public function saveConsentAction()
    {
        if ($this->transaction) {
            $this->transaction->update([
                'consent_actions' => $this->consent_actions,
                'consent_signee' => $this->consent_signee,
            ]);

            AlertHelper::success('Berhasil', 'Persetujuan Tindakan berhasil disimpan.');
        } else {
            AlertHelper::error('Gagal', 'Transaksi tidak ditemukan.');
        }
    }

    public function extractConsentActions()
    {
        set_time_limit(120);

        $this->validate([
            'consent_document' => 'required|image|max:10240', // 10MB Max
        ], [
            'consent_document.required' => 'Pilih file dokumen/foto terlebih dahulu.',
            'consent_document.image' => 'File harus berupa gambar (JPG, PNG).',
            'consent_document.max' => 'Ukuran file maksimal 10MB.',
        ]);

        try {
            $imagePath = $this->consent_document->getRealPath();

            // Run Tesseract OCR with psm(6) to prevent column disjointing
            // PSM 6 = Assume a single uniform block of text.
            $ocrText = (new TesseractOCR($imagePath))
                ->lang('ind', 'eng')
                ->psm(6)
                ->run();

            if (empty($ocrText)) {
                AlertHelper::warning('Peringatan', 'Tesseract OCR tidak menemukan teks apapun pada gambar.');

                return;
            }

            // Refined Parsing Logic using line-by-line strict regex
            $lines = explode("\n", $ocrText);
            $extractedData = [
                'signee' => [
                    'name' => '',
                    'age_or_dob' => '',
                    'address' => '',
                    'phone' => '',
                    'relationship' => '',
                ],
                'actions' => [],
            ];

            $parsingActions = false;
            foreach ($lines as $line) {
                $line = trim($line);
                if (empty($line)) {
                    continue;
                }

                $lowerLine = strtolower($line);

                // --- Stop parsing actions when hitting declarations ---
                if (strpos($lowerLine, 'saya menyatakan bahwa') !== false || strpos($lowerLine, 'telah menerima penjelasan') !== false) {
                    $parsingActions = false;
                }

                // 1. Nama (First instance is Signee)
                if (preg_match('/^Nama\s*[:;]?\s*(.+)/i', $line, $matches) && empty($extractedData['signee']['name'])) {
                    $val = ltrim(trim($matches[1]), ':; ');
                    $val = trim(preg_replace('/_+/', '', $val));
                    if (strtolower($val) !== 'pasien') {
                        $extractedData['signee']['name'] = $val;
                    }
                }
                // 2. Tanggal Lahir/Usia (First instance is Signee)
                elseif (preg_match('/(?:Tanggal Lahir|Usia)[\/\s]*[:;]?\s*(.+)/i', $line, $matches) && empty($extractedData['signee']['age_or_dob'])) {
                    $cleaned = preg_replace('/(?:Usia|Tahun)/i', '', $matches[1]);
                    $cleaned = ltrim(trim($cleaned), ':; ');
                    $cleaned = trim(preg_replace('/_+/', '', $cleaned));
                    $cleaned = preg_replace('/\s+/', ' ', $cleaned); // remove extra spaces
                    $cleaned = preg_replace('/\s+1\s+(\d+)/', ' / $1', $cleaned); // fix 1 -> /
                    $extractedData['signee']['age_or_dob'] = $cleaned;
                }
                // 3. Alamat
                elseif (preg_match('/^Alamat\s*[:;]?\s*(.+)/i', $line, $matches) && empty($extractedData['signee']['address'])) {
                    $val = ltrim(trim($matches[1]), ':; ');
                    $val = trim(preg_replace('/_+/', '', ltrim(trim($val), ':')));
                    if (! str_contains(strtolower($val), 'klinik')) { // Prevent grabbing "Alamat Klinik"
                        $extractedData['signee']['address'] = $val;
                    }
                }
                // 4. No Telepon / HP
                elseif (preg_match('/(?:Telepon|HP)[\/\s]*[:;]?\s*(.+)/i', $line, $matches) && empty($extractedData['signee']['phone'])) {
                    $cleaned = preg_replace('/(?:HP|\/)/i', '', $matches[1]);
                    $cleaned = ltrim(trim($cleaned), ':; ');
                    $cleaned = trim(preg_replace('/_+/', '', $cleaned));

                    // Regex find phone
                    if (preg_match('/(?:1|\|)?\s*(08[0-9]+)/', $cleaned, $phoneMatches)) {
                        $extractedData['signee']['phone'] = $phoneMatches[1];
                    } else {
                        $extractedData['signee']['phone'] = $cleaned;
                    }
                }
                // 5. Hubungan dgn Pasien
                elseif (preg_match('/(?:Hubungan dgn Pasien|Hubungan dengan Pasien)\s*[:;]?\s*.*Lainnya\s*[:;]?\s*(.+)/i', $line, $matches) && empty($extractedData['signee']['relationship'])) {
                    $extractedData['signee']['relationship'] = trim(preg_replace('/_+/', '', ltrim(trim($matches[1]), ':; ')));
                }
                // 6. Check for relation checkboxes [Ya] or [V] or [x] (Diri Sendiri/Suami/Istri/Orang Tua)
                elseif (preg_match('/\[\s*(?:Ya|v|x|X|√|v)\s*\]\s*([^\[]+)/i', $line, $matches) && empty($extractedData['signee']['relationship'])) {
                    $extractedData['signee']['relationship'] = trim($matches[1]);
                }

                // Actions (Tindakan) extraction
                elseif (strpos($lowerLine, 'tindakan medis yang akan dilakukan') !== false) {
                    $parsingActions = true;
                } elseif ($parsingActions) {
                    if (preg_match('/^\d+[\.\)]\s*(.+)/', $line, $matches)) {
                        $act = trim(preg_replace('/_+/', '', $matches[1]));
                        if (! empty($act)) {
                            $extractedData['actions'][] = $act;
                        }
                    } elseif (preg_match('/^[-*]\s*(.+)/', $line, $matches)) {
                        $act = trim(preg_replace('/_+/', '', $matches[1]));
                        if (! empty($act)) {
                            $extractedData['actions'][] = $act;
                        }
                    }
                }
            }

            // Fallback if no specific fields found but we have text
            if (empty($extractedData['signee']['name']) && count($extractedData['actions']) == 0) {
                $extractedData['actions'][] = 'HASIL OCR MENTAH: '.substr($ocrText, 0, 800).'...';
            }

            // Apply findings
            foreach ($extractedData['signee'] as $key => $val) {
                if (! empty($val)) {
                    $this->consent_signee[$key] = $val;
                }
            }

            if (! empty($extractedData['actions'])) {
                foreach ($extractedData['actions'] as $act) {
                    $this->consent_actions[] = $act;
                }
            }

            Log::info('OCR Extraction Result: '.json_encode($extractedData));

            $this->saveConsentAction();
            $this->consent_document = null; // reset file
            AlertHelper::success('Berhasil', 'Ekstraksi Tesseract OCR selesai.');

        } catch (\Exception $e) {
            Log::error('OCR Extraction Exception: '.$e->getMessage());
            AlertHelper::error('Gagal', 'Terjadi kesalahan sistem OCR: '.$e->getMessage());
        }
    }

    public function hydrate()
    {
        $this->resetPage();
    }

    public function createTransactionIcd10()
    {
        $this->type = 'icd10';

        return $this->dispatch('open-modal', ['id' => 'modal']);
    }

    public function createSupportingTransactionIcd10()
    {
        $this->type = 'supporting_icd10';

        return $this->dispatch('open-modal', ['id' => 'modal']);
    }

    public function createTransactionIcd9()
    {
        $this->type = 'icd9';

        return $this->dispatch('open-modal', ['id' => 'modal']);
    }

    public function closeModal()
    {
        $this->reset(['type', 'search']);
        $this->perPage = 5;
        $this->dispatch('close-modal', ['id' => 'modal']);
    }

    public function choiceICD($id)
    {
        if ($this->type == 'icd10') {
            $icd10 = Icd10::find($id);

            if ($icd10) {
                TransactionIcd10::create([
                    'transaction_id' => $this->transaction_id,
                    'icd10_id' => $id,
                    'user_id' => $this->transaction->patient_id,
                ]);

                $this->detailTransactionIcd10();
                AlertHelper::success('Berhasil', 'Diagnosa ICD-10 berhasil ditambahkan.');
            } else {
                AlertHelper::error('Gagal', 'Diagnosa ICD-10 tidak ditemukan.');
            }
        } elseif ($this->type == 'icd9') {
            $icd9 = Icd9::find($id);

            if ($icd9) {
                TransactionIcd9::create([
                    'transaction_id' => $this->transaction_id,
                    'icd9_id' => $id,
                    'user_id' => $this->transaction->patient_id,
                ]);

                $this->detailTransactionIcd9();
                AlertHelper::success('Berhasil', 'Diagnosa ICD-9 berhasil ditambahkan.');
            } else {
                AlertHelper::error('Gagal', 'Diagnosa ICD-9 tidak ditemukan.');
            }
        }
        $this->closeModal();
    }

    public function choiceSupportingICD($id)
    {
        $icd10 = Icd10::find($id);

        if ($icd10) {
            SupportingTransactionIcd10::create([
                'transaction_id' => $this->transaction_id,
                'icd10_id' => $id,
                'user_id' => $this->transaction->patient_id,
            ]);

            $this->detailSupportingTransactionIcd10();
            AlertHelper::success('Berhasil', 'Diagnosa ICD-10 berhasil ditambahkan.');
        } else {
            AlertHelper::error('Gagal', 'Diagnosa ICD-10 tidak ditemukan.');
        }
        $this->closeModal();
    }

    public function changeTab($tab)
    {
        $this->reset(['remaining_queue']);
        $this->remaining_queue = Transaction::select('id')
            ->where([['doctor_id', '=', $this->transaction->doctor_id], ['location_id', '=', $this->transaction->location_id], ['control_doctor_id', '=', $this->transaction->control_doctor_id], ['id', '!=', $this->transaction_id]])
            ->whereIn('status', ['waiting_consultation', 'draft_consultation', 'call_consultation', 'confirmation_call'])
            ->whereDate('date', $this->transaction->date)
            ->count();

        if (in_array($tab, $this->get_tabs)) {
            $this->tab = $tab;

            if ($tab == 'tindakan') {
                $this->doctors = [];
                $this->getDoctors();
                $this->perawats = [];
                $this->perawats = User::role(['Terapis', 'Perawat', 'Super Admin'])
                    ->select('id', 'name')
                    ->where('type_user', 'employee')
                    ->get()
                    ->toArray();
                $this->detailAction();
            } elseif ($tab == 'observasi') {
                $transactionPhysicalExam = TransactionPhysicalExamination::where('transaction_id', $this->transaction_id)->first();
                $this->head_circumference = $transactionPhysicalExam ? $transactionPhysicalExam->head_circumference : null;
                $this->heart_rate = $transactionPhysicalExam ? $transactionPhysicalExam->heart_rate : null;
                $this->breathing = $transactionPhysicalExam ? $transactionPhysicalExam->breathing : null;
                $this->blood_pressure_sistole = $transactionPhysicalExam ? $transactionPhysicalExam->blood_pressure_sistole : null;
                $this->blood_pressure_diastole = $transactionPhysicalExam ? $transactionPhysicalExam->blood_pressure_diastole : null;
                $this->body_temperature = $transactionPhysicalExam ? $transactionPhysicalExam->body_temperature : null;
                $this->height = $transactionPhysicalExam ? $transactionPhysicalExam->height : null;
                $this->weight = $transactionPhysicalExam ? $transactionPhysicalExam->weight : null;
            } elseif ($tab == 'diagnosa') {
                $this->detail();
                $this->detailPrimary();
                $this->detailSecondary();
                $this->detailTransactionNurses();
                $this->detailTransactionIcd10();
                $this->detailSupportingTransactionIcd10();
            } elseif ($tab == 'bukti-tindakan') {
                $this->detailProofOfAction();
            } elseif ($tab == 'resep') {
                $this->getMedicineTypes();
                $this->getSupportingProducts();
                $this->detailMedicine();
            } elseif ($tab == 'jadwal-kontrol') {
                $this->getPolys();
                $this->getDoctors();
                $this->detailSchedule();
            } elseif ($tab == 'rujukan') {
                $this->detailReference();
            } elseif ($tab == 'odontogram') {
                $this->getMedicineTypes();
                $this->getSupportingProducts();
                $this->detailOdontogram();
            } else {
                $this->reset(['transaction_actions', 'subjective', 'return_recommendation', 'objective', 'assessment', 'plan', 'proof_of_actions', 'recipes', 'date', 'description_control', 'doctor_id', 'location_id', 'hospital_name', 'doctor_name', 'description_refer', 'date_refer', 'supporting_products', 'medicine_types', 'locations', 'doctors', 'transaction_icd10s', 'transaction_icd9s', 'allergy_name', 'transaction_nurses', 'type', 'transaction_recipe_id', 'description_primary', 'verification_status', 'clinical_status', 'snomed_code', 'onset_datetime', 'description_secondary', 'supporting_verification_status', 'supporting_clinical_status', 'supporting_snomed_code', 'supporting_onset_datetime', 'supporting_transaction_icd10s', 'heart_rate', 'breathing', 'blood_pressure_sistole', 'blood_pressure_diastole', 'body_temperature', 'height', 'weight', 'transaction_odontograms', 'odontogram', 'odontogram_mode', 'odontogram_name', 'odontogram_price', 'odontogram_product_id', 'odontogram_description']);
            }
        } else {
            $this->tab = 'diagnosa';
        }

        $this->updateTotal();
    }

    public function updateTotal()
    {
        $transaction = Transaction::find($this->transaction_id);

        if ($transaction) {
            // 1. Hitung komponen dasar subtotal
            $first_service_price = $this->is_outside_pharmacy ? 0 : TransactionRecipe::where('transaction_id', $this->transaction_id)->sum('price_service_one');
            $service_other_price = $this->is_outside_pharmacy ? 0 : TransactionRecipe::where('transaction_id', $this->transaction_id)->sum('price_service_other');
            $price_product_price = $this->is_outside_pharmacy ? 0 : TransactionRecipe::where('transaction_id', $this->transaction_id)->sum('sub_total_price');
            $product_price = $this->is_outside_pharmacy ? TransactionDetail::whereIn('type_transaction', ['action', 'other'])->where('transaction_id', $this->transaction_id)
                ->sum('sub_total_price') : TransactionDetail::where('transaction_id', $this->transaction_id)
                ->sum('sub_total_price');

            // Set komponen dasar transaksi
            $transaction->sub_total_price_embalage = $first_service_price + $price_product_price + $product_price;
            $transaction->second_service_price = 0;
            $transaction->first_service_price = $first_service_price;
            $transaction->service_other_price = $service_other_price;
            $transaction->price_product_price = $price_product_price;
            $transaction->product_price = $product_price;
            $transaction->embalage = $transaction->second_service_price + $first_service_price + $price_product_price + $service_other_price;

            // 2. Hitung subtotal awal sebelum promosi dan diskon
            $subtotal = $transaction->embalage + $product_price;

            // Gunakan sub_total_price_before_rounding jika tersedia, jika tidak gunakan subtotal yang dihitung
            if (! empty($transaction->sub_total_price_before_rounding) && $transaction->sub_total_price_before_rounding > 0) {
                $subtotal = $transaction->sub_total_price_before_rounding;
            }

            // 3. Validasi dan terapkan promotion simplified
            if ($this->promotion_simplified_id) {
                $promotionService = new PromotionSimplifiedService;
                $promotionResult = $promotionService->calculatePromotionDiscount($this->promotion_simplified_id, $subtotal);

                // Jika promotion tidak eligible, hapus promotion
                if (! $promotionResult['eligible']) {
                    $promotionName = '';
                    try {
                        $promotion = PromotionSimplified::find($this->promotion_simplified_id);
                        $promotionName = $promotion ? $promotion->name : 'Promosi';
                    } catch (\Exception $e) {
                        $promotionName = 'Promosi';
                    }

                    $this->promotion_simplified_id = null;
                    $transaction->promotion_simplified_id = null;
                    $transaction->promotion_real = 0;
                    $transaction->promotion = 0;
                    $transaction->promotion_type = 'rupiah';
                    $transaction->promotion_value = 0;

                    AlertHelper::warning(
                        'Peringatan',
                        "Promosi '{$promotionName}' tidak memenuhi syarat. Total transaksi kurang dari minimum pembelian atau diskon melebihi batas maksimum."
                    );
                }
            }

            // 4. Hitung total setelah promosi
            $totalAfterPromotion = $subtotal;
            $totalPromotionDiscount = $transaction->promotion_real ?? 0;
            $totalAfterPromotion = $totalAfterPromotion - $totalPromotionDiscount;

            // 5. Aplikasikan pembulatan SEBELUM manual discount
            $rounding = 0;
            $roundedTotal = 0;
            $remainder = 0;

            if ($totalAfterPromotion <= 0) {
                $roundedTotal = 0;
                $rounding = -$totalAfterPromotion;
                $remainder = 0;
            } else {
                $totalAfterPromotion = (int) round($totalAfterPromotion);
                $remainder = $totalAfterPromotion % 1000;

                if ($remainder == 0) {
                    // Sudah bulat ribuan, biarkan apa adanya
                    $roundedTotal = $totalAfterPromotion;
                    $rounding = 0;
                } elseif ($remainder < 500) {
                    $roundedTotal = $totalAfterPromotion - $remainder + 500;
                    $rounding = 500 - $remainder;
                } else {
                    $roundedTotal = $totalAfterPromotion - $remainder + 1000;
                    $rounding = 1000 - $remainder;
                }
            }

            // 6. Hitung dan terapkan manual discount berdasarkan total setelah rounding
            $totalManualDiscount = 0;

            if ($roundedTotal >= 1) {
                if ($this->discount_type == 'percentage') {
                    $discountPercentage = $this->parseFloatValue($this->discount ?? '0');
                    $totalManualDiscount = ($roundedTotal * $discountPercentage) / 100;
                    $transaction->discount = $discountPercentage;
                } else {
                    $discountAmount = $this->parseFloatValue($this->discount ?? '0');
                    // Pastikan diskon tidak melebihi total setelah rounding
                    $totalManualDiscount = min($discountAmount, $roundedTotal);
                    $transaction->discount = $totalManualDiscount;
                }

                // transaction->discount_value is the total sum of all discounts (global + items)
                $itemDiscounts = TransactionDetail::where('transaction_id', $this->transaction_id)->sum('discount_value');
                $transaction->discount_value = $totalManualDiscount + $itemDiscounts;
                $transaction->discount_type = $this->discount_type ?? 'rupiah';
            } else {
                $transaction->discount = 0;
                $transaction->discount_type = 'rupiah';
                $itemDiscounts = TransactionDetail::where('transaction_id', $this->transaction_id)->sum('discount_value');
                $transaction->discount_value = $itemDiscounts;
                $totalManualDiscount = 0;
            }

            // Update format display discount
            $this->discount = ($this->discount_type ?? 'rupiah') == 'rupiah'
                ? number_format($transaction->discount, 0, ',', '.')
                : number_format($transaction->discount, 2, ',', '.');

            // 7. Grand total is rounded total MINUS the global/manual discount
            // roundedTotal already includes item prices AFTER their own discounts
            $grandTotal = $roundedTotal - $totalManualDiscount;

            // Pastikan grand total tidak negatif
            if ($grandTotal < 0) {
                $grandTotal = 0;
                // Adjust manual discount jika menyebabkan total negatif
                $totalManualDiscount = $roundedTotal;
                $transaction->discount = $totalManualDiscount;
                $transaction->discount_value = $totalManualDiscount + TransactionDetail::where('transaction_id', $this->transaction_id)->sum('discount_value');
            }

            $transaction->sub_total_price = $roundedTotal;

            // 8. Set nilai final ke transaksi
            $transaction->rounding = $rounding;
            $transaction->grand_total_price = $grandTotal;
            $transaction->rounding_remainder = $remainder;

            // 9. Hitung pembayaran dan kembalian
            $transaction->payment_amount = $transaction->transactionPayments()->sum('payment_amount');
            $transaction->payment_change = $transaction->payment_amount < $transaction->grand_total_price ? 0 : $transaction->payment_amount - $transaction->grand_total_price;
            $transaction->remaining_bill = $transaction->grand_total_price - $transaction->payment_amount;
            $transaction->remaining_bill = $transaction->remaining_bill < 0 ? 0 : $transaction->remaining_bill;
            $transaction->grand_total_price_admin_fee = $transaction->grand_total_price + ($transaction->single_payment_admin_fee ?? 0);

            // 10. Simpan transaksi dan refresh data
            $transaction->save();
            $this->reset('transaction');
            $this->transaction = $transaction;
        }
    }

    public function detailPrimary()
    {
        $this->description_primary = $this->subjective;
        $this->verification_status = 'confirmed';
        $this->clinical_status = 'active';
        $this->snomed_code = '';
        $this->onset_datetime = '';

        $transactionPrimary = TransactionPrimary::where('transaction_id', $this->transaction_id)->first();

        if ($transactionPrimary) {
            $this->description_primary = $transactionPrimary->description_primary ?? $this->subjective;
            $this->verification_status = $transactionPrimary->verification_status ?? 'confirmed';
            $this->clinical_status = $transactionPrimary->clinical_status ?? 'active';
            $this->snomed_code = json_decode($transactionPrimary->snomed_code) ?? [];
            $this->onset_datetime = $transactionPrimary->onset_datetime ?? '';
        }
    }

    public function detailSecondary()
    {
        $this->description_secondary = '';
        $this->supporting_verification_status = '';
        $this->supporting_clinical_status = '';
        $this->supporting_snomed_code = '';
        $this->supporting_onset_datetime = '';

        $transactionSecondary = TransactionSecondary::where('transaction_id', $this->transaction_id)
            ->first();

        if ($transactionSecondary) {
            $this->description_secondary = $transactionSecondary->description_secondary ?? '';
            $this->supporting_verification_status = $transactionSecondary->supporting_verification_status ?? '';
            $this->supporting_clinical_status = $transactionSecondary->supporting_clinical_status ?? '';
            $this->supporting_snomed_code = json_decode($transactionSecondary->supporting_snomed_code) ?? [];
            $this->supporting_onset_datetime = $transactionSecondary->supporting_onset_datetime ?? '';
        }
    }

    public function detailTransactionIcd10()
    {
        $this->transaction_icd10s = [];

        $transaction_icd10s = TransactionIcd10::where('transaction_id', $this->transaction_id)->where('type', 'non-top')->get();
        foreach ($transaction_icd10s as $key => $value) {
            $this->transaction_icd10s[] = [
                'id' => $value->id,
                'icd10_id' => $value->icd10_id,
                'icd10_code' => $value->icd10->code ?? '',
                'icd10_display' => $value->icd10->display ?? '',
            ];
        }

        $transaction_icd10_tops = TransactionIcd10::where('transaction_id', $this->transaction_id)->where('type', 'top')->get();
        foreach ($transaction_icd10_tops as $key => $value) {
            $this->transaction_icd10_tops[] = $value->icd10_id;
        }
    }

    public function detailSupportingTransactionIcd10(): void
    {
        $this->supporting_transaction_icd10s = [];

        $transaction_icd10s = SupportingTransactionIcd10::where('transaction_id', $this->transaction_id)
            ->get();

        foreach ($transaction_icd10s as $key => $value) {
            $this->supporting_transaction_icd10s[] = [
                'id' => $value->id,
                'icd10_id' => $value->icd10_id,
                'icd10_code' => $value->icd10->code ?? '',
                'icd10_display' => $value->icd10->display ?? '',
            ];
        }
    }

    public function detailTransactionIcd9()
    {
        $this->transaction_icd9s = [];

        $transaction_icd9s = TransactionIcd9::where('transaction_id', $this->transaction_id)->get();
        foreach ($transaction_icd9s as $key => $value) {
            $this->transaction_icd9s[] = [
                'id' => $value->id,
                'icd9_id' => $value->icd9_id,
                'icd9_code' => $value->icd9->code ?? '',
                'icd9_display' => $value->icd9->display ?? '',
            ];
        }
    }

    public function getPolys()
    {
        $this->reset(['locations']);
        $this->locations = Location::select('id', 'name')
            ->where('company_id', Auth::user()->company_id)
            ->orderBy('name', 'asc')
            ->get()
            ->toArray();
    }

    public function getDoctors()
    {
        $this->reset(['doctors']);
        $this->doctors = User::select('id', 'name')
            ->companyRole('Dokter', Auth::user()->company_id)
            ->get()
            ->toArray();
    }

    public function getMedicineTypes()
    {
        $this->reset(['medicine_types']);
        $this->medicine_types = MedicineType::select('id', 'name')
            ->where('company_id', Auth::user()->company_id)
            ->get()
            ->toArray();
    }

    public function getSupportingProducts()
    {
        $this->reset(['supporting_products']);

        $this->supporting_products = Product::where('company_id', Auth::user()->company_id)
            ->whereHas('productType', function ($query) {
                $query->where('name', 'Produk Pendukung'); // atau 'Supporting Product' sesuai isi database
            })
            ->whereHas('productPrice', function ($query) {
                $query->where('price', '>', 0)->where('branch_id', Branch::where('company_id', Auth::user()->company_id)->first()->id);
            })
            ->whereHas('productStock', function ($query) {
                $query->where('quantity', '>', 0)->where('branch_id', Branch::where('company_id', Auth::user()->company_id)->first()->id); // atau 'Supporting Product' sesuai isi database
            })
            ->select('id', 'name')
            ->with('productPrice:id,product_id,price,recipe', 'productStock:id,product_id,quantity')
            ->orderBy('name', 'asc')
            ->get()
            ->toArray();
    }

    public function updated($propertyName)
    {
        if ($propertyName === 'subjective' || $propertyName === 'objective' || $propertyName === 'assessment' || $propertyName === 'plan' || $propertyName === 'return_recommendation') {
            TransactionDiagnosis::updateOrCreate(
                [
                    'transaction_id' => $this->transaction_id,
                    'user_id' => $this->transaction->patient_id,
                ],
                [
                    'subjective' => empty($this->subjective) ? null : $this->subjective,
                    'objective' => empty($this->objective) ? null : $this->objective,
                    'assessment' => empty($this->assessment) ? null : $this->assessment,
                    'plan' => empty($this->plan) ? null : $this->plan,
                    'return_recommendation' => empty($this->return_recommendation) ? null : $this->return_recommendation,
                ],
            );

            TransactionPrimary::updateOrCreate(
                [
                    'transaction_id' => $this->transaction_id,
                ],
                [
                    'description_primary' => empty($this->subjective) ? null : $this->subjective,
                    'verification_status' => empty($this->verification_status) ? 'confirmed' : $this->verification_status,
                    'clinical_status' => empty($this->clinical_status) ? 'active' : $this->clinical_status,
                    'snomed_code' => empty($this->snomed_code) ? null : json_encode($this->snomed_code),
                    'onset_datetime' => empty($this->onset_datetime) ? null : $this->onset_datetime,
                ],
            );

            $this->description_primary = $this->subjective;
        } elseif ($propertyName === 'date' || $propertyName === 'description_control' || $propertyName === 'doctor_id' || $propertyName === 'location_id') {
            UserControlSchedule::updateOrCreate(
                [
                    'transaction_id' => $this->transaction_id,
                    'user_id' => $this->transaction->patient_id,
                ],
                [
                    'date' => empty($this->date) ? null : $this->date, // Fix di sini
                    'description' => empty($this->description_control) ? null : $this->description_control,
                    'doctor_id' => empty($this->doctor_id) ? null : $this->doctor_id,
                    'location_id' => empty($this->location_id) ? null : $this->location_id,
                    'products' => empty($this->products) ? null : $this->products,
                ],
            );
        } elseif ($propertyName === 'hospital_name' || $propertyName === 'doctor_name' || $propertyName === 'description_refer' || $propertyName === 'date_refer') {
            TransactionReference::updateOrCreate(
                [
                    'transaction_id' => $this->transaction_id,
                    'user_id' => $this->transaction->patient_id,
                ],
                [
                    'hospital' => empty($this->hospital_name) ? null : $this->hospital_name,
                    'doctor_name' => empty($this->doctor_name) ? null : $this->doctor_name,
                    'description' => empty($this->description_refer) ? null : $this->description_refer,
                    'date' => empty($this->date_refer) ? null : $this->date_refer,
                ],
            );
        } elseif ($propertyName === 'allergy_name') {
            $allergyMedicine = AllergyMedicine::where('user_id', $this->transaction->patient_id)
                ->where('transaction_id', $this->transaction_id)
                ->where('company_id', Auth::user()->company_id)
                ->first();

            if ($this->allergy_name) {
                AllergyMedicine::updateOrCreate(
                    [
                        'user_id' => $this->transaction->patient_id,
                        'transaction_id' => $this->transaction_id,
                        'company_id' => Auth::user()->company_id,
                    ],
                    [
                        'description' => $this->allergy_name,
                    ],
                );
            } else {
                if ($allergyMedicine) {
                    $allergyMedicine->delete();
                }
            }
        } elseif ($propertyName === 'transaction_nurses') {
            foreach ($this->transaction_nurses as $nurseId) {
                $user = User::find($nurseId);
                $test = TransactionNurse::updateOrCreate(
                    [
                        'nurse_id' => $nurseId,
                        'transaction_id' => $this->transaction_id,
                    ],
                    [
                        'nurse_name' => $user ? $user->name : null,
                        'company_id' => Auth::user()->company_id,
                    ]
                );
            }
        } elseif ($propertyName === 'subjective' || $propertyName === 'description_primary' || $propertyName === 'verification_status' || $propertyName === 'clinical_status' || $propertyName === 'snomed_code' || $propertyName === 'onset_datetime') {
            TransactionPrimary::updateOrCreate(
                [
                    'transaction_id' => $this->transaction_id,
                ],
                [
                    'description_primary' => empty($this->subjective) ? null : $this->subjective,
                    'verification_status' => empty($this->verification_status) ? 'confirmed' : $this->verification_status,
                    'clinical_status' => empty($this->clinical_status) ? 'active' : $this->clinical_status,
                    'snomed_code' => empty($this->snomed_code) ? null : json_encode($this->snomed_code),
                    'onset_datetime' => empty($this->onset_datetime) ? null : $this->onset_datetime,
                ],
            );

            TransactionCondition::updateOrCreate(
                [
                    'transaction_id' => $this->transaction_id,
                    'type' => 'keluhan-utama',
                ],
                [
                    'description' => empty($this->description_primary) ? null : $this->description_primary,
                    'verification_status' => empty($this->verification_status) ? null : $this->verification_status,
                    'clinical_status' => empty($this->clinical_status) ? null : $this->clinical_status,
                    'snomed_code' => empty($this->snomed_code) ? null : json_encode($this->snomed_code),
                    'onset_datetime' => empty($this->onset_datetime) ? null : $this->onset_datetime,
                ],
            );
        } elseif ($propertyName === 'description_secondary' || $propertyName === 'supporting_verification_status' || $propertyName === 'supporting_clinical_status' || $propertyName === 'supporting_snomed_code' || $propertyName === 'supporting_onset_datetime') {
            TransactionSecondary::updateOrCreate(
                [
                    'transaction_id' => $this->transaction_id,
                ],
                [
                    'description_secondary' => empty($this->description_secondary) ? null : $this->description_secondary,
                    'supporting_verification_status' => empty($this->supporting_verification_status) ? null : $this->supporting_verification_status,
                    'supporting_clinical_status' => empty($this->supporting_clinical_status) ? null : $this->supporting_clinical_status,
                    'supporting_snomed_code' => empty($this->supporting_snomed_code) ? null : $this->supporting_snomed_code,
                    'supporting_onset_datetime' => empty($this->supporting_onset_datetime) ? null : $this->supporting_onset_datetime,
                ],
            );
        } elseif ($propertyName === 'transaction_icd10_tops') {
            TransactionIcd10::where('transaction_id', $this->transaction_id)
                ->where('type', 'top')
                ->delete();

            foreach ($this->transaction_icd10_tops as $transaction_icd10_top) {
                TransactionIcd10::create([
                    'transaction_id' => $this->transaction_id,
                    'icd10_id' => $transaction_icd10_top,
                    'user_id' => $this->transaction->patient_id,
                    'type' => 'top',
                ]);
            }
        } elseif (in_array($propertyName, ['head_circumference', 'heart_rate', 'breathing', 'blood_pressure_sistole', 'blood_pressure_diastole', 'body_temperature', 'height', 'weight'])) {
            TransactionPhysicalExamination::updateOrCreate(
                [
                    'transaction_id' => $this->transaction_id,
                    'company_id' => Auth::user()->company_id,
                ],
                [
                    'head_circumference' => empty($this->head_circumference) ? null : $this->head_circumference,
                    'heart_rate' => empty($this->heart_rate) ? null : $this->heart_rate,
                    'breathing' => empty($this->breathing) ? null : $this->breathing,
                    'blood_pressure_sistole' => empty($this->blood_pressure_sistole) ? null : $this->blood_pressure_sistole,
                    'blood_pressure_diastole' => empty($this->blood_pressure_diastole) ? null : $this->blood_pressure_diastole,
                    'body_temperature' => empty($this->body_temperature) ? null : $this->body_temperature,
                    'height' => empty($this->height) ? null : $this->height,
                    'weight' => empty($this->weight) ? null : $this->weight,
                ],
            );

            $this->head_circumference = $this->head_circumference;
            $this->heart_rate = $this->heart_rate;
            $this->breathing = $this->breathing;
            $this->blood_pressure_sistole = $this->blood_pressure_sistole;
            $this->blood_pressure_diastole = $this->blood_pressure_diastole;
            $this->body_temperature = $this->body_temperature;
            $this->height = $this->height;
            $this->weight = $this->weight;
        }
    }

    public function confirmDeleteTransactionIcd10($id)
    {
        return AlertHelper::confirmDelete('deleteTransactionIcd10', 'Apakah Anda yakin ingin menghapus Diagnosa ICD-10 ini?', $id);
    }

    public function deleteTransactionIcd10($id)
    {
        $transaction_icd10 = TransactionIcd10::find($id[0]);

        if ($transaction_icd10) {
            $transaction_icd10->delete();
            $this->detailTransactionIcd10();
            AlertHelper::success('Berhasil', 'Diagnosa ICD-10 berhasil dihapus.');
        } else {
            AlertHelper::error('Gagal', 'Diagnosa ICD-10 tidak ditemukan.');
        }
    }

    public function confirmDeleteSupportingTransactionIcd10($id)
    {
        return AlertHelper::confirmDelete('deleteSupportingTransactionIcd10', 'Apakah Anda yakin ingin menghapus Diagnosa Supporting ICD-10 ini?', $id);
    }

    public function deleteSupportingTransactionIcd10($id)
    {
        $transaction_icd10 = SupportingTransactionIcd10::find($id[0]);

        if ($transaction_icd10) {
            $transaction_icd10->delete();
            $this->detailSupportingTransactionIcd10();
            AlertHelper::success('Berhasil', 'Diagnosa Supporting ICD-10 berhasil dihapus.');
        } else {
            AlertHelper::error('Gagal', 'Diagnosa Supporting ICD-10 tidak ditemukan.');
        }
    }

    public function confirmDeleteTransactionIcd9($id)
    {
        return AlertHelper::confirmDelete('deleteTransactionIcd9', 'Apakah Anda yakin ingin menghapus diagnosa ini?', $id);
    }

    public function deleteTransactionIcd9($id)
    {
        $transaction_icd9 = TransactionIcd9::find($id[0]);

        if ($transaction_icd9) {
            $transaction_icd9->delete();
            $this->detailTransactionIcd9();
            AlertHelper::success('Berhasil', 'Diagnosa ICD-9 berhasil dihapus.');
        } else {
            AlertHelper::error('Gagal', 'Diagnosa ICD-9 tidak ditemukan.');
        }
    }

    public function createActions()
    {
        $this->type = 'action';

        return $this->dispatch('open-modal', ['id' => 'modalAction']);
    }

    public function choiceAction($id)
    {
        $product = Product::find($id);

        $productPrice = ProductPrice::where('product_id', $id)
            ->where('company_id', Auth::user()->company_id)
            ->where('is_updated', true)
            ->first();

        if ($productPrice->price == 0) {
            AlertHelper::error('Gagal', 'Harga produk tidak boleh 0.');

            return;
        }

        if (! $product->is_non_stock) {
            $branchId = Branch::where('company_id', Auth::user()->company_id)->first()?->id;

            $inputQuantity = 1;

            $productStock = ProductStock::where('product_id', $id)
                ->where('company_id', Auth::user()->company_id)
                ->where('branch_id', $branchId)
                ->first();
            // Hitung locked stock dari transaksi aktif lainnya
            $lockedStock = TransactionDetail::where('product_id', $id)
                ->whereHas('transaction', fn ($query) => $query->whereIn('status', $this->validStatuses))
                ->sum('quantity');

            // Hitung locked stock dari resep aktif
            $lockedStockRecipe = TransactionRecipe::where('product_id', $id)
                ->whereHas('transaction', fn ($query) => $query->whereIn('status', $this->validStatuses))
                ->sum('quantity');

            // Hitung stok tersedia
            $available = $productStock->quantity - $lockedStock - $lockedStockRecipe;

            // Validasi stok
            if ($inputQuantity > $available) {
                AlertHelper::error(
                    'Gagal',
                    "Stok produk '{$product->name}' tidak mencukupi. Tersedia: {$available}, Dibutuhkan: {$inputQuantity}."
                );

                return true;
            }
        }

        TransactionDetail::create([
            'transaction_id' => $this->transaction_id,
            'product_id' => $id,
            'quantity' => 1,
            'price' => $productPrice ? $productPrice->price : 0,
            'sub_total_price' => $productPrice ? $productPrice->price : 0,
            'type_transaction' => 'action',
        ]);

        AlertHelper::success('Berhasil', 'Tindakan berhasil ditambahkan.');
        $this->closeModalAction();
        $this->detailAction();
        $this->updateTotal();
    }

    public function closeModalAction()
    {
        $this->reset(['type', 'search']);
        $this->perPage = 5;
        $this->dispatch('close-modal', ['id' => 'modalAction']);
    }

    public function detailAction()
    {
        $this->reset(['transaction_actions']);

        $transaction_actions = TransactionDetail::where('transaction_id', $this->transaction_id)
            // ->where('type_transaction', 'action')
            ->whereNull('transaction_recipe_id')
            ->whereNull('odontogram_code')
            ->with('product:id,sku_number,name,description,company_id')->orderBy('order', 'asc')->get();
        foreach ($transaction_actions as $action) {
            $this->transaction_actions[] = [
                'id' => $action->id,
                'product_id' => $action->product_id,
                'name' => $action->product?->name ?? $action->name,
                'description' => $action->description,
                'quantity' => $action->quantity,
                'price' => intval(Str::replace('.', '', number_format($action->price, 0, ',', '.'))),
                'sub_total_price' => intval(Str::replace('.', '', number_format($action->sub_total_price, 0, ',', '.'))),
                'nurse_id' => $action->nurse_id,
                'doctor_id' => $action->doctor_id,
                'discount_type' => $action->discount_type ?? 'nominal',
                'discount' => $action->discount,
                'discount_value' => $action->discount_value,
            ];
        }
        $this->updateTotal();
    }

    public function cekOdotogram($code)
    {
        $this->odontogram = ($this->odontogram === $code) ? null : $code;
    }

    public $odontogram_color = '#3b82f6'; // Default color (Blue)

    public $odontogram_product_search;

    public $odontogram_product_results = [];

    public $odontogram_map = [];

    public function detailOdontogram()
    {
        $this->reset(['transaction_odontograms', 'odontogram_map']);

        $transaction_odontograms = TransactionDetail::where('transaction_id', $this->transaction_id)
            ->whereNotNull('odontogram_code')
            ->with('product:id,sku_number,name,description,company_id')->orderBy('created_at', 'asc')->get();

        foreach ($transaction_odontograms as $action) {
            $this->transaction_odontograms[] = [
                'id' => $action->id,
                'odontogram_code' => $action->odontogram_code,
                'odontogram_color' => $action->odontogram_color,
                'product_id' => $action->product_id,
                'name' => $action->product?->name ?? $action->name,
                'description' => $action->description,
                'quantity' => $action->quantity,
                'price' => number_format($action->price, 0, ',', '.'),
                'discount' => $action->discount,
                'discount_type' => $action->discount_type,
                'discount_value' => $action->discount_value,
                'sub_total_price' => number_format($action->sub_total_price, 0, ',', '.'),
            ];

            // Populate map for visualization
            if ($action->odontogram_code) {
                $this->odontogram_map[$action->odontogram_code] = $action->odontogram_color ?? '#3b82f6';
            }
        }
    }

    public function createOdontogramActions()
    {
        $this->type = 'odontogram_action';
        $this->dispatch('open-modal', ['id' => 'modalAction']);
    }

    public function choiceOdontogramAction($id)
    {
        $this->selectOdontogramProduct($id);
        $this->dispatch('close-modal', ['id' => 'modalAction']);
    }

    public function updatedOdontogramProductSearch()
    {
        if (strlen($this->odontogram_product_search) < 2) {
            $this->odontogram_product_results = [];

            return;
        }

        $this->odontogram_product_results = Product::where('company_id', Auth::user()->company_id)
            ->where('is_active', true)
            ->where('name', 'like', '%'.$this->odontogram_product_search.'%')
            ->whereHas('productType', function ($query) {
                $query->whereIn('name', ['Jasa', 'Tindakan']);
            })
            ->limit(10)
            ->get();
    }

    public function selectOdontogramProduct($id)
    {
        $product = Product::find($id);
        if ($product) {
            $this->odontogram_product_id = $product->id;
            $this->odontogram_name = $product->name;
            $this->odontogram_product_search = $product->name; // Show selected name

            $productPrice = ProductPrice::where('product_id', $product->id)
                ->where('company_id', Auth::user()->company_id)
                ->where('is_updated', true)
                ->first();

            $this->odontogram_price = intval(Str::replace('.', '', number_format($productPrice ? $productPrice->price : 0, 0, ',', '.')));
            $this->odontogram_product_results = [];
        }
    }

    public function saveOdontogram()
    {
        if (! $this->odontogram) {
            AlertHelper::error('Gagal', 'Silakan pilih bagian gigi pada odontogram terlebih dahulu.');

            return;
        }

        // Validate common fields
        $this->validate([
            'odontogram_name' => 'required', // Name is required for both manual and product
            'odontogram_price' => 'required',
        ]);

        $price = $this->parseIntValue($this->odontogram_price);
        $discount = $this->parseFloatValue($this->odontogram_discount ?? '0');
        $discountType = $this->odontogram_discount_type ?? 'nominal';
        $discountValue = 0;

        // Validation & Calculation: Cap discount
        if ($discountType === 'percentage') {
            if ($discount > 100) {
                $discount = 100;
                $this->odontogram_discount = 100;
            }
            $discountValue = $price * ($discount / 100);
        } else {
            if ($discount > $price) {
                $discount = $price;
                $this->odontogram_discount = $price;
            }
            $discountValue = $discount;
        }

        $subTotalPrice = $price - $discountValue;

        // Prepare data
        $data = [
            'transaction_id' => $this->transaction_id,
            'odontogram_code' => $this->odontogram,
            'odontogram_color' => $this->odontogram_color,
            'name' => $this->odontogram_name,
            'description' => $this->odontogram_description,
            'price' => $price,
            'quantity' => 1,
            'discount' => $discount,
            'discount_type' => $discountType,
            'discount_value' => $discountValue,
            'sub_total_price' => $subTotalPrice,
            'type_transaction' => 'action',
        ];

        if ($this->odontogram_product_id) {
            $data['product_id'] = $this->odontogram_product_id;
        }

        TransactionDetail::create($data);

        AlertHelper::success('Berhasil', 'Data Odontogram berhasil ditambahkan.');

        // Reset inputs
        $this->reset(['odontogram', 'odontogram_name', 'odontogram_price', 'odontogram_product_id', 'odontogram_description', 'odontogram_product_search', 'odontogram_color', 'odontogram_discount', 'odontogram_discount_type']);
        $this->odontogram_color = '#3b82f6'; // Reset to default blue
        $this->odontogram_discount_type = 'nominal';

        $this->detailOdontogram();
        $this->updateTotal();
    }

    public function confirmDeleteOdontogram($id)
    {
        $detail = TransactionDetail::find($id);
        if ($detail) {
            $detail->delete();
            $this->detailOdontogram();
            $this->updateTotal();
            AlertHelper::success('Berhasil', 'Data Odontogram berhasil dihapus.');
        }
    }

    public function detailProofOfAction()
    {
        $this->reset(['proof_of_actions', 'patient_proof_of_actions']);

        // Bukti tindakan untuk transaksi ini
        $proof_of_actions = TransactionProofOfAction::where('transaction_id', $this->transaction_id)->orderBy('created_at', 'desc')->get();
        foreach ($proof_of_actions as $value) {
            $this->proof_of_actions[] = [
                'id' => $value->id,
                'transaction_id' => $value->transaction_id,
                'description' => $value->description,
                'before_photo' => $value->before_photo,
                'after_photo' => $value->after_photo,
            ];
        }

        // Riwayat bukti tindakan dari semua transaksi si pasien (kecuali transaksi ini)
        $patient_id = $this->transaction->patient_id ?? null;
        if ($patient_id) {
            $other_transaction_ids = Transaction::where('patient_id', $patient_id)
                ->where('id', '!=', $this->transaction_id)
                ->pluck('id');

            $patient_proofs = TransactionProofOfAction::whereIn('transaction_id', $other_transaction_ids)
                ->with([
                    'transaction' => fn ($q) => $q->select('id', 'code', 'date'),
                ])
                ->orderBy('created_at', 'desc')
                ->get();

            foreach ($patient_proofs as $value) {
                $this->patient_proof_of_actions[] = [
                    'id' => $value->id,
                    'transaction_code' => $value->transaction?->code ?? '-',
                    'transaction_date' => $value->transaction?->date ? Carbon::parse($value->transaction->date)->locale('id')->isoFormat('D MMMM Y') : '-',
                    'description' => $value->description,
                    'before_photo' => $value->before_photo,
                    'after_photo' => $value->after_photo,
                ];
            }
        }
    }

    public function updatedTransactionActions()
    {
        $branchId = Branch::where('company_id', Auth::user()->company_id)->first()?->id;

        foreach ($this->transaction_actions as $key => $action) {

            $price = intval(str_replace('.', '', $action['price'] ?? '0'));
            $quantity = max(intval(str_replace('.', '', $action['quantity'] ?? '1')), 1);

            $discountType = $action['discount_type'] ?? 'nominal';
            $discountStr = $action['discount'] ?? '0';
            $discount = $this->parseFloatValue($discountStr);

            $discountValue = $discountType === 'percentage'
                ? ($price * $quantity) * ($discount / 100)
                : $discount;

            $subTotalPrice = ($price * $quantity) - $discountValue;

            $transactionAction = TransactionDetail::where('id', $action['id'])
                ->where('transaction_id', $this->transaction_id)
                ->first();

            $product = Product::find($action['product_id']);

            if ($product && ! $product->is_non_stock) {

                $productStock = ProductStock::where('product_id', $product->id)
                    ->where('company_id', Auth::user()->company_id)
                    ->where('branch_id', $branchId)
                    ->first();

                if (! $productStock) {
                    AlertHelper::error('Gagal', "Stok produk '{$product->name}' tidak ditemukan.");

                    return true;
                }

                $lockedStock = TransactionDetail::where('product_id', $product->id)
                    ->whereHas('transaction', fn ($q) => $q->whereIn('status', $this->validStatuses))
                    ->when($transactionAction, fn ($q) => $q->where('id', '!=', $transactionAction->id))
                    ->sum('quantity');

                $lockedStockRecipe = TransactionRecipe::where('product_id', $product->id)
                    ->whereHas('transaction', fn ($q) => $q->whereIn('status', $this->validStatuses))
                    ->sum('quantity');

                $available = $productStock->quantity - $lockedStock - $lockedStockRecipe;

                if ($quantity > $available) {
                    AlertHelper::error(
                        'Gagal',
                        "Stok produk '{$product->name}' tidak mencukupi. Tersedia: {$available}, Dibutuhkan: {$quantity}."
                    );

                    return true;
                }
            }

            if ($transactionAction) {
                $transactionAction->update([
                    'quantity' => $quantity,
                    'price' => $price,
                    'discount_type' => $discountType,
                    'discount' => $discount,
                    'discount_value' => $discountValue,
                    'sub_total_price' => $subTotalPrice,
                    'name' => $action['description'] ?? $product?->name ?? $transactionAction->name,
                    'description' => $action['description'] ?? '',
                    'nurse_id' => ! empty($action['nurse_id']) ? $action['nurse_id'] : null,
                    'doctor_id' => ! empty($action['doctor_id']) ? $action['doctor_id'] : null,
                ]);
            }

            $this->transaction_actions[$key]['price'] = $price;
            $this->transaction_actions[$key]['quantity'] = $quantity;
            $this->transaction_actions[$key]['discount_value'] = $discountValue;
            $this->transaction_actions[$key]['sub_total_price'] = $subTotalPrice;
        }

        $this->updateTotal();
    }

    public function confirmDeleteAction($id)
    {
        return AlertHelper::confirmDelete('deleteAction', 'Apakah Anda yakin ingin menghapus tindakan ini?', $id);
    }

    public function deleteAction($id)
    {
        $transaction_action = TransactionDetail::find($id[0]);

        if ($transaction_action) {
            $transaction_action->delete();
            AlertHelper::success('Berhasil', 'Tindakan berhasil dihapus.');
            $this->detailAction();
        } else {
            AlertHelper::error('Gagal', 'Tindakan tidak ditemukan.');
        }
    }

    public function detail()
    {
        $transaction = TransactionDiagnosis::where('transaction_id', $this->transaction_id)->first();
        if ($transaction) {
            $this->subjective = $transaction->subjective;
            $this->objective = $transaction->objective;
            $this->assessment = $transaction->assessment;
            $this->plan = $transaction->plan;
            $this->return_recommendation = $transaction->return_recommendation;
        } else {
            $this->subjective = '';
            $this->objective = '';
            $this->assessment = '';
            $this->plan = '';
            $this->return_recommendation = '';
        }

        $allergyMedicine = AllergyMedicine::where('user_id', $this->transaction->patient_id)
            ->where('transaction_id', $this->transaction_id)
            ->where('company_id', Auth::user()->company_id)
            ->first();
        if ($allergyMedicine) {
            $this->allergy_name = $allergyMedicine->description;
        } else {
            $this->allergy_name = '';
        }
    }

    public function detailSchedule()
    {
        $schedule = UserControlSchedule::where('transaction_id', $this->transaction_id)->where('user_id', $this->transaction->patient_id)->first();

        if ($schedule) {
            $this->date = $schedule->date;
            $this->description_control = $schedule->description;
            $this->doctor_id = $schedule->doctor_id;
            $this->location_id = $schedule->location_id;
        } else {
            $this->date = null;
            $this->description_control = '';
            $this->doctor_id = null;
            $this->location_id = null;
        }
    }

    public function detailReference()
    {
        $reference = TransactionReference::where('transaction_id', $this->transaction_id)->first();

        if ($reference) {
            $this->hospital_name = $reference->hospital;
            $this->doctor_name = $reference->doctor_name;
            $this->description_refer = $reference->description;
            $this->date_refer = $reference->date;
        } else {
            $this->hospital_name = '';
            $this->doctor_name = '';
            $this->description_refer = '';
            $this->date_refer = null;
        }
    }

    public function createProofOfAction()
    {
        return $this->dispatch('open-modal', ['id' => 'modalProofOfAction']);
    }

    public function closeModalProofOfAction()
    {
        $this->reset(['description', 'type_before_photo', 'before_photo', 'type_after_photo', 'after_photo']);
        $this->dispatch('close-modal', ['id' => 'modalProofOfAction']);
    }

    public function saveAction()
    {
        $this->validate([
            'description' => 'required',
            'before_photo' => 'nullable|image|max:2048',
            'after_photo' => 'nullable|image|max:2048',
        ]);

        $before_photo = null;
        if ($this->before_photo) {
            $manager = new ImageManager(new Driver);
            $image = $manager->read($this->before_photo->getRealPath());
            if ($image->width() > 1024) {
                $image->scaleDown(width: 1024);
            }
            $encoded = $image->toWebp(70);
            $randomName = Str::random(40).'.webp';
            Storage::disk('public')->put('proof_of_action/before/'.$randomName, (string) $encoded);
            $before_photo = 'proof_of_action/before/'.$randomName;
        }

        $after_photo = null;
        if ($this->after_photo) {
            $manager = new ImageManager(new Driver);
            $image = $manager->read($this->after_photo->getRealPath());
            if ($image->width() > 1024) {
                $image->scaleDown(width: 1024);
            }
            $encoded = $image->toWebp(70);
            $randomName = Str::random(40).'.webp';
            Storage::disk('public')->put('proof_of_action/after/'.$randomName, (string) $encoded);
            $after_photo = 'proof_of_action/after/'.$randomName;
        }
        TransactionProofOfAction::create([
            'transaction_id' => $this->transaction_id,
            'description' => $this->description,
            'before_photo' => $before_photo,
            'after_photo' => $after_photo,
            'date' => now(),
            'user_id' => $this->transaction->patient_id,
        ]);
        AlertHelper::success('Berhasil', 'Bukti tindakan berhasil ditambahkan.');
        $this->closeModalProofOfAction();
        $this->detailProofOfAction();
    }

    public function confirmDeleteProofOfAction($id)
    {
        return AlertHelper::confirmDelete('deleteProofOfAction', 'Apakah Anda yakin ingin menghapus bukti tindakan ini?', $id);
    }

    public function deleteProofOfAction($id)
    {

        $proof_of_action = TransactionProofOfAction::find($id[0]);

        if ($proof_of_action) {
            if ($proof_of_action->before_photo && Storage::disk('public')->exists($proof_of_action->before_photo)) {
                Storage::disk('public')->delete($proof_of_action->before_photo);
            }
            if ($proof_of_action->after_photo && Storage::disk('public')->exists($proof_of_action->after_photo)) {
                Storage::disk('public')->delete($proof_of_action->after_photo);
            }

            $proof_of_action->delete();
            AlertHelper::success('Berhasil', 'Bukti tindakan berhasil dihapus.');
            $this->detailProofOfAction();
        } else {
            AlertHelper::error('Gagal', 'Bukti tindakan tidak ditemukan.');
        }
    }

    public function createMedicine()
    {
        $this->transaction_recipe_id = null; // Reset transaction_recipe_id
        $this->type = 'medicine';

        return $this->dispatch('open-modal', ['id' => 'modalProduct']);
    }

    public function closeModalProduct()
    {
        $this->reset(['type']);
        $this->dispatch('close-modal', ['id' => 'modalProduct']);
    }

    public function choiceProduct($id)
    {
        // Get authenticated user's company and branch once
        $companyId = auth()->user()->company_id;
        $branchId = Branch::where('company_id', $companyId)->value('id');

        // Find product with related data in one query
        $product = Product::with(['productStock', 'productPrice'])
            ->where('id', $id)
            // ->whereHas('productType', fn($query) => $query->where('name', 'Obat'))
            ->first();

        if (! $product) {
            // $this->reset('search_sku');
            AlertHelper::error('Gagal', 'Produk tidak ditemukan.');

            return true;
        }

        // Check stock
        if ($product->is_non_stock == false) {
            $productStock = $product->productStock()->where('company_id', $companyId)->where('branch_id', $branchId)->first();

            // if (!$productStock || $productStock->quantity <= 0) {
            //     AlertHelper::error('Gagal', 'Stok produk tidak ditemukan atau stok kosong.');
            //     return true;
            // }
        }

        // if ($productStock?->quantity_now <= 0) {
        //     AlertHelper::error('Gagal', 'Stok produk tidak mencukupi.');
        //     return true;
        // }

        $productPrice = $product->productPrice()->where('company_id', $companyId)->where('branch_id', $branchId)->where('is_updated', true)->first();

        if (! $productPrice) {

            $productPrice = ProductPrice::where('product_id', $id)
                ->where('company_id', $companyId)
                // ->where('is_updated', false)
                ->first();

            $productPrice?->update(['is_updated' => true]);
            $productPrice = ProductPrice::where('product_id', $id)
                ->where('company_id', $companyId)
                ->where('branch_id', $branchId)
                ->where('is_updated', true)
                ->first();

            AlertHelper::error('Gagal', 'Harga produk tidak ditemukan.');
        }
        $price = $productPrice?->price ?? 0;

        if ($price == 0) {
            AlertHelper::error('Gagal', 'Harga produk tidak boleh 0.');

            return;
        }

        // Get or create transaction recipe
        $transactionRecipe = $this->transaction_recipe_id
            ? TransactionRecipe::find($this->transaction_recipe_id)
            : TransactionRecipe::create([
                'transaction_id' => $this->transaction_id,
                'company_id' => $companyId,
                'branch_id' => $branchId,
            ]);

        // Create transaction detail
        TransactionDetail::create([
            'transaction_recipe_id' => $transactionRecipe->id,
            'transaction_id' => $this->transaction_id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => $price,
            'sub_total_price' => $price,
            'dosage_drug' => $product->medicine_dosage ?? 0,
            'type_transaction' => 'recipe',
        ]);

        $this->closeModalProduct();
        $this->detailMedicine();
        AlertHelper::success('Berhasil', 'Obat berhasil ditambahkan ke resep.');

        return true;
    }

    public function detailMedicine()
    {
        $this->recipes = [];

        $transactionDetails = TransactionRecipe::where('transaction_id', $this->transaction_id)->orderBy('order', 'asc')->get();

        foreach ($transactionDetails as $key => $transactionDetail) {
            $medicine_type = MedicineType::find($transactionDetail->medicine_type_id);
            $this->recipes[] = [
                'id' => $transactionDetail->id,
                'medicine_type_id' => $transactionDetail->medicine_type_id,
                'medicine_type_name' => $medicine_type ? $medicine_type->name : null,
                'is_single' => $medicine_type ? $medicine_type->is_single : false,
                'numero_recipe' => $transactionDetail->numero_recipe ?? null,
                'price_service_one' => number_format($medicine_type ? $medicine_type->service_price : 0, 0, ',', '.'),
                'price_service_other' => number_format($medicine_type ? $medicine_type->price_other : 0, 0, ',', '.'),
                'product_id' => $transactionDetail->product_id,
                'product_name' => $transactionDetail->product->name ?? '',
                'quantity' => $transactionDetail->quantity,
                'price' => number_format($transactionDetail->price, 0, ',', '.'),
                'sub_total_price' => number_format($transactionDetail->sub_total_price, 0, ',', '.'),
                'description' => $transactionDetail->description,
                'how_to_use_id' => $transactionDetail->how_to_use_id,
                'route_coding_code' => $transactionDetail->route_coding_code,
            ];

            foreach ($transactionDetail->transactionDetail as $detail) {
                $quantity_real = $this->parseFloatValue($detail->quantity_real ?? 0);
                $quantity = $medicine_type ? $medicine_type->is_single ? $transactionDetail->numero_recipe : $this->parseIntValue($quantity_real) : 0;
                $this->recipes[$key]['details'][] = [
                    'id' => $detail->id,
                    'product_id' => $detail->product_id,
                    'product_name' => $detail->product->name,
                    'quantity_real' => $quantity_real,
                    'quantity' => $quantity,
                    'price' => $detail->price,
                    'discount' => $detail->discount,
                    'discount_type' => $detail->discount_type,
                    'discount_value' => $detail->discount_value,
                    'sub_total_price' => ($detail->price * $quantity) - ($detail->discount_value ?? 0),
                ];
            }
        }
        $this->updateTotal();
        // $this->updateTransactionRecipe();
    }

    public function confirmDeleteTransactionRecipe($transactionRecipeId)
    {
        AlertHelper::confirmDelete('deleteTransactionRecipe', 'Apakah Anda yakin ingin menghapus item ini?', $transactionRecipeId);

        return true;
    }

    public function confirmDeleteTransactionDetail($transactionDetailId)
    {
        AlertHelper::confirmDelete('deleteTransactionDetail', 'Apakah Anda yakin ingin menghapus item ini?', $transactionDetailId);

        return true;
    }

    public function deleteTransactionDetail($transactionDetailId)
    {
        $transactionDetail = TransactionDetail::find($transactionDetailId[0]);

        if ($transactionDetail) {
            $transactionDetail->delete();
            $this->detailMedicine();
            AlertHelper::success('Berhasil', 'Item berhasil dihapus dari keranjang.');
        } else {
            AlertHelper::error('Gagal', 'Item tidak ditemukan.');
        }

        return true;
    }

    public function deleteTransactionRecipe($transactionRecipeId)
    {
        $transactionRecipe = TransactionRecipe::find($transactionRecipeId[0]);

        if ($transactionRecipe) {
            TransactionDetail::where('transaction_recipe_id', $transactionRecipe->id)->where('transaction_id', $this->transaction_id)->delete();

            $transactionRecipe->delete();
            $this->detailMedicine();
            AlertHelper::success('Berhasil', 'Item berhasil dihapus dari keranjang.');
        } else {
            AlertHelper::error('Gagal', 'Item tidak ditemukan.');
        }

        return true;
    }

    public function updatedRecipes()
    {
        foreach ($this->recipes as $key => $value) {
            $transactionRecipe = TransactionRecipe::find($value['id']);

            if (! $transactionRecipe) {
                AlertHelper::error('Gagal', 'Resep tidak ditemukan.');

                continue;
            }

            // Validasi dan assign field
            $transactionRecipe->medicine_type_id = $value['medicine_type_id'] ?? null;
            $transactionRecipe->price_service_one = $this->parseIntValue($value['price_service_one'] ?? 0);
            $transactionRecipe->price_service_other = $this->parseIntValue($value['price_service_other'] ?? 0);
            $transactionRecipe->product_id = ! empty($value['product_id']) ? $value['product_id'] : null;
            $transactionRecipe->numero_recipe = $this->parseIntValue($value['numero_recipe']);
            $transactionRecipe->quantity = $this->parseIntValue($value['quantity']);
            $transactionRecipe->price = $this->parseIntValue($value['price']);
            $transactionRecipe->sub_total_price = $this->parseIntValue($value['sub_total_price']);
            $transactionRecipe->description = $value['description'] ?? null;
            $transactionRecipe->save(); // Observer akan handle

            if (! empty($value['details'])) {
                foreach ($value['details'] as $detail) {
                    $transactionDetail = TransactionDetail::find($detail['id']);

                    if (! $transactionDetail || empty($detail['product_id'])) {
                        continue;
                    }

                    $productRecipe = Product::find($detail['product_id']);
                    if (! $productRecipe) {
                        continue;
                    }

                    $transactionDetail->product_id = $detail['product_id'];
                    $transactionDetail->type = $detail['type'] ?? 'single';
                    $transactionDetail->quantity_real = $this->parseFloatValue($detail['quantity_real'] ?? 0);
                    $quantity = $this->parseIntValue($detail['quantity']);
                    $price = intval(Str::replace('.', '', number_format($detail['price'], 0, ',', '.')));

                    $discountType = $detail['discount_type'] ?? 'nominal';
                    $discountStr = $detail['discount'] ?? '0';
                    $discount = $this->parseFloatValue($discountStr);

                    if ($discountType === 'percentage') {
                        $discountValue = ($price * $quantity) * ($discount / 100);
                    } else {
                        $maxNominal = $price * $quantity;
                        $discountValue = $discount;
                    }

                    $transactionDetail->quantity = $quantity;
                    $transactionDetail->price = $price;
                    $transactionDetail->discount_type = $discountType;
                    $transactionDetail->discount = $discount;
                    $transactionDetail->discount_value = $discountValue;
                    $transactionDetail->sub_total_price = ($price * $quantity) - $discountValue;
                    $transactionDetail->save(); // Observer akan validasi stok
                }
            }
        }

        $this->updateTransactionRecipe();
        $this->detailMedicine();
        $this->updateTotal();
    }

    public function updateTransactionRecipe()
    {
        try {
            DB::beginTransaction();

            $companyId = auth()->user()->company_id;
            $branchId = Branch::where('company_id', $companyId)->first()?->id;

            $transactionRecipes = TransactionRecipe::where('transaction_id', $this->transaction_id)
                ->orderBy('order', 'asc')
                ->get();

            foreach ($transactionRecipes as $key => $transactionRecipe) {
                $medicineType = MedicineType::find($transactionRecipe->medicine_type_id);
                $numeroRecipe = $this->parseIntValue($transactionRecipe->numero_recipe ?? 0);

                if (! $medicineType) {
                    // tetap dibiarkan gagal kalau tipe resep tidak ada
                    AlertHelper::error('Gagal', 'Tipe Resep Pada /R'.($key + 1).' tidak ditemukan.');

                    continue;
                }

                $product = $transactionRecipe->product_id ? Product::find($transactionRecipe->product_id) : null;

                // Use existing price if available, otherwise fetch from database
                $price = 0;
                if ($transactionRecipe->price > 0) {
                    // Use existing stored price to preserve historical data
                    $price = $transactionRecipe->price;
                } else {
                    // Only fetch from database if price is not set (new record)
                    $productPrice = $product ? ProductPrice::where([
                        'product_id' => $product->id,
                        'company_id' => $companyId,
                        'branch_id' => $branchId,
                        'is_updated' => true,
                    ])->first() : null;
                    $price = $productPrice?->price ?? 0;
                }
                $quantity = $transactionRecipe->quantity ?? 0;

                if ($numeroRecipe > 0) {
                    if ($medicineType->is_single) {
                        $transactionRecipe->product_id = null;
                        $transactionRecipe->quantity = 0;
                        $transactionRecipe->price = 0;
                        $transactionRecipe->sub_total_price = 0;
                        $transactionRecipe->save();
                    }

                    $transactionRecipe->fill([
                        'medicine_type_id' => $transactionRecipe->medicine_type_id,
                        'price_service_one' => $medicineType->service_price ?? 0,
                        'price_service_other' => $medicineType->price_other ?? 0,
                        'numero_recipe' => $numeroRecipe,
                        'quantity' => $quantity,
                        'price' => $price,
                        'sub_total_price' => $price * $quantity,
                        'description' => $transactionRecipe->description ?? null,
                    ])->save();

                    // === UPDATE RECIPE DETAILS ===
                    foreach ($transactionRecipe->transactionDetail as $detail) {
                        $productRecipe = Product::find($detail->product_id);
                        if (! $productRecipe) {
                            continue; // skip tanpa validasi
                        }

                        // Use existing price if available, otherwise fetch from database
                        $priceRecipe = 0;
                        if ($detail->price > 0) {
                            // Use existing stored price to preserve historical data
                            $priceRecipe = $detail->price;
                        } else {
                            // Only fetch from database if price is not set (new record)
                            $productPriceRecipe = ProductPrice::where([
                                'product_id' => $productRecipe->id,
                                'company_id' => $companyId,
                                'branch_id' => $branchId,
                                'is_updated' => true,
                            ])->first();
                            $priceRecipe = $productPriceRecipe?->price ?? 0;
                        }

                        if ($priceRecipe == 0) {
                            AlertHelper::error('Gagal', 'Harga produk tidak boleh 0.');

                            return;
                        }

                        $quantityReal = $medicineType->is_single ? $detail->quantity_real ?? $numeroRecipe > 0 ? $numeroRecipe : ($detail->quantity_real ?? 1) : ($detail->quantity_real ?? 0);

                        $quantity = ceil($medicineType->is_single ? $detail->quantity_real ?? $numeroRecipe > 0 ? $numeroRecipe : ($detail->quantity_real ?? 1) : ($detail->quantity_real ?? 0));

                        $detail->fill([
                            'type' => $medicineType->is_single ? 'single' : ($detail->type ?? 'single'),
                            'dosage_doctor' => 0,
                            'dosage_drug' => 0,
                            'quantity_real' => $quantityReal,
                            'quantity' => $quantity,
                            'price' => $priceRecipe,
                            'sub_total_price' => $priceRecipe * $quantity,
                        ])->save();
                    }
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            AlertHelper::error('Gagal', 'Terjadi kesalahan saat memperbarui resep: '.$e->getMessage());
            Log::error('Error updating transaction recipe: '.$e->getMessage());
        }
    }

    public function addDetail($transaction_recipe)
    {
        $this->transaction_recipe_id = $transaction_recipe;
        $this->type = 'medicine';
        $this->dispatch('open-modal', ['id' => 'modalProduct']);
    }

    public function render()
    {
        $this->transaction->loadMissing(['patient.userDetail', 'doctor.userDetail', 'controlDoctor', 'location']);

        return view('livewire.admin.consultation.consultation.detail.admin-consultation-consultation-detail-index', [
            'icds' => $this->getIcds(),
            'actions' => $this->getActions(),
            'master_consultation_body_sites' => $this->MasterConsultationBodySite(),
            'master_consultation_categories' => $this->MasterConsultationCategory(),
            // 'master_consultation_clinic_statuses' => $this->MasterConsultationClinicStatus(),
            'master_consultation_severities' => $this->MasterConsultationSeverity(),
            // 'master_consultation_verification_statuses' => $this->MasterConsultationVerificationStatus(),
            'master_consultation_snomed_cts' => $this->MasterConsultationSnomedCT(),
            'master_consultation_terminologies' => $this->MasterConsultationTerminology(),
            'medicines' => $this->getMedicines(),
            'nurses' => $this->getNurses(),
            'master_medication_request_dosage_routes' => $this->masterMedicationRequestDosageRoute(),
            'how_to_uses' => $this->howToUses(),
            'productGets' => $this->getAllProducts(),
            'allergiMedicines' => $this->getAllergiMedicines(),
            'topICD10s' => $this->getTopICD10s(),
        ])
            ->extends('layout.app')
            ->section('content');
    }

    private function getAllergiMedicines()
    {
        if ($this->type !== 'alergi') {
            return [];
        }

        return AllergyMedicine::search($this->search)->where('user_id', $this->transaction->patient_id)->get();
    }

    private function getTopICD10s()
    {
        if ($this->tab !== 'diagnosa') {
            return [];
        }

        return TransactionIcd10::select('icd10_id', DB::raw('COUNT(*) as total'))
            ->whereHas(
                'transaction',
                fn ($query) => $query->where('company_id', Auth::user()->company_id)
            )
            ->with('icd10:id,code,display') // join ICD10 biar langsung dapat detailnya
            ->groupBy('icd10_id')
            ->orderByDesc('total')
            ->limit(20)
            ->get()->toArray();
    }

    private function MasterConsultationBodySite()
    {
        return $this->tab == 'diagnosa' ? MasterConditionBodySite::select('code', 'display')->get() : [];
    }

    private function MasterConsultationCategory()
    {
        return $this->tab == 'diagnosa' ? MasterConditionCategory::select('code', 'display')->get() : [];
    }

    private function MasterConsultationClinicStatus()
    {
        return $this->tab == 'diagnosa' ? MasterConditionClinicalStatus::select('code', 'display')->get() : [];
    }

    private function MasterConsultationSeverity()
    {
        return $this->tab == 'diagnosa' ? MasterConditionSeverity::select('code', 'display')->get() : [];
    }

    private function masterMedicationRequestDosageRoute()
    {
        return $this->tab == 'resep' ? MasterMedicationRequestDosageRoute::select('code', 'display')->get()->pluck('code_display', 'code')->toArray() : [];
    }

    private function howToUses()
    {
        return $this->tab == 'resep' ? HowToUse::select('id', 'name', 'description', 'day', 'time')->get()->pluck('name_display', 'id')->toArray() : [];
    }

    private function MasterConsultationVerificationStatus()
    {
        return $this->tab == 'diagnosa' ? MasterConditionVerificationStatus::select('code', 'display')->get() : [];
    }

    private function MasterConsultationSnomedCT()
    {
        return $this->tab == 'diagnosa' ? MasterConditionCodeChiefComplaint::select('code', 'display')->get() : [];
    }

    private function MasterConsultationTerminology()
    {
        return $this->tab == 'diagnosa' ? MasterConsultationTerminology::select('code', 'display')->get() : [];
    }

    private function getIcds()
    {
        if (! in_array($this->type, ['icd10', 'icd9', 'supporting_icd10'])) {
            return [];
        }

        $transactionICD10 = TransactionIcd10::select('icd10_id', DB::raw('COUNT(*) as total'))
            ->whereHas(
                'transaction',
                fn ($query) => $query->where('company_id', Auth::user()->company_id)
            )
            ->with('icd10:id,code,display')
            ->groupBy('icd10_id')
            ->orderByDesc('total')
            ->limit(20)
            ->pluck('icd10_id');

        $model = in_array($this->type, ['icd10', 'supporting_icd10']) ? Icd10::class : Icd9::class;

        return $model::select('id', 'code', 'display')
            ->whereNotIn('id', $transactionICD10)
            ->search($this->search)   // pastikan scopeSearch ada di model
            ->paginate($this->perPage);
    }

    private function getActions()
    {
        if (! in_array($this->type, ['action', 'odontogram_action'])) {
            return [];
        }

        return $this->getProducts(true);
    }

    private function getAllProducts()
    {
        $products = Product::where('company_id', Auth::user()->company_id)
            ->select('id', 'sku_number', 'name', 'description', 'company_id')
            ->orderBy('name', 'asc')
            ->get();

        return $this->tab == 'jadwal-kontrol' ? $products : [];
    }

    private function getMedicines()
    {
        if ($this->type !== 'medicine') {
            return [];
        }

        return $this->getProducts(false);
    }

    private function getNurses()
    {
        if ($this->tab !== 'diagnosa') {
            return [];
        }

        return User::role(['Terapis', 'Perawat', 'Super Admin'])
            ->select('id', 'name')
            ->where('type_user', 'employee')
            ->get()
            ->toArray();
    }

    private function getProducts($isAction = true)
    {
        $query = Product::search($this->search)
            ->select('id', 'sku_number', 'name', 'description', 'company_id')
            ->orderBy('name', 'asc')
            ->where('company_id', Auth::user()->company_id);

        // Optimasi: constraint dengan branch_id untuk relations
        $branchId = $this->getBranchId();

        $query->with([
            'company:id,name',
            'productStock' => function ($q) {
                $q->select('id', 'product_id', 'quantity');
            },
            'productPrice' => function ($q) {
                $q->select('id', 'product_id', 'price', 'recipe');
            },
        ]);

        if ($isAction) {
            $query->whereIn('product_type_id', $this->product_types);
        } else {
            $query->whereNotIn('product_type_id', $this->product_types);
        }

        return $query->paginate($this->perPage);
    }

    private function getBranchId()
    {
        return Cache::remember('branch_id_'.Auth::user()->company_id, 3600, function () {
            return Branch::where('company_id', Auth::user()->company_id)->value('id');
        });
    }

    public function confirmSave()
    {
        AlertHelper::confirmSave('simpan', 'Apakah Anda yakin ingin menyimpan perubahan ini?');

        return true;
    }

    public function simpan()
    {
        // Validasi Diagnosa
        $error = $this->validateDiagnosis();
        if ($error !== null) {
            return $error;
        }

        $error = $this->validateTransactionPrimary();
        if ($error !== null) {
            return $error;
        }

        $transactionPrimarys = TransactionPrimary::where('transaction_id', $this->transaction_id)->first();

        if (! $transactionPrimarys && ! $transactionPrimarys->snomed_code) {
            AlertHelper::error('Gagal', 'Snomed Code utama harus diisi.');

            return true;
        }

        $error = $this->validateTransactionSecondary();
        if ($error !== null) {
            return $error;
        }

        // Validasi Jadwal Kontrol
        $error = $this->validateScheduleControl();
        if ($error !== null) {
            return $error;
        }

        // Validasi Rujukan
        $error = $this->validateReferral();
        if ($error !== null) {
            return $error;
        }

        // Validasi Resep
        $error = $this->validateRecipes();
        if ($error !== null) {
            return $error;
        }

        // Simpan transaksi
        return $this->saveTransaction();
    }

    private function validateDiagnosis()
    {
        $fields = [
            'subjective' => 'Subjective',
            'objective' => 'Objective',
            'assessment' => 'Assessment',
            'plan' => 'Plan',
        ];

        $emptyFields = [];

        foreach ($fields as $fieldKey => $fieldName) {
            if (empty(trim($this->$fieldKey))) {
                $emptyFields[] = $fieldName;
            }
        }

        if (! empty($emptyFields)) {
            $this->changeTab('diagnosa');
            AlertHelper::error('Gagal', 'Field diagnosa wajib diisi: '.implode(', ', $emptyFields));

            return false; // Return boolean false untuk error
        }

        return null;
    }

    public function validateTransactionPrimary()
    {
        $fields = [
            'description_primary' => 'Deskripsi Utama',
            'verification_status' => 'Status Verifikasi',
            'clinical_status' => 'Status Klinik',
            // 'snomed_code' => 'Snomed Code',
            'onset_datetime' => 'Onset Datetime',
        ];

        $isAnyFieldFilled = false;
        $emptyFields = [];

        // Cek apakah ada salah satu field yang terisi
        foreach ($fields as $fieldKey => $fieldName) {
            if (! empty(trim($this->$fieldKey))) {
                $isAnyFieldFilled = true;
                break;
            }
        }

        // Jika ada salah satu yang terisi, validasi semua
        if ($isAnyFieldFilled) {
            foreach ($fields as $fieldKey => $fieldName) {
                if (empty(trim($this->$fieldKey))) {
                    $emptyFields[] = $fieldName;
                }
            }

            if (! empty($emptyFields)) {
                $this->changeTab('diagnosa');
                AlertHelper::error('Gagal', 'Field Keluhan wajib diisi: '.implode(', ', $emptyFields));

                return false;
            }
        }

        return null;
    }

    public function validateTransactionSecondary()
    {
        $fields = [
            'description_secondary' => 'Deskripsi Sekunder',
            'supporting_verification_status' => 'Status Verifikasi',
            'supporting_clinical_status' => 'Status Klinik',
            'supporting_snomed_code' => 'Snomed Code',
            'supporting_onset_datetime' => 'Onset Datetime',
        ];

        $isAnyFieldFilled = false;
        $emptyFields = [];

        // Cek apakah ada salah satu field yang terisi
        foreach ($fields as $fieldKey => $fieldName) {
            if (! empty(trim($this->$fieldKey))) {
                $isAnyFieldFilled = true;
                break;
            }
        }

        // Jika ada salah satu yang terisi, validasi semua
        if ($isAnyFieldFilled) {
            foreach ($fields as $fieldKey => $fieldName) {
                if (empty(trim($this->$fieldKey))) {
                    $emptyFields[] = $fieldName;
                }
            }

            if (! empty($emptyFields)) {
                $this->changeTab('diagnosa');
                AlertHelper::error('Gagal', 'Field Keluhan wajib diisi: '.implode(', ', $emptyFields));

                return false;
            }
        }

        return null;
    }

    private function validateScheduleControl()
    {
        return $this->validateFieldGroup(
            [
                'date' => 'Tanggal',
                'doctor_id' => 'Dokter',
                'location_id' => 'Poliklinik',
                'description_control' => 'Deskripsi Kontrol',
            ],
            'jadwal-kontrol',
            'jadwal kontrol',
        );
    }

    private function validateReferral()
    {
        return $this->validateFieldGroup(
            [
                'hospital_name' => 'Nama Rumah Sakit',
                'doctor_name' => 'Nama Dokter',
                'description_refer' => 'Deskripsi Rujukan',
                'date_refer' => 'Tanggal Rujukan',
            ],
            'rujukan',
            'rujukan',
        );
    }

    private function validateFieldGroup($fields, $tab, $groupName)
    {
        $filledFields = array_filter($fields, fn ($field) => ! empty($this->$field), ARRAY_FILTER_USE_KEY);
        $filledCount = count($filledFields);
        $totalFields = count($fields);

        if ($filledCount > 0 && $filledCount < $totalFields) {
            $emptyFields = array_diff_key($fields, $filledFields);
            $this->changeTab($tab);
            AlertHelper::error('Gagal', 'Lengkapi field '.$groupName.' yang kosong: '.implode(', ', $emptyFields).', atau kosongkan semua field '.$groupName.'.');

            return false; // Return boolean false untuk error
        }

        return null;
    }

    private function validateRecipes()
    {
        $recipes = $this->transaction
            ->transactionRecipes()
            ->with(['transactionDetail', 'medicineType'])
            ->get();

        foreach ($recipes as $key => $recipe) {
            $index = $key + 1;

            // Validasi basic recipe
            if (! $recipe->medicine_type_id) {
                AlertHelper::error('Gagal', "Tipe resep /R {$index} belum dipilih.");

                return true;
            }

            if ($recipe->numero_recipe <= 0) {
                AlertHelper::error('Gagal', "Quantity resep /R {$index} belum diisi.");

                return true;
            }

            if (! $recipe->medicineType) {
                AlertHelper::error('Gagal', "Tipe resep /R {$index} tidak ditemukan di database.");

                return true;
            }

            if ($recipe->transactionDetail->isEmpty()) {
                AlertHelper::error('Gagal', "Detail obat /R {$index} belum diisi.");

                return true;
            }

            // Validasi detail
            foreach ($recipe->transactionDetail as $detail) {
                if ($error = $this->validateRecipeDetail($detail, $index, $recipe->medicineType)) {
                    return $error;
                }
            }
        }

        return null;
    }

    private function validateRecipeDetail($detail, $recipeIndex, $medicineType)
    {
        if (! $detail->product_id) {
            AlertHelper::error('Gagal', "Produk /R {$recipeIndex} belum dipilih.");

            return true;
        }

        $product = Product::find($detail->product_id);
        if (! $product) {
            AlertHelper::error('Gagal', "Produk dengan ID {$detail->product_id} tidak ditemukan.");

            return true;
        }

        if (! $detail->quantity_real) {
            AlertHelper::error('Gagal', "Quantity obat /R {$recipeIndex} belum diisi.");

            return true;
        }

        if ($detail->quantity <= 0) {
            AlertHelper::error('Gagal', "Quantity /R {$recipeIndex} belum diisi.");

            return true;
        }

        // 🚫 HAPUS validasi stok — tidak ada pengecekan ProductStock, lockedStock, available.
        // Dengan begini meskipun stok kosong, proses tetap lanjut.

        return null;
    }

    private function saveTransaction()
    {
        $companyId = Auth::user()->company_id;
        $branch = Branch::where('company_id', $companyId)->first();
        $company = Company::find($companyId);

        if (! $branch) {
            AlertHelper::error('Gagal', 'Branch tidak ditemukan.');

            return true;
        }

        // Validasi Diagnosa
        $error = $this->validateDiagnosis();
        if ($error !== null) {
            return $error;
        }

        $error = $this->validateTransactionPrimary();
        if ($error !== null) {
            return $error;
        }

        $transactionPrimarys = TransactionPrimary::where('transaction_id', $this->transaction_id)->first();

        if (! $transactionPrimarys && ! $transactionPrimarys->snomed_code) {
            AlertHelper::error('Gagal', 'Snomed Code utama harus diisi.');

            return true;
        }

        $error = $this->validateTransactionSecondary();
        if ($error !== null) {
            return $error;
        }

        // Validasi Jadwal Kontrol
        $error = $this->validateScheduleControl();
        if ($error !== null) {
            return $error;
        }

        // Validasi Rujukan
        $error = $this->validateReferral();
        if ($error !== null) {
            return $error;
        }

        // Validasi Resep
        $error = $this->validateRecipes();
        if ($error !== null) {
            return $error;
        }

        $encounter = Encounter::where('transaction_id', $this->transaction_id)->first();

        try {
            DB::beginTransaction();

            $transaction = Transaction::find($this->transaction_id);
            if (! $transaction) {
                AlertHelper::error('Gagal', 'Transaksi tidak ditemukan.');

                return true;
            }

            // Cek dan ambil data yang diperlukan dengan validasi null
            $transactionCondition = TransactionPrimary::where('transaction_id', $this->transaction_id)
                ->first();

            $patient = Patient::where('user_id', $transaction->patient_id)->select('id')->first();
            $doctor = Practitioner::where('user_id', $transaction->doctor_id)->select('id')->first();

            // Validasi data yang diperlukan
            // if (!$patient) {
            //     return AlertHelper::error('Gagal', 'Data pasien tidak ditemukan.');
            // }

            // if (!$doctor) {
            //     return AlertHelper::error('Gagal', 'Data dokter tidak ditemukan.');
            // }

            // Hanya jalankan API service jika transactionCondition ada
            if ($transactionCondition && $encounter) {
                $data = [
                    'pending' => true,
                    'id' => null,
                    'company_id' => $companyId,
                    'transaction_id' => $this->transaction_id,
                    'encounter_id' => $encounter?->id,
                ];

                $dataPrimary = [
                    'id' => '',
                    'transaction_condition_id' => $transactionCondition->id,
                    'company_id' => $companyId,
                    'patient_id' => $patient?->id,
                    'encounter_id' => $encounter?->id,
                    'clinical_status' => $transactionCondition?->clinical_status,
                    'category' => 'chief-complaint',
                    'code' => $transactionCondition?->snomed_code,
                    'onset_date_time' => $transactionCondition?->onset_date_time,
                    'notes' => [$transactionCondition?->description],
                ];

                // app(apiservice::class)->createConditionPrimary($data);
                app(apiservice::class)->createCondition($dataPrimary);
            }

            // Process transaction recipes
            $transactionDetails = TransactionRecipe::where('transaction_id', $this->transaction_id)
                ->orderBy('order', 'asc')
                ->get();

            if ($transactionDetails->count() > 0) {
                foreach ($transactionDetails as $transactionDetail) {
                    $medicine_type = MedicineType::find($transactionDetail->medicine_type_id);

                    $transaction_recipe_real = TransactionRecipeReal::create([
                        'transaction_id' => $this->transaction_id,
                        'transaction_recipe_id' => $transactionDetail->id,
                        'product_id' => $transactionDetail->product_id,
                        'product_name' => $transactionDetail->product->name ?? '',
                        'medicine_type_id' => $transactionDetail->medicine_type_id,
                        'medicine_type_name' => $medicine_type ? $medicine_type->name : null,
                        'numero_recipe' => $transactionDetail->numero_recipe ?? 0,
                    ]);

                    foreach ($transactionDetail->transactionDetail as $detail) {
                        TransactionRecipeRealDetail::create([
                            'transaction_recipe_real_id' => $transaction_recipe_real->id,
                            'transaction_id' => $this->transaction_id,
                            'transaction_detail_id' => $detail->id,
                            'product_id' => $detail->product_id,
                            'product_name' => $detail->product->name ?? '',
                        ]);
                    }
                }
            }

            // Update encounter jika ada
            if ($encounter) {
                $dataEncounter = [
                    'pending' => true,
                    'id' => $encounter->id,
                    'transaction_id' => $transaction->id,
                    'company_id' => $transaction->company_id,
                    'location_id' => $transaction->location_id,
                    'patient_id' => $patient->id,
                    'practitioner_id' => $doctor->id,
                    'type' => 'outpatient',
                    'status' => 'in-progress',
                    'class_code' => 'AMB',
                    'hospital_discharge_text' => $this->return_recommendation,
                ];

                app(apiservice::class)->createTransaction($dataEncounter);
            }

            $routeStatus = $transaction->status == 'consultation' ? 'user.consultation.consultation' : 'user.consultation.consultation.detail';

            if ($company->with_pharmacy) {
                $status = 'process';
            } else {
                $status = $transaction->status == 'consultation' ? 'pharmacy' : $transaction->status;
            }

            // Update transaction status and consent actions
            $transaction->update([
                'status' => $status,
                'consent_actions' => $this->consent_actions,
            ]);
            // if ($transaction->transactionRecipes()->count() <= 0) {
            // } else {
            //     $this->updateServiceTransactionRecipe($transaction);
            //     $transaction->update(['status' => 'pharmacy']);
            // }

            DB::commit();

            session()->flash('saved', [
                'title' => 'Transaksi Berhasil!',
                'text' => 'Transaksi berhasil disimpan!',
            ]);

            return redirect()->route($routeStatus);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving transaction: ', [
                'transaction_id' => $this->transaction_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
                'company_id' => $companyId,
                'branch_id' => $branch->id,
            ]);
            AlertHelper::error('Gagal', 'Terjadi kesalahan: '.$e->getMessage());

            return true;
        }
    }

    public static function error($title, $message)
    {
        session()->flash('error', ['title' => $title, 'message' => $message]);
    }

    private function processDetailLevel($transaction, $data, $productService, $companyId, $branchId)
    {
        $transactionDetail = TransactionDetail::findOrFail($data['id']);

        if (! $data['product_id']) {
            return;
        }

        $product = Product::findOrFail($data['product_id']);

        $productPackage = ProductPackage::where('product_id', $product->id)->where('company_id', $companyId)->get();

        // Get product price once for efficiency
        $productPrice = ProductPrice::where('product_id', $product->id)->where('company_id', $companyId)->where('branch_id', $branchId)->first();

        $hppPrice = $productPrice ? $this->parseIntValue(number_format($productPrice->hpp_average, 0, ',', '.')) : 0;
        $quantity = $data['quantity'];
        $sellingPrice = $data['price'];
        $subTotalPrice = $data['price'] * $quantity;

        // Update transaction detail for main product
        $transactionDetail->update([
            'price_hpp' => $hppPrice,
            'sub_total_price_hpp' => $hppPrice * $quantity,
            'sub_total_price' => $subTotalPrice,
        ]);

        // Create transaction product for main product
        $this->createTransactionProduct($transaction, $data, $product, $hppPrice, $quantity, $sellingPrice);
        $productService->createProductDecrement($product->id, $quantity, null, null, $sellingPrice, null, null, null, null, null);

        // Process package products if exists
        if ($productPackage->count() > 0) {
            foreach ($productPackage as $package) {
                $childProduct = Product::find($package->product_child_id);
                if ($childProduct) {
                    $childHppPrice = 0;
                    $childQuantity = $data['quantity'] * $package->quantity;
                    $childSellingPrice = 0; // Package child products typically have 0 selling price

                    // Create separate data array for child product
                    $childData = array_merge($data, [
                        'product_id' => $childProduct->id,
                        'quantity' => $childQuantity,
                        'price' => $childSellingPrice,
                        'sub_total_price' => 0,
                    ]);

                    // $this->createTransactionProduct($transaction, $childData, $childProduct, $childHppPrice, $childQuantity, $childSellingPrice);
                    $productService->createProductDecrement($childProduct->id, $childQuantity, null, null, $childSellingPrice, null, null, null, null, null);
                }
            }
        }
    }

    public function openModalHowToUse($transactionRecipeId)
    {
        $this->transaction_recipe_id = $transactionRecipeId;
        $this->dispatch('open-modal', ['id' => 'modalHowToUse']);
    }

    public function closeModalHowToUse()
    {
        $this->reset(['transaction_recipe_id', 'name_how_to_use', 'description_how_to_use', 'day_how_to_use', 'time_how_to_use']);
        $this->dispatch('close-modal', ['id' => 'modalHowToUse']);
    }

    public function saveHowToUse()
    {
        $this->validate([
            'name_how_to_use' => 'required|string|max:255',
            'description_how_to_use' => 'required|string|max:500',
            'day_how_to_use' => 'required|integer|min:1|max:30',
            'time_how_to_use' => 'required|integer|min:1|max:24',
        ]);

        $transactionRecipe = TransactionRecipe::find($this->transaction_recipe_id);
        if (! $transactionRecipe) {
            AlertHelper::error('Gagal', 'Resep tidak ditemukan.');

            return true;
        }

        $transactionRecipe->how_to_use_id = HowToUse::create([
            'name' => $this->name_how_to_use,
            'description' => $this->description_how_to_use,
            'day' => $this->day_how_to_use,
            'time' => $this->time_how_to_use,
        ])->id;

        $transactionRecipe->save();

        $this->closeModalHowToUse();
        $this->detailMedicine();
        AlertHelper::success('Berhasil', 'Cara penggunaan berhasil disimpan.');

        return true;
    }

    private function createTransactionProduct($transaction, $data, $product, $hppPrice, $quantity, $sellingPrice)
    {
        $profit = ($sellingPrice - $hppPrice) * $quantity;

        if ($sellingPrice > 0 && $quantity > 0) {
            $margin = ($profit / ($sellingPrice * $quantity)) * 100;
        } else {
            $margin = 0;
        }

        // Batasi margin ke rentang -100 s/d 100, lalu bulatkan
        $margin = max(min($margin, 100), -100);
        $margin = round($margin);

        TransactionProduct::create([
            'transaction_id' => $transaction->id,
            'user_id' => $transaction->patient_id,
            'user_name' => $transaction->patient_name ?? '',
            'transaction_detail_id' => $data['id'],
            'product_id' => $product->id,
            'product_name' => $product->name,
            'quantity' => $quantity,
            'price' => $sellingPrice,
            'total' => $data['sub_total_price'],
            'hpp_average' => $hppPrice,
            'hpp_total' => $hppPrice * $quantity,
            'profit' => $profit,
            'margin' => $margin, // Sekarang integer
        ]);
    }

    private function updateServiceTransactionRecipe($transaction)
    {
        $transactionRecipes = TransactionRecipe::where('transaction_id', $transaction->id)->get();

        $encounter = Encounter::where('transaction_id', $transaction->id)->first();
        $patient = Patient::where('user_id', $transaction->patient_id)->select('id')->first();
        $doctor = Practitioner::where('user_id', $transaction->doctor_id)->select('id')->first();

        // Validasi data yang diperlukan
        if (! $encounter || ! $patient || ! $doctor) {
            Log::warning('Missing required data for updateServiceTransactionRecipe', [
                'transaction_id' => $transaction->id,
                'encounter_exists' => ! is_null($encounter),
                'patient_exists' => ! is_null($patient),
                'doctor_exists' => ! is_null($doctor),
            ]);

            return;
        }

        foreach ($transactionRecipes as $transactionRecipe) {
            $transactionDetails = $transactionRecipe->transactionDetail;

            foreach ($transactionDetails as $index => $transactionDetail) {
                $validity = $this->getValidatyRequest($transactionDetail, $transactionRecipe);
                $medication = Medication::where('product_id', $transactionDetail->product_id)->first();

                if (! $medication) {
                    continue;
                }

                $data = [
                    'pending' => true,
                    'id' => null,
                    'transaction_detail_id' => $transactionDetail->id,
                    'company_id' => $transaction->company_id,
                    'patient_id' => $patient->id,
                    'encounter_id' => $encounter->id,
                    'medication_id' => $medication->id,
                    'requester_id' => $doctor->id,
                    'status' => 'active',
                    'intent' => 'order',
                    'category' => 'outpatient',
                    'priority' => 'routine',
                    'course_of_therapy' => 'continuous',
                    'dosage_instructions' => [
                        [
                            'sequence' => $index + 1,
                            'text' => $transactionRecipe->howToUse->name ?? '',
                            'additional_text' => $transactionRecipe->howToUse->description ?? '',
                            'patient_instruction' => $transactionRecipe->description ?? '',
                            'timing_repeat_frequency' => $transactionRecipe->howToUse->time ?? 1,
                            'timing_repeat_period' => $transactionRecipe->howToUse->day ?? 1,
                            'timing_repeat_period_unit' => 'd',
                            'route_coding_code' => $transactionRecipe->route_coding_code ?? null,
                            'dose_rate_type_coding_code' => 'ordered',
                            'dose_rate_quantity_value' => $transactionDetail->quantity ?? 0,
                            'dose_rate_quantity_code' => $transactionDetail->product->denominator_code ?? null,
                        ],
                    ],
                    'dispense_request' => [
                        'interval_value' => 1,
                        'interval_code' => 'd',
                        'validity_start' => $validity['validity_start'] ?? null,
                        'validity_end' => $validity['validity_end'] ?? null,
                        'number_repeat' => 0,
                        'quantity_value' => $transactionDetail->quantity ?? 0,
                        'quantity_code' => trim($transactionDetail->product->denominator_code ?? ''),
                        'expect_value' => $this->parseIntValue(number_format($validity['expect_value'] ?? 0, 0, ',', '.')),
                        'expect_code' => 'd',
                    ],
                ];

                try {
                    app(apiservice::class)->createMedicationRequest($data);
                } catch (\Exception $e) {
                    Log::error('Error creating medication request', [
                        'transaction_detail_id' => $transactionDetail->id,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        }
    }

    private function getValidatyRequest($transactionDetail, $transactionRecipe): array
    {
        $total_obat = $transactionDetail->quantity ?? 0;
        $frekuensi_per_hari = $transactionRecipe->howToUse->time ?? 1;
        $interval_hari = $transactionRecipe->howToUse->day ?? 1;
        $tanggal_mulai = $transactionDetail->created_at?->format('Y-m-d') ?? now()->format('Y-m-d');

        $tanggal_mulai_obj = new \DateTime($tanggal_mulai);

        if ($interval_hari == 1) {
            // Harian
            $jumlah_hari = ceil($total_obat / $frekuensi_per_hari);
            $tanggal_habis = clone $tanggal_mulai_obj;
            $tanggal_habis->modify('+'.($jumlah_hari - 1).' days');
        } else {
            // Interval hari
            $jumlah_hari = ($total_obat - 1) * $interval_hari;
            $tanggal_habis = clone $tanggal_mulai_obj;
            $tanggal_habis->modify("+$jumlah_hari days");
        }

        return [
            'validity_start' => $tanggal_mulai_obj->format('Y-m-d'),
            'validity_end' => $tanggal_habis->format('Y-m-d'),
            'expect_value' => $jumlah_hari,
        ];
    }

    public function detailTransactionNurses()
    {
        $transactionNurses = TransactionNurse::where('transaction_id', $this->transaction_id)
            ->with(['nurse:id,name'])
            ->get();

        if ($transactionNurses->isEmpty()) {
            return [];
        }

        foreach ($transactionNurses as $transactionNurse) {
            $nurse = $transactionNurse->nurse;
            if ($nurse) {
                $this->transaction_nurses[] = $nurse->id;
            }
        }
    }

    public function openModalAlergi(): void
    {
        $this->type = 'alergi';
        $this->dispatch('open-modal', ['id' => 'modalAlergi']);
    }

    public function closeModalAlergi(): void
    {
        $this->reset(['type', 'search']);
        $this->dispatch('close-modal', ['id' => 'modalAlergi']);
    }
}
