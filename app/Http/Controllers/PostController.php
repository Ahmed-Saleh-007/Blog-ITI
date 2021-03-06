<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::withTrashed()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function ajaxShow(Request $request)
    {
        $post = Post::withTrashed()->where("id", $request->post)->first();
        return view('posts.ajax_show', compact('post'));
    }

    public function create()
    {
        $users = User::all();
        return view('posts.create', compact('users'));
    }

    public function store(PostRequest $request)
    {
        $data = $request->all();
        if($request->image){
            $data['image'] = savePhoto('image', 'posts', $request);
        }
        Post::create($data);
        return redirect()->route('posts.index');
    }

    public function edit(Post $post)
    {
        $users = User::all();
        return view('posts.edit', compact('post', 'users'));
    }

    public function update(PostRequest $request, Post $post)
    {
        $data = $request->all();
        if($request->file('image'))
        {
            $data['image']  = savePhoto('image','posts',$request);   //new image
            Storage::delete($post->image);                //delete the old image
        }
        $post->update($data);
        return redirect()->route('posts.index');
    }

    public function destroy(Post $post)
    {
        $post->delete();    //for force delete "hard or permenant delete" $post->forceDelete();
		return redirect()->route('posts.index');
    }

    public function restore($post)
    {
        Post::onlyTrashed()->find($post)->restore();
        return redirect()->route('posts.index');
    }

}
