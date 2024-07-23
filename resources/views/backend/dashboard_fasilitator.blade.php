@extends('backend.layouts.app') @section('title', 'Dashboard') @section('content')
<div class="d-flex justify-content-between flex-wrap dashboard-heading align-items-center pb-24 gap-3">
    <h3 class="mb-0">Hallo Selamat Datang [{{ Auth::user()->name }}]</h3>
    {{-- dropdown menu --}}
    @php $auth_role = !auth()->user()->role ? 'staff' : auth()->user()->role->slug; @endphp
</div>
<div class="content p-0 mt-4">
    
        <div class="row">
            <!-- Dashboard Summery Card Start -->
            <!-- Single Dashboard Summery Card Start -->
            <div class="col-12 col-sm-6 col-xs-6 col-md-4 col-lg-3 col-xl-3 pb-24 pl-12 pr-12">
                <div class="card summery-card ot-card h-100" title="Jumlah aktivitas harian pada bulan ini">
                    <div class="card-heading d-flex align-items-center">
                        <div class="card-icon circle-primary dashboard-card-icon">
                            <i class="las la-tasks"></i>
                        </div>
                        <div class="card-content">
                            <h4>Total<br>Aktivitas Harian</h4>
                            <h1>{{$daily}}</h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Single Dashboard Summery Card End -->
            <!-- Single Dashboard Summery Card Start -->
            <div class="col-12 col-sm-6 col-xs-6 col-md-4 col-lg-3 col-xl-3 pb-24 pl-12 pr-12">
                <div class="card summery-card ot-card h-100" title="Jumlah laporan bulanan pada tahun ini">
                    <div class="card-heading d-flex align-items-center">
                        <div class="card-icon circle-warning dashboard-card-icon">
                            <i class="las la-sticky-note"></i>
                        </div>
                        <div class="card-content">
                            <h4>Total<br>Laporan Bulanan</h4>
                            <h1>{{$monthly}}</h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Single Dashboard Summery Card End -->
            <!-- Single Dashboard Summery Card Start -->
            <div class="col-12 col-sm-6 col-xs-6 col-md-4 col-lg-3 col-xl-3 pb-24 pl-12 pr-12">
                <div class="card summery-card ot-card h-100" title="Jumlah absensi masuk - pulang pada bulan ini">
                    <div class="card-heading d-flex align-items-center">
                        <div class="card-icon circle-lightseagreen dashboard-card-icon">
                            <i class="las la-calendar-check"></i>
                        </div>
                        <div class="card-content">
                            <h4>Total<br>Absensi</h4>
                            <h1>{{$absensi}}</h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Single Dashboard Summery Card End -->
            <!-- Single Dashboard Summery Card Start -->
            <div class="col-12 col-sm-6 col-xs-6 col-md-4 col-lg-3 col-xl-3 pb-24 pl-12 pr-12">
                <div class="card summery-card ot-card h-100" title="Jumlah pengajuan tidak masuk kerja pada bulan ini yang disetujui">
                    <div class="card-heading d-flex align-items-center">
                        <div class="card-icon circle-danger dashboard-card-icon">
                            <i class="las la-calendar-times"></i>
                        </div>
                        <div class="card-content">
                            <h4>Total<br>Tidak Masuk</h4>
                            <h1>{{$leave}}</h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Single Dashboard Summery Card End -->

            

            <div class="col-md-12 pb-24 pl-12 pr-12">
                <div class="card ot-card">
                    <div class="card-header d-flex flex-row justify-content-between align-items-baseline pl-0 pt-0 mb_10">
                        <h3>Aktivitas Harian Terbaru</h3>
                    </div>
                    <br><br>
                    <div class="table-content table-basic">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="thead">
                                    <tr>
                                        <th class="text-left">No</th>
                                        <th>Nama</th>
                                        <th>Peran</th>
                                        <th>Rencana</th>
                                        <th>Realisasi</th>
                                        <th>Lokasi</th>
                                    </tr>
                                </thead>
                                <tbody class="tbody">
                                <?php $no=1;?>
                                @if(empty($daily_recent))

                                    <tr>
                                        <td colspan="6">Belum ada data</td>
                                    </tr>

                                @else

                                    @foreach($daily_recent as $row)
                                    <tr>
                                        <td>{{$no++}}</td>
                                        <td>{{$row->name}}</td>
                                        <td>{{$row->title}}</td>
                                        <td class='text-wrap'>{{$row->rencana}}</td>
                                        <td class='text-wrap'>{{$row->description}}</td>
                                        <td class='text-wrap'>{{$row->location}}</td>
                                        
                                    </tr>
                                    @endforeach

                                @endif
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

            @if(Auth::user()->department_id != 8)
            <div class="col-md-12 pb-24 pl-12 pr-12">
                <div class="card ot-card">
                    <div class="card-header d-flex flex-row justify-content-between align-items-baseline pl-0 pt-0 mb_10">
                        <h3>Laporan Bulanan Terbaru</h3>
                    </div>
                    <br><br>
                    <div class="table-content table-basic">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="thead">
                                    <tr>
                                        <th class="text-left">No</th>
                                        <th>Bulan</th>
                                        <th>Tahun</th>
                                        <th>File</th>
                                    </tr>
                                </thead>
                                <tbody class="tbody">
                                    <?php $no=1;?>
                                    @if(empty($monthly_recent))
                                        <tr>
                                            <td colspan="4">Belum ada data</td>
                                        </tr>
                                    @else
                                        @foreach($monthly_recent as $row)
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>{{$row->month}}</td>
                                            <td>{{$row->year}}</td>
                                            <td><a href="{!!url(''.$row->file.'')!!}" target="_blank"><i class="fa fa-file"></i></a></td>
                                            
                                        </tr>
                                        @endforeach
                                    @endif
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
</div>
<input type="hidden" id="user_slug" value="{{ $auth_role }}" />
<input type="hidden" id="profileWiseDashboard" value="{{ route('dashboard.profileWiseDashboard') }}" />
@endsection @section('script')
<script src="{{ global_asset('backend/js/fs_d_ecma/chart/echarts.min.js') }}"></script>
<script type="module" src="{{ global_asset('backend/js/fs_d_ecma/components/dashboard.js') }}"></script>
@endsection