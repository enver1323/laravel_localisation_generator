@extends('admin.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Groups list</h1>
        <a href="{{route('admin.groups.create')}}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> New Group
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Groups Filter:</h6>
        </div>
        <div class="card-body">
            <form action="{{route('admin.groups.index')}}" method="GET">
                <div class="row d-flex align-items-center">
                    <div class="col form-group">
                        <label for="searchId">ID</label>
                        <input type="number" class="form-control" id="searchId" placeholder="Enter ID" name="id"
                               value="{{(isset($searchQuery->id) ? $searchQuery->id : '')}}">
                    </div>
                    <div class="col form-group">
                        <label for="searchName">Name</label>
                        <input type="text" class="form-control" id="searchName" placeholder="Enter Name" name="name"
                               value="{{(isset($searchQuery->name) ? $searchQuery->name : '')}}">
                    </div>
                    <div class="col form-group">
                        <label for="searchProjects">Projects</label>
                        <select class="form-control" id="searchProjects" name="projects[]" multiple>
                            @foreach($projects as $project)
                                <option
                                    value="{{$project->id}}" {{isset($searchQuery->projects) && in_array($searchQuery->projects, [$project->id]) ? 'selected' : ''}}>
                                    {{$project->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <button class="btn btn-block btn-success" type="submit">
                            <i class="fas fa-filter"></i>
                            Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Manage Projects:</h6>
        </div>
        <div class="card-body">
            <form action="{{route('admin.projects.attachGroups')}}" method="POST" id="projectForm">
                @csrf
                <div class="row mb-4 d-flex align-items-center">
                    <div class="d-inline-block ml-3 mr-4">
                        <label for="groupProject">
                            Add Groups to Project
                        </label>
                    </div>
                    <div class="d-inline-block mr-4">
                        <select name="project" id="groupProject" class="form-control">
                            <option value="">Choose a project to add to</option>
                            @foreach($projects as $project)
                                <option value="{{$project->id}}">{{$project->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-inline-block mr-4">
                        <input id="selectAllGroups" type="checkbox" onclick="selectAll(this.checked)">
                        <label for="selectAllGroups">Select All</label>
                    </div>
                    <button class="btn btn-primary d-inline-block" type="button" onclick="submitForm()">
                        Add
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Groups:</h6>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-center">
                {{$items->links()}}
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Projects</th>
                        <th>Options</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Projects</th>
                        <th>Options</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td width="1px">
                                <input type="checkbox" value="{{$item->id}}" class="groupId">
                            </td>
                            <td width="1px">{{$item->id}}</td>
                            <td>
                                <a href="{{route('admin.groups.show', $item)}}">{{$item->name}}</a>
                            </td>
                            <td class="langPercent">
                                {!! $item->getShortDescription() !!}
                            </td>
                            <td>
                                @foreach($item->projects as $project)
                                    <a href="{{route('admin.projects.show', $project)}}">{{$project->name}}</a>
                                    {{$loop->last ? '' : ', ' }}
                                @endforeach
                            </td>
                            <td>
                                <a href="{{route('admin.groups.edit', $item)}}">
                                    <button class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </a>
                                <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="document.getElementById('{{$item->id}}-destroy-form').submit()">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                            <form id="{{$item->id}}-destroy-form"
                                  action="{{route('admin.groups.destroy', $item)}}" method="POST">
                                @method('DELETE') @csrf
                            </form>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            {{$items->links()}}
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('js/admin/addGroupsToProject.js')}}" type="text/javascript"></script>
@endsection
