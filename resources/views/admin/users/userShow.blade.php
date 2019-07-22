@extends('admin.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{$item->name}} User</h1>
        <div class="div">
            <a href="{{route('admin.users.edit', $item)}}" class="btn btn-warning shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit
            </a>
            <button class="btn btn-danger shadow-sm" onclick="document.getElementById('destroy-form').submit()">
                <i class="fas fa-trash fa-sm text-white-50"></i> Delete
            </button>
            <a href="{{route('admin.users.create')}}" class="btn btn-primary shadow-sm">
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
                    <strong>Name: </strong>
                    <span>{{$item->name}}</span>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col">
                    <strong>Email: </strong>
                    <span>{{$item->email}}</span>
                </div>
            </div>
        </div>
    </div>

    <form id="destroy-form" action="{{route('admin.users.destroy', $item)}}" method="POST">
        @method('DELETE') @csrf
    </form>
@endsection
