@if($errors->any())
    <div class="col-12 alert alert-danger">
        <ol>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ol>
    </div>
@endif