@extends('backend.layouts.app')
@section('title', 'Data Kecamatan')
@section('content')

	<div class="breadcrumb-warning d-flex justify-content-between ot-card">
    <div><h3>Daftar Kecamatan</h3></div>
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb ot-breadcrumb ot-breadcrumb-basic">
            <li class="breadcrumb-item"><a href="{!!url('dashboard')!!}">Dashboard</a></li>
            <li class="breadcrumb-item active">Daftar Kecamatan</li>
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
                                    <input class="form-control act" placeholder="Cari" name="search" id="search" autocomplete="off" />
                                    <span class="icon"><i class="fa-solid fa-magnifying-glass"></i></span>
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
                            <th class="sorting_desc">Nama Kabupaten</th>
                            <th class="sorting_desc">Nama Kecamatan</th>
                        </tr>
                    </thead>

                    <tbody class="tbody">
	                    <tr id="temp">
	                        <td colspan='3'>Loading Data..</td>
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
@section('script')
<script type="text/javascript">
	
	var page  = 1;
    var limit  = 10;
    var search  = 'all';
    
    loadData(page, limit, search);
    
    function loadData(page, limit, search){

        $.ajax({
        url: "get-kecamatan/"+page+'/'+limit+'/'+search,
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
                            
                            var content = "<tr>" +
                            "<td>" + no++ + "</td>" +
                            "<td>" + response['data'][i].nmkab + "</td>" +
                            "<td>" + response['data'][i].nmkec + "</td>" +
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
                       "<td colspan='3'>Belum ada data.</td>" +
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
            var search='all';
        }
        loadData(page, limit, search);
    });

    $('.act').on('change', function() {
        var limit = $('#limitData').val();
        var page = 1;
        var search = $('#search').val();
        if (search=='') {
            var search='all';
        }
        loadData(page, limit, search);
    });

    $(document).on('click', '.btn-reset', function(){
        $('#search').val('');;
        loadData(page, limit, search);
    });

</script>
@endsection
