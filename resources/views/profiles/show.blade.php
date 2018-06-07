@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="page-header">
            <h4>
                {{ $profileUser->name }}
                <small>Since {{$profileUser->created_at->diffForHumans() }}</small>
            </h4>
        </div>

        @foreach($threads as $thread)
            <div class="card my-2">
                <div class="card-header">
                    
                    <div class="level">
                        <div class="flex">{{ $thread->title }}</div>
                        {{ $thread->created_at->diffForHumans() }}
                    </div>
                    
                </div>
                <div class="card-body">
                    <article>
                        <div class="body">{{ $thread->body }}</div>
                    </article> 
                </div>    
            </div>

        @endforeach

        {{ $threads->links() }}
    
    </div>
    

@endsection