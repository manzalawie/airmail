@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Users Management</h1>
        @can('create-user')
        <a href="{{ route('users.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-user-plus fa-sm text-white-50"></i> Add New User
        </a>
        @endcan
    </div>

    <!-- Users Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-primary text-white">
            <h6 class="m-0 font-weight-bold">System Users</h6>
            <div class="btn-group" role="group" aria-label="User Actions">
                <!-- Export Button Group -->
                <div class="btn-group mr-2" role="group">
                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-file-export"></i> Export
                    </button>
                    <div class="dropdown-menu">
                        <button class="dropdown-item export-option" type="button" data-type="csv">
                            <i class="fas fa-file-csv mr-2"></i> CSV
                        </button>
                        <button class="dropdown-item export-option" type="button" data-type="excel">
                            <i class="fas fa-file-excel mr-2"></i> Excel
                        </button>
                        <button class="dropdown-item export-option" type="button" data-type="pdf">
                            <i class="fas fa-file-pdf mr-2"></i> PDF
                        </button>
                    </div>
                </div>
                
                <!-- Filter Button -->
                <button type="button" class="btn btn-info btn-sm mr-2" data-toggle="modal" data-target="#filterModal">
                    <i class="fas fa-filter"></i> Filter
                </button>
                
                <!-- Refresh Button -->
                <button type="button" class="btn text-white font-weight-bold btn-sm" onclick="window.location.reload()">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>
            </div>
        </div>
        <div class="card-body">
            <!-- Search and Filter Row -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <form method="GET" action="{{ route('users.index') }}">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control bg-light border-0 small" placeholder="Search for users..." 
                                   value="{{ request('search') }}" aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    @if(request()->has('search') || request()->has('role') || request()->has('date_from'))
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-danger float-right ml-2">
                        <i class="fas fa-times"></i> Clear Filters
                    </a>
                    @endif
                    @if(request()->has('role') || request()->has('date_from'))
                    <span class="float-right badge badge-info p-2">
                        Active Filters: 
                        {{ request('role') ? 'Role: ' . ucfirst(request('role')) . (request('date_from') ? ', ' : '') : '' }}
                        {{ request('date_from') ? 'From: ' . request('date_from') : '' }}
                        {{ request('date_to') ? ' to ' . request('date_to') : '' }}
                    </span>
                    @endif
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="usersTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th><i class="fas fa-user mr-1"></i> Name</th>
                            <th><i class="fas fa-envelope mr-1"></i> Email</th>
                            <th><i class="fas fa-shield-alt mr-1"></i> Role</th>
                            <th><i class="fas fa-calendar-alt mr-1"></i> Created At</th>
                            <th><i class="fas fa-cog mr-1"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" 
                                         style="width: 36px; height: 36px; margin-right: 10px;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    {{ $user->name }}
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge badge-pill badge-{{ $user->getRoleNames()->first() == 'admin' ? 'success' : ($user->getRoleNames()->first() == 'manager' ? 'warning' : 'info') }}">
                                    {{ ucfirst($user->getRoleNames()->first() ?? 'user') }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm text-center" role="group">
                                    @can('view-users')
                                    <a href="" class="btn btn-info mr-1" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @endcan
                                    @can('edit-users')
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning mr-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endcan
                                    @can('delete-users')
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger mr-1" title="Delete" onclick="return confirm('Are you sure you want to delete this user?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No users found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($users->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $users->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="filterModalLabel">Filter Users</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="GET" action="{{ route('users.index') }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="roleFilter">Role</label>
                        <select class="form-control" id="roleFilter" name="role">
                            <option value="">All Roles</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Date Range</label>
                        <div class="form-row">
                            <div class="col">
                                <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}" placeholder="From">
                            </div>
                            <div class="col">
                                <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}" placeholder="To">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<!-- DataTables Scripts -->
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#usersTable').DataTable({
            responsive: true,
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            "searching": false, // Disable DataTables search as we have our own
            "paging": false, // Disable DataTables pagination as we use Laravel's
            "info": false,
            "columnDefs": [
                { "orderable": false, "targets": [5] }
            ]
        });

        // Export functionality
        $('.export-option').click(function(e) {
            e.preventDefault();
            const type = $(this).data('type');
            
            // Get current filters
            let url = new URL();
            url.searchParams.append('type', type);
            
            @if(request('search'))
            url.searchParams.append('search', '{{ request("search") }}');
            @endif
            
            @if(request('role'))
            url.searchParams.append('role', '{{ request("role") }}');
            @endif
            
            @if(request('date_from'))
            url.searchParams.append('date_from', '{{ request("date_from") }}');
            @endif
            
            @if(request('date_to'))
            url.searchParams.append('date_to', '{{ request("date_to") }}');
            @endif
            
            window.location = url.href;
        });
    });
</script>
@endsection
@endsection