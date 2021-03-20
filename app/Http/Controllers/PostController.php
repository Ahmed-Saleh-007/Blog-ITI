<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = [
            ['id' => 1, 'title' => 'laravel', 'description' => 'php framework', 'posted_by' => 'Ahmed', 'created_at' => '2020-01-10'],
            ['id' => 2, 'title' => 'PHP', 'description' => 'scripting lang', 'posted_by' => 'Mohamed', 'created_at' => '2020-01-25'],
            ['id' => 3, 'title' => 'Javascript', 'description' => 'monster', 'posted_by' => 'Mahmoud', 'created_at' => '2020-02-30'],
        ];

        return view('posts.index', compact('posts'));
    }

    public function show($postId)
    {
        $post = ['id' => 1, 'title' => 'laravel', 'description' => 'php framework', 'posted_by' => 'Ahmed', 'created_at' => '2021-03-20'];

        return view('posts.show', compact('post'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store()
    {
        return redirect()->route('posts.index');
    }

    public function edit($postId)
    {
        $post = ['id' => 1, 'title' => 'laravel', 'description' => 'php framework', 'posted_by' => 'Ahmed', 'created_at' => '2021-03-20'];
        return view('posts.edit', compact('post'));
    }

    public function update($postId)
    {
        return redirect()->route('posts.index');
    }
}
