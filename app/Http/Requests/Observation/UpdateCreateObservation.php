<?php

namespace App\Http\Requests\Observation;

use App\Models\Master\CodeSystem\Observation\MasterObservationCategory;
use App\Models\Master\CodeSystem\Observation\MasterObservationCode;
use App\Models\Master\CodeSystem\Observation\MasterObservationStatus;
use App\Models\Master\CodeSystem\Observation\MasterObservationValueQuantity;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCreateObservation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'id' => 'nullable|uuid',
            'company_id' => 'required|uuid',
            'practitioner_id' => 'required|uuid',
            'patient_id' => 'required|uuid',
            'encounter_id' => 'required|uuid',
            'status' => 'required|exists:master_observation_statuses,code',
            'category' => 'required|exists:master_observation_categories,code',
            'code' => 'required|exists:master_observation_codes,code',
            'effective_date_time' => 'nullable|date',
            'issued' => 'nullable|date',
            'value_value' => 'required|numeric',
            'value_code' => 'required|exists:master_observation_value_quantities,code',
        ];
    }

    public function messages()
    {
        // statuses
        $statuses = MasterObservationStatus::pluck('display')->toArray();
        $statuses = implode(', ', $statuses);

        // categories
        $categories = MasterObservationCategory::pluck('display')->toArray();
        $categories = implode(', ', $categories);

        // codes
        $codes = MasterObservationCode::take(50)->pluck('display')->toArray();
        $codes = implode(', ', $codes);

        // value_codes
        $value_codes = MasterObservationValueQuantity::take(50)->pluck('display')->toArray();
        $value_codes = implode(', ', $value_codes);

        return [
            //
            'id.uuid' => 'ID harus berupa UUID.',
            'company_id.required' => 'Data organisasi wajib diisi.',
            'company_id.uuid' => 'Data organisasi harus berupa UUID.',
            'practitioner_id.required' => 'Data praktisi wajib diisi.',
            'practitioner_id.uuid' => 'Data praktisi harus berupa UUID.',
            'patient_id.required' => 'Data pasien wajib diisi.',
            'patient_id.uuid' => 'Data pasien harus berupa UUID.',
            'encounter_id.required' => 'Data kunjungan pasien wajib diisi.',
            'encounter_id.uuid' => 'Data kunjungan pasien harus berupa UUID.',
            'status.required' => 'Status hasil observasi wajib diisi.',
            'status.exists' => 'Status hasil observasi hanya bernilai : '.$statuses,
            'category.required' => 'Kode yang klasifikasi jenis observasi wajib diisi.',
            'category.exists' => 'Kode yang klasifikasi jenis observasi hanya bernilai : '.$categories,
            'code.required' => 'Kode observasi wajib diisi.',
            'code.exists' => 'Kode observasi hanya bernilai : '.$codes.', ...',
            'effective_date_time.date' => 'Waktu observasi hanya bernilai tanggal',
            'issued.date' => 'Waktu setelah observasi hanya bernilai tanggal',
            'value_value.required' => 'Hasil aktual observasi wajib diisi.',
            'value_value.numeric' => 'Hasil aktual observasi hanya bernilai angka.',
            'value_code.required' => 'Kode hasil aktual observasi wajib diisi.',
            'value_code.exists' => 'Kode hasil aktual observasi hanya bernilai : '.$value_codes.', ...',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Input tidak sesuai dengan ketentuan.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
