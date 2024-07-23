@extends('backend.layouts.app')
@section('title', @$data['title'])

@section('content')
    {!! breadcrumb([
        'title' => @$data['title'],
        route('admin.dashboard') => _trans('common.Dashboard'),
        '#' => @$data['title'],
    ]) !!}
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
                                    <select class="form-select d-inline-block" id="entries" onchange="usersDatatable()">
                                        @include('backend.partials.tableLimit')
                                    </select>
                                    <!--<span class="ml-8">{{ _trans('common.Entries') }}</span>-->
                                </label>
                            </div>

                            <!-- Cari -->
                            <div class="align-self-center">
                                <div class="search-box d-flex">
                                    <input class="form-control" placeholder="{{ _trans('common.Cari') }}" name="search"
                                        onkeyup="usersDatatable()" autocomplete="off">
                                    <span class="icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- add btn -->
                    @if (hasPermission('user_create'))
                        <div class="align-self-center">
                            <a href="{{ route('user.create') }}" role="button" class="btn-add"
                                data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ _trans('common.Tambah Data Fasilitator') }}">
                                <span><i class="fa-solid fa-plus"></i> </span>
                                <span class="d-none d-xl-inline">{{ _trans('common.Tambah Data') }}</span>
                            </a>
                        </div>
                    @endif
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
                                        <select class="form-select d-inline-block" name="kodeprov" id="kodeprov" onchange="usersDatatable()">
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
                                        <select class="form-select d-inline-block" name="kodekab" id="kodekab" onchange="usersDatatable()">
                                            <option value="">Semua Kabupaten</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Kecamatan-->
                                <div class="align-self-center">
                                    <div class="search-box d-flex">
                                        <select class="form-select d-inline-block" name="kodekec" id="kodekec" onchange="usersDatatable()">
                                            <option value="">Semua Kecamatan</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Desa-->
                                <div class="align-self-center">
                                    <div class="search-box d-flex">
                                        <select class="form-select d-inline-block" name="kodedesa" id="kodedesa" onchange="usersDatatable()">
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

    <div class="modal fade lead-modal" id="formModal" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content data">
                <div class="modal-header mb-3" style="background:#dbfbd7 !important">
                    <h5 class="modal-title">Detail Fasilitator</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times text-white" aria-hidden="true"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" class="" enctype="multipart/form-data" id="form_data">
                        @csrf
                        <input type="hidden" name="action" id="action" />
                        <input type="hidden" name="id_user" id="hidden_id" />
                        <div class="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="name">NIK <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="nik" id="nik" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="name">Nama Fasilitator <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name" id="nama_fasilitator" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="name">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="email" id="email" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="name">Nomor Telepon <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="phone" id="phone" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="name">Peran <span class="text-danger">*</span></label>
                                        <select class="form-control" name="department_id" id="department_id" required>
                                            <option value="">-Pilih Peran-</option>
                                            @foreach($peran as $per)
                                            <option value="{{$per->id}}">{{$per->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="name">Provinsi <span class="text-danger">*</span></label>
                                        <select class="form-control" name="kdprov" id="kdprov" required>
                                            <option value="">-Pilih Provinsi-</option>
                                            @foreach($provinsi as $prov)
                                            <option value="{{$prov->kdprov}}">{{$prov->nmprov}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="name">Kabupaten <span class="text-danger">*</span></label>
                                        <select class="form-control" name="kdkab" id="kdkab" required>
                                            <option value="">-Pilih Kabupaten-</option>
                                            @foreach($kabupaten as $kab)
                                            <option value="{{$kab->kdkab}}">{{$kab->nmkab}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="name">Kecamatan <span class="text-danger">*</span></label>
                                        <select class="form-control" name="kdkec" id="kdkec" required>
                                            <option value="">-Pilih Kecamatan-</option>
                                            @foreach($kecamatan as $kec)
                                            <option value="{{$kec->kdkec}}">{{$kec->nmkec}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="name">Desa <span class="text-danger">*</span></label>
                                        <select class="form-control" name="kddesa" id="kddesa" required>
                                            <option value="">-Pilih Desa-</option>
                                            @foreach($desa as $des)
                                            <option value="{{$des->kddesa}}">{{$des->nmdesa}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="name">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <select class="form-control" name="gender" id="gender" required>
                                            <option value="">-Pilih Jenis Kelamin-</option>
                                            <option value="Laki-Laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="name">Alamat <span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="address" id="address" required></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="name">Password </label>
                                        <input type="password" class="form-control" name="password" id="password">
                                        <small>*) Jika fasilitator meminta bantuan ubah password, silakan diisi !</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="name">Ubah Status <span class="text-danger">*</span></label>
                                        <select class="form-control" name="status" id="status" required>
                                            <option value="0">Menunggu</option>
                                            <option value="4">Setujui</option>
                                            <option value="10">Tolak</option>
                                        </select>
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
                Apakah Anda ingin menghapus user ini ?
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
        $(document).on('click', '.edit', function(){
            var id = $(this).attr('id');
            $('#form_result').html('');
            $.ajax({
            url:"../../get-data-user/"+id+"",
            dataType:"json",
            success:function(data){
                
                if(data.data['0'].department_id=="1" || data.data['0'].department_id=="3" || data.data['0'].department_id=="4" || data.data['0'].department_id=="5" || data.data['0'].department_id=="8") {
                    
                    $('#kdprov').attr('required', false);
                    $('#kdkab').attr('required', false);
                    $('#kdkec').attr('required', false);
                    $('#kddesa').attr('required', false);
                    $('#hidden_id').val(data.data['0'].id_main);
                    $('#nik').val(data.data['0'].nik);
                    $('#nama_fasilitator').val(data.data['0'].name);
                    $('#department_id').val(data.data['0'].department_id);
                    $('#email').val(data.data['0'].email);
                    $('#gender').val(data.data['0'].gender);
                    $('#phone').val(data.data['0'].phone);
                    $('#status').val(data.data['0'].role_id);
                    $('#address').val(data.data['0'].address);
                    
                } else {

                    $('#hidden_id').val(data.data['0'].id_main);
                    $('#nik').val(data.data['0'].nik);
                    $('#nama_fasilitator').val(data.data['0'].name);
                    $('#department_id').val(data.data['0'].department_id);
                    $('#kdprov').val(data.data['0'].kdprov);
                    $('#kdkab').val(data.data['0'].kdkab);
                    $('#kdkec').val(data.data['0'].kdkec);
                    $('#kddesa').val(data.data['0'].kddesa);
                    $('#email').val(data.data['0'].email);
                    $('#gender').val(data.data['0'].gender);
                    $('#phone').val(data.data['0'].phone);
                    $('#status').val(data.data['0'].role_id);
                    $('#address').val(data.data['0'].address);

                    $.ajax({
                        url: '../get-kab/'+data.data['0'].kdprov,
                        type:"GET",
                        dataType:"json",
                        success:function(datakab) {
                            $('select[name="kdkab"]').empty();
                            for(var i = 0; i < datakab.kabupaten.length; i++) {
                                if(datakab.kabupaten[i].kdkab == data.data['0'].kdkab) {
                                    var select_val = 'selected';
                                } else {
                                    var select_val = '';
                                }
                                $('select[name="kdkab"]').append('<option value="'+datakab.kabupaten[i].kdkab+'" '+select_val+'>' + datakab.kabupaten[i].nmkab + '</option>');                            
                            }
                        }
                    });

                    $.ajax({
                        url: '../get-kec/'+data.data['0'].kdkab,
                        type:"GET",
                        dataType:"json",
                        success:function(datakec) {
                            $('select[name="kdkec"]').empty();
                            for(var i = 0; i < datakec.kecamatan.length; i++) {
                                if(datakec.kecamatan[i].kdkec == data.data['0'].kdkec) {
                                    var select_val = 'selected';
                                } else {
                                    var select_val = '';
                                }
                                $('select[name="kdkec"]').append('<option value="'+datakec.kecamatan[i].kdkec+'" '+select_val+'>' + datakec.kecamatan[i].nmkec + '</option>');
                            }
                        }
                    });

                    $.ajax({
                        url: '../get-desa/'+data.data['0'].kdkec,
                        type:"GET",
                        dataType:"json",
                        success:function(datadesa) {
                            $('select[name="kddesa"]').empty();
                            for(var i = 0; i < datadesa.desa.length; i++) {
                                if(datadesa.desa[i].kddesa == data.data['0'].kddesa) {
                                    var select_val = 'selected';
                                } else {
                                    var select_val = '';
                                }
                                $('select[name="kddesa"]').append('<option value="'+datadesa.desa[i].kddesa+'" '+select_val+'>' + datadesa.desa[i].nmdesa + '</option>');
                            }
                        }
                    });
                }

                


                $('#formModal').modal('show');
            }
          })
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
            $.ajax({
                url:"../../update-status-user",
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
                        toastr.success("Sukses <br>Data user berhasil diubah!");
                        location.reload();
                    } else {
                    toastr.danger("Gagal, ada kesalahan!");
                    }
                },
            });
            
        });

        $('select[name="kdprov"]').on('change', function(){
                var id_prov = $(this).val();
                if(id_prov) {
                    $.ajax({
                        url: '../get-kab/'+id_prov,
                        type:"GET",
                        dataType:"json",
                        success:function(data) {
                            $('select[name="kdkab"]').empty();
                            $('select[name="kdkab"]').append('<option value="">-Pilih Kabupaten-</option>')
                            for(var i = 0; i < data.kabupaten.length; i++) {
                                $('select[name="kdkab"]').append('<option value="'+data.kabupaten[i].kdkab+'">' + data.kabupaten[i].nmkab + '</option>');
                            }
                        },
                        complete: function(){
                            $('.loader').css("visibility", "hidden");
                        }
                    });
                } else {
                    $('select[name="kdkab"]').empty();
                }
            });

            $('select[name="kdkab"]').on('change', function(){
                var id_kab = $(this).val();
                if(id_kab) {
                    $.ajax({
                        url: '../get-kec/'+id_kab,
                        type:"GET",
                        dataType:"json",
                        success:function(data) {
                            $('select[name="kdkec"]').empty();
                            $('select[name="kdkec"]').append('<option value="">-Pilih Kecamatan-</option>')
                            for(var i = 0; i < data.kecamatan.length; i++) {
                                $('select[name="kdkec"]').append('<option value="'+data.kecamatan[i].kdkec+'">' + data.kecamatan[i].nmkec + '</option>');
                            }
                        },
                        complete: function(){
                            $('.loader').css("visibility", "hidden");
                        }
                    });
                } else {
                    $('select[name="kdkec"]').empty();
                }
            });

            $('select[name="kdkec"]').on('change', function(){
                var id_kec = $(this).val();
                if(id_kec) {
                    $.ajax({
                        url: '../get-desa/'+id_kec,
                        type:"GET",
                        dataType:"json",
                        success:function(data) {
                            $('select[name="kddesa"]').empty();
                            $('select[name="kddesa"]').append('<option value="">-Pilih Desa-</option>')
                            for(var i = 0; i < data.desa.length; i++) {
                                $('select[name="kddesa"]').append('<option value="'+data.desa[i].kddesa+'">' + data.desa[i].nmdesa + '</option>');
                            }
                        },
                        complete: function(){
                            $('.loader').css("visibility", "hidden");
                        }
                    });
                } else {
                    $('select[name="kddesa"]').empty();
                }
            });

            $(document).on('click', '.delete', function(){
                var id = $(this).attr('id');
                $('#id_delete').val(id);
                $('#formConfirm').modal('show');
                $('.loader').css("visibility", "hidden");
            });

            $('#delete_form').on('submit', function(event){
                event.preventDefault();
                $.ajax({
                    url:"../delete-user",
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
