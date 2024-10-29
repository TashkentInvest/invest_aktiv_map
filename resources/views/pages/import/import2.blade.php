@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">@lang('cruds.transaction.title')</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: #007bff;">@lang('global.home')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('import') }}" style="color: #007bff;">Transactions</a></li>
                        <li class="breadcrumb-item active">@lang('global.add')</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">@lang('cruds.transaction.fields.import')</h4>
                    <form action="{{ route('import_credit.xls') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row mb-4">
                            <label for="projectname" class="col-form-label col-lg-2">@lang('cruds.transaction.fields.name')</label>
                            <div class="col-lg-7">
                                <input id="projectname" name="name" type="text" class="form-control form-control-lg" placeholder="@lang('cruds.transaction.fields.import')...">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="projectdesc" class="col-form-label col-lg-2">@lang('cruds.transaction.fields.description')</label>
                            <div class="col-lg-7">
                                <textarea class="form-control form-control-lg" id="description" name="description" rows="3" placeholder="@lang('cruds.transaction.fields.description')..."></textarea>
                            </div>
                        </div>

                        {{-- <div class="row mb-4">
                            <label class="col-form-label col-lg-2">Transaction Date</label>
                            <div class="col-lg-7">
                                <div class="input-daterange input-group" >
                                    <input type="date" class="form-control form-control-lg" placeholder="Start Date" name="start_date" required/>
                                    <input type="date" class="form-control form-control-lg" placeholder="End Date" name="end_date" required/>
                                </div>
                            </div>
                        </div> --}}

                        <div class="row mb-4">
                            <label class="col-form-label col-lg-2">@lang('global.import_data')</label>

                            <div class="col-lg-7">
                                <div class="fallback">
                                    <label>@lang('cruds.transaction.fields.credit')</label>
                                    <input class="form-control form-control-lg" name="credit_excel_file" type="file" multiple />
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-lg-10">
                                <button type="submit" class="btn btn-primary">@lang('global.import_data')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
