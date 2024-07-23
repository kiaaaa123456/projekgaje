<?php

    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Export Laporan Rekap Bulanan.xls");
    
?>

<!DOCTYPE html>
<html>
<head>
	<title>Laporan Rekap Bulanan</title>
	<style type="text/css">
        .table-laporan {
            border-collapse: collapse;
            font-size: 12px;
        }
        .bordernya {
            border: 1px solid black !important;
            
        }
        .bordernyanol {
            border: 0px !important;
        }
        .bordernya > th {
            border-collapse: collapse;
            border: 1px solid black !important;
            text-align: center;
            vertical-align: middle !important;
        }
        .bordernya > td {
            border-collapse: collapse;
            border: 1px solid black !important;
        }
        .bordernyanol > td {
            border-collapse: collapse;
            border: 0px !important;
        }
    </style>
</head>
<body>

	<center>
		<h4>
            LAPORAN REKAP BULANAN
		</h4>
	</center>

	<table class="table-laporan" style="margin-top: 0px" border="1"><br/>
        <thead class="thead">
            <tr>
                <th >Provinsi</th>
                <th >:</th>
                <th >{{$nmprov}}</th>
                <th >Bulan / Tahun</th>
                <th >:</th>
                <th >{{$nama_bulan}} / {{date('Y')}}</th>
            </tr>
            <tr>
                <th >Kabupaten</th>
                <th >:</th>
                <th >{{$nmkab}}</th>
                <th >Jumlah Fasilitator</th>
                <th >:</th>
                <th >{{$jml}} Orang</th>
            </tr>
        </thead>
    </table>

    <br><br>
            <div class="table-responsive" style="border:1px">
                <table class="table-laporan" id="table-body" border="1">
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


                <table class="table-laporan" id="table-body" border="1">
                    <thead class="thead">
                        <tr>
                            <th colspan="11"  style="background: #dbfbd7">FK - FASDIS</th>
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
                                <td><center>{{$fas->hari_kerja}}</center></td>
                                <td>
                                    <?php
                                        if ($fas->jam_kerja < 576000) {
                                            echo "<span style='color:red'>".$hours." jam ".$minutes." menit ".$seconds." detik</span>";
                                        } else {
                                            echo "$hours jam $minutes menit $seconds detik";       
                                        }
                                     
                                    ?>
                                </td>
                                <td><center>{{$fas->akt_harian}}</center></td>
                                <td><center>{{$fas->tdk_masuk}}</center></td>
                                <td>
                                    @if($fas->lap_bul==0)
                                       <center> <span style="color:red"><u>T</u></span></center>
                                    @else
                                        <center>Y</center>
                                    @endif
                                </td>
                                <td>
                                    @if($fas->ttd_basah==0)
                                        <center><span style="color:red"><u>T</u></span></center>
                                    @else
                                        <center>Y</center>
                                    @endif
                                </td>
                                <td><center>{{$fas->nilai_evkin}}</center></td>
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


                <table class="table-laporan" id="table-body" border="1">
                    <thead class="thead">
                        <tr>
                            <th colspan="10" style="background: #dbfbd7">FASKAB</th>
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
                                <td><center>{{$fas->hari_kerja}}</center></td>
                                <td>
                                    <?php
                                        if ($fas->jam_kerja < 576000) {
                                            echo "<span style='color:red'>".$hours." jam ".$minutes." menit ".$seconds." detik</span>";
                                        } else {
                                            echo "$hours jam $minutes menit $seconds detik";       
                                        }
                                     
                                    ?>
                                </td>
                                <td><center>{{$fas->akt_harian}}<center></td>
                                <td><center>{{$fas->tdk_masuk}}<center></td>
                                <td>
                                    @if($fas->lap_bul==0)
                                        <center><span style="color:red"><u>T</u></span><center>
                                    @else
                                        <center>Y<center>
                                    @endif
                                </td>
                                <td>
                                    @if($fas->ttd_basah==0)
                                        <center><span style="color:red"><u>T</u></span><center>
                                    @else
                                        <center>Y<center>
                                    @endif
                                </td>
                                <td><center>{{$fas->nilai_evkin}}</center></td>
                                <td>{{$fas->nmkab}}</td>
                                <!-- <td></td><center>
                                <td></td> -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <br><br>


                <table class="table-laporan" id="table-body" border="1">
                    <thead class="thead">
                        <tr>
                            <th colspan="10"  style="background: #dbfbd7">KORKAB</th>
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
                                <td><center>{{$fas->hari_kerja}}</center></td>
                                <td>
                                    <?php
                                        if ($fas->jam_kerja < 576000) {
                                            echo "<span style='color:red'>".$hours." jam ".$minutes." menit ".$seconds." detik</span>";
                                        } else {
                                            echo "$hours jam $minutes menit $seconds detik";       
                                        }
                                     
                                    ?>
                                </td>
                                <td><center>{{$fas->akt_harian}}</center></td>
                                <td><center>{{$fas->tdk_masuk}}</center></td>
                                <td>
                                    @if($fas->lap_bul==0)
                                        <center><span style="color:red"><u>T</u></span></center>
                                    @else
                                        <center>Y</center>
                                    @endif
                                </td>
                                <td>
                                    @if($fas->ttd_basah==0)
                                        <center><span style="color:red"><u>T</u></span></center>
                                    @else
                                        <center>Y</center>
                                    @endif
                                </td>
                                <td><center>{{$fas->nilai_evkin}}</center></td>
                                <td>{{$fas->nmkab}}</td>
                                <!-- <td></td>
                                <td></td> -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

    
        
    

