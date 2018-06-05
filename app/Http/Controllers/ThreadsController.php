<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Channel;

class ThreadsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }
    
    public function index(){
        $threads = Thread::latest()->get();
        
        return view('threads.index')->with('threads', $threads);
    }

    public function show($channel_slug, Thread $thread){
        return view('threads.show', compact('thread'));
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
}
