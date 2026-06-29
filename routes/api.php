<?php

use App\Http\Controllers\API\OneHealth\Auth\AuthController;
use App\Http\Controllers\API\OneHealth\Consultation\ConsultationIndex;
use App\Http\Controllers\API\OneHealth\Deployment\PatientController;
use App\Http\Controllers\API\OneHealth\MasterData\RegionController;
use App\Http\Controllers\API\Onehealth\Organization\OrganizationController;
use App\Http\Controllers\API\OneHealth\OutPatient\EncounterController;
use App\Http\Controllers\API\Promotion\PromotionController;
use App\Http\Controllers\API\TestingController;
use App\Http\Controllers\NotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/access-token', [AuthController::class, 'accessToken']);

// Promotion Routes
Route::middleware('auth:sanctum')->group(function () {
    // Customer promotion routes
    Route::prefix('promotions')->group(function () {
        Route::get('/', [PromotionController::class, 'getAvailablePromotions']);
        Route::post('/apply', [PromotionController::class, 'applyPromotion']);
        Route::post('/auto-apply', [PromotionController::class, 'getAutoPromotions']);
    });

    // Admin promotion management routes
    Route::middleware('role:Super Admin|Admin')->prefix('admin/promotions')->group(function () {
        Route::get('/', [PromotionController::class, 'index']);
        Route::post('/', [PromotionController::class, 'store']);
        Route::get('/analytics', [PromotionController::class, 'analytics']);
        Route::get('/{id}', [PromotionController::class, 'show']);
        Route::put('/{id}', [PromotionController::class, 'update']);
        Route::delete('/{id}', [PromotionController::class, 'destroy']);
        Route::post('/{id}/clone', [PromotionController::class, 'clone']);
    });
});

// Notification routes
Route::prefix('notifications')->group(function () {
    Route::get('/', [NotificationController::class, 'index']);
    Route::post('/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead']);
});

Route::prefix('/master-data')->group(function () {
    Route::get('/province', [RegionController::class, 'getProvince']);
    Route::get('/city', [RegionController::class, 'getCity']);
    Route::get('/district', [RegionController::class, 'getDistrict']);
    Route::get('/sub-district', [RegionController::class, 'getSubDistrist']);
});

Route::prefix('/deployment')->group(function () {
    Route::post('/create-patient', [PatientController::class, 'createPatient']);
    Route::get('/get-patient/{patient_id}', [PatientController::class, 'getPatient']);
});

Route::prefix('/out-patient')->group(function () {
    Route::post('/create-encounter', [EncounterController::class, 'createEncounter']);
});

Route::prefix('organization')->group(function () {
    Route::post('/create', [OrganizationController::class, 'createOrganization']);
});

Route::prefix('/testing')->group(function () {
    Route::get('/everything', [TestingController::class, 'everything']);

    Route::prefix('/company')->group(function () {
        Route::post('/post-put', [TestingController::class, 'postPutCompany']);
        Route::get('/get', [TestingController::class, 'getCompany']);
    });
    Route::prefix('/location')->group(function () {
        Route::post('/post-put', [TestingController::class, 'postPutLocation']);
    });

    Route::prefix('/practitiont')->group(function () {
        Route::get('/get-by-nik', [TestingController::class, 'getPractitiont']);
    });

    Route::prefix('/patient')->group(function () {
        Route::post('/post-put', [TestingController::class, 'postPutPatient']);
        Route::get('/get-nik', [TestingController::class, 'getPatient']);
    });

    Route::prefix('/encounter')->group(function () {
        Route::post('/post-put', [TestingController::class, 'postPutEncounter']);
    });

    Route::prefix('/condition')->group(function () {
        Route::post('/post-put', [ConsultationIndex::class, 'postPutConsultation']);
        Route::post('/postput', [TestingController::class, 'postPutCondition']);
    });

    Route::prefix('/medication')->group(function () {
        Route::post('/post-put', [TestingController::class, 'postPutMedication']);
    });

    Route::prefix('/medication-request')->group(function () {
        Route::post('/post-put', [TestingController::class, 'postPutMedicationRequest']);
    });

    Route::prefix('/medication-dispense')->group(function () {
        Route::post('/post-put', [TestingController::class, 'postPutMedicationDispense']);
    });

    Route::prefix('/observation')->group(function () {
        Route::post('/post-put', [TestingController::class, 'postPutObservation']);
    });
});
