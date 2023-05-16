@extends('layouts.app')
@section('content')


    @if (session('msg'))
    <div class="alert alert-danger">
        {{ session('msg') }}
    </div>
    @endif


<div class="container">
    <div class="row">
        <form action="{{ route('post.update', $post->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="exampleFormControlInput1">Title</label>
              <input type="text" name="title" class="form-control" value="{{ $post->title }}">
              <span>@error('title') {{ $message }} @enderror</span>
            </div>

            <div class="form-group">
              <label for="exampleFormControlTextarea1">Content</label>
              <textarea class="form-control" name="content" id="exampleFormControlTextarea1" rows="3">
                  {{ $post->content }}
              </textarea>
              <span>@error('content') {{ $message }} @enderror</span>
            </div>
          </div>
          <label for="exampleFormControlInput1">Image</label>
          <input type="file" name="file" class="form-control" id="exampleFormControlInput1" 
          value="{{url('/storage/images/'.$post->file)}}">
          <span>@error('file') {{ $message }} @enderror</span>
          <img src="{{url('/storage/images/'.$post->file)}}" alt="Card image cap" height="100", width="100">
        </div>

<br>
            <input type="submit" class="btn btn-primary" value="Update">
          </form>

    </div>
</div>


@endsection