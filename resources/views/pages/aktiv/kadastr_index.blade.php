@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Check Cadastral Numbers</h1>
        <form method="POST" action="{{ route('aktivs.kadastr') }}">
            @csrf
            <div class="form-group">
                <label for="cadastre_numbers">Cadastral Numbers (one per line):</label>
                <textarea class="form-control" id="cadastre_numbers" name="cadastre_numbers" rows="10" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
@endsection
