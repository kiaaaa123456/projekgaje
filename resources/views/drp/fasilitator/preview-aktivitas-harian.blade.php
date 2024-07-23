<?php

    

    if($bulan==1) {
        $bulan = 'Januari';
    } else if($bulan==2) {
        $bulan = 'Februari';
    } else if($bulan==3) {
        $bulan = 'Maret';
    } else if($bulan==4) {
        $bulan = 'April';
    } else if($bulan==5) {
        $bulan = 'Mei';
    } else if($bulan==6) {
        $bulan = 'Juni';
    } else if($bulan==7) {
        $bulan = 'Juli';
    } else if($bulan==8) {
        $bulan = 'Agustus';
    } else if($bulan==9) {
        $bulan = 'September';
    } else if($bulan==10) {
        $bulan = 'Oktober';
    } else if($bulan==11) {
        $bulan = 'November';
    } else if($bulan==12) {
        $bulan = 'Desember';
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Laporan Aktivitas Harian  </title>
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
            LAPORAN AKTIVITAS HARIAN
		</h4>
	</center>

	<table class="table-laporan" style="margin-top: 0px;width: 100%;" border="1"><br/>
        <tr>
            <th colspan="7"><h3>TRANSFORMASI EKONOMI KAMPUNG TERPADU (TEKAD)</h3></th>
        </tr>
        <tr>
            <th colspan="7"><h4>KEGIATAN HARIAN {{strtoupper($department)}}</h4></th>
        </tr>
        <tr bgcolor="#cbc0c0">
            <th colspan="2"><span style="text-align:left">NAMA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></th>
            
            <th colspan="5" style="text-align:left">&nbsp;{{strtoupper($nama)}}</th>
        </tr>
        <tr bgcolor="#cbc0c0">
            <th colspan="2"> <span style="text-align:left">JABATAN &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></th>
            
            <th colspan="5" style="text-align:left">&nbsp;{{strtoupper($department)}}</th>
        </tr>
        <tr bgcolor="#cbc0c0">
            <th colspan="2"> <span style="text-align:left">PROVINSI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></th>
            <th colspan="3" style="text-align:left">&nbsp;{{strtoupper($nmprov)}}</th>
            <th><span style="text-align:left">&nbsp;Bulan : {{$bulan}}</span></th>
            <th><span style="text-align:left">&nbsp;Tahun : {{date('Y')}}</span></th>
        </tr>
        @if($id_dep==8 || $id_dep==7 || $id_dep==6)
        <tr bgcolor="#cbc0c0">
            <th colspan="2"> <span style="text-align:left">KABUPATEN &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></th>
            <th colspan="5" style="text-align:left">&nbsp;{{strtoupper($nmkab)}}</th>
        </tr>
        @endif

        @if($id_dep==8 || $id_dep==7)
        <tr bgcolor="#cbc0c0">
            <th colspan="2"> <span style="text-align:left">KECAMATAN/DISTRIK &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></th>
            <th colspan="5" style="text-align:left">&nbsp;{{strtoupper($nmkec)}}</th>
        </tr>
        @endif

        @if($id_dep==8)
        <tr bgcolor="#cbc0c0">
            <th colspan="2"> <span style="text-align:left">DESA/KAMPUNG&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></th>
            <th colspan="5" style="text-align:left">&nbsp;{{strtoupper($nmdesa)}}</th>
        </tr>
        @endif
        <tr bgcolor="#b4e6e6">
            <th colspan="7"><u><span style="text-align:left">Ringkasan Kegiatan</span></u>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </th>
        </tr>
        <tr>
            <th colspan="7">
                <br><br><br>
            </th>
        </tr>
        <!-- <tr bgcolor="#b4e6e6">
            <th >Total : </th>
            <th >Hari : </th>
            <th colspan="5"></th>
        </tr> -->
        @if($id_dep==8)
        <tr>
            <th colspan="2">
                <br>Disetujui <br> Fasilitator Kecamatan/Distrik <br><br><br><br><br>(....................................)
            </th>
            <th colspan="3">
                <br>Mengetahui <br> Kepala Desa/Kampung <br><br><br><br><br>(....................................)
            </th>
            <th colspan="2">
                <br>Dibuat Oleh <br> Kader Desa/Kampung <br><br><br><br><br>(....................................)
            </th>
        </tr>

        @elseif($id_dep==7)
        <tr>
            <th colspan="2">
                <br>Disetujui <br> Koordinator Kabupaten <br><br><br><br><br>(....................................)
            </th>
            <th colspan="3">
                <br>Mengetahui <br> Camat <br><br><br><br><br>(....................................)
            </th>
            <th colspan="2">
                <br>Dibuat Oleh <br> Fasilitator Kecamatan <br><br><br><br><br>(....................................)
            </th>
        </tr>
        @elseif($id_dep==6)
        <tr>
            <th colspan="2">
                <br>Disetujui <br> Koordinator Kabupaten <br><br><br><br><br>(....................................)
            </th>
            <th colspan="3">
                <br>Mengetahui <br> DPIU/ TPK Kabupaten <br><br><br><br><br>(....................................)
            </th>
            <th colspan="2">
                <br>Dibuat Oleh <br> Fasilitator Kabupaten <br><br><br><br><br>(....................................)
            </th>
        </tr>
        @elseif($id_dep==5)
        <tr>
            <th colspan="2">
                <br>Disetujui <br> DPIU/TPK Kabupaten <br><br><br><br><br>(....................................)
            </th>
            <th colspan="3">
                
            </th>
            <th colspan="2">
                <br>Dibuat Oleh <br> Koordinator Kabupaten <br><br><br><br><br>(....................................)
            </th>
        </tr>
        @endif


        <tr bgcolor="#a0d2d2">
            <th rowspan="2">No</th>
            <th colspan="2">(Bulan) Tahun</th>
            <th colspan="4"><center>URAIAN KEGIATAN HARIAN</center></th>
        </tr>

		<tr bgcolor="#a0d2d2">
            <th>HARI</th>
            <th>TANGGAL</th>
            <th>RENCANA</th>
            <th>REALISASI</th>
            <th colspan="2">LOKASI</th>
        </tr>

        <?php
            $no =1;
            if (empty($data)) {
                echo "<tr><td colspan='7'>Belum ada data</td></tr>";
            } else {
        	foreach($data as $row) {
            
             $daftar_hari = array( 'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu' );
             $date= $row->date;
             $namahari = date('l', strtotime($date)); 
        ?>

        <tr>

        	<td><center><?=$no++?></center></td>
            <td>&nbsp;<?=$daftar_hari[$namahari]?></td>
            <td><center><?=date('d-m-Y', strtotime($row->date));?></center></td>
            <td>&nbsp;<?=$row->title;?></td>
            <td>&nbsp;<?=$row->description;?></td>
            <td colspan="2">&nbsp;<?=$row->location;?></td>
        </tr>

        <?php 
        	} }
        ?>

        <tr bgcolor="#a0d2d2">
        	<td colspan="4"></td>
            <td colspan="2">Jumlah Jam Kerja</td>
            <td colspan="1">
                <?php 
                    $seconds = $durasi;
                    $hours = floor($seconds / 3600);
                    $seconds -= $hours * 3600;
                    $minutes = floor($seconds / 60);
                    $seconds -= $minutes * 60;

                    echo "$hours jam $minutes menit $seconds detik";
                ?>
            </td>
        </tr>

        <tr bgcolor="#a0d2d2">
            <td colspan="4"></td>
            <td colspan="2">Jumlah Hari Kerja</td>
            <td colspan="1"> {{$total_kerja}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>

        <tr>
            <th colspan="7"><h4>TIDAK MASUK KERJA</h4></th>
        </tr>
        <tr bgcolor="#a0d2d2">
            <th>NO</th>
            <th>JENIS</th>
            <th>TANGGAL PENGAJUAN</th>
            <th>TANGGAL TIDAK MASUK</th>
            <th>DURASI</th>
            <th colspan="2">ALASAN</th>
        </tr>
        <?php $no=1;
        if (empty($data)) {
                echo "<tr><td colspan='7'>Belum ada data</td></tr>";
        } else {
            foreach ($leave  as $val) {
        ?>
        <tr>
            <td><center><?=$no++?></center></td>
            <td>&nbsp;&nbsp;<?=$val->name;?></td>
            <td><center><?=date('d-m-Y', strtotime($val->apply_date));?></center></td>
            <td><center><?=date('d-m-Y', strtotime($val->leave_from));?> s.d. <?=date('d-m-Y', strtotime($val->leave_to));?></center></td>
            <td><center><?=$val->durasi;?> hari</center></td>
            <td colspan="2">&nbsp;&nbsp;<?=$val->reason;?></td>
        </tr>
        <?php } } ?>

    </table>

