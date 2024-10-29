@extends('layouts.admin')

@section('content')
    <h1>Aktivs</h1>
    <a href="{{ route('aktivs.create') }}" class="btn btn-primary mb-3">Create New Aktiv</a>

    @if($aktivs->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Object Name</th>
                    <th>Balance Keeper</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($aktivs as $aktiv)
                    <tr>
                        <td>{{ $aktiv->object_name }}</td>
                        <td>{{ $aktiv->balance_keeper }}</td>
                        <td>{{ $aktiv->location }}</td>
                        <td>
                            <a href="{{ route('aktivs.show', $aktiv) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('aktivs.edit', $aktiv) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('aktivs.destroy', $aktiv) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this aktiv?');">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $aktivs->links() }}
    @else
        <p>No aktivs found.</p>
    @endif
@endsection
