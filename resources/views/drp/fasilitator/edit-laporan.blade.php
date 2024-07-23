@extends('backend.layouts.app')
@section('title', 'Edit Laporan Bulanan')
@section('content')

	<div class="breadcrumb-warning d-flex justify-content-between ot-card">
    <div><h3>Edit Laporan Bulanan</h3></div>
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb ot-breadcrumb ot-breadcrumb-basic">
            <li class="breadcrumb-item"><a href="{!!url('dashboard')!!}">Dashboard</a></li>
            <li class="breadcrumb-item">Laporan Bulanan </li>
            <li class="breadcrumb-item active">Edit Laporan Bulanan</li>
            
        </ol>
    </nav>
</div>

<div class="table-content table-basic">
    <section class="card">
        <div class="card-body">
            <form id="saveData">
                @csrf
                <input type="hidden" name="hidden_id" value="{{$laporan['0']->id}}">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="" class="form-label">Tahun <span class="text-danger">*</span></label>
                            <!-- <select name="year" class="form-control ot-form-control ot-input" required="required" oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
                                <option value="" disabled selected>-Pilih Tahun-</option>
                                <option value="2024" @if($laporan['0']->year==2024) selected @endif>2024</option>
                            </select> -->
                            <input type="text" class="form-control" name="year" id="year" value="{{$laporan['0']->year}}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="" class="form-label">Bulan <span class="text-danger">*</span></label>
                            <!-- <select name="month" class="form-control ot-form-control ot-input" required="required" oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
                                <option value="" disabled selected>-Pilih Bulan-</option>
                                <option value="Januari"  @if($laporan['0']->month=='Januari') selected @endif>Januari</option>
                                <option value="Februari" @if($laporan['0']->month=='Februari') selected @endif>Februari</option>
                                <option value="Maret" @if($laporan['0']->month=='Maret') selected @endif>Maret</option>
                                <option value="April" @if($laporan['0']->month=='April') selected @endif>April</option>
                                <option value="Mei" @if($laporan['0']->month=='Mei') selected @endif>Mei</option>
                                <option value="Juni" @if($laporan['0']->month=='Juni') selected @endif>Juni</option>
                                <option value="Juli" @if($laporan['0']->month=='Juli') selected @endif>Juli</option>
                                <option value="Agustus" @if($laporan['0']->month=='Agustus') selected @endif>Agustus</option>
                                <option value="September" @if($laporan['0']->month=='September') selected @endif>September</option>
                                <option value="Oktober" @if($laporan['0']->month=='Oktober') selected @endif>Oktober</option>
                                <option value="November" @if($laporan['0']->month=='November') selected @endif>November</option>
                                <option value="Desember" @if($laporan['0']->month=='Desember') selected @endif>Desember</option>
                            </select> -->
                            <input type="text" class="form-control" name="month" id="month" value="{{$laporan['0']->month}}" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label" id="upload-label" for="appSettings_company_logo"> File Laporan  </label>
                            <div class="ot_fileUploader left-side mb-3">
                                <input class="form-control ot-form-control ot-input" type="file" placeholder="Description" name="file" id="file" oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" onchange="return validationFile()"/>
                            </div>
                        </div>
                        <p>File Anda Sekarang : <a target="_blank" href="{!!url(''.$laporan['0']->file.'')!!}"><i class="fa fa-file"></i></a></p>
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

                    @if(Auth::user()->department_id!=8)
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label" id="upload-label" for="appSettings_company_logo"> File Laporan Aktivitas Harian </label>
                            <div class="ot_fileUploader left-side mb-3">
                                <input class="form-control ot-form-control ot-input" type="file" placeholder="Description" name="file_ttdbasah" id="file_ttdbasah" oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" onchange="return validationFileTtd()"/>
                            </div>
                        </div>
                        <p>File Anda Sekarang : <a target="_blank" href="{!!url(''.$laporan['0']->file_ttdbasah.'')!!}"><i class="fa fa-file"></i></a></p>
                        <small>
                            Mohon mengupload file laporan aktivitas harian yang sudah ditandatangani basah.  <br>
                            File yang diizinkan jpg, jpeg, png, doc,docx, pdf, ppt, xls, xlsx.

                        </small>
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

    var type = "{{Auth::user()->is_admin}}";

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
        url:"../update-laporan-bulanan",
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
                if (type==0) {
                    window.location.href = '../laporan-bulanan-saya';
                } else {
                    window.location.href = '../laporan-bulanan';
                }
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
