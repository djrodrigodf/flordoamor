<?php

Route::get('/', \App\Livewire\Welcome::class);
Route::get('doctors', \App\Livewire\Admin\DoctorComponent::class);
Route::get('patients', \App\Livewire\Admin\PatientComponent::class);
Route::get('patient/{id}', \App\Livewire\Admin\PatientDetail::class)->name('patient.detail');
Route::get('documents', \App\Livewire\Admin\DocumentIndex::class)->name('documents');
Route::get('documents/create', \App\Livewire\Admin\DocumentCreate::class)->name('documents.create');

Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::get('/', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('home');

    // Permissions
    Route::delete('permissions/destroy', [App\Http\Controllers\Admin\PermissionsController::class, 'massDestroy'])->name('permissions.massDestroy');
    Route::resource('permissions', App\Http\Controllers\Admin\PermissionsController::class);

    // Roles
    Route::delete('roles/destroy', [App\Http\Controllers\Admin\RolesController::class, 'massDestroy'])->name('roles.massDestroy');
    Route::resource('roles', App\Http\Controllers\Admin\RolesController::class);

    // Users
    Route::delete('users/destroy', [App\Http\Controllers\Admin\UsersController::class, 'massDestroy'])->name('users.massDestroy');
    Route::resource('users', App\Http\Controllers\Admin\UsersController::class);

    // Patient
    Route::delete('patients/destroy', [App\Http\Controllers\Admin\PatientController::class, 'massDestroy'])->name('patients.massDestroy');
    Route::post('patients/media', [App\Http\Controllers\Admin\PatientController::class, 'storeMedia'])->name('patients.storeMedia');
    Route::post('patients/ckmedia', [App\Http\Controllers\Admin\PatientController::class, 'storeCKEditorImages'])->name('patients.storeCKEditorImages');
    Route::resource('patients', App\Http\Controllers\Admin\PatientController::class);

    // Doctor
    Route::delete('doctors/destroy', [App\Http\Controllers\Admin\DoctorController::class, 'massDestroy'])->name('doctors.massDestroy');
    Route::resource('doctors', App\Http\Controllers\Admin\DoctorController::class);

    // Appointment
    Route::delete('appointments/destroy', [App\Http\Controllers\Admin\AppointmentController::class, 'massDestroy'])->name('appointments.massDestroy');
    Route::post('appointments/media', [App\Http\Controllers\Admin\AppointmentController::class, 'storeMedia'])->name('appointments.storeMedia');
    Route::post('appointments/ckmedia', [App\Http\Controllers\Admin\AppointmentController::class, 'storeCKEditorImages'])->name('appointments.storeCKEditorImages');
    Route::resource('appointments', App\Http\Controllers\Admin\AppointmentController::class);

    // Prescription
    Route::delete('prescriptions/destroy', [App\Http\Controllers\Admin\PrescriptionController::class, 'massDestroy'])->name('prescriptions.massDestroy');
    Route::post('prescriptions/media', [App\Http\Controllers\Admin\PrescriptionController::class, 'storeMedia'])->name('prescriptions.storeMedia');
    Route::post('prescriptions/ckmedia', [App\Http\Controllers\Admin\PrescriptionController::class, 'storeCKEditorImages'])->name('prescriptions.storeCKEditorImages');
    Route::resource('prescriptions', App\Http\Controllers\Admin\PrescriptionController::class);

    // Document
    Route::delete('documents/destroy', [App\Http\Controllers\Admin\DocumentController::class, 'massDestroy'])->name('documents.massDestroy');
    Route::post('documents/media', [App\Http\Controllers\Admin\DocumentController::class, 'storeMedia'])->name('documents.storeMedia');
    Route::post('documents/ckmedia', [App\Http\Controllers\Admin\DocumentController::class, 'storeCKEditorImages'])->name('documents.storeCKEditorImages');
    Route::resource('documents', App\Http\Controllers\Admin\DocumentController::class);

    // Diagnose
    Route::delete('diagnosis/destroy', [App\Http\Controllers\Admin\DiagnoseController::class, 'massDestroy'])->name('diagnosis.massDestroy');
    Route::post('diagnosis/media', [App\Http\Controllers\Admin\DiagnoseController::class, 'storeMedia'])->name('diagnosis.storeMedia');
    Route::post('diagnosis/ckmedia', [App\Http\Controllers\Admin\DiagnoseController::class, 'storeCKEditorImages'])->name('diagnosis.storeCKEditorImages');
    Route::resource('diagnosis', App\Http\Controllers\Admin\DiagnoseController::class);

    // Treatment
    Route::delete('treatments/destroy', [App\Http\Controllers\Admin\TreatmentController::class, 'massDestroy'])->name('treatments.massDestroy');
    Route::post('treatments/media', [App\Http\Controllers\Admin\TreatmentController::class, 'storeMedia'])->name('treatments.storeMedia');
    Route::post('treatments/ckmedia', [App\Http\Controllers\Admin\TreatmentController::class, 'storeCKEditorImages'])->name('treatments.storeCKEditorImages');
    Route::resource('treatments', App\Http\Controllers\Admin\TreatmentController::class);

    // Medical Report
    Route::delete('medical-reports/destroy', [App\Http\Controllers\Admin\MedicalReportController::class, 'massDestroy'])->name('medical-reports.massDestroy');
    Route::post('medical-reports/media', [App\Http\Controllers\Admin\MedicalReportController::class, 'storeMedia'])->name('medical-reports.storeMedia');
    Route::post('medical-reports/ckmedia', [App\Http\Controllers\Admin\MedicalReportController::class, 'storeCKEditorImages'])->name('medical-reports.storeCKEditorImages');
    Route::resource('medical-reports', App\Http\Controllers\Admin\MedicalReportController::class);

    // Insurance
    Route::delete('insurances/destroy', [App\Http\Controllers\Admin\InsuranceController::class, 'massDestroy'])->name('insurances.massDestroy');
    Route::resource('insurances', App\Http\Controllers\Admin\InsuranceController::class);

    // Emergency Contact
    Route::delete('emergency-contacts/destroy', [App\Http\Controllers\Admin\EmergencyContactController::class, 'massDestroy'])->name('emergency-contacts.massDestroy');
    Route::resource('emergency-contacts', App\Http\Controllers\Admin\EmergencyContactController::class);

    // Audit Logs
    Route::resource('audit-logs', App\Http\Controllers\Admin\AuditLogsController::class, ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // User Alerts
    Route::delete('user-alerts/destroy', [App\Http\Controllers\Admin\UserAlertsController::class, 'massDestroy'])->name('user-alerts.massDestroy');
    Route::get('user-alerts/read', [App\Http\Controllers\Admin\UserAlertsController::class, 'read']);
    Route::resource('user-alerts', App\Http\Controllers\Admin\UserAlertsController::class, ['except' => ['edit', 'update']]);

    Route::get('system-calendar', [App\Http\Controllers\Admin\SystemCalendarController::class, 'index'])->name('systemCalendar');
    Route::get('global-search', [App\Http\Controllers\Admin\GlobalSearchController::class, 'search'])->name('globalSearch');
    Route::get('messenger', [App\Http\Controllers\Admin\MessengerController::class, 'index'])->name('messenger.index');
    Route::get('messenger/create', [App\Http\Controllers\Admin\MessengerController::class, 'createTopic'])->name('messenger.createTopic');
    Route::post('messenger', [App\Http\Controllers\Admin\MessengerController::class, 'storeTopic'])->name('messenger.storeTopic');
    Route::get('messenger/inbox', [App\Http\Controllers\Admin\MessengerController::class, 'showInbox'])->name('messenger.showInbox');
    Route::get('messenger/outbox', [App\Http\Controllers\Admin\MessengerController::class, 'showOutbox'])->name('messenger.showOutbox');
    Route::get('messenger/{topic}', [App\Http\Controllers\Admin\MessengerController::class, 'showMessages'])->name('messenger.showMessages');
    Route::delete('messenger/{topic}', [App\Http\Controllers\Admin\MessengerController::class, 'destroyTopic'])->name('messenger.destroyTopic');
    Route::post('messenger/{topic}/reply', [App\Http\Controllers\Admin\MessengerController::class, 'replyToTopic'])->name('messenger.reply');
    Route::get('messenger/{topic}/reply', [App\Http\Controllers\Admin\MessengerController::class, 'showReply'])->name('messenger.showReply');
});

Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
