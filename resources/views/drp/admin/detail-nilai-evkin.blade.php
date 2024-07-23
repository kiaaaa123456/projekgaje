@extends('backend.layouts.app')
@section('title', 'Evkin Fasilitator')
@section('content')

	<div class="breadcrumb-warning d-flex justify-content-between ot-card">
    <div><h3>Evkin Fasilitator</h3></div>
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb ot-breadcrumb ot-breadcrumb-basic">
            <li class="breadcrumb-item"><a href="{!!url('dashboard')!!}">Dashboard</a></li>
            <li class="breadcrumb-item active">Periode Evkin</li>
            <li class="breadcrumb-item active">Evkin Fasilitator</li>
            
        </ol>
    </nav>
</div>

<div class="table-content table-basic">
    <div class="card">
        <div class="card-body">
            <!-- toolbar table end -->
            <!--  table start -->
            <h6>Nama : <span id="text_name"></span></h6>
            <h6>Peran : <span id="text_unit"></span></h6>
            <h6>Provinsi : <span id="text_prov"></span></h6>
            <h6>Kabupaten : <span id="text_kab"></span></h6>
            @if($peran==8)
                <h6>Kecamatan/Distrik : <span id="text_kec"></span></h6>
                <h6>Desa/Kampung : <span id="text_desa"></span></h6>
            @elseif($peran==7)
                <h6>Kecamatan/Distrik : <span id="text_kec"></span></h6>
            @endif
            <br />
            <hr />
            <br />
            <div class="table-responsive">
                <form id="form_data">
                @csrf
                <input type="hidden" name="id_periode" value="{{Request::segment(2)}}">
                <input type="hidden" name="id_user" value="{{Request::segment(3)}}">
                <table class="table table-bordered visit_table" id="table">
                    <tr>
                        <td class="sorting_desc">No</td>
                        <td class="sorting_desc">Aspek</td>
                        <td class="sorting_desc">Variabel</td>
                        <td class="sorting_desc">Nilai Skor</td>
                    </tr>
                    <tr>
                        <td class="sorting_desc">I</td>
                        <td class="sorting_desc" colspan="3">ASPEK KINERJA</td>
                    </tr>
                    <tr>
                        <td class="sorting_desc">1.1</td>
                        <td class="sorting_desc" colspan="3">ADMINISTRASI</td>
                    </tr>
                    <tr>
                        <td class="sorting_desc">1.1.1</td>
                        <td class="sorting_desc"></td>
                        <td class="sorting_desc">Tingkat kehadiran <i class="fa fa-file" id="show-absensi" style="cursor:pointer"></i></td>
                        <td class="sorting_desc">{{$evkin['0']->kehadiran}}</td>
                    </tr>
                    <tr>
                        <td class="sorting_desc">1.1.2</td>
                        <td class="sorting_desc"></td>
                        <td class="sorting_desc">Menyusun laporan harian <i class="fa fa-file" id="show-aktivitas" style="cursor:pointer"></i></td>
                        <td class="sorting_desc">{{$evkin['0']->akt_harian}}</td>
                    </tr>
                    <tr>
                        <td class="sorting_desc">1.1.3</td>
                        <td class="sorting_desc"></td>
                        <td class="sorting_desc">Menyusun laporan bulanan <i class="fa fa-file" id="show-bulanan" style="cursor:pointer"></i></td>
                        <td class="sorting_desc">{{$evkin['0']->lap_bulanan}}</td>
                    </tr>
                    <tr>
                        <td class="sorting_desc">1.2</td>
                        <td class="sorting_desc" colspan="3">PENDAMPINGAN, SUPERVISI, MONITORING DAN EVALUASI</td>
                    </tr>
                    <tr>
                        <td class="sorting_desc">1.2.1</td>
                        <td class="sorting_desc"></td>
                        <td class="sorting_desc">Pendampingan Terhadap Program TEKAD</td>
                        <td class="sorting_desc">{{$evkin['0']->pendampingan_tekad}}</td>
                    </tr>
                    <tr>
                        <td class="sorting_desc">1.2.2</td>
                        <td class="sorting_desc"></td>
                        <td class="sorting_desc">Supervisi dan Monev terhadap Kelompok dan Sasaran Program</td>
                        <td class="sorting_desc">{{$evkin['0']->supervisi}}</td>
                    </tr>
                    <tr>
                        <td class="sorting_desc">1.3</td>
                        <td class="sorting_desc" colspan="3">PENCAPAIAN OUTPUT</td>
                    </tr>
                    <tr>
                        <td class="sorting_desc">1.3.1</td>
                        <td class="sorting_desc"></td>
                        <td class="sorting_desc">Rencana Kerja</td>
                        <td class="sorting_desc">{{$evkin['0']->rencana_kerja}}</td>
                    </tr>
                    <tr>
                        <td class="sorting_desc">1.3.2</td>
                        <td class="sorting_desc"></td>
                        <td class="sorting_desc">Output Sesuai Tupoksi</td>
                        <td class="sorting_desc">{{$evkin['0']->output_tupoksi}}</td>
                    </tr>
                    <tr>
                        <td class="sorting_desc">II</td>
                        <td class="sorting_desc" colspan="3">PERILAKU KERJA</td>
                    </tr>
                    <tr>
                        <td class="sorting_desc">2.1</td>
                        <td class="sorting_desc" colspan="3">Pengendalian Pendamping</td>
                    </tr>
                    <tr>
                        <td class="sorting_desc">2.1.1</td>
                        <td class="sorting_desc"></td>
                        <td class="sorting_desc">Pendampingan untuk perberdayaan masyarakat</td>
                        <td class="sorting_desc">{{$evkin['0']->pendampingan_masyarakat}}</td>
                    </tr>
                    <tr>
                        <td class="sorting_desc">2.1.2</td>
                        <td class="sorting_desc"></td>
                        <td class="sorting_desc">Penanganan dan penyelesaian permasalahan tim kerja (berjenjang)</td>
                        <td class="sorting_desc">{{$evkin['0']->penanganan}}</td>
                    </tr>
                    <tr>
                        <td class="sorting_desc">2.2</td>
                        <td class="sorting_desc" colspan="2">Loyalitas dan Ketaatan</td>
                        <td class="sorting_desc">{{$evkin['0']->loyalitas}}</td>
                    </tr>
                    <tr>
                        <td class="sorting_desc">2.3</td>
                        <td class="sorting_desc" colspan="2">Koordinasi dan Kerjasama</td>
                        <td class="sorting_desc">{{$evkin['0']->koordinasi}}</td>
                    </tr>
                    <tr>
                        <td class="sorting_desc" colspan="3"><strong><center>Nilai Evkin</center></strong></td>
                        <td class="sorting_desc"><strong>{{$evkin['0']->nilai}}</strong></td>
                    </tr>
                </table>
                <input type="text" hidden id="visit_table_url" value="https://www.sistemweb.my.id/hrm/visit" />
                <br />
                <br />
                <center>
                    @if(Auth::user()->is_admin == 1)
                    <a href="{!!url('evkin-fasilitator/'.Request::segment(2).'')!!}" class="btn btn-warning">Kembali ke penilaian fasilitator</a>
                    @else
                        @if(Auth::user()->department_id==33 || Auth::user()->department_id==27)
                        <a href="{!!url('evkin-korkab')!!}" class="btn btn-warning">Kembali</a>
                        @else
                        <a href="{!!url('evkin-saya')!!}" class="btn btn-warning">Kembali</a>
                        @endif
                    @endif
                </center>
                <br />
                <br />
            </div>
            </form>
            <!--  table end -->
        </div>
    </div>
</div>

<div class="modal fade lead-modal" id="modalAbsensi" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content data">
            <div class="modal-header mb-3" style="background:#dbfbd7 !important">
                <h5 class="modal-title">Absensi Fasilitator</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times text-white" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered visit_table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Masuk</th>
                            <th>Pulang</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(empty($attendance))
                            <tr>
                                <td colspan="4">Belum ada data.</td>
                            </tr>
                        @else
                            <?php $no = 1;?>
                            @foreach($attendance as $row)
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>{{date('d-m-Y', strtotime($row->date))}}</td>
                                    <td>
                                        {{date('d-m-Y', strtotime($row->check_in))}}<br>
                                        <small>{{$row->check_in_location}}</small>
                                    </td>
                                    <td>
                                        @if(empty($row->check_out))
                                        Belum pulang
                                        @else
                                        {{date('d-m-Y', strtotime($row->check_out))}}<br>
                                        <small>{{$row->check_out_location}}</small>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="modal fade lead-modal" id="modalAktivitas" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content data">
            <div class="modal-header mb-3" style="background:#dbfbd7 !important">
                <h5 class="modal-title">Aktivitas Harian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times text-white" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered visit_table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Rencana</th>
                            <th>Realisasi</th>
                            <th>Lokasi</th>
                            <th>File</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(empty($aktivitas))
                            <tr>
                                <td colspan="6">Belum ada data.</td>
                            </tr>
                        @else
                            <?php $no = 1;?>
                            @foreach($aktivitas as $row)
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>
                                        {{date('d-m-Y', strtotime($row->date))}} <br>
                                    </td>
                                    <td>{{$row->appoinment_start_at}} - {{$row->appoinment_end_at}}</td>
                                    <td>{{$row->title}}<br></td>
                                    <td>{{$row->description}}<br></td>
                                    <td>{{$row->location}}<br></td>
                                    <td>
                                        <a href="{!!url(''.$row->file.'')!!}" target="_blank"><i class="fa fa-file"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="modal fade lead-modal" id="modalBulanan" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content data">
            <div class="modal-header mb-3" style="background:#dbfbd7 !important">
                <h5 class="modal-title">Laporan Bulanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times text-white" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered visit_table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Bulan</th>
                            <th>Tahun</th>
                            <th>File</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(empty($bulanan))
                            <tr>
                                <td colspan="4">Belum ada data.</td>
                            </tr>
                        @else
                            <?php $no = 1;?>
                            @foreach($bulanan as $row)
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>{{$row->month}}<br></td>
                                    <td>{{$row->year}}<br></td>
                                    <td>
                                        <a href="{!!url(''.$row->file.'')!!}" target="_blank"><i class="fa fa-file"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>






@endsection
@section('script')
<script type="text/javascript">

    var id_periode = "{{Request::segment(2)}}";
    var id_user = "{{Request::segment(3)}}";

    $(document).ready(function(){
        $('#show-absensi').click(function(){
        $('#modalAbsensi').modal('show');
        });
    });

    $(document).ready(function(){
        $('#show-aktivitas').click(function(){
        $('#modalAktivitas').modal('show');
        });
    });

    $(document).ready(function(){
        $('#show-bulanan').click(function(){
        $('#modalBulanan').modal('show');
        });
    });

	$.ajax({
            url:"../../profil-fasilitator/"+id_periode+"/"+id_user+"",
            dataType:"json",
            success:function(data){
                $('#text_name').html(data.name);
                $('#text_unit').html(data.unit);
                $('#text_prov').html(data.prov);
                $('#text_kab').html(data.kab);
                $('#text_kec').html(data.kec);
                $('#text_desa').html(data.desa);
            }
    })

    toastr.options = {
    "closeButton": true,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
    }    

    $('#form_data').on('submit', function(event){
        event.preventDefault();        
        $.ajax({
            url:"../../../update-nilai-evkin",
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType:"json",
            beforeSend: function(){
                $('.anim').show();
                $("#action_button").prop("disabled", true);
            },
            success:function(data)
            {
                if(data.status==='success') {
                    toastr.success("Penilaian evaluasi kinerja berhasil disimpan");
                    location.reload();
                
                } else {
                    $('.anim').hide();
                    $("#action_button").prop("disabled", false);
                    swal("Gagal!", "Silakan coba lagi", "error")
                }
            },
        });
        
    });
	

</script>
@endsection
