@extends('layouts.admin')

@section('content')

    <h1>Create Posts</h1>

     {!! Form::open(['method'=>'POST', 'action'=> 'AdminPostsController@store','files'=>true]) !!}

        <div class="form-group">
          {!! Form::label('title', 'Title:') !!}
          {!! Form::text('title', null, ['class'=>'form-control'])!!}
        </div>
        <div class="form-group">
          {!! Form::label('category_id', 'Category:') !!}
          {!! Form::select('category_id',[''=>'categories'] + $categories , null, ['class'=>'form-control'])!!}
        </div>
        <div class="form-group">
            {!! Form::label('photo_id', 'Photo:') !!}
            {!! Form::file('photo_id',  ['class'=>'form-control'])!!}
        </div>
        <div class="form-group">
          {!! Form::label('body', 'Body:') !!}
          {!! Form::textarea('body', null, ['class'=>'form-control'])!!}
        </div>
        <div class="form-group">
            {!! Form::submit('Create Posts', ['class'=>'btn btn-primary']) !!}
         </div>

     
      {!! Form::close() !!}
 
    <div class="row">
        @include('includes.form_error')
    </div>
 @stop
