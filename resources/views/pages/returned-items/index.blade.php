@extends('layouts.app')

@section('title', 'Returned Items')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Returned Items</h1>

        @can('create-returned-items')
        <a href="{{ route('returned-items.create') }}"
           class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus"></i> Add Record
        </a>
        @endcan
    </div>

    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold">Daily Records</h6>
            <div>
                <button class="btn btn-sm btn-light" data-toggle="modal" data-target="#filterModal">
                    <i class="fas fa-filter"></i> Filter
                </button>
                @if(request()->hasAny(['date_from', 'date_to', 'created_by']))
                <a href="{{ route('returned-items.index') }}" class="btn btn-sm btn-warning ml-2">
                    <i class="fas fa-times"></i> Clear Filters
                </a>
                @endif
            </div>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                <tr>
                    <th rowspan="2">#</th>
                    <th rowspan="2">Date</th>
                    <th rowspan="2">Warehouse</th>
                    <th colspan="2" class="text-center">Inbound</th>
                    <th colspan="2" class="text-center">Ordinary Mail</th>
                    <th colspan="3" class="text-center bg-info text-white">UV</th>
                    <th colspan="3" class="text-center bg-success text-white">UA</th>
                    <th colspan="3" class="text-center bg-warning text-white">UL</th>
                    <th rowspan="2">Created By</th>
                    <th rowspan="2">Actions</th>
                </tr>
                <tr>
                    <!-- Inbound Sub-headers -->
                    <th>Transit</th>
                    <th>Returned</th>
                    
                    <!-- Ordinary Mail Sub-headers -->
                    <th>Transit</th>
                    <th>Returned</th>
                    
                    <!-- UV Sub-headers -->
                    <th class="bg-info text-white">Dispatches</th>
                    <th class="bg-info text-white">Items</th>
                    <th class="bg-info text-white">Weight</th>
                    
                    <!-- UA Sub-headers -->
                    <th class="bg-success text-white">Dispatches</th>
                    <th class="bg-success text-white">Items</th>
                    <th class="bg-success text-white">Weight</th>
                    
                    <!-- UL Sub-headers -->
                    <th class="bg-warning text-white">Dispatches</th>
                    <th class="bg-warning text-white">Items</th>
                    <th class="bg-warning text-white">Weight</th>
                </tr>
                </thead>
                <tbody>
                @php
                    // Initialize totals
                    $totalWarehouse = 0;
                    $totalInboundTransit = 0;
                    $totalInboundReturned = 0;
                    $totalOrdinaryMailTransit = 0;
                    $totalOrdinaryMailReturned = 0;
                    $totalUvDispatches = 0;
                    $totalUvItems = 0;
                    $totalUvWeight = 0;
                    $totalUaDispatches = 0;
                    $totalUaItems = 0;
                    $totalUaWeight = 0;
                    $totalUlDispatches = 0;
                    $totalUlItems = 0;
                    $totalUlWeight = 0;
                @endphp
                
                @forelse($items as $item)
                    @php
                        // Add to totals
                        $totalWarehouse += $item->warehouse;
                        $totalInboundTransit += $item->inbound_transit;
                        $totalInboundReturned += $item->inbound_returned;
                        $totalOrdinaryMailTransit += $item->ordinary_mail_transit;
                        $totalOrdinaryMailReturned += $item->ordinary_mail_returned;
                        $totalUvDispatches += $item->uv_dispatches;
                        $totalUvItems += $item->uv_items;
                        $totalUvWeight += $item->uv_weight;
                        $totalUaDispatches += $item->ua_dispatches;
                        $totalUaItems += $item->ua_items;
                        $totalUaWeight += $item->ua_weight;
                        $totalUlDispatches += $item->ul_dispatches;
                        $totalUlItems += $item->ul_items;
                        $totalUlWeight += $item->ul_weight;
                    @endphp
                    <tr>
                        <td>
                            @if($paginated)
                                {{ ($items->currentPage() - 1) * $items->perPage() + $loop->iteration }}
                            @else
                                {{ $loop->iteration }}
                            @endif
                        </td>
                        <td>{{ $item->day }}/{{ $item->month }}/{{ $item->year }}</td>
                        <td>{{ $item->warehouse }}</td>
                        
                        <!-- Inbound Columns -->
                        <td>{{ number_format($item->inbound_transit) }}</td>
                        <td>{{ number_format($item->inbound_returned) }}</td>
                        
                        <!-- Ordinary Mail Columns -->
                        <td>{{ number_format($item->ordinary_mail_transit) }}</td>
                        <td>{{ number_format($item->ordinary_mail_returned) }}</td>
                        
                        <!-- UV Columns -->
                        <td class="bg-info text-white">{{ number_format($item->uv_dispatches) }}</td>
                        <td class="bg-info text-white">{{ number_format($item->uv_items) }}</td>
                        <td class="bg-info text-white">{{ number_format($item->uv_weight, 2) }}</td>
                        
                        <!-- UA Columns -->
                        <td class="bg-success text-white">{{ number_format($item->ua_dispatches) }}</td>
                        <td class="bg-success text-white">{{ number_format($item->ua_items) }}</td>
                        <td class="bg-success text-white">{{ number_format($item->ua_weight, 2) }}</td>
                        
                        <!-- UL Columns -->
                        <td class="bg-warning text-white">{{ number_format($item->ul_dispatches) }}</td>
                        <td class="bg-warning text-white">{{ number_format($item->ul_items) }}</td>
                        <td class="bg-warning text-white">{{ number_format($item->ul_weight, 2) }}</td>
                        
                        <td>{{ $item->creator->name ?? 'N/A' }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                @can('edit-returned-items')
                                <a href="{{ route('returned-items.edit', $item->id) }}"
                                   class="btn btn-warning mr-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan

                                @can('delete-returned-items')
                                <form method="POST"
                                      action="{{ route('returned-items.destroy', $item->id) }}">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger"
                                            onclick="return confirm('Delete?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="19" class="text-center">No records found</td>
                    </tr>
                @endforelse
                
                <!-- Totals Row -->
                @if($items->count() > 0)
                <tr class="font-weight-bold" style="background-color: #f8f9fa;">
                    <td colspan="2" class="text-right">Totals:</td>
                    <td>{{ number_format($totalWarehouse) }}</td>
                    
                    <!-- Inbound Totals -->
                    <td>{{ number_format($totalInboundTransit) }}</td>
                    <td>{{ number_format($totalInboundReturned) }}</td>
                    
                    <!-- Ordinary Mail Totals -->
                    <td>{{ number_format($totalOrdinaryMailTransit) }}</td>
                    <td>{{ number_format($totalOrdinaryMailReturned) }}</td>
                    
                    <!-- UV Totals -->
                    <td class="bg-info text-white">{{ number_format($totalUvDispatches) }}</td>
                    <td class="bg-info text-white">{{ number_format($totalUvItems) }}</td>
                    <td class="bg-info text-white">{{ number_format($totalUvWeight, 2) }}</td>
                    
                    <!-- UA Totals -->
                    <td class="bg-success text-white">{{ number_format($totalUaDispatches) }}</td>
                    <td class="bg-success text-white">{{ number_format($totalUaItems) }}</td>
                    <td class="bg-success text-white">{{ number_format($totalUaWeight, 2) }}</td>
                    
                    <!-- UL Totals -->
                    <td class="bg-warning text-white">{{ number_format($totalUlDispatches) }}</td>
                    <td class="bg-warning text-white">{{ number_format($totalUlItems) }}</td>
                    <td class="bg-warning text-white">{{ number_format($totalUlWeight, 2) }}</td>
                    
                    <td colspan="2"></td>
                </tr>
                @endif
                </tbody>
            </table>

            <!-- Show pagination only when paginated -->
            @if($paginated && $items->count() > 0)
            <div class="mt-3">
                {{ $items->links() }}
            </div>
            @endif
            
            <!-- Show record count -->
            @if($items->count() > 0)
            <div class="mt-2 text-muted">
                Showing {{ $items->count() }} record(s)
                @if($paginated && $items->total() > $items->count())
                    of {{ $items->total() }}
                @endif
            </div>
            @endif
        </div>
    </div>
</div>

{{-- FILTER MODAL --}}
<div class="modal fade" id="filterModal">
    <div class="modal-dialog">
        <form method="GET" class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5>Filter Returned Items</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Date From</label>
                    <input type="date" name="date_from"
                           value="{{ request('date_from') }}"
                           class="form-control">
                </div>

                <div class="form-group">
                    <label>Date To</label>
                    <input type="date" name="date_to"
                           value="{{ request('date_to') }}"
                           class="form-control">
                </div>

                <div class="form-group">
                    <label>Created By</label>
                    <select name="created_by" class="form-control">
                        <option value="">All</option>
                        @foreach($creators as $creator)
                            <option value="{{ $creator->id }}"
                                {{ request('created_by') == $creator->id ? 'selected' : '' }}>
                                {{ $creator->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" name="disable_pagination" 
                               id="disable_pagination" 
                               value="1"
                               {{ request('disable_pagination') ? 'checked' : '' }}
                               class="form-check-input">
                        <label for="disable_pagination" class="form-check-label">
                            Show All Records (Disable Pagination)
                        </label>
                        <small class="form-text text-muted">
                            Automatically checked when filtering by date
                        </small>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Apply</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Auto-check disable pagination when date filters are filled
    document.addEventListener('DOMContentLoaded', function() {
        const dateFrom = document.querySelector('input[name="date_from"]');
        const dateTo = document.querySelector('input[name="date_to"]');
        const disablePagination = document.querySelector('input[name="disable_pagination"]');
        
        function checkDateFilters() {
            if (dateFrom.value || dateTo.value) {
                disablePagination.checked = true;
            }
        }
        
        if (dateFrom) dateFrom.addEventListener('change', checkDateFilters);
        if (dateTo) dateTo.addEventListener('change', checkDateFilters);
        
        // Check on page load
        checkDateFilters();
    });
</script>
@endpush