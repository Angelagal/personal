@extends('dashboard.master')

@section('content')

   <h1>{{ $post->title }}</h1>
   <span>{{ $post->posted }}</span>

   <div>
     {{ $post->description }}
   </div>
   <div>
      {{ $post->content }}
   </div>
   <img src="//localhost/larafirststeps/public/uploads/posts/{{ $post->image }}" style="width:250px" alt="{{ $post->title }}"
   {{ $post->image }}
@endsection