@extends('backend.layouts.app')
@section('title', 'Laporan Rekap Bulanan')
@section('content')

	<div class="breadcrumb-warning d-flex justify-content-between ot-card">
    <div><h3>Laporan Rekap Bulanan</h3></div>
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb ot-breadcrumb ot-breadcrumb-basic">
            <li class="breadcrumb-item"><a href="{!!url('dashboard')!!}">Dashboard</a></li>
            <li class="breadcrumb-item active">Laporan Rekap Bulanan</li>
            
        </ol>
    </nav>
</div>
    

<div class="table-content table-basic">
    <div class="card">
        <div class="card-body">
            <!-- toolbar table start -->
            <form action="laporan-rekap-bulanan" method="GET">
            <div class="table-toolbar d-flex flex-wrap gap-2 flex-xl-row justify-content-xxl-between align-content-center pb-3">
                <div class="align-self-center">
                    <div class="d-flex flex-wrap gap-2 flex-lg-row justify-content-center align-content-center">
                        <!-- show per page -->
                        <div class="align-self-center">
                            <label>
                                <select class="form-select d-inline-block act" name="kodeprov" id="kodeprov" required>
                                    <option value="">-Semua Provinsi-</option>
                                    @foreach($provinsi as $prov)
                                    <option value="{{$prov->kdprov}}"
                                        @if(!empty($_GET['kodeprov']))
                                            @if($_GET['kodeprov']==$prov->kdprov) 
                                                selected
                                            @endif
                                        @endif
                                    >
                                        {{$prov->nmprov}}
                                    </option>
                                    @endforeach
                                </select>
                            </label>
                        </div>

                        <div class="align-self-center">
                            <label>
                                <select class="form-select d-inline-block act" name="kodekab" id="kodekab" required>
                                    <option value="">-Semua Kabupaten-</option>
                                </select>
                            </label>
                        </div>

                        <div class="align-self-center">
                            <label>
                                <select class="form-select d-inline-block act" name="bulan" id="bulan">
                                    <?php

                                        if (empty($_GET['bulan'])) {
                                            $date = date('m');
                                        } else {
                                            $date = $_GET['bulan'];
                                        }

                                    ?>
                                    <option value="01" @if($date=='01') selected @endif>Januari</option>
                                    <option value="02" @if($date=='02') selected @endif>Februari</option>
                                    <option value="03" @if($date=='03') selected @endif>Maret</option>
                                    <option value="04" @if($date=='04') selected @endif>April</option>
                                    <option value="05" @if($date=='05') selected @endif>Mei</option>
                                    <option value="06" @if($date=='06') selected @endif>Juni</option>
                                    <option value="07" @if($date=='07') selected @endif>Juli</option>
                                    <option value="08" @if($date=='08') selected @endif>Agustus</option>
                                    <option value="09" @if($date=='09') selected @endif>September</option>
                                    <option value="10" @if($date=='10') selected @endif>Oktober</option>
                                    <option value="11" @if($date=='11') selected @endif>November</option>
                                    <option value="12" @if($date=='12') selected @endif>Desember</option>
                                </select>
                            </label>
                        </div>

                        <div class="align-self-center d-flex flex-wrap gap-2">
                            
                        </div>

                        <div class="align-self-center d-flex flex-wrap gap-2">
                            <button class="btn-add" style="background: #365532;">Cari</button>
                        </div>

                        <div class="align-self-center d-flex flex-wrap gap-2">
                            <a href="{!!url('laporan-rekap-bulanan')!!}" class="btn-add" style="background: red;">Reset</a>
                        </div>

                        <div class="align-self-center d-flex flex-wrap gap-2">
                            <button class="btn-add btn-export" style="background: #11826c;">Ekspor Laporan</button>
                        </div>

                    </div>
                </div>
            </div>

            </form>

            
            <br><br>
            <!-- toolbar table end -->
            <!--  table start -->
            <table class="table table-bordered" id="table-body">
                <thead class="thead">
                    <tr>
                        <th colspan="12">Provinsi</th>
                        <th colspan="12">:</th>
                        <th colspan="12">{{$nmprov}}</th>
                        <th colspan="12">Bulan / Tahun</th>
                        <th colspan="12">:</th>
                        <th colspan="12">{{$nama_bulan}} / {{date('Y')}}</th>
                    </tr>
                    <tr>
                        <th colspan="12">Kabupaten</th>
                        <th colspan="12">:</th>
                        <th colspan="12">{{$nmkab}}</th>
                        <th colspan="12">Jumlah Fasilitator</th>
                        <th colspan="12">:</th>
                        <th colspan="12">{{$jml}} Orang</th>
                    </tr>
                </thead>
            </table>
            <br><br>
            <div class="table-responsive" style="border:1px">
                <table class="table table-bordered" id="table-body">
                    <thead class="thead">
                        <tr>
                            <th colspan="12" style="background:#dbfbd7">KADER</th>
                        </tr>
                    </thead>
                    <thead class="thead">
                        <tr>
                        	<th class="sorting_desc" style="font-size:9pt">No</th>
                            <th class="sorting_desc" style="font-size:9pt">Nama</th>
                            <th class="sorting_desc"  style="max-width:85px;font-size:9pt">Total<br> Hari Kerja</th>
                            <th class="sorting_desc" style="max-width:90px;font-size:9pt">Total<br> Jam Kerja</th>
                            <th class="sorting_desc" style="max-width:90px;font-size:9pt">Total<br> Akt Harian</th>
                            <th class="sorting_desc" style="max-width:90px;font-size:9pt">Total<br> Tdk Masuk</th>
                            <th class="sorting_desc" style="max-width:90px;font-size:9pt">Upload<br> Akt Harian</th>
                            <th class="sorting_desc" style="max-width:90px;font-size:9pt">Upload<br> Lapbul</th>
                            <th class="sorting_desc" style="max-width:90px;font-size:9pt">Nilai<br> Evkin</th>
                            <th class="sorting_desc" style="font-size:9pt">Kabupaten</th>
                            <th class="sorting_desc" style="font-size:9pt">Kecamatan</th>
                            <th class="sorting_desc" style="font-size:9pt">Desa</th>
                        </tr>
                    </thead>

                    <!-- <center><span class="loader"><i class="fa fa-spinner fa-3x fa-spin"></i></span></center> -->
                    <tbody class="tbody">
                        <?php $no = 1;?>
                        @foreach($kader as $kad)
                        <?php 
                            $seconds = $kad->jam_kerja;
                            $hours = floor($seconds / 3600);
                            $seconds -= $hours * 3600;
                            $minutes = floor($seconds / 60);
                            $seconds -= $minutes * 60;
                        ?>
                            <tr>
                                <td>{{$no++}}</td>
                                <td>{{$kad->name}}</td>
                                <td><center>{{$kad->hari_kerja}}</center></td>
                                <td>
                                    <?php
                                        if ($kad->jam_kerja < 576000) {
                                            echo "<span style='color:red'>".$hours." j ".$minutes." m ".$seconds." d</span>";
                                        } else {
                                            echo "$hours j $minutes m $seconds d";       
                                        }
                                     
                                    ?>
                                </td>
                                <td><center>{{$kad->akt_harian}}</center></td>
                                <td><center>{{$kad->tdk_masuk}}</center></td>
                                <td>
                                    @if($kad->lap_bul==0)
                                    <center>Y</center>
                                    @else
                                    <center><span style="color:red"><u>T</u></span></center>
                                    @endif
                                </td>
                                <td>
                                    
                                </td>
                                <td>@if($kad->nilai_evkin < 60) <center><span style="color:red">{{$kad->nilai_evkin}}</span></cente90 @else <center>{{$kad->nilai_evkin}}</cente90 @endif</td>
                                <td>{{$kad->nmkab}}</td>
                                <td>{{$kad->nmkec}}</td>
                                <td>{{$kad->nmdesa}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <!-- <tbody class="tbody">
	                    <tr id="temp">
	                        <td colspan='7'>Loading Data..</td>
	                    </tr>
	                </tbody> -->

                </table>

                <br><br>


                <table class="table table-bordered" id="table-body">
                    <thead class="thead">
                        <tr>
                            <th colspan="12" style="background: #dbfbd7">FK - FASDIS</th>
                        </tr>
                    </thead>
                    <thead class="thead">
                        <tr>
                            <th class="sorting_desc">No</th>
                            <th class="sorting_desc">Nama</th>
                            <th class="sorting_desc">Total<br> Hari Kerja</th>
                            <th class="sorting_desc">Total<br> Jam Kerja</th>
                            <th class="sorting_desc">Total<br> Akt Harian</th>
                            <th class="sorting_desc">Total<br> Tidak Masuk</th>
                            <th class="sorting_desc">Upload<br> Akt Harian</th>
                            <th class="sorting_desc">Upload<br> Lap Bulanan</th>
                            <th class="sorting_desc">Nilai<br> Evkin</th>
                            <th class="sorting_desc">Kabupaten</th>
                            <th class="sorting_desc">Kecamatan</th>
                            <!-- <th class="sorting_desc">Desa</th> -->
                        </tr>
                    </thead>

                    <!-- <center><span class="loader"><i class="fa fa-spinner fa-3x fa-spin"></i></span></center> -->
                    <tbody class="tbody">
                        <?php $no = 1;?>
                        @foreach($fasdis as $fas)
                        <?php 
                            $seconds = $fas->jam_kerja;
                            $hours = floor($seconds / 3600);
                            $seconds -= $hours * 3600;
                            $minutes = floor($seconds / 60);
                            $seconds -= $minutes * 60;
                        ?>
                            <tr>
                                <td>{{$no++}}</td>
                                <td>{{$fas->name}}</td>
                                <td>{{$fas->hari_kerja}}</td>
                                <td>
                                    <?php
                                        if ($fas->jam_kerja < 576000) {
                                            echo "<span style='color:red'>".$hours." jam ".$minutes." menit ".$seconds." detik</span>";
                                        } else {
                                            echo "$hours jam $minutes menit $seconds detik";       
                                        }
                                     
                                    ?>
                                </td>
                                <td>{{$fas->akt_harian}}</td>
                                <td>{{$fas->tdk_masuk}}</td>
                                <td>
                                    @if($fas->lap_bul==0)
                                        <span style="color:red"><u>T</u></span>
                                    @else
                                        Y
                                    @endif
                                </td>
                                <td>
                                    @if($fas->ttd_basah==0)
                                        <span style="color:red"><u>T</u></span>
                                    @else
                                        Y
                                    @endif
                                </td>
                                <td>{{$fas->nilai_evkin}}</td>
                                <td>{{$fas->nmkab}}</td>
                                <td>{{$fas->nmkec}}</td>
                                <!-- <td></td> -->
                            </tr>
                        @endforeach
                    </tbody>
                    <!-- <tbody class="tbody">
                        <tr id="temp">
                            <td colspan='7'>Loading Data..</td>
                        </tr>
                    </tbody> -->

                </table>

                <br><br>


                <table class="table table-bordered" id="table-body">
                    <thead class="thead">
                        <tr>
                            <th colspan="12" style="background: #dbfbd7">FASKAB</th>
                        </tr>
                    </thead>
                    <thead class="thead">
                        <tr>
                            <th class="sorting_desc">No</th>
                            <th class="sorting_desc">Nama</th>
                            <th class="sorting_desc">Total<br> Hari Kerja</th>
                            <th class="sorting_desc">Total<br> Jam Kerja</th>
                            <th class="sorting_desc">Total<br> Akt Harian</th>
                            <th class="sorting_desc">Total<br> Tidak Masuk</th>
                            <th class="sorting_desc">Upload<br> Akt Harian</th>
                            <th class="sorting_desc">Upload<br> Lap Bulanan</th>
                            <th class="sorting_desc">Nilai<br> Evkin</th>
                            <th class="sorting_desc">Kabupaten</th>
                            <!-- <th class="sorting_desc">Kecamatan</th>
                            <th class="sorting_desc">Desa</th> -->
                        </tr>
                    </thead>

                    <!-- <center><span class="loader"><i class="fa fa-spinner fa-3x fa-spin"></i></span></center> -->
                    <tbody class="tbody">
                        <?php $no = 1;?>
                        @foreach($faskab as $fas)
                        <?php 
                            $seconds = $fas->jam_kerja;
                            $hours = floor($seconds / 3600);
                            $seconds -= $hours * 3600;
                            $minutes = floor($seconds / 60);
                            $seconds -= $minutes * 60;
                        ?>
                            <tr>
                                <td>{{$no++}}</td>
                                <td>{{$fas->name}}</td>
                                <td>{{$fas->hari_kerja}}</td>
                                <td>
                                    <?php
                                        if ($fas->jam_kerja < 576000) {
                                            echo "<span style='color:red'>".$hours." jam ".$minutes." menit ".$seconds." detik</span>";
                                        } else {
                                            echo "$hours jam $minutes menit $seconds detik";       
                                        }
                                     
                                    ?>
                                </td>
                                <td>{{$fas->akt_harian}}</td>
                                <td>{{$fas->tdk_masuk}}</td>
                                <td>
                                    @if($fas->lap_bul==0)
                                        <span style="color:red"><u>T</u></span>
                                    @else
                                        Y
                                    @endif
                                </td>
                                <td>
                                    @if($fas->ttd_basah==0)
                                        <span style="color:red"><u>T</u></span>
                                    @else
                                        Y
                                    @endif
                                </td>
                                <td>{{$fas->nilai_evkin}}</td>
                                <td>{{$fas->nmkab}}</td>
                                <!-- <td></td>
                                <td></td> -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <br><br>


                <table class="table table-bordered" id="table-body">
                    <thead class="thead">
                        <tr>
                            <th colspan="12" style="background: #dbfbd7">KORKAB</th>
                        </tr>
                    </thead>
                    <thead class="thead">
                        <tr>
                            <th class="sorting_desc">No</th>
                            <th class="sorting_desc">Nama</th>
                            <th class="sorting_desc">Total<br> Hari Kerja</th>
                            <th class="sorting_desc">Total<br> Jam Kerja</th>
                            <th class="sorting_desc">Total<br> Akt Harian</th>
                            <th class="sorting_desc">Total<br> Tidak Masuk</th>
                            <th class="sorting_desc">Upload<br> Akt Harian</th>
                            <th class="sorting_desc">Upload<br> Lap Bulanan</th>
                            <th class="sorting_desc">Nilai<br> Evkin</th>
                            <th class="sorting_desc">Kabupaten</th>
                            <!-- <th class="sorting_desc">Kecamatan</th>
                            <th class="sorting_desc">Desa</th> -->
                        </tr>
                    </thead>

                    <!-- <center><span class="loader"><i class="fa fa-spinner fa-3x fa-spin"></i></span></center> -->
                    <tbody class="tbody">
                        <?php $no = 1;?>
                        @foreach($korkab as $fas)
                        <?php 
                            $seconds = $fas->jam_kerja;
                            $hours = floor($seconds / 3600);
                            $seconds -= $hours * 3600;
                            $minutes = floor($seconds / 60);
                            $seconds -= $minutes * 60;
                        ?>
                            <tr>
                                <td>{{$no++}}</td>
                                <td>{{$fas->name}}</td>
                                <td>{{$fas->hari_kerja}}</td>
                                <td>
                                    <?php
                                        if ($fas->jam_kerja < 576000) {
                                            echo "<span style='color:red'>".$hours." jam ".$minutes." menit ".$seconds." detik</span>";
                                        } else {
                                            echo "$hours jam $minutes menit $seconds detik";       
                                        }
                                     
                                    ?>
                                </td>
                                <td>{{$fas->akt_harian}}</td>
                                <td>{{$fas->tdk_masuk}}</td>
                                <td>
                                    @if($fas->lap_bul==0)
                                        <span style="color:red"><u>T</u></span>
                                    @else
                                        Y
                                    @endif
                                </td>
                                <td>
                                    @if($fas->ttd_basah==0)
                                        <span style="color:red"><u>T</u></span>
                                    @else
                                        Y
                                    @endif
                                </td>
                                <td>{{$fas->nilai_evkin}}</td>
                                <td>{{$fas->nmkab}}</td>
                                <!-- <td></td>
                                <td></td> -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            <!--  table end -->

            <!-- <div class="ot-pagination d-flex justify-content-end align-content-center">
			    <nav aria-label="Page navigation example">
			        <ul class="pagination" id="paginationData">
			           
			        </ul>
			    </nav>
			</div>

            <div class="ot-pagination d-flex justify-content-end align-content-center">
                <p>Menampilkan <span id="from">0</span> data pada halaman <span id="hal">0</span> dari total <span id="total">0</span> data</small>
            </div> -->

        </div>
    </div>
</div>

@endsection
<!-- MODAL -->
    <div id="formModalAbsensi" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">Absensi Bulan Ini</h5>
                    <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="content-absensi">
                </div>
            </div>
        </div>
    </div>
<!---End Modal--->
@section('script')

<script type="text/javascript">

    var current = "{!!str_replace('laporan-rekap-bulanan','export-rekap-bulanan', url()->full() )!!}";
    $(".btn-export").click(function(){
      window.open(current, '_blank');
    });

    @if(empty($_GET['kodekab']))
        var kodekab = "";
    @else
        var kodeprov = "{{$_GET['kodeprov']}}";
        var kodekab = "{{$_GET['kodekab']}}";

        $.ajax({
            url: 'get-kab/'+kodeprov,
            type:"GET",
            dataType:"json",
            success:function(data) {
                
                for(var i = 0; i < data.kabupaten.length; i++) {

                    if (kodekab == data.kabupaten[i].kdkab) {
                        var selected = 'selected';
                    } else {
                        var selected = '';
                    }

                    $('select[name="kodekab"]').append('<option value="'+data.kabupaten[i].kdkab+'" '+selected+'>' + data.kabupaten[i].nmkab + '</option>');
                }
            },
            complete: function(){
                $('.loader').css("visibility", "hidden");
            }
        });
    @endif

    

    

    //Filter Data
    $('select[name="kodeprov"]').on('change', function(){
        var id_prov = $(this).val();
        $('select[name="kodekab"]').empty();
        $('select[name="kodekab"]').append('<option value="">-Pilih Kabupaten-</option>');
        $('select[name="kodekec"]').empty();
        $('select[name="kodekec"]').append('<option value="">-Pilih Kecamatan-</option>');
        $('select[name="kodedesa"]').empty();
        $('select[name="kodedesa"]').append('<option value="">-Pilih Desa-</option>');
        if(id_prov) {
            $.ajax({
                url: 'get-kab/'+id_prov,
                type:"GET",
                dataType:"json",
                success:function(data) {
                    
                    for(var i = 0; i < data.kabupaten.length; i++) {

                        if (kodekab == data.kabupaten[i].kdkab) {
                            var selected = 'selected';
                        } else {
                            var selected = '';
                        }

                        $('select[name="kodekab"]').append('<option value="'+data.kabupaten[i].kdkab+'">' + data.kabupaten[i].nmkab + '</option>');
                    }
                },
                complete: function(){
                    $('.loader').css("visibility", "hidden");
                }
            });
            
        } else {
            $('select[name="kodekab"]').empty();
            $('select[name="kodekec"]').empty();
            $('select[name="kodedesa"]').empty();
        }
    });

    $(document).ready(function(){
      $('.fa-navicon').trigger('click');
    });
    
</script>
@endsection
