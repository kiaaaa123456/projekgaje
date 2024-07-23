@extends('backend.layouts.app')
@section('title', 'Absensi Kader')
@section('content')

    <div class="breadcrumb-warning d-flex justify-content-between ot-card">
    <div>
        <h3>Absensi Kader</h3>
        <i class="fa fa-map"></i> Kabupaten {{$nmkab}}
    </div>
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb ot-breadcrumb ot-breadcrumb-basic">
            <li class="breadcrumb-item"><a href="{!!url('dashboard')!!}">Dashboard</a></li>
            <li class="breadcrumb-item active">Absensi Kader</li>
            
        </ol>
    </nav>
</div>


<div class="d-flex justify-content-between flex-wrap dashboard-heading  align-items-center pb-24 gap-3">
    <h3 class="mb-0"></h3>
    <div class="dropdown card-button">
        @if(Auth::user()->department_id==7)
        <button class="btn btn-secondary ot-dropdown-btn dropdown-toggle" type="button" id="revenueBtn" data-bs-toggle="dropdown" aria-expanded="false" style="background:#385834">
            <span id="__selected_dashboard">Absensi Fasdis</span>
            <i class="las la-angle-down"></i>
        </button>
        <ul class="dropdown-menu c-dropdown-menu" aria-labelledby="revenueBtn">
            <li>
                <a class="dropdown-item profile_option" href="{!!url('absensi-saya')!!}"> Absensi Saya</a>
            </li>
            <li>
                <a class="dropdown-item profile_option" href="{!!url('absensi-kader')!!}"> Absensi Kader</a>
            </li>
        </ul>
        @elseif(Auth::user()->department_id==6)
        <button class="btn btn-secondary ot-dropdown-btn dropdown-toggle" type="button" id="revenueBtn" data-bs-toggle="dropdown" aria-expanded="false" style="background:#385834">
            <span id="__selected_dashboard">Absensi Kader</span>
            <i class="las la-angle-down"></i>
        </button>
        <ul class="dropdown-menu c-dropdown-menu" aria-labelledby="revenueBtn">
            <li>
                <a class="dropdown-item profile_option" href="{!!url('absensi-saya')!!}"> Absensi Saya</a>
            </li>
            <li>
                <a class="dropdown-item profile_option" href="{!!url('absensi-fasdis')!!}"> Absensi Fasdis</a>
            </li>
            <li>
                <a class="dropdown-item profile_option" href="{!!url('absensi-kader')!!}"> Absensi Kader</a>
            </li>
        </ul>
        @elseif(Auth::user()->department_id==5)
        <button class="btn btn-secondary ot-dropdown-btn dropdown-toggle" type="button" id="revenueBtn" data-bs-toggle="dropdown" aria-expanded="false" style="background:#385834">
            <span id="__selected_dashboard">Absensi Kader</span>
            <i class="las la-angle-down"></i>
        </button>
        <ul class="dropdown-menu c-dropdown-menu" aria-labelledby="revenueBtn">
            <li>
                <a class="dropdown-item profile_option" href="{!!url('absensi-saya')!!}"> Absensi Saya</a>
            </li>
            <li>
                <a class="dropdown-item profile_option" href="{!!url('absensi-faskab')!!}"> Absensi Faskab</a>
            </li>
            <li>
                <a class="dropdown-item profile_option" href="{!!url('absensi-fasdis')!!}"> Absensi Fasdis</a>
            </li>
            <li>
                <a class="dropdown-item profile_option" href="{!!url('absensi-kader')!!}"> Absensi Kader</a>
            </li>
        </ul>
        @else
        <button class="btn btn-secondary ot-dropdown-btn dropdown-toggle" type="button" id="revenueBtn" data-bs-toggle="dropdown" aria-expanded="false" style="background:#385834">
            <span id="__selected_dashboard">Absensi Faskab</span>
            <i class="las la-angle-down"></i>
        </button>
        <ul class="dropdown-menu c-dropdown-menu" aria-labelledby="revenueBtn">
            <li>
                <a class="dropdown-item profile_option" href="{!!url('absensi-korkab')!!}"> Absensi Korkab</a>
            </li>
            <li>
                <a class="dropdown-item profile_option" href="{!!url('absensi-faskab')!!}"> Absensi Faskab</a>
            </li>
            <li>
                <a class="dropdown-item profile_option" href="{!!url('absensi-fasdis')!!}"> Absensi Fasdis</a>
            </li>
            <li>
                <a class="dropdown-item profile_option" href="{!!url('absensi-kader')!!}"> Absensi Kader</a>
            </li>
        </ul>
        @endif
    </div>
</div>


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
                            <div class="align-self-center">
                                <div class="search-box d-flex">
                                    <input class="form-control act" id="search" placeholder="Cari Nama Fasilitator" name="search" autocomplete="off" />
                                    <span class="icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                                </div>
                            </div>
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
                            <button class="btn-add btn-reset" style="background:red">Reset</button>
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
                            <th class="sorting_desc">Kecamatan</th>
                            <th class="sorting_desc">Desa</th>
                            <th class="sorting_desc">Masuk</th>
                            <th class="sorting_desc">Pulang</th>
                            <th class="sorting_desc">Durasi</th>
                        </tr>
                    </thead>

                    <center><span class="loader"><i class="fa fa-spinner fa-3x fa-spin"></i></span></center>

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
                                    <button type="submit" class="btn btn-gradian action-btn">Simpan</button>
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
    var date  = 'all';
    var search  = 'all';
    
    loadData(page, limit, search, date);

    $('.loader').css("visibility", "hidden");
    
    function loadData(page, limit, search, date){

        $.ajax({
        url: "absensi-kader/"+page+'/'+limit+'/'+search+'/'+date,
        type: 'get',
        dataType: 'json',

            beforeSend: function(){
                $('#table-body tbody').empty(); 
                $('.loader').css("visibility", "visible");
            },
            
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
                            "<td>" + response['data'][i].nmkec+ "</td>" +
                            "<td>" + response['data'][i].nmdesa+ "</td>" +
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
            },

            complete: function(){
                $('.loader').css("visibility", "hidden");
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
        loadData(page, limit, search, date);
    });

    $('.act').on('change', function() {
        var limit = $('#limitData').val();
        var page = 1;
        var search = $('#search').val();
        if (search=='') {
            search = 'all';
        }
        var date = $('#tanggal').val();
        if (date=='') {
            date = 'all';
        }
        loadData(page, limit, search, date);
    });

    $(document).on('click', '.btn-reset', function(){
        $('#tanggal').val('');
        $('#search').val('');
        $('#kodeprov').val('');
        $('#kodekab').val('');
        $('#kodekec').val('');
        $('#kodedesa').val('');
        loadData(page, limit, search, date);
    });

</script>
@endsection
