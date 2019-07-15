@extends('admin.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{$item->name}} language</h1>
        <div class="div">
            <a href="{{route('admin.languages.edit', $item)}}" class="btn btn-warning shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit
            </a>
            <button class="btn btn-danger shadow-sm" onclick="document.getElementById('destroy-form').submit()">
                <i class="fas fa-trash fa-sm text-white-50"></i> Delete
            </button>
            <a href="{{route('admin.languages.create')}}" class="btn btn-primary shadow-sm">
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
                    <strong>Code: </strong>
                    <span>{{$item->code}}</span>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col">
                    <strong>Name: </strong>
                    <span>{{$item->name}}</span>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col">
                    <strong>Filled Percentage: </strong>
                    <span class="langPercent">{{$item->getFilledPercentage()}}%</span>
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
        </div>
    </div>

    <form id="destroy-form" action="{{route('admin.languages.destroy', $item)}}" method="POST">
        @method('DELETE') @csrf
    </form>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var percentField = document.getElementsByClassName('langPercent')[0];
            var percent = percentField.innerHTML;
            percent = percent.split('%')[0] / 100;
            percentField.style.color = getColor(percent);
        });

        function getColor(value) {
            var hue = ((value) * 120).toString(10);
            return ["hsl(", hue, ",100%,50%)"].join("");
        }
    </script>
@endsection
