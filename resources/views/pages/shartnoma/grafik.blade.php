@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Йиғимнинг қолган {{$item->percentage_input}} фоизини тўлаш</h1>

    <h2 class="text-center mb-4">РЕЖА ГРАФИГИ</h2>

    @if (!empty($paymentSchedule))
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Чорак</th>
                    <th>тўлов санаси</th>
                    <th>тўлов миқдори</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paymentSchedule as $index => $schedule)
                <tr>
                    <td>{{ $schedule['quarter'] }}</td>
                    <td>{{ \Carbon\Carbon::parse($schedule['payment_date'])->format('d/m/Y') }}</td>
                    <td>{{ number_format($schedule['payment_amount'], 2, ',', ' ') }} сум</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="font-weight-bold">Жами</td>
                    <td class="font-weight-bold">{{ $totalAmount }} сум</td>
                </tr>
            </tfoot>
        </table>
    </div>
    @else
    <p class="text-center">Маълумот мавжуд эмас.</p>
    @endif

      <!-- Mathematical Logic Section -->
      @if (!empty($item))
      <div class="additional-data mt-5">
          <h3>Қўшимча маълумотлар</h3>
          
          <!-- Mathematical Explanation -->
          <div class="mathematical-logic mb-4">
              <p><strong>Маълумотлар:</strong></p>
              <ul>
                  <li><strong>Жами нарх:</strong> {{ number_format($item->generate_price, 2, ',', ' ') }} сум</li>
                  <li><strong>Тўланган процент:</strong> {{ $item->percentage_input }}%</li>
                  <li><strong>Бошланғич тўлов:</strong> {{ number_format($item->first_payment_percent, 2, ',', ' ') }} сум</li>
                  <li><strong>Чорак:</strong> {{ $item->installment_quarterly }}</li>
              </ul>
          
          </div>
  
         
      </div>
      @else
      <p class="text-center mt-5">Қўшимча маълумотлар мавжуд эмас.</p>
      @endif
</div>
@endsection
