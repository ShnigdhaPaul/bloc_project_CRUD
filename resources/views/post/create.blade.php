@extends('layouts.app')
@section('content')


    @if (session('msg'))
    <div class="alert alert-danger">
        {{ session('msg') }}
    </div>
    @endif


<div class="container">
    <div class="row">
        <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <label for="exampleFormControlInput1">Title</label>
              <input type="text" name="title" class="form-control" id="exampleFormControlInput1">
              <span>@error('title') {{ $message }} @enderror</span>
            </div>

            <div class="form-group">
              <label for="exampleFormControlTextarea1">Content</label>
              <textarea class="form-control" name="content" id="exampleFormControlTextarea1" rows="3"></textarea>
              <span>@error('content') {{ $message }} @enderror</span>..
            </div>
            <label for="exampleFormControlInput1">Image</label>
            <input type="file" name="file" class="form-control" id="exampleFormControlInput1">
            <span>@error('file') {{ $message }} @enderror</span>
          </div>
<br>
            <input type="submit" class="btn btn-primary" value="Post">
          </form>

    </div>
</div>


@endsection