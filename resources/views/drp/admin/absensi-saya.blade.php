<?php
    if(Auth::user()->department_id == 7) {
        $fas = 'Absensi Kader';
        $wilayah = "".strtoupper($provinsi)." - ".strtoupper($kab)." - ".strtoupper($kec)."";
    } else if(Auth::user()->department_id == 6) {
        $fas = 'Absensi Fasdis';
        $wilayah = "".strtoupper($provinsi)." - ".strtoupper($kab)."";
    } else if(Auth::user()->department_id == 5) {
        $fas = 'Absensi Faskab';
        $wilayah = "".strtoupper($provinsi)."";
    } else if(Auth::user()->department_id == 8) {
        $wilayah = "".strtoupper($provinsi)." - ".strtoupper($kab)." - ".strtoupper($kec)." - ".strtoupper($desa)."";
    }
?>

@extends('backend.layouts.app')
@section('title', 'Absensi Saya')
@section('content')

	<div class="breadcrumb-warning d-flex justify-content-between ot-card">
    <div>
        <h3>Absensi Saya [{{Auth::user()->name}}]</h3>
          <i class="fa fa-map"></i> {{$wilayah}}
    </div>
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb ot-breadcrumb ot-breadcrumb-basic">
            <li class="breadcrumb-item"><a href="{!!url('dashboard')!!}">Dashboard</a></li>
            <li class="breadcrumb-item active">Absensi Saya</li>
            
        </ol>
    </nav>
</div>

@if(Auth::user()->department_id == 7 || Auth::user()->department_id == 6 || Auth::user()->department_id == 5)
<div class="d-flex justify-content-between flex-wrap dashboard-heading  align-items-center pb-24 gap-3">
    <h3 class="mb-0"></h3>
    <div class="dropdown card-button">
        <button class="btn btn-secondary ot-dropdown-btn dropdown-toggle" type="button" id="revenueBtn" data-bs-toggle="dropdown" aria-expanded="false" style="background:#385834">
            <span id="__selected_dashboard">Absensi Saya</span>
            <i class="las la-angle-down"></i>
        </button>
        <ul class="dropdown-menu c-dropdown-menu" aria-labelledby="revenueBtn">
            <li>
                <a class="dropdown-item profile_option" href="{!!url('absensi-saya')!!}"> Absensi Saya</a>
            </li>
            @if(Auth::user()->department_id == 7)
            <li>
                <a class="dropdown-item profile_option" href="{!!url('absensi-kader')!!}">Absensi Kader</a>
            </li>
            @elseif(Auth::user()->department_id == 6)
            <li>
                <a class="dropdown-item profile_option" href="{!!url('absensi-fasdis')!!}">Absensi Fasdis</a>
            </li>
            <li>
                <a class="dropdown-item profile_option" href="{!!url('absensi-kader')!!}">Absensi Kader</a>
            </li>
            @elseif(Auth::user()->department_id == 5)
            <li>
                <a class="dropdown-item profile_option" href="{!!url('absensi-faskab')!!}">Absensi Faskab</a>
            </li>
            <li>
                <a class="dropdown-item profile_option" href="{!!url('absensi-fasdis')!!}">Absensi Fasdis</a>
            </li>
            <li>
                <a class="dropdown-item profile_option" href="{!!url('absensi-kader')!!}">Absensi Kader</a>
            </li>
            @endif
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
                                    <option value="500">200</option>
                                </select>
                            </label>
                        </div>

                        <div class="align-self-center d-flex flex-wrap gap-2">
                            <!-- search -->
                            <div class="align-self-center">
                                <div class="search-box d-flex">
                                    <input class="form-control act" id="tanggal" placeholder="Tanggal" name="date" autocomplete="off" />
                                    <span class="icon"><i class="fa-solid fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="align-self-center d-flex flex-wrap gap-2">
                            <button class="btn-add btn-reset" style="background: red;">Reset</button>
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
                            <th class="sorting_desc">Nama</th>
                            <th class="sorting_desc">Tanggal</th>
                            <th class="sorting_desc">Peran</th>
                            <th class="sorting_desc">Masuk</th>
                            <th class="sorting_desc">Pulang</th>
                            <th class="sorting_desc">Durasi</th>
                        </tr>
                    </thead>

                    <tbody class="tbody">
	                    <tr id="temp">
	                        <td colspan='8'>Loading Data..</td>
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

            <div class="ot-pagination d-flex justify-content-end align-content-center">
                <p>Menampilkan <span id="from">0</span> data pada halaman <span id="hal">0</span> dari total <span id="total">0</span> data</small>
            </div>

        </div>
    </div>
</div>

@endsection
<!-- MODAL -->
    <div id="formConfirm" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">Hapus Data</h5>
                    <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" role="alert">
                    Apakah Anda ingin menghapus data ini ?
                    </div>
                    <form method="post" id="delete_form" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                        <input type="hidden" name="id_delete" id="id_delete" />
                        <center><span class="loader"><i class="fa fa-spinner fa-3x fa-spin"></i></span></center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect close-modal" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light" name="action_button" id="action_button">Iya</button>
                </div>
                </form>
                </div>
            </div>
        </div>
    </div>
<!---End Modal--->
@section('script')
<script type="text/javascript">
	
	var page  = 1;
    var limit  = 10;
    var date  = 'all';
    
    
    loadData(page, limit, date);
    
    function loadData(page, limit, date){

        $.ajax({
        url: "absensi-saya/"+page+'/'+limit+'/'+date,
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
                            
                            var checkin = response['data'][i].check_in;
                            var masuk = checkin.substr(10, 6);

                            if (response['data'][i].out_status=='CJ') {
                                var cj = "<span class='badge badge-warning ml-2' data-toggle='tooltip' data-placement='top' title='Absen pulang otomatis dari sistem'>CJ</span>";
                            } else {
                                var cj = '';
                            }

                            if(response['data'][i].check_out == null) {
                                var pulang = '';
                            } else {
                                var checkout = response['data'][i].check_out;
                                var check_out = checkout.substr(10, 6);
                                var pulang = "<span class='badge badge-danger'>" + check_out + "</span>&nbsp;&nbsp;<span class='badge badge-primary ml-2' data-toggle='tooltip' data-placement='top' title='"+ response['data'][i].check_out_location+"'> <i class='fa fa-map'></i> </span>&nbsp;&nbsp;"+cj+"";
                            }

                            x = response['data'][i].detik;
                            if (x > 28800) {
                                waktu = '8 jam 0 mnt 0 dtk';
                            } else {
                                y     = x % 3600;
                                jam   = x / 3600;
                                menit = y / 60;
                                detik = y % 60;
                                waktu = Math.floor(jam) + ' jam ' + Math.floor(menit) + ' mnt ' + Math.floor(detik) + ' dtk ';
                            }


                            var content = "<tr>" +
                            "<td>" + no++ + "</td>" +
                            "<td>" + response['data'][i].name+ "</td>" +
                            "<td>" + response['data'][i].date.split("-").reverse().join("-")+ "</td>" +
                            "<td>" + response['data'][i].title+ "</td>" +
                            "<td><span class='badge badge-success'>" + masuk + "</span>&nbsp;&nbsp;<span class='badge badge-primary ml-2' data-toggle='tooltip' data-placement='top' title='"+ response['data'][i].check_in_location+"'> <i class='fa fa-map'></i> </span></td>" +
                            "<td>"+ pulang+"</td>" +
                            "<td>"+ waktu+"</td>" +
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
                       "<td colspan='8'>Belum ada data.</td>" +
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
        var search = $('#search').val();
        if (search=='') {
            search = 'all';
        }
        var date = $('#tanggal').val();
        if (date=='') {
            date = 'all';
        }
        var kodeprov = $('#kodeprov').val();
        if (kodeprov=='') {
            kodeprov = 'all';
        }
        var kodekab = $('#kodekab').val();
        if (kodekab=='') {
            kodekab = 'all';
        }
        var kodekec = $('#kodekec').val();
        if (kodekec=='') {
            kodekec = 'all';
        }
        var kodedesa = $('#kodedesa').val();
        if (kodedesa=='') {
            kodedesa = 'all';
        }
        
        loadData(page, limit, date);
    });

     $('.act').on('change', function() {
        var limit = $('#limitData').val();
        var search = $('#search').val();
        if (search=='') {
            search = 'all';
        }
        var date = $('#tanggal').val();
        if (date=='') {
            date = 'all';
        }
        var kodeprov = $('#kodeprov').val();
        if (kodeprov=='') {
            kodeprov = 'all';
        }
        var kodekab = $('#kodekab').val();
        if (kodekab=='') {
            kodekab = 'all';
        }
        var kodekec = $('#kodekec').val();
        if (kodekec=='') {
            kodekec = 'all';
        }
        var kodedesa = $('#kodedesa').val();
        if (kodedesa=='') {
            kodedesa = 'all';
        }
        var page = 1;
        loadData(page,limit, date);
    });

    $(document).on('click', '.btn-reset', function(){
        $('#tanggal').val('');
        $('#search').val('');
        $('#kodeprov').val('');
        $('#kodekab').val('');
        $('#kodekec').val('');
        $('#kodedesa').val('');
        loadData(page, limit, date);
    });

    $(document).on('click', '.delete', function(){
        var id = $(this).attr('id');
        $('#id_delete').val(id);
        $('#formConfirm').modal('show');
        $('.loader').css("visibility", "hidden");
    });

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

    $('#delete_form').on('submit', function(event){
        event.preventDefault();
            $.ajax({
            url:"../delete-absensi",
            method:"POST",
            data: new FormData(this),
            contentType: false,
            cache:false,
            processData: false,
            dataType:"json",
            beforeSend: function(){
            $('.loader').css("visibility", "visible");
            },
            success:function(data)
            {
                if(data.status==='success') {
                    toastr.success("Sukses <br>Data berhasil dihapus!");
                    location.reload();
                    
                } else {
                    toastr.danger("Sukses <br>Data gagal dihapus!");
                }
            }
        })
            
    });

    $(document).on('click', '.close-modal', function(){
        $("#formConfirm").modal("hide"); 
    });

    //Filter Data
    $('select[name="kodeprov"]').on('change', function(){
        var id_prov = $(this).val();
        if(id_prov) {
            $.ajax({
                url: '../get-kab/'+id_prov,
                type:"GET",
                dataType:"json",
                success:function(data) {
                    $('select[name="kodekab"]').empty();
                    $('select[name="kodekab"]').append('<option value="">-Pilih Kabupaten-</option>')
                    for(var i = 0; i < data.kabupaten.length; i++) {
                        $('select[name="kodekab"]').append('<option value="'+data.kabupaten[i].kdkab+'">' + data.kabupaten[i].nmkab + '</option>');
                    }
                },
                complete: function(){
                    $('.loader').css("visibility", "hidden");
                }
            });
        } else {
            $('select[name="kodekab"]').empty();
        }
    });

    $('select[name="kodekab"]').on('change', function(){
        var id_kab = $(this).val();
        if(id_kab) {
            $.ajax({
                url: '../get-kec/'+id_kab,
                type:"GET",
                dataType:"json",
                success:function(data) {
                    $('select[name="kodekec"]').empty();
                    $('select[name="kodekec"]').append('<option value="">-Pilih Kecamatan-</option>')
                    for(var i = 0; i < data.kecamatan.length; i++) {
                        $('select[name="kodekec"]').append('<option value="'+data.kecamatan[i].kdkec+'">' + data.kecamatan[i].nmkec + '</option>');
                    }
                },
                complete: function(){
                    $('.loader').css("visibility", "hidden");
                }
            });
        } else {
            $('select[name="kodekec"]').empty();
        }
    });

    $('select[name="kodekec"]').on('change', function(){
        var id_kec = $(this).val();
        if(id_kec) {
            $.ajax({
                url: '../get-desa/'+id_kec,
                type:"GET",
                dataType:"json",
                success:function(data) {
                    $('select[name="kodedesa"]').empty();
                    $('select[name="kodedesa"]').append('<option value="">-Pilih Desa-</option>')
                    for(var i = 0; i < data.desa.length; i++) {
                        $('select[name="kodedesa"]').append('<option value="'+data.desa[i].kddesa+'">' + data.desa[i].nmdesa + '</option>');
                    }
                },
                complete: function(){
                    $('.loader').css("visibility", "hidden");
                }
            });
        } else {
            $('select[name="kodedesa"]').empty();
        }
    });

</script>
@endsection
