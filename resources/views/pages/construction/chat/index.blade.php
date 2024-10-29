@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Chat</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('construction.index') }}"
                            style="color: #007bff;">@lang('global.home')</a></li>
                    <li class="breadcrumb-item active">Chat</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="d-lg-flex">
    <div class="w-100 user-chat">
        <div class="card">
            <div class="p-4 border-bottom">
                <div class="row">
                    <div class="col-md-4 col-9">
                        <h5 class="font-size-15 mb-1">Ташкент Инвест Чат</h5>
                        <p class="text-muted mb-0"><i class="mdi mdi-circle text-success align-middle me-1"></i>@lang('global.active')</p>
                    </div>
                </div>
            </div>

            <div>
                <div id="chat-conversation" class="chat-conversation p-3" style="height: 500px; overflow-y: auto;">
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
                                        <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton-{{ $message->id }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton-{{ $message->id }}">
                                            {{-- <a class="dropdown-item" href="#">Copy</a> --}}
                                            <button class="dropdown-item edit-message" data-id="{{ $message->id }}" data-message="{{ $message->message }}">Edit</button>
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
                                    <input type="text" name="message" class="form-control chat-input" placeholder="@lang('global.new_message')">
                                </div>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary btn-rounded chat-send w-md waves-effect waves-light">
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

<!-- Edit Modal -->
<div class="modal fade" id="editMessageModal" tabindex="-1" aria-labelledby="editMessageModalLabel" aria-hidden="true">
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

                var editModal = new bootstrap.Modal(document.getElementById('editMessageModal'), {});
                editModal.show();
            });
        });
    });
</script>
@endsection
