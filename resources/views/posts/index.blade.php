@extends('layouts.app')

@section('title')Index Page @endsection

@section('content')
<a href="{{route('posts.create')}}" class="btn btn-primary mb-3">Create Post</a>

<table class="table text-center">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Title</th>
        <th scope="col">Posted By</th>
        <th scope="col">Created At</th>
        <th scope="col">Actions</th>
      </tr>
    </thead>
    <tbody>
    @foreach($posts as $post)
      <tr>
        <th scope="row">{{ $post['id'] }}</th>
        <td>{{ $post['title'] }}</td>
        <td>{{ $post['posted_by'] }}</td>
        <td>{{ $post['created_at'] }}</td>
        <td>
          <x-button href="{{ route('posts.show',['post' => $post['id']]) }}" class="btn btn-success" title="View" />
          <x-button href="{{ route('posts.edit',['post' => $post['id']]) }}" class="btn btn-secondary" title="Edit" />
          <button type="button" class="btn btn-danger">Delete</button>
        </td>
      </tr>
    @endforeach
    </tbody>
</table>
@endsection