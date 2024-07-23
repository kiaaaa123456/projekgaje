@extends('backend.layouts.app')
@section('title', @$data['title'])
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
                <span id="__selected_dashboard">Aktivitas Harian Saya</span>
                <i class="las la-angle-down"></i>
            </button>
            <ul class="dropdown-menu c-dropdown-menu" aria-labelledby="revenueBtn">
                <li>
                    <a class="dropdown-item profile_option" href="{!!url('hrm/appointment')!!}">Akt Harian Saya</a>
                </li>
                <li>
                    <a class="dropdown-item profile_option" href="{!!url('aktivitas-harian-saya')!!}">
                        @if(Auth::user()->department_id == 7)
                            Akt Harian Kader Desa
                        @elseif(Auth::user()->department_id == 6)
                            Akt Harian Fasilitator Kecamatan
                        @elseif(Auth::user()->department_id == 5)
                            Akt Harian Faskab
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
                        <div class="d-flex flex-wrap gap-2  flex-lg-row  align-content-center">
                            <!-- show per page -->
                            <div class="align-self-center">
                                <label>
                                    <span class="mr-8">{{ _trans('common.Menampilkan') }}</span>
                                    <select class="form-select d-inline-block" id="entries"
                                        onchange="appointmentDatatable()">
                                        @include('backend.partials.tableLimit')
                                    </select>
                                    <span class="ml-8">{{ _trans('common.Data') }}</span>
                                </label>
                            </div>

                            <!-- search -->
                            <div class="align-self-center">
                                <div class="search-box d-flex">
                                    <input class="form-control" placeholder="{{ _trans('common.Cari') }}" name="search"
                                        onkeyup="appointmentDatatable()" autocomplete="off">
                                    <span class="icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                                </div>
                            </div>
                            @if(Auth::user()->is_admin == 0)
                            <div class="align-self-center d-flex flex-wrap gap-2">
                                <div class="align-self-center">
                                    <a href="{!!url('eksport-aktivitas-harian')!!}" role="button" class="btn-add" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Eksport Aktivitas Harian">
                                        <span class="d-none d-xl-inline">Eksport Data</span>
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <!-- export -->
                    

                    <div class="align-self-center d-flex flex-wrap gap-2">
                        <!-- add btn -->                        
                        <div class="align-self-center">
                            <a href="{!!url('hrm/appointment/create')!!}" role="button" class="btn-add"
                                data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ _trans('common.Tambah Data Aktivitas Harian') }}">
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
