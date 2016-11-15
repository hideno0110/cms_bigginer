@extends('layouts.admin')

@section('content')

  <h1>posts index</h1>

    <table class="table">
       <thead>
         <tr>
             <th>Id</th>
             <th>user</th>
             <th>category</th>
             <th>photo</th>
             <th>title</th>
             <th>body</th>
             <th>Created</th>
             <th>Updated</th>
          </tr>
        </thead>
        <tbody>

        @if($posts)
          @foreach($posts as $post)
             <tr>
                <td>{{$post->id}}</td>
                <td><a href="{{route('posts.edit', $post->id)}}">{{$post->user->name}}</a></td> 
                <td>{{$post->category? $post->category->name : 'uncagorized'}}</td>
                <td><img height="100px" src="{{$post->photo ? $post->photo->file : 'http://placehold.it/400x400' }}"</td>
                <td>{{$post->title}}</td>
                <td>{{$post->body}}</td>
                <td>{{$post->created_at->diffForHumans()}}</td>
                <td>{{$post->updated_at->diffForHumans()}}</td>
             </tr>
          @endforeach
        @endif

       </tbody>
     </table>
@endsection
