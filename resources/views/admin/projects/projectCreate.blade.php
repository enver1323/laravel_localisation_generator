@extends('admin.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">New Project</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"></h6>
        </div>
        <div class="card-body">
            <form action="{{route('admin.projects.store')}}" method="POST">
                <div class="row mb-4">
                    <div class="col-md-3 col-lg-2">
                        <label for="projectName">Project Name</label>
                    </div>
                    <div class="col-md-9 col-lg-10">
                        <input type="text" class="form-control col-md-8 col-lg-6" id="projectName" name="name" required>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-3 col-lg-2">
                        <label for="projectDesc">Project Description</label>
                    </div>
                    <div class="col-md-9 col-lg-10">
                        <textarea class="form-control col-md-8 col-lg-6" id="projectDesc" name="description" required>
                        </textarea>
                    </div>
                </div>
                <input type="submit" class="btn btn-success" value="Save">
                @csrf
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('js/admin/ckeditor/ckeditor.js')}}"></script>
    <script>
        CKEDITOR.replace('projectDesc');
    </script>
@endsection
