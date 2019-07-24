@extends('admin.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Translation {{$item->key}}</h1>
    </div>
    <form action="{{route('admin.translations.update', $item)}}" method="POST">
        @method('PATCH')

        <div class="row">
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Entries:
                        </h6>
                    </div>
                    <div class="card-body" id="transForm">
                        <div class="row mb-4">
                            <div class="col-md-4 col-lg-3">
                                <label for="transKey">Translation key</label>
                            </div>
                            <div class="col-md-8 col-lg-9">
                                <input type="text" class="form-control" id="transKey" name="key"
                                       value="{{$item->key}}" required>
                            </div>
                        </div>

                        <div class="row mb-4 {{$item->has('entries') ? '' : 'd-none'}}" id="entriesHeader">
                            <div class="col-md-4 col-lg-3">
                                <strong>Entries:</strong>
                            </div>
                            <div class="col-md-8 col-lg-9"></div>
                        </div>

                        @foreach($item->entries as $entry)
                            <div class="row mb-4">
                                <div class="col-md-4 col-lg-3">
                                    <label for="transEntry{{$entry->language->name}}">{{$entry->language->name}}
                                        language
                                        entry</label></div>
                                <div class="col-md-8 col-lg-9">
                                    <input class="form-control entryInput"
                                           id="transEntry{{$entry->language->name}}" type="text" required
                                           name="entries[{{$entry->language->code}}]" value="{{$entry->entry}}">
                                </div>
                            </div>
                        @endforeach

                        <div class="row mb-4" id="selectContainer">
                            <div class="col-md-4 col-lg-3">
                                <label for="transLangs">Choose language to add entry</label>
                            </div>
                            <div class="col-md-8 col-lg-9 row pl-4">
                                <select id="transLangs" class="form-control col-lg-9 d-inline-block mb-2">
                                    @foreach($langs as $lang)
                                        @unless($item->languages->contains($lang))
                                            <option value="{{$lang->code}}" {{$loop->first ? 'selected' : ''}}>
                                                {{$lang->name}}
                                            </option>
                                        @endunless
                                    @endforeach
                                </select>
                                <div class="col-lg-3 d-inline-block">
                                    <button type="button" class="btn btn-primary btn-block" onclick="addEntry()">
                                        Add entry
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Groups:
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col">
                                <span>Choose groups for translations:</span>
                            </div>
                        </div>

                        <div class="row mb-4">
                            @foreach($groups as $group)
                                <div class="col-md-4 col-lg-3">
                                    <strong>Group {{$group->id}}:</strong>
                                </div>
                                <div class="col-md-8 col-lg-9">
                                    <input type="checkbox" id="transGroup{{$group->id}}" name="groups[]"
                                           value="{{$group->id}}" {{$item->groups->contains($group) ? 'checked' : ''}}>
                                    <label class="ml-1" for="transGroup{{$group->id}}"> {{$group->name}}</label>
                                </div>
                            @endforeach
                        </div>

                        <input type="submit" class="btn btn-success btn-block" value="Update">
                        @csrf
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('scripts')
    <script src="{{asset('js/admin/addTranslationEntries.js')}}"></script>
@endsection
