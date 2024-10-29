<input type="hidden" name="mijoz_turi" value="yuridik">
<div class="row">
    <div class="col-xl-6">

        <div class="card">
            <div class="card-header">
                <h5>Subyekt Malumotlari</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Subyektning tashkily shakli <span style="color: pink">(*)</span></label>
                    <select class="form-select" name="subyekt_shakli_id">

                        @foreach ($subyektShakli as $s)
                            @if ($s->code == 999)
                                <option value="{{ $s->id }}" selected>{{ $s->name }} /
                                    {{ $s->description ?? '' }}</option>
                            @else
                                <option value="{{ $s->id }}">{{ $s->name }} / {{ $s->description ?? '' }}
                                </option>
                            @endif
                        @endforeach

                    </select>
                </div>
                <div class="mb-3">
                    <label for="company_name" class="col-md-6 col-form-label">@lang('cruds.company.fields.company_name') <span style="color: pink">(*)</span></label>
                    <input class="form-control {{ $errors->has('company_name') ? 'is-invalid' : '' }}" type="text"
                        name="company_name" id="company_name" placeholder="@lang('cruds.company.fields.company_name')"
                        value="{{ old('company_name') }}">
                    @if ($errors->has('company_name'))
                        <span class="error invalid-feedback">{{ $errors->first('company_name') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="last_name" class="">@lang('cruds.client.fields.last_name') <span style="color: pink">(*)</span></label>
                    <input class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}" type="text"
                        name="last_name" id="last_name" placeholder="@lang('cruds.client.fields.last_name')" value="{{ old('last_name') }}">
                    @if ($errors->has('last_name'))
                        <span class="error invalid-feedback">{{ $errors->first('last_name') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="name" class="">@lang('cruds.client.fields.name') <span style="color: pink">(*)</span></label>
                    <input class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}" type="text"
                        name="first_name" id="first_name" placeholder="@lang('cruds.client.fields.first_name')"
                        value="{{ old('first_name') }}">
                    @if ($errors->has('first_name'))
                        <span class="error invalid-feedback">{{ $errors->first('first_name') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="father_name" class="col-md-6 my-2">@lang('cruds.client.fields.father_name') <span style="color: pink">(*)</span></label>
                    <input class="form-control {{ $errors->has('father_name') ? 'is-invalid' : '' }}" type="text"
                        name="father_name" id="father_name" placeholder="@lang('cruds.client.fields.father_name')"
                        value="{{ old('father_name') }}">
                    @if ($errors->has('father_name'))
                        <span class="error invalid-feedback">{{ $errors->first('father_name') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="contact" class="">@lang('cruds.client.fields.contact') <span style="color: pink">(*)</span></label>
                    <input class="form-control phone2 {{ $errors->has('contact') ? 'is-invalid' : '' }}" type="text"
                        name="contact" id="contact" placeholder="+998 9999999" value="{{ old('contact', '+998 ') }}"
                        maxlength="14">
                    @if ($errors->has('contact'))
                        <span class="error invalid-feedback">{{ $errors->first('contact') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="contact2" class="">@lang('cruds.client.fields.contact') Qo'shimcha raqam </label>
                    <input class="form-control phone2 {{ $errors->has('contact2') ? 'is-invalid' : '' }}"
                        type="text" name="contact2" id="contact2" placeholder="@lang('cruds.client.fields.contact2')"
                        value="{{ old('contact2', '+998 ') }}" maxlength="14">
                    @if ($errors->has('contact2'))
                        <span class="error invalid-feedback">{{ $errors->first('contact2') }}</span>
                    @endif
                </div>




                <div class="mb-3">
                    <label for="email" class="">@lang('cruds.client.fields.email')</label>
                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text"
                        name="email" id="email" placeholder="@lang('cruds.client.fields.email')" value="{{ old('email') }}">
                    @if ($errors->has('email'))
                        <span class="error invalid-feedback">{{ $errors->first('email') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="client_description" class="col-md-6 col-form-label">@lang('cruds.client.fields.client_description')</label>
                    <textarea id="textarea" name="client_description"
                        class="form-control {{ $errors->has('client_description') ? 'is-invalid' : '' }}" rows="3"
                        placeholder="This textarea has a limit of 225 chars.">{{ old('client_description') }}</textarea>
                    @if ($errors->has('client_description'))
                        <span class="error invalid-feedback">{{ $errors->first('client_description') }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-6">

        <div class="card">
            <div class="card-header">
                <h5>Xujjat Malumotlari</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="stir" class="col-md-6 col-form-label">@lang('cruds.company.fields.stir') <span style="color: pink">(*)</span></label>
                    <input class="form-control {{ $errors->has('stir') ? 'is-invalid' : '' }}" type="text"
                        name="stir" id="stir" placeholder="@lang('cruds.company.fields.stir')" value="{{ old('stir') }}"
                        maxlength="9">
                    @if ($errors->has('stir'))
                        <span class="error invalid-feedback">{{ $errors->first('stir') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="oked" class="col-md-6 col-form-label">@lang('cruds.company.fields.oked') <span style="color: pink">(*)</span></label>
                    <input class="form-control {{ $errors->has('oked') ? 'is-invalid' : '' }}" type="text"
                        name="oked" id="oked" placeholder="@lang('cruds.company.fields.oked')" value="{{ old('oked') }}"
                        maxlength="5">
                    @if ($errors->has('oked'))
                        <span class="error invalid-feedback">{{ $errors->first('oked') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label class="form-label">Банкни танланг <span style="color: pink">(*)</span></label>
                    <select class="form-select form-control" name="bank_id">
                        <option value="">Танланг</option>

                        @foreach ($bank as $b)
                            <option value="{{ $b->id }}">{{ $b->name }}</option>
                        @endforeach

                    </select>
                </div>

            </div>

        </div>
        @include('inc.__address')

    </div>
    <div class="col-sm-12" id="hide_me">
        <div class="card">
            <div class="card-body text-end btn-page">
                <button type="submit" class="btn btn-primary mb-0">Yuborish</button>
                {{-- <button class="btn btn-outline-secondary mb-0">Qaytadan</button> --}}
            </div>
        </div>
    </div>
    <!-- [ sample-page ] end -->
</div>
