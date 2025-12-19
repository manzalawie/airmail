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
                <a class="nav-link text-white active" href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>
            
            @php
                $modules = [
                    'returned-items' => 'Returned Items',
                    'hs-code' => 'HS Code',
                    'sorting' => 'Sorting',
                    'inbound' => 'Inbound',
                    'store' => 'Store',
                    'vns' => 'VNS',
                    'tables' => 'Tables',
                    'employee-affairs' => 'Employee Affairs',
                    'users' => 'Users',
                ];
            @endphp
            
            @foreach($modules as $module => $displayName)
                @can('view-'.$module)
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route($module.'.index') }}">
                            <i class="bi bi-{{ $module === 'hscode' ? 'file-earmark-text' : ($module === 'employeeaffairs' ? 'people' : 'box') }} me-2"></i>
                            {{ $displayName }}
                        </a>
                    </li>
                @endcan
            @endforeach
        
        </ul>
    </div>
</div>
@endauth