@extends('layouts.app')

@section('title', __('messages.returned_items_title'))

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('messages.returned_items_title') }}</h1>

        @can('create-returned-items')
        <a href="{{ route('returned-items.create') }}"
           class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus"></i> {{ __('messages.add_record') }}
        </a>
        @endcan
    </div>

    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold">{{ __('messages.daily_records') }}</h6>
            <div>
                <button class="btn btn-sm btn-light" data-toggle="modal" data-target="#filterModal">
                    <i class="fas fa-filter"></i> {{ __('messages.filter') }}
                </button>
                @if(request()->hasAny(['date_from', 'date_to', 'created_by']))
                <a href="{{ route('returned-items.index') }}" class="btn btn-sm btn-warning ml-2">
                    <i class="fas fa-times"></i> {{ __('messages.clear_filters') }}
                </a>
                @endif
            </div>
        </div>

        <div class="card-body table-responsive text-center">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                <tr>
                    <th rowspan="2">#</th>
                    <th rowspan="2">{{ __('messages.date') }}</th>
                    <th rowspan="2">{{ __('messages.warehouse') }}</th>
                    <th colspan="2" class="text-center">{{ __('messages.inbound') }}</th>
                    <th colspan="2" class="text-center">{{ __('messages.ordinary_mail') }}</th>
                    <th colspan="3" class="text-center bg-info text-white">UV</th>
                    <th colspan="3" class="text-center bg-success text-white">UA</th>
                    <th colspan="3" class="text-center bg-warning text-white">UL</th>
                    <th rowspan="2">{{ __('messages.created_by') }}</th>
                    <th rowspan="2">{{ __('messages.actions') }}</th>
                </tr>
                <tr>
                    <!-- Inbound Sub-headers -->
                    <th>{{ __('messages.transit') }}</th>
                    <th>{{ __('messages.returned') }}</th>
                    
                    <!-- Ordinary Mail Sub-headers -->
                    <th>{{ __('messages.transit') }}</th>
                    <th>{{ __('messages.returned') }}</th>
                    
                    <!-- UV Sub-headers -->
                    <th class="bg-info text-white">{{ __('messages.dispatches') }}</th>
                    <th class="bg-info text-white">{{ __('messages.items') }}</th>
                    <th class="bg-info text-white">{{ __('messages.weight') }}</th>
                    
                    <!-- UA Sub-headers -->
                    <th class="bg-success text-white">{{ __('messages.dispatches') }}</th>
                    <th class="bg-success text-white">{{ __('messages.items') }}</th>
                    <th class="bg-success text-white">{{ __('messages.weight') }}</th>
                    
                    <!-- UL Sub-headers -->
                    <th class="bg-warning text-white">{{ __('messages.dispatches') }}</th>
                    <th class="bg-warning text-white">{{ __('messages.items') }}</th>
                    <th class="bg-warning text-white">{{ __('messages.weight') }}</th>
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
                            <div class="btn-group btn-group-sm text-center" role="group">
                                @can('edit-returned-items')
                                <a href="{{ route('returned-items.edit', $item->id) }}"
                                   class="btn btn-warning mr-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan

                                @can('delete-returned-items')
                                <form method="POST"
                                      action="{{ route('returned-items.destroy', $item->id) }}">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger mr-1"
                                            onclick="return confirm('{{ __('messages.delete_confirmation') }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="19" class="text-center">{{ __('messages.no_records_found') }}</td>
                    </tr>
                @endforelse
                
                <!-- Totals Row -->
                @if($items->count() > 0)
                <tr class="font-weight-bold" style="background-color: #f8f9fa;">
                    <td colspan="2" class="text-right">{{ __('messages.totals') }}:</td>
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
                {{ __('messages.showing_records', ['count' => $items->count()]) }}
                @if($paginated && $items->total() > $items->count())
                    {{ __('messages.of_total', ['total' => $items->total()]) }}
                @endif
            </div>
            @endif
        </div>
    </div>
</div>

{{-- FILTER MODAL --}}
<div class="modal fade {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}" id="filterModal">
    <div class="modal-dialog">
        <form method="GET" class="modal-content">
            <div class="modal-header bg-primary text-white">
                    <h5>{{ __('messages.filter_returned_items') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" style="{{ app()->getLocale() === 'ar' ? 'margin-left:0' : 'margin-right:0' }};">&times;</button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>{{ __('messages.date_from') }}</label>
                    <input type="date" name="date_from"
                           value="{{ request('date_from') }}"
                           class="form-control">
                </div>

                <div class="form-group">
                    <label>{{ __('messages.date_to') }}</label>
                    <input type="date" name="date_to"
                           value="{{ request('date_to') }}"
                           class="form-control">
                </div>

                <div class="form-group">
                    <label>{{ __('messages.created_by') }}</label>
                    <select name="created_by" class="form-control">
                        <option value="">{{ __('messages.all') }}</option>
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
                        <label for="disable_pagination" class="form-check-label {{ app()->getLocale() === 'ar' ? 'mr-3' : '' }}">
                            {{ __('messages.show_all_records') }}
                        </label>
                        <small class="form-text text-muted">
                            {{ __('messages.automatically_checked') }}
                        </small>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.close') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('messages.apply') }}</button>
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
@push('styles')
<style>
    /* Make entire row change color on hover */
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.1) !important;
        cursor: pointer;
    }
    
    /* Ensure all cells in the row have the same background on hover */
    .table-hover tbody tr:hover td {
        background-color: transparent !important;
    }
    
    /* Specific handling for colored cells */
    .table-hover tbody tr:hover td.bg-info {
        background-color: rgba(23, 162, 184, 0.3) !important;
    }
    
    .table-hover tbody tr:hover td.bg-success {
        background-color: rgba(40, 167, 69, 0.3) !important;
    }
    
    .table-hover tbody tr:hover td.bg-warning {
        background-color: rgba(255, 193, 7, 0.3) !important;
    }
</style>
@endpush