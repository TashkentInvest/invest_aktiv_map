@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Тўлов қўшиш</h1>

    <form action="{{ route('fact_payments.store') }}" method="POST">
        @csrf
        <input type="hidden" name="shartnoma_id" value="{{ $shartnoma_id }}">

        <div class="form-group">
            <label for="payment_schedule_id">Тўлов режа:</label>
            <select name="payment_schedule_id" id="payment_schedule_id" class="form-control" required>
                <option value="">Танланг</option>
                @foreach($paymentSchedules as $schedule)
                    <option value="{{ $schedule->id }}">{{ $schedule->quarter }} - {{ $schedule->payment_date->format('d/m/Y') }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="payment_amount">Тўлов миқдори:</label>
            <input type="number" name="payment_amount" id="payment_amount" class="form-control" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="payment_date">Тўлов санаси:</label>
            <input type="date" name="payment_date" id="payment_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="comment">Изоҳ (мавжуд бўлса):</label>
            <textarea name="comment" id="comment" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Сақлаш</button>
    </form>
</div>
@endsection
