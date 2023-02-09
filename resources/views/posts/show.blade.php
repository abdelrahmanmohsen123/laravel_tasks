@extends('layouts.app')
@section('title','show Post')
@section('content')
<?php
use Carbon\Carbon;
?>
    <div class="container mt-3 text-center">
        <h2>Show Post</h2>
    </div>
    <div class="card w-50 text-center m-auto">
        <div class="card-header">
          {{ Carbon::create($post->created_at); }}
        </div>
        <div class="card-body">
          <h5 class="card-title">{{$post->name}}</h5>
          <p class="card-text">{{ $post->description }}</p>
        </div>
      </div>
      <div class="container text-center mt-5">
        <h2>details creator</h2>
      </div>
      <div class="card w-50 text-center   m-auto ">
        <div class="card-header">
            {{$post->User->name}}
        </div>
        <div class="card-body">
          <h5 class="card-title">{{$post->user->email}}</h5>
          <p class="card-text">{{ $post->user->name }}</p>
        </div>
      </div>
 @endsection











