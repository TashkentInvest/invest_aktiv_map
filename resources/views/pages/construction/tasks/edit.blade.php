@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Edit</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Project</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Edit Project</h4>
                    <form action="{{ route('construction.update', $construction->id) }}" method="post">
                        @csrf
                        @method('PUT')



                        @foreach ($construction->branches as $branchIndex => $b)
                            <input type="hidden" name="accordions[{{ $branchIndex }}][id]" value="{{ $b->id }}">

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="contract_apt">@lang('global.ruxsatnoma_raqami')</label>
                                        <input type="text" class="form-control"
                                            name="accordions[{{ $branchIndex }}][contract_apt]"
                                            value="{{ old('accordions.' . $branchIndex . '.contract_apt', $b->contract_apt) }}"
                                            placeholder="@lang('global.ruxsatnoma_raqami')">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="contract_date">@lang('global.sanasi')</label>
                                        <input class="form-control" type="date"
                                            name="accordions[{{ $branchIndex }}][contract_date]"
                                            value="{{ old('accordions.' . $branchIndex . '.contract_date', $b->contract_date) }}">

                                    </div>
                                </div>

                                <div class="col lg-6">
                                    <label for="projectname" class="col-form-label">Apz raqami</label>
                                    <input id="projectname" name="accordions[{{ $branchIndex }}][apz_raqami]"
                                        type="text" class="form-control"
                                        value="{{ old('accordions.' . $branchIndex . '.apz_raqami', $b->apz_raqami) }}"
                                        placeholder="Enter Project Name...">
                                </div>
                                <div class="col lg-6">
                                    <label for="projectname" class="col-form-label">Apz sanasi</label>
                                    <input id="projectname" name="accordions[{{ $branchIndex }}][apz_sanasi]"
                                        type="date" class="form-control"
                                        value="{{ old('accordions.' . $branchIndex . '.apz_sanasi', $b->apz_sanasi) }}"
                                        placeholder="Enter Project Name...">
                                </div>

                                <div class="col-12">
                                    <textarea class="w-100 my-3 form-control" name="accordions[{{ $branchIndex }}][kengash]" id="" cols="30"
                                        rows="10" placeholder="Kengash xulosa">
                                        {{ old('accordions.' . $branchIndex . '.kengash', $b->kengash) }}"
                                    </textarea>

                                </div>
                            </div>
                        @endforeach

                        <button type="submit" class="btn btn-primary">submit</button>
                    </form>


                    {{-- update end ************************************ --}}

                </div>

            </div>
        </div>
    </div>
    </div>
@endsection
