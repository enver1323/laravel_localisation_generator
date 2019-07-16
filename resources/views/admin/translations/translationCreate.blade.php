@extends('admin.app')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">New Translation</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"></h6>
        </div>
        <div class="card-body">
            <form action="{{route('admin.translations.store')}}" method="POST" id="transForm">
                <div class="row mb-4" id="transKeyRow">
                    <div class="col-md-3 col-lg-2">
                        <label for="transKey">Translation key</label>
                    </div>
                    <div class="col-md-9 col-lg-10">
                        <input type="text" class="form-control col-md-8 col-lg-6" id="transKey" name="key" required>
                    </div>
                </div>

                <div class="row mb-4 d-none" id="entriesHeader">
                    <div class="col-md-3 col-lg-2">
                        <strong>Entries:</strong>
                    </div>
                    <div class="col-md-9 col-lg-10"></div>
                </div>

                <div class="row mb-4" id="selectContainer">
                    <div class="col-md-3 col-lg-2">
                        <label for="transLangs">Choose language to add entry</label>
                    </div>
                    <div class="col-md-9 col-lg-10">
                        <select id="transLangs" class="form-control col-md-6 col-lg-4 d-inline-block">
                            @foreach($langs as $lang)
                                <option value="{{$lang->code}}" {{$loop->first ? 'selected' : ''}}>{{$lang->name}}</option>
                            @endforeach
                        </select>
                        <div class="col-md-1 d-inline-block"></div>
                        <button type="button" class="btn btn-primary col-md-1 d-inline-block" onclick="addEntry()">
                            Add entry
                        </button>
                    </div>
                </div>
                <input type="submit" class="btn btn-success" value="Save">
                @csrf
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('js/admin/addTranslationEntries.js')}}"></script>
@endsection
