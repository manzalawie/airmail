@extends('layouts.app')

@section('title', __('messages.create_returned_items'))

@section('content')
<div class="container-fluid">

    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('messages.create_returned_items') }}</h1>
        <a href="{{ route('returned-items.index') }}"
           class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> {{ __('messages.back') }}
        </a>
    </div>

    <!-- Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white">
            <h6 class="m-0 font-weight-bold">{{ __('messages.daily_returned_items_report') }}</h6>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('returned-items.store') }}">
                @csrf

                {{-- ================= DATE ================= --}}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>{{ __('messages.day') }} <span class="text-danger">*</span></label>
                            <input type="number" name="day" class="form-control" value="{{ old('day') }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>{{ __('messages.month') }} <span class="text-danger">*</span></label>
                            <input type="number" name="month" class="form-control" value="{{ old('month') }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>{{ __('messages.year') }} <span class="text-danger">*</span></label>
                            <input type="number" name="year" class="form-control" value="{{ old('year', date('Y')) }}" required>
                        </div>
                    </div>
                </div>

                <hr>

                {{-- ================= INBOUND ================= --}}
                <h5 class="text-primary mb-3">{{ __('messages.inbound') }}</h5>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>{{ __('messages.warehouse') }}</label>
                            <input type="number" name="warehouse" class="form-control" value="{{ old('warehouse',0) }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>{{ __('messages.inbound_transit') }}</label>
                            <input type="number" name="inbound_transit" class="form-control" value="{{ old('inbound_transit',0) }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>{{ __('messages.inbound_returned') }}</label>
                            <input type="number" name="inbound_returned" class="form-control" value="{{ old('inbound_returned',0) }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('messages.ordinary_mail_transit') }}</label>
                            <input type="number" name="ordinary_mail_transit" class="form-control" value="{{ old('ordinary_mail_transit',0) }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('messages.ordinary_mail_returned') }}</label>
                            <input type="number" name="ordinary_mail_returned" class="form-control" value="{{ old('ordinary_mail_returned',0) }}">
                        </div>
                    </div>
                </div>

                <hr>

                {{-- ================= UV ================= --}}
                <h5 class="text-info mb-3">{{ __('messages.uv_outbound') }}</h5>

                <div class="row">
                    <div class="col-md-4">
                        <label>{{ __('messages.dispatches') }}</label>
                        <input type="number" name="uv_dispatches" class="form-control" value="{{ old('uv_dispatches',0) }}">
                    </div>
                    <div class="col-md-4">
                        <label>{{ __('messages.items') }}</label>
                        <input type="number" name="uv_items" class="form-control" value="{{ old('uv_items',0) }}">
                    </div>
                    <div class="col-md-4">
                        <label>{{ __('messages.weight') }}</label>
                        <input type="number" step="0.01" name="uv_weight" class="form-control" value="{{ old('uv_weight',0) }}">
                    </div>
                </div>

                <hr>

                {{-- ================= UA ================= --}}
                <h5 class="text-warning mb-3">{{ __('messages.ua_outbound') }}</h5>

                <div class="row">
                    <div class="col-md-4">
                        <label>{{ __('messages.dispatches') }}</label>
                        <input type="number" name="ua_dispatches" class="form-control" value="{{ old('ua_dispatches',0) }}">
                    </div>
                    <div class="col-md-4">
                        <label>{{ __('messages.items') }}</label>
                        <input type="number" name="ua_items" class="form-control" value="{{ old('ua_items',0) }}">
                    </div>
                    <div class="col-md-4">
                        <label>{{ __('messages.weight') }}</label>
                        <input type="number" step="0.01" name="ua_weight" class="form-control" value="{{ old('ua_weight',0) }}">
                    </div>
                </div>

                <hr>

                {{-- ================= UL ================= --}}
                <h5 class="text-success mb-3">{{ __('messages.ul_outbound') }}</h5>

                <div class="row">
                    <div class="col-md-4">
                        <label>{{ __('messages.dispatches') }}</label>
                        <input type="number" name="ul_dispatches" class="form-control" value="{{ old('ul_dispatches',0) }}">
                    </div>
                    <div class="col-md-4">
                        <label>{{ __('messages.items') }}</label>
                        <input type="number" name="ul_items" class="form-control" value="{{ old('ul_items',0) }}">
                    </div>
                    <div class="col-md-4">
                        <label>{{ __('messages.weight') }}</label>
                        <input type="number" step="0.01" name="ul_weight" class="form-control" value="{{ old('ul_weight',0) }}">
                    </div>
                </div>

                {{-- ================= ACTIONS ================= --}}
                <div class="row mt-4">
                    <div class="col-md-12">
                        <button class="btn btn-primary px-4">
                            <i class="fas fa-save mr-2"></i> {{ __('messages.save') }}
                        </button>
                        <button type="reset" class="btn btn-outline-secondary ml-2">
                            <i class="fas fa-undo mr-2"></i> {{ __('messages.reset') }}
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

