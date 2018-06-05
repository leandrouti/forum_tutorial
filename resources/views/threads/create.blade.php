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
                        <input type="text" class="form-control" name="title" value="{{old('title')}}" required>
                    </div>

                    <div class="form-group">
                        <label for="channel">Channel</label>
                        <select name="channel_id" id="" class="form-control">
                            @foreach(App\Channel::all() as $channel)
                                <option value="{{ $channel->id }}" 
                                    @if(old('channel_id') == $channel->id)
                                        selected="selected"
                                    @endif
                                >{{ $channel->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="body">Body</label>
                        <textarea class="form-control" name="body" required>{{old('body')}}</textarea>
                    </div>

                    <input type="submit" value="Create" class="btn btn-success">

                    </form>
                    @if(count($errors))
                        <hr>
                        <ul class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
