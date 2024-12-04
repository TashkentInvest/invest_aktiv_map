<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Ko'rsatilgan raqam</th>
            <th>Hudud</th>
            <th>Tuman</th>
            <th>Manzil</th>
            <th>Yer maydoni</th>
            <th>Tip ma'lumot</th>
            <th>Vid ma'lumot</th>
            <th>Xujjatlar</th>
            <th>Detallar</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($results as $index => $result)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $result['cad_number'] ?? 'Ma\'lumot yo\'q' }}</td>
                <td>{{ $result['region'] ?? 'Ma\'lumot yo\'q' }}</td>
                <td>{{ $result['district'] ?? 'Ma\'lumot yo\'q' }}</td>
                <td>{{ $result['address'] ?? 'Ma\'lumot yo\'q' }}</td>
                <td>{{ $result['land_area'] ?? 'Ma\'lumot yo\'q' }} m²</td>
                <td>{{ $result['tipText'] ?? 'Ma\'lumot yo\'q' }}</td>
                <td>{{ $result['vidText'] ?? 'Ma\'lumot yo\'q' }}</td>
                <td>
                    @if(isset($result['documents']) && is_array($result['documents']) && count($result['documents']) > 0)
                    {{-- @dump($result['documents']) --}}
                        @foreach($result['documents'] as $ban)
                            <div class="ban-detail">
                                <strong>Tur:</strong> {{ $ban['type'] ?? 'Ma\'lumot yo\'q' }}<br>
                                <strong>Qaror raqami:</strong> {{ $ban['num'] ?? 'Noma\'lum' }}<br>
                                <strong>Egasi:</strong> {{ $ban['owner'] ?? 'Ma\'lumot yo\'q' }}<br>
                                <strong>Sana:</strong> {{ $ban['date'] ?? 'Noma\'lum' }}
                            </div>
                            <hr>
                        @endforeach
                    @else
                        <span class="text-muted">Qaror mavjud emas.</span>
                    @endif
                </td>
                <td>
                    @if(isset($result['bans']) && is_array($result['bans']) && count($result['bans']) > 0)
                        @foreach($result['bans'] as $ban)
                            <div class="ban-detail">
                                <strong>Ta'qiq raqami:</strong> {{ $ban['banfull_nomer'] ?? 'Noma\'lum' }}<br>
                                <strong>Egasi:</strong> {{ $ban['banosnova_owner'] ?? 'Ma\'lumot yo\'q' }}<br>
                                <strong>Tur:</strong> {{ $ban['banosnova_vid'] ?? 'Ma\'lumot yo\'q' }}<br>
                                <strong>Izohlar:</strong> {{ $ban['banosnova_komment'] ?? 'Yo\'q' }}<br>
                                <strong>Sana:</strong> {{ $ban['banfull_date'] ?? 'Noma\'lum' }}
                            </div>
                            <hr>
                        @endforeach
                    @else
                        <span class="text-muted">Ta'qiq mavjud emas.</span>
                    @endif
                </td>
              
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">Natijalar topilmadi.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<style>
    .table {
        width: 100%;
        margin-bottom: 1rem;
        color: #212529;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .table th, .table td {
        padding: 15px;
        vertical-align: middle;
        border-top: 1px solid #dee2e6;
        font-size: 1rem;
    }

    .table th {
        background-color: #f8f9fa;
        color: #495057;
        font-weight: bold;
        text-align: center;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }

    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
    }

    .ban-detail {
        font-size: 0.9rem;
        margin-bottom: 8px;
    }

    .ban-detail strong {
        color: #007bff;
    }

    .text-muted {
        color: #6c757d;
    }

    .text-center {
        text-align: center;
    }

    hr {
        border: 0;
        border-top: 1px solid #dee2e6;
        margin: 10px 0;
    }
</style>
