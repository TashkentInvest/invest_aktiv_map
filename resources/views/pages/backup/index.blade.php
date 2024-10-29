@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Backups</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: #007bff;">@lang('global.home')</a>
                        </li>
                        <li class="breadcrumb-item active">Backups</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="d-xl-flex">
        <div class="w-100">
            <div class="d-md-flex">
                <div class="card filemanager-sidebar me-md-2">
                    <div class="card-body">
                        <div class="d-flex flex-column h-100">
                            <div class="mb-4">
                                <ul class="list-unstyled categories-list">
                                    <li>
                                        <div class="text-center" style="position: relative;">
                                            <h5 class="font-size-15 mb-4">Storage</h5>
                                            <div class="apex-charts" id="radial-chart"
                                                data-colors="[&quot;--bs-primary&quot;]" style="min-height: 66px;">
                                                <div id="apexchartss7urv6zhh"
                                                    class="apexcharts-canvas apexchartss7urv6zhh apexcharts-theme-light"
                                                    style="width: 190px; height: 66px;"></div>
                                            </div>
                                            <p class="text-muted mt-4">Total Storage Size: {{ $totalSizeFormatted }} bytes
                                            </p>
                                            <div class="resize-triggers">
                                                <div class="expand-trigger">
                                                    <div style="width: 191px; height: 53px;"></div>
                                                </div>
                                                <div class="contract-trigger"></div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a id="delete-selected-btn" class="text-body d-flex align-items-center"
                                            style="cursor: pointer">
                                            <span class="me-auto">Delete Selected</span>
                                            <i class="feather icon-trash-2" style="color: red; font-size:18px;"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- filemanager-leftsidebar -->
                <div class="w-100">
                    <div class="card">
                        <div class="card-body">

                            <div class="mt-4">
                                <div class="d-flex flex-wrap">
                                    <h5 class="font-size-16 me-3">Backup Files</h5>
                                </div>
                                <hr class="mt-2">

                                <div class="table-responsive">
                                    <table class="table align-middle table-nowrap table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">Select</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Date modified</th>
                                                <th scope="col">Size</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($backupDetails as $backup)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" name="filenames[]"
                                                            value="{{ basename($backup['file']) }}">
                                                    </td>
                                                    <td>
                                                        <a href="javascript:void(0);" class="text-dark fw-medium">
                                                            <i
                                                                class="mdi mdi-text-box font-size-16 align-middle text-muted me-2"></i>
                                                            {{ basename($backup['file']) }}
                                                        </a>
                                                    </td>
                                                    <td>{{ date('Y-m-d H:i:s', $backup['creation_date']) }}</td>
                                                    <td>{{ round($backup['size'] / 1024, 2) }} KB</td>


                                                    <td class="d-flex">
                                                        <a href="{{ route('backup.download', basename($backup['file'])) }}"
                                                            class="btn btn-sm btn-light-success me-1"><i
                                                                class="feather icon-file"></i></a>

                                                        <form
                                                            action="{{ route('backup.delete', basename($backup['file'])) }}"
                                                            method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item">
                                                                <button type="submit" class="btn btn-sm btn-light-danger"><i
                                                                        class="feather icon-trash-2"></i></button>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card -->
                </div>
                <!-- end w-100 -->
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        var totalSize = "{{ $totalSizeFormatted }}";

        totalSize = parseFloat(totalSize.replace(/[^0-9.]/g, ''));

        var options = {
            series: [totalSize],
            chart: {
                type: 'radialBar',
                height: 200,
            },
            plotOptions: {
                radialBar: {
                    hollow: {
                        size: '50%',
                    },
                    dataLabels: {
                        showOn: 'always',
                        name: {
                            offsetY: -10,
                            show: true,
                            color: '#888',
                            fontSize: '13px',
                        },
                        value: {
                            color: '#111',
                            fontSize: '16px',
                            formatter: function(val) {
                                return val + '%';
                            }
                        }
                    }
                }
            },
            fill: {
                colors: ['#2196F3'],
            },
            labels: ['Storage'],
        };

        var chart = new ApexCharts(document.querySelector("#apexchartss7urv6zhh"), options);
        chart.render();
    </script>

    <script>
        $(document).ready(function() {
            $('#delete-selected-btn').click(function() {
                var selectedFiles = [];
                $('input[name="filenames[]"]:checked').each(function() {
                    selectedFiles.push($(this).val());
                });
                if (selectedFiles.length > 0) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You are about to delete ' + selectedFiles.length + ' file(s).',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('backup.deleteAll') }}",
                                method: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    filenames: selectedFiles
                                },
                                success: function(response) {
                                    Swal.fire(
                                        'Deleted!',
                                        response.message,
                                        'success'
                                    ).then((result) => {
                                        location
                                            .reload(); // Refresh the page after deletion
                                    });
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire(
                                        'Error!',
                                        'An error occurred while deleting files.',
                                        'error'
                                    );
                                    console.error(error);
                                }
                            });
                        }
                    });
                } else {
                    Swal.fire(
                        'No files selected!',
                        'Please select at least one file to delete.',
                        'warning'
                    );
                }
            });
        });
    </script>
@endsection
