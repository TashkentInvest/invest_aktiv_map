@extends('layouts.admin')

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href=>Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0)">E-commerce</a></li>
                        <li class="breadcrumb-item" aria-current="page">Obyektlar</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Obyektlar</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <!-- [ Main Content ] start -->
    <div class="row">
        <!-- [ branches-page ] start -->
        <div class="col-sm-12">
            <div class="card table-card">
                <div class="card-body">

                    <div class="text-end p-sm-4 pb-sm-2">
                        <a href="{{ route('obyekt.add') }}" class="btn btn-primary">
                            <i class="ti ti-plus f-18"></i> Obyekt Yaratish
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover tbl-product" id="pc-dt-simple">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Ruxsatnoma Kim tamonidan</th>
                                    <th>Binoning umumiy xajmi</th>
                                    <th>Ruxsatnoma turi</th>
                                    <th>Manzil</th>

                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($branches as $branch)
                                {{-- @dump($branch->ruxsatnoma->ruxsatnomaKimTamonidan->name) --}}
                                    <tr>
                                        <td>{{ $branch->id }}</td>
                                        <td>{{ $branch->ruxsatnoma->ruxsatnomaKimTamonidan->name ?? 'N/A' }}</td>
                                        <td>{{ $branch->loyihaHajmiMalumotnoma->branch_kubmetr ?? 'N/A' }}</td>
                                        <td>{{ $branch->ruxsatnoma->ruxsatnomaTuri->name ?? 'N/A' }}</td>
                                        <td>{{ $branch->substreet->name ?? 'N/A' }}</td>
                                        
                                        <td class="text-center">
                                            <div class="prod-action-links">
                                                <ul class="list-inline me-auto mb-0">
                                                    <li class="list-inline-item align-bottom" data-bs-toggle="tooltip"
                                                        title="View">
                                                        <a href="{{ route('branches.show', $branch->id) }}"
                                                            class="avtar avtar-xs btn-link-secondary btn-pc-default">
                                                            <i class="ti ti-eye f-18"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item align-bottom" data-bs-toggle="tooltip"
                                                        title="Edit">
                                                        <a href="{{ route('branches.edit', $branch->id) }}"
                                                            class="avtar avtar-xs btn-link-success btn-pc-default">
                                                            <i class="ti ti-edit-circle f-18"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item align-bottom" data-bs-toggle="tooltip"
                                                        title="Delete">
                                                        <form action="{{ route('branches.destroy', $branch->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" onclick="return confirm('Are you sure?')"
                                                                class="avtar avtar-xs btn-link-danger btn-pc-default">
                                                                <i class="ti ti-trash f-18"></i>
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {!! $branches->links() !!} <!-- Pagination links -->
                    </div>
                </div>
            </div>
        </div>
        <!-- [ branches-page ] end -->
    </div>
@endsection
