@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">@lang('cruds.setting.about_company')</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: #007bff;">@lang('global.home')</a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('api-userIndex') }}"
                                style="color: #007bff;">@lang('cruds.setting.about_company')</a></li>
                        <li class="breadcrumb-item active">@lang('global.edit')</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- Main content -->


    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('global.edit')</h3>
                </div>

                <div class="card-body border-bottom">
                    <form id="myForm" action="{{ route('settingUpdate') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex align-items-end">
                            <div class="company_img">
                                @if ($about->image)
                                    <img id="previewImage" name="image"
                                        src="{{ url('/') }}/images/{{ $about->image }}" alt="about_company">
                                @else
                                    <img id="previewImage" name="image" src="{{ asset('assets/images/no-image.png') }}"
                                        alt="about_company">
                                @endif
                            </div>
                            <div class="d-flex">
                                <input class="form-control form-control-lg d-none" id="formFileLg" name="photo"
                                    type="file" accept="image/jpeg, image/png, image/gif">
                                <input type="hidden" name="delete_image">
                                <label for="formFileLg" id="uploadImage"
                                    class="btn btn-primary btn-hover w-100 rounded ms-2 mb-0 d-flex align-items-center">
                                    <i class="bx bx-cloud-upload" style="font-size: 16px;"></i>
                                    Upload
                                </label>
                                <button type="button" id="removeImage"
                                    class="btn btn-soft-danger btn-hover w-100 rounded ms-2 d-flex align-items-center">
                                    <i class="bx bxs-trash-alt" style="font-size: 16px;"></i>
                                    Delete
                                </button>
                            </div>
                        </div>
                        <hr>
                        <div class="form_inputs-box">
                            <div class="row">
                                @foreach (config('constants.locales') as $locale)
                                    <div class="col-12 col-lg-6 mb-2">
                                        <label>@lang('global.name_as') {{ $locale['title'] }}</label>
                                        <input type="text" name="name_{{ $locale['short_name'] }}" class="form-control"
                                            value="{{ old('name_' . $locale['short_name']) ?? $about->{'name_' . $locale['short_name']} }}"
                                            placeholder="Название" required>
                                    </div>
                                @endforeach

                                @foreach (config('constants.locales') as $locale)
                                    <div class="col-12 mb-2">
                                        <label>@lang('global.description_as') {{ $locale['title'] }}</label>
                                        <textarea id="textarea_{{ $locale['short_name'] }}" class="form-control"
                                            name="description_{{ $locale['short_name'] }}" maxlength="225" rows="3" placeholder="Описание ... " required>{{ old('description_' . $locale['short_name']) ?? $about->{'text_' . $locale['short_name']} }}</textarea>
                                    </div>
                                @endforeach

                                <!-- link 1 start -->
                                <div class="col-12 col-lg-6 mb-2">
                                    <label>Link name</label>
                                    <input type="text" name="link_name_1" class="form-control"
                                        value="{{ old('link_name_1', $about->link_name_1) }}" placeholder="Link name">
                                </div>
                                <div class="col-12 col-lg-6 mb-2">
                                    <label>Link</label>
                                    <input type="text" name="link_1" class="form-control"
                                        value="{{ old('link_1', $about->link_1) }}" placeholder="Link">
                                </div>
                                <!-- link 1 end -->

                                <!-- link 2 start -->
                                <div class="col-12 col-lg-6 mb-2">
                                    <label>Link name</label>
                                    <input type="text" name="link_name_2" class="form-control"
                                        value="{{ old('linl_name_2', $about->link_name_2) }}" placeholder="Link name">
                                </div>
                                <div class="col-12 col-lg-6 mb-2">
                                    <label>Link</label>
                                    <input type="text" name="link_2" class="form-control"
                                        value="{{ old('link_2', $about->link_2) }}" placeholder="Link">
                                </div>
                                <!-- link 2 end -->
                            </div>
                            <div class="form-group">
                                <button type="submit"
                                    class="btn btn-success waves-effect waves-light">@lang('global.save')</button>
                                <a href="{{ route('settingAbout') }}"
                                    class="btn btn-light waves-effect">@lang('global.cancel')</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#formFileLg').change(function() {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });

            $('#removeImage').click(function() {
                // Reset the preview image to the default image
                $('#previewImage').attr('src', '{{ asset('assets/images/no-image.png') }}');
                // Clear the file input field
                $('#formFileLg').val('');
                document.querySelector('input[name="delete_image"]').value = "true";
            });

            $('#submitForm').click(function() {
                var formData = new FormData($('#myForm')[0]);
                $.ajax({
                    url: "{{ route('settingUpdate') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Handle success response
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
