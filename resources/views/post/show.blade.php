@extends('layouts.app')
@section('content')


<div class="container">
    <div class="row">


      <div class="card">
        <img class="image-fluid" src="{{url('/storage/images/'.$post->file)}}" alt="Card image cap" height='350', width="250">
        <div class="card-header">
      {{ $post->title }} <div>{{ $post->user->name }}</div> <span>{{ $post->created_at->diffForHumans() }}<span>
        </div>
        <div class="card-body">
          <p class="card-text">  {{ $post->content }} </p>
          <a href="{{ route('post.index') }}" class="btn btn-success">Back</a>
        </div>
      </div>
    </div>

<div class="container p-3 text-center">
    <form action="{{ route('comment.store', $post->id) }}" method="post">
@csrf
<textarea rows="5" cols="50" name="content" class="form-controller"></textarea>
<div><button type="submit" class="btn btn-danger">add</button></div>
    </form>
</div><br>

@foreach ($comments as $comment )

<div class="card">
    <div class="card-header">
  {{ $comment->user->name }} <span>{{ $comment->created_at->diffForHumans() }}<span>
    </div>
    <div class="card-body">
      <p class="card-text">  {{ $comment->content }} </p>
    </div>
  </div>
  @endforeach
</div>
@endsection