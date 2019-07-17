@extends('admin.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit "{{$item->name}}" group</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"></h6>
        </div>
        <div class="card-body">
            <form action="{{route('admin.groups.update', $item)}}" method="POST">
                @method('PATCH')
                <div class="row mb-4">
                    <div class="col-md-3 col-lg-2">
                        <label for="groupName">Group name</label>
                    </div>
                    <div class="col-md-9 col-lg-10">
                        <input type="text" class="form-control col-md-8 col-lg-6" id="groupName"
                               name="name" value="{{$item->name}}" required>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-3 col-lg-2">
                        <label for="groupDesc">Group Description</label>
                    </div>
                    <div class="col-md-9 col-lg-10">
                        <textarea class="form-control col-md-8 col-lg-6" id="groupDesc" name="description" required>
                            {!! $item->description !!}
                        </textarea>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3 col-lg-2">
                        <label for="searchField">Choose translations to add</label>
                    </div>
                    <div class="col-md-9 col-lg-10">
                        <div class="col-md-8 col-lg-6 p-0" id="translationsContainer">
                            <input id="searchField" type="text" class="form-control mb-4"
                                   onkeyup="getTranslationKeys(this.value)">
                            @foreach($item->translations as $translation)
                                <div class="form-check">
                                    <input class="form-check-input translationCheckbox" id="trans-{{$translation->id}}"
                                           onclick="removeItem(this)" name="translations[]" value="{{$translation->id}}"
                                           type="checkbox" checked>
                                    <label for="trans-{{$translation->id}}">Translation: {{$translation->key}}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <input type="submit" class="btn btn-success" value="Update">
                @csrf
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('js/admin/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('js/admin/addTranslations.js')}}"></script>
@endsection
