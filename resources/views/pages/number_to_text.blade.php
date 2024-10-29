<!-- resources/views/number_to_text.blade.php -->
<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <title>Number to Text</title>
</head>
<body>
    <form method="GET" action="/number-to-text">
        <label for="value">Sonni kiriting:</label>
        <input type="text" id="value" name="value" required>
        <button type="submit">Tarjima qilish</button>
    </form>

    @if(isset($text))
        <p>Natija: {{ $text }}</p>
    @endif
</body>
</html>
