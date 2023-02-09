@extends('layouts.app')
@section('title','Create Post')

@section('content')
    <div class="container mt-3">
        <h2>Create Post</h2>
    </div>
    @if ($errors->any())
        <div class="col-sm-12 container mt-3"  >
            <div class="alert  alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="container my-5 card p-3 ">

            <div class="mb-3">
                <label for="" class="form-label"> Post Title</label>
                <input type="text" class="form-control" name="name" id="" value="{{old('name')}}">
            </div>
            <label for="" class="form-label">User</label>
            <select class="form-select" name="user_id" aria-label="Default select example" >
                <option selected disabled>Open this select menu</option>
                @foreach ($users as $user)
                <option value="{{$user->id}}">{{$user->name}}</option>
                @endforeach
              </select>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Descreiption</label>
                <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3">
                    {{old('description')}}
                </textarea>
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











