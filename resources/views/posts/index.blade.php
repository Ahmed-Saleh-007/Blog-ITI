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
        <th scope="row">{{ $post->id }}</th>
        <td>{{ $post->title }}</td>
        <td>{{ $post->user->name }}</td>
        <td>{{  $post->created_at->format('Y-m-d') }}</td>
        <td>
          <button type="button" class="btn btn-success show-ajax" data-toggle="modal" data-target="#ajax_view" data-ajax="{{$post->id}}" >AJView</button>
          <x-button href="{{ route('posts.show', ['post' => $post->id]) }}" class="btn btn-success" title="View" />
          <x-button href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-secondary" title="Edit" />
          @if ($post->trashed())
            <form action="{{ route('posts.restore', ['post' => $post['id']]) }}" method="post" class="d-inline-block">
              @csrf
              <input type="submit" class="btn btn-warning" value="Restore"/>
            </form>
          @else
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#del_post_{{$post->id}}" >Delete</button>
          @endif
        </td>
      </tr>
      
      <div id="del_post_{{$post->id}}" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Delete</h4>
              <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <form method="POST" action="{{route('posts.destroy', ['post' => $post['id']])}}" accept-charset="UTF-8">
              @csrf
              @method('DELETE')
              <div class="modal-body">
                <h4>Do you want to delete post with title {{$post->title}} ?</h4>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">No</button>
                <input class="btn btn-danger" type="submit" value="Yes">
              </div>
            </form>
          </div>
        </div>
      </div>
    @endforeach
    </tbody>
</table>

{{$posts->links("pagination::bootstrap-4")}}

<div id="ajax_view" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">view post</h4>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <div class="modal-body" id="ajax_view_content">
        
      </div>
    </div>
  </div>
</div>


@push('js')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script>
    $(document).ready(function () {
      $('.show-ajax').click(function () {
        console.log($(this).data('ajax'));
        $.ajax({
            url: '{{ route('posts.ajax.show') }}',
            type: 'get',
            data: {post: $(this).data('ajax')},
            success: function (data) {
              $('#ajax_view_content').html(`
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Title:</h5>
                  <p class="card-text">${data.title}</p>
                  <h5 class="card-title">Description:</h5>
                  <p class="card-text">${data.description}</p>
                </div>
              </div>
              `);
            }
        });
      });
    });
  </script>
@endpush

@endsection
