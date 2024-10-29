@extends('layouts.admin')
@section('content')

<h5>
    Jismoniy shaxs qo'shish
</h5>
 

<form id="myForm" action="{{ route('obyekt_create_fizik_client') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="modal-body">
        @include('inc.__fizik_subyekt')
    </div>
    <div class="modal-footer d-flex">
        <button type="submit" class="btn btn-primary">@lang('global.submit')</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('global.cancel')</button>
    </div>
</form>
@endsection