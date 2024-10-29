@extends('layouts.admin')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.0/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.1/spectrum.min.css">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">@lang('cruds.construction.text')</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('construction.index') }}"
                                style="color: #007bff;">@lang('global.home')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('cruds.construction.title')</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <div class="search-box me-2 mb-2 d-inline-block">
                                <div class="position-relative">
                                    <form action="{{ route('construction.index') }}" method="GET">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="@lang('global.search')"
                                                name="search" value="{{ request('search') }}">
                                            <i class="bx bx-search-alt search-icon"></i>

                                            <button class="btn btn-outline-secondary"
                                                type="submit">@lang('global.search')</button>
                                        </div>
                                    </form>
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered dt-responsive w-100">
                            <thead>
                                <tr>
                                    <th>@lang('global.id')</th>
                                    <th>@lang('global.client_name') / @lang('cruds.company.fields.company_name')</th>
                                    <th>@lang('cruds.client.fields.contact')</th>
                                    <th style="width: 20%;">@lang('cruds.company.fields.address')</th>
                                    <th>@lang('cruds.company.fields.stir')</th>
                                    <th>@lang('cruds.branches.fields.apz_number')</th>
                                    <th>@lang('global.ruxsatnoma_raqami')</th>
                                    <th>Yo'nalish</th>
                                    <th style="width: 100px;">@lang('global.actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($constructions as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>

                                        @if ($item->mijoz_turi == 'fizik')
                                            <td>{{ $item->last_name }} {{ $item->first_name }} {{ $item->father_name }}</td>
                                        @else
                                            <td>{{ $item->company->company_name }}</td>
                                        @endif

                                        <td>{{ $item->contact ?? '---' }}</td>

                                        @if ($item->mijoz_turi == 'fizik')
                                            <td>{{ $item->address->home_address }}</td>
                                        @else
                                            <td>{{ $item->address->yuridik_address }}</td>
                                        @endif

                                        <td>{{ $item->company->stir }}</td>

                                     
                                        <td>
                                            @foreach ($item->branches as $b)
                                                @isset($b->apz_raqami)
                                                    <button type="button" class="btn btn-secondary my-1 d-flex btn-sm w-xs waves-effect waves-light">
                                                        {{$b->apz_raqami}} 
                                                    </button>
                                                @endisset
                                            @endforeach
                                        </td>
                                        
                                        <td>
                                            @foreach ($item->branches as $b)
                                                @isset($b->application_number)
                                                    <button type="button" class="btn btn-secondary my-1 d-flex btn-sm w-xs waves-effect waves-light">
                                                        {{$b->application_number}} 
                                                    </button>
                                                @endisset
                                            @endforeach
                                        </td>
                                        
    
                                        <td>{{$item->category->name ?? ''}} </td>

                                        <td class="text-center">
                                            <form action="{{ route('clientDestroy', $item->id) }}" method="post">
                                                @csrf
                                                <ul class="list-unstyled hstack gap-1 mb-0">
                                                    <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="@lang('global.view')">
                                                        <a href="{{ route('construction.show', $item->id) }}"
                                                            class="btn btn-success">
                                                            <i class="bx bxs-edit" style="font-size:16px;"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $constructions->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modals for Notifications -->
    @php
        $modalIndex = 0;
    @endphp

    {{-- @dd(auth()->user()->view->status) --}}

    @if (auth()->user()->roles[0]->name == 'Qurilish')
        @foreach ($constructions as $notification)
            @foreach ($notification->branches as $b)
                @php
                    $modalIndex++;
                @endphp
                <div class="modal fade" id="notificationModal{{ $modalIndex }}" tabindex="-1"
                    aria-labelledby="notificationModalLabel{{ $modalIndex }}" aria-hidden="true"
                    data-bs-backdrop="static" data-bs-keyboard="false">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold" id="notificationModalLabel{{ $modalIndex }}">
                                    <strong>@lang('global.contract_details') - {{ $b->contract_apt }}</strong>
                                </h5>
                                {{-- Remove the close button --}}
                            </div>
                            <div class="modal-body">
                                <table class="table table-striped table-bordered">
                                    <tbody style="font-size: 1.25em;"> <!-- Increased font size -->
                                        <tr>
                                            <td><strong>@lang('global.ruxsatnoma_raqami')</strong></td>
                                            <td colspan="2">{{ $b->contract_apt }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>@lang('global.created_at')</strong></td>
                                            <td colspan="2">{{ $b->contract_date }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>@lang('cruds.branches.fields.application_number')</strong></td>
                                            <td colspan="2">{{ $b->application_number }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>@lang('global.loyiha_nomi')</strong></td>
                                            <td colspan="2">{{ $b->branch_type }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>@lang('cruds.company.fields.branch_type')</strong></td>
                                            <td colspan="2">{{ $b->branch_type }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>@lang('cruds.company.fields.branch_location')</strong></td>
                                            <td colspan="2">{{ $b->branch_location }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>@lang('global.obyekt_boyicha_tolanishi_lozim') ( m³ )</strong></td>
                                            <td colspan="2">{{ number_format($b->branch_kubmetr, 1) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>@lang('global.jami_tolanishi_kerak')</strong></td>
                                            <td colspan="2" class="formatted-number">{{ $b->generate_price }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>@lang('global.bolib_tolash_foizi_oldindan')</strong></td>
                                            <td colspan="2">{{ $b->percentage_input }}%</td>
                                        </tr>
                                        <tr>
                                            <td><strong>@lang('global.quarterly_payment')</strong></td>
                                            <td colspan="2">{{ $b->installment_quarterly }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>@lang('global.bolib_tolash')</strong></td>
                                            <td colspan="2">
                                                @if ($b->payment_type == 'pay_bolib')
                                                    @lang('global.pay_bolib')
                                                @else
                                                    @lang('global.pay_full')
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>@lang('cruds.branches.fields.payed_sum')</strong></td>
                                            <td colspan="2" class="formatted-number">{{ $b->payed_sum }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>@lang('cruds.branches.fields.payed_date')</strong></td>
                                            <td colspan="2">{{ $b->payed_date }}</td>
                                        </tr>

                                        {{--  Platejka start--}}
                                        {{-- @foreach ($files as $file)
                                        <div class="py-1">
                                            <a target="_blank" class="py-2 my-2"
                                                href="{{ asset($file->path) }}">{{ $file->path }}</a>
                                            @can('client.delete')
                                                Delete
                                                <input type="checkbox" name="delete_files[]"
                                                    value="{{ $file->id }}">
                                            @endcan
                                        </div>
                                    @endforeach --}}
                                    <h4>Pinned payment file</h4>
                                    @foreach ($notification->files as $file)
                                    @if (preg_match('/^assets\/payment\/.+$/', $file->path))
                                        <div class="py-1">
                                            <a target="_blank" class="py-2 my-2" href="{{ asset($file->path) }}">{{ $file->path }}</a>
                                        </div>
                
                
                                    @endif
                                @endforeach

                                        {{--  Platejka end--}}
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <form action="{{ route('updateStatus') }}" method="post" class="update-status-form">
                                    @csrf
                                    <input type="hidden" name="branch_id" value="{{ $b->id }}">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-lg">@lang('global.confirmation')</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach

        <script>
            function formatNumberWithSpaces(number) {
                return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
            }

            document.addEventListener('DOMContentLoaded', function() {
                var elements = document.querySelectorAll('.formatted-number');
                elements.forEach(function(element) {
                    element.textContent = formatNumberWithSpaces(element.textContent);
                });
            });
        </script>
    @endif




    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.1/spectrum.min.js"></script>
    <script>
        $(document).ready(function() {
            let modalIndex = 1;
            const totalModals = {{ $modalIndex }};

            function showNextModal() {
                if (modalIndex <= totalModals) {
                    $(`#notificationModal${modalIndex}`).modal('show');
                }
            }

            $('.update-status-form').on('submit', function(e) {
                e.preventDefault();
                let form = $(this);
                let modal = form.closest('.modal');

                $.ajax({
                    type: form.attr('method'),
                    url: form.attr('action'),
                    data: form.serialize(),
                    success: function(response) {
                        if (response.success) {
                            modal.modal('hide');
                            modalIndex++;
                            showNextModal();
                        }
                    },
                    error: function(response) {
                        // Handle error
                    }
                });
            });

            // Start the sequence
            showNextModal();
        });
    </script>
@endsection
