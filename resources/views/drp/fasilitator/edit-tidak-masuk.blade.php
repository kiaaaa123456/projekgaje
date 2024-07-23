@extends('backend.layouts.app')
@section('title', 'Edit Tidak Masuk Kerja')
@section('content')

	<div class="breadcrumb-warning d-flex justify-content-between ot-card">
    <div><h3>Edit Tidak Masuk Kerja</h3></div>
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb ot-breadcrumb ot-breadcrumb-basic">
            <li class="breadcrumb-item"><a href="{!!url('dashboard')!!}">Dashboard</a></li>
            <li class="breadcrumb-item">Tidak Masuk Kerja </li>
            <li class="breadcrumb-item active">Edit Tidak Masuk Kerja</li>
            
        </ol>
    </nav>
</div>

<div class="table-content table-basic">
    <section class="card">
        <div class="card-body">
            <form id="saveData">
                @csrf
                <input type="hidden" name="hidden_id" value="{{$leave['0']->id}}">
                <input type="hidden" name="attachment_id" value="{{$leave['0']->attachment_file_id}}">
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
                                <option value="{{$row->assign_leaves_id}}" @if($leave['0']->assign_leave_id == $row->assign_leaves_id) selected @endif>{{$row->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input class="form-control ot-form-control ot-input" id="tanggal" name="leave_from" type="text"  placeholder="Pilih Tanggal Mulai" value="{{date('d-m-Y', strtotime($leave['0']->leave_from))}}" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="" class="form-label">Tanggal Berakhir <span class="text-danger">*</span></label>
                            <input class="form-control ot-form-control ot-input" id="tanggal_1" name="leave_to" type="text" readonly placeholder="Pilih Tanggal Berakhir" value="{{date('d-m-Y', strtotime($leave['0']->leave_to))}}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label" id="upload-label" for="appSettings_company_logo"> File Lampiran</label>
                            <div class="ot_fileUploader left-side mb-3">
                                <input class="form-control ot-form-control ot-input" type="file" placeholder="Description" name="file" id="file" oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" onchange="return validationFile()"/>
                                <small><i>File yang diizinkan jpg, jpeg, png, doc,docx, pdf, ppt, xls, xlsx</i></small>
                            </div>
                        </div>
                    </div>

                    

                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="" class="form-label">Status <span class="text-danger">*</span></label>
                            @if(Auth::user()->is_admin==0)
                            <select name="status_id" class="form-control ot-form-control ot-input" required="required" oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
                                <option value="" disabled >-Pilih Status-</option>
                                <option value="2" @if($leave['0']->status_id=='2') selected @endif>Pengajuan</option>
                                <option value="7" @if($leave['0']->status_id=='7') selected @endif>Batal</option>
                            </select>
                            @else
                            <select name="status_id" class="form-control ot-form-control ot-input" required="required" oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
                                <option value="" disabled >-Pilih Status-</option>
                                <option value="1" @if($leave['0']->status_id=='1') selected @endif>Setujui</option>
                                <option value="2" @if($leave['0']->status_id=='2') selected @endif>Pengajuan</option>
                                <option value="6" @if($leave['0']->status_id=='6') selected @endif>Tolak</option>
                                <option value="7" @if($leave['0']->status_id=='7') selected @endif>Batal</option>
                            </select>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group mb-3">
                            <label for="" class="form-label">Keterangan / Alasan <span class="text-danger">*</span></label>
                            

                            <textarea name="reason" id="reason" class="form-control mt-0 ot-input" placeholder="{{ _trans('common.Masukkan Keterangan Tidak Masuk Kerja') }}" rows="6" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')"> {!!$leave['0']->reason!!}</textarea>
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
        url:"../update-tidak-masuk",
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
                if (type==0) {
                    window.location.href = '../tidak-masuk-saya';
                } else {
                    window.location.href = '../tidak-masuk';
                }
                
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
