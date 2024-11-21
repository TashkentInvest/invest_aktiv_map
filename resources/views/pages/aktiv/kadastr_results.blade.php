<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Cadastral Number</th>
            <th>Region</th>
            <th>District</th>
            <th>Address</th>
            <th>Land Area</th>
            <th>Details</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($results as $index => $result)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $result['cad_number'] ?? 'N/A' }}</td>
                <td>{{ $result['region'] ?? 'N/A' }}</td>
                <td>{{ $result['district'] ?? 'N/A' }}</td>
                <td>{{ $result['address'] ?? 'N/A' }}</td>
                <td>{{ $result['land_area'] ?? 'N/A' }} m²</td>
                <td>
                    @if(isset($result['bans']) && is_array($result['bans']) && count($result['bans']) > 0)
                        @foreach($result['bans'] as $ban)
                            <div class="ban-detail">
                                <strong>Ban Number:</strong> {{ $ban['banfull_nomer'] ?? 'Unknown' }}<br>
                                <strong>Owner:</strong> {{ $ban['banosnova_owner'] ?? 'N/A' }}<br>
                                <strong>Type:</strong> {{ $ban['banosnova_vid'] ?? 'N/A' }}<br>
                                <strong>Comments:</strong> {{ $ban['banosnova_komment'] ?? 'None' }}<br>
                                <strong>Date:</strong> {{ $ban['banfull_date'] ?? 'Unknown' }}
                            </div>
                            <hr>
                        @endforeach
                    @else
                        <span class="text-muted">No bans available.</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">No results found.</td>
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
    }

    .table th, .table td {
        padding: 12px;
        vertical-align: middle;
        border-top: 1px solid #dee2e6;
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
</style>
