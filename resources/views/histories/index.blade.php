@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Tarix Jurnali</h1>

        <!-- Filter and Search Form -->
        <form method="GET" action="{{ route('histories.index') }}" class="mb-4">
            <div class="d-flex flex-wrap mb-3">
                <!-- Model Type Filter -->
                <div class="form-group mb-2 me-2 flex-grow-1">
                    <label for="model_type" class="form-label">Model Turi bo'yicha Filtrlash:</label>
                    <select id="model_type" name="model_type" class="form-control">
                        <option value="">Hamma Modellar</option>
                        @foreach($modelTypes as $type)
                            <option value="{{ $type }}" {{ request('model_type') == $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- User Filter -->
                <div class="form-group mb-2 me-2 flex-grow-1">
                    <label for="user_id" class="form-label">Foydalanuvchi bo'yicha Filtrlash:</label>
                    <select id="user_id" name="user_id" class="form-control">
                        <option value="">Hamma Foydalanuvchilar</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Start Date Filter -->
                <div class="form-group mb-2 me-2 flex-grow-1">
                    <label for="start_date" class="form-label">Boshlanish Sanasi:</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>

                <!-- End Date Filter -->
                <div class="form-group mb-2 me-2 flex-grow-1">
                    <label for="end_date" class="form-label">Tugash Sanasi:</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>

                <!-- Search Input -->
                <div class="form-group mb-2 flex-grow-1">
                    <label for="search" class="form-label">Qidiruv:</label>
                    <input type="text" id="search" name="search" class="form-control" placeholder="Maydonlar bo'yicha qidirish..." value="{{ request('search') }}">
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Filtrlarni Qo'llash</button>
                <a href="{{ route('histories.index') }}" class="btn btn-secondary">Filtrlarni Qaytarish</a>
            </div>
        </form>

        <!-- History Table -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Model Turi</th>
                        <th>Model ID</th>
                        <th>Maydon</th>
                        <th>Eski Qiymat</th>
                        <th>Yangi Qiymat</th>
                        <th>Foydalanuvchi</th>
                        <th>Yaratilgan Sana</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($histories as $history)
                        <tr>
                            <td>{{ $history->id }}</td>
                            <td>{{ $history->model_type }}</td>
                            <td>{{ $history->model_id }}</td>
                            <td>{{ $history->field }}</td>
                            <td>{{ $history->old_value }}</td>
                            <td>{{ $history->new_value }}</td>
                            <td>{{ $history->user ? $history->user->name : 'N/A' }}</td>
                            <td>{{ $history->created_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Tarix yozuvlari topilmadi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Controls -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div>
                {{ $histories->links() }}
            </div>
            <div>
                {{ $histories->firstItem() }}-{{ $histories->lastItem() }} ko'rsatilmoqda, jami {{ $histories->total() }} ta yozuv mavjud
            </div>
        </div>
    </div>
@endsection
