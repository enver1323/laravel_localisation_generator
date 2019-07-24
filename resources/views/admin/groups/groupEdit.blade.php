@extends('admin.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit "{{$item->name}}" group</h1>
    </div>

    <form action="{{route('admin.groups.update', $item)}}" method="POST">
        @method('PATCH')
        <div class="row">
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Group:
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-4 col-lg-3">
                                <label for="groupName">Group Name</label>
                            </div>
                            <div class="col-md-8 col-lg-9">
                                <input type="text" class="form-control" id="groupName" name="name"
                                       value="{{$item->name}}" required>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4 col-lg-3">
                                <label for="groupDesc">Group Description</label>
                            </div>
                            <div class="col-md-8 col-lg-9">
                                <textarea class="form-control" id="groupDesc" name="description" required>
                                    {{$item->description}}
                                </textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Projects:
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col">
                                <span>Choose projects for group:</span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            @foreach($projects as $project)
                                <div class="col-md-4 col-lg-3">
                                    <strong>Project {{$project->id}}:</strong>
                                </div>
                                <div class="col-md-8 col-lg-9">
                                    <input type="checkbox" id="groupProject{{$project->id}}" name="projects[]"
                                           value="{{$project->id}}" {{$item->projects->contains($project) ? 'checked' : ''}}>
                                    <label class="ml-1" for="groupProject{{$project->id}}"> {{$project->name}}</label>
                                </div>
                            @endforeach
                        </div>
                        <input type="submit" class="btn btn-success btn-block" value="Update">
                    </div>
                </div>
            </div>
        </div>
        @csrf
    </form>
@endsection
@section('scripts')
    <script src="{{asset('js/admin/ckeditor/ckeditor.js')}}"></script>
    <script>
        CKEDITOR.replace('groupDesc');
    </script>
@endsection
