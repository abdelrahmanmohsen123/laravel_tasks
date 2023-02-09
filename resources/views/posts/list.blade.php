@extends('layouts.app')
@section('title','All Products')

@section('content')
<?php
use Carbon\Carbon;
?>
    <div class="container my-5">
      <div class="row">
        <div class="col-8 mb-4">
          <h2>All Products</h2>
        </div>
        <div class="col-4">
            <div class="row">
                <div class="col-3">
                    <h3><a href="{{ route('posts.add') }}" class="btn btn-primary">Add Post</a></h3>
                </div>
                <div class="col-4">
                    <h3><a href="{{ route('posts.deleted') }}" class="btn btn-dark">Deleted Post</a></h3>
                </div>
            </div>
        </div>
      </div>
      @if (session('success'))
            <div class="col-sm-12 text-center">
                <div class="alert  alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if (session('fail'))
        <div class="col-sm-12 text-center">
            <div class="alert  alert-danger alert-dismissible fade show" role="alert">
                {{ session('fail') }}
            </div>
        </div>
    @endif
        <table class="table table-striped my-2">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">image</th>
                <th scope="col">Description</th>
                <th scope="col">Created At</th>
                <th scope="col"> Actions</th>
                <th scope="col"> slug</th>
              </tr>
            </thead>
            <tbody>

                @foreach ($posts as $post)
                <tr>
                    <th scope="row">{{ $post->id }}</th>

                    <td>{{ $post->name }}</td>
                    <td>
                        <img src="{{ asset('storage/' . $post->image) }}" width="100px" alt="">
                    </td>
                    <td>{{$post->description}}</td>
                    <td>{{ Carbon::create($post->created_at); }}</td>
                    <td>
                      <a href="{{ route('posts.show',$post->id) }}" class="btn btn-success">Show</a>
                      <a href="{{ route('posts.edit',$post->id) }}" class="btn btn-primary">Edit</a>
                      <!-- Button trigger modal -->
                      <button type="button"  class="btn btn-danger deletebtn" value="{{ $post->id }}" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Delete
                      </button>
                      <a href="" id="showPost" data-toggle="modal" class="btn btn-light" data-target='#practice_modal' data-id="{{ $post->id }}">show modal</a>
                      <td>
                        {{ $post->slug }}
                      </td>
                      {{-- commments --}}
                      <!-- Modal -->
                      {{-- delete post --}}
                      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header text-center">
                              <h5 class="modal-title  from-control text-center" id="exampleModalLabel">Delete Post </h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              Confirm to Delete Data ?
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                              <form action="{{ route('posts.delete') }}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" id="delete_id"  name="delete_post_id">
                                <button type="submit" class="btn btn-danger">Yes Delete</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                      {{-- //show post  --}}
                      <!-- Modal -->
                      <div class="modal fade" id="practice_modal">
                        <div class="modal-dialog">
                           {{-- <form id="companydata"> --}}
                                <div class="modal-content text-center">
                                  {{-- <h1>view Post</h1> --}}
                                  <div class="lead">
                                   <h2 id="title"></h2>
                                  </div>
                                <p id="description"></p>
                                <p id="username"></p>
                                <p id="usermail"></p>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                           {{-- </form> --}}
                        </div>
                    </div>
                    </td>
                </tr>
                @endforeach
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
                <script src="{{ asset('jquery/jquery-3.5.1.js') }}"></script>
                <script>
                  $(document).on('click','.deletebtn',function(){
                    let post_id = $(this).val()
                    // alert(post_id)
                    $('.exampleModal').modal('show')
                    $('#delete_id').val(post_id)
                  })
                  // ajax
                  /// show model view post
                  $(document).ready(function () {

                          $.ajaxSetup({
                              headers: {
                                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                  }
                          });
                          $('body').on('click', '#showPost', function (event) {
                                  event.preventDefault();
                                  var id = $(this).data('id');
                                  console.log(id)
                                    $.get('posts/' + id + '/show', function (data) {
                                      console.log(data)
                                        $('#practice_modal').modal('show');
                                        $('#title').text("title  :" + data.data.name);
                                        $('#description').text("description :" +  data.data.description);
                                        $('#username').text("username : " + data.user.name);
                                        $('#usermail').text("email :" + data.user.email);
                                    })
                                  });
                          })
              </script>
            </tbody>
          </table>
          {{-- paginate --}}
         <div class="container my-5 w-50 m-auto text-center">
            <div class="row" style="float: right">
              {{ $posts->links() }}
            </div>
        </div>
    </div>
@endsection
