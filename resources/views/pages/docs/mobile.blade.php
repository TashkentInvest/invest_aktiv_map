<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quruvchi va qurilish obyekti bo'yicha malumotlar</title>
    <style>
        body {
            font-family: Calibri, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            margin: 0;
            padding: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
        }

        th, td {
            padding: 2px 4px;
            border: 1px solid #ddd;
            font-size: 13px;
        }

        .card-header {
            text-align: center;
            padding-bottom: 5px;
            font-size: 14px;
            font-weight: bold;
            padding: 0;
        }

        .bold {
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .bg-secondary {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Quruvchi va qurilish obyekti bo'yicha malumotlar 
                <span style="float: right;">{{$client->updated_at->format('d-m-Y')}} Yil</span>
            </h3>
        </div>
        
        <div class="card-body">
            <table>
                <tbody>
                    <tr>
                        <td class="bold">FIO:</td>
                        <td>{{ $client->last_name }} {{ $client->first_name }} {{ $client->father_name ?? '' }}</td>
                    </tr>
                    @if ($client->mijoz_turi == 'fizik')
                        <tr>
                            <td class="bold">@lang('global.passport_pinfl'):</td>
                            <td>{{ $client->passport->passport_pinfl ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="bold">@lang('global.passport_serial'):</td>
                            <td>{{ $client->passport->passport_serial ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="bold">@lang('cruds.client.fields.passport_date'):</td>
                            <td>{{ $client->passport->passport_date ? date('d-m-Y', strtotime($client->passport->passport_date)) : '' }}</td>
                        </tr>
                        <tr>
                            <td class="bold">@lang('cruds.client.fields.passport_location'):</td>
                            <td>{{ $client->passport->passport_location ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="bold">@lang('global.home_address'):</td>
                            <td>{{ $client->address->home_address ?? '' }}</td>
                        </tr>
                    @else
                        <tr>
                            <td class="bold">@lang('cruds.client.fields.yuridik_address'):</td>
                            <td>{{ $client->address->yuridik_address ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="bold">@lang('cruds.company.fields.company_name'):</td>
                            <td>{{ $client->company->company_name ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="bold">@lang('cruds.company.fields.oked'):</td>
                            <td>{{ $client->company->oked ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="bold">@lang('cruds.company.fields.raxbar'):</td>
                            <td>{{ $client->company->raxbar ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="bold">@lang('cruds.company.fields.bank_code'):</td>
                            <td>{{ $client->company->bank_code ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="bold">@lang('cruds.company.fields.bank_service'):</td>
                            <td>{{ $client->company->bank_service ?? '' }}</td>
                        </tr>
                    @endif

                    <tr>
                        <td class="bold">@lang('cruds.company.fields.stir'):</td>
                        <td>{{ $client->company->stir ?? '' }}</td>
                    </tr>

                    @foreach ($client->branches as $b)
                        <tr>
                            <td class="bold">@lang('cruds.branches.fields.application_number'):</td>
                            <td>{{ $b->application_number ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="bold">@lang('global.loyiha_nomi'):</td>
                            <td>{{ $b->branch_name ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="bold">@lang('cruds.company.fields.branch_type'):</td>
                            <td>{{ $b->branch_type_text ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="bold">@lang('cruds.company.fields.branch_location'):</td>
                            <td>{{ $b->branch_location ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="bold">@lang('global.shaxarsozlik_umumiy_xajmi'):</td>
                            <td>{{ $b->shaxarsozlik_umumiy_xajmi }}</td>
                        </tr>
                        <tr>
                            <td class="bold">@lang('global.qavatlar_soni_xajmi'):</td>
                            <td>{{ $b->qavatlar_soni_xajmi }}</td>
                        </tr>
                        <tr>
                            <td class="bold">@lang('global.avtoturargoh_xajmi'):</td>
                            <td>{{ $b->avtoturargoh_xajmi }}</td>
                        </tr>
                        <tr>
                            <td class="bold">@lang('global.qavat_xona_xajmi'):</td>
                            <td>{{ $b->qavat_xona_xajmi }}</td>
                        </tr>
                        <tr>
                            <td class="bold">@lang('global.umumiy_foydalanishdagi_xajmi'):</td>
                            <td>{{ $b->umumiy_foydalanishdagi_xajmi }}</td>
                        </tr>
                        <tr>
                            <td class="bold">@lang('global.qurilish_turi'):</td>
                            <td>{{ $b->qurilish_turi }}</td>
                        </tr>
                        <tr>
                            <td class="bold">@lang('global.coefficient'):</td>
                            <td>{{ $b->coefficient }}</td>
                        </tr>
                        <tr>
                            <td class="bold">@lang('global.zona'):</td>
                            <td>{{ $b->zona }}</td>
                        </tr>
                        <tr>
                            <td class="bold">@lang('global.obyekt_boyicha_tolanishi_lozim') ( m³ ):</td>
                            <td>{{ number_format($b->branch_kubmetr, 1) ?? ''}}</td>
                        </tr>
                        <tr>
                            <td class="bold">@lang('global.jami_tolanishi_kerak'):</td>
                            <td class="formatted-number">{{ $b->generate_price ?? ''}}</td>
                        </tr>
                        <tr>
                            <td class="bold">@lang('global.bolib_tolash_foizi_oldindan'):</td>
                            <td>{{ $b->percentage_input }}%</td>
                        </tr>
                    @endforeach
                </tbody>


              
            </table>

            @if ($client->mijoz_turi != 'fizik')

            <table style="width: 100%; text-align: center; font-family: 'Arial', sans-serif;">
                <tr>
                    <td style="width: 50%; padding: 10px; border:none;">
                        <div style="font-size: 1.2em; margin-bottom: 5px;">
                            ___________________
                        </div>
                        <p style="font-weight: bold; color: #333; margin: 0;">Imzo</p>
                    </td>
                    <td style="width: 50%; padding: 10px; border:none;">
                        <div style="font-size: 1.2em; margin-bottom: 5px;">
                            ___________________
                        </div>
                        <p style="font-weight: bold; color: #333; margin: 0;">F.I.O</p>
                    </td>
                </tr>
            </table>
            @else

            <table style="width: 100%; text-align: center; font-family: 'Arial', sans-serif;">
                <tr>
                    <td style="width: 33%; padding: 10px; border:none;">
                        <div style="font-size: 1.2em; margin-bottom: 5px;">
                            ___________________
                        </div>
                        <p style="font-weight: bold; color: #333; margin: 0;">Nomi</p>
                    </td>

                    <td style="width: 33%; padding: 10px; border:none;">
                        <div style="font-size: 1.2em; margin-bottom: 5px;">
                            ___________________
                        </div>
                        <p style="font-weight: bold; color: #333; margin: 0;">Imzo</p>
                    </td>

                    <td style="width: 33%; padding: 10px; border:none;">
                        <div style="font-size: 1.2em; margin-bottom: 5px;">
                            ___________________
                        </div>
                        <p style="font-weight: bold; color: #333; margin: 0;">F.I.O</p>
                    </td>
                </tr>
            </table>
            @endif
            
        </div>
    </div>
</body>

</html>
