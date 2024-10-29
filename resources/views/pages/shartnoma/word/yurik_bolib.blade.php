@extends('layouts.admin')
@section('content')
        <div class="row">
            <div class="col-sm-9">
                <div class="card">

                    <div class="col-md-12 ">
                        <div class="card">
                            <div class="card-header">
                                <h5>Blockquotes</h5>
                            </div>
                            <div class="card-body pc-component">
                               @include('pages.shartnoma.inc.__yurik_bolib')
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">

                    <div class="col-md-12 ">
                        @include('pages.shartnoma.shartnoma_sidebar')
                    </div>

                </div>
            </div>
        </div>
@endsection