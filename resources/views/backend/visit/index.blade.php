@extends('backend.layouts.app')
@section('title', @$data['title'])

@section('style')
<style>
    .visit_table td{
        max-width: 200px !important;
        white-space: normal !important;
    }

</style>
@endsection
@section('content')
    {!! breadcrumb([
        'title' => @$data['title'],
        route('admin.dashboard') => _trans('common.Dashboard'),
        '#' => @$data['title'],
    ]) !!}

    @if(Auth::user()->department_id == 7 || Auth::user()->department_id == 6 || Auth::user()->department_id == 5)
    <div class="d-flex justify-content-between flex-wrap dashboard-heading  align-items-center pb-24 gap-3">
        <h3 class="mb-0"></h3>
        <div class="dropdown card-button">
            <button class="btn btn-secondary ot-dropdown-btn dropdown-toggle" type="button" id="revenueBtn" data-bs-toggle="dropdown" aria-expanded="false" style="background:#385834">
                <span id="__selected_dashboard">Laporan Bulanan Saya</span>
                <i class="las la-angle-down"></i>
            </button>
            <ul class="dropdown-menu c-dropdown-menu" aria-labelledby="revenueBtn">
                <li>
                    <a class="dropdown-item profile_option" href="{!!url('hrm/visit')!!}">Laporan Bulanan Saya</a>
                </li>
                <li>
                    <a class="dropdown-item profile_option" href="{!!url('laporan-bulanan-saya')!!}">
                        @if(Auth::user()->department_id == 7)
                            Lap Bulanan Kader Desa
                        @elseif(Auth::user()->department_id == 6)
                            Lap Bulanan Fasilitator Kecamatan
                        @elseif(Auth::user()->department_id == 5)
                            Lap Bulanan Faskab
                        @else
                            Tim Saya
                        @endif
                    </a>
                </li>
            </ul>
        </div>
    </div>
    @endif 

    <div class="table-content table-basic">
        <div class="card">

            <div class="card-body">
                <!-- toolbar table start -->
                <div
                    class="table-toolbar d-flex flex-wrap gap-2 flex-xl-row justify-content-xxl-between align-content-center pb-3">
                    <div class="align-self-center">
                        <div class="d-flex flex-wrap gap-2  flex-lg-row justify-content-center align-content-center">
                            <!-- show per page -->
                            <div class="align-self-center">
                                <label>
                                    <span class="mr-8">{{ _trans('common.Show') }}</span>
                                    <select class="form-select d-inline-block" id="entries" onchange="visitDatatable()">
                                        @include('backend.partials.tableLimit')
                                    </select>
                                    <span class="ml-8">{{ _trans('common.Entries') }}</span>
                                </label>
                            </div>



                            <div class="align-self-center d-flex flex-wrap gap-2">
                                <!-- add btn -->

                                <div class="align-self-center">
                                    <button type="button" class="btn-daterange" id="daterange" data-bs-toggle="tooltip"
                                        data-bs-placement="right" data-bs-title="{{ _trans('common.Date Range') }}">
                                        <span class="icon"><i class="fa-solid fa-calendar-days"></i>
                                        </span>
                                        <span class="d-none d-xl-inline">{{ _trans('common.Rentang Tanggal') }}</span>
                                    </button>
                                    <input type="hidden" id="daterange-input" onchange="visitDatatable()">
                                </div>


                                <!-- <div class="align-self-center">
                                    <div class="dropdown dropdown-designation" data-bs-toggle="tooltip"
                                        data-bs-placement="right" data-bs-title="{{ _trans('common.type') }}">
                                        <button type="button" class="btn-designation" data-bs-toggle="dropdown"
                                            aria-expanded="false" data-bs-auto-close="false">
                                            <span class="icon"><i class="fa-solid fa-tag"></i></span>
                                            <span class="d-none d-xl-inline">{{ _trans('common.Status') }}</span>
                                        </button>

                                        <div class="dropdown-menu  align-self-center ">
                                            <select name="status" class="form-control select2" id="status"
                                                onchange="visitDatatable()">
                                                <option value="">{{ _trans('common.Status') }}</option>
                                                @foreach (config()->get('app.visit_status') as $status_key => $status)
                                                    <option value="{{ $status_key }}">{{ $status }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div> -->

                                <!-- search -->
                                <div class="align-self-center">
                                    <div class="search-box d-flex">
                                        <input class="form-control" placeholder="{{ _trans('common.Search') }}"
                                            name="search" onkeyup="visitDatatable()" autocomplete="off" />
                                        <span class="icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                                    </div>
                                </div>


                            </div>


                        </div>
                    </div>
                    
                    
                    <div class="align-self-center d-flex flex-wrap gap-2">
                        <div class="align-self-center">
                            <a href="{!!url('hrm/visit/add-data')!!}" role="button" class="btn-add"
                                data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ _trans('common.Tambah Data Laporan Bulanan') }}">
                                <span><i class="fa-solid fa-plus"></i> </span>
                                <span class="d-none d-xl-inline">{{ _trans('common.Tambah Data') }}</span>
                            </a>
                        </div>
                    </div>

                </div>
                <!-- toolbar table end -->
                <!--  table start -->
                <div class="table-responsive">
                    @include('backend.partials.table')
                </div>
                <!--  table end -->
            </div>
        </div>
    </div>
@endsection
@section('script')
    @include('backend.partials.table_js')
@endsection
