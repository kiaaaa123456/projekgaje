
@extends('backend.layouts.app')
@section('title', 'Periode Evkin')
@section('content')

	<div class="breadcrumb-warning d-flex justify-content-between ot-card">
    <div><h3>Periode Evkin</h3></div>
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb ot-breadcrumb ot-breadcrumb-basic">
            <li class="breadcrumb-item"><a href="{!!url('')!!}">Dashboard</a></li>
            <li class="breadcrumb-item active">Periode Evkin</li>
            
        </ol>
    </nav>
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
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="align-self-center d-flex flex-wrap gap-2">
                            <button class="btn-add btn-reset" style="background:red">Reset</button>
                        </div>
                        <div class="align-self-center">
                            <a role="button" class="btn-add btn-tambah" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Tambah Periode Evkin">
                                <span><i class="fa-solid fa-plus"></i> </span>
                                <span class="d-none d-xl-inline">Tambah Data</span>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
            <!-- toolbar table end -->
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="color:black">
                        <span class="mr-8">Filter Wilayah</span>
                    </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="table-toolbar d-flex flex-wrap gap-2 flex-xl-row justify-content-xxl-between align-content-center pb-3">
                            <!-- Provinsi -->
                            <div class="align-self-center">
                                <div class="search-box d-flex">
                                    <select class="form-select d-inline-block act" name="kodeprov" id="kodeprov">
                                        <option value="">Semua Provinsi</option>
                                        @foreach($provinsi as $prov)
                                        <option value="{{$prov->kdprov}}">{{$prov->nmprov}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- Kabupaten / Kota -->
                            <div class="align-self-center">
                                <div class="search-box d-flex">
                                    <select class="form-select d-inline-block act" name="kodekab" id="kodekab">
                                        <option value="">Semua Kabupaten</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Kecamatan-->
                            <div class="align-self-center">
                                <div class="search-box d-flex">
                                    <select class="form-select d-inline-block act" name="kodekec" id="kodekec">
                                        <option value="">Semua Kecamatan</option>
                                    </select>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <br><br>
            <!--  table start -->
            <div class="table-responsive" style="border:1px">
                <table class="table table-bordered" id="table-body">
                    <thead class="thead">
                        <tr>
                        	<th class="sorting_desc">No</th>
                            <th class="sorting_desc">Penilai</th>
                            <th class="sorting_desc">Peran</th>
                            <th class="sorting_desc">Bulan</th>
                            <th class="sorting_desc">Tahun</th>
                            <th class="sorting_desc">Provinsi</th>
                            <th class="sorting_desc">Kabupaten</th>
                            <th class="sorting_desc">Kecamatan</th>
                            <th class="sorting_desc">Status</th>
                            <th class="sorting_desc">Aksi</th>
                        </tr>
                    </thead>

                    <center><span class="loader"><i class="fa fa-spinner fa-3x fa-spin"></i></span></center>

                    <tbody class="tbody">
	                    <tr id="temp">
	                        <td colspan='10'>Loading Data..</td>
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

                            <center><span class="loader"><i class="fa fa-spinner fa-3x fa-spin"></i></span></center>

                            <div class="col-md-12">
                                <div class="float-right d-flex justify-content-end">
                                    <button type="submit" class="btn btn-success action-btn" id="action_button">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


<!-- <div class="modal fade lead-modal" id="formModal" aria-labelledby="modalLabel" aria-hidden="true">
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
</div> -->



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

    $('.loader').css("visibility", "hidden");

    $(document).ready(function () {
        $(".btn-tambah").click(function () {
            $("#action_button").val("Add");
            $("#action").val("Add");
            $('#form_data')[0].reset();
            $("#formModal").modal("show");
        });
    });
	
	var page  = 1;
    var limit  = 10;
    var month  = 'all';
    var year  = 'all';
    var kodeprov  = 'all';
    var kodekab  = 'all';
    var kodekec  = 'all';
    
    loadData(page, limit, month, year, kodeprov, kodekab,kodekec);

    $('.loader').css("visibility", "hidden");
    
    function loadData(page, limit, month, year, kodeprov, kodekab, kodekec){

        $.ajax({
        url: "periode-evkin-admin/"+page+"/"+limit+"/"+month+"/"+year+'/'+kodeprov+'/'+kodekab+'/'+kodekec,
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

                            if (response['data'][i].nmkab==null) {
                                var nmkab = '-';
                            } else {
                                var nmkab = response['data'][i].nmkab;
                            }
                            if (response['data'][i].nmkec==null) {
                                var nmkec = '-';
                            } else {
                                var nmkec = response['data'][i].nmkec;
                            }
                            if (response['data'][i].nmdesa==null) {
                                var nmdesa = '-';
                            } else {
                                var nmdesa = response['data'][i].nmdesa;
                            }

                            if(response['data'][i].status=='0') {
                                status = '<button class="btn btn-sm btn-warning">Proses Penilaian</button>';
                            } else if(response['data'][i].status=='1') {
                                status = '<button class="btn btn-sm btn-success">Selesai</button>';
                            }

                            var content = "<tr>" +
                            "<td>" + no++ + "</td>" +
                            "<td>" + response['data'][i].name+ "</td>" +
                            "<td>" + response['data'][i].title+ "</td>" +
                            "<td>" + month + "</td>" +
                            "<td>" + response['data'][i].tahun+ "</td>" +
                            "<td>" + response['data'][i].nmprov+ "</td>" +
                            "<td>" + nmkab+ "</td>" +
                            "<td>" + nmkec+ "</td>" +
                            "<td>" + status + "</td>" +
                            // "<td><a href='evkin-fasilitator/"+response['data'][i].id+"'><i class='fa fa-eye' style='cursor:pointer' title='Lihat Detail'></i></a>&nbsp;&nbsp;&nbsp;<i class='fa fa-edit' style='cursor:pointer' title='Edit Data'></i>&nbsp;&nbsp;&nbsp;<i class='fa fa-trash delete' style='cursor:pointer' title='Hapus Data' id='"+response['data'][i].id+"'></i></td>" +
                            "<td><a href='evkin-fasilitator/"+response['data'][i].id+"'><i class='fa fa-eye' style='cursor:pointer' title='Lihat Detail'></i></a>&nbsp;&nbsp;&nbsp;<i class='fa fa-trash delete' style='cursor:pointer' title='Hapus Data' id='"+response['data'][i].id+"'></i></td>" +
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
                       "<td colspan='10'>Belum ada data.</td>" +
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

    $('select[name="kodekab"]').on('change', function(){
        var id_kab = $(this).val();
        $('select[name="kodekec"]').empty();
        $('select[name="kodekec"]').append('<option value="">-Pilih Kecamatan-</option>');
        $('select[name="kodedesa"]').empty();
        $('select[name="kodedesa"]').append('<option value="">-Pilih Desa-</option>');
        if(id_kab) {
            $.ajax({
                url: 'get-kec/'+id_kab,
                type:"GET",
                dataType:"json",
                success:function(data) {
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
            $('select[name="kodedesa"]').empty();
        }
    });
   

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
        

        loadData(page, limit, month, year, kodeprov, kodekab, kodekec);
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
        
        loadData(page, limit, month, year, kodeprov, kodekab, kodekec);
    });

    $(document).on('click', '.btn-reset', function(){
        $('#month').val('');
        $('#year').val('');
        $('#kodeprov').val('');
        $('#kodekab').val('');
        $('#kodekec').val('');
        loadData(page, limit, month, year, kodeprov, kodekab, kodekec);
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
                $('.loader').css("visibility", "visible");
                $("#action_button").prop("disabled", true);
            },
            success:function(data)
            {
                if(data.status==='success') {
                    toastr.success("Sukses <br> Data berhasil disimpan!");
                    location.reload();
                } else if(data.status==='exist') {
                    toastr.warning("Perhatian <br> Anda sudah membuat periode ini!");
                    $('.loader').css("visibility", "hidden");
                    $("#action_button").prop("disabled", false);
                } else {
                    toastr.danger("Gagal <br> Data tidak berhasil disimpan!");
                    $('.loader').css("visibility", "hidden");
                    $("#action_button").prop("disabled", false);
                }
            }
            })
        } 

        
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
            url:"delete-evkin",
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

</script>
@endsection
