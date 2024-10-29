<!-- resources/views/payments/filter.blade.php -->
<form action="{{ route('payments.filter') }}" method="GET">
    <div>
        <label for="year">Year</label>
        <input type="text" name="year" id="year">
    </div>
    <div>
        <label for="month">Month</label>
        <input type="text" name="month" id="month">
    </div>
    <button type="submit">Filter</button>
</form>

<table>
    <thead>
        <tr>
            <th>Quarter</th>
            <th>Payment Date</th>
            <th>Payment Amount</th>
            <th>Fact Payments</th>
        </tr>
    </thead>
    <tbody>
        @foreach($paymentSchedules as $schedule)
            <tr>
                <td>{{ $schedule->quarter }}</td>
                <td>{{ $schedule->payment_date }}</td>
                <td>{{ $schedule->payment_amount }}</td>
                <td>
                    @foreach($schedule->factPayments as $factPayment)
                        <div>{{ $factPayment->payment_amount }} ({{ $factPayment->payment_date }})</div>
                    @endforeach
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div>
    <strong>Total Amount:</strong> {{ $totalAmount }}
</div>
