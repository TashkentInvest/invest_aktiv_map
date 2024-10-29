@extends('layouts.admin')
@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0)">E-commerce</a></li>
                        <li class="breadcrumb-item" aria-current="page">Yuridik shaxs uchun</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Yuridik shaxs uchun</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id='myForm' action="{{ route('create_yuridik_client') }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('inc.__yurik_subyekt')
    </form>
@endsection
