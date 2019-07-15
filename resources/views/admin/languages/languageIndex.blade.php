@extends('admin.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Languages list</h1>
        <a href="{{route('admin.languages.create')}}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> New Language
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Languages Filter:</h6>
        </div>
        <div class="card-body">
            <form action="{{route('admin.languages.index')}}" method="GET">
                <div class="row d-flex align-items-center">
                    <div class="col form-group">
                        <label for="searchCode">Code</label>
                        <input type="text" maxlength="2" class="form-control" id="searchCode" placeholder="Enter Code" name="code"
                               value="{{(isset($searchQuery->code) ? $searchQuery->code : '')}}">
                    </div>
                    <div class="col form-group">
                        <label for="searchName">Name</label>
                        <input type="text" class="form-control" id="searchName" placeholder="Enter Name" name="name"
                               value="{{(isset($searchQuery->name) ? $searchQuery->name : '')}}">
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
            <h6 class="m-0 font-weight-bold text-primary">Languages:</h6>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-center">
                {{$items->links()}}
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Percentage</th>
                        <th>Options</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Percentage</th>
                        <th>Options</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>{{$item->code}}</td>
                            <td>
                                <a href="{{route('admin.languages.show', $item)}}">{{$item->name}}</a>
                            </td>
                            <td class="langPercent">
                                {{$item->getFilledPercentage()}} %
                            </td>
                            <td>
                                <a href="{{route('admin.languages.edit', $item)}}">
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
                                  action="{{route('admin.languages.destroy', $item)}}" method="POST">
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
    <script type="text/javascript">
        $(document).ready(function () {
            var percentFields = document.getElementsByClassName('langPercent');
            for (var i = 0; i < percentFields.length; i++) {
                var percent = percentFields[i].innerHTML;
                percent = percent.split('%')[0] / 100;
                percentFields[i].style.color = getColor(percent);
            }
        });

        function getColor(value) {
            var hue = ((value) * 120).toString(10);
            return ["hsl(", hue, ",100%,50%)"].join("");
        }
    </script>
@endsection
