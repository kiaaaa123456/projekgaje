@extends('backend.layouts.app')
@section('title', 'Evkin Fasilitator')
@section('content')

	<div class="breadcrumb-warning d-flex justify-content-between ot-card">
    <div><h3>Edit Nilai Evkin Fasilitator</h3></div>
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb ot-breadcrumb ot-breadcrumb-basic">
            <li class="breadcrumb-item"><a href="{!!url('dashboard')!!}">Dashboard</a></li>
            <li class="breadcrumb-item ">Periode Evkin</li>
            <li class="breadcrumb-item ">Evkin Fasilitator</li>
            <li class="breadcrumb-item active">Edit Nilai Evkin</li>
            
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
                        <td class="sorting_desc">
                            <?php 
                                $kal = CAL_GREGORIAN;
                                $bulan = date('m');
                                $tahun = date('Y');
                                $hari = cal_days_in_month($kal, $bulan, $tahun);
                                $hadir = count($attendance);
                                $tidak_hadir = $hari - $hadir ;
                                if($tidak_hadir == $hadir) {
                                    $kehadiran = 5;
                                } else if(($tidak_hadir-$hadir)==1) {
                                    $kehadiran = 4;
                                } else if(($tidak_hadir-$hadir)==2) {
                                    $kehadiran = 3;
                                } else if(($tidak_hadir-$hadir)==3) {
                                    $kehadiran = 2;
                                } else if(($tidak_hadir-$hadir) > 3) {
                                    $kehadiran = 1;
                                } else {
                                    $kehadiran = 1;
                                }
                            ?>
                            <input type="text" class="form-control" name="kehadiran" value="{{$kehadiran}}" readonly>
                        </td>
                    </tr>
                    <tr>
                        <td class="sorting_desc">1.1.2</td>
                        <td class="sorting_desc"></td>
                        <td class="sorting_desc">Menyusun laporan harian <i class="fa fa-file" id="show-aktivitas" style="cursor:pointer"></i></td>
                        <td class="sorting_desc">
                            <select class="form-control" name="akt_harian" required>
                                <option value="">-Pilih Nilai-</option>
                                <option value="5" @if($evkin['0']->akt_harian==5) selected @endif>5 - Sesuai dengan Tupoksi (100%)</option>
                                <option value="4" @if($evkin['0']->akt_harian==4) selected @endif>4 - Tidak sesuai dengan Tupoksi (2 kegiatan)</option>
                                <option value="3" @if($evkin['0']->akt_harian==3) selected @endif>3 - Tidak sesuai dengan Tupoksi (4 kegiatan)</option>
                                <option value="2" @if($evkin['0']->akt_harian==2) selected @endif>2 - Tidak sesuai dengan Tupoksi (6 kegiatan)</option>
                                <option value="1" @if($evkin['0']->akt_harian==1) selected @endif>1 - Tidak sesuai dengan Tupoksi (8 kegiatan)</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="sorting_desc">1.1.3</td>
                        <td class="sorting_desc"></td>
                        <td class="sorting_desc">Menyusun laporan bulanan <i class="fa fa-file" id="show-bulanan" style="cursor:pointer"></i></td>
                        <td class="sorting_desc">
                            <select class="form-control" name="lap_bulanan" required>
                                <option value="">-Pilih Nilai-</option>
                                <option value="10" @if($evkin['0']->lap_bulanan==10) selected @endif>10 - Laporan Sesuai dan Lengkap</option>
                                <option value="8" @if($evkin['0']->lap_bulanan==8) selected @endif>8 - Isi Laporan Kurang Sesuai dan Lengkap</option>
                                <option value="6" @if($evkin['0']->lap_bulanan==6) selected @endif>6 - Isi Laporan Kurang Sesuai dan Kurang Lengkap</option>
                                <option value="4" @if($evkin['0']->lap_bulanan==4) selected @endif>4 - Isi Laporan Kurang Sesuai dan Tidak Lengkap</option>
                                <option value="2" @if($evkin['0']->lap_bulanan==2) selected @endif>2 - Isi Laporan Tidak Sesuai dan Tidak Lengkap</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="sorting_desc">1.2</td>
                        <td class="sorting_desc" colspan="3">PENDAMPINGAN, SUPERVISI, MONITORING DAN EVALUASI</td>
                    </tr>
                    <tr>
                        <td class="sorting_desc">1.2.1</td>
                        <td class="sorting_desc"></td>
                        <td class="sorting_desc">Pendampingan Terhadap Program TEKAD</td>
                        <td class="sorting_desc">
                            <select class="form-control" name="pendampingan_tekad" required>
                                <option value="">-Pilih Nilai-</option>
                                <option value="10" @if($evkin['0']->pendampingan_tekad==10) selected @endif>10 - Pendampingan dilakukan sesuai dengan Kebutuhan kegiatan Komponen/ Sub Komponen</option>
                                <option value="6" @if($evkin['0']->pendampingan_tekad==6) selected @endif>6 - Pendampingan dilakukan cukup sesuai dengan Kebutuhan kegiatan Komponen/ Sub Komponen</option>
                                <option value="2" @if($evkin['0']->pendampingan_tekad==2) selected @endif>2 - Pendampingan Tidak sesuai dengan Kebutuhan kegiatan Komponen/ Sub Komponen</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="sorting_desc">1.2.2</td>
                        <td class="sorting_desc"></td>
                        <td class="sorting_desc">Supervisi dan Monev terhadap Kelompok dan Sasaran Program</td>
                        <td class="sorting_desc">
                            <select class="form-control" name="supervisi" required>
                                <option value="">-Pilih Nilai-</option>
                                <option value="10" @if($evkin['0']->supervisi==10) selected @endif>10 - Dilakukan Supervisi dan Monev sesuai dengan Target Group kelompok dan sasaran Program</option>
                                <option value="6" @if($evkin['0']->supervisi==6) selected @endif>6 - Dilakukan Supervisi dan Monev namun kurang sesuai Target Group kelompok dan kurang sesuai dengan sasaran Program</option>
                                <option value="2" @if($evkin['0']->supervisi==2) selected @endif>2 - Tidak melakukan Supervisi dan Monev terhadap Target Group kelompok dan sasaran Program</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="sorting_desc">1.3</td>
                        <td class="sorting_desc" colspan="3">PENCAPAIAN OUTPUT</td>
                    </tr>
                    <tr>
                        <td class="sorting_desc">1.3.1</td>
                        <td class="sorting_desc"></td>
                        <td class="sorting_desc">Rencana Kerja</td>
                        <td class="sorting_desc">
                            <select class="form-control" name="rencana_kerja" required>
                                <option value="">-Pilih Nilai-</option>
                                <option value="15" @if($evkin['0']->rencana_kerja==15) selected @endif>15 - Memiliki Rencana Kerja sesuai dengan Tupoksi </option>
                                <option value="9" @if($evkin['0']->rencana_kerja==9) selected @endif>9 - Memiliki Rencana Kerja cukup sesuai dengan Tupoksi  </option>
                                <option value="3" @if($evkin['0']->rencana_kerja==3) selected @endif>3 - Tidak memiliki Rencana Kerja sesuai dengan Tupoksi  </option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="sorting_desc">1.3.2</td>
                        <td class="sorting_desc"></td>
                        <td class="sorting_desc">Output Sesuai Tupoksi</td>
                        <td class="sorting_desc">
                            <select class="form-control" name="output_tupoksi" required>
                                <option value="">-Pilih Nilai-</option>
                                <option value="15" @if($evkin['0']->output_tupoksi==15) selected @endif>15 - Memiliki Uraian Output kegiatan sesuai dengan Tupoksi  </option>
                                <option value="9" @if($evkin['0']->output_tupoksi==9) selected @endif>9 - Memiliki Uraian Output kegiatan Cukup sesuai dengan Tupoksi  </option>
                                <option value="3" @if($evkin['0']->output_tupoksi==3) selected @endif>3 - Tidak ada uraian Output kegiatan sesuai dengan Tupoksi </option>
                            </select>
                        </td>
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
                        <td class="sorting_desc">
                            <select class="form-control" name="pendampingan_masyarakat" required>
                                <option value="">-Pilih Nilai-</option>
                                <option value="5" @if($evkin['0']->pendampingan_masyarakat==5) selected @endif>5 - Melakukan kegiatan pendampingan sesuai dengan tupoksi , kebutuhan dan jenjang</option>
                                <option value="3" @if($evkin['0']->pendampingan_masyarakat==3) selected @endif>3 - Melakukan kegiatan pendampingan kurang sesuai mulai dari tupoksi, kebtuhan dan jenjang </option>
                                <option value="1" @if($evkin['0']->pendampingan_masyarakat==1) selected @endif>1 - Tidak melakukan kegiatan pendampingan</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="sorting_desc">2.1.2</td>
                        <td class="sorting_desc"></td>
                        <td class="sorting_desc">Penanganan dan penyelesaian permasalahan tim kerja (berjenjang)</td>
                        <td class="sorting_desc">
                            <select class="form-control" name="penanganan" required>
                                <option value="">-Pilih Nilai-</option>
                                <option value="5" @if($evkin['0']->penanganan==5) selected @endif>5 - Melaksanakan penanganan dan penyelesaian permasalahan tim kerja secara berjenjang</option>
                                <option value="3" @if($evkin['0']->penanganan==3) selected @endif>3 - Melaksanan penanganan tetapi tidak menyelesaikan permasalahan tim kerja secara berjenjang</option>
                                <option value="1" @if($evkin['0']->penanganan==1) selected @endif>1 - Tidak melaksanakan penanganan dan penyelesaian permasalahan tim kerja secara berjenjang tim kerja secara berjenjang</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="sorting_desc">2.2</td>
                        <td class="sorting_desc" colspan="2">Loyalitas dan Ketaatan</td>
                        <td class="sorting_desc">
                            <select class="form-control" name="loyalitas" required>
                                <option value="">-Pilih Nilai-</option>
                                <option value="10" @if($evkin['0']->loyalitas==10) selected @endif>10 - Loyal dan taat terhadap peraturan, hirarki dan tupoksi</option>
                                <option value="6" @if($evkin['0']->loyalitas==6) selected @endif>6 - Cukup Loyal dan taat terhadap peraturan, hirarki dan tupoksi</option>
                                <option value="2" @if($evkin['0']->loyalitas==2) selected @endif>2 - Tidak Loyal dan taat terhadap peraturan, hirarki dan tupoksi</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="sorting_desc">2.3</td>
                        <td class="sorting_desc" colspan="2">Koordinasi dan Kerjasama</td>
                        <td class="sorting_desc">
                            <select class="form-control" name="koordinasi" required>
                                <option value="">-Pilih Nilai-</option>
                                <option value="10" @if($evkin['0']->koordinasi==10) selected @endif>10 - Melaksanan koordinasi dan kerjasama sesuai hirarki dan lini kerja</option>
                                <option value="6" @if($evkin['0']->koordinasi==6) selected @endif>6 - Melaksanan koordinasi tetapi kurang kerjasama sesuai hirarki dan lini kerja</option>
                                <option value="2" @if($evkin['0']->koordinasi==2) selected @endif>2 - Tidak melaksanan koordinasi dan kerjasama sesuai hirarki dan lini kerja</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <br />
                <center><span class="loader"><i class="fa fa-spinner fa-3x fa-spin"></i></span></center>
                <br />
                <center>
                    <button class="btn btn-success" type="submit" id="action_button">Simpan</button>
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

    $('.loader').css("visibility", "hidden");

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
            url:"../../update-nilai-evkin",
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType:"json",
            beforeSend: function(){
                $('.loader').css("visibility", "visible");
                $("#action_button").prop("disabled", true);
            },
            success:function(data)
            {
                if(data.status==='success') {
                    toastr.success("Sukses <br> Penilaian evkin berhasil disimpan");
                    window.location.href = '../../nilai-fasilitator/'+id_periode+"/"+id_user;
                
                } else {
                    toastr.danger("Gagal <br> Ada kesalahan dalam penilaian evkin");
                    $('.loader').css("visibility", "hidden");
                    $("#action_button").prop("disabled", false);
                }
            },
        });
        
    });
	

</script>
@endsection
