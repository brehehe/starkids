<?php

namespace App\Services\System\Observation;

use App\Models\Observation\Observation;
use Carbon\Carbon;

class ObservationService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function updateOrCreateObservation($request)
    {
        $observation = Observation::updateOrCreate(
            [
                'id' => $request?->id
            ],
            [
                'company_id'          => $request?->company_id,
                'practitioner_id'     => $request?->practitioner_id,
                'patient_id'          => $request?->patient_id,
                'encounter_id'        => $request?->encounter_id,
                'status'              => $request?->status,
                'category'            => $request?->category,
                'code'                => $request?->code,
                'effective_date_time' => Carbon::now(),
                'issued'              => Carbon::now(),
                'value_value'         => $request?->value_value,
                'value_code'          => $request?->value_code,
            ]
        );

        return $observation;
    }

    public function updateOrCreateOHObservation($observation)
    {
        $OHObservation = $observation->OHObservation()->updateOrCreate(
            [
                'observation_id' => $observation?->id
            ],
            [
                'one_health_organization_id' => $observation?->company?->OHOrganization?->id,
                'one_health_practitioner_id' => $observation?->practitioner?->OHPractitioner?->id,
                'one_health_patient_id'      => $observation?->patient?->OHPatient?->id,
                'one_health_encounter_id'    => $observation?->encounter?->OHEncounter?->id,
                'status'                     => $observation?->status,
                'effective_date_time'        => $observation?->effective_date_time,
                'issued'                     => $observation?->issued,
            ]
        );

        $OHObservation->OHObservationCategory()->updateOrCreate(
            [
                'one_health_observation_id' => $OHObservation?->id,
            ],
            [
                'coding_code' => $observation?->category
            ]
        );

        $OHObservation->OHObservationCode()->updateOrCreate(
            [
                'one_health_observation_id' => $OHObservation?->id,
            ],
            [
                'coding_code' => $observation?->code
            ]
        );

        $OHObservation->OHObservationValueQuantity()->updateOrCreate(
            [
                'one_health_observation_id' => $OHObservation?->id,
            ],
            [
                'value' => $observation?->value_value,
                'code'  => $observation?->value_code,
            ]
        );

        return $OHObservation;
    }
}
