@extends('layouts.admin')

@section('content')
    <h1 class="mb-4">Фойдаланувчилар ва Активлар сони</h1>

    @if ($users->count())
        <div class="table-responsive rounded shadow-sm">
            <table id="users-table" class="table table-hover table-bordered align-middle">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">Фойдаланувчи ID</th>
                        <th scope="col">Исми</th>
                        <th scope="col">Электрон почта</th>
                        <th scope="col">Роли</th>
                        <th scope="col">Яратилган Активлар сони</th>
                        <th scope="col">Ҳаракатлар</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($users as $user)
                        @if ($user->name != 'Employee')
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @foreach ($user->roles as $role)
                                        <span class="badge bg-info text-light">{{ $role->name }}</span>
                                    @endforeach
                                </td>
                                <td>{{ $user->aktivs_count }}</td>
                                <td>
                                    <a href="{{ route('aktivs.index', ['user_id' => $user->id]) }}"
                                        class="btn btn-primary btn-sm">
                                        Активларини кўриш
                                    </a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>

            </table>
        </div>
    @else
        <p>Фойдаланувчилар топилмади.</p>
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
            $('#users-table').DataTable({
                // Optional: Customize DataTables language settings
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/Uzbek.json' // Adjust the URL if needed
                }
            });
        });
    </script>
@endsection
