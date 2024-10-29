<input type="hidden" name="mijoz_turi" value="fizik">

<div class="row">
    <div class="col-xl-6">

        <div class="card">
            <div class="card-header">
                <h5>Subyekt Malumotlari</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="last_name" class="">@lang('cruds.client.fields.last_name')</label>
                    <input class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}" type="text"
                        name="last_name" id="last_name" placeholder="@lang('cruds.client.fields.last_name')"
                        value="{{ old('last_name', $client->last_name) }}">
                    @if ($errors->has('last_name'))
                        <span class="error invalid-feedback">{{ $errors->first('last_name') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="name" class="">@lang('cruds.client.fields.name')</label>
                    <input class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}" type="text"
                        name="first_name" id="first_name" placeholder="@lang('cruds.client.fields.first_name')"
                        value="{{ old('first_name', $client->first_name) }}">
                    @if ($errors->has('first_name'))
                        <span class="error invalid-feedback">{{ $errors->first('first_name') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="father_name" class="col-md-6 my-2">@lang('cruds.client.fields.father_name')</label>
                    <input class="form-control {{ $errors->has('father_name') ? 'is-invalid' : '' }}" type="text"
                        name="father_name" id="father_name" placeholder="@lang('cruds.client.fields.father_name')"
                        value="{{ old('father_name', $client->father_name) }}">
                    @if ($errors->has('father_name'))
                        <span class="error invalid-feedback">{{ $errors->first('father_name') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="birth_date" class="col-md-6 my-2">Tug'ilgan sanasi</label>
                    <input class="form-control {{ $errors->has('birth_date') ? 'is-invalid' : '' }}" type="date"
                        name="birth_date" id="birth_date" placeholder="Tug'ilgan sanasi"
                        value="{{ old('birth_date', $client->birth_date->format('Y-m-d')) }}">
                    @if ($errors->has('birth_date'))
                        <span class="error invalid-feedback">{{ $errors->first('birth_date') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="contact" class="">@lang('cruds.client.fields.contact')</label>
                    <input class="form-control {{ $errors->has('contact') ? 'is-invalid' : '' }}" type="text"
                        name="contact" id="contact" placeholder="@lang('cruds.client.fields.contact')"
                        value="{{ old('contact', $client->contact) }}">
                    @if ($errors->has('contact'))
                        <span class="error invalid-feedback">{{ $errors->first('contact') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="contact2" class="">@lang('cruds.client.fields.contact')Qo'shimcha telefon</label>
                    <input class="form-control {{ $errors->has('contact2') ? 'is-invalid' : '' }}" type="text"
                        name="contact2" id="contact2" placeholder="@lang('cruds.client.fields.contact') telefon" 
                        value="{{ old('contact2', $client->contact2) }}">
                    @if ($errors->has('contact2'))
                        <span class="error invalid-feedback">{{ $errors->first('contact2') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="email" class="">@lang('cruds.client.fields.email')</label>
                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text"
                        name="email" id="email" placeholder="@lang('cruds.client.fields.email')"
                        value="{{ old('email', $client->email) }}">
                    @if ($errors->has('email'))
                        <span class="error invalid-feedback">{{ $errors->first('email') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="client_description" class="col-md-6 col-form-label">@lang('cruds.client.fields.client_description')</label>
                    <textarea id="textarea" name="client_description"
                        class="form-control {{ $errors->has('client_description') ? 'is-invalid' : '' }}" rows="3"
                        placeholder="This textarea has a limit of 225 chars.">{{ old('client_description', $client->client_description) }}</textarea>
                    @if ($errors->has('client_description'))
                        <span class="error invalid-feedback">{{ $errors->first('client_description') }}</span>
                    @endif
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5>Субъект манзили</h5>
                    </div>
                    <div class="card-body">

                        <div class="mb-3">
                            <p>
                                {{ $client->substreet && 
                                    $client->substreet->district && 
                                    $client->substreet->district->region
                                     ? $client->substreet->district->region->name_uz
                                     : 'N/A' }}
                                 {{ $client->substreet && 
                                    $client->substreet->district
                                     ? $client->substreet->district->name_uz
                                     : 'N/A' }}
                                 {{ $client->substreet && 
                                    $client->substreet->district && 
                                    $client->substreet->district->street
                                     ? $client->substreet->district->street->name
                                     : 'N/A' }}
                                 {{ $client->substreet 
                                     ? $client->substreet->name 
                                     : 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>

                @include('inc.__address')
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
                    <label for="stir" class="col-md-6 col-form-label">@lang('cruds.company.fields.stir')</label>
                    <input class="form-control {{ $errors->has('stir') ? 'is-invalid' : '' }}" type="number"
                        name="stir" id="stir" placeholder="@lang('cruds.company.fields.stir')"
                        value="{{ old('stir', $client->stir) }}" minlength="9" maxlength="9">
                    @if ($errors->has('stir'))
                        <span class="error invalid-feedback">{{ $errors->first('stir') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label class="form-label">Shaxsni tasdiqlovchi xujjat turi</label>
                    <select class="form-select" name="xujjat_turi_id">
                        @foreach ($xujjatTurlari as $xujjatTuri)
                            <option value="{{ $xujjatTuri->id }}"
                                {{ $xujjatTuri->id == old('xujjat_turi_id', $client->xujjat_turi_id) ? 'selected' : '' }}>
                                {{ $xujjatTuri->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="passport_serial" class="col-md-6 col-form-label">Xujjat seriyasi</label>
                    <input class="form-control {{ $errors->has('passport_serial') ? 'is-invalid' : '' }}"
                        type="text" name="passport_serial" id="passport_serial" placeholder="Xujjat seriyasi"
                        value="{{ old('passport_serial', $client->passport->passport_serial) }}">
                    @if ($errors->has('passport_serial'))
                        <span class="error invalid-feedback">{{ $errors->first('passport_serial') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="passport_raqami" class="col-md-6 col-form-label">Xujjat Raqami</label>
                    <input class="form-control {{ $errors->has('passport_raqami') ? 'is-invalid' : '' }}"
                        type="text" name="passport_raqami" id="passport_raqami" placeholder="Xujjat seriyasi"
                        value="{{ old('passport_raqami', $client->passport->passport_raqami) }}" >
                    @if ($errors->has('passport_raqami'))
                        <span class="error invalid-feedback">{{ $errors->first('passport_raqami') }}</span>
                    @endif
                </div>

              
                <div class="mb-3">
                    <label for="passport_pinfl" class="col-md-6 col-form-label">Xujjat raqami</label>
                    <input class="form-control {{ $errors->has('passport_pinfl') ? 'is-invalid' : '' }}"
                        type="number" name="passport_pinfl" id="passport_pinfl" placeholder="Xujjat raqami"
                        value="{{ old('passport_pinfl', $client->passport->passport_pinfl) }}" minlength="14" maxlength="14">
                    @if ($errors->has('passport_pinfl'))
                        <span class="error invalid-feedback">{{ $errors->first('passport_pinfl') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="passport_date" class="col-md-4 col-form-label">@lang('cruds.client.fields.passport_date')</label>
                    <input class="form-control {{ $errors->has('passport_date') ? 'is-invalid' : '' }}"
                        type="date" name="passport_date" id="passport_date" placeholder="@lang('cruds.client.fields.passport_date')"
                        value="{{ old('passport_date', $client->passport->passport_date->format('Y-m-d')) }}">
                    @if ($errors->has('passport_date'))
                        <span class="error invalid-feedback">{{ $errors->first('passport_date') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label class="form-label">Xujjat Berilgan joy</label>
                    <select class="form-select" name="xujjat_berilgan_joyi_id">
                        @foreach ($xujjatBerilganJoyi as $xujjatBerilganJoy)
                            <option value="{{ $xujjatBerilganJoy->id }}"
                                {{ $xujjatBerilganJoy->id == old('xujjat_berilgan_joyi_id', $client->xujjat_berilgan_joyi_id) ? 'selected' : '' }}>
                                {{ $xujjatBerilganJoy->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>

    </div>
    <div class="col-sm-12" id="hide_me">
        <div class="card">
            <div class="card-body text-end btn-page">
                {{-- <button class="btn btn-outline-secondary mb-0">Qaytadan</button> --}}
                <button type="submit" class="btn btn-primary mb-0">Yuborish</button>
            </div>
        </div>
    </div>
</div>
