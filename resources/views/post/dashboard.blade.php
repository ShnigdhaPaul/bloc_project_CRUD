@extends('layouts.app')
@section('content')


@if (session('msg'))
<div class="alert alert-success">
    {{ session('msg') }}
</div>
@endif

<div class="container">
  <table class="table">
    <thead class="thead-light">
      <tr>
        <th scope="col">id</th>
        <th scope="col">title</th>
        <th scope="col">edit</th>
        <th scope="col">delete</th>
      </tr>
    </thead>
    <tbody>

@foreach ($myPosts as $post)
      <tr>
        <th scope="row">{{ $post->id }}</th>
        <td>{{ $post->title }}</td>
        <th scope="row">
            <a href="{{ route('post.edit', $post->id) }}" class="btn btn-success">Edit</a>
        </th>
        <td>
       <form action="{{ route('post.destroy', $post) }}" method="post">
           @csrf
           @method('DELETE')
           <button type="submit" class="btn btn-danger" onClick="return confirm('Are you sure')">Delete </button>

       </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <div>{{ $myPosts->links() }}</div>
</div>

@endsection
