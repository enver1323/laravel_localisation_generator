@extends('admin.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Export "{{$item->name}}" project</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"></h6>
        </div>
        <div class="card-body">
            <form action="{{route('admin.projects.export.file', $item)}}" method="POST">
                <div class="row mb-4">
                    <div class="col">
                        <strong>Name: </strong>
                        <span>{{$item->name}}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col">
                        <strong class="mb-2">Description: </strong>
                        {!! $item->description!!}
                    </div>
                </div>
                @if($item->groups()->count())
                    <hr>
                    <div class="row my-4">
                        <div class="col">
                            <strong>Groups ({{$item->groups->count()}}): </strong>
                        </div>
                    </div>
                    @foreach($item->groups as $group)
                        <div class="row my-4">
                            <div class="col">
                                <strong>ID - {{$group->id}}: </strong>
                                <span>Name - {{$group->name}}</span>
                            </div>
                        </div>
                    @endforeach
                @endif
                <hr>

                <div class="row mb-4">
                    <div class="col-md-3 col-lg-2">
                        <label>Choose languages to export</label>
                    </div>
                    <div class="col-md-9 col-lg-10">
                        <div class="col-md-8 col-lg-6 p-0" id="groupsContainer">
                            @foreach($languages as $language)
                                <div class="form-check">
                                    <input class="form-check-input" id="language-{{$language->code}}"
                                           name="languages[]" value="{{$language->code}}"
                                           type="checkbox" checked>
                                    <label for="language-{{$language->code}}">{{$language->name}} language</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3 col-lg-2">
                        <label for="exportType">Choose type to export</label>
                    </div>
                    <div class="col-md-9 col-lg-10">
                        <div class="col-md-8 col-lg-6 p-0">
                            <select name="type" id="exportType" class="form-control">
                                <option value="json">
                                    JSON
                                </option>
                                <option value="archive">
                                    Archive
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <input type="submit" class="btn btn-success" value="Export">
                @csrf
            </form>
        </div>
    </div>
@endsection
