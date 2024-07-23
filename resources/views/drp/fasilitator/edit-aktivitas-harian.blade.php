@extends('backend.layouts.app')
@section('title', 'Edit Aktivitas Harian')
@section('content')

	<div class="breadcrumb-warning d-flex justify-content-between ot-card">
    <div><h3>Edit Aktivitas Harian</h3></div>
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb ot-breadcrumb ot-breadcrumb-basic">
            <li class="breadcrumb-item"><a href="{!!url('dashboard')!!}">Dashboard</a></li>
            <li class="breadcrumb-item">Aktivitas Harian </li>
            <li class="breadcrumb-item active">Edit Aktivitas Harian</li>
            
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
                        

                        <div class="row">
                            <div class="col-md-12">
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form method="POST" id="saveData">
                                    @csrf
                                    <input type="text" hidden value="{{ auth()->id() }}" name="user_id">
                                    <input type="text" hidden value="{!!$data['0']->id!!}" name="hidden_id">
                                    <input type="hidden"  value="1" name="appoinment_with">
                                    <div class="">
                                        <div class="row">
                                            
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="date"
                                                        class="form-label">{{ _trans('common.Tanggal') }} <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="date" id="date"
                                                        class="form-control ot-form-control ot-input" placeholder="{{ _trans('common.Date') }}" value="{{date('d-m-Y')}}" readonly>
                                                    @if ($errors->has('date'))
                                                        <div class="error">{{ $errors->first('date') }}</div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="location"
                                                        class="form-label">Lokasi<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="location" id="location" class="form-control ot-form-control ot-input" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="lat"
                                                        class="form-label">Latitude<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="latitude" id="lat" class="form-control ot-form-control ot-input" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="long"
                                                        class="form-label">Longitude<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="longitude" id="long" class="form-control ot-form-control ot-input" readonly>
                                                </div>
                                            </div>

                                            

                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="name">Rencana<span
                                                            class="text-danger">*</span></label>
                                                    <textarea name="title" class="form-control mt-0 ot-input" placeholder="{{ _trans('common.Masukkan Rencana Kegiatan') }}" rows="6" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">{!!$data['0']->title!!}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Realisasi<span
                                                            class="text-danger">*</span></label>
                                                    <textarea name="description" class="form-control mt-0 ot-input" placeholder="{{ _trans('common.Masukkan Realisasi Kegiatan') }}" rows="6" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">{!!$data['0']->description!!}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label for="#" class="form-label">Jam Mulai</label>
                                                    <input type="text" class="form-control ot-form-control ot-input"
                                                        name="appoinment_start_at" placeholder="{{ _trans('common.Jam Mulai') }}" value="{!!$data['0']->appoinment_start_at!!}"
                                                         oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
                                                    @if ($errors->has('appoinment_start_at'))
                                                        <div class="error">{{ $errors->first('appoinment_start_at') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label for="#" class="form-label">Jam Berakhir</label>
                                                    <input type="text" class="form-control ot-form-control ot-input"
                                                        name="appoinment_end_at" placeholder="{{ _trans('common.Jam Berakhir') }}" value="{!!$data['0']->appoinment_end_at!!}"  oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
                                                    @if ($errors->has('appoinment_end_at'))
                                                        <div class="error">{{ $errors->first('appoinment_end_at') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label for="#" class="form-label">Lampiran Kegiatan<span
                                                            class="text-danger">*</span></label>
                                                    <input type="file" class="form-control ot-form-control ot-input"
                                                        name="file" id="file" placeholder="{{ _trans('common.Lampiran Kegiatan') }}" value="{{ old('file') }}" oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" onchange="return validationFile()">
                                                    @if ($errors->has('file'))
                                                        <div class="error">{{ $errors->first('file') }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <p>File Anda Sekarang : <a target="_blank" href="{!!url(''.$data['0']->file.'')!!}"><i class="fa fa-file"></i></a></p>
                                                <small><i>File yang diizinkan jpg, jpeg, png, doc,docx, pdf, ppt, xls, xlsx</i></small>
                                            </div>

                                            <center><span class="loader"><i class="fa fa-spinner fa-3x fa-spin"></i></span></center>

                                            <div class="col-md-12 ">
                                                <div class=" float-right d-flex justify-content-end">
                                                    <button type="submit"
                                                        class="btn btn-success action-btn" id="action_button">Simpan</button>
                                                </div>
                                            </div>
                                </form>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <!-- toolbar table end -->


            

        </div>
    </div>
</div>



@endsection
@section('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALCRT0rEUbgVV9SfMqfyUvW3rZiTjTLqA&libraries=places"></script>
<script type="text/javascript">

    $('.loader').css("visibility", "hidden");

    var url_main = "{!!url('')!!}";
    var type = "{{Auth::user()->is_admin}}";

    let api_key = "the_key_you_get_from_your_account";
        $.getJSON("https://ipgeolocation.abstractapi.com/v1/?api_key=c3c3af51992545b5998dce0e992ffcda", function(data) {
        var loc_info = "Your location details :\n";
        loc_info += "Latitude: "+data.latitude +"\n";
        loc_info += "Longitude: "+data.longitude+"\n";
        loc_info += "Timezone: GMT"+data.gmt_offset+"\n";
        loc_info += "Country: "+data.country+"\n";
        loc_info += "Region: "+data.region+"\n";
        loc_info += "City: "+data.city+"\n";
        console.log(loc_info);
        $('#lat').val(data.latitude);
        $('#long').val(data.longitude);
        $('#location').val(''+data.city+', '+data.region+', '+data.country+'');
    })

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
        url:"../update-aktivitas-harian",
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
                    window.location.href = '../aktivitas-harian-saya';
                } else {
                    window.location.href = '../aktivitas-harian';
                }
            } else {
               toastr.error("Gagal <br> Data tidak berhasil disimpan!");
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
