@extends('layouts.admin')

@section('content')
<div class="pc-content">
    <!-- [ Breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="">Asosiy sahifa</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0)">Arizalar</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Ariza Arxivi 
                        </li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Ariza Arxivi</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Breadcrumb ] end -->

    <!-- [ Main Content ] start -->
    <div class="row">
        <!-- [ Client Profile ] start -->
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client ID</th>
                    <th>Client Name</th>
                    <th>Action</th>
                    <th>Timestamp</th>
                    <th>Performed By</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->branch->id }}</td>
                        <td>{{ $order->branch->client->id }}</td>
                        <td>{{ $order->branch->client->last_name }} {{ $order->branch->client->father_name }} {{ $order->branch->client->first_name }}</td>
                        <td>{{ ucfirst($order->branch->action) }}</td>
                        <td>{{ $order->branch->action_timestamp }}</td>
                        <td>{{ $order->branch->user_id ? \App\Models\User::find($order->branch->user_id)->name : 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- [ Client Profile ] end -->
    </div>
    <!-- [ Main Content ] end -->
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/libs/admin-resources/rwd-table/rwd-table.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/table-responsive.init.js') }}"></script>
@endsection
