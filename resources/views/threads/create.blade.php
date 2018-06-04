@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create a new Thread</div>

                <div class="card-body">
                    <form action="/threads" method="post">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title">
                    </div>

                    <div class="form-group">
                        <label for="title">Body</label>
                        <textarea class="form-control" name="body"></textarea>
                    </div>

                    <input type="submit" value="Create" class="btn btn-success">

                    </form>
                  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
