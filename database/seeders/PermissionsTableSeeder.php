<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id' => 1,
                'title' => 'user_management_access',
            ],
            [
                'id' => 2,
                'title' => 'permission_create',
            ],
            [
                'id' => 3,
                'title' => 'permission_edit',
            ],
            [
                'id' => 4,
                'title' => 'permission_show',
            ],
            [
                'id' => 5,
                'title' => 'permission_delete',
            ],
            [
                'id' => 6,
                'title' => 'permission_access',
            ],
            [
                'id' => 7,
                'title' => 'role_create',
            ],
            [
                'id' => 8,
                'title' => 'role_edit',
            ],
            [
                'id' => 9,
                'title' => 'role_show',
            ],
            [
                'id' => 10,
                'title' => 'role_delete',
            ],
            [
                'id' => 11,
                'title' => 'role_access',
            ],
            [
                'id' => 12,
                'title' => 'user_create',
            ],
            [
                'id' => 13,
                'title' => 'user_edit',
            ],
            [
                'id' => 14,
                'title' => 'user_show',
            ],
            [
                'id' => 15,
                'title' => 'user_delete',
            ],
            [
                'id' => 16,
                'title' => 'user_access',
            ],
            [
                'id' => 17,
                'title' => 'patient_create',
            ],
            [
                'id' => 18,
                'title' => 'patient_edit',
            ],
            [
                'id' => 19,
                'title' => 'patient_show',
            ],
            [
                'id' => 20,
                'title' => 'patient_delete',
            ],
            [
                'id' => 21,
                'title' => 'patient_access',
            ],
            [
                'id' => 22,
                'title' => 'doctor_create',
            ],
            [
                'id' => 23,
                'title' => 'doctor_edit',
            ],
            [
                'id' => 24,
                'title' => 'doctor_show',
            ],
            [
                'id' => 25,
                'title' => 'doctor_delete',
            ],
            [
                'id' => 26,
                'title' => 'doctor_access',
            ],
            [
                'id' => 27,
                'title' => 'appointment_create',
            ],
            [
                'id' => 28,
                'title' => 'appointment_edit',
            ],
            [
                'id' => 29,
                'title' => 'appointment_show',
            ],
            [
                'id' => 30,
                'title' => 'appointment_delete',
            ],
            [
                'id' => 31,
                'title' => 'appointment_access',
            ],
            [
                'id' => 32,
                'title' => 'prescription_create',
            ],
            [
                'id' => 33,
                'title' => 'prescription_edit',
            ],
            [
                'id' => 34,
                'title' => 'prescription_show',
            ],
            [
                'id' => 35,
                'title' => 'prescription_delete',
            ],
            [
                'id' => 36,
                'title' => 'prescription_access',
            ],
            [
                'id' => 37,
                'title' => 'document_create',
            ],
            [
                'id' => 38,
                'title' => 'document_edit',
            ],
            [
                'id' => 39,
                'title' => 'document_show',
            ],
            [
                'id' => 40,
                'title' => 'document_delete',
            ],
            [
                'id' => 41,
                'title' => 'document_access',
            ],
            [
                'id' => 42,
                'title' => 'diagnosi_create',
            ],
            [
                'id' => 43,
                'title' => 'diagnosi_edit',
            ],
            [
                'id' => 44,
                'title' => 'diagnosi_show',
            ],
            [
                'id' => 45,
                'title' => 'diagnosi_delete',
            ],
            [
                'id' => 46,
                'title' => 'diagnosi_access',
            ],
            [
                'id' => 47,
                'title' => 'treatment_create',
            ],
            [
                'id' => 48,
                'title' => 'treatment_edit',
            ],
            [
                'id' => 49,
                'title' => 'treatment_show',
            ],
            [
                'id' => 50,
                'title' => 'treatment_delete',
            ],
            [
                'id' => 51,
                'title' => 'treatment_access',
            ],
            [
                'id' => 52,
                'title' => 'medical_report_create',
            ],
            [
                'id' => 53,
                'title' => 'medical_report_edit',
            ],
            [
                'id' => 54,
                'title' => 'medical_report_show',
            ],
            [
                'id' => 55,
                'title' => 'medical_report_delete',
            ],
            [
                'id' => 56,
                'title' => 'medical_report_access',
            ],
            [
                'id' => 57,
                'title' => 'insurance_create',
            ],
            [
                'id' => 58,
                'title' => 'insurance_edit',
            ],
            [
                'id' => 59,
                'title' => 'insurance_show',
            ],
            [
                'id' => 60,
                'title' => 'insurance_delete',
            ],
            [
                'id' => 61,
                'title' => 'insurance_access',
            ],
            [
                'id' => 62,
                'title' => 'emergency_contact_create',
            ],
            [
                'id' => 63,
                'title' => 'emergency_contact_edit',
            ],
            [
                'id' => 64,
                'title' => 'emergency_contact_show',
            ],
            [
                'id' => 65,
                'title' => 'emergency_contact_delete',
            ],
            [
                'id' => 66,
                'title' => 'emergency_contact_access',
            ],
            [
                'id' => 67,
                'title' => 'audit_log_show',
            ],
            [
                'id' => 68,
                'title' => 'audit_log_access',
            ],
            [
                'id' => 69,
                'title' => 'user_alert_create',
            ],
            [
                'id' => 70,
                'title' => 'user_alert_show',
            ],
            [
                'id' => 71,
                'title' => 'user_alert_delete',
            ],
            [
                'id' => 72,
                'title' => 'user_alert_access',
            ],
            [
                'id' => 73,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
