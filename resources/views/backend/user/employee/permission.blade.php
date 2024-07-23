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
            <form method="POST"
                action="{{ route('user.permission_update', $data['show']->id) }}"enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-content table-basic">
                            <div class="table-responsive">
                                <table class="table role-create-table role-permission " id="permissions-table">
                                    <thead class="thead">
                                        <tr>
                                            <th class="border-bottom-0" class="" scope="col">
                                                {{ _trans('common.Module') }}/
                                                {{ _trans('common.Sub Module') }}</th>
                                            <th class="border-bottom-0 text-right" scope="col">
                                                {{ _trans('common.Permissions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbody">
                                        {{-- @foreach ($data['permissions'] as $permission)
                                            <tr class="bg-transparent border-bottom-0">
                                                <td colspan="5" class="p-0 border-bottom-0">
                                                    <div class="accordion accordion-role mb-3">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#toggle-{{ $permission->id }}"
                                                                    aria-expanded="false"
                                                                    aria-controls="toggle-{{ $permission->id }}">
                                                                    <div class="input-check-radio">
                                                                        <div class="form-check">
                                                                            <input type="checkbox"
                                                                                class="form-check-input mt-0 read check_all outer-check-item"
                                                                                name="check_all" id="check_all">
                                                                            <label class="form-check-label ml-6"
                                                                                for="check_all">
                                                                                <span>
                                                                                    {{ Str::title(str_replace('_', ' ', __(@$permission->attribute))) }}
                                                                                </span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                            </h2>
                                                            <div id="toggle-{{ $permission->id }}"
                                                                class="accordion-collapse collapse">
                                                                <div class="accordion-body d-flex flex-wrap">
                                                                    @foreach ($permission->keywords as $key => $keyword)
                                                                        <div class="input-check-radio mr-16">
                                                                            <div class="form-check">
                                                                                @if ($keyword != '')
                                                                                    <input type="checkbox"
                                                                                        class="form-check-input mt-0 read inner-check-item"
                                                                                        id="{{ $keyword }}"
                                                                                        name="permissions[]"
                                                                                        value="{{ $keyword }}"
                                                                                        {{ in_array($keyword, @$data['show']->permissions) ? 'checked' : '' }}>
                                                                                    <label class="form-check-label ml-6"
                                                                                        for="{{ $keyword }}">{{ Str::title(str_replace('_', ' ', __($key))) }}</label>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach --}}
                                        @foreach ($data['permissions'] as $permission)
                                            <tr class="bg-transparent border-bottom-0">
                                                <td colspan="5" class="p-0 border-bottom-0">
                                                    <div class="accordion accordion-role mb-3">
                                                        <div class="accordion-item" id="accordion-{{ $permission->id }}">
                                                            <h2 class="accordion-header">
                                                                @php
                                                                    $allChecked = true;
                                                                @endphp
                                                                <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#toggle-{{ $permission->id }}"
                                                                    aria-expanded="false"
                                                                    aria-controls="toggle-{{ $permission->id }}">
                                                                    <div class="input-check-radio">
                                                                        <div class="form-check">
                                                                            @foreach ($permission->keywords as $key => $keyword)
                                                                                @php
                                                                                    $isChecked = in_array($keyword, @$data['show']->permissions);
                                                                                    if (!$isChecked) {
                                                                                        $allChecked = false;
                                                                                    }
                                                                                @endphp
                                                                            @endforeach
                                                                            <input type="checkbox"
                                                                                class="form-check-input mt-0 read check_all outer-check-item"
                                                                                name="check_all"
                                                                                id="check_all_{{ $permission->id }}"
                                                                                {{ $allChecked ? 'checked' : '' }}>
                                                                            <label class="form-check-label ml-6" for="check_all_{{ $permission->id }}">
                                                                                <span>
                                                                                    {{ Str::title(str_replace('_', ' ', __(@$permission->attribute))) }}
                                                                                </span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                            </h2>
                                                            <div id="toggle-{{ $permission->id }}" class="accordion-collapse collapse">
                                                                <div class="accordion-body d-flex flex-wrap">
                                                                    @foreach ($permission->keywords as $key => $keyword)
                                                                        <div class="input-check-radio mr-16">
                                                                            <div class="form-check">
                                                                                @if ($keyword != '')
                                                                                    <input type="checkbox"
                                                                                        class="form-check-input mt-0 read inner-check-item"
                                                                                        id="{{ $keyword }}"
                                                                                        name="permissions[]"
                                                                                        value="{{ $keyword }}"
                                                                                        {{ in_array($keyword, @$data['show']->permissions) ? 'checked' : '' }}>
                                                                                    <label class="form-check-label ml-6" for="{{ $keyword }}">
                                                                                        {{ Str::title(str_replace('_', ' ', __($key))) }}
                                                                                    </label>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-12">
                    <div class="col-md-12 text-right mt-3 mb-3 mr-5">
                        <div class="form-group d-flex justify-content-end">
                            @if (hasPermission('user_create'))
                                <button type="submit" class="btn btn-gradian">{{ _trans('common.Update') }}</button>
                            @endif
                        </div>
                    </div>
                </div>
        </div>
        </form>
    </div>
    </div>
@endsection
@section('script')
    <script src="{{ url('backend/js/pages/__profile.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Bind change event to inner checkboxes
            $('.inner-check-item').on('change', function() {
                var permissionId = $(this).closest('.accordion-item').attr('id').replace('accordion-', '');
                var accordionButton = $('#toggle-' + permissionId).prev('.accordion-header').find(
                    '.outer-check-item');

                // Check if all inner checkboxes are checked
                var allChecked = $(this).closest('.accordion-body').find('.inner-check-item:checked')
                    .length === $(this).closest('.accordion-body').find('.inner-check-item').length;

                // Update the state of the accordion button
                accordionButton.prop('checked', allChecked);
            });

            // Bind change event to outer checkboxes
            $('.outer-check-item').on('change', function() {
                var permissionId = $(this).attr('id').replace('check_all_', '');
                var accordionBody = $('#toggle-' + permissionId).find('.accordion-body');
                var innerCheckboxes = accordionBody.find('.inner-check-item');

                // Check/uncheck all inner checkboxes based on the state of the outer checkbox
                innerCheckboxes.prop('checked', $(this).is(':checked'));
            });
        });
    </script>
@endsection
