@extends('layouts.app')
@section('title','Create Post')

@section('content')
    <div class="container mt-3">
        <h2>Edit Post</h2>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <form action="{{ route('posts.update',$post->id) }}" method="post" enctype="multipart/form-data">
        @method('put')
        @csrf
        <div class="container my-5 card p-3 ">

            <div class="mb-3">
                <label for="" class="form-label"> Post Title</label>
                <input type="text" class="form-control" name="name" id=""  value="{{ $post->name }}" >
            </div>

            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Descreiption</label>
                <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3">
                    {{$post->description}}
                </textarea>
            </div>
            <label for="" class="form-label">User</label>

            <select class="mb-3 form-select" name="user_id" aria-label="Default select example">
                <option  disabled>Open this select menu</option>
                @foreach ($users as $user)
                <option value="{{$user->id}}" @if ($user->id ==$post->user_id)
                    {{'selected'}}
                @endif>{{$user->name}}</option>
                @endforeach
              </select>
              <div class="mb-3">
                <img src="{{ asset('storage/' . $post->image) }}" width="400px" alt="">
              </div>
              <div class="mb-3 col-md-6">
                <label for="formFile" class="form-label">upload image</label>
                <input class="form-control" type="file" name="image" id="formFile">
              </div>
            <div class="mb-3 text-center  " >
                <button type="submit" class="btn btn-primary p-3 form-control"> Send</button>
            </div>
    </div>
    </form>



 @endsection











