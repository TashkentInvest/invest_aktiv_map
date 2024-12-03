@extends('layouts.admin')

@section('content')
    <h1>Кадастр Маълумотлари: Туман - {{ $district->name_uz ?? '' }} / {{$district->aktives->count()}}</h1>

    @if ($district->aktives->count())
        <div class="table-responsive rounded shadow-sm">
            <table id="kadastr-table" class="table table-hover table-bordered align-middle">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Кадастр рақами</th>
                        <th scope="col">Фойдаланувчи номи</th>
                        <th scope="col">Яратилган сана</th>
                        <th scope="col">Активни кориш</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($district->aktives as $aktiv)
                        <tr>
                            <td>{{ $aktiv->id }}</td>
                            <td>{{ $aktiv->kadastr_raqami ?? 'Номи йўқ' }}</td>
                            <td>{{ $aktiv->user->name ?? 'Номи йўқ' }} - {{ $aktiv->user->email ?? 'Номи йўқ' }}</td>
                            <td>{{ $aktiv->created_at ?? 'Номи йўқ' }}</td>
                            <td>
                                <a href="{{ route('aktivs.show',  $aktiv->id) }}" 
                                    class="btn btn-primary btn-sm">
                                     Кадастрларни кўриш
                                 </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>Кадастр маълумотлари топилмади.</p>
    @endif
@endsection

@section('scripts')
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>

    <!-- Include DataTables CSS and JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    
    <!-- Initialize DataTables -->
    <script>
        $(document).ready(function() {
            $('#kadastr-table').DataTable();
        });
    </script>
@endsection
