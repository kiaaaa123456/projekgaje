<?php
    if(Auth::user()->department_id == 7) {
        $fas = 'Evkin Kader';
        $wilayah = "".strtoupper($nmprov)." - ".strtoupper($nmkab)."";
    } else if(Auth::user()->department_id == 6) {
        $fas = 'Evkin Fasdis';
        $wilayah = "".strtoupper($nmprov)." - ".strtoupper($nmkab)."";
    } else if(Auth::user()->department_id == 5) {
        $fas = 'Evkin Faskab';
        $wilayah = "".strtoupper($nmprov)."";
    } else if(Auth::user()->department_id == 8) {
        $wilayah = "".strtoupper($nmprov)." - ".strtoupper($nmkab)."";
    }
?>

@extends('backend.layouts.app')
@section('title', 'Evkin Kader')
@section('content')

    <div class="breadcrumb-warning d-flex justify-content-between ot-card">
    <div>
        <h3>Evkin Kader</h3>
        <i class="fa fa-map"></i> Kabupaten {{$nmkab}}
    </div>
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb ot-breadcrumb ot-breadcrumb-basic">
            <li class="breadcrumb-item"><a href="{!!url('dashboard')!!}">Dashboard</a></li>
            <li class="breadcrumb-item active">Evkin Kader</li>
            
        </ol>
    </nav>
</div>


@if(Auth::user()->department_id == 7 || Auth::user()->department_id == 6 || Auth::user()->department_id == 5)
    <div class="d-flex justify-content-between flex-wrap dashboard-heading  align-items-center pb-24 gap-3">
        <h3 class="mb-0"></h3>
        <div class="dropdown card-button">
            <button class="btn btn-secondary ot-dropdown-btn dropdown-toggle" type="button" id="revenueBtn" data-bs-toggle="dropdown" aria-expanded="false" style="background:#385834">
                <span id="__selected_dashboard">Evkin Kader </span>
                <i class="las la-angle-down"></i>
            </button>
            <ul class="dropdown-menu c-dropdown-menu" aria-labelledby="revenueBtn">
                <li>
                    <a class="dropdown-item profile_option" href="{!!url('evkin-saya')!!}"> Evkin Saya</a>
                </li>
                @if(Auth::user()->department_id == 7)
                <li>
                    <a class="dropdown-item profile_option" href="{!!url('periode-evkin')!!}">
                        {{$fas}}
                    </a>
                </li>
                @elseif(Auth::user()->department_id == 6)
                <li>
                    <a class="dropdown-item profile_option" href="{!!url('periode-evkin')!!}">
                        {{$fas}}
                    </a>
                </li>
                <li>
                    <a class="dropdown-item profile_option" href="{!!url('evkin-kader')!!}">
                        Evkin Kader
                    </a>
                </li>

                @elseif(Auth::user()->department_id == 5)
                <li>
                    <a class="dropdown-item profile_option" href="{!!url('periode-evkin')!!}">
                        {{$fas}}
                    </a>
                </li>
                <li>
                    <a class="dropdown-item profile_option" href="{!!url('evkin-fasdis')!!}">
                        Evkin Fasdis
                    </a>
                </li>
                <li>
                    <a class="dropdown-item profile_option" href="{!!url('evkin-kader')!!}">
                        Evkin Kader
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </div>
@endif 

@if(Auth::user()->department_id==27 || Auth::user()->department_id==33)
<div class="d-flex justify-content-between flex-wrap dashboard-heading  align-items-center pb-24 gap-3">
    <h3 class="mb-0"></h3>
    <div class="dropdown card-button">
        <button class="btn btn-secondary ot-dropdown-btn dropdown-toggle" type="button" id="revenueBtn" data-bs-toggle="dropdown" aria-expanded="false" style="background:#385834">
            <span id="__selected_dashboard">Evkin Kader</span>
            <i class="las la-angle-down"></i>
        </button>
        <ul class="dropdown-menu c-dropdown-menu" aria-labelledby="revenueBtn">
            <li>
                <a class="dropdown-item profile_option" href="{!!url('evkin-korkab')!!}"> Evkin Korkab</a>
            </li>
            <li>
                <a class="dropdown-item profile_option" href="{!!url('evkin-faskab')!!}"> Evkin Faskab</a>
            </li>
            <li>
                <a class="dropdown-item profile_option" href="{!!url('evkin-fasdis')!!}"> Evkin Fasdis</a>
            </li>
            <li>
                <a class="dropdown-item profile_option" href="{!!url('evkin-kader')!!}"> Evkin Kader</a>
            </li>
        </ul>
    </div>
</div> 
@endif

<div class="table-content table-basic">
    <div class="card">
        <div class="card-body">
            <!-- toolbar table start -->
            <div class="table-toolbar d-flex flex-wrap gap-2 flex-xl-row justify-content-xxl-between align-content-center pb-3">
                <div class="align-self-center">
                    <div class="d-flex flex-wrap gap-2 flex-lg-row justify-content-center align-content-center">
                        <!-- show per page -->
                        <div class="align-self-center">
                            <label>
                                <span class="mr-8">Tampilan</span>
                                <select class="form-select d-inline-block act" id="limitData">
                                    <option selected value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    <option value="200">200</option>
                                </select>
                            </label>
                        </div>

                        <div class="align-self-center d-flex flex-wrap gap-2">
                            <div class="align-self-center">
                                <div class="search-box d-flex">
                                    <select class="form-control act" name="month" id="month">
                                        <option value="">-Pilih Bulan-</option>
                                        <option value="01">Januari</option>
                                        <option value="02">Februari</option>
                                        <option value="03">Maret</option>
                                        <option value="04">April</option>
                                        <option value="05">Mei</option>
                                        <option value="06">Juni</option>
                                        <option value="07">Juli</option>
                                        <option value="08">Agustus</option>
                                        <option value="09">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="align-self-center d-flex flex-wrap gap-2">
                            <div class="align-self-center">
                                <div class="search-box d-flex">
                                    <select class="form-control act" name="year" id="year">
                                        <option value="">-Pilih Tahun-</option>
                                         @foreach($tahun as $data)
                                        <option value="{{$data->tahun}}">{{$data->tahun}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="align-self-center d-flex flex-wrap gap-2">
                            <button class="btn-add btn-reset" style="background:red;">Reset</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- toolbar table end -->
            <!--  table start -->
            <div class="table-responsive" style="border:1px">
                <table class="table table-bordered" id="table-body">
                    <thead class="thead">
                        <tr>
                        	<th class="sorting_desc">No</th>
                            <th class="sorting_desc">Penilai</th>
                            <th class="sorting_desc">Bulan</th>
                            <th class="sorting_desc">Tahun</th>
                            <th class="sorting_desc">Status</th>
                            <th class="sorting_desc">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="tbody">
	                    <tr id="temp">
	                        <td colspan='6'>Loading Data..</td>
	                    </tr>
	                </tbody>

                </table>
            </div>
            <!--  table end -->

            <div class="ot-pagination d-flex justify-content-end align-content-center">
			    <nav aria-label="Page navigation example">
			        <ul class="pagination" id="paginationData">
			           
			        </ul>
			    </nav>
			</div>

        </div>
    </div>
</div>

<div class="modal fade lead-modal" id="formModal" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content data">
            <div class="modal-header mb-3" style="background:#dbfbd7 !important">
                <h5 class="modal-title">Tambah Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times text-white" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" class="" enctype="multipart/form-data" id="form_data">
                    @csrf
                    <input type="hidden" name="action" id="action" />
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <div class="">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="name">Bulan <span class="text-danger">*</span></label>
                                    <select class="form-control" name="bulan" id="bulan" required>
                                        <option value="">-Pilih Bulan-</option>
                                        <option value="01">Januari</option>
                                        <option value="02">Februari</option>
                                        <option value="03">Maret</option>
                                        <option value="04">April</option>
                                        <option value="05">Mei</option>
                                        <option value="06">Juni</option>
                                        <option value="07">Juli</option>
                                        <option value="08">Agustus</option>
                                        <option value="09">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Tahun <span class="text-danger">*</span></label>
                                    <input type="" class="form-control" name="tahun" id="tahun" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="float-right d-flex justify-content-end">
                                    <button type="submit" class="btn btn-success action-btn">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>



@endsection
@section('script')
<script type="text/javascript">
	
	var page  = 1;
    var limit  = 10;
    var month  = 'all';
    var year  = 'all';
    
    loadData(page, limit, month, year);
    
    function loadData(page, limit, month, year){

        $.ajax({
        url: "get-evkin-kader/"+page+"/"+limit+"/"+month+"/"+year,
        type: 'get',
        dataType: 'json',
            
            success: function(response){
                $('#tableData tbody').empty(); 
                $('#paginationData').empty(); 
                $('#from').empty(); 
                $('#hal').empty(); 
                $('#total').empty(); 

                if (response['status']!='success') {

                    window.location.href = '{!!url("masuk")!!}';

                } else {

                    len = response['data'].length;
                    pag = response['total_page'];
                    total = response['count'];
                    page_last = pag - 4;
                    
                    var no = 1;

                    console.log(len);

                    if(len > 0){
                        $(".tbody").empty();
                        // Load Data Table
                        for(var i=0; i<len; i++){
                            
                            if(response['data'][i].bulan=='01') {
                                month = 'Januari';
                            } else if(response['data'][i].bulan=='02') {
                                month = 'Februari'
                            } else if(response['data'][i].bulan=='03') {
                                month = 'Maret'
                            } else if(response['data'][i].bulan=='04') {
                                month = 'April'
                            } else if(response['data'][i].bulan=='05') {
                                month = 'Mei'
                            } else if(response['data'][i].bulan=='06') {
                                month = 'Juni'
                            } else if(response['data'][i].bulan=='07') {
                                month = 'Juli'
                            } else if(response['data'][i].bulan=='08') {
                                month = 'Agustus'
                            } else if(response['data'][i].bulan=='09') {
                                month = 'September'
                            } else if(response['data'][i].bulan=='10') {
                                month = 'Oktober'
                            } else if(response['data'][i].bulan=='11') {
                                month = 'November'
                            } else if(response['data'][i].bulan=='12') {
                                month = 'Desember'
                            }

                            if(response['data'][i].status=='0') {
                                status = '<button class="btn btn-sm btn-warning">Proses Penilaian</button>';
                            } else if(response['data'][i].status=='1') {
                                status = '<button class="btn btn-sm btn-success">Selesai</button>';
                            }

                            var content = "<tr>" +
                            "<td>" + no++ + "</td>" +
                            "<td>" + response['data'][i].name+ "</td>" +
                            "<td>" + month + "</td>" +
                            "<td>" + response['data'][i].tahun+ "</td>" +
                            "<td>" + status + "</td>" +
                            "<td><a href='evkin-fasilitator/"+response['data'][i].id+"'><i class='fa fa-eye' style='cursor:pointer' title='Lihat Detail'></i></a>&nbsp;</td>" +
                            "</tr>";
                            $(".tbody").append(content);
                            $(".showEdit").hide();
                        }
                        // End Load Data Table
                        if (page < 2) {
                            var prev_status = 'disabled';
                        }

                        if (page == pag) {
                            var next_status = 'disabled';
                        }
                        
                        if (pag > 7 && page < page_last) {

                                var prev = '<li class="page-item '+prev_status+'"><a class="page-link act-page" id="'+(page-1)+'" style="cursor:pointer"><i class="fas fa-angle-left"></i><span class="sr-only">Previous</span></a></li>';
                                $("#paginationData").append(prev);

                                for(var p=0; p<5; p++){
                                    if (page == p+1) {
                                        var contentpage = '<li class="page-item active"><a class="page-link act-page" id="'+(p+1)+'" style="cursor:pointer">'+(p+1)+'</a></li>';
                                        $("#paginationData").append(contentpage);
                                    } else {
                                        var contentpage = '<li class="page-item"><a class="page-link act-page" id="'+(p+1)+'" style="cursor:pointer">'+(p+1)+'</a></li>';
                                        $("#paginationData").append(contentpage);
                                    }
                                }

                                var contentpage = '<li class="page-item "><a class="page-link">..</a></li>';
                                $("#paginationData").append(contentpage);

                                
                                if (page == pag) {
                                    var contentpage = '<li class="page-item active"><a class="page-link act-page" id="'+pag+'" style="cursor:pointer">'+pag+'</a></li>';
                                    $("#paginationData").append(contentpage);
                                    $('#paginationData').empty();
                                    var prev = '<li class="page-item '+prev_status+'"><a class="page-link act-page" id="'+(page-1)+'" style="cursor:pointer"><i class="fas fa-angle-left"></i><span class="sr-only">Previous</span></a></li>';
                                    $("#paginationData").append(prev);
                                    var contentpagefirst = '<li class="page-item "><a class="page-link act-page" id="1">1</a></li>';
                                    $("#paginationData").append(contentpagefirst);
                                    var contentpagedot = '<li class="page-item "><a class="page-link" href="#">..</a></li>';
                                    $("#paginationData").append(contentpagedot);
                                    var pagedown = pag - 5 ;

                                    for(var d=pagedown; d<pag; d++){

                                        var contentpage = '<li class="page-item"><a class="page-link act-page" id="'+(d+1)+'" style="cursor:pointer">'+(d+1)+'</a></li>';
                                        $("#paginationData").append(contentpage);
                                    }


                                } else {
                                    var contentpage = '<li class="page-item "><a class="page-link act-page" id="'+pag+'" style="cursor:pointer">'+pag+'</a></li>';
                                    $("#paginationData").append(contentpage);
                                }

                                if (page >= 5) {

                                    $('#paginationData').empty();

                                    var prev = '<li class="page-item '+prev_status+'"><a class="page-link act-page" id="'+(page-1)+'" style="cursor:pointer"><i class="fas fa-angle-left"></i><span class="sr-only">Previous</span></a></li>';
                                    $("#paginationData").append(prev);
                                    var contentpagefirst = '<li class="page-item "><a class="page-link act-page" id="1">1</a></li>';
                                    $("#paginationData").append(contentpagefirst);
                                    var contentpagedot = '<li class="page-item "><a class="page-link" href="#">..</a></li>';
                                    $("#paginationData").append(contentpagedot);                                    
                                    
                                    var midsecond = (page*1);
                                    var midfirst = (midsecond*1-1);
                                    var midthird = (midsecond*1+1);

                                    var contentpage = '<li class="page-item mid-first"><a class="page-link act-page" id="'+midfirst+'" style="cursor:pointer">'+midfirst+'</a></li>';
                                    $("#paginationData").append(contentpage);

                                    
                                    var contentpage = '<li class="page-item mid-second active"><a class="page-link act-page" id="'+midsecond+'">'+midsecond+'</a></li>';
                                    $("#paginationData").append(contentpage);

                                    
                                    var contentpage = '<li class="page-item mid-third"><a class="page-link act-page" id="'+midthird+'" style="cursor:pointer">'+midthird+'</a></li>';
                                    $("#paginationData").append(contentpage);

                                    var contentpagedot = '<li class="page-item "><a class="page-link" href="#">..</a></li>';
                                    $("#paginationData").append(contentpagedot);
                                    var contentpagelast = '<li class="page-item "><a class="page-link act-page" id="'+pag+'" style="cursor:pointer">'+pag+'</a></li>';
                                    $("#paginationData").append(contentpagelast);

                                }

                                var next = '<li class="page-item '+next_status+'"><a class="page-link act-page" id="'+(page*1+1)+'" style="cursor:pointer"><i class="fas fa-angle-right"></i><span class="sr-only">Next</span></a></li>';
                                $("#paginationData").append(next);

                            

                        } else if (pag > 7 && page >= page_last) {
                            
                            var prev = '<li class="page-item '+prev_status+'"><a class="page-link act-page" id="'+(page-1)+'" style="cursor:pointer"><i class="fas fa-angle-left"></i><span class="sr-only">Previous</span></a></li>';
                            $("#paginationData").append(prev);
                            var contentpagefirst = '<li class="page-item "><a class="page-link act-page" id="1" style="cursor:pointer">1</a></li>';
                            $("#paginationData").append(contentpagefirst);
                            var contentpagedot = '<li class="page-item "><a class="page-link" href="#">..</a></li>';
                            $("#paginationData").append(contentpagedot);
                            var pagedown = pag - 5 ;
                            var mid = pagedown + 1 ;

                            if (page == mid ) {

                                $('#paginationData').empty();

                                var prev = '<li class="page-item '+prev_status+'"><a class="page-link act-page" id="'+(page-1)+'" style="cursor:pointer"><i class="fas fa-angle-left"></i><span class="sr-only">Previous</span></a></li>';
                                $("#paginationData").append(prev);
                                var contentpagefirst = '<li class="page-item "><a class="page-link act-page" id="1">1</a></li>';
                                $("#paginationData").append(contentpagefirst);
                                var contentpagedot = '<li class="page-item "><a class="page-link" href="#">..</a></li>';
                                $("#paginationData").append(contentpagedot);                                    
                                
                                var midsecond = (page*1);
                                var midfirst = (midsecond*1-1);
                                var midthird = (midsecond*1+1);

                                var contentpage = '<li class="page-item mid-first"><a class="page-link act-page" id="'+midfirst+'" style="cursor:pointer">'+midfirst+'</a></li>';
                                $("#paginationData").append(contentpage);

                                
                                var contentpage = '<li class="page-item mid-second active"><a class="page-link act-page" id="'+midsecond+'">'+midsecond+'</a></li>';
                                $("#paginationData").append(contentpage);

                                
                                var contentpage = '<li class="page-item mid-third"><a class="page-link act-page" id="'+midthird+'" style="cursor:pointer">'+midthird+'</a></li>';
                                $("#paginationData").append(contentpage);

                                var contentpagedot = '<li class="page-item "><a class="page-link" href="#">..</a></li>';
                                $("#paginationData").append(contentpagedot);
                                var contentpagelast = '<li class="page-item "><a class="page-link act-page" id="'+pag+'" style="cursor:pointer">'+pag+'</a></li>';
                                $("#paginationData").append(contentpagelast);

                                var next = '<li class="page-item '+next_status+'"><a class="page-link act-page" id="'+(page*1+1)+'" style="cursor:pointer"><i class="fas fa-angle-right"></i><span class="sr-only">Next</span></a></li>';
                                $("#paginationData").append(next);



                            } else {

                                for(var d=pagedown; d<pag; d++){

                                    if (page == d+1) {
                                        var contentpage = '<li class="page-item active"><a class="page-link act-page" id="'+(d+1)+'" style="cursor:pointer">'+(d+1)+'</a></li>';
                                        $("#paginationData").append(contentpage);
                                    } else {
                                        var contentpage = '<li class="page-item"><a class="page-link act-page" id="'+(d+1)+'" style="cursor:pointer">'+(d+1)+'</a></li>';
                                        $("#paginationData").append(contentpage);
                                    }
                                }

                                var next = '<li class="page-item '+next_status+'"><a class="page-link act-page" id="'+(page*1+1)+'" style="cursor:pointer"><i class="fas fa-angle-right"></i><span class="sr-only">Next</span></a></li>';
                                $("#paginationData").append(next);

                            }

                        } else {

                            var prev = '<li class="page-item '+prev_status+'"><a class="page-link act-page" id="'+(page-1)+'" style="cursor:pointer"><i class="fas fa-angle-left"></i><span class="sr-only">Previous</span></a></li>';
                            $("#paginationData").append(prev);

                            for(var j=0; j<pag; j++){
                                if (page == j+1) {
                                    var contentpage = '<li class="page-item active"><a class="page-link act-page" id="'+(j+1)+'" style="cursor:pointer">'+(j+1)+'</a></li>';
                                    $("#paginationData").append(contentpage);
                                } else {
                                    var contentpage = '<li class="page-item"><a class="page-link act-page" id="'+(j+1)+'" style="cursor:pointer">'+(j+1)+'</a></li>';
                                    $("#paginationData").append(contentpage);
                                }
                            }

                            var next = '<li class="page-item '+next_status+'"><a class="page-link act-page" id="'+(page*1+1)+'" style="cursor:pointer"><i class="fas fa-angle-right"></i><span class="sr-only">Next</span></a></li>';
                            $("#paginationData").append(next);

                        } 

                        

                        // Load Total Data
                        var from = len;
                        $("#from").append(from);
                        $("#hal").append(page);
                        $("#total").append(total);
                        // End Load Total Data

                    } else {
                        
                       len = response['data'].length;
                       pag = response['total_page'];
                       total = response['count'];

                       $(".tbody").empty();

                       var content = "<tr>" +
                       "<td colspan='6'>Belum ada data.</td>" +
                       "</tr>";
                       $(".tbody").append(content);
                       
                       // Load Total Data
                        var from = len;
                        $("#from").append(from);
                        $("#hal").append(page);
                        $("#total").append(total);
                        // End Load Total Data

                   }
                }
            }

        });

    }    

    $(document).on("click", ".act-page", function () {
        var page = $(this).attr("id");
        var limit = $('#limitData').val();
        var month = $('#month').val();
        if (month=='') {
            month = 'all';
        }
        var year = $('#year').val();
        if (year=='') {
            year = 'all';
        }

        loadData(page, limit, month, year);
    });

    $('.act').on('change', function() {
        var limit = $('#limitData').val();
        var page = 1;
        var month = $('#month').val();
        if (month=='') {
            month = 'all';
        }
        var year = $('#year').val();
        if (year=='') {
            year = 'all';
        }
        loadData(page, limit, month, year);
    });

    $(document).on('click', '.btn-reset', function(){
        $('#month').val('');
        $('#year').val('');
        loadData(page, limit, month, year);
    });

    $(document).ready(function () {
        $(".btn-tambah").click(function () {
            $("#action_button").val("Add");
            $("#action").val("Add");
            $('#form_data')[0].reset();
            $("#formModal").modal("show");
        });
    });

    // Set the options that I want
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
        if($('#action').val() == 'Add')
        {
            $.ajax({
            url:"add-periode",
            method:"POST",
            data: new FormData(this),
            contentType: false,
            cache:false,
            processData: false,
            dataType:"json",
            beforeSend: function(){
                $('.anim').show();
                $("#action_button").prop("disabled", true);
            },
            success:function(data)
            {
                if(data.status==='success') {
                    toastr.success("Sukses <br> Data berhasil disimpan!");
                    location.reload();
                } else if(data.status==='exist') {
                    toastr.warning("Perhatian <br> Anda sudah membuat periode ini!");
                } else {
                   toastr.danger("Gagal <br> Data tidak berhasil disimpan!");
                }
            }
            })
        } 

        
    });

</script>
@endsection
