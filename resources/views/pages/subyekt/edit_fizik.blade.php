@extends('layouts.admin')
@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0)">E-commerce</a></li>
                        <li class="breadcrumb-item" aria-current="page">Jismoniy shaxsni o'zgartirish uchun </li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Jismoniy shaxsni o'zgartirish uchun </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <!-- [ Main Content ] start -->
    <form id='myForm' action="{{ route('update_fizik_client', ['id' => $client->id]) }}" method="post"
        enctype="multipart/form-data">
        @csrf
        @include('inc.__fizikEdit_subyekt')
    </form>
@endsection
