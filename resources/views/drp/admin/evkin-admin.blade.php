@extends('backend.layouts.app')
@section('title', 'Evkin Fasilitator')
@section('content')

	<div class="breadcrumb-warning d-flex justify-content-between ot-card">
    <div>
        <h3>Evkin Fasilitator</h3>
        <i class="fa fa-user"></i> Penilai : {{$name}} ({{$peran}}) <br>
        @if($id_depart=='7')
        <i class="fa fa-map"></i> Wilayah :  {{$prov}} - {{$kab}} - {{$kec}}
        @elseif($id_depart=='6' || $id_depart=='5')
        <i class="fa fa-map"></i> Wilayah : {{$prov}} - {{$kab}}
        @endif
    </div>
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb ot-breadcrumb ot-breadcrumb-basic">
            <li class="breadcrumb-item"><a href="{!!url('dashboard')!!}">Dashboard</a></li>
            <li class="breadcrumb-item active">Daftar Bulan</li>
            <li class="breadcrumb-item active">Evkin Fasilitator</li>
            
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
                            <!-- search -->
                            <div class="align-self-center">
                                <div class="search-box d-flex">
                                    <input class="form-control act" placeholder="Cari Nama Fasilitator" name="search" id="search" autocomplete="off" />
                                    <span class="icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="align-self-center d-flex flex-wrap gap-2">
                            <button class="btn-add btn-tambah">Tambah Data</button>
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
                            <th class="sorting_desc">Peran</th>
                            <th class="sorting_desc">Nilai</th>
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
                    <input type="hidden" name="periode_id" id="periode_id" value="{{Request::segment(2)}}"/>
                    <div class="">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Fasilitator <span class="text-danger">*</span></label>
                                    <select class="form-control" name="id_user" id="id_user" required>
                                        <option value="">-Pilih Fasilitator-</option>
                                        @foreach($fasilitator as $row)
                                        <option value="{{$row->id}}">{{ucwords($row->name)}}</option>
                                        @endforeach
                                    </select>
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




@endsection
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
    var search  = 'all';
    var periode = "{{Request::segment(2)}}";
    var month = "{{$bulan}}";
    var year = "{{$tahun}}";
    var month_now = "{{date('m')}}";
    var year_now = "{{date('Y')}}";
    var month_dif = month_now - month;
    
    loadData(page, limit, periode, search);
    
    function loadData(page, limit, periode, search){

        $.ajax({
        url: "../get-evkin-fasilitator/"+page+"/"+limit+"/"+periode+"/"+search,
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

                            if(response['data'][i].department_id==5) {
                                unit = "Koordinator Kabupaten";
                            } else if(response['data'][i].department_id==6) {
                                unit = "Fasiltitator Kabupaten";
                            } else if(response['data'][i].department_id==7) {
                                unit = "Fasilitator Kecamatan";
                            } else if(response['data'][i].department_id==8) {
                                unit = "Kader Desa";
                            } else {
                                unit = "";
                            }

                            if (year == year_now) {
                                if (month_dif <= 1 ) {
                                    var button_edit = "<a href='../edit-nilai-fasilitator/"+periode+"/"+response['data'][i].user_id+"' class='btn btn-warning btn-sm'>Edit penilaian</a> "
                                } else {
                                    var button_edit = '';
                                }
                            }

                            if(response['data'][i].nilai==null) {
                                nilai = "<button class='btn btn-info btn-sm'>Belum dinilai</button>";
                                aksi = "<a href='../nilai-fasilitator/"+periode+"/"+response['data'][i].user_id+"'><i class='fa fa-edit' title='Beri Nilai Evkin'></i></a>&nbsp;&nbsp; <i class='fa fa-trash delete' data-id='"+response['data'][i].id_main+"' title='Hapus Data' style='cursor:pointer'></i>";
                            } else {
                                nilai = response['data'][i].nilai;
                                aksi = "<a href='../nilai-fasilitator/"+periode+"/"+response['data'][i].user_id+"' class='btn btn-success btn-sm'>Detail penilaian</a> " +button_edit+"&nbsp;&nbsp; <i class='fa fa-trash delete' data-id='"+response['data'][i].id_main+"' title='Hapus Data' style='cursor:pointer'></i>";
                            }
                            
                            var content = "<tr>" +
                            "<td>" + no++ + "</td>" +
                            "<td>" + response['data'][i].name + "</td>" +
                            "<td>"+ unit +"<br><small>"+ response['data'][i].wilayah +"</small></td>" +
                            "<td>" + nilai + "</td>" +
                            "<td>" + aksi + "</td>" +
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
        var search = $('#search').val();
        loadData(page, limit, periode, search);
    });

    $('.act').on('change', function() {
        var limit = $('#limitData').val();
        var page = 1;
        var search = $('#search').val();
        loadData(page, limit, periode, search);
    });

    $(document).on('click', '.btn-reset', function(){
        $('#search').val('');
        loadData(page, limit, periode, search);
    });


    $('#form_data').on('submit', function(event){
        event.preventDefault();
            $.ajax({
            url:"../add-fasilitator-evkin",
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
                } else {
                    toastr.danger("Gagal <br> Data tidak berhasil disimpan!");
                    $('.loader').css("visibility", "hidden");
                    $("#action_button").prop("disabled", false);
                }
            }
        })
    });

    $(document).on('click', '.close-modal', function(){
        $("#formConfirm").modal("hide"); 
    });

    $(document).on('click', '.delete', function(){
        var id = $(this).attr('data-id');
        $('#id_delete').val(id);
        $('#formConfirm').modal('show');
        $('.loader').css("visibility", "hidden");
    });

    $('#delete_form').on('submit', function(event){
        event.preventDefault();
            $.ajax({
            url:"../delete-fasilitator-evkin",
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

</script>
@endsection
