@extends('layouts.app')

@section('title', __('messages.dashboard'))

@section('content')
<div class="container-fluid">
    <!-- Welcome Card -->
    <div class="card welcome-card text-white mb-4">
        <div class="card-body p-5">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-4 fw-bold">{{ __('messages.welcome_back', ['name' => Auth::user()->name]) }}</h1>
                    <p class="lead mb-0">{{ __('messages.logged_in_as', ['role' => Auth::user()->role_display_name]) }}</p>
                </div>
                <div class="col-md-4 text-center">
                    <i class="bi bi-person-check" style="font-size: 5rem; opacity: 0.8;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
        @php
            $modules = [
                'returned-items' => __('messages.returned_items'),
                'hs-code' => __('messages.hs_code'),
                'sorting' => __('messages.sorting'),
                'inbound' => __('messages.inbound'),
                'store' => __('messages.store'),
                'vns' => __('messages.vns'),
                'tables' => __('messages.tables'),
                'employee-affairs' => __('messages.employee_affairs'),
                'users' => __('messages.users'),
            ];
        @endphp

        @foreach($modules as $module => $displayName)
            @can('view-'.$module)
                <div class="col-md-4 mt-2">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">{{ $displayName }}</h5>
                                    <p class="card-text text-muted">{{ __('messages.manage_records', ['module' => strtolower($displayName)]) }}</p>
                                </div>
                                <i class="bi bi-{{ $module === 'hscode' ? 'file-earmark-text' : ($module === 'employeeaffairs' ? 'people' : 'box') }} fs-1 text-primary"></i>
                            </div>
                            <a href="{{ route($module.'.index') }}" class="btn btn-outline-primary mt-3">{{ __('messages.go_to_module') }}</a>
                        </div>
                    </div>
                </div>
            @endcan
        @endforeach

    </div>

    <!-- Recent Activity -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">{{ __('messages.recent_activity') }}</h5>
        </div>
        <div class="card-body">
            <!-- Activity content here -->
            <p class="text-muted">{{ __('messages.no_recent_activity') }}</p>
        </div>
    </div>
</div>
@endsection