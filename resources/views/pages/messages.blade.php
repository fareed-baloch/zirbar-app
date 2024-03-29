@if(count($errors) > 0)
    @foreach($errors->all() as $error)
        <div class="alert alert-danger">
            {{$error}}
        </div>
    @endforeach
    
@endif

@if(session('success'))
<div class="alert alert-success">
            {{session('success')}}
        </div>

@endif

@if(session('danger'))
<div class="alert alert-danger">
            {{session('danger')}}
        </div>

@endif

@if(session('info'))
<div class="alert alert-info">
            {{session('info')}}
        </div>

@endif