<div class="card">
    <div class="card-body">
      <h5 class="card-title">Title:</h5>
      <p class="card-text">{{$post->title}}</p>
      <h5 class="card-title">Description:</h5>
      <p class="card-text">{{$post->description}}</p>
      <h5 class="card-title">Posted by:</h5>
      <p class="card-text">{{ $post->user->name }}</p>
      <p class="card-text">{{ $post->user->email }}</p>
      <h5 class="card-title">Created at:</h5>
      <p class="card-text">{{ $post->created_at}}</p>
    </div>
 </div>