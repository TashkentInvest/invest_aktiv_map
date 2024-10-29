@extends('layouts.admin')

@section('content')
    <!-- Start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">@lang('cruds.construction.title')</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('construction.index') }}"
                                style="color: #007bff;">@lang('global.home')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('cruds.construction.title')</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- End page title -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="invoice-title">
                        <h4 class="float-end font-size-16">
                            {{-- @lang('global.contract_details') - {{ $b->contract_apt }} --}}

                        </h4>
                        <div class="mb-4">
                            <h3>@lang('global.contract_details')</h3>
                        </div>
                    </div>
                    <hr>

                    <div class="table-responsive">
                        <table class="table table-bordered dt-responsive w-100 table-nowrap" style="font-size: 16px;">
                            <tbody>
                                <tr>
                                    <td><strong>@lang('global.fio')</strong></td>
                                    <td colspan="2">{{ $construction->last_name }} {{ $construction->first_name }}
                                        {{ $construction->father_name }}</td>
                                </tr>
                                @if ($construction->mijoz_turi == 'fizik')
                                    <tr>
                                        <td><strong>{{ __('global.passport_pinfl') }}</strong></td>
                                        <td>{{ $construction->passport->passport_pinfl }}</td>
                                    </tr>

                                    <tr>
                                        <td><strong>{{ __('global.passport_serial') }}</strong></td>
                                        <td>{{ $construction->passport->passport_serial }}</td>
                                    </tr>

                                    <tr>
                                        @if ($construction->passport->passport_date)
                                            <td><strong>@lang('cruds.client.fields.passport_date')</strong></td>
                                            <td>{{ date('d-m-Y', strtotime($construction->passport->passport_date)) }}</td>
                                        @else
                                            <td><strong>@lang('cruds.client.fields.passport_date')</strong></td>
                                            <td></td>
                                        @endif
                                    </tr>

                                    <tr>
                                        <td><strong>@lang('cruds.client.fields.passport_location')</strong></td>
                                        <td>{{ $construction->passport->passport_location }}</td>
                                    </tr>

                                    <tr>
                                        <td><strong>@lang('global.home_address')</strong></td>
                                        <td colspan="2">{{ $construction->address->home_address }}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td><strong>@lang('cruds.client.fields.yuridik_address')</strong></td>
                                        <td colspan="2">{{ $construction->address->yuridik_address }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>@lang('cruds.company.fields.company_name')</strong></td>
                                        <td colspan="2">{{ $construction->company->company_name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>@lang('cruds.company.fields.oked')</strong></td>
                                        <td colspan="2">{{ $construction->company->oked }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>@lang('cruds.company.fields.raxbar')</strong></td>
                                        <td colspan="2">{{ $construction->company->raxbar }}</td>
                                    </tr>

                                    <tr>
                                        <td><strong>@lang('cruds.company.fields.bank_code')</strong></td>
                                        <td colspan="2">{{ $construction->company->bank_code }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>@lang('cruds.company.fields.bank_service')</strong></td>
                                        <td colspan="2">{{ $construction->company->bank_service }}</td>
                                    </tr>
                                @endif

                                <tr>
                                    <td><strong>@lang('cruds.company.fields.stir')</strong></td>
                                    <td colspan="2">{{ $construction->company->stir }}</td>
                                </tr>

                                @foreach ($construction->branches as $b)
                                        <tr>
                                            <td colspan="3" class="text-center bg-secondary text-light">
                                                <strong>@lang('global.contract_details') -
                                                    {{ $b->contract_apt }}</strong></td>
                                        </tr>

                                    <tr>
                                        <td><strong>@lang('cruds.branches.fields.apz_number')</strong></td>
                                        <td colspan="2">{{ $b->apz_raqami }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>@lang('cruds.branches.fields.apz_date')</strong></td>
                                        <td colspan="2">{{ $b->apz_sanasi }}</td>
                                    </tr>

                                    <tr>
                                        <td><strong>@lang('global.ruxsatnoma_raqami')</strong></td>
                                        <td colspan="2">{{ $b->contract_apt }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>@lang('global.created_at')</strong></td>
                                        <td colspan="2">{{ $b->contract_date }}</td>
                                    </tr>

                                    <tr>
                                        <td><strong>@lang('cruds.branches.fields.kengash')</strong></td>
                                        <td colspan="2">{{ $b->kengash }}</td>
                                    </tr>

                                    <tr>
                                        <td><strong>@lang('cruds.branches.fields.application_number')</strong></td>
                                        <td colspan="2">{{ $b->application_number }}</td>
                                    </tr>

                                    <tr>
                                        <td><strong>@lang('global.loyiha_nomi')</strong></td>
                                        <td colspan="2">{{ $b->branch_type }}</td>
                                    </tr>

                                    <tr>
                                        <td><strong>@lang('cruds.company.fields.branch_type')</strong></td>
                                        <td colspan="2">{{ $b->branch_type }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>@lang('cruds.company.fields.branch_location')</strong></td>
                                        <td colspan="2">{{ $b->branch_location }}</td>
                                    </tr>

                                    <tr>
                                        <td><strong>@lang('global.obyekt_boyicha_tolanishi_lozim') ( m³ )</strong></td>
                                        <td colspan="2">{{ number_format($b->branch_kubmetr, 1) }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>@lang('global.jami_tolanishi_kerak')</strong></td>
                                        <td colspan="2" class="formatted-number">{{ $b->generate_price }}</td>
                                    </tr>

                                    <tr>
                                        <td><strong>@lang('global.bolib_tolash_foizi_oldindan')</strong></td>
                                        <td colspan="2">{{ $b->percentage_input }}%</td>
                                    </tr>
                                    <tr>
                                        <td><strong>@lang('global.quarterly_payment')</strong></td>
                                        <td colspan="2">{{ $b->installment_quarterly }}</td>
                                    </tr>

                                    <tr>
                                        <td><strong>@lang('global.bolib_tolash')</strong></td>
                                        <td colspan="2">
                                            @if ($b->payment_type == 'pay_bolib')
                                                @lang('global.pay_bolib')
                                            @else
                                                @lang('global.pay_full')
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><strong>@lang('cruds.branches.fields.payed_sum')</strong></td>
                                        <td colspan="2" class="formatted-number">{{ $b->payed_sum }}</td>
                                    </tr>

                                    <tr>
                                        <td><strong>@lang('cruds.branches.fields.payed_date')</strong></td>
                                        <td colspan="2">{{ $b->payed_date }}</td>
                                    </tr>

                                    <tr>
                                        <td><strong>@lang('cruds.branches.fields.notification_num')</strong></td>
                                        <td colspan="2">{{ $b->notification_num }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>@lang('cruds.branches.fields.notification_date')</strong></td>
                                        <td colspan="2">{{ $b->notification_date }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>@lang('cruds.branches.fields.insurance_policy')</strong></td>
                                        <td colspan="2">{{ $b->insurance_policy }}</td>
                                    </tr>

                                    <tr>
                                        <td><strong>@lang('cruds.branches.fields.bank_guarantee')</strong></td>
                                        <td colspan="2">{{ $b->bank_guarantee }}</td>
                                    </tr>
                                @endforeach


                                <script>
                                    function formatNumberWithSpaces(number) {
                                        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
                                    }

                                    document.addEventListener('DOMContentLoaded', function() {
                                        var elements = document.querySelectorAll('.formatted-number');
                                        elements.forEach(function(element) {
                                            element.textContent = formatNumberWithSpaces(element.textContent);
                                        });
                                    });
                                </script>
                            </tbody>
                        </table>
                    </div>


                    <h4>Pinned payment file</h4>
                    @foreach ($construction->files as $file)
                    @if (preg_match('/^assets\/payment\/.+$/', $file->path))
                        <div class="py-1">
                            <a target="_blank" class="py-2 my-2" href="{{ asset($file->path) }}">{{ $file->path }}</a>
                        </div>


                    @endif
                @endforeach
                

                    <!-- Viewers Section -->
                    <div class="mt-5 px-3">
                        <h5>@lang('cruds.construction.fields.viewers'): </h5>
                        @php $viewCount = 0; @endphp
                        @foreach ($construction->branches as $b)
                            @foreach ($b->views as $key => $v)
                                @if ($v)
                                    @php $viewCount++; @endphp
                                    <div class="d-flex py-3 border-bottom">
                                        <div class="px-3 flex-grow-1">
                                            {{-- <h4>{{$key+1}} ) </h4> --}}
                                            <h4 class="mb-1 font-size-15"><i class="far fa-user text-primary me-1"></i>
                                                {{ $v->user->name }}</h4>
                                            <p class="text-muted"><i class="far fa-envelope text-primary me-1"></i>
                                                {{ $v->user->email }}</p>
                                            <div class="text-muted font-size-12"><i
                                                    class="far fa-calendar-alt text-primary me-1"></i> {{ $v->updated_at }}
                                                ({{ $v->updated_at->diffForHumans() }})
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endforeach
                        <div class="mt-3">
                            <h5>@lang('cruds.construction.fields.views_count'): {{ $viewCount }}</h5>
                        </div>
                    </div>

                    <!-- Edit Button -->
                    <div class="d-print-none mt-4">
                        <div class="float-end">
                            <a href="javascript:window.print()" class="btn btn btn-success waves-effect waves-light me-1"><i
                                    class="fa fa-print"></i></a>
                            <button type="button" data-bs-toggle="modal"
                                data-bs-target="#exampleModal_{{ $construction->id }}"
                                class="btn btn-primary">@lang('global.edit')</button>
                        </div>
                    </div>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="exampleModal_{{ $construction->id }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                        {{ $construction->{'name_' . app()->getLocale()} }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('construction.update', $construction->id) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        @foreach ($construction->branches as $branchIndex => $b)
                                        <tr>
                                            <td colspan="3" class="text-center bg-secondary text-light">
                                                <strong>@lang('global.contract_details') -
                                                    {{ $b->contract_apt }}</strong></td>
                                        </tr>
                                            <input type="hidden" name="accordions[{{ $branchIndex }}][id]"
                                                value="{{ $b->id }}">

                                            <div class="row">
                                                <div class="col-lg-6 mb-3">
                                                    <label for="projectname"
                                                        class="col-form-label">@lang('cruds.branches.fields.apz_number')</label>
                                                    <input id="projectname"
                                                        name="accordions[{{ $branchIndex }}][apz_raqami]" type="text"
                                                        class="form-control"
                                                        value="{{ old('accordions.' . $branchIndex . '.apz_raqami', $b->apz_raqami) }}"
                                                        placeholder="@lang('cruds.branches.fields.apz_number')">
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <label for="projectname"
                                                        class="col-form-label">@lang('cruds.branches.fields.apz_date')</label>
                                                    <input id="projectname"
                                                        name="accordions[{{ $branchIndex }}][apz_sanasi]" type="date"
                                                        class="form-control"
                                                        value="{{ old('accordions.' . $branchIndex . '.apz_sanasi', $b->apz_sanasi) }}"
                                                        placeholder="@lang('cruds.branches.fields.apz_date')">
                                                </div>

                                                @if(auth()->user()->roles[0]->name != 'Qurilish')
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="contract_apt">@lang('global.ruxsatnoma_raqami')</label>
                                                        <input type="text" class="form-control"
                                                            name="accordions[{{ $branchIndex }}][contract_apt]"
                                                            value="{{ old('accordions.' . $branchIndex . '.contract_apt', $b->contract_apt) }}"
                                                            placeholder="@lang('global.ruxsatnoma_raqami')">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="contract_date">@lang('global.sanasi')</label>
                                                        <input class="form-control" type="date"
                                                            name="accordions[{{ $branchIndex }}][contract_date]"
                                                            value="{{ old('accordions.' . $branchIndex . '.contract_date', $b->contract_date) }}">
                                                    </div>
                                                </div>

                                                @else

                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="contract_apt">@lang('global.ruxsatnoma_raqami')</label>
                                                        <input type="text" class="form-control"
                                                            name="accordions[{{ $branchIndex }}][contract_apt]"
                                                            value="{{ old('accordions.' . $branchIndex . '.contract_apt', $b->contract_apt) }}"
                                                            placeholder="@lang('global.ruxsatnoma_raqami')" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="contract_date">@lang('global.sanasi')</label>
                                                        <input class="form-control" type="date"
                                                            name="accordions[{{ $branchIndex }}][contract_date]"
                                                            value="{{ old('accordions.' . $branchIndex . '.contract_date', $b->contract_date) }}" disabled>
                                                    </div>
                                                </div>
                                                @endif
                                                


                                                <div class="col-12">
                                                    <textarea class="w-100 my-3 form-control" name="accordions[{{ $branchIndex }}][kengash]" id=""
                                                        cols="30" rows="10" placeholder="@lang('cruds.branches.fields.kengash')">{{ old('accordions.' . $branchIndex . '.kengash', $b->kengash) }}</textarea>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="modal-footer d-flex">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
