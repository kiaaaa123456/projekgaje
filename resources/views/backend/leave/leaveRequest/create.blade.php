@extends('backend.layouts.app')
@section('title', 'Input Data Tidak Masuk Kerja')
@section('content')
    {!! breadcrumb([
        'title' => 'Input Data Tidak Masuk Kerja',
        route('admin.dashboard') => _trans('common.Dashboard'),
        '#' => 'Input Data Tidak Masuk Kerja',
    ]) !!}
    <div class="table-content table-basic">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('leaveRequest.store') }}" class="" enctype="multipart/form-data">
                    @csrf
                    <input type="text" hidden value="{{ auth()->id() }}" name="user_id">
                    <div class="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ _trans('common.Jenis (Tidak Masuk Kerja)') }} <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control select2" name="assign_leave_id" required>
                                        <option value="" disabled selected>{{ _trans('common.Pilih Jenis') }}
                                        </option>
                                        @foreach ($data['leaveTypes'] as $type)
                                            <option value="{{ $type->id }}">{{ $type->type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ _trans('common.Pengganti') }}</label>
                                    <select name="substitute_id" class="form-control select2" id="user_id">

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ _trans('common.Durasi Tidak Masuk') }}<span
                                            class="text-danger">*</span></label>
                                    <input class="daterange-table-filter form-control" type="text" name="daterange"
                                        value="{{ date('m/d/Y') }}-{{ date('m/d/Y') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div>
                                    <label class="form-label">{{ _trans('common.Lampiran') }}</label>

                                    <div class="ot_fileUploader left-side mb-3">                                        
                                        <input type="file" class="form-control ot-form-control ot-input" name="file" placeholder="Lampiran" value="" required="">
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ _trans('common.Keterangan Tidak Masuk') }} <span
                                            class="text-danger">*</span></label>
                                    <textarea name="reason" class="form-control ot-input mt-0" placeholder="{{ _trans('common.Keterangan Tidak Masuk') }} " rows="6" required></textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-success ">{{ _trans('common.Ajukan') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <input type="hidden" id="get_user_url" value="{{ route('user.getUser') }}">
@endsection
