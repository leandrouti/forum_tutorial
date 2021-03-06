@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="level">
                        <h4 class="flex">{{ $thread->title }}</h4>

                        @can('delete', $thread)
                            <form action="{{ $thread->path() }}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        @endcan
                    </div>
                    
                </div>

                <div class="card-body">
                    <article>
                        <div class="body">{{ $thread->body }}</div>
                    </article>     
                </div>
            </div>

             @foreach($replies as $reply)
                <div class="card my-2">
                    <div class="card-header">
                        <div class="level">
                            <div class="flex">
                                <a href="{{ route('profile', $reply->owner->name) }}">{{$reply->owner->name}}</a> said {{ $reply->created_at->diffForHumans() }}
                            </div>
                            <form action="/replies/{{ $reply->id }}/favorite" method="post">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-default"  {{ $reply->isFavorited() ? 'disabled' : '' }}>Favorite {{ $reply->favorites_count }}</button>
                            </form>
                        
                        </div>

                        
                    </div>
                    <div class="card-body">
                        <article>
                            <div class="body">{{ $reply->body }}</div>
                        </article>     
                    </div>
                </div>
            @endforeach
        
            {{ $replies->links() }}

            @if(Auth::check())
                <div class="card my-3">
                    <div class="card-header">Reply:</div>
                    <div class="card-body">
                        <form action="{{ $thread->path() . '/replies' }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <textarea name="body" id="body" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Reply" class="btn btn-success">
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <p>
                        This thread was published {{ $thread->created_at->diffForHumans() }} <br>
                        by {{ $thread->owner->name }} <br>
                        currently have {{ $thread->replies_count }} {{ str_plural('comment', $thread->replies_count) }}.
                    <p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
