@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Excel Import and Export</h2>

    <!-- Back Button -->
    <a class="btn btn-outline-primary mb-4" href="{{ route('excel.excel_Index') }}">Back to Index</a>

    <!-- Import Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Import Excel File</h5>
        </div>
        <div class="card-body">
            <!-- Dropzone Form for uploading Excel file -->
            <form action="{{ route('excel.import') }}" method="POST" enctype="multipart/form-data" class="dropzone" id="my-dropzone">
                @csrf
                <div class="dz-message">
                    <h4>Drop Excel files here or click to upload.</h4>
                </div>
            </form>
            <!-- Import Button -->
            <button id="uploadButton" class="btn btn-success mt-3">Import Data</button>
        </div>
    </div>

    <!-- Export Section -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Export Data</h5>
        </div>
        <div class="card-body">
            <!-- Form for exporting data -->
            <form action="{{ route('excel.export') }}" method="GET">
                @csrf
                <div class="form-group">
                    <label for="columns">Select columns to export:</label>
                    <select name="columns[]" class="form-control" multiple size="10">
                        <option value="inn">INN</option>
                        <option value="company_name">Company Name</option>
                        <option value="mijoz_turi">Mijoz Turi</option>
                        <option value="shartnoma_raqami">Shartnoma Raqami</option>
                        <option value="shartnoma_sanasi">Shartnoma Sanasi</option>
                        <option value="payment_deadline">Payment Deadline</option>
                        <option value="tolov_sharti">Tolov Sharti</option>
                        <option value="tolov_muddati">Tolov Muddati</option>
                        <option value="first_payment_percent">First Payment Percent</option>
                        <option value="tuman_code">Tuman Code</option>
                        <option value="tuman">Tuman</option>
                        <option value="generate_price">Generate Price</option>
                        <option value="minimum_wage">Minimum Wage</option>
                        <option value="branch_kubmetr">Branch Kubmetr</option>
                        <!-- Add other columns as needed -->
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Export Data</button>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Bootstrap JS (if you're using Bootstrap) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

<!-- Dropzone JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.10.2/min/dropzone.min.js"></script>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>

<!-- Dropzone CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.10.2/dropzone.min.css">

<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">

<script>
    // Dropzone configuration
    Dropzone.options.myDropzone = {
        paramName: "file", // The name that will be used to transfer the file
        maxFilesize: 2, // MB
        acceptedFiles: ".xlsx",
        autoProcessQueue: false, // Prevent auto upload
        init: function() {
            var myDropzone = this;

            // Setup event listener for the import button
            document.getElementById('uploadButton').addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                myDropzone.processQueue(); // Manually trigger upload
            });

            // Handle successful uploads
            this.on("success", function(file, response) {
                toastr.success("File uploaded successfully."); // Show success toast
                console.log("File uploaded successfully.");
                // Optionally handle success response here
            });

            // Handle upload errors
            this.on("error", function(file, response) {
                toastr.error("Error uploading file."); // Show error toast
                console.error("Error uploading file.");
                // Optionally handle error response here
            });
        }
    };
</script>
@endsection
