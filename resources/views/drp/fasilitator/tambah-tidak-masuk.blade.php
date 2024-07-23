@extends('backend.layouts.app')
@section('title', 'Tambah Tidak Masuk Kerja')
@section('content')

	<div class="breadcrumb-warning d-flex justify-content-between ot-card">
    <div><h3>Tambah Tidak Masuk Kerja</h3></div>
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb ot-breadcrumb ot-breadcrumb-basic">
            <li class="breadcrumb-item"><a href="{!!url('dashboard')!!}">Dashboard</a></li>
            <li class="breadcrumb-item">Tidak Masuk Kerja </li>
            <li class="breadcrumb-item active">Tambah Tidak Masuk Kerja</li>
            
        </ol>
    </nav>
</div>

<div class="table-content table-basic">
    <section class="card">
        <div class="card-body">
            <form id="saveData">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="" class="form-label">Tanggal Pengajuan</label>
                            <input class="form-control ot-form-control ot-input" type="text" value="{{date('d-m-Y')}}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="" class="form-label">Jenis Tidak Masuk<span class="text-danger">*</span></label>
                            <select name="assign_leave_id" class="form-control ot-form-control ot-input" required="required" oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
                                <option value="" disabled selected>-Pilih Jenis Tidak Masuk-</option>
                                @foreach($data as $row)
                                <option value="{{$row->assign_leaves_id}}">{{$row->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="" class="form-label">Tanggal Mulai</label>
                            <input class="form-control ot-form-control ot-input" id="tanggal" name="leave_from" type="text"  placeholder="Pilih Tanggal Mulai">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="" class="form-label">Tanggal Berakhir</label>
                            <input class="form-control ot-form-control ot-input" id="tanggal_1" name="leave_to" type="text" readonly placeholder="Pilih Tanggal Berakhir">
                        </div>
                    </div>
                    <!-- <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="" class="form-label">Durasi Tidak Masuk <span class="text-danger">*</span></label>
                            <input class="daterange-table-filter form-control" type="text" name="daterange"
                                        value="" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
                        </div>
                    </div> -->

                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label class="form-label" id="upload-label" for="appSettings_company_logo"> File Lampiran <span class="text-danger">*</span> </label>
                            <div class="ot_fileUploader left-side mb-3">
                                <input class="form-control ot-form-control ot-input" type="file" placeholder="Description" name="file" id="file" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" onchange="return validationFile()"/>
                                <small><i>File yang diizinkan jpg, jpeg, png, doc,docx, pdf, ppt, xls, xlsx</i></small>
                            </div>

                        </div>

                    </div>

                    <div class="col-lg-12">
                        <div class="form-group mb-3">
                            <label for="" class="form-label">Keterangan / Alasan <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="reason" id="reason" rows="5" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')"></textarea>
                        </div>
                    </div>

                    <center><span class="loader"><i class="fa fa-spinner fa-3x fa-spin"></i></span></center>

                    <div class="col-md-12">
                        <div class="text-right d-flex justify-content-end">
                            <button class="btn btn-success" id="action_button">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>



@endsection
@section('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">
    
    $('.loader').css("visibility", "hidden");

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
        url:"simpan-tidak-masuk",
        method:"POST",
        data: new FormData(this),
        contentType: false,
        cache:false,
        processData: false,
        dataType:"json",
        beforeSend: function(){
            // $('.anim').show();
            $('.loader').css("visibility", "visible");
            $("#action_button").prop("disabled", true);
        },
        success:function(data)
        {
            if(data.status==='success') {
                toastr.success("Sukses <br> Data berhasil disimpan!");
                window.location.href = 'tidak-masuk-saya';
            } else if(data.status==='warning') {
                toastr.warning("Perhatian <br> Tanggal berakhir tidak boleh lebih besar dari tanggal mulai");
                $('.loader').css("visibility", "hidden");
                $("#action_button").prop("disabled", false);
            } else {
               toastr.danger("Gagal <br> Data tidak berhasil disimpan!");
               $('.loader').css("visibility", "hidden");
               $("#action_button").prop("disabled", false);
            }
        }
        })
    });

    function validationFile() {
        var fileInput = document.getElementById('file');
        var filePath = fileInput.value;
        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.pdf|\.doc|\.docx|\.ppt|\.xls|\.xlsx)$/i;
        if (!allowedExtensions.exec(filePath)) {
            toastr.error("Perhatian <br> Format file tidak diizinkan!");
            fileInput.value = '';
            return false;
        }
    }

</script>

@endsection
