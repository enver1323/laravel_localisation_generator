@extends('admin.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Translations list</h1>
        <a href="{{route('admin.translations.create')}}" class="d-none d-sm-inline-block btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> New Translation
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Translations:</h6>
        </div>
        <div class="card-body">
            <form action="{{route('admin.translations.index')}}" method="GET">
                <div class="row">
                    <div class="col form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                    </div>
                    <div class="col">
                    </div>
                    <div class="col"></div>
                    <div class="col form-group">
                        <label for="transLangs">Languages</label>
                        <select class="form-control" id="transLangs" multiple>
                            @foreach($langs as $lang)
                                <option value="{{$lang->id}}" {{in_array($search->laguages, $lang->id) ? 'selected' : ''}}>
                                    {{$lang->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <button class="btn btn-success" type="submit">Filter</button>
                    </div>
                </div>
            </form>
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
                                <a href="{{route('admin.translations.edit')}}">
                                    <button class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </a>
                                <a href="{{route('admin.translations.destroy', $item)}}">
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </a>
                            </td>
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
