@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')
    {!! breadcrumb([
        'title' => @$data['title'],
        route('admin.dashboard') => _trans('common.Dashboard'),
        '#' => @$data['title'],
    ]) !!}
    <div class="table-content table-basic">
        <!-- Main content -->
        <section class="card">
            <div class="card-body">
                <form action="{{ route('visit.store') }}" enctype="multipart/form-data" method="post"
                    id="attendanceForm">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="" class="form-label">{{ _trans('common.Tahun') }} <span
                                        class="text-danger">*</span></label>
                                <select name="year" class="form-control ot-form-control ot-input" required="required">
                                    <option value="" disabled selected>{{ _trans('common.Pilih Tahun') }}</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                </select>
                                @if ($errors->has('type_id'))
                                    <div class="error">{{ $errors->first('year') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="" class="form-label">{{ _trans('common.Bulan') }} <span
                                        class="text-danger">*</span></label>
                                <select name="month" class="form-control ot-form-control ot-input" required="required">
                                    <option value="" disabled selected>{{ _trans('common.Pilih Bulan') }}</option>
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
                                @if ($errors->has('type_id'))
                                    <div class="error">{{ $errors->first('month') }}</div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="form-label" id="upload-label" for="appSettings_company_logo">
                                    {{ _trans('common.File Laporan') }} <span
                                        class="text-danger">*</span>
                                </label>
                                <div class="ot_fileUploader left-side mb-3">
                                    <input class="form-control ot-form-control ot-input" type="file"
                                        placeholder="{{ _trans('common.Description') }}" name="file" required>
                                    <small>Untuk format laporan bulanan dapat Anda unduh melalui link 
                                    @if(Auth::user()->department_id=='15')
                                        <a href="https://www.sistemweb.my.id/download/format_laporan_bulanan_kec.docx"><u>berikut ini</u></a>.
                                    @elseif(Auth::user()->department_id=='14')
                                        <a href="https://www.sistemweb.my.id/download/format_laporan_bulanan.docx"><u>berikut ini</u></a>.
                                    @elseif(Auth::user()->department_id=='13')
                                        <a href="https://www.sistemweb.my.id/download/format_laporan_bulanan.docx"><u>berikut ini</u></a>.
                                    @endif
                                    </small>
                                </div>
                                @if ($errors->has('attachment_file'))
                                    <div class="invalid-feedback d-block">{{ $errors->first('attachment_file') }}</div>
                                @endif



                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="text-right d-flex justify-content-end">
                                <button class="btn btn-success ">{{ _trans('common.Simpan') }}</button>
                            </div>
                        </div>


                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
@section('script')
    <script src="{{ global_asset('frontend/assets/js/iziToast.js') }}"></script>
    <script src="{{ url('backend/js/image_preview.js') }}"></script>


    <script src="{{ global_asset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ global_asset('ckeditor/config.js') }}"></script>
    <script src="{{ global_asset('ckeditor/styles.js') }}"></script>
    <script src="{{ global_asset('ckeditor/build-config.js') }}"></script>
    <script src="{{ global_asset('backend/js/ticket_ckeditor.js') }}"></script>

@endsection
