@extends('layouts.admin')

@section('content')
    <h1>Активлар</h1>
    <a href="{{ route('aktivs.create') }}" class="btn btn-primary mb-3">Янги актив яратиш</a>

    @if ($aktivs->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Фойдаланувчи</th>
                    <th>Объект номи</th>
                    <th>Балансда сақловчи</th>
                    <th>Мўлжал</th>
                    <th>Ҳаракатлар</th>
                    <th>Сана</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($aktivs as $aktiv)
                    <tr>
                        <td>{{ $aktiv->user->id ?? '' }} | {{ $aktiv->user->name ?? '' }} | {{ $aktiv->user->email ?? '' }}</td>
                        <td>{{ $aktiv->object_name }}</td>
                        <td>{{ $aktiv->balance_keeper }}</td>
                        <td>{{ $aktiv->location }}</td>
                        <td>{{ $aktiv->created_at }}</td>
                        <td>
                            <a href="{{ route('aktivs.show', $aktiv) }}" class="btn btn-info btn-sm">Кўриш</a>
                            <a href="{{ route('aktivs.edit', $aktiv) }}" class="btn btn-warning btn-sm">Таҳрирлаш</a>
                            <form action="{{ route('aktivs.destroy', $aktiv) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Сиз ростдан ҳам бу объектни ўчиришни истайсизми?');">
                                    Ўчириш
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $aktivs->links() }}
    @else
        <p>Активлар топилмади.</p>
    @endif
@endsection
