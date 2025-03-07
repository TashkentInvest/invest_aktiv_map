@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="mb-0">
            Активлар: <strong>{{ $aktivs->total() ?? '0' }}</strong>
            @if (in_array(auth()->user()->roles[0]->name, ['Super Admin', 'Manager']))
                <small class="text-muted ms-2">
                    (Ер: {{ $yerCount ?? '0' }} | Нотурар: {{ $noturarBinoCount ?? '0' }} | Турар:
                    {{ $turarBinoCount ?? '0' }})
                </small>
            @endif
        </h6>

        <a href="{{ route('aktivs.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i>
        </a>
    </div>

    <div class="col-3 p-0 m-0">
        <form action="{{ route('aktivs.index') }}" method="get" class="d-flex gap-1 mb-2">
            <input type="text" class="form-control form-control-sm" name="kadastr_raqami" placeholder="Кадастр рақами"
                id="kadastr_raqami" value="{{ request()->input('kadastr_raqami') }}">


            <select name="building_type" id="building_type" class="form-control form-control-sm">
                <option value="">-- Mulk Turini Tanlang --</option>
                <option value="yer" {{ request()->input('building_type') == 'yer' ? 'selected' : '' }}>yer</option>
                <option value="TurarBino" {{ request()->input('building_type') == 'TurarBino' ? 'selected' : '' }}>TurarBino
                </option>
                <option value="NoturarBino" {{ request()->input('building_type') == 'NoturarBino' ? 'selected' : '' }}>
                    NoturarBino</option>
            </select>
            <button type="submit" class="btn btn-sm btn-primary">@lang('global.filter')</button>
        </form>

    </div>

    @if ($aktivs->count())
        <div class="table-responsive">
            <table class="table table-bordered table-sm mb-0">
                <thead class="table-light">
                    <tr class="small text-center">
                        <th>№</th>
                        <th><i class="fas fa-user"> Фойдаланувчи</i></th>
                        <th><i class="fas fa-building"></i> Объект номи</th>
                        <th><i class="fas fa-balance-scale"></i> Балансда сақловчи</th>
                        <th><i class="fas fa-map-marker-alt"></i> Мфй / Коча</th>
                        <th><i class="fa-solid fa-earth-americas"></i> Кадастр</th>
                        <th><i class="fas fa-cogs"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($aktivs as $aktiv)
                        <tr class="small">
                            <td class="fw-bold">{{ $aktiv->id ?? '-' }}</td>
                            <td title="{{ $aktiv->user->name ?? '-' }}">
                                {{ $aktiv->user->email ?? '-' }}
                            </td>
                            <td style="max-width: 250px" class="text-truncate" title="{{ $aktiv->object_name ?? '' }}">
                                {{ $aktiv->object_name ?? '' }}
                            </td>
                            <td class="text-truncate" title="{{ $aktiv->balance_keeper ?? '' }}">
                                {{ $aktiv->balance_keeper ?? '' }}
                            </td>
                            <td class="text-truncate" title="{{ $aktiv->subStreet->district->name_uz ?? 'Маълумот йўқ' }}">
                                {{ $aktiv->street->name ?? '-' }},
                                {{ $aktiv->subStreet->name ?? '-' }}
                            </td>
                            <td>{{ $aktiv->kadastr_raqami ?? '-' }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('aktivs.show', $aktiv) }}" class="btn btn-sm btn-info"
                                        title="Кўриш">
                                        <i class="fas fa-eye text-light"></i>
                                    </a>
                                    <a href="{{ route('aktivs.edit', $aktiv) }}" class="btn btn-sm btn-warning"
                                        title="Таҳрирлаш">
                                        <i class="fas fa-edit text-light"></i>
                                    </a>
                                    @if (auth()->user()->roles[0]->name == 'Manager')
                                        <form action="{{ route('aktivs.destroy', $aktiv) }}" method="POST"
                                            onsubmit="return confirm('Сиз ростдан ҳам бу объектни ўчиришни истайсизми?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Ўчириш">
                                                <i class="fas fa-trash-alt text-light"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $aktivs->links('pagination::bootstrap-4') }}
        </div>
    @else
        <div class="alert alert-warning text-center mt-3 small">
            <i class="fas fa-exclamation-circle"></i> Активлар топилмади.
        </div>
    @endif

    <style>
        table.table {
            font-size: 12px;
        }

        .table th,
        .table td {
            padding: 4px !important;
            vertical-align: middle;
        }

        .table-hover tbody tr:hover {
            background-color: #f9f9f9;
        }

        .btn-sm {
            padding: 2px 6px;
            font-size: 12px;
        }

        .alert {
            font-size: 12px;
            padding: 8px;
        }

        .text-truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
@endsection
