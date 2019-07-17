@if($errors->any())
    @foreach($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>Error!</strong> {{$error}}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endforeach
@endif
@if(session()->get('status'))
    @foreach(session()->get('status') as $status)
        <div class="alert alert-{{$status->type}} alert-dismissible fade show">
            <strong>{{ucfirst($status->type)}}!</strong> {{$status->message}}.
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endforeach
@endif
