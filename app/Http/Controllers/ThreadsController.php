<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;

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

    public function show(Thread $thread){
        return view('threads.show', compact('thread'));
    }

    public function store(Request $request){
        $thread = Thread::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => auth()->id(),
        ]);

        return redirect($thread->path());
    }

    public function create(){
        return view('threads.create');
    }
}
