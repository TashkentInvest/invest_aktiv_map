<!DOCTYPE html>
<html>
<head>
    <title>Import Excel File</title>
</head>
<body>
    <h1>Import Excel File</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if (session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <form action="{{ route('import.post') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" accept=".xlsx" />
        <button type="submit">Import</button>
    </form>
</body>
</html>