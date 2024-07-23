<?php

    if(date('m')==1) {
        $bulan = 'Januari';
    } else if(date('m')==2) {
        $bulan = 'Februari';
    } else if(date('m')==3) {
        $bulan = 'Maret';
    } else if(date('m')==4) {
        $bulan = 'April';
    } else if(date('m')==5) {
        $bulan = 'Mei';
    } else if(date('m')==6) {
        $bulan = 'Juni';
    } else if(date('m')==7) {
        $bulan = 'Juli';
    } else if(date('m')==8) {
        $bulan = 'Agustus';
    } else if(date('m')==9) {
        $bulan = 'September';
    } else if(date('m')==10) {
        $bulan = 'Oktober';
    } else if(date('m')==11) {
        $bulan = 'November';
    } else if(date('m')==12) {
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

	<table class="table-laporan" style="margin-top: 0px" border="1" width="100%"><br/>
        <tr>
            <th colspan="7"><h3>TRANSFORMASI EKONOMI KAMPUNG TERPADU (TEKAD)</h3></th>
        </tr>
        <tr>
            <th colspan="7"><h4>ABSENSI {{strtoupper($department)}}</h4></th>
        </tr>
        <tr bgcolor="#cbc0c0">
            <th colspan="2"><span style="float:left">&nbsp;&nbsp;&nbsp;NAMA</span></th>
            <th>:</th>
            <th colspan="4" style="text-align:left">&nbsp;{{strtoupper($nama)}}</th>
        </tr>
        <tr bgcolor="#cbc0c0">
            <th colspan="2"> <span style="float:left">&nbsp;&nbsp;&nbsp;JABATAN </span></th>
            <th>:</th>
            <th colspan="4" style="text-align:left">&nbsp;{{strtoupper($department)}}</th>
        </tr>
        <tr bgcolor="#cbc0c0">
            <th colspan="2"> <span style="float:left">&nbsp;&nbsp;&nbsp;PROVINSI </span></th>
            <th>:</th>
            <th colspan="4" style="text-align:left">&nbsp;{{strtoupper($nmprov)}}</th>
        </tr>
        @if($id_dep==8 || $id_dep==7 || $id_dep==6 || $id_dep==5)
        <tr bgcolor="#cbc0c0">
            <th colspan="2"> <span style="float:left">&nbsp;&nbsp;&nbsp;KABUPATEN </span></th>
            <th>:</th>
            <th colspan="4" style="text-align:left">&nbsp;{{strtoupper($nmkab)}}</th>
        </tr>
        @endif

        @if($id_dep==8 || $id_dep==7)
        <tr bgcolor="#cbc0c0">
            <th colspan="2"> <span style="float:left">&nbsp;&nbsp;&nbsp;KECAMATAN/DISTRIK </span></th>
            <th>:</th>
            <th colspan="4" style="text-align:left">&nbsp;{{strtoupper($nmkec)}}</th>
        </tr>
        @endif

        @if($id_dep==8)
        <tr bgcolor="#cbc0c0">
            <th colspan="2"> <span style="float:left">&nbsp;&nbsp;&nbsp;DESA/KAMPUNG </span></th>
            <th>:</th>
            <th colspan="4" style="text-align:left">&nbsp;{{strtoupper($nmdesa)}}</th>
        </tr>
        @endif

        

		<tr bgcolor="#a0d2d2">
            <th>No</th>
            <th>HARI</th>
            <th>TANGGAL</th>
            <th>MASUK</th>
            <th>LOKASI</th>
            <th>PULANG</th>
            <th>LOKASI</th>
        </tr>

        <?php
            if (empty($data)) {
                
                echo "<tr><td colspan='7'>Belum ada data</td></tr>";
            } else{

            $no =1;
        	foreach($data as $row) {
            
             $daftar_hari = array( 'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu' );
             $date= $row->date;
             $namahari = date('l', strtotime($date)); 
        ?>

        <tr>

        	<td>&nbsp;<?=$no++?></td>
            <td>&nbsp;<?=$daftar_hari[$namahari]?></td>
        	<td>&nbsp;<?=date('d-m-Y', strtotime($row->date));?></td>
            <td>&nbsp;<?=date('d-m-Y', strtotime($row->check_in));?></td>
            <td>&nbsp;<?=$row->check_in_location;?></td>
            <td>&nbsp;
                    <?php 
                    if (empty($row->check_out)) {
                        echo "-";
                    } else {
                        echo date('d-m-Y', strtotime($row->check_out));
                    }
                    ?>
            </td>
            <td>&nbsp;<?=$row->check_out_location;?></td>
        </tr>

        <?php 
        	} }
        ?>

        <tr bgcolor="#a0d2d2">
        	<td colspan="2"></td>
            <td colspan="2">Jumlah Hari Kerja</td>
            <td colspan="3"> {{count($data)}}</td>
        </tr>

    </table>

