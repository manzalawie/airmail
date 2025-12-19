@auth
<div class="sidebar bg-dark text-white">
    <div class="p-3">
        <div class="text-center mb-4">
            <div class="d-inline-block bg-primary rounded-circle p-3 mb-2">
                <i class="bi bi-person-circle fs-1"></i>
            </div>
            <h5 class="mb-1">{{ Auth::user()->name }}</h5>
            <small class="text-muted">{{ ucfirst(Auth::user()->getRoleNames()->first()) }}</small>
        </div>
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link text-white active {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}" href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2 me-2"></i> {{ __('messages.dashboard') }}
                </a>
            </li>
            
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
                    <li class="nav-item">
                        <a class="nav-link text-white {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}" href="{{ route($module.'.index') }}">
                            <i class="bi bi-{{ $module === 'hs-code' ? 'file-earmark-text' : ($module === 'employee-affairs' ? 'people' : 'box') }} me-2"></i>
                            {{ $displayName }}
                        </a>
                    </li>
                @endcan
            @endforeach
        
        </ul>
    </div>
</div>
@endauth