@extends('backend.layouts.app')
@section('title', 'Tidak Masuk Kerja Korkab')
@section('content')

<div class="breadcrumb-warning d-flex justify-content-between ot-card">
    <div>
        <h3>Tidak Masuk Kerja Korkab</h3>
        <i class="fa fa-map"></i> Kabupaten {{$nmkab}}
    </div>
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb ot-breadcrumb ot-breadcrumb-basic">
            <li class="breadcrumb-item"><a href="{!!url('dashboard')!!}">Dashboard</a></li>
            <li class="breadcrumb-item active">Tidak Masuk Kerja Korkab</li>
            
        </ol>
    </nav>
</div>


<div class="d-flex justify-content-between flex-wrap dashboard-heading  align-items-center pb-24 gap-3">
    <h3 class="mb-0"></h3>
    <div class="dropdown card-button">
        <button class="btn btn-secondary ot-dropdown-btn dropdown-toggle" type="button" id="revenueBtn" data-bs-toggle="dropdown" aria-expanded="false" style="background:#385834">
            <span id="__selected_dashboard">Tidak Masuk Kerja Korkab</span>
            <i class="las la-angle-down"></i>
        </button>
        <ul class="dropdown-menu c-dropdown-menu" aria-labelledby="revenueBtn">
            <li>
                <a class="dropdown-item profile_option" href="{!!url('tidak-masuk-korkab')!!}"> Tidak Masuk Kerja Korkab</a>
            </li>
            <li>
                <a class="dropdown-item profile_option" href="{!!url('tidak-masuk-faskab')!!}"> Tidak Masuk Kerja Faskab</a>
            </li>
            <li>
                <a class="dropdown-item profile_option" href="{!!url('tidak-masuk-fasdis')!!}"> Tidak Masuk Kerja Fasdis</a>
            </li>
            <li>
                <a class="dropdown-item profile_option" href="{!!url('tidak-masuk-kader')!!}"> Tidak Masuk Kerja Kader</a>
            </li>
        </ul>
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

                       <!--  <div class="align-self-center d-flex flex-wrap gap-2">
                            <div class="align-self-center">
                                <div class="search-box d-flex">
                                    <input class="form-control act" id="search" placeholder="Cari Rencana/Realisasi" name="search" autocomplete="off" />
                                    <span class="icon"><i class="fa-solid fa fa-search"></i></span>
                                </div>
                            </div>
                        </div> -->

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
                            <th class="sorting_desc">Status</th>
                            <th class="sorting_desc">Aksi</th>
                        </tr>
                    </thead>

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

            <div class="ot-pagination d-flex justify-content-end align-content-center">
                <p>Menampilkan <span id="from">0</span> data pada halaman <span id="hal">0</span> dari total <span id="total">0</span> data</small>
            </div>

        </div>
    </div>
</div>


@endsection

<div id="formConfirm" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
</div>
@section('script')
<script type="text/javascript">
	
	var page  = 1;
    var limit  = 10;
    var date  = 'all';
    
    loadData(page, limit, date);
    
    function loadData(page, limit, date){

        $.ajax({
        url: "tidak-masuk-korkab/"+page+'/'+limit+'/'+date,
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

                            if (response['data'][i].stt==1) {
                                var status= "<button class='btn btn-sm btn-success'>Disetujui</button>";
                            } else if (response['data'][i].stt==2) {
                                var status= "<button class='btn btn-sm btn-warning'>Pengajuan</button>";
                            } else if (response['data'][i].stt==6) {
                                var status= "<button class='btn btn-sm btn-danger'>Ditolak</button>";
                            } else if (response['data'][i].stt==7) {
                                var status= "<button class='btn btn-sm btn-info'>Dibatalkan</button>";
                            } 

                            var content = "<tr>" +
                            "<td>" + no++ + "</td>" +
                            "<td>" + response['data'][i].nama+ "</td>" +
                            "<td>" + response['data'][i].name+ "</td>" +
                            "<td>" + response['data'][i].apply_date.split("-").reverse().join("-")+"</td>" +
                            "<td>" + response['data'][i].leave_from.split("-").reverse().join("-")+ " &nbsp;s/d <br>"+ response['data'][i].leave_to.split("-").reverse().join("-")+"</td>" +
                            "<td class='text-wrap'>" + response['data'][i].durasi+ " Hari</td>" +
                            "<td class='text-wrap'>" + response['data'][i].reason+ "</td>" +
                            "<td><a href='"+ response['data'][i].img_path+"' target='blank'><i class='fa fa-file' style='cursor:pointer'></i></a></td>" +
                            "<td>"+status+"</td>" +
                            "<td><i class='fa fa-edit data-action' id='"+ response['data'][i].id_main+"' style='cursor:pointer' title='Tindaklanjuti Pengajuan'></i></td>" +
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
                       "<td colspan='9'>Belum ada data.</td>" +
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
        
        var date = $('#tanggal').val();
        if (date=='') {
            date = 'all';
        }
        loadData(page, limit , date);
    });

    $('.act').on('change', function() {
        var limit = $('#limitData').val();
        var page = 1;
        
        var date = $('#tanggal').val();
        if (date=='') {
            date = 'all';
        }
        loadData(page, limit , date);
    });

    $(document).on('click', '.btn-reset', function(){
        $('#tanggal').val('');
        
        $('#kodeprov').val('');
        $('#kodekab').val('');
        $('#kodekec').val('');
        $('#kodedesa').val('');
        loadData(page, limit, date);
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

</script>
@endsection
