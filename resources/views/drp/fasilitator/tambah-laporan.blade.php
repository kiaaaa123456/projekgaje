@extends('backend.layouts.app')
@section('title', 'Tambah Laporan Bulanan')
@section('content')

	<div class="breadcrumb-warning d-flex justify-content-between ot-card">
    <div><h3>Tambah Laporan Bulanan</h3></div>
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb ot-breadcrumb ot-breadcrumb-basic">
            <li class="breadcrumb-item"><a href="{!!url('dashboard')!!}">Dashboard</a></li>
            <li class="breadcrumb-item">Laporan Bulanan </li>
            <li class="breadcrumb-item active">Tambah Laporan Bulanan</li>
            
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
                            <label for="" class="form-label">Tahun <span class="text-danger">*</span></label>
                            <select name="year" class="form-control ot-form-control ot-input" required="required" oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
                                <option value="" disabled selected>-Pilih Tahun-</option>
                                <option value="2024">2024</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="" class="form-label">Bulan <span class="text-danger">*</span></label>
                            <select name="month" class="form-control ot-form-control ot-input" required="required" oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
                                <option value="" disabled selected>-Pilih Bulan-</option>
                                <option value="Januari">Januari</option>
                                <option value="Februari">Februari</option>
                                <option value="Maret">Maret</option>
                                <option value="April">April</option>
                                <option value="Mei">Mei</option>
                                <option value="Juni">Juni</option>
                                <option value="Juli">Juli</option>
                                <option value="Agustus">Agustus</option>
                                <option value="September">September</option>
                                <option value="Oktober">Oktober</option>
                                <option value="November">November</option>
                                <option value="Desember">Desember</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label" id="upload-label" for="appSettings_company_logo"> File Laporan <span class="text-danger">*</span> </label>
                            <div class="ot_fileUploader left-side mb-3">
                                <input class="form-control ot-form-control ot-input" type="file" placeholder="Description" name="file" id="file" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" onchange="return validationFile()"/>
                                <small>
                                    @if(Auth::user()->department_id==8)
                                    Mohon mengupload file laporan aktivitas harian yang sudah ditandatangani basah.
                                    @endif
                                                                        
                                    @if(Auth::user()->department_id==7)
                                    Untuk format laporan bulanan dapat Anda unduh melalui link 
                                    <a href="{!!url('download/laporan_bulanan_fasdis.xlsx')!!}">
                                        <u>berikut ini</u>
                                    </a>.
                                    @elseif(Auth::user()->department_id==6)
                                    Untuk format laporan bulanan dapat Anda unduh melalui link 
                                    <a href="{!!url('download/laporan_bulanan_faskab.xlsx')!!}">
                                        <u>berikut ini</u>
                                    </a>.
                                    @elseif(Auth::user()->department_id==5)
                                    Untuk format laporan bulanan dapat Anda unduh melalui link 
                                    <a href="{!!url('download/laporan_bulanan_korkab.xlsx')!!}">
                                        <u>berikut ini</u>
                                    </a>.
                                    @endif
                                    <br>
                                    File yang diizinkan jpg, jpeg, png, doc,docx, pdf, ppt, xls, xlsx.

                                </small>
                            </div>
                        </div>
                    </div>

                    @if(Auth::user()->department_id!=8)
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label" id="upload-label" for="appSettings_company_logo"> File Laporan Aktivitas Harian <span class="text-danger">*</span> </label>
                            <div class="ot_fileUploader left-side mb-3">
                                <input class="form-control ot-form-control ot-input" type="file" placeholder="Description" name="file_ttdbasah" id="file_ttdbasah" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" onchange="return validationFileTtd()"/>
                                <small>
                                    Mohon mengupload file laporan aktivitas harian yang sudah ditandatangani basah.  <br>                                  
                                    File yang diizinkan jpg, jpeg, png, doc,docx, pdf, ppt, xls, xlsx.

                                </small>
                            </div>
                        </div>
                    </div>
                    @endif

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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
        url:"simpan-laporan-bulanan",
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
                toastr.success("Sukses <br> Data berhasil disimpan.");
                window.location.href = 'laporan-bulanan-saya';
            } else if(data.status==='exist') {
                toastr.warning("Perhatian <br> Anda sudah membuat laporan pada bulan ini.");
                $('.loader').css("visibility", "hidden");
                $("#action_button").prop("disabled", false);
            } else {
               toastr.danger("Gagal <br> Data tidak berhasil disimpan.");
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

    function validationFileTtd() {
        var fileInput = document.getElementById('file_ttdbasah');
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
