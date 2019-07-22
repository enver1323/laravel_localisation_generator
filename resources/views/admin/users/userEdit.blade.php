@extends('admin.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit {{$item->name}} user</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"></h6>
        </div>
        <div class="card-body">
            <form action="{{route('admin.users.update', $item)}}" method="POST">
                @method('PATCH')
                <div class="row mb-4">
                    <div class="col-md-3 col-lg-2">
                        <label for="userName">User Name</label>
                    </div>
                    <div class="col-md-9 col-lg-10">
                        <input type="text" class="form-control col-md-8 col-lg-6" id="userName" name="name" required
                               value="{{$item->name}}">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-3 col-lg-2">
                        <label for="userEmail">User Email</label>
                    </div>
                    <div class="col-md-9 col-lg-10">
                        <input type="email" class="form-control col-md-8 col-lg-6" id="userEmail" name="email" required
                               value="{{$item->email}}">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-3 col-lg-2">
                        <label for="userPass">User Password</label>
                    </div>
                    <div class="col-md-9 col-lg-10">
                        <input type="password" class="form-control col-md-8 col-lg-6" id="userPass" name="password">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-3 col-lg-2">
                        <label for="userPassConfirm">Password Confirmation</label>
                    </div>
                    <div class="col-md-9 col-lg-10">
                        <input type="password" class="form-control col-md-8 col-lg-6" id="userPassConfirm"
                               name="password_confirmation">
                    </div>
                </div>
                <input type="submit" class="btn btn-success" value="Update">
                @csrf
            </form>
        </div>
    </div>
@endsection
