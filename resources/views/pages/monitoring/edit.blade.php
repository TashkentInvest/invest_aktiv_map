@extends('layouts.admin')

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0)">E-commerce</a></li>
                        <li class="breadcrumb-item" aria-current="page">Monitoring</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Monitoring</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Shartnoma -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body">
                    <h6 class="card-title">Shartnoma</h6>
                    <form action="{{ route('shartnoma.update', $monitoring->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="shartnoma_raqami">Raqami</label>
                            <input type="text" class="form-control" id="shartnoma_raqami" name="shartnoma_raqami" value="{{ $monitoring->shartnoma_raqami }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="shartnoma_sanasi">Sanasi</label>
                            <input type="date" class="form-control" id="shartnoma_sanasi" name="shartnoma_sanasi" value="{{ $monitoring->shartnoma_sanasi ? $monitoring->shartnoma_sanasi->format('Y-m-d') : '' }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Shartnoma</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Apz -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body">
                    <h6 class="card-title">Apz</h6>
                    <form action="" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="ariza-raqami">Ariza Raqami</label>
                            <input type="text" class="form-control" id="ariza-raqami" name="ariza_raqami" value="{{ $apz->ariza_raqami }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="ariza-sanasi">Ariza Sanasi</label>
                            <input type="date" class="form-control" id="ariza-sanasi" name="ariza_sanasi" value="{{ $apz->ariza_sanasi->format('Y-m-d') }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="art-raqami">ART Raqami</label>
                            <input type="text" class="form-control" id="art-raqami" name="art_raqami" value="{{ $apz->art_raqami }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="art-sanasi">ART Sanasi</label>
                            <input type="date" class="form-control" id="art-sanasi" name="art_sanasi" value="{{ $apz->art_sanasi->format('Y-m-d') }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="xulosa_izoh">Izoh</label>
                            <textarea name="xulosa_izoh" class="form-control" id="xulosa_izoh" cols="30" rows="3">{{ $apz->xulosa_izoh }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Apz</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Kengash -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body">
                    <h6 class="card-title">Kengash</h6>
                    <form action="" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="kengash-ariza-raqami">Kengash Ariza Raqami</label>
                            <input type="text" class="form-control" id="kengash-ariza-raqami" name="ariza_raqami" value="{{ $kengash->ariza_raqami }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="kengash-bayon-raqami">Kengash Bayon Raqami</label>
                            <input type="text" class="form-control" id="kengash-bayon-raqami" name="bayon_raqami" value="{{ $kengash->bayon_raqami }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="kengash-bayon-sanasi">Kengash Bayon Sanasi</label>
                            <input type="date" class="form-control" id="kengash-bayon-sanasi" name="bayon_sanasi" value="{{ $kengash->bayon_sanasi->format('Y-m-d') }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="kengash-bayon-izoh">Kengash Bayon Izoh</label>
                            <textarea name="bayon_izoh" class="form-control" id="kengash-bayon-izoh" cols="30" rows="3">{{ $kengash->bayon_izoh }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="kengash-raqami">Kengash Xulosa Raqami</label>
                            <input type="text" class="form-control" id="kengash-raqami" name="xulosa_raqami" value="{{ $kengash->xulosa_raqami }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="kengash-sanasi">Kengash Xulosa Sanasi</label>
                            <input type="date" class="form-control" id="kengash-sanasi" name="xulosa_sanasi" value="{{ $kengash->xulosa_sanasi->format('Y-m-d') }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="kengash-izoh">Izoh</label>
                            <textarea name="xulosa_izoh" class="form-control" id="kengash-izoh" cols="30" rows="3">{{ $kengash->xulosa_izoh }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Kengash</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Ekspertiza -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body">
                    <h6 class="card-title">Ekspertiza</h6>
                    <form action="" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="expertiza-raqami">Raqami</label>
                            <input type="text" class="form-control" id="expertiza-raqami" name="raqami" value="{{ $expertiza->raqami }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="expertiza-sanasi">Sanasi</label>
                            <input type="date" class="form-control" id="expertiza-sanasi" name="sanasi" value="{{ $expertiza->sanasi->format('Y-m-d') }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="tashkilot-nomi">Tashkilot Nomi</label>
                            <input type="text" class="form-control" id="tashkilot-nomi" name="tashkilot_nomi" value="{{ $expertiza->tashkilot_nomi }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="masul-shaxs">Masul Shaxs</label>
                            <input type="text" class="form-control" id="masul-shaxs" name="masul_shaxs" value="{{ $expertiza->masul_shaxs }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Ekspertiza</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
