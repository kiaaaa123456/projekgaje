@extends('backend.layouts.app') @section('title', 'Profile') @section('content')

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<div class="breadcrumb-warning d-flex justify-content-between ot-card">
    <div><h3>Profil Pengguna</h3></div>
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb ot-breadcrumb ot-breadcrumb-basic">
            <li class="breadcrumb-item"><a href="{!!url('dashboard')!!}">Dashboard</a></li>
            <li class="breadcrumb-item active">Profil</li>
        </ol>
    </nav>
</div>

<?php
function tgl_indo($tanggal){
    $bulan = array (
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);
 
    return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}
?>

<div class="table-content table-basic">
    <div class="card">
        <div class="card-body">
            <!-- toolbar table start -->
            <div class="table-toolbar flex-wrap gap-2 flex-xl-row justify-content-xxl-between align-content-center pb-3">
                <div class="align-self-center">
                    <div class="flex-wrap gap-2 flex-lg-row justify-content-center align-content-center">
                        <div class="row">
                            <div class="col-md-12">
                                
                                <div class="table-content table-basic">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tbody class="tbody">
                                                <tr>
                                                    <td>NIK</td>
                                                    <td>:</td>
                                                    <td>{{$data['0']->nik}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Nama Lengkap</td>
                                                    <td>:</td>
                                                    <td>{{$data['0']->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Tanggal Lahir</td>
                                                    <td>:</td>
                                                    <td>{{tgl_indo($data['0']->birth_date)}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Peran</td>
                                                    <td>:</td>
                                                    <td>{{$data['0']->displayname}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Provinsi</td>
                                                    <td>:</td>
                                                    <td>{{$nmprov}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Kabupaten</td>
                                                    <td>:</td>
                                                    <td>{{$nmkab}}</td>
                                                </tr>

                                                <tr>
                                                    <td>Kecamatan/Distrik</td>
                                                    <td>:</td>
                                                    <td>{{$nmkec}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Desa/Kampung</td>
                                                    <td>:</td>
                                                    <td>{{$nmdesa}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Alamat</td>
                                                    <td>:</td>
                                                    <td>{{$data['0']->address}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Email</td>
                                                    <td>:</td>
                                                    <td>{{$data['0']->email}}</td>
                                                </tr>
                                                <tr>
                                                    <td>No Telepon</td>
                                                    <td>:</td>
                                                    <td>{{$data['0']->phone}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Jenis Kelamin</td>
                                                    <td>:</td>
                                                    <td>{{$data['0']->gender}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Foto</td>
                                                    <td>:</td>
                                                    <td>
                                                        @if(substr($data['0']->image,0,6)=='static' || empty($data['0']->image))
                                                            <img src="https://tekad.kemendesa.go.id/e-lapkin/static/blank_small.png" style="width:80px;object-fit: cover;"></a>
                                                        @else
                                                            <img src="https://tekad.kemendesa.go.id/monev/storage/{{$data['0']->image}}" style="width:80px;object-fit: cover;"></a>
                                                        @endif
                                                        
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- toolbar table end -->
        </div>
    </div>
</div>

@endsection @section('script')

<script
    src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
></script>

@endsection
