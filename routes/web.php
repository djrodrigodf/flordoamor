<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Patient
    Route::delete('patients/destroy', 'PatientController@massDestroy')->name('patients.massDestroy');
    Route::post('patients/media', 'PatientController@storeMedia')->name('patients.storeMedia');
    Route::post('patients/ckmedia', 'PatientController@storeCKEditorImages')->name('patients.storeCKEditorImages');
    Route::resource('patients', 'PatientController');

    // Doctor
    Route::delete('doctors/destroy', 'DoctorController@massDestroy')->name('doctors.massDestroy');
    Route::resource('doctors', 'DoctorController');

    // Appointment
    Route::delete('appointments/destroy', 'AppointmentController@massDestroy')->name('appointments.massDestroy');
    Route::post('appointments/media', 'AppointmentController@storeMedia')->name('appointments.storeMedia');
    Route::post('appointments/ckmedia', 'AppointmentController@storeCKEditorImages')->name('appointments.storeCKEditorImages');
    Route::resource('appointments', 'AppointmentController');

    // Prescription
    Route::delete('prescriptions/destroy', 'PrescriptionController@massDestroy')->name('prescriptions.massDestroy');
    Route::post('prescriptions/media', 'PrescriptionController@storeMedia')->name('prescriptions.storeMedia');
    Route::post('prescriptions/ckmedia', 'PrescriptionController@storeCKEditorImages')->name('prescriptions.storeCKEditorImages');
    Route::resource('prescriptions', 'PrescriptionController');

    // Document
    Route::delete('documents/destroy', 'DocumentController@massDestroy')->name('documents.massDestroy');
    Route::post('documents/media', 'DocumentController@storeMedia')->name('documents.storeMedia');
    Route::post('documents/ckmedia', 'DocumentController@storeCKEditorImages')->name('documents.storeCKEditorImages');
    Route::resource('documents', 'DocumentController');

    // Diagnose
    Route::delete('diagnosis/destroy', 'DiagnoseController@massDestroy')->name('diagnosis.massDestroy');
    Route::post('diagnosis/media', 'DiagnoseController@storeMedia')->name('diagnosis.storeMedia');
    Route::post('diagnosis/ckmedia', 'DiagnoseController@storeCKEditorImages')->name('diagnosis.storeCKEditorImages');
    Route::resource('diagnosis', 'DiagnoseController');

    // Treatment
    Route::delete('treatments/destroy', 'TreatmentController@massDestroy')->name('treatments.massDestroy');
    Route::post('treatments/media', 'TreatmentController@storeMedia')->name('treatments.storeMedia');
    Route::post('treatments/ckmedia', 'TreatmentController@storeCKEditorImages')->name('treatments.storeCKEditorImages');
    Route::resource('treatments', 'TreatmentController');

    // Medical Report
    Route::delete('medical-reports/destroy', 'MedicalReportController@massDestroy')->name('medical-reports.massDestroy');
    Route::post('medical-reports/media', 'MedicalReportController@storeMedia')->name('medical-reports.storeMedia');
    Route::post('medical-reports/ckmedia', 'MedicalReportController@storeCKEditorImages')->name('medical-reports.storeCKEditorImages');
    Route::resource('medical-reports', 'MedicalReportController');

    // Insurance
    Route::delete('insurances/destroy', 'InsuranceController@massDestroy')->name('insurances.massDestroy');
    Route::resource('insurances', 'InsuranceController');

    // Emergency Contact
    Route::delete('emergency-contacts/destroy', 'EmergencyContactController@massDestroy')->name('emergency-contacts.massDestroy');
    Route::resource('emergency-contacts', 'EmergencyContactController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // User Alerts
    Route::delete('user-alerts/destroy', 'UserAlertsController@massDestroy')->name('user-alerts.massDestroy');
    Route::get('user-alerts/read', 'UserAlertsController@read');
    Route::resource('user-alerts', 'UserAlertsController', ['except' => ['edit', 'update']]);

    Route::get('system-calendar', 'SystemCalendarController@index')->name('systemCalendar');
    Route::get('global-search', 'GlobalSearchController@search')->name('globalSearch');
    Route::get('messenger', 'MessengerController@index')->name('messenger.index');
    Route::get('messenger/create', 'MessengerController@createTopic')->name('messenger.createTopic');
    Route::post('messenger', 'MessengerController@storeTopic')->name('messenger.storeTopic');
    Route::get('messenger/inbox', 'MessengerController@showInbox')->name('messenger.showInbox');
    Route::get('messenger/outbox', 'MessengerController@showOutbox')->name('messenger.showOutbox');
    Route::get('messenger/{topic}', 'MessengerController@showMessages')->name('messenger.showMessages');
    Route::delete('messenger/{topic}', 'MessengerController@destroyTopic')->name('messenger.destroyTopic');
    Route::post('messenger/{topic}/reply', 'MessengerController@replyToTopic')->name('messenger.reply');
    Route::get('messenger/{topic}/reply', 'MessengerController@showReply')->name('messenger.showReply');
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
