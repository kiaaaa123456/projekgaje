@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')
    {!! breadcrumb([
        'title' => @$data['title'],
        route('admin.dashboard') => _trans('common.Dashboard'),
        '#' => @$data['title'],
    ]) !!}

    <div class="card ot-card">
        <div class="card-body">
            <form method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">{{ _trans('common.Nama') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control ot-form-control ot-input"
                                    placeholder="{{ _trans('common.Name') }}" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                    <span class="error text-danger">
                                        {{ $errors->first('name') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">{{ _trans('common.Email') }} <span
                                        class="text-danger">*</span></label>
                                <input type="email" name="email" placeholder="{{ _trans('common.Email') }}"
                                    autocomplete="off" class="form-control ot-form-control ot-input"
                                    value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <span class="error text-danger">
                                        {{ $errors->first('email') }}
                                    </span>
                                @endif

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-20">
                                <label class="mb-10">{{ _trans('profile.Avatar') }}</label>
                                <div class="ot_fileUploader left-side mb-20">
                                    <input class="form-control ot-form-control ot-input" type="file" placeholder="{{ _trans('profile.Avatar') }}"
                                        name="backend_image" readonly="" id="placeholder3">
                                </div>
                                @if ($errors->has('avatar'))
                                <span class="text-danger">{{ $errors->first('avatar') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">{{ _trans('common.No Telepon') }} <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="phone" placeholder="{{ _trans('common.Phone') }}"
                                    autocomplete="off" class="form-control ot-form-control ot-input"
                                    value="{{ old('phone') }}">
                                @if ($errors->has('phone'))
                                    <div class="error text-danger">{{ $errors->first('phone') }}</div>
                                @endif
                            </div>
                        </div>
                        

                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="joining_date" class="form-label">{{ _trans('common.Tanggal Bergabung') }} <span
                                        class="text-danger">*</span></label>
                                <input type="date" name="joining_date" autocomplete="off"
                                    class="form-control ot-form-control ot-input" value="{{ old('joining_date') }}">
                                @if ($errors->has('joining_date'))
                                    <div class="error text-danger">{{ $errors->first('joining_date') }}</div>
                                @endif
                            </div>
                        </div>







                        

                        

                        
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="form-label" for="password"
                                    class="form-label">{{ _trans('common.Password') }} <span class="text-danger">*</span>
                                </label> <br>
                                <input type="radio" name="password_type" value="default" id="" checked> <span class="mr-4">{{ _trans('common.Default Password') }} (12345678)</span>
                                <input type="radio" name="password_type" value="custom" id=""> <span>{{ _trans('common.Custom Password') }}</span>
                            </div>
                        </div>

                        <div id="SelectionDiv" class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="form-label" for="password"
                                    class="form-label">{{ _trans('common.Password') }} <span class="text-danger">*</span>
                                    <span data-toggle="tooltip" data-placement="top"
                                        title="Leave the field blank to use the default password '12345678'"><i
                                            class="fa-solid fa-circle-info"></i></span></label>
                                <input type="text" name="password" placeholder="{{ _trans('common.Password') }}"
                                    autocomplete="off" class="form-control ot-form-control ot-input"
                                    value="{{ old('password') }}" id="password">
                                @if ($errors->has('password'))
                                    <div class="error text-danger">{{ $errors->first('password') }}</div>
                                @endif
                            </div>
                        </div>

                    </div>

                    <div class="col-md-6">
                        
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">{{ _trans('common.Unit') }} <span
                                        class="text-danger">*</span></label>
                                <select name="department_id" class="form-select select2">
                                    <option value="" disabled>{{ _trans('common.Choose One') }}
                                    </option>
                                    @foreach ($data['departments'] as $department)
                                        <option value="{{ $department->id }}">{{ $department->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>                        

                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">{{ _trans('common.Jenis Kelamin') }} <span
                                        class="text-danger">*</span></label>
                                <select name="gender"
                                    class="form-select demo-select2-placeholder {{ $errors->has('gender') ? 'is-invalid' : '' }} select2">
                                    <option disabled selected>{{ _trans('common.Pilih Jenis Kelamin') }}</option>
                                    <option value="0" {{ old('gender') == 0 ? 'selected' : '' }}>
                                        {{ _trans('common.Male') }}</option>
                                    <option value="1" {{ old('gender') == 1 ? 'selected' : '' }}>
                                        {{ _trans('common.Female') }}</option>
                                    <option value="2" {{ old('gender') == 2 ? 'selected' : '' }}>
                                        {{ _trans('common.Unisex') }}</option>
                                </select>
                                @if ($errors->has('gender'))
                                    <span class="error text-danger">
                                        {{ $errors->first('gender') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="form-label" for="name">{{ _trans('common.Alamat') }}</label>
                                <input type="text" name="address" placeholder={{ _trans('common.Address') }}
                                    autocomplete="off" class="form-control ot-form-control ot-input"
                                    value="{{ old('address') }}">
                                @if ($errors->has('address'))
                                    <div class="error text-danger">{{ $errors->first('address') }}</div>
                                @endif
                            </div>
                        </div>

                        

                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="form-label"
                                    for="marital_status">{{ _trans('common.Status') }}</label>
                                <select name="marital_status" id="marital_status" class="form-select select2">
                                    <option disabled selected>{{ _trans('common.Pilih Status') }}
                                    </option>
                                    <option value="Married" {{ old('marital_status') == 'Married' ? 'selected' : '' }}>
                                        {{ _trans('common.Married') }}</option>
                                    <option value="Unmarried"
                                        {{ old('marital_status') == 'Unmarried' ? 'selected' : '' }}>
                                        {{ _trans('common.Unmarried') }}</option>
                                </select>
                                @if ($errors->has('marital_status'))
                                    <div class="error text-danger">{{ $errors->first('marital_status') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="form-label" for="gender">{{ _trans('common.Tanggal Lahir') }}</label>
                                <input type="date" name="birth_date" autocomplete="off"
                                    class="form-control ot-form-control ot-input" value="{{ old('birth_date') }}">
                                @if ($errors->has('birth_date'))
                                    <div class="error text-danger">{{ $errors->first('birth_date') }}</div>
                                @endif
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-lg-12 ">
                        <div class="d-flex justify-content-end">
                            <div class="form-group mt-3 mb-3">
                                @if (hasPermission('user_create'))
                                    <button type="submit"
                                        class="btn btn-gradian mr-3">{{ _trans('common.Simpan') }}</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
    </div>

@endsection
@section('script')
    <script src="{{ url('backend/js/pages/__profile.js') }}"></script>

        <script>
    $(document).ready(function() {
        // Initially hide the role selection div
        $('#SelectionDiv').hide();

        // Attach an event listener to the radio buttons
        $('input[name="password_type"]').on('change', function() {
            if ($(this).val() === 'custom') {
                
                // If the 'custom' radio button is selected, show the role selection div
                $('#SelectionDiv').show();
            } else {
                // If the 'default' radio button is selected or other value, hide the  selection div
                $('#SelectionDiv').hide();
            }
        });
    });

    </script>

@endsection
