<aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 917px;">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">{{ trans('panel.site_title') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li>
                    <select class="searchable-field form-control">

                    </select>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs("admin.home") ? "active" : "" }}" href="{{ route("admin.home") }}">
                        <i class="fas fa-fw fa-tachometer-alt nav-icon">
                        </i>
                        <p>
                            {{ trans('global.dashboard') }}
                        </p>
                    </a>
                </li>
                @can('user_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/permissions*") ? "menu-open" : "" }} {{ request()->is("admin/roles*") ? "menu-open" : "" }} {{ request()->is("admin/users*") ? "menu-open" : "" }} {{ request()->is("admin/audit-logs*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/permissions*") ? "active" : "" }} {{ request()->is("admin/roles*") ? "active" : "" }} {{ request()->is("admin/users*") ? "active" : "" }} {{ request()->is("admin/audit-logs*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-users">

                            </i>
                            <p>
                                {{ trans('cruds.userManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('permission_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-unlock-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.permission.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('role_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-briefcase">

                                        </i>
                                        <p>
                                            {{ trans('cruds.role.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('user_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-user">

                                        </i>
                                        <p>
                                            {{ trans('cruds.user.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('audit_log_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.audit-logs.index") }}" class="nav-link {{ request()->is("admin/audit-logs") || request()->is("admin/audit-logs/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-file-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.auditLog.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('patient_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.patients.index") }}" class="nav-link {{ request()->is("admin/patients") || request()->is("admin/patients/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-user-friends">

                            </i>
                            <p>
                                {{ trans('cruds.patient.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('doctor_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.doctors.index") }}" class="nav-link {{ request()->is("admin/doctors") || request()->is("admin/doctors/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-user-md">

                            </i>
                            <p>
                                {{ trans('cruds.doctor.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('appointment_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.appointments.index") }}" class="nav-link {{ request()->is("admin/appointments") || request()->is("admin/appointments/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-calendar-check">

                            </i>
                            <p>
                                {{ trans('cruds.appointment.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('prescription_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.prescriptions.index") }}" class="nav-link {{ request()->is("admin/prescriptions") || request()->is("admin/prescriptions/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-file-medical-alt">

                            </i>
                            <p>
                                {{ trans('cruds.prescription.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('document_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.documents.index") }}" class="nav-link {{ request()->is("admin/documents") || request()->is("admin/documents/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-copy">

                            </i>
                            <p>
                                {{ trans('cruds.document.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('diagnosi_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.diagnosis.index") }}" class="nav-link {{ request()->is("admin/diagnosis") || request()->is("admin/diagnosis/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-file-medical">

                            </i>
                            <p>
                                {{ trans('cruds.diagnosi.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('treatment_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.treatments.index") }}" class="nav-link {{ request()->is("admin/treatments") || request()->is("admin/treatments/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-briefcase-medical">

                            </i>
                            <p>
                                {{ trans('cruds.treatment.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('medical_report_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.medical-reports.index") }}" class="nav-link {{ request()->is("admin/medical-reports") || request()->is("admin/medical-reports/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-cogs">

                            </i>
                            <p>
                                {{ trans('cruds.medicalReport.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('insurance_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.insurances.index") }}" class="nav-link {{ request()->is("admin/insurances") || request()->is("admin/insurances/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-heartbeat">

                            </i>
                            <p>
                                {{ trans('cruds.insurance.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('emergency_contact_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.emergency-contacts.index") }}" class="nav-link {{ request()->is("admin/emergency-contacts") || request()->is("admin/emergency-contacts/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-user-shield">

                            </i>
                            <p>
                                {{ trans('cruds.emergencyContact.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('user_alert_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.user-alerts.index") }}" class="nav-link {{ request()->is("admin/user-alerts") || request()->is("admin/user-alerts/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-bell">

                            </i>
                            <p>
                                {{ trans('cruds.userAlert.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                <li class="nav-item">
                    <a href="{{ route("admin.systemCalendar") }}" class="nav-link {{ request()->is("admin/system-calendar") || request()->is("admin/system-calendar/*") ? "active" : "" }}">
                        <i class="fas fa-fw fa-calendar nav-icon">

                        </i>
                        <p>
                            {{ trans('global.systemCalendar') }}
                        </p>
                    </a>
                </li>
                @php($unread = \App\Models\QaTopic::unreadCount())
                    <li class="nav-item">
                        <a href="{{ route("admin.messenger.index") }}" class="{{ request()->is("admin/messenger") || request()->is("admin/messenger/*") ? "active" : "" }} nav-link">
                            <i class="fa-fw fa fa-envelope nav-icon">

                            </i>
                            <p>{{ trans('global.messages') }}</p>
                            @if($unread > 0)
                                <strong>( {{ $unread }} )</strong>
                            @endif

                        </a>
                    </li>
                    @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                        @can('profile_password_edit')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}" href="{{ route('profile.password.edit') }}">
                                    <i class="fa-fw fas fa-key nav-icon">
                                    </i>
                                    <p>
                                        {{ trans('global.change_password') }}
                                    </p>
                                </a>
                            </li>
                        @endcan
                    @endif
                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                            <p>
                                <i class="fas fa-fw fa-sign-out-alt nav-icon">

                                </i>
                                <p>{{ trans('global.logout') }}</p>
                            </p>
                        </a>
                    </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
