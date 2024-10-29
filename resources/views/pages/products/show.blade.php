@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">@lang('cruds.branches.title') - {{ $client->id }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('clientIndex') }}"
                                style="color: #007bff;">@lang('global.home')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('cruds.branches.title') - {{ $client->id }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- Data table -->
                    <table class="table table-striped focus-on">
                        <thead>
                            <tr>
                                <th>{{ __('global.id') }}</th>
                                <th> @lang('global.fio') || @lang('global.company_name')</th>
                                <th>{{ __('global.contact') }}</th>
                                <th>@lang('cruds.company.fields.stir')</th>
                                <th>@lang('global.created_at')</th>

                                <th>{{ __('global.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($client))
                                <tr>
                                    <td>{{ $client->id ?? '' }}</td>
                                    @if ($client->mijoz_turi == 'fizik')
                                        <td>{{ $client->last_name }} {{ $client->first_name }} {{ $client->father_name }}
                                        </td>
                                    @else
                                        <td>{{ $client->company->company_name }} </td>
                                    @endif
                                    <td>{{ $client->contact ?? ('---' ?? '') }}</td>
                                    <td>{{ $client->company->stir ?? ('---' ?? '') }}</td>
                                    <td>{{ $client->created_at ?? ('---' ?? '') }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('clientDestroy', $client->id) }}" method="post">
                                            @csrf
                                            <ul class="list-unstyled hstack gap-1 mb-0">
                                                @can('client.delete')
                                                    <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="@lang('global.edit')">
                                                        <a href="{{ route('clientFizikEdit', $client->id) }}" class="btn btn-info">
                                                            <i class="bx bxs-edit" style="font-size:16px;"></i>
                                                        </a>
                                                    </li>

                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="@lang('global.delete')">
                                                        <button onclick="if (confirm('Вы уверены?')) { this.form.submit() }"
                                                            type="button" data-bs-toggle="modal" class="btn btn-danger">
                                                            <i class="bx bxs-trash" style="font-size: 16px;"></i>
                                                        </button>
                                                    </li>
                                                @endcan
                                                @if ($client->is_qonuniy == 1 || $client->status == 1)
                                                    <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="@lang('global.downloadFile')">
                                                        <a href="{{ route('word', $client->id) }}"
                                                            class="btn btn-secondary">
                                                            <i class="bx bxs-download" style="font-size: 16px;"></i>
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('global.company_and_object_detail')</h3>

                </div>
                <div class="card-body">
                    <!-- Data table -->
                    <table id="datatable" class="table table-bordered dt-responsive w-100">
                        <tbody>
                            <tr>
                                <td>@lang('global.fio')</td>
                                <td colspan="2">{{ $client->last_name }} {{ $client->first_name }}
                                    {{ $client->father_name ?? '' }}</td>
                            </tr>
                            @if ($client->mijoz_turi == 'fizik')
                                <tr>
                                    <td>{{ __('global.passport_pinfl') ?? '' }}</td>
                                    <td>{{ $client->passport->passport_pinfl ?? '' }}</td>
                                </tr>

                                <tr>
                                    <td>{{ __('global.passport_serial') ?? '' }}</td>
                                    <td>{{ $client->passport->passport_serial ?? '' }}</td>
                                </tr>

                                <tr>
                                    @if ($client->passport_date)
                                        <td>@lang('cruds.client.fields.passport_date')</td>
                                        <td>{{ date('d-m-Y', strtotime($client->passport->passport_date)) ?? '' }}</td>
                                    @else
                                        <td>@lang('cruds.client.fields.passport_date')</td>
                                        <td></td>
                                    @endif
                                </tr>


                                <tr>
                                    <td>@lang('cruds.client.fields.passport_location')</td>
                                    <td>{{ $client->passport->passport_location ?? '' }}</td>
                                </tr>



                                <tr>
                                    <td>@lang('global.home_address')</td>
                                    <td colspan="2">{{ $client->address->home_address ?? '' }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td>@lang('cruds.client.fields.yuridik_address')</td>
                                    <td colspan="2">{{ $client->address->yuridik_address ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td>@lang('cruds.company.fields.company_name')</td>
                                    <td colspan="2">{{ $client->company->company_name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td>@lang('cruds.company.fields.oked')</td>
                                    <td colspan="2">{{ $client->company->oked ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td>@lang('cruds.company.fields.raxbar')</td>
                                    <td colspan="2">{{ $client->company->raxbar ?? '' }}</td>
                                </tr>

                                <tr>
                                    <td>@lang('cruds.company.fields.bank_code')</td>
                                    <td colspan="2">{{ $client->company->bank_code ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td>@lang('cruds.company.fields.bank_service')</td>
                                    <td colspan="2">{{ $client->company->bank_service ?? '' }}</td>
                                </tr>
                            @endif

                            <tr>
                                <td>@lang('cruds.company.fields.stir')</td>
                                <td colspan="2">{{ $client->company->stir ?? '' }}</td>
                            </tr>

                            @foreach ($client->branches as $b)
                                <tr>
                                    <td colspan="3" class="text-center bg-secondary text-light">
                                        <strong>@lang('global.contract_details') -
                                            {{ $b->contract_apt }}</strong>
                                    </td>
                                </tr>

                                <tr>
                                    <td>@lang('global.ruxsatnoma_raqami')</td>
                                    <td colspan="2">{{ $b->contract_apt ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td>@lang('global.created_at')</td>
                                    <td colspan="2">{{ $b->contract_date ?? '' }}</td>
                                </tr>

                                <tr>
                                    <td>@lang('cruds.branches.fields.application_number')</td>
                                    <td colspan="2">{{ $b->application_number ?? '' }}</td>
                                </tr>

                                <tr>
                                    <td>@lang('global.loyiha_nomi')</td>
                                    <td colspan="2">{{ $b->branch_name ?? '' }}</td>
                                </tr>


                                <tr>
                                    <td>@lang('cruds.company.fields.branch_type')</td>
                                    <td colspan="2">{{ $b->branch_type ?? '' }}</td>
                                </tr>

                                <tr>
                                    <td>@lang('cruds.company.fields.branch_type') text</td>
                                    <td colspan="2">{{ $b->branch_type_text ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td>@lang('cruds.company.fields.branch_location')</td>
                                    <td colspan="2">{{ $b->branch_location ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td>@lang('global.shaxarsozlik_umumiy_xajmi')</td>
                                    <td colspan="2">{{ $b->shaxarsozlik_umumiy_xajmi }}</td>
                                </tr>
                                <tr>
                                    <td>@lang('global.qavatlar_soni_xajmi')</td>
                                    <td colspan="2">{{ $b->qavatlar_soni_xajmi }}</td>
                                </tr>
                                <tr>
                                    <td>@lang('global.avtoturargoh_xajmi')</td>
                                    <td colspan="2">{{ $b->avtoturargoh_xajmi }}</td>
                                </tr>
                                <tr>
                                    <td>@lang('global.qavat_xona_xajmi')</td>
                                    <td colspan="2">{{ $b->qavat_xona_xajmi }}</td>
                                </tr>
                                <tr>
                                    <td>@lang('global.umumiy_foydalanishdagi_xajmi')</td>
                                    <td colspan="2">{{ $b->umumiy_foydalanishdagi_xajmi }}</td>
                                </tr>
                                <tr>
                                    <td>@lang('global.qurilish_turi')</td>
                                    <td colspan="2">{{ $b->qurilish_turi }}</td>
                                </tr>
                                <tr>
                                    <td>@lang('global.coefficient')</td>
                                    <td colspan="2">{{ $b->coefficient }}</td>
                                </tr>
                                <tr>
                                    <td>@lang('global.zona')</td>
                                    <td colspan="2">{{ $b->zona }}</td>
                                </tr>

                                <tr>
                                    <td>@lang('global.obyekt_boyicha_tolanishi_lozim') ( m³ )</td>
                                    <td colspan="2">{{ number_format($b->branch_kubmetr, 1) ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td>@lang('global.jami_tolanishi_kerak')</td>
                                    <td colspan="2" class="formatted-number">{{ $b->generate_price ?? '' }}</td>
                                </tr>



                                <tr>
                                    <td>@lang('global.bolib_tolash_foizi_oldindan')</td>
                                    <td colspan="2">{{ $b->percentage_input }}%</td>
                                </tr>
                                <tr>
                                    <td>@lang('global.quarterly_payment')</td>
                                    <td colspan="2">{{ $b->installment_quarterly ?? '' }}</td>
                                </tr>

                                <tr>
                                    <td>@lang('global.bolib_tolash')</td>
                                    <td colspan="2">
                                        @if ($b->payment_type == 'pay_bolib')
                                            @lang('global.pay_bolib')
                                        @else
                                            @lang('global.pay_full')
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td>@lang('cruds.branches.fields.payed_sum')</td>
                                    <td colspan="2" class="formatted-number">{{ $b->payed_sum ?? '' }}</td>
                                </tr>

                                <tr>
                                    <td>@lang('cruds.branches.fields.payed_date')</td>
                                    <td colspan="2">{{ $b->payed_date ?? '' }}</td>
                                </tr>

                                <tr>
                                    <td>@lang('cruds.branches.fields.notification_num')</td>
                                    <td colspan="2">{{ $b->notification_num ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td>@lang('cruds.branches.fields.notification_date')</td>
                                    <td colspan="2">{{ $b->notification_date ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td>@lang('cruds.branches.fields.insurance_policy')</td>
                                    <td colspan="2">{{ $b->insurance_policy ?? '' }}</td>
                                </tr>

                                <tr>
                                    <td>@lang('cruds.branches.fields.bank_guarantee')</td>
                                    <td colspan="2">{{ $b->bank_guarantee ?? '' }}</td>
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
                            <ul>
                                <h5>@lang('global.contract_details')</h5>

                                {{-- @foreach ($files as $file)
                                    <div class="py-1">
                                        <a target="_blank" class="py-2 my-2"
                                            href="{{ asset($file->path) }}">{{ $file->path }}</a>

                                    </div>
                                @endforeach --}}


                                <link rel="stylesheet"
                                    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
                                <style>
                                    .file-upload-card {
                                        border: 1px solid #ddd;
                                        border-radius: 8px;
                                        padding: 15px;
                                        margin-bottom: 15px;
                                    }

                                    .file-list-item {
                                        display: flex;
                                        align-items: center;
                                        padding: 8px 0;
                                        border-bottom: 1px solid #ddd;
                                    }

                                    .file-list-item:last-child {
                                        border-bottom: none;
                                    }

                                    .file-icon {
                                        margin-right: 10px;
                                        font-size: 1.2rem;
                                    }

                                    .file-label {
                                        margin-left: 10px;
                                        font-weight: bold;
                                        color: #555;
                                    }

                                    .label-document {
                                        color: #007bff;
                                    }

                                    .label-payment {
                                        color: #28a745;
                                    }

                                    .label-ruxsatnoma {
                                        color: #ffc107;
                                    }

                                    .label-kengash {
                                        color: #dc3545;
                                    }

                                    .delete-checkbox {
                                        margin-left: auto;
                                    }
                                </style>

                                <div class="col-12 mt-4">
                                    <h5>@lang('global.uploaded_files')</h5>
                                    <div class="file-list">
                                        @foreach ($files as $file)
                                            <div class="file-list-item">
                                                <i class="fas fa-file-alt file-icon"></i>
                                                <a target="_blank" class="py-2 my-2" href="{{ asset($file->path) }}">
                                                    {{ basename($file->path) }}
                                                </a>
                                                <span
                                                    class="file-label {{ strpos($file->path, 'qurilish_xajmi/') !== false
                                                        ? 'label-document'
                                                        : (strpos($file->path, 'payment/') !== false
                                                            ? 'label-document'
                                                            : (strpos($file->path, 'ruxsatnoma/') !== false
                                                                ? 'label-document'
                                                                : (strpos($file->path, 'kengash/') !== false
                                                                    ? 'label-document'
                                                                    : ''))) }}">
                                                    {{ 
                                                    
                                                   strpos($file->path, 'documents/') !== false
                                                    ? 'Document'
                                                    : (strpos($file->path, 'payment/') !== false
                                                        ? 'Payment'
                                                        : (strpos($file->path, 'ruxsatnoma/') !== false
                                                            ? 'Ruxsatnoma'
                                                            : (strpos($file->path, 'kengash/') !== false
                                                                ? 'Kengash'
                                                                : (strpos($file->path, 'loyiha_xujjati/') !== false
                                                                    ? 'Loyiha Xujjati'
                                                                    : (strpos($file->path, 'qurilish_xajmi/') !== false
                                                                        ? 'Qurilish Xajmi'
                                                                        : '')))))
                                                    
                                                    }}

                                                
                                                  
                                                </span>
                                                <div class="delete-checkbox">
                                                    {{ $file->updated_at }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            </ul>

                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Toggle column visibility
            $('.toggle-column').change(function() {
                var column = $(this).data('column');
                var isChecked = $(this).is(':checked');
                var table = $('#datatable');

                table.find('tr').each(function() {
                    if (isChecked) {
                        $(this).find('th').eq(column).removeClass('d-none');
                        $(this).find('td').eq(column).removeClass('d-none');
                    } else {
                        $(this).find('th').eq(column).addClass('d-none');
                        $(this).find('td').eq(column).addClass('d-none');
                    }
                });
            });

            // Hide columns by default
            $('.toggle-column').each(function() {
                var column = $(this).data('column');
                if (!$(this).is(':checked')) {
                    var table = $('#datatable');
                    table.find('tr').each(function() {
                        $(this).find('th').eq(column).addClass('d-none');
                        $(this).find('td').eq(column).addClass('d-none');
                    });
                }
            });


        });
    </script>
    <script>
        function toggle_instock(id) {
            $.ajax({
                url: "/clients/toggle-status/" + id,
                type: "POST",
                data: {
                    _token: "{!! @csrf_token() !!}"
                },
                success: function(result) {
                    if (result.is_active == 1) {
                        $("#program_" + id).attr('class', "fas fa-check-circle text-success");
                    } else {
                        $("#program_" + id).attr('class', "fas fa-times-circle text-danger");
                    }
                },
                error: function(errorMessage) {
                    console.log(errorMessage)
                }
            });
        }
    </script>

    <script src="{{ asset('assets/libs/admin-resources/rwd-table/rwd-table.min.js') }}"></script>

    <!-- Init js -->
    <script src="{{ asset('assets/js/pages/table-responsive.init.js') }}"></script>
@endsection
