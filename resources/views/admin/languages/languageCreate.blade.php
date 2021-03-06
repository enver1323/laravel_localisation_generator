@extends('admin.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">New Language</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"></h6>
        </div>
        <div class="card-body">
            <form action="{{route('admin.languages.store')}}" method="POST">
                <div class="row mb-4">
                    <div class="col-md-3 col-lg-2">
                        <label for="langCode">Language Code</label>
                    </div>
                    <div class="col-md-9 col-lg-10">
                        <input type="text" maxlength="2" class="form-control col-md-8 col-lg-6" id="langCode" name="code" required>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-3 col-lg-2">
                        <label for="langName">Language Name</label>
                    </div>
                    <div class="col-md-9 col-lg-10">
                        <input type="text" class="form-control col-md-8 col-lg-6" id="langName" name="name" required>
                    </div>
                </div>
                <input type="submit" class="btn btn-success" value="save">
                @csrf
            </form>
        </div>
    </div>
@endsection
