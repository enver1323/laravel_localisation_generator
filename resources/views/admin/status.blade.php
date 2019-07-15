@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show">
        <ul>
            @foreach ($errors->all() as $error)
                <strong>Error!</strong> {{$error}}
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
@endif
@if(session()->get('status'))
    @php $status = session()->get('status') @endphp
    <div class="alert alert-{{$status->type}} alert-dismissible fade show">
        <strong>{{ucfirst($status->type)}}!</strong> {{$status->message}}.
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
@endif
