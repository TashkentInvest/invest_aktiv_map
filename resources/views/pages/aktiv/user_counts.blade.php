@extends('layouts.admin')

@section('content')
    <h1 class="mb-4">Фойдаланувчилар ва Активлар сони</h1>

    @if ($users->count())
        <div class="table-responsive rounded shadow-sm">
            <table class="table table-hover table-bordered align-middle">
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
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach ($user->roles as $role)
                                    <span class="badge bg-info text-dark">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td>{{ $user->aktivs_count }}</td>
                            <td>
                                <a href="{{ route('aktivs.index', ['user_id' => $user->id]) }}" class="btn btn-primary btn-sm">
                                    Активларини кўриш
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>Фойдаланувчилар топилмади.</p>
    @endif
@endsection
