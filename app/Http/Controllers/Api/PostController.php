<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;

class PostController extends Controller{

    public function index() {
        $posts = Post::all();
        return PostResource::collection($posts);
    }

    public function show(Post $post){
        return new PostResource($post);
    }

    public function store(PostRequest $request){
        $post = Post::create($request->all());
        return new PostResource($post);
    }

}
