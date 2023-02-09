@extends('layouts.main')
@section('title','Contact us')
    
@section('content')
    <div class="container mt-3">
        <h2>Contact us</h2>
    </div>
    <div class="container my-5 card p-3 ">
            
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label"> User Name</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="eg :ahmed">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Email address</label>
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Message</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <div class="mb-3 text-center  " >
                <button type="submit" class="btn btn-primary p-3 form-control"> Send</button>
            </div>
    </div>
    

 @endsection    











