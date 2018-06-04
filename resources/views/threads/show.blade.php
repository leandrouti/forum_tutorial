@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center my-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h4>{{ $thread->title }}</h4></div>

                <div class="card-body">
                    <article>
                        <div class="body">{{ $thread->body }}</div>
                    </article>     
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            
            @foreach($thread->replies as $reply)
                <div class="card my-2">
                    <div class="card-header">{{$reply->owner->name}} said {{ $reply->created_at->diffForHumans() }}</div>
                    <div class="card-body">
                        <article>
                            <div class="body">{{ $reply->body }}</div>
                        </article>     
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @if(Auth::check())
        <div class="row justify-content-center my-4">
            <div class="col-md-8">
                <div class="card">
                <div class="card-header">Reply:</div>
                    <div class="card-body">
                        <form action="{{ $thread->path() . '/replies' }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <textarea name="body" id="body" class="form-control">
                                </textarea>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Reply" class="btn btn-success">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
