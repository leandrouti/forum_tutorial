@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Forum Threads</div>

                <div class="card-body">
                    <article>
                        <h4>{{ $thread->title }}</h4>
                        <div class="body">{{ $thread->body }}</div>
                    </article>     
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            
            @foreach($thread->replies as $reply)
                <div class="card">
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
</div>
@endsection
