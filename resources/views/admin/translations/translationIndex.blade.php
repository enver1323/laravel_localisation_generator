@extends('admin.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Translations list</h1>
        <a href="{{route('admin.translations.create')}}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> New Translation
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Translations Filter:</h6>
        </div>
        <div class="card-body">
            <form action="{{route('admin.translations.index')}}" method="GET">
                <div class="row d-flex align-items-center">
                    <div class="col form-group">
                        <label for="searchId">ID</label>
                        <input type="number" class="form-control" id="searchId" placeholder="Enter ID" name="id"
                               value="{{(isset($searchQuery->id) ? $searchQuery->id : '')}}">
                    </div>
                    <div class="col form-group">
                        <label for="searchKey">Key</label>
                        <input type="text" class="form-control" id="searchKey" placeholder="Enter Key" name="key"
                               value="{{(isset($searchQuery->key) ? $searchQuery->key : '')}}">
                    </div>
                    <div class="col form-group">
                        <label for="searchLangs">Languages</label>
                        <select class="form-control" id="searchLangs" name="language_ids[]" multiple>
                            @foreach($langs as $lang)
                                <option
                                    value="{{$lang->id}}" {{in_array($searchQuery->languages, $lang->id) ? 'selected' : ''}}>
                                    {{$lang->name}}
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
            <h6 class="m-0 font-weight-bold text-primary">Translations:</h6>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-center">
                {{$items->links()}}
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Key</th>
                        <th>Languages</th>
                        <th>Options</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Key</th>
                        <th>Languages</th>
                        <th>Options</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>
                                <a href="{{route('admin.translations.show', $item)}}">{{$item->key}}</a>
                            </td>
                            <td>
                                @foreach($item->languages as $lang)
                                    <a href="{{route('admin.languages.show', $lang)}}">
                                        {{$lang->name . ($loop->last ? '' : ', ' )}}
                                    </a>
                                @endforeach
                            </td>
                            <td>
                                <a href="{{route('admin.translations.edit', $item)}}">
                                    <button class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </a>
                                <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="document.getElementById('{{$item->id}}-destroy-form').submit()">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                            <form id="{{$item->id}}-destroy-form" action="{{route('admin.translations.destroy', $item)}}" method="POST">
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
