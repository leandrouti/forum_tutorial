<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Channel;
use App\Filters\ThreadFilters;

class ThreadsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }
    
    public function index(Channel $channel = null, ThreadFilters $filters){
        
        if($channel){
            $threads = $channel->threads()->latest();
        }else{
            $threads = Thread::latest();
        }

        $threads = $threads->filter($filters)->get();

        if(request()->wantsJson()){
            return $threads;
        }

        
        return view('threads.index')->with('threads', $threads);
        
    }

    public function show($channel_slug, Thread $thread){
        return view('threads.show', [
            'thread' => $thread,
            'replies' => $thread->replies()->paginate(20)
        ]);
    }

    public function store(Request $request){
        
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'channel_id' => 'required|exists:channels,id'
        ]);

        $thread = Thread::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => auth()->id(),
            'channel_id' => $request->channel_id,
        ]);

        return redirect($thread->path());
    }

    public function create(){
        return view('threads.create');
    }

    public function destroy($channel_slug, Thread $thread)
    {
        $this->authorize('delete', $thread);
        
        $thread->delete();

        if(request()->wantsJson()){
            return response([], 204);
        }

        return redirect('/threads');
        
    }
}
