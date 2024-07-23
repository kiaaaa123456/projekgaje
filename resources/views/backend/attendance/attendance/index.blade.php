@extends('backend.layouts.app')
@section('title', @$data['title'])

@section('content')
    {!! breadcrumb([
        'title' => @$data['title'],
        route('admin.dashboard') => _trans('common.Dashboard'),
        '#' => @$data['title'],
    ]) !!}

    @if(Auth::user()->department_id == 15 || Auth::user()->department_id == 14 || Auth::user()->department_id == 13)
    <div class="d-flex justify-content-between flex-wrap dashboard-heading  align-items-center pb-24 gap-3">
        <h3 class="mb-0"></h3>
        <div class="dropdown card-button">
            <button class="btn btn-secondary ot-dropdown-btn dropdown-toggle" type="button" id="revenueBtn" data-bs-toggle="dropdown" aria-expanded="false" style="background:#385834">
                <span id="__selected_dashboard">Absensi Saya</span>
                <i class="las la-angle-down"></i>
            </button>
            <ul class="dropdown-menu c-dropdown-menu" aria-labelledby="revenueBtn">
                <li>
                    <a class="dropdown-item profile_option" href="{!!url('hrm/attendance')!!}"> Absensi Saya</a>
                </li>
                <li>
                    <a class="dropdown-item profile_option" href="{!!url('absensi-tim-saya')!!}">
                        @if(Auth::user()->department_id == 15)
                            Absensi Kader Desa
                        @elseif(Auth::user()->department_id == 14)
                            Absensi Fasilitator Kecamatan
                        @elseif(Auth::user()->department_id == 13)
                            Absensi Faskab
                        @else
                            Tim Saya
                        @endif
                    </a>
                </li>
            </ul>
        </div>
    </div>
    @endif 
    
    <div class="table-content table-basic">
        <div class="card">

            <div class="card-body">
                <!-- toolbar table start -->
                <div
                    class="table-toolbar d-flex flex-wrap gap-2 flex-xl-row justify-content-xxl-between align-content-center pb-3">
                    <div class="align-self-center">
                        <div class="d-flex flex-wrap gap-2  flex-lg-row justify-content-center align-content-center">
                            <!-- show per page -->
                            <div class="align-self-center">
                                <label>
                                    <span class="mr-8">{{ _trans('common.Tampil') }}</span>
                                    <select class="form-select d-inline-block" id="entries"
                                        onchange="attendanceDatatable()">
                                        @include('backend.partials.tableLimit')
                                    </select>
                                </label>
                            </div>



                            <div class="align-self-center d-flex flex-wrap gap-2">
                                <div class="align-self-center">
                                    <button type="button" class="btn-daterange" id="daterange" data-bs-toggle="tooltip"
                                        data-bs-placement="right" data-bs-title="{{ _trans('common.Date Range') }}">
                                        <span class="icon"><i class="fa-solid fa-calendar-days"></i>
                                        </span>
                                        <span class="d-none d-xl-inline">{{ _trans('common.Rentang Tanggal') }}</span>
                                    </button>
                                    <input type="hidden" id="daterange-input" onchange="attendanceDatatable()">
                                </div>
                                
                                <!-- search -->
                                <div class="align-self-center">
                                    <div class="search-box d-flex">
                                        <input class="form-control" placeholder="{{ _trans('common.Cari') }}"
                                            name="search" onkeyup="attendanceDatatable()" autocomplete="off">
                                        <span class="icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                                    </div>
                                </div>

                            </div>

                        </div>

                        
                    </div>
                    <!-- export -->
                    
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
                                                <select class="form-select d-inline-block" name="kodeprov" id="kodeprov" onchange="attendanceDatatable()">
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
                                                <select class="form-select d-inline-block" name="kodekab" id="kodekab" onchange="attendanceDatatable()">
                                                    <option value="">Semua Kabupaten</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- Kecamatan-->
                                        <div class="align-self-center">
                                            <div class="search-box d-flex">
                                                <select class="form-select d-inline-block" name="kodekec" id="kodekec" onchange="attendanceDatatable()">
                                                    <option value="">Semua Kecamatan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- Desa-->
                                        <div class="align-self-center">
                                            <div class="search-box d-flex">
                                                <select class="form-select d-inline-block" name="kodedesa" id="kodedesa" onchange="attendanceDatatable()">
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
                <div class="table-responsive">
                    @include('backend.partials.table')
                </div>
                <!--  table end -->
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
    @include('backend.partials.table_js')
    <script>
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
