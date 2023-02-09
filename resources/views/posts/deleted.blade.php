@extends('layouts.app')
@section('title','deleted posts')

@section('content')
<?php

use Carbon\Carbon;
?>
    <div class="container my-5">
      <div class="row">
        <div class="col-6">
          <h2>All posts</h2>
        </div>
        {{-- <div class="col-3">
          <h3><a href="{{ route('posts.add') }}" class="btn btn-primary">Add Post</a></h3>
        </div> --}}
        <div class="col-3">
            <h3><a href="{{ route('posts.all') }}" class="btn btn-secondary">All Post</a></h3>
        </div>


      </div>

        <table class="table my-2">
            <thead>
              <tr>
                <th scope="col">#</th>

                <th scope="col">Title</th>
                {{-- <th scope="col">image</th> --}}

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
                    {{-- <td>
                        <img src="{{ asset('storage/' . $post->image) }}" width="100px" alt="">
                    </td> --}}
                    <td>{{$post->description}}</td>
                    <td>{{ Carbon::create($post->created_at); }}</td>
                    <td>
                      {{-- <a href="{{ route('posts.show',$post->id) }}" class="btn btn-success">Show</a>
                      <a href="{{ route('posts.edit',$post->id) }}" class="btn btn-primary">Edit</a> --}}
                      <!-- Button trigger modal -->
                      <a href="{{ route('posts.restore',$post->id) }}" class="btn btn-primary">Restore</a>

                      <button type="button"  class="btn btn-warning deletebtn" value="{{ $post->id }}" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Delete Permenat
                      </button>
                      {{-- <a href="" id="showPost" data-toggle="modal" class="btn btn-light" data-target='#practice_modal' data-id="{{ $post->id }}">show modal</a> --}}
                      {{-- <a href="" id="editCompany" data-toggle="modal" data-target='#practice_modal' data-id="{{ $item->id }}">Edit</a> --}}

                      <td>
                        {{ $post->slug }}
                      </td>
                      {{-- commments --}}
                      <!-- Modal -->
                      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header text-center">
                              <h5 class="modal-title  from-control text-center" id="exampleModalLabel">Delete Post </h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              Confirm to Delete Data Permenatnt ?
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                              <form action="{{ route('posts.forceDelete') }}" method="post">
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
                                {{-- <input type="hidden" id="color_id" name="color_id" value="">
                                <div class="modal-body">
                                    <input type="text" name="name" id="name" value="" class="form-control">
                                </div>

                                <input type="submit" value="Submit" id="submit" class="btn btn-sm btn-outline-danger py-0" style="font-size: 0.8em;"> --}}

                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                            </div>
                           {{-- </form> --}}
                        </div>
                    </div>

{{--  --}}

                      {{-- <form action="{{ route('posts.delete',$post->id) }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-danger">Delete</button>
                      </form> --}}
                      {{-- <a href="" class="btn btn-danger">Delete</a> --}}
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
                  $(document).ready(function () {

                          $.ajaxSetup({
                              headers: {
                                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                  }
                          });

                          // $('body').on('click', '#submit', function (event) {
                          //     event.preventDefault()
                          //     var id = $("#color_id").val();
                          //     var name = $("#name").val();

                          //     $.ajax({
                          //       url: 'color/' + id,
                          //       type: "POST",
                          //       data: {
                          //         id: id,
                          //         name: name,
                          //       },
                          //       dataType: 'json',
                          //       success: function (data) {

                          //           $('#companydata').trigger("reset");
                          //           $('#practice_modal').modal('hide');
                          //           window.location.reload(true);
                          //       }
                          //   });
                          // });

                          $('body').on('click', '#showPost', function (event) {

                                  event.preventDefault();
                                  var id = $(this).data('id');
                                  console.log(id)
                                    $.get('posts/' + id + '/show', function (data) {
                                      console.log(data)

                                        // $('#userCrudModal').html("Edit category");
                                        // $('#submit').val("Edit category");
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
          <div class="row">
            {{ $posts->links() }}
          </div>
      </div>
    </div>


@endsection
