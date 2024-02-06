@extends('layouts.theme')
@section('content')
<div class="row">

    <div class="col-sm">
        <h1>Toman Suppliers</h1>
    </div>
    <div class="col-sm"></div>
</div>
<form method="post" action="{{ route('add_toman_supplier') }}">
    @csrf
    <div class="row ">
        <div class="col">
            <input type="text" name="title" required class="form-control" placeholder="Party Name">
        </div>
        
        <input type="hidden" name="type" value="partykanta" required class="form-control">
        
        <div class="col">
            <input type="submit" value="Add Party" class="btn btn-info">
        </div>
    </div>
</form>

<br>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">List of all Parties</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title/Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Title/Name</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>

                    @foreach($party as $data)
                    <tr>
                        <td>{{$data->id}}</td>
                        <td>{{$data->name}}</td>
                        <td><a class="btn btn-success" href="/SupplierKanta/{{$data->id}}">Khanta</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection