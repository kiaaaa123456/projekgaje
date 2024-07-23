
@extends('backend.layouts.app')
@section('title', 'Tidak Masuk Kerja')
@section('content')

    <div class="breadcrumb-warning d-flex justify-content-between ot-card">
    <div><h3>Tidak Masuk Kerja</h3></div>
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb ot-breadcrumb ot-breadcrumb-basic">
            <li class="breadcrumb-item"><a href="{!!url('dashboard')!!}">Dashboard</a></li>
            <li class="breadcrumb-item active">Tidak Masuk Kerja</li>
            
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
                                    <input class="form-control act" id="search" placeholder="Cari Nama Fasilitator" name="search" autocomplete="off">
                                    <span class="icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="align-self-center d-flex flex-wrap gap-2">
                            <!-- search -->
                            <div class="align-self-center">
                                <div class="search-box d-flex">
                                    <input class="form-control act" id="tanggal" placeholder="Tanggal Pengajuan" name="date" autocomplete="off" />
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
                            <!-- Desa-->
                            <div class="align-self-center">
                                <div class="search-box d-flex">
                                    <select class="form-select d-inline-block act" name="kodedesa" id="kodedesa">
                                        <option value="">Semua Desa</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <br><br>
            <!-- toolbar table end -->
            <!--  table start -->
            <div class="table-responsive" style="border:1px">
                <table class="table table-bordered" id="table-body">
                    <thead class="thead">
                        <tr>
                            <th class="sorting_desc">No</th>
                            <th class="sorting_desc">Nama</th>
                            <th class="sorting_desc">Jenis</th>
                            <th class="sorting_desc">Tgl Pengajuan</th>
                            <th class="sorting_desc">Tgl Cuti</th>
                            <th class="sorting_desc">Durasi </th>
                            <th class="sorting_desc">Alasan</th>
                            <th class="sorting_desc">File</th>
                            <th class="sorting_desc">Peran</th>
                            <th class="sorting_desc">Provinsi</th>
                            <th class="sorting_desc">Kabupaten</th>
                            <th class="sorting_desc">Kecamatan</th>
                            <th class="sorting_desc">Desa</th>
                            <th class="sorting_desc">Status</th>
                            <th class="sorting_desc">Aksi</th>
                        </tr>
                    </thead>

                    <center><span class="loader"><i class="fa fa-spinner fa-3x fa-spin"></i></span></center>

                    <tbody class="tbody">
                        <tr id="temp">
                            <td colspan='15'>Loading Data..</td>
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

<!-- <div id="formConfirm" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Tindaklanjuti Pengajuan</h5>
                <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="saveData">
                @csrf
                <div class="row">
                    <input type="hidden" name="hidden_id" id="hidden_id">
                    <div class="col-lg-12">
                        <div class="form-group mb-3">
                            <label for="" class="form-label">Pilih Status <span class="text-danger">*</span></label>
                            <select class="form-control" name="status" id="status" required>
                                <option value="">-Pilih Status-</option>
                                <option value="1">Setujui</option>
                                <option value="6">Tolak</option>
                                <option value="7">Batal</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="text-right d-flex justify-content-end">
                            <button class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div> -->

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
<script src="https://cdn.jsdelivr.net/gh/placemarker/jQuery-MD5@master/jquery.md5.js"></script>
<script type="text/javascript">
    
    var page  = 1;
    var limit  = 10;
    var search  = 'all';
    var date  = 'all';
    var kodeprov  = 'all';
    var kodekab  = 'all';
    var kodekec  = 'all';
    var kodedesa  = 'all';
    
    loadData(page, limit, search, date , kodeprov, kodekab, kodekec, kodedesa);

    $('.loader').css("visibility", "hidden");
    
    function loadData(page, limit, search, date, kodeprov, kodekab, kodekec, kodedesa){

        $.ajax({
        url: "tidak-masuk/"+page+'/'+limit+'/'+search+'/'+date+'/'+kodeprov+'/'+kodekab+'/'+kodekec+'/'+kodedesa,
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
                    

                    if(len > 0){
                        $(".tbody").empty();
                        // Load Data Table
                        for(var i=0; i<len; i++){

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

                            if (response['data'][i].stt==1) {
                                var status= "<button class='btn btn-sm btn-success'>Disetujui</button>";
                            } else if (response['data'][i].stt==2) {
                                var status= "<button class='btn btn-sm btn-warning'>Pengajuan</button>";
                            } else if (response['data'][i].stt==6) {
                                var status= "<button class='btn btn-sm btn-danger'>Ditolak</button>";
                            } else if (response['data'][i].stt==7) {
                                var status= "<button class='btn btn-sm btn-info'>Dibatalkan</button>";
                            } 

                            var button = "<a href='edit-tidak-masuk/"+ $.md5(response['data'][i].id_main)+"'><i class='fa fa-edit' style='cursor:pointer' title='Edit Pengajuan'></i></a>&nbsp;&nbsp; <i class='fa fa-trash delete' style='cursor:pointer' title='Hapus Data' id='"+response['data'][i].id_main+"'></i> ";

                            var content = "<tr>" +
                            "<td>" + no++ + "</td>" +
                            "<td>" + response['data'][i].nama+ "</td>" +
                            "<td>" + response['data'][i].name+ "</td>" +
                            "<td>" + response['data'][i].apply_date.split("-").reverse().join("-")+"</td>" +
                            "<td>" + response['data'][i].leave_from.split("-").reverse().join("-")+ " &nbsp;s/d <br>"+ response['data'][i].leave_to.split("-").reverse().join("-")+"</td>" +
                            "<td class='text-wrap'>" + response['data'][i].durasi+ " Hari</td>" +
                            "<td class='text-wrap'>" + response['data'][i].reason+ "</td>" +
                            "<td><a href='"+ response['data'][i].img_path+"' target='blank'><i class='fa fa-file' style='cursor:pointer'></i></a></td>" +
                            "<td>" + response['data'][i].peran+ "</td>" +
                            "<td>"+ response['data'][i].nmprov+"</td>" +
                            "<td>"+nmkab+"</td>" +
                            "<td>"+nmkec+"</td>" +
                            "<td>"+nmdesa+"</td>" +
                            "<td>"+status+"</td>" +
                            "<td>"+button+"</td>" +
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
                       "<td colspan='15'>Belum ada data.</td>" +
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

    $('select[name="kodekec"]').on('change', function(){
        var id_kec = $(this).val();
        $('select[name="kodedesa"]').empty();
        $('select[name="kodedesa"]').append('<option value="">-Pilih Desa-</option>')
        if(id_kec) {
            $.ajax({
                url: 'get-desa/'+id_kec,
                type:"GET",
                dataType:"json",
                success:function(data) {
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

    $(document).on("click", ".act-page", function () {
        var page = $(this).attr("id");
        var limit = $('#limitData').val();
        
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

        loadData(page, limit , date, kodeprov, kodekab, kodekec, kodedesa);
    });

    $('.act').on('change', function() {
        var limit = $('#limitData').val();
        var page = 1;
        
        var date = $('#tanggal').val();
        if (date=='') {
            date = 'all';
        }

        var search = $('#search').val();
        if (search=='') {
            search = 'all';
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

        loadData(page, limit , search, date, kodeprov, kodekab, kodekec, kodedesa);
    });

    $(document).on('click', '.btn-reset', function(){
        $('#search').val('');
        $('#tanggal').val('');
        $('#kodeprov').val('');
        $('#kodekab').val('');
        $('#kodekec').val('');
        $('#kodedesa').val('');
        loadData(page, limit, search, date,kodeprov, kodekab, kodekec, kodedesa);
    });

    $(document).on('click', '.data-action', function(){
        var id = $(this).attr('id');
        $('#form_result').html('');
        $.ajax({
        url:"get-data-tidakmasuk/"+id+"",
        dataType:"json",
        success:function(data){
        $('#hidden_id').val(data.data['0'].id);
        $('#action_button').val("Edit");
        $('#formConfirm').modal('show');
        $('.loader').css("visibility", "hidden");
        }
      })
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

    $('#saveData').on('submit', function(event){
        event.preventDefault();
        $.ajax({
            url:"update-status-pengajuan",
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType:"json",
            beforeSend: function(){
            $('.loader').css("visibility", "visible");
            },
            success:function(data)
            {
                if(data.status==='success') {
                    toastr.success("Sukses <br> Data berhasil disimpan!");
                    location.reload();
                }  else {
                   toastr.danger("Gagal <br> Data tidak berhasil disimpan!");
                   $("#action_button").prop("disabled", false);
                }
            },
        });
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
            url:"delete-tidak-masuk",
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
