@extends('admin.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Translation {{$item->key}}</h1>
        <div class="div">
            <a href="{{route('admin.translations.edit', $item)}}" class="btn btn-warning shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit
            </a>
            <button class="btn btn-danger shadow-sm" onclick="document.getElementById('destroy-form').submit()">
                <i class="fas fa-trash fa-sm text-white-50"></i> Delete
            </button>
            <a href="{{route('admin.translations.create')}}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> New
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"></h6>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col">
                    <strong>ID: </strong>
                    <span>{{$item->id}}</span>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col">
                    <strong>Key: </strong>
                    <span>{{$item->key}}</span>
                </div>
            </div>
            @if($item->entries()->count())
                <div class="row my-4">
                    <div class="col">
                        <strong>Entries ({{$item->entries->count()}}): </strong>
                    </div>
                </div>
                @foreach($item->entries as $entry)
                    <div class="row my-4">
                        <div class="col">
                            <strong>{{$entry->language_code}}: </strong>
                            <span>{{$entry->entry}}</span>
                        </div>
                    </div>
                @endforeach
            @endif
            @if($item->groups()->count())
                <div class="row my-4">
                    <div class="col">
                        <strong>Groups ({{$item->groups->count()}}): </strong>
                    </div>
                </div>
                @foreach($item->groups as $group)
                    <div class="row my-4">
                        <div class="col">
                            <strong>{{$group->id}}: </strong>
                            <span>{{$group->name}}</span>
                            <br/>
                            <span>{{$group->description}}</span>
                        </div>
                    </div>
                @endforeach
            @endif
            @if($item->projects()->count())
                <div class="row my-4">
                    <div class="col">
                        <strong>Projects ({{$item->projects->count()}}): </strong>
                    </div>
                </div>
                @foreach($item->projects as $project)
                    <div class="row my-4">
                        <div class="col">
                            <strong>{{$project->id}}: </strong>
                            <span>{{$project->name}}</span>
                            <br/>
                            <span>{{$project->description}}</span>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <form id="destroy-form" action="{{route('admin.translations.destroy', $item)}}" method="POST">
        @method('DELETE') @csrf
    </form>
@endsection
