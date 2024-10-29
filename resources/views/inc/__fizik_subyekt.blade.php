<input type="hidden" name="mijoz_turi" value="fizik">
<div class="row">
    <div class="col-xl-6">

        <div class="card">
            <div class="card-header">
                <h5>Subyekt Malumotlari</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="last_name" class="">@lang('cruds.client.fields.last_name')  <span style="color: pink">(*)</span></label>
                    <input class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}" type="text"
                        name="last_name" id="last_name" placeholder="@lang('cruds.client.fields.last_name')" value="{{ old('last_name') }}">
                    @if ($errors->has('last_name'))
                        <span class="error invalid-feedback">{{ $errors->first('last_name') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="name" class="">@lang('cruds.client.fields.name')  <span style="color: pink">(*)</span></label>
                    <input class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}" type="text"
                        name="first_name" id="first_name" placeholder="@lang('cruds.client.fields.first_name')"
                        value="{{ old('first_name') }}">
                    @if ($errors->has('first_name'))
                        <span class="error invalid-feedback">{{ $errors->first('first_name') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="father_name" class="col-md-6 my-2">@lang('cruds.client.fields.father_name')</label>
                    <input class="form-control {{ $errors->has('father_name') ? 'is-invalid' : '' }}" type="text"
                        name="father_name" id="father_name" placeholder="@lang('cruds.client.fields.father_name')"
                        value="{{ old('father_name') }}">
                    @if ($errors->has('father_name'))
                        <span class="error invalid-feedback">{{ $errors->first('father_name') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="birth_date" class="col-md-6 my-2">Tug'ilgan sanasi  <span style="color: pink">(*)</span></label>
                    <input class="form-control {{ $errors->has('birth_date') ? 'is-invalid' : '' }}" type="date"
                        name="birth_date" id="birth_date" placeholder="Tug'ilgan sanasi"
                        value="{{ old('birth_date') }}">
                    @if ($errors->has('birth_date'))
                        <span class="error invalid-feedback">{{ $errors->first('birth_date') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="contact" class="">@lang('cruds.client.fields.contact')  <span style="color: pink">(*)</span></label>
                    <input class="form-control phone2 {{ $errors->has('contact') ? 'is-invalid' : '' }}" type="text"
                        name="contact" id="contact" placeholder="+998 9999999"
                        value="{{ old('contact', '+998 ') }}" maxlength="14">
                    @if ($errors->has('contact'))
                        <span class="error invalid-feedback">{{ $errors->first('contact') }}</span>
                    @endif
                </div>
                
                <div class="mb-3">
                    <label for="contact2" class="">@lang('cruds.client.fields.contact') Qo'shimcha raqam</label>
                    <input class="form-control phone2" type="text"
                        name="contact2" id="contact2" placeholder="@lang('cruds.client.fields.contact')"
                        value="{{ old('contact2', '+998 ') }}" maxlength="14">
                    
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
                    <label for="stir" class="col-md-6 col-form-label">@lang('cruds.company.fields.stir')  <span style="color: pink">(*)</span></label>
                    <input class="form-control {{ $errors->has('stir') ? 'is-invalid' : '' }}" type="text"
                        name="stir" id="stir" placeholder="@lang('cruds.company.fields.stir')" value="{{ old('stir') }}"
                        maxlength="9">
                    @if ($errors->has('stir'))
                        <span class="error invalid-feedback">{{ $errors->first('stir') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="passport_pinfl" class="col-md-6 col-form-label">Shaxsiy raqami   <span style="color: pink">(*)</span></label>
                    <input class="form-control {{ $errors->has('passport_pinfl') ? 'is-invalid' : '' }}" type="text"
                        name="passport_pinfl" id="passport_pinfl" placeholder="Xujjat raqami"
                        value="{{ old('passport_pinfl') }}" maxlength="14">
                    @if ($errors->has('passport_pinfl'))
                        <span class="error invalid-feedback">{{ $errors->first('passport_pinfl') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">Shaxsni tasdiqlovchi xujjat turi  <span style="color: pink">(*)</span></label>
                    <select class="form-select" name="xujjat_turi_id">
                        @foreach ($xujjatTurlari as $xujjatTuri)
                        <option value="{{ $xujjatTuri->id }}"
                            {{ $xujjatTuri->id == 2 ? 'selected' : '' }}>
                            {{ $xujjatTuri->name }}
                        </option>                 
                        @endforeach

                      
                    </select>
                </div>
                <div class="mb-3">
                    <label for="passport_serial" class="col-md-6 col-form-label">Xujjat seriyasi  <span style="color: pink">(*)</span></label>
                    <input class="form-control {{ $errors->has('passport_serial') ? 'is-invalid' : '' }}"
                        type="text" name="passport_serial" id="passport_serial" placeholder="AC"
                        value="{{ old('passport_serial') }}" maxlength="2">
                    @if ($errors->has('passport_serial'))
                        <span class="error invalid-feedback">{{ $errors->first('passport_serial') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="passport_raqami" class="col-md-6 col-form-label">Xujjat raqami  <span style="color: pink">(*)</span></label>
                    <input class="form-control {{ $errors->has('passport_raqami') ? 'is-invalid' : '' }}"
                        type="text" name="passport_raqami" id="passport_raqami" placeholder="1234567"
                        value="{{ old('passport_raqami') }}" maxlength="7">
                    @if ($errors->has('passport_raqami'))
                        <span class="error invalid-feedback">{{ $errors->first('passport_raqami') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="passport_date" class="col-md-4 col-form-label">@lang('cruds.client.fields.passport_date')  <span style="color: pink">(*)</span></label>
                    <input class="form-control {{ $errors->has('passport_date') ? 'is-invalid' : '' }}"
                        type="date" name="passport_date" id="passport_date" placeholder="@lang('cruds.client.fields.passport_date')"
                        value="{{ old('passport_date') }}">
                    @if ($errors->has('passport_date'))
                        <span class="error invalid-feedback">{{ $errors->first('passport_date') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label class="form-label">Xujjat Berilgan joy  <span style="color: pink">(*)</span></label>
                    <select class="form-select" name="xujjat_berilgan_joyi_id">
                        @foreach ($xujjatBerilganJoyi as $xujjatBerilganJoy)
                            <option value="{{ $xujjatBerilganJoy->id }}">{{ $xujjatBerilganJoy->name }}</option>
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
