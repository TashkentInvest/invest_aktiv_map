@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Активлар сони: {{ $aktivs->total() ?? '' }}</h1>
        <a href="{{ route('aktivs.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Янги актив яратиш
        </a>
    </div>

    @if ($aktivs->count())
        <div class="table-responsive rounded shadow-sm">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-primary">
                    <tr>
                        <th scope="col"><i class="fas fa-user"></i> Фойдаланувчи</th>
                        <th scope="col" width="50"><i class="fas fa-building"></i> Объект номи</th>
                        <th scope="col"><i class="fas fa-balance-scale"></i> Балансда сақловчи</th>
                        <th scope="col" width="100" style="width: 100px"><i class="fas fa-map-marker-alt"></i> Мфй /
                            Коча</th>
                        <th scope="col"><i class="fas fa-calendar-alt"></i> Сана</th>
                        <th scope="col" class="text-center"><i class="fas fa-cogs"></i> Ҳаракатлар</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($aktivs as $aktiv)
                        <tr>
                            <td class="fw-bold">
                                {{ $aktiv->user->name ?? 'No Name' }}<br>
                                <small class="text-muted">{{ $aktiv->user->email ?? 'No Email' }}</small>
                            </td>
                            <td style="max-width: 200px" class="text-truncate" title="...">

                                {{ $aktiv->object_name }}

                                <style>
                                    .text-truncate {
                                        word-wrap: break-word;
                                        word-break: break-word;
                                        white-space: normal;
                                    }

                                 
                                </style>
                            </td>
                            <td>{{ $aktiv->balance_keeper }}</td>
                            <td style="width: 100px" class="text-truncate"
                                title="{{ $aktiv->subStreet->district->name_uz ?? 'Маълумот йўқ' }}">
                                {{ $aktiv->street->name ?? 'Маълумот йўқ' }},
                                {{ $aktiv->subStreet->name ?? 'Маълумот йўқ' }}</td>
                            <td>{{ $aktiv->created_at->format('d-m-Y H:i') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('aktivs.show', $aktiv) }}" class="btn btn-info btn-sm"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Кўриш">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    @if (auth()->user()->roles[0]->name != 'Manager')
                                        <a href="{{ route('aktivs.edit', $aktiv) }}" class="btn btn-warning btn-sm"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Таҳрирлаш">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('aktivs.destroy', $aktiv) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Ўчириш"
                                                onclick="return confirm('Сиз ростдан ҳам бу объектни ўчиришни истайсизми?');">
                                                <i class="fas fa-trash-alt"></i>
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

        <!-- Pagination Controls -->
        <div class="d-flex justify-content-center mt-4">
            {{ $aktivs->links('pagination::bootstrap-4') }}
        </div>
    @else
        <div class="alert alert-warning text-center mt-4">
            <i class="fas fa-exclamation-circle"></i> Активлар топилмади.
        </div>
    @endif
@endsection

@section('styles')
    <style>
        .table {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }

        .table-primary th {
            background-color: #007bff;
            color: white;
        }

        .table-primary th i {
            margin-right: 5px;
            font-size: 1.1rem;
            vertical-align: middle;
        }

        .fw-bold {
            font-weight: 600;
        }

        .table-bordered td,
        .table-bordered th {
            border-color: #dee2e6 !important;
        }

        .btn-sm {
            padding: 6px 8px;
            font-size: 0.875rem;
        }

        .btn {
            transition: all 0.2s ease-in-out;
        }

        .btn:hover {
            transform: scale(1.05);
            box-shadow: 0px 4px 12px rgba(0, 123, 255, 0.2);
        }

        .alert-warning {
            background-color: #fff3cd;
            border-color: #ffecb5;
            color: #856404;
        }

        /* Truncate long text */
        .text-truncate {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
    </style>
@endsection

@section('scripts')
    <!-- Include Font Awesome for Icons and Tooltip Initialization -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script>
        // Initialize tooltips
        document.addEventListener("DOMContentLoaded", function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
@endsection
