<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Doctor
    Route::apiResource('doctors', 'DoctorApiController');

    // Appointment
    Route::post('appointments/media', 'AppointmentApiController@storeMedia')->name('appointments.storeMedia');
    Route::apiResource('appointments', 'AppointmentApiController');

    // Prescription
    Route::post('prescriptions/media', 'PrescriptionApiController@storeMedia')->name('prescriptions.storeMedia');
    Route::apiResource('prescriptions', 'PrescriptionApiController');

    // Document
    Route::post('documents/media', 'DocumentApiController@storeMedia')->name('documents.storeMedia');
    Route::apiResource('documents', 'DocumentApiController');

    // Diagnose
    Route::post('diagnosis/media', 'DiagnoseApiController@storeMedia')->name('diagnosis.storeMedia');
    Route::apiResource('diagnosis', 'DiagnoseApiController');

    // Treatment
    Route::post('treatments/media', 'TreatmentApiController@storeMedia')->name('treatments.storeMedia');
    Route::apiResource('treatments', 'TreatmentApiController');

    // Medical Report
    Route::post('medical-reports/media', 'MedicalReportApiController@storeMedia')->name('medical-reports.storeMedia');
    Route::apiResource('medical-reports', 'MedicalReportApiController');

    // Insurance
    Route::apiResource('insurances', 'InsuranceApiController');

    // Emergency Contact
    Route::apiResource('emergency-contacts', 'EmergencyContactApiController');
});
