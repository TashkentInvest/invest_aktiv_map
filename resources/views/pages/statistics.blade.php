@extends('layouts.admin')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">@lang('global.dashboard')</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">@lang('global.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('global.dashboard')</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">

    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-xl-4">
            <div class="card bg-primary bg-soft">
                <div>
                    <div class="row">
                        <div class="col-7">
                            <div class="text-primary p-3">
                                <h5 class="text-primary">Добро пожаловать обратно!</h5>
                                <p>Панель управления Tashkent Invest</p>

                                <ul class="ps-3 mb-0">
                                    <li class="py-1">Статистика компании</li>
                                    <li class="py-1"><a target="_blank"
                                            href="https://toshkentinvest.uz/">Toshkentinvest.uz</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-5 align-self-end">
                            <img src="assets/images/profile-img.png" alt="" class="img-fluid">
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="row">

                @foreach ($categoryCounts as $category)
                    <div class="col-sm-4 mb-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar-xs me-3">
                                        <span
                                            class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18">
                                            <i class="bx bx-copy-alt"></i>
                                        </span>
                                    </div>
                                    <h5 class="font-size-14 mb-0 text-truncate">{{ $category->name }}</h5>
                                </div>

                                <div class="text-muted mt-4 d-flex align-items-center">
                                    <h4 class="mb-0 me-2 text-secondary">Количества:</h4>
                                    <span class="fs-4 fw-bold text-dark">{{ $category->clients_count }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
            <!-- end row -->
        </div>
    </div>

    <div class="row">


        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <div class="col-xl-4">

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4"></h4>

                    <div>
                        <div id="donut-chart" data-colors='["--bs-primary", "--bs-success", "--bs-danger"]'
                            class="apex-charts">Отчёты</div>
                    </div>

                    <div class="text-left text-muted">
                        <div class="row">
                            <div class="col-12">
                                <div class="mt-4 d-flex justify-content-between">
                                    <p class="mb-2 text-truncate"><i class="mdi mdi-circle text-primary me-1"></i> Apz Olamaganlar
                                    </p>
                                    <h5>0</h5>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mt-4 d-flex justify-content-between">
                                    <p class="mb-2 text-truncate"><i class="mdi mdi-circle text-success me-1"></i> Ariza bermaganlar
                                    </p>
                                    <h5>0</h5>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mt-4 d-flex justify-content-between">
                                    <p class="mb-2 text-truncate"><i class="mdi mdi-circle text-danger me-1"></i> Kenashdan ruxsat olmaganlar
                                    </p>
                                    <h5>0</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card">
                <div class="p-4 border-bottom">
                    <div class="row">
                        <div class="col-md-4 col-9">
                            <h5 class="font-size-15 mb-1">Ташкент Инвест Чат</h5>
                            <p class="text-muted mb-0"><i
                                    class="mdi mdi-circle text-success align-middle me-1"></i>@lang('global.active')</p>
                        </div>
                    </div>
                </div>

                <div>
                    <div id="chat-conversation" class="chat-conversation p-3" style="height: 350px; overflow-y: auto;">
                        <ul class="list-unstyled mb-0" data-simplebar>
                            @php
                                $lastDate = null;
                            @endphp
                            @foreach ($messages as $message)
                                @php
                                    $messageDate = $message->created_at->format('Y-m-d');
                                @endphp
                                @if ($lastDate !== $messageDate)
                                    <li class="chat-day-title">
                                        <span class="title">{{ $message->created_at->format('F j, Y') }}</span>
                                    </li>
                                    @php
                                        $lastDate = $messageDate;
                                    @endphp
                                @endif
                                <li class="{{ $message->user->id === auth()->id() ? 'right' : '' }}">
                                    <div class="conversation-list">
                                        <div class="dropdown">
                                            <button class="btn btn-link dropdown-toggle" type="button"
                                                id="dropdownMenuButton-{{ $message->id }}" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu"
                                                aria-labelledby="dropdownMenuButton-{{ $message->id }}">
                                                {{-- <a class="dropdown-item" href="#">Copy</a> --}}
                                                <button class="dropdown-item edit-message" data-id="{{ $message->id }}"
                                                    data-message="{{ $message->message }}">Edit</button>
                                                <form action="{{ route('chat.destroy', $message->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="ctext-wrap">
                                            <div class="conversation-name">{{ $message->user->name }}</div>
                                            <p>{{ $message->message }}</p>
                                            <p class="chat-time mb-0">
                                                <i class="bx bx-time-five align-middle me-1"></i>
                                                {{ $message->created_at->format('H:i') }}
                                                @if ($message->updated_at != $message->created_at)
                                                    <span class="badge bg-info text-dark">Edited</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="p-3 chat-input-section">
                        <form action="{{ route('chat.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <div class="position-relative">
                                        <input type="text" name="message" class="form-control chat-input"
                                            placeholder="@lang('global.new_message')">
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button type="submit"
                                        class="btn btn-primary btn-rounded chat-send w-md waves-effect waves-light">
                                        <span class="d-none d-sm-inline-block me-2">@lang('global.send')</span>
                                        <i class="mdi mdi-send"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

    <!-- end row -->

    <div class="modal fade" id="editMessageModal" tabindex="-1" aria-labelledby="editMessageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editMessageForm" action="{{ route('chat.update', 0) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editMessageModalLabel">Edit Message</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="message_id" id="editMessageId">
                        <div class="mb-3">
                            <label for="editMessage" class="form-label">Message</label>
                            <textarea class="form-control" id="editMessage" name="message" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <!-- apexcharts -->
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- saas dashboard init -->
    <script src="{{ asset('assets/js/pages/saas-dashboard.init.js') }}"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var chatConversation = document.getElementById('chat-conversation');
            chatConversation.scrollTop = chatConversation.scrollHeight;

            document.querySelectorAll('.edit-message').forEach(button => {
                button.addEventListener('click', function() {
                    var messageId = this.getAttribute('data-id');
                    var messageText = this.getAttribute('data-message');

                    document.getElementById('editMessageId').value = messageId;
                    document.getElementById('editMessage').value = messageText;

                    var formAction = '{{ route('chat.update', 0) }}';
                    formAction = formAction.replace('0', messageId);
                    document.getElementById('editMessageForm').action = formAction;

                    var editModal = new bootstrap.Modal(document.getElementById(
                    'editMessageModal'), {});
                    editModal.show();
                });
            });
        });
    </script>
@endsection
